@extends('layouts.app')

@section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
        <div class="navbar-breadcrumb">
            <h4 class="mb-0">Regions</h4>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Regions</li>
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
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#region_registration" id="register" type="button" class=" btn btn-sm btn-primary float-right" style="color: white"><i class="fa fa-plus-circle"></i> New </a>
                    <span>
                        <input type="checkbox" id="filter_checkbox" class="checkbox-input float-left" style="width: 30px; height: 30px;">
                       Filters
                    </span>
            
            
                    <div class="row" style="margin-top:2%; display:none" id="toggleFilters">
                        <div class="col-md-3">
                            <select name="class_filter" id="zone_filter" class="form-control form-control-sm">
                                <option value="">Select Zone</option>
                            </select>   
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="regions_datatable" class="table table-striped table-bordered" width="100%" style="table-layout: inherit">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Zone</th>
                                <th>Districts</th>
                                <th>Wards</th>
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





    <div class="modal fade" id="region_registration" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog " role="document" style="width:70%">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Regions</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">×</span>
                 </button>
              </div>
              <hr style=" height: 5px;
                            background-color:#2E9AFE ;
                            border: none;">       
              <div class="modal-body">

                 <div id="bank_details">
                     <form id="region_form">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="Region Name"> Name</label>
                                 <input type="text" id="region_name" name="region_name" class="form-control form-control-sm">
                              </div>
                            </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Zone">Zone</label>
                                  <select name="zone" id="zone" class="form-control">
                                      <option value="">Select Zone</option>
                                      @foreach ($zones as $zone )
                                      <option value="{{ $zone->id }}">{{ $zone->name  }}</option> 
                                      @endforeach
                                    
                                  </select>
                                  {{-- <input type="text" class="form-control" name="account_no" id=""> --}}
                              </div>
                          </div>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="Post Code">Post Code.</label>
                                  <input type="text" id="post_code" class="form-control form-control-sm input-sm" name="post_code" id="">
                              </div>
                          </div>

                          <input type="hidden" id="region_id" name="region_id">

                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="Descriptions">Descriptions.</label>
                                  <textarea name="descriptions" id="descriptions" rows="3" class="form-control"></textarea>
                              </div>
                          </div>
                        </div>

                     </form>
                 </div>
    
    
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#">  <button type="button" class="btn btn-primary"  id="save_region">Save changes</button>  </a> 
              </div>
           </div>
        </div>
     </div>

     @endsection

     @section('scripts')
     let regions_datatable = $('#regions_datatable').DataTable({
        processing: true,
        serverSide: true,
         ajax:'{{ route('location.regions.datatable') }}',
         columns:[
             {data: 'name', name:'name'},
             {data:'zone', name:'zone'},
             {data:'districts', name:'districts'},
             {data:'wards', name:'wards'},
             {data:'action', name:'action', orderable:false, searchable:false}
         ],

     });


     $('#save_region').click(function(){

         let form_data = $('#region_form').serialize();
         let url = '{{ route('location.regions.store') }}';

         $.ajax({
             type:'POST',
             data:form_data,
             url:url,
             success:function(response){
                 console.log(response)
                regions_datatable.ajax.reload();
                 $('#region_registration').modal('hide');

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

  $('body').on('click','.rgnEditBtn', function (e) {
      e.preventDefault();
      let edit_id = $(this).data('edit_region_id');
      let url = '{{route('location.regions.edit','id')}}';
      url = url.replace('id',edit_id);
      $.ajax({
        type:'POST',
        data:{
            region_id : edit_id
        },
        url:url,
        success:function(response){

           $('#region_name').val(response.name);
           $('#post_code').val(response.post_code);
           $('#descriptions').val(response.descriptions);
           $('#zone').select2('destroy').val(response.zone_id).select2({width:'100%'});;
           $('#region_id').val(edit_id);

           $('#region_registration').modal('show');

        }
    })  
    });

    $('#register').click(function(){

        $('#region_form')[0].reset();
        $('#region_form').val(0);


    });

    $('#zone').select2({width:'100%'});

    $('body').on('click', '.rgnDltBtn', function(e){
        e.preventDefault();
        let dlt_id = $(this).data('delete_region_id');
        let url = '{{route('location.regions.destroy','id')}}';
        url = url.replace('id',dlt_id);
        {{-- confirm('are you sure you want to delete?'); --}}
        $.ajax({
            url:url,
            type:'DELETE',
            success:function (){
                regions_datatable.draw();
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

    $('#zone_filter').select2({width:'100%'});



    $("#filter_checkbox").change(function() {
        if(this.checked) {
            $('#toggleFilters').removeAttr('style','display:none').css({'margin-top':'2%'});
        }else{
            $('#toggleFilters').css({'display':'none'});
        }
     });

     @endsection