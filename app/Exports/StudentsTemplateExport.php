<?php


namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Modules\Registration\Entities\AccountStudentDetail;

class StudentsExport implements FromView
{
    public function view(): View
    {
        return view('registration::printouts::students_excel', [
            'students' => AccountStudentDetail::all()
        ]
    );
    }
}
