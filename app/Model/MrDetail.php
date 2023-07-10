<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MrDetail extends Authenticatable
{	
	use Notifiable;

    public function get_territory(){
        return $this->hasMany('App\Model\MrTerritory','mr_id','id');
    }

    public function territory_detail(){
        return $this->hasOne('App\Model\MrTerritory','mr_id','id');
    }

    public function salsehistory(){
        return $this->hasOne('App\Model\SalesHistory','mr_id','id');
    }

    public function generateToken($headers){
        $randToken = $this->randomString(16);
        $usertoken = new UserToken;
        $usertoken->device_token = $randToken;
        $usertoken->device_type = $headers['device-type'];
        if(isset($headers['fcm-token']) && $headers['fcm-token'] != ''){
            $usertoken->fcm_token = $headers['fcm-token'];
        }
        $usertoken->version = $headers['version'];
        $usertoken->save();
        if($usertoken){
            return $randToken;
        } else {
            return false;
        }
    }

    public function randomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function userToken(){
        return $this->hasMany('App\Models\UserToken','user_id','id');
    }
}
