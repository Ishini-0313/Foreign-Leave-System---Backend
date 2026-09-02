<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Office;

class SubOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Office::create([
            'name' => 'පිරිස් හා පුහුණු අංශය',
            'type' => 'Chief Secretary Personal and Training',
            'parent_office_id' => 3,
        ]);

        Office::create([
            'name' => 'පාලන අංශය',
            'type' => 'Chief Secretary Admin',
            'parent_office_id' => 3,
        ]);
    }
}
