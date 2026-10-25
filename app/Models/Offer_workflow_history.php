<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Workflow_steps;
use App\Models\Offer;
use App\Models\User;

class Offer_workflow_history extends Model
{
    protected $fillable = ['offer_id', 'workflow_step_id', 'user_id','action', 'remarks', 'signature_path'];

    public function workflowStep(){
        return $this->belongsTo(Workflow_steps::class);
    }

    public function offer(){
        return $this->belongsTo(Offer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
