@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    {{-- <link rel="stylesheet" href="assets/plugins/sweetalert2/sweetalert2.min.css"> --}}
@endpush
@section('content')
<style>
    .error{
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
                            <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
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
                    <a href="#" class="btn btn-success w-100"> Search </a>
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
                                @foreach ($employeesalary as $item)
                                    
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                         
                                            <a>{{$item->user->first_name}}</a>
                                        </h2>
                                    </td>
                                    <td>{{$item->user->employeeID}}</td>
                                    <td>
                                        {{$item->user->email}}
                                    </td>
                                    <td>{{$item->user->joiningDate}}</td>
                                    <td>{{$item->basic_salary}}</td>
                                    <td><a class="btn btn-sm btn-primary" href="{{(route('admin.employee.view_slip',$item->employee_id))}}">View Slip</a></td>
                                    <td class="text-end">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item edit" href="#"
                                                     data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i>
                                                    Edit</a>
                                                 <a class="dropdown-item increment" href="#"
                                                     data-id="{{$item->id}}"><i class="fa fa-plus" aria-hidden="true"></i>
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
                        <form action="{{route('admin.payroll.store')}}" method="POST" id="employee">
                            @csrf
                            <div id="editid">
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Employee</label>
                                        <select class="select" name="employee_id" id="employeeId" >
                                            <option value="">Select Employee</option>
                                            @foreach ($employee as $item)
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
                                    <input class="form-control" id="NetSalary" name="net_salary" type="text">
                                    @error('net_salary')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="text-primary">Earnings</h4>
                                    <div class="form-group">
                                        <label>Basic</label>
                                        <input class="form-control"name="basic_salary" id="BasicSalary" type="text">
                                        @error('basic_salary')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>DA(40%)</label>
                                        <input class="form-control"name="da" id="Da" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>HRA(15%)</label>
                                        <input class="form-control" name="hra" id="Hra" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Conveyance</label>
                                        <input class="form-control"name="conveyance" id="Conveyance" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Allowance</label>
                                        <input class="form-control" name="allowance" id="Allowance"  type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Medical Allowance</label>
                                        <input class="form-control"name="Medical_allow" id="Medical_allow" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h4 class="text-primary">Deductions</h4>
                                    <div class="form-group">
                                        <label>TDS</label>
                                        <input class="form-control"name="tds" id="Tds" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>ESI</label>
                                        <input class="form-control"name="est" id="Est" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>PF</label>
                                        <input class="form-control" name="pf" id="Pf" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Prof. Tax</label>
                                        <input class="form-control" name="Prof_tax" id="Prof_tax" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Labour Welfare</label>
                                        <input class="form-control"name="Labour_welf" id="Labour_welf" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Others</label>
                                        <input class="form-control"name="other" id="Other" type="text">
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
     <div id="increment_salary" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Increment Employee</h5>
                    <button type="button" class="close edit" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="employee">
                        @csrf
                        <div id="incrementid">
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Employee</label>
                                    <select disabled="true" class="form-control" name="employee_id" id="employeeId_incre">
                                        @foreach ($employee as $item)
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
                                <input class="form-control" id="NetSalary_incre" name="net_salary" type="text">
                                @error('net_salary')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Month</label>
                                    <input class="form-control"name="basic_salary" id="monthInc" type="text" onkeyup="salaryInc()">
                                    @error('basic_salary')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Increment</label>
                                    <input class="form-control"name="basic_salary" id="Inc" type="text" onkeyup="salaryInc()">
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
                                    <input class="form-control"name="basic_salary" id="basic_incre" type="text"  onKeyUp="multiply()">
                                    @error('basic_salary')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <input type="hidden" name="PPRICE" id="amount" value="12" readonly/>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Net Salary</label>
                                    <input class="form-control"name="basic_salary" id="TOTAL" type="text">
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
                                    <input class="form-control"name="basic_salary" value="{{$increment[10]->description}}" id="BasicSalary_incre" type="text">
                                    @error('basic_salary')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>DA(40%)</label>
                                    <input class="form-control"name="da" value="{{$increment[11]->description}}" id="Da_incre" type="text">
                                </div>
                                <div class="form-group">
                                    <label>HRA(15%)</label>
                                    <input class="form-control" name="hra" value="{{$increment[12]->description}}" id="Hra_incre" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Conveyance</label>
                                    <input class="form-control"name="conveyance" value="{{$increment[13]->description}}" id="Conveyance_incre" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Allowance</label>
                                    <input class="form-control" name="allowance" value="{{$increment[14]->description}}" id="Allowance_incre"  type="text">
                                </div>
                                <div class="form-group">
                                    <label>Medical Allowance</label>
                                    <input class="form-control"name="Medical_allow" value="{{$increment[15]->description}}" id="Medical_allow_incre" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <h4 class="text-primary">Deductions</h4>
                                <div class="form-group">
                                    <label>TDS</label>
                                    <input class="form-control"name="tds" value="{{$increment[16]->description}}" id="Tds_incre" type="text">
                                </div>
                                <div class="form-group">
                                    <label>ESI</label>
                                    <input class="form-control"name="est" value="{{$increment[17]->description}}" id="Est_incre" type="text">
                                </div>
                                <div class="form-group">
                                    <label>PF</label>
                                    <input class="form-control" name="pf" value="{{$increment[18]->description}}" id="Pf_incre" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Prof. Tax</label>
                                    <input class="form-control" name="Prof_tax" value="{{$increment[19]->description}}" id="Prof_tax_incre" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Labour Welfare</label>
                                    <input class="form-control"name="Labour_welf" value="{{$increment[18]->description}}"  id="Labour_welf_incre" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Others</label>
                                    <input class="form-control"name="other" value="{{$increment[19]->description}}" id="Other_incre" type="text">
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
            a = Number(document.getElementById('monthInc').value);
            b = Number(document.getElementById('Inc').value);
            c = a + b;
            document.getElementById('basic_incre').value = c;
            multiply();
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
                $("#NetSalary").val('');
                $("#BasicSalary").val('');
                $("#Tds").val('');
                $("#Da").val('');
                $("#Est").val('');
                $("#Hra").val('');
                $("#Pf").val('');
                $("#Conveyance").val('');
                $("#Prof_tax").val('');
                $("#Allowance").val('');
                $("#Labour_welf").val('');
                $("#Medical_allow").val('');
                $("#Other").val('');
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
                        $('#NetSalary').val(res.edit.net_salary);
                        $('#BasicSalary').val(res.edit.basic_salary);
                        $('#Tds').val(res.edit.tds);
                        $('#Da').val(res.edit.da);
                        $('#Est').val(res.edit.est);
                        $('#Hra').val(res.edit.hra);
                        $('#Pf').val(res.edit.pf);
                        $('#Conveyance').val(res.edit.conveyance);
                        $('#Prof_tax').val(res.edit.Prof_tax);
                        $('#Allowance').val(res.edit.allowance);
                        $('#Labour_welf').val(res.edit.Labour_welf);
                        $('#Medical_allow').val(res.edit.Medical_allow);
                        $('#Other').val(res.edit.other);
                        $("#add_salary").modal('show');
                    }

                });

            });
        });

         // -------------------increment model-------------
        $(document).ready(function() {
            $(document).on("click", '.increment', (function() {
                $("#incrementid").html("<input type='hidden' name='id' value='" + $(this).data('id') + "'>");
            }));
    
        });
        $(document).ready(function() {
            $('#increment_salary').on('hidden.bs.modal', function(e) {
                $("#incrementid").html('');
                $("#employeeId_incre").val('');
                $("#NetSalary_incre").val('');
               
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
                        $('#NetSalary_incre').val(res.edit.net_salary);
                        $("#increment_salary").modal('show');
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
@endpush
