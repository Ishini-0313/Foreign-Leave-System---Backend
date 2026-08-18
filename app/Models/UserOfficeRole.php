<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Office;
use App\Models\Role;

class UserOfficeRole extends Model
{
    protected $table = 'user_office_roles';

    protected $fillable = [
        'user_id',
        'office_id',
        'role_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function office(){
        return $this->belongsTo(Office::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }
}
