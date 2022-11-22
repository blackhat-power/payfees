@extends('layouts.app')

@section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
        <div class="navbar-breadcrumb">
            <h4 class="mb-0"> School Registration</h4>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">School Registration</li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection

@section('content-body')

<div class="card">

   <div class="card-body">
{{-- @include('configuration::school.includes.school_settings_tabs') --}}

            <form id="school_form">

               <div style="border-left: 6px solid green;
               height: 60%;
               position: absolute;
               left: 60%;
               margin-left: -3px;
               top: 18;">

           </div>
           <div class="row">
               <div class="col-md-7">
                   <div class="row">
                       <div class="col-md-6">
                           <div class="form-group">
                              <label>School Name: *</label>
                              <input type="text" class="form-control form-control-sm"   name="school_name" id="school_name" placeholder="enter school">
                              <input type="hidden" id="school_id" name="school_id">
                              <input type="hidden" name="account_id" >

                           </div>
                        </div>

                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Ownership: *</label>
                              <select name="school_ownership" id="school_ownership" class="form-control form-control-sm" >
                                 <option value="GOVERNMENT" >Government</option>
                                 <option value="PRIVATE">Private</option>
                              </select>
                              {{-- <input type="text" class="form-control" name="school_ownership" id="school_ownership" placeholder="enter owner"> --}}
                           </div>
                        </div>

                        <div class="col-md-6">
                         <div class="form-group">
                            <label>Registration No: *</label>
                            <input type="text" class="form-control form-control-sm"  name="registration_no" id="registration_no" placeholder="enter registration no.">
                         </div>
                      </div>

                      <div class="col-md-6">
                         <div class="form-group">
                            <label>Category: *</label>
                            <select name="school_category[]" id="school_category" multiple="multiple" class="form-control form-control-sm" >
                              <option >Select Category </option>
                               @foreach ($categories as $category )
                               <option value="{{ $category->id  }}">{{ $category->name }}</option>  
                               @endforeach
                            </select>
                         </div>
                      </div>

                      <div class="col-md-6">
                         <div class="form-group">
                            <label>School Address: *</label>
                            <input type="text" class="form-control form-control-sm"   name="school_address" id="school_address" placeholder="enter address">
                            <input type="hidden" name="school_address_id" id="school_address_id"  >
                         </div>
                      </div>

                      <div class="col-md-6">
                         <div class="form-group">
                            <label>Phone No: *</label>
                            <input type="text" class="form-control form-control-sm"  name="phone_no" id="phone_no" placeholder="enter phone">
                            <input type="hidden" class="form-control form-control-sm"  name="phone_no_id" id="phone_no_id" placeholder="enter phone">

                         </div>
                      </div>


                      <div class="col-md-6">
                         <div class="form-group">
                            <label>Email Address: *</label>
                            <input type="text" class="form-control form-control-sm"  name="email" id="email" placeholder="enter email">
                            <input type="hidden" class="form-control form-control-sm"  name="email_id" id="email_id" placeholder="enter email">
                            
                         </div>
                      </div>

                      {{-- <div class="col-md-6"> --}}
                        {{-- <div class="form-group"> --}}
                           {{-- <label>Current Session: *</label> --}}
                           <input type="hidden" id="current_session" name="current_session" class="form-control form-control-sm" placeholder="eg. 2022-2023" required>
                           <input type="hidden" name="current_session_value" >
                           </select>
                        {{-- </div> --}}
                     {{-- </div> --}}

                      <div class="col-md-6">
                         <div class="form-group">
                            <label>District: *</label>
                            <select name="district" id="district" class="form-control" required>
                               
                               <option ></option>
                            </select>
                         </div>
                      </div>

                      <div class="col-md-6">
                         <div class="form-group">
                            <label>Ward: *</label>
                            <select name="ward" id="ward" class="form-control">
                                 
                               <option ></option>

                            </select>
                         </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                           <label>Street: *</label>
                           <input type="text" id="street" readonly name="street" class="form-control form-control-sm">
                           <input type="hidden" name="street_id" >
                           </select>
                        </div>
                     </div>

                    

                      {{-- <div class="col-md-6">
                         <div class="form-group">
                            <label>Village: *</label>
                            <select name="village" id="village" style="height: 50%" class="form-control">
                                
                               <option ></option>
                            </select>
                         </div>
                      </div> --}}


                   </div>
               </div>
               
               <div style="margin-left:10%; margin-top:6%;" class="col-md-3">
                  <div class="row">
                     <div class="col-md-12">
                     <div class="row" style="width: 100%; !important">
                        <div class="col-md-12">
                           <span>
                              <p class="text-center text-bold">Change Logo</p>  
                           </span>
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="container">
                                  
                                  <img id="profile-image" accept="image/*" src=""  style="width:300px; height:200px;" alt="">
                                    <fieldset style="display: none; width:100%;" class="border p-2">
                                    <legend>Preview</legend>
                                    <img id="image_preview" style="width:auto;height:300;max-width:100%;max-height:100%;" src="" alt="placeholder">
                                    <span>
                                       <p class="text-center text-bold" id="file_name">Picture name</p>
                                    </span>

                                    <span id="zoom" class="float-right"> <a href="javascript:void(0)">  <i class="fas fa-search-plus"></i></a></span>
                                    </fieldset>
                                 </div>
                              </div>
                           </div>
                           
                        </div>
                     </div>
                     </div>
                     
                     <div class="row col-md-12" style="margin-top: 4%">
                        <div class="col-md-6">     
                           <div class="form-group" style="margin-left: 2vw;">
                              <button id="remove" style="display:none" class="btn btn-secondary btn-sm">X Remove</button>
                           </div>

                        </div>
                        <div class="col-md-6">
                           <div class="form-group" style="margin-left: 2vw;">
                             {{--  <input type="file" name="photo" onchange="previewFile(this)" class="custom-file-input" data-show-caption="false" data-show-upload="false" data-fouc required>
                              <span>Browse</span> --}}
                              <div class="custom-file">
                                 <span>
                                    <label class=" btn btn-primary btn-sm" for="customInput"> <i class="fas fa-file-medical"></i> Browse </label>
                                    <input type="file" src="" name="logo" onchange="previewFile(this)" class="custom-file-input form-control-sm" id="customInput">
                                 </span>
                             </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               
           </div>

           <div class="row" style="margin-top:2%">
              <div class="col-md-7">
               <h5 style="text-align: center; margin-top:2%;">Bank Details</h5>
               <hr style=" height: 5px;
                          background-color:#2E9AFE ;
                          border: none;">
               </div> 
           </div>
          
           <div id="bank_details">
           <div class="row">
               <div class="col-md-7">
                   <div class="row">
                       <div class="col-md-1"></div>
                       <div class="col-md-5">
                           <div class="form-group">
                              <label for="Bank Name"> Bank Name</label>
                               <select name="bank_details[]" class="form-control form-control-sm banks_select2">
                                   <option >Select Bank</option>
                                  @foreach ($banks as $bank )
                                  <option value="{{ $bank->id }}">{{$bank->bank_name}}</option>
                                  @endforeach
                                  
                               </select>
                           </div>
                         </div>
                         <div class="col-md-5">
                           <div class="form-group">
                               <label for="Account No">Account No.</label>
                               <input type="text" class="form-control form-control-sm"  name="account_no[]" id="account_no">
                           </div>
                       </div>
                          <div class="col-md-1">
                             <button type="button" style="color:black; margin-top:90%" class="btn btn-primary btn-sm fa fa-plus" id="class_add_bank"> </button>
                          </div>
                   </div>

               </div>

           </div>
         </div>       
            <div class="row" style="margin-top: 2%; margin-left:10%">
             <div class="col-md-8"></div>
                <button type="submit" class="btn btn-primary btn-sm" id="save_school"><i class="fa fa-paper-plane"></i> Save Changes</button> 
            </div>
          
        </form>
         </div>
      </div>

   </div>
 </div>
       </div>
    </div>
 </div>



{{-- bank duplicate --}}
 <div class="row" id="bank_duplicate" style="display: none">
    <div class="col-md-7">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="form-group">
                       <select name="bank_details[]" id="bank_detail" class="form-control multiple_select new_select_bank">
                          <option >Select Bank</option>
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
    <button type="button" style="color:black; margin-top:5%" class="btn btn-warning btn-sm fa fa-minus remove_row"> </button>
   </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')


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
{{-- $('#village').select2({
   width:'100%',
   multiple:false

}) --}}

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
            {{-- $('#village').html(response); --}}
            $('#street').removeAttr('readonly');
   
         }
      })
   
   
   });
}

$('#remove').click(function(e){
   e.preventDefault();
   $(this).attr('style','display:none');
   $('#profile-image').removeAttr('style','display:none');
   $('#customInput').val();
   {{-- $("div").animate({left: '250px'}) --}}
   $('fieldset').attr('style','display:none');

});

{{-- 
$('#save_school').click(function(){
   let form_data = $('#school_form').serialize();
   console.log(form_data);

   $.ajax({
      type: "POST",
      url: "{{ route('school.settings.store') }}",
      data: form_data,
      success: function (response) {
          school_datatable.ajax.reload();
           $('#configurations_modal').modal('hide');
      }  
   });

}); --}}

$('#save_school').click(function(e){
   e.preventDefault();
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
            toastr.success(response.msg, response.title);
            let url = '{{ route('configurations.index') }}';
            window.location.replace(url);

         }
              
         else if(response.state == 'Fail'){
             toastr.warning(response.msg, response.title)
             console.log(response)
         }

         else if(response.state == 'Error'){
            toastr.error(response.msg, response.title)
            console.log(response)
        }
 
     },
     error: function(response){  

         console.log(response)   
         
     }
    
   });

});


{{-- $("form#school_edit_form").submit(function(e) {
   e.preventDefault();    
   var formData = new FormData(this);
   alert('yeah');

   $.ajax({
       url: '{{ route('school.settings.store') }}',
       type: 'POST',
       enctype: 'multipart/form-data',
       cache: false,
       contentType: false,
       processData: false,

       data: formData,
       success: function (response) {
           
         console.log(response)

       }
   }
   );
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


 function previewFile(input){
   var file = $("input[type=file]").get(0).files[0];
   $('fieldset').removeAttr('style','display:none');
   $('#profile-image').attr('style','display:none');
   var fileName = file.name;
   $('#remove').removeAttr('style');

   $('#file_name').text(fileName);

   if(file){
       var reader = new FileReader();

       reader.onload = function(){
           $("#image_preview").attr("src", reader.result);
       }

       reader.readAsDataURL(file);
   }
}


$('#zoom').click(function(){
   {{-- e.preventDefault(); --}}
   $('#image_preview').imageZoom();
})


@endsection
   