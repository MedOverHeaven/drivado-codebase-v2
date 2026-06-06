<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vehicle;
use App\Models\Agency;

class DatabaseLogicTest extends TestCase
{
    use RefreshDatabase;

    public function test_vehicle_belongs_to_agency(): void
    {
           $agency = Agency::create([
    'agency_name' => 'Test Agency',
    'city' => 'Oujda',
    'address' => '123 Rue Test',
    'phone' => '0600000000',
    'email' => 'test@agency.com',
    'legal_id' => 'RC123456',
    'user_id' => 1,
]);

        $vehicle = Vehicle::create([
            'agency_id' => $agency->id,
            'make' => 'Dacia',
            'model' => 'Logan',
            'year' => 2023,
            'category' => 'sedan',
            'price_per_day' => 250,
            'is_available' => true,
        ]);

        $this->assertEquals($agency->id, $vehicle->agency->id);
    }
}