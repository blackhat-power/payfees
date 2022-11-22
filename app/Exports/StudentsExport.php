<?php


namespace App\Exports;

use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Modules\Registration\Entities\AccountStudentDetail;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StudentsExport implements FromView,ShouldAutoSize
{
    public function view(): View
    {
        return view('registration::printouts.students_excel', [
            'students' => AccountStudentDetail::all(),
             'school_info' => AccountSchoolDetail::first(),
             'address' =>  Contact::where('contactable_type',AccountSchoolDetail::class)
             ->where('contact_type_id',3)->first(),

             'phone' => Contact::where('contactable_type',AccountSchoolDetail::class)
             ->where('contact_type_id',1)->first(),

            'email' => Contact::where('contactable_type',AccountSchoolDetail::class)
            ->where('contact_type_id',2)->first(),
   
        ]
        
    );
    }







}
