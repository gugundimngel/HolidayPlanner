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
 
use Auth;  
use Config;

class WalletController extends Controller
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
	
	public function RechargeHistory(Request $request) 
	{
		$query 		= Wallet::where('user_id','=',Auth::user()->id );
		
		$totalData 	= $query->count();	//for all data

		$lists		= $query->orderby('id','DESC')->get(); 
		
		return view('Agent.wallet.index',compact(['lists', 'totalData'])); 
	}
	
	public function Walletform(Request $request) 
	{
		
		return view('Agent.wallet.create');
	}
	
	public function Walletstore(Request $request) 
	{
		$requestdata 		= 	$request->all();
		$expdate = explode('/',@$requestdata['pay_date']);
		$wallet = new Wallet;
			$wallet->user_id = Auth::user()->id;
			$wallet->pay_mode = @$requestdata['pay_mode'];
			$wallet->amount = @$requestdata['amount'];
			$wallet->cheque_no = @$requestdata['cheque_no'];
			$wallet->pay_date = @$expdate[2].'-'.@$expdate[0].'-'.@$expdate[1];
			$wallet->bank_name = @$requestdata['bank_name'];
			$wallet->bank_branch = @$requestdata['bank_branch'];
			$wallet->bank_transaction_id = @$requestdata['bank_transaction_id'];
			$wallet->remarks = @$requestdata['remarks'];
			$saved = $wallet->save();
			if(!$saved) 
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{ 
				return Redirect::to('/agent/wallet')->with('success', 'Wallet requested Successfully');
			} 	 	
	}
	
	public function Crdrhistory(Request $request){
		$query 		= WalletHistory::where('user_id','=',Auth::user()->id );
		
		$totalData 	= $query->count();	//for all data

		$lists		= $query->orderby('created_at','DESC')->get(); 
		
		return view('Agent.wallet.crdr',compact(['lists', 'totalData'])); 
	}
}
?>