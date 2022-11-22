@extends('layouts.app')
@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Student Managment</a></li>
              <li class="breadcrumb-item active" aria-current="page">Graduates</a></li>
            </ol>
          </nav>
  

@endsection 

{{-- @section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
        <div class="navbar-breadcrumb">
            <h4 class="mb-0">Students Registration</h4>
            <nav aria-label="breadcrumb" style="background-color: rgb(255, 249, 249)">
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Students</li>
                </ul>
            </nav>
        </div>
        <div class="btn-group btn-group-toggle">
            
            <a type="button" href="" id="register" data-toggle="modal" data-target="#students_registration" class="button btn btn-primary btn-sm mr-2"><i class="ri-add-line m-0"></i>Register</a> 
        </div>
    </div>
</div>
@endsection --}}


@section('content-body')

            <div class="card" style="width: 100%">
                <div class="card-header border-bottom">

                    <span>
                        <input type="checkbox" id="filter_checkbox" class="checkbox-input float-left" style="width: 30px; height: 30px;">
                       Filters
                    </span>
                    <span class="float-right" style="margin-right:1%">
                        <a href="javascript:void(0)"  style="color:white" title="excel"  class="btn btn-success btn-sm"> <i class="fa fa-file-excel"></i>  Excel      </a>
                        <a onclick="generateFile('pdf')" style="color:white !important" title="pdf" target="_blank" class="btn btn-warning btn-sm"><i class="fa fa-print" style="color: white"></i> Pdf </a>
                    </span>
            
            
                    <div class="row" style="margin-top:2%; display:none" id="toggleFilters" >
                     
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
                            <select name="graduated_year" id="graduated_year" class="form-control form-control-sm">
                                <option value="">Select Year</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="students_datatable" class="table table-sm table-striped table-bordered" width="100%" style="table-layout: inherit">
                            <thead>
                            <tr>
                                <th>avatar</th>
                                <th>full name</th>
                                <th>Class</th>
                                <th>Stream</th>
                                <th>gender</th>
                                <th>dob</th>
                                <th>Year Graduated</th>
                                <th>action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

@endsection

@section('scripts')

students_datatable=$('#students_datatable').DataTable({
    processing: true,
    serverSide: true,

    ajax:{

        url : '{{ route('students.graduates.datatable') }}',

        data:function(d){

            d.class_id = $('#class_filter_upload').val(),
            d.stream_id = $('#stream_filter_upload').val()
   
        },
    },
   
     columns:[
        {data:'avatar', name:'avatar'},
         {data: 'full_name', name:'full_name'},
         {data: 'class', name:'class'},
         {data: 'stream', name:'stream'},
         {data:'gender', name:'gender'},
         {data:'dob', name:'dob'},
         {data:'graduation_date', name:'graduation_date'},
         {data:'action', name:'action', orderable:false, searchable:false}
     ],

});


function generateFile($file_type){

    let class_id = $('#class_filter_upload').val();
    let stream_id = $('#stream_filter_upload').val();
    let file_type = $file_type;


    let url = '{{ route('students.printouts') }}';
    url = url+"?file_type="+file_type+"&class_id="+class_id+"&stream_id="+stream_id;
    window.open(url,'_blank');   
    console.log(url);

}

  

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  $('#class_select').select2({
      width:'100%'
  });

  $('#stream_select').select2({
      width:'100%'
  })


  $("#registration_checkbox").change(function() {
    if(this.checked) {
        $('#excel_template_display').removeAttr('style')
    }else{
        $('#excel_template_display').attr('style','display:none')
    }
});

$('#class_filter_upload').select2({width:'100%'});
$('#stream_filter_upload').select2({width:'100%'});

$("#filter_checkbox").change(function() {
    if(this.checked) {
        $('#toggleFilters').removeAttr('style','display:none').css({'margin-top':'2%'});
    }else{
        $('#toggleFilters').css({'display':'none'});
    }
 });


 $('#class_filter_upload').change(function(){
    let class_id = $(this).val();
    startSpinnerOne();
    $.ajax({
        url:'{{ route('students.to_class.filter') }}',
        data:{
            class_id : class_id
        },
        success: function(response){

             $('#stream_filter_upload').html(response);

        }
        
    });

    students_datatable.draw();

    stopSpinnerOne();

});

$('#stream_filter_upload').change(function(){

    students_datatable.draw();

});




@endsection