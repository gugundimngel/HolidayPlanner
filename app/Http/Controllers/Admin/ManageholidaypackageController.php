<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\Destination;
use App\Amenitie;
use App\PackagePrice;
use App\Hotel;
use App\Holidaytype;
use App\Inclusion;
use App\Exclusion;
use App\Topinclusion;
use App\SuperTopInclusion;
use App\Holidaypackage;
use App\Package;
use App\PackageHotel;
use App\PackageTheme;
use App\PackageItinerary;
use App\PackageGallery;
use App\Metatag;
use App\MetaSearch;
use App\Location;
use App\Addon;

 
use Auth;
use Config;
 
class ManageholidaypackageController extends Controller
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
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		if(Auth::user()->role == 1){
			$query 		= Package::where('id', '!=', '')->with(['user']);
		}else{
			$query 		= Package::where('user_id', '=', Auth::user()->id);
		}
		$totalData 	= $query->count();	//for all data
		if ($request->has('package_id')) 
		{
			$package_id 		= 	$request->input('package_id'); 
			if(trim($package_id) != '')
			{
				$query->where('id', '=', @$package_id);
			}
		}
		if ($request->has('name')) 
		{
			$name 		= 	$request->input('name'); 
			if(trim($name) != '')
			{
				$query->where('package_name', 'LIKE', '%'.@$name.'%');
			}
		}
		if ($request->has('dest_type')) 
		{
			$dest_type 		= 	$request->input('dest_type'); 
			if(trim($dest_type) != '')
			{
				$query->where('type', '=', @$dest_type);
			}
		}
		$lists		= $query->orderby('id','desc')->get();
		
		return view('Admin.manageholidaypackage.index',compact(['lists', 'totalData'])); 	

		//return view('Admin.manageholidaypackage.index');	  
	} 
	
	public function create(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		if(Auth::user()->role == 1){	
			$destination 		= Location::all();		
			$amenitie 			= Amenitie::all();
			$holidaytype 		= Holidaytype::all();
			$inclusion 			= Inclusion::all();
			$exclusion 			= Exclusion::all();
			$topinclusion 		= SuperTopInclusion::all();
			$hotel 				= Hotel::all();
			$addon 				= Addon::all();
		}else{
			$destination 		= Location::all();	
			$amenitie 		= Amenitie::where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get();
			$holidaytype 		= Holidaytype::where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get();
			$inclusion 			= Inclusion::where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get();
			$exclusion 			= Exclusion::where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get();
			$topinclusion 		= SuperTopInclusion::all();
			$hotel 				= Hotel::where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get();
		}	
		
		//return view('Admin.users.create',compact(['usertype']));
		return view('Admin.manageholidaypackage.create',compact(['destination', 'amenitie',  'holidaytype', 'inclusion', 'exclusion', 'topinclusion', 'hotel','addon']));  
	}  
	 
	public function store(Request $request) 
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'dest_type' => 'required',
										'destination' => 'required',
										'package_name' => 'required',
									  ]);
									  $requestData 		= 	$request->all();
			
			$obj				= 	new Package;
			$obj->user_id	=	Auth::user()->id;
			$obj->type	=	@$requestData['dest_type'];
			$obj->destination		=	@$requestData['destination'];
			$obj->package_name			=	@$requestData['package_name'];
			$obj->package_type			=	@$requestData['pack_type'];
			$obj->tour_code			=	@$requestData['tour_code'];
			$obj->package_image_alt	=	@$requestData['package_image_alt'];
			$obj->price_on_request	=	@$requestData['price_on_request'];
			$obj->city	=	@$requestData['city'];
			$obj->package_image	=	@$requestData['package_image_id'];
			$obj->banner_image_m	=	@$requestData['banner_image_id'];
			$obj->package_overview	=	@$requestData['package_overview'];
			$obj->package_validity	=	date('Y-m-d', strtotime(@$requestData['package_validity']));
			$obj->package_enddate	=	date('Y-m-d', strtotime(@$requestData['package_enddate']));
			$obj->no_of_nights	=	@$requestData['no_of_nights'];
			$obj->details_day_night	=	@$requestData['details_day_night'];
			$obj->no_of_days	=	@$requestData['no_of_days'];
			$obj->support_no	=	@$requestData['support_no'];
			$obj->sales_price	=	@$requestData['twin'][0];
			//$obj->offer_price	=	@$requestData['offer_price'];
			$obj->discount	=	@$requestData['discount'];
			//$obj->price_details	=	@$requestData['price_details'];
			//$obj->price_summary	=	@$requestData['price_summary']; 
			$obj->onward_flight	=	@$requestData['onward_flight']; 
			$obj->return_flight	=	@$requestData['return_flight']; 
			$obj->slug	=	$this->createSlug(Auth::user()->id,'packages',@$requestData['package_name']);
			$obj->flightname	=	@$requestData['flightname']; 
			$obj->dep_city	=	@$requestData['dep_city']; 
			$obj->arv_city	=	@$requestData['arv_city']; 
			$obj->dep_time	=	@$requestData['dep_time']; 
			$obj->arv_time	=	@$requestData['arv_time'];  
			$obj->visa_overview	=	@$requestData['visa_overview'];  
		
			
			$addon = '';
			if(!empty($requestData['package_addons'])){
				for($ia =0; $ia<count(@$requestData['package_addons']); $ia++){
					$addon .= $requestData['package_addons'][$ia].',';
				}
			}
			$obj->addon	=	rtrim(@$addon,',');
			$inclusion = '';
			if(!empty($requestData['package_inclusions'])){
				for($i =0; $i<count(@$requestData['package_inclusions']); $i++){
					$inclusion .= $requestData['package_inclusions'][$i].'~';
				}
			}
			$obj->package_inclusions	=	rtrim(@$inclusion,'~');
			$topinclusion = '';
			if(!empty($requestData['package_topinclusions'])){
				for($j =0; $j<count(@$requestData['package_topinclusions']); $j++){
					$topinclusion .= $requestData['package_topinclusions'][$j].',';
				}
			}
			$obj->package_topinclusions	=	rtrim(@$topinclusion,',');
			$exclusion = '';
			if(!empty($requestData['package_exclusions'])){
				for($k =0; $k<count(@$requestData['package_exclusions']); $k++){
					$exclusion .= @$requestData['package_exclusions'][$k].'~';
				}
			}
			$obj->package_exclusions	=	rtrim(@$exclusion,'~');
			$packtheme = '';
			if(!empty($requestData['package_typetheme'])){
				for($ks =0; $ks<count(@$requestData['package_typetheme']); $ks++){
					$packtheme .= @$requestData['package_typetheme'][$ks].',';
				}
			}
			$obj->package_theme	=	rtrim(@$packtheme,',');
			
			$tour_policy = '';
			if(!empty($requestData['tour_policy'])){
				for($itp =0; $itp<count(@$requestData['tour_policy']); $itp++){
					$tour_policy .= $requestData['tour_policy'][$itp].'~';
				}
			}
			$obj->package_tourpolicy	=	rtrim(@$tour_policy,'~');
			
			//$obj->package_tourpolicy	=	@$requestData['package_tourpolicy'];
			// Pdf Upload Function Start 						  
					if($request->hasfile('pdf')) 
					{	
						$pdf = $this->uploadFile($request->file('pdf'), Config::get('constants.pdfs'));
					}
					else
					{
						$pdf = NULL;
					}		
				// Pdf  Upload Function End 	
			$obj->pdf	=	@$pdf;
			$obj->status	=	1;

			$saved				=	$obj->save();
				
			$dep_price = @$requestData['dep_price'];
			if(!empty($requestData['dep_price'])){
				if(count($dep_price) > 0){
					for($ipth = 0; $ipth<count($dep_price); $ipth++){
						$queryArray = array();
						parse_str($dep_price[$ipth], $queryArray );
						$pprice = new PackagePrice;
						$pprice->package_id = $obj->id;
						$pprice->departure_date = @$queryArray['departure_date'];
						$pprice->no_of_seats = @$queryArray['seats'];
						$pprice->twin = @$queryArray['twin'];
						$pprice->triple = @$queryArray['triple'];
						$pprice->single = @$queryArray['single'];
						$pprice->child_with_bed = @$queryArray['child_with_bed'];
						$pprice->child_without_bedbelow12 = @$queryArray['child_without_bedbelow12'];
						$pprice->child_without_bedbelow26 = @$queryArray['child_without_bedbelow26'];
						$pprice->infant = @$queryArray['infant'];
						$pprice->adult_flight = @$queryArray['adult_flight'];
						$pprice->child_flight = @$queryArray['child_flight'];
						$pprice->infant_flight = @$queryArray['infant_flight'];
						$pprice->price_type = @$queryArray['price_type'];
						$pprice->booking_amt = @$queryArray['booking_amt'];
						$pprice->dis_type = @$queryArray['dis_type'];
						$pprice->bal_rec_day = @$queryArray['balance_rec'];
						$pprice->flight_type	=	@$queryArray['flight_type'];
							if(@$queryArray['flight_type'] == 1){
								$pprice->flightname	=	@$queryArray['flightname']; 
								$pprice->dep_city	=	@$queryArray['dep_city']; 
								$pprice->arv_city	=	@$queryArray['arv_city']; 
								$pprice->dep_time	=	@$queryArray['dep_time']; 
								$pprice->arv_time	=	@$queryArray['arv_time']; 
							}
						//$pprice->price_summary = @$requestData['price_summary'];
						$saved = $pprice->save();
					}
				}
			}
			
			/* Package Theme Saving */
			/* $package_theme = @$requestData['package_theme'];
			if(!empty($requestData['package_theme'])){
			if(count($package_theme) > 0){
				for($ipth = 0; $ipth<count($package_theme); $ipth++){
					$ptheme = new PackageTheme;
					$ptheme->package_id = $obj->id;
					//$ptheme->holiday_type = @$requestData['holiday_type'][$ipth];
					$ptheme->holiday_type = @$package_theme[$ipth];
						$ptheme->save();
				}
			}	
			} */
			
			/* Itinerary Saving */
			$package_itinerary = @$requestData['itinerary_title'];
			if(!empty($requestData['itinerary_title'])){
			if(count($package_itinerary) > 0){
				for($iptra = 0; $iptra<count($package_itinerary); $iptra++){
					$pitinerary = new PackageItinerary;
					$pitinerary->package_id = $obj->id;
					$pitinerary->title = @$requestData['itinerary_title'][$iptra];
					$pitinerary->details = @$requestData['all_itinerary_detail'][$iptra];
					$pitinerary->itinerary_image = @$requestData['all_itinerary_img'][$iptra];
					$pitinerary->foodtype = @$requestData['all_itinerary_food'][$iptra];
					$pitinerary->save();
				}
			}
			}
			/* Hotel Saving*/
			$hotel_name = @$requestData['all_hotel_name'];
		if(!empty($requestData['all_hotel_name'])){
			if(count($hotel_name) > 0){
				for($ik = 0; $ik<count($hotel_name); $ik++){
					$photel = new PackageHotel;
					$photel->package_id = $obj->id;
					$photel->dest_type = @$requestData['all_dest_type'][$ik];
					$photel->destination =@$requestData['all_hotel_destination'][$ik];
					$photel->hotel_name = @$hotel_name[$ik];
						$photel->save();
				}
			}
		}
			/* Hotel Saving*/
			
			/* Gallery Saving*/
			if(!empty($requestData['all_gallery_imageid'])){
			$gallery_name = @$requestData['all_gallery_imagealt'];
			$all_gallery_imageid = @$requestData['all_gallery_imageid'];
			if(count($all_gallery_imageid) > 0){
			
				for($iga = 0; $iga<count($gallery_name); $iga++){
					$pgallery = new PackageGallery;
					$pgallery->package_id = $obj->id;				
					$pgallery->package_gallery_image =@$requestData['all_gallery_imageid'][$iga];
					$pgallery->package_gallery_image_alt = @$gallery_name[$iga];
					$pgallery->save();
				}
			}
			}
			/* Gallery Saving*/
			
			/* Meta Tags Saving*/
			$meta_title = @$requestData['all_meta_title'];
			if(!empty($requestData['all_meta_title'])){
			if(count($meta_title) > 0){
				for($imtag = 0; $imtag<count($meta_title); $imtag++){
					$pmetatag = new Metatag;
					$pmetatag->package_id = $obj->id;				
					$pmetatag->keyword =@$requestData['all_meta_keyword'][$imtag];
					$pmetatag->description =@$requestData['all_meta_desc'][$imtag];
					$pmetatag->title = @$meta_title[$imtag];
					$pmetatag->save();
				}
			}
			}
			/* Meta Tags Saving*/
			
			/* Meta Search Saving*/
			if(!empty($requestData['metasearch'])){
			$metasearch = @$requestData['metasearch'];
			if(count($metasearch) > 0){
				for($imseah = 0; $imseah<count($metasearch); $imseah++){
					$pmetasea = new MetaSearch;
					$pmetasea->package_id = $obj->id;				
					//$pmetasea->meta_search =@$requestData['metasearch'][$imeta];
					$pmetasea->destination_id = @$metasearch[$imseah];
					$pmetasea->save();
				}
			}
			}
			/* Meta Search Saving*/
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/holidaypackage/edit/'.base64_encode(convert_uuencode($obj->id)))->with('success', 'Package added Successfully');
			}				
		}		
	}  
	
	
	public function storeDuplicate(Request $request) 
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'dest_type' => 'required',
										'destination' => 'required',
										'package_name' => 'required',
									  ]);
			
			$requestData 		= 	$request->all();
			
			$obj				= 	new Package;
			$obj->user_id	=	Auth::user()->id;
			$obj->type	=	@$requestData['dest_type'];
			$obj->destination		=	@$requestData['destination'];
			$obj->package_name			=	@$requestData['package_name'];
			$obj->package_type			=	@$requestData['pack_type'];
			$obj->tour_code			=	@$requestData['tour_code'];
			$obj->package_image_alt	=	@$requestData['package_image_alt'];
			$obj->price_on_request	=	@$requestData['price_on_request'];
			$obj->city	=	@$requestData['city'];
			$obj->package_image	=	@$requestData['package_image_id'];
			$obj->banner_image_m	=	@$requestData['banner_image_id'];
			$obj->package_overview	=	@$requestData['package_overview'];
			$obj->package_validity	=	date('Y-m-d', strtotime(@$requestData['package_validity']));
			$obj->no_of_nights	=	@$requestData['no_of_nights'];
			$obj->details_day_night	=	@$requestData['details_day_night'];
			$obj->no_of_days	=	@$requestData['no_of_days'];
			$obj->support_no	=	@$requestData['support_no'];
			$obj->sales_price	=	@$requestData['twin'][0];
			//$obj->offer_price	=	@$requestData['offer_price'];
			$obj->discount	=	@$requestData['discount'];
			//$obj->price_details	=	@$requestData['price_details'];
			//$obj->price_summary	=	@$requestData['price_summary']; 
				$obj->onward_flight	=	@$requestData['onward_flight']; 
				$obj->return_flight	=	@$requestData['return_flight']; 
			$obj->slug	=	$this->createSlug(Auth::user()->id,'packages',@$requestData['package_name']);	 
			$inclusion = '';
			if(!empty($requestData['package_inclusions'])){
				for($i =0; $i<count(@$requestData['package_inclusions']); $i++){
					$inclusion .= $requestData['package_inclusions'][$i].',';
				}
			}
			$obj->package_inclusions	=	rtrim(@$inclusion,',');
			$topinclusion = '';
			if(!empty($requestData['package_topinclusions'])){
				for($j =0; $j<count(@$requestData['package_topinclusions']); $j++){
					$topinclusion .= $requestData['package_topinclusions'][$j].',';
				}
			}
			$obj->package_topinclusions	=	rtrim(@$topinclusion,',');
			$exclusion = '';
			if(!empty($requestData['package_exclusions'])){
				for($k =0; $k<count(@$requestData['package_exclusions']); $k++){
					$exclusion .= @$requestData['package_exclusions'][$k].',';
				}
			}
			$obj->package_exclusions	=	rtrim(@$exclusion,',');
			$packtheme = '';
			if(!empty($requestData['package_typetheme'])){
				for($ks =0; $ks<count(@$requestData['package_typetheme']); $ks++){
					$packtheme .= @$requestData['package_typetheme'][$ks].',';
				}
			}
			$obj->package_theme	=	rtrim(@$packtheme,',');
			$obj->package_tourpolicy	=	@$requestData['package_tourpolicy'];
			// Pdf Upload Function Start 						  
					if($request->hasfile('pdf')) 
					{	
						$pdf = $this->uploadFile($request->file('pdf'), Config::get('constants.pdfs'));
					}
					else
					{
						$pdf = NULL;
					}		
				// Pdf  Upload Function End 	
			$obj->pdf	=	@$pdf;
			$obj->status	=	1;

			$saved				=	$obj->save();  
			
			/* Package Theme Saving */
			$package_theme = @$requestData['package_theme'];
			if(!empty($requestData['package_theme'])){
			if(count($package_theme) > 0){
				for($ipth = 0; $ipth<count($package_theme); $ipth++){
					$ptheme = new PackageTheme;
					$ptheme->package_id = $obj->id;
					//$ptheme->holiday_type = @$requestData['holiday_type'][$ipth];
					$ptheme->holiday_type = @$package_theme[$ipth];
						$ptheme->save();
				}
			}	
			}
			
			/* Itinerary Saving */
			$package_itinerary = @$requestData['itinerary_title'];
			if(!empty($requestData['itinerary_title'])){
			if(count($package_itinerary) > 0){
				for($iptra = 0; $iptra<count($package_itinerary); $iptra++){
					$pitinerary = new PackageItinerary;
					$pitinerary->package_id = $obj->id;
					$pitinerary->title = @$requestData['itinerary_title'][$iptra];
					$pitinerary->details = @$requestData['all_itinerary_detail'][$iptra];
					$pitinerary->itinerary_image = @$requestData['all_itinerary_img'][$iptra];
					$pitinerary->foodtype = @$requestData['all_itinerary_food'][$iptra];
					$pitinerary->save();
				}
			}
			}
			/* Hotel Saving*/
			$hotel_name = @$requestData['all_hotel_name'];
		if(!empty($requestData['all_hotel_name'])){
			if(count($hotel_name) > 0){
				for($ik = 0; $ik<count($hotel_name); $ik++){
					$photel = new PackageHotel;
					$photel->package_id = $obj->id;
					$photel->dest_type = @$requestData['all_dest_type'][$ik];
					$photel->destination =@$requestData['all_hotel_destination'][$ik];
					$photel->hotel_name = @$hotel_name[$ik];
						$photel->save();
				}
			}
		}
			/* Hotel Saving*/
			
			/* Gallery Saving*/
			if(!empty($requestData['all_gallery_imageid'])){
			$gallery_name = @$requestData['all_gallery_imagealt'];
			$all_gallery_imageid = @$requestData['all_gallery_imageid'];
			if(count($all_gallery_imageid) > 0){
			
				for($iga = 0; $iga<count($gallery_name); $iga++){
					$pgallery = new PackageGallery;
					$pgallery->package_id = $obj->id;				
					$pgallery->package_gallery_image =@$requestData['all_gallery_imageid'][$iga];
					$pgallery->package_gallery_image_alt = @$gallery_name[$iga];
					$pgallery->save();
				}
			}
			}
			/* Gallery Saving*/
			
			/* Meta Tags Saving*/
			$meta_title = @$requestData['all_meta_title'];
			if(!empty($requestData['all_meta_title'])){
			if(count($meta_title) > 0){
				for($imtag = 0; $imtag<count($meta_title); $imtag++){
					$pmetatag = new Metatag;
					$pmetatag->package_id = $obj->id;				
					$pmetatag->keyword =@$requestData['all_meta_keyword'][$imtag];
					$pmetatag->description =@$requestData['all_meta_desc'][$imtag];
					$pmetatag->title = @$meta_title[$imtag];
					$pmetatag->save();
				}
			}
			}
			/* Meta Tags Saving*/
			
			/* Meta Search Saving*/
			if(!empty($requestData['metasearch'])){
			$metasearch = @$requestData['metasearch'];
			if(count($metasearch) > 0){
				for($imseah = 0; $imseah<count($metasearch); $imseah++){
					$pmetasea = new MetaSearch;
					$pmetasea->package_id = $obj->id;				
					//$pmetasea->meta_search =@$requestData['metasearch'][$imeta];
					$pmetasea->destination_id = @$metasearch[$imseah];
					$pmetasea->save();
				}
			}
			}
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/holidaypackage')->with('success', 'Package added Successfully');
			}				
		}	
	}  
	
	public function edit(Request $request, $id = NULL)
	{			
		//check authorization start	
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		if(Auth::user()->role == 1){	
			$destination 		= Location::all();		
			$amenitie 			= Amenitie::all();
			$holidaytype 		= Holidaytype::all();
			$inclusion 			= Inclusion::all();
			$exclusion 			= Exclusion::all();
			$topinclusion 		= SuperTopInclusion::all();
			$hotel 				= Hotel::all();
			$addon 				= Addon::all();
		}else{
			$destination 		= Location::all();	
			$amenitie 		= Amenitie::where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get();
			$holidaytype 		= Holidaytype::where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get();
			$inclusion 			= Inclusion::where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get();
			$exclusion 			= Exclusion::where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get();
			$topinclusion 		= SuperTopInclusion::all();
			$hotel 				= Hotel::where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get();
		} 
	
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'dest_type' => 'required',
										'destination' => 'required',
										'package_name' => 'required',
									  ]);
			
			$requestData 		= 	$request->all();
			//echo '<pre>'; print_r($requestData); die;
			$obj					= 	Package::find(@$requestData['id']);;
			$obj->type				=	@$requestData['dest_type'];
			$obj->destination		=	@$requestData['destination'];
			$obj->package_name		=	@$requestData['package_name'];
			$obj->package_type		=	@$requestData['pack_type'];
			$obj->tour_code			=	@$requestData['tour_code'];
			$obj->package_image_alt	=	@$requestData['package_image_alt'];
			$obj->package_image		=	@$requestData['package_image_id'];
			$obj->banner_image_m	=	@$requestData['banner_image_id'];
			$obj->city				=	@$requestData['city'];
			$obj->package_overview	=	@$requestData['package_overview'];
			$obj->price_on_request	=	@$requestData['price_on_request'];
			$obj->package_validity	=	date('Y-m-d', strtotime(@$requestData['package_validity']));
			$obj->package_enddate	=	date('Y-m-d', strtotime(@$requestData['package_enddate']));
			$obj->no_of_nights		=	@$requestData['no_of_nights'];
			$obj->details_day_night	=	@$requestData['details_day_night'];
			$obj->no_of_days		=	@$requestData['no_of_days'];
			$obj->support_no		=	@$requestData['support_no'];
			$obj->sales_price		=	@$requestData['twin'][0];
			$obj->onward_flight		=	@$requestData['onward_flight']; 
			$obj->return_flight		=	@$requestData['return_flight'];
			$obj->flightname		=	@$requestData['flight_name']; 
			$obj->dep_city			=	@$requestData['dep_city']; 
			$obj->arv_city			=	@$requestData['arv_city']; 
			$obj->dep_time			=	@$requestData['dep_time']; 
			$obj->arv_time			=	@$requestData['arv_time']; 
			$obj->visa_overview		=	@$requestData['visa_overview']; 
			$obj->slug				=	$this->createSlug(Auth::user()->id,'packages',@$requestData['package_name'], $requestData['id']);	
			
			$addon = '';
			if(!empty($requestData['package_addons'])){
				for($ia =0; $ia<count(@$requestData['package_addons']); $ia++){
					$addon .= $requestData['package_addons'][$ia].',';
				}
			}
			$obj->addon	=	rtrim(@$addon,',');

			
			$inclusion = '';
			if(!empty($requestData['package_inclusions'])){
				for($i =0; $i<count(@$requestData['package_inclusions']); $i++){
					$inclusion .= $requestData['package_inclusions'][$i].'~';
				}
			}
			$obj->package_inclusions	=	rtrim(@$inclusion,'~');
			$topinclusion = '';
			if(!empty($requestData['package_topinclusions'])){
				for($j =0; $j<count(@$requestData['package_topinclusions']); $j++){
					$topinclusion .= $requestData['package_topinclusions'][$j].',';
				}
			}
			$obj->package_topinclusions	=	rtrim(@$topinclusion,',');
			$exclusion = '';
			if(!empty($requestData['package_exclusions'])){
				for($k =0; $k<count(@$requestData['package_exclusions']); $k++){
					$exclusion .= @$requestData['package_exclusions'][$k].'~';
				}
			}
			$obj->package_exclusions	=	rtrim(@$exclusion,'~');
			$packtheme = '';
			if(!empty($requestData['package_typetheme'])){
				for($ks =0; $ks<count(@$requestData['package_typetheme']); $ks++){
					$packtheme .= @$requestData['package_typetheme'][$ks].',';
				}
			}
			$obj->package_theme	=	rtrim(@$packtheme,',');
			$obj->package_exclusions	=	rtrim(@$exclusion,'~');
			$package_tourpolicy = '';
			if(!empty($requestData['tour_policy'])){
				for($ks =0; $ks<count(@$requestData['tour_policy']); $ks++){
					$package_tourpolicy .= @$requestData['tour_policy'][$ks].'~';
				}
			}
			$obj->package_tourpolicy	=	rtrim(@$package_tourpolicy,'~');
			// Pdf Upload Function Start 						  
				if($request->hasfile('pdf')) 
				{	
				/* Unlink File Function Start */ 
					if($requestData['old_pdf'] != '')
					{
						$this->unlinkFile($requestData['old_pdf'], Config::get('constants.pdfs'));
					}
				/* Unlink File Function End */
					$pdf = $this->uploadFile($request->file('pdf'), Config::get('constants.pdfs'));
				}
				else
				{
					$pdf = $requestData['old_pdf']; 
				}		
				// Pdf  Upload Function End 	
			$obj->pdf	=	@$pdf;
			$obj->status	=	1;
			
			$saved							=	$obj->save();
			
			
			/* Package Theme Saving */
			$themeExist = DB::table('package_themes')->where('package_id', $requestData['id'])->exists();
			if($themeExist)
			{
				$response	=	DB::table('package_themes')->where('package_id', @$requestData['id'])->delete();
			}
			$package_theme = @$requestData['package_theme'];
			if(!empty($requestData['package_theme'])){
			if(count($package_theme) > 0){
				for($ipth = 0; $ipth<count($package_theme); $ipth++){
					$ptheme = new PackageTheme;
					$ptheme->package_id = $requestData['id'];
					//$ptheme->holiday_type = @$requestData['holiday_type'][$ipth];
					$ptheme->holiday_type = @$package_theme[$ipth];
						$ptheme->save();
				}
			}			
			}			
			
			/* Itinerary Saving */
			$itinerariesExist = DB::table('package_itineraries')->where('package_id', $requestData['id'])->exists();
			if($itinerariesExist)
			{
				$response	=	DB::table('package_itineraries')->where('package_id', @$requestData['id'])->delete();
			}
			$package_itinerary = @$requestData['itinerary_title'];
			if(!empty($requestData['itinerary_title'])){
			if(count($package_itinerary) > 0){
				for($iptra = 0; $iptra<count($package_itinerary); $iptra++){
					$pitinerary = new PackageItinerary;
					$pitinerary->package_id = $requestData['id'];
					$pitinerary->title = @$requestData['itinerary_title'][$iptra];
					$pitinerary->details = @$requestData['all_itinerary_detail'][$iptra];
					$pitinerary->itinerary_image = @$requestData['all_itinerary_img'][$iptra];
					$pitinerary->foodtype = @$requestData['all_itinerary_food'][$iptra];
					$pitinerary->save();
				}
			}
			}
			/* Hotel Saving*/
			$hotelExist = DB::table('package_hotels')->where('package_id', @$requestData['id'])->exists();
			if($hotelExist)
			{
				$response	=	DB::table('package_hotels')->where('package_id', @$requestData['id'])->delete();
			}
			$hotel_name = @$requestData['all_hotel_name'];
			if(!empty($requestData['all_hotel_name'])){
			if(count($hotel_name) > 0){
				for($ik = 0; $ik<count($hotel_name); $ik++){
					$photel = new PackageHotel;
					$photel->package_id = $requestData['id'];
					$photel->dest_type = @$requestData['all_dest_type'][$ik];
					$photel->destination =@$requestData['all_hotel_destination'][$ik];
					$photel->hotel_name = @$hotel_name[$ik];
						$photel->save();
				}
			}
			}
			/* Hotel Saving*/
			
			/* Gallery Saving*/
			$galleryExist = DB::table('package_galleries')->where('package_id', @$requestData['id'])->exists();
			if($galleryExist)
			{
				$response	=	DB::table('package_galleries')->where('package_id', @$requestData['id'])->delete();
			}
			$gallery_name = @$requestData['all_gallery_imagealt'];
			if(!empty($requestData['all_gallery_imagealt'])){
			if(count($gallery_name) > 0){
			
				for($iga = 0; $iga<count($gallery_name); $iga++){
					$pgallery = new PackageGallery;
					$pgallery->package_id = $requestData['id'];				
					$pgallery->package_gallery_image =@$requestData['all_gallery_imageid'][$iga];
					$pgallery->package_gallery_image_alt = @$gallery_name[$iga];
					$pgallery->save();
				}
			}
			}
			/* Gallery Saving*/
			
			/* Meta Tags Saving*/
			$tagsExist = DB::table('metatags')->where('package_id', $requestData['id'])->exists();
			if($tagsExist)
			{
				$response	=	DB::table('metatags')->where('package_id', @$requestData['id'])->delete();
			}
			$meta_title = @$requestData['all_meta_title'];
// 			dd($requestData);
			if(!empty($requestData['all_meta_title'])){
			if(count($meta_title) > 0){
				for($imtag = 0; $imtag<count($meta_title); $imtag++){
					$pmetatag = new Metatag;
					$pmetatag->package_id = $requestData['id'];				
					$pmetatag->keyword =@$requestData['all_meta_keyword'][$imtag];
					$pmetatag->description =@$requestData['all_meta_desc'][$imtag];
					$pmetatag->canonicaltag =@$requestData['canonicaltag'][$imtag];
					$pmetatag->title = @$meta_title[$imtag];
					$pmetatag->save();
				}
			}
			}
			/* Meta Tags Saving*/
			
			/* Meta Search Saving*/
			$searchExist = DB::table('meta_searches')->where('package_id', $requestData['id'])->exists();
			if($searchExist)
			{
				$response	=	DB::table('meta_searches')->where('package_id', @$requestData['id'])->delete();
			}
			$metasearch = @$requestData['metasearch'];
			if(!empty($requestData['metasearch'])){
			if(count($metasearch) > 0){
				for($imseah = 0; $imseah<count($metasearch); $imseah++){
					$pmetasea = new MetaSearch;
					$pmetasea->package_id = $requestData['id'];				
					//$pmetasea->meta_search =@$requestData['metasearch'][$imeta];
					$pmetasea->destination_id = @$metasearch[$imseah];
					$pmetasea->save();
				}
			}
			}
			/* Meta Search Saving*/

			/*Price*/
			
			$aa = array();
			$dep_price = @$requestData['dep_price'];
			if(!empty($requestData['dep_price'])){
				if(count($dep_price) > 0){
					
					for($ipths = 0; $ipths<count($dep_price); $ipths++){
						$queryArrays = array();
						parse_str($dep_price[$ipths], $queryArrays );
					$aa[] = @$queryArrays['priceid'];
						
					}
				}
			}
			$ppdetail = PackagePrice::where('package_id',$requestData['id'])->get();
			
			foreach($ppdetail as $r){
				if(!in_array($r->id, $aa)){
					PackagePrice::where('package_id',$requestData['id'])->where('id', $r->id)->delete();
				}
			}
			
			
				
			if(!empty($requestData['dep_price'])){
				if(count($dep_price) > 0){
					for($ipth = 0; $ipth<count($dep_price); $ipth++){
						$queryArray = array();
						parse_str($dep_price[$ipth], $queryArray );
						
						$isexist = PackagePrice::where('id', @$queryArray['priceid'])->exists();
						if($isexist){
							$pprice =  PackagePrice::find(@$queryArray['priceid']);
							$pprice->departure_date = @$queryArray['departure_date'];
							$pprice->no_of_seats = @$queryArray['seats'];
							$pprice->twin = @$queryArray['twin'];
							$pprice->triple = @$queryArray['triple'];
							$pprice->single = @$queryArray['single'];
							$pprice->child_with_bed = @$queryArray['child_with_bed'];
							$pprice->child_without_bedbelow12 = @$queryArray['child_without_bedbelow12'];
							$pprice->child_without_bedbelow26 = @$queryArray['child_without_bedbelow26'];
							$pprice->infant = @$queryArray['infant'];
							$pprice->adult_flight = @$queryArray['adult_flight'];
							$pprice->child_flight = @$queryArray['child_flight'];
							$pprice->infant_flight = @$queryArray['infant_flight'];
							$pprice->price_type = @$queryArray['price_type'];
							$pprice->booking_amt = @$queryArray['booking_amt'];
							$pprice->dis_type = @$queryArray['dis_type'];
							$pprice->bal_rec_day = @$queryArray['balance_rec'];
							$pprice->flight_type	=	@$queryArray['flight_type'];
							if(@$queryArray['flight_type'] == 1){
								$pprice->flightname	=	@$queryArray['flightname']; 
								$pprice->dep_city	=	@$queryArray['dep_city']; 
								$pprice->arv_city	=	@$queryArray['arv_city']; 
								$pprice->dep_time	=	@$queryArray['dep_time']; 
								$pprice->arv_time	=	@$queryArray['arv_time']; 
							}
							//$pprice->price_summary = @$requestData['price_summary'];
							$saved = $pprice->save();	
						}else{
							$pprice = new PackagePrice;
							$pprice->package_id = $obj->id;
							$pprice->departure_date = @$queryArray['departure_date'];
							$pprice->no_of_seats = @$queryArray['seats'];
							$pprice->twin = @$queryArray['twin'];
							$pprice->triple = @$queryArray['triple'];
							$pprice->single = @$queryArray['single'];
							$pprice->child_with_bed = @$queryArray['child_with_bed'];
							$pprice->child_without_bedbelow12 = @$queryArray['child_without_bedbelow12'];
							$pprice->child_without_bedbelow26 = @$queryArray['child_without_bedbelow26'];
							$pprice->infant = @$queryArray['infant'];
							$pprice->adult_flight = @$queryArray['adult_flight'];
							$pprice->child_flight = @$queryArray['child_flight'];
							$pprice->infant_flight = @$queryArray['infant_flight'];
							$pprice->price_type = @$queryArray['price_type'];
							$pprice->booking_amt = @$queryArray['booking_amt'];
							$pprice->dis_type = @$queryArray['dis_type'];
							$pprice->bal_rec_day = @$queryArray['balance_rec'];
							$pprice->flight_type	=	@$queryArray['flight_type'];
							if(@$queryArray['flight_type'] == 1){
								$pprice->flightname	=	@$queryArray['flightname']; 
								$pprice->dep_city	=	@$queryArray['dep_city']; 
								$pprice->arv_city	=	@$queryArray['arv_city']; 
								$pprice->dep_time	=	@$queryArray['dep_time']; 
								$pprice->arv_time	=	@$queryArray['arv_time']; 
							}
							//$pprice->price_summary = @$requestData['price_summary'];
							$saved = $pprice->save();
						}
					}
				}
			}
			/*Price*/
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			
			else
			{
				return Redirect::to('/admin/holidaypackage/edit/'.base64_encode(convert_uuencode($requestData['id'])))->with('success', 'Package Edited Successfully');
			}			
			 
		}
		else{	
			
			if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	
				if(Package::where('id', '=', $id)->exists()) 
				{
					$fetchedData = Package::find($id);
					return view('Admin.manageholidaypackage.edit',compact(['fetchedData','destination', 'amenitie',  'holidaytype', 'inclusion', 'exclusion', 'topinclusion', 'hotel', 'addon']));
				} 
				else
				{
					return Redirect::to('/admin/holidaypackage')->with('error', 'Package Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/holidaypackage')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	
	public function duplicate(Request $request, $id = NULL)
	{	
		//check authorization start	
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		//check authorization end
		if(Auth::user()->role == 1){	
			$destination 		= Location::all();		
			$amenitie 			= Amenitie::all();
			$holidaytype 		= Holidaytype::all();
			$inclusion 			= Inclusion::all();
			$exclusion 			= Exclusion::all();
			$topinclusion 		= SuperTopInclusion::all();
			$hotel 				= Hotel::all();
			$addon 				= Addon::all();
		}else{
			$destination 		= Location::all();	
			$amenitie 		= Amenitie::where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get();
			$holidaytype 		= Holidaytype::where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get();
			$inclusion 			= Inclusion::where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get();
			$exclusion 			= Exclusion::where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get();
			$topinclusion 		= SuperTopInclusion::all();
			$hotel 				= Hotel::where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get();
		} 
		if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	
				if(Package::where('id', '=', $id)->exists()) 
				{
					$fetchedData = Package::find($id);
					return view('Admin.manageholidaypackage.clone',compact(['fetchedData','destination', 'amenitie',  'holidaytype', 'inclusion', 'exclusion', 'topinclusion', 'hotel', 'addon']));
				} 
				else
				{
					return Redirect::to('/admin/holidaypackage')->with('error', 'Package Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/holidaypackage')->with('error', Config::get('constants.unauthorized'));
			}		
			
					
					 	
	}
	  
	public function getPackages(Request $request){
		$destype = $request->destination;
		if($destype != ''){
			$Package = Package::where('user_id', '=', Auth::user()->id)->where('destination',$destype)->orderby('sort_order','ASC')->get();
			$fixedval = ''; $pa = 1;
			echo '<ul id="sortable">';
			foreach($Package as $lpack){
				?>
				 <li id="<?php echo $lpack->id; ?>" class="ui-state-default">
				 <span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo @$lpack->package_name; ?> (Tour Code: <?php echo @$lpack->tour_code; ?>)</li>
				<?php
				$fixedval .= $lpack->id.':'.$pa.',';
				$pa++;
			}
			echo '</ul> <input type="hidden" id="order_sort" name="order_sort" value="'.rtrim($fixedval, ',').'" />';
		}	
		die; 
	}
	public function getDestinations(Request $request){
		$destype = $request->destype;
		if($destype != ''){
			echo '<option value="">Choose One...</option>';
			//if(Auth::user()->role == 1){
				$destination = Location::where('dest_type',$destype)->get();
			/*}  else{
				$destination = Location::where('dest_type',$destype)->where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get();
			} */
			foreach (@$destination as $ut){
				echo '<option value="'.$ut->id.'">'.$ut->name.'</option>';
			}
		}else{
			echo '<option value="">Choose One...</option>';
		}
		die; 
	}
	/* public function getHotels(Request $request){
		$desnate = $request->desnate;
		$destype = $request->destype;
		if($destype != '' && $desnate != ''){
			echo '<option value="">Choose One...</option>';
			$hotel = Hotel::where('dest_type',$destype)->where('destination',$desnate)->get();
			foreach (@$hotel as $hotl){ 
				echo '<option value="'.$hotl->id.'">'.$hotl->name.'</option>';
			}
		}else{
			echo '<option value="">Choose One...</option>';
		}
		die;
	} */
	public function getHotels(Request $request){
		$desnate = $request->desnate;
		if($desnate != ''){
			echo '<option value="">Choose One...</option>';			
			if(Auth::user()->role == 1){
				$hotel = Hotel::where('destination',$desnate)->get();
			}else{
				$hotel = Hotel::where('destination',$desnate)->where('user_id', '=', Auth::user()->id)->orderby('id', 'desc')->get(); 
			}
			foreach (@$hotel as $hotl){
				echo '<option value="'.$hotl->id.'">'.$hotl->name.'</option>';
			}
		}else{
			echo '<option value="">Choose One...</option>';
		}
		die;
	}
	
	public function sortPackage(Request $request){
		$Package = Package::where('user_id', '=', Auth::user()->id)->orderby('sort_order','ASC')->get();
		return view('Admin.manageholidaypackage.sort', compact(['Package']));
	}
	
	public function addSort(Request $request){
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			$ordersort = explode(',', $requestData['order_sort']);
			for($ic = 0; $ic < count($ordersort); $ic++){
				$ordersorts = explode(':', $ordersort[$ic]);
				if(Package::where('user_id', '=', Auth::user()->id)->where('id', '=',$ordersorts[0])->exists()) 
				{
					$obj	= Package::find($ordersorts[0]);	
					$obj->sort_order		=	@$ordersorts[1];
					$saved				=	$obj->save();
				}
				
			}
			if(!$saved)
			{ 
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/sort-package')->with('success', 'Package Sorted Successfully');
			}
		}
	}
	
}
