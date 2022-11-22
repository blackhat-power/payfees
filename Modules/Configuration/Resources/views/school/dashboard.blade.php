
@extends('layouts.app')
@section('content-breadcrumbs')
<nav aria-label="breadcrumb" style="width: 100%;">
   <ol class="breadcrumb" style="background-color: rgb(255, 249, 249)">
      <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
   </ol>
</nav>
<hr>
@endsection
@section('content-body')


<div class="container-fluid">
    <div class="row">
      @include('configuration::school.includes.school_profile')
       <div class="col-lg-9 col-md-6">
          <div class="card card-block card-stretch card-height">
             <div class="card-header">
                <div class="header-title">
                   <h4 class="card-title"></h4>
                </div>
             </div>
            
             @include('configuration::school.includes.tabs')


             <div class="container-fluid">
               <div class="row">
                  <div class="col-md-6 col-lg-3">
                     <div class="card card-block card-stretch card-height">
                        <div class="card-body bg-primary-light rounded">
                           <div class="d-flex align-items-center justify-content-between">
                              <div class="rounded iq-card-icon bg-primary"><i class="ri-user-fill"></i>
                              </div>
                              <div class="text-right">
                                 <h2 class="mb-0"><span class="counter" style="visibility: visible;">5600</span></h2>
                                 <h5 class="">Doctors</h5>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-3">
                     <div class="card card-block card-stretch card-height">
                        <div class="card-body bg-warning-light rounded">
                           <div class="d-flex align-items-center justify-content-between">
                              <div class="rounded iq-card-icon bg-warning"><i class="ri-women-fill"></i>
                              </div>
                              <div class="text-right">
                                 <h2 class="mb-0"><span class="counter" style="visibility: visible;">3450</span></h2>
                                 <h5 class="">Nurses</h5>
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
                                 <h5 class="">Patients</h5>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-3">
                     <div class="card card-block card-stretch card-height">
                        <div class="card-body bg-info-light rounded">
                           <div class="d-flex align-items-center justify-content-between">
                              <div class="rounded iq-card-icon bg-info"><i class="ri-hospital-line"></i>
                              </div>
                              <div class="text-right">
                                 <h2 class="mb-0"><span class="counter" style="visibility: visible;">4500</span></h2>
                                 <h5 class="">Pharmacists</h5>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-3">
                     <div class="card card-block card-stretch card-height bg-primary rounded">
                        <div class="card-body">
                           <div class="d-flex align-items-center justify-content-between">
                              <div class="icon iq-icon-box rounded iq-bg-primary rounded shadow" data-wow-delay="0.2s"> <i class="las la-users"></i>
                              </div>
                              <div class="iq-text">
                                 <h6 class="text-white">Customers</h6>
                                 <h3 class="text-white">75</h3>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-3">
                     <div class="card card-block card-stretch card-height bg-warning rounded">
                        <div class="card-body">
                           <div class="d-flex align-items-center justify-content-between">
                              <div class="icon iq-icon-box rounded iq-bg-warning rounded shadow" data-wow-delay="0.2s"> <i class="lab la-product-hunt"></i>
                              </div>
                              <div class="iq-text">
                                 <h6 class="text-white">Products</h6>
                                 <h3 class="text-white">60</h3>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-3">
                     <div class="card card-block card-stretch card-height bg-success rounded">
                        <div class="card-body">
                           <div class="d-flex align-items-center justify-content-between">
                              <div class="icon iq-icon-box rounded iq-bg-success rounded shadow" data-wow-delay="0.2s"> <i class="las la-user-tie"></i>
                              </div>
                              <div class="iq-text">
                                 <h6 class="text-white">User</h6>
                                 <h3 class="text-white">80</h3>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-3">
                     <div class="card card-block card-stretch card-height bg-danger rounded">
                        <div class="card-body">
                           <div class="d-flex align-items-center justify-content-between">
                              <div class="icon iq-icon-box rounded iq-bg-danger rounded shadow" data-wow-delay="0.2s"> <i class="lab la-buffer"></i>
                              </div>
                              <div class="iq-text">
                                 <h6 class="text-white">Category</h6>
                                 <h3 class="text-white">45</h3>
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
 </div>
 

 @endsection


 @section('scripts')



 @endsection
