<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add 10 seats for facility_id 1
        for ($i = 1; $i <= 15; $i++) {
            DB::table('seats')->insert([
                'facility_id' => 1,  // Assuming facility_id 1 is for a specific facility (e.g., Gaming PC, etc.)
                'seat_number' => 'Seat ' . $i,  // Seat 1, Seat 2, etc.
                'status' => 'available',  // Default status
                'price' => 3,  // Example price for each seat
            ]);
        }

        // You can add more seats for other facilities by repeating the logic with different facility_ids
        for ($i = 1; $i <= 5; $i++) {
            DB::table('seats')->insert([
                'facility_id' => 2,  // Assuming facility_id 2 for another facility (e.g., PlayStation 5)
                'seat_number' => 'Seat ' . $i,  // Seat 1, Seat 2, etc.
                'status' => 'available',  // Default status
                'price' => 7,  // Example price
            ]);
        }

        for ($i = 1; $i <= 1; $i++) {
            DB::table('seats')->insert([
                'facility_id' => 3,  // Assuming facility_id 2 for another facility (e.g., PlayStation 5)
                'seat_number' => 'Seat ' . $i,  // Seat 1, Seat 2, etc.
                'status' => 'available',  // Default status
                'price' => 4,  // Example price
            ]);
        }

        for ($i = 1; $i <= 1; $i++) {
            DB::table('seats')->insert([
                'facility_id' => 4,  // Assuming facility_id 2 for another facility (e.g., PlayStation 5)
                'seat_number' => 'Seat ' . $i,  // Seat 1, Seat 2, etc.
                'status' => 'available',  // Default status
                'price' => 4,  // Example price
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {
            DB::table('seats')->insert([
                'facility_id' => 5,  // Assuming facility_id 2 for another facility (e.g., PlayStation 5)
                'seat_number' => 'Seat ' . $i,  // Seat 1, Seat 2, etc.
                'status' => 'available',  // Default status
                'price' => 5,  // Example price
            ]);
        }
    }
}
