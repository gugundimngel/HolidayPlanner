<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

//use App\Destination;

use Config;
use Cookie;


class HotelController extends Controller
{
	public function __construct(Request $request)
    {	
		/* $siteData = WebsiteSetting::where('id', '!=', '')->first();
		\View::share('siteData', $siteData); */
	}
	
	public function index(){
		$countries = $this->getnationality();
		//\Cache::put('singlerefetch','yyyy' , now()->addMinutes(25));
		//\Cache::forget('singlerefetch');
		return view('hotel', compact('countries'));
		//return view('under_construction');
	}
		
	public function ecash(){
		
		return view('under_construction');
	}
	
	public function hotelimport(){
		 $hotelcodescount = \App\HotelImage::where('main_image', 'Y')->count();
		$totalpages = ceil($hotelcodescount / 100);
		$page = 1;
		
		for($idd=0; $idd<=$totalpages; $idd++){ 
			$start    = ($page - 1) * 100;
			$hotelcodes = DB::connection('mysql2')->select("select * from hotel_images where main_image = 'Y' LIMIT $start,100 ");
			foreach($hotelcodes as $list){
				DB::connection('mysql2')->table('grnhotels')->where('hotel_code', $list->hotel_code)->update(['main_image' => $list->image]);
				
				echo $list->hotel_code.'----------------'.$list->image.'===='.$page.'---'.$totalpages.'<br>';
			}
			 $page++;
			 
			 
			 if ($idd > 0 && $idd % 5 == 0) { // After every 5 Loop Item Executions
				set_time_limit (60);
			}
		}
		/*  */
		
	}

	
	
	public function HotelCities(Request $request){
		$output = '';
		$query = $request->get('textval');
		if($query != ''){
			//DB::enableQueryLog();
			$airportcodelis = DB::table('hotel_cities')->where('name', '=', $query);
			  $codelist = $airportcodelis->get();
			 $airportcodeliss = DB::table('hotel_cities')->where('name', 'LIKE', '%'.$query.'%');
       
          $codelist1 = $airportcodeliss->orderby('name', 'ASC')->get();
		 $airportcodeliss = array_merge($codelist->toArray(), $codelist1->toArray());
		$t = array();
		 foreach($airportcodeliss as $alist){
			 $HotelCountry = \App\HotelCountry::where('country_code_1', $alist->country_code)->first();
			 $t[$alist->city_code] = array(
				'country_code' => $alist->country_code,
				'name' => $alist->name,
				'city_code' => $alist->city_code,
				'country_name' => $HotelCountry->name,
				
			 );
		 }
			foreach($t as $key => $alist){
				
					$output .= '<li class="" roundwayfromtops="'.$alist['city_code'].', '.$alist['country_code'].'" roundwayfromtop="'.$alist['name'].', '.$alist['name'].'" roundwayfrom="'.$alist['name'].'">
					<div class="fli_name"><i class="fa fa-map-marker-alt"></i> '.$alist['name'].'</div>
					<div class="airport_name">City - '.$alist['name'].'</div></li>';
				
					
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
}
?>