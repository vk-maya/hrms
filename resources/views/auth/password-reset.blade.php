@extends('admin.layouts.loginapp')
@section('title')
    <title>Employee Login - Scrum Digital HRMS</title>
@endsection
@section('content')
    <div class="main-wrapper">
        <div class="account-content">
            <div class="container">

                <div class="account-logo">
                    <img src="{{ asset('assets/img/logo2.png') }}" alt="Scrum Digital">
                </div>

                <div class="account-box">
                    <div class="account-wrapper">
                        <h3 class="account-title">Register</h3>
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @error('email')
                            <span class="text-danger">
                                <i class="fa fa-times" aria-hidden="true"><strong> {{ $message }}</strong></i>
                            </span>
                        @enderror
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <div class="form-group">
                                <label>Email Address</label>
                                <input class="form-control" name="email" type="text"
                                    value="{{ old('email', $request->email) }}" required autofocus>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input id="password" class="form-control" type="password" name="password" required />
                            </div>

                            <div class="form-group">
                                <label>Repeat Password<span class="mandatory">*</span></label>
                                <input id="password_confirmation" class="form-control" type="password"
                                    name="password_confirmation" required />
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary account-btn" type="submit">Reset Password</button>
                            </div>
                            <div class="account-footer">
                                <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
