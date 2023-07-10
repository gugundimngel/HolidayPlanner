<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\Gallery;
 
use Auth;
use Config;
 
class GalleryController extends Controller
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
		if(Auth::user()->role == 1){
			$query 		= Gallery::where('id','!=','' )->with(['user']);
		}else{
			$query 		= Gallery::where('user_id', '=', Auth::user()->id);
		}
		
		$totalData 	= $query->count();	//for all data

		$lists		= $query->sortable(['id' => 'Asc'])->paginate(config('constants.limit'));
		
		return view('Admin.managegallery.index',compact(['lists', 'totalData']));  
	}
	
	public function create(Request $request)
	{
		
		return view('Admin.managegallery.create');
	}
	
	public function store(Request $request)
	{
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'gallery_name' => 'required|max:255'
									  ]);
			
			$requestData 		= 	$request->all();
			
			$obj				= 	new Gallery;
			$obj->user_id	=	Auth::user()->id;
			$obj->gallery_name	=	@$requestData['gallery_name'];
			
			// Gallery Image Upload Function Start 						  
					if($request->hasfile('gallery')) 
					{	
						$gallery_image = $this->uploadFile($request->file('gallery'), Config::get('constants.gallery_img')); 
					}
					else
					{
						$gallery_image = NULL;
					}	 	
				// Gallery Image Upload Function End
				
			$obj->gallery			=	@$gallery_image;
			$saved		 		=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/gallery')->with('success', 'Gallery Added Successfully');
			}				
		}	
		
	}
	
	public function edit(Request $request, $id = NULL)
	{			
		//check authorization end
	
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$this->validate($request, [
										'gallery_name' => 'required|max:255'
									  ]);
									  
									  
			$obj				= 	Gallery::find($requestData['id']);
			$obj->gallery_name			=	@$requestData['gallery_name'];
			
			/* Gallery Image Upload Function Start */						  
			if($request->hasfile('gallery')) 
			{	
				/* Unlink File Function Start */ 
					if($requestData['gallery'] != '')
						{
							$this->unlinkFile($requestData['old_gallery'], Config::get('constants.gallery_img'));
						}
				/* Unlink File Function End */
				
				$gallery_image = $this->uploadFile($request->file('gallery'), Config::get('constants.gallery_img'));
			} 
			else
			{
				$gallery_image = @$requestData['old_gallery'];
			}		
		/* Gallery Image Upload Function End */ 
		
			$obj->gallery			=	@$gallery_image;
						
			$saved				=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/gallery')->with('success', 'Gallery Edited Successfully');
			}				
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(Gallery::where('id', '=', $id)->exists()) 
				{
					$fetchedData = Gallery::find($id);
					return view('Admin.managegallery.edit', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/gallery')->with('error', 'Gallery Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/gallery')->with('error', Config::get('constants.unauthorized'));
			}		 
		}				
	}
	 
	
}
