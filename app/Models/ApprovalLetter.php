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
        'pdf_path',
        'template_name',

        'pdf_hash',
        'digital_signature',
        'signature_algorithm',
        'signed_by',
        'digitally_signed_at',
        'public_key_path',
    ];

    protected $casts = [
        'digitally_signed_at' => 'datetime',
    ];

    public function application(){
        return $this->belongsTo(Application::class);
    }
}
