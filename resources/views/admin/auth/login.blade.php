@extends('admin.layouts.loginapp')
@section('title')
<title>Admin Login - Scrum Digital HRMS</title>
@endsection
@push('css')


@endpush
@section('content')

<div class="main-wrapper login-scrum" style="background-image: url('{{ asset('assets/img/admin-bg.jpg')}}'); background-size: cover">
    <div class="account-content">
        <div class="container">

            <div class="account-box">
                <div class="account-wrapper">

                    <div class="account-logo">
                        <img src="{{ asset('assets/img/logo2.png') }}" alt="Scrum Digital">
                    </div>
                    {{-- <h3 class="account-title">Login</h3> --}}
                    <p class="account-title">Access to Admin</p>

                    <form action="{{ route('admin.login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Email Address</label>
                            <input class="form-control" name="email" type="text" value="{{ old('email') }}">
                            @error('email')
                            <span class="text-danger mt-1 d-inline-block"><small>{{$message}}</small></span>
                            @enderror

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label>Password</label>
                                </div>
                            </div>
                            <div class="position-relative">
                                <input class="form-control" type="password" name="password" id="password">
                                <span class="fa fa-eye-slash" id="toggle-password"></span>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary account-btn" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
