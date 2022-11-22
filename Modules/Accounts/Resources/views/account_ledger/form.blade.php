@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Finance Management</li>
                <li  class="breadcrumb-item active" aria-current="page">Account Settings</li>
                <li  class="breadcrumb-item"><a href="{{route('accounts.ledgers.index')}}">Account Ledger</a></li>
                <li class="breadcrumb-item active" aria-current="page">New Ledger</a></li>
                <li class="ml-auto"> <a id="comment" style="color: #551a8b !important" href="{{route('configurations.users.manual')}}"><i class="fa fa-comments"></i> Support</a></li>
              </ol>
          </nav>
@endsection 


@section('content-body')

<div class="card" style="width: 100%; border-top: 4px solid #00a65a;">
    <div class="card-header">Account Details</div>
    <div class="card-body">
        <form action="#" id="sub_groups_form">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Ledger Name</label>
                        <input type="text" name="ledger_name" id="name" class="form-control form-control-sm">
                    </div>  
                    <input type="hidden" name="action" value="create">
                </div>
                <div class="col-md-4">
    
                    <div class="form-group">
                        <label for="">Account Group</label>
                       <select name="sub_group_id" id="account_group_id" class="form-control form-control-sm">
                        <option> Account Group </option>  
                        @foreach ($account_sub_groups as $group)
                        <option value="{{  $group->id }}">{{ $group->name }}</option>  
                        @endforeach
                       </select>
                    </div>
                </div>

                <div class="col-md-4 account_flip"  style="display: none">
                    <div class="form-group">
                        <label for="">Account Name</label>
                        <input type="text" name="account" id="account" class="form-control form-control-sm">
                    </div>  
                </div>

                <div class="col-md-2 account_flip"  style="display: none">
                    <div class="form-group">
                        <label for="">Currency</label>
                        <select class="form-control form-control-sm" id="currency"> <option> </option>  </select>
                    </div>  
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Opening Balance</label>
                        <input type="text" name="opening_balance" id="opening_balance" class="form-control form-control-sm">
                    </div>  
                </div>

                <div class="col-md-1">
                    <div class="form-group">
                        <label for="">Dr/Cr</label>
                        <select name="transaction_type" id="transaction_type" class="form-control form-control-sm">
                            <option value=""></option>
                            <option value="Dr">Dr</option>
                            <option value="Cr">Cr</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">As Of</label>
                        <input type="text" placeholder="Date" name="date" id="date" class="form-control form-control-sm">
                    </div>  
                </div>
            </div>
        </form>
        <span class="float-right">
            <a type="button" id="register" class="btn btn-primary btn-sm">Register</a>
          </span>
        </div>
      
       
       

</div>
</div>
  

</section>


@endsection


@section('scripts')

$('#account_groups').select2({width: '100%'});

$('#transaction_type').select2({width:'100%'});


$('#register').click(function(){

let form = $('#sub_groups_form');
let form_data =  new FormData(form[0]);

$.ajax({

method: 'POST',
processData: false,
contentType: false,
url : '{{ route('accounts.ledgers.store')  }}',
data:form_data,

success: function(response){

    if(response.message == 'success'){
        window.location.replace('{{route('accounts.ledgers.index') }}');
        
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


$('#account_group_id').change(function(){

if($(this).val() == 17){

    $('.account_flip').css({'display': 'block'});
}
else{
    $('.account_flip').css({'display': 'none'});
}


});


$('#currency').select2({width:'100%'});


$('#account_group_id').select2({width:'100%'});

$('#opening_balance').keyup(function(event){
    let elem = $(this);
    let value = $(this).val();
   if (event.which >= 37 && event.which <= 40) return;
   numberWithCommas(elem);
 });
 var $j = jQuery.noConflict();
 $("#date").datepicker().datepicker("setDate", new Date());


@endsection
