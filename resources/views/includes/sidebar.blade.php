<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-white shadow">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand py-3">
        <!--begin::Brand Link-->
        <a href="../index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ asset('images/logo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <h2 class="brand-text fw-bold my-0">LEVI</h2>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper p-0">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link active">
                        <img src="{{ asset('images/icon/leave-icon.svg') }}" alt="Leave">
                        <p>Leave & Time Off</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../generate/theme.html" class="nav-link">
                        <img src="{{ asset('images/icon/overtime-icon.svg') }}" alt="Leave">
                        <p>Overtime</p>
                    </a>
                </li>
                @if (Auth::user()->role == 'hr')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <img src="{{ asset('images/icon/user.svg') }}" alt="Leave">
                            <p>User Management</p>
                        </a>
                    </li>
                @endif
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->
