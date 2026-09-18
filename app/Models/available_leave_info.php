<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class available_leave_info extends Model
{
    protected $fillable = [
        'application_id',
        'vacation_months',
        'vacation_days',
        'commuted_halfpay_months',
        'commuted_halfpay_days',
        'halfpay_months',
        'halfpay_days',
        'nopay_months',
        'nopay_days',
        'total_months',
        'total_days',
        'filled_by',
        'filled_at'
    ];

    public function application(){
        return $this->belongsTo(Application::class);
    }
}
