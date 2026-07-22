<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application_amendments;
use App\Models\Workflow_steps;

class AmendmentTrackingController extends Controller
{
    public function index($id){
        $amendment = Application_amendments::with('application.institute','workflowHistories.workflowStep', 'workflowHistories.user.office')->findOrFail($id);

        $steps = Workflow_steps::with('role')->where('workflow_id', $amendment->workflow_id)->orderBy('sequence_no')->get();

        //latest history record
        $latestHistory = $amendment->workflowHistories->sortByDesc('created_at')->first();

        foreach($steps as $step){
            // office name
            if($step->office_reference === 'Institute'){
                $step->office_name = $amendment->application->institute->name;
            }
            else{
                $step->office_name = ucwords(str_replace('_', ' ', $step->office_reference));
            }

            // default status
            $step->status = 'pending';

            // current step
            if($step->id == $amendment->current_step_id){
                $step->status = 'current';
                continue;
            }

            //returned step
            if($latestHistory && $latestHistory->action == 'Returned' && $latestHistory->workflow_step_id == $step->id){
                $step->status = 'returned';
                continue;
            }

            // completed step
            if($step->sequence_no < optional($amendment->current_step)->sequence_no){
                $step->status = 'completed';
            }
            
        }

        // $history = $application->workflowHistories()->with(['workflowStep.role', 'user.office'])->orderBy('created_at')->get();

        return response()->json([
            'application' => $amendment,
            'steps' => $steps,
            'history' => $amendment->workflowHistories->sortBy('created_at')->values()
        ]);
    }
}
