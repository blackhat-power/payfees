
@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Students Management</a></li>
                <li class="breadcrumb-item active" aria-current="page">Students Promotion</a></li>
              </ol>
          </nav>
  
@endsection 
@section('content-body')
            <div class="card" style="width: 100%">
               
                <div class="card-header header-elements-inline">
                    <h5 class="card-title font-weight-bold text-center">
                        Student Promotion from <span class="text-danger">  {{ $old_year }}  </span>  TO <span class="text-success"> {{ $new_year }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <form id="promotion_form" method="POST" action="{{route('students.promotions.list')}}">
                        @csrf
                   <div class="row">
                       <div class="col-md-10">
                        <fieldset>
                            <div class="row">
                                
                                <div class="col-md-5"  style="border-top: 3px solid #f39c12">
                                    <div class="row" style="margin-top: 5%">            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="">From Class:</label>
                                     <select name="from_class_promo" id="from_class_promo" id="" class="form-control form-control-sm" required>
                                         <option value=""></option>
                                         @foreach ($classes as $class)
                                         <option value="{{$class->id}}" {{ ($checked && $fc == $class->id) ? 'selected' : '' }} > {{$class->name}}</option>
                                         @endforeach
                                     </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                 <div class="form-group">
                                     <label class="font-weight-bold" for="">From Stream</label>
                                    <select name="from_stream_promo" id="from_stream_promo" class="form-control form-control-sm">
                                        <option value=""></option>
                                    </select>
                                 </div>
                             </div>

                                    </div>

                                </div>
                                <div class="col-md-1"></div>
                          
                                <div class="col-md-6" style="border-top: 3px solid #00a65a">
                                    <div class="row" style="margin-top: 5%">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="">To Class:</label>
                                                <select name="to_class_promo" id="to_class_promo" class="form-control form-control-sm" required>
                                                    <option value=""></option>
                                                    @foreach ($classes as $class)
                                                    <option value="{{$class->id}}"  {{ ($checked && $tc == $class->id) ? 'selected' : '' }}> {{$class->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                           <div class="form-group">
                                               <label class="font-weight-bold" for="">To Stream:</label>
                                               <select name="to_stream_promo" id="to_stream_promo" class="form-control form-control-sm">
                                                   <option value=""></option>
                                               </select>
                                           </div>
                                       </div>

                                    </div>


                                </div>

                            </div>
                        </fieldset>
                       </div>

                       <div class="col-md-2 mt-5">
                        <div class="text-right mt-4">
                            <button id="promotion_query" type="submit" class="btn btn-primary btn-sm">Manage Promotion <i class="fa fa-paper-plane ml-2"></i></button>
                        </div>
                    </div>
                   </div>
                    </form>
                </div>
             </div>


             @if ($checked)

             <div class="card">
                <div class="card-header header-elements-inline">
                </div>
        
                <div class="card-body">
                    @include('registration::student.promotions.promotion')
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
            $(this).val("P");
            
        }
        else{

            $(this).val("D");
            $(this).closest('div').find('input[type="hidden"]').removeAttr('disabled');

        }

    });
   

});



$('#promote_students').click(function(){

    let form_data = $('#promote_form').find(':input[value!=""]').serialize();
    {{-- let fc = @php echo $fc ? $fc : '' @endphp;
    let fs = @php echo $fs ? $fs : '' @endphp;
    let tc = @php echo $tc ? $tc : '' @endphp;
    let ts = @php echo $ts ? $ts : '' @endphp; --}}
    {{-- console.log(tc); --}}
    let url = '{{ route('students.promote',[$fc,$tc,$fs,$ts]) }}';
   
    {{-- let url = init_url.replace(':fc',fc).replace(':fs',fs).replace(':tc',tc).replace(':ts',ts); --}}
    startSpinnerOne();
    
     $.ajax({
        url:url,
        type:'POST',
        data:form_data,
        success:function(response){
            console.log(response)
            window.location.replace(response)
            {{-- window.location.href =  --}}
            stopSpinnerOne();
        }
    }) 
    {{-- alert('iyoo'); --}}
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