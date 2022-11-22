@extends('layouts.app')

@section('content-heading')



    
          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Classes</a></li>
                <li class="breadcrumb-item active" aria-current="page">Streams</a></li>
              </ol>
          </nav>
  
@endsection 

@section('content-body')

<div class="container-fluid">

<div class="card" style="100%">

<div class="card-body">
<div class="container-fluid" style="100%">
   <div class="row">
         <div class="col-sm-12">
            <div class="card">
               <div class="card-header">
                  <div class="btn-group btn-group-toggle" style="margin-left:90%" >
                     <a  href="{{  route('configurations.school.class.streams.new', $id)  }}"  id="register" type="button" class=" btn btn-sm btn-primary float-right" style="color: white"><i class="fa fa-plus-circle"></i> New </a>
                  </div>
               </div>
               <div class="card-body">
                     <div class="table-responsive">

                        <table class="table" id="stream_table" style="width: 100%">
                           <thead>
                              <tr>
                                 <th>Name</th>
                                 <th>description</th>
                                 <th>Created By</th>
                                 <th>Actions</th>
                              </tr>
                           </thead>
                        </table>
                     </div>
                  </div>
            </div>
         </div>
      </div>
   </div>
      </div>
   </div>
</div>

 </div>

       </div>
    </div>
 </div>



@endsection

@section('scripts')

let init_url = '{{ route('configurations.school.class.streams.datatable',':id') }}';
let id = {{ $id }};
console.log(id);
let url = init_url.replace(':id',id)

streams_datatable=$('#stream_table').DataTable({
    processing: true,
    serverSide: true,
     ajax:url,
     columns:[
         {data: 'name', name:'name'},
         {data:'description', name:'description'},
         {data:'created_by', name:'created_by'},
         {data:'action', name:'action', orderable:false, searchable:false}
     ],

     drawCallback: function(){
      
        $('.dltBtn').click(function(e){
           e.preventDefault();
  
           let id = $(this).data('id');
  
           let init_url = '{{ route('configurations.school.stream.delete',':id')   }}';
           let url = init_url.replace(':id',id);

           Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
               $.ajax({
  
                  type:'DELETE',
      
                  url: url,
      
                  success:function(response){
          
                     if(response.state == 'Done'){
                        toastr.success(response.msg, response.title);
                        streams_datatable.draw();
              
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

            }
          })



         
  
        });

       }
   
 });

@endsection
