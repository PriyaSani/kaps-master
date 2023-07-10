@extends('layouts.admin')
@section('title','Add offset')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Add offset</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.doctorList') }}">Doctor List</a></li>
                            <li class="breadcrumb-item active">Add offset</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <!-- end page title -->
        <!-- end row -->
            <div class="row">
                <div class="col-lg-6 offset-3">

                    <h4 class="mb-0 font-size-18">{{$doctor_details['doctor_detail']['full_name']}} @if(isset($doctor_details['profile_name'])) ({{$doctor_details['profile_name']}}) @endif</h4><br>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4 float-right"><span class="mandatory">*</span> Mendatory</h4><br>
                            <form class="custom-validation" action="{{ route('admin.saveDoctorOffset') }}" method="post" id="saveDoctorOffset" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">

                                <label>Sales for {{date('M y', strtotime($previous_month))}} <span class="mandatory">*</span></label>
                                <!-- <label>Sales for Oct 20 <span class="mandatory">*</span></label> -->
                                <input type="text" class="form-control numinput" name="last_month_sales" autocomplete="off" @if(isset($get_offset_sales->last_month_sales) && ($get_offset_sales->last_month_sales != '')) value={{$get_offset_sales->last_month_sales}} @else value="0" @endif required/>
                                <input type="hidden" name="last_month_date" value="{{$previous_month}}">
                            </div>
                            <div class="form-group">

                                <label>Sales for {{date('M y', strtotime($previous_second_month))}} <span class="mandatory">*</span></label>
                                <!-- <label>Sales for Sep 20 <span class="mandatory">*</span></label> -->
                                <input type="text" class="form-control numinput" name="previous_second_month_sales" @if(isset($get_offset_sales->previous_second_month_sales) && ($get_offset_sales->previous_second_month_sales != '')) value={{$get_offset_sales->previous_second_month_sales}} @else value="0" @endif autocomplete="off" required/>
                                <input type="hidden" name="previous_second_month_date" value="{{$previous_second_month}}">
                            </div>

                            <div class="form-group">
                                <label>Sales for {{date('M y', strtotime($previous_third_month))}} <span class="mandatory">*</span></label>
                                <!-- <label>Sales for Aug 20 <span class="mandatory">*</span></label> -->
                                <input type="text" class="form-control numinput" name="previous_third_month_sales" @if(isset($get_offset_sales->previous_third_month_sales) && ($get_offset_sales->previous_third_month_sales != '')) value={{$get_offset_sales->previous_third_month_sales}} @else value="0" @endif autocomplete="off" required/>
                                <input type="hidden" name="previous_third_month_date" value="{{$previous_third_month}}">
                            </div>

                            <div class="form-group">
                                <label>Target in {{date('M y', strtotime($previous_month))}} <span class="mandatory">*</span></label>
                               <!--  <label>Target in Oct 20 <span class="mandatory">*</span></label> -->
                                <input type="text" class="form-control numinput" name="target_previous_month" @if(isset($get_offset_sales->target_previous_month) && ($get_offset_sales->target_previous_month != '')) value={{$get_offset_sales->target_previous_month}} @else value="0" @endif  autocomplete="off" required/>
                                <input type="hidden" name="target_previous_month_date" value="{{$previous_month}}">
                            </div>

                            <div class="form-group">
                                <label>Carry forward for {{date('M y', strtotime($current_month))}} <span class="mandatory">*</span></label>
                                <!-- <label>Carry forward for Nov 20 <span class="mandatory">*</span></label> -->
                                <input type="text" class="form-control numinput" name="carry_forward" autocomplete="off" @if(isset($get_offset_sales->carry_forward) && ($get_offset_sales->carry_forward != '')) value={{$get_offset_sales->carry_forward}} @else value="0" @endif required/>

                                <input type="hidden" name="carry_forward_date" value="{{$current_month}}">
                            </div>
                            <div class="form-group">
                                <label>Eligible Amount for {{date('M y', strtotime($current_month))}} <span class="mandatory">*</span></label>
                               <!--  <label>Eligible Amount for Nov 20 <span class="mandatory">*</span></label> -->
                                <input type="text" class="form-control numinput" name="eligible_amount" autocomplete="off" @if(isset($get_offset_sales->eligible_amount) && ($get_offset_sales->eligible_amount != '')) value={{$get_offset_sales->eligible_amount}} @else value="0" @endif required/>

                                <input type="hidden" name="eligible_amount_date" value="{{$current_month}}">
                            </div>
                            <input type="hidden" name="profile_id" value="{{$id}}">
                            <input type="hidden" name="doctor_id" value="{{$doctor_id}}">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 save_button" name="btn_submit" value="save">
                                        Save
                                </button>
                                <a href="{{ route('admin.doctorManageProfile',$doctor_id) }}" class="btn btn-secondary waves-effect cancel_button">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
