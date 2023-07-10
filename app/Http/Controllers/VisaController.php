<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

//use App\Destination;
use App\Country;
use Config;
use Cookie;


class VisaController extends Controller
{
	public function __construct(Request $request)
    {	
		/* $siteData = WebsiteSetting::where('id', '!=', '')->first();
		\View::share('siteData', $siteData); */
	}
	
	public function index(){
		$country = Country::get();
		return view('visa.index', compact('country'));
	}
	
	public function details($id){
		 $visa = DB::table('visas')->where('slug', $id)->first();
		return view('visa.details', compact('visa'));
	}
	public function search(Request $request){
	    $country = Country::get();
		 $visa = DB::table('visas')->where('country_id', $request->visa_for)->get();
		return view('visa.list', compact('country','visa'));
	}
	 public function save(Request $request){
      DB::table('visa_query')->insert([
				 "name" => $request->name,
				 "email" => $request->email,
				 "phone" => $request->phone,
				 "country_name" => $request->visa_for,
                  "remark" => $request->add_info,
                  "date_travel" => $request->traveldate,
			]);
return true;
    }
}
?>