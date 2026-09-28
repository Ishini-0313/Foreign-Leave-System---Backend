<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Application;

class WarmClothOffer extends Model
{
    protected $fillable = [
        'application_id',
        'is_country_in_the_northern_hemisphere',
        'north_latitude',
        'is_country_in_the_southern_hemisphere',
        'south_latitude',
        'situated_more_than_5000_feet_above_sea_level',
        'height',
        'created_by'
    ];

    public function application(){
        return $this->belongsTo(Application::class,'application_id');
    }

    public function officer(){
        return $this->belongsTo(User::class,'created_by');
    }
}
