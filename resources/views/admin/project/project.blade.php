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
                        <h3 class="page-title">Projects</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Projects</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ route('admin.project.create') }}" class="btn add-btn"><i
                                class="fa fa-plus"></i>
                            Create Project</a>
                        <div class="view-icons">
                            <a href="{{ route('admin.project') }}" class="grid-view btn btn-link active"><i
                                    class="fa fa-th"></i></a>
                            <a href="{{ route('admin.project.list') }}" class="list-view btn btn-link"><i
                                    class="fa fa-bars"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating">
                        <label class="focus-label">Project Name</label>
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
                            <option>Select Roll</option>
                            <option>Web Developer</option>
                            <option>Web Designer</option>
                            <option>Android Developer</option>
                            <option>Ios Developer</option>
                        </select>
                        <label class="focus-label">Designation</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <a href="#" class="btn btn-success w-100"> Search </a>
                </div>
            </div>
            @isset($project)
                <div class="row">
                    @foreach ($project as $item)
                        <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown dropdown-action profile-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('admin.project.edit', $item->id) }}"><i
                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <button class="dropdown-item delete" href="" data-id="{{ $item->id }}"
                                                data-bs-toggle="modal" data-bs-target="#delete_project"><i
                                                    class="fa fa-trash-o m-r-5"></i>
                                                Delete</button>
                                        </div>
                                    </div>
                                    <h4 class="project-title"><a href="{{route('admin.project.view',$item->id)}}">{{ $item->name }}</a></h4>
                                    <small class="block text-ellipsis m-b-15">
                                        <span class="text-xs">1</span> <span class="text-muted">open tasks, </span>
                                        <span class="text-xs">9</span> <span class="text-muted">tasks
                                            completed</span>
                                    </small>
                                    {!! $item->description !!}
                                    <div class="pro-deadline m-b-15">
                                        <div class="sub-title">
                                            Deadline:
                                        </div>
                                        <div class="text-muted">
                                            {{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }} </div>
                                    </div>
                                    <div class="pro-deadline m-b-15">
                                        <div class="sub-title">
                                            Client:
                                        </div>
                                        <div class="text-muted">
                                            {{ $item->client->company }} </div>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>Project Leader :</div>
                                        <ul class="team-members">
                                            @foreach ($item->leaders()->get() as $it)
                                                <li>
                                                    <a href="#" data-bs-toggle="tooltip" title="{{ $it->name }}"><img
                                                            alt="" src="{{ asset('storage/uploads/' . $it->image) }}"></a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>Team :</div>
                                        <ul class="team-members">
                                            @foreach ($item->team()->get() as $it)
                                                <li>
                                                    <a href="#" data-bs-toggle="tooltip" title="{{ $it->name }}"><img
                                                            alt="" src="{{ asset('storage/uploads/' . $it->image) }}"></a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                    <p class="m-b-5">Progress <span class="text-success float-end">40%</span></p>
                                    <div class="progress progress-xs mb-0">
                                        <div class="progress-bar bg-success" role="progressbar" data-bs-toggle="tooltip"
                                            title="40%" style="width: 40%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endisset
            @isset($projectlist)
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table datatable">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Project Id</th>
                                        <th>Leader</th>
                                        <th>Team</th>
                                        <th>Deadline</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                {{-- {{$projectlist}} --}}
                                <tbody>
                                    @foreach ($projectlist as $item)
                                        {{-- {{$item}} --}}
                                        <tr>
                                            <td>
                                                <a href="project-view.html">{{ $item->name }}</a>
                                            </td>
                                            <td>PRO-{{ $item->id }}</td>
                                            <td>
                                                <ul class="team-members">
                                                    @foreach ($leader as $lead)
                                                        @if ($lead->prject_id == $item->id)
                                                            {{ $lead->name }}
                                                            <li>
                                                                <a href="#" data-bs-toggle="tooltip"
                                                                    title="{{ $lead->user->name }}"><img alt=""
                                                                        src="{{ asset('storage/uploads/' . $lead->user->image) }}"></a>
                                                            </li>
                                                        @endif
                                                    @endforeach

                                                </ul>
                                            </td>
                                            <td>
                                                <ul class="team-members text-nowrap">
                                                    @foreach ($team as $teams)
                                                        @if ($item->id == $teams->prject_id)
                                                            <li>
                                                                <a href="#" data-bs-toggle="tooltip" title=" {{ $teams->user->name }}"><img alt=""src="{{ asset('storage/uploads/' . $teams->user->image) }}"></a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td> {{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="dropdown action-label">
                                                    @if ($item->priority == 'high')
                                                        <a href="#" class="btn btn-white btn-sm btn-rounded dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="fa fa-dot-circle-o text-danger"></i> High </a>
                                                    @endif
                                                    @if ($item->priority == 'medium')
                                                        <a href="#" class="btn btn-white btn-sm btn-rounded dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="fa fa-dot-circle-o text-warning"></i> Medium </a>
                                                    @endif
                                                    @if ($item->priority == 'low')
                                                        <a href="#" class="btn btn-white btn-sm btn-rounded dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="fa fa-dot-circle-o text-success"></i> Low </a>
                                                    @endif

                                                </div>
                                            </td>
                                            <td>
                                                <div class="dropdown action-label">
                                                    <a href="#" class="btn btn-white btn-sm btn-rounded dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="fa fa-dot-circle-o text-success"></i> Active </a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#"><i
                                                                class="fa fa-dot-circle-o text-success"></i>
                                                            Active</a>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="fa fa-dot-circle-o text-danger"></i>
                                                            Inactive</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                                        aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#edit_project"><i class="fa fa-pencil m-r-5"></i>
                                                            Edit</a>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_project"><i class="fa fa-trash-o m-r-5"></i>
                                                            Delete</a>
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
                            var url = "{{ route('admin.project.delete', ':id') }}";
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
                                        $(yes).parent().parent().parent().parent().parent().hide(0500);

                                    }
                                }
                            });
                        }
                    });
            })
        });
    </script>
@endpush
