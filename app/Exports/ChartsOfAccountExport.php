<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ChartsOfAccountExport implements FromView,ShouldAutoSize
{
    public function view(): View
    {
        return view('accounts::chartsOfAccounts.printouts.excel', [
            'chart_of_accounts' => $chart_of_accounts = DB::select('SELECT * FROM '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups join chart_of_accounts ON '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups.id = chart_of_accounts.account_group_id')
   
        ]
        
    );
    }

}
