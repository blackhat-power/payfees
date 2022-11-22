@extends('layouts.app')

@section('head-page')
    @include('layouts.heading')
@endsection
@section('content-body')

<div class="col-md-6 col-lg-3">
    <div class="card card-block card-stretch card-height">
       <div class="card-body bg-primary-light rounded">
          <div class="d-flex align-items-center justify-content-between">
             <div class="rounded iq-card-icon bg-primary"><i class="ri-user-fill"></i>
             </div>
             <div class="text-right">
                <h2 class="mb-0"><span class="counter" style="visibility: visible;">{{ $school_count }}</span></h2>
                <h6 class="">TOTAL SCHOOLS</h6>
             </div>
          </div>
       </div>
    </div>
 </div>


 <div class="col-md-6 col-lg-3">
    <div class="card card-block card-stretch card-height">
       <div class="card-body bg-danger-light rounded">
          <div class="d-flex align-items-center justify-content-between">
             <div class="rounded iq-card-icon bg-danger"><i class="ri-group-fill"></i>
             </div>
             <div class="text-right">
                <h2 class="mb-0"><span class="counter" style="visibility: visible;">3500</span></h2>
                <h6 class="">TOTAL CLIENTS</h6>
             </div>
          </div>
       </div>
    </div>
 </div>


@endsection
