@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">


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
                        <h3 class="page-title">Add Project</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Project</li>
                        </ul>
                    </div>
                </div>
            </div>
            @isset($project)
                {{ $project }}
            @endisset
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.project.store') }}" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                @csrf
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputname">Project Name</label>
                                        <input id="inputname" name="name"
                                            value="@if (isset($project)) {{ $project->name }}@else{{ old('name') }} @endif"
                                            class="form-control" type="text">
                                        <span class="text-danger">
                                            @error('name')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Client</label>
                                        <select class="select" name="clientname">
                                            <option>Select Client</option>
                                            @foreach ($client as $item)
                                                <option @if (isset($project) && $project->client_id == $item->id) ) selected @endif
                                                    value="{{ $item->id }}">{{ $item->company }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('clientname')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker"
                                                value="@if (isset($project)) {{ date('d/m/Y', strtotime($project->start_date)) }} @endif {{ old('start_date') }}"
                                                name="start_date" type="text">
                                            <span class="text-danger">
                                                @error('start_date')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" name="end_date"
                                                value="@if (isset($project)) {{ date('d/m/Y', strtotime($project->end_date)) }} @endif{{ old('end_date') }}"
                                                type="text">
                                            <span class="text-danger">
                                                @error('end_date')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Rate</label>
                                        <input placeholder="$50" name="rate"
                                            value="@if (isset($project)) {{ $project->rate }}@else{{ old('rate') }} @endif""
                                                                                        class="           form-control"
                                            type="text">
                                        <span class="text-danger">
                                            @error('rate')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <select class="select" name="duration">
                                            <option>Select Duration</option>
                                            <option @if (isset($project) && $project->duration == 'hour') selected @endif value="hour">Hourly
                                            </option>
                                            <option @if (isset($project) && $project->duration == 'fixed') selected @endif value="fixed">Fixed
                                            </option>
                                        </select>
                                        <span class="text-danger">
                                            @error('duration')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Priority</label>
                                        <select class="select" name="priority">
                                            <option>Select Priority </option>
                                            <option @if (isset($project) && $project->priority == 'high') selected @endif value="high">High
                                            </option>
                                            <option @if (isset($project) && $project->priority == 'medium') selected @endif value="medium">Medium
                                            </option>
                                            <option @if (isset($project) && $project->priority == 'low') selected @endif value="low">Low
                                            </option>
                                        </select>
                                        <span class="text-danger">
                                            @error('priority')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                {{-- <option @if (isset($client) && $client->country_id == $item->id) selected @endif value="{{ $item->id }}"> --}}
                                {{-- {{ $projectleader }} --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Add Project Leader</label>
                                        <select class="select" multiple name="teamlead[]">
                                            <option>Select Client</option>
                                            @foreach ($employeesc as $item)
                                                @isset($projectleader)
                                                    @foreach ($projectleader as $leader)
                                                    @endisset
                                                    <option @if (isset($projectleader) && $leader->leader_id == $item->id) selected @endif
                                                        value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @isset($projectleader)
                                                    @endforeach
                                                @endisset
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('teamlead[]')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Add Team</label>
                                        <select class="select" multiple name="team[]">
                                            <option>Select Client</option>
                                            @foreach ($employeesc as $item)
                                                @foreach ($projectteam as $team)
                                                    <option @if (isset($projectteam) && $team->team_id == $item->id) selected @endif
                                                        value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('team[]')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                {{-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Team Members</label>
                                        <div class="project-members">
                                            <a href="#" data-bs-toggle="tooltip" title="John Doe"
                                                class="avatar">
                                                <img src="assets/img/profiles/avatar-16.jpg" alt="">
                                            </a>
                                            <a href="#" data-bs-toggle="tooltip" title="Richard Miles"
                                                class="avatar">
                                                <img src="assets/img/profiles/avatar-09.jpg" alt="">
                                            </a>
                                            <a href="#" data-bs-toggle="tooltip" title="John Smith"
                                                class="avatar">
                                                <img src="assets/img/profiles/avatar-10.jpg" alt="">
                                            </a>
                                            <a href="#" data-bs-toggle="tooltip" title="Mike Litorus"
                                                class="avatar">
                                                <img src="assets/img/profiles/avatar-05.jpg" alt="">
                                            </a>
                                            <span class="all-team">+2</span>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea id="editor" name="description" id="" cols="3" rows="2">
                                                                @isset($project)
{!! $project->description !!}
@endisset
                                                                </textarea>
                                <span class="text-danger">
                                    @error('description')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label>Upload Files</label>
                                <input class="form-control" name="image[]" multiple type="file">
                            </div>
                            <span class="text-danger">
                                @error('image')
                                    {{ $message }}
                                @enderror
                            </span>
                            <div class="col-md-6">
                                <label for="statusinput" class="mb-4">Status</label>
                                <div class="col-md-12">
                                    <div class="form-check form-switch">
                                        <input class='input-switch' type="checkbox" value="1" checked name="status"
                                            id="demo" />
                                        <label class="label-switch" for="demo"></label>
                                        <span class="info-text"></span>
                                        <span class="text-danger">
                                            @error('status')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>
                            {{ $project->id }}

                            @isset($projectimage)
                                {{-- {{ $projectimage }} --}}
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title m-b-20">Uploaded image files</h5>
                                        <div class="row">
                                            @foreach ($projectimage as $img)
                                                <div class="col-md-3 col-sm-4 col-lg-4 col-xl-2">
                                                    <div class="uploaded-box">
                                                        <div class="uploaded-img">
                                                            <img alt="" src="{{ asset('storage/project/' . $img->image) }}">
                                                        </div>
                                                        <div class="uploaded-img-name">

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endisset
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
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
    <script src="{{ asset('assets/js/ckeditor.js') }}"></script>

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
