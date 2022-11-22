
@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Student Management</a></li>
                <li class="breadcrumb-item active" aria-current="page">Graduate Students</a></li>
              </ol>
          </nav>
  
@endsection 
@section('content-body')
            <div class="card" style="width:100%">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title font-weight-bold text-center">
                       Graduate Students <span class="text-danger">  {{ $old_year }}  </span>
                    </h5>
                </div>
                <div class="card-body">
                    <form id="graduate_form" method="POST" action="{{route('students.graduands.list')}}">
                        @csrf
                   <div class="row">
                       <div class="col-md-12">
                        <fieldset>
                            <div class="row justify-content-center">
                                <div class="col-md-8"  style="border-top: 3px solid #f39c12">
                                    <div class="row" style="margin-top: 5%">            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="">Class:</label>
                                     <select name="from_class_promo" id="from_class_promo" id="" class="form-control form-control-sm" required>
                                         <option value=""></option>
                                         @foreach ($classes as $class)
                                         <option value="{{$class->id}}" {{ ($selected && $fc == $class->id) ? 'selected' : '' }} > {{$class->name}}</option>
                                         @endforeach
                                     </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                 <div class="form-group">
                                     <label class="font-weight-bold" for="">Stream</label>
                                    <select name="from_stream_promo" id="from_stream_promo" class="form-control form-control-sm">
                                        <option value=""></option>
                                        {{-- @foreach ($streams as $stream )
                                        <option value="{{$stream->id}}"
                                        @if (isset($from_stream) && $selected)
                                            @if ($from_stream->stream_id == $stream->id ) 'selected' @endif
                                        @endif> {{$stream->name}} </option>    
                                        @endforeach --}}
                                    </select>
                                 </div>
                             </div>

                                    </div>

                                </div>
                                <div class="col-md-2" style="margin-left: -8%; margin-top:2.5rem !important">
                                    {{-- <div class="form-group"></div> --}}
                                 <div class="text-right mt-4">
                                     <button id="promotion_query" type="submit" class="btn btn-primary btn-sm">Fetch</button>
                                 </div>
         
                                </div>
                          
                            </div>
                        </fieldset>
                       </div>
                   </div>
                    </form>
                </div>
             </div>


             @if ($selected)

             <div class="card" style="width: 100%">
                <div class="card-header header-elements-inline">
                    <h6 class="card-title font-weight-bold text-center"> <span class="text-teal"> {{ $from_class->name}}  {{ ($from_stream) ? $from_stream->name : ''  }}</span> Graduands List <span></span>  </h6>
                    {{-- {!! Qs::getPanelOptions() !!} --}}
                </div>
          
                <div class="card-body">
                    @include('registration::student.graduates.graduands_list')
                </div>
            </div>

             @endif
    @endsection

@section('scripts')


$('#from_class_promo').change(function(){

  let class_id = $(this).val();
  startSpinnerOne();
    $.ajax({

        url:'{{ route('students.from_class.filter') }}',
        data:{
            class_id : class_id
        },

        success: function(response){

            $('#from_stream_promo').html(response);
            setTimeout(function(){
                stopSpinnerOne();
            },1000)
            
        }
    });
});


$('#to_class_promo').change(function(){

    let class_id = $(this).val();
    startSpinnerOne();
      $.ajax({
          url:'{{ route('students.to_class.filter') }}',
          data:{
              class_id : class_id
          },
          success: function(response){

               $('#to_stream_promo').html(response);
               stopSpinnerOne();

          }
      });
  });


  $('#from_stream_promo').change(function(){
     console.log('jQueryMan');
  });
  

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });


  $('#class_select').select2({
      width:'100%'
  });

  $('#stream_select').select2({
      width:'100%'
  })

  $('#to_class_promo').select2({
    width:'100%'
})

$('#to_stream_promo').select2({
    width:'100%'
})

$('#from_stream_promo').select2({
    width:'100%'
})

$('#from_class_promo').select2({
    width:'100%'
})

  $("#registration_checkbox").change(function() {
    if(this.checked) {
        $('#excel_template_display').removeAttr('style')
    }else{
        $('#excel_template_display').attr('style','display:none')
    }
});


{{-- $('.class_select').select2({
    multiple:false
}); --}}


$("input[type=checkbox]").each(function() {
    $(this).click(function(){
        if($(this).is(':checked')){
            $(this).closest('div').find('input[type="hidden"]').attr('disabled');
            $(this).val("G");
            
        }
        else{

            $(this).val("D");
            $(this).closest('div').find('input[type="hidden"]').removeAttr('disabled');

        }

    });
   

});



$('#graduate_students').click(function(){

    let form_data = $('#graduands_form').find(':input[value!=""]').serialize();
    let fc = @php echo $fc ? $fc : 0 @endphp;
    let fs = @php echo $fs ? $fs : 0 @endphp;

    let init_url = '{{ route('students.graduants.graduate',[':fc', ':fs']) }}';
   
    let url = init_url.replace(':fc',fc).replace(':fs',fs);

    console.log(url);
    startSpinnerOne();

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Proceed!'
      }).then((result) => {
        if (result.isConfirmed) {
         
            $.ajax({
                url:url,
                type:'POST',
                data:form_data,
                success:function(response){
                    console.log(response)
                    window.location.replace(response)
                    
                }
            })

        }
      })

      stopSpinnerOne();
    

    
})

$("#search_table").on("keyup", function() {
    startSpinnerOne();
    var value = $(this).val().toLowerCase();
    


    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      stopSpinnerOne();
    });
  });

@endsection