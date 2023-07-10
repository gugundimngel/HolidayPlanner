<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;

use App\Addon;
 
use Auth;
use Config;
 //use DataTables;
class ManageaddonController extends Controller
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
		
		$query 		= Addon::where('id','!=','');
		if ($request->has('name')) 
		{
			$name 		= 	$request->input('name'); 
			if(trim($name) != '')
			{
				$query->where('title', 'LIKE', '%'.@$name.'%');
			}
		}
		
		$totalData 	= $query->count();	//for all data

		$lists		= $query->orderby('id','desc')->get();
		
		return view('Admin.manageaddon.index',compact(['lists', 'totalData']));  
	}
	 
	public function create(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		return view('Admin.manageaddon.create');
	} 
	
	public function store(Request $request)
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
										'title' => 'required|max:255'
									  ]);
			
			$requestData 		= 	$request->all();
			
			$obj				= 	new Addon;
			$obj->title			=	@$requestData['title'];
			$obj->price			=	@$requestData['price'];
			$obj->child_price3	=	@$requestData['child_price3'];
			$obj->child_price2	=	@$requestData['child_price2'];
			$obj->infant_price	=	@$requestData['infant_price'];
			$obj->duration		=	@$requestData['duration'];
			$obj->description	=	@$requestData['description'];
			//$obj->destination	=	@$requestData['destination'];
			//$obj->dest_type	=	@$requestData['dest_type'];
			
			$saved				=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/addons')->with('success', 'Addon added Successfully');
			}				
		}	
		
	}
	
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
			
			$this->validate($request, [
										'title' => 'required|max:255'
									  ]);
									  
									  
			$obj				= 	Addon::find($requestData['id']);
			
			$obj->title			=	@$requestData['title'];
			$obj->price			=	@$requestData['price'];
			$obj->duration		=	@$requestData['duration'];
			$obj->description	=	@$requestData['description'];
			$obj->child_price3	=	@$requestData['child_price3'];
			$obj->child_price2	=	@$requestData['child_price2'];
			$obj->infant_price	=	@$requestData['infant_price'];
			//$obj->destination	=	@$requestData['destination'];
			//$obj->dest_type	=	@$requestData['dest_type'];
			$saved = $obj->save();
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/addons')->with('success', 'Addon Edited Successfully');
			}				
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(Addon::where('id', '=', $id)->exists()) 
				{
					$fetchedData = Addon::find($id);
					
					return view('Admin.manageaddon.edit', compact(['fetchedData']));
				}
				else 
				{
					return Redirect::to('/admin/addons')->with('error', 'Addon Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/addons')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	 
	
}
