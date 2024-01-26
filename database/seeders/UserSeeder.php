<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@lynkCoding.com',
            'password' => Hash::make('123456789'),
        ]);
        User::create([
            'name' => 'Customer One',
            'email' => 'customerone@lynkCoding.com',
            'password' => Hash::make('123456789'),
        ]);
        User::create([
            'name' => 'Customer Two',
            'email' => 'customertwo@lynkCoding.com',
            'password' => Hash::make('123456789'),
        ]);
    }
}
