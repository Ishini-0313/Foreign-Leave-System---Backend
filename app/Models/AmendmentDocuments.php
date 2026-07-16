<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Application_amendments;

class AmendmentDocuments extends Model
{
    protected $fillable = [
        'amendment_id',
        'document_type',
        'file_name',
        'file_path'
    ];

    public function amendment(){
        return $this->belongsTo(Application_amendments::class);
    }
}
