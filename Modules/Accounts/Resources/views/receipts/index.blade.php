@extends('dashboard')

@section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
        <div class="navbar-breadcrumb">
            <h4 class="mb-0">Receipts</h4>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Receipts</li>
                </ul>
            </nav>
        </div>
    </div>
  
</div> 
@endsection


@section('content-body')


<div class="card" style="width: 100%" >
   {{--  <div class="card-header d-flex justify-content-between">

       <div class="header-title">
       </div>
    </div> --}}
    <div class="card-header border-bottom">
        
            <a href="{{ route('accounts.receipts.create') }}" id="register" type="button" class=" btn btn-sm btn-primary float-right" style="color: white"><i class="fa fa-plus-circle"></i> New </a>
        
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
            <table id="new_receipts_table" class="table table-striped table-bordered table-sm" width="100%" style="table-layout: inherit">
                <thead>
                <tr>
                <th>Date</th>
                  <th>Receipt No</th>
                  <th>Student Name</th>
                  <th>Bill No</th>
                  <th>Receipt Amount</th>
                  <th>Action</th>
                </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th colspan="3">&nbsp;</th>
                        <th>TOTAL</th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
         </div>  
    </div>

    <div class="top-right p-4"> 

    </div>
 </div>


@endsection


@section('scripts')

totalFee();
function totalFee(){
    var total = 0;
    $("input[type=checkbox]:checked").each(function() {
        total += parseFloat($(this).val());
    });
 
    $(".totalSum").val(total);
}


 $('.checkboxes').each(function(){
     $(this).click(function(){
        totalFee();
     });
 })


 $('#academic_season').on('change',function(){

    let season_id = $(this).val();
    $.ajax({
        type: "POST",
        url: "{{ route('accounts.invoices.filter.fee_structure')  }}",
        data: {
            'season_id' :season_id
        },
        dataType: "JSON",
        success: function (response) {

            console.log(response.fee_structure_html);

            $('#fee_structure_tbody').html(response.fee_structure_html);
            totalFee();
        },
        error: function(response){
            
            $('#fee_structure_tbody').html(response);

        }
    });

 });


 $('#term').change(function(){
    let term_id = $(this).val();
    console.log(term_id);
    $.ajax({
        type: "POST",
        url: "{{ route('accounts.invoices.filter.fee_structure')  }}",
        data: {
            'term_id' :term_id
        },
        dataType: "JSON",
        success: function (response) {

            console.log(response.fee_structure_html);

            $('#fee_structure_tbody').html(response.fee_structure_html);
            totalFee();
        },
        error: function(response){
            
            $('#fee_structure_tbody').html(response);

        }
    });
 })


 

$('#student_search').select2({
})


$('#new_receipts_table').DataTable({
     processing: true,
    serverSide: true,
     ajax:'{{ route('accounts.receipts.datatable') }}',
     columns:[
        {data: 'date', name:'date'},
        {data: 'receipt', name:'receipt'},
        {data: 'payer', name:'payer'},
        {data: 'reference', name:'reference'},
         {data: 'paid_amount', name:'paid_amount'},
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
            .column( 4 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            
  {{--   var receiptAmountTotal = api
            .column( 5 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 ); --}}           
        
            
        // Update footer by showing the total with the reference of the column index 
   {{--  $( api.column( 0 ).footer() ).html('Total'); --}}
        $( api.column( 4 ).footer() ).html(billAmountTotal.toLocaleString());
        {{-- $( api.column( 5 ).footer() ).html(receiptAmountTotal.toLocaleString()); --}}
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




