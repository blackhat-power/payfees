@extends('layouts.app')

@section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
        <div class="navbar-breadcrumb">
            <h4 class="mb-0">Invoices</h4>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New Invoice</li>
                </ul>
            </nav>
        </div>
    </div>
  
</div>
@endsection


@section('content-body')


<div class="card" style="width: 100%" >
    <div class="card-header d-flex justify-content-between">
       <div class="header-title">
       </div>
    </div>
    <div class="card-body">
        <div class="container">
`    <form id="invoice_form" method="POST" action="{{ route('accounts.invoices.filter.fee_structure') }}" >
    @csrf
    <div class="row">
        <div class="col-md-1">&nbsp;</div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-6">
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
                <div class="col-md-6">
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

        </div>
        <div class="col-md-1">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-1">
        </div>  
        <div class="col-md-4">
            <div class="form-group">
                <label for="email">Academic Season <span class="text-red">*</span></label>

                <select name="academic_season" class="form-control form-control-sm" id="academic_season" required>
                @foreach($seasons as $season)
                        <option value="{{ $season->id }}"  {{ isset($acc_id) == $season->id ? 'selected' : ''  }} >{{$season->name}}</option>
                @endforeach
                    
                </select>
             </div>
        </div>
        <div class="col-md-2">
        </div>  

        <div class="col-md-4">
            <div class="form-group">
                <label for="Term"> Term <span class="text-red">*</span> </label>
                <select name="term" id="term" class="form-control form-control-sm" required>
                    <option value="">Select Term </option>
                    @foreach ($terms as $term)
                    <option value="{{$term->id}}"{{ $s_id == $term->id ? 'selected' : ''  }}>{{$term->name}}</option> 
                    @endforeach
                    
                </select>
             </div>
        </div>

            <div class="col-md-1">
            </div>

    </div>

    <div class="row justify-content-center">
        <div class="form-group align-content-center">

                <button type="buttton" id="new_invoice_btn" class="btn btn-primary mt-2 ml-2">  <i class="fa fa-paper-plane">   </i>  Submit </button>
            
        </div>
    </div>
</form>

        </div>

    </div>
 </div>
</div>
@if ($selected)
<div class="row justify-content-center top-right p-4">

    <div class="card" style="width: 80%">

        <div class="card-body">
           
    
            @include('accounts::payments.settings.loaded_fee_structure')
                  
           
    
        </div>
    
    
     </div>

</div>
@endif


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


 $('#class_search').change(function(e){
     e.preventDefault();
     let class_id = $(this).val();
     console.log(class_id);
     $.ajax({
         type:'POST',
         url:'{{ route('accounts.invoices.class.students.filter') }}',
         data:{
             class_id : class_id
         },
         success: function(response){
             $('#student_search').html(response); 
         }
     })

 });


$('#save_bill').click(function(e){
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
        
        toastr.error(response.msg, response.title);
        
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



@endsection

















@extends('layouts.app')

@section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
        <div class="navbar-breadcrumb">
            <h4 class="mb-0">Invoices</h4>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New Invoice</li>
                </ul>
            </nav>
        </div>
    </div>
  
</div>
@endsection


@section('content-body')


<section class="container-fluid">
    <div class="row">
        <div class="col-md-12">
               {{-- here --}}
              <form id="invoice_form_store" method="POST">
                    @csrf 
            <div class="table" style="border-top: 4px solid #00c0ef; background-color: #dce0e7">
              
               
            <div class="row" style="margin-top: 2%">

                <div class="col-md-12" style=""> 
                    <div class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="card" style="border-top: 4px solid #00a65a; margin-left: 2%; margin-right:2%">
                                        <div class="card-header">
                                            <span>Student Info:</span> 
                                         </div>
                                       <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email">Academic Season <span class="text-red">*</span></label>
                                            
                                                            <select name="academic_season" class="form-control form-control-sm" id="academic_season" readonly>
                                                            @foreach($seasons as $season)
                                                                    <option value="{{ $season->id }}"  {{ isset($acc_id) == $season->id ? 'selected' : ''  }} >{{$season->name}}</option>
                                                            @endforeach
                                                                
                                                            </select>
                                                         </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label style="text-align:center" for="">Class Name <span class="text-red">*</span></label>
                                                            <input type="hidden" value="{{$c_id}}" name="class_id" id="class_search">
                                                            <input type="text" class="form-control form-control-sm" value="{{$class_name}}" disabled>
                                                        {{-- <select name="class_id" id="class_search" class="form-control form-control-sm" required>
                                                            <option value=""> Select Class </option>
                                                            @foreach ($classes as $class )
                                    
                                                            <option value="{{$class->id}}" {{ $c_id == $class->id ? 'selected' : ''  }}>{{ $class->name }}</option>    
                                                            @endforeach
                                                        </select> --}}
                                                    </div>
                                                    </div>
                
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label style="" for="">Student Name  <span class="text-red">*</span>  </label>
                                                            <input type="hidden" value="{{$std_id}}" name="account_id" id="student_search">
                                                            <input type="text" class="form-control form-control-sm" value="{{strtoupper($student_name)}}" disabled>
                                                        {{-- <select name="account_id" id="student_search" class="form-control form-control-sm" required>
                                                            <option value=""> Select Student </option>
                                                            @foreach ($students as $student )
                                                            <option value="{{$student->id}}" {{ $std_id == $student->id ? 'selected' : ''  }}> {{$student->first_name}}  {{$student->middle_name}} {{$student->last_name}}</option>    
                                                            @endforeach
                                                        </select> --}}
                                                    </div>
                                                    </div>
                                                    @if ($selected)
                                                           <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-12" id="dueInvoiceList">
                                                                    <h5 style="color: #a94465">Due Invoices:</h5>
        
                                                                    <table class="table">
                                                                        @foreach ($invoices as $invoice)
        
                                                                     @if ( $invoice->invoiceItems()->sum('rate') - $invoice->receiptItems()->sum('rate')  > 0)
                                                                     <tr>
                                                                         @php
                                                                             $balance = $invoice->invoiceItems()->sum('rate') - $invoice->receiptItems()->sum('rate')
                                                                         @endphp
                                                                         <td>
                                                                            <table>
                                                                                <tr>
                                                                                    <td>{{$invoice->invoice_number}}</td>
                                                                                    <td> <span style="background-color:#e36e60; color:#fff; border-radius:12%; padding: 5px 7px; font-size:12px; min-width:10px; font-weight:700; text-align:center;">
                                                                                        <a id="pay_due" href="{{ route('accounts.students.payments.create',[$invoice->id,$balance,$std_id]) }}" target="_blank" style=" font-size:13px; font-weight:900px; color:white;"> {{ number_format($balance)}}  </a> 
                                                                                       </span>
                                                                                       <input type="hidden" name="invoice_id" id="invoice_id" value="{{$invoice->id}}">
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                         </td>
                                                                        
                                                                       
                                                                    </tr>
        
                                                                     @endif   
                                                  
                                                                        @endforeach
                                                                      
                                                                    </table>
                                                                    <ul class="nav nav-stacked">
                                                            </div>
                                                           
                                                        </div>
                                                    </div> 
                                                    
                                                    @endif
                
                                             
                                       </div>
                                    </div>
                                </div>
                                </div>
                              
                                <div class="col-md-12">
                                    <div class="row">
                                           <div class="col-md-12">
                                               <div class="card" style="border-top:4px solid #f39c12; margin-left:2%">
                                                   <div class="card-header"> Invoice Info: </div>
                                                   <div class="card-body">
                                                   <div class="row">
                                                       <div class="col-md-12">
                                                           <div class="form-group">
                                                               <label for="">Invoice Date: <span class="text-red"> *</span></label>
                                                               <input type="date" name="date" class="form-control" required>
                                                               <input type="hidden" name="stdnt_id" id="std_id" value="{{$std_id}}">
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
                                           </div>
                                       
               
                                        
                                    </div>
            
                             
            
                                </div>
                            </div>
                          

                    </div>

                    <div class="col-md-7">
                        <div class="card" style="border-top:4px solid #00a65a; margin-right:2%">
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
                                       <div class="form-group">
                                       <span> <a href="javascript:void(0)" id="load_invoice_item" style="margin-top: 9%" class="btn btn-primary"> <i id="spinner" class="fa fa-spinner fa-spin" aria-hidden="true" style="display:none"></i> <span id="textload">Load Invoice Items</span> </a>  </span>
                                     </div>
                                   </div>
                               </div>
     
                               <div id="items_div" style="display: none">
                               <div class="row">
                                 <table id="items_table" s class="table table-bordered table-responsive-md">
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

                    </div>
               
                    
                 </div>
                </form>

                        <div class="col-md-12">
                            <div class="card" style="margin-left: 1%; margin-right:1%">
                                <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <button class="btn btn-warning"> Reset </button>
                                    </div>
                                    <div class="col-md-8">
                                        <span class="float-right" style="margin-right:1%">
                                            <a href="javascript:void(0)" onclick="generateFile('pdf')" type="button" style="color:white" class="btn btn-success"><i class="fa fa-print"></i>print</a>
                                            <a href="javascript:void(0)"  style="color:white" id="save_bill" type="button" class="btn btn-primary">CREATE INVOICE</a>
                                        </span>
                                    </div>
        
                                </div>
                               </div>
                            </div>
                        </div>

            </div>
               
            </div>

        </div>
       
     </div>

  

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

 let table = $("#items_table tbody");
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
     data:{ group_id : group_id, class_id:class_id },
 
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



function displayItems(response,group_id){

    let total = 0; 
    $('#items_div').attr('style','display:block').css({'margin-left':'18%', 'margin-top':'4%'});
    table.empty();
    table_footer.empty();
    if(group_id == 1 && response.items){

        $.each(response.items, function(indx, elem){
            total += elem.amount;
            console.log(elem.name);
            table.append('<tr> <td>'+ (++indx) +'</td> <td>' + (elem.name).toUpperCase() + '</td><td style="text-align: right">  <input type="hidden" name="amount[]" value=" '+ (elem.amount).toLocaleString() +' - '+ elem.name +' ">    ' + (elem.amount).toLocaleString() +'</td> <td> Mandatory </td> </tr>' );
            
        });
    }
    else{
        if(response){

            $.each(response.items, function(indx, elem){
                total += elem.amount;
                console.log(elem.name);
                table.append('<tr> <td>'+ (++indx) +'</td> <td>' + (elem.name).toUpperCase() + '</td><td style="text-align: right">  <input type="hidden" name="amount[]" value="'+ (elem.amount).toLocaleString() +' - '+ elem.name +' ">' + (elem.amount).toLocaleString() +'</td> <td class="total">  </td> <td>  <span> <button type="button" class="btn btn-sm btn-danger btnRemoveItem"><i class="fa fa-times-circle"></i></button> </span>    </td> </tr>' );
                
            });

        }
      

    }

    
    table_footer.append('<tr><td colspan="2" style="text-align: right"> <b>TOTAL:</b> </td><td style="text-align: right"> <b>' + (total).toLocaleString() +'</b></td> <td> </td> </tr>' );


}


$("#items_table").on('click', '.btnRemoveItem', function () {
    $(this).closest('tr').remove();
    {{-- displayItems(); --}}
    let sum = 0;
    $('.total').each(function(){
       var tdTxt= $(this).prev('td').text().replaceAll(',','');
       console.log(tdTxt); 
        sum += parseFloat(tdTxt);
    });
     table_footer.empty();
     table_footer.append('<tr> <td colspan="2" style="text-align: right"> <b>TOTAL:</b> </td><td style="text-align: right"> <b>' + (sum).toLocaleString() +'</b></td> <td> </td> </tr>' );
});



 $('#fee_type_group').select2({width:'100%'});

 $('#class_search').change(function(e){
     e.preventDefault();
     let class_id = $(this).val();
     console.log(class_id);
     startInvoiceSpinner();
     $.ajax({
         type:'POST',
         url:'{{ route('accounts.invoices.class.students.filter') }}',
         data:{
             class_id : class_id
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



@endsection

