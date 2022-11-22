@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Accounts</a></li>
                <li  class="breadcrumb-item"><a href="{{route('accounts.debtors.list')}}">Debtors List</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$students_name}} Debts</a></li>
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
            <a href="javascript:void(0){{-- {{ route('accounts.debtors.individual.list.pdf',[encrypt($id)]) }} --}}" style="color:white" target="_blank" class="btn btn-warning btn-sm"><i class="fa fa-print"></i>Print</a>
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
            <table id="individual_debtors_list_table" class="table table-striped table-bordered table-sm" width="100%" style="table-layout: inherit">
                <thead>
                <tr>
                  <th>Date</th>
                  <th>Invoice Number</th>
                  <th style="text-align:right" >Billed Amount</th>
                  <th style="text-align:right" >Amount Paid</th>
                  <th style="text-align: right">Balance</th>
                  <th>Action</th>
                </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th colspan="2" style="text-align: right">TOTAL</th>
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


$('#save_bill').click(function(e){
    e.preventDefault();

    let form_data = $('#invoice_form').serialize();

$.ajax({
    type: "POST",
    url: "{{  route('accounts.invoices.store')  }}",
    data: form_data,
    dataType: "JSON",
    success: function (response) {
        
    }
}); 
}) 

$('#student_search').select2({
})

let url = '{{ route('accounts.individual.debtors.list.datatable',$id) }}'

$('#individual_debtors_list_table').DataTable({
     processing: true,
    serverSide: true,
     ajax:url,
     columns:[
        {data: 'invoice_date', name:'invoice_date'},
        {data: 'invoice_number', name:'invoice_number'},
        {data: 'billed_amount', name:'billed_amount', className: "text-right"},
        {data: 'paid_amount', name:'paid_amount', className: "text-right"},
        {data: 'balance', name:'balance', className: "text-right"},
        {data:'action', name:'action', orderable:false, searchable:false}
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
            .column( 2 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            
    var receiptAmountTotal = api
            .column( 3)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            
    var balanceTotal = api
            .column( 4)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        
            
        // Update footer by showing the total with the reference of the column index 
   {{--  $( api.column( 0 ).footer() ).html('Total'); --}}
        $( api.column( 2 ).footer() ).html(billAmountTotal.toLocaleString());
        $( api.column( 3 ).footer() ).html(receiptAmountTotal.toLocaleString());
        $( api.column( 4 ).footer() ).html(balanceTotal.toLocaleString());
    },

 
});






$("#filter_checkbox").change(function() {
    if(this.checked) {
        $('#toggleFilters').removeAttr('style','display:none')
    }else{
        $('#toggleFilters').attr('style','display:none')
    }
});


@endsection




