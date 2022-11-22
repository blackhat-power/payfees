@extends('dashboard')


@section('alerts-ground')

@if(Session::has('message'))

<div class="toast fade show bg-primary text-white border-0 rounded p-2" role="alert" aria-live="assertive" aria-atomic="true" style="width: 100%; display:none">
    <div class="toast-header bg-primary text-white">
       <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
       <span aria-hidden="true">×</span>
       </button>
    </div>
    <div class="toast-body">
        {{ Session::get('message') }}
    </div>
 </div>

<p class="alert {{ Session::get('alert-class', 'alert-info') }}" style="width: 100%; display:none">{{ Session::get('message') }}</p>

@endif
@endsection

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Account Settings</a></li>
              <li class="breadcrumb-item active" aria-current="page">Account Ledgers List</a></li>
              <li class="ml-auto"> <a id="comment" style="color: #551a8b !important" href="{{route('configurations.users.manual')}}"><i class="fa fa-comments"></i> Support</a></li>
            </ol>
          </nav>
  

@endsection 


@section('content-body')

{{-- <div id="center"  style=" top: 10%; left: 50%; position: absolute;"> --}}

    <div id="dialog" style="display: none;">
    </div>

    <div class="modal" id="pdf" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="modal_body">
            
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">Save changes</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

{{-- </div> --}}


<div class="card" style="width: 100%" >
   {{--  <div class="card-header d-flex justify-content-between">

       <div class="header-title">
       </div>
    </div> --}}
    <div class="card-header border-bottom">
        <span>
            <input type="checkbox" id="filter_checkbox" class="checkbox-input float-left" style="width: 30px; height: 30px;">
           Filters
        </span>
        <span class="float-right">
            <a href="javascript:void(0)" title="excel" onclick="generateFile('excel')"  style="color:white" class="btn btn-success btn-sm"> <i class="fa fa-file-excel"></i>&nbsp;Excel</a>
            <a href="javascript:void(0)" title="pdf" onclick="generateFile('pdf')" style="color:white" class="btn btn-warning btn-sm"><i class="fa fa-print"></i>&nbsp;Pdf</a>
            <a href="{{ route('accounts.ledgers.form') }}" title="new account"  id="register" type="button" class=" btn btn-primary btn-sm" ><i class="fa fa-plus-circle"></i>&nbsp;New Account</a>
        </span>
        <form id="filter_form">
        <div class="row" style="margin-top:2%; display:none" id="toggleFilters" >
            <div class="col-md-3">
                <select name="account_group" id="account_group" class="form-control form-control-sm">
                    <option value="">Account Group</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="account_name" id="account_name" class="form-control form-control-sm">
                    <option value="">Account Name</option>
                    
                </select>   
            </div>
            <div class="col-md-1">
                <a title="clear" href="javascript:void(0)" class="btn btn-info btn-sm" id="clear"><i class="fa fa-refresh"></i></a>
            </div>
            <div class="col-md-6"></div>
        
            
            
        </div> 
    </form>
    </div>


    <div class="card-body">
         <div class="table-responsive "> 
            <table id="ledgers_table" class="table table-striped table-bordered table-sm" width="100%" style="table-layout: inherit">
                <thead>
                <tr>
                  <th>ID</th>
                    <th>Name</th>
                    <th>Under</th>
                  <th>DR</th>
                  <th> CR </th>
                </tr>
                </thead>
            </table>
         </div> 
   

       

    </div>
 </div>


@endsection

@include('shadows.custom_js')
@section('scripts')


$('#clear').click(function(){
 let form = $('#filter_form');
    clearForm(form);

    startSpinnerOne();
    invoices_table .draw();  
    stopSpinnerOne();
});



function generateFile($file_type){

    let class_id = $('#class_filter').val();
    let stream_id = $('#class_filter').val();
    let file_type = $file_type;

    let url = '{{ route('accounts.ledgers.printouts') }}';
    url = url+"?file_type="+file_type+"&class_id="+class_id+"&stream_id="+stream_id;
    window.open(url,'_blank');   
    console.log(url);

}

var account_sub_group = $('#ledgers_table').DataTable({
    processing: false,
    serverSide: true,
     ajax:{
         url : '{{ route('accounts.ledgers.datatable') }}',

         data: function (d) {
            d.from_date = $('#from_date').val();
            d.to_date = $('#to_date').val();
            d.class_id = $('#class_filter').val(),
            d.stream_id = $('#stream_filter').val()
        }
     },

     columns:[
        {data:'ledger_id', name:'ledger_id'},
        {data: 'ledger_name', name:'ledger_name'},
        {data: 'sub_group_name', name:'sub_group_name'},
        {data: 'Dr', name:'Dr' ,className:'text-right'},
        {data: 'Cr', name:'Cr',className:'text-right'}
    ],

      "drawCallback":function(){}

    });
    

    $('#ledgers_table').on('draw.dt', function () {
        $('#ledgers_table').Tabledit({
        url: '{{ route('accounts.ledgers.store') }}',
        dataType: 'json',
        columns: {
        identifier: [0, 'ledger_id'],
        editable: [[1, 'ledger_name'],[2, 'sub_group_id', '{!! $sub_groups !!}'], [3, 'Dr' ], [4, 'Cr']  ]},

        restoreButton: false,
        onSuccess: function (data, textStatus, jqXHR) {
        $('#ledgers_table').DataTable().ajax.reload();
        {{-- $.ajax({
       
          url :  '{{  route('fee_type_groups.load')   }}',
          success:function(response){
             $('#fee_group').html(response);
          }
       
         }); --}}
        }
        });
        });
        


{{-- FILTERS --}}


$("#filter_checkbox").change(function() {


    if(this.checked) {
        $('#toggleFilters').removeAttr('style','display:none').css({'margin-top':'2%'});
    }else{
        $('#toggleFilters').css({'display':'none'});
    }
 });

 $('#class_filter').select2({width:'100%'});


    




@endsection




