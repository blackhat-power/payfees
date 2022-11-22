<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Invoice;

class PaymentsReviewExport implements FromView,ShouldAutoSize
{
    public function view(): View
    {
    //     return view('accounts::chartsOfAccounts.printouts.excel', [
    //         'chart_of_accounts' => $chart_of_accounts = DB::select('SELECT * FROM '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups join chart_of_accounts ON '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups.id = chart_of_accounts.account_group_id')
   
    //     ]
        
    // );

    $payments_review = Invoice::select('invoices.*')
    ->join('accounts','invoices.account_id','=','accounts.id')
    ->join('account_student_details','accounts.id','=','account_student_details.account_id')
    ->join('receipts','invoices.id','receipts.invoice_id')
    ->where('receipts.status',1);

        $payments_review =  $payments_review->get();

        $data['payments_review'] = array();

        foreach($payments_review as $p){

            $receipts = $p->receipts;
            $receipt_items = 0;
            $date =  date("M jS, Y", strtotime("".$p->date.""));
            $bill_model = $p->BilledAmount;
            $amount = 0;
            $student_name =  $p->student_name->first_name .' '. $p->student_name->last_name;

           foreach ($bill_model as $bill) {
               $amount += $bill->billed_amount;
           }
             $amount = number_format($amount);

            foreach($receipts as $receipt_item){
                if($receipt_item->status == 3){
                    $receipt_items += $receipt_item->receiptItems()->sum('rate');
                }
            }

        $balance = number_format($p->invoiceItems()->sum('rate') - $receipt_items);

        $data['payments_review'][]  = ['billed_amount'=>$amount,'invoice_number'=>$p->invoice_number, 'balance' => $balance, 'date'=> $date, 'student_name'=> $student_name, 'paid'=> $receipt_items];
        }

        $ppt = $data['payments_review'];

        return view('accounts::payments.review.printouts..excel',['payments_review'=>$ppt]);


    }

}
