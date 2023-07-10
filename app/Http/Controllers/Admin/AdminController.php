<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

use App\Lead;
use App\Admin;
use App\WebsiteSetting;
use App\SeoPage;
use App\Inclusion;
use App\Topinclusion;
use App\Exclusion;
use App\Holidaytype;
use App\City;
use App\Contact;
use App\Package;
use App\Hotel;
use App\Destination;
use App\TaxRate;

use Auth;
use Config;

class AdminController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {	
		/* Leads */
		$not_contacted = Lead::where('assign_to', '=', Auth::user()->id)->where('status', '=', 0)->count();
		$create_porposal = Lead::where('assign_to', '=', Auth::user()->id)->where('status', '=', 1)->count();
		$followup = Lead::where('assign_to', '=', Auth::user()->id)->where('status', '=', 15)->count();
		$undecided = Lead::where('assign_to', '=', Auth::user()->id)->where('status', '=', 11)->count();
		$lost = Lead::where('assign_to', '=', Auth::user()->id)->where('status', '=', 12)->count();
		$won = Lead::where('assign_to', '=', Auth::user()->id)->where('status', '=', 13)->count();
		$ready_to_pay = Lead::where('assign_to', '=', Auth::user()->id)->where('status', '=', 14)->count();
		/* Leads */
		/* Client data */
		$Contact = Contact::where('user_id', '=', Auth::user()->id)->count();
		$Lead = Lead::where('user_id', '=', Auth::user()->id)->count();
		$Package = Package::where('user_id', '=', Auth::user()->id)->count();
		$Hotel = Hotel::where('user_id', '=', Auth::user()->id)->count();
		$Destination = Destination::where('user_id', '=', Auth::user()->id)->count();
		$Admindd = Admin::where('user_id', '=', Auth::user()->id)->count();
		/* Client data */
        return view('Admin.dashboard', compact(['not_contacted', 'create_porposal', 'followup', 'undecided', 'lost', 'won', 'ready_to_pay', 'Contact', 'Lead', 'Package', 'Hotel', 'Destination', 'Admindd']));
    }
	/**
     * My Profile.
     *
     * @return \Illuminate\Http\Response
     */
	public function returnsetting(Request $request){
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			$obj							= 	Admin::find(Auth::user()->id);
			if(@$requestData['is_business_gst'] == 'yes'){
			$obj->is_business_gst				=	@$requestData['is_business_gst'];
			$obj->gstin					=	@$requestData['gstin'];
			$obj->gst_date						=	@$requestData['gst_date'];
			}else{
				$obj->is_business_gst				=	@$requestData['is_business_gst'];
			$obj->gstin					=	'';
			$obj->gst_date						=	'';
			}
			$saved							=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/settings/taxes/returnsetting')->with('success', 'Your Profile has been edited successfully.');
			}	
		}else{
			//return view('Admin.my_profile', compact(['fetchedData', 'countries']));
			return view('Admin.settings.returnsetting');
		}
	}
	public function taxrates(Request $request){
		if ($request->isMethod('post')) 
		{
			
		}else{
			$query = TaxRate::where('user_id',Auth::user()->id);
			$totalData = $query->count();
			$lists = $query->get();
			return view('Admin.settings.taxrates', compact(['lists','totalData']));
		}
	}
	public function taxratescreate(Request $request){
		return view('Admin.settings.create');
	}
	
	public function edittaxrates(Request $request, $id = Null){
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$this->validate($request, [
										'name' => 'required|max:255'
									  ]);
									  
									  
			$obj				= 	TaxRate::find($requestData['id']);
			
			$obj->name			=	@$requestData['name'];
			$obj->rate			=	@$requestData['rate'];
						
			$saved				=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/settings/taxes/taxrates/edit/'.base64_encode(convert_uuencode(@$requestData['id'])))->with('success', 'Tax updated Successfully');
			}				
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(TaxRate::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->exists()) 
				{
					$fetchedData = TaxRate::find($id);
					
					return view('Admin.settings.edit', compact(['fetchedData']));
				}
				else 
				{
					return Redirect::to('/admin/settings/taxes/taxrates')->with('error', 'Tax Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/settings/taxes/taxrates')->with('error', Config::get('constants.unauthorized'));
			}		
		}
	}
	  
	public function savetaxrate(Request $request){
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'name' => 'required|max:255'
									  ]);
			
			$requestData 		= 	$request->all();
			
			$obj				= 	new TaxRate;
			$obj->user_id	=	Auth::user()->id;
			$obj->name	=	@$requestData['name'];
			$obj->rate	=	@$requestData['rate'];
			
			$saved				=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/settings/taxes/taxrates/edit/'.base64_encode(convert_uuencode(@$obj->id)))->with('success', 'Tax added Successfully');
			}				
		}
	}
	public function myProfile(Request $request)
	{
		/* Get all Select Data */	
			$countries = array();		
		/* Get all Select Data */
		
		if ($request->isMethod('post')) 
		{	
			$requestData 		= 	$request->all();
			
			$this->validate($request, [
										'first_name' => 'required',
										'last_name' => 'nullable',
										'country' => 'required',
										'phone' => 'required|max:14|unique:admins,phone,'.$requestData['id'],
										'state' => 'required',
										'city' => 'required',
										'address' => 'required',
										'zip' => 'required'
									  ]);
									  
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

				if($request->hasfile('profile_logo')) 
				{	
					/* Unlink File Function Start */ 
						if($requestData['profile_logo'] != '')
							{
								$this->unlinkFile($requestData['old_profile_logo'], Config::get('constants.profile_imgs'));
							}
					/* Unlink File Function End */
					
					$profile_logo = $this->uploadFile($request->file('profile_logo'), Config::get('constants.profile_imgs'));
				}
				else
				{
					$profile_logo = @$requestData['old_profile_logo'];
				}	
			/* Profile Image Upload Function End */						  
									  
								  					  
			$obj							= 	Admin::find(Auth::user()->id);
			
			$obj->first_name				=	@$requestData['first_name'];
			$obj->last_name					=	@$requestData['last_name'];
			$obj->phone						=	@$requestData['phone'];
			$obj->country					=	@$requestData['country'];
			$obj->state						=	@$requestData['state'];
			$obj->city						=	@$requestData['city'];
			$obj->address					=	@$requestData['address'];
			$obj->zip						=	@$requestData['zip'];
			$obj->company_name						=	@$requestData['company_name'];
			$obj->company_website						=	@$requestData['company_website'];
			$obj->primary_email						=	@$requestData['primary_email'];
			$obj->b2c_email						=	@$requestData['b2c_email'];
			$obj->b2b_email						=	@$requestData['b2b_email'];
			$obj->ref_prefix						=	@$requestData['ref_prefix'];
			$obj->invoice_id						=	@$requestData['invoice_id'];
			$obj->logo						=	@$profile_logo;
			$obj->gst_no						=	@$requestData['gst_no'];
			$obj->profile_img				=	@$profile_img;
			
			$saved							=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/my_profile')->with('success', 'Your Profile has been edited successfully.');
			}		
		}
		else
		{	
			$id = Auth::user()->id;	
			$fetchedData = Admin::find($id);
		
			return view('Admin.my_profile', compact(['fetchedData', 'countries']));
		}	
	}	
	/**
     * Change password and Logout automatiaclly.
     *
     * @return \Illuminate\Http\Response
     */
	public function change_password(Request $request)
	{
		//check authorization start	
			/* $check = $this->checkAuthorizationAction('Admin', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			} */	
		//check authorization end

		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'old_password' => 'required|min:6',
										'password' => 'required|confirmed|min:6',
										'password_confirmation' => 'required|min:6'
									  ]);
			
			
			$requestData 	= 	$request->all();
			$admin_id = Auth::user()->id;
			
			$fetchedData = Admin::where('id', '=', $admin_id)->first();
			if(!empty($fetchedData))
				{
					if($admin_id == trim($requestData['admin_id']))
						{
							 if (!(Hash::check($request->get('old_password'), Auth::user()->password))) 
								{
									return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
								}
							else
								{
									$admin = Admin::find($requestData['admin_id']);
									$admin->password = Hash::make($requestData['password']);
									if($admin->save())
										{
											Auth::guard('admin')->logout();
											$request->session()->flush();
											
											return redirect('/admin')->with('success', 'Your Password has been changed successfully.');
										}
									else
										{
											return redirect()->back()->with('error', Config::get('constants.server_error'));
										}
								}	
						}
					else
						{
							return redirect()->back()->with('error', 'You can change the password only your account.');
						}	
				}	
			else
				{
					return redirect()->back()->with('error', 'User is not exist, so you can not change the password.');
				}	
		}
		return view('Admin.change_password');		
	}
	 
	public function CustomerDetail(Request $request){
		$contactexist = Contact::where('id', $request->customer_id)->where('user_id', Auth::user()->id)->exists();
		if($contactexist){
			$contact = Contact::where('id', $request->customer_id)->with(['currencydata'])->first();
			return json_encode(array('success' => true, 'contactdetail' => $contact));
		}else{
			return json_encode(array('success' => false, 'message' => 'ID not exist'));
		}
	}
	public function editSeo(Request $request, $id = NULL)
	{
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$this->validate($request, [
										'id' => 'required'
									  ]);

			$obj				= 	SeoPage::find($requestData['id']);
			$obj->meta_title	=	@$requestData['meta_title'];
			$obj->meta_keyword	=	@$requestData['meta_keyword'];
			$obj->meta_desc		=	@$requestData['meta_desc'];

			$saved				=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/dashboard')->with('success', 'SEO Information for this Page'.Config::get('constants.edited'));
			}				
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(SeoPage::where('id', '=', $id)->exists()) 
				{
					$fetchedData = SeoPage::find($id);
					return view('Admin.seo.edit_seo', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/dashboard')->with('error', 'Page'.Config::get('constants.not_exist'));
				}	
			}
			else
			{
				return Redirect::to('/admin/dashboard')->with('error', Config::get('constants.unauthorized'));
			}		
		}		
	}
	
	public function websiteSetting(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('Admin', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		if ($request->isMethod('post')) 
		{	
			$requestData 		= 	$request->all();
			
			/* $this->validate($request, [
										'phone' => 'required|max:20',
										'ofc_timing' => 'nullable|max:255',
										'email' => 'required|max:255'
									  ]);*/	

			/* Logo Upload Function Start */						  
			/*	if($request->hasfile('logo')) 
				{	
					
						if(@$requestData['logo'] != '')
							{
								$this->unlinkFile(@$requestData['old_logo'], Config::get('constants.logo'));
							}
				
					
					$logo = $this->uploadFile($request->file('logo'), Config::get('constants.logo'));
				}
				else
				{
					$logo = @$requestData['old_logo'];
				}*/		
			/* Logoe Upload Function End */					  
			
			if(!empty(@$requestData['id']))
			{		
				$obj				= 	WebsiteSetting::find(@$requestData['id']);
			}		
			else
			{
				$obj				= 	new WebsiteSetting;
			}	
			$obj->disable_booking				=	@$requestData['disable_booking'];
			/*$obj->ofc_timing		=	@$requestData['ofc_timing'];
			$obj->email				=	@$requestData['email'];
			$obj->logo				=	@$logo;*/
			
			$saved							=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/website_setting')->with('success', 'Website Setting has been edited successfully.');
			}		
		}
		else
		{	
			$fetchedData = WebsiteSetting::where('id', '!=', '')->first();
		
			return view('Admin.website_setting', compact(['fetchedData']));
		}	
	}
	
	public function deleteAllAction(Request $request){
		$status 			= 	0;
		$method 			= 	$request->method();	
		$redirect 			= 	'';	
	
		if ($request->isMethod('post')) 
		{
			$requestData 	= 	$request->all();
			$requestData['table'] = trim($requestData['table']);
			if(isset($requestData['id']) && !empty($requestData['id']) && isset($requestData['table']) && !empty($requestData['table'])) 
			{
				$tableExist = Schema::hasTable(trim($requestData['table']));
				if($tableExist)
				{
					if($requestData['table'] == 'holiday_themes'){
						$recordExist = DB::table($requestData['table'])->wherein('id', $requestData['id'])->exists();
					}else{
						$recordExist = DB::table($requestData['table'])->wherein('id', $requestData['id'])->exists();
					}
					if($recordExist)
					{
						$id = $requestData['id'];
						$fl = true;
						foreach ($id as $ke) {
							if($requestData['table'] == 'leads'){
								$response	=	DB::table($requestData['table'])->where('id', @$ke)->delete();
								DB::table('followups')->where('lead_id', @$ke)->delete();
								
							}else if($requestData['table'] == 'holiday_themes'){
								$flag = true;
								$ptExist = DB::table('packages')->whereRaw("find_in_set('".$ke."',package_theme)")->exists();
								if($ptExist){
									$message = 'Record not deleted. it has some relation in aother record.';
									$flag = false; 
									$fl = false;
									break;
								}
								$phtExist = DB::table('holidaytypes')->where("theme_id",$ke)->exists();
								if($phtExist){
									$message = 'Record not deleted. it has some relation in aother record.';
									$flag = false; 
									$fl = false;
									break;
								}
															
								if($flag){
									$response	=	DB::table($requestData['table'])->where('id', @$ke)->delete();
								}
								
							}else if($requestData['table'] == 'packages'){
								DB::table($requestData['table'])->where('id', @$ke)->delete();
								$themeExist = DB::table('package_themes')->where('package_id', @$ke)->exists();
								if($themeExist)
								{
									$response	=	DB::table('package_themes')->where('package_id', @$ke)->delete();
								}
								
								$itinerariesExist = DB::table('package_itineraries')->where('package_id', @$ke)->exists();
								if($itinerariesExist)
								{
									$response	=	DB::table('package_itineraries')->where('package_id', @$ke)->delete();
								}
								
								$hotelExist = DB::table('package_hotels')->where('package_id', @$ke)->exists();
								if($hotelExist)
								{
									$response	=	DB::table('package_hotels')->where('package_id', @$ke)->delete();
								}
								
								$galleryExist = DB::table('package_galleries')->where('package_id', @$ke)->exists();
								if($galleryExist)
								{
									$response	=	DB::table('package_galleries')->where('package_id', @$ke)->delete();
								}
								
								$tagsExist = DB::table('metatags')->where('package_id', @$ke)->exists();
								if($tagsExist)
								{
									$response	=	DB::table('metatags')->where('package_id', @$ke)->delete();
								}
								
								$searchExist = DB::table('meta_searches')->where('package_id', @$ke)->exists();
								if($searchExist)
								{
									$response	=	DB::table('meta_searches')->where('package_id', @$ke)->delete();
								}
								
							} else if($requestData['table'] == 'hotels'){
								$flag = true;
								$phExist = DB::table('package_hotels')->where('hotel_name', $ke)->exists();
								if($phExist){
									$message = 'Record not deleted. it has some relation in another record.';
									$flag = false; 
									$fl = false;
									break; 
								}
								if($flag){
									$response	=	DB::table($requestData['table'])->where('id', @$ke)->delete();
								}
							}else if($requestData['table'] == 'inclusions'){
								$flag = true;
								$phExist = DB::table('packages')->whereRaw("find_in_set('".$ke."',package_inclusions)")->exists();
								if($phExist){
									$message = 'Record not deleted. it has some relation in aother record.';
									$flag = false; 
									$fl = false;
									break;
								}
															
								if($flag){
									$response	=	DB::table($requestData['table'])->where('id', @$ke)->delete();
								}
							}else if($requestData['table'] == 'exclusions'){
								$flag = true;
								$phExist = DB::table('packages')->whereRaw("find_in_set('".$ke."',package_exclusions)")->exists();
								if($phExist){
									$message = 'Record not deleted. it has some relation in aother record.';
									$fl = false;
										break;
								}	      						
								if($flag){
									$response	=	DB::table($requestData['table'])->where('id', @$ke)->delete();
								}
							}else if($requestData['table'] == 'amenities'){
								$flag = true;
								$phExist = DB::table('hotels')->whereJsonContains('amenities',[$ke])->exists();
								if($phExist){
									$message = 'Record not deleted. it has some relation in aother record.';
									$fl = false;
										break;
								}	      						
								if($flag){
									$response	=	DB::table($requestData['table'])->where('id', @$ke)->delete();
								}
							}else if($requestData['table'] == 'holidaytypes'){
								$flag = true;
								$phExist = DB::table('package_themes')->where('holiday_type', $ke)->exists();
								if($phExist){
									$message = 'Record not deleted. it has some relation in aother record.';
									$flag = false; 
									$fl = false;
										break;
								}
														
								if($flag){
									$response	=	DB::table($requestData['table'])->where('id', @$ke)->delete();
								
								}
							}else if($requestData['table'] == 'topinclusions'){
								$flag = true;
								$phExist = DB::table('packages')->whereRaw("find_in_set('".$ke."',package_topinclusions)")->exists();
								if($phExist){
									$message = 'Record not deleted. it has some relation in aother record.';
									$flag = false; 
									$fl = false;
										break;
								}
															
								if($flag){
									$response	=	DB::table($requestData['table'])->where('id', @$ke)->delete();
								}
							}else if($requestData['table'] == 'cities'){
								$flag = true;
								$phExist = DB::table('packages')->where('city', $ke)->exists();
								if($phExist){
									$message = 'Record not deleted. it has some relation in another record.';
									$flag = false; 
									$fl = false;
									break; 
								}
								if($flag){
									$response	=	DB::table($requestData['table'])->where('id', @$ke)->delete();
								}
							}else{
								$flag = true;
								$response	=	DB::table($requestData['table'])->where('id', @$ke)->delete();
							}	
						} 	
						if($fl){
							$status = 1;	
							$message = 'Record has been deleted successfully. Redirecting .....';
						}
					}else{
						$message = 'ID does not exist, please check it once again.';
					}
				}else{
					$message = 'Table does not exist, please check it once again.';	
				}		
			}else 
			{
				$message = 'Id OR Table does not exist, please check it once again.';		
			}
		}else 
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message));
		die;
	}
	public function deleteAction(Request $request)
	{	
		$status 			= 	0;
		$method 			= 	$request->method();	
		if ($request->isMethod('post')) 
		{
			$requestData 	= 	$request->all();
			
			$requestData['id'] = trim($requestData['id']);
			$requestData['table'] = trim($requestData['table']);
			
			$role = Auth::user()->role;
				
				if(isset($requestData['id']) && !empty($requestData['id']) && isset($requestData['table']) && !empty($requestData['table'])) 
				{
					$tableExist = Schema::hasTable(trim($requestData['table']));
					
					if($tableExist)
					{
						$recordExist = DB::table($requestData['table'])->where('id', $requestData['id'])->exists();
						
						if($recordExist)
						{
							if($requestData['table'] == 'currencies'){
								$isexist	=	$recordExist = DB::table($requestData['table'])->where('id', $requestData['id'])->exists();
								if($isexist){
									$response	=	DB::table($requestData['table'])->where('id', @$requestData['id'])->delete();
								
									if($response) 
									{	
										$status = 1;	
										$message = 'Record has been deleted successfully.';
									} 
									else 
									{
										$message = Config::get('constants.server_error');
									}
								}else{
									$message = 'ID does not exist, please check it once again.';
								}
							}else{
								$response	=	DB::table($requestData['table'])->where('id', @$requestData['id'])->delete();
								
								if($response) 
								{	
									$status = 1;	
									$message = 'Record has been deleted successfully.';
								} 
								else 
								{
									$message = Config::get('constants.server_error');
								}
							}
						}
						else
						{
							$message = 'ID does not exist, please check it once again.';
						}		
					}
					else
					{
						$message = 'Table does not exist, please check it once again.';	
					}		
				} 
				else 
				{
					$message = 'Id OR Table does not exist, please check it once again.';		
				}
					
		} 
		else 
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message));
		die;
	}
	
	
	public function deletenewAction(Request $request)
	{	
		$status 			= 	0;
		$method 			= 	$request->method();	
		if ($request->isMethod('post')) 
		{
			$requestData 	= 	$request->all();
			
			$requestData['id'] = trim($requestData['id']);
			$requestData['table'] = trim($requestData['table']);
			
			$role = Auth::user()->role;
				
				if(isset($requestData['id']) && !empty($requestData['id']) && isset($requestData['table']) && !empty($requestData['table'])) 
				{
					
						$recordExist = DB::connection('mysql2')->table($requestData['table'])->where('id', $requestData['id'])->exists();
						
						if($recordExist)
						{
							if($requestData['table'] == 'currencies'){
								$isexist	=	$recordExist = DB::connection('mysql2')->table($requestData['table'])->where('id', $requestData['id'])->exists();
								if($isexist){
									$response	=	DB::connection('mysql2')->table($requestData['table'])->where('id', @$requestData['id'])->delete();
								
									if($response) 
									{	
										$status = 1;	
										$message = 'Record has been deleted successfully.';
									} 
									else 
									{
										$message = Config::get('constants.server_error');
									}
								}else{
									$message = 'ID does not exist, please check it once again.';
								}
							}else{
								$response	=	DB::connection('mysql2')->table($requestData['table'])->where('id', @$requestData['id'])->delete();
								
								if($response) 
								{	
									$status = 1;	
									$message = 'Record has been deleted successfully.';
								} 
								else 
								{
									$message = Config::get('constants.server_error');
								}
							}
						}
						else
						{
							$message = 'ID does not exist, please check it once again.';
						}		
						
				} 
				else 
				{
					$message = 'Id OR Table does not exist, please check it once again.';		
				}
					
		} 
		else 
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message));
		die;
	}
	
	public function deleteDesAction(Request $request)
	{	
		$status 			= 	0;
		$method 			= 	$request->method();	
		if ($request->isMethod('post')) 
		{
			$requestData 	= 	$request->all();
			
			$requestData['id'] = trim($requestData['id']);
			$requestData['table'] = trim($requestData['table']);
			
			$role = Auth::user()->role;
			if($role == 1)
			{	
				if(isset($requestData['id']) && !empty($requestData['id']) && isset($requestData['table']) && !empty($requestData['table'])) 
				{
					$tableExist = Schema::hasTable(trim($requestData['table']));
					
					if($tableExist)
					{
						$recordExist = DB::table($requestData['table'])->where('id', $requestData['id'])->exists();
						
						if($recordExist)
						{
							$flag = true;
							$desExist = DB::table('packages')->where('destination', $requestData['id'])->exists();
							
							if($desExist){
								$message = 'Record not deleted. it has some relation in aother record.';
								$flag = false; 
							}
							$htExist = DB::table('hotels')->where('destination', $requestData['id'])->exists();
							
							if($htExist){
								$message = 'Record not deleted. it has some relation in aother record.';
								$flag = false; 
							}
							
							$phExist = DB::table('package_hotels')->where('destination', $requestData['id'])->exists();
							if($phExist){
								$message = 'Record not deleted. it has some relation in aother record.';
								$flag = false; 
							}
							$msExist = DB::table('meta_searches')->where('destination_id', $requestData['id'])->exists();
							if($msExist){
								$message = 'Record not deleted. it has some relation in aother record.';
								$flag = false; 
							}							
							if($flag){
								$response	=	DB::table($requestData['table'])->where('id', @$requestData['id'])->delete();
							
								if($response) 
								{	
									$status = 1;	
									$message = 'Record has been deleted successfully.';
								} 
								else 
								{
									$message = Config::get('constants.server_error');
								}
							}
						}
						else
						{
							$message = 'ID does not exist, please check it once again.';
						}		
					}
					else
					{
						$message = 'Table does not exist, please check it once again.';	
					}		
				} 
				else 
				{
					$message = 'Id OR Table does not exist, please check it once again.';		
				}
			}
			else
			{
				$message = 'You are not authorized person to perform this action.';	
			}		
		} 
		else 
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message));
		die;
	}
	
	public function deleteHotelAction(Request $request)
	{	
		$status 			= 	0;
		$method 			= 	$request->method();	
		if ($request->isMethod('post')) 
		{
			$requestData 	= 	$request->all();
			
			$requestData['id'] = trim($requestData['id']);
			$requestData['table'] = trim($requestData['table']);
			
			$role = Auth::user()->role;
			if($role == 1)
			{	
				if(isset($requestData['id']) && !empty($requestData['id']) && isset($requestData['table']) && !empty($requestData['table'])) 
				{
					$tableExist = Schema::hasTable(trim($requestData['table']));
					
					if($tableExist)
					{
						$recordExist = DB::table($requestData['table'])->where('id', $requestData['id'])->exists();
						
						if($recordExist)
						{
							$flag = true;
							
							
							$phExist = DB::table('package_hotels')->where('hotel_name', $requestData['id'])->exists();
							if($phExist){
								$message = 'Record not deleted. it has some relation in aother record.';
								$flag = false; 
							}
														
							if($flag){
								$response	=	DB::table($requestData['table'])->where('id', @$requestData['id'])->delete();
							
								if($response) 
								{	
									$status = 1;	
									$message = 'Record has been deleted successfully.';
								} 
								else 
								{
									$message = Config::get('constants.server_error');
								}
							}
						}
						else
						{
							$message = 'ID does not exist, please check it once again.';
						}		
					}
					else
					{
						$message = 'Table does not exist, please check it once again.';	
					}		
				} 
				else 
				{
					$message = 'Id OR Table does not exist, please check it once again.';		
				}
			}
			else
			{
				$message = 'You are not authorized person to perform this action.';	
			}		
		} 
		else 
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message));
		die;
	}
	
	
	
	public function deleteTopAction(Request $request)
	{	
		$status 			= 	0;
		$method 			= 	$request->method();	
		if ($request->isMethod('post')) 
		{
			$requestData 	= 	$request->all();
			
			$requestData['id'] = trim($requestData['id']);
			$requestData['table'] = trim($requestData['table']);
			
			$role = Auth::user()->role;
			if($role == 1)
			{	
				if(isset($requestData['id']) && !empty($requestData['id']) && isset($requestData['table']) && !empty($requestData['table'])) 
				{
					$tableExist = Schema::hasTable(trim($requestData['table']));
					
					if($tableExist)
					{
						$recordExist = DB::table($requestData['table'])->where('id', $requestData['id'])->exists();
						
						if($recordExist)
						{
							$flag = true;
							
							
							$phExist = DB::table('packages')->whereRaw("find_in_set('".$requestData['id']."',package_topinclusions)")->exists();
							if($phExist){
								$message = 'Record not deleted. it has some relation in aother record.';
								$flag = false; 
							}
														
							if($flag){
								$response	=	DB::table($requestData['table'])->where('id', @$requestData['id'])->delete();
							
								if($response) 
								{	
									$status = 1;	
									$message = 'Record has been deleted successfully.';
								} 
								else 
								{
									$message = Config::get('constants.server_error');
								}
							}
						}
						else
						{
							$message = 'ID does not exist, please check it once again.';
						}		
					}
					else
					{
						$message = 'Table does not exist, please check it once again.';	
					}		
				} 
				else 
				{
					$message = 'Id OR Table does not exist, please check it once again.';		
				}
			}
			else
			{
				$message = 'You are not authorized person to perform this action.';	
			}		
		} 
		else 
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message));
		die;
	} 
	  
	public function deleteTypeAction(Request $request)
	{	
		$status 			= 	0;
		$method 			= 	$request->method();	
		if ($request->isMethod('post')) 
		{
			$requestData 	= 	$request->all();
			
			$requestData['id'] = trim($requestData['id']);
			$requestData['table'] = trim($requestData['table']);
			
			$role = Auth::user()->role;
			if($role == 1)
			{	
				if(isset($requestData['id']) && !empty($requestData['id']) && isset($requestData['table']) && !empty($requestData['table'])) 
				{
					$tableExist = Schema::hasTable(trim($requestData['table']));
					
					if($tableExist)
					{
						$recordExist = DB::table($requestData['table'])->where('id', $requestData['id'])->exists();
						
						if($recordExist)
						{
							$flag = true;
							
							
							$phExist = DB::table('package_themes')->where('holiday_type', $requestData['id'])->exists();
							if($phExist){
								$message = 'Record not deleted. it has some relation in aother record.';
								$flag = false; 
							}
														
							if($flag){
								$response	=	DB::table($requestData['table'])->where('id', @$requestData['id'])->delete();
							
								if($response) 
								{	
									$status = 1;	
									$message = 'Record has been deleted successfully.';
								} 
								else 
								{
									$message = Config::get('constants.server_error');
								}
							}
						}
						else
						{
							$message = 'ID does not exist, please check it once again.';
						}		
					}
					else
					{
						$message = 'Table does not exist, please check it once again.';	
					}		
				} 
				else 
				{
					$message = 'Id OR Table does not exist, please check it once again.';		
				}
			}
			else
			{
				$message = 'You are not authorized person to perform this action.';	
			}		
		} 
		else 
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message));
		die;
	}
	
	public function deletePackageAction(Request $request)
	{	
		$status 			= 	0;
		$method 			= 	$request->method();	
		if ($request->isMethod('post')) 
		{
			$requestData 	= 	$request->all();
			
			$requestData['id'] = trim($requestData['id']);
			$requestData['table'] = trim($requestData['table']);
			
			$role = Auth::user()->role;
			/* if($role == 1)
			{ */	
				if(isset($requestData['id']) && !empty($requestData['id']) && isset($requestData['table']) && !empty($requestData['table'])) 
				{
					$tableExist = Schema::hasTable(trim($requestData['table']));
					
					if($tableExist)
					{
						$recordExist = DB::table($requestData['table'])->where('id', $requestData['id'])->exists();
						
						if($recordExist)
						{
							$response	=	DB::table($requestData['table'])->where('id', @$requestData['id'])->delete();
							
							if($response) 
							{	
								$themeExist = DB::table('package_themes')->where('package_id', $requestData['id'])->exists();
								if($themeExist)
								{
									$response	=	DB::table('package_themes')->where('package_id', @$requestData['id'])->delete();
								}
								
								$itinerariesExist = DB::table('package_itineraries')->where('package_id', $requestData['id'])->exists();
								if($itinerariesExist)
								{
									$response	=	DB::table('package_itineraries')->where('package_id', @$requestData['id'])->delete();
								}
								
								$hotelExist = DB::table('package_hotels')->where('package_id', $requestData['id'])->exists();
								if($hotelExist)
								{
									$response	=	DB::table('package_hotels')->where('package_id', @$requestData['id'])->delete();
								}
								
								$galleryExist = DB::table('package_galleries')->where('package_id', $requestData['id'])->exists();
								if($galleryExist)
								{
									$response	=	DB::table('package_galleries')->where('package_id', @$requestData['id'])->delete();
								}
								
								$tagsExist = DB::table('metatags')->where('package_id', $requestData['id'])->exists();
								if($tagsExist)
								{
									$response	=	DB::table('metatags')->where('package_id', @$requestData['id'])->delete();
								}
								
								$searchExist = DB::table('meta_searches')->where('package_id', $requestData['id'])->exists();
								if($searchExist)
								{
									$response	=	DB::table('meta_searches')->where('package_id', @$requestData['id'])->delete();
								}
								
								$status = 1;	
								$message = 'Record has been deleted successfully.';
							} 
							else 
							{
								$message = Config::get('constants.server_error');
							}
						}
						else
						{
							$message = 'ID does not exist, please check it once again.';
						}		
					}
					else
					{
						$message = 'Table does not exist, please check it once again.';	
					}		
				} 
				else 
				{
					$message = 'Id OR Table does not exist, please check it once again.';		
				}
			/* }
			else
			{
				$message = 'You are not authorized person to perform this action.';	
			} */		
		} 
		else 
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message));
		die;
	}
	
	public function editapi(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('api_key', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		if ($request->isMethod('post')) 
		{
			$obj	= 	Admin::find(Auth::user()->id);
			$obj->client_id	=	md5(Auth::user()->id.time());
			$saved				=	$obj->save();
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/api-key')->with('success', 'Api Key'.Config::get('constants.edited'));
			}
		}else{	
			return view('Admin.apikey');
		}
	}
	
	public function updatenewAction(Request $request){
		$status 			= 	0;
		$requestData 	= 	$request->all();
		if($requestData['current_status'] == 0)
		{
			$updated_status = 1;
			$message = 'Record has been enabled successfully.';
		}
		else
		{
			$updated_status = 0;
			$message = 'Record has been disabled successfully.';
		}
		$obj = \App\RoomImage::find($requestData['id']);
		$obj->status = $updated_status;
		$response = $obj->save();
		
		if($response) 
		{
			$status = 1;
			$message = 'Record Updated successfully';			
		} 
		else 
		{
			$message = Config::get('constants.server_error');
		}
		
		echo json_encode(array('status'=>$status, 'message'=>$message));
		die;
	}
	public function updateAction(Request $request)
	{	
		$status 			= 	0;
		$method 			= 	$request->method();	
		if ($request->isMethod('post')) 
		{
			$requestData 	= 	$request->all();

			$requestData['id'] = trim($requestData['id']);
			$requestData['current_status'] = trim($requestData['current_status']);
			$requestData['table'] = trim($requestData['table']);
			$requestData['col'] = trim($requestData['colname']);
			
			$role = Auth::user()->role;
			if($role == 1 || $role == 7)
			{
				if(isset($requestData['id']) && !empty($requestData['id']) && isset($requestData['current_status']) && isset($requestData['table']) && !empty($requestData['table'])) 
				{
					$tableExist = Schema::hasTable(trim($requestData['table']));
					
					if($tableExist)
					{
						$recordExist = DB::table($requestData['table'])->where('id', $requestData['id'])->exists();
						
						if($recordExist)
						{
							if($requestData['current_status'] == 0)
							{
								$updated_status = 1;
								$message = 'Record has been enabled successfully.';
							}
							else
							{
								$updated_status = 0;
								$message = 'Record has been disabled successfully.';
							}		
							
							
							if($requestData['table'] == 'agents'){
								$response 	= 	DB::table($requestData['table'])->where('id', $requestData['id'])->update([$requestData['col'] => $updated_status]);
								if($updated_status == 1){
									$set = \App\Admin::where('id',1)->first();
									$userData = \App\Agent::select('id', 'decrypt_password', 'username', 'first_name', 'last_name','email')->where('id', '=', @$requestData['id'])->first();
									$url = $link = \URL::to('/').'/agent/login';
									 $replace = array('{logo}', '{customer_name}', '{url}', '{username}', '{password}', '{support_mail}', '{company_name}');					
									$replace_with = array(\URL::to('/public/img/profile_imgs').'/'.@$set->logo, @$userData->first_name.' '.@$userData->last_name, $url, @$userData->username, @$userData->decrypt_password, @$set->b2b_email, @$set->company_name); 
		
									$this->send_email_template($replace, $replace_with, 'account-approved', @$userData->email,'Holiday Planner Account Approved',$set->primary_email);
					
								}
							}
							else if($requestData['table'] == 'room_images'){
								$obj = \App\RoomImage::find($requestData['id']);
								$obj->updated_status = $updated_status;
								$response = $obj->save();
							}else{
								$response 	= 	DB::table($requestData['table'])->where('id', $requestData['id'])->update([$requestData['col'] => $updated_status]);
							}				
							if($response) 
							{
								$status = 1;	
							} 
							else 
							{
								$message = Config::get('constants.server_error');
							}
						}
						else
						{
							$message = 'ID does not exist, please check it once again.';
						}							
					}	
					else
					{
						$message = 'Table does not exist, please check it once again.';	
					}	
				} 
				else 
				{
					$message = 'Id OR Current Status OR Table does not exist, please check it once again.';		
				}
			}
			else
			{
				$message = 'You are not authorized person to perform this action.';	
			}		
		} 
		else 
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message));
		die;
	}
	
	public function updateTypeAction(Request $request)
	{	
		$status 			= 	0;
		$method 			= 	$request->method();	
		if ($request->isMethod('post')) 
		{
			$requestData 	= 	$request->all();

			$requestData['id'] = trim($requestData['id']);
			$requestData['current_status'] = trim($requestData['current_status']);
			$requestData['table'] = trim($requestData['table']);
			$requestData['col'] = trim($requestData['colname']);
			
			$role = Auth::user()->role;
			if($role == 1 || $role == 7)
			{
				if($requestData['table'] == 'topinclusions'){
					$whereid = 'top_inc_id';
				}else{
					$whereid = 'theme_id';
				}
				if(isset($requestData['id']) && !empty($requestData['id']) && isset($requestData['current_status']) && isset($requestData['table']) && !empty($requestData['table'])) 
				{
					$tableExist = Schema::hasTable(trim($requestData['table']));
					
					if($tableExist)
					{
						
						$recordExist = DB::table($requestData['table'])->where($whereid, $requestData['id'])->where('user_id', Auth::user()->id)->exists();
						
						if($recordExist)
						{
							if($requestData['current_status'] == 0)
							{
								$updated_status = 1;
								$message = 'Record has been enabled successfully.';
							}
							else
							{
								$updated_status = 0;
								$message = 'Record has been disabled successfully.';
							}		
							//DB::enableQueryLog(); 
							$response 	= 	DB::table($requestData['table'])->where($whereid, $requestData['id'])->where('user_id', Auth::user()->id)->update([$requestData['col'] => $updated_status]);	
							if($response) 
							{
								$status = 1;	
								
							} 
							else 
							{
								//$message = DB::getQueryLog();
								$message = Config::get('constants.server_error');
							}
						}
						else
						{
							if($requestData['current_status'] == 0)
							{
								$updated_status = 1;
								
							}
							else
							{
								$updated_status = 0;
								
							}	
							if($requestData['table'] == 'topinclusions'){
								$obj				= new Topinclusion;
								$obj->status		=	$updated_status;			
								$obj->top_inc_id	=	$requestData['id'];			
								$obj->user_id		=	Auth::user()->id;			
								$saved				=	$obj->save();
							}else{
								$obj				= new Holidaytype;
								$obj->status		=	$updated_status;			
								$obj->theme_id		=	$requestData['id'];			
								$obj->user_id		=	Auth::user()->id;			
								$saved				=	$obj->save();
							}	
								if(!$saved)
								{
								}else{
									$status = 1;
									$message = 'Record has been disabled successfully.';
								}
						}							
					}	
					else
					{
						$message = 'Table does not exist, please check it once again.';	
					}	
				} 
				else 
				{
					$message = 'Id OR Current Status OR Table does not exist, please check it once again.';		
				}
			}
			else
			{
				$message = 'You are not authorized person to perform this action.';	
			}		
		} 
		else 
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message));
		die;
	}

	public function getStates(Request $request)
	{	
		$status 			= 	0;
		$data				=	array();
		$method 			= 	$request->method();	
		
		if ($request->isMethod('post')) 
		{
			$requestData 	= 	$request->all();
			
			$requestData['id'] = trim($requestData['id']);
			
			if(isset($requestData['id']) && !empty($requestData['id'])) 
			{
				$recordExist = Country::where('id', $requestData['id'])->exists();
				
				if($recordExist)
				{
					$data 	= 	State::where('country_id', '=', $requestData['id'])->get();
					
					if($data) 
					{
						$status = 1;	
						$message = 'Record has been fetched successfully.';
					} 
					else 
					{
						$message = Config::get('constants.server_error');
					}
				}
				else
				{
					$message = 'ID does not exist, please check it once again.';
				}			
			} 
			else 
			{
				$message = 'ID does not exist, please check it once again.';		
			}
		} 
		else 
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message, 'data'=>$data));
		die;
	}

	public function getChapters(Request $request)
	{	
		$status 			= 	0;
		$data				=	array();
		$method 			= 	$request->method();	
		
		if ($request->isMethod('post')) 
		{
			$requestData 	= 	$request->all();
			
			$requestData['id'] = trim($requestData['id']);
			
			if(isset($requestData['id']) && !empty($requestData['id'])) 
			{
				$recordExist = McqSubject::where('id', $requestData['id'])->exists();
				
				if($recordExist)
				{
					$data 	= 	McqChapter::where('subject_id', '=', $requestData['id'])->get();
					
					if($data) 
					{
						$status = 1;	
						$message = 'Record has been fetched successfully.';
					} 
					else 
					{
						$message = Config::get('constants.server_error');
					}
				}
				else
				{
					$message = 'ID does not exist, please check it once again.';
				}			
			} 
			else 
			{
				$message = 'ID does not exist, please check it once again.';		
			}
		} 
		else 
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message, 'data'=>$data));
		die;
	}
	
	public function addCkeditiorImage(Request $request)
	{
		echo "<pre>";
		print_r($_FILES);die;


	
		$status 			= 	0;
		$method 			= 	$request->method();	
		
		if ($request->isMethod('post')) 
		{
			$requestData 	= 	$request->all();
			
			echo "<pre>";
			print_r($requestData);die;
			
			
			if(isset($requestData['id']) && !empty($requestData['id'])) 
			{
				$recordExist = Country::where('id', $requestData['id'])->exists();
				
				if($recordExist)
				{
					$data 	= 	State::where('country_id', '=', $requestData['id'])->get();
					
					if($data) 
					{
						$status = 1;	
						$message = 'Record has been fetched successfully.';
					} 
					else 
					{
						$message = Config::get('constants.server_error');
					}
				}
				else
				{
					$message = 'ID does not exist, please check it once again.';
				}			
			} 
			else 
			{
				$message = 'ID does not exist, please check it once again.';		
			}
		} 
		else 
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message, 'data'=>$data));
		die;
	}	
	
	public function add_inclusion(Request $request)
	{
		$status 			= 	0;
		$data 			= 	'';
		$message 			= 	'';
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			if($requestData['savetype'] == 'inclusion'){
			$isexist = Inclusion::where('user_id', Auth::user()->id)->where('name',$requestData['inclusion_Name'])->first();
			if($isexist){
				$message = 'Already exist';
			}
			else{
				$obj				= 	new Inclusion;
				$obj->user_id	=	Auth::user()->id;
				
				$obj->name	=	@$requestData['inclusion_Name'];
				
				$saved				=	$obj->save();  
				
				if(!$saved)
				{
					$message = Config::get('constants.server_error'); 
				}
				else
				{
					$data = $obj;
					$status = 1;
					$message = 'successfully added';
				}
			}
		}else if($requestData['savetype'] == 'topinclusion'){
			
			$isexist = Topinclusion::where('user_id', Auth::user()->id)->where('name',$requestData['inclusion_Name'])->first();
			if($isexist){
				$message = 'Already exist';
			}
			else{
				$topinclu_image = NULL;
				if($request->hasfile('fileimage')) 
				{	
					$topinclu_image = $this->uploadFile($request->file('fileimage'), Config::get('constants.topinclusion_img')); 
				}
				$obj				= 	new Topinclusion;
				$obj->user_id	=	Auth::user()->id;
				$obj->image			=	@$topinclu_image;
				$obj->name	=	@$requestData['inclusion_Name'];
				
				$saved				=	$obj->save();  
				
				if(!$saved)
				{
					$message = Config::get('constants.server_error'); 
				}
				else
				{
					$data = $obj;
					$status = 1;
					$message = 'successfully added';
				}
			}
		}else if($requestData['savetype'] == 'exclusions'){
			
			$isexist = Exclusion::where('user_id', Auth::user()->id)->where('name',$requestData['inclusion_Name'])->first();
			if($isexist){
				$message = 'Already exist';
			}
			else{
				$obj				= 	new Exclusion;
				$obj->user_id	=	Auth::user()->id;
				
				$obj->name	=	@$requestData['inclusion_Name'];
				
				$saved				=	$obj->save();  
				
				if(!$saved)
				{
					$message = Config::get('constants.server_error'); 
				}
				else
				{
					$data = $obj;
					$status = 1;
					$message = 'successfully added';
				}
			}
		}else if($requestData['savetype'] == 'departure_x_city'){
			
			$isexist = City::where('user_id', Auth::user()->id)->where('name',$requestData['inclusion_Name'])->first();
			if($isexist){
				$message = 'Already exist';
			}
			else{
				$obj				= 	new City;
				$obj->user_id	=	Auth::user()->id;
				
				$obj->name	=	@$requestData['inclusion_Name'];
				
				$saved				=	$obj->save();  
				
				if(!$saved)
				{
					$message = Config::get('constants.server_error'); 
				}
				else
				{
					$data = $obj;
					$status = 1;
					$message = 'successfully added';
				}
			}
		}else if($requestData['savetype'] == 'holidaytype'){
			
			$isexist = Holidaytype::where('user_id', Auth::user()->id)->where('name',$requestData['inclusion_Name'])->first();
			if($isexist){
				$message = 'Already exist';
			}
			else{
				$obj				= 	new Holidaytype;
				$obj->user_id	=	Auth::user()->id;
				$obj->status	=	1;
				
				$obj->name	=	@$requestData['inclusion_Name'];
				
				$saved				=	$obj->save();  
				
				if(!$saved)
				{
					$message = Config::get('constants.server_error'); 
				}
				else
				{
					$data = $obj;
					$status = 1;
					$message = 'successfully added';
				}
			}
		}
		}else{
			$message = Config::get('constants.server_error');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message, 'data'=>$data));
		die;
	}
	
	
	public function multi_factor(Request $request)
	{
		return view('Admin.multi_factor');		
	} 
	public function sessions(Request $request)
	{
		return view('Admin.sessions');		
	} 
}
