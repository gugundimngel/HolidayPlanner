<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

use Auth;
use Config;

use App\ComboProduct;
use App\ComboProductRelation;
use App\Professor;
use App\Product;

class ComboProductController extends Controller
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
     * All Combo Products.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('ComboProduct', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		$query 		= ComboProduct::where('id', '!=', '');
		
		$totalData 	= $query->count();	//for all data
		
		//searching start	
			if ($request->has('search_term')) 
			{
				$search_term 		= 	$request->input('search_term');
				if(trim($search_term) != '')	
				{
					$query->where('combo_name', 'LIKE', '%' . $search_term . '%');
				}
			}
			if ($request->has('search_term_from')) 
			{
				$search_term_from 		= 	$request->input('search_term_from');
				if(trim($search_term_from) != '')
				{
					$query->whereDate('created_at', '>=', $search_term_from);
				}
			}
			if ($request->has('search_term_to')) 
			{	
				$search_term_to 		= 	$request->input('search_term_to');
				if(trim($search_term_to) != '')
				{
					$query->whereDate('created_at', '<=', $search_term_to);
				}	
			}
			
			if ($request->has('search_term') || $request->has('search_term_from') || $request->has('search_term_to')) 
			{
				$totalData 	= $query->count();//after search
			}
		//searching end	

		$lists		= $query->sortable(['id'=>'desc'])->paginate(config('constants.limit'));	

		return view('Admin.combo_product.index',compact(['lists', 'totalData']));	
	}
	/**
     * Add Combo Product.
     *
     * @return \Illuminate\Http\Response
     */
	public function addComboProduct(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('ComboProduct', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		/* Get all Select Data */		
			$products = Product::select('id', 'professor_id', 'subject_name')->where('status', '=', 1)->with(['professor'=>function($query){
				$query->select('id', 'first_name', 'last_name');
			}])->get();	
		/* Get all Select Data */
		
		if ($request->isMethod('post')) 
		{
			$requestData 					= 	$request->all();
			
			$this->validate($request, [
										'combo_name' => 'required|max:255',
										'discount' => 'required|max:10',
										'combo' => 'required',
									  ],
									  [
										'combo.required' => 'Please checked at least one product for combo pack.',
									  ]);	

			$obj							= 	new ComboProduct;
			
			$obj->combo_name				=	@$requestData['combo_name'];
			$obj->discount					=	@$requestData['discount'];

			$saved							=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				//combo product relation start	
					$combo_id = $obj->id; //last inserted product id
					
					foreach(@$requestData['combo'] as $combo)
					{
						$objCombo 					=	new ComboProductRelation;
						$objCombo->combo_id			=	$combo_id;
						$objCombo->product_id		=	$combo;
						
						$objCombo->save();	
					}			
				//combo product relation rnd

				return Redirect::to('/admin/combo_products')->with('success', 'Combo Product'.Config::get('constants.added'));
			}
		}
		return view('Admin.combo_product.add_combo_product',  compact(['products']));		
	}
	
	public function editComboProduct(Request $request, $id = NULL)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('ComboProduct', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		/* Get all Select Data */		
			$products = Product::select('id', 'professor_id', 'subject_name')->where('status', '=', 1)->with(['professor'=>function($query){
				$query->select('id', 'first_name', 'last_name');
			}])->get();	
		/* Get all Select Data */
	
		if ($request->isMethod('post')) 
		{	
			$requestData 					= 	$request->all();
		
			$this->validate($request, [
										'combo_name' => 'required|max:255',
										'discount' => 'required|max:10',
										'combo' => 'required',
									  ],
									  [
										'combo.required' => 'Please checked at least one product for combo pack.',
									  ]);
									  
				  					  
			$obj							= 	ComboProduct::find($requestData['id']);

			$obj->combo_name				=	@$requestData['combo_name'];
			$obj->discount					=	@$requestData['discount'];

			$saved							=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				//Remove old product other info start	
					DB::table('combo_product_relations')->where('combo_id', @$requestData['id'])->delete();
				//Remove old product other info end
				
				//combo product relation start	
					foreach(@$requestData['combo'] as $combo)
					{
						$objCombo 					=	new ComboProductRelation;
						$objCombo->combo_id			=	@$requestData['id'];
						$objCombo->product_id		=	$combo;
						
						$objCombo->save();	
					}			
				//combo product relation rnd
				
				return Redirect::to('/admin/combo_products')->with('success', 'Combo Product'.Config::get('constants.edited'));
			}		
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
	
				if(ComboProduct::where('id', '=', $id)->exists())
				{
					$fetchedData = ComboProduct::find($id);
					
					$comboRelation = ComboProductRelation::where('combo_id', '=', $id)->get();
	
					return view('Admin.combo_product.edit_combo_product', compact(['fetchedData', 'comboRelation', 'products']));
				}
				else
				{
					return Redirect::to('/admin/combo_products')->with('error', 'Combo Product'.Config::get('constants.not_exist'));
				}	
			}
			else
			{
				return Redirect::to('/admin/combo_products')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	
	public function viewComboProduct(Request $request, $id)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('ComboProduct', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		/* Get all Select Data */		
			$products = Product::select('id', 'professor_id', 'subject_name')->where('status', '=', 1)->with(['professor'=>function($query){
				$query->select('id', 'first_name', 'last_name');
			}])->get();	
		/* Get all Select Data */
		
		if(isset($id) && !empty($id))
		{
			$id = $this->decodeString($id);
			if(ComboProduct::where('id', '=', $id)->exists()) 
			{
				$fetchedData = ComboProduct::find($id);
					
				$comboRelation = ComboProductRelation::where('combo_id', '=', $id)->get();		
					
				return view('Admin.combo_product.view_combo_product', compact(['fetchedData', 'comboRelation', 'products']));
			}
			else
			{
				return Redirect::to('/admin/combo_products')->with('error', 'Combo Product'.Config::get('constants.not_exist'));
			}
		}
		else
		{
			return Redirect::to('/admin/combo_products')->with('error', Config::get('constants.unauthorized'));
		}
	}
}
