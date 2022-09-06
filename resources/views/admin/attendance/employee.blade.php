@extends('admin.layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endpush
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Attendance</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Attendance</li>
                    </ul>
                </div>
            </div>
        </div>
        <form action="{{route('admin.attendance.employee')}}" method="GET">
            <div class="row filter-row">
                <div class="col-sm-3 col-md">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" name="user_id">
                            <option value=""></option>
                            @foreach ($allemployees as $employee)
                            <option @if(isset(request()->user_id) && request()->user_id == $employee->id) selected @endif value="{{$employee->id}}">{{$employee->first_name}}</option>
                            @endforeach
                        </select>
                        <label class="focus-label">Employee Name</label>
                    </div>
                </div>
                <div class="col-sm-3 col-md">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" name="month">
                            <option @if(isset(request()->month) && request()->month == 1)
                                selected
                                @endif value="1">Jan</option>
                            <option @if(isset(request()->month) && request()->month == 2)
                                selected
                                @endif value="2">Feb</option>
                            <option @if(isset(request()->month) && request()->month == 3)
                                selected
                                @endif value="3">Mar</option>
                            <option @if(isset(request()->month) && request()->month == 4)
                                selected
                                @endif value="4">Apr</option>
                            <option @if(isset(request()->month) && request()->month == 5)
                                selected
                                @endif value="5">May</option>
                            <option @if(isset(request()->month) && request()->month == 6)
                                selected
                                @endif value="6">Jun</option>
                            <option @if(isset(request()->month) && request()->month == 7)
                                selected
                                @endif value="7">Jul</option>
                            <option @if(isset(request()->month) && request()->month == 8)
                                selected
                                @endif value="8">Aug</option>
                            <option @if(isset(request()->month) && request()->month == 9)
                                selected
                                @endif value="9">Sep</option>
                            <option @if(isset(request()->month) && request()->month == 10)
                                selected
                                @endif value="10">Oct</option>
                            <option @if(isset(request()->month) && request()->month == 11)
                                selected
                                @endif value="11">Nov</option>
                            <option @if(isset(request()->month) && request()->month == 12)
                                selected
                                @endif value="12">Dec</option>
                        </select>
                        <label class="focus-label">Select Month</label>
                    </div>
                </div>
                @php
                $years=2019;
                $curenty= date('Y', strtotime(now()))
                @endphp
                <div class="col-sm-3 col-md">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" name="year">
                            <option>-</option>
                            @for($years; $years <=$curenty; $years++) <option @if(isset(request()->year) && request()->year == $years) selected @endif value="{{$years}}">{{$years}}</option>
                                @endfor
                        </select>
                        <label class="focus-label">Select Year</label>
                    </div>
                </div>
                <div class="col-sm-3 col-md">
                    <div class="search-btn">
                        <button type="submit" class="btn btn-success"> Search </button>
                    </div>
                </div>
                <div class="col-sm-3 col-md">
                    <div class="search-btn">
                        <a href="{{route('admin.attendance.employee')}}" class="btn btn-success"> Reset </a>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                <table class="table cus-table-striped custom-table mb-0" id="designation">
                        <tbody>
                            <th>Employees Name</th>
                            <th>Month</th>
                            <th>PL Leave</th>
                            <th>Sick Leave</th>
                            <th>Other Leave</th>
                            <th>Total Working Day</th>
                            <th>More Action</th>
                            @foreach ($attendance as $item)
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-xs" href="{{ route('admin.employees.profile', $item->id) }}"><img alt="" src="@if ($item->image != null) {{ asset('storage/uploads/' . $item->image) }}@else{{ asset('assets/img/avtar.jpg') }} @endif""></a>
                                                <a href=" {{ route('admin.employees.profile', $item->id) }}">{{ $item->first_name }}</a>
                                    </h2>
                                </td>
                                @php
                                $month= date('m', strtotime($item->$method->from));
                                $year= date('Y', strtotime($item->$method->from));
                                @endphp
                                <td>{{\Carbon\Carbon::parse($item->$method->from)->format('M').', '.$year}}</td>
                                <td>@if ($item->$method->apprAnual>0){{$item->$method->apprAnual}}@else 0 @endif</td>
                                <td>@if ($item->$method->apprSick>0){{$item->$method->apprSick}}@else 0 @endif</td>
                                <td>@if ($item->$method->other>0){{$item->$method->other}}@else 0 @endif</td>
                                <td>@if ($item->$method->working_day>0){{$item->$method->working_day}}@else 0 @endif</td>
                                <td><a href="{{route('admin.employee.month',[$item->id,$year,$month])}}">Month Record </a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal custom-modal fade" id="attendance_info" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance Info</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="card punch-status">
                            <div class="card-body">
                                <h5 class="card-title">Timesheet <small class="text-muted" id="clickdate">
                                        {{ \Carbon\Carbon::now()->format('d-m-Y') }}</small></h5>
                                <div class="punch-det">
                                    <h6>Punch In at</h6>
                                    <p id="intime"></p>
                                </div>
                                {{-- {{$attendance}} --}}

                                <div class="punch-info">
                                    <div class="punch-hours">
                                        <span id="totalhour"></span>
                                    </div>
                                </div>
                                <div class="punch-det">
                                    <h6>Punch Out at</h6>
                                    <p id="outtime"></p>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@push('js')
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script>
    $('#designation').DataTable({
        paging: true,
        searching: true
    });
</script>
<script>
    $(document).ready(function() {
        $(document).on("click", ".attend-info-show", function() {
            var id = $(this).data('id');
            console.log(id);
            var url = "{{ route('admin.attendance.info', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                cache: false,
                success: function(res) {
                    $('#clickdate').text(res.attend.date);
                    $('#intime').text(res.attend.in_time);
                    if (res.attend.out_time != "00:00:00") {
                        $('#outtime').text(res.attend.out_time);
                    } else {
                        $('#outtime').text('00:00:00');
                    }
                    $('#totalhour').text(res.attend.work_time);
                    $("#attendance_info").modal('show');
                }
            });
        });
    });
</script>
@endpush