@extends('layouts.app')

@section('content-heading')
      <nav aria-label="breadcrumb" style="width: 100%">
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
           <li class="breadcrumb-item active" aria-current="page">Configurations</a></li>
           <li class="breadcrumb-item active" aria-current="page">Academic Years</a></li>
         </ol>
       </nav>
@endsection

@section('content-body')
            <div class="card" style="width: 100%">

               <div class="card-header">
                     <a title="new academic year"  href="{{  route('configurations.school.academic.year.create')  }}"  id="register" type="button" class=" btn btn-sm btn-primary float-right" style="color: white"><i class="fa fa-plus-circle"></i> New Academic Year </a>
               </div>
               <div class="card-body">
                     <div class="table-responsive">

                        <table class="table" id="academic_year" style="width: 100%">
                           <thead>
                              <tr>
                                 <th>Title</th>
                                 <th>Start Date</th>
                                 <th>End Date</th>
                                 <th>Status</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                        </table>
                     </div>
                  </div>
            </div>
@endsection

@section('scripts')

let class_url = '{{ route('configurations.school.academic.year.datatable') }}';
 
{{-- class_url = class_url.replace(':id',  @php echo $school_details->id @endphp) --}}
  academic_year_datatable = $('#academic_year').DataTable({
    processing: true,
    serverSide: true,
     ajax:class_url,

     columns:[
       {data: 'name', name:'name'},
       {data: 'start_date', name:'start_date'},
       {data: 'end_date', name:'end_date'},
       {data: 'status', name:'status'},
         {data:'action', name:'action', orderable:false, searchable:false}
     ],


     drawCallback: function(){
      
      $('.dltBtn').click(function(e){
         e.preventDefault();

         let id = $(this).data('id');

         let init_url = '{{ route('configurations.school.academic.year.delete',':id')   }}';
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
                      academic_year_datatable.draw();
              
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
   





















 






