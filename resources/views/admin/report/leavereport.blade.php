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
                        <h3 class="page-title">Employee</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employee</li>
                        </ul>
                    </div>
                    <div class="col-auto icon-topic d-flex">
                      
                        <div class="employ-add-btn">
                            @if (isset($monthRecord))
                                <form action="{{ route('admin.month.leave.record.manage.all') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="all" value="{{ json_encode($monthRecord) }}">
                                    <button type="submit" class="btn add-btn ">All Emp. Month Record</button>
                                </form>
                            @endif
                        </div>
                        <div class="employ-add-btn">
                            @if (isset($monthRecord))
                                <form action="{{ route('admin.emp.slip.generate') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="all" value="{{ json_encode($monthRecord) }}">
                                    <button type="submit" class="btn add-btn ">All Emp. Slip</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>       
            <form action="{{ route('admin.emp.report.search') }}" method="POST">
                @csrf
                <div class="row filter-row">
                    <div class="col-sm-3 col-md">
                        <div class="form-group form-focus select-focus">
                            <select class="select floating" name="user_id">
                                <option value="">All Employees</option>
                                @foreach ($users as $employee)
                                    <option @if (isset(request()->user_id) && request()->user_id == $employee->id) selected @endif value="{{ $employee->id }}">
                                        {{ $employee->first_name }}</option>
                                @endforeach
                            </select>
                            <label class="focus-label">Employee Name</label>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md">
                        <div class="form-group form-focus select-focus">
                            <select class="select floating" name="month">
                                <option @if (isset(request()->month) && request()->month == 1) selected @endif value="1">Jan</option>
                                <option @if (isset(request()->month) && request()->month == 2) selected @endif value="2">Feb</option>
                                <option @if (isset(request()->month) && request()->month == 3) selected @endif value="3">Mar</option>
                                <option @if (isset(request()->month) && request()->month == 4) selected @endif value="4">Apr</option>
                                <option @if (isset(request()->month) && request()->month == 5) selected @endif value="5">May</option>
                                <option @if (isset(request()->month) && request()->month == 6) selected @endif value="6">Jun</option>
                                <option @if (isset(request()->month) && request()->month == 7) selected @endif value="7">Jul</option>
                                <option @if (isset(request()->month) && request()->month == 8) selected @endif value="8">Aug</option>
                                <option @if (isset(request()->month) && request()->month == 9) selected @endif value="9">Sep</option>
                                <option @if (isset(request()->month) && request()->month == 10) selected @endif value="10">Oct</option>
                                <option @if (isset(request()->month) && request()->month == 11) selected @endif value="11">Nov</option>
                                <option @if (isset(request()->month) && request()->month == 12) selected @endif value="12">Dec</option>
                            </select>
                            <label class="focus-label">Select Month</label>
                        </div>
                    </div>
                    @php
                        $years = 2019;
                        $curenty = date('Y', strtotime(now()));
                    @endphp
                    <div class="col-sm-3 col-md">
                        <div class="form-group form-focus select-focus">
                            <select class="select floating" name="year">
                                @for ($years; $years <= $curenty; $years++)
                                    <option @if (isset(request()->year) && request()->year == $years) selected @endif
                                        value="{{ $years }}">
                                        {{ $years }}</option>
                                @endfor
                            </select>
                            <label class="focus-label">Select Year</label>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md">
                        <div class="search-btn">
                            <button type="submit" class="btn btn-success"> Submit </button>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md">
                        <div class="search-btn">
                            <a type="submit" class="btn btn-success" href="{{ route('admin.emp.report') }}"> Reset </a>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table cus-table-striped custom-table mb-0" id="department">
                        <thead>
                            <tr>
                                <th style="width: 30px;">SR</th>
                                <th class="text-center">Employees Name</th>
                                <th class="text-center">Month</th>
                                <th class="text-center">Month Leave Manage</th>
                                <th class="text-center">Month Record Generate</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($monthRecord))
                                @foreach ($monthRecord as $key => $item)
                                    @if (!empty($item->monthleavesalary))
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->first_name}}</td>
                                            @php
                                                $month = date('m', strtotime($item->monthleavesalary->from));
                                                $year = date('Y', strtotime($item->monthleavesalary->from));
                                            @endphp
                                            <td>{{$month.'-'.$year }}</td>
                                            <td><a
                                                    href="{{ route('admin.employee.month', ['id' => $item->id, 'month' => $month, 'year' => $year]) }}">Month
                                                    Record</a></td>
                                            <td><a
                                                    href="{{ route('admin.month.leave.record.manage', ['id' => $item->id, 'from' => $item->monthleavesalary->from, 'to' => $item->monthleavesalary->to, 'monthleave_id' => $item->monthleavesalary->id]) }}">Generate
                                                    Month</a> </td>
                                            <td><a
                                                    href="{{ route('admin.emp.slip.generate', ['id' => $item->id, 'from' => $item->monthleavesalary->from, 'to' => $item->monthleavesalary->to, 'monthrecord_id' => $item->monthleavesalary->id]) }}">Generate
                                                    Slip</a></td>
                                            <td>Salary pending </td>
                                        </tr>                                   
                                    @endif
                                @endforeach                        
                            @endif
                        </tbody>
                    </table>
                </div>
                {{-- @if (isset($monthRecord))
                    <form action="{{ route('admin.month.leave.record.manage.all') }}" method="POST">
                        @csrf
                        <div class="row filter-row">
                            <h4>Month Record Management</h4>
                            <div class="col-sm-3 col-md">
                                <div class="form-group form-focus select-focus">
                                    <select class="select floating" name="all">
                                        <option value="{{json_encode($monthRecord)}}">All Employees</option>
                                    </select>
                                    <label class="focus-label">Employee Name</label>
                                </div>
                            </div>                           
                            <div class="col-sm-3 col-md">
                                <div class="search-btn">
                                    <button type="submit" class="btn btn-success"> Submit </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif --}}
                {{-- @if (isset($monthRecord))
                    <form action="{{ route('admin.emp.slip.generate') }}" method="POST">
                        @csrf
                        <div class="row filter-row">
                            <h4>Salary slip Generate</h4>
                            <div class="col-sm-3 col-md">
                                <div class="form-group form-focus select-focus">
                                    <select class="select floating" name="all">
                                        <option value="{{ json_encode($monthRecord) }}">All Employees</option>
                                    </select>
                                    <label class="focus-label">Employee Name</label>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md">
                                <div class="search-btn">
                                    <button type="submit" class="btn btn-success"> Submit </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif --}}
            </div>
        </div>
    </div>
@endsection
@push('plugin-js')
<<<<<<< HEAD
<script>
    if (isset($dataedit)) {
        $("#add_salary").modal('show');
    }
</script>
=======
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script>
        if (isset($dataedit)) {
            $("#add_salary").modal('show');
        }
    </script>
>>>>>>> master
@endpush
