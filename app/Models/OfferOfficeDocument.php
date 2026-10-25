<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;
use App\Models\User;

class OfferOfficeDocument extends Model
{
    protected $fillable = [
        'application_id',
        'uploaded_by',
        'document_type',
        'file_name',
        'file_path',
    ];

    public function application(){
        return $this->belongsTo(Offer::class);
    }

    public function uploader(){
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
