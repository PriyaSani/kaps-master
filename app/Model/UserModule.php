<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserModule extends Model
{
    public function module(){
    	return $this->hasOne('App\Model\Module','id','module_id');
    }
}
