


@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">

            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">System Configurations</a></li>
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
            .mg-top{
                margin-top: 1.4rem;
            } 

          </style>

@endsection


@section('content-body')
        </div>
    </div>
    <div class="card" style="100%">
        <div class="card-header">

        </div>

        <div class="card-body">

            <div class="container">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="fas fa-heart"></i>
                    <h3> <a href="{{ route('accounts.school.fee.structure.master.particulars') }}">Master Fees</a> </h3>
                    <small>Create Master Particulars</small>
                  </div>
                  <div class="col-sm-3">
                    <i class="fas fa-camera"></i>
                    <h3> <a href="{{ route('accounts.school.fee.structure.master.categories.index') }}">Create Fees</a> </h3>
                    <small>Create Master Fees </small>
                  </div>
                  <div class="col-sm-3">
                    <i class="fas fa-book"></i>
                    <h3> <a href="{{ route('accounts.school.new.fee.structure') }}">Fee Structure</a> </h3>
                    <small>Displays fee structure for student</small>
                  </div>
                  
                </div>
              </div>


 @endsection


 @section('scripts')



 @endsection





































