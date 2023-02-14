<?php

namespace Modules\Registration\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactPerson;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Modules\Configuration\Entities\AccountSchoolDetailClass;
use Modules\Configuration\Entities\AccountSchoolDetailStream;
use Modules\Registration\Entities\AccountStudentDetail;

class StudentsProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('registration::index');
    }


    public static function studentProfile($id){
        $data['student'] = $student = AccountStudentDetail::find($id);
        $data['school'] = AccountSchoolDetail::first();
       $data['email'] = Contact::where('contactable_type',AccountStudentDetail::class)
                                   ->where('contactable_id',$id)
                                   ->where('contact_type_id',2)
                                   ->first()->contact;
       $data['phone'] = Contact::where('contactable_type',AccountStudentDetail::class)
                                   ->where('contactable_id',$id)
                                   ->where('contact_type_id',1)
                                   ->first()->contact;

       $data['address'] = Contact::where('contactable_type',AccountStudentDetail::class)
                                   ->where('contactable_id',$id)
                                   ->where('contact_type_id',3)
                                   ->first()->contact;
      $data['activeLink']='student';
      $data['class'] = AccountSchoolDetailClass::find($student->account_school_details_class_id)->name;
      
      $student->account_school_detail_stream_id ?   $data['stream'] = AccountSchoolDetailStream::find($student->account_school_detail_stream_id)->name : $data['stream'] = '';
      $data['current_tab'] = 'profile_detail';
      $data['streams'] = AccountSchoolDetailStream::select(['name','id'])->groupBy(['name'])->get(); 
      $data['classes'] = AccountSchoolDetailClass::select(['name','id'])->groupBy(['name'])->get();

     if(auth()->user()->student_id){
        $data['activeLink'] = 'profile_detail';
      }
       return view('registration::student.profile')->with($data);
   }

  
   public function contactPeople($id){
    
    $data['student'] = $student = AccountStudentDetail::find($id);
    $data['school'] = AccountSchoolDetail::first();
   $data['email'] = Contact::where('contactable_type',AccountStudentDetail::class)
                               ->where('contactable_id',$id)
                               ->where('contact_type_id',2)
                               ->first()->contact;
   $data['phone'] = Contact::where('contactable_type',AccountStudentDetail::class)
                               ->where('contactable_id',$id)
                               ->where('contact_type_id',1)
                               ->first()->contact;

   $data['address'] = Contact::where('contactable_type',AccountStudentDetail::class)
                               ->where('contactable_id',$id)
                               ->where('contact_type_id',3)
                               ->first()->contact;
  $data['activeLink']='student';
  $data['class'] = AccountSchoolDetailClass::find($student->account_school_details_class_id)->name;
  $student->account_school_detail_stream_id ?   $data['stream'] = AccountSchoolDetailStream::find($student->account_school_detail_stream_id)->name : $data['stream'] = '';
  $data['current_tab'] = 'contact_people';
  $data['streams'] = AccountSchoolDetailStream::select(['name','id'])->groupBy(['name'])->get(); 
  $data['classes'] = AccountSchoolDetailClass::select(['name','id'])->groupBy(['name'])->get();

    return view('registration::student.contact_people')->with($data);

   }



   public function contactPeopleStore(Request $request){


    try {
      

        if($request->relationship == 'FATHER'){

            $father = ContactPerson::updateOrCreate(
                [
                    'id'=>$request->father_id
                ],
                [
                'full_name'=>$request->father_name,
                'occupation'=>$request->father_occupation,
                'relationship'=>'FATHER',
                'personable_type' => AccountStudentDetail::class,
                'personable_id' => $request->student_id,
    
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
         if($request->relationship == 'MOTHER'){
    
            $mother = ContactPerson::updateOrCreate(
                [
                    'id'=>$request->mother_id
                ],
                [
                'full_name'=>$request->mother_name,
                'occupation'=>$request->mother_occupation,
                'relationship'=>'MOTHER',
                'personable_type' => AccountStudentDetail::class,
                'personable_id' => $request->student_id,
    
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
    
        if($request->relationship == 'GUARDIAN'){
    
            $guardian = ContactPerson::updateOrCreate(
    
                [
                    'id'=>$request->guardian_id
                ],
                
                [
                'full_name'=>$request->guardian_name,
                'occupation'=>$request->guardian_occupation,
                'relationship'=>'GUARDIAN',
                'personable_type' => AccountStudentDetail::class,
                'personable_id' => $request->student_id,
    
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
    
        if($request->relationship){
            $data = ['state'=> 'DONE', 'msg'=> 'record successfully created', 'title' => 'success'];
            return response($data);
        }
    
        $data = ['state'=> 'FAIL', 'msg'=> 'record not created', 'title' => 'info'];
            return response($data);

    } catch (QueryException $e) {

        $data = ['status'=> 'ERROR', 'msg'=> 'record successfully created', 'title' => 'error'];
        return response($data);
    }

   }


     
   public function studentAttachment($id){
    
   $data['student'] = $student = AccountStudentDetail::find($id);
    $data['school'] = AccountSchoolDetail::first();
   $data['email'] = Contact::where('contactable_type',AccountStudentDetail::class)
                               ->where('contactable_id',$id)
                               ->where('contact_type_id',2)
                               ->first()->contact;
   $data['phone'] = Contact::where('contactable_type',AccountStudentDetail::class)
                               ->where('contactable_id',$id)
                               ->where('contact_type_id',1)
                               ->first()->contact;

   $data['address'] = Contact::where('contactable_type',AccountStudentDetail::class)
                               ->where('contactable_id',$id)
                               ->where('contact_type_id',3)
                               ->first()->contact;
  $data['activeLink']='student';
  $data['class'] = AccountSchoolDetailClass::find($student->account_school_details_class_id)->name;
  $student->account_school_detail_stream_id ?   $data['stream'] = AccountSchoolDetailStream::find($student->account_school_detail_stream_id)->name : $data['stream'] = '';
  $data['current_tab'] = 'attachments';
  $data['streams'] = AccountSchoolDetailStream::select(['name','id'])->groupBy(['name'])->get(); 
  $data['classes'] = AccountSchoolDetailClass::select(['name','id'])->groupBy(['name'])->get();

    return view('registration::student.attachments')->with($data);

   }


   public function studentInvoiceList($id){

    $data['student'] = $student = AccountStudentDetail::find($id);
    $data['school'] = AccountSchoolDetail::first();
   $data['email'] = Contact::where('contactable_type',AccountStudentDetail::class)
                               ->where('contactable_id',$id)
                               ->where('contact_type_id',2)
                               ->first()->contact;
   $data['phone'] = Contact::where('contactable_type',AccountStudentDetail::class)
                               ->where('contactable_id',$id)
                               ->where('contact_type_id',1)
                               ->first()->contact;

   $data['address'] = Contact::where('contactable_type',AccountStudentDetail::class)
                               ->where('contactable_id',$id)
                               ->where('contact_type_id',3)
                               ->first()->contact;
  $data['activeLink']='student';
  $data['class'] = AccountSchoolDetailClass::find($student->account_school_details_class_id)->name;
  $student->account_school_detail_stream_id ?   $data['stream'] = AccountSchoolDetailStream::find($student->account_school_detail_stream_id)->name : $data['stream'] = '';
  $data['current_tab'] = 'invoice_list';
  $data['streams'] = AccountSchoolDetailStream::select(['name','id'])->groupBy(['name'])->get(); 
  $data['classes'] = AccountSchoolDetailClass::select(['name','id'])->groupBy(['name'])->get();

    return view('registration::student.invoice_list')->with($data);



   }



   public function studentUpdateStatus(Request $request)
   {


       try {
        // return $request->status;
        DB::beginTransaction();
           $student = AccountStudentDetail::find($request->student_id);
           $student->status = $request->status;
           $update = $student->save();
           DB::commit();

           if($update){
               $data = ['state'=>'DONE', 'msg'=>'status updated', 'title'=>'success'];
               return response($data);
           }

           $data = ['state'=>'FAIL', 'msg'=>'Status update failed', 'title'=>'Fail'];
           return response($data);


       }
       catch(\Exception $e){
           DB::rollback();
           $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
           $data = ['state'=>'ERROR', 'msg'=>$message, 'title'=>'Error'];
           return response($data);
       }


   }


   public function editContactPeople($id , Request $request){
    
               $guardian =  $data['guardian'] = AccountStudentDetail::join('contact_people', 'account_student_details.id', '=', 'contact_people.personable_id')
                ->join('contacts', 'contact_people.id', '=', 'contacts.contactable_id')
                ->select('contact_people.*', 'contacts.contact','contact_people.full_name as guardian_name','contacts.id as cnct_id', 'contacts.contact_type_id')
                ->where('account_student_details.id', $id)
                ->where('contactable_type', ContactPerson::class)
                ->where('contacts.contact_type_id', 1)
                ->where('contact_people.relationship', 'GUARDIAN')
                ->where('contacts.contactable_id',$request->contact_person_id)
                ->first();
    
               $mother = $data['mother'] = AccountStudentDetail::join('contact_people', 'account_student_details.id', '=', 'contact_people.personable_id')
                ->join('contacts', 'contact_people.id', '=', 'contacts.contactable_id')
                ->select('contact_people.*', 'contacts.contact','contact_people.full_name as mother_name','contacts.id as cnct_id')
                ->where('account_student_details.id', $id)
                ->where('contactable_type', ContactPerson::class)
                ->where('contact_type_id', 1)
                ->where('contact_people.relationship', 'MOTHER')
                ->where('contacts.contactable_id',$request->contact_person_id)
                ->first();
    
               $father =  $data['father'] = AccountStudentDetail::join('contact_people', 'account_student_details.id', '=', 'contact_people.personable_id')
                ->join('contacts', 'contact_people.id', '=', 'contacts.contactable_id')
                ->select('contact_people.*','contact_people.full_name as father_name', 'contacts.contact','contacts.id as cnct_id')
                ->where('account_student_details.id', $id)
                ->where('contactable_type', ContactPerson::class)
                ->where('contact_type_id', 1)
                ->where('contact_people.relationship', 'FATHER')
                ->where('contacts.contactable_id',$request->contact_person_id)
                ->first();


                return response($data);

   }



public function contactPeopleDestroy(Request $request, $id){
    try {
        // return $id;
        $contact =  Contact::where('contactable_id', $id)->where('contactable_type', ContactPerson::class)->delete();
        $contact_person =   ContactPerson::where('personable_id', $request->student_id)->where('id',$id)->delete();
        if ($contact && $contact_person) {
            $data = ['state'=>'DONE', 'msg'=> 'Record Deleted Successfully', 'title'=> 'success'];
            return response($data);
        }
        $data = ['state'=>'FAIL', 'msg'=> 'Record not deleted', 'title'=> 'info'];
        return response($data);
    } catch (QueryException $e) {
        $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
        return  response($data);
    }
}







  
}
