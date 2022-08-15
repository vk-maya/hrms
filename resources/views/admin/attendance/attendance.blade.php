@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
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
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating">
                        <label class="focus-label">Employee Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating">
                            <option>-</option>
                            <option>Jan</option>
                            <option>Feb</option>
                            <option>Mar</option>
                            <option>Apr</option>
                            <option>May</option>
                            <option>Jun</option>
                            <option>Jul</option>
                            <option>Aug</option>
                            <option>Sep</option>
                            <option>Oct</option>
                            <option>Nov</option>
                            <option>Dec</option>
                        </select>
                        <label class="focus-label">Select Month</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating">
                            <option>-</option>
                            <option>2019</option>
                            <option>2018</option>
                            <option>2017</option>
                            <option>2016</option>
                            <option>2015</option>
                        </select>
                        <label class="focus-label">Select Year</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="d-grid">
                        <a href="#" class="btn btn-success"> Search </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    @for ($i = 1; $i <= $month; $i++)
                                        <th>{{ $i }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendance as $item)
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a class="avatar avatar-xs"
                                                    href="{{ route('admin.employees.profile', $item->id) }}"><img alt=""
                                                        src="@if ($item->image != null) {{ asset('storage/uploads/' . $item->image) }}@else{{ asset('assets/img/avtar.jpg') }} @endif""></a>
                                                <a href="{{ route('admin.employees.profile', $item->id) }}">{{ $item->first_name }}</a>
                                            </h2>
                                        </td>
                                        @php
                                            $count = 0;
                                        @endphp
                                        @for ($i = 1; $i <= $month; $i++)
                                            @if (in_array(date("Y-m-d",strtotime(now()->format("Y-m-").$i)),$item->attendence->pluck('date')->toArray()))
                                                @if ($item->attendence[$count]->attendance == 'P')
                                                    <td>
                                                        <button class="dropdown-item attend-info-show" data-id="{{ $item->attendence[$count]->id }}"><i class="fa fa-check text-success"></i></button>
                                                    </td>
                                                    {{-- <td><a href="{{route('admin.attendance.info',$attend->id)}}"><i class="fa fa-check text-success"></i></td> --}}
                                                @else
                                                    <td><i class="fa fa-close text-danger"></i> </td>
                                                @endif
                                                @php
                                                    $count++;
                                                @endphp
                                            @else
                                                <td>-</td>
                                            @endif
                                        @endfor
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
                                    <h5 class="card-title">Timesheet <small class="text-muted">
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
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/multiselect.min.js') }}"></script>
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
                        $('#intime').text(res.attend.in_time);
                        if (res.attend.out_time != "00:00:00") {
                            $('#outtime').text(res.attend.out_time);
                        } else {
                            $('#outtime').text('00:00:00');
                        }
                        $('#totalhour').text(res.attend.working_time);
                        $("#attendance_info").modal('show');
                    }
                });
            });
        });
    </script>
@endpush
