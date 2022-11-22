@extends('layouts.app')

@section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
        <div class="navbar-breadcrumb">
            <h4 class="mb-0">Students Registration</h4>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Students</li>
                </ul>
            </nav>
        </div>
        <div class="btn-group btn-group-toggle">
            <a type="button" href="javascript:void(0)" data-toggle="modal" data-target="#students_registration"  id="register" type="button" class=" btn btn-sm btn-primary float-right" style="color: white"><i class="fa fa-plus-circle"></i> New </a>
            {{-- <a type="button" href="" id="register" data-toggle="modal" data-target="#students_registration" class="button btn btn-primary btn-sm mr-2"><i class="ri-add-line m-0"></i>Register</a> --}}
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
                    <h4 class="card-title">Manage Payment Records for {{ $students_name }} </h4>
                </div>
                    <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab-two" role="tablist">
                               <li class="nav-item">
                                  <a class="nav-link active" id="home-tab-two" data-toggle="tab" href="#incomplete-payments" role="tab" aria-controls="home" aria-selected="true">Incomplete Payments</a>
                               </li>
                               <li class="nav-item">
                                  <a class="nav-link" id="profile-tab-two" data-toggle="tab" href="#complete-payments" role="tab" aria-controls="profile" aria-selected="false">Complete Payments</a>
                               </li>
                            </ul>
                            <div class="tab-content" id="myTabContent-1">
                               <div class="tab-pane fade active show" id="incomplete-payments" role="tabpanel" aria-labelledby="home-tab-two">

                                <div class="table-responsive">
                                    <table id="individual_student_payment" class="table table-sm table-striped table-bordered" width="100%" style="table-layout: inherit">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Pay Ref</th>
                                            <th>Amount</th>
                                            <th>Paid</th>
                                            <th>Balance</th>
                                            <th>Pay Now</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" style="text-align: right">TOTAL</th>
                                                <th></th>
                                                <th></th>
                                              
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                               </div>
                               <div class="tab-pane fade" id="complete-payment" role="tabpanel" aria-labelledby="profile-tab-two">
                                 
                               {{--  <div class="table-responsive">
                                    <table id="students_datatable" class="table table-sm table-striped table-bordered" width="100%" style="table-layout: inherit">
                                        <thead>
                                        <tr>
                                            <th>avatar</th>
                                            <th>full name</th>
                                            <th>gender</th>
                                            <th>dob</th>
                                            <th>action</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div> --}}

                               </div>
                            </div>
                         </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
   

@endsection

@section('scripts')
let init_url = '{{ route('accounts.payments.individual.datatable',':id') }}'
let url = init_url.replace(':id',@php echo $id @endphp);
let individual_payments=$('#individual_student_payment').DataTable({
    processing: true,
    serverSide: true,
     ajax:url,
     columns:[
        {data:'title', name:'title'},
        {data: 'invoice_number', name:'invoice_number'},
         {data: 'billed_amount', name:'billed_amount'},
         {data:'paid_amount', name:'paid_amount'},
         {data:'balance', name:'balance'},
         {data: 'pay_now', name:'pay_now' },
         {data:'action', name:'action', orderable:false, searchable:false}
     ],
     "columnDefs": [
        { className: "font-weight-bold", "targets": [ 2 ] },
        { className: "text-blue font-weight-bold", "targets": [ 3 ] },
        { className: "text-danger font-weight-bold", "targets": [ 4 ] }
      ],


{{-- 
      "drawCallback":function(){
        $('form.ajax-pay').on('submit', function(ev){
            ev.preventDefault();
            alert('yoo');
            console.log('aii');
            submitForm($(this),'store')
            individual_payments.draw();
            var form_id = $(this).attr('id');

         })
        }, --}}

     "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // converting to interger to find total
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        // computing column Total of the complete result 
        let billAmountTotal = api
            .column( 3 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            
    var receiptAmountTotal = api
            .column( 4)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            
  {{--   var balanceTotal = api
            .column( 5)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 ); --}}
        
            
        // Update footer by showing the total with the reference of the column index 
   {{--  $( api.column( 0 ).footer() ).html('Total'); --}}
        $( api.column( 3 ).footer() ).html(billAmountTotal.toLocaleString());
        $( api.column( 4 ).footer() ).html(receiptAmountTotal.toLocaleString());
        {{-- $( api.column( 5 ).footer() ).html(balanceTotal.toLocaleString()); --}}
    },
});

@endsection