@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Profile</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ route('admin.employees.attach', $employees->id) }}" class="btn add-btn"><i class="fa fa-paperclip" aria-hidden="true"></i>Attach Document</a>
                        <a href="{{ route('admin.employees.edit', $employees->id) }}" class="btn add-btn"><i class="fa fa-plus"></i>Edit User</a>
                    </div> 
                </div>
            </div>
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        <a href="#"><img alt=""
                                                src="@if($employees->image != NULL){{ asset('storage/uploads/' . $employees->image) }}@else{{ asset('assets/img/avtar.jpg')}}@endif"></a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0">{{ $employees->first_name }}</h3>
                                                <h6 class="text-muted">
                                                    {{ $employees->profiledesignation->designation_name }}</h6>
                                                <small
                                                    class="text-muted">{{ $employees->department->department_name }}</small>
                                                <div class="staff-id">Employee ID : {{ $employees->employeeID }}</div>
                                                <div class="staff-id">Machine ID :@if(isset($employees)&& $employees->machineID != NULL){{ $employees->machineID }}@else NO @endif</div>
                                                <div class="small doj text-muted">Date of Join :
                                                    {{ \Carbon\Carbon::parse($employees->joiningDate)->format('d/m/Y') }}
                                                </div>
                                                <div class="staff-msg"><a class="btn btn-custom"
                                                        href="{{ route('admin.emp.show-taskk', $employees->id) }}">Show-Task</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Phone:</div>
                                                    <div class="text">@if(isset($employees)&& $employees->phone != NULL){{ $employees->phone }}@else NO @endisset</div>
                                                </li>
                                                <li>
                                                    <div class="title">Email:</div>
                                                    <div class="text">@if(isset($employees)&& $employees->email != NULL){{ $employees->email }}@else NO @endisset</div>
                                                </li>
                                                <li>
                                                    <div class="title">Birthday:</div>
                                                    <div class="text">@if(isset($employees)&& $employees->dob != NULL){{ $employees->dob }}@else NO @endisset</div>
                                                   
                                                </li>
                                                <li>
                                                    <div class="title">Address:</div>
                                                    <div class="text">@if(isset($employees)&& $employees->address != NULL){{ $employees->address }}@else NO @endisset</div>
                                                </li>
                                                <li>
                                                    <div class="title">Gender:</div>
                                                    <div class="text">
                                                        @if ($employees->gender == 'm')
                                                            {{ 'Male' }}
                                                        @elseif($employees->gender == 'm')
                                                            {{ 'Female' }}
                                                            @else
                                                            NO
                                                        @endif
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card tab-box">
                <div class="row user-tabs">
                    <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <li class="nav-item"><a href="#emp_profile" data-bs-toggle="tab"
                                    class="nav-link active">Profile</a></li>
                            <li class="nav-item"><a href="#emp_projects" data-bs-toggle="tab"
                                    class="nav-link">Projects</a></li>
                            <li class="nav-item"><a href="#bank_statutory" data-bs-toggle="tab"
                                    class="nav-link">Bank & Statutory <small class="text-danger">(Admin
                                        Only)</small></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div id="emp_profile" class="pro-overview tab-pane fade show active">
                    <div class="row">
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">Personal Informations </h3>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Nationality</div>
                                            <div class="text">
                                                @isset($employees->moreinfo->nationality)
                                                    {{ $employees->moreinfo->nationality }}
                                                @else
                                                    No
                                                @endisset
                                            </div>
                                        </li>
                                        <li>
                                            <div class="title">Marital status</div>
                                            <div class="text">
                                                @isset($employees->moreinfo->maritalStatus)
                                                    {{ $employees->moreinfo->maritalStatus }}
                                                @else
                                                    No
                                                @endisset
                                            </div>
                                        </li>
                                        <li>
                                            <div class="title">No. of children</div>
                                            <div class="text">
                                                @isset($employees->moreinfo->noOfChildren)
                                                    {{ $employees->moreinfo->noOfChildren }}
                                                @else
                                                    No
                                                @endisset
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">Bank information</h3>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Bank name</div>
                                            <div class="text">
                                                @isset($employees->moreinfo->bankname)
                                                    {{ $employees->moreinfo->bankname }}
                                                @else
                                                    No
                                                @endisset
                                            </div>
                                        </li>
                                        <li>
                                            <div class="title">Bank account</div>
                                            <div class="text">
                                                @isset($employees->moreinfo->bankAc)
                                                    {{ $employees->moreinfo->bankAc }}
                                                @else
                                                    No
                                                @endisset
                                            </div>
                                        </li>
                                        <li>
                                            <div class="title">IFSC Code</div>
                                            <div class="text">
                                                @isset($employees->moreinfo->ifsc)
                                                    {{ $employees->moreinfo->ifsc }}
                                                @else
                                                    No
                                                @endisset
                                            </div>
                                        </li>
                                        <li>
                                            <div class="title">PAN No</div>
                                            <div class="text">
                                                @isset($employees->moreinfo->pan)
                                                    {{ $employees->moreinfo->pan }}
                                                @else
                                                    No
                                                @endisset
                                            </div>

                                        </li>
                                    </ul>
                                </div>
                            </div>
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
        <script></script>
    @endpush
