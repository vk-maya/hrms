@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">
@endpush
@section('content')

<div class="page-wrapper">

    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Employee Salary</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Salary</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_salary"><i
                            class="la la-money"></i>All Generate Slip</a>
                </div>
            </div>
        </div>


        <div class="row filter-row">
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating">
                    <label class="focus-label">Employee Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option value=""> -- Select -- </option>
                        <option value="">Employee</option>
                        <option value="1">Manager</option>
                    </select>
                    <label class="focus-label">Role</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option> -- Select -- </option>
                        <option> Pending </option>
                        <option> Approved </option>
                        <option> Rejected </option>
                    </select>
                    <label class="focus-label">Leave Status</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text">
                    </div>
                    <label class="focus-label">From</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text">
                    </div>
                    <label class="focus-label">To</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <a href="#" class="btn btn-success w-100"> Search </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table datatable">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Employee ID</th>
                                <th>Join Date</th>
                                <th>Role</th>
                                <th>Salary</th>
                                <th>Payslip</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $user)
                                {{-- {{$user}} --}}
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="{{ route('admin.employees.profile', $user->id) }}" class="avatar"><img alt="" src="@if ($user->image != null) {{ asset('storage/uploads/' . $user->image) }}@else{{ asset('assets/img/avtar.jpg') }} @endif"></a>
                                        <a href="{{ route('admin.employees.profile', $user->id) }}">{{$user->first_name}} <span>{{$user->userDesignation->designation_name}}</span></a>
                                    </h2>
                                </td>
                                <td>{{$user->employeeID}}</td>     
                                @php
                                 
                                    $jd=new DateTime($user->joiningDate);
                                @endphp                          
                                <td>{{$jd->format('d-M-Y')}}</td>   
                                {{-- $start->format('Y-m-d')                             --}}
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-white btn-sm btn-rounded " style="pointer-events: none"
                                            data-bs-toggle="dropdown" aria-expanded="false">{{$user->userDesignation->designation_name}} </a>                                      
                                    </div>
                                </td>
                                <td>$59698</td>
                                <td><a class="btn btn-sm btn-primary" href="salary-view.html">Generate Slip</a>
                                </td>                             
                            </tr>
                            @endforeach                            
                        </tbody>
                    </table>
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
    <script src="{{ asset('assets/js/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
@endpush
