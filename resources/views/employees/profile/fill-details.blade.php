{{-- @extends('layouts.app') --}}
{{-- @push('css') --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title>Scrum Digital - HRMS</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
    .stt{
    min-height: 325px;
    left: -110px;
        }
        a.disabled {
            pointer-events: none;
            cursor: default;
        }

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
</head>

<body>
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left">
                <a href="{{ route('dashboard') }}" class="logo">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="">
                </a>
            </div>
            <div class="page-title-box">
            </div>
            <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
            <ul class="nav user-menu">
                <li class="nav-item dropdown flag-nav">
                    <a class="nav-link disabled">
                        <img src="{{ asset('assets/img/flags/us.png') }}" alt="" height="20"> <span>India</span>
                    </a>
                </li>
                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <span class="user-img"><img
                                src="@if(Auth::guard('web')->user()->image!= NULL){{ asset('storage/uploads/' . Auth::guard('web')->user()->image) }}@else{{ asset('assets/img/avtar.jpg')}}@endif" alt="">
                            <span class="status online"></span></span>
                        <span> {{ Auth::guard('web')->user()->name }}</span>
                    </a>
                    <div class="dropdown-menu">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class=" dropdown-item" type="submit">
                                Log Out
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <div class="page-wrapper stt">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Personal Information</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Complete or Verify Your Details</li>
                            </ul>
                        </div>
                        <div class="col-auto float-end ms-auto">
                            <h4 class="page-title">Joining Date</h4>
                            <span><b>{{\Carbon\Carbon::parse($employees->joiningDate)->format('d F Y')}}</b></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('fill.data.store') }}" enctype="multipart/form-data"
                                method="POST">
                                @csrf
                                <input type="text" hidden
                                    value="@if (isset($employees)) {{ $employees->id }} @endif" name="id">
                                <div class="row">
                                    @if($employees->image != NULL)
                                        <div class="col-md-12 text-center">
                                            <span class="avatar" style="width: 100px; height: 100px">
                                                <img src="{{ asset('storage/uploads/' . $employees->image) }}">
                                            </span>
                                        </div>
                                    @endisset
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">First Name <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" name="first_name" type="text"
                                                value="@if (isset($employees)){{$employees->first_name }}@endif">
                                            <span class="text-danger">
                                                @error('first_name')
                                                    <p>First Name field is required.</p>
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Last Name</label>
                                            <input class="form-control" name="last_name" type="text"
                                                value="@if(isset($employees)){{ $employees->last_name}}@endif">
                                            <span class="text-danger">
                                                @error('last_name')
                                                    <p>Last Name field is required.</p>
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select class="select form-control" name="gender">
                                                <option value="">Selected Gender</option>
                                                <option value="m"@if(isset($employees) && $employees->gender == 'm')selected @endif>Male
                                                </option>
                                                <option value="f"@if (isset($employees) && $employees->gender == 'f')selected @endif>
                                                    Female
                                                </option>
                                            </select>
                                            <span class="text-danger">
                                                @error('gender')
                                                    <p>Employee Gender field is required.</p>
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Birth Date</label>
                                            <div class="">
                                                <input type="date" class="form-control" name="dob"
                                                    value="@if(isset($employees) && $employees->dob != NULL){{\Carbon\Carbon::parse($employees->dob)->format('Y-m-d')}}@endif" max="{{ \Carbon\Carbon::now()->subMonths(216)->toDateString() }}">
                                                <span class="text-danger">
                                                    @error('dob')
                                                        <p>Employee Birth Date field is required.</p>
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label" for="emp">Employee ID</label>
                                        <div class="input-group">
                                            <input type="text" readonly class="form-control"
                                                id="emp"
                                                value="@if(isset($employees)){{$employees->employeeID}}@endif">
                                        </div>
                                        <span class="text-danger">
                                            @error('employeeID')
                                                <p>Employee ID field is required.</p>
                                            @enderror
                                        </span>
                                        <div id="empt">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Email <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="email" id="email" readonly
                                                value="@if(isset($employees)){{$employees->email}}@endif" style="text-transform: none;">
                                            <span class="text-danger">
                                                @error('email')
                                                    <p>Email ID field is required.</p>
                                                @enderror
                                            </span>
                                        </div>
                                        <div id="emailerror">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Phone </label>
                                            <input class="form-control phone" name="phone" type="text" maxlength="10"
                                                pattern="[1-9]{1}[0-9]{9}"
                                                value="@if(isset($employees)){{$employees->phone}}@endif">
                                            <span class="text-danger">
                                                @error('phone')
                                                    <p>Phone field is required.</p>
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Address</label>
                                            <input class="form-control"
                                                value="@if (isset($employees)){{$employees->address}}@endif"
                                                name="address" type="text">
                                            <span class="text-danger">
                                                @error('address')
                                                    <p>Address field is required.</p>
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Country <span
                                                    class="text-danger">*</span></label>
                                            <select class="select" name="country_id" class="form-control"
                                                id="inputcountry" onkeypress="country()">
                                                <option value="">Select Country</option>
                                                @foreach ($count as $item)
                                                    <option @if(isset($employees) && $employees->country_id == $item->id)selected @endif
                                                        value="{{$item->id}}">
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error('country_id')
                                                    <p>Country field is required.</p>
                                                @enderror
                                            </span>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">State <span
                                                    class="text-danger">*</span></label>
                                            <select class="select" name="state_id" id="inputstate">
                                                <option value="">Select State</option>
                                            </select>
                                            <span class="text-danger">
                                                @error('state_id')
                                                    <p>State field is required.</p>
                                                @enderror
                                            </span>
                                            @isset($employees)
                                                <input type="hidden" value="{{$employees->state_id }}" id="EditState">
                                            @endisset
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">City <span
                                                    class="text-danger">*</span></label>
                                            <select class="select" name="city_id" id="inputcity">
                                                <option value="">Select City</option>
                                            </select>
                                            <span class="text-danger">
                                                @error('city_id')
                                                    <p>City field is required.</p>
                                                @enderror
                                            </span>
                                            @isset($employees)
                                                <input type="hidden" value="{{$employees->city_id}}" id="Editcity">
                                            @endisset
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Pin Code</label>
                                            <input type="text" name="pincode" class="form-control"
                                                value="@if(isset($employees)){{$employees->pinCode}}@endif">
                                            <span class="text-danger">
                                                @error('pincode')
                                                    <p>Pin Code field is required.</p>
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Update Profile Photo</label>
                                            <input name="image" class="form-control" value="" type="file">
                                            <span class="text-danger">
                                                @error('image')
                                                    <p>Photo field is required.</p>
                                                @enderror
                                            </span>
                                        </div>
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
    </div>
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript">
        $('.phone').keypress(function(e) {
            var arr = [];
            var kk = e.which;

            for (i = 48; i < 58; i++)
                arr.push(i);

            if (!(arr.indexOf(kk) >= 0))
                e.preventDefault();
        });

        function states() {
            var contid = document.getElementById("inputcountry");
            var id = $('#inputcountry').val();
            var url = "{{ route('state.name') }}";
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
                    let selected = ''
                    $.each(res.state, function(key, val) {
                        if ($(document).find("#EditState").length > 0 && $("#EditState").val() == val
                            .id) {
                            selected = 'selected';
                        } else {
                            selected = '';
                        }
                        data += '<option ' + selected + ' value="' + val.id + '">' + val.name +
                            '</option>';
                    });
                    $("#inputstate").html(data);
                    cities();
                }
            })
        }
        function cities() {
            var id = $("#inputstate").val();
            var url = "{{ route('state.city.name') }}"
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
                    var selected = ''
                    $.each(res.city, function(key, val) {
                        if ($(document).find("#Editcity").length > 0 && $("#Editcity").val() == val
                            .id) {
                            selected = 'selected';
                        } else {
                            selected = '';
                        }
                        data += '<option ' + selected + ' value="' + val.id + '">' + val.name +
                            '</option>';
                    });
                    $("#inputcity").html(data);
                }
            });
        }
        states();
        document.getElementById("inputcountry").onchange = function() {
            states();
        };
        document.getElementById("inputstate").onchange = () => {
            cities();
        };
    </script>
</body>
</html>
