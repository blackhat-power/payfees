<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'path',
        'receipt_id'
    ];



    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

}
