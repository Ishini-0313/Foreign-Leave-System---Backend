<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Workflow_template;

class Workflow_templateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1
        Workflow_template::create([
            'workflow_name' => 'Institue > Chief Sec Personnel & Training'
        ]);

        // 2
        Workflow_template::create([
            'workflow_name' => 'Institue > Chief Sec Admin > Chief Sec Personnel & Training'
        ]);

        // 3
        Workflow_template::create([
            'workflow_name' => 'Institue > Chief Ministry > Chief Sec Personnel & Training'
        ]);

        // 4
        Workflow_template::create([
            'workflow_name' => 'Institue > Ministry of Education > Chief Sec Personnel & Training'
        ]);

        // 5
        Workflow_template::create([
            'workflow_name' => 'Institue > Ministry of Agriculture > Chief Sec Personnel & Training'
        ]);

        // 6
        Workflow_template::create([
            'workflow_name' => 'Institue > Ministry of Fisheries > Chief Sec Personnel & Training'
        ]);

        // 7
        Workflow_template::create([
            'workflow_name' => 'Institue > Ministry of Sports > Chief Sec Personnel & Training'
        ]);

        // 8
        Workflow_template::create([
            'workflow_name' => 'Institue > Department of Local government > Chief Ministry > Chief Sec Personnel & Training'
        ]);

        // 9
        Workflow_template::create([
            'workflow_name' => 'Institue > Department of Education > Ministry of Education > Chief Sec Personnel & Training'
        ]);

        //10
        Workflow_template::create([
            'workflow_name' => 'Institue > Office of the assistant commissioner of local government-Galle> Department of local government > Chief Ministry > Chief Sec Personnel & Training'
        ]);

        //11
        Workflow_template::create([
            'workflow_name' => 'Institue > Office of the assistant commissioner of local government-Matara> Department of local government > Chief Ministry > Chief Sec Personnel & Training'
        ]);

        //12
        Workflow_template::create([
            'workflow_name' => 'Institue > Office of the assistant commissioner of local government-Hambanthota> Department of local government > Chief Ministry > Chief Sec Personnel & Training'
        ]);

        //13
        Workflow_template::create([
            'workflow_name' => 'Institue > Office of provincial director of health service-Galle > Department of health service > Chief Ministry > Chief Sec Personnel & Training'
        ]);

        //14
        Workflow_template::create([
            'workflow_name' => 'Institue > Office of provincial director of health service-Matara > Department of health service > Chief Ministry > Chief Sec Personnel & Training'
        ]);

        //15
        Workflow_template::create([
            'workflow_name' => 'Institue > Office of provincial director of health service-Hambanthota > Department of health service > Chief Ministry > Chief Sec Personnel & Training'
        ]);

        //16
        Workflow_template::create([
            'workflow_name' => 'Special Grade Workflow'
        ]);
    }
}
