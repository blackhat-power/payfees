<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sub_group_id',
        'opening_balance',
        'opening_balance_date',
        'account',
        'transaction_type'
    ];

    public $timestamps = false;

    public function journalEntryItems(){

        return $this->hasMany(JournalItem::class);
    }


}
