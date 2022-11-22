@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Users</a></li>
              </ol>
          </nav>
  
@endsection 

@section('content-body')
<div class="container-fluid">
<div class="card">
    <div class="card-body">
        <form action="" id="users_form">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">User Type</label>
                            <select name="user_type" id="user_type" class="form-control form-control-sm">
                                <option value=""></option>
                                @foreach ($user_types as $user_type)
                                <option value="{{ $user_type->id }}" {{$user->user_type == $user_type->id ? 'selected' : '' }}>{{ $user_type->name }}</option>
                                @endforeach

                            </select>

                        </div>

                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Full Name</label>
                            <input type="text" name="full_name" value="{{ $user->name }}"  id="full_name" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Address</label>
                            <input type="text" name="address" value="{{ $user->address }}" id="address" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Email Address</label>
                            <input type="text" name="email" id="email" value="{{  $user->email  }}" class="form-control form-control-sm">
                        </div>
                    </div>
     
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" id="username" value="{{ $user->username }}"  class="form-control form-control-sm">
                            <input type="hidden" id="user_id" name="user_id" value="{{$user->id}}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {{-- <i class="fa fa-eye"></i> --}}
                            {{-- <input type="text" name="password" id="password" class="form-control form-control-sm"> --}}
                                <label>Password</label>
                                <div class="input-group" id="show_hide_password">
                                  <input class="form-control form-control-sm" type="password" id="password" name="password">
                                  <div class="input-group-addon" style=" border-radius:5px; border:1px solid brown; background-color: #fafbfe;">
                                    <a href="javascript:void(0)" id="toggle-eye"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                  </div>
                                </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Phone</label>
                            <input type="text" name="phone" id="phone" value="{{ $user->phone }}" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Gender</label>
                            <select name="gender" id="gender" class="form-control form-control-sm"> 
                                <option value="Male" {{ $user->gender == 'male' ? 'selected' : '' }} >Male</option>
                                <option value="Female" {{ $user->gender == 'female' ? 'selected' : '' }} >Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Upload Passport</label>
                            <input type="file" accept="image/*" name="photo">
                        </div>
                    </div>

                </div>
            </div>

            </div> 
       
            <div class="row">
                <div class="col-md-10"></div>
                <div class="form-group">
                    <button type="submit" id="submit_user" class="float-right btn btn-primary btn-sm"><i class="fa fa-paper-plane"></i> SUbmit</button>
                </div>
            </div>

        </form>

        </div>

    </div>

</div>
</div>

@endsection



@section('scripts')


$('#toggle-eye').click(function(e){

        e.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }

});


$('#user_type').select2({width:'100%'});
$('#gender').select2({width:'100%'});

$("form#users_form").submit(function(e) {
    e.preventDefault();    
    var formData = new FormData(this);

    $.ajax({
        url: '{{ route('configuration.users.store') }}',
        type: 'POST',
        enctype: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,

        data: formData,
        success: function (response) {
            console.log(response)
            if(response.state == 'Done'){

                console.log(response);
                toastr.success(response.msg, response.title);
                window.location.replace('{{ route('configuration.users.index') }}'); 


            }
    
            else if(response.state == 'Fail'){
                toastr.warning(response.msg, response.title)
    
            }
            else if(response.state == 'Error'){
                toastr.error(response.msg, response.title);
            }
    
        },
        error: function(response){
            
            toastr.error(response.msg, response.title);
            
        }
    });
});




@endsection
