
@extends('layouts.app')

@section('content-breadcrumbs')
         
<nav aria-label="breadcrumb" style="width: 100%">
   <ol class="breadcrumb">
     <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
     <li class="breadcrumb-item active" aria-current="page">Accounts</a></li>
     <li class="breadcrumb-item active" aria-current="page">Fee Structure Settings</a></li>
   </ol>
 </nav>

@endsection

@section('content-body')

 
          <div class="card" style="width:100%; border-top: 2px solid #008080">
             <div class="card-header">
                <a href="{{  route('accounts.school.fee_structure.create')  }}"  id="register" type="button" class=" btn btn-sm btn-primary float-right" style="color: white"><i class="fa fa-plus-circle"></i> New Fee Structure </a>
             </div>
            
             {{-- @include('configuration::school.includes.tabs') --}}

             <div class="card-body">
               <div class="table-responsive "> 
                  <table class="table table-striped table-bordered table-sm" id="fee_structures" style="table-layout: inherit; width:100%">

                     <thead>
                        <tr>
                           <th>Date</th>
                           <th>Class</th>
                           <th>Actions</th>
                        </tr>
                     </thead>

                  </table>
               </div> 
      
      
             
      
          </div>

                   {{-- <button type="button" name="next" style="margin-top:2%"    class="btn btn-primary float-right" id="save_seasons_n_classes" >Save</button> --}}
                   

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

 let class_url = '{{ route('accounts.fee_structure.datatable',':id') }}';
 
 class_url = class_url.replace(':id',  @php echo $school_details->id @endphp)
   let fee_structure_table = $('#fee_structures').DataTable({
     processing: true,
     serverSide: true,
      ajax:class_url,
      columns:[
         {data:'date', name:'date'},
          {data: 'class_name', name:'class_name'},
          {data:'action', name:'action', orderable:false, searchable:false}
      ],
 });



 $('body').on('click', '.fee-structure-delete', function(e){
   e.preventDefault();
   let dlt_id = $(this).data('fee_dlt_id');
   let url = '{{route('accounts.school.fee_structure.delete',[':school_id',':id'])}}';
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





















 






