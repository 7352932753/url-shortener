<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Raw SQL as required
          DB::statement("
          INSERT INTO companies (id, name, created_at, updated_at) 
          VALUES (1, 'Default Company', NOW(), NOW()) 
          ON DUPLICATE KEY UPDATE name = name
      ");

      DB::statement("
          INSERT INTO users (id, name, email, email_verified_at, password, role, company_id, created_at, updated_at) 
          VALUES (1, 'SuperAdmin', 'superadmin@example.com', NOW(), ?, 'superadmin', 1, NOW(), NOW())
          ON DUPLICATE KEY UPDATE email = email
      ", [Hash::make('password')]);
  
    }
}
