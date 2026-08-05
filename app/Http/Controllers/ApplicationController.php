<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\GOSL_funds;
use App\Models\Previous_travel;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Workflow_steps;
use App\Services\WorkflowService;
use App\Models\Application_workflow_histories;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationSubmittedMail;
use App\Models\Workflow_template;

class ApplicationController extends Controller
{
    public function store(Request $request, WorkflowService $workflowService){
        DB::beginTransaction();
        
        try{
            $user = auth()->user();
            $office = $user->office;

            if(!$office){
                throw new \Exception('User office not assigned');
            }

            if($request->service_id == "ශ්‍රී ලංකා පරිපාලන සේවය"  && $request->class_or_grade == "විශේෂ ශ්‍රේණිය" ){
                $workflow_id = Workflow_template::where(
                    'workflow_name',
                    'Special Grade Workflow'
                )->value('id');
            }else{
                $workflow_id = $office->workflow_template_id;
            }
            
            $first_step = Workflow_steps::where('workflow_id',$workflow_id)->orderBy('sequence_no')->first();

            $application = Application::create([
                "application_no" => 'FLM-' . now()->format('YmdHis'),
                "user_id" => auth()->id(),

                "workflow_id" => $workflow_id,
                "current_step_id" => $first_step->id,

                "status" => "Pending",

                "name" => $request->name,
                "position" => $request->position,
                "service_id" => $request->service_id,

                "dob" => $request->dob,
                "nic" => $request->nic,

                "ministry_id" => $request->ministry_id,
                "institute_id" => $request->institute_id,

                "arrangement_made_to_cover_duty" => $request->arrangement_made_to_cover_duty,

                "purpose" => $request->purpose,
                "nature_of_trip" => $request->nature_of_trip,
                'leave_category' => $request->leave_category,
                "awarding_agency" => $request->awarding_agency,
                "expenses_mainly_to_be_met" => $request->expenses_mainly_to_be_met,
                "foreign_loan_project_particulars_thereof" => $request->foreign_loan_project_particulars_thereof,
                "commencement_date_of_trainig" => $request->commencement_date_of_trainig,
                "completion_date_of_trainig" => $request->completion_date_of_trainig,
                "departure_date" => $request->departure_date,
                "return_date" => $request->return_date,
                "country" => $request->country,
                "foreign_address" => $request->foreign_address,
                "foreign_phone" => $request->foreign_phone,
                "foreign_fax" => $request->foreign_fax,
                "foreign_email" => $request->foreign_email,
                "has_previous_trip_report_submitted" => $request->boolean('has_previous_trip_report_submitted'),
                
                "name_and_designation"=> $request->name_and_designation,
                "class_or_grade" => $request->class_or_grade,
                "first_appoinment_date"=> $request->first_appoinment_date,
                "last_return_date" => $request->last_return_date,
                "leave_start_date"=> $request->leave_start_date,
                "leave_end_date" => $request->leave_end_date,
                "reason_for_leave"=> $request->reason_for_leave,
                "is_travel_on_a_pre_paid_ticket" => $request->is_travel_on_a_pre_paid_ticket,
                "relationship_of_the_person_sending_it"=> $request->relationship_of_the_person_sending_it,
                "cost_maintanence_abroad" => $request->cost_maintanence_abroad,
                "relationship_of_person_meeting_expenditure"=> $request->relationship_of_person_meeting_expenditure,
            ]);

            $workflowService->assignFirstStep($application);

            // Save GOSL Funds
            $funds = json_decode($request->goslFunds, true);

            GOSL_funds::create([
                'application_id' => $application->id,

                'air_travel_selected' => $funds['air_travel']['selected'],
                'air_travel_amount' => $funds['air_travel']['amount']?: 0,

                'subsistence_selected' => $funds['subsistence']['selected'],
                'subsistence_amount' => $funds['subsistence']['amount']?: 0,

                'course_fees_selected' => $funds['course_fees']['selected'],
                'course_fees_amount' => $funds['course_fees']['amount']?: 0,

                'additional_expenses_selected' => $funds['additional_expenses']['selected'],
                'additional_expenses_amount' => $funds['additional_expenses']['amount']?: 0,

                'other_personal_expenses_selected' => $funds['other_personal_expenses']['selected'],
                'other_personal_expenses_amount' => $funds['other_personal_expenses']['amount']?: 0,
            ]);

            // Save Previous Travels
            $travels = json_decode(
                $request->previousTravels,
                true
            );

            foreach ($travels as $travel) {

                Previous_travel::create([
                    'application_id' => $application->id,
                    'year' => $travel['year'],
                    'purpose' => $travel['purpose'],
                    'period' => $travel['period'],
                    'country' => $travel['country'],
                ]);
            }

            // Save Signature
            // if ($request->signature) {

            //     $signature = $request->signature;

            //     $signature = str_replace(
            //         'data:image/png;base64,',
            //         '',
            //         $signature
            //     );

            //     $signature = str_replace(
            //         ' ',
            //         '+',
            //         $signature
            //     );

            //     $signaturePath = 'signatures/'.$application->id.'.png';

            //     Storage::disk('public')->put(
            //         $signaturePath,base64_decode($signature)
            //     );

            //     $application->signature_path = $signaturePath;
            //     $application->save();
            // }

            if ($request->hasFile('signature')) {
                $file = $request->file('signature');
                $path = $file->storeAs(
                    'signatures',
                    $application->id . '.' . $file->getClientOriginalExtension(),
                    'public'
                );
                $application->signature_path = $path;
                $application->save();
            }

            // Save Documents
            $documentFields = [
                'invitation_letter',
                'service_confirmation',
                'southern_absorption',
                'duty_cover_letter',
                'passport_copy',
                'flight_details',
                'request_letter',
                'disciplinary_clearance',
                'agreement'
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

                    Document::create([
                        'application_id' => $application->id,
                        'document_type' => $field,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                    ]);
                }
            }

            Application_workflow_histories::create([
                'application_id' => $application->id,
                'workflow_step_id' => $application->current_step_id,
                'user_id' => $application->user_id,
                'action' => 'Submited',
                'remarks' => '-'
            ]);

        
            DB::commit();

            Mail::to($user->email)->send(new ApplicationSubmittedMail($application));

            return response()->json([
                'message' => 'Application Submitted successfully'
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

    public function restore(Request $request, $id, WorkflowService $workflowService){
        DB::beginTransaction();
        try{
            // find existing application
            $application = Application::findOrFail($id);

            // security
            if($application->user_id != auth()->id()){
                return response()->json([
                    "message" => "Unauthorized !"
                ], 403);
            }

            // only returned application can be edited
            if($application->status !== "Returned"){
                return response()->json([
                    "message" => "This application cannot be edited."
                ], 400);
            }

            $first_step = Workflow_steps::where('workflow_id', $application->workflow_id)->orderBy('sequence_no')->first();

            // update application
            $application->update([
                "current_step_id" => $first_step->id,

                "status" => "Pending",

                "name" => $request->name,
                "position" => $request->position,
                "service_id" => $request->service_id,

                "dob" => $request->dob,
                "nic" => $request->nic,

                "ministry_id" => $request->ministry_id,
                "institute_id" => $request->institute_id,

                "arrangement_made_to_cover_duty" => $request->arrangement_made_to_cover_duty,

                "purpose" => $request->purpose,
                "nature_of_trip" => $request->nature_of_trip,
                "awarding_agency" => $request->awarding_agency,
                "expenses_mainly_to_be_met" => $request->expenses_mainly_to_be_met,
                "foreign_loan_project_particulars_thereof" => $request->foreign_loan_project_particulars_thereof,
                "commencement_date_of_trainig" => $request->commencement_date_of_trainig,
                "completion_date_of_trainig" => $request->completion_date_of_trainig,
                "departure_date" => $request->departure_date,
                "return_date" => $request->return_date,
                "country" => $request->country,
                "foreign_address" => $request->foreign_address,
                "foreign_phone" => $request->foreign_phone,
                "foreign_fax" => $request->foreign_fax,
                "foreign_email" => $request->foreign_email,
                "has_previous_trip_report_submitted" => $request->boolean('has_previous_trip_report_submitted'),
                
                "name_and_designation"=> $request->name_and_designation,
                "class_or_grade" => $request->class_or_grade,
                "first_appoinment_date"=> $request->first_appoinment_date,
                "last_return_date" => $request->last_return_date,
                "leave_start_date"=> $request->leave_start_date,
                "leave_end_date" => $request->leave_end_date,
                "reason_for_leave"=> $request->reason_for_leave,
                "is_travel_on_a_pre_paid_ticket" => $request->is_travel_on_a_pre_paid_ticket,
                "relationship_of_the_person_sending_it"=> $request->relationship_of_the_person_sending_it,
                "cost_maintanence_abroad" => $request->cost_maintanence_abroad,
                "relationship_of_person_meeting_expenditure"=> $request->relationship_of_person_meeting_expenditure,
            ]);

            $funds = json_decode($request->goslFunds,true);

            $application->goslFunds()->update([
                'air_travel_selected'=>$funds['air_travel']['selected'],
                'air_travel_amount'=>$funds['air_travel']['amount']?:0,

                'subsistence_selected'=>$funds['subsistence']['selected'],
                'subsistence_amount'=>$funds['subsistence']['amount']?:0,

                'course_fees_selected'=>$funds['course_fees']['selected'],
                'course_fees_amount'=>$funds['course_fees']['amount']?:0,

                'additional_expenses_selected'=>$funds['additional_expenses']['selected'],
                'additional_expenses_amount'=>$funds['additional_expenses']['amount']?:0,

                'other_personal_expenses_selected'=>$funds['other_personal_expenses']['selected'],
                'other_personal_expenses_amount'=>$funds['other_personal_expenses']['amount']?:0,
            ]);

            Previous_travel::where('application_id',$application->id)->delete();

            $travels=json_decode($request->previousTravels,true);

            foreach($travels as $travel){
                Previous_travel::create([
                    'application_id'=>$application->id,
                    'year'=>$travel['year'],
                    'purpose'=>$travel['purpose'],
                    'period'=>$travel['period'],
                    'country'=>$travel['country'],
                ]);
            }

            $documentFields = [
                'invitation_letter',
                'service_confirmation',
                'southern_absorption',
                'duty_cover_letter',
                'passport_copy',
                'flight_details',
                'request_letter',
                'disciplinary_clearance',
                'agreement'
            ];

            foreach($documentFields as $field){
                if($request->hasFile($field)){

                    $old = Document::where(
                        'application_id',
                        $application->id
                    )->where(
                        'document_type',
                        $field
                    )->first();

                    if($old){

                        Storage::disk('public')->delete($old->file_path);
                        $old->delete();
                    }

                    $file=$request->file($field);

                    $path=$file->store(
                        'documents',
                        'public'
                    );

                    Document::create([
                        'application_id'=>$application->id,
                        'document_type'=>$field,
                        'file_name'=>$file->getClientOriginalName(),
                        'file_path'=>$path,
                    ]);
                }
            }

            // Application_workflow_histories::where(
            //     'application_id',
            //     $application->id
            // )->delete();

            Application_workflow_histories::create([
                'application_id' => $application->id,
                'workflow_step_id' => $application->current_step_id,
                'user_id' => $application->user_id,
                'action' => 'Resubmited',
                'remarks' => '-'
            ]);

            $workflowService->assignFirstStep($application);

            DB::commit();

            return response()->json([
                'message'=>'Application resubmitted successfully.'
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

    public function generateGeneral126($id){
        $application = Application::with([
            'goslFunds',
            'previousTravels',
            'documents'
        ])->findOrFail($id);

        $pdf = Pdf::loadView(
            'pdf.general126',
            compact('application')
        );

        return $pdf->download(
            'General126-'.$application->application_no.'.pdf'
        );
    }

    public function show($id){
        $application = Application::with([
            'goslFunds',
            'previousTravels',
            'documents',
            'ministry',
            'institute',
            'availableLeaveInfo',
            'current_step.role',
            'amendments'
        ])->findOrFail($id);

        $currentStep = $application->current_step;
        $isFinalStep = false;
        if($currentStep){
            $hasNextStep = Workflow_steps::where('workflow_id',$application->workflow_id)->where('sequence_no','>',$currentStep->sequence_no)->exists();
            $isFinalStep = !$hasNextStep;
        }

        return response()->json([
            'application' => $application,
            'is_final_step' => $isFinalStep
        ]);
    }

    public function myApplication(){
        $application = Application::with(['institute','amendments'])->where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->get();

        return response()->json($application);
    }

    public function documents($id){
        $application = Application::with('documents')->findOrFail($id);

        return response()->json(
            $application->documents
        );
    }

    
}
