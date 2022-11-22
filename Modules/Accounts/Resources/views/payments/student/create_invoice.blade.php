

@extends('layouts.app')

@section('head-page')
    @include('layouts.heading')
@endsection
@section('content-body')
<div class="container-fluid">

    <div class="row">

        <div class="col-md-12">


            <div class="card">
                <div class="card-body">
 
                    <div class="row">

                        <div class="col-md-4">

                            <h6 class="card-title">ACTION MENU</h6>


                        </div>


                        <div class="col-md-8">
                            <span class="text-center"> <h6>  Fee Structure Invoices   </h6> </span>

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for=""> Student Name </label>
                                        <input type="text" class="form-control" value="{{ strtoupper($student->full_name)    }}"  readonly>

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for=""> Academic Year </label>
                                        <input type="text"  class="form-control"  value="{{ $session  }}"  readonly>

                                    </div>

                                </div>

                            </div>
                            <div>

                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                        </div>

                        <div class="col-md-8">
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for=""> Class </label>
                                        <input type="text" class="form-control" value="{{ strtoupper($student->name)  }}"  readonly>

                                    </div>

                                </div>

                            </div>

                             <div class="">
                                <button class="btn btn-primary" id="load_invoice_item">LOAD INVOICE ITEMS</button>
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

$('#load_invoice_item').click(function(){


alert('hooray');


});










@endsection


































