@extends('layouts.app')

@section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
        <div class="navbar-breadcrumb">
            <h4 class="mb-0">Student Payments</h4>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Student Payments</li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection
@section('content-body')
    <div class="container-fluid">

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-bottom">

                    <span>
                        <input type="checkbox" id="filter_checkbox" class="checkbox-input float-left" style="width: 30px; height: 30px;">
                       Filters
                    </span>

            <span class="float-right">
                        <a href=""  style="color:white" class="btn btn-success btn-sm"> <i class="fa fa-file-excel"></i>        </a>
                        <a onclick="generateFile('pdf')" style="color:white" target="_blank" class="btn btn-warning btn-sm"><i class="fa fa-print"></i></a>
                    </span>
            
            
                    <div class="row" style="margin-top:2%; display:none" id="toggleFilters" >
                        <div class="col-md-3">
                            <select name="class_filter" id="class_filter" class="form-control form-control-sm">
                                <option value="">Select Class</option>
                                @foreach ($my_classes as $class )

                                            <option value="{{$class->id}}">{{ $class->name }}</option>
                                                
                                            @endforeach
                            </select>   
                        </div>
            
                        {{-- <div class="col-md-3">
                            <select name="stream_filter" id="stream_filter" class="form-control form-control-sm">
                                <option value="">Select Stream</option>
                            </select>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="students_datatable" class="table table-sm table-striped table-bordered" width="100%" style="table-layout: inherit">
                            <thead>
                            <tr>
                                <th>avatar</th>
                                <th>full name</th>
                                <th>billed Amount</th>
                                <th>action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
   

@endsection

@section('scripts')

$('#filter_class').select2({ width:'100%'   });
$('#class_filter').select2({ width:'100%' });

$("#filter_checkbox").change(function() {
    if(this.checked) {
        $('#toggleFilters').removeAttr('style','display:none').css({'margin-top':'2%'});
    }else{
        $('#toggleFilters').css({'display':'none'});
    }
 });
 

 students_datatable=$('#students_datatable').DataTable({
    processing: true,
    serverSide: true,
     ajax:'{{ route('accounts.students.payments.datatable') }}',
     columns:[
        {data:'avatar', name:'avatar'},
         {data: 'name', name:'name'},
         {data:'billed_amount', name:'billed_amount'},
         {data:'action', name:'action', orderable:false, searchable:false}
     ],
});

@endsection