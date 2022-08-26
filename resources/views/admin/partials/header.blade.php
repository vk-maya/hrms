<div class="header">

    <div class="header-left">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <img src="{{ asset('assets/img/logo.png') }}" alt="">
        </a>
    </div>

    <a id="toggle_btn" href="javascript:void(0);">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    @php
        $session = \App\Models\Admin\Session::where('status', 1)->first();
    @endphp
    <div class="page-title-box">
        <h3>Session - {{date('Y', strtotime($session->from)).'-'.date('Y', strtotime($session->to))}}</h3>
    </div>

    <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>

    <ul class="nav user-menu">

        <li class="nav-item">
            <div class="top-nav-search">
                <a href="javascript:void(0);" class="responsive-search">
                    <i class="fa fa-search"></i>
                </a>
                <form action="#">
                    <input class="form-control" type="text" placeholder="Search here">
                    <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </li>


        <li class="nav-item dropdown has-arrow flag-nav">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button">
                <img src="{{ asset('assets/img/flags/us.png') }}" alt="" height="20"> <span>India</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" data-bs-toggle="dropdown" href="#" role="button">
                    <img src="{{ asset('assets/img/flags/us.png') }}" alt="" height="20" class="me-3"> <span>India</span>
                </a>
            </div>
        </li>
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img"><img
                        src="{{ asset('assets/img/avtar.jpg') }}" alt="">
                </span>
                <span> {{ Auth::guard('admin')->user()->name }}</span>
            </a>
            <div class="dropdown-menu">
                <div class="admin-heading text-center">
                    <h4>Admin</h4>
                    <p>user</p>
                </div>
                <a class="dropdown-item" href="profile.html"><i class="fas fa-user me-3"></i>My Profile</a>
                <a class="dropdown-item" href="{{route('admin.settings')}}"><i class="fas fa-cog me-3"></i>Settings</a>
                <a class="dropdown-item" href="{{route('admin.salary.settings')}}"><i class="fas fa-money-check-alt me-3"></i>Salary Settings</a>
                <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"><i class="fas fa-sign-out me-3"></i>
                Log Out
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>


<div class="dropdown mobile-user-menu">
    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i
        class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="profile.html">My Profile</a>
            <a class="dropdown-item" href="settings.html">Settings</a>
            <a class="dropdown-item" href="index.html">Logout</a>
        </div>
    </div>

</div>
