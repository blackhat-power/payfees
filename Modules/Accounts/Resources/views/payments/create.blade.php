
@extends('layouts.app')


@section('alerts-ground')
@if ($notification = Session::get('payment_submitted'))
<div class="toast fade show bg-success text-white border-0 rounded p-2 mt-3" role="alert" aria-live="assertive" aria-atomic="true" style="width: 100%; display:none">
   <div class="toast-header bg-success text-white">
      <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">×</span>
      </button>
   </div>
   <div class="toast-body">
      <strong>{{ $notification }}</strong>
   </div>
</div>

@endif
@endsection


@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                 <li  class="breadcrumb-item"><a href="{{route('accounts.invoice')}}">Invoices</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Payments</a></li>
              </ol>
          </nav>
  
@endsection 

@section('content-body')



<section class="container-fluid">
   <div class="row">
       <div class="">
           <div class="table" style="border-top: 4px solid #00c0ef; background-color: #dce0e7">
               
           <div class="row" style="margin-top: 2%">
            <form target="_blank" id="invoice_form_store" method="POST"  action="{{ route('accounts.receipts.store.print') }}">
                @csrf
                   <div class="col-md-12">
                       <div class="row">
                           <div class="col-md-3">
                              <div class="col-md-12">
                                  <div class="card" style="border-top:4px solid #f39c12; margin-left:2%">
                                      <div class="card-header"> Invoice Info: </div>
                                      <div class="card-body">
                                      <div class="row">
                                       <div class="col-md-12">
                                          <div class="form-group">
                                              <label for="">Invoice No.</label>
                                              <input type="text" name="invoice_no" value="{{ $invoice_details->invoice_number }}" id="invoice_no" class="form-control" disabled>
                                           </div>
                                      </div>

                                          <div class="col-md-12">
                                              <div class="form-group">
                                                  <label for="">Invoice Date: <span class="text-red"> *</span></label>
                                                  <input type="date" name="date" value="{{ $invoice_details->date }}" class="form-control" disabled>
                                              </div>
                                          </div>
                                         
                                      </div>
                                  </div>
                                  </div>
                              </div>
  
                           </div>
  
                           <div class="col-md-9">
  
                              <div class="card" style="border-top:4px solid #00a65a; margin-right:2%">
                                  <div class="card-header">
                                     Payment Info
                                  </div>
                                  <div class="card-body">
                                     <div class="row">
                                        <div class="col-md-12">

                                         <span class="float-right"> <b>Balance :</b> <span class="text-red">  {{ number_format($balance)  }} </span>       </span> 
                                        </div>
                                       
                                     </div>
                                     <div class="row">
                                        <div class="col-md-4">
                                           <div class="form-group">
                                              <label class="text-bold" for=""> Payment Date <span class="text-red">*</span></label>
                                              <input type="text" name="date" id="date" class="form-control form-control-sm">
                                              <input type="hidden" name="student" value="{{ $student }}">
                                              <input type="hidden" name="bill_no" value = "{{$invoice_id}}">
                                           </div>
                                        </div>
                                         <div class="col-md-4">
                                             <div class="form-group">
                                               <label for="">  Payment Method <span class="text-red"> *</span></label>
                                               <select name="fee_type_group" id="fee_type_group" class="form-control form-control-sm">
                                                   <option value="">Pick A method</option>
                                               </select>
                                             </div>   
                                         </div>

                                         <div class="col-md-4">
                                          <div class="form-group  has-feedback">
                                            <label for="">  Paid Amount <span class="text-red"> *</span></label>
                                            <input type="text" min="1" max="{{ $balance }}" name="amt_paid" id="amt_paid" class="form-control form-control-sm">
                                            <span class="text-danger" id="max_check"></span>
                                          </div>   
                                      </div>

                                      <div class="col-md-4">
                                       <div class="form-group has-feedback">
                                           <label for="payment_method">Payment Reference</label>
                                           <input type="text" name="payment_reference" class="form-control form-control-sm" value="" maxlength="255" placeholder="optional">
                                           {{-- <span class="form-control-feedback fa fa-link"></span> --}}
                                          
                                       </div>
                                   </div>

                                   <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="payment_document">Payment Document<span class="text-danger">[Max 1mb]</span></label>
                                        <input type="file" name="payment_attachment" id="myFile" class="form-control-file" accept=".jpeg, .jpg, .png, .txt, .text, .doc, .docx, .pdf, .odt" name="payment_document">
                                    </div>
                                    
                                    </div>
                                     </div>
                                    
                                  </div>
                               </div>
  
                           </div>
                       </div>

                   

                   </div>

                       <div class="col-md-12">
                           <div class="card" style="margin-left: 1%; margin-right:1%">
                               <div class="card-body">
                               <div class="row">
                                   <div class="col-md-4">
                                       <a type="buttton" href="javascript:void(0)" class="btn btn-primary btn-sm" id="add_only"> <i class="fa fa-plus-circle"></i> Pay </a>
                                   </div>
                                   <div class="col-md-8">
                                       <span class="float-right" style="margin-right:1%">
                                           <button type="submit" id="add_print" style="color:white" class="btn btn-success btn-sm" disabled><i class="fa fa-print"></i>Add & Print</button>                                           
                                       </span>
                                   </div>
       
                               </div>
                              </div>
                           </div>
                       </div>   
                    </form>             
           </div>
              
           </div>

       </div>
      
    </div>

 

</section>

@endsection


 @section('scripts')

 $('#amt_paid').keyup(function(event){
    let elem = $(this);
    let value = $(this).val();
   if (event.which >= 37 && event.which <= 40) return;
   numberWithCommas(elem);
   let max = parseInt($(this).attr('max'));
   let new_value = parseInt(value.replaceAll(',',''));

   if(max >= new_value){

      $('#max_check').text('');
   }

 });
 var $j = jQuery.noConflict();
 $("#date").datepicker().datepicker("setDate", new Date());


 $('#add_only').click(function(){

    let form = $('#invoice_form_store');
    let formData = new FormData(form[0]);


   $.ajax({

      url:'{{ route('accounts.receipts.store') }}',

      type:'POST',
      processData: false,
      dataType:'JSON',
      contentType: false,
      data:formData,
      success: function(response){

        if(response.state == 'Done'){

            let url = '{{ route('accounts.invoice') }}';
            window.location.replace(url);

            }

            if(response.state == 'Fail'){

                toast.error(response.msg, response.title);

            }
            
      },

      error: function(response){
         
         console.log(response);

      }

   });
});



$('#amt_paid').focusout(function() {

  let value = parseInt($(this).val().replaceAll(',',''));
  let max = parseInt($(this).attr('max'));
  if(max < value){

     $('#max_check').text( 'Please enter a value less than or equal to'+' '+ max.toLocaleString());

  }
  


});
 



 @endsection





















 






