<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Rista',
            'npp' => '240821',
            'password' => Hash::make('password'),
            'role' => 'UK',
            'department' => 'SDMUK',
        ]);
        User::create([
            'name' => 'Faris',
            'npp' => '241083',
            'password' => Hash::make('password'),
            'role' => 'UP',
            'department' => 'PKP',
        ]);
    }
}
