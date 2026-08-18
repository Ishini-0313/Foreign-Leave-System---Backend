<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Office;
use App\Models\User;

class OfficeAssignment extends Model
{
    protected $fillable = [
        'office_id',
        'subject_officer_id',
        'check_officer_id',
        'recommended_officer_id',
        'recommended_officer2_id',
        'recommended_officer3_id,',
        'chief_sec_id',
        'admin_user_id',
        'assigned_by'
    ];

    public function office(){
        return $this->belongsTo(Office::class);
    }

    public function subjectOfficer(){
        return $this->belongsTo(User::class, 'subject_officer_id');
    }

    public function checkOfficer(){
        return $this->belongsTo(User::class, 'check_officer_id');
    }

    public function recommendedOfficer(){
        return $this->belongsTo(User::class, 'recommended_officer_id');
    }

    public function recommendedOfficer2(){
        return $this->belongsTo(User::class, 'recommended_officer2_id');
    }

    public function recommendedOfficer3(){
        return $this->belongsTo(User::class, 'recommended_officer3_id');
    }

    public function cheifSec(){
        return $this->belongsTo(User::class, 'chief_sec_id');
    }

    public function admin(){
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    public function assignedBy(){
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
