@extends('admin.layouts.app')
@push('css')
@endpush
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                    <h3 class="page-title">Designations</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Designations</li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-6 text-end">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_designation"><i class="fa fa-plus"></i> Add Designation</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table cus-table-striped custom-table mb-0 data-table-theme">
                        <thead>
                            <tr>
                                <th style="width: 30px;">SR</th>
                                <th>Designation </th>
                                <th>Department </th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($designation as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->designation_name }}</td>
                                <td>{{ $item->department->department_name }}</td>
                                <td>
                                    <div class="action-label">
                                        <a class="btn btn-white btn-sm btn-rounded status" data-id="{{ $item->id }}" href="javascript:void(0);">
                                            @if ($item->status == 1)
                                            <i class="fas fa-check-circle text-success me-2"></i><span class="yes-data ">Approved</span>
                                            @else
                                            <i class="fas fa-check-circle text-danger me-2"></i> <span class="yes-data">Declined</span>
                                            @endif
                                        </a>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <button class="dropdown-item edit" data-id="{{ $item->id }}"><i class="fa fa-pencil m-r-5"></i>
                                                Edit</button>
                                            <button class="dropdown-item delete" data-id="{{ $item->id }}"><i class="fa fa-trash m-r-5"></i>
                                                Delete</button>
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
    <div id="add_designation" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Designation</h5>
                    <button type="button" class="close edit" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button></a>
                </div>
                <form action="{{ route('admin.designation') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Designationinput" class="mb-1 d-inline-block">Designation</label>
                            <input type="text" name="designation" class="form-control" id="inputdesignation" placeholder="Enter Designation" value="">
                        </div>
                        <div class="form-group">
                            <label class="mb-1 d-inline-block">Select Department</label>
                            <select class="select" name="department_id" id="inputdepartment">
                                <option value="">Select Department</option>
                                @foreach ($department as $item)
                                <option value="{{ $item->id }}">{{ $item->department_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <label class="mb-1 d-inline-block" for="statusinput">Status</label>
                        <div class="form-check form-switch d-flex pl-0">
                            <input class='input-switch' type="checkbox" value="1" name="status" checked id="demo" />
                            <label class="label-switch" for="demo"></label>
                            <span class="info-text"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn add-btn" id="submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('plugin-js')
<script>
    $(document).ready(function() {
        $(document).on("click", ".status", function() {
            var yes = $(this);
            var id = $(this).data('id');
            var url = "{{ route('admin.designation.status') }}";
            let dataobj = {
                "_token": "{{ csrf_token() }}",
                id: id,
            };
            $.ajax({
                type: "POST",
                url: url,
                data: dataobj,
                cache: false,
                success: function(response) {
                    let classname = $(yes).children()[0];
                    let text = $(yes).children()[1];
                    if ($(text).html() == 'Approved') {
                        $(text).html('Declined');
                        $(classname).removeClass('text-success');
                        $(classname).addClass(' text-danger');
                    } else {
                        $(text).html('Approved');
                        $(classname).removeClass(' text-danger');
                        $(classname).addClass('text-success');
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
    $(document).ready(function() {
        $('#add_designation').on('hidden.bs.modal', function(e) {
            $("#editid").html('');
            $("#inputdesignation").val('');
        })
        $(document).on("click", ".edit", function() {
            var id = $(this).data('id');
            var url = "{{ route('admin.designation.edit', ':id') }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                type: "get",
                cache: false,
                success: function(res) {
                    $("#submit").text("Update");
                    $("#inputid").val(res.msg.id);
                    $("#inputdesignation").val(res.msg.designation_name);
                    console.log(res.msg.department_id);
                    $("#inputdepartment").children().prop('selected', false);
                    $("#inputdepartment").find('option[value="' + res.msg.department_id + '"]').prop('selected', true);
                    if (res.msg.status == 1) {
                        $("#demo").prop("checked", true)
                    } else {
                        $("#demo").prop("checked", false)
                    }
                    $("#add_designation").modal('show');
                }
            });
        });
    });

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
                        let url = "{{ route('admin.designation.delete', ':id') }}";
                        url = url.replace(':id', id);
                        $.ajax({
                            url: url,
                            type: "GET",
                            cache: false,
                            success: function(res) {
                                console.log(res.msg)
                                if (res.msg == 'no') {
                                    swal("unsuccessful! Your Department has been Add Any Employees! ", {
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