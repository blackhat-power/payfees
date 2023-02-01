


@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">

            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">System Configurations</a></li>
                <li class="breadcrumb-item active" aria-current="page">Transport</a></li>
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
                    <h3>Title 1</h3>
                  </div>
                  <div class="col-sm-3">
                    <i class="fas fa-camera"></i>
                    <h3>Title 2</h3>
                  </div>
                  <div class="col-sm-3">
                    <i class="fas fa-book"></i>
                    <h3>Title 3</h3>
                  </div>

                  <div class="col-sm-3">
                    <a href="">
                        <img src="{{asset('assets/')}}" alt="">

                    </a>
                    <i class="fas fa-book"></i>
                    <h3>Title 3</h3>
                  </div>
                  
                </div>
              </div>
           
           <div class="contents">
            <div>
                <p style="margin-bottom: 0rem;"> <a href="#">Settings</a> </p>
                <small>Transport Settings</small>

            </div>
            <div>
                <p style="margin-bottom: 0rem;"> <a href="#">Stops</a> </p>
                <small>Stops Details</small>

            </div>
           </div>
           <div class="contents mg-top">
            <div>
                <p style="margin-bottom: 0rem;"> <a href="#">Vehicals</a> </p>
                <small>Vehical Details</small>

            </div>
            <div>
                <p style="margin-bottom: 0rem;"> <a href="#">Routes</a> </p>
                <small>Set Vehicle Routes</small>

            </div>
           </div>
           <div class="contents mg-top">
            <div>
                <p style="margin-bottom: 0rem;"> <a href="#">Transport Fee</a> </p>
                <small>Transport Fee Details</small>

            </div>
            <div>
                <p style="margin-bottom: 0rem;"> <a href="#">Transport Report</a> </p>
                <small>Transport Related Reports</small>

            </div>
           </div>
           <div class="contents mg-top">
            <div>
                <p style="margin-bottom: 0rem;"> <a href="#">Settings</a> </p>
                <small>Transport Settings</small>

            </div>
            <div>
                <p style="margin-bottom: 0rem;"> <a href="#">Stops</a> </p>
                <small>Stops Details</small>

            </div>
           </div>


        </div>
    </div>


 @endsection


 @section('scripts')



 @endsection





































