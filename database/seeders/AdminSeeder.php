<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'first_name' => 'Default',
            'last_name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'phone' => '1234567890',
            'password' => bcrypt('password'),
            'image' => null,
        ]);
    }
}
