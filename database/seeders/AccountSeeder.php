<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert(
            [
                'name'=>'first account',
                'status'=>'inactive',
                'user_id'=>1,
                'type_id'=>1,
            ],

            [
                'name'=>1,
                'status'=>'second account',
                'user_id'=>1,
                'type_id'=>1,
            ],
                
    
                );
           
    }
}
