@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <style>
        .chat-content-wrap .chat-wrap-inner #bodyData {
            overflow: auto;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

    </style>
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="chat-main-row">
            <div class="chat-main-wrapper">
                <div class="col-lg-9 message-view task-view">
                    <div class="chat-window">
                        <div class="fixed-header">
                            <div class="navbar">
                                <div class="user-details me-auto">
                                    <div class="float-start user-img">
                                        <div class="avatar" href="profile.html"
                                            title="{{ Auth::guard('web')->user()->name }}">
                                            <img src=" {{ asset('storage/uploads/' . Auth::guard('web')->user()->image) }}"
                                                alt="" class="rounded-circle">
                                            <span class="status online"></span>
                                        </div>
                                    </div>
                                    <div class="user-info float-start">
                                        <span title="Mike Litorus">{{ Auth::guard('web')->user()->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-contents">
                            <div class="chat-content-wrap">
                                <div class="chat-wrap-inner">
                                    <div class="chat-box">
                                        <div class="chats">
                                            <div class="chat chat-right">
                                                <div class="chat-body">
                                                    <div class="chat-bubble">
                                                        <div id="bodyData">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-footer">
                            <div class="message-bar">
                                <div class="message-inner">
                                    <a class="link attach-icon" href="#" data-bs-toggle="modal"
                                        data-bs-target="#drag_files"><img
                                            src="{{ asset('storage/project/' . Auth::guard('web')->user()->image) }}"
                                            alt=""></a>
                                    <div class="message-area">
                                        <form id="SubmitForm">
                                            <div class="input-group">
                                                @csrf
                                                <input type="hidden" id="InputId"
                                                    value="{{ Auth::guard('web')->user()->id }}">
                                                <input id="InputName" class="form-control" value=""
                                                    placeholder="Type message...">
                                                <span class="text-danger" id="nameErrorMsg"></span>
                                                <button class="btn btn-custom" id="submit" type="submit"><i
                                                        class="fa fa-send"></i></button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-3 message-view chat-profile-view chat-sidebar" id="task_window">
                    <div class="chat-window video-window">
                        <div class="fixed-header">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item"><a class="nav-link" href="#calls_tab"
                                        data-bs-toggle="tab">Calls</a></li>
                                <li class="nav-item"><a class="nav-link active" href="#profile_tab"
                                        data-bs-toggle="tab">Profile</a></li>
                            </ul>
                        </div>
                        <div class="tab-content chat-contents">
                            <div class="content-full tab-pane" id="calls_tab">
                                <div class="chat-wrap-inner">
                                    <div class="chat-box">
                                        <div class="chats">
                                            <div class="chat chat-left">
                                                <div class="chat-avatar">
                                                    <a href="profile.html" class="avatar">
                                                        <img alt="" src="assets/img/profiles/avatar-02.jpg">
                                                    </a>
                                                </div>
                                                <div class="chat-body">
                                                    <div class="chat-bubble">
                                                        <div class="chat-content">
                                                            <span class="task-chat-user">You</span> <span
                                                                class="chat-time">8:35 am</span>
                                                            <div class="call-details">
                                                                <i class="material-icons">phone_missed</i>
                                                                <div class="call-info">
                                                                    <div class="call-user-details">
                                                                        <span class="call-description">Jeffrey
                                                                            Warden missed the call</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                                                            <span class="task-chat-user">John Doe</span> <span
                                                                class="chat-time">8:35 am</span>
                                                            <div class="call-details">
                                                                <i class="material-icons">call_end</i>
                                                                <div class="call-info">
                                                                    <div class="call-user-details"><span
                                                                            class="call-description">This call has
                                                                            ended</span></div>
                                                                    <div class="call-timing">Duration: <strong>5 min
                                                                            57 sec</strong></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="chat-line">
                                                <span class="chat-date">January 29th, 2019</span>
                                            </div>
                                            <div class="chat chat-left">
                                                <div class="chat-avatar">
                                                    <a href="profile.html" class="avatar">
                                                        <img alt="" src="assets/img/profiles/avatar-05.jpg">
                                                    </a>
                                                </div>
                                                <div class="chat-body">
                                                    <div class="chat-bubble">
                                                        <div class="chat-content">
                                                            <span class="task-chat-user">Richard Miles</span> <span
                                                                class="chat-time">8:35 am</span>
                                                            <div class="call-details">
                                                                <i class="material-icons">phone_missed</i>
                                                                <div class="call-info">
                                                                    <div class="call-user-details">
                                                                        <span class="call-description">You missed
                                                                            the call</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                                                            <span class="task-chat-user">You</span> <span
                                                                class="chat-time">8:35 am</span>
                                                            <div class="call-details">
                                                                <i class="material-icons">ring_volume</i>
                                                                <div class="call-info">
                                                                    <div class="call-user-details">
                                                                        <a href="#"
                                                                            class="call-description call-description--linked"
                                                                            data-qa="call_attachment_link">Calling
                                                                            John Smith ...</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content-full tab-pane show active" id="profile_tab">
                                <div class="display-table">
                                    <div class="table-row">
                                        <div class="table-body">
                                            <div class="table-content">
                                                <div class="chat-profile-img">
                                                    <div class="edit-profile-img">
                                                        <img src="assets/img/profiles/avatar-02.jpg" alt="">
                                                        <span class="change-img">Change Image</span>
                                                    </div>
                                                    <h3 class="user-name m-t-10 mb-0">John Doe</h3>
                                                    <small class="text-muted">Web Designer</small>
                                                    <a href="javascript:void(0);" class="btn btn-primary edit-btn"><i
                                                            class="fa fa-pencil"></i></a>
                                                </div>
                                                <div class="chat-profile-info">
                                                    <ul class="user-det-list">
                                                        <li>
                                                            <span>Username:</span>
                                                            <span class="float-end text-muted">johndoe</span>
                                                        </li>
                                                        <li>
                                                            <span>DOB:</span>
                                                            <span class="float-end text-muted">24 July</span>
                                                        </li>
                                                        <li>
                                                            <span>Email:</span>
                                                            <span class="float-end text-muted"><a
                                                                    href="https://smarthr.dreamguystech.com/cdn-cgi/l/email-protection"
                                                                    class="__cf_email__"
                                                                    data-cfemail="abc1c4c3c5cfc4ceebced3cac6dbc7ce85c8c4c6">[email&#160;protected]</a></span>
                                                        </li>
                                                        <li>
                                                            <span>Phone:</span>
                                                            <span class="float-end text-muted">9876543210</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="transfer-files">
                                                    <ul class="nav nav-tabs nav-tabs-solid nav-justified mb-0">
                                                        <li class="nav-item"><a class="nav-link active"
                                                                href="#all_files" data-bs-toggle="tab">All Files</a>
                                                        </li>
                                                        <li class="nav-item"><a class="nav-link"
                                                                href="#my_files" data-bs-toggle="tab">My Files</a></li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane show active" id="all_files">
                                                            <ul class="files-list">
                                                                <li>
                                                                    <div class="files-cont">
                                                                        <div class="file-type">
                                                                            <span class="files-icon"><i
                                                                                    class="fa fa-file-pdf-o"></i></span>
                                                                        </div>
                                                                        <div class="files-info">
                                                                            <span class="file-name text-ellipsis">AHA
                                                                                Selfcare Mobile Application
                                                                                Test-Cases.xls</span>
                                                                            <span class="file-author"><a href="#">Loren
                                                                                    Gatlin</a></span>
                                                                            <span class="file-date">May 31st at 6:53
                                                                                PM</span>
                                                                        </div>
                                                                        <ul class="files-action">
                                                                            <li class="dropdown dropdown-action">
                                                                                <a href="#" class="dropdown-toggle"
                                                                                    data-bs-toggle="dropdown"
                                                                                    aria-expanded="false"><i
                                                                                        class="material-icons">more_horiz</i></a>
                                                                                <div class="dropdown-menu">
                                                                                    <a class="dropdown-item"
                                                                                        href="javascript:void(0)">Download</a>
                                                                                    <a class="dropdown-item" href="#"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#share_files">Share</a>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="tab-pane" id="my_files">
                                                            <ul class="files-list">
                                                                <li>
                                                                    <div class="files-cont">
                                                                        <div class="file-type">
                                                                            <span class="files-icon"><i
                                                                                    class="fa fa-file-pdf-o"></i></span>
                                                                        </div>
                                                                        <div class="files-info">
                                                                            <span class="file-name text-ellipsis">AHA
                                                                                Selfcare Mobile Application
                                                                                Test-Cases.xls</span>
                                                                            <span class="file-author"><a href="#">John
                                                                                    Doe</a></span>
                                                                            <span class="file-date">May 31st at 6:53
                                                                                PM</span>
                                                                        </div>
                                                                        <ul class="files-action">
                                                                            <li class="dropdown dropdown-action">
                                                                                <a href="#" class="dropdown-toggle"
                                                                                    data-bs-toggle="dropdown"
                                                                                    aria-expanded="false"><i
                                                                                        class="material-icons">more_horiz</i></a>
                                                                                <div class="dropdown-menu">
                                                                                    <a class="dropdown-item"
                                                                                        href="javascript:void(0)">Download</a>
                                                                                    <a class="dropdown-item" href="#"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#share_files">Share</a>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>


    </div>
@endsection
@push('plugin-js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript">
        var oldscrollHeight = $("#bodyData").prop("scrollHeight");

        function loaddata() {
            $.ajax({
                url: "{{ route('employees.show-taskk') }}",
                type: "get",
                cache: false,
                dataType: 'json',
                success: function(dataResult) {
                    var resultData = dataResult.data;
                    var bodyData = '';
                    $.each(resultData, function(index, row) {
                        const today = new Date(row.created_at);
                        bodyData += "<div class='chat mt-1 chat-right'>" +
                            "<div class='chat-body'>" +
                            "<div class='chat-bubble'>" +
                            "<div class='chat-content'>" +
                            "<p>" + row.name + "</p>" +
                            "<span class='chat-time'>" + today.toDateString() + "</span>" +
                            "</div>" +
                            "</div>" +
                            "</div>"
                    });
                    $("#bodyData").html(bodyData);
                    var newscrollHeight = $("#bodyData").prop("scrollHeight");
                    if (newscrollHeight > oldscrollHeight) {
                        $("#bodyData").animate({
                            scrollTop: newscrollHeight
                        }, 'slow');
                    }
                }
            });
        }
        loaddata();
        $('#SubmitForm').on('submit', function(e) {
            e.preventDefault();
            let name = $('#InputName').val();
            let id = $('#InputId').val();
            let dataobj = {
                "_token": "{{ csrf_token() }}",
                name: name,
                id: id,
            };
            $.ajax({
                url: '{{ route('employees.daily.task.store') }}',
                type: "POST",
                data: dataobj,
                cache: false,
                success: function(response) {
                    loaddata();
                    $('#successMsg').show();
                    $('#InputName').val("");
                }
            });
        });
    </script>
@endpush
