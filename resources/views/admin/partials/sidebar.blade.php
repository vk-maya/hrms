
		<div class="sidebar" id="sidebar">
			<div class="sidebar-inner slimscroll">
				<div id="sidebar-menu" class="sidebar-menu">
					<ul>
						<li class="menu-title">
							<span>Main</span>
						</li>
						<li class="@if(\Request::route()->getName() == 'admin.dashboard') active @endif">
							<a href="{{route('admin.dashboard')}}"><i class="la la-dashboard"></i> <span> Dashboard</span></a>
						</li>
						{{-- <li class="submenu">
							<a href="#"><i class="la la-cube"></i> <span> Apps</span> <span
									class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="chat.html">Chat</a></li>
								<li class="submenu">
									<a href="#"><span> Calls</span> <span class="menu-arrow"></span></a>
									<ul style="display: none;">
										<li><a href="voice-call.html">Voice Call</a></li>
										<li><a href="video-call.html">Video Call</a></li>
										<li><a href="outgoing-call.html">Outgoing Call</a></li>
										<li><a href="incoming-call.html">Incoming Call</a></li>
									</ul>
								</li>
								<li><a href="events.html">Calendar</a></li>
								<li><a href="contacts.html">Contacts</a></li>
								<li><a href="inbox.html">Email</a></li>
								<li><a href="file-manager.html">File Manager</a></li>
							</ul>
						</li> --}}
						<li class="menu-title">
							<span>Branch</span>
						</li>
						<li class="submenu @if(\Request::route()->getName() == 'admin.departments' || \Request::route()->getName() == 'admin.designation') active @endif">
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
						<li class="submenu @if(\Request::route()->getName() == 'admin.employees') active @endif">
							<a href="#"><i class="la la-user"></i> <span> Employees</span> <span
									class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a class="@if(\Request::route()->getName() == 'admin.employees') active @endif" href="{{route('admin.employees')}}">All Employees</a></li>
								<li><a class="@if(\Request::route()->getName() == 'admin.leave.setting') active @endif" href="{{route('admin.leave.setting')}}">Leave Settings</a></li>
								<li><a class="@if(\Request::route()->getName() == 'admin.leave.list') active @endif" href="{{route('admin.leave.list')}}">Leave</a></li>
							</ul>
						
						</li>
						<li class="submenu @if(\Request::route()->getName() == 'admin.all.task.list') active @endif">
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
