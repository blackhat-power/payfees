

<div class="container-fluid">
    <div class="row">
       <div class="col-sm-12 col-lg-12">
          <div class="iq-card">
             <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                   <h4 class="card-title"></h4>
                </div>
             </div>
             <div class="iq-card-body">
                {{-- <form id="form-wizard1" class="text-center mt-4"> --}}
                   <ul id="top-tab-list" class="p-0">
                      <li class="active" id="account">
                         <a href="javascript:void();">
                         <span>Academic Year</span>
                         </a>
                      </li>
                      <li id="personal" class="">
                         <a href="javascript:void();">
                         <span>Fee Structure</span>
                         </a>
                      </li>
                     {{--  <li id="payment" class="">
                         <a href="javascript:void();">
                         <i class="ri-camera-fill"></i><span>Image</span>
                         </a>
                      </li>
                      <li id="confirm">
                         <a href="javascript:void();">
                         <i class="ri-check-fill"></i><span>Finish</span>
                         </a>
                      </li> --}}
                   </ul>
                   <!-- fieldsets -->
                   <fieldset style="position: relative; opacity: 1;">
                      <div class="form-card text-left">
                         <div class="row">
                            <div class="col-7">
                               <h5 class="mb-4">SEASONS:</h5>
                            </div>
                         </div>
                        <form id="seasons_and_classes_form" action="javascript:void(0)" enctype="multipart/form-data">
                         <div id="seasons_div">
                           
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="season_name">Name</label>
                                       <input type="text" class="form-control" name="season_name[]" >
                                    </div>
   
                                </div>
                                <div class="col-md-3">
                                   <div class="form-group">
                                      <label for="Start Date">Start Date</label>
                                      <input type="date" class="form-control" name="season_start_date[]" >
                                      <input type="hidden" name="school_id" id="school_id" value="{{$school_details->id}}">
                                   </div>
                               </div>
                               <div class="col-md-3">
                                   <div class="form-group">
                                      <label for="End Date">End Date</label>
                                      <input type="date" class="form-control" name="season_end_date[]" >
                                   </div>
                               </div>
                               <div class="col-md-1">
                                      <button type="button" style="color:black; margin-top:90%" class="btn btn-primary btn-sm fa fa-plus " id="add_row"> </button>
                               </div>
   
   
                            </div>
                           
                         </div>


                         <div id="semesters_div">
                           
                           <div class="row">

                               <div class="col-md-4">
                                   <div class="form-group">
                                      <label for="Semester Name">Semester/Term</label>
                                      <input type="text" class="form-control" name="semester_name[]" >
                                   </div>
  
                               </div>
                               <div class="col-md-3">
                                  <div class="form-group">
                                     <label for="Start Date">Start Date</label>
                                     <input type="date" class="form-control" name="semester_start_date[]" >
                                     <input type="hidden" name="school_id" id="school_id" value="{{$school_details->id}}">
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="form-group">
                                     <label for="End Date">End Date</label>
                                     <input type="date" class="form-control" name="semester_end_date[]" >
                                  </div>
                              </div>
                              <div class="col-md-1">
                                     <button type="button" style="color:black; margin-top:90%" class="btn btn-primary btn-sm fa fa-plus " id="semester_add_row"> </button>
                              </div>
  
  
                           </div>
                          
                        </div>
                       
                        
                         <div class="row" style="margin-top: 2%">
                            <div class="col-7">
                                <h5 class="mb-4">CLASSES:</h5>
                             </div>

                             <div id="classes_row">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group" style="margin-left: 7px">
                                           <label for="class_name">Name</label>
                                           <input type="text" name="class_name[]" class="form-control" >
                                        </div>
       
                                    </div>
                                    <div class="col-md-2">
                                       <div class="form-group">
                                          <label for="Symbol">Symbol</label>
                                          <input type="text" class="form-control" name="symbol[]" >
                                       </div>
                                   </div>
                                   <div class="col-md-3">
                                       {{-- <div class="form-group"> --}}
                                          <label for="Streams">Streams</label>
                                          
                                          {{-- <input type="text" class="form-control" name="streams[]" > --}}
                                       {{-- </div> --}}
                                   </div>

                                   <div class="col-md-2">
                                    <div class="form-group">
                                       <label for="Short Form">Short Form</label>
                                       <input type="text" class="form-control" name="short_form[]" >
                                    </div>
                                </div>
                                   
                                   <div class="col-md-1">
                                          <button type="button" style="color:black; margin-top:90%" class="btn btn-primary btn-sm fa fa-plus" id="class_add_row"> </button>
                                   </div>
       
                                </div>
    
                             </div>
                         </div>
                         
                         
                        </form>
                      </div>
                      <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next" id="save_seasons_n_classes" >Next</button>
                   </fieldset>
                   <fieldset style="opacity: 0; position: relative; display: none;">
                      <div class="form-card text-left">
                         <div class="row">
                            <div class="col-7">
                               <h5 class="mb-4"></h5>
                            </div>
                            <div class="col-5">
                               <h2 class="steps">Step 2 - 2</h2>
                            </div>
                         </div>
                         <form id="fee_payment_form">
                         <div id="fees">
                           <div id="fees_append">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label> Class </label>
                                       <select name="classes[]" id="" class="form-control">
                                          @foreach ($classes as $class )
                                          <option value="{{$class->id}}">{{$class->name}}</option>  
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label> Semester/term </label>
                                       <select name="semesters[]" id="" class="form-control" >
                                          @foreach ($semesters as $semester )
                                          <option value="{{$semester->id}}">{{$semester->name}}</option>
                                          @endforeach
                                          
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label> Fee Types *</label>
                                       <input type="text" class="form-control" name="fee_types[]" placeholder="fee">
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label>Installment.: *</label>
                                       <input type="text" class="form-control" name="installments[]" placeholder="Installment.">
                                    </div>
                                 </div>
                                 <div class="col-md-2">
                                     <div class="form-group">
                                        <label>Currency.: *</label>
                                        <select name="currency[]" class="form-control" id="">
                                           @foreach ($currencies as $currency)
                                           <option value="{{$currency->id}}">{{$currency->name}}</option>
                                           @endforeach
                                           
                                        </select>
                                       
                                     </div>
                                  </div>
                                  <div class="col-md-3">
                                     <div class="form-group">
                                        <label>Amount.: *</label>
                                        <input type="text" class="form-control" name="amounts[]" placeholder="amount.">
                                     </div>
                                  </div>
                                  <div class="col-md-1">
                                    <button type="button" style="color:black; margin-top:60%" class="btn btn-primary btn-sm fa fa-plus fee_add_row"> </button>
                             </div>
                              </div>
   
                            </div>

                            <button type="button" name="next" class="btn btn-primary float-left" id="add_new_fee_row" >Add Class</button>
                         </div>
                        </form>
                        
                      </div>

                      {{-- <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next">Next</button> --}}
                      <button type="button" name="next" class="btn btn-primary next action-button float-right" id="save_fee_payment" value="Submit">Submit</button>
                      <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous">Previous</button>
                   </fieldset>
             </div>
          </div>
       </div>
    </div>
 </div>

 @include('configuration::registration.form_duplicates')
 