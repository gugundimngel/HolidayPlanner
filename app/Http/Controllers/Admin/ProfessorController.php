<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Professor;
use App\Admin;
use App\Country;

use Auth;
use Config;

class ProfessorController extends Controller
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
     * All Professors.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('Professor', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		$query 		= Professor::select('id', 'organisation_role', 'which_organisation', 'first_name', 'last_name', 'status', 'order_number', 'created_at', 'updated_at')->where('id', '!=', '')->with(['organisationData'=>function($q){
			$q->select('id', 'first_name', 'email');	
		}]);
		
		$totalData 	= $query->count();	//for all data
		
		if ($request->has('search_term_first')) 
		{
			$search_term_first 		= 	$request->input('search_term_first');
			if(trim($search_term_first) != '')	
			{
				$query->where('first_name', 'LIKE', '%' . $search_term_first . '%');
			}
		}
		
		if ($request->has('search_term_last')) 
		{
			$search_term_last 		= 	$request->input('search_term_last');
			if(trim($search_term_last) != '')	
			{
				$query->where('last_name', 'LIKE', '%' . $search_term_last . '%');
			}
		}
		
		if ($request->has('search_term_email')) 
		{
			$search_term_email 		= 	$request->input('search_term_email');
			if(trim($search_term_email) != '')	
			{
				$query->whereHas('organisationData', function ($q) use($search_term_email){
						$q->where('email', 'LIKE', '%'.$search_term_email.'%');
					});
			}
		}
		
		if ($request->has('search_term_organisation_name')) 
		{
			$search_term_organisation_name 		= 	$request->input('search_term_organisation_name');
			if(trim($search_term_organisation_name) != '')	
			{
				$query->whereHas('organisationData', function ($q) use($search_term_organisation_name){
						$q->where('first_name', 'LIKE', '%'.$search_term_organisation_name.'%');
					});
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
		
		if ($request->has('search_term_first') || $request->has('search_term_last') || $request->has('search_term_email') || $request->has('search_term_organisation_name') || $request->has('search_term_from') || $request->has('search_term_to')) 
		{
			$totalData 	= $query->count();
		}
		
		$lists		= $query->sortable(['id'=>'desc'])->paginate(config('constants.limit'));	
		
		return view('Admin.professor.index',compact(['lists', 'totalData']));	
	}
	/**
     * Add Professor.
     *
     * @return \Illuminate\Http\Response
     */
	public function addProfessor(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('Professor', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		/* Get all Select Data */	
			$organisations = Admin::select('id', 'first_name', 'email')->where('role', '=', 3)->where('status', '=', 1)->get();	
			$countries = Country::select('id', 'name')->where('status', '=', 1)->get();		
		/* Get all Select Data */
		
		if ($request->isMethod('post')) 
		{
			$requestData 					= 	$request->all();

			$this->validate($request, [
										'which_organisation' => 'required',
										'first_name' => 'required|max:255',
										'last_name' => 'required|max:255',
										'email' => 'nullable|max:191|unique:admins',
										'password' => 'nullable|min:6|max:10',
										'mobile' => 'nullable|max:12',
										'gstin' => 'nullable|max:255',
										'assistant_name' => 'nullable|max:255',
										'assistant_number' => 'nullable|max:12'
									  ]);	
									  
			if($requestData['which_organisation'] == 0) //that means this is individual professor
			{
				/* Profile Image Upload Function Start */						  
					if($request->hasfile('profile_img')) 
					{	
						$profile_img = $this->uploadFile($request->file('profile_img'), Config::get('constants.profile_imgs'));
					}
					else
					{
						$profile_img = NULL;
					}		
				/* Profile Image Upload Function End */	
				
				$objAdmin						= 	new Admin;
				$objAdmin->role					=	4; //individual professor
				
				$objAdmin->first_name			=	@$requestData['first_name'];
				$objAdmin->last_name			=	@$requestData['last_name'];	
				$objAdmin->email				=	@$requestData['email'];	
				$objAdmin->password				=	Hash::make(@$requestData['password']);
				$objAdmin->decrypt_password		=	@$requestData['password'];
				$objAdmin->phone				=	@$requestData['mobile'];	
				$objAdmin->country				=	@$requestData['country'];	
				$objAdmin->state				=	@$requestData['state'];	
				$objAdmin->city					=	@$requestData['city'];	
				$objAdmin->address				=	@$requestData['address'];	
				$objAdmin->zip					=	@$requestData['zip'];
				$objAdmin->profile_img			=	@$profile_img;
				
				$saved							=	$objAdmin->save();
				
				if(!$saved)
				{
					return redirect()->back()->with('error', Config::get('constants.server_error'));
				}
				else
				{
					$organisation_role 	= 4;
					$which_organisation	= $objAdmin->id; //last inserted individual professor 
				}
			}	
			else
			{
				/* Profile Image Upload Function Start */						  
					if($request->hasfile('profile_img')) 
					{	
						$profile_img = $this->uploadFile($request->file('profile_img'), Config::get('constants.profile_imgs'));
					}
					else
					{
						$profile_img = NULL;
					}		
				/* Profile Image Upload Function End */	

				$organisation_role 	= 3;
				$which_organisation	= @$requestData['which_organisation'];
			}							  

			
			$obj							= 	new Professor;
			
			$obj->organisation_role			=	@$organisation_role;
			$obj->which_organisation		=	@$which_organisation;
			$obj->first_name				=	@$requestData['first_name'];
			$obj->last_name					=	@$requestData['last_name'];
			$obj->mobile					=	@$requestData['mobile'];
			$obj->gstin						=	@$requestData['gstin'];
			$obj->about_faculty				=	@$requestData['about_faculty'];
			$obj->date_of_agreement			=	@$requestData['date_of_agreement'];
			$obj->assistant_name			=	@$requestData['assistant_name'];
			$obj->assistant_number			=	@$requestData['assistant_number'];
			$obj->org_professor_image		=	@$profile_img;
			
			//Order number start	
				if(empty($requestData['order_number']))
				{
					$forOrder = Professor::select('id', 'order_number')->where('id', '!=', '')->orderBy('order_number', 'DESC')->first();
					
					$order = @$forOrder->order_number + 1;
				}	
				else
				{
					if(Professor::where('order_number', '=', @$requestData['order_number'])->exists())
					{ //if exists order number already
						$matchProfessor = Professor::select('id')->where('order_number', '=', @$requestData['order_number'])->first();
						
						$forOrder = Professor::select('id', 'order_number')->where('id', '!=', '')->orderBy('order_number', 'DESC')->first();
						$lastOrder = @$forOrder->order_number + 1;
						
						$objUpdate					= 	Professor::find($matchProfessor->id);
						$objUpdate->order_number	=	$lastOrder;
						$saved						=	$objUpdate->save();	
					}
					$order = @$requestData['order_number'];	
				}
			//Order number end
			
			
			$obj->order_number				=	@$order;
			
			$saved							=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/professors')->with('success', 'Professor'.Config::get('constants.added'));
			}
		}
		return view('Admin.professor.add_professor',  compact(['organisations', 'countries']));		
	}
	
	public function editProfessor(Request $request, $id = NULL)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('Professor', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		/* Get all Select Data */	
			$organisations = Admin::select('id', 'first_name', 'email')->where('role', '=', 3)->where('status', '=', 1)->get();	
			$countries = Country::select('id', 'name')->where('status', '=', 1)->get();		
		/* Get all Select Data */
	
		if ($request->isMethod('post')) 
		{	
			$requestData 		= 	$request->all();
			
			$this->validate($request, [
										'which_organisation' => 'required',
										'first_name' => 'required|max:255',
										'last_name' => 'required|max:255',
										'email' => 'nullable|max:191|unique:admins,email,'.$requestData['organisation_id'],
										'password' => 'nullable|min:6|max:10',
										'mobile' => 'nullable|max:12',
										'gstin' => 'nullable|max:255',
										'assistant_name' => 'nullable|max:255',
										'assistant_number' => 'nullable|max:12'
									  ]);
			
			if($requestData['which_organisation'] == 0) //that means this is individual professor
			{
				$getPreviousData = Professor::where('id', '=', $requestData['id'])->with(['organisationData'])->first();
				
				/* Profile Image Upload Function Start */						  
					if($request->hasfile('profile_img')) 
					{	
						/* Unlink File Function Start */ 
							if($requestData['profile_img'] != '')
								{
									$this->unlinkFile($requestData['old_profile_img'], Config::get('constants.profile_imgs'));
								}
						/* Unlink File Function End */
						
						$profile_img = $this->uploadFile($request->file('profile_img'), Config::get('constants.profile_imgs'));
					}
					else
					{
						$profile_img = @$requestData['old_profile_img'];
					}		
				/* Profile Image Upload Function End */
			
				
				if(($getPreviousData->organisation_role == 3))
				{ //wants to be part of individual
					$objAdmin		= 	new Admin;
					
					if(trim(@$requestData['email']) == trim($getPreviousData->organisationData->email))
					{
						return redirect()->back()->with('error', 'Email Id is already register with your last organisation, so please choose another one.');
					}	
					
					$objAdmin->email				=	@$requestData['email'];
				}
				else
				{
					$objAdmin		= 	Admin::find($requestData['organisation_id']);
				}		
				
				$objAdmin->role					=	4; //individual professor
				
				$objAdmin->first_name			=	@$requestData['first_name'];
				$objAdmin->last_name			=	@$requestData['last_name'];	
				if(!empty(@$requestData['password']))
				{		
					$objAdmin->password				=	Hash::make(@$requestData['password']);
					$objAdmin->decrypt_password		=	@$requestData['password'];
				}
				$objAdmin->phone				=	@$requestData['mobile'];	
				$objAdmin->country				=	@$requestData['country'];	
				$objAdmin->state				=	@$requestData['state'];	
				$objAdmin->city					=	@$requestData['city'];	
				$objAdmin->address				=	@$requestData['address'];	
				$objAdmin->zip					=	@$requestData['zip'];	
				$objAdmin->profile_img			=	@$profile_img;
				
				$saved							=	$objAdmin->save();
				
				if(!$saved)
				{
					return redirect()->back()->with('error', Config::get('constants.server_error'));
				}
				else
				{
					$organisation_role 	= 4;
					if(($getPreviousData->organisation_role == 3))
					{ 
						$which_organisation	= $objAdmin->id;
					}
					else
					{		
						$which_organisation	= @$requestData['organisation_id']; //last inserted individual professor 
					}
				}
			}	
			else
			{
				/* Profile Image Upload Function Start */						  
					if($request->hasfile('profile_img')) 
					{	
						/* Unlink File Function Start */ 
							if($requestData['profile_img'] != '')
								{
									$this->unlinkFile($requestData['old_profile_img'], Config::get('constants.profile_imgs'));
								}
						/* Unlink File Function End */
						
						$profile_img = $this->uploadFile($request->file('profile_img'), Config::get('constants.profile_imgs'));
					}
					else
					{
						$profile_img = @$requestData['old_profile_img'];
					}		
				/* Profile Image Upload Function End */

				$organisation_role 	= 3;
				$which_organisation	= @$requestData['which_organisation'];
			}
			
			$obj							= 	Professor::find($requestData['id']);

			if(($obj->organisation_role == 4) && ($organisation_role == 3))
			{ //for those professor who want to be a part of any organization 
				$admin_id = @$requestData['organisation_id']; 
				DB::table('admins')->where('id', @$admin_id)->delete(); //delete from admin table
			}	
			
			$obj->organisation_role			=	@$organisation_role;
			$obj->which_organisation		=	@$which_organisation;
			$obj->first_name				=	@$requestData['first_name'];
			$obj->last_name					=	@$requestData['last_name'];
			$obj->mobile					=	@$requestData['mobile'];
			$obj->gstin						=	@$requestData['gstin'];
			$obj->about_faculty				=	@$requestData['about_faculty'];
			$obj->date_of_agreement			=	@$requestData['date_of_agreement'];
			$obj->assistant_name			=	@$requestData['assistant_name'];
			$obj->assistant_number			=	@$requestData['assistant_number'];
			$obj->org_professor_image		=	@$profile_img;
			
			//Order number start	
				if(empty($requestData['order_number']))
				{
					$forOrder = Professor::select('id', 'order_number')->where('id', '!=', '')->orderBy('order_number', 'DESC')->first();
					
					$order = $forOrder->order_number + 1;
				}	
				else
				{
					if(Professor::where('id', '!=', $requestData['id'])->where('order_number', '=', @$requestData['order_number'])->exists())
					{ //if exists order number already
						$matchProfessor = Professor::select('id')->where('order_number', '=', @$requestData['order_number'])->first();
						
						$forOrder = Professor::select('id', 'order_number')->where('id', '!=', '')->orderBy('order_number', 'DESC')->first();
						$lastOrder = $forOrder->order_number + 1;
						
						$objUpdate					= 	Professor::find($matchProfessor->id);
						$objUpdate->order_number	=	$lastOrder;
						$saved						=	$objUpdate->save();	
					}
					$order = @$requestData['order_number'];	
				}
			//Order number end
			
			
			$obj->order_number				=	@$order;
			
			$saved							=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/professors')->with('success', 'Professor'.Config::get('constants.edited'));
			}
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
	
				if(Professor::where('id', '=', $id)->exists())
				{
					$fetchedData = Professor::where('id', '=', $id)->with(['organisationData'])->first();
		
					return view('Admin.professor.edit_professor', compact(['fetchedData', 'organisations', 'countries']));
				}
				else
				{
					return Redirect::to('/admin/professors')->with('error', 'Professor'.Config::get('constants.not_exist'));
				}	
			}
			else
			{
				return Redirect::to('/admin/professors')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	
	public function viewProfessor(Request $request, $id)
	{
		if(isset($id) && !empty($id))
		{
			$id = $this->decodeString($id);
			if(Professor::where('id', '=', $id)->exists()) 
			{
				$fetchedData 		= 	Professor::where('id', '=', $id)->with(['organisationData'=>function($query){
					$query->with(['countryData', 'stateData']);
				}])->first();
				
				return view('Admin.professor.view_professor', compact(['fetchedData']));
			}
			else
			{
				return Redirect::to('/admin/professors')->with('error', 'Professor'.Config::get('constants.not_exist'));
			}
		}
		else
		{
			return Redirect::to('/admin/professors')->with('error', Config::get('constants.unauthorized'));
		}
	}
	
	public function linkedProfessors(Request $request)
	{	
		$query 		= Professor::select('id', 'organisation_role', 'which_organisation', 'first_name', 'last_name', 'status', 'order_number', 'created_at', 'updated_at')->where('id', '!=', '')->where('which_organisation', '=', Auth::user()->id)->with(['organisationData'=>function($q){
			$q->select('id', 'first_name', 'email');	
		}]);
		
		$totalData 	= $query->count();	//for all data
		
		if ($request->has('search_term_first')) 
		{
			$search_term_first 		= 	$request->input('search_term_first');
			if(trim($search_term_first) != '')	
			{
				$query->where('first_name', 'LIKE', '%' . $search_term_first . '%');
			}
		}
		
		if ($request->has('search_term_last')) 
		{
			$search_term_last 		= 	$request->input('search_term_last');
			if(trim($search_term_last) != '')	
			{
				$query->where('last_name', 'LIKE', '%' . $search_term_last . '%');
			}
		}
		
		if ($request->has('search_term_email')) 
		{
			$search_term_email 		= 	$request->input('search_term_email');
			if(trim($search_term_email) != '')	
			{
				$query->whereHas('organisationData', function ($q) use($search_term_email){
						$q->where('email', 'LIKE', '%'.$search_term_email.'%');
					});
			}
		}
		
		if ($request->has('search_term_organisation_name')) 
		{
			$search_term_organisation_name 		= 	$request->input('search_term_organisation_name');
			if(trim($search_term_organisation_name) != '')	
			{
				$query->whereHas('organisationData', function ($q) use($search_term_organisation_name){
						$q->where('first_name', 'LIKE', '%'.$search_term_organisation_name.'%');
					});
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
		
		if ($request->has('search_term_first') || $request->has('search_term_last') || $request->has('search_term_email') || $request->has('search_term_organisation_name') || $request->has('search_term_from') || $request->has('search_term_to')) 
		{
			$totalData 	= $query->count();
		}
		
		$lists		= $query->sortable(['id'=>'desc'])->paginate(config('constants.limit'));	
		
		return view('Admin.professor.linked_professors',compact(['lists', 'totalData']));	
	}
	
	
}
