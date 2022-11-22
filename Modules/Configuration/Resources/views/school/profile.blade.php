
@extends('layouts.app')


@section('content-breadcrumbs')
<nav aria-label="breadcrumb" style="width: 100%;">
   <ol class="breadcrumb" style="background-color: rgb(255, 249, 249)">
      <li class="breadcrumb-item"><a href="{{ route('configurations.school.dashboard',$school_details->id)}}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Students Management &nbsp;</li>
      {{-- <li class="breadcrumb-item active" aria-current="page">Class List</li> --}}
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
                   <h4 class="card-title">Profile</h4>
                </div>
             </div>
            
            

             @include('configuration::school.includes.tabs')
             <h6 style="text-align: center"> Profile </h6>

                              <hr>
                              <div class="card-body">
                                 <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                       <a class="nav-link active" id="pills-home-tab" data-toggle="pill"  role="tab" aria-controls="pills-home" aria-selected="true">List of Classes</a>
                                    </li>
                                    <li class="nav-item">
                                       <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">List of Students</a>
                                    </li>
                                    <li class="nav-item">
                                       <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Collections</a>
                                    </li>
                                 </ul>
                                 <div class="tab-content" id="pills-tabContent-2">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                                       <div class="container-fluid" style="100%">
                                          <div class="row">
                                                <div class="col-sm-12">
                                                   <div class="card">
                                                      <div class="card-body">
                                                            <div class="table-responsive">

                                                               <table class="table" id="classes_table" style="width: 100%">
                                                                  <thead>
                                                                     <tr>
                                                                        <th>Class Group</th>
                                                                        <th>Academic Year</th>
                                                                        <th>Number of Students</th>
                                                                        <th>Bill Payable</th>
                                                                        <th>Bill Paid</th>
                                                                        <th>Bill Balance</th>
                                                                        <th>Action</th>
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
                                    <div class="tab-pane fade" id="pills-profile" style="width: 100%" role="tabpanel" aria-labelledby="pills-profile-tab">
                                       <table class="table">
                                          <thead>
                                             <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col"> Class</th>
                                                <th scope="col">Date of Join</th>
                                                <th scope="col">Bill Payable</th>
                                                <th>Bill Paid</th>
                                                <th>Bill Balance</th>
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>

                                          </tbody>
                                       </table> 
                                    </div>
                                 </div>
                              </div>


                         
             


          </div>
       </div>
      
    </div>
 </div>
 

 @endsection


 @section('scripts')


 $('#semester_add_row').click(function(){
   let duplicate_row =   $('#semester_duplicate').clone().removeAttr('style id');
   $(this).parents('#semesters_div').append(duplicate_row);
   console.log('aa');
   removeRow(duplicate_row);
  });



 $('#add_row').click(function(){
   let duplicate_row =   $('#duplicate_row').clone().removeAttr('style id');
       $(this).parents('#seasons_div').append(duplicate_row);
 
       removeRow(duplicate_row);
      });



 let class_url = '{{ route('configurations.classes.datatable',':id') }}';
 
 class_url = class_url.replace(':id',  @php echo $school_details->id @endphp)
   classes_datatable = $('#classes_table').DataTable({
     processing: true,
     serverSide: true,
      ajax:class_url,
      columns:[
         {data:'class_name', name:'class_name'},
          {data: 'season_name', name:'season_name'},
          {data:'students_count', name:'students_count'},
          {data:'bill_payable', name:'bill_payable'},
          {data:'bill_paid', name:'bill_paid'},
          {data:'bill_balance', name:'bill_balance'},
          {data:'action', name:'action', orderable:false, searchable:false}
      ],
 });
 

 @endsection





















 






