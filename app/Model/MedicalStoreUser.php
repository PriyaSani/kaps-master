<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MedicalStoreUser extends Model
{
    public function user_detail(){
    	return $this->hasOne('App\Model\AssociatedUser','id','associated_user_id')->where('is_delete',0);
    }

    public function store_detail(){
    	return $this->hasOne('App\Model\MedicalStore','id','medical_store_id')->where('is_delete',0);
    }

    public function medical_store_territory(){
        return $this->hasMany('App\Model\MedicalStoreTerritory','medical_store_id','medical_store_id');
    }
}
