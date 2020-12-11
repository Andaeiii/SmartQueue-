<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Schema;

class Atikuser extends Basemodel{

    protected $table = 'atiku_users';

	protected $guarded = [];

	 public static function migrate(){

    	Schema::dropIfExists('atiku_users');
	 	Schema::create('atiku_users', function(Blueprint $table){

	 		$table->increments('id');
	 		$table->string('fullname');
	 		$table->string('email');	 		
	 		$table->string('phone');
	 		$table->string('pvc');
	 		//$table->string('long');
	 		//$table->string('lat');
	 		$table->timestamps();
	 	});

	 	echo 'photos migrated successfully...';

    }
}
