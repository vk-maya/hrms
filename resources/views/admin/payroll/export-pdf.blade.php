<!DOCTYPE html>
<html lang="en">

<head>

</head>

<body>
    <div class="row">
        <div class="col-md-12">
            <div>
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">                     
                        <div class="modal-body">
                            <div class="content container-fluid">                             
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div>
                                                        <h4 class="payslip-title"><span id="slip"></span> - Pay
                                                            Slip
                                                        </h4>
                                                    </div>
                                                    <div>
                                                        <h5 class="payslip-title">PAY SLIP:#
                                                            {{ $employeesalary->payslip_number }}<span
                                                                id="payslipnumber"></span></h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 m-b-20">
                                                        <ul class="list-unstyled">
                                                            <li>
                                                                <h4 class="mb-0"><strong>{{ $company->name }}</strong>
                                                                </h4>
                                                            </li>
                                                            <li id="Paddress">Address @if (isset($company->p_address))
                                                                 {{ $company->p_address }}
                                                                @else
                                                                    Not Available
                                                                @endif
                                                            </li>
                                                            <li id="postal">Pin Code: @if (isset($company->postl))
                                                                    {{ $company->postl }}
                                                                @else
                                                                    Not Available
                                                                @endif
                                                            </li>
                                                            <li id="phone">Phone: @if (isset($company->phone))
                                                                    {{ $company->phone }}
                                                                @else
                                                                    Not Available
                                                                @endif
                                                            </li>
                                                            <li id="emailc">
                                                                @if (isset($company->email))
                                                                    {{ $company->email }}
                                                                @else
                                                                    Not Available
                                                                @endif
                                                            </li>
                                                            <li id="web">
                                                                @if (isset($company->web))
                                                                    {{ $company->web }}
                                                                @else
                                                                    Not Available
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-6 m-b-20">
                                                        <ul class="list-unstyled">
                                                            <li>
                                                                <h4 class="mb-0"><strong>
                                                                        @if (isset($employeesalary->user->first_name))
                                                                            {{ $employeesalary->user->first_name }}
                                                                        @else
                                                                            Not Available
                                                                        @endif
                                                                    </strong></h4>
                                                            </li>
                                                            <li>
                                                                @if (isset($employeesalary->user->userDesignation->designation_name))
                                                                    {{$employeesalary->user->userDesignation->designation_name }}
                                                                @else
                                                                    Not Available
                                                                @endif
                                                            </li>
                                                            <li>Employee ID: @if (isset($employeesalary->user->employeeID))
                                                                    {{ $employeesalary->user->employeeID }}
                                                                @else
                                                                    Not Available
                                                                @endif
                                                            </li>
                                                            <li>Joining Date: @if (isset($employeesalary->user->joiningDate))
                                                                    {{ $employeesalary->user->joiningDate }}
                                                                @else
                                                                    Not Available
                                                                @endif
                                                            </li>
                                                            <li>
                                                                @if (isset($employeesalary->user->email))
                                                                    {{ $employeesalary->user->email }}
                                                                @else
                                                                    Not Available
                                                                @endif
                                                            </li>
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
                                                                        <td>Basic Salary @if (isset($employeesalary->basic_salary))
                                                                                {{ $employeesalary->basic_salary }}
                                                                            @else
                                                                                0
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>House Rent Allowance
                                                                                (H.R.A.)</strong>
                                                                            @if (isset($employeesalary->hra))
                                                                                {{ $employeesalary->hra }}
                                                                            @else
                                                                                0
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Conveyance</strong>
                                                                            @if (isset($employeesalary->conveyance))
                                                                                {{ $employeesalary->conveyance }}
                                                                            @else
                                                                                0
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Allowance</strong>
                                                                            @if (isset($employeesalary->allowance))
                                                                                {{ $employeesalary->allowance }}
                                                                            @else
                                                                                0
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Dearness Allowance</strong><strong
                                                                                id="da">
                                                                                @if (isset($employeesalary->da))
                                                                                    {{ $employeesalary->da }}
                                                                                @else
                                                                                    0
                                                                                @endif
                                                                            </strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Medical Allowance</strong> <strong
                                                                                id="ma">
                                                                                @if (isset($employeesalary->medical_allowance))
                                                                                    {{ $employeesalary->medical_allowance }}
                                                                                @else
                                                                                    0
                                                                                @endif
                                                                            </strong>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Total Earnings</strong>
                                                                            class="float-end"><strong>
                                                                                @if (isset($employeesalary->tEarning))
                                                                                    {{ $employeesalary->tEarning }}
                                                                                @else
                                                                                    0
                                                                                @endif
                                                                            </strong>
                                                                        </td>
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
                                                                        <td><strong>Tax Deducted at Source
                                                                                (T.D.S.)</strong>
                                                                            <span class="float-end">
                                                                                @if (isset($employeesalary->tds))
                                                                                    {{ $employeesalary->tds }}
                                                                                @else
                                                                                    0
                                                                                @endif
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Provident Fund</strong> <span
                                                                                class="float-end" id="pf">
                                                                                @if (isset($employeesalary->pf))
                                                                                    {{ $employeesalary->pf }}
                                                                                @else
                                                                                    0
                                                                                @endif
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>ESI</strong> <span class="float-end"
                                                                                id="est">
                                                                                @if (isset($employeesalary->esi))
                                                                                    {{ $employeesalary->esi }}
                                                                                @else
                                                                                    0
                                                                                @endif
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Prof. Tax</strong> <span
                                                                                class="float-end" id="Proftax">
                                                                                @if (isset($employeesalary->prof_tax))
                                                                                    {{ $employeesalary->prof_tax }}
                                                                                @else
                                                                                    0
                                                                                @endif
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Labour Welfare</strong> <span
                                                                                class="float-end" id="lw">
                                                                                @if (isset($employeesalary->labour_welfare))
                                                                                    {{ $employeesalary->labour_welfare }}
                                                                                @else
                                                                                    0
                                                                                @endif
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Other</strong> <span
                                                                                class="float-end" id="other">
                                                                                @if (isset($employeesalary->others))
                                                                                    {{ $employeesalary->others }}
                                                                                @else
                                                                                    0
                                                                                @endif
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Leave Deduction</strong> <span
                                                                                class="float-end" id="lDeducation">
                                                                                @if (isset($employeesalary->leave_deduction))
                                                                                    {{ $employeesalary->leave_deduction }}
                                                                                @else
                                                                                    0
                                                                                @endif
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Total Deductions</strong> <span
                                                                                class="float-end"><strong
                                                                                    id="tDeducation">
                                                                                    @if (isset($employeesalary->tDeducation))
                                                                                        {{ $employeesalary->tDeducation }}
                                                                                    @else
                                                                                        0
                                                                                    @endif
                                                                                </strong></span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="col-sm-12">
                                                                <p> <strong>Month Salary</strong> <span
                                                                        class="float-end" id="bs">
                                                                        @if (isset($employeesalary->monthly_netsalary))
                                                                            {{ $employeesalary->monthly_netsalary }}
                                                                        @else
                                                                            0
                                                                        @endif
                                                                    </span></p>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">

                                                            <div class="col-sm-12">
                                                                <p><strong>Pay Gross Salary: <span class="float-end"
                                                                            id="paysalary">
                                                                            @if (isset($employeesalary->paysalary))
                                                                                {{ $employeesalary->paysalary }}
                                                                            @else
                                                                                0
                                                                            @endif
                                                                        </span> </strong></p>
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
        </div>
    </div>
</body>

</html>
