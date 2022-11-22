<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Registration\Entities\AccountStudentDetail;
use App\Models\Invoice;

class StudentCollectionExport implements FromView,ShouldAutoSize
{
    public function view(): View
    {
    $students = AccountStudentDetail::join('account_school_detail_classes', 'account_student_details.account_school_details_class_id','=','account_school_detail_classes.id')
   ->leftjoin('account_school_detail_streams','account_student_details.account_school_detail_stream_id','=','account_school_detail_streams.id')
   ->select('account_student_details.id as student_id','account_student_details.first_name','account_student_details.last_name','account_school_detail_classes.name as class_name','account_school_detail_streams.name as stream_name')
   ->get();

            $collection = array();

            $total = 0;

            foreach ($students as $key => $student) {
            $invoices = Invoice::select('invoices.*')
            ->join('accounts','invoices.account_id','=','accounts.id')
            ->join('account_student_details','accounts.id','=','account_student_details.account_id')
            ->where('account_student_details.id',$student->student_id)
            ->groupBy('invoices.id')
            ->get();
            $paid_amount = 0;
            
            foreach($invoices as $invoice){
            // $invoice->where('student_id',$student->id)
            $receipts = $invoice->receipts;
            foreach($receipts as $receipt_item){
            if($receipt_item->status == 3){
            $paid_amount += $receipt_item->receiptItems()->sum('rate');
            }

            }

            }
            if($paid_amount > 0){
            $total += $paid_amount;
            $collection[] = ['class'=>$student->class_name,'stream'=>$student->stream_name, 'student_id'=>$student->student_id, 'student_name'=>''.$student->first_name.' '.$student->last_name .'', 'amount_paid'=>$paid_amount ];
            }

            }

            $data['collection'] = $collection;
            $data['total_collection'] = $total;
        return view('accounts::collection.printouts.excel', $data);
    }

}
