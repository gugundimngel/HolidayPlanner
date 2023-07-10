<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Admin;

use App\AgentOffer;
use Auth;  
use Config;
class AgentOfferController extends Controller {
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()  {
        $this->middleware('auth:admin'); 
    }
	/**
     * All Vendors. 
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request) {
		//check authorization start	
			/*  $check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)	{ 
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	 */
		//check authorization end
		//$query 		= AgentOffer::where('id', '!=', '');
		$query 		= AgentOffer::where('id', '!=', ''); 
		$totalData 	= $query->count();  
		$lists		= $query->orderby('created_at', 'desc')->paginate(config('constants.limit'));		
		return view('Admin.agentoffer.index', compact(['lists', 'totalData'])); 		
	}

	public function create(Request $request){
		return view('Admin.agentoffer.create'); 
	}
	public function edit(Request $request, $id = Null)	{
		
		if ($request->isMethod('post')) {
			$this->validate($request, [
										'name' => 'required'
									  ]);			
			$requestData 		= 	$request->all();			
			/* Profile Image Upload Function Start */						  

			if($request->hasfile('image')) {	
				/* Unlink File Function Start */ 
					if($requestData['image'] != '') {
							$this->unlinkFile($requestData['old_image'], Config::get('constants.cmspage'));
						}
				/* Unlink File Function End */	
				$offer_image = $this->uploadFile($request->file('image'), Config::get('constants.cmspage'));
			}
			else{
				$offer_image = @$requestData['old_image'];
			}		
		/* Profile Image Upload Function End */
		
			$obj					= 	AgentOffer::find($requestData['id']);
			$obj->name		=	@$requestData['name'];
			$obj->type		=	@$requestData['type'];
			$obj->image		=	@$offer_image;
			$obj->price		=	@$requestData['price'];
			$obj->url		=	@$requestData['url'];
			$obj->offer_type		=	@$requestData['offer_type'];
			$obj->description		=	@$requestData['description'];
			$saved					=	$obj->save(); 				
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/agent-offers')->with('success', 'Offer updated Successfully');
			}
		}else{
			if(isset($id) && !empty($id)){
				$id = $this->decodeString($id);	
				if(AgentOffer::where('id', '=', $id)->exists()){
					$fetchedData = AgentOffer::find($id);
					return view('Admin.agentoffer.edit', compact(['fetchedData']));
				}else{
					return Redirect::to('/admin/agent-offers')->with('error', 'Offer '.Config::get('constants.not_exist'));
				} 
			}else{
				return Redirect::to('/admin/agent-offers')->with('error', Config::get('constants.unauthorized'));
			}
		}

	}

	public function store(Request $request) {
		
		//check authorization start	
			/* $check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check) {
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			} */	
		//check authorization end

		if ($request->isMethod('post')) {
			$this->validate($request, [
										'name' => 'required'
									  ]);
			$requestData 		= 	$request->all();
			if($request->hasfile('image')) 
			{	
				$offer_image = $this->uploadFile($request->file('image'), Config::get('constants.cmspage')); 
			}
			else
			{ 
				$offer_image = NULL;
			}
			$obj					= 	new AgentOffer;
			$obj->type		=	@$requestData['type'];
			$obj->name		=	@$requestData['name'];
			$obj->image		=	@$offer_image;
			$obj->price		=	@$requestData['price'];
			$obj->url		=	@$requestData['url'];
			$obj->offer_type		=	@$requestData['offer_type'];
			$obj->description		=	@$requestData['description'];
			
			$saved					=	$obj->save();  
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/agent-offers')->with('success', 'Offer added Successfully');
			}				
		}			
	}
	
}