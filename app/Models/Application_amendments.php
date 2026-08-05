<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Application;
use App\Models\Workflow_steps;
use App\Models\Amendment_workflow_histories;
use App\Models\Office;
use App\Models\AmendmentDocuments;

class Application_amendments extends Model
{
    protected $fillable = [
        'application_id',
        'new_leave_start_date',
        'new_leave_end_date',
        'reason_for_change',
        'workflow_id',
        'current_step_id',
        'current_assigned_user_id',
        'current_assigned_office_id',
        'status',
        'approved_at'
    ];

    public function application(){
        return $this->belongsTo(Application::class);
    }

    public function current_step(){
        return $this->belongsTo(Workflow_steps::class, 'current_step_id');
    }

    public function workflowHistories(){
        return $this->hasMany(Amendment_workflow_histories::class, "amendment_id");
    }

    public function documents(){
        return $this->hasMany(AmendmentDocuments::class, 'amendment_id', 'id');
    }
}
