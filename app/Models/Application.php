<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'application_no',
        'user_id',
        // 'workflow_id',
        // 'current_step_id',

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
}
