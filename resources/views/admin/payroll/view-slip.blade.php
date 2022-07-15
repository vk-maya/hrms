@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    {{-- <link rel="stylesheet" href="assets/plugins/sweetalert2/sweetalert2.min.css"> --}}
@endpush
@section('content')
    <style>
        .error {
            color: rgb(229, 33, 33);
        }
    </style>
    <div class="page-wrapper">

        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Employee Salary Slips</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Slips</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a class="btn add-btn"
                            href="{{ route('admin.employee.slip', $slipgenerate[0]->employee_id) }}">Generate
                            Slip
                        </a>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ route('admin.payroll.list') }}" class="btn add-btn"><i class="fa fa-arrow-left"
                                aria-hidden="true"></i>Back</a>
                    </div>
                </div>
            </div>
            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>    
                <strong>{{ $message }}</strong>
            </div>
            @endif
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0" id="department">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Employee ID</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                    <th>Salary</th>
                                    <th>Payslip</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employeeslip as $item)
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a>{{ $item->user->first_name }}</a>
                                            </h2>
                                        </td>
                                        <td>{{ $item->user->employeeID }}</td>
                                        <td>
                                            {{ $item->user->email }}
                                        </td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->monthly }}</td>
                                        <td><a class="btn btn-sm btn-primary"
                                                href="{{ route('admin.employee.generate_slip', $item->id) }}">View
                                                Slip</a></td>

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
@push('js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script>
        $('#department').DataTable({
            paging: true,
            searching: true
        });

        // -------------------show hidden column-------------
    </script>
@endpush
