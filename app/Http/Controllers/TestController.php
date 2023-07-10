<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use App\TestSeriesTransactionHistory;
use App\PurchasedSubject;
use App\Test;
use App\ScheduledTest;
use App\WebsiteSetting;
use Illuminate\Support\Facades\Input;
use Auth;
use Config;
use Cookie;
use Session;
class TestController extends Controller
{
	public function __construct()
    {
		$siteData = WebsiteSetting::where('id', '!=', '')->first();
		\View::share('siteData', $siteData);	
      //  $this->middleware('auth:web');
	}
	
	public function testpay(Request $request){
		$api = new Api('rzp_test_9BsnxNsU16jr90', 'BxykBD4klu8Zz5l15IcHSZwl');
		$finaltotal = 2000;
		$orderData = [
			'amount'          => $finaltotal * 100, // 2000 rupees in paise
			'currency'        => 'INR',
			'payment_capture' => 1 // auto capture
		];
		$razorpayOrder = $api->order->create($orderData);
		$razorpayOrderId = $razorpayOrder['id'];
		Session::put('razorpay_order_id', $razorpayOrderId);
		$email = 'pp@gmail.com';
		$contact = '9999999999';
		return view('testrazorpay',compact(['finaltotal','email','contact','razorpayOrderId']));
	}
	
	public function testuserpaywithrazorpay(Request $request){
		$input = Input::all();
	
		$api = new Api('rzp_test_9BsnxNsU16jr90', 'BxykBD4klu8Zz5l15IcHSZwl');
	
		$success = false;
		try
    {
			$success = true;
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => Session::get('razorpay_order_id'),
            'razorpay_payment_id' => $input['razorpay_payment_id'],
            'razorpay_signature' => $input['razorpay_signature']
        );
		
		$api->utility->verifyPaymentSignature($attributes);
			

			
		}
		catch(SignatureVerificationError $e)
		{
			$success = false;
			$error = 'Razorpay Error : ' . $e->getMessage();
		}
		
		if ($success === true)
		{
			$html = "<p>Your payment was successful</p>
					 <p>Payment ID: {$input['razorpay_payment_id']}</p>";
		}
		else
		{
			$html = "<p>Your payment failed</p>
					 <p>{$error}</p>";
		}
		echo $html;

	}
	public function index(Request $request)
	{
		$BookingDetail = \App\BookingDetail::where('id', 460)->first();
		$pessager = (array) json_decode($BookingDetail->bookingib_request);
		$resultdata =  json_decode($BookingDetail->farequoteob_log);
		$farequoteib_log =  json_decode($BookingDetail->farequoteib_log);
		$farebrakdowna = $resultdata->Response->Results->FareBreakdown;
		  $result_data = '{
			"ResultIndex": "'.$pessager['hfRIndex'].'",
			"Passengers": [';
						for($ic=0;$ic<count($farebrakdowna);$ic++){
				for($ics=0;$ics < $farebrakdowna[$ic]->PassengerCount; $ics++){

				if($farebrakdowna[$ic]->PassengerType == 1){
					if($farebrakdowna[$ic]->BaseFare == 0){
						$fareprice = 0;
					}else{
						$fareprice = $farebrakdowna[$ic]->BaseFare / $farebrakdowna[$ic]->PassengerCount;
					}
					if($farebrakdowna[$ic]->Tax == 0){
						$faretax = 0;
					}else{
						$faretax = $farebrakdowna[$ic]->Tax / $farebrakdowna[$ic]->PassengerCount;
					}
					
					if($farebrakdowna[$ic]->YQTax == 0){
						$yqtax = 0;
					}else{
						$yqtax = $farebrakdowna[$ic]->YQTax;
					}
					if($pessager['adulttitle'][$ics] == 'Mr'){
						$gender = 1;
					}else{
						$gender = 2;
					}
					$adultpassportno = '';
					$adultpassportdate = '';
					if($pessager['IsIntr'] == 1 || $pessager['IsIntr'] == 'true'){
						$adultpassportno = $pessager['adultpassportno'][$ics];
						 $dte1explode = explode('/', $pessager['adultpassportdate'][$ics]);
						 $adultpassportdate = $dte1explode[2].'-'.$dte1explode[1].'-'.$dte1explode[0].'T00:00:00';
						 
					}
					
					if($ics == 0){
						$IsLeadPax = 'true';
					}else{
						$IsLeadPax = 'false';
					}
				//	echo '1'.$farebrakdowna[$ic]->PassengerCount.'<br>';
	 $result_data .=	'{
			  "Title": "'.$pessager['adulttitle'][$ics].'",
			  "FirstName": "'.$pessager['adultfirstname'][$ics].'",
			  "LastName": "'.$pessager['adultlastname'][$ics].'",
			  "PaxType": '.$farebrakdowna[$ic]->PassengerType.',
			  "DateOfBirth": "1987-12-06T00:00:00",
			  "Gender": '.$gender.',';
			  if($pessager['IsIntr'] == 1 || $pessager['IsIntr'] == 'true'){
					$result_data .=	'"PassportNo": "'.$adultpassportno.'",';
					$result_data .=	'"PassportExpiry": "'.$adultpassportdate.'",';
			  }
			   
		$result_data .=	  '"AddressLine1": "123 test",
			  "AddressLine2": "",
				"City": "Gurgaon",
				"CountryCode": "IN",
				"CountryName": "India",
				"Nationality": "IN",
				"ContactNo": "'.$pessager['phone'].'",
				"Email": "'.$pessager['email'].'",
				"IsLeadPax": '.$IsLeadPax.',
				"FFAirline": "",
				"FFNumber": "",';
				if($resultdata->Response->Results->IsGSTMandatory == true && $ics == 0){
					 $result_data .='"GSTCompanyAddress": "F111/112 North Square Mall, Delhi",
					"GSTCompanyContactNumber": "1147262626",
					"GSTCompanyName": "Holiday Planner PRIVATE LIMITED",
					"GSTNumber": "07AAACZ3593Q1ZI",
					"GSTCompanyEmail": "booking@holidaychacha.com"';
				}
			   $result_data .=	'"Fare": {
				"Currency": "INR",
				"BaseFare": '.number_format($fareprice, 2, '.', '').',
				"Tax": '.number_format($faretax, 2, '.', '').',
				"YQTax": '.number_format($yqtax, 2, '.', '').',
				"AdditionalTxnFeeOfrd": 0.0,
				"AdditionalTxnFeePub": 0.0,
				"PGCharge": 0.0';
				 $result_data .= '			
			 
		}'; 
		
		$result = $farequoteib_log;
			\Cache::put('ssrob'.$pessager['hfTraceId'].$pessager['hfRIndex'], $result , 10);
					if (\Cache::has('ssrob'.$pessager['hfTraceId'].$pessager['hfRIndex'])){
						
						
						//print_r($dep_baggage);
							$ssrresult = \Cache::get( 'ssrob'.$pessager['hfTraceId'].$pessager['hfRIndex']);
							
							$ssrresultdata = $ssrresult;
							$adultbaggage = preg_filter('/^adultbaggage_'.$ics.'(.*)/', '$1', array_keys( $pessager ));
					if(!empty($adultbaggage)){
					$resultbag_data = ',"Baggage":[';
					foreach($adultbaggage as $val){
					if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->Baggage !== null){
					if(isset($pessager['adultbaggage_'.$ics.$val])){
						$dep_baggage = explode('_', $pessager['adultbaggage_'.$ics.$val]);
						if($dep_baggage[1] != 'NONE'){
							foreach(@$ssrresultdata->Response->Baggage as $key => $bsslist){
								foreach(@$bsslist as $b_list){
									if($b_list->Code == $dep_baggage[1]){
										$resultbag_data .= '{
											"AirlineCode": "'.$b_list->AirlineCode.'",
											"FlightNumber": "'.$b_list->FlightNumber.'",
											"WayType": '.$b_list->WayType.',
											"Code": "'.$dep_baggage[1].'",
											"Description": '.$b_list->Description.',
											"Weight": '.$b_list->Weight.',
											"Currency": "'.$b_list->Currency.'",
											"Price": '.$b_list->Price.',
											"Origin": "'.$b_list->Origin.'",
											"Destination": "'.$b_list->Destination.'"	
										},';
									}
								}
							}
						}
					}
					}
					}
				$result_data .= rtrim($resultbag_data,',');
			$result_data .= ']';
		}
							$adulmeal = preg_filter('/^adultmeal_'.$ics.'(.*)/', '$1', array_keys( $pessager ));
	if(!empty($adulmeal)){
						$resultmeal_data = ',"MealDynamic":[';
						foreach($adulmeal as $val){
							
						if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->MealDynamic !== null){
						if(isset($pessager['adultmeal_'.$ics.$val])){
							$dep_meal = explode('@', $pessager['adultmeal_'.$ics.$val]);
							$dep_mealx = explode('-', $pessager['adultmeal_'.$ics.$val]);
							if($dep_meal[0] != 'NONE'){
								foreach(@$ssrresultdata->Response->MealDynamic as $key => $meallist){
									foreach(@$meallist as $m_list){
										
										if($m_list->Code == $dep_meal[0] && $m_list->Origin == $dep_mealx[1] && $m_list->Destination == $dep_mealx[2]){
											
											$resultmeal_data .= '{
													"AirlineCode": "'.$m_list->AirlineCode.'",
													"FlightNumber": "'.$m_list->FlightNumber.'",
													"WayType": '.$m_list->WayType.',
													"Code": "'.$dep_meal[0].'",
													"Description": '.$m_list->Description.',
													"AirlineDescription": "'.$m_list->AirlineDescription.'",
													"Quantity": 1,
													"Currency": "'.$m_list->Currency.'",
													"Price": '.$m_list->Price.',
													"Origin": "'.$m_list->Origin.'",
													"Destination": "'.$m_list->Destination.'"	
												},';
										}
									}
								}
							}
						}
						}
						}
					$result_data .= rtrim($resultmeal_data,',');
				$result_data .= ']';
			}
							
							
							  $adulPaxSeat = preg_filter('/^adult_'.$ics.'_PaxSeat_(.*)/', '$1', array_keys( $pessager ));
							//  print_r($adulPaxSeat);
							 if(!empty($adulPaxSeat)){ 
							 $resultseat_data = ',"SeatDynamic":[';
								foreach($adulPaxSeat as $val){
									if(isset($pessager['adult_'.$ics.'_PaxSeat_'.$val])){
										
										
											 if($pessager['adult_'.$ics.'_PaxSeat_'.$val] != 'none'){
												 
												 $exploadseats = explode('_', $pessager['adult_'.$ics.'_PaxSeat_'.$val]);
												 $seat = @$exploadseats[1];
												 $seatsegment = @$exploadseats[3];
												 $rowseat = @$exploadseats[5];
												 $seatn = @$exploadseats[7];
												 if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->SeatDynamic !== null){
													
													 if(isset($ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn])){
														
															$resultseat_data .= '{
							"AirlineCode": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->AirlineCode.'",
							 "FlightNumber": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->FlightNumber.'",
							  "CraftType": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->CraftType.'",
							   "Origin": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Origin.'",
								"Destination": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Destination.'",
								"AvailablityType": '.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->AvailablityType.',
								"Description": '.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Description.',
								"Code": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Code.'",
								"RowNo": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->RowNo.'",
								"SeatNo": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->SeatNo.'",
								"SeatType": '.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->SeatType.',
								"SeatWayType": '.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->SeatWayType.',
								"Compartment": '.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Compartment.',
								"Deck": '.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Deck.',
								"Currency": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Currency.'",
								"Price":'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Price.'                                            },';
													 }
												 }
											}
									}
								}
								$result_data .= rtrim($resultseat_data,',');
								$result_data .= ']';
							}
							
						}
					
				
			 $result_data .= '			
			 
		},'; 
					}else if($farebrakdowna[$ic]->PassengerType == 2){ 
					if($farebrakdowna[$ic]->BaseFare == 0){
						$fareprice = 0;
					}else{
						$fareprice = $farebrakdowna[$ic]->BaseFare / $farebrakdowna[$ic]->PassengerCount;
					}
					if($farebrakdowna[$ic]->Tax == 0){
						$faretax = 0;
					}else{
						$faretax = $farebrakdowna[$ic]->Tax / $farebrakdowna[$ic]->PassengerCount;
					}
					
					if($farebrakdowna[$ic]->YQTax == 0){
						$yqtax = 0;
					}else{
						$yqtax = $farebrakdowna[$ic]->YQTax;
					}
					//echo '2'.$farebrakdowna[$ic]->PassengerCount.'<br>';
					if($pessager['childtitle'][$ics] == 'Master'){
						$gender = 1;
					}else{
						$gender = 2;
					}
					$childpassportno = '';
					$childpassportdate = '';
					if($pessager['IsIntr'] == 1 || $pessager['IsIntr'] == 'true'){
						$childpassportno = $pessager['childpassportno'][$ics];
						$dte1explode = explode('/', $pessager['childpassportdate'][$ics]);
						 $childpassportdate = $dte1explode[2].'-'.$dte1explode[1].'-'.$dte1explode[0].'T00:00:00';
						
					}
					
					$chexp = explode('/',$pessager['childdob'][$ics]);
					
				$dataachild = $chexp[2].'-'.$chexp[1].'-'.$chexp[0].'T00:00:00';
					
				 	$result_data .='
		{
			  "Title": "'.$pessager['childtitle'][$ics].'",
			  "FirstName": "'.$pessager['childfirstname'][$ics].'",
			  "LastName": "'.$pessager['childlastname'][$ics].'",
			  "PaxType": '.$farebrakdowna[$ic]->PassengerType.',
			"DateOfBirth": "'.$dataachild.'",
			  "Gender": '.$gender.',';
			  
			 if($pessager['IsIntr'] == 1 || $pessager['IsIntr'] == 'true'){
					$result_data .=	'"PassportNo": "'.$childpassportno.'",';
					$result_data .=	'"PassportExpiry": "'.$childpassportdate.'",';
			  }
			   
			  $result_data .=	'"AddressLine1": "123 test",
			  "AddressLine2": "",
			   "City": "Gurgaon",
				"CountryCode": "IN",
				"CountryName": "India",
				"Nationality": "IN",
				"ContactNo": "'.$pessager['phone'].'",
				"Email": "'.$pessager['email'].'",
				"IsLeadPax": false,
				"FFAirline": "",
				"FFNumber": "",
			   "Fare": {
				"Currency": "INR",
				"BaseFare": '.$fareprice.',
				"Tax": '.$faretax.',
				"YQTax": '.$yqtax.',
				"AdditionalTxnFeeOfrd": 0,
				"AdditionalTxnFeePub": 0,
				"PGCharge": 0';
			 $result_data .= '}';		  
			 if (\Cache::has('ssrob'.$pessager['hfTraceId'].$pessager['hfRIndex'])){
						
						
						//print_r($dep_baggage);
							$ssrresult = \Cache::get( 'ssrob'.$pessager['hfTraceId'].$pessager['hfRIndex']);
							
							$ssrresultdata = json_decode($ssrresult);
							$childbaggage = preg_filter('/^childbaggage_'.$ics.'(.*)/', '$1', array_keys( $pessager ));
					if(!empty($childbaggage)){
					$resultbag_data = ',"Baggage":[';
					foreach($childbaggage as $val){
					if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->Baggage !== null){
					if(isset($pessager['childbaggage_'.$ics.$val])){
						$dep_baggage = explode('_', $pessager['childbaggage_'.$ics.$val]);
						if($dep_baggage[1] != 'NONE'){
							foreach(@$ssrresultdata->Response->Baggage as $key => $bsslist){
								foreach(@$bsslist as $b_list){
									if($b_list->Code == $dep_baggage[1]){
										$resultbag_data .= '{
											"AirlineCode": "'.$b_list->AirlineCode.'",
											"FlightNumber": "'.$b_list->FlightNumber.'",
											"WayType": '.$b_list->WayType.',
											"Code": "'.$dep_baggage[1].'",
											"Description": '.$b_list->Description.',
											"Weight": '.$b_list->Weight.',
											"Currency": "'.$b_list->Currency.'",
											"Price": '.$b_list->Price.',
											"Origin": "'.$b_list->Origin.'",
											"Destination": "'.$b_list->Destination.'"	
										},';
									}
								}
							}
						}
					}
					}
					}
				$result_data .= rtrim($resultbag_data,',');
			$result_data .= ']';
		}
							
							 $childmeal = preg_filter('/^childmeal_'.$ics.'(.*)/', '$1', array_keys( $pessager ));
							if(!empty($childmeal)){
								$resultmeal_data = ',"MealDynamic":[';
								foreach($childmeal as $val){
									if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->MealDynamic !== null){
										if(isset($pessager['childmeal_'.$ics.$val])){
											$dep_meal = explode('@', $pessager['childmeal_'.$ics.$val]);
											$dep_mealx = explode('-', $pessager['childmeal_'.$ics.$val]);
											if($dep_meal[0] != 'NONE'){
												foreach(@$ssrresultdata->Response->MealDynamic as $key => $meallist){
													foreach(@$meallist as $m_list){
														if($m_list->Code == $dep_meal[0] && $m_list->Origin == $dep_mealx[1] && $m_list->Destination == $dep_mealx[2]){
															$resultmeal_data .= '{
																	"AirlineCode": "'.$m_list->AirlineCode.'",
																	"FlightNumber": "'.$m_list->FlightNumber.'",
																	"WayType": '.$m_list->WayType.',
																	"Code": "'.$dep_meal[0].'",
																	"Description": '.$m_list->Description.',
																	"AirlineDescription": "'.$m_list->AirlineDescription.'",
																	"Quantity": 1,
																	"Currency": "'.$m_list->Currency.'",
																	"Price": '.$m_list->Price.',
																	"Origin": "'.$m_list->Origin.'",
																	"Destination": "'.$m_list->Destination.'"	
																},';
														}
													}
												}
											}
										}
									}
								}
								$result_data .= rtrim($resultmeal_data,',');
								$result_data .= ']';
							}
							
							 $childPaxSeat = preg_filter('/^child_'.$ics.'_PaxSeat_(.*)/', '$1', array_keys( $pessager ));
							 if(!empty($childPaxSeat)){ 
							 $resultseat_data = ',"SeatDynamic":[';
								foreach($childPaxSeat as $val){
									if(isset($pessager['child_'.$ics.'_PaxSeat_'.$val])){
										
											 if($pessager['child_'.$ics.'_PaxSeat_'.$val] != 'none'){
												 $exploadseats = explode('_', $pessager['child_'.$ics.'_PaxSeat_'.$val]);
												 $seat = @$exploadseats[1];
												 $seatsegment = @$exploadseats[3];
												 $rowseat = @$exploadseats[5];
												 $seatn = @$exploadseats[7];
												 if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->SeatDynamic !== null){
													 if(isset($ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn])){
															$resultseat_data .= '{
							"AirlineCode": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->AirlineCode.'",
							 "FlightNumber": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->FlightNumber.'",
							  "CraftType": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->CraftType.'",
							   "Origin": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Origin.'",
								"Destination": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Destination.'",
								"AvailablityType": '.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->AvailablityType.',
								"Description": '.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Description.',
								"Code": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Code.'",
								"RowNo": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->RowNo.'",
								"SeatNo": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->SeatNo.'",
								"SeatType": '.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->SeatType.',
								"SeatWayType": '.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->SeatWayType.',
								"Compartment": '.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Compartment.',
								"Deck": '.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Deck.',
								"Currency": "'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Currency.'",
								"Price":'.$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Price.'                                            },';
													 }
												 }
											}
									}
								}
								$result_data .= rtrim($resultseat_data,',');
								$result_data .= ']';
							}
							
						}
		 $result_data .= '},'; 
					}else{ 
					if($farebrakdowna[$ic]->BaseFare == 0){
						$fareprice = 0;
					}else{
						$fareprice = $farebrakdowna[$ic]->BaseFare / $farebrakdowna[$ic]->PassengerCount;
					}
					if($farebrakdowna[$ic]->Tax == 0){
						$faretax = 0;
					}else{
						$faretax = $farebrakdowna[$ic]->Tax / $farebrakdowna[$ic]->PassengerCount;
					}
					
					if($farebrakdowna[$ic]->YQTax == 0){
						$yqtax = 0;
					}else{
						$yqtax = $farebrakdowna[$ic]->YQTax;
					}
					if($pessager['infanttitle'][$ics] == 'Master'){
						$gender = 1;
					}else{
						$gender = 2;
					}
					$infantpassportno = '';
					$infantpassportdate = '';
					if($pessager['IsIntr'] == 1 || $pessager['IsIntr'] == 'true'){
						$infantpassportno = $pessager['infantpassportno'][$ics];
						$dte1explode = explode('/', $pessager['infantpassportdate'][$ics]);
						 $infantpassportdate = $dte1explode[2].'-'.$dte1explode[1].'-'.$dte1explode[0].'T00:00:00';
					}
				//$datada = date('Y-m-d', strtotime($pessager['infantdob'][$ics])).'T00:00:00';
$inexp = explode('/',$pessager['infantdob'][$ics]);
					
				$dataainfant = $inexp[2].'-'.$inexp[1].'-'.$inexp[0].'T00:00:00';				
					//echo '3'.$farebrakdowna[$ic]->PassengerCount.'<br>';
					$result_data .='
		{
			  "Title": "'.$pessager['infanttitle'][$ics].'",
			  "FirstName": "'.$pessager['infantfirstname'][$ics].'",
			  "LastName": "'.$pessager['infantlastname'][$ics].'",
			  "PaxType": '.$farebrakdowna[$ic]->PassengerType.',
			  "DateOfBirth": "'.$dataainfant.'",';
			  
			if($pessager['IsIntr'] == 1 || $pessager['IsIntr'] == 'true'){
					$result_data .=	'"PassportNo": "'.$infantpassportno.'",';
					$result_data .=	'"PassportExpiry": "'.$infantpassportdate.'",';
			  }
			 $result_data .=	'"Gender": '.$gender.',
			"AddressLine1": "123 test",
			"AddressLine2": "",
			"City": "Gurgaon",
			"CountryCode": "IN",
			"CountryName": "India",
			"ContactNo": "'.$pessager['phone'].'",
			"Email": "'.$pessager['email'].'",
			"IsLeadPax": false,
			"FFAirline": "",
			"FFNumber": "",
			"Nationality": "IN",
			   "Fare": {
					"Currency": "INR",
					"BaseFare": '.number_format($fareprice, 2, '.', '').',
					"Tax": '.number_format($faretax, 2, '.', '').',
					"YQTax": '.number_format($yqtax, 2, '.', '').',
					"AdditionalTxnFeeOfrd": 0.0,
					"AdditionalTxnFeePub": 0.0,
					"PGCharge": 0.0
				} 
			  },';			 
		
					}
		
			}
			
	} 
	
	$result_data .=	'],';
			if($resultdata->Response->Results->IsLCC ==1){
				$result_data .= '"PreferredCurrency": null,';
			}
		$result_data .='"EndUserIp": "103.118.16.198",
			"TokenId": "",
			"TraceId": "'.$pessager['hfTraceId'].'"
			}'; 
	echo $result_data; die;			
	}
	
	public function viewTest(Request $request, $id)
	{
		if(isset($id) && !empty($id))
        {
			$id = $this->decodeString($id);

            if(Test::where('id', '=', $id)->where('status', '=', 1)->exists()) 
            {
				//Test Data start	
					$query      =   Test::where('id', '=', $id);
					
					$fetchedDataTest   =   $query->with(['subject'=>function($subQuery){
						$subQuery->select('id', 'which_course', 'which_test_series_type', 'which_group', 'subject_name');
						$subQuery->with(['course' => function($subSubQuery){
								$subSubQuery->select('id', 'course_name');
							}, 'test_series_type' => function($subSubQuery){
								$subSubQuery->select('id', 'test_series_type');
							}, 'group' => function($subSubQuery){
								$subSubQuery->select('id', 'group_name');
							}]);	
					}])->first();
				//Test Data End

				//Schedule Test Start
					$scheduleData = ScheduledTest::where('student_id', '=', Auth::user()->id)->where('test_id', '=', $id)->first();
				//Schedule Test End		
					
                return view('Frontend.tests.view_test', compact(['fetchedDataTest', 'scheduleData']));
            }
            else
            {
                return Redirect::to('/test')->with('error', 'Test does not exist.');
            }
        }
        else
        {
            return Redirect::to('/test')->with('error', Config::get('constants.unauthorized'));
        }
	}
	
	public function scheduleTestRequest(Request $request)
	{
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'test_id' => 'required',
										'scheduled_date' => 'required|date'
									  ]);
	
			$student_id = Auth::user()->id;
	
			$requestData 		= 	$request->all();
			
			$queryTestData =  Test::where('id', '=', @$requestData['test_id']);	
			$fetchedDataTest   =   $queryTestData->with(['subject'=>function($subQuery){
				$subQuery->select('id', 'which_course', 'which_test_series_type', 'which_group', 'subject_name');
				$subQuery->with(['course' => function($subSubQuery){
						$subSubQuery->select('id', 'course_name');
					}, 'test_series_type' => function($subSubQuery){
						$subSubQuery->select('id', 'test_series_type');
					}, 'group' => function($subSubQuery){
						$subSubQuery->select('id', 'group_name');
					}]);	
			}])->first();
			
			if(@$fetchedDataTest)
			{
				$getPurchasedSubjects = PurchasedSubject::where('student_id', '=', $student_id)->where('subject_id', '=', @$fetchedDataTest->which_subject)->where('status', '=', 1)->count();
				
				if($getPurchasedSubjects > 0)
				{
					$obj						= 	new ScheduledTest;
					$obj->student_id			=	@$student_id;
					$obj->test_id				=	@$requestData['test_id'];
					$obj->scheduled_date		=	@$requestData['scheduled_date'];
					$obj->test_data				=	json_encode(array(@$fetchedDataTest));
					
					$saved				=	$obj->save();
					
					if(!$saved)
					{
						return redirect()->back()->with('error', Config::get('constants.server_error'));
					}
					else
					{
						return Redirect::to('/view_test/'.base64_encode(convert_uuencode(@$requestData['test_id'])))->with('success', 'Your test has been schedule successfully, so please wait till given date.');
					}
				}
				else
				{
					return Redirect::to('/test')->with('error', 'You have not purchased subject for this Test, so you can not schedule your Test.');
				}		
			}
			else
			{
				return Redirect::to('/test')->with('error', 'Test does not exist.');
			}		
		}
	}
	
	public function uploadAnswer(Request $request)
	{
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'id' => 'required',
										'test_submitted_copy' => 'required'
									  ]);
	
			$student_id = Auth::user()->id;
	
			$requestData 		= 	$request->all();
			
			if(ScheduledTest::where('id', '=', @$requestData['id'])->where('student_id', '=', $student_id)->exists()) 
            {
				$scheduleData = ScheduledTest::select('id', 'test_id')->where('id', '=', @$requestData['id'])->where('student_id', '=', $student_id)->first();
				
				/* Test PDF Upload Function Start */						  
					if($request->hasfile('test_submitted_copy')) 
					{
						$test_submitted_copy = $this->uploadFile($request->file('test_submitted_copy'), Config::get('constants.test_submitted_copies'));
					}
					else
					{
						$test_submitted_copy = NULL;
					}		
				/* Test PDF Upload Function End */
				
					$obj							= 	ScheduledTest::find(@$requestData['id']);
					$obj->test_submitted			=	1;
					$obj->test_submitted_copy		=	@$test_submitted_copy;
					$obj->submit_date				=	date('Y-m-d H:i:s');
					
					$saved				=	$obj->save();
					
					if(!$saved)
					{
						return redirect()->back()->with('error', Config::get('constants.server_error'));
					}
					else
					{
						return Redirect::to('/view_test/'.base64_encode(convert_uuencode(@$scheduleData->test_id)))->with('success', 'Your test has been submitted successfully. Our Experts will review your test paper and let you know our feedbacks on the same. Also please find our suggested answers below.');
					}
			}	
			else
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}		
		}
	}
}