<?php

namespace Modules\Accounts\Http\Controllers;

use App\Models\Invoice;
use App\Models\Receipt;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;
use Modules\Configuration\Entities\AccountSchoolDetailClass;
use Modules\Configuration\Entities\AccountSchoolDetailSeason;
use Modules\Configuration\Entities\Semester;
use Modules\Registration\Entities\AccountStudentDetail;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use App\Exports\PaymentsReviewExport;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class PaymentsReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data['activeLink'] = 'payment_review';
        $data['seasons'] = AccountSchoolDetailSeason::all();
        $data['students'] = AccountStudentDetail::all();
        $data['terms'] = Semester::all();
        $data['classes'] = AccountSchoolDetailClass::all();
        return view('accounts::payments.review.index')->with($data);
    }

    public function datatable(Request $request)
    {
        
       try {

       $invoices = Invoice::select('invoices.*')
                            ->join('accounts','invoices.account_id','=','accounts.id')
                            ->join('account_student_details','accounts.id','=','account_student_details.account_id')
                            ->join('receipts','invoices.id','receipts.invoice_id')
                            ->where('receipts.status',1);
       

       if (!empty($request->get('class_id'))) {
        
       $invoices =  $invoices->where('account_student_details.account_school_details_class_id',$request->get('class_id'));
        
            }

            if (!empty($request->get('stream_id'))) {

                $invoices =  $invoices->where('account_student_details.account_school_detail_stream_id',$request->get('stream_id'));
                
            } 

            if (!empty($request->get('from_date'))  && empty($request->get('to_date'))) {

                $from = date($request->from_date);
                $invoices =  $invoices->whereDate('invoices.date', '>=', $from);
                
            } 

            if (!empty($request->get('to_date')) && empty($request->get('from_date'))) {

                $to = date($request->to_date);
                $invoices =  $invoices->whereDate('invoices.date', '<=', $to);
                
            } 

            if(!empty($request->get('to_date')) && !empty($request->get('from_date'))){

                $from = date($request->from_date);
                $to = date($request->to_date);
                $invoices = $invoices->whereBetween('date', [$from, $to]);

            }


            // return $invoices::join('receipts','invoices.');
        

        return DataTables::of($invoices) 

        ->editColumn('amount',function($invoice){
            //  return $invoice->getClass();
             $bill_model = $invoice->BilledAmount;
             $amount = 0;
            foreach ($bill_model as $bill) {
                $amount += $bill->billed_amount;
            }
            return  number_format($amount);

        })

        ->addColumn('student_name',function($invoice){
           
            return $invoice->student_name->first_name .' '. $invoice->student_name->last_name;
        })

        ->addColumn('invoice_date',function($invoice){
           
            return date("M jS, Y", strtotime("".$invoice->date.""));
        })

        ->addColumn('paid',function($invoice){
            $receipts = $invoice->receipts;
            $receipt_items = 0;
            foreach($receipts as $receipt_item){
                if($receipt_item->status == 3){
                    $receipt_items += $receipt_item->receiptItems()->sum('rate');
                }
               
            }
            return number_format($receipt_items);
 
        }) 
        ->addColumn('balance',function($invoice){
            $receipts = $invoice->receipts;
            $receipt_items = 0;
            foreach($receipts as $receipt_item){
                if($receipt_item->status == 3){
                    $receipt_items += $receipt_item->receiptItems()->sum('rate');
                }
            }
        return number_format($invoice->invoiceItems()->sum('rate') - $receipt_items);  
            
        }) 

        // date("M jS, Y", strtotime("".$receipts[0]->receipt_date.""))  /* DATE FORMAT */

        ->addColumn('amount',function($invoice){
           
            return  number_format($invoice->amount);
        })
        
        ->addColumn('action', function($invoice) {
            $receipts = $invoice->receipts;
            $receipt_items = 0;
            foreach($receipts as $receipt_item){
                $receipt_items += $receipt_item->receiptItems()->sum('rate');
            }


         return 
         '
                     
        <a target="_blank" href="javascript:void(0)" id="payment_details-'.$invoice->id.'" data-invoice_id="'.$invoice->id.'" title="preview" class="btn btn-primary btn-sm payment_details"><i class="fa fa-eye"></i> </a>
             
       ';
               
          })
      ->rawColumns(['action'])
      ->make();

       } catch (QueryException $e) {

          return $e->getMessage();

       }




         
    }



    public function printing(Request $request){
        // return 'now';
        $data['payments_review'] = [];
        $data['school_info'] = AccountSchoolDetail::first();

        $data['students'] = $students = AccountStudentDetail::all();

        $data['school_info'] = AccountSchoolDetail::first();
        $data['address'] =  Contact::where('contactable_type',AccountSchoolDetail::class)
                            ->where('contact_type_id',3)->first()->contact;
        $data['phone'] = Contact::where('contactable_type',AccountSchoolDetail::class)
                        ->where('contact_type_id',1)->first()->contact;

        $data['email'] = Contact::where('contactable_type',AccountSchoolDetail::class)
        ->where('contact_type_id',2)->first()->contact;

        $data['invoices'] = $invoices = Invoice::select('invoices.*')
        ->join('accounts','invoices.account_id','=','accounts.id')
        ->join('account_student_details','accounts.id','=','account_student_details.account_id')->get();

        $payments_review = Invoice::select('invoices.*')
        ->join('accounts','invoices.account_id','=','accounts.id')
        ->join('account_student_details','accounts.id','=','account_student_details.account_id')
        ->join('receipts','invoices.id','receipts.invoice_id')
        ->where('receipts.status',1);

            if (!empty($request->get('class_id'))) {

            $payments_review =  $payments_review->where('account_student_details.account_school_details_class_id',$request->get('class_id'));

            }

            if (!empty($request->get('stream_id'))) {

            $payments_review =  $payments_review->where('account_student_details.account_school_detail_stream_id',$request->get('stream_id'));
            }

            $payments_review =  $payments_review->get();

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
            // return $data['payments_review'];
         if ($request->file_type == 'pdf') {
             // return 'pdf';

             $pdf = FacadePdf::loadView('accounts::payments.review.printouts.pdf', $data);

             return $pdf->stream('payments_review.pdf', array("Attachment" => false));

         }
         if ($request->file_type == 'excel') {

            return FacadesExcel::download(new PaymentsReviewExport , 'payments_review.xlsx');

         }

     }



    public function receiptsTable($id)
    {
        try {

          $data['receipts'] = Receipt::select(
                'account_student_details.first_name',
                'account_student_details.middle_name',
                'account_student_details.last_name',
                'receipts.date as receipt_date',
                'receipts.reference',
                'payment_attachments.path',
                'receipts.id as receipt_id',
                'receipts.payer',
                'statuses.name as status_name',
                'invoices.id as rcpt_invoice_id',
                DB::raw("(
                    SELECT SUM(invoice_items.rate * invoice_items.quantity) FROM invoice_items WHERE invoice_items.invoice_id = invoices.id
                    ) AS bill_amount"),
                DB::raw("(
                    SELECT SUM(receipt_items.rate * receipt_items.quantity) FROM receipt_items WHERE receipt_items.receipt_id = receipts.id
                    ) AS amount_paid"),
            )
            
                ->join('invoices', 'receipts.invoice_id', '=', 'invoices.id')
                ->leftjoin('payment_attachments','receipts.id','=','payment_attachments.receipt_id')
                ->leftjoin('statuses', 'receipts.status','=','statuses.id')
                ->join('accounts', 'accounts.id', '=', 'invoices.account_id')
                ->join('account_student_details', 'accounts.id', '=', 'account_student_details.account_id')
                ->where('invoices.id',$id)->get();

                return response($data);

            
        } catch (QueryException $e) {
            return $e->getMessage();
        }
  
    }


    public function paymentApproval(Request $request,$id){

        try {
            $status_id = $request->status_id;
            $data = ['status' => $status_id];

            $update = Receipt::find($id)->update($data);
    
            if($update){
    
                $data = ['state'=> 'Done', 'msg'=>'Payment Approval Status Set', 'success'];
                echo json_encode($data);
    
            }
            elseif (!$update) {
                $data = ['state'=> 'Fail', 'msg'=>'Payment Approval Failed ', 'Fail'];
                echo json_encode($data);
            }
    
    
            } catch (QueryException $e) {
                $data = ['state'=> 'Error', 'msg'=>'Database Error, Please Contact The Admin ', 'Error'];
                echo json_encode($data);
            }


    }


 
}
