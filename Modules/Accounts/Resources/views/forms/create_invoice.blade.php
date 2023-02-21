


@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">

            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">System Configurations</a></li>
                <li class="breadcrumb-item active" aria-current="page">New Invoice</a></li>
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
               justify-content: space-between;
                width: 100%;
            }
            .spaces{
                padding: 0px 12px;
            }
            .div_spaces{
                display: flex;
            }

            .radiobtns{
                display: flex;
                justify-content: space-between;
            }

            .filter_type{
                padding-left: 2rem;
            }

            .card .card-header {
                background: #9e9e9e ;
            }
            .radio:hover{
                cursor: pointer;
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
                <span>
                    {{-- <input type="checkbox" id="filter_checkbox" class="checkbox-input float-left" style="width: 30px; height: 30px;"> --}}
                   {{-- Filters --}}
                </span>

                <div class="row">
                    <div class="col-md-2">
                        <span>   </span>
                    </div>
                    <div class="col-md-2"></div>
                </div>



                    <div class="radiobtns">
                        <div>
                            <span class="filter_type">
                                <input id="radiobtn-1" name="no_of_terms" onclick="changeTemplate($(this))"  type="radio" class="radio" value="1" checked>
                                <label for="" style="margin-top: 0.5rem;">Generate By Template</label>
                            </span>

                            <span class="filter_type">
                                <input id="radiobtn-2" name="no_of_terms" onclick="changeManually($(this))" class="radio"  type="radio" value="2">
                                <label for="" style="margin-top: 0.5rem;">Generate Manually</label>
                            </span>
                        </div> 
                        <div class="filter_type">
                        <span style="float: right;"><button id="create_invoice" disabled class="btn btn-sm btn-primary"> Generate Invoice   </button></span>
                    </div>
                                                      
                    </div>
       

{{-- 
                        <div class="col-sm-3" id="by_template">
                        
                           <select name="category_id" data-check="0" id="category_id" style="background: #87a2a1;" class="form-control temp form-control-sm">
                            <option value="">Select Template</option>
                            @foreach ($fee_master_categories as  $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                           </select>
                           <span style="margin-left: 25rem; display:none " id="loader_spin" >
                            <img src="{{ asset('assets/images/new_loader.gif') }}" alt="">
                            </span>
                          </div> --}}

                          <fieldset class="border p-3" style="background: #eeeeee;" id="fieldset_template">
                            <legend class="w-auto" style="font-size: 12px !important; min-width: 15rem !important;">
                                   <select name="category_id" data-check="0" id="category_id" style="background: #87a2a1;" class="form-control temp form-control-sm">
                                    <option value="">Select Template</option>
                                    @foreach ($fee_master_categories as  $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                   </select>
                                   <span style="margin-left: 25rem; display:none " id="loader_spin" >
                                    <img src="{{ asset('assets/images/new_loader.gif') }}" alt="">
                                    </span>
                            </legend>
                            <div class="row">

                                <div class="col-sm-3">
                                    <div style="display:none" id="by_class">
                                        <span>Filter By Class:</span>
                                        <select name="class_id" data-check="0" id="class_id" style="background: #87a2a1;" class="form-control temp form-control-sm">
                                         <option value="">Select Class</option>
                                         @foreach ($classes as  $class)
                                             <option value="{{$class->id}}">{{$class->name}}</option>
                                         @endforeach
                                        </select>
                                    </div>
                                      </div>
                                      <div class="col-sm-3">
                                        <div style="display:none" id="by_admn_No">
                                            <span>Filter By Admission Number:</span>
                                            <select name="admn_no" data-check="0" id="admn_no" style="background: #87a2a1;" class="form-control form-control-sm">
                                                <option value="">Select Admission Number</option>
                                                @foreach ($admn_nos as $no )
                                                <option value="{{$no->id}}">{{ $no->admission_no  }}</option>
                                                @endforeach
                                            
                                            </select>
                                        </div>
                                          </div>
                            </div>
   
                          </fieldset>


                          <fieldset class="border p-3 d-none" style="background: #eeeeee;" id="manually">
                            <legend class="w-auto" style="font-size: 12px !important; min-width: 15rem !important;">
                                  <input type="text" disabled value="GENERATE MANUALLY"> 
                            </legend>
                            <div class="row">
                                TO BE DONE...

                                {{-- <div class="col-sm-3">
                                    <div style="display:none" id="by_class">
                                        <span>Filter By Class:</span>
                                        <select name="class_id" data-check="0" id="class_id" style="background: #87a2a1;" class="form-control temp form-control-sm">
                                         <option value="">Select Class</option>
                                         @foreach ($classes as  $class)
                                             <option value="{{$class->id}}">{{$class->name}}</option>
                                         @endforeach
                                        </select>
                                    </div>
                                      </div>
                                      <div class="col-sm-3">
                                        <div style="display:none" id="by_admn_No">
                                            <span>Filter By Admission Number:</span>
                                            <select name="admn_no" data-check="0" id="admn_no" style="background: #87a2a1;" class="form-control form-control-sm">
                                                <option value="">Select Admission Number</option>
                                                @foreach ($admn_nos as $no )
                                                <option value="{{$no->id}}">{{ $no->admission_no  }}</option>
                                                @endforeach
                                            
                                            </select>
                                        </div>
                                          </div> --}}
                            </div>
   
                          </fieldset>
                          

                          {{-- <div class="col-sm-3" id="by_template">
                            <span>Generate Manually:</span>
                           <select name="category_id" data-check="0" id="category_id" style="background: #87a2a1;" class="form-control form-control-sm">
                            <option value="">Select Template</option>
                            @foreach ($fee_master_categories as  $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                           </select>
                           <span style="margin-left: 25rem; display:none " id="loader_spin" >
                            <img src="{{ asset('assets/images/new_loader.gif') }}" alt="">
                            </span>
                          </div> --}}

{{-- <div class="col-sm-3">
   
  </div> --}}

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
    </div>
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
                                    {{-- @foreach ($classes as $class )
                                    <div class="batch">
                                       <span class="spaces"> <input type="checkbox" value="{{$class->id}}" name="classes[]" class="form-control checkboxes form-control-sm"></span>  
                                        <span class="spaces">{{   $class->name  }}</span>
                                    </div>
                                    @endforeach --}}
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


function changeManually(elem){

    $('#fieldset_template').addClass('d-none');
    $('#manually').removeClass('d-none');

}

function changeTemplate(elem){

    $('#manually').addClass('d-none');
    $('#fieldset_template').removeClass('d-none');

}


$('#class_id').change(function(){
    $('#loader_spin').removeAttr('style','display:none').css({'margin-left':'5rem'});
    $('#by_template').removeAttr('style','display:none');

$.ajax({

url:'{{ route('accounts.query.admsn.numbers')   }}',
type:'POST',
data:{
    class_id:$(this).val()
},
success:function(res){
$('#admn_no').html(res);
console.log(res);

}


})
    
setTimeout(function(){
    $('#loader_spin').attr('style','display:none');
    $('#result').removeAttr('style','display:none'); 
    query_table.draw();
},500)

});

$('.temp').select2({width:'100%'});



document.addEventListener('click',function(event){
let elem_type = event.target.type;

let total = 0;
if( elem_type == 'checkbox'){
    let amount = parseFloat(event.target.closest('.total_check').querySelector('.amount').textContent);
    if(event.target.checked){
        total +=amount;

    }else{

        total -=amount;

    }

    $('#total_bd').text(total);

} 


})


$('#category_id').change(function(){
let category_id =  $(this).val();
$('#by_class').removeAttr('style','display:none');
$('#by_admn_No').removeAttr('style','display:none');

$('#create_invoice').prop('disabled',false);

$('#loader_div').removeAttr('style');

$.ajax({

    url:"{{ route('accounts.school.new.fee.structure.category.classes') }}",
    type:"POST",
    data:{
        category_id : category_id
    },
    success:function(response){

        $('#class_id').html(response.html);

        $('#admn_no').html(response.admsn_nos)

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
            d.admission_no = $('#admn_no').val().trim();
       }
    },

    columns:[
       {data: 'full_name', name:'full_name'},
       {data: 'admission_no', name:'admission_no'},
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
                    $('#fee_house').html(response);
                    {{-- console.log(response); --}}

                },
                error:function(){


                }
            });


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

    $('#admn_no').select2({
        width:'100%'
    })


    $('#admn_no').change(function(e){
        e.preventDefault();
        {{-- console.log($(this).val()); --}}
        $('#loader_spin').removeAttr('style','display:none').css({'margin-left':'40rem'});
        query_table.draw();
        setTimeout(function(){
            $('#loader_spin').attr('style','display:none');

        },800)

    });


    $('#create_invoice').click(function(){


        {{-- alert('now more than never'); --}}

        $.ajax({

            url:'{{ route('accounts.new.invoice.redo.store') }}',
            type:'POST',
            data:{
                template_id : $('#category_id').val(),
                class_id : $('#class_id').val(),
                admn_no : $('#admn_no').val(),
            },
            
            success:function(response)
            {
        
                if(response.state == 'Done'){
                    toastr.success(response.msg, response.title);
                    setTimeout(function(){
                        window.location.replace('{{ route('accounts.invoice') }}')   
                    }, 1300)
                    
                }
                else if(response.state == 'Fail'){
                    toastr.warning(response.msg, response.title)
             
                }
                else if(response.state == 'Error') {
                    toastr.error(response.msg, response.title);
                }
                
            },
            error:function(response){

                if(response.statusCode == '500'){
                    toastr.error('Internal Server Error');
    
                }



        }
        
    });




    });













 @endsection





































