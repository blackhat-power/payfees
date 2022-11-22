@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Accounts</a></li>
                <li  class="breadcrumb-item"><a href="{{route('accounts.invoice')}}">Invoices</a></li>
                <li class="breadcrumb-item active" aria-current="page">New Invoice</a></li>
              </ol>
          </nav>
  
@endsection 


@section('content-body')

<div class="card" style="width: 100%; border-top: 4px solid #00a65a;">
    <div class="card-header">Student Info</div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab-1" role="tablist">
            <li class="nav-item">
               <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Search By Reg. No</a>
            </li>
            <li class="nav-item">
               <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Search By class</a>
            </li>
         </ul>

         <div class="tab-content" id="myTabContent-2">
            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">

               {{-- ON PROGRESS --}}
             
            </div>
            <div class="tab-pane fade active show" id="profile" role="tabpanel" aria-labelledby="profile-tab">

            {{-- FORM --}}
            <form id="invoice_form" method="POST" action="{{ route('accounts.invoices.filter.fee_structure') }}">
                @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Academic Season">Academic Season <span class="text-red">*</span></label>
    
                    <select name="academic_season" class="form-control form-control-sm" id="academic_season" required>
                    @foreach($seasons as $season)
                            <option value="{{ $season->id }}"  {{ $season_id == $season->id ? 'selected' : ''  }} >{{$season->name}}</option>
                    @endforeach
                        
                    </select>
                 </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label style="text-align:center" for="">Class Name <span class="text-red">*</span></label>
                <select name="class_id" id="class_search" class="form-control form-control-sm" required>
                    <option value=""> Select Class </option>
                    @foreach ($classes as $class )

                    <option value="{{$class->id}}" {{ $c_id == $class->id ? 'selected' : ''  }}>{{ $class->name }}</option>    
                    @endforeach
                </select>
            </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label style="" for="">Student Name  <span class="text-red">*</span>  </label>
                <select name="account_id" id="student_search" class="form-control form-control-sm" required>
                    <option value=""> Select Student </option>
                    @foreach ($students as $student )
                    <option value="{{$student->id}}" {{ $std_id == $student->id ? 'selected' : ''  }}> {{$student->first_name}}  {{$student->middle_name}} {{$student->last_name}}</option>    
                    @endforeach
                </select>
            </div>
            </div>
        </div>

       

                       @if ($selected)
                       <div class="row">
                                                   <div class="col-md-12">

                                                    <div class="row">
                                                        <div class="col-md-12" id="dueInvoiceList">
                                                                <h5 style="color: #a94465">Due Invoices:</h5>
                            
                                                                <table class="table" style="width: 30%; margin-top:1%">
                                                                    @foreach ($due_invoices as $invoice)
                                                                 <tr>
                                                                    <td colspan="2">{{$invoice['invoice_number']}}</td>
                                                                    <td> <span class="rounded-pill text-center" style="background-color:#e36e60; padding:4px">
                                                                         <a target="_blank" href="{{ route('accounts.students.payments.create',[encrypt($invoice['invoice_id']),encrypt($invoice['balance']),encrypt($std_id)]) }}" class="text-white">{{ number_format($invoice['balance'])}}</a>
                                                                        </span>
                                                                        <input type="hidden" name="invoice_id" id="invoice_id" value="{{$invoice['invoice_id']}}">
                                                                      
                                                                     </td>
                                                                </tr>
                                              
                                                                    @endforeach
                                                                  
                                                                </table>
                                                                <ul class="nav nav-stacked">
                                                        </div>
                                                       
                                                    </div>
                                               
                                            </div> 
                                        </div>
                                            @endif



        <div class="col-md-12">     
            <div class="row float-right">
                <div class="col-md-6">
                    <button  type="submit" id="new_invoice_btn" class="btn btn-primary btn-sm">Fetch</button>
                </div>
            </div>
        </div>
            </form>

{{-- END FORM --}}
            </div> {{-- close tab pane --}}


    </div> {{-- close Tab --}}

</div>
</div>

                        
                 @if ($selected)
                        <form id="invoice_form_store" method="POST">
                            @csrf
                        <div class="row">
                                   <div class="card" style="border-top:4px solid #f39c12; width: 31em; margin-left: 1em;">
                                       <div class="card-header"> Invoice Info: </div>
                                       <div class="card-body">
                                       <div class="row">
                                           <div class="col-md-12">
                                               <div class="form-group">
                                                   <label for="">Invoice Date: <span class="text-red"> *</span></label>
                                                   <input type="text" id="date" name="date" class="form-control form-control-sm" required>
                                                   <input type="hidden" name="stdnt_id" id="std_id" value="{{$std_id}}">
                                                   <input type="hidden" name="class_id" id="class_id" value="{{  $c_id }}">
                                               </div>
                                           </div>
                                           <div class="col-md-12">
                                               <div class="input-group">
                                                   <div class="input-group-prepend">
                                                      <span class="input-group-text text-area">REMARKS</span>
                                                   </div>
                                                   <textarea name="remarks" class="form-control" aria-label="With textarea"></textarea>
                                                </div>
                                           </div>
                                       </div>
                                   </div>
                                   </div>   

   
                               <div class="card" style="border-top:4px solid #00a65a;width: 64em; margin-left: 1em;">
                                   <div class="card-header">
                                      Fees
                                   </div>
                                   <div class="card-body">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                <label for="">  Fee Type Group <span class="text-red"> *</span></label>
                                                <select name="fee_type_group" id="fee_type_group" class="form-control form-control-sm">
                                                    <option value="">Choose Fee Group</option>
                                                    @foreach ($fee_groups as $fee_group)
            
                                                    <option value="{{ $fee_group->id  }}">{{ $fee_group->name }}</option>
            
                                                    @endforeach
                                                </select>
                                              </div>   
                                          </div>
            
                                          <div class="col-md-4">
                                            <div class="form-group" style="margin-top: 23px">
                                            <span id="load_invoice_spinner" style="display:none"> <a href="javascript:void(0)" id="load_invoice_item" style="margin-top: 9%" class="btn btn-sm btn-primary"> <i id="spinner" class="fa fa-spinner fa-spin" aria-hidden="true" style="display:none"></i> <span id="textload">Load Invoice Items</span> </a>  </span>
                                          </div>
                                        </div>
                                      </div>
            
                                      <div class="float_xmachina" id="items_div" style="display: none">
                                        <a href="javascript:void(0)" class="btn btn-sm" title="remove selected Item" class="" id = "float_x">
                                            <i class="fa fa-times-circle"></i>
                                        </a>

                                      <div class="row">
                                        <table id="items_table" class="table table-bordered table-responsive-md">
                                            <thead>
                                                <tr> 
                                                    <th>SN</th>
                                                     <th> Item Name </th>
                                                     <th> Amount (Tzs) </th>
                                                     <th>Status</th>
                                                     <th>Action</th>
                                                 </tr>
                                            </thead>
            
                                            <tbody>
            
                                            </tbody>
                                            <tfoot>
            
                                            </tfoot>
                                        </table>
            
                                      </div>
                                      <div class="row">
                                          {{-- <a href="javascript:void(0)" class="btn btn-primary float-right" style="margin-left: 76%"> CREATE INVOICE </a> --}}
                                      </div>
                                    </div>
                                     
                                     
                                   </div>
                                </div>
   
                            </div>


                    </form>

                
                    

                    {{-- <div class="row"> --}}
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <button class="btn btn-sm btn-warning"> Reset </button>
                                    </div>
                                    <div class="col-md-8">
                                        <span class="float-right" style="margin-right:1%">
                                            <a href="javascript:void(0)" onclick="generateFile('pdf')" type="button" style="color:white" class="btn btn-sm btn-success"><i class="fa fa-print"></i>Print</a>
                                            <a href="javascript:void(0)"  style="color:white" id="save_bill" type="button" class="btn btn-sm btn-primary">CREATE INVOICE</a>
                                        </span>
                                    </div>
        
                                </div>
                               </div>
                            </div>
                        </div>
                    {{-- </div> --}}
                    
                 
                 @endif

  

</section>


@endsection


@section('scripts')

totalFee();
function totalFee(){
    var total = 0;
    $("input[type=checkbox]:checked").each(function() {
        let init_value = $(this).val();
        let value = init_value.replaceAll(',','')
        total += parseFloat(value);
    });
 
    $(".totalSum").val(total.toLocaleString('en-US'));
}

 $('.checkboxes').each(function(){
     $(this).click(function(){
        totalFee();
     });
 })

 let table_html = $("#items_table");
let table_body = $("#items_table tbody");
let table_footer = $("#items_table tfoot");

$('#load_invoice_item').click(function(){

{{-- alert('we gon load'); --}}

$('#spinner').removeAttr('style');
$('#textload').text('loading......');

startInvoiceSpinner();

let group_id = $('#fee_type_group').val();
let class_id = $('#class_search').val();

 $.ajax({

    url:'{{ route('school.fee.structure.group.filter') }}',
    type:'POST',
    data:{ 
        _token: "{{ csrf_token() }}",
        group_id : group_id,
         class_id:class_id
          },

    success:function(response){
        console.log('ffff'+group_id);
        $('#spinner').attr('style','display:none');
        $('#textload').text('Load Invoice Items');

        stopInvoiceSpinner();
        displayItems(response,group_id);
    },

    error:function(res ){

        if(res.status == 500){
            toastr.error('Fee Group Not Set','error');
        }
        
        $('#spinner').attr('style','display:none');
        $('#textload').text('Load Invoice Items');
        table.empty();
        table_footer.empty();

    }

});


});

$('#float_x').click(function(e){
    e.preventDefault()
    table_body.empty();
    $(this).parent().css({ 'display':'none' });
})



function displayItems(response,group_id){

    let total = parseFloat(0); 
    let amount = parseFloat(0);
    var count = 0;
    let index = 0;
    $('#items_div').attr('style','display:block').css({'margin-left':'18%', 'margin-top':'4%'});
    {{-- table.empty();
     --}}
     table_footer.empty();

       index =  $('.data tr:last-child td:first-child').html() ? index = $('table_html tr:last-child td:first-child').html() : index = 0;

        console.log('last index'+index);

    if(group_id == 1 && response.items){

        $.each(response.items, function(indx, elem){
            total += parseFloat(elem.amount);
            amount = parseFloat(elem.amount).toLocaleString()
            console.log(elem.name);
           
            table_body.append('<tr class="data"> <td class="index"></td> <td>' + (elem.name).toUpperCase() + '</td><td style="text-align: right">  <input type="hidden" class="amount" name="amount[]" value=" '+ parseFloat(elem.amount).toLocaleString() +' - '+ elem.name +' ">    ' + (elem.amount).toLocaleString() +'</td> <td> Mandatory </td> </tr><tr style="display:none" id="tunaficha"> <td> <input type="hidden" name="group_ids[]" class="amount" value="'+elem.account_school_detail_fee_structure_id+'">  </td> </tr>' );
            
        });
    }
    else{
        if(response){

            $.each(response.items, function(indx, elem){
                total += parseFloat(elem.amount);
                console.log(count);
                table_body.append('<tr class="data"> <td class="index"></td> <td>' + (elem.name).toUpperCase() + '</td><td style="text-align: right">  <input type="hidden" name="amount[]" class="amount" value="'+ parseFloat(elem.amount).toLocaleString() +' - '+ elem.name +' ">' + (elem.amount).toLocaleString() +'</td> <td class="total">  </td> <td>  <span> <button type="button" class="btn btn-sm btn-danger btnRemoveItem"><i class="fa fa-times-circle"></i></button> </span>   </td> </tr> <tr style="display:none" id="tunaficha"> <td class="index"> <input type="hidden" name="group_ids[]" class="amount" value="'+elem.account_school_detail_fee_structure_id+'">  </td> </tr>' );
                
            });

        }
      

    } 
    calculateTotal();  

}




function calculateTotal(){

    let init_total = '';
    let amount_total = 0;
    let ind = 0;
    $("tr.data").each(function() {
         init_total =  $(this).find(".amount").val();
         amount = init_total.split('-')[0].replaceAll(',','');
         amount_total += parseFloat(amount);
       
    });

    table_footer.append('<tr><td colspan="2" style="text-align: right"> <b>TOTAL:</b> </td><td style="text-align: right"> <b>' + (amount_total).toLocaleString() +'</b></td> <td> </td> </tr>' );

}


$("#items_table").on('click', '.btnRemoveItem', function () {
    $(this).closest('tr').remove();
     table_footer.empty();
     calculateTotal(); 
});



var $j = jQuery.noConflict();
 $("#date").datepicker().datepicker("setDate", new Date());



 $('#fee_type_group').select2({width:'100%'});


$('#fee_type_group').change(function(){


$('#load_invoice_spinner').removeAttr('style');
$('#spinner').removeAttr('style');
$('#textload').text('loading......');

startInvoiceSpinner();

let group_id = $('#fee_type_group').val();
let class_id = $('#class_search').val();

 $.ajax({

    url:'{{ route('school.fee.structure.group.filter') }}',
    type:'POST',
    data:{ 
        _token: "{{ csrf_token() }}",
        group_id : group_id,
         class_id:class_id
          },
          
    success:function(response){
        console.log('ffff'+group_id);
        $('#spinner').attr('style','display:none');
        $('#textload').text('Load Invoice Items');
        $('#tunaficha').css({'display':'none'});
        stopInvoiceSpinner();
        displayItems(response,group_id);
        $('#load_invoice_spinner').attr('style','display:none');
    },  

    error:function(res ){

        if(res.status == 500){
            toastr.error('Fee Group Not Set','error');
        }
        
        $('#spinner').attr('style','display:none');
        $('#textload').text('Load Invoice Items');
        table.empty();
        table_footer.empty();
        $('#load_invoice_spinner').attr('style','display:none');

    }
})

});





 $('#class_search').change(function(e){
     e.preventDefault();
     let class_id = $(this).val();
     console.log(class_id);
     startInvoiceSpinner();

     $.ajax({
         type:'POST',
         url:'{{ route('accounts.invoices.class.students.filter') }}',
         data:{
            "_token": "{{ csrf_token() }}",
             class_id : class_id,

         },
         success: function(response){
            
             if(response.state == 'Done'){
                $('#student_search').html(response.msg); 
             }

             if(response.state == 'Fail'){
                toastr.info(response.msg, response.title);
             }

             if(response.state == 'Error'){
                toastr.error(response.msg, response.title);
             }
             stopInvoiceSpinner();
             
             
         },
         error:function(response){
             console.log(response.status == 500);
             toastr.error('Internal Server Error', 'error');
             
             stopInvoiceSpinner();

         }
     })

 });  


$('#save_bill').click(function(e){
    {{-- alert('uwii'); --}}
    e.preventDefault();
    let form_data = $('#invoice_form_store').serialize();

$.ajax({
    type: "POST",
    url: "{{  route('accounts.invoices.store')  }}",
    data:form_data,
    {{-- dataType: "JSON", --}}
    success: function (response) {
        if(response.state == 'Done'){
            window.location.replace('{{route('accounts.invoice') }}');
            
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
            toastr.error('Internal server Error', 'error');
        }
        
        
        
    }
}); 
}); 

$('#student_search').select2({
});

$('#class_search').select2({

});

$('#academic_season').select2({

});

$('#term').select2({

});


$('#student_search').change(function(){

$.ajax({

    type: 'POST',
    url : '{{ route('configurations.school.student.class') }}',

    data:{
        _token: "{{ csrf_token() }}",
        student_id : $(this).val()
    },

    success:function(response){

        console.log(response.class_id);
        $('#class_search').select2('destroy').val(response.class_id).select2().attr('selected',true);

    },
    error:function(){

        
    }


})

})



@endsection
