


@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">

            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Finance Management</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fee Reminder Settings</a></li>
                 {{-- <li  class="breadcrumb-item"><a href="{{route('accounts.fee_structure.settings')}}">Fee Reminder Settings</a></li> --}}
                {{-- <li class="breadcrumb-item active" aria-current="page">New</a></li> --}}
              </ol>
          </nav>

@endsection


@section('content-body')
<div class="container">
    

    <div class="modal" tabindex="-1" role="dialog" id="fee_reminder_modal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #00a65a">
              <h5 class="modal-title">Add Fee Reminder</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="#" id="fee_reminder">
                 @csrf
                 <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" name="action" value="create">
                           <label for="">Class</label>
                           <select type="text" name="class" id="class" class=" academic form-control form-control-sm">
                              <option value=""></option>
                              @foreach ($classes as $class )
                                  <option value="{{$class->id}}">{{$class->name}}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" name="action" value="create">
                           <label for="">Academic Year</label>
                           <select type="text" name="academic_year" id="academic_year" class="academic form-control form-control-sm">
                              <option value=""></option>
                              @foreach ($academic_years as $year )
                              <option value="{{$year->id}}">{{$year->name}}</option>
                          @endforeach
                           </select>
                        </div>
                     </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" name="action" value="create">
                           <label for="">Bill Category</label>
                           <select type="text" name="category_id" id="bill_category" class="form-control form-control-sm">
                              <option value=""></option>
                              @foreach ($bill_categories as $category )
                              <option value="{{$category->id}}">{{$category->name}}</option>
                              @endforeach
                            
                           </select>
                        </div>
                     </div>
                    <div class="col-md-12">
                       <div class="form-group">
                           <input type="hidden" name="action" value="create">
                          <label for="">Semester</label>
                          <select type="text" name="semester" id="semester" class="form-control form-control-sm">
                             <option value=""></option>
                             @foreach ($semesters as $semester )
                                    <option value="{{ $semester->id }}"> {{ $semester->name }} </option>
                             @endforeach
                             
                          </select>
                       </div>
                    </div>
                    <div class="col-md-12">
                       <div class="form-group">
                           <input type="hidden" name="action" value="create">
                          <label for="">Amount</label>
                          <input type="text" name="amount" class="amount form-control form-control-sm">
                       </div>
                    </div>
                    <div class="col-md-12">
                       <div class="form-group">
                          <label for=""> Counter </label>
                          <input name="counter" type="number" class="form-control form-control-sm">
                       </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                           <label for=""> Period Btn Reminder </label>
                           <select name="period_btn_number" id="period_btn_number">
                            <option value="7"> 7 DAYS </option>
                            <option value="10"> 10 DAYS </option>
                            <option value="14">14 DAYS</option>
                            <option value="28"> 28 DAYS </option>
                           </select>
                        </div>
                     </div>
                 </div>
     
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary btn-sm" id="save_header">Save changes</button>
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>




<div class="card" style="border-top: 3px solid  #faa21c; width:100%;">
    <div class="card-header">
        Fee Reminder
       <span class=" float-right text-right"> <a class="btn btn-primary btn-sm" id="new_reminder_group"><i class="fa fa-plus"></i>  New Reminder  </a>  </span>
       </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table style="width: 100%" id="fee_reminder_setting">
                    <thead>
                       <tr>
                        <th style="width: 2% !important;">Code</th>
                          <th>N0</th>
                          <th>Semister</th>
                          <th>Amount</th>
                          <th>Counter</th>
                          <th>Period Between Reminders</th>
                       </tr>
                    </thead>
             
                    </table>  
            </div>
        </div>
     
    </div>
 </div>

</div>

 @endsection


 @section('scripts')

 var fee_reminder_table = $('#fee_reminder_setting').DataTable({
    processing: false,
   serverSide: true,
    ajax:{
        url : '{{ route('accounts.fee_reminder.datatable') }}',
        {{-- data: function (d) {
           d.from_date = $('#from_date').val();
           d.to_date = $('#to_date').val();
           d.class_id = $('#class_filter').val(),
           d.stream_id = $('#stream_filter').val()
       }   --}}
    },

    columns:[
       {data: 'id', name:'id'},
       {data: 'semester', name:'semester'},
       {data: 'amount', name:'amount'},
       {data: 'counter', name:'counter'},
       {data: 'period_btn_reminders', name:'period_btn_reminder'},
   ],
   "columnDefs": [ { className: " text-right font-weight-bold", "targets": [ 3 ] } ],
  "drawCallback":function(){},
  "footerCallback": function ( ) {},
   
 });

 $('.amount').keyup(function(event){
    let elem = $(this);
    let value = $(this).val();
    
   if (event.which >= 37 && event.which <= 40) return;
   numberWithCommas(elem);

 });



$('#save_header').click(function(){

let form_data =  new FormData($('#fee_reminder')[0]);

$.ajax({

type:'POST',
processData:false,
contentType: false, 
data: form_data,
url: '{{ route('accounts.fee_reminder.store') }}',
success: function (response) {
    if(response.state == 'Done'){
       toastr.success(response.msg, response.title);
       $('#fee_reminder_modal').modal('hide');
   }
   else if(response.state == 'Fail'){
       toastr.warning(response.msg, response.title)

   }
   else if(response.state == 'Error') {
       toastr.error(response.msg, response.title);
   }

},
error: function(response){
   if(response.status == 500){
    toastr.error('Server Error', 'error');
   }
}


});


});

$('.academic').select2({width:'100%'});


$('#new_reminder_group').click(function(){

    $('#fee_reminder_modal').modal('show');
});

$('#bill_category').select2({width:'100%'});
$('#semester').select2({width:'100%'});
$('#period_btn_number').select2({width:'100%'});


 @endsection





































