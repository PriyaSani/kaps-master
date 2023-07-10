<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DoctorRequestTerritorry extends Model
{
    public function territory_name(){
        return $this->hasOne('App\Model\Territory','id','territory_id');
    }

    public function sub_territory_name(){
        return $this->hasOne('App\Model\SubTerritory','id','sub_territory_id');
    }
}
