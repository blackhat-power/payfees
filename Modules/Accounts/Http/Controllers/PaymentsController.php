<?php

namespace Modules\Accounts\Http\Controllers;

use App\Models\Invoice;
use App\Models\Receipt;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Modules\Configuration\Entities\AccountSchoolDetailClass;
use Modules\Registration\Entities\AccountStudentDetail;
use Yajra\DataTables\DataTables;

class PaymentsController extends Controller
{
    
    protected $my_class, $student, $year , $invoice;

    public function __construct( Invoice $invoice ,  AccountSchoolDetailClass $my_class, AccountStudentDetail $student)
    {
        $this->my_class = $my_class;
        $this->invoice = $invoice;
        $this->year = DB::select('select * from account_school_details')[0]->current_session;  /* current year */
        $this->student = $student;

        // $this->middleware('teamAccount');
    }
     
    public function index()
    {
        $data['activeLink'] = 'student_payments';
        $data['my_classes'] = AccountSchoolDetailClass::all();
        return view('accounts::payments.index')->with($data);
    }



/*     public function studentPaymentsDatatable()
    {
        $students = AccountStudentDetail::all();
        return DataTables::of($students)

        ->addColumn('avatar',  function($student){
            $url= asset('storage/student_profile_pics/'.$student->profile_pic);
            return '<img src="'.$url.'" height="45" width:"45" style="border-radius:50%;
            display: table;" >';
        })
            
         ->addColumn('full_name',function($student){
            $full_name =  $student->first_name .' '. $student->middle_name .' '. $student->last_name;
            return $full_name;
        }) 
        ->addColumn('action', function($student){
            return view('accounts::payments.action_button');
          })
      ->rawColumns(['action','avatar'])
      ->make();

        
    } */

    public function studentPaymentsDatatable()
    {
    $debtors_query = AccountStudentDetail::select('account_student_details.*')
    ->selectRaw('SUM(invoice_items.rate * invoice_items.quantity) AS bill_amount')
    ->selectRaw("SUM(receipt_items.quantity* receipt_items.rate) AS paid_amount")
    ->join('accounts','account_student_details.account_id','=','accounts.id')
    ->join('invoices','accounts.id','=','invoices.account_id')
    ->join('invoice_items','invoices.id','=','invoice_items.invoice_id')
    ->join('receipts','invoices.id','=','receipts.invoice_id')
    ->join('receipt_items','receipts.id','=','receipt_items.receipt_id')
    ->groupBy('account_student_details.id');

    $debtors = DB::table(DB::raw("({$debtors_query->toSql()}) AS debtors_list"))
    ->mergeBindings($debtors_query->getQuery())
    ->where('bill_amount','>','paid_amount')
    ->orWhere(DB::raw("bill_amount - paid_amount"),'>',0)
    ->get();

    $debtors;
    
    return DataTables::of($debtors)  
    ->addColumn('name',function($row){
        $debtor = AccountStudentDetail::find($row->id);
        return $debtor->full_name;
    }) 
    ->addColumn('billed_amount',function($row){
        $debtor = AccountStudentDetail::find($row->id);
        return number_format($debtor->debt_amount);
    }) 
    ->addColumn('avatar',  function($student){
        $url= asset('storage/student_profile_pics/'.$student->profile_pic);
        return '<img src="'.$url.'" height="45" width:"45" style="border-radius:50%;
        display: table;" >';
    })
 
    ->addColumn('action', function($row){
        $debtor = AccountStudentDetail::find($row->id);
        $button = '';
        $button .= '  <a href="'.route('accounts.students.individual.payments',$debtor->id).'" class="button-icon button btn btn-sm rounded-small btn-success  more-details-1"><i class="fa fa-eye m-0"></i></a>';    
        return '<nobr>'.$button. '</nobr>';
      })
  ->rawColumns(['action','avatar'])
  ->make();
}


public function individualDebtorsListDatatable($id){
    $debtors = Invoice::select('invoices.invoice_number','invoices.id','invoices.date as invoice_date')
   ->selectRaw('SUM(invoice_items.rate * invoice_items.quantity) as bill_amount')
   ->selectRaw("receipt_items.quantity* receipt_items.rate AS paid_amount")
   ->join('accounts','invoices.account_id','=','accounts.id')
   ->join('account_student_details','accounts.id','=','account_student_details.account_id')
   ->join('invoice_items','invoices.id','=','invoice_items.invoice_id')
   ->leftjoin('receipts','invoices.id','=','receipts.invoice_id')
   ->leftjoin('receipt_items','receipts.id','=','receipt_items.receipt_id')
    
->where('account_student_details.id',$id)
->groupBy('invoices.id')
->get();

return DataTables::of($debtors)  
->addColumn( 'title', function(){
    return 'title';
})
->addColumn('billed_amount',function($debtor){
   return number_format($debtor->bill_amount);
}) 
->addColumn('paid_amount',function($debtor){
   return number_format($debtor->paid_amount);
})  
->addColumn('balance',function($debtor){
   $balance = $debtor->bill_amount - $debtor->paid_amount;
   return number_format($balance);
}) 
->addColumn('action', function($debtor) {
/*  $button = '';
 $button .= '  <a target="_blank" href="'.route('accounts.debtors.individual.pdf',$debtor->id).'" class="button-icon button btn btn-sm rounded-small btn-success  more-details-1"><i class="fa fa-eye m-0"></i></a>';    
 return '<nobr>'.$button. '</nobr>'; */
return
'<div class="list-icons">
    <div class="dropdown">
        <a href="#" class="list-icons-item" data-toggle="dropdown" aria-expanded="false"> <i class="fas fa-bars"></i> <i class="fas fa-caret-down"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 18px, 0px);">

            
            <a id="LNnGzV5XgPWKOZ" onclick="confirmReset(this.id)" href="#" class="dropdown-item"><i class="icon-reset"></i> Reset Payment</a>
            <form method="post" id="item-reset-LNnGzV5XgPWKOZ" action="http://localhost/lvs/public/payments/reset_record/LNnGzV5XgPWKOZ" class="hidden"><input type="hidden" name="_token" value="87CglKAzk79tDECc9NZb90z8LGLhFse4LQ6MxBvH"> <input type="hidden" name="_method" value="delete"></form>
                <a target="_blank" href="http://localhost/lvs/public/payments/receipts/LNnGzV5XgPWKOZ" class="dropdown-item"><i class="icon-printer"></i> Print Receipt</a>
                <a target="_blank" href="http://localhost/lvs/public/payments/receipts/LNnGzV5XgPWKOZ" class="dropdown-item"><i class="icon-printer"></i> Print Invoice</a>
        </div>
    </div>
</div>';

 })

 ->addColumn('pay_now',function($invoice){
     /* check if invoice has balance */
     $balance = $invoice->amount - $invoice->rcpt_paid_amount;
   
     return 'jeje';

/* '<form id="'.$invoice->invoice_id.'" action="'.route('accounts.receipts.store').'" type="POST"  class="ajax-pay">
    <div class="row">
        <div class="col-md-7">
            <input id="pay_now-'.$invoice->invoice_id.'" min="1" max="'.$balance.'" data-invoice_model="'.$invoice.'" class="form-control form-control-sm" required="" placeholder="Pay Now" title="Pay Now" name="amt_paid" type="number">
            <input type="hidden" name="bill_no" value = "'.$invoice->invoice_id.'">
            <input type="hidden" name="student" value = "'.$invoice->student_id.'">
        </div>
        <div class="col-md-5">
            <button data-text="Pay" class="btn btn-danger btn-sm ml-2" type="submit"> Pay <i class="fa fa-paper-plane"></i></button>
        </div>
    </div>
</form>'; */
 })

->rawColumns(['action','pay_now'])
->make();
}



public function individualStudentPaymentsList($id){
    $data['id']=$id;
    $data['activeLink'] = 'student_payments';
    $data['students_name'] = AccountStudentDetail::find($id)->full_name;
    return view('accounts::payments.individual_payments')->with($data);
}

    public function invoice($st_id, $year = NULL)
    {
        if(!$st_id) {return 'bado man';}

        $inv = $year ? $this->invoice->getAllMyPR($st_id, $year) : $this->pay->getAllMyPR($st_id);

        $d['sr'] = $this->student->findByUserId($st_id)->first();
        $pr = $inv->get();
        $d['uncleared'] = $pr->where('paid', 0);
        $d['cleared'] = $pr->where('paid', 1);

        return view('pages.support_team.payments.invoice', $d);
        
    }



    public function individualIncompleteStudentPaymentsDatatable(){

        $data['activeLink'] = 'student_payments';
        return view('accounts::payments.individual_payments')->with($data);


    }


    public function create($invoice_id,$balance,$student)
    {
        $invoice_id = decrypt($invoice_id);
        $balance = decrypt($balance);
        $student = decrypt($student);
        
        $data['invoice_details'] = Invoice::find($invoice_id);
        $data['student'] = $student;
        $data['balance'] = $balance;
        $data['invoice_id'] = $invoice_id;
        $data['activeLink'] = 'bills';
        $data['my_classes'] = $this->my_class->all();
        return view('accounts::payments.create', $data);

    }


    

    public function store(/* PaymentCreate $req */)
    {
       /*  $data = $req->all();
        $data['year'] = $this->year;
        $data['ref_no'] = Pay::genRefCode();
        $this->pay->create($data);

        return Qs::jsonStoreOk(); */
    }



    public function manage($class_id = NULL)
    {
        $d['my_classes'] = $this->my_class->all();
        $d['selected'] = false;

        if($class_id){
            $d['students'] = $st = $this->student->getRecord(['my_class_id' => $class_id])->get()->sortBy('user.name');
            if($st->count() < 1){
                // return Qs::goWithDanger('payments.manage');
            }
            $d['selected'] = true;
            $d['my_class_id'] = $class_id;
        }

        return view('pages.support_team.payments.manage', $d);
    }

}
