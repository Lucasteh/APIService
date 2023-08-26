<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            'name' => 'Hardik',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('syspassword'),
        ]);
        User::create([
            'name' => 'Admin1',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('syspassword'),
        ]);
        User::create([
            'name' => 'admin2',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('syspassword'),
        ]);
    }
}
