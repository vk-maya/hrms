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
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ route('employees.wfh.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add
                            WFH</a>
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
                            <li class="nav-item"><a href="#leave" data-bs-toggle="tab"
                                    class="nav-link active">Leave</a></li>
                            <li class="nav-item"><a href="#wfh" data-bs-toggle="tab" class="nav-link">WFH</a>
                            </li>                            
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div id="leave" class="pro-overview tab-pane fade show active">
                    <div class="row">
                        <div class="col-md">
                            <div class="stats-info">
                                <h6>Leave </h6>
                                <div class="row">
                                    <div class="col-md">
                                        <div class=""> <strong>Accrued </strong> Paid
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="">{{ $month->anualLeave }}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class=""> <strong> Accrued </strong>Sick
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="">{{ $month->sickLeave }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $plp = 0;
                            $psick = 0;
                            $pother = 0;
                            $sother = 0;
                            $other = 0;
                            foreach ($ptotalMonthLeave as $leavep) {
                                if ($leavep->leaveType->type == 'PL') {                                    
                                        $pother =$pother+$leavep->day ;                                   
                                } elseif ($leavep->leaveType->type == 'Sick') {                                   
                                    $sother = $leavep->day +$sother;
                                } else {
                                    $other = $other+$leavep->day;
                                }
                            }
                           
                            $currentMonthLeave = $month->apprAnual + $month->apprSick + $month->other;
                        @endphp
                        <div class="col-md">
                            <div class="stats-info">
                                <h6>Utilized leave </h6>
                                <div class="row">
                                    <div class="col-md">
                                        <div class=""><strong> leave </strong>
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="">Paid
                                                        <div class="">
                                                            @if ($month->apprAnual != null)
                                                                {{ $month->apprAnual }}
                                                            @else
                                                                0
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md">
                                                    <div class="">sick
                                                        <div class="">
                                                            @if ($month->apprSick != null)
                                                                {{ $month->apprSick }}
                                                            @else
                                                                0
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md">
                                                    <div class="">other
                                                        <div class="">
                                                            @if ($month->other != null)
                                                                {{ $month->other }}
                                                            @else
                                                                0
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="stats-info">
                                <h6>Pending</h6>
                                <div class="row">
                                    <div class="col-md">
                                        <div class="">
                                            <div class=""><strong> Leave</strong>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <div class="">PL
                                                            <div class="">{{ $pother }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div class="">Sick
                                                            <div class="">{{ $sother }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div class="">other
                                                            <div class="">{{ $other }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="stats-info">
                                <h6>Balance Leave</h6>
                                <div class="row">
                                    <div class="col-md">
                                        <div class=""> <strong> PL </strong> 
                                            <div class="">
                                                {{ $anual = $month->anualLeave - $month->apprAnual }}</div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md">
                                        <div class=""> <strong> Sick</strong> 
                                            <div class="">{{ $sick = $month->sickLeave - $month->apprSick }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="stats-info">
                                <h6>Total Leave</h6>
                                <div class="row">
                                    <div class="col-md">
                                        <div class=""><strong> Month </strong>
                                            <div class="">
                                                {{ $currentMonthLeave }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class=""> <strong> All </strong>
                                            <div class="">{{ $allDay }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                                <td> {{ $item->day }}</td>
                                                <td><a href="#"
                                                        data-bs-toggle="modal"data-bs-target="#reson{{ $item->id }}">{{ \Illuminate\Support\Str::limit($item->reason, 20, '..') }}</a>
                                                </td>
                                                <td class="text-center">
                                                    <div class="">
                                                        @if ($item->status == 2)
                                                            <span class="item  btn-white btn-sm btn-rounded "><i
                                                                    class="fa fa-dot-circle-o text-purple"></i>
                                                                New</span>
                                                        @elseif($item->status == 0)
                                                            <span class="item  btn-white btn-sm btn-rounded"><i
                                                                    class="fa fa-dot-circle-o text-danger"></i>
                                                                Declined</span>
                                                        @else
                                                            <span class="item  btn-white btn-sm btn-rounded"><i
                                                                    class="fa fa-dot-circle-o text-success"></i>
                                                                Approved</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                @if ($item->status == 2)
                                                    <td class="text-end">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                    class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('employees.leave.delete', $item->id) }}"><i
                                                                        class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        <div><i class="fa fa-ban text-danger" ></i>
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
                <div id="wfh" class="pro-overview tab-pane fade show">                   
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>                                           
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Day</th>                                            
                                            <th>Task</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wfh as $item)
                                            <tr>
                                                @php $start = new DateTime($item->from);
                                                $to = new DateTime($item->to);
                                                 @endphp                                                
                                                <td> {{ $start->format('d-m-Y') }}</td>                             
                                                <td> {{ $to->format('d-m-Y') }}</td>                             
                                                <td> {{ $item->day }}</td>
                                                <td><a href="#" data-bs-toggle="modal"data-bs-target="#task{{ $item->id }}">{{ \Illuminate\Support\Str::limit($item->task, 20, '..') }}</a></td>
                                                <td class="text-center">
                                                    <div class="">
                                                        @if ($item->status == 2)
                                                            <span class="item  btn-white btn-sm btn-rounded "><i
                                                                    class="fa fa-dot-circle-o text-purple"></i>
                                                                New</span>
                                                        @elseif($item->status == 0)
                                                            <span class="item  btn-white btn-sm btn-rounded"><i
                                                                    class="fa fa-dot-circle-o text-danger"></i>
                                                                Declined</span>
                                                        @else
                                                            <span class="item  btn-white btn-sm btn-rounded"><i
                                                                    class="fa fa-dot-circle-o text-success"></i>
                                                                Approved</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                @if ($item->status == 2)
                                                    <td class="text-end">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                    class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('employees.leave.delete', $item->id) }}"><i
                                                                        class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        <div>
                                                            <i class="fa fa-ban text-danger" ></i>
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
            @foreach ($wfh as $item)
                <div id="task{{ $item->id }}" class="modal custom-modal fade" role="dialog">
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
                                        {{ $item->task }}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @foreach ($data as $item)
                <div id="reson{{ $item->id }}" class="modal custom-modal fade" role="dialog">
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
