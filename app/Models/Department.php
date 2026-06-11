<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'ministry_id', 'status'];

    // a dept belongs to one ministry
    public function ministry(){
        return $this->belongsTo(Ministry::class);
    }

    // a department has many district offices
    public function district_offices(){
        return $this->hasMany(DistrictOffice::class);
    }
}
