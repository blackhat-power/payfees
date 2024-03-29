@extends('layouts.app')


@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Account</a></li>
              </ol>
          </nav>
  
@endsection



@section('content-body')
          <div class="card" style="width: 100%">
             <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                   <h4 class="card-title"></h4>
                </div>
             </div>

             <div class="card-body">
                @include('configuration::users.my_account.tabs')

                <div class="tab-content" id="myTabContent-1">

                    <div class="tab-pane fade active show" id="home-two" role="tabpanel" aria-labelledby="home-tab-two">
                        <div class="row">
                            <div class="col-md-8">
                                <form method="post" action="{{ route('configuration.users.password.update') }}">
                                    @csrf 
                                    @method('PUT') 
                                    <div class="form-group row">
                                        <label for="current_password" class="col-lg-3 col-form-label font-weight-semibold">Current Password <span class="text-danger">*</span></label>
                                        <div class="col-lg-9">
{{-- 
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control form-control-sm" placeholder=" enter current password" aria-label="" aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                  <span class="input-group-text" id="basic-addon2"><a href="javascript:void(0)" id="toggle-eye"><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                                                </div>
                                                @if($errors->has('old_password'))
                                                <span class="error text-danger">{{ $errors->first('old_password') }}</span>
                                                @endif
                                              </div> --}}
                                              



                                            <div class="input-group" id="show_hide_password">
                                                <input class="form-control form-control-sm" type="password" id="old_password" name="old_password">
                                                <div class="input-group-addon" style=" border-radius:5px; border:1px solid brown; background-color: #fafbfe;">
                                                  <a href="javascript:void(0)" id="toggle-eye"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                                </div>
                                                @if($errors->has('old_password'))
                                            <span class="error text-danger">{{ $errors->first('old_password') }}</span>
                                            @endif
                                              </div>
                                        </div>
                                    </div>
                    
                                    <div class="form-group row">
                                        <label for="password" class="col-lg-3 col-form-label font-weight-semibold">New Password <span class="text-danger">*</span></label>
                                        <div class="col-lg-9">
                                            <input id="password" name="new_password" required="" type="password" class="form-control form-control-sm ">
                                            @if($errors->has('new_password'))
                                            <span class="error text-danger">{{ $errors->first('new_password') }}</span>
                                            @endif
                                        </div>
                                    </div>
                    
                                    <div class="form-group row">
                                        <label for="password_confirmation" class="col-lg-3 col-form-label font-weight-semibold">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="col-lg-9">
                                            <input id="password2" name="new_confirm_password" required="" type="password" class="form-control form-control-sm ">
                                           
                                            @if($errors->has('new_confirmation_password'))
                                            <span class="error text-danger">{{ $errors->first('new_confirmation_password') }}</span>
                                            @endif
                                        </div>
                                    </div>
                    
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary btn-sm">Submit form <i class="fa fa-paper-plane ml-2"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
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

$("#password").on("focusout", function () {
    if ($(this).val() != $("#password2").val()) {
      $("#password2").removeClass("is-valid").addClass("is-invalid");
    } else {
      $("#password2").removeClass("is-invalid").addClass("is-valid");
    }
  });
  
  $("#password2").on("keyup", function () {
    if ($("#password").val() != $(this).val()) {
      $(this).removeClass("is-valid").addClass("is-invalid");
    } else {
      $(this).removeClass("is-invalid").addClass("is-valid");
    }
  });

@endsection






















