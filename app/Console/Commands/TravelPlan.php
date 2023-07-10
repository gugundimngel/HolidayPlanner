<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Admin;
use App\TravelPlan;

use Config;
class TravelPlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TravelPlan:travelplan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User Name Change Successfully';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	public function handle()
    {
		$resu = $this->GetInsurancePlan();
		for($i = 0; $i<count($traveldata->pTrvCoverDtlsList_out); $i++){
			if(TravelPlan::where('name', @$resu->pTrvCoverDtlsList_out[$i]->pbenefits)->exists()){
				$dd = TravelPlan::where('name', @$resu->pTrvCoverDtlsList_out[$i]->pbenefits)->first();
				$travelplans = TravelPlan::find($dd->id);
				$travelplans->name = @$resu->pTrvCoverDtlsList_out[$i]->pbenefits;
				$travelplans->price = @$resu->pTrvCoverDtlsList_out[$i]->plimits;
				$travelplans->pdeductible = @$resu->pTrvCoverDtlsList_out[$i]->pdeductible;
				$save = $travelplans->save();
			}else{
				$travelplans = new TravelPlan;
				$travelplans->name = @$resu->pTrvCoverDtlsList_out[$i]->pbenefits;
				$travelplans->price = @$resu->pTrvCoverDtlsList_out[$i]->plimits;
				$travelplans->pdeductible = @$resu->pTrvCoverDtlsList_out[$i]->pdeductible;
				$save = $travelplans->save();
			}
		}
	}
	
	public static function GetInsurancePlan(){
		$url = "https://api.bagicpp.bajajallianz.com/BjazTravelWebServices/travelplan";
		$data = '{		
			  "auserId": "adminholy1@insurance.com",
			  "apassword": "Bagic123",
			  "aIntemdCode": "0",
			  "pDealerCode": "0",
			  "pIntermediaryList_out": [
				{
				  "pAgentCode": ""
				}
			  ],
			  "pTravelList_out": [
				{
				  "countPplan": "",
				  "pplan": ""
				}
			  ],
			  "pError_out": {
			   "errNumber": "",
				"parName": "",
				"property": "",
				"errText": "",
				"parIndex": "",
				"errLevel": ""
			  },
			  "pErrorCode_out": "0"
			}';
			
			$result = $this->postcurlRequest($url,$data); 
			$resultdata = json_decode($result);
			$urls = "https://api.bagicpp.bajajallianz.com/BjazTravelWebServices/getplandtls";
			$datas = '{
				  "pUserId": "adminholy1@insurance.com",
				  "apassword": "Bagic123",
				  "aPlanname": "'.$resultdata->pTravelList_out[0]->pplan.'",
				  "pTrvPlanDtlsList_out": [
					{
					 "maxAgeTo": "",
						"planname": "",
						"areaname": "",
						"minAgeFrom": "",
						"minDaysFrom":"",
						"extCol10": "",
						"maxDaysTo": "",
						"extCol9": "",
						"extCol8": "",
						"extCol7": "",
						"extCol6": "",
						"extCol5": "",
						"extCol4": "",
						"extCol3": "",
						"extCol2": "",
						"extCol1": ""
					}
				  ],
				  "pTrvCoverDtlsList_out": [
					{
					 "pbenefits": "",
						"pdeductible": "",
						 "plimits": ""
					}
				  ],
				  "pError_out": {
				   "errNumber": "",
					"parName": "",
					"property": "",
					"errText": "",
					"parIndex": "",
					"errLevel": ""
				  },
				  "pErrorCode_out": "0"
				}';
			$results = $this->postcurlRequest($urls,$datas); 
			$resultdatas = json_decode($results);
			return $resultdatas;
	}
	
	public static function postcurlRequest($url,$data){
       $ch = curl_init();
	   curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_ENCODING,  '');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$result = curl_exec($ch);
curl_close($ch);

        return $result;
    }
}