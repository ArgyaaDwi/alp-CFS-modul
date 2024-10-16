<?php

namespace Database\Seeders;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');
        for ($i = 1; $i <= 12; $i++) {
            DB::table('distributors')->insert([
                'company_type_id' => $faker->numberBetween(1, 5),
                'company_name' => $faker->company(),
                'company_province_id' => $faker->numberBetween(10, 18),
                'company_code' => $faker->ean8(),
                'company_distributor_id' => $faker->numberBetween(1, 2),
                'company_city_id' => $faker->numberBetween(1, 25),
                'company_address' => $faker->address(),
                'company_phone' => $faker->phoneNumber(),
                'company_email' => $faker->email(),
                'company_website' => $faker->url(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

    }
}
