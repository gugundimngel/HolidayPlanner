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
 
class SmsGatewayController extends Controller
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
		return view('Admin.gateways.sms');
	}
	
	public function store(Request $request){
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
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
				return Redirect::to('/admin/settings/sms-gateway')->with('success', 'SMS Gateway added Successfully');
			}
		}
	}
}	?>