<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1
        Role::create([
            'role_name' => 'Applicant'
        ]);

        // 2
        Role::create([
            'role_name' => 'Subject Officer'
        ]);

        // 3
        Role::create([
            'role_name' => 'Check Officer'
        ]);

        // 4
        Role::create([
            'role_name' => 'Recommending Officer'
        ]);

        // 5
        Role::create([
            'role_name' => 'Chief Secretary'
        ]);
    }
}
