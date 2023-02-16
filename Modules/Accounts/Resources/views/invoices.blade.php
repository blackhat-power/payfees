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
              <li class="breadcrumb-item active" aria-current="page">Accounts</a></li>
              <li class="breadcrumb-item active" aria-current="page">Bills</a></li>
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
            <a href="{{ route('accounts.new.invoice.redo.create') }}" title="new invoice"  id="register" type="button" class=" btn btn-primary btn-sm" ><i class="fa fa-plus-circle"></i>&nbsp;New Invoice</a>
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


    let url = '{{ route('accounts.invoices.printouts') }}';
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
         url : '{{ route('accounts.invoices.datatable') }}',

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

        $(".toast").fadeTo(3000, 1,'swing',function(){
            $('.toast').slideUp(7000,'swing');
         });

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
                            if(attachment_path){
                                attachment_link = `<a href="{{asset('storage')}}/${attachment_path}" target="_blank" class="" style="margin-left:30%" title="View Attachment"><i class="fa fa-download"></i></a>`;
                            }
    
                            table.append(`<tr> <td> ${++indx} </td> <td> ${ elem.receipt_date }</td> <td></td> <td style="text-align: right;"> ${(elem.amount_paid).toLocaleString()}</td> <td></td> <td style="text-align:center"> ${elem.status_name}  </td> 
                                 <td> ${attachment_link}  </td>
                                   <td style="width: 8em; text-align:center">
                                <a href="${url}" target="_blank" title="Print" class="btn btn-warning btn-sm"><i class="fa fa-print"></i>Pdf</a>
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


    
{{-- $('body').on('click', '.invoice_print', function(){
            var fileName = "Mudassar_Khan.pdf";

            $(function () {
                $( "#dialog" ).dialog({
                  autoOpen: false
                });
                
                $("#opener").click(function() {
                  $("#dialog1").dialog('open');
                });
              }); --}}


                {{-- $("#dialog").dialog({
                    modal: true,
                    title: fileName,
                    width: 540,
                    height: 450,
                    buttons: {
                        Close: function () {
                            $(this).dialog('close');
                        }
                    },
                    open: function () {
                        var object = "<object data=\"{FileName}\" type=\"application/pdf\" width=\"500px\" height=\"300px\">";
                        object += "If you are unable to view file, you can download from <a href = \"{FileName}\">here</a>";
                        object += " or download <a target = \"_blank\" href = \"http://get.adobe.com/reader/\">Adobe PDF Reader</a> to view the file.";
                        object += "</object>";
                        object = object.replace(/{FileName}/g, "Files/" + fileName);
                        $("#dialog").html(object);
                    }
                }); --}}

{{-- }); --}}

{{-- $(function () { --}}
    {{-- $( "#dialog" ).dialog({
      autoOpen: false
    }); --}}
   

    {{-- $('body').on('click', '.invoice_print', function(){ --}}
        {{-- $.noConflict(); --}}
        var fileName = "Invoice.pdf";
        {{-- let id = $(this).data('inv_id');
        console.log(id);
        let file_url = '{{route('accounts.invoices.pdf',[':id'])}}'.replace(':id',id);
       
        let obj = `<iframe src="${file_url}" width="500" height="300"></iframe>`;
               
     
        $('#pdf').find('.modal-body').html(obj);
        $('#pdf').modal('show'); --}}

        {{-- $("#dialog").dialog({
            modal: true,
            title: fileName,
            width: 540,
            height: 450,
            buttons: {
                Close: function () {
                    $(this).dialog('close');
                }
            },
            open: function () {
                var object = "<object data=\"{FileName}\" type=\"application/pdf\" width=\"500px\" height=\"300px\">";
                object += "If you are unable to view file, you can download from <a href = \"{FileName}\">here</a>";
                object += " or download <a target = \"_blank\" href = \"http://get.adobe.com/reader/\">Adobe PDF Reader</a> to view the file.";
                object += "</object>";
                object = object.replace(/{FileName}/g, file_url);
               let obj = `<iframe src="${file_url}" width="500" height="300"></iframe>`;
                $("#dialog").html(obj);
            }
        });;

    });

  }); --}}
 





@endsection




