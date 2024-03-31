<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'email' => 'mojtabagh0098@gmail.com',
            'password' => 'H2m^md]CUvHwr5^',
            'role_id' => 1
        ]);
    }
}
