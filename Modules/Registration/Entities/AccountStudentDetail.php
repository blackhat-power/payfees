<?php

namespace Modules\Registration\Entities;

use App\Models\Account;
use App\Models\Contact;
use App\Models\ContactPerson;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\ReceiptItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Modules\Configuration\Entities\AccountSchoolDetailClass;
use Modules\Configuration\Entities\AccountSchoolDetailStream;

class AccountStudentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'account_school_details_id',
        'first_name',
        'middle_name',
        'last_name',
        'dob',
        'gender',
        'account_school_details_class_id',
        'account_school_detail_stream_id',
        'grad',
        'profile_pic',
        'graduation_date',
        'admitted_year',
        'session'

        
    ];

    public function studentsCount(){
        return $this->count();
    }

    public function classes(){

        return $this->belongsTo(AccountSchoolDetailClass::class,'account_school_details_class_id');

    }

    public function streams(){

        return $this->belongsTo(AccountSchoolDetailStream::class,'account_school_detail_stream_id');
        
    }

    public function school(){

        return $this->belongsTo(AccountSchoolDetail::class,'account_school_details_id');
        
    }

    public function getFullNameAttribute(){
         return "{$this->first_name} {$this->last_name}";
    }


    public function getPaidAmountAttribute(){
        return ReceiptItem::join('receipts','receipt_items.receipt_id','=','receipts.id')
                ->join('invoices','receipts.invoice_id','=','invoices.id')
                ->join('accounts','accounts.id','=','invoices.account_id')
                ->join('account_student_details','account_student_details.account_id','=','accounts.id')
                ->where('account_student_details.id',$this->id)->selectRaw("SUM(receipt_items.quantity* receipt_items.rate) AS paid_amount")->first()->paid_amount;
    }

    public function getDebtAmountAttribute(){
        return InvoiceItem::join('invoices','invoice_items.invoice_id','=','invoices.id')
                ->join('accounts','accounts.id','=','invoices.account_id')
                ->join('account_student_details','account_student_details.account_id','=','accounts.id')
                ->selectRaw("SUM(quantity* rate) AS debt_amount")
                ->where('account_student_details.id',$this->id)->first()->debt_amount;
    }

    public function getBalanceAttribute(){
       return  $this->getDebtAmountAttribute() - $this->getPaidAmountAttribute();
    }


    public function getDebtorsList(){

        Account::join('invoices','accounts.id','=','invoices.account_id')
                ->join('invoice_items','invoices.id','=','invoice_items.invoice_id')
                ->join('receipts','invoices.id','=','receipts.invoice_id')
                ->join('receipt_items','receipts.id','=','receipt_items.receipt_id')
                /* ->where() */
                ->groupBy($this->id);



        $debtors = $this::select('account_student_details.*')
        ->selectRaw('SUM(invoice_items.rate * invoice_items.quantity) AS bill_amount')
        ->selectRaw("SUM(receipt_items.quantity* receipt_items.rate) AS paid_amount")
        ->join('accounts','account_student_details.account_id','=','accounts.id')
        ->join('invoices','accounts.id','=','invoices.account_id')
        ->join('invoice_items','invoices.id','=','invoice_items.invoice_id')
        ->join('receipts','invoices.id','=','receipts.invoice_id')
        ->join('receipt_items','receipts.id','=','receipt_items.receipt_id')
        ->groupBy('account_student_details.id');
    }



    public function getDateInvoiceAttribute(){
        return InvoiceItem::join('invoices','invoice_items.invoice_id','=','invoices.id')
        ->join('accounts','accounts.id','=','invoices.account_id')
        ->join('account_student_details','account_student_details.account_id','=','accounts.id')
        ->select('invoices.date as invoice_date')
        ->where('account_student_details.id',$this->id)
        ->first()
        ->invoice_date;
    }

    public function getRecord(array $data)
    {
        return $this->activeStudents()->where($data)->with('users');
    }


    public function activeStudents()
    {
        return $this::where(['grad' => 0]);
    }

    public function personable(){
        return $this->morphMany(ContactPerson::class,'personable');
    }
    public function contactable(){
        return $this->morphMany(Contact::class,'contactable');
    }


    public function account(){
        return $this->belongsTo(Account::class);
    }

    public function promotions(){
        return $this->hasMany(Promotion::class,'student_id');

    }


    public function getAllPromotionsAttribute(){

        return $this->promotions();

    }




       /************* Promotions *************/
       public function createPromotion(array $data)
       {
           return Promotion::create($data);
       }
   
       public function findPromotion($id)
       {
           return Promotion::find($id);
       }
   
       public function deletePromotion($id)
       {
           return Promotion::destroy($id);
       }
   
      /*  public function getAllPromotions()
       {
           return Promotion::with(['student', 'fc', 'tc', 'fs', 'ts'])->where(['from_session' => '2020-2021', 'to_session' => '2022-2023'])->get();
       }  */
   
       public function getPromotions(array $where)
       {
           return Promotion::where($where)->get();
       }
    
    protected static function newFactory()
    {
        return \Modules\Registration\Database\factories\AccountStudentDetailFactory::new();
    }
}
