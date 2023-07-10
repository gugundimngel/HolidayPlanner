@extends('layouts.frontend')
@section('title', @$seoDetails->meta_title)
@section('meta_title', '')
@section('meta_keyword', '')
@section('meta_description', '')
@section('bodyclass', 'ch single-page page-search')
@section('content')
<?php use App\Http\Controllers\Controller;
//echo ''; print_r($flightresult); die;
?>
<style>
.secflight_details_info{display:none;}
</style>
<!--<div class="flight_loader">
<div class="inner_loader">
<h4>Please wait....</h4>
<p><i class="fa fa-spinner" aria-hidden="true"></i> We are looking for the best flight for you.</p>
</div>
</div> -->
<section id="content">
<div id="content-wrap">
<!-- === Section Flat =========== -->
<div class="section-flat single_sec_flat">					
<div class="section-content"> 
<div class="container">
<div class="row">  
<div class="col-md-12 pos_static">	
<!--<div class="fli_detail hide_desktop">
<h4><i class="fa fa-arrow-left arrow_lg"></i> Delhi <i class="fa fa-arrow-right arrow_sm"></i> Mumbai</h4>
<span>Thu 02-Jul | 1 Adult</span>
</div>-->
<div class="search_flight hide_desktop">
<a href="javascript:;"><i class="fa fa-search"></i> Modify Search</a>
</div>
<div class="clearfix"></div>
<div class="banner-reservation-tabs custom_reservation_tab search_mobile">
<div class="close_flight hide_desktop">
<a href="javascript:;"><i class="fa fa-times"></i></a>
</div> 

<ul class="br-tabs">
<?php 
$srch = Request::get('srch'); 
$px = Request::get('px'); 
$mytravlercount = explode('-', $px);
$mtcount = 0;
for($mit =0; $mit<count($mytravlercount); $mit++){
$mtcount += $mytravlercount[$mit];
}
$cbn = Request::get('cbn'); 
$nt = Request::get('nt'); 
$explodesearc = explode('|', $srch);
$originexplode = explode('-', $explodesearc[0]);
$desexplode = explode('-', $explodesearc[1]);
$datedeparture = date('Y-m-d', strtotime($explodesearc[2]));

$explodepass = explode('-', $px);
$depdatye = explode('/', $explodesearc[2]);
$datedeparture = $depdatye[2].'-'.$depdatye[1].'-'.$depdatye[0];
$retdatye = explode('/', $explodesearc[3]);
$datereturn = $retdatye[2].'-'.$retdatye[1].'-'.$retdatye[0];
?>
<li <?php if(isset($_GET['jt']) && $_GET['jt'] == 1) { ?> class="active" <?php } ?> dataway="oneway"><a href="javascript:;">One Way</a></li>
<li  class="roundtriptab <?php if(isset($_GET['jt']) && $_GET['jt'] == 2) { ?> active <?php } ?>" dataway="roundtrip"><a href="javascript:;">Round Trip</a></li>
<!--<li <?php /* if(isset($_GET['jt']) && $_GET['jt'] == 3) { ?> class="active" <?php } */ ?> dataway="multicity"><a href="javascript:;">Multi City</a></li>-->
</ul><!-- .br-tabs end -->

<ul class="br-tabs-content" style="height: 100%;">
<li class="active" style="display: list-item;">
<div class="ismultipleway">
<form action="{{URL::to('/FlightList/index')}}" class="form-banner-reservation form-inline style-2 form-h-40">
<div class="form-group loc_search_field cus_loc_field">
<input type="hidden" id="roundfromsearch" value="{{@$explodesearc[0]}}">
<input type="hidden" id="journey_type" value="{{@$_GET['jt']}}">
<input style="cursor: text;" autocomplete="off" type="text" name="roundwayfrmtext" id="fromdest_show" class="roundwayfrom form-control wrapper-dropdown-2" placeholder="From" value="{{@$originexplode[1]}}({{@$originexplode[0]}})">
<i class="fas fa-plane"></i>
<div class="location_search selhide" id="location_search">
<div class="inner_loc_search">
<div class="top_city">
	<span>Top Cities</span>
</div>
<ul class="is_search_from_val">
@foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $alist)
	<li roundwayfromtop="{{$alist->city_code}}-{{$alist->city_name}}-{{$alist->country_name}}" roundwayfrom="{{$alist->city_name}}({{$alist->city_code}})">
		<div class="fli_name"><i class="fa fa-plane"></i> {{$alist->city_name}} ({{$alist->city_code}})</div>
		<div class="airport_name">{{$alist->airport_name}}<span>{{$alist->country_name}}</span></div>
	</li>
@endforeach
</ul>
</div>
</div>
<div id="swap" onclick="SwapRoundDestination();" class="swipe single_swipe"></div>
</div><!-- .form-group end -->
<div class="form-group loc_search_field_to cus_loc_field">
<input type="hidden" id="roundtosearch" value="{{@$explodesearc[1]}}">
<input style="cursor: text;" autocomplete="off" type="text" name="roundwaytotext" id="todest_show" class="roundwayto form-control wrapper-dropdown-3" placeholder="To" value="{{@$desexplode[1]}}({{@$desexplode[0]}})">
<i class="fas fa-plane"></i>
<div class="location_search_to selhide" id="location_search_to">
<div class="inner_loc_search">
<div class="top_city">
	<span>Top Cities</span>
</div>
<ul class="is_search_to_val">
@foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $elist)
	<li roundwaytotop="{{$elist->city_code}}-{{$elist->city_name}}-{{$elist->country_name}}" roundwayto="{{$elist->city_name}}({{$elist->city_code}})">
		<div class="fli_name"><i class="fa fa-plane"></i> {{$elist->city_name}} ({{$elist->city_code}})</div>
		<div class="airport_name">{{$elist->airport_name}}<span>{{$elist->country_name}}</span></div>
	</li>
@endforeach
</ul>
</div>
</div>
</div><!-- .form-group end -->
<div class="form-group cus_calendar_field">
<input autocomplete="off" type="text" value="{{@$explodesearc[2]}}" name="brTimeStart" value="" class="form-control" id="datepicker-time-start"
placeholder="2019/09/30">
<i class="far fa-calendar"></i>
</div><!-- .form-group end -->
<div class="form-group cus_calendar_field" style="<?php if(isset($_GET['jt']) && $_GET['jt'] != 2) { ?>opacity: 0.4;<?php } ?>">
<input autocomplete="off" <?php if(isset($_GET['jt']) && $_GET['jt'] != 2) { ?>  <?php }else{ echo 'readonly'; } ?> type="text" value="{{@$explodesearc[3]}}" name="brTimeEnd" value="" class="form-control if_oneway_trip roundtripenable" id="datepicker-time-end"
placeholder="2019/09/30">
<i class="far fa-calendar"></i>
</div><!-- .form-group end -->
<div class="form-group roundtrip cus_passenger_field">
<?php $no_pessa = $explodepass[0] + $explodepass[1] + $explodepass[2]; ?>
<input autocomplete="off" type="text" id="roundpessanger" name="brPassengerNumber" class="form-control show-dropdown-passengers roundpessanger"
placeholder="Passengers" value="{{$no_pessa}} Passengers">
<i class="fas fa-user"></i>
<ul class="list-dropdown-passengers">
<li>
<ul class="list-persons-count">
	<li>
		<span>Adults:</span>
		<div class="counter-add-item">
			<a class="decrease-btn" href="javascript:;">-</a>
			<input id="roundadult" class="onewayadult" type="text" value="{{$explodepass[0]}}">
			<a class="increase-btn" href="javascript:;">+</a>
		</div><!-- .counter-add-item end -->
	</li>
	<li>
		<span>Childs:</span>
		<div class="counter-add-item">
			<a class="decrease-btn" href="javascript:;">-</a>
			<input id="roundchild" class="onewaychild" type="text" value="{{$explodepass[1]}}">
			<a class="increase-btn" href="javascript:;">+</a>
		</div><!-- .counter-add-item end -->
	</li>
	<li>
		<span>Infants:</span>
		<div class="counter-add-item">
			<a class="decrease-btn" href="javascript:;">-</a>
			<input id="roundinfant" class="onewayinfants" type="text" value="{{$explodepass[2]}}">
			<a class="increase-btn" href="javascript:;">+</a>
		</div><!-- .counter-add-item end -->
	</li>
</ul><!-- .list-persons-count end -->
</li>
<li>
<a class="btn-reservation-passengers btn x-small colorful hover-dark"
	href="javascript:;">Done</a>
</li>
</ul><!-- .list-dropdown-passengers end -->
</div><!-- .form-group end -->
<div class="form-group cus_searchbtn_field">
<button type="button" class="form-control roundformsearch icon"><i class="fas fa-search"></i> Search Flights</button>
</div><!-- .form-group end -->
<div class="clearfix"></div>
<a style="display:none;" class="if_multicity_trip btn-multiple-destinations btn x-small colorful hover-dark" href="javascript:;">
<i class="fas fa-plus"></i>
Add Another Flight
</a>
</form><!-- .form-banner-reservation end -->
</div>
</li>

</ul><!-- .br-tabs-content end -->
<div class="advanced_option round_advance_search"><a href="javascript:;">Advanced Option <i class="fa fa-plus"></i></a>
<ul class="list-select-grade list_grade">
<li>
<label class="radio-container radio-default">
<input class="roundseatclass" value="2" <?php if($cbn == 2){ echo 'checked'; } ?> type="radio" checked="checked" name="radio">
<span class="checkmark"></span>
Economy
</label>
</li>
<li>
<label class="radio-container radio-default">
<input class="roundseatclass" value="3" type="radio" <?php if($cbn == 3){ echo 'checked'; } ?> name="radio">
<span class="checkmark"></span>
Premium Economy
</label>
</li>
<li>
<label class="radio-container radio-default">
<input class="roundseatclass" value="4" <?php if($cbn == 4){ echo 'checked'; } ?> type="radio" name="radio">
<span class="checkmark"></span>
Business
</label>
</li>
<li>
<label class="radio-container radio-default">
<input class="roundseatclass" value="6" <?php if($cbn == 6){ echo 'checked'; } ?> type="radio"  name="radio">
<span class="checkmark"></span>
First
</label>
</li> 
<li>
<label class="label-container checkbox-default">
<span>Nonstop</span>
<input id="roundis_non_stop" value="1" <?php if($nt == 1){ echo 'checked'; } ?> type="checkbox">
<span class="checkmark"></span>
</label>
</li>
</ul><!-- .list-select-grade end -->
</div>
<div class="clearfix"></div>
</div><!-- .banner-reservation-tabs end -->

</div><!-- .col-md-12 end -->

<div class="col-md-12">									
<div class="page-single-content sidebar-left mt-10 roundtrip_search custom_page_search">
<div class="row">
@if(@$flightresult->Response->Error->ErrorCode != 0)
<div class="container">
<div class="row">
<div class="col-md-12">	
<p>{{$flightresult->Response->Error->ErrorMessage}}</p>
</div>
</div>
</div>
@else


<div class="col-lg-9 col-md-9 col-lg-push-3 col-md-push-3 col-sm-12"> 
<div class="row">											
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col_pull_6 cus_col_6">
<div class="content-main">
<div class="block_content roundtrip_header">
<ul>
	<li class="flight_name">{{@$source}} <i class="fa fa-arrow-right"></i> {{@$destin}}</li>
	<li class="date">{{date('D-d M Y', strtotime($datedeparture))}}</li>
	<li class="prev_next_btn"><a id="lnkOutBoundPrevDay" href="javascript:;">Previous Day</a><span></span>
<?php
	if(strtotime($datedeparture) < strtotime($datereturn)){
?>
	<a id="lnkOutBoundNextDay" href="javascript:;">Next Day</a>
	<?php }else{
		?>
		<a id="" href="javascript:;">Next Day</a>
		<?php
	} ?>
	</li>
</ul>
<div class="clearfix"></div>
</div>
<div class="block_content">
<div class="flight_info">
	<ul>
		<li><a onclick="AirlineSortRoundOneWay()" href="javascript:;">Airlines <i class="airsorta fa fa-arrow-up" ></i><i style="display:none;" class="airsortd fa fa-arrow-down"></i></a><input type="hidden" id="airsorting" value="descending"></li>
		<li><a onclick="DepartSortRoundOneWay()" href="javascript:;">Depart <i class="depasorta fa fa-arrow-up" ></i><i style="display:none;" class="depasortd fa fa-arrow-down"></i></a><input type="hidden" id="depasorting" value="descending"></li>
		<li><a onclick="DurationSortRoundOneWay()" href="javascript:;">Duration <i class="durasorta fa fa-arrow-up" ></i><i style="display:none;" class="durasortd fa fa-arrow-down"></i></a><input type="hidden" id="durasorting" value="descending"></li>
		<li><a onclick="ArriveSortRoundOneWay()" href="javascript:;">Arrive <i class="arriveasorta fa fa-arrow-up" ></i><i style="display:none;" class="arrivesortd fa fa-arrow-down"></i></a><input type="hidden" id="arrivesorting" value="descending"></li>
		<li class="price_control"><a onclick="PriceSortDRTO()" href="javascript:;">Price <i class="pricesorta fa fa-arrow-up" ></i><i style="display:none;" class="pricesortd fa fa-arrow-down"></i></a><input type="hidden" id="pricesorting" value="descending"></li>
		<li></li>
	</ul>
	<div class="clearfix"></div>
</div>
</div>
<div class="round_trip_list" id="bingo_width">
<?php 
$flightonwar = array();
if(isset($flightresult->Response->Results[0])){
	foreach($flightresult->Response->Results[0] as $flightr)
	{
		$segments = $flightr->Segments[0][0];
		
		$flightonwar[$segments->Airline->AirlineCode.$segments->Airline->FlightNumber][] = $flightr;
		
	}
}

$flightreturn = array();
if(isset($flightresult->Response->Results[1])){
	foreach($flightresult->Response->Results[1] as $retflight)
	{
		$segmentss = $retflight->Segments[0][0];
		
		$flightreturn[$segmentss->Airline->AirlineCode.$segmentss->Airline->FlightNumber][] = $retflight;
		
	}
}
$irs = 0;
$dataarray = array();
$dataairlinearray = array();
$dataairlineprice = array();
$dataairlinedeparttime = array();
$dataairlinecraftarray = array();
$returndataarray = array();
$returndataairlinearray = array();
$returndataairlineprice = array();
$returndataairlinedeparttime = array();
$returndataairlinecraftarray = array();
foreach($flightonwar as $flightdeti){ 
	$countmore = count($flightdeti);
	$flight = $flightdeti[0];
	$moreflight = $flightdeti;
	$segments = $flight->Segments[0][0];
	$bagagesegments = $flight->Segments[0];
	$D_TIME = date('H:i', strtotime($segments->Origin->DepTime));
	$A_TIME = date('H:i', strtotime($segments->Destination->ArrTime));
	$timedep = explode(':', $D_TIME);
	$timearr = explode(':', $A_TIME);
	$totaldepSecs   = ($timedep[0] * 60) + $timedep[1]; 
	$totalarvSecs   = ($timearr[0] * 60) + $timearr[1]; 

	$countflighdata = count($flight->Segments[0]); 
	$ti = $countflighdata -1;

	$depdatetime = $segments->Origin->DepTime;
	$arrdatetime = $flight->Segments[0][$ti]->Destination->ArrTime;
	$datetime1 =  new \DateTime($depdatetime);
	$datetime2 =  new \DateTime($arrdatetime);
	$interval = $datetime1->diff($datetime2);
	$time2 = $interval->format('%h').":".$interval->format('%i');
	$time2s = $interval->format('%h')."h:".$interval->format('%i').'m';
	$timeDUR = explode(':', @$time2); 
	$totaldurSecs   = ($timeDUR[0] * 60) + $timeDUR[1]; 

	$newtotal = $flight->Fare->PublishedFare;
	$offtotal = $flight->Fare->OfferedFare;
	$FareClassificationtype = @$flight->FareClassification;
	$oldwtotal = $flight->Fare->PublishedFare;
	$oldofftotal = $flight->Fare->OfferedFare;
	
	$F_NAME = $segments->Airline->AirlineName;
	$STOP = count($flight->Segments[0]) -1;

	$dataairlinearray[$segments->Airline->AirlineCode] = array(
			'AirLineName' =>$segments->Airline->AirlineName
	);
	$markupd =0;
	$submark =0;
	$markupamt = \App\Markup::where('flight_code',$segments->Airline->AirlineCode)->where('user_type', 'b2c')->where('flight_type', 'domestic')->first(); 
	if($markupamt){
	if($markupamt->service_type == 'fixed'){
	$markupd =  $markupamt->service_fee * $mtcount;
	}else{
	$markupd = ($offtotal * $markupamt->service_fee/100)  * $mtcount;
	}
	$mark = $offtotal + $markupd;
	$submark = $mark - $newtotal;
	}
	if($submark < 0){
	$newtotal = round($newtotal + $submark);
	}else{
	$newtotal = round($newtotal + $submark);
	}
	$service_fees = \App\MyConfig::where('meta_key','service_fees')->first();
	$service_type = \App\MyConfig::where('meta_key','service_type')->first();
	if($service_type->meta_value == 'fixed'){
	$mv =  $service_fees->meta_value;
	}else{
	$mv = ($newtotal * $service_fees->meta_value/100);
	}		
	$dataairlineprice[] = round($newtotal + $mv);
?>
<div class="refendable11 refendable11return" refendable="" test_org_cust="" test_org_pub="" >
<div class="price1" price="<?php echo round( $newtotal + $mv); ?>" data-price="<?php echo round( $newtotal + $mv); ?>" data-arrtime="{{$totalarvSecs}}" data-duration="{{@$totaldurSecs}}" data-deptime="{{$totaldepSecs}}" data-flight="{{@$segments->Airline->AirlineCode}}">
<div class="price111 price111onword" timedep="{{@$timedep[0]}}" timearr="{{@$timearr[0]}}">
<div class="flight11" flight="{{@$segments->Airline->AirlineCode}}">
<div class="flight112" flightcraft="{{@$segments->Craft}}"> 
<div class="stopscount" stop="{{$STOP}}">

<div id="div{{$flight->ResultIndex}}" attrtime="{{date('H:i:s', strtotime($segments->Origin->DepTime))}}" class="Price{{round($newtotal)}} allshow block-content-2 custom_block_content flight-list-v2 DRTFilter {{@$segments->Airline->AirlineCode}} {{$F_NAME}} 0Stops bingo_button_4">
<div class="box-result custom_box_result">
<ul class="list-search-result result_list">
<li>
<img src="{{URL::to('/public/img/airline/')}}/{{@$segments->Airline->AirlineCode}}.gif" alt="">
<div class="flight_name obflight_name hide_mob">
{{$F_NAME}}
<span class="flight_no">{{@$segments->Airline->AirlineCode}}-{{$segments->Airline->FlightNumber}}</span></div>
<div class="flight_name hide_desk">
<span class="flight_no">{{@$segments->Airline->AirlineCode}}-{{$segments->Airline->FlightNumber}}</span>
</div>
</li>
<li class="pad_left10">
<span class="date departdate">{{date('H:i', strtotime($segments->Origin->DepTime))}}</span>
{{$segments->Origin->Airport->CityName}}
</li>
<li>
<span class="duration departdur"><?php echo Controller::GetFlightTimeduration($flight->Segments[0]); ?><span> 
@if(count($flight->Segments[0]) > 1)

<div class="cus_tooltip"><?php echo count($flight->Segments[0])-1; ?> stop
<span class="tooltiptext">
<?php for($rr = 0;$rr<$ti; $rr++){ ?>
{{$flight->Segments[0][$rr]->Destination->Airport->AirportName}}
<br>
<?php } ?>
</span>
</div>	
@else 
non-stop
@endif
</span>

</span>
</li>
<li class="pad_left10">
<span class="date arivedate">{{date('H:i', strtotime($flight->Segments[0][$ti]->Destination->ArrTime))}}</span>
{{$flight->Segments[0][$ti]->Destination->Airport->CityName}}	
</li>
<li class="price priced ">
<i class="fa fa-rupee-sign"></i>
<span class="airlineprice">
<span class="mainprice">
{{round( $newtotal + $mv)}}
</span>
</span>
</li>  
<li class="round_check">
<div class="checkbox-default">
<input <?php if($irs == 0){ echo 'checked'; } ?> name="inbound" onclick="InboundResullt('{{$segments->Airline->AirlineCode}}','{{$segments->Airline->AirlineName}}','{{$segments->Airline->FlightNumber}}','{{date('H:i', strtotime($segments->Origin->DepTime))}}','{{$segments->Origin->Airport->AirportCode}}','{{date('H:i', strtotime($flight->Segments[0][$ti]->Destination->ArrTime))}}','{{$flight->Segments[0][$ti]->Destination->Airport->AirportCode}}','{{round($newtotal + $mv)}}','{{$flight->ResultIndex}}','{{$flight->IsLCC}}')" type="radio" >
<span class="checkboxmark"></span>
</div>
</li>
</ul><!-- .list-search-result end -->
<div class="clearfix"></div>
<div class="flight_details hide_mob">
<a href="javascript:;" dataid="{{$irs}}" class="seconddetails_btn">Fight Details</a>
<?php
if($countmore > 1){
	?>
	<a style="float: right;" href="javascript:;" dataid="tbodepshow{{$flight->ResultIndex}}" class="more_detail_btn fplus btn small colorful-transparent hover-colorful btn_green"><i class="fa fa-plus"></i> More Fare</a>
	<?php
}
?>
<div class="clearfix"></div>
<div class="clearfix visible-xs"></div>
<?php
						if($countmore > 1){
							?>
					<div class="more_flight_fare showfaremoretbodepshow{{$flight->ResultIndex}}" style="display:none;">
					<?php $uiv = 0; foreach($moreflight as $farelist){ 
$farenewtotal = $farelist->Fare->PublishedFare;
$fareofftotal = $farelist->Fare->OfferedFare;
$newSegments = $farelist->Segments[0][0];

$countflighdatanew = count($farelist->Segments[0]); 
$tinew = $countflighdatanew -1;

$FareClassification = @$farelist->FareClassification;
$CabinClass = '';
if($newSegments->CabinClass == 1){
	$CabinClass = '- All';
}else if($newSegments->CabinClass == 2){
	$CabinClass = '- Economy';
}else if($newSegments->CabinClass == 3){
	$CabinClass = '- PremiumEconomy';
}else if($newSegments->CabinClass == 4){
	$CabinClass = '- Business';
}else if($newSegments->CabinClass == 5){
	$CabinClass = '- PremiumBusiness';
}else if($newSegments->CabinClass == 6){
	$CabinClass = '- First';
}

	$flighttype = 'domestic';

$markupd =0;
	$submark =0;
	$markupamt = \App\Markup::where('flight_code', $newSegments->Airline->AirlineCode)->where('flight_type', $flighttype)->first(); 
	if($markupamt){
		if($markupamt->service_type == 'fixed'){
			$markupd =  $markupamt->service_fee * $mtcount;
		}else{
			$markupd = ($fareofftotal * $markupamt->service_fee/100) * $mtcount;
		}
		$mark = $fareofftotal + $markupd;
	 $submark = $mark - $farenewtotal;
	}
	
	if($submark < 0){
			$farenewtotal = round($farenewtotal + $submark);
		}else{
			$farenewtotal = round($farenewtotal + $submark);
		}
		$service_fees = \App\MyConfig::where('meta_key','service_fees')->first();
			$service_type = \App\MyConfig::where('meta_key','service_type')->first();
			if($service_type->meta_value == 'fixed'){
				$mv =  $service_fees->meta_value;
			}else{
				$mv = ($farenewtotal * $service_fees->meta_value/100);
			}	
			
			$farenewtotal = $farenewtotal + $mv;
						
						
						$searchid = base64_encode(convert_uuencode($farelist->ResultIndex.$srch));
					?>
						<div class="cus_fare_row">
							<div class="cus_fare_left">
								<div class="samefaredetail">
									<label>
									<input faretype="<?php echo @$FareClassification->Type; ?>" onclick="InboundResullt('{{$newSegments->Airline->AirlineCode}}','{{$newSegments->Airline->AirlineName}}','{{$newSegments->Airline->FlightNumber}}','{{date('H:i', strtotime($newSegments->Origin->DepTime))}}','{{$newSegments->Origin->Airport->AirportCode}}','{{date('H:i', strtotime($farelist->Segments[0][$tinew]->Destination->ArrTime))}}','{{$farelist->Segments[0][$tinew]->Destination->Airport->AirportCode}}','<?php echo round($farenewtotal); ?>','{{$farelist->ResultIndex}}','{{$farelist->IsLCC}}','{{$flight->ResultIndex}}','{{$searchid}}')" mainfare="<?php echo round($farenewtotal); ?>" offrerfareprice="<?php echo $fareofftotal; ?>" mainindex="{{$flight->ResultIndex}}" name="farechk{{$flight->ResultIndex}}" type="radio" <?php if($uiv == 0){ ?>checked<?php } ?> id="" fareindex="{{$farelist->ResultIndex}}" class="fareselect" fareprice="<?php echo round($farenewtotal); ?>"/>
										<span class="published_price"><span class="currency_symb"><i class="fa fa-rupee-sign"></i></span><?php echo round($farenewtotal); ?></span>
										
										<span class="flight_extra_info">
											<span class="flight_extra_classification">
												@if($farelist->IsRefundable) <span style="color:green;">R</span> @else <span style="color:red;">N</span> @endif 
											</span>
											<?php
											if(isset($newSegments->NoOfSeatAvailable)){
											?>
											<span class="seats_available lightred-text"><i class="fa fa-seat-airline"></i> <span>{{@$newSegments->NoOfSeatAvailable}}</span></span>
											<?php } ?>
											<span class="faretype"><?php echo @$FareClassification->Type; ?></span>
										</span> 
									</label>
								</div>
							</div>
							
						</div>
					<?php $uiv++; } ?>
					</div>
					<?php
						}
						?>
<div class="flight_details_info secflight_details_info" id="depshow_{{$irs}}">
<ul class="nav nav-tabs custom_tabs">
<li class="active"><a href="#flightinfo{{$irs}}00" aria-controls="flightinfo" role="tab" data-toggle="tab">Flight Information</a></li>
<li class=""><a  href="#faredetail{{$irs}}10" class="" aria-controls="faredetail" role="tab" data-toggle="tab">Fare Details</a></li> 
<li class=""><a href="#baggageinfo{{$irs}}20" aria-controls="baggageinfo" role="tab" data-toggle="tab">Baggage Information</a></li>
<li class=""><a  resindex="{{$flight->ResultIndex}}" href="#cancellationrule{{$irs}}30" class="farerule" aria-controls="cancellationrule" role="tab" data-toggle="tab">Cancellation Rules</a></li>
</ul>
<div class="secflight_details_close cus_flight_detail_close">
<a href="javascript:;"><i class="fa fa-times"></i></a>
</div>	
<div class="tab-content">
<div role="tabpanel" class="tab-pane active" id="flightinfo{{$irs}}00">
<?php 
$depflighdata = $flight->Segments[0];
						for($fl =0;$fl<count($depflighdata);$fl++){
							if($flight->IsLCC == 1){
//echo $allflighdata[$fl]->GroundTime;
if($depflighdata[$fl]->GroundTime != 0){
$minutes = $depflighdata[$fl]->GroundTime;
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
$arTime = date('Y-m-d h:i:s a', strtotime($depflighdata[0]->Destination->ArrTime));
$DepTime = date('Y-m-d h:i:s a', strtotime($depflighdata[1]->Origin->DepTime));
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
$arTime = date('Y-m-d h:i:s a', strtotime($depflighdata[1]->Destination->ArrTime));
$DepTime = date('Y-m-d h:i:s a', strtotime($depflighdata[2]->Origin->DepTime));
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
$arTime = date('Y-m-d h:i:s a', strtotime($depflighdata[2]->Destination->ArrTime));
$DepTime = date('Y-m-d h:i:s a', strtotime($depflighdata[3]->Origin->DepTime));
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
<div class="flight_route">
	<div class="flight_route_list">
		<ul>
			<li>
				<img src="{{URL::to('public/img/airline/') }}/{{$depflighdata[$fl]->Airline->AirlineCode}}.gif" alt="">
				<div class="flight_name">{{$depflighdata[$fl]->Airline->AirlineName}}<span class="flight_no">{{$depflighdata[$fl]->Airline->AirlineCode}}-{{$depflighdata[$fl]->Airline->FlightNumber}}</span></div>
			</li>
			<li class="flight_timer">
				{{$depflighdata[$fl]->Origin->Airport->AirportCode}} {{date('H:i', strtotime($depflighdata[$fl]->Origin->DepTime))}} <span>{{$depflighdata[$fl]->Origin->Airport->CityName}} <br> {{date('D-d M Y', strtotime($depflighdata[$fl]->Origin->DepTime))}}<br> Terminal-{{$depflighdata[$fl]->Origin->Airport->Terminal}}</span>
			</li>
			<li>
				<span class="duration"><span><i class="fa fa-clock"></i></span><?php echo Controller::GetFetilFlightTimeduration($depflighdata[$fl]); ?><?php //echo Controller::GetTimeduration($depflighdata[$fl]->Origin->DepTime, $depflighdata[$fl]->Destination->ArrTime); ?></span>
			</li> 
			<li class="flight_timer">
				{{$depflighdata[$fl]->Destination->Airport->AirportCode}} {{date('H:i', strtotime($depflighdata[$fl]->Destination->ArrTime))}} <span>{{$depflighdata[$fl]->Destination->Airport->CityName}} <br> {{date('D-d M Y', strtotime($depflighdata[$fl]->Destination->ArrTime))}} <br> Terminal-{{$depflighdata[$fl]->Destination->Airport->Terminal}}</span>
			</li> 
		</ul>
		<div class="clearfix"></div>
	</div>
</div>
<?php } ?>
</div>
<div role="tabpanel" class="tab-pane" id="faredetail{{$irs}}10">
<div class="fare_details">
<div class="row">
<div class="col-sm-12 fare_left">
								<?php 
								$uiv = 0; foreach($moreflight as $farelist){ 
						
								$farebrakdown = $farelist->FareBreakdown;
								?>
								<table border="0" style="<?php if($uiv != 0){ echo 'display:none;'; } ?>" class="commonshowprice showpprice_{{$farelist->ResultIndex}}">
									<tbody>
							<?php 
							for($fb = 0; $fb<count($farebrakdown); $fb++){ ?>
								<tr>
								<td><?php echo $farebrakdown[$fb]->PassengerCount ?> x  <?php if($farebrakdown[$fb]->PassengerType == 1){ echo 'Adults'; }else if($farebrakdown[$fb]->PassengerType == 2){ echo 'Child'; }else{ echo 'Infant'; } ?></td>
									<td><i class="fa fa-rupee-sign"></i> <?php echo $farebrakdown[$fb]->BaseFare; ?></td>
									</tr>
								<?php } ?>
								<tr>
									<td><b>Base Fare</b></td>
									<td><i class="fa fa-rupee-sign"></i> <?php echo @$farelist->Fare->BaseFare; ?></td>
								</tr>
								<?php
								$tax = isset($farelist->Fare->Tax) ? $farelist->Fare->Tax : 0;
				$OtherCharges = isset($farelist->Fare->OtherCharges) ? $farelist->Fare->OtherCharges : 0;
				$AdditionalTxnFeePub = isset($farelist->Fare->AdditionalTxnFeePub) ? $farelist->Fare->AdditionalTxnFeePub : 0;
				$ServiceFee = isset($farelist->Fare->ServiceFee) ? $farelist->Fare->ServiceFee : 0;
				$AirlineTransFee = isset($farelist->Fare->AirlineTransFee) ? $farelist->Fare->AirlineTransFee : 0;
				
				$totaltax = $tax + $OtherCharges + $AdditionalTxnFeePub + $ServiceFee + $AirlineTransFee;
				$newtotal = $farelist->Fare->PublishedFare;
				$markupd =0;
				$submark =0;
				$newSegments = $farelist->Segments[0][0];
				$markupamt = \App\Markup::where('flight_code', $newSegments->Airline->AirlineCode)->where('flight_type', 'domestic')->where('user_type', 'b2c')->first(); 
				if($markupamt){
				if($markupamt->service_type == 'fixed'){
					$markupd =  $markupamt->service_fee * $mtcount;
				}else{
					$markupd = ($farelist->Fare->OfferedFare * $markupamt->service_fee/100) * $mtcount;
				}
					$mark = $farelist->Fare->OfferedFare + $markupd;
					$submark += $mark - $farelist->Fare->PublishedFare;
				}
				
				if($submark < 0){
				$newtotal = round($farelist->Fare->PublishedFare + $submark);
				}else{
					$newtotal = round($farelist->Fare->PublishedFare + $submark);
				}
					$service_fees = \App\MyConfig::where('meta_key','service_fees')->first();
					$service_type = \App\MyConfig::where('meta_key','service_type')->first();
				if($service_type->meta_value == 'fixed'){
					$mv =  $service_fees->meta_value;
				}else{
					$mv = ($newtotal * $service_fees->meta_value/100);
				}
								?>
								<tr>
									<td><b>Total Tax & Surcharge</b></td>
									<td>
										
											<i class="fa fa-rupee-sign"></i> <?php echo $totaltax; ?></td>
											</tr>
											<?php if($submark < 0){ ?>
											<tr>
											<td><b>Discount</b></td>
											<td><i class="fa fa-rupee-sign"></i> <?php echo round($submark); ?></td>
											</tr>	
											<?php }else{
											?>

											<?php
											} 
											if($submark < 0){
											?>		
											<tr>
											<td><b>Service Fee</b></td>
											<td><i class="fa fa-rupee-sign"></i> <?php echo round($mv); ?></td>
											</tr>	
											<?php }else{
											?>
											<tr>
											<td><b>Service Fee</b></td>
											<td><i class="fa fa-rupee-sign"></i> <?php echo round($submark
											+ $mv); ?></td>
											</tr>	
											<?php
											} ?>
											<tr>
											<td><b>Total</b></td>
											<td><i class="fa fa-rupee-sign"></i> <?php echo round($newtotal + $mv); ?></td>
											</tr>
																		</tbody>
								</table>
								<?php $uiv++; } ?>
							</div>
<div class="clearfix"></div>
</div>
</div>
</div>
<div role="tabpanel" class="tab-pane" id="baggageinfo{{$irs}}20">
<div class="baggage_info">
<div class="baggage_row baggage_border">
<div class="col-sm-3">
<div class="baggage_title">AIRLINE</div>
</div>
<div class="col-sm-3">
<div class="baggage_title">Check-in Baggage</div>
</div>
<div class="col-sm-3">
<div class="baggage_title">Cabin Baggage</div>
</div>
<div class="clearfix"></div>
</div>
<?php
									$uiv = 0;
									foreach($moreflight as $farelist){
										
										?>
										<div style="<?php  if($uiv != 0){ echo 'display:none;'; }  ?>" class="commonshowbag showpbag_{{$farelist->ResultIndex}}">
										<?php
										$bagagesegments = $farelist->Segments[0];
									for($flb =0;$flb<count($bagagesegments);$flb++){
									?>
									<div class="baggage_row">
									<div class="col-sm-4 col-xs-4 baggcol_3">
										<div class="baggage_value">
										
											<img src="{{URL::to('/public/img/airline/')}}/{{$bagagesegments[$flb]->Airline->AirlineCode}}.gif" alt="">
											<div class="flight_name"><span>{{$bagagesegments[$flb]->Airline->AirlineName}}</span><span>{{$bagagesegments[$flb]->Airline->AirlineCode}}-{{$bagagesegments[$flb]->Airline->FlightNumber}}</span></div>
										</div> 
									</div>
									<div class="col-sm-4 col-xs-4 baggcol_3">
										<div class="baggage_value">
											<span>{{$bagagesegments[$flb]->Baggage}}</span>
										</div>
									</div>
									<div class="col-sm-4 col-xs-4 baggcol_3">
										<div class="baggage_value">
											<span>{{$bagagesegments[$flb]->CabinBaggage}}</span>
										</div> 
									</div>
									<div class="clearfix"></div>
								</div>
									<?php } ?>
									</div>
									<?php $uiv++; } ?>
</div>
</div>
<div role="tabpanel" class="tab-pane" id="cancellationrule{{$irs}}30">
<div class="cancellationrule_info">
<div class="col-sm-12">
<div class="fare_right fare_rules">
<h4>Fare Rules</h4>

<div class="row">
<div class="col-sm-12 terms_condition">
<input type="hidden" id="first{{$flight->ResultIndex}}" isfirst="0">
<div class="showtob{{$flight->ResultIndex}} term_list">
<img src="{{URL::to('/public/img')}}/Ellipsis.gif">
</div>
<div class="clearfix"></div>
</div>
</div>

</div>
</div>
<div class="clearfix"></div> 
</div>
</div>
</div>
</div> 
</div>
</div><!-- .box-result end -->
</div><!-- .block-content-2 end -->
</div><!-- .block-content-2 end -->
</div><!-- .block-content-2 end -->
</div><!-- .block-content-2 end -->
</div><!-- .block-content-2 end -->
</div><!-- .block-content-2 end -->
</div><!-- .block-content-2 end -->
<?php $irs++; } ?>
</div><!-- .content-main end -->
</div>
</div><!-- .col-lg-6 end -->
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col_push_6 cus_col_6"> 
<div class="content-main">
<div class="block_content roundtrip_header">
<ul>
	<li class="flight_name">{{@$destin}} <i class="fa fa-arrow-right"></i> {{@$source}}</li>
	<li class="date">{{date('D-d M Y', strtotime($datearival))}}</li>
	<li class="prev_next_btn">
	<?php
	if(strtotime($datereturn) > strtotime($datedeparture)){
	?>
	<a id="lnkInboundPrevDay" href="javascript:;">Previous Day</a>
	<?php }else{
		?>
		<a id="" href="javascript:;">Previous Day</a>
		<?php
	} ?>
	<span></span>
	<a id="lnkInboundNextDay" href="javascript:;">Next Day</a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="block_content">
<div class="flight_info">
	<ul>
		<li><a onclick="AirlineSortRoundIBWay()" href="javascript:;">Airlines <i class="ibairsorta fa fa-arrow-up" ></i><i style="display:none;" class="ibairsortd fa fa-arrow-down"></i></a><input type="hidden" id="ibairsorting" value="descending"></li>
		<li><a onclick="DepartSortRoundIBWay()" href="javascript:;">Depart <i class="ibdepasorta fa fa-arrow-up" ></i><i style="display:none;" class="ibdepasortd fa fa-arrow-down"></i></a><input type="hidden" id="ibdepasorting" value="descending"></li>
		<li><a onclick="DurationSortRoundIBWay()" href="javascript:;">Duration <i class="ibdurasorta fa fa-arrow-up" ></i><i style="display:none;" class="ibdurasortd fa fa-arrow-down"></i></a><input type="hidden" id="ibdurasorting" value="descending"></li>
		<li><a onclick="ArriveSortRoundIBWay()" href="javascript:;">Arrive <i class="ibarriveasorta fa fa-arrow-up" ></i><i   style="display:none;" class="ibarrivesortd fa fa-arrow-down"></i></a><input type="hidden" id="ibarrivesorting" value="descending"></li>
		<li class="price_control"><a onclick="PriceSortDRTR()" href="javascript:;">Price <i class="pricesorta1 fa fa-arrow-up" ></i><i style="display:none;"  class="pricesortd1 fa fa-arrow-down"></i></a><input type="hidden" id="pricesorting1" value="descending"></a></li>
		<li></li>
	</ul>
	<div class="clearfix"></div>
</div> 
</div> 
<div class="round_trip_list" id="bingo_width1">
<?php
$ir = 0;
?>
@if(isset($flightresult->Response->Results[1]))
	@foreach($flightreturn as $retflighti)
		<?php
		$retcountmore = count($retflighti);
$retflight = $retflighti[0];
$retmoreflight = $retflighti;
					$segments = $retflight->Segments[0][0];
$bagagesegments = $retflight->Segments[0];
$D_TIME = date('H:i', strtotime($segments->Origin->DepTime));
$A_TIME = date('H:i', strtotime($segments->Destination->ArrTime));
$timedep = explode(':', $D_TIME);
$timearr = explode(':', $A_TIME);
$totaldepSecs   = ($timedep[0] * 60) + $timedep[1]; 
$totalarvSecs   = ($timearr[0] * 60) + $timearr[1]; 

$countflighdata = count($retflight->Segments[0]); 
$ti = $countflighdata -1;

$depdatetime = $segments->Origin->DepTime;
$arrdatetime = $retflight->Segments[0][$ti]->Destination->ArrTime;
$datetime1 =  new \DateTime($depdatetime);
$datetime2 =  new \DateTime($arrdatetime);
$interval = $datetime1->diff($datetime2);
$time2 = $interval->format('%h').":".$interval->format('%i');
$time2s = $interval->format('%h')."h:".$interval->format('%i').'m';
$timeDUR = explode(':', @$time2); 
$totaldurSecs   = ($timeDUR[0] * 60) + $timeDUR[1]; 

$newtotal = $retflight->Fare->PublishedFare;
$offtotal = $retflight->Fare->OfferedFare;
$FareClassificationtype = @$flight->FareClassification;
$oldwtotal = $retflight->Fare->PublishedFare;
$oldofftotal = $retflight->Fare->OfferedFare;

$F_NAME = $segments->Airline->AirlineName;
$STOP = count($retflight->Segments[0]) -1;

$returndataairlinearray[$segments->Airline->AirlineCode] = array(
		'AirLineName' =>$segments->Airline->AirlineName
);

$markupd =0;
$submark =0;
$markupamt = \App\Markup::where('flight_code', $segments->Airline->AirlineCode)->where('user_type', 'b2c')->where('flight_type', 'domestic')->first(); 
if($markupamt){
if($markupamt->service_type == 'fixed'){
$markupd =  $markupamt->service_fee * $mtcount;
}else{
$markupd = ($offtotal * $markupamt->service_fee/100) * $mtcount;
}
$mark = $offtotal + $markupd;
$submark = $mark - $newtotal;
}
if($submark < 0){
$newtotal = round($newtotal + $submark);
}else{
$newtotal = round($newtotal + $submark);
}
$service_fees = \App\MyConfig::where('meta_key','service_fees')->first();
$service_type = \App\MyConfig::where('meta_key','service_type')->first();
if($service_type->meta_value == 'fixed'){
$mv =  $service_fees->meta_value;
}else{
$mv = ($newtotal * $service_fees->meta_value/100);
}	
$returndataairlineprice[] = round($newtotal + $mv);
		?>
		<div class="refendable11 refendable11onword" refendable="" test_org_cust="" test_org_pub="" >
			<div class="price1" price="<?php echo round( $newtotal + $mv); ?>" data-price="<?php echo round( $newtotal + $mv); ?>" data-arrtime="{{$totalarvSecs}}" data-duration="{{@$totaldurSecs}}" data-deptime="{{$totaldepSecs}}" data-flight="{{@$segments->Airline->AirlineCode}}">
				<div class="price111 price111return" timedep="{{@$timedep[0]}}" timearr="{{@$timearr[0]}}">
					<div class="flight11" flight="{{@$segments->Airline->AirlineCode}}">
						<div class="flight112" flightcraft="{{@$segments->Craft}}"> 
							<div class="stopscount" stop="{{$STOP}}">	
								<div id="div{{$retflight->ResultIndex}}" attrtime="{{date('H:i:s', strtotime($segments->Origin->DepTime))}}" class="Price{{round($newtotal)}} allshow block-content-2 custom_block_content returnflight-list-v2 DRTFilter {{$segments->Airline->AirlineCode}} {{$segments->Airline->AirlineName}} 0Stops bingo_button_41">
										<div class="box-result custom_box_result">
<ul class="list-search-result result_list">
<li>
	<img src="{{URL::to('/public/img/airline/')}}/{{$segments->Airline->AirlineCode}}.gif" alt="">
	<div class="flight_name ibflight_name hide_mob">
	{{@$F_NAME}}
	<span class="flight_no">{{$segments->Airline->AirlineCode}}-{{$segments->Airline->FlightNumber}}</span></div>
	<div class="flight_name hide_desk">
		<span class="flight_no">{{$segments->Airline->AirlineCode}}-{{$segments->Airline->FlightNumber}}</span>
	</div>
</li>
<li class="pad_left10">
	<span class="date ibdepartdate">{{date('H:i', strtotime($segments->Origin->DepTime))}}</span>
	{{$segments->Origin->Airport->CityName}}
</li>
<li>
	<span class="duration ibduration"><?php echo Controller::GetFlightTimeduration($retflight->Segments[0]); 
	//Controller::GetTimeduration($res->Segments[0][0]->Origin->DepTime, $res->Segments[0][$ti]->Destination->ArrTime);
	?> <span> @if(count($retflight->Segments[0]) > 1)
	
<div class="cus_tooltip"><?php echo count($retflight->Segments[0])-1; ?> stop
		<span class="tooltiptext">
		<?php for($rr = 0;$rr<$ti; $rr++){ ?>
	{{$retflight->Segments[0][$rr]->Destination->Airport->AirportName}}
	<br>
	<?php } ?>
		</span>
	</div>
@else 
	non-stop
	@endif</span>
		
	</span>
</li> 
<li class="pad_left10">
	<span class="date">{{date('H:i', strtotime($retflight->Segments[0][$ti]->Destination->ArrTime))}}</span>
	{{$retflight->Segments[0][$ti]->Destination->Airport->CityName}}
</li>
<li class="price pricer">
	<i class="fa fa-rupee-sign"></i> 
		<span class="airlineprice">
<span class="mainprice">
		{{round($newtotal + $mv)}}
		</span>
		</span>
</li>  
<li class="round_check">
<div class="checkbox-default">
<input <?php if($ir == 0){ echo 'checked'; } ?> class=""  name="outbound" onclick="OutboundResullt('{{$segments->Airline->AirlineCode}}','{{$segments->Airline->AirlineName}}','{{$segments->Airline->FlightNumber}}','{{date('H:i', strtotime($segments->Origin->DepTime))}}','{{$segments->Origin->Airport->AirportCode}}','{{date('H:i', strtotime($retflight->Segments[0][$ti]->Destination->ArrTime))}}','{{$retflight->Segments[0][$ti]->Destination->Airport->AirportCode}}','<?php echo round($newtotal + $mv); ?>','{{$retflight->ResultIndex}}','{{$retflight->IsLCC}}','{{$retflight->ResultIndex}}')" type="radio">
<span class="checkboxmark"></span>
</div>
</li>
</ul><!-- .list-search-result end -->
<div class="clearfix"></div>
<div class="flight_details hide_mob">
<a href="javascript:;" dataid="{{$ir}}" class="details_btn">Fight Details</a>
<?php
if($retcountmore > 1){
	?>										
	<a style="float:right;" href="javascript:;" dataid="tboretshow{{$retflight->ResultIndex}}" class="more_detail_btn fplus btn small colorful-transparent hover-colorful btn_green"><i class="fa fa-plus"></i> More Fare</a>
	<div class="clearfix"></div>	
	<?php
}
?>
<div class="clearfix visible-xs"></div>
<?php
						if($retcountmore > 1){
							?>
					<div class="more_flight_fare showfaremoretboretshow{{$retflight->ResultIndex}}" style="display:none;">
					<?php $uivs = 0; foreach($retmoreflight as $retfarelist){ 
						$farenewtotal = $retfarelist->Fare->PublishedFare;
						$fareofftotal = $retfarelist->Fare->OfferedFare;
						$newSegments = $retfarelist->Segments[0][0];
						
						$countflighdataret = count($retfarelist->Segments[0]); 
						$tiret = $countflighdataret -1;
						
						$FareClassification = @$retfarelist->FareClassification;
						$CabinClass = '';
						if($newSegments->CabinClass == 1){
							$CabinClass = '- All';
						}else if($newSegments->CabinClass == 2){
							$CabinClass = '- Economy';
						}else if($newSegments->CabinClass == 3){
							$CabinClass = '- PremiumEconomy';
						}else if($newSegments->CabinClass == 4){
							$CabinClass = '- Business';
						}else if($newSegments->CabinClass == 5){
							$CabinClass = '- PremiumBusiness';
						}else if($newSegments->CabinClass == 6){
							$CabinClass = '- First';
						}

	$flighttype = 'domestic';
	$markupd =0;
	$submark =0;
	$markupamt = \App\Markup::where('flight_code', $newSegments->Airline->AirlineCode)->where('flight_type', $flighttype)->first(); 
	if($markupamt){
		if($markupamt->service_type == 'fixed'){
			$markupd =  $markupamt->service_fee * $mtcount;
		}else{
			$markupd = ($fareofftotal * $markupamt->service_fee/100) * $mtcount;
		}
		$mark = $fareofftotal + $markupd;
	 $submark = $mark - $farenewtotal;
	}
	
	if($submark < 0){
			$farenewtotal = round($farenewtotal + $submark);
		}else{
			$farenewtotal = round($farenewtotal + $submark);
		}
		$service_fees = \App\MyConfig::where('meta_key','service_fees')->first();
			$service_type = \App\MyConfig::where('meta_key','service_type')->first();
			if($service_type->meta_value == 'fixed'){
				$mv =  $service_fees->meta_value;
			}else{
				$mv = ($farenewtotal * $service_fees->meta_value/100);
			}	
			
			$farenewtotal = $farenewtotal + $mv;
						$searchid = base64_encode(convert_uuencode($retfarelist->ResultIndex.$srch));
					?>
						<div class="cus_fare_row">
							<div class="cus_fare_left">
								<div class="samefaredetail">
									<label>
									<input faretype="<?php echo @$FareClassification->Type; ?>" onclick="OutboundResullt('{{$newSegments->Airline->AirlineCode}}','{{$newSegments->Airline->AirlineName}}','{{$newSegments->Airline->FlightNumber}}','{{date('H:i', strtotime($newSegments->Origin->DepTime))}}','{{$newSegments->Origin->Airport->AirportCode}}','{{date('H:i', strtotime($retfarelist->Segments[0][$tiret]->Destination->ArrTime))}}','{{$retfarelist->Segments[0][$tiret]->Destination->Airport->AirportCode}}','<?php echo round($farenewtotal); ?>','{{$retfarelist->ResultIndex}}','{{$retfarelist->IsLCC}}','{{$retflight->ResultIndex}}','{{$searchid}}')" mainfare="<?php echo round($farenewtotal); ?>"  offrerfareprice="<?php echo $fareofftotal; ?>" mainindex="{{$retflight->ResultIndex}}" name="retfarechk{{$retflight->ResultIndex}}" type="radio" <?php if($uivs == 0){ ?>checked<?php } ?> id="" fareindex="{{$retfarelist->ResultIndex}}" class="retfareselect" fareprice="<?php echo round($farenewtotal); ?>"/>
										<span class="published_price"><span class="currency_symb"><i class="fa fa-rupee-sign"></i></span><?php echo round($farenewtotal); ?></span>  
										
										<span class="flight_extra_info">
											<span class="flight_extra_classification">
												@if($retfarelist->IsRefundable) <span style="color:green;">R</span> @else <span style="color:red;">N</span> @endif 
											</span>
											<?php
											if(isset($newSegments->NoOfSeatAvailable)){
											?>
											<span class="seats_available lightred-text"><i class="fa fa-seat-airline"></i> <span>{{@$newSegments->NoOfSeatAvailable}}</span></span>
											<?php } ?>
											<span class="faretype"><?php echo @$FareClassification->Type; ?></span>
										</span>  
									</label>
								</div>
							</div>
							
						</div>
						
					<?php $uivs++; } ?>
					</div>
					<?php
						}
						?>
<div class="flight_details_info" id="show_{{$ir}}">
<ul class="nav nav-tabs custom_tabs">
<li class="active"><a href="#flightinfo{{$ir}}0" aria-controls="flightinfo{{$ir}}0" role="tab" data-toggle="tab">Flight Information</a></li>
<li class=""><a href="#faredetail{{$ir}}1" aria-controls="faredetail{{$ir}}1" role="tab" data-toggle="tab">Fare Details</a></li> 
<li class=""><a href="#baggageinfo{{$ir}}2" aria-controls="baggageinfo{{$ir}}2" role="tab" data-toggle="tab">Baggage Information</a></li>
<li class=""><a class="farerule" traceid="" resindex="{{$retflight->ResultIndex}}" href="#cancellationrule{{$ir}}3" aria-controls="cancellationrule{{$ir}}3" role="tab" data-toggle="tab">Cancellation Rules</a></li>
</ul>
<div class="flight_details_close cus_flight_detail_close">
<a href="javascript:;"><i class="fa fa-times"></i></a>
</div>	 
<div class="tab-content">
<div role="tabpanel" class="tab-pane active" id="flightinfo{{$ir}}0">
<?php 
$allflighdata = $retflight->Segments[0];
for($fl =0;$fl<count($depflighdata);$fl++){
							if($flight->IsLCC == 1){
//echo $allflighdata[$fl]->GroundTime;
if($depflighdata[$fl]->GroundTime != 0){
$minutes = $depflighdata[$fl]->GroundTime;
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
$arTime = date('Y-m-d h:i:s a', strtotime($depflighdata[0]->Destination->ArrTime));
$DepTime = date('Y-m-d h:i:s a', strtotime($depflighdata[1]->Origin->DepTime));
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
$arTime = date('Y-m-d h:i:s a', strtotime($depflighdata[1]->Destination->ArrTime));
$DepTime = date('Y-m-d h:i:s a', strtotime($depflighdata[2]->Origin->DepTime));
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
$arTime = date('Y-m-d h:i:s a', strtotime($depflighdata[2]->Destination->ArrTime));
$DepTime = date('Y-m-d h:i:s a', strtotime($depflighdata[3]->Origin->DepTime));
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
<div class="flight_route">
	<div class="flight_route_list">
		<ul>
			<li>
				<img src="{{URL::to('public/img/airline/') }}/{{$depflighdata[$fl]->Airline->AirlineCode}}.gif" alt="">
				<div class="flight_name">{{$depflighdata[$fl]->Airline->AirlineName}}<span class="flight_no">{{$depflighdata[$fl]->Airline->AirlineCode}}-{{$depflighdata[$fl]->Airline->FlightNumber}}</span></div>
			</li>
			<li class="flight_timer">
				{{$depflighdata[$fl]->Origin->Airport->AirportCode}} {{date('H:i', strtotime($depflighdata[$fl]->Origin->DepTime))}} <span>{{$depflighdata[$fl]->Origin->Airport->CityName}} <br> {{date('D-d M Y', strtotime($depflighdata[$fl]->Origin->DepTime))}}<br> Terminal-{{$depflighdata[$fl]->Origin->Airport->Terminal}}</span>
			</li>
			<li>
				<span class="duration"><span><i class="fa fa-clock"></i></span><?php echo Controller::GetFetilFlightTimeduration($depflighdata[$fl]); ?><?php //echo Controller::GetTimeduration($depflighdata[$fl]->Origin->DepTime, $depflighdata[$fl]->Destination->ArrTime); ?></span>
			</li> 
			<li class="flight_timer">
				{{$depflighdata[$fl]->Destination->Airport->AirportCode}} {{date('H:i', strtotime($depflighdata[$fl]->Destination->ArrTime))}} <span>{{$depflighdata[$fl]->Destination->Airport->CityName}} <br> {{date('D-d M Y', strtotime($depflighdata[$fl]->Destination->ArrTime))}} <br> Terminal-{{$depflighdata[$fl]->Destination->Airport->Terminal}}</span>
			</li> 
		</ul>
		<div class="clearfix"></div>
	</div>
</div>
<?php } ?>
		</div>
		<div role="tabpanel" class="tab-pane" id="faredetail{{$ir}}1">
			<div class="fare_details">
				<div class="row">
					<div class="col-sm-12 fare_left">
						<?php 
								$uiv = 0; foreach($retmoreflight as $farelist){ 
				
								$farebrakdown = $farelist->FareBreakdown;
								?>
								<table border="0" style="<?php if($uiv != 0){ echo 'display:none;'; } ?>" class="commonshowprice showpprice_{{$farelist->ResultIndex}}">
									<tbody>
							<?php 
							for($fb = 0; $fb<count($farebrakdown); $fb++){ ?>
								<tr>
								<td><?php echo $farebrakdown[$fb]->PassengerCount ?> x  <?php if($farebrakdown[$fb]->PassengerType == 1){ echo 'Adults'; }else if($farebrakdown[$fb]->PassengerType == 2){ echo 'Child'; }else{ echo 'Infant'; } ?></td>
									<td><i class="fa fa-rupee-sign"></i> <?php echo $farebrakdown[$fb]->BaseFare; ?></td>
									</tr>
								<?php } ?>
								<tr>
									<td><b>Base Fare</b></td>
									<td><i class="fa fa-rupee-sign"></i> <?php echo @$farelist->Fare->BaseFare; ?></td>
								</tr>
								<?php
								$tax = isset($farelist->Fare->Tax) ? $farelist->Fare->Tax : 0;
				$OtherCharges = isset($farelist->Fare->OtherCharges) ? $farelist->Fare->OtherCharges : 0;
				$AdditionalTxnFeePub = isset($farelist->Fare->AdditionalTxnFeePub) ? $farelist->Fare->AdditionalTxnFeePub : 0;
				$ServiceFee = isset($farelist->Fare->ServiceFee) ? $farelist->Fare->ServiceFee : 0;
				$AirlineTransFee = isset($farelist->Fare->AirlineTransFee) ? $farelist->Fare->AirlineTransFee : 0;
				
				$totaltax = $tax + $OtherCharges + $AdditionalTxnFeePub + $ServiceFee + $AirlineTransFee;
				$newtotal = $farelist->Fare->PublishedFare;
				$markupd =0;
				$submark =0;
				$newSegments = $farelist->Segments[0][0];
				$markupamt = \App\Markup::where('flight_code', $newSegments->Airline->AirlineCode)->where('flight_type', 'domestic')->where('user_type', 'b2c')->first(); 
				if($markupamt){
				if($markupamt->service_type == 'fixed'){
					$markupd =  $markupamt->service_fee * $mtcount;
				}else{
					$markupd = ($farelist->Fare->OfferedFare * $markupamt->service_fee/100) * $mtcount;
				}
					$mark = $farelist->Fare->OfferedFare + $markupd;
					$submark += $mark - $farelist->Fare->PublishedFare;
				}
				
				if($submark < 0){
				$newtotal = round($farelist->Fare->PublishedFare + $submark);
				}else{
					$newtotal = round($farelist->Fare->PublishedFare + $submark);
				}
					$service_fees = \App\MyConfig::where('meta_key','service_fees')->first();
					$service_type = \App\MyConfig::where('meta_key','service_type')->first();
				if($service_type->meta_value == 'fixed'){
					$mv =  $service_fees->meta_value;
				}else{
					$mv = ($newtotal * $service_fees->meta_value/100);
				}
								?>
								<tr>
									<td><b>Total Tax & Surcharge</b></td>
									<td>
										
											<i class="fa fa-rupee-sign"></i> <?php echo $totaltax; ?></td>
											</tr>
											<?php if($submark < 0){ ?>
											<tr>
											<td><b>Discount</b></td>
											<td><i class="fa fa-rupee-sign"></i> <?php echo round($submark); ?></td>
											</tr>	
											<?php }else{
											?>

											<?php
											} 
											if($submark < 0){
											?>		
											<tr>
											<td><b>Service Fee</b></td>
											<td><i class="fa fa-rupee-sign"></i> <?php echo round($mv); ?></td>
											</tr>	
											<?php }else{
											?>
											<tr>
											<td><b>Service Fee</b></td>
											<td><i class="fa fa-rupee-sign"></i> <?php echo round($submark
											+ $mv); ?></td>
											</tr>	
											<?php
											} ?>
											<tr>
											<td><b>Total</b></td>
											<td><i class="fa fa-rupee-sign"></i> <?php echo round($newtotal + $mv); ?></td>
											</tr>
																		</tbody>
								</table>
								<?php $uiv++; } ?>
</div>
<div class="clearfix"></div>
</div>
</div>
</div>
<div role="tabpanel" class="tab-pane" id="baggageinfo{{$ir}}2">
<div class="baggage_info">
<div class="baggage_row baggage_border">
<div class="col-sm-3">
<div class="baggage_title">AIRLINE</div>
</div>
<div class="col-sm-3">
<div class="baggage_title">Check-in Baggage</div>
</div>
<div class="col-sm-3">
<div class="baggage_title">Cabin Baggage</div>
</div>
<div class="clearfix"></div>
</div>
<?php
	$uiv = 0;
	foreach($retmoreflight as $farelist){

		?>
		<div style="<?php  if($uiv != 0){ echo 'display:none;'; }  ?>" class="commonshowbag showpbag_{{$farelist->ResultIndex}}">
		<?php
		$bagagesegments = $farelist->Segments[0];
	for($flb =0;$flb<count($bagagesegments);$flb++){
	?>
	<div class="baggage_row">
	<div class="col-sm-4 col-xs-4 baggcol_3">
		<div class="baggage_value">
		
			<img src="{{URL::to('/public/img/airline/')}}/{{$bagagesegments[$flb]->Airline->AirlineCode}}.gif" alt="">
			<div class="flight_name"><span>{{$bagagesegments[$flb]->Airline->AirlineName}}</span><span>{{$bagagesegments[$flb]->Airline->AirlineCode}}-{{$bagagesegments[$flb]->Airline->FlightNumber}}</span></div>
		</div> 
	</div>
	<div class="col-sm-4 col-xs-4 baggcol_3">
		<div class="baggage_value">
			<span>{{$bagagesegments[$flb]->Baggage}}</span>
		</div>
	</div>
	<div class="col-sm-4 col-xs-4 baggcol_3">
		<div class="baggage_value">
			<span>{{$bagagesegments[$flb]->CabinBaggage}}</span>
		</div> 
	</div>
	<div class="clearfix"></div>
</div>
	<?php } ?>
	</div>
	<?php $uiv++; } ?>
</div>
</div>
<div role="tabpanel" class="tab-pane" id="cancellationrule{{$ir}}3">
<div class="cancellationrule_info">
<div class="col-sm-12">
<div class="fare_right fare_rules">
<h4>Fare Rules</h4>

<div class="row">

<div class="col-sm-12 terms_condition">
<input type="hidden" id="first{{$retflight->ResultIndex}}" isfirst="0">
<div class="showtob{{$retflight->ResultIndex}} term_list">
<img src="{{URL::to('/public/img')}}/Ellipsis.gif">
</div>
</div>
<div class="clearfix"></div>
</div>

</div>
</div>
<div class="clearfix"></div> 
</div>
</div>
</div>
</div> 
</div>
</div><!-- .box-result end -->
								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $ir++; ?>
	@endforeach
@endif
</div>
</div><!-- .content-main end -->
</div><!-- .col-lg-6 end --> 
@endif
</div>
</div>
<div class="col-lg-3 col-md-3 col-lg-pull-9 col-md-pull-9 col-sm-12 cus_col_3">
<div class="sidebar style-1 custom_sidebar">
<div class="filter_head"> 
<div class="filter_title">
<h3>Filter <span id="cleflt" class="clearfilter">Clear All</span></h3>
</div>	
<a class="filter_close"><i class="fa fa-times"></i></a> 
</div>
<div class="inner_filter">
<div class="box-widget">
<h5 class="box-title">Price Range</h5>
<div class="box-content">
<input type="hidden" class="pricenew">
<div class="slider-dragable-range slider-range-price">
<input type="text" class="price">
<div class="slider-range" data-slider-min-value="{{min(@$dataairlineprice)}}" data-slider-max-value="{{max(@$dataairlineprice)}}" data-range-start-value="{{min(@$dataairlineprice)}}" data-range-end-value="{{max(@$dataairlineprice)}}" data-slider-value-sign="&#8377;"></div>
</div><!-- .slider-dragable-price end --> 											 				
</div><!-- .box-content end -->
</div><!-- .box-widget end -->
<?php /* <div class="box-widget">
<h5 class="box-title">Return Price</h5>
<div class="box-content">
<div class="slider-dragable-range slider-range-price-return">
<input type="text" class="retprice">
<div class="slider-range" data-slider-min-value="{{min($returndataairlineprice)}}" data-slider-max-value="{{max($returndataairlineprice)}}" data-range-start-value="{{min($returndataairlineprice)}}" data-range-end-value="{{max($returndataairlineprice)}}" data-slider-value-sign="&#8377;"></div>
</div><!-- .slider-dragable-price end --> 											 				
</div><!-- .box-content end -->
</div><!-- .box-widget end --> */ ?>
<div class="box-widget">
<h5 class="box-title">Departure</h5>
<div class="box-content">
<input type="hidden" class="timenew">
<div class="slider-dragable-range slider-range-price-time-round">
<input type="text" class="time">
<div class="slider-range-r" data-slider-min-value="0" data-slider-max-value="24" data-range-start-value="0"
data-range-end-value="24" data-slider-value-sign="Hr"></div>
</div><!-- .slider-dragable-range end -->
</div><!-- .box-content end -->
</div><!-- .box-widget end -->

<div class="box-widget">
<h5 class="box-title">Stops</h5>
<div class="box-content">
<ul class="check-boxes-custom list-checkboxes">

<li>
<label for="option1"  class="label-container checkbox-default">Non Stop
<input check_see="0" name="options" class="Stopfliter flightstop" id="option1" type="checkbox" value="0" >
<span class="checkmark"></span>
</label>
</li>
<li>
<label for="option2" class="label-container checkbox-default">1 Stop
<input check_see="0" name="options" class="Stopfliter flightstop" id="option2" type="checkbox" value="1" >
<span class="checkmark"></span>
</label>
</li>
<li>
<label for="option3"  class="label-container checkbox-default">1+ Stops
<input check_see="0" name="options" class="Stopfliter flightstop" id="option3" type="checkbox" value="2" >
<span class="checkmark"></span>
</label>
</li>
</ul><!-- .check-boxes-custom end -->
</div><!-- .box-content end -->
</div><!-- .box-widget end -->
<div class="box-widget">
<h5 class="box-title">AirLine</h5>
<div class="box-content">
<ul id="myULair" class="check-boxes-custom list-checkboxes">
<?php 
$air = array_merge($dataairlinearray, $returndataairlinearray);
foreach($air as $key => $val){
?>
<li>
<label class="label-container checkbox-default">@if($key == 'I5')
AirAsia 
@else
{{$val['AirLineName']}}
@endif
<input value_for_short="{{$key}}" name="airline" class="chboxAirline flightso" type="checkbox" value="0" id="Chk{{$key}}"  >
<span class="checkmark"></span>
</label>
</li>
<?php
} 
?>
</ul><!-- .check-boxes-custom end -->
<a href="javascript:;" id="airloadMore">Show more</a>
</div><!-- .box-content end -->
</div><!-- .box-widget end -->

</div>
<div class="applyfilter_btn">
<button type="button" class="apply_btn applyfilter">Apply Filter</button>
</div> 
</div><!-- .sidebar end -->

</div><!-- .col-lg-3 end -->
<div class="filter_btn_style"> 
<a href="javascript:;" class="filter_btn"><i class="fa fa-filter"></i> <span>Filiter</span></a> 
</div>
</div><!-- .row end -->
</div><!-- .page-single-content end -->

</div><!-- .col-md-12 end -->
</div><!-- .row end -->
</div><!-- .container end -->
@if(@$flightresult->Response->Error->ErrorCode != 0)

@else 
<div class="sticky_bottom">
<div class="container">
<div class="row col_mob_60">
<div class="col-sm-4 col-xs-6 brder_rgt stick_col_4">
<div class="stk_btm_sec" id="InboundFlight">
<ul> 
<li class="flight_txt">
<img src="" alt="" class="hide_mob">
<div class="flight_name"><span class="flight_no"></span></div>
</li>
<li class="flight_duration hide_mob">
<div class="depart_time cus_time">
<span class="date"></span>

</div>
<div class="arrow">
<i class="fa fa-arrow-right"></i>
</div>
<div class="arrive_time cus_time">
<span class="date"></span>

</div>
</li>
<li class="flight_price">
<i class="fa fa-rupee-sign"></i> 
</li>
</ul>
<div class="clearfix"></div>
</div> 
</div>
<div class="col-sm-4 col-xs-6 brder_rgt stick_col_4"> 
<div class="stk_btm_sec" id="OutboundFlight">
<ul> 
<li class="flight_txt">
<img src="images/files/logo-companies/img-1.png" alt="" class="hide_mob">
<div class="flight_name"><span class="flight_no"></span></div>
</li> 
<li class="flight_duration hide_mob"> 
<div class="depart_time cus_time">
<span class="date"></span>

</div>
<div class="arrow">
<i class="fa fa-arrow-right"></i>
</div>
<div class="arrive_time cus_time">
<span class="date"></span>

</div>
</li>
<li class="flight_price">
<i class="fa fa-rupee-sign"></i> 
<!--<a href="#" class="price_details">Details</a>-->
</li> 
</ul>
<div class="clearfix"></div>
</div> 
</div> 
<div class="col-sm-4 col-xs-12 stick_col_4">
<div class="stk_grand_total">
<ul>
<li class="grandtotal_txt">
Grand Total <span><i class="fa fa-rupee-sign"></i> <span id="totalamount"></span></span>
</li>
<li class="grandtotal_btn hide_mob">
<button onclick="BookingContinue();" class="btn">BooK Now</button>
</li>
</ul>  
<div class="clearfix"></div>
</div>
</div> 
<div class="clearfix"></div>
</div>
<div class="col_mob_40 hide_desk">
<div class="grandtotal_btn">
<button onclick="BookingContinue();" class="btn">BooK Now</button>
</div>
</div>
</div>	
</div>	
@endif
</div><!-- .section-content end -->

</div><!-- .section-flat end -->

</div><!-- #content-wrap -->

</section>
<input id='hfFilterData' type='hidden' value='{{json_encode(array_merge($dataarray,$returndataarray))}}'/>

<input type="hidden" value='0' id="multifilter">
<input id="hdftracid" name="hdftracid" type="hidden" value="{{@$flightresult->Response->TraceId}}" />
<input id="hdfInIndex" name="hdfInIndex" type="hidden" value="">
<input id="hdfOutIndex" name="hdfOutIndex" type="hidden" value="">
<input id="IsLccR" name="IsLccR" type="hidden" value="">
<input id="IsLcc" name="IsLcc" type="hidden" value="">
<input id="hdfOuttotalAmt" name="hdfOuttotalAmt" type="hidden" value="0">
<input id="hdfIntotalAmt" name="hdfIntotalAmt" type="hidden" value="0">
@endsection
@section('scripts')
<script>
$(function () {
	$(document).delegate('.more_detail_btn.fplus','click',function (e) {
	var fv = $(this).attr('dataid');
	$(this).removeClass('fplus');
	$(this).addClass('fminus');
		$(this).find('i').removeClass('fa-plus');
		$(this).find('i').addClass('fa-minus');
		
	$('.showfaremore'+fv).show();
});

$(document).delegate('.more_detail_btn.fminus','click',function (e) {
	var fv = $(this).attr('dataid');
	$(this).addClass('fplus');
	$(this).removeClass('fminus');
		$(this).find('i').addClass('fa-plus');
		$(this).find('i').removeClass('fa-minus');
	$('.showfaremore'+fv).hide();
});
	
	$(document).delegate('.fareselect','change',function (e) {
	if( $(this).is(":checked") ){
	var fareprice = $(this).attr('fareprice');
	var offrerfareprice = $(this).attr('offrerfareprice');
	var faretype = $(this).attr('faretype');
	var airlineremark = $(this).attr('airlineremark');
	var flightsearchid = $(this).attr('flightsearchid');
	var mainindex = $(this).attr('mainindex');
	var fareindex = $(this).attr('fareindex');
	var traceid = $(this).attr('traceid');
	
	$('#div'+mainindex+' .airlineprice .mainprice').html(fareprice);
	$('#div'+mainindex+' .flight_offer').html(faretype);
	$('#div'+mainindex+' .airlineremark span').html(airlineremark);
	$('#div'+mainindex+' .for_net_fare_div .mainprice').html(offrerfareprice);
	$('#div'+mainindex+' .book_btn a.book_now').attr('resindex', fareindex);
	$('#div'+mainindex+' .book_btn a.book_now').attr('searchid', flightsearchid);
		getFareRule('SingleTB','SrdvTB',traceid,fareindex,mainindex);
	
	$('#div'+mainindex+' .commonshowprice').hide();
	$('#div'+mainindex+' .showpprice_'+fareindex).show();
		$('#div'+mainindex+' .commonshowbag').hide();
	$('#div'+mainindex+' .showpbag_'+fareindex).show();
	}
	
});

	$(document).delegate('.retfareselect','change',function (e) {
		if( $(this).is(":checked") ){
		var fareprice = $(this).attr('fareprice');
		var offrerfareprice = $(this).attr('offrerfareprice');
		var faretype = $(this).attr('faretype');
		var mainindex = $(this).attr('mainindex');
		var fareindex = $(this).attr('fareindex');
		var mainfare = $(this).attr('mainfare');
		$('#div'+mainindex+' .flight_offer').html(faretype);
		$('#div'+mainindex+' .airlineprice').html(fareprice);
		$('#div'+mainindex+' .for_net_fare_div').html(offrerfareprice);
	$('#div'+mainindex+' .commonshowprice').hide();
			$('#div'+mainindex+' .showpprice_'+fareindex).show();
	$('#div'+mainindex+' .commonshowbag').hide();
			$('#div'+mainindex+' .showpbag_'+fareindex).show();
		$('input[name="outbound"]:checked').attr('outboundprice', mainfare);
		getFareRule('SingleTB','SrdvTB','{{@$flightresult->Response->TraceId}}',fareindex,mainindex);
		
		}
		
	});
});


</script>
@endsection