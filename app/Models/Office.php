<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = ['name', 'type', 'parent_office_id', 'status'];

    

}
