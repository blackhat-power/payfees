
    <div class="modal fade" id="students_registration" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" style="margin-left: 40%">Student Registration</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">×</span>
                 </button>
              </div>
              <div class="modal-body">
                 
                <div class="card-body">
                    <form id="student_registration_form" >
                        <p class="text-center"><b>Personal Information</b></p>
                        <hr style=" height: 5px;
                        background-color:#2E9AFE ;
                        border: none;">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="First Name">First Name:</label>
                                    <input type="text" name="first_name" class="form-control form-control-sm" id="first_name">
                                    <input type="hidden" name="stdnt_id" id="stdnt_id" class="form-control form-control-sm">
                                    
                                 </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Middle Name">Middle Name:</label>
                                    <input type="text" name="middle_name" class="form-control form-control-sm" id="middle_name">
                                 </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Last Name">Last Name:</label>
                                    <input type="text" name="last_name" class="form-control form-control-sm" id="last_name">
                                 </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Address">Address:</label>
                                    <input type="text" name="address" id="std_address" class="form-control form-control-sm" id="address">
                                    <input type="hidden" name="std_address_id" id="std_address_id">
                                 </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Phone">Phone:</label>
                                    <input type="text" name="phone" id="std_phone" class="form-control form-control-sm" id="phone">
                                    <input type="hidden" name="std_contact_id" id="std_contact_id" class="form-control form-control-sm" id="phone">
                                 </div>
                                 <input type="hidden" name="account_id" id="account_id">
                                 <input type="hidden" name="std_phone_id" id="std_phone_id">
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Email">Email:</label>
                                    <input type="email" name="email" id="std_email" class="form-control form-control-sm" id="email">
                                    <input type="hidden" name="std_email_id" id="std_email_id">

                                 </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Date of Birth">Date of Birth:</label>
                                    <input type="date" name="dob" id="std_dob" class="form-control form-control-sm" id="dob">
                                 </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Gender">Gender:</label>
                                    <select name="gender" id="std_gender" class="form-control form-control-sm" id="">
                                        <option value="male">male</option>
                                        <option value="female">female</option>
                                    </select>
                                 </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Class">Class:</label>
                                    <select name="students_class" id="class_select" style="width: 100%" class="class_select form-control form-control-sm">
                                        @foreach ($classes as $class )
                                        <option value="{{$class->id}}">{{$class->name}}</option>
                                        @endforeach
                                    </select>
                                 </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="streams">Stream:</label>
                                    <select name="students_stream" id="stream_select" style="width: 100%" class="class_select form-control form-control-sm">
                                        @foreach ($streams as $stream )
                                        <option value="{{$stream->id}}">{{$stream->name}}</option>
                                        @endforeach
                                    </select>
                                 </div>
                            </div>

                            <div class="col-md-4">
                                <div  class="form-group">
                                    <label for="">Admission Date</label>
                                    <input type="date" name="admitted_year" id="admitted_year" class="form-control form-control-sm">
                                </div>
                            </div>

                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Session">Year Admitted:</label>
                                    <input type="number" min="2021" max="2050"  placeholder="eg. 2021"  class=" yearpicker form-control form-control-sm">
                                 </div>
                            </div> --}}

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Category</label>
                                    <select name="student_category" id="student_category" class="form-control form-control-sm class_select">
                                        <option value="">Category 1</option>
                                        <option value="">Category 2</option>
                                    </select>
                                 </div>
                            </div>

                        </div>
                        <h5 style="text-align: center"> Parent/ Guardian Information</h5>
                        <hr style=" height: 5px;
                        background-color:#2E9AFE ;
                        border: none;"> 

                      <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Father's Name">Father's Name:</label>
                                <input type="text" name="father_name" class="form-control form-control-sm" id="fname">
                                <input type="hidden" name="father_contact_id" id="father_contact_id">
                                <input type="hidden" name="father_id" id="father_id">

                             </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Occupation">Occupation:</label>
                                <input name="father_occupation" id="father_occupation" class="form-control form-control-sm" id=""/>
                             </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Phone">Phone:</label>
                                <input type="number" name="father_phone" id="father_phone" class="form-control form-control-sm"/>
                             </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="MOther's Name">Mother's Name:</label>
                                <input type="text" name="mother_name" id="mother_name" class="form-control form-control-sm">
                                <input type="hidden" name="mother_contact_id" id="mother_contact_id">
                                <input type="hidden" name="mother_id" id="mother_id">
                             </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Occupation">Occupation:</label>
                                <input name="mother_occupation" id="mother_occupation" class="form-control form-control-sm" id=""/>
                             </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Phone">Phone:</label>
                                <input type="number" name="mother_phone" id="mother_phone" class="form-control form-control-sm"/>
                             </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Father's Name">Guardian's Name:</label>
                                <input type="text" name="guardian_name" id="guardian_name" class="form-control form-control-sm" id="fname">
                                <input type="hidden" name="guardian_contact_id" id="guardian_contact_id">
                                <input type="hidden" name="guardian_id" id="guardian_id">
                             </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Occupation">Occupation:</label>
                                <input name="guardian_occupation" id="guardian_occupation" class="form-control form-control-sm" id=""/>
                             </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Phone">Phone:</label>
                                <input type="number" name="guardian_phone" id="guardian_phone" class="form-control form-control-sm"/>
                             </div>
                        </div>
                    </div>

                    </form>
                 </div>

              </div>

              <div class="modal-footer">
                 <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary btn-sm" id="save_student" >Save changes</button>
              </div>
           </div>
        </div>
     </div>