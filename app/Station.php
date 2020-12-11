<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Schema;

class Station extends Basemodel{

	protected $guarded = [];

    protected $table = "stations";

    public function code(){
    	return $this->hasOne('App\Code', 'station_id');
    }

    public function state(){
    	return $this->belongsTo('App\State', 'state_id');
    }

    public function company(){
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function queues(){
    	return $this->hasMany('App\SmartQueue', 'station_id');
    }

    public function stationlogs(){
    	return $this->hasMany('App\StationLog', 'station_id');
    }

    public function fuellogs(){
    	return $this->hasMany('App\FuelLog', 'station_id');
    }    

    public static function migrate(){

    	Schema::dropIfExists('stations');
	 	Schema::create('stations', function(Blueprint $table){

	 		$table->increments('id');

	 		$table->integer('company_id');
	 		$table->string('fullname');
	 		$table->string('branch');

	 		$table->integer('state_id');
	 		$table->integer('lga_id');
	 		$table->string('town');

	 		$table->string('street');
	 		
/******done with phone app *********/

	 		$table->time('open_time');
	 		$table->time('close_time');

	 		$table->string('lng');
	 		$table->string('lat');

	 		$table->integer('functional_pumps_num');
	 		$table->integer('total_pumps');
	 		$table->integer('capacity');

/******done with phone app *********/

	 		$table->timestamps();
	 	});

	 	echo 'table migrated successfully... - xx';

    }



}
