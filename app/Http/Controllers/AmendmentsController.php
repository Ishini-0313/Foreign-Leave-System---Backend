<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AmendentWorkflowService;
use App\Models\Workflow_steps;
use App\Models\Application_amendments;
use App\Models\AmendmentDocuments;
use Illuminate\Support\Facades\DB;

class AmendmentsController extends Controller
{
    public function store(Request $request, AmendentWorkflowService $workflowService){
        DB::beginTransaction();

        try{
            $user = auth()->user();
            $office = $user->office;
            $workflow_id = $office->workflow_template_id;
            $first_step = Workflow_steps::where('workflow_id',$workflow_id)->orderBy('sequence_no')->first();

            $amendment = Application_amendments::create([
                'application_id' => $request->application_id,
                'new_leave_start_date' => $request->new_leave_start_date,
                'new_leave_end_date' => $request->new_leave_end_date,
                'reason_for_change' => $request->reason,
                'workflow_id' => $workflow_id,
                'current_step_id'=> $first_step->id,
                'status' => 'Pending',
            ]);

            $workflowService->assignFirstStep($amendment);

            $documentFields = [
                'request_letter',
                'foreign_leave_approval_letter',
                'flight_details',
                'confirmation_of_reason',
            ];

            foreach ($documentFields as $field) {

                if ($request->hasFile($field)) {

                    $file = $request->file($field);

                    $path = $request
                        ->file($field)
                        ->store(
                            'documents',
                            'public'
                        );

                    AmendmentDocuments::create([
                        'amendment_id' => $amendment->id,
                        'document_type' => $field,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Application Amendments Submitted'
            ]);

            
        }catch(\Exception $e){
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    public function getAmendments($application_id){
        $amendment = Application_amendments::with(['application'])->where(
            'application_id',
            $application_id
        )
        ->get();

        return response()->json($amendment);
    }
}
