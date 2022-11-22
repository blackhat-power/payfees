@extends('layouts.app')

@section('content-heading')
          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li> 
                <li  class="breadcrumb-item"><a href="{{route('configurations.school.academic.year.index')}}">Academic Year</a></li>       
                <li class="breadcrumb-item active" aria-current="page">New</a></li>
              </ol>
          </nav>
  
@endsection 

@section('content-body')

<div class="card" style="width: 100%">
   <div class="card-header bg-red">
     <span class="text-white">Important : Choose Session Start Date Carefully</span> 
   </div>
   <div class="card-body">
      <div class="row">
         <div class="col-md-12"> <span><i class="fa fa-bullhorn" aria-hidden="true"></i> Fees calculation as well as Other Academic activity is dependent on the Session .</span> &nbsp;&nbsp; <b>So before Saving Make sure You Confirm The Dates</b>  </div>
         <div class="col-md-12"><span> <i class="fa fa-bullhorn" aria-hidden="true"></i> Only One Academic Year Should be Active. </span> </div>
      </div>
     
     
   </div>
</div>

<div class="card" style="width:100%">

<div class="card-body">
   
                  <form action="" id="academic_year_form">
                   <div class="row">
      
                      <div class="col-md-12">
                         <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for=""> Namess </label>
                                 <input type="number" name="year" value="{{ $academic_year ? $academic_year->name : '' }}" placeholder="eg. 2022" class="form-control form-control-sm" id="class_name">
                                 <input type="hidden"  name="year_id" value="{{ $academic_year ? $academic_year->id : ''  }}">
                              </div>
                            </div>
      
                            <div class="col-md-3">
                              <div class="form-group">
                                 <label for=""> Start Date </label>
                                 <input type="date" name="start_date" value="{{ $academic_year ? $academic_year->start_date : '' }}"  class="form-control form-control-sm" id="start_date">
                              </div>
                            </div>
      
                            <div class="col-md-3">
                              <div class="form-group">
                                 <label for="">  End Date </label>
                                 <input type="date" name="end_date" value="{{ $academic_year ? $academic_year->end_date : '' }}" class="form-control form-control-sm" id="end_date">
                              </div>
                            </div>
                            
                            <div class="col-md-2">
                              <div class="form-group">
                                 <label for="">  Status </label>
                                 <select name="academic_year_status" id="academic_year_status" class="form-control form-control-sm">
                                    <option value="active">Active</option>
                                 <option value="deactive">Deactive</option>
                                 </select>
                                 
                              </div>
                            </div>

                         </div>
                      </div>
                   </div>
               
                     
                        <button class="btn btn-primary btn-sm float-right" id="submit"> Submit </button>
                      
                  

                  

                  </form>

                  
                </div>

              
             </div>
@endsection

@section('scripts')


$('#submit').click(function(e){
   e.preventDefault();

   let form_data = $('#academic_year_form').serialize();
   let url = '{{ route('configurations.school.academic.year.store')  }}';
   
   $.ajax({
   method:'POST',
   url: url,
   data:form_data,
   success:function(response){
   console.log(response);
      if(response.state == 'Done'){
         
         let url = '{{ route('configurations.school.academic.year.index') }}';
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
