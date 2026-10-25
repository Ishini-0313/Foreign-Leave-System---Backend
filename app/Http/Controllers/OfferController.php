<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\WarmClothOffer;
use App\Models\AdditionalOffer;
use App\Services\OfferWorkflowService;
use App\Models\Document;
use App\Models\Office;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Workflow_steps;
use App\Models\Offer;
use App\Models\Offer_workflow_history;
use Illuminate\Support\Facades\Mail;
use App\Models\OfferDocuments;
use App\Mail\ApplicationSubmittedMail;

class OfferController extends Controller
{
    public function save_additonal(Request $request, $id){
        $application = Application::findOrFail($id);
        $user = auth()->user();

        // Check current responsible officer
        if ($application->current_assigned_user_id != $user->id) {
            return response()->json([
                'message' => 'You are not currently responsible for this application.'
            ], 403);
        }

        // Check Subject Officer
        if ($user->role?->role_name !== 'Subject Officer') {
            return response()->json([
                'message' => 'Only the Subject Officer can fill this section.'
            ], 403);
        }

        // Check applicant's institute
        if ($user->office_id != $application->institute_id) {
            return response()->json([
                'message' => 'You are not the Subject Officer of the applicant\'s institute.'
            ], 403);
        }

        $request->validate([
            'no_of_days' => 'required|integer|min:0',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $additionalOffer = AdditionalOffer::updateOrCreate(
            [
                'application_id' => $application->id,
            ],
            [
                'no_of_days' => $request->no_of_days,
                'total_additional_offer' => $request->total_amount,
                'created_by' => auth()->id(),
            ]
        );
        
        return response()->json([
            'message' => 'Saved successfully!',
            'additional_offer' => $additionalOffer,
        ]);
    }

    public function save_warmcloth(Request $request, $id){
        $application = Application::findOrFail($id);
        $user = auth()->user();

        // Check current responsible officer
        if ($application->current_assigned_user_id != $user->id) {
            return response()->json([
                'message' => 'You are not currently responsible for this application.'
            ], 403);
        }

        // Check Subject Officer
        if ($user->role?->role_name !== 'Subject Officer') {
            return response()->json([
                'message' => 'Only the Subject Officer can fill this section.'
            ], 403);
        }

        // Check applicant's institute
        if ($user->office_id != $application->institute_id) {
            return response()->json([
                'message' => 'You are not the Subject Officer of the applicant\'s institute.'
            ], 403);
        }

        $request->validate([
            'is_country_in_the_northern_hemisphere' => 'required',
            'north_latitude' => 'required',
            'is_country_in_the_southern_hemisphere' => 'required',
            'south_latitude'=> 'required',
            'situated_more_than_5000_feet_above_sea_level' => 'required',
            'height' => 'required',
        ]);

        $warmClothOffer = WarmClothOffer::updateOrCreate(
            [
                'application_id' => $application->id,
            ],
            [
                'is_country_in_the_northern_hemisphere' => $request->is_country_in_the_northern_hemisphere,
                'north_latitude' => $request->north_latitude,
                'is_country_in_the_southern_hemisphere' => $request->is_country_in_the_southern_hemisphere,
                'south_latitude'=> $request->south_latitude,
                'situated_more_than_5000_feet_above_sea_level' => $request->situated_more_than_5000_feet_above_sea_level,
                'height' => $request->height,
                'created_by' => auth()->id(),
            ]
        );

        return response()->json([
            'message' => 'Saved successfully!',
            'warm_cloth_offer' => $warmClothOffer,
        ]);
    }

    public function store_offer_req(Request $request, OfferWorkflowService $workflowService){
        DB::beginTransaction();
        
        try{
            $user = auth()->user();
            $office_id = $request->institute_id;

            if(!$office_id){
                throw new \Exception('Institute/office ID is required');
            }

            $office = Office::find($office_id);

            if (!$office) {
                throw new \Exception('Institute/office not found');
            }

            $workflow_id = $office->workflow_template_id;

            if (!$workflow_id) {
                throw new \Exception('No workflow is assigned to this institute/office');
            }

            $first_step = Workflow_steps::where('workflow_id',$workflow_id)->orderBy('sequence_no')->first();

            $application = Offer::create([
                "application_no" => 'FLM-' . now()->format('YmdHis'),
                "user_id" => auth()->id(),

                "workflow_id" => $workflow_id,
                "current_step_id" => $first_step->id,

                "nature_of_trip" => $request->nature_of_trip,
                'leave_category' => $request->leave_category,

                "status" => "Pending",

                "name" => $request->name,
                "institute_id" => $request->institute_id,
                "position" => $request->position,
                "purpose" => $request->purpose,
                "leave_nature_additional" => $request->leave_nature_additional,
                "leave_nature_warm" => $request->leave_nature_warm,
                "country" => $request->country,
                "has_letter_of_invitation_for_training" => $request->has_letter_of_invitation_for_training,
                "has_approval_letter" => $request->has_approval_letter,
                "has_government_also_been_invited_for_training" => $request->has_government_also_been_invited_for_training,
                "has_government_nominated_to_participate_in_it" => $request->has_government_nominated_to_participate_in_it,
                "institution_designated_in_that_manner" => $request->institution_designated_in_that_manner,
                "commencement_date_of_trainig" => $request->commencement_date_of_trainig,
                "completion_date_of_trainig" => $request->completion_date_of_trainig,
                "departure_date" => $request->departure_date,
                "return_date" => $request->return_date,
                "departure_time" => $request->departure_time,
                "return_time" => $request->return_time,
                "provides_other_allowances_that_provide_by_awarding_institution" => $request->provides_other_allowances_that_provide_by_awarding_institution,
                "amount_to_be_paid" => $request->amount_to_be_paid,
                "have_received_warm_clothing_allowance_within_five_years" => $request->have_received_warm_clothing_allowance_within_five_years,
            ]);

            $workflowService->assignFirstStep($application);

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
                'duty_cover_letter',
                'passport_copy',
                'flight_details',
                'request_letter',
                'letter_stating_that_allowances_will_not_be_paid',
            ];

            foreach ($documentFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $path = $request->file($field)->store('documents', 'public');

                    OfferDocuments::create([
                        'offer_id' => $application->id,
                        'document_type' => $field,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                    ]);
                }
            }

            Offer_workflow_history::create([
                'offer_id' => $application->id,
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

    public function restore_offer_req(Request $request, $id, OfferWorkflowService $workflowService){
        DB::beginTransaction();
        try{
            // find existing application
            $application = Offer::findOrFail($id);

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
                "application_no" => 'FLM-' . now()->format('YmdHis'),
                "user_id" => auth()->id(),

                "workflow_id" => $workflow_id,
                "current_step_id" => $first_step->id,

                "nature_of_trip" => $request->nature_of_trip,
                'leave_category' => $request->leave_category,

                "status" => "Pending",

                "name" => $request->name,
                "institute_id" => $request->institute_id,
                "position" => $request->position,
                "purpose" => $request->purpose,
                "leave_nature_additional" => $request->leave_nature_additional,
                "leave_nature_warm" => $request->leave_nature_warm,
                "country" => $request->country,
                "has_letter_of_invitation_for_training" => $request->has_letter_of_invitation_for_training,
                "has_approval_letter" => $request->has_approval_letter,
                "has_government_also_been_invited_for_training" => $request->has_government_also_been_invited_for_training,
                "has_government_nominated_to_participate_in_it" => $request->has_government_nominated_to_participate_in_it,
                "institution_designated_in_that_manner" => $request->institution_designated_in_that_manner,
                "commencement_date_of_trainig" => $request->commencement_date_of_trainig,
                "completion_date_of_trainig" => $request->completion_date_of_trainig,
                "departure_date" => $request->departure_date,
                "return_date" => $request->return_date,
                "departure_time" => $request->departure_time,
                "return_time" => $request->return_time,
                "provides_other_allowances_that_provide_by_awarding_institution" => $request->provides_other_allowances_that_provide_by_awarding_institution,
                "amount_to_be_paid" => $request->amount_to_be_paid,
                "have_received_warm_clothing_allowance_within_five_years" => $request->have_received_warm_clothing_allowance_within_five_years,  
            ]);

            $documentFields = [
                'invitation_letter',
                'service_confirmation',
                'duty_cover_letter',
                'passport_copy',
                'flight_details',
                'request_letter',
                'letter_stating_that_allowances_will_not_be_paid',
            ];

            foreach($documentFields as $field){
                if($request->hasFile($field)){

                    $old = OfferDocuments::where(
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

                    OfferDocuments::create([
                        'offer_id'=>$application->id,
                        'document_type'=>$field,
                        'file_name'=>$file->getClientOriginalName(),
                        'file_path'=>$path,
                    ]);
                }
            }


            Offer_workflow_history::create([
                'offer_id' => $application->id,
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

    public function myApplication(){
        $application = Offer::with(['institute'])->where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->get();

        return response()->json($application);
    }

    public function show($application_no){
        $application = Offer::with([
            'documents',
            // 'officeDocuments',
            'institute',
            'current_step.role',
            //'warmClothOffer',
            //'additionalOffer'
        ])->where('application_no', $application_no)->firstOrFail();

        $currentStep = $application->current_step;
        $isFinalStep = false;
        if($currentStep){
            $hasNextStep = Workflow_steps::where('workflow_id',$application->workflow_id)->where('sequence_no','>',$currentStep->sequence_no)->exists();
            $isFinalStep = !$hasNextStep;
        }

        return response()->json([
            'application' => $application,
            'warm_cloth_offer' => $application->warmClothOffer,
            'is_final_step' => $isFinalStep
        ]);
    }

    public function documents($application_no){
        $application = Offer::with([
            'documents',
            'officeDocuments'
        ])->where('application_no', $application_no)->firstOrFail();

        $documents = $application->documents
            ->map(function ($document) {
                $document->uploaded_by_type = 'applicant';
                return $document;
            })
            ->concat(
                $application->officeDocuments->map(function ($document) {
                    $document->uploaded_by_type = 'subject_officer';
                    return $document;
                })
            )
            ->values();

        return response()->json($documents);
    }

}
