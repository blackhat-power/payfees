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
use Modules\Configuration\Entities\Stream;
use Modules\Registration\Entities\AccountStudentDetail;
use Modules\Registration\Entities\Promotion;

class StudentPromotionsController extends Controller
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



    public function promotion($fc = NULL, $tc = NULL, $fs = NULL, $ts = NULL)
    {
        try {

        DB::beginTransaction();

        $data['activeLink'] = 'promote_student';
        $old_year =  AccountSchoolDetail::first()->current_session;
        // $old_year_explode = explode('-',$old_year);
        $data['old_year'] = $old_year;
        // $data['new_year'] =  ++$old_year_explode[0] .'-'.++$old_year_explode[1];
        $data['new_year'] =  ++$old_year;
        $data['classes'] = $classes =  $this->my_class::all();

        $data['fc'] = '';
        $data['fs'] = '';
        $data['tc'] = '';  
        $data['ts'] = '';
       
        $data['streams'] =  DB::select('select * from account_school_detail_streams');
        // return $ts;
        $data['checked'] = false;

        if($fc && $tc){
            // return $fc;
            $data['checked'] = true;
            $data['fc'] = $fc;
            $data['fs'] = $fs;
            $data['tc'] = $tc;  
            $data['ts'] = $ts;
            $data['to_class'] = $this->my_class::find($tc);
            $data['from_class'] = $this->my_class::find($fc);
            $ts ? $data['to_stream'] = AccountSchoolDetailStream::find($ts) : $data['to_stream'] = '';
            $fs ? $data['from_stream'] = AccountSchoolDetailStream::find($fs) :  $data['from_stream'] = '';
           
            $sts = $students = AccountStudentDetail::where('account_school_details_class_id',$fc)
            ->where('grad',0);
            if($fs){
                $sts->where('account_school_detail_stream_id',$fs);
            }
            $data['students'] =  $sts->get()->sortBy('account_student_details.name');

            if($sts->count() < 1){
                session()->flash('info','No students to promote');
                return redirect()->back();
            }

        }
            DB::commit();

            return view('registration::student.promotions.index')->with($data);

            } catch (QueryException $e) {
               return $e->getMessage();
            }

    }
            /* CLASS TO STREAM  FILTER */

    public function fromClassFilter(Request $request){

        /* return */ $request->all();
       $streams = AccountSchoolDetailClass::find($request->class_id)->streams;
       $html = '<option>  </option>';
       foreach ($streams as $stream){
           $html .= '<option  value = "'.$stream->id.'"> '.$stream->name.' </option>';
       }

       return $html;

    }




    public function toClassFilter(Request $request){

        $streams = AccountSchoolDetailClass::find($request->class_id)->streams;
        $html = '<option>  </option>';
        foreach ($streams as $stream){
            $html .= '<option  value = "'.$stream->id.'"> '.$stream->name.' </option>';
        }
 
        return $html;
 
    }


    public function getPromotionList( Request $request){
        //   return $request->all();
        $fc = $request->from_class_promo;
          $fs = $request->from_stream_promo;
          $tc = $request->to_class_promo;
          $ts = $request->to_stream_promo;

          return redirect()->route('students.promotion', [$fc,$tc,$fs,$ts]);

    }

    
    public function promote(Request $request,$fc,$tc,$fs=null,$ts=null)
    {
        // return $request->all();
        try {           
        $old_year = AccountSchoolDetail::first()->current_session;
        // $old_year_explode = explode('-',$old_year);
        $data['old_year'] = $old_year;
        // $data['new_year'] = $new_session =  ++$old_year_explode[0] .'-'.++$old_year_explode[1];
        $data['new_year'] = $new_session = $old_year + 1;
        DB::beginTransaction();

        // $students = $this->student->getRecord(['account_school_details_class_id' => $fc, 'account_school_detail_stream_id' => $fs, 'session' => '2021-2022' ])->get()->sortBy('account_student_details.name');
         $students = $sts = $students = AccountStudentDetail::where('account_school_details_class_id',$fc)->where('grad',0);
         if($fs){
            $students->where('account_school_detail_stream_id',$fs);
         }
        $students = $students->get();

        if($students->count() < 1){

            return redirect()->route('students.promotion');
        }

        foreach($students as $student){
          $p = 'p-'.$student->id;
          $p = $request->$p;
            if($p === 'P'){ // Promote
                $data['account_school_details_class_id'] = $tc;
                $data['account_school_detail_stream_id'] = $ts;
                $data['session'] = $new_session;
            }
            if($p === 'D'){ // Don't Promote
                $data['account_school_details_class_id'] = $fc;
                $data['account_school_detail_stream_id'] = $fs;
                $data['session'] = $old_year;
            }
         /*    if($p === 'G'){ // Graduated
                $data['account_school_details_class_id'] = $fc;
                $data['account_school_detail_stream_id'] = $fs;
                $data['grad'] = 1;
                $data['graduation_date'] = '2020-2021';
            } */

            // $this->student->updateRecord($student->id, $data);
           $student_update = AccountStudentDetail::find($student->id)->update($data);

//            Insert New Promotion Data
            $promote['from_class'] = $fc;
            $promote['from_stream'] = $fs;
            $promote['grad'] = ($p === 'G') ? 1 : 0;
            $promote['to_class'] = in_array($p, ['D', 'G']) ? $fc : $tc;
            $promote['to_stream'] = in_array($p, ['D', 'G']) ? $fs : $ts;
            $promote['student_id'] = $student->id;
            $promote['from_session'] = $old_year;
            $promote['to_session'] = $new_session;
            $promote['status'] = $p;

           $promotion = Promotion::create($promote);

            DB::commit();
        }
        if($promotion){
            session()->flash('success', 'selected students promoted');
        }
        else{
            session()->flash('error', 'selected students not promoted');
        }
       
        return route('students.promotion');

    } catch (QueryException $e) {
        session()->flash('error','Something went wrong!<br />' . $e->errorInfo[2]);
        // return route('students.promotion');
        return $e->getMessage();

    }
    }


    public function manage()
    {
        // return 'menn';
        /* create a next year function  && old_year too  */
        $old_year = AccountSchoolDetail::first()->current_session;
        // $old_year_explode = explode('-',$old_year);
        $data['old_year'] = $old_year;
        $data['new_year'] = $new_session =  $old_year +1;

       $data['promotions'] = AccountStudentDetail::with(['promotions','promotions.fc', 'promotions.tc', 'promotions.fs', 'promotions.ts'])
                                                    ->whereHas('promotions', function($query) use($old_year,$new_session) {
                                                         $query->orWhere(['from_session'=>$old_year,'to_session'=>$new_session]);
                                                    })
                                                        
                                                    ->get();
        $data['old_year'] = $old_year;
        $data['new_year'] = $new_session;
        $data['activeLink'] = 'manage_promotion';

        return view('registration::student.promotions.reset')->with($data);

    }

    public function reset($promotion_id)
    {
        try { 

    //    return $this->student->findPromotion($promotion_id)->student_id;
       $reset =  $this->reset_single($promotion_id);
       if($reset){
        session()->flash('success','promotion was reset successfullly');
        return redirect()->back();
       }

        } catch (QueryException $e) {

            return $e->getMessage();

        }

    }

    public function reset_all()
    {
        try {

            $old_year = AccountSchoolDetail::first()->current_session;
            // $old_year_explode = explode('-',$old_year);
            $data['old_year'] = $old_year;
            $data['new_year'] = $new_session =  $old_year + 1;
            
            $next_session = $new_session;
            $where = ['from_session' => $old_year, 'to_session' => $next_session];
            $promotions = $this->student->getPromotions($where);
    
            if ($promotions->count()){
              foreach ($promotions as $prom){
                  $this->reset_single($prom->id);
    
              }
            }

            // session()->flash('success', 'all promotions were reset');
            $data = ['state'=>'Done','msg'=>'All promotions were reset','title'=>'success'];
            return response($data);

        } catch (QueryException $e) {

            session()->flash('error', 'Something went wrong!<br />' . $e->errorInfo[2]);
            return redirect()->back();
        }
      

        
    }


    protected function reset_single($promotion_id)
    {
        
        $prom = $this->student->findPromotion($promotion_id);
        
        $data['account_school_details_class_id'] = $prom->from_class;
        $prom->from_stream ? $data['account_school_detail_stream_id'] = $prom->from_stream : $data['account_school_detail_stream_id'] = null;
        $data['session'] = $prom->from_session;
        $data['grad'] = 0;
        $data['graduation_date'] = null;

       $student = AccountStudentDetail::where('id',$prom->student_id)->update($data);
        // $this->student->update(['account_student_details.id' => $prom->student_id], $data);
        if($student){
            return $this->student->deletePromotion($promotion_id);
        }
        
    }

}
