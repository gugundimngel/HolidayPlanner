<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

use App\Subject;
use App\Test;
use App\ScheduledTest;
use App\TestSeriesLog;

use Auth;
use Config;

class LogTestSeriesController extends Controller
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
     * All Tests.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('LogTestSeries', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end		
		
		$query 		= TestSeriesLog::where('id', '!=', '');
		
		$totalData 	= $query->count();	//for all data

		$lists 	= 	$query->sortable(['id'=>'desc'])->paginate(config('constants.limit'));					
		
		return view('Admin.test_series_log.index',compact(['lists', 'totalData']));	
	}
}
