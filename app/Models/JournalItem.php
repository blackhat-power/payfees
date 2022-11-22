<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'operation',
        'account_id',
        'amount',
        'description'
    ];


    public function journal_entries(){
        return $this->belongsTo(Journal::class);
    }

    public function ledgers(){

        return $this->belongsTo(Ledger::class,'account_id');
    }

    public function getAccountNameAttribute(){

       return $this->ledgers()->first()->name;

    }

    // protected $fillable = [
    //     'journal_id',
    //     'cr_account_id',
    //     'dr_account_id',
    //     'amount',
    //     'naration'
    // ];
}
