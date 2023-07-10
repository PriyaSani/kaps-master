@extends('layouts.admin')
@section('title','Add Employee')
@section('content')
<style type="text/css">
#upload-demo{
    width: 250px;
    height: 250px;
    padding-bottom:25px;
}
</style>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Add Employee</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add Employee</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <!-- end page title -->
        <!-- end row -->
        <form class="custom-validation" action="{{ route('admin.saveEmployee') }}" method="post" id="addEmployee" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4 float-right"><span class="mandatory">*</span> Mendatory</h4>
                            <h4 class="card-title mb-4">Employee Details</h4>
                            <div class="form-group">
                                <label>Profile Image</label>
                                <center>
                                    <img class="rounded-circle avatar-xl" alt="200x200" width="200" src="{{ asset('images/users/user.png') }}" data-holder-rendered="true" id="item-img-output">
                                    <input type="file" name="profile" class="item-img" id="my_file" style="display: none;" />
                                    <input type="hidden" name="profile_image" id="profile_image" value="">
                                    <figure style="margin-top:-25px;margin-right:-65px;">
                                        <figcaption><i class="fa fa-camera" style="color:white"></i></figcaption>
                                    </figure>
                                </center>
                            </div>

                            <div class="form-group">
                                <label>Full Name <span class="mandatory">*</span></label>
                                <input type="text" class="form-control" name="full_name" onkeypress="return /^[a-zA-Z\. ]*$/.test(event.key)" placeholder="Full Name" autocomplete="off" required/>
                            </div>

                            <div class="form-group">
                                <label>Address <span class="mandatory">*</span></label>
                                <textarea class="form-control" name="address" id="address" placeholder="Address" autocomplete="off" required></textarea>
                            </div>

                             <div class="form-group">
                                <label>Mobile Number <span class="mandatory">*</span></label>
                                <input type="text" class="form-control number" name="mobile_number" placeholder="Mobile Number" autocomplete="off" maxlength="10" minlength="10" required/>
                            </div>

                            <div class="form-group">
                                <label>DOB</label>
                                <input type="text" class="form-control" name="dob" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="0d" autocomplete="off">
                            </div>

                           <div class="form-group">
                                <label>Joining Date</label>
                                <input type="text" class="form-control" name="joining_date" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="0d" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea class="form-control" name="remarks" id="remarks" placeholder="Remarks" autocomplete="off"></textarea>
                            </div>
                           
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Login Details</h4>
                            <div class="form-group">
                                <label>Email ID <span class="mandatory">*</span></label>
                                <input type="text" class="form-control" name="email_id" placeholder="Email ID" autocomplete="off" />
                            </div>

                            <div class="form-group">
                                <label>Password <span class="mandatory">*</span></label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" required data-msg="Enter Password"/>
                            </div>

                            <div class="form-group">
                                <label>Confirm Password <span class="mandatory">*</span></label>
                                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" autocomplete="off" required data-msg="Enter Confirm Password"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Territories</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Territories <span class="mandatory">*</span></label>
                                    <select class="select2 form-control select2-multiple territories" multiple="multiple" name="territories[]" data-placeholder="" required>
                                        @forelse ($get_territories as $gk => $gv)
                                            <option value="{{$gv->id}}">{{$gv->territory_id}}</option>
                                        @empty
                                            <option>No Data Found</option>
                                        @endforelse
                                    </select>
                                    <span id="territories"></span>
                                </div>
                            </div><br><br>
                            <div class="row">    
                                <div class="col-md-12">
                                    <label>Sub Territories <span class="mandatory">*</span></label>
                                    <select class="select2 form-control select2-multiple sub_territories" multiple="multiple" name="sub_territories[]" data-placeholder="" required>
                                        
                                    </select>
                                    <span id="sub_territories"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Modules Access <span class="mandatory">*</span></h4>
                            <div class="row">
                            @if(!is_null($getModule))
                                @foreach($getModule as $mk => $mv)
                                    <div class="col-md-6">
                                        <div class="mt-4 mt-lg-0">
                                            <div class="custom-control custom-checkbox mb-2">
                                                <input type="checkbox" name="module[]" class="custom-control-input" id="customCheck{{$mk}}" value="{{ $mv->id }}">
                                                <label class="custom-control-label" for="customCheck{{$mk}}">{{ $mv->name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            </div>
                            <span id="module"></span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 save_button" name="btn_submit" value="save">
                                        Save
                                    </button>
                                    <button type="submit" class="btn btn-danger waves-effect waves-light mr-1 save_and_next_button" name="btn_submit" value="save_and_update">
                                        Save & Add New
                                    </button>
                                    <a href="{{ route('admin.employeeList') }}" class="btn btn-secondary waves-effect cancel_button">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script>



</script>
@endsection