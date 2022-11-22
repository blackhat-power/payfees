@extends('layouts.app')

@section('content-heading')



    
          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Users</a></li>
              </ol>
          </nav>
  
@endsection 



@section('content-body')

<div class="card" style="width: 100%" >
    {{--  <div class="card-header d-flex justify-content-between">
 
        <div class="header-title">
        </div>
     </div> --}}
     <div class="card-header border-bottom">
         
             <a href="{{ route('configuration.users.create') }}" id="register" type="button" class=" btn btn-sm btn-primary float-right" style="color: white"><i class="fa fa-plus-circle"></i> New </a>
         
         <span>
             <input type="checkbox" id="filter_checkbox" class="checkbox-input float-left" style="width: 30px; height: 30px;">
            Filters
         </span>
 
 
         <div class="row" style="margin-top:2%; display:none" id="toggleFilters" >
             <div class="col-md-3">
                 <select name="role_filter" id="role_filter" class="form-control form-control-sm">

                     <option value="">Select Role</option>
                     @foreach ($roles as $role )

                     <option value="{{ $role->id }}">{{ $role->name }}</option>
                         
                     @endforeach

                 </select>   
             </div>

         </div>
     </div>
     <div class="card-body">
          <div class="table-responsive"> 
             <table id="users_table" class="table table-striped table-bordered table-sm" width="100%" style="table-layout: inherit">
                 <thead>
                 <tr>
                 <th>SN</th>
                 <th>Photo</th>
                   <th>Name</th>
                   <th>Username</th>
                   <th>Phone</th>
                   <th>Email</th>
                   <th>Action</th>
                 </tr>
                 </thead>
             </table>
          </div>  
     </div>
 
     <div class="top-right p-4"> 
 
     </div>
  </div>

@endsection

@section('scripts')

let users_datatable = $('#users_table').DataTable({
    processing: true,
   serverSide: true,
    ajax:{

        url: '{{ route('configuration.users.datatable') }}',

        data:function(e){

            e.role_id = $('#role_filter').val()

        }

        
    },
    
    columns:[
    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
       {data: 'photo', name:'photo'},
       {data: 'name', name:'name'},
       {data: 'username', name:'username'},
       {data: 'phone', name:'phone'},
        {data: 'email', name:'email'},
       {data:'action', name:'action', orderable:false, searchable:false}
   ],

  

});


$('#role_filter').change(function(){

    users_datatable.draw();
    
});



$("#filter_checkbox").change(function() {
    if(this.checked) {
        $('#toggleFilters').removeAttr('style','display:none').css({'margin-top':'2%'});
    }else{
        $('#toggleFilters').css({'display':'none'});
    }
 });



$('body').on('click','.usrDltBtn',(function(e){
    e.preventDefault();
    let student_id = $(this).data('user_dlt_id');
    console.log(student_id);
    let init_url = "{{ route('configuration.users.delete', 'id') }}"
    let url = init_url.replace('id',student_id);
   
    $.ajax({
        type: "DELETE",
        url: url,

        success: function (response) {
            if(response.state == 'Done'){
                users_datatable.ajax.reload();
                toastr.success(response.msg, response.title); 
            }
    
            else if(response.state == 'Fail'){
                toastr.warning(response.msg, response.title)
    
            }
            else if(response.state == 'Error'){
                toastr.warning(response.msg, response.title)
    
            }
    
        },
        error: function(response){
            console.log(response);
            
        }

    });


}))
;



@endsection