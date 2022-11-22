
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
       
      {{-- @include('configuration::school.includes.school_profile') --}}

       <div class="col-md-12">
          <div class="card card-block card-stretch card-height">
             <div class="card-header">
                <div class="header-title">
                </div>
             </div>
            
             {{-- @include('configuration::school.includes.tabs') --}}
                    <div class="container">
                   <div class="form-card text-left">
                            <h6 class="mb-4" style="text-align: center">SEASON:</h6>
                         <hr style=" height: 5px;
                         background-color:#2E9AFE ;
                         border: none;">

                         
                     <form id="seasons_and_classes_form" action="javascript:void(0)" enctype="multipart/form-data">
                      <div id="seasons_div">

                        @foreach ($academic_year_seasons as $academic_year )

                        <div class="row">
                           <div class="col-md-1"></div>
                           <div class="col-md-10">
                              <div class="row">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="season_name">Season Name</label>
                                       <input type="text" class="form-control form-control-sm" value="{{ $academic_year->name }}" name="season_name[]" >
                                       <input type="hidden" name="hidden_season_id" value="{{ $season_id }}">
                                    </div>
     
                                </div>

                                <div class="col-md-4">
                                 <div class="form-group form-group-sm">
                                    <label for="Start Date">Start Date</label>
                                    <input type="date" class="form-control form-control-sm" value="{{ $academic_year->start_date }}" name="season_start_date[]" >
                                    {{-- <input type="hidden" name="school_id" id="school_id" value=" {{$school_details->id}} "> --}}
                                 </div>
                                 </div>

                                 <div class="col-md-4">
                                    <div class="form-group form-group-sm">
                                       <label for="End Date">End Date</label>
                                       <input type="date" class="form-control form-control-sm" value="{{ $academic_year->end_date  }}" name="season_end_date[]" >
                                    </div>
                                </div>
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
                           <div class="col-md-1"></div>
                           <div class="col-md-10">
                              <div class="row">
                                 <div class="col-md-4">
                                    <div class="form-group form-group-sm">
                                       <label for="Semester Name">Semester/Term</label>
                                       <input type="text" class="form-control form-control-sm" value="{{ $semester->name }}" name="semester_name[]" >
                                       <input type="hidden" name="hidden_semester_id[]" value="{{ $semester->id }}">
                                    </div>
    
                                </div>

                                <div class="col-md-3">
                                 <div class="form-group form-group-sm">
                                    <label for="Start Date">Start Date</label>
                                    <input type="date" class="form-control form-control-sm" value="{{ $semester->start_date }}" name="semester_start_date[]" >
                                    {{-- <input type="hidden" name="school_id" id="school_id" value="{{$school_details->id}}"> --}}
                                 </div>
                             </div>

                             <div class="col-md-4">
                              <div class="form-group form-group-sm">
                                 <label for="End Date">End Date</label>
                                 <input type="date" class="form-control form-control-sm" value="{{ $semester->end_date }}"  name="semester_end_date[]" >
                              </div>
                           </div>


                           @if ($semesters_index == 0)
                           <div class="col-md-1">
                            <button type="button" style="color:black; margin-top:50%" class="btn btn-primary btn-sm fa fa-plus " id="semester_add_row"> </button>
                            </div> 
                            @else
                            <div class="col-md-1">
                                <button type="button" style="color:black; margin-top:50%" class="btn btn-warning btn-sm fa fa-minus remove_row"> </button>
                           </div>
                           @endif
                              </div>

                           </div>

                        </div>
                        @endforeach
                     </div>

                     
                     <h6 style="text-align: center; margin-top:4%;"  class="mb-4">CLASSES:</h6>
                     <hr style=" height: 5px;
                     background-color:#2E9AFE ;
                     border: none;">
                     <div id="classes_row">
                        {{-- @php
                           dump($streams);
                        @endphp --}}
                             @foreach ( $classes as $class_index => $class )
                             <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group form-group-sm" style="margin-left: 12px">
                                          <label for="class_name">Class Name</label>
                                          <input type="text" value="{{$class->name}}" name="class_name[]" class="form-control form-control-sm" >
                                          <input type="hidden" name="class_id[]" value="{{$class->id}}">
                                       </div>
      
                                   </div>

                                   <div class="col-md-2">
                                    <div class="form-group form-group-sm">
                                       <label for="Symbol">Symbol</label>
                                       <input type="text" class="form-control form-control-sm" value="{{$class->symbol}}" name="symbol[]" >
                                    </div>
                                 </div>

                                <div class="col-md-2">
                                 <div class="form-group form-group-sm">
                                    <label for="Short Form">Short Form</label>
                                    <input type="text" class="form-control form-control-sm" value="{{$class->short_form}}" name="short_form[]" >
                                 </div>
                             </div>
                             <div class="col-md-3">
                              <div class="form-group form-group-sm">
                                 <label for="Streams">Streams</label>
                                 {{-- <input type="hidden" value="{{}}"> --}}
                               
                                 <select class="multiple_select form-control" multiple name="streams[{{ $class->id }}][]" style="width: 100%">
                                    @foreach ($streams_all as $single_stream )

                                    <option {{ isset($streams[$class->id]) && !empty($streams[$class->id]) && in_array($single_stream->id,$streams[$class->id]) ? "selected" : "" }} value="{{ $single_stream->id }}">{{$single_stream->name}}</option>
                                       
                                    @endforeach
                                </select>
                                  {{-- <input type="text" class="form-control" name="streams[]" > --}}
                              </div>
                          </div>

                             @if ($class_index == 0)
                             <div class="col-md-1">
                                 <button type="button" style="color:black; margin-top:70%" class="btn btn-primary btn-sm fa fa-plus" id="class_add_row"> </button>
                          </div>
                          @else
                          <div class="col-md-1">
                             
                              <button type="button" style="color:black; margin-top:65%" class="btn btn-warning btn-sm fa fa-minus remove_row "> </button>
                             
                        </div>
                             @endif
                                 </div>

                                </div>

                             </div>
                             @endforeach

                     </form>
                   </div>
                </div>
                <div class="row justify-content-md-end" style="margin-right:4%">
                  <div class="form-group">
                     <button type="button" style="margin-top:2%" class="btn btn-primary btn-sm float-right" id="save_season"> <i class="fa fa-paper-plane"></i> Save</button>
                  </div>
                  
               </div>

          </div>
       </div>
      
    </div>
 </div>

 <div class="row" id="class_duplicate_row" style="display: none">
   <div class="col-md-1"></div>
   <div class="col-md-10">
      <div class="row">
         <div class="col-md-4">
            <div class="form-group" style="margin-left: 12px">
               <input type="text" class="form-control form-control-sm" name="class_name[]" >
            </div>
         
         </div>

         <div class="col-md-2">
            <div class="form-group">
               <input type="text" class="form-control form-control-sm" name="symbol[]" >
            </div>
          </div>

      
         <div class="col-md-2">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="short_form[]" >
            </div>
            </div>

            <div class="col-md-3">
               <div class="form-group form-group-sm">
                     <select class="multiple_select_duplicate form-control streams" multiple name="streams[][]" style="width: 100%">
                                     @foreach ($streams_all as $single_stream )
 
                                     <option  value="{{ $single_stream->id }}">{{$single_stream->name}}</option>
                                        
                                     @endforeach
                                 </select>
                   {{-- <input type="text" class="form-control" name="streams[]" > --}}
               </div>
            </div>

            <div class="col-md-1">
               <button type="button" style="color:black; margin-top:20%" class="btn btn-warning btn-sm fa fa-minus remove_row "> </button>
          </div>

      </div>

   </div>

</div>



 @include('configuration::registration.form_duplicates')

 @endsection


 @section('scripts')

 var class_index = {{ $latest_id }};
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
         

         let duplicate_row = $('#class_duplicate_row').clone().removeAttr('style id');
         duplicate_row.find('.multiple_select_duplicate').select2();   
         $(this).parents('#classes_row').append(duplicate_row);

         class_index += 1;
         duplicate_row.find('.streams').attr('name', 'streams['+class_index+'][]').trigger('change');
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
 
 $('#save_season').click(function(e){
   e.preventDefault();
   {{-- alert('woi'); --}}
   let school_id = $('#school_id').val();
   let form_data = $('#seasons_and_classes_form').serializeArray();
   let url = '{{route('school.settings.seasons.update',':id')}}';
   url = url.replace(':id',school_id);
      $.ajax({
      type: "POST",
       url: url,
       data: form_data,
       dataType: "JSON",
       success: function (response) {
           console.log(response.state);

        if(response.state == 'Done'){
           console.log(response);

          let id = $('#school_id').val();
          let init_url = '{{ route('school.settings.profile','id') }}';
          let url = init_url.replace('id',id);
          window.location.replace(url);
          {{-- toastr.success(response.msg, response.title); --}}

       }
            

       else if(response.state == 'Fail'){
         console.log(response); 
           toastr.error(response.msg, response.title)


       }

       else if(response.state == 'Error'){
          console.log(response)
          toastr.error(response.msg, response.title)

      }

   },
   error: function(response){

       toastr.error(response.msg, response.title);
       
       console.log(response.state);

 }

  }); 

});

 {{-- $('#save_season').click(function(e){
    e.preventDefault();
    let school_id = $('#school_id').val();
    let form_data = $('#seasons_and_classes_form').serializeArray();
    let url = '{{route('school.settings.seasons.update',':id')}}';
    url = url.replace(':id',school_id);
       $.ajax({
       type: "POST",
        url: url,
        data: form_data,
        dataType: "JSON",
        success: function (response) {

         if(response.state == 'Done'){
            console.log(response);
           let id = $('#school_id').val();
           let init_url = '{{ route('school.settings.profile','id') }}';

           let url = init_url.replace('id',id);
           window.location.replace(url);
      

        }
             

        else if(response.state == 'Fail'){
           console.log(response);
            toastr.warning(response.msg, response.title)

        }
        else if(response.state == 'Error'){

         toastr.error(response.msg, response.title)

        }

    },
    error: function(response){
       if(response.state == 'Error'){
         console.log(response);

         toastr.error(response.msq, response.title);

       }
             
    }

   }); 
 
 }); --}}

 $('.multiple_select').select2({
   multiple: true
 });

 @endsection





















 






