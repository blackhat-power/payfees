@extends('layouts.app')

@section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
        <div class="navbar-breadcrumb">
            <h4 class="mb-0">Districts</h4>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Districts</li>
                </ul>
            </nav>
        </div>
    {{--     <div class="btn-group btn-group-toggle">
            <a type="button" href="" id="register" data-toggle="modal" data-target="#district_registration" class="button btn btn-primary btn-sm mr-2"><i class="ri-add-line m-0"></i>Register</a>
        </div>
    </div> --}}
</div>
@endsection

@section('content-body')
    <div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#districts_registration" id="register" type="button" class=" btn btn-sm btn-primary float-right" style="color: white"><i class="fa fa-plus-circle"></i> New </a>
                    <span>
                        <input type="checkbox" id="filter_checkbox" class="checkbox-input float-left" style="width: 30px; height: 30px;">
                       Filters
                    </span>
            
            
                    <div class="row" style="margin-top:2%; display:none" id="toggleFilters">
                        <div class="col-md-3">
                            <select name="region_filter" id="region_filter" class="form-control form-control-sm">
                                <option value="">Select Region</option>
                            </select>   
                        </div>
            
                       {{--  <div class="col-md-3">
                            <select name="stream_filter" id="stream_filter" class="form-control form-control-sm">
                                <option value="">Select Stream</option>
                            </select>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="districts_datatable" class="table table-striped table-bordered" width="100%" style="table-layout: inherit">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Region</th>
                                <th>Zone</th>
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





    <div class="modal fade" id="districts_registration" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog " role="document" style="width:70%">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Districts</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">×</span>
                 </button>
              </div>
              <hr style=" height: 5px;
                            background-color:#2E9AFE ;
                            border: none;">       
              <div class="modal-body">

                 <div id="bank_details">
                     <form id="districts_form">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="Region Name"> Name</label>
                                 <input type="text" name="district_name" id="district_name" class="form-control form-control-sm">
                              </div>
                            </div>

                            <input type="hidden" name="district_id" id="district_id">


                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Region">Region</label>
                                  <select name="region_id" id="region_id" class="form-control form-control-sm input-sm">
                                      <option value="">Select Region</option>
                                      @foreach ($regions as $region )
                                      <option value="{{ $region->id }}">{{$region->name}}</option>
                                      @endforeach
                                  </select>
                                  {{-- <input type="text" class="form-control" name="account_no" id=""> --}}
                              </div>
                          </div>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="Post Code">Post Code.</label>
                                  <input type="text" class="form-control input-sm form-control-sm" name="post_code" id="post_code">
                              </div>
                          </div>
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
                <a href="#">  <button type="button" class="btn btn-primary"  id="save_district">Save changes</button>  </a> 
              </div>
           </div>
        </div>
     </div>

     @endsection

     @section('scripts')
     let districts_datatable = $('#districts_datatable').DataTable({
        processing: true,
        serverSide: true,
         ajax:'{{ route('location.districts.datatable') }}',
         columns:[
             {data: 'name', name:'name'},
             {data:'region', name:'region'},
             {data:'zone', name:'zone'},
             {data:'wards', name:'wards'},
             {data:'action', name:'action', orderable:false, searchable:false}
         ],

     });

$('#register').click(function(){

    $('#districts_form')[0].reset();
    $('#district_id').val(0);
});
 
     $('#save_district').click(function(){

        let form_data = $('#districts_form').serialize();
        let url = '{{ route('location.districts.store') }}';

        $.ajax({
            type:'POST',
            data:form_data,
            url:url,
            success:function(response){
                console.log(response)
                districts_datatable.ajax.reload();
                $('#districts_registration').modal('hide');
                $('#districts_form')[0].reset();

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
        })

    });

 $('body').on('click','.dstrctEditBtn', function (e) {
     e.preventDefault();
     let edit_id = $(this).data('edit_district_id');
     let url = '{{route('location.districts.edit','id')}}';
     url = url.replace('id',edit_id);
     $.ajax({
       type:'POST',
       data:{
           district_id : edit_id
       },
       url:url,
       success:function(response){
            console.log(response);
          $('#district_name').val(response.name);
          $('#post_code').val(response.post_code);
          $('#descriptions').val(response.descriptions);
          $('#zone').val(response.zone_id);
          $('#region_id').select2('destroy').val(response.region_id).prop('selected',true).select2({width:'100%'});
          $('#district_id').val(edit_id);

          $('#districts_registration').modal('show');

       }
   })  
   });

   $('#region_id').select2({width:'100%'});

   $('body').on('click', '.dstrctDltBtn', function(e){
       e.preventDefault();
       let dlt_id = $(this).data('delete_district_id');
       let url = '{{route('location.districts.destroy','id')}}';
       url = url.replace('id',dlt_id);
       {{-- confirm('are you sure you want to delete?'); --}}
       $.ajax({
           url:url,
           type:'DELETE',
           success:function (){
            districts_datatable.draw();
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

   $('#region_filter').select2({width:'100%'});

   $("#filter_checkbox").change(function() {
    if(this.checked) {
        $('#toggleFilters').removeAttr('style','display:none').css({'margin-top':'2%'});
    }else{
        $('#toggleFilters').css({'display':'none'});
    }
 });

     @endsection