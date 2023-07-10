<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\HotelMarkup;
 
use Auth;  
use Config;

class HotelmarkupController extends Controller
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
		$query = HotelMarkup::where('id','!=', '')->orderby('id', 'DESC');
		$hotellist = $query->paginate(20);
		return view('Admin.hotelmarkup.index', compact('hotellist')); 	
		
	}
	
	public function create(Request $request){
		return view('Admin.hotelmarkup.create'); 
	}
	
	public function edit(Request $request, $id = Null)
	{ 
		if ($request->isMethod('post')) 
		{ 
				$requestData 		= 	$request->all();
			
			$obj					= 	HotelMarkup::find(@$requestData['id']);
			$obj->user_type		=	@$requestData['user_type'];
			$obj->markup_type		=	@$requestData['markup_type'];
			$obj->markup_fee		=	@$requestData['markup_fee'];
			$obj->amount_type		=	@$requestData['amount_type'];
			//$obj->hotel_type	=	@$requestData['hotel_type'];
			if(@$requestData['markup_type'] == 'city_wise'){
				
				$obj->city_code	=	@$requestData['searchcode'];
			}else{
				$obj->hotel_code			=	@$requestData['searchcode'];
			}
			
			
			
			$saved					=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/hotelmarkup')->with('success', 'Markup updated Successfully');
			}
		}else{
			if(isset($id) && !empty($id))
			{ 
				$id = $this->decodeString($id);	
				if(HotelMarkup::where('id', '=', $id)->exists()) 
				{
					$fetchedData = HotelMarkup::where('id', '=', $id)->first();
					return view('Admin.hotelmarkup.edit', compact(['fetchedData']));
				} 
				else
				{
					return Redirect::to('/admin/hotelmarkup')->with('error', 'Markup Not Exist');
				}
			}else{
				return Redirect::to('/admin/hotelmarkup')->with('error', Config::get('constants.unauthorized'));
			}
		}
	}
	
	public function store(Request $request)
	{
		
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'user_type' => 'required|max:255'
									  ]);
			
			$requestData 		= 	$request->all();
			
			$obj					= 	new HotelMarkup;
			$obj->user_type		=	@$requestData['user_type'];
			$obj->markup_type		=	@$requestData['markup_type'];
			$obj->markup_fee		=	@$requestData['markup_fee'];
			$obj->amount_type		=	@$requestData['amount_type'];
			//$obj->hotel_type	=	@$requestData['hotel_type'];
			if(@$requestData['markup_type'] == 'city_wise'){
				
				$obj->city_code	=	@$requestData['searchcode'];
			}else{
				$obj->hotel_code			=	@$requestData['searchcode'];
			}
			
			
			
			$saved					=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/hotelmarkup')->with('success', 'Markup added Successfully');
			}				
		}	
		
	}
	
}