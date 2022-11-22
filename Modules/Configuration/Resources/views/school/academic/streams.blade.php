@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Configurations</a></li>
              <li class="breadcrumb-item active" aria-current="page">Streams</a></li>
            </ol>
          </nav>
  

@endsection 

@section('content-body')
 
<div class="card" style="width:100%">
   <div class="card-header">
      <a  href="{{  route('configurations.school.streams.new')  }}"  id="register" type="button" class=" btn btn-sm btn-primary float-right" style="color: white"><i class="fa fa-plus-circle"></i> New Stream</a>
</div>
<div class="card-body">
                     <div class="table-responsive">
                        <table class="table" id="stream_table" style="width: 100%">
                           <thead>
                              <tr>
                                 <th>Name</th>
                                 <th>Class</th>
                                 <th>description</th>
                                 <th>Created By</th>
                                 <th>Actions</th>
                              </tr>
                           </thead>
                        </table>
                     </div>
                  </div>
            </div>
@endsection

@section('scripts')

streams_datatable=$('#stream_table').DataTable({
    processing: true,
    serverSide: true,
     ajax:'{{ route('configurations.school.streams.datatable') }}',
     columns:[
         {data: 'name', name:'name'},
         {data:'class', name:'class'},
         {data:'created_by', name:'created_by'},
         {data:'description', name:'description'},
         {data:'action', name:'action', orderable:false, searchable:false}
     ],

     {{-- drawCallback: function(){

        $('.editBtn').click(function(){

            alert('hooray');

        });
     } --}}
   
 });

@endsection
   






















 






