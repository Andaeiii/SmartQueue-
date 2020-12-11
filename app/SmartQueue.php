<?php

namespace App;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Illuminate\Database\Eloquent\Model;

class SmartQueue extends Basemodel{

    protected $table = "smart_queues";
    protected $guarded = [];

    public function station(){
    	return $this->belongsTo('App\Station', 'station_id');
    }

    public static function migrate(){

    	Schema::dropIfExists('smart_queues');
	 	Schema::create('smart_queues', function(Blueprint $table){
			$table->increments('id');
			$table->string('name');
			$table->integer('station_id');
			$table->string('vec_num');
			$table->string('vec_model');
			$table->string('vec_color');
			$table->string('tag_number');
			$table->string('sq_number');
			$table->string('status'); //signed in/out.
			$table->timestamps();
		});

	 	echo 'table migrated successfully...';

	}

}
