@extends('layouts.app')

@section('content-heading')
    

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Accounts</a></li>
                <li class="breadcrumb-item active" aria-current="page">Debtors List</a></li>
              </ol>
          </nav>
@endsection


@section('content-body')


<div class="card" style="width: 100%" >
   {{--   <div class="card-header d-flex justify-content-between">

       <div class="header-title">
        
       </div>
      
    </div> --}}
    <div class="card-header border-bottom">
        <span class="float-right">
            <a href="{{ route('accounts.debtors.list.pdf') }}" style="color:white" target="_blank" class="btn btn-warning btn-sm"><i class="fa fa-print"></i>Pdf</a>
        </span>
        <span>
            <input type="checkbox" id="filter_checkbox" class="checkbox-input float-left" style="width: 30px; height: 30px;">
           Filters
        </span>


        <div class="row" style="margin-top:2%; display:none" id="toggleFilters" >
            <div class="col-md-3">
                <select name="class_filter" id="class_filter" class="form-control form-control-sm">
                    <option value="">Select Class</option>
                </select>   
            </div>

            <div class="col-md-3">
                <select name="stream_filter" id="stream_filter" class="form-control form-control-sm">
                    <option value="">Select Stream</option>
                </select>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="debtors_list_table" class="table table-striped table-bordered table-xs" width="100%" style="table-layout: inherit">
                <thead>
                <tr>
                  <th>Student Name</th>
                  <th>Billed Amount</th>
                  <th>Amount Paid</th>
                  <th>Balance</th>
                  <th>Action</th>
                </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th style="text-align: right">TOTAL</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
         </div>  
    </div>
 </div>


@endsection


@section('scripts')


$('#student_search').select2({
})


$('#debtors_list_table').DataTable({
     processing: true,
    serverSide: true,
     ajax:'{{ route('accounts.debtors.list.datatable') }}',
     columns:[
        {data: 'student_name', name:'student_name'},
        {data: 'billed_amount', name:'billed_amount'},
        {data: 'amount_paid', name:'amount_paid'},
        {data: 'balance', name:'balance'},
        {data:'action', name:'action', orderable:false, searchable:false}
    ],
    "columnDefs": [
        { className: " text-right font-weight-bold", "targets": [ 1 ] },
        { className: "text-blue text-right font-weight-bold", "targets": [ 2 ] },
        { className: "text-danger text-right font-weight-bold", "targets": [ 3 ] }
      ],


    "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // converting to interger to find total
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        // computing column Total of the complete result 
        let billAmountTotal = api
            .column( 1 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            
    var receiptAmountTotal = api
            .column( 2)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            
    var balanceTotal = api
            .column( 3)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        
            
        // Update footer by showing the total with the reference of the column index 
   {{--  $( api.column( 0 ).footer() ).html('Total'); --}}
        $( api.column( 1 ).footer() ).html(billAmountTotal.toLocaleString());
        $( api.column( 2 ).footer() ).html(receiptAmountTotal.toLocaleString());
        $( api.column( 3 ).footer() ).html(balanceTotal.toLocaleString());
    },

 
});


$("#filter_checkbox").change(function() {
    if(this.checked) {
        $('#toggleFilters').removeAttr('style','display:none').css({'margin-top':'2%'});
    }else{
        $('#toggleFilters').css({'display':'none'});
    }
 });


@endsection




