<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DoctorDetail extends Model
{
    public function territory_name(){
        return $this->hasOne('App\Model\DoctorTerritory','doctor_id','id');
    }

    public function get_doctor_territory(){
        /*return $this->hasMany('App\Model\DoctorTerritory','doctor_id','id');*/
        return $this->hasOne('App\Model\DoctorTerritory','doctor_id','id');
    }

    public function get_territory(){
        return $this->hasMany('App\Model\DoctorTerritory','doctor_id','id');
        /*return $this->hasOne('App\Model\DoctorTerritory','doctor_id','id');*/
    }
    public function territory_detail(){
        return $this->hasMany('App\Model\DoctorTerritory','doctor_id','id');
    }

    public function profile(){
        return $this->hasOne('App\Model\DoctorProfile','doctor_id','id');
    }
}
