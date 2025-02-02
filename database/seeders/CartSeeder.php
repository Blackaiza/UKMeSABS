<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 600; $i++) {
            DB::table('carts')->insert([
                'user_id' => $faker->numberBetween(11, 25),
                'date' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'time_id' => $faker->numberBetween(1, 14),
                'facility_id' => $faker->numberBetween(1, 5),
                'seat_id' => $faker->numberBetween(1, 25),
                'price' => $faker->randomFloat(2, 1, 99),  // Double-digit decimal price
                'booking_id_succesful' => strtoupper($faker->lexify('??????') . $faker->numerify('###')), // Random mix of letters and numbers
                'created_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                'updated_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
