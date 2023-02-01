@extends('layouts.app')
@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Students Management</a></li>
                <li class="breadcrumb-item active" aria-current="page">Students</a></li>
              </ol>
          </nav>
  
@endsection 

@section('content-body')
            <div class="card" style="width: 100%">
                <div class="card-header border-bottom">
                    <span>
                        <input type="checkbox" id="registration_checkbox" class="checkbox-input float-left" style="width: 30px; height: 30px;" id="excel_upload_checkbox">
                       Register By Excel 
                    </span>
                  
            <span class="float-right">
                        <a href="javascript:void(0)" title="excel"  style="color:white" onclick="generateFile('excel')" class="btn btn-success btn-sm"> <i class="fa fa-file-excel"></i> Excel </a>
                        <a href="javascript:void(0)" title="pdf" onclick="generateFile('pdf')" style="color:white"  class="btn btn-warning btn-sm"><i class="fa fa-print"></i> Pdf </a>
                        <a type="button"title="add student" href="{{ route('students.registrationPortal')   }}"   {{-- id="register" --}} type="button" class=" btn btn-sm btn-primary" style="color: white;"><i class="fa fa-plus-circle"></i> New Student </a>
                    </span>
        <div class="card-body">
          <div class="collapse" id="collapsible_div">   
            
                <div class="container-fluid">            
                        <form method="post" id="import_form" action="{{ route('students.excel.import')  }}" enctype="multipart/form-data">
                            @csrf
                        <div class="row" id="row_border" style="margin-top:2%;">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="row"> 
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                        <a    
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="download excel template"
                                                href="{{ route('students.registration.excel')  }}" class="btn btn-secondary btn-sm">Download Excel Template </a>
                                        </div>

                                      </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                        <select name="class_filter" id="class_filter_upload" class="form-control form-control-sm" required>
                                            <option value="">Select Class</option>
                                            @foreach($classes as $class)
                                            <option value="{{$class->id}}">{{$class->name}}</option>
                                             @endforeach
                                        </select> 
                                    </div>  
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                        <select name="stream_filter" id="stream_filter_upload" class="form-control form-control-sm">
                                            <option value="">Select Stream</option>
                                        </select>
                                    </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                        <input type="file" id="myFile" name="students_excel">
                                    </div>
                                    </div>

                                    <div class="col-md-12">
                                        <a type="submit"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="upload excel"
                                        class="btn btn-primary btn-default btn-sm float-right" id="import" style="color:#fff" name="import" value="Import"><i class="fa fa-upload "></i>
                                        </a>
                                    </div>
                                  

                                </div>
                            </div>
                        </div>
                        </form>

                    </div>
            </div>
                   
                   </div>

        <form id="f_clr">
            <div class="row" style="margin-bottom:1%; margin-top:1%">
                <div class="col-md-3">
                    <select name="class_filter" id="class_filter" class="form-control form-control-sm">
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                        <option value="{{$class->id}}">{{$class->name}}</option>
                         @endforeach
                    </select>   
                </div>

                <div class="col-md-3">
                    
                    <select name="stream_filter_id" id="stream_filter" class="form-control form-control-sm">
                        <option value="">Select Stream</option>
                    </select>

                </div>
                <div class="col-md-1" style="margin-top: 0%">
                    <a title="clear" href="javascript:void(0)" class="btn btn-info btn-sm" id="clear"><i class="fa fa-refresh"></i></a>
                </div>
            </div>


        </form>
                   
                </div>
                
                <div class="container-fluid">
                    <div class="table-responsive" style="margin-top: 1%">
                        <table id="students_datatable" class="table table-sm table-striped table-bordered" width="100%" style="table-layout: inherit">
                            <thead>
                            <tr>
                                <th>avatar</th>
                                <th>full name</th>
                                <th>Class</th>
                                <th>Stream</th>
                                <th>gender</th>
                                <th>dob</th>
                                <th>action</th>
                            </tr>
                            </thead>
                        </table>
                  
            </div>
        </div>
        </div>

    {{--    Registration Modal     --}}

 @include('registration::student.partials.registration_modal')

@endsection

@section('scripts')

$('#class_filter_upload').select2({width:'100%'});
$('#stream_filter_upload').select2({width:'100%'});


$('#class_filter_upload').change(function(){
    let class_id = $(this).val();
    $.ajax({
        url:'{{ route('students.to_class.filter') }}',
        data:{
            class_id : class_id
        },
        success: function(response){

             $('#stream_filter_upload').html(response);

        }

    });

})

$('#import').click(function(){

    let form = $('#import_form');
    let formData = new FormData(form[0]);

    {{-- $('#student_container').waitMe({}); --}}

    startSpinnerOne();

   $.ajax({

    url: '{{ route('students.excel.import')  }}',
    type: 'POST',
     data:formData,
    enctype: 'multipart/form-data',
    cache: false,
    contentType: false,
    processData: false,


    success: function (response) {
        if(response.state == 'Done'){
            console.log(response);
            students_datatable.ajax.reload();
            toastr.success(response.msg, response.title);  
        }

        else if(response.state == 'Fail'){
            toastr.warning(response.msg, response.title)

        }
        else if(response.state == 'Error'){
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

students_datatable=$('#students_datatable').DataTable({
    processing: true,
    serverSide: true,

     ajax:{

         url : '{{ route('students.datatable') }}',

         data: function (d) {
            d.class_id = $('#class_filter').val(),
            d.stream_id = $('#stream_filter').val()
        },

     },


     columns:[
        {data:'avatar', name:'avatar'},
         {data: 'full_name', name:'full_name'},
         {data:'class_name', name:'class_name'},
         {data:'stream_name', name:'stream_name'},
         {data:'gender', name:'gender'},
         {data:'dob', name:'dob'},
         {data:'action', name:'action', orderable:false, searchable:false}
     ],

     drawCallback:function(){
         
         
         {{-- $('.statusChange').click(function(){
            
            let student_id = $(this).data('student_id');
            let isActive = $(this).prop('checked') ? 1 : 0;
            console.log(student_id)

            $.ajax({

                url:'{{ route('student.update.status') }}',
                type:'POST',
                data:{
                    student_id : student_id,
                    status: isActive
                },

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
                },

                error:function(res){
                    console.log(res);

                }

            });

            if(isActive){
                $('#fa_ban').attr('style','display:none');
                $('#fa_tick').attr('style','display:block');
            }
            else{
                $('#fa_tick').attr('style','display:none');
                $('#fa_ban').attr('style','display:block');
            }
            
         }); --}}
     }
});


$('#clear').click(function(){
    let form = $('#f_clr');
    clearForm(form);
    $('#class_filter').select2('destroy').val('').select2({width:'100%'});
    students_datatable.draw();

})

$('#class_filter').change(function(){
    let class_id = $(this).val();

    $.ajax({
        url:'{{ route('students.to_class.filter') }}',
        data:{
            class_id : class_id
        },
        success: function(response){

             $('#stream_filter').html(response);

        }

    });

    students_datatable.draw();
});

$('#stream_filter').change(function(){

    students_datatable.draw();

});

$('#class_filter').select2({width:'100%'})

$('#register').click(function(){
    let form = $('#student_registration_form');
    clearForm(form);
    $('#students_registration').modal('show');
    
});

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
            students_datatable.ajax.reload();
            toastr.success(response.msg, response.title);  
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


$('body').on('click','.statusChange', function(){

    {{-- let checkbox =  $(this).parent().find('.checkbox'); --}}
    let student_id = $(this).data('student_id');
    let isActive = $(this).prop('checked') ? 1 : 0;
      console.log(student_id);
  
      $.ajax({
  
          url:'{{ route('student.update.status') }}',
          type:'POST',
          data:{
              student_id : student_id,
              status: isActive
          },
  
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
          },
  
          error:function(res){
              console.log(res);
  
          }
  
      });
  
      if(isActive){
          $('#fa_ban').attr('style','display:none');
          $('#fa_tick').attr('style','display:block');
      }
      else{
          $('#fa_tick').attr('style','display:none');
          $('#fa_ban').attr('style','display:block');
      }
  
  });

  

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  $('#class_select').select2({
      width:'100%'
  });

  $('#class_select').change(function(){
      let class_id = $(this).val();

    $.ajax({

        url:'{{ route('students.to_class.filter') }}',

        data:{

            class_id : class_id

        },

        success: function(response){

            $('#stream_select').html(response);

        }

    })

  });



  $('#stream_select').select2({
      width:'100%'
  })


  $("#registration_checkbox").change(function() {
    if(this.checked) {
        $('#collapsible_div').collapse('show');
        {{-- $('#excel_template_display').removeAttr('style');
        $('#row_border').attr('style','margin-top:2%'); --}}
    }else{
        $('#collapsible_div').collapse('hide');
        {{-- $('#excel_template_display').attr('style','display:none') --}}
    }
});



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



function generateFile($file_type){

    let class_id = $('#class_filter').val();
    let stream_id = $('#stream_filter').val();
    let file_type = $file_type;


    let url = '{{ route('students.printouts') }}';
    url = url+"?file_type="+file_type+"&class_id="+class_id+"&stream_id="+stream_id;
    window.open(url,'_blank');   
    console.log(url);

}


$('body').on('click','.stdDltBtn',(function(e){
    e.preventDefault();
    let student_id = $(this).data('student_id');
    let init_url = "{{ route('students.registration.delete', 'id') }}"
    let url = init_url.replace('id',student_id);
   
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
                type: "DELETE",
                url: url,
        
                success: function (response) {
                    if(response.state == 'Done'){
                        students_datatable.ajax.reload();
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
      })
}));







@endsection