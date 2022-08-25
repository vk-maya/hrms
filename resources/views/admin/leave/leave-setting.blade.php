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
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leave Settings</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card leave-box" id="leave_annual">
                    <div class="card-body">
                        <div class="h3 card-title with-switch">
                            Privilege leaves
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
                                                <input type="hidden" name="type" value="PL">
                                                <label>Days</label>
                                                <input type="number" required name="day" class="form-control" disabled>
                                                @error('day')
                                                <span class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leave-edit-btn-sec leave-right">
                                        <button type="submit" class="leave-edit-btn-cust leave-edit-btn"><i class="fal fa-pencil"></i></button>
                                    </div>
                                </div>
                            </form>
                            <div class="leave-row">
                                <form action="{{ route('admin.leave.type') }}" method="POST">
                                    @csrf
                                    <div class="leave-left">
                                        <div class="input-box">
                                            <label class="d-block">Carry forward</label>
                                            <div class="leave-inline-form">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                    name="inlineRadioOptions" id="carry_no" value="option1"
                                                    disabled>
                                                    <label class="form-check-label" for="carry_no">No</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                    name="inlineRadioOptions" id="carry_yes" value="option2"
                                                    disabled>
                                                    <label class="form-check-label" for="carry_yes">Yes</label>
                                                </div>
                                                <div class="input-group">
                                                    <input type="hidden" readonly name="type" required value="PL">
                                                    <span class="input-group-text">Max</span>
                                                    <input type="type" name="carryforward" required class="form-control">
                                                    @error('carryforward')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="leave-edit-btn-sec leave-right">
                                        <button class="leave-edit-btn-cust leave-edit-btn"><i class="fal fa-pencil"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card leave-box" id="leave_sick">
                    <div class="card-body">
                        <div class="h3 card-title with-switch">
                         Sick leave 
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
                                            <input type="hidden" required name="type" value="Sick">
                                            <label>Days</label>
                                            <input type="number" required name="day" class="form-control" disabled>
                                            @error('day')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="leave-edit-btn-sec leave-right">
                                    <button type="submit" class="leave-edit-btn-cust leave-edit-btn"><i class="fal fa-pencil"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card leave-box" id="leave_sick">
                <div class="card-body">
                    <div class="h3 card-title with-switch">
                        Other leave
                        <div class="onoffswitch">
                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch_other"
                            checked>
                            <label class="onoffswitch-label" for="switch_other">
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
                                            <input type="hidden" required name="type" value="Other">
                                            <label>Days</label>
                                            <input type="number" required readonly name="day" value="0"
                                            class="form-control" disabled>
                                            @error('day')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="leave-right leave-edit-btn-sec">
                                    <button type="submit" class="leave-edit-btn-cust leave-edit-btn"><i class="fal fa-pencil"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>






        {{-- <div class="card leave-box mb-0" id="leave_custom01">
            <div class="card-body">
                <div class="h3 card-title with-switch">
                    LOP
                    <div class="onoffswitch">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch_custom01" checked>
                        <label class="onoffswitch-label" for="switch_custom01">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                    <button class="btn btn-danger leave-delete-btn" type="button">Delete</button>
                </div>
                <div class="leave-item">

                    <div class="leave-row">
                        <div class="leave-left">
                            <div class="input-box">
                                <div class="form-group">
                                    <label>Days</label>
                                    <input type="text" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="leave-edit-btn-sec leave-right">
                            <button class="leave-edit-btn-cust leave-edit-btn"><i class="fal fa-pencil"></i></button>
                        </div>
                    </div>


                    <div class="leave-row">
                        <div class="leave-left">
                            <div class="input-box">
                                <label class="d-block">Carry forward</label>
                                <div class="leave-inline-form">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="carryForward" id="carry_no_01" value="option1" disabled>
                                        <label class="form-check-label" for="carry_no_01">No</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="carryForward" id="carry_yes_01" value="option2" disabled>
                                        <label class="form-check-label" for="carry_yes_01">Yes</label>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text">Max</span>
                                        <input type="text" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="leave-edit-btn-sec leave-right">
                            <button class="leave-edit-btn-cust leave-edit-btn"><i class="fal fa-pencil"></i></button>
                        </div>
                    </div>


                    <div class="leave-row">
                        <div class="leave-left">
                            <div class="input-box">
                                <label class="d-block">Earned leave</label>
                                <div class="leave-inline-form">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" disabled>
                                        <label class="form-check-label" for="inlineRadio1">No</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" disabled>
                                        <label class="form-check-label" for="inlineRadio2">Yes</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="leave-edit-btn-sec leave-right">
                            <button class="leave-edit-btn-cust leave-edit-btn"><i class="fal fa-pencil"></i></button>
                        </div>
                    </div>

                </div>

                <div class="custom-policy">
                    <div class="leave-header">
                        <div class="title">Custom policy</div>
                        <div class="leave-action">
                            <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add_custom_policy"><i class="fa fa-plus"></i> Add
                            custom policy</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-nowrap leave-table mb-0">
                            <thead>
                                <tr>
                                    <th class="l-name">Name</th>
                                    <th class="l-days">Days</th>
                                    <th class="l-assignee">Assignee</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>5 Year Service </td>
                                    <td>5</td>
                                    <td>
                                        <a href="#" class="avatar"><img alt="" src="assets/img/profiles/avatar-02.jpg"></a>
                                        <a href="#">John Doe</a>
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown dropdown-action">
                                            <a aria-expanded="false" data-bs-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i
                                                class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit_custom_policy"><i
                                                        class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_custom_policy"><i
                                                            class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div> --}}

                </div>
            </div>
        </div>


        {{-- <div id="add_custom_policy" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Custom Policy</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Policy Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Days <span class="text-danger">*</span></label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group leave-duallist">
                                <label>Add employee</label>
                                <div class="row">
                                    <div class="col-lg-5 col-sm-5">
                                        <select name="customleave_from" id="customleave_select" class="form-control form-select" size="5" multiple="multiple">
                                            <option value="1">Bernardo Galaviz </option>
                                            <option value="2">Jeffrey Warden</option>
                                            <option value="2">John Doe</option>
                                            <option value="2">John Smith</option>
                                            <option value="3">Mike Litorus</option>
                                        </select>
                                    </div>
                                    <div class="multiselect-controls col-lg-2 col-sm-2 d-grid gap-2">
                                        <button type="button" id="customleave_select_rightAll" class="btn w-100 btn-white"><i class="fa fa-forward"></i></button>
                                        <button type="button" id="customleave_select_rightSelected" class="btn w-100 btn-white"><i class="fa fa-chevron-right"></i></button>
                                        <button type="button" id="customleave_select_leftSelected" class="btn w-100 btn-white"><i class="fa fa-chevron-left"></i></button>
                                        <button type="button" id="customleave_select_leftAll" class="btn w-100 btn-white"><i class="fa fa-backward"></i></button>
                                    </div>
                                    <div class="col-lg-5 col-sm-5">
                                        <select name="customleave_to" id="customleave_select_to" class="form-control form-select" size="8" multiple="multiple"></select>
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
        </div> --}}

        {{-- <div id="edit_custom_policy" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Custom Policy</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Policy Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="LOP">
                            </div>
                            <div class="form-group">
                                <label>Days <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="4">
                            </div>
                            <div class="form-group leave-duallist">
                                <label>Add employee</label>
                                <div class="row">
                                    <div class="col-lg-5 col-sm-5">
                                        <select name="edit_customleave_from" id="edit_customleave_select" class="form-control form-select" size="5" multiple="multiple">
                                            <option value="1">Bernardo Galaviz </option>
                                            <option value="2">Jeffrey Warden</option>
                                            <option value="2">John Doe</option>
                                            <option value="2">John Smith</option>
                                            <option value="3">Mike Litorus</option>
                                        </select>
                                    </div>
                                    <div class="multiselect-controls col-lg-2 col-sm-2 d-grid gap-2">
                                        <button type="button" id="edit_customleave_select_rightAll" class="btn w-100 btn-white"><i class="fa fa-forward"></i></button>
                                        <button type="button" id="edit_customleave_select_rightSelected" class="btn w-100 btn-white"><i class="fa fa-chevron-right"></i></button>
                                        <button type="button" id="edit_customleave_select_leftSelected" class="btn w-100 btn-white"><i class="fa fa-chevron-left"></i></button>
                                        <button type="button" id="edit_customleave_select_leftAll" class="btn w-100 btn-white"><i class="fa fa-backward"></i></button>
                                    </div>
                                    <div class="col-lg-5 col-sm-5">
                                        <select name="customleave_to" id="edit_customleave_select_to" class="form-control form-select" size="8" multiple="multiple"></select>
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


        <div class="modal custom-modal fade" id="delete_custom_policy" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Custom Policy</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

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
    {{-- <script src="{{ asset('assets/js/select2.min.js') }}"></script> --}}
    @endpush
