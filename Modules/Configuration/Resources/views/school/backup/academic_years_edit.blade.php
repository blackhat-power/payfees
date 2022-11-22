
@extends('layouts.app')
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
                      <div id="seasons_div">

                        @foreach ($academic_year_seasons as $academic_year )

                        <div class="row">
                           <div class="col-md-4">
                               <div class="form-group">
                                  <label for="season_name">Season Name</label>
                                  <input type="text" class="form-control" value="{{ $academic_year->name }}" name="season_name[]" >
                               </div>

                           </div>
                           <div class="col-md-3">
                              <div class="form-group form-group-sm">
                                 <label for="Start Date">Start Date</label>
                                 <input type="date" class="form-control" value="{{ $academic_year->start_date }}" name="season_start_date[]" >
                                 {{-- <input type="hidden" name="school_id" id="school_id" value=" {{$school_details->id}} "> --}}
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group form-group-sm">
                                 <label for="End Date">End Date</label>
                                 <input type="date" class="form-control" value="{{ $academic_year->end_date  }}" name="season_end_date[]" >
                              </div>
                          </div>
                       </div>

                       @endforeach
                      </div>

                      <h6 style="text-align: center;margin-top: 4%">SEMESTERS</h6>
                      <hr style=" height: 5px;
                      background-color:#2E9AFE ;
                      border: none;">       
                      <div id="semesters_div">
                        @foreach ($academic_year_semesters as $semesters_index => $semester )
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group form-group-sm">
                                   <label for="Semester Name">Semester/Term</label>
                                   <input type="text" class="form-control" value="{{ $semester->name }}" name="semester_name[]" >
                                </div>

                            </div>
                            <div class="col-md-3">
                               <div class="form-group form-group-sm">
                                  <label for="Start Date">Start Date</label>
                                  <input type="date" class="form-control" value="{{ $semester->start_date }}" name="semester_start_date[]" >
                                  {{-- <input type="hidden" name="school_id" id="school_id" value="{{$school_details->id}}"> --}}
                               </div>
                           </div>
                           <div class="col-md-3">
                               <div class="form-group form-group-sm">
                                  <label for="End Date">End Date</label>
                                  <input type="date" class="form-control" value="{{ $semester->end_date }}"  name="semester_end_date[]" >
                               </div>
                           </div>
                           @if ($semesters_index == 0)
                           <div class="col-md-1">
                            <button type="button" style="color:black; margin-top:70%" class="btn btn-primary btn-sm fa fa-plus " id="semester_add_row"> </button>
                            </div> 
                            @else
                            <div class="col-md-1">
                                <button type="button" style="color:black; margin-top:70%" class="btn btn-warning btn-sm fa fa-minus remove_row"> </button>
                           </div>
                           @endif
                           


                        </div>
                        @endforeach
                     </div>
                    
                     <h6 style="text-align: center; margin-top:4%;"  class="mb-4">CLASSES:</h6>
                     <hr style=" height: 5px;
                     background-color:#2E9AFE ;
                     border: none;">
                      <div class="row" style="margin-top: 2%">
                          <div id="classes_row">
                             @foreach ( $classes as $class_index => $class )
                                
                            
                             <div class="row">
                                 <div class="col-md-4">
                                     <div class="form-group form-group-sm" style="margin-left: 12px">
                                        <label for="class_name">Class Name</label>
                                        <input type="text" value="{{$class->name}}" name="class_name[]" class="form-control" >
                                        <input type="hidden" name="class_id[]" value="{{$class->id}}">
                                     </div>
    
                                 </div>
                                 <div class="col-md-2">
                                    <div class="form-group form-group-sm">
                                       <label for="Symbol">Symbol</label>
                                       <input type="text" class="form-control" value="{{$class->symbol}}" name="symbol[]" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-sm">
                                       <label for="Streams">Streams</label>
                                       {{-- <input type="hidden" value="{{}}"> --}}
                                       <select class="multiple_select form-control" multiple name="streams[{{$class_index}}][]" style="width: 100%">
                                          @foreach ($streams[$class->id] as $stream_index => $stream)
                                          <option value="A"  {{ $stream->stream_name == 'A' ? 'selected' : '' }}>A</option>
                                          <option value="B" {{ $stream->stream_name == 'B' ? 'selected' : '' }}>B</option>
                                          <option value="C" {{ $stream->stream_name == 'C' ? 'selected' : '' }}>C</option>
                                          <option value="D" {{ $stream->stream_name == 'D' ? 'selected' : '' }}>D</option>
                                          @endforeach
                                      </select>
                                        {{-- <input type="text" class="form-control" name="streams[]" > --}}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                 <div class="form-group form-group-sm">
                                    <label for="Short Form">Short Form</label>
                                    <input type="text" class="form-control" value="{{$class->short_form}}" name="short_form[]" >
                                 </div>
                             </div>
                                @if ($class_index == 0)
                                <div class="col-md-1">
                                    <button type="button" style="color:black; margin-top:70%" class="btn btn-primary btn-sm fa fa-plus" id="class_add_row"> </button>
                             </div>
                             @else
                             <div class="col-md-1">
                                <button type="button" style="color:black; margin-top:80%" class="btn btn-warning btn-sm fa fa-minus remove_row "> </button>
                           </div>
                                @endif
                               
                             </div>
                             @endforeach
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
         removeRow(duplicate_row);
         
       
 
      });
 
 
      
    function removeRow(duplicate_row){
    let row = duplicate_row.find('.remove_row');
     row.click(function(){
        $(this).parent().parent().remove();
        console.log('remove');
        }) 
    
   }
removeClass();
   function removeClass(){
   let row = $('#classes_row').find('.remove_row');
   row.click(function(){
    $(this).parent().parent().remove();
   });
   }

   removeSemester();
   function removeSemester(){
   let row = $('#semesters_div').find('.remove_row');
   row.click(function(){
    $(this).parent().parent().remove();
   });
   }

   
   function removeDiv(duplicate_row){
    duplicate_row.find('.remove_div').click(function(){
             $(this).parent().parent().parent().remove();
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
 




 
 {{--  SEASONS & CLASSES SAVE  --}}
 
 

 $('#save_seasons_n_classes').click(function(e){
    e.preventDefault();
    let school_id = $('#school_id').val();
    let form_data = $('#seasons_and_classes_form').serializeArray();
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





















 






