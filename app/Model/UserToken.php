<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    public function user(){
        return $this->hasMany('App\Models\MrDetail','id','user_id');
    }
}
