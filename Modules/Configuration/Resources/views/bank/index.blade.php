@extends('layouts.app')

@section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
        <div class="navbar-breadcrumb">
            <h4 class="mb-0">Registered Banks</h4>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Banks</li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection

@section('content-body')

    <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header border-bottom">
                    <a href="javascript:void(0)" id="bank_amsha_modal" type="button" class=" btn btn-sm btn-primary float-right" style="color: white"><i class="fa fa-plus-circle"></i> New </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="banks_datatable" class="table table-striped table-bordered" width="100%" style="table-layout: inherit">
                            <thead>
                            <tr>
                                <th>Bank Name</th>
                                <th>Swift Code</th>
                                <th>Location</th>
                                <th>action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>





    <div class="modal fade" id="bank_registration" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md" role="document">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Bank Registration</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">×</span>
                 </button>
              </div>
              <hr style=" height: 5px;
                            background-color:#2E9AFE ;
                            border: none;">       
              <div class="modal-body">

                 <div id="bank_details">
                     <form id="bank_form">
                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                 <label for="Bank Name"> Bank Name</label>
                                 <input type="text" name="bank_name" class="form-control" id="bank_name">
                                 <input type="hidden" name="bank_id" id="bank_id">
                              </div>
                            </div>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="Account No">Swift Code.</label>
                                  <input type="text" class="form-control " name="swift_code" id="swift_code">
                              </div>
                          </div>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="Location">Location.</label>
                                  <input type="text" class="form-control" name="location" id="location_name">                    
                              </div>
                          </div>
                        </div>

                     </form>
                 </div>
    
    
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#">  <button type="button" class="btn btn-primary"  id="save_bank">Save changes</button>  </a> 
              </div>
           </div>
        </div>
     </div>

     @endsection

     @section('scripts')
     let bank_datatable = $('#banks_datatable').DataTable({
        processing: true,
        serverSide: true,
         ajax:'{{ route('configurations.banks.datatable') }}',
         columns:[
             {data: 'bank_name', name:'bank_name'},
             {data:'swift_code', name:'swift_code'},
             {data:'location', name:'location'},
             {data:'action', name:'action', orderable:false, searchable:false}
         ],

     });

     $('#bank_amsha_modal').click(function(){
         
        let bank_form = $('#bank_form');
        clearForm(bank_form);
        $('#bank_registration').modal('show');

     })


     $('#save_bank').click(function(){
          {{-- alert('clicked') --}}
         let form_data = $('#bank_form').serialize();
         let url = '{{ route('configurations.banks.store') }}';

         $.ajax({
             type:'POST',
             data:form_data,
             url:url,
             success:function(response){
               
                if(response.state == 'Done'){
                    console.log(response);
                   toastr.success(response.msg, response.title);
                    $('#bank_registration').modal('hide');
                    bank_datatable.ajax.reload();
                }
                     
                else if(response.state == 'Fail'){
                    toastr.warning(response.msg, response.title)
                    console.log(response)
                }
       
                else if(response.state == 'Error'){
                   toastr.error(response.msg, response.title)
                   console.log(response)
               }
        
            },
            error: function(response){  
       
                console.log(response)   
                
            }
                
         });

     });

  $('body').on('click','.bankEditBtn', function (e) {
      e.preventDefault();
      let edit_id = $(this).data('bank_edit_id');
       let init_url = '{{ route('configurations.banks.edit','id') }}';
       let url = init_url.replace('id',edit_id);
      $.ajax({
        url:url,
        success:function(response){
            console.log(response);
            $('#bank_name').val(response.bank_name);
            $('#location_name').val(response.location);
            $('#swift_code').val(response.swift_code);
            $('#bank_id').val(response.id);
           $('#bank_registration').modal('show');

        }
    })  
    });

    $('body').on('click', '.bank-delete', function(e){
        e.preventDefault();
        let dlt_id = $(this).data('bank_delete_id');
        let url = '{{route('configurations.banks.destroy','id')}}';
        url = url.replace('id',dlt_id);
        {{-- confirm('are you sure you want to delete?'); --}}
        $.ajax({
            url:url,
            type:'DELETE',
            success:function (){
                bank_datatable.draw();
                    if(response.state == 'Done'){
                        console.log(response);
                       toastr.success(response.msg, response.title);
                        $('#bank_registration').modal('hide');
           
                    }
                         
                    else if(response.state == 'Fail'){
                        toastr.warning(response.msg, response.title)
                        console.log(response)
                    }
           
                    else if(response.state == 'Error'){
                       toastr.error(response.msg, response.title)
                       console.log(response)
                   }
            
                },
                error: function(response){  
           
                    console.log(response)   
                    
                }
        });
    });




     @endsection