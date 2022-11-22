
@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">

            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Accounts</a></li>
                 <li  class="breadcrumb-item"><a href="{{route('accounts.fee_structure.settings')}}">Fee Structure Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">New</a></li>
              </ol>
          </nav>

@endsection


@section('content-body')


      <div class="card" style="border-top: 3px solid #faa21c; width:30%" >
         <div class="card-header">
            Add Fee Group Type
         </div>
         <div class="card-body">
            <form action="#" id="fee_header_form">
               @csrf
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                         <input type="hidden" name="action" value="create">
                        <label for=""> Fee Group Type Header</label>
                        <input type="text" name="name" id="fee_group_header" class="form-control form-control-sm">
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for=""> Description </label>
                        <input name="description" type="text" class="form-control form-control-sm">
                     </div>
                  </div>
               </div>

            </form>

            <span class="float-right"> <a href="javascript:void(0)" id="save_header" class="btn btn-sm btn-primary"> Save </a> </span>
         </div>
      </div>


      <div class="card" style="border-top: 3px solid  #faa21c; width:68%; margin-left:2%">
         <div class="card-header"> Fee Type Group List </div>
         <div class="card-body">
            <table style="width: 100%" id="fee_type_group">
            <thead>
               <tr>
                   <th style="width: 2% !important;">Code</th>
                  <th>Names</th>
                  <th>Description</th>
               </tr>
            </thead>


            </table>
         </div>
      </div>


   <div class="card card-block card-stretch card-height" style="border-top:4px solid #00a65a; width:'100%">
      <div class="card-header">
      </div>
      <div class="card-body">

         <div class="row">
            <div class="col-md-11">

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
                                        <select name="fee_group" id="fee_group" class="form-control form-control-sm">
                                          @foreach ($fee_groups as $fee_group )
                                          <option value="{{ $fee_group->id  }}"> {{ $fee_group->name }} </option>
                                          @endforeach
                                        </select>
                                 </div>
                                 </div>

                                 <div class="col-md-2">
                                    <div class="form-group form-group-sm">
                                       <label>Installment.: *</label>
                                       <input type="number" class="form-control form-control-sm input-sm" name="installments[]" placeholder="Installment.">
                                    </div>
                                 </div>

                                 <div class="col-md-3">
                                     <div class="form-group">
                                        <label for="">Class <span class="text-red">*</span></label>
                                        <select name="classes[]" id="classes" class="form-control form-control-sm">
                                          @foreach ($classes as $class )
                                          <option value="{{$class->id}}">{{$class->name }}</option>
                                          @endforeach
                                       </select>
                                 </div>
                                 </div>



                                 <div class="col-md-2">
                                     <div class="form-group">
                                        <label for="">Academic Year <span class="text-red">*</span> </label>
                                        <select name="academic_year" id="academic_year" class="form-control form-control-sm">
                                          @foreach ($academic_years as $academic_year )
                                          <option value="{{ $academic_year->id }}"> {{ $academic_year->name  }} </option>
                                          @endforeach
                                        </select>
                                         {{-- <input type="text" name="academic_year" value="{{$academic_year}}" class="form-control form-control-sm" placeholder="eg 2022" readonly> --}}
                                     </div>
                                 </div>



                              </div>


                                <div class="row">
                                   <div class="col-md-4">
                                      <div class="form-group form-group-sm">
                                         <label> Fee Types *</label>
                                         <input type="text" class="form-control form-control-sm input-sm" name="fee_types[]" placeholder="fee">
                                      </div>
                                   </div>

                                   <div class="col-md-3">
                                       <div class="form-group form-group-sm">
                                          <label>Currency.: *</label>
                                          <select name="currency[]" class="form-control form-control-sm" id="">
                                             @foreach ($currencies as $currency)
                                             <option value="{{$currency->id}}">{{$currency->name}}</option>
                                             @endforeach
                                          </select>

                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group form-group-sm">
                                          <label>Amount.: *</label>
                                          <input type="text" class="form-control form-control-sm amounts" name="amounts[]" placeholder="amount.">
                                       </div>
                                    </div>
                                    <div class="col-md-1">
                                      <button type="button" id="fee_adrow" style="color:black; margin-top:29px !important" class="btn btn-primary btn-sm fa fa-plus fee_add_row"> </button>
                               </div>
                                </div>

                              </div>

                              {{-- <button type="button" name="next" class="btn btn-primary float-left" id="add_new_fee_row" >Add Class</button> --}}
                           </div>

                             <div class="row">
                                <div class="col-md-11">

                                </div>


                             </div>
                             <button type="button" name="next" style="margin-top:2%"  class="btn btn-primary  btn-sm float-right" id="save_fee_payment" value="Submit"> <i class="fa fa-paper-plane"></i>Submit</button>


                       </form>

                     </div>



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



 $('#save_header').click(function(){

let form_data = new FormData($('#fee_header_form')[0]);

$.ajax({

   method: 'POST',
   processData: false,
   contentType: false,

   url : '{{ route('fee_type_groups.store')  }}',
   data:form_data,
   success: function(response){

    console.log(response);

       if(response.message == 'success'){
           toastr.success('Data Saved Successful', 'Success')
           fee_type_group_table.draw();
           $('#fee_header_form')[0].reset();

           $.ajax({

            url :  '{{  route('fee_type_groups.load')   }}',
            success:function(response){
               $('#fee_group').html(response);
            }

           });
       }
       else{
           toastr.warning('Failed To Save Data', 'Failed')

       }

   },
   error: function(response){
       if(response.status == 500){
           toastr.error('Internal server Error', 'error');
       }

   }



   });



 })


{{-- $('#fee_type_group').Datat --}}

var fee_type_group_table = $('#fee_type_group').DataTable({
   processing: false,
  serverSide: true,
   ajax:{
       url : '{{ route('fee_type_groups.datatable') }}',
       data: function (d) {
          d.from_date = $('#from_date').val();
          d.to_date = $('#to_date').val();
          d.class_id = $('#class_filter').val(),
          d.stream_id = $('#stream_filter').val()
      }  
   },
   columns:[
      {data: 'id', name:'id'},
      {data: 'name', name:'name'},
      {data: 'description', name:'description'},
  ],
  "columnDefs": [ {{-- { className: " text-right font-weight-bold", "targets": [ 3 ] } --}} ],
 "drawCallback":function(){},
 "footerCallback": function ( ) {},
  
});


 $('#fee_type_group').on('draw.dt', function () {
 $('#fee_type_group').Tabledit({
 url: '{{ route('fee_type_groups.store') }}',
 dataType: 'json',
 columns: {
 identifier: [0, 'id'],
 editable: [[1, 'name'],[2, 'description']],
 },
 restoreButton: false,
 onSuccess: function (data, textStatus, jqXHR) {
 $('#fee_type_group').DataTable().ajax.reload();
 $.ajax({

   url :  '{{  route('fee_type_groups.load')   }}',
   success:function(response){
      $('#fee_group').html(response);
   }

  });
 }
 });
 });


 $('.tabledit-edit-button').html('Edit').trigger('change');




 $('#semester_add_row').click(function(){

   let duplicate_row =   $('#semester_duplicate').clone().removeAttr('style id');
   $(this).parents('#semesters_div').append(duplicate_row);

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
        if(response.status == 500){
         toastr.error('Server Error', 'error');
        }


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

 $('#fee_adrow').css({'margin-top':'29px'});
 {{-- $('#save_fee_payment').css({''}) --}}

 @endsection




























