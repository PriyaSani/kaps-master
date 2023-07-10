<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StockiestWiseMedicalStoreData extends Model
{	
	public function store_detail(){
    	return $this->hasOne('App\Model\MedicalStore','id','medical_store_id');
    }

    public function stockiest_detail(){
    	return $this->hasOne('App\Model\MrWiseStockiestData','id','stockiest_id');
    }

    public function mr_detail(){
    	return $this->hasOne('App\Model\MrDetail','id','mr_id');
    }

}
