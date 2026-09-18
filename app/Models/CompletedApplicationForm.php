<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class CompletedApplicationForm extends Model
{
    protected $fillable = [
        'application_id',
        'form_type',
        'docx_file_name',
        'docx_file_path',
        'pdf_file_name',
        'pdf_file_path',
        'generated_at',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
    ];

    public function application(){
        return $this->belongsTo(
            Application::class
        );
    }
}
