


@extends('layouts.app')
@section('content-heading')
<link rel="stylesheet" href="{{ asset('css/loader.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css ">  
<style>
.loader {
    width: 1em;
    height: 1em;
    margin: auto;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    position: absolute;
}
.wizard_btns{
margin-top: 0.3rem;
}
.nav-pills .nav-link.active{

background-color:#04476a !important;
}
.success_bg{
    background-color: #0447 !important;
}
.status_btn{
    border-radius: 0px !important;
    pointer-events: none;
}

.nav_top{

    margin-top:.2rem;
}
.btn-sbmt{
    background-color:#04476a !important;

}

.status{

    background-color: red;
    height: 20px;
    width: 3.8rem;
    height: 1.6rem;

}

.form_wizard{
    width: 80%;
    margin: 1rem auto;
}

.cnt_prsn_section{
    margin-top: 1.2rem;
    background-color:#f7f7f7;
    padding: 0.6rem;
    width: 100%;
    margin-left: 0;

}

.description {
border-spacing: 0px;
border-collapse: separate;
border-top: 1px solid #999;

}

.required:after {
    content:" *";
    color: red;
  }

.description tr td {
border-bottom: 1px solid #999;
padding: 8;
}
.description  th  {
padding: 8;
border-bottom: 1px solid #999;
}

.structure_html{
    display: flex;
    flex-direction: horizontal;
    margin-left: 2rem;
}


/* COLLAPSIBLE ACCORDION */


/* END */

</style>
          <nav aria-label="breadcrumb" style="width: 100%">
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Students Management</a></li>
                <li class="breadcrumb-item active" aria-current="page">Students</a></li>
                <li class="breadcrumb-item active" aria-current="page">Registration</a></li>
              </ol>
          </nav>
  
@endsection 

@section('content-body')
    
    <!-- SOME TEST -->
    
    <div class="form_wizard" style="width: 100%">
    <div class="container">
    
    
        <div class="card">
    
        <div class="card-header">
            
        </div>
        <div class="card-body">
        <div class="row">
            <div class="col-md-3" id="step-nav">
                <h5 class="text-center">Steps</h5>
                <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                        <a  class="nav-link active"  href="#step-1" data-toggle="pill"> <i class="font_icon d-none fas fa-check"></i> Personal Details</a>
                    </li>
                    <li class="nav-item nav_top">
                        <a class="nav-link" href="#step-2" data-toggle="pill"><i class="font_icon d-none fas fa-check"></i> Contact Person Details</a>
                    </li>
                    <li class="nav-item nav_top">
                        <a class="nav-link" href="#step-3" data-toggle="pill"> <i class="font_icon d-none fas fa-check"></i> Class Details</a>
                    </li>
                    <li class="nav-item nav_top">
                        <a class="nav-link" href="#step-4" data-toggle="pill"> <i class="font_icon d-none fas fa-check"></i> Attachments</a>
                    </li>
                    <li class="nav-item nav_top">
                        <a class="nav-link" href="#step-5" data-toggle="pill"> <i class="font_icon d-none fas fa-check"></i>Settings</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9">
    <div class="tab-content">
    <div id="step-1" class="tab-pane active">
        <!-- form 1 -->
        <form id="form-1" class="form-container">
            <div class="loader_gif d-none">
                <img style="max-width:15%" src="{{ asset('assets/images/cupertino_loader.gif') }}" alt="">
            </div>
    
    <div class="row">
        <div class="col-md-4">
            <div  class="form-group">
                <label for="">Admission Number</label>
                <input readonly type="text" value="1" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-md-4">
            <div  class="form-group">
                <label for="">Admission Date</label>
                <input type="date" data-must="1" name="admitted_year" id="admitted_year" class="form-control form-control-sm">
            </div>
        </div>
        
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="First Name">First Name: <span class="required"></span></label>
                <input data-must="1" type="text" name="first_name" class="form-control form-control-sm" id="first_name">
                <input type="hidden" name="stdnt_id" id="stdnt_id" class="form-control form-control-sm">
                
             </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="Middle Name">Middle Name: <span class="required"></span></label>
                <input type="text" name="middle_name" class="form-control form-control-sm" id="middle_name">
             </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="Last Name">Last Name: <span class="required"></span></label>
                <input data-must="1" type="text" name="last_name" class="form-control form-control-sm" id="last_name">
             </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="Address">Address:</label>
                <input type="text" name="address" id="std_address" class="form-control form-control-sm" id="address">
                <input type="hidden" name="std_address_id" id="std_address_id">
             </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="Phone">Phone:</label>
                <input type="text" name="phone" id="std_phone" class="form-control form-control-sm" id="phone">
                <input type="hidden" name="std_contact_id" id="std_contact_id" class="form-control form-control-sm" id="phone">
             </div>
             <input type="hidden" name="account_id" id="account_id">
             <input type="hidden" name="std_phone_id" id="std_phone_id">
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="Email">Email: </label>
                <input type="email" name="email" id="std_email" class="form-control form-control-sm" id="email">
                <input type="hidden" name="std_email_id" id="std_email_id">

             </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="Date of Birth">Date of Birth: <span class="required"></span></label>
                <input data-must="1" type="date" name="dob" id="std_dob" class="form-control form-control-sm" id="dob">
             </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="Gender">Gender: <span class="required"></span></label>
                <select data-must="1" name="gender" id="std_gender" class="form-control form-control-sm" id="">
                    <option value="male">male</option>
                    <option value="female">female</option>
                </select>
             </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Category <span class="required"></span></label>
                <select data-must="1" name="student_category" id="student_category" class="form-control form-control-sm class_select">
                    <option value="1">BASIC</option>
                    <option value="2">STAFF</option>
                </select>
             </div>
        </div>

    </div>

    {{-- <span style="float:right">
    <button type="button" id="portal_sbmit" style="background-color:#04476a !important"  class=" wizard_btns btn btn-sm btn-primary next-step"> <i class="fa fa-tick"></i>Next</button>
    </span> --}}
    
    </form>
    
    </div>
    
    
    <!-- STEP TWO -->
    <div id="step-2" class="tab-pane">
    
    <form id="form-2" class="form-container">
        <div class="loader_gif d-none">
            <img style="max-width:15%" src="{{ asset('assets/images/cupertino_loader.gif') }}" alt="">
        </div>
    
    <div id="contact_person_details_div">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Father's Name">Father's Name:</label>
                    <input type="text" name="father_name" class="form-control form-control-sm" id="fname">
                    <input type="hidden" name="father_contact_id" id="father_contact_id">
                    <input type="hidden" name="father_id" id="father_id">
                    <input type="hidden" name="student_id" id="student_id" class="student_id">

                 </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Occupation">Occupation:</label>
                    <input name="father_occupation" id="father_occupation" class="form-control form-control-sm" id=""/>
                 </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="Phone">Phone:</label>
                    <input type="number" name="father_phone" id="father_phone" class="form-control form-control-sm"/>
                 </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="MOther's Name">Mother's Name:</label>
                    <input type="text" name="mother_name" id="mother_name" class="form-control form-control-sm">
                    <input type="hidden" name="mother_contact_id" id="mother_contact_id">
                    <input type="hidden" name="mother_id" id="mother_id">
                 </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Occupation">Occupation:</label>
                    <input name="mother_occupation" id="mother_occupation" class="form-control form-control-sm" id=""/>
                 </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="Phone">Phone:</label>
                    <input type="number" name="mother_phone" id="mother_phone" class="form-control form-control-sm"/>
                 </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Father's Name">Guardian's Name:</label>
                    <input type="text" name="guardian_name" id="guardian_name" class="form-control form-control-sm" id="fname">
                    <input type="hidden" name="guardian_contact_id" id="guardian_contact_id">
                    <input type="hidden" name="guardian_id" id="guardian_id">
                 </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Occupation">Occupation:</label>
                    <input name="guardian_occupation" id="guardian_occupation" class="form-control form-control-sm" id=""/>
                 </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="Phone">Phone:</label>
                    <input type="number" name="guardian_phone" id="guardian_phone" class="form-control form-control-sm"/>
                 </div>
            </div>
        </div>
         </div>
                       
    </form>
                    {{-- <span style="float:right">
                    <!-- <button type="button" class=" wizard_btns btn btn-secondary btn-sm prev-step">Prev</button> -->
        <button type="button" style="background-color:#04476a !important;" class=" wizard_btns btn btn-primary btn-sm next-step">Next</button>
                </span> --}}
    
    </div>



    {{-- NEW STEP 3 --}}

    <div id="step-3" class="tab-pane">
        <form id="form-3" action="" class="form-container" >
            <div class="loader_gif d-none">
                <img style="max-width:15%" src="{{ asset('assets/images/cupertino_loader.gif') }}" alt="">
            </div>
            
        <div class="row" id="form-3_div">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Class">Class:</label>
                    <select data-must="1" name="students_class" id="class_select" style="width: 100%" class="class_select form-control form-control-sm" required>
                        <option value="">Select Class</option>
                        @foreach ($classes as $class )
                        <option value="{{$class->id}}">{{$class->name}}</option>
                        @endforeach
                    </select>
                 </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="streams">Stream:</label>
                    <select name="students_stream" id="stream_select" style="width: 100%" class="class_select form-control form-control-sm">
                        <option value="">Select Stream</option>
                        @foreach ($streams as $stream )
                        <option value="{{$stream->id}}">{{$stream->name}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="student_id" id="student_id" class="student_id">
                 </div>
            </div>
    </div>
        {{-- <span style="float: right;">
        <!-- <button type="button" class=" wizard_btns btn btn-secondary btn-sm prev-step">Prev</button> -->
        <button type="button" style="background-color:#04476a !important;" class=" wizard_btns btn btn-primary btn-sm next-step">Next</button>
        </span>  --}}
        </form>
    </div>
    
    <!-- STEP 4 -->

    <div id="step-4" class="tab-pane">

        <table id="customers" class="table">
            <thead class="thead-light">
                <tr>
                    <th>Attachment Type  / Aina ya Kiambatanisho </th>
                    <th>Status</th>
                    <th style="width: 9%;"> </th>
                  </tr>
            </thead>
         
          <tr class="att_cover">
            <td class="attach_type">Passport</td>
            <td>
            <button id="btn-1" type="button" class="btn btn-sm btn-warning status_btn"> <i class="fa-sharp fa-solid fa-circle-xmark"></i> Not Attached    </button>
            <input type="hidden" name="to_next" id="to_next">
            <input type="hidden" name="student_id" id="student_id" class="student_id">
        </td>
            <td> <button type="button" class="btn btn-sm btn-sbmt text-white attach"  data-title="TIN" style="font-size: 0.77rem; height:25px"> Attach </button>  </td>
          </tr>
          <tr class="att_cover">
            <td class="attach_type">Birth Certificate</td>
            <td> 
            <button id="btn-2" type="button" class="btn btn-sm btn-warning status_btn"> <i class="fa-sharp fa-solid fa-circle-xmark"></i> Not Attached    </button>
            </td>
            <td> <button type="button"  class="btn btn-sm btn-sbmt text-white attach" data-title="Truck Card" style="font-size: 0.77rem; height:25px"> Attach </button> </td>
          </tr>        
          </tr>
        </table>
        <span class="text-danger" id="attachment_error" style="float: left; margin-top:1rem">
        
        
        </span>
        {{-- <span style="float: right;">
        <!-- <button type="button" class=" wizard_btns btn btn-secondary btn-sm prev-step">Prev</button> -->
        <button type="button" style="background-color:#04476a !important;" class=" wizard_btns btn btn-primary btn-sm next-step">Next</button>
        
        </span> --}}
          
        </div>
    
    
    
    <!-- STEP FOUR -->
    
    <div id="step-5" class="tab-pane">
    
        <form id="form-5" action="" class="form-container" >
    
        <div class="row">
    <div class="col-md-12">
    <div class="loader  text-center">
          <div class="spinner-border my-auto iphone-loader">
             <span class="sr-only">Loading...</span>
          </div>
       </div>
    </div> 
    </div>
        <div class="row" id="settings_part">
            <div class="col-md-12">

                <table class="table">
                    <tr>
                        <td>Enable SMS Features</td>
                    <td> <input id="student_is_sms_checked" name="student[is_sms_enabled]" type="checkbox">  </td>
                    </tr>

                    <tr>
                        <td>Assign Transport</td>
                    <td> <input id="student_is_sms_checked" name="student[is_sms_enabled]" type="checkbox">  </td>
                    </tr>

                    {{-- <img align="absmiddle" alt="Loader" border="0" id="loader2" src="/images/loader.gif?60630d2a1025b2d1855181295e0dc963" style="display: none;"> --}}
                </table>
            </div>
    <div class="col-md-4">
        <div class="form-group">
            <input type="hidden" name="client_id" class="client_id">
            <input type="hidden" name="class_id" id="class_id" class="class_id">
            <input type="hidden" name="student_id" id="student_id" class="student_id">
        </div>
        
    </div>

    </div>
    <span style="text-align: center"> <p style="font-size: .8rem;
        color: darkslateblue;
        background: #e1e1e1;"> Assigned Fees Structure For Student  </p>  </span>

        <div class="structure_html">
            <div id="innerHTML"></div>

    </div>
   
        </form>
    </div>
    <!-- </form> -->
    </div>
    </div>
    </div>
    
    ​</div>

    <div class="card-footer">
        <span style="float: right;">
            <!-- <button type="button" class=" wizard_btns btn btn-secondary btn-sm prev-step">Prev</button> -->
            <button type="button" id="finalize_btn" class=" wizard_btns btn btn-sm btn-success d-none">Finish</button>
                <button type="button" style="background-color:#04476a !important;" class=" wizard_btns btn btn-primary btn-sm next-step">Next</button>
            </span>
    </div>
    
    </div>
            
    </div>
    
    <div class="modal fade" tabindex="-1" role="dialog" id="attachments_modal" >
      <div class="modal-dialog"  role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="1">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="multipart_form" enctype="multipart/form-data" class="form-content">
    <div class="col-md-12">
    <div class="loader d-none text-center">
          <div class="spinner-border my-auto iphone-loader">
             <span class="sr-only">Loading...</span>
          </div>
       </div>
    </div> 
            <div class="mb-12">
           <input class="form-control form-control-sm" style="height: 45px; font-size:10px;" name="file_attach" id="file_attach" type="file">
           <input type="hidden" class="class_hidden" name="type" id="type">
           <input type="hidden" name="client_id" class="client_id">
            </div>  
            </form>
     
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-sm btn-sbmt" id="upload"> <i class="fa-solid fa-upload"></i>Upload</button>
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('scripts')
$(document).ready(function() {
    var currentStep = 1;
    var totalSteps = 5;
    $('.next-step').click(function() {
        
     if (validateStep(currentStep)) {
            $(this).addClass("disabled"); 
            {{-- $('#step-' + currentStep).removeClass('active') --}}
            $('#step-' + currentStep).find('.font_icon').removeClass('d-none');
            if(currentStep == 1){
                let form = $('#form-1')[0];
                let form_data = new FormData(form);
                $('.loader_gif').removeClass("d-none"); 
                {{-- cupertino_loader.gif --}}
                 $.ajax({
                     url: '{{ route('students.registration.wizard.store')  }}',
                   type: "POST",
                      timeout: 250000,
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: form_data,
                    dataType:'JSON',

                     success:function(response){
                        $('.loader_gif').addClass("d-none");
                        $('.next-step').removeClass('disabled');
                        $('.student_id').val(response.student.id);
                        if(response.state=='Done'){
                        $('#step-' + currentStep).removeClass('active');
                        $('#step-nav a[href="#step-' + currentStep + '"]').addClass('success_bg').addClass('text-white');
                        $('#step-nav a[href="#step-' + currentStep + '"]').find('.font_icon').removeClass('d-none').addClass('text-white');
                        currentStep++;
                        $('#step-' + currentStep).addClass('active');
                        $('.nav-link').removeClass('active');
                        $('#step-nav a[href="#step-' + currentStep + '"]').addClass('active'); 

                        
                        }
                    }
             
        })
    } 
             if(currentStep == 2){
                $(this).addClass("disabled");
                $('.loader_gif').removeClass("d-none");
                let form = $('#form-2')[0];
                let form_data = new FormData(form); 

                         $.ajax({
                            url: '{{  route('students.registration.wizard.contact_person.store') }}',
                        type: "POST",
                            timeout: 250000,
                            processData: false,
                            contentType: false,
                            cache: false,
                            data: form_data,
                            dataType:'JSON',

                            success:function(response){
                                $('.loader_gif').addClass("d-none");
                                $('.next-step').removeClass('disabled'); 
                             
                                    if(response.state=='Done'){
                                        $('#step-' + currentStep).removeClass('active');
                                        $('#step-nav a[href="#step-' + currentStep + '"]').addClass('success_bg').addClass('text-white');
                                        $('#step-nav a[href="#step-' + currentStep + '"]').find('.font_icon').removeClass('d-none').addClass('text-white');
                                        currentStep++;
                                        $('#step-' + currentStep).addClass('active');
                                        $('.nav-link').removeClass('active');
                                        $('#step-nav a[href="#step-' + currentStep + '"]').addClass('active'); 
                                        }
                             
                        }
                        });
                    } 
            

                    if(currentStep == 3){
                        $(this).addClass("disabled");
                        $('.loader_gif').removeClass("d-none");
                        let form = $('#form-3')[0];
                        let form_data = new FormData(form); 
                                 $.ajax({
                                    url: '{{  route('students.registration.wizard.class.stream.store') }}',
                                type: "POST",
                                    timeout: 250000,
                                    processData: false,
                                    contentType: false,
                                    cache: false,
                                    data: form_data,
                                    dataType:'JSON',
        
                                    success:function(response){
                                        {{-- console.log('now response',response); --}}
                                        $('.loader_gif').addClass("d-none");
                                        $('.next-step').removeClass('disabled'); 
                                            if(response.state=='Done'){
                                                $('.class_id').val(response.class_id);
                                                $('#step-' + currentStep).removeClass('active');
                                                $('#step-nav a[href="#step-' + currentStep + '"]').addClass('success_bg').addClass('text-white');
                                                $('#step-nav a[href="#step-' + currentStep + '"]').find('.font_icon').removeClass('d-none').addClass('text-white');
                                                currentStep++;
                                                $('#step-' + currentStep).addClass('active');
                                                $('.nav-link').removeClass('active');
                                                $('#step-nav a[href="#step-' + currentStep + '"]').addClass('active'); 
                                                }
                                        
                                       {{-- console.log(response); --}}
                                }
                                });
                            }

                            if(currentStep == 4){
                                $(this).addClass("disabled");
                                $('.loader_gif').removeClass("d-none");
                                let form = $('#form-2')[0];
                                let form_data = new FormData(form); 
                
                                         $.ajax({
                                            url: '{{  route('students.registration.wizard.contact_person.store') }}',
                                        type: "POST",
                                            timeout: 250000,
                                            processData: false,
                                            contentType: false,
                                            cache: false,
                                            data: form_data,
                                            dataType:'JSON',
                
                                            success:function(response){
                                                $('.loader_gif').addClass("d-none");
                                                $('.next-step').removeClass('disabled'); 
                                                
                                                    if(response.state='Done'){
                                                        $('#step-' + currentStep).removeClass('active');
                                                        $('#step-nav a[href="#step-' + currentStep + '"]').addClass('success_bg').addClass('text-white');
                                                        $('#step-nav a[href="#step-' + currentStep + '"]').find('.font_icon').removeClass('d-none').addClass('text-white');
                                                        currentStep++;
                                                        $('#step-' + currentStep).addClass('active');
                                                        $('.nav-link').removeClass('active');
                                                        $('#step-nav a[href="#step-' + currentStep + '"]').addClass('active'); 

                                                        $('#finalize_btn').removeClass('d-none');
                                                        $('.next-step').addClass('d-none');



                                                        {{-- QUERY FEE STRUCTURE --}}

                                                        $.ajax({

                                                            url:"{{ route('students.registration.wizard.fee.structure')  }}",
                                                            type:"POST",
                                                            data:{
                                                                class_id : $('.class_id').val()
                                                            },
                                                            success:function(response){
                                                                console.log(response)
                                                                $('.structure_html').html(response);

                                                            },
                                                            error:function(response){

                                                                console.log(response);
                                                                
                                                            }



                                                        });



                                                        }
                                               
                                        }
                                        });
                                    }




        }

    })
    
});

    $('.prev-step').click(function() {
    if(currentStep > 1) {
        $('#step-' + currentStep).removeClass('active');
        currentStep--;
        $('#step-' + currentStep).addClass('active');
        $('.nav-link').removeClass('active');
        $('#step-nav a[href="#step-' + currentStep + '"]').addClass('active');
    }
});



function validateStep(step) {
    var isValid = true;

if(step == 4){

    return isValid;
{{-- let btn1_text = $('#btn-1').text().trim();
let btn2_text = $('#btn-2').text().trim();
let btn3_text = $('#btn-3').text().trim();

console.log('btn_1_text' + btn1_text)
console.log('btn_2_text' + btn2_text)
console.log('btn_3_text' + btn3_text) --}}

{{-- if(btn1_text == 'Attached' || btn1_text =='Imeambatanishwa' && btn2_text == 'Attached' || btn2_text == 'Imeambatanishwa' && btn3_text == 'Attached' || btn3_text == 'Imeambatanishwa' ){
    $('#to_next').val(1);
   return isValid;
}else{
    $('#to_next').val('');
    isValid = false;
    $('#attachment_error').html('<i class="fa-solid fa-circle-exclamation"></i> &nbsp; <?= $this->lang->line('error_attachment_upload') ?>');
} --}}
}else{

    let elements = $("#form-" + step).find("input, select");
   elements.each(function() {
        if ( $(this).data('must') &&  !$(this).val()) {
            isValid = false;
            $(this).addClass('is-invalid');
        }
        else {
            $(this).removeClass('is-invalid');
        }
    });
    return isValid;
}
}



{{-- var $j = jQuery.noConflict();
$j(document).ready(function() {
  $j("#admitted_year").datepicker();
}); --}}



$('.attach').each(function(){
    let btn = $(this);
    $('.loader').addClass("d-none");
    btn.click(function (params) {
        let title_text = btn.data('title'); 
        let modal_clone = $('#attachments_modal');
        modal_clone.find('.modal-title').text(title_text);
        modal_clone.find('.class_hidden').val(title_text);
        modal_clone.modal('show');
        $('#multipart_form')[0].reset();
    });
    
    });


    $('#upload').click(function(){
        let btn = $(this);
        btn.addClass("disabled");
        $('.loader').removeClass("d-none");
        let form = $('#multipart_form')[0];
        let form_data = new FormData(form);
        if (form_data) {
        {{-- $.ajax({
    
            type:'POST',
            processData: false,
            contentType: false,
            data:form_data,
            // type:'JSON',
            url:'<?= base_url('app/save_attachment') ?>',
    
            success:function(response){
                $('.loader').addClass("d-none");
                $('#upload').removeClass('disabled');
               $('.att_cover').each(function(){
                let type = JSON.parse(response).type;
                 if($(this).children('.attach_type').text() == type){
                    console.log('kweli');
                    let success_upload = `<i class="fa-sharp fa-solid fa-circle-check"></i> Attached`;
                    $(this).find('.status_btn').removeClass('btn-warning').addClass('btn-success').html(success_upload);
    
                 } 
    
                 $('#attachments_modal').modal('hide');
               });
                
                // console.log(JSON.parse(response).type);
        
    
            },
            error:function(response){
                console.log(response);
            }
    
    
    
        }); --}}
    
    }

    
    });

    $(document).ready(function () {
        $('.accordion-toggle').on('click', function(event){
            event.preventDefault();
            // create accordion variables
            var accordion = $(this);
            var accordionContent = accordion.next('.accordion-content');
    
            // toggle accordion link open class
            accordion.toggleClass("open");
            // toggle accordion content
            accordionContent.slideToggle(250);
    
        });
    });
    


@endsection