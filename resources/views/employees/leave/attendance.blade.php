@extends('layouts.app')
@push('css')
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Attendance</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attendance</li>
                        </ul>
                    </div>
                </div>
            </div>
            <form action="{{ route('employees.search.month.attendance') }}" method="GET">
                <div class="row filter-row">
                    <div class="col">
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
                    <div class="col">
                        <div class="form-group form-focus select-focus">
                            <select class="select floating" name="year">
                                @for ($years; $years <= $curenty; $years++)
                                    <option @if (isset(request()->year) && request()->year == $years) selected  @endif value="{{ $years }}">
                                        {{ $years }}</option>
                                @endfor
                            </select>
                            <label class="focus-label">Select Year</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="search-btn">
                            <button type="search" class="btn btn-success"> Search </button>
                            <a href="{{route('employees.attendance')}}" class="btn btn-success"> Reset </a>
                        </div>
                    </div>
                </div>
            </form>
            @isset($messege)
                @if ($messege == 0)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Attendance! </strong>record Not Available!.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @else
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Attendance! </strong>record Available!.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endisset
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table cus-table-striped custom-table mb-0 data-table-theme">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date </th>
                                    <th>Punch In</th>
                                    <th>Punch Out</th>
                                    <th>Work Hour</th>
                                    <th class="text-center">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendance as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }} </td>
                                        <td>{{ $item->in_time }}</td>
                                        <td>{{ $item->out_time }}</td>
                                        <td>{{ $item->work_time }}</td>
                                        @php
                                            $todayDate = now()->subDay(2);
                                            $todayDate = \Carbon\Carbon::parse($todayDate)->format('d-m-Y');
                                            $attendanceDate = \Carbon\Carbon::parse($item->date)->format('d-m-Y');
                                        @endphp
                                        <td class="text-center">
                                            @if ($item->mark == 'HDO')
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggl disabled"
                                                    href="#" data-bs-toggle="dropdown" aria-expanded="false"> <i
                                                        class="fa fa-check  text-info"></i> H-Half-Day </a>
                                            @else
                                                @if ($item->attendance == 'P' || $item->attendance == 'WO')
                                                    <div class="dropdown action-label">
                                                        <a class="btn btn-white btn-sm btn-rounded  disabled" href="#"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-check text-success me-2"></i> Present
                                                        </a>
                                                    </div>
                                                @elseif($item->action == 3)
                                                    <a class="dropdown-item disabled"> <i
                                                            class="fa fa-hourglass-start text-info"></i></a>
                                                @elseif($item->action == 1)
                                                    <a class="btn btn-white btn-sm btn-rounded  disabled" href="#"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-check text-success"></i> A - accept
                                                    </a>
                                                @elseif($item->action == 0)
                                                    <a class="dropdown-item disabled" href="#" aria-expanded="false">
                                                        <i class="fa fa-close text-danger"></i> A - Absent</a>
                                                @else
                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle"
                                                        href="#" data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="fa fa-close text-danger"></i> A - Absent</a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if ($item->mark == 'L')
                                                            <a class="dropdown-item attend-leave-show disabled"
                                                                data-id="{{ $item->id }}"> <i
                                                                    class="fa fa-dot-circle-o text-danger"></i> Leave</a>
                                                            <a class="dropdown-item wfh" data-id="{{ $item->id }}"><i
                                                                    class="fa fa-dot-circle-o text-info"></i>WFH</a>
                                                        @elseif($item->mark == 'WFH')
                                                            <a class="dropdown-item attend-leave-show"
                                                                data-id="{{ $item->id }}"> <i
                                                                    class="fa fa-dot-circle-o text-danger"></i> Leave</a>
                                                            <a class="dropdown-item wfh disabled"
                                                                data-id="{{ $item->id }}"><i
                                                                    class="fa fa-dot-circle-o text-info"></i> WFH</a>
                                                        @else
                                                            <a class="dropdown-item attend-leave-show"
                                                                data-id="{{ $item->id }}"> <i
                                                                    class="fa fa-dot-circle-o text-danger"></i> Leave</a>
                                                            <a class="dropdown-item wfh "
                                                                data-id="{{ $item->id }}"><i
                                                                    class="fa fa-dot-circle-o text-info"></i> WFH</a>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endif
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
    <div id="add_leave" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Leave</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('employees.attendance.leave') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label>Day Type Select<span class="text-danger">*</span></label>
                            <select class="select" name="dayType" required>
                                <option value="1">Full Day</option>
                                <option value="0">Half Day</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Leave Type <span class="text-danger">*</span></label>
                            <select class="select" name="leaveType">
                                @foreach ($leaveType as $item)
                                    <option value="{{ $item->id }}">{{ $item->type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>From <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control" name="from" readonly type="text" id="date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>To <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control" name="to" readonly id="dateto" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Number of days <span class="text-danger">*</span></label>
                            <input class="form-control" name="day" readonly type="text" value="1">
                        </div>
                        <div class="form-group">
                            <label>Leave Reason <span class="text-danger">*</span></label>
                            <textarea rows="4" class="form-control" name="reson"></textarea>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="wfh" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Leave</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('employees.attendance.wfh') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="wid">
                        <div class="form-group">
                            <label>Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control" name="wdate" readonly id="wdate" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Number of days <span class="text-danger">*</span></label>
                            <input class="form-control" name="day" readonly type="text" value="1">
                        </div>
                        <div class="form-group">
                            <label>Task<span class="text-danger">*</span></label>
                            <textarea rows="4" class="form-control" name="task"></textarea>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('plugin-js')
    <script>
        $(document).ready(function() {
            $(document).on("click", ".attend-leave-show", function() {
                var id = $(this).data('id');
                var url = "{{ route('employees.attendance.get.leave', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    type: "GET",
                    cache: false,
                    success: function(res) {
                        console.log(res);
                        $('#date').val(res.attendleave.date);
                        $('#dateto').val(res.attendleave.date);
                        $('#id').val(res.attendleave.id);
                        $("#add_leave").modal('show');
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".wfh", function() {
                var id = $(this).data('id');
                console.log(id);
                var url = "{{ route('employees.attendance.get.leave', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    type: "GET",
                    cache: false,
                    success: function(res) {
                        console.log(res);
                        $('#wdate').val(res.attendleave.date);
                        $('#wid').val(res.attendleave.id);
                        $("#wfh").modal('show');
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".lwfh", function() {
                var id = $(this).data('id');
                console.log(id);
                var url = "{{ route('employees.attendance.get.leave', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    type: "GET",
                    cache: false,
                    success: function(res) {
                        console.log(res);
                        $('#lwdate').val(res.attendleave.date);
                        $('#lwid').val(res.attendleave.id);
                        $("#lwfh").modal('show');
                    }
                });
            });
        });
    </script>
@endpush
