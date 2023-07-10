<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

 use PDF;
 use DateTime;

use Config;
use Log;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
class HotelFetchs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'HotelFetchs:hotelfetchs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User Name Change Successfully';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	
		
		$citydats = \App\HotelCity::get();
$i = 0;
		foreach($citydats as $citydat){
			//if(!\App\Grnhotel::where('city_code', @$citydat->city_code)->exists()){
			$log = ['email' => $citydat->city_code,];
						$orderLog = new Logger('hotelcheck');
				$orderLog->pushHandler(new StreamHandler(storage_path('logs/hotelcheck.log')), Logger::INFO);
				$orderLog->info('hotelcheck', $log);
			  $i++;
			$ch = array();
			$res = array();
			$conn = array();
		$hotelcodescount = \App\HotelData::where('city_code', $citydat->city_code)->count();
		$totalpages = ceil($hotelcodescount / 100);
		$city_code = $citydat->city_code;
		$mh = curl_multi_init(); 
		$page = 1;
		for($idd=0; $idd<=$totalpages; $idd++){ 
		$codes = array();
		$codesdd = array();
	
		$start    = ($page - 1) * 100;
		$hotelcodes = DB::select("select * from hotel_datas where city_code = '$city_code' LIMIT $start,100 ");
			
		//echo '<pre>'; print_r($hotelcodes); die;
	
		
		$nationality ='IN';

		
		$Rooms =1;
		$paxsde =2;
		$curentdate = date('Y-m-d');
		/* $hotelreq['checkin'] = date('Y-m-d',strtotime($curentdate. " + 1 day"));
		$hotelreq['checkout'] = date('Y-m-d',strtotime($hotelreq['checkin']. " + 1 day")); */
		$hotelreq['checkin'] = '2022-05-11';
		$hotelreq['checkout'] = '2022-05-12';
		$hotelreq['client_nationality'] = $nationality;
		$hotelreq['cutoff_time'] = '30000';
		$hotelreq['currency'] = 'INR';
		$hotelreq['rates'] = 'concise';
		$pax = explode('?',2);
		
		for($i=0; $i< 1; $i++){
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
		$log = ['hoteldata' => $hotellists,];
						$orderLog = new Logger('hoteldata');
				$orderLog->pushHandler(new StreamHandler(storage_path('logs/hoteldata.log')), Logger::INFO);
				$orderLog->info('hoteldata', $log); 
		 foreach($hotellists as $httlist){
			 $data =  json_decode($httlist);
			 if(isset($data->hotels)) {
				 foreach($data->hotels aS $hotels){
					 if(@$hotels->images->url != ''){
						$mapimage = @$hotels->images->url;
					}else{
						$mapimage = \URL::to('public/images/9755ac2262968d28c2e05d5b5592b77a.jpg');
					}
					
					if(\App\Grnhotel::where('hotel_code', @$hotels->hotel_code)->exists()){
						/* $hoteld = \App\Grnhotel::where('hotel_code', @$hotels->hotel_code)->first();
						$obj = \App\Grnhotel::find($hoteld->id);
						$obj->name = @$hotels->name;
						$obj->main_image = @$mapimage;
						
						$obj->longitude = $hotels->geolocation->longitude;
						$obj->latitude = $hotels->geolocation->latitude;
						$obj->facilities = @$hotels->hotel_code;
						$obj->country = @$hotels->country;
						$obj->city_code = @$hotels->city_code;
						$obj->category = @$hotels->category;
						$obj->address = @$hotels->address;
						$obj->safe2stay = json_encode(@$hotels->safe2stay);
						$obj->status = 1;
						$obj->slug = $this->createSlug('grnhotels',@$hotels->name);
						$obj->description = @$hotels->description; */
					}else{
						$facilitiesd ='';
						if(isset($hotels->facilities)){
							$facilities = explode(';', $hotels->facilities);
							foreach($facilities aS $fd){
								if(\App\GrnFac::where('name', trim(@$fd))->exists()){
									$li = \App\GrnFac::where('name', trim(@$fd))->first();
									$facilitiesd .= $li->id.',';
								}else{
									$objww = new \App\GrnFac;
									$objww->name = trim(@$fd);
									$objww->save();
									
									$facilitiesd .= $objww->id.',';
								}
							}
						}
						$obj = new \App\Grnhotel;
						$obj->hotel_code = @$hotels->hotel_code;
						$obj->name = @$hotels->name;
						$obj->main_image = @$mapimage;
						$obj->longitude = $hotels->geolocation->longitude;
						$obj->latitude = $hotels->geolocation->latitude;
						$obj->facilities = rtrim(@$facilitiesd,',');
						$obj->country = @$hotels->country;
						$obj->city_code = @$hotels->city_code;
						$obj->category = @$hotels->category;
						$obj->address = @$hotels->address;
						$obj->safe2stay = json_encode(@$hotels->safe2stay);
						$obj->meal_plan = @$hotels->min_rate->rate_comments->mealplan;
						$obj->status = 1;
						$obj->slug = $this->createSlug('grnhotels',@$hotels->name);
						$obj->description = @$hotels->description;
						
						$obj->save();
						
						 $this->info($citydat->name.' '.@$hotels->name.' hotel inserted<br>');
					
					}
				 }
			 }
		 }
		 
			if ($i > 0 && $i % 1 == 0) { // After every 5 Loop Item Executions
				set_time_limit (30);
			}
		// }
		 }
		
    }
	
	public static function createSlug($table, $title, $id = 0)
    {
        // Normalize the title
        $slug = str_slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = Self::getRelatedSlugs($table, $slug, $id);

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }
	
	public static function getRelatedSlugs($table, $slug, $id = 0)
    {
        return DB::connection('mysql2')->table($table)->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)

            ->get();
    }
	
	
}
?>