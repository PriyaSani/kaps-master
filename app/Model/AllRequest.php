<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AllRequest extends Model
{
    public function doctor_detail(){
    	return $this->hasOne('App\Model\DoctorDetail','id','doctor_id');
    }

    public function main_territory_detail(){
        return $this->hasMany('App\Model\DoctorRequestTerritorry','request_id','id');  
    }

    public function sub_territory_detail(){
        return $this->hasMany('App\Model\DoctorRequestTerritorry','request_id','id');    
    }

    public function mr_detail(){
        return $this->hasOne('App\Model\MrDetail','id','submitted_by'); 
    }

    public function profile_detail(){
        return $this->hasOne('App\Model\DoctorProfile','id','profile_id');
    }

    public function commission(){
        return $this->hasOne('App\Model\DoctorCommission','doctor_id','doctor_id','profile_id','profile_id')->orderBy('end_date','DESC')->where('is_delete',0);     
    }
}
