<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', 'PagesController@index');

Route::get('/new-coy', 'PagesController@newCompany');
Route::get('/company/all', 'PagesController@allCompany')->name('all_company');
Route::post('/company/new', 'PagesController@addNewCoy')->name('new_company');

Route::get('/station/{id}/add', 'PagesController@newStation');
Route::get('/station/all', 'PagesController@allStations');

Route::post('/process', 'PagesController@process_new')->name('new_station');

Route::get('/service/{id}/logs', 'PagesController@getLogs')->name('logs');


Route::post('/logs/add', 'PagesController@addLog')->name('new_log');

Route::get('/state/{id}/lgas', 'PagesController@getLgas');

/////////////////////////////////////////////////////////////////////////////////////////////////////


Route::get('/blog/{party}', 'AtikuController@addnew');
Route::post('/blog/process', 'AtikuController@process')->name('process_blog');
Route::get('/blogs/all', 'AtikuController@allBlogs');
Route::get('blog/{id}/view', 'AtikuController@blogSingle');
Route::get('blog/{id}/del', 'AtikuController@delBlog');

Route::get('gallery/{id}/del', 'AtikuController@delPhoto');

Route::get('/photos/add', 'AtikuController@addImages');
Route::get('/photos/all', 'AtikuController@allPhotos')->name('atikuphotos');
Route::post('/photos/upload', 'AtikuController@uploadImages');

Route::get('comment/{id}/approve', 'AtikuController@approveComment');

Route::get('bspool', function(){

	App\Atikucomment::create([
		'atikublog_id'  => 4,
		'comment'		=> 'To prevent future '.md5('abc' . rand() * 234).' occurrence, I have come' . time()
	]);
	echo 'entered..';
});


/////////////////////////////////

//clear all data...
Route::get('/atiku/refresh', function(){
	DB::transaction(function(){
		App\Atikuphoto::truncate();
		App\Atikublog::truncate();
		App\Atikucomment::truncate();
		App\Atikuser::truncate();
		
	});

	echo 'Atiku-tables cleared successfully.....';
});

/////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/userTimeline', function(){
	return Twitter::getUserTimeline(
		[
			'screen_name' => 'atiku', 
			'count' => 1, 
			'format' => 'json'
		]
	);
});

/////////////////////////////////////////////////////////////////////////////////////////////////////


Route::get('/test', function(){
	echo App\Code::generateRetailNumber();
});

//clear all data...
Route::get('/refresh', function(){
	DB::transaction(function(){
		App\Station::truncate();
		App\Code::truncate();
		App\Company::truncate();
		App\FuelLog::truncate();
		//App\Fuel::truncate();
		App\SmartQueue::truncate();
		App\StationLog::truncate();
	});

	echo 'tables cleared successfully.....';
});

//////////////////////////////////////////////////////////////////////////	the migrations starts here....

Route::get('/tb/migrate/{model}', function($model){
	$model = '\App\\'.studly_case($model);
	$model::migrate();
});

////////////////////////////////////////////////////////////////////////////beginthe migration routes... 