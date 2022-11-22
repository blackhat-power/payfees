<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'type',
        'remarks',
        'relationable_type',
        'relationable_id',
        'date'
    ];


    public function journalItems(){
        return $this->hasMany(JournalItem::class);
    }


    public function getJournalEntriesAmountAttribute(){
        return $this->journalItems()->where('operation','DEBIT')->sum('amount');
    }


    public function journal_no()
    {
       
         if (isset($this::where('type','JOURNAL')->get()[0])) {
             $next_no = $this::where('type','JOURNAL')->latest()->first()->id + 1;
             return 'JVNO-' . date('Y') . '/' . Helper::add_leading_zeros($next_no);
             
        } else {
            return 'JVNO-' . date('Y') . '/0001';
        } 


    }

    public function contra_no()
    {

         if (isset($this::where('type','CONTRA')->get()[0])) {
             $next_no = $this::where('type','CONTRA')->latest()->first()->id + 1;
             return 'CVNO-' . date('Y') . '/' . Helper::add_leading_zeros($next_no);
             
        } else {
            return 'CVNO-' . date('Y') . '/0001';
        } 


    }


    public function payment_voucher_no()
    {
         if (isset($this::where('type','CASH PAYMENT')->get()[0])) {
             $next_no = $this::where('type','CASH PAYMENT')->latest()->first()->id + 1;
             return 'PVNO-' . date('Y') . '/' . Helper::add_leading_zeros($next_no);
             
        } else {
            return 'PVNO-' . date('Y') . '/0001';
        }

    }


}
