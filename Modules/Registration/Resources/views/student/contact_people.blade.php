
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
          <div class="card card-block card-stretch card-height">
             <div class="card-header">
                <div class="header-title">

                </div>
             </div>
                              <div class="card-body">
                               @include('registration::student.tabs')
                                <div class="tab-content" id="pills-tabContent-2">

                                 <div class="tab-pane fade show active" id="contact-people" role="tabpanel" aria-labelledby="pills-contact-tab">
                                    <div class="card">
                                       <div class="card-header">
                                  
                                          <a  style="color:white !important" id="new_contact_person" class=" btn btn-sm btn-primary float-right"><i class="fa fa-plus-circle"></i> New </a>
                                       </div>
                                       <div class="card-body">
                                          <div class="table-responsive">

                                             <table id="contact_people_table" class="table table-striped table-bordered table-sm" width="100%" style="table-layout: inherit">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Relationship </th>
                                                  <th>Occupation</th>
                                                    <th>Phone</th>
                                                  <th>Action</th>
                                                </tr>
                                                </thead>
                                
                                            </table>
         
                                          </div>

                                       </div>
                                    </div>
  
                                 </div>

                                   <div class="tab-pane fade" id="invoices_list" role="tabpanel" aria-labelledby="pills-profile-tab">
                                      <div class="card" style="border-top: 3px solid #70bab3 ">
                                       <div class="table-responsive">
                                    <table id="new_invoices_table" class="table table-striped table-bordered table-sm" width="100%" style="table-layout: inherit">
                                       <thead>
                                       <tr>
                                           <th>Date</th>
                                         <th>Invoice Number</th>
                                         <th>Amount</th>
                                           <th>Paid</th>
                                           <th>Balance</th>
                                         <th>Action</th>
                                       </tr>
                                       </thead>
                       
                       
                                       <tfoot>
                                           <tr>
                                               <th colspan="2" style="text-align: right">TOTAL</th>
                                               <th></th>
                                               <th></th>
                                               <th></th>
                                           </tr>
                                       </tfoot>
                       
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
 </div>


 <div class="modal fade" id="contact_person_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Contact Person</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="contact_person_form" method="POST">
               @csrf
            <div id="cntP">
            <div class="row">
               <div class="col-md-4">
                   <div class="form-group">
                       <label for="Father's Name">Next of KiN Relationship:</label>
                       <select name="relationship" id="relationship" class="form-control relationship form-control-sm">
                          <option value="FATHER">Father</option>
                          <option value="MOTHER">Mother</option>
                          <option value="GUARDIAN">Guardian</option>
                       </select>
                    </div>
                    <input type="hidden" name="student_id" value="{{$student->id}}" id="student_id">
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                      <label for="Occupation">Name:</label>
                      <input name="father_name" id="father_name" class="form-control name form-control-sm">
                      <input type="hidden" name="father_contact_id" id="father_contact_id">
                      <input type="hidden" name="father_id" id="father_id">
                      <input type="hidden" name="mother_contact_id" id="mother_contact_id">
                      <input type="hidden" name="mother_id" id="mother_id">
                      <input type="hidden" name="guardian_contact_id" id="guardian_contact_id">
                      <input type="hidden" name="guardian_id" id="guardian_id">
                   </div>
              </div>
               <div class="col-md-4">
                   <div class="form-group">
                       <label for="Occupation">Occupation:</label>
                       <input name="father_occupation" id="father_occupation" class="form-control occupation form-control-sm">
                    </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                      <label for="Phone">Phone:</label>
                      <input type="number" name="father_phone" id="father_phone" class="form-control phone form-control-sm">
                   </div>
              </div>
           </div>
         </div>
      </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="save_contact_person" class="btn btn-primary">Save changes</button>
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


$('#save_contact_person').click(function(){

let form_data = $('#contact_person_form').serialize();

let url = '{{ route('student.profile.contact.people.store') }}';

startSpinnerOne();

$.ajax({

   url:url,
   method: 'POST',
   data:form_data,

   success:function(res){
      console.log(res);
      if(res.state == 'DONE'){
          toastr.success(res.msg, res.title);
      }
      if(res.state == 'FAIL'){
          toastr.info(res.msg, res.title);
      }

      if(res.state == 'ERROR'){
          toastr.error(res.msg, res.title);
      }
      $('#contact_person_modal').modal('hide');
      contact_people_datatable.draw();
  },

  error:function(res){

   if(res.status == 500){

      console.log(res); 
      toastr.error('Internal Error', 'error');

   }
  
  }
});

stopSpinnerOne();

});


 

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

{{-- CONTACT PEOPLE DATATABLE --}}

 let contact_url = '{{ route('configurations.contact.people',[':id']) }}';

let cnct_url = contact_url.replace(':id', @php echo $student->id  @endphp );
 

 let contact_people_datatable = $('#contact_people_table').DataTable({
   processing: true,
  serverSide: true,
   ajax:cnct_url,
   columns:[
      {data: 'full_name', name:'full_name'},
      {data: 'relationship', name:'relationship'},
      {data: 'occupation', name:'occupation'},
      {data: 'phone', name:'phone'},
      {data:'action', name:'action', orderable:false, searchable:false}
  ],

});

$('.relationship').change(function(){

   if($(this).val() == 'MOTHER'){
      $(this).parent().parent().parent().find('.occupation').attr('name','mother_occupation').attr('id','mother_occupation_1');
      $(this).parent().parent().parent().find('.name').attr('name','mother_name').attr('id','mother_name_1');
      $(this).parent().parent().parent().find('.phone').attr('name','mother_phone').attr('id','mother_phone_1');

   }
   if($(this).val() == 'GUARDIAN'){
      $(this).parent().parent().parent().find('.occupation').attr('name','guardian_occupation').attr('id','guardian_occupation_1').trigger('change');
      $(this).parent().parent().parent().find('.name').attr('name','guardian_name').attr('id','guardian_name_1');
      $(this).parent().parent().parent().find('.phone').attr('name','guardian_phone').attr('id','guardian_phone_1');

   }
   if($(this).val() == 'FATHER'){
      $(this).parent().parent().parent().find('.occupation').attr('name','father_occupation').attr('id','father_occupation_1').trigger('change');
      $(this).parent().parent().parent().find('.name').attr('name','father_name').attr('id','father_name_1');
      $(this).parent().parent().parent().find('.phone').attr('name','father_phone').attr('id','father_phone_1');
   }
   
});

$('#new_contact_person').click(function(){
   $('#contact_person_modal').modal('show');
});


$('body').on('click','.editCntBtn', function(){

   let student_id = $(this).data('edit_btn');
   let init_url = '{{ route('student.profile.contact.people.edit',':id') }}';
   let url = init_url.replace(':id',student_id);
   let relationship = $('#relationship').val();
   let relationship_select = $('#relationship');

   let contact_person_id = $(this).data('contact_person_id');

   $.ajax({

      url:url,

      type:'POST',

      data:{

         contact_person_id : contact_person_id

      },
      success: function(response){
         console.log(response)
   {{-- GUARDIAN CHECK EDIT --}}
   if(response.guardian){
      $('#relationship').val(response.guardian.relationship).trigger('change');
      $('#relationship').parent().parent().parent().find('.occupation').attr('name','guardian_occupation').attr('id','guardian_occupation_1').trigger('change');
      $('#relationship').parent().parent().parent().find('.name').attr('name','guardian_name').attr('id','guardian_name_1');
      $('#relationship').parent().parent().parent().find('.phone').attr('name','guardian_phone').attr('id','guardian_phone_1');

      $('#guardian_occupation_1').val(response.guardian.occupation)
      $('#guardian_phone_1').val(response.guardian.contact)
      $('#guardian_name_1').val(response.guardian.guardian_name) 
      $('#guardian_id').val(response.guardian.id)
      $('#guardian_contact_id').val(response.guardian.cnct_id)
     
   }
   
   
   {{-- MOTHER CHECK EDIT --}}
   if(response.mother){

      $('#relationship').val(response.mother.relationship).trigger('change')
      $('#relationship').parent().parent().parent().find('.occupation').attr('name','mother_occupation').attr('id','mother_occupation_1');
      $('#relationship').parent().parent().parent().find('.name').attr('name','mother_name').attr('id','mother_name_1');
      $('#relationship').parent().parent().parent().find('.phone').attr('name','mother_phone').attr('id','mother_phone_1');

      $('#mother_id').val(response.mother.id)
      $('#mother_contact_id').val(response.mother.cnct_id)
      $('#mother_occupation_1').val(response.mother.occupation)
      $('#mother_phone_1').val(response.mother.contact)
      $('#mother_name_1').val(response.mother.mother_name)
      
   }


   {{-- FATHER CHECK EDIT --}}
   console.log(response.father);
   if(response.father){

      $('#relationship').val(response.father.relationship).trigger('change');
      $('#relationship').parent().parent().parent().find('.occupation').attr('name','father_occupation').attr('id','father_occupation_1').trigger('change');
      $('#relationship').parent().parent().parent().find('.name').attr('name','father_name').attr('id','father_name_1');
      $('#relationship').parent().parent().parent().find('.phone').attr('name','father_phone').attr('id','father_phone_1');

      $('#father_id').val(response.father.id);
      $('#father_contact_id').val(response.father.cnct_id);
      $('#father_occupation_1').val(response.father.occupation);
      $('#father_phone_1').val(response.father.contact);
      $('#father_name_1').val(response.father.father_name);
      
   }


   $('#contact_person_modal').modal('show');

      }

   });

});


$('body').on('click','.dltBtn', function(e){
   e.preventDefault();
   let cnct_prsn_id = $(this).data('contact_person_id');
   let init_url = '{{ route('student.profile.contact.people.destroy',':id') }}';
   let url = init_url.replace(':id',cnct_prsn_id);

   startSpinnerOne();

   let student_id = $('#student_id').val();

   $.ajax({
      url:url,
      type:'DELETE',
      data:{

         student_id : student_id

      },

      success: function (response) {

         if(response.state == 'DONE'){
             console.log(response);
             contact_people_datatable.ajax.reload();
             toastr.success(response.msg, response.title);  
         }
 
         else if(response.state == 'FAIL'){
             toastr.warning(response.msg, response.title)
 
         }
         else if(response.state == 'ERROR'){

             toastr.error(response.msg, response.title)
 
         }
 
         stopSpinnerOne();
 
     },
     error: function(response){
       if(response.status == 500){
         toastr.error('Internal Server Error', 'error');
       }
         stopSpinnerOne();
     }


   });


});


$('body').on('click','.studentEditBtn',(function(e){
   e.preventDefault();
   let student_id = $(this).data('student_id');
   
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
             $('#father_occupation').val(response.father_phone.occupation);
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





















 






