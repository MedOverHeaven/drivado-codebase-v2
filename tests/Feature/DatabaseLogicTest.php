<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vehicle;
use App\Models\Agency;
use App\Models\User;

class DatabaseLogicTest extends TestCase
{
    use RefreshDatabase;

    public function test_vehicle_belongs_to_agency(): void
    {
        $agency = Agency::factory()->create();
        $vehicle = Vehicle::factory()->create(['agency_id' => $agency->id]);
        
        $this->assertEquals($agency->id, $vehicle->agency->id);
    }
}