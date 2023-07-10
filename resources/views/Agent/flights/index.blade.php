@extends('layouts.agentfrontend')
@section('title', @$seoDetails->meta_title)
@section('meta_title', @$seoDetails->meta_title)
@section('meta_keyword', @$seoDetails->meta_keyword)
@section('meta_description', @$seoDetails->meta_desc)
@section('bodyclass', 'homepage')
@section('content')
<?php use App\Http\Controllers\PackageController; ?>
<!-- Banner
============================================= -->
<div class="mob_flight_link"> 
	<div class="container"> 
		<div class="row">
			<div class="col-sm-12 padd0">
				<div class="flight_link">
					<ul>
						<li><a href="#"><img src="{!! asset('public/images/icons/flight-tab.png') !!}" alt=""/> Flight</a></li>
						<li><a href="#"><img src="{!! asset('public/images/icons/hotel-tab.png') !!}" alt=""/> Hotels</a></li>
						<li><a href="#"><img src="{!! asset('public/images/icons/holiday-tab.png') !!}" alt=""/> Holiday</a></li>
						<li><a href="#"><img src="{!! asset('public/images/icons/bus-tab.png') !!}" alt=""/> Bus</a></li>
						<li><a href="#"><img src="{!! asset('public/images/icons/visa-tab.png') !!}" alt=""/> Visa</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<section id="banner">
	<div class="banner-parallax" data-banner-height="550">
		<img src="{!! asset('public/images/home-banner-bg.jpg') !!}" alt="">
		<div class="overlay-colored color-bg-white opacity-40"></div><!-- .overlay-colored end -->
		<div class="slide-content">
			<div class="container">
				<div class="row">
					<div class="col-md-12">		
						<div class="banner-center-box">
							<div class="banner-reservation-tabs custom_reservation_tab">
								<ul class="br-tabs">
									<li class="active" dataway="oneway"><a href="javascript:;">One Way</a></li>
									<li class="roundtriptab" dataway="roundtrip"><a href="javascript:;">Round Trip</a></li> 
									<li dataway="multicity"><a href="javascript:;">Multi City</a></li>
								</ul><!-- .br-tabs end -->
								
								<ul class="br-tabs-content" style="height: 100%;">
									<li class="roundandoneway commonway active" style="display: list-item;">
									<div class="ismultipleway">
										<form action="{{URL::to('/FlightList/index')}}" class="form-banner-reservation form-inline style-2 form-h-50">
											<div class="form-group loc_search_field cus_loc_field">
												<input type="hidden" id="roundfromsearch">
												<input type="hidden" id="journey_type" value="1">
												<input style="cursor: text;" autocomplete="off" type="text" name="roundwayfrmtext" id="fromdest_show" class="roundwayfrom form-control wrapper-dropdown-2" placeholder="From">
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
												<div id="swap" onclick="SwapRoundDestination();" class="swipe"></div>
											</div><!-- .form-group end -->
											<div class="form-group loc_search_field_to cus_loc_field">
											<input type="hidden" id="roundtosearch">
												<input style="cursor: text;" autocomplete="off" type="text" name="roundwaytotext" id="todest_show" class="roundwayto form-control wrapper-dropdown-3" placeholder="To">
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
												<input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" id="datepicker-time-start" placeholder="2019/09/30">
												<i class="far fa-calendar"></i>
											</div><!-- .form-group end -->
											<div class="form-group hideifmulticity cus_calendar_field" style="opacity: 0.4;">
												<input autocomplete="off" readonly type="text" name="brTimeEnd" value="" class="form-control if_oneway_trip roundtripenable" id="datepicker-time-end" placeholder="2019/09/30">
												<i class="far fa-calendar"></i>
											</div><!-- .form-group end -->
											<div class="form-group roundtrip cus_passenger_field">
												<input autocomplete="off" type="text" id="roundpessanger" name="brPassengerNumber" class="form-control show-dropdown-passengers roundpessanger"
													placeholder="Passengers" value="1 Passengers">
												<i class="fas fa-user"></i>
												<ul class="list-dropdown-passengers">
													<li>
														<ul class="list-persons-count">
															<li>
																<span>Adults:</span>
																<div class="counter-add-item">
																	<a class="decrease-btn" href="javascript:;">-</a>
																	<input id="roundadult" class="onewayadult" type="text" value="1">
																	<a class="increase-btn" href="javascript:;">+</a>
																</div><!-- .counter-add-item end -->
															</li>
															<li>
																<span>Childs:</span>
																<div class="counter-add-item">
																	<a class="decrease-btn" href="javascript:;">-</a>
																	<input id="roundchild" class="onewaychild" type="text" value="0">
																	<a class="increase-btn" href="javascript:;">+</a>
																</div><!-- .counter-add-item end -->
															</li>
															<li>
																<span>Infants:</span>
																<div class="counter-add-item">
																	<a class="decrease-btn" href="javascript:;">-</a>
																	<input id="roundinfant" class="onewayinfants" type="text" value="0">
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
											<a style="display:none;" class="if_multicity_trip btn-multiple-destinations btn x-small colorful hover-dark" href="javascript:;">
												<i class="fas fa-plus"></i>
												Add City
											</a>
											<div class="clearfix"></div>
										</form><!-- .form-banner-reservation end -->
										</div>
									</li>
									
									<li class="multiwaytrip commonway" style="display: none;">
									<form action="{{URL::to('/FlightList/index')}}" class="form-banner-reservation form-inline style-2 form-h-50">
									<div class="ismultipleway" id="section-s1">
										<div class="form-group loc_search_field cus_loc_field">
												<input type="hidden" id="multi_roundfromsearch1">
												<input type="hidden" id="journey_type" value="3">
												<input did="s1" ssid="1" style="cursor: text;" autocomplete="off" type="text" name="multiwayfromtext1" id="fromdest_show1" class="multi_roundwayfrom form-control wrapper-dropdown-7" placeholder="From">
												<i class="fas fa-plane"></i>
												<div class="location_search selhide" id="location_search">
													<div class="inner_loc_search">
														<div class="top_city">
															<span>Top Cities</span>
														</div>
														<ul class="multi_is_search_from_val">
														@foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $alist)
															<li roundwayfromtop="{{$alist->city_code}}-{{$alist->city_name}}-{{$alist->country_name}}" roundwayfrom="{{$alist->city_name}}({{$alist->city_code}})">
																<div class="fli_name"><i class="fa fa-plane"></i> {{$alist->city_name}} ({{$alist->city_code}})</div>
																<div class="airport_name">{{$alist->airport_name}}<span>{{$alist->country_name}}</span></div>
															</li>
														@endforeach
														</ul>
													</div>
												</div> 
										
											</div><!-- .form-group end -->
											<div class="form-group loc_search_field_to cus_loc_field">
											<input type="hidden" id="multi_roundtosearch1">
												<input did="s1" ssid="1" style="cursor: text;" autocomplete="off" type="text" name="multiwaytotext1" id="todest_show1" class="multi_roundwayto form-control wrapper-dropdown-8" placeholder="To">
												<i class="fas fa-plane"></i>
												<div class="location_search_to selhide" id="location_search_to"> 
													<div class="inner_loc_search">
														<div class="top_city">
															<span>Top Cities</span>
														</div>
														<ul class="multi_is_search_to_val">
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
												<input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" id="multipicker1"
													placeholder="2019/09/30">
												<i class="far fa-calendar"></i>
											</div><!-- .form-group end -->
											
											<div class="form-group multiroundtrip cus_passenger_field">
												<input autocomplete="off" type="text" id="multiroundpessanger" name="multibrPassengerNumber" class="form-control show-dropdown-passengers multiroundpessanger"
													placeholder="Passengers" value="1 Passengers">
												<i class="fas fa-user"></i>
												<ul class="list-dropdown-passengers">
													<li>
														<ul class="list-persons-count">
															<li>
																<span>Adults:</span>
																<div class="counter-add-item">
																	<a class="multidecrease-btn" href="javascript:;">-</a>
																	<input id="multiroundadult" class="multionewayadult" type="text" value="1">
																	<a class="multiincrease-btn" href="javascript:;">+</a>
																</div><!-- .counter-add-item end -->
															</li>
															<li>
																<span>Childs:</span>
																<div class="counter-add-item">
																	<a class="multidecrease-btn" href="javascript:;">-</a>
																	<input id="multiroundchild" class="multionewaychild" type="text" value="0">
																	<a class="multiincrease-btn" href="javascript:;">+</a>
																</div><!-- .counter-add-item end -->
															</li>
															<li>
																<span>Infants:</span>
																<div class="counter-add-item">
																	<a class="multidecrease-btn" href="javascript:;">-</a>
																	<input id="multiroundinfant" class="multionewayinfants" type="text" value="0">
																	<a class="multiincrease-btn" href="javascript:;">+</a>
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
												<button type="button" class="form-control multiroundformsearch icon" onClick="ValidateMuticity()"><i class="fas fa-search"></i> Search Flights</button>
											</div><!-- .form-group end -->
											<a id="crs1" onclick="CloseSection('section-s1','')" class="closem" style="display:none;" href="javascript:;">
												<i class="fas fa-times"></i>
												
											</a>
											<div class="clearfix"></div>
									
										</div>
										<div class="ismultipleway" id="section-s2">
										<div class="form-group loc_search_field cus_loc_field">
												<input type="hidden" id="multi_roundfromsearch2">
											
												<input did="s2" ssid="2" style="cursor: text;" autocomplete="off" type="text" name="multiwayfromtext2" id="fromdest_show2" class="multi_roundwayfrom form-control wrapper-dropdown-8" placeholder="From">
												<i class="fas fa-plane"></i>
												<div class="location_search selhide" id="location_search">
													<div class="inner_loc_search">
														<div class="top_city">
															<span>Top Cities</span>
														</div>
														<ul class="multi_is_search_from_val">
														@foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $alist)
															<li roundwayfromtop="{{$alist->city_code}}-{{$alist->city_name}}-{{$alist->country_name}}" roundwayfrom="{{$alist->city_name}}({{$alist->city_code}})">
																<div class="fli_name"><i class="fa fa-plane"></i> {{$alist->city_name}} ({{$alist->city_code}})</div>
																<div class="airport_name">{{$alist->airport_name}}<span>{{$alist->country_name}}</span></div>
															</li>
														@endforeach
														</ul>
													</div>
												</div> 
												<div id="swap" onclick="SwapRoundDestination();" class="swipe"></div>
											</div><!-- .form-group end -->
											<div class="form-group loc_search_field_to cus_loc_field">
											<input type="hidden" id="multi_roundtosearch2">
												<input did="s2" ssid="2" style="cursor: text;" autocomplete="off" type="text" name="multiwaytotext2" id="todest_show2" class="multi_roundwayto form-control wrapper-dropdown-9" placeholder="To">
												<i class="fas fa-plane"></i>
												<div class="location_search_to selhide" id="location_search_to"> 
													<div class="inner_loc_search">
														<div class="top_city">
															<span>Top Cities</span>
														</div>
														<ul class="multi_is_search_to_val">
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
												<input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" id="multipicker2"
													placeholder="2019/09/30">
												<i class="far fa-calendar"></i>
											</div><!-- .form-group end -->
											
											<a id="crs2" onclick="CloseSection('section-s2','')" class="closem" style="display:none;" href="javascript:;">
												<i class="fas fa-times"></i>
												
											</a>
											
											<div class="clearfix"></div>
									
										</div>
										<div class="ismultipleway" id="section-s3" style="display:none;">
										<div class="form-group loc_search_field cus_loc_field">
												<input type="hidden" id="multi_roundfromsearch3">
											
												<input did="s3" ssid="3" style="cursor: text;" autocomplete="off" type="text" name="multiwayfromtext3" id="fromdest_show3" class="multi_roundwayfrom form-control wrapper-dropdown-10" placeholder="From">
												<i class="fas fa-plane"></i>
												<div class="location_search selhide" id="location_search">
													<div class="inner_loc_search">
														<div class="top_city">
															<span>Top Cities</span>
														</div>
														<ul class="multi_is_search_from_val">
														@foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $alist)
															<li roundwayfromtop="{{$alist->city_code}}-{{$alist->city_name}}-{{$alist->country_name}}" roundwayfrom="{{$alist->city_name}}({{$alist->city_code}})">
																<div class="fli_name"><i class="fa fa-plane"></i> {{$alist->city_name}} ({{$alist->city_code}})</div>
																<div class="airport_name">{{$alist->airport_name}}<span>{{$alist->country_name}}</span></div>
															</li>
														@endforeach
														</ul>
													</div>
												</div> 
												<div id="swap" onclick="SwapRoundDestination();" class="swipe"></div>
											</div><!-- .form-group end -->
											<div class="form-group loc_search_field_to cus_loc_field">
											<input type="hidden" id="multi_roundtosearch3">
												<input did="s3" ssid="3" style="cursor: text;" autocomplete="off" type="text" name="multiwaytotext3" id="todest_show3" class="multi_roundwayto form-control wrapper-dropdown-11" placeholder="To">
												<i class="fas fa-plane"></i>
												<div class="location_search_to selhide" id="location_search_to"> 
													<div class="inner_loc_search">
														<div class="top_city">
															<span>Top Cities</span>
														</div>
														<ul class="multi_is_search_to_val">
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
												<input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" id="multipicker3"
													placeholder="2019/09/30">
												<i class="far fa-calendar"></i>
											</div><!-- .form-group end -->
											
											<a id="crs3" onclick="CloseSection('section-s3','')" class="closem" href="javascript:;">
												<i class="fas fa-times"></i>
												
											</a>
											
											<div class="clearfix"></div>
									
										</div>
										<div class="ismultipleway" id="section-s4" style="display:none;">
										<div class="form-group loc_search_field cus_loc_field">
												<input type="hidden" id="multi_roundfromsearch4">
											
												<input did="s4" ssid="4" style="cursor: text;" autocomplete="off" type="text" name="multiwayfromtext4" id="fromdest_show4" class="multi_roundwayfrom form-control wrapper-dropdown-12" placeholder="From">
												<i class="fas fa-plane"></i>
												<div class="location_search selhide" id="location_search">
													<div class="inner_loc_search">
														<div class="top_city">
															<span>Top Cities</span>
														</div>
														<ul class="multi_is_search_from_val">
														@foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $alist)
															<li roundwayfromtop="{{$alist->city_code}}-{{$alist->city_name}}-{{$alist->country_name}}" roundwayfrom="{{$alist->city_name}}({{$alist->city_code}})">
																<div class="fli_name"><i class="fa fa-plane"></i> {{$alist->city_name}} ({{$alist->city_code}})</div>
																<div class="airport_name">{{$alist->airport_name}}<span>{{$alist->country_name}}</span></div>
															</li>
														@endforeach
														</ul>
													</div>
												</div> 
												<div id="swap" onclick="SwapRoundDestination();" class="swipe"></div>
											</div><!-- .form-group end -->
											<div class="form-group loc_search_field_to cus_loc_field">
											<input type="hidden" id="multi_roundtosearch4">
												<input did="s4" ssid="4" style="cursor: text;" autocomplete="off" type="text" name="multiwaytotext4" id="todest_show4" class="multi_roundwayto form-control wrapper-dropdown-13" placeholder="To">
												<i class="fas fa-plane"></i>
												<div class="location_search_to selhide" id="location_search_to"> 
													<div class="inner_loc_search">
														<div class="top_city">
															<span>Top Cities</span>
														</div>
														<ul class="multi_is_search_to_val">
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
												<input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" id="multipicker4"
													placeholder="2019/09/30">
												<i class="far fa-calendar"></i>
											</div><!-- .form-group end -->
											
											<a  id="crs4" class="closem" onclick="CloseSection('section-s4',3)" href="javascript:;">
												<i class="fas fa-times"></i>
											
											</a>
											
											<div class="clearfix"></div>
									
										</div>
										<div class="ismultipleway" id="section-s5" style="display:none;">
										<div class="form-group loc_search_field cus_loc_field">
												<input type="hidden" id="multi_roundfromsearch5">
										
												<input did="s5" ssid="5" style="cursor: text;" autocomplete="off" type="text" name="multiwayfromtext5" id="fromdest_show5" class="multi_roundwayfrom form-control wrapper-dropdown-14" placeholder="From">
												<i class="fas fa-plane"></i>
												<div class="location_search selhide" id="location_search">
													<div class="inner_loc_search">
														<div class="top_city">
															<span>Top Cities</span>
														</div>
														<ul class="multi_is_search_from_val">
														@foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $alist)
															<li roundwayfromtop="{{$alist->city_code}}-{{$alist->city_name}}-{{$alist->country_name}}" roundwayfrom="{{$alist->city_name}}({{$alist->city_code}})">
																<div class="fli_name"><i class="fa fa-plane"></i> {{$alist->city_name}} ({{$alist->city_code}})</div>
																<div class="airport_name">{{$alist->airport_name}}<span>{{$alist->country_name}}</span></div>
															</li>
														@endforeach
														</ul>
													</div>
												</div> 
												<div id="swap" onclick="SwapRoundDestination();" class="swipe"></div>
											</div><!-- .form-group end -->
											<div class="form-group loc_search_field_to cus_loc_field">
											<input type="hidden" id="multi_roundtosearch5">
												<input did="s5" ssid="5" style="cursor: text;" autocomplete="off" type="text" name="multiwaytotext5" id="todest_show5" class="multi_roundwayto form-control wrapper-dropdown-15" placeholder="To">
												<i class="fas fa-plane"></i>
												<div class="location_search_to selhide" id="location_search_to"> 
													<div class="inner_loc_search">
														<div class="top_city">
															<span>Top Cities</span>
														</div>
														<ul class="multi_is_search_to_val">
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
												<input autocomplete="off" type="text" name="brTimeStart" value="" class="form-control" id="multipicker5"
													placeholder="2019/09/30">
												<i class="far fa-calendar"></i>
											</div><!-- .form-group end -->
											
											<a  id="crs5" onclick="CloseSection('section-s5',4)" class="closem" href="javascript:;">
												<i class="fas fa-times"></i>
												
											</a>
											
											<div class="clearfix"></div>
									
										</div>
										<div class="ismultipleway" id="section-s6" style="display:none;">
										<div class="form-group loc_search_field cus_loc_field">
												<input type="hidden" id="multi_roundfromsearch6">
												<input type="hidden" id="journey_type" value="3">
												<input did="s6" ssid="6" style="cursor: text;" autocomplete="off" type="text" name="multiwayfromtext6" id="fromdest_show6" class="multi_roundwayfrom form-control wrapper-dropdown-16" placeholder="From">
												<i class="fas fa-plane"></i>
												<div class="location_search selhide" id="location_search">
													<div class="inner_loc_search">
														<div class="top_city">
															<span>Top Cities</span>
														</div>
														<ul class="multi_is_search_from_val">
														@foreach(\App\Airport::where('top_cities','1')->orderby('priority','ASC')->get() as $alist)
															<li roundwayfromtop="{{$alist->city_code}}-{{$alist->city_name}}-{{$alist->country_name}}" roundwayfrom="{{$alist->city_name}}({{$alist->city_code}})">
																<div class="fli_name"><i class="fa fa-plane"></i> {{$alist->city_name}} ({{$alist->city_code}})</div>
																<div class="airport_name">{{$alist->airport_name}}<span>{{$alist->country_name}}</span></div>
															</li>
														@endforeach
														</ul>
													</div>
												</div> 
												<div id="swap" onclick="SwapRoundDestination();" class="swipe"></div>
											</div><!-- .form-group end -->
											<div class="form-group loc_search_field_to cus_loc_field">
											<input type="hidden" id="multi_roundtosearch6">
												<input did="s6" ssid="6" style="cursor: text;" autocomplete="off" type="text" name="multiwaytotext6" id="todest_show6" class="multi_roundwayto form-control wrapper-dropdown-17" placeholder="To">
												<i class="fas fa-plane"></i>
												<div class="location_search_to selhide" id="location_search_to"> 
													<div class="inner_loc_search">
														<div class="top_city">
															<span>Top Cities</span>
														</div>
														<ul class="multi_is_search_to_val">
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
												<input autocomplete="off" type="text" name="brTimeStart6" value="" class="form-control" id="multipicker6"
													placeholder="2019/09/30">
												<i class="far fa-calendar"></i>
											</div><!-- .form-group end -->
											
											<a  id="crs6" onclick="CloseSection('section-s6',5)" class="closem" href="javascript:;">
												<i class="fas fa-times"></i>
											
											</a>
											
											<div class="clearfix"></div>
									
										</div>
										<div class="addcity" id="addAnFlt">
											<a  class="if_multicity_trip btn-multiple-destinations btn x-small colorful hover-dark adm" href="javascript:;">
												<i class="fas fa-plus"></i>
												Add City
											</a>
										</div>
									</form>
									</li>
									
								</ul><!-- .br-tabs-content end -->
								<div class="advanced_option"><a href="javascript:;">Advanced Search Option <i class="fa fa-plus"></i></a>
									<ul class="list-select-grade list_grade">
										<li>
											<label class="radio-container radio-default">
												<input class="roundseatclass" value="2" type="radio" checked="checked" name="radio">
												<span class="checkmark"></span>
												Economy
											</label>
										</li>
										<li>
											<label class="radio-container radio-default">
												<input class="roundseatclass" value="3" type="radio"  name="radio">
												<span class="checkmark"></span>
												Premium Economy
											</label>
										</li>
										<li>
											<label class="radio-container radio-default">
												<input class="roundseatclass" value="4" type="radio" name="radio">
												<span class="checkmark"></span>
												Business
											</label>
										</li>
										<li>
											<label class="radio-container radio-default">
												<input class="roundseatclass" value="6" type="radio"  name="radio">
												<span class="checkmark"></span>
												First
											</label>
										</li>											
										<li>
											<label class="label-container checkbox-default">
												<span>Nonstop</span>
												<input id="roundis_non_stop" value="1" type="checkbox">
												<span class="checkmark"></span>
											</label>
										</li>
									</ul><!-- .list-select-grade end -->
								</div>
								<div class="clearfix"></div>
							</div><!-- .banner-reservation-tabs end -->
						</div><!-- .banner-center-box end -->
		
					</div><!-- .col-md-12 end -->
				</div><!-- .row end -->
			</div><!-- .container end -->
		</div><!-- .slide-content end -->
	</div><!-- .banner-parallax end -->
 
</section><!-- #banner end -->

<div id="section-services-1" class="section-flat custom_service" style="background: #f5f5f5; margin-top: 0px;">
	<div class="section-content">		
		<div class="container">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-2">
					<div class="box-info box-service-1">
						<div class="box-icon">
							<i class="fas fa-tags"></i>
						</div><!-- .box-icon end -->
						<div class="box-content">
							<h4><a href="javascript:;">Best Price Guarantee</a></h4>
							<!--<p>Find a lower price? we'll refund you 200% of the difference.</p>-->
						</div><!-- .box-content end -->
					</div><!-- .box-info box-service-1 end -->
				</div><!-- .col-md-4 end -->
				<div class="col-md-2">						
					<div class="box-info box-service-1 mt-md-50">
						<div class="box-icon">
							<i class="fas fa-smile"></i>
						</div><!-- .box-icon end -->
						<div class="box-content">
							<h4><a href="javascript:;">Easy Booking</a></h4>
							<!--<p>We’re always here for you – reach us 24 hours a day, 7 days a week.</p>-->
						</div><!-- .box-content end -->
					</div><!-- .box-info box-service-1 end -->						
				</div><!-- .col-md-4 end -->
				<div class="col-md-2">						
					<div class="box-info box-service-1 mt-md-50">
						<div class="box-icon">
							<i class="fas fa-search"></i>
						</div><!-- .box-icon end -->
						<div class="box-content">
							<h4><a href="javascript:;">No Hidden Charges</a></h4>
							<!--<p>Book Flight, Hotel, Holiday and Sightseeing/Activities in 3 Simple Steps</p>-->
						</div><!-- .box-content end -->
					</div><!-- .box-info box-service-1 end -->						
				</div><!-- .col-md-4 end -->
				<div class="col-md-2">						
					<div class="box-info box-service-1 mt-md-50">
						<div class="box-icon">
							<i class="fas fa-globe"></i>
						</div><!-- .box-icon end -->
						<div class="box-content">
							<h4><a href="javascript:;">Worldwide Connectivity</a></h4>
							<!--<p>Book Flight, Hotel, Holiday and Sightseeing/Activities in 3 Simple Steps</p>-->
						</div><!-- .box-content end -->
					</div><!-- .box-info box-service-1 end -->						
				</div><!-- .col-md-4 end -->
				<div class="col-md-2">						
					<div class="box-info box-service-1 mt-md-50">
						<div class="box-icon"> 
							<i class="fas fa-headset"></i>
						</div><!-- .box-icon end -->
						<div class="box-content">
							<h4><a href="javascript:;">Awarded is top Tour operator by several</a></h4>
							<!--<p>Book Flight, Hotel, Holiday and Sightseeing/Activities in 3 Simple Steps</p>-->
						</div><!-- .box-content end -->
					</div><!-- .box-info box-service-1 end -->						
				</div><!-- .col-md-4 end -->
			</div><!-- .row end -->
		</div><!-- .container end -->		
	</div><!-- .section-content end -->		
</div>

<div class="best_offer">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="inner_best_offer">
					<h3>Best Offers</h3>
					<ul class="nav nav-tabs custom_tabs">
						<li class="active"><a  href="#alloffer" aria-controls="alloffer" role="tab" data-toggle="tab">All Offers</a></li>
						<li class=""><a href="#flight" aria-controls="flight" role="tab" data-toggle="tab">Flight</a></li>
						<!--<li class=""><a href="#hotel" aria-controls="hotel" role="tab" data-toggle="tab">Hotel</a></li>-->
					</ul>   
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="alloffer">
							<div class="swiper-container">
								<div class="swiper-wrapper">
									<?php
										$today = date('Y-m-d');
										$coupondetails = \App\Coupon::whereDate('start_date','<=', $today)->whereDate('end_date','>=', $today)->where('status',1)->get();
										?>
										@foreach($coupondetails as $coupondetail)
										<?php
											$image = \App\MediaImage::where('id', $coupondetail->image)->first();
									?>
									<div class="swiper-slide">
										<div class="item">
											<div class="item-left">
												<img class="item-left-img" src="{!! asset('public/img/media_gallery/'.$image->images) !!}" alt="">
											</div>
											<div class="item-right"> 
												<h2 class="title">{{$coupondetail->coupon_name}}</h2>
												<p class="desc">{{$coupondetail->shortdescription}}</p>
												<div class="promocode_desc">
													<span class="promcde">Promocode</span>
													<span class="coupncde" id="{{$coupondetail->coupon_code}}">{{$coupondetail->coupon_code}}</span>
												</div>
												<!--<a href="#" class="coupon_btn"><i class="fa fa-arrow-right"></i></a>-->
											</div>
										</div>
									</div>
									@endforeach
								</div>										
							</div>
							<div class="swiper_button">
								<div class="swiper-button-prev"></div>
								<div class="swiper-button-next"></div>
							</div>	
						</div>
						<div role="tabpanel" class="tab-pane" id="flight">
							<div class="banner_offer">
								<img class="img-fluid" src="{!! asset('public/images/convenience_img.jpg') !!}" alt="">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Content
		============================================= -->
<section id="content">
	<div id="content-wrap">
		<!-- === Section Top Destinations =========== -->
		<div id="section-top-destintations" class="section-flat hidden">
			<div class="section-content">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<div class="section-title">
								<h2><strong>Top</strong> Destinations</h2>
							</div><!-- .section-title end -->

						</div><!-- .col-md-6 end -->
					</div><!-- .row end -->
				</div><!-- .container end -->
				<div class="container">
					<div class="row">
						<div class="col-md-12">				
							<div class="slider-top-destinations">
								<ul class="slick-slider">
									<li>
										<div class="box-preview box-area-destination">
											<div class="box-img img-bg">
												<a href="javascript:;"><img src="{!! asset('public/images/img-2.jpg') !!}" alt=""></a>
												<div class="overlay">
													<div class="overlay-inner">
													</div><!-- .overlay-inner end -->
												</div><!-- .overlay end -->
											</div><!-- .box-img end -->
											<div class="box-content">
												<i class="fas fa-map-marker-alt"></i>
												<div class="title">
													<h5><a href="javascript:;">South America</a></h5>
													<h6>3 Tours</h6>
												</div><!-- .title end -->
											</div><!-- .box-content end -->
										</div><!-- .box-preview end -->
									</li>
									<li>
										<div class="box-preview box-area-destination">
											<div class="box-img img-bg">
												<a href="javascript:;"><img src="{!! asset('public/images/img-3.jpg') !!}" alt=""></a>
												<div class="overlay">
													<div class="overlay-inner">
													</div><!-- .overlay-inner end -->
												</div><!-- .overlay end -->
											</div><!-- .box-img end -->
											<div class="box-content">
												<i class="fas fa-map-marker-alt"></i>
												<div class="title">
													<h5><a href="javascript:;">Europe</a></h5>
													<h6>7 Tours</h6>
												</div><!-- .title end -->
											</div><!-- .box-content end -->
										</div><!-- .box-preview end -->
									</li>
									<li>
										<div class="box-preview box-area-destination">
											<div class="box-img img-bg">
												<a href="javascript:;"><img src="{!! asset('public/images/img-5.jpg') !!}" alt=""></a>
												<div class="overlay">
													<div class="overlay-inner">
													</div><!-- .overlay-inner end -->
												</div><!-- .overlay end -->
											</div><!-- .box-img end -->
											<div class="box-content">
												<i class="fas fa-map-marker-alt"></i>
												<div class="title">
													<h5><a href="javascript:;">Aisa</a></h5>
													<h6>2 Tours</h6>
												</div><!-- .title end -->
											</div><!-- .box-content end -->
										</div><!-- .box-preview end -->
									</li>
									<li>
										<div class="box-preview box-area-destination">
											<div class="box-img img-bg">
												<a href="javascript:;"><img src="{!! asset('public/images/img-6.jpg') !!}" alt=""></a>
												<div class="overlay">
													<div class="overlay-inner">
													</div><!-- .overlay-inner end -->
												</div><!-- .overlay end -->
											</div><!-- .box-img end -->
											<div class="box-content">
												<i class="fas fa-map-marker-alt"></i>
												<div class="title">
													<h5><a href="javascript:;">Africa</a></h5>
													<h6>5 Tours</h6>
												</div><!-- .title end -->
											</div><!-- .box-content end -->
										</div><!-- .box-preview end -->
									</li>
									<li>
										<div class="box-preview box-area-destination">
											<div class="box-img img-bg">
												<a href="javascript:;"><img src="{!! asset('public/images/img-4.jpg') !!}" alt=""></a>
												<div class="overlay">
													<div class="overlay-inner">
													</div><!-- .overlay-inner end -->
												</div><!-- .overlay end -->
											</div><!-- .box-img end -->
											<div class="box-content">
												<i class="fas fa-map-marker-alt"></i>
												<div class="title">
													<h5><a href="javascript:;">Australia</a></h5>
													<h6>6 Tours</h6>
												</div><!-- .title end -->
											</div><!-- .box-content end -->
										</div><!-- .box-preview end -->
									</li>
									<li>
										<div class="box-preview box-area-destination">
											<div class="box-img img-bg">
												<a href="javascript:;"><img src="{!! asset('public/images/img-2.jpg') !!}" alt=""></a>
												<div class="overlay">
													<div class="overlay-inner">
													</div><!-- .overlay-inner end -->
												</div><!-- .overlay end -->
											</div><!-- .box-img end -->
											<div class="box-content">
												<i class="fas fa-map-marker-alt"></i>
												<div class="title">
													<h5><a href="javascript:;">South America</a></h5>
													<h6>3 Tours</h6>
												</div><!-- .title end -->
											</div><!-- .box-content end -->
										</div><!-- .box-preview end -->
									</li>
									<li>
										<div class="box-preview box-area-destination">
											<div class="box-img img-bg">
												<a href="javascript:;"><img src="{!! asset('public/images/img-3.jpg') !!}" alt=""></a>
												<div class="overlay">
													<div class="overlay-inner">
													</div><!-- .overlay-inner end -->
												</div><!-- .overlay end -->
											</div><!-- .box-img end -->
											<div class="box-content">
												<i class="fas fa-map-marker-alt"></i>
												<div class="title">
													<h5><a href="javascript:;">Europe</a></h5>
													<h6>7 Tours</h6>
												</div><!-- .title end -->
											</div><!-- .box-content end -->
										</div><!-- .box-preview end -->
									</li>
								</ul><!-- .slick-slider end -->
								<div class="slick-arrows"></div><!-- .slick-arrows end -->
							</div><!-- .slider-top-destinations end -->
				
						</div><!-- .col-md-12 end -->
					</div><!-- .row end -->
				</div><!-- .container end -->
			</div><!-- .section-content end -->
		</div><!-- .section-flat end -->	
	</div><!-- #content-wrap -->
</section><!-- #content end -->
<section class="why_booking-area pb-50 pt-70 mt-20">
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<div class="why_booking-text mb-15">
					<h4>Why ZapBooking?</h4>
					<p>One of the leaders in the Indian travel industry, ZapBooking is the go-to platform for your travel needs. Find the best online flight tickets booking and hotel booking deals, and save money every time you hit the road for business or leisure.<span class="dots" id="dots">...</span><span class="more" id="more"> Visit the website, or download the iOS or Android ZapBooking travel app to book on-the-go. Registration Reward, HEG Coupon, exclusive coupons for air ticket and hotel discounts, user-friendly interface and secure payments channel will help you enjoy a seamless cheap flights and hotels booking experience.</span></p>
					<button onclick="myFunction(1)" id="myBtn"><i class='fa fa-plus'></i> Read more</button>
				</div>
			</div>
			<div class="col-sm-4"> 
				<div class="why_booking-text mb-15">
					<h4>Flight Booking with ZapBooking?</h4>
					<p>In a short span, ZapBooking has become a frontrunner in the online flight booking space. On a daily basis, thousands of travellers book cheap airline tickets with ZapBooking and score the lowest airfares in India. The success of ZapBooking in the<span class="dots" id="dots1">...</span><span class="more" id="more1"> flight booking industry does not only stem from its unbelievable deals and offers on international and domestic air tickets, but also the convenience of online booking. If you are planning to travel soon, then give ZapBooking a shot and immerse yourself in a flight booking experience that stands out.</span></p>
					<button onclick="myFunction(2)" id="myBtn1"><i class='fa fa-plus'></i> Read more</button>
				</div>  
			</div>  
			<div class="col-sm-4"> 
				<div class="why_booking-text mb-15">
					<h4>Hotel Booking with ZapBooking?</h4>
					<p>Stop spending hours on the internet, scouting the best hotel booking offer, and visit ZapBooking for guaranteed best prices for hotel rooms. From budget to luxury, choose the hotel category that suits you the best and pick your accommodation<span class="dots" id="dots2">...</span><span class="more" id="more2"> from an array of options. Whether you are going on an adventure trip or heading out on business, ZapBooking has the perfect hotel for you. So, what are you waiting for? Book now!</span></p>
					<button onclick="myFunction(3)" id="myBtn2"><i class='fa fa-plus'></i> Read more</button>
				</div>
			</div>
		</div> 
	</div>
</section>
<section class="subscribe-area pb-50 pt-70">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="subscribe-text mb-15">
					<span>Coupons, Special Offers and Promotions.</span>
					<h2>Sign up for Exclusive Offers</h2>
				</div>
			</div>
			<div class="col-md-6">
				<div class="subscribe-wrapper subscribe2-wrapper mb-15">
					<div class="subscribe-form">
						<form action="#">
							<input placeholder="enter your email address" type="email">
							<button>subscribe <i class="fas fa-long-arrow-alt-right"></i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div> 
</section>
<div class="mob_sticky_menu"> 
	<div class="container">
		<div class="row"> 
			<ul>
				<li><a href="{{URL::to('/')}}"><i class="fa fa-home"></i> Home</a></li>
				@if(Auth::user())
				<li><a href="{{URL::to('/my-profile')}}" class=""><i class="fa fa-user"></i> My Account</a></li>
				@else
					<li><a href="#" class="popup-btn-login"><i class="fa fa-user"></i> My Account</a></li>
				@endif
				@if(Auth::user())
				<li><a href="{{URL::to('/user')}}"><i class="fa fa-calendar"></i> My Booking</a></li>
			@else
				<li><a href="#"><i class="fa fa-calendar"></i> My Booking</a></li>
			@endif
			</ul>
		</div> 
	</div> 
</div> 
@endsection  