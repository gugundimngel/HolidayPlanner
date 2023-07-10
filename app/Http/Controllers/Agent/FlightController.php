<?php
namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Route;

use App\User;
use App\Admin;
use App\WebsiteSetting;
use App\TravelPlan;
use App\Coupon;
use App\Agent;
use App\WalletHistory;
use Log;
use Mail;
use PDF;
use App\Mail\TicketMail;
use App\MyConfig;
use Carbon\Carbon;
use DB;
use Auth;
use Config;
use Cookie;
use Session;
use App\Airport;
use App\BookingDetail;
use App\PaymentDetail;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
class FlightController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		$this->middleware('auth:agents');
	}

	public function Flightindex(Request $request) 
    {
		 return view('Agent.flights.index');
	}	
	
	public function farerules(Request $request) 
	{
		$flghtapi = WebsiteSetting::where('id', '!=', '')->first();
		$auth = $this->GetAgentAuthenticate();
		if(isset($_GET['resindex']) && $_GET['resindex'] != ''){
			$resultxdataob = '{
			"EndUserIp": "103.138.188.143",
			"TokenId": "'.$auth->TokenId.'",
			"TraceId": "'.$request->traceid.'",
			"ResultIndex": "'.$request->resindex.'"
			}';
			if($flghtapi->agent_flight_api_type == 1){
				$urlsearch="https://tboapi.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/FareRule";
			}else{
				$urlsearch="http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/FareRule";
			}
			$resultob = $this->postcurlRequest($urlsearch,$resultxdataob); 
			$resultdataib = json_decode($resultob);
		$log = ['reuest' => $resultxdataob,'description' => $resultob];
		$orderLog = new Logger('obfarerule');
		$orderLog->pushHandler(new StreamHandler(storage_path('logs/obfarerule.log')), Logger::INFO);
		$orderLog->info('ObFareRule', $log);
		
		$resultxdataib = '{
			"EndUserIp": "103.138.188.143",
			"TokenId": "'.$auth->TokenId.'",
			"TraceId": "'.$request->traceid.'",
			"ResultIndex": "'.$request->ResultIndexR.'"
			}';
			if($flghtapi->agent_flight_api_type == 1){
				$urlsssearch="https://tboapi.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/FareRule";
			}else{
				$urlsssearch="http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/FareRule";
			}
			$resultib = $this->postcurlRequest($urlsssearch,$resultxdataib); 
			
		$log = ['request' => $resultxdataib,'description' => $resultib];
		$orderLog = new Logger('ibfarerule');
		$orderLog->pushHandler(new StreamHandler(storage_path('logs/ibfarerule.log')), Logger::INFO);
		$orderLog->info('IbFareRule', $log);
			if(isset($resultdataib->Response->FareRules)){
				if($resultdataib->Response->FareRules[0]->FareRuleDetail != ''){
					echo $resultdataib->Response->FareRules[0]->FareRuleDetail;
				}else{
					echo 'No Fare Rules Found';
				}
			}else{
					echo 'No Fare Rules Found';
				}
		}
	}
	public function FareQuote(Request $request) 
    {
		$flghtapi = WebsiteSetting::where('id', '!=', '')->first();
			$auth = $this->GetAgentAuthenticate();
			$resultdataib = array();
		if(isset($_GET['IsReturn']) && $_GET['IsReturn'] != 'False'){
			$resultxdataob = '{
			"EndUserIp": "103.138.188.143",
			"TokenId": "'.$auth->TokenId.'",
			"TraceId": "'.$request->TraceId.'",
			"ResultIndex": "'.$request->ResultIndex.'"
			}';
			$resultxdataib = '{
			"EndUserIp": "103.138.188.143",
			"TokenId": "'.$auth->TokenId.'",
			"TraceId": "'.$request->TraceId.'",
			"ResultIndex": "'.$request->ResultIndexR.'"
			}';
			if($flghtapi->agent_flight_api_type == 1){
				$urlsearch = "https://tboapi.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/FareQuote";
			}else{
				$urlsearch = "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/FareQuote";
			}
			$result = $this->postcurlRequest($urlsearch,$resultxdataob); 
			$resultdata = json_decode($result);
			
			$resultib = $this->postcurlRequest($urlsearch,$resultxdataib); 
			$resultdataib = json_decode($resultib);
			
			\Cache::put('farequoteob'.$request->TraceId.$request->ResultIndex, $result , now()->addMinutes(15));
			\Cache::put('farequoteib'.$request->TraceId.$request->ResultIndexR, $resultib , now()->addMinutes(15));
			
			$logss = ['request' => $resultxdataib,'description' => $resultib];
			$orderLog = new Logger('farequoteib');
			$orderLog->pushHandler(new StreamHandler(storage_path('logs/farequoteib.log')), Logger::INFO);
			$orderLog->info('FareQuoteIb', $logss);
		}else{
			$resultxdataob = '{
			"EndUserIp": "103.138.188.143",
			"TokenId": "'.$auth->TokenId.'",
			"TraceId": "'.$request->TraceId.'",
			"ResultIndex": "'.$request->ResultIndex.'"
			}';
			if($flghtapi->agent_flight_api_type == 1){
				$urlsearch = "https://tboapi.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/FareQuote";
			
			}else{
				$urlsearch = "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/FareQuote";
			}
			$result = $this->postcurlRequest($urlsearch,$resultxdataob); 
			$resultdata = json_decode($result);
				\Cache::put('farequoteob'.$request->TraceId.$request->ResultIndex, $result , now()->addMinutes(15));
		}
		$log = ['request' => $resultxdataob, 'description' => $result];
			$orderLog = new Logger('farequote');
			$orderLog->pushHandler(new StreamHandler(storage_path('logs/farequote.log')), Logger::INFO);
			$orderLog->info('FareQuote', $log);
		/* echo '<pre>'; print_r($resultdata);
		echo '<pre>'; print_r($resultdataib); */
		if(isset($_GET['IsReturn']) && $_GET['IsReturn'] != 'False'){
			if($resultdata->Response->Error->ErrorCode == 0 && $resultdataib->Response->Error->ErrorCode == 0){
			$mytotal = $request->price;
			$expired = 0;
			
			
			return view('Agent.flights.farequote', compact(['resultdata','resultdataib','mytotal','expired'])); 
		}else{
			$expired = 1;
			$err = $resultdata->Response->Error->ErrorMessage.' '.$resultdataib->Response->Error->ErrorMessage;
			return view('Agent.flights.farequote', compact(['expired','err'])); 
		}
		}else{
			if($resultdata->Response->Error->ErrorCode == 0){
			$mytotal = $request->price;
			$expired = 0;
			
			
			return view('Agent.flights.farequote', compact(['resultdata','resultdataib','mytotal','expired'])); 
		}else{
			$expired = 1;
			$err = $resultdata->Response->Error->ErrorMessage;
			return view('Agent.flights.farequote', compact(['expired','err'])); 
		}
		}
		
	}	
	
	 
	public function flightList(Request $request) 
    {
		$flghtapi = WebsiteSetting::where('id', '!=', '')->first();
		$auth = $this->GetAgentAuthenticate();
		
		Session::put('allrequest',$request->all());
		if($request->has('srch')){
			$srch 		= 	$request->input('srch');
				if(trim($srch) != '')	
				{
					$explodesearc = explode('|', $srch);
					$originexplode = explode('-', $explodesearc[0]);
					$desexplode = explode('-', $explodesearc[1]);
					
					$datedeparture = date('Y-m-d', strtotime($explodesearc[2]));
					$datearival = date('Y-m-d', strtotime($explodesearc[2]));
					if(isset($explodesearc[3])){
						$datearival = date('Y-m-d', strtotime($explodesearc[3]));
					}
					$origin = $originexplode[0];
					$destination = $desexplode[0];
					
					$source = $originexplode[1];
					$destin = $desexplode[1];
					
				}
		}
		if($request->has('jt')){
			$jt 		= 	$request->input('jt');
		}
		if($request->has('cbn')){
			$cbn 		= 	$request->input('cbn');
		}
		if($request->has('nt')){
			$nt 		= 	$request->input('nt');
			if($nt == 1){
				$DirectFlight = "true";
			}else{
				$DirectFlight = "false";
			}
		}else{
			$DirectFlight = "false";
		}
		if($request->has('px')){
			$px 		= 	$request->input('px');
				if(trim($px) != '')	
				{
					$explodepass = explode('-', $px);
					$adult = $explodepass[0];
					$child = $explodepass[1];
					$infant = $explodepass[2];
				} 
		}
		
		
		if($jt == 1){
			Session::put('origin', $origin);
		Session::put('destination', $destination);
		Session::put('from_date', $datedeparture);
		Session::put('to_date', '');
		$data = '{
			"EndUserIp": "103.138.188.143",
			"TokenId": "'.$auth->TokenId.'",
			"AdultCount": "'.$adult.'",
			"ChildCount": "'.$child.'",
			"InfantCount": "'.$infant.'",
			"DirectFlight": "'.$DirectFlight.'",
			"OneStopFlight": "false",
			"JourneyType": "'.$jt.'",
			"PreferredAirlines": null,
			"Segments": [
			{
			"Origin": "'.$origin.'",
			"Destination": "'.$destination.'",
			"FlightCabinClass": '.$cbn.',
			"PreferredDepartureTime": "'.$datedeparture.'T00: 00: 00",
			"PreferredArrivalTime": "'.$datearival.'T00: 00: 00"
			}
					],
			"Sources": null
			}'; 
		//	echo $data; die;
			$calenderdata = '{
				"JourneyType": "'.$jt.'",
				"EndUserIp": "103.138.188.143",
				"TokenId": "'.@$auth->TokenId.'",
				"PreferredAirlines": null,
				"Segments": [ {
						"Origin": "'.$origin.'",
				"Destination": "'.$destination.'",
				"FlightCabinClass": "'.$cbn.'",
				"PreferredDepartureTime": "'.$datedeparture.'T00:00:00"
				}
				],
				"Sources": null
				}';
				$depmonth = date('m',strtotime($datedeparture));
				$depyear = date('Y',strtotime($datedeparture));
				if ($depmonth >= 12)
                {
                    $PreferredDepartureTime = ($depyear + 1) . "-" . ($depmonth - 11) . "-01T00:00:00";
                }
                else
                {
					
                    $PreferredDepartureTime = $depyear . "-" . ($depmonth + 1) . "-01T00:00:00";
                }
				$calenderdatad = '{
				"JourneyType": "'.$jt.'",
				"EndUserIp": "103.138.188.143",
				"TokenId": "'.@$auth->TokenId.'",
				"PreferredAirlines": null,
				"Segments": [ {
						"Origin": "'.$origin.'",
				"Destination": "'.$destination.'",
				"FlightCabinClass": "'.$cbn.'",
				"PreferredDepartureTime": "'.$PreferredDepartureTime.'"
				}
				],
				"Sources": null
				}';
				if($flghtapi->agent_flight_api_type == 1){
					$urlcsearch = "https://tboapi.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/GetCalendarFare";
				}else{
					$urlcsearch = "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/GetCalendarFare";
				}
				
			$calendesrresult = $this->postcurlRequest($urlcsearch,$calenderdata); 
			$calendesrresult1 = $this->postcurlRequest($urlcsearch,$calenderdatad); 
			$calenderresult = json_decode($calendesrresult);
			//echo '<pre>'; print_r($calenderresult);
			$calenderresult1 = json_decode($calendesrresult1);
		}else if($jt == 2){
			Session::put('origin', $origin);
		Session::put('destination', $destination);
		Session::put('from_date', $datedeparture);
		Session::put('to_date', $datearival);
			$data = '{
			"EndUserIp": "103.138.188.143",
			"TokenId": "'.$auth->TokenId.'",
			"AdultCount": "'.$adult.'",
			"ChildCount": "'.$child.'",
			"InfantCount": "'.$infant.'",
			"DirectFlight": "'.$DirectFlight.'",
			"OneStopFlight": "false",
			"JourneyType": "'.$jt.'",
			"PreferredAirlines": null,
			"Segments": [
			{
			"Origin": "'.$origin.'",
			"Destination": "'.$destination.'",
					"FlightCabinClass": '.$cbn.',
			"PreferredDepartureTime": "'.$datedeparture.'T00: 00: 00",
			"PreferredArrivalTime": "'.$datedeparture.'T00: 00: 00"
			},
				{
				  "Origin": "'.$destination.'",
				  "Destination": "'.$origin.'",
				  "FlightCabinClass": '.$cbn.',
				  "PreferredDepartureTime": "'.$datearival.'T00:00:00",
				  "PreferredArrivalTime": "'.$datearival.'T00:00:00"
				}
					],
			"Sources": null
			}'; 
		}else if($jt == 3){
			$srch 		= 	$request->input('srch');
			$explodesearc = explode('^', $srch);
			$array = array();
			for($i=0; $i< count($explodesearc); $i++){
				$explodedes = explode('|', $explodesearc[$i]);
					$source = explode('-', $explodedes[0]);
					$dest = explode('-', $explodedes[1]);

					$datedeparture = date('Y-m-d', strtotime($explodedes[2]));
					$datearival = date('Y-m-d', strtotime($explodedes[2]));
					
					
					$array[] = array(
						'Origin' =>$source[0],
						'Destination' =>$dest[0],
						'FlightCabinClass' =>2,
						"PreferredDepartureTime"=> $datedeparture.'T00: 00: 00',
						"PreferredArrivalTime"=> $datedeparture.'T00: 00: 00'
					); 
			}
			$r = json_encode($array);
			$data = '{
			"EndUserIp": "103.138.188.143",
			"TokenId": "'.$auth->TokenId.'",
			"AdultCount": "'.$adult.'",
			"ChildCount": "'.$child.'",
			"InfantCount": "'.$infant.'",
			"DirectFlight": "'.$DirectFlight.'",
			"OneStopFlight": "false",
			"JourneyType": "3",
			"PreferredAirlines": null,
			"Segments": '.$r.',
			"Sources": null
			}'; 
			
			//echo '<pre>'; print_r($data); die;
		}
		
			 $jsonresponse = $data;
	$log = ['description' => $jsonresponse];
			$orderLog = new Logger('searchreq');
			$orderLog->pushHandler(new StreamHandler(storage_path('logs/searchrequest.log')), Logger::INFO);
			$orderLog->info('SearchReq', $log);	
		
		if($flghtapi->agent_flight_api_type == 1){			
			$urlsearch = "https://tboapi.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/Search";
		 }else{
			$urlsearch = "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/Search";
		}  
			//echo $urlsearch; die;
			 $result = $this->postcurlRequest($urlsearch,$jsonresponse);
		
			 
			$logs = ['description' => $result];
			$orderLog = new Logger('searchres');
			$orderLog->pushHandler(new StreamHandler(storage_path('logs/searchresponse.log')), Logger::INFO);
			$orderLog->info('SearchRes', $logs);
			$flightresult = json_decode($result);
		//echo '<pre>'; print_r($flightresult); die;
			if(@$flightresult->Response->Error->ErrorCode == 0){
				
				\Cache::put($flightresult->Response->TraceId, $result , now()->addMinutes(15));
				if($jt == 1){
					if($originexplode[2] == 'India' && $desexplode[2] == 'India'){
						$is_international = false;
					}else{
						$is_international = true;
					}
					
					return view('Agent.flights.oneway', compact(['flightresult','calenderresult', 'is_international', 'calenderresult1'])); 
				}else if($jt == 3){
				$calenderresult = array();
				$calenderresult1 = array();
					if($originexplode[2] == 'India' && $desexplode[2] == 'India'){
						$is_international = false;
					}else{
						$is_international = true;
					}
						//echo '<pre>'; print_r($flightresult); die;
					return view('Agent.flights.multiway', compact(['flightresult','calenderresult', 'is_international', 'calenderresult1'])); 
				}else if($jt == 2){
					if($originexplode[2] == 'India' && $desexplode[2] == 'India'){
						$result = \Cache::get($flightresult->Response->TraceId);
						$flightresult = json_decode($result);
						return view('Agent.flights.roundtrip', compact(['flightresult','source','destin','datearival','datedeparture'])); 
					}else{
						$calenderdata = '{
				"JourneyType": "'.$jt.'",
				"EndUserIp": "103.138.188.143",
				"TokenId": "'.$auth->TokenId.'",
				"PreferredAirlines": null,
				"Segments": [ {
						"Origin": "'.$origin.'",
				"Destination": "'.$destination.'",
				"FlightCabinClass": "'.$cbn.'",
				"PreferredDepartureTime": "'.$datedeparture.'T00:00:00"
				}
				],
				"Sources": null
				}';
				if($flghtapi->agent_flight_api_type == 1){
					$urlcsearch = "https://tboapi.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/GetCalendarFare";
				}else{
					$urlcsearch = "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/GetCalendarFare";
				}
				
				
			$calendesrresult = $this->postcurlRequest($urlcsearch,$calenderdata); 
			$calenderresult = json_decode($calendesrresult);
						return view('Agent.flights.international', compact(['flightresult','source','destin','datearival','datedeparture','calenderresult'])); 
					}
					
				}
			}else{
				
				return Redirect::to('/agent/search-again')->with('error', Config::get('constants.unauthorized'));
			}
	}

	public function booking(Request $request){
		
		if (\Cache::has($request->tid)){
				$resultdataib = array();
			$resultib = \Cache::get( $request->tid);
			$resultdataibs = json_decode($resultib);
			 
			$ibkeys = array();
			if(isset($_GET['IsReturn'])){
				$keys = [];
				foreach($resultdataibs->Response->Results as $l){
					
					for ($i=0; $i<count($l); $i++) {
					
						 if (@$_GET['Index'] == $l[$i]->ResultIndex) {
							array_push($keys, $l[$i]);
						}
					}
				}
				$ibkeys = [];
				foreach($resultdataibs->Response->Results as $ls){
					
					
					for ($is=0; $is<count($ls); $is++) {
					
						 if ($_GET['IndexR'] == $ls[$is]->ResultIndex) {
							array_push($ibkeys, $ls[$is]);
						}
					}
				}
				
			}else{
				foreach($resultdataibs->Response->Results as $l){
					$keys = [];
					for ($i=0; $i<count($l); $i++) {
					
						 if ($_GET['RIndex'] == $l[$i]->ResultIndex) {
							array_push($keys, $l[$i]);
						}
					}
				}
			}
			
		
			$resultdata = $keys;
			
			$resultdataib = $ibkeys;
				
		$getplantotal = $resu = $this->GetInsurancePlan();
			return view('Agent.flights.booking', compact(['resultdata','resultdataib','getplantotal'])); 
		}else{
		
				return Redirect::to('/agent/booking/error')->with('error', 'Your session (TraceId) is expired.');
		}
		
	}
	
	public function searchagain(Request $request){
		return view('Agent.flights.searchagain'); 
	}
	
	public function GetSSR(Request $request){
		$flghtapi = WebsiteSetting::where('id', '!=', '')->first();
		$auth = $this->GetAgentAuthenticate();
		 $result_data = '{
		"EndUserIp": "103.138.188.143",
		"TokenId": "'.$auth->TokenId.'",
		"TraceId": "'.$request->TraceId.'",
        "ResultIndex": "'.$request->ResultIndex.'"
		}';
		if($flghtapi->agent_flight_api_type == 1){
		$urlse= "https://tboapi.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/SSR";
		}else{
		$urlse= "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/SSR";
		}
		$result = $this->postcurlRequest($urlse,$result_data); 
		$ssrdata = json_decode($result); 
		\Cache::put('ssrob'.$request->TraceId.$request->ResultIndex, $result , now()->addMinutes(15));
		
			$log = ['email' => @$pessager['email'],
				'description' => $result];
			$orderLog = new Logger('ssrob');
				$orderLog->pushHandler(new StreamHandler(storage_path('logs/ssrob.log')), Logger::INFO);
				$orderLog->info('SsOb', $log);
		$ssrdataib = array();
		$is_return = 0;
		
		$inwardbaggagessr = array();
		$inwardflight = '';
		$inwardbaggagessr = array();
		$inwardmealssr = array();
			$inwardseatssr = '';
		$inwardseatSEGMRNTssr = array();
		$inwardflightcode = '';
		if(isset($_GET['IsReturn']) && $_GET['IsReturn'] == 'true'){
			 $result_dataib = '{
			"EndUserIp": "103.138.188.143",
			"TokenId": "'.$auth->TokenId.'",
			"TraceId": "'.$request->TraceId.'",
			"ResultIndex": "'.@$request->ResultIndexR.'"
			}';
			//print_r($result_dataib);
			$resultib = $this->postcurlRequest($urlse,$result_dataib); 
			$ssrdataib = json_decode($resultib);
			$is_return = 1;
		\Cache::put('ssrdataib'.$request->TraceId.$request->ResultIndexR, $resultib , now()->addMinutes(15));
			if(@$ssrdataib->Response->Error->ErrorCode == 0 && @$ssrdataib->Response->Baggage !== null){
			//echo '<pre>'; print_r($ssrdataib);
				foreach(@$ssrdataib->Response->Baggage as $key => $bsslist){ 
					$inwardflight = @$ssrdataib->Response->Baggage[$key][0]->Origin. ' - ' .@$ssrdataib->Response->Baggage[$key][0]->Destination;
					
				
					foreach(@$bsslist as $b_list){
						if($b_list->Code != 'NoBaggage'){
							
							$inwardbaggagessr[] = array(
								'key' => $b_list->Weight.'@^@Direct_'.$b_list->Code,
								'price' => $b_list->Price,
								'Weight' => $b_list->Weight,
								'value' => $b_list->Weight.'-Kg Rs.-'.$b_list->Price.'-Checked Baggage'.$b_list->Weight.'Kg'
							);
						}
					}
				}
			}else{
				$inwardbaggagessr[] = array(
					'key' => '0@^@Direct_NONE',
					'value' => 'No Excess/Extra Baggage'
				);
			}
			
			if(@$ssrdataib->Response->Error->ErrorCode == 0 && @$ssrdataib->Response->MealDynamic !== null){
			foreach(@$ssrdataib->Response->MealDynamic as $key => $mlist){ 
				foreach(@$mlist as $m_list){
					if($m_list->Code != 'NoMeal'){
						
						$inwardmealssr[$m_list->Origin.'-'.$m_list->Destination][] = array(
							'key' => $m_list->Code.'@^@'.$m_list->Price,
							'price' => $m_list->Price,
							'AirlineDescription' => $m_list->AirlineDescription,
							'value' => $m_list->AirlineDescription.' Rs.-'.$m_list->Price
						);
						
					}
				}
			}
		}else{
			$inwardmealssr[] = array(
				'key' => 'NONE@^@0',
				'value' => 'Add No Meal Rs.-0'
			);
		}
		
		
		if(@$ssrdataib->Response->Error->ErrorCode == 0 && @$ssrdataib->Response->SeatDynamic !== null){
			foreach(@$ssrdataib->Response->SeatDynamic as $keys => $seatlist){ 
				foreach(@$seatlist->SegmentSeat as $keya => $seat_list){
					$inwardseatssr = '';
					$inwardflightcode = @$seat_list->RowSeats[0]->Seats[0]->AirlineCode.'|'.@$seat_list->RowSeats[0]->Seats[0]->FlightNumber; 
					foreach(@$seat_list->RowSeats as $keyb => $row_list){
						
						$inwardseatssr .= '<tr>';
						foreach($row_list->Seats as $keyse => $slist){
							if($slist->Code != 'NoSeat'){
								$seatselected = 'Open';
								if($slist->AvailablityType == 3){
									$seatselected = 'occupied';
								}
								if($keyse == 3){
								$inwardseatssr .= '<td class="seat_space"></td>';
								}
								
								$inwardseatssr .= '<td id="FlSeat_1_Seg_'.$keya.'_Row_'.$keyb.'_Seat_'.$keyse.'" seatprice="'.$slist->Price.'" seatcode="'.$slist->Code.'" ><span class="ytfi-seat '.$seatselected.'">'.$slist->Code.'</span><div class="seatdetails" id="FlSeatInfo_1_Seg_'.$keya.'_Row_'.$keyb.'_Seat_'.$keyse.'" style="display: none;">
									<ul class="seatinfo">
                                    <li>Seat No : '.$slist->Code.'</li>

                                    
                                    <li id="StPrc_1_Seg_'.$keya.'_Row_'.$keyb.'_Seat_'.$keyse.'">Price : Rs. '.$slist->Price.'</li>
                                   
                                    
                                </ul>
                            </div></td>';
								
							}
						}
						$inwardseatssr .= '</tr>';
					}
					$inwardseatSEGMRNTssr[$keya] = $inwardseatssr;
				}
			}
		}else{ 
			$inwardseatSEGMRNTssr ='';
		}
		
		}
		$onwardbaggagessr = array();
		$onwardflight = '';
		//$inwardbaggagessr = array();
		if(@$ssrdata->Response->Error->ErrorCode == 0 && @$ssrdata->Response->Baggage !== null){
			//echo '<pre>'; print_r(@$ssrdata->Response->Baggage);
			foreach(@$ssrdata->Response->Baggage as $key => $bsslist){ 
				$onwardflight = @$ssrdata->Response->Baggage[$key][0]->Origin. ' - ' .@$ssrdata->Response->Baggage[$key][0]->Destination;
				
			
				foreach(@$bsslist as $b_list){
					if($b_list->Code != 'NoBaggage'){
					
						$onwardbaggagessr[] = array(
							'key' => $b_list->Weight.'@^@Direct_'.$b_list->Code,
							'price' => $b_list->Price,
								'Weight' => $b_list->Weight,
							'value' => $b_list->Weight.'-Kg Rs.-'.$b_list->Price.'-Checked Baggage'.$b_list->Weight.'Kg'
						);
					}
				}
			}
		}else{
			$onwardbaggagessr[] = array(
				'key' => '0@^@Direct_NONE',
				'value' => 'No Excess/Extra Baggage'
			);
		}
		
		
		$onwardmealssr = array();
		//$inwardmealssr = array();
		//print_r($ssrdata);
		if(@$ssrdata->Response->Error->ErrorCode == 0 && @$ssrdata->Response->MealDynamic !== null){
			foreach(@$ssrdata->Response->MealDynamic as $key => $mlist){ 
				foreach(@$mlist as $m_list){
					if($m_list->Code != 'NoMeal'){

						$onwardmealssr[$m_list->Origin.'-'.$m_list->Destination][] = array(
							'key' => $m_list->Code.'@^@'.$m_list->Price,
							'price' => $m_list->Price,
							'AirlineDescription' => $m_list->AirlineDescription,
							'value' => $m_list->AirlineDescription.' Rs.-'.$m_list->Price
						);
					}
				}
			}
		}else{
			$onwardmealssr[] = array(
				'key' => 'NONE@^@0',
				'value' => 'Add No Meal Rs.-0'
			);
		}
		$onwardseatssr = '';
		$onwardseatSEGMRNTssr = array();
		$onwardflightcode = '';
	//print_r(@$ssrdata->Response->SeatDynamic);
		if(@$ssrdata->Response->Error->ErrorCode == 0 && @$ssrdata->Response->SeatDynamic !== null){
			foreach(@$ssrdata->Response->SeatDynamic as $keys => $seatlist){ 
				foreach(@$seatlist->SegmentSeat as $keya => $seat_list){
					$onwardseatssr = '';
					$onwardflightcode = @$seat_list->RowSeats[0]->Seats[0]->AirlineCode.'|'.@$seat_list->RowSeats[0]->Seats[0]->FlightNumber; 
					foreach(@$seat_list->RowSeats as $keyb => $row_list){
						
						$onwardseatssr .= '<tr>';
						foreach($row_list->Seats as $keyse => $slist){
							if($slist->Code != 'NoSeat'){
								$seatselected = 'Open';
								if($slist->AvailablityType == 3){
									$seatselected = 'occupied';
								}
								if($keyse == 3){
								$onwardseatssr .= '<td class="seat_space"></td>';
								}
								
								$onwardseatssr .= '<td id="FlSeat_'.$keys.'_Seg_'.$keya.'_Row_'.$keyb.'_Seat_'.$keyse.'" seatprice="'.$slist->Price.'" seatcode="'.$slist->Code.'" ><span class="ytfi-seat '.$seatselected.'">'.$slist->Code.'</span><div class="seatdetails" id="FlSeatInfo_'.$keys.'_Seg_'.$keya.'_Row_'.$keyb.'_Seat_'.$keyse.'" style="display: none;">
									<ul class="seatinfo">
                                    <li>Seat No : '.$slist->Code.'</li>

                                    
                                    <li id="StPrc_'.$keys.'_Seg_'.$keya.'_Row_'.$keyb.'_Seat_'.$keyse.'">Price : Rs. '.$slist->Price.'</li>
                                   
                                    
                                </ul>
                            </div></td>';
								
							}
						}
						$onwardseatssr .= '</tr>';
					}
					$onwardseatSEGMRNTssr[$keya] = $onwardseatssr;
				}
			}
		}else{ 
			$onwardseatSEGMRNTssr ='';
		}
		//echo '<pre>'; print_r($ssrdata); echo '<pre>';
		
		echo json_encode(array('success' => true, 'onwardbaggagessr' => $onwardbaggagessr, 'inwardbaggagessr' => $inwardbaggagessr, 'onwardmealssr' => $onwardmealssr, 'inwardmealssr' => $inwardmealssr,'onwardflight'=> $onwardflight, 'inwardflight' => $inwardflight, 'onwardseatssr' => $onwardseatSEGMRNTssr, 'onwardflightcode' => $onwardflightcode, 'inwardseatssr' => $inwardseatSEGMRNTssr, 'inwardflightcode' => $inwardflightcode));
		exit;
		//return view('Frontend.flights.ssr', compact(['ssrdata','ssrdataib','is_return'])); 
	}
	
	public function bookingerror(Request $request){
		return view('Agent.flights.error'); 
	}
	public function ticket(Request $request){
		$flghtapi = WebsiteSetting::where('id', '!=', '')->first();
		if($flghtapi->disable_booking == 1){
			return Redirect::to('/agent/booking-failure');
		}
		$pessager = Session::get('pessager');
		 //print_r($pessager); die;
		$auth = $this->GetAgentAuthenticate();
		 
		if (\Cache::has('farequoteob'.$pessager['hfTraceId'].$pessager['hfRIndex'])){
					$result = \Cache::get( 'farequoteob'.$pessager['hfTraceId'].$pessager['hfRIndex']);
			}else{
				$booking_id = Session::get('booking_id');
			$payment_id = Session::get('payment_id');
			$user_id = Session::get('useridd');
				$bookingdetail = BookingDetail::find($booking_id);
				$bookingdetail->user_id = @$user_id;
				$bookingdetail->status = 2;
				
				$bookingdetail->booking_response = json_encode(array('message' => 'Your session (TraceId) is expired.'));
				$saved = $bookingdetail->save();
				
				
				$payment = PaymentDetail::find($payment_id);
				$payment->status = 1;
				$payment->save();
				$message = "Dear Admin, {name} has trying to book a  ticket from {source} to {destination} but failed. Refrence Id is {bookingid}. For more bookings please visit {URL}. Thank you.";
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
				return Redirect::to('/agent/booking/error')->with('error', 'Your session (TraceId) is expired.');
		}
		
		$resultdata = json_decode($result);
		
		if($resultdata->Response->Error->ErrorCode != 0){
			$booking_id = Session::get('booking_id');
			$payment_id = Session::get('payment_id');
			$user_id = Session::get('useridd');
				$bookingdetail = BookingDetail::find($booking_id);
				$bookingdetail->user_id = @$user_id;
				$bookingdetail->status = 2;
				
				$bookingdetail->booking_response = $result;
				$saved = $bookingdetail->save();
				
				
				/* $payment = PaymentDetail::find($payment_id);
				$payment->status = 3;
				$payment->save(); */
				$message = "Dear Admin, {name} has trying to book a  ticket from {source} to {destination} but failed. Refrence Id is {bookingid}. For more bookings please visit {URL}. Thank you.";
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
				return Redirect::to('/agent/booking/error')->with('error', $resultdata->Response->Error->ErrorMessage);
		}else{	
		//echo '<pre>'; print_r($pessager);
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
			  "Gender": '.$gender.',';
			   if((isset($pessager['airasia']) && $pessager['airasia'] == 1) || ($pessager['IsIntr'] == 1 || $pessager['IsIntr'] == 'true')){
						$chexp = explode('/',$pessager['adultdob'][$ics]);
						$dataaadult = $chexp[2].'-'.$chexp[1].'-'.$chexp[0].'T00:00:00';
						$result_data .=	'"DateOfBirth": "'.$dataaadult.'",';
					}
				
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
				"ContactNo": "'.str_replace(' ', '', $pessager['phone']).'",
				"Email": "'.$pessager['email'].'",
				"IsLeadPax": '.$IsLeadPax.',
				"FFAirline": "",
				"FFNumber": "",';
				if($resultdata->Response->Results->IsGSTMandatory == true && $ics == 0){
					 $result_data .='"GSTCompanyAddress": "F111/112 North Square Mall, Delhi",
					"GSTCompanyContactNumber": "1147262626",
					"GSTCompanyName": "Holiday Planner PRIVATE LIMITED",
					"GSTNumber": "07AAACZ3593Q1ZI",
					"GSTCompanyEmail": "info@zapbooking.com",';
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
			
					if (\Cache::has('ssrob'.$pessager['hfTraceId'].$pessager['hfRIndex'])){
						
						
						//print_r($dep_baggage);
							$ssrresult = \Cache::get( 'ssrob'.$pessager['hfTraceId'].$pessager['hfRIndex']);
							
							$ssrresultdata = json_decode($ssrresult);
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
					if($pessager['childtitle'][$ics] == 'Mstr'){
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
				"ContactNo": "'.str_replace(' ', '', $pessager['phone']).'",
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
					if($pessager['infanttitle'][$ics] == 'Mstr'){
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
			"ContactNo": "'.str_replace(' ', '', $pessager['phone']).'",
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
		$result_data .='"EndUserIp": "103.138.188.143",
			"TokenId": "'.$auth->TokenId.'",
			"TraceId": "'.$pessager['hfTraceId'].'"
			}'; 
	//echo $result_data; die;
	$log = ['email' => @$pessager['email'],
        'description' => $result_data];
			$orderLog = new Logger('bookrequest');
	$orderLog->pushHandler(new StreamHandler(storage_path('logs/bookrequest.log')), Logger::INFO);
	$orderLog->info('BookRequest', $log);

	if($resultdata->Response->Results->IsLCC ==1){
		if($flghtapi->agent_flight_api_type == 1){
			$urlsew= "https://booking.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/Ticket";
		}else{
			$urlsew= "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/Ticket";
		}
		//echo $urlsew; die;
		$result = $this->postcurlRequest($urlsew,$result_data);
	}else{
		if($flghtapi->agent_flight_api_type == 1){
			$urlbook= "https://booking.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/Book";
		}else{
			$urlbook= "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/Book";
		}
		//echo $urlbook; die;
		$resultbook = $this->postcurlRequest($urlbook,$result_data); 
		$bookdetail = json_decode($resultbook);
		$log = ['email' => @$pessager['email'],
        'description' => $bookdetail];

			//first parameter passed to Monolog\Logger sets the logging channel name
				$orderLog = new Logger('bookorder');
				$orderLog->pushHandler(new StreamHandler(storage_path('logs/bookorder.log')), Logger::INFO);
				$orderLog->info('BookOrderLog', $log);
				if($bookdetail->Response->ResponseStatus != 1 && $bookdetail->Response->Error->ErrorCode !=0){
					$booking_id = Session::get('booking_id');
						$payment_id = Session::get('payment_id');
						$user_id = Session::get('useridd');
							$bookingdetail = BookingDetail::find($booking_id);
							$bookingdetail->user_id = @$user_id;
							$bookingdetail->status = 2;
							
							$bookingdetail->booking_response = $resultbook;
							$saved = $bookingdetail->save();
							
							
							/* $payment = PaymentDetail::find($payment_id);
							$payment->status = 3;
							$payment->save(); */
							$message = "Dear Admin, {name} has trying to book a  ticket from {source} to {destination} but failed. Refrence Id is {bookingid}. For more bookings please visit {URL}. Thank you.";
							//$this->AdminPhoneBookingTicket($booking_id, $message);
					Session::forget('pessager');
					Session::forget('TokenId');
					Session::forget('booking_id');
					Session::forget('payment_id');
					Session::forget('useridd');
					Session::forget('origin');
					Session::forget('destination');
					Session::forget('from_date');
					Session::forget('to_date');
					return Redirect::to('/agent/booking/error')->with('error', $bookdetail->Response->Error->ErrorMessage);
					exit;
				}
					//echo '<pre>'; print_r($bookdetail); die;
					if($flghtapi->agent_flight_api_type == 1){
						$urlsew= "https://booking.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/Ticket";
					}else{
						$urlsew= "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/Ticket";
					}
					//echo $urlsew; die;
					$result_data = '{
							"EndUserIp": "103.138.188.143",
							"TokenId": "'.$auth->TokenId.'",
							"TraceId": "'.$pessager['hfTraceId'].'",
						  "PNR": "'.$bookdetail->Response->Response->PNR.'",
						  "BookingId": '.$bookdetail->Response->Response->BookingId.'
						}';
					$result = $this->postcurlRequest($urlsew,$result_data);
					
					$logss = ['email' => @$pessager['email'],'description' => $result_data];

			//first parameter passed to Monolog\Logger sets the logging channel name
			$orderLogs = new Logger('ticketorder');
			$orderLogs->pushHandler(new StreamHandler(storage_path('logs/ticket.log')), Logger::INFO);
			$orderLogs->info('TicketOrderLog', $logss);
	}
		 
	$log = ['email' => @$pessager['email'],'description' => $result];

			//first parameter passed to Monolog\Logger sets the logging channel name
			$orderLog = new Logger('order');
			$orderLog->pushHandler(new StreamHandler(storage_path('logs/order.log')), Logger::INFO);
			$orderLog->info('OrderLog', $log);
					$ssrdata = json_decode($result); 
			if($flghtapi->agent_flight_api_type == 1){
				$urlbooksew= "https://booking.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/GetBookingDetails";
			}else{
				$urlbooksew= "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/GetBookingDetails";
			}
			
				$bookdetailresult_data = '{
				"EndUserIp": "103.138.188.143",
				"TokenId": "'.$auth->TokenId.'",
				"PNR": "'.@$ssrdata->Response->Response->PNR.'",
				"BookingId": '.@$ssrdata->Response->Response->BookingId.'
				}';
				$bookideob = $this->postcurlRequest($urlbooksew,$bookdetailresult_data);

	$logob = ['email' => @$pessager['email'],'request' => $bookdetailresult_data, 'description' => $bookideob];
			$orderLogob = new Logger('getbookrequestib');
			$orderLogob->pushHandler(new StreamHandler(storage_path('logs/getbookobrequest.log')), Logger::INFO);
			$orderLogob->info('GetBookRequestIb', $logob);	
		
		if($ssrdata->Response->ResponseStatus == 1 && $ssrdata->Response->Error->ErrorCode ==0){
			$policy = '';
			if(@$pessager['is_travelinsurance'] == 1){
			$response = $this->GetissuePolicy($pessager);
				$policy = @$response->pWeoTrvProcessPolicyIn_inout->policyNo;
				$res = $this->GetPolicyToken(); 
		$re = json_decode($res, TRUE);
		//echo '<pre>'; print_r($re); die;
		//echo $re['access_token'];
		if(isset($re['access_token'])){
		$r = $this->GetPolicyImage($re['access_token'],$policy); 
		$i = json_decode($r);
		
		$b64 = $i->downloadedPdf;

		
		
//Decode pdf content
				$pdf_decoded = base64_decode ($b64);
				//Write data back to pdf file
				$pdf = fopen (Config::get('constants.policy').$policy.'.pdf','w');
				fwrite ($pdf,$pdf_decoded);
				//close output file
				fclose ($pdf);

		}
			}
				$booking_id = Session::get('booking_id');
				$payment_id = Session::get('payment_id');
				$user_id = Session::get('useridd');
				$bookingdetail = BookingDetail::find($booking_id);
				$bookingdetail->user_id = @$user_id;
				$bookingdetail->pnr = $ssrdata->Response->Response->PNR;
				$bookingdetail->booking_id = $ssrdata->Response->Response->BookingId;
				$bookingdetail->trace_id = $ssrdata->Response->TraceId;
				
				$bookingdetail->booking_response = $result;
				$bookingdetail->policy = $policy;
				$bookingdetail->status = 1;
				$bookingdetail->ticket_status = $ssrdata->Response->Response->TicketStatus;
				$saved = $bookingdetail->save();
				
				
				$payment = PaymentDetail::find($payment_id);
				$payment->status = 1;
				$payment->save();
				if($saved){
					$fetchedData = BookingDetail::where('id',$booking_id)->with(['user'])->first();
					$pdf = PDF::setOptions([
				'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
				'logOutputFile' => storage_path('logs/log.htm'),
				'tempDir' => storage_path('logs/')
				])->loadView('emails.ticket', compact('fetchedData'));
				$output = $pdf->output();
				$set = Admin::where('id',1)->first();
				$invoicefilename = $set->ref_prefix.'-'.$fetchedData->id.'-'.$fetchedData->pnr.'.pdf';
				file_put_contents('/home/zapbooking/public_html/public/invoices/'.$invoicefilename, $output);
				$array['file'] = '/home/zapbooking/public_html/public/invoices/'.$invoicefilename;
				$array['file_name'] = $invoicefilename;
				$booking = json_decode($fetchedData->booking_response);
				$Flight_Name = @$booking->Response->Response->FlightItinerary->Segments[0]->Airline->AirlineName;
				$DATE = date('d/m/Y',strtotime(@$booking->Response->Response->FlightItinerary->Segments[0]->Origin->DepTime));
				$subject = $Flight_Name." Booking PNR ". $fetchedData->pnr.": ".$DATE." ".@$booking->Response->Response->FlightItinerary->Segments[0]->Origin->Airport->CityName."-".@$booking->Response->Response->FlightItinerary->Segments[$tr]->Destination->Airport->CityName." for ".@$pessager['adulttitle'][0]." ".@$pessager['adultfirstname'][0]." ".@$pessager['adultlastname'][0];
				
					// Mail::to(@$pessager['email'])->send(new TicketMail($fetchedData, $subject, $set->primary_email, $array));
					//  Mail::to($set->primary_email)->cc('mukesh@zapbooking.com')->send(new TicketMail($fetchedData, $subject, $set->primary_email, $array));
					 unlink($array['file']);
					 if(@Auth::user()){
					 }else{
						 
						 $customer = User::where('id', '=', $user_id)->first();
							DB::table('password_resets')->insert([
								'email' => $customer->email,
								'token' => str_random(60),
								'created_at' => Carbon::now()
							]);
							//Get the token just created above
							$tokenData = DB::table('password_resets')
								->where('email', $customer->email)->first();
								 $this->sendPasswordEmail($customer->email, $tokenData->token);
								 }
					
					 /*SMS */
				$phone = str_replace(' ', '', $pessager['phone']);
					$fetchedData = BookingDetail::where('id',$fetchedData->id)->with(['user'])->first();
					$name=@$fetchedData->user->title.' '.@$fetchedData->user->first_name.' '.$fetchedData->user->last_name;
						$authkey = MyConfig::where('meta_key','web2sms_auth_key')->first()->meta_value;
						$senderid = MyConfig::where('meta_key','web2sms_senderid')->first()->meta_value;
						$routeid = MyConfig::where('meta_key','web2sms_routeid')->first()->meta_value;
						$url = MyConfig::where('meta_key','web2sms_gateway_url')->first()->meta_value;
						$smscontent = MyConfig::where('meta_key','web2sms_smscontent')->first()->meta_value;
						
						$replacesub = array('{name}', '{source}', '{destination}', '{PNR}', '{BookingID}', '{URL}');					
						$replace_with_sub = array(@$name, @$fetchedData->source, @$fetchedData->destination, @$fetchedData->pnr, $set->ref_prefix.'-'.$fetchedData->id, \URL::to('/'));
						$subContent	=	str_replace($replacesub,$replace_with_sub,$smscontent);
						
						$message =$subContent;
						if(MyConfig::where('meta_key','msg_status')->first()->meta_value == 'msgnine'){
							$authkey = MyConfig::where('meta_key','msg_authkey')->first()->meta_value;
						$senderid = MyConfig::where('meta_key','msg_senderid')->first()->meta_value;
						$routeid = MyConfig::where('meta_key','msg_otptemplate_id')->first()->meta_value;
						$url = MyConfig::where('meta_key','msg_gateway_url')->first()->meta_value;
						$mobileNumber = "91".$phone;
						$senderId = "ZAPFLI";
						$message = urlencode($message);
						$route = "4";
						$postData = array(
							'mobiles' => $mobileNumber,
							'message' => $message,
							'sender' => $senderId,
							'route' => $route
						);
						$url="http://api.msg91.com/api/v2/sendsms";


						$curl = curl_init();
						curl_setopt_array($curl, array(
							CURLOPT_URL => "$url",
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_CUSTOMREQUEST => "POST",
							CURLOPT_POSTFIELDS => $postData,
							CURLOPT_HTTPHEADER => array(
								"authkey: ".$authkey,
								"content-type: multipart/form-data"
							),
						));

						$response = curl_exec($curl);

						$err = curl_error($curl);

						curl_close($curl);

			if ($err) {
			// echo json_encode(array('success' =>false,'message'=>$err));
			} else {
			 // echo json_encode(array('success' =>true,'message'=>$response));
			}
						}else{
						//echo  $url."?AUTH_KEY=".$authkey."&message=".$message."&senderId=".$senderid."&routeId=".$routeid."&mobileNos=".$phone."&smsContentType=english";
						$curl = curl_init();

						curl_setopt_array($curl, array(
				
						  CURLOPT_URL => $url."?AUTH_KEY=".$authkey."&message=".$message."&senderId=".$senderid."&routeId=".$routeid."&mobileNos=".$phone."&smsContentType=english",
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => "",
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 30,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => "GET",
						  CURLOPT_HTTPHEADER => array(
							"Cache-Control: no-cache"
						  ),
						));

						$response = curl_exec($curl);
						$err = curl_error($curl);

						curl_close($curl);

						if ($err) {
						 $message =  $err;
						} else {
						  $message =  $response;
						  $success = true;
						}
				}
				/*SMS */
				$pd = 1;
				$message = "Dear Admin, '{name}' have successfully booked a flight ticket from {source} to {destination}. PNR is '{PNR}' and Holiday Planner Id is '{BookingID}'. {travel_date} and {flight_name} For more bookings please visit {URL}. Thank you.";
				//$this->AdminPhoneBookingTicket($booking_id, $message,$pd);
					Session::forget('pessager');
					Session::forget('TokenId');
					Session::forget('booking_id');
					Session::forget('payment_id');
					Session::forget('useridd');
					Session::forget('origin');
					Session::forget('destination');
					Session::forget('from_date');
					Session::forget('to_date');
					return Redirect::to('/agent/booking/success/'.base64_encode(convert_uuencode(@$bookingdetail->id)));
				}else{
					return redirect()->back()->with('error', Config::get('constants.server_error'));
				}
			
		}else{
			$booking_id = Session::get('booking_id');
			$payment_id = Session::get('payment_id');
			$user_id = Session::get('useridd');
				$bookingdetail = BookingDetail::find($booking_id);
				$bookingdetail->user_id = @$user_id;
				$bookingdetail->status = 2;
				$bookingdetail->booking_response = $result;
				$saved = $bookingdetail->save();
				
				
				/* $payment = PaymentDetail::find($payment_id);
				$payment->status = 3;
				$payment->save(); */
				$message = "Dear Admin, {name} has trying to book a  ticket from {source} to {destination} but failed. Refrence Id is {bookingid}. For more bookings please visit {URL}. Thank you.";
				//$this->AdminPhoneBookingTicket($booking_id, $message);
		Session::forget('pessager');
		Session::forget('TokenId');
		Session::forget('booking_id');
		Session::forget('payment_id');
		Session::forget('useridd');
		Session::forget('origin');
		Session::forget('destination');
		Session::forget('from_date');
		Session::forget('to_date');
			//echo '<pre>'; print_r($ssrdata);
			 /* if($pessager['IsIntr'] == 1 || $pessager['IsIntr'] == 'true'){
						 if(isset($pessager['isReturn']) && $pessager['isReturn'] == 'true'){
							  return Redirect::to('/Review/Checkout?tid='.$pessager['hfTraceId'].'&RIndex='.$pessager['hfRIndex'].'&isINT=true&IsReturn=true')->with('error', $bookdetail->Response->Error->ErrorMessage);
						 }else{ 
							  return Redirect::to('/Review/Checkout?tid='.$pessager['hfTraceId'].'&RIndex='.$pessager['hfRIndex'].'&isINT=true&IsReturn=false')->with('error', $bookdetail->Response->Error->ErrorMessage);
						 }
					 }else{
			return Redirect::to('/Review/Checkout?tid='.$pessager['hfTraceId'].'&RIndex='.$pessager['hfRIndex'].'&isINT='.$pessager['IsIntr'])->with('error', @$ssrdata->Response->Error->ErrorMessage);
					 } */
					 
					return Redirect::to('/agent/booking/error')->with('error', @$ssrdata->Response->Error->ErrorMessage);	 
		} 
		}
	}
	
	public function Returnticket(Request $request){
		$flghtapi = WebsiteSetting::where('id', '!=', '')->first();
		if($flghtapi->disable_booking == 1){
			return Redirect::to('/agent/booking-failure');
		}
		$pessager = Session::get('pessager');
		
		$auth = $this->GetAgentAuthenticate();
		
		if($pessager['IsReturn'] == 1){
			if (\Cache::has('farequoteob'.$pessager['hfTraceId'].$pessager['hfRIndex'])){
					$result = \Cache::get( 'farequoteob'.$pessager['hfTraceId'].$pessager['hfRIndex']);
			}else{
				
				$booking_id = Session::get('booking_id');
			$payment_id = Session::get('payment_id');
			$user_id = Session::get('useridd');
				$bookingdetail = BookingDetail::find($booking_id);
				$bookingdetail->user_id = @$user_id;
				$bookingdetail->status = 2;
				
				$bookingdetail->booking_response = json_encode(array('message' => 'Your session (TraceId) is expired.'));
				$saved = $bookingdetail->save();
				
				
				$payment = PaymentDetail::find($payment_id);
				$payment->status = 1;
				$payment->save();
				$message = "Dear Admin, {name} has trying to book a  ticket from {source} to {destination} but failed. Refrence Id is {bookingid}. For more bookings please visit {URL}. Thank you.";
			//	$this->AdminPhoneBookingTicket($booking_id, $message);
				Session::forget('pessager');
				Session::forget('TokenId');
				Session::forget('booking_id');
				Session::forget('payment_id');
				Session::forget('useridd');
				Session::forget('origin');
				Session::forget('destination');
				Session::forget('from_date');
				Session::forget('to_date');
				
				return Redirect::to('/agent/booking/error')->with('error', 'Your session (TraceId) is expired.');
			}
			
			$resultdata = json_decode($result);
			
			if (\Cache::has('farequoteib'.$pessager['hfTraceId'].$pessager['hfIBRIndex'])){
					$resultib = \Cache::get( 'farequoteib'.$pessager['hfTraceId'].$pessager['hfIBRIndex']);
			}else{
				$booking_id = Session::get('booking_id');
			$payment_id = Session::get('payment_id');
			$user_id = Session::get('useridd');
				$bookingdetail = BookingDetail::find($booking_id);
				$bookingdetail->user_id = @$user_id;
				$bookingdetail->status = 2;
				
				$bookingdetail->booking_response = json_encode(array('message' => 'Your session (TraceId) is expired.'));
				$saved = $bookingdetail->save();
				
				
				$payment = PaymentDetail::find($payment_id);
				$payment->status = 1;
				$payment->save();
				$message = "Dear Admin, {name} has trying to book a  ticket from {source} to {destination} but failed. Refrence Id is {bookingid}. For more bookings please visit {URL}. Thank you.";
			//	$this->AdminPhoneBookingTicket($booking_id, $message);
				Session::forget('pessager');
				Session::forget('TokenId');
				Session::forget('booking_id');
				Session::forget('payment_id');
				Session::forget('useridd');
				Session::forget('origin');
				Session::forget('destination');
				Session::forget('from_date');
				Session::forget('to_date');
				return Redirect::to('/agent/booking/error')->with('error', 'Your session (TraceId) is expired.');
			}
			$resultdataib = json_decode($resultib);
		}else{
			if (\Cache::has('farequoteob'.$pessager['hfTraceId'].$pessager['hfRIndex'])){
					$result = \Cache::get( 'farequoteob'.$pessager['hfTraceId'].$pessager['hfRIndex']);
			}else{
		$booking_id = Session::get('booking_id');
			$payment_id = Session::get('payment_id');
			$user_id = Session::get('useridd');
				$bookingdetail = BookingDetail::find($booking_id);
				$bookingdetail->user_id = @$user_id;
				$bookingdetail->status = 2;
				
				$bookingdetail->booking_response = json_encode(array('message' => 'Your session (TraceId) is expired.'));
				$saved = $bookingdetail->save();
				
				
				$payment = PaymentDetail::find($payment_id);
				$payment->status = 1;
				$payment->save();
				$message = "Dear Admin, {name} has trying to book a  ticket from {source} to {destination} but failed. Refrence Id is {bookingid}. For more bookings please visit {URL}. Thank you.";
				//$this->AdminPhoneBookingTicket($booking_id, $message);
				Session::forget('pessager');
				Session::forget('TokenId');
				Session::forget('booking_id');
				Session::forget('payment_id');
				Session::forget('useridd');
				Session::forget('origin');
				Session::forget('destination');
				Session::forget('from_date');
				Session::forget('to_date');
				return Redirect::to('/agent/booking/error')->with('error', 'Your session (TraceId) is expired.');
			}
			
			$resultdata = json_decode($result);
		}
		
		if($resultdata->Response->Error->ErrorCode != 0 || $resultdataib->Response->Error->ErrorCode != 0){
			$booking_id = Session::get('booking_id');
			$payment_id = Session::get('payment_id');
			$user_id = Session::get('useridd');
				$bookingdetail = BookingDetail::find($booking_id);
				$bookingdetail->user_id = @$user_id;
				
				$bookingdetail->booking_response = $result;
				$saved = $bookingdetail->save();
				
				
				/* $payment = PaymentDetail::find($payment_id);
				$payment->status = 3;
				$payment->save(); */
				$message = "Dear Admin, {name} has trying to book a  ticket from {source} to {destination} but failed. For more bookings please visit {URL}. Thank you.";
				//$this->AdminPhoneBookingTicket($booking_id, $message);
				Session::forget('pessager');
				Session::forget('TokenId');
				Session::forget('booking_id');
				Session::forget('payment_id');
				Session::forget('useridd');
				Session::forget('origin');
				Session::forget('destination');
				Session::forget('from_date');
				Session::forget('to_date');
			//	echo $resultdata->Response->Error->ErrorMessage.'eeeee'; die;
				return Redirect::to('/agent/booking/error')->with('error', $resultdata->Response->Error->ErrorMessage);
		}else{	
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
		
	 $result_data .=	'{
			  "Title": "'.$pessager['adulttitle'][$ics].'",
			  "FirstName": "'.$pessager['adultfirstname'][$ics].'",
			  "LastName": "'.$pessager['adultlastname'][$ics].'",
			  "PaxType": '.$farebrakdowna[$ic]->PassengerType.',
			  
			  "Gender": '.$gender.',';
			 if((isset($pessager['airasia']) && $pessager['airasia'] == 1) || ($pessager['IsIntr'] == 1 || $pessager['IsIntr'] == 'true')){
						$chexp = explode('/',$pessager['adultdob'][$ics]);
						$dataaadult = $chexp[2].'-'.$chexp[1].'-'.$chexp[0].'T00:00:00';
						$result_data .=	'"DateOfBirth": "'.$dataaadult.'",';
					}
			   if($pessager['IsIntr'] == 1 || $pessager['IsIntr'] == 'true'){
					$result_data .=	'"PassportNo": "'.$adultpassportno.'",';
					$result_data .=	'"PassportExpiry": "'.$adultpassportdate.'",';
			  }
			  $result_data .=	'"AddressLine1": "123 test",
			  "AddressLine2": "",
			   "City": "Gurgaon",
				"CountryCode": "IN",
				"CountryName": "India",
				"ContactNo": "'.str_replace(' ', '', $pessager['phone']).'",
				"Email": "'.$pessager['email'].'",
				"IsLeadPax": '.$IsLeadPax.',
				"FFAirline": "",
				"FFNumber": "",
				"Nationality": "IN",';
				if($resultdata->Response->Results->IsGSTMandatory == true && $ics == 0){
					 $result_data .='"GSTCompanyAddress": "F111/112 North Square Mall, Delhi",
					"GSTCompanyContactNumber": "1147262626",
					"GSTCompanyName": "Holiday Planner PRIVATE LIMITED",
					"GSTNumber": "07AAACZ3593Q1ZI",
					"GSTCompanyEmail": "info@zapbooking.com",';
				}
			   $result_data .='"Fare": {
				"BaseFare": '.number_format($fareprice, 2, '.', '').',
				"Tax": '.number_format($faretax, 2, '.', '').',
				"YQTax": '.number_format($yqtax, 2, '.', '').',
				"AdditionalTxnFeeOfrd": 0.0,
				"AdditionalTxnFeePub": 0.0,
				"PGCharge": 0.0
			  }';
			  if (\Cache::has('ssrob'.$pessager['hfTraceId'].$pessager['hfRIndex'])){	
				$ssrresult = \Cache::get( 'ssrob'.$pessager['hfTraceId'].$pessager['hfRIndex']);
				$ssrresultdata = json_decode($ssrresult);
				//echo '<pre>'; print_r($pessager);
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
		 $result_data .='},'; 
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
					
					if($pessager['childtitle'][$ics] == 'Mstr'){
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
					//echo '2'.$farebrakdowna[$ic]->PassengerCount.'<br>';
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
			 $result_data .= '"AddressLine1": "123 test",
			  "AddressLine2": "",
			  "City": "Gurgaon",
				  "CountryCode": "IN",
				  "CountryName": "India",
				  "ContactNo": "'.str_replace(' ', '', $pessager['phone']).'",
				  "Email": "'.$pessager['email'].'",
				  "IsLeadPax": false,
				  "FFAirline": "",
				  "FFNumber": "",
				  "Nationality": "IN",
			   "Fare": {
				"BaseFare": '.$fareprice.',
				"Tax": '.$faretax.',
				"YQTax": '.$yqtax.',
				"AdditionalTxnFeeOfrd": 0,
				"AdditionalTxnFeePub": 0,
				"PGCharge": 0
			  }';  
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
					
					if($pessager['infanttitle'][$ics] == 'Mstr'){
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
				  "ContactNo": "'.str_replace(' ', '', $pessager['phone']).'",
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
		$result_data .='"EndUserIp": "103.138.188.143",
			"TokenId": "'.$auth->TokenId.'",
			"TraceId": "'.$pessager['hfTraceId'].'"
			}'; 
			/*OB end*/
			/* IB */
			
			$farebrakdownr = $resultdataib->Response->Results->FareBreakdown;
		  $result_dataib = '{
			"ResultIndex": "'.$pessager['hfIBRIndex'].'",
			"Passengers": [';
						for($ic=0;$ic<count($farebrakdownr);$ic++){
				for($ics=0;$ics < $farebrakdownr[$ic]->PassengerCount; $ics++){

				if($farebrakdownr[$ic]->PassengerType == 1){
					if($farebrakdownr[$ic]->BaseFare == 0){
						$fareprice = 0;
					}else{
						$fareprice = $farebrakdownr[$ic]->BaseFare / $farebrakdownr[$ic]->PassengerCount;
					}
					if($farebrakdownr[$ic]->Tax == 0){
						$faretax = 0;
					}else{
						$faretax = $farebrakdownr[$ic]->Tax / $farebrakdownr[$ic]->PassengerCount;
					}
					
					if($farebrakdownr[$ic]->YQTax == 0){
						$yqtax = 0;
					}else{
						$yqtax = $farebrakdownr[$ic]->YQTax;
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
	 $result_dataib .=	'{
			  "Title": "'.$pessager['adulttitle'][$ics].'",
			  "FirstName": "'.$pessager['adultfirstname'][$ics].'",
			  "LastName": "'.$pessager['adultlastname'][$ics].'",
			  "PaxType": '.$farebrakdownr[$ic]->PassengerType.',
			  
				"Gender": '.$gender.',';
				 if((isset($pessager['airasia']) && $pessager['airasia'] == 1) || ($pessager['IsIntr'] == 1 || $pessager['IsIntr'] == 'true')){
						$chexp = explode('/',$pessager['adultdob'][$ics]);
						$dataaadult = $chexp[2].'-'.$chexp[1].'-'.$chexp[0].'T00:00:00';
						$result_dataib .=	'"DateOfBirth": "'.$dataaadult.'",';
					}
				 if($pessager['IsIntr'] == 1 || $pessager['IsIntr'] == 'true'){
					$result_dataib .=	'"PassportNo": "'.$adultpassportno.'",';
					$result_dataib .=	'"PassportExpiry": "'.$adultpassportdate.'",';
			  }
			  $result_dataib .=	'"AddressLine1": "123 test",
			  "AddressLine2": "",
			  "City": "Gurgaon",
			  "CountryCode": "IN",
			  "CountryName": "India",
			  "ContactNo": "'.str_replace(' ', '', $pessager['phone']).'",
			  "Email": "'.$pessager['email'].'",
			  "IsLeadPax": '.$IsLeadPax.',
			  "FFAirline": "",
			  "FFNumber": "",';
			  if($resultdataib->Response->Results->IsGSTMandatory == true && $ics == 0){
					 $result_dataib .='"GSTCompanyAddress": "F111/112 North Square Mall, Delhi",
					"GSTCompanyContactNumber": "1147262626",
					"GSTCompanyName": "Holiday Planner PRIVATE LIMITED",
					"GSTNumber": "07AAACZ3593Q1ZI",
					"GSTCompanyEmail": "info@zapbooking.com",';
				}
			  $result_dataib .='"Nationality": "IN",
			   "Fare": {
				"Currency": "INR",
				"BaseFare": '.number_format($fareprice, 2, '.', '').',
				"Tax": '.number_format($faretax, 2, '.', '').',
				"YQTax": '.number_format($yqtax, 2, '.', '').',
				"AdditionalTxnFeeOfrd": 0.0,
				"AdditionalTxnFeePub": 0.0,
				"PGCharge": 0.0
			  }';
			  if (\Cache::has('ssrdataib'.$pessager['hfTraceId'].$pessager['hfIBRIndex'])){	
				$ssrdataib = \Cache::get( 'ssrdataib'.$pessager['hfTraceId'].$pessager['hfIBRIndex']);
				$ssrresultibdata = json_decode($ssrdataib);
				
				$adultbaggage = preg_filter('/^returnadultbaggage_'.$ics.'(.*)/', '$1', array_keys( $pessager ));
					if(!empty($adultbaggage)){
					$resultbag_data = ',"Baggage":[';
					foreach($adultbaggage as $val){
					if(@$ssrresultibdata->Response->Error->ErrorCode == 0 && @$ssrresultibdata->Response->Baggage !== null){
					if(isset($pessager['returnadultbaggage_'.$ics.$val])){
						$dep_baggage = explode('_', $pessager['returnadultbaggage_'.$ics.$val]);
						if($dep_baggage[1] != 'NONE'){
							foreach(@$ssrresultibdata->Response->Baggage as $key => $bsslist){
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
				$result_dataib .= rtrim($resultbag_data,',');
			$result_dataib .= ']';
		}
				
				
				$adulmeal = preg_filter('/^returnadultmeal_'.$ics.'(.*)/', '$1', array_keys( $pessager ));
	if(!empty($adulmeal)){
						$resultmeal_data = ',"MealDynamic":[';
						foreach($adulmeal as $val){
							
						if(@$ssrresultibdata->Response->Error->ErrorCode == 0 && @$ssrresultibdata->Response->MealDynamic !== null){
						if(isset($pessager['returnadultmeal_'.$ics.$val])){
							$dep_meal = explode('@', $pessager['returnadultmeal_'.$ics.$val]);
							$dep_mealx = explode('-', $pessager['returnadultmeal_'.$ics.$val]);
							if($dep_meal[0] != 'NONE'){
								foreach(@$ssrresultibdata->Response->MealDynamic as $key => $meallist){
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
					$result_dataib .= rtrim($resultmeal_data,',');
				$result_dataib .= ']';
			}
				
		$adulPaxSeat = preg_filter('/^returnadult_'.$ics.'_PaxSeat_(.*)/', '$1', array_keys( $pessager ));
							//echo '<pre>'; print_r($pessager);
							 if(!empty($adulPaxSeat)){ 
							 $resultseat_data = ',"SeatDynamic":[';
								foreach($adulPaxSeat as $val){
									if(isset($pessager['returnadult_'.$ics.'_PaxSeat_'.$val])){
										
										
											 if($pessager['returnadult_'.$ics.'_PaxSeat_'.$val] != 'none'){
												 
												 $exploadseats = explode('_', $pessager['returnadult_'.$ics.'_PaxSeat_'.$val]);
												 $seat = 0;
												 $seatsegment = @$exploadseats[3];
												 $rowseat = @$exploadseats[5];
												 $seatn = @$exploadseats[7];
												 if(@$ssrresultibdata->Response->Error->ErrorCode == 0 && @$ssrresultibdata->Response->SeatDynamic !== null){
													
													 if(isset($ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn])){
														
															$resultseat_data .= '{
							"AirlineCode": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->AirlineCode.'",
							 "FlightNumber": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->FlightNumber.'",
							  "CraftType": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->CraftType.'",
							   "Origin": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Origin.'",
								"Destination": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Destination.'",
								"AvailablityType": '.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->AvailablityType.',
								"Description": '.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Description.',
								"Code": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Code.'",
								"RowNo": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->RowNo.'",
								"SeatNo": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->SeatNo.'",
								"SeatType": '.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->SeatType.',
								"SeatWayType": '.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->SeatWayType.',
								"Compartment": '.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Compartment.',
								"Deck": '.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Deck.',
								"Currency": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Currency.'",
								"Price":'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Price.'                                            },';
													 }
												 }
											}
									}
								}
								$result_dataib .= rtrim($resultseat_data,',');
								$result_dataib .= ']';
							}
				
				}
		$result_dataib .='},'; 
					}else if($farebrakdownr[$ic]->PassengerType == 2){ 
					if($farebrakdownr[$ic]->BaseFare == 0){
						$fareprice = 0;
					}else{
						$fareprice = $farebrakdownr[$ic]->BaseFare / $farebrakdownr[$ic]->PassengerCount;
					}
					if($farebrakdownr[$ic]->Tax == 0){
						$faretax = 0;
					}else{
						$faretax = $farebrakdownr[$ic]->Tax / $farebrakdownr[$ic]->PassengerCount;
					}
					
					if($farebrakdownr[$ic]->YQTax == 0){
						$yqtax = 0;
					}else{
						$yqtax = $farebrakdownr[$ic]->YQTax;
					}
					//echo '2'.$farebrakdowna[$ic]->PassengerCount.'<br>';
					if($pessager['childtitle'][$ics] == 'Mstr'){
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
				 	$result_dataib .='
		{
			  "Title": "'.$pessager['childtitle'][$ics].'",
			  "FirstName": "'.$pessager['childfirstname'][$ics].'",
			  "LastName": "'.$pessager['childlastname'][$ics].'",
			  "PaxType": '.$farebrakdownr[$ic]->PassengerType.',
				"DateOfBirth": "'.$dataachild.'",
			  "Gender": '.$gender.',';
			   if($pessager['IsIntr'] == 1 || $pessager['IsIntr'] == 'true'){
					$result_dataib .=	'"PassportNo": "'.$childpassportno.'",';
					$result_dataib .=	'"PassportExpiry": "'.$childpassportdate.'",';
			  }
			  $result_dataib .='"AddressLine1": "123 test",
			  "AddressLine2": "",
			  "City": "Gurgaon",
			  "CountryCode": "IN",
			  "CountryName": "India",
			  "ContactNo": "'.str_replace(' ', '', $pessager['phone']).'",
			  "Email": "'.$pessager['email'].'",
			  "IsLeadPax": false,
			  "FFAirline": "",
			  "FFNumber": "",
			  "Nationality": "IN",
			   "Fare": {
				"Currency": "INR",
				"BaseFare": '.$fareprice.',
				"Tax": '.$faretax.',
				"YQTax": '.$yqtax.',
				"AdditionalTxnFeeOfrd": 0,
				"AdditionalTxnFeePub": 0,
				"PGCharge": 0
			  }';		  
			   if (\Cache::has('ssrdataib'.$pessager['hfTraceId'].$pessager['hfIBRIndex'])){
						
							$ssrdataib = \Cache::get( 'ssrdataib'.$pessager['hfTraceId'].$pessager['hfIBRIndex']);
							
							$ssrresultibdata = json_decode($ssrdataib);
							
							$childbaggage = preg_filter('/^returnchildbaggage_'.$ics.'(.*)/', '$1', array_keys( $pessager ));
					if(!empty($childbaggage)){
					$resultbag_data = ',"Baggage":[';
					foreach($childbaggage as $val){
					if(@$ssrresultibdata->Response->Error->ErrorCode == 0 && @$ssrresultibdata->Response->Baggage !== null){
					if(isset($pessager['returnchildbaggage_'.$ics.$val])){
						$dep_baggage = explode('_', $pessager['returnchildbaggage_'.$ics.$val]);
						if($dep_baggage[1] != 'NONE'){
							foreach(@$ssrresultibdata->Response->Baggage as $key => $bsslist){
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
				$result_dataib .= rtrim($resultbag_data,',');
			$result_dataib .= ']';
		}
							
							
							
							$childmeal = preg_filter('/^returnchildmeal_'.$ics.'(.*)/', '$1', array_keys( $pessager ));
							if(!empty($childmeal)){
								$resultmeal_data = ',"MealDynamic":[';
								foreach($childmeal as $val){
									if(@$ssrresultibdata->Response->Error->ErrorCode == 0 && @$ssrresultibdata->Response->MealDynamic !== null){
										if(isset($pessager['returnchildmeal_'.$ics.$val])){
											$dep_meal = explode('@', $pessager['returnchildmeal_'.$ics.$val]);
											$dep_mealx = explode('-', $pessager['returnchildmeal_'.$ics.$val]);
											if($dep_meal[0] != 'NONE'){
												foreach(@$ssrresultibdata->Response->MealDynamic as $key => $meallist){
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
								$result_dataib .= rtrim($resultmeal_data,',');
								$result_dataib .= ']';
							}
							
							$childPaxSeat = preg_filter('/^returnchild_'.$ics.'_PaxSeat_(.*)/', '$1', array_keys( $pessager ));
							 if(!empty($childPaxSeat)){ 
							 $resultseat_data = ',"SeatDynamic":[';
								foreach($childPaxSeat as $val){
									if(isset($pessager['returnchild_'.$ics.'_PaxSeat_'.$val])){
										
											 if($pessager['returnchild_'.$ics.'_PaxSeat_'.$val] != 'none'){
												 $exploadseats = explode('_', $pessager['returnchild_'.$ics.'_PaxSeat_'.$val]);
												 $seat = 0;
												 $seatsegment = @$exploadseats[3];
												 $rowseat = @$exploadseats[5];
												 $seatn = @$exploadseats[7];
												 if(@$ssrresultibdata->Response->Error->ErrorCode == 0 && @$ssrresultibdata->Response->SeatDynamic !== null){
													 if(isset($ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn])){
															$resultseat_data .= '{
							"AirlineCode": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->AirlineCode.'",
							 "FlightNumber": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->FlightNumber.'",
							  "CraftType": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->CraftType.'",
							   "Origin": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Origin.'",
								"Destination": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Destination.'",
								"AvailablityType": '.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->AvailablityType.',
								"Description": '.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Description.',
								"Code": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Code.'",
								"RowNo": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->RowNo.'",
								"SeatNo": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->SeatNo.'",
								"SeatType": '.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->SeatType.',
								"SeatWayType": '.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->SeatWayType.',
								"Compartment": '.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Compartment.',
								"Deck": '.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Deck.',
								"Currency": "'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Currency.'",
								"Price":'.$ssrresultibdata->Response->SeatDynamic[$seat]->SegmentSeat[$seatsegment]->RowSeats[$rowseat]->Seats[$seatn]->Price.'                                            },';
													 }
												 }
											}
									}
								}
								$result_dataib .= rtrim($resultseat_data,',');
								$result_dataib .= ']';
							}
							
						}
		$result_dataib .='},'; 
					}else{ 
					if($farebrakdownr[$ic]->BaseFare == 0){
						$fareprice = 0;
					}else{
						$fareprice = $farebrakdownr[$ic]->BaseFare / $farebrakdownr[$ic]->PassengerCount;
					}
					if($farebrakdownr[$ic]->Tax == 0){
						$faretax = 0;
					}else{
						$faretax = $farebrakdownr[$ic]->Tax / $farebrakdownr[$ic]->PassengerCount;
					}
					
					if($farebrakdownr[$ic]->YQTax == 0){
						$yqtax = 0;
					}else{
						$yqtax = $farebrakdownr[$ic]->YQTax;
					}
					
					if($pessager['infanttitle'][$ics] == 'Mstr'){
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
					$inexp = explode('/',$pessager['infantdob'][$ics]);
					
				$dataainfant = $inexp[2].'-'.$inexp[1].'-'.$inexp[0].'T00:00:00';					
					//echo '3'.$farebrakdowna[$ic]->PassengerCount.'<br>';
					$result_dataib .='
		{
			  "Title": "'.$pessager['infanttitle'][$ics].'",
			  "FirstName": "'.$pessager['infantfirstname'][$ics].'",
			  "LastName": "'.$pessager['infantlastname'][$ics].'",
			  "PaxType": '.$farebrakdownr[$ic]->PassengerType.',
			  "DateOfBirth": "'.$dataainfant.'",';
			  if($pessager['IsIntr'] == 1 || $pessager['IsIntr'] == 'true'){
					$result_dataib .=	'"PassportNo": "'.$infantpassportno.'",';
					$result_dataib .=	'"PassportExpiry": "'.$infantpassportdate.'",';
			  }
			  $result_dataib .=	'"Gender": '.$gender.',
			  "AddressLine1": "123 test",
			  "AddressLine2": "",
			  "City": "Gurgaon",
			  "CountryCode": "IN",
			  "CountryName": "India",
			  
			  "ContactNo": "'.str_replace(' ', '', $pessager['phone']).'",
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
	
	$result_dataib .=	'],';
			if($resultdataib->Response->Results->IsLCC ==1){
				$result_dataib .= '"PreferredCurrency": null,';
			}
		$result_dataib .='"EndUserIp": "103.138.188.143",
			"TokenId": "'.$auth->TokenId.'",
			"TraceId": "'.$pessager['hfTraceId'].'"
			}'; 
		  /*  echo $result_data;  
 echo '<h1>RETUN ---------------------------</h1>';  
echo $result_dataib; die;   */	
		$log = ['email' => @$pessager['email'],
        'description' => $result_data];
			$orderLog = new Logger('bookrequestib');
	$orderLog->pushHandler(new StreamHandler(storage_path('logs/bookibrequest.log')), Logger::INFO);
	$orderLog->info('BookRequestIb', $log);	
	
	$los= ['email' => @$pessager['email'],
        'description' => $result_dataib];
			$orderLog = new Logger('bookrequestob');
	$orderLog->pushHandler(new StreamHandler(storage_path('logs/bookobrequest.log')), Logger::INFO);
	$orderLog->info('BookRequestOb', $los);		
			/* IB end*/
/*  echo $result_data;  
 echo '<h1>RETUN ---------------------------</h1>';  
echo $result_dataib; die;   */
$nonlcc = true;
	if($resultdata->Response->Results->IsLCC ==1){
		//echo 'a';
		$nonlcc = false;
		if($flghtapi->agent_flight_api_type == 1){
			$urlsew= "https://booking.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/Ticket";
		}else{
			$urlsew= "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/Ticket";
		}
		$result = $this->postcurlRequest($urlsew,$result_data); 
		$ssrdata = json_decode($result); 
	}else{
		
		 if($flghtapi->agent_flight_api_type == 1){
			 $urlsew= "https://booking.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/Book";
		 }else{
			 $urlsew= "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/Book";
		 }
		 
		 $result = $this->postcurlRequest($urlsew,$result_data); 
		 $bookdetail = json_decode($result); 
		 
	}
	if($resultdataib->Response->Results->IsLCC ==1){
		if($flghtapi->agent_flight_api_type == 1){
			$urlsew= "https://booking.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/Ticket";
		}else{
				$urlsew= "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/Ticket";
		}
		$resultib = $this->postcurlRequest($urlsew,$result_dataib); 
		$ssrdataib = json_decode($resultib);
		//echo 'd';
	}else{
		 if($flghtapi->agent_flight_api_type == 1){
			 //echo 'e';
			 $urlsew= "https://booking.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/Book";
		 }else{
			 $urlsew= "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/Book";
		 }
		$resultib = $this->postcurlRequest($urlsew,$result_dataib); 
		$bookdetailib = json_decode($resultib);
	}
		$log = ['email' => @$pessager['email'],
		'obrequest' => $result_data, 'obreponse'=>$result, 'ibrequest'=>$result_dataib, 'ibrewsponse'=>$resultib];	
		$orderLog = new Logger('bookorder');
		$orderLog->pushHandler(new StreamHandler(storage_path('logs/nonlccbookorder.log')), Logger::INFO);
		$orderLog->info('BookOrderLog', $log);
		
			if($resultdata->Response->Results->IsLCC ==1){
			}else{
				if($flghtapi->agent_flight_api_type == 1){
					$urlsew= "https://booking.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/Ticket";
				}else{
					$urlsew= "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/Ticket";
				}
				
				$result_data = '{
						"EndUserIp": "103.138.188.143",
						"TokenId": "'.$auth->TokenId.'",
						"TraceId": "'.$pessager['hfTraceId'].'",
					  "PNR": "'.$bookdetail->Response->Response->PNR.'",
					  "BookingId": '.$bookdetail->Response->Response->BookingId.'
					}';
				$ssrdata = $this->postcurlRequest($urlsew,$result_data);
			}
			if($resultdataib->Response->Results->IsLCC ==1){
			}else{
				if($flghtapi->agent_flight_api_type == 1){
					$urlsew= "https://booking.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/Ticket";
				}else{
					$urlsew= "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/Ticket";
				}
				
				$result_dataib = '{
						"EndUserIp": "103.138.188.143",
						"TokenId": "'.$auth->TokenId.'",
						"TraceId": "'.$pessager['hfTraceId'].'",
					  "PNR": "'.$bookdetailib->Response->Response->PNR.'",
					  "BookingId": '.$bookdetailib->Response->Response->BookingId.'
					}';
				$ssrdataib = $this->postcurlRequest($urlsew,$result_dataib);
			}
			
			//if($pessager['IsReturn'] == 1){
				$log = ['email' => @$pessager['email'],
        'obrequest' => $result_data, 'obreponse'=>$ssrdata, 'ibrequest'=>$result_dataib, 'ibrewsponse'=>$ssrdataib];

		//first parameter passed to Monolog\Logger sets the logging channel name
			$orderLog = new Logger('bookorder');
			$orderLog->pushHandler(new StreamHandler(storage_path('logs/nonlccticket.log')), Logger::INFO);
			$orderLog->info('BookOrderLog', $log);
				
			//}
	//}
		
		
		/* $log = ['email' => @$pessager['email'],
        'departure' => $result, 'arrival' =>$resultib];

		//first parameter passed to Monolog\Logger sets the logging channel name
		$orderLog = new Logger('order');
		$orderLog->pushHandler(new StreamHandler(storage_path('logs/order.log')), Logger::INFO);
		$orderLog->info('OrderLog', $log); */
		
		if((@$ssrdata->Response->ResponseStatus == 1 && $ssrdata->Response->Error->ErrorCode ==0) && (@$ssrdataib->Response->ResponseStatus == 1 && $ssrdataib->Response->Error->ErrorCode ==0)){
			if($flghtapi->agent_flight_api_type == 1){
				$urlbooksew= "https://booking.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/GetBookingDetails";
			}else{
				$urlbooksew= "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/GetBookingDetails";
			}
			
				$bookdetailresult_data = '{
						"EndUserIp": "103.138.188.143",
						"TokenId": "'.$auth->TokenId.'",
					  "PNR": "'.$ssrdata->Response->Response->PNR.'",
					  "BookingId": '.$ssrdata->Response->Response->BookingId.'
					}';
				$bookideob = $this->postcurlRequest($urlbooksew,$bookdetailresult_data);
				
				$logob = ['email' => @$pessager['email'],'request'=>$bookdetailresult_data,'description' => $bookideob];
			$orderLogob = new Logger('getbookrequestib');
	$orderLogob->pushHandler(new StreamHandler(storage_path('logs/getbookobrequest.log')), Logger::INFO);
	$orderLogob->info('GetBookRequestIb', $logob);	
	if($flghtapi->agent_flight_api_type == 1){
	$urlibbooksew= "https://booking.travelboutiqueonline.com/AirAPI_V10/AirService.svc/rest/GetBookingDetails";
	}else{
		$urlibbooksew= "http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/GetBookingDetails";
	}
				$bookddetailresult_data = '{
						"EndUserIp": "103.138.188.143",
						"TokenId": "'.$auth->TokenId.'",
					  "PNR": "'.$ssrdataib->Response->Response->PNR.'",
					  "BookingId": '.$ssrdataib->Response->Response->BookingId.'
					}';
				$bookideib = $this->postcurlRequest($urlibbooksew,$bookddetailresult_data);
	
	$losib= ['email' => @$pessager['email'],'request'=>$bookddetailresult_data,'description' => $bookideib];
			$orderLogib = new Logger('fetbookrequestib');
	$orderLogib->pushHandler(new StreamHandler(storage_path('logs/getbookibrequest.log')), Logger::INFO);
	$orderLogib->info('GetBookRequestIb', $losib);	
				$booking_id = Session::get('booking_id');
				$payment_id = Session::get('payment_id');
				$user_id = Session::get('useridd');
			
				$bookingdetail = BookingDetail::find($booking_id);
				$bookingdetail->user_id = $user_id;
				$bookingdetail->pnr = $ssrdata->Response->Response->PNR;
				$bookingdetail->pnrib = $ssrdataib->Response->Response->PNR;
				$bookingdetail->booking_id = $ssrdata->Response->Response->BookingId;
				$bookingdetail->trace_id = $ssrdata->Response->TraceId;
				$bookingdetail->booking_response = $result;
				$bookingdetail->booking_response_ib = $resultib;
				$bookingdetail->status = 1;
				$bookingdetail->ticket_status = @$ssrdata->Response->Response->TicketStatus;
				$saved = $bookingdetail->save();
				
				$payment = PaymentDetail::find($payment_id);
				$payment->status = 1;
				$payment->save();
				$message = "Dear Admin, '{name}' have successfully booked a flight ticket from {source} to {destination}. PNR is '{PNR}' and Holiday Planner Id is '{BookingID}'. {travel_date} and {flight_name} For more bookings please visit {URL}. Thank you.";
				//$this->AdminPhoneBookingTicket($booking_id, $message,1);
				if($saved){
					$fetchedData = BookingDetail::where('id',$booking_id)->with(['user'])->first();
					$pdf = PDF::setOptions([
				'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
				'logOutputFile' => storage_path('logs/log.htm'),
				'tempDir' => storage_path('logs/')
				])->loadView('emails.ticket', compact('fetchedData'));
				$output = $pdf->output();
				$set = Admin::where('id',1)->first();
				$invoicefilename = $set->ref_prefix.$fetchedData->id.'-'.$fetchedData->pnr.'.pdf';
				file_put_contents('/home/zapbooking/public_html/public/invoices/'.$invoicefilename, $output);
				$array['file'] = '/home/zapbooking/public_html/public/invoices/'.$invoicefilename;
				$array['file_name'] = $invoicefilename;
				$booking = json_decode($fetchedData->booking_response);
				$Flight_Name = @$booking->Response->Response->FlightItinerary->Segments[0]->Airline->AirlineName;
				$DATE = date('d/m/Y',strtotime(@$booking->Response->Response->FlightItinerary->Segments[0]->Origin->DepTime));
				$subject = $Flight_Name." Booking PNR ". $fetchedData->pnr.": ".$DATE." ".@$booking->Response->Response->FlightItinerary->Segments[0]->Origin->Airport->CityName."-".@$booking->Response->Response->FlightItinerary->Segments[$tr]->Destination->Airport->CityName." for ".@$pessager['adulttitle'][0]." ".@$pessager['adultfirstname'][0]." ".@$pessager['adultlastname'][0];
					// Mail::to(@$pessager['email'])->send(new TicketMail($fetchedData, $subject, $set->primary_email, $array));
					 // Mail::to($set->primary_email)->cc('mukesh@zapbooking.com')->send(new TicketMail($fetchedData, $subject, $set->primary_email, $array));
					 unlink($array['file']);
					

					if(@Auth::user()){
					 }else{
						 
						 $customer = User::where('id', '=', $user_id)->first();
							DB::table('password_resets')->insert([
								'email' => $customer->email,
								'token' => str_random(60),
								'created_at' => Carbon::now()
							]);
							//Get the token just created above
							$tokenData = DB::table('password_resets')
								->where('email', $customer->email)->first();
								 $this->sendResetEmail($customer->email, $tokenData->token);
								 }					
				/*SMS */
				$phone = str_replace(' ', '', $pessager['phone']);
					$fetchedData = BookingDetail::where('id',$fetchedData->id)->with(['user'])->first();
					$name=@$fetchedData->user->title.' '.@$fetchedData->user->first_name.' '.$fetchedData->user->last_name;
						$authkey = MyConfig::where('meta_key','web2sms_auth_key')->first()->meta_value;
						$senderid = MyConfig::where('meta_key','web2sms_senderid')->first()->meta_value;
						$routeid = MyConfig::where('meta_key','web2sms_routeid')->first()->meta_value;
						$url = MyConfig::where('meta_key','web2sms_gateway_url')->first()->meta_value;
						$smscontent = MyConfig::where('meta_key','web2sms_smscontent')->first()->meta_value;
						
						$replacesub = array('{name}', '{source}', '{destination}', '{PNR}', '{BookingID}', '{URL}');					
						$replace_with_sub = array(@$name, @$fetchedData->source, @$fetchedData->destination, @$fetchedData->pnr, @$set->ref_prefix.'-'.$fetchedData->id, \URL::to('/'));
						$subContent	=	str_replace($replacesub,$replace_with_sub,$smscontent);
						
						$message =$subContent;
						if(MyConfig::where('meta_key','msg_status')->first()->meta_value == 'msgnine'){
						$authkey = MyConfig::where('meta_key','msg_authkey')->first()->meta_value;
						$senderid = MyConfig::where('meta_key','msg_senderid')->first()->meta_value;
						$routeid = MyConfig::where('meta_key','msg_otptemplate_id')->first()->meta_value;
						$url = MyConfig::where('meta_key','msg_gateway_url')->first()->meta_value;
						$mobileNumber = "91".$phone;
						$senderId = "ZAPFLI";
						$message = urlencode($message);
						$route = "4";
						$postData = array(
							'mobiles' => $mobileNumber,
							'message' => $message,
							'sender' => $senderId,
							'route' => $route
						);
						$url="http://api.msg91.com/api/v2/sendsms";


						$curl = curl_init();
						curl_setopt_array($curl, array(
							CURLOPT_URL => "$url",
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_CUSTOMREQUEST => "POST",
							CURLOPT_POSTFIELDS => $postData,
							CURLOPT_HTTPHEADER => array(
								"authkey: ".$authkey,
								"content-type: multipart/form-data"
							),
						));

						$response = curl_exec($curl);

						$err = curl_error($curl);

						curl_close($curl);

			if ($err) {
			// echo json_encode(array('success' =>false,'message'=>$err));
			} else {
			 // echo json_encode(array('success' =>true,'message'=>$response));
			}
						}else{
						//echo  $url."?AUTH_KEY=".$authkey."&message=".$message."&senderId=".$senderid."&routeId=".$routeid."&mobileNos=".$phone."&smsContentType=english";
						$curl = curl_init();

						curl_setopt_array($curl, array(
				
						  CURLOPT_URL => $url."?AUTH_KEY=".$authkey."&message=".$message."&senderId=".$senderid."&routeId=".$routeid."&mobileNos=".$phone."&smsContentType=english",
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => "",
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 30,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => "GET",
						  CURLOPT_HTTPHEADER => array(
							"Cache-Control: no-cache"
						  ),
						));

						$response = curl_exec($curl);
						$err = curl_error($curl);

						curl_close($curl);

						if ($err) {
						 $message =  $err;
						} else {
						  $message =  $response;
						  $success = true;
						}
				}
				/*SMS */
					Session::forget('pessager');
					Session::forget('TokenId');
					Session::forget('booking_id');
					Session::forget('payment_id');
					Session::forget('useridd');
					Session::forget('origin');
					Session::forget('destination');
					Session::forget('from_date');
					Session::forget('to_date');
					return Redirect::to('/agent/booking/success/'.base64_encode(convert_uuencode(@$bookingdetail->id)));
				}else{
					return redirect()->back()->with('error', Config::get('constants.server_error'));
				}
			
		}else{
				$booking_id = Session::get('booking_id');
				$payment_id = Session::get('payment_id');
				$user_id = Session::get('useridd');
				$bookingdetail = BookingDetail::find($booking_id);
				$bookingdetail->user_id = @$user_id;

				$bookingdetail->booking_response = $result;
				$bookingdetail->booking_response_ib = $resultib;
				$saved = $bookingdetail->save();

				/* $payment = PaymentDetail::find($payment_id);
				$payment->status = 3;
				$payment->save(); */
				$message = "Dear Admin, '{name}' has trying to book a flight ticket from {source} to {destination} but failed. For more bookings please visit {URL}. Thank you.";
			//	$this->AdminPhoneBookingTicket($booking_id, $message);
				Session::forget('pessager');
				Session::forget('TokenId');
				Session::forget('booking_id');
				Session::forget('payment_id');
				Session::forget('useridd');
				Session::forget('origin');
				Session::forget('destination');
				Session::forget('from_date');
				Session::forget('to_date');
				$error = '';
			if(isset($ssrdata->Response->Error->ErrorMessage)){
				$error .= $ssrdata->Response->Error->ErrorMessage;
			}
			if(isset($ssrdataib->Response->Error->ErrorMessage)){
				$error .= $ssrdataib->Response->Error->ErrorMessage;
			}
			//return Redirect::to('/Review/Checkout?tid='.$pessager['hfTraceId'].'&Index='.$pessager['hfRIndex'].'&isINT='.$pessager['IsIntr'].'&isINT='.$pessager['IsIntr'])->with('error', $error);
				return Redirect::to('/agent/booking/error')->with('error', $error);
		}
		}
	}
	
	public function BookingTicket(Request $request, $id = Null){
		if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	 
				if(BookingDetail::where('id', '=', $id)->exists()) 
				{
					$fetchedData = BookingDetail::where('id',$id)->with(['user'])->first();
					 return view('Agent.flights.ticket', compact(['fetchedData']));
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
	
	public function PhoneBookingTicket(Request $request, $id = Null){
		$success = false;
		$message = '';
		if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	 
				if(BookingDetail::where('id', '=', $id)->exists()) 
				{
					$set = Admin::where('id',1)->first();
					$phone = $request->phone;
					$fetchedData = BookingDetail::where('id',$id)->with(['user'])->first();
					$name=@$fetchedData->user->title.' '.@$fetchedData->user->first_name.' '.$fetchedData->user->last_name;
					if(MyConfig::where('meta_key','msg_status')->first()->meta_value == 'msgnine'){
						
						 $authkey = MyConfig::where('meta_key','msg_authkey')->first()->meta_value;
						$senderid = MyConfig::where('meta_key','msg_senderid')->first()->meta_value;
						$routeid = MyConfig::where('meta_key','msg_otptemplate_id')->first()->meta_value;
						$url = MyConfig::where('meta_key','msg_gateway_url')->first()->meta_value;
						$smscontent = MyConfig::where('meta_key','web2sms_smscontent')->first()->meta_value;
						$mobileNumber = "91".$phone;
						$senderId = "ZAPFLI";
						$replacesub = array('{name}', '{source}', '{destination}', '{PNR}', '{BookingID}', '{URL}');					
						$replace_with_sub = array(@$name, @$fetchedData->source, @$fetchedData->destination, @$fetchedData->pnr, $set->ref_prefix.'-'.@$fetchedData->id, \URL::to('/'));
						$subContent	=	str_replace($replacesub,$replace_with_sub,$smscontent);
						
						$message =$subContent;
						$message = urlencode($message);
						$route = "4";
						$postData = array(
						'mobiles' => $mobileNumber,
						'message' => $message,
						'sender' => $senderId,
						'route' => $route
						);
						$url="http://api.msg91.com/api/v2/sendsms";
						$curl = curl_init();
						curl_setopt_array($curl, array(
						CURLOPT_URL => "$url",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS => $postData,
						CURLOPT_HTTPHEADER => array(
						"authkey: ".$authkey,
						"content-type: multipart/form-data"
						),
						));

						$response = curl_exec($curl);

						$err = curl_error($curl);

						curl_close($curl);

						if ($err) {
						 $message =  $err;
						} else {
						  $message =  $response;
						  $success = true;
						}
					}else{
						
					
						$authkey = MyConfig::where('meta_key','web2sms_auth_key')->first()->meta_value;
						$senderid = MyConfig::where('meta_key','web2sms_senderid')->first()->meta_value;
						$routeid = MyConfig::where('meta_key','web2sms_routeid')->first()->meta_value;
						$url = MyConfig::where('meta_key','web2sms_gateway_url')->first()->meta_value;
						$smscontent = MyConfig::where('meta_key','web2sms_smscontent')->first()->meta_value;
						
						$replacesub = array('{name}', '{source}', '{destination}', '{PNR}', '{BookingID}', '{URL}');					
						$replace_with_sub = array(@$name, @$fetchedData->source, @$fetchedData->destination, @$fetchedData->pnr, $set->ref_prefix.'-'.@$fetchedData->id, \URL::to('/'));
						$subContent	=	str_replace($replacesub,$replace_with_sub,$smscontent);
						
						$message =$subContent;
						//echo  $url."?AUTH_KEY=".$authkey."&message=".$message."&senderId=".$senderid."&routeId=".$routeid."&mobileNos=".$phone."&smsContentType=english"; die;
						$curl = curl_init();

						curl_setopt_array($curl, array(
				
						  CURLOPT_URL => $url."?AUTH_KEY=".$authkey."&message=".$message."&senderId=".$senderid."&routeId=".$routeid."&mobileNos=".$phone."&smsContentType=english",
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => "",
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 30,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => "GET",
						  CURLOPT_HTTPHEADER => array(
							"Cache-Control: no-cache"
						  ),
						));

						$response = curl_exec($curl);
						$err = curl_error($curl);

						curl_close($curl);

						if ($err) {
						 $message =  $err;
						} else {
						  $message =  $response;
						  $success = true;
						}
						}
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
			echo json_encode(array('success'=>$success,'message'=>$message));
	}
	
	
	public function EmailBookingTicket(Request $request, $id = Null){
		$success = false;
		if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	 
				if(BookingDetail::where('id', '=', $id)->exists()) 
				{
					$fetchedData = BookingDetail::where('id',$id)->with(['user'])->first();
					$pdf = PDF::setOptions([
				'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
				'logOutputFile' => storage_path('logs/log.htm'),
				'tempDir' => storage_path('logs/')
				])->loadView('emails.ticket', compact('fetchedData'));
				$output = $pdf->output();
				$set = Admin::where('id',1)->first();
				$invoicefilename = $set->ref_prefix.$fetchedData->id.'-'.$fetchedData->pnr.'.pdf';
				file_put_contents('/home/zapbooking/public_html/public/invoices/'.$invoicefilename, $output);
				$array['file'] = '/home/zapbooking/public_html/public/invoices/'.$invoicefilename;
				$array['file_name'] = $invoicefilename;
				$booking = json_decode($fetchedData->booking_response);
				$Flight_Name = @$booking->Response->Response->FlightItinerary->Segments[0]->Airline->AirlineName;
				$DATE = date('d/m/Y',strtotime(@$booking->Response->Response->FlightItinerary->Segments[0]->Origin->DepTime));
				$subject = $Flight_Name." Booking PNR ".$fetchedData->pnr.": ".$DATE." ".@$booking->Response->Response->FlightItinerary->Segments[0]->Origin->Airport->CityName."-".@$booking->Response->Response->FlightItinerary->Segments[$tr]->Destination->Airport->CityName." for ".@$pessager['adulttitle'][0]." ".@$pessager['adultfirstname'][0]." ".@$pessager['adultlastname'][0];
					 Mail::to($request->email)->send(new TicketMail($fetchedData, $subject, $set->primary_email, $array));
					 unlink($array['file']);
					 if (Mail::failures()) {
						
					}else{
						$success = true;
					}
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
			echo json_encode(array('success'=>$success));
	}
	public function BookingSuccess(Request $request, $id = Null){
		if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	 
				if(BookingDetail::where('id', '=', $id)->exists()) 
				{
					$fetchedData = BookingDetail::where('id',$id)->with(['user'])->first();
					 return view('Agent.flights.booking-confirm', compact(['fetchedData']));
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
	public function cities(Request $request){
		$output = '';
		$query = $request->get('textval');
		if($query != ''){
			//DB::enableQueryLog();
			 $airportcodelis = DB::table('airports')->where('airport_code', '=', $query);
        // ->where('city_name', 'LIKE', '%'.$query.'%')
        // ->orwhere('city_code', '=', $query)
         $codelist = $airportcodelis->get();
		 //print_r(DB::getQueryLog());
		 $airportcodelis = DB::table('airports')->where('city_name', 'LIKE', '%'.$query.'%')->orwhere('country_name', '=', $query);
		 $codelist1 = $airportcodelis->orderby('city_name', 'ASC')->get();
		 $airportcodeliss = array_merge($codelist->toArray(), $codelist1->toArray());
		 $t = array();
		 foreach($airportcodeliss as $alist){
			 $t[$alist->airport_code] = array(
				'country_name' => $alist->country_name,
				'city_name' => $alist->city_name,
				'airport_code' => $alist->airport_code,
				'airport_name' => $alist->airport_name,
				'city_code' => $alist->city_code,
			 );
		 }
			foreach($t as $key => $alist){
				
				if($request->type == 'if_search_val'){
					$output .= '<li class="" onewayfromtop="'.$alist['city_code'].'-'.$alist['city_name'].'-'.$alist['country_name'].'" onewayfrom="'.$alist['city_name'].' ('.$alist['city_code'].')">
					<div class="fli_name"><i class="fa fa-plane"></i> '.$alist['city_name'].' ('.$alist['airport_code'].')</div>
					<div class="airport_name">'.$alist['airport_name'].'<span>'.$alist['country_name'].'</span></div>
				</li>';
				}else if($request->type == 'multi_is_search_from_val'){
					$output .= '<li class="" roundwayfromtop="'.$alist['city_code'].'-'.$alist['city_name'].'-'.$alist['country_name'].'" roundwayfrom="'.$alist['city_name'].' ('.$alist['city_code'].')">
					<div class="fli_name"><i class="fa fa-plane"></i> '.$alist['city_name'].' ('.$alist['airport_code'].')</div>
					<div class="airport_name">'.$alist['airport_name'].'<span>'.$alist['country_name'].'</span></div>
				</li>';
				}else if($request->type == 'multi_is_search_to_val'){
					$output .= '<li class="" roundwaytotop="'.$alist['city_code'].'-'.$alist['city_name'].'-'.$alist['country_name'].'" roundwayto="'.$alist['city_name'].' ('.$alist['city_code'].')">
					<div class="fli_name"><i class="fa fa-plane"></i> '.$alist['city_name'].' ('.$alist['airport_code'].')</div>
					<div class="airport_name">'.$alist['airport_name'].'<span>'.$alist['country_name'].'</span></div>
				</li>';
				}else if($request->type == 'is_search_from_val'){
						$output .= '<li class="" roundwayfromtop="'.$alist['city_code'].'-'.$alist['city_name'].'-'.$alist['country_name'].'" roundwayfrom="'.$alist['city_name'].' ('.$alist['city_code'].')">
					<div class="fli_name"><i class="fa fa-plane"></i> '.$alist['city_name'].' ('.$alist['airport_code'].')</div>
					<div class="airport_name">'.$alist['airport_name'].'<span>'.$alist['country_name'].'</span></div>
				</li>';
				}else if($request->type == 'is_search_to_val'){
						$output .= '<li class="" roundwaytotop="'.$alist['city_code'].'-'.$alist['city_name'].'-'.$alist['country_name'].'" roundwayto="'.$alist['city_name'].' ('.$alist['city_code'].')">
					<div class="fli_name"><i class="fa fa-plane"></i> '.$alist['city_name'].' ('.$alist['airport_code'].')</div>
					<div class="airport_name">'.$alist['airport_name'].'<span>'.$alist['country_name'].'</span></div>
				</li>';
				}else{
					$output .= '<li class="" onewaytotop="'.$alist['city_code'].'-'.$alist['city_name'].'-'.$alist['country_name'].'" onewayto="'.$alist['city_name'].' ('.$alist['city_code'].')">
					<div class="fli_name"><i class="fa fa-plane"></i> '.$alist['city_name'].' ('.$alist['airport_code'].')</div>
					<div class="airport_name">'.$alist['airport_name'].'<span>'.$alist['country_name'].'</span></div>
				</li>';
				} 
				
			}
			
		}else{
			$output = '';
		}
		 $data = array(
       'table_data'  => $output,
       'ddd'  => 'city_name LIKE'.$query
      );

      echo json_encode($data);
	}
	
	public function ApplyCoupon(Request $request){
		$requestData 		= 	$request->all();
		$data = array();
		if(@$requestData['coupon_code'] != ''){
			$today = date('Y-m-d');
			if(Coupon::where('coupon_code',@$requestData['coupon_code'])->whereDate('start_date','<=', $today)->whereDate('end_date','>=', $today)->where('status',1)->exists()){
				$couponvalue = Coupon::where('coupon_code',@$requestData['coupon_code'])->whereDate('start_date','<=', $today)->whereDate('end_date','>=', $today)->where('status',1)->first();
				if($couponvalue->no_of_coupon != ''){
					if($couponvalue->no_of_coupon >= $couponvalue->used_count){
						$data = array('success'=>true, 'message'=>'Coupon Code applied successfully', 'coupondetail' =>$couponvalue);
					}else{
						$data = array('success'=>false, 'message'=>'Coupon Code not found');
					}
				}else{
					$data = array('success'=>true, 'message'=>'Coupon Code applied successfully', 'coupondetail' =>$couponvalue);
				}
				
			}else{
				$data = array('success'=>false, 'message'=>'Coupon Code not found');
			}
			 echo json_encode($data);
			 die;
		}
	}
	public function FlightStatus(Request $request){
		return view('under_construction');
	}
	
	public function viewTicket(Request $request){
		if(isset($_GET['ticket']) && isset($_GET['email'])){
			$ticket = $_GET['ticket']; 
			$email = $_GET['email'];
			$query 		= BookingDetail::where('pnr','=',$ticket )->orwhere('booking_id',$ticket)->with(['user']);
			$query->whereHas('user', function ($q) use($email){
					$q->where('email', '=', $email);
				});			
				$lists		= $query->first();
				if(BookingDetail::where('id', '=', $lists->id)->exists()) 
				{
					$fetchedData = BookingDetail::where('id',$lists->id)->with(['user'])->first();
					 return view('Agent.flights.ticket', compact(['fetchedData']));
				}
				else
				{
					//return Redirect::to('/admin/contact')->with('error', 'Ticket Not Exist');
				}	
		}	
	}
}
?>