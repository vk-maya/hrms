@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">
@endpush
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3">

                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Change Password</h3>
                        </div>
                    </div>
                </div>

                <form action="{{route('employees.propassword')}}" method="POST">
                    @csrf                   
                    <div class="form-group">
                        <input type="hidden" name="id" value="{{Auth::guard('web')->user()->id}}">
                        <label>New password</label>
                        <input class="form-control" name="password" type="password">
                        @error('password')
                        <span class="text-danger">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Confirm password</label>
                        <input class="form-control" name="password_confirmation" type="password">
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Update Password</button>
                    </div>
                </form>
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
