<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model{
    
    protected $table = 'fuel_logs';
    
    public $timestamps = false;

    public function station(){
    	return $this->belongsTo('App\Station', 'station_id');
    }

    public function fuel(){
    	return $this->belongsTo('App\Fuel', 'fuel_id');
    }

}
