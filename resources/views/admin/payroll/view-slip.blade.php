@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Employee Salary Slips</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin.payroll.list') }}">Salary</a></li>
                            <li class="breadcrumb-item active">Slips</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">                 
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ route('admin.emp.report.emp',$id) }}" class="btn add-btn"><i class="fa fa-plus-circle"
                                aria-hidden="true"></i>Generate</a>
                    </div>
                </div>
            </div>          
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0" id="department">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Employee ID</th>
                                    <th>Email</th>
                                    <th>Salary</th>
                                    <th>Month</th>
                                    <th>Payslip</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employeeslip as $item)
                                    <tr>
                                        <td>
                                            <a href="{{route('admin.employees.profile',$item->user->id)}}" class="avatar"> <img
                                                src="@if($item->user->image != NULL){{ asset('storage/uploads/' . $item->user->image) }}@else{{ asset('assets/img/avtar.jpg')}}@endif" alt="Employees Image"></a>
                                        <a href="{{route('admin.employees.profile',$item->user->id)}}"><b>{{  $item->user->first_name }}</b></a></td>
                                        <td>{{ $item->user->employeeID }}</td>
                                        <td>{{ $item->user->email }}</td>
                                        <td>{{ $item->basic_salary }}</td>
                                        <td>{{ Carbon\Carbon::parse($item->salary_month )->format('M-Y')}}</td>
                                        <td> <a class="salarySlip btn btn-sm btn-success"data-id="{{ $item->id }}">Slip View</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- //slip module --}}
    <div id="salarySlip" class="modal custom-modal fade" role="dialog">
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
                                <div class="col-auto float-end ms-auto">
                                    <div class="btn-group btn-group-sm">
                                        <span class="btn btn-white"><a href="{{route('admin.payslip.download',':id')}}" id="pdf-route">PDF</a></span>
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
                                            <h5 class="payslip-title" >PAY SLIP:#<span id="payslipnumber"></span></h5>
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
                                                    <li><h4><b><span id="username"></span></b></li>
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
                                                                <td>Basic Salary <span
                                                                    class="float-end" id="basicSalary">0</span></td>
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
                                                                <td><strong>Leave Deduction</strong> <span class="float-end"
                                                                        id="lDeducation">0</span>
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
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="col-sm-12">
                                                        <p> <strong>Month Salary</strong> <span class="float-end" id="bs">0</span></p>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">

                                                    <div class="col-sm-12">
                                                        <p><strong>Pay Gross Salary: <span class="float-end" id="paysalary">0</span> </strong></p>
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
        <script>
            $(document).ready(function() {
                $(document).on("click", ".salarySlip", function() {
                    var id = $(this).data('id');
                    let url = "{{route('admin.employees.view.slip',':id')}}";
                    url= url.replace(':id',id);
                    $.ajax({
                        url: url,
                        type: "GET",
                        cache: false,
                        success: function(res) {
                            console.log(res);
                            $("#pdf-route").attr('href',$("#pdf-route").attr('href').replace(':id',res.slip.id));
                            $("#fname").html(res.company.name);
                            $("#emailc").html(res.company.email);
                            $("#Paddress").html(res.company.p_address);
                            $("#postal").html(res.company.postl);
                            $("#phone").html(res.company.phone);
                            $("#web").html(res.company.web);
                            $("#username").html(res.slip.user.first_name);
                            const monthNames = ["January", "February", "March", "April", "May", "June",
                            "July", "August", "September", "October", "November", "December"
                            ];
                            var formattedDate = new Date(res.slip.salary_month);
                            $("#slip").html(monthNames[formattedDate.getMonth()]+" - "+ formattedDate.getFullYear());
                            $("#empid").html(res.slip.user.employeeID);
                            $("#jd").html(res.slip.user.joiningDate);
                            $("#emailu").html(res.slip.user.email);
                            $("#desigination").html(res.slip.user.user_designation.designation_name);
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
                            $("#tDeducation").html(res.slip.tDeducation+res.slip.leave_deduction);
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
