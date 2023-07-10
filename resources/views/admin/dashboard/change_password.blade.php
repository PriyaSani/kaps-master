@extends('layouts.admin')
@section('title','Change Password')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Change Password</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Change Password</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <!-- end page title -->
        <!-- end row -->
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="card">
                    <div class="card-body">
                        <form class="custom-validation" action="{{ route('admin.updatePassword') }}" method="post" id="changePassword">
                        	@csrf
                        	
                            <div class="form-group">
                                <label>Current Password<span class="mandatory">*</span></label>
                                <input type="password" class="form-control" name="old_pass" required placeholder="Current Password"/>
                            </div>

                            <div class="form-group">
                                <label>New Password<span class="mandatory">*</span></label>
                                <input type="password" class="form-control" name="new_pass" required placeholder="New Password" id="inputNewPassword" />
                            </div>

                            <div class="form-group">
                                <label>Confirm New Password<span class="mandatory">*</span></label>
                                <input type="password" class="form-control" name="confirm_password" required placeholder="Confirm New Password"/>
                            </div>

                            
                            <div class="form-group mb-0">
                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 save_button">
                                        Submit
                                    </button>
                                    <a href="{{ route('dashboard') }}" class="btn btn-secondary waves-effect cancel_button">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection