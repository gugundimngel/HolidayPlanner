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
use Config;
use PDF;

class ProfitlossController extends Controller
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
		
		
		
		//DB::enableQueryLog();
		$query 		= BookingDetail::where('user_id',@Auth::user()->id)->where('status','=',1 )->with(['paymentdetail']);
		
			$query->where('type','=','b2b' );
		
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
		
		$lists		= $query->get(); 
		if(isset($_GET['action']) && $_GET['action'] == 'print'){
			$pdf = PDF::loadView('Agent.profitloss.pdf', compact('lists'));
				
				$pdf->save(storage_path().'_filename.pdf');
				// Finally, you can download the file using download function
				return $pdf->stream('profit&loss.pdf');
		}
		if(isset($_GET['action']) && $_GET['action'] == 'excel'){
			$pdf = PDF::loadView('Agent.profitloss.pdf', compact('lists'));
				
				$pdf->save(storage_path().'_filename.pdf');
				// Finally, you can download the file using download function
				return $pdf->download('profit&loss.pdf');
		}
		return view('Agent.profitloss.index',compact(['lists', 'totalData'])); 	
		
	}
	
}