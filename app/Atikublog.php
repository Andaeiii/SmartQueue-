<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Schema;

class Atikublog extends Basemodel{

	protected $table = 'atiku_blogs';

	protected $guarded = [];

	public function comments(){
		return $this->hasMany('App\Atikucomment', 'atikublog_id');
	}

	 public static function migrate(){

    	Schema::dropIfExists('atiku_blogs');
	 	Schema::create('atiku_blogs', function(Blueprint $table){

	 		$table->increments('id');
	 		$table->string('title');
	 		$table->text('content');
	 		$table->string('excerpt');
	 		$table->string('image');
	 		$table->string('extra');
	 		
	 		$table->string('party');
	 		//$table->boolean('verified')->default(false);
	 		$table->timestamps();
	 	});

	 	echo 'blogs migrated successfully...';

    }
    
}
