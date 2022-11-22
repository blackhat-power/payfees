@extends('dashboard')


@section('content-heading')



    
          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Accounts</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payments Review</a></li>
              </ol>
          </nav>
  
@endsection 


@section('content-body')


<div class="card" style="width: 100%" >

    <div class="card-header border-bottom">
        {{-- <a href="{{ route('accounts.invoices.create') }}"  id="register" type="button" class=" btn btn-primary btn-sm float-right" ><i class="fa fa-plus-circle"></i> </a> --}}
        <span>
            <input type="checkbox" id="filter_checkbox" class="checkbox-input float-left" style="width: 30px; height: 30px;">
           Filters
        </span>
        <span class="float-right">
            <a href="javascript:void(0)" title="excel" onclick="generateFile('excel')"  style="color:white" class="btn btn-success btn-sm"> <i class="fa fa-file-excel"></i>   Excel     </a>
            <a href="javascript:void(0)" title="pdf" onclick="generateFile('pdf')" style="color:white" class="btn btn-warning btn-sm"><i class="fa fa-print"></i>Pdf </a>
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
        
            <div class="col-md-1" style="margin-top: 39px">
                <a title="clear" href="javascript:void(0)" class="btn btn-info btn-sm" id="clear"><i class="fa fa-refresh"></i></a>
            </div>
            
        </div> 
    </form>
    </div>


    <div class="card-body">
         <div class="table-responsive "> 
            <table id="new_invoices_table" class="table table-striped table-bordered table-sm" width="100%" style="table-layout: inherit">
                <thead>
                <tr>
                    <th>Date</th>
                  <th>Invoice Number</th>
                  <th>Student</th>
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
                            <table class="table table-bordered table-striped table-sm" id="receipts_tbl" style="width: 100%; table-layout: fixed;">
                                <thead>

                                    <tr>
                                        <th style="width:2em;">SN</th>
                                        <th style="width:6em; text-align:center">Date</th>
                                        <th style="width:7em; text-align:center">Method</th>
                                        <th style="width:7em; text-align:center">Amount</th>
                                        <th style="width:7em; text-align:center">Ref.</th>
                                        <th style="width:9em; text-align:center">Status</th>
                                        <th style="width:4em; text-align:center">Doc*</th>
                                        <th style="width:4em; text-align:center">Action</th>
                                    </tr>

                                </thead>


                            <tbody>
                             
                            </tbody>

                            </table>


                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary btn btn-sm" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>

            </div>


@endsection

@include('shadows.custom_js')
@section('scripts')

    let elem = $('.date');
    DateLimit(elem);

$('#from_date').on('change', function(){

    startSpinnerOne();
    invoices_table .draw();  
    stopSpinnerOne();
     
});


$('#to_date').on('change', function(){

    startSpinnerOne();
    invoices_table .draw();  
    stopSpinnerOne();

});


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
    {{-- console.log(term_id); --}}
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

    });
 })


function generateFile($file_type){

    let class_id = $('#class_filter').val();
    let stream_id = $('#class_filter').val();
    let file_type = $file_type;
 
    let url = '{{ route('accounts.student.payments.review.printing') }}';
    url = url+"?file_type="+file_type+"&class_id="+class_id+"&stream_id="+stream_id;
    window.open(url,'_blank');   
    console.log(url);

}



$('#student_search').select2({
})


$('#class_filter').change(function(){
    let class_id  = $(this).val();

    $.ajax({
        url:'{{ route('students.to_class.filter') }}',
        data:{
            class_id : class_id
        },
        success: function(response){

             $('#stream_filter').html(response);

        }

    });

    invoices_table.draw();
});

$('#stream_filter').change(function(){
    invoices_table.draw();
});

$('#stream_filter').select2({width:'100%'})


var invoices_table = $('#new_invoices_table').DataTable({
     processing: false,
    serverSide: true,
     ajax:{
         url : '{{ route('accounts.student.payments.review.datatable') }}',

         data: function (d) {
            d.from_date = $('#from_date').val();
            d.to_date = $('#to_date').val();
            d.class_id = $('#class_filter').val(),
            d.stream_id = $('#stream_filter').val()
        }
     },

     columns:[
        {data: 'invoice_date', name:'invoice_date'},
        {data: 'invoice_number', name:'invoice_number'},
        {data: 'student_name', name:'student_ame'},
        {data: 'amount', name:'amount'},    
        {data: 'paid', name:'paid'},
        {data: 'balance', name:'balance'},
        {data:'action', name:'action', orderable:false, searchable:false}
    ],
    "columnDefs": [
        { className: " text-right font-weight-bold", "targets": [ 3 ] },
        { className: "text-blue text-right font-weight-bold", "targets": [ 4 ] },
        { className: "text-danger text-right font-weight-bold", "targets": [ 5 ] }
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
                    if(response.receipts.length !==0 ){
                        $.each(response.receipts, function(indx, elem){
                            console.log(elem.receipt_date);
                            let init_url = '{{ route('accounts.receipt.pdf',[':id',':rcpt']) }}';
                            let url = init_url.replace(':id',elem.rcpt_invoice_id).replace(':rcpt',elem.receipt_id);
                            console.log(url);
    
                            let attachment_link = '';
                            let attachment_path = elem.path;
                            let status = elem.status_name;

                            let approval_buttons = '';
                            {{-- if (status == 'Analyst Processing') {
    
                                approval_buttons = `<button type="button" data-payment_id="${elem.id}" id="approve_yes" title="Approve" class="btn btn-success btn-xs">YES</button>
                                <button type="button"  title="Dont Approve" data-payment_id="${elem.id}" id="approve_no" class="btn btn-danger btn-xs">NO</button> `;
                            } --}}

                            if(attachment_path){
                                attachment_link = `<a href="{{asset('storage')}}/${attachment_path}" target="_blank" class="" style="margin-left:30%" title="View Attachment"><i class="fa fa-download"></i></a>`;
                            }
    
                            table.append(`<tr> <td> ${++indx} </td> <td> ${ elem.receipt_date }</td> <td></td> <td style="text-align: right;"> ${(elem.amount_paid).toLocaleString()}</td> <td></td> <td> ${status}  </td> 
                                 <td> ${attachment_link}  </td>
                                   <td style="width: 8em">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown" aria-expanded="false"> <i class="fas fa-bars"></i> <i class="fas fa-caret-down"></i>
                                            </a>
                                    
                                            <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 18px, 0px);">
                                                   <button type="button"  id="approve_yes" data-payment_id = "${elem.receipt_id}" style="margin-left: -9px;"  class="dropdown-item"><i class="btn btn-success btn-sm fa fa-check-circle"></i> Approve</button>
                                                    <button type="button"  id="approve_no" data-payment_id= "${elem.receipt_id}" class="dropdown-item"><i class="btn btn-danger btn-sm fa fa-times-circle"></i> Reject </button>
                                            </div>
                                        </div>
                                    </div>
            
                                </td> </tr>` );
                        });
                        console.log(response.receipts);
                    }
                    else{
                        table.append('<tr><td></td> <td style="text-align: center" class="text-danger" colspan="5">NO PAYMENTS MADE</td>  </tr>');
                    }
                
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
            .column( 3 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            
    var receiptAmountTotal = api
            .column( 4)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            
    var balanceTotal = api
            .column( 5)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        
            
        // Update footer by showing the total with the reference of the column index 
   {{--  $( api.column( 0 ).footer() ).html('Total'); --}}
        $( api.column( 3 ).footer() ).html(billAmountTotal.toLocaleString());
        $( api.column( 4 ).footer() ).html(receiptAmountTotal.toLocaleString());
        $( api.column( 5 ).footer() ).html(balanceTotal.toLocaleString());
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



 $('body').on('click','#approve_yes', function (e) {

    e.preventDefault();
    let payment_id = $(this).data('payment_id');
    let init_url = "{{route('accounts.student.payments.review.update',[':id'])}}";
    let url = init_url.replace(':id',payment_id);
    $.ajax({
    type: "POST",
    url: url,
    data: {
            status_id : 3,
        },
    dataType: "JSON",
    success: function (response) {
        console.log(response);
        if (response.state == 'Done') {

            toastr.success(response.msg, response.title)
            $('#payment_details_modal').modal('hide');
            invoices_table.draw();
            
        }

        if (response.state == 'Fail') {

        toastr.warning(response.msg, response.title)

        }

        if (response.state == 'Error') {

            toastr.error(response.msg, response.title)

            }

            
    },

    error:function(response){

        if (response.status == 500) {

        toastr.error('Internal Server Error', 'error')

        }


    }
});


});



$('body').on('click','#approve_no', function (e) {

e.preventDefault();
let payment_id = $(this).data('payment_id');
let init_url = "{{route('accounts.student.payments.review.update',[':id'])}}";
let url = init_url.replace(':id',payment_id);
$.ajax({
    type: "POST",
    url: url,
    data: {
            status_id : 2,
        },
    dataType: "JSON",
    success: function (response) {
        console.log(response);
        if (response.state == 'Done') {

            toastr.success(response.msg, response.title);
            $('#payment_details_modal').modal('hide');
            invoices_table.draw();
            
        }

        if (response.state == 'Fail') {

        toastr.warning(response.msg, response.title)

        }

        if (response.state == 'Error') {

            toastr.error(response.msg, response.title)

            }
    },

    error:function(response){

        if (response.status == 500) {

        toastr.error('Internal Server Error', 'error')

        }


    }
});

});

 





@endsection




