<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

use App\DiscountTestSeries;

use Auth;
use Config;

class DiscountTestSeriesController extends Controller
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
     * All Test Series Discount. 
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('DiscountTestSeries', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		$query 		= DiscountTestSeries::where('id', '!=', '');
		
		$totalData 	= $query->count();	//for all data
		
		if ($request->has('search_term')) 
		{
			$search_term 		= 	$request->input('search_term');
			if(trim($search_term) != '')
			{
				$query->where('discount', 'LIKE', '%' . $search_term . '%');
			}
			
			$totalData 	= $query->count();//after search
		
		}	
		$lists		= $query->sortable(['id'=>'desc'])->paginate(config('constants.limit'));

		return view('Admin.test_series_discount.index',compact(['lists', 'totalData']));	
	}
	/**
     * Add Test Series Discount.
     *
     * @return \Illuminate\Http\Response
     */
	public function addTestSeriesDiscount(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('DiscountTestSeries', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
	
		if ($request->isMethod('post')) 
		{
			$requestData 			= 	$request->all();
			
			$this->validate($request, [
										'subject_numbers' => 'required|unique:discount_test_series',
										'discount' => 'required',
									  ]);

			$obj					= 	new DiscountTestSeries;
			$obj->subject_numbers	=	$requestData['subject_numbers'];
			$obj->discount			=	@$requestData['discount'];
			
			$saved					=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/test_series_discounts')->with('success', 'Test Series Discount'.Config::get('constants.added'));
			}				
		}
		return view('Admin.test_series_discount.add_test_series_discount');		
	}
	
	public function editTestSeriesDiscount(Request $request, $id = NULL)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('DiscountTestSeries', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end	

	
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$this->validate($request, [
										'subject_numbers' => 'required|unique:discount_test_series,subject_numbers,'.$requestData['id'],
										'discount' => 'required',
									  ]); 					  
									  
			$obj					= 	DiscountTestSeries::find($requestData['id']);
			$obj->subject_numbers	=	$requestData['subject_numbers'];
			$obj->discount			=	@$requestData['discount'];
			
			$saved					=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/test_series_discounts')->with('success', 'Test Series Discount'.Config::get('constants.edited'));
			}				
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(DiscountTestSeries::where('id', '=', $id)->exists()) 
				{
					$fetchedData = DiscountTestSeries::find($id);
					return view('Admin.test_series_discount.edit_test_series_discount', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/test_series_discounts')->with('error', 'Test Series Discount'.Config::get('constants.not_exist'));
				}	
			}
			else
			{
				return Redirect::to('/admin/test_series_discounts')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
}
