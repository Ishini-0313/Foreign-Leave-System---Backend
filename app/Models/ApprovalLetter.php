<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class ApprovalLetter extends Model
{
    protected $fillable = [
        'application_id',
        'file_name',
        'file_path',
        'template_name',
    ];

    public function application(){
        return $this->belongsTo(Application::class);
    }
}
