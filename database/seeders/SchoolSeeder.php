<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_school_details')->insert(
           [
            'account_id'=>1,
            'name'=>'BAGAMOYO SECONDARY SCHOOL',
            'ownership'=>'GOVERNMENT',
            'district'=>1,
            'registration_number'=>'234XVU',
            'street'=>2,
            'type_id'=>2
           ]
       
 
     );
    }
}
