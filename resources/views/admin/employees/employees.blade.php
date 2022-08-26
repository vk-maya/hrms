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
                        <a href="{{ route('admin.add-employee') }}" class="btn add-btn"><i class="fa fa-plus"></i>
                            Add Employee</a>
                        <a href="{{ route('admin.add.employees.leavemonth') }}" class="btn add-btn"><i class="fa fa-plus"></i>
                            Add Leave</a>
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
                        <input type="text" class="form-control floating" id="empID">
                        <label class="focus-label">Employee ID</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating" id="empName">
                        <label class="focus-label">Employee Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <select class="form-control select floating" id="designation">
                            <option>Select Designation</option>
                            @foreach ($designation as $item)
                            <option value="{{$item->id}}">{{$item->designation_name}}</option>
                            @endforeach
                        </select>
                        <label class="focus-label">Designation</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="btn-search">
                        <a class="btn btn-success search"> Search </a>
                    </div>
                </div>
            </div>
            @isset($lemployees)
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
                                    {{-- <th>Designation</th> --}}
                                    <th class="text-end no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody id="list">
                                @foreach ($lemployees as $item)
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <div style="display: flex">
                                                <a href="{{route('admin.employees.profile',$item->id)}}" class="avatar"> <img src="@if($item->image != NULL){{asset('storage/uploads/' . $item->image)}}@else{{asset('assets/img/avtar.jpg')}}@endif"></a>
                                                <div>
                                                    <a href="{{route('admin.employees.profile',$item->id)}}"><b>{{$item->first_name.' '.$item->last_name}}</b><br>
                                                        <span>{{$item->designation->designation_name}}</span></a>
                                            </div>
                                        </td>
                                        <td>{{$item->employeeID}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{$item->phone}}</td>
                                        <td> {{ \Carbon\Carbon::parse($item->joiningDate)->format('d M Y') }}</td>
                                        {{-- <td>{{$item->designation->designation_name}}</td> --}}
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.edit-employee',$item->id) }}"><i
                                                            class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <button class="dropdown-item delete" data-id="{{$item->id}}"><i
                                                            class="fa fa-trash-o m-r-5"></i> Delete</button>
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
            @endisset
            @isset($employees)
                <div class="row staff-grid-row" id="grid">
                    @foreach ($employees as $item)
                        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                            <div class="profile-widget">
                                <div class="profile-img">
                                    <a href="{{route('admin.employees.profile',$item->id)}}">
                                    <span class="avatar">
                                        <img src="@if($item->image != NULL){{ asset('storage/uploads/' . $item->image) }}@else{{ asset('assets/img/avtar.jpg')}}@endif"></span></a>
                                </div>
                                <div class="dropdown profile-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i class="material-icons">more</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('admin.edit-employee', $item->id) }}"><i
                                                class="fa fa-pencil me-3"></i> Edit</a>
                                        <button class="dropdown-item delete" data-id="{{ $item->id }}"><i
                                                class="fa fa-trash-alt me-3"></i> Delete</button>
                                        <a class="dropdown-item more-add" href="{{route('admin.employees.information',$item->id)}}"><i class="fa fa-plus text-info  m-r-5"></i>Add More</a>
                                        <a class="dropdown-item status" href="{{route('admin.employees.status',$item->id)}}">
                                            @if ($item->status == 1)
                                                 <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                                <span
                                                    class="yeh-data">Inactive</span>
                                            @else
                                                <i class="fa fa-check m-r-5 text-success"></i> <span
                                                    class="yeh-data">Active</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                                <div>
                                    @if ($item->status == 0)
                                        <span class="position-relative">
                                            <span
                                                class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                            </span>
                                        </span>
                                    @else
                                        <span class="position-relative">
                                            <span
                                                class="position-absolute top-0 start-100 translate-middle p-2 bg-success border border-light rounded-circle">
                                            </span>
                                        </span>
                                    @endif
                                </div>
                                <div class="small text-muted">
                                    <h4 class="user-name m-t-10 mb-0 text-ellipsis">{{$item->first_name.' '.$item->last_name}}</h4>
                                    {{$item->designation->designation_name}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endisset
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
        });
        $(document).on("click", ".search", function() {
            var id = $('#empID').val();
            var name = $('#empName').val();
            var designation = $('#designation').val();

            if (id != NULL || name != NULL || designation != NULL) {
                $.ajax({
                    type: "GET",
                    url: '',
                    cache: false,
                    success: function(res) {

                    }
                });
            }
        });
    });
</script>
@endpush
