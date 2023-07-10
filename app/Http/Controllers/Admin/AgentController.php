<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Agent;
use App\User;
use App\UserRole;
use App\UserType;
use App\CreditLimitLog;
 
use Auth;
use Config;
use Carbon\Carbon;

class AgentController extends Controller
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
		
	
		$query 		= Agent::where('id', '!=', ''); 
		  
		$totalData 	= $query->count();	//for all data
		if ($request->has('agent_id')) 
		{
			$agent_id 		= 	$request->input('agent_id'); 
			if(trim($agent_id) != '')
			{
				$query->where('username', '=', @$agent_id);
			}
		}
		if ($request->has('company_name')) 
		{
			$company_name 		= 	$request->input('company_name'); 
			if(trim($company_name) != '')
			{
				$query->where('company_name', '=', @$company_name);
			}
		}
		if ($request->has('from')) 
		{
			$from 		= 	$request->input('from'); 
			if(trim($from) != '')
			{
				$query->whereDate('created_at', '>=', date('Y-m-d',strtotime(@$from)));
			}
		}if ($request->has('to')) 
		{
			$to 		= 	$request->input('to'); 
			if(trim($to) != '')
			{
				$query->whereDate('created_at', '<=', date('Y-m-d',strtotime(@$to)));
			}
		}if ($request->has('email')) 
		{
			$email 		= 	$request->input('email'); 
			if(trim($email) != '')
			{
				$query->where('email', '=', @$email);
			}
		}if ($request->has('mobile')) 
		{
			$mobile 		= 	$request->input('mobile'); 
			if(trim($email) != '')
			{
				$query->where('mobile_no', '=', @$mobile);
			}
		}
		if ($request->has('status')) 
		{
			$status 		= 	$request->input('status'); 
			if(trim($email) != '')
			{
				$query->where('status', '=', @$status);
			}
		}
		if ($request->has('status') || $request->has('mobile_no') || $request->has('email')|| $request->has('to')|| $request->has('from')|| $request->has('company_name')|| $request->has('agent_id')) 
		{
			$totalData 	= $query->count();//after search
		}
		$lists		= $query->orderby('created_at','DESC')->paginate(20);
		
		return view('Admin.agents.index',compact(['lists', 'totalData']));	

		//return view('Admin.users.index');	 
	}
	
	public function show(Request $request,$id = Null)
	{
		if(isset($id) && !empty($id))
			{
				
				$id = $this->decodeString($id);	
				if(Agent::where('id', '=', $id)->exists()) 
				{
					$fetchedData = Agent::find($id);
					return view('Admin.agents.view', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/agents')->with('error', 'Agent Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/agents')->with('error', Config::get('constants.unauthorized'));
			}			
	}
	
	public function sendPassword(Request $request, $id = Null){
		$id = $this->decodeString($id);
		if(Agent::where('id', '=', $id)->exists()) 
		{			
		$customer = Agent::where('id', '=', $id)->first();
			DB::table('password_resets')->insert([
				'email' => $customer->email,
				'token' => str_random(60),
				'created_at' => Carbon::now()
			]);
			//Get the token just created above
			$tokenData = DB::table('password_resets')
				->where('email', $customer->email)->first();

			if ($this->agentsendResetEmail($customer->email, $tokenData->token)) {
				return redirect()->back()->with('success', trans('A reset link has been sent to your email address.'));
			} else {
				return redirect()->back()->with('error', 'A Network Error occurred. Please try again.');
				
			} 
		}
	} 
	
	public function setCreditlimit(Request $request,$id = Null){
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			$flag = true;
			if($requestData['userid'] == ''){
				$flag = false;
				echo json_encode(array('success' => false, 'message'=>'Agent is required'));
				
					exit;
			}
			else if($requestData['credit_limit'] == ''){
				$flag = false;
				echo json_encode(array('success' => false, 'message'=>'Credit Limit is required'));
			
					exit;
			}
			if($flag){
				if(Agent::where('id', '=', $requestData['userid'])->exists()) 
				{
					$obj = Agent::find($requestData['userid']);
					$obj->credit_limit = $requestData['credit_limit'];
					$saved = $obj->save();
					if($saved){
						$oga = new CreditLimitLog;
						$oga->agent_id = $requestData['userid'];
						$oga->credit_limit = $requestData['credit_limit'];
						$oga->save();
						echo json_encode(array('success' => true, 'message'=>'Credit limit successfully updated', 'userid' => $obj->id, 'amount' => number_format(@$obj->credit_limit,2)));
					}else{
						echo json_encode(array('success' => false, 'message'=>'Please try again'));
					}
				}else{
					echo json_encode(array('success' => false, 'message'=>'Agent not found'));
						exit;
				}
			}
			
		}else{
			if(isset($id) && !empty($id)) 
			{
				//$id = $this->decodeString($id);			
				if(Agent::where('id', '=', $id)->exists()) 
				{
					$fetchedData = Agent::where('id',$id)->first();
					
					echo view('Admin.agents.modal-popup', compact(['fetchedData']));
				}
				else
				{
					echo 'Not Found';
				}	
			}
			else
			{
				echo 'Not Found';
			}
		}
	}
	
	
	public function agentlogin(Request $request,$id = Null){
		if(isset($id) && !empty($id)) 
		{
			$id = $this->decodeString($id);
			if(Agent::where('id', '=', $id)->exists()) 
				{
					$fetchedData = Agent::where('id',$id)->first();
					Auth::guard('agents')->login($fetchedData);
					return Redirect::to(\URL::to('/agent/dashboard'));
				}
				else
				{
					return redirect()->back()->with('error', 'A Network Error occurred. Please try again.');
				}	
		}
	}
	public function excelReport(Request $request){
		$where = '';
		
		$query 		= Agent::where('id', '!=', ''); 
		  
		$totalData 	= $query->count();	//for all data
if ($request->has('agent_id')) 
		{
			$agent_id 		= 	$request->input('agent_id'); 
			if(trim($agent_id) != '')
			{
				$query->where('username', '=', @$agent_id);
			}
		}
		if ($request->has('company_name')) 
		{
			$company_name 		= 	$request->input('company_name'); 
			if(trim($company_name) != '')
			{
				$query->where('company_name', '=', @$company_name);
			}
		}
		if ($request->has('from')) 
		{
			$from 		= 	$request->input('from'); 
			if(trim($from) != '')
			{
				$query->whereDate('created_at', '>=', date('Y-m-d',strtotime(@$from)));
			}
		}if ($request->has('to')) 
		{
			$to 		= 	$request->input('to'); 
			if(trim($to) != '')
			{
				$query->whereDate('created_at', '<=', date('Y-m-d',strtotime(@$to)));
			}
		}if ($request->has('email')) 
		{
			$email 		= 	$request->input('email'); 
			if(trim($email) != '')
			{
				$query->where('email', '=', @$email);
			}
		}if ($request->has('mobile')) 
		{
			$mobile 		= 	$request->input('mobile'); 
			if(trim($email) != '')
			{
				$query->where('mobile_no', '=', @$mobile);
			}
		}
		if ($request->has('status')) 
		{
			$status 		= 	$request->input('status'); 
			if(trim($email) != '')
			{
				$query->where('status', '=', @$status);
			}
		}
		if ($request->has('status') || $request->has('mobile_no') || $request->has('email')|| $request->has('to')|| $request->has('from')|| $request->has('company_name')|| $request->has('agent_id')) 
		{
			$totalData 	= $query->count();//after search
		}
		$lists		= $query->get();
		
		$finalexcel = array();
			$firstheading = array('Agent ID','Company Name','Agent Name','Mobile','Email','GST Number','PAN Number','Address','City','State','Country','Pincode','Balance','Credit Limit','Status','Entry Date');
			array_push($finalexcel,$firstheading);
		if(isset($lists)){
			foreach($lists as $lis){
				$status = 'Inactive';
			if($lis->status == 1){
				$status = 'Active';
			}
				$exceldata = array($lis->username,$lis->company_name,$lis->first_name.' '.$lis->last_name,$lis->mobile_no,$lis->email,$lis->gst_no,$lis->pan_no,$lis->address,$lis->city,$lis->state,$lis->country,$lis->zip,$lis->wallet,$lis->credit_limit,$lis->status,date('h:i A, d m Y', strtotime($lis->created_at)));
				array_push($finalexcel,$exceldata);
			}
			$this->exports_data($finalexcel,date('Y-m-d')."_Agent_Report");
		}
		//return view('Agent.transactionlog.index',compact(['lists'])); 
	}
}
