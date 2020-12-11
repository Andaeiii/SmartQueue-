<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Schema;

class Atikuphoto extends Basemodel{

    protected $table = 'atiku_photos';

	protected $guarded = [];

	 public static function migrate(){

    	Schema::dropIfExists('atiku_photos');
	 	Schema::create('atiku_photos', function(Blueprint $table){

	 		$table->increments('id');
	 		$table->string('imgfile');
	 		
	 		$table->string('title');
	 		$table->string('description');

	 		$table->timestamps();
	 	});

	 	echo 'photos migrated successfully...';

    }
}
