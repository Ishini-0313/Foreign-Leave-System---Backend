<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\UserOfficeRole;

class Role extends Model
{
    protected $fillable = [
        'role_name'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function userOfficeRoles()
    {
        return $this->hasMany(UserOfficeRole::class);
    }
}
