<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Factory::create('id_ID');
        for ($i = 1; $i < 60; $i++) {
            DB::table('city')->insert([
                'city_name' => $faker->city(),
                'province_id' => $faker->numberBetween(10, 18),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
