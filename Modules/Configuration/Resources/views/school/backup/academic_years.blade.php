
@extends('layouts.app')
@section('content-breadcrumbs')
<nav aria-label="breadcrumb" style="width: 100%;">
   <ol class="breadcrumb" style="background-color: rgb(255, 249, 249)">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Academic Year</a></li>
      <li class="breadcrumb-item active" aria-current="page">Settings</li>
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
                   <h4 class="card-title">School Profile</h4>
                </div>
             </div>
            
             @include('configuration::school.includes.tabs')
               <div class="container">
                   <div class="form-card text-left">
                      {{-- <div class="row"> --}}
                            <h6 class="mb-4" style="text-align: center">SEASONS:</h6>
                         <hr style=" height: 5px;
                         background-color:#2E9AFE ;
                         border: none;">

                         
                     <form id="seasons_and_classes_form" action="javascript:void(0)" enctype="multipart/form-data">
                        @csrf
                      <div id="seasons_div">

                        <div class="row">
                           <div class="col-md-4">
                               <div class="form-group">
                                  <label for="season_name">Season Name</label>
                                  <input type="text" class="form-control" name="season_name[]" >
                               </div>

                           </div>
                           <div class="col-md-3">
                              <div class="form-group form-group-sm">
                                 <label for="Start Date">Start Date</label>
                                 <input type="date" class="form-control" name="season_start_date[]" >
                                 <input type="hidden" name="school_id" id="school_id" >
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group form-group-sm">
                                 <label for="End Date">End Date</label>
                                 <input type="date" class="form-control" name="season_end_date[]" >
                              </div>
                          </div>
{{--                           <div class="col-md-1">
                                 <button type="button" style="color:black; margin-top:70%" class="btn btn-primary btn-sm fa fa-plus " id="add_row"> </button>
                          </div> --}}


                       </div>
                      </div>

                      <h6 style="text-align: center;margin-top: 4%">SEMESTERS</h6>
                      <hr style=" height: 5px;
                      background-color:#2E9AFE ;
                      border: none;">       
                      <div id="semesters_div">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group form-group-sm">
                                   <label for="Semester Name">Semester/Term</label>
                                   <input type="text" class="form-control" name="semester_name[]" >
                                </div>

                            </div>
                            <div class="col-md-3">
                               <div class="form-group form-group-sm">
                                  <label for="Start Date">Start Date</label>
                                  <input type="date" class="form-control" name="semester_start_date[]" >
                                  <input type="hidden" name="school_id" id="school_id">
                               </div>
                           </div>
                           <div class="col-md-3">
                               <div class="form-group form-group-sm">
                                  <label for="End Date">End Date</label>
                                  <input type="date" class="form-control" name="semester_end_date[]" >
                               </div>
                           </div>
                           <div class="col-md-1">
                                  <button type="button" style="color:black; margin-top:70%" class="btn btn-primary btn-sm fa fa-plus " id="semester_add_row"> </button>
                           </div>


                        </div>

                     </div>
                    
                     <h6 style="text-align: center; margin-top:4%;"  class="mb-4">CLASSES:</h6>
                     <hr style=" height: 5px;
                     background-color:#2E9AFE ;
                     border: none;">
                      <div class="row" style="margin-top: 2%">
                          <div id="classes_row">                                
                            
                             <div class="row">
                                 <div class="col-md-4">
                                     <div class="form-group form-group-sm" style="margin-left: 12px">
                                        <label for="class_name">Class Name</label>
                                        <input type="text" name="class_name[]" class="form-control" >
                                     </div>
    
                                 </div>
                                 <div class="col-md-2">
                                    <div class="form-group form-group-sm">
                                       <label for="Symbol">Symbol</label>
                                       <input type="text" class="form-control" name="symbol[]" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                       <label for="Streams">Streams</label>
                                       <select class="multiple_select form-control streams" multiple name="streams[0][]" style="width: 100%">
                                          <option value="A">A</option>
                                          <option value="B">B</option>
                                          <option value="C">C</option>
                                          <option value="D">D</option>
                                      </select>
                                        {{-- <input type="text" class="form-control" name="streams[]" > --}}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                 <div class="form-group form-group-sm">
                                    <label for="Short Form">Short Form</label>
                                    <input type="text" class="form-control" name="short_form[]" >
                                 </div>
                             </div>
                                
                                <div class="col-md-1">
                                       <button type="button" style="color:black; margin-top:90%" class="btn btn-primary btn-sm fa fa-plus" id="class_add_row"> </button>
                                </div>
    
                             </div>
                          </div>
                      </div>
                     </form>
                   </div>
                  </div>
                   <button type="button" {{-- name="next" --}} style="margin-top:2%" class="btn btn-primary float-right" id="save_seasons_n_classes" >Save</button>

          </div>
       </div>
      
    </div>
 </div>
 @include('configuration::registration.form_duplicates')

 @endsection


 @section('scripts')

 var class_index = 0;



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
 
      $('#class_add_row').click(function(){
         
         
         let duplicate_row = $('#class_duplicate_row').clone().removeAttr('style id')
         duplicate_row.find('.multiple_select_duplicate').select2();   
         $(this).parents('#classes_row').append(duplicate_row);
         class_index += 1;
         duplicate_row.find('.streams').attr('name', 'streams['+class_index+'][]').trigger('change');
         removeRow(duplicate_row);
                
 
      });
 
      
    function removeRow(duplicate_row){
     duplicate_row.find('.remove_row').click(function(){
             $(this).parent().parent().remove();
             console.log('remove');
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

 
 /* SEASONS & CLASSES SAVE */
 
 
 
 
 $('#save_seasons_n_classes').click(function(e){
    e.preventDefault();
    let school_id = $('#school_id').val();
    let form_data = $('#seasons_and_classes_form').serialize();
    console.log(form_data)
    let url = '{{route('configurations.school.seasons.store',':id')}}';
    url = url.replace(':id',@php echo $school_details->id @endphp);
     $.ajax({
        type:'POST',
        url:url,
        data:form_data,
        success: function(response){
         window.location.replace(response);
        }
     })
 
 });

 $('.multiple_select').select2({
   multiple: true
 });

 @endsection





















 






