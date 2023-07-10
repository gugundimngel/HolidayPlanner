<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use App\Country;
use App\City;
use App\Lead;
use App\Visa;
use App\VisaCategory;
use Config;

class VisaController extends Controller
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
  public function index(){
      $data = Visa::all();
      $visas = [];
      foreach($data as $visa){
          $d = [];
          $d['id'] = $visa->id;
          $d['visa_title'] = $visa->visa_title;
          $d['visa_type'] = $visa->visa_type;
          $country_from = Country::where('id',$visa->country_from)->first();
          $country_to = Country::where('id',$visa->country_to)->first();
          $d['country_from'] = $country_from->name;
          $d['country_to'] = $country_to->name;
          $d['Is_Popular'] = $visa->Is_Popular;
          $d['status'] = $visa->status;
          array_push($visas,$d);
      }
      return view("Admin.visa.index", compact("visas"));
      
  }
  public function visa_query(){
      $visa_query = DB::table('visa_query')->get();
      return view("Admin.visa.booking", compact("visa_query"));
      
  }
  public function add($id=null){
      $country = Country::get();
      $cities = City::get();
      $categories = VisaCategory::all();
      if(!empty($id)){
          $id = $this->decodeString($id);	
          $visa = DB::table('visas')->where('id', $id)->first();
         return view("Admin.visa.add", compact("country","cities","categories","visa")); 
      }else{
      return view("Admin.visa.add", compact("country","cities","categories"));
      }
      
  }
  
  public function save(Request $request){
        $this->validate($request, [
            'visa_type' => 'required',
            'country_from' => 'required',
            'country_to' => 'required',
            'traveler_city' => 'required',
            'visa_processing' => 'required',
            'visa_title' => 'required'
        ]);
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->visa_title)));
        $id = $request->id;
        if($request->hasfile('banner_img')){
                $banner_img = $this->uploadFile($request->file('banner_img'), Config::get('constants.visaBanner'));
            }else{
                $banner_img = null;
            }
        if($id == null){
            //save new
            
            $visa = new Visa;
            $visa->visa_type = $request->visa_type;
            $visa->country_from = $request->country_from;
            $visa->country_to = $request->country_to;
            $visa->traveler_city = $request->traveler_city;
            $visa->visa_processing = $request->visa_processing;
            $visa->visa_title = $request->visa_title;
            $visa->descritionTitle = $request->descritionTitle;
            $visa->descrptionDetails = $request->descrptionDetails;
            $visa->clientsDocTitle = $request->clientsDocTitle;
            $visa->clientDoc_details = $request->clientDoc_details;
            $visa->holida_assis_title = $request->holida_assis_title;
            $visa->holiday_planer_Assest_details = $request->holiday_planer_Assest_details;
            $visa->special_note_title = $request->special_note_title;
            $visa->special_note_details = $request->special_note_details;
            $visa->how_to_ApplyTitle = $request->how_to_ApplyTitle;
            $visa->how_to_apply_details = $request->how_to_apply_details;
            $visa->visa_info_title = $request->visa_info_title;
            $visa->visa_info_details = $request->visa_info_details;
            $visa->terms_condition_title = $request->terms_condition_title;
            $visa->term_condition_Details = $request->term_condition_Details;
            $visa->holiday_list_title = $request->holiday_list_title;
            $visa->holiday_list_details = $request->holiday_list_details;
            $visa->adult_b2c_price = $request->adult_b2c_price;
            $visa->adult_b2b_price = $request->adult_b2b_price;
            $visa->adult_corporate_price = $request->adult_corporate_price;
            $visa->child_b2c_price = $request->child_b2c_price;
            $visa->child_b2b_price = $request->child_b2b_price;
            $visa->child_corporate_price = $request->child_corporate_price;
            $visa->banner_img = $banner_img;
            $visa->slug = $slug;
            $visa->visa_category = $request->visa_category;
            $visa->save();
            
            if($visa){
                return redirect()->route('admin.visa.index')->with('success', 'Visa added successfully.');
            }else{
                return back()->with('error', 'Failed to add Visa.');
            }
        }else{
            $checkVisa = Visa::where('id',$id)->exists();
            if($checkVisa){
                $visa = Visa::where('id',$id)->update([
                        'visa_type' => $request->visa_type,
                        'country_from' => $request->country_from,
                        'country_to' => $request->country_to,
                        'traveler_city' => $request->traveler_city,
                        'visa_processing' => $request->visa_processing,
                        'visa_title' => $request->visa_title,
                        'descritionTitle' => $request->descritionTitle,
                        'descrptionDetails' => $request->descrptionDetails,
                        'clientsDocTitle' => $request->clientsDocTitle,
                        'clientDoc_details' => $request->clientDoc_details,
                        'holida_assis_title' => $request->holida_assis_title,
                        'holiday_planer_Assest_details' => $request->holiday_planer_Assest_details,
                        'special_note_title' => $request->special_note_title,
                        'special_note_details' => $request->special_note_details,
                        'how_to_ApplyTitle' => $request->how_to_ApplyTitle,
                        'how_to_apply_details' => $request->how_to_apply_details,
                        'visa_info_title' => $request->visa_info_title,
                        'visa_info_details' => $request->visa_info_details,
                        'terms_condition_title' => $request->terms_condition_title,
                        'term_condition_Details' => $request->term_condition_Details,
                        'holiday_list_title' => $request->holiday_list_title,
                        'holiday_list_details' => $request->holiday_list_details,
                        'adult_b2c_price' => $request->adult_b2c_price,
                        'adult_b2b_price' => $request->adult_b2b_price,
                        'adult_corporate_price' => $request->adult_corporate_price,
                        'child_b2c_price' => $request->child_b2c_price,
                        'child_b2b_price' => $request->child_b2b_price,
                        'child_corporate_price' => $request->child_corporate_price,
                        'banner_img' => $banner_img,
                        'slug' => $slug,
                        'visa_category' => $request->visa_category,
                    ]);
                    
                    return redirect()->route('admin.visa.index')->with('success', 'Visa updated successfully.');
            }else{
                return back()->with('error', 'Failed to update Visa.');
            }
        }
  }
  
  public function delete_visa(Request $request){
      $id = $request->id;
      $deleteVisa = Visa::where('id',$id)->delete();
      if($deleteVisa){
          return response(['status' => true]);
      }else{
          return response(['status' => false]);
      }
  }
  
  public function price(){
        return view('Admin.visa.price');
  }
	
	public function popular_status(Request $request){
	   
	    $id = $request->id;
	    $state = $request->state;
	    $type = $request->type;
	    $checkVisa = Visa::where('id',$id)->first();
	    if($checkVisa){
	        if($type == 'popular'){
	            $visa = Visa::where('id',$id)->update(['Is_Popular'=>$state]);
	        }else if($type == 'status'){
	            $visa = Visa::where('id',$id)->update(['status'=>$state]);
	        }
	        return response(['status' => true, 'visa' => $checkVisa->visa_title]);
	    }else{
	        return response(['status' => false]);
	    }
	}
	
	public function category(){
	    $categories = VisaCategory::all();
	    return view('Admin.visa.category',compact('categories'));
	}
	
	public function addCategory(Request $request){
	    $id = $request->category_id;
	    if($id == ''){
    	    $category = new VisaCategory;
    	    $category->name = $request->name;
    	    $category->save();
    	    return back()->with('success','Visa category Added.');
	    }else{
	        $categoryUpdate = VisaCategory::where('id',$id)->update(['name'=>$request->name]);
	        return back()->with('success','Visa category updated.');
	    }
	}
	
	public function deleteCategory(Request $request){
	    $category = VisaCategory::where('id',$request->id)->delete();
	    if($category){
	        return response(['status' => true]);
	    }else{
	        return response(['status' => false]);
	    }
	}
}