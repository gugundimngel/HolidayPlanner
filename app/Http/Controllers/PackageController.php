<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Razorpay\Api\Api;
use Tzsk\Payu\Facade\Payment;
use App\MyConfig;
use App\PackageBookingDetail;
use App\PackagePaymentDetail;

use App\Destination;
use App\Location;
use App\Package;
use App\WebsiteSetting;
use App\PackagePrice;
use App\Addon;
use App\Coupon;
use App\User;
use App\PackageEnquiry;
use Mail;
use App\Mail\EnquiryMail;
use Illuminate\Support\Facades\Session;

use Config;
use Auth;
use Cookie;

class PackageController extends Controller
{
	public function __construct()
    {	
		$siteData = WebsiteSetting::where('id', '!=', '')->first();
		\View::share('siteData', $siteData);
	}
	public function index(Request $request, $slug = NULL)
    {
		if(isset($slug) && !empty($slug))
		{
			$myquery = Location::where('slug', '=', $slug)->first();
			if(!$myquery){
			    $title = $slug.' destination not found.';
			   return back()->with('error', $title);
			}
			
			//$myquery = Destination::where('dest_id', '=', $myloc->id)->where('is_active', '=', '1')->with(['myloc'])->first();
			$query = Package::where('destination', '=', $myquery->id)->where('status', '=', 1);
				 
			$destinationdetail		= $query->with(['media'])->sortable(['sort_order'=>'ASC'])->paginate(20);
			
			$client_id = env('TRAVEL_CLIENT_ID', '');
			
			$furl = env('TRAVEL_API_URL', '')."filterdata?slug=".$slug."&client_id=".$client_id; 
			
			$filterlist = $this->GetcurlRequest($furl,'GET','');
			
			return view('packagelist', compact(['destinationdetail', 'slug', 'filterlist','myquery']));
		}
		
    }
	
	 public function theme(Request $request, $slug = NULL)
    {
		if(isset($slug) && !empty($slug))
		{
			$client_id = env('TRAVEL_CLIENT_ID', '');
			 $iurl = env('TRAVEL_API_URL', '')."theme-detail?slug=".$slug."&order=DESC&limit=10&client_id=".$client_id; 
			$destinationdetail = $this->GetcurlRequest($iurl,'GET','');
			
			$furl = env('TRAVEL_API_URL', '')."filterdata?themeslug=".$slug."&client_id=".$client_id; 
			$filterlist = $this->GetcurlRequest($furl,'GET','');
			return view('themelist', compact(['destinationdetail', 'slug', 'filterlist']));
		}
		
    } 
	
	public function Search(Request $request)
    {
		$client_id = env('TRAVEL_CLIENT_ID', '');
		
		$ilocation = env('TRAVEL_API_URL', '')."location?name=".$request->term; 
		$locationdetail = $this->GetcurlRequest($ilocation,'GET','');
		 $locations = json_decode($locationdetail);
		
		$iurl = env('TRAVEL_API_URL', '')."destination-detail?slug=".$locations->slug."&order=DESC&limit=10&client_id=".$client_id; 
		$destinationdetail = $this->GetcurlRequest($iurl,'GET','');
		
		$furl = env('TRAVEL_API_URL', '')."filterdata?slug=".$locations->slug."&client_id=".$client_id; 
		$slug = $locations->slug;
		$filterlist = $this->GetcurlRequest($furl,'GET','');
		return view('packagelist', compact(['destinationdetail', 'slug', 'filterlist']));
		
    }
	   
	public function searchpackagedetails(Request $request)
    {
		if(isset($request->tslug) && !empty($request->tslug))
		{
			$slug = $request->tslug;
		}else{
			$slug = $request->slug;
		}

			$myquery = Location::where('slug', '=', $slug)->first();
			//$myquery = Destination::where('dest_id', '=', $myloc->id)->where('is_active', '=', '1')->with(['myloc'])->first();
			DB::enableQueryLog(); 
			$query = Package::where('status', '=', 1);
			$query->where('destination', '=', $myquery->id);
			if ($request->has('price') && $request->price != '') 
			{
				$pprice = explode('_',$request->price);
				$from 		= 	 trim($pprice[0]);
				$to 		= 	 trim($pprice[1]);
					
				/* $query->where('sales_price', '>=', $from);
				$query->where('sales_price', '<=', $to); */
				$query->whereBetween('sales_price', [$from, $to]);
				  
			}
			if ($request->has('flight')) 
			{
				$flight = $request->flight;
				if(in_array('1', $flight)){
					$query->Where('onward_flight', '!=', '');
					$query->Where('return_flight', '!=', '');
				}else if(in_array('0', $flight)){
					$query->Where('onward_flight', '=', '');
					$query->Where('return_flight', '=', '');
				}else{
					
				}
				
			}
			if ($request->has('ptype') && $request->ptype != '') 
			{
				$ptype = $request->ptype;
				$query->where(function ($query) use ($ptype) {
					 $query->where('package_type', '=',$ptype[0]);
						for($i = 1; $i<count($ptype); $i++){
							$query->orWhere('package_type', '=', $ptype[$i]);
						}
					});	
				
			}
			$f = 'asc';
			if ($request->has('filter') && $request->filter != '') 
			{
				$f = $request->filter;
			}
			$totalData = $query->count();
			//dd(DB::getQueryLog());
			$dest		= $query->with(['media','packloc'])->sortable(['sales_price'=> $f])->paginate(20);
			
			return view('searchlist', compact(['dest','totalData','myquery']));
    }
	
	public function packdetails(Request $request,$dslug= NULL ,$slug = NULL)
    {
		if(isset($slug) && !empty($slug))
		{
			$query = Package::where('slug', '=', $request->slug)->where('status', '=', '1');
		    
			$packagedetail 	= 	$query->with(['packigalleries' => function($query)
					{
						$query->select('id','package_id','package_gallery_image_alt','package_gallery_image');
						$query->with(['galleriesmedia' => function($subQuery){
							$subQuery->select('id','images');
						}]);
					}, 'packhotel'=>function($query){
							$query->select('id', 'package_id', 'hotel_name');
							
						   $query->with(['hotel' => function($subsQuery){
							$subsQuery->select('id','name','hotel_category','image_alt','image','hotel_gallery','description', 'address');
						}]);  
					}, 'packitinerary'=>function($query){
						$query->select('id', 'package_id', 'title', 'details', 'itinerary_image', 'foodtype');
						$query->with(['itsmedia' => function($subQuerys){
							$subQuerys->select('id','images');
						}]);
					}, 'bamedia'=>function($query){
						$query->select('id','images');
						
					}])->first();
			$Packagess = Package::where('id', '@=', $packagedetail->id)->where('destination', '=', $packagedetail->destination)->with(['media']);
			$totalpac = $Packagess->count();
			$Packages = $Packagess->paginate(3);	
			
			return view('packdetails', compact(['Packages','packagedetail','dslug','totalpac']));
		}
		
    }
	
	public function thanks(Request $request)
    {
		return view('thanks');
	}	
	public function enquiryContact(Request $request)
    {
		$requestdata =  $request->all();
		if($requestdata['captcha'] != $requestdata['code']){
			return json_encode(array('success'=> false,'message'=> 'Captcha Invalid'));
		}
		
		$client_id = env('TRAVEL_CLIENT_ID', '');
		$requestdata['client_id'] = env('TRAVEL_CLIENT_ID', '');
		$data_string = json_encode($requestdata);
		$iurl = env('TRAVEL_API_URL', '')."enquiry-contact";
		$packagedetail = $this->GetcurlRequest($iurl,'POST',$data_string);
			
		return $packagedetail;
		
    }
    
    public function package_enquiry(Request $request){
       
        $requestdata =  $request->all();
		if($requestdata['captcha'] != $requestdata['code']){
			return back()->with('error','Captcha code error.');
		}
		
		$enquiry = new PackageEnquiry;
		$enquiry->name = $requestdata['name'];
		$enquiry->email = $requestdata['email'];
		$enquiry->phone = $requestdata['phone'];
		$enquiry->city = $requestdata['city'];
		$enquiry->travel_date = $requestdata['traveldate'];
		$enquiry->adult = $requestdata['adults'];
		$enquiry->children = $requestdata['children'];
		$enquiry->message = $requestdata['add_info'];
		$enquiry->package_id = $requestdata['package_id'];
		$enquiry->save();
		
		if($enquiry){
		    $package = Package::where('id',$requestdata['package_id'])->first();
		    $sender = $requestdata['email'];
		    $content = [
		            "package_name" => $package->package_name,
		            "name" => $requestdata['name'],
		            "phone" => $requestdata['phone'],
		            "city" => $requestdata['city'],
		            "travel_date" => $requestdata['traveldate'],
		            "adult" => $requestdata['adults'],
		            "children" => $requestdata['children'],
		            "message" => $requestdata['add_info']
		        ];
		    
		    $mail = Mail::to('Support@holidaychacha.com')->send(new EnquiryMail($sender));
		    if($mail){
		        return back()->with('success','Enquiry Mail sent.');
		    }else{
		        return back()->with('error','Mail not sent.');
		    }
		    
		}
		
    }
	
	public static function topInclusion($iInclusionid){
		$client_id = env('TRAVEL_CLIENT_ID', '');
		$iurl = env('TRAVEL_API_URL', '')."top-inclusion/".$iInclusionid."&client_id=".$client_id; 
		return (new static)->GetcurlRequest($iurl,'GET','');
	}
	
	public static function themepachages($typeid){
		$client_id = env('TRAVEL_CLIENT_ID', '');
		$iurl = env('TRAVEL_API_URL', '')."type-by-package/".$typeid."?client_id=".$client_id; 
		return (new static)->GetcurlRequest($iurl,'GET','');
	}
	
	public static function Inclusion($iInclusionid){
		$client_id = env('TRAVEL_CLIENT_ID', '');
		$iurl = env('TRAVEL_API_URL', '')."inclusion/".$iInclusionid."&client_id=".$client_id; 
		return (new static)->GetcurlRequest($iurl,'GET','');
	}
	
	public static function Exclusion($iInclusionid){
		$client_id = env('TRAVEL_CLIENT_ID', '');
		$iurl = env('TRAVEL_API_URL', '')."exclusion/".$iInclusionid."&client_id=".$client_id; 
		return (new static)->GetcurlRequest($iurl,'GET','');
	}
	
	public function packbooking(Request $request, $packageid = NULL)
    {
		if(isset($packageid) && !empty($packageid))
		{
			 $id = $this->decodeString($packageid);	
			 
			 $selecteddate = isset($_GET['date']) ? date('Y-m-d', $_GET['date']) : '';
			$explode = explode('-', $selecteddate);

			$seldate = $explode[1].'/'.$explode[2].'/'.$explode[0];
			$allprice = \App\PackagePrice::select('departure_date','twin','single','triple','child_with_bed','child_without_bedbelow12','child_without_bedbelow26','infant','no_of_seats')->where('package_id',$id)->where('departure_date',$seldate)->first();
			//echo '<pre>'; print_r($allprice); die;
			if($allprice){
			$pax = isset($_GET['srch']) ? $_GET['srch'] : ''; 
			$hid = isset($_GET['hid']) ? $_GET['hid'] : ''; 
			$eexplode = explode('|', $hid);
			$nhdid = isset($_GET['nhdid']) ? $_GET['nhdid'] : ''; 
			$erexplode = explode('|', $nhdid);
			$explode = explode('|', $pax);
			$adults = 0; $Infant = 0; $cwb = 0; $cwob = 0; $cwobb = 0;
			for($i =0; $i<count($explode); $i++){
				$rooms = explode('-', $explode[$i]);
				for($ij =0; $ij<$rooms[1]; $ij++){
					$adults = $ij + 1;
				}
				
				for($ijin =0; $ijin<$rooms[2]; $ijin++){
					$Infant = $ijin + 1;
				}
				
				for($ijcb =0; $ijcb<$rooms[3]; $ijcb++){
					$cwb = $ijcb + 1;
				}
				for($ijcob =0; $ijcob<$rooms[4]; $ijcob++){
					$cwob = $ijcob + 1;
				}
				for($ijcobb =0; $ijcobb<$rooms[5]; $ijcobb++){
					$cwobb = $ijcobb + 1;
				}
				
			}
			
			$selectedseats = $adults + $Infant + $cwb + $cwob + $cwobb;
				$exp = $allprice->departure_date;
				 $no_of_seats = $allprice->no_of_seats;
				  if($selectedseats > $no_of_seats){
					  return redirect()->back()->with('error', 'Seats Not Available');
					  exit;
				 }
			
			}else{
				return redirect()->back()->with('error', 'Package Not Found');
			}
			 
			$isexist = Package::where('id',$id)->exists();
			if($isexist){
				$query = Package::where('id', '=', $id)->where('status', '=', '1');
			$packagedetail 	= 	$query->with(['packigalleries' => function($query)
					{
						$query->select('id','package_id','package_gallery_image_alt','package_gallery_image');
						$query->with(['galleriesmedia' => function($subQuery){
							$subQuery->select('id','images');
						}]);
					}, 'packhotel'=>function($query){
							$query->select('id', 'package_id', 'hotel_name');
							
						   $query->with(['hotel' => function($subsQuery){
							$subsQuery->select('id','name','hotel_category','image_alt','image','description', 'address');
						}]);  
					}, 'packitinerary'=>function($query){
						$query->select('id', 'package_id', 'title', 'details', 'itinerary_image', 'foodtype');
						$query->with(['itsmedia' => function($subQuerys){
							$subQuerys->select('id','images');
						}]);
					}, 'bamedia'=>function($query){
						$query->select('id','images');
						
					}])->first();
				return view('packbooking', compact(['packagedetail']));
			}else{
				abort(404);
			}
		}else{
			abort(404);
		}
	}
	
	public function payment(Request $request){
		if($request->payment_method != ''){
			$pessager = $request->all();
			 //echo '<pre>'; print_r($pessager); die;
			$id = $this->decodeString($pessager['package_id']);
			
			$selecteddate =  explode('-', date('Y-m-d', $pessager['package_date']));

			$seldate = $selecteddate[1].'/'.$selecteddate[2].'/'.$selecteddate[0];
			$allprice = \App\PackagePrice::select('departure_date','twin','single','triple','child_with_bed','child_without_bedbelow12','child_without_bedbelow26','infant','no_of_seats')->where('package_id',$id)->where('departure_date',$seldate)->first();
			//echo '<pre>'; print_r($allprice); die;
			if($allprice){
				 $explode = explode('|', $pessager['p_id']);
			$counttravler = 0;
			$countadult = 0;
			$countinfant = 0;
			$countcb = 0;
			$countcob = 0;
			$countcobb = 0;
			$adultprice = 0;
			$cwob = 0;
			$cwobb = 0;
			$cwb = 0;
			$infnt = 0;
			for($i =0; $i<count($explode); $i++){
				$rooms = explode('-', $explode[$i]);
				$countadult += $rooms[1];
				$countinfant += $rooms[2];
				$countcb += $rooms[3];
				$countcob += $rooms[4];
				$countcobb += $rooms[5];
				
				if($rooms[1] == 1){
					$price = $allprice->single;
				}else if($rooms[1] == 2){
					$price = $allprice->twin;
				}else{
					$price = $allprice->triple;
				}
				$adultprice += $price * $rooms[1];
			}
			$counttravler = $countadult + $countinfant + $countcb + $countcob +$countcobb; 
			
			 $selectedseats = $counttravler; 
				
				 $no_of_seats = $allprice->no_of_seats;
				  if($selectedseats > $no_of_seats){
					  return redirect()->back()->with('error', 'Seats Not Available');
					  exit;
				 }
			
			}else{
				return redirect()->back()->with('error', 'Package Not Found');
			}
			
			
			
			
			// $roomtype = $pessager['roomtype'];
			 $selecteddate = date('Y-m-d', $pessager['package_date']);
			 $explode = explode('-', $selecteddate);
			$date = $explode[1].'/'.$explode[2].'/'.$explode[0];
			 $allprice = PackagePrice::select('twin','single','triple','child_with_bed','child_without_bedbelow12','child_without_bedbelow26','infant')->where('package_id',$id)->where('departure_date',$seldate)->first();
			 
				
			 //echo '<pre>'; print_r($pessager); die;
			 if($allprice){
			 }else{
				 return redirect()->back()->with('error', 'Package Not Found');
			 }
			if(@Auth::user()){
				$user = User::where('id', '=', Auth::user()->id)->first();
			}else{
				if(User::where('email', '=', $pessager['email'])->exists()) 
				{
					$user = User::where('email', '=', $pessager['email'])->first();
					}else{
						$user = new User;
					$user->email = @$pessager['email'];
					$user->phone = @$pessager['phone'];
					$user->title = @$pessager['adulttitle'][0];
					$user->first_name = @$pessager['passenger'][1]['adultfirstname'][0];
					$user->last_name = @$pessager['passenger'][1]['adultlastname'][0];
					$user->password = Hash::make(@$pessager['passenger'][1]['adultfirstname'][0].time());
					$user->status = 1;
					$save = $user->save();
				}
			}
			
			
			 $explode = explode('|', $pessager['p_id']);
			$counttravler = 0;
			$countadult = 0;
			$countinfant = 0;
			$countcb = 0;
			$countcob = 0;
			$countcobb = 0;
			$adultprice = 0;
			$cwob = 0;
			$cwobb = 0;
			$cwb = 0;
			$infnt = 0;
			for($i =0; $i<count($explode); $i++){
				$rooms = explode('-', $explode[$i]);
				$countadult += $rooms[1];
				$countinfant += $rooms[2];
				$countcb += $rooms[3];
				$countcob += $rooms[4];
				$countcobb += $rooms[5];
				
				if($rooms[1] == 1){
					$price = $allprice->single;
				}else if($rooms[1] == 2){
					$price = $allprice->twin;
				}else{
					$price = $allprice->triple;
				}
				$adultprice += $price * $rooms[1];
			}
			$counttravler = $countadult + $countinfant + $countcb + $countcob +$countcobb; 
			$counttchild = $countcb + $countcob + $countcobb; 
				if($countinfant >0){
					$infnt = @$allprice->infant * $countinfant;
				}
			if($countcb >0){
					$cwb = @$allprice->child_with_bed * $countcb;
				}
				if($countcob >0){
					$cwob = @$allprice->child_without_bedbelow12 * $countcob;
				}
				if($countcobb >0){
					$cwobb = @$allprice->child_without_bedbelow26 * $countcobb;
				}
			$totlaprice = $adultprice + $infnt + $cwob + $cwb + $cwobb;
			$addons = array();
			$adultaddonprice = 0;
			$childaddonprice = 0;
			$infantaddonprice = 0;
			if(!empty(@$pessager['myaddons'])){
				$myaddons = $pessager['myaddons'];
				for($ai = 0; $ai<count($myaddons); $ai++){
					$addon = Addon::where('id',$myaddons[$ai])->first();
					$addons[] = array(
						'name' => $addon->title,
						'price' => $addon->price,
						'child' => $addon->child,
						'infant' => $addon->infant,
						'duration' => $addon->duration,
					);
					
					$adultaddonprice += $addon->price * $countadult;
					$childaddonprice += $addon->child * $counttchild;
					$infantaddonprice += 0;
				}
			}
			$subtotal = $totlaprice + $adultaddonprice + $childaddonprice + $infantaddonprice;
			$discount =0;
			$coupon_id = '';
			$discount_type = '';
			$discount_amt = '';
			if($pessager['coupncode'] != ''){
				$today = date('Y-m-d');
				if(Coupon::where('coupon_code',@$pessager['coupncode'])->whereDate('start_date','<=', $today)->whereDate('end_date','>=', $today)->where('status',1)->where('type','holiday')->exists()){
					$couponvalue = Coupon::where('coupon_code',@$pessager['coupncode'])->whereDate('start_date','<=', $today)->whereDate('end_date','>=', $today)->where('status',1)->first();
					if($couponvalue->no_of_coupon >= $couponvalue->used_count){
						if($couponvalue->discount_type == 'percentage'){
							$discount_type = 'percentage';
							$coupon_id = $couponvalue->coupon_code;
							$discount_amt = $couponvalue->discount;
							
							$discount = ($subtotal * $couponvalue->discount/100);
						}else{
							$discount_type = 'fixed';
							$coupon_id = $couponvalue->coupon_code;
							$discount_amt = $couponvalue->discount;
							$discount = $couponvalue->discount;
						}
					}
				}
			}
			
			$finaltotal = $subtotal - $discount;
				
				$bookingdetail = new PackageBookingDetail;
				$bookingdetail->user_id = $user->id;
				$bookingdetail->email = $pessager['email'];
				$bookingdetail->mobile = $pessager['phone'];
				$bookingdetail->package_id = $id;
				$bookingdetail->package_date = date('Y-m-d', $pessager['package_date']);
				$bookingdetail->passengers = json_encode($pessager);
				$bookingdetail->addons = json_encode($addons); 
				$bookingdetail->status = 0;
				$bookingdetail->type = 'b2c';
				$saved = $bookingdetail->save();
				
				
				$payment = new PackagePaymentDetail;
				$payment->bookingid = $bookingdetail->id;
				$payment->coupon_id = $coupon_id;
				$payment->discount_type = $discount_type;
				$payment->discount_amount = $discount_amt;
				$payment->amount = $finaltotal;
				$payment->org_amount = $subtotal;
				
				$payment->service_fee = 0;
				//$payment->markupob = 0;
				//$payment->markupib = 0;
				$payment->status = 0;
				$payment->save();	
				Session::put('booking_id', $bookingdetail->id);
				Session::put('payment_id', $payment->id);
				Session::put('useridd', $user->id);
				 if($request->payment_method == 'razorpay'){
				 $email = $request->email;
				 $name = $pessager['passenger'][1]['adultfirstname'][0];
				 	return view('packagerazorpay',compact(['finaltotal', 'email','name']));
				}
		}
	}
	
	public function payWithRazorpay(Request $request){
	$input = Input::all();

	$rzkey = \App\MyConfig::where('meta_key','rz_paykey')->first()->meta_value;
	$rzsec = \App\MyConfig::where('meta_key','rz_paysecret')->first()->meta_value;
	$api = new Api('rzp_test_9BsnxNsU16jr90', 'BxykBD4klu8Zz5l15IcHSZwl');
        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
				
            } catch (\Exception $e) {
				
				$result = json_encode(array('success'=>false, 'message' => $e->getMessage()));
				$booking_id = Session::get('booking_id');
				$payment_id = Session::get('payment_id');
				$user_id = Session::get('useridd');
				$bookingdetail = PackageBookingDetail::find($booking_id);
				$bookingdetail->user_id = @$user_id;

				$saved = $bookingdetail->save();
				
				
				$payment = PackagePaymentDetail::find($payment_id);
				$payment->status = 2;
				$saved = $payment->save();
				$message = "Dear Admin, {name} has trying to book a  ticket from {source} to {destination} but Payment failed. Refrence Id is {bookingid}. For more bookings please visit {URL}. Thank you.";
				//$this->AdminPhoneBookingTicket($booking_id, $message);
				Session::forget('payment_id');
				Session::forget('useridd');
				return Redirect::to('/booking-failure');
               
            } 

       
			
			$booking_id = Session::get('booking_id');
			$payment_id = Session::get('payment_id');
			$user_id = Session::get('useridd');
			$bookingdetail = PackageBookingDetail::find($booking_id);
			$bookingdetail->status = 1;
			$saved = $bookingdetail->save();
			
			
			$payment = PackagePaymentDetail::find($payment_id);
			$payment->status = 1;
			$saved = $payment->save();
			
			
			$selecteddate =  explode('-', $bookingdetail->package_date);

			$seldate = $selecteddate[1].'/'.$selecteddate[2].'/'.$selecteddate[0];
			$allprice = \App\PackagePrice::where('package_id',$bookingdetail->package_id)->where('departure_date',$seldate)->first();
			//echo '<pre>'; print_r($allprice); die;
			if($allprice){
				$pessangerdetail = json_decode($bookingdetail->passengers);
				 $explode = explode('|', $pessangerdetail->p_id);
			$counttravler = 0;
			$countadult = 0;
			$countinfant = 0;
			$countcb = 0;
			$countcob = 0;
			$countcobb = 0;
			$adultprice = 0;
			$cwob = 0;
			$cwobb = 0;
			$cwb = 0;
			$infnt = 0;
			for($i =0; $i<count($explode); $i++){
				$rooms = explode('-', $explode[$i]);
				$countadult += $rooms[1];
				$countinfant += $rooms[2];
				$countcb += $rooms[3];
				$countcob += $rooms[4];
				$countcobb += $rooms[5];
				
				if($rooms[1] == 1){
					$price = $allprice->single;
				}else if($rooms[1] == 2){
					$price = $allprice->twin;
				}else{
					$price = $allprice->triple;
				}
				$adultprice += $price * $rooms[1];
			}
			$counttravler = $countadult + $countinfant + $countcb + $countcob +$countcobb; 
			
			 $selectedseats = $counttravler; 
			$no_of_seats = $allprice->no_of_seats;
			$no_of_seats = $no_of_seats - $counttravler;
			 $noofseats = $no_of_seats; 
			 $o = \App\PackagePrice::find($allprice->id);
			 $o->no_of_seats = $noofseats;
			 $o->save();
			}else{
				//return redirect()->back()->with('error', 'Package Not Found');
			}
			
			
			
			Session::forget('booking_id');
			Session::forget('payment_id');
				Session::forget('useridd');
			return Redirect::to('/package/ticket/'.base64_encode(convert_uuencode(@$bookingdetail->id)));
        }
        
        /* \Session::put('success', 'Payment successful, your order will be despatched in the next 48 hours.');
        return redirect()->back(); */
    }
	
	public function packageTicket(Request $request, $id = Null){
		if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	 
				if(PackageBookingDetail::where('id', '=', $id)->exists()) 
				{
					$fetchedData = PackageBookingDetail::where('id',$id)->with(['user'])->with(['paymentdetail','user','packagedetail'])->first();
					 return view('packageticket', compact(['fetchedData']));
				}
				else
				{
					//return Redirect::to('/admin/contact')->with('error', 'Contact Not Exist');
				}	
			}
			else
			{
				//return Redirect::to('/admin/contact')->with('error', Config::get('constants.unauthorized'));
			}
	}
	
	public function selecthotels(Request $request){
		$requestdata = $request->all();
		$hotel_id = $requestdata['hotel_id'];
		$inchotel_id = $requestdata['inchotel_id'];
		$hotel_id = Hotel::where('id',$hotel_id)->first();
		$inchotel_id = Hotel::where('id',$inchotel_id)->first();
		if($hotel_id){
			$hotelprice = $hotel_id->price - $inchotel_id->price;
			$mhotelprice = $hotel_id->price + $inchotel_id->price;
		}
		echo json_encode(array('success'=>true, 'hoteldetail' => $hotel_id, 'hotelprice'=>$hotelprice, 'oldhotelprice'=>$mhotelprice - $hotel_id->price));
	}
	public function hotels(Request $request){
		$requestdata = $request->all();
		$city = $requestdata['city'];
		$packageid = $requestdata['packageid'];
		$hotel_id = $requestdata['hotel_id'];
		$hotels = Hotel::where('destination', $city)->get();
		return view('packagehotel', compact(['hotels','packageid','hotel_id']));
		
		die;
	}
}
?>