@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
@endpush
@section('content')
    <div class="page-wrapper">

        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Leave Settings</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Leave Settings</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card leave-box" id="leave_annual">
                        <div class="card-body">
                            <div class="h3 card-title with-switch">
                                Annual
                                <div class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                                        id="switch_annual" checked>
                                    <label class="onoffswitch-label" for="switch_annual">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="leave-item">
                                <form action="{{ route('admin.leave.type') }}" method="POST">
                                    @csrf
                                    <div class="leave-row">
                                        <div class="leave-left">
                                            <div class="input-box">
                                                <div class="form-group">
                                                    <input type="hidden" name="type"value="Annual">
                                                    <label>Days</label>
                                                    <input type="number" name="day" class="form-control" disabled>
                                                    @error('day')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="leave-right">
                                            <button type="submit" class="leave-edit-btn">Edit</button>
                                        </div>
                                    </div>
                                </form>
                        
                            </div>
                        </div>
                    </div>
                    <div class="card leave-box" id="leave_sick">
                        <div class="card-body">
                            <div class="h3 card-title with-switch">
                                Sick
                                <div class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch_sick"
                                        checked>
                                    <label class="onoffswitch-label" for="switch_sick">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="leave-item">
                                <form action="{{ route('admin.leave.type') }}" method="POST">
                                    @csrf
                                    <div class="leave-row">
                                        <div class="leave-left">
                                            <div class="input-box">
                                                <div class="form-group">
                                                    <input type="hidden" name="type" value="Sick">
                                                    <label>Days</label>
                                                    <input type="number" name="day" class="form-control" disabled>
                                                    @error('day')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="leave-right">
                                            <button type="submit" class="leave-edit-btn">Edit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card leave-box" id="leave_hospitalisation">
                        <div class="card-body">
                            <div class="h3 card-title with-switch">
                                Hospitalisation
                                <div class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                                        id="switch_hospitalisation">
                                    <label class="onoffswitch-label" for="switch_hospitalisation">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="leave-item">
                                <form action="{{ route('admin.leave.type') }}" method="POST">
                                    @csrf
                                    <div class="leave-row">
                                        <div class="leave-left">
                                            <div class="input-box">
                                                <div class="form-group">
                                                    <input type="hidden" name="type" value="Hospitalisation">
                                                    <label>Days</label>
                                                    <input type="number" name="day" class="form-control" disabled>
                                                    @error('day')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="leave-right">
                                            <button type="submit" class="leave-edit-btn">Edit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card leave-box" id="leave_maternity">
                        <div class="card-body">
                            <div class="h3 card-title with-switch">
                                Maternity <span class="subtitle">Assigned to female only</span>
                                <div class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                                        id="switch_maternity" checked>
                                    <label class="onoffswitch-label" for="switch_maternity">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="leave-item">
                                <form action="{{ route('admin.leave.type') }}" method="POST">
                                    @csrf
                                    <div class="leave-row">
                                        <div class="leave-left">
                                            <div class="input-box">
                                                <div class="form-group">
                                                    <input type="hidden" name="type"
                                                        value="Maternity Assigned to female only">
                                                    <label>Days</label>
                                                    <input type="number" name="day" class="form-control" disabled>
                                                    @error('day')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="leave-right">
                                            <button type="submit" class="leave-edit-btn">Edit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card leave-box" id="leave_paternity">
                        <div class="card-body">
                            <div class="h3 card-title with-switch">
                                Paternity <span class="subtitle">Assigned to male only</span>
                                <div class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                                        id="switch_paternity">
                                    <label class="onoffswitch-label" for="switch_paternity">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="leave-item">
                                <form action="{{ route('admin.leave.type') }}" method="POST">
                                    @csrf
                                    <div class="leave-row">
                                        <div class="leave-left">
                                            <div class="input-box">
                                                <div class="form-group">
                                                    <input type="hidden" name="type"
                                                        value="Paternity Assigned to male only">
                                                    <label>Days</label>
                                                    <input type="number" name="day" class="form-control" disabled>
                                                    @error('day')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="leave-right">
                                            <button type="submit" class="leave-edit-btn">Edit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card leave-box mb-0" id="leave_custom01">
                        <div class="card-body">
                            <div class="h3 card-title with-switch">
                                LOP
                                <div class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                                        id="switch_custom01" checked>
                                    <label class="onoffswitch-label" for="switch_custom01">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                                <button class="btn btn-danger leave-delete-btn" type="button">Delete</button>
                            </div>
                            <div class="leave-item">
                                <form action="{{ route('admin.leave.type') }}" method="POST">
                                    @csrf
                                    <div class="leave-row">
                                        <div class="leave-left">
                                            <div class="input-box">
                                                <div class="form-group">
                                                    <input type="hidden" name="type" value="LOP">
                                                    <label>Days</label>
                                                    <input type="number" name="day" class="form-control" disabled>
                                                    @error('day')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="leave-right">
                                            <button type="submit" class="leave-edit-btn">Edit</button>
                                        </div>
                                    </div>
                                </form>
                                {{-- <div class="leave-row">
                                    <div class="leave-left">
                                        <div class="input-box">
                                            <label class="d-block">Carry forward</label>
                                            <div class="leave-inline-form">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="carryForward"
                                                        id="carry_no_01" value="option1" disabled>
                                                    <label class="form-check-label" for="carry_no_01">No</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="carryForward"
                                                        id="carry_yes_01" value="option2" disabled>
                                                    <label class="form-check-label" for="carry_yes_01">Yes</label>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-text">Max</span>
                                                    <input type="text" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leave-right">
                                        <button class="leave-edit-btn">
                                            Edit
                                        </button>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card leave-box mb-0" id="leave_custom01">
                        <div class="card-body">
                            <div class="h3 card-title with-switch">
                                Other
                                <div class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                                        id="switch_custom01" checked>
                                    <label class="onoffswitch-label" for="switch_custom01">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                                <button class="btn btn-danger leave-delete-btn" type="button">Delete</button>
                            </div>
                            <div class="leave-item">
                                <form action="{{ route('admin.leave.type') }}" method="POST">
                                    @csrf
                                    <div class="leave-row">
                                        <div class="leave-left">
                                            <div class="input-box">
                                                <div class="form-group">
                                                    <label for="">Type</label>
                                                    <input type="text" class="form-control" name="type" value="">
                                                    <label>Days</label>
                                                    <input type="number" name="day" class="form-control" disabled>
                                                    @error('day')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="leave-right">
                                            <button type="submit" class="leave-edit-btn">Edit</button>
                                        </div>
                                    </div>
                                </form>
                                {{-- <div class="leave-row">
                                    <div class="leave-left">
                                        <div class="input-box">
                                            <label class="d-block">Carry forward</label>
                                            <div class="leave-inline-form">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="carryForward"
                                                        id="carry_no_01" value="option1" disabled>
                                                    <label class="form-check-label" for="carry_no_01">No</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="carryForward"
                                                        id="carry_yes_01" value="option2" disabled>
                                                    <label class="form-check-label" for="carry_yes_01">Yes</label>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-text">Max</span>
                                                    <input type="text" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leave-right">
                                        <button class="leave-edit-btn">
                                            Edit
                                        </button>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
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
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/multiselect.min.js') }}"></script>
@endpush
