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
          User::factory()->count(10)->create();
          
          User::factory()->create([
              'name' => 'Admin User',
              'email' => 'admin@example.com',
              'password' => bcrypt('admin123'),
              'email_verified_at' => now(),
          ]);
    }
}
