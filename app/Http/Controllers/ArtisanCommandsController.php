<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ArtisanCommandsController extends Controller
{
    public function run(){

        Artisan::call('storage:link');

    }
    
      public function clearView(){
        
        Artisan::call('view:clear');

    }
    
    public function clearCache(){
       Artisan::call('optimize:clear'); 
    }

    public function createModel($model){

        Artisan::call('make:model '.$model.' -m');

    }

    public function createController($controller,$module=null){
        if($module){

            Artisan::call('module:make-controller '.$controller.' '.$module.' ');

        }else{

            Artisan::call('make:controller '.$controller.'');
            
        }

        

    }
}
