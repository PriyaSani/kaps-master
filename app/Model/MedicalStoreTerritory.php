<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MedicalStoreTerritory extends Model
{
    public function territory_name(){
        return $this->hasOne('App\Model\Territory','id','territories_id');
    }

    public function sub_territory(){
        return $this->hasOne('App\Model\SubTerritory','id','sub_territories');
    }
}
