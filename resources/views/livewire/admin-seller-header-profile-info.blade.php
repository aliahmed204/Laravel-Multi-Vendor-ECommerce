<div>
    {{-- The whole world belongs to you. --}}

    @if(Auth::guard('admin')->check())
        <div class="user-info-dropdown">
            <div class="dropdown">
                <a
                    class="dropdown-toggle"
                    href="#"
                    role="button"
                    data-toggle="dropdown"
                >
							<span class="user-icon">
								<img src="{{$admin->getFirstMediaUrl('avatars')}}" alt="" />
							</span>
                    <span class="user-name">{{$admin->username}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                    <a class="dropdown-item" href="{{route('admin.profile')}}">
                        <i class="dw dw-user1"></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="profile.html">
                        <i class="dw dw-settings2"></i>
                        Setting
                    </a>

                    <a class="dropdown-item"
                       href="{{route('admin.logout')}}"
                       onclick="event.preventDefault(); document.getElementById('adminLogoutForm').submit();"
                    ><i class="dw dw-logout"></i> Log Out</a>
                    <form method="post" action="{{route('admin.logout')}}" id="adminLogoutForm">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    @elseif(Auth::guard('seller')->check())
        <div class="user-info-dropdown">
            <div class="dropdown">
                <a
                    class="dropdown-toggle"
                    href="#"
                    role="button"
                    data-toggle="dropdown"
                >
							<span class="user-icon">
								<img src="{{$seller ->getFirstMediaUrl('avatars')}}" alt="avatar" />
							</span>
                    <span class="user-name">{{$seller->username}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                    <a class="dropdown-item" href="{{route('seller.profile')}}">
                        <i class="dw dw-user1"></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="profile.html">
                        <i class="dw dw-settings2"></i>
                        Setting
                    </a>

                    <a class="dropdown-item"
                       href="{{route('seller.logout')}}"
                       onclick="event.preventDefault(); document.getElementById('adminLogoutForm').submit();"
                    ><i class="dw dw-logout"></i> Log Out</a>
                    <form method="post" action="{{route('seller.logout')}}" id="adminLogoutForm">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    @endif


</div>
