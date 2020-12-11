<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Schema\Blueprint;
use Schema;

class Company extends Model{

	protected $table = 'companys';

	protected $guarded = [];

	public function stations(){
		return $this->hasMany('App\Station', 'company_id');
	}


    public static function migrate(){

    	Schema::dropIfExists('companys');
	 	Schema::create('companys', function(Blueprint $table){

	 		$table->increments('id');
	 		$table->string('fullname');
	 		$table->string('sap_code');
	 		$table->string('rc_number');
	 		$table->string('email');
	 		$table->string('phone');
	 		$table->text('address'); 

	 		//$table->string('state');


	 		$table->timestamps();
	 	});

	 	echo 'table migrated successfully...';

    }
    //
}
