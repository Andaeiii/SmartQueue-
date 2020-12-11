<?php

namespace App;

use Illuminate\Database\Schema\Blueprint;
use Schema;

use Illuminate\Database\Eloquent\Model;

class FuelLog extends Basemodel{
    
    protected $table = 'fuel_logs';

    public function station(){
    	return $this->belongsTo('App\Station', 'station_id');
    }

    public static function migrate(){
    	Schema::dropIfExists('fuel_logs');
	 	Schema::create('Fuel_logs', function(Blueprint $table){
	 		$table->increments('id');
	 		$table->integer('station_id');
	 		$table->integer('fuel_id');

	 		$table->integer('morning');
	 		$table->integer('afternoon');
	 		$table->integer('evening');

	 		$table->text('ext_info');
	 		$table->timestamps();
	 	});

	 	echo 'table migrated successfully...';

    }

}
