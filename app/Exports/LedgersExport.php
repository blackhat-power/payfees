<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LedgersExport implements FromView,ShouldAutoSize
{
    public function view(): View
    {
        return view('accounts::account_ledger.printouts.excel', [
            'ledgers' => $ledgers = DB::select('SELECT ledgers.name as ledger_name,ledgers.transaction_type, ledgers.id as ledger_id,  ledgers.opening_balance, account_sub_groups.name as sub_group_name,  '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups.name as group_name FROM ledgers JOIN account_sub_groups ON ledgers.sub_group_id = account_sub_groups.id JOIN '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups ON account_sub_groups.account_group_id = '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups.id  ')
   
        ]
        
    );
    }

}
