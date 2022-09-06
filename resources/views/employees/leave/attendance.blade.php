@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Attendance vvvvvvvvv</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attendance</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row filter-row">
                <div class="col-sm-3">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input type="text" class="form-control floating datetimepicker">
                        </div>
                        <label class="focus-label">Date</label>
                    </div>
                </div>
                <div class="col-sm-3">
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
                <div class="col-sm-3">
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
                <div class="col-sm-3">
                    <div class="d-grid">
                        <a href="#" class="btn btn-success"> Search </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date </th>
                                    <th>Punch In</th>
                                    <th>Punch Out</th>
                                    <th>Work Hour</th>
                                    <th>Action</th>

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
                                            $todayDate= now()->subDay(2);
                                            $todayDate=\Carbon\Carbon::parse($todayDate)->format('d-m-Y');
                                            $attendanceDate=\Carbon\Carbon::parse($item->date)->format('d-m-Y');
                                        @endphp
                                        <td class="text-center">                     
                                            @if ($item->attendance == 'P')
                                                <div class="dropdown action-label">
                                                    <a class="btn btn-white btn-sm btn-rounded  disabled" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-check text-success"></i> P - Present
                                                    </a>
                                                </div>
                                            @elseif($item->action ==3)
                                            <a class="dropdown-item disabled" > <i class="fa fa-hourglass-start text-info"></i></a>
                                            @elseif($item->action ==1)
                                            <a class="btn btn-white btn-sm btn-rounded  disabled" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-check text-success"></i> A - accept
                                                    </a>
                                            {{-- <a class="dropdown-item disabled" href="#" aria-expanded="false"> <i class="fa fa-check-square-o text-success"></i> A -accept</a> --}}
                                            @elseif($item->action ==0)
                                            <a class="dropdown-item disabled" href="#" aria-expanded="false"> <i class="fa fa-close text-danger"></i> A - Absent</a>
                                            @else
                                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-close text-danger"></i> A - Absent</a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if ($item->mark == "L")

                                                <a class="dropdown-item attend-leave-show disabled" data-id="{{ $item->id}}"> <i class="fa fa-dot-circle-o text-danger"></i> Leave</a>                                                    
                                                <a class="dropdown-item lwfh "  data-id="{{ $item->id}}"><i class="fa fa-dot-circle-o text-info"></i> Leave In WFH</a>

                                                @elseif($item->mark == "WFH")
                                                <a class="dropdown-item attend-leave-show" data-id="{{ $item->id}}"> <i class="fa fa-dot-circle-o text-danger"></i> Leave</a>                                                    
                                                <a class="dropdown-item wfh disabled" data-id="{{ $item->id}}"><i class="fa fa-dot-circle-o text-info"></i> WFH</a>
                                                @else
                                                <a class="dropdown-item attend-leave-show" data-id="{{ $item->id}}"> <i class="fa fa-dot-circle-o text-danger"></i> Leave</a>                                                    
                                                <a class="dropdown-item wfh " data-id="{{ $item->id}}"><i class="fa fa-dot-circle-o text-info"></i> WFH</a>

                                                @endif
                                            </div>
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
                            <label>Leave Type <span class="text-danger">*</span></label>
                            <select class="select" name="leaveType">
                                <option value="">Select Leave Type</option>
                                @foreach ($leaveType as $item)
                                    <option value="{{$item->id}}">{{ $item->type }}</option>
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
    <div id="lwfh" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Leave</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('employees.attendance.leave.wfh') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="lwid">                     
                        <div class="form-group">
                            <label>Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control" name="wdate" readonly id="lwdate" type="text">
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
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
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
{{-- <div class="dropdown action-label">
    @if($item->leavestatus->status==0 && $item->action == 4)
        <a class="dropdown-item disabled" href="#" aria-expanded="false"> <i class="fa fa-close text-danger"></i> A - Absent</a>
    @elseif($item->leavestatus->status==1 && $item->action == 4)
        <a class="dropdown-item disabled" href="#" aria-expanded="false"> <i class="fa fa-check-square-o text-success"></i> A -accept</a>
    @else
            @if ($item->action==2)
                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-close text-danger"></i> A - Absent</a>
            @elseif($item->action==3)                                            
                <a class="dropdown-item disabled" > <i class="fa fa-hourglass-start text-info"></i> Leave</a>
            @elseif($item->action==4)
                <a class="dropdown-item  disabled"><i class="fa fa-hourglass-start text-info"></i> WFH</a>
            @elseif($item->action==5)
                <a class="dropdown-item disabled"><i class="fa fa-hourglass-start text-info"></i> Leave In WFH</a>
            @endif 

            <div class="dropdown-menu dropdown-menu-right">                                                                
                @if($item->leavestatus->form <= $item->date && $item->leaveStatus->to >= $item->date)
                <a class="dropdown-item attend-leave-show disabled" data-id="{{ $item->id}}"> <i class="fa fa-dot-circle-o text-danger"></i> Leave</a>
                <a class="dropdown-item lwfh"data-id="{{ $item->id }}"><i class="fa fa-dot-circle-o text-success"></i> Leave In WFH</a>  
                @else
                @endif
            </div>                                                     
    @endif
</div>   --}}