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
                        <h3 class="page-title">Employee Salary</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Salary</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_salary"><i
                                class="fa fa-plus"></i> Add Salary</a>
                    </div>

                </div>
            </div>
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating">
                        <label class="focus-label">Employee Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating">
                            <option value=""> -- Select -- </option>
                            <option value="">Employee</option>
                            <option value="1">Manager</option>
                        </select>
                        <label class="focus-label">Role</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating">
                            <option> -- Select -- </option>
                            <option> Pending </option>
                            <option> Approved </option>
                            <option> Rejected </option>
                        </select>
                        <label class="focus-label">Leave Status</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text">
                        </div>
                        <label class="focus-label">From</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text">
                        </div>
                        <label class="focus-label">To</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <a href="#" class="btn btn-success"> Search </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Employee ID</th>
                                    <th>Email</th>
                                    <th>Join Date</th>
                                    <th>Salary</th>
                                    <th>Payslip</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $item)
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="{{ route('admin.employees.profile', $item->id) }}" class="avatar">
                                                    <img src="@if ($item->image != null) {{ asset('storage/uploads/' . $item->image) }}@else{{ asset('assets/img/avtar.jpg') }} @endif"
                                                        alt="Employees Image"></a>
                                                <a href="{{ route('admin.employees.profile', $item->id) }}"><b>{{ $item->first_name }}</b>
                                                </a>
                                            </h2>
                                        </td>
                                        <td>{{ $item->employeeID }}</td>
                                        <td>
                                            {{ $item->email }}
                                        </td>
                                        <td>{{ $item->joiningDate }}</td>
                                        <td>
                                            @if (isset($item->salary->user_id))
                                                <a class="salaryinfo btn add-btn"
                                                    data-id="{{ $item->id }}">{{ $item->salary->net_salary }}</a>
                                            @else
                                                <div class="col-auto float-end ms-auto">
                                                    <a class="btn add-btn addsalary" data-id="{{ $item->id }}"><i
                                                            class="fa fa-plus"></i> Add
                                                        Salary</a>
                                                </div>
                                            @endif
                                        </td>
                                        <td><a class="salaryinfo btn add-btn"
                                                href="{{ route('admin.employee.view_slip', $item->id) }}">View Slip</a>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item edit" href="#"
                                                        data-id="{{ $item->id }}"><i class="fa fa-pencil m-r-5"></i>
                                                        Edit</a>
                                                    <a class="dropdown-item increment" href="#"
                                                        data-id="{{ $item->id }}"><i class="fa fa-plus"
                                                            aria-hidden="true"></i>
                                                        Increment</a>
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
        <div id="add_salary" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Employee Salary</h5>
                        <button type="button" class="close edit" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.payroll.store') }}" method="POST" id="employee">
                            @csrf
                            <div id="editid">
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Employee</label>
                                        <select class="form-control" name="employee_id" id="employeeId">
                                            <option value="">Select Employee</option>
                                            @foreach ($employees as $item)
                                                <option value="{{ $item->id }}">{{ $item->first_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('employee_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Net Salary</label>
                                    <input class="form-control" id="NetSalary_incre1" name="net_salary" type="text"
                                        onkeyup="Percentage(1)">
                                    @error('net_salary')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- ...............................incrementmodel................................. --}}
    {{-- <div id="increment_salary" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Increment Employee</h5>
                    <button type="button" class="close edit" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.employee.increment')}}" method="POST" id="employee">
                        @csrf
                        <div id="incrementid">
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Employee</label>
                                    <select class="form-control" name="employee_id" id="employeeId_incre">
                                        @foreach ($employeeincre as $item)
                                        <option  value="{{$item->id}}">{{$item->first_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label>Net Salary</label>
                                <input class="form-control" id="NetSalary_incre2" name="net_salary" type="text" onkeyup="Percentage(2)">
                                @error('net_salary')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Month</label>
                                    <input class="form-control"name="monthly" id="monthly" type="text" readonly onkeyup="salaryInc()">
                                    @error('basic_salary')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Increment</label>
                                    <input class="form-control"name="increment" id="Inc" type="text" onkeyup="salaryInc()">
                                    @error('basic_salary')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Total</label>
                                    <input class="form-control"name="monthly_new" id="basic_incre"  readonly type="text"  onKeyUp="multiply()">
                                    @error('basic_salary')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <input type="hidden" name="PPRICE" id="amount" value="12" readonly/>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Net Salary</label>
                                    <input class="form-control"name="net_salary_new" readonly id="TOTAL" type="text">
                                    @error('basic_salary')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="text-primary">Earnings</h4>
                                <div class="form-group">
                                    <label>Basic</label>
                                    <input class="form-control"name="basic_salary"  id="basic_increment2" type="text">
                                    <input type="hidden" id="basic_type2" value="{{$increment[10]->type}}">
                                    <input type="hidden" class="form-control" value="{{$increment[10]->description}}" id="BasicSalary_incre2" type="text">
                                    @error('basic_salary')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>DA</label>
                                    <input type="hidden" class="form-control" value="{{$increment[11]->description}}" id="Da_incre2" type="text">
                                    <input class="form-control"name="da" id="Da_incre_total2" type="text">
                                    <input type="hidden"  id="da_type2" value="{{$increment[11]->type}}">
                                </div>
                                <div class="form-group">
                                    <label>HRA</label>
                                    <input type="hidden" class="form-control"  value="{{$increment[12]->description}}" id="Hra_incre2" type="text">
                                    <input class="form-control" name="hra"  id="Hra_incre_total2" type="text">
                                    <input type="hidden"  id="hra_type2" value="{{$increment[12]->type}}">
                                </div>
                                <div class="form-group">
                                    <label>Conveyance</label>
                                    <input type="hidden" class="form-control" value="{{$increment[13]->description}}" id="Conveyance_incre2" type="text">
                                    <input class="form-control"name="conveyance" id="Conveyance_incre_total2" type="text">
                                    <input type="hidden"  id="conveyance_type2" value="{{$increment[13]->type}}">
                                </div>
                                <div class="form-group">
                                    <label>Allowance</label>
                                    <input type="hidden" class="form-control"  value="{{$increment[14]->description}}" id="Allowance_incre2"  type="text">
                                    <input class="form-control" name="allowance"  id="Allowance_incre_total2"  type="text">
                                    <input type="hidden"  id="allowance_type2" value="{{$increment[14]->type}}">
                                </div>
                                <div class="form-group">
                                    <label>Medical Allowance</label>
                                    <input type="hidden" class="form-control" value="{{$increment[15]->description}}" id="Medical_allow_incre2" type="text">
                                    <input class="form-control"name="Medical_allow"  id="Medical_allow_total2" type="text">
                                    <input type="hidden"  id="Medical_type2" value="{{$increment[15]->type}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <h4 class="text-primary">Deductions</h4>
                                <div class="form-group">
                                    <label>TDS</label>
                                    <input type="hidden" class="form-control" value="{{$increment[16]->description}}" id="Tds_incre2" type="text">
                                    <input class="form-control"name="tds" id="Tds_incre_total2" type="text">
                                    <input type="hidden"  id="Tds_type2" value="{{$increment[16]->type}}">
                                </div>
                                <div class="form-group">
                                    <label>ESI</label>
                                    <input type="hidden" class="form-control" value="{{$increment[17]->description}}" id="Est_incre2" type="text">
                                    <input class="form-control"name="est" id="Est_incre_total2" type="text">
                                    <input type="hidden"  id="Est_type2" value="{{$increment[17]->type}}">
                                </div>
                                <div class="form-group">
                                    <label>PF</label>
                                    <input type="hidden" class="form-control" value="{{$increment[18]->description}}" id="Pf_incre2" type="text">
                                    <input class="form-control" name="pf"  id="Pf_incre_total2" type="text">
                                    <input type="hidden"  id="Pf_type2" value="{{$increment[18]->type}}">
                                </div>
                                <div class="form-group">
                                    <label>Prof. Tax</label>
                                    <input type="hidden" class="form-control" value="{{$increment[19]->description}}" id="Prof_tax_incre2" type="text">
                                    <input class="form-control" name="Prof_tax"  id="Prof_tax_incre_total2" type="text">
                                    <input type="hidden"  id="Prof_type2" value="{{$increment[19]->type}}">
                                </div>
                                <div class="form-group">
                                    <label>Labour Welfare</label>
                                    <input type="hidden" class="form-control" value="{{$increment[20]->description}}"  id="Labour_welf_incre2" type="text">
                                    <input class="form-control"name="Labour_welf"  id="Labour_welf_total2" type="text">
                                    <input type="hidden"  id="Labour_type2" value="{{$increment[20]->type}}">

                                </div>
                                <div class="form-group">
                                    <label>Others</label>
                                    <input type="hidden" class="form-control"value="{{$increment[21]->description}}" id="Other_incre2" type="text">
                                    <input class="form-control"name="other"  id="Other_incre_total2" type="text">
                                    <input type="hidden"  id="Other_type2" value="{{$increment[21]->type}}">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    </div>
    {{-- ---------------------salary show modules only user------------------- --}}
    <div id="salaryId" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Salary information</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="content container-fluid">
                        <div class="page-header">
                            <div class="row align-items-center">
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
                                        <h4 class="payslip-title">Salary information </h4>
                                        <div class="row">
                                            <div class="col-lg-12 m-b-20">
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <h3 class="mb-0"> Name <strong id="fname"></strong></h3>
                                                    </li>
                                                    {{-- <li ><span id="role"></span></li> --}}
                                                    <li>Employee ID: <span id="empid"></span></li>
                                                    <li>Joining Date: <span id="jd"></span></li>
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
                                                                <td><strong>Basic Salary</strong> <span class="float-end"
                                                                        id="bs">0</span></td>
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
                                                                <td><strong>Total Deductions</strong> <span
                                                                        class="float-end"><strong
                                                                            id="tDeducation">0</strong></span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <p><strong>Net Salary: <span id="netsalary">0</span> </strong></p>
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

        function multiply() {
            a = Number(document.getElementById('basic_incre').value);
            b = Number(document.getElementById('amount').value);
            c = a * b;
            document.getElementById('TOTAL').value = c;
        }

        function salaryInc() {
            a = Number(document.getElementById('monthly').value);
            b = Number(document.getElementById('Inc').value);
            c = a + b;
            document.getElementById('basic_incre').value = c;
            multiply();
        }

        function Percentage(model) {
            a = Number(document.getElementById('NetSalary_incre' + model).value);
            b = Number(document.getElementById('BasicSalary_incre' + model).value);
            var basic = document.getElementById("basic_type" + model);
            var da = document.getElementById("da_type" + model);
            var hram = document.getElementById("hra_type" + model);
            var conveyance_type = document.getElementById("conveyance_type" + model);
            var allowance_type = document.getElementById("allowance_type" + model);
            var Medical_type = document.getElementById("Medical_type" + model);
            var Tds_type = document.getElementById("Tds_type" + model);
            var Est_type = document.getElementById("Est_type" + model);
            var Pf_type = document.getElementById("Pf_type" + model);
            var Prof_type = document.getElementById("Prof_type" + model);
            var Labour_type = document.getElementById("Labour_type" + model);
            var Other_type = document.getElementById("Other_type" + model);

            if (basic !== null && basic.value === "per") {
                c = a * b / 100;
            } else {
                c = a - b;
            }
            document.getElementById('basic_increment' + model).value = c;

            f = Number(document.getElementById('Da_incre' + model).value);
            if (da !== null && da.value === "per") {
                g = a * f / 100;
            } else {
                g = a - f;
            }
            document.getElementById('Da_incre_total' + model).value = g;

            hra = Number(document.getElementById('Hra_incre' + model).value);
            if (hram !== null && hram.value === "per") {
                hrat = a * hra / 100;
            } else {
                hrat = a - hra;
            }
            document.getElementById('Hra_incre_total' + model).value = hrat;

            Conveyance = Number(document.getElementById('Conveyance_incre' + model).value);
            if (conveyance_type !== null && conveyance_type.value === "per") {
                Conveyance_incre = a * Conveyance / 100;
            } else {
                Conveyance_incre = a - Conveyance;
            }
            document.getElementById('Conveyance_incre_total' + model).value = Conveyance_incre;

            Allowance_incre = Number(document.getElementById('Allowance_incre' + model).value);
            if (allowance_type !== null && allowance_type.value === "per") {
                Allowance = a * Allowance_incre / 100;
            } else {
                Allowance = a - Allowance_incre;
            }
            document.getElementById('Allowance_incre_total' + model).value = Allowance;

            Medical_allow_incre = Number(document.getElementById('Medical_allow_incre' + model).value);
            if (Medical_type !== null && Medical_type.value === "per") {
                Medical_allow = a * Medical_allow_incre / 100;
            } else {
                Medical_allow = a - Medical_allow_incre;
            }
            document.getElementById('Medical_allow_total' + model).value = Medical_allow;

            Tds_incre = Number(document.getElementById('Tds_incre' + model).value);
            if (Tds_type !== null && Tds_type.value === "per") {
                Tds = a * Tds_incre / 100;
            } else {
                Tds = a - Tds_incre;
            }
            document.getElementById('Tds_incre_total' + model).value = Tds;

            Est_incre = Number(document.getElementById('Est_incre' + model).value);
            if (Est_type !== null && Est_type.value === "per") {
                Est = a * Est_incre / 100;
            } else {
                Est = a - Est_incre;
            }
            document.getElementById('Est_incre_total' + model).value = Est;

            Pf_incre = Number(document.getElementById('Pf_incre' + model).value);
            if (Pf_type !== null && Pf_type.value === "per") {
                pf = a * Pf_incre / 100;
            } else {
                pf = a - Pf_incre;
            }
            document.getElementById('Pf_incre_total' + model).value = pf;

            Prof_tax_incre = Number(document.getElementById('Prof_tax_incre' + model).value);
            if (Prof_type !== null && Prof_type.value === "per") {
                Prof = a * Prof_tax_incre / 100;
            } else {
                Prof = a - Prof_tax_incre;
            }
            document.getElementById('Prof_tax_incre_total' + model).value = Prof;

            Labour_welf_incre = Number(document.getElementById('Labour_welf_incre' + model).value);
            if (Labour_type !== null && Labour_type.value === "per") {
                Labour = a * Labour_welf_incre / 100;
            } else {
                Labour = a - Labour_welf_incre;
            }
            document.getElementById('Labour_welf_total' + model).value = Labour;

            Other_incre = Number(document.getElementById('Other_incre' + model).value);
            if (Other_type !== null && Other_type.value === "per") {
                Other = a * Other_incre / 100;
            } else {
                Other = a - Other_incre;
            }
            document.getElementById('Other_incre_total' + model).value = Other;

        }
        // -------------------show hidden column-------------
        $(document).ready(function() {
            $(document).on("click", '.edit', (function() {
                $("#editid").html("<input type='hidden' name='id' value='" + $(this).data('id') + "'>");
            }));

        });
        // ------------------------edit---------------------
        $(document).ready(function() {
            $('#add_salary').on('hidden.bs.modal', function(e) {
                $("#editid").html('');
                $("#employeeId").val('');
                $("#NetSalary_incre1").val('');
                $("#basic_increment1").val('');
                $("#Da_incre_total1").val('');
                $("#Tds_incre_total1").val('');
                $("#Est_incre_total1").val('');
                $("#Hra_incre_total1").val('');
                $("#Pf_incre_total1").val('');
                $("#Conveyance_incre_total1").val('');
                $("#Prof_tax_incre_total1").val('');
                $("#Allowance_incre_total1").val('');
                $("#Labour_welf_total1").val('');
                $("#Medical_allow_total1").val('');
                $("#Other_incre_total1").val('');
            })
            $(document).on("click", ".edit", function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "payroll/edit/" + id,
                    type: "get",
                    cache: false,
                    success: function(res) {
                        $('#submit').text("Update");
                        $('#inputid').val(res.edit.id);
                        $('#employeeId').val(res.edit.employee_id);
                        $('#NetSalary_incre1').val(res.edit.net_salary);
                        $('#basic_increment1').val(res.edit.basic_salary);
                        $('#Da_incre_total1').val(res.edit.da);
                        $('#Tds_incre_total1').val(res.edit.tds);
                        $('#Est_incre_total1').val(res.edit.est);
                        $('#Hra_incre_total1').val(res.edit.hra);
                        $('#Pf_incre_total1').val(res.edit.pf);
                        $('#Conveyance_incre_total1').val(res.edit.conveyance);
                        $('#Prof_tax_incre_total1').val(res.edit.Prof_tax);
                        $('#Allowance_incre_total1').val(res.edit.allowance);
                        $('#Labour_welf_total1').val(res.edit.Labour_welf);
                        $('#Medical_allow_total1').val(res.edit.Medical_allow);
                        $('#Other_incre_total1').val(res.edit.other);
                        $("#add_salary").modal('show');
                        Percentage(1);

                    }

                });

            });
        });

        // -------------------increment model-------------
        $(document).ready(function() {
            $(document).on("click", '.increment', (function() {
                $("#incrementid").html("<input type='hidden' name='id' value='" + $(this).data('id') +
                    "'>");
            }));

        });
        $(document).ready(function() {
            $('#increment_salary').on('hidden.bs.modal', function(e) {
                $("#incrementid").html('');
                $("#employeeId_incre").val('');
                $("#NetSalary_incre2").val('');
                $("#monthly").val('');

            })
            $(document).on("click", ".increment", function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "payroll/edit/" + id,
                    type: "get",
                    cache: false,
                    success: function(res) {
                        $('#submit').text("Update");
                        $('#inputid').val(res.edit.id);
                        $('#employeeId_incre').val(res.edit.employee_id);
                        $('#NetSalary_incre2').val(res.edit.net_salary);
                        $('#monthly').val(res.edit.monthly);
                        $("#increment_salary").modal('show');
                        Percentage(2);
                    }

                });

            });
        });
    </script>
    <script>
        if ($("#employee").length > 0) {
            $("#employee").validate({

                rules: {
                    employee_id: {
                        required: true,
                    },

                    net_salary: {
                        required: true,
                    },

                    basic_salary: {
                        required: true,
                    },
                },
                messages: {

                    employee_id: {
                        required: "Please enter employee",
                    },
                    net_salary: {
                        required: "Please enter valid net salary",
                    },

                    basic_salary: {
                        required: "Please enter basic salary",
                    },
                },
            })
        }
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".salaryinfo", function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "salary/info/" + id,
                    type: "get",
                    cache: false,
                    success: function(res) {
                        // console.log(res.salary)
                        $("#fname").html(res.user.first_name);
                        $("#empid").html(res.user.employeeID);
                        $("#jd").html(res.user.joiningDate);
                        $("#bs").html(res.salary.basic_salary);
                        $("#hra").html(res.salary.hra);
                        $("#conveyance").html(res.salary.conveyance);
                        $("#oa").html(res.salary.allowance);
                        $("#da").html(res.salary.da);
                        $("#ma").html(res.salary.medical_allowance);
                        $("#tds").html(res.salary.tds);
                        $("#pf").html(res.salary.pf);
                        $("#est").html(res.salary.esi);
                        $("#Proftax").html(res.salary.prof_tax);
                        $("#lw").html(res.salary.labour_welfare);
                        $("#other").html(res.salary.others);
                        $("#tDeducation").html(res.salary.tDeducation);
                        $("#tEarning").html(res.salary.tEarning);
                        $("#netsalary").html(res.salary.net_salary);
                        $("#salaryId").modal('show');
                    }

                });

            });
        });
    </script>
    <script>
        $(document).ready(function() {
            function InputMaker(data, type) {
                let html = '';
                console.log(data);
                $.each(data, function(indexInArray, valueOfElement) {
                    if (valueOfElement.type == type) {
                        html += `<div class="form-group">
                            <label>${valueOfElement.title}</label>
                            <input type="text" class="form-control" name="${valueOfElement.title.toLowerCase().replace(' ','_')}" id="basic_increment1">
                            <input type="hidden" id="basic_type1" value="">
                            <input type="hidden" class="form-control" value="" id="BasicSalary_incre1">
                        </div>`;
                    }
                });
                return html;
            }
            $(document).on("click", ".addsalary", function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "add/salary/" + id,
                    type: "get",
                    cache: false,
                    success: function(res) {
                        console.log(res.salary);
                        $("#employeeId").children().prop('selected', false);
                        $("#employeeId").find("option[value='" + res.salary.id + "']").prop(
                            'selected', true);
                        $("#earningInput").html(InputMaker(res.salary.user_salary_data,
                            'earning'));
                        $("#deductInput").html(InputMaker(res.salary.user_salary_data,
                            'deduction'));
                        $("#add_salary").modal('show');
                    }

                });

            });
        });
    </script>
@endpush
