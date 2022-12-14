<style>
    a.disabled {
        pointer-events: none;
        cursor: default;
    }
</style>
<div class="header">

    <div class="header-left">
        <a href="{{ route('dashboard') }}" class="logo">
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

    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

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


        <!-- <li class="nav-item flag-nav">
            <a class="nav-link disabled">
                <img src="{{ asset('assets/img/flags/us.png') }}" alt="" height="20"> <span>India</span>
            </a>
        </li> -->
        {{-- @if($employees->image != NULL){{ asset('storage/uploads/' . $employees->image) }}@else{{ asset('assets/img/avtar.jpg')}}@endif" </li> --}}
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img"><img src="@if(Auth::guard('web')->user()->image != NULL){{ asset('storage/uploads/' . Auth::guard('web')->user()->image) }}@else{{ asset('assets/img/avtar.jpg')}}@endif" alt="">
                    <span class="status online"></span></span>
                <span> {{ Auth::guard('web')->user()->name }}</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{route('employees.add.moreinfo')}}"><i class="fa fa-user me-3" aria-hidden="true"></i> My Profile</a>
                <a class="dropdown-item" href="{{route('employees.profile')}}"><i class="fa fa-key me-3" aria-hidden="true"></i> Password</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn dropdown-item" type="submit">
                        <i class="fas fa-sign-out me-3"></i> Log Out
                    </button>
                </form>
            </div>
        </li>
    </ul>
</div>