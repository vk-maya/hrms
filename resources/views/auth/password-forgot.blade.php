@extends('admin.layouts.loginapp')
@section('title')
<title>Employee Login - Scrum Digital HRMS</title>
@endsection
@section('content')
<div class="main-wrapper">
    <div class="account-content">
        <div class="container">
            <div class="account-logo">
                <a href="admin-dashboard.html"><img src="assets/img/logo2.png" alt="Dreamguy's Technologies"></a>
            </div>
          
            
            <div class="account-box">
                <div class="account-wrapper">
                    <h3 class="account-title">Forgot Password?</h3>
                    @if ($message = Session::get('status'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group">
                            <label>Email Address</label>
                            <input class="form-control" name="email" type="email.com">
                            @error('email')
                            <span class="text-danger">
                                <i class="fa fa-times" aria-hidden="true"><strong> {{ $message }}</strong></i>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary account-btn" type="submit">Reset Password</button>
                        </div>
                        <div class="account-footer">
                            <p>Remember your password? <a href="{{route('login')}}">Login</a></p>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
