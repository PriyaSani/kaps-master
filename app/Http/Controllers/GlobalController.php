<?php

namespace App\Http\Controllers;

use Auth;
use Request;
use Response;
use App\Model\UserToken;
use App\Model\UserTerritory;
use Illuminate\Support\Str;

class GlobalController extends Controller
{   
    //Convert Date Format
    public function convertDate($date){
        $date = explode('/',$date);
        return $date[2]."-".$date[1]."-".$date[0];
    }
    
	//GENERATE UUID
    public function generateUUID(){
		return (string) Str::uuid();
    }

    //Upload image
    public function uploadImage($image,$path){

        $imagedata = $image;
        $destinationPath = 'uploads/'.$path;
        $extension = $imagedata->getClientOriginalExtension(); 
        $fileName = rand(11111,99999).'.'.$extension;
        $imagedata->move($destinationPath, $fileName);

        return $fileName;
    }

    //String genrater
    public function randomStringGenerater($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    //User app token genrate
    public function updateUserAppToken($headers,$user_id){

        $randToken = $this->randomStringGenerater(32);
        $usertoken = UserToken::where('device_token',$headers['device-token'])
                            ->update(['app_token' => $randToken,'user_id' => $user_id]);

        if($usertoken){
            return $randToken;
        } else {
            return false;
        }
    }

    //Log file
    public function Append($log_file, $value)
    {   
        \File::append($log_file, $value . "\r\n");
    }

    //Log input
    public function LogInput()
    {
        $log_file = storage_path() . '/logs/api' . date('Ymd') . '.log';
        $headers = apache_request_headers();

        $this->Append($log_file,'----------------' . debug_backtrace()[1]['function'] . ' --------------');
        $this->Append($log_file,'Request Info : ');
        $this->Append($log_file,'Date: ' . date('Y-m-d H:i:s') . '    IP: ' .  Request::ip());
        $this->Append($log_file,'User-Agent: ' .  Request::header('User-Agent'));
        $this->Append($log_file,'URL: ' .  Request::url());
        $this->Append($log_file,'Input Parameters: ' .  json_encode(Request::all()));
        $this->Append($log_file,'Headers Parameters: ' .  json_encode($headers));
        $this->Append($log_file,'-----------');
        return;
    }

    //Log output
    public function LogOutput($output)
    {
        $log_file = storage_path() . '/logs/api' . date('Ymd') . '.log';
        $this->Append($log_file, 'Output: ');
        $this->Append($log_file,$output);
        $this->Append($log_file,'--------------------END------------------------');
        $this->Append($log_file,'');
        return;
    }

    //200 success response
    public function responseSuccess($message = NULL,$data = NULL){

        if (empty($data)) {

            $this->LogOutput(Response::json(array('status'=>'success','status_code' => 200,'message' => $message)));
            return Response::json(array('status'=>'success','status_code' => 200,'message' => $message),200);

        }else{
            if($message != '' && $data != ''){

                $this->LogOutput(Response::json(array('status'=>'success','status_code' => 200,'message' => $message,'data' => $data)));
                return Response::json(array('status'=>'success','status_code' => 200,'message' => $message,'data' => $data),200);

            } else {

                $this->LogOutput(Response::json(array('status'=>'success','status_code' => 200,'data' => $data)));
                return Response::json(array('status'=>'success','status_code' => 200,'data' => $data),200);
            }
            
        }
    }

    //500 failer response
    public function responseFailer($message,$errors = NULL){
        
        if (empty($errors)) {
            
            $this->LogOutput(Response::json(array('status'=>'failer','status_code'=>500,'message' => $message)));
            return Response::json(array('status'=>'failer','status_code'=>500,'message' => $message),500);

        } else {
            
            if($message == ''){

                $this->LogOutput(Response::json(array('status'=>'failer','status_code'=>500,'errors' => $errors)));
                return Response::json(array('status'=>'failer','status_code'=>500,'errors' => $errors),500);

            } else {

                $this->LogOutput(Response::json(array('status'=>'failer','status_code'=>500,'message' => $message,'errors' => $errors)));
                return Response::json(array('status'=>'failer','status_code'=>500,'message' => $message,'errors' => $errors),500);

            }
            
        }
        
    }

    //401 Not authorized (not logged in) or user not found
    public function responseUnauthorized($message,$errors = NULL){

        if (empty($errors)) {
            
            $this->LogOutput(Response::json(array('status'=>'failer','status_code'=>401,'message' => $message)));
            return Response::json(array('status'=>'failer','status_code'=>401,'message' => $message),401);

        }else{
            
            if($message == ''){

                $this->LogOutput(Response::json(array('status'=>'failer','status_code'=>401,'errors' => $errors)));
                return Response::json(array('status'=>'failer','status_code'=>401,'errors' => $errors),401);

            } else {

                $this->LogOutput(Response::json(array('status'=>'failer','status_code'=>401,'message' => $message,'errors' => $errors)));
                return Response::json(array('status'=>'failer','status_code'=>401,'message' => $message,'errors' => $errors),401);

            }
            
        }
    }

    //201 success response
    public function responseDatanotFound($message,$data = NULL){
        
        if (empty($data)) {
            
            $this->LogOutput(Response::json(array('status'=>'failer','status_code'=>201,'message' => $message)));
            return Response::json(array('status'=>'failer','status_code'=>201,'message' => $message),201);

        } else {
            
            if($message == ''){

                $this->LogOutput(Response::json(array('status'=>'failer','status_code'=>201,'data' => $data)));
                return Response::json(array('status'=>'failer','status_code'=>201,'data' => $data),201);

            } else {

                $this->LogOutput(Response::json(array('status'=>'failer','status_code'=>201,'message' => $message,'data' => $data)));
                return Response::json(array('status'=>'failer','status_code'=>201,'message' => $message,'data' => $data),201);

            }
            
        }
        
    }

    // User territory
    public function userTerritory($id){

        $get_user_territory = UserTerritory::where('employee_id',Auth::guard()->user()->id)->where('territories_id','!=','')->pluck('territories_id')->toArray();

        return $get_user_territory;
    } 

    // User sub territory
    public function userSubTerritory($id){

        $get_user_sub_territory = UserTerritory::where('employee_id',Auth::guard()->user()->id)->where('sub_territories','!=','')->pluck('sub_territories')->toArray();

        return $get_user_sub_territory;
    }
}
