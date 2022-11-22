@extends('layouts.app')

@section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
        <div class="navbar-breadcrumb">
            <h4 class="mb-0">Update System Settings</h4>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">settings</li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection

@section('content-body')

<div class="container-fluid">

<div class="card" style="100%">

<div class="card-body">
@include('configuration::school.includes.school_settings_tabs')

<div class="container-fluid" style="100%">
   <div class="row">
         <div class="col-sm-12">
            <div class="card">
               <div class="card-header">
                  <div class="btn-group btn-group-toggle" style="margin-left:90%" >
                     <a  href="{{  route('school.settings.academic_year',$school_details->id)  }}"  id="register" type="button" class=" btn btn-sm btn-primary float-right" style="color: white"><i class="fa fa-plus-circle"></i> Register </a>

                  </div>
               </div>
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

       </div>
    </div>
 </div>



@endsection

@section('scripts')

let class_url = '{{ route('school.settings.academic_year.datatable',':id') }}';
 
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
   



























<div class="container-fluid">
      {{-- @include('configuration::school.includes.school_profile') --}}


 </div>

 @include('configuration::registration.form_duplicates')

 {{-- @endsection --}}


 {{-- @section('scripts') --}}

 {{-- let class_url = '{{ route('configurations.classes.academic_year.datatable',':id') }}';


 
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


}) --}}



 
 {{-- @endsection --}}





















 






