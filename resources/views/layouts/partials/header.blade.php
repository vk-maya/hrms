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

    <div class="page-title-box">
        {{-- <h3>Scrum Digital Pvt Ltd</h3> --}}
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


        <li class="nav-item dropdown flag-nav">
            <a class="nav-link disabled">
                <img src="{{ asset('assets/img/flags/us.png') }}" alt="" height="20"> <span>India</span>
            </a>
           
        </li>
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img"><img
                        src="{{ asset('storage/uploads/' . Auth::guard('web')->user()->image) }}" alt="">
                    <span class="status online"></span></span>
                <span> {{ Auth::guard('web')->user()->name }}</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{route('employees.profile')}}">My Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class=" dropdown-item" type="submit">
                            Log Out
                        </button>
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
