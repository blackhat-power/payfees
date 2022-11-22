
@extends('layouts.app')

@section('content-breadcrumbs')
<nav aria-label="breadcrumb" style="width: 100%;">
   <ol class="breadcrumb" style="background-color: rgb(255, 249, 249)">
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
      {{-- <li class="breadcrumb-item"><a href="#">Library</a></li> --}}
      <li class="breadcrumb-item active" aria-current="page">Fee Structure</li>
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
               <a type="button" href="{{  route('configurations.school.fee_structure',$school_details->id)  }}" id="register" class="button btn btn-primary btn-sm mr-2"><i class="ri-add-line m-0"></i>New</a>
           </div>
             <div class="form-card text-left">
                 <div class="form-card text-left">
                    <div class="container-fluid" style="100%">
                        <div class="row">
                              <div class="col-sm-12">
                                 <div class="card">
                                    <div class="card-body">
                                          <div class="table-responsive">

                                             <table class="table" id="fee_structures" style="width: 100%">

                                                <thead>
                                                   <tr>
                                                      <th>Date</th>
                                                      <th>Class</th>
                                                      <th>Semester</th>
                                                      <th> Created By  </th>
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
                   {{-- <button type="button" name="next" style="margin-top:2%"    class="btn btn-primary float-right" id="save_seasons_n_classes" >Save</button> --}}
                   

          </div>
       </div>
      
    </div>
 </div>
 @include('configuration::registration.form_duplicates')

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
 
      $('.fee_add_row').click(function(){
       let duplicate_row = $('#fee_structure_inner_row').clone().removeAttr('style id')
          $(this).parents('#fees_append').append(duplicate_row);
          removeRow(duplicate_row);
      }); 
 
   
 $('#add_new_fee_row').click(function(){
    let duplicate_row = $('#fee_copy').clone().removeAttr('style id')
    console.log('awii');
    $(this).parents('#fees').prepend(duplicate_row);
    removeDiv(duplicate_row);
 
 });
      
    function removeRow(duplicate_row){
     duplicate_row.find('.remove_row').click(function(){
             $(this).parent().parent().remove();
             console.log('remove');
      });
   }
   function removeDiv(duplicate_row){
    duplicate_row.find('.remove_div').click(function(){
             $(this).parent().parent().parent().remove();
             console.log('remove');
      });
 
   }

 let class_url = '{{ route('configurations.school.fee_structure.datatable',':id') }}';
 
 class_url = class_url.replace(':id',  @php echo $school_details->id @endphp)
   let fee_structure_table = $('#fee_structures').DataTable({
     processing: true,
     serverSide: true,
      ajax:class_url,
      columns:[
         {data:'date', name:'date'},
          {data: 'class_name', name:'class_name'},
          {data:'semester_name', name:'semester_name'},
          {data:'created_by', name:'created_by'},
          {data:'action', name:'action', orderable:false, searchable:false}
      ],
 });



 $('body').on('click', '.fee-structure-delete', function(e){
   e.preventDefault();
   let dlt_id = $(this).data('fee_dlt_id');
   let url = '{{route('configurations.school.fee_structure.delete',[':school_id',':id'])}}';
   url = url.replace(':id',dlt_id);
   url = url.replace(':school_id',@php echo $school_details->id @endphp);
   {{-- confirm('are you sure you want to delete?'); --}}
   $.ajax({
       url:url,
       type:'DELETE',
       success:function (){
         fee_structure_table.draw();
       }
   });
});

 @endsection





















 






