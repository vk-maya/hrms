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
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Leaves</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Leaves</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ route('employees.add.leave') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add
                            Leave</a>
                    </div>
                </div>
            </div>
             
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
            @if ($message = Session::get('unsuccess'))
            <div class="alert alert-warning alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
            <div class="row">
                <div class="col-md-2">
                    <div class="stats-info">
                        <h6>Annual Leave</h6>
                        <h6>
                        </h6>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="stats-info">
                        <h6>Medical Leave</h6>
                        <h6>
                        </h6>

                    </div>
                </div>
                <div class="col-md-2">
                    <div class="stats-info">
                        <h6>Other Leave</h6>
                        <h6>

                        </h6>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="stats-info">
                        <h6>Remaining Leave</h6>
                        <h6></h6>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="stats-info">
                        <h6>Next A/M Leave</h6>
                        <h6></h6>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="stats-info">
                        <h6>Total Leave</h6>

                        <h6></h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>Leave Type</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>No of Days</th>
                                    <th>Reason</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        @php
                                            $start = new DateTime($item->form);
                                            $end = new DateTime($item->to);
                                        @endphp
                                        <td>{{ $item->leaveType->type }}</td>
                                        <td> {{ $start->format('d-m-Y') }}</td>
                                        <td> {{ $end->format('d-m-Y') }}</td>
                                        <td>{{ $start->diff($end)->format('%a') + 1 }}</td>
                                        <td><a href="#"
                                                data-bs-toggle="modal"data-bs-target="#add_department{{ $item->id }}">{{ \Illuminate\Support\Str::limit($item->reason, 20, '..') }}</a>
                                        </td>
                                        <td class="text-center">
                                            <div class="">
                                                @if ($item->status == 2)
                                                    <span class="item  btn-white btn-sm btn-rounded "><i
                                                            class="fa fa-dot-circle-o text-purple"></i> New</span>
                                                @elseif($item->status == 0)
                                                    <span class="item  btn-white btn-sm btn-rounded"><i
                                                            class="fa fa-dot-circle-o text-danger"></i> Declined</span>
                                                @else
                                                    <span class="item  btn-white btn-sm btn-rounded"><i
                                                            class="fa fa-dot-circle-o text-success"></i> Approved</span>
                                                @endif
                                            </div>
                                        </td>
                                        @if ($item->status ==2 || $item->status==0 )                                            
                                        <td class="text-end">
                                                <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false"><i
                                                class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">                                                  
                                                        <a class="dropdown-item" href="{{route('employees.leave.delete',$item->id)}}" ><i
                                                            class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                            </td>
                                            @else
                                            <td class="text-end">
                                                <div class="dropdown dropdown-action">                                               
                                                    </div>
                                            </td>
                                    @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($data as $item)
            <div id="add_department{{ $item->id }}" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">View Reason</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    {{ $item->reason }}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endsection
    @push('plugin-js')
        <script src="{{ asset('assets/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/js/moment.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ asset('assets/js/ckeditor.js') }}"></script>
        <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    @endpush
