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
                        <h3 class="page-title">Employee Salary</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Salary E-D</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#addsalary"><i
                                class="fa fa-plus"></i>Add Salary eran And Deducation</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h3 class="mt-3">Earning</h3>
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Count.</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($salarym as $key => $item)
                                        @if ($item->salarymanagement->type == 'earning')
                                            <tr class="holiday-completed">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->salarymanagement->title }}</td>
                                                <td>{{ $item->value }}</td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="{{ route('admin.salary.earn.deducation', $item->id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <h3 class="mt-3">Deductions </h3>

                            <table class="table table-striped custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Count.</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($salarym as $key => $item)
                                        @if ($item->salarymanagement->type == 'deduction')
                                            <tr class="holiday-completed">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->salarymanagement->title }}</td>
                                                <td>{{ $item->value }}</td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.salary.earn.deducation', $item->id) }}"><i
                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="addsalary" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Earning deduction </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.salary.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="text-primary">Earnings</h4>
                                @foreach ($data as $item)
                                    @if ($item->type == 'earning')
                                        <div class="form-group">
                                            <label>{{ $item->title }} %</label>
                                            <input class="form-control" name="ids[{{$item->id}}]" type="text">
                                            {{-- <input class="form-control" name="ids[{{strtolower(str_replace(" ","_", $item->title))}}]" type="text"value=""> --}}

                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-sm-6">
                                <h4 class="text-primary">Deductions</h4>
                                @foreach ($data as $item)
                                    @if ($item->type == 'deduction')
                                        <div class="form-group">
                                            <label>{{ $item->title }} %</label>
                                            <input class="form-control" name="ids[{{$item->id}}]"
                                            {{-- <input class="form-control" name="ids[{{strtolower(str_replace(" ","_", $item->title))}}]" --}}
                                                type="text"value="">
                                        </div>
                                    @endif
                                @endforeach
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
    @if (isset($dataedit))
        <div id="editmanagement" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Employee</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.salary.earn.deducation.edit') }}" method="POST">
                            @csrf
                            <div class="row ">
                                <div class="col-sm-6 ">
                                    <h4 class="text-primary">{{ucfirst($dataedit->salarymanag->type) }}</h4>
                                    <div class="form-group align-items-center">
                                        <label>{{$dataedit->salarymanag->title }} %</label>
                                        <input class="form-control" name="value" type="text" value="{{$dataedit->value}}">
                                        <input type="hidden" value="{{$dataedit->id}}" name="id">
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
    @endif
@endsection
@push('js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    @if (isset($dataedit))
        <script>
            $(document).ready(function() {
                $("#editmanagement").modal('show');
            });
        </script>
    @endif
@endpush
