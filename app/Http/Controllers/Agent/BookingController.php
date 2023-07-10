<?php
namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\BookingDetail;
 
use Auth;  
use PDF;  
use Config;

class BookingController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:agents'); 
    }
	/**
     * All Vendors. 
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		
		 $type = 'b2b';
		
		//DB::enableQueryLog();
		$query 		= BookingDetail::where('agent_id',@Auth::user()->id)->where('type','=',$type )->with(['paymentdetail']);
		
		$totalData 	= $query->count();	//for all data
		if ($request->has('pnr')) 
		{
			$pnr 		= 	$request->input('pnr'); 
			if(trim($pnr) != '')
			{
				$query->where('pnr', '=', @$pnr);
			}
		}
		if ($request->has('ref')) 
		{
			$ref 		= 	$request->input('ref'); 
			if(trim($ref) != '')
			{
				$ex = explode('-',$ref);
				$query->where('id', '=', @$ex[1]);
			}
		}
		if ($request->has('from')) 
		{
			$from 		= 	$request->input('from'); 
			if(trim($from) != '')
			{
			
				$query->whereDate('from_date', '=', @date('Y-m-d',strtotime($from)));
			}
		}
		if ($request->has('to')) 
		{
			$to 		= 	$request->input('to'); 
			if(trim($to) != '')
			{
			
				$query->whereDate('to_date', '=', @date('Y-m-d',strtotime($to)));
			}
		}
		
		if ($request->has('email')) 
		{
			$email 		= 	$request->input('email'); 
			if(trim($email) != '')
			{
				$query->whereHas('user', function ($q) use($email){
					$q->where('email','=',$email);
				});
			}
		}
		
		if ($request->has('mobile')) 
		{
			$phone 		= 	$request->input('mobile'); 
			if(trim($phone) != '')
			{
				$query->whereHas('user', function ($q) use($phone){
					$q->where('phone','=',$phone);
				});
			}
		}
		if ($request->has('status')) 
		{
			$status 		= 	$request->input('status'); 
			if(trim($status) != '')
			{
				$query->where('status', '=', $status);
			}
		}
		if ($request->has('source')) 
		{
			$source 		= 	$request->input('source'); 
			if(trim($source) != '')
			{
				$query->where('source', '=', $source);
			}
		}
		if ($request->has('destination')) 
		{
			$destination 		= 	$request->input('destination'); 
			if(trim($destination) != '')
			{
				$query->where('destination', '=', $destination);
			}
		}
		
		$lists		= $query->orderby('created_at','DESC')->get(); 
		if(isset($_GET['action']) && $_GET['action'] == 'print'){
			$pdf = PDF::loadView('Agent.bookings.pdf', compact('lists'));
				
				$pdf->save(storage_path().'_filename.pdf');
				// Finally, you can download the file using download function
				return $pdf->stream('bookingreport.pdf');
		}
		if(isset($_GET['action']) && $_GET['action'] == 'excel'){
			$finalexcel = array();
			$firstheading = array('Journey Detail','Journey Date','Return Journey Detail','Return Journey Date','Ref No','PNR','Booking Date', 'Pessanger Detail','Ticket Status','Payment Status','Amount');
			array_push($finalexcel,$firstheading);
			foreach($lists as $bookdetail){
				$booking_response = json_decode($bookdetail->booking_response);
				$bookingib_request = json_decode($bookdetail->bookingib_request);
				$tr = 0;
				if(isset($booking_response->Response->Response->FlightItinerary->Segments)){
					$tr = count(@$booking_response->Response->Response->FlightItinerary->Segments) -1;
				}
				//echo '<pre>'; print_r($booking_response); 
				$booking_response_ib = array();
				$trr = 0;
				if($bookdetail->booking_response_ib != ''){
					$booking_response_ib = json_decode(@$bookdetail->booking_response_ib);
					
					$trr = @count(@$booking_response_ib->Response->Response->FlightItinerary->Segments) -1;
				}
				
				if(@$bookdetail->depart_flight == ''){
					$journeydetail = $booking_response->Response->Response->FlightItinerary->Segments[0]->Origin->Airport->AirportCode.'-'.@$booking_response->Response->Response->FlightItinerary->Segments[$tr]->Destination->Airport->AirportCode;
					$journeydate = date('d/m/Y', strtotime(@$booking_response->Response->Response->FlightItinerary->Segments[0]->Origin->DepTime));
				}else{
					$journeydetail = $bookdetail->depart_flight;
					$journeydate = date('d/m/Y', strtotime(@$bookdetail->depart_date));
				}
				if($bookdetail->return_flight == '' && !empty($booking_response_ib)){
					$returnjourneydetail = @$booking_response_ib->Response->Response->FlightItinerary->Segments[0]->Origin->Airport->AirportCode.'-'.@$booking_response_ib->Response->Response->FlightItinerary->Segments[$trr]->Destination->Airport->AirportCode;
					$returnjourneydate = date('d/m/Y', strtotime(@$booking_response_ib->Response->Response->FlightItinerary->Segments[0]->Origin->DepTime));
				}else{
					$returnjourneydetail = '';
					$returnjourneydate = '';
					if($bookdetail->return_flight != ''){
						$returnjourneydetail = $bookdetail->return_flight;
						$returnjourneydate = date('d/m/Y', strtotime(@$bookdetail->return_date));
					}
				}
				$pessangers = '';
				
				if(isset($bookingib_request->adulttitle)){
					$pes = $bookingib_request->adulttitle;
					for($ps =0;$ps<count($pes); $ps++){
						$pessangers .= @$bookingib_request->adulttitle[$ps].' '.@$bookingib_request->adultfirstname[$ps].' '.@$bookingib_request->adultlastname[$ps].' (Adult) '.PHP_EOL ;
					}
				}
				if(isset($bookingib_request->childtitle)){ 
					$pes = $bookingib_request->childtitle;
					for($ps =0;$ps<count($pes); $ps++){
						$pessangers .= @$bookingib_request->childtitle[$ps].' '.@$bookingib_request->childfirstname[$ps].' '.@$bookingib_request->childlastname[$ps].' (Child) \r\n';
					}
				}
				if(isset($bookingib_request->infanttitle)){ 
					$pes = $bookingib_request->infanttitle;
					for($ps =0;$ps<count($pes); $ps++){
						$pessangers .= @$bookingib_request->infanttitle[$ps].' '.@$bookingib_request->infantfirstname[$ps].' '.@$bookingib_request->infantlastname[$ps].' (Infant) \r\n';
					}
				}
				$ticketstatus = '';
				if($bookdetail->status == 1){
					$ticketstatus = 'Confirm';
				}else if($bookdetail->status == 2){
					$ticketstatus = 'Failed';
				}else{
					$ticketstatus = 'Pending';
				}
				$paymentstatus = '';
				if($bookdetail->paymentdetail->status == 1){
					$paymentstatus = 'Success';
				}else if($bookdetail->paymentdetail->status == 2){
					$paymentstatus = 'Failed';
				}else{
					$paymentstatus = 'Pending';
				}
				$exceldata = array(@$journeydetail,@$journeydate,@$returnjourneydetail,@$returnjourneydate, 'ZAP-'.$bookdetail->id,@$bookdetail->pnr, date('d/m/Y h:i', strtotime(@$bookdetail->created_at)), $pessangers, $ticketstatus, $paymentstatus,@$bookdetail->paymentdetail->amount);
				array_push($finalexcel,$exceldata);
			}
			$this->exports_data($finalexcel,date('Y-m-d')."_Booking_Report");
		}
		return view('Agent.bookings.index',compact(['lists', 'totalData'])); 
		
		//return view('Admin.managecontact.index'); 	
		
	}
	
	public function BookingDetail(Request $request, $id = Null){
		if(isset($id) && !empty($id)) 
		{
			$id = $this->decodeString($id);	 
			if(BookingDetail::where('agent_id',@Auth::user()->id)->where('id', '=', $id)->exists()) 
				{
					$fetchedData = BookingDetail::find($id);
					return view('Agent.bookings.detail', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/agent/bookings')->with('error', 'Not Exist');
				}
		}else
			{
				return Redirect::to('/agent/bookings')->with('error', Config::get('constants.unauthorized'));
			}
	}
	public function logs(Request $request, $id = Null){
		if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	 
				if(BookingDetail::where('agent_id',@Auth::user()->id)->where('id', '=', $id)->exists()) 
				{
					$fetchedData = BookingDetail::find($id);
					return view('Agent.bookings.logs', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/agent/bookings')->with('error', 'Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/agent/bookings')->with('error', Config::get('constants.unauthorized'));
			}
	}
}