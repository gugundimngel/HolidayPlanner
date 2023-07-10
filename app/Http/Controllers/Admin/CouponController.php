<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\Coupon;
 
use Auth;  
use Config;

class CouponController extends Controller
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
		
		$query 		= Coupon::where('id','!=','' );
		
		$totalData 	= $query->count();	//for all data

		$lists		= $query->get(); 
		
		return view('Admin.coupon.index',compact(['lists', 'totalData'])); 
		
		//return view('Admin.managecontact.index'); 	
		
	}
	
	public function create(Request $request) 
	{
		//check authorization start	
			/* $check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	 
		//check authorization end
		
		$managecontact 		=  Managecontact::all();	 */	
		return view('Admin.coupon.create');
	}
	
	
	 public function store(Request $request)
	{
		//check authorization start	
			/* $check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	 */
		//check authorization end
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
			'coupon_name' => 'required|max:255|unique:coupons',
			'coupon_code' => 'unique:coupons',
			
			'type' => 'required',
			'discount_type' => 'required',
			'discount' => 'required',
			'start_date' => 'required',
			'end_date' => 'required'
		  ]);
		 
		  $requestData 		= 	$request->all();
			  
		 
		  
			$obj						= 	new Coupon; 
			$obj->coupon_name			=   @$requestData['coupon_name'];  
			$obj->type				=	@$requestData['type'];
			$obj->discount_type			=	@$requestData['discount_type'];
			$obj->no_of_coupon			=	@$requestData['no_of_coupon'];		 	
			$obj->discount			=	@$requestData['discount'];			
			$obj->start_date				=	date('Y-m-d', strtotime(@$requestData['start_date']));
			$obj->image	=	@$requestData['offer_image_m_id'];	
			$obj->shortdescription	=	@$requestData['shortdescription'];	
			$obj->end_date				=	date('Y-m-d', strtotime(@$requestData['end_date']));			
			$obj->description			=	@$requestData['description'];
			
			$saved				=	$obj->save(); 
			if($requestData['coupon_code'] == ''){
				$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
				$res = "";
				for ($i = 0; $i < 10; $i++) {
					$res .= $chars[mt_rand(0, strlen($chars)-1)];
				}
			}else{
				$res = $requestData['coupon_code'];
			}
			$cop = Coupon::find($obj->id);
			$cop->coupon_code = $res;
			$save				=	$cop->save(); 
			
			if(!$saved) 
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{ 
				return Redirect::to('/admin/coupon-code')->with('success', 'Coupon added Successfully');
			} 				
		}	 
	} 
	
	 
	 public function edit(Request $request, $id = NULL)
	{			
		//check authorization end
	//check authorization start	
			/* $check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			} */	
		//check authorization end
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			$this->validate($request, [
			'coupon_name' => 'required|max:255|unique:coupons,coupon_name,'.$requestData['id'],
			'coupon_code' => 'unique:coupons,coupon_code,'.$requestData['id'],
			
			'type' => 'required',
			'discount_type' => 'required',
			'discount' => 'required',
			'start_date' => 'required',
			'end_date' => 'required'
		  ]);
		 
		  
			  
		 
		  
			$obj						= 	Coupon::find($requestData['id']); 
			$obj->coupon_name			=   @$requestData['coupon_name'];  
			$obj->type					=	@$requestData['type'];
			$obj->discount_type			=	@$requestData['discount_type'];
			$obj->no_of_coupon			=	@$requestData['no_of_coupon'];		 	
			$obj->discount				=	@$requestData['discount'];			
			$obj->start_date			=	date('Y-m-d', strtotime(@$requestData['start_date']));
			$obj->end_date				=	date('Y-m-d', strtotime(@$requestData['end_date']));
			$obj->image					=	@$requestData['offer_image_m_id'];	
			$obj->shortdescription		=	@$requestData['shortdescription'];			
			$obj->description			=	@$requestData['description'];
			
			$saved						=	$obj->save(); 
			if($requestData['coupon_code'] == ''){
				$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
				$res = "";
				for ($i = 0; $i < 10; $i++) {
					$res .= $chars[mt_rand(0, strlen($chars)-1)];
				}
			}else{
				$res = $requestData['coupon_code'];
			}
			$cop = Coupon::find($requestData['id']);
			$cop->coupon_code = $res;
			$save				=	$cop->save(); 					
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/coupon-code')->with('success', 'Contact Edited Successfully');
			}				
		}
		else
		{	 
			if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	 
				if(Coupon::where('id', '=', $id)->exists()) 
				{
					$fetchedData = Coupon::find($id);
					return view('Admin.coupon.edit', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/coupon-code')->with('error', 'Contact Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/coupon-code')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	} 
	
	
}
