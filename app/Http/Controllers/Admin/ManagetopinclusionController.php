<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\Topinclusion;
use App\SuperTopInclusion;
 
use Auth;
use Config;
 
class ManagetopinclusionController extends Controller
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
		
			$query 		= SuperTopInclusion::where('id','!=','' );
		
				
		$totalData 	= $query->count();	//for all data
		if ($request->has('topid')) 
		{
			$inc_id 		= 	$request->input('topid'); 
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
		$lists		= $query->with(['topinclusion' => function($query)  use ($userid){
			$query->select('id','top_inc_id','name','status','image')->where('user_id', '=', $userid);
		}])->orderby('id','ASC')->get();
		
		return view('Admin.managetopinclusion.index',compact(['lists', 'totalData'])); 	  
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
		return view('Admin.managetopinclusion.create');
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
			
			$obj				= 	new Topinclusion;
			$obj->user_id	=	Auth::user()->id;			
			$obj->name	=	@$requestData['name'];
			
			// Topinclusion Image Upload Function Start 						  
					if($request->hasfile('image')) 
					{	
						$topinclu_image = $this->uploadFile($request->file('image'), Config::get('constants.topinclusion_img')); 
					}
					else
					{
						$topinclu_image = NULL;
					}	 	
				// Topinclusion Image Upload Function End
				
			$obj->image			=	@$topinclu_image;
			$saved		 		=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/topinclusion')->with('success', 'Topinclusion Added Successfully');
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
			
			if(Topinclusion::where('top_inc_id', '=', $requestData['id'])->where('user_id', '=', Auth::user()->id)->exists()) 
			{
				if($request->hasfile('image')) 
				{	
					if($requestData['image'] != '')
						{
							$this->unlinkFile($requestData['old_image'], Config::get('constants.topinclusion_img'));
						}
					$topinclu_image = $this->uploadFile($request->file('image'), Config::get('constants.topinclusion_img')); 
				}
				else
				{
					$topinclu_image = @$requestData['old_image'];
				}
				 $obj				= 	Topinclusion::find(@$requestData['topinid']);
				$obj->user_id		=	Auth::user()->id;	
				if(isset($requestData['status']) && $requestData['status'] != ''){
					$obj->status		=	1;
				}else{
					$obj->status		=	0;
				}						
				$obj->image		=	@$topinclu_image;			
				
				$saved				=	$obj->save();
				
				if(!$saved)
				{
					return redirect()->back()->with('error', Config::get('constants.server_error'));
				}
				else
				{
					return Redirect::to('/admin/topinclusion')->with('success', 'Top Inclusion Edited Successfully');
				}
				
			}else{
				if($request->hasfile('image')) 
				{	
					$topinclu_image = $this->uploadFile($request->file('image'), Config::get('constants.topinclusion_img')); 
				}
				else
				{
					$topinclu_image = NULL;
				}
				$obj				= new Topinclusion;
				if(isset($requestData['status']) && $requestData['status'] != ''){
					$obj->status		=	1;
				}else{
					$obj->status		=	0;
				}
							
				$obj->image			=	@$topinclu_image;			
				$obj->top_inc_id		=	@$requestData['id'];			
				$obj->user_id		=	Auth::user()->id;			
				$saved				=	$obj->save();
				
				if(!$saved)
				{
					return redirect()->back()->with('error', Config::get('constants.server_error'));
				}
				else
				{
					return Redirect::to('/admin/topinclusion')->with('success', 'Top Inclusion Edited Successfully');
				}
			}
							
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(SuperTopInclusion::where('id', '=', $id)->exists()) 
				{
					$query = SuperTopInclusion::where('id','=',$id);
					$userid = Auth::user()->id;
				$fetchedData		= $query->with(['topinclusion' => function($query)  use ($userid){
					$query->select('id','top_inc_id','name','status','image')->where('user_id', '=', $userid);
				}])->first();
					return view('Admin.managetopinclusion.edit', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/topinclusion')->with('error', 'Topinclusion Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/topinclusion')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	 
	
}
