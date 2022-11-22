<ul class="nav nav-pills mb-3 nav-fill" id="pills-tab-1" role="tablist">
    <li class="nav-item">
       <a class="nav-link {{$active == 'dashboard' ? 'active' : ''}} " href="{{ route('configurations.school.dashboard',$school_id)}}" role="tab" aria-controls="pills-home" aria-selected="true">Dashboard</a>
    </li>
    <li class="nav-item">
       <a class="nav-link {{$active == 'profile' ? 'active' : ''}}" href="{{ route('configurations.school.profile',$school_id) }}" role="tab" aria-controls="list-of-classes" aria-selected="false">Students Management</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{$active == 'academic_year' ? 'active' : ''}}" href="{{ route('configurations.school.academic_year.profile',$school_id) }}" role="tab" aria-controls="pills-academic-year" aria-selected="false">Academic Year</a>
   </li>
   <li class="nav-item">
      <a class="nav-link {{$active == 'fee_structure' ? 'active' : ''}}  " id="pills-profile-tab-fill" href="{{ route('configurations.school.fee_structure.profile',$school_id) }}" role="tab" aria-controls="pills-fee-structure" aria-selected="false">Fee Structure</a>
   </li>
    <li class="nav-item">
       <a class="nav-link" id="pills-contact-tab-fill" data-toggle="pill" href="#pills-contact-fill" role="tab" aria-controls="pills-contact" aria-selected="false">Bank Statement</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="pills-contact-tab-fill" data-toggle="pill" href="#pills-contact-fill" role="tab" aria-controls="pills-contact" aria-selected="false">Bank Reconciliation</a>
   </li>
 </ul>