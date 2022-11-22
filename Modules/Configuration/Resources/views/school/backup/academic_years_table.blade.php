
@extends('layouts.app')

@section('content-breadcrumbs')
<nav aria-label="breadcrumb" style="width: 100%;">
   <ol class="breadcrumb" style="background-color: rgb(255, 249, 249)">
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
      {{-- <li class="breadcrumb-item"><a href="#">Library</a></li> --}}
      <li class="breadcrumb-item active" aria-current="page">Academic Year</li>
   </ol>
</nav>
<hr>
@endsection

@section('content-body')


<div class="container-fluid">
    <div class="row">
      @include('configuration::school.includes.school_profile')
       <div class="col-lg-9 col-md-6">
          <div class="card card-block card-stretch card-height">
             <div class="card-header">
                <div class="header-title">
                   <h4 class="card-title">School Profile</h4>
                </div>
             </div>
            
             @include('configuration::school.includes.tabs')
             <div class="btn-group btn-group-toggle" style="margin-left:90%" >
                <a type="button" href="{{  route('school.settings.academic_year',$school_details->id)  }}" id="register" class="button btn btn-primary btn-sm mr-2"><i class="ri-add-line m-0"></i>Register</a>
            </div>
                   <div class="form-card text-left">
                    <div class="container-fluid" style="100%">
                        <div class="row">
                              <div class="col-sm-12">
                                 <div class="card">
                                    <div class="card-body">
                                          <div class="table-responsive">

                                             <table class="table" id="academic_years" style="width: 100%">
                                                <thead>
                                                   <tr>
                                                      <th>Date</th>
                                                      <th>Year</th>
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

 @include('configuration::registration.form_duplicates')



 <div class="modal fade" id="academic_modal_years" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         {{-- <h5 class="modal-title">Modal title</h5> --}}
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">

         <p>Modal body text goes here.</p>
       </div>
       <div class="modal-footer">
         {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       </div>
     </div>
   </div>
 </div>
 @endsection


 @section('scripts')

 let class_url = '{{ route('configurations.classes.academic_year.datatable',':id') }}';
 
 class_url = class_url.replace(':id',  @php echo $school_details->id @endphp)
   academic_year_datatable = $('#academic_years').DataTable({
     processing: true,
     serverSide: true,
      ajax:class_url,

      columns:[
         {data:'date', name:'date'},
        {data: 'name', name:'name'},
         {data:'created_by', name:'created_by'},
          {data:'action', name:'action', orderable:false, searchable:false}
      ],

 });



 $('body').on('click','.academic_more_details', function(){
   
   let data = $(this).data('academic_model');
   console.log(data);

})
 
 @endsection





















 






