<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\Grnhotel;
use App\GrnFac;
use App\HotelCity;
 
use Auth;
use Config;
use Session;
 
class GRNHotelController extends Controller
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
		$query = Grnhotel::orderby('name', 'ASC');
		if ($request->has('hotel_code')) 
		{
			$hotel_code 		= 	$request->input('hotel_code'); 
			if(trim($hotel_code) != '')
			{
			
				$query->where('hotel_code', '=', @$hotel_code);
			}
		}
		if ($request->has('hotel_name')) 
		{
			$hotel_name 		= 	$request->input('hotel_name'); 
			if(trim($hotel_name) != '')
			{
			
				$query->where('name', '=', @$hotel_name);
			}
		}
		
		 if ($request->has('city'))  
		{
			$search_term_first_name 		= 	$request->input('city');	
			if(trim($search_term_first_name) != '')
			{
				$query->where('city_code', '=', $search_term_first_name);
			}		
		} 
		$hotelcodes = $query->paginate(20);
		return view('Admin.grnhotel.index', compact('hotelcodes'));  
	}
	
	public function edit(Request $request, $id = NULL)
	{			
		//check authorization end
	
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$this->validate($request, [
										'name' => 'required|max:255',
										'longitude' => 'required',
										'latitude' => 'required',
										'category' => 'required',
									  ]);
									  
			$obj				= 	Grnhotel::find($requestData['id']);
			
			$obj->name			=	@$requestData['name'];
			$obj->longitude		=	@$requestData['longitude'];
			$obj->latitude	=	@$requestData['latitude'];
			$obj->address	=	@$requestData['address'];
			$obj->zip	=	@$requestData['zip'];
			$obj->category	=	@$requestData['category'];
			$obj->description			=	@$requestData['description'];	
			
			
		
			//$obj->gallery			=	@$gallery_image;
						
			$saved				=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				
				/* Gallery Image Upload Function Start */						  
			 if($request->hasfile('upimages')) 
				{	
					$images = $request->file('upimages');
					foreach ($images as $item){
						$gallery_image = $this->uploadFile($item, Config::get('constants.gallery_img'));
						$objimage = new \App\HotelImage;
						$objimage->image = $gallery_image;
						$objimage->hotel_code = @$request->hotel_code;
						$objimage->main_image = 'N';
						$objimage->status = 1;
						$objimage->type = 'system';
						$objimage->save();
					}
					
				} 
					
			/* Gallery Image Upload Function End */ 
				return Redirect::to('/admin/grnhotel')->with('success', 'GRN Hotel Edited Successfully');
			}				
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(Grnhotel::where('id', '=', $id)->exists()) 
				{
					$fetchedData = Grnhotel::where('id', '=', $id)->with(['hotelmainimages','hotelfac'])->first();
					return view('Admin.grnhotel.edit', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/grnhotel')->with('error', 'GRN Hotel Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/grnhotel')->with('error', Config::get('constants.unauthorized'));
			}		 
		}				
	}
	
	public function gethotel(Request $request){
		$fetchedData = Grnhotel::where('name','LIKE', '%'.$request->likevalue.'%')->get();
		$agents = array();
		foreach($fetchedData as $list){
			$agents[] = array(
				'id' => $list->id,

				'agent_hotel_name' => $list->name,
			);
		}
		
		echo json_encode($agents);
	}
	
	public function getcity(Request $request){
		$fetchedData = HotelCity::where('name','LIKE', '%'.$request->likevalue.'%')->get();
		$agents = array();
		foreach($fetchedData as $list){
			$agents[] = array(
				'id' => $list->city_code,
				'agent_city' => $list->name,
			);
		}
		
		echo json_encode($agents);
	}
	public function searchlist(Request $request){
		if($request->h == 'city_wise'){
			
			$QUERY = \App\HotelCity::where('name', 'LIKE', '%'.$request->term.'%');
			/* if($request->h == 'domestic'){
				$QUERY->where('country_code', '=', 'IN');
			}else{
				$QUERY->where('country_code', '!=', 'IN');
			} */
			$cities = $QUERY->orderby('name', 'ASC')->get();
			$citydata = array();
			foreach($cities as $city){
				$citydata[] = array('label'=>$city->name, 'v_id' =>$city->city_code);
				
			}			
			echo json_encode($citydata);
			die;  
		}else{
			$QUERY = \App\HotelData::where('hotel_name', 'LIKE', '%'.$request->term.'%');
			/* if($request->h == 'domestic'){
				$QUERY->where('country_code', '=', 'IN');
			}else{
				$QUERY->where('country_code', '!=', 'IN');
			} */
			$hotels = $QUERY->orderby('hotel_name', 'ASC')->get();
			$hoteldata = array();
			foreach($hotels as $hotel){
				$hoteldata[] = array('label'=>$hotel->hotel_name, 'v_id' =>$hotel->hotel_code);
			}			
			echo json_encode($hoteldata);
			die;
		}
	}
	
	public function grnhotelfacilties(Request $request)
	{		 
		$hotelcodes = GrnFac::orderby('name', 'ASC')->paginate(20);
		
		return view('Admin.grnhotel.facilities.index', compact('hotelcodes'));  
	}
	
	public function editgrnhotelfacilties(Request $request, $id = Null)
	{	
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			$this->validate($request, [
				'name' => 'required|max:255'
			  ]);
			if($requestData['imagetype'] == 'image'){
			/* Hotel Image Upload Function Start */						  
			if($request->hasfile('image')) 
			{	
				/* Unlink File Function Start */ 
					if($requestData['image'] != '')
						{
							$this->unlinkFile($requestData['old_image'], Config::get('constants.hotel_img'));
						}
				/* Unlink File Function End */
				
				$hotel_img = $this->uploadFile($request->file('image'), Config::get('constants.hotel_img'));
			}
			else
			{
				$hotel_img = @$requestData['old_image'];
			}		
		/* Hotel Image Upload Function End */
			}else{
				$hotel_img = @$requestData['icon'];
			}
			
			$obj				= 	GrnFac::find($requestData['id']);
			$obj->name			=	@$requestData['name'];
			$obj->icon			=	@$hotel_img;
			$obj->type			=	@$requestData['imagetype'];
			$saved 				= $obj->save();
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/grnhotelfacilties')->with('success', 'Record Updated Successfully');
			}	
		}else{
			if(isset($id) && !empty($id))
				{
					$id = $this->decodeString($id);	
					if(GrnFac::where('id', '=', $id)->exists()) 
					{
						$fetchedData = GrnFac::where('id', '=', $id)->first();
						return view('Admin.grnhotel.facilities.edit', compact(['fetchedData']));
					}
					else
					{
						return Redirect::to('/admin/grnhotelfacilties')->with('error', 'Record Not Exist');
					}	
				}
				else
				{
					return Redirect::to('/admin/grnhotelfacilties')->with('error', Config::get('constants.unauthorized'));
				}	
		}
	}
	
	public function rooms(Request $request){
		
		$hotelreq['hotel_codes'] = array($request->hcode);
		$cin = date('Y-m-d', strtotime('+1 month'));
		$cout = date('Y-m-d', strtotime('+1 day'.$cin));
		$hotelreq['checkin'] = date('Y-m-d',strtotime($cin));
		$hotelreq['checkout'] = date('Y-m-d',strtotime($cout));
		$hotelreq['client_nationality'] = 'IN';
		$hotelreq['cutoff_time'] = '50000';
		$hotelreq['currency'] = 'INR';
		$hotelreq['rates'] = 'concise';
		
		
		$rooms[0]['adults'] = 2;
		$hotelreq['rooms'] = $rooms;
		
		$hotelreq['version'] = "2.0";
		    $hotelpost =  json_encode($hotelreq); 
		 // echo '<pre>'; print_r($hotelreq); die;
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

		$hotellistsda = curl_exec($curl);
		$hotellists  = json_decode($hotellistsda);
		
		$search_id = $hotellists->search_id;
		
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $hotel_endpoint.'api/v3/hotels/availability/'.$search_id.'?hcode='.$request->hcode,
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
			'Accept-Encoding: application/gzip',
			'Content-Type: application/json'
		  ),
		));
		$hcode = $request->hcode;
		$hotelrooms = curl_exec($curl);
		$hotellists  = json_decode($hotelrooms);
		return view('Admin.grnhotel.rooms.index', compact('hotellists','hcode'));
		
		
	}
	
	
	public function roomsedit(Request $request){
		if ($request->isMethod('post')) 
		{
			$hcode = $request->hotel_code;
			$ref = $request->ref;
			
			$obj = new \App\Room;
			$obj->hotel_id			=	@$hcode;
			$obj->room_reference	=	@$ref;
			
			$obj->room_size			=	@$request->room_size;
			$obj->description		=	@$request->description;
			$saved = $obj->save();
			
			/* Gallery Image Upload Function Start */						  
			 if($request->hasfile('upimages')) 
				{	
					$images = $request->file('upimages');
					foreach ($images as $item){
						$gallery_image = $this->uploadFile($item, Config::get('constants.gallery_img'));
						$objimage = new \App\RoomImage;
						$objimage->hcode				=	@$hcode;
						$objimage->refid				=	@$ref;
						$objimage->image				=	@$gallery_image;
						$objimage->status				=	1;
						$objimage->save();
					}
					
				} 
					
			/* Gallery Image Upload Function End */ 
				return Redirect::to('/admin/rooms/edit?ref='.$ref.'&hcode='.$hcode)->with('success', 'Record Updated Successfully');
			
		}else{
			$hcode = $request->hcode;
			$ref = $request->ref;
			$roomsdata = json_decode(Session::get('roomsdata_'.$request->ref));
			
			return view('Admin.grnhotel.rooms.edit', compact('roomsdata','hcode','ref'));
		}
	}
}
