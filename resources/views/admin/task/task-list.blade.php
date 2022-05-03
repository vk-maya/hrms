@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Employee</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employee</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ route('admin.addemployees') }}" class="btn add-btn"><i class="fa fa-plus"></i>
                            Add Employee</a>
                        <div class="view-icons">
                            <a href="{{ route('admin.employees') }}" class="grid-view btn btn-link active"><i
                                    class="fa fa-th"></i></a>
                            <a href="{{ route('admin.employees.list') }}" class="list-view btn btn-link emplist"
                                id="employeeslist"><i class="fa fa-bars"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating">
                        <label class="focus-label">Employee ID</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating">
                        <label class="focus-label">Employee Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating">
                            <option>Select Designation</option>
                            <option>Web Developer</option>
                            <option>Web Designer</option>
                            <option>Android Developer</option>
                            <option>Ios Developer</option>
                        </select>
                        <label class="focus-label">Designation</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="d-grid">
                        <a href="#" class="btn btn-success w-100"> Search </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Employee ID</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th class="text-nowrap">Join Date</th>
                                    <th>Role</th>
                                    <th class="text-end no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $item)
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="#" class="avatar"> <img
                                                        src="{{ asset('storage/uploads/' . $item->image) }}" alt=""></a>
                                                <a href=""><b>{{ $item->name }}</b>
                                                    <span>{{ $item->designation->designation_name }}</span></a>
                                            </h2>
                                        </td>
                                        <td>SDC-EMP-{{ $item->employee_id }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td> {{ \Carbon\Carbon::parse($item->joining_date)->format('d/m/Y') }}</td>
                                        <td>{{ $item->designation->designation_name }}</td>
                                        <td>
                                            <a href="{{route('admin.employ.task.list',$item->id)}}">View Task</a>
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
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".delete", function() {
                var yes = $(this);
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var id = $(this).data("id");
                            var url = "{{ route('admin.employees.delete', ':id') }}";
                            url = url.replace(':id', id);
                            $.ajax({
                                type: "get",
                                url: url,
                                cache: false,
                                success: function(res) {
                                    if (res.msg == 'no') {
                                        swal("unsuccessful! Your Department has been Add Any Employees! ", {
                                            icon: "error",
                                        })
                                    } else {
                                        swal("Success! Your Department has been deleted!", {
                                            icon: "success",
                                        })
                                        $(yes).parent().parent().parent().parent().hide(
                                            0500);

                                    }
                                }
                            });
                        }
                    });
            })
        });
    </script>
@endpush
