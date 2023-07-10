@extends('layouts.agentfrontend')
@section('title', @$seoDetails->meta_title)
@section('meta_title', '')
@section('meta_keyword', '')
@section('meta_description', '')
@section('bodyclass', 'homepage')
@section('content')
<style>

#myUL .coupon_li{display:none;}
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
button:disabled, button[disabled] {
    color: #666666;
    background-image: linear-gradient(to right, #93968d , #9a9e94)!important;
}
.flight-direction {
    border: 1px solid #e6e6e6;
    position: relative;
    margin-top: 15px;
    z-index: 9;
}
.flight-direction:before {
    background: #e6e6e6 none repeat scroll 0 0;
    border-radius: 50%;
    color: #0A3152;
    content: "";
    height: 15px;
    position: absolute;
    left: -5px;
    top: -7px;
    width: 15px;
}
.flight-direction:after {
    background: #e6e6e6 none repeat scroll 0 0;
    border-radius: 50%;
    color: #0A3152;
    content: "";
    height: 15px;
    position: absolute;
    right: -8px;
    top: -7px;
    width: 15px;
}
</style>

<section id="content">
<?php use App\Http\Controllers\Controller; ?>
<?php
$searchdata = Session::get('allrequest');
$mytravlercount = explode('-', $searchdata['px']);
$explodesearc = explode('|', $searchdata['srch']);
$originexplode = explode('-', $explodesearc[0]);
$desexplode = explode('-', $explodesearc[1]);
	$mtcount = 0;
	for($mit =0; $mit<count($mytravlercount); $mit++){
		$mtcount += $mytravlercount[$mit];
	}
	
	
?>
			<div id="content-wrap">
				<!-- === Section Flat =========== -->
				<div class="section-flat single_sec_flat booking_sec">      
					<div class="section-content">
						<div class="container">
						<?php if(isset($_GET['IsReturn'])){ ?>
						 {{ Form::open(array('url' => 'agent/Flight/payment', 'name'=>"frmProduct", 'autocomplete'=>'off', "enctype"=>"multipart/form-data", "id" => "frm_Product")) }}
						 <?php }else{
							 ?>
						 {{ Form::open(array('url' => 'agent/Flight/payment', 'name'=>"frmProduct", 'autocomplete'=>'off', "enctype"=>"multipart/form-data", "id" => "frm_Product")) }}
						  <?php
						 } ?>
						 <input id="hfTraceId" name="hfTraceId" type="hidden" value="{{@$_GET['tid']}}"> 
						 <?php
						 if($originexplode[2] == 'India' && $desexplode[2] == 'India'){
						$is_international = 2;
					}else{
						$is_international = 1;
					}
						 ?>
						  <input id="IsIntr" name="IsIntr" type="hidden" value="{{@$is_international}}"> 
						 <?php if(isset($_GET['IsReturn'])){ ?>
						 <input id="" name="hfIBRIndex" type="hidden" value="{{@$resultdataib[0]->ResultIndex}}"> 
						 <input id="" name="IsReturn" type="hidden" value="1"> 
						
						 <?php }else{
							 ?>
							 <input id="" name="IsReturn" type="hidden" value="0"> 
							 <?php
						 } ?>
						 <input id="" name="hfRIndex" type="hidden" value="{{@$resultdata[0]->ResultIndex}}"> 
						 <input id="" name="IsInt" type="hidden" value="{{@$is_international}}"> 
						 <input id="travlercount" name="travlercount" type="hidden" value="{{@$mtcount}}"> 
						 <input type="hidden" id="travelDate" name="travelDate" value="{{Session::get('from_date')}}"/>
							
							<div class="row">
								<div class="col-md-12">
									<div class="server-error"> 
										@include('../Elements/front-flash-message')
									</div>
								</div>
							</div> 
							<div class="row">
								<div class="col-md-9 col-sm-12">
										<div class="inner_booking">
										<div class="booking_title">
											<h3><img src="{!! asset('public/images/review.png') !!}" alt=""/> Review Your Booking</h3>
											<a class="change_flight" href="{{URL::to('/agent/FlightList/index')}}?srch={{$searchdata['srch']}}&px={{$searchdata['px']}}&cbn={{$searchdata['cbn']}}&nt={{$searchdata['nt']}}&jt={{$searchdata['jt']}}">Change Flight</a>
										</div>
									<div class="block-content-2 custom_block_content">
										<div class="box-result custom_box_result">
											<div class="flight_tags depart_tags">
												<span style="z-index: 999;">Departure</span>
											</div>	
											<?php 
											$aaircode = array();
											$aircode = array();
										if(isset($_GET['jt']) && $_GET['jt'] == 1){
											if(isset($resultdata[0]->Segments)){
												
													$segments = $resultdata[0]->Segments;
												
												foreach($segments as $slist){
													$ir = 0;
													$res = $resultdata[0];
												
														$countflighdata = count($slist); 
														$allflighdata = $slist;
											 for($fl =0;$fl<count($allflighdata);$fl++){ 
		
			
			if ($fl != 0){
			if ($fl == 1){
				//$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[0]->Destination->ArrTime));
			//	$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[0]->Origin->DepTime));
					$datetime1 =  new \DateTime($allflighdata[0]->Destination->ArrTime);
		$datetime2 =  new \DateTime($allflighdata[1]->Origin->DepTime);
		$interval = $datetime1->diff($datetime2);
				
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo $interval->format('%h')."h ".$interval->format('%i')."m"; ?></span></div>
				</div>
			<?php
			}
			else if ($fl == 2)
			{
				//$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[1]->Destination->ArrTime));
				//$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[2]->Origin->DepTime));
								$datetime1 =  new \DateTime($allflighdata[1]->Destination->ArrTime);
		$datetime2 =  new \DateTime($allflighdata[2]->Origin->DepTime);
		$interval = $datetime1->diff($datetime2);
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo $interval->format('%h')."h ".$interval->format('%i')."m"; ?></span></div>
				</div>
			<?php
			}else if ($fl == 3)
			{
				//$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[2]->Destination->ArrTime));
				//$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[3]->Origin->DepTime));
								$datetime1 =  new \DateTime($allflighdata[2]->Destination->ArrTime);
		$datetime2 =  new \DateTime($allflighdata[3]->Origin->DepTime);
		$interval = $datetime1->diff($datetime2);
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo $interval->format('%h')."h ".$interval->format('%i')."m"; ?></span></div>
				</div>
			<?php
			}
			}
		//}
		
		?>
											<ul class="list-search-result booking_list"> 
												<li class="flight_name"> 
													<img src="{{URL::to('/public/img/airline/')}}/{{$allflighdata[$fl]->Airline->AirlineCode}}.gif" alt="">
													<div class="name">@if($allflighdata[$fl]->Airline->AirlineCode == 'I5')
																		AirAsia 
																	@else
																	
																		{{$allflighdata[$fl]->Airline->AirlineName}}
																	@endif<span class="flight_no">{{$allflighdata[$fl]->Airline->AirlineCode}}-{{$allflighdata[$fl]->Airline->FlightNumber}}</span></div> 
												</li> 
												<li class="flight_time"> 
													{{$allflighdata[$fl]->Origin->Airport->CityName}}, {{$allflighdata[$fl]->Origin->Airport->CountryCode}} 
													<strong>{{date('H:i', strtotime($allflighdata[$fl]->Origin->DepTime))}}</strong>
													<span class="date">{{date('D, d M Y', strtotime($allflighdata[$fl]->Origin->DepTime))}}</span>
													<span class="airport"> {{$allflighdata[$fl]->Origin->Airport->AirportName}}  , Terminal {{$allflighdata[$fl]->Origin->Airport->Terminal}}</span>
												</li>
												<li class="flight_amenties">
													<div class="top"><span class="duration"><i class="fa fa-clock"></i> <?php
					
					 $datetime1 =  new \DateTime($allflighdata[$fl]->Origin->DepTime);
					$datetime2 =  new \DateTime($allflighdata[$fl]->Destination->ArrTime);
					$interval = $datetime1->diff($datetime2);
					$time2 = $interval->format('%h')."h ".$interval->format('%i')."m";
					echo $time2;
				?></span><span class="grey_rtbrder">|</span> <!--<span class="meal"> <i class="fa fa-utensils"></i>
													@if($resultdata[0]->Fare->TotalMealCharges == 0)
														Free Meal
													@else 
													Paid @endif</span><span class="grey_rtbrder">|</span> --><span class="economy">
													<?php if($allflighdata[$fl]->CabinClass == 2){ echo 'Economy'; }else if($allflighdata[$fl]->CabinClass == 3){ echo 'PremiumEconomy'; }else if($allflighdata[$fl]->CabinClass == 4){ echo 'Business'; }else if($allflighdata[$fl]->CabinClass == 4){ echo 'PremiumBusiness'; }else if($allflighdata[$fl]->CabinClass == 6){ echo 'First'; }else{ echo 'All'; } ?>
													</span></div> 
													<div class="middle"><span class="txt"><i class="fa fa-plane"></i> Flight</span></div>
													<div class="bottom"><span class="wght">{{$allflighdata[$fl]->Baggage}}</span><span class="grey_rtbrder">|</span><span class="refundable">
													<?php 
											if($resultdata[0]->IsRefundable){ 
												echo 'Refundable'; 
											}else{ echo 'Non Refundable'; } ?></span></div>
												</li>   
												<li class="flight_time">
													{{$allflighdata[$fl]->Destination->Airport->CityName}}, {{$allflighdata[$fl]->Destination->Airport->CountryCode}}
													<strong>{{date('H:i', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</strong>
													<span class="date">{{date('D, d M Y', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</span>
													<span class="airport"> {{$allflighdata[$fl]->Destination->Airport->AirportName}}, Terminal {{$allflighdata[$fl]->Destination->Airport->Terminal}}</span>
												</li> 												
											</ul><!-- .list-search-result end -->
											<div class="clearfix"></div>
											<?php 
											$lastdate = date('Y-m-d', strtotime($allflighdata[$fl]->Origin->DepTime));
											 ?> 
											<?php  } ?>
											<?php } ?>
											<?php }
											$LastSegmentDepartureDate = @$lastdate; 
										}else{
											if(isset($resultdata[0]->Segments)){
												if(isset($_GET['jt']) && $_GET['jt'] == 1){
													$segments = $resultdata[0]->Segments;
												}else{
													if(@$_GET['isINT'] == 'true'){
														$segments = $resultdata[0]->Segments[0];
													}else{
														$segments = $resultdata[0]->Segments;
													}
												}
												//foreach($segments as $slist){
													$ir = 0;
													$res = $resultdata[0];
													if(isset($_GET['jt']) && $_GET['jt'] == 1){
														$countflighdata = count($slist); 
														$allflighdata = $slist;
													}else{
														
														$countflighdata = count($res->Segments[0]); 
														$allflighdata = $res->Segments[0];
													}
													$aircode = array();
											 for($fl =0;$fl<count($allflighdata);$fl++){ 
											$aircode[] = $allflighdata[$fl]->Airline->AirlineCode;		
		
		if($res->IsLCC == 1){
		//echo $allflighdata[$fl]->GroundTime;
			if($allflighdata[$fl]->GroundTime != 0){
				$minutes = $allflighdata[$fl]->GroundTime;
				$hours = floor($minutes / 60);
				$min = $minutes - ($hours * 60);
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo @$hours.'h : '.@$min.'m'; ?></span></div>
				</div>
			<?php
			}
		}else{
			
			if ($fl != 0){
			if ($fl == 1){
				$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[0]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[1]->Origin->DepTime));
				$date1Timestamp = strtotime($arTime);
$date2Timestamp = strtotime($DepTime);
 $delta_T = ($date2Timestamp - $date1Timestamp);
//Calculate the difference.
$hours = round((($delta_T % 604800) % 86400) / 3600); 
$minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
				
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo @$hours.'h : '.@$minutes.'m'; ?></span></div>
				</div>
			<?php
			}
			else if ($fl == 2)
			{
				$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[1]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[2]->Origin->DepTime));
								$date1Timestamp = strtotime($arTime);
$date2Timestamp = strtotime($DepTime);
 $delta_T = ($date2Timestamp - $date1Timestamp);
//Calculate the difference.
$hours = round((($delta_T % 604800) % 86400) / 3600); 
$minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo @$hours.'h : '.@$minutes.'m'; ?></span></div>
				</div>
			<?php
			}else if ($fl == 3)
			{
				$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[2]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[3]->Origin->DepTime));
								$date1Timestamp = strtotime($arTime);
$date2Timestamp = strtotime($DepTime);
 $delta_T = ($date2Timestamp - $date1Timestamp);
//Calculate the difference.
$hours = round((($delta_T % 604800) % 86400) / 3600); 
$minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo @$hours.'h : '.@$minutes.'m'; ?></span></div>
				</div>
			<?php
			}
			}
		}
		
		?>
											<ul class="list-search-result booking_list"> 
												<li class="flight_name"> 
													<img src="{{URL::to('/public/img/airline/')}}/{{$allflighdata[$fl]->Airline->AirlineCode}}.gif" alt="">
													<div class="name">@if($allflighdata[$fl]->Airline->AirlineCode == 'I5')
																		AirAsia 
																	@else
																	
																		{{$allflighdata[$fl]->Airline->AirlineName}}
																	@endif<span class="flight_no">{{$allflighdata[$fl]->Airline->AirlineCode}}-{{$allflighdata[$fl]->Airline->FlightNumber}}</span></div> 
												</li> 
												<li class="flight_time"> 
													{{$allflighdata[$fl]->Origin->Airport->CityName}}, {{$allflighdata[$fl]->Origin->Airport->CountryCode}} 
													<strong>{{date('H:i', strtotime($allflighdata[$fl]->Origin->DepTime))}}</strong>
													<span class="date">{{date('D, d M Y', strtotime($allflighdata[$fl]->Origin->DepTime))}}</span>
													<span class="airport"> {{$allflighdata[$fl]->Origin->Airport->AirportName}}  , Terminal {{$allflighdata[$fl]->Origin->Airport->Terminal}}</span>
												</li>
												<li class="flight_amenties">
													<div class="top"><span class="duration"><i class="fa fa-clock"></i><?php
					
					 $datetime1 =  new \DateTime($allflighdata[$fl]->Origin->DepTime);
					$datetime2 =  new \DateTime($allflighdata[$fl]->Destination->ArrTime);
					$interval = $datetime1->diff($datetime2);
					$time2 = $interval->format('%h')."h ".$interval->format('%i')."m";
					echo $time2;
				?></span><span class="grey_rtbrder">|</span> <!--<span class="meal"> <i class="fa fa-utensils"></i>
													@if($resultdata[0]->Fare->TotalMealCharges == 0)
														Free Meal
													@else 
													Paid @endif</span><span class="grey_rtbrder">|</span> --><span class="economy">
													<?php if($allflighdata[$fl]->CabinClass == 2){ echo 'Economy'; }else if($allflighdata[$fl]->CabinClass == 3){ echo 'PremiumEconomy'; }else if($allflighdata[$fl]->CabinClass == 4){ echo 'Business'; }else if($allflighdata[$fl]->CabinClass == 4){ echo 'PremiumBusiness'; }else if($allflighdata[$fl]->CabinClass == 6){ echo 'First'; }else{ echo 'All'; } ?>
													</span></div> 
													<div class="middle"><span class="txt"><i class="fa fa-plane"></i> Flight</span></div>
													<div class="bottom"><span class="wght">{{$allflighdata[$fl]->Baggage}}</span><span class="grey_rtbrder">|</span><span class="refundable">
													<?php 
											if($resultdata[0]->IsRefundable){ 
												echo 'Refundable'; 
											}else{ echo 'Non Refundable'; } ?></span></div>
												</li>   
												<li class="flight_time">
													{{$allflighdata[$fl]->Destination->Airport->CityName}}, {{$allflighdata[$fl]->Destination->Airport->CountryCode}}
													<strong>{{date('H:i', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</strong>
													<span class="date">{{date('D, d M Y', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</span>
													<span class="airport"> {{$allflighdata[$fl]->Destination->Airport->AirportName}}, Terminal {{$allflighdata[$fl]->Destination->Airport->Terminal}}</span>
												</li> 												
											</ul><!-- .list-search-result end -->
											<div class="clearfix"></div>
											<?php
											$lastdate = date('Y-m-d', strtotime($allflighdata[$fl]->Origin->DepTime));
											?>
											<?php  } ?>
											<?php //} ?>
											<?php } } 
											$LastSegmentDepartureDate = @$lastdate;
											?>
											
											
										</div><!-- .box-result end -->
										<?php 
										if(@$_GET['isINT'] == 'true'){
											?>
											<hr class="hr_seperator" />
											<div class="box-result custom_box_result">
												<div class="flight_tags return_tags">
													<span>Return</span>
												</div>	
												<?php 
											if(isset($resultdata[0]->Segments[1])){
												$ir = 0;
											$res = $resultdata[0];
											
												$countflighdata = count($res->Segments[1]); 
												$allflighdata = $res->Segments[1];
												
											?>
											
											<!--<div class="total_time">
												<span>Total Time: 2h 10m</span>
											</div>-->
											<?php
$aaircode = array();
											for($fl =0;$fl<count($allflighdata);$fl++){ 
											$aaircode[] = $allflighdata[$fl]->Airline->AirlineCode;
	
			if ($fl != 0){
			if ($fl == 1){
	//$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[0]->Destination->ArrTime));
			//	$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[1]->Origin->DepTime));
				$datetime1 =  new \DateTime($allflighdata[0]->Destination->ArrTime);
		$datetime2 =  new \DateTime($allflighdata[1]->Origin->DepTime);
		$interval = $datetime1->diff($datetime2);
				
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo $interval->format('%h')."h ".$interval->format('%i')."m"; ?></span></div>
				</div>
			<?php
			}
			else if ($fl == 2)
			{
				//$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[1]->Destination->ArrTime));
			//	$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[2]->Origin->DepTime));
								$datetime1 =  new \DateTime($allflighdata[1]->Destination->ArrTime);
		$datetime2 =  new \DateTime($allflighdata[2]->Origin->DepTime);
		$interval = $datetime1->diff($datetime2);
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo $interval->format('%h')."h ".$interval->format('%i')."m"; ?></span></div>
				</div>
			<?php
			}else if ($fl == 3)
			{
				$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[2]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[3]->Origin->DepTime));
									$datetime1 =  new \DateTime($allflighdata[2]->Destination->ArrTime);
		$datetime2 =  new \DateTime($allflighdata[3]->Origin->DepTime);
		$interval = $datetime1->diff($datetime2);
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo $interval->format('%h')."h ".$interval->format('%i')."m"; ?></span></div>
				</div>
			<?php
			}
			}
		//}
		
		?>	
											<ul class="list-search-result booking_list"> 
												<li class="flight_name"> 
													<img src="{{URL::to('/public/img/airline/')}}/{{$allflighdata[$fl]->Airline->AirlineCode}}.gif" alt="">
													<div class="name">@if($allflighdata[$fl]->Airline->AirlineCode == 'I5')
																		AirAsia 
																	@else
																	
																		{{$allflighdata[$fl]->Airline->AirlineName}}
																	@endif<span class="flight_no">{{$allflighdata[$fl]->Airline->AirlineCode}}-{{$allflighdata[$fl]->Airline->FlightNumber}}</span></div> 
												</li> 
												<li class="flight_time"> 
													{{$allflighdata[$fl]->Origin->Airport->CityName}}, {{$allflighdata[$fl]->Origin->Airport->CountryCode}} 
													<strong>{{date('H:i', strtotime($allflighdata[$fl]->Origin->DepTime))}}</strong>
													<span class="date">{{date('D, d M Y', strtotime($allflighdata[$fl]->Origin->DepTime))}}</span>
													<span class="airport"> {{$allflighdata[$fl]->Origin->Airport->AirportName}}  , Terminal {{$allflighdata[$fl]->Origin->Airport->Terminal}}</span>
												</li>
												<li class="flight_amenties">
													<div class="top"><span class="duration"><i class="fa fa-clock"></i> <?php
					
					 $datetime1 =  new \DateTime($allflighdata[$fl]->Origin->DepTime);
					$datetime2 =  new \DateTime($allflighdata[$fl]->Destination->ArrTime);
					$interval = $datetime1->diff($datetime2);
					$time2 = $interval->format('%h')."h ".$interval->format('%i')."m";
					echo $time2;
				?></span><span class="grey_rtbrder">|</span> <!--<span class="meal"> <i class="fa fa-utensils"></i>
													@if($resultdata[0]->Fare->TotalMealCharges == 0)
														Free Meal
													@else 
													Paoid @endif</span><span class="grey_rtbrder">|</span> --><span class="economy">
													<?php if($allflighdata[$fl]->CabinClass == 2){ echo 'Economy'; }else if($allflighdata[$fl]->CabinClass == 3){ echo 'PremiumEconomy'; }else if($allflighdata[$fl]->CabinClass == 4){ echo 'Business'; }else if($allflighdata[$fl]->CabinClass == 4){ echo 'PremiumBusiness'; }else if($allflighdata[$fl]->CabinClass == 6){ echo 'First'; }else{ echo 'All'; } ?>
													</span></div> 
													<div class="middle"><span class="txt"><i class="fa fa-plane"></i> Flight</span></div>
													<div class="bottom"><span class="wght">{{$allflighdata[$fl]->Baggage}}</span><span class="grey_rtbrder">|</span><span class="refundable">
													<?php 
											if($resultdata[0]->IsRefundable){ 
												echo 'Refundable'; 
											}else{ echo 'Non Refundable'; } ?></span></div>
												</li>   
												<li class="flight_time">
													{{$allflighdata[$fl]->Destination->Airport->CityName}}, {{$allflighdata[$fl]->Destination->Airport->CountryCode}}
													<strong>{{date('H:i', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</strong>
													<span class="date">{{date('D, d M Y', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</span>
													<span class="airport"> {{$allflighdata[$fl]->Destination->Airport->AirportName}}, Terminal {{$allflighdata[$fl]->Destination->Airport->Terminal}}</span>
												</li> 												
											</ul><!-- .list-search-result end -->
											<div class="clearfix"></div>
											
											<?php 
											$lastdate = date('Y-m-d', strtotime($allflighdata[$fl]->Origin->DepTime));
											} ?>
											<?php } ?>
											</div>
											<?php
											$LastSegmentDepartureDate = @$lastdate;
										}else{
										$is_return = 0;
										if(!empty($resultdataib)){ if(isset($resultdataib[0]->Segments[0])){ 
											$is_return = 1;
											$resarrive = $resultdataib[0];
										
												$arriveflighdata = $resarrive->Segments[0];
										?>
										<hr class="hr_seperator" />
										  
										<div class="box-result custom_box_result">
											<div class="flight_tags return_tags">
												<span>Return</span>
											</div>	
											<!--<div class="total_time">
												<span>Total Time: 2h 10m</span>
											</div>-->
											<?php 
											/* echo '<pre>'; print_r($arriveflighdata);
											die; */
											$aaircode = array();
											for($fla =0;$fla<count($arriveflighdata);$fla++){ 
											$aaircode[] = $arriveflighdata[$fla]->Airline->AirlineCode;
		if($resarrive->IsLCC == 1){
		//echo $allflighdata[$fl]->GroundTime;
			if($arriveflighdata[$fla]->GroundTime != 0){
				$minutes = $arriveflighdata[$fla]->GroundTime;
				$hours = floor($minutes / 60);
				$min = $minutes - ($hours * 60);
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo @$hours.'h : '.@$min.'m'; ?></span></div>
				</div>
			<?php
			}
		}else{
			
			if ($fla != 0){
			if ($fla == 1){
				$arTime = date('Y-m-d h:i:s a', strtotime($arriveflighdata[0]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($arriveflighdata[1]->Origin->DepTime));
				$date1Timestamp = strtotime($arTime);
$date2Timestamp = strtotime($DepTime);
 $delta_T = ($date2Timestamp - $date1Timestamp);
//Calculate the difference.
$hours = round((($delta_T % 604800) % 86400) / 3600); 
$minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
				
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo @$hours.'h : '.@$minutes.'m'; ?></span></div>
				</div>
			<?php
			}
			else if ($fla == 2)
			{
				$arTime = date('Y-m-d h:i:s a', strtotime($arriveflighdata[1]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($arriveflighdata[2]->Origin->DepTime));
								$date1Timestamp = strtotime($arTime);
$date2Timestamp = strtotime($DepTime);
 $delta_T = ($date2Timestamp - $date1Timestamp);
//Calculate the difference.
$hours = round((($delta_T % 604800) % 86400) / 3600); 
$minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo @$hours.'h : '.@$minutes.'m'; ?></span></div>
				</div>
			<?php
			}else if ($fla == 3)
			{
				$arTime = date('Y-m-d h:i:s a', strtotime($arriveflighdata[2]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($arriveflighdata[3]->Origin->DepTime));
								$date1Timestamp = strtotime($arTime);
$date2Timestamp = strtotime($DepTime);
 $delta_T = ($date2Timestamp - $date1Timestamp);
//Calculate the difference.
$hours = round((($delta_T % 604800) % 86400) / 3600); 
$minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo @$hours.'h : '.@$minutes.'m'; ?></span></div>
				</div>
			<?php
			}
			}
		}
		
		?>	
											<ul class="list-search-result booking_list"> 
												<li class="flight_name"> 
													<img src="{{URL::to('/public/img/airline/')}}/{{$arriveflighdata[$fla]->Airline->AirlineCode}}.gif" alt="">
<div class="name">@if($arriveflighdata[$fla]->Airline->AirlineCode == 'I5')
			AirAsia 
		@else
		
			{{$arriveflighdata[$fla]->Airline->AirlineName}}
		@endif<span class="flight_no">{{$arriveflighdata[$fla]->Airline->AirlineCode}}-{{$arriveflighdata[$fla]->Airline->FlightNumber}}</span></div> 
												</li> 
	<li class="flight_time"> 
		{{$arriveflighdata[$fla]->Origin->Airport->CityName}}, {{$arriveflighdata[$fla]->Origin->Airport->CountryCode}} 
		<strong>{{date('H:i', strtotime($arriveflighdata[$fla]->Origin->DepTime))}}</strong>
		<span class="date">{{date('D, d M Y', strtotime($arriveflighdata[$fla]->Origin->DepTime))}}</span>
		<span class="airport"> {{$arriveflighdata[$fla]->Origin->Airport->AirportName}}  , Terminal {{$arriveflighdata[$fla]->Origin->Airport->Terminal}}</span>
	</li>
												<li class="flight_amenties">
													<div class="top"><span class="duration"><i class="fa fa-clock"></i> <?php
					
					 $datetime1 =  new \DateTime($arriveflighdata[$fla]->Origin->DepTime);
					$datetime2 =  new \DateTime($arriveflighdata[$fla]->Destination->ArrTime);
					$interval = $datetime1->diff($datetime2);
					$time2 = $interval->format('%h')."h ".$interval->format('%i')."m";
					echo $time2;
				?></span><span class="grey_rtbrder">|</span> <!--<span class="meal"><i class="fa fa-utensils"></i> @if($resultdataib[0]->Fare->TotalMealCharges == 0)
														Free Meal
													@else 
													Paoid @endif</span><span class="grey_rtbrder">|</span>--> <span class="economy">Economy</span></div> 
													<div class="middle"><span class="txt"><i class="fa fa-plane"></i> Flight</span></div>
													<div class="bottom"><span class="wght">{{$arriveflighdata[$fla]->Baggage}}</span><span class="grey_rtbrder">|</span><span class="refundable"><?php
													if($resultdataib[0]->IsRefundable){ 
												echo 'Refundable'; 
											}else{ echo 'Non Refundable'; }
													?></span></div>
												</li>    
												<li class="flight_time">
													{{$arriveflighdata[$fla]->Destination->Airport->CityName}}, {{$arriveflighdata[$fla]->Destination->Airport->CountryCode}}
													<strong>{{date('H:i', strtotime($arriveflighdata[$fla]->Destination->ArrTime))}}</strong>
													<span class="date">{{date('D, d M Y', strtotime($arriveflighdata[$fla]->Destination->ArrTime))}}</span>
													<span class="airport"> {{$arriveflighdata[$fla]->Destination->Airport->AirportName}}, Terminal {{$arriveflighdata[$fla]->Destination->Airport->Terminal}}</span>
												</li> 												
											</ul><!-- .list-search-result end -->
											<div class="clearfix"></div>
											<?php 
											$lastdate = date('Y-m-d', strtotime($arriveflighdata[$fla]->Origin->DepTime));
											 ?> 
											<?php } ?>
										</div><!-- .box-result end -->
										<?php } } } 
										$LastSegmentDepartureDate = @$lastdate;
										?>
										
									</div><!-- .block-content-2 end -->
								
									
									
										<div class="block-content-2 custom_block_content contact_detail">
											<div class="box-result custom_box_result">
												<div class="col-sm-2 contact_label cus_label">Contact Details</div>
												<div class="col-sm-10">
													<div class="form_field"><input data-valid="required" value=""  type="email" name="email" placeholder="Email ID" class="form-control" /></div>
													<div class="form_field country_field"><div class="country_code"><input class="" id="telephone" type="tel" name="telephone" readonly ></div><div class="mobile_no"><input data-valid="required minlength7 maxlength15" value=""  id="phone" name="phone" type="tel" placeholder="Mobile Number" class="form-control"/></div></div>
													<p>Your booking details will be sent to this email address and mobile number.</p>
													
												</div>   
												<div class="clearfix"></div>
												<div class="traveller_info">
													<h4>Traveller Information</h4>
													<div class="note"><span>Important Note:</span> Please ensure that the names of the passengers on the travel documents is the same as on their government issued identity proof.</div>
													<?php 
													 $hfInfantCount = 0;
													$hfChildCount = 0;
													$hfAdultCount = 0;
														$farebrakdowna = $res->FareBreakdown;
														$person = 0;
														//echo '<pre>'; print_r($farebrakdowna); die;
														
														for($ic=0;$ic < count($farebrakdowna); $ic++){
															if($farebrakdowna[$ic]->PassengerType != 3){
															$person += $farebrakdowna[$ic]->PassengerCount;
															}
															if($farebrakdowna[$ic]->PassengerType == 1){ $hfAdultCount = $farebrakdowna[$ic]->PassengerCount;
																}else if($farebrakdowna[$ic]->PassengerType == 2){ $hfChildCount= $farebrakdowna[$ic]->PassengerCount;
																}else{ $hfInfantCount= $farebrakdowna[$ic]->PassengerCount; }
															
															$jss = 0;
															for($ics=1;$ics <= $farebrakdowna[$ic]->PassengerCount; $ics++){
																
																
													?>
													<div class="row">
													<div class="col-sm-12">
														<h6>Passenger {{$ics}} - <?php if($farebrakdowna[$ic]->PassengerType == 1){ echo '(Adults'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo '(Child'; }else{ echo '(Infant'; } ?> {{$ics}})</h6>
													<div class="col-sm-2 contact_label cus_label"></div>
													<div class="col-sm-10">
														<div class="form_field form_select_field">
															<select id="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'ddlAdultTitle'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'ddlChildTitle'.$jss; }else{ echo 'ddlInfantTitle'.$jss; } ?>" data-valid="required" class="form-control" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adulttitle[]'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childtitle[]'; }else{ echo 'infanttitle[]'; } ?>">
																<option value="">Title</option>
																<?php if($farebrakdowna[$ic]->PassengerType == 1){
																	?>
																	<option selected value="Mr">Mr.</option>
																<option value="Mrs">Mrs.</option>
																
																	<?php
																	}else{ ?>
																	<option selected value="Miss">Miss</option>
																<option value="Mstr">Master</option>
																	<?php } ?>
																
															</select>
															
															<input id="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'txtAdultFName'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'txtChildFName'.$jss; }else{ echo 'txtInfantFName'.$jss; } ?>" onkeypress="return /[a-z]/i.test(event.key)" data-valid="required letteronly minlength1 maxlength32" type="text" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultfirstname[]'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childfirstname[]'; }else{ echo 'infantfirstname[]'; } ?>" placeholder="First Name" class="form-control <?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'firstname'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'firstname'; }else{ echo 'firstname'; } ?>" />
														</div>
														<div class="form_field">
															<input id="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'txtAdultLName'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'txtChildLName'.$jss; }else{ echo 'txtInfantLName'.$jss; } ?>" onkeypress="return /[a-z]/i.test(event.key)" data-valid="required letteronly minlength2 maxlength32" data-valid="required" type="text" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultlastname[]'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childlastname[]'; }else{ echo 'infantlastname[]'; } ?>" placeholder="Last Name" class="form-control <?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'lastname'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'lastname'; }else{ echo 'lastname'; } ?>" />
															<input type="hidden" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultseataddons[]'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childseataddons[]'; }else{ echo 'infantseataddons[]'; } ?>" class="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'atxtAdultLName'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'atxtChildLName'.$jss; }else{ echo 'atxtInfantLName'.$jss; } ?>">
															<input type="hidden" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultmealaddons[]'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childmealaddons[]'; }else{ echo 'infantmealaddons[]'; } ?>" class="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'btxtAdultLName'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'btxtChildLName'.$jss; }else{ echo 'btxtInfantLName'.$jss; } ?>">
															<input type="hidden" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultbagaddons[]'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childbagaddons[]'; }else{ echo 'infantbagaddons[]'; } ?>" class="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'ctxtAdultLName'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'ctxtChildLName'.$jss; }else{ echo 'ctxtInfantLName'.$jss; } ?>">
														</div> 
														<?php if($farebrakdowna[$ic]->PassengerType == 1){
															$arraymerge = array_merge($aircode, $aaircode);
															//print_r($arraymerge);
									if(in_array('I5', $arraymerge) || $is_international == 1){
															?>
															<div class="form_field">
					<input id="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'txtDOBAdult'.$jss; } ?>" data-valid="required <?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultdob'; } ?>" type="text" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultdob[]'; } ?>" placeholder="Date of Birth" class="form-control <?php if($farebrakdowna[$ic]->PassengerType == 1){ ?>datepicker-adulttime-start<?php } ?>" />
														</div> 
															<?php
									}
														}else{
															?>
														
														<div class="form_field">
					<input id="<?php if($farebrakdowna[$ic]->PassengerType == 2){ echo 'txtDOBChild'.$jss; }else{ echo 'txtDOBInfant'.$jss; } ?>" data-valid="required <?php if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childdob'; }else if($farebrakdowna[$ic]->PassengerType == 3){ echo 'infantdob'; } ?>" type="text" name="<?php if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childdob[]'; }else{ echo 'infantdob[]'; } ?>" placeholder="Date of Birth" class="form-control <?php  if($farebrakdowna[$ic]->PassengerType == 2){?>datepicker-child-time-start<?php }else if($farebrakdowna[$ic]->PassengerType == 3){ ?>datepicker-infant-time-start<?php } ?>" />
														</div> 
														<?php } ?>
													</div>
			<?php if($farebrakdowna[$ic]->PassengerType == 3){ ?>
				<div style="color: #ff0000;">Baggage OR Meal Preference is not available for Infant.</div>
			<?php
			}else{ ?>										
			<div class="col-md-12 addonspassenger">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p>Add-ons (Optional)</p>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="seatloader">
							<img src="{{URL::to('/')}}/public/img/loader2.gif" alt=""/>
						</div>
						<div class="ssrloadershow" style="display:none;">
							<a href="javascript:;" style="padding:5px 10px;" class="btn btn-primary btn-sm showmeals" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'mealBoxAdult'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'mealBoxChild'.$jss; }else{ echo ''; } ?>"><i class="fa fa-hamburger"></i>&nbsp;Add Meal</a>
							<a href="javascript:;" style="padding:5px 10px;" class="btn btn-primary btn-sm showbags" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'baggageBoxAdult'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'baggageBoxChild'.$jss; }else{ echo ''; } ?>"><i class="fa fa-luggage-cart"></i>&nbsp; Add Baggage</a>
						</div>
					</div>
				</div>
			</div>
			<div class="service_req_sec service_req_sec_nseat meal_info" id="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'mealBoxAdult'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'mealBoxChild'.$jss; }else{ echo ''; } ?>" style="display:none;">
				<ul class="nav nav-tabs custom_tabs">
				<?php
					if(isset($resultdata[0]->Segments[0])){ 
						$res = $resultdata[0];
					$allflighdata = $res->Segments[0];
					
					for($fl =0;$fl<count($allflighdata);$fl++){	
					?>
					<li class="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'mypasadult-'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'mypaschild-'.$jss; }else{ echo ''; } ?> <?php if($fl == 0){ echo 'active';}?> countdepvalue"><a href="#<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'pasadult-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'paschild-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else{ echo ''; } ?>" aria-controls="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'pasadult-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'paschild-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else{ echo ''; } ?>" role="tab" data-toggle="tab">{{$allflighdata[$fl]->Origin->Airport->CityCode}} - {{$allflighdata[$fl]->Destination->Airport->CityCode}}</a></li>
						<input type="hidden" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'mealadult[]'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'mealchild[]'; }else{ echo ''; } ?>" value="{{$allflighdata[$fl]->Origin->Airport->CityCode}}-{{$allflighdata[$fl]->Destination->Airport->CityCode}}">
					<?php } ?>
					<?php } 
					if(!empty($resultdataib) && isset($resultdataib[0]->Segments[0])){ 
					$res = $resultdataib[0];
					$allflighdata = $res->Segments[0];
				
					for($fl =0;$fl<count($allflighdata);$fl++){	
					?>
					<li class="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'mypasadult-'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'mypaschild-'.$jss; }else{ echo ''; } ?> countdepvalue"><a href="#<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'pasadult-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'paschild-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else{ echo ''; } ?>" aria-controls="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'pasadult-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'paschild-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else{ echo ''; } ?>" role="tab" data-toggle="tab">{{$allflighdata[$fl]->Origin->Airport->CityCode}} - {{$allflighdata[$fl]->Destination->Airport->CityCode}}</a></li>
						<input type="hidden" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'mealadult[]'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'mealchild[]'; }else{ echo ''; } ?>" value="{{$allflighdata[$fl]->Origin->Airport->CityCode}}-{{$allflighdata[$fl]->Destination->Airport->CityCode}}">
					<?php } ?>
					<?php } ?>
				</ul>
				<div class="tab-content">
					<?php if(isset($resultdata[0]->Segments[0])){ 
					
					$res = $resultdata[0];
					$allflighdata = $res->Segments[0];					
					for($fl =0;$fl<count($allflighdata);$fl++){
				?>	
					<div role="tabpanel" class="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'mydpasadult-'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'mydpaschild-'.$jss; }else{ echo ''; } ?> tab-pane <?php if($fl == 0){ echo 'active';}?>" id="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'pasadult-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'paschild-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else{ echo ''; } ?>">
							<div class="meals_list service_req_list dep_meal_sele">
							<ul id="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultmeal_'.$jss.'_'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childmeal_'.$jss.'_'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else{ echo 'infantmeal_'.$jss; } ?>" class="b_{{$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode}}" vclass="{{$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode}}">   
								
							</ul> 
							<div class="clearfix"></div>
						</div>
						<span class="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultmeal_'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childmeal_'.$jss; }else{ echo 'infantmeal_'.$jss; } ?> mealdetail" style="display:none;">
						<kbd>Meal Qunatity : <code style="float:none;" class="mealwth">0</code> Platter</kbd>
						<kbd>Meal Charges : <em>Rs.</em> <code style="float:none;" class="mealcharges">0</code>
						</kbd>
						</span>						
					</div>
					<?php } ?>
				
					<?php } ?>
					
					<?php if(!empty($resultdataib) && isset($resultdataib[0]->Segments[0])){ 
					$res = $resultdataib[0];
					$allflighdata = $res->Segments[0];		
					for($fl =0;$fl<count($allflighdata);$fl++){
				?>	
					<div role="tabpanel" class="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'mydpasadult-'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'mydpaschild-'.$jss; }else{ echo ''; } ?> tab-pane " id="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'pasadult-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'paschild-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else{ echo ''; } ?>">
							<div class="retmeals_list service_req_list dep_meal_sele">
							<ul id="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'returnadultmeal_'.$jss.'_'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'returnchildmeal_'.$jss.'_'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else{ echo 'returninfantmeal_'.$jss; } ?>" class="b_{{$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode}}" vclass="{{$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode}}">   
								
							</ul> 
							<div class="clearfix"></div>
						</div>
						<span class="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'returnadultmeal_'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'returnchildmeal_'.$jss; }else{ echo 'returninfantmeal_'.$jss; } ?> mealdetail" style="display:none;">
						<kbd>Meal Qunatity : <code style="float:none;" class="mealwth">0</code> Platter</kbd>
						<kbd>Meal Charges : <em>Rs.</em> <code style="float:none;" class="mealcharges">0</code>
						</kbd>
						</span>						
					</div>
					<?php } ?>
					<?php } ?>
					<input type="hidden" value="0" class="mealcount">
			</div>
			</div>
			
			<div class="service_req_sec service_req_sec_nseat baggage_info" id="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'baggageBoxAdult'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'baggageBoxChild'.$jss; }else{ echo ''; } ?>" style="display:none;">
				<ul class="nav nav-tabs custom_tabs">
				<?php
				if(isset($resultdata[0]->Segments[0])){ 
					
					$res = $resultdata[0];
					$allflighdata = $res->Segments[0];
				$fl = 0;
					//for($fl =0;$fl<count($allflighdata);$fl++){	
				?>
					<li class="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'mybagpasadult-'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'mybagpaschild-'.$jss; }else{ echo ''; } ?> <?php if($fl == 0){ echo 'active';}?> countdepvalue"><a href="#<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'bagpasadult-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'bagpaschild-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else{ echo ''; } ?>" aria-controls="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'bagpasadult-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'bagpaschild-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else{ echo ''; } ?>" role="tab" data-toggle="tab">{{$allflighdata[$fl]->Origin->Airport->CityCode}} - {{$allflighdata[$fl]->Destination->Airport->CityCode}}</a></li>
					<?php } 
					if(!empty($resultdataib) && isset($resultdataib[0]->Segments[0])){ 
					$res = $resultdataib[0];
					$allflighdata = $res->Segments[0];
					$fl = 0;
					//for($fl =0;$fl<count($allflighdata);$fl++){	
					?>
					<li class="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'mybagpasadult-'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'mybagpaschild-'.$jss; }else{ echo ''; } ?> countdepvalue"><a href="#<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'bagpasadult-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'bagpaschild-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else{ echo ''; } ?>" aria-controls="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'bagpasadult-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'bagpaschild-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else{ echo ''; } ?>" role="tab" data-toggle="tab">{{$allflighdata[$fl]->Origin->Airport->CityCode}} - {{$allflighdata[$fl]->Destination->Airport->CityCode}}</a></li>
						
					<?php //} ?>
					<?php } ?>
				</ul>
				<div class="tab-content">
				<?php if(isset($resultdata[0]->Segments[0])){ 
					$res = $resultdata[0];
					$allflighdata = $res->Segments[0];		
					$fl=0;
					//for($fl =0;$fl<count($allflighdata);$fl++){
				?>	
					<div role="tabpanel" class="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'mydbagpasadult-'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'mydbagpaschild-'.$jss; }else{ echo ''; } ?> tab-pane active" id="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'bagpasadult-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'bagpaschild-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else{ echo ''; } ?>">
					
							<div class="baggage_list service_req_list dep_baggage_sele">
								<ul id="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultbaggage_'.$jss.'_'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childbaggage_'.$jss.'_'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else{ echo ''.$jss; } ?>">   
								
							</ul> 
								<div class="clearfix"></div>
								<span class="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultbaggage_'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childbaggage_'.$jss; }else{ echo ''.$jss; } ?> mealdetail" style="display:none;">
								
								<kbd>Baggage Weight : <code style="float:none;" class="bagwth">0</code> Kg</kbd>
								<kbd>Baggage Charges : <em>Rs.</em> <code style="float:none;" class="bagcharges">0</code>
								</kbd>
							</span>
							</div>	
							
					</div>
					<?php } 
					if(!empty($resultdataib) && isset($resultdataib[0]->Segments[0])){ 
					$res = $resultdataib[0];
					$allflighdata = $res->Segments[0];
					$fl = 0;
					?>
					<div role="tabpanel" class="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'mydbagpasadult-'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'mydbagpaschild-'.$jss; }else{ echo ''; } ?> tab-pane " id="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'bagpasadult-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'bagpaschild-'.$jss.'-'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else{ echo ''; } ?>">
					
							<div class="baggage_list service_req_list dep_baggage_sele">
								<ul id="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'returnadultbaggage_'.$jss.'_'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'returnchildbaggage_'.$jss.'_'.$allflighdata[$fl]->Origin->Airport->CityCode.'-'.$allflighdata[$fl]->Destination->Airport->CityCode; }else{ echo ''.$jss; } ?>">   
								
							</ul> 
								<div class="clearfix"></div>
								<span class="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'returnadultbaggage_'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'returnchildbaggage_'.$jss; }else{ echo ''.$jss; } ?> mealdetail" style="display:none;">
								
								<kbd>Baggage Weight : <code style="float:none;" class="bagwth">0</code> Kg</kbd>
								<kbd>Baggage Charges : <em>Rs.</em> <code style="float:none;" class="bagcharges">0</code>
								</kbd>
							</span>
							</div>	
							
					</div>
				<?php } ?>
			</div>
			</div>
			
		
			<?php } ?>
			
			
							<div class="clearfix"></div>
							
							</div>
							</div>
							@if(isset($_GET['isINT']) && ($_GET['isINT'] == '1' || $_GET['isINT'] == 'true'))
							<div class="row">
							<div class="col-sm-12">
							<div class="col-sm-2 contact_label cus_label">Passport Detail</div>
							<div class="col-sm-10">
							
								<div class="form_field">
									<input maxlength="16" id="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'txtAdultPassport'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'txtChildPassport'.$jss; }else{ echo 'txtChildPassportExp'.$jss; } ?>" data-valid="required pasmaxlength15 PassportNoValidator" type="text" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultpassportno[]'; }else if($farebrakdowna[$jss]->PassengerType == 2){ echo 'childpassportno[]'; }else{ echo 'infantpassportno[]'; } ?>" placeholder="Passport Number" class="form-control" />
								</div>
								<div class="form_field">
									<input data-valid="required" id="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'txtAdultPassportExp'.$jss; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'txtChildPassportExp'.$jss; }else{ echo 'txtInfantPassportExp'.$jss; } ?>" type="text" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultpassportdate[]'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childpassportdate[]'; }else{ echo 'infantpassportdate[]'; } ?>" placeholder="Passport Expire date" class="form-control datepicker-3-time-start" />
								</div>
																					
							</div>
							<div class="clearfix"></div>
							</div>
							</div>
							@endif
							
							
									<?php 
									
									$jss++; } } ?>
						</div>
					</div><!-- .box-result end -->
				</div>
													
										
										<div class="myseatinfo" style="display:none;">
											<div class="booking_title">
												<h3>Select Seat</h3>
											</div>
											<div class="block-content-2 custom_block_content add_gst">
												<div class="box-result custom_box_result">
													<div class="service_req_sec">
														<ul class="nav nav-tabs custom_tabs">
														<?php 
														if(isset($resultdata[0]->Segments[0])){ 
															$res = $resultdata[0];
															$allflighdata = $res->Segments[0];
														
															for($fl =0;$fl<count($allflighdata);$fl++){ ?>
															<li class="<?php if($fl == 0){ echo 'active';}?>"><a id="SegSeatSelect_0_Seg_{{$fl}}" href="#departure_seat{{$fl}}" aria-controls="departure_seat{{$fl}}" role="tab" data-toggle="tab">{{$allflighdata[$fl]->Origin->Airport->CityCode}} - {{$allflighdata[$fl]->Destination->Airport->CityCode}}</a>
															
															</li>
															<?php } ?>
															<?php } ?>
															<?php if(!empty($resultdataib)){ if(isset($resultdataib[0]->Segments[0])){ 
															$res = $resultdataib[0];
															$allflighdata = $res->Segments[0];											
														?>														
															<?php 
														
															for($fl =0;$fl<count($allflighdata);$fl++){ ?>
															<li class=""><a id="SegSeatSelect_1_Seg_{{$fl}}" href="#return_seat{{$fl}}" aria-controls="return_seat{{$fl}}" role="tab" data-toggle="tab">{{$allflighdata[$fl]->Origin->Airport->CityCode}} - {{$allflighdata[$fl]->Destination->Airport->CityCode}}</a></li>
															<?php } ?>
															<?php } ?>
															<?php } ?>
														</ul>
														<div class="tab-content">
															<?php if(isset($resultdata[0]->Segments[0])){ 
															$res = $resultdata[0];
															$allflighdata = $res->Segments[0];		
															for($fl =0;$fl<count($allflighdata);$fl++){
														?>	
			<div role="tabpanel" class="tab-pane <?php if($fl == 0){ echo 'active';}?>" id="departure_seat{{$fl}}">
				<div class="plane_seat_sec">
					<div class="row">
						<div class="col-md-4">
							<div class="seat_info">
								<div class="flight_name">
									<img src="{{URL::to('/public/img/airline/')}}/{{$allflighdata[$fl]->Airline->AirlineCode}}.gif" alt="">
									<div class="name">{{$allflighdata[$fl]->Airline->AirlineName}}<span class="flight_no">{{$allflighdata[$fl]->Airline->AirlineCode}}-{{$allflighdata[$fl]->Airline->FlightNumber}}</span></div> 
								</div>
								<div class="ticket_info">
								<?php

								$j = 0;
								for($ic=0;$ic < count($farebrakdowna); $ic++){
									$jss = 0;
									for($ics=1;$ics <= $farebrakdowna[$ic]->PassengerCount; $ics++){
										if($farebrakdowna[$ic]->PassengerType != 3){
								?>
									<div class="ticket_col">
										<div class="tic_label"><?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'Adult'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'Child'; } ?> {{$ics}} <span fid="{{$allflighdata[$fl]->Origin->Airport->CityCode}} - {{$allflighdata[$fl]->Destination->Airport->CityCode}}" tif="<?php if($farebrakdowna[$ic]->PassengerType == 1){ ?>adultPaxSeat_{{$jss}}_0_Seg_{{$fl}}_paxCount<?php }else if($farebrakdowna[$ic]->PassengerType == 2){ ?>childPaxSeat_{{$jss}}_0_Seg_{{$fl}}_paxCount<?php } ?>" class="seatnumber" id="PaxSeat_0_Seg_{{$fl}}_paxCount_{{$j}}" style="visibility:hidden;"></span></div>
										<div class="tic_price">Rs <code id="PaxSeatCH_0_Seg_{{$fl}}_paxCount_{{$j}}">0.00</code></div>
										<input class="PaxSeat_0_Seg_{{$fl}}_paxCount_{{$j}}" type="hidden" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adult_'.$jss.'_PaxSeat_0_Seg_'.$fl.'_paxCount_'.$j; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'child_'.$jss.'_PaxSeat_0_Seg_'.$fl.'_paxCount_'.$j; } ?>">
									</div>	
										<?php  $jss++; }  $j++; }  } ?>
									
								</div>
							<div class="seat_section">
								<div class="seat_title">Seat Type</div>
								<ul>
									<li class="ytfi-seat avail">Available Seat</li>
									<li class="ytfi-seat booked">Occupied Seat</li>
									<li class="ytfi-seat sclt"><i class="fa fa-check"></i> Selected Seat</li>
								</ul>
							</div>
							</div>
						</div>
						<div class="col-md-8">
							<div class="seat_list">
								<div class="main_title">Front</div> 
								<div class="wings_top cus_wings"><span>Wings</span></div>
								<div class="table-responsive table_data">
									<table border="0" class="table">
										<tbody>
										</tbody>
									</table>
								</div>
								<div class="wings_bottom cus_wings"><span>Wings</span></div>
							</div>
						</div>
					</div>
				</div>
			</div>
															<?php } ?>
															<?php } ?>
															
			<?php if(!empty($resultdataib)){ if(isset($resultdataib[0]->Segments[0])){ 
			$res = $resultdataib[0];
			$allflighdata = $res->Segments[0];
			for($fl =0;$fl<count($allflighdata);$fl++){
				?>
			<div role="tabpanel" class="tab-pane " id="return_seat{{$fl}}">
			<div class="plane_seat_sec">
				<div class="row">
					<div class="col-md-4">
						<div class="seat_info">
							<div class="flight_name">
								<img src="{{URL::to('/public/img/airline/')}}/{{$allflighdata[$fl]->Airline->AirlineCode}}.gif" alt="">
								<div class="name">{{$allflighdata[$fl]->Airline->AirlineName}}<span class="flight_no">{{$allflighdata[$fl]->Airline->AirlineCode}}-{{$allflighdata[$fl]->Airline->FlightNumber}}</span></div> 
							</div>
								<div class="ticket_info">
								<?php

								$j = 0;
								for($ic=0;$ic < count($farebrakdowna); $ic++){
									$jss = 0;
									for($ics=1;$ics <= $farebrakdowna[$ic]->PassengerCount; $ics++){
										if($farebrakdowna[$ic]->PassengerType != 3){
								?>
									<div class="ticket_col">
										<div class="tic_label"><?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'Adult'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'Child'; } ?> {{$ics}} <span class="seatnumber" id="PaxSeat_1_Seg_{{$fl}}_paxCount_{{$j}}" fid="{{$allflighdata[$fl]->Origin->Airport->CityCode}} - {{$allflighdata[$fl]->Destination->Airport->CityCode}}" tif="<?php if($farebrakdowna[$ic]->PassengerType == 1){ ?>adultPaxSeat_{{$jss}}_1_Seg_{{$fl}}_paxCount<?php }else if($farebrakdowna[$ic]->PassengerType == 2){ ?>childPaxSeat_{{$jss}}_1_Seg_{{$fl}}_paxCount<?php } ?>" style="visibility:hidden;"></span></div>
										<div class="tic_price">Rs <code id="PaxSeatCH_1_Seg_{{$fl}}_paxCount_{{$j}}">0.00</code></div>
										<input class="PaxSeat_1_Seg_{{$fl}}_paxCount_{{$j}}" type="hidden" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'returnadult_'.$jss.'_PaxSeat_1_Seg_'.$fl.'_paxCount_'.$j; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'returnchild_'.$jss.'_PaxSeat_1_Seg_'.$fl.'_paxCount_'.$j; } ?>">
									</div>	
			<?php
									
									?>
									
										<?php  $jss++; }  $j++; }  } ?>
									

								</div>
								
							<div class="seat_section">
								<div class="seat_title">Seat Type</div>
								<ul>
									<li class="ytfi-seat avail">Available Seat</li>
									<li class="ytfi-seat booked">Occupied Seat</li>
									<li class="ytfi-seat sclt"><i class="fa fa-check"></i> Selected Seat</li>
								</ul>
							</div>
							</div>
						</div>
						<div class="col-md-8">
							<div class="seat_list">
								<div class="main_title">Front</div> 
								<div class="wings_top cus_wings"><span>Wings</span></div>
								<div class="table-responsive table_data">
									<table border="0" class="table">
										<tbody>
										</tbody>
									</table>
								</div>
								<div class="wings_bottom cus_wings"><span>Wings</span></div>
							</div>
						</div>
					</div>
				</div>
			</div>
																<?php
															}
															}
															}
															?>
														</div>
													</div>
												</div>
											</div>
										</div> 
									<input id="hfAdultCount" name="hfAdultCount" type="hidden" value="{{$hfAdultCount}}">
			<input id="hfChildCount" name="hfChildCount" type="hidden" value="{{$hfChildCount}}">
			<input id="hfInfantCount" name="hfInfantCount" type="hidden" value="{{$hfInfantCount}}">
										<div class="block-content-2 custom_block_content add_gst">
											<div class="box-result custom_box_result">
												<div class="gst_icon cus_icon"><img src="{!! asset('public/images/gst_icon.png') !!}" alt=""/></div>
												<div class="gst_txt cus_txt">
													<p>Add your GST Details <span>(Optional)</span></p>
													<span>Claim credit of GST charges. Your taxes may get updated post submitting your GST details.</span>
												</div>
												<div class="gst_btn"> 
													<a class="add_link" href="javascript:;"><i class="fa fa-plus"></i> Add</a>
													<a class="form_close" href="javascript:;"><i class="fa fa-times"></i></a>
												</div> 
												<div class="gst_form">
													<div class="col-sm-6 col-xs-6 col_xs_480">
														<div class="form-group">
															<div class="row">
																<label class="col-sm-4 col-xs-12 pad_rt0">GST Number:</label>
																<div class="col-sm-8 col-xs-12">
																	<div  class="form_field"><input maxlength="15" data-valid="" id="gstNumber" type="text" class="form-control" name="gst_number"/ value="{{@Auth::user()->gst_no}}"></div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-sm-6 col-xs-6 col_xs_480">
														<div class="form-group">
															<div class="row">
																<label class="col-sm-4 col-xs-12 pad_rt0">Company Name:</label>
																<div class="col-sm-8 col-xs-12"> 
																	<div  class="form_field"><input  id="gstName" type="text" class="form-control" name="company_name" value="{{@Auth::user()->company_name}}"/></div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-sm-6 col-xs-6 col_xs_480">
														<div class="form-group">
															<div class="row">
																<label class="col-sm-4 col-xs-12 pad_rt0">Email Id:</label>
																<div class="col-sm-8 col-xs-12">
																	<div class="form_field"><input id="gstEmail" type="email" class="form-control" name="emailid" value="{{@Auth::user()->email_id}}"/></div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-sm-6 col-xs-6 col_xs_480">
														<div class="form-group">
															<div class="row">
																<label class="col-sm-4 col-xs-12 pad_rt0">Mobile Number:</label>
																<div class="col-sm-8 col-xs-12">
																	<div class="form_field"><input maxlength="14" id="gstContact" type="text" class="form-control" name="mobile" value="{{@Auth::user()->mobile_number}}" /></div>
																</div>
															</div>
														</div>
													</div> 
													<div class="clearfix"></div>
													
												</div>
											</div><!-- .box-result end -->
										</div> 
								<input type="hidden" id="LastSegmentDepartureDate" name="LastSegmentDepartureDate" value="{{@$LastSegmentDepartureDate}}"/>		<?php
									$arraymerge = array_merge($aircode, $aaircode);
									if(in_array('I5', $arraymerge)){
										?>
										<input type="hidden" id="airasia" name="airasia" value="1"/>
										<?php
									}else{
										?>
										<input type="hidden" id="airasia" name="airasia" value="0"/>
										<?php
									}
								?>
										<div class="booking_title hidden">
		<h3><img src="{!! asset('public/images/travel-insurance.png') !!}" alt=""/> Travel Insurance <span class="cus_span">(Recommended)</span></h3>
	</div>
	<div class="block-content-2 custom_block_content add_gst hidden">
	<?php
	//echo '<pre>'; print_r($getplantotal);
	?>
		<div class="box-result custom_box_result">
			<div class="checkbox label_checkbox">
				<label class="label-container checkbox-default"><input type="checkbox" dataprice="{{@$getplantotal->pTravelPremiumOut_out->ptotalPremium}}" name="is_travelinsurance" value="1"/><span class="checkmark"></span> Yes, Add Travel Protection to protect my trip <span>(<i class="fa fa-rupee-sign"></i> {{@$getplantotal->pTravelPremiumOut_out->ptotalPremium}} per traveller)</span></label>  
			</div>
			
			<div class="view_benfits_sec">
				<p>Cover Includes</p> 
				<div class="insurence_list">
					<ul id="mucoverinc">
					@foreach(\App\TravelPlan::all() as $list)
						
						<li class="insu">
							<img alt="Flight" src="{{URL::to('/public/images/insuarance')}}/{{@$list->name}}.png">
							<span class="insurence_name">{{@$list->name}}</span>
							<div class="claim">
								<span>Claim upto <i class="fa fa-rupee-sign"></i>{{@$list->price}}</span>
							</div>
						</li>
						
							
						@endforeach
						<li class="showmore">
							<i class="fa fa-plus"></i>
							<span class="insurence_name"></span>
							<div class="claim">
								<span>Show More</span>
							</div>
							</li>
						<li style="display:none;" class="lessmore">
							<i class="fa fa-minus"></i>
							<span class="insurence_name"></span>
							<div class="claim">
								<span>Show Less</span>
							</div>
							</li>
						</ul>
					<div class="clearfix"></div>
				</div>
				<div class="insurance_note">
					<p>Note: Travel Protection is applicable only for Indian citizens below the age of 70 years. <a href="#">Terms & Conditions</a></p>
				</div> 
				<div class="insurance_holder">
					<div class="ins_logo">
						<!--<span>Insurance Provider</span>-->
						<img src="{{URL::to('/public/images')}}/Bajaj-Allianz-Life-Insurance-Logo.png" alt=""/>
					</div>
				</div>
			</div>
		</div>
	</div>								
									</div> 
								</div>  
								<div class="col-md-3 col-sm-12 cus_sidebar" id="sidebar">	
									<div class="booking_sidebar theiaStickySidebar">	
										<div class="inner_fare">	
										<h4>Fare Details</h4>
										<a href="javascript:;" class="myfarerule" traceid="{{@$_GET['tid']}}"  resindex="{{$res->ResultIndex}}">View Fare Rules</a> 
										<div class="fare_rules sidebar_bgclr inner_sidebar" id="DivFareQuote">
											<ul>
											<?php 
											$farebrakdown = @$res->FareBreakdown;
										
											if(!empty($resultdataib) && isset($resultdataib[0]->Segments[0])){ 
												$farebrakdownR = $resarrive->FareBreakdown; 
												?>
												<?php $vasefarec = 0; for($fbs = 0; $fbs<count($farebrakdown); $fbs++){ $vasefarec += $farebrakdown[$fbs]->BaseFare + $farebrakdownR[$fbs]->BaseFare; }  ?>
												<li class="basefare">Base Fare <small>(<?php echo $mtcount; ?> Traveller)</small> <i class="fa fa-angle-down"></i>
													<span class="price"><i class="fa fa-rupee-sign"></i> {{number_format($vasefarec)}}</span>
													<ul class="inner_ul">
														<?php for($fb = 0; $fb<count($farebrakdown); $fb++){ ?>
														<li><?php if($farebrakdown[$fb]->PassengerType == 1){ echo 'Adults'; }else if($farebrakdown[$fb]->PassengerType == 2){ echo 'Child'; }else{ echo 'Infant'; } ?>  x <?php echo $farebrakdown[$fb]->PassengerCount ?>  <span class="price"><i class="fa fa-rupee-sign"></i> <?php echo number_format($farebrakdown[$fb]->BaseFare + $farebrakdownR[$fb]->BaseFare); ?></span></li>
														<?php } ?>
													</ul>
												</li> 
												<li class="fee_subcharge">Taxes & Subcharges <!--<i class="fa fa-angle-down"></i>-->
												<?php  if(@$_GET['IsInt'] == 'False'){ $is_international = 'domestic'; }else{ $is_international = 'international'; }?>
												
	<?php
	$markupd =0;
	$markupamt = \App\Markup::where('flight_code', $res->Segments[0][0]->Airline->AirlineCode)->where('flight_type', $is_international)->first(); 
	if($markupamt){
		if($markupamt->service_type == 'fixed'){
			$markupd =  $markupamt->service_fee;
		}else{
			$markupd = ($res->Fare->OfferedFare * $markupamt->service_fee/100);
		}
	}
	$mark = $res->Fare->OfferedFare + $markupd;
	 $submark = $mark - $res->Fare->PublishedFare;
	
	/*Return*/
	$remarkupd =0;
	$remarkupamt = \App\Markup::where('flight_code', $resarrive->Segments[0][0]->Airline->AirlineCode)->where('flight_type', $is_international)->first(); 
	if($remarkupamt){
		if($remarkupamt->service_type == 'fixed'){
			$remarkupd =  $remarkupamt->service_fee;
		}else{
			$remarkupd = ($resarrive->Fare->OfferedFare * $remarkupamt->service_fee/100);
		}
	}
	$remark = $resarrive->Fare->OfferedFare + $remarkupd;
	 $sremarkupd = $remark - $resarrive->Fare->PublishedFare;
	?>
													<span class="price"><i class="fa fa-rupee-sign"></i> <?php echo number_format($res->Fare->Tax + $res->Fare->OtherCharges + $res->Fare->AdditionalTxnFeePub + $resarrive->Fare->Tax + $resarrive->Fare->OtherCharges + $resarrive->Fare->AdditionalTxnFeePub + $submark + $sremarkupd); ?></span>
													<!--<ul class="inner_ul">
														<li>User Development Fee <span class="price"><i class="fa fa-rupee-sign"></i> 142</span></li>
														<li>GST <span class="price"><i class="fa fa-rupee-sign"></i> 254</span></li>
														<li>Airline Fuel Subcharges <span class="price"><i class="fa fa-rupee-sign"></i> 2,187</span></li>
													</ul>-->
												</li>
												<li style="display:none;" class="addons">Add-Ons <i class="fa fa-angle-down"></i>
													<span class="price"><i class="fa fa-rupee-sign"></i> <span class="addonprice"></span></span>
													<small style="display:block;" class="addonname"></small>
													<ul class="inner_ul addonli">
														
													</ul>
												</li>
												
												<li class="total_value" totalfare="<?php echo round($res->Fare->PublishedFare + $resarrive->Fare->PublishedFare + $submark + $sremarkupd); ?>">Total Fare <span class="price"><i class="fa fa-rupee-sign"></i> <span class="totfare">0</span></span>
												<input type="hidden" id="tev_we" value="0">
												<input type="hidden" id="dep_we" value="0">
												<input type="hidden" id="ret_we" value="0">
												<input type="hidden" id="ret_meal" value="0">
												<input type="hidden" id="dep_meal" value="0">
												</li> 
												<li class="discount_value" style="display:none;"></li>
											<li class="you_pay">Rechecking fare <span class="price"> <span class="youpay"><img src="{{URL::to('/public/img')}}/Ellipsis.gif"></span></span>
												</li>
												<?php $total = round($res->Fare->PublishedFare + $resarrive->Fare->PublishedFare + $submark + $sremarkupd); ?>
												<?php
											}else{
												
												?>
												<?php if(@$_GET['IsInt']){ $is_international = 'international'; }else{ $is_international = 'domestic'; }
												$markupd =0;
	$markupamt = \App\Markup::where('flight_code', $res->Segments[0][0]->Airline->AirlineCode)->where('flight_type', $is_international)->first(); 
	if($markupamt){
		if($markupamt->service_type == 'fixed'){
			$markupd =  $markupamt->service_fee;
		}else{
			$markupd = ($res->Fare->OfferedFare * $markupamt->service_fee/100);
		}
	}
	$mark = $res->Fare->OfferedFare + $markupd;
	 $submark = $mark - $res->Fare->PublishedFare;
												?>
												
												<?php $vasefarec = 0; for($fbs = 0; $fbs<count($farebrakdown); $fbs++){ $vasefarec += $farebrakdown[$fbs]->BaseFare; }  ?>
												<li class="basefare">Base Fare <small>(<?php echo $mtcount; ?> Traveller)</small> <i class="fa fa-angle-down"></i>
													<span class="price"><i class="fa fa-rupee-sign"></i> {{number_format($vasefarec)}}</span>
													<ul class="inner_ul">
														<?php for($fb = 0; $fb<count($farebrakdown); $fb++){ ?>
														<li><?php if($farebrakdown[$fb]->PassengerType == 1){ echo 'Adults'; }else if($farebrakdown[$fb]->PassengerType == 2){ echo 'Child'; }else{ echo 'Infant'; } ?>  x <?php echo $farebrakdown[$fb]->PassengerCount ?>  <span class="price"><i class="fa fa-rupee-sign"></i> <?php echo number_format($farebrakdown[$fb]->BaseFare); ?></span></li>
														<?php } ?>
													</ul>
												</li> 
												<li class="fee_subcharge">Taxes & Surcharges <!--<i class="fa fa-angle-down"></i>-->
													<span class="price"><i class="fa fa-rupee-sign"></i> <?php echo number_format($res->Fare->Tax + $res->Fare->OtherCharges + $submark); ?></span>
													<!--<ul class="inner_ul">
														<li>User Development Fee <span class="price"><i class="fa fa-rupee-sign"></i> 142</span></li>
														<li>GST <span class="price"><i class="fa fa-rupee-sign"></i> 254</span></li>
														<li>Airline Fuel Subcharges <span class="price"><i class="fa fa-rupee-sign"></i> 2,187</span></li>
													</ul>-->
												</li>
												<li class="excess_bagage">Excess Baggage (<span class="weightc">0</span>KG )
													<span class="price"><i class="fa fa-rupee-sign"></i> 0.00</span>
												</li>
												<li class="meal_charges">Meal (0)
													<span class="price"><i class="fa fa-rupee-sign"></i> 0.00</span>
												</li>
												<li class="seat_charges">Seat Charges
													<span class="price"><i class="fa fa-rupee-sign"></i> 0.00</span>
												</li>
												<?php $total = round($res->Fare->PublishedFare + $submark); ?>
												<li class="total_value" totalfare="{{$res->Fare->PublishedFare + $submark}}">Total Fare <span class="price"><i class="fa fa-rupee-sign"></i> <span class="totfare">0</span></span>
												<input type="hidden" id="tev_we" value="0">
												<input type="hidden" id="dep_we" value="0">
												<input type="hidden" id="ret_we" value="0">
												<input type="hidden" id="ret_meal" value="0">
												<input type="hidden" id="dep_meal" value="0">
												<input type="hidden" id="coupon_code" value="0">
											
												</li> 
												<li class="discount_value" style="display:none;"></li>
												
												<li class="you_pay">Rechecking fare <span class="price"> <span class="youpay"><img src="{{URL::to('/public/img')}}/Ellipsis.gif"></span></span>
												</li>
												<?php
											}
											?>
										
												<!--<li class="earn">Earn <div style="display:inline-block;color:#db9a00;">eCash</div> <i class="fa fa-explanation"></i>: <span class="price"><i class="fa fa-rupee-sign"></i> 500</span>
												</li>-->
											</ul>
											<div class="clearfix"></div>
										</div>
											<input type="hidden" id="noAltChd" value="{{$person}}">	
										<h4>Promo Code</h4>
	<div class="promo_code sidebar_bgclr inner_sidebar">
		<div class="inner_promo">
			<div class="form-group">
				<label class="promo_label">Select a Promo Code</label>
				<div class="promo_field"> 
					<input type="text" class="form-control applytext" />
					<input type="hidden" name="coupncode" class="form-control applytextvaue" />
					<button type="button" class="promo_button">Apply</button>
					<button type="button" style="display:none;" class="clear_button">Clear</button>
					<p class="couponsuccess" style="display:none;"></p>
				</div>
			</div>
			<div id="" style="margin-top: 22px;">
			
			<div class="form-group coupon_li">
				<div class="cus_radio">
					<label>
						<div class="radio_field"><input checked name="payment_method" value="wallet" type="radio" class="paymenttype" /><span class="checkradio"></span></div> 
						<div class="promo_content">
							<span class="promo_key">Wallet (<b><i class="fa fa-rupee-sign"></i>{{@Auth::user()->wallet}}</b>)</span>
							
						</div>
					</label>
				</div>
			</div>
			<div class="form-group coupon_li">
				<div class="cus_radio">
					<label>
						<div class="radio_field"><input name="payment_method" value="razor_pay" type="radio" class="paymenttype" /><span class="checkradio"></span></div> 
						<div class="promo_content">
							<span class="promo_key">Razorpay</span>
							
						</div>
					</label>
					
				</div>
			</div>	
			
			</div>
			
		</div>
		<div class="booking_btn">
			<button disabled  type="button" onClick="customValidate('frmProduct')" class="pay_btn">Rechecking Fare</button>
		</div>
	</div>
									</div>
									</div>
								</div>
								<div class="col-md-12 hidden-sm hidden-xs hidden">
									<div class="booking_btn">
										<button disabled type="button" onClick="customValidate('frmProduct')" class="pay_btn">Rechecking Fare</button>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>	
							
							  {{ Form::close() }}
						</div>	
					</div>	
				</div>	 
			</div>	
		<div class=""></div>	
		</section>	
		<script> 
		 $(document).ready(function() {
                <?php
					if(isset($_GET['IsReturn']) && $_GET['IsReturn'] != 'False'){
						?>
						$.ajax({
							url: '{{URL::to('/')}}/agent/Flight/FareQuote?ResultIndex={{@$_GET['Index']}}&TraceId={{$_GET['tid']}}&IsInternational={{$_GET['IsInt']}}&IsReturn=true&ResultIndexR={{@$_GET['IndexR']}}&IsLccR=False&price={{$total}}',
							type:'GET',
							success:function(html){
								$('#DivFareQuote').html(html);
								BindMealBaggage();
							}
						});
						 
						<?php
					}else{
						?>
						console.log('sssd');
						$.ajax({
							url: '{{URL::to('/')}}/agent/Flight/FareQuote?ResultIndex={{@$_GET['RIndex']}}&TraceId={{$_GET['tid']}}&IsInternational={{$_GET['isINT']}}&IsReturn=False&ResultIndexR=&IsLccR=False&price={{$total}}',
							type:'GET',
							success:function(html){
								$('#DivFareQuote').html(html);
								BindMealBaggage();
							}
					});
						<?php
					}
				?>
               
               
              // BindTravelPlan();
            });
			 <?php
					if(isset($_GET['IsReturn']) && $_GET['IsReturn'] != 'False'){
						?>
			 function BindMealBaggage() {
				 setTimeout(function () {
					 
					// $(".bagageandmeal").load("");
					  $.ajax({
									url: '{{URL::to('/')}}/agent/Passenger/GetSSR?ResultIndex={{@$_GET['Index']}}&TraceId={{$_GET['tid']}}&IsLcc=True&IsInternational={{$_GET['IsInt']}}&IsReturn=true&ResultIndexR={{@$_GET['IndexR']}}&IsLccR=False',
									type:'GET',
									success:function(html){
										var obj = JSON.parse(html);
										$('.onward_flight').html(obj.onwardflight);
										$('.inward_flight').html(obj.inwardflight);
										$('.adultbaggage').prop('disabled', false);
										$('.adultmeal').prop('disabled', false);
										$('.childmeal').prop('disabled', false);
										$('.childbaggage').prop('disabled', false);
										
										$('.return_adultbaggage').prop('disabled', false);
										$('.return_adultmeal').prop('disabled', false);
										$('.return_childmeal').prop('disabled', false);
										$('.return_childbaggage').prop('disabled', false);
										$('[id^="adultbaggage_"]').each(function () {
											 var html1 = '';
											 var vid = this.id;
											$.each(obj.onwardbaggagessr, function(k, v) {
											if(v.key != '0@^@Direct_NONE'){
												html1 += '<li ><label><input class="AddadultOnbItem AddOnbItem" dvalue="'+v.value+'" value="'+v.key+'" type="checkbox" name="'+vid+'"><div class="serv_txt"><div class="serv_icon"><i class="fa fa-suitcase"></i></div><span class="serv_type baggage_type">Additional '+v.Weight+'kg</span><span class="serv_price baggage_price"><i class="fa fa-rupee-sign"></i> '+v.price+'</span></div></label></li>';
												}else{
													
												}
											});
											$('.baggage_list #'+vid).html(html1);
										});
										
										 $('[id^="childbaggage_"]').each(function () {
											 var html2 = '';
											 var vid = this.id;
											$.each(obj.onwardbaggagessr, function(k, v) {
											if(v.key != '0@^@Direct_NONE'){
												html2 += '<li ><label><input class="AddchildOnbItem AddOnbItem" dvalue="'+v.value+'" value="'+v.key+'" type="checkbox" name="'+vid+'"><div class="serv_txt"><div class="serv_icon"><i class="fa fa-suitcase"></i></div><span class="serv_type baggage_type">Additional '+v.Weight+'kg</span><span class="serv_price baggage_price"><i class="fa fa-rupee-sign"></i> '+v.price+'</span></div></label></li>';
												}else{
													
												}
											});
											$('.baggage_list #'+vid).html(html2);
										});
										
										$('[id^="returnadultbaggage_"]').each(function () {
											 var html1 = '';
											 var vid = this.id;
											$.each(obj.inwardbaggagessr, function(k, v) {
											if(v.key != '0@^@Direct_NONE'){
												html1 += '<li ><label><input class="AddadultOnbItem AddOnbItem" dvalue="'+v.value+'" value="'+v.key+'" type="checkbox" name="'+vid+'"><div class="serv_txt"><div class="serv_icon"><i class="fa fa-suitcase"></i></div><span class="serv_type baggage_type">Additional '+v.Weight+'kg</span><span class="serv_price baggage_price"><i class="fa fa-rupee-sign"></i> '+v.price+'</span></div></label></li>';
												}else{
													
												}
											});
											$('.baggage_list #'+vid).html(html1);
										});
										
										 $('[id^="returnchildbaggage_"]').each(function () {
											 var html2 = '';
											 var vid = this.id;
											$.each(obj.inwardbaggagessr, function(k, v) {
											if(v.key != '0@^@Direct_NONE'){
												html2 += '<li ><label><input class="AddchildOnbItem AddOnbItem" dvalue="'+v.value+'" value="'+v.key+'" type="checkbox" name="'+vid+'"><div class="serv_txt"><div class="serv_icon"><i class="fa fa-suitcase"></i></div><span class="serv_type baggage_type">Additional '+v.Weight+'kg</span><span class="serv_price baggage_price"><i class="fa fa-rupee-sign"></i> '+v.price+'</span></div></label></li>';
												}else{
													
												}
											});
											$('.baggage_list #'+vid).html(html2);
										});
							
										$('[id^="adultmeal_"]').each(function () {
											var vid = this.id;
											var vclasss = $(this).attr('vclass');
										
											var omhtml1 = '';
												if (typeof obj.onwardmealssr[vclasss] !== 'undefined') {
											$.each(obj.onwardmealssr[vclasss], function(kd, mod) {
												console.log(mod);
												if(mod.key != "NONE@^@0"){	
													omhtml1 += '<li><label><input class="AddadultOnmItem AddOnmItem" svalue="'+mod.value+'" name="'+vid+'" value="'+mod.key+'-'+vclasss+'" type="checkbox"><div class="serv_txt"><div class="serv_icon"><i class="fa fa-utensils"></i></div><span class="serv_type meals_type">'+mod.AirlineDescription+'</span><span class="serv_price meals_price"><i class="fa fa-rupee-sign"></i> '+mod.price+'</span></div></label></li>';
													}else{
														
													}
											});
												
											$('.meals_list #'+vid+'.b_'+vclasss).html(omhtml1);
											}else{
											omhtml1 = '<li style="color:red;">No Meal Found</li>';
											$('.meals_list #'+vid+'.b_'+vclasss).html(omhtml1);
										}
										});
							
										$('[id^="childmeal_"]').each(function () {
											var vid = this.id;
											var vclasss = $(this).attr('vclass');
											var omhtml2 = '';
											if (typeof obj.onwardmealssr[vclasss] !== 'undefined') {
											$.each(obj.onwardmealssr[vclasss], function(kd, mod) {
												if(mod.key != "NONE@^@0"){	
													omhtml2 += '<li><label><input class="AddchildOnmItem AddOnmItem" svalue="'+mod.value+'" name="'+vid+'" value="'+mod.key+'-'+vclasss+'" type="checkbox"><div class="serv_txt"><div class="serv_icon"><i class="fa fa-utensils"></i></div><span class="serv_type meals_type">'+mod.AirlineDescription+'</span><span class="serv_price meals_price"><i class="fa fa-rupee-sign"></i> '+mod.price+'</span></div></label></li>';
													}else{
														
													}
											}); 
											$('.meals_list #'+vid+'.b_'+vclasss).html(omhtml2);
											}else{
											omhtml2 = '<li style="color:red;">No Meal Found</li>';
											$('.meals_list #'+vid+'.b_'+vclasss).html(omhtml2);
										}
										}); 
										$('[id^="returnadultmeal_"]').each(function () {
											
											var vid = this.id;
											var vclasss = $(this).attr('vclass');
											
											var omhtml3 = '';
												if (typeof obj.inwardmealssr[vclasss] !== 'undefined') {
											$.each(obj.inwardmealssr[vclasss], function(kd, mod) {
												console.log(mod);
												if(mod.key != "NONE@^@0"){	
												
													omhtml3 += '<li><label><input class="AddadultOnmItem AddOnmItem" svalue="'+mod.value+'" name="'+vid+'" value="'+mod.key+'-'+vclasss+'" type="checkbox"><div class="serv_txt"><div class="serv_icon"><i class="fa fa-utensils"></i></div><span class="serv_type meals_type">'+mod.AirlineDescription+'</span><span class="serv_price meals_price"><i class="fa fa-rupee-sign"></i> '+mod.price+'</span></div></label></li>';
													}else{
														
													}
											});
											$('.retmeals_list #'+vid+'.b_'+vclasss).html(omhtml3);
											}else{
											omhtml3 = '<li style="color:red;">No Meal Found</li>';
											$('.retmeals_list #'+vid+'.b_'+vclasss).html(omhtml3);
										}
										});
							
										$('[id^="returnchildmeal_"]').each(function () {
											var vid = this.id;
											var vclasss = $(this).attr('vclass');
											var omhtml4 = '';
											if (typeof obj.inwardmealssr[vclasss] !== 'undefined') {
											$.each(obj.inwardmealssr[vclasss], function(kd, mod) {
												if(mod.key != "NONE@^@0"){	
													omhtml4 += '<li><label><input class="AddchildOnmItem AddOnmItem" svalue="'+mod.value+'" name="'+vid+'" value="'+mod.key+'-'+vclasss+'" type="checkbox"><div class="serv_txt"><div class="serv_icon"><i class="fa fa-utensils"></i></div><span class="serv_type meals_type">'+mod.AirlineDescription+'</span><span class="serv_price meals_price"><i class="fa fa-rupee-sign"></i> '+mod.price+'</span></div></label></li>';
													}else{
														
													}
											});
											$('.retmeals_list #'+vid+'.b_'+vclasss).html(omhtml4);
											}else{
											omhtml4 = '<li style="color:red;">No Meal Found</li>';
											$('.retmeals_list #'+vid+'.b_'+vclasss).html(omhtml4);
										}
										}); 
										$('.seatloader').hide();
										$('.ssrloadershow').show();
										$('.myseatinfo').show();
									if(obj.onwardseatssr.length != 0){
											$.each(obj.onwardseatssr, function(i, s) {
											console.log(i);
											$('#departure_seat'+i+' .plane_seat_sec .table_data .table tbody').html(s);
										});
										}else{
											$('.myseatinfo').hide();
										}
										
										$.each(obj.inwardseatssr, function(is, ss) {
										
											$('#return_seat'+is+' .plane_seat_sec .table_data .table tbody').html(ss);
										});
									}
							});
				 },2000);
			 }
			 <?php
					}else{
						?>
						function BindMealBaggage() {
						setTimeout(function () {
							 $.ajax({
									url: '{{URL::to('/')}}/agent/Passenger/GetSSR?ResultIndex={{@$_GET['RIndex']}}&TraceId={{$_GET['tid']}}&IsLcc=True&IsInternational={{$_GET['isINT']}}&IsReturn=False&ResultIndexR=&IsLccR=False',
									type:'GET',
									success:function(html){
										var obj = JSON.parse(html);
										$('.onward_flight').html(obj.onwardflight);
										$('.adultbaggage').prop('disabled', false);
										$('.adultmeal').prop('disabled', false);
										$('.childmeal').prop('disabled', false);
										$('.childbaggage').prop('disabled', false);
										
										 $('[id^="adultbaggage_"]').each(function () {
											 var html1 = '';
											 var vid = this.id;
											$.each(obj.onwardbaggagessr, function(k, v) {
											if(v.key != '0@^@Direct_NONE'){
												html1 += '<li ><label><input class="AddadultOnbItem AddOnbItem" dvalue="'+v.value+'" value="'+v.key+'" type="checkbox" name="'+vid+'"><div class="serv_txt"><div class="serv_icon"><i class="fa fa-suitcase"></i></div><span class="serv_type baggage_type">Additional '+v.Weight+'kg</span><span class="serv_price baggage_price"><i class="fa fa-rupee-sign"></i> '+v.price+'</span></div></label></li>';
												}else{
													
												}
											});
											$('.baggage_list #'+vid).html(html1);
										});
										
										 $('[id^="childbaggage_"]').each(function () {
											 var html2 = '';
											 var vid = this.id;
											$.each(obj.onwardbaggagessr, function(k, v) {
											if(v.key != '0@^@Direct_NONE'){
												html2 += '<li ><label><input class="AddchildOnbItem AddOnbItem" dvalue="'+v.value+'" value="'+v.key+'" type="checkbox" name="'+vid+'"><div class="serv_txt"><div class="serv_icon"><i class="fa fa-suitcase"></i></div><span class="serv_type baggage_type">Additional '+v.Weight+'kg</span><span class="serv_price baggage_price"><i class="fa fa-rupee-sign"></i> '+v.price+'</span></div></label></li>';
												}else{
													
												}
											});
											$('.baggage_list #'+vid).html(html2);
										});
							
										$('[id^="adultmeal_"]').each(function () {
											
											var vid = this.id;
											var vclasss = $(this).attr('vclass');
											var omhtml1 = '';
											
												if (typeof obj.onwardmealssr[vclasss] !== 'undefined') {
											$.each(obj.onwardmealssr[vclasss], function(kd, mod) {
												if(mod.key != "NONE@^@0"){	
													omhtml1 += '<li><label><input class="AddadultOnmItem AddOnmItem" svalue="'+mod.value+'" name="'+vid+'" value="'+mod.key+'-'+vclasss+'" type="checkbox"><div class="serv_txt"><div class="serv_icon"><i class="fa fa-utensils"></i></div><span class="serv_type meals_type">'+mod.AirlineDescription+'</span><span class="serv_price meals_price"><i class="fa fa-rupee-sign"></i> '+mod.price+'</span></div></label></li>';
													}else{
														
													}
											});
											$('.meals_list #'+vid+'.b_'+vclasss).html(omhtml1);
										}else{
											omhtml1 = '<li style="color:red;">No Meal Found</li>';
											$('.meals_list #'+vid+'.b_'+vclasss).html(omhtml1);
										}
											
										});
							
										$('[id^="childmeal_"]').each(function () {
											var vid = this.id;
											var vclasss = $(this).attr('vclass');
											var omhtml2 = '';
											if (typeof obj.onwardmealssr[vclasss] !== 'undefined') {
											$.each(obj.onwardmealssr[vclasss], function(kd, mod) {
												if(mod.key != "NONE@^@0"){	
													omhtml2 += '<li><label><input class="AddchildOnmItem AddOnmItem" svalue="'+mod.value+'" name="'+vid+'" value="'+mod.key+'-'+vclasss+'" type="checkbox"><div class="serv_txt"><div class="serv_icon"><i class="fa fa-utensils"></i></div><span class="serv_type meals_type">'+mod.AirlineDescription+'</span><span class="serv_price meals_price"><i class="fa fa-rupee-sign"></i> '+mod.price+'</span></div></label></li>';
													}else{
														
													}
											});
											$('.meals_list #'+vid+'.b_'+vclasss).html(omhtml2);
											}else{
												omhtml1 = '<li style="color:red;">No Meal Found</li>';
											$('.meals_list #'+vid+'.b_'+vclasss).html(omhtml1);
											}
										}); 
										
										
										
										
										//console.log(html);
										$('.depseat').html(obj.onwardflight);
										$('.seatloader').hide();
										$('.ssrloadershow').show();
										$('.myseatinfo').show();
										if(obj.onwardseatssr.length != 0){
											$.each(obj.onwardseatssr, function(i, s) {
												console.log(i);
												$('#departure_seat'+i+' .plane_seat_sec .table_data .table tbody').html(s);
											});
										}else{
											$('.myseatinfo').hide();
										}
										
										//$('.childmeal').html(omhtml);
									}
							});
					 //$(".bagageandmeal").load("");
					 
						},2000);
			 }
				<?php
					}
				?>
			/*  function BindTravelPlan() {
				 setTimeout(function () {
					 $(".travelplandata").load("{{URL::to('/')}}/Passenger/travelplan/");
					 
				 },2000);
			 } */
			 function showMBPopup(){
				$('#mytravelModal').modal('show');
			}
			  
		$(document).ready(function() {
			 travelsize_li = $("#mucoverinc .insu").length;
			  if(travelsize_li > 3){
				  $('.showmore').show();
			  }else{
				  $('.showmore').hide();
			  } 
			  xsss = 3; 
			  $('#mucoverinc .insu:lt(' + xsss + ')').show();
			  $('.showmore').click(function() {
				  $('#mucoverinc .insu').show();
					$('.showmore').hide();
					$('.lessmore').show();
			});
			 $('.lessmore').click(function() {
				 $('#mucoverinc .insu').hide();
				  $('#mucoverinc .insu:lt(' + xsss + ')').show();
				  
					$('.showmore').show();
					$('.lessmore').hide();
			});
			$(document).delegate('input[name="is_travelinsurance"]',"click", function(){ 
				if ($("input[name='is_travelinsurance']:checked").length > 0)
				{
					
					var dataprice = $(this).attr('dataprice'); 
					
					var totalfare = $('.total_value').attr('totalfare'); 
					var travlercount = $('#travlercount').val(); 
					$('.addons').show();
					var travelprice = parseInt(dataprice) * parseInt(travlercount);
					$('#tev_we').val(travelprice);
					var dep = $('#tev_we').val();
					
					$('.addonli').append('<li class="ret_dep_travel">Travel Insurance <div class="fa_close"><i class="fa fa-times"></i></div> <span class="price"><i class="fa fa-rupee-sign"></i> '+travelprice+'</span></li>');
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val(),$('#tev_we').val());
				}else{
					var dataprice = 0; 
					var dataweight = 0; 
					var totalfare = $('.total_value').attr('totalfare'); 
					$('#tev_we').val(dataprice);
					$('.ret_dep_travel').remove();
					var dep = $('#tev_we').val();
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val(),$('#tev_we').val());
				}
				if ($('ul.addonli').children('li').length == 0) {
					$('.addons').hide();
				}
				});
				$(document).delegate('input[name="return"]',"click", function(){ 
				$('.returnselectbag').removeClass('active');
				$('.ret_dep_weight').remove();
				 if ($("input[name='return']:checked").length > 0)
				{
					$(this).parent().addClass("active"); 
					var group = "input:checkbox[name='"+$(this).attr("name")+"']";
					$(group).attr("checked",false);
					$(this).attr("checked",true);
				 }else{
					  var group = "input:checkbox[name='"+$(this).attr("name")+"']";
					$(group).attr("checked",false);
				}
				 
				 if ($("input[name='return']:checked").length > 0)
				{
					
					var dataprice = $(this).parent().attr('dataprice'); 
					var dataweight = $(this).parent().attr('dataweight'); 
					var totalfare = $('.total_value').attr('totalfare'); 
					$('.addons').show();
					$('#ret_we').val(dataprice);
					var dep = $('#dep_we').val();
					
					$('.addonli').append('<li class="ret_dep_weight">Additional Weight '+dataweight+'kg <div class="fa_close"><i class="fa fa-times"></i></div> <span class="price"><i class="fa fa-rupee-sign"></i> '+dataprice+'</span></li>');
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val(),$('#tev_we').val());
				}else{
					var dataprice = 0; 
					var dataweight = 0; 
					var totalfare = $('.total_value').attr('totalfare'); 
					$('#ret_we').val(dataprice);
					$('.ret_dep_weight').remove();
					var dep = $('#dep_we').val();
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val(),$('#tev_we').val());
				}
				if ($('ul.addonli').children('li').length == 0) {
					$('.addons').hide();
				}
			});
				
			  var cs = $('.bagcharges').parent().children().first().text();
				$(document).delegate('.AddOnItem',"change", function(){
					var t = $(this).attr('name');
					 $('.dep_baggage_sele input[name="'+t+'"]').not(this).attr("checked",false); 
					 var totBagWt = 0;
					 var totBagCh = 0;
					var bag = $('.dep_baggage_sele input[name="'+t+'"]:checked').attr('dvalue');
					var bagv = $('.dep_baggage_sele input[name="'+t+'"]:checked').val();
					 if ($(this).is(':checked')) {
					 }else{
						 bag = 'No Excess/Extra Baggage';
					 }
					 var mwt = 0;
					var bag = bag.split('-');
					var splitLenght = bag.length;
					  if (bag == 'No Excess/Extra Baggage') {
							if (splitLenght === 6 || splitLenght === 5 || cs != 'Rs.') {
								bag = ("0-Kg " + cs + "-0-(Rs.-0)").split('-');
							}
							else {
								bag = ("0-Kg Rs.-0").split('-');
							}
						}
					
					$(this).closest('.dep_baggage_sele').find('.baggage_details .bagwth').html(parseFloat(bag[0]));
					$(this).closest('.dep_baggage_sele').find('.baggage_details .bagcharges').html(parseFloat(bag[2]));
					   splitLenght = bag.length;
					/* $('.baggage_details .bagwth').each(function () {
						totBagWt += parseInt($(this).text());
					});
					$('.excess_bagage .weightc').html(totBagWt);
					
					 $('.baggage_details .bagcharges').each(function () {
						totBagCh += parseFloat($(this).text());
					}); */
					var itemname = t.split('_');
					var mytab = 'pasadult-'+itemname[1]+'-'+itemname[2];
					var mytabf = 'mybagpasadult-'+itemname[1];
					var mytabfd = 'mydbagpasadult-'+itemname[1];
					
					$('.AddOnItem:checked').each(function () {
						var vd = $(this).attr('dvalue');
						console.log(vd);
						var mDDTextd = vd.split('-');
						totBagCh += parseFloat(mDDTextd[2]);
						//rc =  parseInt(rc) + 1;
					});
					var rc = $('.'+mytabfd+' .AddOnItem:checked').length;
					var rca = $('.'+mytabf+'.countdepvalue').length;
					
					$('.excess_bagage .price').html('<i class="fa fa-rupee-sign"></i> '+parseFloat(totBagCh).toFixed(2));
					$('#dep_we').val(parseFloat(totBagCh).toFixed(2));
					//$(this).closest('.dep_baggage_sele').find('.baggage_details .selectbagvalue').val(bagv);
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val(),$('#tev_we').val());
					var asd = $(this).closest('.dep_baggage_sele').parent().parent().parent().attr('id');
					
					if(rc > 0){
						if(rc < rca){
							$('a[name="'+asd+'"]').html('<i class="fa fa-luggage-cart"></i> '+rc+' Baggage Added');
							
							$('.nav-tabs li.'+mytabf+':eq('+rc+') a').tab('show');
						}else if(rc == rca){
							$('a[name="'+asd+'"]').html('<i class="fa fa-luggage-cart"></i> '+rc+' Baggage Added');
							$('.service_req_sec_nseat').hide();
						$('.service_req_sec_nseat').removeClass('activebox');
						}
					}else{
						$('.service_req_sec_nseat').hide();
						$('.service_req_sec_nseat').removeClass('activebox');
						$('a[name="'+asd+'"]').html('<i class="fa fa-luggage-cart"></i> &nbsp;Add Baggage');
					}
					
					/* if($(this).closest('.dep_baggage_sele').find('.baggage_details .selectbagvalue').val() != ''){
					
						$('.service_req_sec_nseat').removeClass('activebox');
						$('.service_req_sec_nseat').hide();
						
					}else{
						$('a[name="'+asd+'"]').html('<i class="fa fa-luggage-cart"></i> Add Baggage');
					} */
					
					
				});
				
				$(document).delegate('.AddadultOnbItem',"change", function(){
					var t = $(this).attr('name');
					 $('.dep_baggage_sele input[name="'+t+'"]').not(this).attr("checked",false); 
					 $('.dep_baggage_sele input[name="'+t+'"]').parent().parent().removeClass('activebag'); 
					 $('input[name="'+t+'"]:checked').parent().parent().addClass('activebag');
					 var totBagWt = 0;
					 var totBagCh = 0;
					var bag = $('.dep_baggage_sele input[name="'+t+'"]:checked').attr('dvalue');
					var bagv = $('.dep_baggage_sele input[name="'+t+'"]:checked').val();
					 if ($(this).is(':checked')) {
					 }else{
						 bag = 'No Excess/Extra Baggage';
					 }
					 var mwt = 0;
					var bag = bag.split('-');
					var splitLenght = bag.length;
					  if (bag == 'No Excess/Extra Baggage') {
							if (splitLenght === 6 || splitLenght === 5 || cs != 'Rs.') {
								bag = ("0-Kg " + cs + "-0-(Rs.-0)").split('-');
							}
							else {
								bag = ("0-Kg Rs.-0").split('-');
							}
						}
					
					$(this).closest('.dep_baggage_sele').find('.baggage_details .bagwth').html(parseFloat(bag[0]));
					$(this).closest('.dep_baggage_sele').find('.baggage_details .bagcharges').html(parseFloat(bag[2]));
					   splitLenght = bag.length;
					/* $('.baggage_details .bagwth').each(function () {
						totBagWt += parseInt($(this).text());
					});
					$('.excess_bagage .weightc').html(totBagWt);
					
					 $('.baggage_details .bagcharges').each(function () {
						totBagCh += parseFloat($(this).text());
					}); */
					var itemname = t.split('_');
					var mytab = 'pasadult-'+itemname[1]+'-'+itemname[2];
					var mytabf = 'mybagpasadult-'+itemname[1];
					var mytabfd = 'mydbagpasadult-'+itemname[1];
					
					$('.AddOnbItem:checked').each(function () {
						var vd = $(this).attr('dvalue');
						console.log(vd);
						var mDDTextd = vd.split('-');
						totBagCh += parseFloat(mDDTextd[2]);
						//rc =  parseInt(rc) + 1;
					});
					$('.AddOnbItem:checked').each(function () {
						var vd = $(this).attr('dvalue');
						console.log(vd);
						var mDDTextd = vd.split('-');
						totBagWt += parseFloat(mDDTextd[0]);
						
					});
					$('.excess_bagage .weightc').html(totBagWt);
					
					var rc = $('.'+mytabfd+' .AddOnbItem:checked').length;
					var rca = $('.'+mytabf+'.countdepvalue').length;
					
					$('.excess_bagage .price').html('<i class="fa fa-rupee-sign"></i> '+parseFloat(totBagCh).toFixed(2));
					$('#dep_we').val(parseFloat(totBagCh).toFixed(2));
					//$(this).closest('.dep_baggage_sele').find('.baggage_details .selectbagvalue').val(bagv);
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val(),$('#tev_we').val());
					var asd = $(this).closest('.dep_baggage_sele').parent().parent().parent().attr('id');
					
					if(rc > 0){
						if(rc < rca){
							$('a[name="'+asd+'"]').html('<i class="fa fa-luggage-cart"></i> '+rc+' Baggage Added');
							
							$('.nav-tabs li.'+mytabf+':eq('+rc+') a').tab('show');
						}else if(rc == rca){
							$('a[name="'+asd+'"]').html('<i class="fa fa-luggage-cart"></i> '+rc+' Baggage Added');
							$('.service_req_sec_nseat').hide();
						$('.service_req_sec_nseat').removeClass('activebox');
						}
					}else{
						$('.service_req_sec_nseat').hide();
						$('.service_req_sec_nseat').removeClass('activebox');
						$('a[name="'+asd+'"]').html('<i class="fa fa-luggage-cart"></i>&nbsp; Add Baggage');
					}
					
					/* if($(this).closest('.dep_baggage_sele').find('.baggage_details .selectbagvalue').val() != ''){
					
						$('.service_req_sec_nseat').removeClass('activebox');
						$('.service_req_sec_nseat').hide();
						
					}else{
						$('a[name="'+asd+'"]').html('<i class="fa fa-luggage-cart"></i> Add Baggage');
					} */
					
					
				});
				
				$(document).delegate('.AddchildOnbItem',"change", function(){
					var t = $(this).attr('name');
					 $('.dep_baggage_sele input[name="'+t+'"]').not(this).attr("checked",false); 
					  $('.dep_baggage_sele input[name="'+t+'"]').parent().parent().removeClass('activebag'); 
					 $('input[name="'+t+'"]:checked').parent().parent().addClass('activebag');
					 var totBagWt = 0;
					 var totBagCh = 0;
					var bag = $('.dep_baggage_sele input[name="'+t+'"]:checked').attr('dvalue');
					var bagv = $('.dep_baggage_sele input[name="'+t+'"]:checked').val();
					 if ($(this).is(':checked')) {
					 }else{
						 bag = 'No Excess/Extra Baggage';
					 }
					 var mwt = 0;
					var bag = bag.split('-');
					var splitLenght = bag.length;
					  if (bag == 'No Excess/Extra Baggage') {
							if (splitLenght === 6 || splitLenght === 5 || cs != 'Rs.') {
								bag = ("0-Kg " + cs + "-0-(Rs.-0)").split('-');
							}
							else {
								bag = ("0-Kg Rs.-0").split('-');
							}
						}
					
					$(this).closest('.dep_baggage_sele').find('.baggage_details .bagwth').html(parseFloat(bag[0]));
					$(this).closest('.dep_baggage_sele').find('.baggage_details .bagcharges').html(parseFloat(bag[2]));
					   splitLenght = bag.length;
					
					var itemname = t.split('_');

					var mytabf = 'mybagpaschild-'+itemname[1];
					var mytabfd = 'mydbagpaschild-'+itemname[1];
					
					$('.AddOnbItem:checked').each(function () {
						var vd = $(this).attr('dvalue');
						console.log(vd);
						var mDDTextd = vd.split('-');
						totBagCh += parseFloat(mDDTextd[2]);
						//rc =  parseInt(rc) + 1;
					});
					var rc = $('.'+mytabfd+' .AddOnbItem:checked').length;
					var rca = $('.'+mytabf+'.countdepvalue').length;
					$('.AddOnbItem:checked').each(function () {
						var vd = $(this).attr('dvalue');
						console.log(vd);
						var mDDTextd = vd.split('-');
						totBagWt += parseFloat(mDDTextd[0]);
						
					});
					$('.excess_bagage .weightc').html(totBagWt);
					$('.excess_bagage .price').html('<i class="fa fa-rupee-sign"></i> '+parseFloat(totBagCh).toFixed(2));
					$('#dep_we').val(parseFloat(totBagCh).toFixed(2));
					//$(this).closest('.dep_baggage_sele').find('.baggage_details .selectbagvalue').val(bagv);
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val(),$('#tev_we').val());
					var asd = $(this).closest('.dep_baggage_sele').parent().parent().parent().attr('id');
					
					if(rc > 0){
						if(rc < rca){
							$('a[name="'+asd+'"]').html('<i class="fa fa-luggage-cart"></i> '+rc+'&nbsp; Baggage Added');
							
							$('.nav-tabs li.'+mytabf+':eq('+rc+') a').tab('show');
						}else if(rc == rca){
							$('a[name="'+asd+'"]').html('<i class="fa fa-luggage-cart"></i> '+rc+'&nbsp; Baggage Added');
							$('.service_req_sec_nseat').hide();
						$('.service_req_sec_nseat').removeClass('activebox');
						}
					}else{
						$('.service_req_sec_nseat').hide();
						$('.service_req_sec_nseat').removeClass('activebox');
						$('a[name="'+asd+'"]').html('<i class="fa fa-luggage-cart"></i>&nbsp; Add Baggage');
					}
					
					/* if($(this).closest('.dep_baggage_sele').find('.baggage_details .selectbagvalue').val() != ''){
					
						$('.service_req_sec_nseat').removeClass('activebox');
						$('.service_req_sec_nseat').hide();
						
					}else{
						$('a[name="'+asd+'"]').html('<i class="fa fa-luggage-cart"></i> Add Baggage');
					} */
					
					
				});
				
				
				$(document).delegate('.AddadultOnmItem',"change", function(){
					var t = $(this).attr('name');
					 $('.dep_meal_sele input[name="'+t+'"]').not(this).attr("checked",false); 
					 $('.dep_meal_sele input[name="'+t+'"]').parent().parent().removeClass('activemeal'); 
					 $('input[name="'+t+'"]:checked').parent().parent().addClass('activemeal');
					var v = $('input[name="'+t+'"]:checked').attr('svalue');
					console.log(v);
					 var mwt = 0;
					 var mQ = 0;
					 var mCh = 0;
				
					 if ($(this).is(':checked')) {
					 }else{
						 v = 'Add No Meal Rs.-0';
					 }
					var mDDText = v.split('-');
					console.log(mDDText);
					var splitLenght = mDDText.length;
					
					$(this).parent().find('.mealdetail .mealcharges').html(parseFloat(mDDText[1]));
					var itemname = t.split('_');
					var mytab = 'pasadult-'+itemname[1]+'-'+itemname[2];
					var mytabf = 'mypasadult-'+itemname[1];
					var mytabfd = 'mydpasadult-'+itemname[1];
					
					var mealc = 0;
					$('.AddOnmItem:checked').each(function () {
						var vd = $(this).attr('svalue');
						console.log(vd);
						var mDDTextd = vd.split('-');
						mCh += parseFloat(mDDTextd[1]);
						mealc++;
					});
					$('.meal_charges .mealxc').html(mealc);
					var rc = $('.'+mytabfd+' .AddOnmItem:checked').length;
					var rca = $('.'+mytabf+'.countdepvalue').length;
					$('.mealcount').val(rc);
					$('.meal_charges .price').html('<i class="fa fa-rupee-sign"></i> '+parseFloat(mCh).toFixed(2));
					
					$('#dep_meal').val(parseFloat(mCh).toFixed(2));
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val(),$('#tev_we').val());
				
					var asd = $(this).closest('.dep_meal_sele').parent().parent().parent().attr('id');
					
					if(rc > 0){
						if(rc < rca){
							
							$('a[name="'+asd+'"]').html('<i class="fa fa-hamburger"></i>&nbsp;'+rc+' Meal Added');
							$('.nav-tabs li.'+mytabf+':eq('+rc+') a').tab('show');
						}else if(rc == rca){
							$('a[name="'+asd+'"]').html('<i class="fa fa-hamburger"></i>&nbsp;'+rc+' Meal Added');
							$('.service_req_sec_nseat').hide();
						$('.service_req_sec_nseat').removeClass('activebox');
						}
					}else{
						$('.service_req_sec_nseat').hide();
						$('.service_req_sec_nseat').removeClass('activebox');
						$('a[name="'+asd+'"]').html('<i class="fa fa-hamburger"></i>&nbsp;Add Meal');
					}
				});
				
				
				$(document).delegate('.AddchildOnmItem',"change", function(){
					var t = $(this).attr('name');
					 $('.dep_meal_sele input[name="'+t+'"]').not(this).attr("checked",false); 
					  $('.dep_meal_sele input[name="'+t+'"]').parent().parent().removeClass('activemeal'); 
					 $('input[name="'+t+'"]:checked').parent().parent().addClass('activemeal');
					var v = $('input[name="'+t+'"]:checked').attr('svalue');
					console.log(v);
					 var mwt = 0;
					 var mQ = 0;
					 var mCh = 0;
					 if ($(this).is(':checked')) {
					 }else{
						 v = 'Add No Meal Rs.-0';
					 }
					var mDDText = v.split('-');
					console.log(mDDText);
					var splitLenght = mDDText.length;
					
					$(this).parent().find('.mealdetail .mealcharges').html(parseFloat(mDDText[1]));
					var itemname = t.split('_');
					var mytab = 'paschild-'+itemname[1]+'-'+itemname[2];
					var mytabf = 'mypaschild-'+itemname[1];
					var mytabfd = 'mydpaschild-'+itemname[1];
					var mealc = 0;
					$('.AddOnmItem:checked').each(function () {
						var vd = $(this).attr('svalue');
						console.log(vd);
						var mDDTextd = vd.split('-');
						mCh += parseFloat(mDDTextd[1]);
						mealc++;
					});
					$('.meal_charges .mealxc').html(mealc);
					var rc = $('.'+mytabfd+' .AddOnmItem:checked').length;
					var rca = $('.'+mytabf+'.countdepvalue').length;
					
					$('.mealcount').val(rc);
					$('.meal_charges .price').html('<i class="fa fa-rupee-sign"></i> '+parseFloat(mCh).toFixed(2));
					
					$('#dep_meal').val(parseFloat(mCh).toFixed(2));
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val(),$('#tev_we').val());
				
					var asd = $(this).closest('.dep_meal_sele').parent().parent().parent().attr('id');
					
					if(rc > 0){
						if(rc < rca){
							
							$('a[name="'+asd+'"]').html('<i class="fa fa-hamburger"></i>&nbsp;'+rc+' Meal Added');
							$('.nav-tabs li.'+mytabf+':eq('+rc+') a').tab('show');
						}else if(rc == rca){
							$('a[name="'+asd+'"]').html('<i class="fa fa-hamburger"></i>&nbsp;'+rc+' Meal Added');
							$('.service_req_sec_nseat').hide();
						$('.service_req_sec_nseat').removeClass('activebox');
						}
					}else{
						$('.service_req_sec_nseat').hide();
						$('.service_req_sec_nseat').removeClass('activebox');
						$('a[name="'+asd+'"]').html('<i class="fa fa-hamburger"></i>&nbsp;Add Meal');
					}
				});
			
			$(document).delegate('.login', 'click', function(){
				var flag = true;
				$(".custom-error").remove();
				$('.showiferror').hide();
				if($('input[name="login_email"]').val() == ''){
					flag = false;
					$($('input[name="login_email"]')).after("<span class='custom-error' role='alert'>Email is required</span>");
				}else if(!validateEmail($.trim($('input[name="login_email"]').val()))) 
				{
					flag = false;
					$('input[name="login_email"]').after("<span class='custom-error' role='alert'>Please enter the valid email address.</span>");
				}
				if($('input[name="login_password"]').val() == ''){
					flag = false;
					$($('input[name="login_password"]')).after("<span class='custom-error' role='alert'>Password is required</span>");
				}
				if(flag){
					$.ajax({
						url: "{{ route('customer.login') }}",
						dataType: 'json',
						type: 'POST',
						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						 
						data: {email:$('input[name="login_email"]').val(),password:$('input[name="login_password"]').val()},
						success:function(resp){
					
							if (resp.success) {
								location.reload();
							}else{
								$('.showiferror').html("<span class='custom-error' role='alert'>"+resp.errors+"</span>");
								$('.showiferror').show();
							}
						}
					});
				}
				
			});
			$(document).delegate('.promo_button', 'click', function(){
				var flag = true;
				if($('.applytext').val() == ''){
					alert('Please enter coupon code');
					flag = false;
				}
				if(flag){
					var coupo = $(".applytext").val();
					$.ajax({
					url:'{{URL::to('/agent/Flight/ApplyCoupon')}}',
					dataType: 'json',
					type: 'GET',
				
					data:{coupon_code:coupo},
					success: function(res){
						var obj = res;
						$('.couponsuccess').show();
						if(obj.success){
							$('.discount_value').show();
							var postfix = '';
							var prefix = '';
							if(obj.coupondetail.discount_type == 'percentage'){
								postfix = '%';
							}else{
								prefix = '<i class="fa fa-rupee-sign"></i>';
							}
							$('.discount_value').html('Discount '+obj.coupondetail.coupon_code+' ('+prefix+obj.coupondetail.discount+postfix+')<span class="price"><i class="fa fa-rupee-sign"></i> <span class="distotfare"></span>');
							$('.applytextvaue').val(coupo);
							$('.promo_button').hide();
							$('.clear_button').show();
							$('.couponsuccess').html(obj.message);
							var cp = $('#coupon_code').val(obj.coupondetail.discount+'|'+obj.coupondetail.discount_type);
							var cp = obj.coupondetail.discount+'|'+obj.coupondetail.discount_type;
							calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), cp,$('#tev_we').val());
							$('.couponsuccess').css('color','#a8d845');
						}else{
							$('.promo_button').show();
							$('.clear_button').hide();
							$('#coupon_code').val(0);
							$('.discount_value').hide();
							$('.applytext').val('');
							$('.applytextvaue').val('');
							calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), 0,$('#tev_we').val());
							$('.couponsuccess').html(obj.message);
							$('.couponsuccess').css('color','#ff0000');
						}
					}
				});
				}
			});
			$(document).delegate('.clear_button', 'click', function(){
				$('.promo_button').show();
				$('.clear_button').hide();
				$('#coupon_code').val(0);
				$('.discount_value').hide();
				$('.applytext').val('');
				$('.applytextvaue').val('');
				$('.couponsuccess').hide();
				$('.couponcode').prop('checked', false);
				calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), 0,$('#tev_we').val());
				$('.couponsuccess').html('');
			});
			$(document).delegate('.coupon_apply', 'change', function(){
				var coupo = $("input[name='couponcode']:checked").val();
				$('.applytext').val(coupo);
				$.ajax({
					url:'{{URL::to('/agent/Flight/ApplyCoupon')}}',
					dataType: 'json',
					type: 'GET',
				
					data:{coupon_code:coupo},
					success: function(res){
						$('.couponsuccess').show();
						var obj = res;
						if(obj.success){
							$('.discount_value').show();
							var postfix = '';
							var prefix = '';
							if(obj.coupondetail.discount_type == 'percentage'){
								postfix = '%';
							}else{
								prefix = '<i class="fa fa-rupee-sign"></i>';
							}
							$('.discount_value').html('Discount '+obj.coupondetail.coupon_code+' ('+prefix+obj.coupondetail.discount+postfix+')<span class="price"><i class="fa fa-rupee-sign"></i> <span class="distotfare"></span>');
							$('.applytextvaue').val(coupo);
							$('.promo_button').hide();
							$('.clear_button').show();
							$('.couponsuccess').html(obj.message);
							var cp = $('#coupon_code').val(obj.coupondetail.discount+'|'+obj.coupondetail.discount_type);
							var cp = obj.coupondetail.discount+'|'+obj.coupondetail.discount_type;
							calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), cp,$('#tev_we').val());
							$('.couponsuccess').css('color','#a8d845');
						}else{
							$('.promo_button').show();
							$('.clear_button').hide();
							$('#coupon_code').val(0);
							$('.discount_value').hide();
							$('.applytext').val('');
							$('.applytextvaue').val('');
							calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), 0,$('#tev_we').val());
							$('.couponsuccess').html(obj.message);
							$('.couponsuccess').css('color','#ff0000');
						}
					}
				});
			});
		
			function calculation(ob,rb,om,rm,cm,tp){
				
				var totalfare = $('.total_value').attr('totalfare'); 
				var seatprice =0;
				 $('[id^="PaxSeatCH_"]').each(function () {
					  if ($(this).text() != '') {
						 seatprice +=  parseFloat($(this).text());
					  }
				 });
				var total = parseFloat(totalfare) + parseFloat(ob) + parseFloat(rb) + parseFloat(om) + parseFloat(rm) + parseFloat(tp) + parseFloat(seatprice);
				var discount = 0;
				if(cm != 0){
					var value = cm.split('|');
					if(value[1] == 'percentage'){
						discount = (total * value[0]/100);
					}else{
						discount =  value[0];
					} 
				}
				 
				$('.distotfare').html(discount.toFixed(2));
				var finaltotal = total - discount;
				var fnd = Math.round(total);
				var fn = Math.round(finaltotal);
				$('.addonprice').html(parseFloat(ob) + parseFloat(rb) + parseFloat(om) + parseFloat(rm) + parseFloat(tp));
				$('.totfare').html(fnd.toLocaleString());
					$('.youpay').html(fn.toLocaleString());
			}
			
			$(document).delegate('.fare_rules ul li.basefare', 'click', function(){				
				$('.fare_rules ul li.basefare ul.inner_ul').toggleClass('show');
			});
			$(document).delegate('.fare_rules ul li.fee_subcharge', "click", function(){ 
				$('.fare_rules ul li.fee_subcharge ul.inner_ul').toggleClass('show');
			});
			$(document).delegate('.fare_rules ul li.addons',"click", function(){ 
				$('.fare_rules ul li.addons ul.inner_ul').toggleClass('show');
			});
			$(document).delegate('.booking_title a.open_signin', "click", function(){ 
				$(this).toggleClass('open');
				$('.signin_content').toggleClass('show'); 
			});
			$(document).delegate('.signin_content .content_close', "click", function(){ 
				$('.booking_title a.open_signin').removeClass('open');
				$('.signin_content').removeClass('show'); 
			});
			$(document).delegate('.add_gst .gst_btn a.add_link',"click", function(){ 
				$(this).addClass('hide');
				$('.gst_form').toggleClass('show');
				$('.add_gst .gst_btn a.form_close').addClass('show');
			});
			$(document).delegate('.add_gst .gst_btn a.form_close',"click", function(){ 
				$(this).removeClass('show');
				$('.add_gst .gst_btn a.add_link').removeClass('hide');
				$('.gst_form').toggleClass('show');   
			});  
			/* $('.service_req_list li span.baggage_select').on("click", function(){ 
				$(this).toggleClass('checked'); 
				$(this).parent('.service_req_list li').toggleClass('active');  
			});  */
	
			 $('.paymethod').on('click', function(){
				var val = $("input:radio[name='paymentmethod']:checked").val();
				$('#payment_method').val(val);
			});
			
			 var _divId = '';
			  var noAdCh = parseInt($('#noAltChd').val());
    $(document).delegate('[id^="FlSeat_"]','mouseover', function () {
        var _id = this.id;
        if (_divId != '') {
            $('#' + _divId).hide();
            _divId = '';
        }
        var sdata = _id.split('_');
        _divId = _id.replace('FlSeat_', 'FlSeatInfo_');
        $('#' + _divId).show();
    });

   $(document).delegate('[id^="FlSeat_"]','mouseout', function () {
        var _id = this.id;
        var divid = _id.replace('FlSeat_', 'FlSeatInfo_');
        $('#' + divid).hide();
    });

    /* $('#Paxspn_0_Seg_0_paxCount_0').live('mouseover', function () {
        $('#FlSeatclick').show();
    });
    $('#Paxspn_0_Seg_0_paxCount_0').live('mouseout', function () {
        $('#FlSeatclick').hide();
    }); */
	$(document).delegate('[id^="SegSeatSelect_"]', 'click', function(){
		 isSeatChaning = false;
		 seatChaingID = '';
		 var _id = this.id;
        var spId = _id.split('_');
		 if (firstSelId.length > 0) {
            firstSelId = [];
            $('[id^="PaxSeat_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_"]').each(function () {
                firstSelId[firstSelId.length] = '#';
            });
        }
        else {
            firstSelId = [];
        }
		
		
		 var cot = 0;
        $('[id^="PaxSeat_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_"]').each(function () {
            var srText = $(this).text();
			console.log('[id^="FlSeat_' + spId[1] + '_Seg_' + spId[3] + '_Row_"]');
            $('[id^="FlSeat_' + spId[1] + '_Seg_' + spId[3] + '_Row_"]').each(function () {
                var inrStText = $(this).find('span').text();
                if (inrStText == srText) {
                    if ($(this).find('span').hasClass('selected')) {
                        firstSelId[cot] = this.id;
                    }
                    else if ($(this).find('span').hasClass('occupied')) {
                        $(this).find('span').removeClass('occupied');
                        $(this).find('span').addClass('selected');
                        firstSelId[cot] = this.id;
                    }
                }
            });
            cot++;
        });
        var t = 0;
        var bp = 0;
        var stxt = '';
        for (var ic = 0; ic < firstSelId.length; ic++) {
            if (firstSelId[ic] != '' && firstSelId[ic] == '#') {
                $('#PaxSeat_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_' + ic).html('-');
                $('.PaxSeat_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_' + ic).val('0');
                $('#PaxSeatCH_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_' + ic).text('0.00');
                if (isBaseCheck) {
                    $('#PaxSeatBaseCH_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_' + ic).text('0.00');
                }
                stxt += ' - ';
            }
            else {
                $('#PaxSeat_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_' + ic).html($('#' + firstSelId[ic]).attr('seatcode')).css('visibility','visible');
                $('.PaxSeat_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_' + ic).val($('#' + firstSelId[ic]).attr('id'));
                var liid = firstSelId[ic].replace('FlSeat_', 'StPrc_');
                var stprc = $('#' + liid).text().replace('Price : ', '').replace(' (', ' ').replace(')', ' ').split(' ');
                t += parseFloat(stprc[1].replace(',', ''));
                if (stprc.length > 2) {
                    bp += parseFloat(stprc[3].replace(',', ''));
                }
                $('#PaxSeatCH_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_' + ic).text((parseFloat(stprc[1].replace(',', ''))).toFixed(2));
                if (isBaseCheck) {
                    $('#PaxSeatBaseCH_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_' + ic).text((parseFloat(stprc[3].replace(',', ''))).toFixed(2));
                }
                stxt += $('#' + firstSelId[ic]).text();
            }
            if (ic < (firstSelId.length - 1)) {
                stxt += ',';
            }
        }
		var mseatprice =0;
	 $('[id^="PaxSeatCH_"]').each(function () {
		  if ($(this).text() != '') {
			 mseatprice +=  parseFloat($(this).text());
		  }
	 });
	 $('.seat_charges .price').html('<i class="fa fa-rupee-sign"></i> '+mseatprice.toFixed(2));
		calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val(),$('#tev_we').val());
	});		
 var firstSelId = [];
  var isSeatChaning = false;
  var seatChaingID = '';
    var singlePaxSelection = false;
    var paxNoSelection = 0;
    var isBaseCheck = false;
$(document).delegate('[id^="FlSeat_"]', 'click', function(){
	//$('#departure_seat .table tr td').removeClass('selected');
	var _id = this.id;
        var spId = _id.split('_');
       // var cdId = 'cdPrc_' + spId[1] + '_Seg_' + spId[3];
      //  var prcID = _id.replace('FlSeat_', 'StPrc_');
	var seatprice = $(this).attr('seatprice');
	var seatcode = $(this).attr('seatcode');
	var per = $('.ticket_info .ticket_col').length;
	if ($(this).find('span').hasClass('occupied')) {
            alert('This seat is reserved. Please select another seat.');
            return false;
        }
	 if ($(this).find('span').hasClass('selected')) {
		 if (isSeatChaning) {
                if (_id == seatChaingID) {
                    // clear selected particular pax seat
                    for (var j = 0; j < firstSelId.length; j++) {
                        if (firstSelId[j] != '' && firstSelId[j] == seatChaingID) {
                            firstSelId[j] = '#';
                            seatChaingID = _id;
                            $(this).find('span').removeClass('selected');
                        }
                    }
                }
                else {
                    alert('This seat is reserved for another passenger. Please select another seat.');
                }
            }
            else {
                // remove seat and new seat                
                for (var j = 0; j < firstSelId.length; j++) {
                    if (firstSelId[j] != '' && firstSelId[j] == _id) {
                        firstSelId[j] = '#';
                    }
                }
                $(this).find('span').removeClass('selected');
            }
	 }else{
		 if (isSeatChaning) {
                if (seatChaingID == '') {
                    // click  on '-'  case                   
                    firstSelId[paxNoSelection] = _id;
                    seatChaingID = _id;
                    $(this).find('span').addClass('selected');

                }
                else {
                    // existing seat changing case
                    for (var a = 0; a < firstSelId.length; a++) {
                        if ((firstSelId[a] != '' && firstSelId[a] == seatChaingID) || (firstSelId[a] == '#' && a == paxNoSelection)) {
                            firstSelId[a] = _id;
                        }
                    }
                    $('#' + seatChaingID).find('span').removeClass('selected');
                    seatChaingID = _id;
                    $(this).find('span').addClass('selected');
                }
            }
			else {
					if (firstSelId.length < noAdCh) {
						firstSelId[firstSelId.length] = _id;
						console.log(firstSelId[0]);
					}else{
						var hashReplacemt = false;
						var hashIndex = 0;
						for (var i = 0; i < firstSelId.length; i++) {
							if (firstSelId[i] == '#') {
								hashReplacemt = true;
								hashIndex = i;
								break;
							}
						}
						if (hashReplacemt) {
							if (firstSelId[hashIndex] == '#') {
								firstSelId[hashIndex] = _id;
							}
						}
						else {
							
							$('#' + firstSelId[0]).find('span').removeClass('selected');
							var art = [];
							for (var i = 1; i < firstSelId.length; i++) {
								if (firstSelId[i] != '') {
									art[i - 1] = firstSelId[i];
								}
							}
							art[art.length] = _id;
							firstSelId = [];
							firstSelId = art;
						}
						
					}
				$(this).find('span').addClass('selected');
			}
	}
	 // Seat assignment and setting price  start   
        var t = 0;
        var bp = 0;
        var stxt = '';
        for (var ic = 0; ic < firstSelId.length; ic++) {
            if (firstSelId[ic] != '' && firstSelId[ic] == '#') {
                $('#PaxSeat_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_' + ic).html('-');
                $('.PaxSeat_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_' + ic).val('none');
                $('#PaxSeatCH_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_' + ic).text('0.00');
                if (isBaseCheck) {
                    $('#PaxSeatBaseCH_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_' + ic).text('0.00');
                }
                stxt += ' - ';
            }
            else {
                $('#PaxSeat_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_' + ic).html($('#' + firstSelId[ic]).attr('seatcode')).css('visibility','visible');
                $('.PaxSeat_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_' + ic).val($('#' + firstSelId[ic]).attr('id'));
                var liid = firstSelId[ic].replace('FlSeat_', 'StPrc_');
                var stprc = $('#' + liid).text().replace('Price : ', '').replace(' (', ' ').replace(')', ' ').split(' ');
                t += parseFloat(stprc[1].replace(',', ''));
                if (stprc.length > 2) {
                    bp += parseFloat(stprc[3].replace(',', ''));
                }
                $('#PaxSeatCH_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_' + ic).text((parseFloat(stprc[1].replace(',', ''))).toFixed(2));
                if (isBaseCheck) {
                    $('#PaxSeatBaseCH_' + spId[1] + '_Seg_' + spId[3] + '_paxCount_' + ic).text((parseFloat(stprc[3].replace(',', ''))).toFixed(2));
                }
                stxt += $('#' + firstSelId[ic]).text();
            }
            if (ic < (firstSelId.length - 1)) {
                stxt += ',';
            }
        }
		var mseatprice =0;
	 $('[id^="PaxSeatCH_"]').each(function () {
		  if ($(this).text() != '') {
			 mseatprice +=  parseFloat($(this).text());
		  }
	 });
	 $('.seat_charges .price').html('<i class="fa fa-rupee-sign"></i> '+mseatprice.toFixed(2));
		calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val(),$('#tev_we').val());
});

$(document).delegate('.showmeals', 'click', function(){
	var v = $(this).attr('name');
	if($('#'+v).hasClass('activebox')){
		
	$('#'+v).removeClass('activebox');
	$('#'+v).hide();
	}else{
		$('.service_req_sec_nseat').hide();
		$('.service_req_sec_nseat').removeClass('activebox');
	$('#'+v).addClass('activebox');
	$('#'+v).show('slow');
	}
	
});
$(document).delegate('.showbags', 'click', function(){
	var v = $(this).attr('name');
	if($('#'+v).hasClass('activebox')){
		
	$('#'+v).removeClass('activebox');
	$('#'+v).hide();
	}else{
		
		$('.service_req_sec_nseat').removeClass('activebox');
		$('.service_req_sec_nseat').hide();
	$('#'+v).addClass('activebox');
	$('#'+v).show('slow');
	}
});
$(document).delegate('.myfarerule', 'click', function(){
		$('#fareruleModal').modal('show');
		var rsindex = $(this).attr('resindex');
		var val = $('#firsttime').val();
		if(val == 0){
		$.ajax({
		   url:"{{URL::to('/agent/Flight/farerules/')}}",
		   method:'GET',
		   data:{resindex:rsindex, traceid:$(this).attr('traceid')},
		   success:function(data)
		   {
				$('.showfarerule').html(data);
				$('#firsttime').val(1);
		   }
		  });
		}
	});	

var minLength = 1; 
var maxLength = 32;	
$('.firstname').on('keydown keyup change', function(){
	 $(".custom-error").remove();
        var char = $(this).val();
        var charLength = $(this).val().length;
        if(charLength < minLength){
           
        }else if(charLength > maxLength){
          $(this).next('.cuserrormsg').html("<span class='custom-error' role='alert'>Enter maximum "+maxLength+" Alphabets </span>");
            $(this).val(char.substring(0, maxLength));
        }else{
              $(this).next('.cuserrormsg').html('');
			  $(".custom-error").remove();
        }
    });
	
	var fminLength = 2;
var fmaxLength = 32;	
$('.lastname').on('keydown keyup change', function(){
	 $(".custom-error").remove();
        var char = $(this).val();
        var charLength = $(this).val().length;
       if(charLength < fminLength){
           $(this).next('.fcuserrormsg').html("<span class='custom-error' role='alert'>Enter minimum "+fminLength+" Alphabets </span>");
        }else if(charLength > fmaxLength){
           $(this).next('.fcuserrormsg').html("<span class='custom-error' role='alert'>Enter maximum "+fmaxLength+" Alphabets </span>");
            $(this).val(char.substring(0, fmaxLength));
        }else{
             $(this).next('.fcuserrormsg').html('');
             $(".custom-error").remove();
        }
    });
	
	$("#phone").on("keypress keyup blur",function (event) {
		var data=$('#phone').val();
if(phone_validate(data)) 
     { 
      // $('.error_Msg').hide();  // hides error msg if validation is true
     } 
     else 
     { 
      $('#phone').val('');
     } 		
         
        });
		
		 function phone_validate(phno) 
{ 
  var regexPattern=new RegExp(/^[0-9]+$/);    // regular expression pattern
  return regexPattern.test(phno); 
} 


    //////////////GST Validation Start Part 1///////////////
    $('#gstNumber').bind("keyup", function () {
        this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
    });
    $('#gstContact').bind("keyup", function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#gstaddress').bind("keyup", function () {
        //Removes backslash
        this.value = this.value.replace(/[^A-Za-z0-9*=@#$&()\-`.+,\/ ]/g, '/');
    });
    $('#gstName').bind("keyup", function () {
        //Removes backslash
        this.value = this.value.replace(/[^A-Za-z0-9-. ]/g, '');
    });
    //////////////GST Validation End///////////////
	
});

	</script>
	<div id="mytravelModal" class="modal modal-lg fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Travel Protection</h4>
			  </div>
			  <div class="modal-body">
				<div class="row"> 
					<div class="col-md-12">
						<div class="text-center">
							<span class="logo-bharti-axa mt-1">
								<span class="fs-12">Insurance Provider</span>
							</span>
						</div>
						<table class="table-bordered mt-1">
							<thead>
							<tr>
								<th colspan="2"> Coverage </th>
								<th colspan="2"> INR <i class="fa fa-rupee-sign"></i></th>
							</tr>
							
							</thead>
							<tbody>
							@foreach(\App\TravelPlan::all() as $tlist)
								<tr>
									<td>{{$tlist->name}}</td>
									<td><i class="fa fa-rupee-sign"></i>{{$tlist->price}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			  </div>
			</div>
		</div>
	</div>
	<div id="fareruleModal" class="modal modal-lg fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Fare Rules</h4>
			  </div>
			  <div class="modal-body">
				<div class="row"> 
					<div class="col-md-12">
					<b>"Convenience Fee of Rs. 200 per ticket is applicable in addition to any fee mentioned under fare rules "</b>
						<input type="hidden" id="firsttime" isfirst="0">
					<div class="showfarerule term_list">
					<img src="{{URL::to('/public/img')}}/Ellipsis.gif">
					</div>
						
					</div>
				</div>
			  </div>
			</div>
		</div>
	</div>
	<div id="myModal" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Payment Method</h4>
								  </div>
								  <div class="modal-body">
										<div class="row"> 
											<div class="col-md-12">
												<?php $ccavenu = \App\MyConfig::where('meta_key','cc_status')->first(); ?>
												@if($ccavenu->meta_value == 1)
													<div class="form-group">
														<label class=""><input type="radio" class="paymethod"  name="paymentmethod" value="ccavenue"> <img src="{{URL::to('/public/icons/cc_avenue1.png')}}"> </label>
													</div>
												@endif
												<?php $rzavenu = \App\MyConfig::where('meta_key','rz_status')->first(); ?>
												@if($rzavenu->meta_value == 1)
													<div class="form-group">
														<label class=""><input checked class="paymethod" type="radio"  name="paymentmethod" value="razorpay"> <img style="width: 100px;height:23px;" src="{{URL::to('/public/icons/razorpay.jpg')}}"> </label>
													</div>
												@endif
											</div>
										</div>
								  </div>
								  <div class="modal-footer">
									
									<button class="pay_ticket" form="frm_Product"  type="submit">Submit</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								  </div>
								</div>

							  </div> 
							</div>
							
<div id="ModalConfirm" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Review your Booking</h4>
            </div>
            <div class="modal-body">
                    <div id="DivDeparture">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <i class="fa fa-paper-plane" aria-hidden="true"></i> DEPARTURE
                                <span></span>
                            </div>
                            <div class="panel-body">
                                <div class="col-sm-12 text-center">
									<?php
									if(isset($_GET['jt']) && $_GET['jt'] == 1){
										if(isset($resultdata[0]->Segments)){
											if(isset($_GET['jt']) && $_GET['jt'] == 1){
												$segments = $resultdata[0]->Segments;
											}else{
												if(@$_GET['isINT'] == 'true'){
													$segments = $resultdata[0]->Segments[0];
												}else{
													$segments = $resultdata[0]->Segments;
												}
											}
											foreach($segments as $slist){
												$ir = 0; 
												$res = $resultdata[0];
												if(isset($_GET['jt']) && $_GET['jt'] == 1){
														$countflighdata = count($slist); 
														$allflighdata = $slist;
													}else{
														
														$countflighdata = count($res->Segments[0]); 
														$allflighdata = $res->Segments[0];
													}
										for($fl =0;$fl<count($allflighdata);$fl++){
											
									?>
										<div class="row flight-list-main">
											<div class="col-md-12 col-sm-12 col-xs-13 text-center airline">
														<?php
		
			
			if ($fl != 0){
			if ($fl == 1){
				$datetime1 =  new \DateTime($allflighdata[0]->Destination->ArrTime);
		$datetime2 =  new \DateTime($allflighdata[1]->Origin->DepTime);
		$interval = $datetime1->diff($datetime2);
				
				
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo $interval->format('%h')."h ".$interval->format('%i')."m"; ?></span></div>
				</div>
			<?php
			}
			else if ($fl == 2)
			{
					$datetime1 =  new \DateTime($allflighdata[1]->Destination->ArrTime);
		$datetime2 =  new \DateTime($allflighdata[2]->Origin->DepTime);
		$interval = $datetime1->diff($datetime2);
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo $interval->format('%h')."h ".$interval->format('%i')."m"; ?></span></div>
				</div>
			<?php
			}else if ($fl == 3)
			{
				$datetime1 =  new \DateTime($allflighdata[2]->Destination->ArrTime);
		$datetime2 =  new \DateTime($allflighdata[3]->Origin->DepTime);
		$interval = $datetime1->diff($datetime2);
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo $interval->format('%h')."h ".$interval->format('%i')."m"; ?></span></div>
				</div>
			<?php
			}
			}
		
		?>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-3 text-center airline">
												<img src="{{URL::to('/public/img/airline/')}}/{{$allflighdata[$fl]->Airline->AirlineCode}}.gif" alt="{{$allflighdata[$fl]->Airline->AirlineName}}">
												<h6>{{$allflighdata[$fl]->Airline->AirlineName}}</h6>
												<small>{{$allflighdata[$fl]->Airline->AirlineCode}}-{{$allflighdata[$fl]->Airline->FlightNumber}}</small>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3 departure">
												<strong><i class="fa fa-clock-o" aria-hidden="true"></i> {{date('H:i', strtotime($allflighdata[$fl]->Origin->DepTime))}}</strong>
												<h5 class="bold">{{$allflighdata[$fl]->Origin->Airport->CityName}}</h5>
											</div>
											<div class="col-md-4 col-sm-4 col-xs-3 stop-duration">
												<div class="flight-direction"></div>
												<div class="stop"></div>
												
												<div class="duration text-center">
													<small>
														<i class="fa fa-clock mr-5"></i>
														<?php
					
					 $datetime1 =  new \DateTime($allflighdata[$fl]->Origin->DepTime);
					$datetime2 =  new \DateTime($allflighdata[$fl]->Destination->ArrTime);
					$interval = $datetime1->diff($datetime2);
					$time2 = $interval->format('%h')."h ".$interval->format('%i')."m";
					echo $time2;
				?>
													</small>
													 <small>Check-In: {{$allflighdata[$fl]->Baggage}}</small>
												</div>
											</div>
    <div class="col-md-3 col-sm-3 col-xs-3 destination">
        <strong><i class="fa fa-clock mr-5"></i> {{date('H:i', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</strong>
        <h5 class="bold">{{$allflighdata[$fl]->Destination->Airport->CityName}}</h5>
    </div>
	<div class="clearfix"></div>
    
</div>
										<?php 
											}
											}
										} 
									}else{
										if(isset($resultdata[0]->Segments)){
											if(isset($_GET['jt']) && $_GET['jt'] == 1){
												$segments = $resultdata[0]->Segments;
											}else{
												if(@$_GET['isINT'] == 'true'){
													$segments = $resultdata[0]->Segments[0];
												}else{
													$segments = $resultdata[0]->Segments;
												}
											}
											//foreach($segments as $slist){
												$ir = 0;
												$res = $resultdata[0];
												if(isset($_GET['jt']) && $_GET['jt'] == 1){
														$countflighdata = count($slist); 
														$allflighdata = $slist;
													}else{
														
														$countflighdata = count($res->Segments[0]); 
														$allflighdata = $res->Segments[0];
													}
										for($fl =0;$fl<count($allflighdata);$fl++){
											
									?>
										<div class="row flight-list-main">
											<div class="col-md-12 col-sm-12 col-xs-13 text-center airline">
														<?php
		if($res->IsLCC == 1){
		//echo $allflighdata[$fl]->GroundTime;
			if($allflighdata[$fl]->GroundTime != 0){
				$minutes = $allflighdata[$fl]->GroundTime;
				$hours = floor($minutes / 60);
				$min = $minutes - ($hours * 60);
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo @$hours.'h : '.@$min.'m'; ?></span></div>
				</div>
			<?php
			}
		}else{
			
			if ($fl != 0){
			if ($fl == 1){
				$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[0]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[1]->Origin->DepTime));
				$date1Timestamp = strtotime($arTime);
$date2Timestamp = strtotime($DepTime);
 $delta_T = ($date2Timestamp - $date1Timestamp);
//Calculate the difference.
$hours = round((($delta_T % 604800) % 86400) / 3600); 
$minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
				
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo @$hours.'h : '.@$minutes.'m'; ?></span></div>
				</div>
			<?php
			}
			else if ($fl == 2)
			{
				$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[1]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[2]->Origin->DepTime));
								$date1Timestamp = strtotime($arTime);
$date2Timestamp = strtotime($DepTime);
 $delta_T = ($date2Timestamp - $date1Timestamp);
//Calculate the difference.
$hours = round((($delta_T % 604800) % 86400) / 3600); 
$minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo @$hours.'h : '.@$minutes.'m'; ?></span></div>
				</div>
			<?php
			}else if ($fl == 3)
			{
				$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[2]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[3]->Origin->DepTime));
								$date1Timestamp = strtotime($arTime);
$date2Timestamp = strtotime($DepTime);
 $delta_T = ($date2Timestamp - $date1Timestamp);
//Calculate the difference.
$hours = round((($delta_T % 604800) % 86400) / 3600); 
$minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo @$hours.'h : '.@$minutes.'m'; ?></span></div>
				</div>
			<?php
			}
			}
		}
		
		?>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-3 text-center airline">
												<img src="{{URL::to('/public/img/airline/')}}/{{$allflighdata[$fl]->Airline->AirlineCode}}.gif" alt="{{$allflighdata[$fl]->Airline->AirlineName}}">
												<h6>{{$allflighdata[$fl]->Airline->AirlineName}}</h6>
												<small>{{$allflighdata[$fl]->Airline->AirlineCode}}-{{$allflighdata[$fl]->Airline->FlightNumber}}</small>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3 departure">
												<strong><i class="fa fa-clock-o" aria-hidden="true"></i> {{date('H:i', strtotime($allflighdata[$fl]->Origin->DepTime))}}</strong>
												<h5 class="bold">{{$allflighdata[$fl]->Origin->Airport->CityName}}</h5>
											</div>
											<div class="col-md-4 col-sm-4 col-xs-3 stop-duration">
												<div class="flight-direction"></div>
												<div class="stop"></div>
												
												<div class="duration text-center">
													<small>
														<i class="fa fa-clock mr-5"></i>
														<?php
					
					 $datetime1 =  new \DateTime($allflighdata[$fl]->Origin->DepTime);
					$datetime2 =  new \DateTime($allflighdata[$fl]->Destination->ArrTime);
					$interval = $datetime1->diff($datetime2);
					$time2 = $interval->format('%h')."h ".$interval->format('%i')."m";
					echo $time2;
				?>
													</small>
													 <small>Check-In: {{$allflighdata[$fl]->Baggage}}</small>
												</div>
											</div>
    <div class="col-md-3 col-sm-3 col-xs-3 destination">
        <strong><i class="fa fa-clock mr-5"></i> {{date('H:i', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</strong>
        <h5 class="bold">{{$allflighdata[$fl]->Destination->Airport->CityName}}</h5>
    </div>
	<div class="clearfix"></div>
    
</div>
										<?php 
											}
											//}
										}
															}										?>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php if(@$_GET['isINT'] == 'true'){ 
					if(isset($resultdata[0]->Segments[1])){
					?>
					<div class="DivReturn">
						<div class="panel panel-primary">
                            <div class="panel-heading">
                                <i class="fa fa-paper-plane" aria-hidden="true"></i> Return
                                <span></span>
                            </div>
                            <div class="panel-body">
                                <div class="col-sm-12 text-center">
									<?php
										
											$ir = 0;
											$res = $resultdata[0];
											$countflighdata = count($res->Segments[1]); 
											$allflighdata = $res->Segments[1];
										
										for($fl =0;$fl<count($allflighdata);$fl++){
									?>
										<div class="row flight-list-main">
										<div class="col-md-12 col-sm-12 col-xs-13 text-center airline">
														<?php
	
			
			if ($fl != 0){
			if ($fl == 1){
				$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[0]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[1]->Origin->DepTime));
				$datetime1 =  new \DateTime($allflighdata[0]->Destination->ArrTime);
		$datetime2 =  new \DateTime($allflighdata[1]->Origin->DepTime);
		$interval = $datetime1->diff($datetime2);
				
				
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo $interval->format('%h')."h ".$interval->format('%i')."m"; ?></span></div>
				</div>
			<?php
			}
			else if ($fl == 2)
			{
				//$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[1]->Destination->ArrTime));
				//$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[2]->Origin->DepTime));
							$datetime1 =  new \DateTime($allflighdata[1]->Destination->ArrTime);
		$datetime2 =  new \DateTime($allflighdata[2]->Origin->DepTime);
		$interval = $datetime1->diff($datetime2);
				
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo $interval->format('%h')."h ".$interval->format('%i')."m"; ?></span></div>
				</div>
			<?php
			}else if ($fl == 3)
			{
				$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[2]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[3]->Origin->DepTime));
							$datetime1 =  new \DateTime($allflighdata[2]->Destination->ArrTime);
		$datetime2 =  new \DateTime($allflighdata[3]->Origin->DepTime);
		$interval = $datetime1->diff($datetime2);
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo $interval->format('%h')."h ".$interval->format('%i')."m"; ?></span></div>
				</div>
			<?php
			}
			}
		//}
		
		?>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-3 text-center airline">
												<img src="{{URL::to('/public/img/airline/')}}/{{$allflighdata[$fl]->Airline->AirlineCode}}.gif" alt="{{$allflighdata[$fl]->Airline->AirlineName}}">
												<h6>{{$allflighdata[$fl]->Airline->AirlineName}}</h6>
												<small>{{$allflighdata[$fl]->Airline->AirlineCode}}-{{$allflighdata[$fl]->Airline->FlightNumber}}</small>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3 departure">
												<strong><i class="fa fa-clock-o" aria-hidden="true"></i> {{date('H:i', strtotime($allflighdata[$fl]->Origin->DepTime))}}</strong>
												<h5 class="bold">{{$allflighdata[$fl]->Origin->Airport->CityName}}</h5>
											</div>
											<div class="col-md-4 col-sm-4 col-xs-3 stop-duration">
												<div class="flight-direction"></div>
												<div class="stop"></div>
												
												<div class="duration text-center">
													<small>
														<i class="fa fa-clock mr-5"></i>
														<?php
					
					 $datetime1 =  new \DateTime($allflighdata[$fl]->Origin->DepTime);
					$datetime2 =  new \DateTime($allflighdata[$fl]->Destination->ArrTime);
					$interval = $datetime1->diff($datetime2);
					$time2 = $interval->format('%h')."h ".$interval->format('%i')."m";
					echo $time2;
				?>
													</small>
												</div>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3 destination">
												<strong><i class="fa fa-clock mr-5"></i> {{date('H:i', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</strong>
												<h5 class="bold">{{$allflighdata[$fl]->Destination->Airport->CityName}}</h5>
											</div>
											<div class="clearfix"></div>
											<div class="col-sm-12">
												<small>Check-In: {{$allflighdata[$fl]->Baggage}}</small>
											</div>
											
										</div>
										<?php 
										
											}
										 ?>
                                </div>
                            </div>
                        </div>
					</div>
					<?php } 
					}else{
						$is_return = 0;  
						if(!empty($resultdataib)){ 
							if(isset($resultdataib[0]->Segments[0])){
							$is_return = 1;
							$resarrive = $resultdataib[0];
							$allflighdata = $resarrive->Segments[0];
						?>
							<div class="DivReturn">
						<div class="panel panel-primary">
                            <div class="panel-heading">
                                <i class="fa fa-paper-plane" aria-hidden="true"></i> Return
                                <span></span>
                            </div>
                            <div class="panel-body">
                                <div class="col-sm-12 text-center">
									<?php 
										for($fl =0;$fl<count($allflighdata);$fl++){
									?>
									
										<div class="row flight-list-main">
										<div class="col-md-12 col-sm-12 col-xs-13 text-center airline">
														<?php
		if($res->IsLCC == 1){
		//echo $allflighdata[$fl]->GroundTime;
			if($allflighdata[$fl]->GroundTime != 0){
				$minutes = $allflighdata[$fl]->GroundTime;
				$hours = floor($minutes / 60);
				$min = $minutes - ($hours * 60);
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo @$hours.'h : '.@$min.'m'; ?></span></div>
				</div>
			<?php
			}
		}else{
			
			if ($fl != 0){
			if ($fl == 1){
				$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[0]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[1]->Origin->DepTime));
				$date1Timestamp = strtotime($arTime);
$date2Timestamp = strtotime($DepTime);
 $delta_T = ($date2Timestamp - $date1Timestamp);
//Calculate the difference.
$hours = round((($delta_T % 604800) % 86400) / 3600); 
$minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
				
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo @$hours.'h : '.@$minutes.'m'; ?></span></div>
				</div>
			<?php
			}
			else if ($fl == 2)
			{
				$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[1]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[2]->Origin->DepTime));
								$date1Timestamp = strtotime($arTime);
$date2Timestamp = strtotime($DepTime);
 $delta_T = ($date2Timestamp - $date1Timestamp);
//Calculate the difference.
$hours = round((($delta_T % 604800) % 86400) / 3600); 
$minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo @$hours.'h : '.@$minutes.'m'; ?></span></div>
				</div>
			<?php
			}else if ($fl == 3)
			{
				$arTime = date('Y-m-d h:i:s a', strtotime($allflighdata[2]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($allflighdata[3]->Origin->DepTime));
								$date1Timestamp = strtotime($arTime);
$date2Timestamp = strtotime($DepTime);
 $delta_T = ($date2Timestamp - $date1Timestamp);
//Calculate the difference.
$hours = round((($delta_T % 604800) % 86400) / 3600); 
$minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
				?>
				<div class="layover_time">
					<div class="layover_txt">Layover:<span><?php echo @$hours.'h : '.@$minutes.'m'; ?></span></div>
				</div>
			<?php
			}
			}
		}
		
		?>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-3 text-center airline">
												<img src="{{URL::to('/public/img/airline/')}}/{{$allflighdata[$fl]->Airline->AirlineCode}}.gif" alt="{{$allflighdata[$fl]->Airline->AirlineName}}">
												<h6>{{$allflighdata[$fl]->Airline->AirlineName}}</h6>
												<small>{{$allflighdata[$fl]->Airline->AirlineCode}}-{{$allflighdata[$fl]->Airline->FlightNumber}}</small>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3 departure">
												<strong><i class="fa fa-clock-o" aria-hidden="true"></i> {{date('H:i', strtotime($allflighdata[$fl]->Origin->DepTime))}}</strong>
												<h5 class="bold">{{$allflighdata[$fl]->Origin->Airport->CityName}}</h5>
											</div>
											<div class="col-md-4 col-sm-4 col-xs-3 stop-duration">
												<div class="flight-direction"></div>
												<div class="stop"></div>
												
												<div class="duration text-center">
													<small>
														<i class="fa fa-clock mr-5"></i>
														<?php
					
					 $datetime1 =  new \DateTime($allflighdata[$fl]->Origin->DepTime);
					$datetime2 =  new \DateTime($allflighdata[$fl]->Destination->ArrTime);
					$interval = $datetime1->diff($datetime2);
					$time2 = $interval->format('%h')."h ".$interval->format('%i')."m";
					echo $time2;
				?>
													</small>
													 <small>Check-In: {{$allflighdata[$fl]->Baggage}}</small>
												</div>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3 destination">
												<strong><i class="fa fa-clock mr-5"></i> {{date('H:i', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</strong>
												<h5 class="bold">{{$allflighdata[$fl]->Destination->Airport->CityName}}</h5>
											</div>
											<div class="clearfix"></div>
											
										</div>
										<?php 
											}
											}
										 ?>
                                </div>
                            </div>
                        </div>
					</div>
						<?php
					}
					}
					

					?>
                    <div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <i class="fa fa-user" aria-hidden="true"></i> Passenger Details
                            </div>
                            <div class="panel-body">
                                <div class="col-sm-12">
                                    <ol class="pesdetail">
										<?php
										for($a =0; $a<$hfAdultCount; $a++){
										?>
                                         <li><label style="font-size: 16px;" id="lblAdult{{$a}}"></label></li>
										<?php } ?>
										<?php
										for($b =0; $b<$hfChildCount; $b++){
										?>
                                         <li><label style="font-size: 16px;" id="lblChild{{$b}}"></label></li>
										<?php } ?>
										<?php
										for($c =0; $c<$hfInfantCount; $c++){
										?>
                                         <li><label style="font-size: 16px;" id="lblInfant{{$c}}"></label></li>
										<?php } ?>
                                     </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <i class="fa fa-envelope" aria-hidden="true"></i> Contact Details
                            </div>
                            <div class="panel-body">
                                <div class="col-sm-6 text-center">
                                    <h6>
                                        Email :
                                        <label id="lblEmail"></label>
                                    </h6>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <h6>
                                        Mobile :
                                        <label id="lblMobile"></label>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <i class="fa fa-rupee" aria-hidden="true"></i> Fare Details
                                <span class="pull-right">
                                    Total Fare :
                                    <span id="lblTotalFare"></span>
                                </span>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <span class="pull-left"><button type="button" class="btn btn-default btnCoupon cancel_btn" data-dismiss="modal">Cancel & return</button></span>
                <span class="pull-right"><button form="frm_Product"  type="submit" class="btn btn-primary btnCoupon" >Confirm and Continue</button></span>
            </div>
        </div>
    </div>
</div>
@endsection