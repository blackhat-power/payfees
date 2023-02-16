


@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">

            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">System Configurations</a></li>
                <li class="breadcrumb-item" aria-current="page"> <a href="{{route('accounts.school.fee.structure.master')}}"> Fee Structure Settings</a></li>
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

            .icon {
        width: 10rem;
        height: 70px;
        text-align: center;
        margin: 1rem 1px;
        display: inline-block;
      }
      .icon i {
        font-size: 40px;
        color: #333;
        margin-top: 15px;
      }
      .icon span {
        font-size: .9rem;
        margin-top: 10px;
      }
      img {
    max-width: 30%;
}


.box {
  border: 1px solid #ccc;
  box-shadow: 0 2px 5px #ccc;
  transition: all 0.3s ease-in-out;
}

.box:hover {
  border: 2px solid #04476a;
  box-shadow: 0 4px 10px #04476a;
  transform: translateY(-2px);
}

.container_style{

display: flex;
direction: horizontal;
justify-content: space-around;
width: 100%;
margin-bottom:2rem;


}


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

            <div class="container">
              <div class="container_style">
              <div class="box">
                <a href="javascript:void(0)" id="fee_category">
                <div class="icon">
                  <img src="{{asset('assets/images/category_fee.png')}}" alt="">
                <h6>Fee Master Category </h6>
                <small>Create Fee Master Categories</small>
                </div>
                </a>
            </div>

            <div class="box">
              <a href="{{ route('accounts.school.fee.structure.patcl.index') }}">
              <div class="icon">
                <img src="{{asset('assets/images/fee.png')}}" alt="">
              <h6> Fee Particulars </h6>
              <small>Create Category Fee Items </small>
              </div>
            </a>
              </div>
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





































