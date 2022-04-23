@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Clients</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Clients</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ route('admin.client.create') }}" class="btn add-btn"><i class="fa fa-plus"></i>
                            Add Client</a>
                        <div class="view-icons">
                            <a href="{{ route('admin.client') }}" class="grid-view btn btn-link active"><i
                                    class="fa fa-th"></i></a>
                            <a href="{{ route('admin.client.list') }}" class="list-view btn btn-link"><i
                                    class="fa fa-bars"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating">
                        <label class="focus-label">Client ID</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating">
                        <label class="focus-label">Client Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating">
                            <option>Select Company</option>
                            <option>Global Technologies</option>
                            <option>Delta Infotech</option>
                        </select>
                        <label class="focus-label">Company</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="d-grid">
                        <a href="#" class="btn btn-success"> Search </a>
                    </div>
                </div>
            </div>
            @isset($clist)
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table datatable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Client ID</th>
                                        <th>Contact Person</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Status</th>
                                        <th class="text-end no-sort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clist as $item)
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar"> <img
                                                            src="{{ asset('storage/client/' . $item->image) }}" alt=""></a>
                                                    <a href="profile.html"><b>{{ $item->company }}</b>
                                                        <span>{{ $item->client_id }}</span></a>
                                                </h2>
                                            </td>
                                            <td>SDC-EMP-{{ $item->client_id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td class="text-center">
                                                <div class="action-label">
                                                    <a class="btn btn-white btn-sm btn-rounded status"
                                                        data-id="{{ $item->id }}" href="javascript:void(0);">
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
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.client.edit', $item->id) }}"><i
                                                                class="fa fa-pencil m-r-5"></i> Edit</a>
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
            @endisset
            @isset($client)
                <div class="row staff-grid-row">
                    @foreach ($client as $item)
                        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                            <div class="profile-widget">
                                <div class="profile-img">
                                    <a href="java" class="avatar">
                                        <img src="{{ asset('storage/client/' . $item->image) }}" alt=""></a>
                                </div>
                                <div class="dropdown profile-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('admin.client.edit', $item->id) }}"><i
                                                class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <button class="dropdown-item delete" data-id="{{ $item->id }}"><i
                                                class="fa fa-trash-o m-r-5"></i> Delete</button>
                                    </div>
                                </div>
                                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="">{{ $item->company }}</a></h4>
                                <div class="small text-muted">{{ $item->name }}</div>
                            </div>
                        </div>
                    @endforeach
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
                            var url = "{{ route('admin.client.delete', ':id') }}";
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
        $(document).ready(function() {
            $(document).on("click", ".status", function() {
                var yeh = $(this);
                var id = $(this).data('id');
                let dataobj = {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                };
                $.ajax({
                    url: "{{ route('admin.client.status') }}",
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
@endpush
