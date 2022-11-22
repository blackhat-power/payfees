<?php

namespace Modules\Registration\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Modules\Configuration\Entities\AccountSchoolDetailClass;
use Modules\Configuration\Entities\AccountSchoolDetailStream;
use Modules\Registration\Entities\AccountStudentDetail;

class GraduateStudentsMakeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    protected $my_class, $student;

    public function __construct(AccountSchoolDetailClass $my_class, AccountStudentDetail $student)
    {
        $this->my_class = $my_class;
        $this->student = $student; 
    }



    public function index($fc = NULL, $fs = NULL)
    {
        try {
      
            DB::beginTransaction();
    
            $data['activeLink'] = 'promote_student';
            $old_year =  AccountSchoolDetail::first()->current_session;
            // $old_year_explode = explode('-',$old_year);
            $data['old_year'] = $old_year;
            // $data['new_year'] =  ++$old_year_explode[0] .'-'.++$old_year_explode[1];
            $data['new_year'] =  $old_year + 1;
            $data['classes'] = $classes =  $this->my_class::all();
    
            $data['fc'] = '';
            $data['fs'] = '';
           
            // $data['streams'] =  DB::select('select * from payfeetz_landlord.streams');
            // return $ts;
            $data['selected'] = false;
            if($fc){
                $data['selected'] = true;
                $data['fc'] = $fc;
                $data['from_class'] = $this->my_class::find($fc);
               $fs ? $data['from_stream'] = AccountSchoolDetailStream::find($fs) : $data['from_stream'] = null;

                 $students = AccountStudentDetail::where('account_school_details_class_id',$fc)
                ->where('grad',0);

                    if($fs){
                        $data['fs'] = $fs;
                        $students->where('account_school_detail_stream_id',$fs);
                    }

                  $data['students'] = $sts = $students->get()->sortBy('account_student_details.name');
                
                if($sts->count() < 1){
                    session()->flash('info','No students to Graduate');
                    return redirect()->back();
                }
    
            }
                DB::commit();
                } catch (QueryException $e) {
                    $e->getMessage();
                }
    
            return view('registration::student.promotions.graduate')->with($data);
    }

    public function getGraduandsList( Request $request){
        //   return $request->all();
        $fc = $request->from_class_promo;
        $fs = $request->from_stream_promo;

        return redirect()->route('students.graduate.index', [$fc, $fs]);

    }

        
    public function graduate(Request $request, $fc, $fs)
    {
        try {
           
        $old_year = DB::select('select * from account_school_details')[0]->current_session;
        // $old_year_explode = explode('-',$old_year);
        $data['old_year'] = $old_year;
        $data['new_year']  = $old_year + 1;
        DB::beginTransaction();

        // $students = $this->student->getRecord(['account_school_details_class_id' => $fc, 'account_school_detail_stream_id' => $fs, 'session' => '2021-2022' ])->get()->sortBy('account_student_details.name');
          $students = AccountStudentDetail::where('account_school_details_class_id',$fc)->where('grad',0);
         if($fs){
            $students->where('account_school_detail_stream_id',$fs);
         }
        $final_students = $students->get();


        if($final_students->count() < 1){

            return redirect()->route('students.graduate.index');
        }

        foreach($final_students as $student){
            
           $p = 'p-'.$student->id;
           $p = $request->$p;

            if($p === 'D'){ // Don't Graduate

               $data['account_school_details_class_id'] = $fc;
                if($fs){
                    $data['account_school_detail_stream_id'] = $fs;
                }
               
                $data['session'] = $old_year;
            }
             if($p === 'G'){ // Graduated
                 $data['account_school_details_class_id'] = $fc;
                if($fs){
                    $data['account_school_detail_stream_id'] = $fs;
                }
               
                $data['grad'] = 1;
                $data['graduation_date'] = $old_year;
            }

          $student_update = AccountStudentDetail::find($student->id)->update($data);

            DB::commit();
        }
         if($student_update){
            session()->flash('success', 'selected students graduated');
        }
        else{
            session()->flash('error', 'selected students not graduated');
        }
       
         return route('students.graduate.index');

    } catch (QueryException $e) {
        session()->flash('error','Something went wrong!<br />' . $e->errorInfo[2]);
        return route('students.graduate.index');
        // return $e->getMessage();

    }
    }



}
