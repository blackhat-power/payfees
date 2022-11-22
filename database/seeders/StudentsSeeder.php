<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('account_student_details')->insert(
           [
            'account_id'=>2,
            'account_school_details_id'=>1,
            'first_name'=>'steve',
            'middle_name'=>'jackson',
            'last_name'=>'wonder',
            'dob'=>'1998-02-04',
            'gender'=>'male',
            'account_school_details_class_id'=>2
           ],
           [
            'account_id'=>3,
            'account_school_details_id'=>1,
            'first_name'=>'tarick',
            'middle_name'=>'hussen',
            'last_name'=>'abdul',
            'dob'=>'2022-01-24',
            'gender'=>'male',
            'account_school_details_class_id'=>'1'
           ]

    );

    }
}
