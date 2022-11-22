<?php


namespace App\Exports;

use App\Models\Contact;
use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Modules\Registration\Entities\AccountStudentDetail;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InvoiceExport implements FromView,ShouldAutoSize
{
    public function view(): View
    {
        return view('accounts::printouts.invoice_list_excel', [
            'invoices' => $invoices = Invoice::select('invoices.*')
            ->join('accounts','invoices.account_id','=','accounts.id')
            ->join('account_student_details','accounts.id','=','account_student_details.account_id')->get()
   
        ]
        
    );
    }

}
