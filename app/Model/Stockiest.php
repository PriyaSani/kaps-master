<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Stockiest extends Model
{
    public function stockiest_user(){
    	return $this->hasMany('App\Model\StockiestUser','stockiest_id','id')->where('is_delete',0);
    }

    public function stockiest_territories(){
    	return $this->hasMany('App\Model\StockiestTerritory','stockiest_id','id')->where('is_delete',0);
    }	
}
