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
use App\HotelImage;
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
		if($hotelcodes = \App\Grnhotel::where('city_code', $citydat->city_code)->exists()){
		
		$hotelcodescount = \App\Grnhotel::where('city_code', $citydat->city_code)->count();
		$totalpages = ceil($hotelcodescount / 60);
		
		$hotelcodes = \App\Grnhotel::where('city_code', $citydat->city_code)->orderby('hotel_code', 'desc')->paginate(60);
		
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
	
	public function ajaxpricelisting(Request $request){
		$citydat = \App\HotelCity::where('name', $request->city)->first();
		$hotelcodescount = \App\Grnhotel::where('city_code', $citydat->city_code)->count();
		
		$totalpages = ceil($hotelcodescount / 60);
		$city_code = $citydat->city_code;
		$isdomestic = $citydat->country_code;
		$hotelcodes = \App\Grnhotel::where('city_code', $citydat->city_code)->orderby('name', 'ASC')->paginate(60);
		
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
		
		$codes= array();	
		foreach($hotelcodes as $hotelcode){
			 $codes[] = $hotelcode->hotel_code;
			//echo  $hotelcode->hotel_code.'<br>';
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
		$mapdata = array();
		$hotelprice = array(0,0);
		$facilties = array();
				$faciltiess = array();
				$minprice =0;
				$maxprice =0;
	
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
		
		$log = ['request' => $hotelpost,'response' => $hotellists];
		$hotellog = new Logger('hotelrequest');
		$hotellog->pushHandler(new StreamHandler(storage_path('logs/hotelsearch.log')), Logger::INFO);
		$hotellog->info('hotelsearch', $log);
		
		curl_close($curl);
		$data =  json_decode($hotellists);
		$hoteldata = array();
		$mealplans = array();
		if(isset($data->hotels)) {
			$date1 = new \DateTime($explodecin[2].'-'.$explodecin[1].'-'.$explodecin[0]);
		$date2 = new \DateTime($explodecot[2].'-'.$explodecot[1].'-'.$explodecot[0]);
		 $numberOfNights = $date2->diff($date1)->format("%a");
			foreach($data->hotels as $hotels){
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
			  if(@$hotels->images->url != ''){
						$mapimage = @$hotels->images->url;
					}else{
						$mapimage = \URL::to('public/images/9755ac2262968d28c2e05d5b5592b77a.jpg');
					}
					
				
					
					$hotel_code = @$hotels->hotel_code;
					
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
					$perdayprice = round(@$hotels->min_rate->price / $numberOfNights);
					$mainprice = @$hotels->min_rate->price;
					if($hotelmarkup->amount_type == 'Percentage'){
						$amount = (@$perdayprice * $hotelmarkup->markup_fee) / 100;
						$mainamount = (@$mainprice * $hotelmarkup->markup_fee) / 100;
					}else{
						$amount = $hotelmarkup->markup_fee;
						$mainamount = $hotelmarkup->markup_fee;
					}
					
					$calculateamount = $perdayprice + $amount;
					$maincalculateamount = $mainprice + $mainamount;
				$hoteldata[@$hotels->hotel_code] = array(
					'price'=> round(@$calculateamount),
					'mainprice'=> @$maincalculateamount,
					'code'=> @$hotels->hotel_code,
					'sid'=> @$data->search_id,
					'mealplans'=> @$mealplans,
					
				
					
					'mealplan'=> @$mealplanss,
				);
			}
		}
		$hoteldatanew = array();
		foreach($codes as $cdlist){
			if(array_key_exists($cdlist, $hoteldata)){
				$hoteldatanew[] = $hoteldata[$cdlist];
			}else{
				$hoteldatanew[] = array(
					'price'=> 'Not abailable',
					'code'=> @$cdlist,
					'sid'=> '',
				);
			}
			
		}
		
		
		return json_encode(array('success'=>true, 'hotels'=> $hoteldatanew));
		die;
	}
	public function ajaxlisting(Request $request){
		$countries = $this->getnationality();
		
		$citydat = \App\HotelCity::where('name', $request->city)->first();
	//	echo $citydat->city_code; die;
		//if($hotelcodes = HotelData::where('city_code', $citydat->city_code)->exists()){
		
		$hotelcodescount = \App\Grnhotel::where('city_code', $citydat->city_code)->count();
		$hotelcodes = \App\Grnhotel::select('latitude', 'hotel_code', 'longitude', 'category', 'name', 'address')->where('city_code', $citydat->city_code)->with(['available_images','hotelfac'])->orderby('name', 'ASC')->paginate(60);
		
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
	
			ob_start();
			$minmaxprice = array();
			$faciltiesarray = array();
			 $mealplans = array();
			$mapdata = array();
			$hotelnamedata = array();
			if($hotelcodes) {
				/* echo '<pre>'; print_r($hotelcodes);
				die; */
					foreach($hotelcodes aS $hotels){
						if(isset($hotels->available_images->image)){
							$mapimage = 'https://images.grnconnect.com/'.@$hotels->available_images->image;
							$main_image = 'https://images.grnconnect.com/'.@$hotels->available_images->image;
						}else{
							$mapimage = \URL::to('public/images/9755ac2262968d28c2e05d5b5592b77a.jpg');
							$main_image = \URL::to('public/images/9755ac2262968d28c2e05d5b5592b77a.jpg');
						}
					
						$LatLng = array();
						$LatLng[] = (object) array(
								'lat' => trim($hotels->latitude),
								'lng' => trim($hotels->longitude)
							);
							$rate = '';
							for($i=0; $i<round(@$hotels->category); $i++){
								$rate .= '<i class="fa fa-star"></i>';
							}
						$mapdata[] = array(
							'placeName' => @$hotels->name,
							'placeaddress' => @$hotels->address,
							'placeImage' => $main_image,
							'placerate' => $rate,
							'placeprice' => '',
							'LatLng' => $LatLng
						);
						$hotelnamedata[] = @$hotels->name;
						
						$pernight = '';
			
						$facilitiess = ''; 
						if(isset($hotels->hotelfac)){
							$facilities = $hotels->hotelfac;
							foreach($facilities aS $fd){
								
									if(!in_array(trim($fd->name), $faciltiesarray)){
										$slug=preg_replace('/[^A-Za-z0-9-]+/', '-', trim($fd->name));
										$facilitiess .=  trim(@$slug).';'; 
									}
								
							}
						} 
							
							 $mealplanss = '';
							
							 ?>
			<div class="refendable11onword" id="code_<?php echo @$hotels->hotel_code; ?>">
			<div class="hotelnamesearch" hotelname="<?php echo @$hotels->name; ?>">
			<div class="price1" price="null" data-price="null" >
			<div class="mealplans" mealplan="<?php echo $mealplanss; ?>" >
			<div class="facilities" facilities="<?php echo rtrim(@$facilitiess,';'); ?>" >
			<div class="starsscount" stars="<?php echo round(@$hotels->category); ?>">
			<div class="hotel_item" >
				<div class="hotel_img">
					<a target="_blank" class="bookinglink" href="javascript:;">
						<img src="<?php echo @$main_image; ?>" alt=""/>
					
					</a>
				</div>
				<div class="hotel_info">
					<div class="left">
						<div class="title_wrap">
							<h3 class="title"><a target="_blank" class="bookinglink" href="javascript:;"><?php echo @$hotels->name; ?></a></h3> 
							<div class="title_badges"> 
								<div class="hotel_star">
									<?php for($i=0; $i<round(@$hotels->category); $i++){ ?>
										<i class="fa fa-star"></i>
									<?php } ?>
								</div>
							
							</div>
						</div>
						<div class="hotel_search_address">
							<span><a href="javascript:;" country="<?php echo @$hotels->country; ?>" address="<?php echo @$hotels->address; ?>" class="openmap" lat="<?php echo $hotels->latitude; ?>" long="<?php echo $hotels->longitude; ?>"><i class="fa fa-map-marker-alt"></i> <?php echo @$hotels->address; ?></a></span>
							<!--<span class="distance">14km from center</span>-->
						</div> 
						<div class="tripadvisior_review" style="display:none;">
							<img class="item-left-img" src="<?php //echo \URL::to('public/img/ta-45.png'); ?>" alt="Trip Advisior">
						</div>
						<div class="room_amenities">
							<!--<span>Amenities</span>-->
							<?php
						
							if(isset($hotels->hotelfac)){
							$facilities =	$hotels->hotelfac;
							
							foreach($facilities aS $fd){
								
									if(!in_array(trim($fd->name), $faciltiesarray)){
										$slug=preg_replace('/[^A-Za-z0-9-]+/', '-', trim($fd->name));
										$faciltiesarray[] = array('slug'=>$slug,'name'=> trim($fd->name));
									}
		
							}
							
							?>
							<ul>
							<?php for($i=0;$i<5; $i++){
								if(isset($faciltiesarray[$i])){
									$list = \App\GrnFac::where('name', trim(@$faciltiesarray[$i]['name']))->first();
								//	if(@$list->name != ''){
									?>
									<li><!--<i class="fa fa-tv"></i>--><?php  if(@$list->type == 'image'){ if($list->icon != ''){ ?><img width="30" src="<?php echo \URL::to('/public/img/hotel_img').'/'.@$list->icon; ?>" class=""/><?php } }else{ ?><i class="<?php echo @$list->icon; ?>"></i> <?php }  ?><?php echo trim(@$faciltiesarray[$i]['name']); ?></li>
									<?php //} 
									} } ?>
							</ul>
							<?php } ?>
						</div>
					</div>
					<div class="right" >
						<div class="room_price_res" style="text-align: right;">
							<img src="<?php echo \URL::to('/public/images/loading (1).gif')?>" class="">
						</div>
						<div class="room_price" style="display:none;">
							<span class="price_value"><i class="fas fa-rupee-sign"></i> 
							</span>
							<span class="price_tag">Per Night</span>
							<span class="total_cost">(Total Cost)</span>
						</div>
						<div class="select_hotel_btn" style="display:none;">
							<a target="_blank" href="<?php echo \URL::to('Hotel/HotelDetail'); ?>?city=<?php echo $city; ?>&cin=<?php echo $cin; ?>&cOut=<?php echo $cOut; ?>&Hotel=NA&Rooms=<?php echo $Rooms; ?>&pax=<?php echo $paxsde; ?>&sid=<?php echo @$data->search_id; ?>&hid=<?php echo @$hotels->hotel_code; ?>">View Room <i class="fa fa-angle-right"></i></a> 
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
			</div>
			<?php
					} 
			}
			$datare = ob_get_clean();
			$filtersMeta = array(
				'hotelprice' => array('price' => $minmaxprice),
				'facilties' => $faciltiesarray,
				'mealplans' => $mealplans,
				'hotelnamedata' => $hotelnamedata
			);
			return json_encode(array('success'=>true, 'totalcount'=> 0, 'hotelsdata'=> $datare, 'filtersMeta'=> $filtersMeta, 'mapdata' => $mapdata));
			die;
		
	}

public function hotelsearchview(Request $request){
	$citydat = \App\HotelCity::where('name', $request->city)->first();
		if($hotelcodes = HotelData::where('city_code', $citydat->city_code)->exists()){
		$hotelcodes = HotelData::where('city_code', $citydat->city_code)->orderby('hotel_code', 'desc')->paginate(60);
		
		
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
			$error = @$data->errors[0]->messages[0];
			return view('hotel-error-search', compact('error'));
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
		return view('hotel-error-search', compact('error'));
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
			$error = $detail->errors[0]->messages[0];
			return view('hotel-error-search', compact('error'));
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