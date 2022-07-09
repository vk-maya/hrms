@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsivesss">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>Reason</th>
                                    <th>Leave Type</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Days</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        @php
                                            $start = new DateTime($item->from);
                                            $end = new DateTime($item->to);
                                        @endphp
                                        <td>
                                            <a href="#" data-bs-toggle="modal"data-bs-target="#add_department{{ $item->id }}">{{ \Illuminate\Support\Str::limit($item->reason, 20, '..') }}</a>
                                        </td>
                                        <td>{{ $item->leavetype->type }}</td>
                                        <td> {{ $start->format('d-M-Y') }}</td>
                                        <td> {{ $end->format('d-M-Y') }}</td>
                                        @php
                                            
                                            $interval = $start->diff($end);
                                            $da = $interval->format('%a');
                                            $days = $da + 1;
                                        @endphp
                                        <td>{{ $days }}</td>
                                        <td class="text-center">
                                            @if ($item->status == 2)
                                                <span class="btn btn-white btn-sm btn-rounded dropdown-toggle">
                                                    <i class="fa fa-dot-circle-o text-purple"></i> New
                                                </span>
                                            @elseif($item->status == 0)
                                                <span class="btn btn-white btn-sm btn-rounded dropdown-toggle"><i
                                                        class="fa fa-dot-circle-o text-danger"></i> Declined</span>
                                            @else
                                                <span class="btn btn-white btn-sm btn-rounded dropdown-toggle"><i
                                                        class="fa fa-dot-circle-o text-success"></i> Approved</span>
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
