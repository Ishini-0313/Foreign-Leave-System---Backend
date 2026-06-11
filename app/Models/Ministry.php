<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ministry extends Model
{
    protected $fillable = ['name','status'];

    // a ministry has many depatments
    public function departments(){
        return $this->hasMany(Department::class);
    }
}
