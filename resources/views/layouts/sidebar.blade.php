      
      <div class="iq-sidebar  sidebar-default jqueryhover">
        <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
            <a href="index.html" class="header-logo">

                   @if (app('currentTenant')->name == 'Bizytech Limited')

                   <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid rounded-normal" alt="logo">
                       
                   @else

                    @php  $logo= asset('storage/'.\Modules\Configuration\Entities\AccountSchoolDetail::first()->logo); @endphp
                    @if ($logo)
                    <img src="{{ $logo }}" class="img-fluid rounded-normal" alt="logo">
                    @else
                    <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid rounded-normal" alt="logo">
                    @endif
                   @endif 
            </a>
            <div class="iq-menu-bt-sidebar">
                <i class="las la-bars wrapper-menu menu-toggle open"></i>
            </div>
        </div>
        <div class="data-scrollbar" data-scroll="1">
            <nav class="iq-sidebar-menu">
                <ul id="iq-sidebar-toggle" class="iq-menu">
                    @role('super_admin')
                     <li class="{{ $activeLink == 'super_admin_dashboard' ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class="">
                                <i style="background-color: unset !important;"   class="las la-home iq-arrow-left"></i><span>Dashboard</span>
                            </a>
                        <ul id="home" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        </ul>
                     </li>
                     @endrole
                     @role ('administration|accountant|admin')
                     
                     <li class="{{ $activeLink == 'dashboard' ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="">
                            <i style="background-color: unset !important;"   class="las la-home iq-arrow-left"></i><span>Dashboard</span>
                        </a>
                    <ul id="home" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                    </ul>
                 </li>
                     @endrole

                    @role('student')
                     <li class="{{ $activeLink == 'students_dashboard' ? 'active' : '' }}">
                        <a href="{{ route('students.dashboard') }}" class="">
                            <i style="background-color: unset !important;"   class="las la-home iq-arrow-left"></i><span>Dashboard</span>
                        </a>
                    <ul id="home" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                    </ul>
                 </li>

                 @endrole

                        @role('admin')
                     <li class="">
                        <a href="#app" class="collapsed" data-toggle="collapse" aria-expanded="false">
                            <i style="background-color: unset !important;"   class="fa fa-users iq-arrow-left"></i><span> Student Management  </span>
                            <i style="background-color: unset !important;"   class="las la-plus iq-arrow-right arrow-active"></i>
                            <i style="background-color: unset !important;"   class="las la-minus iq-arrow-right arrow-hover"></i>
                        </a>
                        <ul id="app" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
                            <li style="background-color: #d3d3d3 !important;"  class=" {{ $activeLink == 'student' ? 'active' : '' }}  ">
                                <a href="{{ route('students.registration') }}">  
                                    <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>Students Information</span>
                                </a>
                             </li> 
                                <li style="background-color: #d3d3d3 !important;"  class=" ">
                                    <a href="#students_promotion" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                        <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>Students Promotion</span>
                                        <i style="background-color: unset !important;"   class="las la-plus iq-arrow-right arrow-active"></i>
                                        <i style="background-color: unset !important;"   class="las la-minus iq-arrow-right arrow-hover"></i>
                                    </a>
                                    <ul id="students_promotion" class="iq-submenu collapse" data-parent="#app" style="">
                                            <li style="background-color: #d3d3d3 !important;"  class=" {{ $activeLink == 'promote_student' ? 'active' : '' }} ">
                                                <a href="{{ route('students.promotion') }}">
                                                    <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>Promote Students</span>
                                                </a>
                                            </li>
                                            <li style="background-color: #d3d3d3 !important;"  class="{{ $activeLink == 'manage_promotion' ? 'active' : '' }}">
                                                <a href="{{ route('students.manage.promotion') }}">
                                                    <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>Manage Promotions</span>
                                                </a>
                                            </li>

                                            <li style="background-color: #d3d3d3 !important;"  class="{{ $activeLink == 'graduate_students' ? 'active' : '' }}">
                                                <a href="{{ route('students.graduate.index') }}">
                                                    <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>Graduate Students</span>
                                                </a>

                                            </li>
                                          
                                    </ul>
                                </li>
                                <li style="background-color: #d3d3d3 !important;"  class=" {{ $activeLink == 'graduated' ? 'active' : '' }}">
                                    <a href="{{ route('students.graduates') }}">  
                                        <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>Students Graduated</span>
                                    </a>
                                 </li> 
                        </ul>
                     </li>
                     @endrole


                     @role('accountant|admin')
                     <li class="">
                        <a href="#bills_n_payments" class="collapsed" data-toggle="collapse" aria-expanded="false">
                            <i style="background-color: unset !important;"   class="las la-file-invoice iq-arrow-left"></i><span> Finance Management </span>
                            <i style="background-color: unset !important;"   class="las la-plus iq-arrow-right arrow-active"></i>
                            <i style="background-color: unset !important;"   class="las la-minus iq-arrow-right arrow-hover"></i>
                        </a>
                        <ul id="bills_n_payments" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
                                <li style="background-color: #d3d3d3 !important;"  class=" {{ $activeLink == 'bills' ? 'active' : '' }} ">
                                        <a href="{{ route('accounts.invoice') }}">
                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>Bills</span>
                                        </a>
                                </li>
                                <li style="background-color: #d3d3d3 !important;"  class="{{ $activeLink == 'payment_review' ? 'active' : '' }} ">
                                        <a href="{{ route('accounts.student.payments.review.index') }}">
                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Payments Review </span>
                                        </a>
                                </li>

                                {{-- CURRENTLY WORKING ON --}}
                                

                        
            
                                        <li class="" style="background-color: #d3d3d3 !important;">
                                            <a href="#academic" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                                <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>Reports</span>
                                                <i style="background-color: unset !important;"   class="las la-plus iq-arrow-right arrow-active"></i>
                                                <i style="background-color: unset !important;"   class="las la-minus iq-arrow-right arrow-hover"></i>
                                            </a>
                                            <ul id="academic" class="iq-submenu collapse" data-parent="#configuration" style="">
            
                                                    <li style="background-color: #d3d3d3 !important;" class=" {{ $activeLink == 'collection' ? 'active' : '' }} ">
                                                        <a href="{{ route('accounts.collection.index') }}">
                                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span> Collections </span>
                                                        </a>
                                                    </li>
            
                                                    <li style="background-color: #d3d3d3 !important;" class=" {{ $activeLink == 'classes' ? 'active' : '' }}">
                                                            <a href="#">
                                                                <i style="background-color: unset !important; font-size:8px" class="fa fa-circle"></i><span>Expenditure</span>
                                                            </a>
                                                    </li>
            
                                                    <li style="background-color: #d3d3d3 !important; display:none" class=" {{ $activeLink == 'streams' ? 'active' : '' }} " style="display: none">
                                                        <a href="#">
                                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Revenues </span>
                                                        </a>
                                                </li>

                                                <li style="background-color: #d3d3d3 !important;"  class="{{ $activeLink == 'debtors_list' ? 'active' : '' }} ">
                                                    <a href="{{ route('accounts.debtors.list') }}">
                                                        <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Debtors List </span>
                                                    </a>
                                                </li>
            
                                            </ul>
                                        </li>                          

             
                                        <li class="" style="background-color: #d3d3d3 !important;">
                                            <a href="#account_setting" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                                <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>Account Setting</span>
                                                <i style="background-color: unset !important;"   class="las la-plus iq-arrow-right arrow-active"></i>
                                                <i style="background-color: unset !important;"   class="las la-minus iq-arrow-right arrow-hover"></i>
                                            </a>
                                            <ul id="account_setting" class="iq-submenu collapse" data-parent="#configuration" style="">
                                                    <li style="background-color: #d3d3d3 !important; display:none" class=" {{ $activeLink == 'account_group' ? 'active' : '' }} " style="display: none">
                                                        <a href="{{ route('accounts.sub.groups.index')  }}">
                                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Account Sub Groups </span>
                                                        </a>
                                                </li>


                                                <li style="background-color: #d3d3d3 !important;" class=" {{ $activeLink == 'account_ledger' ? 'active' : '' }} " style="display: none">
                                                    <a href="{{ route('accounts.ledgers.index') }}">
                                                        <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Ledgers </span>
                                                    </a>
                                            </li>
                                            <li style="background-color: #d3d3d3 !important; display:none" class=" {{ $activeLink == 'charts_of_accounts' ? 'active' : '' }} " style="display: none">
                                                <a href="{{ route('charts.of.accounts') }}">
                                                    <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Charts of A/C </span>
                                                </a>
                                        </li>

                                            <li style="background-color: #d3d3d3 !important;"  class="{{ $activeLink == 'account_fee_settings' ? 'active' : '' }} ">
                                                <a href="{{ route('accounts.fee_structure.settings') }}">
                                                    <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Fee Structure Settings </span>
                                                </a>
                                            </li> 
                                            <li style="background-color: #d3d3d3 !important;"  class="{{ $activeLink == 'fee_reminder_settings' ? 'active' : '' }} ">
                                                <a href="{{ route('accounts.fee_reminder.settings') }}">
                                                    <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Fee Reminder Settings </span>
                                                </a>
                                            </li> 
            
                                            </ul>
                                        </li>                          

                                
                                        <li class="" style="background-color: #d3d3d3 !important;">
                                            <a href="#transaction" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                                <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>Transactions</span>
                                                <i style="background-color: unset !important;"   class="las la-plus iq-arrow-right arrow-active"></i>
                                                <i style="background-color: unset !important;"   class="las la-minus iq-arrow-right arrow-hover"></i>
                                            </a>
                                            <ul id="transaction" class="iq-submenu collapse" data-parent="#configuration" style="">



                                            <li style="background-color: #d3d3d3 !important;"  class="{{ $activeLink == 'journal_voucher' ? 'active' : '' }} ">
                                                <a href="{{ route('accounts.journal.voucher.index') }}">
                                                    <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Journal Voucher </span>
                                                </a>
                                            </li> 

                                            <li style="background-color: #d3d3d3 !important;"  class="{{ $activeLink == 'payment_voucher' ? 'active' : '' }} ">
                                                <a href="{{ route('accounts.payment.voucher.index') }}">
                                                    <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Payment Voucher </span>
                                                </a>
                                            </li> 

                                                    <li style="background-color: #d3d3d3 !important;" class=" {{ $activeLink == 'contra_voucher' ? 'active' : '' }} " style="display: none">
                                                        <a href="{{ route('accounts.contra.voucher.index')  }}">
                                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Contra Voucher </span>
                                                        </a>
                                                </li>


                                                <li style="background-color: #d3d3d3 !important;" class=" {{ $activeLink == 'receipt_voucher' ? 'active' : '' }} " style="display: none">
                                                    <a href="{{ route('accounts.receipts.voucher.index') }}">
                                                        <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Receipt Voucher </span>
                                                    </a>
                                            </li>

               

                                           
                                            </ul>
                                        </li>                          
    

                               
                        </ul>
                     </li>
                     
                     @endrole

                     @role('student')
                     @if (Modules\Registration\Entities\AccountStudentDetail::find(auth()->user()->student_id))
                         
                     <li class="">
                        <a href="#individual_invoice_and_payments" class="collapsed" data-toggle="collapse" aria-expanded="false">
                            <i style="background-color: unset !important;"   class="las la-file-invoice iq-arrow-left"></i><span> Fees </span>
                            <i style="background-color: unset !important;"   class="las la-plus iq-arrow-right arrow-active"></i>
                            <i style="background-color: unset !important;"   class="las la-minus iq-arrow-right arrow-hover"></i>
                        </a>
                        <ul id="individual_invoice_and_payments" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
                                <li  style="background-color: #d3d3d3 !important;"  class=" {{ $activeLink == 'individual_invoice_create' ? 'active' : '' }} ">
                                    @php
                                        
                                    $student = Modules\Registration\Entities\AccountStudentDetail::find(auth()->user()->student_id);
                                    $class_id = $student->account_school_details_class_id;
                                    $acc_id = $student->account_id;
                                    $std_id = $student->id;
                                    $season_id = Modules\Configuration\Entities\AccountSchoolDetailSeason::where('status','active')->first()->id;

                                    @endphp
                                        <a href="{{ route('accounts.invoices.create',[$class_id,$acc_id,$std_id,$season_id]) }}">
                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>Create Invoice</span>
                                        </a>
                                </li>
                                <li  style="background-color: #d3d3d3 !important;"   class="{{ $activeLink == 'individual_invoice' ? 'active' : '' }} ">
                                        <a href="{{ route('accounts.invoices.individual.view', auth()->user()->id) }}">
                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Invoice List </span>
                                        </a>
                                </li>
                        </ul>    
                     </li>

                     @endif
                     @endrole

                     @role('super_admin')
                     <li class="" {{-- style="display: none" --}}>
                        <a href="#schools" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i style="background-color: unset !important;"   class="las la-solid la-school iq-arrow-left"></i><span>Schools</span>
                            <i style="background-color: unset !important;"   class="las la-plus iq-arrow-right arrow-active"></i>
                            <i style="background-color: unset !important;"   class="las la-minus iq-arrow-right arrow-hover"></i>
                        </a>
                        <ul id="schools" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
                                <li  style="background-color: #d3d3d3 !important;"  class=" {{ $activeLink == 'schools' ? 'active' : '' }}  ">
                                        <a href="{{ route('configurations.index') }}" class="toggleDisplay" >
                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle" aria-hidden="true"></i><span>Registered Schools</span>
                                        </a>
                                </li>
                             {{--    <li class=" ">
                                        <a href="../backend/layout-2.html">
                                            <i style="background-color: unset !important;"   class="las la-percent"></i><span> Registration </span>
                                        </a>
                                </li> --}}
                        </ul>
                     </li>


                     <li class="" {{-- style="display: none" --}}>
                        <a href="#banks" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i style="background-color: unset !important;"   class="las la-city iq-arrow-left"></i> <span>Banks</span>
                            <i style="background-color: unset !important;"   class="las la-plus iq-arrow-right arrow-active"></i>
                            <i style="background-color: unset !important;"   class="las la-minus iq-arrow-right arrow-hover"></i>
                        </a>
                        <ul id="banks" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
                                <li  style="background-color: #d3d3d3 !important;"  class="{{ $activeLink == 'banks' ? 'active' : '' }} ">
                                        <a href="{{route('configurations.banks')}}">
                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>Registered Banks</span>
                                        </a>
                                </li>
                             {{--    <li class=" ">
                                        <a href="../backend/layout-2.html">
                                            <i style="background-color: unset !important;"   class="las la-percent"></i><span> Registration </span>
                                        </a>
                                </li> --}}
                        </ul>
                     </li>


                     <li class="" {{-- style="display: none" --}}>
                        <a href="#location" class="collapsed" data-toggle="collapse" aria-expanded="false">
                            <i style="background-color: unset !important;"   class="las la-map-marker iq-arrow-left"></i><span>Location</span>
                            <i style="background-color: unset !important;"   class="las la-plus iq-arrow-right arrow-active"></i>
                            <i style="background-color: unset !important;"   class="las la-minus iq-arrow-right arrow-hover"></i>
                        </a>
                        <ul id="location" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
                                <li style="background-color: #d3d3d3 !important;"  class=" {{ $activeLink == 'zones' ? 'active' : '' }} ">
                                        <a href="{{ route('location.zones') }}">
                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>Zones</span>
                                        </a>
                                </li>
                                <li style="background-color: #d3d3d3 !important;"  class=" {{ $activeLink == 'regions' ? 'active' : '' }} ">
                                    <a href="{{ route('location.regions') }}">
                                        <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>Region</span>
                                    </a>
                            </li>
                                <li  style="background-color: #d3d3d3 !important;"  class=" {{ $activeLink == 'districts' ? 'active' : '' }} ">
                                        <a href="{{ route('location.districts') }}">
                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> District </span>
                                        </a>
                                </li>
                                <li  style="background-color: #d3d3d3 !important;"  class=" {{ $activeLink == 'wards' ? 'active' : '' }} ">
                                        <a href="{{ route('location.wards') }}">
                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span> Ward </span>
                                        </a>
                                </li>
                        </ul>
                     </li>
                     @endrole

                     
                    @role('admin')
                     <li class="">
                        <a href="#configuration" class="collapsed" data-toggle="collapse" aria-expanded="false">
                            <i style="background-color: unset !important;"   class="fas fa-cog iq-arrow-left"></i><span>System Configurations</span>
                            <i style="background-color: unset !important;"   class="las la-plus iq-arrow-right arrow-active"></i>
                            <i style="background-color: unset !important;"   class="las la-minus iq-arrow-right arrow-hover"></i>
                        </a>
                        <ul id="configuration" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">

                            <li class="" style="background-color: #d3d3d3 !important;">
                                <a href="#academic" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                    <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>Academic</span>
                                    <i style="background-color: unset !important;"   class="las la-plus iq-arrow-right arrow-active"></i>
                                    <i style="background-color: unset !important;"   class="las la-minus iq-arrow-right arrow-hover"></i>
                                </a>
                                <ul id="academic" class="iq-submenu collapse" data-parent="#configuration" style="">

                                        <li style="background-color: #d3d3d3 !important;" class=" {{ $activeLink == 'academic_year' ? 'active' : '' }} ">
                                            <a href="{{ route('configurations.school.academic.year.index') }}">
                                                <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span> Academic Year </span>
                                            </a>
                                        </li>

                                        <li style="background-color: #d3d3d3 !important;" class=" {{ $activeLink == 'classes' ? 'active' : '' }}">
                                                <a href=" {{ route('configurations.school.classes') }}">
                                                    <i style="background-color: unset !important; font-size:8px" class="fa fa-circle"></i><span>Classes & streams</span>
                                                </a>
                                        </li>

                                        <li style="background-color: #d3d3d3 !important;" class=" {{ $activeLink == 'streams' ? 'active' : '' }} " style="display: none">
                                            <a href="{{ route('configurations.school.streams') }}">
                                                <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Streams </span>
                                            </a>
                                    </li>

                                </ul>
                            </li>  


                            <li class="" style="background-color: #d3d3d3 !important;">
                                <a href="#sms" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                    <i style="background-color: unset !important;font-size:8px" class="fa fa-envelope"></i><span>Messages / SMS</span>
                                    <i style="background-color: unset !important;"   class="las la-plus iq-arrow-right arrow-active"></i>
                                    <i style="background-color: unset !important;"   class="las la-minus iq-arrow-right arrow-hover"></i>
                                </a>
                                <ul id="sms" class="iq-submenu collapse" data-parent="#sms" style="">

                                        <li style="background-color: #d3d3d3 !important;" class=" {{ $activeLink == 'sms_settings' ? 'active' : '' }} ">
                                            <a href="#">
                                                <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span> SMS Settings </span>
                                            </a>
                                        </li>

                                        <li style="background-color: #d3d3d3 !important;" class=" {{ $activeLink == 'classes' ? 'active' : '' }}">
                                                <a href="#">
                                                    <i style="background-color: unset !important; font-size:8px" class="fa fa-circle"></i><span> Bulk SMS </span>
                                                </a>
                                        </li>

                                        <li style="background-color: #d3d3d3 !important;" class=" {{ $activeLink == 'streams' ? 'active' : '' }} " style="display: none">
                                            <a href="#">
                                                <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Bulk SMS Report </span>
                                            </a>
                                    </li>

                                </ul>
                            </li>  

                                <li  style="background-color: #d3d3d3 !important;" class=" {{ $activeLink == 'configurations' ? 'active' : '' }}">
                                        <a href=" {{ route('school.settings.edit') }}">
                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>School Profile</span>
                                        </a>
                                </li>
                                  
                        </ul>
                     </li>


                     <li class="" style="background-color: #d3d3d3 !important;">
                        <a href="#communication" class="collapsed" data-toggle="collapse" aria-expanded="false">
                            <i style="background-color: unset !important;font-size:10px" class="fa fa-desktop iq-arrow-left"></i><span>Communication</span>
                            <i style="background-color: unset !important;"   class="las la-plus iq-arrow-right arrow-active"></i>
                            <i style="background-color: unset !important;"   class="las la-minus iq-arrow-right arrow-hover"></i>
                        </a>
                        <ul id="communication" class="iq-submenu collapse" data-parent="#communication" style="">

                                <li style="background-color: #d3d3d3 !important;" class=" {{ $activeLink == 'send_message' ? 'active' : '' }} ">
                                    <a href="#">
                                        <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span> Send Message </span>
                                    </a>
                                </li>

                                <li style="background-color: #d3d3d3 !important;" class=" {{ $activeLink == 'send_login_details' ? 'active' : '' }}">
                                        <a href="#">
                                            <i style="background-color: unset !important; font-size:8px" class="fa fa-circle"></i><span> Message Report </span>
                                        </a>
                                </li>

                                <li style="background-color: #d3d3d3 !important;" class=" {{ $activeLink == 'streams' ? 'active' : '' }} " style="display: none">
                                    <a href="#">
                                        <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Bulk SMS Report </span>
                                    </a>
                            </li>

                        </ul>
                    </li>  

                    @endrole



                     @role(' super_admin|admin ')
                     <li class=" {{ $activeLink == 'users' ? 'active' : '' }} ">
                        <a href="{{ route('configuration.users.index') }}">  
                            <i style="background-color: unset !important;"   class="las la-user iq-arrow-left"></i><span>User Management</span>
                        </a>
                     </li> 

                     @endrole

                     @role('student')
                     @if (Modules\Registration\Entities\AccountStudentDetail::find(auth()->user()->student_id))
                     <li class=" {{ $activeLink == 'profile_detail' ? 'active' : '' }} ">
                        <a href=" {{ route('students.profile',$std_id) }}">  
                            <i style="background-color: unset !important;"   class="las la-user iq-arrow-left"></i><span>My Profile</span>
                        </a>
                         
                     </li> 

                     <li class=" {{ $activeLink == 'my_account' ? 'active' : '' }} ">
                        <a href=" {{ route('configuration.users.myaccount.password.reset.index') }}">  
                            <i style="background-color: unset !important;"   class="las la-user iq-arrow-left"></i><span>Change Password</span>
                        </a>
                     </li> 
                     @endif
                     @endrole
                        @role('admin')


                        <li class="" style="display: none">
                            <a href="#student_reports" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <i style="background-color: unset !important;"   class="las la-file-invoice iq-arrow-left"></i><span> Reports </span>
                                <i style="background-color: unset !important;"   class="las la-plus iq-arrow-right arrow-active"></i>
                                <i style="background-color: unset !important;"   class="las la-minus iq-arrow-right arrow-hover"></i>
                            </a>
                            <ul id="student_reports" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
                                    <li  style="background-color: #d3d3d3 !important;" class=" {{ $activeLink == 'bills' ? 'active' : '' }} ">
                                            <a href="{{ route('accounts.invoice') }}">
                                                <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i><span>Student Details</span>
                                            </a>
                                    </li>                                
    
                                    <li style="background-color: #d3d3d3 !important;"  class="{{ $activeLink == 'debtors_list' ? 'active' : '' }} ">
                                        <a href="{{ route('accounts.debtors.list') }}">
                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Fee Paid Reports </span>
                                        </a>
                                    </li>
    
                                    <li style="background-color: #d3d3d3 !important;"  class="{{ $activeLink == 'account_fee_settings' ? 'active' : '' }} ">
                                        <a href="{{ route('accounts.fee_structure.settings') }}">
                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Fee Due Reports </span>
                                        </a>
                                    </li> 
    
                                    <li style="background-color: #d3d3d3 !important;"  class="{{ $activeLink == 'account_fee_settings' ? 'active' : '' }} ">
                                        <a href="{{ route('accounts.fee_structure.settings') }}">
                                            <i style="background-color: unset !important;font-size:8px" class="fa fa-circle"></i> <span> Admission Reports </span>
                                        </a>
                                    </li> 
                            </ul>
                         </li>


                        @endrole

                     @role('admin|accountant|super_admin')

                     <li class=" {{ $activeLink == 'my_account' ? 'active' : '' }} ">
                        <a href=" {{ route('configuration.users.myaccount') }}">  
                            <i style="background-color: unset !important;"   class="las la-user iq-arrow-left"></i><span>My Account</span>
                        </a>
                        
                        
                     </li> 

                     @endrole

                   

                </ul>
            </nav>
            <div class="p-3"></div>
        </div>
        </div> 

        
        

