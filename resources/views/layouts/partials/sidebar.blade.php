<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="@if(\Request::route()->getName() == 'dashboard' || \Request::route()->getName() == 'empdashboard') active @endif">
                    <a href="{{ route('dashboard') }}"><i class="la la-dashboard"></i> <span> Dashboard</span> <span
                            class=""></span></a>
                </li>
                <li class="menu-title">
                    <span>Employees</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-user"></i> <span> Employees</span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="@if(\Request::route()->getName() == 'employees.leave') active @endif" href="{{route('employees.leave')}}">Leaves</a></li>
                        
                    </ul>
                </li>
                <li class="submenu @if(\Request::route()->getName() == 'employees.daily.task' || \Request::route()->getName() == 'employees.show-list') active @endif">
                    <a href="#"><i class="la la-rocket"></i> <span> Task</span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        {{-- <li><a href="{{route('employees.task')}}">Tasks</a></li> --}}
                        <li><a class="@if(\Request::route()->getName() == 'employees.daily.task') active @endif" href="{{route('employees.daily.task')}}">Daily Task</a></li>
                        <li><a class="@if(\Request::route()->getName() == 'employees.show-list') active @endif" href="{{route('employees.show-list')}}">List Task</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
