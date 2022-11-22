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
                   <div class="tab-pane fade active show" id="profile-two" role="tabpanel" aria-labelledby="profile-tab-two">
                    <div class="container-fluid" id="divReload">
                        <div class="row">
                           
                          <div class="col-md-3">
                    
                             <div class="card card-block p-card" style="border-top: 3px solid #00c0ef">
                               <div class="profile-box bg-green-400">
                        <div class="profile rounded" style="position:relative;">
                           <div class="img-display" id="dp-overlay" style="display:none">
                           
                           <form id="profile_submit" action="" method="post" enctype="multipart/form-data"> 
                                 <input type="hidden" name="_token" value="GHkBhDz7phtie5AJ0HTu7IdXH5Ko9350C9WaNBCi">
                                 
                    
                               <input onchange="upload(event)" style="display: none" type="file" name="profile_pic" id="profile_pic">  
                    
                           </form>
                             
                            <a href="javascript:void(0)"> 
                              <img id="profile_image" style="display:block; position:relative; background-color:#20202090; padding: 40px;border-radius: 50%; height: 120px; width: 120px;  top: 30%;-ms-transform: translateY(-50%);transform: translateY(-50%);margin: auto;" src="http://payfees_ronnie.bizytech.test/assets/images/profile_edit.png"> 
                            </a>  
                        </div>
                              
                        @php  $url= asset('storage/user_passports/'.auth()->user()->passport); @endphp
                              
                           <img id="profile_image_update" src="{{ $url }}" alt="profile-bg" class="avatar-120 rounded d-block mx-auto img-fluid mb-1">
                         
                          
                           <h5 class="font-60 text-center mb-1">{{  ucwords(auth()->user()->name) }}</h5>
                           <p class="text-muted  text-center"> {{  ucwords($user->name) }}  </p>
                           
                        </div>
                        <div class="pro-content rounded" id="content_update" style="margin-top: 1%;width: 100%;
                        margin-left: -21px;">
                           <div class="d-flex align-items-center mb-3">
                              <div class="p-icon mr-1 " style="width: 19% !important;
                              height: 1.5em !important;">
                                 <i class="las la-envelope-open-text"></i>
                              </div>
                              <div class="row">
                                 <div class="col-md-12">
                                    <span style="word-break: break-all; font-size:0.9em" class="mb-0">{{  auth()->user()->email }}</span>
                                 </div>
                              </div>
                              
                           </div>
                           <div class="d-flex align-items-center mb-3">
                              <div class="p-icon mr-1" style="width: 19% !important;
                              height: 1.5em !important;">
                                 <i class="las la-phone"></i>
                              </div>
                              <span style="word-break: break-all; font-size:0.9em" class="mb-0"> {{  auth()->user()->phone }} </span>
                           </div>
                           <div class="d-flex align-items-center mb-3">
                              <div class="p-icon mr-1" style="width: 19% !important;
                              height: 1.5em !important;">
                                 <i class="las la-map-marked"></i>
                              </div>
                              <span style="word-break: break-all; font-size:0.9em" class="mb-0"> {{  auth()->user()->address }}</span>
                              
                           </div>
                           <div class="d-flex justify-content-center">
                              <div class="social-ic d-inline-flex rounded">
                                 <a id="edit_my_profile" href="javascript:void(0) {{-- {{route('configuration.users.create', auth()->user()->id)}} --}}" class="btn btn-sm btn-pill btn-outline-primary"> <i class="fa fa-edit"> </i> </a> 
                              </div>
                           </div>
                        </div>
                     </div>         </div>
                          </div>   
                           <div class="col-md-9">
                              <div class="card card-block card-stretch card-height" style="border-top: 3px solid #70bab3"> 
                                 <div class="card-header">
                                    <div class="header-title">
                                      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link  active " id="profile" href="{{ route('configuration.users.myaccount') }}" role="tab">Profile</a>
                         </li>
                         <li class="nav-link"></li>
                     </ul>                </div>
                                 </div>
                                 
                                                  <div class="card-body">
                                                   
                                                    <div class="tab-content" id="pills-tabContent-2">
                                                        <div class="tab-pane show active" role="tabpanel">
                                                           <p class="text-info" style="font-size: 16px;border-bottom: 1px solid #eee;">Personal Info:</p>


                                                            {{-- TO BE CHANGED --}}
                                                           {{-- <div class="container">
                                                            <table style="border: none; width:100%; margin-bottom: 1rem; color: #535f6b;">
                                                                <tr> 
                                                                    <td> Full Name </td>
                                                                    <td> <span>: {{ $school->current_session }} </span></td> 
                                                                    <td> Registration No </td>
                                                                    <td> <span>: &nbsp;221001 </span>  </td>
                                                                </tr>
                                                                <tr> <td style="height:2rem;"></td></tr>
                                                                <tr>
                                                                    <td>Class</td>
                                                                    <td><span>: {{ ucwords($class) }}</span></td>
                                                                      <td>Stream</td>
                                                                      <td><span>: {{ $stream }} </span></td>
                                                                  </tr>
                                                                  <tr> <td style="height:2rem;"></td></tr>
                                                                  <tr>
                                                                    <td>Notification SMS No.</td>
                                                                    <td><span>:Father's Phone No. </span></td>
                                                                    
                                                                  </tr>
                                                                  <tr> <td style="height:2rem;"></td></tr>
                    
                                                                  <tr>
                                                                    <td>Username</td>
                                                                    <td><span>: jeroddy</span></td>
                                                                      <td>Status</td>
                                                                      <td>:@if ($student->status == 1)
                                                                        <span class="bg-green badge">Active</span> 
                                                                        @else
                                                                        <span class="bg-red badge">InActive</span> 
                                                                        @endif    </td>
                                                                  </tr>
                                                                  <tr> <td style="height:2rem;"></td></tr>
                                                            </table>
                                                        </div> --}}

                                                           <div class="row">
                                                               <div class="col-md-3">
                                                                   <label for="">Full Name</label>
                                                               </div>
                                                               <div class="col-md-3">
                                                                   <p for="">: {{ ucwords(auth()->user()->name) }} </p>
                                                               </div>
                                                               <div class="col-md-3">
                                                                   <label for="">Date of Birth</label>
                                                               </div>
                                                               <div class="col-md-3">
                                                                   <p for="">: </p>
                                                               </div>
                                                           </div>
                                                               <div class="row">
                                                                 <div class="col-md-3">
                                                                    <label for="">Gender</label>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <p for="">: {{ ucwords(auth()->user()->gender)  }} </p>
                                                                </div>
                                                               <div class="col-md-3">
                                                                   <label for="">Email</label>
                                                               </div>
                                                               <div class="col-md-3">
                                                                   <p for="">: abdultarickh@gmail.com </p>
                                                               </div>
                                                               <div class="col-md-3">
                                                                   <label for="">Phone No.</label>
                                                               </div>
                                                               <div class="col-md-3">
                                                                   <p for="">: {{ auth()->user()->phone }}</p>
                                                               </div>
                                                           </div>
                               
                                                           <div class="row">
                                                               <div class="col-md-3">
                                                                   <label for="">Notification SMS No.</label>
                                                               </div>
                                                               <div class="col-md-3">
                                                                   <p for="">: Phone No.</p>
                                                               </div>
                                                           </div>
                                                           <div class="row">
                                                               <div class="col-md-3">
                                                                   <label for="">Username</label>
                                                               </div>
                                                               <div class="col-md-3">
                                                                   <p for="">: {{ auth()->user()->username }} </p>
                                                               </div>
                                                               <div class="col-md-3">
                                                                   <label for="">Status</label>
                                                               </div>
                                                               <div class="col-md-3">
                                                                   <p for="">:
                                                                <span class="bg-green badge">Active</span> 
                                                                                                                     
                                                                    </p>
                                                               </div>
                                                           </div>
                                                     </div>
                                                       </div>
                                                    </div>
                                                 </div>
                              </div>
                           </div>





 <div class="modal fade" id="user_edit" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title" style="margin-left: 40%">PROFILE EDIT</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">×</span>
             </button>
          </div>
          <div class="modal-body">
             
            <div class="card-body" style="border-top: 3px solid #70bab3">

                <form action="" id="users_form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Full Name</label>
                                        <input type="text" name="full_name" value="{{ ucwords(auth()->user()->name) }}"  id="full_name" class="form-control form-control-sm">
                                    </div>
                                </div>
            
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <input type="text" name="address" value="{{ auth()->user()->address }}" id="address" class="form-control form-control-sm">
                                    </div>
                                </div>
            
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Email Address</label>
                                        <input type="text" name="email" id="email" value="{{  auth()->user()->email  }}" class="form-control form-control-sm">
                                    </div>
                                </div>
                 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Username</label>
                                        <input type="text" name="username" id="username" value="{{ auth()->user()->username }}"  class="form-control form-control-sm">
                                        <input type="hidden" id="user_id" name="user_id" value="{{auth()->user()->id}}">
                                    </div>
                                </div>
            
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Phone</label>
                                        <input type="text" name="phone" id="phone" value="{{ auth()->user()->phone }}" class="form-control form-control-sm">
                                    </div>
                                </div>
            
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Gender</label>
                                        <select name="gender" id="gender" class="form-control form-control-sm"> 
                                              @php
                                                  $gender = ['Male','Female'];
                                              @endphp

                                                @foreach ( $gender as $mf )
                                                <option value="{{$mf}}" {{ auth()->user()->gender == $mf ? 'selected' : '' }} >{{$mf}}</option>  
                                                @endforeach
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
 </div>
                          
                        </div>                      

                </div>
             </div>
          </div>
       </div>







@endsection

@section('scripts')


$('#edit_my_profile').click(function(e){

    e.preventDefault();

$('#user_edit').modal('show');


});




$("form#users_form").submit(function(e) {
    e.preventDefault();    
    var formData = new FormData(this);

    $.ajax({
        url: '{{ route('configuration.users.my_profile.update') }}',
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
                {{-- toastr.success(response.msg, response.title); --}}
                $('#user_edit').modal('hide');
                {{-- window.location.replace('{{ route('configuration.users.index') }}');  --}}
                {{-- $("#container").load(location.href+" #divReload"); --}}
                let currentUrl = '{{ url()->current() }}'
                window.location.href = currentUrl;
                
            }
    
            else if(response.state == 'Fail'){
                toastr.warning(response.msg, response.title)
    
            }
            else if(response.state == 'Error'){
                toastr.error(response.msg, response.title);
            }
    
        },
        error: function(response){

            if(response.status == 500){

                toastr.error('Internal Server Error', 'error');

            }
            
            
        }
    });
});







@endsection