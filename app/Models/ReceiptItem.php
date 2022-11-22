<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'receipt_id',
        'rate',
        'tax_id',
        'exchange_rate',
        'descriptions'

    ];


    public function receipt(){
        return $this->belongsTo(Receipt::class);
    }
}
