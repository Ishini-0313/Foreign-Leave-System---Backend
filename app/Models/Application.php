<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Workflow_template;
use App\Models\GOSL_funds;
use App\Models\Previous_travel;
use App\Models\Document;
use App\Models\Application_workflow_histories;
use App\Models\Office;
use App\Models\Workflow_steps;

class Application extends Model
{
    protected $fillable = [
        'application_no',
        'user_id',

        'workflow_id',
        'current_step_id',

        'current_assigned_user_id',
        'current_assigned_office_id',
        
        'status',

        'approved_at',
        
        'name',
        'position',
        'service_id',

        'dob',
        'nic',
        
        'ministry_id',
        'institute_id',

        'arrangement_made_to_cover_duty',

        'purpose',
        'nature_of_trip',
        'awarding_agency',
        'expenses_mainly_to_be_met',
        'foreign_loan_project_particulars_thereof',
        'commencement_date_of_trainig',
        'completion_date_of_trainig',
        'departure_date',
        'return_date',
        'country',
        'foreign_address',
        'foreign_phone',
        'foreign_fax',
        'foreign_email',
        'has_previous_trip_report_submitted',

        'name_and_designation',
        'class_or_grade',
        'first_appoinment_date',
        'last_return_date',
        'leave_start_date',
        'leave_end_date',
        'reason_for_leave',
        'is_travel_on_a_pre_paid_ticket',
        'relationship_of_the_person_sending_it',
        'cost_maintanence_abroad',
        'relationship_of_person_meeting_expenditure',

        'signature_path'
    ];

    public function applicant(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function current_step(){
        return $this->belongsTo(Workflow_steps::class, 'current_step_id');
    }

    public function goslFunds(){
        return $this->hasMany(GOSL_funds::class);
    }

    public function previousTravels(){
        return $this->hasMany(Previous_travel::class);
    }

    public function documents(){
        return $this->hasMany(Document::class);
    }

    public function workflowHistories(){
        return $this->hasMany(Application_workflow_histories::class);
    }

    public function ministry(){
        return $this->belongsTo(Office::class, 'ministry_id');
    }

    public function institute(){
        return $this->belongsTo(Office::class, 'institute_id');
    }
}

