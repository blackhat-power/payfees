@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Finance Management</li>
                <li  class="breadcrumb-item active" aria-current="page">Account Settings</li>
                <li  class="breadcrumb-item"><a href="{{route('accounts.sub.groups.index')}}">Account SubGroup</a></li>
                <li class="breadcrumb-item active" aria-current="page">New Account</a></li>
                <li class="ml-auto"> <a id="comment" style="color: #551a8b !important" href="{{route('configurations.users.manual')}}"><i class="fa fa-comments"></i> Support</a></li>
              </ol>
          </nav>
  
@endsection 


@section('content-body')

<div class="card" style="width: 100%; border-top: 4px solid #00a65a;">
    <div class="card-header">Account Details</div>
    <div class="card-body">
        <form action="#" id="sub_groups_form">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" placeholder=" Sub Group Account Name" name="sub_group_name" id="sub_group_name" class="form-control form-control-sm">
                    </div>  
                    <input type="hidden" name="action" value="create">

                    {{-- <input type="hidden" name="chart_of_account_id" id="chart_of_account_id"  value="{{$id}}"> --}}

                </div>
                <div class="col-md-6">
    
                    <div class="form-group">
                       <select name="group_name" id="group_name" class="form-control form-control-sm">
                        {{-- <option value="">Account Groups</option> --}}
                        @foreach ($account_groups as $group)
                        <option value="{{  $group->id }}">{{ $group->name }}</option>  
                        @endforeach
                       </select>
                    </div>
                </div>
            </div>
        </form>
        <span class="float-right">
            <a type="button" id="register" class="btn btn-primary btn-sm">Register</a>
          </span>
        </div>
      
       
       

</div>
</div>
  

</section>


@endsection


@section('scripts')

$('#account_groups').select2({width: '100%'});


$('#register').click(function(){

let form = $('#sub_groups_form');
let form_data =  new FormData(form[0]);

$.ajax({

method: 'POST',
processData: false,
contentType: false,
url : '{{ route('accounts.sub.groups.store')  }}',
data:form_data,

success: function(response){

    if(response.message == 'success'){
        window.location.replace('{{route('accounts.sub.groups.index') }}');
        
    }
    else {{-- if(response.state == 'Fail') --}}{
        toastr.warning(response.msg, response.title)

    }
    {{-- else if(response.state == 'Error') {
        toastr.error(response.msg, response.title);
    } --}}

},
error: function(response){

    if(response.status == 500){
        toastr.error('Internal server Error', 'error');
    }

}



});



});


@endsection
