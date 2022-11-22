@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Finance Management</li>
                <li  class="breadcrumb-item active" aria-current="page">Transactions</li>
                <li  class="breadcrumb-item"><a href="{{route('accounts.ledgers.index')}}">Receipt Voucher</a></li>
                <li class="breadcrumb-item active" aria-current="page">New</a></li>
                <li class="ml-auto"> <a id="comment" style="color: #551a8b !important" href="{{route('configurations.users.manual')}}"><i class="fa fa-comments"></i> Support</a></li>
              </ol>
          </nav>
@endsection 


@section('content-body')

<div class="card" style="width: 100%; border-top: 4px solid #00a65a;">
    <div class="card-header">Receipt Voucher</div>
    <div class="card-body">
        <form action="#" id="payment_voucher">
            @csrf

            <div class="row table">
              <div class="col-md-9"> </div>
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">Date</label>
                    <input type="text" name="date" id="date" class="form-control form-control-sm">
                </div> 
            </div>
                <div class="col-md-3">
                      <div class="form-group">
                          <input type="text" name="voucher_no" placeholder = "Voucher Number" id="voucher_no" class="form-control form-control-sm">
                      </div>  
                      <input type="hidden" name="action" value="create">
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" name="reference" placeholder ="Reference" id="reference" class="form-control form-control-sm">
                    </div>  
                </div>


                  <div class="col-md-4">
                    <div class="form-group">
                        <select type="text" name="credit" id="credit_account" class="form-control form-control-sm credit_account">
                            <option> Select Debited Account  </option>
                            @foreach($ledgers as $ledger)
                            <option  value={{ $ledger->id  }} > {{  $ledger->name   }} </option>
                            @endforeach
                        </select>
                    </div>  
                   
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <select type="text" name="currency" id="currency" class="form-control form-control-sm currency">
                            <option> Select  Currency  </option>
                        </select>
                    </div>  
                   
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <select type="text" name="against_invoice" id="against_invoice" class="form-control form-control-sm credit_account">
                            <option> Receive Against Invoice </option>
                            @foreach($ledgers as $ledger)
                            <option  value={{ $ledger->id  }} > {{  $ledger->name   }} </option>
                            @endforeach
                        </select>
                    </div>  
                   
                </div>

                  </div>

              <div class="row">      
              <div class="col-md-12">
                <table class="custom-table" style="width: 100%; margin-left: 3%">
                  <thead>
                      <tr style="background: rgba(5,86,158,0) !important; border-bottom: solid #2b303b">
                          <th style="width: 25%; color: #2b303b">Credit Account</th>
                          <th style="width: 60%; color: #2b303b">Description</th>
                          <th style="width: 20%; color: #2b303b; text-align: right">Amount</th>
                          <th style="width: 15%; color: #2b303b; text-align: right"> </th>
                      </tr>
                  </thead>
                  <tbody id="voucher_items" style="background-color: rgba(5,86,158,0)">
                  <tr>
                      <td style="height: 0 !important;" colspan="4">&nbsp;</td>
                  </tr>
                          <tr>
                          <td style="height: 0 !important;">
                              <select required="" name="debit_accounts[]" class="form-control form-control-sm accounts">
                                  <option value="">Select Account</option>
                                  @foreach($ledgers as $ledger)
                                    <option  value={{ $ledger->id  }} > {{  $ledger->name   }} </option>
                                    @endforeach
                                   </select>
                          </td>
                          <td><input required="" type="text" name="description[]" class="form-control form-control-sm" placeholder="Description for service"></td>
                          <td><input style="text-align: right" type="text" class="form-control form-control-sm amount" name="amount[]" placeholder="0.00"></td>
                      </tr>
                        <tr>
                          <td style="height: 0 !important;">
                              <select required="" name="debit_accounts[]" class="form-control form-control-sm accounts">
                                  <option value="" selected="selected" disabled="">Select Account</option> 
                                  @foreach($ledgers as $ledger)
                                    <option  value={{ $ledger->id  }} > {{  $ledger->name   }} </option>
                                    @endforeach                                             
                              </select>
                          </td>
                          <td><input required="" type="text" name="description[]" class="form-control form-control-sm" placeholder="Description for service"></td>
                          <td><input style="text-align: right" type="text" class="form-control form-control-sm amount" name="amount[]" placeholder="0.00"></td>
                          <td> <button type="button" id="fee_adrow" style="border-radius: 2px !important; margin-right: 3px !important; margin-top: 29px;" class="btn btn-primary btn-sm fa fa-plus fee_add_row"> </button> </td>
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
                          <th id="total_amount" style="width: 35%; color: #2b303b; text-align: right; font-size:14px; padding-right:21px;">0.00</th>
                      </tr>
                  </tfoot>
                
                </table>

                <div class="col-md-12" style="margin-top:1%">
                    <div class="form-group">
                        <label for="description"></label>
                        <textarea name="remarks" class="form-control form-control-sm" placeholder="description" id="description" rows="2"></textarea>
                      </div>
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
  

</section>


@endsection


@section('scripts')

$('.accounts').select2({width:'100%'});
$('.credit_account').select2({width:'100%'});
$('.currency').select2({width:'100%'});

let total_amount = parseFloat(0);
let total_amount_elem = $('#total_amount');

$('.amount').keyup(function(event){
    let elem = $(this);
    let value = $(this).val();
    
   if (event.which >= 37 && event.which <= 40) return;
   numberWithCommas(elem);
   let sum = calculateTotal();
   {{-- console.log(sum); --}}

 });


 function calculateTotal(){
    let amount_total = 0;
    $(".custom-table tbody tr").each(function() {

        amount =  $(this).find(".amount").val();
        console.log(amount);
         amount_total += parseFloat(amount);
         {{-- console.log(amount_total); --}}
       
    });

    {{-- return amount_total; --}}

}


var $j = jQuery.noConflict();
 $("#date").datepicker().datepicker("setDate", new Date());


 $('#register').click(function(e){
    {{-- alert('uwii'); --}}
    e.preventDefault();
    let form_data = $('#payment_voucher').serialize();

$.ajax({
    type: "POST",
    url: "{{  route('accounts.payment.voucher.store')  }}",
    data:form_data,
    {{-- dataType: "JSON", --}}
    success: function (response) {

        console.log(response);

        if(response.state == 'Done'){
            {{-- window.location.replace('{{route('accounts.invoice') }}'); --}}
            
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


@endsection
