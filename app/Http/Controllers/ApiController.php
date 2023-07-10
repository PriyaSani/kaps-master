<?php

namespace App\Http\Controllers;

use Str;
use URL;
use Auth;
use File;
use Hash;
use Mail;
use Request;
use Response;
use DateTime;
use App\Model\XApi;
use App\Model\MrDetail;
use App\Model\Stockiest;
use App\Model\UserToken;
use App\Model\AppVersion;
use App\Model\AllRequest;
use App\Model\MrTerritory;
use App\Model\MedicalStore;
use App\Model\DoctorDetail;
use App\Model\SalesHistory;
use App\Model\DoctorProfile;
use App\Model\DoctorOffset;
use App\Model\StockiestStatement;
use App\Model\StockiestTerritory;
use App\Model\MrWiseStockiestData;
use App\Model\DoctorCommission;
use App\Model\MedicalStoreDoctorData;
use App\Model\DoctorRequestTerritorry;
use App\Model\StockiestWiseMedicalStoreData;
use App\Model\MedicalStoreTerritory;
use App\Model\DoctorTerritory;

class ApiController extends GlobalController
{
    public function __construct(){
        
        $headers = apache_request_headers();
        //check X-API
        if (isset($headers['x-api-key']) && $headers['x-api-key'] != '') {
            if (isset($headers['device-type']) && $headers['device-type'] != '') {
               if(!XApi::checkXAPI($headers['x-api-key'],$headers['device-type'])){
                   echo json_encode(array('status'=>500,'message'=>'Invalid X-API'));exit;
               }
            } else {
               echo json_encode(array('status'=>500,'message'=>'Device type not found'));exit;
            }
        } else {
          echo json_encode(array('status'=>500,'message'=>'X-API key not found'));exit; 
        }

        //check version
        if (isset($headers['device-token']) && isset($headers['version'])) {
            $updateVersion = UserToken::where('Device_Token',$headers['device-token'])->update(['Version' => $headers['version']]);
        }

        if (isset($headers['device-type']) && isset($headers['version'])) {
            $getUserAppVersion = AppVersion::where('platform',$headers['device-type'])->where('version',$headers['version'])->first();
            if (!empty($getUserAppVersion->expireddate)) {
                if ($getUserAppVersion->expireddate < date('Y-m-d H:i:s')) {
                    //CHECK IF THE USER VERSION IS EXPIRED OR NOT
                    $res['status'] = 700;
                    $res['message'] = "App Version Expired";
                    echo json_encode($res);
                    exit;
                } 
            } 
        }  
    }   

    // Check data null to blank
    public function nulltoblank($data) {
        return !$data ? $data = "" : $data;
    }

    //GENERATE DEVICE TOKEN
    public function generateDeviceToken(){
        
        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();
        
        if (!isset($headers['device-type']) && $headers['device-type'])
            $errors_array['device-type'] = 'Please pass device type';

        if(count($errors_array) == 0){
            $user = new MrDetail;
            $token = $user->generateToken($headers);
            $response['device_token'] = $token;

            $data = $response;
            $message = '';
            return $this->responseSuccess($message,$data);

        } else {

            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);
        }
    }

    //Custom login api
    public function mrLogin(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!Request::has('email') || Request::get('email') == "")
            $errors_array['email'] = 'Please pass email id';

        if (!Request::has('password') || Request::get('password') == "")
            $errors_array['password'] = 'Please pass password';

        if(count($errors_array) == 0){
            $data = Request::all();

            $mr_data = array();

            //check member
            $mr_detail = MrDetail::where('email',$data['email'])->where('is_active', 1)->where('is_delete', 0)->first();

            if(!empty($mr_detail)){
                if(Hash::check($data['password'], $mr_detail->password)){

                        $update_member = MrDetail::findOrFail($mr_detail->id);
                        $update_member->is_login = 1;
                        $update_member->save();

                        $mr_data['user_id'] = $this->nulltoblank($mr_detail->id);
                        $mr_data['full_name'] = $this->nulltoblank($mr_detail->full_name);
                        $mr_data['email'] = $this->nulltoblank($mr_detail->email);
                        //update user app token
                        \Log::info($headers);
                        $app_token = $this->updateUserAppToken($headers,$mr_detail->id);
                        $mr_data['user_token'] = $app_token;
                    
                        
                        $data = $mr_data;
                        $message = 'Login successful!';
                        return $this->responseSuccess($message,$data);
                } else {

                    $message = 'Password incorrect!';
                    return $this->responseUnauthorized($message);
                }  

            } else {

                $message = 'User not found!';
                return $this->responseUnauthorized($message);

            }

        } else {

            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);

        }

    }

    // MR forgot password Api
    public function mrForgotPassword(){

        $errors_array = array();

        if(!Request::has('email') || Request::get('email') == ""){
            $errors_array['email'] = 'Please enter your email ID.';
        }

        if(count($errors_array) == 0){
            $check_mail = MrDetail::where('email', Request::get('email'))->where('is_delete', 0)->first();
            if(!empty($check_mail)){

                $mr_data = MrDetail::where('email', Request::get('email'))->where('is_delete', 0)->first();

                $maildata[] = '';
                $signature_message = '';
                $mail_message = '';
                $mail_message .= "<b>Hello,</b><br><br>";
                $mail_message .= "Below is Your change password Link</b><br><br>";
                $mail_message .= "";
                $signature_message .= "<br>Regards</b>";
                $signature_message .= "<br>Kaps</b><br>";
                $title = "Change Password - Mr Forgot Password";
                $email = Request::get('email');

                $maildata['bodymessage'] = $mail_message;
                $maildata['signature_message'] = $signature_message;
                $maildata['mr_data'] = $mr_data;
                $token = app('auth.password.broker')->createToken($mr_data);
                $maildata['token'] = $token;

                Mail::send('mail.email', $maildata, function ($message) use ($email,$title)
                {
                    $message->from('darshit.finlark@gmail.com', 'forgot Password');
                    $message->to($email);
                    $message->subject($title);
                });

                $message = 'Forgot password link successfully send to registed email id';
                return $this->responseSuccess($message);

            } else {

                $message = 'Email id not available in our record!';
                return $this->responseUnauthorized($message);

            }
        } else {

            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);

        }
    }

    //MR logout
    public function userLogout(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-token']) || $headers['user-token'] == "")
            $errors_array['user-token'] = 'Please enter user token';
        

        if(count($errors_array) == 0){

            $updateToken = UserToken::where('app_token',$headers['user-token'])
                                    ->update(['app_token' => '']);

            if($updateToken){

                $message = 'Successfully logout';
                return $this->responseSuccess($message);

            } else {

                $message = 'errors';
                return $this->responseFailer($message);
            }

        } else {

            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);

        }      
    }

    //Change password
    public function changePassword(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if (!Request::has('current_password') || Request::get('current_password') == "")
            $errors_array['current_password'] = 'Please pass current password';

        if (!Request::has('password') || Request::get('password') == "")
            $errors_array['password'] = 'Please pass password';

        if (!Request::has('confirm_password') || Request::get('confirm_password') == "")
            $errors_array['confirm_password'] = 'Please pass confirm password';

        if(count($errors_array) == 0){

            $data = Request::all();

            //check email id
            $mr_data = MrDetail::where('id',$headers['user-id'])->where('is_delete', 0)->first();

            if(!empty($mr_data)){

                //check password
                if(Hash::check($data['current_password'], $mr_data->password)){

                    if($data['password'] == $data['confirm_password']){

                        $update_member = MrDetail::findOrFail($mr_data->id);
                        $update_member->password = Hash::make($data['confirm_password']);
                        $update_member->save();

                        if($update_member){

                            $message = 'Password updated Successfully!';
                            return $this->responseSuccess($message);

                        } else {

                            $message = 'Something went wrong!';
                            return $this->responseFailer($message);                        

                        }    

                    } else {

                        $message = 'Password and confirm password not match!';
                        return $this->responseUnauthorized($message);

                    }
                    
                } else {

                    $message = 'Current password incorrect!';
                    return $this->responseUnauthorized($message);

                }

            } else {

                $message = 'Unauthorized User!';
                return $this->responseUnauthorized($message);
                    
            }

        }  else {

            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);

        }      
    }

    // Upload documents of stockiest
    public function uploadDocument(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if (!Request::has('stockist_id') || Request::get('stockist_id') == "")
            $errors_array['stockist_id'] = 'Please pass stockist id';

        if (!Request::has('statement'))
            $errors_array['statement'] = 'Please pass statement';  

        if(count($errors_array) == 0){

            $data = Request::all();

            foreach ($data['statement'] as $sk => $sv) {
                $save_statement = new StockiestStatement;
                $save_statement->data_id = $data['stockist_id'];   
                $statement = $this->uploadImage($sv,'statement');
                $save_statement->statement = $statement;  
                $save_statement->save();
            }

            $message = 'Statement successfully uploaded!';
            return $this->responseSuccess($message);
            
        } else {

            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);
        }   
    }

    // Stokiest wise uploaded statment's list
    public function uploadStatement(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if (!Request::has('stockist_id') || Request::get('stockist_id') == "")
            $errors_array['stockist_id'] = 'Please pass stockist id';

        if(count($errors_array) == 0){

            $data = Request::all();
            
            $path = URL::to('/uploads');

            if(isset($data['statement']) && (!empty($data['statement']))){
                foreach ($data['statement'] as $sk => $sv) {
                    $save_statement = new StockiestStatement;
                    $save_statement->data_id = $headers['user-id'];   
                    $statement = $this->uploadImage($sv,'statement');
                    $save_statement->statement = $statement;  
                    $save_statement->save();
                }
            }
            
            //get attachement
            $get_attachment = StockiestStatement::where('data_id',$data['stockist_id'])->where('is_delete',0)->paginate(20);

            if(!empty($get_attachment)){
                $documents = array();
                foreach($get_attachment as $ak => $av){

                    $documents[$ak]['id'] = $this->nulltoblank($av->id);
                    $documents[$ak]['document_name'] = $this->nulltoblank($av->statement);
                    $documents[$ak]['document_url'] = $path.'/statement/'.$av->statement;
                    $extension = substr($av->statement, strpos($av->statement, ".") + 1);
                    $documents[$ak]['document_extension'] = $extension;
                    
                }

                if(!empty($documents)){
                    $data['total_documents'] = $get_attachment->total();
                    $data['documents'] = $documents;
                    $message = '';
                    return $this->responseSuccess($message,$data);
                } else {
                    $data['documents'] = [];
                    $message = 'Requests not found!';
                    return $this->responseDatanotFound($message,$data);
                }

            } else {

                /*$message = 'Attachment not available right now!';
                return $this->responseFailer($message);*/

                $message = 'Attachment not available right now!';
                return $this->responseDatanotFound($message);
            }
            
        } else {

            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);

        }   
    }

    // Remove Upload statement
    public function removeUploadStatement(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if (!Request::has('stockist_id') || Request::get('stockist_id') == "")
            $errors_array['stockist_id'] = 'Please pass stockist id';

        if (!Request::has('statement_id') || Request::get('statement_id') == "")
            $errors_array['statement_id'] = 'Please pass statement id';

        if(count($errors_array) == 0){

            $data = Request::all();

            $removeStatement = StockiestStatement::where('data_id',$data['stockist_id'])->where('id',$data['statement_id'])->update(['is_delete' => 1]);

            if($removeStatement){

                $message = 'Statement deleted!';
                return $this->responseSuccess($message);

            } else {

                $message = 'Something went wrong!';
                return $this->responseFailer($message);
            }

        } else {
                
            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);

        }
    }

    // All doctor request list
    public function allDoctorRequestList(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if(count($errors_array) == 0){

            $data = Request::all();

            //get all doctor request List
            $query = AllRequest::where('submitted_by',$headers['user-id'])->with(['doctor_detail','profile_detail']);

            if(isset($data['doctor_name']) && $data['doctor_name'] != ''){
                $doctor_name = $data['doctor_name'];

                $query->whereHas('doctor_detail', function ($query) use ($doctor_name) { 
                $query->where('full_name', 'like','%' . $doctor_name . '%'); })->orWhereHas('profile_detail', function ($query) use ($doctor_name) { 
                    $query->where('profile_name', 'like','%' . $doctor_name . '%'); 
                });
            } 

            $get_doctor_data = $query->paginate(20);

            $doctorRequestData = array();

            if(!empty($get_doctor_data)){
                foreach ($get_doctor_data as $gk => $gv) {
                
                    $doctorRequestData[$gk]['id'] = $this->nulltoblank($gv->id);
                    //profile name
                    if($gv['profile_detail']['profile_name'] != ''){
                        $doctorRequestData[$gk]['doctor_name'] = $gv['doctor_detail']['full_name'].' ( '.$gv['profile_detail']['profile_name'].' )';    
                    } else {
                        $doctorRequestData[$gk]['doctor_name'] = $gv['doctor_detail']['full_name'];    
                    }
                    
                    $doctorRequestData[$gk]['request_date'] = (($gv->request_date != '') ? date('j M,Y',strtotime($gv->request_date)) : ''); 
                    $doctorRequestData[$gk]['request_amount'] = $this->nulltoblank($gv->request_amount);
                    $doctorRequestData[$gk]['reason'] = $this->nulltoblank($gv->reason);
                    $doctorRequestData[$gk]['status'] = ($gv->status == 0) ? 0 : (($gv->status == 1) ? 1 : 2);
                    $doctorRequestData[$gk]['is_payment_genrated'] = (($gv->is_payment_genrated == 0) ? 0 : 1);

                    if($gv->is_payment_genrated == 0){
                        $doctorRequestData[$gk]['recived_on'] = ''; 
                        $doctorRequestData[$gk]['paid_on'] = ''; 
                    } else {
                        $doctorRequestData[$gk]['paid_to_doctor'] = (($gv->is_paid_to_doctor == 0) ? 0 : 1);
                        $doctorRequestData[$gk]['recived_on'] = (($gv->received_on != '') ? date('j M,Y',strtotime($gv->received_on)) : ''); 
                        $doctorRequestData[$gk]['paid_on'] = (($gv->paid_on != '') ? date('j M,Y',strtotime($gv->paid_on)) : ''); 
                    }
                }

                if(!empty($doctorRequestData)){
                    $data['total_stockist'] = $get_doctor_data->total();
                    $data['doctor_request'] = $doctorRequestData;
                    $message = '';
                    return $this->responseSuccess($message,$data);
                } else {
                    $data['doctor_request'] = [];
                    $message = 'Requests not found!';
                    return $this->responseDatanotFound($message,$data);
                }
            } else {
                $message = 'Requests not found!';
                return $this->responseDatanotFound($message);
            }

        } else {
            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);
        }
    }

    // Doctor Request List
    public function doctorRequestList(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if (!Request::has('profile_id') || Request::get('profile_id') == "")
            $errors_array['profile_id'] = 'Please pass profile id';

        if (!Request::has('doctor_id') || Request::get('doctor_id') == "")
            $errors_array['doctor_id'] = 'Please pass doctor id';

        if(count($errors_array) == 0){

            $data = Request::all();

            $get_doctor_request = AllRequest::where('profile_id',$data['profile_id'])
                                            ->where('doctor_id',$data['doctor_id'])
                                            ->where('submitted_by',$headers['user-id'])
                                            ->paginate(20);

            if(!empty($get_doctor_request)){
                $doctorRequestData = array();

                foreach ($get_doctor_request as $gk => $gv) {
                
                    $doctorRequestData[$gk]['id'] = $this->nulltoblank($gv->id);
                    $doctorRequestData[$gk]['request_date'] = (($gv->request_date != '') ? date('j M,Y',strtotime($gv->request_date)) : ''); 
                    $doctorRequestData[$gk]['request_amount'] = $this->nulltoblank($gv->request_amount);
                    $doctorRequestData[$gk]['reason'] = $this->nulltoblank($gv->reason);
                    $doctorRequestData[$gk]['status'] = ($gv->status == 0) ? 0 : (($gv->status == 1) ? 1 : 2);
                    $doctorRequestData[$gk]['received_by_mr'] = (($gv->received_by_mr == 0) ? 0 : 1);

                    if($gv->received_by_mr == 0){
                        $doctorRequestData[$gk]['paid_to_doctor'] = "";
                        $doctorRequestData[$gk]['paid_on'] = $gv->is_paid_to_doctor == 0 ? "" : ""; 
                    } else {
                        $doctorRequestData[$gk]['paid_to_doctor'] = (($gv->is_paid_to_doctor == 0) ? 0 : 1);
                        $doctorRequestData[$gk]['paid_on'] = (($gv->paid_on != '') ? date('j M,Y',strtotime($gv->paid_on)) : ''); 
                    }
                }

                $doctor_offset = DoctorOffset::where('profile_id',$data['profile_id'])->where('doctor_id',$data['doctor_id'])->orderBy('id','DESC')->first();

                //send doctor offsets
                $data['last_month_sales_heading'] = (!empty($doctor_offset) ? 'Sales of '.date('M y', strtotime($doctor_offset->last_month_date)) : ''); 
                $data['last_month_sales'] = (!empty($doctor_offset) ? '₹ '.$doctor_offset->last_month_sales : '₹  0'); 

                $data['second_month_heading'] = (!empty($doctor_offset) ? 'Sales of '.date('M y', strtotime($doctor_offset->previous_second_month_date)) : '');
                $data['second_month_sales'] = (!empty($doctor_offset) ? '₹ '.$doctor_offset->previous_second_month_sales : '₹  0'); 

                $data['third_month_heading'] = (!empty($doctor_offset) ? 'Sales of '.date('M y', strtotime($doctor_offset->previous_third_month_date)) : ''); 
                $data['third_month_sales'] = (!empty($doctor_offset) ? '₹ '.$doctor_offset->previous_third_month_sales : '₹  0'); 

                $data['target_sales_heading'] = (!empty($doctor_offset) ? 'Target Sales ' : ''); 
                $data['target_sales'] = (!empty($doctor_offset) ? '₹ '.number_format($doctor_offset->target_previous_month,2): '₹  0'); 

                $data['carry_forward_heading'] = (!empty($doctor_offset) ? 'Carry Forward Points' : ''); 
                $data['carry_forward_sales'] = (!empty($doctor_offset) ? '₹ '.number_format($doctor_offset->carry_forward,2): '₹  0'); 

                $data['eligible_heading'] = (!empty($doctor_offset) ? 'Eligible Points'  : ''); 
                $data['eligible_sales'] = (!empty($doctor_offset) ? '₹ '.number_format($doctor_offset->eligible_amount,2): '₹  0'); 

                if(!empty($doctorRequestData)){
                    $data['total_stockist'] = $get_doctor_request->total();
                    $data['doctor_request'] = $doctorRequestData;
                    $message = '';

                    return $this->responseSuccess($message,$data);
                } else {
                    $data['doctor_request'] = [];
                    $message = 'Requests not found!';
                    return $this->responseDatanotFound($message,$data);
                }
                
                return $this->responseSuccess($message,$data);

            } else {

                $message = 'Requests not found!';
                return $this->responseDatanotFound($message);
            }

        } else {

            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);

        }
    }

    // Calendar details function
    public function calendarDetail(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if (!Request::has('date') || Request::get('date') == "")
            $errors_array['date'] = 'Please pass date';

        if(count($errors_array) == 0){

            $data = Request::all();

            $date = explode('/',$data['date']);
            
            $year = $date[01];

            $get_territories = MrTerritory::where('mr_id',$headers['user-id'])->where('territories_id','!=','')->pluck('territories_id');
            $get_sub_territories = MrTerritory::where('mr_id',$headers['user-id'])->where('sub_territories','!=','')->pluck('sub_territories');

            $doctors_dob = DoctorDetail::where('is_delete', 0)
                                       ->selectRaw('year(dob) year, month(dob) month, day(dob) date, full_name, id')
                                       ->groupBy('id', 'year', 'month', 'date', 'full_name')
                                       ->whereHas('territory_detail', function ($query) use ($get_territories) { $query->whereIn('territories_id', $get_territories); })
                                       ->WhereHas('territory_detail', function ($query) use ($get_sub_territories) { $query->whereIn('sub_territories',$get_sub_territories); })
                                       ->with(['territory_detail' => function($q){ $q->with(['territory_name']); }])
                                       ->whereRaw('extract(month from dob) = ?', [$date[0]])
                                       ->get();
                
            // Doctors anniversary date
            $doctors_anniversary = DoctorDetail::where('is_delete', 0)->selectRaw('year(anniversary_date) year, month(anniversary_date) month, day(anniversary_date) date, full_name, id')->groupBy('id', 'year', 'month', 'date', 'full_name')->whereHas('territory_detail', function ($query) use ($get_territories) { $query->whereIn('territories_id', $get_territories); })->WhereHas('territory_detail', function ($query) use ($get_sub_territories) { $query->whereIn('sub_territories',$get_sub_territories); })->with(['territory_detail' => function($q){ $q->with(['territory_name']); }])->whereRaw('extract(month from anniversary_date) = ?', [$date[0]])->get();
            
            // Doctors clinic opening date
            $clinic_open_date = DoctorDetail::where('is_delete', 0)->selectRaw('year(clinic_opening_date) year, month(clinic_opening_date) month, day(clinic_opening_date) date, full_name, id')->groupBy('id', 'year', 'month', 'date', 'full_name')->whereHas('territory_detail', function ($query) use ($get_territories) { $query->whereIn('territories_id', $get_territories); })->WhereHas('territory_detail', function ($query) use ($get_sub_territories) { $query->whereIn('sub_territories',$get_sub_territories); })->with(['territory_detail' => function($q){ $q->with(['territory_name']); }])->whereRaw('extract(month from clinic_opening_date) = ?', [$date[0]])->get();
            
            // Mr payment received date
            $payment_rec = AllRequest::with(['mr_detail'])->whereHas('main_territory_detail', function ($query) use ($get_territories) { $query->whereIn('territory_id', $get_territories); })->WhereHas('main_territory_detail', function ($query) use ($get_sub_territories) { $query->whereIn('sub_territory_id',$get_sub_territories); })->whereMonth('received_on','=', $date[0])->whereYear('received_on','=',$date[01])->get();

            // Mr payment paid to doctor date
            $payment_paid = AllRequest::with(['mr_detail'])->with(['doctor_detail'])->whereHas('main_territory_detail', function ($query) use ($get_territories) { $query->whereIn('territory_id', $get_territories); })->WhereHas('main_territory_detail', function ($query) use ($get_sub_territories) { $query->whereIn('sub_territory_id',$get_sub_territories); })->whereMonth('paid_on','=', $date[0])->whereYear('paid_on', '=',$date[01])->get();
         
            $dob = array();        
            $anniversary = array();
            $clinic_open = array();
            $pay_rec = array();    
            $pay_paid = array();   

            if(!empty($doctors_dob)){
                $birthday_date = [];
                foreach ($doctors_dob as $bk => $bv) {
   
                    $date = $bv->month."/".$bv->date;
                    if(!in_array($date,$birthday_date)){
                        $birthday_date[] = $date;
                        $dob[$bk]['name'] = "Birthday";
                    } else {
                        $dob[$bk]['name'] = '';
                    }
                    if(!empty($bv->territory_detail)){
                        $dob[$bk]['event_description'] = $bv->full_name." (". $bv['territory_detail'][0]['territory_name']['territory_id'].")"; 
                    } else {
                        $dob[$bk]['event_description'] = $bv->full_name;  
                    }
                    
                    $date2 = strtotime($year."-".$bv->month."-".$bv->date);
                    $dob[$bk]['date'] = date('Y-m-d', $date2);
                    $dob[$bk]['type'] = "birthday";

                }
            }

            if(!empty($doctors_anniversary)){
                $anniversary_date = [];
                foreach ($doctors_anniversary as $ak => $av) {

                    $date = $av->month."/".$av->date;
                    if(!in_array($date,$anniversary_date)){
                        $anniversary_date[] = $date;
                        $anniversary[$ak]['name'] = "Anniversary";
                    } else {
                        $anniversary[$ak]['name'] = '';
                    }

                    if(!empty($av->territory_detail)){
                        $anniversary[$ak]['event_description'] = $av->full_name." (". $av['territory_detail'][0]['territory_name']['territory_id'].")";
                    } else {
                        $anniversary[$ak]['event_description'] = $av->full_name;
                    }
                    
                    $date2 = strtotime($av->month."/".$av->date."/".$year);
                    $anniversary[$ak]['date'] = date('Y-m-d', $date2);
                    $anniversary[$ak]['type'] = "anniversary";

                }
            }

            if(!empty($clinic_open_date)){
                $opening_date = [];
                foreach ($clinic_open_date as $ck => $cv) {
                    
                    $date = $cv->month."/".$cv->date;
                    if(!in_array($date,$opening_date)){
                        $opening_date[] = $date;
                        $clinic_open[$ck]['name'] = "Clinic opening anniversary";
                    } else {
                        $clinic_open[$ck]['name'] = '';
                    }

                    if(!empty($cv->territory_detail)){
                        
                        $clinic_open[$ck]['event_description'] = $cv->full_name." (". $cv['territory_detail'][0]['territory_name']['territory_id'].")";
                    } else {
                        
                        $clinic_open[$ck]['event_description'] = $cv->full_name;
                    }
                    $date2 = strtotime($cv->month."/".$cv->date."/".$year);
                    $clinic_open[$ck]['date'] = date('Y-m-d', $date2);
                    $clinic_open[$ck]['type'] = "clinic_opening";
                    
                }
            }

            if(!empty($payment_rec)){
                $recived_date = [];
                foreach ($payment_rec as $rk => $rv){
                    
                    $date = $rv->month."/".$rv->date;
                    if(!in_array($date,$recived_date)){
                        $recived_date[] = $date;
                        $pay_rec[$rk]['name'] = "MR payment received";
                    } else {
                        $pay_rec[$rk]['name'] = '';
                    }
                    $pay_rec[$rk]['event_description'] = "₹ ".$rv->request_amount." received by ".$rv->mr_detail->full_name;  
                    
                    $pay_rec[$rk]['date'] = $rv->received_on;
                    $pay_rec[$rk]['type'] = "mr_receive";

                }
            }

            if(!empty($payment_paid)){
                $paid_date = [];
                foreach ($payment_paid as $pk => $pv) {

                    $date = $pv->month."/".$pv->date;
                    if(!in_array($date,$paid_date)){
                        $paid_date[] = $date;
                        $pay_paid[$pk]['name'] = 'MR payment paid to doctor';
                    } else {
                        $pay_paid[$pk]['name'] = '';
                    }
                    $pay_paid[$pk]['event_description'] = $pv->mr_detail->full_name." paid ₹ ".$pv->request_amount." to ".$pv->doctor_detail->full_name;  
                    $pay_paid[$pk]['date'] = $rv->paid_on;
                    $pay_paid[$pk]['type'] = "mr_paid_to_doctor";
                }
            }

            $all_data = array_merge($dob,$anniversary,$clinic_open,$pay_rec,$pay_paid);
            
            if(!empty($all_data)){
                $data['calendar_data'] = $all_data;
                $message = '';
                return $this->responseSuccess($message,$data);    
            } else {
                $message = 'Events not found!';
                return $this->responseDatanotFound($message);
            }

        } else {
            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);
        }
    }

    // Stockiest list
    public function stockistList(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if(count($errors_array) == 0){

            $data = Request::all();
            
            $query = MrWiseStockiestData::where([['mr_id',$headers['user-id']],['is_delete',0]])->with(['stockiest_detail','medical_store','doctor']);

            //search stockist name
            if(isset($data['stockist_name']) && $data['stockist_name'] != ''){
                $stockist_name = $data['stockist_name'];
                $query->whereHas('stockiest_detail', function ($query) use ($stockist_name) { 
                    $query->where('stockiest_name', 'like','%' . $stockist_name . '%'); 
                });
            }

            //if date filter require
            if(isset($data['sales_month']) && $data['sales_month'] != ''){
                $date = explode('-',$data['sales_month']);
                $query->whereMonth('sales_month', '=', $date[0]);
                $query->whereYear('sales_month', '=', $date[1]);
            } else {
                $current_month = date('m');
                $current_year = date('Y');
                $query->whereMonth('sales_month', '=', $current_month);
                $query->whereYear('sales_month', '=', $current_year);                
            }

            $getStokistData = $query->paginate(20);

            $check_monthly_confirm = '';
            $completed = '';

            if(!empty($getStokistData)){
                $stockiest = array();

                foreach ($getStokistData as $sk => $sv) {

                    $stockiest[$sk]['id'] = $this->nulltoblank($sv->id);
                    $stockiest[$sk]['stockist_id'] = $this->nulltoblank($sv->stockiest_id);
                    $stockiest[$sk]['stockist_name'] = $this->nulltoblank($sv['stockiest_detail']['stockiest_name']);
                    $stockiest[$sk]['sales_month'] = $this->nulltoblank(date('F Y',strtotime($sv->sales_month)));
                    $stockiest[$sk]['amount'] = ($sv->amount != '' && $sv->amount !=  0) ? (string)$sv->amount : (($sv->amount === null && $sv->amount !== 0) ? "" :  0);
                    
                    //0 = blank, 1 = draft, 2 = completed
                    
                    //stokiest status
                    if($sv->is_completed == 2){
                        $stockiest[$sk]['stockist_status'] = 2;         
                    } else {
                        if($sv->priority == 0){
                            $stockiest[$sk]['stockist_status'] = $sv->priority == 0 ? 0 : 1;                            
                        } elseif($sv->is_confirm_data == 1) {
                            $stockiest[$sk]['stockist_status'] = 2;                            
                        } else {
                            $stockiest[$sk]['stockist_status'] = $sv->priority == 0 ? 0 : 1;                            
                        }
                    }

                    //medical store status
                    if($sv->is_completed == 2){
                        $stockiest[$sk]['medical_store_status'] = 2;    
                    } elseif(!is_null($sv->medical_store)){
                        if($sv->is_confirm_data == 1){
                            $stockiest[$sk]['medical_store_status'] = 2;                            
                        } else {
                            $stockiest[$sk]['medical_store_status'] = 1;
                        }
                    } else {
                        $stockiest[$sk]['medical_store_status'] = 0;
                    }

                    //doctor status
                    if($sv->is_completed == 2){
                        $stockiest[$sk]['doctor_status'] = 2;    
                    } elseif(!is_null($sv->doctor)){
                        if($sv->is_confirm_data == 1){
                            $stockiest[$sk]['doctor_status'] = 2;                            
                        } else {
                            $stockiest[$sk]['doctor_status'] = 1;
                        }
                    } else {
                        $stockiest[$sk]['doctor_status'] = 0;
                    }
                    
                    //button status
                    if($sv->is_completed == 0){
                        $stockiest[$sk]['button_status'] = 0; //disable 
                    } elseif($sv->is_completed == 1){
                        $stockiest[$sk]['button_status'] = 1; //enable
                    } else {
                        $stockiest[$sk]['button_status'] = 2; //enable
                    }
                }
                
                $data['total_stockist'] = $getStokistData->total();

                if(isset($data['sales_month']) && $data['sales_month'] != ''){
                    // $date = explode('-',$data['sales_month']);
                    $check = MrWiseStockiestData::where('mr_id',$headers['user-id'])->where('is_delete',0)->whereMonth('sales_month', '=', $date[0])->whereYear('sales_month', '=', $date[1])->first();
                    if(!empty($check)){
                        $data['month_confirm_status'] = $check->is_confirm_data == 0 ? 0 : 1;                            
                    } else {
                        $data['month_confirm_status'] = 0; 
                    }
                    
                }

                if(!empty($stockiest)){

                    $data['stockist'] = $stockiest;
                    $message = '';
                    return $this->responseSuccess($message,$data);    

                } else {

                    $data['stockist'] = $stockiest;
                    $message = '';

                    $this->LogOutput(Response::json(array('status'=>'success','status_code' => 201,'data' => $data)));
                    return Response::json(array('status'=>'success','status_code' => 201,'data' => $data),200);
                }
                
                if(!empty($stockiest)){

                    $data['stockist'] = $stockiest;
                    $message = '';
                    return $this->responseSuccess($message,$data);    

                } else {
                    $data['stockist'] = [];
                    $message = 'stockist not found!';
                    return $this->responseDatanotFound($message,$data);
                }

            } else {
                $message = 'Stockiest not found!';
                return $this->responseDatanotFound($message);
            }   

        } else {
            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);
        }
    }

    // Add doctor request
    public function addDoctorRequest(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if (!Request::has('profile_id') || Request::get('profile_id') == "")
            $errors_array['profile_id'] = 'Please pass profile id';

        if (!Request::has('doctor_id') || Request::get('doctor_id') == "")
            $errors_array['doctor_id'] = 'Please pass doctor id';

        if (!Request::has('request_date') || Request::get('request_date') == "")
            $errors_array['request_date'] = 'Please pass request date';

        if (!Request::has('eligible_amount') || Request::get('eligible_amount') == "")
            $errors_array['eligible_amount'] = 'Please pass eligible amount';

        if (!Request::has('required_amount') || Request::get('required_amount') == "")
            $errors_array['required_amount'] = 'Please pass required amount';

        if (!Request::has('reason') || Request::get('reason') == "")
            $errors_array['reason'] = 'Please pass reason';

        if(count($errors_array) == 0){
            $data = Request::all();

            //add doctor
            $doctor = new AllRequest;
            $doctor->doctor_id = $data['doctor_id'];
            $doctor->profile_id = $data['profile_id'];
            $doctor->request_date = $this->convertDate($data['request_date']);
            $doctor->eligible_amount = $data['eligible_amount'];
            $doctor->request_amount = $data['required_amount'];
            $doctor->reason = $data['reason'];
            $doctor->submitted_by = $headers['user-id'];
            $doctor->submitted_on = date('Y-m-d');
            $doctor->save();

            $get_doctor_territories = DoctorDetail::with(['get_territory'])->first();
   
            if(!empty($get_doctor_territories['get_territory'])){
                foreach ($get_doctor_territories['get_territory'] as $tk => $tv) {
                    $territories = new DoctorRequestTerritorry;
                    $territories->request_id = $doctor->id;
                    $territories->territory_id = $tv['territories_id'];
                    $territories->sub_territory_id = $tv['sub_territories'];
                    $territories->save();
                }
            }

            if($doctor){

                $message = 'Request successfully Added!';
                return $this->responseSuccess($message);  

            } else {

                $message = 'Something went wrong!';
                return $this->responseFailer($message);
            }

        } else {

            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);

        }        
    }

    // Update status
    public function updateStatus(){
        
        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if (!Request::has('stockist_id') || Request::get('stockist_id') == "")
            $errors_array['stockist_id'] = 'Please pass stockist id';

        if(count($errors_array) == 0){

            $data = Request::all();

            $update_status = MrWiseStockiestData::findOrFail($data['stockist_id']);
            //update status of entry
            if(isset($data['entry_status']) && $data['entry_status'] != ''){
                $update_status->entry_status = $data['entry_status'];
            }

            if(isset($data['is_completed']) && $data['is_completed'] != ''){
                if(!Request::has('amount')){
                    $message = 'Pass amount!';
                    return $this->responseFailer($message);
                } else {
                    $update_status->amount = $data['amount'];
                    $update_status->submitted_on = date("Y-m-d");
                    $update_status->priority = 1;           
                    $update_status->submitted_by = $headers['user-id'];           
                    $update_status->is_completed = $data['is_completed'];
                }
            }
            $update_status->save();

            if($update_status){
                
                $message = 'Successfully updated!';
                return $this->responseSuccess($message);
            } else {
                $message = 'Something went wrong!';
                return $this->responseFailer($message);
            }
        } else {
            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);            
        }        
    }

    // MR wise doctor list
    public function mrDoctorList(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if(count($errors_array) == 0){

            $data = Request::all();

            $get_mr_territories = MrDetail::with(['get_territory'])->where('id',$headers['user-id'])->first();

            /*echo "<pre>";
            print_r($get_mr_territories->toArray());
            exit;*/

            //mr territories and sub territories
            $mrTerritories = array();
            $mrSubTerritories = array();

            if(!empty($get_mr_territories['get_territory'])){
                foreach ($get_mr_territories['get_territory'] as $tk => $tv) {
                    $mrTerritories[] = $tv['territories_id'];
                    $mrSubTerritories[] = $tv['sub_territories'];
                }
            }

            //Stokiest territory data fetching

            $stockiestTerritory = array();
            $stockiestSubTerritory = array();

            $getStokist = StockiestTerritory::whereIn('territories_id',$mrTerritories)
                                            ->whereIn('sub_territories',$mrSubTerritories)
                                            ->select('territories_id','sub_territories')
                                            ->get();
            
            if(!is_null($getStokist)){
                foreach($getStokist as $sk => $sv){
                    
                    if(!in_array($sv['territories_id'],$stockiestTerritory)){
                        $stockiestTerritory[] = $sv['territories_id'];
                    }

                    if(!in_array($sv['sub_territories'],$stockiestSubTerritory)){
                        $stockiestSubTerritory[] = $sv['sub_territories'];
                    }
                }
            }     

            //get medical store data
            $medicalStoreTerritory = array();
            $medicalStoreSubTerritory = array();

            $getMedicalStore = MedicalStoreTerritory::whereIn('territories_id',$stockiestTerritory)
                                            ->whereIn('sub_territories',$stockiestSubTerritory)
                                            ->select('territories_id','sub_territories')
                                            ->get();
            
            if(!is_null($getMedicalStore)){
                foreach($getMedicalStore as $sk => $sv){
                    
                    if(!in_array($sv['territories_id'],$medicalStoreTerritory)){
                        $medicalStoreTerritory[] = $sv['territories_id'];
                    }

                    if(!in_array($sv['sub_territories'],$medicalStoreSubTerritory)){
                        $medicalStoreSubTerritory[] = $sv['sub_territories'];
                    }
                }
            }      

            //get doctor base on medical store
            $doctor_id = DoctorTerritory::whereIn('territories_id',$medicalStoreTerritory)
                                         ->whereIn('sub_territories',$medicalStoreSubTerritory)
                                         ->groupBy('doctor_id')
                                         ->pluck('doctor_id')
                                         ->toArray();

            $query = DoctorProfile::whereIn('doctor_id',$doctor_id)->where('is_delete',0)->with(['doctor_detail'])->orderBy('doctor_id','ASC');
            
            if(isset($data['doctor_name'])){
                $doctor_name = $data['doctor_name'];
                $query->where('profile_name','like', '%' . $doctor_name . '%')->orWhereHas('doctor_detail', function ($query) use ($doctor_name) { $query->where('full_name','like', '%' . $doctor_name . '%'); })->whereIn('doctor_id',$doctor_id);
            }

            $get_doctor = $query->paginate(20);

            if(!empty($get_doctor)){
                $doctor_data = array();
                foreach ($get_doctor as $gk => $gv) {
                    $doctor_data[$gk]['id'] = $this->nulltoblank($gv->id);
                    $doctor_data[$gk]['doctor_id'] = $gv['doctor_detail']['id'];
                    $doctor_data[$gk]['doctor_name'] = $gv['profile_name'] != '' ? $this->nulltoblank($gv['doctor_detail']['full_name'].' ('.$gv->profile_name.')') : $this->nulltoblank($gv['doctor_detail']['full_name']);    
                }

                if(!empty($doctor_data)){
                    $data['total_doctor'] = $get_doctor->total();
                    $data['doctors'] = $doctor_data;
                    $message = '';
                    return $this->responseSuccess($message,$data);
                } else {
                    $data['doctors'] = [];
                    $message = 'Requests not found!';
                    return $this->responseDatanotFound($message,$data);
                }
            } else {

                $message = 'Doctors not found!';
                return $this->responseDatanotFound($message);
            }

        } else {

            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);
        }
    }  

    // Create profile
    public function createProfile($data){

        $territories = array();
        $sub_territories = array();

        $getMedicalStore = MedicalStoreTerritory::where('medical_store_id',$data['medical_store_id'])->get();

        if(!empty($getMedicalStore)){
            foreach ($getMedicalStore as $tk => $tv) {
                $territories[] = $tv->territories_id;
                $sub_territories[] = $tv->sub_territories;
            }
        }

        //doctors detail
        $doctorId = DoctorTerritory::whereIn('territories_id',$territories)
                                            ->whereIn('sub_territories',$sub_territories)
                                            ->select('territories_id','sub_territories','doctor_id')
                                            ->pluck('doctor_id')->toArray();
        

        //get doctor depend on mr territories
        $territoristDoctorDetail = DoctorProfile::whereIn('doctor_id',$doctorId)->where('is_delete',0)->get();

        if(isset($data['get_mr_territories']) && $data['get_mr_territories'] == true){
            $check_data = MedicalStoreDoctorData::where('medical_store_id',$data['medical_store_id'])->where('stockiest_id',$data['stockist_id'])->where('sales_month',$data['sales_month'])->first();
        } else {
            $check_data = array();
        }

        $sales_id = MrWiseStockiestData::where('stockiest_id',$data['stockist_id'])->where('sales_month',$data['sales_month'])->where('mr_id',$data['mr_id'])->first();

        //save stockiest data
        if(empty($check_data) && (!empty($sales_id))){
            if(!empty($territoristDoctorDetail)){
                foreach($territoristDoctorDetail as $sk => $sv) {

                    $getData = MedicalStoreDoctorData::where('doctor_profile',$sv->id)
                                                     ->where('doctor_id',$sv->doctor_id)
                                                     ->where('medical_store_id',$data['medical_store_id'])
                                                     ->where('stockiest_id',$data['stockist_id'])
                                                     ->where('sales_id',$sales_id->sales_id)
                                                     ->where('mr_id',$data['mr_id'])
                                                     ->where('sales_month',$data['sales_month'])
                                                     ->first();
                    
                    if(is_null($getData)){

                        $save_doctor_detail = new MedicalStoreDoctorData;
                        $save_doctor_detail->doctor_profile = $sv->id;
                        $save_doctor_detail->doctor_id = $sv->doctor_id;
                        $save_doctor_detail->medical_store_id = $data['medical_store_id'];
                        $save_doctor_detail->stockiest_id = $data['stockist_id'];
                        $save_doctor_detail->sales_id = $sales_id->sales_id;
                        $save_doctor_detail->mr_id = $data['mr_id'];
                        $save_doctor_detail->sales_month = $data['sales_month'];
                        $save_doctor_detail->priority = 0;
                        $save_doctor_detail->save();
                    }
                }
            }
        }

        return 'true';
    }

    // Get medical store list
    public function medicalstoreList(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if (!Request::has('stockist_id') || Request::get('stockist_id') == "")
            $errors_array['stockist_id'] = 'Please pass stockist id';

        if(count($errors_array) == 0){

            $data = Request::all();

            //if medical store not in database
            //================================            
            $date = explode(' ',$data['sales_month']);
            $date_month = date('m', strtotime($date[0]));
            $date_year = $date[1];
            $current_month = date('m');
            $current_year = date('Y');
            $date = $date[1].'-'.$date_month.'-25';
            
            $getMrTerritories = MrDetail::where('id',$headers['user-id'])
                                        ->with(['get_territory','salsehistory'])
                                        ->first();

            //mr territories and sub territories
            $mrTerritories = array();
            $mrSubTerritories = array();

            if(!is_null($getMrTerritories) && !is_null($getMrTerritories->get_territory)){
                foreach($getMrTerritories->get_territory as $sk => $sv){
                    
                    if(!in_array($sv['territories_id'],$mrTerritories)){
                        $mrTerritories[] = $sv['territories_id'];
                    }

                    if(!in_array($sv['sub_territories'],$mrSubTerritories)){
                        $mrSubTerritories[] = $sv['sub_territories'];
                    }
                }
            }

            //get stockiest data
            $stockiestTerritory = array();
            $stockiestSubTerritory = array();

            $getStokist = StockiestTerritory::whereIn('territories_id',$mrTerritories)
                                            ->whereIn('sub_territories',$mrSubTerritories)
                                            ->select('territories_id','sub_territories')
                                            ->get();

            if(!is_null($getStokist)){
                foreach($getStokist as $sk => $sv){
                    
                    if(!in_array($sv['territories_id'],$stockiestTerritory)){
                        $stockiestTerritory[] = $sv['territories_id'];
                    }

                    if(!in_array($sv['sub_territories'],$stockiestSubTerritory)){
                        $stockiestSubTerritory[] = $sv['sub_territories'];
                    }
                }
            }    

            //medical store ids array
            $getMedicalStore = MedicalStoreTerritory::whereIn('territories_id',$stockiestTerritory)
                                    ->whereIn('sub_territories',$stockiestSubTerritory)
                                    ->groupBy('medical_store_id')
                                    ->pluck('medical_store_id')
                                    ->toArray();     
           
            //medical store data
            $store_id = MedicalStore::whereIn('id',$getMedicalStore)
                                       ->with(['medical_store_user','mendical_store_territories'])
                                       ->where('is_delete',0)
                                       ->get();     
            //check data that medical store is added or not in the stockiest wise medical store data
            $checkData = array();

            if(!is_null($getMrTerritories)){
                $getSalesData = SalesHistory::where('mr_id',$headers['user-id'])->whereDate('sales_month',$date)->first();


                if(!is_null($getSalesData)){
                    $checkData = StockiestWiseMedicalStoreData::where([
                                    ['stockiest_id',$data['stockist_id']],
                                    ['mr_id',$headers['user-id']],
                                    ['sales_month',$getSalesData->sales_month]
                                ])->first();    
                }
            }
            
            //get mr wise stokiest data
            $sales_id = MrWiseStockiestData::where('id',$data['stockist_id'])->where('mr_id',$headers['user-id'])->first();

            //save stockiest data
            if(is_null($checkData)){
                if(!is_null($store_id) && !is_null($sales_id)){
                    foreach($store_id as $sk => $sv) {
                        //if($sv->id == 793){
                            $req['mr_id'] = $headers['user-id'];
                            $req['stockist_id'] = $data['stockist_id'];
                            $req['medical_store_id'] = $sv->id;
                            $req['sales_month'] = $getSalesData->sales_month;
                            $req['get_mr_territories'] = !is_null($getMrTerritories) ? true : false;

                            $this->createProfile($req);

                            $save_stockiest = new StockiestWiseMedicalStoreData;
                            $save_stockiest->medical_store_id = $sv->id;
                            $save_stockiest->stockiest_id = $data['stockist_id'];
                            $save_stockiest->sales_id = $sales_id->sales_id;
                            $save_stockiest->mr_id = $headers['user-id'];
                            $save_stockiest->sales_month = $date;
                            $save_stockiest->priority = 0;
                            $save_stockiest->save();
                        //}
                    }
                }

            } else {

                $checkDataAvailableOrNot = MedicalStoreDoctorData::where('mr_id',$headers['user-id'])->where('stockiest_id',$data['stockist_id'])->where('sales_month',$date)->get()->toArray();

                if(count($checkDataAvailableOrNot) == 0){
                    if(!is_null($store_id) && !is_null($sales_id)) {
                        foreach($store_id as $sk => $sv) {
                            $req['mr_id'] = $headers['user-id'];
                            $req['stockist_id'] = $data['stockist_id'];
                            $req['medical_store_id'] = $sv->id;
                            $req['sales_month'] = $getSalesData->sales_month;
                            $req['get_mr_territories'] = !is_null($getMrTerritories) ? true : false;


                            $this->createProfile($req);
                        }
                    }    
                }
            }

            $getDoctor = DoctorDetail::with(['get_territory'])->where('is_delete',0)->get();

            //get doctor depend on mr territories
            $doctor_id = array();
           
            $territorist_doctor_detail = DoctorProfile::whereIn('doctor_id',$doctor_id)->where('is_delete',0)->count();

            $query = StockiestWiseMedicalStoreData::query();
            $query->where('mr_id',$headers['user-id']);  
            $query->where('stockiest_id',$data['stockist_id']);   
            $query->where('is_delete',0);
            $query->where('sales_month', $date);

            if(isset($data['medical_store_name']) && $data['medical_store_name'] != ''){
                $medical_store_name = $data['medical_store_name'];
                $query->whereHas('store_detail', function ($query) use ($medical_store_name) { 
                    $query->where('store_name', 'like','%' . $medical_store_name . '%'); 
                });
            } else {
                $query->with(['store_detail']);
            }
            //$query->with(['store_detail']);
            $get_medical_store_data = $query->paginate(20);

            if(!empty($get_medical_store_data)){
                $get_medical_store_detail = array();
                foreach ($get_medical_store_data as $mk => $mv) {
                    
                    $get_medical_store_detail[$mk]['id'] = $this->nulltoblank($mv->medical_store_id);
                    $get_medical_store_detail[$mk]['store_name'] = $this->nulltoblank($mv['store_detail']['store_name']);
                    $get_medical_store_detail[$mk]['sales_amount'] = $this->nulltoblank($mv->sales_amount);
                    
                    $query = MedicalStoreDoctorData::query();
                    $query->where('medical_store_id',$mv->medical_store_id);
                    $query->where('sales_month',$date);  
                    $query->where('stockiest_id',$data['stockist_id']);
                    $query->where('is_delete',0);
                    $total_doctor = $query->count();//all doctors
                    
                    $query->whereNOTNULL('sales_amount');
                    $remaining_doctor = $query->count();//remaining doctors

                    if($mv->sales_amount != ''){
                        $get_medical_store_detail[$mk]['sales_amount'] = $mv->sales_amount != null ? (string)$mv->sales_amount : "0";
                        $get_medical_store_detail[$mk]['extra_business'] = $mv->extra_business != null ? (string)$mv->extra_business : "0";
                        $get_medical_store_detail[$mk]['scheme_business'] = $mv->scheme_business != null ? (string)$mv->scheme_business : "0";
                        $get_medical_store_detail[$mk]['ethical_business'] = $mv->ethical_business != null ? (string)$mv->ethical_business : "0";
                    } else {
                        $get_medical_store_detail[$mk]['sales_amount'] = $mv->sales_amount != null ? (string)$mv->sales_amount : "";
                        $get_medical_store_detail[$mk]['extra_business'] = $mv->extra_business != null ? (string)$mv->extra_business : "";
                        $get_medical_store_detail[$mk]['scheme_business'] = $mv->scheme_business != null ? (string)$mv->scheme_business : "";
                        $get_medical_store_detail[$mk]['ethical_business'] = $mv->ethical_business != null ? (string)$mv->ethical_business : "";
                    }
                    $total_amount = $mv->sales_amount + $mv->extra_business + $mv->scheme_business + $mv->ethical_business;
                    $get_medical_store_detail[$mk]['total_amount'] = $this->nulltoblank((string)$total_amount);
                    
                    $doctor = $total_doctor == 0 ? $territorist_doctor_detail : $total_doctor;

                    if($doctor == 0 && $remaining_doctor == 0){
                        $get_medical_store_detail[$mk]['remaining_doctor'] = "0/0";    
                    } else {
                        $get_medical_store_detail[$mk]['remaining_doctor'] = $remaining_doctor.'/'.(($total_doctor == 0 ) ? $territorist_doctor_detail : $total_doctor);
                    }

                    $get_medical_store_detail[$mk]['doc'] = $total_doctor;
                    
                    $get_medical_store_detail[$mk]['entry_status'] = $mv->entry_status == 2 ? $mv->entry_status : $mv->priority;
                    $get_medical_store_detail[$mk]['doctors_show'] = $mv->priority == 0 ? 0 : 1; 

                }

                $sales_id = MrWiseStockiestData::where('id',$data['stockist_id'])->where('mr_id',$headers['user-id'])->whereMonth('sales_month', '=', $date_month)->whereYear('sales_month', '=', $date_year)->first();


                if(!is_null($sales_id) && $sales_id->is_completed == 0){
                    $data['confirm_data'] = 0;
                } elseif(!is_null($sales_id) && $sales_id->is_completed == 1){
                    $data['confirm_data'] = 1;
                } elseif(!is_null($sales_id) && $sales_id->is_completed == 2){
                    $data['confirm_data'] = 2;
                } else {
                    $data['confirm_data'] = 0;
                }

                if(!empty($get_medical_store_detail)){
                    $data['total_store'] = $get_medical_store_data->total();
                    $data['stores'] = $get_medical_store_detail;
                    $message = '';

                    return $this->responseSuccess($message,$data);
                } else {
                    // $data['total_store'] = $get_medical_store_data->total();
                    $data['stores'] = [];
                    $message = 'Medicalstore not found!';
                    return $this->responseDatanotFound($message,$data);
                }
                
            } else {

                /*$message = 'Stockiest not found!';
                return $this->responseFailer($message);*/

                $message = 'Medicalstore not found!';
                return $this->responseDatanotFound($message);

            }

        } else {

            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);

        }
    }

    //update amount of medicalstore
    public function updateAmountMedicalstore(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if (!Request::has('stockist_id') || Request::get('stockist_id') == "")
            $errors_array['stockist_id'] = 'Please pass stockist id';

        if (!Request::has('store_id') || Request::get('store_id') == "")
            $errors_array['store_id'] = 'Please pass store id';

        if(count($errors_array) == 0){

            $data = Request::all();

            $get_stockist_data = MrWiseStockiestData::where('id',$data['stockist_id'])->first();

            $query = StockiestWiseMedicalStoreData::where('stockiest_id',($data['stockist_id']));

            //store sales amount
            $store_sales_amount = $query->sum( 'sales_amount' );
            
            //extra business
            $extra_business = $query->sum( 'extra_business' );

            //scheme business
            $scheme_business = $query->sum( 'scheme_business' );

            //ethical business
            $ethical_business = $query->sum( 'ethical_business' );
            
            //check same value
            $check_same_value = $query->where('id',$data['store_id'])->first();  
            
            if((isset($data['sales_amount']) && $data['sales_amount'] != '') && (isset($check_same_value->sales_amount) && ($check_same_value->sales_amount != ''))){
                $amount = $check_same_value->sales_amount;
                $request_amount = $data['sales_amount'];   
            } else {
                $amount = 0;
                $request_amount = 0;
            }

            if((isset($data['extra_business']) && $data['extra_business'] != '') && (isset($check_same_value->extra_business) && ($check_same_value->extra_business != ''))) {
                $amount = $check_same_value->extra_business;
                $request_amount = $data['extra_business'];
            } else {
                $amount = 0;
                $request_amount = 0;
            }

            if((isset($data['scheme_business']) && $data['scheme_business'] != '')  && (isset($check_same_value->scheme_business) && ($check_same_value->scheme_business != ''))){
                $amount = $check_same_value->scheme_business;
                $request_amount = $data['scheme_business'];
            } else {
                $amount = 0;
                $request_amount = 0;
            }

            //ethical business
            if((isset($data['ethical_business']) && $data['ethical_business'] != '')  && (isset($check_same_value->ethical_business) && ($check_same_value->ethical_business != ''))){
                $amount = $check_same_value->ethical_business;     
                $request_amount = $data['ethical_business'];
            } else {
                $amount = 0;
                $request_amount = 0;
            }

            //store total amount
            $store_total_amount = $store_sales_amount + $extra_business + $scheme_business + $ethical_business;
            
            if($amount != 0){
                
                $add_new_amount = $store_total_amount + $amount - $check_same_value->sales_amount - $check_same_value->extra_business - $check_same_value->scheme_business - $check_same_value->ethical_business + $data['sales_amount'] + $data['extra_business'] + $data['scheme_business'] + $data['ethical_business'];

            } else {
                
                $add_new_amount = $store_total_amount;
                $add_new_amount = $store_total_amount - $amount + $request_amount + $data['sales_amount'] + $data['extra_business'] + $data['scheme_business'] + $data['ethical_business'];
                
            }

            if($add_new_amount > $get_stockist_data->amount){
                
                $message = 'Amount exceeded total sales!';
                return $this->responseFailer($message);

            } else {

                //changed on 9th july
                $getSalesData = StockiestWiseMedicalStoreData::where('medical_store_id',$data['store_id'])->where('stockiest_id',$data['stockist_id'])->orderBy('id','desc')->first();

                $update_amount = StockiestWiseMedicalStoreData::findOrFail($getSalesData->id);

                //update status of entry
                if(isset($data['sales_amount']) && $data['sales_amount'] != ''){
                    $update_amount->sales_amount = $data['sales_amount'];
                    $update_amount->priority = 1;
                }

                if(isset($data['extra_business']) && $data['extra_business'] != ''){
                    $update_amount->extra_business = $data['extra_business'];                
                    $update_amount->priority = 1;
                }

                if(isset($data['scheme_business']) && $data['scheme_business'] != ''){
                    $update_amount->scheme_business = $data['scheme_business'];   
                    $update_amount->priority = 1;
                }

                if(isset($data['ethical_business']) && $data['ethical_business'] != ''){
                    $update_amount->ethical_business = $data['ethical_business'];   
                    $update_amount->priority = 1;
                }
                
                $update_amount->submitted_on = date("Y-m-d");
                $update_amount->submitted_by = $headers['user-id'];
                $update_amount->save();

                if($update_amount){

                    $message = 'Amount successfully updated!';
                    return $this->responseSuccess($message);  

                } else {

                    $message = 'Something went wrong!';
                    return $this->responseFailer($message);

                }

            }
            
        } else {

            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);

        }
        
    }

    // Array merger
    public function mergeArray($data){

        $allData = array();

        if(!is_null($data['doctor_id'])){
            foreach ($data['doctor_id'] as $dk => $dv) {
                $allData[$dk]['doctor'] = $dv;
            }
        }

        if(!is_null($data['amount'])){
            foreach ($data['amount'] as $ak => $av) {
                $allData[$ak]['amount'] = $av;
            }
        }

        return $allData;
    }

    // Create date format
    public function createDate($date){

        $da = explode('-',$date);

        return $da[0].'-'.$da[1].'-25';
    }

    // Updated code for multiple doctor amount store
    public function updateDoctorSales(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if (!Request::has('store_id') || Request::get('store_id') == "")
            $errors_array['store_id'] = 'Please pass store id';

        if (!Request::has('doctor_id') || Request::get('doctor_id') == "")
            $errors_array['doctor_id'] = 'Please pass doctor id';

        if (!Request::has('amount') || Request::get('amount') == "")
            $errors_array['amount'] = 'Please pass amount';

        if (!Request::has('entry_status') || Request::get('entry_status') == "")
            $errors_array['entry_status'] = 'Please pass entry status';

        if (!Request::has('stockiest_id') || Request::get('stockiest_id') == "")
            $errors_array['stockiest_id'] = 'Please pass stockiest id';

        if (!Request::has('sales_month_date') || Request::get('sales_month_date') == "")
            $errors_array['sales_month_date'] = 'Please pass sales month date';

        if(count($errors_array) == 0){

            $data = Request::all();

            $salesMonth = $this->createDate($data['sales_month_date']);
            //$salesMonth = '2021-12-25';

            // Sum of all requested amount
            $updatedAmount = array_sum($data['amount']);

            //old code
            //$stockiest_id = $update_amount->stockiest_id;
            
            //New code
            $stockiest_id = $data['stockiest_id'];

            // Get total sum of perticular medical store
            $storeSalesAmount = StockiestWiseMedicalStoreData::where('medical_store_id',$data['store_id'])
                                                             ->where('stockiest_id', $data['stockiest_id'])
                                                             ->where('sales_month',$salesMonth)
                                                             ->first();

            // Check if new amount is exceeded or not          
            if($updatedAmount > $storeSalesAmount->sales_amount){
                return $this->responseFailer('Amount exceeded total sales!');
            } else {   

                $allData = $this->mergeArray($data);

                if(!is_null($allData)){
                    foreach ($allData as $ak => $av) {
                        // Update amount of doctors sales
                        $update_amount = MedicalStoreDoctorData::findOrFail($av['doctor']);
                        $old_amount = $update_amount->sales_amount;
                        $update_amount->sales_amount = $av['amount'] ? $av['amount'] : null; 
                        $update_amount->submitted_by = $headers['user-id']; 
                        $update_amount->submitted_on = date("Y-m-d");
                        $update_amount->priority = 1;
                        
                        $allData[$ak]['old_amount'] = $old_amount ? $old_amount : 0;
                        $current_date = $update_amount->sales_month;
                        if($update_amount->isDirty()){   
                            $update_amount->previous_sales_amount = $old_amount;
                            $update_amount->is_considered = 0;
                        }
                        $update_amount->save();
                    }
                }

                if(!is_null($allData)){
                    foreach ($allData as $ak => $av) {

                        $getDoctorDetail = MedicalStoreDoctorData::with(['commission'])->where('id',$av['doctor'])->first();

                        $getDoctorSales = MedicalStoreDoctorData::where('doctor_profile',$getDoctorDetail->doctor_profile)
                                                                ->where('doctor_id',$getDoctorDetail->doctor_id)->where('sales_month',$salesMonth)->first();

                        if(!is_null($getDoctorSales)){

                            // Sum of sales amount of doctors
                            $getTotalSale = MedicalStoreDoctorData::where('doctor_profile',$getDoctorDetail->doctor_profile)
                                                                ->where('doctor_id',$getDoctorDetail->doctor_id)->where('sales_month',$salesMonth)->sum('sales_amount');

                            $getDoctorOffset = DoctorOffset::where('profile_id',$getDoctorDetail->doctor_profile)
                                                           ->where('doctor_id',$getDoctorDetail->doctor_id)
                                                           ->orderBy('id','DESC')
                                                           ->first();
                            
                            // Last month sales
                            $lastMonthSales = !is_null($getDoctorOffset) ? $getDoctorOffset->carry_forward : 0;
                            $amount = $av['amount'] != null ? $av['amount'] : 0;
                            
                            $carrryForwardAmount = 0;

                            if($lastMonthSales > 0){
                                $carrryForwardAmount = $lastMonthSales + $av['old_amount'];
                            } else {
                                $carrryForwardAmount = $lastMonthSales - $av['old_amount'];
                            }

                            if(!is_null($getDoctorDetail) && !is_null($getDoctorDetail->commission)){

                                // Total sales
                                if($lastMonthSales != 0){
                                    $totalSales = $amount + $carrryForwardAmount;
                                } else {
                                    $totalSales = $amount + 0;
                                }
                                
                                // Eligibility 
                                $eligibility = ($totalSales * $getDoctorDetail->commission->commission) / 100;
                                
                                // Target
                                $target = 0;
                                
                                // Carry forward amount
                                $carry_forward  = $totalSales - $target;

                                $saveoffset = new DoctorOffset;
                                $saveoffset->last_month_sales = $getTotalSale ? $getTotalSale : 0;
                                $saveoffset->last_month_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
                                $saveoffset->target_previous_month_date = $current_date;
                                $saveoffset->carry_forward = $carry_forward;
                                $saveoffset->carry_forward_date = $current_date;
                                $saveoffset->eligible_amount = $eligibility;
                                $saveoffset->eligible_amount_date = $current_date;
                                $saveoffset->profile_id = $getDoctorDetail->doctor_profile;
                                $saveoffset->doctor_id = $getDoctorDetail->doctor_id;
                                $saveoffset->previous_second_month_sales = !is_null($getDoctorOffset) ? $getDoctorOffset->previous_second_month_sales  : 0;
                                $saveoffset->previous_second_month_date = date('Y-m-d', strtotime('-1 month', strtotime($current_date)));
                                $saveoffset->previous_third_month_date = date('Y-m-d', strtotime('-2 month', strtotime($current_date)));
                                $saveoffset->previous_third_month_sales = !is_null($getDoctorOffset) ? $getDoctorOffset->previous_third_month_sales : 0;
                                $saveoffset->target_previous_month = 0;
                                $saveoffset->save();

                            }
                        }                                                             
                    }
                }

                $storeEntryStatus = StockiestWiseMedicalStoreData::where('id',$data['store_id'])->update(['entry_status' => $data['entry_status']]);

                if($update_amount){
                    return $this->responseSuccess('Amount successfully updated!');
                } else {
                    return $this->responseFailer('Something went wrong!');
                }
            } 
        } else {
            return $this->responseFailer('errors',$errors_array);
        }
    }

    // Update confirm data
    public function updateConfirmData(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if(count($errors_array) == 0){
            $data = Request::all();

            if(isset($data['stockist_id']) && (isset($data['is_completed']))){

                $update_status = MrWiseStockiestData::where('id',$data['stockist_id'])->where('mr_id',$headers['user-id'])->update(['is_completed' => $data['is_completed']]);

                $update_status = StockiestWiseMedicalStoreData::where('stockiest_id',$data['stockist_id'])->where('mr_id',$headers['user-id'])->update(['entry_status' => 2]);
                
            } else if (isset($data['sales_month'])) {
                
                $query = MrWiseStockiestData::query();
                $date = explode('-',$data['sales_month']);
                $query->where('mr_id',$headers['user-id']);
                $query->whereMonth('sales_month', '=', $date[0]);
                $query->whereYear('sales_month', '=', $date[1]);
                $update_status = $query->update(['is_confirm_data' => 1]);
                
                //sales history confirm
                $query = SalesHistory::query();
                $date = explode('-',$data['sales_month']);
                $query->where('mr_id',$headers['user-id']);
                $query->whereMonth('sales_month', '=', $date[0]);
                $query->whereYear('sales_month', '=', $date[1]);
                $update_status = $query->update(['is_submited' => 1,'submitted_on' => date("Y-m-d")]);
                
            }

            if($update_status){

                $message = 'Successfully confirm!';
                return $this->responseSuccess($message);  

            } else {

                $message = 'Something went wrong!';
                return $this->responseFailer($message);

            }

        } else {

            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);

        }
    }

    // Update doctor payment
    public function updateDoctorPayment(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if (!Request::has('request_id') || Request::get('request_id') == "")
            $errors_array['request_id'] = 'Please pass request id';

        if(count($errors_array) == 0){

            $data = Request::all();

            $current_date = date("Y-m-d");

            //check if amount is paid to doctor or not 
            if(isset($data['paid_to_doctor']) && $data['paid_to_doctor']  != ''){

                $update_request = AllRequest::where('id',$data['request_id'])
                                            ->update([
                                                'is_paid_to_doctor' => $data['paid_to_doctor'],
                                                'paid_on' => $current_date
                                            ]);    

            } else {

                //if not paid to doctor then add recived amount in doctor 
                if(isset($data['received']) && $data['received']  != ''){

                    $update_request = AllRequest::where('id',$data['request_id'])
                                                ->update([
                                                    'received_by_mr' => $data['received'],
                                                    'received_on' => $current_date
                                                ]);        
                }                
            }

            if(isset($update_request)){

                $message = 'Payment status successfully updated!';
                $current_date = date("j M,Y");
                $data = $current_date;
                return $this->responseSuccess($message,$data);  

            } else {

                $message = 'Pass all parameter!';
                return $this->responseFailer($message);
            }           

        } else {

            $errors = $errors_array;
            $message = 'errors';
            return $this->responseFailer($message,$errors);
        }
    }

    // Doctors list
    public function doctorsList(){

        $this->LogInput();
        $errors_array = array();
        $headers = apache_request_headers();

        if (!isset($headers['user-id']) || $headers['user-id'] == "")
            $errors_array['user-id'] = 'Please pass user id';

        if (!Request::has('stockist_id') || Request::get('stockist_id') == "")
            $errors_array['stockist_id'] = 'Please pass stockist id';

        if (!Request::has('store_id') || Request::get('store_id') == "")
            $errors_array['store_id'] = 'Please pass store id';

        if(count($errors_array) == 0){
            $data = Request::all();

            //if doctor not in database
            //================================            
            $date = explode(' ',$data['sales_month']);
            $date_month = date("m", strtotime($date[0]));
            $current_month = date('m');
            $current_year = date('Y');
            $salesMonth = $date[1].'-'.$date_month.'-25';

            $query = MedicalStoreDoctorData::where('mr_id',$headers['user-id'])->where('stockiest_id',$data['stockist_id'])->where('medical_store_id',$data['store_id'])->where('is_delete',0)->with(['stockiest_detail'])->whereMonth('sales_month',$date_month)->whereYear('sales_month',$date[1]);

            if(isset($data['doctor_name']) && $data['doctor_name'] != ''){
                $doctor_name = $data['doctor_name'];
                $query->whereHas('doctor_detail', function ($query) use ($doctor_name) { 
                    $query->where('full_name', 'like','%' . $doctor_name . '%'); })->orWhereHas('profile_detail', function ($query) use ($doctor_name) { 
                        $query->where('profile_name', 'like','%' . $doctor_name . '%'); })
                    ->where('medical_store_id',$data['store_id'])->where('is_delete',0);
            } else {
                $query->with(['doctor_detail','profile_detail']);
            }
            $getDoctorData = $query->paginate(20);

            $total_doctor = MedicalStoreDoctorData::where('mr_id',$headers['user-id'])->where('stockiest_id',$data['stockist_id'])->where('medical_store_id',$data['store_id'])->where('is_delete',0)->whereMonth('sales_month',$date_month)->whereYear('sales_month',$date[1])->count();

            $remaining_doctor = MedicalStoreDoctorData::where('mr_id',$headers['user-id'])->where('stockiest_id',$data['stockist_id'])->where('medical_store_id',$data['store_id'])->where('is_delete',0)->whereMonth('sales_month',$date_month)->whereYear('sales_month',$date[1])->where('sales_amount','!=','')->count();

            if(!is_null($getDoctorData)){
                $doctor_data = array();

                foreach ($getDoctorData as $dk => $dv) {

                    $date = date('Y-m-d');
                     
                    $getCommision = DoctorCommission::where('profile_id',$dv->doctor_profile)
                                                    ->where('doctor_id',$dv->doctor_id)
                                                    ->whereDate('start_date','<=',$date)
                                                    ->whereDate('end_date','>=',$date)
                                                    ->first();
                    
                    $doctor_data[$dk]['id'] = $this->nulltoblank($dv->id);
                    $doctor_data[$dk]['doctor_id'] = $dv->doctor_id;
                    $doctor_data[$dk]['store_id'] = $this->nulltoblank($dv->medical_store_id);
                    $doctor_data[$dk]['stockist_id'] = $this->nulltoblank($dv->stockiest_id);
                    $doctor_data[$dk]['is_commision_added'] = !is_null($getCommision) ? true : false;

                    if($dv['profile_detail']['profile_name'] != ''){
                        $doctor_data[$dk]['doctor_name'] = $this->nulltoblank($dv['doctor_detail']['full_name'] .'('. $dv['profile_detail']['profile_name'] .')' );    
                    } else {
                        $doctor_data[$dk]['doctor_name'] = $this->nulltoblank($dv['doctor_detail']['full_name']);    
                    }
                    
                    $doctor_data[$dk]['sales_month'] = $this->nulltoblank(date('F Y',strtotime($dv->sales_month)));
                    $doctor_data[$dk]['sales_amount'] = $dv->sales_amount != null ? (string)$dv->sales_amount : "";

                }
                
                if(!empty($doctor_data)){
                    $data['total_doctor'] = $getDoctorData->total();
                    $data['remaining_doctor'] = $remaining_doctor.'/'.$total_doctor;
                    $data['doctors'] = $doctor_data;
                    $message = '';

                    return $this->responseSuccess($message,$data);
                } else {
                    $data['doctors'] = [];
                    $message = 'Requests not found!';
                    return $this->responseDatanotFound($message,$data);
                }

            } else {
                $message = 'Doctors not found!';
                return $this->responseDatanotFound($message);
            } 

        } 
    }
}   

?>