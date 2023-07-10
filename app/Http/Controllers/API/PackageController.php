<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
//use App\Http\Controllers\API\BaseController as BaseController;

use App\Destination;
use App\Package;
use App\Admin;
use App\Topinclusion;
use App\Lead;
use App\Holidaytype;
use App\HolidayTheme;
use App\PackageTheme;
use DB;


class PackageController extends BaseController
{
	public function __construct(Request $request)
    {	
		//$siteData = WebsiteSetting::where('id', '!=', '')->first();
		//\View::share('siteData', $siteData);
	}
	
	public function enquiryContact(Request $request)
    {
		$requestdata 	=  $request->all();
		$client_id = @$request['client_id'];
		$users = Admin::where('client_id', '=', $client_id)->first();
		if($users){
			$leads = new Lead;
		$leads->name = @$requestdata['name'];
		$leads->user_id = $users->id;
		$leads->package_id = @$requestdata['package_id'];
		$leads->email = @$requestdata['email'];
		$leads->phone = @$requestdata['phone'];
		$leads->city = @$requestdata['city'];
		$leads->travel_date = date('Y-m-d', strtotime(@$requestdata['traveldate']));
		$leads->adults = @$requestdata['adults'];
		$leads->children = @$requestdata['children'];
		$leads->customize_package = @$requestdata['add_info'];
		$leads->ip = $_SERVER['REMOTE_ADDR'];
		$saved = $leads->save();
		if(!$saved)
			{
				return $this->sendError('Error', array('client_id'=>array(Config::get('constants.server_error'))));
			}
			else
			{
				/* $dataTransaction = Lead::where('id', '=', $leads->id)->with(['package_detail'=>function($subQuery){
									$subQuery->select('id', 'package_name', 'tour_code');
										
								}])->first(); */
				/* $customerInfo = '';
				$customerInfo .= '<tr style="border:1px solid #011224;">';
								$customerInfo .= '<td style="border:1px solid #011224; text-align:center;">'.@$dataTransaction->name.'</td>';
								$customerInfo .= '<td style="border:1px solid #011224; text-align:center;">'.@$dataTransaction->email.'</td>';
								$customerInfo .= '<td style="border:1px solid #011224; text-align:center;">'.@$dataTransaction->phone.'</td>';
								$customerInfo .= '<td style="border:1px solid #011224; text-align:center;">'.@$dataTransaction->city.'</td>';
								$customerInfo .= '<td style="border:1px solid #011224; text-align:center;">'.@$dataTransaction->travel_date.'</td>';
								$customerInfo .= '<td style="border:1px solid #011224; text-align:center;">'.@$dataTransaction->adults.'</td>';
								$customerInfo .= '<td style="border:1px solid #011224; text-align:center;">'.@$dataTransaction->children.'</td>';
								
								$customerInfo .= '</tr>'; */
				//email goes to  admin start
					/* $replace = array('{logo}', '{package_name}', '{trip_code}', '{customerInfo}', '{discription}');					
					$replace_with = array('', @$dataTransaction->package_detail->package_name, @$dataTransaction->package_detail->tour_code, $customerInfo, ''); */
		
					//$this->send_email_template($replace, $replace_with, 'admin_enquiry', $users->email);
				//email goes to  admin end
				
				//email goes to  admin start
					/* $replace = array('{logo}', '{name}');					
					$replace_with = array('', @$dataTransaction->name); */
		
					//$this->send_email_template($replace, $replace_with, 'thanks_enquiry', $dataTransaction->email);
				//email goes to  admin end
				$success['data'] = $leads;
				return $this->sendResponse($success, '');
			}
			
		}else{
			return $this->sendError('Error', array('client_id'=>array('Client id not found'))); 
		}
		
    }
	
	public function PopularTour(Request $request){
		$client_id = $request->client_id;
		$users = Admin::where('client_id', '=', $client_id)->first();
		if($users){
			$Packages = Package::where('user_id', '=', $users->id)->where('is_popular', '=', 1)->with(['media','packloc'])->paginate(12);		
			$success['popular_pack'] =  @$Packages;
			$success['image_gallery_path'] 	=  \URL::to('/public/img/media_gallery').'/';
			return $this->sendResponse($success, '');
		}else{
			return $this->sendError('Error', array('client_id'=>array('Client id not found'))); 
		}
	}
	public function holidaytype(Request $request){
		$client_id = $request->client_id;
		$users = Admin::where('client_id', '=', $client_id)->first();
		if($users){
			$query = HolidayTheme::where('id', '!=', '');
			$userid = $users->id;
			$Packages = $query->with(['holidaytype' => function($query)  use ($userid){
				$query->select('id','theme_id','name','status','image')->where('user_id', '=', $userid);
			}])->orderby('name','ASC')->get();	
			$success['holidaytype_pack'] =  @$Packages;
			$success['image_gallery_path'] 	=  \URL::to('/public/img/themes_img').'/';
			return $this->sendResponse($success, '');
		}else{
			return $this->sendError('Error', array('client_id'=>array('Client id not found'))); 
		}
	}
	public function holidaytypePackage(Request $request,$typeid= null){
		$client_id = $request->client_id;
		$users = Admin::where('client_id', '=', $client_id)->first();
		if($users){
			$ql = array();
			$Packagestheme = PackageTheme::where('holiday_type', '=', $typeid)->get();
			foreach($Packagestheme as $l){
				$ql[] = $l->package_id;
			}
			DB::enableQueryLog(); 
			$query = Package::whereIn('id', $ql)->where('user_id', '=', $users->id)->with(['media','packloc']);
			$totalcount = $query->count();
			$Packages = $query->paginate(6);
			$success['package_theme'] =  @$Packages;
			$success['totalcount'] =  @$totalcount;
			$success['package_s'] =  DB::getQueryLog();
			$success['image_gallery_path'] 	=  \URL::to('/public/img/media_gallery').'/';
			return $this->sendResponse($success, '');
		}else{
			return $this->sendError('Error', array('client_id'=>array('Client id not found'))); 
		}
	}
	public function Packagedetail(Request $request){
		$client_id = $request->client_id;
		$users = Admin::where('client_id', '=', $client_id)->first();
	
			if($users){
			//	DB::enableQueryLog(); 
				$query = Package::where('user_id', '=', $users->id)->where('slug', '=', $request->slug)->where('status', '=', '1');
				
				 $lists 	= 	$query->with(['packigalleries' => function($query)
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
						
					}, 'bamedia'=>function($query){
						$query->select('id','images');
						
					}])->first();
				$Packages = Package::where('user_id', '=', $users->id)->where('destination', '=', $lists->destination)->with(['media'])->paginate(3);		
				$success['package_detail'] =  @$lists;
				$success['related_pack'] =  @$Packages;
				//$success['package_s'] =  DB::getQueryLog();
				$success['image_gallery_path'] 	=  \URL::to('/public/img/media_gallery').'/';
				$success['pdfs'] 	=  \URL::to('/public/img/pdfs').'/';
				$success['image_topinclusion_path'] 	=  \URL::to('/public/img/topinclusion_img').'/';
				$success['image_hotel_path'] 	=  \URL::to('/public/img/hotel_img').'/';
				return $this->sendResponse($success, '');
			}else{
				return $this->sendError('Error', array('client_id'=>array('Client id not found'))); 
			}
		
	}	
}
?>	