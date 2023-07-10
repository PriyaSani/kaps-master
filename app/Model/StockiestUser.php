<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StockiestUser extends Model
{
    public function stockiest_user_detail(){
    	return $this->hasOne('App\Model\AssociatedUser','id','associated_user_id')->where('is_delete',0);
    }

    public function stockiest_detail(){
    	return $this->hasOne('App\Model\Stockiest','id','stockiest_id')->where('is_delete',0);
    }

    public function stockiest_territory(){
        return $this->hasMany('App\Model\StockiestTerritory','stockiest_id','stockiest_id');
    }
}
