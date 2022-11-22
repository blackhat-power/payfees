<?php

namespace Modules\Accounts\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ChartOfAccount;
use Yajra\DataTables\DataTables;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;
use App\Exports\ChartsOfAccountExport;
use App\Models\Contact;
use Illuminate\Support\Facades\Session;
use App\Models\AccountSubGroup;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $chart_of_account;

    public function __construct(ChartOfAccount $charts_of_account, AccountSubGroup $accounts )
    {
        $this->chart_of_account = $charts_of_account;
        $this->accounts = $accounts;
        
        
    }


    public function chartsOfAccountsIndex()
    {
        $data['activeLink'] = 'charts_of_accounts';
        $data['accounts'] = $this->accounts::all();
        $data['parent_groups'] = $groups = AccountSubGroup::where('parent_group',NULL)->get();

        return view('accounts::chartsOfAccounts.index')->with($data);

    }


    public function drawAccountTree()
    {
        $tree = '';
        if (sizeof($this->accounts) > 0){
            $tree .= '<ul>';
            foreach ($this->accounts as $account){
                $tree .= '<li><a href="#">'.$account->name.'</a><a class="float-right" href="#">'.$account->opening_balance_custom.'</a>';
                $tree .= $account->drawAccountTree();
                $tree .= '</li>';
            }
            $tree .= '</ul>';
        }

        return $tree;
          
    }

    public function getOpeningBalanceAttribute()
    {
        $opening_balance =  AccountOpeningBalance::where('account_id', $this->id)->first();
        return $opening_balance ? $opening_balance->amount : 0;
    }

    public function getOpeningBalanceCustomAttribute()
    {
        $opening_balance =  AccountOpeningBalance::where('account_id', $this->id)->first();
        return $opening_balance ? $this->currency->symbols.' '.$opening_balance->amount : '';
    }


    public function chartsOfAccountForm($id=null){

        
        $data['code'] ='';
        $data['account_name'] = '';
        $data['currency'] = '';
        $data['account_group_id'] = '';

        if($id){
            $model = $this->chart_of_account::find($id);
            $data['code'] = $model->code;
            $data['account_name'] = $model->account_name;
            $data['currency'] = $model->currency;
            $data['account_group_id'] = $model->account_group_id;

        }

        $data['activeLink'] = 'charts_of_accounts';
        $data['id'] = $id;
        $data['account_groups'] = DB::select('SELECT * FROM '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups');
        $data['currencies'] = DB::select('SELECT * FROM '.env('LANDLORD_DB_DATABASE').'.currencies');
        return view('accounts::chartsOfAccounts.new_form')->with($data);

    }


    public function chartsOfAccountDatatable(){


        $charts_of_accounts = $this->chart_of_account::all();

        return DataTables::of($charts_of_accounts) 
        ->addColumn('account_group', function($charts_of_account){
           $account_name = DB::select('SELECT name FROM '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups WHERE id = '.$charts_of_account->account_group_id.' LIMIT 1')[0];
           return $account_name->name;
        })
        ->addColumn('action', function($charts_of_account) {

            $button = '';
            $button .= ' <a href="'.route('charts.of.accounts.new.form',$charts_of_account->id).'" data-original-title="Edit" data-student_id="'.$charts_of_account->id.'"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  studentEditBtn" ><i class="fa fa-edit  m-0"></i></a>';
            $button .= ' <a href="" data-original-title="Edit" data-chart_id="'.$charts_of_account->id.'"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  chartDltBtn" ><i class="fa fa-trash  m-0"></i></a>';
            return '<nobr>'.$button. '</nobr>';


        })
        ->rawColumns(['action'])
        ->make();


    
    }

    public function chartsOfAccountStore(Request $request)
    {

        try {
            
            
            DB::beginTransaction();

            $chart_of_account = ChartOfAccount::updateOrCreate(

                 ['id'=>$request->chart_of_account_id],
     
                 [
                     'code'=>$request->code,
                     'account_name'=>$request->account_name,
                     'account_group_id'=>$request->account_groups,
                     'currency'=>$request->currency
                 ]
                 
                 );
     
     
                 DB::commit();
     
                 if($chart_of_account){
                    
                     session()->flash('success','Record created successful');
                     $data = ['state'=>'Done'];
                     return response($data);
                 }
     
                 $data = ['state'=>'Fail','msg'=>'Record could not be created','title'=>'Fail'];
                 return response($data);
             
        } catch (QueryException $e) {
            
            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            return  response($data);

        }


    


    }



    public function deleteChartOfAccount($id){
        try {
            
          $chart_of_account = $this->chart_of_account::find($id)->delete();

          if($chart_of_account){
              
             $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record deleted successful'];
  
             return response($data);
  
          }
  
          $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be deleted'];
          return  response($data);

        } catch (QueryException $e) {

          $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
          return  response($data); 
        }
     
    }



    public function chartsOfAccountprinting(Request $request){

        $data['school_info'] = AccountSchoolDetail::first();

        $data['chart_of_accounts'] = $charts_of_account = DB::select('SELECT * FROM '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups join chart_of_accounts ON '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups.id = chart_of_accounts.account_group_id');
       
        $data['school_info'] = AccountSchoolDetail::first();
        $data['address'] =  Contact::where('contactable_type',AccountSchoolDetail::class)
                            ->where('contact_type_id',3)->first()->contact;
        $data['phone'] = Contact::where('contactable_type',AccountSchoolDetail::class)
                        ->where('contact_type_id',1)->first()->contact;

        $data['email'] = Contact::where('contactable_type',AccountSchoolDetail::class)
        ->where('contact_type_id',2)->first()->contact;
            
 
         if ($request->file_type == 'pdf') {
             // return 'pdf';
             
             $pdf = FacadePdf::loadView('accounts::chartsOfAccounts.printouts.pdf', $data);

             return $pdf->stream('charts_of_account.pdf', array("Attachment" => false));
             
         }
         if ($request->file_type == 'excel') {
             return FacadesExcel::download(new ChartsOfAccountExport, 'charts_of_account.xlsx');
 
         }

     }





    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('accounts::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
   

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('accounts::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('accounts::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
