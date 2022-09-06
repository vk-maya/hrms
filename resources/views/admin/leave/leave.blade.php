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
                    <h3 class="page-title">Leaves</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leaves</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{ route('admin.leave.setting') }}" class="btn add-btn"><i class="fa fa-plus"></i>
                        Add Leave Type</a>
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
        <div class="card tab-box">
            <div class="row user-tabs">
                <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                    <ul class="nav nav-tabs nav-tabs-bottom">
                        <li class="nav-item"><a href="#leave_request" data-bs-toggle="tab" class="nav-link active ">Leave
                                Request<small class="text-danger"> @if(isset($leaveCount) && $leaveCount != null)({{$leaveCount}})
                                    @endif</small></a></li>
                        <li class="nav-item"><a href="#wfh_request" data-bs-toggle="tab" class="nav-link ">Work Form Home Request <small class="text-danger">@if(isset($wfhcount) && $wfhcount != null)({{$wfhcount}})
                                    @endif</small></a></li>
                        {{-- <li class="nav-item"><a href="#bank_statutory" data-bs-toggle="tab" class="nav-link">Bank &
                                    Statutory <small class="text-danger">(Admin
                                        Only)</small></a></li> --}}
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div id="leave_request" class="pro-overview tab-pane fade show active">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table cus-table-striped custom-table mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Leave Type</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Days</th>
                                        <th>Reason</th>
                                        <th>More...</th>
                                        <th class="text-center">Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                    <tr>
                                        @php
                                        $start = new DateTime($item->form);
                                        $end = new DateTime($item->to);
                                        @endphp
                                        <td><a href="{{ route('admin.leave.view', $item->id) }}">{{ $item->user->first_name }}</a>
                                        </td>
                                        <td>{{ $item->leaveType->type }}</td>
                                        <td> {{ $start->format('d-M-Y') }}</td>
                                        <td> {{ $end->format('d-M-Y') }}</td>
                                        @php
                                        $lr = 0;
                                        foreach ($item->leaverecord as $leaver) {
                                        $lr = $lr + $leaver->day;
                                        }
                                        @endphp
                                        <td>{{ $item->day }}</td>

                                        <td><a href="#" data-bs-toggle="modal" data-bs-target="#add_department{{ $item->id }}">{{ \Illuminate\Support\Str::limit($item->reason, 20, '..') }}</a>
                                        </td>
                                        <td><a href="{{ route('admin.leave.view', $item->id) }}">More View</a></td>
                                        <td class="text-center">
                                            <div class="dropdown action-label">
                                                @if ($item->status == 2)
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-purple"></i> New
                                                </a>
                                                @elseif($item->status == 0)
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> Declined</a>
                                                @else
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-success"></i>
                                                    Approved</a>
                                                @endif

                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if ($item->status ==1 || $item->status == 0 )
                                                    <form action="{{ route('admin.leave.report') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="2">
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fa fa-dot-circle-o text-purple"></i>
                                                            New</button>
                                                    </form>
                                                    @else
                                                    <span class="dropdown-item disabled">
                                                        <i class="fa fa-dot-circle-o text-purple"></i>
                                                        New</span>

                                                    @endif
                                                    @if ($item->status == 0 || $item->status == 2)
                                                    <form action="{{ route('admin.leave.report') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="1">
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        <input type="hidden" name="type_id" value="{{ $item->leaves_id }}">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fa fa-dot-circle-o text-success"></i>
                                                            Approved</button>
                                                    </form>
                                                    @else
                                                    <span class="dropdown-item disabled">
                                                        <i class="fa fa-dot-circle-o text-success"></i>
                                                        Approved</span>

                                                    @endif
                                                    @if ($item->status == 1 || $item->status == 2)
                                                    <form action="{{ route('admin.leave.report') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value=0>
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fa fa-dot-circle-o text-danger"></i>
                                                            Declined</button>
                                                    </form>
                                                    @else
                                                    <span class="dropdown-item disabled">
                                                        <i class="fa fa-dot-circle-o text-danger"></i>
                                                        Declined</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        @if ($item->status == 2 || $item->status == 0)
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{ route('admin.leave.delete', $item->id) }}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
            <div class="tab-pane fade" id="wfh_request">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table cus-table-striped custom-table mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Days</th>
                                        <th>Task</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wfhData as $item)
                                    <tr>
                                        @php
                                        $start = new DateTime($item->from);
                                        $end = new DateTime($item->to);
                                        @endphp
                                        <td><a class="disabled" href="">{{ $item->user->first_name }}</a> </td>
                                        <td> {{ $start->format('d-M-Y') }}</td>
                                        <td> {{ $end->format('d-M-Y') }}</td>
                                        <td>{{ $item->day }}</td>
                                        <td><a href="#" data-bs-toggle="modal" data-bs-target="#task{{ $item->id }}">{{ \Illuminate\Support\Str::limit($item->task, 20, '..') }}</a>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown action-label">
                                                @if ($item->status == 2)
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-purple"></i> New
                                                </a>
                                                @elseif($item->status == 0)
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> Declined</a>
                                                @else
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-success"></i>
                                                    Approved</a>
                                                @endif
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if ($item->status == 2)
                                                    <span class="dropdown-item disabled">
                                                        <i class="fa fa-dot-circle-o text-purple"></i>
                                                        New</span>
                                                    @else
                                                    <form action="{{ route('admin.wfh.report') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="2">
                                                        <input type="hidden" name="user_id" value="{{ $item->user->id}}">
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fa fa-dot-circle-o text-purple"></i>
                                                            New</button>
                                                    </form>
                                                    @endif
                                                    @if ($item->status == 1)
                                                    <span class="dropdown-item disabled">
                                                        <i class="fa fa-dot-circle-o text-success"></i>
                                                        Approved</span>
                                                    @else
                                                    <form action="{{ route('admin.wfh.report') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="1">
                                                        <input type="hidden" name="user_id" value="{{ $item->user->id}}">
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        <input type="hidden" name="type_id" value="{{ $item->leaves_id }}">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fa fa-dot-circle-o text-success"></i>
                                                            Approved</button>
                                                    </form>
                                                    @endif
                                                    @if ($item->status == 0)
                                                    <span class="dropdown-item disabled">
                                                        <i class="fa fa-dot-circle-o text-danger"></i>
                                                        Declined</span>
                                                    @else
                                                    <form action="{{ route('admin.wfh.report') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value=0>
                                                        <input type="hidden" name="user_id" value="{{ $item->user->id}}">
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fa fa-dot-circle-o text-danger"></i>
                                                            Declined</button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        {{-- {{$item}} --}}
                                        @if ($item->status == 2 || $item->status == 0)
                                        <td class="text-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{ route('admin.leave.delete', $item->id) }}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        @else
                                        <td class="text-center">
                                            <div class="dropdown dropdown-action">
                                                <i class="fa fa-ban text-danger"></i>
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
@foreach ($wfhData as $item)
<div id="task{{$item->id}}" class="modal custom-modal fade" role="dialog">
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
                        <p>{{ $item->task }}</p>
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