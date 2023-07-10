<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MrWiseStockiestData extends Model
{	
	public function stockiest_detail(){
    	return $this->hasOne('App\Model\Stockiest','id','stockiest_id');
    }

    public function mr_detail(){
    	return $this->hasOne('App\Model\MrDetail','id','mr_id');
    }

    public function medical_store(){
    	return $this->hasMany('App\Model\StockiestWiseMedicalStoreData','stockiest_id','id')->orWhereNotNull('sales_amount')->orWhereNotNull('extra_business')->orWhereNotNull('scheme_business')->orWhereNotNull('ethical_business');
    }

    public function doctor(){
    	return $this->hasMany('App\Model\MedicalStoreDoctorData','stockiest_id','id')->orWhereNotNull('sales_amount');
    }
}
