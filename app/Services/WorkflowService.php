<?php
namespace App\Services;

use App\Models\Workflow_steps;
use App\Models\Application;
use App\Models\Office;
use App\Models\User;
use App\Models\Application_workflow_histories;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationReturnedMail;
use App\Models\OfficeAssignment;
use App\Models\Role;
use App\Models\ApplicationOfficeDocument;
use Illuminate\Http\UploadedFile;


class WorkflowService{
    private function requiresAccountsApproval(Application $application): bool{
        return in_array($application->leave_category, [
            'leave_with_additional_offer',
            'leave_with_warm_cloths_and_additional_offer',
            'warm_cloths_and_additional_offer_only',
        ], true);
    }

    public function assignFirstStep(Application $application){
        $firstStep = Workflow_steps::where('workflow_id', $application->workflow_id)->where('office_reference', '!=', 'Applicant')->orderBy('sequence_no')->first();

        $targetOfficer = $this->resolveOfficer($application, $firstStep);

        $application->update([
            'current_step_id' => $firstStep->id,
            'current_assigned_user_id' => $targetOfficer->id,
            'current_assigned_office_id' => $targetOfficer->office_id
        ]);
    }

    public function resolveOfficer(Application $application, Workflow_steps $step){
        if($step->office_reference == 'Institute'){
            $officeId = $application->applicant->office_id;
        }elseif($step->office_reference == 'Applicant'){
            return $application->applicant;
        }else{
            $office = Office::where('name', $step->office_reference)->first();
            $officeId = $office->id;
        }
       // $user =  User::where('office_id', $officeId)->where('role_id', $step->role_id)->first();

       $assignment = OfficeAssignment::where('office_id',$officeId)->first();

        if (!$assignment) {
            throw new \Exception(
                "No user found for assignment found for office_id={$officeId}"
            );
        }

        //determine role
        $role = Role::find($step->role_id);

        if (!$role) {
            throw new \Exception(
                "Role not found: {$step->role_id}"
            );
        }

        //Resolve user
        $userId = match ($role->role_name) {
            'Subject Officer' => $assignment->subject_officer_id,

            'Check Officer' => $assignment->check_officer_id,

            'Recommended Officer' => $assignment->recommended_officer_id,

            'Recommended Officer-II' => $assignment->recommended_officer2_id,

            'Recommended Officer-III' => $assignment->recommended_officer3_id,

            'Chief Secretary' =>
        $assignment->chief_sec_id,


            'Admin' => $assignment->admin_user_id,

            default => null,
        };

        if (!$userId) {
            throw new \Exception(
                "No {$role->role_name} assigned for office_id={$officeId}"
            );
        }

        return User::findOrFail($userId);
    }

    public function forward(Application $application, User $user, ?string $remarks,?string $signaturePath, string $action,){
        $currentStep = $application->current_step;

        // check subject officer fill offie form
        if($currentStep->role_id == 2){
            if (!$application->availableLeaveInfo) {
                throw new \Exception(
                    "Please complete the 'Particulars of Available Leave' section before forwarding this application."
                );
            }

            if(!$application->officeDocuments()->exists()){
                throw new \Exception(
                    "Please upload the required documents before forwarding this application."
                );
            }
        }

        Application_workflow_histories::create([
            'application_id' => $application->id,
            'workflow_step_id' => $application->current_step_id,
            'user_id' => $user->id,
            'action' => $action,
            'remarks' => $remarks,
            'signature_path' => $signaturePath
        ]);

        $nextStep = Workflow_steps::where('workflow_id', $application->workflow_id)->where('sequence_no', $currentStep->sequence_no + 1)->first();

        if(!$nextStep){
            throw new \Exception(
                'This is the final approval step. Please use Approve.'
            );
        }

        $nextOfficer = $this->resolveOfficer($application, $nextStep);

        $application->update([
            'current_step_id' => $nextStep->id,
            'current_assigned_user_id' => $nextOfficer->id,
            'current_assigned_office_id' => $nextOfficer->office_id
        ]);
    }

    public function return(Application $application, User $user, ?string $remarks, ?string $signaturePath, string $action){
        Application_workflow_histories::create([
            'application_id' => $application->id,
            'workflow_step_id' => $application->current_step_id,
            'user_id' => $user->id,
            'action' => $action,
            'remarks' => $remarks,
            'signature_path' => $signaturePath
        ]);

        $currentStep = $application->current_step;

        $previousStep = Workflow_steps::where('workflow_id', $application->workflow_id)->where('sequence_no', $currentStep->sequence_no - 1)->first();

        if ($previousStep->office_reference == 'Applicant') {
            $application->update([
                'current_step_id' => $previousStep->id,
                'current_assigned_user_id' => $application->user_id,
                'current_assigned_office_id' => null,
                'status' => 'Returned'
            ]);

            Mail::to($application->applicant->email)->send(new ApplicationReturnedMail($application));

            
            return response()->json([
                'message' => 'Application Returned to applicant'
            ]);
        }

        if (!$previousStep) {
            throw new \Exception("Cannot return from the first workflow step.");
        }

        // Find officer for previous step
        $previousOfficer = $this->resolveOfficer($application, $previousStep);

        // Update application
        $application->update([
            'current_step_id' => $previousStep->id,
            'current_assigned_user_id' => $previousOfficer->id,
            'current_assigned_office_id' => $previousOfficer->office_id,
            'status' => 'Pending'
        ]);
    }

    public function approve(Application $application,User $user,?string $remarks, ?string $signaturePath, string $action){
        $currentStep = $application->current_step;

        if (!$currentStep) {
            throw new \Exception(
                'Current workflow step not found.'
            );
        }

        // Create approval history for current step
        Application_workflow_histories::create([
            'application_id' => $application->id,
            'workflow_step_id' => $application->current_step_id,
            'user_id' => $user->id,
            'action' => $action,
            'remarks' => $remarks ?? '-',
            'signature_path' => $signaturePath
        ]);

        //Check whether this is Chief Secretary
        $isChiefSecretary =
            $currentStep->role?->role_name === 'Chief Secretary';

        //Chief Secretary approved
        if($isChiefSecretary && requiresAccountsApproval()){

            //Find Accounts Officer workflow step
            $accountsStep = Workflow_steps::where('workflow_id', $application->workflow_id)
                ->where('office_reference', 'ගිණුම් අංශය')
                ->whereHas('role', function ($query) {
                    $query->where('role_name', 'Accountant');
                })
                ->orderBy('sequence_no')
                ->first();

            if (!$accountsStep) {
                throw new \Exception(
                    'Accounts Officer workflow step not found.'
                );
            }

            //Find Accountant user
            $accountsOffice = Office::where(
                'name',
                'ගිණුම් අංශය'
            )->first();


            if (!$accountsOffice) {
                throw new \Exception(
                    'ගිණුම් අංශය office not found.'
                );
            }

            $accountsOfficer = User::where('office_id',$accountsOffice->id)
                ->whereHas('designation', function ($query) {
                    $query->where(
                        'name',
                        'ගණකාධිකාරී'
                    );
                })
                ->first();

            if (!$accountsOfficer) {
                throw new \Exception(
                    'ගණකාධිකාරී not assigned in ගිණුම් අංශය.'
                );
            }

            //Forward application to Accounts Officer
            $application->update([
                'status' => 'Pending',
                'current_step_id' => $accountsStep->id,
                'current_assigned_user_id' => $accountsOfficer->id,
                'current_assigned_office_id' => $accountsOffice->id,
            ]);

            return;
        }

        //normal final approval
        $nextStep = Workflow_steps::where(
            'workflow_id',
            $application->workflow_id
        )
        ->where(
            'sequence_no',
            '>',
            $currentStep->sequence_no
        )
        ->orderBy('sequence_no')
        ->first();

        if ($nextStep) {
            throw new \Exception(
                'This application is not at the final approval step.'
            );
        }
        
        // if($action == "Approved with salary"){
        //     $approved_with_salary = 1;
        // }else{
        //     $approved_with_salary = 0;
        // }

        $approvedWithSalary =
            $action === 'Approved with salary' ? 1 : 0;

        // Mark application approved
        $application->update([
            'status' => 'Approved',
            'approved_with_salary' => $approved_with_salary,
            'approved_at' => now(),
            'current_assigned_user_id' => null,
            'current_assigned_office_id' => null,
        ]);
    }
}


