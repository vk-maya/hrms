@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <style>
        .input-switch {
            display: none;
        }

        .label-switch {
            display: inline-block;
            position: relative;
        }

        .label-switch::before,
        .label-switch::after {
            content: "";
            display: inline-block;
            cursor: pointer;
            transition: all 0.5s;
        }

        .label-switch::before {
            width: 3em;
            height: 1em;
            border: 1px solid #757575;
            border-radius: 4em;
            background: #888888;
        }

        .label-switch::after {
            position: absolute;
            left: 0;
            top: -12%;
            width: 1.5em;
            height: 1.5em;
            border: 1px solid #757575;
            border-radius: 4em;
            background: #ffffff;
        }

        .input-switch:checked~.label-switch::before {
            background: #00a900;
            border-color: #008e00;
            margin-top: 2px;
        }

        .input-switch:checked~.label-switch::after {
            left: unset;
            right: 0;
            background: #00ce00;
            border-color: #009a00;
            /* margin-top: 4px; */
        }

        .info-text {
            display: inline-block;
        }

        .info-text::before {
            content: "Not active";
        }

        .input-switch:checked~.info-text::before {
            content: "Active";
        }

    </style>
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">{{ $project->name }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Task Board</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row board-view-header">
                <div class="col-4">
                    <div class="pro-teams">
                        <div class="pro-team-lead">
                            <h4>Lead</h4>
                            <div class="avatar-group">
                                @foreach ($project->leaders()->get() as $item)
                                    <div class="avatar">
                                        <img class="avatar-img rounded-circle border border-white"
                                            title="{{ $item->name }}" alt="User Image"
                                            src="{{ asset('storage/uploads/' . $item->image) }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="pro-team-members">
                            <h4>Team</h4>
                            <div class="avatar-group">
                                @foreach ($project->team()->get() as $item)
                                    <div class="avatar">
                                        <img class="avatar-img rounded-circle border  border-white"
                                            title="{{ $item->name }}" alt="User Image"
                                            src="{{ asset('storage/uploads/' . $item->image) }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8 text-end">
                    <a href="#" class="btn btn-white float-end ms-2" data-bs-toggle="modal"
                        data-bs-target="#add_task_board"><i class="fa fa-plus"></i> Create List</a>
                    <a href="project-view.html" class="btn btn-white float-end" title="View Board"><i
                            class="fa fa-link"></i></a>
                </div>
                <div class="col-12">
                    <div class="pro-progress">
                        <div class="pro-progress-bar">
                            <h4>Progress</h4>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 20%"></div>
                            </div>
                            <span>20%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kanban-board card mb-0">
                <div class="card-body">
                    <div class="kanban-cont">
                        @foreach ($project->TaskBoard as $tb)
                            <div class="kanban-list kanban-{{ $tb->tbcolor }}">
                                <div class="kanban-header">
                                    <span class="status-title">{{ $tb->name }}</span>
                                    <div class="dropdown kanban-action">
                                        <a href="#" data-bs-toggle="dropdown">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item edit" data-id="{{ $tb->id }}">Edit</a>
                                            <button class="dropdown-item deletetb" data-id="{{ $tb->id }}">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="kanban-wrap">
                                    @foreach ($project->Tasks as $tboard)
                                        <div class="card panel">
                                            @if ($tb->id == $tboard->tb_id)
                                                <div class="kanban-box">
                                                    <div class="task-board-header">
                                                        <span class="status-title"><a href="">{{ $tboard->name }}
                                                            </a></span>
                                                        <div class="dropdown kanban-task-action">
                                                            <a href="#" data-bs-toggle="dropdown">
                                                                <i class="fa fa-angle-down"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#edit_task_modal">Edit</a>
                                                                <button class="dropdown-item deletetask" data-id="{{$tboard->id}}" >Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="task-board-body">
                                                        <div class="kanban-info">
                                                            <div class="progress progress-xs">
                                                                <div class="progress-bar" role="progressbar"
                                                                    style="width: 20%" aria-valuenow="20" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                            <span>70%</span>
                                                        </div>
                                                        <div class="kanban-footer">
                                                            <span class="task-info-cont">
                                                                <span class="task-date"><i
                                                                        class="fa fa-clock-o"></i>{{ $tboard->end_date }}</span>

                                                                @if ($tboard->priority == 'high')
                                                                    <span
                                                                        class="task-priority badge bg-inverse-danger">High</span>
                                                                @elseif($tboard->priority == 'normal')
                                                                    <span
                                                                        class="task-priority badge bg-inverse-warning">Normal</span>
                                                                @else
                                                                    <span
                                                                        class="task-priority badge bg-inverse-warning">Low</span>
                                                                @endif

                                                            </span>
                                                            <span class="task-users">
                                                                @foreach ($tboard->task_followers as $item)
                                                                    <img src="{{ asset('storage/uploads/' . $item->image) }}"
                                                                        class="task-avatar" width="24" height="24"
                                                                        alt="">
                                                                @endforeach
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                    <div class="add-new-task">
                                        <a href="{{ route('admin.project.task.add', [$project->id, $tb->id]) }}"
                                            class="btn btn-success">Add
                                            New Task</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="add_task_board" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Task Board</h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.project.task.board.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Task Board Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group task-board-color">
                            <label>Task Board Color</label>
                            <div class="board-color-list">
                                <label class="board-control board-primary">
                                    <input type="radio" name="tbcolor" class="board-control-input" value="primary"
                                        checked="">
                                    <span class="board-indicator"></span>
                                </label>
                                <label class="board-control board-success">
                                    <input type="radio" name="tbcolor" class="board-control-input" value="success">
                                    <span class="board-indicator"></span>
                                </label>
                                <label class="board-control board-info">
                                    <input type="radio" name="tbcolor" class="board-control-input" value="info">
                                    <span class="board-indicator"></span>
                                </label>
                                <label class="board-control board-purple">
                                    <input type="radio" name="tbcolor" class="board-control-input" value="purple">
                                    <span class="board-indicator"></span>
                                </label>
                                <label class="board-control board-warning">
                                    <input type="radio" name="tbcolor" class="board-control-input" value="warning">
                                    <span class="board-indicator"></span>
                                </label>
                                <label class="board-control board-danger">
                                    <input type="radio" name="tbcolor" class="board-control-input" value="danger">
                                    <span class="board-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="statusinput" class="mb-4">Status</label>
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input class='input-switch' type="checkbox" value="1" checked name="status" id="demo" />
                                    <label class="label-switch" for="demo"></label>
                                    <span class="info-text"></span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <div class="m-t-20 text-center">
                            <button class="btn btn-primary btn-lg">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('plugin-js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $(document).on("click", ".deletetb", function(e) {
                e.preventDefault();
                var yes = $(this);
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var id = $(this).data("id");
                            var url = "{{ route('admin.project.delete.task.board', ':id') }}";
                            url = url.replace(':id', id);
                            $.ajax({
                                type: "GET",
                                url: url,
                                cache: false,
                                success: function(res) {
                                    if (res.msg == 'no') {
                                        swal("unsuccessful! Add This Other Task  ", {
                                            icon: "error",
                                        })
                                    } else {
                                        swal("Success! Your Project File has been deleted!", {
                                            icon: "success",
                                        })
                                        $(yes).parent().parent().parent().parent().hide(0500);

                                    }
                                }
                            });
                        }
                    });
            })
        });
        $(document).ready(function() {
            $(document).on("click", ".deletetask", function(e) {
                e.preventDefault();
                var yes = $(this);
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var id = $(this).data("id");
                            var url = "{{ route('admin.project.delete.task', ':id') }}";
                            url = url.replace(':id', id);
                            $.ajax({
                                type: "GET",
                                url: url,
                                cache: false,
                                success: function(res) {
                                    if (res.msg == 'no') {
                                        swal("unsuccessful! Add This Other Task  ", {
                                            icon: "error",
                                        })
                                    } else {
                                        swal("Success! Your Project File has been deleted!", {
                                            icon: "success",
                                        })
                                        $(yes).parent().parent().parent().parent().hide(0500);

                                    }
                                }
                            });
                        }
                    });
            })
        });
    </script>
@endpush
