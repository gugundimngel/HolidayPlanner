<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\Holidaytype;
use App\HolidayTheme;
 
use Auth;
use Config;
 
class ManageholidaytypeController extends Controller
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
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		//DB::enableQueryLog(); 
			$query 		= HolidayTheme::where('id', '!=', '');
		
		$totalData 	= $query->count();	//for all data
		if ($request->has('type')) 
		{
			$inc_id 		= 	$request->input('type'); 
			if(trim($inc_id) != '')
			{
				$query->where('id', '=', @$inc_id);
			}
		} 
		 
		if ($request->has('name')) 
		{
			$name 		= 	$request->input('name'); 
			if(trim($name) != '')
			{
				$query->where('name', 'LIKE', '%'.@$name.'%');
			} 
		}
		$userid = Auth::user()->id;
		$lists		= $query->with(['holidaytype' => function($query)  use ($userid){
			$query->select('id','theme_id','name','status','image')->where('user_id', '=', $userid);
		}])->orderby('id','ASC')->get();
		//dd(DB::getQueryLog());
		return view('Admin.manageholidaytype.index',compact(['lists', 'totalData'])); 	

		//return view('Admin.manageholidaytype.index');	  
	}
	
	/* public function create(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		return view('Admin.manageholidaytype.create');
	}  */
	
	/* public function store(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'name' => 'required|max:255',
										'status' => 'required|max:255'
									  ]);
			
			$requestData 		= 	$request->all();
			 
			$obj				= 	new Holidaytype;
			$obj->user_id	=	Auth::user()->id;
			$obj->name			=	@$requestData['name'];
			$obj->status		=	@$requestData['status'];
			$obj->description		=	@$requestData['description'];
			
			$saved				=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/holidaytype')->with('success', 'Holidaytype added Successfully');
			}				
		}	

	
	} */
	
	public function edit(Request $request, $id = NULL)
	{			
		//check authorization start	
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
	
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			if(Holidaytype::where('theme_id', '=', $requestData['id'])->where('user_id', '=', Auth::user()->id)->exists()) 
			{
				if($request->hasfile('image')) 
				{	
					if($requestData['image'] != '')
						{
							$this->unlinkFile($requestData['old_image'], Config::get('constants.themes_img'));
						}
					$topinclu_image = $this->uploadFile($request->file('image'), Config::get('constants.themes_img')); 
				}
				else
				{
					$topinclu_image = @$requestData['old_image'];
				}
				
				if($request->hasfile('banner_image')) 
				{	
					if($requestData['banner_image'] != '')
						{
							$this->unlinkFile($requestData['banner_old_image'], Config::get('constants.themes_img'));
						}
					$banner_image = $this->uploadFile($request->file('banner_image'), Config::get('constants.themes_img')); 
				}
				else
				{
					$banner_image = @$requestData['banner_old_image'];
				}
				 $obj				= 	Holidaytype::find($requestData['typeinid']);
				$obj->user_id		=	Auth::user()->id;	
				if(isset($requestData['status']) && $requestData['status'] != ''){
					$obj->status		=	1;
				}else{
					$obj->status		=	0;
				}							
				$obj->image		=	@$topinclu_image;			
				$obj->banner_image		=	@$banner_image;			
				$obj->description		=	@$requestData['description'];			
				
				$saved				=	$obj->save();
				
				if(!$saved)
				{
					return redirect()->back()->with('error', Config::get('constants.server_error'));
				}
				else
				{
					return Redirect::to('/admin/holidaytype')->with('success', 'Holidaytype Edited Successfully');
				} 
			}else{
				if($request->hasfile('image')) 
				{	
					$topinclu_image = $this->uploadFile($request->file('image'), Config::get('constants.themes_img')); 
				}
				else
				{
					$topinclu_image = NULL;
				}
				$obj				= new Holidaytype;
				
				if(isset($requestData['status']) && $requestData['status'] != ''){
					$obj->status		=	1;
				}else{
					$obj->status		=	0;
				}		
				$obj->image			=	@$topinclu_image;			
				$obj->theme_id		=	@$requestData['id'];	
				$obj->description		=	@$requestData['description'];					
				$obj->user_id		=	Auth::user()->id;			
				$saved				=	$obj->save();
				
				if(!$saved)
				{
					return redirect()->back()->with('error', Config::get('constants.server_error'));
				}
				else
				{
					return Redirect::to('/admin/holidaytype')->with('success', 'Holidaytype Edited Successfully');
				}
			}			
												
		}
		else
		{	
			if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	
				if(HolidayTheme::where('id', '=', $id)->exists()) 
				{
					$query = HolidayTheme::where('id','=',$id);
					$userid = Auth::user()->id;
				$fetchedData		= $query->with(['holidaytype' => function($query)  use ($userid){
					$query->select('id','theme_id','name','status','description','banner_image','image')->where('user_id', '=', $userid);
				}])->first();
					return view('Admin.manageholidaytype.edit', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/holidaytype')->with('error', 'Holidaytype Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/holidaytype')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	 
	
}
