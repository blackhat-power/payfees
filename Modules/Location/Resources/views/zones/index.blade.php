@extends('layouts.app')

@section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
        <div class="navbar-breadcrumb">
            <h4 class="mb-0">Zones</h4>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Zones</li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection

@section('content-body')
    <div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#zone_registration" id="register" type="button" class=" btn btn-sm btn-primary float-right" style="color: white"><i class="fa fa-plus-circle"></i> New </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="zones_datatable" class="table table-striped table-bordered" width="100%" style="table-layout: inherit">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Regions</th>
                                <th></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>





    <div class="modal fade" id="zone_registration" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog " role="document" style="width:70%">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Zones</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">×</span>
                 </button>
              </div>
              <hr style=" height: 5px;
                            background-color:#2E9AFE ;
                            border: none;">       
              <div class="modal-body">

                 <div id="bank_details">
                     <form id="zones_form">
                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                 <label for="Zone Name"> Name</label>
                                 <input type="text" name="zone" id="zone" class="form-control form-control-sm">
                              </div>
                            </div>
                          {{-- <div class="col-md-12">
                              <div class="form-group">
                                  <label for="Post Code">Post Code.</label>
                                  <input type="text" class="form-control input-sm" name="swift_code" id="">
                              </div>
                          </div> --}}
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="Descriptions">Descriptions.</label>
                                  <textarea name="descriptions" id="descriptions" rows="3" class="form-control"></textarea>
                              </div>
                          </div>
                        </div>

                        <input type="hidden" name="zone_id" id="zone_id">

                     </form>
                 </div>
    
    
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#">  <button type="button" class="btn btn-primary"  id="save_zone">Save changes</button>  </a> 
              </div>
           </div>
        </div>
     </div>

     @endsection

     @section('scripts')
     let zones_datatable = $('#zones_datatable').DataTable({
        processing: true,
        serverSide: true,
         ajax:'{{ route('location.zones.datatable') }}',
         columns:[
             {data: 'name', name:'name'},
             {data:'region', name:'region'},
             {data:'action', name:'action', orderable:false, searchable:false}
         ],

     });

     $('#register').click(function(){

      $('#zones_form')[0].reset();
      $('#zone_id').val(0);
      
  });

   
       $('#save_zone').click(function(){
  
          let form_data = $('#zones_form').serialize();
          let url = '{{ route('location.zones.store') }}';
  
          $.ajax({
              type:'POST',
              data:form_data,
              url:url,


              success:function(response){

                  zones_datatable.ajax.reload();
                  $('#zone_registration').modal('hide');
                  $('#zones_form')[0].reset();
                    if(response.state == 'Done'){
                        toastr.success(response.msg, response.title);                        
                    }
                    else if(response.state == ' Fail'){
                        toastr.warning(response.msg, response.title)
            
                    }
                    else{
                        toastr.error(response.msg, response.title);
                    }
            
                },
                error: function(response){
                    
                    toastr.error(response.msg, response.title);
                    
                }
  
              });
          });
  
   $('body').on('click','.zoneEditBtn', function (e) {
       e.preventDefault();
       let edit_id = $(this).data('edit_zone_id');
       let url = '{{route('location.zones.edit','id')}}';
       url = url.replace('id',edit_id);
       $.ajax({
         type:'POST',
         data:{
             zone_id : edit_id
         },
         url:url,
         success:function(response){

            $('#descriptions').val(response.descriptions);
            $('#zone').val(response.name);
            $('#zone_id').val(response.id);
            $('#zone_registration').modal('show');
  
         }
     })  
     });

   
  
     $('body').on('click', '.zoneDltBtn', function(e){
         e.preventDefault();
         let dlt_id = $(this).data('delete_zone_id');
         let url = '{{route('location.zones.destroy','id')}}';
         url = url.replace('id',dlt_id);
         {{-- confirm('are you sure you want to delete?'); --}}
         $.ajax({
             url:url,
             type:'DELETE',
             success:function (){
               zones_datatable.draw();
               if(response.state == 'Done'){
                toastr.success(response.msg, response.title);                        
            }
            else if(response.state == ' Fail'){
                toastr.warning(response.msg, response.title)
    
            }
            else{
                toastr.error(response.msg, response.title);
            }
    
        },
        error: function(response){
            
            toastr.error(response.msg, response.title);
            
        }
         });
     });


     @endsection