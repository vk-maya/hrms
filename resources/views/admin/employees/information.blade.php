@extends('admin.layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush
@section('content')
<div class="page-wrapper admin-frm">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">More Information</li>
                    </ul>
                </div>
                <div class="modal-content heading mt-5">
                    <div class="modal-header">
                        <h4 class="modal-title">Personal Information</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.employees.info') }}" method="POST">
                            @csrf
                            @isset($data)
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            @endisset
                            <input type="hidden" name="user_id" value="{{ $id }}">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Nationality Select</label>
                                        <select class="select form-control" name="nationality">
                                            <option @if (isset($data) && $data->nationality == 'Indian') selected @endif
                                                value="Indian">Indian</option>
                                            <option @if (isset($data) && $data->nationality == 'Other') selected @endif
                                                value="Other">Other</option>
                                        </select>
                                        <span class="text-danger">
                                            @error('nationality')
                                            <p>Nationality field is required.</p>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Marital status Select<span class="text-danger">*</span></label>
                                        <select class="select form-control" name="maritalstatus">
                                            <option @if (isset($data) && $data->maritalStatus == 'Single') selected @endif
                                                value="Single">Single</option>
                                            <option @if (isset($data) && $data->maritalStatus == 'Married') selected @endif
                                                value="Married">Married</option>
                                        </select>
                                        <span class="text-danger">
                                            @error('maritalstatus')
                                            <p>Marital status field is required.</p>
                                            @enderror
                                        </span>
                                    </div>
                                </div>                            
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>No. of children Select<span class="text-danger">*</span></label>
                                        <select class="select form-control" name="children">
                                            <option @if (isset($data) && $data->noOfChildren == 1) selected @endif
                                                value="1">1</option>
                                            <option @if (isset($data) && $data->noOfChildren == 2) selected @endif
                                                value="2">2</option>
                                            <option @if (isset($data) && $data->noOfChildren == 3) selected @endif
                                                value="3">3</option>
                                            <option @if (isset($data) && $data->noOfChildren == 4) selected @endif
                                                value="4">4</option>
                                            <option @if (isset($data) && $data->noOfChildren == 5) selected @endif
                                                value="5">5</option>
                                            <option @if (isset($data) && $data->noOfChildren =="5+") selected @endif
                                                value="5+">5+</option>
                                        </select>
                                        <span class="text-danger">
                                            @error('maritalstatus')
                                            <p>Marital status field is required.</p>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <h4 class="modal-title">Bank information </h4>
                                <hr>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Bank Name <span class="text-danger">*</span></label>
                                        <input class="form-control" name="bankname" required type="text" value="@isset($data){{$data->bankname}}@else{{old('bankname')}}@endisset">
                                        <span class="text-danger">
                                            @error('bankname')
                                            <p>Bank Name field is required.</p>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Bank account No.</label>
                                        <div>
                                            <input name="bankAc" class="form-control" required type="text" value="@isset($data){{ $data->bankAc}}@else{{old('bankAc')}}@endisset">
                                            <span class="text-danger">
                                                @error('bankAc')
                                                <p>Bank A/c field is required.</p>
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>IFSC Code</label>
                                        <input name="ifsc" class="form-control" type="text" required value="@isset($data){{ $data->ifsc}}@else{{ old('ifsc')}}@endisset">
                                        <span class="text-danger">
                                            @error('ifsc')
                                            <p>IFSC Code field is required.</p>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Pan Number</label>
                                        <input name="pan" class="form-control" type="text" required value="@isset($data){{ $data->pan}}@else{{old('pan')}}@endisset">
                                        <span class="text-danger">
                                            @error('pan')
                                            <p>Pan Number field is required.</p>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-success">Submit</button>
                            </div>
                        </form>
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