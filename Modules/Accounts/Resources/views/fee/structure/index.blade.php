


@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">

            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">System Configurations</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fee</a></li>
                 {{-- <li  class="breadcrumb-item"><a href="{{route('accounts.fee_structure.settings')}}">Fee Reminder Settings</a></li> --}}
                {{-- <li class="breadcrumb-item active" aria-current="page">New</a></li> --}}
              </ol>
          </nav>
          <style>

            .contents{

                display: flex;
                direction: horizontal;
                justify-content: space-around;
                align-items: left; 
                width: 100%;
               


            }
            .mg-top{
                margin-top: 1.4rem;
            } 

            .scrollable-content{
                height: 200px; /* set the height of the div */
                overflow-y: scroll; /* add scroll to the y-axis */
                background: #eeeeee;
            }

            .checkboxes{
                height: 15px;
            }
           

             .batch{
                display: flex;
                direction: horizontal;
               justify-content: start;
                width: 100%;
            }
            .spaces{
                padding: 0px 12px;
            }
/*
            .batch_container{

                width: 200


            } */


          </style>

@endsection


@section('content-body')
        </div>
    </div>
    <div class="card" style="100%">
        <div class="card-header">

        </div>

        <div class="card-body">

            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div>
                            {{-- <span>search</span> --}}
                            {{-- <input type="text" name="search" style="background: #87a2a1;" id="search" class="form-control form-control-sm" placeholder="search ...."> --}}
                        </div>

                    </div>
<div class="col-md-2" style="margin-top: 1.3rem;">
    <span style="margin-left: 25rem; display:none " id="loader_spin" >
        <img src="{{ asset('assets/images/new_loader.gif') }}" alt="">
        </span>
</div>

{{-- <div class="col-sm-3">
   
  </div> --}}
             <div class="col-sm-3">
                <div style="float:right; display:none" id="by_class">
                    <span>Filter By Class:</span>
                    <select name="class_id" data-check="0" id="class_id" style="background: #87a2a1;" class="form-control form-control-sm">
                     <option value="">Select Class</option>
                     @foreach ($classes as  $class)
                         <option value="{{$class->id}}">{{$class->name}}</option>
                     @endforeach
                    </select>
                </div>
                   
                  </div>


                  <div class="col-sm-3" id="by_template">
                    <span>Filter By Template:</span>
                   <select name="category_id" data-check="0" id="category_id" style="background: #87a2a1;" class="form-control form-control-sm">
                    <option value="">Select Class</option>
                    @foreach ($fee_master_categories as  $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                   </select>
                  </div>

                
                    
                </div>

                <div id="loader_div" style="display:none">
                    <span style="float:right; " id="loader_spin" >
                        <img src="{{ asset('assets/images/new_loader.gif') }}" alt="">
                        </span>
                </div>
               
                      
                </div>
              </div>

              <div style="margin-top: 2rem">
            </div>
            {{-- @if (false) --}}
              <div id="result" class="container" style="display: none" >

                <table  id="query_fee_structure_table" class="table table-striped table-bordered table-sm" width="100%" style="table-layout: inherit">
                <thead>
                    <tr>
                        {{-- <th>S/NO</th> --}}
                        <th>Name</th>
                        <th>Admn nO.</th>
                        <th>Fees</th>
                        <th></th>
                    </tr>

                </thead>
               
{{-- 
                @foreach ($students as  $student )
                <tr>
                    <td>{{$student->full_name}}</td>
                    <td>{{}}</td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach --}}

             
                </table>

              </div>

              {{-- @endif --}}

        </div>



        <div class="modal" tabindex="-1" role="dialog" id="fcategory">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header" style="background-color: #00a65a">
                  <h5 class="modal-title"> Fee Structure  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="#" id="fee_header_form">
                     @csrf
                     <div class="row">
                         <div class="col-md-3">
                            <span>Fee Particulars</span>
                         </div>
                        <div class="col-md-9">
                            <div class="container">
                                <div class="scrollable-content">
                                    <table><tr><td>Select: &nbsp;</td> <td><span><a id="all" href="javascript:void(0)">All</a> ,&nbsp;&nbsp; <a id="none" href="javascript:void(0)">None</a></span></td></tr></table>
                                    <hr>
                                    <div id="fee_house">

                                    </div>
                                    @foreach ($classes as $class )
                                    <div class="batch">
                                       <span class="spaces"> <input type="checkbox" value="{{$class->id}}" name="classes[]" class="form-control checkboxes form-control-sm"></span>  
                                        <span class="spaces">{{   $class->name  }}</span>
                                    </div>
                                    @endforeach
                                    <!-- Your content here -->
                                </div>
                            </div>
                         </div>
                     </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary btn-sm" id="save_header">Update</button>
                  <button type="button" class="btn btn-warning btn-sm" id="print"> <i class="fa fa-print"></i> Print</button>
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
 
    


 @endsection


 @section('scripts')

$('#class_id').change(function(){
    $('#loader_spin').removeAttr('style','display:none').css({'margin-left':'25rem'});
    $('#by_template').removeAttr('style','display:none');
    
setTimeout(function(){
    $('#loader_spin').attr('style','display:none');
    $('#result').removeAttr('style','display:none'); 
    query_table.draw();
},500)

});

$('#category_id').change(function(){
let category_id =  $(this).val();
$('#by_class').removeAttr('style','display:none');

$('#loader_div').removeAttr('style');

$.ajax({

    url:"{{ route('accounts.school.new.fee.structure.category.classes') }}",
    type:"POST",
    data:{
        category_id : category_id
    },
    success:function(response){

        $('#class_id').html(response);

    },
    error:function(){

    }

});

$('#result').removeAttr('style','display:none'); 
query_table.draw();

setTimeout(function(){
    $('#loader_div').attr('style','display:none');

},500)




});


 

let query_table = $('#query_fee_structure_table').DataTable({
    processing: false,
   serverSide: true,
    ajax:{
        url : '{{ route('accounts.school.new.fee.structure.datatable') }}',
        
        data: function (d) {
            d.class_id = $('#class_id').val();
            d.category_id = $('#category_id').val();
       }
    },

    columns:[
       {data: 'full_name', name:'full_name'},
       {data: 'fee', name:'fee'},
      {data: 'fee', name:'fee'},
       {data:'action', name:'action', orderable:false, searchable:false, 'width':'8%' } 
   ],
   "columnDefs": [
       { className: " text-right", "targets": [ 2 ] },
       { className: " text-right font-weight-bold", "targets": [ 3 ] },
     ],

     "drawCallback":function(){

        $('.edit').click(function(){

            $('#fcategory').modal('show');

            let edit_id = $(this).data('edit_id');

            console.log('edit_id'+ edit_id);
            
            let class_id =  $('#class_id').val();

            console.log('class_id'+class_id)

            $.ajax({

                url:'{{ route('accounts.school.new.fee.structure.student.fee.items')  }}',
                type:'POST',
                data:{
                    student_id : edit_id,
                    category_id : $('#category_id').val(),
                    class_id : class_id,
                },
                success:function(response){

                    console.log(response);

                },
                error:function(){


                }
            });

            

            console.log('now now');


        });

        {{-- $('') --}}

     },

});


$('#all').click(function(){
    $('input[type="checkbox"]').each(function(){
        $(this).prop('checked',true);
    });

});

$('#none').click(function(){
        $('input[type="checkbox"]').each(function(){
            $(this).prop('checked',false);
        });
    
    });













 @endsection





































