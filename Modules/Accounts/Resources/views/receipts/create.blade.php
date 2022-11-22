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
    <div class="card-body">
        <div class="container" style="margin-top:2%" >
            <form id="receipt_form">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4 float-right">
                        <div class="form-group">
                            <label for="">Date</label>
                                <input type="date" class="form-control form-control-sm" name="date" required>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="student">Student</label>
                            
                            <select name="student" id="student" class="form-control">
                                <option value="">Select Student</option>
                            @foreach ($students as $student )
                                <option value="{{ $student->id }}">{{ $student->first_name }} {{$student->last_name}}</option>
                            @endforeach
                            </select>  
                            
                           
                         </div>
                    </div>
    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="bill">Select Bill to Pay:</label>
                            <select name="bill_no" id="bill_no" class="form-control">
                                <option value=""></option>
                            </select>
                         </div>
                    </div>
                    

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" id="amount" class="form-control form-control-sm" readonly>
                         </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="paid">Paid</label>
                            <input type="text" id="paid_amount" class="form-control form-control-sm" readonly>
                         </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        {{-- <div class="input-group">
                            <div class="input-group-prepend">
                               <span class="input-group-text text-area">REMARKS</span>
                            </div>
                            <textarea name="remarks" class="form-control" aria-label="With textarea"></textarea>
                         </div> --}}
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Balance</label>
                            <input type="text" id="balance" class="form-control form-control-sm float-right" name="balance" id="">
                        </div>

                    </div>

                </div>

                <div  class="row" id="invoice_items_structure" style="display: none">

                    <div class="top-left p-4 shadow-showcase text-center">
                                <div class="row">
                                <div class="col-md-8"> </div>
                                <div class="col-md-4 float-right">
                                 <input  type="date" name="date" class="form-control">
                                </div>
                                </div>
                            <table>
                
                                <tbody id="fee_structure_tbody">
                                    
                                  
                                </tbody>
                                <tfoot>
                                <tr>
                                <th> TOTAL </th>
                                <th>   <input style="text-align:right" type="text" class="totalSum form-control" readonly>  </th>
                                </tr>
                                </tfoot>
                             </table>
                
                   
                            </div>
                </div>
                <div class="remarks" style="display: none; margin-top:4%">
                    <div class="input-group">
                        <div class="input-group-prepend">
                           <span class="input-group-text text-area">REMARKS</span>
                        </div>
                        <textarea name="remarks" class="form-control" aria-label="With textarea"></textarea>
                     </div>
                </div>
                
             </form>
            </div>    
    </div>

    <div class="card-footer">
        <span  class="float-right" >
            <button type="submit" id="save_receipt"  class="btn btn-sm btn-primary">Save</button>
            <button type="submit" class="btn btn-sm bg-secondary">Print</button>
        </span>
       
      </div>

 </div>


@endsection


@section('scripts')

$('#student').select2();
$('#bill_no').select2();

$('#student').change(function(){
    let student_id = $(this).val();
    console.log(student_id);
    $.ajax({
        type: "POST",
        url: "{{ route('accounts.receipts.invoices.filter')  }}",
        data: {
            'student_id' :student_id
        },
        {{-- dataType: "JSON", --}}
        success: function (response) {
            $('#bill_no').html(response);
        },
        error: function(response){
            
            console.log('error');

        }

})
});


$('#bill_no').change(function(){


    let invoice_id = $(this).val();
    console.log(invoice_id);
    $.ajax({
        type: "POST",
        url: "{{ route('accounts.receipts.selected.filter')  }}",
        data: {
            'invoice_id' :invoice_id
        },
        {{-- dataType: "JSON", --}}
        success: function (response) {
            {{-- $('#bill_no').html(response); --}}
            $('#amount').val(response.amount);
            $('#paid_amount').val(response.paid);
            console.log(response)
            let balance =parseFloat((response.amount).replace(/,/g, '')) - parseFloat((response.paid).replace(/,/g, ''));
            let final_balance = numberWithCommas(balance)

            $('#invoice_items_structure').removeAttr('style').html(

                response.invoice_items_html
            );
            $('#balance').val(final_balance);

            $('.remarks').removeAttr('style','display:none').attr('style','margin-top:4%;');
        },
        error: function(response){
            
            console.log('error');

        }

});

});

$('#balance').keyup( function(){

    let balance = $(this).val().toLocaleString("en-US");
let computed_balance = numberWithCommas(balance);
$(this).val(computed_balance)

}  
);

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
  
$('#save_receipt').click(function(e){
    e.preventDefault();

    let form = $('#receipt_form');
    let form_data = new FormData(form[0]);

$.ajax({
    type: "POST",
    url: "{{  route('accounts.receipts.store')  }}",
    data: form_data,
    processData:false,
    contentType:false,
  
    success: function (response) {
        console.log(response);
        {{-- window.location.replace(response); --}}
    }
}); 
}) 







{{-- END PAYMENTS --}}

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



$("#filter_checkbox").change(function() {
    if(this.checked) {
        $('#toggleFilters').removeAttr('style','display:none')
    }else{
        $('#toggleFilters').attr('style','display:none')
    }
});


@endsection




