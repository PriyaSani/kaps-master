<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MrTerritory extends Model
{
    public function territory_name(){
        return $this->hasOne('App\Model\Territory','id','territories_id');
    }

    public function mr_detail(){
        return $this->hasOne('App\Model\MrDetail','id','mr_id')->where('is_delete','0');
    }

    public function sub_territory(){
        return $this->hasOne('App\Model\SubTerritory','id','sub_territories');
    }
}
