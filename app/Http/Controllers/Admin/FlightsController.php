<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Route;

use App\Flight;
use App\FlightDetail;
use App\User;

use Auth;
use Config;

class FlightsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {	
        $this->middleware('auth:admin');
	}
	/**
     * All Cms Page.
     *
     * @return \Illuminate\Http\Response
     */
	public function getFlights(Request $request){
		 $query 		= FlightDetail::with(['flight', 'flightsource', 'flightdest']);
		   
		$type = $request->type; 
		
		$totalData 	= $query->count();	//for all data 
		$lists		= $query->orderby('id','desc')->get();
		return view('Admin.flightdetail.show',compact(['lists', 'totalData','type']));	
	}
	public function searchFlights(Request $request){
		 $query 		= FlightDetail::with(['flight', 'flightsource', 'flightdest']);
		 $type = $request->type; 
		  if($request->has('name')){
			  $name 		= 	$request->input('name');
			  if(trim($name) != '')
				{
					$query->whereHas('flight', function ($q) use($name){
						$q->where('name','=',$name);
					});
				}
		  }  
		  if($request->has('depdate')){
			  $depdate 		= 	$request->input('depdate');
			  if(trim($depdate) != '')
				{
					$query->whereDate('dep_time', '=', @date('Y-m-d',strtotime($depdate)));
				}
		  } 
		if($request->has('code')){
			  $code 		= 	$request->input('code');
			  if(trim($code) != '')
				{
					$query->whereHas('flight', function ($q) use($code){
						$q->where('code','=',$code);
					});
				}
		  } 	
		
		$totalData 	= $query->count();	//for all data 
		$lists		= $query->orderby('id','desc')->get();
		return view('Admin.flightdetail.show',compact(['lists', 'totalData','type']));	
	}
	public function index(Request $request)
	{
		//check authorization start	
			/*  $check = $this->checkAuthorizationAction('cmspages', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	  */
		//check authorization end
		
		 $query 		= Flight::where('id', '!=', '');
		
		$totalData 	= $query->count();	//for all data
		$lists		= $query->orderby('id','desc')->get();
		return view('Admin.flights.index',compact(['lists', 'totalData']));	
	}
	
	public function create(Request $request)
	{
		return view('Admin.flights.create');	
	}
	 
	public function store(Request $request)
	{
		 /* $check = $this->checkAuthorizationAction('cmspages', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			} */	
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
					'name' => 'required|max:255',
					'code' => 'required',
			]);
			$requestData 		= 	$request->all();
			if(Flight::where('code', @$requestData['code'])->exists()){
				return Redirect::to('/admin/flights/create')->with('error', 'Flights is already exists');
			}
			
			/* if($request->hasfile('logo')) 
			{	
				$flights_image = $this->uploadFile($request->file('logo'), Config::get('constants.flights')); 
			} 
			else
			{ 
				$flights_image = NULL;
			}
			 */
			$obj				= 	new Flight;
			$obj->name			=	@$requestData['name'];
			$obj->code			=	@$requestData['code'];
			//$obj->logo			=	@$flights_image;
			$obj->user_id		=	Auth::user()->id;
			$saved				=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/flights')->with('success', 'Flights added Successfully');
			}
		}			
	} 
	 
	public function edit(Request $request, $id = NULL)
	{	
		//check authorization start	
			/*  $check = $this->checkAuthorizationAction('cmspages', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	 */
		//check authorization end
	
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$this->validate($request, [
					'name' => 'required|max:255',
					'code' => 'required',
			]);
			$fdetail = Flight::where('code', @$requestData['code'])->first();
			if($requestData['code'] != @$fdetail->code){
				if(Flight::where('code', @$requestData['code'])->exists()){
					return Redirect::to('/admin/flights/edit'.base64_encode(convert_uuencode(@$requestData['id'])))->with('error', 'Flights is already exists');
				}
			}
			
			// if($request->hasfile('logo')) 
			// {	
					// if($requestData['old_logo'] != '')
						// {
							// $this->unlinkFile($requestData['old_logo'], Config::get('constants.flights'));
						// }
				
				
				// $topinclu_image = $this->uploadFile($request->file('logo'), Config::get('constants.flights'));
			// }
			// else
			// {
				// $flights_image = @$requestData['old_logo'];
			// }
			$obj				= 	Flight::find(@$requestData['id']);
			$obj->name			=	@$requestData['name'];
			$obj->code			=	@$requestData['code'];
			//$obj->logo			=	@$flights_image;
			$obj->user_id		=	Auth::user()->id;
			$saved				=	$obj->save(); 
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/flights')->with('success', 'Flight'.Config::get('constants.edited'));
			}				
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(Flight::where('id', '=', $id)->exists()) 
				{
					$fetchedData = Flight::find($id);
					return view('Admin.flights.edit', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/flights')->with('error', 'Flight'.Config::get('constants.not_exist'));
				}	
			}
			else
			{
				return Redirect::to('/admin/flights')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	
	public function FlightDetailindex(Request $request)
	{
		//check authorization start	
			/*  $check = $this->checkAuthorizationAction('cmspages', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	  */ 
		//check authorization end
		
		 $query 		= FlightDetail::with(['flight', 'flightsource', 'flightdest','agentdetail']);
		   
		 
		
		$totalData 	= $query->count();	//for all data 
		$lists		= $query->orderby('id','desc')->get();
		return view('Admin.flightdetail.index',compact(['lists', 'totalData']));	
	}
	 
	public function FlightDetailindexCreate(Request $request){
		$flights = Flight::orderby('id','desc')->get();
		$users = User::orderby('company_name','ASC')->get();
		return view('Admin.flightdetail.create',compact(['flights','users']));
	}
	
	public function FlightDetailindexStore(Request $request){
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			
			 
			$obj						= 	new FlightDetail;
			$obj->flighttype				=	@$requestData['flighttype'];
			$obj->agent				=	@$requestData['agent'];
			$obj->flight_id				=	@$requestData['flight_name'];
			$obj->flight_number			=	@$requestData['flight_number'];
			$obj->flight_source			=	@$requestData['flight_source'];
			$obj->flight_destination	=	@$requestData['flight_destination'];
			$obj->dep_time				=	@$requestData['dep_time'];
			$obj->arival_time			=	@$requestData['arival_time'];
			$obj->duration				=	@$requestData['duration'];
			
			$obj->ret_flight_id				=	@$requestData['ret_flight_id'];
			$obj->ret_flight_number			=	@$requestData['ret_flight_number'];
			$obj->ret_dep_time			=	@$requestData['ret_dep_time'];
			$obj->ret_arv_time			=	@$requestData['ret_arv_time'];
			$obj->ret_duration			=	@$requestData['ret_duration'];
			$obj->ret_stop			=	@$requestData['ret_stop'];
			
			$obj->stop					=	@$requestData['stop'];
			$obj->bc_total				=	@$requestData['bc_total'];
			$obj->bb_total				=	@$requestData['bb_total'];
			$obj->fare_detail			=	@$requestData['fare_detail'];
			$obj->check_in_baggage		=	@$requestData['check_in_baggage'];
			$obj->cabbin_baggage		=	@$requestData['cabbin_baggage'];
			$obj->cancellation_policy	=	@$requestData['cancellation_policy'];
			$obj->user_id				=	Auth::user()->id;
			$saved						=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/flight-detail')->with('success', 'Flights added Successfully');
			}
		}
	}
	
	
	public function FlightDetailindexClone(Request $request, $id = NULL){
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			$obj						= new FlightDetail;
			$obj->agent					=	@$requestData['agent'];
			$obj->flighttype				=	@$requestData['flighttype'];
			$obj->flight_id				=	@$requestData['flight_name'];
			$obj->flight_number			=	@$requestData['flight_number'];
			$obj->flight_source			=	@$requestData['flight_source'];
			$obj->flight_destination	=	@$requestData['flight_destination'];
			$obj->dep_time				=	@$requestData['dep_time'];
			$obj->arival_time			=	@$requestData['arival_time'];
		
			$obj->ret_flight_id				=	@$requestData['ret_flight_id'];
			$obj->ret_flight_number			=	@$requestData['ret_flight_number'];
			$obj->ret_dep_time			=	@$requestData['ret_dep_time'];
			$obj->ret_arv_time			=	@$requestData['ret_arv_time'];
			$obj->ret_duration			=	@$requestData['ret_duration'];
			$obj->ret_stop			=	@$requestData['ret_stop'];
			
			
			$obj->duration				=	@$requestData['duration'];
			$obj->stop					=	@$requestData['stop'];
			$obj->bc_total				=	@$requestData['bc_total'];
			$obj->bb_total				=	@$requestData['bb_total'];
			$obj->fare_detail			=	@$requestData['fare_detail'];
			$obj->check_in_baggage		=	@$requestData['check_in_baggage'];
			$obj->cabbin_baggage		=	@$requestData['cabbin_baggage'];
			$obj->cancellation_policy	=	@$requestData['cancellation_policy'];
			$obj->user_id				=	Auth::user()->id;
			$saved						=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/flight-detail')->with('success', 'Flight'.Config::get('constants.edited'));
			}				
		}
		else
		{	
	$flights = Flight::orderby('id','desc')->get();
	$users = User::orderby('company_name','ASC')->get();
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(FlightDetail::where('id', '=', $id)->exists()) 
				{
					$fetchedData = FlightDetail::find($id);
					return view('Admin.flightdetail.clone', compact(['flights','fetchedData','users']));
				}
				else
				{
					return Redirect::to('/admin/flight-detail')->with('error', 'Flight'.Config::get('constants.not_exist'));
				}	
			}
			else
			{
				return Redirect::to('/admin/flight-detail')->with('error', Config::get('constants.unauthorized'));
			}		
		}	
	}
	public function FlightDetailindexEdit(Request $request, $id = NULL)
	{	
		//check authorization start	
			/*  $check = $this->checkAuthorizationAction('cmspages', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	 */
		//check authorization end
	
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			$obj						= 	FlightDetail::find(@$requestData['id']);
			$obj->agent					=	@$requestData['agent'];
			$obj->flighttype				=	@$requestData['flighttype'];
			$obj->flight_id				=	@$requestData['flight_name'];
			$obj->flight_number			=	@$requestData['flight_number'];
			$obj->flight_source			=	@$requestData['flight_source'];
			$obj->flight_destination	=	@$requestData['flight_destination'];
			$obj->dep_time				=	@$requestData['dep_time'];
			$obj->arival_time			=	@$requestData['arival_time'];
		
			$obj->ret_flight_id				=	@$requestData['ret_flight_id'];
			$obj->ret_flight_number			=	@$requestData['ret_flight_number'];
			$obj->ret_dep_time			=	@$requestData['ret_dep_time'];
			$obj->ret_arv_time			=	@$requestData['ret_arv_time'];
			$obj->ret_duration			=	@$requestData['ret_duration'];
			$obj->ret_stop			=	@$requestData['ret_stop'];
			
			
			$obj->duration				=	@$requestData['duration'];
			$obj->stop					=	@$requestData['stop'];
			$obj->bc_total				=	@$requestData['bc_total'];
			$obj->bb_total				=	@$requestData['bb_total'];
			$obj->fare_detail			=	@$requestData['fare_detail'];
			$obj->check_in_baggage		=	@$requestData['check_in_baggage'];
			$obj->cabbin_baggage		=	@$requestData['cabbin_baggage'];
			$obj->cancellation_policy	=	@$requestData['cancellation_policy'];
			$obj->user_id				=	Auth::user()->id;
			$saved						=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/flight-detail')->with('success', 'Flight'.Config::get('constants.edited'));
			}				
		}
		else
		{	 
	$flights = Flight::orderby('id','desc')->get();
	$users = User::orderby('company_name','ASC')->get();
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(FlightDetail::where('id', '=', $id)->exists()) 
				{
					$fetchedData = FlightDetail::find($id);
					return view('Admin.flightdetail.edit', compact(['flights','fetchedData','users']));
				}
				else
				{
					return Redirect::to('/admin/flight-detail')->with('error', 'Flight'.Config::get('constants.not_exist'));
				}	
			}
			else
			{
				return Redirect::to('/admin/flight-detail')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	
}
