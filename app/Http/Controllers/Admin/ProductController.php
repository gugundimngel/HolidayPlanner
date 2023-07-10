<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

use App\Professor;
use App\ModeProduct;
use App\Product;
use App\ProductOtherInformation;
use App\ProductDemoVideo;
use App\ProductReview;

use Auth;
use Config;

class ProductController extends Controller
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
     * All Products.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('Product', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		$query 		= Product::where('id', '!=', '')->with(['professor']);
		
		$totalData 	= $query->count();	//for all data
		
		//searching start	
			if ($request->has('search_term')) 
			{
				$search_term 		= 	$request->input('search_term');
				if(trim($search_term) != '')	
				{
					$query->where('subject_name', 'LIKE', '%' . $search_term . '%');
				}
			}
			if ($request->has('search_term_professor')) 
			{
				$search_term_professor 		= 	$request->input('search_term_professor');
				if(trim($search_term_professor) != '')
				{
					$query->whereHas('professor', function ($q) use($search_term_professor){
						$q->where('first_name', 'LIKE', '%'.$search_term_professor.'%')->where('last_name', 'LIKE', '%'.$search_term_professor.'%');
					});
				}
			}
			if ($request->has('search_term_batch_type')) 
			{
				$search_term_batch_type 		= 	$request->input('search_term_batch_type');
				if(trim($search_term_batch_type) != '')	
				{
					$query->where('batch_type', 'LIKE', '%' . $search_term_batch_type . '%');
				}
			}
			if ($request->has('search_term_from')) 
			{
				$search_term_from 		= 	$request->input('search_term_from');
				if(trim($search_term_from) != '')
				{
					$query->whereDate('created_at', '>=', $search_term_from);
				}
			}
			if ($request->has('search_term_to')) 
			{	
				$search_term_to 		= 	$request->input('search_term_to');
				if(trim($search_term_to) != '')
				{
					$query->whereDate('created_at', '<=', $search_term_to);
				}	
			}
			
			if ($request->has('search_term') || $request->has('search_term_professor') || $request->has('search_term_batch_type') || $request->has('search_term_from') || $request->has('search_term_to')) 
			{
				$totalData 	= $query->count();//after search
			}
		//searching end	

		$lists		= $query->sortable(['id'=>'desc'])->paginate(config('constants.limit'));	

		return view('Admin.product.index',compact(['lists', 'totalData']));	
	}
	/**
     * Add Product.
     *
     * @return \Illuminate\Http\Response
     */
	public function addProduct(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('Product', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		/* Get all Select Data */	
			$professors = Professor::select('id', 'first_name', 'last_name')->where('status', '=', 1)->get();
			$mode_of_products = ModeProduct::select('id', 'mode_product')->where('status', '=', 1)->get();		
		/* Get all Select Data */
		
		if ($request->isMethod('post')) 
		{
			$requestData 					= 	$request->all();
			
			$this->validate($request, [
										'professor_id' => 'required',
										'subject_name' => 'required',
										'course_level' => 'nullable|max:255',
										'attempt_info' => 'nullable|max:255',
										'package' => 'nullable|max:255',
										'video_language' => 'nullable|max:255',
										'study_material_language' => 'nullable|max:255',
										'dispatched_by' => 'nullable|max:255',
										'delivery_period' => 'nullable|max:255',
										'system_requirement' => 'nullable|max:255',
										'runs_on' => 'nullable|max:255',
										'batch_type' => 'nullable|max:255',
										'no_lecture' => 'nullable|max:20',
										'syllabus_coverage' => 'nullable|max:255',
										'amendment' => 'nullable|max:255',
										'faculty_support' => 'nullable|max:255',
										'lecture_recorded' => 'nullable|max:255',
										'fast_forward' => 'nullable|max:255',
										'books_provided' => 'nullable|max:255',
										'validity_start_from' => 'nullable|max:255',
										'validity_extension' => 'nullable|max:255',
										'views_extension' => 'nullable|max:255',
										'internet_connectivity' => 'nullable|max:255',
										'dispatch_time' => 'nullable|max:255'
									  ]);	
									  
			/* Product Image Upload Function Start */						  
				if($request->file('image')) 
				{
					$image = $this->uploadFile($request->file('image'), Config::get('constants.product_img'));
				}	
			/* Product Image Upload Function Start */							  

			$obj							= 	new Product;
			
			$obj->professor_id				=	@$requestData['professor_id'];
			$obj->subject_name				=	@$requestData['subject_name'];
			$obj->course_level				=	@$requestData['course_level'];
			$obj->attempt_info				=	@$requestData['attempt_info'];
			$obj->package					=	@$requestData['package'];
			$obj->video_language			=	@$requestData['video_language'];
			$obj->study_material_language	=	@$requestData['study_material_language'];
			$obj->dispatched_by				=	@$requestData['dispatched_by'];
			$obj->delivery_period			=	@$requestData['delivery_period'];
			$obj->system_requirement		=	@$requestData['system_requirement'];
			$obj->runs_on					=	@$requestData['runs_on'];
			$obj->batch_type				=	@$requestData['batch_type'];
			$obj->feature_product			=	@$requestData['feature_product'];
			$obj->features					=	@$requestData['features'];
			$obj->no_lecture				=	@$requestData['no_lecture'];
			$obj->syllabus_coverage			=	@$requestData['syllabus_coverage'];
			$obj->amendment					=	@$requestData['amendment'];
			$obj->faculty_support			=	@$requestData['faculty_support'];
			$obj->lecture_recorded			=	@$requestData['lecture_recorded'];
			$obj->fast_forward				=	@$requestData['fast_forward'];
			$obj->books_provided			=	@$requestData['books_provided'];
			$obj->index_order				=	@$requestData['index_order'];
			$obj->other_info				=	@$requestData['other_info'];
			$obj->validity_start_from		=	@$requestData['validity_start_from'];
			$obj->validity_extension		=	@$requestData['validity_extension'];
			$obj->views_extension			=	@$requestData['views_extension'];
			$obj->internet_connectivity		=	@$requestData['internet_connectivity'];
			$obj->dispatch_time				=	@$requestData['dispatch_time'];
			$obj->stock_out					=	@$requestData['stock_out'];
			
			//Order number start	
				if(empty(@$requestData['order_number']))
				{
					$forOrder = Product::select('id', 'order_number')->where('id', '!=', '')->orderBy('order_number', 'DESC')->first();
					
					$order = @$forOrder->order_number + 1;
				}	
				else
				{
					if(Product::where('order_number', '=', @$requestData['order_number'])->exists())
					{ //if exists order number already
						$matchProduct = Product::select('id')->where('order_number', '=', @$requestData['order_number'])->first();
						
						$forOrder = Product::select('id', 'order_number')->where('id', '!=', '')->orderBy('order_number', 'DESC')->first();
						$lastOrder = @$forOrder->order_number + 1;
						
						$objUpdate					= 	Product::find(@$matchProduct->id);
						$objUpdate->order_number	=	@$lastOrder;
						$saved						=	$objUpdate->save();	
					}
					$order = @$requestData['order_number'];	
				}
			//Order number end

			$obj->order_number				=	@$order;
			$obj->sampleImage				=	@$requestData['sampleImage'];
			$obj->image						=	@$image;
			
			$saved							=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				//products other information start	
					$product_id = $obj->id; //last inserted product id
					
					$count = @$requestData['count'];
					
					for($i = 1; $i <= $count; $i++)
					{
						$objOther 					=	new ProductOtherInformation;
						
						$objOther->product_id		= 	@$product_id;

						if (array_key_exists('mode_product'.$i, @$requestData))
						{
							$objOther->mode_of_product	= 	@$requestData["mode_product".$i];
						}			
						if (array_key_exists("duration".$i, @$requestData))
						{
							$objOther->duration	= 	@$requestData["duration".$i];
						}
						if (array_key_exists("validity".$i, @$requestData))
						{
							$objOther->validity	= 	@$requestData["validity".$i];
						}
						if (array_key_exists("price".$i, @$requestData))
						{
							$objOther->price	= 	@$requestData["price".$i];
						}
						if (array_key_exists("discount".$i, @$requestData))
						{
							if(trim(@$requestData["discount".$i]) == '')
								{	
									$objOther->discount	= 0;
								}
							else
								{
									$objOther->discount = @$requestData["discount".$i];
								}	
						}
						if (array_key_exists("views".$i, @$requestData))
						{
							$objOther->views	= 	@$requestData["views".$i];
						}
						
						$total_amount = $objOther->price - ($objOther->price * $objOther->discount) / 100;  
						
						$objOther->total_amount = @$total_amount;
						
						if (array_key_exists('mode_product'.$i, @$requestData))	
						{	
							$saved		=	$objOther->save();	
						}
					}			
				//products other information end

				//products demo video start	
					$countDemo = @$requestData['countDemo'];
					
					for($i = 1; $i <= $countDemo; $i++)
					{
						$objDemo					=	new ProductDemoVideo;
						
						$objDemo->product_id		= 	@$product_id;
	
						if(trim(@$requestData["demo_videos".$i]) != '')
						{	
							if (array_key_exists('demo_videos'.$i, @$requestData))
							{
								$objDemo->demo_videos	= 	@$requestData["demo_videos".$i];
								$saved		=	$objDemo->save();
							}
						}	
					}
				//products demo video end
			
				return Redirect::to('/admin/products')->with('success', 'Product'.Config::get('constants.added'));
			}
		}
		return view('Admin.product.add_product',  compact(['professors', 'mode_of_products']));		
	}
	
	public function editProduct(Request $request, $id = NULL)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('Product', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		/* Get all Select Data */	
			$professors = Professor::select('id', 'first_name', 'last_name')->where('status', '=', 1)->get();
			$mode_of_products = ModeProduct::select('id', 'mode_product')->where('status', '=', 1)->get();		
		/* Get all Select Data */
	
		if ($request->isMethod('post')) 
		{	
			$requestData 					= 	$request->all();
		
			$this->validate($request, [
										'professor_id' => 'required',
										'subject_name' => 'required',
										'course_level' => 'nullable|max:255',
										'attempt_info' => 'nullable|max:255',
										'package' => 'nullable|max:255',
										'video_language' => 'nullable|max:255',
										'study_material_language' => 'nullable|max:255',
										'dispatched_by' => 'nullable|max:255',
										'delivery_period' => 'nullable|max:255',
										'system_requirement' => 'nullable|max:255',
										'runs_on' => 'nullable|max:255',
										'batch_type' => 'nullable|max:255',
										'no_lecture' => 'nullable|max:20',
										'syllabus_coverage' => 'nullable|max:255',
										'amendment' => 'nullable|max:255',
										'faculty_support' => 'nullable|max:255',
										'lecture_recorded' => 'nullable|max:255',
										'fast_forward' => 'nullable|max:255',
										'books_provided' => 'nullable|max:255',
										'validity_start_from' => 'nullable|max:255',
										'validity_extension' => 'nullable|max:255',
										'views_extension' => 'nullable|max:255',
										'internet_connectivity' => 'nullable|max:255',
										'dispatch_time' => 'nullable|max:255'
									  ]);

			/* File Upload Function Start */						  
				if($request->file('image')) 
				{
					/* Unlink File Function Start */ 
						if(@$requestData['image'] != '')
							{
								$this->unlinkFile(@$requestData['old_product_img'], Config::get('constants.product_img'));
							}
					/* Unlink File Function End */
					
					$image = $this->uploadFile($request->file('image'), Config::get('constants.product_img'));
				}
			else
				{
					$image = @$requestData['old_product_img'];
				}		
			/* File Upload Function End */
				  					  
			$obj							= 	Product::find(@$requestData['id']);

			$obj->professor_id				=	@$requestData['professor_id'];
			$obj->subject_name				=	@$requestData['subject_name'];
			$obj->course_level				=	@$requestData['course_level'];
			$obj->attempt_info				=	@$requestData['attempt_info'];
			$obj->package					=	@$requestData['package'];
			$obj->video_language			=	@$requestData['video_language'];
			$obj->study_material_language	=	@$requestData['study_material_language'];
			$obj->dispatched_by				=	@$requestData['dispatched_by'];
			$obj->delivery_period			=	@$requestData['delivery_period'];
			$obj->system_requirement		=	@$requestData['system_requirement'];
			$obj->runs_on					=	@$requestData['runs_on'];
			$obj->batch_type				=	@$requestData['batch_type'];
			$obj->feature_product			=	@$requestData['feature_product'];
			$obj->features					=	@$requestData['features'];
			$obj->no_lecture				=	@$requestData['no_lecture'];
			$obj->syllabus_coverage			=	@$requestData['syllabus_coverage'];
			$obj->amendment					=	@$requestData['amendment'];
			$obj->faculty_support			=	@$requestData['faculty_support'];
			$obj->lecture_recorded			=	@$requestData['lecture_recorded'];
			$obj->fast_forward				=	@$requestData['fast_forward'];
			$obj->books_provided			=	@$requestData['books_provided'];
			$obj->index_order				=	@$requestData['index_order'];
			$obj->other_info				=	@$requestData['other_info'];
			$obj->validity_start_from		=	@$requestData['validity_start_from'];
			$obj->validity_extension		=	@$requestData['validity_extension'];
			$obj->views_extension			=	@$requestData['views_extension'];
			$obj->internet_connectivity		=	@$requestData['internet_connectivity'];
			$obj->dispatch_time				=	@$requestData['dispatch_time'];
			$obj->stock_out					=	@$requestData['stock_out'];
			
			//Order number start	
				if(empty(@$requestData['order_number']))
				{
					$forOrder = Product::select('id', 'order_number')->where('id', '!=', '')->orderBy('order_number', 'DESC')->first();
					
					$order = @$forOrder->order_number + 1;
				}	
				else
				{
					if(Product::where('id', '!=', @$requestData['id'])->where('order_number', '=', @$requestData['order_number'])->exists())
					{ //if exists order number already
						$matchProduct = Product::select('id')->where('order_number', '=', @$requestData['order_number'])->first();
						
						$forOrder = Product::select('id', 'order_number')->where('id', '!=', '')->orderBy('order_number', 'DESC')->first();
						$lastOrder = @$forOrder->order_number + 1;
						
						$objUpdate					= 	Product::find(@$matchProduct->id);
						$objUpdate->order_number	=	@$lastOrder;
						$saved						=	$objUpdate->save();	
					}
					$order = @$requestData['order_number'];	
				}
			//Order number end
			
			
			$obj->order_number				=	@$order;
			$obj->sampleImage				=	@$requestData['sampleImage'];
			$obj->image						=	@$image;
			
			$saved							=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{	
				//Remove old product demo info start	
					DB::table('product_demo_videos')->where('product_id', @$requestData['id'])->delete();
				//Remove old product demo info end
				
				//products start	
					$count = @$requestData['count'];
					
					for($i = 1; $i <= $count; $i++)
					{
						if (array_key_exists('id_other'.$i, @$requestData))
						{
							$objOther	= 	ProductOtherInformation::find(@$requestData["id_other".$i]);
						}
						else
						{
							$objOther	= new ProductOtherInformation;
						}		
					
						$objOther->product_id		= 	@$requestData['id'];

						if (array_key_exists('mode_product'.$i, @$requestData))
						{
							$objOther->mode_of_product	= 	@$requestData["mode_product".$i];
						}			
						if (array_key_exists("duration".$i, @$requestData))
						{
							$objOther->duration	= 	@$requestData["duration".$i];
						}
						if (array_key_exists("validity".$i, @$requestData))
						{
							$objOther->validity	= 	@$requestData["validity".$i];
						}
						if (array_key_exists("price".$i, @$requestData))
						{
							$objOther->price	= 	@$requestData["price".$i];
						}
						if (array_key_exists("discount".$i, @$requestData))
						{
							if(trim(@$requestData["discount".$i]) == '')
								{	
									$objOther->discount	= 0;
								}
							else
								{
									$objOther->discount = @$requestData["discount".$i];
								}
						}
						if (array_key_exists("views".$i, @$requestData))
						{
							$objOther->views	= 	@$requestData["views".$i];
						}	
						
						$total_amount = $objOther->price - ($objOther->price * $objOther->discount) / 100;  
						
						$objOther->total_amount = $total_amount;
						
						if (array_key_exists('mode_product'.$i, @$requestData))	
						{	
							$saved		=	$objOther->save();	
						}
					}			
				//products end
				
				//products demo video start	
					$countDemo = @$requestData['countDemo'];
					
					for($i = 1; $i <= $countDemo; $i++)
					{
						$objDemo					=	new ProductDemoVideo;
						
						$objDemo->product_id		= 	@$requestData['id'];

						if(trim(@$requestData["demo_videos".$i]) != '')
						{	
							if (array_key_exists('demo_videos'.$i, @$requestData))
							{
								$objDemo->demo_videos	= 	@$requestData["demo_videos".$i];
								$saved		=	$objDemo->save();
							}
						}	
					}
				//products demo video end

				return Redirect::to('/admin/products')->with('success', 'Product'.Config::get('constants.edited'));
			}		
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
	
				if(Product::where('id', '=', $id)->exists())
				{
					$fetchedData = Product::find($id);
					
					$productOtherInfo = ProductOtherInformation::where('product_id', '=', $id)->with(['mode_product'=>function($query){
							$query->select('id', 'mode_product');
						}])->get();
						
					$productDemoInfo = ProductDemoVideo::where('product_id', '=', $id)->get();		
						
					return view('Admin.product.edit_product', compact(['fetchedData', 'productOtherInfo', 'productDemoInfo', 'professors', 'mode_of_products']));
				}
				else
				{
					return Redirect::to('/admin/products')->with('error', 'Product'.Config::get('constants.not_exist'));
				}	
			}
			else
			{
				return Redirect::to('/admin/products')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	
	public function viewProduct(Request $request, $id)
	{
		if(isset($id) && !empty($id))
		{
			$id = $this->decodeString($id);
			if(Product::where('id', '=', $id)->exists()) 
			{
				$fetchedData 		= 	Product::where('id', '=', $id)->with(['professor'=>function($query){
					$query->select('id', 'first_name', 'last_name');
				}])->first();

				$productOtherInfo = ProductOtherInformation::where('product_id', '=', $id)->with(['mode_product'=>function($query){
							$query->select('id', 'mode_product');
						}])->get();
						
				$productDemoInfo = ProductDemoVideo::where('product_id', '=', $id)->get();		
					
				return view('Admin.product.view_product', compact(['fetchedData', 'productOtherInfo', 'productDemoInfo']));
			}
			else
			{
				return Redirect::to('/admin/products')->with('error', 'Product'.Config::get('constants.not_exist'));
			}
		}
		else
		{
			return Redirect::to('/admin/products')->with('error', Config::get('constants.unauthorized'));
		}
	}
	
	public function addProductSampleImage(Request $request)
	{
		$status 			= 	0;
		$method 			= 	$request->method();	
		if ($request->isMethod('post')) 
		{
			$requestData 					= 	$request->all();

			if($request->file('file')) 
				{
					$image = $this->uploadFile($request->file('file'), Config::get('constants.product_sample_img'));
				}
			$status = 1;
			$message = $image;
		}
		else
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message));
		die;
	}

	public function deleteProductSampleImage(Request $request)
	{
		$status 			= 	0;
		$method 			= 	$request->method();	
		if ($request->isMethod('post')) 
		{
			$requestData 					= 	$request->all();
			
			if(!empty($requestData['image']))
			{
				/* Unlink File Function Start */ 
					if($requestData['image'] != '')
						{
							$this->unlinkFile($requestData['image'], Config::get('constants.product_sample_img'));
						}
				/* Unlink File Function End */
				$status = 1;
				$message = 'Sample Product Image has been deleted successfully.';
			}
		}
		else
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message));
		die;
	}
	
	public function linkedProducts(Request $request)
	{
		$professor_ids = array();
		$professors = Professor::select('id', 'which_organisation')->where('which_organisation', '=', Auth::user()->id)->get();
		
		if(!empty($professors))
			{	
				foreach($professors as $professor)
					{
						array_push($professor_ids, $professor->id);
					}
			}
		
		if(!empty($professor_ids))
		{
			$query 		= Product::whereIn('professor_id', $professor_ids)->with(['professor']);
			
			$totalData 	= $query->count();	//for all data
			
			//searching start	
				if ($request->has('search_term')) 
				{
					$search_term 		= 	$request->input('search_term');
					if(trim($search_term) != '')	
					{
						$query->where('subject_name', 'LIKE', '%' . $search_term . '%');
					}
				}
				if ($request->has('search_term_professor')) 
				{
					$search_term_professor 		= 	$request->input('search_term_professor');
					if(trim($search_term_professor) != '')
					{
						$query->whereHas('professor', function ($q) use($search_term_professor){
							$q->where('first_name', 'LIKE', '%'.$search_term_professor.'%')->where('last_name', 'LIKE', '%'.$search_term_professor.'%');
						});
					}
				}
				if ($request->has('search_term_batch_type')) 
				{
					$search_term_batch_type 		= 	$request->input('search_term_batch_type');
					if(trim($search_term_batch_type) != '')	
					{
						$query->where('batch_type', 'LIKE', '%' . $search_term_batch_type . '%');
					}
				}
				if ($request->has('search_term_from')) 
				{
					$search_term_from 		= 	$request->input('search_term_from');
					if(trim($search_term_from) != '')
					{
						$query->whereDate('created_at', '>=', $search_term_from);
					}
				}
				if ($request->has('search_term_to')) 
				{	
					$search_term_to 		= 	$request->input('search_term_to');
					if(trim($search_term_to) != '')
					{
						$query->whereDate('created_at', '<=', $search_term_to);
					}	
				}
				
				if ($request->has('search_term') || $request->has('search_term_professor') || $request->has('search_term_batch_type') || $request->has('search_term_from') || $request->has('search_term_to')) 
				{
					$totalData 	= $query->count();//after search
				}
			//searching end	

			$lists		= $query->sortable(['id'=>'desc'])->paginate(config('constants.limit'));
		}

		return view('Admin.product.linked_products',compact(['lists', 'totalData']));	
	}
	
	/**
     * All Reviews.
     *
     * @return \Illuminate\Http\Response
     */
	public function viewProductReviews(Request $request, $id)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('Product', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		if(isset($id) && !empty($id))
		{
			$id = $this->decodeString($id);
			
			if(Product::where('id', '=', $id)->exists()) 
			{		
				$query 		= ProductReview::where('product_id', '=', $id)->with(['studentData'=>function($q){
					$q->select('id', 'first_name', 'last_name', 'email');
				}, 'productData'=>function($q){
					$q->select('id', 'subject_name');
				}]);
				
				$totalData 	= $query->count();	//for all data
				
				//searching start	
					if ($request->has('search_term')) 
					{
						$search_term 		= 	$request->input('search_term');
						if(trim($search_term) != '')
						{
							$query->whereHas('studentData', function ($q) use($search_term){
								$q->where('first_name', 'LIKE', '%'.$search_term.'%');
							});
						}
					}
					if ($request->has('search_term_last')) 
					{
						$search_term_last 		= 	$request->input('search_term_last');
						if(trim($search_term_last) != '')
						{
							$query->whereHas('studentData', function ($q) use($search_term_last){
								$q->where('last_name', 'LIKE', '%'.$search_term_last.'%');
							});
						}
					}
					if ($request->has('search_term_email')) 
					{
						$search_term_email 		= 	$request->input('search_term_email');
						if(trim($search_term_email) != '')
						{
							$query->whereHas('studentData', function ($q) use($search_term_email){
								$q->where('email', 'LIKE', '%'.$search_term_email.'%');
							});
						}
					}
					if ($request->has('search_term_from')) 
					{
						$search_term_from 		= 	$request->input('search_term_from');
						if(trim($search_term_from) != '')
						{
							$query->whereDate('created_at', '>=', $search_term_from);
						}
					}
					if ($request->has('search_term_to')) 
					{	
						$search_term_to 		= 	$request->input('search_term_to');
						if(trim($search_term_to) != '')
						{
							$query->whereDate('created_at', '<=', $search_term_to);
						}	
					}
					
					if ($request->has('search_term') || $request->has('search_term_last') || $request->has('search_term_email') || $request->has('search_term_from') || $request->has('search_term_to')) 
					{
						$totalData 	= $query->count();//after search
					}
				//searching end	

				$lists		= $query->sortable(['id'=>'desc'])->paginate(config('constants.limit'));	

				return view('Admin.product.view_product_reviews',compact(['lists', 'totalData', 'id']));	
			}
			else
			{
				return Redirect::to('/admin/products')->with('error', 'Product'.Config::get('constants.not_exist'));
			}		
		}
		else
		{
			return Redirect::to('/admin/products')->with('error', Config::get('constants.unauthorized'));
		}		
	}

	public function viewProductReview(Request $request, $id)
	{
		if(isset($id) && !empty($id))
		{
			$id = $this->decodeString($id);
			
			if(ProductReview::where('id', '=', $id)->exists()) 
			{
				$fetchedData 		= 	ProductReview::where('id', '=', $id)->with(['studentData'=>function($query){
					$query->select('id', 'first_name', 'last_name', 'email');
				}, 'productData'=>function($query){
					$query->select('id', 'subject_name');
				}])->first();

				return view('Admin.product.view_review', compact(['fetchedData']));
			}
			else
			{
				return Redirect::to('/admin/products')->with('error', 'Product'.Config::get('constants.not_exist'));
			}
		}
		else
		{
			return Redirect::to('/admin/products')->with('error', Config::get('constants.unauthorized'));
		}
	}	
}
