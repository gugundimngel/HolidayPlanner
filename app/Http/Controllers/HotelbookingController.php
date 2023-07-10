<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
//use App\Destination;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Config;
use Cookie;
//use Session;
use App\HotelBookingDetail;
use App\HotelPaymentDetail;
use App\WebsiteSetting;
use App\MyConfig;
use App\Admin;
use Auth;
use Log;
use Mail;
use PDF;  
use App\Mail\HotelTicketMail;
use Session;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
class HotelbookingController extends Controller
{
	public function __construct(Request $request)
    {	
	date_default_timezone_set('Asia/Kolkata');
		/* $siteData = WebsiteSetting::where('id', '!=', '')->first();
		\View::share('siteData', $siteData); */
	}
	
	public function index(Request $request){
		 if($request->has('sid')){
			 $requestdata = $request->all();
			 $sid = $requestdata['sid'];
			 $hid = $requestdata['hid'];
			 $rm = $requestdata['rm'];
			 $hotelapi = \App\MyConfig::where('meta_key','hotel_api_key')->first()->meta_value;
			$hotel_endpoint = \App\MyConfig::where('meta_key','hotel_endpoint')->first()->meta_value;
			 $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $hotel_endpoint.'api/v3/hotels/availability/'.$sid.'?hcode='.$hid.'&bundled=true',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
			'api-key: '.$hotelapi,
			'Accept: application/json',
			'Content-Type: application/json'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$log = ['response' => $response];
		$hotellog = new Logger('hotelrefetchrequest');
		$hotellog->pushHandler(new StreamHandler(storage_path('logs/hotelrefetchrequest.log')), Logger::INFO);
		$hotellog->info('hotelrefetchrequest', $log);
		$detail =  json_decode($response);
		$mydetail =  json_decode($response);
		//echo '<pre>'; print_r($detail); die;
		if(isset($detail->errors)){
			$error= @$detail->errors[0]->messages[0];
			return view('hotel-error-search', compact('error'));
		}else{ 
			 if(isset($detail->hotel->rates[$rm])){
				 $rooms = $detail->hotel->rates[$rm];
			 if($rooms->rate_type == 'recheck'){
			  $rcurl = curl_init();
				$ratepost['rate_key'] = $rooms->rate_key;
				 $ratepost['group_code'] = $rooms->group_code;
		
				curl_setopt_array($rcurl, array(
			  CURLOPT_URL => $hotel_endpoint.'api/v3/hotels/availability/'.$sid.'/rates/?action=recheck',
			   CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>	json_encode($ratepost),
			  CURLOPT_HTTPHEADER => array(
				'api-key: '.$hotelapi,
				'Accept: application/json',
				'Content-Type: application/json'
			  ),
			));

			 $responserate = curl_exec($rcurl);

			curl_close($rcurl);
			
				$log = ['request' => $ratepost,'response' => $responserate];
				$hotellog = new Logger('hotelrecheckrequest');
				$hotellog->pushHandler(new StreamHandler(storage_path('logs/hotelrecheckrequest.log')), Logger::INFO);
				$hotellog->info('hotelrecheckrequest', $log);
					$detail =  json_decode($responserate);
					// echo '<pre>'; print_r($detail); die;
				 }
			}
				if(isset($detail->errors)){
					$error = $detail->errors[0]->messages[0];
			return view('hotel-error-search', compact('error'));
				}else{ 
					//\Cache::put('singlerefetch'.$sid.$hid.$rm, $detail , now()->addMinutes(25));			
					return view('hotel-booking', compact('detail','rm','mydetail')); 
				}
			}
		 }
	} 

	public function HotelPayment(Request $request){
		$hotelapi = \App\MyConfig::where('meta_key','hotel_api_key')->first()->meta_value;
		$hotel_endpoint = \App\MyConfig::where('meta_key','hotel_endpoint')->first()->meta_value;
		 $requestdata = $request->all();
		 //print_r($requestdata); die;
		 $searchid = $requestdata['searchid'];
		 $rm = $requestdata['room'];
		 $hotel_code = $requestdata['hotel_code'];
		 $city_code = $requestdata['city_code'];
		 $group_code = $requestdata['group_code'];
		 $checkin = $requestdata['checkin'];
		 $checkout = $requestdata['checkout'];
		 
		 
		 $adulttitle = $requestdata['adulttitle'];
		 $firstname = $requestdata['firstname'];
		 $lastname = $requestdata['lastname'];
		 
		  $childtitle = @$requestdata['childtitle'];
		 $childfirstname = @$requestdata['childfirstname'];
		 $childlastname = @$requestdata['childlastname'];
		 $pan = @$requestdata['pan'];
		 
		 $email = $requestdata['email'];
		 $mobile = $requestdata['mobile'];
		 
		 $room_code = $requestdata['room_code'];
		 $rate_key = $requestdata['rate_key'];
		 
		 
		 $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $hotel_endpoint.'api/v3/hotels/availability/'.$searchid.'?hcode='.$hotel_code.'&bundled=true',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
			'api-key: '.$hotelapi,
			'Accept: application/json',
			'Content-Type: application/json'
		  ),
		));

		$response = curl_exec($curl);
		
		curl_close($curl);
		$responserate = $response;
		$detail =  json_decode($response);
		// echo '<pre>'; print_r($detail); die;
		 if(isset($detail->hotel->rates[$rm])){
			 $rooms = $detail->hotel->rates[$rm];
			
			$isdomestic = @$detail->hotel->country;
			$hotel_code = @$detail->hotel->hotel_code;
			$city_code = @$detail->hotel->city_code;
				if($isdomestic == 'IN'){
					$type = 'domestic';
				}else{
					$type = 'international';
				}
				if(\App\HotelMarkup::where('markup_type', 'hotel_wise')->where('hotel_code', $hotel_code)->exists()){
				$hotelmarkup  = \App\HotelMarkup::where('markup_type', 'hotel_wise')->where('hotel_code', $hotel_code)->first();

			}
			else if(\App\HotelMarkup::where('markup_type', 'city_wise')->where('city_code', $city_code)->exists()){
				$hotelmarkup  = \App\HotelMarkup::where('markup_type', 'city_wise')->where('city_code', $city_code)->first();
				
			}else if(\App\HotelMarkup::where('markup_type', $type)->exists()){
				$hotelmarkup  = \App\HotelMarkup::where('markup_type', $type)->first();
			}
				$amount = 0;
				$mainamount = 0;
				$baseprice = 0;
				$tax = 0;
				if(isset($detail->hotel->rates[$rm])){
					$tax = number_format($detail->hotel->rates[$rm]->price_details->GST[2]->amount,2,'.','');
					$baseprice = $detail->hotel->rates[$rm]->price_details->net[2]->amount;
				}else{
					$tax = number_format($detail->hotel->rate->price_details->GST[2]->amount,2,'.','');
					$baseprice = $detail->hotel->rate->price_details->net[2]->amount;
				}
				
				$mainprice = $baseprice + $tax;
				if($hotelmarkup->amount_type == 'Percentage'){
					$mainamount = (@$mainprice * $hotelmarkup->markup_fee) / 100;
				}else{
					$mainamount = $hotelmarkup->markup_fee;
				}
				
				 $calculateamount = number_format($mainprice + $mainamount,2,'.',''); 
			
			 $rzkey = \App\MyConfig::where('meta_key','rz_paykey')->first()->meta_value;
				$rzsec = \App\MyConfig::where('meta_key','rz_paysecret')->first()->meta_value;
			$api = new Api($rzkey, $rzsec);
				 $orderData = [
					'amount'          => $calculateamount * 100, // 2000 rupees in paise
					'currency'        => 'INR',
					'payment_capture' => 1 // auto capture
				];
				
				 $amount = $orderData['amount'];
				 $bookingdetail = new HotelBookingDetail;
			$bookingdetail->email = $email;
			$bookingdetail->mobile = $mobile;
			$bookingdetail->booking_request = json_encode($requestdata);
			$bookingdetail->search_id = $searchid;
			$bookingdetail->rm = $rm;
			$bookingdetail->hotel_code = $hotel_code;
			$bookingdetail->city_code = $city_code;
			$bookingdetail->group_code = $group_code;
			$bookingdetail->checkin = $checkin;
			$bookingdetail->checkout = $checkout;
			$bookingdetail->room_code = $room_code;
			$bookingdetail->rate_key = $rate_key;
			$bookingdetail->recheck_response = $responserate;
		
			$saved = $bookingdetail->save();
			Session::put('zap_booking_id', $bookingdetail->id);
			
				$payment = new HotelPaymentDetail;
				$payment->bookingid = $bookingdetail->id;
				$payment->coupon_id = '';
				$payment->discount_type = '';
				$payment->discount_amount = 0;
				$payment->amount = $calculateamount;
				$payment->base_total = $baseprice;

				$payment->service_fee = $tax + $mainamount;
				$payment->status = 0;
				$payment->save();			
				Session::put('zap_payment_id', $payment->id);	 
				$razorpayOrder = $api->order->create($orderData);
				$razorpayOrderId = $razorpayOrder['id'];
				Session::put('hrazorpay_order_id', $razorpayOrderId);
				 $email = $email;
				 $phone = $mobile;
				 $name = $firstname[1][0];
				 $finaltotal = $calculateamount;
				 	return view('hotelrazorpay',compact(['finaltotal','email','name','phone','razorpayOrderId','amount']));
		 }
			
	}
	
	public function HotelPay(Request $request){
		$input = Input::all();
		$rzkey = \App\MyConfig::where('meta_key','rz_paykey')->first()->meta_value;
		$rzsec = \App\MyConfig::where('meta_key','rz_paysecret')->first()->meta_value;
		$api = new Api($rzkey, $rzsec);
		$success = false;
		try {
			$success = true;
			 $attributes = array(
            'razorpay_order_id' => Session::get('hrazorpay_order_id'),
            'razorpay_payment_id' => $input['razorpay_payment_id'],
            'razorpay_signature' => $input['razorpay_signature']
			);
			$api->utility->verifyPaymentSignature($attributes);
		}catch (SignatureVerificationError $e) {
			$success = false;
			$result = json_encode(array('success'=>false, 'message' => $e->getMessage()));
			$booking_id = Session::get('zap_booking_id');
			$payment_id = Session::get('zap_payment_id');
			$bookingdetail = HotelBookingDetail::find($booking_id);
			$bookingdetail->booking_response = $result;
			$saved = $bookingdetail->save();
			
			$payment = HotelPaymentDetail::find($payment_id);
			$payment->status = 2;
			$payment->save();
			//$message = "Dear Admin, {name} has trying to book a  hotrl but Payment failed. Refrence Id is {bookingid}. For more bookings please visit {URL}. Thank you.";
			//$this->AdminPhoneBookingTicket($booking_id, $message);
			Session::forget('zap_booking_id');
				Session::forget('zap_payment_id');
				return Redirect::to('/booking-failure');
		}
		if ($success === true)
		{
			$booking_id = Session::get('zap_booking_id');
			$payment_id = Session::get('zap_payment_id');
			$payment = HotelPaymentDetail::find($payment_id);
			$payment->status = 1;
			$payment->save();
			
			$websetting = WebsiteSetting::where('id', '!=', '')->first();
			if($websetting->disable_booking == 1){
				Session::forget('zap_payment_id');
				Session::forget('zap_booking_id');
				return Redirect::to('/booking-failure');
			}
			
			return view('hoteldonoclose');
		}
	}
	
	public function HotelBooking(Request $request){
		if( $requestdata = HotelBookingDetail::where('id', Session::get('zap_booking_id'))->exists()){
			 $requestdata = HotelBookingDetail::where('id', Session::get('zap_booking_id'))->first();
			 //print_r($requestdata); die;
			 $searchid = $requestdata->search_id;
			 $rm = $requestdata->rm;
			 $hotel_code = $requestdata->hotel_code;
			 $city_code = $requestdata->city_code;
			 $group_code = $requestdata->group_code;
			 $checkin = $requestdata->checkin;
			 $checkout = $requestdata->checkout;
			 $recheck_response = $requestdata->recheck_response;
			 
			$booking_request = json_decode($requestdata->booking_request, true);
	//	echo '<pre>'; print_r($booking_request['adulttitle']); die;
			 $adulttitle = $booking_request['adulttitle'];
			 $firstname = $booking_request['firstname'];
			 $lastname = $booking_request['lastname'];
			 	
			  $childtitle = @$booking_request['childtitle'];
			 $childfirstname = @$booking_request['childfirstname'];
			 $childlastname = @$booking_request['childlastname'];
			 
			 $email = $requestdata->email;
			 $mobile = $requestdata->mobile;
			 $pan = @$requestdata->pan;
			 
			 $room_code = $requestdata->room_code;
			 $rate_key = $requestdata->rate_key;
			 
			 $hotelreq['search_id'] = $searchid;
			 $hotelreq['hotel_code'] = $hotel_code;
			 $hotelreq['city_code'] = $city_code;
			 $hotelreq['booking_name'] = "booking_".time();
			 $hotelreq['group_code'] = $group_code;
			 $hotelreq['checkin'] = $checkin;
			 $hotelreq['checkout'] = $checkout;
			 $hotelreq['payment_type'] = "AT_WEB";
			 $hotelreq['agent_reference'] = "agent_".time();
			 $nationality = Session::get('nationality');
			
			 $hotelreq['holder']['title'] = $adulttitle[1][0];
			 $hotelreq['holder']['name'] = $firstname[1][0];
			 $hotelreq['holder']['surname'] = $lastname[1][0];
			 $hotelreq['holder']['email'] = $email;
			 $hotelreq['holder']['phone_number'] = $mobile;
			 $hotelreq['holder']['client_nationality'] = $nationality;
			 if(isset($requestdata->pan) && $requestdata->pan != ''){
				$hotelreq['holder']['pan_number'] = $requestdata->pan;
			 }
			 
			$detail =  json_decode($recheck_response);
			//echo '<pre>'; print_r($detail); die;
			if(isset($detail->hotel->rates[$rm])){
				$roomsde = $detail->hotel->rates[$rm];
				$room_code = $detail->hotel->rates[$rm]->room_code;
				$rate_key = $detail->hotel->rates[$rm]->rate_key;
			}else if(isset($detail->hotel->rate)){
				$roomsde = $detail->hotel->rate;
				$room_code = $detail->hotel->rate->room_code;
				$rate_key = $detail->hotel->rate->rate_key;
			}
			 
			 if(isset($detail->hotel->rates[$rm]) || isset($detail->hotel->rate)){
				 $rooms = $roomsde;
				$is = 1;
				$allrooms = array();
				foreach($rooms->rooms as $key => $room){
					$paxes = array();
					$rmss = array();
					for($ss=0; $ss<$room->no_of_adults; $ss++){
						$paxes[] = array(
							'title' => $adulttitle[$is][$ss],
							'name' => $firstname[$is][$ss],
							'surname' => $lastname[$is][$ss],
							'type' => 'AD'
						);
					}
					if($room->no_of_children !=0){ 
						for($s=0; $s <$room->no_of_children; $s++){
							$paxes[] = array(
							'title' => $childtitle[$is][$s],
							'name' => $childfirstname[$is][$s],
							'surname' => $childlastname[$is][$s],
							'type' => 'CH',
							'age' => $room->children_ages[$s],
							);
						}
					}
				  $allrooms[] = array(
						'paxes' => $paxes,
						'room_reference' =>$room->room_reference,
					);  
					
					/*  $rmss[] = array('paxes'=>$paxes,'room_reference' =>$room->room_reference);
					$allrooms[] = array(
					'room_code' => $room_code,
					'rate_key' => $rate_key,
					'rooms' => $rmss,
						
					);  */
					$is++;
				}
			//$hotelreq['booking_items'] = $allrooms;
		 $rooms = $allrooms;
			 $hotelreq['booking_items'][] = array(
				'room_code' => $detail->hotel->rates[$rm]->room_code,
				'rate_key' => $detail->hotel->rates[$rm]->rate_key,
				'rooms' => $rooms,
			 );  
			 
			 //echo '<pre>'; print_r($hotelreq);  die;
			   $hotelpost =  json_encode($hotelreq);
			 $hotelapi = \App\MyConfig::where('meta_key','hotel_api_key')->first()->meta_value;
			$hotel_endpoint = \App\MyConfig::where('meta_key','hotel_endpoint')->first()->meta_value;
			 $curls = curl_init();

			curl_setopt_array($curls, array(
			  CURLOPT_URL => $hotel_endpoint.'api/v3/hotels/bookings',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>	$hotelpost,
			  CURLOPT_HTTPHEADER => array(
				'api-key: '.$hotelapi,
				'Accept: application/json',
				'Content-Type: application/json'
			  ),
			));

			$hotellists = curl_exec($curls);

			curl_close($curls);
			$data =  json_decode($hotellists);
				//echo '<pre>'; print_r($data);
					
		$log = ['request' => $hotelpost,'response' => $hotellists];
		$hotellog = new Logger('hotelnewbooking');
		$hotellog->pushHandler(new StreamHandler(storage_path('logs/hotelnewbooking.log')), Logger::INFO);
		$hotellog->info('hotelnewbooking', $log);
				if(isset($data->status)){
					if($data->status == 'confirmed'){
						$booking_id = Session::get('zap_booking_id');
						
						$curlss = curl_init();

			curl_setopt_array($curlss, array(
			  CURLOPT_URL => $hotel_endpoint.'api/v3/hotels/bookings/'.$data->booking_reference.'?type=GRN',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			  CURLOPT_HTTPHEADER => array(
				'api-key: '.$hotelapi,
				'Accept: application/json',
				'Content-Type: application/json'
			  ),
			));

			$responsess = curl_exec($curlss);
$log = ['request' => $hotelpost,'response' => $responsess];
		$hotellog = new Logger('hotelrequest');
		$hotellog->pushHandler(new StreamHandler(storage_path('logs/hotelbooking.log')), Logger::INFO);
		$hotellog->info('hotelbooking', $log);
			curl_close($curlss);
		//	$detail =  json_decode($responsess);
						
						
						$bookingdetail = HotelBookingDetail::find($booking_id);
						$bookingdetail->booking_response = $responsess;
						$bookingdetail->booking_id = $data->booking_id;
						$bookingdetail->booking_reference = $data->booking_reference;
						$bookingdetail->booking_date = $data->booking_date;
						$bookingdetail->status = 1;
						$saved = $bookingdetail->save();
						
						$set = Admin::where('id',1)->first();
						$fetchedData = HotelBookingDetail::where('id',$booking_id)->first();	
						$pdf = PDF::setOptions([
						'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
						'logOutputFile' => storage_path('logs/log.htm'),
						'tempDir' => storage_path('logs/')
						])->loadView('emails.hotelvoucher', compact('fetchedData')); 
						$output = $pdf->output();
						$invoicefilename = $set->ref_prefix.$fetchedData->id.'-Ticket'.'.pdf';
						file_put_contents('/home1/zapbolib/public_html/public/invoices/'.$invoicefilename, $output);
						$array['file'] = '/home1/zapbolib/public_html/public/invoices/'.$invoicefilename;
						$array['file_name'] = $invoicefilename;
						
						 Mail::to($email)->send(new HotelTicketMail($fetchedData, 'Hotel Voucher '.$set->ref_prefix.$fetchedData->id, $set->primary_email, $array));
						unlink($array['file']);
						
						return Redirect::to('/Hotel/booking/success/'.base64_encode(convert_uuencode(@$bookingdetail->id)));
					}else{
						$booking_id = Session::get('zap_booking_id');
						
						$bookingdetail = HotelBookingDetail::find($booking_id);
						$bookingdetail->booking_response = $hotellists;
						$bookingdetail->status = 2;
						$saved = $bookingdetail->save();
						return Redirect::to('/booking-failure');
					}
				}else{
					$booking_id = Session::get('zap_booking_id');
						
						$bookingdetail = HotelBookingDetail::find($booking_id);
						$bookingdetail->booking_response = $hotellists;
						$bookingdetail->status = 2;
						$saved = $bookingdetail->save();
						return Redirect::to('/booking-failure');
				}
			 }else{
				 $booking_id = Session::get('zap_booking_id');
						
						$bookingdetail = HotelBookingDetail::find($booking_id);
						$bookingdetail->booking_response = $detail;
						$bookingdetail->status = 2;
						$saved = $bookingdetail->save();
						return Redirect::to('/booking-failure');
			 }
		}
	}
	
	public function HotelBookingSuccess(Request $request, $id = Null){
		$hotelapi = \App\MyConfig::where('meta_key','hotel_api_key')->first()->meta_value;
		$hotel_endpoint = \App\MyConfig::where('meta_key','hotel_endpoint')->first()->meta_value;
		if(isset($id) && !empty($id)){
			$id = $this->decodeString($id);	 
				if(HotelBookingDetail::where('id', '=', $id)->exists()) 
				{
					$fetchedData = HotelBookingDetail::where('id',$id)->first();
					$curlss = curl_init();

			curl_setopt_array($curlss, array(
			  CURLOPT_URL => $hotel_endpoint.'api/v3/hotels/bookings/'.$fetchedData->booking_reference.'?type=GRN',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			  CURLOPT_HTTPHEADER => array(
				'api-key: '.$hotelapi,
				'Accept: application/json',
				'Content-Type: application/json'
			  ),
			));

			$responsess = curl_exec($curlss);

			curl_close($curlss);
			$detail =  json_decode($responsess);
			//echo '<pre>'; print_r($detail); echo '<pre>'; die;
					 return view('hotel_booking_confirmation', compact(['fetchedData','detail']));
				}
				else
				{
					//return Redirect::to('/admin/contact')->with('error', 'Contact Not Exist');
				}
		}
		
	}
	 
	public function hotelvoucher(Request $request, $id = Null){
		if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	 
				if(HotelBookingDetail::where('id', '=', $id)->exists()) 
				{
					$fetchedData = HotelBookingDetail::where('id', '=', $id)->with(['paymentdetail'])->first();
					//return view('emails.hotelvoucher', compact(['fetchedData']));
					 $pdf = PDF::setOptions([
					'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
					'logOutputFile' => storage_path('logs/log.htm'),
					'tempDir' => storage_path('logs/')
					])->loadView('emails.hotelvoucher', compact('fetchedData')); 
					
					$set = Admin::where('id',1)->first();
					return $pdf->download($set->ref_prefix.$fetchedData->id.'-Ticket'.'.pdf');
				}
				else
				{
					return Redirect::to('/admin/bookings?btype=hotel&type=b2c')->with('error', 'Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/bookings?btype=hotel&type=b2c')->with('error', Config::get('constants.unauthorized'));
			}
	}
	
	public function ticketmail(Request $request){
		$set = Admin::where('id',1)->first();
		$requestdata = $request->all();
		$email = $requestdata['mnailiduser'];
		$valuesubj = $requestdata['valuesubj'];
		$printid = $requestdata['printid'];
		//$printContents = $requestdata['printContents'];
		$printid = $this->decodeString($printid);	
		$fetchedData = HotelBookingDetail::where('id',$printid)->with(['paymentdetail'])->first();
		 $pdf = PDF::setOptions([
					'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
					'logOutputFile' => storage_path('logs/log.htm'),
					'tempDir' => storage_path('logs/')
					])->loadView('emails.hotelvoucher', compact('fetchedData')); 
		$output = $pdf->output();
		$invoicefilename = $set->ref_prefix.$fetchedData->id.'-Ticket'.'.pdf';
		file_put_contents('/home1/zapbolib/public_html/public/invoices/'.$invoicefilename, $output);
		$array['file'] = '/home1/zapbolib/public_html/public/invoices/'.$invoicefilename;
		$array['file_name'] = $invoicefilename;
		
		 Mail::to($email)->send(new HotelTicketMail($fetchedData, $valuesubj, $set->primary_email, $array));
		unlink($array['file']);
		//Mail::to($email)->send(new CommonMail($printContents, $valuesubj, $set->primary_email));
		if (Mail::failures()) {
			echo 'There is a problem in system. please try again later';
		}else{
			echo 'Email sent successfully';
			
		}
		die;
	}
}
?>