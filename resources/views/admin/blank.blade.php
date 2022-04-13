@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">

    <div class="content container-fluid">

        <div id="add_employee" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Employee</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">First Name <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" name="name" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Last Name</label>
                                        <input class="form-control" name="last_name" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Username <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" name="user_name" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                        <input class="form-control" name="email" type="email">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Password</label>
                                        <input class="form-control" name="password" type="password">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Confirm Password</label>
                                        <input class="form-control" type="password">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Employee ID <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="employee_id" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Joining Date <span
                                                class="text-danger">*</span></label>
                                        <div class="cal-icon"><input name="joining_date"
                                                class="form-control datetimepicker" type="text"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Phone </label>
                                        <input class="form-control" name="phone" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Mobile</label>
                                        <input class="form-control" name="mobile" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Work Address</label>
                                        <input class="form-control" name="address_first" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Home Address</label>
                                        <input class="form-control" name="address_second" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">City</label>
                                        <input class="form-control" name="city" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">State</label>
                                        <input class="form-control" name="state" type="text">
                                    </div>
                                </div>
        
                                {{-- {{$department}} --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Department <span class="text-danger">*</span></label>
                                        <select class="select">
                                            <option>Select Department</option>
                                            @foreach ($department as $item)
                                                <option value="{{ $item->id }}">{{ $item->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Designation <span class="text-danger">*</span></label>
                                        <select class="select">
                                            <option>Select Designation</option>
                                            @foreach ($designation as $item)
                                                <option value="{{ $item->id }}">{{ $item->designation_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Company</label>
                                        <select class="select">
                                            <option value="">Global Technologies</option>
                                            <option value="1">Delta Infotech</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="statusinput" class="mb-4">Status</label>
                                        <input class='input-switch' type="checkbox" value="1" name="status" checked
                                            id="demo" />
                                        <div class="form-check form-switch">
                                            <input class='input-switch' type="checkbox" value="1" name="status" checked
                                                id="demo" />
                                            <label class="label-switch" for="demo"></label>
                                            <span class="info-text"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group ml-2">
                                        <label class="col-form-label">Work Place</label>
                                        <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"  title="Work From Office" name="inlineRadioOptions" id="wfo" value="option1">
                                            <label class="form-check-label" title="Work From Office" for="wfo">WFO</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                            <input class="form-check-input" title="Work From House" type="radio" name="inlineRadioOptions" id="wfh" value="option2">
                                            <label class="form-check-label" title="Work From House" for="wfh">WFH</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="both" id="both" value="option3">
                                            <label class="form-check-label"title="Both" for="both">Both</label>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"></label>
                                    <div class="col-md-6">
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Upload Photo</label>
                                    <input name="image" class="form-control" type="file">
                                </div>
        
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</div>
@endsection
