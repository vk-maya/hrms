@extends('layouts.loginapp')
@section('content')
    <div class="main">
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="../assets/img/pages/signin.jpg" alt="sing up image"></figure>
                        <a href="sign_up.html" class="signup-image-link">Create an account</a>
                    </div>
                    <div class="signin-form">
                        <h2 class="form-title">Login</h2>
                        <form action="{{route('login')}}" method="POST"  class="register-form" id="login-form">
                            @csrf
                            <div class="form-group">
                                <div class="">
                                    <input name="email" type="text" placeholder="User Name"
                                        class="form-control input-height" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="">
                                    <input name="password" type="password" placeholder="Password"
                                        class="form-control input-height" />
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember
                                    me</label>
                            </div>
                            <div class="form-group form-button">
                                <button class="btn btn-round btn-primary" name="signin" id="signin">Login</button>
                            </div>
                        </form>                      
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('js')
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- bootstrap -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
@endpush
