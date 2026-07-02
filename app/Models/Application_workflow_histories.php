<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Workflow_steps;
use App\Models\Application;
use App\Models\User;


class Application_workflow_histories extends Model
{
    protected $fillable = ['application_id', 'workflow_step_id', 'user_id','action', 'remarks'];

    public function workflowStep(){
        return $this->belongsTo(Workflow_steps::class);
    }

    public function application(){
        return $this->belongsTo(Application::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    
}
