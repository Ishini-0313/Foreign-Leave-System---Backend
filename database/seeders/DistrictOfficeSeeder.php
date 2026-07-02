<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Office;

class DistrictOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 30
        Office::create([
            'name' => 'දකුණු පළාත් සහකාර පළාත් පාලන දෙපාර්තමේන්තුව - ගාල්ල',
            'type' => 'District Office',
            'parent_office_id' => 16,
            'workflow_template_id' => 8
        ]);

        // 31
        Office::create([
            'name' => 'දකුණු පළාත් සහකාර පළාත් පාලන දෙපාර්තමේන්තුව - මාතර',
            'type' => 'District Office',
            'parent_office_id' => 16,
            'workflow_template_id' => 8
        ]);

        // 32
        Office::create([
            'name' => 'දකුණු පළාත් සහකාර පළාත් පාලන දෙපාර්තමේන්තුව - හම්බන්තොට',
            'type' => 'District Office',
            'parent_office_id' => 16,
            'workflow_template_id' => 8
        ]);

        // 33
        Office::create([
            'name' => 'දිස්ත්‍රික් සෞඛ්‍ය සේවා අධ්‍යක්ෂ කාර්යාලය - ගාල්ල',
            'type' => 'District Office',
            'parent_office_id' => 18,
            'workflow_template_id' => 8
        ]);

        // 34
        Office::create([
            'name' => 'දිස්ත්‍රික් සෞඛ්‍ය සේවා අධ්‍යක්ෂ කාර්යාලය - මාතර',
            'type' => 'District Office',
            'parent_office_id' => 18,
            'workflow_template_id' => 8
        ]);

        // 35
        Office::create([
            'name' => 'දිස්ත්‍රික් සෞඛ්‍ය සේවා අධ්‍යක්ෂ කාර්යාලය - හම්බන්තොට‍',
            'type' => 'District Office',
            'parent_office_id' => 18,
            'workflow_template_id' => 8
        ]);

        
        // 36
        Office::create([
            'name' => 'කලාප අධ්‍යාපන කාර්යාලය - අම්බලන්ගොඩ',
            'type' => 'District Office',
            'parent_office_id' => 19,
            'workflow_template_id' => 9
        ]);

        // 37
        Office::create([
            'name' => 'කලාප අධ්‍යාපන කාර්යාලය -වලස්මුල්ල',
            'type' => 'District Office',
            'parent_office_id' => 19,
            'workflow_template_id' => 9
        ]);

        // 38
        Office::create([
            'name' => 'කලාප අධ්‍යාපන කාර්යාලය -උඩුගම',
            'type' => 'District Office',
            'parent_office_id' => 19,
            'workflow_template_id' => 9
        ]);


        // 39
        Office::create([
            'name' => 'කලාප අධ්‍යාපන කාර්යාලය -හම්බන්තොට',
            'type' => 'District Office',
            'parent_office_id' => 19,
            'workflow_template_id' => 9
        ]);


        // 40
        Office::create([
            'name' => 'කලාප අධ්‍යාපන කාර්යාලය -මුලටියන',
            'type' => 'District Office',
            'parent_office_id' => 19,
            'workflow_template_id' => 9
        ]);

        // 41
        Office::create([
            'name' => 'කලාප අධ්‍යාපන කාර්යාලය -අකුරැස්ස',
            'type' => 'District Office',
            'parent_office_id' => 19,
            'workflow_template_id' => 9
        ]);


        // 42
        Office::create([
            'name' => 'කලාප අධ්‍යාපන කාර්යාලය -මාතර',
            'type' => 'District Office',
            'parent_office_id' => 19,
            'workflow_template_id' => 9
        ]);

        // 43
        Office::create([
            'name' => 'කලාප අධ්‍යාපන කාර්යාලය -ඇල්පිටිය',
            'type' => 'District Office',
            'parent_office_id' => 19,
            'workflow_template_id' => 9
        ]);

        // 44
        Office::create([
            'name' => 'කලාප අධ්‍යාපන කාර්යාලය -තංගල්ල',
            'type' => 'District Office',
            'parent_office_id' => 19,
            'workflow_template_id' => 9
        ]);

        // 45
        Office::create([
            'name' => 'කලාප අධ්‍යාපන කාර්යාලය -දෙණියාය, මොරවක',
            'type' => 'District Office',
            'parent_office_id' => 19,
            'workflow_template_id' => 9
        ]);

        // 46
        Office::create([
            'name' => 'කලාප අධ්‍යාපන කාර්යාලය -ගාල්ල',
            'type' => 'District Office',
            'parent_office_id' => 19,
            'workflow_template_id' => 9
        ]);
    }
}
