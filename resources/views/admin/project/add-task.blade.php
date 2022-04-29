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
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Add Task</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Task</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.project.task.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <input type="hidden" name="tb_id" value="{{$tb_id}}">
                            <div class="form-group">
                                <label>Task Name</label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}">
                                <span class="text-danger">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label>Task Priority</label>
                                <select class="form-control select" name="priority">
                                    <option value="">Select</option>
                                    <option value="high">High</option>
                                    <option value="normal">Normal</option>
                                    <option value="low">Low</option>
                                </select>
                                <span class="text-danger">
                                    @error('priority')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label>Start Date</label>
                                <div class="cal-icon"><input class="form-control datetimepicker" value="{{old('start_date')}}" type="text"
                                        name="start_date"></div>
                                        <span class="text-danger">
                                            @error('start_date')
                                                {{ $message }}
                                            @enderror
                                        </span>
                            </div>
                            <div class="form-group">
                                <label>Due Date</label>
                                <div class="cal-icon"><input class="form-control datetimepicker"  value="{{old('due_date')}}" type="text"
                                        name="due_date"></div>
                                        <span class="text-danger">
                                            @error('due_date')
                                                {{ $message }}
                                            @enderror
                                        </span>
                            </div>
                            <div class="form-group">
                                <label>Task Followers</label>
                                <select class="select" multiple name="team[]">
                                    <option value="">Select Client</option>
                                    @foreach ($project->team()->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    @error('team')
                                        {{ $message }}
                                    @enderror
                                </span>
                                {{-- <div class="task-follower-list">
                                    @foreach ($project->team()->get() as $item)
                                        <span data-bs-toggle="tooltip" title="{{ $item->name }}">
                                            <img src="{{ asset('storage/uploads/' . $item->image) }}" class="avatar"
                                                alt="Project Team Member" width="20" height="20">
                                            <i class="fa fa-times deleteteam" data-pid="{{ $project->id }}"
                                                data-id="{{ $item->id }}"></i>
                                        </span>
                                    @endforeach
                                 
                                </div> --}}
                            </div>
                            <div class="col-sm-6">
                                <label for="statusinput" class="mb-4">Status</label>
                                <div class="col-md-12">
                                    <div class="form-check form-switch">
                                        <input class='input-switch' type="checkbox" value="1" checked name="status"
                                            id="demo" />
                                        <label class="label-switch" for="demo"></label>
                                        <span class="info-text"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section text-center">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
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
    <script>
        $(document).ready(function() {
            $(document).on("click", ".deleteteamu", function(e) {
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
                            var pid = $(this).data("pid");
                            var url = "{{ route('admin.project.delete.team.member') }}";
                            var id = {
                                "_token": "{{ csrf_token() }}",
                                id: id,
                                pid: pid,
                            }
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: id,
                                cache: false,
                                success: function(res) {
                                    if (res.msg == 'no') {
                                        swal("unsuccessful! ", {
                                            icon: "error",
                                        })
                                    } else {
                                        swal("Success! Your Project File has been deleted!", {
                                            icon: "success",
                                        })
                                        $(yes).parent().hide(0500);

                                    }
                                }
                            });
                        }
                    });
            })
        });
    </script>
@endpush
