<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Services\WorkflowService;
use App\Models\Office;

class OfficerController extends Controller
{
    public function pending(){
        //return Application::where('current_assigned_user_id', auth()->id())->where('status', 'Pending')->get();

        return Application::with(['applicant','applicant.office'])->where('current_assigned_user_id', auth()->id())->where('status', 'Pending')->get();
    }

    public function approve(Request $request, Application $application, WorkflowService $workflowService){
        $request->validate([
            'remarks' => 'nullable|string'
        ]);

        // Make sure this application belongs to the logged-in responsible officer
        if ($application->current_assigned_user_id != auth()->id()) {
            return response()->json([
                'message' => 'This application is not assigned to you.'
            ], 403);
        }
        try{
            $workflowService->approve($application,auth()->user(),$request->remarks);

            return response()->json([
                'message' => 'Application approved successfully.'
            ]);

            $this->generateApprovalLetter($application);
        }catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
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

    public function allSubApplications(Request $request){
        $user = $request->user();

        // Logged-in user's office
        $office = $user->office;

        if (!$office) {
            return response()->json([
                'message' => 'User is not assigned to an office.'
            ], 403);
        }

        // Get logged-in office + all child offices
        $officeIds = $office->getAllDescendantIds();

        // Get applications belonging to those offices
        $applications = Application::with([
            'applicant.office'
        ])
        ->whereIn('institute_id', $officeIds)
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json($applications);
        }
}
