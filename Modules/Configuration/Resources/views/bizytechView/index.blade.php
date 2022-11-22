@extends('layouts.app')

@section('content-breadcrumbs')
<nav aria-label="breadcrumb" style="width: 100%;">
   <ol class="breadcrumb" style="background-color: rgb(255, 249, 249)">
      <li class="breadcrumb-item"><a href="#">Registered Schools</a></li>
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Schools</li>
   </ol>
</nav>
<hr>
@endsection

{{-- @section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
        <div class="navbar-breadcrumb">
            <h4 class="mb-0">Registered Schools</h4>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Schools</li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection --}}

@section('content-body')

<div class="container-fluid">
   <div class="row">
       <div class="col-sm-12">
           <div class="card">
               <div class="card-body">
                  <div class="card-header border-bottom">
                     <a href="{{ route('school.settings.create') }}" id="register" type="button" class=" btn btn-sm btn-primary float-right" style="color: white"><i class="fa fa-plus-circle"></i> New </a>
                     <span>
                         <input type="checkbox" id="filter_checkbox" class="checkbox-input float-left" style="width: 30px; height: 30px;">
                        Filters
                     </span>

                     <div class="row" style="margin-top:2%; display:none" id="toggleFilters" >
                        <div class="col-md-3">
                            <select name="class_filter" id="class_filter" class="form-control form-control-sm">
                                <option value="">Select Region</option>
                            </select>   
                        </div>
            
                        <div class="col-md-3">
                            <select name="stream_filter" id="stream_filter" class="form-control form-control-sm">
                                <option value="">Select District</option>
                            </select>
                        </div>
                    </div>
                  </div>
                   <div class="table-responsive">
                       <table id="schools_datatable" class="table table-striped table-bordered" width="100%" style="table-layout: inherit">
                           <thead>
                           <tr>
                               <th>School Name</th>
                               <th>Ownership</th>
                               <th>Organization</th>
                               <th>Number Of Students </th>
                               <th>Location</th>
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


<div class="modal fade" id="configurations_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">School Registration</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">×</span>
             </button>
          </div>
          <hr style=" height: 5px;
                        background-color:#2E9AFE ;
                        border: none;"> 
         <form id="school_form">      
          <div class="modal-body">
            <div class="row">
               <div class="col-md-1"></div>
                <div class="col-md-10">
                   <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                           <label>School Name: *</label>
                           <input type="text" class="form-control form-control-sm"  name="school_name" id="school_name" placeholder="enter school">
                           <input type="hidden" name="school_id" id="school_id">
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                           <label>Ownership: *</label>
                           <select name="school_ownership" id="school_ownership" class="form-control form-control-sm" >
                              <option value="Government">Government</option>
                              <option value="Private">Private</option>
                           </select>
                           {{-- <input type="text" class="form-control" name="school_ownership" id="school_ownership" placeholder="enter owner"> --}}
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Registration No: *</label>
                           <input type="text" class="form-control form-control-sm" name="registration_no" id="registration_no" placeholder="enter registration no.">
                        </div>
                     </div>


                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Category: *</label>
                           <select name="school_category[]" id="school_category" multiple="multiple" class="form-control form-control-sm" >
                              <option value="">Select Category </option>
                              <option value="nursery">Nursery</option>
                              <option value="primary">Primary</option>
                              <option value="secondary">Secondary</option>
                           </select>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label>School Address: *</label>
                           <input type="text" class="form-control form-control-sm " name="school_address" id="school_address" placeholder="enter address">
                           <input type="hidden" class="form-control form-control-sm " name="school_address_id" id="school_address_id">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Phone No: *</label>
                           <input type="text" class="form-control form-control-sm" name="phone_no" id="phone_no" placeholder="enter phone">
                           <input type="hidden" class="form-control form-control-sm" name="phone_no_id" id="phone_no_id" placeholder="enter phone">
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label>District: *</label>
                           <select name="district" id="district" class="form-control">
                           </select>
                        </div>
                     </div>
                     <div class="col-md-6">
                      <div class="form-group">
                         <label>Ward: *</label>
                         <select name="ward" id="ward" class="form-control">
                            <option value=""></option>
                         </select>
                      </div>
                   </div>
                   <div class="col-md-6">
                      <div class="form-group">
                         <label>Village: *</label>
                         <select name="village" id="village" style="height: 50%" class="form-control">
                            <option value=""></option>
                         </select>
                      </div>
                   </div>

                   <div class="col-md-6">
                     <div class="form-group">
                        <label>Email Address: *</label>
                        <input type="text" class="form-control form-control-sm" name="email" id="email" placeholder="eg xx@gmail.com">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Upload Logo: *</label>
                        <input type="file" class="form-control form-control-sm" name="logo" id="logo" >
                     </div>
                  </div>

                   </div>
                   
                </div>
              

             </div>

             <h5 style="text-align: center">Bank Details</h5>
             <hr style=" height: 5px;
                        background-color:#2E9AFE ;
                        border: none;">       
             <div id="bank_details">
               <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-10">
                     <div class="row">

                        <div class="col-md-5">
                           <div class="form-group">
                              <label for="Bank Name"> Bank Name</label>
                               <select name="bank_details[]" id="bank_name" class="form-control form-control-sm banks_select2">
                                   <option value="">Select Bank</option>
                                  @foreach ($banks as $bank )
                                  <option value="{{ $bank->id }}">{{$bank->bank_name}}</option>
                                  @endforeach
                                  
                               </select>
        
                           </div>
                         </div>

                         <div class="col-md-5">
                           <div class="form-group">
                               <label for="Account No">Account No.</label>
                               <input type="text" class="form-control form-control-sm" name="account_no[]" id="">
                           </div>
                       </div>

                       <div class="col-md-1">
                        <button type="button" style="color:black; margin-top:65%" class="btn btn-primary btn-sm fa fa-plus" id="class_add_bank"> </button>
                     </div>

                     </div>
                  </div>
               
             
                 

              </div>

             </div>
          </div>
        
          <div class="modal-footer">
             <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <a href="#">  <button type="button" class="btn btn-primary btn-sm"  id="save_school">Save changes</button>  </a> 
          </div>

         </form>
       </div>
    </div>
 </div>



{{-- bank duplicate --}}
 <div class="row" id="bank_duplicate" style="display: none">
   <div class="col-md-1"></div>
   <div class="col-md-10">

      <div class="row">

         <div class="col-md-5">
            <div class="form-group">
                   <select name="bank_details[]" id="bank_detail" class="form-control new_select_bank">
                      <option value="">Select Bank</option>
                     @foreach ($banks as $bank )
                     <option value="{{ $bank->id }}">{{$bank->bank_name}}</option>
                     @endforeach
                  </select>
       
            </div>
          </div>

          <div class="col-md-5">
            <div class="form-group">
                <input type="text" class="form-control form-control-sm" name="account_no[]">
            </div>
        </div>

        <div class="col-md-1">
         <button type="button" style="color:black; margin-top:20%" class="btn btn-warning btn-sm fa fa-minus remove_row"> </button>
        </div>

      </div>

   </div>
  

 
</div>

@endsection

@section('scripts')

school_datatable=$('#schools_datatable').DataTable({
   processing: true,
   serverSide: true,
    ajax:'{{ route('school.settings.datatable') }}',
    columns:[
        {data: 'school_name', name:'school_name'},
        {data:'ownership', name:'ownership'},
        {data:'organization_name', name:'organization_name'},
        {data:'Number_of_students', name:'Number_of_students'},
        {data:'location', name:'location'},
        {data:'action', name:'action', orderable:false, searchable:false}
    ],
  
});


getWards();
function getWards(){
   $('#district').change(function(){
      let district_id = $(this).val();
     let url = '{{ route('configurations.wards.option') }}';
      $.ajax({
         type:'POST',
         url:url,
         data:{
            district_id : district_id
         },
         success: function(response){
            console.log(response);
            $('#ward').html(response);
   
         }
      })
   
   
   });
}

$('#school_category').select2({
   width:'100%',
   multiple:true,
   background:'#fafbfe'
});

$('#district').select2({
   width:'100%',
   multiple:false,
})
$('#ward').select2({
   width:'100%',
   multiple:false

})
$('#village').select2({
   width:'100%',
   multiple:false

})

getVillages();
function getVillages(){
   $('#ward').change(function(){
      let ward_id = $(this).val();
     let url = '{{ route('configurations.villages.option') }}';
      $.ajax({
         type:'POST',
         url:url,
         data:{
            ward_id : ward_id
         },
         success: function(response){
            console.log(response);
            $('#village').html(response);
   
         }
      })
   
   
   });
}


$('#save_school').click(function(){

   let form = $('#school_form');
   let formData = new FormData(form[0]);
   $.ajax({
      url: '{{ route('school.settings.store') }}',
      type: 'POST',
      enctype: 'multipart/form-data',
      cache: false,
      contentType: false,
      processData: false,

      data: formData,

      success: function (response) {
         console.log(response);
         if(response.state == 'Done'){
             console.log(response);
             school_datatable.ajax.reload();
            toastr.success(response.msg, response.title);

         }
              
 
         else if(response.state == ' Fail'){

             toastr.warning(response.msg, response.title)
         }
 
     },
     error: function(response){         
         toastr.error(response.msg, response.title);
         
     }
    
   });

});



{{-- $('body').on('click','.schlEditBtn',function(e){
   e.preventDefault();
   let school_id = $(this).data('school_id');

   let init_url = "{{ route('school.settings.edit','id') }}";
   let url = init_url.replace('id',school_id);
   

   $.ajax({
      url: url,
      data:{
         school_id:school_id
      },
      success: function (response) {  

         console.log(response)

         $('#school_name').val(response.school_details.name);
         $('#school_ownership').val(response.school_details.ownership);
         $('#registration_no').val(response.school_details.registration_number);
         $('#school_category').select2('destroy').val('Secondary').select2({width:'100%'});
         $('#bank_name').val(response.school_details.bank_id);
         $('#email').val(response.email.contact);
         $('#village').html('<option  value="+response.school_villages.id+" selected> '+ response.school_villages.name +' </option>')
         $('#ward').html('<option  value="+response.school_ward.id+" selected> '+ response.school_ward.name +' </option>')
         $('#school_address').val(response.address.contact);
         $('#phone_no').val(response.phone.contact);
         $('#school_id').val(response.school_id);
         $('#phone_no_id').val(response.phone.cnct_id);
         $('#email_id').val(response.email.cnct_id);

         

         

         
         
         


         $('#configurations_modal').modal('show');


      }  
   });

}); --}}

getDistricts();
function getDistricts(){
   $.ajax({
      type: "POST",
      url: "{{ route('configurations.districts.option') }}",

      success: function (response) {
           $('#district').html(response);  
      }  
   });
}

$('#class_add_bank').click(function(){

   let duplicate_row =   $('#bank_duplicate').clone().removeAttr('style id');
   $(this).parents('#bank_details').append(duplicate_row);
   if( duplicate_row.find('.new_select_bank').select2({width: '100%'})){
      duplicate_row.find('.new_select_bank').select2('destroy');
   }
   duplicate_row.find('.new_select_bank').select2({width: '100%'});
   removeRow(duplicate_row);
});

function removeRow(duplicate_row){
   duplicate_row.find('.remove_row').click(function(){
           $(this).parent().parent().remove();
           console.log('remove');
    });
 }


 $('.banks_select2').select2({
    width:'100%'
 });

 $('#school_ownership').select2({
    width:'100%'
 })


 $("#filter_checkbox").change(function() {
   if(this.checked) {
       $('#toggleFilters').removeAttr('style','display:none').css({'margin-top':'2%'});
   }else{
       $('#toggleFilters').css({'display':'none','margin-top':'2%'});
   }
});

@endsection
   