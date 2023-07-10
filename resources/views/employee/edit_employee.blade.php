@extends('layouts.admin')
@section('title','Edit Employee')
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
                    <h4 class="mb-0 font-size-18">Edit Employee</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit Employee</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <!-- end page title -->
        <!-- end row -->
        <form class="custom-validation" action="{{ route('admin.saveEditedEmployee') }}" method="post" id="addEmployee" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4 float-right"><span class="mandatory">*</span> Mendatory</h4>
                            <h4 class="card-title mb-4">Employee Details</h4>
                            <input type="hidden" name="id" id="employee_id" value="{{ $findEmployee->id }}">

                            <div class="form-group">
                                <label>Profile Image</label>
                                <center>
                                    <img class="rounded-circle avatar-xl" alt="200x200" width="200" @if($findEmployee->profile_image != '') src="{{ asset('uploads/employee') }}/{{$findEmployee->profile_image}}"  @else src="{{ asset('images/users/user.png') }}" @endif data-holder-rendered="true" id="item-img-output">
                                    <input type="file" name="profile" class="item-img" id="my_file" style="display: none;" />
                                    <input type="hidden" name="profile_image" id="profile_image" value="">
                                    <figure style="margin-top:-25px;margin-right:-65px;">
                                        <figcaption><i class="fa fa-camera" style="color:white"></i></figcaption>
                                    </figure>
                                </center>
                            </div>

                            <div class="form-group">
                                <label>Full Name <span class="mandatory">*</span></label>
                                <input type="text" class="form-control" name="full_name" onkeypress="return /^[a-zA-Z\. ]*$/.test(event.key)" placeholder="Full Name" autocomplete="off" value="{{ $findEmployee->name }}" required/>
                            </div>

                             <div class="form-group">
                                <label>Address <span class="mandatory">*</span></label>
                                <textarea class="form-control" name="address" id="address" placeholder="Address" autocomplete="off" required>{{ $findEmployee->address }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Mobile Number <span class="mandatory">*</span></label>
                                <input type="text" class="form-control number" name="mobile_number" placeholder="Mobile Number" autocomplete="off" maxlength="10" minlength="10" value="{{ $findEmployee->mobile }}"required/>
                            </div>

                            <div class="form-group">
                                <label>DOB</label>
                                @if($findEmployee->dob != '')
                                <?php $date1 = explode('-', $findEmployee->dob);
                                      $date1 = implode('/', $date1); $date1 = date('d/m/Y',strtotime($date1)); ?>
                                @endif
                                <input type="text" class="form-control" name="dob" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="0d" @if($findEmployee->dob != '') value="{{ $date1 }}" @endif>
                            </div>

                           <div class="form-group">
                                <label>Joining Date</label>
                                @if($findEmployee->joining_date != '')
                                <?php $date2 = explode('-', $findEmployee->joining_date);
                                      $date2 = implode('/', $date2); $date2 = date('d/m/Y',strtotime($date2)); ?>
                                @endif
                                <input type="text" class="form-control" name="joining_date" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="0d" @if($findEmployee->joining_date != '') value="{{ $date2 }}" @endif>
                            </div>
                            
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea class="form-control" name="remarks" id="remarks" placeholder="Remarks" autocomplete="off">{{$findEmployee->remarks}}</textarea>
                            </div>
                            
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Login Details</h4>
                            <div class="form-group">
                                <label>Email ID <span class="mandatory">*</span></label>
                                <input type="text" class="form-control" name="email_id" placeholder="Email ID" autocomplete="off" value="{{$findEmployee->email}}" />
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" />
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" autocomplete="off" />
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
                                        @forelse ($get_all_territory as $gk => $gv)
                                            <option value="{{$gv->id}}" @if(in_array($gv->id,$terretory_id)) selected="selected" @endif >{{$gv->territory_id}}</option>
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
                                        @forelse ($get_sub_territory as $sk => $sv)
                                            <option value="{{$sv->id}}" @if(in_array($sv->id,$sub_terretory_id)) selected="selected" @endif >{{$sv->sub_territory}}</option>
                                        @empty
                                            <option>No Data Found</option>
                                        @endforelse
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
                                                <input type="checkbox" name="module[]" class="custom-control-input" id="customCheck{{$mk}}" value="{{ $mv->id }}" @if(in_array($mv->id,$getModuleId)) checked @endif>
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
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 save_button">
                                        Update
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