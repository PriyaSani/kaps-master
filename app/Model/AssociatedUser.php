<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AssociatedUser extends Model
{
    public function medical_store_user(){
        return $this->hasMany('App\Model\MedicalStoreUser','associated_user_id','id')->where('is_delete',0); 
    }

    public function stockiest_user(){
        return $this->hasMany('App\Model\StockiestUser','associated_user_id','id')->where('is_delete',0);
    }
}
