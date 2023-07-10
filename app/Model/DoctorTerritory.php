<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DoctorTerritory extends Model
{
    public function territory_name(){
        return $this->hasOne('App\Model\Territory','id','territories_id');
    }

    public function doctor_detail(){
        return $this->hasOne('App\Model\DoctorDetail','id','doctor_id')->where('is_delete','0');
    }

    public function sub_territory(){
        return $this->hasOne('App\Model\SubTerritory','id','sub_territories');
    }
}
