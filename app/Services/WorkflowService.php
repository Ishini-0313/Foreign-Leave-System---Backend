<?php
namespace App\Services;

use App\Models\Workflow_steps;
use App\Models\Application;
use App\Models\Office;
use App\Models\User;
use App\Models\Application_workflow_histories;

class WorkflowService{
    public function assignFirstStep(Application $application){
        $firstStep = Workflow_steps::where('workflow_id', $application->workflow_id)->orderBy('sequence_no')->first();

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

    public function forward(Application $application, User $user, ?string $remarks){
        Application_workflow_histories::create([
            'application_id' => $application->id,
            'workflow_step_id' => $application->current_step_id,
            'user_id' => $user->id,
            'action' => 'Forwarded',
            'remarks' => $remarks
        ]);

        $currentStep = $application->current_step;

        $nextStep = Workflow_steps::where('workflow_id', $application->workflow_id)->where('sequence_no', $currentStep->sequence_no + 1)->first();

        if(!$nextStep){
            $application->update([
                'status' => 'Approved',
                'approved_at' => now(),
                'current_assigned_user_id'=>null,
                'current_assigned_office_id'=>null
            ]);

            return;
        }

        $nextOfficer = $this->resolveOfficer($application, $nextStep);

        $application->update([
            'current_step_id' => $nextStep->id,
            'current_assigned_user_id' => $nextOfficer->id,
            'current_assigned_office_id' => $nextOfficer->office_id
        ]);
    }

    public function return(Application $application, User $user, ?string $remarks){
        Application_workflow_histories::create([
            'application_id' => $application->id,
            'workflow_step_id' => $application->current_step_id,
            'user_id' => $user->id,
            'action' => 'Returned',
            'remarks' => $remarks
        ]);

        $currentStep = $application->current_step;

        $previousStep = Workflow_steps::where('workflow_id', $application->workflow_id)->where('sequence_no', $currentStep->sequence_no - 1)->first();

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

}


