


@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">

            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">System Configurations</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reminder Settings</a></li>
                 {{-- <li  class="breadcrumb-item"><a href="{{route('accounts.fee_structure.settings')}}">Fee Reminder Settings</a></li> --}}
                {{-- <li class="breadcrumb-item active" aria-current="page">New</a></li> --}}
              </ol>
          </nav>


          <style>

.icon {
        width: 12rem;
        height: 70px;
        text-align: center;
        margin: 10px;
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


      .container_style{

        display: flex;
        direction: horizontal;
        justify-content: space-around;
        width: 100%;
        margin-bottom:2rem;


      }

.box {
  /* width: 300px;
  height: 200px; */
  /* margin: 50px auto; */
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
    <div style="bakground:#f4f9fa">
    <div class="card" style="100%;" >
        <div class="card-header">

        </div>

        <div class="card-body">
            <div class="container-fluid">
                <div class="container_style">
                    <div class="box">
                        <a href="">
                            <div class="icon">
                                <i class="fas fa-home"></i>
                                <h6> <a href="">Reminder Settings</a> </h6>
                               <small>Create and manage reminders for events, fee schedules and exam schedules</small> 
                              </div>
                        </a>
                       
                    </div>
                
                    <div class="box">
                        <a href="">
                  <div class="icon">
                    <i class="fas fa-envelope"></i>
                    <h6> <a href="">Create Custom Reminders</a> </h6>
                    <small>Create custom reminders for upcoming institutional events</small>
                  </div>
                </div>
            </a>
                       
        </div>
                

                <div class="container_style">
                    <div class="box">
                        <a href="">
                    <div class="icon">
                      <i class="fas fa-home"></i>
                      <h6> <a href="">View Event Reminders</a> </h6>
                      <small>View and update reminders for upcoming events, fee schedules and exam schedules</small>
                    </div>
                </a>
                       
            </div>

            <div class="box">
                <a href="">
                    <div class="icon">
                      <i class="fas fa-envelope"></i>
                      <h6> <a href="">View Custom Reminders</a> </h6>
                      <small>View and update custom reminders for upcoming institutional events</small>
                    </div>
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





































