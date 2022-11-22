@extends('layouts.app')

@section('content-heading')
          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li> 
                <li  class="breadcrumb-item"><a href="{{route('configurations.school.academic.year.index')}}">Academic Year</a></li>       
                <li class="breadcrumb-item active" aria-current="page">Semesters</a></li>
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
                  <div class="btn-group btn-group-toggle" style="margin-left:98%" >
                     <a title="new semester"  href="{{  route('configurations.school.academic.year.semester.create',[$id])  }}"  id="register" type="button" class=" btn btn-sm btn-primary float-right" style="color: white"><i class="fa fa-plus-circle"></i> </a>
                  </div>
               </div>
               <div class="card-body">
                     <div class="table-responsive">

                        <table class="table" id="classes" style="width: 100%">
                           <thead>
                              <tr>
                                 <th>Name</th>
                                 <th>Start Date</th>
                                 <th>End Date</th>
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
let year_id = {{  $id  }};
let init_url = '{{ route('configurations.school.academic.year.semester.datatable',[':id']) }}';
let url = init_url.replace(':id',year_id);
 
{{-- class_url = class_url.replace(':id',  @php echo $school_details->id @endphp) --}}
  semester_datatable = $('#classes').DataTable({
    processing: true,
    serverSide: true,
     ajax:url,

     columns:[
       {data: 'name', name:'name'},
        {data:'start_date', name:'start_date'},
        {data:'end_date', name:'end_date'},
         {data:'action', name:'action', orderable:false, searchable:false}
     ],


     drawCallback: function(){
      
      $('.dltBtn').click(function(e){
         e.preventDefault();
         Swal.showLoading()

         let s_id = $(this).data('id');
         let id = {{$id}};

         let init_url = '{{ route('configurations.school.academic.year.semester.delete',[':y_id',':id'])   }}';
         let url = init_url.replace(':id',s_id).replace(':y_id',id);

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
                    {{-- dataType:'JSON', --}}
        
                    url: url,
        
                    success:function(response){
                        console.log(response.state);
                       if(response.state == 'Done'){
                        toastr.success(response.msg, response.title);
                        semester_datatable.draw();
                
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
   










































 






