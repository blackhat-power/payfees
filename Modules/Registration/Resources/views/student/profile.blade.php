
@extends('layouts.app')


@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('students.registration')}}">Students</a></li>
              <li class="breadcrumb-item active" aria-current="page">Profile</a></li>
            </ol>
          </nav>
  

@endsection 
@section('content-body')


<div class="container-fluid">
    <div class="row">
       
      <div class="col-md-3">

         <div class="card card-block p-card" style="border-top: 3px solid #00c0ef">
           @include('registration::includes.student_profile')
         </div>
      </div>   
       <div class="col-md-9">
          <div class="card card-block card-stretch card-height"  style="border-top: 3px solid #70bab3"> {{-- #70bab3 --}}
             <div class="card-header">
                <div class="header-title">
                  @include('registration::student.tabs')
                </div>
             </div>
             {{-- <input type="file" name="innn"> --}}
            
             {{-- @include('configuration::school.includes.tabs') --}}

                              <div class="card-body">
                               {{-- @include('registration::student.tabs') --}}
                                <div class="tab-content" id="pills-tabContent-2">
                                    <div class="tab-pane show active" role="tabpanel">
                                       <p class="text-info" style="font-size: 16px;border-bottom: 1px solid #eee;">Personal Info:</p>
                                       <div class="row">
                                        <div class="container">
                                            <table  class="student_profile_js" style="border: none; width:100% !important; margin-bottom: 1rem; color: #535f6b;">
                                                <tr> 
                                                    <td> Full Name </td>
                                                    <td> <span>: {{ ucwords($student->full_name)   }} </span></td> 
                                                    <td> Date of Birth </td>
                                                    <td> <span>: {{ date('dS M Y  ', strtotime($student->dob))   }}</span>  </td>
                                                </tr>
                                                <tr> <td style="height:2rem;"></td></tr>
                                                <tr>
                                                  <td>Gender</td>
                                                  <td><span>: {{ ucwords($student->gender) }}</span></td>
                                                    <td>Email</td>
                                                    <td><span>: {{ $email }} </span></td>
                                                </tr>
                                                <tr> <td style="height:2rem;"></td></tr>
                                                <tr>
    
                                                    <td>Phone No.</td>
                                                    <td>: {{ $phone }} </td>
                                                </tr>
                                                <tr></tr>
                                            </table>
                                        </div>
                                       </div>

                                       <p class="text-info" style="font-size: 16px;border-bottom: 1px solid #eee; margin-top:1.5%">Academic Info:</p>
                                       <div class="container">
                                        <table class="student_profile_js" style="border: none; width:100%; margin-bottom: 1rem; color: #535f6b;">
                                            <tr> 
                                                <td> Academic Year </td>
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
                                    </div>
                                 </div>

                                   </div>

                                </div>
                             </div>
          </div>
       </div>
      
    </div>
 </div>
 

 @include('registration::student.partials.registration_modal')

 @endsection


 @section('scripts')


 function showEdit(event){
   $('#dp-overlay').css({"display": "block","position": "absolute", "z-index": "10", "height": "inherit", "width": "inherit", "inset": "0px", "margin": "auto"});
}

function hideEdit(event){
   $('#dp-overlay').removeAttr('style','display:block').
   attr('style','display:none');
}
 

$('#profile_image').click(function(){
   $('#profile_pic').click();
});

function upload(event){

   let profile_url = '{{ route('students.profile.pic.update','id') }}';
   let final_profile_url = profile_url.replace('id',@php echo $student->id @endphp );

      data = new FormData($('#profile_submit')[0]);

   $.ajax({
         type:'POST',
         processData: false,
         contentType: false,
         enctype: 'multipart/form-data',
         url:final_profile_url,
         data:data,
         success:function(response){
            console.log(response)

            $("#profile_image_update").attr("src",response);
         }

}); 

}


$('body').on('click','.studentEditBtn',(function(e){
   e.preventDefault();
   let student_id = $(this).data('student_id');
   {{-- console.log(student_id); --}}
   $.ajax({
       type: "POST",
       url: "{{ route('students.registration.edit') }}",
       data:{

          student_id:student_id

       },
       success: function (response) {  
           console.log(response);

         {{-- STUDENT DETAILS EDIT --}}
         $('#first_name').val(response.student.first_name);
         $('#middle_name').val(response.student.middle_name);
         $('#last_name').val(response.student.last_name);
         $('#std_gender').val(response.student.gender).attr('selected','selected');
         $('#class_select').select2('destroy').val(response.student.account_school_details_class_id).attr('selected','selected').select2({width:'100%'});
         $('#stream_select').select2('destroy').val(response.student.account_school_detail_stream_id).attr('selected','selected').select2({width:'100%'});
         $('#std_address').val(response.address.contact);
         $('#std_email').val(response.email.contact);
         $('#std_phone').val(response.phone.contact);
         $('#std_dob').val(response.student.dob);
         $('#stdnt_id').val(response.student.id);
         $('#account_id').val(response.student.account_id);
         $('#admitted_year').val(response.student.admitted_year);
         $('#std_email_id').val(response.email.cnct_id);
         $('#std_phone_id').val(response.phone.cnct_id);
         $('#std_address_id').val(response.address.cnct_id);

         {{-- GUARDIAN CHECK EDIT --}}
         (response.guardian) ? $('#guardian_occupation').val(response.guardian.occupation) :  $('#guardian_occupation').val('');
         (response.guardian) ? $('#guardian_phone').val(response.guardian_phone.contact) : $('#guardian_phone').val('');
         (response.guardian) ? $('#guardian_name').val(response.guardian.guardian_name) : $('#guardian_name').val('');
         (response.guardian) ? $('#guardian_id').val(response.guardian.id) : $('#guardian_id').val('');
         (response.guardian) ? $('#guardian_contact_id').val(response.guardian_phone.cnct_id) : $('#guardian_contact_id').val('');
         
         
         {{-- MOTHER CHECK EDIT --}}
         (response.mother) ? $('#mother_id').val(response.mother.id) : $('#mother_id').val('');
         (response.mother) ? $('#mother_contact_id').val(response.mother_phone.cnct_id) : $('#mother_contact_id').val('');
         (response.mother) ? $('#mother_occupation').val(response.mother.occupation)  : $('#mother_occupation').val('');
         (response.mother) ? $('#mother_phone').val(response.mother_phone.contact) : $('#mother_phone').val('');
         (response.mother) ? $('#mother_name').val(response.mother.mother_name) : $('#mother_name').val('');

         {{-- FATHER CHECK EDIT --}}
         console.log(response.father);
         if(response.father !== null){
             $('#father_id').val(response.father.id);
             $('#father_contact_id').val(response.father_phone.cnct_id);
             $('#father_occupation').val(response.father.occupation);
             $('#father_phone').val(response.father_phone.contact);
             $('#fname').val(response.father.father_name);

         }
         $('#students_registration').modal('show');

       },
       error: function (response) { 
 
       } 
        
    });
   })
);


$('#save_student').click(function(){
   let form_data = $('#student_registration_form').serialize();
   $.ajax({
       type: "POST",
       url: "{{ route('students.store') }}",
       data: form_data,
       success: function (response) {
       if(response.state == 'Done'){
           $('#students_registration').modal('hide');
           console.log(response);
           toastr.success(response.msg, response.title);  
           {{-- $("#content_update").load(location.href + " #content_update"); --}}
           $("#content_update").load(location.href + " #content_update>*", "");
       }

       else if(response.state == 'Fail'){
           toastr.warning(response.msg, response.title)

       }
       else if(response.state == 'Error'){
         toastr.error(response.msg, response.title)

     }

   },
   error: function(response){
       
       toastr.error(response.msg, response.title);
       
   }
   });
});

$('#class_select').select2({
   width:'100%'
});

$('#stream_select').select2({
   width:'100%'
})

 @endsection





















 






