<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //1
        Grade::create([
            'name' => 'විශේෂ ශ්‍රේණිය'
        ]);

        //2
        Grade::create([
            'name' => 'I'
        ]);

        //3
        Grade::create([
            'name' => 'II'
        ]);

        //4
        Grade::create([
            'name' => 'III'
        ]);
    }
}
