@extends('layouts.login')
@section('title','Admin Password')
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
                                    <h5 class="text-primary login_font">Reset Password !</h5>
                                    <p class="login_font">{{ env('APP_NAME') }}.</p>
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
                            @if (session('status'))
                                <div class="alert alert-success text-center mb-4" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            
                            <form class="form-horizontal" action="{{ route('password.email') }}" method="post" id="forgotForm">
                                @csrf
                               <div class="form-group">
                                    <label for="useremail">Email</label>
                                    <input type="email" class="form-control" name="email" id="useremail" name="eamil" placeholder="Enter email" required>
                                </div>
            
                                <div class="form-group row mb-0">
                                    <div class="col-12 text-right">
                                        <button class="btn btn-primary w-md waves-effect waves-light login_button" type="submit">Send Password Reset Link</button>
                                    </div>

                                </div>
                                <div class="mt-4 text-center">
                                    <a href="{{ route('login') }}" class="text-muted "><i class="mdi mdi-lock mr-1"></i> Back to login</a>
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
