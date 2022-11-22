@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('configurations.school.classes')}}">Classes</a></li>
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
                  <form action="" id="classes_form">
                   <div class="row">
                      <div class="col-md-12">
                         <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="">  Class Name </label>
                                 <input type="text" name="class_name" value="{{ $class ? $class->name : '' }}" placeholder="eg. FORM 1" class="form-control form-control-sm" id="class_name">
                                 <input type="hidden"  name="class_id" value="{{ $class ? $class->id : ''  }}">
                              </div>
                            </div>
      
                            <div class="col-md-4">
                              <div class="form-group">
                                 <label for=""> Symbol </label>
                                 <input type="text" name="class_symbol" value="{{ $class ? $class->symbol : '' }}"  class="form-control form-control-sm" id="symbol">
                              </div>
                            </div>
      
                            <div class="col-md-4">
                              <div class="form-group">
                                 <label for="">  Short Form </label>
                                 <input type="text" name="short_form" value="{{ $class ? $class->short_form : '' }}" class="form-control form-control-sm" id="short_form">
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

   let form_data = $('#classes_form').serialize();
   let url = '{{ route('configurations.school.classes.store')  }}';
   
   $.ajax({
   method:'POST',
   url: url,
   data:form_data,
   success:function(response){
   
      if(response.state == 'Done'){
         
         let url = '{{ route('configurations.school.classes') }}';
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
   
      console.log(response);
   
   
   }
   
   });

});




@endsection
