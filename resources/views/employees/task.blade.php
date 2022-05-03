@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="chat-main-row">
            <div class="chat-main-wrapper">
                <div class="col-lg-7 message-view task-view task-left-sidebar">
                    <div class="chat-window">
                        <div class="fixed-header">
                            <div class="navbar">
                                <div class="float-start me-auto">
                                    <div class="">
                                        <span class="">
                                            Task Board
                                        </span>
                                    </div>
                                </div>
                                <a class="task-chat profile-rightbar float-end" id="task_chat" href="#task_window"><i
                                        class="fa fa fa-comment"></i></a>
                            </div>
                        </div>
                        <div class="chat-contents">
                            <div class="chat-content-wrap">
                                <div class="chat-wrap-inner">
                                    <div class="chat-box">
                                        <div class="task-wrapper">
                                            <div class="task-list-container">
                                                <div class="task-list-body">
                                                    @foreach ($task as $item)
                                                        <ul id="task-list">
                                                            <li class="task">
                                                                <div class="task-container">
                                                                    <b>{{ $item->projectDetails->name }}</b><br>
                                                                    <b> Due Date:</b>
                                                                    {{ $item->projectDetails->end_date }}
                                                                </div>
                                                                @if ($item->taskDetails->status == 1)
                                                                    <div class="task-container">
                                                                        <span class="task-action-btn task-check ">
                                                                            <span
                                                                                class="action-circle large complete-btn bg-warning"
                                                                                title="Mark Complete">
                                                                                <i class="material-icons ok"
                                                                                    data-id="{{ $item->taskDetails->id }}">check</i>
                                                                            </span>
                                                                        </span>
                                                                        <span class="task-label">
                                                                            {{ $item->taskDetails->name }}
                                                                        </span>
                                                                        <span class="task-action-btn task-btn-right">
                                                                            <form
                                                                                action="{{ route('employees.task.status') }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <div class="row">
                                                                                    <div class="col-md-10 ">
                                                                                        <input type="hidden" name="task_id"
                                                                                            value="{{ $item->taskDetails->id }}">
                                                                                        <input placeholder="Task Status"
                                                                                            name="report"></input>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <button
                                                                                            class="btn btn-success btn-sm">save</button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </span>
                                                                    </div>
                                                                @else
                                                                    <div class="task-container">
                                                                        <span class="task-action-btn task-check">
                                                                            <span
                                                                                class="action-circle large complete-btn bg-success"
                                                                                title="Mark Complete">
                                                                                <i class="material-icons ">check</i>
                                                                            </span>
                                                                        </span>
                                                                        <span class="task-label">
                                                                            {{ $item->taskDetails->name }}
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    @endforeach
                                                </div>
                                            </div>
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
                                    <a class="" id="task_complete" href="javascript:void(0);">

                                    </a>
                                </div>
                                <ul class="nav float-end custom-menu">
                                    <li class="dropdown dropdown-action">
                                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="chat-contents task-chat-contents">
                            <div class="chat-content-wrap">
                                <div class="chat-wrap-inner">
                                    <div class="chat-box">
                                        @foreach ($task as $item)
                                            {{-- {{$item->taskDetails->assigned->name}} --}}
                                            @if ($item->taskDetails->status == 1)
                                                <div class="chats">
                                                    <h5>Project Name: <b> {{ $item->projectDetails->name }}</b></h5>
                                                    <div class="task-header">
                                                        <div class="assignee-info">
                                                            <div class="avatar">
                                                                <img alt="" src="{{asset('assets/uploads',$item->taskDetails->assigned->image)}}" alt="Assigned Pic">

                                                            </div>
                                                            <div class="assigned-info">
                                                                <div class="task-head-title">Assigned To</div>
                                                                <div class="task-assignee">
                                                                    {{ $item->taskDetails->assigned->name }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="task-due-date">
                                                            <div class="due-info">
                                                                <div class="task-head-title">Due Date</div>
                                                                <div class="due-date">
                                                                    {{ $item->taskDetails->end_date }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="task-line">
                                                    <div class="task-information">
                                                        <h5>Task Name: <b>{{ $item->taskDetails->name }}</b></h5>
                                                        <span class="task-info-line"><span class="task-info-subject">Created
                                                                Task: </span></span>
                                                        <div class="task-time">{{ $item->taskDetails->start_date }}
                                                        </div>
                                                    </div>
                                                    <div class="task-information">
                                                        <span class="task-info-line">
                                                            <span class="task-info-cont">
                                                                <h5>Task Priority:
                                                                    @if ($item->taskDetails->priority == 'high')
                                                                        <span
                                                                            class="task-priority badge bg-inverse-danger">High</span>
                                                                    @elseif($item->taskDetails->priority == 'normal')
                                                                        <span
                                                                            class="task-priority badge bg-inverse-warning">Normal</span>
                                                                    @else
                                                                        <span
                                                                            class="task-priority badge bg-inverse-info">Low</span>
                                                                    @endif
                                                                </h5>
                                                            </span>
                                                            <span class="task-info-cont">
                                                                <h5>Daily Task Report</h5>
                                                                @if ($item->taskDetails->status == 1)
                                                                    @foreach ($item->taskreport as $re)
                                                                        <ul>
                                                                            <li>{{ $re->report }} Report Date:
                                                                                {{ $re->created_at }}</li>
                                                                        </ul>
                                                                    @endforeach
                                                                @endif
                                                            </span>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
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
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $(document).on("click", ".ok", function() {
                var yes = $(this);
                swal({
                        title: "Are you sure?",
                        text: "Once Complete, you will not be able to recover this!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var id = $(this).data("id");
                            var url = "{{ route('employees.task-status-complete', ':id') }}";
                            url = url.replace(':id', id);
                            $.ajax({
                                type: "get",
                                url: url,
                                cache: false,
                                success: function(res) {
                                    if (!res.success) {
                                        swal("Success! Your Task has been Complete!", {
                                            icon: "success",
                                        })
                                    } else {
                                        swal("unsuccessful! ", {
                                            icon: "error",
                                        });
                                    }
                                    location.reload();
                                }
                            });
                        }
                    });
            })
        });
    </script>
@endpush
