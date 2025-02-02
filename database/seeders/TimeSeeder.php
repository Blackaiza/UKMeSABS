<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Time;

class TimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $times = [
                ['timerange' => '9AM - 10AM'],
                ['timerange' => '10AM - 11AM'],
                ['timerange' => '11AM - 12PM'],
                ['timerange' => '12PM - 1PM'],
                ['timerange' => '1PM - 2PM'],
                ['timerange' => '2PM - 3PM'],
                ['timerange' => '3PM - 4PM'],
                ['timerange' => '4PM - 5PM'],
                ['timerange' => '5PM - 6PM'],
                ['timerange' => '6PM - 7PM'],
                ['timerange' => '7PM - 8PM'],
                ['timerange' => '8PM - 9PM'],
                ['timerange' => '9PM - 10PM'],
                ['timerange' => '10PM - 11PM'],
            ];

            foreach ($times as $time) {
                Time::create($time);
            }
        }
    }
}
