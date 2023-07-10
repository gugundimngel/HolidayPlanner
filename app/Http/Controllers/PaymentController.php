<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
// use Illuminate\Support\Facades\Input;

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Tzsk\Payu\Facade\Payment;

use App\WebsiteSetting;
use App\MyConfig;
use App\BookingDetail;
use App\PaymentDetail;
use App\Coupon;
use App\User;
use App\Admin;
use App\Markup;

use Session;
use Cookie;
use Config;
use Auth;

class PaymentController extends Controller
{
	public function __construct(Request $request)
    {	
		$siteData = WebsiteSetting::where('id', '!=', '')->first();
		\View::share('siteData', $siteData);
       // $this->middleware('auth:web');
	}
	/**
     * All Payment Process.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		if($request->payment_method != ''){
			
			$auth = $this->GetAuthenticate();
			 $pessager = $request->all();
			  /*  $adulmeal = preg_filter('/^adult_PaxSeat_(.*)/', '$1', array_keys( $pessager ));
			$ssrresult = \Cache::get( 'ssrob'.$request->hfTraceId.$request->hfRIndex);
			$ssrresultdata = json_decode($ssrresult);
			 foreach($adulmeal as $val){
				 echo 'adult_PaxSeat_'.$val.'----'.$pessager['adult_PaxSeat_'.$val].'<br>';
				 $exploadseats = explode('_', $pessager['adult_PaxSeat_'.$val]);
				 $seat = @$exploadseats[1];
				 $seatsegment = @$exploadseats[3];
				 $rowseat = @$exploadseats[5];
				 $seatn = @$exploadseats[7];
				 if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->SeatDynamic !== null){
					 if(isset($ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn])){
						 echo @$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Code.'<br>';
						 
						echo '<pre>';  print_r(@$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]);
					 }
				 }
			 } */
			 
			  /* $childmeal = preg_filter('/^child_PaxSeat_(.*)/', '$1', array_keys( $pessager ));
			
			 foreach($childmeal as $val){
				 echo 'child_PaxSeat_'.$val.'----'.$pessager['child_PaxSeat_'.$val].'<br>'; 
				 
				  $exploadseats = explode('_', $pessager['child_PaxSeat_'.$val]);
				 $seat = @$exploadseats[1];
				 $seatsegment = @$exploadseats[3];
				 $rowseat = @$exploadseats[5];
				 $seatn = @$exploadseats[7];
				 if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->SeatDynamic !== null){
					 if(isset($ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn])){
						 echo @$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Code.'<br>';
					 }
				 }
			 }  */ 
			 
			 
								
			//
		/* echo '<pre>'; print_r($pessager); 
			die; */
			$searchdata = Session::get('allrequest');
			$mytravlercount = explode('-', $searchdata['px']);
			$mtcount = 0;
			for($mit =0; $mit<count($mytravlercount); $mit++){
				$mtcount += $mytravlercount[$mit];
			}
		  
			 $PublishedFare = 0;
			 $markupib = 0;
			 $submark = 0;
			 $sremarkupd = 0;
			 $insprice = 0;
			 $nytotal = 0;
			 $seatprice = 0;
			if($request->IsReturn == 1){
				if (\Cache::has('farequoteob'.$request->hfTraceId.$request->hfRIndex)){
					$resultob = \Cache::get( 'farequoteob'.$request->hfTraceId.$request->hfRIndex);
					
				}else{
		
				return Redirect::to('/booking/error')->with('error', 'Your session (TraceId) is expired.');
		}
		
		if(@$pessager['is_travelinsurance'] == 1){
			$response = $this->GetCalculatePlan($pessager);
			
			$insprice = @$response->pTravelPremiumOut_out->ptotalPremium;
		}
				if (\Cache::has('farequoteib'.$request->hfTraceId.$request->hfIBRIndex)){
					$resultib = \Cache::get( 'farequoteib'.$request->hfTraceId.$request->hfIBRIndex);
				}else{
		
				return Redirect::to('/booking/error')->with('error', 'Your session (TraceId) is expired.');
		} 
				
				$resultdata = json_decode($resultob);
				
				
				$resultdataib = json_decode($resultib);
				if($pessager['IsInt'] == 1){
						$is_international = 'international';
				}else{
					$is_international = 'domestic';
				}
				/* OB start*/
				$markupd =0;
	$markupamt = \App\Markup::where('flight_code', $resultdata->Response->Results->Segments[0][0]->Airline->AirlineCode)->where('flight_type', $is_international)->where('user_type', 'b2c')->first(); 
	if($markupamt){
		if($markupamt->service_type == 'fixed'){
			$markupd =  $markupamt->service_fee * $mtcount;
		}else{
			$markupd = ($resultdata->Response->Results->Fare->OfferedFare * $markupamt->service_fee/100) * $mtcount;
		}
		$mark = $resultdata->Response->Results->Fare->OfferedFare + $markupd;
	 $submark = $mark - $resultdata->Response->Results->Fare->PublishedFare;
	}
	if($submark < 0){
		$newtotal1 = round($resultdata->Response->Results->Fare->PublishedFare + $submark);
	}else{
		$newtotal1 = round($resultdata->Response->Results->Fare->PublishedFare + $submark);
	}
	
	/*Return*/
	$remarkupd =0;
	$remarkupamt = \App\Markup::where('flight_code', $resultdataib->Response->Results->Segments[0][0]->Airline->AirlineCode)->where('flight_type', $is_international)->where('user_type', 'b2c')->first(); 
	if($remarkupamt){
		if($remarkupamt->service_type == 'fixed'){
			$remarkupd =  $remarkupamt->service_fee * $mtcount;
		}else{
			$remarkupd = ($resultdataib->Response->Results->Fare->OfferedFare * $remarkupamt->service_fee/100) * $mtcount;
		}
		$remark = $resultdataib->Response->Results->Fare->OfferedFare + $remarkupd;
	 $sremarkupd = $remark - $resultdataib->Response->Results->Fare->PublishedFare;
	}
	
	if($submark < 0){
		$newtotal2 = round($resultdataib->Response->Results->Fare->PublishedFare + $sremarkupd);
	}else{
		$newtotal2 = round($resultdataib->Response->Results->Fare->PublishedFare + $sremarkupd);
	}
	
			$newtotal = $newtotal1 + $newtotal2;	
				
				/* OB End*/
				
				$service_fees = \App\MyConfig::where('meta_key','service_fees')->first();
				$service_type = \App\MyConfig::where('meta_key','service_type')->first();
				
				if($service_type->meta_value == 'fixed'){
					$mv =  $service_fees->meta_value;
				}else{
					$mv = ($newtotal * $service_fees->meta_value/100);
				}
				
				
				$bagageprice = 0;
				$mealprice = 0;
				$seatprice = 0;
				
				$adulbaggage = preg_filter('/^adultbaggage_(.*)/', '$1', array_keys( $pessager ));
				foreach($adulbaggage as $val){
					if (\Cache::has('ssrob'.$request->hfTraceId.$request->hfRIndex)){
						$ssrresult = \Cache::get( 'ssrob'.$request->hfTraceId.$request->hfRIndex);
						$ssrresultdata = json_decode($ssrresult);
						if(isset($pessager['adultbaggage_'.$val])){
							$dep_baggage = explode('_', $pessager['adultbaggage_'.$val]);
							if($dep_baggage[1] != 'NONE'){
								if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->Baggage !== null){
									foreach(@$ssrresultdata->Response->Baggage as $key => $bsslist){
										foreach(@$bsslist as $b_list){
											if($b_list->Code == $dep_baggage[1]){
												//echo 'sdsddssd ><br>';
												$bagageprice +=  $b_list->Price;
												
											}
										}
									}
								}
							}
						}
					}
				}
				
				
				$adulmeal = preg_filter('/^adultmeal_(.*)/', '$1', array_keys( $pessager ));
				foreach($adulmeal as $val){
							if (\Cache::has('ssrob'.$request->hfTraceId.$request->hfRIndex)){
								if(isset($pessager['adultmeal_'.$val])){
										$dep_meal = explode('@', $pessager['adultmeal_'.$val]);
										if($dep_meal[0] != 'NONE'){
											if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->MealDynamic !== null){
												foreach(@$ssrresultdata->Response->MealDynamic as $key => $meallist){
													foreach(@$meallist as $m_list){
														
														if($m_list->Code == $dep_meal[0]){
															
															$mealprice +=$m_list->Price;
															break;
														}
													}
												}
											}
										}
									} 
							}
						 }			
				
			$adulPaxSeat = preg_filter('/^adult_(.*)/', '$1', array_keys( $pessager ));
				foreach($adulPaxSeat as $val){
					if(isset($pessager['adult_'.$val])){
						$ssrresult = \Cache::get( 'ssrob'.$request->hfTraceId.$request->hfRIndex);
						$ssrresultdata = json_decode($ssrresult);
							 if($pessager['adult_'.$val] != 'none'){
								 $exploadseats = explode('_', $pessager['adult_'.$val]);
								 $seat = @$exploadseats[1];
								 $seatsegment = @$exploadseats[3];
								 $rowseat = @$exploadseats[5];
								 $seatn = @$exploadseats[7];
								 if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->SeatDynamic !== null){
									 if(isset($ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn])){
										 $seatprice += @$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Price;
									 }
								 }
							}
					}
				}
				
				
				$childbaggage = preg_filter('/^childbaggage_(.*)/', '$1', array_keys( $pessager ));
				foreach($childbaggage as $val){
					if (\Cache::has('ssrob'.$request->hfTraceId.$request->hfRIndex)){
						$ssrresult = \Cache::get( 'ssrob'.$request->hfTraceId.$request->hfRIndex);
						$ssrresultdata = json_decode($ssrresult);
						if(isset($pessager['childbaggage_'.$val])){
							$dep_baggage = explode('_', $pessager['childbaggage_'.$val]);
							if($dep_baggage[1] != 'NONE'){
								if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->Baggage !== null){
									foreach(@$ssrresultdata->Response->Baggage as $key => $bsslist){
										foreach(@$bsslist as $b_list){
											if($b_list->Code == $dep_baggage[1]){
												//echo 'sdsddssd ><br>';
												$bagageprice +=  $b_list->Price;
												
											}
										}
									}
								}
							}
						}
					}
				}
			
			$childmeal = preg_filter('/^childmeal_(.*)/', '$1', array_keys( $pessager ));				
			foreach($childmeal as $val){
				 if(isset($pessager['childmeal_'.$val])){
							$dep_meal = explode('@', $pessager['childmeal_'.$val]);
							$dep_mealc = explode('-', $pessager['childmeal_'.$val]);
							if($dep_meal[0] != 'NONE'){
								if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->MealDynamic !== null){
									foreach(@$ssrresultdata->Response->MealDynamic as $key => $meallist){
										foreach(@$meallist as $m_list){
											
											if($m_list->Code == $dep_meal[0] && $m_list->Origin == $dep_mealc[1] && $m_list->Destination == $dep_mealc[2]){
												
												$mealprice +=$m_list->Price;
												break;
											}
										}
									}
								}
							}
						}
			 }	

$childseat = preg_filter('/^child_(.*)/', '$1', array_keys( $pessager ));
				foreach($childseat as $val){
					if(isset($pessager['child_'.$val])){
						$ssrresult = \Cache::get( 'ssrob'.$request->hfTraceId.$request->hfRIndex);
						$ssrresultdata = json_decode($ssrresult);
					
							 if($pessager['child_'.$val] != 'none'){
								 $exploadseats = explode('_', $pessager['child_'.$val]);
								 $seat = @$exploadseats[1];
								 $seatsegment = @$exploadseats[3];
								 $rowseat = @$exploadseats[5];
								 $seatn = @$exploadseats[7];
								 if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->SeatDynamic !== null){
									 if(isset($ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn])){
										 $seatprice += @$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Price;
									 }
								 }
							}
					}
				}			 
					
					$adulbaggage = preg_filter('/^returnadultbaggage_(.*)/', '$1', array_keys( $pessager ));
				foreach($adulbaggage as $val){
					if (\Cache::has('ssrdataib'.$request->hfTraceId.$request->hfIBRIndex)){
						$ssrresult = \Cache::get( 'ssrdataib'.$request->hfTraceId.$request->hfIBRIndex);
						$ssrresultdata = json_decode($ssrresult);
						if(isset($pessager['returnadultbaggage_'.$val])){
							$dep_baggage = explode('_', $pessager['returnadultbaggage_'.$val]);
							if($dep_baggage[1] != 'NONE'){
								if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->Baggage !== null){
									foreach(@$ssrresultdata->Response->Baggage as $key => $bsslist){
										foreach(@$bsslist as $b_list){
											if($b_list->Code == $dep_baggage[1]){
												//echo 'sdsddssd ><br>';
												$bagageprice +=  $b_list->Price;
												
											}
										}
									}
								}
							}
						}
					}
				}

						$adulmeal = preg_filter('/^returnadultmeal_(.*)/', '$1', array_keys( $pessager ));
						
						foreach($adulmeal as $val){
							if (\Cache::has('ssrdataib'.$request->hfTraceId.$request->hfIBRIndex)){
								$ssribresult = \Cache::get( 'ssrdataib'.$request->hfTraceId.$request->hfIBRIndex);
							$ssrssribesult = json_decode($ssribresult);
								if(isset($pessager['returnadultmeal_'.$val])){
										$dep_meal = explode('@', $pessager['returnadultmeal_'.$val]);
										$dep_mealc = explode('-', $pessager['returnadultmeal_'.$val]);
										
										if($dep_meal[0] != 'NONE'){
											if(@$ssrssribesult->Response->Error->ErrorCode == 0 && @$ssrssribesult->Response->MealDynamic !== null){
												foreach(@$ssrssribesult->Response->MealDynamic as $key => $meallist){
													foreach(@$meallist as $m_list){
														if($m_list->Code == $dep_meal[0] && $m_list->Origin == $dep_mealc[1] && $m_list->Destination == $dep_mealc[2]){
															$mealprice +=$m_list->Price;
															break;
													}
												}
											}
										}
									}
								} 
							}
						}	

$adulPaxSeat = preg_filter('/^returnadult_(.*)/', '$1', array_keys( $pessager ));

				foreach($adulPaxSeat as $val){
					if(isset($pessager['returnadult_'.$val])){
					
						$ssrresultib = \Cache::get( 'ssrdataib'.$request->hfTraceId.$request->hfIBRIndex);
						$ssrresultdataib = json_decode($ssrresultib);
						//echo '<pre>'; print_r($ssrresultdataib); die;
							 if($pessager['returnadult_'.$val] != 'none'){
								 	
								 $exploadseats = explode('_', $pessager['returnadult_'.$val]);
								 $seat = @$exploadseats[1];
								 $seatsegment = @$exploadseats[3];
								 $rowseat = @$exploadseats[5];
								 $seatn = @$exploadseats[7];
								 if(@$ssrresultdataib->Response->Error->ErrorCode == 0 && @$ssrresultdataib->Response->SeatDynamic !== null){
									 
									 if(isset($ssrresultdataib->Response->SeatDynamic[0]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn])){
									
										 $seatprice += @$ssrresultdataib->Response->SeatDynamic[0]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Price;
									 }
								 }
							}
					}
				}	
			
					//echo '<pre>'; print_r($pessager);		
			$adulbaggage = preg_filter('/^returnchildbaggage_(.*)/', '$1', array_keys( $pessager ));
				foreach($adulbaggage as $val){
					if (\Cache::has('ssrdataib'.$request->hfTraceId.$request->hfIBRIndex)){
						$ssrresult = \Cache::get( 'ssrdataib'.$request->hfTraceId.$request->hfIBRIndex);
						$ssrresultdata = json_decode($ssrresult);
						if(isset($pessager['returnchildbaggage_'.$val])){
							$dep_baggage = explode('_', $pessager['returnchildbaggage_'.$val]);
							if($dep_baggage[1] != 'NONE'){
								if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->Baggage !== null){
									foreach(@$ssrresultdata->Response->Baggage as $key => $bsslist){
										foreach(@$bsslist as $b_list){
											if($b_list->Code == $dep_baggage[1]){
												//echo 'sdsddssd ><br>';
												$bagageprice +=  $b_list->Price;
												
											}
										}
									}
								}
							}
						}
					}
				}

					 $childmeal = preg_filter('/^returnchildmeal_(.*)/', '$1', array_keys( $pessager ));

					 foreach($childmeal as $val){
						 if(isset($pessager['returnchildmeal_'.$val])){
							 $ssrssdresult = \Cache::get( 'ssrdataib'.$request->hfTraceId.$request->hfIBRIndex);
							 $ssrssribesult = json_decode($ssrssdresult);
									$dep_meal = explode('@', $pessager['returnchildmeal_'.$val]);
									$dep_mealc = explode('-', $pessager['returnchildmeal_'.$val]);
									if($dep_meal[0] != 'NONE'){
										if(@$ssrssribesult->Response->Error->ErrorCode == 0 && @$ssrssribesult->Response->MealDynamic !== null){
											foreach(@$ssrssribesult->Response->MealDynamic as $key => $meallist){
												foreach(@$meallist as $m_list){
													
													if($m_list->Code == $dep_meal[0] && $m_list->Origin == $dep_mealc[1] && $m_list->Destination == $dep_mealc[2]){
														
														$mealprice +=$m_list->Price;
														break;
													}
												}
											}
										}
									}
								}
					 }	

			$childseat = preg_filter('/^returnchild_(.*)/', '$1', array_keys( $pessager ));
				foreach($childseat as $val){
					if(isset($pessager['returnchild_'.$val])){
						$ssrssdresult = \Cache::get( 'ssrdataib'.$request->hfTraceId.$request->hfIBRIndex);
						$ssrssribesult = json_decode($ssrssdresult);
					
							 if($pessager['returnchild_'.$val] != 'none'){
								 $exploadseats = explode('_', $pessager['returnchild_'.$val]);
								 $seat = 0;
								 $seatsegment = @$exploadseats[3];
								 $rowseat = @$exploadseats[5];
								 $seatn = @$exploadseats[7];
								 if(@$ssrssribesult->Response->Error->ErrorCode == 0 && @$ssrssribesult->Response->SeatDynamic !== null){
									 if(isset($ssrssribesult->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn])){
										 $seatprice += @$ssrssribesult->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Price;
									 }
								 }
							}
					}
				}					 
				/*  echo $bagageprice; 
							echo '<br>';
							echo $mealprice; die;  */
				$stotal = $newtotal + $mv + $bagageprice + $mealprice + $seatprice;
				 
				$publishfare = $stotal;
			}else{
				if (\Cache::has('farequoteob'.$request->hfTraceId.$request->hfRIndex)){
					$resultob = \Cache::get( 'farequoteob'.$request->hfTraceId.$request->hfRIndex);
				}else{
		
				return Redirect::to('/booking/error')->with('error', 'Your session (TraceId) is expired.');
					}
					/* if(@$pessager['is_travelinsurance'] == 1){
						$response = $this->GetCalculatePlan($pessager);
						
						$insprice = @$response->pTravelPremiumOut_out->ptotalPremium;
					} */
	
				$resultdata = json_decode($resultob);
				if($pessager['IsInt'] == 1){
						$is_international = 'international';
				 }else{
					$is_international = 'domestic';
				} 
				/* OB start*/
				$markupd =0;
				$submark = 0;
			//echo $is_international;
				foreach($resultdata->Response->Results->Segments as $key => $resss){ 
					$allflighdata = $resss;
					$markupamt = \App\Markup::where('flight_code', $allflighdata[0]->Airline->AirlineCode)->where('flight_type', $is_international)->where('user_type', 'b2c')->first(); 
					
					if($markupamt){
						if($markupamt->service_type == 'fixed'){
							$markupd =  $markupamt->service_fee * $mtcount; 
						}else{
							$markupd = ($resultdata->Response->Results->Fare->OfferedFare * $markupamt->service_fee/100) * $mtcount;
						}
						 $mark = $resultdata->Response->Results->Fare->OfferedFare + $markupd;
						 $submark += $mark - $resultdata->Response->Results->Fare->PublishedFare;
					}
				}
					
					
					
					  if($submark < 0){
						$newtotal = round($resultdata->Response->Results->Fare->PublishedFare + $submark);
					}else{
						$newtotal = round($resultdata->Response->Results->Fare->PublishedFare + $submark);
					}
					
			
				/* OB End*/
				$service_fees = \App\MyConfig::where('meta_key','service_fees')->first();
				$service_type = \App\MyConfig::where('meta_key','service_type')->first();
				if($service_type->meta_value == 'fixed'){
					$mv =  $service_fees->meta_value;
				}else{
					$mv = ($newtotal * $service_fees->meta_value/100);
				}
				
				$bagageprice = 0;
				$mealprice = 0;
				$seatprice = 0;
				$adulbaggage = preg_filter('/^adultbaggage_(.*)/', '$1', array_keys( $pessager ));
				foreach($adulbaggage as $val){
					if (\Cache::has('ssrob'.$request->hfTraceId.$request->hfRIndex)){
						$ssrresult = \Cache::get( 'ssrob'.$request->hfTraceId.$request->hfRIndex);
						$ssrresultdata = json_decode($ssrresult);
						if(isset($pessager['adultbaggage_'.$val])){
							$dep_baggage = explode('_', $pessager['adultbaggage_'.$val]);
							if($dep_baggage[1] != 'NONE'){
								if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->Baggage !== null){
									foreach(@$ssrresultdata->Response->Baggage as $key => $bsslist){
										foreach(@$bsslist as $b_list){
											if($b_list->Code == $dep_baggage[1]){
												//echo 'sdsddssd ><br>';
												$bagageprice +=  $b_list->Price;
												
											}
										}
									}
								}
							}
						}
					}
				}
							
							
			$childbaggage = preg_filter('/^childbaggage_(.*)/', '$1', array_keys( $pessager ));
				foreach($childbaggage as $val){
					if (\Cache::has('ssrob'.$request->hfTraceId.$request->hfRIndex)){
						$ssrresult = \Cache::get( 'ssrob'.$request->hfTraceId.$request->hfRIndex);
						$ssrresultdata = json_decode($ssrresult);
						if(isset($pessager['childbaggage_'.$val])){
							$dep_baggage = explode('_', $pessager['childbaggage_'.$val]);
							if($dep_baggage[1] != 'NONE'){
								if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->Baggage !== null){
									foreach(@$ssrresultdata->Response->Baggage as $key => $bsslist){
										foreach(@$bsslist as $b_list){
											if($b_list->Code == $dep_baggage[1]){
												//echo 'sdsddssd ><br>';
												$bagageprice +=  $b_list->Price;
												
											}
										}
									}
								}
							}
						}
					}
				}
				
				$adulmeal = preg_filter('/^adultmeal_(.*)/', '$1', array_keys( $pessager ));
				foreach($adulmeal as $val){
							if (\Cache::has('ssrob'.$request->hfTraceId.$request->hfRIndex)){
								$ssrresult = \Cache::get( 'ssrob'.$request->hfTraceId.$request->hfRIndex);
						$ssrresultdata = json_decode($ssrresult);
								if(isset($pessager['adultmeal_'.$val])){
										$dep_meal = explode('@', $pessager['adultmeal_'.$val]);
										$dep_mealc = explode('-', $pessager['adultmeal_'.$val]);
										if($dep_meal[0] != 'NONE'){
											if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->MealDynamic !== null){
												foreach(@$ssrresultdata->Response->MealDynamic as $key => $meallist){
													foreach(@$meallist as $m_list){
														
														if($m_list->Code == $dep_meal[0] && $m_list->Origin == $dep_mealc[1] && $m_list->Destination == $dep_mealc[2]){
															//echo $m_list->Price. '<br>';
															$mealprice +=$m_list->Price;
															break;
														}
													}
												}
											}
										}
									} 
							}
						 }	
			
				  $childmeal = preg_filter('/^childmeal_(.*)/', '$1', array_keys( $pessager ));		
			  
			foreach($childmeal as $val){
				 if(isset($pessager['childmeal_'.$val])){
					$ssrresult = \Cache::get( 'ssrob'.$request->hfTraceId.$request->hfRIndex);
						$ssrresultdata = json_decode($ssrresult);
							$dep_meal = explode('@', $pessager['childmeal_'.$val]);
							$dep_mealc = explode('-', $pessager['childmeal_'.$val]);
							if($dep_meal[0] != 'NONE'){
								if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->MealDynamic !== null){
									foreach(@$ssrresultdata->Response->MealDynamic as $key => $meallist){
										foreach(@$meallist as $m_list){
											//echo $dep_meal[0];
											if($m_list->Code == $dep_meal[0] && $m_list->Origin == $dep_mealc[1] && $m_list->Destination == $dep_mealc[2]){
												
												$mealprice +=$m_list->Price;
												break;
											}
										}
									}
								}
							}
						}
			 }	
			
				 $adulPaxSeat = preg_filter('/^adult_(.*)/', '$1', array_keys( $pessager ));
				foreach($adulPaxSeat as $val){
					if(isset($pessager['adult_'.$val])){
						$ssrresult = \Cache::get( 'ssrob'.$request->hfTraceId.$request->hfRIndex);
						$ssrresultdata = json_decode($ssrresult);
							 if($pessager['adult_'.$val] != 'none'){
								 $exploadseats = explode('_', $pessager['adult_'.$val]);
								 $seat = @$exploadseats[1];
								 $seatsegment = @$exploadseats[3];
								 $rowseat = @$exploadseats[5];
								 $seatn = @$exploadseats[7];
								 if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->SeatDynamic !== null){
									 if(isset($ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn])){
										 $seatprice += @$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Price;
									 }
								 }
							}
					}
				}
				
				$childseat = preg_filter('/^child_(.*)/', '$1', array_keys( $pessager ));
				foreach($childseat as $val){
					if(isset($pessager['child_'.$val])){
						$ssrresult = \Cache::get( 'ssrob'.$request->hfTraceId.$request->hfRIndex);
						$ssrresultdata = json_decode($ssrresult);
					
							 if($pessager['child_'.$val] != 'none'){
								 $exploadseats = explode('_', $pessager['child_'.$val]);
								 $seat = @$exploadseats[1];
								 $seatsegment = @$exploadseats[3];
								 $rowseat = @$exploadseats[5];
								 $seatn = @$exploadseats[7];
								 if(@$ssrresultdata->Response->Error->ErrorCode == 0 && @$ssrresultdata->Response->SeatDynamic !== null){
									 if(isset($ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn])){
										 $seatprice += @$ssrresultdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Price;
									 }
								 }
							}
					}
				}
				
						/* echo $bagageprice; 
							echo '<br>';
							echo $mealprice; die; */
				  $nytotal = $newtotal + $mv + $bagageprice + $mealprice + $seatprice;  
				$publishfare = $nytotal; 
				
				
			}
					
				// print_r($pessager); die;
				 Session::put('TokenId', $auth->TokenId);
				 Session::put('pessager', $pessager);
				
				 
				if($request->IsReturn == 1){
					if($resultdata->Response->Error->ErrorCode != 0 || $resultdataib->Response->Error->ErrorCode != 0){
						return Redirect::to('/booking/error')->with('error', $resultdata->Response->Error->ErrorMessage);
					}
				}else{
					if($resultdata->Response->Error->ErrorCode != 0){
						return Redirect::to('/booking/error')->with('error', $resultdata->Response->Error->ErrorMessage);
					}
				}
				
				
				$discount =0;
				$coupon_id = '';
				$discount_type = '';
				$discount_amt = '';
				if($pessager['coupncode'] != ''){
					$today = date('Y-m-d');
					if(Coupon::where('coupon_code',@$pessager['coupncode'])->whereDate('start_date','<=', $today)->whereDate('end_date','>=', $today)->where('status',1)->exists()){
						$couponvalue = Coupon::where('coupon_code',@$pessager['coupncode'])->whereDate('start_date','<=', $today)->whereDate('end_date','>=', $today)->where('status',1)->first();
					
						
							if($couponvalue->no_of_coupon >= $couponvalue->used_count){
									if($couponvalue->discount_type == 'percentage'){
										$discount_type = 'percentage';
										$coupon_id = $couponvalue->coupon_code;
										$discount_amt = $couponvalue->discount;
										
										$discount = ($publishfare * $couponvalue->discount/100);
									}else{
										$discount_type = 'fixed';
										$coupon_id = $couponvalue->coupon_code;
										$discount_amt = $couponvalue->discount;
										$discount = $couponvalue->discount;
									}
								}
						
					}
				}
   
				$oldtotal = $publishfare + $insprice; 
				$finaltotal = $oldtotal - $discount; 
				
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
					$user->first_name = @$pessager['adultfirstname'][0];
					$user->last_name = @$pessager['adultlastname'][0];
					$user->password = Hash::make(@$pessager['adultfirstname'][0].time());
					$user->status = 1;
					$save = $user->save();
				}
			}
			$uuser = User::find($user->id);
			$uuser->gst_no = @$pessager['gst_number'];
			$uuser->company_name = @$pessager['company_name'];
			$uuser->email_id = @$pessager['email_id'];
			$uuser->mobile_number = @$pessager['phone'];
			$uuser->save();
			
			$origin = Session::get('origin');
		$destination = Session::get('destination');
		$from_date = Session::get('from_date');
		$to_date = Session::get('to_date');
				$bookingdetail = new BookingDetail;
				$bookingdetail->user_id = $user->id;
				$bookingdetail->pnr = '';
				$bookingdetail->booking_id = '';
				$bookingdetail->trace_id = '';
				$bookingdetail->email = $pessager['email'];
				$bookingdetail->mobile = $pessager['phone'];
				$bookingdetail->depart_flight = $origin.'-'.$destination;
				if($request->IsReturn == 1){
				$bookingdetail->return_flight = $destination.'-'.$origin;
				}
				$bookingdetail->source = $origin;
				$bookingdetail->destination = $destination;
				$bookingdetail->from_date = $from_date;
				if($request->IsReturn == 1){
				$bookingdetail->to_date = $to_date;
				}
				$bookingdetail->depart_date = $from_date;
				if($request->IsReturn == 1){
				$bookingdetail->return_date = $to_date;
				}
				$bookingdetail->farequoteib_log = @$resultib;
				$bookingdetail->farequoteob_log = @$resultob;
				$bookingdetail->bookingib_request = json_encode($pessager);
				$bookingdetail->booking_response = '';
				$bookingdetail->status = 0;
				$bookingdetail->type = 'b2c';
				$bookingdetail->ticket_status = 0;
				$saved = $bookingdetail->save();
				
				
				$payment = new PaymentDetail;
				$payment->bookingid = $bookingdetail->id;
				$payment->coupon_id = $coupon_id;
				$payment->discount_type = $discount_type;
				$payment->discount_amount = $discount_amt;
				$payment->amount = $finaltotal;
				$payment->org_amount = $publishfare;
				
				$payment->service_fee = $mv;
				$payment->markupob = $submark;
				$payment->markupib = $sremarkupd;
				$payment->ins_amount = $insprice;
				$payment->status = 0;
				$payment->save();
				Session::put('booking_id', $bookingdetail->id);
				Session::put('payment_id', $payment->id);
				Session::put('useridd', $user->id);
			 if($request->payment_method == 'razorpay'){
				 
				 $rzkey = \App\MyConfig::where('meta_key','rz_paykey')->first()->meta_value;
				$rzsec = \App\MyConfig::where('meta_key','rz_paysecret')->first()->meta_value;
				$api = new Api($rzkey, $rzsec);
				 $orderData = [
					'amount'          => $finaltotal * 100, // 2000 rupees in paise
					'currency'        => 'INR',
					'payment_capture' => 1 // auto capture
				];
				  $amount = $orderData['amount'];
				 $razorpayOrder = $api->order->create($orderData);
				$razorpayOrderId = $razorpayOrder['id'];
				Session::put('razorpay_order_id', $razorpayOrderId);
				 $email = $request->email;
				 $phone = $request->phone;
				 $name = $pessager['adultfirstname'][0];
				 	return view('razorpay',compact(['finaltotal','email','name','phone','razorpayOrderId','amount']));
			 }
			 else if ($request->payment_method == 'ccavenue') {
				$set = Admin::where('id',1)->first();
				 $d = array();
				 $d['merchant_id'] = MyConfig::where('meta_key','cc_merchant_id')->first()->meta_value;
				 $d['order_id'] = $set->ref_prefix.date("dmyHis");
				  $d['currency'] = 'INR';
				 $d['billing_country'] = 'India';
				 $d['billing_tel'] =  $request->phone;
				 $d['billing_name'] = $pessager['adultfirstname'][0];
				 $d['billing_email'] = $request->email;
				 $d['language'] = 'EN';
				$d['redirect_url'] = \URL::to('/Flight/response');
				$d['cancel_url'] = \URL::to('/Flight/response');
				$d['amount'] = $finaltotal;
				$working_key = MyConfig::where('meta_key','cc_working_key')->first();
				
				$accesscode = MyConfig::where('meta_key','cc_access_code')->first();
				$access_code = $accesscode->meta_value;
				$cc_gateway_url = MyConfig::where('meta_key','cc_gateway_url')->first();
				$merchant_data = ''; 
				foreach ($d as $key => $value){
					$merchant_data.=$key.'='.urlencode($value).'&';
				}
				$encrypted_data=$this->encrypt($merchant_data,$working_key->meta_value); // Method for encrypting the data.
				//return Redirect::to('/Flight/ticket');
				?>
				<form method="post" name="redirect" action="<?php echo $cc_gateway_url->meta_value; ?>"> 
				<?php
				echo "<input type=hidden name=encRequest value=$encrypted_data>";
				echo "<input type=hidden name=access_code value=$access_code>";
				?>
				</form>
				</center>
				<script language='javascript'>document.redirect.submit();</script>
				<?php
			 }else{
				 
			 }
		}
		
	} 


public function payWithRazorpay(Request $request){
	$input = $request->all();
	// $input = Input::all();
	$rzkey = \App\MyConfig::where('meta_key','rz_paykey')->first()->meta_value;
	$rzsec = \App\MyConfig::where('meta_key','rz_paysecret')->first()->meta_value;
	$api = new Api($rzkey, $rzsec);
        //Fetch payment information by razorpay_payment_id
        //$payment = $api->payment->fetch($input['razorpay_payment_id']);
$success = false;
     //   if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
				$success = true;
              //  $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
				 $attributes = array(
            'razorpay_order_id' => Session::get('razorpay_order_id'),
            'razorpay_payment_id' => $input['razorpay_payment_id'],
            'razorpay_signature' => $input['razorpay_signature']
        );
		
		$api->utility->verifyPaymentSignature($attributes);
            } catch (SignatureVerificationError $e) {
				$success = false;
				$result = json_encode(array('success'=>false, 'message' => $e->getMessage()));
				$error = 'Razorpay Error : ' . $e->getMessage();
				$booking_id = Session::get('booking_id');
				$payment_id = Session::get('payment_id');
				$user_id = Session::get('useridd');
				$bookingdetail = BookingDetail::find($booking_id);
				$bookingdetail->user_id = @$user_id;
				
				$bookingdetail->booking_response = $result;
				$saved = $bookingdetail->save();
				
				
				$payment = PaymentDetail::find($payment_id);
				$payment->status = 2;
				$payment->save();
				$message = "Dear Admin, {name} has trying to book a  ticket from {source} to {destination} but Payment failed. Refrence Id is {bookingid}. For more bookings please visit {URL}. Thank you.";
				$this->AdminPhoneBookingTicket($booking_id, $message);
				Session::forget('pessager');
				Session::forget('TokenId');
				Session::forget('booking_id');
				Session::forget('payment_id');
				Session::forget('useridd');
				Session::forget('origin');
				Session::forget('destination');
				Session::forget('from_date');
				Session::forget('to_date');
				return Redirect::to('/booking-failure');
               
            }
		if ($success === true)
		{
			$pessager = Session::get('pessager');
			$payment_id = Session::get('payment_id');
			$payment = PaymentDetail::find($payment_id);
			$payment->status = 1;
			$payment->save();
			
			$websetting = WebsiteSetting::where('id', '!=', '')->first();
			if($websetting->disable_booking == 1){
				Session::forget('pessager');
				Session::forget('TokenId');
				Session::forget('booking_id');
				Session::forget('payment_id');
				Session::forget('useridd');
				Session::forget('origin');
				Session::forget('destination');
				Session::forget('from_date');
				Session::forget('to_date');
				return Redirect::to('/booking-failure');
			}
			 return view('donoclose');
		}else{
			$booking_id = Session::get('booking_id');
				$payment_id = Session::get('payment_id');
				$user_id = Session::get('useridd');
				$bookingdetail = BookingDetail::find($booking_id);
				$bookingdetail->user_id = @$user_id;
				
				$bookingdetail->booking_response = $error;
				$saved = $bookingdetail->save();
				
				
				$payment = PaymentDetail::find($payment_id);
				$payment->status = 2;
				$payment->save();
				$message = "Dear Admin, {name} has trying to book a  ticket from {source} to {destination} but Payment failed. Refrence Id is {bookingid}. For more bookings please visit {URL}. Thank you.";
				$this->AdminPhoneBookingTicket($booking_id, $message);
				Session::forget('pessager');
				Session::forget('TokenId');
				Session::forget('booking_id');
				Session::forget('payment_id');
				Session::forget('useridd');
				Session::forget('origin');
				Session::forget('destination');
				Session::forget('from_date');
				Session::forget('to_date');
				return Redirect::to('/booking-failure');
		}

        //}
        
        /* \Session::put('success', 'Payment successful, your order will be despatched in the next 48 hours.');
        return redirect()->back(); */
    }
public function donotClose(Request $request){
	$pessager = Session::get('pessager');
	 return view('donoclose');
}
public function response(Request $request){
	$workingKey=MyConfig::where('meta_key','cc_working_key')->first()->meta_value; //Working Key should be provided here.
		$encResponse=$_POST["encResp"]; //This is the response sent by the CCAvenue Server
		$rcvdString=$this->decrypt($encResponse,$workingKey); //Crypto Decryption used as per the specified working key.
		$order_status="";
		$order_id="";
		$decryptValues=explode('&', $rcvdString);
		$dataSize=sizeof($decryptValues);
		for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==3)
			$order_status=$information[1];
		if($i==0)
		{
			$order_id=$information[1];
		}
		if($i==1)
		{
			$tracking_id=$information[1];
		}
		if($i==2)
		{
			$bank_ref_no=$information[1];
		}
		if($i==4)
		{
			$failure_message=$information[1];
		}
		if($i==5)
		{
			$payment_mode=$information[1];
		}
		if($i==6)
		{
			$card_name=$information[1];
		}
		if($i==7)
		{
			$status_code=$information[1];
		}
		if($i==8)
		{
			$status_message=$information[1];
		}
		if($i==26)
		{
			$merchant_param1=$information[1];
		}
		if($i==27)
		{
			$vault=$information[1];
		}
		if($i==28)
		{
			$offer_type=$information[1];
		}
		if($i==29)
		{
			$offer_code=$information[1];
		}
		if($i==30)
		{
			$discount_value=$information[1];
		}
		if($i==35)
		{
			$mer_amount=$information[1];
		}
		if($i==36)
		{
			$eci_value=$information[1];
		}
		if($i==37)
		{
			$retry=$information[1];
		}
		if($i==38)
		{
			$response_code=$information[1];
		}
		if($i==39)
		{
			$billing_notes=$information[1];
		}
		if($i==40)
		{
			$trans_date=$information[1];
		}
		if($i==41)
		{
			$bin_country=$information[1];
		}
	}
	
	if($order_status==="Success")
	{
		$pessager = Session::get('pessager');
		if($pessager['IsReturn'] == 1){
			return Redirect::to('/Flight/returnticket');
		}else{
			return Redirect::to('/Flight/ticket');
		}
		
	}
	else if($order_status==="Failure")
	{
		
		$result = json_encode(array('success'=>false, 'message' => "Thank you for shopping with us.However,the transaction has been declined"));
		$booking_id = Session::get('booking_id');
		$payment_id = Session::get('payment_id');
		$user_id = Session::get('useridd');
				$bookingdetail = BookingDetail::find($booking_id);
				$bookingdetail->user_id = @$user_id;
				
				$bookingdetail->booking_response = $result;
				$saved = $bookingdetail->save();
				
				
				$payment = PaymentDetail::find($payment_id);
				$payment->status = 2;
				$message = "Dear Admin, {name} has trying to book a  ticket from {source} to {destination} but Payment failed. Refrence Id is {bookingid}. For more bookings please visit {URL}. Thank you.";
				$this->AdminPhoneBookingTicket($booking_id, $message);
		Session::forget('pessager');
		Session::forget('TokenId');
		Session::forget('booking_id');
		Session::forget('payment_id');
		Session::forget('useridd');
		Session::forget('origin');
		Session::forget('destination');
		Session::forget('from_date');
		Session::forget('to_date');
		return Redirect::to('/booking-failure');
		
	}
	else
	{
		$pessager = Session::get('pessager');
		$origin = Session::get('origin');
		$destination = Session::get('destination');
		$from_date = Session::get('from_date');
		$to_date = Session::get('to_date');
		//$result = json_encode('success'=>false, "message"=>"Security Error. Illegal access detected");
		$result = json_encode(array('success'=>false, 'message' => "Security Error. Illegal access detected"));
				$booking_id = Session::get('booking_id');
		$payment_id = Session::get('payment_id');
		$user_id = Session::get('useridd');
				$bookingdetail = BookingDetail::find($booking_id);
				$bookingdetail->user_id = @$user_id;
				
				$bookingdetail->booking_response = $result;
				$saved = $bookingdetail->save();
				
				
				$payment = PaymentDetail::find($payment_id);
				$payment->status = 3;
				$payment->save();
				$message = "Dear Admin, {name} has trying to book a  ticket from {source} to {destination} but Payment failed. Refrence Id is {bookingid}. For more bookings please visit {URL}. Thank you.";
				$this->AdminPhoneBookingTicket($booking_id, $message);
		Session::forget('pessager');
		Session::forget('TokenId');
		Session::forget('booking_id');
		Session::forget('payment_id');
		Session::forget('useridd');
		Session::forget('origin');
		Session::forget('destination');
		Session::forget('from_date');
		Session::forget('to_date');
		return Redirect::to('/booking-failure');
	
	}
	
}
}