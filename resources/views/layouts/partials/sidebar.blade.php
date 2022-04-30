<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="">
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
                        <li><a href="leaves-employee.html">Leaves (Employee)</a></li>

                        <li><a href="attendance-employee.html">Attendance (Employee)</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-rocket"></i> <span> Projects</span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{route('employees.task')}}">Tasks</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>