<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $faker = Factory::create('id_ID');
        for ($i = 1; $i < 10; $i++) {
            DB::table('province')->insert([
                'province_name' => $faker->word(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
