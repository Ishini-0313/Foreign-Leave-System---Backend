<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class Office extends Model
{
    protected $fillable = ['name', 'type', 'parent_office_id', 'status'];

    public function application(){
        return $this->hasMany(Application::class);
    }
}
