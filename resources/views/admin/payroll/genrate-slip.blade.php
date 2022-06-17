@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    {{-- <link rel="stylesheet" href="assets/plugins/sweetalert2/sweetalert2.min.css"> --}}
@endpush
@section('content')
<div class="page-wrapper">

    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Payslip</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Payslip</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-white">CSV</button>
                        <button class="btn btn-white">PDF</button>
                        <button class="btn btn-white"><i class="fa fa-print fa-lg"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="payslip-title">Payslip for the month of Feb 2019</h4>
                        <div class="row">
                            <div class="col-sm-6 m-b-20">
                                <img src="assets/img/logo2.png" class="inv-logo" alt="">
                                <ul class="list-unstyled mb-0">
                                    <li>Dreamguy's Technologies</li>
                                    <li>3864 Quiet Valley Lane,</li>
                                    <li>Sherman Oaks, CA, 91403</li>
                                </ul>
                            </div>
                            <div class="col-sm-6 m-b-20">
                                <div class="invoice-details">
                                    <h3 class="text-uppercase">Payslip #49029</h3>
                                    <ul class="list-unstyled">
                                        <li>Salary Month: <span>March, 2019</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 m-b-20">
                                <ul class="list-unstyled">
                                    <li>
                                        <h5 class="mb-0"><strong>{{$employeesalary->user->first_name}}</strong></h5>
                                    </li>
                                    <li><span>Web Designer</span></li>
                                    <li>Employee ID: {{$employeesalary->user->employeeID}}</li>
                                    <li>Joining Date: {{$employeesalary->user->joiningDate}}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div>
                                    <h4 class="m-b-10"><strong>Earnings</strong></h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><strong>Basic Salary</strong> <span class="float-end">${{$employeesalary->basic_salary}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>House Rent Allowance (H.R.A.)</strong> <span class="float-end">${{$employeesalary->hra}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Conveyance</strong> <span class="float-end">${{$employeesalary->conveyance}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Other Allowance</strong> <span class="float-end">${{$employeesalary->allowance}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Earnings</strong> <span class="float-end"><strong>$55</strong></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div>
                                    <h4 class="m-b-10"><strong>Deductions</strong></h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><strong>Tax Deducted at Source (T.D.S.)</strong> <span class="float-end">${{$employeesalary->tds}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Provident Fund</strong> <span class="float-end">${{$employeesalary->pf}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>ESI</strong> <span class="float-end">${{$employeesalary->est}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Loan</strong> <span class="float-end">$300</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Deductions</strong> <span class="float-end"><strong>$59698</strong></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <p><strong>Net Salary: ${{$employeesalary->net_salary}}</strong> (Fifty nine thousand six hundred and ninety eight only.)</p>
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
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        // ------------shoe data table---------------
        $('#department').DataTable({
            paging: true,
            searching: true
        });


    </script>
@endpush
