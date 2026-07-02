<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\MinistrySeeder;
use Database\Seeders\DeptSeeder;
use Database\Seeders\DistrictOfficeSeeder;
use Database\Seeders\OfficeSeeder;
use Database\Seeders\GradeSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\Workflow_templateSeeder;
use Database\Seeders\SubOfficeSeeder;
use Database\Seeders\Workflow_step_seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            MinistrySeeder::class,
            DeptSeeder::class,
            DistrictOfficeSeeder::class,
            OfficeSeeder::class,
            GradeSeeder::class,
            ServiceSeeder::class,
            RoleSeeder::class,
            SubOfficeSeeder::class,
            Workflow_templateSeeder::class,
            Workflow_step_seeder::class
        ]);
    }
}
