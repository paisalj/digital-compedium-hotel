<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
User::create([
    'name' => 'Super Admin',
    'email' => 'superadmin@mbahalaphotel.com',
    'password' => bcrypt('password'),
    'role' => 'super_admin',
]);

User::create([
    'name' => 'Admin',
    'email' => 'admin@mbahalaphotel.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
]);
    }
}