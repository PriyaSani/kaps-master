<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MedicalStore extends Model
{
    public function medical_store_user(){
    	return $this->hasMany('App\Model\MedicalStoreUser','medical_store_id','id')->where('is_delete',0);
    }	

    public function mendical_store_territories(){
    	return $this->hasMany('App\Model\MedicalStoreTerritory','medical_store_id','id')->where('is_delete',0);
    }	
}

