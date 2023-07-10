@extends('layouts.frontend')
@section('content')
<?php use App\Http\Controllers\PackageController; ?>
	<?php 
			$dest = json_decode($packagedetail);
			//echo '<pre>'; print_r($dest); die;
		?>

<section class="pack_details start_bg_zoom">
	<div class="wrapper">
		<div class="container-fluid"> 
			<div class="row"> 
				<div class="details_image">
					<img src="{{@$dest->data->image_gallery_path}}{{@$dest->data->package_detail->bamedia->images}}" class="img-fluid" alt=""/>
					<div class="opacity_banner"></div>
				</div> 
			</div>
		</div>
		<div class="container">
			<div class="pack_banner_title">
				<div class="inner_title">
					<span class="count_days">{{@$dest->data->package_detail->no_of_nights}} Nights / {{@$dest->data->package_detail->no_of_days}} Days</span> 
					<h1 class="fadeInUp animated mytitle"><span></span>{{@$dest->data->package_detail->package_name}}</h1>
					<p><i class="fa fa-map-marker"></i> {{@$dest->data->package_detail->details_day_night}}</p>
				</div>				
				<div class="pack_price"> 
					<span class="banner_code_span">Tour Code: <strong>{{@$dest->data->package_detail->tour_code}}</strong></span>	
				 @if(@$dest->data->package_detail->price_on_request == 1)
						<strong>Price On Request</strong>
					@else	 
						<?php
						$discount = (@$dest->data->package_detail->sales_price - @$dest->data->package_detail->offer_price) /100; 
						?>
						<span>Price:</span>
						<div class="price_val"><strike><strong><i class="fa fa-rupee-sign"></i> {{@$dest->data->package_detail->sales_price}}</strong></strike>
						<span class="actual_price"><i class="fa fa-rupee-sign"></i> {{$dest->data->package_detail->offer_price}}</span></div>
				@endif 
						
				</div>	
			</div>
		</div>  
	</div>
</section>     
  
<div class="details_main">
	<div class="container">
		<div class="row">
			<div class="col-sm-9">
				<div class="pack_info_details">
					<div class="pack_tabs">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#itinerary" aria-controls="itinerary" role="tab" data-toggle="tab">Itinerary</a></li>
							<li role="presentation"><a href="#visa" aria-controls="visa" role="tab" data-toggle="tab">Visa</a></li>
							<li role="presentation"><a href="#policy" aria-controls="policy" role="tab" data-toggle="tab">Policy</a></li>
							<li role="presentation"><a href="#similar_package" aria-controls="similar_package" role="tab" data-toggle="tab">Similar Packages</a></li>
						</ul>  
					</div>
					<!-- Tab panes --> 
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="itinerary">
							<div class="dayplan_filter">
								<div class="filter_tabs">
									<ul>
										<li class="active"><a href="javascript:;">Day Plan</a></li>
										<li><a href="javascript:;">Flight 2</a></li>
										<li><a href="javascript:;">Hotel 1</a></li>
										<li><a href="javascript:;">Transfers 2</a></li>
										<li><a href="javascript:;">Activities 5</a></li>
										<li><a href="javascript:;">Summary</a></li>
									</ul>
								</div>
								<div class="dayplan_list">
									<div class="datelist">
										<div class="makeflex">
											<p>Nov</p>
											<ul>
												<li class="dayactive"><a href="javascript:;">02</a></li>
												<li class=""><a href="javascript:;">03</a></li>
												<li class=""><a href="javascript:;">04</a></li>
												<li class=""><a href="javascript:;">05</a></li>
											</ul>
										</div>
									</div> 
									<div class="inner_dayplan">
										<div class="dayplan_1 cus_plan_col">
											<h4>Day 1 - <span>Arrival in Singapore</span></h4>
											<div class="flight_plan brdr_contain">
												<div class="plan_left">
													<div class="flight_route">
														<div class="flight_route_list">
															<ul>
																<li>
																	<img src="https://www.zapbooking.com/public/img/airline/SG.gif" alt="">
																	<div class="flight_name">SpiceJet<span class="flight_no">SG-8730</span></div>
																</li> 
																<li class="flight_timer">18:50 <span>DEL</span></li>
																<li><span class="duration"><span><i class="fa fa-clock"></i></span>02h 25m </span></li> 
																<li class="flight_timer">21:15 <span>HYD</span></li> 
																<li class="flight_baggage"><strong>Baggage</strong><span><b>Cabin:</b> 7Kgs</span><span><b>Check-in:</b> 30Kgs</span></li> 
															</ul>
															<div class="clearfix"></div> 
														</div>
													</div>
													<div class="layover_time">
														<div class="layover_txt">Layover:<span>10h : 30m</span></div>
													</div>
													<div class="flight_route"> 
														<div class="flight_route_list">
															<ul>
																<li>
																	<img src="https://www.zapbooking.com/public/img/airline/SG.gif" alt="">
																	<div class="flight_name">SpiceJet<span class="flight_no">SG-243</span></div>
																</li>
																<li class="flight_timer">07:45 <span>HYD</span></li>
																<li><span class="duration"><span><i class="fa fa-clock"></i></span>01h 00m </span></li>
																<li class="flight_timer">08:45 <span>BLR</span></li> 
																<li class="flight_baggage"><strong>Baggage</strong><span><b>Cabin:</b> 7Kgs</span><span><b>Check-in:</b> 30Kgs</span></li>
															</ul>
															<div class="clearfix"></div>
														</div>
													</div>
												</div>
												<div class="plan_right">
													<div class="plan_chg_remove">
														<a class="remove" href="javascript:;">Remove</a>
														<span class="link-separator">|</span>	
														<a class="change" href="javascript:;">Change</a>
													</div>
												</div>
												<div class="clearfix"></div>
											</div>
											<div class="joining-line"></div>
											<div class="transport_plan brdr_contain">
												<div class="plan_left">
													<div class="transport_img">
														<img class="" src="{!! asset('public/images/packages/group_transfer.png') !!}" alt="" />
													</div>  
													<div class="transport_text">
														<p>Airport to hotel in Singapore</p>
														<h5>Shared Transfer</h5>
														<div class="plan_facility">
															<ul>
																<li><span>Includes</span>Wifi</li>
															</ul>
														</div>
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="plan_right">
													<div class="plan_chg_remove">
														<a class="remove" href="javascript:;">Remove</a>
														<span class="link-separator">|</span>	
														<a class="change" href="javascript:;">Change</a>
													</div>
												</div>
												<div class="clearfix"></div>
											</div>
											<div class="joining-line ">Check-in to <b>Hotel in Singapore</b> @3 PM</div>
											<div class="hotel_plan brdr_contain">
												<div class="plan_left">
													<div class="hotel_img">
														<img class="" src="{!! asset('public/images/packages/pack_hotel_img.jpg') !!}" alt="" />
													</div> 
													<div class="hotel_info">
														<div class="hotel_tags"></div>
														<h5>Oxford Hotel - MMT Special</h5>
														<div class="hotel_rating">
															<ul>
																<li class="active"><i class="fa fa-star"></i></li>
																<li class="active"><i class="fa fa-star"></i></li>
																<li class="active"><i class="fa fa-star"></i></li>
																<li class=""><i class="fa fa-star"></i></li>
																<li class=""><i class="fa fa-star"></i></li>
															</ul>
														</div>
														<div class="hotel_address">
															<span>32 Sector Near Metro station, New Delhi</span>
														</div>
														<div class="plan_facility">
															<ul>
																<li><span>Dates</span>Mon, 2 Nov 2020</li>
																<li><span>Includes</span>Breakfast</li>
															</ul>
														</div> 
														<div class="pack_room_type">
															<p><span>Room Type</span>Standard Room <a href="javascript:;">Change Room</a></p>
														</div>
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="plan_right">
													<div class="plan_chg_remove">
														<a class="change" href="javascript:;">Change</a>
													</div>
												</div>
												<div class="clearfix"></div> 
											</div> 
											<div class="joining-line"></div>
											<div class="end_day_plan">
												<div class="plan_left makeFlex">
													<div class="end_day_icon">
														<i class="fa fa-glass-martini-alt"></i>
													</div>
													<div class="end_day_txt">
														<h5>End of day</h5>
														<p>Spend time at leisure or add an activity </p>
													</div>
													<div class="clearfix"></div>
												</div> 
												<div class="plan_right">
													<div class="plan_chg_remove">
														<a class="add_activity" href="javascript:;">Add Activity</a>
													</div>
												</div> 
												<div class="clearfix"></div>
											</div>
										</div>
										<div class="dayplan_2 cus_plan_col">
											<h4>Day 2 - <span>Singapore</span></h4>
											<div class="joining-line bubble first">Breakfast at <b>Hotel in Singapore</b></div>
											<div class="activity_plan brdr_contain">
												<div class="plan_left">
													<div class="activity_img">
														<img class="" src="{!! asset('public/images/packages/singapore_pack_img2.jpg') !!}" alt="" />
													</div> 
													<div class="activity_info">
														<span>Activity in Singapore</span>
														<h5>Half Day City Tour of Singapore with Shared Transfers</h5>
														<p>We begin our journey from Suntec City to see the Fountain of Wealth before continuing towards the Padang area, followed by a stop at the Mer <a href="javascript:;">Read More...</a></p>
														<div class="plan_facility">
															<ul>
																<li><span>Duration</span>4 hrs</li>
																<li><span>Suitable For</span>Adult, Child, Infants,Teens,Senior</li>
																<li><span>Transfers</span>Shared Transfer</li>
															</ul>
														</div> 
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="plan_right">
													<div class="plan_chg_remove">
														<a class="remove" href="javascript:;">Remove</a>
													</div>
												</div>
												<div class="clearfix"></div> 
											</div> 
											<div class="joining-line"></div>
											<div class="end_day_plan">
												<div class="plan_left makeFlex">
													<div class="end_day_icon">
														<i class="fa fa-glass-martini-alt"></i>
													</div>
													<div class="end_day_txt">
														<h5>End of day</h5>
														<p>Spend time at leisure or add an activity </p>
													</div>
													<div class="clearfix"></div>
												</div> 
												<div class="plan_right">
													<div class="plan_chg_remove">
														<a class="add_activity" href="javascript:;">Add Activity</a>
													</div>
												</div> 
												<div class="clearfix"></div>
											</div>
										</div>
										<div class="dayplan_3 cus_plan_col">
											<h4>Day 3 - <span>Singapore</span></h4>
											<div class="joining-line bubble first">Breakfast at <b>Hotel in Singapore</b></div>
											<div class="activity_plan brdr_contain">
												<div class="plan_left">
													<div class="activity_img">
														<img class="" src="{!! asset('public/images/packages/singapore_pack_img3.jpg') !!}" alt="" />
													</div> 
													<div class="activity_info">
														<span>Activity in Singapore</span>
														<h5>Universal Studios Singapore with Shared Transfer</h5>
														<p>Go beyond the screen and ride your favourite movies only at Universal Studios in Singapore. You will be picked up from your hotel around 9:4 <a href="javascript:;">Read More...</a></p>
														<div class="plan_facility">
															<ul>
																<li><span>Duration</span>8 hrs</li>
																<li><span>Suitable For</span>Adult, Child, Infants,Teens,Senior</li>
																<li><span>Transfers</span>Shared Transfer</li>
															</ul>
														</div> 
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="plan_right">
													<div class="plan_chg_remove">
														<a class="remove" href="javascript:;">Remove</a>
													</div>
												</div>
												<div class="clearfix"></div> 
											</div> 
											<div class="joining-line"></div>
											<div class="end_day_plan">
												<div class="plan_left makeFlex">
													<div class="end_day_icon">
														<i class="fa fa-glass-martini-alt"></i>
													</div>
													<div class="end_day_txt">
														<h5>End of day</h5>
														<p>Spend time at leisure or add an activity </p>
													</div>
													<div class="clearfix"></div>
												</div> 
												<div class="plan_right">
													<div class="plan_chg_remove">
														<a class="add_activity" href="javascript:;">Add Activity</a>
													</div>
												</div> 
												<div class="clearfix"></div>
											</div>
										</div>
										<div class="dayplan_4 cus_plan_col">
											<h4>Day 4 - <span>Singapore</span></h4>
											<div class="joining-line bubble first">Breakfast at <b>Hotel in Singapore</b></div>
											<div class="activity_plan brdr_contain">
												<div class="plan_left">
													<div class="activity_img"> 
														<img class="" src="{!! asset('public/images/packages/singapore_pack_img4.jpg') !!}" alt="" />
													</div> 
													<div class="activity_info">
														<span>Activity in Singapore</span>
														<h5>Sentosa Experiential Tour with Shared Transfers </h5>
														<p>"Take an exciting tour of State of Fun, Sentosa Island, filled with thrilling attractions and activities. You will be picked up from your ho <a href="javascript:;">Read More...</a></p>
														<div class="plan_facility">
															<ul>
																<li><span>Duration</span>8 hrs</li>
																<li><span>Suitable For</span>Adult, Child, Infants,Teens,Senior</li>
																<li><span>Transfers</span>Shared Transfer</li>
															</ul>
														</div> 
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="plan_right">
													<div class="plan_chg_remove">
														<a class="remove" href="javascript:;">Remove</a>
													</div>
												</div>
												<div class="clearfix"></div> 
											</div> 
											<div class="joining-line"></div>
											<div class="end_day_plan">
												<div class="plan_left makeFlex">
													<div class="end_day_icon">
														<i class="fa fa-glass-martini-alt"></i>
													</div>
													<div class="end_day_txt">
														<h5>End of day</h5>
														<p>Spend time at leisure or add an activity </p>
													</div>
													<div class="clearfix"></div>
												</div> 
												<div class="plan_right">
													<div class="plan_chg_remove">
														<a class="add_activity" href="javascript:;">Add Activity</a>
													</div>
												</div> 
												<div class="clearfix"></div>
											</div>
										</div>
										<div class="dayplan_5 cus_plan_col">
											<h4>Day 1 - <span>Arrival in Singapore</span></h4>
											<div class="joining-line bubble first">Breakfast at <b>Hotel in Singapore</b></div>
											<div class="joining-line">Checkout from <b>Hotel in Singapore</b></div>
											<div class="transport_plan brdr_contain">
												<div class="plan_left">
													<div class="transport_img">
														<img class="" src="{!! asset('public/images/packages/group_transfer.png') !!}" alt="" />
													</div>  
													<div class="transport_text">
														<p>Airport to hotel in Singapore</p>
														<h5>Shared Transfer</h5>
														<div class="plan_facility">
															<ul>
																<li><span>Includes</span>Wifi</li>
															</ul>
														</div>
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="plan_right">
													<div class="plan_chg_remove">
														<a class="remove" href="javascript:;">Remove</a>
														<span class="link-separator">|</span>	
														<a class="change" href="javascript:;">Change</a>
													</div>
												</div>
												<div class="clearfix"></div>
											</div>
											<div class="joining-line"></div>
											<div class="flight_plan brdr_contain">
												<div class="plan_left">
													<div class="flight_route">
														<div class="flight_route_list">
															<ul>
																<li>
																	<img src="https://www.zapbooking.com/public/img/airline/SG.gif" alt="">
																	<div class="flight_name">SpiceJet<span class="flight_no">SG-8730</span></div>
																</li> 
																<li class="flight_timer">18:50 <span>DEL</span></li>
																<li><span class="duration"><span><i class="fa fa-clock"></i></span>02h 25m </span></li> 
																<li class="flight_timer">21:15 <span>HYD</span></li> 
																<li class="flight_baggage"><strong>Baggage</strong><span><b>Cabin:</b> 7Kgs</span><span><b>Check-in:</b> 30Kgs</span></li> 
															</ul>
															<div class="clearfix"></div> 
														</div>
													</div>
													<div class="layover_time">
														<div class="layover_txt">Layover:<span>10h : 30m</span></div>
													</div>
													<div class="flight_route"> 
														<div class="flight_route_list">
															<ul>
																<li>
																	<img src="https://www.zapbooking.com/public/img/airline/SG.gif" alt="">
																	<div class="flight_name">SpiceJet<span class="flight_no">SG-243</span></div>
																</li>
																<li class="flight_timer">07:45 <span>HYD</span></li>
																<li><span class="duration"><span><i class="fa fa-clock"></i></span>01h 00m </span></li>
																<li class="flight_timer">08:45 <span>BLR</span></li> 
																<li class="flight_baggage"><strong>Baggage</strong><span><b>Cabin:</b> 7Kgs</span><span><b>Check-in:</b> 30Kgs</span></li>
															</ul>
															<div class="clearfix"></div>
														</div>
													</div>
												</div>
												<div class="plan_right">
													<div class="plan_chg_remove">
														<a class="remove" href="javascript:;">Remove</a>
														<span class="link-separator">|</span>	
														<a class="change" href="javascript:;">Change</a>
													</div>
												</div>
												<div class="clearfix"></div>
											</div>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="visa">...</div>
						<div role="tabpanel" class="tab-pane" id="policy">...</div>
						<div role="tabpanel" class="tab-pane" id="similar_package">...</div>
					</div> 
				</div>
			</div>	
		</div>	
	</div>	
</div>
@endsection