<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button>
                        {{ __('Resend Verification Email') }}
                    </x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>



<div id="smartwizard">
    <ul class="nav">
       <li>
           <a class="nav-link" href="#step-1">
              Step 1
           </a>
       </li>
       <li>
           <a class="nav-link" href="#step-2">
              Step 2
           </a>
       </li>
    </ul>
 
    <div class="tab-content">
       <div id="step-1" class="tab-pane" role="tabpanel">
        <div class="row">
            <div class="col-md-12">&nbsp;</div>
        </div>
        <form id="school_form">

            <div style="border-left: 20%; solid green;
            height: 60%;
            position: absolute;
            left: 60%;
            margin-left: -3px;
            top: 18;">

            </div>

        <div class="row">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                           <label>School Name: <span class="text">*</span></label>
                           <input type="text" class="form-control form-control-sm" value=""  name="school_name" id="school_name" placeholder="enter school" required>
                           <input type="hidden" id="school_id" name="school_id" value="">
                           <input type="hidden" name="account_id" value="">

                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Ownership: *</label>
                           <select name="school_ownership" id="school_ownership" class="form-control form-control-sm" required>
                              <option value="GOVERNMENT" >Government</option>
                              <option value="PRIVATE">Private</option>
                           </select>
                           {{-- <input type="text" class="form-control" name="school_ownership" id="school_ownership" placeholder="enter owner"> --}}
                        </div>
                     </div>

                     <div class="col-md-6">
                      <div class="form-group">
                         <label>Registration No: *</label>
                         <input type="text" class="form-control form-control-sm" value="" name="registration_no" id="registration_no" placeholder="enter registration no." required>
                      </div>
                   </div>

                   <div class="col-md-6">
                      <div class="form-group">
                         <label>Category: *</label>
                         <select name="school_category[]" id="school_category" multiple="multiple" class="form-control form-control-sm" required >
                           <option value="">Select Category </option>
                            @foreach ($categories as $category )
                            <option value="{{ $category->id  }}">{{ $category->name }}</option>  
                            @endforeach
                         </select>
                      </div>
                   </div>

                   <div class="col-md-6">
                      <div class="form-group">
                         <label>School Address: *</label>
                         <input type="text" class="form-control form-control-sm"  value="" name="school_address" id="school_address" placeholder="enter address" required>
                         <input type="hidden" name="school_address_id" id="school_address_id" value="" >
                      </div>
                   </div>

                   <div class="col-md-6">
                      <div class="form-group">
                         <label>Phone No: *</label>
                         <input type="text" class="form-control form-control-sm" value="" name="phone_no" id="phone_no" placeholder="enter phone" required>
                         <input type="hidden" class="form-control form-control-sm" value="" name="phone_no_id" id="phone_no_id" placeholder="enter phone">

                      </div>
                   </div>


                   <div class="col-md-6">
                      <div class="form-group">
                         <label>Email Address: *</label>
                         <input type="text" class="form-control form-control-sm" value="" name="email" id="email" placeholder="enter email" required>
                         <input type="hidden" class="form-control form-control-sm" value="" name="email_id" id="email_id" placeholder="enter email">
                         
                      </div>
                   </div>

                   <div class="col-md-6">
                     <div class="form-group">
                        <label>Current Session: *</label>
                        <input type="text" id="current_session" name="current_session" class="form-control form-control-sm" placeholder="eg. 2022-2023" required>
                        <input type="hidden" name="current_session_value" value="">
                        </select>
                     </div>
                  </div>

                   <div class="col-md-6">
                      <div class="form-group">
                         <label>District: *</label>
                         <select name="district" id="district" class="form-control" required>
                            
                            <option value=""></option>
                         </select>
                      </div>
                   </div>

                   <div class="col-md-6">
                      <div class="form-group">
                         <label>Ward: *</label>
                         <select name="ward" id="ward" class="form-control" required>
                              
                            <option value=""></option>

                         </select>
                      </div>
                   </div>

                   <div class="col-md-6">
                     <div class="form-group">
                        <label>Street: *</label>
                        <input type="text" id="street" readonly name="street" class="form-control form-control-sm" required>
                        <input type="hidden" name="street_id" value="">
                        </select>
                     </div>
                  </div>


                </div>
            </div>
            
            <div style="margin-left:10%; margin-top:6%;" class="col-md-3">
               <div class="row">
                  <div class="col-md-12">
                  <div class="row" style="width: 100%; !important">
                     <div class="col-md-12">
                        <span>
                           <p class="text-center text-bold">Change Logo</p>  
                        </span>
                        <div class="row">
                           <div class="col-md-12">
                              <div class="container">
                               
                               <img id="profile-image" accept="image/*" src=""  style="width:300px; height:200px;" alt="">
                                 <fieldset style="display: none; width:100%;" class="border p-2">
                                 <legend>Preview</legend>
                                 <img id="image_preview" style="width:auto;height:300;max-width:100%;max-height:100%;" src="" alt="placeholder">
                                 <span>
                                    <p class="text-center text-bold" id="file_name">Picture name</p>
                                 </span>

                                 <span id="zoom" class="float-right"> <a href="javascript:void(0)">  <i class="fas fa-search-plus"></i></a></span>
                                 </fieldset>
                              </div>
                           </div>
                        </div>
                        
                     </div>
                  </div>
                  </div>
                  
                  <div class="row col-md-12" style="margin-top: 4%">
                     <div class="col-md-6">     
                        <div class="form-group" style="margin-left: 2vw;">
                           <button id="remove" style="display:none" class="btn btn-secondary btn-sm">X Remove</button>
                        </div>

                     </div>
                     <div class="col-md-6">
                        <div class="form-group" style="margin-left: 2vw;">
                          {{--  <input type="file" name="photo" onchange="previewFile(this)" class="custom-file-input" data-show-caption="false" data-show-upload="false" data-fouc required>
                           <span>Browse</span> --}}
                           <div class="custom-file">
                              <span>
                                 <label class=" btn btn-primary btn-sm" for="customInput"> <i class="fas fa-file-medical"></i> Browse </label>
                                 <input type="file" src="" name="logo" onchange="previewFile(this)" class="custom-file-input form-control-sm" id="customInput">
                              </span>
                          </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            
        </div>

       </div>
       <div id="step-2" class="tab-pane" role="tabpanel">

        <div class="row" style="margin-top:2%">
            <div class="col-md-7">
             <h5 style="text-align: center; margin-top:2%;">Bank Details</h5>
             <hr style=" height: 5px;
                        background-color:#2E9AFE ;
                        border: none;">
             </div> 
         </div>
        
         <div id="bank_details">
         <div class="row">
             <div class="col-md-10">
                 <div class="row">
                     <div class="col-md-1"></div>
                     <div class="col-md-5">
                         <div class="form-group">
                            <label for="Bank Name"> Bank Name</label>
                             <select name="bank_details[]" class="form-control form-control-sm banks_select2">
                                 <option value="">Select Bank</option>
                                @foreach ($banks as $bank )
                                <option value="{{ $bank->id }}">{{$bank->bank_name}}</option>
                                @endforeach
                                
                             </select>
                         </div>
                       </div>
                       <div class="col-md-5">
                         <div class="form-group">
                             <label for="Account No">Account No.</label>
                             <input type="text" class="form-control form-control-sm" value="" name="account_no[]" id="account_no">
                         </div>
                     </div>
                        <div class="col-md-1">
                           <button type="button" style="color:black; margin-top:90%" class="btn btn-primary btn-sm fa fa-plus" id="class_add_bank"> </button>
                        </div>
                 </div>

             </div>

         </div>
       </div>       
          <div class="row" style="margin-top: 2%; margin-left:10%">
           <div class="col-md-8"></div>
              <button type="submit" class="btn btn-primary btn-sm" id="save_school"><i class="fa fa-paper-plane"></i> Save Changes</button> 
          </div>
        
      </form>

        
{{-- bank duplicate --}}
 <div class="row" id="bank_duplicate" style="display: none">
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="form-group">
                       <select name="bank_details[]" id="bank_detail" class="form-control multiple_select new_select_bank">
                          <option value="">Select Bank</option>
                         @foreach ($banks as $bank )
                         <option value="{{ $bank->id }}">{{$bank->bank_name}}</option>
                         @endforeach
                      </select>
           
                </div>
              </div>

              <div class="col-md-5">
                <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="account_no[]">
                </div>
            </div>


 <div class="col-md-1">
    <button type="button" style="color:black; margin-top:5%" class="btn btn-warning btn-sm fa fa-minus remove_row"> </button>
   </div>
        </div>
    </div>
</div>
       </div>
    </div>
</div>



















<div class="tab-content">
    <div id="step-1" class="tab-pane" role="tabpanel">
        <div class="row">
            <div class="col-md-12">&nbsp;</div>
        </div>
        <form id="school_form">

            <div style="border-left: 20%; solid green;
            height: 60%;
            position: absolute;
            left: 60%;
            margin-left: -3px;
            top: 18;">

            </div>

        <div class="row">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                           <label>School Name: <span class="text">*</span></label>
                           <input type="text" class="form-control form-control-sm" value=""  name="school_name" id="school_name" placeholder="enter school" required>
                           <input type="hidden" id="school_id" name="school_id" value="">
                           <input type="hidden" name="account_id" value="">

                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Ownership: *</label>
                           <select name="school_ownership" id="school_ownership" class="form-control form-control-sm" required>
                              <option value="GOVERNMENT" >Government</option>
                              <option value="PRIVATE">Private</option>
                           </select>
                           {{-- <input type="text" class="form-control" name="school_ownership" id="school_ownership" placeholder="enter owner"> --}}
                        </div>
                     </div>

                     <div class="col-md-6">
                      <div class="form-group">
                         <label>Registration No: *</label>
                         <input type="text" class="form-control form-control-sm" value="" name="registration_no" id="registration_no" placeholder="enter registration no." required>
                      </div>
                   </div>

                   <div class="col-md-6">
                      <div class="form-group">
                         <label>Category: *</label>
                         <select name="school_category[]" id="school_category" multiple="multiple" class="form-control form-control-sm" required >
                           <option value="">Select Category </option>
                            @foreach ($categories as $category )
                            <option value="{{ $category->id  }}">{{ $category->name }}</option>  
                            @endforeach
                         </select>
                      </div>
                   </div>

                   <div class="col-md-6">
                      <div class="form-group">
                         <label>School Address: *</label>
                         <input type="text" class="form-control form-control-sm"  value="" name="school_address" id="school_address" placeholder="enter address" required>
                         <input type="hidden" name="school_address_id" id="school_address_id" value="" >
                      </div>
                   </div>

                   <div class="col-md-6">
                      <div class="form-group">
                         <label>Phone No: *</label>
                         <input type="text" class="form-control form-control-sm" value="" name="phone_no" id="phone_no" placeholder="enter phone" required>
                         <input type="hidden" class="form-control form-control-sm" value="" name="phone_no_id" id="phone_no_id" placeholder="enter phone">

                      </div>
                   </div>


                   <div class="col-md-6">
                      <div class="form-group">
                         <label>Email Address: *</label>
                         <input type="text" class="form-control form-control-sm" value="" name="email" id="email" placeholder="enter email" required>
                         <input type="hidden" class="form-control form-control-sm" value="" name="email_id" id="email_id" placeholder="enter email">
                         
                      </div>
                   </div>

                   <div class="col-md-6">
                     <div class="form-group">
                        <label>Current Session: *</label>
                        <input type="text" id="current_session" name="current_session" class="form-control form-control-sm" placeholder="eg. 2022-2023" required>
                        <input type="hidden" name="current_session_value" value="">
                        </select>
                     </div>
                  </div>

                   <div class="col-md-6">
                      <div class="form-group">
                         <label>District: *</label>
                         <select name="district" id="district" class="form-control" required>
                            
                            <option value=""></option>
                         </select>
                      </div>
                   </div>

                   <div class="col-md-6">
                      <div class="form-group">
                         <label>Ward: *</label>
                         <select name="ward" id="ward" class="form-control" required>
                              
                            <option value=""></option>

                         </select>
                      </div>
                   </div>

                   <div class="col-md-6">
                     <div class="form-group">
                        <label>Street: *</label>
                        <input type="text" id="street" readonly name="street" class="form-control form-control-sm" required>
                        <input type="hidden" name="street_id" value="">
                        </select>
                     </div>
                  </div>


                </div>
            </div>
            
            <div style="margin-left:10%; margin-top:6%;" class="col-md-3">
               <div class="row">
                  <div class="col-md-12">
                  <div class="row" style="width: 100%; !important">
                     <div class="col-md-12">
                        <span>
                           <p class="text-center text-bold">Change Logo</p>  
                        </span>
                        <div class="row">
                           <div class="col-md-12">
                              <div class="container">
                               
                               <img id="profile-image" accept="image/*" src=""  style="width:300px; height:200px;" alt="">
                                 <fieldset style="display: none; width:100%;" class="border p-2">
                                 <legend>Preview</legend>
                                 <img id="image_preview" style="width:auto;height:300;max-width:100%;max-height:100%;" src="" alt="placeholder">
                                 <span>
                                    <p class="text-center text-bold" id="file_name">Picture name</p>
                                 </span>

                                 <span id="zoom" class="float-right"> <a href="javascript:void(0)">  <i class="fas fa-search-plus"></i></a></span>
                                 </fieldset>
                              </div>
                           </div>
                        </div>
                        
                     </div>
                  </div>
                  </div>
                  
                  <div class="row col-md-12" style="margin-top: 4%">
                     <div class="col-md-6">     
                        <div class="form-group" style="margin-left: 2vw;">
                           <button id="remove" style="display:none" class="btn btn-secondary btn-sm">X Remove</button>
                        </div>

                     </div>
                     <div class="col-md-6">
                        <div class="form-group" style="margin-left: 2vw;">
                          {{--  <input type="file" name="photo" onchange="previewFile(this)" class="custom-file-input" data-show-caption="false" data-show-upload="false" data-fouc required>
                           <span>Browse</span> --}}
                           <div class="custom-file">
                              <span>
                                 <label class=" btn btn-primary btn-sm" for="customInput"> <i class="fas fa-file-medical"></i> Browse </label>
                                 <input type="file" src="" name="logo" onchange="previewFile(this)" class="custom-file-input form-control-sm" id="customInput">
                              </span>
                          </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            
        </div>

       </div>


       <div id="step-2" class="tab-pane" role="tabpanel">

        <div class="row" style="margin-top:2%">
            <div class="col-md-7">
             <h5 style="text-align: center; margin-top:2%;">Bank Details</h5>
             <hr style=" height: 5px;
                        background-color:#2E9AFE ;
                        border: none;">
             </div> 
         </div>
        
         <div id="bank_details">
         <div class="row">
             <div class="col-md-10">
                 <div class="row">
                     <div class="col-md-1"></div>
                     <div class="col-md-5">
                         <div class="form-group">
                            <label for="Bank Name"> Bank Name</label>
                             <select name="bank_details[]" class="form-control form-control-sm banks_select2">
                                 <option value="">Select Bank</option>
                                @foreach ($banks as $bank )
                                <option value="{{ $bank->id }}">{{$bank->bank_name}}</option>
                                @endforeach
                                
                             </select>
                         </div>
                       </div>
                       <div class="col-md-5">
                         <div class="form-group">
                             <label for="Account No">Account No.</label>
                             <input type="text" class="form-control form-control-sm" value="" name="account_no[]" id="account_no">
                         </div>
                     </div>
                        <div class="col-md-1">
                           <button type="button" style="color:black; margin-top:90%" class="btn btn-primary btn-sm fa fa-plus" id="class_add_bank"> </button>
                        </div>
                 </div>

             </div>

         </div>
       </div>  

       <div class="row" style="margin-top: 2%; margin-left:10%">
        <div class="col-md-8"></div>
           <button type="submit" class="btn btn-primary btn-sm" id="save_school"><i class="fa fa-paper-plane"></i> Save Changes</button> 
       </div>

            
{{-- bank duplicate --}}
<div class="row" id="bank_duplicate" style="display: none">
<div class="col-md-10">
<div class="row">
<div class="col-md-1"></div>
<div class="col-md-5">
<div class="form-group">
       <select name="bank_details[]" id="bank_detail" class="form-control multiple_select new_select_bank">
          <option value="">Select Bank</option>
         @foreach ($banks as $bank )
         <option value="{{ $bank->id }}">{{$bank->bank_name}}</option>
         @endforeach
      </select>

</div>
</div>

<div class="col-md-5">
<div class="form-group">
    <input type="text" class="form-control form-control-sm" name="account_no[]">
</div>
</div>


<div class="col-md-1">
<button type="button" style="color:black; margin-top:5%" class="btn btn-warning btn-sm fa fa-minus remove_row"> </button>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
       
            <div class="nav float-right ">
                <div class="form-group">
                    <a style="cursor: pointer;" href="#" id="prev" class="btn btn-sm btn-primary prev">Previous</a>
                <a style="cursor: pointer;" href="#" id="next" class="next btn btn-sm btn-primary">Next</a>
                </div>
            
            </div>
       
  
</div>
</div>





</div>