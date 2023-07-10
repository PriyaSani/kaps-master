<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DoctorOffset extends Model
{
    public function mr_detail(){
    	return $this->hasOne('App\Model\MrDetail','id','submitted_by');	
    }

    public function commission(){
    	return $this->hasOne('App\Model\DoctorCommission','profile_id','profile_id','doctor_id','doctor_id')->orderBy('end_date','DESC')->where('is_delete',0);		
    }
}
