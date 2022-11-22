@extends('layouts.app')

@section('content-heading')
    
          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li  class="breadcrumb-item"><a href="{{route('configurations.school.academic.year.index')}}">Academic Years</a></li>
                <li  class="breadcrumb-item"><a href="{{route('configurations.school.academic.year.semester.index',$acd_year)}}">Semesters</a></li>
                <li class="breadcrumb-item active" aria-current="page">New</a></li>
              </ol>
          </nav>
  
@endsection 

@section('content-body')

<div class="container-fluid">

<div class="card" style="100%">

<div class="card-body">
<div class="container-fluid" style="100%">
            <div class="card">
               <div class="card-header">
                  <div class="btn-group btn-group-toggle" style="margin-left:90%" >
                    
                  </div>
               </div>
               <div class="card-body">
                  <form action="" id="semester_form">
                   <div class="row">
                      <div class="col-md-12">
                         <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for=""> Name </label>
                                 <input type="text" name="semester" value="{{ $semester ? $semester->name : '' }}" placeholder="eg. semester 1" class="form-control form-control-sm" id="class_name">
                                 <input type="hidden"  id="s_id" name="s_id" value="{{ $semester ? $semester->id : ''  }}">
                              </div>    
                            </div>
      
                            <div class="col-md-4">
                              <div class="form-group">
                                 <label for=""> Start Date </label>
                                 <input type="date" name="start_date" value="{{ $semester ? $semester->start_date : '' }}"  class="form-control form-control-sm" id="start_date">
                              </div>
                            </div>
      
                            <div class="col-md-4">
                              <div class="form-group">
                                 <label for="">  End Date </label>
                                 <input type="date" name="end_date" value="{{ $semester ? $semester->end_date : '' }}" class="form-control form-control-sm" id="end_date">
                              </div>
                            </div>
                         </div>
                      </div>
                   </div>

                   <button class="btn btn-primary btn-sm float-right" id="submit"> Submit </button>

                  </form>

                  
                </div>

              
             </div>
                  </div>
            </div>
         </div>
      </div>
@endsection

@section('scripts')


$('#submit').click(function(e){
   e.preventDefault();

   let form_data = $('#semester_form').serialize();
   let init_url = '{{ route('configurations.school.academic.year.semester.store',[':id'])  }}';
   let s_id = $('#s_id').val();
   let url = init_url.replace(':id',{{$acd_year}});

   $.ajax({
   method:'POST',
   url: url,
   data:form_data,
   success:function(response){
   console.log(response);
      if(response.state == 'Done'){
         
         let url = '{{ route('configurations.school.academic.year.semester.index',$acd_year) }}';
         console.log(url);
         window.location.href = url;

        }
        if(response.state == 'Fail'){
 
         toastr.error(response.msg, response.title);
 
        }
 
        if(response.state == 'Error'){
 
         toastr.error(response.msg, response.title);
 
        }
   
   },
   
   error: function(response){
   
      if(response.status == 500){
         toastr.error('Internal Server Error', 'error');
      }
      console.log(response);
   
   
   }
   
   });

});




@endsection
