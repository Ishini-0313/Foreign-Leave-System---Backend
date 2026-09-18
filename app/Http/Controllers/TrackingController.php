<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Workflow_steps;

class TrackingController extends Controller{
    private function requiresAccountantApproval(Application $application): bool{
        return in_array($application->leave_category, [
            'leave_with_additional_offer',
            'leave_with_warm_cloths_and_additional_offer',
            'warm_cloths_and_additional_offer_only',
        ]);
    }

    public function index($id){
        $application = Application::with('institute','workflowHistories.workflowStep', 'workflowHistories.user.office')->findOrFail($id);

        $steps = Workflow_steps::with('role')->where('workflow_id', $application->workflow_id)->orderBy('sequence_no')->get();

        
        //Determine whether Accountant approval is required
        

        $requiresAccountantApproval = in_array(
            $application->leave_category,
            [
                'leave_with_additional_offer',
                'leave_with_warm_cloths_and_additional_offer',
                'warm_cloths_and_additional_offer_only',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Remove Accountant step for normal applications
        |--------------------------------------------------------------------------
        |
        | Your workflow templates may contain the Accountant step for
        | multiple categories. For normal applications, hide it.
        |
        */

        if (!$requiresAccountantApproval) {
            $steps = $steps->filter(function ($step) {
                return !(
                    $step->office_reference === 'ගිණුම් අංශය'
                    &&
                    $step->role_id == 10
                );
            })->values();
        }

        

        //latest history record
        $latestHistory = $application->workflowHistories->sortByDesc('created_at')->first();

        /*
        |--------------------------------------------------------------------------
        | Current step
        |--------------------------------------------------------------------------
        */

        $currentStep = $application->current_step;

        foreach($steps as $step){
            // office name
            if($step->office_reference === 'Institute'){
                $step->office_name = $application->institute->name;
            }
            else{
                $step->office_name = ucwords(str_replace('_', ' ', $step->office_reference));
            }

            // default status
            $step->status = 'pending';

            // application fully approved
            if ($application->status === 'Approved') {
                $step->status = 'completed';
                continue;
            }

            //current step
            if ($step->id == $application->current_step_id) {
                $step->status = 'current';
                continue;
            }

            //returned step
            if ($latestHistory && $latestHistory->action === 'Returned' && $latestHistory->workflow_step_id == $step->id) {
                $step->status = 'returned';
                continue;
            }

            $currentStep = $application->current_step;

            if ($currentStep &&$step->sequence_no < $currentStep->sequence_no) {
                $step->status = 'completed';
            }
            
        }

        

        // $history = $application->workflowHistories()->with(['workflowStep.role', 'user.office'])->orderBy('created_at')->get();

        return response()->json([
            'application' => $application,
            'steps' => $steps,
            'history' => $application->workflowHistories->sortBy('created_at')->values()
        ]);
    }
}
