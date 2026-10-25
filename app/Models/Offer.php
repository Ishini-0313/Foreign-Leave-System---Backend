<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Workflow_steps;
use App\Models\Document;
use App\Models\OfferDocuments;
use App\Models\Offer_workflow_history;
use App\Models\OfferOfficeDocument;

class Offer extends Model{
    protected $fillable = [
        'application_no',
        'user_id',

        'workflow_id',
        'current_step_id',

        'current_assigned_user_id',
        'current_assigned_office_id',
        
        'status',

        'approved_at',
        'approved_with_salary',
        
        'name',
        'position',
        'institute_id',
        'purpose',
        'nature_of_trip',
        'leave_category',
        'commencement_date_of_trainig',
        'completion_date_of_trainig',
        'departure_date',
        'return_date',
        'country',
        'signature_path',
        "leave_nature_additional" ,
        "leave_nature_warm",
        'has_letter_of_invitation_for_training',
        'has_approval_letter',
        'has_government_also_been_invited_for_training',
        'has_government_nominated_to_participate_in_it',
        'institution_designated_in_that_manner',
        'departure_time',
        'return_time',
        'provides_other_allowances_that_provide_by_awarding_institution',
        'amount_to_be_paid',
        'have_received_warm_clothing_allowance_within_five_years',
    ];

    protected $appends = ['is_editable'];

    public function getIsEditableAttribute(){
        return $this->status === "Returned";
    }

    public function applicant(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function current_step(){
        return $this->belongsTo(Workflow_steps::class, 'current_step_id');
    }

    public function documents(){
        return $this->hasMany(OfferDocuments::class);
    }

    public function officeDocuments(){
        return $this->hasMany(OfferOfficeDocument::class);
    }

    public function workflowHistories(){
        return $this->hasMany(Offer_workflow_history::class);
    }

    public function institute(){
        return $this->belongsTo(Office::class, 'institute_id');
    }

    public function approvalLetter(){
        return $this->hasOne(ApprovalLetter::class);
    }
}
