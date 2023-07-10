<?php

namespace App\Http\Controllers;

use Auth;
use App\Model\Territory;
use App\Model\AllRequest;
use App\Model\SubTerritory;
use App\Model\DoctorDetail;
use App\Model\DoctorOffset;
use App\Model\DoctorProfile;
use Illuminate\Http\Request;
use App\Model\DoctorTerritory;
use App\Model\DoctorCommission;
use App\Http\Controllers\Controller;
use App\Model\MedicalStoreDoctorData;
use App\Http\Controllers\GlobalController;

class DoctorController extends GlobalController
{
    public function __construct(){
       $this->middleware('auth');
       $this->middleware('checkpermission');
    }

    // Doctor List
    public function doctorList(){
        if(Auth::guard()->user()->id != 1){
            $get_user_territory = array_unique($this->userTerritory(Auth::guard()->user()->id));
            $get_user_sub_territory = array_unique($this->userSubTerritory(Auth::guard()->user()->id));
            
            $get_doctor = DoctorDetail::where('is_delete',0)
                                      ->with([
                                        'profile',
                                        'get_territory' => function($q){ 
                                            $q->with([
                                                'territory_name',
                                                'sub_territory'
                                            ]); 
                                        }
                                      ])
                                      ->whereHas(
                                        'territory_detail', function ($query) use ($get_user_territory) { 
                                            $query->whereIn('territories_id', $get_user_territory); 
                                        }
                                      )
                                      ->WhereHas('territory_detail', function ($query) use ($get_user_sub_territory) { 
                                            $query->whereIn('sub_territories',$get_user_sub_territory); 
                                        }
                                      )
                                      ->get();
            
        } else {
            $get_doctor = DoctorDetail::where('is_delete',0)
                                      ->with([
                                        'profile',
                                        'get_territory' => function($q){ 
                                            $q->with([
                                                'territory_name',
                                                'sub_territory'
                                            ]); 
                                        }
                                      ])
                                      ->get();
        }

        return view('doctor.doctor_list',compact('get_doctor'));
    }

    // Add Doctor
    public function addDoctor(){

        $get_territories = Territory::where('is_active',1)->where('is_delete',0)->get();

        return view('doctor.add_doctor',compact('get_territories'));
    }

    // Save Doctor
    public function saveDoctor(Request $request){

        $save_doctor = new DoctorDetail;
        $save_doctor->full_name = $request->full_name;
        $save_doctor->specialization = $request->specialization;
        $save_doctor->email = $request->email;
        $save_doctor->mobile_number = $request->mobile_number;
        if($request->dob != ''){
            $save_doctor->dob = $request->dob ? $this->convertDate($request->dob) : "";
        }

        if($request->anniversary_date != ''){
            $save_doctor->anniversary_date = $request->anniversary_date ? $this->convertDate($request->anniversary_date) : "";
        }

        $save_doctor->remarks = $request->remarks;
        $save_doctor->clininc_name = $request->clininc_name;
        $save_doctor->clinic_address = $request->clinic_address;
        if($request->clinic_opening_date != ''){
            $save_doctor->clinic_opening_date = $request->clinic_opening_date ? $this->convertDate($request->clinic_opening_date) : "";
        }

        $save_doctor->save();

        $territories_details = array();
        if(!is_null($request->territories)){
            foreach($request->territories as $tk => $tv){
                $territories_details[$tk]['territories'] = $tv;
            }
        }

        if(!is_null($request->sub_territories)){
            foreach($request->sub_territories as $sk => $sv){
                $territories_details[$sk]['sub_territories'] = $sv;
            }
        }

        if(!is_null($territories_details)){
            foreach($territories_details as $dk => $dv){
               
                $save_territories = new DoctorTerritory;
                $save_territories->doctor_id = $save_doctor->id;
                if(isset($dv['territories'])){
                    $save_territories->territories_id = $dv['territories'];    
                } else {
                    if(isset($dv['sub_territories'])){
                        $main_territory = SubTerritory::where('id',$dv['sub_territories'])->where('is_delete',0)->first();
                        $save_territories->territories_id = $main_territory->territory_id;    
                    }
                }
                if(isset($dv['sub_territories'])){
                    $save_territories->sub_territories = $dv['sub_territories'];
                }
                $save_territories->save();
            }
        }

        if($request->btn_submit == 'save_and_update'){

            return redirect(route('admin.addDoctor'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Doctor',
                    'message' => 'Doctor Successfully Added',
                ],
            ]); 

        } else {

            return redirect(route('admin.doctorList'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Doctor',
                    'message' => 'Doctor Successfully Added',
                ],
            ]); 
        }
    }

    // Edit Doctor
    public function editDoctor($id){

        $get_doctor = DoctorDetail::where('id',$id)->first();

        $terretory_id = DoctorTerritory::where('doctor_id',$id)->pluck('territories_id')->toArray();

        $sub_terretory_id = DoctorTerritory::where('doctor_id',$id)->pluck('sub_territories')->toArray();

        $get_all_territory = Territory::where('is_active',1)->where('is_delete',0)->get();

        $get_sub_territory = SubTerritory::whereIn('territory_id',$terretory_id)->where('is_active',1)->where('is_delete',0)->get();

        return view('doctor.edit_doctor',compact('get_doctor','terretory_id','sub_terretory_id','get_all_territory','get_sub_territory'));
    }

    // Update doctor details
    public function saveEditedDoctor(Request $request){

        $save_doctor = DoctorDetail::findOrFail($request->id);
        $save_doctor->full_name = $request->full_name;
        $save_doctor->specialization = $request->specialization;
        $save_doctor->email = $request->email;
        $save_doctor->mobile_number = $request->mobile_number;
        if($request->dob != ''){
            $save_doctor->dob = $this->convertDate($request->dob);
        }

        if($request->anniversary_date != ''){
            $save_doctor->anniversary_date = $this->convertDate($request->anniversary_date);
        }

        $save_doctor->remarks = $request->remarks;
        $save_doctor->clininc_name = $request->clininc_name;
        $save_doctor->clinic_address = $request->clinic_address;
        if($request->clinic_opening_date != ''){
            $save_doctor->clinic_opening_date = $this->convertDate($request->clinic_opening_date);
        }

        $save_doctor->save();

        $territories_details = array();
        if(!is_null($request->territories)){
            foreach($request->territories as $tk => $tv){
                $territories_details[$tk]['territories'] = $tv;
            }
        }

        if(!is_null($request->sub_territories)){
            foreach($request->sub_territories as $sk => $sv){
                $territories_details[$sk]['sub_territories'] = $sv;
            }
        }

        if(!is_null($territories_details)){
            $removeTerritories = DoctorTerritory::where('doctor_id',$request->id)->delete();
            foreach($territories_details as $dk => $dv){
               
                $save_territories = new DoctorTerritory;
                $save_territories->doctor_id = $request->id;
                if(isset($dv['territories'])){
                    $save_territories->territories_id = $dv['territories'];    
                } else {
                    if(isset($dv['sub_territories'])){
                        $main_territory = SubTerritory::where('id',$dv['sub_territories'])->where('is_delete',0)->first();
                        $save_territories->territories_id = $main_territory->territory_id;    
                    }
                }
                if(isset($dv['sub_territories'])){
                    $save_territories->sub_territories = $dv['sub_territories'];
                }
                $save_territories->save();
            }
        }

        return redirect(route('admin.doctorList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Doctor',
                'message' => 'Doctor Successfully Added',
            ],
        ]); 
    }

    // Delete Doctor
    public function deleteDoctor($id){

        $deleteEmployee = DoctorDetail::where('id',$id)->update(['is_delete' => 1]);

        return redirect(route('admin.doctorList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Doctor',
                'message' => 'Doctor Successfully Deleted',
            ],
        ]); 

    }
    
    // Check doctor Email Exists or not
    public function checkDoctorEmailExists(Request $request){

        $query = DoctorDetail::query();
        $query->where('email',$request->email);
        $query->where('is_delete',0);
        if (isset($request->id)) {
            $query->where('id','!=',$request->id);
        }
        $admin = $query->first();

        return (!is_null($admin) ? 'false' : 'true'); 

    }

    // Check mobile number exists or not
    public function checkDoctorMobileExists(Request $request){

        $query = DoctorDetail::query();
        $query->where('mobile_number',$request->mobile_number);
        $query->where('is_delete',0);
        if (isset($request->id)) {
            $query->where('id','!=',$request->id);
        }
        $admin_mobile = $query->first();

        return (!is_null($admin_mobile) ? 'false' : 'true'); 

    }

    // Change doctor status
    public function doctorChangeStatus(Request $request){

        $updateStatus = DoctorDetail::where('id',$request->id)->update(['is_active' => $request->option]);

        return $updateStatus ? 'true' : 'false';

    }

    // Doctor manage profile
    public function doctorManageProfile($id){

        $get_doctor = DoctorDetail::where('id',$id)->first();

        $get_doctor_profiles = DoctorProfile::where('doctor_id',$id)->where('profile_name',NULL)->where('is_delete',0)->first();

        if(empty($get_doctor_profiles)){
            $doctor_profile = new DoctorProfile;
            $doctor_profile->doctor_id = $id;
            $doctor_profile->profile_name = NULL;
            $doctor_profile->save();
        }

        $current_date = date("Y-m-d");

        // Get profile id
        $get_profile_id = DoctorProfile::where('doctor_id',$id)->pluck('id')->toArray();
        
        $get_doctor_offset = DoctorOffset::where('doctor_id',$id)->orderBy('id','DESC')->first();
        $check_offset = DoctorOffset::whereIn('profile_id',$get_profile_id)->where('doctor_id',$id)->orderBy('id','DESC')->first();

        $last_month_sales = array();
        if(!empty($get_profile_id) && (!empty($check_offset))){
            foreach($get_profile_id as $pk => $pv){
                $last_month_sales_data = DoctorOffset::where('doctor_id',$id)->where('profile_id',$pv)->where('last_month_date',$get_doctor_offset->last_month_date)->orderBy('id','DESC')->first();
                if(isset($last_month_sales_data->last_month_sales) && ($last_month_sales_data->last_month_sales != '')){
                    $last_month_sales[] = $last_month_sales_data->last_month_sales;
                } else {
                    $last_month_sales[] = 0;
                }
            }
        } else {
            $last_month_sales[] = 0;
        }

        $previous_sales_data = array();
        if(!empty($get_profile_id) && (!empty($check_offset))){
            foreach($get_profile_id as $pk => $pv){
                $previous_second_month_sales_data = DoctorOffset::where('doctor_id',$id)->where('profile_id',$pv)->where('previous_second_month_date',$get_doctor_offset->previous_second_month_date)->orderBy('id','DESC')->first();
                if(isset($previous_second_month_sales_data->previous_second_month_sales) && ($previous_second_month_sales_data->previous_second_month_sales != '')){
                    $previous_sales_data[] =  $previous_second_month_sales_data->previous_second_month_sales;
                } else {
                    $previous_sales_data[] =  0;
                }
            }
        } else {
            $previous_sales_data[] = 0;
        }
    
        $previous_third_sales_data = array();
        if(!empty($get_profile_id) && (!empty($check_offset))){
            foreach($get_profile_id as $pk => $pv){
                $previous_third_month_sales_data = DoctorOffset::where('doctor_id',$id)->where('profile_id',$pv)->where('previous_third_month_date',$get_doctor_offset->previous_third_month_date)->orderBy('id','DESC')->first();
                if(isset($previous_third_month_sales_data->previous_third_month_sales) && ($previous_third_month_sales_data->previous_third_month_sales != '')){
                    $previous_third_sales_data[] =  $previous_third_month_sales_data->previous_third_month_sales;
                } else {
                    $previous_third_sales_data[] =  0;
                }
            }
        } else {
            $previous_third_sales_data[] = 0;
        }

        $target_sales_data = array();
        if(!empty($get_profile_id) && (!empty($check_offset))){
            foreach($get_profile_id as $pk => $pv){
                $target_sales_detail = DoctorOffset::where('doctor_id',$id)->where('profile_id',$pv)->where('target_previous_month_date',$get_doctor_offset->target_previous_month_date)->orderBy('id','DESC')->first();
                if(isset($target_sales_detail->target_previous_month) && ($target_sales_detail->target_previous_month != '')){
                    $target_sales_data[] =  $target_sales_detail->target_previous_month;
                } else {
                    $target_sales_data[] =  0;
                }
            }
        } else {
            $target_sales_data[] = 0;
        }

        $carry_sales_data = array();
        if(!empty($get_profile_id) && (!empty($check_offset))){
            foreach($get_profile_id as $pk => $pv){
                $carry_forward_sales_data = DoctorOffset::where('doctor_id',$id)->where('profile_id',$pv)->where('carry_forward_date',$get_doctor_offset->carry_forward_date)->orderBy('id','DESC')->first();
                if(isset($carry_forward_sales_data->carry_forward) && ($carry_forward_sales_data->carry_forward != '')){
                    $carry_sales_data[] =  $carry_forward_sales_data->carry_forward;
                } else {
                    $carry_sales_data[] =  0;
                }
            }
        } else {
            $carry_sales_data[] = 0;
        }

        $eligible_sales_data = array();
        if(!empty($get_profile_id) && (!empty($check_offset))){
            foreach($get_profile_id as $pk => $pv){
                $eligible_sales_detail = DoctorOffset::where('doctor_id',$id)->where('profile_id',$pv)->where('eligible_amount_date',$get_doctor_offset->eligible_amount_date)->orderBy('id','DESC')->first();
                if(isset($eligible_sales_detail->eligible_amount) && ($eligible_sales_detail->eligible_amount != '')){
                    $eligible_sales_data[] =  $eligible_sales_detail->eligible_amount;
                } else {
                    $eligible_sales_data[] =  0;
                }
            }
        } else {
            $eligible_sales_data[] = 0;
        }

        //Set carry forward and eligibility date
        $previous_month_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
        //Set previous and second month date
        $previous_third_month_date = date('Y-m-d', strtotime('-2 month', strtotime($current_date)));
        $previous_second_month_date = date('Y-m-d', strtotime('-1 month', strtotime($current_date)));

        //Pass data blade file
        $current_date = date('d-m-Y');
        $actual_date = date('25-m-Y');

        if($current_date < $actual_date){
            
            ($previous_month_date != '') ? $last_month_heading = date('M y', strtotime($previous_month_date. ' 0 month')) : $last_month_heading = '';

            ($previous_second_month_date != '') ? $second_month_heading = date('M y', strtotime($previous_month_date. ' -1 month')) : $second_month_heading = '';
            
            ($previous_third_month_date != '') ? $third_month_heading = date('M y', strtotime($previous_second_month_date. ' -1 month')) : $third_month_heading = '';
            
        } else {
            
            ($previous_month_date != '') ? $last_month_heading = date('M y', strtotime($previous_month_date)) : $last_month_heading = ''; 

            ($previous_second_month_date != '') ? $second_month_heading = date('M y', strtotime($previous_second_month_date)) : $second_month_heading = ''; 

            ($previous_third_month_date != '') ? $third_month_heading = date('M y', strtotime($previous_third_month_date)) : $third_month_heading = ''; 
            
        }
        
        ($current_date != '') ? $target_sales_heading = date('M y', strtotime($current_date)) : $target_sales_heading = ''; 
        
        ($current_date != '') ? $carry_forward_heading = date('M y', strtotime($current_date)) : $carry_forward_heading = ''; 
        
        ($current_date != '') ? $eligible_heading = date('M y', strtotime($current_date)) : $eligible_heading = ''; 
        
        $get_profiles = DoctorProfile::with(['doctor_detail'])->where('doctor_id',$id)->where('is_delete',0)->get();
      
        return view('doctor.manage_profile.doctor_profile_list',compact('get_doctor','get_profiles','last_month_heading','last_month_sales','second_month_heading','previous_sales_data','third_month_heading','previous_third_sales_data','target_sales_heading','target_sales_data','carry_forward_heading','carry_sales_data','eligible_heading','eligible_sales_data'));
    }

    // Update doctor profile
    public function editDoctorProfile(Request $request){

        $doctor_details = DoctorDetail::where('id',$request->doctor_id)->first();

        if (isset($request->sender_id) && ($request->sender_id != '')) {
            $get_profile_detail = DoctorProfile::where('id',$request->sender_id)->first();
        } else {
            $get_profile_detail = array(); 
        }

        return view('doctor.manage_profile.update_doctor_profile',compact('doctor_details','get_profile_detail'));   
    }

    // Save doctor profile
    public function saveDoctorProfile(Request $request){

        $doctor_profile = new DoctorProfile;
        $doctor_profile->doctor_id = $request->doctor_id;
        $doctor_profile->profile_name = $request->profile_name;
        $doctor_profile->save();
    
        return redirect(route('admin.doctorManageProfile',$request->doctor_id))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Doctor',
                'message' => 'Doctor Profile Successfully Added',
            ],
        ]);
    }

    // Update doctor profile
    public function updateDoctorProfile(Request $request){

        $update_doctor_profile = DoctorProfile::findOrFail($request->id);
        $update_doctor_profile->profile_name = $request->profile_name;
        $update_doctor_profile->doctor_id = $request->doctor_id;
        $update_doctor_profile->save();

        return redirect(route('admin.doctorManageProfile',$request->doctor_id))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Doctor',
                'message' => 'Doctor Profile Successfully Updated',
            ],
        ]);
    }

    // Delete doctor profile
    public function deleteDoctorProfile($doctor_id,$id = 'null'){

        $delete_profile = DoctorProfile::where('id',$id)->update(['is_delete' => 1]);

        return redirect(route('admin.doctorManageProfile',$doctor_id))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Doctor',
                'message' => 'Doctor Profile Successfully Deleted',
            ],
        ]);
    }

    // Doctor commission calculation
    public function doctorCommision($doctor_id,$id){

        $doctor_details = DoctorProfile::with(['doctor_detail'])->where('id',$id)->where('doctor_id',$doctor_id)->first();

        $get_commission = DoctorCommission::where('profile_id',$id)->where('doctor_id',$doctor_id)->where('is_delete',0)->orderBy('created_at','DESC')->get();

        $get_last_id = DoctorCommission::orderBy('id','DESC')->where('is_delete',0)->first();
        
        return view('doctor.manage_profile.commission_calculation.commission_calculation_list',compact('doctor_details','doctor_id','id','get_commission'));      
    }

    // Save doctor commission
    public function saveDoctorCommision(Request $request){

        if($request->new_start_date == ''){

        } else {

            $get_last_id = DoctorCommission::orderBy('id','DESC')->where('doctor_id', $request->doctor_id)->where('is_delete',0)->first();


            if(!is_null($get_last_id) && $get_last_id->end_date == ''){

                $updateDoctoreCommisionEndDate = DoctorCommission::orderBy('id','DESC')->where('doctor_id', $request->doctor_id)->where('is_delete',0)->update(['end_date' => $this->convertDate($request->new_start_date)]);

            }

            $save_doctor_commission = new DoctorCommission;
            $save_doctor_commission->start_date = $this->convertDate($request->new_start_date);
            if(isset($request->new_end_date) && ($request->new_end_date != '')){
                $save_doctor_commission->end_date = $this->convertDate($request->new_end_date);    
            }
            
            $save_doctor_commission->doctor_id = $request->doctor_id;
            $save_doctor_commission->profile_id = $request->profile_id;
            $save_doctor_commission->commission = $request->new_commission;
            $save_doctor_commission->save();

            if(isset($get_last_id->end_date) && ($get_last_id->end_date == '')){
                
                $get_previuos_date = date('Y-m-d', strtotime('-1 day', strtotime($save_doctor_commission->start_date)));
                $update_last_id = DoctorCommission::where('id',$get_last_id->id)->update(['end_date' => $get_previuos_date]);
            }

            return redirect(route('admin.doctorCommision',[$request->doctor_id,$request->profile_id]))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Doctor',
                    'message' => 'Doctor Commission Successfully Added',
                ],
            ]);
        }
    }

    // Update doctor commission
    public function updateDoctorCommision(Request $request){

        $save_doctor_commission = DoctorCommission::findOrFail($request->id);
        $save_doctor_commission->start_date = $this->convertDate($request->start_date);
        if(isset($request->end_date) && ($request->end_date != '')){
            $save_doctor_commission->end_date = $this->convertDate($request->end_date);    
        } else {
            $save_doctor_commission->end_date = "";
        }
        $save_doctor_commission->doctor_id = $request->doctor_id;
        $save_doctor_commission->profile_id = $request->profile_id;
        $save_doctor_commission->commission = $request->commission;
        $save_doctor_commission->save();

        return $save_doctor_commission ? 'true' : 'false';
    }

    // Remove doctor commission
    public function deleteDoctorCommission($doctor_id,$profile_id,$id){

        $delete_profile = DoctorCommission::where('id',$id)->update(['is_delete' => 1]);

        return redirect(route('admin.doctorCommision',[$doctor_id,$profile_id]))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Doctor',
                'message' => 'Doctor Commission Successfully Deleted',
            ],
        ]);

    }

    // Check commission between range
    public function checkCommissionDate(Request $request){

        $date = $this->convertDate($request->date);   
        if(isset($request->id)){
            
            $check_date = DoctorCommission::whereRaw('? between start_date and end_date', [$date])->where('id','!=',$request->id)->where('is_delete',0)->first();
        } else {

            $check_date = DoctorCommission::whereRaw('? between start_date and end_date', [$date])->where('is_delete',0)->first();    
        }

        return (!empty($check_date) ? 'false' : 'true'); 

    }

    // Check doctor profile exists
    public function checkDoctorProfile(Request $request){

        $query = DoctorProfile::query();
        $query->where('profile_name',$request->profile_name);
        if (isset($request->id)){
            $query->where('doctor_id', $request->id);
        }
        $query->where('is_delete',0);
        $admin = $query->count();

        return $admin == 0 ? 'true' : 'false';
    }

    // Doctor profile wise payment
    public function doctorRequestList($doctor_id = NULL,$id = NULL,Request $request){

        $filter = 0;
        $request_date = '';
        $received_on = '';
        $payment_on = '';
        $status = '';

        $query = AllRequest::query();

        if(isset($request->request_date) && $request->request_date != ''){

            $filter = 1;
            $request_date = $request->request_date;
            $date = $this->convertDate($request->request_date);
            $query->where('request_date',$date);
        }

        if(isset($request->received_on) && $request->received_on != ''){
        
            $filter = 1;
            $received_on = $request->received_on;
            $received_date = $this->convertDate($request->received_on);
            $query->where('received_on',$received_date);
        }

        if(isset($request->payment_on) && $request->payment_on != ''){
        
            $filter = 1;
            $payment_on = $request->payment_on;
            $pay_on = $this->convertDate($request->payment_on);
            $query->where('payment_on',$pay_on);
        }

        if(isset($request->status) && $request->status != ''){
            
            $filter = 1;
            $status = $request->status;
            $query->where('status',$request->status);
        }

        $query->with(['doctor_detail','profile_detail'])->where('doctor_id',$doctor_id)->where('profile_id',$id);
        $doctor_payment = $query->orderBy('updated_at','DESC')->get();

        $get_doctor_offset = DoctorOffset::where('profile_id',$id)->where('doctor_id',$doctor_id)->orderBy('id','DESC')->first();
        
        $current_date = date('d-m-Y');
        $previous_month_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
        //Set previous and second month date
        $previous_third_month_date = date('Y-m-d', strtotime('-2 month', strtotime($current_date)));
        $previous_second_month_date = date('Y-m-d', strtotime('-1 month', strtotime($current_date)));

        //Pass data blade file
        $actual_date = date('25-m-Y');
        if($current_date < $actual_date){
            
            ($previous_month_date != '') ? $last_month_heading = date('M y', strtotime($previous_month_date. ' 0 month')) : $last_month_heading = ''; 

            ($previous_second_month_date != '') ? $second_month_heading = date('M y', strtotime($previous_month_date. ' -1 month')) : $second_month_heading = '';  
            
            ($previous_third_month_date != '') ? $third_month_heading = date('M y', strtotime($previous_second_month_date. ' -1 month')) : $third_month_heading = '';  
            
        } else {
            
            ($previous_month_date != '') ? $last_month_heading = date('M y', strtotime($previous_month_date)) : $last_month_heading = ''; 

            ($previous_second_month_date != '') ? $second_month_heading = date('M y', strtotime($previous_second_month_date)) : $second_month_heading = ''; 

            ($previous_third_month_date != '') ? $third_month_heading = date('M y', strtotime($previous_third_month_date)) : $third_month_heading = ''; 
            
        }

        (!empty($get_doctor_offset) ? $last_month_sales = $get_doctor_offset->last_month_sales : $last_month_sales = 0); 

        (!empty($get_doctor_offset)) ? $second_month_sales = $get_doctor_offset->previous_second_month_sales : $second_month_sales = 0; 

        (!empty($get_doctor_offset)) ? $third_month_sales = $get_doctor_offset->previous_third_month_sales : $third_month_sales = 0; 

        (!empty($get_doctor_offset)) ? $target_sales_heading = date('M y', strtotime($get_doctor_offset->target_previous_month_date)) : $target_sales_heading = ''; 
        (!empty($get_doctor_offset)) ? $target_sales = $get_doctor_offset->target_previous_month: $target_sales = 0; 

        (!empty($get_doctor_offset)) ? $carry_forward_heading = date('M y', strtotime($get_doctor_offset->carry_forward_date)) : $carry_forward_heading = ''; 
        (!empty($get_doctor_offset)) ? $carry_forward_sales = $get_doctor_offset->carry_forward : $carry_forward_sales = 0; 

        (!empty($get_doctor_offset)) ? $eligible_heading = date('M y', strtotime($get_doctor_offset->carry_forward_date)) : $eligible_heading = ''; 
        (!empty($get_doctor_offset)) ? $eligible_sales = $get_doctor_offset->eligible_amount : $eligible_sales = 0; 

        return view('doctor.manage_profile.payment_request.payment_request_list',compact('doctor_payment','doctor_id','id','filter','request_date','received_on','payment_on','status','last_month_heading','last_month_sales','second_month_heading','second_month_sales','third_month_heading','third_month_sales','target_sales_heading','target_sales','carry_forward_heading','carry_forward_sales','eligible_heading','eligible_sales'));
    }

    // Update request Payment generated
    public function updateRequestPaymentGenrated(Request $request){

        // Get doctor request data
        $requestData = AllRequest::where('id', $request->id)->first();

        // Get doctor offset value
        $doctorOffsetValue = DoctorOffset::where('profile_id', $requestData->profile_id)->where('doctor_id', $requestData->doctor_id)->orderBy('id', 'DESC')->first();

        //$doctorEligibleAmount = DoctorOffset::where('profile_id', $requestData->profile_id)->where('doctor_id', $requestData->doctor_id)->sum('eligible_amount');
        //$doctorTargetAmount = DoctorOffset::where('profile_id', $requestData->profile_id)->where('doctor_id', $requestData->doctor_id)->sum('target_previous_month');
        //$doctorCarryForwardAmount = DoctorOffset::where('profile_id', $requestData->profile_id)->where('doctor_id', $requestData->doctor_id)->sum('carry_forward');

        // Get doctor wise commission persentage
        $doctorCommision = DoctorCommission::where('doctor_id', $requestData->doctor_id)->first();

        // New eligibility, target & carry forward sales calculation
        $newEligibility = $doctorOffsetValue->eligible_amount - $requestData->request_amount;
        $target = $doctorOffsetValue->target_previous_month + $requestData->request_amount * 100 / $doctorCommision->commission;
        $carryForwardSales = $doctorOffsetValue->carry_forward - $requestData->request_amount * 100 / $doctorCommision->commission; 

        // Old eligibility, target & carry forward sales calculation
        $oldEligibility = $doctorOffsetValue->eligible_amount + $requestData->request_amount;
        $oldTarget = $doctorOffsetValue->target_previous_month - $requestData->request_amount * 100 / $doctorCommision->commission;
        $oldCarryForwardSales = $doctorOffsetValue->carry_forward + $requestData->request_amount * 100 / $doctorCommision->commission; 

        // Current date
        $current_date = date("Y-m-d");

        if($request->status == 0 && $requestData->status == 2){
            
            // Rejected clear all data    
            $updateGenratedPayment = AllRequest::where('id',$request->id)->update(['status' => $request->status,'status_updated_on' => $current_date,'is_payment_genrated' => 0,'payment_on' => NULL,'received_by_mr' => 0,'received_on' => NULL,'is_paid_to_doctor' => 0,'paid_on' => NULL]);
            
            // Update doctor offset value
            $updateDoctorOffsetValue = DoctorOffset::where('profile_id', $requestData->profile_id)
                                                    ->where('doctor_id', $requestData->doctor_id)
                                                    ->update([
                                                        'carry_forward' => $oldCarryForwardSales, 
                                                        'eligible_amount' => $oldEligibility, 
                                                        'target_previous_month' => $oldTarget
                                                    ]);

        } else if($request->status == 1 && $requestData->status == 2){
            
            // Rejected clear all data    
            $updateGenratedPayment = AllRequest::where('id',$request->id)->update(['status' => $request->status,'status_updated_on' => $current_date,'is_payment_genrated' => 0,'payment_on' => NULL,'received_by_mr' => 0,'received_on' => NULL,'is_paid_to_doctor' => 0,'paid_on' => NULL]);
                
            // Update doctor offset value
            $updateDoctorOffsetValue = DoctorOffset::where('profile_id', $requestData->profile_id)
                                                    ->where('doctor_id', $requestData->doctor_id)
                                                    ->update([
                                                        'carry_forward' => $oldCarryForwardSales, 
                                                        'eligible_amount' => $oldEligibility, 
                                                        'target_previous_month' => $oldTarget
                                                    ]);

        } else if($request->status == 1){

            // Rejected clear all data    
            $updateGenratedPayment = AllRequest::where('id',$request->id)->update(['status' => $request->status,'status_updated_on' => $current_date,'is_payment_genrated' => 0,'payment_on' => NULL,'received_by_mr' => 0,'received_on' => NULL,'is_paid_to_doctor' => 0,'paid_on' => NULL]);

        } else if($request->status == 2){

            // Update generated payment 
            $updateGenratedPayment = AllRequest::where('id',$request->id)->update(['status' => $request->status,'status_updated_on' => $current_date]);

            // Update doctor offset value
            $updateDoctorOffsetValue = DoctorOffset::where('profile_id', $requestData->profile_id)
                                                    ->where('doctor_id', $requestData->doctor_id)
                                                    ->update([
                                                        'carry_forward' => $carryForwardSales, 
                                                        'eligible_amount' => $newEligibility, 
                                                        'target_previous_month' => $target
                                                    ]);

        } else {

            // Rejected clear all data    
            $updateGenratedPayment = AllRequest::where('id',$request->id)->update(['status' => $request->status,'status_updated_on' => $current_date,'is_payment_genrated' => 0,'payment_on' => NULL,'received_by_mr' => 0,'received_on' => NULL,'is_paid_to_doctor' => 0,'paid_on' => NULL]);
        }

        return $updateGenratedPayment ? 'true' : 'false';
    }

    // Update payment recived to mr
    public function updateRequestReceivedMr(Request $request){

       /* $current_date = date("Y-m-d");

        $updateReceivedMr = AllRequest::where('id',$request->id)->update(['received_by_mr' => $request->received_by_mr,'received_on' => $current_date]);*/

        if($request->received_by_mr == 0){
            $current_date = NULL;
            $updateReceivedMr = AllRequest::where('id',$request->id)->update(['received_by_mr' => 0,'received_on' => $current_date,'is_paid_to_doctor' => 0,'paid_on' => NULL]);
        } else {
            $current_date = date("Y-m-d");    
            $updateReceivedMr = AllRequest::where('id',$request->id)->update(['received_by_mr' => $request->received_by_mr,'received_on' => $current_date]);
        }

        return $updateReceivedMr ? 'true' : 'false';

    }

    // Update paid to doctor
    public function updateDoctorPaidDoctor(Request $request){

        if($request->paid_to_doctor == 0){
            $current_date = NULL;
            $payment_genrated = 0;
            $received_by_mr = 0;
        } else {
            $payment_genrated = 1;
            $received_by_mr = 1;
            $current_date = date("Y-m-d");    
        }
        
        $get_data = AllRequest::where('id',$request->id)->first();

        if(!empty($get_data) && ($get_data->payment_on == '')){
            $payment_on = $current_date;
        } else {
            $payment_on = $get_data->payment_on;
        }

        if(!empty($get_data) && ($get_data->received_on == '')){
            $received_on = $current_date;
        } else {
            $received_on = $get_data->payment_on;
        }

        $updatePaidDoctor = AllRequest::where('id',$request->id)->update(['is_paid_to_doctor' => $request->paid_to_doctor,'payment_on' => $payment_on,'received_on' => $received_on,'paid_on' => $current_date,'is_payment_genrated' => $payment_genrated,'received_by_mr' => $received_by_mr]);

        return $updatePaidDoctor ? 'true' : 'false';

    }

    // Doctor profile wise sales
    public function doctorSalesList($doctor_id = NULL,$id = NULL){

        $sales_data = MedicalStoreDoctorData::with(['doctor_detail','profile_detail'])->where('doctor_id',$doctor_id)->where('doctor_profile',$id)->orderBy('sales_month','DESC')->get();
        
        $monthly = array();
        $months = array();
        $month = '';
        if(!empty($sales_data)){
            foreach($sales_data as $sk => $sv){
                if(!in_array($sv->sales_month,$months)){
                    $months[] = $sv->sales_month;
                    $get_sales_data = MedicalStoreDoctorData::where('doctor_id',$doctor_id)->where('doctor_profile',$id)->where('sales_month',$sv->sales_month)->sum('sales_amount');
                    $month = $sv->sales_month;
                    $monthly[$sk]['month'] = $month;
                    $monthly[$sk]['sales'] = $get_sales_data;
                }
            }
        }
        
        return view('doctor.manage_profile.sales_data.sales_list',compact('sales_data','doctor_id','id','monthly','doctor_id','id'));
    }

    // Doctor medical store wise sales
    public function doctorMedicalstoreWiseSales($doctor_id = NULL,$id = NULL,$month = NULL,$year = NULL){

        $sales_month = $month.'-'.$year;
        $sales_data = MedicalStoreDoctorData::with(['doctor_detail','profile_detail','store_detail' => function($q){ $q->with(['store_detail']); }])->where('doctor_id',$doctor_id)->where('doctor_profile',$id)->whereRaw('extract(month from sales_month) = ?', [$month])->whereRaw('extract(year from sales_month) = ?', [$year])->get();

        return view('doctor.manage_profile.sales_data.medical_store_wise_sales',compact('sales_data'));
    }

    // Update doctor sales amount
    public function saveDoctorSalesAmount(Request $request){

         if($request->amount != ''){
            $priority = 1;
        } else {
            $priority = 0;
        }

        $updateAmount = MedicalStoreDoctorData::where('id',$request->id)->update(['sales_amount' => $request->amount,'priority' => $priority]);

        return $updateAmount ? 'true' : 'false';
    }

    // Remove doctor data
    public function removeDoctorData($id,$doctor_id,$profile_id){
        
        $updateEntry = MedicalStoreDoctorData::where('id',$id)->update(['sales_amount' => NULL,'priority' => 0]);

        return redirect(route('admin.doctorSalesList',[$doctor_id,$profile_id]))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Entry',
                'message' => 'Entry Successfully Cleared',
            ],
        ]);

    }

    // Doctor offset data
    public function doctorOffset($doctor_id,$id){
        
        $doctor_details = DoctorProfile::with(['doctor_detail'])->where('id',$id)->where('doctor_id',$doctor_id)->first();
        
        $current_date = date('Y-m-d');
        $check_date = date('Y-m-d');

        if($current_date < $check_date){
            
            $previous_third_month = date('Y-m-d', strtotime('-3 month', strtotime($current_date)));
            $previous_second_month = date('Y-m-d', strtotime('-2 month', strtotime($current_date)));
            $previous_month = date('Y-m-d', strtotime('-1 month', strtotime($current_date)));
            $current_month = $check_date;

        } else {

            $previous_third_month = date('Y-m-d', strtotime('-2 month', strtotime($check_date)));
            $previous_second_month = date('Y-m-d', strtotime('-1 month', strtotime($check_date)));
            $previous_month = $check_date;
            $current_month = date('Y-m-d', strtotime('+1 month', strtotime($check_date)));

            $month = date('m');
            $year = date('Y');
            $get_offset_sales = DoctorOffset::where('doctor_id',$doctor_id)->where('profile_id',$id)->whereRaw('extract(month from last_month_date) = ?', [$month])->whereRaw('extract(year from last_month_date) = ?', [$year])->where('is_manual',1)->orderBy('id','DESC')->first();

        }

        return view('doctor.manage_profile.add_offset.add_offset',compact('doctor_details','doctor_id','id','previous_third_month','previous_second_month','previous_month','current_month','get_offset_sales'));
    }

    // Save doctor offset details
    public function saveDoctorOffset(Request $request){

        $save_offset = new DoctorOffset;
        $save_offset->last_month_sales = $request->last_month_sales;
        $save_offset->last_month_date = $request->last_month_date;
        $save_offset->previous_second_month_sales = $request->previous_second_month_sales;
        $save_offset->previous_second_month_date = $request->previous_second_month_date;
        $save_offset->previous_third_month_sales = $request->previous_third_month_sales;
        $save_offset->previous_third_month_date = $request->previous_third_month_date;
        $save_offset->target_previous_month = $request->target_previous_month;
        $save_offset->target_previous_month_date = $request->target_previous_month_date;
        $save_offset->carry_forward = $request->carry_forward;
        $save_offset->carry_forward_date = $request->carry_forward_date;
        $save_offset->eligible_amount = $request->eligible_amount;
        $save_offset->eligible_amount_date = $request->eligible_amount_date;
        $save_offset->profile_id = $request->profile_id;
        $save_offset->doctor_id = $request->doctor_id;
        $save_offset->is_manual = 1;
        $save_offset->save();
    
        return redirect(route('admin.doctorManageProfile',[$request->doctor_id]))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Doctor',
                'message' => 'Doctor Offset Successfully Save',
            ],
        ]);

    }
}
