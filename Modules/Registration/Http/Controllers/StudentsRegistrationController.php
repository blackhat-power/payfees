<?php

namespace Modules\Registration\Http\Controllers;

use App\Exports\StudentsExport;
use App\Imports\ChochoteImport;
use App\Imports\StudentImport;
use App\Models\Account;
use App\Models\ContactPerson;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Modules\Configuration\Entities\AccountSchoolDetailClass;
use Modules\Configuration\Entities\AccountSchoolDetailStream;
use Modules\Registration\Entities\AccountStudentDetail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Attachment;
use App\Models\Contact;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Modules\Accounts\Entities\FeeMasterCategory;
use Modules\Accounts\Entities\FeeStructure;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;


class StudentsRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

      $data['streams'] = AccountSchoolDetailStream::select(['name','id'])->groupBy(['name'])->get(); 
       $data['classes'] = AccountSchoolDetailClass::select(['name','id'])->groupBy(['name'])->get();   
     
        $data['activeLink']='student';
        return view('registration::index')->with($data);
        
    }

    public function registrationPortal(Request $request){

        $data['streams'] = AccountSchoolDetailStream::select(['name','id'])->groupBy(['name'])->get(); 
       $data['classes'] = AccountSchoolDetailClass::select(['name','id'])->groupBy(['name'])->get();   
     
        $data['activeLink']='student';
        return view('registration::student.registration_wizard')->with($data);


    }

 

    public function studentsStore(Request $request){

        try {

            //   return $request->all();

            DB::beginTransaction();

            $full_name = $request->first_name .' '. $request->middle_name . ' '. $request->last_name;
           $account =   Account::updateOrCreate(
                [
                    'id'=>$request->account_id
                ],
                [
                    'name'=>$full_name,
                    'created_by'=>auth()->user()->id,
                ]

                );

                if($account){
                //    return $class = $request->students_stream;
                     if($request->gender == 'male'){
                         $avatar = 'man_avatar.png';
                     }
                     else{
                        $avatar = 'avatar-woman.png';
                     }
                   $student_detail =  AccountStudentDetail::updateOrCreate(
                        [
                            'id'=>$request->stdnt_id
                        ],
                        [
                            'account_id'=>$account->id,
                            'first_name'=>$request->first_name,
                            'middle_name'=>$request->middle_name,
                            'last_name'=>$request->last_name,
                            'gender'=>$request->gender,
                            'admitted_year'=>$request->admitted_year,
                            'dob'=>$request->dob,
                            'session'=>AccountSchoolDetail::select('account_school_details.*')->first()->current_session,
                            'account_school_details_id'=>AccountSchoolDetail::select('account_school_details.*')->first()->id,
                            'account_school_details_class_id'=>$request->students_class,
                            'account_school_detail_stream_id'=>$request->students_stream,
                            'profile_pic'=>$avatar

                        ]
                        );

                        $full_name = $request->first_name .' '.$request->middle_name.' '.$request->last_name;

                        $user = User::create([
                            'name'=>$full_name,
                            'username'=>strtoupper($request->last_name),
                            'gender'=>$request->gender,
                            'user_type'=>4,
                            'student_id'=>$student_detail->id,
                            'created_by'=>auth()->user()->id,
                            'phone'=>$request->phone,
                            'email'=>$request->email,
                            'address'=>$request->address,
                            'passport'=>$avatar,
                            'password'=>bcrypt('123456')
                        ]);
                        $user->assignRole(2);


                    Contact::updateOrCreate(
                        [
                            'id'=>$request->std_phone_id
                        ],
                        
                        [
                            'contact_type_id'=>1,
                            'contact'=>$request->phone,
                            'contactable_id' => $student_detail->id,
                            'contactable_type' => AccountStudentDetail::class,

                        ]);

                        Contact::updateOrCreate(
                            [
                                'id'=>$request->std_email_id
                            ],
                            [
                                'contact_type_id'=>2,
                                'contact'=>$request->email,
                                'contactable_id' => $student_detail->id,
                                'contactable_type' => AccountStudentDetail::class,
    
                            ]);


                            Contact::updateOrCreate(
                                [
                                    'id'=>$request->std_address_id
                                ],
                                [
                                    'contact_type_id'=>3,
                                    'contact'=>$request->address,
                                    'contactable_id' => $student_detail->id,
                                    'contactable_type' => AccountStudentDetail::class,
        
                                ]);


                    if($request->father_name){

                        $father = ContactPerson::updateOrCreate(
                            [
                                'id'=>$request->father_id
                            ],
                            [
                            'full_name'=>$request->father_name,
                            'occupation'=>$request->father_occupation,
                            'relationship'=>'FATHER',
                            'personable_type' => AccountStudentDetail::class,
                            'personable_id' => $student_detail->id,
     
                        ]);

                    Contact::updateOrCreate(
                        [
                            'id'=>$request->father_contact_id
                        ],
                        [
                            'contact_type_id'=>1,
                            'contact'=>$request->father_phone,
                            'contactable_id' => $father->id,
                            'contactable_type' => ContactPerson::class,

                        ]);

                    }
                     if($request->mother_name){

                        $mother = ContactPerson::updateOrCreate(
                            [
                                'id'=>$request->mother_id
                            ],
                            [
                            'full_name'=>$request->mother_name,
                            'occupation'=>$request->mother_occupation,
                            'relationship'=>'MOTHER',
                            'personable_type' => AccountStudentDetail::class,
                            'personable_id' => $student_detail->id,
     
                            ]
                                                    );

                        Contact::updateOrCreate(
                            [
                             'id'=>$request->mother_contact_id
                            ],
                            [
                                'contact_type_id'=>1,
                                'contact'=>$request->mother_phone,
                                'contactable_id' => $mother->id,
                                'contactable_type' => ContactPerson::class,
    
                            ]
                        );

                    }

                    if($request->guardian_name){

                        $guardian = ContactPerson::updateOrCreate(

                            [
                                'id'=>$request->guardian_id
                            ],
                            
                            [
                            'full_name'=>$request->guardian_name,
                            'occupation'=>$request->guardian_occupation,
                            'relationship'=>'GUARDIAN',
                            'personable_type' => AccountStudentDetail::class,
                            'personable_id' => $student_detail->id,
     
                        ]);

                    $final_store =  Contact::updateOrCreate(
                        [
                            'id'=>$request->guardian_contact_id
                        ],
                            [
                                'contact_type_id'=>1,
                                'contact'=>$request->guardian_phone,
                                'contactable_id' => $guardian->id,
                                'contactable_type' => ContactPerson::class,
    
                            ]
                        );


                    }
                }
          DB::commit();

          if($student_detail){

           $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record created successful'];

           return response($data);

          }

          $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record could not be created'];
          return response($data);


        } catch (QueryException $e) {
            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            // session()->flash('error','Something went wrong!<br />' . $e->errorInfo[2]);
            return  response($data);
           
        }
        
    }

    public function importStudents(Request $req){

        try {
            
        $class_id = $req->class_filter;
        $req->stream_filter ?  $stream_id = $req->stream_filter : $stream_id = null;
 
       $excel = Excel::import(new StudentImport($class_id,$stream_id) , $req->file('students_excel'));

       if($excel){
    
        $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Students Imported successful'];

        return response($data);

     }

     $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Students could not be imported'];
       return  response($data);

   } catch (QueryException $e) {

     $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
     return  response($data); 
   }

    }


    public function studentsExcelTemplateExport(){

        $spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
        $sheet = $spreadsheet->getActiveSheet();
       
        // manually set table data value
        $sheet->setCellValue('A1', 'First Name'); 
        $sheet->setCellValue('B1', 'Middle Name');
        $sheet->setCellValue('C1', 'Last Name');
        $sheet->setCellValue('D1', 'Gender');
        $sheet->setCellValue('E1', 'Date Of Birth');
        $sheet->setCellValue('F1', 'Address');
        $sheet->setCellValue('G1', 'Phone');
        $sheet->setCellValue('H1', 'Email');
        $sheet->setCellValue('I1', 'Admitted Year');
        $sheet->setCellValue('J1', 'Father Name');
        $sheet->setCellValue('K1', 'Father Phone');
        $sheet->setCellValue('l1', 'Father Occupation');
        $sheet->setCellValue('M1', 'Mother Name');
        $sheet->setCellValue('N1', 'Mother Occupation');
        $sheet->setCellValue('O1', 'Mother Phone');
        $sheet->setCellValue('P1', 'Guardian Name');
        $sheet->setCellValue('Q1', 'Guardian Occupation');
        $sheet->setCellValue('R1', 'Guardian Phone');
       

        $spreadsheet->getActiveSheet()->getStyle('A1:R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('75EF24');
        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
         }
        $writer = new Xlsx($spreadsheet);// instantiate Xlsx
 
        $filename = 'students-template'; // set filename for excel file to be exported
 
        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');	// download file 

    }

    public function studentsDatatable(Request $request){
        
        $students = AccountStudentDetail::join('account_school_detail_classes','account_student_details.account_school_details_class_id','=','account_school_detail_classes.id')
                                            ->leftjoin('account_school_detail_streams','account_student_details.account_school_detail_stream_id','account_school_detail_streams.id')
                                            ->select('account_student_details.*','account_school_detail_classes.name as class_name','account_school_detail_streams.name as stream_name')
                                            ->where('account_student_details.grad',0);

        if (!empty($request->get('class_id'))) {
           $students = $students->where('account_student_details.account_school_details_class_id',$request->get('class_id'));
        }

        if (!empty($request->get('stream_id'))) {
            $students = $students->where('account_student_details.account_school_detail_stream_id',$request->get('stream_id'))
            ->where('account_student_details.account_school_details_class_id',$request->get('class_id'));
         }



        return DataTables::of($students)

        ->addColumn('avatar',  function($student){

            $url= asset('storage/student_profile_pics/'.$student->profile_pic);
            return '<img src="'.$url.'" height="50" width="50" style="border-radius:50%;  object-fit: cover;
         " >';
            

        })

        // ->addColumn('status', function($student){
        //     $data['status'] = $student->status;
        //     $data['id'] = $student->id;
        //    return (string) view('registration::includes.status',['status'=> $student->status, 'id'=>$student->id ]);   
        // })

        ->editColumn('dob', function($student){

           return date("jS M, Y", strtotime($student->dob));
        })
            
         ->addColumn('full_name',function($student){
            $full_name = ucwords($student->full_name);
            return $full_name;
        }) 
        ->addColumn('action', function($student){
          $button = '';
                    $button .= '  <a href="'.route('students.profile',$student->id).'" class="button-icon button btn btn-sm rounded-small btn-success"><i class="fa fa-eye m-0"></i> </a>';
                    $button .= ' <a href="javascript:void(0)" data-original-title="Edit" data-student_id="'.$student->id.'"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  studentEditBtn" ><i class="fa fa-edit  m-0"></i></a>';
                    $button .= ' <a href="" data-original-title="Edit" data-student_id="'.$student->id.'"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  stdDltBtn" ><i class="fa fa-trash  m-0"></i></a>';
          return '<nobr>'.$button. '</nobr>';
          })
          
      ->rawColumns(['action','avatar','status'])
      ->make();
      }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('registration::create');
    }

                                        /* PRINTOUTS */


    public function printing(Request $request){
       
        $data['school_info'] = AccountSchoolDetail::first();
        $data['address'] =  Contact::where('contactable_type',AccountSchoolDetail::class)
                            ->where('contact_type_id',3)->first()->contact;
        $data['phone'] = Contact::where('contactable_type',AccountSchoolDetail::class)
                        ->where('contact_type_id',1)->first()->contact;

        $data['email'] = Contact::where('contactable_type',AccountSchoolDetail::class)
        ->where('contact_type_id',2)->first()->contact;

        // $data['students'] = $students = AccountStudentDetail::select('account_student_details.*')->get();
         $students = AccountStudentDetail::join('account_school_detail_classes','account_student_details.account_school_details_class_id','=','account_school_detail_classes.id')
                                            ->leftjoin('account_school_detail_streams','account_student_details.account_school_detail_stream_id','account_school_detail_streams.id')
                                            ->select('account_student_details.*','account_school_detail_classes.name as class_name','account_school_detail_streams.name as stream_name');

        if (!empty($request->get('class_id'))) {
            
             $students->where('account_student_details.account_school_details_class_id',$request->get('class_id'));
        }

        if (!empty($request->get('stream_id'))) {

            // return $request->get('stream_id');

            $students->where('account_student_details.account_school_detail_stream_id',$request->get('stream_id'))
            ->where('account_student_details.account_school_details_class_id',$request->get('class_id'));
         }

         $data['students'] = $students->get();
         

        if ($request->file_type == 'pdf') {
            // return view('registration::printouts.students_pdf')->with($data);
            $pdf = FacadePdf::loadView('registration::printouts.students_pdf', $data);
            return $pdf->stream('students.pdf', array("Attachment" => false));
            
        }
        if ($request->file_type == 'excel') {

            return Excel::download(new StudentsExport, 'students.xlsx');

        }


    }


    public function editStudent(Request $request){
       
       $student_id = $request->student_id;
        
        if ($student_id) {
            $data['student'] = AccountStudentDetail::find($student_id);
            // $data['new'] = AccountStudentDetail::leftjoin('contacts', 'account_student_details.id', '=', 'contacts.contactable_id')

            // ->where('account_student_details.id', $student_id)->get();

            $data['address'] = AccountStudentDetail::leftjoin('contacts', 'account_student_details.id', '=', 'contacts.contactable_id')
            ->select('contacts.id as cnct_id','contacts.contact')
            ->where('account_student_details.id', $student_id)
            ->where('contacts.contact_type_id', 3)
            ->first();

            $data['phone'] = AccountStudentDetail::leftjoin('contacts', 'account_student_details.id', '=', 'contacts.contactable_id')
            ->select('contacts.id as cnct_id','contacts.contact')
            ->where('account_student_details.id', $student_id)
            ->where('contacts.contact_type_id', 1)
            ->first();

            $data['email'] = AccountStudentDetail::leftjoin('contacts', 'account_student_details.id', '=', 'contacts.contactable_id')
            ->select('contacts.id as cnct_id','contacts.contact')
            ->where('account_student_details.id', $student_id)
            ->where('contacts.contact_type_id', 2)
            ->first();

            /* Guardian */
            $data['guardian'] = AccountStudentDetail::join('contact_people', 'account_student_details.id', '=', 'contact_people.personable_id')
            ->select('contact_people.*', 'contact_people.full_name as guardian_name')
            ->where('account_student_details.id', $student_id)
            ->where('personable_type', AccountStudentDetail::class)
            ->where('contact_people.relationship', 'GUARDIAN')
            ->first();

            $data['guardian_phone'] = AccountStudentDetail::join('contact_people', 'account_student_details.id', '=', 'contact_people.personable_id')
            ->join('contacts', 'contact_people.id', '=', 'contacts.contactable_id')
            ->select('contact_people.*', 'contacts.contact','contacts.id as cnct_id', 'contacts.contact_type_id')
            ->where('account_student_details.id', $student_id)
            ->where('contactable_type', ContactPerson::class)
            ->where('contacts.contact_type_id', 1)
            ->where('contact_people.relationship', 'GUARDIAN')
            ->first();

            

            /* Mother */

            $data['mother'] = AccountStudentDetail::join('contact_people', 'account_student_details.id', '=', 'contact_people.personable_id')
            ->select('contact_people.*', 'contact_people.full_name as mother_name')
            ->where('account_student_details.id', $student_id)
            ->where('personable_type', AccountStudentDetail::class)
            ->where('contact_people.relationship', 'MOTHER')
            ->first();

            $data['mother_phone'] = AccountStudentDetail::join('contact_people', 'account_student_details.id', '=', 'contact_people.personable_id')
            ->join('contacts', 'contact_people.id', '=', 'contacts.contactable_id')
            ->select('contact_people.*', 'contacts.contact','contacts.id as cnct_id')
            ->where('account_student_details.id', $student_id)
            ->where('contactable_type', ContactPerson::class)
            ->where('contact_type_id', 1)
            ->where('contact_people.relationship', 'MOTHER')
            ->first();

            /* FATHER */

           $data['father'] = AccountStudentDetail::join('contact_people', 'account_student_details.id', '=', 'contact_people.personable_id')
            ->select('contact_people.*', 'contact_people.full_name as father_name')
            ->where('account_student_details.id', $student_id)
            ->where('personable_type', AccountStudentDetail::class)
            ->where('contact_people.relationship', 'FATHER')
            ->first();

             $data['father_phone'] = AccountStudentDetail::join('contact_people', 'account_student_details.id', '=', 'contact_people.personable_id')
            ->join('contacts', 'contact_people.id', '=', 'contacts.contactable_id')
            ->select('contact_people.*', 'contacts.contact','contacts.id as cnct_id')
            ->where('account_student_details.id', $student_id)
            ->where('contactable_type', ContactPerson::class)
            ->where('contact_type_id', 1)
            ->where('contact_people.relationship', 'FATHER')
            ->first();

            

            return response($data);
        }
    }


    public function profilePicUpdate(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            
            $request->validate([
                'image.*' => 'mimes:jpeg,png,jpg,gif,svg',
            ]);

            if($request->hasfile('profile_pic')){
                $avatar_name= $request->file('profile_pic')->getClientOriginalName();
                $path = $request->file('profile_pic')->storeAs('student_profile_pics',$avatar_name, 'public');

                AccountStudentDetail::where('id',$id)->update(['profile_pic'=>$avatar_name ]);
 
             }

        DB::commit();
       return $url= asset('storage/student_profile_pics/'.$avatar_name);
        } catch (QueryException $e) {

            return $e->getMessage();
        }
        
  }


    public function storeAttachments(Request $request,$id){

            // return $request->attachments;

        try {

            if ($request->hasfile('attachment_file')) {
                $avatar_name= $request->file('attachment_file')->getClientOriginalName();
                $path = $request->file('attachment_file')->storeAs('student/'.$id.'/attachments/'.$request->attachments.'', $avatar_name, 'public',true);    
                DB::beginTransaction();
    
                $attachment = Attachment::Create(
                    [
                        'attachable_type'=>AccountStudentDetail::class,
                        'attachable_id'=>$id,
                        'attachment_type'=>$request->attachments,
                        'path'=>$path,
                        'name'=>$avatar_name,
                        'created_by'=> auth()->user()->id
                    ]
                );
            }
    
                DB::commit();

            if($attachment){
    
               $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Uploaded successful'];
    
               return response($data);
    
            }
    
            $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'could not be uploaded'];
              return  response($data);

          } catch (QueryException $e) {

            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            return  response($data); 
          } 
        

    }




    public function attachmentsDatatable($id){
        

        $attachments = Attachment::where('attachable_id',$id)
                                ->where('attachable_type',AccountStudentDetail::class)->get();

        return DataTables::of($attachments)

        ->addColumn('action', function($attachment){
          $button = '';
                    $button .= ' <a target="_blank" href="'.asset('storage/student/'.$attachment->attachable_id.'/attachments/'.$attachment->attachment_type.'/'.$attachment->name).'" class="button-icon button btn btn-sm rounded-small btn-success"><i class="fa fa-eye m-0"></i> </a>';
                    $button .= ' <a href="javascript:void(0)" data-original-title="delete"  data-toggle="tooltip" data-dlt_attachment="'.$attachment->id.'" class="button-icon button btn btn-sm rounded-small btn-danger  attDltBtn" ><i class="fa fa-trash  m-0"></i></a>';
          return '<nobr>'.$button. '</nobr>';
          })
      ->rawColumns(['action','avatar'])
      ->make();
      }


      public function deleteStudent($id){
          try {
              
            $student =   AccountStudentDetail::find($id);

            if($student){
                Contact::where('contactable_id',$student->id)->where('contactable_type',AccountSchoolDetail::class)->delete();
                ContactPerson::where('personable_id',$student->id)->delete();
                $student->delete();
                
               $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record deleted successful'];
    
               return response($data);
    
            }
    
            $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be deleted'];
              return  response()->json($data);

          } catch (QueryException $e) {

            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            return  response()->json($data); 
          }
       
      }



      public function deleteAttachments($id){
         
        try {
            

            $attachment = Attachment::where('attachable_type',AccountStudentDetail::class)
            ->where('attachable_id',$id)->first();

            Storage::delete($attachment->path); /* DELETE INTERNAL STORAGE ON HOLD */
            if($attachment){
            $delete = $attachment->delete();

            if($delete){

                $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record deleted successful'];
    
               return response($data);

            }
            $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be deleted'];
              return  response($data);

                }

        } catch (QueryException $e) {
            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            return  response($data); 
        }
       

      }
                /* GRADUATES */

      public function graduatedStudentsIndex(){
        $data['streams'] = AccountSchoolDetailStream::select(['name','id'])->groupBy(['name'])->get(); 
        $data['classes'] = AccountSchoolDetailClass::select(['name','id'])->groupBy(['name'])->get(); 
          $data['activeLink'] = 'graduated';
          return view('registration::student.graduates.index')->with($data);

      }


      public function graduatedStudentsDatatable(Request $request){

         $students = AccountStudentDetail::where('account_student_details.grad',1);

        if (!empty($request->get('class_id'))) {
             $students->where('account_student_details.account_school_details_class_id',$request->get('class_id'));
         }
 
         if (!empty($request->get('stream_id'))) {
             $students->where('account_student_details.account_school_detail_stream_id',$request->get('stream_id'))
             ->where('account_student_details.account_school_details_class_id',$request->get('class_id'));
          }

          $final_students = $students->get();

        return DataTables::of($final_students)
        ->editColumn('graduation_date', function($student){
            return $student->graduation_date;
        })
        ->addColumn('class', function($student){
            // return $student->full_name;
           return $student->classes->name;

        })

        ->addColumn('stream', function($student){
            // return $student->full_name;
            return $student->streams ? $student->streams->name : '';
           

        })

        ->addColumn('full_name', function($student){

            return ucwords($student->full_name);

        })

        ->editColumn('dob', function($student){
            return date("jS F, Y", strtotime($student->dob));
        })

        ->addColumn('avatar',  function($student){
            $url= asset('storage/student_profile_pics/'.$student->profile_pic);
            return '<img src="'.$url.'" height="45" width:"45" style="border-radius:50%;
            display: table;" >';
        })
        ->addColumn('action', function($student){
          $button = '';
          $button .= '  <a href="'.route('students.profile',$student->id).'" class="button-icon button btn btn-sm rounded-small btn-success"><i class="fa fa-eye m-0"></i> </a>';
                return '<nobr>'.$button. '</nobr>';
          })
      ->rawColumns(['action','avatar'])
      ->make();


      }



      public function studentWizardStore(Request $request){

        try {
            DB::beginTransaction();

            // return $request->all();
            $full_name = $request->first_name .' '. $request->middle_name . ' '. $request->last_name;
           $account = Account::updateOrCreate(
                [
                    'id'=>$request->account_id
                ],
                [
                    'name'=>$full_name,
                    'created_by'=>auth()->user()->id,
                ]

                );

                if($account){
                //    return $class = $request->students_stream;
                     if($request->gender == 'male'){
                         $avatar = 'man_avatar.png';
                     }
                     else{
                        $avatar = 'avatar-woman.png';
                     }
                   $student_detail =  AccountStudentDetail::updateOrCreate(
                        [
                            'id'=>$request->stdnt_id
                        ],
                        [
                            'account_id'=>$account->id,
                            'first_name'=>$request->first_name,
                            'middle_name'=>$request->middle_name,
                            'last_name'=>$request->last_name,
                            'gender'=>$request->gender,
                            'admitted_year'=>$request->admitted_year,
                            'dob'=>$request->dob,
                            'session'=>AccountSchoolDetail::select('account_school_details.*')->first()->current_session,
                            'account_school_details_id'=>AccountSchoolDetail::select('account_school_details.*')->first()->id,
                            'account_school_details_class_id'=>$request->students_class,
                            'account_school_detail_stream_id'=>$request->students_stream,
                            'profile_pic'=>$avatar
                        ]
                        );

                        $full_name = $request->first_name .' '.$request->middle_name.' '.$request->last_name;

                        $user = User::create([
                            'name'=>$full_name,
                            'username'=>strtoupper($request->last_name),
                            'gender'=>$request->gender,
                            'user_type'=>4,
                            'student_id'=>$student_detail->id,
                            'created_by'=>auth()->user()->id,
                            'phone'=>$request->phone,
                            'email'=>$request->email,
                            'address'=>$request->address,
                            'passport'=>$avatar,
                            'password'=>bcrypt('123456')
                        ]);
                        $user->assignRole(2); 


                    Contact::updateOrCreate(
                        [
                            'id'=>$request->std_phone_id
                        ],
                        
                        [
                            'contact_type_id'=>1,
                            'contact'=>$request->phone,
                            'contactable_id' => $student_detail->id,
                            'contactable_type' => AccountStudentDetail::class,

                        ]);

                        Contact::updateOrCreate(
                            [
                                'id'=>$request->std_email_id
                            ],
                            [
                                'contact_type_id'=>2,
                                'contact'=>$request->email,
                                'contactable_id' => $student_detail->id,
                                'contactable_type' => AccountStudentDetail::class,
    
                            ]);


                            Contact::updateOrCreate(
                                [
                                    'id'=>$request->std_address_id
                                ],
                                [
                                    'contact_type_id'=>3,
                                    'contact'=>$request->address,
                                    'contactable_id' => $student_detail->id,
                                    'contactable_type' => AccountStudentDetail::class,
        
                                ]);
                }
          DB::commit();

          if($student_detail){

           $data = ['state'=>'Done', 'title'=>'Successful', 'student'=>$student_detail, 'msg'=>'Record created successful'];

           return response($data);

          }

          $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record could not be created'];
          return response($data);


        } catch (QueryException $e) {
            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            // session()->flash('error','Something went wrong!<br />' . $e->errorInfo[2]);
            return  response($data);
           
        }
        
        
        
        }

        public function studentWizardContactPersonStore(Request $request){
         $student_detail = AccountStudentDetail::orderBy('id','DESC')->first();
          try {
            
            if($request->father_name){

                $father = ContactPerson::updateOrCreate(
                    [
                        'id'=>$request->father_id
                    ],
                    [
                    'full_name'=>$request->father_name,
                    'occupation'=>$request->father_occupation,
                    'relationship'=>'FATHER',
                    'personable_type' => AccountStudentDetail::class,
                    'personable_id' => $student_detail->id,

                ]);

            Contact::updateOrCreate(
                [
                    'id'=>$request->father_contact_id
                ],
                [
                    'contact_type_id'=>1,
                    'contact'=>$request->father_phone,
                    'contactable_id' => $father->id,
                    'contactable_type' => ContactPerson::class,

                ]);

            }

            if($request->mother_name){

                $mother = ContactPerson::updateOrCreate(
                    [
                        'id'=>$request->mother_id
                    ],
                    [
                    'full_name'=>$request->mother_name,
                    'occupation'=>$request->mother_occupation,
                    'relationship'=>'MOTHER',
                    'personable_type' => AccountStudentDetail::class,
                    'personable_id' => $student_detail->id,

                    ]
                                                    );

                Contact::updateOrCreate(
                    [
                     'id'=>$request->mother_contact_id
                    ],
                    [
                        'contact_type_id'=>1,
                        'contact'=>$request->mother_phone,
                        'contactable_id' => $mother->id,
                        'contactable_type' => ContactPerson::class,

                    ]
                );

            }

            if($request->guardian_name){

                $guardian = ContactPerson::updateOrCreate(

                    [
                        'id'=>$request->guardian_id
                    ],
                    
                    [
                    'full_name'=>$request->guardian_name,
                    'occupation'=>$request->guardian_occupation,
                    'relationship'=>'GUARDIAN',
                    'personable_type' => AccountStudentDetail::class,
                    'personable_id' => $student_detail->id,

                ]);

            $final_store =  Contact::updateOrCreate(
                [
                    'id'=>$request->guardian_contact_id
                ],
                    [
                        'contact_type_id'=>1,
                        'contact'=>$request->guardian_phone,
                        'contactable_id' => $guardian->id,
                        'contactable_type' => ContactPerson::class,

                    ]
                );


            }

            DB::commit();

            if($student_detail){
  
             $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record created successful'];
  
             return response($data);
  
            }
  
            $data = ['state'=>'Fail', 'title'=>'Successful', 'msg'=>'Record could not be created'];
            return response($data);
  
  
          } catch (QueryException $e) {
              $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
              // session()->flash('error','Something went wrong!<br />' . $e->errorInfo[2]);
              return  response($data);
             
          }

        }


        public function studentClassPartStore(Request $req){

            try {
                
            DB::beginTransaction();
            $student_detail = AccountStudentDetail::orderBy('id','DESC')->first();
            $data = [ 'account_school_details_class_id'=>$req->students_class,'account_school_detail_stream_id'=>$req->students_stream ];
            $update =  $student_detail->update($data);
            $class_id = AccountStudentDetail::find($req->student_id)->account_school_details_class_id;
            $category = AccountStudentDetail::find($req->student_id)->category;
                DB::commit();

                if($update){
      
                 $data = ['state'=>'Done','class_id'=>$class_id,'category'=>$category, 'title'=>'Successful', 'msg'=>'Record created successful'];
      
                 return response($data);
      
                }
      
                $data = ['state'=>'Fail', 'title'=>'Successful', 'msg'=>'Record could not be created'];
                return response($data);



            } catch (QueryException $e) {
                
                $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
                // session()->flash('error','Something went wrong!<br />' . $e->errorInfo[2]);
                return  response($data);

            }
        }

        public function queryFeeStructure( Request $req){

$html = '';
         $fee_masters =  FeeMasterCategory::join('fee_structures','fee_master_categories.id','=','fee_structures.category_id')
       ->select('fee_master_categories.id as the_category_id','fee_master_categories.name as category_name','fee_structures.id as fee_structure_id')
       ->where('class_id',$req->class_id)
          ->groupBy('category_id')->get();
        
        foreach ($fee_masters as $key => $fee) {
        $total = 0;
        $student_fee_items = FeeStructure::join('fee_master_particulars','fee_structures.particular_id','=','fee_master_particulars.id')
         ->join('account_school_detail_classes','account_school_detail_classes.id','=','fee_structures.class_id')
         ->join('account_student_details','account_student_details.id','=','fee_structures.student_id')
         ->select('fee_structures.class_id','fee_structures.category_id','amount','fee_master_particulars.name as fee_name','particular_id')
          ->where('category_id',$fee->the_category_id)
          ->where('class_id',$req->class_id)
          ->groupBy('particular_id')
          ->get();

            $html.= '<div class="accordion-container">
            <a href="#" class="accordion-toggle">'.$fee->category_name.'</a>
            <div class="accordion-content">
            <input type="hidden" name="category_id" value="'.$fee->category_id.'"> 
            ';
            foreach($student_fee_items as $key=>$item){
                $total += $item->amount;
                $html .= '<div class="form-check">
                <div class="batch total_check">
                      <div class="div_spaces">
                      <span class="spaces"> <input type="checkbox" value="'.$item->particular_id.'" name="particular_ids[]"  class="form-check-input checkboxes" checked>
                      <input type="hidden" name="amount[]" value="'.$item->amount.'">   
                      </span>  
                      <span class="spaces">'.$item->fee_name .'</span>
                      </div>
          
                      <div class="div_spaces">
                      <span class="spaces"> &nbsp; </span>
                      <span style="float:right; margin-left:3rem" class="spaces amount">  '.$item->amount.' </span>
                     </div>
                     </div>
                
              </div>';

            }
            $html.='</div> </div>';
          }
          
return response($html);

           return FeeStructure::leftjoin('fee_master_particulars','fee_master_particulars.id','=','fee_structures.particular_id')
           ->where('class_id',$req->class_id)->orderBy('amount','DESC')->groupBy('particular_id')->get();
            // return $req->all();
        }



        public function studentFeeStructureStore(Request $request){

            try {


                return $request->all();
    
                DB::beginTransaction();
                $particular_id = $request->particular_id;
                $student_category = $request->student_category;
                $category_id = $request->select_category;
                $description = $request->description;
                $amount = $request->amount;
                $response = 1;
    
            //     foreach($request->fee_items as $row_index=>$item){
    
            //       $students =  AccountSchoolDetailClass::find($class)->students;
    
            //         // return $students;
            //         foreach ($students as $key => $student) {
    
            //         $response = FeeStructure::updateOrCreate(
            //             [
            //                 'id' => $request->fee_structure_id
            //             ],
            //             [
            //                 'category_id'=>$category_id,
            //                 'amount'=>$amount,
            //                 'created_by'=>auth()->user()->id,
            //                 'category_type'=>$student_category,
            //                 'class_id'=>$class,
            //                 'particular_id'=>$particular_id,
            //                 'description'=>$description,
            //                 'student_id'=>$student->id 
            //             ]
            //             );
    
            //         }
            // }
                DB::commit();
                if ($response) {
    
    
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




}
