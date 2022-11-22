
@extends('layouts.app')


@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">

            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Accounts</a></li>
                 <li  class="breadcrumb-item"><a href="{{route('accounts.fee_structure.settings')}}">Fee Structure Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</a></li>
              </ol>
          </nav>

@endsection



@section('content-body')

    <div class="card" style="border-top:4px solid #00a65a; width:100%">

      <div class="card-header">

        <div class="row justify-content-center" style="border-bottom: 1px solid #aeb8b8 " >

        <span class=" card-title text-red text-center" style="font-size: 1.2em"> {{  $fee_structures[0]->class_name  }} </span>  <span style="font-size: 1.1em; margin-left:1%"> [ {{ strtoupper($fee_structures[0]->group_name) }} GROUP  ] &nbsp; EDIT </span> 

        </div> 


      <div class="card-body">

         <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
               <div class="row">
                  
                  <div class="container">
                     <div class="form-card text-left">
                        <form id="fee_payment_form">
                        
                          <div id="fees">
                             <div id="fees_append">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="">Fee Group <span class="text-red">*</span></label>
                                        <select name="fee_group" id="fee_group" class="form-control form-control-sm" readonly>
                                           <option value="{{ $fee_structures[0]->group_id  }}" selected> {{ $fee_structures[0]->group_name }} </option>                                           
                                        </select>
                                    </div>
                                    </div>
                                    <div class="col-md-2">
                                       <div class="form-group form-group-sm">
                                          <label>Installment.: *</label>
                                          <input type="text" value="{{ $fee_structures[0]->installments }}" class="form-control form-control-sm input-sm" name="installments[]" placeholder="Installment.">
                                       </div>
                                    </div>
                        
                                    <div class="col-md-3">
                                        <div class="form-group">
                                           <label for="">Class <span class="text-red">*</span></label>
                                           <select name="classes[]" id="" class="form-control form-control-sm" readonly>
                                            <option value="{{ $fee_structures[0]->class_id}}">{{$fee_structures[0]->class_name }}</option>  
                                         </select>

                                         <input type="hidden" name="fee_structure_item_id" value="{{ $fee_structures[0]->fee_structure_item_id  }}">
                                         <input type="hidden" name="fee_structure_id" value="{{ $fee_structures[0]->fee_structure_id  }}">
                                    </div>
                                    </div>

                                    <div class="col-md-2">
                                       <div class="form-group">
                                          <label for="">Academic Year <span class="text-red">*</span> </label>
                                          <select name="academic_year" id="academic_year" class="form-control form-control-sm">
                                            @foreach ($academic_years as $academic_year )
                                            <option value="{{ $academic_year->id }}"  {{ $fee_structures[0]->season_id == $academic_year->id ? 'selected' : '' }} > {{ $academic_year->name  }} </option>
                                            @endforeach
                                          </select>
                                           {{-- <input type="text" name="academic_year" value="{{$academic_year}}" class="form-control form-control-sm" placeholder="eg 2022" readonly> --}}
                                       </div>
                                   </div>
                        
                                 </div>
        
                                @foreach ($fee_structures as $fee_index => $fee_structure )
                                <div class="row">
                                   <div class="col-md-4">
                                      <div class="form-group form-group-sm">
                                         <label> Fee Types *</label>
                                         <input type="text" value="{{ $fee_structure->item_name }}" class="form-control form-control-sm input-sm" name="fee_types[]" placeholder="fee">
                                      </div>
                                   </div>
                                  
                                   <div class="col-md-3">
                                       <div class="form-group form-group-sm">
                                          <label>Currency.: *</label>
                                          <select name="currency[]" class="form-control form-control-sm currency" id="">
                                             @foreach ($currencies as $currency)
                                             <option value="{{$currency->id}}"  {{ $currency->id == $fee_structure->currency_id ? 'selected' : '' }}  >{{$currency->name}}</option>
                                             @endforeach
                                          </select>
                                         
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group form-group-sm">
                                          <label>Amount.: *</label>
                                          <input type="text" class="form-control form-control-sm amounts" value="{{ number_format($fee_structure->amount) }}" name="amounts[]" placeholder="amount.">
                                       </div>
                                    </div>
        
                                    @if ($fee_index == 0)
                                    <div class="col-md-1" style="margin-top: 3%">
                                        <button type="button" style="color:black;" class="btn btn-primary btn-sm fa fa-plus fee_add_row"> </button>
                                    </div> 
        
                                    @else
                                    <div class="col-md-1" style="margin-top: 3%">
                                        <button type="button" style="color:black;" class="btn btn-warning btn-sm fa fa-minus remove_row "> </button>
                                   </div>
                                    @endif 
                                </div>
                                @endforeach
           
                              </div>
           
                              {{-- <button type="button" name="next" class="btn btn-primary float-left" id="add_new_fee_row" >Add Class</button> --}}
                           </div>

                       </form>
                       
                     </div>
                    
                           <button type="button" name="next" style="margin-top:2%"  class="btn btn-primary btn-sm float-right" id="save_fee_payment" value="Submit"> <i class="fa fa-paper-plane"></i>Submit</button>
                   

                    </div>

               </div>
            </div>
         </div>


      </div>

    </div>

 @include('configuration::registration.form_duplicates')

 @endsection


 @section('scripts')


      $('#save_fee_payment').click(function(){
         let form_data = $('#fee_payment_form').serialize();
         var school_id = $('#school_id').val();
         let class_id = {{$class_id}}
         let url = '{{route('accounts.school.fee.structure.store',':id')}}';
        url = url.replace(':id',school_id);

        startSpinnerOne();

       $.ajax({
       type: "POST",
        url: url,
        data: form_data,
        {{-- dataType: "JSON", --}}
        success: function (response) {

         if(response.state == 'Done'){
            {{-- toastr.success(response.msg, response.title); --}}
            let respnse_url = '{{ route('accounts.school.fee_structure.class','id') }}';
            let url = respnse_url.replace('id',class_id);
            window.location.replace(url);
        }
        else if(response.state == 'Fail'){
            toastr.warning(response.msg, response.title)

        }
        else if(response.state == 'Error') {
            toastr.error(response.msg, response.title);
        }

        stopSpinnerOne();

    },
    error: function(response){
        if(response.error == 500){
            toastr.error('Server Error', 'error');
        }
        stopSpinnerOne();
        
    }


   }); 
      });

 
      $('.fee_add_row').click(function(){
       let duplicate_row = $('#fee_structure_inner_row').clone().removeAttr('style id')
          $(this).parents('#fees_append').append(duplicate_row);
          removeRow(duplicate_row);
          let amountElem = duplicate_row.find('.amounts');
          {{-- let curr = $('.currency'); --}}
         numberFormat(amountElem);
         {{-- currency_switch(curr) --}}

      }); 


      numberFormat($('.amounts'));

      function numberFormat(ele){
         ele.keyup(function(){
            
            let check_mate = parseFloat($(this).val().replace(/,/g, ''));
            if(check_mate){
               $(this).val(check_mate.toLocaleString());
            }
            else{
               $(this).val('');
            }
         })
      }
 
   
 $('#add_new_fee_row').click(function(){
    let duplicate_row = $('#fee_copy').clone().removeAttr('style id')
    console.log('awii');
    $(this).parents('#fees').prepend(duplicate_row);
    removeDiv(duplicate_row);
 
 });
      
    function removeRow(duplicate_row){
     duplicate_row.find('.remove_row').click(function(){
             $(this).parent().parent().remove();
             console.log('remove');
      });
   }
   function removeDiv(duplicate_row){
    duplicate_row.find('.remove_div').click(function(){
             $(this).parent().parent().parent().remove();
             console.log('remove');
      });
 
   }

   removeFeeRow();
   function removeFeeRow(){
   let row = $('#fees_append').find('.remove_row');
   row.click(function(){
    $(this).parent().parent().remove();
   });
   }


 

 @endsection





















 






