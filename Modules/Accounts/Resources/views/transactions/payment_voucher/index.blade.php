@extends('layouts.app')


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
              <li class="breadcrumb-item active" aria-current="page">Accounts</a></li>
              <li class="breadcrumb-item active" aria-current="page">Finance Management</a></li>
              <li class="breadcrumb-item active" aria-current="page">Payment Voucher</a></li>
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
  
    <div class="card-header border-bottom">
        <span>
            <input type="checkbox" id="filter_checkbox" class="checkbox-input float-left" style="width: 30px; height: 30px;">
           Filters
        </span>
        <span class="float-right">
            <a href="javascript:void(0)" title="excel" onclick="generateFile('excel')"  style="color:white" class="btn btn-success btn-sm"> <i class="fa fa-file-excel"></i>&nbsp;Excel</a>
            <a href="javascript:void(0)" title="pdf" onclick="generateFile('pdf')" style="color:white" class="btn btn-warning btn-sm"><i class="fa fa-print"></i>&nbsp;Pdf</a>
            <a href="{{ route('accounts.payment.voucher.form') }}" title="new payment voucher"  id="register" type="button" class=" btn btn-primary btn-sm" ><i class="fa fa-plus-circle"></i>&nbsp;New Payment Voucher</a>
        </span>
        <form id="filter_form">
        <div class="row" style="margin-top:2%; display:none" id="toggleFilters" >
            <div class="col-md-3">
                <select name="class_filter" id="class_filter" class="form-control form-control-sm">
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                   <option value="{{$class->id}}">{{$class->name}}</option>
                    @endforeach
                </select>   
            </div>

            <div class="col-md-3">
                <select name="stream_filter" id="stream_filter" class="form-control form-control-sm">
                    <option value="">Select Stream</option>
                </select>
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-3" style="margin-top: 1%">
                <div class="form-group">
                    <label class="control-label text-right" for="From">FROM:</label>
                    <input type="date" name="from_date" id="from_date" class="form-control date form-control-sm">
                </div>
            </div>

            <div class="col-md-3" style="margin-top: 1%">
                <div class="form-group">
                    <label for="To">TO:</label>
                    <input type="date" name="to_date" id="to_date" class="form-control date  form-control-sm">
                </div>
            </div>
        
            <div class="col-md-1" style="margin-top: 3.5%">
                <a title="clear" href="javascript:void(0)" class="btn btn-info btn-sm" id="clear"><i class="fa fa-refresh"></i></a>
            </div>
            
        </div> 
    </form>
    </div>


    <div class="card-body">
         <div class="table-responsive "> 
            <table id="payment_voucher" class="table table-striped table-bordered table-sm" width="100%" style="table-layout: inherit">
                <thead>
                <tr>
                    <th>Date</th>
                    <th> No </th>
                      <th> Payee </th>
                        <th> Description </th>
                          <th> Payment Method </th>
                  <th>Amount</th>
                  <th> </th>
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


    let url = '{{ route('accounts.invoices.printouts') }}';
    url = url+"?file_type="+file_type+"&class_id="+class_id+"&stream_id="+stream_id;
    window.open(url,'_blank');   
    console.log(url);

}


{{-- FILTERS --}}


$("#filter_checkbox").change(function() {


    if(this.checked) {
        $('#toggleFilters').removeAttr('style','display:none').css({'margin-top':'2%'});
    }else{
        $('#toggleFilters').css({'display':'none'});
    }
 });

 $('#class_filter').select2({width:'100%'});


let payment_voucher_table = $('#payment_voucher').DataTable({
    processing: false,
   serverSide: true,
    ajax:{
        url : '{{ route('accounts.payment.voucher.datatable') }}',

        {{-- data: function (d) {
           d.from_date = $('#from_date').val();
           d.to_date = $('#to_date').val();
           d.class_id = $('#class_filter').val(),
           d.stream_id = $('#stream_filter').val()
       } --}}
    },

    columns:[
       {data: 'date', name:'date'},
       {data: 'reference', name:'reference'},
       {data: 'payee', name:'payee'},
       {data: 'remarks', name:'remarks'},    
       {data: 'payment_method', name:'payment_method'},
       {data: 'amount', name:'amount'},
       {data:'action', name:'action', orderable:false, searchable:false}
   ],
   "columnDefs": [
    { className: " text-right font-weight-bold", "targets": [ 5 ] },
    { className: " text-center font-weight-bold", "targets": [ 6 ] }
       {{-- ,
       { className: "text-blue text-right font-weight-bold", "targets": [ 4 ] },
       { className: "text-danger text-right font-weight-bold", "targets": [ 5 ] } --}}
     ],

});


@endsection




