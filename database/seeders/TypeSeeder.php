<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert(
            [
                'name' => 'nursery',
                'description' => 'Nu',
            ], 
            [
            'name' => 'primary',
            'description' => 'P',
            
            ],
           [
            'name' => 'secondary',
            'description' => 'S',
           ] 
           
    );
    }
}
