<?php

namespace Modules\Configuration\Http\Controllers;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data['activeLink'] = 'users';
        $data['roles'] = Role::all();
        return view('configuration::users.index')->with($data);

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function datatable(Request $req )

    {
        //  return $req->role_id;
        
       $users = User::join('model_has_roles','users.id','=','model_has_roles.model_id')
        ->join('roles','roles.id','=','model_has_roles.role_id')
        ->select('users.id as user_id','users.name','users.username','users.phone','users.email');

        if($req->role_id){

          $users = $users->where('roles.id',$req->role_id);

        }

        return DataTables::of($users) 
        ->addIndexColumn()

        ->addColumn('photo',  function($user){
            $url= asset('storage/user_passports/'.$user->passport);
            return '<img src="'.$url.'" height="45" width:"45" style="border-radius:50%;
            display: table;" >';
        })

        ->addColumn('created_by',function($user){    
            return auth()->user()->name;
        })
        ->addColumn('action', function($user){
          $button = '';
                    //  $button .= '  <a href="'.route('configuration.users.profile',[$user->id]).'" class="button-icon button btn btn-sm rounded-small btn-warning  more-details-1"><i class="fa fa-eye m-0"></i> </a>';
                     $button .= ' <a href="'.route('configuration.users.create',[$user->user_id]).'" data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  editBtn" ><i class="fa fa-edit  m-0"></i></a>';
                     $button .= ' <a href="javascript:void(0)" data-original-title="Delete" data-user_dlt_id="'.$user->user_id.'"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  usrDltBtn"><i class="fa fa-trash  m-0"></i></a>';
               
          return '<nobr>'.$button. '</nobr>';
          })
      ->rawColumns(['action','photo'])
      ->make();
        


    }


  

    public function profile($id){

        return view('configuration::users.profile');

    }


    public function delete($id){
        try {
            
          $user =   User::find($id);

          if($user){
  
              $user->delete();
  
             $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record deleted successful'];
  
             return response($data);
  
          }
  
          $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be deleted'];
            return  response()->json($data);

        } catch (QueryException $e) {

          $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
          return  response()->json($data); 
        }

    }


  

    public function create($id=NULL){
   
        if($id){  
           $data['user'] = User::find($id);
        }
        else{
            $data['user'] = new  User();
        }
       $data['user_types'] = $users =  DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.user_types');
    //   foreach ($users as $key => $user) {
    //     return $user->id;
    //   }
         $data['activeLink'] = 'users';
         $data['id'] = $id;
        return view('configuration::users.create')->with($data);


    }

    public function store(Request $request){

         try {
             
            if ($request->hasfile('photo')) {

                $avatar_name= $request->file('photo')->getClientOriginalName();
                $path = $request->file('photo')->storeAs('user_passports', $avatar_name, 'public');

            }
            else{
                if($request->gender == 'male'){
                    $avatar_name = 'avatar-woman.png';
                }
                else{
                    $avatar_name = 'man_avatar.png';
                }
            }

                DB::beginTransaction();

               $user = User::updateOrCreate(
                   [
                    'id'=>$request->user_id
                   ],
      
                    [
                        'name'=>$request->full_name,
                        'email'=>$request->email,
                        'phone'=>$request->phone,
                        'address'=>$request->address,
                        'username'=>$request->username,
                        'gender'=>$request->gender,
                        'user_type'=>$request->user_type,
                        'password'=> bcrypt($request->password),
                        'passport'=>$avatar_name,
                        'created_by'=> auth()->user()->id 

                    ]   
                
                );
                $user->assignRole($request->user_type);
    
                DB::commit();
    
    
                if($user){
    
                     $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record created successful'];
                    return  response($data);
    
                }
    
                $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
                return  response($data);
    
         } catch (QueryException $e) {


            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            return  response($data);


         }



        
    }




    public function myProfileUpdate(Request $request){

        try {
            
           if ($request->hasfile('photo')) {

               $avatar_name= $request->file('photo')->getClientOriginalName();
               $path = $request->file('photo')->storeAs('user_passports', $avatar_name, 'public');

           }
           elseif (auth()->user()->id) {
            # code...
            $avatar_name = User::find(auth()->user()->id)->passport;
            }
           else{
               if($request->gender == 'male'){
                   $avatar_name = 'avatar-woman.png';
               }
               else{
                   $avatar_name = 'man_avatar.png';
               }
           }

               DB::beginTransaction();

               $data =   [
                'name'=>$request->full_name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'address'=>$request->address,
                'username'=>$request->username,
                'gender'=>$request->gender,
                'passport'=>$avatar_name,
                'created_by'=> auth()->user()->id 
                        ];

              $user = User::find(auth()->user()->id)->update($data);
               DB::commit();
   
               if($user){
   
                    $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record updated successful'];
                    session()->flash('success','Record updated successful');
                   return  response($data);
   
               }
   
               $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be updated'];
               return  response($data);
   
        } catch (QueryException $e) {

           $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
           return  response($data);


        }



       
   }

 

}
