<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\Inclusion;
 
use Auth;
use Config;
 
class ManageinclusionController extends Controller
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
		if(Auth::user()->role == 1){
			$query 		= Inclusion::where('id','!=','' )->with(['user']);
		}else{	
			$query 		= Inclusion::where('user_id', '=', Auth::user()->id);
		 } 
				
		$totalData 	= $query->count();	//for all data
		if ($request->has('inc_id')) 
		{
			$inc_id 		= 	$request->input('inc_id'); 
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
		$lists		= $query->orderby('id','desc')->get();
		
		return view('Admin.manageinclusion.index',compact(['lists', 'totalData'])); 

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
		return view('Admin.manageinclusion.create');
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
										'name' => 'required|max:255'
									  ]);
			
			$requestData 		= 	$request->all();
			
			$obj				= 	new Inclusion;
			$obj->user_id	=	Auth::user()->id;
			
			$obj->name	=	@$requestData['name'];
			
			$saved				=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/inclusion')->with('success', 'Inclusion added Successfully');
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
										'name' => 'required|max:255'
									  ]);
									  
									  
			$obj				= 	Inclusion::find($requestData['id']);
			$obj->name			=	@$requestData['name'];
						
			$saved				=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/inclusion')->with('success', 'Inclusion Edited Successfully');
			}				
		} 
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(Inclusion::where('id', '=', $id)->exists()) 
				{
					$fetchedData = Inclusion::find($id);
					return view('Admin.manageinclusion.edit', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/inclusion')->with('error', 'Inclusion Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/inclusion')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	 
	
}
