<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

use App\Wallet;
use App\WalletHistory;
use App\Agent;

use Auth;
use Config;

class WalletController extends Controller
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
		
		$query 		= Wallet::with(['user']);
			if ($request->has('agent')) 
		{
			$agent 		= 	$request->input('agent'); 
			if(trim($agent) != '')
			{
				$query->where('user_id',$agent);
			}
		}
		if ($request->has('aname')) 
		{
			$aname 		= 	$request->input('aname'); 
			if(trim($aname) != '')
			{
				$query->wherehas('user', function($q) use ($aname){
					$q->where('first_name', 'LIKE', '%'.@$aname.'%');
				});
			}
		}
		if ($request->has('date')) 
		{
			$date 		= 	$request->input('date'); 
			if(trim($date) != '')
			{
				$query->whereDate('pay_date',date('Y-m-d',strtotime($date)));
			}
		}
		if ($request->has('rdate')) 
		{
			$rdate 		= 	$request->input('rdate'); 
			if(trim($rdate) != '')
			{
				$query->whereDate('created_at',date('Y-m-d',strtotime($rdate)));
			}
		}
		if ($request->has('mode')) 
		{
			$mode 		= 	$request->input('mode'); 
			if(trim($mode) != '')
			{
				$query->where('pay_mode',$mode);
			}
		}
		if ($request->has('transaction_id')) 
		{
			$transaction_id 		= 	$request->input('transaction_id'); 
			if(trim($transaction_id) != '')
			{
				$query->where('bank_transaction_id',$transaction_id);
			}
		}
		if ($request->has('status')) 
		{
			$status 		= 	$request->input('status'); 
			if(trim($status) != '')
			{
				$query->where('status',$status);
			}
		}
		
		$totalData 	= $query->count();	//for all data
		
			
		$lists		= $query->orderby('pay_date','DESC')->get();

		return view('Admin.wallet.index',compact(['lists', 'totalData']));	
	}
	
	
	public function create(Request $request, $id = NULL){
		$allusers = Agent::all();
		$agent_id = isset($request->agent_id) ? $this->decodeString($request->agent_id) : '';
		$type = isset($request->type) ? $request->type : '';
		return view('Admin.wallet.create',compact(['allusers', 'agent_id', 'type']));	
	}
	public function store(Request $request){
		$requestData 		= 	$request->all();
		$wallethistory = new WalletHistory;
		$wallethistory->user_id = $requestData['agent_id'];
		$wallethistory->type =  $requestData['type'];
		if($requestData['type'] == 'credit'){
			$wallethistory->credit = $requestData['amount'];
		}else{
			$wallethistory->debit = $requestData['amount'];
		}
		$wallethistory->remark = $requestData['remark'];
		$saved				=	$wallethistory->save();
			$u = Agent::find($requestData['agent_id']);
			if($requestData['type'] == 'credit'){
			$u->wallet		+=	$requestData['amount'];
			}else{
			$u->wallet		-=	$requestData['amount'];	
			}
			$u->save();
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				
				return Redirect::to('/admin/wallet/crdr')->with('success', 'Wallet Successfully');
			}
	}
	public function edit(Request $request, $id = NULL){
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			$obj				= 	Wallet::find($requestData['walletid']);
				
			if($obj->status == 0){
				if($requestData['type'] == 'approve'){
					$obj->status		=	1;
				}else{
					$obj->status		=	2;
				}
				$obj->admin_remark		=	@$requestData['remarks'];
				$saved				=	$obj->save();
				if($requestData['type'] == 'approve'){
					 $u = Agent::find($obj->user_id);
					$u->wallet		+=	$obj->amount;
					$u->save(); 
					
					$objs = new WalletHistory;
					$objs->user_id = $obj->user_id;
					$objs->credit = $obj->amount;
					$objs->debit = 0;
					
						$objs->remark = 'Recharge';
					
					$objs->reference_id = time();
					$objs->type = 'credit';
					$objs->save();
				}
			$approved = \App\Wallet::where('status',1)->count();
				$pending = \App\Wallet::where('status',0)->count();
				$rejected = \App\Wallet::where('status',2)->count();
				$totalrec = \App\Wallet::where('status',1)->sum('amount');
				if(!$saved)
				{
					echo json_encode(array('success' => false, 'message'=>'Please try again','approved'=>$approved,'pending'=>$pending,'rejected'=>$rejected,'totalrec'=>$totalrec));
					exit;
				}
				else
				{
					
					if($obj->status == '1'){
						$wallettype = 'approve';
					}else{
						$wallettype = 'reject';
					}
					echo json_encode(array('success' => true, 'message'=>'Record successfully updated','wallettype'=>$wallettype,'approved'=>$approved,'pending'=>$pending,'rejected'=>$rejected,'totalrec'=>$totalrec));
					exit;
				}
			}else{
				$approved = \App\Wallet::where('status',1)->count();
				$pending = \App\Wallet::where('status',0)->count();
				$rejected = \App\Wallet::where('status',2)->count();
				$totalrec = \App\Wallet::where('status',1)->sum('amount');
				echo json_encode(array('success' => false, 'message'=>'Already approve/Reject','approved'=>$approved,'pending'=>$pending,'rejected'=>$rejected,'totalrec'=>$totalrec));
					exit;
			}
		}else{
			if(isset($id) && !empty($id)) 
			{
				//$id = $this->decodeString($id);
				$type = $request->type;				
				if(Wallet::where('id', '=', $id)->exists()) 
				{
					$fetchedData = Wallet::where('id',$id)->with(['user'])->first();
					
					echo view('Admin.wallet.modal-popup', compact(['fetchedData', 'type']));
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
	
	
	public function show(Request $request,$id = Null)
	{
		if(isset($id) && !empty($id))
			{
				
				$id = $this->decodeString($id);	
				if(Wallet::where('id', '=', $id)->exists()) 
				{
					$fetchedData = Wallet::find($id);
					return view('Admin.wallet.view', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/wallet')->with('error', 'Wallet Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/wallet')->with('error', Config::get('constants.unauthorized'));
			}			
	} 
	
	
	public function crdr(Request $request, $id = NULL){
		$query 		= WalletHistory::with(['user']);
		if ($request->has('date')) 
		{
			$date 		= 	$request->input('date'); 
			if(trim($date) != '')
			{
				$query->whereDate('created_at',date('Y-m-d',strtotime($date)));
			}
		}
			if ($request->has('agent')) 
		{
			$agent 		= 	$request->input('agent'); 
			if(trim($agent) != '')
			{
				$query->where('user_id',$agent);
			}
		}	
		if ($request->has('type')) 
		{
			$type 		= 	$request->input('type'); 
			if(trim($type) != '' && $type =='credit')
			{
				$query->where('credit','!=',0);
			}
		}
		if ($request->has('type')) 
		{
			$type 		= 	$request->input('type'); 
			if(trim($type) != '' && $type =='debit')
			{
				$query->where('debit','!=',0);
			}
		}
		$totalData 	= $query->count();	//for all data
		
			
		$lists		= $query->get();

		return view('Admin.wallet.history',compact(['lists', 'totalData']));	
	}
	
	public function excelReport(Request $request){
		$where = '';
		
		$query 		= Wallet::with(['user']); 
		  
		$totalData 	= $query->count();	//for all data
		if ($request->has('agent')) 
		{
			$agent 		= 	$request->input('agent'); 
			if(trim($agent) != '')
			{
				$query->where('user_id',$agent);
			}
		}
		if ($request->has('aname')) 
		{
			$aname 		= 	$request->input('aname'); 
			if(trim($aname) != '')
			{
				$query->wherehas('user', function($q) use ($aname){
					$q->where('first_name', 'LIKE', '%'.@$aname.'%');
				});
			}
		}
		if ($request->has('date')) 
		{
			$date 		= 	$request->input('date'); 
			if(trim($date) != '')
			{
				$query->whereDate('pay_date',date('Y-m-d',strtotime($date)));
			}
		}
		if ($request->has('rdate')) 
		{
			$rdate 		= 	$request->input('rdate'); 
			if(trim($rdate) != '')
			{
				$query->whereDate('created_at',date('Y-m-d',strtotime($rdate)));
			}
		}
		if ($request->has('mode')) 
		{
			$mode 		= 	$request->input('mode'); 
			if(trim($mode) != '')
			{
				$query->where('pay_mode',$mode);
			}
		}
		if ($request->has('transaction_id')) 
		{
			$transaction_id 		= 	$request->input('transaction_id'); 
			if(trim($transaction_id) != '')
			{
				$query->where('bank_transaction_id',$transaction_id);
			}
		}
		if ($request->has('status')) 
		{
			$status 		= 	$request->input('status'); 
			if(trim($status) != '')
			{
				$query->where('status',$status);
			}
		}
		if ($request->has('status') || $request->has('agent') || $request->has('date')|| $request->has('rdate')|| $request->has('mode')|| $request->has('transaction_id')) 
		{
			$totalData 	= $query->count();//after search
		}
		$lists		= $query->get();
		
		$finalexcel = array();
			$firstheading = array('Agent ID','Agent Name','Request Date','Payment Date','Amount','Payment Mode','Status');
			array_push($finalexcel,$firstheading);
		if(isset($lists)){
			foreach($lists as $lis){
				
			if($lis->status == 1){
				$status = 'Approved';
			}else if($lis->status == 2){
				$status = 'Rejected';
			}else{
				$status = 'Pending';
			}
				$exceldata = array($lis->user->username,$lis->user->first_name.' '.$lis->user->last_name,date('Y-m-d',strtotime(@$lis->pay_date)),@$lis->pay_date,$lis->amount,$lis->pay_mode,$status);
				array_push($finalexcel,$exceldata);
			}
			//echo '<pre>'; print_r($finalexcel);
			$this->exports_data($finalexcel,date('Y-m-d')."_Wallet_Report");
		}
		//return view('Agent.transactionlog.index',compact(['lists'])); 
	}
}