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
                            <a href="projects.html" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                            <a href="project-list.html" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
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
            {{ $project }}
            <div class="row">
                @foreach ($project as $item)
                    <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown dropdown-action profile-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#edit_project"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_project"><i class="fa fa-trash-o m-r-5"></i>
                                            Delete</a>
                                    </div>
                                </div>
                                <h4 class="project-title"><a href="project-view.html">{{ $item->name }}</a></h4>
                                <small class="block text-ellipsis m-b-15">
                                    <span class="text-xs">1</span> <span class="text-muted">open tasks, </span>
                                    <span class="text-xs">9</span> <span class="text-muted">tasks
                                        completed</span>
                                </small>
                                <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. When an unknown printer took a galley of type and
                                    scrambled it...
                                </p>
                                <div class="pro-deadline m-b-15">
                                    <div class="sub-title">
                                        Deadline: 
                                    </div>
                                    <div class="text-muted">
                                        {{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}                                    </div>
                                </div>
                                <div class="project-members m-b-15">
                                    <div>Project Leader :</div>
                                    <ul class="team-members">
                                        <li>
                                            <a href="#" data-bs-toggle="tooltip" title="Jeffery Lalor"><img alt=""
                                                    src="assets/img/profiles/avatar-16.jpg"></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="project-members m-b-15">
                                    <div>Team :</div>
                                    <ul class="team-members">
                                        <li>
                                            <a href="#" data-bs-toggle="tooltip" title="John Doe"><img alt=""
                                                    src="assets/img/profiles/avatar-02.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" data-bs-toggle="tooltip" title="Richard Miles"><img alt=""
                                                    src="assets/img/profiles/avatar-09.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" data-bs-toggle="tooltip" title="John Smith"><img alt=""
                                                    src="assets/img/profiles/avatar-10.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" data-bs-toggle="tooltip" title="Mike Litorus"><img alt=""
                                                    src="assets/img/profiles/avatar-05.jpg"></a>
                                        </li>
                                        <li class="dropdown avatar-dropdown">
                                            <a href="#" class="all-users dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false">+15</a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <div class="avatar-group">
                                                    <a class="avatar avatar-xs" href="#">
                                                        <img alt="" src="assets/img/profiles/avatar-02.jpg">
                                                    </a>
                                                    <a class="avatar avatar-xs" href="#">
                                                        <img alt="" src="assets/img/profiles/avatar-09.jpg">
                                                    </a>
                                                    <a class="avatar avatar-xs" href="#">
                                                        <img alt="" src="assets/img/profiles/avatar-10.jpg">
                                                    </a>
                                                    <a class="avatar avatar-xs" href="#">
                                                        <img alt="" src="assets/img/profiles/avatar-05.jpg">
                                                    </a>
                                                    <a class="avatar avatar-xs" href="#">
                                                        <img alt="" src="assets/img/profiles/avatar-11.jpg">
                                                    </a>
                                                    <a class="avatar avatar-xs" href="#">
                                                        <img alt="" src="assets/img/profiles/avatar-12.jpg">
                                                    </a>
                                                    <a class="avatar avatar-xs" href="#">
                                                        <img alt="" src="assets/img/profiles/avatar-13.jpg">
                                                    </a>
                                                    <a class="avatar avatar-xs" href="#">
                                                        <img alt="" src="assets/img/profiles/avatar-01.jpg">
                                                    </a>
                                                    <a class="avatar avatar-xs" href="#">
                                                        <img alt="" src="assets/img/profiles/avatar-16.jpg">
                                                    </a>
                                                </div>
                                                <div class="avatar-pagination">
                                                    <ul class="pagination">
                                                        <li class="page-item">
                                                            <a class="page-link" href="#" aria-label="Previous">
                                                                <span aria-hidden="true">«</span>
                                                                <span class="visually-hidden">Previous</span>
                                                            </a>
                                                        </li>
                                                        <li class="page-item"><a class="page-link" href="#">1</a>
                                                        </li>
                                                        <li class="page-item"><a class="page-link" href="#">2</a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link" href="#" aria-label="Next">
                                                                <span aria-hidden="true">»</span>
                                                                <span class="visually-hidden">Next</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
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
