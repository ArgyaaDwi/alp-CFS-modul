<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $userData = [
        //     [
        //         'name' => 'user1',
        //         'email' => 'user1@gmail.com',
        //         'no_telephone' => 1212123131,
        //         'distributor_id' => 7,
        //         'password' => bcrypt('Password')
        //     ],
        //     [
        //         'name' => 'admin',
        //         'email' => 'admin@gmail.com',
        //         'no_telephone' => 1123456789,
        //         'role_id' => 2,
        //         'is_verified' => true,
        //         'password' => bcrypt('Password')
        //     ],
        //     [
        //         'name' => 'quality manager',
        //         'email' => 'qm@gmail.com',
        //         'no_telephone' => 123456789,
        //         'role_id' => 3,
        //         'is_verified' => true,
        //         'password' => bcrypt('Password')
        //     ],
        //     [
        //         'name' => 'factory general manager',
        //         'email' => 'fgm@gmail.com',
        //         'no_telephone' => 123456789,
        //         'role_id' => 4,
        //         'is_verified' => true,
        //         'password' => bcrypt('Password')
        //     ],

        // ];
        $userData = [
            'name' => 'Admin 1',
            'email' => 'admin@gmail.com',
            'no_telephone' => 1123456789,
            'role_id' => 2,
            'is_verified' => true,
            'password' => bcrypt('Password')
        ];

        User::create($userData);
        // foreach ($userData as $key => $value) {
        //     User::create($value);
        // }
    }
}
