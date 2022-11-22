<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
        [
            'account_school_details_id'=>1,
            'start_date'=>'2021-02-20',
            'end_date'=>'2022-01-9-23',
            'name'=>'first term',
        ],
            [
                'account_school_details_id'=>1,
                'start_date'=>'2021-02-20',
                'end_date'=>'2022-01-9-23',
                'name'=>'second term',
                ]

            );
       

    }
}
