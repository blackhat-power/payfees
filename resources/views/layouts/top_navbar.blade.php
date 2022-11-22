<div class="iq-top-navbar" style="background-color:#ffffff ">
    <div class="iq-navbar-custom">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
        <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
            <i class="ri-menu-line wrapper-menu"></i>
        </div>

        
        <div class="d-flex justify-content-center iq-search-bar device-search" style="color: white !important">
        @role('student|admin')
        
         @php
         
            $query_year = Modules\Configuration\Entities\AccountSchoolDetail::first()->current_session;
            if($query_year){
                $school_year = $query_year;
            }else {
                $school_year = 'NOT SET';
            }

        @endphp

<a style="color:white" @role('student') href="javascript:void(0)" @endrole @role('admin') href="{{ route('configurations.school.academic.year.index') }}" @endrole>
    <p class="bounce" style="padding: 0.15rem; background-color: #00bcd4; border-color:#00bcd4; border: 1px solid transparent; letter-spacing: .1px; border-radius: 4px;">
        <span> <i style="color:white" class="fa fa-arrow-alt-circle-down"></i> </span>
        <span style="color:#fff; font-size:0.8em;">
            ACTIVE ACADEMIC YEAR: {{ $school_year }}
    </span>
</p>
</a>
 
        @endrole

        </div>

            <div class="d-flex align-items-center">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"  aria-label="Toggle navigation">
                <i class="ri-menu-3-line"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-list align-items-center">
                    <li class="nav-item nav-icon search-content">
                        <a href="#" class="search-toggle rounded" id="dropdownSearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-search-line"></i>
                        </a>
                        <div class="iq-search-bar iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownSearch">
                            <form action="#" class="searchbox p-2">
                                <div class="form-group mb-0 position-relative">
                                <input type="text" class="text search-input font-size-12" placeholder="type here to search...">
                                <a href="#" class="search-link"><i class="las la-search"></i></a> 
                                </div>
                            </form>
                        </div>
                        <div>
                            
                          </div>
                    </li> 
                    
                    

{{-- starts here --}}

<div class="collapse navbar-collapse" id="navbarSupportedContent">


    <li class="nav-item iq-full-screen"><a href="#" class="" id="btnFullscreen"><i class="ri-fullscreen-line"></i></a></li>
                    @php  $url= asset('storage/user_passports/'.auth()->user()->passport); @endphp
                    <li class="caption-content">
                        <a href="javascript:void(0)" class="iq-user-toggle">
                            <img src="{{ $url }}" class="img-fluid rounded" alt="user">
                        </a>
                        <div class="iq-user-dropdown">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center mb-0">
                                <div class="header-title">
                                    <h4 class="card-title mb-0">Profile</h4>
                                </div>
                                <div class="close-data text-right badge badge-primary cursor-pointer"><i class="ri-close-fill"></i></div>
                                </div>
                                <div class="data-scrollbar" data-scroll="2">
                                <div class="card-body">
                                    <div class="profile-header">
                                        <div class="cover-container text-center">
                                           
                                            <img src="{{ $url }}" alt="profile-bg" class="rounded img-fluid avatar-80">
                                            <div class="profile-detail mt-3">
                                                 <h3>{{ auth()->user()->name  }}</h3> 
                                                <p class="mb-1"> </p>
                                            </div>

                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <x-dropdown-link :href="route('logout')"
                                                                 onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                                    {{ __('Logout') }}
                                                </x-dropdown-link>
                                            </form>
                                        </div>
                                      
                                    </div>
                                    <div class="p-3">
                                        
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    </ul>                     
                </div> 
            </div>
        </nav>
    </div>
</div>

