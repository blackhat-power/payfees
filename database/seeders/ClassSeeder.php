<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('account_school_detail_classes')->insert(
            [
                'name'=>'form 1',
                'symbol'=>'F1',
                'streams'=>'A',
                'short_form'=>'FM1',
                'account_school_details_id'=>1
            
            ], 
            

    );
    }
}
