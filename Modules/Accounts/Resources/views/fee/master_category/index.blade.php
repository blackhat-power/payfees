


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
                  <div class="col-sm-3">
                    <i class="fas fa-heart"></i>
                    <h3> <a href="javascript:void(0)" id="fee_category">Create Category</a> </h3>
                    <small>Create Master Particulars</small>
                  </div>
                  <div class="col-sm-3">
                    <i class="fas fa-camera"></i>
                    <h3> <a href="{{ route('accounts.school.fee.structure.patcl.index') }}">Create Particulars</a> </h3>
                    <small>Create Category Particulars </small>
                    
                  </div>
                  
                </div>
              </div>


              {{-- THE MODAL --}}



             <div class="modal" tabindex="-1" role="dialog" id="fcategory">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header" style="background-color: #00a65a">
                      <h5 class="modal-title"> Create Master Category for Fees  </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="#" id="fee_header_form">
                         @csrf
                         <div class="row">
                            <div class="col-md-12">
                               <div class="form-group">
                                  <label for=""> Name </label>
                                  <input type="text" name="name" id="particular_name" class="form-control form-control-sm">
                               </div>
                            </div>
                             <div class="col-md-3">
                                <span>Classes</span>
                             </div>
                            <div class="col-md-9">

                                <div class="container">
                                    <div class="scrollable-content">
                                        <table><tr><td>Select: &nbsp;</td> <td><span><a id="all" href="javascript:void(0)">All</a> ,&nbsp;&nbsp; <a id="none" href="javascript:void(0)">None</a></span></td></tr></table>
                                        <hr>
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
                            <div class="col-md-12">
                               <div class="form-group">
                                  <label for=""> Description </label>
                                  <input name="description" id="particular_description" type="text" class="form-control form-control-sm">
                               </div>
                            </div>
                         </div>
             
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary btn-sm" id="save_header">Save changes</button>
                      <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>






 @endsection


 @section('scripts')

 $('#save_header').click(function(){

    let form = $('#fee_header_form')[0];
    let form_data = new FormData(form);
    
    $.ajax(
       {
        processData:false,
        contentType: false, 
        url:'{{ route('accounts.school.fee.structure.master.categories.store')  }}',
        type:'POST',
        data:form_data,
        dataType: "JSON",
        success:function(response){
            if(response.state == 'Done'){
                toastr.success(response.msg, response.title);
                $('#fcategory').modal('hide');
                {{-- particulars_table.draw(); --}}
            }
            else if(response.state == 'Fail'){
                toastr.warning(response.msg, response.title)
         
            }
            else if(response.state == 'Error') {
                toastr.error(response.msg, response.title);
            }
         
         },
         error: function(response){
            if(response.status == 500){
             toastr.error('Server Error', 'error');
            }
    
        }
    
    
       });
    
    })







$('#fee_category').click(function(){

    $('#fcategory').modal('show');


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





































