<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\BankAccount;
 
use Auth;  
use Config;

class BankAccountController extends Controller
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
	
	public function index(Request $request)
	{
		$query 		= BankAccount::where('id','!=','' );
		
		$totalData 	= $query->count();
		$lists		= $query->get(); 
		//print_r($lists); die;
		return view('Admin.settings.bankaccounts',compact(['lists', 'totalData'])); 
	}
	public function create(Request $request) 
	{
		//check authorization start	
			/* $check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	 
		//check authorization end
		
		$managecontact 		=  Managecontact::all();	 */	
		return view('Admin.settings.createaccount');
	}
	
	 public function store(Request $request)
	{
		//check authorization start	
			/* $check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	 */
		//check authorization end
		if ($request->isMethod('post')) 
		{
			
			$requestData 		= 	$request->all();

			$obj				= 	new BankAccount;   
			$obj->bank_name		=	@$requestData['bank_name'];
			$obj->account_no		=	@$requestData['account_no'];
			$obj->company_bank_name		=	@$requestData['company_bank_name'];
			$obj->bank_city		=	@$requestData['bank_city'];
			$obj->bank_address			=	@$requestData['bank_address'];
			$obj->postal_code			=	@$requestData['postal_code'];
			$obj->ifsc_code			=	@$requestData['ifsc_code'];
			$obj->swift_code			=	@$requestData['swift_code'];
			$saved				=	$obj->save();  
			
			if(!$saved) 
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{ 
				return Redirect::to('/admin/settings/bank-accounts/')->with('success', 'Bank Account added Successfully');
			} 				
		}	 
	}
	
	public function edit(Request $request, $id = NULL)
	{			
		//check authorization end
	//check authorization start	
			/* $check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			} */	
		//check authorization end
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();

			$obj				= 	 BankAccount::find($requestData['id']);   
			$obj->bank_name		=	@$requestData['bank_name'];
			$obj->account_no		=	@$requestData['account_no'];
			$obj->company_bank_name		=	@$requestData['company_bank_name'];
			$obj->bank_city		=	@$requestData['bank_city'];
			$obj->bank_address			=	@$requestData['bank_address'];
			$obj->postal_code			=	@$requestData['postal_code'];
			$obj->ifsc_code			=	@$requestData['ifsc_code'];
			$obj->swift_code			=	@$requestData['swift_code'];
			$saved				=	$obj->save();  
			
			if(!$saved) 
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{ 
				return Redirect::to('/admin/settings/bank-accounts/')->with('success', 'Bank Account added Successfully');
			} 				
		}
		else
		{	 
			if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	 
				if(BankAccount::where('id',$id)->exists()) 
				{
					$fetchedData = BankAccount::find($id);
					return view('Admin.settings.editbank', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/settings/editbank')->with('error', 'Bank Account Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/settings/editbank')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
}
?>