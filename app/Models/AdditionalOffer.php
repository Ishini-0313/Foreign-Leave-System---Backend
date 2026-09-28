<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class AdditionalOffer extends Model
{
    protected $fillable = [
        'application_id',
        'no_of_days',
        'total_additional_offer',
        'created_by',
    ];

    public function application(){
        return $this->belongsTo(Application::class,'application_id');
    }

    public function officer(){
        return $this->belongsTo(User::class,'created_by');
    }
}
