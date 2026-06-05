<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agency;
use App\Models\User;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agency1 = User::where('email', 'agency1@example.com')->first();
        $agency2 = User::where('email', 'agency2@example.com')->first();

        Agency::create([
            'user_id' => $agency1->id,
            'agency_name' => 'Oujda Rent Agency',
            'legal_id' => 'ICE-123456789',
            'address' => 'Boulevard Mohammed V, Oujda',
            'city' => 'Oujda',
            'latitude' => 34.6867,
            'longitude' => -1.9114,
            'phone' => '0536000001',
            'status' => 'approved',
        ]);

        Agency::create([
            'user_id' => $agency2->id,
            'agency_name' => 'Berkane Auto',
            'legal_id' => 'ICE-987654321',
            'address' => 'Route d\'Ahfir, Berkane',
            'city' => 'Berkane',
            'latitude' => 34.9200,
            'longitude' => -2.3200,
            'phone' => '0536000002',
            'status' => 'approved',
        ]);
    }
}
