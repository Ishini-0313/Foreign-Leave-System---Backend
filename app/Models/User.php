<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'full_name', 'nic', 'email', 'phone', 'designation', 'office_id', 'role_id', 'username', 'hash_password','status'
    ];

    protected $hidden = ['hash_password'];
}
