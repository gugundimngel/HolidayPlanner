<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\Lead;
use App\FollowupType;
use App\Package;
use App\Followup;
 
use Auth; 
use Config;
use Carbon\Carbon;
class LeadController extends Controller
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
			 $check = $this->checkAuthorizationAction('lead_management', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		 if(Auth::user()->role == 1){
			$query 		= Lead::where('user_id','!=','' )->with(['user']); 
		 }else if(Auth::user()->role == 7){	
			$query 		= Lead::where('user_id', '=', Auth::user()->id);
		 }else{
			 $query 		= Lead::where('assign_to', '=', Auth::user()->id);
		 }	
		 if(Auth::user()->role == 7){
			 $not_contacted = Lead::where('user_id', '=', @Auth::user()->id)->where('status', '=', 0)->count();
			$create_porposal = Lead::where('user_id', '=', Auth::user()->id)->where('status', '=', 1)->count();
			$followup = Lead::where('user_id', '=', Auth::user()->id)->where('status', '=', 15)->count();
			$undecided = Lead::where('user_id', '=', Auth::user()->id)->where('status', '=', 11)->count();
			$lost = Lead::where('user_id', '=', Auth::user()->id)->where('status', '=', 12)->count();
			$won = Lead::where('user_id', '=', Auth::user()->id)->where('status', '=', 13)->count();
			$ready_to_pay = Lead::where('user_id', '=', Auth::user()->id)->where('status', '=', 14)->count();
			$todaycall = Lead::where('user_id', '=', Auth::user()->id)->where('status', '=', 15)->whereHas('followupload', function ($q) {
					$q->whereDate('followup_date',Carbon::today());
						})->count();
		 }else{
			 $not_contacted = Lead::where('assign_to', '=', Auth::user()->id)->where('status', '=', 0)->count();
			$create_porposal = Lead::where('assign_to', '=', Auth::user()->id)->where('status', '=', 1)->count();
			$followup = Lead::where('assign_to', '=', Auth::user()->id)->where('status', '=', 15)->count();
			$undecided = Lead::where('assign_to', '=', Auth::user()->id)->where('status', '=', 11)->count();
			$lost = Lead::where('assign_to', '=', Auth::user()->id)->where('status', '=', 12)->count();
			$won = Lead::where('assign_to', '=', Auth::user()->id)->where('status', '=', 13)->count();
			$ready_to_pay = Lead::where('assign_to', '=', Auth::user()->id)->where('status', '=', 14)->count();
			$todaycall = Lead::where('assign_to', '=', Auth::user()->id)->where('status', '=', 15)->whereHas('followupload', function ($q) {
					$q->whereDate('followup_date',Carbon::today());
						})->count();
		 }
		  
		$totalData 	= $query->count();	//for all data
		if ($request->has('type')) 
		{	
			 $type 		= 	$request->input('type'); 
			if(trim($type) != '')
			{
				if($type != 'not_contacted' && $type != 'today'){
					$FollowupType = FollowupType::where('type', '=', $type)->first();
					
					$query->where('status', '=', @$FollowupType->id);
				}else if($type == 'today'){
					
					$query->whereHas('followupload', function ($q) {
					$q->whereDate('followup_date',Carbon::today());
						});
				}else{
					$query->where('status', '=', 0);
				}
				
			}	
		}
		if ($request->has('lead_id')) 
		{
			$lead_id 		= 	$request->input('lead_id'); 
			if(trim($lead_id) != '')
			{
				$query->where('id', '=', @$lead_id);
			}
		}
		if ($request->has('email')) 
		{
			$email 		= 	$request->input('email'); 
			if(trim($email) != '')
			{
				$query->where('email', '=', @$email);
			}
		}if ($request->has('name')) 
		{
			$name 		= 	$request->input('name'); 
			if(trim($name) != '')
			{
				$query->where('name', 'LIKE', '%'.@$name.'%');
			}
		}if ($request->has('phone')) 
		{
			$phone 		= 	$request->input('phone'); 
			if(trim($phone) != '')
			{
				$query->where('phone', '=', @$phone);
			}
		}if ($request->has('status')) 
		{
			$status 		= 	$request->input('status'); 
			if(trim($status) != '')
			{
				$query->where('status', '=', @$status);
			}
		}
		if ($request->has('followupdate')) 
		{
			$followupdate 		= 	$request->input('followupdate'); 
			if(trim($followupdate) != '')
			{
				$query->whereHas('followupload', function ($q) use($followupdate){
					$q->whereDate('followup_date',date('Y-m-d',strtotime($followupdate)));
				});
			}
		}
		if ($request->has('priority')) 
		{
			$priority 		= 	$request->input('priority'); 
			if(trim($priority) != '')
			{
				$query->where('priority', '=', @$priority);
			}
		}
	if ($request->has('type') || $request->has('lead_id') || $request->has('email')|| $request->has('name') || $request->has('phone') || $request->has('status')|| $request->has('followupdate') || $request->has('priority')) 
		{
			$totalData 	= $query->count();//after search
		}
		$lists		= $query->sortable(['id' => 'desc'])->paginate(config('constants.limit')); 
		$cur_url = $request->fullUrl();
		return view('Admin.leads.index',compact(['lists', 'totalData', 'not_contacted', 'create_porposal', 'followup', 'undecided', 'lost', 'won', 'ready_to_pay', 'cur_url', 'todaycall'])); 

	}   
	
	public function create(Request $request) 
	{
		//check authorization start	
			 $check = $this->checkAuthorizationAction('add_lead', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	 
		//check authorization end
		
		return view('Admin.leads.create');
	}
	
	public function assign(Request $request) {
		$requestData 		= 	$request->all();
		$id = $this->decodeString($requestData['mlead_id']);	 
		if(Lead::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->exists()) 
		{
			$leads = Lead::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->first();
			if($leads->assign_to != ''){
				if($leads->assign_to == $requestData['assignto']){
					return redirect()->back()->with('error', 'Already Assigned to this user');
				}else{
					$assignfrom = Admin::where('id',$leads->assign_to)->first();
					$assignto = Admin::where('id',$requestData['assignto'])->first();
					$ld = Lead::find($id);
					$ld->assign_to = $requestData['assignto'];
					$ld->save();
					$followup 					= new Followup;
					$followup->lead_id			= @$id;
					$followup->user_id			= Auth::user()->id;
					$followup->note				= 'changed from '.$assignfrom->first_name.' '.$assignfrom->last_name.' to '.$assignto->first_name.' '.$assignto->last_name;
					$followup->followup_type	= 'assigned_to';
					$saved				=	$followup->save();  
					if(!$saved) 
					{
						return redirect()->back()->with('error', 'Please try again');
					}else{
						return redirect()->back()->with('success', 'Lead transfer successfully');
					}
				}
			}else{
				$ld = Lead::find($id);
				$ld->assign_to = $requestData['assignto'];
				$saved		= $ld->save();
				if(!$saved) 
					{
						return redirect()->back()->with('error', 'Please try again');
					}else{
						return redirect()->back()->with('success', 'Lead Assigned successfully');
					}
			}
		}else{
			return redirect()->back()->with('error', 'Not Found');
		}
	}
	public function history(Request $request, $id = NULL) 
	{
		//check authorization start	
			 $check = $this->checkAuthorizationAction('lead_history', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	  
		//check authorization end
		if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	 
				if(Lead::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->orwhere('assign_to', '=', Auth::user()->id)->exists()) 
				{
					$fetchedData = Lead::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->orwhere('assign_to', '=', Auth::user()->id)->with(['staffuser'])->first();
					return view('Admin.leads.history', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/leads')->with('error', 'Lead Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/leads')->with('error', Config::get('constants.unauthorized'));
			}
	}
	
	 public function store(Request $request)
	{
		//check authorization start	
			  $check = $this->checkAuthorizationAction('add_lead', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	 
		//check authorization end
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'full_name' => 'required|max:255',
										'email' => 'required|max:255',
										'phone' => 'required',
										'duration_night' => 'numeric',
										'duration_day' => 'numeric',
										'lead_assign' => 'required'
									  ]);
			
			$requestData 		= 	$request->all();
			 
			$obj				= 	new Lead; 
			$obj->user_id	=	Auth::user()->id;   
			$obj->name		=	@$requestData['full_name'];
			$obj->email		=	@$requestData['email'];
			$obj->phone	=	@$requestData['phone'];			
			$obj->going_to		=	@$requestData['going_to'];			
			$obj->service		=	@$requestData['service'];			
			$obj->city		=	@$requestData['city'];			
			$obj->travel_date	=	@$requestData['departure_date'];
			$obj->duration_night	=	@$requestData['duration_night'];
			$obj->duration_day	=	@$requestData['duration_day'];
			$obj->adults	=	@$requestData['adults'];
			$obj->children	=	@$requestData['children'];
			$obj->assign_to	=	@$requestData['lead_assign'];
			$obj->lead_source	=	@$requestData['lead_source'];
			$obj->customize_package	=	@$requestData['remark'];
			$obj->latest_comment	=	@$requestData['latest_comment'];
			$obj->baby	=	@$requestData['baby'];
			$obj->type	=	'mannual';
			$obj->priority	=	@$requestData['status'];
			$obj->status	=	0;
			 
			
			$saved				=	$obj->save();  
			
			if(!$saved) 
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{ 
				return Redirect::to('/admin/leads')->with('success', 'Lead added Successfully');
			} 				
		}	
	} 
	
	 public function edit(Request $request, $id = NULL)
	{			
		//check authorization end
	//check authorization start	
			$check = $this->checkAuthorizationAction('edit_lead', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'full_name' => 'required|max:255',
										'email' => 'required|max:255',
										'phone' => 'required',
										'duration_night' => 'numeric',
										'duration_day' => 'numeric',
										'lead_assign' => 'required'
									  ]);
			
			$requestData 		= 	$request->all();
			 
			$obj				= Lead::find(@$requestData['id']); 
			$obj->name		=	@$requestData['full_name'];
			$obj->email		=	@$requestData['email'];
			$obj->phone		=	@$requestData['phone'];			
			$obj->going_to		=	@$requestData['going_to'];			
			$obj->service		=	@$requestData['service'];			
			$obj->city		=	@$requestData['city'];			
			$obj->travel_date	=	@$requestData['departure_date'];
			$obj->duration_night	=	@$requestData['duration_night'];
			$obj->duration_day	=	@$requestData['duration_day'];
			$obj->adults	=	@$requestData['adults'];
			$obj->children	=	@$requestData['children'];
			$obj->assign_to	=	@$requestData['lead_assign'];
			$obj->lead_source	=	@$requestData['lead_source'];
			$obj->customize_package	=	@$requestData['remark'];
			$obj->latest_comment	=	@$requestData['latest_comment'];
			$obj->baby	=	@$requestData['baby'];
			$obj->type	=	'mannual';
			$obj->priority	=	@$requestData['status'];
			 
			
			$saved				=	$obj->save();  
			
			if(!$saved) 
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{ 
				return Redirect::to('/admin/leads/edit'.base64_encode(convert_uuencode(@$requestData['id'])))->with('success', 'Lead updated Successfully');
			}				
		}
		else
		{	
			if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	 
				if(Lead::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->exists()) 
				{
					$fetchedData = Lead::find($id);
					return view('Admin.leads.edit', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/leads')->with('error', 'Lead Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/leads')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	} 
	
	
}
