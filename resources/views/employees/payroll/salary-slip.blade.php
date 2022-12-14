@extends('layouts.app')
@push('css')
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Slip-List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"> Salary slip-List</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="job-content job-widget">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 data-table-theme">
                            <thead>
                                <tr>
                                    <th style="width: 30px;">SR</th>
                                    <th>Date</th>
                                    <th>Month</th>
                                    <th>Payslip Number</th>
                                    <th>Net Salary</th>
                                    <th>Basic Salary</th>
                                    <th>View</th>
                                    <th class="text-center">Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($salipList as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->slip_month)->format('m/Y') }} </td>
                                        <td>{{ \Carbon\Carbon::parse($item->slip_month)->format('M/Y') }} </td>
                                        <td>{{ $item->payslip_number }}</td>
                                        <td>{{ $item->net_salary }}</td>
                                        <td>{{ $item->basic_salary }}</td>
                                        <td> <a class="btn add-btn salarySlip"data-id="{{ $item->id }}">View</a>
                                        </td>
                                        <td class="text-center"><a class="btn add-btn" href="{{ route('employees.payslip.download', $item->id) }}">
                                                Download</a>
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
    <div id="salarySlip" class="modal cust-mod custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pay Slip</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="content container-fluid">
                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col-auto ms-auto">
                                    <div class="btn-group btn-group-sm">
                                        <span class="btn"><a class="btn add-btn"
                                                href="{{ route('employees.payslip.download', ':id') }}"
                                                id="pdf-route">download PDF</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div>
                                                <h4 class="payslip-title"><span id="slip"></span> - Pay Slip</h4>
                                            </div>
                                            <div>
                                                <h5 class="payslip-title">PAY SLIP:#<span id="payslipnumber"></span></h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 m-b-20">
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <h4 class="mb-0"><strong id="fname"></strong></h4>
                                                    </li>
                                                    <li id="Paddress">Address:</li>
                                                    <li id="postal">Pin Code:</li>
                                                    <li id="phone">Phone:</li>
                                                    <li id="emailc"></li>
                                                    <li id="web"></li>

                                                </ul>
                                            </div>
                                            <div class="col-lg-6 m-b-20">
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <h4 class="mb-0"><strong id="fname"></strong></h4>
                                                    </li>
                                                    <li>
                                                        <h4><b><span id="username"></span></b>
                                                    </li>
                                                    <li><span id="desigination"></span></li>
                                                    <li>Employee ID: <span id="empid"></span></li>
                                                    <li>Joining Date: <span id="jd"></span></li>
                                                    <li><span id="emailu"></span></li>
                                                    {{-- <li> 1 Jan 2013</li> --}}
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
                                                                <td>Basic Salary <span class="float-end"
                                                                        id="basicSalary">0</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>House Rent Allowance (H.R.A.)</strong> <span
                                                                        class="float-end" id="hra">0</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Conveyance</strong> <span class="float-end"
                                                                        id="conveyance">0</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Allowance</strong> <span class="float-end"
                                                                        id="oa">0</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Dearness Allowance</strong> <span
                                                                        class="float-end"><strong
                                                                            id="da">0</strong></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Medical Allowance</strong> <span
                                                                        class="float-end"><strong
                                                                            id="ma">0</strong></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Total Earnings</strong> <span
                                                                        class="float-end"><strong
                                                                            id="tEarning">0</strong></span></td>
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
                                                                <td><strong>Tax Deducted at Source (T.D.S.)</strong> <span
                                                                        class="float-end" id="tds">0</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Provident Fund</strong> <span class="float-end"
                                                                        id="pf">0</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>ESI</strong> <span class="float-end"
                                                                        id="est">0</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Prof. Tax</strong> <span class="float-end"
                                                                        id="Proftax">0</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Labour Welfare</strong> <span class="float-end"
                                                                        id="lw">0</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Other</strong> <span class="float-end"
                                                                        id="other">0</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Leave Deduction</strong> <span
                                                                        class="float-end" id="lDeducation">0</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Total Deductions</strong> <span
                                                                        class="float-end"><strong
                                                                            id="tDeducation">0</strong></span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col-md">
                                                <div class="col-md-6">
                                                    <div class="col-sm-12">
                                                        <p> <strong>Month Salary</strong> <span class="float-end"
                                                                id="bs">0</span></p>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">

                                                    <div class="col-sm-12">
                                                        <p><strong>Pay Gross Salary: <span class="float-end"
                                                                    id="paysalary">0</span> </strong></p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
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
@push('plugin-js')
    <script>
        $(document).ready(function() {
            $(document).on("click", ".salarySlip", function() {
                var id = $(this).data('id');
                let url = "{{ route('employees.employees.view.slip', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    type: "GET",
                    cache: false,
                    success: function(res) {
                        $("#pdf-route").attr('href', $("#pdf-route").attr('href').replace(':id',
                            res.slip.id));
                        $("#fname").html(res.company.name);
                        $("#emailc").html(res.company.email);
                        $("#Paddress").html(res.company.p_address);
                        $("#postal").html(res.company.postl);
                        $("#phone").html(res.company.phone);
                        $("#web").html(res.company.web);
                        $("#username").html(res.user.first_name);
                        const monthNames = ["January", "February", "March", "April", "May",
                            "June",
                            "July", "August", "September", "October", "November", "December"
                        ];
                        var formattedDate = new Date(res.slip.salary_month);
                        $("#slip").html(monthNames[formattedDate.getMonth()] + " - " +
                            formattedDate.getFullYear());
                        $("#empid").html(res.user.employeeID);
                        $("#jd").html(res.user.joiningDate);
                        $("#emailu").html(res.user.email);
                        $("#desigination").html(res.user.designation.designation_name);
                        $("#bs").html(res.slip.monthly_netsalary);
                        $("#tds").html(res.slip.tds);
                        $("#da").html(res.slip.da);
                        $("#est").html(res.slip.esi);
                        $("#hra").html(res.slip.hra);
                        $("#lDeducation").html(res.slip.leave_deduction);
                        $("#pf").html(res.slip.pf);
                        $("#conveyance").html(res.slip.conveyance);
                        $("#Proftax").html(res.slip.prof_tax);
                        $("#oa").html(res.slip.allowance);
                        $("#lw").html(res.slip.labour_welfare);
                        $("#ma").html(res.slip.medical_allowance);
                        $("#other").html(res.slip.others);
                        $("#tEarning").html(res.slip.tEarning);
                        $("#tDeducation").html(res.slip.tDeducation + res.slip.leave_deduction);
                        $("#netslip").html(res.slip.net_salary);
                        $("#payslipnumber").html(res.slip.payslip_number);
                        $("#netsalary").html(res.slip.basic_salary);
                        $("#paysalary").html(res.slip.paysalary);
                        $("#basicSalary").html(res.slip.basic_salary);
                        $("#salarySlip").modal('show');
                    }

                });

            });
        });
    </script>
@endpush
