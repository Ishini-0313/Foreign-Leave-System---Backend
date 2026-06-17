<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Office;

class MinistrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1
        Office::create([
            'name' => 'දකුණු පළාත් සභා ලේකම් කාර්යාලය',
            'type' => 'Ministry',
            'parent_office_id' => NULL
        ]);

        // 2
        Office::create([
            'name' => 'දකුණු පළාත් රාජ්‍ය සේවා කොමිෂන් සභාව',
            'type' => 'Ministry',
            'parent_office_id' => NULL
        ]);

        // 3
        Office::create([
            'name' => 'දකුණු පළාත් ප්‍රධාන ලේකම් කාර්යාලය',
            'type' => 'Ministry',
            'parent_office_id' => NULL
        ]);

        // 4
        Office::create([
            'name' => 'දකුණු පළාත් සැලසුම් ලේකම් කාර්යාලය',
            'type' => 'Ministry',
            'parent_office_id' => NULL
        ]);

        // 5
        Office::create([
            'name' => 'දකුණු පළාත් ඉංජිනේරු සේවා කාර්යාලය',
            'type' => 'Ministry',
            'parent_office_id' => NULL
        ]);

        // 6
        Office::create([
            'name' => 'දකුණු පළාත් පළාත් සමූපකාර සේවක කොමිෂන් සභාව',
            'type' => 'Ministry',
            'parent_office_id' => NULL
        ]);

        // 7
        Office::create([
            'name' => 'දකුණු පළාත් පළාත් මෝටර් රථ ප්‍රවාහන දෙපාර්තමේන්තුව',
            'type' => 'Ministry',
            'parent_office_id' => NULL
        ]);

        // 8
        Office::create([
            'name' => 'දකුණු පළාත් පළාත් ආදායම් දෙපාර්තමේන්තුව',
            'type' => 'Ministry',
            'parent_office_id' => NULL
        ]);

        // 9
        Office::create([
            'name' => 'දකුණු පළාත් ප්‍රධාන අමාත්‍යංශය',
            'type' => 'Ministry',
            'parent_office_id' => NULL
        ]);


        // 10
        Office::create([
            'name' => 'දකුණු පළාත් අධ්‍යාපන අමාත්‍යංශය',
            'type' => 'Ministry',
            'parent_office_id' => NULL
        ]);

        // 11
        Office::create([
            'name' => 'දකුණු පළාත් කෘෂිකර්ම අමාත්‍යංශය',
            'type' => 'Ministry',
            'parent_office_id' => NULL
        ]);

        // 12
        Office::create([
            'name' => 'දකුණු පළාත් ධීවර අමාත්‍යංශය',
            'type' => 'Ministry',
            'parent_office_id' => NULL
        ]);

        // 13
        Office::create([
            'name' => 'දකුණු පළාත් ක්‍රීඩා අමාත්‍යංශය',
            'type' => 'Ministry',
            'parent_office_id' => NULL
        ]);

    }
}
