<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SalesHistory extends Model
{
    public function mr_detail(){
    	return $this->hasOne('App\Model\MrDetail','id','mr_id');
    }

    public function user_detail(){
    	return $this->hasOne('App\Model\User','id','confirm_by_id');
    }

    public function get_mr_territory(){
        return $this->hasMany('App\Model\MrTerritory','mr_id','mr_id');        
    }
}
