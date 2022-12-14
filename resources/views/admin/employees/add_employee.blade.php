@extends('admin.layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
<style>
    .error{
        color: red;
    }
</style>
@endpush
    @section('content')
        <div class="page-wrapper ttt">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Add Employee</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('admin.employees') }}">Employees</a></li>
                                <li class="breadcrumb-item active">Add Employee</li>
                            </ul>
                        </div>
                        @isset($employee)
                        <div class="col-auto float-end ms-auto">
                            <a href="{{ route('admin.employees.information', $employee->id) }}" class="btn add-btn"><i class="fa fa-plus"></i> Add More Info</a>
                        </div>
                        @endisset
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.store.employee') }}" enctype="multipart/form-data" method="POST" id="regForm">
                                @csrf
                                    @if (isset($employee))
                                        <input type="text" hidden value="{{$employee->id}}" name="id">
                                    @endif
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                        <input class="form-control" required name="first_name" type="text" value="@if(isset($employee)) {{ $employee->first_name }}@else{{ old('first_name') }}@endif">
                                        <span class="text-danger">
                                            @error('first_name')
                                            <p>First Name field is required.</p>
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                            <label class="col-form-label">Last Name</label>
                                            <input class="form-control" name="last_name" type="text" value="@if(isset($employee)) {{ $employee->last_name }}@else{{ old('last_name') }}@endif">
                                            <span class="text-danger">
                                                @error('last_name')
                                                <p>Last Name field is required.</p>
                                                @enderror
                                            </span>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <label class="col-form-label">Gender</label>
                                        <select class="select form-control" name="gender">
                                            <option value="">Selected Gender</option>
                                            <option value="m" @if (isset($employee) && $employee->gender == 'm') selected @endif>Male
                                            </option>
                                            <option value="f" @if (isset($employee) && $employee->gender == 'f') selected @endif>Female
                                            </option>
                                        </select>
                                        <span class="text-danger">
                                            @error('gender')
                                            <p>Employee Gender is required.</p>
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <label class="col-form-label">Birth Date</label>
                                        <div class="">
                                            <input type="date" class="form-control" name="dob" max="{{ \Carbon\Carbon::now()->subMonths(216)->toDateString() }}" value="@if(isset($employee) && $employee->dob != NULL){{\Carbon\Carbon::parse($employee->dob)->format('Y-m-d')}}@endif">
                                            <span class="text-danger">
                                                @error('dob')
                                                <p>Valid Employee Birth Date is required.</p>
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <label class="col-form-label" for="emp">Employee ID</label>
                                        <div class="input-group">
                                            @if (!isset($employee))
                                            <span class="input-group-text" id="inputGroupPrepend">SDPL-JAI-</span>
                                            @endif
                                            <input type="text" readonly class="form-control" id="emp" value="@if (isset($employee)){{$employee->employeeID}}@else{{$empid}} @endif">
                                        </div>
                                        <span class="text-danger">
                                            @error('employeeID')
                                            <p>Employee ID is required.</p>
                                            @enderror
                                        </span>

                                        <div id="empt">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <label class="col-form-label" for="machine">Machine ID</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="inputGroupPrepend">Mac-ID-</span>
                                            <input type="text" class="form-control" name="machineID" id="machine" value="@if (isset($employee)){{$employee->machineID}}@endif" placeholder="Enter Machine ID">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <label class="col-form-label">Phone </label>
                                        <input class="form-control phone" name="phone" type="text" maxlength="10" pattern="[1-9]{1}[0-9]{9}" value="@if(isset($employee)){{$employee->phone}}@else{{old('phone')}}@endif">
                                        <span class="text-danger">
                                            @error('phone')
                                            <p>Phone is required.</p>
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                        <input class="form-control" required name="email" type="email" id="email" value="@if(isset($employee)){{$employee->email}}@else{{ old('email') }}@endif" {{ old('email') }} onkeypress="emaill()">
                                        <span class="text-danger">
                                            @error('email')
                                            <p>Email ID is required.</p>
                                            @enderror
                                        </span>
                                        <div id="emailerror">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <label class="col-form-label">Password<span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input class="form-control" required type="password" name="password" value="" id="password">
                                            <span class="text-danger">
                                                @error('password')
                                                <p>Password required.</p>
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <label class="col-form-label">Confirm Password<span class="text-danger">*</span></label>
                                        <input class="form-control" required name="password_confirmation" type="password">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <label class="col-form-label">Address</label>
                                        <input class="form-control" value="@if(isset($employee)){{$employee->address}}@else{{old('address')}}@endif" name="address" type="text">
                                        <span class="text-danger">
                                            @error('address')
                                            <p>Address is required.</p>
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <label class="col-form-label">Country </label>
                                        <select name="country_id" class="form-control select2" id="inputcountry" onkeypress="country()">
                                            <option value="">Select Country</option>
                                            @foreach ($country as $item)
                                            <option @if(isset($employee) && $employee->country_id == $item->id) selected @endif
                                                value="{{$item->id}}{{old('country')}}">
                                                {{ $item->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('country_id')
                                            <p>Country is required.</p>
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <label class="col-form-label">State </label>
                                        <select class="form-control select2" name="state_id" id="inputstate">
                                            <option value="">Select State</option>
                                        </select>
                                        <span class="text-danger">
                                            @error('state_id')
                                            <p>State is required.</p>
                                            @enderror
                                        </span>
                                        @isset($employee)
                                        <input type="hidden" value="{{$employee->state_id}}" id="EditState">
                                        @endisset
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <label class="col-form-label">City </label>
                                        <select class="form-control select2" name="city_id" id="inputcity">
                                            <option value="">Select City</option>
                                        </select>
                                        <span class="text-danger">
                                            @error('city_id')
                                            <p>City is required.</p>
                                            @enderror
                                        </span>
                                        @isset($employee)
                                        <input type="hidden" value="{{$employee->city_id}}" id="Editcity">
                                        @endisset
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <div class="form-group">
                                            <label class="col-form-label">Pin Code</label>
                                            <input type="text" name="pincode" class="form-control" value="@if(isset($employee)){{$employee->pinCode}}@else{{old('pincode')}}@endif">
                                            <span class="text-danger">
                                                @error('pincode')
                                                <p>Pin Code is required.</p>
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group ">
                                        <div class="form-group">
                                            <label class="col-form-label">Joining Date <span class="text-danger">*</span></label>
                                            <div class="">
                                                @if (isset($employee))
                                                <input type="text" required readonly class="form-control" value="{{\Carbon\Carbon::parse($employee->joiningDate)->format('d-m-Y')}}">
                                                @else
                                                <input name="joiningDate" class="form-control" type="date" max="{{ \Carbon\Carbon::now()->toDateString() }}">
                                                @endif
                                                <span class="text-danger">
                                                    @error('joiningDate')
                                                    <p>Joining Date is required.</p>
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <div class="form-group">
                                            <label class="col-form-label">Department <span class="text-danger">*</span></label>
                                            <select class="select" name="department_id" required class="form-control" id="inputDepartment" onkeypress="indepartment()">
                                                <option value="" disabled selected> Select Department </option>
                                                @foreach ($department as $item)
                                                <option @if(isset($employee) && $employee->department_id == $item->id) selected @endif
                                                    value="{{$item->id}}">
                                                    {{$item->department_name}}
                                                </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error('department_id')
                                                <p>Department is required.</p>
                                                @enderror
                                            </span>
                                            @isset($employee)
                                            <input type="hidden" value="{{$employee->designation_id}}" id="editdesignation">
                                            @endisset
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 marker:form-group">
                                        <div class="form-group">
                                            <label class="col-form-label">Designation <span class="text-danger">*</span></label>
                                            <select class="select" required name="designation_id" id="inputDesignation">
                                                <option value="">Select Designation</option>
                                            </select>
                                            <span class="text-danger">
                                                @error('designation_id')
                                                <p>Designation is required.</p>
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <label for="statusinput" class="mb-3">Status</label>
                                        <div class="col-md-12">
                                            <div class="form-check form-switch d-flex align-items-center p-0">
                                                <input class='input-switch' checked type="checkbox" value="1" @if (isset($employee)) @if($employee->status == 0) @else checked @endif
                                                @endif
                                                name="status" id="demo" />
                                                <label class="label-switch" for="demo"></label>
                                                <span class="info-text"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <label>Upload Profile Photo</label>
                                        <input name="image" class="form-control" value="" type="file">
                                        <span class="text-danger">
                                            @error('image')
                                            <p>Photo is required.</p>
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group">
                                        <label>Attach Employees Document</label>
                                        <input name="files[]" class="form-control" value="" type="file" multiple>
                                        <span class="text-danger">
                                            @error('image')
                                            <p>Photo is required.</p>
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-lg-4 col-md-5 col-sm-6 form-group">
                                        <div class="form-group ml-2">
                                            <label class="col-form-label">Work Place</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" title="Work From Office" checked @if (isset($employee)) @if($employee->workplace == 'wfo')checked @endif
                                                    @endif
                                                    name="workplace" id="wfo" value="wfo">
                                                    <label class="form-check-label" title="Work From Office" for="wfo">WFO</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" title="Work From House" type="radio" name="workplace" id="wfh" @if (isset($employee)) @if($employee->workplace == 'wfh') checked @endif
                                                    @endif
                                                    value="wfh">
                                                    <label class="form-check-label" title="Work From House" for="wfh">WFH</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" title="Work From House" type="radio" name="workplace" id="both" @if (isset($employee)) @if($employee->workplace == 'both') checked @endif
                                                    @endif
                                                    value=" both">
                                                    <label class="form-check-label" title="Both" for="both">both</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    @if (isset($employee) && $employee->image != '')
                                        <div class="profile-img">
                                            <a href="" class="avatar">
                                                <img src="{{asset('storage/uploads/' . $employee->image)}}" alt=""></a>
                                        </div>
                                    @endisset
                                    <hr>
                                    <div class="row">
                                        <h3 class="mb-2">Salary Earning And Deductions</h3>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="ftr-list">
                                                <h3>Earning</h3>
                                                @foreach ($salared as $item)
                                                @if ($item->salarymanag->type == 'earning')
                                                <div class="accent-chek">
                                                    <label class="checkbox-inline"><input @if(isset($user_salary) && in_array($item->id,$user_salary->toArray())) checked @endif type="checkbox" value="{{$item->id}}" name="earning[]" class="days recurring me-3"
                                                        ></label><span class="checkmark">{{$item->salarymanag->title}}</span>
                                                </div>
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="ftr-list">
                                                <h3>Deductions</h3>
                                                @foreach ($salared as $item)
                                                @if ($item->salarymanag->type == 'deduction')
                                                <div class="accent-chek">
                                                    <label class="checkbox-inline"><input @if(isset($user_salary)&& in_array($item->id,$user_salary->toArray()))
                                                        checked @endif type="checkbox"
                                                        value="{{$item->id}}" name="earning[]" class="days recurring me-3"
                                                        ><span class="checkmark">{{$item->salarymanag->title}}</span></label>
                                                </div>
                                                @endif
                                                @endforeach


                                            </div>
                                        </div>
                                    </div>                                   
                                    <div class="text-center mt-3">
                                        <button class="btn btn-success" type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@push('plugin-js')  
<script>
    $(document).ready(function() {
        $("#regForm").validate({
            rules: {
                first_name: "required",
                password: "required",
                joiningDate: "required",
                department_id: "required",
                designation_id: "required",
                confirmPassword: "required",
                email: "required",                  
            }
        });
    }); 
</script> 
    <script type="text/javascript">
        $('.phone').keypress(function(e) {
            var arr = [];
            var kk = e.which;

            for (i = 48; i < 58; i++)
                arr.push(i);

            if (!(arr.indexOf(kk) >= 0))
                e.preventDefault();
        });
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script>
        $(document).getElementById("email").onchange = function() {
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
        $(document).getElementById("emp").onchange = function() {
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
                        if ($(document).find("#editdesignation").length > 0 && $("#editdesignation")
                            .val() == val.id) {
                            selected = 'selected';
                        } else {
                            selected = '';
                        }
                        data += '<option ' + selected + ' value="' + val.id + '">' + val
                            .designation_name + '</option>';
                    });
                    $("#inputDesignation").html(data);
                }

            })
        }
        $.(document).getElementById("inputDepartment").onchange = function() {
            indepartment()
        };
        indepartment()
        states();
        $.(document).getElementById("inputcountry").onchange = function() {
            states();
        };
        $.(document).getElementById("inputstate").onchange = () => {
            cities();
        };
    </script>
@endpush