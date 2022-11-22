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
              <li class="breadcrumb-item active" aria-current="page">Transactions</a></li>
              <li class="breadcrumb-item">  <a href="{{  route('accounts.journal.voucher.index') }}"> Journal Voucher</a></li>
              <li class="breadcrumb-item active" aria-current="page">New</a></li>
              <li class="ml-auto"> <a id="comment" style="color: #551a8b !important" href="{{route('configurations.users.manual')}}"><i class="fa fa-comments"></i> Support</a></li>
            </ol>
          </nav>
  

@endsection 


@section('content-body')


<div class="card" style="width: 100%; border-top: 4px solid #00a65a;">
    <div class="card-header">Journal Voucher</div>
    <div class="card-body">
        <form action="#" id="journal_voucher">
            @csrf

            <div class="row table"> 
            <div class="col-md-3"> </div>
                <div class="col-md-3">
                      <div class="form-group">
                          <label for="">Voucher No.</label>
                          <input type="text" name="voucher_no" value="{{  $voucher_no  }}" id="voucher_no" class="form-control form-control-sm" readonly>
                      </div>  
                  </div>
    
                  <div class="col-md-3">
                      <div class="form-group">
                          <label for="">Date</label>
                          <input type="text" name="date" id="date" class="form-control form-control-sm">
                      </div>   
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                        <label> Currency </label>
                        <select type="text" name="currency" id="currency" class="form-control form-control-sm currency">
                            <option> Select  Currency  </option>
                        </select>
                    </div>  
                   
                </div>
                  </div>

              <div class="row">      
              <div class="col-md-12">
                <table class="custom-table" style="width: 100%; margin-left: 3%; background-color:#f1f1f1 !important">
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
                              <select required="" name="accounts[]" class="accounts form-control form-control-sm">
                                  <option value="" >Select Account</option>
                                  @foreach( $ledgers as $ledger  )
                                  <option value="{{ $ledger->id }}" > {{ $ledger->name  }}  </option>
                                  @endforeach
                                   </select>
                          </td>
                          <td><input required="" type="text" name="description[]" class="form-control form-control-sm" placeholder="Description for service"></td>
                          <td><input style="text-align: right" type="text" class="form-control form-control-sm debit" name="debit[]" placeholder="0.00"></td>
                          <td><input style="text-align: right" type="text" class="form-control form-control-sm credit" name="credit[]" placeholder="0.00"></td>
                      </tr>
                        <tr>
                          <td style="height: 0 !important;">
                              <select required="" name="accounts[]" class="accounts form-control form-control-sm">
                                  <option value="" selected="selected" disabled="">Select Account</option>  
                                  @foreach( $ledgers as $ledger  )
                                  <option value="{{ $ledger->id }}" > {{ $ledger->name  }}  </option>
                                  @endforeach
                              </select>
                          </td>
                          <td><input required="" type="text" name="description[]" class="form-control form-control-sm" placeholder="Description for service"></td>
                          <td><input style="text-align: right" type="text" class="form-control form-control-sm debit" name="debit[]" placeholder="0.00"></td>
                          <td><input style="text-align: right" type="text" class="form-control form-control-sm credit" name="credit[]" placeholder="0.00"></td>
                          <td> <button type="button" id="fee_adrow" style="border-radius: 2px !important; margin-right: 3px !important; margin-top: 29px;" class="btn btn-primary btn-sm fa fa-plus fee_add_row"> </button> </td>
                      </tr>
                  
                  {{-- <tr>
                      <td colspan="4">&nbsp;</td>
                  </tr> --}}
                
                  </tbody>
                
                  <tfoot style="background: rgba(5,86,158,0) !important">
                      <tr style="border-bottom: solid #2b303b">
                          <td colspan="4">&nbsp;</td>
                      </tr>
                      <tr>
                          <th colspan="2" style="width: 70%; text-align:right; font-size:14px">&nbsp;TOTAL</th>
                          <th id="total_debit" style="width: 15%; color: #2b303b; text-align: right; font-size:14px;">0.00</th>
                          <th id="total_credit" style="width: 15%; color: #2b303b; text-align: right; font-size:14px">0.00</th>
                      </tr>
                  </tfoot>
                
                </table>

              </div>

              <div class="col-md-12" style="margin-top:1%">
                <div class="form-group">
                    <label for="description"></label>
                    <textarea name="remarks" class="form-control form-control-sm" placeholder="description" id="description" rows="2"></textarea>
                  </div>
            </div>
 
              </div>   
            </form> 
        <span class="float-right">
            <a type="button" id="register" class="btn btn-primary btn-sm">Submit</a>
          </span>
        </div>
      
</div>

<table class="table_template"  style="display:none">
    <tr>
        <td style="height: 0 !important;">
            <select required="" name="accounts[]" class="accounts form-control form-control-sm">
                <option value="" selected="selected" disabled="">Select Account</option>  
                @foreach( $ledgers as $ledger  )
                <option value="{{ $ledger->id }}" > {{ $ledger->name  }}  </option>
                @endforeach
            </select>
        </td>
        <td><input required="" type="text" name="description[]" class="form-control form-control-sm" placeholder="Description for service"></td>
        <td><input style="text-align: right" type="text" class="form-control form-control-sm debit" name="debit[]" placeholder="0.00"></td>
        <td><input style="text-align: right" type="text" class="form-control form-control-sm credit" name="credit[]" placeholder="0.00"></td>
        <td> <button type="button" id="fee_adrow" style="border-radius: 2px !important; margin-right: 3px !important; margin-top: 29px;" class="btn btn-warning btn-sm fa fa-minus remove_row"> </button> </td>
    </tr>

</table>

</div>

@endsection

@include('shadows.custom_js')
@section('scripts')

$('.table_template').css({'display':'none'});

$('#register').click(function(e){
    {{-- alert('uwii'); --}}
    e.preventDefault();
    let form_data = $('#journal_voucher').serialize();

$.ajax({
    type: "POST",
    url: "{{  route('accounts.journal.voucher.store')  }}",
    data:form_data,
    {{-- dataType: "JSON", --}}
    success: function (response) {

        if(response.state == 'Done'){
            window.location.replace('{{route('accounts.journal.voucher.index') }}');
            
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

$('.accounts').select2({width:'100%'});

$('.currency').select2({width:'100%'});

$('.fee_add_row').click(function(){

let cloned_row = $('.table_template').find('tr').clone();
cloned_row.appendTo($('#voucher_items'));
removeRow(cloned_row);
numberClick(cloned_row);
});


function removeRow(duplicate_row){

    duplicate_row.find('.remove_row').click(function(){
            $(this).closest('tr').remove();
            console.log('remove');
     });
} 

$('.remove_row').click(function(){
 
    $(this).parent().parent().remove();
 
  });


  function numberClick(cloned_row){

  cloned_row.find('.debit').keyup(function(){
    let type = 'debit';
    let elem = $(this);
    let value = $(this).val();
 
    if(value){
     
    $(this).closest('tr').find('.credit').attr('readonly', '').trigger('change');

    }
    else{

        $(this).closest('tr').find('.credit').removeAttr('readonly').trigger('change');
       

    }

    if (event.which >= 37 && event.which <= 40) return;
    numberWithCommas(elem);

    getDebitValues();
    calculateTotal(type,elem);



});


cloned_row.find('.credit').keyup(function(){
    let type = 'credit';
    let elem = $(this);
    let value = $(this).val();

    if(value){

        $(this).closest('tr').find('.debit').attr('readonly', '').trigger('change');
    }
    else{

        $(this).closest('tr').find('.debit').removeAttr('readonly').trigger('change');
    }

    $('.debit').keyup(function(event){
        let elem = $(this);
       
     });

     if (event.which >= 37 && event.which <= 40) return;
     numberWithCommas(elem);

    getCreditValues();
    calculateTotal(type,elem);
   
    });


  }


  let debit_sum_container = [];
  let credit_sum_container = [];

  let total = 0;

$('.debit').keyup(function(){
    let type = 'debit';
    let elem = $(this);
    let value = $(this).val();

    if(value){
     
    $(this).closest('tr').find('.credit').attr('readonly', '').trigger('change');

    }
    else{

        $(this).closest('tr').find('.credit').removeAttr('readonly').trigger('change');
       

    }
    let amount = $(this).val().replaceAll(',','');

    getDebitValues();
    calculateTotal(type,elem);

});


function getDebitValues() {
    
        let total = parseFloat(0.0);
         
         $(".custom-table tbody tr").find(".debit").each(function( indx ) {
            let amount = parseFloat($(this).val().replaceAll(',',''));
            amount = !isNaN(amount) ? amount : 0
             debit_sum_container[indx] = amount;
         })
         
     }

     function getCreditValues() {
    
        let total = parseFloat(0.0);
         
         $(".custom-table tbody tr").find(".credit").each(function( indx ) {
            let amount = parseFloat($(this).val().replaceAll(',',''));
            amount = !isNaN(amount) ? amount : 0
            credit_sum_container[indx] = amount;
         })
         
     }

     



function calculateTotal(type,elem){
  
     let debit_total_elem = $('#total_debit');
     let credit_total_elem = $('#total_credit');
     let credit_total = parseFloat(0);
     let debit_total = parseFloat(0);

    if(type == 'debit'){

        for(let i=0; i < debit_sum_container.length; i++ ){
            debit_total += parseFloat(debit_sum_container[i]);
          }
         debit_total_elem.html(debit_total);

    }
    else{

        for(let i=0; i < credit_sum_container.length; i++ ){
            credit_total += parseFloat(credit_sum_container[i]);
          } 
          credit_total_elem.html(credit_total);

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

$('.credit').keyup(function(){
    let type = 'credit';
    let elem = $(this);
    if($(this).val()){
        $(this).closest('tr').find('.debit').attr('readonly', '').trigger('change');
    }
    else{

        $(this).closest('tr').find('.debit').removeAttr('readonly').trigger('change');
    }

    getCreditValues();
    calculateTotal(type,elem);
   
    });

$('.debit').keyup(function(event){
    let elem = $(this);
    let value = $(this).val();
   if (event.which >= 37 && event.which <= 40) return;
   numberWithCommas(elem);
 });


 $('.credit').keyup(function(event){
    let elem = $(this);
    let value = $(this).val();
   if (event.which >= 37 && event.which <= 40) return;
   numberWithCommas(elem);
 });

var $j = jQuery.noConflict();
 $("#date").datepicker().datepicker("setDate", new Date());

@endsection




