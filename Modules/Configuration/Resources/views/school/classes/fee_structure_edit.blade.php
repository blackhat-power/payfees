
@extends('dashboard')
@section('content-body')


<div class="container-fluid">
    <div class="row">
      
      @include('configuration::school.includes.school_profile')

       <div class="col-lg-9 col-md-6">
          <div class="card card-block card-stretch card-height">
             <div class="card-header">
                <div class="header-title">
                   <h4 class="card-title">School Profile</h4>
                </div>
             </div>
            
             @include('configuration::school.includes.tabs')
             <div class="container">
             <div class="form-card text-left">
                <form id="fee_payment_form">
                
                  <div id="fees">
                     <div id="fees_append">
                        <div class="row">
                           
                           <div class="col-md-6">
                              <div class="form-group form-group-sm">
                                 <label> Class </label>
                                 <select name="classes[]" id="" class="form-control">
                                    @foreach ($classes as $class )
                                    <option value="{{$class->id}}">{{$class->name }}</option>  
                                    @endforeach
                                 </select>
                                 <input type="hidden" name="fee_structure_item_id" value="{{ $fee_structures[0]->fee_structure_item_id  }}">
                                 <input type="hidden" name="fee_structure_id" value="{{ $fee_structures[0]->fee_structure_id  }}">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group form-group-sm">
                                 <label> Semester/term </label>
                                 <select name="semesters[]" id="" class="form-control" >
                                    @foreach ($semesters as $semester )
                                    <option value="{{$semester->id}}">{{$semester->name}}</option>
                                    @endforeach
                                    
                                 </select>
                              </div>
                           </div>
                        </div>

                        @foreach ($fee_structures as $fee_index => $fee_structure )
                        <div class="row">
                           <div class="col-md-3">
                              <div class="form-group form-group-sm">
                                 <label> Fee Types *</label>
                                 <input type="text" value="{{ $fee_structure->item_name }}" class="form-control input-sm" name="fee_types[]" placeholder="fee">
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group form-group-sm">
                                 <label>Installment.: *</label>
                                 <input type="text" value="{{ $fee_structure->installments }}" class="form-control input-sm" name="installments[]" placeholder="Installment.">
                              </div>
                           </div>
                           <div class="col-md-2">
                               <div class="form-group form-group-sm">
                                  <label>Currency.: *</label>
                                  <select name="currency[]" class="form-control" id="">
                                     @foreach ($currencies as $currency)
                                     <option value="{{$currency->id}}"  {{ $currency->id == $fee_structure->currency_id ? 'selected' : '' }}  >{{$currency->name}}</option>
                                     @endforeach
                                     
                                  </select>
                                 
                               </div>
                            </div>
                            <div class="col-md-3">
                               <div class="form-group form-group-sm">
                                  <label>Amount.: *</label>
                                  <input type="text" class="form-control amounts" value="{{ number_format($fee_structure->amount) }}" name="amounts[]" placeholder="amount.">
                               </div>
                            </div>

                            @if ($fee_index == 0)
                            <div class="col-md-1">
                                <button type="button" style="color:black; margin-top:60%" class="btn btn-primary btn-sm fa fa-plus fee_add_row"> </button>
                            </div> 

                            @else
                            <div class="col-md-1">
                                <button type="button" style="color:black; margin-top:80%" class="btn btn-warning btn-sm fa fa-minus remove_row "> </button>
                           </div>
                            @endif 
                        </div>
                        @endforeach
   
                      </div>
   
                      <button type="button" name="next" class="btn btn-primary float-left" id="add_new_fee_row" >Add Class</button>
                   </div>
                  
                     
                 

               </form>
               
             </div>
            </div>
                   {{-- <button type="button" name="next" style="margin-top:2%"    class="btn btn-primary float-right" id="save_seasons_n_classes" >Save</button> --}}
                   <button type="button" name="next" style="margin-top:2%"  class="btn btn-primary {{-- next action-button --}} float-right" id="save_fee_payment" value="Submit">Submit</button>

          </div>
       </div>
      
    </div>
 </div>
 @include('configuration::registration.form_duplicates')

 @endsection


 @section('scripts')


      $('#save_fee_payment').click(function(){
         let form_data = $('#fee_payment_form').serialize();
         let school_id = $('#school_id').val();
          
         let url = '{{route('configurations.school.fee.structure.store',':id')}}';
        url = url.replace(':id',school_id);
       $.ajax({
       type: "POST",
        url: url,
        data: form_data,
        {{-- dataType: "JSON", --}}
        success: function (response) {
         window.location.replace(response);
         }
   }); 
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

 let class_url = '{{ route('configurations.classes.datatable',':id') }}';
 
 class_url = class_url.replace(':id',  @php echo $school_details->id @endphp)
   classes_datatable = $('#classes_table').DataTable({
     processing: true,
     serverSide: true,
      ajax:class_url,
      columns:[
         {data:'class_name', name:'class_name'},
          {data: 'season_name', name:'season_name'},
          {data:'Number_of_students', name:'Number_of_students'},
          {data:'bill_payable', name:'bill_payable'},
          {data:'bill_paid', name:'bill_paid'},
          {data:'bill_balance', name:'bill_balance'},
          {data:'action', name:'action', orderable:false, searchable:false}
      ],
 });
 



 @endsection





















 






