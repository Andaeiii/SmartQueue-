<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\State;
use App\Code;
use App\Station;
use App\Company;
use App\Log;
use App\Fuel;

use DB;

class PagesController extends Controller{

	public function index(){
		return view('pages.home')
				->with('pg_title', 'Welcome, Dashboard');
	}

	public function newStation($id){
		return view('pages.add')
				->with('states', State::all())
				->with('company', Company::find(intval($id)))
				->with('r_code', Code::generateRetailNumber())
				->with('pg_title', 'Add New Station');
	}

	public function allStations(){
		$all = Station::with(['code','state'])->get();
		//pr($all, true); 
		return view('pages.all')
				->with('stations', $all)
				->with('pg_title', 'All Stations');
	}  

	public function getLogs($id){
		$all = Log::with('station')->where('station_id', $id)->get();
		$mkt = Station::find($id);
		//pr($all, true);
		return view('pages.logs')
				->with('logs', $all)
				->with('fuels', Fuel::all())
				->with('mkt', $mkt)
				->with('pg_title', 'Fuel Service Logs');
	}  

	public function process_new(Request $request){

		//pr($request->all(), true);
		
		DB::transaction(function() use($request){

			//save the marketer info... 
			$m = new Station;
			$m->company_id = $request['company_id'];
			$m->fullname = $request['fullname'];
			$m->branch = $request['branch_name'];
			//$m->rc_number = $request['rc_num'];
			
			$m->state_id = $request['state'];
			$m->lga_id = $request['lga'];
			$m->town = $request['town_name'];
			$m->street = $request['street_name'];

			//$m->fuels = serialize($request['fuels']); //not updated yet...

			$m->save();

			//save the code part... 
			$c = new Code;
			$c->station_id = $m->id;
			$c->retail_num = $request['r_code'];
			$c->save();

		});
		return redirect()->to('/station/all');

	}


	public function addLog(Request $request){

		$ar = Station::find($request['mid'])->fuels;

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
		$lg->station_id = $request['mid'];

		$lg->morning = serialize($ar_07);
		$lg->afternoon = serialize($ar_12);
		$lg->evening = serialize($ar_05);

		$lg->save();

		return redirect()->back();

	}


	public function getLgas($id){
		
		$lgas = State::find($id)->lgas;

		$lg = '<select name="lga" class="form-control" required="true">';
	    $lg .= '<option>--------</option>';
		foreach($lgas as $l){
	        $lg .= '<option value="'. $l->id .'">'. $l->name .'</option>';
		}
	    $lg .= '</select>';

	    echo $lg;
	}

	///////////////////////////////////////////////////////////

	public function newCompany(){
		return view('pages.newcoy')
				->with('states', State::all())
				->with('pg_title', 'Add New Company');
	}

	public function addNewCoy(Request $request){
		//pr($request->all());

		$c = new Company;

		$c->fullname 	= $request['fullname'];
		$c->rc_number   = $request['rc_num'];
		$c->sap_code 	= $request['sap_code'];
		$c->email     	= $request['email'];
		$c->phone    	= $request['phone'];
		$c->address    	= $request['address'];

		$c->save();

		return redirect()->to('/company/all');
	}

	public function allCompany(){
		return view('pages.allcoys')
				->with('coys', Company::all())
				->with('pg_title', 'All Registered Company(s)');
	}



}
