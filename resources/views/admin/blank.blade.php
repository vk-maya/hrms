@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endpush
@section('content')

<div class="page-wrapper">
    <div class="chat-main-row">
        <div class="chat-main-wrapper">
            <div class="col-lg-7 message-view task-view task-left-sidebar">
                <div class="chat-window">
                    <div class="fixed-header">
                        <div class="navbar">
                            <div class="float-start me-auto">
                                <div class="add-task-btn-wrapper">
                                    <span class="add-task-btn btn btn-white btn-sm">
                                        Add Task
                                    </span>
                                </div>
                            </div>
                            <a class="task-chat profile-rightbar float-end" id="task_chat" href="#task_window"><i class="fa fa fa-comment"></i></a>
                            <ul class="nav float-end custom-menu">
                                <li class="nav-item dropdown dropdown-action">
                                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)">Pending Tasks</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Completed Tasks</a>
                                        <a class="dropdown-item" href="javascript:void(0)">All Tasks</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="chat-contents">
                        <div class="chat-content-wrap">
                            <div class="chat-wrap-inner">
                                <div class="chat-box">
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
                                                            <span class="task-label" contenteditable="true">Patient appointment
                                                                booking</span>
                                                            <span class="task-action-btn task-btn-right">
                                                                <span class="action-circle large"
                                                                    title="Assign">
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
                                                            <span class="task-label" contenteditable="true">Appointment booking with
                                                                payment gateway</span>
                                                            <span class="task-action-btn task-btn-right">																	
                                                                <span class="action-circle large delete-btn"
                                                                    title="Delete Task">
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
                                                            <span class="task-label">Doctor available
                                                                module</span>
                                                            <span class="task-action-btn task-btn-right">
                                                                <span class="action-circle large"
                                                                    title="Assign">
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
                                                            <span class="task-label" contenteditable="true">Patient and Doctor video
                                                                conferencing</span>
                                                            <span class="task-action-btn task-btn-right">
                                                                <span class="action-circle large"
                                                                    title="Assign">
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
                                                                <span class="action-circle large"
                                                                    title="Assign">
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
                                                            <span class="task-label" contenteditable="true">Patient Profile
                                                                add</span>
                                                            <span class="task-action-btn task-btn-right">
                                                                <span class="action-circle large"
                                                                    title="Assign">
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
                                                    <span class="add-new-task-btn btn" id="add-task">Add
                                                        Task</span>
                                                    <span class="btn" id="close-task-panel">Close</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="notification-popup hide">
                                        <p>
                                            <span class="task"></span>
                                            <span class="notification-text"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 message-view task-chat-view task-right-sidebar" id="task_window">
                <div class="chat-window">
                    <div class="fixed-header">
                        <div class="navbar">
                            <div class="task-assign">
                                <a class="task-complete-btn" id="task_complete" href="javascript:void(0);">
                                    <i class="material-icons">check</i> Mark Complete
                                </a>
                            </div>
                            <ul class="nav float-end custom-menu">
                                <li class="dropdown dropdown-action">
                                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)">Delete Task</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Settings</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="chat-contents task-chat-contents">
                        <div class="chat-content-wrap">
                            <div class="chat-wrap-inner">
                                <div class="chat-box">
                                    <div class="chats">
                                        <h4>Hospital Administration Phase 1</h4>
                                        <div class="task-header">
                                            <div class="assignee-info">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#assignee">
                                                    <div class="avatar">
                                                        <img alt="" src="assets/img/profiles/avatar-02.jpg">
                                                    </div>
                                                    <div class="assigned-info">
                                                        <div class="task-head-title">Assigned To</div>
                                                        <div class="task-assignee">John Doe</div>
                                                    </div>
                                                </a>
                                                <span class="remove-icon">
                                                    <i class="fa fa-close"></i>
                                                </span>
                                            </div>
                                            <div class="task-due-date">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#assignee">
                                                    <div class="due-icon">
                                                        <span>
                                                            <i class="material-icons">date_range</i>
                                                        </span>
                                                    </div>
                                                    <div class="due-info">
                                                        <div class="task-head-title">Due Date</div>
                                                        <div class="due-date">Mar 26, 2019</div>
                                                    </div>
                                                </a>
                                                <span class="remove-icon">
                                                    <i class="fa fa-close"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <hr class="task-line">
                                        <div class="task-desc">
                                            <div class="task-desc-icon">
                                                <i class="material-icons">subject</i>
                                            </div>
                                            <div class="task-textarea">
                                                <textarea class="form-control" placeholder="Description"></textarea>
                                            </div>
                                        </div>
                                        <hr class="task-line">
                                        <div class="task-information">
                                            <span class="task-info-line"><a class="task-user" href="#">Lesley
                                                    Grauer</a> <span class="task-info-subject">created
                                                    task</span></span>
                                            <div class="task-time">Jan 20, 2019</div>
                                        </div>
                                        <div class="task-information">
                                            <span class="task-info-line"><a class="task-user" href="#">Lesley
                                                    Grauer</a> <span class="task-info-subject">added to Hospital
                                                    Administration</span></span>
                                            <div class="task-time">Jan 20, 2019</div>
                                        </div>
                                        <div class="task-information">
                                            <span class="task-info-line"><a class="task-user" href="#">Lesley
                                                    Grauer</a> <span class="task-info-subject">assigned to John
                                                    Doe</span></span>
                                            <div class="task-time">Jan 20, 2019</div>
                                        </div>
                                        <hr class="task-line">
                                        <div class="task-information">
                                            <span class="task-info-line"><a class="task-user" href="#">John
                                                    Doe</a> <span class="task-info-subject">changed the due date
                                                    to Sep 28</span> </span>
                                            <div class="task-time">9:09pm</div>
                                        </div>
                                        <div class="task-information">
                                            <span class="task-info-line"><a class="task-user" href="#">John
                                                    Doe</a> <span class="task-info-subject">assigned to
                                                    you</span></span>
                                            <div class="task-time">9:10pm</div>
                                        </div>
                                        <div class="chat chat-left">
                                            <div class="chat-avatar">
                                                <a href="profile.html" class="avatar">
                                                    <img alt="" src="assets/img/profiles/avatar-02.jpg">
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-bubble">
                                                    <div class="chat-content">
                                                        <span class="task-chat-user">John Doe</span> <span class="chat-time">8:35 am</span>
                                                        <p>I'm just looking around.</p>
                                                        <p>Will you tell me something about yourself? </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="completed-task-msg"><span class="task-success"><a
                                                    href="#">John Doe</a> completed this task.</span> <span class="task-time">Today at 9:27am</span></div>
                                        <div class="chat chat-left">
                                            <div class="chat-avatar">
                                                <a href="profile.html" class="avatar">
                                                    <img alt="" src="assets/img/profiles/avatar-02.jpg">
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-bubble">
                                                    <div class="chat-content">
                                                        <span class="task-chat-user">John Doe</span> <span class="file-attached">attached 3 files <i
                                                                class="fa fa-paperclip"></i></span> <span class="chat-time">Feb 17, 2019 at 4:32am</span>
                                                        <ul class="attach-list">
                                                            <li><i class="fa fa-file"></i> <a href="#">project_document.avi</a></li>
                                                            <li><i class="fa fa-file"></i> <a href="#">video_conferencing.psd</a></li>
                                                            <li><i class="fa fa-file"></i> <a href="#">landing_page.psd</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat chat-left">
                                            <div class="chat-avatar">
                                                <a href="profile.html" class="avatar">
                                                    <img alt="" src="assets/img/profiles/avatar-16.jpg">
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-bubble">
                                                    <div class="chat-content">
                                                        <span class="task-chat-user">Jeffery Lalor</span> <span class="file-attached">attached file <i
                                                                class="fa fa-paperclip"></i></span> <span class="chat-time">Yesterday at 9:16pm</span>
                                                        <ul class="attach-list">
                                                            <li class="pdf-file"><i class="fa fa-file-pdf-o"></i> <a href="#">Document_2016.pdf</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat chat-left">
                                            <div class="chat-avatar">
                                                <a href="profile.html" class="avatar">
                                                    <img alt="" src="assets/img/profiles/avatar-16.jpg">
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-bubble">
                                                    <div class="chat-content">
                                                        <span class="task-chat-user">Jeffery Lalor</span> <span class="file-attached">attached file <i
                                                                class="fa fa-paperclip"></i></span> <span class="chat-time">Today at 12:42pm</span>
                                                        <ul class="attach-list">
                                                            <li class="img-file">
                                                                <div class="attach-img-download"><a href="#">avatar-1.jpg</a></div>
                                                                <div class="task-attach-img"><img src="assets/img/user.jpg" alt=""></div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="task-information">
                                            <span class="task-info-line">
                                                <a class="task-user" href="#">John Doe</a>
                                                <span class="task-info-subject">marked task as incomplete</span>
                                            </span>
                                            <div class="task-time">1:16pm</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-footer">
                        <div class="message-bar">
                            <div class="message-inner">
                                <a class="link attach-icon" href="#"><img src="assets/img/attachment.png" alt=""></a>
                                <div class="message-area">
                                    <div class="input-group">
                                        <textarea class="form-control" placeholder="Type message..."></textarea>
                                        <button class="btn btn-primary" type="button"><i
                                                class="fa fa-send"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="project-members task-followers">
                            <span class="followers-title">Followers</span>
                            <a class="avatar" href="#" data-bs-toggle="tooltip" title="Jeffery Lalor">
                                <img alt="" src="assets/img/profiles/avatar-16.jpg">
                            </a>
                            <a class="avatar" href="#" data-bs-toggle="tooltip" title="Richard Miles">
                                <img alt="" src="assets/img/profiles/avatar-09.jpg">
                            </a>
                            <a class="avatar" href="#" data-bs-toggle="tooltip" title="John Smith">
                                <img alt="" src="assets/img/profiles/avatar-10.jpg">
                            </a>
                            <a class="avatar" href="#" data-bs-toggle="tooltip" title="Mike Litorus">
                                <img alt="" src="assets/img/profiles/avatar-05.jpg">
                            </a>
                            <a href="#" class="followers-add" data-bs-toggle="modal" data-bs-target="#task_followers"><i class="material-icons">add</i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="create_project" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Project</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Project Name</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Client</label>
                                    <select class="select">
                                        <option>Global Technologies</option>
                                        <option>Delta Infotech</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Rate</label>
                                    <input placeholder="$50" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <select class="select">
                                        <option>Hourly</option>
                                        <option>Fixed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Priority</label>
                                    <select class="select">
                                        <option>High</option>
                                        <option>Medium</option>
                                        <option>Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Add Project Leader</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Team Leader</label>
                                    <div class="project-members">
                                        <a class="avatar" href="#" data-bs-toggle="tooltip" title="Jeffery Lalor">
                                            <img alt="" src="assets/img/profiles/avatar-16.jpg">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Add Team</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Team Members</label>
                                    <div class="project-members">
                                        <a class="avatar" href="#" data-bs-toggle="tooltip" title="John Doe">
                                            <img alt="" src="assets/img/profiles/avatar-02.jpg">
                                        </a>
                                        <a class="avatar" href="#" data-bs-toggle="tooltip" title="Richard Miles">
                                            <img alt="" src="assets/img/profiles/avatar-09.jpg">
                                        </a>
                                        <a class="avatar" href="#" data-bs-toggle="tooltip" title="John Smith">
                                            <img alt="" src="assets/img/profiles/avatar-10.jpg">
                                        </a>
                                        <a class="avatar" href="#" data-bs-toggle="tooltip" title="Mike Litorus">
                                            <img alt="" src="assets/img/profiles/avatar-05.jpg">
                                        </a>
                                        <span class="all-team">+2</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <div id="editor"></div>
                        </div>
                        <div class="form-group">
                            <label>Upload Files</label>
                            <input class="form-control" type="file">
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div id="assignee" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign to this task</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group m-b-30">
                        <input placeholder="Search to add" class="form-control search-input" type="text">
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
                        <button class="btn btn-primary submit-btn">Assign</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="task_followers" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add followers to this task</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group m-b-30">
                        <input placeholder="Search to add" class="form-control search-input" type="text">
                        <button class="btn btn-primary">Search</button>
                    </div>
                    <div>
                        <ul class="chat-user-list">
                            <li>
                                <a href="#">
                                    <div class="media d-flex">
                                        <span class="avatar"><img alt=""
                                                src="assets/img/profiles/avatar-16.jpg"></span>
                                        <div class="media-body media-middle text-nowrap">
                                            <div class="user-name">Jeffery Lalor</div>
                                            <span class="designation">Team Leader</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="media d-flex">
                                        <span class="avatar"><img alt=""
                                                src="assets/img/profiles/avatar-08.jpg"></span>
                                        <div class="media-body media-middle text-nowrap">
                                            <div class="user-name">Catherine Manseau</div>
                                            <span class="designation">Android Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="media d-flex">
                                        <span class="avatar"><img alt=""
                                                src="assets/img/profiles/avatar-26.jpg"></span>
                                        <div class="media-body media-middle text-nowrap">
                                            <div class="user-name">Wilmer Deluna</div>
                                            <span class="designation">Team Leader</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Add to Follow</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
    {{-- {{$state}} --}}
@endsection
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
