<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\Application_workflow_histories;
use App\Models\Amendment_workflow_histories;

class Workflow_steps extends Model
{
    protected $fillable = ['workflow_id', 'sequence_no', 'office_reference', 'role_id'];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function histories(){
        return $this->hasMany(Application_workflow_histories::class);
    }

    public function amendment_histories(){
        return $this->hasMany(Amendment_workflow_histories::class);
    }
}
