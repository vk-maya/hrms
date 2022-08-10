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
                        <h3 class="page-title">Attendance</h3>
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
                                        {{-- <td><a class="btn btn-succress" href="{{route('admin.attan.hit',$item->user_id)}}">Atte</a></td> --}}
                                        <td class="text-center">

                                            @if ($item->attendance == 'P')
                                                <div class="dropdown action-label">
                                                    <a class="btn btn-white btn-sm btn-rounded  disabled"
                                                        href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-check text-success"></i> P - Present
                                                    </a>
                                                </div>
                                            @else
                                                <div class="dropdown action-label">
                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle"
                                                        href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-close text-danger"></i> A - Absent
                                                    </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="fa fa-dot-circle-o text-purple"></i> New</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="fa fa-dot-circle-o text-info"></i> Pending</a>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#approve_leave"><i
                                                                    class="fa fa-dot-circle-o text-success"></i>
                                                                Approved</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="fa fa-dot-circle-o text-danger disabled"></i>
                                                                Declined</a>
                                                        </div>
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
@endsection
@push('plugin-js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
@endpush
