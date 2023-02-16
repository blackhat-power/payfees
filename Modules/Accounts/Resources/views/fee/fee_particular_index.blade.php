


@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">

            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">System Configurations</a></li>
                <li class="breadcrumb-item" aria-current="page"> <a href="{{ route('accounts.school.fee.structure.master') }}"> Fee Structure Settings </a></li>
                <li class="breadcrumb-item active" aria-current="page">Fee</a></li>
                 {{-- <li  class="breadcrumb-item"><a href="{{route('accounts.fee_structure.settings')}}">Fee Reminder Settings</a></li> --}}
                {{-- <li class="breadcrumb-item active" aria-current="page">New</a></li> --}}
              </ol>
          </nav>


          <style>

            .contents{

                display: flex;
                direction: horizontal;
                justify-content: space-around;
                align-items: left; 
                width: 100%;
               


            }
            .mg-top{
                margin-top: 1.4rem;
            } 

          </style>

@endsection


@section('content-body')
        </div>
    </div>
    <div class="card" style="100%">
        <div class="card-header">
            <span style="float: right">
                <button class="btn btn-primary btn-sm" id="elevate_modal">  New </button>
            </span>
        </div>

        <div class="card-body">

            <div class="table-responsive "> 
                <table id="particulars_table" class="table table-striped table-bordered table-sm" width="100%" style="table-layout: inherit">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                      <th>Action</th>
                    </tr>
                    </thead>
    
                </table>
             </div> 




             <div class="modal" tabindex="-1" role="dialog" id="fee_type_modal">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header" style="background-color: #00a65a">
                      <h5 class="modal-title"> Add Master Fee Particular  </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="#" id="fee_header_form">
                         @csrf
                         <div class="row">
                            <div class="col-md-12">
                               <div class="form-group">
                                   <input type="hidden" name="action" value="create">
                                  <label for=""> Name </label>
                                  <input type="text" name="name" id="particular_name" class="form-control form-control-sm">
                               </div>
                            </div>
                            <div class="col-md-12">
                                <div style="display: flex; direction:horizontal;">
                                    <span style=" font-size: .8rem;
                                    width: 100%;">Is Tuition Fee ?   &nbsp; &nbsp; </span>
                                    
                                    <input style="height: 1.4rem" name="is_tuition_fee" id="is_tuition_fee" type="checkbox" class="form-control form-control-sm">
                                </div>
                                   </span>
                                {{-- <div class="form-group">
                                   <label for=""> Is Tuition Fee </label>
                                  
                                </div> --}}
                             </div>
                            <div class="col-md-12">
                               <div class="form-group">
                                  <label for=""> Description </label>
                                  <input name="description" id="particular_description" type="text" class="form-control form-control-sm">
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


 @endsection


 @section('scripts')

 var particulars_table = $('#particulars_table').DataTable({
    processing: false,
   serverSide: true,
    ajax:{
        url : '{{ route('accounts.school.fee.structure.master.particulars.datatable') }}',

        {{-- data: function (d) {
           d.from_date = $('#from_date').val();
           d.to_date = $('#to_date').val();
           d.class_id = $('#class_filter').val(),
           d.stream_id = $('#stream_filter').val()
       } --}}
    },

    columns:[
       {data: 'name', name:'name'},
       {data: 'description', name:'description'},
       {data: 'action', name:'action'},
       {{-- {data: 'student_name', name:'student_ame'},
       {data: 'amount', name:'amount'},    
       {data: 'paid', name:'paid'},
       {data: 'balance', name:'balance'},
       {data:'action', name:'action', orderable:false, searchable:false} --}}
   ],
   "columnDefs": [
       { className: " text-right font-weight-bold", "targets": [ 2 ] },
       {{-- { className: "text-blue text-right font-weight-bold", "targets": [ 4 ] }, --}}
       {{-- { className: "text-danger text-right font-weight-bold", "targets": [ 5 ] } --}}
     ],

     "drawCallback":function(){


     },

});


$('#elevate_modal').click(function(){

  $('#fee_type_modal input').val('');

$('#fee_type_modal').modal('show');


});

$()


$('#save_header').click(function(){

let form = $('#fee_header_form')[0];
let form_data = new FormData(form);

$.ajax(
   {
    processData:false,
    contentType: false, 
    url:'{{ route('accounts.school.fee.structure.master.particulars.store')  }}',
    type:'POST',
    data:form_data,
    dataType: "JSON",
    success:function(response){
        if(response.state == 'Done'){
            toastr.success(response.msg, response.title);
            $('#fee_type_modal').modal('hide');
            particulars_table.draw();
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

})


 @endsection





































