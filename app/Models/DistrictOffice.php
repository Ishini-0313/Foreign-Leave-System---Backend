<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistrictOffice extends Model
{
    protected $fillable = ['name', 'dept_id', 'status'];

    // a district office belongs to a department
    public function department(){
        return $this->belongsTo(Department::class);
    }
}
