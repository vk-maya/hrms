@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Profile</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">More Information</li>
                        </ul>
                    </div>
                    <div>
                        <div class="mt-5">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Personal Information</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('employees.add.moreinfo.save') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ Auth::guard('web')->user()->id }}">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Nationality Select</label>
                                                    <select class="select form-control" name="nationality">
                                                        <option @if (isset($data) && $data->nationality == 'indian') selected @endif
                                                            value="indian">Indian</option>
                                                        <option @if (isset($data) && $data->nationality == 'other') selected @endif
                                                            value="other">Other</option>
                                                    </select>
                                                    <span class="text-danger">
                                                        @error('nationality')
                                                            <p>Nationality field is required.</p>
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Marital status Select<span class="text-danger">*</span></label>
                                                    <select class="select form-control" name="maritalstatus">
                                                        <option @if (isset($data) && $data->maritalStatus == 'single') selected @endif
                                                            value="single">Single</option>
                                                        <option @if (isset($data) && $data->maritalStatus == 'married') selected @endif
                                                            value="married">Married</option>
                                                    </select>
                                                    <span class="text-danger">
                                                        @error('maritalstatus')
                                                            <p>Marital status field is required.</p>
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>No. of children Select<span class="text-danger">*</span></label>
                                                    <select class="select form-control" name="children">
                                                        <option @if (isset($data) && $data->noOfChildren ==0) selected @endif
                                                            value="0">0</option>
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
                                                        <option @if (isset($data) && $data->noOfChildren == '5+') selected @endif
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Bank Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" name="bankname" type="text"
                                                        value="@isset($data){{$data->bankname }}@else{{old('bankname')}}@endisset" required>
                                                    <span class="text-danger">
                                                        @error('bankname')
                                                            <p>Bank Name field is required.</p>
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Bank account No.<span class="text-danger">*</span></label>
                                                    <div>
                                                        <input name="bankAc" class="form-control" type="text"
                                                            value="@isset($data){{$data->bankAc}}@else{{old('bankAc')}}@endisset" required>
                                                        <span class="text-danger">
                                                            @error('bankAc')
                                                                <p>Bank A/c field is required.</p>
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>IFSC Code<span class="text-danger">*</span></label>
                                                    <input name="ifsc" class="form-control" type="text"
                                                        value="@isset($data){{$data->ifsc}}@else{{old('ifsc')}}@endisset" required>
                                                    <span class="text-danger">
                                                        @error('ifsc')
                                                            <p>IFSC Code field is required.</p>
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Pan Number<span class="text-danger">*</span></label>
                                                    <input name="pan" class="form-control" type="text"
                                                        value="@isset($data){{$data->pan }}@else{{old('pan')}}@endisset" required>
                                                    <span class="text-danger">
                                                        @error('pan')
                                                            <p>Pan Number field is required.</p>
                                                        @enderror
                                                    </span>
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
                </div>
            </div>
        </div>
    </div>
@endsection
@push('plugin-js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
@endpush
