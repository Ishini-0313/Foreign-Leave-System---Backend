<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Workflow_steps;
use App\Models\Application;


class Application_workflow_histories extends Model
{
    protected $fillable = ['application_id', 'workflow_step_id', 'acted_by','action', 'remarks'];

    public function workflowStep(){
        return $this->belongsTo(Workflow_steps::class);
    }

    public function application(){
        return $this->belongsTo(Application::class);
    }
    
}
