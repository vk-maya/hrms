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
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table cus-table-striped custom-table mb-0" id="designation">
                        <tbody>
                            <th>Employees Name</th>
                            <th>Date</th>
                            <th>In_Time</th>
                            <th>Out_Time</th>
                            <th>Working_Hour</th>
                            <th>Attendance</th>
                            <th>More Action</th>
                            @foreach ($monthrecord as $item)
                            <tr>
                                <td>{{ $item->userinfoatt->first_name }}</td>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->in_time }}</td>
                                <td>{{ $item->out_time }}</td>
                                <td>{{ $item->work_time }}</td>
                                <td>{{ $item->attendance }}</td>
                                <td class="text-center">
                                    <div class="dropdown action-label">
                                        @if ($item->mark == 'A')
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-dot-circle-o text-danger"></i> A-absent
                                        </a>
                                        @elseif($item->mark == 'L')
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-warning"></i>Leave</a>
                                        @elseif($item->mark == 'WFH')
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-info"></i>WFH</a>
                                        @elseif($item->mark == "P")
                                        <a class="btn btn-white btn-sm btn-rounded disabled">
                                            <i class="fa fa-dot-circle-o text-success"></i>
                                            P-present</a>
                                        @else
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i>
                                            Leave</a>

                                        @endif
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if ($item->mark == 'L')
                                            <form action="{{ route('admin.employee.month.record.report') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="WFH">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                    WFH</button>
                                            </form>
                                            <form action="{{ route('admin.employee.month.record.report') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="A">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa fa-dot-circle-o text-danger"></i>
                                                    A-absent</button>
                                            </form>
                                            @endif
                                            @if ($item->mark == 'A')
                                            <form action="{{ route('admin.employee.month.record.report') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="WFH">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                    WFH</button>
                                            </form>
                                            <form action="{{ route('admin.employee.month.record.report') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="L">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa fa-dot-circle-o text-warning"></i>
                                                    Leave</button>
                                            </form>
                                            @endif
                                            @if ($item->mark =='WFH')
                                            <form action="{{ route('admin.employee.month.record.report') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="A">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa fa-dot-circle-o text-danger"></i>
                                                    A-absent</button>
                                            </form>
                                            <form action="{{ route('admin.employee.month.record.report') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="L">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa fa-dot-circle-o text-warning"></i>
                                                    Leave</button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
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
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script> --}}
<script src="{{ asset('assets/js/multiselect.min.js') }}"></script>
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