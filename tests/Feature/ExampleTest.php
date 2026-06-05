<?php

namespace Tests\Feature;

use App\Models\Agency;
use App\Models\Booking;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_booking_confirmation_recalculates_server_side_totals(): void
    {
        $user = User::create([
            'name' => 'Client',
            'email' => 'client@example.com',
            'phone' => '0600000000',
            'password' => 'password',
            'role' => 'user',
        ]);

        $agencyUser = User::create([
            'name' => 'Agency Owner',
            'email' => 'agency@example.com',
            'phone' => '0611111111',
            'password' => 'password',
            'role' => 'agency',
        ]);

        $agency = Agency::create([
            'user_id' => $agencyUser->id,
            'agency_name' => 'Secure Rentals',
            'legal_id' => 'ICE123',
            'address' => 'Oujda',
            'city' => 'Oujda',
            'phone' => '0611111111',
            'status' => 'approved',
        ]);

        $vehicle = Vehicle::create([
            'agency_id' => $agency->id,
            'make' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2024,
            'category' => 'sedan',
            'description' => 'Reliable sedan',
            'price_per_day' => 100,
            'options' => [],
            'is_available' => true,
        ]);

        $startDate = now()->addDay()->toDateString();
        $endDate = now()->addDays(3)->toDateString();

        $this->actingAs($user)->post(route('booking.confirm'), [
            'vehicle_id' => $vehicle->id,
            'agency_id' => 999,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'days' => 99,
            'subtotal' => 1,
            'commission_rate' => 0,
            'commission_amount' => 0,
            'total' => 1,
        ])->assertRedirect();

        $booking = Booking::firstOrFail();

        $this->assertSame($agency->id, $booking->agency_id);
        $this->assertSame(2, $booking->total_days);
        $this->assertEquals(200, $booking->subtotal);
        $this->assertEquals(20, $booking->commission_amount);
        $this->assertEquals(220, $booking->total_amount);
    }

    public function test_users_cannot_view_another_users_booking_success_page(): void
    {
        $owner = User::create([
            'name' => 'Owner',
            'email' => 'owner@example.com',
            'phone' => '0600000001',
            'password' => 'password',
            'role' => 'user',
        ]);

        $otherUser = User::create([
            'name' => 'Other',
            'email' => 'other@example.com',
            'phone' => '0600000002',
            'password' => 'password',
            'role' => 'user',
        ]);

        $agencyUser = User::create([
            'name' => 'Agency Owner',
            'email' => 'agency-owner@example.com',
            'phone' => '0611111112',
            'password' => 'password',
            'role' => 'agency',
        ]);

        $agency = Agency::create([
            'user_id' => $agencyUser->id,
            'agency_name' => 'Private Rentals',
            'legal_id' => 'ICE456',
            'address' => 'Oujda',
            'city' => 'Oujda',
            'phone' => '0611111112',
            'status' => 'approved',
        ]);

        $vehicle = Vehicle::create([
            'agency_id' => $agency->id,
            'make' => 'Dacia',
            'model' => 'Logan',
            'year' => 2023,
            'category' => 'city',
            'description' => 'City car',
            'price_per_day' => 80,
            'options' => [],
            'is_available' => true,
        ]);

        $booking = Booking::create([
            'user_id' => $owner->id,
            'vehicle_id' => $vehicle->id,
            'agency_id' => $agency->id,
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'total_days' => 1,
            'subtotal' => 80,
            'commission_rate' => 10,
            'commission_amount' => 8,
            'total_amount' => 88,
            'status' => 'confirmed',
        ]);

        $this->actingAs($otherUser)
            ->get(route('booking.success', $booking))
            ->assertForbidden();
    }
}
