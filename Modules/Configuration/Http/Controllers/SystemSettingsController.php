<?php

namespace Modules\Configuration\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Currency;
use App\Models\CustomTenantModel as ModelsCustomTenantModel;
use App\Models\Tenant\CustomTenantModel;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Modules\Configuration\Entities\AccountSchoolBankDetail;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Modules\Configuration\Entities\AccountSchoolDetailCategory;
use Modules\Configuration\Entities\AccountSchoolDetailClass;
use Modules\Configuration\Entities\AccountSchoolDetailSeason;
use Modules\Configuration\Entities\AccountSchoolDetailStream;
use Modules\Registration\Entities\AccountStudentDetail;
use Modules\Configuration\Entities\BankDetail;
use Modules\Configuration\Entities\Category;
use Modules\Configuration\Entities\Semester;
use Modules\Configuration\Entities\Stream;
use Modules\Location\Entities\District;
use Modules\Location\Entities\Street;
use Modules\Location\Entities\Village;
use Modules\Location\Entities\Ward;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class SystemSettingsController extends Controller
{

    public $student; 

    public function __construct(AccountStudentDetail $stud)
    {
        $this->student = $stud;
        
    }
   
    public function editSchoolSettings()
    {
 
        $data['districts'] = DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.districts');
        $data['banks']= DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.bank_details');
        $data['activeLink']='configurations';
        $data['school_details'] =$school= AccountSchoolDetail::select('account_school_details.*')->first();
        $data['classes'] = AccountSchoolDetailClass::join('account_school_detail_streams','account_school_detail_classes.id',
        '=','account_school_detail_streams.account_school_detail_class_id')
        ->select('account_school_detail_streams.name as stream_name','account_school_detail_classes.id as class_id','account_school_detail_classes.name as class_name')->get();
          $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$school->id)->get(); 
          $data['semesters'] = Semester::all();
          $data['categories'] =  DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.categories');
          $data['currencies']= DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.currencies');
    /* return */  
      $data['school_categories'] = $school->schoolCategories->pluck('category_id')->toArray();

            $bank_ids = [];
            $data['schbanks'] = '';
            if(count(AccountSchoolBankDetail::all())){

                $data['schbanks'] = AccountSchoolDetail::join('account_school_bank_details','account_school_details.id','=','account_school_bank_details.account_school_detail_id')            
                            ->join(''.env('LANDLORD_DB_DATABASE').'.bank_details','account_school_bank_details.bank_id','=',''.env('LANDLORD_DB_DATABASE').'.bank_details.id')
                            ->select(''.env('LANDLORD_DB_DATABASE').'.bank_details.*','account_school_bank_details.account_no','account_school_bank_details.id as sch_bank_id')
                            ->get();
            }
           /* return  */  
                     $data['school_villages'] = $village = $school->street;
                    $data['school_ward'] = $ward = DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.wards WHERE id = ?',[$village->ward_id])[0];
                    $data['school_district_object'] =   DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.districts WHERE id = ?',[$ward->district_id])[0];

          $data['active'] = 'system'; 
          $data['activeLink']='configurations';


           $data['address'] = AccountSchoolDetail::leftjoin('contacts', 'account_school_details.id', '=', 'contacts.contactable_id')
          ->select('contacts.id as cnct_id','contacts.contact')
          ->where('contacts.contact_type_id', 3)
          ->where('contactable_type',AccountSchoolDetail::class)
          ->first();

          $data['phone'] = AccountSchoolDetail::leftjoin('contacts', 'account_school_details.id', '=', 'contacts.contactable_id')
          ->select('contacts.id as cnct_id','contacts.contact')
          ->where('contacts.contact_type_id', 1)
          ->where('contactable_type',AccountSchoolDetail::class)
          ->first();

          $data['email'] = AccountSchoolDetail::leftjoin('contacts', 'account_school_details.id', '=', 'contacts.contactable_id')
          ->select('contacts.id as cnct_id','contacts.contact')
          ->where('contacts.contact_type_id', 2)
          ->where('contactable_type',AccountSchoolDetail::class)
          ->first();
          
        return view('configuration::school.profile_edit')->with($data);

    }



    public function schoolRegistrationStore(Request $request)
    { 

        $user = null;
        $domain = null;
        if(!$request->school_id){
          return  $request->school_name;
                  $db_name = 'payfees_'.explode(' ', strtolower($request->school_name))[0];
                        $domain = $db_name.'.bizytech.test';
                        
                    // $cmd = shell_exec("echo $domain >> /etc/hosts ");

                        $email = $db_name.'@bizytech.com';
                        DB::table('tenants')->where('database',$db_name)->delete();
                        $tenant = ModelsCustomTenantModel::create(['name'=>$db_name,'domain'=>$domain,'database'=>$db_name]);
                        Tenant::forgetCurrent();

                        DB::connection('tenant')->statement('DROP DATABASE IF EXISTS '.$db_name.'');

                        DB::connection('tenant')->statement("CREATE DATABASE ".$db_name."");

                        $command = 'tenants:artisan "migrate --database=tenant " --tenant=' . $tenant->id . '';
                        Artisan::call($command);
                        $tenant->makeCurrent($tenant->id);
                        // DB::connection('tenant')->statement('INSERT INTO users (name,password,gender,email,username,user_type ) VALUES("'.$db_name.'","'.bcrypt($db_name).'","male","'.$email.'","'.$db_name.'","2")');

                        Role::create(['name' => 'accountant']);
                        Role::create(['name'=>'student']);
                        Role::create(['name' => 'admin']);

                        
                        DB::table('model_has_roles')->insert(
                            [
                            'role_id' => 3,
                            'model_type'=>User::class,
                            'model_id'=>1,
                            
                            ]);


                        $user = User::create([
                        'name'=>$db_name,
                        'password'=>bcrypt('123456'),
                        'gender'=>'male',
                        'email'=>$db_name.'@gmail.com',
                        'username'=>$db_name,
                        'passport'=>'shule.jpeg',
                        'user_type'=>2,
                        'created_by'=>1
                        ]);

        }
        
        if ($request->hasfile('logo')) {
            //  dd('tuna logo');
            $avatar_name= $request->file('logo')->getClientOriginalName();
            // return $request->file('logo')->getRealPath();
            $path = $request->file('logo')->storeAs('school_logo', $avatar_name, 'public');
        }
        elseif ($request->account_id) {
            # code...
            $path = AccountSchoolDetail::first()->logo;
        }
        else{
            $path = '';
        }
        


        try {
           DB::beginTransaction();

            $accounts = Account::updateOrCreate(
                ['id'=>$request->account_id],
                [
                    'name'=>$request->school_name,
                    'created_by'=> $user ? $user->id : auth()->user()->id
                ]
   
        );

        if($accounts){
            
            $avatar_name = '';   

                $response = AccountSchoolDetail::updateOrCreate(
                    ['id'=>$request->school_id],

                    [

                    'account_id'=>$accounts->id, 
                     'name'=>$request->school_name,
                     'ownership'=>$request->school_ownership,
                     'registration_number'=>$request->registration_no,
                     'current_session'=>$request->current_session,
                     'logo'=> $path

                    ]

                    );

                   
                  $strt_id = Street::where('school_id',$response->id)->first();

                    Street::updateOrCreate(
                        [
                            'id'=> $strt_id ? $strt_id->id : null
                        ],

                        [
                            'name'=>$request->street,
                            'ward_id'=>$request->ward,
                            'school_id'=>$response->id

                        ]
                    
                    );


                 AccountSchoolDetailCategory::where('school_id',$response->id)->delete();

                foreach($request->school_category as $index => $school_category){

                    AccountSchoolDetailCategory::create(
                        [
                            
                            'category_id'=>$school_category,
                            'school_id'=>$response->id
                        ]

                        );
                    }
            
                Contact::updateOrCreate(
                    [
                        'id'=>$request->phone_no_id
                    ],
                    [
                        'contact_type_id'=>1,
                        'contact'=>$request->phone_no,
                        'contactable_id' => $response->id,
                        'contactable_type' => AccountSchoolDetail::class,

                    ]);

                    Contact::updateOrCreate(
                        [
                            'id'=>$request->email_id
                        ],
                        [
                            'contact_type_id'=>2,
                            'contact'=>$request->email,
                            'contactable_id' => $response->id,
                            'contactable_type' => AccountSchoolDetail::class,

                        ]);

                        Contact::updateOrCreate(
                            [
                                'id'=>$request->school_address_id
                            ],
                            [
                                'contact_type_id'=>3,
                                'contact'=>$request->school_address,
                                'contactable_id' => $response->id,
                                'contactable_type' => AccountSchoolDetail::class,
    
                            ]);


                if ($response) {

                    
                    AccountSchoolBankDetail::where('account_school_detail_id', $response->id)->delete();
                    foreach ($request->bank_details as $index => $bank_detail) {
                        // return $bank_detail;

                      $bank =  AccountSchoolBankDetail::create(
                            [
                                'bank_id'=>$bank_detail,
                                'account_school_detail_id'=>$response->id,
                                'account_no'=>$request->account_no[$index]
                            ]
                        );
                    }
                }
                 

        }
        else{
            return 0;
        }
           $one =  DB::commit();
            if($response){
                $domain ? $url = $domain :  $url = null;

                $data = ['state'=>'Done', 'url'=>''.$url.'',  'title'=>'Successful', 'msg'=>'Record created successful'];
                session()->flash('success', 'Account created successful');
                return response($data); 
            }
            
            $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
            return  response($data);

            
        } catch (QueryException $e) {

            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            return  response($data);
            
        }
    }


    public function academicYearStore(Request $request){

        // return $request->all();

        try {
            DB::beginTransaction();

            $data = [
                'end_date'=>$request->end_date,
                'start_date' => $request->start_date,
                'name'=>$request->year,
                'status'=>$request->academic_year_status,
                'account_school_details_id'=>AccountSchoolDetail::first()->id
            ];
            if($request->year_id){
                if($request->academic_year_status == 'active'){
                    $seasons = AccountSchoolDetailSeason::all();
                    foreach ($seasons as $key => $season) {
                        if($season->status == 'active'){
                            $single_data = ['status'=>'deactive'];
                            AccountSchoolDetailSeason::where('status','active')->update($single_data);
                            
                        }
                    } 
                }
                if ($request->academic_year_status == 'deactive') {
                    $seasons = AccountSchoolDetailSeason::all();
                    $active_box = 0;
                    foreach ($seasons as $key => $season) {
                        if($season->status == 'active'){
                            ++$active_box;
                        }

                    }
                    if($active_box <= 1 ){
                        return response(['state'=>'Fail','msg'=>'Atleat One Year Needs to Be Active','title'=>'Fail']);
                    }

                }
                $academic_year = AccountSchoolDetailSeason::where('id',$request->year_id)->update($data);
                
                // AccountSchoolDetail::first()->update(['current_session'=>$acdmc_yr->name]);
                DB::commit();
                if($academic_year){
                    // return $request->year;
                    AccountSchoolDetail::first()->update(['current_session'=>$request->year]);
                    $data = ['state'=>'Done','msg'=>'academic year updated successfully', 'title'=>'success'];
                    session()->flash('success','academic year updated successfully');
                    return response($data);
                }

                $data = ['state'=>'Fail','msg'=>'academic year not updated', 'title'=>'warning'];
                return response($data);

            }

            if($request->academic_year_status == 'active'){
                $seasons = AccountSchoolDetailSeason::all();

                foreach ($seasons as $key => $season) {
                    if($season->status == 'active'){
                        $data = ['state'=>'Fail', 'msg'=>'Only one Academic year can be Active', 'title'=>'Fail'];
                        return response($data);
                    }
                }
            }

         $acdmc_yr = AccountSchoolDetailSeason::create($data);
         AccountSchoolDetail::first()->update(['current_session'=>$request->year]);
        DB::commit();
           
            if($acdmc_yr){
                /* for Now */
                // AccountSchoolDetail::first()->update(['current_session'=>$acdmc_yr->name]);
                session()->flash('success','academic year created successfully');
                $data = ['state'=>'Done','msg'=>'academic year created successfully', 'title'=>'success'];
                
                return response($data);
            }

            $data = ['state'=>'Fail','msg'=>'academic year not updated', 'title'=>'warning'];
            return response($data);
          


        } catch (QueryException $e) {
            return $e->getMessage();
            $data = ['state'=>'Error','msg'=>'Database Error', 'title'=>'error'];
            return response($data);

        }


    }
   public function academicYearProfile(){
    $data['school_details'] = $school = AccountSchoolDetail::select('account_school_details.*')->first();
    $data['classes'] = AccountSchoolDetailClass::join('account_school_detail_streams','account_school_detail_classes.id',
    '=','account_school_detail_streams.account_school_detail_class_id')
    ->select('account_school_detail_streams.name as stream_name','account_school_detail_classes.id as class_id','account_school_detail_classes.name as class_name')->get();
      $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$school->id)->get(); 
      $data['semesters'] = Semester::all();
      $data['currencies']= DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.currencies');
    
      $data['activeLink']='configurations';
      $data['active'] = 'academic_year';   
      return view('configuration::school.classes.academic_years_table')->with($data);

}



public function datatable(){
    $academics = AccountSchoolDetail::select('account_school_details.*')->first()->seasons;

        return DataTables::of($academics)
        ->addColumn('date',function($academic){
            return date("jS F, Y", strtotime($academic->created_at));
        })
        ->addColumn('created_by',function(){    
            return auth()->user()->name;
        })
        ->addColumn('action', function($academic){
          $button = '';
                    //  $button .= '  <a href="javascript:void(0)" type="button" data-academic_model="'.$academic->id.'" data-toggle="modal" class="button-icon button btn btn-sm rounded-small btn-secondary  academic_more_details"><i class="fa fa-eye m-0"></i> </a>';
                     $button .= ' <a href="'.route('school.settings.academic_year.edit',[$academic->id]).'" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i></a>';
                     $button .= ' <a href="" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  editBtn" ><i class="fa fa-trash  m-0"></i></a>';
               
          return '<nobr>'.$button. '</nobr>';
          })
      ->rawColumns(['action'])
      ->make();

    }


    public function academicYear(){
        $school = AccountSchoolDetail::select('account_school_details.*')->first();
        $data['contacts'] = Contact::where('contactable_type',AccountSchoolDetail::class)->where('contactable_id',$school->id)->get(); 
        $data['semesters'] = Semester::all();
        $data['currencies']= DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.currencies');
        $data['school_details'] = $school->with('seasons')->get()[0];
        $data['streams_all'] = DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.streams');
        $data['activeLink'] = 'configurations';
        $data['active'] = 'academic_year';

        return view('configuration::school.classes.academic_years')->with($data);
  }


  public function create(){

    $data['districts'] = District::all();
    $data['banks']= BankDetail::all();
    $data['villages']=Village::all();
    $data['categories'] = Category::all();
    $data['activeLink']='schools';
    return view('configuration::create')->with($data);

  }


  public function schoolAcademicYearStore(Request $request){

    try { 

        // return $request->all();

        DB::beginTransaction();

        $school = AccountSchoolDetail::first();

    foreach($request->season_name as $index => $value ){

          $season =   AccountSchoolDetailSeason::create(
                [
                    'start_date'=>$request->season_start_date[$index],
                     'end_date'=>$request->season_end_date[$index],
                     'name'=>$value,
                     'account_school_details_id'=>$school->id
                ]

                ); 
          

            foreach($request->semester_name as $semester_index => $semester){
                // return $request->semester_start_date;
                Semester::create(
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
               $response = AccountSchoolDetailClass::create(
                    [
                        'account_school_detail_season_id'=>$season->id,
                        'name'=>$value,
                        'symbol'=>$request->symbol[$index],
                        'short_form'=>$request->short_form[$index],
                        
                    ]
                    );
                    foreach($request->streams[$index] as $stream){
                        // return $request->streams;
                        // return ;
                        AccountSchoolDetailStream::create(
                            [
                                'name'=> DB::select('select name from '.env('LANDLORD_DB_DATABASE').'.streams where id = :id',[$stream])[0]->name,
                                'stream_id'=>$stream,
                                'description'=> DB::select('select name from '.env('LANDLORD_DB_DATABASE').'.streams where id = :id',[$stream])[0]->name,
                                'account_school_detail_class_id'=>$response->id

                            ]
                    );

                    }
                      }
                  
            }
                DB::commit();

                if($response){
                    $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record created successful'];
                    return response($data); 
                }
                
                $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
                return  response($data);
        
                
                }
            catch (QueryException $e) {
        
            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            return  response($data);
                
            }

}


public function schoolDatatable(){
    
   /*  return */ $schools = Tenant::where('database','!=',''.env('LANDLORD_DB_DATABASE').'')->get();

   $data = [];

   foreach($schools as $school){
    $db_name = $school->database;
    $subdomain = $school->domain;
    $db_table = $db_name.'.account_school_details';
    $acc_student_details = $db_name.'.account_student_details';
    $students_count = DB::table(''.$acc_student_details.'')
            ->join(''.$db_table.'', ''.$db_table.'.id', '=', ''.$acc_student_details.'.account_school_details_id')
            ->count();
//   return  $students_count = DB::select('select count '.$acc_student_details.'.id'.' from '. $acc_student_details.' join '.$db_table.'  ON '.$db_table.'.id' == $acc_student_details.'.account_school_details_id');
    $school_details =  ['database'=>$db_name, 'subdomain'=>$subdomain, 'school'=>DB::select('select * from '.$db_table.''), 'students_count'=>$students_count];
    $data[] = $school_details;

   }
   $schools = collect($data);

//    foreach($schools as $school){
//     return $school;
//     // return $school['school'];
//       foreach($school['school'] as $sch) {
//           return $sch;
//       }; 
//    }

    // $schools = AccountSchoolDetail::with('students')->with('villages')->get();
    return DataTables::of($schools)
    ->addColumn('ownership',function($school){
        foreach($school['school'] as $sch) {
            return $sch->ownership;
        }; 
        
    })
    ->addColumn('organization_name', function($school){
        return 'Bizytech';
    })
    ->addColumn('school_name', function($school){

        foreach($school['school'] as $sch) {

            return  strtoupper($sch->name);

        }; 
        // ucwords(str_replace('_',' ',$school->name ));
           

    })
    ->addColumn('Number_of_students',function($school){

        return $school['students_count'];
        
    })
    ->addColumn('location', function($school){

     return 1;
    })
    ->addColumn('action', function($school){

        foreach($school['school'] as $sch) {
            $db = $school['database'];
            $id = strtoupper($sch->id);
            $button = '';
            $button .= '  <a href="'.route('configurations.school.profile',[$id,$db]).'" class="button-icon button btn btn-sm rounded-small btn-warning"><i class="fa fa-eye m-0"></i> </a>';
            $button .= ' <a href="" data-original-title="delete"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  dltBtn" ><i class="fa fa-trash  m-0"></i></a>';
            return '<nobr>'.$button. '</nobr>'; 

        }; 

     
      })
  ->rawColumns(['action'])
  ->make();
}



  public function schoolAcademicYearUpdate(Request $request){
    //  return $request->streams;
    // return $request->all();
   try { 
       DB::beginTransaction();

   foreach($request->season_name as $index => $value ){

         $season = AccountSchoolDetailSeason::updateOrCreate(

            ['id'=> $request->hidden_season_id],

            [
                'start_date'=>$request->season_start_date[$index],
                'end_date'=>$request->season_end_date[$index],
                'name'=>$value,

            ]); 
         

           foreach($request->semester_name as $semester_index => $semester){
           
               Semester::updateOrCreate(
                   [
                       'id'=> $request->hidden_semester_id ?  $request->hidden_semester_id[$semester_index] : null
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
        //   return count($request->class_name);
        //    return  (count($request->class_id));

             if($index <= (count($request->class_id)-1)){
                $class_id = $request->class_id[$index];
             }else{
                 $class_id = null;
             }


              $response = AccountSchoolDetailClass::updateOrCreate(
                   [
                       'id'=> $class_id
                    ],

                   [
                       'account_school_detail_season_id'=>$season->id,
                       'name'=>$value,
                       'symbol'=>$request->symbol[$index],
                       'short_form'=>$request->short_form[$index],
                       
                   ]);

                 return   $response->streams;

               foreach($request->streams[$response->id]  as  $stream_id){
                    //  return $stream_id;

                    // if()
                    foreach(  $response->streams as $strm){

                        AccountSchoolDetailStream::updateOrCreate(
                            [
                             'id' => $strm->id,
                             'account_school_detail_class_id'=>$response->id
                            ],
    
                            [
                                'name'=>  DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.streams WHERE id =?',[$stream_id])[0]->name,
                                'stream_id'=>$stream_id ,
                                'description'=>DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.streams WHERE id =?',[$stream_id])[0]->name,
                                'account_school_detail_class_id'=>$response->id
    
                            ]);

                    }
                   

                   }
             }
                 
        }
            DB::commit();

           if($response){
               session()->flash('success','Records altered successful');
            $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record created successful'];
            return response($data); 
        }
        
        $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
        session()->flash('success','Record could not be created');
        return  response($data);

        
        }
    catch (QueryException $e) {
        return $e->getMessage();
    $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
    return  response($data);
        
    }

}

public function academicYearEdit($id){

    $data['academic_year'] = AccountSchoolDetailSeason::find($id);
    $data['activeLink'] = 'academic_year';
    $data['class'] = '';
    return view('configuration::school.academic.new_academic_year')->with($data);

}


public function academicYearDelete($id){

    try {
        
        $acdmc_year = AccountSchoolDetailSeason::find($id)->delete();
        if($acdmc_year){
            $data = ['state'=>'Done', 'msg'=>'Academic Year Deleted Successfully','title'=>'success'];
            return response($data);
        }

        $data = ['state'=>'Fail', 'msg'=>'Academic Year coul not be Deleted ','title'=>'Fail'];
            return response($data);

    } catch (QueryException $e) {
        
        return $e->getMessage();



    }



}


public function academicYearIndex(){

    $data['activeLink'] = 'academic_year';
    return view('configuration::school.academic.academic_year')->with($data);


}

public function academicYearDatatable(){

    $academic_years = AccountSchoolDetailSeason::all();

    return DataTables::of($academic_years)


    ->addColumn('action', function($acy){
      $button = '';
                 $button .= '  <a href="'.route('configurations.school.academic.year.semester.index',[$acy->id]).'" type="button" data-academic_model="'.$acy->id.'" class="button-icon button btn btn-sm rounded-small btn-secondary streams"><i class="fa fa-eye m-0"></i> </a>';
                 $button .= ' <a href="'.route('configurations.school.academic.year.edit',[$acy->id]).'" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i></a>';
                 $button .= ' <a href="" data-original-title="delete"  data-id="'.$acy->id.'" class="button-icon button btn btn-sm rounded-small btn-danger  dltBtn" ><i class="fa fa-trash  m-0"></i></a>';
           
      return '<nobr>'.$button. '</nobr>';
      })
  ->rawColumns(['action'])
  ->make();

}



public function semesterIndex($id){

    $data['activeLink'] = 'academic_year';
    $data['academic_year'] = '';
    $data['semester'] = '';
    $data['id'] = $id;
    return view('configuration::school.semesters.index')->with($data);

}



public function semesterCreate($id,$s_id=null){

    $data['activeLink'] = 'academic_year';
    $data['academic_year'] = '';
    $data['semester'] = '';
    $data['acd_year'] = $id;

    if($s_id){
        $data['semester'] = Semester::find($s_id);
    }
    return view('configuration::school.semesters.create')->with($data);

}



public function semesterStore($id , Request $request ) {

    try {
        $data['activeLink'] = 'academic_year';
        $data['academic_year'] = '';
        $data['semester'] = '';

        DB::beginTransaction();
        
        $semester = Semester::updateOrCreate(
            [
                'id'=>$request->s_id,
                'account_school_detail_season_id'=>$id
            ],
            [
                'name'=>$request->semester,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
            ]
            );
            DB::commit();
    
            if($semester){
    
                $data = ['state'=>'Done','title'=>'Successful', 'msg'=>'Record created successful'];
                session()->flash('success', 'Semester created successful');
                return response($data); 
            }
            
            $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
            return  response($data);

    } catch (QueryException $e) {

        return $e->getMessage();
        
    }

}




public function semesterDatatable($id){

   
     $semesters =  AccountSchoolDetailSeason::find($id)->semesters;
    return DataTables::of($semesters)

    ->addColumn('created_by',function(){    
        return auth()->user()->name;
    })
    ->addColumn('action', function($semester){
      $button = '';
                 $button .= ' <a href="'.route('configurations.school.academic.year.semester.create',[$semester->account_school_detail_season_id,$semester->id]).'" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i></a>';
                 $button .= ' <a href="" data-original-title="delete"  data-id="'.$semester->id.'" class="button-icon button btn btn-sm rounded-small btn-danger  dltBtn" ><i class="fa fa-trash  m-0"></i></a>';
           
      return '<nobr>'.$button. '</nobr>';
      })
  ->rawColumns(['action'])
  ->make();

 

}



public function semesterDelete($id,$s_id){

    try {
        DB::beginTransaction();
    $data['activeLink'] = 'academic_year';
    $data['academic_year'] = '';
    $data['semester'] = '';

    $semester = Semester::where('account_school_detail_season_id',$id)->where('id',$s_id)->delete();
    DB::commit();
    if($semester){
        $data= ['state'=>'Done', 'msg'=>'Deleted Successfully', 'title'=>'success'];
        return response($data);
    }
    $data= ['state'=>'Fail', 'msg'=>'not Deleted', 'title'=>'Fail'];
    return response($data);

    } catch (QueryException $e) {

        return $e->getMessage();

    }

    

}


public function studentClass(Request $req){

// return $req->all();

$student = $this->student::find($req->student_id);
$data['class_id'] = $student->account_school_details_class_id;

return response($data);


}




public function  academicYearCreate(){
    $data['class'] = '';
    $data['activeLink'] = 'academic_year';
    $data['academic_year'] = '';
    return view('configuration::school.academic.new_academic_year')->with($data);

}


public function classes(){

    $data['active'] = 'classes';
    $data['activeLink'] = 'classes';
    return view('configuration::school.academic.classes')->with($data);


}


public function createClass(){


    $data['activeLink'] = 'classes';
    $data['class'] = '';
    return view('configuration::school.academic.new_class')->with($data);


}


public function storeClass(Request $request){

//  return $request->all();

try {

    DB::beginTransaction();

   $response = AccountSchoolDetailClass::updateOrCreate(
        [
    
            'id'=>$request->class_id
    
        ],
        
        [
        'name'=>$request->class_name,
        'symbol'=>$request->class_symbol,
        'short_form'=>$request->short_form
        ]
    
    );

    DB::commit();

    if($response){

        $data = ['state'=>'Done','title'=>'Successful', 'msg'=>'Record created successful'];
        session()->flash('success', 'Class created successful');
        return response($data); 
    }
    
    $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
    return  response($data);

    
} catch (QueryException $e) {

    $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
    return  response($data);
    
}

}


public function classDatatable(){

    $classes = AccountSchoolDetailClass::all() ;

    return DataTables::of($classes)

    ->addColumn('created_by',function(){    
        return auth()->user()->name;
    })
    ->addColumn('action', function($class){
      $button = '';
                 $button .= '  <a href="'.route('configurations.school.classes.streams',[$class->id]).'" type="button" data-academic_model="'.$class->id.'" class="button-icon button btn btn-sm rounded-small btn-secondary streams"><i class="fa fa-eye m-0"></i> </a>';
                 $button .= ' <a href="'.route('configurations.school.classes.edit',[$class->id]).'" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i></a>';
                 $button .= ' <a href="" data-original-title="delete"  data-id="'.$class->id.'" class="button-icon button btn btn-sm rounded-small btn-danger  dltBtn" ><i class="fa fa-trash  m-0"></i></a>';
           
      return '<nobr>'.$button. '</nobr>';
      })
  ->rawColumns(['action'])
  ->make();


} 


public function editClass($id){

    $data['activeLink'] = 'classes';
    $data['class'] = AccountSchoolDetailClass::find($id);
     return view('configuration::school.academic.new_class')->with($data);
}


public function streams(){

$data['activeLink'] = 'streams';    

return view('configuration::school.academic.streams')->with($data);

}


public function classStreamDatatable($id){


    $streams =  AccountSchoolDetailStream::where('account_school_detail_class_id',$id);

    return DataTables::of($streams)

    ->addColumn('created_by',function(){    
        return auth()->user()->name;
    })
    ->addColumn('action', function($stream){
      $button = '';
                //  $button .= '  <a href="javascript:void(0)" type="button" data-academic_model="'.$academic->id.'" data-toggle="modal" class="button-icon button btn btn-sm rounded-small btn-secondary  academic_more_details"><i class="fa fa-eye m-0"></i> </a>';
                 $button .= ' <a href="'.route('configurations.school.class.streams.edit',[$stream->classes->id,$stream->id]).'" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i></a>';
                 $button .= ' <a href="javascript:void(0)" data-id="'.$stream->id.'" class="button-icon button btn btn-sm rounded-small btn-danger  dltBtn" ><i class="fa fa-trash  m-0"></i></a>';
           
      return '<nobr>'.$button. '</nobr>';

      })
  ->rawColumns(['action'])
  ->make();


}



public function classStreamCreate($id){

    $data['activeLink'] = 'streams';
    $data['stream'] = '';
    $data['class_id'] = $id;
    $data['class_name'] = AccountSchoolDetailClass::find($id)->name;
    $data['classes'] = AccountSchoolDetailClass::all();
    return view('configuration::school.academic.class_new_stream')->with($data);

}


public function classStreamEdit($class_id,$stream_id){

    // return $class_id;
    $data['activeLink'] = 'streams';
    $data['stream'] = AccountSchoolDetailStream::find($stream_id);
    $data['class_id'] = $class_id;
    $data['class_name'] = AccountSchoolDetailClass::find($class_id)->name;
    $data['classes'] = AccountSchoolDetailClass::all();
    return view('configuration::school.academic.class_new_stream')->with($data);

}


public function  streamsPerClass($id){

    $data['id'] = $id;
    $data['activeLink'] = 'classes';
    return view('configuration::school.academic.class_streams')->with($data);

}


public function createStream(){

$data['activeLink'] = 'streams';
$data['stream'] = '';
$data['classes'] = AccountSchoolDetailClass::all();
return view('configuration::school.academic.new_stream')->with($data);

}


public function editStream($id){

    $data['activeLink'] = 'streams';
   /*  return */ $data['stream'] = AccountSchoolDetailStream::find($id);
    $data['classes'] = AccountSchoolDetailClass::all();
    return view('configuration::school.academic.new_stream')->with($data);
    
    }





public function storeStream( Request $request){


//   return  $request->all();

    try {

        DB::beginTransaction();

       $response = AccountSchoolDetailStream::updateOrCreate(
            [
        
                'id'=>$request->stream_id
        
            ],
            
            [
            'name'=>$request->stream_name,
            'description'=>$request->description,
            'account_school_detail_class_id'=>$request->class_id
            ]
        
        );
    
        DB::commit();

        // return $response;
    
        if($response){
            $data = ['state'=>'Done', 'data'=>$response, 'title'=>'Successful', 'msg'=>'Record created successful'];
            session()->flash('success', 'Stream created successful');
            return response($data); 
        }
        
        $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
        return  response($data);
    
        
    } catch (QueryException $e) {
    
        $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
        return  response($data);
        
    }


}





public function classDelete($id){

    try {

        $response = AccountSchoolDetailClass::find($id)->delete();
       
        if($response){

            $data = ['state'=>'Done', 'data'=>$response, 'title'=>'Successful', 'msg'=>'Record deleted successful'];
            return response($data); 

        }
        
        $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be deleted'];
        return  response($data);



    } catch (QueryException $e) {
        
        $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
        return  response($data);


    }


}



public function StreamDatatable(){

    $streams =  AccountSchoolDetailStream::all();

    return DataTables::of($streams)

    ->addColumn('class',function($stream){

        return $stream->classes->name;

    })
    ->addColumn('created_by',function(){    
        return auth()->user()->name;
    })
    ->addColumn('action', function($stream){
      $button = '';
                //  $button .= '  <a href="javascript:void(0)" type="button" data-academic_model="'.$academic->id.'" data-toggle="modal" class="button-icon button btn btn-sm rounded-small btn-secondary  academic_more_details"><i class="fa fa-eye m-0"></i> </a>';
                 $button .= ' <a href="'.route('configurations.school.streams.edit',[$stream->id]).'" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i></a>';
                 $button .= ' <a href="javascript:void(0)" data-original-title="Edit" data-id="'.$stream->id.'"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  dltBtn" ><i class="fa fa-trash  m-0"></i></a>';
           
      return '<nobr>'.$button. '</nobr>';

      })
  ->rawColumns(['action'])
  ->make();


}



public function streamDelete($id){


    try {

        $response = AccountSchoolDetailStream::find($id)->delete();
       
        if($response){

            $data = ['state'=>'Done', 'data'=>$response, 'title'=>'Successful', 'msg'=>'Record deleted successful'];
            return response($data); 

        }
        
        $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be deleted'];
        return  response($data);



    } catch (QueryException $e) {
        
        $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
        return  response($data);


    }



}




}
