<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Basemodel{
    
    protected $table = "states";

    public $timestamps = false;

    public function station(){
    	return $this->hasMany('App\Station', 'state_id');
    }

    public function lgas(){
    	return $this->hasMany('App\Lga', 'state_id');
    }
  
}
