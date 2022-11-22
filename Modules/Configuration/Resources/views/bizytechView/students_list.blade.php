
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
          <div class="card card-block card-stretch card-height" style="border-top: 3px solid #00c0ef ">
             <div class="card-header">
                <div class="header-title">
                  
                </div>
             </div>
                              <div class="card-body">
                                 
                             @include('configuration::bizytechView.tabs')

                                 <div class="tab-content" id="pills-tabContent-2">
                                    <div class="tab-pane show active fade" id="pills-profile" style="width: 100%" role="tabpanel" aria-labelledby="pills-profile-tab">
                                       <table class="table" id="student_list_table">
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



 let class_url = '{{ route('configurations.school.profile.students.list',[':id',':db']) }}';
 
 class_url = class_url.replace(':id',  @php echo $school_details->id @endphp).replace(':db', @php  echo  "'$db' "  @endphp );
   classes_datatable = $('#student_list_table').DataTable({
     processing: true,
     serverSide: true,
      ajax:class_url,
      columns:[
        {data: 'student_name', name:'student_name'},
         {data:'class_name', name:'class_name'},
         {data: 'doj', name:'doj'},
          {data:'bill_payable', name:'bill_payable'},
          {data:'bill_paid', name:'bill_paid'},
          {data:'bill_balance', name:'bill_balance'},
          {data:'action', name:'action', orderable:false, searchable:false}
      ],
 });
 

 @endsection
