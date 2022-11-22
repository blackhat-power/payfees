<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'quantity',
        'tax_id',
        'exchange_rate',
        'invoice_id',
        'descriptions',
        'fee_group_id',
        'rate'
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

   /*  public function getAmountAttribute($value)
    {
        return $this->
    } */
}
