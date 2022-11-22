@extends('layouts.app')

@section('content-heading')



    
          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Classes</a></li>
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Streams</a></li>
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
                  <form action="" id="streams_form">
                   <div class="row">
                      <div class="col-md-1"></div>
                      <div class="col-md-10">
                         <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                   <label for="Class"> Class </label>
                                   <select name="class_id" id="class_id" class="form-control" readonly>
                                           <option value="{{$class_id}}" selected> {{ $class_name }} </option>
                                   </select>
                                </div>
                              </div>

                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="Stream Name"> Stream Name </label>
                                 <input type="text" name="stream_name" value="{{ $stream ? $stream->name : '' }}" placeholder="eg. A" class="form-control" id="stream_name">
                                 <input type="hidden" name="stream_id" value="{{ $stream ? $stream->id : '' }}">
                              </div>
                            </div>
      
                            <div class="col-md-4">
                              <div class="form-group">
                                 <label for="">  Note / Description </label>
                                 <input name="description" id="description" class="form-control"  value="{{ $stream ? $stream->description : '' }}">
                              </div>
                            </div>
                         </div>
                      </div>
                   </div>

                   <button class="btn btn-primary float-right" id="submit" > Submit </button>

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
 
    let form_data = $('#streams_form').serialize();
    let url = '{{ route('configurations.school.streams.store')  }}';
    
    $.ajax({
    method:'POST',
    url: url,
    data:form_data,
    
    success:function(response){
    
       if(response.state == 'Done'){
        let class_id = response.data.account_school_detail_class_id;
        let init_url =   '{{ route('configurations.school.classes.streams',':id') }}';
        let url = init_url.replace(':id',class_id);

        console.log(class_id);
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
    
    }
    
    });
 
 });



@endsection
   









 






