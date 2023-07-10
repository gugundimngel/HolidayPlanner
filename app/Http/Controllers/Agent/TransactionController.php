<?php
namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Agent;
use App\Wallet;
use App\WalletHistory;
use App\CreditLimitLog;
 
use Auth;  
use Config;

class TransactionController extends Controller
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
	
	public function index(Request $request){
		$where = '';
		if ($request->has('fromdate')) 
		{
			$search_term_from 		= 	$request->input('fromdate');
			if(trim($search_term_from) != '')
			{
				$search_term_from = date('Y-m-d', strtotime($search_term_from));
				$where .= " AND DATE(created_at) >= '$search_term_from'";
			}
		}
		if ($request->has('todate')) 
		{	
			$search_term_to 		= 	$request->input('todate');
			if(trim($search_term_to) != '')
			{
				$search_term_to = date('Y-m-d', strtotime($search_term_to));
				$where .= " AND DATE(created_at) <= '$search_term_to'";
			}	
		}
	
		$lists 		= DB::select("SELECT id, user_id, created_at, credit, debit, COALESCE(((SELECT SUM(credit) FROM wallet_histories b WHERE b.id <= a.id AND user_id = '".Auth::user()->id."') - (SELECT SUM(debit) FROM wallet_histories b WHERE b.id <= a.id AND user_id = '".Auth::user()->id."')), 0) as balance, remark,reference_id FROM wallet_histories a WHERE user_id = '".Auth::user()->id."' $where ORDER BY id DESC");
		
		return view('Agent.transactionlog.index',compact(['lists'])); 
	}
	
	public function excelReport(Request $request){
		$where = '';
		if ($request->has('fromdate')) 
		{
			$search_term_from 		= 	$request->input('fromdate');
			if(trim($search_term_from) != '')
			{
				$search_term_from = date('Y-m-d', strtotime($search_term_from));
				$where .= " AND DATE(created_at) >= '$search_term_from'";
			}
		}
		if ($request->has('todate')) 
		{	
			$search_term_to 		= 	$request->input('todate');
			if(trim($search_term_to) != '')
			{
				$search_term_to = date('Y-m-d', strtotime($search_term_to));
				$where .= " AND DATE(created_at) <= '$search_term_to'";
			}	
		}
	
		$lists 		= DB::select("SELECT id, user_id, created_at, credit, debit, COALESCE(((SELECT SUM(credit) FROM wallet_histories b WHERE b.id <= a.id AND user_id = '".Auth::user()->id."') - (SELECT SUM(debit) FROM wallet_histories b WHERE b.id <= a.id AND user_id = '".Auth::user()->id."')), 0) as balance, remark,reference_id FROM wallet_histories a WHERE user_id = '".Auth::user()->id."' $where ORDER BY id DESC");
		
		$finalexcel = array();
			$firstheading = array('Detail','Dr','Cr','Balance','Date');
			array_push($finalexcel,$firstheading);
		if(isset($lists)){
			foreach($lists as $lis){
				if($lis->remark == 'Generate Ticket'){
					$detail =  'Flight Booking (ID - '.$lis->reference_id.')';
				}else{
					$detail =  $lis->remark;
				}
				$exceldata = array($detail,$lis->credit,$lis->debit,$lis->balance,date('h:i A, d m Y', strtotime($lis->created_at)));
				array_push($finalexcel,$exceldata);
			}
			$this->exports_data($finalexcel,date('Y-m-d')."_Transaction_Report");
		}
		//return view('Agent.transactionlog.index',compact(['lists'])); 
	}
	
	public function credit_limit_log(Request $request){
		$query 		= CreditLimitLog::where('agent_id','=',Auth::user()->id );
		
		$totalData 	= $query->count();	//for all data

		$lists		= $query->orderby('created_at','DESC')->get(); 
		
		return view('Agent.wallet.limitlog',compact(['lists', 'totalData'])); 
	}
}
?>