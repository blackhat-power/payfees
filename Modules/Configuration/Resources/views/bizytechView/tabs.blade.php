<ul class="nav nav-pills mb-3" role="tablist">
    <li class="nav-item">
       <a class="nav-link {{  $activeTab == 'profile' ? 'active'  : '' }}" href="{{ route('configurations.school.profile',[$school_id,$db]) }}"  role="tab" aria-controls="pills-home" aria-selected="true">Profile</a>
    </li>
    <li class="nav-item">
       <a class="nav-link  {{  $activeTab == 'students_list' ? 'active'  : '' }}"  href="{{ route('configurations.school.profile.students.list',[$school_id,$db]) }}" role="tab" aria-controls="pills-profile" aria-selected="false">List of Students</a>
    </li>
 </ul>