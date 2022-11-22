<ul class="nav nav-tabs" id="myTab-three" role="tablist">
    <li class="nav-item">
       <a class="nav-link {{ $active == 'system' ? 'active' : '' }}" href="{{ route('school.settings.edit') }}" role="tab" aria-controls="home" aria-selected="true">School</a>
    </li>
    {{-- <li class="nav-item">
       <a class="nav-link {{ $active == 'academic_year' ? 'active' : '' }}" href="{{ route('school.settings.profile') }}" role="tab" aria-controls="profile" aria-selected="false"> * <i class="fa fa-cog fa-spin"></i></a>
       <a class="nav-link {{ $active == 'academic_year' ? 'active' : '' }}" href="{{ route('school.settings.profile') }}" role="tab" aria-controls="profile" aria-selected="false"> * <i class="fa fa-cog fa-spin"></i></a>
    </li> --}}
 </ul>