<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Workflow_steps;
use App\Models\Application_amendments;
use App\Models\User;

class Amendment_workflow_histories extends Model
{
    protected $fillable = ['amendment_id', 'workflow_step_id', 'user_id','action', 'remarks'];

    public function workflowStep(){
        return $this->belongsTo(Workflow_steps::class);
    }

    public function amendment(){
        return $this->belongsTo(Application_amendments::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
