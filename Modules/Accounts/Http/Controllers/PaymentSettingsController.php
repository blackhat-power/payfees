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
use Modules\Accounts\Entities\FeeMasterCategory;
use Modules\Accounts\Entities\FeeMasterCategoryClass;
use Modules\Accounts\Entities\FeeMasterParticular;
use Modules\Accounts\Entities\FeeStructure;
use Modules\Accounts\Entities\FeeStructureItem;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Modules\Configuration\Entities\AccountSchoolDetailClass;
use Modules\Configuration\Entities\AccountSchoolDetailFeeStructure;
use Modules\Configuration\Entities\AccountSchoolDetailFeeStructureItem;
use Modules\Configuration\Entities\AccountSchoolDetailSeason;
use Modules\Configuration\Entities\Semester;
use Modules\Registration\Entities\AccountStudentDetail;
use Yajra\DataTables\DataTables;

class PaymentSettingsController extends Controller
{

        public function feeStructure(){
            $data['school_details'] =$school= AccountSchoolDetail::select('account_school_details.*')->first();
            $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$school->id)->get(); 
            $data['semesters'] = Semester::all();

            // return ''.env('LANDLORD_DB_DATABASE').'';

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
            $data['parent_groups'] = $response =  FeeTypeGroup::where('parent_id',NULL)->get();
            // return $response;

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








/* BREAKING CHANGES JAN 2023 */

public function feeMaster(){


    $data['activeLink'] = 'fee_master';
    return view('accounts::fee.index')->with($data);


}

public function feeMasterParticulars(){

    $data['activeLink'] = 'fee_master';
    return view('accounts::fee.fee_particular_index')->with($data);


}

public function feeMasterParticularsDatatable(){


$fee_master_particulars = FeeMasterParticular::all();
// var_dump($fee_master_particulars);
// exit();
return DataTables::of($fee_master_particulars) 
// ->addColumn('created_by',function($fee){ 

// return auth()->user()->name;

// })
->addColumn('action', function($particular){
$button = '';
           $button .= ' <a href="'.route('accounts.school.fee_structure.edit',[$particular->id]).'" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i></a>';
           $button .= ' <a href="" data-original-title="Delete" data-fee_dlt_id="'.$particular->id.'"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  fee-structure-delete" ><i class="fa fa-trash  m-0"></i></a>';
     
return '<nobr>'.$button. '</nobr>';
})
->rawColumns(['action'])
->make();

}



    public function feeParticularStore(Request $request){


        try {

            DB::beginTransaction();

            // return $request->all();
           
            $response = FeeMasterParticular::updateOrCreate(
                [
                    'id' => $request->id
                ],
                [
                    'name'=>$request->name,
                    'created_by'=>auth()->user()->id,
                    'description'=>$request->description,
                    'is_tuition_fee'=>$request->is_tuition_fee ? 1 : 0
                ]
                );
            DB::commit();

            if ($response) {
                 $data = ['state'=>'Done','title'=>'success', 'msg'=>'Record created'];
                 return  response($data);

            }

            $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
            return  response($data);

        } catch (QueryException $e) {

            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            return  response($data);

        }

    }

    public function feeMasterCategories(){

        $data['activeLink'] = 'fee_master';
        $data['classes'] = AccountSchoolDetailClass::all();
        return view('accounts::fee.master_category.index')->with($data);
    
    
    }


    public function feeMasterCategoryStore(Request $request){


        try {

            DB::beginTransaction();

            // return $request->all();

            $classes = $request->classes;
            

                $response = FeeMasterCategory::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'name'=>$request->name,
                        'created_by'=>auth()->user()->id,
                        'description'=>$request->description,
                    ]
                    );


                    


            foreach($classes as $class){  
                
                FeeMasterCategoryClass::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'fee_master_category_id'=>$response->id,
                        'class_id'=>$class,
                    ]

                    );

            }
           
            DB::commit();

            if ($response) {
                 $data = ['state'=>'Done','title'=>'success', 'msg'=>'Record created'];
                 return  response($data);

            }

            $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
            return  response($data);

        } catch (QueryException $e) {

            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            return  response($data);

        }

    }


    public function feeCategoryParticularIndex(){

        $data['activeLink'] = 'fee_master';
        $data['classes'] = AccountSchoolDetailClass::all();
        $data['master_particulars'] = FeeMasterParticular::all();
        $data['fee_master_categories'] = FeeMasterCategory::all();
        return view('accounts::fee.fee_particulars.index')->with($data);


    }

    public function feeCategoryParticularCategory(Request $request){

        $category_id = $request->category_id;
        $a = FeeMasterCategory::find($category_id)->feeCategoryMasterClasses;
        
       $return = FeeMasterCategoryClass::where('fee_master_category_id',$category_id)
        ->select('class_id','account_school_detail_classes.name as class_name')
        ->join('fee_master_categories','fee_master_category_classes.fee_master_category_id','=','fee_master_categories.id')
        ->join('account_school_detail_classes','account_school_detail_classes.id','=','fee_master_category_classes.class_id')
        // ->join('fee_master_categories','')
        ->get();



        $html = '';

        foreach ($return as $key => $r) {
            $html .= '<div class="batch">
            <span class="spaces"> <input style="height:1rem" type="checkbox" value="'.$r->class_id.'" name="classes[]" class="form-control checkboxes form-control-sm"></span>  
             <span class="spaces">'. $r->class_name .'</span>
         </div>';
        }



        if ($return) {
            $data = ['state'=>'Done','content'=>$html,'title'=>'success', 'msg'=>'Record created'];
            return  response($data);

       }

        // return $html;



        

        return $request->all();


    }


    public function feeCategoryParticularCategoryStore(Request $request){

        // 'id',
        // 'category_id',
        // 'class_id',
        // 'category_type'



        // return $request->all();


        try {

            DB::beginTransaction();
            //   return $request->all();

            $particular_id = $request->particular_id;
            $student_category = $request->student_category;
            $category_id = $request->select_category;
            $description = $request->description;
            $amount = $request->amount;


            foreach($request->classes as $row_index=>$class){

              $students =  AccountSchoolDetailClass::find($class)->students;

                // return $students;

                $response = FeeStructure::updateOrCreate(
                    [
                        'id' => $request->fee_structure_id
                    ],
                    [
                        'category_id'=>$category_id,
                        'amount'=>$amount,
                        'created_by'=>auth()->user()->id,
                        'category_type'=>$student_category,
                        'class_id'=>$class,
                        'particular_id'=>$particular_id,
                        'description'=>$description
                    ]
                    );

                    // str_replace(',','',$request->amounts[$col_index]),

                    foreach ($students as $key => $student) {
                        # code...
                        if($student->id == 5){

                            $fee_structure_item = FeeStructureItem::updateOrCreate(

                                [
                                    'id' => $request->fee_structure_id
                                ],
                                [
                                    'fee_structure_id'=> $response->id ,
                                    'student_id'=>$student->id  
                                ]
        
                                );
                        }
            }
        }
            DB::commit();
            if ($fee_structure_item) {


                $data = ['state'=>'Done', 'title'=>'success', 'msg'=>'Record created'];

                 return  response($data);

            }

            $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
            return  response($data);

        } catch (QueryException $e) {

            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            return  response($data);

        }




    }



    public function newFeeStructureIndex(){


        $data['activeLink'] = 'fee_master';
        $data['classes'] = AccountSchoolDetailClass::all();
        $data['fee_master_categories'] = FeeMasterCategory::all();
        // $data['master_particulars'] = FeeMasterParticular::all();
        // $data['fee_master_categories'] = FeeMasterCategory::all();
        return view('accounts::fee.structure.index')->with($data);

    }


    public function newFeeStructureDatatable(Request $request){

        $class_id = $request->class_id;

        //  return $class_id;

        $students = FeeStructure::leftjoin('fee_structure_items','fee_structure_items.fee_structure_id','=','fee_structures.id')
        ->join('account_student_details','account_student_details.id','=','fee_structure_items.student_id')
        ->join('fee_master_categories','fee_structures.category_id','=','fee_master_categories.id')
        ->select(DB::raw("SUM(fee_structures.amount) as total_amount"),'fee_master_categories.id as category_id', 'fee_structure_items.student_id','fee_structures.amount','account_student_details.*')
        ->groupBy(['account_student_details.id'])
        ;

        // return $students->get();




        // $students = AccountStudentDetail::join('account_school_detail_classes','account_student_details.account_school_details_class_id','=','account_school_detail_classes.id')
        // ->leftjoin('account_school_detail_streams','account_student_details.account_school_detail_stream_id','=','account_school_detail_streams.id')
        // ->leftjoin('fee_structures','fee_structures.class_id','=','account_school_detail_classes.id')
        // ->leftjoin('fee_master_categories','fee_structures.category_id','=','fee_master_categories.id')
        // ->leftjoin('fee_structure_items','fee_structure_items.category_id','=','fee_master_categories.id')
        // ->select(DB::raw("SUM(fee_structure_items.amount) as total_amount"),'account_student_details.*','account_school_detail_classes.name as class_name','account_school_detail_streams.name as stream_name')
        // ->groupBy('account_student_details.id')
        // ->where('account_student_details.grad',0);


//         $subquery = DB::table('fee_structure_items')
//         ->select(DB::raw('SUM(amount) as sum_amount'))
//         ->leftjoin('fee_structures','fee_structures.category_id','=','fee_structure_items.category_id')
//         ->leftjoin('account_school_detail_classes','account_school_detail_classes.id','=','fee_structures.class_id')
//         ->leftjoin('account_student_details','account_student_details.account_school_details_class_id','=','account_school_detail_classes.id')
//         ->where('account_student_details.grad',0)
//         ->groupBy('account_student_details.id')
//         ->toSql();

// $students = AccountStudentDetail::join('account_school_detail_classes','account_student_details.account_school_details_class_id','=','account_school_detail_classes.id')
//         ->leftjoin('account_school_detail_streams','account_student_details.account_school_detail_stream_id','=','account_school_detail_streams.id')
//         ->leftjoin(DB::raw("($subquery) as sum_table"),'sum_table.account_student_details_id','=','account_student_details.id')
//         ->select('sum_table.sum_amount AS sum','account_student_details.*','account_school_detail_classes.name as class_name','account_school_detail_streams.name as stream_name')
//         ->groupBy('account_student_details.id');




if (!empty($request->get('class_id'))) {
$students = $students->where('account_student_details.account_school_details_class_id',$class_id);
}

if (!empty($request->get('category_id'))) {

    $students = $students->where('category_id',$request->get('category_id'));

    }



// return $students->get();
      
      return DataTables::of($students) 

      ->addColumn('full_name',function($student){
        $full_name = $student->first_name .' '. $student->last_name;
        $full_name = ucwords($full_name);
        return $full_name;
    }) 

    ->addColumn('fee',function($student){
        return $student->total_amount;
    }) 

      ->addColumn('action', function($student){
        $button = '';
                   $button .= '  <a href="javascript:void(0)" data-edit_id="'.$student->student_id.'" class="edit button-icon button btn btn-sm rounded-small btn-success  more-details-1"><i class="fa fa-eye m-0"></i></a>';
                   $button .= ' <a href="javascript:void(0)" data-delete_id="'.$student->student_id.'"  data-original-title="Delete" data-fee_dlt_id=""  data-toggle="tooltip" class=" delete button-icon button btn btn-sm rounded-small btn-danger  fee-structure-delete" ><i class="fa fa-trash  m-0"></i></a>';
             
        return '<nobr>'.$button. '</nobr>';
        })
    ->rawColumns(['action'])
    ->make();

    }

    public function newFeeStructureCategoryClasses(Request $req){

        $html = '<option> Filter By Class </option>';
        $category_id = $req->category_id;
       $master_category_classes = FeeMasterCategoryClass::join('account_school_detail_classes','account_school_detail_classes.id','=','fee_master_category_classes.class_id')
        ->where('fee_master_category_id',$category_id)
        ->get();

        foreach ($master_category_classes as $key => $master) {
            # code...
            $html .= '<option value="'.$master->class_id.'"> '.$master->name.'  </option>';

        }


        return response($html);


    }



    public function newFeeStructureStudentFeeItems(Request $req){

        $student_id = $req->student_id;

        // return $student_id;
        $category_id = $req->category_id;
       $student_fee_items = FeeStructure::join('fee_structure_items','fee_structures.id','fee_structure_items.fee_structure_id')
       ->join('fee_master_particulars','fee_structures.particular_id','=','fee_master_particulars.id')
       ->join('account_school_detail_classes','account_school_detail_classes.id','=','fee_structures.class_id')
       ->select('fee_structures.class_id','fee_structures.category_id','amount','fee_structure_items.student_id','fee_master_particulars.name as fee_name','particular_id')
        ->where('category_id',$category_id)
        ->where('fee_structure_items.student_id',$student_id);

        if(is_numeric($req->class_id)){
            return $req->class_id;
            $student_fee_items->where('class_id',$req->class_id);
        }
        $html = '';
        $total = 0;

       
        foreach ($student_fee_items->get() as $key => $item) {
            $total += $item->amount;
            $html .= '
            <div class="batch total_check">

            <div class="div_spaces">
            <span class="spaces"> <input type="checkbox" value="'.$item->particular_id.'" name="fee_items[]" class="form-control checkboxes form-control-sm" checked></span>  
            <span class="spaces">'.$item->fee_name .'</span>
            </div>

            <div class="div_spaces">
            <span class="spaces"> &nbsp; </span>
            <span style="float:right; margin-left:3rem" class="spaces amount">  '.$item->amount.' </span>
           </div>
           </div>
           ';


           if($key == count($student_fee_items->get()) - 1){
            $html.= '<div class="batch"> 
            <div class="div_spaces">
            <span class="spaces checkboxes"> </span>
            <span class="spaces text-right text-bold" style="margin-left:.9rem"> <b> TOTAL </b> </span>
            </div>
            <div class="div_spaces">
            <span class="spaces text-bold" id="total">  <b id="total_bd"> '.$total.' </b> </span>
            </div>
            </div>';
        
        }

        }

        return response($html);

    }











    // $data['fee_master_categories'] = FeeMasterCategory::all();


}
