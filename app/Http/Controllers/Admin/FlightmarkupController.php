<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\Markup;
 
use Auth;  
use Config;

class FlightmarkupController extends Controller
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
     * All Vendors. 
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		//check authorization start	
			/*  $check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	 */
		//check authorization end
		
		 /* if(Auth::user()->role == 1){
			$query 		= Contact::where('id','!=','' )->with(['user']); 
		 }else{	
			$query 		= Contact::where('user_id', '=', Auth::user()->id);
		 }	 */
		
		return view('Admin.flightmarkup.index'); 	
		
	}
	
	public function create(Request $request){
		return view('Admin.flightmarkup.create'); 
	}
	
	public function update(Request $request)
	{
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			//echo '<pre>'; print_r($requestData); die;
			if($requestData['update_type'] == 1){
				foreach($requestData['allcheckbox'] as $list){
					//if($requestData['commission'] == 1){
					$obj = Markup::find($list);
					$obj->flight_type		=	@$requestData['markup_tpe'];
					$obj->service_fee		=	@$requestData['amount'];
					$obj->service_type		=	@$requestData['service_type'];
				
					$obj->user_type			=	@$requestData['user_type'];
					$saved					=	$obj->save();  
					/* }else{
						$obj = Markup::find($list);
					$obj->flight_type		=	@$requestData['markup_tpe'];
					
					$obj->service_type		=	@$requestData['service_type'];
					$obj->commission_fee	=	@$requestData['amount'];
					$obj->user_type			=	@$requestData['user_type'];
					$obj->commission_type			=	@$requestData['service_type'];
					$saved					=	$obj->save();  
					} */
				}
			}else{
				// if($requestData['commission'] == 1){
					$saved = DB::table('markups')
					->where('user_type', @$requestData['user_type'])->where('flight_type', @$requestData['markup_tpe'])
					->update(['flight_type' => @$requestData['markup_tpe'],'service_fee' => @$requestData['amount'],'service_type' => @$requestData['service_type'],'user_type' => @$requestData['user_type']]);
				/* }else{ 
					$saved = DB::table('markups')
					->where('user_type', @$requestData['user_type'])->where('flight_type', @$requestData['markup_tpe'])
					->update(['flight_type' => @$requestData['markup_tpe'],'service_type' => @$requestData['service_type'],'commission_fee' => @$requestData['commission_fee'],'commission_fee' => @$requestData['amount'],'user_type' => @$requestData['user_type']]);
				//} */
				
					
					
			
			}
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				
				return Redirect::to('/admin/flightmarkup')->with('success', 'Markup added Successfully');
			}	
		}
	}
	public function commission(Request $request)
	{
	
		$QUESRY = Markup::where('flight_type',$request->markup_tpe);
			
		
		$markups = $QUESRY->get();
		$type = $request->com_type;
		$flight_type = $request->markup_tpe;
		return view('Admin.flightmarkup.commission', compact(['markups','type','flight_type'])); 	
	}
	public function store(Request $request)
	{
		//check authorization start	
			/* $check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			} */	
		//check authorization end
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'flight_code' => 'required|max:255'
									  ]);
			
			$requestData 		= 	$request->all();
			$is_exist = Markup::where('flight_type',$request->flight_type)->where('flight_code',$request->flight_code)->where('user_type',$request->user_type)->exists();
			if($is_exist){
				return Redirect::to('/admin/flightmarkup')->with('error', 'Already Exists');
			}
			$obj					= 	new Markup;
			$obj->flight_code		=	@$requestData['flight_code'];
			$obj->flight_type		=	@$requestData['flight_type'];
			$obj->service_fee		=	@$requestData['service_fee'];
			$obj->service_type		=	@$requestData['service_type'];
			$obj->commission_type	=	@$requestData['service_type'];
			$obj->commission_fee	=	@$requestData['commission_fee'];
			$obj->user_type			=	@$requestData['user_type'];
			
			$saved					=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/flightmarkup')->with('success', 'Markup added Successfully');
			}				
		}	
		
	}
	
}