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
                                            value="@if(isset($employees)){{$employees->name}}@else{{old('name')}}@endif">
                                        <span class="text-danger">
                                            @error('name')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Last Name</label>
                                        <input class="form-control" name="last_name" type="text"
                                            value="@if(isset($employees)){{ $employees->last_name }}@else{{ old('last_name') }}@endif">
                                        <span class="text-danger">
                                            @error('last_name')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label" for="emp">Employee ID</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend">SDC-EMP-</span>
                                        <input type="text" readonly class="form-control" name="employee_id" id="emp"
                                            value="@if(isset($employees)){{$employees->employee_id}}@else{{$empid}}@endif"
                                            onkeypress="empl()" aria-describedby="inputGroupPrepend">
                                    </div>
                                    <span class="text-danger">
                                        @error('employee_id')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                    <div id="empt">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                        <input class="form-control" name="email" type="email" id="email"
                                            value="@if(isset($employees)){{ $employees->email }}@else{{old('email')}}@endif"
                                            {{ old('email') }} onkeypress="emaill()">
                                        <span class="text-danger">
                                            @error('email')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div id="emailerror">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Password</label>
                                        <input class="form-control" name="password" type="password">
                                        <span class="text-danger">
                                            @error('password')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Confirm Password</label>
                                        <input class="form-control" name="password_confirmation" type="password">                                     
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Phone </label>
                                        <input class="form-control phone" name="phone" type="text" maxlength="10" pattern="[1-9]{1}[0-9]{9}"
                                            value="@if (isset($employees)){{ $employees->phone }}@else{{ old('phone') }}@endif">
                                    </div>
                                    <span class="text-danger">
                                        @error('phone')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Address</label>
                                        <input class="form-control"
                                            value="@if(isset($employees)){{ $employees->address }}@else{{old('address')}}@endif"
                                            name="address" type="text">
                                        <span class="text-danger">
                                            @error('address')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Country <span class="text-danger">*</span></label>
                                        <select class="select" name="country" class="form-control"
                                            id="inputcountry" onkeypress="country()">
                                            <option value="">Select Country</option>
                                            @foreach ($count as $item)
                                                <option @if (isset($employees) && $employees->country_id == $item->id) selected @endif value="{{ $item->id }} {{ old('country') }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('country')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                  
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">State <span class="text-danger">*</span></label>
                                        <select class="select" name="state" id="inputstate" >
                                            <option value="">Select State</option>
                                        </select>
                                        <span class="text-danger">
                                            @error('state')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                        @isset($employees)
                                            <input type="hidden" value="{{$employees->state_id}}" id="EditState">
                                        @endisset
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">City <span class="text-danger">*</span></label>
                                        <select class="select" name="city" id="inputcity">
                                            <option value="">Select City</option>
                                        </select>
                                        <span class="text-danger">
                                            @error('city')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                        @isset($employees)
                                        <input type="hidden" value="{{$employees->city_id}}" id="Editcity">                                            
                                        @endisset
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Department <span
                                                class="text-danger">*</span></label>
                                        <select class="select" name="department" class="form-control"
                                            id="inputDepartment" onkeypress="indepartment()">
                                            <option> Select Department </option>
                                            @foreach ($department as $item)
                                                <option @if (isset($employees) && $employees->department_id == $item->id) selected @endif
                                                    value="{{ $item->id }} {{ old('department_id') }}">
                                                    {{ $item->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('department')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                        @isset($employees)
                                        <input type="hidden" value="{{$employees->designation_id}}" id="editdesignation" >
                                        @endisset
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Designation <span
                                                class="text-danger">*</span></label>
                                        <select class="select" name="designation" id="inputDesignation">
                                            <option value="">Select Designation</option>
                                        </select>
                                        <span class="text-danger">
                                            @error('designation')
                                                {{ $message }}
                                            @enderror
                                        </span>
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
                                            <span class="text-danger">
                                                @error('joining_date')
                                                    {{ $message }}
                                                @enderror
                                            </span>
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
                                                    checked
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
                                @isset($employees)
                                    <div class="profile-img">
                                        <a href="" class="">
                                            <img src="{{ asset('storage/uploads/' . $employees->image) }}" alt=""></a>
                                    </div>
                                @endisset
                                <div class="form-group">
                                    <label>Upload Photo</label>
                                    <input name="image" class="form-control" value="" type="file">
                                    <span class="text-danger">
                                        @error('image')
                                            {{ $message }}
                                        @enderror
                                    </span>
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
  
        <script type="text/javascript">
            $('.phone').keypress(function(e) {
                var arr = [];
                var kk = e.which;
            
                for (i = 48; i < 58; i++)
                    arr.push(i);
            
                if (!(arr.indexOf(kk)>=0))
                    e.preventDefault();
            });
        </script>
    <script>

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

        function states() {
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
                    let selected = ''
                    $.each(res.state, function(key, val) {
                        if($(document).find("#EditState").length > 0 && $("#EditState").val()==val.id){
                            selected = 'selected';
                        }else{
                            selected = '';
                        }
                        data += '<option '+selected+' value="' + val.id + '">' + val.name + '</option>';
                    });
                    $("#inputstate").html(data);
                    cities();
                }
            })
        }  

        function cities() {
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
                    var selected = ''
                    $.each(res.city, function(key, val) {
                        if($(document).find("#Editcity").length > 0 && $("#Editcity").val()==val.id){
                            selected ='selected';
                        }else{
                            selected= '';
                        }
                        data += '<option '+selected+' value="' +val.id+ '">' + val.name + '</option>';
                    });
                    $("#inputcity").html(data);
                }
            });
        }
        
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
                    let selected = ''
                    $.each(desig.count, function(index, val) {
                        if($(document).find("#editdesignation").length > 0 && $("#editdesignation").val()==val.id){
                            selected = 'selected';
                        }else{
                            selected = '';
                        }
                        data += '<option '+selected+' value="' + val.id + '">' + val.designation_name + '</option>';
                    });
                    $("#inputDesignation").html(data);
                }

            })
        }
        document.getElementById("inputDepartment").onchange = function() {
            indepartment()
        };
        indepartment() 

             states(); 
        document.getElementById("inputcountry").onchange = function() {
            states();
        };
        document.getElementById("inputstate").onchange = () => {
            cities();
        };
    </script>
@endpush
