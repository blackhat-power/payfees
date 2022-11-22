
@extends('layouts.app')

@section('content-breadcrumbs')
<nav aria-label="breadcrumb" style="width: 100%;">
   <ol class="breadcrumb" style="background-color: rgb(255, 249, 249)">
      <li class="breadcrumb-item"><a href="{{ route('configurations.school.dashboard',$school_details->id) }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('configurations.school.profile',$school_details->id) }}">Students Management</a></li>
      <li class="breadcrumb-item"><a href="{{ route('configurations.school.classes.profile',$school_details->id)  }}">Classes</a></li>
      <li class="breadcrumb-item active" aria-current="page">Students</li>
   </ol>
</nav>
<hr>
@endsection

@section('content-body')


<div class="container-fluid">
    <div class="row">
       
      @include('configuration::school.includes.school_profile')

       <div class="col-lg-9 col-md-6">
          <div class="card card-block card-stretch card-height">
             <div class="card-header">
                <div class="header-title">
                   <h4 class="card-title">Profile</h4>
                </div>
             </div>
            
             @include('configuration::school.includes.tabs')
             <h6 style="text-align: center"> List of Students </h6>
                              <hr>
                              <div class="card-body">
                                 <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                       <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">List of Classes</a>
                                    </li>
                                    <li class="nav-item">
                                       <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">List of Students</a>
                                    </li>
                                    <li class="nav-item">
                                       <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Collections</a>
                                    </li>
                                 </ul>
                                 <div class="tab-content" id="pills-tabContent-2">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                                       <div class="container-fluid" style="100%">
                                          <div class="row">
                                                <div class="col-sm-12">
                                                   <div class="card">
                                                      <div class="card-body">
                                                            <div class="table-responsive">

                                                               <table class="table" id="classes_table" style="width: 100%">
                                                                  <thead>
                                                                     <tr>
                                                                        <th>Name</th>
                                                                        <th>Class</th>
                                                                        <th>Date Of Join</th>
                                                                        <th>Bill Payable</th>
                                                                        <th>Bill Paid</th>
                                                                        <th>Bill Balance</th>
                                                                        <th>Action</th>
                                                                     </tr>
                                                                  </thead>
                                                               </table>
                                                            </div>
                                                         </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    <div class="tab-pane fade" id="pills-profile" style="width: 100%" role="tabpanel" aria-labelledby="pills-profile-tab">
                                       <table class="table">
                                          <thead>
                                             <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col"> Class</th>
                                                <th scope="col">Date of Join</th>
                                                <th scope="col">Bill Payable</th>
                                                <th>Bill Paid</th>
                                                <th>Bill Balance</th>
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>

                                          </tbody>
                                       </table> 
                                    </div>
                                 </div>
                              </div>


                         
             


          </div>
       </div>
      
    </div>
 </div>
 

 @endsection


 @section('scripts')


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
 
    
   /*    $('#fees').find('.duplicate_fee_add_row').each(function () {
         
         $(this).click(function(){
            console.log('cliked');
          let duplicate_row = $('#fee_structure_inner_row').clone().removeAttr('style id')
          $(this).closest('.duplicate').append(duplicate_row);
          removeRow(duplicate_row);
         });
         
      }); */
      $('#save_fee_payment').click(function(){
         let form_data = $('#fee_payment_form').serialize();
         let school_id = $('#school_id').val();
          
         let url = '{{route('configurations.school.fee.structure.store',':id')}}';
    url = url.replace(':id',school_id);
       $.ajax({
       type: "POST",
        url: url,
        data: form_data,
        dataType: "JSON",
        success: function (response) {
     }
   }); 
      });
 
      $('#class_add_row').click(function(){
 
         let duplicate_row = $('#class_duplicate_row').clone().removeAttr('style id')
         $(this).parents('#classes_row').append(duplicate_row);
         removeRow(duplicate_row);
 
      });
 
      $('.fee_add_row').click(function(){
       let duplicate_row = $('#fee_structure_inner_row').clone().removeAttr('style id')
          $(this).parents('#fees_append').append(duplicate_row);
          removeRow(duplicate_row);
      }); 
 
   
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

 let class_url = '{{ route('configurations.school.classes.profile.students.datatable',':id') }}';
 
 class_url = class_url.replace(':id',  @php echo $school_details->id @endphp)
   classes_datatable = $('#classes_table').DataTable({
     processing: true,
     serverSide: true,
      ajax:class_url,
      columns:[
         {data:'full_name', name:'full_name'},
         {data:'streams', name:'streams'},
          {data: 'date', name:'date'},
          {data:'bill_payable', name:'bill_payable'},
          {data:'bill_paid', name:'bill_paid'},
          {data:'bill_balance', name:'bill_balance'},
          {data:'action', name:'action', orderable:false, searchable:false}
      ],
 });
 
 
{{-- SEMESTERS --}}

{{-- $('body').on('click','.more-details-1',function(){

}); --}}

 
 /* SEASONS & CLASSES SAVE */
 
 
 
 
 $('#save_seasons_n_classes').click(function(e){
    e.preventDefault();
    let school_id = $('#school_id').val();
    let form_data = $('#seasons_and_classes_form').serialize();
    let url = '{{route('configurations.school.seasons.store',':id')}}';
    url = url.replace(':id',school_id);
       $.ajax({
       type: "POST",
        url: url,
        data: form_data,
        dataType: "JSON",
        success: function (response) {
     }
   }); 
 
 });

 $('.multiple_select').select2({
   multiple: true
 });

 @endsection





















 






