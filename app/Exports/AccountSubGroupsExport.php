<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AccountSubGroupsExport implements FromView,ShouldAutoSize
{
    public function view(): View
    {
        return view('accounts::sub_groups.printouts.excel', [

            'sub_groups' => $sub_groups = DB::select('SELECT account_sub_groups.id as sub_group_id,account_sub_groups.name as sub_group_name ,'.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups.name as group_name FROM account_sub_groups JOIN '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups ON account_sub_groups.account_group_id = '.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups.id')
   
        ]
        
    );
    }

}
