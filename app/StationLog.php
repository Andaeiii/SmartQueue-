<?php

namespace App;

use Illuminate\Database\Schema\Blueprint;
use Schema;

use Illuminate\Database\Eloquent\Model;

class StationLog extends Model{
    
	protected $guarded = [];
	
	protected $table = "station_logs";

	public function station(){
		return $this->belongsTo('App\Station', 'station_id');

	}
    public static function migrate(){

    	Schema::dropIfExists('station_logs');
	 	Schema::create('station_logs', function(Blueprint $table){
			$table->increments('id');
			$table->integer('station_id');

			$table->string('log_status'); //constants.. 
			$table->text('log_description');

			$table->text('remarks');
			
			$table->timestamps();
		});

		echo 'table migrated successfully...';
	}


}
