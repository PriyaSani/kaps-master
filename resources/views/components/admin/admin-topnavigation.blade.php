<div>
	<header id="page-topbar">
	    <div class="navbar-header">
	        <div class="d-flex">
	            <!-- LOGO -->
	            <div class="navbar-brand-box navigation_color">
	                <a href="{{route('dashboard')}}" class="logo logo-dark">
	                    <span class="logo-sm">
	                        <img src="{{ asset('images/logo1.png') }}" alt="" height="22">
	                    </span>
	                    <span class="logo-lg">
	                        <img src="{{ asset('images/logo1.png') }}" alt="" height="17">
	                    </span>
	                </a>

	                <a href="{{route('dashboard')}}" class="logo logo-light">
	                    <span class="logo-sm">
	                        <!-- <img src="{{ asset('images/logo-light.svg') }}" alt="" height="22"> -->
	                        <img src="{{ asset('images/favicon.png') }}" alt="" height="22" style="width: 172%;height:41px;">
	                    </span>
	                    <span class="logo-lg">
	                        <!-- <img src="{{ asset('images/logo-light.png') }}" alt="" height="19"> logo.png-->
	                        <img src="{{ asset('images/logo1.png') }}" alt="" height="26" style="width: 42%;height:60px;">
	                    </span>
	                </a>
	            </div>

	            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
	                <i class="fa fa-fw fa-bars"></i>
	            </button>

	        </div>

	        <div class="d-flex">

	            <div class="dropdown d-inline-block d-lg-none ml-2">
	                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
	                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                    <i class="mdi mdi-magnify"></i>
	                </button>
	                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
	                    aria-labelledby="page-header-search-dropdown">
	        
	                    <form class="p-3">
	                        <div class="form-group m-0">
	                            <div class="input-group">
	                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
	                                <div class="input-group-append">
	                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
	                                </div>
	                            </div>
	                        </div>
	                    </form>
	                </div>
	            </div>

	            <div class="dropdown d-inline-block">
	                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                    @if(Auth::guard()->user()->id == 1)

	                    	<img class="rounded-circle header-profile-user" src="{{ asset('images/users/avatar-1.jpg') }}"
							alt="Header Avatar"><!-- images/users/avatar-1.jpg -->
						@else
							@if(Auth::guard()->user()->profile_image != '')
								<img class="rounded-circle header-profile-user" src="{{ asset('uploads/employee') }}/{{Auth::guard()->user()->profile_image}}"
								alt="Header Avatar"><!-- images/users/avatar-1.jpg -->
							@else
								
								<img class="rounded-circle header-profile-user" src="{{ asset('images/users/avatar-1.jpg') }}"
								alt="Header Avatar"><!-- images/users/avatar-1.jpg -->
							@endif
						@endif
	                    <span class="d-none d-xl-inline-block ml-1">{{ Auth::guard()->user()->name }}</span>
	                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
	                </button>
	                <div class="dropdown-menu dropdown-menu-right">
	                    <!-- item-->
	                    <a class="dropdown-item" href="{{ route('admin.changePassoword') }}"><i class="bx bx-lock-open font-size-16 align-middle mr-1"></i> Change Password</a>
	                    
	                    <div class="dropdown-divider"></div>
	                    <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</header> 
</div>