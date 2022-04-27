@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endpush
@section('content')

<div class="page-wrapper">

    
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">{{$project->name}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Project</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{ route('admin.project.edit', $project->id) }}" class="btn add-btn" ><i
                            class="fa fa-plus"></i> Edit Project</a>
                    <a href="task-board.html" class="btn btn-white float-end m-r-10" data-bs-toggle="tooltip" title="Task Board"><i class="fa fa-bars"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <div class="project-title">
                            <h5 class="card-title">Hospital Administration</h5>
                            <small class="block text-ellipsis m-b-15"><span class="text-xs">2</span> <span
                                    class="text-muted">open tasks, </span><span class="text-xs">5</span> <span
                                    class="text-muted">tasks completed</span></small>
                        </div>
                       {!!$project->description!!}
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-20">Uploaded image files</h5>
                        <div class="row">
                            @foreach ($project->image()->get() as $item)
                            <div class="col-md-3 col-sm-4 col-lg-4 col-xl-3">
                                <div class="uploaded-box">
                                    <div class="uploaded-img">
                                        <img src="{{ asset('storage/project/' . $item->image) }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="uploaded-img-name">
                                    {{$item->image}}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                    
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-20">Uploaded files</h5>
                        <ul class="files-list">
                            <li>
                                <div class="files-cont">
                                    <div class="file-type">
                                        <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                    </div>
                                    <div class="files-info">
                                        <span class="file-name text-ellipsis"><a href="#">AHA Selfcare Mobile
                                                Application Test-Cases.xls</a></span>
                                        <span class="file-author"><a href="#">John Doe</a></span> <span class="file-date">May 31st at 6:53 PM</span>
                                        <div class="file-size">Size: 14.8Mb</div>
                                    </div>
                                    <ul class="files-action">
                                        <li class="dropdown dropdown-action">
                                            <a href="#" class="dropdown-toggle btn btn-link" data-bs-toggle="dropdown" aria-expanded="false"><i
                                                    class="material-icons">more_horiz</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void(0)">Download</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#share_files">Share</a>
                                                <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="files-cont">
                                    <div class="file-type">
                                        <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                    </div>
                                    <div class="files-info">
                                        <span class="file-name text-ellipsis"><a href="#">AHA Selfcare Mobile
                                                Application Test-Cases.xls</a></span>
                                        <span class="file-author"><a href="#">Richard Miles</a></span> <span class="file-date">May 31st at 6:53 PM</span>
                                        <div class="file-size">Size: 14.8Mb</div>
                                    </div>
                                    <ul class="files-action">
                                        <li class="dropdown dropdown-action">
                                            <a href="#" class="dropdown-toggle btn btn-link" data-bs-toggle="dropdown" aria-expanded="false"><i
                                                    class="material-icons">more_horiz</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void(0)">Download</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#share_files">Share</a>
                                                <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- <div class="project-task">
                    <ul class="nav nav-tabs nav-tabs-top nav-justified mb-0">
                        <li class="nav-item"><a class="nav-link active" href="#all_tasks" data-bs-toggle="tab" aria-expanded="true">All Tasks</a></li>
                        <li class="nav-item"><a class="nav-link" href="#pending_tasks" data-bs-toggle="tab" aria-expanded="false">Pending Tasks</a></li>
                        <li class="nav-item"><a class="nav-link" href="#completed_tasks" data-bs-toggle="tab" aria-expanded="false">Completed Tasks</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="all_tasks">
                            <div class="task-wrapper">
                                <div class="task-list-container">
                                    <div class="task-list-body">
                                        <ul id="task-list">
                                            <li class="task">
                                                <div class="task-container">
                                                    <span class="task-action-btn task-check">
                                                        <span class="action-circle large complete-btn"
                                                            title="Mark Complete">
                                                            <i class="material-icons">check</i>
                                                        </span>
                                                    </span>
                                                    <span class="task-label" contenteditable="true">Patient
                                                        appointment booking</span>
                                                    <span class="task-action-btn task-btn-right">
                                                        <span class="action-circle large" title="Assign">
                                                            <i class="material-icons">person_add</i>
                                                        </span>
                                                    <span class="action-circle large delete-btn" title="Delete Task">
                                                            <i class="material-icons">delete</i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </li>
                                            <li class="task">
                                                <div class="task-container">
                                                    <span class="task-action-btn task-check">
                                                        <span class="action-circle large complete-btn"
                                                            title="Mark Complete">
                                                            <i class="material-icons">check</i>
                                                        </span>
                                                    </span>
                                                    <span class="task-label" contenteditable="true">Appointment
                                                        booking with payment gateway</span>
                                                    <span class="task-action-btn task-btn-right">
                                                        <span class="action-circle large" title="Assign">
                                                            <i class="material-icons">person_add</i>
                                                        </span>
                                                    <span class="action-circle large delete-btn" title="Delete Task">
                                                            <i class="material-icons">delete</i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </li>
                                            <li class="completed task">
                                                <div class="task-container">
                                                    <span class="task-action-btn task-check">
                                                        <span class="action-circle large complete-btn"
                                                            title="Mark Complete">
                                                            <i class="material-icons">check</i>
                                                        </span>
                                                    </span>
                                                    <span class="task-label">Doctor available module</span>
                                                    <span class="task-action-btn task-btn-right">
                                                        <span class="action-circle large" title="Assign">
                                                            <i class="material-icons">person_add</i>
                                                        </span>
                                                    <span class="action-circle large delete-btn" title="Delete Task">
                                                            <i class="material-icons">delete</i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </li>
                                            <li class="task">
                                                <div class="task-container">
                                                    <span class="task-action-btn task-check">
                                                        <span class="action-circle large complete-btn"
                                                            title="Mark Complete">
                                                            <i class="material-icons">check</i>
                                                        </span>
                                                    </span>
                                                    <span class="task-label" contenteditable="true">Patient and
                                                        Doctor video conferencing</span>
                                                    <span class="task-action-btn task-btn-right">
                                                        <span class="action-circle large" title="Assign">
                                                            <i class="material-icons">person_add</i>
                                                        </span>
                                                    <span class="action-circle large delete-btn" title="Delete Task">
                                                            <i class="material-icons">delete</i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </li>
                                            <li class="task">
                                                <div class="task-container">
                                                    <span class="task-action-btn task-check">
                                                        <span class="action-circle large complete-btn"
                                                            title="Mark Complete">
                                                            <i class="material-icons">check</i>
                                                        </span>
                                                    </span>
                                                    <span class="task-label" contenteditable="true">Private chat
                                                        module</span>
                                                    <span class="task-action-btn task-btn-right">
                                                        <span class="action-circle large" title="Assign">
                                                            <i class="material-icons">person_add</i>
                                                        </span>
                                                    <span class="action-circle large delete-btn" title="Delete Task">
                                                            <i class="material-icons">delete</i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </li>
                                            <li class="task">
                                                <div class="task-container">
                                                    <span class="task-action-btn task-check">
                                                        <span class="action-circle large complete-btn"
                                                            title="Mark Complete">
                                                            <i class="material-icons">check</i>
                                                        </span>
                                                    </span>
                                                    <span class="task-label" contenteditable="true">Patient
                                                        Profile add</span>
                                                    <span class="task-action-btn task-btn-right">
                                                        <span class="action-circle large" title="Assign">
                                                            <i class="material-icons">person_add</i>
                                                        </span>
                                                    <span class="action-circle large delete-btn" title="Delete Task">
                                                            <i class="material-icons">delete</i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="task-list-footer">
                                        <div class="new-task-wrapper">
                                            <textarea id="new-task" placeholder="Enter new task here. . ."></textarea>
                                            <span class="error-message hidden">You need to enter a task
                                                first</span>
                                            <span class="add-new-task-btn btn" id="add-task">Add Task</span>
                                            <span class="btn" id="close-task-panel">Close</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="pending_tasks"></div>
                        <div class="tab-pane" id="completed_tasks"></div>
                    </div>
                </div> --}}
            </div>
            <div class="col-lg-4 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title m-b-15">Project details</h6>
                        <table class="table table-striped table-border">
                            <tbody>
                                <tr>
                                    <td>Cost:</td>
                                    <td class="text-end">{{$project->rate}}</td>
                                </tr>
                                {{-- <tr>
                                    <td>Total Hours:</td>
                                    <td class="text-end">100 Hours</td>
                                </tr> --}}
                                <tr>
                                    <td>Created:</td>
                                    <td class="text-end"> {{ \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Deadline:</td>
                                    <td class="text-end"> {{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Priority:</td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="#" class="badge badge-danger dropdown-toggle" data-bs-toggle="dropdown">Highest </a>
                                            <div class="dropdown-menu dropdown-menu-right">                                                
                                                <a class="dropdown-item" href="#"><i
                                                        class="fa fa-dot-circle-o text-info"></i> High
                                                    priority</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="fa fa-dot-circle-o text-primary"></i> Normal
                                                    priority</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="fa fa-dot-circle-o text-success"></i> Low
                                                    priority</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    {{-- {{$project->auth()->name}} --}}
                                    
                                        
                                    
                                    <td>Created by:</td>
                                    {{-- <td class="text-end"><a href="profile.html">{{$project->auth()->get()}}</a></td> --}}
                                </tr>
                                <tr>
                                    <td>Status:</td>
                                    <td class="text-end">Working</td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="m-b-5">Progress <span class="text-success float-end">40%</span></p>
                        <div class="progress progress-xs mb-0">
                            <div class="progress-bar bg-success" role="progressbar" data-bs-toggle="tooltip" title="40%" style="width: 40%"></div>
                        </div>
                    </div>
                </div>
                {{-- <div class="card project-user">
                    <div class="card-body">
                        <h6 class="card-title m-b-20">Assigned Leader <button type="button" class="float-end btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assign_leader"><i class="fa fa-plus"></i> Add</button></h6>
                        <ul class="list-box">
                            <li>
                                <a href="profile.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar"><img alt=""
                                                    src="assets/img/profiles/avatar-11.jpg"></span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Wilmer Deluna</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Team Leader</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="profile.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar"><img alt=""
                                                    src="assets/img/profiles/avatar-01.jpg"></span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Lesley Grauer</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Team Leader</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card project-user">
                    <div class="card-body">
                        <h6 class="card-title m-b-20">
                            Assigned users
                            <button type="button" class="float-end btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assign_user"><i class="fa fa-plus"></i>
                                Add</button>
                        </h6>
                        <ul class="list-box">
                            <li>
                                <a href="profile.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar"><img alt=""
                                                    src="assets/img/profiles/avatar-02.jpg"></span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">John Doe</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Web Designer</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="profile.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar"><img alt=""
                                                    src="assets/img/profiles/avatar-09.jpg"></span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Richard Miles</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Web Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

{{-- 
    <div id="assign_leader" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Leader to this project</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group m-b-30">
                        <input placeholder="Search to add a leader" class="form-control search-input" type="text">
                        <button class="btn btn-primary">Search</button>
                    </div>
                    <div>
                        <ul class="chat-user-list">
                            <li>
                                <a href="#">
                                    <div class="media d-flex">
                                        <span class="avatar"><img alt=""
                                                src="assets/img/profiles/avatar-09.jpg"></span>
                                        <div class="media-body align-self-center text-nowrap">
                                            <div class="user-name">Richard Miles</div>
                                            <span class="designation">Web Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="media d-flex">
                                        <span class="avatar"><img alt=""
                                                src="assets/img/profiles/avatar-10.jpg"></span>
                                        <div class="media-body align-self-center text-nowrap">
                                            <div class="user-name">John Smith</div>
                                            <span class="designation">Android Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="media d-flex">
                                        <span class="avatar">
                                            <img alt="" src="assets/img/profiles/avatar-16.jpg">
                                        </span>
                                        <div class="media-body align-self-center text-nowrap">
                                            <div class="user-name">Jeffery Lalor</div>
                                            <span class="designation">Team Leader</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="assign_user" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign the user to this project</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group m-b-30">
                        <input placeholder="Search a user to assign" class="form-control search-input" type="text">
                        <button class="btn btn-primary">Search</button>
                    </div>
                    <div>
                        <ul class="chat-user-list">
                            <li>
                                <a href="#">
                                    <div class="media d-flex">
                                        <span class="avatar"><img alt=""
                                                src="assets/img/profiles/avatar-09.jpg"></span>
                                        <div class="media-body align-self-center text-nowrap">
                                            <div class="user-name">Richard Miles</div>
                                            <span class="designation">Web Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="media d-flex">
                                        <span class="avatar"><img alt=""
                                                src="assets/img/profiles/avatar-10.jpg"></span>
                                        <div class="media-body align-self-center text-nowrap">
                                            <div class="user-name">John Smith</div>
                                            <span class="designation">Android Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="media d-flex">
                                        <span class="avatar">
                                            <img alt="" src="assets/img/profiles/avatar-16.jpg">
                                        </span>
                                        <div class="media-body align-self-center text-nowrap">
                                            <div class="user-name">Jeffery Lalor</div>
                                            <span class="designation">Team Leader</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


 

</div>

@push('plugin-js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        // document.getElementById("email").onchange = function() {
        //     email()
        // };
        document.getElementById("email").onchange = function() {
            emaill()
        };

        function emaill() {
            var x = document.getElementById("email");
            let email = $('#email').val();
            var url = "{{ route('admin.emailv') }}";
            $.ajax({
                url: url,
                type: "post",
                cache: false,
                data: {
                    _token: '{{ csrf_token() }}',
                    x: email
                },
                success: function(email) {
                    x = JSON.parse(email);
                    if (x.count > 0) {
                        $("#emailerror").html('<span class="text-danger">Email Already Exist</span>');
                    } else {
                        $("#emailerror").html('');
                    }
                }
            })
        }
        document.getElementById("emp").onchange = function() {
            empl()
        };

        function empl() {
            var y = document.getElementById("emp");
            let eamployees = $('#emp').val();
            // consol.log(email)
            var url = "{{ route('admin.epid') }}";
            $.ajax({
                url: url,
                type: "post",
                cache: false,
                data: {
                    _token: '{{ csrf_token() }}',
                    y: eamployees
                },
                success: function(empl) {
                    xy = JSON.parse(empl);
                    if (xy.count > 0) {
                        $("#empt").html('<span class="text-danger">Employees Id Already Exist</span>');
                    } else {
                        $("#empt").html('');
                    }
                }
            })
        }

        function country() {
            var contid = document.getElementById("inputcountry");
            var id = $('#inputcountry').val();
            var url = "{{ route('admin.country.name') }}";
            $.ajax({
                url: url,
                type: "post",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    contid: id,
                },
                success: function(res) {
                    // console.log(state);
                    let data = '';
                    $.each(res.state, function(key, val) {
                        // console.log(val);
                        data += '<option value="' + val.id + '">' + val.name + '</option>';
                    });
                    $("#inputstate").html(data);
                }
            })
        }

        document.getElementById("inputcountry").onchange = function() {
            country()
        };



        function indepartment() {
            var dep = document.getElementById("inputDepartment");
            var de = $('#inputDepartment').val();
            var url = "{{ route('admin.designation.name') }}";
            $.ajax({
                url: url,
                type: "post",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    dep: de,
                },
                success: function(designation) {
                    desig = JSON.parse(designation);
                    // console.log(desig);
                    let data = '';
                    $.each(desig.count, function(index, val) {
                        data += '<option value="' + val.id + '">' + val.designation_name + '</option>';
                    });
                    $("#inputDesignation").html(data);
                }

            })
        }
        document.getElementById("inputDepartment").onchange = function() {
            indepartment()
        };
        indepartment()

        function city() {
            var city = document.getElementById("inputstate");
            var id = $("#inputstate").val();
            var url = "{{ route('admin.country.state.name') }}"
            $.ajax({
                type: "post",
                url: url,
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function(res) {
                    var data = '';
                    $.each(res.city, function(key, val) {
                        // console.log(val);
                        data += '<option value="' + val.id + '">' + val.name + '</option>';
                    });
                    $("#inputcity").html(data);

                }
            });
        }
        document.getElementById("inputstate").onchange = () => {
            city()
        };
    </script>
@endpush
