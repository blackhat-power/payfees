<?php

namespace Modules\Accounts\Http\Controllers;

use App\Models\Contact;
use App\Models\Currency;
use App\Models\FeeTypeGroup;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Modules\Configuration\Entities\AccountSchoolDetailClass;
use Modules\Configuration\Entities\AccountSchoolDetailFeeStructure;
use Modules\Configuration\Entities\AccountSchoolDetailFeeStructureItem;
use Modules\Configuration\Entities\AccountSchoolDetailSeason;
use Modules\Configuration\Entities\Semester;
use Yajra\DataTables\DataTables;

class PaymentSettingsController extends Controller
{

        public function feeStructure(){
            $data['school_details'] =$school= AccountSchoolDetail::select('account_school_details.*')->first();
            $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$school->id)->get(); 
            $data['semesters'] = Semester::all();
            $data['currencies']= DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.currencies');
              
              $data['classes'] = AccountSchoolDetailClass::all();
              $data['activeLink']='account_fee_settings';
              
              return view('accounts::payments.settings.fee_structure_table')->with($data);

        }

        public function individualClassFeeStructure($id){

            
            $data['school_details'] =$school= AccountSchoolDetail::first();
            $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$school->id)->get(); 
            $data['semesters'] = Semester::all();
            $data['currencies']= DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.currencies');
            $data['class_id'] = $id;
            $data['classes'] = AccountSchoolDetailClass::all();
            $data['activeLink']='account_fee_settings';

            return view('accounts::payments.settings.individual_class_fee_structure')->with($data);


        }


        public function individualClassGroupFeeStructureDatatable($id){


            $fee_structure = AccountSchoolDetailClass::join('account_school_detail_fee_structures','account_school_detail_classes.id','=','account_school_detail_fee_structures.account_school_details_class_id')
            ->join('fee_type_groups','account_school_detail_fee_structures.fee_group_id','=','fee_type_groups.id')
            ->select('fee_type_groups.name as group_name','account_school_detail_classes.id as class_id','account_school_detail_classes.name as class_name','account_school_detail_fee_structures.created_at as fee_created_at','account_school_detail_fee_structures.id as fee_structure_id' )
            ->where('account_school_detail_classes.id',$id)
            ->groupBy('fee_type_groups.id')->get();

             
      return DataTables::of($fee_structure) 
      ->addColumn('created_by',function($fee){ 

        return auth()->user()->name;

      })
      ->addColumn('action', function($fee){
        $button = '';
                   $button .= ' <a href="'.route('accounts.school.fee_structure.edit',[$fee->fee_structure_id]).'" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i></a>';
                   $button .= ' <a href="" data-original-title="Delete" data-fee_dlt_id="'.$fee->fee_structure_id.'"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  fee-structure-delete" ><i class="fa fa-trash  m-0"></i></a>';
             
        return '<nobr>'.$button. '</nobr>';
        })
    ->rawColumns(['action'])
    ->make();

        }


        public function create(){
            $data['school_details'] =$school= AccountSchoolDetail::select('account_school_details.*')->first();
            $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$school->id)->get(); 
            $data['semesters'] = Semester::all();
            $data['currencies']= DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.currencies');
            $data['classes'] = AccountSchoolDetailClass::all();
            $data['school_id'] = $school->id;
            $data['fee_groups'] = FeeTypeGroup::all();
            // $data['active'] = 'fee_structure';
            $data['academic_years'] = AccountSchoolDetailSeason::all();
            $data['activeLink']='account_fee_settings';
  
            return view('accounts::payments.settings.fee_structure')->with($data);
  
    
      }



     public function feeStructureGroupFilter(Request $request){        

        try {

            $data['selected'] = false;

            // return $request->group_id;

          $items = AccountSchoolDetailFeeStructure::where('fee_group_id',$request->group_id)
                                                            ->where('account_school_details_class_id',$request->class_id)->first()->items;
            // $items = array();
            // foreach($items as $item){
            //     $items[] = $item;
            // }
            // return $items;

            if($items){
                $data['selected'] = true;
                $data['items'] = $items;

                return response($data);
            }
             $data = ['state'=>'Fail','msg'=>'Fee Group Not Set', 'title'=>'error'];
             return response($data);

        } catch (QueryException $e) {
            //throw $th;
            $data = ['state'=>'Error','msg'=>'Fee Group Not Set', 'title'=>'error'];
            return response($data);


        }


      }



    public function store(Request $request){


        try {

            DB::beginTransaction();
            //   return $request->all();

            foreach($request->classes as $row_index=>$row_value){

                $response = AccountSchoolDetailFeeStructure::updateOrCreate(
                    [
                        'id' => $request->fee_structure_id
                    ],
                    [
                        'account_school_details_class_id'=>$request->classes[$row_index],
                        // 'semester_id'=>$request->semesters[$row_index],
                        
                        'created_by'=>auth()->user()->id,
                        'account_school_detail_season_id'=>$request->academic_year,
                        'fee_group_id' => $request->fee_group,
                        'installments'=>$request->installments[$row_index],
                        'season_id'=>$request->academic_year

                    ]
                    );
                    AccountSchoolDetailFeeStructureItem::where('account_school_detail_fee_structure_id',$response->id)->delete();

                foreach($request->fee_types as $col_index=>$col_value){
                        if($response){
                         $fee_structure_item =  AccountSchoolDetailFeeStructureItem::create(
                                [
                                    'account_school_detail_fee_structure_id'=>$response->id,
                                    // 'installments'=>$request->installments[$col_index],
                                    'currency_id'=>$request->currency[$col_index],
                                    'exchange_rate'=>1,
                                    'amount'=>str_replace(',','',$request->amounts[$col_index]),
                                    'name'=>$request->fee_types[$col_index]
                                ]
    
                            );
                        }

                }

            }

            DB::commit();

            if ($fee_structure_item) {

                 session()->flash('success','Record created successful');

                 $data = ['state'=>'Done'];


                 return  response($data);

            }

            $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
            return  response($data);

        } catch (QueryException $e) {

            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            return  response($data);

        }

    }


    public function edit($fee_structure_id){

        $data['school_details'] =$school= AccountSchoolDetail::first();
        $data['academic_years'] = AccountSchoolDetailSeason::all();
       
       $data['fee_structures'] = $fee_structures =  AccountSchoolDetailFeeStructure::join(
             'account_school_detail_classes','account_school_detail_fee_structures.account_school_details_class_id','=','account_school_detail_classes.id'
         )
        //  ->join('account_school_detail_seasons', 'account_school_detail_classes.account_school_detail_season_id','=','account_school_detail_seasons.id')
         ->join('fee_type_groups','account_school_detail_fee_structures.fee_group_id','=','fee_type_groups.id')
        //  ->join('semesters','account_school_detail_fee_structures.semester_id','=','semesters.id')
         ->join('account_school_detail_fee_structure_items', 'account_school_detail_fee_structures.id','account_school_detail_fee_structure_items.account_school_detail_fee_structure_id')
         ->where('account_school_detail_fee_structures.id',$fee_structure_id)
         ->select('account_school_detail_fee_structure_items.name as item_name',
         'account_school_detail_fee_structures.installments',
         'account_school_detail_fee_structure_items.currency_id',
         'fee_type_groups.name as group_name',
         'fee_type_groups.id as group_id',
         'account_school_detail_fee_structures.season_id',
         'account_school_detail_fee_structure_items.exchange_rate',
         'account_school_detail_fee_structure_items.amount',
         'account_school_detail_fee_structure_items.id as fee_structure_item_id',
         'account_school_detail_classes.id as class_id',
         'account_school_detail_classes.name as class_name',/* 'semesters.name as semester_name', */'account_school_detail_fee_structures.id as fee_structure_id')
         ->get(); 
         
           $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$school->id)->get(); 
           $data['semesters'] = Semester::all();
           $data['currencies']= $a = DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.currencies');
           $data['fee_groups'] = DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.fee_groups');
           $data['classes'] = AccountSchoolDetailClass::all();
           $data['school_id'] = $school->id;
           $data['class_id'] = $fee_structures[0]->class_id;
        //    $data['active'] = 'fee_structure';
        $data['activeLink']='account_fee_settings';

          //  $data['fee_structure_id'] = $fee_structure_id;
 
           return view('accounts::payments.settings.fee_structure_edit')->with($data);

     }


    public function datatable(){

        $fees =  AccountSchoolDetailFeeStructure::join(
          'account_school_detail_classes','account_school_detail_fee_structures.account_school_details_class_id','=','account_school_detail_classes.id'
      )
    //   ->join('account_school_detail_seasons', 'account_school_detail_classes.account_school_detail_season_id','=','account_school_detail_seasons.id')
    //   ->join('semesters','account_school_detail_fee_structures.semester_id','=','semesters.id')
      ->select('account_school_detail_classes.id as class_id','account_school_detail_classes.created_at as date','account_school_detail_classes.name as class_name','account_school_detail_fee_structures.created_at as fee_created_at','account_school_detail_fee_structures.id as fee_structure_id' )
      ->groupBy('account_school_detail_classes.id')
      // ->get()
      ;   

      
      return DataTables::of($fees) 

        ->addColumn('date',function($fee){

            return date('jS M Y', strtotime("".$fee->date.""));

        })

      ->addColumn('action', function($fee){
        $button = '';
                   $button .= '  <a href="'.route('accounts.school.fee_structure.class',[$fee->class_id]).'" class="button-icon button btn btn-sm rounded-small btn-success  more-details-1"><i class="fa fa-eye m-0"></i></a>';
                   $button .= ' <a href="" data-original-title="Delete" data-fee_dlt_id="'.$fee->fee_structure_id.'"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  fee-structure-delete" ><i class="fa fa-trash  m-0"></i></a>';
             
        return '<nobr>'.$button. '</nobr>';
        })
    ->rawColumns(['action'])
    ->make();

  }



















}
