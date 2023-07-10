<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MedicalStoreDoctorData extends Model
{	

    public function profile_detail(){
        return $this->hasOne('App\Model\DoctorProfile','id','doctor_profile');
    }

	public function doctor_detail(){
    	return $this->hasOne('App\Model\DoctorDetail','id','doctor_id');
    }

    public function store_detail(){
    	return $this->hasOne('App\Model\StockiestWiseMedicalStoreData','id','medical_store_id');
    }

    public function stockiest_detail(){
    	return $this->hasOne('App\Model\Stockiest','id','stockiest_id');
    }

    public function mr_detail(){
    	return $this->hasOne('App\Model\MrDetail','id','mr_id');
    }

    public function commission(){
        return $this->hasOne('App\Model\DoctorCommission','profile_id','doctor_profile','doctor_id','doctor_id')->orderBy('id','DESC')->where('is_delete',0);     
    }
}
