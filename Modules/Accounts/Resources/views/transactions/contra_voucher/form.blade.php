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
              <li class="breadcrumb-item active" aria-current="page">Finance Management</a></li>
              <li class="breadcrumb-item "> <a href="{{ route('accounts.contra.voucher.index')  }}"> Contra Voucher</a></li>
              <li class="breadcrumb-item active" aria-current="page">New</a></li>
              <li class="ml-auto"> <a id="comment" style="color: #551a8b !important" href="{{route('configurations.users.manual')}}"><i class="fa fa-comments"></i> Support</a></li>
            </ol>
          </nav>
  

@endsection 


@section('content-body')

<div class="card" style="width: 100%; border-top: 4px solid #00a65a;">
  <div class="card-header">Contra Voucher</div>
  <div class="card-body">

      <form action="#" id="contra_voucher">
          @csrf
          <div class="row">
            <div class="col-md-6"> </div>
              <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Voucher No.</label>
                        <input type="text" name="voucher_no" value={{ $voucher_no  }} id="voucher_no" class="form-control form-control-sm" readonly>
                    </div>  

                </div>
  
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Date</label>
                        <input type="text" name="date" id="date" class="form-control form-control-sm">
                    </div>  
                   
                </div>
                </div>

            <div class="row">      
            <div class="col-md-12">
              <table class="custom-table" style="width: 100%; margin-left: 3%">
                <thead>
                    <tr style="background: rgba(5,86,158,0) !important; border-bottom: solid #2b303b">
                        <th style="width: 20%; color: #2b303b">Account</th>
                        <th style="width: 50%; color: #2b303b">Description</th>
                        <th style="width: 15%; color: #2b303b; text-align: right">Debit</th>
                        <th style="width: 15%; color: #2b303b; text-align: right">Credit</th>
                        <th style="width: 15%; color: #2b303b; text-align: right"> </th>
                    </tr>
                </thead>
                <tbody id="voucher_items" style="background-color: rgba(5,86,158,0)">
                <tr>
                    <td style="height: 0 !important;" colspan="4">&nbsp;</td>
                </tr>
                        <tr>
                        <td style="height: 0 !important;">
                            <select required="" name="accounts[]" class="form-control form-control-sm account">
                                <option value="" >Select Account</option>
                                @foreach($ledgers as $ledger)
                                <option  value={{ $ledger->id  }} > {{  $ledger->name   }} </option>
                                @endforeach
                                 </select>
                        </td>
                        <td><input required="" type="text" name="description[]" class="form-control form-control-sm" placeholder="Description for service"></td>
                        <td><input style="text-align: right" type="text" class="form-control form-control-sm debit" name="debit[]" placeholder="0.00"></td>
                        <td><input style="text-align: right" type="text" class="form-control form-control-sm credit" name="credit[]" placeholder="0.00"></td>
                    </tr>
                      <tr>
                        <td style="height: 0 !important;">
                            <select required="" name="accounts[]" class="form-control form-control-sm account">
                                <option value="" selected="selected" disabled="">Select Account</option>    
                                @foreach($ledgers as $ledger)
                                <option  value={{ $ledger->id  }} > {{  $ledger->name   }} </option>
                                @endforeach                                          
                            </select>
                        </td>
                        <td><input required="" type="text" name="description[]" class="form-control form-control-sm" placeholder="Description for service"></td>
                        <td><input style="text-align: right" type="text" class="form-control form-control-sm debit" name="debit[]" placeholder="0.00"></td>
                        <td><input style="text-align: right" type="text" class="form-control form-control-sm credit" name="credit[]" placeholder="0.00"></td>
                    </tr>
                
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
              
                </tbody>
              
                <tfoot style="background: rgba(5,86,158,0) !important">
                    <tr style="border-bottom: solid #2b303b">
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <th colspan="2" style="width: 70%; text-align:right">TOTAL</th>
                        <th id="total_debit" style="width: 15%; font-size:14px; color: #2b303b; text-align: right; padding-right:9px">0.00</th>
                        <th id="total_credit" style="width: 15%; font-size:14px; color: #2b303b; text-align: right; padding-right:9px;">0.00</th>
                    </tr>
                </tfoot>
              
              </table>
            </div>
           
            </div> 
            
            <div class="row" style="margin-top:30px">
              <div class="col-md-12">
                <div class="form-group">
                  <textarea placeholder="Description" name="description" class="form-control" id="exampleFormControlTextarea1" rows="2"></textarea>
                </div>
              </div>
            </div>


        </form>

      <span class="float-right">
          <a type="button" id="register" class="btn btn-primary btn-sm">Submit</a>
        </span>
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


var $j = jQuery.noConflict();
 $("#date").datepicker().datepicker("setDate", new Date());


{{-- FILTERS --}}


$("#filter_checkbox").change(function() {


    if(this.checked) {
        $('#toggleFilters').removeAttr('style','display:none').css({'margin-top':'2%'});
    }else{
        $('#toggleFilters').css({'display':'none'});
    }
 });

 $('#class_filter').select2({width:'100%'});

 
 $('#register').click(function(e){
    {{-- alert('uwii'); --}}
    e.preventDefault();
    let form_data = $('#contra_voucher').serialize();


$.ajax({
    type: "POST",
    url: "{{  route('accounts.contra.voucher.store')  }}",
    data:form_data,
    {{-- dataType: "JSON", --}}
    success: function (response) {

        console.log(response);

        if(response.state == 'Done'){
            window.location.replace('{{route('accounts.contra.voucher.index') }}');
            
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
            toastr.error('Internal server Error', 'error');
        }
        
    }
}); 
}); 

$('.account').select2({width:'100%'});

$('.debit').keyup(function(event){
    let elem = $(this);
    let value = $(this).val();
    let type = 'DEBIT';
    
   if (event.which >= 37 && event.which <= 40) return;
   numberWithCommas(elem);
   

     if($(this).val()){
     
    $(this).closest('tr').find('.credit').attr('readonly', '').trigger('change');

    }
    else{

        $(this).closest('tr').find('.credit').removeAttr('readonly').trigger('change');
       

    }

    calculateTotal(type,elem);

 });

 $('.credit').keyup(function(event){
    let elem = $(this);
    let value = $(this).val();
    let type = 'CREDIT';
    
   if (event.which >= 37 && event.which <= 40) return;
   numberWithCommas(elem);
   
    if($(this).val()){
        $(this).closest('tr').find('.debit').attr('readonly', '').trigger('change');
    }
    else{

        $(this).closest('tr').find('.debit').removeAttr('readonly').trigger('change');
    }
    calculateTotal(type,elem);

 });


 function calculateTotal(type,elem){

     let debit_total_elem = $('#total_debit');
     let credit_total_elem = $('#total_credit');
     let credit_total = parseFloat(0);
     let debit_total = parseFloat(0);

    if(type == 'DEBIT'){

        elem.each(function(ind){

            debit_total += parseFloat($(this).val().replaceAll(',',''));
            debit_total_elem.html(debit_total);

        })

    }
    else{

        $(elem).each(function(indx){

            credit_total += parseFloat($(this).val().replaceAll(',',''));
            credit_total_elem.html(credit_total);

        });

    }

    if(parseFloat(credit_total_elem.text()) == parseFloat(debit_total_elem.text())){

        credit_total_elem.css({'background-color':'#0da75e !important'})
        debit_total_elem.css({'background-color':'#0da75e !important'})
        $('#register').removeAttr('disabled').trigger('change');
        {{-- console.log() --}}

    }else{

        credit_total_elem.css({'background-color':'#c26565 !important'})
        debit_total_elem.css({'background-color':'#c26565 !important'})
        $('#register').attr('disabled','');

    }    

}




@endsection




