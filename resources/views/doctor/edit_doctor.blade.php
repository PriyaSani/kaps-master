@extends('layouts.admin')
@section('title','Edit Doctor')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Doctor</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit Doctor</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <!-- end page title -->
        <!-- end row -->
        <form class="custom-validation" action="{{ route('admin.saveEditedDoctor') }}" method="post" id="doctorForm" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4 float-right"><span class="mandatory">*</span> Mendatory</h4>
                            <h4 class="card-title mb-4">Doctor Details</h4>
                            <div class="form-group">
                                <label>Full Name <span class="mandatory">*</span></label>
                                <input type="text" class="form-control" name="full_name" onkeypress="return /^[a-zA-Z\. ]*$/.test(event.key)" placeholder="Full Name" autocomplete="off" value="{{$get_doctor->full_name}}" required/>
                            </div>

                            <div class="form-group">
                                <label>Specialization <span class="mandatory">*</span></label>
                                <input type="text" class="form-control" name="specialization" placeholder="Specialization" autocomplete="off" value="{{$get_doctor->specialization}}" required/>
                            </div>

                            <div class="form-group">
                                <label>Email <span class="mandatory">*</span></label>
                                <input type="text" class="form-control" name="email" placeholder="Email" autocomplete="off" value="{{$get_doctor->email}}" />
                                <input type="hidden" name="id" id="doctor_id" value="{{$get_doctor->id}}">
                            </div>

                            <div class="form-group">
                                <label>Mobile Number<span class="mandatory">*</span></label>
                                <input type="text" class="form-control number" name="mobile_number" placeholder="Mobile Number" autocomplete="off" maxlength="10" minlength="10" value="{{$get_doctor->mobile_number}}" />
                            </div>

                            <div class="form-group">
                                <label>DOB</label>
                                @if($get_doctor->dob != '')
                                <?php $date1 = explode('-', $get_doctor->dob);
                                      $date1 = implode('/', $date1); $date1 = date('d/m/Y',strtotime($date1)); ?>
                                @endif
                                <input type="text" class="form-control" name="dob" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="0d" autocomplete="off" @if($get_doctor->dob != '') value="{{ $date1 }}" @endif>
                            </div>

                           <div class="form-group">
                                <label>Date Anniversary</label>
                                @if($get_doctor->anniversary_date != '')
                                <?php $date2 = explode('-', $get_doctor->anniversary_date);
                                      $date2 = implode('/', $date2); $date2 = date('d/m/Y',strtotime($date2)); ?>
                                @endif
                                <input type="text" class="form-control" name="anniversary_date" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="0d" autocomplete="off" @if($get_doctor->anniversary_date != '') value="{{ $date2 }}" @endif>
                            </div>

                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea class="form-control" name="remarks" id="remarks" placeholder="Remarks" autocomplete="off">{{$get_doctor->remarks}}</textarea>
                            </div>
                           
                        </div>
                    </div>

                    
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Clinic Details</h4>
                            <div class="form-group">
                                <label>Clinic Name</label>
                                <input type="text" class="form-control" name="clininc_name" placeholder="Clinic Name" value="{{$get_doctor->clininc_name}}" autocomplete="off"/>
                            </div>

                            <div class="form-group">
                                <label>Clinic Address</label>
                                <textarea class="form-control" name="clinic_address" id="clinic_address" placeholder="Clinic Address" autocomplete="off" >{{$get_doctor->clinic_address}}</textarea>

                            </div>

                            <div class="form-group">
                                <label>Clinic Opening Date</label>
                                <input type="text" class="form-control" name="clinic_opening_date" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="0d" autocomplete="off" @if($get_doctor->clinic_opening_date != '') value="{{ date('d/m/yy',strtotime($get_doctor->clinic_opening_date)) }}" @endif>
                            </div>

                        </div>
                    </div>
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
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 save_button" name="btn_submit" value="save">
                                        Update
                                    </button>
                                    <a href="{{ route('admin.doctorList') }}" class="btn btn-secondary waves-effect cancel_button">
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