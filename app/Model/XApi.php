<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class XApi extends Model
{
   protected $table = 'x_apis';

   public static function checkXAPI($x_api,$platform) {
   	$get_x_api = XApi::select('api_key')->where('api_key', $x_api)->where('platform', $platform)->first();
   	
   	if($get_x_api){
   	
	   	if($get_x_api->api_key == $x_api){

	   		return true;

	   	} else {

	   	return false;

	   	}	
   	} else {
		return false;
   	}
   	
   }
}
