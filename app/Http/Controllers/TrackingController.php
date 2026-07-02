<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Workflow_steps;

class TrackingController extends Controller
{
    public function index($id){
        $application = Application::with('institute')->findOrFail($id);

        $steps = Workflow_steps::with('role')->where('workflow_id', $application->workflow_id)->orderBy('sequence_no')->get();

        $steps->transform(function ($step) use ($application) {
            if ($step->office_reference === 'Institute') {
                $step->office_name = $application->institute->name;
            } else {
                $step->office_name = ucwords(str_replace('_', ' ', $step->office_reference));
            }
            return $step;
        });

        $history = $application->workflowHistories()->with(['workflowStep.role', 'user.office'])->orderBy('created_at')->get();

        return response()->json([
            'application' => $application,
            'steps' => $steps,
            'history' => $history
        ]);
    }
}
