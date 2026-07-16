<?php
namespace App\Services;

use App\Models\Workflow_steps;
use App\Models\Application_amendments;
use App\Models\Office;
use App\Models\User;
use App\Models\Amendment_workflow_histories;


class AmendentWorkflowService{
    public function assignFirstStep(Application_amendments $amendent){
        $firstStep = Workflow_steps::where('workflow_id', $amendent->workflow_id)->where('office_reference', '!=', 'Applicant')->orderBy('sequence_no')->first();

        $targetOfficer = $this->resolveOfficer($amendent, $firstStep);

        $amendent->update([
            'current_step_id' => $firstStep->id,
            'current_assigned_user_id' => $targetOfficer->id,
            'current_assigned_office_id' => $targetOfficer->office_id
        ]);
    }

    public function resolveOfficer(Application_amendments $amendent, Workflow_steps $step){
        if($step->office_reference == 'Institute'){
            $officeId = $amendent->application->applicant->office_id;
        }else{
            $office = Office::where('name', $step->office_reference)->first();
            $officeId = $office->id;
        }
        $user =  User::where('office_id', $officeId)->where('role_id', $step->role_id)->first();

        if (!$user) {
            throw new \Exception(
                "No user found for office_id={$officeId}, role_id={$step->role_id}"
            );
        }

        return $user;
    }

    public function forward(Application_amendments $amendent, User $user, ?string $remarks){
        $currentStep = $amendent->current_step;
        
        Amendment_workflow_histories::create([
            'amendment_id' => $amendent->id,
            'workflow_step_id' => $amendent->current_step_id,
            'user_id' => $user->id,
            'action' => 'Forwarded',
            'remarks' => $remarks
        ]);

        $nextStep = Workflow_steps::where('workflow_id', $amendent->workflow_id)->where('sequence_no', $currentStep->sequence_no + 1)->first();

        if(!$nextStep){
            $amendent->update([
                'status' => 'Approved',
                'approved_at' => now(),
                'current_assigned_user_id'=>null,
                'current_assigned_office_id'=>null
            ]);

            return;
        }

        $nextOfficer = $this->resolveOfficer($amendent, $nextStep);

        $amendent->update([
            'current_step_id' => $nextStep->id,
            'current_assigned_user_id' => $nextOfficer->id,
            'current_assigned_office_id' => $nextOfficer->office_id
        ]);
    }

    public function return(Application_amendments $amendent, User $user, ?string $remarks){
        Amendment_workflow_histories::create([
            'amendment_id' => $amendent->id,
            'workflow_step_id' => $amendent->current_step_id,
            'user_id' => $user->id,
            'action' => 'Returned',
            'remarks' => $remarks
        ]);

        $currentStep = $amendent->current_step;

        $previousStep = Workflow_steps::where('workflow_id', $amendent->workflow_id)->where('sequence_no', $currentStep->sequence_no - 1)->first();

        if (!$previousStep) {
            throw new \Exception("Cannot return from the first workflow step.");
        }

        // Find officer for previous step
        $previousOfficer = $this->resolveOfficer($amendent, $previousStep);

        // Update application
        $amendent->update([
            'current_step_id' => $previousStep->id,
            'current_assigned_user_id' => $previousOfficer->id,
            'current_assigned_office_id' => $previousOfficer->office_id,
            'status' => 'Pending'
        ]);
    }


}


