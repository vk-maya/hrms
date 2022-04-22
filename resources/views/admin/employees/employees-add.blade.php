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
                        <h3 class="page-title">Add Employee</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Employee</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.storeemployees') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <input type="text" hidden
                                value="@if (isset($employees)) {{ $employees->id }} @endif" name="id">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">First Name <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" name="name" type="text"
                                            value="@if (isset($employees)) {{ $employees->name }} @endif {{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Last Name</label>
                                        <input class="form-control" name="last_name" type="text"
                                            value="@if (isset($employees)) {{ $employees->last_name }} @endif {{ old('last_name') }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Employee ID <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="employee_id" class="form-control" id="emp"
                                            value="SDC-EMP-{{$empid+1}}@if (isset($employees)){{ $employees->employee_id }} @endif{{ old('employee_id')}}"
                                            onkeypress="empl()">
                                    </div>
                                    <div id="empt">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                        <input class="form-control" name="email" type="email" id="email"
                                            value="@if (isset($employees)) {{ $employees->email }} @endif"
                                            {{ old('email') }} onkeypress="emaill()">
                                    </div>
                                    <div id="emailerror">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Password</label>
                                        <input class="form-control" name="password" type="password">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Confirm Password</label>
                                        <input class="form-control" name="password_repeat" type="password">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Phone </label>
                                        <input class="form-control" name="phone" type="text"
                                            value="@if (isset($employees)) {{ $employees->phone }} @endif {{ old('phone') }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Address</label>
                                        <input class="form-control"
                                            value="@if (isset($employees)) {{ $employees->address }} @endif {{ old('address') }}"
                                            name="address" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Country <span class="text-danger">*</span></label>
                                        <select class="select" name="country_id" class="form-control"
                                            id="inputcountry" onkeypress="country()">
                                            <option value="">Select Country</option>
                                            @foreach ($count as $item)
                                                <option value="{{ $item->id }} {{ old('country') }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">State <span class="text-danger">*</span></label>
                                        <select class="select" name="state_id" id="inputstate" onkeypress="city()">
                                            <option value="">Select State</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">City <span class="text-danger">*</span></label>
                                        <select class="select" name="city_id" id="inputcity">
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Department <span
                                                class="text-danger">*</span></label>
                                        <select class="select" name="department_id" class="form-control"
                                            id="inputDepartment" onkeypress="indepartment()">
                                            <option> Select Department </option>
                                            @foreach ($department as $item)
                                                <option @if (isset($employees) && $employees->department_id == $item->id) selected @endif
                                                    value="{{ $item->id }} {{ old('department_id') }}">
                                                    {{ $item->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Designation <span
                                                class="text-danger">*</span></label>
                                        <select class="select" name="designation_id" id="inputDesignation">
                                            <option value="{{ old('designation_id') }}">Select Designation</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Joining Date <span
                                                class="text-danger">*</span></label>
                                        <div class="cal-icon"><input name="joining_date"
                                                class="form-control datetimepicker"
                                                value="@if (isset($employees)) {{ date('d/m/Y', strtotime($employees->joining_date)) }} @endif {{ old('joining_date') }}"
                                                type="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="statusinput" class="mb-4">Status</label>
                                    <div class="col-md-12">
                                        <div class="form-check form-switch">
                                            <input class='input-switch' type="checkbox"
                                                value="@if (isset($employees)) {{ $employees->status }} @endif 1"
                                                @if (isset($employees)) @if ($employees->status == 0) @else checked @endif
                                                @endif checked
                                            name="status" id="demo" />
                                            <label class="label-switch" for="demo"></label>
                                            <span class="info-text"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group ml-2">
                                        <label class="col-form-label">Work Place</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" title="Work From Office"
                                                    @if (isset($employees)) @if ($employees->workplace == 'wfo')checked @endif
                                                    @endif
                                                name="workplace" id="wfo" value="wfo{{ old('workplace') }}">
                                                <label class="form-check-label" title="Work From Office"
                                                    for="wfo">WFO</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" title="Work From House" type="radio"
                                                    name="workplace" id="wfh"
                                                    @if (isset($employees)) @if ($employees->workplace == 'wfh') checked @endif
                                                    @endif
                                                value="wfh{{ old('workplace') }}">
                                                <label class="form-check-label" title="Work From House"
                                                    for="wfh">WFH</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" title="Work From House" type="radio"
                                                    name="workplace" id="both"
                                                    @if (isset($employees)) @if ($employees->workplace == 'both') checked @endif
                                                    @endif
                                                value=" both{{ old('workplace') }}">
                                                <label class="form-check-label" title="Both" for="both">both</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"></label>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                                @isset($employees)
                                    <div class="profile-img">
                                        <a href="" class="">
                                            <img src="{{ asset('storage/uploads/' . $employees->image) }}" alt=""></a>
                                    </div>
                                @endisset
                                <div class="form-group">
                                    <label>Upload Photo</label>
                                    <input name="image" class="form-control" value="" type="file">
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                                </div>
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
