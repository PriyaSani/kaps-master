@extends('layouts.login')
@section('title','Admin Login')
@section('content')
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="bg-soft-primary">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-4">
                                    <h5 class="text-primary login_font">Welcome Back !</h5>
                                    <p class="login_font">Sign in to continue to {{ env('APP_NAME') }}.</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ asset('images/profile-img.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0"> 
                        <div>
                            <a href="javascript:void(0);">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <span class="avatar-title rounded-circle bg-light">
                                        <img src="{{ asset('images/favicon.png') }}" alt="" class="rounded-circle" height="34">
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="p-2">
                            <form class="form-horizontal" action="{{ route('login') }}" method="post" id="loginForm">
                                @csrf
                                <div class="form-group">
                                    <label for="username">Email</label>
                                    <input type="text" name="email" class="form-control" id="username" placeholder="Enter email" required>
                                </div>
        
                                <div class="form-group">
                                    <label for="userpassword">Password</label>
                                    <input type="password" name="password" class="form-control" id="userpassword" placeholder="Enter password" required>
                                </div>
        
                                <div class="mt-3">
                                    <button class="btn btn-primary btn-block waves-effect waves-light login_button" type="submit">Log In</button>
                                </div>
    
                                <div class="mt-4 text-center">
                                    <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock mr-1"></i> Forgot your password?</a>
                                </div>
                            </form>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
