<ul class="nav nav-tabs" id="myTab-two" role="tablist">
    <li class="nav-item">
       <a class="nav-link  {{  $activeTab == 'profile' ? 'active' : '' }}"    id="profile-tab-two" href="{{ route('configuration.users.myaccount') }}" role="tab" aria-controls="profile" aria-selected="false">Manage Profile</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{  $activeTab == 'password_reset' ? 'active' : '' }}" id="home-tab-two" href="{{ route('configuration.users.myaccount.password.reset.index') }}" role="tab" aria-controls="home" aria-selected="true">Change Password </a>
     </li>

 </ul>