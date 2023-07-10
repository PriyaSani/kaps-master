<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    public function doctor_detail(){
    	return $this->hasOne('App\Model\DoctorDetail','id','doctor_id');
    }	

    public function doctor_offset(){
    	return $this->hasOne('App\Model\DoctorOffset','doctor_id','doctor_id','profile_id','profile_id')->orderBy('end_date','DESC');		
    }

    public function doctor_commission(){
    	return $this->hasOne('App\Model\DoctorCommission','profile_id','id')->orderBy('end_date','DESC')->where('is_delete',0);
    }
}
