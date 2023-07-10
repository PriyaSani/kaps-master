@extends('layouts.admin')
@section('title','Add Doctor')
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
                    <h4 class="mb-0 font-size-18">Add Doctor</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add Doctor</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <!-- end page title -->
        <!-- end row -->
        <form class="custom-validation" action="{{ route('admin.saveDoctor') }}" method="post" id="doctorForm" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4 float-right"><span class="mandatory">*</span> Mendatory</h4>
                            <h4 class="card-title mb-4">Doctor Details</h4>
                            <div class="form-group">
                                <label>Full Name <span class="mandatory">*</span></label>
                                <input type="text" class="form-control " onkeypress="return /^[a-zA-Z\. ]*$/.test(event.key)" name="full_name" placeholder="Full Name" autocomplete="off" required/>
                            </div>

                            <div class="form-group">
                                <label>Specialization <span class="mandatory">*</span></label>
                                <input type="text" class="form-control" name="specialization" placeholder="Specialization" autocomplete="off" required/>
                            </div>

                            <div class="form-group">
                                <label>Email </label>
                                <input type="text" class="form-control" name="email" placeholder="Email" autocomplete="off" />
                            </div>

                            <div class="form-group">
                                <label>Mobile Number </label>
                                <input type="text" class="form-control number" name="mobile_number" placeholder="Mobile Number" autocomplete="off" maxlength="10" minlength="10"/>
                            </div>

                            <div class="form-group">
                                <label>DOB</label>
                                <input type="text" class="form-control" name="dob" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="0d" autocomplete="off">
                            </div>

                           <div class="form-group">
                                <label>Date Anniversary</label>
                                <input type="text" class="form-control" name="anniversary_date" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="0d" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Remarks </label>
                                <textarea class="form-control" name="remarks" id="remarks" placeholder="Remarks" autocomplete="off"></textarea>
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
                                <input type="text" class="form-control" name="clininc_name" placeholder="Clinic Name" autocomplete="off"/>
                            </div>

                            <div class="form-group">
                                <label>Clinic Address</label>
                                <textarea class="form-control" name="clinic_address" id="clinic_address" placeholder="Clinic Address" autocomplete="off"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Clinic Opening Date</label>
                                <input type="text" class="form-control" name="clinic_opening_date" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="0d" autocomplete="off">
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