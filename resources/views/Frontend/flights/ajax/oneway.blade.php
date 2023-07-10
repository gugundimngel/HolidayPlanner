<div class="col-md-12">									
									<div class="page-single-content sidebar-left mt-20 oneway_search">
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
											<div class="col-lg-9 col-md-12 col-lg-push-3">
												<div class="content-main">
												<?php //echo '<pre>'; print_r($calenderresult); echo '<pre>'; die; ?> 
												@if(@$calenderresult->Response->Error->ErrorCode == 0)
													<div class="block-content-2 carousel_timer">
														<div class="owl-carousel owl-theme">
														@foreach($calenderresult->Response->SearchResults as $clis)
														<?php $depdate = date('Y-m-d', strtotime($clis->DepartureDate)) ?>
															<div class="item <?php if($depdate == $datedeparture){ echo 'chk_index'; } ?>">
																<h4><?php echo date('M d', strtotime($clis->DepartureDate)); ?></h4>
																<span><i class="fa fa-rupee-sign"></i> {{round($clis->Fare)}}</span>
															</div>
														@endforeach
															
														</div>
													</div><!-- .block-content-2 end -->
													@else
														{{$calenderresult->Response->Error->ErrorMessage}}
													@endif
													<div class="block_content">
														<div class="flight_info"> 
															<ul>
																<li>Airlines</li>
																<li>Depart</li>
																<li>Duration</li>
																<li>Arrive</li>
																<li class="price_control"><a href="#">Price <i class="fa fa-arrow-up"></i></a></li>
																<li></li>
															</ul>
															<div class="clearfix"></div>
														</div>  
													</div>
													
													<?php 
														$ir = 0;
													foreach($flightresult->Response->Results[0] as $res){ 
															
															?>
															<?php $countflighdata = count($res->Segments[0]); 
																
																	$ti = $countflighdata -1;
																
																
															?>
													<div class="block-content-2 custom_block_content">
														<div class="box-result custom_box_result">
															<ul class="list-search-result result_list">
																<li>
																	<img src="{{URL::to('/public/img/airline/')}}/{{$res->Segments[0][0]->Airline->AirlineCode}}.gif" alt="">
																	<div class="flight_name">{{$res->Segments[0][0]->Airline->AirlineName}}<span class="flight_no">{{$res->Segments[0][0]->Airline->AirlineCode}}-{{$res->Segments[0][0]->Airline->FlightNumber}}</span></div>
																</li>
															
																<li class="pad_left30">
																	<span class="date">{{date('h:i', strtotime($res->Segments[0][0]->Origin->DepTime))}}</span>
																	{{$res->Segments[0][0]->Origin->Airport->CityName}}
																</li>
																<li>
																
																	<span class="duration"><?php echo Controller::GetTimeduration($res->Segments[0][0]->Origin->DepTime, $res->Segments[0][$ti]->Destination->ArrTime); ?><span> 
																	@if(count($res->Segments[0]) > 1)
																	<?php echo count($res->Segments[0]); ?> stop
																@else 
																	non-stop
																	@endif
																</span></span>
																   
																</li> 
																<li class="pad_left30">
																	<span class="date">{{date('h:i', strtotime($res->Segments[0][$ti]->Destination->ArrTime))}}</span>
																	{{$res->Segments[0][$ti]->Destination->Airport->CityName}}	
															
																</li>
																<li class="price">
																	<i class="fa fa-rupee-sign"></i> {{round($res->Fare->PublishedFare)}}
																</li>  
																<li class="book_btn">
																	<a class="btn small colorful-transparent hover-colorful btn_green" href="{{URL::to('/Review/Checkout')}}?tid={{$flightresult->Response->TraceId}}&RIndex={{$res->ResultIndex}}">Book Now</a>
																</li>
															</ul><!-- .list-search-result end -->
															<div class="clearfix"></div>
															<div class="flight_details">
																<a href="javascript:;" dataid="{{$ir}}" class="details_btn">Fight Details</a>
																<div class="flight_details_info" id="show_{{$ir}}">
																	<ul class="nav nav-tabs custom_tabs">
																		<li class="active"><a href="#flightinfo{{$ir}}0" aria-controls="flightinfo" role="tab" data-toggle="tab">Flight Information</a></li>
																		<li class=""><a href="#faredetail{{$ir}}1" aria-controls="faredetail" role="tab" data-toggle="tab">Fare Details</a></li> 
																		<li class=""><a href="#baggageinfo{{$ir}}2" aria-controls="baggageinfo" role="tab" data-toggle="tab">Baggage Information</a></li>
																		<li class=""><a href="#cancellationrule{{$ir}}3" aria-controls="cancellationrule" role="tab" data-toggle="tab">Cancellation Rules</a></li>
																	</ul>
																	<div class="flight_details_close">
																		<a href="javascript:;"><i class="fa fa-times"></i></a>
																	</div>	
																	<div class="tab-content">
																		<div role="tabpanel" class="tab-pane active" id="flightinfo{{$ir}}0">
																		<?php 
																			$allflighdata = $res->Segments[0];
																		for($fl =0;$fl<count($allflighdata);$fl++){ ?>
																			<div class="flight_route">
																				<h4>{{$allflighdata[$fl]->Origin->Airport->AirportCode}} <span><i class="fa fa-arrow-right"></i></span> {{$allflighdata[$fl]->Destination->Airport->AirportCode}}</h4>
																				<div class="flight_route_list">
																					<ul>
																						<li>
																							<img src="{{URL::to('/public/img/airline/')}}/{{$allflighdata[$fl]->Airline->AirlineCode}}.gif" alt="">
																							<div class="flight_name">{{$allflighdata[$fl]->Airline->AirlineName}}<span class="flight_no">{{$allflighdata[$fl]->Airline->AirlineCode}}-{{$allflighdata[$fl]->Airline->FlightNumber}}</span></div>
																						</li>
																						<li class="flight_timer">
																							{{$allflighdata[$fl]->Origin->Airport->AirportCode}} {{date('h:i', strtotime($allflighdata[$fl]->Origin->DepTime))}} <span>{{date('D-d M Y', strtotime($allflighdata[$fl]->Origin->DepTime))}}</span>
																						</li>
																						<li>
																							<span class="duration"><span><i class="fa fa-clock"></i></span><?php echo Controller::GetTimeduration($allflighdata[$fl]->Origin->DepTime, $allflighdata[$fl]->Destination->ArrTime); ?> </span>
																						</li> 
																						<li class="flight_timer">
																							{{$allflighdata[$fl]->Destination->Airport->AirportCode}} {{date('h:i', strtotime($allflighdata[$fl]->Destination->ArrTime))}} <span>{{date('D-d M Y', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</span>
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
																								<tr>
																									<td><?php echo $farebrakdown[$fb]->PassengerCount ?> x  <?php if($farebrakdown[$fb]->PassengerType == 1){ echo 'Adults'; }else if($farebrakdown[$fb]->PassengerType == 2){ echo 'Child'; }else{ echo 'Infant'; } ?></td>
																									<td><i class="fa fa-rupee-sign"></i> <?php echo $farebrakdown[$fb]->BaseFare; ?></td>
																								</tr>
																								<?php } ?>
																								<tr>
																									<td><b>Total (Base Fare)</b></td>
																									<td><i class="fa fa-rupee-sign"></i> <?php echo $res->Fare->BaseFare; ?></td>
																								</tr>
																								<tr>
																									<td><b>Total Tax & Surcharge</b></td>
																									<td><i class="fa fa-rupee-sign"></i> <?php echo $res->Fare->Tax + $res->Fare->OtherCharges; ?></td>
																								</tr>
																								
																								<tr>
																									<td><b>Total</b></td>
																									<td><i class="fa fa-rupee-sign"></i> <?php echo round($res->Fare->PublishedFare); ?></td>
																								</tr>
																							</tbody>
																						</table>
																					</div>
																					<div class="col-sm-8">
																						<div class="fare_right fare_rules">
																							<h4>Fare Rules</h4>
																							<a href="#" class="refund_btn">@if($res->IsRefundable == 'true') Refundable @else Non-Refundable @endif</a>
																							<div class="clearfix"></div>
																							<div class="row">
																								<div class="col-sm-6">
																									<h5>Cancellation Charges</h5>
																									<table>
																										<tbody>
																											<tr>
																												<td>Before 4 hours Departure</td>
																												<td class="clr_td"><i class="fa fa-rupee-sign"></i> 2483</td>
																											</tr>
																											<tr>
																												<td>Holiday Planner Fee</td>
																												<td class="clr_td"><i class="fa fa-rupee-sign"></i> 300</td>
																											</tr>
																										</tbody>
																									</table>	
																								</div>     
																								<div class="col-sm-6">
																									<h5>Reschedule Charges</h5>
																									<table>
																										<tbody>
																											<tr>
																												<td>Before 4 hours Departure</td>
																												<td class="clr_td"><i class="fa fa-rupee-sign"></i> 3000</td>
																											</tr>
																											<tr>
																												<td>Holiday Planner Fee</td>
																												<td class="clr_td"><i class="fa fa-rupee-sign"></i> 300</td>
																											</tr>
																										</tbody>
																									</table>	
																								</div>
																								<div class="clearfix"></div>
																							</div>
																							<div class="terms_condition">
																								<h5>Terms & Conditions</h5>
																								<div class="term_list">
																				<ul>
																					<li>The charges will be on per passenger per sector</li>
																					<li>Rescheduling Charges = Rescheduling/Change Penalty + Fare Difference (if applicable)</li>
																					<li>Partial cancellation is not allowed on the flight tickets which are book under special discounted fares</li>
																					<li>In case, the customer have not cancelled the ticket within the stipulated time or no show then only statutory taxes are refundable from the respective airlines</li>
																					<li>For infants there is no baggage allowance</li>
																					<li>In certain situations of restricted cases, no amendments and cancellation is allowed</li>
																					<li>Penalty from airlines needs to be reconfirmed before any cancellation or amendments</li>
																					<li>Penalty changes in airline are indicative and can be changed without any prior notice</li>
																				</ul>
																								</div>
																							</div>
																						</div>
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
																			$allbaggagedata = $res->Segments[0];
																		for($flb =0;$flb<count($allbaggagedata);$flb++){ ?>
																				<div class="baggage_row">
																					<div class="col-sm-3">
																						<div class="baggage_value">
																						
																							<img src="{{URL::to('/public/img/airline/')}}/{{$allbaggagedata[$flb]->Airline->AirlineCode}}.gif" alt="">
																							<div class="flight_name"><span>{{$allbaggagedata[$flb]->Airline->AirlineName}}</span><span>{{$allbaggagedata[$flb]->Airline->AirlineCode}}-{{$allbaggagedata[$flb]->Airline->FlightNumber}}</span></div>
																						</div> 
																					</div>
																					<div class="col-sm-3">
																						<div class="baggage_value">
																							<span>{{$allbaggagedata[$flb]->Baggage}}</span>
																						</div>
																					</div>
																					<div class="col-sm-3">
																						<div class="baggage_value">
																							<span>{{$allbaggagedata[$flb]->CabinBaggage}}</span>
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
																						<a href="#" class="refund_btn">Refundable</a>
																						<div class="row">
																							<div class="col-sm-6">
																								<h5>Cancellation Charges</h5>
																								<table>
																									<tbody>
																										<tr>
																											<td>Before 4 hours Departure</td>
																											<td class="clr_td"><i class="fa fa-rupee-sign"></i> 2483</td>
																										</tr>
																										<tr>
																											<td>Holiday Planner Fee</td>
																											<td class="clr_td"><i class="fa fa-rupee-sign"></i> 300</td>
																										</tr>
																									</tbody>
																								</table>	
																							</div>     
																							<div class="col-sm-6">
																								<h5>Reschedule Charges</h5>
																								<table>
																									<tbody>
																										<tr>
																											<td>Before 4 hours Departure</td>
																											<td class="clr_td"><i class="fa fa-rupee-sign"></i> 3000</td>
																										</tr>
																										<tr>
																											<td>Holiday Planner Fee</td>
																											<td class="clr_td"><i class="fa fa-rupee-sign"></i> 300</td>
																										</tr>
																									</tbody>
																								</table>	
																							</div>
																							<div class="clearfix"></div>
																						</div>
																						<div class="terms_condition">
																							<h5>Terms & Conditions</h5>
																							<div class="term_list">
																			<ul>
																				<li>The charges will be on per passenger per sector</li>
																				<li>Rescheduling Charges = Rescheduling/Change Penalty + Fare Difference (if applicable)</li>
																				<li>Partial cancellation is not allowed on the flight tickets which are book under special discounted fares</li>
																				<li>In case, the customer have not cancelled the ticket within the stipulated time or no show then only statutory taxes are refundable from the respective airlines</li>
																				<li>For infants there is no baggage allowance</li>
																				<li>In certain situations of restricted cases, no amendments and cancellation is allowed</li>
																				<li>Penalty from airlines needs to be reconfirmed before any cancellation or amendments</li>
																				<li>Penalty changes in airline are indicative and can be changed without any prior notice</li>
																			</ul>
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
													<?php $ir++; } ?>
													
												</div><!-- .content-main end -->
										 
											</div><!-- .col-lg-9 end -->
											@endif
											<div class="col-lg-3 col-md-12 col-lg-pull-9">  
												<div class="sidebar style-1 custom_sidebar">
													<h3>Filter <span class="clearfilter">Clear All</span></h3>
													<div class="box-widget">
														<h5 class="box-title">Price Range</h5>
														<div class="box-content">
															<div class="slider-dragable-range slider-range-price">
																<input type="text" class="price">
																<div class="slider-range" data-slider-min-value="2996" data-slider-max-value="8309" data-range-start-value="4500" data-range-end-value="7590" data-slider-value-sign="Rs."></div>
															</div><!-- .slider-dragable-price end -->											 				
														</div><!-- .box-content end -->
													</div><!-- .box-widget end -->
													<div class="box-widget">
														<h5 class="box-title">Departure</h5>
														<div class="box-content">
															<div class="slider-dragable-range slider-range-price">
																<input type="text" class="price">
																<div class="slider-range" data-slider-min-value="0" data-slider-max-value="24" data-range-start-value="6"
																	data-range-end-value="16" data-slider-value-sign="hr "></div>
															</div><!-- .slider-dragable-range end -->
														</div><!-- .box-content end -->
													</div><!-- .box-widget end -->
													<div class="box-widget">   
														<h5 class="box-title">Return</h5>
														<div class="box-content">
															<div class="slider-dragable-range slider-range-price">
																<input type="text" class="price">
																<div class="slider-range" data-slider-min-value="0" data-slider-max-value="24" data-range-start-value="5"
																	data-range-end-value="18" data-slider-value-sign="hr "></div>
															</div><!-- .slider-dragable-price end -->
														</div><!-- .box-content end -->
													</div><!-- .box-widget end -->
													<div class="box-widget">
														<h5 class="box-title">Stops</h5>
														<div class="box-content">
															<ul class="check-boxes-custom list-checkboxes">
																<li>
																	<label class="label-container checkbox-default">All
																		<input type="checkbox">
																		<span class="checkmark"></span>
																	</label>
																</li>
																<li>
																	<label class="label-container checkbox-default">Non Stop
																		<input type="checkbox">
																		<span class="checkmark"></span>
																	</label>
																</li>
																<li>
																	<label class="label-container checkbox-default">1 Stop
																		<input type="checkbox">
																		<span class="checkmark"></span>
																	</label>
																</li>
																<li>
																	<label class="label-container checkbox-default">2 Stops
																		<input type="checkbox">
																		<span class="checkmark"></span>
																	</label>
																</li>
															</ul><!-- .check-boxes-custom end -->
														</div><!-- .box-content end -->
													</div><!-- .box-widget end -->
													<div class="box-widget">
														<h5 class="box-title">AirLine</h5>
														<div class="box-content">
															<ul class="check-boxes-custom list-checkboxes">
																<li>
																	<label class="label-container checkbox-default">All
																		<input type="checkbox">
																		<span class="checkmark"></span>
																	</label>
																</li>
																<li>
																	<label class="label-container checkbox-default">Egypt Air
																		<input type="checkbox">
																		<span class="checkmark"></span>
																	</label>
																</li>
															</ul><!-- .check-boxes-custom end -->
														</div><!-- .box-content end -->
													</div><!-- .box-widget end -->
													<div class="box-widget">
														<h5 class="box-title">Airport</h5>
														<div class="box-content">
															<ul class="check-boxes-custom list-checkboxes">
																<li>
																	<label class="label-container checkbox-default">All
																		<input type="checkbox">
																		<span class="checkmark"></span>
																	</label>
																</li>
															</ul><!-- .check-boxes-custom end -->
														</div><!-- .box-content end -->
													</div><!-- .box-widget end -->
													<div class="box-widget">
														<h5 class="box-title">Duration</h5>
														<div class="box-content">
															<div class="slider-dragable-range slider-range-time">
																<div class="time">
																	<span class="slider-time-1">8:00 AM</span> - <span class="slider-time-2">3:00 PM</span>
																</div><!-- .time end -->
																<div class="sliders_step1">
																	<div class="slider-range" data-time-start-minutes="480" data-time-end-minutes="900"></div>
																</div>
															</div><!-- .slider-range-time end -->
														</div><!-- .box-content end -->
													</div><!-- .box-widget end -->
												</div><!-- .sidebar end -->
										
											</div><!-- .col-lg-3 end -->
										</div><!-- .row end -->

									</div><!-- .page-single-content end -->
									
								</div><!-- .col-md-12 end -->