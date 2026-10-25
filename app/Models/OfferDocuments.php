<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;

class OfferDocuments extends Model
{
    protected $fillable = [
        'offer_id',
        'document_type',
        'file_name',
        'file_path'
    ];

    public function offer(){
        return $this->belongsTo(Offer::class);
    }

}
