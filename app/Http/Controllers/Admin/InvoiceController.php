<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\Invoice;
use App\Item;
use App\InvoiceDetail;
use App\InvoicePayment;
use App\InvoiceFollowup;
use App\EmailTemplate;
use App\ShareInvoice;
use App\TaxRate;
use App\Currency;
use App\Contact;
use App\AttachFile;
 use PDF;
use Auth; 
use Config;

class InvoiceController extends Controller
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
		//check authorization start	
			/* $check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}*/	
		//check authorization end
		
		$query 		= Invoice::where('user_id', '=', Auth::user()->id)->with(['customer']);
		$lists		= $query->orderby('id','desc')->get();
		return view('Admin.invoice.index',compact(['lists'])); 

	}   
	
	public function paymentsave(Request $request){
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
				'invoice_id' => 'required',
				'amount_rec' => 'required',
				'payment_date' => 'required',
			  ]);
			if(Invoice::where('id', '=', $request->invoice_id)->where('user_id', '=', Auth::user()->id)->exists()) 
			{  
				$requestData 		= 	$request->all();
				$invoicedetail = Invoice::where('id', '=', $request->invoice_id)->where('user_id', '=', Auth::user()->id)->first();
				
				$amount_rec = InvoicePayment::where('invoice_id',$request->invoice_id)->get()->sum("amount_rec");
				$fullamount = $requestData['amount_rec'] + $amount_rec;
				if($fullamount > $invoicedetail->amount){
					return json_encode(array('success' => false, 'message' => 'It looks like you\'ve entered an excess amount.'));
				}else{
					$obj				= 	new InvoicePayment;
					$obj->invoice_id	=	$request->invoice_id;
					$obj->amount_rec	=	@$requestData['amount_rec'];
					$obj->bank_charges	=	@$requestData['bank_charges'];
					$obj->payment_date	=	@$requestData['payment_date'];
					$obj->payment_mode	=	@$requestData['payment_mode'];
					$obj->reference	=	@$requestData['reference'];
					$obj->notes	=	@$requestData['notes'];
					
					$saved				=	$obj->save(); 
					
					
					if(!$saved)
					{
						return json_encode(array('success' => false, 'message' => 'Please try again'));
					}else{
						$objf				= 	new InvoiceFollowup;
						$objf->invoice_id	=	$request->invoice_id;
						$objf->user_id	=	Auth::user()->id;
						$objf->followup_type	=	'payment';
						$objf->comment	=	"Payment of {currency}".$requestData['amount_rec']." received";
						$followupsaved				=	$objf->save(); 
						
						$objs = Invoice::find($request->invoice_id);
						if($fullamount < $invoicedetail->amount){
							$objs->status = 3;
						}else{
							$objs->status = 1;
						}
						
						$savedstatus		=	$objs->save(); 
						if(@$requestData['email_payment'] == 1){
							
							$customer = Contact::where('id', '=', $invoicedetail->customer_id)->first();
							$replaceav = array('{customer_name}','{company_name}','{company_logo}','{company_email}');$replace_withav = array(@$customer->first_name.' '.@$customer->last_name, @Auth::user()->company_name, \URL::to('/').'/public/img/profile_imgs/'.@Auth::user()->profile_img, @Auth::user()->email);			
							$emailtemplate	= 	DB::table('email_templates')->where('alias', 'thank-you-payment')->first();
						$subContentav 	= 	$emailtemplate->subject;
						$issuccess = $this->send_email_template($replaceav, $replace_withav, 'thank-you-payment', $customer->contact_email,$subContentav,'info@crm.travelsdata.com'); 
						}
						return json_encode(array('success' => true, 'message' => 'Payment Saved successfully'));
					}	
				}
			}else{
				return json_encode(array('success' => false, 'message' => 'ID not exist'));
			}
		}	
	}
	
	public function editpaymentsave(Request $request){
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
				'payment_id' => 'required',
				'amount_rec' => 'required',
				'payment_date' => 'required',
			  ]);
			if(InvoicePayment::where('id', '=', $request->payment_id)->exists()) 
			{  
				$requestData 		= 	$request->all();
				$invoicepaydetail = InvoicePayment::where('id', '=', $request->payment_id)->first();
				$amount_rec = InvoicePayment::where('invoice_id',$invoicepaydetail->invoice_id)->where('id','!=',$request->payment_id)->get()->sum("amount_rec");
				 $fullamount = $requestData['amount_rec'] + $amount_rec;
				
				$invoicedetail = Invoice::where('id', '=', $invoicepaydetail->invoice_id)->first();
				if($fullamount > $invoicedetail->amount){
					return json_encode(array('success' => false, 'message' => 'It looks like you\'ve entered an excess amount.'));
				}else{
					$obj				= 	InvoicePayment::find($request->payment_id);
					$obj->amount_rec	=	@$requestData['amount_rec'];
					$obj->bank_charges	=	@$requestData['bank_charges'];
					$obj->payment_date	=	@$requestData['payment_date'];
					$obj->payment_mode	=	@$requestData['payment_mode'];
					$obj->reference	=	@$requestData['reference'];
					$obj->notes	=	@$requestData['notes'];
					
					$saved				=	$obj->save(); 
					
					
					if(!$saved)
					{
						return json_encode(array('success' => false, 'message' => 'Please try again'));
					}else{
						if($requestData['amount_rec'] != $invoicepaydetail->amount_rec){
						$objf				= 	new InvoiceFollowup;
						$objf->invoice_id	=	$invoicepaydetail->invoice_id;
						$objf->user_id	=	Auth::user()->id;
						$objf->followup_type	=	'payment';
						$objf->comment	=	"Payment #".$invoicepaydetail->id." details modified. Amount changed from {currency}".number_format($invoicepaydetail->amount_rec, 2)." to {currency}".number_format($requestData['amount_rec'], 2);
						$followupsaved				=	$objf->save(); 
					}
						$objs = Invoice::find($invoicepaydetail->invoice_id);
						if($fullamount < $invoicedetail->amount){
							$objs->status = 3;
						}else{
							$objs->status = 1;
						}
						
						$savedstatus		=	$objs->save(); 
						return json_encode(array('success' => true, 'message' => 'Payment Saved successfully'));
					}	
				}
			}else{
				return json_encode(array('success' => false, 'message' => 'ID not exist'));
			}
		}	
	}
	
	public function detail(Request $request){
		if(Invoice::where('id', '=', $request->invoiceid)->where('user_id', '=', Auth::user()->id)->exists()) 
		{
			$invoicedetail = Invoice::where('id', '=', $request->invoiceid)->where('user_id', '=', Auth::user()->id)->with(['customer'])->first();
			$amount_rec = \App\InvoicePayment::where('invoice_id',$request->invoiceid)->get()->sum("amount_rec");
			$invoicedetail->amount = $invoicedetail->amount - $amount_rec;
			return json_encode(array('success' => true, 'invoicedetail' => $invoicedetail));
		}else{
			return json_encode(array('success' => false, 'message' => 'ID not exist'));
		}
	}
	
	public function editpayment(Request $request){
		if(InvoicePayment::where('id', '=', $request->invoiceid)->exists()) 
		{
			$query = InvoicePayment::where('id', '=', $request->invoiceid);
			$invoicedetail 	= 	$query->with(['invoice' => function($query)
					{
						$query->select('id', 'user_id', 'customer_id', 'status');
						$query->with(['customer' => function($subQuery){
							$subQuery->select('id', 'first_name','last_name');
						}]);
					}])->first();				
		
			return json_encode(array('success' => true, 'invoicedetail' => $invoicedetail));
		}else{
			return json_encode(array('success' => false, 'message' => 'ID not exist'));
		}
	}
	
	public function email(Request $request, $id = Null){
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$invoice 		= Invoice::where('id', '=', $requestData['id'])->where('user_id', '=', Auth::user()->id)->with(['customer'])->first();
			$objfs = new ShareInvoice;
			$objfs->invoice_id	=	$requestData['id'];
			//$objf->invoice_link	=	md5($id);
			$objfs->expire_date	=	date('Y-m-d', strtotime('+30 days'));
			$objfs->user_id	=	Auth::user()->id;
			$followupsaved				=	$objfs->save(); 
			if($followupsaved){
				$ob = ShareInvoice::find($objfs->id);
				$ob->invoice_link	=	md5($requestData['id'].$objfs->id);
				$ob->save(); 
				$invoicelink = \URL::to('/invoice/secure/'.base64_encode(convert_uuencode(@$ob->invoice_link)));
			}else{ $invoicelink = '';  }
			$currencydata = Currency::where('id',$invoice->currency_id)->first();
			$replace = array('{customer_name}', '{currency}', '{invoice_amount}', '{invoice_no}', '{invoice_date}','{due_date}','{invoice_link}','{company_name}','{support_mail}','{company_logo}');	
			
			$replace_with = array(@$invoice->customer->first_name.' '.@$invoice->customer->last_name, $currencydata->currency_symbol,number_format($invoice->amount, $currencydata->decimal), @$invoice->invoice, @$invoice->invoice_date, @$invoice->due_date, $invoicelink, @Auth::user()->company_name,@Auth::user()->email, \URL::to('/').'/public/img/profile_imgs/'.@Auth::user()->profile_img);
			
			$replacesub = array('{invoice_no}', '{company_name}');					
			$replace_with_sub = array(@$invoice->invoice, @Auth::user()->company_name);
			
			$emailtemplate	= 	DB::table('email_templates')->where('alias', 'send-invoice')->first();
			$subContent 	= 	$emailtemplate->subject;
			$subContent	=	str_replace($replacesub,$replace_with_sub,$subContent);
			if(!empty(@$requestData['attacfile_id'])){
				$invoicedetail = Invoice::find($invoice->id);
				$invoicefilename = $invoicedetail->invoice.'-'.$invoicedetail->id.'.pdf';

				$pdf = PDF::setOptions([
				'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
				'logOutputFile' => storage_path('logs/log.htm'),
				'tempDir' => storage_path('logs/')
				])->loadView('invoices.invoice', compact('invoicedetail'));
				$output = $pdf->output();

				file_put_contents('public/invoices/'.$invoicefilename, $output);
				$array['view'] = 'emails.invoice';
				if(@$requestData['attach_invoice'] == 1){
				$array['file'] = 'public/invoices/'.$invoicefilename;
				$array['file_name'] = $invoicefilename;
				}
				$attacfile_id = count($requestData['attacfile_id']);
				for($i = 0; $i <count($requestData['attacfile_id']); $i++){
					$a = AttachFile::where('id', '=', $requestData['attacfile_id'][$i])->first();
					$array['files'][$i] = 'public/img/attach_files/'.$a->files;
				}
				$issuccess = $this->send_multipleattachment_email_template($replace, $replace_with, 'send-invoice', $requestData['send_to'],$subContent,'info@crm.travelsdata.com',$array);
				if(@$requestData['attach_invoice'] == 1){
				unlink($array['file']);
				}
			}
			else if(@$requestData['attach_invoice'] == 1){
				/*Attachment start*/
				$invoicedetail = Invoice::find($invoice->id);
				$invoicefilename = $invoicedetail->invoice.'-'.$invoicedetail->id.'.pdf';

				$pdf = PDF::setOptions([
				'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
				'logOutputFile' => storage_path('logs/log.htm'),
				'tempDir' => storage_path('logs/')
				])->loadView('invoices.invoice', compact('invoicedetail'));
				$output = $pdf->output();

				file_put_contents('public/invoices/'.$invoicefilename, $output);

				$array['view'] = 'emails.invoice';
				$array['file'] = 'public/invoices/'.$invoicefilename;
				$array['file_name'] = $invoicefilename;

				//sends email to customer with the invoice pdf attached
				$issuccess = $this->send_attachment_email_template($replace, $replace_with, 'send-invoice', $requestData['send_to'],$subContent,'info@crm.travelsdata.com',$array);
				unlink($array['file']);
				/*Attachment end*/
			}else{
				$issuccess = $this->send_email_template($replace, $replace_with, 'send-invoice', $requestData['send_to'],$subContent,'info@crm.travelsdata.com');
			}
			
			if($issuccess){
				$objf				= 	new InvoiceFollowup;
				$objf->invoice_id	=	$requestData['id'];
				$objf->user_id	=	Auth::user()->id;
				$objf->followup_type	=	'invoice_email';
				$objf->comment	=	"Invoice emailed to ".$requestData['send_to'];
				$followupsaved				=	$objf->save(); 
				return Redirect::to('/admin/invoice/lists/'.base64_encode(convert_uuencode(@$requestData['id'])))->with('success', 'Invoice send Successfully');
			}else{
				return Redirect::to('/admin/invoice/lists'.base64_encode(convert_uuencode(@$requestData['id'])))->with('error', 'Please try again');
			}
		}else{
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);
				if(Invoice::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->exists()) 
				{
					$invoice 		= Invoice::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->with(['customer'])->first();
					$emailtemplate = EmailTemplate::where('alias','send-invoice')->first();
					return view('Admin.invoice.email',compact(['emailtemplate','invoice'])); 
				}else 
				{
					return Redirect::to('/admin/invoice')->with('error', 'invoice Not Exist');
				}		
			}else{
				return Redirect::to('/admin/invoice')->with('error', Config::get('constants.unauthorized'));
			}
		}
	}
	
	public function reminder(Request $request, $id = Null){
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$invoice 		= Invoice::where('id', '=', $requestData['id'])->where('user_id', '=', Auth::user()->id)->with(['customer'])->first();
				$amount_rec = InvoicePayment::where('invoice_id',$invoice->id)->get()->sum("amount_rec");
				$baldue = $invoice->amount - $amount_rec;
				$currencydata = Currency::where('id',$invoice->currency_id)->first();
				$currency_sign = $currencydata->currency_symbol;
				 $replace = array('{customer_name}', '{invoice_no}', '{invoice_date}', '{due_date}','{amount}','{company_name}');					
					$replace_with = array(@$invoice->customer->first_name.' '.@$invoice->customer->last_name, @$invoice->invoice,@$invoice->invoice_date, @$invoice->due_date, $currency_sign.$baldue, @Auth::user()->company_name);
				
				 $replacesub = array('{due_amount}', '{invoice_no}');					
				$replace_with_sub = array($currency_sign.$baldue, @$invoice->invoice);
				
				$emailtemplate	= 	DB::table('email_templates')->where('alias', 'invoice-reminder')->first();
				$subContent 	= 	$emailtemplate->subject;
				$subContent	=	str_replace($replacesub,$replace_with_sub,$subContent);
				
				
				if(@$requestData['attach_invoice'] == 1){
					
				/*Attachment start*/
				$invoicedetail = Invoice::find($invoice->id);
				$invoicefilename = $invoicedetail->invoice.'-'.$invoicedetail->id.'.pdf';

				$pdf = PDF::setOptions([
				'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
				'logOutputFile' => storage_path('logs/log.htm'),
				'tempDir' => storage_path('logs/')
				])->loadView('invoices.invoice', compact('invoicedetail'));
				$output = $pdf->output();

				file_put_contents('public/invoices/'.$invoicefilename, $output);

				$array['view'] = 'emails.invoice';
				$array['file'] = 'public/invoices/'.$invoicefilename;
				$array['file_name'] = $invoicefilename;

				//sends email to customer with the invoice pdf attached
				$issuccess = $this->send_attachment_email_template($replace, $replace_with, 'invoice-reminder', $requestData['send_to'],$subContent,'info@crm.travelsdata.com',$array);
				unlink($array['file']);
				/*Attachment end*/
				}else{
					
					$issuccess = $this->send_email_template($replace, $replace_with, 'invoice-reminder', $requestData['send_to'],$subContent,'info@crm.travelsdata.com');
				}
				
			if($issuccess){
				
				$objf				= 	new InvoiceFollowup;
				$objf->invoice_id	=	$requestData['id'];
				$objf->user_id	=	Auth::user()->id;
				$objf->followup_type	=	'invoice_email';
				$objf->comment	=	"Payment reminder sent to ".$requestData['send_to'];
				$followupsaved				=	$objf->save(); 
				return Redirect::to('/admin/invoice/lists/'.base64_encode(convert_uuencode(@$requestData['id'])))->with('success', 'Invoice send Successfully');
			}else{
				return Redirect::to('/admin/invoice/lists'.base64_encode(convert_uuencode(@$requestData['id'])))->with('error', 'Please try again');
			}
		}else{
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);
				if(Invoice::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->exists()) 
				{
					$invoice 		= Invoice::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->with(['customer'])->first();
					$emailtemplate = EmailTemplate::where('alias','invoice-reminder')->first();
					return view('Admin.invoice.reminder',compact(['emailtemplate','invoice'])); 
				}else 
				{
					return Redirect::to('/admin/invoice')->with('error', 'invoice Not Exist');
				}		
			}else{
				return Redirect::to('/admin/invoice')->with('error', Config::get('constants.unauthorized'));
			}
		}
	}
	
	public function lists(Request $request, $id = Null)
	{	
		if(isset($id) && !empty($id))
		{
			$id = $this->decodeString($id);		
			if(Invoice::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->exists()) 
			{
				$invoicedetail = Invoice::find($id);
				$query 		= Invoice::where('user_id', '=', Auth::user()->id)->with(['customer']);
				$lists		= $query->orderby('id','desc')->get();
				return view('Admin.invoice.lists',compact(['invoicedetail','lists']));  
			}
			else 
			{
				return Redirect::to('/admin/invoice')->with('error', 'invoice Not Exist');
			}
		}else{
			return Redirect::to('/admin/invoice')->with('error', Config::get('constants.unauthorized'));
		}
		
	}
	
	public function invoicebyid(Request $request)
	{	
		if(isset($_GET['invoiceid']) && $_GET['invoiceid'] !='')
		{
			$id = $this->decodeString($_GET['invoiceid']);		
			if(Invoice::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->exists()) 
			{
				$invoicedetail = Invoice::find($id);
				$query 		= Invoice::where('user_id', '=', Auth::user()->id)->with(['customer']);
				$lists		= $query->orderby('id','desc')->get();
				return view('Admin.invoice.invoicebyid',compact(['invoicedetail','lists'])); 
			}
			else 
			{
				echo 'Not exist';
			}
		}
		
	} 
	public function create(Request $request)  
	{		
		$userid = Auth::user()->id; 
		$invoice = DB::select("select invoiceid from invoices where user_id = '$userid' order by id DESC LIMIT 1");
		
		if($invoice){
			$invoicenumber = "INV-".str_pad($invoice[0]->invoiceid + 1, 7, "0", STR_PAD_LEFT);;
		}else{
			 $invoicenumber = "INV-".str_pad(1, 7, "0", STR_PAD_LEFT);
		}
		return view('Admin.invoice.create',compact(['invoicenumber']));  

	} 
	
	public function store(Request $request)  
	{		
	
		$userid = Auth::user()->id; 
		$invoice = DB::select("select invoiceid from invoices where user_id = '$userid' order by id DESC LIMIT 1");
		
		if($invoice){
			$invoicenumber = "INV-".str_pad($invoice[0]->invoiceid + 1, 7, "0", STR_PAD_LEFT);
			$invoiceid = $invoice[0]->invoiceid + 1;
		}else{
			 $invoicenumber = "INV-".str_pad(1, 7, "0", STR_PAD_LEFT);
			 $invoiceid = 1;
		}
		$requestData 		= 	$request->all();
		$subtotal = 0;
		$total_value = 0;
		for($i =1; $i<count($requestData['item_detail']); $i++){
			//echo $requestData['item_detail'][$i].'---'.$requestData['quantity'][$i].'---'.$requestData['rate'][$i].'<br>';
			 $total_value = $requestData['rate'][$i] * $requestData['quantity'][$i];
			$subtotal += $total_value;
		}
		
		 $discount = $requestData['discount'];
		 $discounttype = $requestData['disc_type'];
		if($discounttype == 'fixed'){
			
			 $per = $discount;
			$finaltotal = $subtotal - $discount;
			 
		}else {
	
			$per = ($subtotal * $discount) / 100;
			$finaltotal = $subtotal - $per;
		}
		if(@Auth::user()->is_business_gst == 'yes'  && $requestData['tax'] != 0){
			$cure = TaxRate::where('id',$requestData['tax'])->first();
			$taxcal = ($finaltotal * $cure->rate) / 100;
			$finaltotal = $finaltotal + $taxcal; 
		}
		
		$obj						= 	new Invoice; 
		$obj->user_id				=	Auth::user()->id;  
		$obj->customer_id				=	$requestData['customer_name'];  
		$obj->invoiceid				=	$invoiceid;  
		$obj->invoice				=	$invoicenumber;  
		$obj->invoice_date				=	$requestData['invoice_date'];  
		$obj->order_id				=	$requestData['order_no'];  
		$obj->terms				=	$requestData['terms'];  
		$obj->customer_note				=	$requestData['customer_note'];  
		$obj->term_condition				=	$requestData['term_condition'];  
		$obj->currency_id				=	@$requestData['currency_id'];  
		$obj->amount				=	$finaltotal;  
		$obj->discount_type				=	$requestData['disc_type'];  
		$obj->discount				=	$requestData['discount'];  
		$obj->due_date				=	$requestData['due_date'];  
		$obj->tax				=	@$requestData['tax'];  
		$saved				=	$obj->save();  
		for($i =1; $i<count($requestData['item_detail']); $i++){
			//echo $requestData['item_detail'][$i].'---'.$requestData['quantity'][$i].'---'.$requestData['rate'][$i].'<br>';
			$invoicedetail = new InvoiceDetail;
			$invoicedetail->invoice_id = $obj->id;
			$invoicedetail->item_name = $requestData['item_detail'][$i];
			$invoicedetail->quantity = $requestData['quantity'][$i];
			$invoicedetail->rate = $requestData['rate'][$i];
			$saved				=	$invoicedetail->save();
			
			if(Item::where('name',$requestData['item_detail'][$i])->where('user_id',Auth::user()->id)->exists()){
				
			}else{
				$it = new Item;
				$it->user_id = Auth::user()->id;
				$it->name = $requestData['item_detail'][$i];
				$it->save();
			}
		}
		if(!$saved) 
		{
			return redirect()->back()->with('error', Config::get('constants.server_error'));
		}
		else
		{ 
			$objf				= 	new InvoiceFollowup;
			$objf->invoice_id	=	$obj->id;
			$objf->user_id	=	Auth::user()->id;
			$objf->followup_type	=	'invoice_update';
			$objf->comment	=	"Invoice created for {currency}".$finaltotal;
			$followupsaved				=	$objf->save(); 
			
			/* $invoicedetail = Invoice::find($obj->id);
				$invoicefilename = $invoicedetail->invoice.'-'.$invoicedetail->id.'.pdf';
					if(file_exists('public/invoices/'.$invoicefilename)){
						$this->unlinkFile($invoicefilename, 'public/invoices/');
					}else{
						 $pdf = PDF::setOptions([
                            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
                            'logOutputFile' => storage_path('logs/log.htm'),
                            'tempDir' => storage_path('logs/')
                        ])->loadHtml('invoices.invoice', compact('invoicedetail'));
						$output = $pdf->output();
						
						file_put_contents('public/invoices/'.$invoicefilename, $output);
						$invoicedetail->invoicefile = $invoicefilename;
						$invoicedetail->save(); 
					} */
			if(@$requestData['save_type'] == 'save_send'){
				return Redirect::to('/admin/invoice/email/'.base64_encode(convert_uuencode(@$obj->id)))->with('success', 'Invoice saved Successfully');
			}else if(@$requestData['save_type'] == 'save_print'){
				return Redirect::to('/admin/invoice/lists/'.base64_encode(convert_uuencode(@$obj->id)).'?print_invoice=true')->with('success', 'Invoice saved Successfully');
			}else if(@$requestData['save_type'] == 'save_share'){
				return Redirect::to('/admin/invoice/lists/'.base64_encode(convert_uuencode(@$obj->id)).'?share_invoice=true')->with('success', 'Invoice saved Successfully');
			}
			else{
				return Redirect::to('/admin/invoice/lists'.base64_encode(convert_uuencode(@$obj->id)))->with('success', 'Invoice saved Successfully');
			}
		} 
	} 
	
	public function customer_invoice_download($id)
    {
		if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	
				if(Invoice::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->exists()) 
				{
					
					$invoicedetail = Invoice::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->with(['company'])->first();
					$invoicefilename = $invoicedetail->invoice.'-'.$invoicedetail->id.'.pdf';
					$pdf = PDF::setOptions([
                        'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
                        'logOutputFile' => storage_path('logs/log.htm'),
                        'tempDir' => storage_path('logs/')
                    ])->loadView('invoices.invoice', compact('invoicedetail'));
					return $pdf->download($invoicefilename); 
				}else{
					abort(404);
				}
		}else{ abort(404); }
	}
	
	 public function customer_invoice_print($id)
    {
       if(isset($id) && !empty($id)) 
			{ 
				$id = $this->decodeString($id);	
				if(Invoice::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->exists()) 
				{ 
					
					$invoicedetail = Invoice::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->with(['company'])->first();
					$invoicefilename = $invoicedetail->invoice.'-'.$invoicedetail->id.'.pdf';
					$pdf = PDF::setOptions([
                        'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
                        'logOutputFile' => storage_path('logs/log.htm'),
                        'tempDir' => storage_path('logs/')
                    ])->loadView('invoices.invoice', compact('invoicedetail'));
					return $pdf->stream($invoicefilename); 
				}else{
					abort(404);
				}
		}else{ abort(404); }
    } 
	
	public function edit(Request $request, $id = NULL)
	{	
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			$subtotal = 0;
			$total_value = 0;
			for($i =1; $i<count($requestData['item_detail']); $i++){
				//echo $requestData['item_detail'][$i].'---'.$requestData['quantity'][$i].'---'.$requestData['rate'][$i].'<br>';
				 $total_value = $requestData['rate'][$i] * $requestData['quantity'][$i];
				$subtotal += $total_value;
			}
			$invoicedetail = Invoice::where('id', '=', $request->id)->where('user_id', '=', Auth::user()->id)->first();
				$amount_rec = InvoicePayment::where('invoice_id',$invoicedetail->id)->get()->sum("amount_rec");
				if($subtotal < $amount_rec){
					return Redirect::to('/admin/invoice/edit/'.base64_encode(convert_uuencode(@$request->id)))->with('error', 'The payment entered is more than the total amount due for this invoice. Please check and retry.');
				}else{
					$subtotal = 0;
					$total_value = 0;
					$subtotal1 = 0;
					$total_value1 = 0;
					for($i =1; $i<count($requestData['item_detail']); $i++){
						//echo $requestData['item_detail'][$i].'---'.$requestData['quantity'][$i].'---'.$requestData['rate'][$i].'<br>';
						 $total_value = $requestData['rate'][$i] * $requestData['quantity'][$i];
						$subtotal += $total_value;
					}
					
					 $discount = $requestData['discount'];
					 $discounttype = $requestData['disc_type'];
					if($discounttype == 'fixed'){
						
						 $per = $discount;
						$finaltotal = $subtotal - $discount;
						 
					}else {
				
						$per = ($subtotal * $discount) / 100;
						$finaltotal = $subtotal - $per;
					}
					if(@Auth::user()->is_business_gst == 'yes' && $requestData['tax'] != 0){
						$cure = TaxRate::where('id',$requestData['tax'])->first();
						$taxcal = ($finaltotal * $cure->rate) / 100;
						$finaltotal = $finaltotal + $taxcal; 
					}
					$obj						= 	Invoice::find($requestData['id']); 
					$obj->customer_id				=	$requestData['customer_name'];  
					  
					$obj->invoice_date				=	$requestData['invoice_date'];  
					$obj->order_id				=	$requestData['order_no'];  
					$obj->terms				=	$requestData['terms'];  
					$obj->customer_note				=	$requestData['customer_note'];  
					$obj->term_condition				=	$requestData['term_condition'];  
					$obj->amount				=	$finaltotal;  
					$obj->currency_id				=	@$requestData['currency_id'];  
					$obj->discount_type				=	$requestData['disc_type'];  
					$obj->discount				=	$requestData['discount'];  
					$obj->due_date				=	$requestData['due_date']; 
					$obj->tax				=	@$requestData['tax'];  					
					$saved				=	$obj->save();  
					$su = InvoiceDetail::where('invoice_id', $requestData['id'])->delete();
					for($i =1; $i<count($requestData['item_detail']); $i++){
						$invoicedetail = new InvoiceDetail;
						$invoicedetail->invoice_id = $obj->id;
						$invoicedetail->item_name = $requestData['item_detail'][$i];
						$invoicedetail->quantity = $requestData['quantity'][$i];
						$invoicedetail->rate = $requestData['rate'][$i];
						$saved				=	$invoicedetail->save();

						if(Item::where('name',$requestData['item_detail'][$i])->where('user_id',Auth::user()->id)->exists()){

						}else{
							$it = new Item;
							$it->user_id = Auth::user()->id;
							$it->name = $requestData['item_detail'][$i];
							$it->save();
						}
					}
					$invoicedetail = Invoice::where('id', '=', $requestData['id'])->where('user_id', '=', Auth::user()->id)->first();
					$amount_rec = InvoicePayment::where('invoice_id',$invoicedetail->id)->get()->sum("amount_rec");
					$fullamount = $subtotal + $amount_rec;
					if($finaltotal > $amount_rec){
						$ic = Invoice::find($requestData['id']);
						$ic->status = 3;
						$ic->save();
					}else{
						$ic = Invoice::find($requestData['id']);
						$ic->status = 1;
						$ic->save();
					}
					$objf				= 	new InvoiceFollowup;
						$objf->invoice_id	=	$requestData['id'];
						$objf->user_id	=	Auth::user()->id;
						$objf->followup_type	=	'invoice_update';
						$objf->comment	=	"Invoice updated";
						$followupsaved				=	$objf->save(); 
					if(!$saved) 
					{
						return redirect()->back()->with('error', Config::get('constants.server_error'));
					}
					else
					{  
			
				/* $invoicedetail = Invoice::find($request->id);
				$invoicefilename = $invoicedetail->invoice.'-'.$invoicedetail->id.'.pdf';
					if(file_exists('public/invoices/'.$invoicefilename)){
						$this->unlinkFile($invoicefilename, 'public/invoices/');
					}else{
						 $pdf = PDF::setOptions([
                            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
                            'logOutputFile' => storage_path('logs/log.htm'),
                            'tempDir' => storage_path('logs/')
                        ])->loadHtml('invoices.invoice', compact('invoicedetail'));
						$output = $pdf->output();
						
						file_put_contents('public/invoices/'.$invoicefilename, $output);
						$invoicedetail->invoicefile = $invoicefilename;
						$invoicedetail->save(); 
					} */
						  
            /* $array['view'] = 'emails.invoice';
            $array['subject'] = 'Order Placed - '.$order->code;
            $array['from'] = env('MAIL_USERNAME');
            $array['content'] = 'Hi. Your order has been placed';
            $array['file'] = 'public/invoices/Order#'.$order->code.'.pdf';
            $array['file_name'] = 'Order#'.$order->code.'.pdf';

            //sends email to customer with the invoice pdf attached
            if(env('MAIL_USERNAME') != null && env('MAIL_PASSWORD') != null){
                Mail::to($request->session()->get('shipping_info')['email'])->queue(new InvoiceEmailManager($array));
            } 
            unlink($array['file']);*/
			if(@$requestData['save_type'] == 'save_send'){
				return Redirect::to('/admin/invoice/email/'.base64_encode(convert_uuencode(@$request->id)))->with('success', 'Invoice updated Successfully');
			}else if(@$requestData['save_type'] == 'save_print'){
				return Redirect::to('/admin/invoice/lists/'.base64_encode(convert_uuencode(@$request->id)).'?print_invoice=true')->with('success', 'Invoice saved Successfully');
			}else if(@$requestData['save_type'] == 'save_share'){
				return Redirect::to('/admin/invoice/lists/'.base64_encode(convert_uuencode(@$request->id)).'?share_invoice=true')->with('success', 'Invoice saved Successfully');
			}
			else{
				return Redirect::to('/admin/invoice/lists/'.base64_encode(convert_uuencode(@$request->id)))->with('success', 'Invoice updated Successfully');
			}
						
					} 
				}
		}else{
			if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	
				if(Invoice::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->exists()) 
				{
					$fetchedData = Invoice::find($id);
					
					return view('Admin.invoice.edit', compact(['fetchedData']));
				} 
				else
				{
					return Redirect::to('/admin/invoice')->with('error', 'Invoice Not Exist');
				}
			}else{
				return Redirect::to('/admin/invoice')->with('error', Config::get('constants.unauthorized'));
			}	
		}	
	}
	
	public function sharelink(Request $request){
		if ($request->isMethod('post')) 
		{
			$id = $this->decodeString($request->invoiceid);	
			$objf = new ShareInvoice;
			$objf->invoice_id	=	$id;
			//$objf->invoice_link	=	md5($id);
			$objf->expire_date	=	$request->expire_date;
			$objf->user_id	=	Auth::user()->id;
			$followupsaved				=	$objf->save(); 
			if($followupsaved){
				$ob = ShareInvoice::find($objf->id);
				$ob->invoice_link	=	md5($id.$objf->id);
				$ob->save(); 
				$url = \URL::to('/invoice/secure/'.base64_encode(convert_uuencode(@$ob->invoice_link)));
				return json_encode(array('success' => true, 'sharelink' => $url));
			}else{
				return json_encode(array('success' => false, 'message' => "Please try again"));
			}
		}
	}
	public function disablelink(Request $request){
		if ($request->isMethod('post')) 
		{
			$id = $this->decodeString($request->invoiceid);	
			$response 	= 	DB::table('share_invoices')->where('user_id', Auth::user()->id)->update(['status' => '0']);	
			if($response){
				return json_encode(array('success' => true));
			}else{
				return json_encode(array('success' => false, 'message' => "Please try again"));
			}
		}
	}
	public function addcomment(Request $request){
		if ($request->isMethod('post')) 
		{
			
			$objf				= 	new InvoiceFollowup;
			$objf->invoice_id	=	$request->ivoiceid;
			$objf->user_id	=	Auth::user()->id;
			$objf->followup_type	=	'comment';
			$objf->comment	=	$request->comment;
			$followupsaved				=	$objf->save(); 
			if($followupsaved){
				$query = InvoiceFollowup::where('id', $objf->id)->with(['user'])->first();
				$strtime = date('d/m/Y h:i a', strtotime($query->created_at));
				$html = '<div><i class="fas fa-comment bg-blue"></i><div class="timeline-item"><span class="name">'.$query->user->first_name.' '.$query->user->last_name.'</span><h3 class="timeline-header"><i class="far fa-clock"></i> '.$strtime.' </h3><div class="timeline-body">'.$query->comment.'</div></div></div>';
				return json_encode(array('success' => true, 'followup' => $html));
			}else{
				return json_encode(array('success' => false, 'message' => 'Please try again'));
			}
		}	
	}
	public function getattachfile(Request $request){
		$id = $this->decodeString($request->invoice_id);
		if(Invoice::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->exists()) 
		{
			$fils = AttachFile::where('invoice_id', '=', $id)->get();
			$o = Invoice::find($id);
			return json_encode(array('success' => true,'files' => $fils,'state' => $o->display_attach));
		}else{ return json_encode(array('success' => false, 'message' => 'Please try again')); }
		
	}
	public function removeattachfile(Request $request){
		if(AttachFile::where('id', '=', $request->invoice_id)->exists()) 
		{
			$att = AttachFile::where('id', '=', $request->invoice_id)->first();
			 AttachFile::where('id', '=', $request->invoice_id)->delete();
			$fils = AttachFile::where('invoice_id', '=', $att->invoice_id)->get();
			
			return json_encode(array('success' => true,'files' => $fils));
		}else{
			return json_encode(array('success' => false, 'message' => 'Please try again'));
		}
	}
	public function attachfileemail(Request $request){
		$id = $this->decodeString($request->invoice_id);
		if(Invoice::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->exists()) 
		{
			$Invoice = Invoice::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->first();
			if($Invoice->display_attach == 1){
				$display_attach = 0;
			}else{
				$display_attach = 1;
			}
			$o = Invoice::find($id);
			$o->display_attach = $display_attach;
			$o->save();
			return json_encode(array('success' => true));
		}else{
			return json_encode(array('success' => false, 'message' => 'Please try again'));
		}
	}
	public function attachfile(Request $request){
		$id = $this->decodeString($request->invoice_id);
		$countatt = AttachFile::where('invoice_id', '=', $id)->count();
		if($countatt > 5){
			return json_encode(array('success' => false, 'message' => 'You can upload a maximum of 5 files'));
		}
		if(Invoice::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->exists()) 
		{
			
			$AttachFile = new AttachFile;
			$AttachFile->invoice_id = $id;
			if($request->hasfile('image')) 
			{	
				$AttachFile->files  = $this->uploadFile($request->file('image'), Config::get('constants.attach_files')); 
			}
			else
			{
				$AttachFile->files  = NULL;
			}	
			$AttachFile->name  = $request->file('image')->getClientOriginalName();
			$saved = $AttachFile->save();
			if(!$saved){
				
				return json_encode(array('success' => false, 'message' => 'Please try again'));
			}else{
				$fils = AttachFile::where('invoice_id', '=', $id)->get();
				return json_encode(array('success' => true,'files' => $fils));
			}
		}
	}
	public function history(Request $request){
		if(Invoice::where('id', '=', $request->ivoiceid)->where('user_id', '=', Auth::user()->id)->exists()) 
		{
			$invoiceid = $request->ivoiceid;
			$query = InvoiceFollowup::where('invoice_id', $request->ivoiceid)->with(['user']);
			$totalcount = $query->count();
			$fetchedData = $query->orderby('id','desc')->get();
			return view('Admin.invoice.history', compact(['fetchedData','totalcount','invoiceid']));
		}else{
			echo 'Not found';
		}	
	}
	
}
