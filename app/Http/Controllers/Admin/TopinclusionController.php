<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\SuperTopInclusion;
 
use Auth;
use Config;
 
class TopinclusionController extends Controller
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
			if(Auth::user()->role != 1)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		$query 		= SuperTopInclusion::where('id', '!=', '');
		 
				
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
		$lists		= $query->orderby('id','desc')->get();
		
		return view('Admin.supertopinclusion.index',compact(['lists', 'totalData'])); 	  
	}
	
	public function create(Request $request)
	{
		//check authorization start	
			if(Auth::user()->role != 1)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		return view('Admin.supertopinclusion.create');
	}
	
	public function store(Request $request)
	{
		//check authorization start	
			if(Auth::user()->role != 1)
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
			
			$obj				= 	new SuperTopInclusion;
			//$obj->user_id	=	Auth::user()->id;			
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
				return Redirect::to('/admin/top-inclusion')->with('success', 'Topinclusion Added Successfully');
			}				
		}	
		
	}
	
	public function edit(Request $request, $id = NULL)
	{			
		//check authorization start	
			if(Auth::user()->role != 1)
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
									  
									  
			$obj				= 	SuperTopInclusion::find($requestData['id']);
			$obj->name			=	@$requestData['name'];
			
			/* Destination Image Upload Function Start */						  
			if($request->hasfile('image')) 
			{	
				/* Unlink File Function Start */ 
					if($requestData['image'] != '')
						{
							$this->unlinkFile($requestData['old_image'], Config::get('constants.topinclusion_img'));
						}
				/* Unlink File Function End */
				
				$topinclu_image = $this->uploadFile($request->file('image'), Config::get('constants.topinclusion_img'));
			}
			else
			{
				$topinclu_image = @$requestData['old_image'];
			}		
		/* Destination Image Upload Function End */ 
		
			$obj->image			=	@$topinclu_image;
						
			$saved				=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/top-inclusion')->with('success', 'Topinclusion Edited Successfully');
			}				
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(SuperTopInclusion::where('id', '=', $id)->exists()) 
				{
					$fetchedData = SuperTopInclusion::find($id);
					return view('Admin.supertopinclusion.edit', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/top-inclusion')->with('error', 'Topinclusion Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/top-inclusion')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	 
	
}
