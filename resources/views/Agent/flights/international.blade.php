@extends('layouts.agentfrontend')
@section('title', @$seoDetails->meta_title)
@section('meta_title', '')
@section('meta_keyword', '')
@section('meta_description', '')
@section('bodyclass', 'ch single-page page-search')
@section('content')
<?php use App\Http\Controllers\Controller; ?>
<section id="content">
<?php //echo '<pre>'; print_r($flightresult); die; ?>
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
									?>
								<li <?php if(isset($_GET['jt']) && $_GET['jt'] == 1) { ?> class="active" <?php } ?> dataway="oneway"><a href="javascript:;">One Way</a></li>
									<li <?php if(isset($_GET['jt']) && $_GET['jt'] == 2) { ?> class="active" <?php } ?> class="roundtriptab" dataway="roundtrip"><a href="javascript:;">Round Trip</a></li>
									<!--<li <?php /* if(isset($_GET['jt']) && $_GET['jt'] == 3) { ?> class="active" <?php } */ ?> dataway="multicity"><a href="javascript:;">Multi City</a></li>-->
								</ul><!-- .br-tabs end -->									
								<ul class="br-tabs-content" style="height: 100%;"> 
									<li class="active" style="display: list-item;">
									<div class="ismultipleway">
										<form action="{{URL::to('/agent/FlightList/index')}}" class="form-banner-reservation form-inline style-2 form-h-40">
											<div class="form-group loc_search_field cus_loc_field">
												<input type="hidden" id="roundfromsearch" value="{{@$explodesearc[0]}}">
												<input type="hidden" id="journey_type" value="{{@$_GET['jt']}}"> 
												<input type="hidden" name="isReturn" value="true">
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
											<div class="form-group cus_calendar_field" style="<?php if(isset($_GET['jt']) && $_GET['jt'] == 2) { ?>  <?php }else{ echo 'opacity: 0.4;'; } ?>">
												<input autocomplete="off" <?php if(isset($_GET['jt']) && $_GET['jt'] == 2) { ?>  <?php }else{ echo 'readonly'; } ?> type="text" value="{{@$explodesearc[3]}}" name="brTimeEnd" value="" class="form-control if_oneway_trip roundtripenable" id="datepicker-time-end"
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
								<div class="advanced_option"><a href="javascript:;">Advanced Option <i class="fa fa-plus"></i></a>
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
									</ul><!-- .list-reservation-options end -->
								</div>
								<div class="clearfix"></div>
							</div><!-- .banner-reservation-tabs end -->

								</div><!-- .col-md-12 end -->  
								 
								<div class="col-md-12">									
									<div class="page-single-content sidebar-left mt-10 internationtrip_search">
										<div class="row">
											<div class="col-lg-9 col-md-9 col-lg-push-3 col-md-push-3 col-sm-12">
												<div class="content-main">
													@if(@$calenderresult->Response->Error->ErrorCode == 0)
													<div class="block-content-2 carousel_timer">
														<div class="owl-carousel owl-theme">
														@foreach($calenderresult->Response->SearchResults as $clis)
														<?php $depdate = date('Y-m-d', strtotime($clis->DepartureDate)) ?>
															<div class="item <?php if($depdate == $datedeparture){ echo 'chk_index'; } ?>">
				<a class="bydatesearchdata" seatclass="{{$_GET['cbn']}}" journytype="{{@$_GET['jt']}}" hfadult="{{$explodepass[0]}}" hfChild="{{$explodepass[1]}}" hfInfant="{{$explodepass[2]}}" fromdate="{{date('d/m/Y', strtotime($clis->DepartureDate))}}" fromdestination="{{$explodesearc[0]}}" todestination="{{$explodesearc[1]}}" href="{{URL::to('agent/FlightList/index')}}?srch={{$explodesearc[0]}}|{{$explodesearc[1]}}|{{date('Y/m/d', strtotime($clis->DepartureDate))}}&px={{$_GET['px']}}&cbn={{$_GET['cbn']}}&nt={{$_GET['nt']}}&jt={{$_GET['jt']}}"><h4><?php echo date('M d', strtotime($clis->DepartureDate)); ?></h4>
																<span><i class="fa fa-rupee-sign"></i> {{round($clis->Fare)}} </a></span>
															</div>
														@endforeach
															
														</div>
													</div><!-- .block-content-2 end -->
													@else
														
													@endif
													<div class="block_content">
														<div class="flight_info">
															<ul>
																<li><a onclick="AirlineSortRoundOneWay()" href="javascript:;">Airlines <i class="airsorta fa fa-arrow-up" ></i><i style="display:none;" class="airsortd fa fa-arrow-down"></i></a><input type="hidden" id="airsorting" value="descending"></li>
																<li><a onclick="DepartSortRoundOneWay()" href="javascript:;">Depart <i class="depasorta fa fa-arrow-up" ></i><i style="display:none;" class="depasortd fa fa-arrow-down"></i></a><input type="hidden" id="depasorting" value="descending"></li>
																<li><a onclick="DurationSortRoundOneWay()" href="javascript:;">Duration <i class="durasorta fa fa-arrow-up" ></i><i style="display:none;" class="durasortd fa fa-arrow-down"></i></a><input type="hidden" id="durasorting" value="descending"></li>
																<li><a onclick="ArriveSortRoundOneWay()" href="javascript:;">Arrive <i class="arriveasorta fa fa-arrow-up" ></i><i style="display:none;" class="arrivesortd fa fa-arrow-down"></i></a><input type="hidden" id="arrivesorting" value="descending"></li>
																
															</ul>
															<div class="clearfix"></div>
														</div>
													</div>
													<div id="bingo_width">
													<?php
														$ir = 0;
														$dataarray = array();
														$dataairlinecraftarray = array();
														$dataairlinearray = array();
														$dataairlineprice = array();
														$dataairlinedeparttime = array();
														foreach(@$flightresult->Response->Results[0] as $res){ 
															$countflighdata = count($res->Segments[0]);
															$ti = $countflighdata -1;
															
															$countflighdata1 = count($res->Segments[1]);
															$ti1 = $countflighdata1 -1;
															$dataairlinearray[$res->Segments[0][0]->Airline->AirlineCode] = array(
														'AirLineName' =>$res->Segments[0][0]->Airline->AirlineName
													);
													
													if($res->Segments[0][0]->Craft != ''){
														$dataairlinecraftarray[$res->Segments[0][0]->Craft] = array(
															'AirLineCraft' =>$res->Segments[0][0]->Craft
														);
													}
												$markupd =0;
	$submark =0;
	$markupamt = \App\Markup::where('flight_code', $res->Segments[0][0]->Airline->AirlineCode)->where('flight_type', 'international')->first(); 
	if($markupamt){
		if($markupamt->service_type == 'fixed'){
			$markupd =  $markupamt->service_fee * $mtcount;
		}else{
			$markupd = ($res->Fare->OfferedFare * $markupamt->service_fee/100) * $mtcount;
		}
		$mark = $res->Fare->OfferedFare + $markupd;
	 $submark = $mark - $res->Fare->PublishedFare;
	}
	
	if($submark < 0){
			$newtotal = round($res->Fare->PublishedFare + $submark);
		}else{
			$newtotal = round($res->Fare->PublishedFare + $submark);
		}
		$service_fees = \App\MyConfig::where('meta_key','service_fees')->first();
			$service_type = \App\MyConfig::where('meta_key','service_type')->first();
			if($service_type->meta_value == 'fixed'){
				$mv =  $service_fees->meta_value;
			}else{
				$mv = ($newtotal * $service_fees->meta_value/100);
			}	
													$dataairlineprice[] = round($newtotal + $mv);
													$dataairlinedeparttime[] = date('H:i', strtotime($res->Segments[0][0]->Origin->DepTime));
																	$stop = count($res->Segments[0]);
													 
															$dataarray[] = array(
																'IndexNumber' => $res->ResultIndex,
																'AirV' => $res->Segments[0][0]->Airline->AirlineCode,
																'AirLineName' => $res->Segments[0][0]->Airline->AirlineName,
																'Stop' => $stop,
																'DAirp' => $res->Segments[0][0]->Origin->Airport->AirportCode,
																'RAirP' => '',
																'DTime' => date('H:i', strtotime($res->Segments[0][0]->Origin->DepTime)),
																'RTime' => "",
																'GrandTotal' => round($newtotal + $mv),
																'Faretype' => "",
																'Travelclass' => "",
															);
													?>
													<div id="div{{$res->ResultIndex}}" attrtime="{{date('H:i:s', strtotime($res->Segments[0][0]->Origin->DepTime))}}" class="Price{{round($res->Fare->PublishedFare)}} allshow block-content-2 custom_block_content flight-list-v2 {{$res->Segments[0][0]->Airline->AirlineCode}} {{$res->Segments[0][0]->Airline->AirlineName}} 0Stops bingo_button_4">
														<div class="box-result custom_box_result ">
															<div class="inter_trip_left">
																<h4>Depart</h4>
																<ul class="list-search-result result_list">
																	<li>
																		<img src="{{URL::to('/public/img/airline/')}}/{{$res->Segments[0][0]->Airline->AirlineCode}}.gif" alt="">
																		<div class="flight_name obflight_name">{{$res->Segments[0][0]->Airline->AirlineName}}<span class="flight_no">{{$res->Segments[0][0]->Airline->AirlineCode}}-{{$res->Segments[0][0]->Airline->FlightNumber}}</span></div>
																	</li>
																	<li class="depart_time cus_dep_arr_time">
																		<span class="date departdate">{{$res->Segments[0][0]->Origin->Airport->CityCode}} {{date('H:i', strtotime($res->Segments[0][0]->Origin->DepTime))}}</span>
																		{{$res->Segments[0][0]->Origin->Airport->CityName}} 
																		<div class="date_time">{{date('D-d M Y', strtotime($res->Segments[0][0]->Origin->DepTime))}}</div>
																	</li>
																	<li class="flight_time_between">
																		<span class="duration departdur"><?php echo Controller::GetFlightTimeduration($res->Segments[0]); ?> <?php //echo Controller::GetTimeduration($res->Segments[0][0]->Origin->DepTime, $res->Segments[0][$ti]->Destination->ArrTime); ?> | @if(count($res->Segments[0]) > 1) 
																	<div class="cus_tooltip"><?php echo count($res->Segments[0]) -1; ?> stop <span class="tooltiptext">
																<?php for($rr = 0;$rr<$ti; $rr++){ ?>
																	{{$res->Segments[0][$rr]->Destination->Airport->AirportName}}
																	<br>
																	<?php } ?>
																</span></div> @else non-stop @endif </span>
																		<div class="time_separete"></div>
																		<div class="flight_rel">{{$res->Segments[0][0]->Origin->Airport->CityCode}}- {{$res->Segments[0][$ti]->Destination->Airport->CityCode}}</div>
																	</li>  
																	<li class="arrive_time cus_dep_arr_time">
																		<span class="date arivedate">{{$res->Segments[0][$ti]->Destination->Airport->CityCode}} {{date('H:i', strtotime($res->Segments[0][$ti]->Destination->ArrTime))}}</span>
																		{{$res->Segments[0][$ti]->Destination->Airport->CityName}} 
																		<div class="date_time">{{date('D-d M Y', strtotime($res->Segments[0][$ti]->Destination->ArrTime))}}</div>
																	</li>
																</ul><!-- .list-search-result end -->
																<div class="clearfix"></div>
																<div class="hr_seperator"></div>
																<h4>Return</h4>
																<ul class="list-search-result result_list">
																	<li>
																		<img src="{{URL::to('/public/img/airline/')}}/{{$res->Segments[1][0]->Airline->AirlineCode}}.gif" alt="">
																		<div class="flight_name">{{$res->Segments[1][0]->Airline->AirlineName}}<span class="flight_no">{{$res->Segments[1][0]->Airline->AirlineCode}}-{{$res->Segments[1][0]->Airline->FlightNumber}}</span></div>
																	</li>
																	<li class="depart_time">
																		<span class="date">{{$res->Segments[1][0]->Origin->Airport->CityCode}} {{date('H:i', strtotime($res->Segments[1][0]->Origin->DepTime))}}</span>
																		{{$res->Segments[1][0]->Origin->Airport->CityName}} 
																		<div class="date_time cus_dep_arr_time">{{date('D - d M Y', strtotime($res->Segments[1][0]->Origin->DepTime))}}</div>
																	</li>
																	<li class="flight_time_between">
																		<span class="duration"><?php echo Controller::GetFlightTimeduration($res->Segments[1]); ?><?php  //echo Controller::GetTimeduration($res->Segments[1][0]->Origin->DepTime, $res->Segments[1][$ti1]->Destination->ArrTime); ?> | @if(count($res->Segments[1]) > 1) 
																			<div class="cus_tooltip">
																		<?php echo count($res->Segments[1]) -1; ?> stop <span class="tooltiptext">
																		<?php for($rr = 0;$rr<$ti1; $rr++){ ?>
																	{{$res->Segments[1][$ti1]->Destination->Airport->AirportName}}
																	<br>
																	<?php } ?>
																		</span></div> 
																		@else non-stop @endif</span>
																		<div class="time_separete"></div>
																		<div class="flight_rel">{{$res->Segments[1][0]->Origin->Airport->CityCode}}- {{$res->Segments[1][$ti1]->Destination->Airport->CityCode}}</div>
																	</li> 
																	<li class="arrive_time cus_dep_arr_time">
																		<span class="date">{{$res->Segments[1][$ti1]->Destination->Airport->CityCode}} {{date('H:i', strtotime($res->Segments[1][$ti1]->Destination->ArrTime))}}</span>
																		{{$res->Segments[1][$ti1]->Destination->Airport->CityName}}
																		<div class="date_time">{{date('D-d M Y', strtotime($res->Segments[1][$ti1]->Destination->ArrTime))}}</div>
																	</li>
																</ul><!-- .list-search-result end -->
															</div>	 
															<div class="book_flight">
																<div class="refundable clr_green">
																	<span>@if($res->IsRefundable == 'true') Refundable @else Non-Refundable @endif</span>
																</div>
																<span class="fli_price"><i class="fa fa-rupee-sign"></i> <?php
	$markupd =0;
	$submark =0;
	$markupamt = \App\Markup::where('flight_code', $res->Segments[0][0]->Airline->AirlineCode)->where('flight_type', 'international')->first(); 
	if($markupamt){
		if($markupamt->service_type == 'fixed'){
			$markupd =  $markupamt->service_fee * $mtcount;
		}else{
			$markupd = ($res->Fare->OfferedFare * $markupamt->service_fee/100) * $mtcount;
		}
		$mark = $res->Fare->OfferedFare + $markupd;
	 $submark = $mark - $res->Fare->PublishedFare;
	}
	
	if($submark < 0){
			$newtotal = round($res->Fare->PublishedFare + $submark);
		}else{
			$newtotal = round($res->Fare->PublishedFare + $submark);
		}
		$service_fees = \App\MyConfig::where('meta_key','service_fees')->first();
			$service_type = \App\MyConfig::where('meta_key','service_type')->first();
			if($service_type->meta_value == 'fixed'){
				$mv =  $service_fees->meta_value;
			}else{
				$mv = ($newtotal * $service_fees->meta_value/100);
			}
	?>																		{{round($newtotal + $mv)}}
		</span>
		<a class="btn small colorful-transparent hover-colorful btn_green" href="{{URL::to('/agent/Review/Checkout')}}?tid={{$flightresult->Response->TraceId}}&RIndex={{$res->ResultIndex}}&isINT=true&isReturn=true">Book Now</a>
															<!--	<span class="fli_meal"><i class="fa fa-utensils"></i> Free Meals</span>-->
															</div>
															<div class="clearfix"></div>
															 
															<div class="flight_details">
																<a href="javascript:;" dataid="{{$ir}}" class="details_btn">Fight Details</a>
																<div class="clearfix"></div>
																<div class="flight_details_info" id="show_{{$ir}}">
																	<ul class="nav nav-tabs custom_tabs">
																		<li class="active"><a href="#flightinfo{{$ir}}0" aria-controls="flightinfo" role="tab" data-toggle="tab">Flight Information</a></li>
																		<li class=""><a class="farerule" traceid="{{$flightresult->Response->TraceId}}" resindex="{{$res->ResultIndex}}" href="#faredetail{{$ir}}1" aria-controls="faredetail" role="tab" data-toggle="tab">Fare Details</a></li> 
																		<li class=""><a href="#baggageinfo{{$ir}}2" aria-controls="baggageinfo" role="tab" data-toggle="tab">Baggage Information</a></li>
																		<li class=""><a class="farerule" traceid="{{$flightresult->Response->TraceId}}" resindex="{{$res->ResultIndex}}" href="#cancellationrule{{$ir}}3" aria-controls="cancellationrule" role="tab" data-toggle="tab">Cancellation Rules</a></li>
																	</ul>
																	<div class="flight_details_close cus_flight_detail_close">
																		<a href="javascript:;"><i class="fa fa-times"></i></a>
																	</div>	
																	<div class="tab-content">
																		<div role="tabpanel" class="tab-pane active" id="flightinfo{{$ir}}0">
																		<div class="col-md-12 ot">
																			<i class="fa fa-plane"></i> Departure
																		</div>
																		<div class="col-md-12">
																			{{$res->Segments[0][0]->Origin->Airport->CityName}} to {{$res->Segments[0][$ti]->Destination->Airport->CityName}}
																		</div>
																		<?php 
																			$depflighdata = $res->Segments[0];
																		for($fl =0;$fl<count($depflighdata);$fl++){ ?>
		<?php
		if($res->IsLCC == 1){
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
		
		?>																		<div class="flight_route">
																				
																				<div class="flight_route_list">
																					<ul>
																						<li>
																							<img src="{{URL::to('/public/img/airline/')}}/{{$depflighdata[$fl]->Airline->AirlineCode}}.gif" alt="">
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
																		
																		
																		<div class="col-md-12 ot">
																			<i class="fa fa-plane"></i> Return
																		</div>
																		<div class="col-md-12">
																			{{$res->Segments[1][0]->Origin->Airport->CityName}} to {{$res->Segments[1][$ti1]->Destination->Airport->CityName}}
																		</div>
																		<?php 
																			$retflighdata = $res->Segments[1];
																		for($fl =0;$fl<count($retflighdata);$fl++){ ?>
					<?php
		if($res->IsLCC == 1){
		//echo $allflighdata[$fl]->GroundTime;
			if($retflighdata[$fl]->GroundTime != 0){
				$minutes = $retflighdata[$fl]->GroundTime;
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
				$arTime = date('Y-m-d h:i:s a', strtotime($retflighdata[0]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($retflighdata[1]->Origin->DepTime));
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
				$arTime = date('Y-m-d h:i:s a', strtotime($retflighdata[1]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($retflighdata[2]->Origin->DepTime));
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
				$arTime = date('Y-m-d h:i:s a', strtotime($retflighdata[2]->Destination->ArrTime));
				$DepTime = date('Y-m-d h:i:s a', strtotime($retflighdata[3]->Origin->DepTime));
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
		
		?>															<div class="flight_route">
																				<h4>{{$retflighdata[$fl]->Origin->Airport->CityName}} <span><i class="fa fa-arrow-right"></i></span> {{$retflighdata[$fl]->Destination->Airport->CityName}}</h4>
																				<div class="flight_route_list">
																					<ul>
																						<li>
																							<img src="{{URL::to('/public/img/airline/')}}/{{$retflighdata[$fl]->Airline->AirlineCode}}.gif" alt="">
																							<div class="flight_name">{{$retflighdata[$fl]->Airline->AirlineName}}<span class="flight_no">{{$retflighdata[$fl]->Airline->AirlineCode}}-{{$retflighdata[$fl]->Airline->FlightNumber}}</span></div>
																						</li>
																						<li class="flight_timer">
																							{{$retflighdata[$fl]->Origin->Airport->AirportCode}} {{date('H:i', strtotime($retflighdata[$fl]->Origin->DepTime))}} <span>{{$retflighdata[$fl]->Origin->Airport->CityName}} <br> {{date('D-d M Y', strtotime($retflighdata[$fl]->Origin->DepTime))}} <br> Terminal-{{$retflighdata[$fl]->Origin->Airport->Terminal}}</span>
																						</li>
																						<li>
																							<span class="duration"><span><i class="fa fa-clock"></i></span><?php echo Controller::GetFetilFlightTimeduration($retflighdata[$fl]); ?><?php //echo Controller::GetTimeduration($retflighdata[$fl]->Origin->DepTime, $retflighdata[$fl]->Destination->ArrTime); ?></span>
																						</li> 
																						<li class="flight_timer">
																							{{$retflighdata[$fl]->Destination->Airport->AirportCode}} {{date('H:i', strtotime($retflighdata[$fl]->Destination->ArrTime))}} <span>{{$retflighdata[$fl]->Destination->Airport->CityName}} <br>{{date('D-d M Y', strtotime($retflighdata[$fl]->Destination->ArrTime))}} <br> Terminal-{{$retflighdata[$fl]->Destination->Airport->Terminal}} </span>
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
																					<div class="col-sm-4 fare_left">
																						<table border="0">
																							<tbody>
																							<?php 
																								$farebrakdown = $res->FareBreakdown;
																								for($fb = 0; $fb<count($farebrakdown); $fb++){ ?>
																								<td><?php echo $farebrakdown[$fb]->PassengerCount ?> x  <?php if($farebrakdown[$fb]->PassengerType == 1){ echo 'Adults'; }else if($farebrakdown[$fb]->PassengerType == 2){ echo 'Child'; }else{ echo 'Infant'; } ?></td>
																									<td><i class="fa fa-rupee-sign"></i> <?php echo $farebrakdown[$fb]->BaseFare; ?></td>
																								<?php } ?>
																								<tr>
																									<td><b>Total (Base Fare)</b></td>
																									<td><i class="fa fa-rupee-sign"></i> <?php echo $res->Fare->BaseFare; ?></td>
																								</tr>
																								<tr>
																									<td><b>Total Tax & Surcharge</b></td>
																									<td>
																										<?php
	$markupd =0;
	$submark =0;
	$markupamt = \App\Markup::where('flight_code', $res->Segments[0][0]->Airline->AirlineCode)->where('flight_type', 'international')->first(); 
	if($markupamt){
		if($markupamt->service_type == 'fixed'){
			$markupd =  $markupamt->service_fee * $mtcount;
		}else{
			$markupd = ($res->Fare->OfferedFare * $markupamt->service_fee/100) * $mtcount;
		}
		$mark = $res->Fare->OfferedFare + $markupd;
	 $submark = $mark - $res->Fare->PublishedFare;
	}
	
	if($submark < 0){
			$newtotal = round($res->Fare->PublishedFare + $submark);
		}else{
			$newtotal = round($res->Fare->PublishedFare + $submark);
		}
		$service_fees = \App\MyConfig::where('meta_key','service_fees')->first();
			$service_type = \App\MyConfig::where('meta_key','service_type')->first();
			if($service_type->meta_value == 'fixed'){
				$mv =  $service_fees->meta_value;
			}else{
				$mv = ($newtotal * $service_fees->meta_value/100);
			}	
	?>
<i class="fa fa-rupee-sign"></i> <?php echo $res->Fare->Tax + $res->Fare->OtherCharges + $res->Fare->AdditionalTxnFeePub; ?></td>
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
																					</div>
																					<div class="col-sm-8">
																						<div class="fare_right fare_rules">
																							<h4>Fare Rules</h4>
																							
																							<div class="clearfix"></div>
																							<div class="row">
																								<div class="col-sm-12 terms_condition">
																									<input type="hidden" id="first{{$res->ResultIndex}}" isfirst="0">
																								<div class="showtob{{$res->ResultIndex}} term_list">
																								<img src="{{URL::to('/public/img')}}/Ellipsis.gif">
																								</div></div>     
																								
																								<div class="clearfix"></div>
																							</div>
																							
																						</div>
																					</div>
																					<div class="clearfix"></div>
																				</div>
																			</div>
																		</div>
<div role="tabpanel" class="tab-pane" id="baggageinfo{{$ir}}2">
<div class="col-md-12">
	<i class="fa fa-plane"></i>
	Departure
</div>
<div class="col-md-12">
	{{$res->Segments[0][0]->Origin->Airport->CityName}} to {{$res->Segments[0][$ti]->Destination->Airport->CityName}}
</div>
	<div class="baggage_info">
		<div class="baggage_row baggage_border">
			<div class="col-sm-3 col-xs-4">
				<div class="baggage_title">AIRLINE</div>
			</div>
			<div class="col-sm-3 col-xs-4">
				<div class="baggage_title">Check-in Baggage</div>
			</div>
			<div class="col-sm-3 col-xs-4">
				<div class="baggage_title">Cabin Baggage</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<?php 
			$depflighbag = $res->Segments[0]; 
			for($flb =0;$flb<count($depflighbag);$flb++){
		?>
		<div class="baggage_row">
			<div class="col-sm-3 col-xs-4">
				<div class="baggage_value">
					<img src="{{URL::to('/public/img/airline/')}}/{{$depflighbag[$flb]->Airline->AirlineCode}}.gif" alt="">
					<div class="flight_name"><span>{{$depflighbag[$flb]->Airline->AirlineName}}</span><span>{{$depflighbag[$flb]->Airline->AirlineCode}}-{{$depflighbag[$flb]->Airline->FlightNumber}}</span></div>
				</div> 
			</div>
			<div class="col-sm-3 col-xs-4">
				<div class="baggage_value">
					<span>{{$depflighbag[$flb]->Baggage}}</span>
				</div>
			</div>
			<div class="col-sm-3 col-xs-4">
				<div class="baggage_value">
					<span>{{$depflighbag[$flb]->CabinBaggage}}</span>
				</div> 
			</div>
			<div class="clearfix"></div>
		</div>
			<?php } ?>
	</div>
	<div class="col-md-12">
	<i class="fa fa-plane"></i>
	Return
	</div>
	<div class="col-md-12">
	{{$res->Segments[1][0]->Origin->Airport->CityName}} to {{$res->Segments[1][$ti1]->Destination->Airport->CityName}}
</div>
	<div class="baggage_info">
		<div class="baggage_row baggage_border">
			<div class="col-sm-3 col-xs-4">
				<div class="baggage_title">AIRLINE</div>
			</div>
			<div class="col-sm-3 col-xs-4">
				<div class="baggage_title">Check-in Baggage</div>
			</div>
			<div class="col-sm-3 col-xs-4">
				<div class="baggage_title">Cabin Baggage</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<?php 
			$arvflighbag = $res->Segments[1]; 
			for($flab =0;$flab<count($arvflighbag);$flab++){
		?>
		<div class="baggage_row">
			<div class="col-sm-3 col-xs-4">
				<div class="baggage_value">
					<img src="{{URL::to('/public/img/airline/')}}/{{$arvflighbag[$flab]->Airline->AirlineCode}}.gif" alt="">
					<div class="flight_name"><span>{{$arvflighbag[$flab]->Airline->AirlineName}}</span><span>{{$arvflighbag[$flab]->Airline->AirlineCode}}-{{$arvflighbag[$flab]->Airline->FlightNumber}}</span></div>
				</div> 
			</div>
			<div class="col-sm-3 col-xs-4">
				<div class="baggage_value">
					<span>{{$arvflighbag[$flab]->Baggage}}</span>
				</div>
			</div>
			<div class="col-sm-3 col-xs-4">
				<div class="baggage_value">
					<span>{{$arvflighbag[$flab]->CabinBaggage}}</span>
				</div> 
			</div>
			<div class="clearfix"></div>
		</div>
			<?php } ?>
	</div>
</div>
																		<div role="tabpanel" class="tab-pane" id="cancellationrule{{$ir}}3">
																			<div class="cancellationrule_info">
																				<div class="col-sm-10 col-sm-offset-1">
																					<div class="fare_right fare_rules">
																						<h4>Fare Rules</h4>
																						
																						<div class="row">
																							<div class="col-sm-12 terms_condition">
																							<div class="showtob{{$res->ResultIndex}} term_list">
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
													</div><!-- .block-content-2 end -->
														<?php $ir++; }?>
												</div><!-- .content-main end -->
										 </div>
											</div><!-- .col-lg-9 end -->
											<div class="col-lg-3 col-md-3 col-lg-pull-9 col-md-pull-9 col-sm-12 cus_col_3">   
												<div class="sidebar style-1 custom_sidebar">
													<a class="filter_close"><i class="fa fa-times"></i></a>
													<h3>Filter <span onClick="ClearAll();" class="clearfilter">Clear All</span></h3>
													<div class="inner_filter">
														<div class="box-widget">
															<h5 class="box-title">Price Range</h5>
															<div class="box-content">
																<div class="slider-dragable-range slider-range-price">
																	<input type="text" class="price">
																	<div class="slider-range" data-slider-min-value="{{min($dataairlineprice)}}" data-slider-max-value="{{max($dataairlineprice)}}" data-range-start-value="{{min($dataairlineprice)}}" data-range-end-value="{{max($dataairlineprice)}}" data-slider-value-sign="&#8377;"></div>
																</div><!-- .slider-dragable-price end --> 											 				
															</div><!-- .box-content end -->
														</div><!-- .box-widget end -->
														<div class="box-widget">
															<h5 class="box-title">Departure</h5>
															<div class="box-content">
																<div class="slider-dragable-range slider-range-price-time">
																	<input type="text" class="time">
																	<div class="slider-range-t" data-slider-min-value="0" data-slider-max-value="24" data-range-start-value="0"
																		data-range-end-value="24" data-slider-value-sign="Hr"></div>
																</div><!-- .slider-dragable-range end -->
															</div><!-- .box-content end -->
														</div><!-- .box-widget end -->
														<!--<div class="box-widget">   
															<h5 class="box-title">Return</h5>
															<div class="box-content">
																<div class="slider-dragable-range slider-range-price">
																	<input type="text" class="price">
																	<div class="slider-range" data-slider-min-value="0" data-slider-max-value="24" data-range-start-value="5"
																		data-range-end-value="18" data-slider-value-sign="hr "></div>
																</div>
															</div>
														</div> -->
														<div class="box-widget"> 
															<h5 class="box-title">Stops</h5>
															<div class="box-content">
																<ul class="check-boxes-custom list-checkboxes">
																	
																	<li>
																		<label for="option1" onclick="doFilter('stop','0');" class="label-container checkbox-default">Non Stop
																			<input name="options" class="Stopfliter" id="option1" type="radio" value="0" onclick="doFilter('stop','0');">
																			<span class="checkmark"></span>
																		</label>
																	</li>
																	<li>
																		<label for="option2" onclick="doFilter('stop','1');" class="label-container checkbox-default">1 Stop
																			<input name="options" class="Stopfliter" id="option2" type="radio" value="1" onclick="doFilter('stop','1');">
																			<span class="checkmark"></span>
																		</label>
																	</li>
																	<li>
																		<label for="option3" onclick="doFilter('stop','2');" class="label-container checkbox-default">1+ Stops
																			<input name="options" class="Stopfliter" id="option3" type="radio" value="2" onclick="doFilter('stop','2');">
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
																	
																	foreach($dataairlinearray as $key => $val){
																		?>
																		<li>
																		<label class="label-container checkbox-default">{{$val['AirLineName']}}
																			<input name="airline" class="chboxAirline" type="checkbox" value="" id="Chk{{$key}}" onclick="doFilter('flight','{{$key}}',event);" >
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
														<div class="box-widget">
															<h5 class="box-title">AirLine Craft</h5>
															<div class="box-content">
																<ul id="myUL" class="check-boxes-custom list-checkboxes">
																	<?php 
																	
																	foreach($dataairlinecraftarray as $key => $val){
																		?>
																		<li>
																		<label class="label-container checkbox-default">{{$val['AirLineCraft']}}
																			<input name="airline" class="chboxAirline" type="checkbox" value="" id="Chk{{$key}}" onclick="doFilter('craft','{{$key}}',event);" >
																			<span class="checkmark"></span>
																		</label>
																		</li>
																		<?php
																	} 
																	?>
																</ul><!-- .check-boxes-custom end -->
																<a href="javascript:;" id="craftloadMore">Show more</a>
															</div><!-- .box-content end -->
														</div><!-- .box-widget end -->
														<!--<div class="box-widget">
															<h5 class="box-title">Airport</h5>
															<div class="box-content">
																<ul class="check-boxes-custom list-checkboxes">
																	<li>
																		<label class="label-container checkbox-default">All
																			<input type="checkbox">
																			<span class="checkmark"></span>
																		</label>
																	</li>
																</ul>
															</div>
														</div> -->
														<!--<div class="box-widget">
															<h5 class="box-title">Duration</h5>
															<div class="box-content">
																<div class="slider-dragable-range slider-range-time">
																	<div class="time">
																		<span class="slider-time-1">8:00 AM</span> - <span class="slider-time-2">3:00 PM</span>
																	</div>
																	<div class="sliders_step1">
																		<div class="slider-range" data-time-start-minutes="480" data-time-end-minutes="900"></div>
																	</div>
																</div>
															</div>
														</div>-->
													</div>
													<div class="applyfilter_btn">
														<button type="button" class="apply_btn">Apply Filter</button>
													</div>
												</div><!-- .sidebar end -->
										
											</div><!-- .col-lg-3 end -->
											<div class="filter_icon">
												<a href="javascript:;"><i class="fa fa-filter"></i> <span>Filiter</span></a>
											</div>
										</div><!-- .row end -->

									</div><!-- .page-single-content end -->
									
								</div><!-- .col-md-12 end -->
							</div><!-- .row end -->
						</div><!-- .container end -->

					</div><!-- .section-content end -->

				</div><!-- .section-flat end -->

			</div><!-- #content-wrap -->

		</section>
		<input id='hfFilterData' type='hidden' value='{{json_encode($dataarray)}}'/>

<input type="hidden" value='0' id="multifilter">
@endsection