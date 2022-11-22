@extends('layouts.app')

@section('content-heading')
          <nav aria-label="breadcrumb" style="width: 100%">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Configurations</a></li>
              <li class="breadcrumb-item" aria-current="page"> <a href="{{route('configurations.school.streams')}}"> Streams</a> </li>
              <li class="breadcrumb-item active" aria-current="page">Edit</a></li>
            </ol>
          </nav>
  

@endsection 

@section('content-body')
<div class="card" style="width:100%">
               <div class="card-body">
                  <form action="" id="streams_form">
                   <div class="row">
                      <div class="col-md-12">
                         <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="Stream Name"> Stream Name </label>
                                 <input type="text" name="stream_name" value="{{ $stream ? $stream->name : '' }}" placeholder="eg. A" class="form-control form-control-sm" id="stream_name">
                                 <input type="hidden" name="stream_id" value="{{ $stream ? $stream->id : '' }}">
                              </div>
                            </div>
      
                            <div class="col-md-4">
                              <div class="form-group">
                                 <label for="Class"> Class </label>
                                 <select name="class_id" id="class_id" class="form-control form-control-sm">
                                     <option value="">Select Class</option>

                                     @foreach ($classes as $class )
                                         <option value="{{$class->id}}"  {{  !empty($stream) ? $stream->account_school_detail_class_id == $class->id ? 'selected' : '' : ''  }}  > {{ $class->name }} </option>
                                     @endforeach

                                 </select>
                              </div>
                            </div>
      
                            <div class="col-md-4">
                              <div class="form-group">
                                 <label for="">  Note / Description </label>
                                 <input name="description" id="description" class="form-control form-control-sm"  value="{{ $stream ? $stream->description : '' }}">
                              </div>
                            </div>
                         </div>
                      </div>
                   </div>

                   <a type="btn" style="color: white !important" class="btn btn-primary btn-sm float-right" id="submit" > Submit </a>

                  </form>

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
    
       console.log(response)
    
    },
    
    error: function(response){
    
       console.log(response);
    
    }
    
    });
 
 });



@endsection
   









 






