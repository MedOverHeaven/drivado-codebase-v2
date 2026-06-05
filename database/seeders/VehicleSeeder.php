<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\Agency;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agency1 = Agency::where('agency_name', 'Oujda Rent Agency')->first();
        $agency2 = Agency::where('agency_name', 'Berkane Auto')->first();

        // Oujda Vehicles
        Vehicle::create([
            'agency_id' => $agency1->id,
            'make' => 'Dacia',
            'model' => 'Logan',
            'year' => 2023,
            'category' => 'sedan',
            'fuel_type' => 'Essence',
            'seats' => 5,
            'transmission' => 'Manuelle',
            'description' => 'A comfortable and economical car for city travel.',
            'price_per_day' => 250.00,
            'price_per_week' => 1500.00,
            'options' => ['AC', 'Bluetooth', 'Manual'],
            'cancellation_policy' => 'Free cancellation up to 24 hours before pickup.',
            'is_available' => true,
        ]);

        Vehicle::create([
            'agency_id' => $agency1->id,
            'make' => 'Hyundai',
            'model' => 'Tucson',
            'year' => 2024,
            'category' => 'suv',
            'fuel_type' => 'Essence',
            'seats' => 5,
            'transmission' => 'Automatique',
            'description' => 'Powerful SUV perfect for long trips and families.',
            'price_per_day' => 600.00,
            'price_per_week' => 3800.00,
            'options' => ['AC', 'GPS', 'Automatic', 'Sunroof'],
            'cancellation_policy' => 'Full refund 48h before.',
            'is_available' => true,
        ]);

        // Berkane Vehicles
        Vehicle::create([
            'agency_id' => $agency2->id,
            'make' => 'Renault',
            'model' => 'Clio 5',
            'year' => 2023,
            'category' => 'city',
            'fuel_type' => 'Essence',
            'seats' => 5,
            'transmission' => 'Manuelle',
            'description' => 'Compact and stylish city car.',
            'price_per_day' => 300.00,
            'price_per_week' => 1800.00,
            'options' => ['AC', 'Touchscreen', 'Manual'],
            'cancellation_policy' => 'No refund if cancelled less than 12h before.',
            'is_available' => true,
        ]);
    }
}
