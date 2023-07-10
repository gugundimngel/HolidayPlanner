<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Route;

use App\ModeProduct;

use Auth;
use Config;

class ModeProductController extends Controller
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
     * All Mode of Product.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('ModeProduct', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		$query 		= ModeProduct::where('id', '!=', '');
		
		$totalData 	= $query->count();	//for all data
		
		if ($request->has('search_term')) 
		{
			$search_term 		= 	$request->input('search_term');
			if(trim($search_term) != '')
			{		
				$query->where('mode_product', 'LIKE', '%' . $search_term . '%');
			}
			$totalData 	= $query->count();//after search
		}	
		$lists		= $query->sortable(['id' => 'desc'])->paginate(config('constants.limit'));
		
		return view('Admin.mode_product.index',compact(['lists', 'totalData']));	
	}
	/**
     * Add Mode of Product.
     *
     * @return \Illuminate\Http\Response
     */
	public function addModeProduct(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('ModeProduct', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
	
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'mode_product' => 'required|max:255|unique:mode_products'
									  ]);
			
			
			$requestData 		= 	$request->all();
			
			$obj				= 	new ModeProduct;
			$obj->mode_product	=	$requestData['mode_product'];
			
			$saved				=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/mode_products')->with('success', 'Mode of Product'.Config::get('constants.added'));
			}				
		}
		return view('Admin.mode_product.add_mode_product');		
	}
	
	public function editModeProduct(Request $request, $id = NULL)
	{	
		//check authorization start	
			$check = $this->checkAuthorizationAction('ModeProduct', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
	
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$this->validate($request, [
										'mode_product' => 'required|max:255|unique:mode_products,mode_product,'.$requestData['id']
									  ]);
			$obj				= 	ModeProduct::find($requestData['id']);
			$obj->mode_product	=	$requestData['mode_product'];
			
			$saved				=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/mode_products')->with('success', 'Mode of Product'.Config::get('constants.edited'));
			}				
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(ModeProduct::where('id', '=', $id)->exists()) 
				{
					$fetchedData = ModeProduct::find($id);
					return view('Admin.mode_product.edit_mode_product', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/mode_products')->with('error', 'Mode of Product'.Config::get('constants.not_exist'));
				}	
			}
			else
			{
				return Redirect::to('/admin/mode_products')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	
}
