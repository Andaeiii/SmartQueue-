<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Schema\Blueprint;
use Schema;

class Fuel extends Basemodel{

	public $timestamps = false;
	protected $guarded = [];
	
	protected $table = "fuels";


	public function logs(){
		$this->hasMany('App/FuelLog', 'fuel_id');
	}

    public static function migrate(){

    	Schema::dropIfExists('fuels');
	 	Schema::create('fuels', function(Blueprint $table){
			$table->increments('id');
			$table->string('name');
		});

		$ar = explode(';','Petrol;Diesel;Kerosine;Gas');
		foreach($ar as $r){
			self::create([
				'name'=>$r
			]);
		}
		echo 'data_created...';
	}


}
