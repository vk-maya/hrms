@extends('admin.layouts.loginapp')
@section('content')
    <div class="main-wrapper">
        <div class="account-content">
            <div class="container">

                <div class="account-logo">
                    <img src="{{ asset('assets/img/logo2.png') }}"
                            alt="Dreamguy's Technologies">
                </div>
                <div class="account-box">
                    <div class="account-wrapper">
                        <h3 class="account-title"> Uer Login</h3>
                        <p class="account-subtitle">Access to Employees</p>

                        <form action="{{route('login')}}" method="POST"  class="register-form" id="login-form">
                            @csrf
                            <div class="form-group">
                                <label>Email Address</label>
                                <input class="form-control" name="email" type="text" value="">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>Password</label>
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <input class="form-control" type="password" name="password" value="" id="password">
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
