<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Services\WorkflowService;

class OfficerController extends Controller
{
    public function pending(){
        //return Application::where('current_assigned_user_id', auth()->id())->where('status', 'Pending')->get();

        return Application::with(['applicant','applicant.office'])->where('current_assigned_user_id', auth()->id())->where('status', 'Pending')->get();
    }

    public function approve(Request $request, $id, WorkflowService $workflowService){
        $application = Application::findOrFail($id);
        $workflowService->approve($application, auth()->user(), $request->remarks);

        return response()->json([
            'message' => 'Approved'
        ]);
    }

    public function forward(Request $request, Application $application, WorkflowService $workflowService){
        $request->validate([
            'remarks' => 'nullable|string'
        ]);

        if($application->current_assigned_user_id != auth()->id()){
            return response()->json([
                'message' => 'This application is not assigned to you.'
            ], 403);
        }

        $workflowService->forward($application, auth()->user(), $request->remarks);

        return response()->json([
            'message' => 'Application Forwarded successfully'
        ]);

    }

    public function return(Request $request, Application $application, WorkflowService $workflowService){
        $request->validate([
            'remarks' => 'nullable|string'
        ]);

        if($application->current_assigned_user_id != auth()->id()){
            return response()->json([
                'message' => 'This application is not assigned to you.'
            ], 403);
        }

        $workflowService->return($application, auth()->user(), $request->remarks);

        return response()->json([
            'message' => 'Application Returned'
        ]);
    }

    public function myQueue(){
        $applications = Application::with(['applicant', 'applicant.office', 'current_step'])->where('current_assigned_user_id', auth()->id())->where('status', 'Pending')->latest()->get();
        return response()->json($applications);
    }

    public function allApplications(){
        $applications = Application::with(['applicant', 'applicant.office', 'current_step'])->latest()->get();
        return response()->json($applications);
    }
}
