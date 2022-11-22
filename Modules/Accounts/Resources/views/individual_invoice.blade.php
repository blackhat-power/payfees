@extends('dashboard')

@section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
        <div class="navbar-breadcrumb">
            <h4 class="mb-0">Invoices</h4>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">invoices</li>
                </ul>
            </nav>
        </div>

    </div>
  
</div> 
@endsection


@section('content-body')


<div class="card" style="width: 100%" >
   
    @php                              
    $student = Modules\Registration\Entities\AccountStudentDetail::find(auth()->user()->student_id);
    $class_id = $student->account_school_details_class_id;
    $acc_id = $student->account_id;
    $std_id = $student->id;

    @endphp

    <div class="card-header border-bottom">
        {{-- <a href="{{route('accounts.invoices.student.create',[$class_id,$acc_id,$std_id])}}"  id="register" type="button" class=" btn btn-primary btn-sm float-right" ><i class="fa fa-plus-circle"></i> New </a> --}}
        <span>
            <input type="checkbox" id="filter_checkbox" class="checkbox-input float-left" style="width: 30px; height: 30px;">
           Filters
        </span>
        <span class="float-right" style="margin-right:1%">
            <a href="javascript:void(0)" title="excel" onclick="generateFile('excel')"  style="color:white" class="btn btn-success btn-sm"> <i class="fa fa-file-excel"></i>        </a>
            <a href="javascript:void(0)" title="pdf" onclick="generateFile('pdf')" style="color:white" class="btn btn-warning btn-sm"><i class="fa fa-print"></i></a>
        </span>
        <form id="filter_form">
        <div class="row" style="margin-top:2%; display:none" id="toggleFilters" >
            <div class="col-md-3">
                <select name="year_filter" id="year_filter_id" class="form-control form-control-sm">
                    <option value="">Select Academic Year</option>
                    @foreach($seasons as $season)
                   <option value="{{$season->id}}">{{$season->name}}</option>
                    @endforeach
                </select>   
            </div>
            <div class="col-md-1" style="margin-top: 0.2%">
                <a title="clear" href="javascript:void(0)" class="btn btn-info btn-sm" id="clear"><i class="fa fa-refresh"></i></a>
            </div>
        </div> 
    </form>
    </div>


    <div class="card-body">
         <div class="table-responsive"> 
            <table id="new_invoices_table" class="table table-striped table-bordered table-sm" width="100%" style="table-layout: inherit">
                <thead>
                <tr>
                    <th>Date</th>
                  <th>Invoice Number</th>
                  <th>Amount</th>
                    <th>Paid</th>
                    <th>Due</th>
                  <th>Action</th>
                </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th colspan="3" style="text-align: right">TOTAL</th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>
                    </tr>
                </tfoot>

            </table>
         </div> 

    </div>
 </div>



          <!-- Modal -->
          <div class="row" style="width: 100%">
            <div class="col-md-12">
                <div class="modal" tabindex="-1" role="dialog" id="payment_details_modal">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Payment Details</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-striped" id="receipts_tbl" style="width: 100%; table-layout: fixed;">
                                <thead>

                                    <tr>
                                        <th>SN</th>
                                        <th style="width:9em">Date</th>
                                        <th>Method</th>
                                        <th style="width:9em;">Amount</th>
                                        <th>Ref.</th>
                                        <th>Document</th>
                                        <th style="width:8em;">Action</th>
                                    </tr>

                                </thead>


                            <tbody>
                                

                            </tbody>

                            </table>


                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
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

$('#year_filter_id').change(function(){

    invoices_table.draw();

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

$('#student_search').select2({
})



var invoices_table = $('#new_invoices_table').DataTable({
     processing: false,
    serverSide: true,
     ajax:{
         url : '{{ route('accounts.invoices.individual.datatable',$the_id) }}',

         data: function (d) {
            d.year_id = $('#year_filter_id').val();
        }
     },

     columns:[
        {data: 'date', name:'date'},
        {data: 'invoice_number', name:'invoice_number'},
        {data: 'amount', name:'amount'},    
        {data: 'paid', name:'paid'},
        {data: 'balance', name:'balance'},
        {data:'action', name:'action', orderable:false, searchable:false}
    ],
    "columnDefs": [
        { className: " text-right font-weight-bold", "targets": [ 2 ] },
        { className: "text-blue text-right font-weight-bold", "targets": [ 3 ] },
        { className: "text-danger text-right font-weight-bold", "targets": [ 4 ] }
      ],

      "drawCallback":function(){
        $('form.ajax-pay').on('submit', function(ev){
            ev.preventDefault();
            submitForm($(this),'store',invoices_table)
             invoices_table.ajax.reload();
            var form_id = $(this).attr('id');
        });

        $('.payment_details').click(function(e){
            e.preventDefault();
            startSpinnerOne();

            let invoice_id = $(this).data('invoice_id');
            let init_url = '{{ route('accounts.receipts.table',':id')}}';
            let url = init_url.replace(':id',invoice_id);
            $.ajax({

                url:url,
                type:'POST',

                success: function(response){
                    let table = $("#receipts_tbl tbody");
                    table.empty();
                    $.each(response.receipts, function(indx, elem){
                        console.log(elem.receipt_date);
                        let init_url = '{{ route('accounts.receipt.pdf',[':id',':rcpt']) }}';
                        let url = init_url.replace(':id',elem.rcpt_invoice_id).replace(':rcpt',elem.receipt_id);
                        console.log(url);
                        table.append(`<tr> <td> ${++indx} </td> <td> ${ elem.receipt_date }</td> <td></td> <td style="text-align: right;"> ${(elem.amount_paid).toLocaleString()}</td> <td>  </td>  <td></td> <td style="width: 8em">
                            <a href="${url}" target="_blank" title="Print" class="btn btn-primary btn-xs"><i class="fa fa-print"></i></a>
                            </td> </tr>` );
                    });
                    console.log(response);
                }

            });

            $('#payment_details_modal').modal('show');


            stopSpinnerOne();
            

        })

      },

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




