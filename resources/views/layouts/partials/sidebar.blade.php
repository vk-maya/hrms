@if (Auth::guard('web')->user()->verified==1)
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="@if(in_array(\Request::route()->getName(), ["empdashboard"])) active @endif">
                    <a href="{{ route('empdashboard') }}"><i class="la la-dashboard"></i> <span> Dashboard</span> <span
                            class=""></span></a>
                </li>
                <li class="menu-title">
                    <span>Employees</span>
                </li>
                <li class="submenu @if(in_array(\Request::route()->getName(), ["employees.attendance", "employees.leave"])) active @endif">
                    <a href="#"><i class="la la-user"></i> <span> Employees</span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="@if(\Request::route()->getName() == 'employees.attendance') active @endif" href="{{route('employees.attendance')}}">Attendance</a></li>
                        <li><a class="@if(\Request::route()->getName() == 'employees.leave') active @endif" href="{{route('employees.leave')}}">Leaves</a></li>

                    </ul>
                </li>                
                <li class="submenu @if(in_array(\Request::route()->getName(), ["employees.daily.task", "employees.show-list"])) active @endif">
                    <a href="#"><i class="la la-rocket"></i> <span> Task</span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        {{-- <li><a href="{{route('employees.task')}}">Tasks</a></li> --}}
                        @php
                        $date = now();
                               $task = \App\Models\DailyTasks::where('user_id',Auth::guard('web')->user()->id)->whereDate('post_date', date('Y-m-d', strtotime($date)))->count();
                        @endphp
                        @if($task < 2)
                            <li><a class="@if(\Request::route()->getName() == 'employees.daily.task') active @endif" href="{{route('employees.daily.task')}}">Daily Task</a></li>
                           
                        @else
                            <li><a disabled>Daily Task</a></li>
                            @endif
                            <li><a class="@if(\Request::route()->getName() == 'employees.show-list') active @endif" href="{{route('employees.show-list')}}">List Task</a></li>
                    
                    </ul>
                </li>
                <li class="submenu @if(in_array(\Request::route()->getName(), ["employees.attendance", "employees.leave"])) active @endif">
                    <a href="#"><i class="la la-user"></i> <span> Pay Roll</span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="@if(\Request::route()->getName() == 'employees.salary.slip.list') active @endif" href="{{route('employees.salary.slip.list')}}">Slip List</a></li>
                        {{-- <li><a class="@if(\Request::route()->getName() == 'employees.leave') active @endif" href="{{route('employees.leave')}}">Leaves</a></li> --}}

                    </ul>
                </li>    
            </ul>
        </div>
    </div>
</div>
@endif
