<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workflow_steps extends Model
{
    protected $fillable = ['workflow_id', 'sequence_no', 'office_id', 'role_id'];
}
