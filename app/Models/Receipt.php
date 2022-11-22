<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'currency_id',
        'invoice_id',
        'payer',
        'reference',
        'remarks',
        'date',
        'receipt_no',
        'status'
    ];


    public function receiptItems(){
        return $this->hasMany(ReceiptItem::class);
    }


    public function invoices(){
        return $this->belongsTo(Invoice::class,'invoice_id');
    }

    public function receiptNumber()
    {
       

         if (isset(Receipt::latest()->get()[0])) {
             $next_no = Receipt::latest()->get()[0]->id + 1;
             return 'RCPT-' . date('Y') . '/' . Helper::add_leading_zeros($next_no);
             
        } else {
            return 'RCPT-' . date('Y') . '/0001';
        } 
    }

    


    public function receiptNo()
    {
        return 'RCPTNO-'.Helper::add_leading_zeros($this->id);
    }


   /*  public function getDebtAmountAttribute(){
        return InvoiceItem::join('invoices','invoice_items.invoice_id','=','invoices.id')
                ->join('accounts','accounts.id','=','invoices.account_id')
                ->join('account_student_details','account_student_details.account_id','=','accounts.id')
                ->where('account_student_details.id',$this->id)->selectRaw("SUM(quantity* rate) AS debt_amount")->first()->debt_amount;
    } */

    public function getPaidAmountAttribute(){
        
    }



}
