<?php

use Illuminate\Http\Request;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'marketers',
], function (){

    Route::get('retailer/detail/{rn}', 'ApiController@getRetailDetails');
    Route::put('save/location', 'ApiController@saveLocation');
    Route::get('fuel/list/{id}', 'ApiController@getFuelList');
    Route::get('retailer/log/{id}', 'ApiController@getLog');
    Route::get('retailer/profile/{id}', 'ApiController@getMarketerProfile');
    Route::post('fuel/log', 'ApiController@saveFuelLog');

    Route::get('search/stations/{lat}/{lng}', 'ApiController@searchStations');
    Route::post('save/status', 'ApiController@saveStatus');
    Route::get('fuel/search/{lat}/{lng}/{hr}/{dist}/{ft}/{ql}', 'ApiController@searchFuel');
    Route::post('join/queue', 'ApiController@joinSmartQueue');
    Route::get('smart/queue/number/{number}/{station_id}', 'ApiController@getSmartQueueNumber');
    Route::get('my/smart/queues', 'ApiController@getMySmartQueues');
    Route::post('change/smart/queue', 'ApiController@changeSmartQueue');

    Route::get('search/vehicle/{type}/{value}/{station_id}', 'ApiController@stationSearchForVehicle');
    Route::put('station/clear/vehicle/{id}/{station_id}', 'ApiController@stationClearVehicle');
    Route::get('get/station/for/complain/{number}', 'ApiController@getStationForComplain');
    Route::get('get/station/sq/list/{id}', 'ApiController@getStationSmartQueueList');

    Route::get('test/last', 'ApiController@lastUser');
    Route::get('last/user', 'ApiController@userLast');
    Route::get('get/fuels', 'ApiController@getAllFuel');

    Route::get('test', function (){
        $time = localtime();
        $hr = $time[2];
        $startTime = date("Y-m-d H:i:s");
        $cenvertedTime = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($startTime)));
        return $cenvertedTime;
    });



});




Route::group(['prefix' => 'dv'], function (){
    Route::get('/test', function(){
        $all = [];
        $ar = explode(';','aminu;matilda;sam;emma;Josh;Gummie;zainab;choice;rita');
        $ct = 1;
        foreach($ar as $r){
            $r = [
                'id' => $ct,
                'name' => ucfirst($r),
                'age' => ceil(rand(1, 60))
            ];
            array_push($all, $r);
            $ct++;
        }
        return json_encode($all);
    });
});
