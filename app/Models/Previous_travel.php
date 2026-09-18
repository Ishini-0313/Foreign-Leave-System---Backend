<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Previous_travel extends Model
{
    protected $fillable = [
        'application_id',
        'year',
        'purpose',
        'period',
        'country'
    ];
}
