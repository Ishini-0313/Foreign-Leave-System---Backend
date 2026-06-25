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
}
