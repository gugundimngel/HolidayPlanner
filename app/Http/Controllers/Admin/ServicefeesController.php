<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\MyConfig;
 
use Auth;  
use Config;

class ServicefeesController extends Controller
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
			/*  $check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	 */
		//check authorization end
		
		 /* if(Auth::user()->role == 1){
			$query 		= Contact::where('id','!=','' )->with(['user']); 
		 }else{	
			$query 		= Contact::where('user_id', '=', Auth::user()->id);
		 }	 */
		 
		
		return view('Admin.settings.servicefees'); 	
		
	}
	public function store(Request $request){
		if ($request->isMethod('post'))  
		{
			$requestData 		= 	$request->all();
			//echo '<pre>'; print_r($requestData); die;
			
			foreach($requestData['fee'] as $key => $gt){ 
				
				if(MyConfig::where('meta_key',$key)->exists()){
					$id = MyConfig::where('meta_key',$key)->first()->id;
					
					 $myconfig = MyConfig::find($id);
					$myconfig->meta_value = $gt;
					$saved = $myconfig->save();
				}else{
					$myconfig = new MyConfig;
					$myconfig->meta_key = $key;
					$myconfig->meta_value = $gt;
					$saved = $myconfig->save();
				}
			}
			
			 
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/servicefees')->with('success', 'Service Fees added Successfully');
			}
		} 
	}
}