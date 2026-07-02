<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Office;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 47
        Office::create([
            'name' => 'මහා නගර සභාව - ගාල්ල',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 10
        ]);

        // 48
        Office::create([
            'name' => 'නගර සභාව - අම්බලන්ගොඩ',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 49
        Office::create([
            'name' => 'නගර සභාව - හික්කඩුව',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 50
        Office::create([
            'name' => 'ප්‍රාදේශිය සභාව - බෝපේ පෝද්දල',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 51
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - රජ්ගම',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 52
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව -නියාගම',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 53
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - ඉමදුව',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 54
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - අක්මීමණ',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 55
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - නෙළුව',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 56
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - වැලිවිටිය-දිවිතුර',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 57
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - බෙන්තොට',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 58
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - බද්දේගම',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 59
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - නාගොඩ',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 60
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - කරන්දෙණිය',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 61
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - තවලම',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 62
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - යක්කලමුල්ල',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 63
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - හබරාදුව',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 64
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - අම්බලන්ගොඩ',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 65
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - ඇල්පිටිය',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 66
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - බලපිටිය',
            'type' => 'Office',
            'parent_office_id' => 30,
            'workflow_template_id' => 12
        ]);

        // 67
        Office::create([
            'name' => 'මහා නගර සභාව - මාතර',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        // 68
        Office::create([
            'name' => 'නගර සභාව - වැලිගම',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        // 69
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - පිටබැද්දර',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        // 70
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - අතුරලිය',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        // 71
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - දික්වැල්ල',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        // 72
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - මුලටියන',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        // 73
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - කිරින්ද පුහුල්වැල්ල',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        // 74
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - කඹුරුපිටිය',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        // 75
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - මාතර',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        // 76
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - පස්ගොඩ',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        //77
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - හක්මන',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        //78
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - කොටපොල',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        //79
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - අකුරැස්ස',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        //80
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - වැලිගම',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        //81
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - තිහගොඩ',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        //82
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - මාලිම්බඩ',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        //83
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - දෙවිනුවර',
            'type' => 'Office',
            'parent_office_id' => 31,
            'workflow_template_id' => 12
        ]);

        //84
        Office::create([
            'name' => 'මහා නගර සභාව - හම්බන්තොට',
            'type' => 'Office',
            'parent_office_id' => 32,
            'workflow_template_id' => 12
        ]);

        //85
        Office::create([
            'name' => 'නගර සභාව - තංගල්ල',
            'type' => 'Office',
            'parent_office_id' => 32,
            'workflow_template_id' => 12
        ]);

        //86
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - අම්බලන්තොට',
            'type' => 'Office',
            'parent_office_id' => 32,
            'workflow_template_id' => 12
        ]);

        //87
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - බෙලිඅත්ත',
            'type' => 'Office',
            'parent_office_id' => 32,
            'workflow_template_id' => 12
        ]);

        //88
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - සූරියවැව',
            'type' => 'Office',
            'parent_office_id' => 32,
            'workflow_template_id' => 12
        ]);

        //89
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - ලුණුගම්වෙහෙර',
            'type' => 'Office',
            'parent_office_id' => 32,
            'workflow_template_id' => 12
        ]);

        //90
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - අඟුණුකොළපැලැස්ස',
            'type' => 'Office',
            'parent_office_id' => 32,
            'workflow_template_id' => 12
        ]);

        //91
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - කටුවන',
            'type' => 'Office',
            'parent_office_id' => 32,
            'workflow_template_id' => 12
        ]);

        //92
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව -තිස්සමහාරාමය',
            'type' => 'Office',
            'parent_office_id' => 32,
            'workflow_template_id' => 12
        ]);

        //93
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - හම්බන්තොට',
            'type' => 'Office',
            'parent_office_id' => 32,
            'workflow_template_id' => 12
        ]);

        //94
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - තංගල්ල',
            'type' => 'Office',
            'parent_office_id' => 32,
            'workflow_template_id' => 12
        ]);

        //95
        Office::create([
            'name' => 'ප්‍රාදේශීය සභාව - වීරකැටිය',
            'type' => 'Office',
            'parent_office_id' => 32,
            'workflow_template_id' => 12
        ]);

        //96
        Office::create([
            'name' => 'මූලික රෝහල - බලපිටිය',
            'type' => 'Office',
            'parent_office_id' => 34,
            'workflow_template_id' => 13
        ]);

        //97
        Office::create([
            'name' => 'මූලික රෝහල - උඩුගම',
            'type' => 'Office',
            'parent_office_id' => 34,
            'workflow_template_id' => 13
        ]);

        //98
        Office::create([
            'name' => 'මූලික රෝහල - ඇල්පිටිය',
            'type' => 'Office',
            'parent_office_id' => 34,
            'workflow_template_id' => 13
        ]);

        //99
        Office::create([
            'name' => 'මූලික රෝහල - කඹුරුපිටිය',
            'type' => 'Office',
            'parent_office_id' => 35,
            'workflow_template_id' => 13
        ]);

        //100
        Office::create([
            'name' => 'මූලික රෝහල - දෙනියාය',
            'type' => 'Office',
            'parent_office_id' => 35,
            'workflow_template_id' => 13
        ]);

        //101
        Office::create([
            'name' => 'මූලික රෝහල - තංගල්ල',
            'type' => 'Office',
            'parent_office_id' => 36,
            'workflow_template_id' => 13
        ]);

        //102
        Office::create([
            'name' => 'මූලික රෝහල - වලස්මුල්ල',
            'type' => 'Office',
            'parent_office_id' => 36,
            'workflow_template_id' => 13
        ]);

        //103
        Office::create([
            'name' => 'මූලික රෝහල - තිස්සමහාරාම',
            'type' => 'Office',
            'parent_office_id' => 36,
            'workflow_template_id' => 13
        ]);
    }
}

