<div class="sidebar" id="sidebar">
   <div class="sidebar-inner slimscroll">
      <div id="sidebar-menu" class="sidebar-menu">
         <ul>
            <li class="menu-title">
               <span>Main</span>
            </li>
            <li class="@if(in_array(\Request::route()->getName(), ["admin.dashboard"])) active @endif">
            <a href="{{route('admin.dashboard')}}"><i class="la la-dashboard"></i> <span> Dashboard</span></a>
            </li>
            <li class="menu-title">
               <span>Branch</span>
            </li>
            <li class="submenu @if(in_array(\Request::route()->getName(), ["admin.departments", "admin.designation"])) active @endif">
            <a href="#"><i class="fa fa-sitemap" aria-hidden="true"></i> <span>Departments</span> <span
               class="menu-arrow"></span></a>
            <ul style="display: none;">
               <li><a class="@if(\Request::route()->getName() == 'admin.departments') active @endif" href="{{route('admin.departments')}}">All Departments</a></li>
               <li><a class="@if(\Request::route()->getName() == 'admin.designation') active @endif" href="{{route('admin.designation')}}">All Designation</a></li>
            </ul>
            </li>
            <li class="menu-title">
               <span>Employees</span>
            </li>
            <li class="submenu @if(in_array(\Request::route()->getName(), ["admin.employees", "admin.attendance", "admin.holidays", "admin.leave-setting", "admin.leave.list", "admin.add-leave-type"])) active @endif">
            <a href="#"><i class="la la-user"></i> <span> Employees</span> <span
               class="menu-arrow"></span></a>
            <ul style="display: none;">
               <li><a class="@if(\Request::route()->getName() == 'admin.employees') active @endif" href="{{route('admin.employees')}}">Employees</a></li>
               <li><a class="@if(\Request::route()->getName() == 'admin.attendance') active @endif" href="{{route('admin.attendance')}}">Attendance</a></li>
               <li><a class="@if(\Request::route()->getName() == 'admin.holidays') active @endif" href="{{route('admin.holidays')}}">Holiday</a></li>
               <li><a class="@if(in_array(\Request::route()->getName(), ["admin.leave-setting", "admin.add-leave-type"])) active @endif " href="{{route('admin.leave-setting')}}">Leave Settings</a></li>
               <li><a class="@if(\Request::route()->getName() == 'admin.leave.list') active @endif" href="{{route('admin.leave.list')}}">Leave</a></li>
            </ul>
            </li>
            <li class="submenu @if (in_array(\Request::route()->getName(), ["admin.payroll.list"])) active @endif">
            <a href="#" class=""><i class="la la-money"></i> <span> Payroll </span> <span
               class="menu-arrow"></span></a>
            <ul style="display: none;">
               <li><a class="@if (\Request::route()->getName() == 'admin.payroll.list') active @endif"
                  href="{{route('admin.payroll.list')}}"> Employee Salary </a></li>
            </ul>
            </li>
            <li class="submenu @if(in_array(\Request::route()->getName(), ["admin.emp.report"])) active @endif">
            <a href="#"><i class="la la-pie-chart"></i> <span>Report</span> <span
               class="menu-arrow"></span></a>
            <ul style="display: none;">
               <li><a class="@if(\Request::route()->getName() == 'admin.emp.report') active @endif" href="{{route('admin.emp.report')}}">Payslip</a></li>
            </ul>
            </li>
            <li class="submenu @if(in_array(\Request::route()->getName(), ["admin.all.task.list"])) active @endif">
            <a href="#"><i class="la la-edit"></i> <span> Task</span> <span
               class="menu-arrow"></span></a>
            <ul style="display: none;">
               <li><a class="@if(\Request::route()->getName() == 'admin.all.task.list') active @endif" href="{{route('admin.all.task.list')}}">Task List</a></li>
            </ul>
            </li>
         </ul>
      </div>
   </div>
</div>