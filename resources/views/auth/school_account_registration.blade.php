





<!DOCTYPE html>
<html lang="en" id="login-page" class="height-full">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/login.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
      <link rel="stylesheet" href="{{ asset('assets/css/backend.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/fonts/remixicon.css')}}"/>
      <link rel="stylesheet" href="{{ asset('assets/vendor/@icon/dripicons/dripicons.css') }}" />
      <link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.css')}}"/>
      <link rel="stylesheet" href="{{ asset('assets/css/smallbox_anim.css')  }}">
      <link rel="stylesheet" href="{{ asset('assets/css/background_anim.css')  }}">

      <link rel="stylesheet" href="{{ asset('assets/css/new_wizard.css')  }}">
    <link rel="stylesheet" href="{{ asset('assets/toastr/build/toastr.css' )}}"></link>
    <!-- CSS -->
<link href="{{ asset('assets/smartwizard/dist/css/smart_wizard_all.css') }}" rel="stylesheet" type="text/css" />

    <title>Sign in to Payfeetz</title>
  </head>
  <body style="height: 20%">
   {{-- <div style="">
      <img src="{{ asset('assets/images/everlay.svg') }}" style="height: 90%; width:100%; background-position: center; background-repeat: no-repeat; background-size: cover; left: 0px;top: 0px; position:absolute;" alt="">
   </div> --}}
   
    {{-- <img src="{{ asset('assets/images/overlay.svg')  }}"  style="width: 100%;" alt="Glowing universe" class=" bg js-warp-hide position-absolute overflow-hidden home-hero-glow events-none"> --}}

    <div class="header" role="banner">
      <div class="row justify-content-between">
         <div class="container clearfix width-full">
            <img class="header-logo" src="{{ asset('assets/images/logo.png') }}" alt=""   viewBox="0 0 16 16" height="48">
          {{-- <a class="header-logo" href="#"><svg class="octicon octicon-mark-github" height="48"  viewBox="0 0 16 16" width="48"><path fill-rule="evenodd" d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path></svg></a> --}}
        </div>
         <div class="" style="margin-left: 74%">
            <p style="padding: 15px 20px; text-align:center;">Already Have an Account? <a style="cursor: pointer;" href="{{ route('login')  }}"> <span class="text-white">Sign In  <i class=" fa fa-arrow-alt-circle-right">  </i>  </span> </a>.</p>
          </div>
      </div>

      
    
     
      <div class="access-aid"></div>
      <div role="main">
          <div class="container container-sm" style=" background-color:'#d8dee2';  border-top:1px solid #d8dee2; padding:20px; border-radius:5px; border-bottom-left-radius:5px;   border-bottom-right-radius:5px;  ">
        {{-- @include('configuration::school.includes.school_settings_tabs') --}}

        <div class="container container-sm">	


<div id="smartwizard" style="background-color: #fff">  
    <ul class="nav">
       <li>
           <a class="nav-link" href="#step-1">
              Step 1
           </a>
       </li>
       <li>
           <a class="nav-link" href="#step-2">
              Step 2
           </a>
       </li>
    </ul>
 
    <div class="tab-content" style="min-height: 500px;">
       <div id="step-1" class="tab-pane" role="tabpanel">
        <div class="row">
            <div class="col-md-12">&nbsp;</div>
        </div>
        <form id="school_form">
           @csrf

            <div style="border-left: 20%; solid green;
            height: 60%;
            position: absolute;
            left: 60%;
            margin-left: -3px;
            top: 18;">

            </div>

        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                           <label>School Name: <span class="text">*</span></label>
                           <input type="text" class="form-control form-control-sm" value=""  name="school_name" id="school_name" placeholder="enter school" required>
                           <input type="hidden" id="school_id" name="school_id" value="">
                           <input type="hidden" name="account_id" value="">

                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Ownership: *</label>
                           <select name="school_ownership" id="school_ownership" class="form-control form-control-sm" required>
                              <option value="GOVERNMENT" >Government</option>
                              <option value="PRIVATE">Private</option>
                           </select>
                           {{-- <input type="text" class="form-control" name="school_ownership" id="school_ownership" placeholder="enter owner"> --}}
                        </div>
                     </div>

                     <div class="col-md-6">
                      <div class="form-group">
                         <label>Registration No: *</label>
                         <input type="text" class="form-control form-control-sm" value="" name="registration_no" id="registration_no" placeholder="enter registration no." required>
                      </div>
                   </div>

                   <div class="col-md-6">
                      <div class="form-group">
                         <label>Category: *</label>
                         <select name="school_category[]" id="school_category" multiple="multiple" class="form-control form-control-sm" required >
                           <option value="">Select Category </option>
                            @foreach ($categories as $category )
                            <option value="{{ $category->id  }}">{{ $category->name }}</option>  
                            @endforeach
                         </select>
                      </div>
                   </div>

                   <div class="col-md-6">
                      <div class="form-group">
                         <label>School Address: *</label>
                         <input type="text" class="form-control form-control-sm"  value="" name="school_address" id="school_address" placeholder="enter address" required>
                         <input type="hidden" name="school_address_id" id="school_address_id" value="" >
                      </div>
                   </div>

                   <div class="col-md-6">
                      <div class="form-group">
                         <label>Phone No: *</label>
                         <input type="text" class="form-control form-control-sm" value="" name="phone_no" id="phone_no" placeholder="enter phone" required>
                         <input type="hidden" class="form-control form-control-sm" value="" name="phone_no_id" id="phone_no_id" placeholder="enter phone">

                      </div>
                   </div>


                   <div class="col-md-6">
                      <div class="form-group">
                         <label>Email Address: *</label>
                         <input type="text" class="form-control form-control-sm" value="" name="email" id="email" placeholder="enter email" required>
                         <input type="hidden" class="form-control form-control-sm" value="" name="email_id" id="email_id" placeholder="enter email">
                         
                      </div>
                   </div>

                   {{-- <div class="col-md-6"> --}}
                     {{-- <div class="form-group"> --}}
                        {{-- <label>Current Session: *</label> --}}
                        <input type="hidden" id="current_session" name="current_session" class="form-control form-control-sm" placeholder="eg. 2022-2023" required>
                        <input type="hidden" name="current_session_value" value="">
                        </select>
                     {{-- </div> --}}
                  {{-- </div> --}}

                   <div class="col-md-6">
                      <div class="form-group">
                         <label>District: *</label>
                         <select name="district" id="district" class="form-control" required>
                            
                            <option value=""></option>
                            @foreach ($districts as $district )

                            <option value="{{$district->id}}">{{$district->name}}</option>
                               
                            @endforeach
                         </select>
                      </div>
                   </div>

                   <div class="col-md-6">
                      <div class="form-group">
                         <label>Ward: *</label>
                         <select name="ward" id="ward" class="form-control" required>
                              
                            <option value=""></option>

                         </select>
                      </div>
                   </div>

                   <div class="col-md-6">
                     <div class="form-group">
                        <label>Street: *</label>
                        <input type="text" id="street" readonly name="street" class="form-control form-control-sm" required>
                        <input type="hidden" name="street_id" value="">
                        </select>
                     </div>
                  </div>


                </div>
            </div>
            
            <div style="margin-left:3%; margin-top:6%;" class="col-md-3">
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
                        <div class="form-group" style="margin-left: 1.5vw;">
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

       </div>
       <div id="step-2" class="tab-pane" role="tabpanel">

         <div class="row justify-content-center" style="margin-bottom:2%">
                       
            <span style="font-size: 15pt; border-bottom:1px solid green;" class="text-center text-black text-bold"> BANK SETTINGS  </span>
            <div class="col-md-12"></div>
           </div>

      <div id="bank_details">
         <div class="row">
             <div class="col-md-10">
                 <div class="row">
                     <div class="col-md-1"></div>
                     <div class="col-md-5">
                         <div class="form-group">
                            <label for="Bank Name"> Bank Name</label>
                             <select name="bank_details[]" class="form-control form-control-sm banks_select2">
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
                             <input type="text" class="form-control form-control-sm" value="" name="account_no[]" id="account_no">
                         </div>
                     </div>
                        <div class="col-md-1">
                           <button type="button" style="color:black; margin-top:65%" class="btn btn-primary btn-sm fa fa-plus" id="class_add_bank"> </button>
                        </div>
                 </div>

             </div>

         </div>
       </div> 
   
        
      </form>

        
{{-- bank duplicate --}}
 <div class="row" id="bank_duplicate" style="display: none">
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="form-group">
                       <select name="bank_details[]" id="bank_detail" class="form-control multiple_select new_select_bank">
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
    <button type="button" style="color:black; margin-top:5%" class="btn btn-warning btn-sm fa fa-minus remove_row"> </button>
   </div>
        </div>
    </div>
</div>
       </div>
    </div>

    <div class="progress">
      <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>

      <div class="site-footer">
        <ul class="site-footer-links">
          <li><a href="#">Terms</a></li>
          <li><a href="#">Privacy</a></li>
          <li><a href="#">Security</a></li>
          <li><a href="#">Contact Bizytech</a></li>
        </ul>
      </div>
    </div>


<div>
         {{--   <ul class="circles">
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
          </ul>  --}}

  </div>


  </body>


  <footer>

<script src="{{ asset('assets/jquery/dist/jquery.js' )}}"></script>
<script src="{{ asset('assets/select2/dist/js/select2.js' )}}"></script>
<script src="{{ asset('assets/toastr/build/toastr.min.js' )}}"></script>
<script type="text/javascript">
   $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
   </script>   
<!-- JavaScript -->
<script src="{{asset('assets/smartwizard/dist/js/jquery.smartWizard.js')}}" type="text/javascript"></script>
<script>
let inputElem = document.querySelector("#login-page");
window.addEventListener('load', function(e) {
    inputElem.focus();
})

$('#school_ownership').select2({width:'100%'});

$('#school_category').select2({width:'100%'});






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
   $('#customInput').val('');
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




                                 /* SMART WIZARD JS SETUP */


var submitBtn = $('<button> </button>').text('SUBMIT')
                                  .addClass('btn btn-primary  sw-btn-group-extra d-none')
                                  .on('click', function(){ 
                                    let form_data = $('#school_form').serialize();
                                    console.log(form_data);

                                    $.ajax({
                                       type: "POST",
                                       url: "{{ route('school.settings.store') }}",
                                       data: form_data,
                                       beforeSend: function( xhr ) {
                                       // Show the loader
                                       $('#smartwizard').smartWizard("loader", "show");
                                    }
                                    }).done(function( res ) {
                                       if(res.state == 'Done'){
                                         let url = "//"+res.url;
                                          window.location.replace(url);
                                          $('#smartwizard').smartWizard("loader", "hide");
                                       }
                                       else if(res.state == 'Fail'){
                                          toastr.info(res.msg, res.title);
                                           $('#smartwizard').smartWizard("loader", "hide");
                                       }

                       // Hide the loader
                                 
                                       

   }).fail(function(err) {
       if(err.state == 'Error'){
          toastr.error(res.msg, res.title);
       }
       $('#smartwizard').smartWizard("loader", "hide");
   });

         });


$(document).ready(function(){
 
 // SmartWizard initialize
 $('#smartwizard').smartWizard({
   theme: 'arrows',
   keyboardSettings: {
     keyNavigation: true,
     keyLeft: [74], // J key code
     keyRight: [75] // K key code
   },
   toolbar: {
      position: 'bottom', // none|top|bottom|both
      showNextButton: true, // show/hide a Next button
      showPreviousButton: true, // show/hide a Previous button
      extraHtml: [submitBtn] // Extra html to show on toolbar
  }, 

  anchor: {
      enableNavigation: true, // Enable/Disable anchor navigation 
      enableNavigationAlways: false, // Activates all anchors clickable always
      enableDoneState: true, // Add done state on visited steps
      markPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
      unDoneOnBackNavigation: false, // While navigate back, done state will be cleared
      enableDoneStateNavigation: true // Enable/Disable the done state navigation
  },
 });

});



$("#smartwizard").on("showStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
if(currentStepIndex == '1'){
   $('.sw-btn-group-extra').removeClass('d-none'); 
}
else{
   $('.sw-btn-group-extra').addClass('d-none'); 
}


});

 
 $("#smartwizard").on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {

   if(anchorObject.prevObject.length - 1 == nextStepIndex){
      let form_data = $('#school_form').serialize();
      let url = 'AJAXURL'
   $.ajax({
      type: "POST",
      url: url,
      data: form_data,
      beforeSend: function( xhr ) {
           // Show the loader
           $('#smartwizard').smartWizard("loader", "show");
       }
  
   }).done(function( res ) {
       // Build the content HTML
       let html = `<div class="card w-100" >
                       <div class="card-body">
                           <p class="card-text">${res}</p>
                       </div>
                   </div>`;
         
       // Resolve the Promise with the tab content
       callback(html);

       // Hide the loader
       $('#smartwizard').smartWizard("loader", "hide");
      

   }).fail(function(err) {
       // Handle ajax error
      
       // Hide the loader
       $('#smartwizard').smartWizard("loader", "hide");
   });

            }


}); 


$('#smartwizard').smartWizard("fixHeight");



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




// Checking button status ( wether or not next/previous and
// submit should be displayed )
const checkButtons = (activeStep, stepsCount) => {
  const prevBtn = $("#wizard-prev");
  const nextBtn = $("#wizard-next");
  const submBtn = $("#wizard-subm");

  switch (activeStep / stepsCount) {
    case 0: // First Step
      prevBtn.hide();
      submBtn.hide();
      nextBtn.show();
      break;
    case 1: // Last Step
      nextBtn.hide();
      prevBtn.show();
      submBtn.show();
      break;
    default:
      submBtn.hide();
      prevBtn.show();
      nextBtn.show();
  }
};

// Scrolling the form to the middle of the screen if the form
// is taller than the viewHeight
const scrollWindow = (activeStepHeight, viewHeight) => {
  if (viewHeight < activeStepHeight) {
    $(window).scrollTop($(steps[activeStep]).offset().top - viewHeight / 2);
  }
};

// Setting the wizard body height, this is needed because
// the steps inside of the body have position: absolute
const setWizardHeight = activeStepHeight => {
  $(".wizard-body").height(activeStepHeight);
};

$(function() {
  // Form step counter (little cirecles at the top of the form)
  const wizardSteps = $(".wizard-header .wizard-step");
  // Form steps (actual steps)
  const steps = $(".wizard-body .step");
  // Number of steps (counting from 0)
  const stepsCount = steps.length - 1;
  // Screen Height
  const viewHeight = $(window).height();
  // Current step being shown (counting from 0)
  let activeStep = 0;
  // Height of the current step
  let activeStepHeight = $(steps[activeStep]).height();

  checkButtons(activeStep, stepsCount);
  setWizardHeight(activeStepHeight);
  
  // Resizing wizard body when the viewport changes
  $(window).resize(function() {
    setWizardHeight($(steps[activeStep]).height());
  });

  // Previous button handler
  $("#wizard-prev").click(() => {
    // Sliding out current step
    $(steps[activeStep]).removeClass("active");
    $(wizardSteps[activeStep]).removeClass("active");

    activeStep--;
    
    // Sliding in previous Step
    $(steps[activeStep]).removeClass("off").addClass("active");
    $(wizardSteps[activeStep]).addClass("active");

    activeStepHeight = $(steps[activeStep]).height();
    setWizardHeight(activeStepHeight);
    checkButtons(activeStep, stepsCount);
  });

  // Next button handler
  $("#wizard-next").click(() => {
    // Sliding out current step
    $(steps[activeStep]).removeClass("inital").addClass("off").removeClass("active");
    $(wizardSteps[activeStep]).removeClass("active");

    // Next step
    activeStep++;
    
    // Sliding in next step
    $(steps[activeStep]).addClass("active");
    $(wizardSteps[activeStep]).addClass("active");

    activeStepHeight = $(steps[activeStep]).height();
    setWizardHeight(activeStepHeight);
    checkButtons(activeStep, stepsCount);
  });
});



// $(document).ready(function () {
//     var $el = $('#paragraph'),
//         text = $el.text(),
//         speed = 50; //ms

//     $el.empty();
// var wordArray = text.split(' ');
// console.log(wordArray)    
//     i = 0;
//    let paragraph = setInterval(() => {
//        if( i >= wordArray.length - 1){
//            clearInterval(paragraph);
//            $el.append(wordArray[i] + ' ');
//         i++;
//        }
       
//    }, speed);

// });




      </script>
  </footer>
</html>
