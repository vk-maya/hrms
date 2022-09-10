@extends('admin.layouts.app')
@push('css')
@endpush
@section('content')
<div class="page-wrapper inner">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                    <h3 class="page-title">Department</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Department</li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-6 text-end">
                    <a href="#" class="btn add-btn show" data-bs-toggle="modal" data-bs-target="#add_department"><i class="fa fa-plus"></i> Add Department</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table cus-table-striped custom-table mb-0 data-table-theme">
                    <thead>
                        <tr>
                            <th style="width: 30px;">SR</th>
                            <th>Department Name</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($department as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->department_name }}</td>
                            <td>
                                <div class="action-label">
                                    <a class="btn btn-white btn-sm btn-rounded status" data-id="{{ $item->id }}" href="javascript:void(0);">
                                        @if ($item->status == 1)
                                        <i class="fas fa-check-circle text-success me-2"></i> <span class="yeh-data">Approved</span>
                                        @else
                                        <i class="fas fa-check-circle me-2 text-danger"></i> <span class="yeh-data">Declined</span>
                                        @endif
                                    </a>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button class="dropdown-item edit" data-id="{{ $item->id }}"><i class="fa fa-pencil me-2"></i>
                                            Edit</button>
                                        <button class="dropdown-item delete" data-id="{{ $item->id }}"><i class="fas fa-trash-alt me-2"></i> Delete</button>
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
                <form action="{{ route('admin.departments') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Designationinput">Department</label>
                            <input type="text" name="department" class="form-control" placeholder="Enter Department" id="inputdepartment" value="">
                        </div>
                        <label class="mb-1 d-inline-block" for="statusinput">Status</label>
                        <div class="form-check form-switch d-flex pl-0">
                            <input class='input-switch' type="checkbox" value="1" name="status" checked id="demo" />
                            <label class="label-switch" for="demo"></label>
                            <span class="info-text"></span>
                        </div>
                    </div>
                    <div class="modal-footer text-center submit-section">
                        <button type="submit" class="btn btn-success" id="submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    // -------------------show hidden column-------------
    $(document).ready(function() {
        $(document).on("click", '.edit', (function() {
            $("#editid").html("<input type='hidden' name='id' value='" + $(this).data('id') + "'>");
        }));
    })
    // ------------------------edit---------------------
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
    // ---------------------status ----------------------------
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
</script>
<script>
    // -----------------------delete----------------------
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