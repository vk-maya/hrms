@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">

    <style>
        .chat-content-wrap .chat-wrap-inner #bodyData {
            overflow: auto;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .chat-contents .chat-content-wrap .chats .chat-right {
            width: 100%;
            float: right;
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
                                    </div>
                                    <div class="user-info float-start">
                                        <span title="Mike Litorus">{{ Auth::guard('admin')->user()->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-contents">
                            <div class="chat-content-wrap">
                                <div class="chat-wrap-inner">
                                    <div class="chat-box">
                                        <div class="chats">
                                            <div id="bodyData">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="checklog" value="{{ Auth::guard('admin')->check() }}">
                        <div class="chat-footer">
                            <div class="message-bar">
                                <div class="message-inner">
                                    <a class="link attach-icon" href="#" data-bs-toggle="modal"
                                        data-bs-target="#drag_files"><img src="" alt=""></a>
                                    <div class="message-area">
                                        <form id="SubmitForm">
                                            <div class="input-group">
                                                @csrf
                                                <input type="hidden" id="InputId"
                                                    value="{{ Auth::guard('admin')->user()->id }}">
                                                <input id="InputName" class="form-control task-textarea" value=""
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
                url: "{{ route('admin.show-task') }}",
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
                url: '{{ route('admin.daily.task.store') }}',
                type: "POST",
                data: dataobj,
                cache: false,
                success: function(response) {
                    loaddata();
                    $('#InputName').val("");
                }
            });
        });
    </script>
@endpush
