<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\State;
use App\Code;
use App\Marketer;
use App\Log;
use App\Station;
use Validator;
use App\FuelLog;
use App\StationLog;
use App\SmartQueue;
use App\Fuel;

use DB;

class ApiController extends Controller{

    private $plog = '';
    private $index = 0;
    private $nsq_num = 0;
    private $osq_num = 0;
    private $new_user_tag_number = 0;

	/*public function index(){
		return view('pages.home')
				->with('pg_title', 'Welcome, Dashboard');
	}

	public function newMarketer(){
		return view('pages.add')
				->with('states', State::all())
				->with('r_code', Code::generateRetailNumber())
				->with('pg_title', 'Add New Marketer');
	}

	public function allMarketers(){
		$all = Marketer::with(['code','state'])->get();
		//pr($all, true);
		return view('pages.all')
				->with('marketers', $all)
				->with('pg_title', 'All Marketers');
	}

	public function getLogs($id){
		$all = Log::where('marketer_id', $id)->get();
		$mkt = Marketer::find($id);
		//pr($all, true);
		return view('pages.logs')
				->with('logs', $all)
				->with('mkt', $mkt)
				->with('pg_title', 'Fuel Service Logs');
	}
*/

    public function getRetailDetails($rn){

        $grd = Code::select('station_id')
                    ->with([
                        'station.company:id,fullname'
                    ])
                    ->where('retail_num', $rn)
                    ->first();

        if($grd != null){
            return ['type' => 'success', 'station' => $grd];
        }
        else{
            return ['type' => 'fail', 'msg' => 'Wrong Retail Serial Number'];
        }

    }

    public function saveLocation(Request $request){

        $validator = Validator::make($request->all(), [
            'total_pump_number' => 'bail|required',
            'close_time' => 'bail|required',
            'open_time' => 'bail|required|',
        ]);

        if($validator->fails()) {
            return ['type' => 'failure', 'msg' => $validator->errors()];
        }
        else{
            $mk = Station::find($request['station_id']);

            $mk->lat = $request['lat'];
            $mk->lng = $request['lng'];
            $mk->open_time = $request['open_time'];
            $mk->close_time = $request['close_time'];
            $mk->total_pumps = $request['total_pump_number'];

            $mk->save();


            return ['type' => 'done', 'msg' => 'Station record saved'];

        }


    }


    public function getFuelList($id){

        $mk = unserialize(Marketer::find($id)->fuels);

        return $mk;
    }
    

    public function getLog($id){

        $log = Log::where('marketer_id', $id)->first();

        $ar = unserialize($log->evening);
        return json_encode($ar);

    }


    public function getMarketerProfile($id){
        $mk = Marketer::find($id);

        return $mk;
    }

    // SAVING EACH STATION FUEL LOG
    public function saveFuelLog(Request $request){

        //return $request->all(); exit;

        $dt = date('Y-m-d');

        $tfl = FuelLog::where('station_id', $request['station_id'])
                        ->whereDate('created_at', $dt)->count();

        /*$mm = $this->logPetrol($request['period'], $request['petrol'], $tfl, $request['station_id'], $dt);

        return $mm; exit;*/

        DB::transaction(function() use($request, $dt, $tfl){

            $this->logPetrol($request['period'], $request['petrol'], $tfl, $request['station_id'], $dt);
            $this->logKerosine($request['period'], $request['kerosine'], $tfl, $request['station_id'], $dt);
            $this->logDisel($request['period'], $request['disel'], $tfl, $request['station_id'], $dt);
            $this->logGas($request['period'], $request['gas'], $tfl, $request['station_id'], $dt);
        });

        return ['type' => 'success', 'msg' => 'Log for '.$request['period'].' saved'];
    }

    //**************SAVING PETROL LOGS***********************
    public function logPetrol($period, $value, $count, $station_id, $date){

        //return [$station_id]; exit;

       if($count == 0){

           //return ['count is zero '.$station_id]; exit;

            if($period === 'morning'){
                $log = new FuelLog();
                $log->station_id = $station_id;
                $log->fuel_id = 1;
                $log->morning = $value;
                $log->save();
            }elseif ($period === 'afternoon'){
                $log = new FuelLog();
                $log->station_id = $station_id;
                $log->fuel_id = 1;
                $log->afternoon = $value;
                $log->save();
            }
            else{
                $log = new FuelLog();
                $log->station_id = $station_id;
                $log->fuel_id = 1;
                $log->evening = $value;
                $log->save();
            }

        }else{

            $log = FuelLog::where('station_id', $station_id)
                            ->whereDate('created_at', $date)
                            ->where('fuel_id', 1)->first();
            if($period === 'morning'){
                $log->morning = $value;
                $log->save();
            }elseif ($period === 'afternoon'){
                $log->afternoon = $value;
                $log->save();
            }
            else{
                $log->evening = $value;
                $log->save();
            }

        }


    }

    //**************SAVING KEROSINE LOGS***********************
    public function logKerosine($period, $value, $count, $station_id, $date){

        if($count == 0){

            if($period === 'morning'){
                $log = new FuelLog();
                $log->station_id = $station_id;
                $log->fuel_id = 2;
                $log->morning = $value;
                $log->save();
            }elseif ($period === 'afternoon'){
                $log = new FuelLog();
                $log->station_id = $station_id;
                $log->fuel_id = 2;
                $log->afternoon = $value;
                $log->save();
            }
            else{
                $log = new FuelLog();
                $log->station_id = $station_id;
                $log->fuel_id = 2;
                $log->evening = $value;
                $log->save();
            }

        }else{

            $log = FuelLog::where('station_id', $station_id)
                ->whereDate('created_at', $date)
                ->where('fuel_id', 2)->first();
            if($period == 'morning'){
                $log->morning = $value;
                $log->save();
            }elseif ($period == 'afternoon'){
                $log->afternoon = $value;
                $log->save();
            }
            else{
                $log->evening = $value;
                $log->save();
            }

        }
    }

    //**************SAVING DISEL LOGS***********************
    public function logDisel($period, $value, $count, $station_id, $date){

        if($count == 0){

            if($period === 'morning'){
                $log = new FuelLog();
                $log->station_id = $station_id;
                $log->fuel_id = 3;
                $log->morning = $value;
                $log->save();
            }elseif ($period === 'afternoon'){
                $log = new FuelLog();
                $log->station_id = $station_id;
                $log->fuel_id = 3;
                $log->afternoon = $value;
                $log->save();
            }
            else{
                $log = new FuelLog();
                $log->station_id = $station_id;
                $log->fuel_id = 3;
                $log->evening = $value;
                $log->save();
            }


        }else{

            $log = FuelLog::where('station_id', $station_id)
                ->whereDate('created_at', $date)
                ->where('fuel_id', 3)->first();
            if($period === 'morning'){
                $log->morning = $value;
                $log->save();
            }elseif ($period === 'afternoon'){
                $log->afternoon = $value;
                $log->save();
            }
            else{
                $log->evening = $value;
                $log->save();
            }

        }
    }

    //**************SAVING GAS LOGS***********************
    public function logGas($period, $value, $count, $station_id, $date){

        if($count == 0){

            if($period === 'morning'){
                $log = new FuelLog();
                $log->morning = $value;
                $log->station_id = $station_id;
                $log->fuel_id = 4;
                $log->save();
            }elseif ($period === 'afternoon'){
                $log = new FuelLog();
                $log->station_id = $station_id;
                $log->fuel_id = 4;
                $log->afternoon = $value;
                $log->save();
            }
            else{
                $log = new FuelLog();
                $log->station_id = $station_id;
                $log->fuel_id = 4;
                $log->evening = $value;
                $log->save();
            }


        }else{

            $log = FuelLog::where('station_id', $station_id)
                ->whereDate('created_at', $date)
                ->where('fuel_id', 4)->first();
            if($period === 'morning'){
                $log->morning = $value;
                $log->save();
            }elseif ($period === 'afternoon'){
                $log->afternoon = $value;
                $log->save();
            }
            else{
                $log->evening = $value;
                $log->save();

            }

        }
    }


    public function updatePeriod($id, $period, $val) {

        $log = Log::find($id);

        if($period == 'morning'){
            $log->morning = $val;

        }elseif ($period == 'afternoon'){
            $log->afternoon = $val;

        }else{
            $log->evening = $val;

        }
        $log->save();
    }

    public function searchStations($lat, $lng) {
        /**/
        $dt = '2018-09-29';

        $circle_radius = 3959;
        $max_distance = 10;

        $stations = DB::select('SELECT id, fullname, branch, lng, lat, '.$circle_radius.' * acos(cos(radians('.$lat.')) * cos(radians(lat)) * cos(radians(lng) - radians('.$lng.')) + sin(radians('.$lat.')) * sin(radians(lat))) AS distance FROM stations HAVING distance < '.$max_distance.' ORDER BY distance LIMIT 0, 20')
        ->has('stationlogs', function ($query) use($dt){
            $query->where('log_status', 'Open')
                ->whereDate('created_at', $dt);
        });

        return $stations;
    }

    //*********************CLOSE OPEN AND HOLD STATION STATUS**************

    public function saveStatus(Request $request){

        $dt = date('Y-m-d');

        //return [$request['station_id']]; exit;

        $validator = Validator::make($request->all(), [
            'status' => 'bail|required',
            'description' => 'bail|max:300',
        ]);

        if($validator->fails()) {
            return ['type' => 'failure', 'msg' => $validator->errors()];
        }

        $st = StationLog::where('station_id', $request['station_id'])
                            ->whereDate('created_at', $dt)->first();

        //return $st; exit;

        if($st != null){

            $st->log_status = $request['status'];
            $st->log_description = $request['description'];
            $st->save();

            return ['type' => 'success', 'msg' => 'Station status changed'];

        }

        $nst = new StationLog;

        $nst->log_status = $request['status'];
        $nst->log_description = $request['description'];
        $nst->station_id = $request['station_id'];
        $nst->save();

        return ['type' => 'success', 'msg' => 'Station status changed'];


    }

    //********************************SEARCHING FOR FUEL ************************************************
    public function searchFuel($lat, $lng, $hr, $dist, $ft, $ql){

        //return [$hr]; exit;

        $dt = date('Y-m-d');//'2018-09-29';//
        $moment = $this->setMoment();

        $circle_radius = 3959;
        $max_distance = $dist;

        $swf = Station::with([
                            'company:id,fullname',
                            'fuellogs' => function($query) use($dt, $ft, $moment) {
                                $query->select('station_id',$moment)->where('fuel_id', $ft)
                                    ->whereDate('created_at', $dt);
                                return $query;
                            },
                            'state:id,state',
                            'stationlogs' => function($query) use($dt) {
                                $query->select('station_id','log_status')->whereDate('created_at', $dt);
                            },
                ])
                ->having('distance', '<', $max_distance)
                    ->select(DB::raw("*,
                     (3959 * ACOS(COS(RADIANS($lat))
                           * COS(RADIANS(lat))
                           * COS(RADIANS($lng) - RADIANS(lng))
                           + SIN(RADIANS($lat))
                           * SIN(RADIANS(lat)))) AS distance")
                    )->orderBy('distance', 'asc')
                    ->whereHas('fuellogs', function ($query) use ($dt, $ft, $moment) {
                        $query->where($moment, '!=', null)
                            ->where('fuel_id', $ft)
                            ->whereDate('created_at', $dt);
                    })
                    ->has('queues', '<', $ql)
                    ->withCount(['queues' => function($query) use ($ft){
                        $query->whereDate('created_at', date('Y-m-d'))
                                ->where('status', 'pending')
                                ->where('fuel_id', $ft);
                    }])
                    ->get();


        return $swf;

    }

    //****************************SETTING FUEL SEARCH MOMENT ****************************************
    public function setMoment(){

        $current_hour = date('H');

        $to_nigeria_H = intval($current_hour) + 1;

        if($to_nigeria_H >= 0 && $to_nigeria_H <= 11){
            return 'morning';
        }
        elseif ($to_nigeria_H >= 12 && $to_nigeria_H <= 16){
            return 'afternoon';
        }
        else{
            return 'evening';
        }

    }
    
    
    //**************************JOINING STARTQUEUE ********************************************************
    public function joinSmartQueue(Request $request){

        $dt = date('Y-m-d');

        $validator = Validator::make($request->all(), [
            'number' => 'bail|required',
            'made' => 'bail|required',
            'color' => 'bail|required',
        ]);

        if($validator->fails()) {
            return ['type' => 'failure', 'msg' => $validator->errors()];
        }

        $last_user = SmartQueue::where('station_id', $request['station_id'])
                                    ->whereDate('created_at', $dt)
                                    ->orderBy('created_at', 'desc')
                                    ->first();
        if($last_user != null){
            $this->new_user_tag_number = $last_user->tag_number + 1;
        }else{
            $this->new_user_tag_number = 1;
        }

        $sq_number = SmartQueue::where('station_id', $request['station_id'])
                                    ->whereDate('created_at', $dt)
                                    ->where('status', 'pending')
                                    ->count();

        //return $tag_count; exit;

        $ck = SmartQueue::with([
            'station' => function($query){
                $query->select('id','company_id','close_time','open_time','lga_id','state_id','branch','town','street')
                    ->with([
                        'company:id,fullname',
                        'state:id,state'
                    ]);
            },
        ])
            ->where('vec_num', $request['number'])
            ->where('status', 'pending')
            ->whereDate('created_at', $dt)
            ->first();

        if($ck != null){

            $nst = Station::with([
                                'company:id,fullname',
                                'state:id,state'
                            ])
                            ->select('id','company_id','close_time','open_time','lga_id','state_id','branch','town','street')
                            ->where('id', $request['station_id'])
                            ->first();

            return ['type' => 'already', 'msg' => 'You are already in queue', 'std' => $ck, 'nst' => $nst];
        }

        $nsq = new SmartQueue();

        $nsq->station_id = $request['station_id'];
        $nsq->fuel_id = $request['fuel_id'];
        $nsq->vec_num = $request['number'];
        $nsq->vec_model = $request['made'];
        $nsq->vec_color = $request['color'];
        $nsq->tag_number = $this->new_user_tag_number;
        $nsq->sq_number = intval($sq_number) + 1;
        $nsq->status = 'pending';

        $nsq->save();

        return ['type' => 'success', 'msg' => 'You have successfully joined the queue', 'id' => $nsq->id];


    }

    //********************************GETTING USER CURRENT SMARTQUEUE VEHICLES*************************
    public function getMySmartQueues(Request $request){
        //return json_decode($request['sq_ids']); exit();
        $dt = date('Y-m-d');

        $ids = $request['sq_ids'];

        //return $ids;

        $my_sq = SmartQueue::whereIn('id', json_decode($ids))
                                ->with(
                                    'station.company'
                                )
                                ->whereDate('created_at', $dt)
                                ->get();


        return $my_sq;
    }

    public function getSmartQueueNumber($number, $station_id){

        $dt = date('Y-m-d');

        $query = DB::table(DB::raw('smart_queues, (SELECT @row := 0) r'))
            ->select(
            DB::raw('@row := @row + 1 AS sq_num'),
            'vec_num',
            'tag_number',
            'station_id'
        )
            ->where('station_id', $station_id)
            ->whereDate('created_at', $dt)
            ->orderBy('created_at','asc')
            ->get();

        return $query;
    }
    
    //************************CHANGING VEHICLE STATION**********************************************

    public function changeSmartQueue(Request $request){

        $dt = date('Y-m-d');
        //get cold queue and delete it

        //return $request->all(); exit();

        DB::transaction(function() use($request, $dt){


            $oldSQ = SmartQueue::where('vec_num', $request['number'])
                ->whereDate('created_at', $dt)
                ->first();

            $this->osq_num = $oldSQ->id;

            $oldSQ_Id = $oldSQ->station_id;
            $oldSQ_umber= $oldSQ->sq_number;

            $oldSQ->delete();

            $oldSQVs = SmartQueue::where('station_id', $oldSQ_Id)
                        ->whereDate('created_at', $dt)
                        ->get();

            foreach ($oldSQVs as $v){

                if($v->sq_number > $oldSQ_umber){
                    $v->sq_number = intval($v->sq_number) - 1;
                    $v->save();
                }

            }

            $last_user = SmartQueue::where('station_id', $request['station_id'])
                                    ->whereDate('created_at', $dt)
                                    ->orderBy('created_at', 'desc')
                                    ->first();
                                    /*->where('status', 'cleared')*/
                                    /*->count();*/

            $sq_number = SmartQueue::where('station_id', $request['station_id'])
                                    ->whereDate('created_at', $dt)
                                    ->where('status', 'pending')
                                    ->count();

            $nsq = new SmartQueue();

            $nsq->station_id = $request['station_id'];
            $nsq->vec_num = $request['number'];
            $nsq->vec_model = $request['made'];
            $nsq->vec_color = $request['color'];
            $nsq->tag_number = intval($last_user->tag_number) + 1;
            $nsq->sq_number = $sq_number + 1;
            $nsq->status = 'pending';

            $nsq->save();

            $this->nsq_num = $nsq->id;

        });

        return ['type' => 'success', 'msg' => 'You have successfully join a new station SmartQueue', 'id' => $this->nsq_num, 'di' => $this->osq_num];

    }

    //*********************SEARCHING FOR STATION VEHICLES **********************************************************

    public function stationSearchForVehicle($type, $value, $station_id){

        $vehicle = SmartQueue::where($type, $value)
                               ->where('station_id', $station_id)
                               ->where('status', 'pending')
                                ->first();
        return $vehicle;
    }


    //******************* STATIONS CLEARING VEHICLE ******************************************************

    public function stationClearVehicle($id, $station_id){

        DB::transaction(function() use($id, $station_id){

            $dt = date('Y-m-d');

            $vec = SmartQueue::find($id);
            $vec->status = 'cleared';
            $vec->save();

            $oldSQ_number = $vec->sq_number;


            $oldSQVs = SmartQueue::where('station_id', $station_id)
                ->whereDate('created_at', $dt)
                ->where('status', 'pending')
                ->get();

            foreach ($oldSQVs as $v){

                if($v->sq_number > $oldSQ_number){
                    $v->sq_number = intval($v->sq_number) - 1;
                    $v->save();
                }

            }


        });

        return ['type' => 'success', 'msg' => 'Vehicle has been cleared'];
    }

    //***********************GET STATION FOR COMPLAIN *****************************************************
    public function getStationForComplain($number){

        $dt = date('Y-m-d');

        $vec = SmartQueue::with([

                                'station' => function($query){
                                    $query->select('id','company_id','lga_id','state_id','branch','town','street')
                                        ->with([
                                            'company:id,fullname',
                                            'state:id,state'
                                        ]);
                                }

                                ])
                            ->where('vec_num', $number)
                            ->whereDate('created_at', $dt)
                            ->where('status', 'cleared')
                            ->first();
        return $vec;
    }

    public function userLast(){

        $last_user = SmartQueue::where('station_id', 1)
            ->whereDate('created_at', date('Y-m-d'))
            ->orderBy('created_at', 'desc')
            ->first();
        return $last_user;
    }

    //***************************GETTING STATION SMARTQUEUE LIST *******************************

    public function getStationSmartQueueList($id){
        $list = SmartQueue::where('station_id', $id)
                            ->where('status', 'pending')
                            ->whereDate('created_at', date('Y-m-d'))
                            ->orderBy('sq_number', 'asc')
                            ->get();

        return $list;
    }

    //************************GETTING FUEL TYPE *************************************************
    public function getAllFuel(){
        $fuel = Fuel::all();

        return $fuel;
    }



/*
	public function process_new(Request $request){

		//pr($request->all(), true);

		DB::transaction(function() use($request){

			//save the marketer info...
			$m = new Marketer;
			$m->fullname = $request['fullname'];
			$m->branch = $request['branch_name'];
			$m->rc_number = $request['rc_num'];
			$m->state_id = $request['state'];
			$m->fuels = serialize($request['fuels']);
			$m->save();

			//save the code part...
			$c = new Code;
			$c->marketer_id = $m->id;
			$c->retail_num = $request['r_code'];
			$c->save();

		});

	}


	public function addLog(Request $request){

		$ar = Marketer::find($request['mid'])->fuels;

		$s = explode(';', 'kerosine;petrol;diesel');

		//check for occurence of each variabble..
		foreach($s as $txt){
			$$txt = (strpos($ar, $txt) !== false) ? true : false;
		}

		//initialize the array...
		$ar_07 = $ar_12 = $ar_05 = [
			'kerosine'	=> 0,
			'petrol' 	=> 0,
			'diesel' 	=> 0
		];

		if($kerosine){
			 $ar_07['kerosine'] = $request['kerosine_07am'];
			 $ar_12['kerosine'] = $request['kerosine_12pm'];
			 $ar_05['kerosine'] = $request['kerosine_05pm'];
		}

		if($petrol){
			 $ar_07['petrol'] = $request['petrol_07am'];
			 $ar_12['petrol'] = $request['petrol_12pm'];
			 $ar_05['petrol'] = $request['petrol_05pm'];
		}

		if($diesel){
			 $ar_07['diesel'] = $request['diesel_07am'];
			 $ar_12['diesel'] = $request['diesel_12pm'];
			 $ar_05['diesel'] = $request['diesel_05pm'];
		}

		//do the data entry...

		$lg = new Log;
		$lg->marketer_id = $request['mid'];

		$lg->morning = serialize($ar_07);
		$lg->afternoon = serialize($ar_12);
		$lg->evening = serialize($ar_05);

		$lg->save();

		return redirect()->back();

	}*/




}
