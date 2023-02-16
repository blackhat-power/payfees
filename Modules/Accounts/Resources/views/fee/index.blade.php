


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


.icon {
        width: 10rem;
        height: 70px;
        text-align: center;
        margin: 1rem 1px;
        display: inline-block;
      }
      .icon i {
        font-size: 40px;
        color: #333;
        margin-top: 15px;
      }
      .icon span {
        font-size: .9rem;
        margin-top: 10px;
      }
      img {
    max-width: 30%;
}


      .container_style{

        display: flex;
        direction: horizontal;
        justify-content: space-around;
        width: 100%;
        margin-bottom:2rem;


      }

  .box {
  border: 1px solid #ccc;
  box-shadow: 0 2px 5px #ccc;
  transition: all 0.3s ease-in-out;
}

.box:hover {
  border: 2px solid #04476a;
  box-shadow: 0 4px 10px #04476a;
  transform: translateY(-2px);
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
                    <div class="container_style">
                    <div class="box">
                      <a href="{{ route('accounts.school.fee.structure.master.particulars') }}">
                      <div class="icon">
                        <img src="{{asset('assets/images/tuition.png')}}" alt="">
                      {{-- <i class="fas fa-heart"></i> --}}
                      <h6>Master Fees </h6>
                      <small>Create Master Particulars</small>
                      </div>
                      </a>
                  </div>

                  <div class="box">
                    <a href="{{ route('accounts.school.fee.structure.master.categories.index') }}">
                    <div class="icon">
                      <img src="{{asset('assets/images/fee.png')}}" alt="">
                    <h6> Create Fees </h6>
                    <small>Create Master Fees </small>
                    </div>
                  </a>
                    </div>

                  <div class="box">
                    <a href="{{ route('accounts.school.new.fee.structure') }}">
                    <div class="icon">
                      <img src="{{asset('assets/images/fees.png')}}" alt="">
                    <h6> Fee Structure </h6>
                    <small>Displays fee structure for student</small>
                  </div>
                    </a>
                  </div>
                </div>
                </div>
        </div>
    </div>
    


 @endsection


 @section('scripts')



 @endsection





































