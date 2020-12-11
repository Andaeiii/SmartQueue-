<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Schema;

class Code extends Basemodel{

   protected $table = 'codes';

   public function station(){
   	 return $this->belongsTo('App\Station', 'station_id');
   }

   public static function migrate(){

    	Schema::dropIfExists('codes');
	 	Schema::create('codes', function(Blueprint $table){
	 		$table->increments('id');
	 		$table->string('station_id');
	 		$table->string('retail_num');
	 		$table->timestamps();
	 	});

	 	echo 'table migrated successfully...';

    }


   public static function generateRetailNumber(){
		$characters = '1234567890';
		$pin = mt_rand(1000000, 9999999). mt_rand(1000000, 9999999). $characters[rand(0, strlen($characters) - 1)];
		$pin2 = mt_rand(1000000, 9999999). mt_rand(1000000, 9999999). $characters[rand(0, strlen($characters) - 1)];
		
		$string = substr(str_shuffle($pin), 0, 10);
		$str2 = substr(str_shuffle($pin2), -3, 3);

		$num = '00'. $str2 .'-'.$string;

		if(self::where('retail_num', $num)->count() > 0){
			self::generateRetailNumber();
		}else{
			return $num;
		}
	}


}
