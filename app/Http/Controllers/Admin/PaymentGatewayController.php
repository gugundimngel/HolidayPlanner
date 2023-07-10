<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\Holidaytype;
use App\MyConfig;
 
use Auth;
use Config;
 
class PaymentGatewayController extends Controller
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
		return view('Admin.gateways.index');
	}
	
	public function store(Request $request){
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			//echo '<pre>'; print_r($requestData); die;
			if(isset($requestData['gateway']['cc_name'])){
				if(isset($requestData['gateway']['cc_status'])){
					$requestData['gateway']['cc_status'] = 1;
				}else{
					$requestData['gateway']['cc_status'] = 0;
				}
			}
			if(isset($requestData['gateway']['rz_paykey'])){
				if(isset($requestData['gateway']['rz_status'])){
					$requestData['gateway']['rz_status'] = 1;
				}else{
					$requestData['gateway']['rz_status'] = 0;
				}
			}
			foreach($requestData['gateway'] as $key => $gt){
				
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
				return Redirect::to('/admin/settings/payment-gateway')->with('success', 'Gateway added Successfully');
			}
		}
	}
}	?>