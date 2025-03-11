<!--begin::Header-->
<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            {{-- @include('includes.notification') --}}

            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li>
            <!--end::Fullscreen Toggle-->
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    {{-- <div class="p-1 text-center" style="display:inline-block; width: 25px; height: 25px; background-color: #0000FE; color: white; border-radius:50%; line-height: 50%;"><span>D</span></div> --}}
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!--begin::Menu Footer-->
                    <li class="user-footer">
                        <a href="{{ route('profile') }}" class="btn btn-light btn-flat d-block text-start mb-2">Profile</a>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="d-block w-full" style="text-decoration: none; background-color: #FFF4F2F2; opacity: 0.9; color: #BD251C;">
                                <span><img src="{{ asset('images/icon/logout.svg')}}" alt="Logout Icon"></span>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </li>
                    <!--end::Menu Footer-->
                </ul>
            </li>
            <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>
<!--end::Header-->
