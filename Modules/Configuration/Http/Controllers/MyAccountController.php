<?php

namespace Modules\Configuration\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class MyAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data['activeLink'] = 'my_account';
        $data['activeTab'] = 'profile';
        $data['user'] = User::join(''.env('LANDLORD_DB_DATABASE').'.user_types', 'users.user_type','=', ''.env('LANDLORD_DB_DATABASE').'.user_types.id')->first();
        return view('configuration::users.my_account.index')->with($data);
    }

    public function updatePassword(Request $request){

    $validate_data = $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:6',
        'new_confirm_password' => ['same:new_password'],
      ]);
 
        $hashedPassword = auth()->user()->password;
        if (Hash::check($request->old_password , $hashedPassword)) {
            if (Hash::check($request->new_password , $hashedPassword)) {
                session()->flash('error','new password can not be the old password!');
                return redirect()->back();   
            }
            else{
                
                $users = User::find(auth()->user()->id);
                $users->password = bcrypt($request->new_password);
                $users->save();
                session()->flash('success','password updated successfully');
                return redirect()->back();
            } 
        }
        else{
            session()->flash('error','old password doesnt matched');
            return redirect()->back();
        }
    }

    public function passwordResetIndex(){

        $data['activeLink'] = 'my_account';
        $data['activeTab'] = 'password_reset';


        if(auth()->user()->student_id){

            return view('configuration::users.my_account.student_password_reset')->with($data);
        }
        return view('configuration::users.my_account.password_reset')->with($data);

    }








}



