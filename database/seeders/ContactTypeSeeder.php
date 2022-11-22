<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contact_types')->insert(
            [
            'name' => 'phone',
            'description' => '',
            
            ],
           [
            'name' => 'email',
            'description' => '',
           ],
           [
            'name' => 'address',
            'description' => '',
           ]  

    );
    }
}
