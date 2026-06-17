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
        // 14
        Office::create([
            'name' => 'දකුණු පළාත් අභ්‍යන්තර විගණන දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 3
        ]);

        // 15
        Office::create([
            'name' => 'දකුණු පළාත් කළමනාකරණ සංවර්ධන හා පුහුණු ආයතනය-වක්වැල්ල',
            'type' => 'Department',
            'parent_office_id' => 3
        ]);

        // 16
        Office::create([
            'name' => 'දකුණු පළාත් පළාත් පාලන දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 9
        ]);

        // 17
        Office::create([
            'name' => 'දකුණු පළාත් ආයුර්වේද දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 9
        ]);

        // 18
        Office::create([
            'name' => 'දකුණු පළාත් සෞඛ්‍ය සේවා දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 9
        ]);

        // 19
        Office::create([
            'name' => 'දකුණු පළාත් පළාත් අධ්‍යාපන දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 10
        ]);

        // 20
        Office::create([
            'name' => 'දකුණු පළාත් ඉඩම් කොමසාරිස් දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 10
        ]);

        // 21
        Office::create([
            'name' => 'දකුණු පළාත් වාරිමාර්ග දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 11
        ]);

        // 22
        Office::create([
            'name' => 'දකුණු පළාත් කෘෂිකර්ම දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 11
        ]);

        // 23
        Office::create([
            'name' => 'දකුණු පළාත් සමුපකාර දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 11
        ]);

        // 24
        Office::create([
            'name' => 'දකුණු පළාත් කර්මාන්ත සංවර්ධන දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 12
        ]);

        // 25
        Office::create([
            'name' => 'දකුණු පළාත් සත්ත්ව නිෂ්පාදන හා සෞඛ්‍ය දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 12
        ]);

        // 26
        Office::create([
            'name' => 'දකුණු පළාත් සමාජ සුභසාධන පරිවාස හා ළමාරක්ෂක සේවා දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 13
        ]);

        // 27
        Office::create([
            'name' => 'දකුණු පළාත් නිවාස කොමසාරිස් දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 13
        ]);

        // 28
        Office::create([
            'name' => 'ක්‍රීඩා සංවර්ධන දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 13
        ]);

        // 29
        Office::create([
            'name' => 'පළාත් ග්‍රාම සංවර්ධන දෙපාර්තමේන්තුව',
            'type' => 'Department',
            'parent_office_id' => 13
        ]);
    }
}
