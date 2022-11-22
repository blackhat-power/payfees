<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttachmentsController extends Controller
{
    public function store(Request $request){
/* 
        $request->validate([
            'image.*' => 'mimes:jpeg,png,jpg,gif,svg',
        ]); */

        if($request->hasfile('profile_pic')){
            $avatar_name= $request->file('profile_pic')->getClientOriginalName();
            $path = $request->file('profile_pic')->storeAs('student_profile_pics',$avatar_name, 'public');

            AccountStudentDetail::where('id',$id)->update(['profile_pic'=>$avatar_name ]);

         }
        

    }
}
