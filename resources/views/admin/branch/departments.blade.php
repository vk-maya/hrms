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

    <!-- Sweetalert 2 CSS -->
    <link rel="stylesheet" href="assets/plugins/sweetalert2/sweetalert2.min.css">
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
            @if (Session::has('success'))
                <div class="alert alert-success alert-block" role="alert">
                    <button class="close" data-dismiss="alert"></button>
                    {{ Session::get('success') }}
                </div>
            @endif

            {{-- //Bonus: you can also use this subview for your error, warning, or info messages --}}
            @if (Session::has('error'))
                <div class="alert alert-danger alert-block" role="alert">
                    <button class="close" data-dismiss="alert"></button>
                    {{ Session::get('error') }}
                </div>
            @endif
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
                                            <a class="btn btn-white btn-sm btn-rounded status" data-id="{{ $item->id }}"
                                                href="javascript:void(0);">
                                                @if ($item->status == 1)
                                                    <i class="fa fa-dot-circle-o text-success"></i> <span
                                                        class="yeh-data">Approved</span>
                                                @else
                                                    <i class="fa fa-dot-circle-o text-danger"></i> <span
                                                        class="yeh-data">Declined</span>
                                                @endif
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <button class="dropdown-item edit" data-id="{{ $item->id }}"><i
                                                        class="fa fa-pencil m-r-5"></i>
                                                    Edit</button>
                                                <button class="dropdown-item delete" data-id="{{ $item->id }}"><i
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
    </div>
    <div id="add_department" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Add Department
                    </h5>
                    <button type="button" class="close edit" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.departments') }}" method="POST">
                        @csrf
                        <div id="editid">

                        </div>
                        <div class="form-group row">
                            <div class="form-group">
                                <label for="Designationinput">Department</label>
                                <input type="text" name="department" class="form-control" placeholder="Enter Department"
                                    id="inputdepartment" value="">
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
                        <button type="submit" id="submit" class="btn btn-primary"> Submit
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <script>
        $('#department').DataTable({
            paging: true,
            searching: true
        });

        $(document).ready(function() {
            $(document).on("click", '.edit', (function() {
                $("#add_department").modal('show');
            }));
        });

        $(document).ready(function() {
            $('#add_department').on('hidden.bs.modal', function(e) {
                $("#editid").html('');
                $("#inputdepartment").val('');
            })
            $(document).on("click", ".edit", function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "departments/edit/" + id,
                    type: "get",
                    cache: false,
                    success: function(res) {
                        console.log();
                        $('#submit').text("Update");
                        $('#inputid').val(res.edit.id);
                        $('#inputdepartment').val(res.edit.department_name);
                        if (res.edit.status == 1) {
                            $("#demo").prop('checked', true);
                        } else {
                            $("#demo").prop('checked', false);
                        }
                        $("#add_department").modal('show');
                    }

                });

            });
        });

        $(document).ready(function() {
            $(document).on("click", ".status", function() {
                var yeh = $(this);
                var id = $(this).data('id');
                let dataobj = {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                };
                $.ajax({
                    url: "{{ route('admin.departments.status') }}",
                    type: "POST",
                    data: dataobj,
                    cache: false,
                    success: function(res) {
                        let className = $(yeh).children()[0];
                        let text = $(yeh).children()[1];
                        console.log($(className).html());
                        if ($(text).html() == 'Approved') {
                            $(text).html('Declined');
                            $(className).removeClass('text-success');
                            $(className).addClass('text-danger');
                        } else {
                            $(text).html('Approved');
                            $(className).removeClass('text-danger');
                            $(className).addClass('text-success');
                        }
                    }
                });
            })
        })






        $(document).ready(function() {
            $(document).on("click", '.edit', (function() {
                $("#editid").html("<input type='hidden' name='id' value='" + $(this).data('id') + "'>");
            }));
        })
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("click", '.delete', function() {
                var yeh = $(this);
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var id = $(this).data('id');
                            let url = "{{ route('admin.departments.delete', ':id') }}";
                            url = url.replace(':id', id);
                            $.ajax({
                                url: url,
                                type: "GET",
                                cache: false,
                                success: function(res) {
                                    console.log(res.msg)
                                    if (res.msg == 'no') {
                                        swal("unsuccessful! Your Department has been Add Any Designation! ", {
                                            icon: "error",
                                        })

                                    } else {
                                        swal("Success! Your Department has been deleted!", {
                                            icon: "success",
                                        })
                                        $(yeh).parent().parent().parent().parent().hide(
                                            0500);

                                    }


                                }
                            });

                        }
                    });
            });
        });
    </script>
@endpush
