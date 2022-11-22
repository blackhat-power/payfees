{{-- <div class=""></div> --}}
<div class="profile-box bg-green-400">
    <div class="profile rounded" onmouseover="showEdit(event)" onmouseout="hideEdit(event)" style="position:relative;">
       <div class="img-display" id="dp-overlay" style="position: absolute; z-index: 10; height: inherit; width: inherit; inset: 0px; margin: auto; display: none;">
       
       <form id="profile_submit" action="{{ route('students.profile.pic.update',$student->id) }}" method="post" enctype="multipart/form-data"> 
             {{ csrf_field() }}
             {{-- {{ method_field('put') }} --}}

           <input onchange ="upload(event)" style="display: none" type="file" name="profile_pic" id="profile_pic">  

       </form>
         
        <a href="javascript:void(0)"> 
          <img id="profile_image" style="display:block; position:relative; background-color:#20202090; padding: 40px;border-radius: 50%; height: 120px; width: 120px;  top: 30%;-ms-transform: translateY(-50%);transform: translateY(-50%);margin: auto;" src="{{ asset('assets/images/profile_edit.png')  }}"> 
        </a>  
    </div>
       @php  $url= asset('storage/student_profile_pics/'.$student->profile_pic); @endphp
    
       <img id="profile_image_update" src="{{ $url }}" alt="profile-bg" class="avatar-120 rounded d-block mx-auto img-fluid mb-1">
     
      
       <h5 class="font-60 text-center mb-1">{{ strtoupper($student->full_name) }}</h5>
       <p class="text-muted  text-center"> {{   Modules\Configuration\Entities\AccountSchoolDetailClass::find($student->account_school_details_class_id)->name  }}  </p>
       
    </div>
    <div class="pro-content rounded" id="content_update" style="margin-top: 1%; width:100%;">
       <div class="d-flex align-items-center mb-3">
          <div class="p-icon mr-1" style="width:14%; height:4%">
             <i class="las la-envelope-open-text"></i>
          </div>
          {{-- <div class="row">
             <div class="col-md-12"> --}}
                <span style="word-break: break-all;" class="mb-0">{{$email}}</span>
             {{-- </div>
          </div> --}}
          
       </div>

       <div class="d-flex align-items-center mb-3">
          <div class="p-icon mr-1" style="width:14%; height:4%;">
             <i class="las la-phone"></i>
          </div>
          <span style="word-break: break-all; font-size:0.9em " class="mb-0">{{$phone}}</span>
       </div>
       <div class="d-flex align-items-center mb-3">
          <div class="p-icon mr-1" style="width:14%; height:4%">
             <i class="las la-map-marked"></i>
          </div>
          <span style="word-break: break-all; font-size:0.9em" class="mb-0">{{$address}}</span>
          
       </div>
       <div class="d-flex justify-content-center">
          <div class="social-ic d-inline-flex rounded">
             <a data-student_id="{{$student->id}}"  class="btn btn-sm btn-pill btn-outline-primary studentEditBtn"> <i class="fa fa-edit"> </i> </a> 
          </div>
       </div>
    </div>
 </div>