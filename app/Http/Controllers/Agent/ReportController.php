<?php
namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\BookingDetail;
use App\WalletHistory;
 
use Auth;  
use PDF;  
use Config;
use Carbon\Carbon;

class ReportController extends Controller
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
	public function dailysale(Request $request)
	{  
	if($request->type == 'b2b'){
		DB::enableQueryLog();
		$query 		= BookingDetail::where('user_id',@Auth::user()->id)->where('type','=','b2b' )->where('status','=',1 )->with(['paymentdetail','agent']);
		if($request->agent != 'all'){
			$agent 		= 	$request->input('agent');
			if(trim($agent) != '')
			{
				$query->where('user_id', '=', $agent);
			}
		}
		if ($request->has('submission_from')) 
		{
			$search_term_from 		= 	$request->input('submission_from');
			if(trim($search_term_from) != '')
			{
				$efrom = explode('/',$search_term_from);
				$from = $efrom[2].'-'.$efrom[0].'-'.$efrom[1];
				$query->whereDate('created_at', '>=', $from);
			}
		} 
		
		if ($request->has('submission_to')) 
		{	
			$search_term_to 		= 	$request->input('submission_to');
			
			if(trim($search_term_to) != '')
			{
				$eto = explode('/',$search_term_to);
					$to = $eto[2].'-'.$eto[0].'-'.$eto[1];
				$query->whereDate('created_at', '<=', $to);
			}	
		}
		if ($request->has('submission_from') && $request->has('submission_to') ) 
		{
			$totalData 	= $query->count();
		}else{
			$query->whereDate('created_at',Carbon::today());
		}
		
		$b2blists		= $query->get();
		$b2clists = array();
		//dd(DB::getQueryLog());
	}else{
		$query 		= BookingDetail::where('user_id',@Auth::user()->id)->where('type','=','b2b')->where('status','=',1)->with(['paymentdetail']);
		if ($request->has('from')) 
		{
			$search_term_from 		= 	$request->input('from');
			if(trim($search_term_from) != '')
			{
				$efrom = explode('/',$search_term_from);
				$from = $efrom[2].'-'.$efrom[0].'-'.$efrom[1];
				$query->whereDate('created_at', '>=', $from);
			}
		} 
		
		if ($request->has('to')) 
		{	
			$search_term_to 		= 	$request->input('to');
			
			if(trim($search_term_to) != '')
			{
				$eto = explode('/',$search_term_to);
					$to = $eto[2].'-'.$eto[0].'-'.$eto[1];
				$query->whereDate('created_at', '<=', $to);
			}	
		}
		if ($request->has('from') && $request->has('to') ) 
		{
			$totalData 	= $query->count();
		}else{
			$query->whereDate('created_at',Carbon::today());
		}
		
		$b2clists		= $query->get();
		$b2blists = array();
	}
		return view('Agent.report.dailysale',compact(['b2clists','b2blists'])); 	
		
	} 
	public function ledger(Request $request)
	{  
		$lists = array();
		if ($request->has('ref')) {
			$query = WalletHistory::where('user_id',@Auth::user()->id)->where('id','!=','')->with(['user']);
			$ref 		= 	$request->input('ref');
			if(trim($ref) != '')
			{
				$query->where('reference_id', '=', $ref);
			}
			$totalData 	= @$query->count();
			$lists		= $query->get();
		}else if ($request->has('submission_start')) 
		{	
	//DB::enableQueryLog();
			$query = WalletHistory::where('user_id',@Auth::user()->id)->where('id','!=','')->with(['user']);
				
			if ($request->has('submission_start')) 
		{	
			$search_term_to 		= 	$request->input('submission_start');
			
			if(trim($search_term_to) != '')
			{
				$eto = explode('/',$search_term_to);
					$to = $eto[2].'-'.$eto[0].'-'.$eto[1];
				$query->whereDate('created_at', '>=', $to);
			}	
		}
		if ($request->has('submission_end')) 
		{	
			$search_term_from 		= 	$request->input('submission_end');
			
			if(trim($search_term_from) != '')
			{
				$eto = explode('/',$search_term_from);
					$to = $eto[2].'-'.$eto[0].'-'.$eto[1];
				$query->whereDate('created_at', '<=', $to);
			}	
		}
		$totalData 	= @$query->count();
		$lists		= $query->get();
		}
		
		
		

		//dd(DB::getQueryLog());
		if(@$request->type == 'excel'){
			if(@$totalData !== 0){
			 $filename = @$lists[0]->user->username; 
			$file_ending = "xls";
			 header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0"); 
			
			$sep = "\t";
			echo "Company Name \t".@$lists[0]->user->company_name;
			echo "\n";
			echo "Agent ID \t".@$lists[0]->user->username;
			echo "\n";
			
			echo "Date \t";
			echo "Ref Number \t";
			echo "Particulars \t";
			echo "Debit \t";
			echo "Credit \t";
			echo "Running balance \t";
			print("\n");
			$tbalance=0;
			foreach($lists as $li){
				$debit = 0;
				$credit = 0;
				echo date('d/m/Y', strtotime($li->created_at))."\t";
				echo $li->reference_id."\t";
				echo $li->remark."\t";
				if(@$li->type == 'debit'){ 
					$debit = @$li->amount;
					echo  @$li->amount."\t"; }else{ echo '0'."\t"; }
				if(@$li->type == 'credit'){ 
					$credit = @$li->amount;
					echo  @$li->amount."\t"; }else{ echo '0'."\t"; }
					$chkbala = $credit - $debit;  
					echo $tbalance += $chkbala;
					
			print "\n";
			}
			}else{
				return view('Agent.report.ledger',compact(['lists']));
			} 
			}else if(@$request->type == 'pdf'){
				if(@$totalData !== 0){
				$pdf = PDF::loadView('Agent.report.pdfledger', compact('lists'));
				
				$pdf->save(storage_path().'_filename.pdf');
				// Finally, you can download the file using download function
				return $pdf->download(@$lists[0]->user->username.'.pdf');
				}else{
				return view('Agent.report.ledger',compact(['lists']));
				} 
			}else if(@$request->type == 'print'){
				if(@$totalData !== 0){
				$pdf = PDF::loadView('Agent.report.pdfledger', compact('lists'));
				
				$pdf->save(storage_path().'_filename.pdf');
				// Finally, you can download the file using download function
				return $pdf->stream(@$lists[0]->user->username.'.pdf');
				}
			}else{
			return view('Agent.report.ledger',compact(['lists'])); 	
		}
	}
	    
}