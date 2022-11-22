
@extends('layouts.app')
@section('content-body')

<div class="container-fluid">
   <div class="card card-block card-stretch card-height" style="border-top:4px solid #00a65a; margin-right:1%">
      <div class="card-header">
      </div>
      <div class="card-body">
         <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                   <label for="">Fee Group <span class="text-red">*</span></label>

                <select name="fee_group" id="fee_group" class="form-control form-control-sm">
                   @foreach ($fee_groups as $fee_grooup )
                   <option value="{{ $fee_group->id  }}"> {{ $fee_group->name }} </option>
                   @endforeach
                   
                </select>
            </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                   <label for="">Class <span class="text-red">*</span></label>
                   <select name="classes[]" id="classes" class="form-control form-control-sm">
                     @foreach ($classes as $class )
                     <option value="{{$class->id}}">{{$class->name }}</option>  
                     @endforeach
                  </select>
            </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                   <label for="">Academic Year <span class="text-red">*</span> </label>
                    <input type="text" name="" id="" class="form-control form-control-sm" placeholder="eg 2022">
                </div>
            </div>

         </div>

         <div class="container" style="margin-top: 2%">

         <div class="row">
            <div class="col-md-3">
               <div class="form-group form-group-sm">
                  <label> Fee Types *</label>
                  <input type="text" class="form-control form-control-sm input-sm" name="fee_types[]" placeholder="fee">
               </div>
            </div>
            <div class="col-md-3">
               <div class="form-group form-group-sm">
                  <label>Installment.: *</label>
                  <input type="number" class="form-control form-control-sm input-sm" name="installments[]" placeholder="Installment.">
               </div>
            </div>
            <div class="col-md-2">
                <div class="form-group form-group-sm">
                   <label>Currency.: *</label>
                   <select name="currency[]" class="form-control form-control-sm" id="">
                      @foreach ($currencies as $currency)
                      <option value="{{$currency->id}}">{{$currency->name}}</option>
                      @endforeach
                   </select>
                  
                </div>
             </div>
             <div class="col-md-3">
                <div class="form-group form-group-sm">
                   <label>Amount.: *</label>
                   <input type="text" class="form-control form-control-sm amounts" name="amounts[]" placeholder="amount.">
                </div>
             </div>
             <div class="col-md-1">
               <button type="button" style="color:black; margin-top:42%" class="btn btn-primary btn-sm fa fa-plus fee_add_row"> </button>
        </div>
         </div>

      </div>

      </div>

   </div>
</div>
     
   </div>
</div>

 @include('configuration::registration.form_duplicates')

 @endsection


 @section('scripts')


 $('#fee_group').select2({width:'100%'});


 $('#semester_add_row').click(function(){
   let duplicate_row =   $('#semester_duplicate').clone().removeAttr('style id');
   $(this).parents('#semesters_div').append(duplicate_row);
   console.log('aa');
   removeRow(duplicate_row);
  });



 $('#add_row').click(function(){
   let duplicate_row =   $('#duplicate_row').clone().removeAttr('style id');
       $(this).parents('#seasons_div').append(duplicate_row);
 
       removeRow(duplicate_row);
      });
 
      $('#save_fee_payment').click(function(){
         let form_data = $('#fee_payment_form').serialize();
         let school_id = $('#school_id').val();
         let fee_group = $('#fee_group').val();
         let url = '{{ route('accounts.school.fee.structure.store') }}';

       $.ajax({
       type: "POST",
        url: url,
        data: form_data,
        {{-- dataType: "JSON", --}}
        success: function (response) {


         if(response.state == 'Done'){
            {{-- toastr.success(response.msg, response.title); --}}
            {{-- window.location.replace('{{route('accounts.invoice') }}'); --}}
            window.location.replace('{{ route('accounts.fee_structure.settings') }}');
            
        }
        else if(response.state == 'Fail'){
            toastr.warning(response.msg, response.title)

        }
        else if(response.state == 'Error') {
            toastr.error(response.msg, response.title);
        }

    },
    error: function(response){
        
        toastr.error(response.msg, response.title);
        
    }

   

   }); 
      });
 
      $('#class_add_row').click(function(){
 
         let duplicate_row = $('#class_duplicate_row').clone().removeAttr('style id')
         duplicate_row.find('.multiple_select_duplicate').select2();   
         $(this).parents('#classes_row').append(duplicate_row);
         removeRow(duplicate_row);
         
      });
 
      $('.fee_add_row').click(function(){
       let duplicate_row = $('#fee_structure_inner_row').clone().removeAttr('style id')
          $(this).parents('#fees_append').append(duplicate_row);
          removeRow(duplicate_row);
         let amountElem = duplicate_row.find('.amounts');
         numberFormat(amountElem);
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

      $('#classes').select2({width:'100%'});
      $('#semester').select2({width:'100%'});

   
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

 


 $('.multiple_select').select2({
   multiple: true
 });

 @endsection





















 






