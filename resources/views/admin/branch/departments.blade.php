@extends('admin.layouts.app')
@push('css')
    <style>
        .input-switch {
            display: none;
        }

        .label-switch {
            display: inline-block;
            position: relative;
        }

        .label-switch::before,
        .label-switch::after {
            content: "";
            display: inline-block;
            cursor: pointer;
            transition: all 0.5s;
        }

        .label-switch::before {
            width: 3em;
            height: 1em;
            border: 1px solid #757575;
            border-radius: 4em;
            background: #888888;
        }

        .label-switch::after {
            position: absolute;
            left: 0;
            top: -12%;
            width: 1.5em;
            height: 1.5em;
            border: 1px solid #757575;
            border-radius: 4em;
            background: #ffffff;
        }

        .input-switch:checked~.label-switch::before {
            background: #00a900;
            border-color: #008e00;
            margin-top: 2px;
        }

        .input-switch:checked~.label-switch::after {
            left: unset;
            right: 0;
            background: #00ce00;
            border-color: #009a00;
            /* margin-top: 4px; */
        }

        .info-text {
            display: inline-block;
        }

        .info-text::before {
            content: "Not active";
        }

        .input-switch:checked~.info-text::before {
            content: "Active";
        }

    </style>

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
                        <h3 class="page-title">Department</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Department</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn show" data-bs-toggle="modal" data-bs-target="#add_department"><i
                                class="fa fa-plus"></i> Add Department</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0" id="department">
                        <thead>
                            <tr>
                                <th style="width: 30px;">SR</th>
                                <th>Department Name</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($department as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->department_name }}</td>
                                    <td class="text-center">
                                        <div class="action-label">
                                            <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                                                @if ($item->status == 1)
                                                    <i class="fa fa-dot-circle-o text-success"></i> Approved
                                                @else
                                                    <i class="fa fa-dot-circle-o text-danger"></i> Declined
                                                @endif
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                {{-- <a class="dropdown-item" href="#" data-bs-toggle="modal" id="edit" 
                                                    data-bs-target="#add_department"><i class="fa fa-pencil m-r-5"></i>
                                                    Edit</a> --}}
                                                <button class="dropdown-item edit" id="edit" value="{{ $item->id }}"><i
                                                        class="fa fa-pencil m-r-5"></i>
                                                    Edit</button>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.departments.delete', $item->id) }}"><i
                                                        class="fa fa-trash-o m-r-5"></i> Delete</a>
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
    <div id="add_department" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @isset($edit)
                            Edit
                        @else
                            Add
                        @endisset Department
                    </h5>

                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.departments') }}" method="POST">
                        @csrf
                        @isset($edit)
                            <input type="hidden" name="edit-id" value="" id="inputid">
                        @endisset
                        <div class="form-group row">
                            <div class="form-group">
                                <label for="Designationinput">Department</label>
                                <input type="text" name="department" class="form-control" id="Designationinput"
                                    placeholder="Enter Department" id="inputdepartment" value="">
                            </div>
                            <label for="statusinput">Status</label>
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input class='input-switch' type="checkbox" value="1" name="status" checked id="demo" />
                                    <label class="label-switch" for="demo"></label>
                                    <span class="info-text"></span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="submit" class="btn btn-primary">                                Submit                            
                        </button>
                    </form>
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
    <script>
        $('#department').DataTable({
            paging: true,
            searching: true
        });
    </script>
    @isset($esit)
        <script>
            $(document).ready(function() {
                $("#add_department").modal('show');
            });
        </script>
    @endisset
    <script>
        $(document).ready(function() {
            $(document).on("click", ".edit", function() {
                var id = $(this).val();
                $.ajax({
                    url: "departments/edit/" + id,
                    type: "get",
                    cache: false,
                    success: function(edit) {
                        $('#submit').text("Update");
                        $('#inputid').val(edit.id);
                        $('#inputdepartment').val(edit.department_name);
                        $("#add_department").modal('show');
                    }

                });

            });
        });
    </script>
@endpush
