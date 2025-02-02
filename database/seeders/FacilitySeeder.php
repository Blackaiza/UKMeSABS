<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            ['name' => 'Gaming PC'],
            ['name' => 'PlayStation 5'],
            ['name' => 'Snooker A'],
            ['name' => 'Snooker B'],
            ['name' => 'Racing Simulator'],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}
