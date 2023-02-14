<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Registration\Entities\AccountStudentDetail;
use App\Helpers\Helper;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'created_by',
        'currency_id',
        'payment_terms',
        'remarks',
        'date',
        'invoice_number',
        'class_id',
        'season_id',
        'student_id'
        
    ];

    public function invoiceItems(){
        return $this->hasMany(InvoiceItem::class,'invoice_id');
    }

    public function getTotalInvoiceItemsAttribute(){
        return $this->invoiceItems()->get();

    } 

    public function invoice_payments(){
        return $this->hasMany(PaymentAttachment::class);
    }

    public function getstudentNameAttribute(){
       return Account::join('invoices','accounts.id','invoices.account_id')
                ->join('account_student_details','accounts.id','account_student_details.account_id')
                ->select('account_student_details.first_name','account_student_details.last_name')
                ->where('invoices.id',$this->id)->first();
    }


    public function invo(){
        return  Invoice::join('accounts', 'invoices.account_id','=','accounts.id')
        ->join('account_student_details','accounts.id','=','account_student_details.account_id')
        ->where('invoices.id',$this->id);
    }

    public function receipts(){
        return $this->hasMany(Receipt::class);
    }

    public function receiptItems(){
        return $this->hasManyThrough(ReceiptItem::class, Receipt::class);

    }

    public function account(){
        return $this->belongsTo(Account::class,'account_id');
    }


    public function getAllMyPR($st_id, $year = NULL)
    {
        return $year ? $this->getRecord(['student_id' => $st_id, 'year' => $year]) : $this->getRecord(['student_id' => $st_id]);
    }

    public function getRecord($data, $order = 'year', $dir = 'desc')
    {
        return $this::orderBy($order, $dir)->where($data)->with('payment');
    }

    public function student(){

        return $this->account()->students;

    }



    public function invoice_no()
    {
       

         if (isset(Invoice::orderBy('id','DESC')->first()->id)) {
            $next_no = Invoice::orderBy('id','DESC')->first()->id + 1;
             return 'INVNO-' . date('Y') . '/' . Helper::add_leading_zeros($next_no);
             
        } else {
            return 'INVNO-' . date('Y') . '/0001';
        } 
    }

    public function getAmountPaidAttribute(){

        
        $receipt_item =  ReceiptItem::selectRaw('SUM(receipt_items.rate * receipt_items.quantity) as paid_amount')
       ->leftjoin('receipts', 'receipts.id','=','receipt_items.receipt_id')
                    ->where('invoice_id',$this->id)->groupBy('receipt_items.id')->first();
                    return $receipt_item ? $receipt_item->paid_amount : 0;
                    

        
    }


    public function getBilledAmountAttribute(){

        
        return InvoiceItem::selectRaw('SUM(invoice_items.rate * invoice_items.quantity) as billed_amount')
        ->join('invoices', 'invoices.id','=','invoice_items.invoice_id')
                     ->where('invoice_id',$this->id)->groupBy('invoice_items.id')->get();
 
         
     }

     public function getTotalInvoiceAttribute(){

     $invoice_items = $this->invoiceItems()->where('invoice_id',$this->id)->get();
     $total = 0;
     foreach ($invoice_items as $key => $item) {

        $total += $item->rate;   
     }


         return  $total;

     }

     public function getTotalReceiptAttribute(){

        return $this->receiptItems()->where('invoice_id',$this->id)->sum('rate');

    }

    
    
}
