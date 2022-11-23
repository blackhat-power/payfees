<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Modules\Configuration\Entities\AccountSchoolDetailClass;
use Modules\Registration\Entities\AccountStudentDetail;
use Spatie\Permission\Contracts\Role;
use App\Helpers\Helper;

class DashboardController extends Controller
{
    public function index(){

        $data['activeLink'] = 'dashboard';
    
         
        if( auth()->user()->getRoleNames()[0] == 'student' ){
           
            $data['activeLink'] = 'students_dashboard';
            return view('dashboard.students_dashboard')->with($data);
        }

        if( auth()->user()->getRoleNames()[0] == 'admin'){

           $data['classes'] = AccountSchoolDetailClass::all();
           $data['debtors_list'] = Helper::debtors_list_count();
           $data['pending_approval'] = Helper::pendingPaymentsApproval();
           $data['students'] = AccountStudentDetail::all()->count();
            return view('dashboard')->with($data);   

        }


       $data['activeLink'] = 'super_admin_dashboard';
       $data['schools'] = DB::table('payfees_landlord.tenants')->where('payfees_landlord.tenants.database','!=','payfees_landlord')->get();
       $data['school_count'] = DB::table('payfees_landlord.tenants')->where('payfees_landlord.tenants.database','!=','payfees_landlord')->count();

        return view('dashboard.super_admin_dashboard')->with($data);


    }


    public function studentDashboard(){
        
        $data['activeLink'] = 'students_dashboard';
        return view('dashboard.students_dashboard')->with($data);
    }


    public function getStudentsData(){

       $classes = AccountSchoolDetailClass::all();
       foreach ($classes as $key => $class) {

        $male_students = AccountStudentDetail::where('account_school_details_class_id',$class->id)->where('account_student_details.gender','male')->count();
        $female_students = AccountStudentDetail::where('account_school_details_class_id',$class->id)->where('account_student_details.gender','female')->count();
        $data[] = ['class_id'=>$class->id,'class_name'=>$class->name,'male'=>$male_students, 'female'=>$female_students];
        

       }

        return response($data);
            
    }


    public function getStudentsAccountData(){
        $classes = AccountSchoolDetailClass::all();
        foreach ($classes as $key => $class) {
            $bill_per_class = 0;
            $paid_amount_per_class = 0;
            $billed_amount = 0;
            $paid_amount = 0;
           
          $students_per_class = AccountStudentDetail::where('account_school_details_class_id',$class->id)->get();
        if($students_per_class == '[]'){
            $student_accounts_per_class_ratio[] =  ['class_id'=>$class->id,'class_name'=>$class->name,'billed_amount'=>0, 'amount_paid'=>0, 'balance'=> 0 ];
        }
        else {

            foreach ($students_per_class as $key => $student) {
          
                $account_id = $student->account_id;
                $invoices = Invoice::where('account_id',$account_id)->get();
                foreach($invoices as $invoice){
                    if($invoice->invoiceItems()){
                        $billed_amount = $invoice->invoiceItems()->sum('rate');
                        $paid_amount = $invoice->receiptItems()->sum('rate');
                    }
                   
                }
                $bill_per_class += $billed_amount; 
                $paid_amount_per_class += $paid_amount;
                $balance = $bill_per_class - $paid_amount_per_class;
                $balance == 0 ? $per_class_balance = 0 : $per_class_balance = - ($balance);
    
              }
              $student_accounts_per_class_ratio[] =  ['class_id'=>$class->id,'class_name'=>$class->name,'billed_amount'=>$bill_per_class, 'amount_paid'=>$paid_amount_per_class, 'balance'=> $per_class_balance ];
              
    
            }
        }

       


        return response($student_accounts_per_class_ratio);


    }

}
