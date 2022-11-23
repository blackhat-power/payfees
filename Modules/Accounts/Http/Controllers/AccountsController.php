<?php

namespace Modules\Accounts\Http\Controllers;

use App\Exports\AccountSubGroupsExport;
use App\Exports\InvoiceExport;
use App\Exports\LedgersExport;
use App\Exports\StudentCollectionExport;
use App\Models\Account;
use App\Models\AccountSubGroup;
use App\Models\Contact;
use App\Models\FeeGroup;
use App\Models\FeeTypeGroup;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Journal;
use App\Models\JournalItem;
use App\Models\Ledger;
use App\Models\PaymentAttachment;
use App\Models\Receipt;
use App\Models\ReceiptItem;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Facade\FlareClient\Stacktrace\File;
use Flasher\Toastr\Prime\ToastrFactory;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;
use Modules\Accounts\Entities\FeeReminderSetting;
use Modules\Configuration\Entities\AccountSchoolBankDetail;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Modules\Configuration\Entities\AccountSchoolDetailClass;
use Modules\Configuration\Entities\AccountSchoolDetailFeeStructure;
use Modules\Configuration\Entities\AccountSchoolDetailSeason;
use Modules\Configuration\Entities\AccountSchoolDetailStream;
use Modules\Configuration\Entities\BankDetail;
use Modules\Configuration\Entities\Semester;
use Modules\Registration\Entities\AccountStudentDetail;
use Yajra\DataTables\DataTables;
use Yoeunes\Toastr\Toastr;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $std_model;
    public $class_model;

    public function __construct(AccountStudentDetail $student, AccountSchoolDetailClass $class)
    {
        $this->std_model = $student;
        $this->class_model = $class;
    }

    public function index()
    {
        // return $invoices = Invoice::all();
        $data = array();
        $data['seasons'] = AccountSchoolDetailSeason::all();
        $data['students'] = AccountStudentDetail::all();
        $data['terms'] = Semester::all();
        $data['activeLink']='bills';
        $data['classes'] = AccountSchoolDetailClass::all();
        $fee_structures =  AccountSchoolDetailFeeStructure::with('items')->get();
        foreach ($fee_structures as $key => $fee_structure) {
            foreach ($fee_structure->items()->get() as $item) {
                $data['items'][] = $item;
            }
        }
        return view('accounts::invoices')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

    public function storeInvoice(Request $request, ToastrFactory $flasher)
    {

        //  return $request->all();
        
        try {
            DB::beginTransaction();
            
            //  return $request->date;
            $invoice_instance = new Invoice();
            $invoice_no = $invoice_instance->invoice_no();
            $date =  $request->date;
           $newDate = date("Y-m-d", strtotime($date));
           $query = DB::select(
                'select account_student_details.account_id as student_account_id, account_school_details.account_id as school_account_id from account_student_details JOIN account_school_details ON account_student_details.account_school_details_id = account_school_details.id
            where account_student_details.id = ?',
                [$request->stdnt_id]
            )[0];
            $invoice = Invoice::updateOrCreate(
                [
            'id'=>null
        ],
                [
            'account_id'=>$query->student_account_id,
            'created_by'=>auth()->user()->id,
            'currency_id'=>1,
            'payment_terms'=>'DUE_ON_RECEIPT',
            'date'=>$newDate,
            'remarks'=>$request->remarks,
            'semester_id'=>$request->term,
            'invoice_number'=>$invoice_no,
            'due_date'=>$request->date,
            // 'fee_type_group_id'=>$request->fee_type_group,
            'class_id'=>$request->class_id,
            'season_id'=>AccountSchoolDetailSeason::where('status','active')->first()->id
        ]
            );


            if ($invoice) {
                // return $invoice;
                foreach ($request->amount as $col_index => $col) {
                    $explode = explode('-', $col);
                    $description = $explode[1];
                    $rate = $explode[0];
                   $group_id = $request->group_ids[$col_index];

                    $invoice_items =  InvoiceItem::updateOrCreate(
                        ['id'=> null],

                        [
                'item_id'=>null,
                'quantity'=>1,
                'tax_id'=>1,
                'exchange_rate'=>1,
                'invoice_id'=>$invoice->id,
                'descriptions'=>$description,
                'fee_group_id'=>$group_id,
                'rate'=> str_replace(',','',$rate)
                ]
                    );
                }





$journal =  Journal::updateOrCreate(
                    [
                'id'=>null,
            ],
                    [
         'reference'=>$invoice->invoice_number,
        'type'=>'SALES',
        'remarks'=>$invoice->remarks,
        'relationable_type'=>Invoice::class,
        'relationable_id'=>$invoice->id,
        'date'=>$invoice->date
            ]
                );


                if ($journal) {
                    // return $invoice_items->rate;

                    $journal_item  =   JournalItem::updateOrCreate(
                        [
                        'id'=>null,
                    ],
                        [
                        'journal_id'=>$journal->id,
                        'cr_account_id'=>$invoice->account_id,
                        'dr_account_id'=>$query->school_account_id,
                        'amount'=>$invoice_items->rate,
                        'naration'=>$invoice->remarks
                    ]
                    );
                }
            }
            DB::commit();

            if ($journal_item) {
                session()->flash('success','Record created successful');
                $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record created successful'];
                return response($data);

            }

            $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
            return  response($data);

        } catch (QueryException $e) {
            return $e->getMessage();
            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            return  response($data);

        }
    }

    public function invoiceDatatable(Request $request)
    {

       try {

       $invoices = Invoice::select('invoices.*')
                            ->join('accounts','invoices.account_id','=','accounts.id')
                            ->join('account_student_details','accounts.id','=','account_student_details.account_id');


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

        ->addColumn('pay_now',function($invoice){
            /* check if invoice has balance */
            $receipts = $invoice->receipts;
            $receipt_items = 0;
            foreach($receipts as $receipt_item){
                $receipt_items += $receipt_item->receiptItems()->sum('rate');
            }
        $balance =($invoice->invoiceItems()->sum('rate') - $receipt_items);

        return  $balance ?


        '<form id="'.$invoice->id.'" action="'.route('accounts.receipts.store').'" type="POST"  class="ajax-pay">
            <div class="row">
                <div class="col-md-7">
                    <input  min="1" max="'.$balance.'" data-invoice_model="'.$invoice.'" class="form-control form-control-sm" required="" placeholder="Pay Now" title="Pay Now" name="amt_paid" type="number">
                    <input type="hidden" name="bill_no" value = "'.$invoice->id.'">
                    <input type="hidden" name="student" value = "'.$invoice->account->students[0]->id.'">
                </div>
                <div class="col-md-5">
                    <button data-text="Pay" id="$invoice->id" class="btn btn-danger btn-sm ml-2" type="submit"> Pay <i class="fa fa-paper-plane"></i></button>
                </div>
            </div>
        </form>' : '' ;

        })

        ->addColumn('action', function($invoice) {
            $receipts = $invoice->receipts;
            $receipt_items = 0;

            foreach($receipts as $receipt_item){
                if($receipt_item->status == 3){
                    $receipt_items += $receipt_item->receiptItems()->sum('rate');
                }
                /* href="'.route('accounts.invoices.pdf',$invoice->id).'" */

            }
        $balance =($invoice->invoiceItems()->sum('rate') - $receipt_items);
        $ahrefs = '';
        if($balance){
            $ahrefs .= '<a  href="'.route('accounts.students.payments.create',[encrypt($invoice->id),encrypt($balance), encrypt($invoice->account->students[0]->id)]).'" data-student_id = "'.encrypt($invoice->account->students[0]->id).'" id="add_payment"  class="dropdown-item"><i class="fa fa-credit-card"></i> Add Payment</a>';
        }
        $rcpts = '';
        if($receipt_items){
            $rcpts .= '<a target="_blank" href="'.route('accounts.receipts.pdf',$invoice->id).'" class="dropdown-item"><i class="fa fa-print"></i> Print Receipts</a>';
        }

         return
         '<div class="list-icons">
         <div class="dropdown">
             <a href="#" class="list-icons-item" data-toggle="dropdown" aria-expanded="false"> <i class="fas fa-bars"></i> <i class="fas fa-caret-down"></i>
             </a>

             <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 18px, 0px);">
                    '.$rcpts.'
                     <a target="_blank" href="'.route('accounts.invoices.pdf',$invoice->id).'" data-inv_id="'.$invoice->id.'" id="print_pdf-'.$invoice->id.'" class="dropdown-item invoice_print"><i class=" fa fa-print"></i> Print Invoice</a>

                     <a target="_blank" href="javascript:void(0)" id="payment_details-'.$invoice->id.'" data-invoice_id="'.$invoice->id.'" class="dropdown-item payment_details"><i class="fa fa-list"></i> Payment Details</a>

                     '.$ahrefs.'
             </div>
         </div>
     </div>';

          })
      ->rawColumns(['action','pay_now'])
      ->make();

       } catch (QueryException $e) {

          return $e->getMessage();

       }

    }


    public function individualInvoiceView(){

        $data = array();
        $data['seasons'] = AccountSchoolDetailSeason::all();
        $data['students'] = AccountStudentDetail::all();
        $data['terms'] = Semester::all();
        $data['the_id'] = AccountStudentDetail::find(auth()->user()->student_id)->id;
        $data['activeLink']='individual_invoice';
        $fee_structures =  AccountSchoolDetailFeeStructure::with('items')->get();
        foreach ($fee_structures as $key => $fee_structure) {
            foreach ($fee_structure->items()->get() as $item) {
                $data['items'][] = $item;
            }
        }
        return view('accounts::individual_invoice')->with($data);


    }

    public function fee_type_group_store(Request $request){

        try {
            DB::beginTransaction();

            // return $request->all();

            switch ($request->action){
                case 'edit':
                    $fee_type_group = FeeTypeGroup::updateOrCreate(
                        [
                            'id'=>$request->id
                        ], 
                        [
                            'name'=>$request->name,
                            'parent_id'=>$request->parent_group,
                            'description'=>$request->description
                        ]
                    );
                    break;
                case 'delete':
                    $fee_type_group = FeeTypeGroup::find($request->id);
                    $fee_type_group->delete();
                    break;
                case 'create':
                    $fee_type_group = FeeTypeGroup::updateOrCreate(
                        [
                            'id'=>$request->id
                        ],
                        [
                            'name'=>$request->name,
                            'parent_id'=>$request->parent_group,
                            'description'=>$request->description
                        ]
                    );
                    break;
            }
            DB::commit();
            $data['message'] = 'success';
            return response($data);
        } catch (QueryException $e) {
            $data['message'] = $e;
            return response($data);
        }




    }


    public function loadGroupTypes(){

        $fee_type_groups = FeeTypeGroup::all();
        $fee_group_html = '';

        foreach ($fee_type_groups as $key => $group) {
            $fee_group_html .= '<option  value="'. $group->id.'" > '.$group->name.' </option>';
        }
        return response($fee_group_html);
        


    }


    public function fee_type_group_datatable(){

     $fee_group_types = FeeTypeGroup::all();

        return DataTables::of($fee_group_types)

  ->make();
    



    }

    public function create( Request $request, $c_id=null, $acc_id = null, $std_id=null, $season_id=null)
    {
        $data = array();
        $data['seasons'] = AccountSchoolDetailSeason::all();
        $data['invoices'] = Invoice::where('account_id',$acc_id)->get();
        $data['students'] = AccountStudentDetail::all();
        $data['classes'] = AccountSchoolDetailClass::all();
        $data['terms'] = Semester::select(['name','id'])->groupBy(['name'])->get();
        $data['fee_groups'] = FeeTypeGroup::all();
        $data['selected'] = false;
        $data['activeLink']='bills';



        if($c_id && $acc_id && $std_id && $season_id){
            // return $acc_id;
            $std_id = decrypt($std_id);
            $season_id = decrypt($season_id);
            $c_id = decrypt($c_id);
            // $acc_id = decrypt($acc_id);
             $acc_id = AccountStudentDetail::find($std_id)->account_id;

            $data['invoices'] = Invoice::where('account_id',$acc_id)->get();

            $invoices = Invoice::select('invoices.*')
            ->join('accounts','invoices.account_id','=','accounts.id')
            ->join('account_student_details','accounts.id','=','account_student_details.account_id')
            ->where('invoices.account_id',$acc_id)
            ->get();


            $due_invoices = array();

            foreach($invoices as $invoice){

                $receipts = $invoice->receipts;
                $paid_amount = 0;
                foreach($receipts as $receipt_item){
                    if($receipt_item->status == 3){
                        $paid_amount += $receipt_item->receiptItems()->sum('rate');
                    }
                }
                // return number_format($paid_amount);
                $billed_amount = $invoice->invoiceItems()->sum('rate');
                $balance = $billed_amount - $paid_amount;
                if ( $balance > 0){
                    $acc_id = $invoice->account_id;
                   $student = AccountStudentDetail::where('account_id',$acc_id)->first();
                    $due_invoices[] = ['invoice_number'=>$invoice->invoice_number,'invoice_id'=>$invoice->id, 'balance'=> $balance ];
                }
            }





            $data['due_invoices'] = $due_invoices;
            $data['c_id'] = $c_id;
            $data['acc_id'] = $acc_id;
            $data['std_id'] = $std_id;
            $data['season_id'] = $season_id;
            $data['season_name'] = AccountSchoolDetailSeason::find($season_id)->name;
            $data['student_name'] = AccountStudentDetail::find($std_id)->first_name . ' '. AccountStudentDetail::find($std_id)->last_name;
            $data['class_name'] = AccountSchoolDetailClass::find($c_id)->name;
            // $data['semester'] = Semester::find($s_id)->name;
            $data['selected'] = true;
            $data['query'] = AccountSchoolDetailClass::find($c_id)->feeStructures()
                                                // ->where(['account_school_detail_fee_structures.semester_id'=>$s_id])
                                                ->get();
    //    return $data;
        }

        else{

            $data['c_id'] = null;
            // $data['s_id'] = null;
            $data['acc_id'] = null;
            $data['std_id'] = null;
            $data['season_id'] = null;

        }

        if(auth()->user()->student_id){
            $data['activeLink']='individual_invoice_create';
            return view('accounts::forms.individual_student_invoice')->with($data);
        }

        return view('accounts::forms.new_invoice')->with($data);
    }


    public function generateInvoicePdf($id)
    {


    // find($season_id)->semesters;
//    return $amountInWords = ucwords((new NumberFormatter('en_IN', NumberFormatter::SPELLOUT))->format(500));
    $pymnt_schedule = [];

      $data['particulars'] = $particulars = Invoice::join(
           'invoice_items', 'invoices.id','=', 'invoice_items.invoice_id',)
        ->join('accounts', 'invoices.account_id', '=', 'accounts.id')
        ->join('fee_type_groups','fee_type_groups.id','=','invoice_items.fee_group_id')
        ->join('account_school_detail_seasons','invoices.season_id','=','account_school_detail_seasons.id')
        // ->join('semesters','account_school_detail_seasons.id','=','semesters.account_school_detail_season_id')
        // ->join('account_school_detail_fee_structure_items','account_school_detail_fee_structures.id','=','account_school_detail_fee_structure_items.account_school_detail_fee_structure_id')
        ->join('account_student_details', 'accounts.id', '=', 'account_student_details.account_id')
        ->join('account_school_details', 'account_student_details.account_school_details_id', 'account_school_details.id')
        ->select(
            'invoices.date as invoice_date',
            'invoices.invoice_number',
            'accounts.name',
            'account_school_detail_seasons.id as season_id',
            'account_student_details.id as std_id',
            'invoices.id as invoice_id',
            'invoices.class_id',
            'invoice_items.fee_group_id as invoice_item_fee_group_id',
            'account_school_details.name as school_name',
            'account_school_details.id as school_id',
            DB::raw('SUM(invoice_items.rate) as amount')
        )
        ->where('invoices.id', $id)
        ->groupBy(['invoices.id'])
        ->first();

        $invoice_amount = $particulars->amount;

        // return $particulars->fee_type_group_id;

    //    return AccountSchoolDetailFeeStructure::all();
      
    //    return AccountSchoolDetailSeason::join('semesters','account_school_detail_seasons.id','=','semesters.account_school_detail_season_id')
    //    ->join('account_school_detail_fee_structures','account_school_detail_seasons.id','=','account_school_detail_fee_structures.season_id')
    //    ->where('account_school_detail_seasons.id',$particulars->season_id)
    //    ->where('account_school_detail_fee_structures.account_school_details_class_id',$particulars->class_id)
    //    ->where('account_school_detail_fee_structures.fee_group_id',2)->get();

     $invoice_item_gpids = Invoice::find($id)->invoiceItems;
     $installments_box_office = [];

      foreach($invoice_item_gpids as $grpid){

         $no_of_installment =  AccountSchoolDetailSeason::join('semesters','account_school_detail_seasons.id','=','semesters.account_school_detail_season_id')
         ->join('account_school_detail_fee_structures','account_school_detail_seasons.id','=','account_school_detail_fee_structures.season_id')
         ->join('invoice_items', 'invoice_items.fee_group_id', '=' ,'account_school_detail_fee_structures.id')
         ->where('account_school_detail_seasons.id',$particulars->season_id)
         ->where('account_school_detail_fee_structures.account_school_details_class_id',$particulars->class_id)
         ->where('account_school_detail_fee_structures.fee_group_id',$grpid->fee_group_id)
         ->select('account_school_detail_fee_structures.*','semesters.name as semester_name','semesters.start_date as ssd','semesters.end_date as sed')
         ->groupBy('account_school_detail_fee_structures.fee_group_id')
         ->first();

         $installments_box_office[] = $no_of_installment;

      }
        $max_installment = max($installments_box_office)->installments;

        // return $installments_box_office;
        $no_of_semesters =  AccountSchoolDetailSeason::find($particulars->season_id)->semesters()->count();

        $amount_per_installment = $invoice_amount/$max_installment;
        $percentage_per_installment = floatval (($amount_per_installment/$invoice_amount * 100 ));


        $payment_schedules =  AccountSchoolDetailSeason::join('semesters','account_school_detail_seasons.id','=','semesters.account_school_detail_season_id')
        ->join('account_school_detail_fee_structures','account_school_detail_seasons.id','=','account_school_detail_fee_structures.season_id')
        // ->join('invoices','account_school_detail_fee_structures.id','=','invoices.fee_type_group_id')
        ->where('account_school_detail_seasons.id',$particulars->season_id)
        ->where('account_school_detail_fee_structures.account_school_details_class_id',$particulars->class_id)
        ->where('account_school_detail_fee_structures.fee_group_id',$particulars->fee_type_group_id)
        //  ->groupBy('account_school_detail_fee_structures.id')
        // ->where('invoices.id', $id)
        ->get();

            // if ($no_of_installment/$no_of_semesters == 1 ) {
            //     # code...
            // }else{

                // if($no_of_semesters ==  1){

                //     $semester_name = $p_schedule->name;
                //         $start_date = $p_schedule->start_date;

                //         $end_date = $p_schedule->end_date;
                //         $s_date = strtotime($start_date);
                //         $due_date = strtotime("+14 day", $s_date);
                //         $final_due_date = date('d-m-Y', $due_date);

                //         $e_date = strtotime($end_date);
                //         $e_due_date = strtotime("-14 day", $e_date);
                //         $e_final_due_date = date('d-m-Y', $e_due_date);

                //         $pymnt_schedule[] =[
                //         'percentage'=>''.$percentage_per_installment.'%',
                //         'amount_per_installment'=>$amount_per_installment,
                //         'description'=>['start_date' =>'Beggining of '.$semester_name.'', 'before_end_description' => 'Before end of '.$semester_name.''],
                //         'due_date'=> ['start_final_date'=>$final_due_date,'before_end_due'=>$e_final_due_date],
                //         'fee_type_group'=>$p_schedule->fee_group_id

                //     ];

                // }

                foreach($payment_schedules as $p_schedule){

                   

                    for ($i=1; $i <= $no_of_installment/$no_of_semesters  ; $i++) {
                        $semester_name = $p_schedule->name;
                        $start_date = $p_schedule->start_date;

                        $end_date = $p_schedule->end_date;
                        $s_date = strtotime($start_date);
                        $due_date = strtotime("+14 day", $s_date);
                        $final_due_date = date('d-m-Y', $due_date);

                        $e_date = strtotime($end_date);
                        $e_due_date = strtotime("-14 day", $e_date);
                        $e_final_due_date = date('d-m-Y', $e_due_date);
                        // $NewDate=Date('y:m:d', strtotime('+50 days'));

                        $pymnt_schedule[] =[
                            'percentage'=>''.$percentage_per_installment.'%',
                            'amount_per_installment'=>$amount_per_installment,
                            'description'=>['start_date' =>'Beggining of '.$semester_name.'', 'before_end_description' => 'Before end of '.$semester_name.''],
                            'due_date'=> ['start_final_date'=>$final_due_date,'before_end_due'=>$e_final_due_date],
                            'fee_type_group'=>$p_schedule->fee_group_id

                        ];

                     }

                    }


            // }



       $data['invoice_items'] = Invoice::find($id)->invoiceItems;
        $data['payments_schedule_list'] =$ps = $pymnt_schedule;
        $data['no_of_installments'] = $no_of_installment;
        // foreach ($ps as $key => $p) {
        //     return $p['due_date'];
        //     # code...
        // }

        $data['school_details'] = AccountSchoolDetail::first();
        $data['school_phone'] = Contact::where('contactable_type',AccountSchoolDetail::class)
       ->where('contactable_id',$particulars->school_id)
       ->where('contact_type_id',1)
       ->first()->contact;

       $data['school_email'] = Contact::where('contactable_type',AccountSchoolDetail::class)
       ->where('contactable_id',$particulars->school_id)
       ->where('contact_type_id',2)
       ->first()->contact;

       $data['school_address'] = Contact::where('contactable_type',AccountSchoolDetail::class)
       ->where('contactable_id',$particulars->school_id)
       ->where('contact_type_id',3)
       ->first()->contact;

       $data['qrcode'] = 'VALID INVOICE FOR '.AccountSchoolDetail::first()->name;

       /* return  */$data['student_phone'] = Contact::where('contactable_type',AccountStudentDetail::class)
                                        ->where('contactable_id',$particulars->std_id)
                                        ->where('contact_type_id',1)
                                        ->first()->contact;

                $data['student_email'] = Contact::where('contactable_type',AccountStudentDetail::class)
                ->where('contactable_id',$particulars->std_id)
                ->where('contact_type_id',2)
                ->first()->contact;




        //  return /* $id ; */

                     /*       TO BE WOKED ON INVOICES             */


    //    return  $data['school_details'] =$school= Invoice::find($id)->account->students[0]->school()->with(['contactable','district'])->get();
    //     //  $data['school_details'] =
    $data['school_bank_details'] = AccountSchoolBankDetail::join(''.env('LANDLORD_DB_DATABASE').'.bank_details','account_school_bank_details.bank_id','=',''.env('LANDLORD_DB_DATABASE').'.bank_details.id')->get();
    //  AccountSchoolDetail::all();

        //   return view('accounts::printouts.invoice_pdf', $data);

          $pdf = FacadePdf::loadView('accounts::printouts.invoice_pdf', $data);

         return $pdf->stream('itsolutionstuff.pdf', array("Attachment" => false));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */


    public function receiptsIndex()
    {
        $data['activeLink'] = 'receipts';
        return view('accounts::receipts.index')->with($data);
    }

    public function receiptsSave(Request $request)
    {
        try {

            DB::beginTransaction();
            $full_name = AccountStudentDetail::find($request->student)->full_name;
            $invoice_id = $request->bill_no;
            $root_path = public_path('storage/student/');
            $student_id = $request->student;

            if(!is_dir($root_path)){
                File::makeDirectory($root_path, 0777, true, true);
            }



            $invoice_no = Invoice::find($request->bill_no)->invoice_number;

            $new_receipt = new Receipt();

           $receipt_no =  $new_receipt->receiptNumber();
           $date =  $request->date;
           $newDate = date("Y-m-d", strtotime($date));

            $receipt = Receipt::updateOrCreate(
                [
                      'id'=>null
                ],

                [
                      'created_by'=>auth()->user()->id,
                      'currency_id'=>1,
                      'invoice_id'=>$request->bill_no,
                      'payer'=>$full_name,
                      'reference'=>$invoice_no,
                      'remarks'=>$request->remarks,
                      'date'=>$newDate,
                      'status'=>3,
                      'receipt_no'=>$receipt_no

                  ]

            );
            // $path = $request->file('attachment_file')->storeAs('student/'.$id.'/attachments/'.$request->attachments.'', $avatar_name, 'public',true);
            $path = '';
            if ($request->hasfile('payment_attachment')) {

                $avatar_name= $request->file('payment_attachment')->getClientOriginalName();
                $path = $request->file('payment_attachment')->storeAs('student/'.$student_id.'/invoices/'.$invoice_id.'/receipts/'.$receipt->id.'', $avatar_name, 'public',true);
            }

            PaymentAttachment::create([
                'invoice_id'=> $invoice_id,
                'path'=> $path,
                'receipt_id'=>$receipt->id
            ]);

            $invoice_items = Invoice::find($request->bill_no)->invoiceItems;
            $desc = '';
            foreach ($invoice_items as $index => $invoice_item) {
                if ($index == 0) {
                    $desc .= $invoice_item->descriptions;
                } else {
                    $desc .= ','.$invoice_item->descriptions;
                }
            }


            if ($receipt) {
                $receipt_items = ReceiptItem::updateOrCreate(
                    [
                            'id'=>null,
                        ],
                    [
                            'quantity'=>1,
                            'receipt_id'=>$receipt->id,
                            'rate'=>str_replace(',', '', $request->amt_paid),
                            'tax_id'=>1,
                            'exchange_rate'=>1,
                            'descriptions'=>$desc
                        ]
                );
            }

            DB::commit();

            if ($receipt_items) {

                Session::flash('message', 'Payment is Submitted...Please kindly Wait for Confirmation');
                $data = ['state'=>'Done'];

                return response($data);

            }

            $data = ['state'=>'Fail', 'msg'=>'Payment not success', 'title'=>'Fail'];
            return response($data);

        } catch (QueryException $e) {
            // return back()->withInput();
            // $data = ['state'=>'Error', 'msg'=>'Database Error', 'title'=>'Error'];
            // return response($data);
            return $e->getMessage();
        }
    }



    public function receiptsSavePrint(Request $request)
    {

        // return ;
        try {
            DB::beginTransaction();
            $full_name = AccountStudentDetail::find($request->student)->full_name;
            $invoice_no = Invoice::find($request->bill_no)->invoice_number;
            $invoice_id = $request->bill_no;
            $root_path = public_path('storage/student/');
            $student_id = $request->student;
            $path = '';

            if(!is_dir($root_path)){
                File::makeDirectory($root_path, 0777, true, true);
            }

            $new_receipt = new Receipt();

            $receipt_no =  $new_receipt->receiptNumber();
            $date =  $request->date;
            $newDate = date("Y-m-d", strtotime($date));
            $receipt = Receipt::updateOrCreate(
                [
                      'id'=>null
                  ],
                [
                      'created_by'=>auth()->user()->id,
                      'currency_id'=>1,
                      'invoice_id'=>$request->bill_no,
                      'payer'=>$full_name,
                      'reference'=>$invoice_no,
                      'remarks'=>$request->remarks,
                      'date'=>$newDate,
                      'status'=>1,
                      'receipt_no'=>$receipt_no

                  ]
            );

            if ($request->hasfile('payment_attachment')) {

                $avatar_name= $request->file('payment_attachment')->getClientOriginalName();
                $path = $request->file('payment_attachment')->storeAs('student/'.$student_id.'/invoices/'.$invoice_id.'/receipts/'.$receipt->id.'', $avatar_name, 'public',true);
            }

            PaymentAttachment::create([
                'invoice_id'=> $invoice_id,
                'path'=> $path,
                'receipt_id'=>$receipt->id
            ]);



            $invoice_items = Invoice::find($request->bill_no)->invoiceItems;
            $desc = '';
            foreach ($invoice_items as $index => $invoice_item) {
                if ($index == 0) {
                    $desc .= $invoice_item->descriptions;
                } else {
                    $desc .= ','.$invoice_item->descriptions;
                }
            }


            if ($receipt) {
                $receipt_items = ReceiptItem::updateOrCreate(
                    [
                            'id'=>null,
                        ],
                    [
                            'quantity'=>1,
                            'receipt_id'=>$receipt->id,
                            'rate'=>str_replace(',', '', $request->amt_paid),
                            'tax_id'=>1,
                            'exchange_rate'=>1,
                            'descriptions'=>$desc
                        ]
                );
            }

            DB::commit();

            if ($receipt_items) {

               return redirect()->route('accounts.receipt.pdf',[$request->bill_no,$receipt->id]);

            }

        } catch (QueryException $e) {
            // return back()->withInput();
            return $e->getMessage();
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


    public function receiptsCreate(){
        $data['activeLink']='receipts';
        $data['students'] = AccountStudentDetail::all();

        return view('accounts::receipts.create')->with($data);
    }

    public function studentsInvoiceFilter(Request $request){
        $student_id = $request->student_id;
        $student_invoices_html = '';
        $student_invoices_html .= '<option> Select Bill to Pay  </option>';
        $data = array();

         $studentsInvoices = AccountStudentDetail::find($student_id)->account->invoices;

        foreach($studentsInvoices as $student_invoice){
            $student_invoices_html .= '<option value="'.$student_invoice->id.'"> '.$student_invoice->invoice_number.'</option>';
        }

        return $student_invoices_html;


    }


    public function selectedBillFilter(Request $request){
        $selected_bill = $request->invoice_id;
        // return Invoice::find($selected_bill)->invoiceItems[0]->SUM('rate')->get();
        $invoice_amount = Invoice::find($selected_bill)->invoiceItems->SUM('rate');
        $paid_amount = number_format(Invoice::find($selected_bill)->amount_paid);
        $amount = number_format($invoice_amount);

    $invoice_items = Invoice::find($request->invoice_id)->invoiceItems;
        $html = '';
         foreach ($invoice_items as $key => $invoice_item) {
            /*  return $invoice_item; */
              $html .= ' <tr>
                 <td scope="row">
                 <div class="checkbox d-inline-block mr-3">
                           <input type="checkbox" name="checkboxes[]" class="checkbox-input checkboxes" value="'.$invoice_item->rate.'" disabled checked>
                           <label for="checkbox1">'.$invoice_item->descriptions.'</label>
                        </div>

                   </td>
                       <td> <input style="text-align:right" name="amount[]" type="text" class="form-control" value="'.$invoice_item->rate.'" readonly>  </td>

                   </tr>';

        }

        $data = array();
        $data = [
            'amount'=>$amount,
            'paid'=>$paid_amount,
            'invoice_items_html'=>$html,
        ];
        return response()->json($data);


    }


  public function filterStudentByClass(Request $req){

    try {

        $student_details_html = '';
        $student_details_html .= '<option> Select Student  </option>';
        $data = array();

        $students = AccountSchoolDetailClass::find($req->class_id)->students;

        foreach($students as $student){
            $student_details_html .= '<option value="'.$student->id.'"> '.$student->full_name.'</option>';
        }
        if($students){

             $data = ['state'=> 'Done', 'msg' => $student_details_html , 'title'=>'success'];
             return response($data);
        }

        $data = ['state'=> 'Fail', 'msg' => 'Selected Class has No students' , 'title'=>'success'];
        return response($data);

    } catch (QueryException $e) {

        $data = ['state'=> 'Error', 'msg' => 'Database Error'.$e->getMessage(), 'title'=>'Error'];
        return response($data);

    }

  }

    public function filterFeeStructure(Request $request){


    //  return $request->all();
       $c_id = $request->class_id;
        //$s_id = $request->term;
        $season_id = $request->academic_season;
        $std_id = $request->account_id;

        $acc_id = AccountStudentDetail::find($std_id)->account_id;

        return redirect()->route('accounts.invoices.create',[encrypt($c_id),encrypt($acc_id),encrypt($std_id),encrypt($season_id)]);


    }





    public function printing(Request $request){

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

            if (!empty($request->get('class_id'))) {

            $invoices =  $invoices->where('account_student_details.account_school_details_class_id',$request->get('class_id'));

            }

            if (!empty($request->get('stream_id'))) {

            $invoices =  $invoices->where('account_student_details.account_school_detail_stream_id',$request->get('stream_id'));
            }


         if ($request->file_type == 'pdf') {
             // return 'pdf';

             $pdf = FacadePdf::loadView('accounts::printouts.invoice_list_pdf', $data);

             return $pdf->stream('students_invoice_list.pdf', array("Attachment" => false));

         }
         if ($request->file_type == 'excel') {
            $pdf = FacadePdf::loadView('accounts::printouts.invoice_list_pdf', $data);
             return FacadesExcel::download(new InvoiceExport , 'students_invoice_list.xlsx');

         }

     }


    public function individualInvoiceDatatable(Request $request,$id){


        try {
            // return $id;
            $student_invoices = [];

            $account_id = AccountStudentDetail::find($id)->account_id;
            $innit = Invoice::where('account_id',$account_id);

            if (!empty($request->get('year_id'))) {

                $innit =  $innit->where('season_id',$request->get('year_id'));

            }
            $invoices = $innit->get();

            foreach($invoices as $invoice){
                $billed_amount = $invoice->invoiceItems()->sum('rate');
                $paid_amount = $invoice->receiptItems()->sum('rate');
                $balance = $billed_amount - $paid_amount;
                // if ( $balance > 0){
                $acc_id = $invoice->account_id;
                $student = AccountStudentDetail::where('account_id',$acc_id)->first();
                $student_invoices[] = ['invoice_number'=>$invoice->invoice_number,'invoice_id'=>$invoice->id,'student_id'=>$student->id, 'date' => $invoice->date, 'billed_amount'=>$billed_amount, 'amount_paid'=>$paid_amount, 'balance'=> $balance ];
            }

            return DataTables::of($student_invoices)

            ->addColumn('paid',function($invoice){

                return number_format($invoice['amount_paid']);
            })
            ->addColumn('balance',function($invoice){
               return number_format($invoice['balance']);

            })
            ->editColumn('date',function($invoice){
              return  date("jS M, Y", strtotime("".$invoice['date'].""));

             })

            // date("M jS, Y", strtotime("".$receipts[0]->receipt_date.""))  /* DATE FORMAT */
            ->addColumn('amount',function($invoice){

                return  number_format($invoice['billed_amount']);
            })

            ->addColumn('action', function($invoice) {
              $button = '';
                         $button .= '  <a target="_blank" href="'.route('accounts.invoices.pdf',$invoice['invoice_id']).'" class="button-icon button btn btn-sm rounded-small btn-success  more-details-1"><i class="fa fa-eye m-0"></i></a>';
                        //  $button .= ' <a href="" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i></a>';
                        //  $button .= ' <a href="" data-original-title="Delete" data-fee_dlt_id="'.$invoice->invoice_id.'"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  fee-structure-delete" ><i class="fa fa-trash  m-0"></i></a>';

              return '<nobr>'.$button. '</nobr>';
              })
          ->rawColumns(['action'])
          ->make();


               //code...
           } catch (QueryException $e) {
              return $e->getMessage();
           }

    }


    public function debtorsList(){
        $data['activeLink'] = 'debtors_list';
        return view('accounts::debtors.index')->with($data);
    }


    public function debtorsListDatatable(Request $request){

        $students = $this->std_model::join('account_school_detail_classes', 'account_student_details.account_school_details_class_id','=','account_school_detail_classes.id')
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
                 $billed_amount = 0;
                 $balance = 0;
                 
                 foreach($invoices as $invoice){

                    $receipts = $invoice->receipts;
                    foreach($receipts as $receipt_item){

                        if($receipt_item->status == 3){
                            $paid_amount += $receipt_item->receiptItems()->sum('rate');
                        }
                        // return $paid_amount;

                    }
        
                    $billed_amount += $invoice->invoiceItems()->sum('rate');
                }
                 $balance = $billed_amount - $paid_amount;
                if ( $balance > 0){
                    $debtors[] = ['invoice_number'=>$invoice->invoice_number,'invoice_id'=>$invoice->id,'student_id'=>$student->student_id, 'student_name'=>''.$student->first_name.' '.$student->last_name.'', 'date' => $invoice->date, 'billed_amount'=>$billed_amount, 'amount_paid'=>$paid_amount, 'balance'=> $balance ];
                }
     
                 }

    //    $invoices = Invoice::select('invoices.*')
    //     ->join('accounts','invoices.account_id','=','accounts.id')
    //     ->join('account_student_details','accounts.id','=','account_student_details.account_id')
    //     ->groupBy('account_student_details.id')
    //     ->get();


        // $debtors = array();
        // foreach($invoices as $invoice){

        //     $receipts = $invoice->receipts;
        //     $paid_amount = 0;
        //     foreach($receipts as $receipt_item){
        //         if($receipt_item->status == 3){
        //             $paid_amount += $receipt_item->receiptItems()->sum('rate');
        //         }
        //     }

        //     $billed_amount = $invoice->invoiceItems()->sum('rate');
        //     $balance = $billed_amount - $paid_amount;
        //     if ( $balance > 0){
        //         $acc_id = $invoice->account_id;
        //        $student = AccountStudentDetail::where('account_id',$acc_id)->first();
        //         $debtors[] = ['invoice_number'=>$invoice->invoice_number,'invoice_id'=>$invoice->id,'student_id'=>$student->id, 'student_name'=>''.$student->full_name.'', 'date' => $invoice->date, 'billed_amount'=>$billed_amount, 'amount_paid'=>$paid_amount, 'balance'=> $balance ];
        //     }
        // }

        // return $debtors;

        return DataTables::of($debtors)

            ->addColumn('billed_amount',function($row){
                return number_format($row['billed_amount']);
            })

            ->addColumn('amount_paid',function($invoice){
                return number_format($invoice['amount_paid']);
            })
            ->addColumn('balance',function($invoice){
                return number_format($invoice['balance']);
            })
            ->addColumn('action', function($invoice){
                $debtor = AccountStudentDetail::find($invoice['student_id']);
                $button = '';
                $button .= '  <a href="'.route('accounts.individual.debtors.list',encrypt($invoice['student_id'])).'" class="button-icon button btn btn-sm rounded-small btn-primary  more-details-1"><i class="fa fa-eye m-0"></i></a>';
                return '<nobr>'.$button. '</nobr>';
              })

      ->rawColumns(['action'])
      ->make();

    }

    public function individualDebtorsList($id){
        $id = decrypt($id);
        $data['activeLink'] = 'debtors_list';
        $data['id']=$id;
        $data['students_name'] = AccountStudentDetail::find($id)->full_name;
        return view('accounts::debtors.individual_debts')->with($data);
    }


    public function individualDebtorsListDatatable($id){


        $debtors = Invoice::select('invoices.*')
        ->join('accounts','invoices.account_id','=','accounts.id')
        ->join('account_student_details','accounts.id','=','account_student_details.account_id')
        ->where('account_student_details.id',$id)
         ->groupBy('invoices.id')
        ->get();


        $debtors = array();
        $account_id = AccountStudentDetail::find($id)->account_id;
        $invoices = Invoice::where('account_id',$account_id)->get();
        foreach($invoices as $invoice){
            $billed_amount = $invoice->invoiceItems()->sum('rate');
            $paid_amount = $invoice->receiptItems()->sum('rate');
            $balance = $billed_amount - $paid_amount;
            if ( $balance > 0){
                $acc_id = $invoice->account_id;
               $student = AccountStudentDetail::where('account_id',$acc_id)->first();
                $debtors[] = ['invoice_number'=>$invoice->invoice_number,'invoice_id'=>$invoice->id,'student_id'=>$student->id, 'date' => $invoice->date, 'billed_amount'=>$billed_amount, 'amount_paid'=>$paid_amount, 'balance'=> $balance ];
            }
        }

        return DataTables::of($debtors)

        ->addColumn('invoice_date',function($invoice){

            return date("M jS, Y", strtotime("".$invoice['date'].""));
        })

        ->addColumn('paid_amount',function($invoice){

            return number_format($invoice['amount_paid']);
        })
        ->addColumn('balance',function($invoice){

        return number_format($invoice['balance']);

        })

        // date("M jS, Y", strtotime("".$receipts[0]->receipt_date.""))  /* DATE FORMAT */

        ->addColumn('billed_amount',function($invoice){

           return  number_format($invoice['billed_amount']);

        })

        ->addColumn('action', function($debtor) {
          $button = '';
          $button .= '  <a target="_blank" href="'.route('accounts.invoices.pdf',$debtor['invoice_id']).'" class="button-icon button btn btn-sm rounded-small btn-primary  more-details-1"><i class="fa fa-eye m-0"></i></a>';
          return '<nobr>'.$button. '</nobr>';
          })

      ->rawColumns(['action'])
      ->make();
    }



    public function generateDebtorsListPdf(){

        $data['school_info'] = AccountSchoolDetail::first();
        $data['school_info'] = AccountSchoolDetail::first();
        $data['address'] =  Contact::where('contactable_type',AccountSchoolDetail::class)
                            ->where('contact_type_id',3)->first()->contact;
        $data['phone'] = Contact::where('contactable_type',AccountSchoolDetail::class)
                        ->where('contact_type_id',1)->first()->contact;

        $data['email'] = Contact::where('contactable_type',AccountSchoolDetail::class)
        ->where('contact_type_id',2)->first()->contact;

      $students = $this->std_model::join('account_school_detail_classes', 'account_student_details.account_school_details_class_id','=','account_school_detail_classes.id')
      ->leftjoin('account_school_detail_streams','account_student_details.account_school_detail_stream_id','=','account_school_detail_streams.id')
      ->select('account_student_details.id as student_id','account_student_details.first_name','account_student_details.last_name','account_school_detail_classes.name as class_name','account_school_detail_streams.name as stream_name')
      ->get();
   
               $collection = array();
   
               $total_billed_amount = 0;
               $total_paid_amount = 0;
               $all_total_billed_amount = 0;
               $all_total_paid_amount = 0;
   
               foreach ($students as $key => $student) {
               $invoices = Invoice::select('invoices.*')
               ->join('accounts','invoices.account_id','=','accounts.id')
               ->join('account_student_details','accounts.id','=','account_student_details.account_id')
               ->where('account_student_details.id',$student->student_id)
               ->groupBy('invoices.id')
               ->get();
               $paid_amount = 0;
               $billed_amount = 0;
               $balance = 0;
               
               foreach($invoices as $invoice){

                  $receipts = $invoice->receipts;
                  foreach($receipts as $receipt_item){

                      if($receipt_item->status == 3){
                          $paid_amount += $receipt_item->receiptItems()->sum('rate');
                      }
                      // return $paid_amount;

                  }
      
                  $billed_amount += $invoice->invoiceItems()->sum('rate');
              }
              $all_total_billed_amount += $billed_amount;
              $all_total_paid_amount += $paid_amount;
               $balance = $billed_amount - $paid_amount;
              if ( $balance > 0){
                $total_billed_amount += $billed_amount;
                $total_paid_amount += $paid_amount;
                  $debtors[] = ['invoice_number'=>$invoice->invoice_number,'invoice_id'=>$invoice->id,'student_id'=>$student->id, 'name'=>''.$student->first_name.' '.$student->last_name.'', 'date' => $invoice->date, 'billed_amount'=>$billed_amount, 'amount_paid'=>$paid_amount, 'balance'=> $balance ];
              }
   
               }
      

      $data['debtors'] = $debtors;
      $data['total_billed_amount'] = $total_billed_amount;
      $data['total_paid_amount'] = $total_paid_amount;
      $data['total_balance'] = $total_billed_amount - $total_paid_amount;

               /* ALL STUDENTS RECORDS DEBTORS OR NOT */
      $data['all_total_billed_amount'] = $all_total_billed_amount;
      $data['all_total_paid_amount'] = $all_total_paid_amount;
      $data['all_total_balance'] = $all_total_billed_amount - $all_total_paid_amount;

    //  return view('accounts::debtors.printouts.debts_pdf')->with($data);

         $pdf = FacadePdf::loadView('accounts::debtors.printouts.debts_pdf', $data);

        return $pdf->stream('debtors_list.pdf',array("Attachment" => false));
     }


     public function generateIndividualDebtorsListPdf($id){



        $debtors = array();
        $account_id = AccountStudentDetail::find($id)->account_id;


        $invoices = Invoice::where('account_id',$account_id)->get();


    foreach ($invoices as $invoice) {
    $billed_amount = $invoice->invoiceItems()->sum('rate');
    $paid_amount = $invoice->receiptItems()->sum('rate');
    $balance = $billed_amount - $paid_amount;

    if ($balance > 0) {
        $acc_id = $invoice->account_id;
        $student = AccountStudentDetail::where('account_id', $acc_id)->first();
        $debtors[] = ['invoice_number'=>$invoice->invoice_number,'invoice_id'=>$invoice->id,'student_id'=>$student->id, 'date' => $invoice->date, 'billed_amount'=>$billed_amount, 'amount_paid'=>$paid_amount, 'balance'=> $balance ];
    }
}
    $data['debtors'] = $debtors;

        $total_billed = 0;
        $total_paid_amount = 0;
        foreach($debtors as $debtor){
            if($debtor['billed_amount'] - $debtor['amount_paid'] ){

            $total_billed += $debtor['billed_amount'];
            $total_paid_amount += $debtor['amount_paid'];

            }

        }
        $data['total_billed_amount'] = $total_billed;
        $data['total_paid_amount'] = $total_paid_amount;
        $data['total_balance'] = $total_billed - $total_paid_amount;
        $data['full_name'] = AccountStudentDetail::find($id)->full_name;

        $pdf = FacadePdf::loadView('accounts::debtors.printouts.individual_debts_list_pdf', $data);

        return $pdf->stream('debtors_list.pdf',array("Attachment" => false));
     }


/* TO BE WORKED ON */

     public function generateIndividualDebtorPdf($id){

     $data['particulars'] = Invoice::join(
        'invoice_items','invoices.id','invoice_items.invoice_id'
    )
    ->join('accounts','invoices.account_id','=','accounts.id')
    ->join('account_student_details','accounts.id','=','account_student_details.account_id')
    ->join('account_school_details','account_student_details.account_school_details_id','account_school_details.id')
    ->select('invoices.date as invoice_date','invoices.invoice_number','accounts.name','invoices.id as invoice_id',
    'account_school_details.name as school_name'
    )
    ->selectRaw('SUM(invoice_items.rate) as amount')
    ->where('invoices.id',$id)
    ->groupBy('invoices.id')
    ->get()[0];

     $data['school_details'] = Invoice::find($id)->account->students[0]->school()->with(['contactable','villages'])->get();

    $pdf = FacadePdf::loadView('accounts::debtors.printouts.individual_debts_pdf', $data);

    return $pdf->stream('student_invoice.pdf',array("Attachment" => false));

     }

     public function generateReceiptsPdf($id){

        $data['receipts'] = $receipts = Invoice::find($id)->with(['receipts','invoiceItems','receipts.receiptItems','account.students'])->where('invoices.id',$id)->first();
        $class =  AccountSchoolDetailClass::find($receipts->account->students[0]->account_school_details_class_id)->name;
        AccountSchoolDetailStream::find($receipts->account->students[0]->account_school_detail_stream_id) ? $stream = AccountSchoolDetailStream::find($receipts->account->students[0]->account_school_detail_stream_id)->name : $stream = '';
        $stream ? $data['class_stream'] = $class .' - '. $stream : $data['class_stream'] = $class;

        $data['school_details'] = Invoice::find($id)->account->students[0]->school()->with(['contactable','street'])->first();

        $data['address'] =  Contact::where('contactable_type',AccountSchoolDetail::class)
        ->where('contact_type_id',3)->first()->contact;
        $data['phone'] = Contact::where('contactable_type',AccountSchoolDetail::class)
       ->where('contact_type_id',1)->first()->contact;

       $data['email'] = Contact::where('contactable_type',AccountSchoolDetail::class)
        ->where('contact_type_id',2)->first()->contact;

        return  view('accounts::receipts.printouts.new_receipt_pdf', $data);

       $pdf = FacadePdf::loadView('accounts::receipts.printouts.new_receipt_pdf', $data);

        return $pdf->stream('receipts.pdf',array("Attachment" => false));

     }

     public function generateOneReceiptPdf($id,$receipt_id){

         $data['receipts'] = $receipts = Invoice::find($id)->receipts;
         $data['receipts'] = $receipts = Receipt::join('invoices','receipts.invoice_id','=','invoices.id')
                ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
                ->join('receipt_items', 'receipts.id','=','receipt_items.receipt_id')
                ->join('accounts','accounts.id','=','invoices.account_id')
                ->join('account_student_details', 'accounts.id', '=', 'account_student_details.account_id')
                ->where('invoices.id',$id)
                ->where('receipts.id',$receipt_id)
                ->first();

         $data['billed_amount'] = Invoice::find($id)->getTotalInvoiceAttribute();
 
         $class =  AccountSchoolDetailClass::find($receipts->account_school_details_class_id)->name;
         $data['school_info'] = AccountSchoolDetail::first();
        $data['address'] =  Contact::where('contactable_type',AccountSchoolDetail::class)
                            ->where('contact_type_id',3)->first()->contact;
        $data['phone'] = Contact::where('contactable_type',AccountSchoolDetail::class)
                        ->where('contact_type_id',1)->first()->contact;

        $data['email'] = Contact::where('contactable_type',AccountSchoolDetail::class)
        ->where('contact_type_id',2)->first()->contact;

         AccountSchoolDetailStream::find($receipts->account_school_detail_stream_id) ?  $stream = AccountSchoolDetailStream::find($receipts->account_school_detail_stream_id)->name :   $stream = '';
        // $stream ? $data['class_stream'] =  $stream :  $data['class_stream'] = $class;
        $data['class_stream'] = $stream;

        $data['school_details'] = Invoice::find($id)->account->students[0]->school()->with(['contactable','street'])->first();

        //  return  view('accounts::receipts.printouts.single_receipt_pdf', $data);

        $pdf = FacadePdf::loadView('accounts::receipts.printouts.single_receipt_pdf', $data);

         return $pdf->stream('receipts.pdf',array("Attachment" => false));

      }




      public function accountSubGroupIndex(){

        $data['activeLink'] = 'account_group';

        $account_groups = AccountSubGroup::where('parent_group','!=',NULL)->get();


        foreach ($account_groups as $key => $group) {
          # code...
          $data['groups'][$group->id] = $group->name;
          
        }

        // $data['sub_groups'][0] = '';
        // foreach (AccountSubGroup::all() as $sub_group) {
        //     # code...
        //     $data['sub_groups'][$sub_group->id] = $sub_group->name;

        // }

        // return $data;
          $data['groups'] =  json_encode( $data['groups'] );
        //   $data['sub_groups'] = json_encode( $data['sub_groups']);



    // return $account_groups;

    //   foreach ($account_groups as $key => $group) {
        # code...
    //     $data['groups'][strtolower($group->name) ] = $group;

    //   }
    //   return $data['groups'];
        // return view('accounts::sub_groups.index')->with($data);

        return view('accounts::sub_groups.index')->with($data);

      }

     public function accountSubGroupForm(){

        $data['activeLink'] = 'account_group';
       return $data['account_groups'] = $account_sub_groups = AccountSubGroup::where('parent_group','!=','')->get();
        // $data['account_groups'] = DB::select('SELECT * FROM '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups');
        return view('accounts::sub_groups.form')->with($data);

     }


    public function accountSubGroupDatatable(){
       $data['account_groups'] = $account_sub_groups = $account_sub_groups = AccountSubGroup::where('parent_group','!=','')->get();
   
           return DataTables::of($account_sub_groups)
   
       ->make();

   
       }


       public function collectionIndex(){

        $data['classes'] = $this->class_model::all();
        $data['activeLink'] = 'collection';
        return view('accounts::collection.index')->with($data);

       }

       public function collectionPrint(Request $request){

        $data['school_info'] = AccountSchoolDetail::first();
        $data['school_info'] = AccountSchoolDetail::first();
        $data['address'] =  Contact::where('contactable_type',AccountSchoolDetail::class)
                            ->where('contact_type_id',3)->first()->contact;
        $data['phone'] = Contact::where('contactable_type',AccountSchoolDetail::class)
                        ->where('contact_type_id',1)->first()->contact;

        $data['email'] = Contact::where('contactable_type',AccountSchoolDetail::class)
        ->where('contact_type_id',2)->first()->contact;
        
   $students = $this->std_model::join('account_school_detail_classes', 'account_student_details.account_school_details_class_id','=','account_school_detail_classes.id')
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
 
         if ($request->file_type == 'pdf') {
             // return 'pdf';
             
             $pdf = FacadePdf::loadView('accounts::collection.printouts.pdf', $data);

             return $pdf->stream('collection.pdf', array("Attachment" => false));
             
         }
         if ($request->file_type == 'excel') {
             return FacadesExcel::download(new StudentCollectionExport, 'collection.xlsx');
         }

       }

       public function collectionDatatable(Request $request){

        $students = $this->std_model::join('account_school_detail_classes', 'account_student_details.account_school_details_class_id','=','account_school_detail_classes.id')
        ->leftjoin('account_school_detail_streams','account_student_details.account_school_detail_stream_id','=','account_school_detail_streams.id')
        ->join('accounts','account_student_details.account_id','=','accounts.id')
        ->join('invoices','accounts.id','=', 'invoices.account_id')
        ->join('receipts','invoices.id','=','receipts.invoice_id')
        ->select('receipts.date as receipt_date','account_student_details.id as student_id','account_student_details.first_name','account_student_details.last_name','account_school_detail_classes.name as class_name','account_school_detail_streams.name as stream_name')
        ->groupBy('account_student_details.id')
        ;

        if (!empty($request->get('class_id'))) {

            $students =  $students->where('account_student_details.account_school_details_class_id',$request->get('class_id'));
     
                 }
     
                 if (!empty($request->get('stream_id'))) {
     
                     $students =  $students->where('account_student_details.account_school_detail_stream_id',$request->get('stream_id'));
     
                 }
     
                 if (!empty($request->get('from_date'))  && empty($request->get('to_date'))) {
     
                     $from = date($request->from_date);
                     $students =  $students->whereDate('receipts.date', '>=', $from);
     
                 }
     
                 if (!empty($request->get('to_date')) && empty($request->get('from_date'))) {
     
                     $to = date($request->to_date);
                     $students =  $students->whereDate('receipts.date', '<=', $to);
     
                 }
     
                 if(!empty($request->get('to_date')) && !empty($request->get('from_date'))){
     
                     $from = date($request->from_date);
                     $to = date($request->to_date);
                     $students = $students->whereBetween('receipts.date', [$from, $to]);
     
                 }

                 $students = $students->get();
      
        $collection = array();

       

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
                $collection[] = ['class'=>$student->class_name,'stream'=>$student->stream_name, 'student_id'=>$student->student_id, 'student_name'=>''.$student->first_name.' '.$student->last_name .'', 'amount_paid'=>$paid_amount ];
            }
           
        }

        return DataTables::of($collection)

            ->addColumn('amount_paid',function($col){
                return number_format($col['amount_paid']);
            })

            ->addColumn('class', function ($col){
                return $col['class'];
            })

            ->addColumn('stream', function ($col){
                return $col['stream'];
            })

      ->rawColumns(['action'])
      ->make();     

       }


     public function accountSubGroupStore(Request $request){

        try {
            DB::beginTransaction();
            switch ($request->action){
                case 'edit':
                    $fee_type_group = AccountSubGroup::updateOrCreate(
                        [
                            'id'=>$request->sub_group_id
                        ],
                        [
                            'name'=>$request->sub_group_name,
                            'account_group_id'=>$request->group_name
                        ]
                    );
                    break;
                case 'delete':
                    $fee_type_group = AccountSubGroup::find($request->sub_group_id);
                    $fee_type_group->delete();
                    break;
                case 'create':
                    $fee_type_group = AccountSubGroup::updateOrCreate(
                        [
                            'id'=>$request->sub_group_id
                        ],
                        [
                            'name'=>$request->sub_group_name,
                            'account_group_id'=>$request->group_name
                        ]
                    );
                    break;
            }
            DB::commit();
            $data['message'] = 'success';
            return response($data);
        } catch (QueryException $e) {
            $data['message'] = $e;
            return response($data);
        }
        
     }


     public function accountLedgerIndex(){

        $data['activeLink'] = 'account_ledger';

        $account_groups = AccountSubGroup::where('parent_group','!=',NULL)->get();
        foreach ($account_groups as $key => $group) {
          # code...
          $data['groups'][$group->id] = $group->name;
          
        }

        $sub_groups = AccountSubGroup::where('parent_group','!=',NULL)->get();
        $data['sub_groups'][0] = '';
        foreach ($sub_groups as $sub_group) {
            # code...
            $data['sub_groups'][$sub_group->id] = $sub_group->name;

        }

        // return $data;
          $data['groups'] =  json_encode( $data['groups'] );
          $data['sub_groups'] = json_encode( $data['sub_groups']);

          return view('accounts::account_ledger.index')->with($data);
     }


     public function accountLedgerStore(Request $request){

        try {
            // return $request->all();
           $opening_balance = str_replace(',', '', $request->opening_balance);
            $date = $request->date;
            $newDate = date("Y-m-d", strtotime($date));
            DB::beginTransaction();
            switch ($request->action){
                case 'edit':
                    $opening_balance =  $request->Dr ? $request->Dr : $request->Cr;
                    $ledger = Ledger::updateOrCreate(
                        [
                            'id'=>$request->ledger_id
                        ],
                        [
                            'name'=>$request->ledger_name,
                            'opening_balance'=>$opening_balance,
                            'opening_balance_date'=>$newDate,
                            'account'=>$request->account,
                            'transaction_type'=>$request->Dr ? 'Dr' : 'Cr',
                            'sub_group_id'=>$request->sub_group_id

                        ]
                    );
                    break;
                case 'delete':
                    $fee_type_group = Ledger::find($request->ledger_id);
                    $fee_type_group->delete();
                    break;
                case 'create':
                    $ledger = Ledger::updateOrCreate(
                        [
                            'id'=>$request->ledger_id
                        ],
                        [
                            'name'=>$request->ledger_name,
                            'opening_balance'=>$opening_balance,
                            'opening_balance_date'=>$newDate,
                            'account'=>$request->account,
                            'transaction_type'=>$request->transaction_type,
                            'sub_group_id'=>$request->sub_group_id
                        ]
                    );
                    break;
            }
            DB::commit();
            $data['message'] = 'success';
            return response($data);
        } catch (QueryException $e) {
            $data['message'] = $e;
            return response($data);
        }
        
     }

     public function accountLedgerDatatable(){
    //    $ledgers = Ledger::all();

        $ledgers = DB::select('SELECT ledgers.name as ledger_name,ledgers.transaction_type, ledgers.id as ledger_id,  ledgers.opening_balance, account_sub_groups.name as sub_group_name,  '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups.name as group_name, '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups.id as group_id FROM ledgers LEFT JOIN account_sub_groups ON ledgers.sub_group_id = account_sub_groups.id JOIN '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups ON ledgers.sub_group_id = '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups.id  ');
   
           return DataTables::of($ledgers)

           ->addColumn('Dr', function($ledger){

             return   $ledger->transaction_type == 'Dr' ?  number_format($ledger->opening_balance) :  '';

           })
           ->addColumn('Cr', function($ledger){

             return   $ledger->transaction_type == 'Cr' ?  number_format($ledger->opening_balance) :  '';

           })

           ->addColumn('sub_group_two', function(){

            return '';

           })
   
       ->make();
   
       }


       public function accountLedgerForm(){

        $data['account_sub_groups'] = AccountSubGroup::where('parent_group','!=',NULL)->get();
        $data['activeLink'] = 'account_ledger';
        return view('accounts::account_ledger.form')->with($data);

       }


       public function subAccountGroupPrinting(Request $request){
        

        $data['school_info'] = AccountSchoolDetail::first();
        $data['account_sub_groups'] = DB::select('SELECT account_sub_groups.id as sub_group_id,account_sub_groups.name as sub_group_name ,'.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups.name as group_name FROM account_sub_groups JOIN '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups ON account_sub_groups.account_group_id = '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups.id');
        $data['school_info'] = AccountSchoolDetail::first();
        $data['address'] =  Contact::where('contactable_type',AccountSchoolDetail::class)
                            ->where('contact_type_id',3)->first()->contact;
        $data['phone'] = Contact::where('contactable_type',AccountSchoolDetail::class)
                        ->where('contact_type_id',1)->first()->contact;

        $data['email'] = Contact::where('contactable_type',AccountSchoolDetail::class)
        ->where('contact_type_id',2)->first()->contact;
            
 
         if ($request->file_type == 'pdf') {
             // return 'pdf';
             
             $pdf = FacadePdf::loadView('accounts::sub_groups.printouts.pdf', $data);

             return $pdf->stream('account_sub_groups.pdf', array("Attachment" => false));
             
         }
         if ($request->file_type == 'excel') {
             return FacadesExcel::download(new AccountSubGroupsExport, 'account_sub_groups.xlsx');
 
         }

     }


     public function Ledgerprinting(Request $request){

        $data['school_info'] = AccountSchoolDetail::first();

        $data['ledgers'] = DB::select('SELECT ledgers.name as ledger_name,ledgers.transaction_type, ledgers.id as ledger_id,  ledgers.opening_balance, account_sub_groups.name as sub_group_name,  '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups.name as group_name FROM ledgers JOIN account_sub_groups ON ledgers.sub_group_id = account_sub_groups.id JOIN '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups ON account_sub_groups.account_group_id = '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups.id  ');
       
        $data['school_info'] = AccountSchoolDetail::first();
        $data['address'] =  Contact::where('contactable_type',AccountSchoolDetail::class)
                            ->where('contact_type_id',3)->first()->contact;
        $data['phone'] = Contact::where('contactable_type',AccountSchoolDetail::class)
                        ->where('contact_type_id',1)->first()->contact;

        $data['email'] = Contact::where('contactable_type',AccountSchoolDetail::class)
        ->where('contact_type_id',2)->first()->contact;
            
 
         if ($request->file_type == 'pdf') {
             // return 'pdf';
             
             $pdf = FacadePdf::loadView('accounts::account_ledger.printouts.pdf', $data);

             return $pdf->stream('ledgers.pdf', array("Attachment" => false));
             
         }
         if ($request->file_type == 'excel') {
             return FacadesExcel::download(new LedgersExport, 'ledgers.xlsx');
 
         }

     }
          /* ACCOUNTING TRANSACTIONS */

    public function paymentVoucherIndex(){

        $data['activeLink'] = 'payment_voucher';
        $data['classes'] = $this->class_model::all();
        return view('accounts::transactions.payment_voucher.index')->with($data);

    }

    public function contraVoucherForm(){
        $data['activeLink'] = 'contra_voucher';
        $data['ledgers'] = Ledger::all();
        $journal_instance = new Journal();
        $contra_no = $journal_instance->contra_no();
        $data['voucher_no'] = $contra_no;
        return view('accounts::transactions.contra_voucher.form')->with($data);

    }

    public function paymentVoucherForm(){
        $data['activeLink'] = 'payment_voucher';
        $data['ledgers'] = Ledger::all();
        $journal_instance = new Journal();
        $payment_voucher_no = $journal_instance->payment_voucher_no();
        $data['voucher_no'] = $payment_voucher_no;
        return view('accounts::transactions.payment_voucher.form')->with($data);

    }
    public function journalVoucherForm(){
        $data['activeLink'] = 'journal_voucher';
        $journal_instance = new Journal();
        $JV_NO = $journal_instance->journal_no();
        $data['voucher_no'] = $JV_NO;
        $data['ledgers'] = Ledger::all();
        return view('accounts::transactions.journal_voucher.form')->with($data);

    }
    public function receiptVoucherForm(){
        $data['activeLink'] = 'receipt_voucher';
        $data['ledgers'] = Ledger::all();
        return view('accounts::transactions.receipt_voucher.form')->with($data);

    }


    public function journalVoucherIndex(){
        $data['activeLink'] = 'journal_voucher';
        $data['classes'] = $this->class_model::all();
        return view('accounts::transactions.journal_voucher.index')->with($data);
    }


    public function receiptVoucherIndex(){
        $data['classes'] = $this->class_model::all();
        $data['activeLink'] = 'receipt_voucher';
        return view('accounts::transactions.receipt_voucher.index')->with($data);

    }


    public function contraVoucherIndex(){
        $data['classes'] = $this->class_model::all();
        $data['activeLink'] = 'contra_voucher';
        return view('accounts::transactions.contra_voucher.index')->with($data);

    }


    function receiptVoucherStore(Request $request){


        return $request->all();


    }

    function journalVoucherStore(Request $request){

try{
    $date =  $request->date;
    $newDate = date("Y-m-d", strtotime($date));
    DB::beginTransaction();
    $journal =  Journal::updateOrCreate(
        [
    'id'=>null,
    ],
        [
    'reference'=>$request->voucher_no,
    'type'=>'JOURNAL',
    'remarks'=>$request->remarks,
    'relationable_type'=>Journal::class,
    'relationable_id'=>null,
    'date'=>$newDate
    ]
    );
    
    if ($journal) {
        // return $invoice_items->rate;
    foreach($request->accounts as $index => $account ){
        $journal_item  = JournalItem::updateOrCreate(
            [
            'id'=>null,
        ],
            [
            'journal_id'=>$journal->id,
            'operation'=> isset($request->credit[$index]) ? 'CREDIT' : 'DEBIT',
            'account_id'=> $account,
            'amount'=> isset($request->credit[$index]) ? str_replace(',','',$request->credit[$index] ) : str_replace(',','',$request->debit[$index] ),
            'description'=>$request->description[$index]
        ]

        );

    }

    }
    DB::commit();


    if ($journal_item) {
        session()->flash('success','Record created successful');
        $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record created successful'];
        return response($data);

    }

    $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
    return  response($data);


} catch (QueryException $e) {
    return $e->getMessage();
    $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
    return  response($data);

}

    }

    function paymentVoucherStore(Request $request){


        try{

            // return $request->all();
            $date =  $request->date;
            $newDate = date("Y-m-d", strtotime($date));
            DB::beginTransaction();
            $journal =  Journal::updateOrCreate(
                [
            'id'=>null,
            ],
            [
            'reference'=>$request->voucher_no,
            'type'=>'CASH PAYMENT',
            'remarks'=>$request->remarks,
            'relationable_type'=>Journal::class,
            'relationable_id'=>null,
            'date'=>$newDate

            ]
            );
            
            if ($journal) {
            $credit_amount = 0;
            foreach($request->debit_accounts as $index => $account ){

                $credit_amount += str_replace(',','',$request->amount[$index] );

                $journal_item  = JournalItem::updateOrCreate(
                [
                    'id'=>null,
                ],
                    [
                    'journal_id'=>$journal->id,
                    'operation'=> 'DEBIT',
                    'account_id'=> $account,
                    'amount'=> str_replace(',','',$request->amount[$index]),
                    'description'=>$request->description[$index]
                ]
        
                );

                if($index == count($request->debit_accounts) - 1 ){

                    $journal_item  = JournalItem::updateOrCreate(
                        [
                            'id'=>null,
                        ],
                            [
                            'journal_id'=>$journal->id,
                            'operation'=> 'CREDIT',
                            'account_id'=> $request->credit,
                            'amount'=> $credit_amount,
                            'description'=>''
                        ]
                
                        );

                }
        
            }


            }
        
            DB::commit(); 

            if ($journal_item) {
                session()->flash('success','Record created successful');
                $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record created successful'];
                return response($data);
        
            }
        
            $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
            return  response($data);
        
        } catch (QueryException $e) {
            return $e->getMessage();
            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            return  response($data);
        
        }
 
    }

    function contraVoucherStore(Request $request){

    try{
        $date =  $request->date;
        $newDate = date("Y-m-d", strtotime($date));
        DB::beginTransaction();
        $journal =  Journal::updateOrCreate(
            [
        'id'=>null,
        ],
        [
        'reference'=>$request->voucher_no,
        'type'=>'CONTRA',
        'remarks'=>$request->description,
        'relationable_type'=>Journal::class,
        'relationable_id'=>null,
        'date'=>$newDate

        ]
        );
        
        if ($journal) {
            
            foreach($request->accounts as $index => $account ){
                $journal_item  = JournalItem::updateOrCreate(
                    [
                    'id'=>null,
                ],
                    [
                    'journal_id'=>$journal->id,
                    'operation'=> isset($request->credit[$index]) ? 'CREDIT' : 'DEBIT',
                    'account_id'=> $account,
                    'amount'=> isset($request->credit[$index]) ? str_replace(',','',$request->credit[$index] ) : str_replace(',','',$request->debit[$index] ),
                    'description'=>$request->description[$index]
                ]
        
                );
        
            }

        }
    
        DB::commit(); 

        if ($journal_item) {
            session()->flash('success','Record created successful');
            $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record created successful'];
            return response($data);
    
        }
    
        $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
        return  response($data);
    
    } catch (QueryException $e) {
        return $e->getMessage();
        $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
        return  response($data);
    
    }

        
    }

  

    function paymentVoucherDatatable(){

        $payment_vouchers = Journal::where('type','CASH PAYMENT');

        return DataTables::of($payment_vouchers)

        ->addColumn('no', function($entry){
            return '';
        })

        ->addColumn('amount', function($entry){
            return number_format($entry->journal_entries_amount);
        })

        ->addColumn('payee', function($entry){
            return '';
        })

        ->addColumn('payment_method', function($entry){
            return '';
        })

        ->editColumn('date', function($entry){

            return date("M jS, Y", strtotime("".$entry->date.""));

        })

        ->addColumn('action', function($entry){
            // accounts.payment.voucher.preview
            $button = '';
            $button .= '<div class="btn-group btn-group-sm" style="float: center;"> <a target="_blank" href="'.route('accounts.payment.voucher.preview',$entry->id).'" class="btn btn-sm btn-primary" style="float: center;">Preview</a></div>';
            return  $button;
        })
        ->rawColumns(['action'])
         ->make();
        
    }

    function journalVoucherDatatable(){

        $journal_entries = Journal::where('type','JOURNAL');

        return DataTables::of($journal_entries)

        ->addColumn('no', function($entry){
            return '';
        })

        ->addColumn('amount', function($entry){
            return number_format($entry->journal_entries_amount);
        })

        ->editColumn('date', function($entry){

            return date("jS M, Y", strtotime("".$entry->date.""));

        })

        ->addColumn('action', function($entry){
            $button = '';
           $button .= '<div class="btn-group btn-group-sm" style="float: center;"> <a target="_blank" href="'.route('accounts.journal.voucher.preview',$entry->id).'" class="btn btn-sm btn-primary" style="float: none;">Preview</a></div>';
           return  $button;
        })
        ->rawColumns(['action'])
         ->make();

    }

    function receiptVoucherDatatable(){
        
        $receipt_vouchers = Journal::where('type','CASH RECEIPT');

        return DataTables::of($receipt_vouchers)

        ->addColumn('no', function($entry){
            return '';
        })

        ->addColumn('amount', function($entry){
            return '';
        })

        ->addColumn('action', function($entry){
            return '';
        })
        ->rawColumns(['action'])
         ->make();

    }

    public function journalVoucherPreview($id){
  
  
    $data['journal_entry'] = $journal_entry = Journal::where('type','JOURNAL')->where('id',$id)->first();
    $data['journal_entry_items'] = $journal_items = $journal_entry->journalItems;

    $data['school_info'] = AccountSchoolDetail::first();
        $data['address'] =  Contact::where('contactable_type',AccountSchoolDetail::class)
                            ->where('contact_type_id',3)->first()->contact;
        $data['phone'] = Contact::where('contactable_type',AccountSchoolDetail::class)
                        ->where('contact_type_id',1)->first()->contact;

        $data['email'] = Contact::where('contactable_type',AccountSchoolDetail::class)
        ->where('contact_type_id',2)->first()->contact;

        $pdf = FacadePdf::loadView('accounts::transactions.journal_voucher.printouts.pdf', $data);

        return $pdf->stream('itsolutionstuff.pdf', array("Attachment" => false));
        
    }

    public function paymentVoucherPreview($id){
        $data['journal_entry'] = $journal_entry = Journal::where('type','CASH PAYMENT')->where('id',$id)->first();
        $data['journal_entry_items'] = $journal_items = $journal_entry->journalItems()->where('operation','CREDIT')->first();
    
        $data['school_info'] = AccountSchoolDetail::first();
            $data['address'] =  Contact::where('contactable_type',AccountSchoolDetail::class)
                                ->where('contact_type_id',3)->first()->contact;
            $data['phone'] = Contact::where('contactable_type',AccountSchoolDetail::class)
                            ->where('contact_type_id',1)->first()->contact;
    
            $data['email'] = Contact::where('contactable_type',AccountSchoolDetail::class)
            ->where('contact_type_id',2)->first()->contact;
    
            $pdf = FacadePdf::loadView('accounts::transactions.payment_voucher.printouts.pdf', $data);
    
            return $pdf->stream('payment_voucher.pdf', array("Attachment" => false));
            
        }


        public function contraVoucherPreview($id){
            $data['journal_entry'] = $journal_entry = Journal::where('type','CONTRA')->where('id',$id)->first();
            $data['journal_entry_items'] = $journal_items = $journal_entry->journalItems;
        
            $data['school_info'] = AccountSchoolDetail::first();
                $data['address'] =  Contact::where('contactable_type',AccountSchoolDetail::class)
                                    ->where('contact_type_id',3)->first()->contact;
                $data['phone'] = Contact::where('contactable_type',AccountSchoolDetail::class)
                                ->where('contact_type_id',1)->first()->contact;
        
                $data['email'] = Contact::where('contactable_type',AccountSchoolDetail::class)
                ->where('contact_type_id',2)->first()->contact;
        
                $pdf = FacadePdf::loadView('accounts::transactions.contra_voucher.printouts.pdf', $data);
        
                return $pdf->stream('contra_voucher.pdf', array("Attachment" => false));
                
            }

    function contraVoucherDatatable(){


        $contra_vouchers = Journal::where('type','CONTRA');

        return DataTables::of($contra_vouchers)

        ->addColumn('no', function($entry){
            return '';
        })

        ->addColumn('amount', function($entry){
            return number_format($entry->journal_entries_amount);
        })

        ->editColumn('date', function($entry){

            return date("jS M, Y", strtotime("".$entry->date.""));

        })

        ->addColumn('action', function($entry){
            $button = '';
            $button .= '<div class="btn-group btn-group-sm" style="float: center;"> <a target="_blank" href="'.route('accounts.contra.voucher.preview',$entry->id).'" class="btn btn-sm btn-primary" style="float: none;">Preview</a></div>';
            return  $button;
        })
        ->rawColumns(['action'])
         ->make();


        
    }




    /* FEE REMINDER SETTINGS */


   public function feeReminderIndex(){

    $data['activeLink'] = 'fee_reminder_settings';
    $data['semesters'] = Semester::all();
    $data['classes'] = AccountSchoolDetailClass::all();
    $data['academic_years'] = AccountSchoolDetailSeason::all();
    $data['bill_categories'] = FeeTypeGroup::where('parent_id',NULL)->get();
    return view('accounts::fee_reminder.index')->with($data);



   }


   public function feeReminderCreate(){

    $data['activeLink'] = 'fee_reminder_settings';
    return view('accounts::fee_reminder.form')->with($data);


    
}

public function feeReminderStore(Request $req){

try {

    // return $req->all();
   
    DB::beginTransaction();

    $amount  = str_replace(',','',$req->amount);

  $fee_reminder =  FeeReminderSetting::updateOrCreate(
        [
            'id'=>null
        ],
    
        [
    
            'bill_category_id'=>$req->category_id,
            'class_id'=>$req->class,
            'academic_year_id'=>$req->academic_year,
            'semester' => $req->semester,
            'amount'=> $amount,
            'counter'=> $req->counter,
            'period_btn_reminders'=>$req->period_btn_number
    
        ]
        );

        DB::commit();

        if($fee_reminder){

            $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record created successful'];
            return response($data);

        }

        $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
        return  response($data);

} catch (QueryException $e) {
    return $e->getMessage();
    $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
}
// return $req->all();


//    DB::commit(); 

//         if ($journal_item) {
//             session()->flash('success','Record created successful');
//             $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record created successful'];
//             return response($data);
    
//         }
    
//         $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
//         return  response($data);
    
//     } catch (QueryException $e) {
//         return $e->getMessage();
//         $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
//         return  response($data);
    
//     }
    
}
public function feeReminderDatatable(){


    $fee_reminders = FeeReminderSetting::all();

    return DataTables::of($fee_reminders)
    ->addColumn('amount',function($reminder){

        return number_format($reminder->amount);
    })
    ->addColumn('semester', function($reminder){

        // return $reminder->semester->name;
        return 'error';
    })
    ->rawColumns()
->make();

    
}


}
