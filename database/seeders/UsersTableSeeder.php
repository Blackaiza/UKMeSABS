<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('ms_MY'); // Use Malaysian locale for more realistic names

        // Realistic admin names
        $adminNames = ['Aiman', 'Amira', 'Hazim', 'Syafiq', 'Nurul', 'Farah', 'Zulhilmi', 'Fatin', 'Hafiz', 'Siti'];
        $admins = [];

        foreach ($adminNames as $name) {
            $admins[] = [
                'name' => $name,
                'email' => strtolower($name) . '@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'created_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                'updated_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            ];
        }

        // Realistic user names
        $userNames = ['Abu', 'John', 'Izzat', 'Rahman', 'Aisyah', 'Kamal', 'Shafiq', 'Rosli', 'Fazli', 'Liyana', 'Syuhada', 'Azlan', 'Hafiza', 'Sufian', 'Nadia', 'Amalina', 'Ikmal', 'Rosnah', 'Zainab', 'Hisham', 'Fakhrul', 'Solehah', 'Fakhri', 'Sazali', 'Aida', 'Norazman', 'Nizam', 'Lina', 'Kamariah', 'Maimunah', 'Jamilah', 'Afiq', 'Imran', 'Syahirah', 'Muaz', 'Afiqah', 'Hanafi', 'Zikri', 'Syamimi', 'Sham', 'Yasmin', 'Shamim', 'Raihan', 'Iskandar', 'Rashid', 'Alia', 'Firdaus', 'Diana', 'Anuar', 'Suhana', 'Najwa', 'Yusuf', 'Ramli', 'Khairul', 'Sani', 'Najib', 'Rozita', 'Kamrun', 'Taufiq'];
        $users = [];

        foreach (array_slice($userNames, 0, 60) as $name) {
            $users[] = [
                'name' => $name,
                'email' => strtolower($name) . '@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'created_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                'updated_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            ];
        }

        DB::table('users')->insertOrIgnore(array_merge($admins, $users));
    }
}
