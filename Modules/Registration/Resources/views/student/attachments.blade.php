

@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('students.registration')}}">Students</a></li>
              <li class="breadcrumb-item active" aria-current="page">Attachments</a></li>
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
          <div class="card card-block card-stretch card-height" style="border-top: 3px solid #70bab3">
             <div class="card-header">
                {{-- <div class="header-title"> --}}
                    @include('registration::student.tabs')
                {{-- </div> --}}
             </div>

                              <div class="card-body">
                              
                                <div class="tab-content" id="pills-tabContent-2">

                                 <div class="tab-pane fade show active" id="contact-people" role="tabpanel" aria-labelledby="pills-contact-tab">

                                    
                                    <div class="card">
                                        <div class="card-header">
                                    <a type="button" style="color: white" class=" btn btn-sm btn-primary float-right" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-arrow-down"></i> New </a>
                                    </div>
                                    <div class="collapse" id="collapseExample">
                                     <div id="attachments_display">
                                        <div class="container">
                                            
                                    <form method="post" id="attachments_form"  enctype="multipart/form-data">
                                    @csrf
                                        <div class="row" style="margin-top: 3%">
                                                
                                                    <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="">Attachment Type</label>
                                                    <select name="attachments" id="attachment_id" class="form-control form-control-sm">
                                                        <option value="">Select Attachment Type</option>
                                                        <option value="Receipt">Receipt</option>
                                                        <option value="Invoice">Invoice</option>
                                                    </select>
                                                    <span class="text-danger" style="font-style: italic;" id="type_error_span">      </span>
                                                   
                                                    </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">&nbsp;</label>
                                                        <input type="file" id="myFile" name="attachment_file" class="form-control" style="line-height:21px !important; height:34px !important; padding-bottom:0rem; padding-top:0.1rem">
                                                        <span class="text-danger" style="font-style: italic;" id="file_error_span">      </span>
                                                    </div>
                                                    
                                                    </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">&nbsp;</label>
                                                        <button type="submit" data-toggle="tooltip" data-placement="top" title="" class="btn btn-info btn-default btn-sm" style="color:#fff; margin-top:27px" name="import" value="Import" data-original-title="upload attachment">
                                                         <i class="fa fa-upload "></i>  <i id="spinner" class="fa fa-spinner fa-spin" aria-hidden="true" style="display:none"></i> <span id="textload"></span> </button>
                           
                                                    </div>
                                                    
                                                </div>
                                                
                                        </div>
                                    </form>
                                    
                                            </div>
                                    
                                        </div>
                                    </div>

                                    <div class="table-responsive" style="margin-top: 1%">
                                        <table id="attachments_table" class="table table-striped table-bordered table-sm" width="100%" style="table-layout: inherit">
                                           <thead>
                                           <tr>
                                             <th>Type</th>
                                               <th>Attachment</th>
                                             <th>Action</th>
                                           </tr>
                                           </thead>
                              
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

   let final_profile_url = '{{ route('students.profile.pic.update',$student->id) }}';

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



{{-- START ATTACHMENTS DATATABLE  --}}

let final_attachments_url = '{{ route('students.attachments.datatable',$student->id) }}';

 let attachments_table = $('#attachments_table').DataTable({
   processing: true,
  serverSide: true,
   ajax:final_attachments_url,
   columns:[
      {data: 'attachment_type', name:'attachment_type'},
      {data: 'name', name:'name'},
      {data:'action', name:'action', orderable:false, searchable:false}
  ],


});

{{-- END ATTACHMENTS TABLE --}}

$('#attachments_form').submit(function(e){
 e.preventDefault();

   let url = '{{   route('students.attachments.store',$student->id)  }}';

   if($('#myFile').val() == ''){
      $('#file_error_span').text('No file Attached!');
      {{-- stop_spinner(); --}}
      $('#spinner').attr('style','display:none');
      btn.removeAttr("disabled"); 
  }else{
   $('#file_error_span').text('');
  }
  if($('#attachment_id').val() == ''){
   $('#type_error_span').text('No file Attached!');
}else{
   $('#type_error_span').text('');
}
  
  
   let formData = new FormData(this);
       {{-- $('#image-input-error').text(''); --}}

       $.ajax({
          type:'POST',
          url: url,
           data: formData,
           contentType: false,
           processData: false,
           success: (response) => {
             if (response) {
               this.reset();
               if(response.state == 'Done'){
                  toastr.success(response.msg, response.title);
               }
               if(response.state == 'Fail'){
                  toastr.success(response.msg, response.title);
               }

               if(response.state == 'Error'){
                  toastr.success(response.msg, response.title);
               }

               attachments_table.draw();
               
      }
           },
           error: function(response){
            if(response.status == 500){
               toastr.error('Internal Server Error', 'error');
            }

           }
});



});


$('body').on('click','.attDltBtn', function(e){
   e.preventDefault();

   let url = '{{   route('students.attachments.delete',$student->id)  }}';

  let id = $(this).data('dlt_attachment');


  Swal.fire({
   title: 'Are you sure?',
   text: "You won't be able to revert this!",
   icon: 'warning',
   showCancelButton: true,
   confirmButtonColor: '#3085d6',
   cancelButtonColor: '#d33',
   confirmButtonText: 'Yes, delete it!'
 }).then((result) => {
   if (result.isConfirmed) {

      $.ajax({

         type:'POST',
         url:url,
      
         success: function(response){
            if(response.state == 'Done'){
               attachments_table.draw();
               toastr.success(response.msg, response.title);  
           }
   
           else if(response.state == ' Fail'){
               toastr.warning(response.msg, response.title)
   
           }
           else{
               toastr.error(response.msg, response.title);
           }
           
      
         },

         error: function(response){
               
            toastr.error(response.msg, response.title);
            
        }

        });

   }
 });

  
  
});


$('#attachment_id').select2({width:'100%'});



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