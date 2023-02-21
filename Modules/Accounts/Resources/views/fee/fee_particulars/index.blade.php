


@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">

            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">System Configurations</a></li>
                <li class="breadcrumb-item" aria-current="page"> <a href="{{ route('accounts.school.fee.structure.master') }}"> Fee Structure Settings</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('accounts.school.fee.structure.master.categories.index') }}"> Fee Maste Categories </a></li>
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
            .scrollable-content{
                height: 160px; /* set the height of the div */
                overflow-y: scroll; /* add scroll to the y-axis */
                background: #eeeeee;
            }

            .space_pad{
                padding: 24px;
            }
            .mg-top{
                margin-top: 1.4rem;
            } 

            .checkMates{

                position: absolute;
                margin-top: 0.3rem;
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

          </style>

@endsection


@section('content-body')
        </div>
    </div>
    <div style="bakground:#f4f9fa">
    <div class="card" style="100%;" >
        <div class="card-header">

        </div>

        <div class="card-body">

            <div class="container">
                <form id="structure_form">
                <div class="row">
                    <div class="col-md-6">

                        <table>
                            <tr>
                                <td class="space_pad">  Name: </td>
                                <td> 
                                    <select data-must="1" name="particular_id" id="particular_id" class="form-control form-control-sm" style="width: 22rem">
                                        <option value=""> Select A Particular</option>
                                        @foreach ($master_particulars as  $particular)
                                            <option value="{{$particular->id}}"> {{  $particular->name }} </option>
                                        @endforeach
                                    </select>
                                 </td>
                            </tr>
    
                            <tr>
                                <td class="space_pad">Description: </td>
                                <td> 
                                    <input type="text" name="description" class="form-control form-control-sm">
                                 </td>
                            </tr>
    
                            <tr>
                                <td class="space_pad">Create Using:</td>
                                <td>  
                                <table>
                                    
                                <tr>
                                    <td style="padding-left: 3rem;"><input style="position: relative" class="form-check-input" type="radio" name="student_category" value="1" checked></td>
                                    <td>all</td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 3rem;"><input style="position: relative" class="form-check-input" type="radio" name="student_category" value="2"></td>
                                    <td>Admission Number</td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 3rem;"><input style="position: relative" class="form-check-input" type="radio" name="student_category"  value="3"></td>
                                    <td> <span> Student Category</span> </td>
                                </tr>
                                </table>    
                                
                                </td>
                            </tr>
    
                            <tr>
    
                                <td class="space_pad">Amount </td>
                                <td>
                                    <input name="amount" data-must="1" id="amount" type="text" class="form-control form-control-sm">
                                </td>
    
                            </tr>
                          
                        </table>
    
    
                      </div>


                  <div class="col-md-6">
                    <div class="row">
                        <table id="category_tr">
                            <tr>
                                <td class="space_pad">Select a Category</td>
                                <td>
                                    <select style="width: 22rem" data-must="1" name="select_category" id="select_category" class="form-control form-control-sm">
                                        <option value="">Select a Category</option>
                                        @foreach ($fee_master_categories as $cat )

                                        <option value="{{$cat->id}}"> {{ $cat->name }}</option>
                                            
                                        @endforeach
                                    </select>

                                </td>
                                <td>
                                    <span style="margin-left: .7rem; display:none" id="loader_spin" >
                                        <img src="{{ asset('assets/images/new_loader.gif') }}" alt="">
                                        </span>
                                    </td>
                            </tr>
                        </table>
                    </div>

                    <div class="row">
                        <div class="container" id="the_container" style="display: none">
                            <div>  <span style="font-size: .9rem;">Select a Class </span> <span class="text-danger">*</span> </div>
                            <div class="scrollable-content">
                                <table><tr><td>Select: &nbsp;</td> <td><span><a id="all" href="javascript:void(0)">All</a> ,&nbsp;&nbsp; <a id="none" href="javascript:void(0)">None</a></span></td></tr></table>
                                <hr>
                                <div id="part"></div>

                            </div>
                    </div>
                   

                  </div>


                 
                  
                </div>
              </div>

            </form>
        </div>
    </div>

    <div class="card-footer">
        <span style="float:right">
            <button  class="btn btn-sm btn-primary" id="save_header"> Create </button>
        </span>
    </div>


</div>

 @endsection

 @section('scripts')


$('#select_category').change(function(e){
    e.preventDefault();

    let category_id = $(this).val();
    console.log(category_id)

    $('#loader_spin').removeAttr('style','display:none');

    $.ajax(
        {
         {{-- processData:false,
         contentType: false,  --}}
         url:'{{ route('accounts.school.fee.structure.patcl.category')  }}',
         type:'POST',
         data:{
            category_id:category_id,
         },
         dataType: "JSON",
         success:function(response){

            console.log(response);
            $('#loader_spin').attr('style','display:none');
             if(response.state == 'Done'){

                $('#the_container').removeAttr('style','display:none');

                $('#part').html(
                response.content
                );
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


    {{-- STORE --}}
   


    $('#save_header').click(function(){

        $category = $('#select_category').val();
        $particular_id = $('#particular_id').val();

        if($('#amount').val() && $category && $particular_id ){

            let form = $('#structure_form')[0];
            let form_data = new FormData(form);

            $.ajax(
                {
                 processData:false,
                 contentType: false, 
                 url:'{{ route('accounts.school.fee.structure.patcl.category.store')  }}',
                 type:'POST',
                 data:form_data,
                 dataType: "JSON",
                 success:function(response){
                     if(response.state == 'Done'){
                         toastr.success(response.msg, response.title);
                         $('#fcategory').modal('hide');
                        
                         let elements = $("#structure_form").find("input, select");
                            elements.each(function() {
                                $(this).val('')
                            });

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


        }else{

            let elements = $("#structure_form").find("input, select");
            elements.each(function() {
                if ( !$(this).val() && $(this).data('must')) {
                    $(this).addClass('is-invalid');
                }
            });
            {{-- if(!)
            $('#amount').addClass('is-invalid'); --}}

        }
        })

{{-- $('#select_category').select2({width:'100%'});
$('#particular_id').select2({width:'100%'}); --}}




 @endsection





































