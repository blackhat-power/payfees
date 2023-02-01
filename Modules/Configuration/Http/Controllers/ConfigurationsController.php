<?php

namespace Modules\Configuration\Http\Controllers;

use App\Models\Type;
use App\Models\Account;
use App\Models\Contact;
use App\Models\ContactPerson;
use App\Models\Currency;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Location\Entities\Ward;
use Illuminate\Support\Facades\Auth;
use Modules\Location\Entities\Region;
use Modules\Location\Entities\Village;
use Illuminate\Database\QueryException;
use Modules\Location\Entities\District;
use Illuminate\Contracts\Support\Renderable;
use Modules\Configuration\Entities\Semester;
use Modules\Configuration\Entities\BankDetail;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Modules\Registration\Entities\AccountStudentDetail;
use Modules\Configuration\Entities\AccountSchoolBankDetail;
use Modules\Configuration\Entities\AccountSchoolDetailClass;
use Modules\Configuration\Entities\AccountSchoolDetailSeason;
use Modules\Configuration\Entities\AccountSchoolDetailStream;
use Modules\Configuration\Entities\AccountSchoolSeasonDetail;
use Modules\Configuration\Entities\AccountSchoolDetailFeeStructure;
use Modules\Configuration\Entities\AccountSchoolDetailFeeStructureItem;
use Modules\Configuration\Entities\Category;
use Spatie\Multitenancy\Models\Tenant;

class ConfigurationsController extends Controller
{ 
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // return bcrypt('1234567');
        $data['districts'] = District::all();
        $data['banks']= BankDetail::all();
        $data['villages']=Village::all();
        $data['activeLink']='schools';
        return view('configuration::bizytechView.index')->with($data);

    }  

    public function districtsOptions(){
        $options = '';
        foreach (Region::all() as $region) {
            $options .= '<option> Select District </option>';
            $options .= '<optgroup label="'.$region->name.'">';
            foreach($region->districts as $district){
                $options .= '<option value="'.$district->id.'">'.$district->name.'</option>';
            }
            $options .= '</optgroup>';
        }
        return $options;
    }


    public function villagesOptions(Request $request){
        $options = '';
        $options .= '<option> Select Street/Village </option>';
     $wards_with_villages =  Ward::find($request->ward_id)->with('villages')->get();
      foreach($wards_with_villages as $wards_with_village){

          foreach($wards_with_village->villages as $village) {
            $options .= '<option  value="'.$village->id.'" > '.$village->name.' </option>';
              
          }
      }
      return $options;
    }

    public function wardsOptions(Request $request){
        $options = '';
        $options .= '<option> Select Ward </option>';
      $districts_with_wards =  District::find($request->district_id)->with('wards')->get();
      foreach($districts_with_wards as $districts_with_ward){

          foreach($districts_with_ward->wards as $ward) {
            $options .= '<option  value="'.$ward->id.'" > '.$ward->name.' </option>';
              
          }
      }
      return $options;
        
    }

    public function classProfileStudents($id){
        $school_id =  AccountSchoolDetailClass::find($id)->seasons->accountSchoolDetail->id;
        $data['classes'] = AccountSchoolDetailClass::join('account_school_detail_streams','account_school_detail_classes.id',
        '=','account_school_detail_streams.account_school_detail_class_id')
        ->select('account_school_detail_streams.name as stream_name','account_school_detail_classes.id as class_id','account_school_detail_classes.name as class_name')->get();
           $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$id)->get(); 
          $data['semesters'] = Semester::all();
          $data['currencies']= Currency::all();
          $data['school_details'] = AccountSchoolDetail::find($school_id);
          $data['class_id'] = $id;
          $data['school_id']= $school_id;
          $data['activeLink']='schools';
          $data['active'] = 'profile';
          return view('configuration::school.students.profile')->with($data);
    }


    public function classProfileStudentsDatatable($id){

        // $school_id =  AccountSchoolDetailClass::find($id)->seasons->accountSchoolDetail->id;

     $classes= AccountStudentDetail::join('account_school_detail_classes', 'account_school_detail_classes.id', '=', 'account_student_details.account_school_details_class_id')
        ->join('account_school_detail_streams', 'account_school_detail_classes.id','=','account_school_detail_streams.account_school_detail_class_id')
        ->select('account_student_details.created_at as student_date','account_student_details.first_name as student_first_name','account_school_detail_streams.name as stream_name',
        'account_school_detail_classes.id as class_id','account_school_detail_classes.name as class_name','account_student_details.middle_name as student_middle_name','account_student_details.last_name as student_last_name')
        ->where('account_school_details_class_id',DB::raw("account_school_detail_classes.id"))
        ->where('account_school_detail_stream_id',DB::raw("account_school_detail_streams.id"))
        ->where('account_student_details.id',$id)
        ->get();

        return DataTables::of($classes)
        ->addColumn('full_name',function($class){

           $name = $class->student_first_name .' '. $class->student_middle_name . ' ' . $class->student_last_name;
            return $name;
        })
        ->addColumn('streams',function($class){

            $name = $class->class_name . ' '. $class->stream_name;
             return $name;
         })
         ->addColumn('date',function($class){
            // return strtotime();
            return date("jS F, Y", strtotime($class->student_date));
            // return '20000';
        })
        ->addColumn('bill_payable',function(){
            return '200010';
        })
        ->addColumn('bill_paid',function(){
            return '45000';
        })
        ->addColumn('bill_balance', function(){
            return '45632';
        })
        ->addColumn('action', function($class){
          $button = '';
                     $button .= '  <a href="'.route('configurations.school.classes.profile.students', $class->class_id).'" class="button-icon button btn btn-sm rounded-small btn-warning  more-details-1"><i class="fa fa-eye m-0"></i>More Details </a>';
                     $button .= ' <a href="" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i>Send Reminder</a>';
               
          return '<nobr>'.$button. '</nobr>';
          })
      ->rawColumns(['action'])
      ->make();



    }


    public function classProfile($id){ 
       $school_id =  AccountSchoolDetailClass::find($id)->seasons->accountSchoolDetail->id;

        $data['classes'] = AccountSchoolDetailClass::join('account_school_detail_streams','account_school_detail_classes.id',
        '=','account_school_detail_streams.account_school_detail_class_id')
        ->select('account_school_detail_streams.name as stream_name','account_school_detail_classes.id as class_id','account_school_detail_classes.name as class_name')->get();
           $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$id)->get(); 
          $data['semesters'] = Semester::all();
          $data['currencies']= Currency::all(); 
          $data['school_details'] = AccountSchoolDetail::find( $school_id );
          $data['class_id'] = $id;
          $data['school_id'] = $school_id;
          $data['active'] = 'profile';
          $data['activeLink']='schools';
          return view('configuration::school.classes.profile')->with($data);
          
    }


    /*       FEE   STRUCTURES        */


    public function feeStructureProfile($id){
        $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$id)->get(); 
          $data['semesters'] = Semester::all();
          $data['currencies']= Currency::all();
          $data['school_details'] = AccountSchoolDetail::find($id);
          $data['classes'] = AccountSchoolDetailClass::all();
          $data['school_id'] = $id;
          $data['active'] = 'fee_structure';
          $data['activeLink']='schools';
          return view('configuration::school.classes.fee_structure_table')->with($data);                                                                                                                                                                                                                    
    }

    public function feeStructureProfileDatatable($id){

          $fees =  AccountSchoolDetailFeeStructure::join(
            'account_school_detail_classes','account_school_detail_fee_structures.account_school_details_class_id','=','account_school_detail_classes.id'
        )
        ->join('account_school_detail_seasons', 'account_school_detail_classes.account_school_detail_season_id','=','account_school_detail_seasons.id')
        ->join('semesters','account_school_detail_fee_structures.semester_id','=','semesters.id')
        ->select('account_school_detail_classes.name as class_name','semesters.name as semester_name','account_school_detail_fee_structures.created_at as fee_created_at','account_school_detail_fee_structures.id as fee_structure_id' )
        // ->get()
        ;   

        
        return DataTables::of($fees) 

        ->addColumn('date',function($fee){  

            return date("jS F, Y", strtotime($fee->fee_created_at));

        })

        ->addColumn('created_by',function($fee){    
            return auth()->user()->name;
        })
        ->addColumn('action', function($fee) use($id){
          $button = '';
                     $button .= '  <a href="" class="button-icon button btn btn-sm rounded-small btn-warning  more-details-1"><i class="fa fa-eye m-0"></i>More Details </a>';
                     $button .= ' <a href="'.route('configurations.school.fee_structure.edit',[$id,$fee->fee_structure_id]).'" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i>Edit</a>';
                     $button .= ' <a href="" data-original-title="Delete" data-fee_dlt_id="'.$fee->fee_structure_id.'"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  fee-structure-delete" ><i class="fa fa-trash  m-0"></i>Delete</a>';
               
          return '<nobr>'.$button. '</nobr>';
          })
      ->rawColumns(['action'])
      ->make();

    }


    public function schoolSettingsEdit($id){

        $data['districts'] = District::all();
        $data['banks']= BankDetail::all();
        $data['villages']=Village::all();
        $data['activeLink']='configurations';
        $data['classes'] = AccountSchoolDetailClass::join('account_school_detail_streams','account_school_detail_classes.id',
        '=','account_school_detail_streams.account_school_detail_class_id')
        ->select('account_school_detail_streams.name as stream_name','account_school_detail_classes.id as class_id','account_school_detail_classes.name as class_name')->get();
          $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$id)->get(); 
          $data['semesters'] = Semester::all();
          $data['currencies']= Currency::all();
          $data['school_details'] = AccountSchoolDetail::find($id);
          $data['school_id'] = $id;
          $data['active'] = 'system';
          $data['activeLink']='configurations';
        return view('configuration::school.profile_edit')->with($data);

    }


    public function feeStructure($id){

          $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$id)->get(); 
          $data['semesters'] = Semester::all();
          $data['currencies']= Currency::all();
          $data['school_details'] = AccountSchoolDetail::find($id);
          $data['classes'] = AccountSchoolDetailClass::all();
          $data['school_id'] = $id;
          $data['active'] = 'fee_structure';
          $data['activeLink']='schools';

          return view('configuration::school.classes.fee_structure')->with($data);

  
    }


    public function saveFeeStructurePayments(Request $request,$id){
        //  return $request->all();
        // return 'user'. Auth::user();
        try {
            DB::beginTransaction();
            foreach($request->classes as $row_index=>$row_value){

                $response = AccountSchoolDetailFeeStructure::updateOrCreate(
                    [
                        'id' => $request->fee_structure_id
                    ],
                    [
                        'account_school_details_class_id'=>$request->classes[$row_index],
                        'semester_id'=>$request->semesters[$row_index],
                        'user_id'=>1

                    ]
                    );

                foreach($request->fee_types as $col_index=>$col_value){
                        if($response){

                         $fee_structure_item =  AccountSchoolDetailFeeStructureItem::updateOrCreate(
                                ['id'=>$request->fee_structure_item_id],
                                [
                                    'account_school_detail_fee_structure_id'=>$response->id,
                                    'installments'=>$request->installments[$col_index],
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


            if($fee_structure_item){

                return route('configurations.school.fee_structure.profile',$id);

            }
        } catch (QueryException $e) {
           return $e->getMessage();
            
        }

    }

    public function feeStructureEdit($id,$fee_structure_id){

          /* return  */  $data['fee_structures'] =  AccountSchoolDetailFeeStructure::join(
               'account_school_detail_classes','account_school_detail_fee_structures.account_school_details_class_id','=','account_school_detail_classes.id'
           )
           ->join('account_school_detail_seasons', 'account_school_detail_classes.account_school_detail_season_id','=','account_school_detail_seasons.id')
           ->join('semesters','account_school_detail_fee_structures.semester_id','=','semesters.id')
           ->join('account_school_detail_fee_structure_items', 'account_school_detail_fee_structures.id','account_school_detail_fee_structure_items.account_school_detail_fee_structure_id')
           ->where('account_school_detail_fee_structures.id',$fee_structure_id)
           ->select('account_school_detail_fee_structure_items.name as item_name',
           'account_school_detail_fee_structure_items.installments',
           'account_school_detail_fee_structure_items.currency_id',
           'account_school_detail_fee_structure_items.exchange_rate',
           'account_school_detail_fee_structure_items.amount',
           'account_school_detail_fee_structure_items.id as fee_structure_item_id',
           'account_school_detail_classes.name as class_name','semesters.name as semester_name','account_school_detail_fee_structures.id as fee_structure_id' )
           ->get()
           ; 
             $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$id)->get(); 
             $data['semesters'] = Semester::all();
             $data['currencies']= Currency::all();
             $data['school_details'] = AccountSchoolDetail::find($id);
             $data['classes'] = AccountSchoolDetailClass::all();
             $data['school_id'] = $id;
             $data['active'] = 'fee_structure';
             $data['activeLink']='schools';

            //  $data['fee_structure_id'] = $fee_structure_id;
   
             return view('configuration::school.classes.fee_structure_edit')->with($data);

       }



       public function feeStructureDelete($id,$fee_structure_id){
        //    return $fee_structure_id;
        try {

            $fee_structure_delete = AccountSchoolDetailFeeStructure::find($fee_structure_id)->delete();

        } catch (QueryException $e) {
            return $e->getMessage();
            
        }

       }



       /*      END FEE STRUCTURES          */



       /* ACADEMIC YEAR SEASONS AND CLASSES */

       public function schoolDashboard($id){

        $data['school_details'] = AccountSchoolDetail::find($id);
        $data['school_id'] = $id;
        $data['active'] = 'dashboard';
        $data['activeLink'] = 'dashboard';
         return view('configuration::school.dashboard')->with($data);

       }

    public function academicYear($id){

          $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$id)->get(); 
          $data['semesters'] = Semester::all();
          $data['currencies']= Currency::all();
        $data['school_details'] = AccountSchoolDetail::find($id)->with('seasons')->get()[0];
          $data['school_id'] = $id;
          $data['activeLink'] = 'schools';
          $data['active'] = 'academic_year';


          return view('configuration::school.classes.academic_years')->with($data);
    }

    public function schoolAcademicYearStore(Request $request, $id){


       try { 
           DB::beginTransaction();

       foreach($request->season_name as $index => $value ){

             $season =   AccountSchoolDetailSeason::updateOrCreate(
                   ['id'=>null],
                   [
                       'start_date'=>$request->season_start_date[$index],
                        'end_date'=>$request->season_end_date[$index],
                        'name'=>$value,
                        'account_school_details_id'=>$id

                   ]
                   ); 
             

               foreach($request->semester_name as $semester_index => $semester){
                   // return $request->semester_start_date;
                   Semester::updateOrCreate(
                       [
                           'id'=>null
                       ],
                       [
                           'name'=>$semester,
                           'descriptions'=>$semester,
                           'start_date'=>$request->semester_start_date[$semester_index],
                           'end_date'=>$request->semester_end_date[$semester_index],
                           'account_school_detail_season_id'=> $season->id
                       ]
                       );
               }

               foreach($request->class_name as $index => $value){
                    // return $request->streams[0][1];
                  $response = AccountSchoolDetailClass::updateOrCreate(
                       ['id'=>$request->class_id],
                       [
                           'account_school_detail_season_id'=>$season->id,
                           'name'=>$value,
                           'symbol'=>$request->symbol[$index],
                           'short_form'=>$request->short_form[$index],
                           
                       ]
                       );
                       foreach($request->streams[$index] as $stream){

                             return $request->streams;


                           AccountSchoolDetailStream::updateOrCreate(
                               [
                                   'id'=>null
                               ],
   
                               [
                                   'name'=>$stream,
                                   'description'=>$stream,
                                   'account_school_detail_class_id'=>$response->id

                               ]
                       );

                       }
                         }
                     
               }
                   DB::commit();
                   
               if($response){
                    return route('configurations.school.academic_year.profile',$id);
               }


           } catch (QueryException $e) {
               return $e->getMessage();
           }
   }


    public function academicYearEdit($id,$season_id){


         $data['academic_year_semesters'] = AccountSchoolDetailSeason::find($season_id)->semesters;
         $data['activeLink']='schools';

           /* return */ $data['academic_year_seasons'] = AccountSchoolDetail::find($id)->seasons()->where('account_school_detail_seasons.id',$season_id)->get(); 
            AccountSchoolDetailSeason::find($season_id);

       
         /* return */ $queries = AccountSchoolDetail::find($id)->seasons()->where('account_school_detail_seasons.id',$season_id)->get();
            foreach($queries as $class){
              $classes =  $data['classes'] = $class->classes;

            }

        $streams_arr = [];
        
        foreach($classes as $class){

            $streams_arr[$class->id] = AccountSchoolDetailClass::join('account_school_detail_streams','account_school_detail_classes.id',
                '=','account_school_detail_streams.account_school_detail_class_id')
                ->join('account_school_detail_seasons','account_school_detail_classes.account_school_detail_season_id','=','account_school_detail_seasons.id')
                ->join('semesters','account_school_detail_seasons.id','=','semesters.account_school_detail_season_id')
                ->where('account_school_detail_seasons.id',$season_id)
                ->where('account_school_detail_classes.id',$class->id)
                ->select('semesters.end_date as semester_end_date','semesters.start_date as semester_start_date',
                'semesters.name as semester_name','account_school_detail_streams.name as stream_name',
                'account_school_detail_seasons.start_date as season_start_date',
                'account_school_detail_seasons.end_date as season_end_date',
                'account_school_detail_classes.id as class_id','account_school_detail_seasons.name as season_name','account_school_detail_classes.name as class_name',
                )
                ->groupBy(['account_school_detail_classes.id','account_school_detail_streams.id'])
                ->get();

        }

         $data['streams'] = $streams_arr;

          $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$id)->get(); 
          $data['semesters'] = Semester::all();
          $data['currencies']= Currency::all();
          $data['school_details'] = AccountSchoolDetail::find($id)->with('seasons')->get()[0];
          $data['school_id'] = $id;
          $data['active'] = 'academic_year';


          return view('configuration::school.classes.academic_years_edit')->with($data);
    }


    public function academicYearProfile($id){

        $data['classes'] = AccountSchoolDetailClass::join('account_school_detail_streams','account_school_detail_classes.id',
        '=','account_school_detail_streams.account_school_detail_class_id')
        ->select('account_school_detail_streams.name as stream_name','account_school_detail_classes.id as class_id','account_school_detail_classes.name as class_name')->get();
          $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$id)->get(); 
          $data['semesters'] = Semester::all();
          $data['currencies']= Currency::all();
          $data['school_details'] = AccountSchoolDetail::find($id);
          $data['school_id'] = $id;
          $data['activeLink']='schools';
          $data['active'] = 'academic_year';   
          return view('configuration::school.classes.academic_years_table')->with($data);
    }

   public function academicYearDatatable($id){
    $academics = AccountSchoolDetail::find($id)->seasons;
/*   return $academics = AccountSchoolDetailSeason::join('account_school_detail_classes','account_school_detail_seasons.id','=','account_school_detail_classes.account_school_detail_season_id')
                                                ->join('account_school_details','account_school_detail_seasons.account_school_details_id','=','account_school_details.id')
                                                ->join('account_school_detail_streams','account_school_detail_classes.id','=','account_school_detail_streams.account_school_detail_class_id')
                                                ->join('semesters','account_school_detail_seasons.id','=','semesters.account_school_detail_season_id')
                                                ->select('account_school_detail_seasons.name as season_name','account_school_details.id as school_id','account_school_detail_seasons.id as season_id','account_school_detail_seasons.created_at as season_date')
                                                // ->where('account_school_details.id',$id)
                                                ->groupBy('account_school_detail_seasons.name')
                                                // ;
                                                   ->get(); */

        return DataTables::of($academics)
        ->addColumn('date',function($academic){
            return date("jS F, Y", strtotime($academic->created_at));
        })
        ->addColumn('created_by',function(){    
            return auth()->user()->name;
        })
        ->addColumn('bill_payable',function(){
            return '20000';
        })
        ->addColumn('bill_paid',function(){
            return '45000';
        })
        ->addColumn('bill_balance', function(){
            return '45632';
        })
        ->addColumn('action', function($academic) use ($id){
          $button = '';
                    //  $button .= '  <a href="javascript:void(0)" type="button" data-academic_model="'.$academic->id.'" data-toggle="modal" class="button-icon button btn btn-sm rounded-small btn-secondary  academic_more_details"><i class="fa fa-eye m-0"></i> </a>';
                     $button .= ' <a href="'.route('configurations.school.academic_year.edit',[$id,$academic->id]).'" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i></a>';
                     $button .= ' <a href="" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  editBtn" ><i class="fa fa-trash  m-0"></i></a>';
               
          return '<nobr>'.$button. '</nobr>';
          })
      ->rawColumns(['action'])
      ->make();

    }


     /* END */


     /*                                                             CCCCCCCCCCCCCCCCCCCCCCC */

    public function classProfileDatatable($id){

        $school_id =  AccountSchoolDetailClass::find($id)->seasons->accountSchoolDetail->id;


       $student_count_per_stream = AccountStudentDetail::select(DB::raw("COUNT(account_student_details.id) as students_count"))->where('account_school_details_class_id',DB::raw("account_school_detail_classes.id"))
                                                                                                                                ->where('account_school_detail_stream_id',DB::raw("account_school_detail_streams.id"))
                                                                                                                                
                                                                                                                                ;

    /*  return  */ $classes =  AccountSchoolDetailClass::select(
                        'account_school_detail_classes.id as class_id',DB::raw("({$student_count_per_stream->toSql()}) as students_count"),'account_school_detail_streams.name as stream_name','account_school_detail_seasons.name as season_name','account_school_details.*','account_school_details.name as school_name', 'account_school_detail_classes.name as class_name',
                         DB::raw("SUM(invoice_items.rate * invoice_items.quantity) as bill_payable"),
                         DB::raw("SUM(receipt_items.rate * receipt_items.quantity) as bill_paid"),
                        )
                     ->join('account_school_detail_seasons', 'account_school_detail_seasons.id', '=', 'account_school_detail_classes.account_school_detail_season_id')
                     ->join('account_school_details','account_school_detail_seasons.account_school_details_id','=','account_school_details.id')
                     ->join('account_student_details','account_school_details.id','=','account_student_details.account_school_details_id')
                        ->join('accounts','account_student_details.account_id','=','accounts.id')
                        ->join('invoices','accounts.id','invoices.account_id')
                       ->join('invoice_items','invoices.id','invoice_items.invoice_id')
                        ->join('receipts','invoices.id','=','receipts.invoice_id')
                        ->join('receipt_items','receipts.id','=','receipt_items.receipt_id')
                     ->join('account_school_detail_streams', 'account_school_detail_classes.id','=','account_school_detail_streams.account_school_detail_class_id')
                     ->where('account_school_details.id',$school_id)
                     ->where('account_school_detail_classes.id',$id)
                     ->groupBy('account_school_detail_streams.id')
                     ;

        return DataTables::of($classes)
        ->addColumn('streams',function($class){

           $name = $class->class_name . '' . $class->stream_name;
            return $name;
        })
        ->addColumn('bill_payable',function($class){

            return $class->students_count ?  number_format($class->bill_payable) : 0;   
        })
        ->addColumn('bill_paid',function($class){

            return $class->students_count ?  number_format($class->bill_paid) : 0; 

        })
        ->addColumn('bill_balance', function($class){

            return $class->students_count ?  number_format($class->bill_payable  - $class->bill_paid ) : 0;             

        })
        ->addColumn('action', function($class){
          $button = '';
                     $button .= '  <a href="'.route('configurations.school.classes.profile.students', $class->class_id).'" class="button-icon button btn btn-sm rounded-small btn-warning  more-details-1"><i class="fa fa-eye m-0"></i>More Details </a>';
                     $button .= ' <a href="" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i>Send Reminder</a>';
               
          return '<nobr>'.$button. '</nobr>';
          })
      ->rawColumns(['action'])
      ->make();

    }




   

    public function classesDatatable($id,$db){
        $schools = Tenant::where('database','!=',''.env('LANDLORD_DB_DATABASE').'')->get();
            $db_table = $db.'.account_school_details';
            $invoices = $db.'.invoices';
            $invoice_items = $db.'.invoice_items';
            $receipts = $db.'.receipts';
            $receipt_items = $db.'.receipt_items';
            $accounts = $db.'.accounts';
            $classes = $db.'.account_school_detail_classes';
            $acc_student_details = $db.'.account_student_details';

            $students_count = DB::table(''.$acc_student_details.'')
            //save joy till last dance
                    ->leftjoin(''.$db_table.'', ''.$db_table.'.id', '=', ''.$acc_student_details.'.account_school_details_id')
                    ->join(''.$classes.'', ''.$classes.'.id', '=', ''.$acc_student_details.'.account_school_details_class_id')
                    // ->groupBy('')
                    ->count();
                    $data = [];

                //     $debtors = AccountStudentDetail::select('account_student_details.*',DB::raw("SUM(receipt_items.quantity* receipt_items.rate ) as pd_amnt"),
                //     DB::raw("SUM(invoice_items.rate * invoice_items.quantity ) as bll_amnt"
                //     ))
                //   ->join('accounts','account_student_details.account_id','=','accounts.id')
                //   ->join('invoices','accounts.id','=','invoices.account_id')
                //   ->join('invoice_items','invoices.id','=','invoice_items.invoice_id')
                //   ->join('receipts','invoices.id','=','receipts.invoice_id')
                //   ->join('receipt_items','receipts.id','=','receipt_items.receipt_id')
                //   ->groupBy(['account_student_details.id'])->get();
                 

              $debtors = DB::table(''.$acc_student_details.'')

                  ->join(''.$accounts.'', ''.$acc_student_details.'.account_id', '=', ''.$accounts.'.id')
                  ->join(''.$invoices.'', ''.$accounts.'.id', '=', ''.$invoices.'.account_id')
                  ->join(''.$invoice_items.'', ''.$invoices.'.id', '=', ''.$invoice_items.'.invoice_id')
                  ->join(''.$receipts.'', ''.$invoices.'.id', '=', ''.$receipts.'.invoice_id')
                  ->join(''.$receipt_items.'', ''.$receipts.'.id', '=', ''.$receipt_items.'.receipt_id')
                  ->join(''.$classes.'', ''.$classes.'.id', '=', ''.$acc_student_details.'.account_school_details_class_id')
                    ->select(''.$classes.'.id  as class_id',''.$classes.'.name  as class_name')
                    ->groupBy(''.$classes.'.id')
                  ->where(''.$acc_student_details.'.account_school_details_id',$id)
                  ->get();
                 
                //   $data = [];
                //   $billed_amount = [];
                //   $paid_amount = [];
                //   $balance = [];

                //   foreach($debtors as $debtor){
                //       $students = DB::table(''.$acc_student_details.'')->where(''.$acc_student_details.'.account_school_details_class_id', $debtor->class_id)->get();
                //       foreach($students as $student){
                //         return   $billed_amount = $student;
                //         $paid_amount = $student->paid_amount;
                //         $balance =  $billed_amount - $paid_amount;
                        
                //       }
                     
                //           $data [] = ['name' => $student->full_name, 'student_id'=>$student->id, 'billed_amount'=>$billed_amount, 'amount_paid'=>$paid_amount, 'balance'=>$balance ]; 
                //   }

                  /* coomentt */

    //     $student_count_per_class = AccountStudentDetail::select(DB::raw("COUNT(account_student_details.id) as students_count"))->where('account_school_details_class_id',DB::raw("account_school_detail_classes.id"));

    // //   /* return  */ $classes =  AccountSchoolDetailClass::select('account_school_detail_classes.id as class_id',DB::raw("({$student_count_per_class->toSql()}) as students_count"),'account_school_detail_seasons.name as season_name','account_school_details.name as school_name', 'account_school_detail_classes.name as class_name')
    // //                 ->join('account_school_detail_seasons', 'account_school_detail_seasons.id', '=', 'account_school_detail_classes.account_school_detail_season_id')
    // //                 ->join('account_school_details','account_school_detail_seasons.account_school_details_id','=','account_school_details.id')
    // //                 ->where('account_school_details.id',$id)
    // //                 ->get();
                   

        
    //    /* return  */ $classes = AccountStudentDetail::join('accounts','account_student_details.account_id','=','accounts.id')
    //                             ->leftjoin('invoices','accounts.id','invoices.account_id')
    //                             ->leftjoin('invoice_items','invoices.id','invoice_items.invoice_id')
    //                             ->leftjoin('receipts','invoices.id','=','receipts.invoice_id')
    //                             ->leftjoin('receipt_items','receipts.id','=','receipt_items.receipt_id')
    //                             ->join('account_school_detail_classes','account_student_details.account_school_details_class_id','=','account_school_detail_classes.id')
    //                             ->join('account_school_detail_seasons', 'account_school_detail_seasons.id', '=', 'account_school_detail_classes.account_school_detail_season_id')
    //                             ->join('account_school_details','account_school_detail_seasons.account_school_details_id','=','account_school_details.id')
    //                             ->select(
    //                                 'account_school_detail_classes.id as class_id','account_school_detail_seasons.name as season_name','account_school_details.name as school_name', 'account_school_detail_classes.name as class_name',
    //                                 DB::raw("({$student_count_per_class->toSql()}) as students_count"),
    //                                     DB::raw("SUM(invoice_items.rate * invoice_items.quantity) as bill_payable"),
    //                                      DB::raw("SUM(receipt_items.rate * receipt_items.quantity) as bill_paid"),
    //                                     )
    //                             // ->select('account_student_details.first_name')
    //                             ->where('account_school_details.id',$id)
    //                              ->groupBy(/* 'account_school_detail_classes.id', */'invoices.id')
    //                             ->get();







        //  $seasons = AccountSchoolDetail::find($id)->seasons;

    //   return  $classes = AccountSchoolDetail::find($id)->classes;  

        return DataTables::of($debtors)
         
      /*   ->addColumn('students_count',function($class){
            return $class->students->count();
        }) */
        ->addColumn('bill_payable',function($class){
            return 1;

            // return $class->bill_payable ? $class->bill_payable : 0 ;
        })
        ->editColumn('class_name',function($class){
            // return $class->bill_paid ? $class->bill_paid : 0 ;
            return $class->class_name;
        })
        ->addColumn('bill_paid',function($class){
            // return $class->bill_paid ? $class->bill_paid : 0 ;
            return 1;
        })
        ->addColumn('bill_balance', function($class){
            return 1;
            // return number_format($class->bill_payable - $class->bill_paid);
        })
        ->addColumn('action', function($class){
          $button = '';
                    //  $button .= '  <a href="'.route('configurations.school.classes.profile', $class->class_id).'" class="button-icon button btn btn-sm rounded-small btn-warning  more-details-1"><i class="fa fa-eye m-0"></i>More Details </a>';
                    //  $button .= ' <a href="" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i>Send Reminder</a>';
               
          return '<nobr>'.$button. '</nobr>';
          })
      ->rawColumns(['action'])
      ->make();

    }




    public function schoolProfileStudentsList($id,$db){

        $classes = $db.'.account_school_detail_classes';
        $school = $db.'.account_school_details';
        $streams = $db.'.account_school_detail_streams';
        $semesters = $db.'.semesters';
        $contacts = $db.'.contacts';
        $data['school_id'] = $id;
        $data['db'] = $db;
        $data['activeTab'] = 'students_list';

     $data['classes'] = DB::table(''.$classes.'')
    ->join(''.$streams.'', ''.$classes.'.id', '=', ''.$streams.'.account_school_detail_class_id')
    ->get();
    // $data['classes'] = AccountSchoolDetailClass::join('account_school_detail_streams','account_school_detail_classes.id',
    //   '=','account_school_detail_streams.account_school_detail_class_id')
    //   ->select('account_school_detail_streams.name as stream_name','account_school_detail_classes.id as class_id','account_school_detail_classes.name as class_name')->get();

        $data['contacts'] =  DB::table(''.$contacts.'')->get();
        // $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$id)->get(); 
        // $data['semesters'] = Semester::all();
        $data['semesters'] = DB::table(''.$semesters.'');
        $data['currencies']= Currency::all();
        $data['active'] ='profile';
        $data['activeLink']='schools';
        $data['school_id']=$id; 
        $data['school_details'] = DB::table(''.$school.'')->where('id',$id)->first();
        return view('configuration::bizytechView.students_list')->with($data);



    }


    public function schoolProfileStudentsListDatatable($id,$db){

        $schools = Tenant::where('database','!=',''.env('LANDLORD_DB_DATABASE').'')->get();
        $db_table = $db.'.account_school_details';
        $invoices = $db.'.invoices';
        $invoice_items = $db.'.invoice_items';
        $receipts = $db.'.receipts';
        $receipt_items = $db.'.receipt_items';
        $accounts = $db.'.accounts';
        $classes = $db.'.account_school_detail_classes';
        $acc_student_details = $db.'.account_student_details';

       $debtors = DB::table(''.$acc_student_details.'')
        ->join(''.$classes.'', ''.$classes.'.id', '=', ''.$acc_student_details.'.account_school_details_class_id')
        ->select(''.$classes.'.id  as class_id',''.$acc_student_details.'.last_name  as stdnt_l_name',''.$acc_student_details.'.first_name  as stdnt_f_name',''.$classes.'.name  as class_name',''.$acc_student_details.'.id  as std_id',DB::raw('COUNT('.$acc_student_details.'.id) as students_count'))
        ->groupBy(''.$acc_student_details.'.id')
        ->get();
            
        $data = [];

         foreach($debtors as $debtor){

            $pid_amount = DB::table(''.$receipt_items.'')
            ->join(''.$receipts.'',''.$receipt_items.'.receipt_id','=',''.$receipts.'.id')
            ->join(''.$invoices.'', ''.$receipts.'.invoice_id', '=', ''.$invoices.'.id')
            ->join(''.$accounts.'', ''.$accounts.'.id', '=', ''.$invoices.'.account_id')
            ->join(''.$acc_student_details.'', ''.$acc_student_details.'.account_id', '=', ''.$accounts.'.id')
             ->join(''.$classes.'', ''.$classes.'.id', '=', ''.$acc_student_details.'.account_school_details_class_id')
            ->select(DB::raw('SUM('.$receipt_items.'.rate) AS paid_amount'),)
             ->groupBy([''.$acc_student_details.'.id'])
             ->where(''.$acc_student_details.'.id',$debtor->std_id)
            ->first();

            $pid_amount  ? $paid_amount = $pid_amount->paid_amount : $paid_amount = 0;

            $bld_amount =   DB::table(''.$invoice_items.'')
            ->join(''.$invoices.'', ''.$invoice_items.'.invoice_id', '=', ''.$invoices.'.id')
            ->join(''.$accounts.'', ''.$accounts.'.id', '=', ''.$invoices.'.account_id')
            ->join(''.$acc_student_details.'', ''.$acc_student_details.'.account_id', '=', ''.$accounts.'.id')
            ->join(''.$classes.'', ''.$classes.'.id', '=', ''.$acc_student_details.'.account_school_details_class_id')
            ->groupBy(''.$acc_student_details.'.id')
            ->select(DB::raw('SUM('.$invoice_items.'.rate) AS billed_amount'))
            ->where(''.$acc_student_details.'.id',$debtor->std_id)
            ->first();

            $bld_amount ?  $billed_amount = $bld_amount->billed_amount  : $billed_amount = 0;

            $billed_amount ? $balance = ($billed_amount - $paid_amount) : $balance = 0;

            $data[] = [ 'f_name'=>$debtor->stdnt_f_name, 'l_name'=>$debtor->stdnt_l_name,'balance'=>$balance,'students_count'=>$debtor->students_count, 'class'=>$debtor->class_name,'billed_amount'=>$billed_amount, 'paid_amount'=>$paid_amount];

         }

         $profile_data = $data;

    return DataTables::of($profile_data)
     
     ->addColumn('student_name',function($class){
       
       $last_name = $class['l_name'];
       $first_name = $class['f_name'];
       $full_name = $first_name . ' '. $last_name;

       return  ucwords($full_name);

    }) 
    ->addColumn('doj',function($class){
        return 1;
    })

    ->addColumn('bill_payable',function($class){
        return number_format($class['billed_amount']);
    })
    ->editColumn('class_name',function($class){
        // return $class->bill_paid ? $class->bill_paid : 0 ;
        return $class['class'];
    })
    ->addColumn('bill_paid',function($class){
        // return $class->bill_paid ? $class->bill_paid : 0 ;
        return number_format($class['paid_amount']);
    })
    ->addColumn('bill_balance', function($class){
        
        return number_format($class['balance']);
    })
    ->addColumn('action', function($class){
      $button = '';
                //  $button .= '  <a href="'.route('configurations.school.classes.profile', $class->class_id).'" class="button-icon button btn btn-sm rounded-small btn-warning  more-details-1"><i class="fa fa-eye m-0"></i>More Details </a>';
                //  $button .= ' <a href="" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i>Send Reminder</a>';
           
      return '<nobr>'.$button. '</nobr>';
      })
  ->rawColumns(['action'])
  ->make();

    }



    public function classesBizyDatatable($id,$db){
        $schools = Tenant::where('database','!=',''.env('LANDLORD_DB_DATABASE').'')->get();
            $db_table = $db.'.account_school_details';
            $invoices = $db.'.invoices';
            $invoice_items = $db.'.invoice_items';
            $receipts = $db.'.receipts';
            $receipt_items = $db.'.receipt_items';
            $accounts = $db.'.accounts';
            $classes = $db.'.account_school_detail_classes';
            $acc_student_details = $db.'.account_student_details';

            $debtors = DB::table(''.$acc_student_details.'')
            ->rightjoin(''.$classes.'', ''.$classes.'.id', '=', ''.$acc_student_details.'.account_school_details_class_id')
            ->select(''.$classes.'.id  as class_id',''.$classes.'.name  as class_name',''.$acc_student_details.'.id  as std_id',DB::raw('COUNT('.$acc_student_details.'.id) as students_count'))
            ->groupBy(''.$classes.'.id')
            ->get();
                
            $data = [];

             foreach($debtors as $debtor){

              $paid_amount = DB::table(''.$receipt_items.'')
                ->join(''.$receipts.'',''.$receipt_items.'.receipt_id','=',''.$receipts.'.id')
                ->join(''.$invoices.'', ''.$receipts.'.invoice_id', '=', ''.$invoices.'.id')
                ->leftjoin(''.$accounts.'', ''.$accounts.'.id', '=', ''.$invoices.'.account_id')
                ->join(''.$acc_student_details.'', ''.$acc_student_details.'.account_id', '=', ''.$accounts.'.id')
                 ->rightjoin(''.$classes.'', ''.$classes.'.id', '=', ''.$acc_student_details.'.account_school_details_class_id')
                ->select(DB::raw('SUM('.$receipt_items.'.rate) AS paid_amount'),)
                 ->groupBy([''.$classes.'.id'])
                 ->where(''.$classes.'.id',$debtor->class_id)
                ->first()->paid_amount;


                $billed_amount =   DB::table(''.$invoice_items.'')
                ->join(''.$invoices.'', ''.$invoice_items.'.invoice_id', '=', ''.$invoices.'.id')
                ->leftjoin(''.$accounts.'', ''.$accounts.'.id', '=', ''.$invoices.'.account_id')
                ->join(''.$acc_student_details.'', ''.$acc_student_details.'.account_id', '=', ''.$accounts.'.id')
                ->rightjoin(''.$classes.'', ''.$classes.'.id', '=', ''.$acc_student_details.'.account_school_details_class_id')
                ->groupBy(''.$classes.'.id')
                ->select(DB::raw('SUM('.$invoice_items.'.rate) AS billed_amount'))
                ->where(''.$classes.'.id',$debtor->class_id)
                ->first()->billed_amount;

                $balance = $billed_amount - $paid_amount;

                $data[] = ['balance'=>$balance,'students_count'=>$debtor->students_count, 'class'=>$debtor->class_name,'billed_amount'=>$billed_amount, 'paid_amount'=>$paid_amount];

             }

             $profile_data = $data;

        return DataTables::of($profile_data)
         
         ->addColumn('students_count',function($class){
            return $class['students_count'];
        }) 
        ->addColumn('bill_payable',function($class){
            return number_format($class['billed_amount']);
        })
        ->editColumn('class_name',function($class){
            // return $class->bill_paid ? $class->bill_paid : 0 ;
            return $class['class'];
        })
        ->addColumn('bill_paid',function($class){
            // return $class->bill_paid ? $class->bill_paid : 0 ;
            return number_format($class['paid_amount']);
        })

        ->addColumn('season_name',function($class){
            // return $class->bill_paid ? $class->bill_paid : 0 ;
            return '2022';
        })

        ->addColumn('bill_balance', function($class){
            
            return number_format($class['balance']);
        })
        ->addColumn('action', function($class){
          $button = '';
                    //  $button .= '  <a href="'.route('configurations.school.classes.profile', $class->class_id).'" class="button-icon button btn btn-sm rounded-small btn-warning  more-details-1"><i class="fa fa-eye m-0"></i>More Details </a>';
                    //  $button .= ' <a href="" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i>Send Reminder</a>';
               
          return '<nobr>'.$button. '</nobr>';
          })
      ->rawColumns(['action'])
      ->make();

    }



    public function schoolRegistrationStore(Request $request, $id=null)
    {   
        //  return $request->all();
        try {
           DB::beginTransaction();

            $accounts = Account::updateOrCreate(
                ['id'=>$id],
                [
                    'name'=>$request->school_name,
                    'type_id'=>1,
                    'user_id'=>auth()->user()->id
                ]
   
        );

        if($accounts){

            foreach($request->school_category as $index => $school_category){
                // return $school_category;
                $response = AccountSchoolDetail::updateOrCreate(
                    ['id'=>$id],
                        [
                    'account_id'=>$accounts->id, 
                     'name'=>$request->school_name,
                     'ownership'=>$request->school_ownership,
                     'registration_number'=>$request->registration_no,
                     'village_id'=> $request->village,
                     'category'=>$school_category,
                     'logo'=>$request->logo
                        ]
                    );

            }

            
            Contact::updateOrCreate(
                [
                    'id'=>$request->std_phone_id
                ],
                [
                    'contact_type_id'=>1,
                    'contact'=>$request->phone_no,
                    'contactable_id' => $response->id,
                    'contactable_type' => AccountSchoolDetail::class,

                ]);

                Contact::updateOrCreate(
                    [
                        'id'=>$request->std_email_id
                    ],
                    [
                        'contact_type_id'=>2,
                        'contact'=>$request->email,
                        'contactable_id' => $response->id,
                        'contactable_type' => AccountSchoolDetail::class,

                    ]);


                    Contact::updateOrCreate(
                        [
                            'id'=>$request->std_address_id
                        ],
                        [
                            'contact_type_id'=>3,
                            'contact'=>$request->school_address,
                            'contactable_id' => $response->id,
                            'contactable_type' => AccountSchoolDetail::class,

                        ]);


                if ($response) {
                    foreach ($request->bank_details as $index => $bank_detail) {
                        AccountSchoolBankDetail::updateOrCreate(
                            [
            
                            ],
                            [
                                'bank_id'=>$bank_detail,
                                'account_school_detail_id'=>$response->id,
                                'account_no'=>$request->account_no[$index]
                            ]
                        );
                    }
                }
                 

        }
        

            DB::commit();
            // $data= ['url'=> route('configurations.school.profile', [$response->id])];
               return $response;

            
        } catch (  QueryException $e) {
            return $e->getMessage();
        }
    }


    public function schoolProfile($id,$db){  
        $classes = $db.'.account_school_detail_classes';
        $school = $db.'.account_school_details';
        $streams = $db.'.account_school_detail_streams';
        $semesters = $db.'.semesters';
        $contacts = $db.'.contacts';
        $data['school_id'] = $id;
        $data['db'] = $db;
        $data['activeTab'] = 'profile';

     $data['classes'] = DB::table(''.$classes.'')
    ->join(''.$streams.'', ''.$classes.'.id', '=', ''.$streams.'.account_school_detail_class_id')
    ->get();
    // $data['classes'] = AccountSchoolDetailClass::join('account_school_detail_streams','account_school_detail_classes.id',
    //   '=','account_school_detail_streams.account_school_detail_class_id')
    //   ->select('account_school_detail_streams.name as stream_name','account_school_detail_classes.id as class_id','account_school_detail_classes.name as class_name')->get();

        $data['contacts'] =  DB::table(''.$contacts.'')->get();
        // $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$id)->get(); 
        // $data['semesters'] = Semester::all();
        $data['semesters'] = DB::table(''.$semesters.'');
        $data['currencies']= Currency::all();
        $data['active'] ='profile';
        $data['activeLink']='schools';
        $data['school_id']=$id; 
        $data['school_details'] = DB::table(''.$school.'')->where('id',$id)->first();
        return view('configuration::bizytechView.profile')->with($data);

    }




/* COMMENTED */
    // public function schoolDatatable(){

    //     //  $schools = AccountSchoolDetail::with('students')->with('villages')->get();
    //     return $schools = Tenant::all();
    //     return DataTables::of($schools)
    //     ->addColumn('organization_name', function($school){
    //         return 'Bizytech';
    //     })
    //     ->addColumn('Number_of_students',function($school){
    //         return count($school->students);
    //     })
    //     ->addColumn('location', function($school){

    //         // return $school->villages->name;
    //     })
    //     ->addColumn('action', function($school){
    //       $button = '';
    //                  $button .= '  <a href="'.route('configurations.school.profile', $school->id).'" class="button-icon button btn btn-sm rounded-small btn-warning"><i class="fa fa-eye m-0"></i> </a>';
    //                  $button .= ' <a href="'.route('school.settings.edit',$school->id).'" data-original-title="Edit" data-school_id="'.$school->id.'"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  schlEditBtn" ><i class="fa fa-edit  m-0"></i></a>';
    //                  $button .= ' <a href="" data-original-title="delete"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  dltBtn" ><i class="fa fa-trash  m-0"></i></a>';
               
    //       return '<nobr>'.$button. '</nobr>';
    //       })
    //   ->rawColumns(['action'])
    //   ->make();
    // }


    public function schoolRegistrationEdit(Request $request){
        $id = $request->school_id;
        if($id){
            $data['school'] = AccountSchoolDetail::find($id);
        }
        return view('configuration::index')->with($data);
    }


    public function dashboard(){
        $data['activeLink'] = 'dashboard';
        return view('configuration::school.dashboard');
    }


   public function banksDatatable(){
    $schools = BankDetail::get();
        return DataTables::of($schools)

        ->addColumn('action', function($bank){
          $button = '';
                    $button .= ' <a href="javascript:void(0);" data-original-title="Edit" data-bank_edit_id = "'.$bank->id.'"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  bankEditBtn" ><i class="fa fa-edit  m-0"></i></a>';
                     $button .= '  <a href="#" data-bank_delete_id="'.$bank->id.'" class="button-icon button btn btn-sm rounded-small btn-danger bank-delete  "><i class="fa fa-trash m-0"></i> </a>';
                     
               
          return '<nobr>'.$button. '</nobr>';
          })
      ->rawColumns(['action'])
      ->make();
   }

   public function banks(){
       $data['activeLink'] = 'banks';
       return view('configuration::bank.index')->with($data);
   }

   public function saveBankDetails(Request $request){
        //   return $request->all();
        try {
            DB::beginTransaction();
            $bank_details = BankDetail::updateOrCreate(
                [
                 'id'=>$request->bank_id
                ],
                [
                 'bank_name'=>$request->bank_name,
                 'swift_code'=>$request->swift_code,
                 'location'=>$request->location
                ]
         );
         DB::commit();

         if($bank_details){

             $data = ['state'=>'Done','title'=>'success','msg'=>'Record created successfully'];
             return response($data);

         }
         $data = ['state'=>'Fail','title'=>'Fail','msg'=>'Record was not created'];
         return response($data);


        } catch (QueryException $e) {
            // return $e->getMessage();
            $data = ['state'=>'Error','title'=>'Database error','msg'=>'Record was not created </br>'.$e->erroInfo[2]];
         return response($data);
        }

   }

   public function editBank($id){
       $bank = BankDetail::find($id);
       return response($bank);
   }

   public function destroyBank($id){

    try {
        $bank = BankDetail::find($id)->delete();
        if($bank){
            $data = ['state'=>'Done','title'=>'success','msg'=>'Record deleted successfully'];
            return response($data);
        }

        $data = ['state'=>'Fail','title'=>'Fail','msg'=>'Record was not created'];
        return response($data);



    } catch (QueryException $e) {
        // return $e->getMessage();
        $data = ['state'=>'Error','title'=>'Database error','msg'=>'Record was not created </br>'.$e->erroInfo[2]];
         return response($data);
        
    } 

   }


   public function contactPeopleDatatable($id){
     $contact_persons = ContactPerson::select('contact_people.*')                  
                     ->where('personable_type',AccountStudentDetail::class)
                    ->where('personable_id',$id)
                    ->get()
                    ;
                    // ;

    return DataTables::of($contact_persons)
         
      ->addColumn('address',function($contact_person){
        return $contact_person->Address;
      })
      ->addColumn('email',function($contact_person){
          return $contact_person->Email;
      })
      ->addColumn('phone', function($contact_person){
          return $contact_person->Phone;
      })
      ->addColumn('action', function($contact_person) use ($id){
        $button = '';
                //    $button .= '  <a href="javacript:void(0)" class="button-icon button btn btn-sm rounded-small btn-warning  more-details-1"><i class="fa fa-eye m-0"></i> </a>';
                   $button .= ' <a href="javascript:void(0)" data-contact_person_id="'.$contact_person->id.'" data-original-title="Edit" data-edit_btn="'.$id.'"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editCntBtn" ><i class="fa fa-edit  m-0"></i></a>';
                   $button .= ' <a href="javascript:void(0)" data-contact_person_id="'.$contact_person->id.'" data-original-title="delete"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  dltBtn" ><i class="fa fa-trash  m-0"></i></a>';
             
        return '<nobr>'.$button. '</nobr>';
        })
    ->rawColumns(['action'])
    ->make();

   }


   public function contactPersonEdit(Request $req, $id){

       return $contact_person = Contact::where('contactable_id',$id)->where('contactable_type',ContactPerson::class)->get();


   }


   public function transport(){


    $data['activeLink'] = 'transport';

    return view('configuration::school.transport.index')->with($data);



   }

 

}
