<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Office;

class DeptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 11
        Office::create([
            'name' => 'දකුණු පළාත් පළාත් සමූපකාර සේවක කොමිෂන් සභාව',
            'type' => 'Department',
            'parent_office_id' => 8,
            'workflow_template_id' => 6
        ]);

        // 12
        Office::create([
            'name' => 'දකුණු පළාත් පළාත් මෝටර් රථ ප්‍රවාහන දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 3,
            'workflow_template_id' => 1
        ]);

        // 13
        Office::create([
            'name' => 'දකුණු පළාත් පළාත් ආදායම් දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 3,
            'workflow_template_id' => 1
        ]);

        // 14
        Office::create([
            'name' => 'දකුණු පළාත් අභ්‍යන්තර විගණන දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 3,
            'workflow_template_id' => 2
        ]);

        // 15
        Office::create([
            'name' => 'දකුණු පළාත් කළමනාකරණ සංවර්ධන හා පුහුණු ආයතනය-වක්වැල්ල',
            'type' => 'Department',
            'parent_office_id' => 3,
            'workflow_template_id' => 2
        ]);

        // 16
        Office::create([
            'name' => 'දකුණු පළාත් පළාත් පාලන දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 9,
            'workflow_template_id' => 3
        ]);

        // 17
        Office::create([
            'name' => 'දකුණු පළාත් ආයුර්වේද දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 9,
            'workflow_template_id' => 3
        ]);

        // 18
        Office::create([
            'name' => 'දකුණු පළාත් සෞඛ්‍ය සේවා දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 9,
            'workflow_template_id' => 3
        ]);

        // 19
        Office::create([
            'name' => 'දකුණු පළාත් පළාත් අධ්‍යාපන දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 10,
            'workflow_template_id' => 4
        ]);

        // 20
        Office::create([
            'name' => 'දකුණු පළාත් ඉඩම් කොමසාරිස් දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 10,
            'workflow_template_id' => 4
        ]);

        // 21
        Office::create([
            'name' => 'දකුණු පළාත් වාරිමාර්ග දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 11,
            'workflow_template_id' => 5
        ]);

        // 22
        Office::create([
            'name' => 'දකුණු පළාත් කෘෂිකර්ම දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 11,
            'workflow_template_id' => 5
        ]);

        //23
        Office::create([
            'name' => 'දකුණු පළාත් සමුපකාර සංවර්ධන දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 11,
            'workflow_template_id' => 5
        ]);

        // 24
        // Office::create([
        //     'name' => 'දකුණු පළාත් කර්මාන්ත සංවර්ධන දෙපාර්තමේන්තුව',
        //     'type' => 'Department',
        //     'parent_office_id' => 12,
        //     'workflow_template_id' => 7
        // ]);

        // 25
        Office::create([
            'name' => 'දකුණු පළාත් සත්ත්ව නිෂ්පාදන හා සෞඛ්‍ය දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 12,
            'workflow_template_id' => 6
        ]);

        // 26
        Office::create([
            'name' => 'දකුණු පළාත් සමාජ සුභසාධන පරිවාස හා ළමාරක්ෂක සේවා දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 13,
            'workflow_template_id' => 7
        ]);

        // 27
        Office::create([
            'name' => 'දකුණු පළාත් නිවාස කොමසාරිස් දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 13,
            'workflow_template_id' => 7
        ]);

        // 28
        Office::create([
            'name' => 'ක්‍රීඩා සංවර්ධන දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 13,
            'workflow_template_id' => 7
        ]);

        // 29
        Office::create([
            'name' => 'පළාත් ග්‍රාම සංවර්ධන දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 13,
            'workflow_template_id' => 7
        ]);
    }
}
