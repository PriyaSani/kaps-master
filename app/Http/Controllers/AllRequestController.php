<?php

namespace App\Http\Controllers;

use Auth;
use App\Model\MrDetail;
use App\Model\Territory;
use App\Model\AllRequest;
use App\Model\SubTerritory;
use App\Model\DoctorOffset;
use App\Model\DoctorDetail;
use Illuminate\Http\Request;
use App\Model\MedicalStoreDoctorData;
use App\Http\Controllers\GlobalController;

class AllRequestController extends GlobalController
{
   	public function __construct(){
       $this->middleware('auth');
       $this->middleware('checkpermission');
    }

    // All request list
    public function allRequestList(Request $request){

        $filter = 0;
        $request_date = '';
        $doctor_name = '';
        $doctor_id = '';
        $mr_name = '';
        $mr_id = '';
        $territory = '';
        $territorry_id = '';
        $sub_territory = '';
        $status = '';
        $received_status = '';
        $paid_to_doctor = '';
        $payment_on = '';
        $received_on = '';

        
        $query = AllRequest::query();

        if(isset($request->request_date) && $request->request_date != ''){
            
            $filter = 1;
            $request_date = $request->request_date;
            $date = $this->convertDate($request->request_date);
            $query->where('request_date',$date);

        }

        if(isset($request->doctor_id) && $request->doctor_id != ''){

            $filter = 1;
            $doctor_name = $request->doctor_name;
            $doctor_id = $request->doctor_id;
            $query->where('doctor_id',$request->doctor_id);

        }

        if(isset($request->mr_id) && $request->mr_id != ''){
            
            $filter = 1;
            $mr_name = $request->mr_name;
            $mr_id = $request->mr_id;
            $query->where('submitted_by',$request->mr_id);

        }

        if(isset($request->territorry_id) && $request->territorry_id != ''){
            
            $filter = 1;
            $territory = $request->territorry;
            $territorry_id = $request->territorry_id;

            $query->whereHas('main_territory_detail', function ($query) use ($territorry_id) { $query->where('territory_id',$territorry_id); });

            $get_sub_territory = SubTerritory::where('territory_id',$request->territorry_id)->where('is_delete',0)->get();

        } else {
            $get_sub_territory = array();
        }

        if(isset($request->sub_territory) && $request->sub_territory != ''){
            
            $filter = 1;
            $sub_territory = $request->sub_territory;

            $query->whereHas('sub_territory_detail', function ($query) use ($sub_territory) { $query->where('sub_territory_id',$sub_territory); });

        }

        if(isset($request->status) && $request->status != ''){
            
            $filter = 1;
            $status = $request->status;
            $query->where('status',$request->status);

        }

        if(isset($request->received_status) && $request->received_status != ''){
            
            $filter = 1;
            $received_status = $request->received_status;

            $query->where('received_by_mr',$request->received_status);

        }

        if(isset($request->paid_to_doctor) && $request->paid_to_doctor != ''){
        
            $filter = 1;
            $paid_to_doctor = $request->paid_to_doctor;
            $query->where('is_paid_to_doctor',$paid_to_doctor);

        }

        if(isset($request->payment_on) && $request->payment_on != ''){
        
            $filter = 1;
            $payment_on = $request->payment_on;
            $pay_on = $this->convertDate($request->payment_on);
            $query->where('payment_on',$pay_on);

        }

        if(isset($request->received_on) && $request->received_on != ''){
        
            $filter = 1;
            $received_on = $request->received_on;
            $received_date = $this->convertDate($request->received_on);
            $query->where('received_on',$received_date);

        }

        $query->with(['doctor_detail','profile_detail','main_territory_detail','sub_territory_detail','mr_detail','main_territory_detail' => function($q){ $q->with(['territory_name']); },'sub_territory_detail' => function($q){ $q->with(['sub_territory_name']); }]);
        $get_all_request = $query->orderBy('id','DESC')->get();
        if(Auth::guard()->user()->id != 1){
            $get_user_territory = array_unique($this->userTerritory(Auth::guard()->user()->id));
            $get_user_sub_territory = array_unique($this->userSubTerritory(Auth::guard()->user()->id));

            $get_all_request = $query->orderBy('id','DESC')->whereHas('main_territory_detail', function ($query) use ($get_user_territory) { $query->whereIn('territory_id', $get_user_territory); })->WhereHas('sub_territory_detail', function ($query) use ($get_user_sub_territory) { $query->whereIn('sub_territory_id',$get_user_sub_territory); })->get();
        }
    	return view('all_request.requested_list',compact('get_all_request','request_date','doctor_name','doctor_id','mr_name','mr_id','territory','territorry_id','sub_territory','status','received_status','paid_to_doctor','payment_on','received_on','filter','get_sub_territory'));
    }

    // Updated Payment genrated
    public function updatePaymentGenrated(Request $request){

        if($request->payment_genrated == 0){
            $current_date = NULL;
            $updateGenratedPayment = AllRequest::where('id',$request->id)->update(['is_payment_genrated' => $request->payment_genrated,'payment_on' => $current_date,'received_by_mr' => 0,'received_on' => NULL,'is_paid_to_doctor' => 0,'paid_on' => NULL]);
        } else {
            $current_date = date("Y-m-d");    
            $updateGenratedPayment = AllRequest::where('id',$request->id)->update(['is_payment_genrated' => $request->payment_genrated,'payment_on' => $current_date]);
        }
        

        return $updateGenratedPayment ? 'true' : 'false';
    }

    // Update payment recived to mr
    public function updateReceivedMr(Request $request){

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
    public function updatePaidDoctor(Request $request){

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

    // Check doctor request reason
    public function viewDoctorRequest($id){

        $get_doctor_details = AllRequest::with(['doctor_detail','mr_detail'])->where('id',$id)->first();

        $get_doctor_offset = DoctorOffset::where('profile_id',$get_doctor_details->profile_id)->where('doctor_id',$get_doctor_details->doctor_id)->orderBy('id','DESC')->first();

        $current_date = date('d-m-Y');
        //Set carry forward and eligibility date
        $previous_month_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
        //Set previous and second month date
        $previous_third_month_date = date('Y-m-d', strtotime('-2 month', strtotime($current_date)));
        $previous_second_month_date = date('Y-m-d', strtotime('-1 month', strtotime($current_date)));
        
        //Pass data blade file
        $actual_date = date('25-m-Y');

        if($current_date < $actual_date){
    
            ($previous_month_date != '') ? $last_month_heading = date('M y', strtotime($previous_month_date. ' -1 month')) : $last_month_heading = ''; 
        
            ($previous_second_month_date != '') ? $second_month_heading = date('M y', strtotime($previous_second_month_date. ' -2 month')) : $second_month_heading = '';  
            
            ($previous_third_month_date != '') ? $third_month_heading = date('M y', strtotime($previous_third_month_date. ' -3 month')) : $third_month_heading = '';  
            
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


        return view('all_request.view_doctor_request',compact('get_doctor_details','last_month_heading','last_month_sales','second_month_heading','second_month_sales','third_month_heading','third_month_sales','target_sales_heading','target_sales','carry_forward_heading','carry_forward_sales','eligible_heading','eligible_sales'));
    }

    // Update payment status
    public function updateStatusPayment(Request $request){

        $current_date = date("Y-m-d");

        if($request->status == 1){
            //Rejected clear all data    
            $updateStaus = AllRequest::where('id',$request->id)->update(['status' => $request->status,'status_updated_on' => $current_date,'is_payment_genrated' => 0,'payment_on' => NULL,'received_by_mr' => 0,'received_on' => NULL,'is_paid_to_doctor' => 0,'paid_on' => NULL]);

            $doctor_details = AllRequest::with(['commission'])->where('id',$request->id)->first();

            $get_doctor_offset = DoctorOffset::where('profile_id',$doctor_details->profile_id)->where('doctor_id',$doctor_details->doctor_id)->orderBy('id','DESC')->first();

            $save_offset = new DoctorOffset;
            $save_offset->last_month_sales = $get_doctor_offset->last_month_sales;
            $save_offset->last_month_date = $get_doctor_offset->last_month_date;
            $save_offset->previous_second_month_sales = $get_doctor_offset->previous_second_month_sales;
            $save_offset->previous_second_month_date = $get_doctor_offset->previous_second_month_date;
            $save_offset->previous_third_month_sales = $get_doctor_offset->previous_third_month_sales;
            $save_offset->previous_third_month_date = $get_doctor_offset->previous_third_month_date;
            $save_offset->target_previous_month = $get_doctor_offset->target_previous_month;
            $save_offset->target_previous_month_date = $get_doctor_offset->target_previous_month_date;
            $save_offset->carry_forward = $get_doctor_offset->carry_forward;
            $save_offset->carry_forward_date = $get_doctor_offset->carry_forward_date;
            $save_offset->eligible_amount = $get_doctor_offset->eligible_amount;
            $save_offset->eligible_amount_date = $get_doctor_offset->eligible_amount_date;
            $save_offset->profile_id = $get_doctor_offset->profile_id;
            $save_offset->doctor_id = $get_doctor_offset->doctor_id;
            $save_offset->save();

        } else {
            

            $doctor_details = AllRequest::with(['commission'])->where('id',$request->id)->first();
            
            $time = strtotime($doctor_details->request_date);
            $month = date("m",$time);
            $year = date("Y",$time);
       
            $get_doctor_offset = DoctorOffset::where('profile_id',$doctor_details->profile_id)->where('doctor_id',$doctor_details->doctor_id)->orderBy('id','DESC')->with(['commission'])->first();

            $get_carry_forward = DoctorOffset::where('profile_id',$doctor_details->profile_id)->where('doctor_id',$doctor_details->doctor_id)->orderBy('id','DESC')->with(['commission'])->first();

            $get_sales = MedicalStoreDoctorData::where('doctor_id',$doctor_details->doctor_id)->where('doctor_profile',$doctor_details->profile_id)->whereMonth('sales_month',$month)->sum('sales_amount');
            
            if(!empty($get_doctor_offset)){
                
                if (!is_null($get_doctor_offset['commission'])) {
                    
                    $updateStaus = AllRequest::where('id',$request->id)->update(['status' => $request->status,'status_updated_on' => $current_date]);
                    
                    //Net sales 
                    $net_sales = $get_doctor_offset->carry_forward;
                    
                    //eligibility        
                    // $eligibility = $net_sales * $get_doctor_offset['commission']['commission']/100;
                   
                    //Next target
                    $doctor_details->request_amount;
                    
                    $get_doctor_offset['commission']['commission'];
                    
                    $target = $doctor_details->request_amount * 100 / $get_doctor_offset['commission']['commission'];
                    
                    $update_amount = AllRequest::where('id',$request->id)->where('is_considered_by_request',0)->where('status',2)->update(['is_considered_by_request' => 1]);

                    //New eligibility
                    $new_eligibility = $get_doctor_offset->eligible_amount - $doctor_details->request_amount;
                    
                    // $carry_forward = $new_eligibility * $get_doctor_offset['commission']['commission'];
                    $carry_forward = $get_doctor_offset->carry_forward - $target;
                    
                    // $save_offset = DoctorOffset::findOrFail($get_doctor_offset->id);
                    $save_offset = new DoctorOffset;
                    if(isset($get_carry_forward->last_month_sales) && $get_carry_forward->last_month_sales != ''){
                        $save_offset->last_month_sales = $get_carry_forward->last_month_sales;
                    } else {
                        $save_offset->last_month_sales = 0;
                    }

                    //Set carry forward and eligibility date
                    $previous_month_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));

                    $save_offset->last_month_date = $previous_month_date;
                    if(isset($get_carry_forward->previous_second_month_sales) && $get_carry_forward->previous_second_month_sales != ''){
                        $save_offset->previous_second_month_sales = $get_carry_forward->previous_second_month_sales;
                    } else {
                        $save_offset->previous_second_month_sales = 0;
                    }

                    //Set previous and second month date
                    $previous_third_month_date = date('Y-m-d', strtotime('-2 month', strtotime($current_date)));
                    $previous_second_month_date = date('Y-m-d', strtotime('-1 month', strtotime($current_date)));

                    $save_offset->previous_second_month_date = $previous_second_month_date;
                    if(isset($get_carry_forward->previous_third_month_sales) && $get_carry_forward->previous_third_month_sales != ''){
                        $save_offset->previous_third_month_sales = $get_carry_forward->previous_third_month_sales;
                    } else {
                        $save_offset->previous_third_month_sales = 0;
                    }
                    $save_offset->previous_third_month_date = $previous_third_month_date;
                    $save_offset->target_previous_month = $target;
                    $save_offset->target_previous_month_date = $current_date;
                    $save_offset->carry_forward = $carry_forward;
                    $save_offset->carry_forward_date = $current_date;
                    $save_offset->eligible_amount = $new_eligibility;
                    $save_offset->eligible_amount_date = $current_date;
                    $save_offset->profile_id = $doctor_details->profile_id;
                    $save_offset->doctor_id = $doctor_details->doctor_id;
                    $save_offset->save();
                } else {
                    return redirect(route('admin.allRequestList'))->with('messages', [
                        [
                            'type' => 'error',
                            'title' => 'Doctor Commission',
                            'message' => 'Please update doctor commission first',
                        ],
                    ]);
                }

            } else {
                
                //Net sales 
                if(isset($get_carry_forward->carry_forward)){
                    $net_sales = $get_carry_forward->carry_forward + $get_sales;
                } else {
                    $net_sales = $get_sales;
                }
                
                //Eligibility        
                $eligibility = $net_sales * $doctor_details['commission']['commission']/100;
                
                $target = $doctor_details->request_amount * $doctor_details['commission']['commission'];
                
                $update_amount = AllRequest::where('id',$request->id)->where('is_considered_by_request',0)->where('status',2)->update(['is_considered_by_request' => 1]);

                //New eligibility
                $new_eligibility = $eligibility - $doctor_details->request_amount;
                
                $carry_forward = $new_eligibility * $doctor_details['commission']['commission'];
                
                $save_offset = new DoctorOffset;
                if(isset($get_carry_forward->last_month_sales) && $get_carry_forward->last_month_sales != ''){
                    $save_offset->last_month_sales = $get_carry_forward->last_month_sales;
                } else {
                    $save_offset->last_month_sales = 0;
                }

                //Set carry forward and eligibility date
                $previous_month_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));

                $save_offset->last_month_date = $previous_month_date;
                if(isset($get_carry_forward->previous_second_month_sales) && $get_carry_forward->previous_second_month_sales != ''){
                    $save_offset->previous_second_month_sales = $get_carry_forward->previous_second_month_sales;
                } else {
                    $save_offset->previous_second_month_sales = 0;
                }

                //Set previous and second month date
                $previous_third_month_date = date('Y-m-d', strtotime('-2 month', strtotime($current_date)));
                $previous_second_month_date = date('Y-m-d', strtotime('-1 month', strtotime($current_date)));

                $save_offset->previous_second_month_date = $previous_second_month_date;
                if(isset($get_carry_forward->previous_third_month_sales) && $get_carry_forward->previous_third_month_sales != ''){
                    $save_offset->previous_third_month_sales = $get_carry_forward->previous_third_month_sales;
                } else {
                    $save_offset->previous_third_month_sales = 0;
                }
                $save_offset->previous_third_month_date = $previous_third_month_date;
                $save_offset->target_previous_month = $target;
                $save_offset->target_previous_month_date = $current_date;
                $save_offset->carry_forward = $carry_forward;
                $save_offset->carry_forward_date = $current_date;
                $save_offset->eligible_amount = $new_eligibility;
                $save_offset->eligible_amount_date = $current_date;
                $save_offset->profile_id = $doctor_details->profile_id;
                $save_offset->doctor_id = $doctor_details->doctor_id;
                $save_offset->save();

            }

        }
        
        return redirect(route('admin.allRequestList'))->with('messages', [
            [
              'type' => 'success',
              'title' => 'Status',
              'message' => 'Request Staus Successfully Updated',
            ],
        ]); 
    }
}
