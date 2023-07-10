<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

//use App\Destination;
use Log;
use Config;
use Cookie;
use Session;
use App\HotelList;
use App\HotelData;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class HotelsearchController extends Controller
{
	public function __construct(Request $request)
    {	
	date_default_timezone_set('Asia/Kolkata');
	
		/* $siteData = WebsiteSetting::where('id', '!=', '')->first();
		\View::share('siteData', $siteData); */
	}
	
	public function index(){
		
		return view('hotel-search');
	}
	
	public function hotelCities(Request $request){
		if($request->has('keyword')){
		$hotelcodes = HotelList::where('city', 'LIKE', '%'.$request->keyword.'%')->groupBy('city')->get();
		?>
		<ul id="country-list">
		<?php
		foreach($hotelcodes as $country) {
			?>
			<li onClick="selectCountry('<?php echo $country->city; ?>');"><?php echo $country->city; ?></li>
			<?php
		}
		?>
		</ul>
		<?php
		}
		die;
	}

	public function HotelListing(Request $request){
		$countries = $this->getnationality();
		
		$citydat = \App\HotelCity::where('name', $request->city)->first();
	//	echo $citydat->city_code; die;
		if($hotelcodes = HotelData::where('city_code', $citydat->city_code)->exists()){
		
		$hotelcodescount = HotelData::where('city_code', $citydat->city_code)->count();
		$totalpages = ceil($hotelcodescount / 100);
		
		$hotelcodes = HotelData::where('city_code', $citydat->city_code)->orderby('hotel_code', 'desc')->paginate(100);
		
		//echo '<pre>'; print_r($hotelcodes); die;
		$city =$request->city;
		$page =isset($_GET['page']) ? $_GET['page'] : 1;
		$nationality =$request->nationality;
		Session::put('nationality', $nationality);
		$explodecin = explode('/', $request->cin);
		$explodecot = explode('/', $request->cOut);
		$cin 	= $explodecin[2].'/'.$explodecin[1].'/'.$explodecin[0];
		$cOut 	= $explodecot[2].'/'.$explodecot[1].'/'.$explodecot[0];
		$Rooms =$request->Rooms;
		$paxsde =$request->pax;
		
		
		foreach($hotelcodes as $hotelcode){
			$codes[] = $hotelcode->hotel_code;
		}
		
		$hotelreq['hotel_codes'] = @$codes;
		$hotelreq['checkin'] = date('Y-m-d',strtotime($cin));
		$hotelreq['checkout'] = date('Y-m-d',strtotime($cOut));
		$hotelreq['client_nationality'] = $nationality;
		$hotelreq['cutoff_time'] = '50000';
		$hotelreq['currency'] = 'INR';
		$hotelreq['rates'] = 'concise';
		$pax = explode('?',$request->pax);
		
		for($i=0; $i< $request->Rooms; $i++){
			$childers = array();
			$paxs = explode('_',$pax[$i]);
			$rooms[$i]['adults'] = $paxs[0];
			if(isset($paxs[1])){
				if(isset($paxs[2])){
					$childers[] = $paxs[2];
				}
				if(isset($paxs[3])){
					$childers[] = $paxs[3];
				}
				
				$rooms[$i]['children_ages'] = $childers;
			}
			 
		}
		$hotelreq['rooms'] = $rooms;
		
		$hotelreq['version'] = "2.0";
		   $hotelpost =  json_encode($hotelreq); 
		
		$curl = curl_init();
		 $hotelapi = \App\MyConfig::where('meta_key','hotel_api_key')->first()->meta_value;
		
		$hotel_endpoint = \App\MyConfig::where('meta_key','hotel_endpoint')->first()->meta_value;
		$data = array();
 
			$ajax = $request->ajax;
			$facilties = array();
			$maxprice = 0;
			$minprice = 0;
			
		
			return view('hotel-search', compact('data','city','cin','cOut','Rooms','paxsde','pax','minprice','maxprice','facilties','countries','hotelcodes','ajax','totalpages'));
			
		} else{
		$error = 'Record Not Found';
		return view('hotel-error-search', compact('error'));
	}
	
	}
	
	
	
	public function ajaxlisting(Request $request){
		$countries = $this->getnationality();
		$ch = array();
$res = array();
$conn = array();
		$citydat = \App\HotelCity::where('name', $request->city)->first();
	//	echo $citydat->city_code; die;
		//if($hotelcodes = HotelData::where('city_code', $citydat->city_code)->exists()){
		
		$hotelcodescount = HotelData::where('city_code', $citydat->city_code)->count();
		$totalpages = ceil($hotelcodescount / 100);
		$city_code = $citydat->city_code;
		$mh = curl_multi_init(); 
		$page = 1;
		for($idd=0; $idd<=$totalpages; $idd++){ 
		$codes = array();
	
		$start    = ($page - 1) * 100;
		$hotelcodes = DB::select("select * from hotel_datas where city_code = '$city_code' LIMIT $start,100 ");
		
		//echo '<pre>'; print_r($hotelcodes); die;
		
		$city =$request->city;
		$page =isset($_GET['page']) ? $_GET['page'] : 1;
		$nationality =$request->nationality;
		Session::put('nationality', $nationality);
		$explodecin = explode('/', $request->cin);
		$explodecot = explode('/', $request->cOut);
		$cin 	= $explodecin[2].'/'.$explodecin[1].'/'.$explodecin[0];
		$cOut 	= $explodecot[2].'/'.$explodecot[1].'/'.$explodecot[0];
		$Rooms =$request->Rooms;
		$paxsde =$request->pax;
		$hotelreq['checkin'] = date('Y-m-d',strtotime($cin));
		$hotelreq['checkout'] = date('Y-m-d',strtotime($cOut));
		$hotelreq['client_nationality'] = $nationality;
		$hotelreq['cutoff_time'] = '30000';
		$hotelreq['currency'] = 'INR';
		$hotelreq['rates'] = 'concise';
		$pax = explode('?',$request->pax);
		
		for($i=0; $i< $request->Rooms; $i++){
			$childers = array();
			$paxs = explode('_',$pax[$i]);
			$rooms[$i]['adults'] = $paxs[0];
			if(isset($paxs[1])){
				if(isset($paxs[2])){
					$childers[] = $paxs[2];
				}
				if(isset($paxs[3])){
					$childers[] = $paxs[3];
				}
				
				$rooms[$i]['children_ages'] = $childers;
			}
			 
		}
		$hotelreq['rooms'] = $rooms;
		
		$hotelreq['version'] = "2.0";
		foreach($hotelcodes as $hotelcode){
			$codes[] = $hotelcode->hotel_code;
		}
		$hotelreq['hotel_codes'] = @$codes;
		   $hotelpost =  json_encode($hotelreq); 
		
		
		
		 $hotelapi = \App\MyConfig::where('meta_key','hotel_api_key')->first()->meta_value;
		
		$hotel_endpoint = \App\MyConfig::where('meta_key','hotel_endpoint')->first()->meta_value;
		$data = array();
		$mapdata = array();
		$hotelprice = array(0,0);
		$facilties = array();
				$faciltiess = array();
				$minprice =0;
				$maxprice =0;
	 $conn[$idd] = curl_init();
	 //  Settings URL And the corresponding options 
  curl_setopt($conn[$idd], CURLOPT_URL, $hotel_endpoint.'api/v3/hotels/availability');
  curl_setopt($conn[$idd], CURLOPT_HEADER, 0);
  curl_setopt($conn[$idd], CURLOPT_RETURNTRANSFER, true);
 curl_setopt($conn[$idd], CURLOPT_TIMEOUT, 30);
 curl_setopt($conn[$idd], CURLOPT_ENCODING, '');
    curl_setopt($conn[$idd], CURLOPT_POST, true);
  curl_setopt($conn[$idd], CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
  curl_setopt($conn[$idd], CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($conn[$idd], CURLOPT_POSTFIELDS, $hotelpost);
  curl_setopt($conn[$idd], CURLOPT_IPRESOLVE ,CURL_IPRESOLVE_V4 );
  //302 Jump 
  curl_setopt($conn[$idd], CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($conn[$idd], CURLOPT_HTTPHEADER,  array(
			'api-key: '.$hotelapi,
			'Accept: application/json',
			'Accept-Encoding: application/gzip',
			'Content-Type: application/json'
		  ));
  //  Add handle 
  curl_multi_add_handle($mh, $conn[$idd]);
  $page++;
  
		}
$active = null;
// Anti-jamming writing: Execute batch handle 
do {
  $mrc = curl_multi_exec($mh, $active);
} while ($mrc == CURLM_CALL_MULTI_PERFORM);
while ($active && $mrc == CURLM_OK) {
  if (curl_multi_select($mh) != -1) {
    do {
      $mrc = curl_multi_exec($mh, $active);
    } while ($mrc == CURLM_CALL_MULTI_PERFORM);
  }
}

for ($idd=0; $idd<$totalpages; $idd++){ 
  // Gets the currently resolved cURL Related transmission information of 
  $info = curl_multi_info_read($mh);
  // Get request header information 
  $heards = curl_getinfo($conn[$idd]);
 
  // Gets the output text stream 
  $res[$idd] = curl_multi_getcontent($conn[$idd]);
  //  Remove curl A handle resource in a batch handle resource 
  curl_multi_remove_handle($mh, $conn[$idd]);
  // Shut down cURL Conversation 
  curl_close($conn[$idd]);
}
// Close all handles 
curl_multi_close($mh);


		 $hotellists = $res;
	//echo '<pre>'; print_r($hotellists); die;
	
$log = ['request' => $hotelpost,'response' => json_encode($hotellists)];
		$hotellog = new Logger('hotelrequest');
		$hotellog->pushHandler(new StreamHandler(storage_path('logs/hotelsearch.log')), Logger::INFO);
		$hotellog->info('hotelsearch', $log);
		//curl_close($curl);
		

		
	
			
		/*  if(isset($data->errors)){
			$error = $data->errors[0]->messages[0];
			echo json_encode(array('success'=>false));
		}else{ */
		$dataho = '';
		$minmaxprice = array();
			$faciltiesarray = array();
			 $mealplans = array();
			$mapdata = array();
			$hotelnamedata = array();
				foreach($hotellists as $httlist){
					$data =  json_decode($httlist);
			/* echo '<pre>'; print_r($data);
			die; */
			if(isset($data->hotels)) {
				
					foreach($data->hotels aS $hotels){
						if(@$hotels->images->url != ''){
							$mapimage = @$hotels->images->url;
						}else{
							$mapimage = \URL::to('public/images/9755ac2262968d28c2e05d5b5592b77a.jpg');
						}
						$LatLng = array();
						$LatLng[] = (object) array(
								'lat' => trim($hotels->geolocation->latitude),
								'lng' => trim($hotels->geolocation->longitude)
							);
							$rate = '';
							for($i=0; $i<round(@$hotels->category); $i++){
								$rate .= '<i class="fa fa-star"></i>';
							}
						$mapdata[] = array(
							'placeName' => @$hotels->name,
							'placeaddress' => @$hotels->address,
							'placeImage' => $hotels->images->url,
							'placerate' => $rate,
							'placeprice' => @$hotels->min_rate->price,
							'LatLng' => $LatLng
						);
						$hotelnamedata[] = @$hotels->name;
						
						$pernight = @$hotels->min_rate->price;
			
			$facilitiess = ''; 
			if(isset($hotels->facilities)){
							$facilities = explode(';', $hotels->facilities);
							
							foreach($facilities aS $fd){
								if(!in_array(trim($fd), $faciltiesarray)){
$slug=preg_replace('/[^A-Za-z0-9-]+/', '-', trim($fd));
 $facilitiess .=  trim(@$slug).';'; 
								}
							}
							
							 } 
							
							 $mealplanss = '';
							 if(isset($hotels->min_rate->rate_comments->mealplan)){
								 if($hotels->min_rate->rate_comments->mealplan != ''){
									 
									 $mealplanss = strtolower(@$hotels->min_rate->rate_comments->mealplan);
									 $mealplanss=preg_replace('/[^A-Za-z0-9-]+/', '-', trim($mealplanss));
									 if(!in_array($mealplanss, array_column($mealplans, 'slug'))){
										$slug = $mealplanss;
										$mealplans[] = array('slug'=>$slug,'name'=> trim($hotels->min_rate->rate_comments->mealplan));
										
									 }
								 }else{
									 $mealplanss = 'None';
								 }
							 }
							
			$dataho .= '<div class="refendable11onword" >';
			$dataho .= '<div class="hotelnamesearch" hotelname="'.@$hotels->name.'">';
			$dataho .= '<div class="price1" price="'.$pernight.'" data-price="'.$pernight.'" >';
			$dataho .= '<div class="mealplans" mealplan="'.$mealplanss.'" >';
			$dataho .= '<div class="facilities" facilities="'.rtrim(@$facilitiess,";").'" >';
			$dataho .= '<div class="starsscount" stars="'. round(@$hotels->category).'">';
			$dataho .= '<div class="hotel_item">
				<div class="hotel_img">
					<a href="#">';
					 if(@$hotels->images->url != ''){ 
						$dataho .= '<img src="'.@$hotels->images->url.'" alt=""/>';
					 } else{
						
						$dataho .= '<img src="'.\URL::to('public/images/9755ac2262968d28c2e05d5b5592b77a.jpg').'" alt=""/>';
						
					}
						
					$dataho .= '</a></div><div class="hotel_info"><div class="left"><div class="title_wrap">';
							$dataho .= '<h3 class="title"><a target="_blank" href="'.\URL::to('Hotel/HotelDetail').'?city='.$city.'&cin='.$cin.'&cOut='.$cOut.'&Hotel=NA&Rooms='.$Rooms.'&pax='.$paxsde.'&sid='.@$data->search_id.'&hid='. @$hotels->hotel_code.'">'.@$hotels->name.'</a></h3>'; 
							$dataho .= '<div class="title_badges"> 
								<div class="hotel_star">';
									 for($i=0; $i<round(@$hotels->category); $i++){ 
										$dataho .= '<i class="fa fa-star"></i>';
									 } 
								$dataho .= '</div>
							
							</div>
						</div>
						<div class="hotel_search_address">';
							$dataho .= '<span><i class="fa fa-map-marker-alt"></i> '. @$hotels->address.'</span>
						</div> <div class="tripadvisior_review">';
							$dataho .= '<img class="item-left-img" src="'.\URL::to('public/img/ta-45.png').'" alt="Trip Advisior">';
						$dataho .= '</div>
						<div class="room_amenities">';
					
							if(isset($hotels->facilities)){
							$facilities = explode(';', $hotels->facilities);
							
							foreach($facilities aS $fd){
								if(!in_array(trim($fd), $faciltiesarray)){
$slug=preg_replace('/[^A-Za-z0-9-]+/', '-', trim($fd));
//$res = preg_replace('/[^a-zA-Z0-9_ -]/s','-',trim($fd));
				$faciltiesarray[] = array('slug'=>$slug,'name'=> trim($fd));
								}
							}
							
							$dataho .= '<ul>';
							 for($i=0;$i<5; $i++){
								if(isset($facilities[$i])){
									
								$dataho .= '<li>'.trim(@$facilities[$i]).'</li>';
								 } } 
							$dataho .= '</ul>';
						 } 
						$dataho .= '</div>
					</div>
					<div class="right">
						<div class="room_price">
							<span class="price_value"><i class="fas fa-rupee-sign"></i> ';
							
							$noofnight = $data->no_of_nights;
							$pernight = @$hotels->min_rate->price;
							$minmaxprice[] = $pernight;
							$dataho .= @round($pernight).'</span>';
							$dataho .= '<span class="price_tag">Per Night</span>';
						
						$dataho .= '</div>';
						$dataho .= '<div class="select_hotel_btn">';
							$dataho .= '<a target="_blank" href="'.\URL::to('Hotel/HotelDetail').'?city='.$city.'&cin='.$cin.'&cOut='.$cOut.'&Hotel=NA&Rooms='.$Rooms.'&pax='.$paxsde.'&sid='.@$data->search_id.'&hid='. @$hotels->hotel_code.'">View Room <i class="fa fa-angle-right"></i></a> 
						</div>
					</div> 
					<div class="clearfix"></div>
					
					
				</div> 
				<div class="clearfix"></div>
			</div>
			</div>
			</div>
			</div>
			</div>
			</div>
			</div>';
			
			
					} 
			}
			}
		
		//	$datare = ob_get_clean();
			$filtersMeta = array(
				'hotelprice' => array('price' => $minmaxprice),
				'facilties' => $faciltiesarray,
				'mealplans' => $mealplans,
				'hotelnamedata' => $hotelnamedata
			);
			return json_encode(array('success'=>true, 'totalcount'=> 0, 'hotelsdata'=> $dataho, 'filtersMeta'=> $filtersMeta, 'mapdata' => $mapdata));
			die;
		//}
	}

public function hotelsearchview(Request $request){
	$citydat = \App\HotelCity::where('name', $request->city)->first();
		if($hotelcodes = HotelData::where('city_code', $citydat->city_code)->exists()){
		$hotelcodes = HotelData::where('city_code', $citydat->city_code)->orderby('hotel_code', 'desc')->paginate(100);
		
		
		$city =$request->city;
		$starRating =$request->starRating;
		
		 $cin =$request->cin;
		$explodeci = explode('/', $cin);
		$cOut =$request->cOut;
		$explodeco = explode('/', $cOut);
		$Rooms =$request->Rooms;
		$paxsde =$request->pax;
		$sortprice =$request->sortprice;
		foreach($hotelcodes as $hotelcode){
			$codes[] = $hotelcode->hotel_code;
		}
		
		$hotelreq['hotel_codes'] = @$codes;
		$hotelreq['checkin'] = $explodeci[2].'-'.$explodeci[1].'-'.$explodeci[0];
		$hotelreq['checkout'] = $explodeco[2].'-'.$explodeco[1].'-'.$explodeco[0];
		//$hotelreq['checkout'] = date('Y-m-d',strtotime($request->cOut));
		$hotelreq['client_nationality'] = 'IN';
		$hotelreq['cutoff_time'] = '30000';
		$hotelreq['currency'] = 'INR';
		$hotelreq['rates'] = 'concise';
		//$hotelreq['hotel_category'] = ;
		$pax = explode('?',$request->pax);
		
		for($i=0; $i< $request->Rooms; $i++){
			$childers = array();
			$paxs = explode('_',$pax[$i]);
			$rooms[$i]['adults'] = $paxs[0];
			if(isset($paxs[1])){
				if(isset($paxs[2])){
					$childers[] = $paxs[2];
				}
				if(isset($paxs[3])){
					$childers[] = $paxs[3];
				}
				
				$rooms[$i]['children_ages'] = $childers;
			}
			 
		}
		$hotelreq['rooms'] = $rooms;
		
		$hotelreq['version'] = "2.0";
		//echo '<pre>'; print_r($hotelreq);
		 $hotelpost =  json_encode($hotelreq);
		
		$curl = curl_init();
		$hotelapi = \App\MyConfig::where('meta_key','hotel_api_key')->first()->meta_value;
		$hotel_endpoint = \App\MyConfig::where('meta_key','hotel_endpoint')->first()->meta_value;
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $hotel_endpoint.'api/v3/hotels/availability',
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
			'Accept-Encoding: application/gzip',
			'Content-Type: application/json'
		  ),
		));

		$hotellists = curl_exec($curl);

		curl_close($curl);
		$data =  json_decode($hotellists);
		//echo '<pre>'; print_r($data); die;
		 if(isset($data->errors)){
			$error = $data->errors[0]->messages[0];
			//return view('hotel-error-search', compact('error'));
		}else{
			if(isset($data->hotels)) {
				$datad = array(); 
				$hotelprice = array();
				$faciltiess = array();
				foreach($data->hotels aS $hotels){
					$hotelprice[] = @$hotels->min_rate->price;
					if($request->has('hotelname') && $request->hotelname !=''){
						//echo '1';
						if (strpos(strtolower($hotels->name),strtolower($request->hotelname)) !== FALSE) {
							$datad[] = array(
								'image' =>@$hotels->images->url,
								'name' =>$hotels->name,
								'category' =>@$hotels->category,
								'address' =>@$hotels->address,
								'facilities' =>@$hotels->facilities,
								'price' =>@$hotels->min_rate->price,
								'search_id' =>@$data->search_id,
								'hotel_code' =>@$hotels->hotel_code,
							);
						}
					}else if($request->has('starRating') && !$request->has('hotelfacilties') && $request->maxprice == '' && $request->minprice == ''){
						//echo '2';
						if(in_array($hotels->category, $starRating)){
							$datad[] = array(
								'image' =>@$hotels->images->url,
								'name' =>$hotels->name,
								'category' =>@$hotels->category,
								'address' =>@$hotels->address,
								'facilities' =>@$hotels->facilities,
								'price' =>@$hotels->min_rate->price,
								'search_id' =>$data->search_id,
								'hotel_code' =>$hotels->hotel_code,
							);
						}
					}else if(!$request->has('starRating') && $request->has('hotelfacilties') && $request->maxprice =='' && $request->minprice ==''){
						//echo '3';
						$search_this = $request->hotelfacilties;
						$facilities = explode(';', $hotels->facilities);
						$fac = array();
						foreach($facilities as $fa){
							$fac[] = trim($fa);
						}
						 $check = (count(array_intersect($fac, $search_this))) ? true : false; 
						if ($check) {
							$datad[] = array(
								'image' =>@$hotels->images->url,
								'name' =>$hotels->name,
								'category' =>@$hotels->category,
								'address' =>@$hotels->address,
								'facilities' =>@$hotels->facilities,
								'price' =>$hotels->min_rate->price,
								'search_id' =>@$data->search_id,
								'hotel_code' =>@$hotels->hotel_code,
							);
						}
					}else if($request->has('starRating') && $request->has('hotelfacilties') && $request->maxprice =='' && $request->minprice ==''){
						//echo '4';
						$search_this = $request->hotelfacilties;
						$facilities = explode(';', $hotels->facilities);
						$fac = array();
						foreach($facilities as $fa){
							$fac[] = trim($fa);
						}
						$check = (count(array_intersect($fac, $search_this))) ? true : false; 
						if (in_array($hotels->category, $starRating) && $check) {
							$datad[] = array(
								'image' =>@$hotels->images->url,
								'name' =>$hotels->name,
								'category' =>@$hotels->category,
								'address' =>@$hotels->address,
								'facilities' =>@$hotels->facilities,
								'price' =>@$hotels->min_rate->price,
								'search_id' =>@$data->search_id,
								'hotel_code' =>@$hotels->hotel_code,
							);
						}
					}else if(!$request->has('starRating') && !$request->has('hotelfacilties')  && $request->has('minprice')&& $request->has('maxprice') && $request->maxprice !=''&& $request->minprice !=''){
						//echo '5';
						$minprice = $request->minprice;
						$maxprice = $request->maxprice;
						
						if ($hotels->min_rate->price >= $minprice && $hotels->min_rate->price <= $maxprice) { 
							$datad[] = array(
								'image' =>@$hotels->images->url,
								'name' =>$hotels->name,
								'category' =>@$hotels->category,
								'address' =>@$hotels->address,
								'facilities' =>@$hotels->facilities,
								'price' =>@$hotels->min_rate->price,
								'search_id' =>@$data->search_id,
								'hotel_code' =>@$hotels->hotel_code,
							);
						 
							}
					}else if($request->has('starRating') && !$request->has('hotelfacilties')  && $request->has('minprice')&& $request->has('maxprice') && $request->maxprice !=''&& $request->minprice !=''){
						//echo '5';
						$minprice = $request->minprice;
						$maxprice = $request->maxprice;

						if ($hotels->min_rate->price >= $minprice && $hotels->min_rate->price <= $maxprice && in_array($hotels->category, $starRating)) { 
							$datad[] = array(
								'image' =>@$hotels->images->url,
								'name' =>$hotels->name,
								'category' =>@$hotels->category,
								'address' =>@$hotels->address,
								'facilities' =>@$hotels->facilities,
								'price' =>@$hotels->min_rate->price,
								'search_id' =>@$data->search_id,
								'hotel_code' =>@$hotels->hotel_code,
							);
						 
							}
					}else if($request->has('starRating') && $request->has('hotelfacilties')   && $request->has('minprice')&& $request->has('maxprice') && $request->maxprice !=''&& $request->minprice !=''){
						//echo '5';
						$minprice = $request->minprice;
						$maxprice = $request->maxprice;
						$search_this = $request->hotelfacilties;
						$facilities = explode(';', $hotels->facilities);
						$fac = array();
						foreach($facilities as $fa){
							$fac[] = trim($fa);
						}
						$check = (count(array_intersect($fac, $search_this))) ? true : false; 
						if ($hotels->min_rate->price >= $minprice && $hotels->min_rate->price <= $maxprice && in_array($hotels->category, $starRating) && $check) { 
							$datad[] = array(
								'image' =>@$hotels->images->url,
								'name' =>$hotels->name,
								'category' =>@$hotels->category,
								'address' =>@$hotels->address,
								'facilities' =>@$hotels->facilities,
								'price' =>@$hotels->min_rate->price,
								'search_id' =>@$data->search_id,
								'hotel_code' =>@$hotels->hotel_code,
							);
						 
							}
					}else{
						$datad[] = array(
								'image' =>@$hotels->images->url,
								'name' =>$hotels->name,
								'category' =>@$hotels->category,
								'address' =>@$hotels->address,
								'facilities' =>@$hotels->facilities,
								'price' =>$hotels->min_rate->price,
								'search_id' =>@$data->search_id,
								'hotel_code' =>@$hotels->hotel_code,
							);
					}
					$hfacility = explode(';', @$hotels->facilities);
					foreach($hfacility aS $f){
						$faciltiess[] = trim($f);
					}
				}
				$datad = $this->sortAssociativeArrayByKey($datad, "price", $sortprice);
				$minprice = min($hotelprice);
				$maxprice = max($hotelprice);
				$facilties = array();
				foreach($faciltiess aS $fd){
						if(!in_array(trim($fd), $facilties)){
							$facilties[] = trim($fd);
						}
					}
				
				echo view('ajaxhotel', compact('datad','city','cin','cOut','Rooms','paxsde','pax','minprice','maxprice','facilties','sortprice','hotelcodes'));
			} 
			
			//return view('hotel-search', compact('data','city','cin','cOut','Rooms','paxsde','pax','minprice','maxprice','facilties'));
		} 
	}else{
		$error = 'Record Not Found';
		//return view('hotel-error-search', compact('error'));
	}
	}  	
	
	public function HotelDetail(Request $request){
		$sid = $request->sid;
		$hid = $request->hid;
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
		$detail =  json_decode($response);
		//echo '<pre>'; print_r($detail); die;
		 if(isset($detail->errors)){
			echo $detail->errors[0]->messages[0];
		}else{
			
			$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $hotel_endpoint.'api/v3/hotels/'.$hid.'/images?version=2.0',
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
		$images =  json_decode($response);
			
			return view('hotel-detail', compact('detail','images'));
		}
	}
}
?>