<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<style>
    .payslip-title {
    text-align: center;
    text-decoration: underline;
    text-transform: uppercase;
    margin: 0 0 20px;
}
html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, 
{
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    vertical-align: baseline;

}
.m-b-20 {
    margin-bottom: 20px!important;
}


.col-sm-6 {
    flex: 0 0 auto;
    width: 50%;
}
.invoice-details {
    float: right;
    text-align: right;
}
.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
    margin-top: 0;
    margin-bottom: 0.5rem;
    font-weight: 500;
    line-height: 1.2;
}
.row {
    --bs-gutter-x: 1.5rem;
    --bs-gutter-y: 0;
    display: flex;
    flex-wrap: wrap;
    margin-top: calc(-1 * var(--bs-gutter-y));
    margin-right: calc(-.5 * var(--bs-gutter-x));
    margin-left: calc(-.5 * var(--bs-gutter-x));
}

.card-body {
    flex: 1 1 auto;
    padding: 1rem 1rem;
}
.table {
    --bs-table-bg: transparent;
    --bs-table-accent-bg: transparent;
    --bs-table-striped-color: #212529;
    --bs-table-striped-bg: rgba(0, 0, 0, 0.05);
    --bs-table-active-color: #212529;
    --bs-table-active-bg: rgba(0, 0, 0, 0.1);
    --bs-table-hover-color: #212529;
    --bs-table-hover-bg: rgba(0, 0, 0, 0.075);
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
    vertical-align: top;
    border-color: #dee2e6;
}

</style>
<body>
    
    <div class="page-wrapper">

        <div class="content container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="payslip-title">Payslip for the month of Feb 2019</h4>
                            <div class="row">
                                <div class="col-sm-6 m-b-20">
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
                                            <h5 class="mb-0"><strong>{{ $employeesalary->user->first_name }}</strong>
                                            </h5>
                                        </li>
                                        <li><span>Web Designer</span></li>
                                        <li>Employee ID: {{ $employeesalary->user->employeeID }}</li>
                                        <li>Joining Date: {{ $employeesalary->date }}</li>
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
                                                    <td><strong>Monthly</strong> <span
                                                            class="float-end">₹{{ $employeesalary->monthly }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Basic</strong> <span
                                                            class="float-end">₹{{ $employeesalary->basic_salary / 12 }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>DA</strong> <span
                                                            class="float-end">₹{{ $employeesalary->da / 12 }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>House Rent Allowance (H.R.A.)</strong> <span
                                                            class="float-end">₹{{ $employeesalary->hra / 12 }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Conveyance</strong> <span
                                                            class="float-end">₹{{ $employeesalary->conveyance / 12 }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Allowance</strong> <span
                                                            class="float-end">₹{{ $employeesalary->allowance / 12 }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Medical Allowance</strong> <span
                                                            class="float-end">₹{{ $employeesalary->Medical_allow / 12 }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Total Earnings</strong> <span class="float-end"><strong>
                                                                ₹{{ $employeesalary->monthly +
                                                                    $employeesalary->basic_salary / 12 +
                                                                    $employeesalary->da / 12 +
                                                                    $employeesalary->hra / 12 +
                                                                    $employeesalary->conveyance / 12 +
                                                                    $employeesalary->allowance / 12 +
                                                                    $employeesalary->Medical_allow / 12 }}</strong></span>
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
                                                    <td><strong>Tax Deducted at Source (T.D.S.)</strong> <span
                                                            class="float-end">₹{{ $employeesalary->tds / 12 }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Provident Fund</strong> <span
                                                            class="float-end">₹{{ $employeesalary->pf / 12 }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>ESI</strong> <span
                                                            class="float-end">₹{{ $employeesalary->est / 12 }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Prof. Tax</strong> <span
                                                            class="float-end">₹{{ $employeesalary->Prof_tax / 12 }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Labour Welfare</strong> <span
                                                            class="float-end">₹{{ $employeesalary->Labour_welf / 12 }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Other</strong> <span
                                                            class="float-end">₹{{ $employeesalary->other / 12 }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Total Deductions</strong> <span class="float-end"><strong>₹
                                                                {{ $employeesalary->tds / 12 +
                                                                    $employeesalary->pf / 12 +
                                                                    $employeesalary->est / 12 +
                                                                    $employeesalary->Prof_tax / 12 +
                                                                    $employeesalary->Labour_welf / 12 +
                                                                    $employeesalary->other / 12 }}</strong></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <p><strong>Net Salary:
                                            ₹</strong>
                                        (Fifty nine thousand
                                        six hundred and ninety eight only.)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <script src="assets/js/app.js"></script>
</body>

<!-- Mirrored from smarthr.dreamguystech.com/blue/salary-view.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Apr 2022 10:27:29 GMT -->

</html>
