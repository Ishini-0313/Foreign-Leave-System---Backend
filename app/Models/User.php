<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Office;
use App\Models\Role;
use App\Models\Designation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use App\Models\UserOfficeRole;

class User extends Authenticatable implements CanResetPassword
{
    use Notifiable;
    use CanResetPasswordTrait;
    use HasApiTokens;
    
    protected $fillable = [
        'full_name', 'nic', 'email', 'phone', 'designation_id', 'office_id', 'role_id', 'username', 'hash_password','status'
    ];

    protected $hidden = ['hash_password'];

    //one user belongs to one office
    public function office(){
        return $this->belongsTo(Office::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function designation(){
        return $this->belongsTo(Designation::class);
    }

    public function officeRoles(){
        return $this->hasMany(UserOfficeRole::class);
    }

    public function assignedRoles(){
        return $this->belongsToMany(Role::class,'user_office_roles')->withPivot('office_id')->withTimestamps();
    }
}
