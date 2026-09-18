<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Services\WorkflowService;
use App\Models\Office;
use App\Services\ApprovalLetterService;
use App\Services\CompletedApplicationService;
use Illuminate\Support\Facades\DB;

class OfficerController extends Controller
{
    public function pending(){
        //return Application::where('current_assigned_user_id', auth()->id())->where('status', 'Pending')->get();

        return Application::with(['applicant','applicant.office'])->where('current_assigned_user_id', auth()->id())->where('status', 'Pending')->get();
    }

    public function approve(Request $request, Application $application, WorkflowService $workflowService, ApprovalLetterService $approvalLetterService, CompletedApplicationService $completedApplicationService){
        $request->validate([
            'remarks' => 'nullable|string',
            'approval' => 'nullable|in:approved_with_salary,approved_without_salary,not_approved',
            'signature' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Make sure this application belongs to the logged-in responsible officer
        if ($application->current_assigned_user_id != auth()->id()) {
            return response()->json([
                'message' => 'This application is not assigned to you.'
            ], 403);
        }

        $step = $application->current_step;
        $roleName = $step?->role?->role_name;
        $isCheifSecretary = $roleName == 'Chief Secretary';
        
        if ($isCheifSecretary) {
            if (!$request->approval) {
                return response()->json([
                    'message' => 'Please select approved or not approved.'
                ], 422);
            }
            if (!$request->hasFile('signature')) {
                return response()->json([
                    'message' => 'Please upload your signature.'
                ], 422);
            }
        }

        DB::beginTransaction();
        try{
            $signaturePath = null;
            if ($request->hasFile('signature')) {
                $signaturePath = $request->file('signature')->store('workflow_signatures', 'public');
            }

            if($request->approval == "approved_with_salary"){
                $action = "Approved with salary";
            }else if($request->approval == "approved_without_salary"){
                $action = "Approved without salary";
            }else if($request->approval == "not_approved"){
                $action = "Not Approved";
            }else{
                $action = "";
            }


            $workflowService->approve($application,auth()->user(),$request->remarks,$signaturePath,$action);

            $approvalLetter = $approvalLetterService->generate(
                $application->fresh()
            );

            //Generate completed application forms
            $completedForm = $completedApplicationService->generate_form_16($application);
            $completedForm = $completedApplicationService->generate_form_126($application);

            DB::commit();

            return response()->json([
                'message' => 'Application approved successfully.',
                'approval_letter' => [
                    'id' => $approvalLetter->id,
                    'file_name' => $approvalLetter->file_name,
                ],
            ]);
        }catch(\Exception $e){
            \Log::error(
            'Approval letter generation failed',
                [
                    'application_id' => $application->id,
                    'error' => $e->getMessage()
                ]
            );
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function forward(Request $request, Application $application, WorkflowService $workflowService){
        $request->validate([
            'remarks' => 'nullable|string',
            'recommendation' => 'nullable|in:recommended_with_salary,recommended_without_salary,not_recommended',
            'signature' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if($application->current_assigned_user_id != auth()->id()){
            return response()->json([
                'message' => 'This application is not assigned to you.'
            ], 403);
        }

        $step = $application->current_step;
        $roleName = $step?->role?->role_name;
        $isRecommendationOfficer =
            $roleName !== 'Applicant' &&
            $roleName !== 'Subject Officer' &&
            $roleName !== 'Check Officer' &&
            $roleName !== 'Chief Secretary';

        if ($isRecommendationOfficer) {
            if (!$request->recommendation) {
                return response()->json([
                    'message' => 'Please select a recommendation.'
                ], 422);
            }
            if (!$request->hasFile('signature')) {
                return response()->json([
                    'message' => 'Please upload your signature.'
                ], 422);
            }
        }

        DB::beginTransaction();

        try{
            $signaturePath = null;
            if ($request->hasFile('signature')) {
                $signaturePath = $request->file('signature')->store('workflow_signatures', 'public');
            }

            if($request->recommendation == "recommended_with_salary"){
                $recommendation = "Recommended with salary";
            }else if($request->recommendation == "recommended_without_salary"){
                $recommendation = "Recommended without salary";
            }else if($request->recommendation == "not_recommended"){
                $recommendation = "Not recommended";
            }else{
                $recommendation = "";
            }

            $action = $isRecommendationOfficer ? $recommendation : "Forwarded";   
             //move application to next step
            $workflowService->forward($application, auth()->user(), $request->remarks, $signaturePath, $action);

            DB::commit();

            return response()->json([
                'message' => 'Application forwarded successfully.'
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            \Log::error('Application returned failed', [
                'application_id' => $application->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function return(Request $request, Application $application, WorkflowService $workflowService){
        $request->validate([
            'remarks' => 'nullable|string',
            'recommendation' => 'nullable|in:recommended_with_salary,recommended_without_salary,not_recommended',
            'signature' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if($application->current_assigned_user_id != auth()->id()){
            return response()->json([
                'message' => 'This application is not assigned to you.'
            ], 403);
        }

        $step = $application->current_step;
        $roleName = $step?->role?->role_name;
        $isRecommendationOfficer =
            $roleName !== 'Applicant' &&
            $roleName !== 'Subject Officer' &&
            $roleName !== 'Check Officer' &&
            $roleName !== 'Chief Secretary';

        if ($isRecommendationOfficer) {
            if (!$request->recommendation) {
                return response()->json([
                    'message' => 'Please select a recommendation.'
                ], 422);
            }
            if (!$request->hasFile('signature')) {
                return response()->json([
                    'message' => 'Please upload your signature.'
                ], 422);
            }
        }

        DB::beginTransaction();

        try{
            $signaturePath = null;
            if ($request->hasFile('signature')) {
                $signaturePath = $request->file('signature')->store('workflow_signatures', 'public');
            }

            //save workflow history
            // $history = Application_workflow_histories::create([
            //     'application_id' => $application->id,
            //     'user_id' => auth()->id(),
            //     'step_id' => $application->current_step_id,
            //     'remarks' => $request->remarks,
            //     'action' => 'Returned',
            //     'recommendation' => $isRecommendationOfficer
            //         ? $request->recommendation
            //         : null,
            //     'signature_path' => $signaturePath,
            // ]);

            $action = $isRecommendationOfficer ? "Not Recommended & Returned" : "Returned";

            // return to previous step
            $workflowService->return($application,auth()->user(),$request->remarks, $signaturePath, $action);

            DB::commit();

            return response()->json([
                'message' => 'Application returned successfully.'
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            \Log::error('Application returned failed', [
                'application_id' => $application->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
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
