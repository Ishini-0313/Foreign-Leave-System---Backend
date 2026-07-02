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
            'parent_office_id' => NULL,
            'workflow_template_id' => 1
        ]);

        // 2
        Office::create([
            'name' => 'දකුණු පළාත් රාජ්‍ය සේවා කොමිෂන් සභාව',
            'type' => 'Ministry',
            'parent_office_id' => NULL,
            'workflow_template_id' => 1
        ]);

        // 3
        Office::create([
            'name' => 'දකුණු පළාත් ප්‍රධාන ලේකම් කාර්යාලය',
            'type' => 'Ministry',
            'parent_office_id' => NULL,
            'workflow_template_id' => 2
        ]);

        // 4
        Office::create([
            'name' => 'දකුණු පළාත් සැලසුම් ලේකම් කාර්යාලය',
            'type' => 'Ministry',
            'parent_office_id' => NULL,
            'workflow_template_id' => 1
        ]);

        // 5
        Office::create([
            'name' => 'දකුණු පළාත් ඉංජිනේරු සේවා කාර්යාලය',
            'type' => 'Ministry',
            'parent_office_id' => NULL,
            'workflow_template_id' => 1
        ]);

        // 6
        Office::create([
            'name' => 'දකුණු පළාත් පළාත් සමූපකාර සේවක කොමිෂන් සභාව',
            'type' => 'Ministry',
            'parent_office_id' => NULL,
            'workflow_template_id' => 6
        ]);

        // 7
        Office::create([
            'name' => 'දකුණු පළාත් පළාත් මෝටර් රථ ප්‍රවාහන දෙපාර්තමේන්තුව',
            'type' => 'Ministry',
            'parent_office_id' => NULL,
            'workflow_template_id' => 1
        ]);

        // 8
        Office::create([
            'name' => 'දකුණු පළාත් පළාත් ආදායම් දෙපාර්තමේන්තුව',
            'type' => 'Ministry',
            'parent_office_id' => NULL,
            'workflow_template_id' => 1
        ]);

        // 9
        Office::create([
            'name' => 'දකුණු පළාත් ප්‍රධාන අමාත්‍යංශය',
            'type' => 'Ministry',
            'parent_office_id' => NULL,
            'workflow_template_id' => 1
        ]);


        // 10
        Office::create([
            'name' => 'දකුණු පළාත් අධ්‍යාපන අමාත්‍යංශය',
            'type' => 'Ministry',
            'parent_office_id' => NULL,
            'workflow_template_id' => 1
        ]);

        // 11
        Office::create([
            'name' => 'දකුණු පළාත් කෘෂිකර්ම අමාත්‍යංශය',
            'type' => 'Ministry',
            'parent_office_id' => NULL,
            'workflow_template_id' => 1
        ]);

        // 12
        Office::create([
            'name' => 'දකුණු පළාත් ධීවර අමාත්‍යංශය',
            'type' => 'Ministry',
            'parent_office_id' => NULL,
            'workflow_template_id' => 1
        ]);

        // 13
        Office::create([
            'name' => 'දකුණු පළාත් ක්‍රීඩා අමාත්‍යංශය',
            'type' => 'Ministry',
            'parent_office_id' => NULL,
            'workflow_template_id' => 1
        ]);

    }
}
