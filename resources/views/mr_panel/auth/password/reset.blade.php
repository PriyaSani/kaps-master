@extends('layouts.login')
@section('title','Mr Reset Password')
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
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p>Sign in to continue to {{ env('APP_NAME') }}.</p>
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
                                        <img src="{{ asset('images/logo.svg') }}" alt="" class="rounded-circle" height="34">
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="p-2">
                            <form class="form-horizontal" action="{{ route('mr.resetpassword') }}" method="post" id="resetPassword">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group hide">
                                    <label for="username">Email</label>
                                    <input type="text" name="email" class="form-control" id="username" placeholder="Enter email" value="{{ $email }}">
                                </div>
        
                                <div class="form-group">
                                    <label for="userpassword">Password</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter password">
                                </div>

                                <div class="form-group">
                                    <label for="userpassword">Comfirm Password</label>
                                    <input type="password" class="form-control" id="userpassword" placeholder="Enter comfirm password" name="password_confirmation">
                                </div>
        
                                <div class="mt-3">
                                    <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Reset Password</button>
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
