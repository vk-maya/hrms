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
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsivesss">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Leave Type</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>No of Days</th>
                                    <th>Reason</th>
                                    <th>Action</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>                                     
                                        @php
                                            $start = new DateTime($item->form);
                                            $end = new DateTime($item->to);
                                        @endphp
                                        <td>{{ $item->user->first_name }}</td>
                                        <td>{{ $item->leaveType->type }}</td>
                                        <td> {{ $start->format('Y-m-d') }}</td>
                                        <td> {{ $end->format('Y-m-d') }}</td>
                                        @php
                                           
                                            $interval = $start->diff($end);
                                            $da = $interval->format('%a');
                                            $days = $da+1;
                                        @endphp
                                        <td>{{ $days}}</td>
                                        <td>{{ $item->reason }}</td>
                                        <td class="text-end">
											<div class="dropdown dropdown-action">
												<a href="#" class="action-icon dropdown-toggle"
													data-bs-toggle="dropdown" aria-expanded="false"><i
														class="material-icons">more_vert</i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="{{route('admin.leave.edit',$item->id)}}"><i
															class="fa fa-pencil m-r-5"></i> Edit</a>
													<a class="dropdown-item" href="{{route('admin.leave.delete',$item->id)}}" ><i
															class="fa fa-trash-o m-r-5"></i> Delete</a>
												</div>
											</div>
										</td>
                                        <td class="text-center">
                                            <div class="dropdown action-label">
                                                @if ($item->status == 2)
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href=""
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-purple"></i> New
                                                </a>
                                                @elseif($item->status == 0)
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href=""
                                                data-bs-toggle="dropdown" aria-expanded="false"><i
                                                    class="fa fa-dot-circle-o text-danger"></i> Declined</a>  
                                                @else
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href=""
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                    class="fa fa-dot-circle-o text-success"></i> Approved</a> 
                                                @endif

                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <form action="{{route('admin.leave.report')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="2">
                                                        <input type="hidden" name="id" value="{{$item->id}}">
                                                        <button type="submit" class="dropdown-item"><i
                                                                class="fa fa-dot-circle-o text-purple"></i> New</button>                                                  
                                                        </form>
                                                        <form action="{{route('admin.leave.report')}}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="status" value="1">
                                                            <input type="hidden" name="id" value="{{$item->id}}">
                                                            <input type="hidden" name="type_id" value="{{$item->leaves_id}}">
                                                            <button type="submit" class="dropdown-item"><i
                                                                    class="fa fa-dot-circle-o text-success"></i> Approved</button>                                                  
                                                            </form>                                             
                                                    <form action="{{route('admin.leave.report')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="0">
                                                        <input type="hidden" name="id" value="{{$item->id}}">

                                                        <button type="submit" class="dropdown-item"><i
                                                                class="fa fa-dot-circle-o text-danger"></i> Declined</button>                                                  
                                                        </form>  
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
@endsection
@push('plugin-js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
@endpush
