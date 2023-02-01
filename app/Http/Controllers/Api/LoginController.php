<?php

namespace App\Http\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;

class LoginController extends Controller
{
    

public function login(Request  $request){

    try {
        
        $username = $request->username;
        $password = bcrypt($request->password);

        return $password;
    
       $user = User::where('username',$username)->where('password',$password)->first();
       if($user){
        $data = ['succes'=>true];
        return response()->json($data,200);
       }
       $data = ['succes'=>false];
       return response()->json($data);

    } catch (QueryException $e) {


        return response()->json($e);
        
    }


}



}