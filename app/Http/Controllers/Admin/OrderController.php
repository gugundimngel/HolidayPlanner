<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;


use App\Product;
use App\ProductOrder;
use App\ProductTransactionHistory;
use App\User;
use App\Professor;
use App\State;
use App\Country;

use Auth;
use Config;

class OrderController extends Controller
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
	
	public function index(Request $request)
	{
		$professor_ids = array();	
		$ids = array();
		$order_ids = array();
		
		$professors = Professor::select('id', 'which_organisation')->where('which_organisation', '=', Auth::user()->id)->get();
		
		if(!empty($professors))
			{	
				foreach($professors as $professor)
					{
						array_push($professor_ids, $professor->id);
					}
			}	
		
		$products 		= Product::select('id')->whereIn('professor_id', $professor_ids)->get();
		
		if(!empty($products))
			{	
				foreach($products as $product)
					{
						array_push($ids, $product->id);
					}
			}
			
		$allOrderIds = ProductTransactionHistory::whereIn('product_id', $ids)->where('response', '=', 1)->select('id', 'order_id')->get();
		
		if(!empty($allOrderIds))
			{	
				foreach($allOrderIds as $allOrderId)
					{
						array_push($order_ids, $allOrderId->order_id);
					}
			}
		
		$order_ids = array_unique($order_ids);
		
		
		$query = ProductOrder::whereIn('id', $order_ids)->where('status', '=', 1)->with(['product_transaction_history'=>function($subQuery){
			$subQuery->select('id', 'student_id', 'order_id', 'dispatched', 'dispatched_date');
		}]);
		
		$totalData 	= $query->count();	//for all data
		
		if ($request->has('search_term_first_name')) 
		{
			$search_term_first_name 		= 	$request->input('search_term_first_name');	
			if(trim($search_term_first_name) != '')
			{
				$query->whereHas('student', function ($q) use($search_term_first_name){
					$q->where('first_name',$search_term_first_name);
				});
			}		
		}
		if ($request->has('search_term_last_name')) 
		{	
			$search_term_last_name 		= 	$request->input('search_term_last_name');	
			if(trim($search_term_last_name) != '')
			{
				$query->whereHas('student', function ($q) use($search_term_last_name){
					$q->where('last_name',$search_term_last_name);
				});
			}		
		}
		if ($request->has('search_term_email')) 
		{
			$search_term_email 		= 	$request->input('search_term_email');	
			if(trim($search_term_email) != '')
			{
				$query->whereHas('student', function ($q) use($search_term_email){
					$q->where('email',$search_term_email);
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
		
		if ($request->has('search_term_order')) 
		{
			$search_term_order 		= 	$request->input('search_term_order');	
			if(trim($search_term_order) != '')
			{
				$query->whereDate('id', '=', $search_term_order);
			}		
		}
		
		$query->with(['student'=>function($q){
			$q->select('id', 'first_name', 'last_name', 'email', 'phone');
		}]);
		
		if ($request->has('search_term_first_name') || $request->has('search_term_last_name') || $request->has('search_term_email') || $request->has('search_term_from') || $request->has('search_term_to') || $request->has('search_term_order')) 
		{
			$totalData 	= $query->count();
		}
		
		$lists = $query->sortable(['id'=>'desc'])->paginate(config('constants.limit'));
		
		return view('Admin.order.index',compact(['lists', 'totalData']));	
	}
	
	public function viewOrderDetails(Request $request, $id)
	{
		if(isset($id) && !empty($id))
		{
			$id = $this->decodeString($id);
			
			if(ProductOrder::where('id', '=', $id)->exists()) 
			{	
				$query 		= 	ProductTransactionHistory::where('order_id', '=', $id);
				
				$fetchedDatas 		= 	$query->with(['student'=>function($query){
					$query->select('id', 'first_name', 'last_name', 'email', 'phone');
				}, 'product'=>function($query1){
					$query1->select('id', 'professor_id', 'subject_name');
					$query1->with(['professor'=>function($subQuery){
						$subQuery->select('id', 'first_name', 'last_name');
					}]);
				}, 'mode_product_data'=>function($query2){
					$query2->select('id', 'mode_product');
				}])->get();
				

				$orderDetail = ProductOrder::where('id', '=', @$id)->with(['student'=>function($subQuery){
					$subQuery->with(['countryData', 'stateData']);	
				}])->first();
				
				return view('Admin.order.view_order_details', compact(['fetchedDatas', 'orderDetail']));
			}
			else
			{
				return Redirect::to('/admin/orders')->with('error', 'Order does not exist.');
			}
		}
		else
		{
			return Redirect::to('/admin/orders')->with('error', Config::get('constants.unauthorized'));
		}
	}
	
	public function dispatchRequest(Request $request)
	{
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$this->validate($request, [
										'id' => 'required',
										'serial_number' => 'required|max:255',
										'tracking_number' => 'required|max:255',
										'courier_company_name' => 'required|max:255'
									  ]);
				
			$transactionIds 		= 	ProductTransactionHistory::where('order_id', '=', @$requestData['id'])->with(['student'=>function($subQuery){
				$subQuery->select('id', 'first_name', 'last_name', 'email', 'country', 'state', 'city', 'address', 'zip', 'phone');
			}, 'product'=>function($subSubQuery){
				$subSubQuery->select('id', 'professor_id', 'subject_name');
				$subSubQuery->with(['professor'=>function($subSubSubQuery){
					$subSubSubQuery->select('id', 'first_name', 'last_name', 'which_organisation');
					$subSubSubQuery->with(['organisationData'=>function($subSubSubSubQuery){
						$subSubSubSubQuery->select('id', 'email');
					}]);	
				}]);	
			}, 'mode_product_data'=>function($subQuery){
							$subQuery->select('id', 'mode_product');
			}])->get();
			
			$productInfo = '';
			foreach($transactionIds as $data)
			{
				//product info start
					$productInfo .= '<tr style="border:1px solid #011224;">';
					$productInfo .= '<td style="border:1px solid #011224; text-align:center;">'.@$data->product->professor->first_name.' '.@$data->product->professor->last_name.'</td>';
					$productInfo .= '<td style="border:1px solid #011224; text-align:center;">'.@$data->product->subject_name.'</td>';
					$productInfo .= '<td style="border:1px solid #011224; text-align:center;">'.@$data->mode_product_data->mode_product.'</td>';
					$productInfo .= '<td style="border:1px solid #011224; text-align:center;">'.@$data->views.'</td>';
					$productInfo .= '<td style="border:1px solid #011224; text-align:center;">'.@$data->duration.'</td>';
					$productInfo .= '<td style="border:1px solid #011224; text-align:center;">'.@$data->validity.'</td>';
					$productInfo .= '<td style="border:1px solid #011224; text-align:center;">₹ '.@$data->price.'</td>';
					$productInfo .= '<td style="border:1px solid #011224; text-align:center;">'.@$data->discount.'%</td>';
					$productInfo .= '<td style="border:1px solid #011224; text-align:center;">'.@$data->quantity.'</td>';
					$productInfo .= '<td style="border:1px solid #011224; text-align:center;">₹ '.@$data->total_amount.'</td>';
					$productInfo .= '</tr>';
				//product info end
			
				$obj						= 	ProductTransactionHistory::find($data->id);
				$obj->dispatched			=	1;
				$obj->dispatched_date		=	date('Y-m-d');
				$obj->serial_number			=	$requestData['serial_number'];
				$obj->tracking_number		=	$requestData['tracking_number'];
				$obj->courier_company_name	=	$requestData['courier_company_name'];
				
				$saved						=	$obj->save();
			}

			//shipping info start
				$stateData = State::select('id', 'name')->where('id', '=', @$transactionIds[0]->student->state)->first();
				$countryData = Country::select('id', 'name')->where('id', '=', @$transactionIds[0]->student->country)->first();
			
				$shipping_info = '';
				$shipping_info .= '<p style="font-size: 14px; margin: 2px;">'.@$transactionIds[0]->student->first_name.' '.@$transactionIds[0]->student->last_name.'</p>';
				$shipping_info .= '<p style="font-size: 14px; margin: 2px;">'.@$transactionIds[0]->student->address.'</p>';		
				$shipping_info .= '<p style="font-size: 14px; margin: 2px;">'.@$transactionIds[0]->student->city.'</p>';	
				$shipping_info .= '<p style="font-size: 14px; margin: 2px;">'.@$stateData->name.', '.@$countryData->name.'</p>';	
				$shipping_info .= '<p style="font-size: 14px; margin: 2px;">'.@$transactionIds[0]->student->zip.'</p>';	
				$shipping_info .= '<p style="font-size: 14px; margin: 2px;"><b>Mobile No :</b> '.@$transactionIds[0]->student->phone.'</p>';
			//shipping info end	
			
			
			//email goes to student start
				$replace = array('{logo}', '{first_name}', '{last_name}', '{year}', '{order_id}', '{productInfo}', '{serial_number}', '{tracking_number}', '{company_name}', '{dispatch_date}', '{shipping_info}');
				$replace_with = array(\URL::to('/').Config::get('constants.logoImg'), @$transactionIds[0]->student->first_name, @$transactionIds[0]->student->last_name, date('Y'), @$transactionIds[0]->order_id, $productInfo, @$requestData['serial_number'], @$requestData['tracking_number'], @$requestData['courier_company_name'], date('Y-m-d'), @$shipping_info);
				$this->send_email_template($replace, $replace_with, 'dispatch_student', @$transactionIds[0]->student->email);	
			//email goes to student end	
			
			//email goes to superadmin start
				$replace = array('{logo}', '{first_name}', '{last_name}', '{year}', '{order_id}', '{productInfo}', '{serial_number}', '{tracking_number}', '{company_name}', '{dispatch_date}', '{shipping_info}');
				$replace_with = array(\URL::to('/').Config::get('constants.logoImg'), @$transactionIds[0]->student->first_name, @$transactionIds[0]->student->last_name, date('Y'), @$transactionIds[0]->order_id, $productInfo, @$requestData['serial_number'], @$requestData['tracking_number'], @$requestData['courier_company_name'], date('Y-m-d'), @$shipping_info);
				$this->send_email_template($replace, $replace_with, 'dispatch_superadmin', 'apnamentor.com@gmail.com');		
			//email goes to superadmin end	
			
			return Redirect::to('/admin/view_order_details/'.$this->encodeString($requestData['id']))->with('success', 'Dispatched Order successfully.');			
		}
		else
		{
			return redirect()->back()->with('error', Config::get('constants.post_method'));
		}	
	}
	
	public function exportOrder(Request $request)
	{
		$headers = array(
							"Content-type" => "text/csv",
							"Content-Disposition" => "attachment; filename=Order Report.csv",
							"Pragma" => "no-cache",
							"Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
							"Expires" => "0"
						);
						
		$professor_ids = array();	
		$product_ids = array();
		$order_ids = array();
		
		$professors = Professor::select('id', 'which_organisation')->where('which_organisation', '=', Auth::user()->id)->get();
		
		if(!empty($professors))
			{	
				foreach($professors as $professor)
					{
						array_push($professor_ids, $professor->id);
					}
			}
			
		$products 		= Product::select('id')->whereIn('professor_id', $professor_ids)->get();
		
		if(!empty($products))
			{	
				foreach($products as $product)
					{
						array_push($product_ids, $product->id);
					}
			}
		
		$allOrderIds = ProductTransactionHistory::whereIn('product_id', $product_ids)->where('response', '=', 1)->select('id', 'order_id')->get();
		
		if(!empty($allOrderIds))
			{	
				foreach($allOrderIds as $allOrderId)
					{
						array_push($order_ids, $allOrderId->order_id);
					}
			}
		
		$order_ids = array_unique($order_ids);				
		
		$reports = ProductOrder::whereIn('id', $order_ids)->where('status', '=', 1)->with(['product_transaction_history'=>function($subQuery){
			$subQuery->select('id', 'student_id', 'order_id', 'subject_name', 'quantity', 'pay_amount', 'created_at');
		}, 'student' => function($subQuery1){
			$subQuery1->select('id', 'first_name', 'last_name', 'email', 'phone');
		}])->get();	
	
		$columns = array('Order Number', 'Name', 'Email', 'Phone', 'Product Name', 'Quantity', 'Pay Amount', 'Date');	
		
		$callback = function() use ($reports, $columns)
			{
				$file = fopen('php://output', 'w');
				fputcsv($file, $columns);

				foreach($reports as $reportData) 
				{
					fputcsv($file, array(@$reportData->product_transaction_history[0]->order_id, @$reportData->student->first_name.' '.@$reportData->student->last_name, @$reportData->student->email, @$reportData->student->phone, @$reportData->product_transaction_history[0]->subject_name, @$reportData->product_transaction_history[0]->quantity, @$reportData->product_transaction_history[0]->pay_amount, date('d M Y', strtotime(@$reportData->product_transaction_history[0]->created_at))));
				}
				fclose($file);
			};
		return Response::stream($callback, 200, $headers);									
	}
	
}
