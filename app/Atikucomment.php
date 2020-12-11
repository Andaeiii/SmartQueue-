<?php

namespace App;

use Illuminate\Database\Schema\Blueprint;
use Schema;

use Illuminate\Database\Eloquent\Model;

class Atikucomment extends Basemodel{

	protected $table = 'atiku_comments';

	protected $guarded = [];

	public function comments(){
	  return $this->belongsTo('App\Atikublog', 'atikublog_id');
	}

	 public static function migrate(){

    	Schema::dropIfExists('atiku_comments');    	
	 	Schema::create('atiku_comments', function(Blueprint $table){

	 		$table->increments('id');
	 		$table->integer('atikublog_id');
	 		$table->string('user_info');
	 		$table->string('comment');
	 		$table->boolean('verified')->default(false);
	 		$table->timestamps();

	 	});

	 	echo 'comments migrated successfully...';

    }

}
