<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GOSL_funds extends Model
{
    protected $fillable = [
        'application_id',

        'air_travel_selected',
        'air_travel_amount',

        'subsistence_selected',
        'subsistence_amount',

        'course_fees_selected',
        'course_fees_amount',

        'additional_expenses_selected',
        'additional_expenses_amount',

        'other_personal_expenses_selected',
        'other_personal_expenses_amount'
    ];
}
