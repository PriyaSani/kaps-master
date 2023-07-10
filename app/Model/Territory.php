<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Territory extends Model
{
    public function get_city(){
        return $this->hasOne('App\Model\City','id','territory_id');
    }
    public function get_state(){
        return $this->hasOne('App\Model\State','id','state_id');
    }
}
