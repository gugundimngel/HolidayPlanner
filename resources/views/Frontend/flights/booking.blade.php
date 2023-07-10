@extends('layouts.frontend')
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
</style>

<section id="content">
<?php use App\Http\Controllers\Controller; ?>
<?php
$searchdata = Session::get('allrequest');
//echo '<pre>'; print_r($resultdata); die;
?>
			<div id="content-wrap">
				<!-- === Section Flat =========== -->
				<div class="section-flat single_sec_flat booking_sec">      
					<div class="section-content">
						<div class="container">
						<?php if(isset($_GET['isReturn'])){ ?>
						 {{ Form::open(array('url' => 'Flight/payment', 'name'=>"add-ticket", 'autocomplete'=>'off', "enctype"=>"multipart/form-data", "id" => "frm_Product")) }}
						 <?php }else{
							 ?>
						 {{ Form::open(array('url' => 'Flight/payment', 'name'=>"frmProduct", 'autocomplete'=>'off', "enctype"=>"multipart/form-data", "id" => "frm_Product")) }}
						  <?php
						 } ?>
						 <input id="hfTraceId" name="hfTraceId" type="hidden" value="{{@$resultdata->Response->TraceId}}"> 
						  <input id="IsIntr" name="IsIntr" type="hidden" value="{{@$_GET['IsInt']}}"> 
						 <?php if(isset($_GET['isReturn'])){ ?>
						 <input id="" name="hfIBRIndex" type="hidden" value="{{@$resultdataib->Response->Results->ResultIndex}}"> 
						 <input id="hfTraceId" name="IsReturn" type="hidden" value="1"> 
						
						 <?php }else{
							 ?>
							 <input id="hfTraceId" name="IsReturn" type="hidden" value="0"> 
							 <?php
						 } ?>
						 <input id="" name="hfRIndex" type="hidden" value="{{@$resultdata->Response->Results->ResultIndex}}"> 
							<div class="row">
								<div class="col-md-12">
									<div class="server-error"> 
						@include('../Elements/front-flash-message')
					</div>
								</div>
								<div class="col-md-9 col-sm-12">	
									<div class="booking_title">
										<h3><img src="{!! asset('public/images/review.png') !!}" alt=""/> Review Your Booking</h3>
										<a class="change_flight" href="{{URL::to('/FlightList/index')}}?srch={{$searchdata['srch']}}&px={{$searchdata['px']}}&cbn={{$searchdata['cbn']}}&nt={{$searchdata['nt']}}&jt={{$searchdata['jt']}}">Change Flight</a>
									</div>
									<div class="block-content-2 custom_block_content">
										<div class="box-result custom_box_result">
											<div class="flight_tags depart_tags">
												<span>Departure</span>
											</div>	
											<?php
											if(isset($resultdata->Response->Results->Segments[0])){
												$ir = 0;
											$res = $resultdata->Response->Results;
												$countflighdata = count($res->Segments[0]); 
												$allflighdata = $res->Segments[0];
												
											?>
											
											<!--<div class="total_time">
												<span>Total Time: 2h 10m</span>
											</div>-->
											<?php for($fl =0;$fl<count($allflighdata);$fl++){ ?>
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
													<strong>{{date('h:i', strtotime($allflighdata[$fl]->Origin->DepTime))}}</strong>
													<span class="date">{{date('D, d M Y', strtotime($allflighdata[$fl]->Origin->DepTime))}}</span>
													<span class="airport">{{$allflighdata[$fl]->Origin->Airport->AirportName}}  , {{$allflighdata[$fl]->Origin->Airport->Terminal}}</span>
												</li>
												<li class="flight_amenties">
													<div class="top"><span class="duration"><i class="fa fa-clock"></i> <?php echo Controller::GetFetilFlightTimeduration($allflighdata[$icf]); ?></span><span class="grey_rtbrder">|</span> <span class="meal"> <i class="fa fa-stop"></i>
													@if(count($res->Segments[0]) > 1)
														<?php echo count($res->Segments[0])-1; ?> stop
													@else 
													non-stop @endif</span><span class="grey_rtbrder">|</span> <span class="economy">
													<?php if($allflighdata[$fl]->CabinClass == 2){ echo 'Economy'; }else if($allflighdata[$fl]->CabinClass == 3){ echo 'PremiumEconomy'; }else if($allflighdata[$fl]->CabinClass == 4){ echo 'Business'; }else if($allflighdata[$fl]->CabinClass == 4){ echo 'PremiumBusiness'; }else if($allflighdata[$fl]->CabinClass == 6){ echo 'First'; }else{ echo 'All'; } ?>
													</span></div> 
													<div class="middle"><span class="txt"><i class="fa fa-plane"></i> Flight</span></div>
													<div class="bottom"><span class="wght">{{$allflighdata[$fl]->Baggage}}</span><span class="grey_rtbrder">|</span><span class="refundable">
													<?php 
											if($resultdata->Response->Results->IsRefundable){ 
												echo 'Refundable'; 
											}else{ echo 'Non Refundable'; } ?></span></div>
												</li>   
												<li class="flight_time">
													{{$allflighdata[$fl]->Destination->Airport->CityName}}, {{$allflighdata[$fl]->Destination->Airport->CountryCode}}
													<strong>{{date('h:i', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</strong>
													<span class="date">{{date('D, d M Y', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</span>
													<span class="airport">{{$allflighdata[$fl]->Destination->Airport->AirportName}}, {{$allflighdata[$fl]->Destination->Airport->Terminal}}</span>
												</li> 												
											</ul><!-- .list-search-result end -->
											<div class="clearfix"></div>
											<?php } ?>
											<?php } ?>
											
											
										</div><!-- .box-result end -->
										<?php 
										$is_return = 0;
										if(!empty($resultdataib)){ if(isset($resultdataib->Response->Results->Segments[0])){ 
											$is_return = 1;
											$resarrive = $resultdataib->Response->Results;
										
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
											<?php for($fla =0;$fla<count($arriveflighdata);$fla++){ ?>
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
													<strong>{{date('h:i', strtotime($arriveflighdata[$fla]->Origin->DepTime))}}</strong>
													<span class="date">{{date('D, d M Y', strtotime($arriveflighdata[$fla]->Origin->DepTime))}}</span>
													<span class="airport">{{$arriveflighdata[$fla]->Origin->Airport->AirportName}}  , {{$arriveflighdata[$fla]->Origin->Airport->Terminal}}</span>
												</li>
												<li class="flight_amenties">
													<div class="top"><span class="duration"><i class="fa fa-clock"></i> <?php echo Controller::GetTimeduration($arriveflighdata[$fla]->Origin->DepTime, $arriveflighdata[$fla]->Destination->ArrTime); ?></span><span class="grey_rtbrder">|</span> <span class="meal"><i class="fa fa-utensils"></i> Paid Meal</span><span class="grey_rtbrder">|</span> <span class="economy">Economy</span></div> 
													<div class="middle"><span class="txt"><i class="fa fa-plane"></i> Flight</span></div>
													<div class="bottom"><span class="wght">{{$arriveflighdata[$fla]->Baggage}}</span><span class="grey_rtbrder">|</span><span class="refundable">Partially Refundable</span></div>
												</li>    
												<li class="flight_time">
													{{$arriveflighdata[$fla]->Destination->Airport->CityName}}, {{$arriveflighdata[$fla]->Destination->Airport->CountryCode}}
													<strong>{{date('h:i', strtotime($arriveflighdata[$fla]->Destination->ArrTime))}}</strong>
													<span class="date">{{date('D, d M Y', strtotime($arriveflighdata[$fla]->Destination->ArrTime))}}</span>
													<span class="airport">{{$arriveflighdata[$fla]->Destination->Airport->AirportName}}, {{$arriveflighdata[$fla]->Destination->Airport->Terminal}}</span>
												</li> 												
											</ul><!-- .list-search-result end -->
											<div class="clearfix"></div>
											<?php } ?>
										</div><!-- .box-result end -->
										<?php } }?>
									</div><!-- .block-content-2 end -->
								
									<div class="booking_title">
										<h3><img src="{!! asset('public/images/travel-details.png') !!}" alt=""/> Enter Traveller Details</h3>
											@if(@Auth::user())<div class="sub_title">Welcome {{@Auth::user()->first_name}} {{Auth::user()->last_name}}</div> @else <div class="sub_title"><a href="javascript:;" class="open_signin">Sign in</a> to book faster and use eCash</div>@endif
									</div>
									
										<div class="custom_block_content signin_content"> 
											<div class="col-md-12 showiferror" style="display:none;">
												<span class="custom-error" role="alert"></span>
											</div>
											<div class="content_close"><a href="javascript:;"><i class="fa fa-times"></i></a></div>
											<div class="sign_label cus_label">Sign In Now</div>
											<div class="form_field"><input type="email" name="login_email" placeholder="Email Address" class="form-control" /></div>
											<div class="form_field"><input type="password" name="login_password" placeholder="Password" class="form-control" /><!--<a href="#">Forgot?</a>--></div>
											<div class="login_btn"><input type="button" name="submit" class="btn login" value="Login"/></div>
											<div class="or_txt">OR</div> 
											<div class="fb_txt"><a href="{{URL::to('/auth/facebook')}}"><i class="fab fa-facebook-f"></i></a></i></div>
										</div><!-- .block-content-2 end -->
									
									
										<div class="block-content-2 custom_block_content contact_detail">
											<div class="box-result custom_box_result">
												<div class="col-sm-2 contact_label cus_label">Contact Details</div>
												<div class="col-sm-10">
													<div class="form_field"><input data-valid="required" value="{{@Auth::user()->email}}"  type="email" name="email" placeholder="Email ID" class="form-control" /></div>
													<div class="form_field country_field"><div class="country_code"><input class="" id="telephone" type="tel" name="telephone" readonly ></div><div class="mobile_no"><input data-valid="required" value="{{@Auth::user()->phone}}"  id="phone" name="phone" type="tel" placeholder="Mobile Number" class="form-control"/></div></div>
													<p>Your booking details will be sent to this email address and mobile number.</p>
													<div class="checkbox label_checkbox">
														<label class="label-container checkbox-default"><input type="checkbox"/><span class="checkmark"></span> Also send my booking details on WhatsApp <div class="whatapp_icon"></div></label>
													</div>
												</div>   
												<div class="clearfix"></div>
												<div class="traveller_info">
													<h4>Traveller Information</h4>
													<div class="note"><span>Important Note:</span> Please ensure that the names of the passengers on the travel documents is the same as on their government issued identity proof.</div>
													<?php 
														$farebrakdowna = $res->FareBreakdown;
														//echo '<pre>'; print_r($farebrakdowna); die;
														for($ic=0;$ic < count($farebrakdowna); $ic++){
															for($ics=1;$ics <= $farebrakdowna[$ic]->PassengerCount; $ics++){
													?>
													<div class="row">
													<div class="col-sm-12">
													<div class="col-sm-2 contact_label cus_label"><?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'Adults'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'Child'; }else{ echo 'Infant'; } ?> {{$ics}}</div>
													<div class="col-sm-10">
														<div class="form_field form_select_field">
															<select data-valid="required" class="form-control" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adulttitle[]'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childtitle[]'; }else{ echo 'infanttitle[]'; } ?>">
																<option value="">Title</option>
																<?php if($farebrakdowna[$ic]->PassengerType == 1){
																	?>
																	<option selected value="Mr">Mr.</option>
																<option value="Mrs">Mrs.</option>
																<option value="Ms">Ms.</option>
																	<?php
																	}else{ ?>
																	<option selected value="Miss">Miss</option>
																<option value="Master">Master</option>
																	<?php } ?>
																
															</select> 
															<input data-valid="required" type="text" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultfirstname[]'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childfirstname[]'; }else{ echo 'infantfirstname[]'; } ?>" placeholder="First Name" class="form-control" />
														</div>
														<div class="form_field">
															<input data-valid="required" type="text" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultlastname[]'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childlastname[]'; }else{ echo 'infantlastname[]'; } ?>" placeholder="Last Name" class="form-control" />
														</div> 
														<?php if($farebrakdowna[$ic]->PassengerType != 1){ ?>
														<div class="form_field">
															<input data-valid="required" type="text" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultdob[]'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childdob[]'; }else{ echo 'infantdob[]'; } ?>" placeholder="Date of Birth" class="form-control datepicker-3-time-start" />
														</div> 
														<?php } ?>
													</div> 
													<div class="clearfix"></div>
													
													</div>
													</div>
													@if(isset($_GET['isINT']) && $_GET['isINT'] == '1')
													<div class="row">
													<div class="col-sm-12">
													<div class="col-sm-2 contact_label cus_label">Passport Detail</div>
													<div class="col-sm-10">
													
														<div class="form_field">
															<input data-valid="required" type="text" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultpassportno[]'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childpassportno[]'; }else{ echo 'infantpassportno[]'; } ?>" placeholder="Passport Number" class="form-control" />
														</div>
														<div class="form_field">
															<input data-valid="required" type="text" name="<?php if($farebrakdowna[$ic]->PassengerType == 1){ echo 'adultpassportdate[]'; }else if($farebrakdowna[$ic]->PassengerType == 2){ echo 'childpassportdate[]'; }else{ echo 'infantpassportdate[]'; } ?>" placeholder="Passport Expire date" class="form-control datepicker-3-time-start" />
														</div>
														
																											
													</div>
													<div class="clearfix"></div>
													</div>
													</div>
													@endif
															<?php } } ?>
												</div>
											</div><!-- .box-result end -->
										</div> 
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
																	<div class="form_field"><input type="text" class="form-control" name="gst_number"/></div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-sm-6 col-xs-6 col_xs_480">
														<div class="form-group">
															<div class="row">
																<label class="col-sm-4 col-xs-12 pad_rt0">Company Name:</label>
																<div class="col-sm-8 col-xs-12">
																	<div class="form_field"><input type="text" class="form-control" name="company_name"/></div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-sm-6 col-xs-6 col_xs_480">
														<div class="form-group">
															<div class="row">
																<label class="col-sm-4 col-xs-12 pad_rt0">Email Id:</label>
																<div class="col-sm-8 col-xs-12">
																	<div class="form_field"><input type="email" class="form-control" name="emailid"/></div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-sm-6 col-xs-6 col_xs_480">
														<div class="form-group">
															<div class="row">
																<label class="col-sm-4 col-xs-12 pad_rt0">Mobile Number:</label>
																<div class="col-sm-8 col-xs-12">
																	<div class="form_field"><input type="text" class="form-control" name="mobile"/></div>
																</div>
															</div>
														</div>
													</div> 
													<div class="clearfix"></div>
													<div class="add_gst_btn">
														<button type="button" class="addgst"><i class="fa fa-plus"></i> Add GST</button>
													</div>
												</div>
											</div><!-- .box-result end -->
										</div> 
										<!--<div class="booking_title">
											<h3><img src="{!! asset('public/images/travel-insurance.png') !!}" alt=""/> Travel Insurance <span class="cus_span">(Recommended)</span></h3>
										</div>
										<div class="block-content-2 custom_block_content add_gst">
											<div class="box-result custom_box_result">
												<div class="checkbox label_checkbox">
													<label class="label-container checkbox-default"><input type="checkbox"/><span class="checkmark"></span> Yes, Add Travel Protection to protect my trip <span>(<i class="fa fa-rupee-sign"></i> per traveller)</span></label>  
												</div>
												<div class="travel_much">
													<p>6000+ travellers on Yatra protect their trip daily. <a href="#">Learn More</a></p>
												</div>
												<div class="view_benfits_sec">
													<p>Cover Includes</p> 
													<div class="insurence_list">
														<ul>
															<li>
																<i class="fa fa-plane"></i>
																<span class="insurence_name">Trip Cancellation</span>
																<div class="claim">
																	<span>Claim upto <i class="fa fa-rupee-sign"></i>25,000</span>
																</div>
															</li>
															<li>
																<i class="fa fa-hotel"></i>
																<span class="insurence_name">Flight Delay</span>
																<div class="claim">
																	<span>Claim upto <i class="fa fa-rupee-sign"></i>10,500</span>
																</div>
															</li> 
															<li>
																<i class="fa fa-suitcase"></i>
																<span class="insurence_name">Loss of Baggage</span>
																<div class="claim">
																	<span>Claim upto <i class="fa fa-rupee-sign"></i>20,000</span>
																</div>
															</li>
															<li>
																<i class="fa fa-ambulance"></i>
																<span class="insurence_name">Medical Emergency</span>
																<div class="claim">
																	<span>Claim upto <i class="fa fa-rupee-sign"></i>25,000</span>
																</div>
															</li>
															<li>
																<i class="fa fa-ambulance"></i>
																<div class="claim">
																	<span>Roadside & Medical Assistance</span>
																</div>
															</li>
														</ul>
														<div class="clearfix"></div>
													</div>
													<div class="insurance_note">
														<p>Note: Travel Protection is applicable only for Indian citizens below the age of 70 years. <a href="#">Terms & Conditions</a></p>
													</div> -->
													<!--<div class="insurance_holder">
														<span class="logo_cover_more ins_logo">
															<span>India</span>
														</span>
														<span class="logo_bharti_axa ins_logo">
 															<span>Insurance Provider</span>
														</span>

													</div>-->
												<!--</div>
											</div>
										</div>-->
										<?php
										if(@$ssrdata->Response->Error->ErrorCode == 0 && @$ssrdata->Response->Baggage !== null){
											 $isbag =0; foreach(@$ssrdata->Response->Baggage as $bsslist){ 
												foreach(@$bsslist as $bd_list){ if($bd_list->Price != 0){ $isbag++; } }}
												if($isbag > 0){
										?>
										<div class="booking_title">
											<h3>Baggage <span class="cus_span">(Optional)</span></h3>
										</div>	
										<div class="block-content-2 custom_block_content add_gst">
											<div class="box-result custom_box_result">
												<div class="service_req_sec">
												<ul class="nav nav-tabs custom_tabs"> 
														<li class="active"><a href="#addbaggage" aria-controls="addbaggage" role="tab" data-toggle="tab">Departure</a></li>
														@if($is_return == 1)
														<li class=""><a href="#addreturnbaggage" aria-controls="addreturnbaggage" role="tab" data-toggle="tab">Return</a></li>
													@endif
													</ul>
													<div class="tab-content">
														<div role="tabpanel" class="tab-pane active" id="addbaggage">
										<?php 
											if(@$ssrdata->Response->Error->ErrorCode == 0 && @$ssrdata->Response->Baggage !== null){ ?>		
											<?php $isbag =0; foreach(@$ssrdata->Response->Baggage as $bsslist){ 
												foreach(@$bsslist as $bd_list){ if($bd_list->Price != 0){ $isbag++; } }} ?>
													<?php if($isbag > 0){ ?>											
															<div class="service_req_list">
																<ul>  
																
																<?php  foreach(@$ssrdata->Response->Baggage as $blist){ 
																	foreach(@$blist as $b_list){ 
											
																	if($b_list->Price != 0){
																?>		
																	<li class="selectbag" dataweight="{{$b_list->Weight}}" dataprice="{{$b_list->Price}}">
																		<input name="onward" type="checkbox" />
																		<img src="{{URL::to('/html')}}/images/travel-bag.png" alt=""/>
																		<span class="baggage_type">Additional</span>
																		<span class="baggage_name">{{$b_list->Weight}}</span>
																		<span class="baggage_price"><i class="fa fa-rupee-sign"></i> {{number_format($b_list->Price)}}</span>
																		<span class="baggage_select"><a href="javascript:;">Select</a></span>
																	</li> 
																	<?php } } } ?>
																	
																</ul> 
																<div class="clearfix"></div>
															</div>	
											<?php }else{ echo ''; } ?>
											<?php } ?>
														</div>	
														<div role="tabpanel" class="tab-pane" id="addreturnbaggage">
														<?php 
										if(!empty($ssrdataib)){
										if(@$ssrdataib->Response->Error->ErrorCode == 0 && @$ssrdataib->Response->Baggage !== null){ ?>
											<?php $isbag =0; foreach(@$ssrdataib->Response->Baggage as $bsslist){ 
												foreach(@$bsslist as $bd_list){ if($bd_list->Price != 0){ $isbag++; } }} ?>
													<?php if($isbag > 0){ ?>
													<div class="service_req_list">
																<ul>  
																
																<?php  foreach(@$ssrdataib->Response->Baggage as $blist){ 
																	foreach(@$blist as $b_list){ 
											
																	if($b_list->Price != 0){
																?>		
																	<li class="returnselectbag" dataweight="{{$b_list->Weight}}" dataprice={{$b_list->Price}}>
																	<input  name="return" type="checkbox" />
																		<img src="{{URL::to('/html')}}/images/travel-bag.png" alt=""/>
																		<span class="baggage_type">Additional</span>
																		<span class="baggage_name">{{$b_list->Weight}}</span>
																		<span class="baggage_price"><i class="fa fa-rupee-sign"></i> {{number_format($b_list->Price)}}</span>
																		<span class="baggage_select"><a href="javascript:;">Select</a></span>
																	</li> 
																	<?php } } } ?>
																	
																</ul> 
																<div class="clearfix"></div>
															</div>	
													<?php }else{ echo ''; } ?>
										<?php } }  ?>
														</div>
													</div>
												</div>
											</div><!-- .box-result end -->
										</div>
									<?php } } ?>
										
										<?php
										if(@$ssrdata->Response->Error->ErrorCode == 0 && @$ssrdata->Response->MealDynamic !== null){
											$ismeal =0; foreach(@$ssrdata->Response->MealDynamic as $bsslist){ 
												foreach(@$bsslist as $ml_list){ if($ml_list->Price != 0){ $ismeal++; } }}
											if($ismeal > 0){ 
										?>
										<div class="booking_title">
											<h3>Meals <span class="cus_span">(Optional)</span></h3>
										</div>	
										<div class="block-content-2 custom_block_content add_gst">
											<div class="box-result custom_box_result">
												<div class="service_req_sec">
												
													<ul class="nav nav-tabs custom_tabs"> 
														<li class="active"><a href="#addmeal" aria-controls="addmeal" role="tab" data-toggle="tab">Departure</a></li>
														@if($is_return == 1)
														<li class=""><a href="#addreturnmeal" aria-controls="addreturnmeal" role="tab" data-toggle="tab">Return</a></li>
													@endif
													</ul>
													<div class="tab-content">
														<div role="tabpanel" class="tab-pane active" id="addmeal">
										<?php 
									
										if(@$ssrdata->Response->Error->ErrorCode == 0 && @$ssrdata->Response->MealDynamic !== null){ ?>	
											
												<?php if($ismeal > 0){ ?>										
															<div class="service_req_list">
																<ul>  
																<?php  foreach(@$ssrdata->Response->MealDynamic as $mlist){ 
																	foreach(@$mlist as $m_list){ 
											
																	if($m_list->Price != 0){
																?>		
																	<li class="selectmeal" dataweight="{{$m_list->Code}}" dataprice="{{$m_list->Price}}">
																	<input  name="onwarmeal" type="checkbox" />
																		<img src="{{URL::to('/html')}}/images/lunch-1593666-1348717.png" alt=""/>
																		<span class="baggage_type">Additional</span>
																		<span class="baggage_name">{{$m_list->AirlineDescription}}</span>
																		<span class="baggage_price"><i class="fa fa-rupee-sign"></i> {{number_format($m_list->Price)}}</span>
																		<span class="baggage_select"><a href="javascript:;">Select</a></span>
																	</li> 
																	<?php } } } ?>
																	
																</ul> 
																<div class="clearfix"></div>
															</div>
											<?php }  } ?>															
														</div>
														<div role="tabpanel" class="tab-pane" id="addreturnmeal">
															<?php 
															if(!empty($ssrdataib)){
																if(@$ssrdataib->Response->Error->ErrorCode == 0 && @$ssrdataib->Response->MealDynamic !== null){
															?>
															<?php $ismeal =0; foreach(@$ssrdataib->Response->MealDynamic as $bsslist){ 
																foreach(@$bsslist as $ml_list){ if($ml_list->Price != 0){ $ismeal++; } }} ?>
																<?php if($ismeal > 0){ ?>
																<div class="service_req_list">
																<ul>  
																<?php  foreach(@$ssrdataib->Response->MealDynamic as $mlist){ 
																	foreach(@$mlist as $m_list){ 
											
																	if($m_list->Price != 0){
																?>		
																	<li class="selectmeal" dataweight="{{$m_list->Code}}" dataprice="{{$m_list->Price}}">
																	<input  name="returnmeal" type="checkbox" />
																		<img src="{{URL::to('/html')}}/images/lunch-1593666-1348717.png" alt=""/>
																		<span class="baggage_type">Additional</span>
																		<span class="baggage_name">{{$m_list->AirlineDescription}}</span>
																		<span class="baggage_price"><i class="fa fa-rupee-sign"></i> {{number_format($m_list->Price)}}</span>
																		<span class="baggage_select"><a href="javascript:;">Select</a></span>
																	</li> 
																	<?php } } } ?>
																	
																</ul> 
																<div class="clearfix"></div>
															</div>	
																<?php } ?>
															<?php } } ?>
														</div>													
													</div>
										
												</div>
											</div><!-- .box-result end -->
										</div>
											<?php } } ?>
								</div>
								<div class="col-md-3 col-sm-12">	
									<div class="booking_sidebar">	
										<h4>Fare Details</h4>
										<a href="#">View Fare Rules</a> 
										<div class="fare_rules sidebar_bgclr inner_sidebar">
											<ul>
											<?php 
											$farebrakdown = $res->FareBreakdown;
										
											if(!empty($resultdataib) && isset($resultdataib->Response->Results->Segments[0])){ 
												$farebrakdownR = $resarrive->FareBreakdown; 
												?>
												<?php $vasefarec = 0; for($fbs = 0; $fbs<count($farebrakdown); $fbs++){ $vasefarec += $farebrakdown[$fbs]->BaseFare + $farebrakdownR[$fbs]->BaseFare; }  ?>
												<li class="basefare">Base Fare <small>(<?php echo count($farebrakdown); ?> Traveller)</small> <i class="fa fa-angle-down"></i>
													<span class="price"><i class="fa fa-rupee-sign"></i> {{number_format($vasefarec)}}</span>
													<ul class="inner_ul">
														<?php for($fb = 0; $fb<count($farebrakdown); $fb++){ ?>
														<li><?php if($farebrakdown[$fb]->PassengerType == 1){ echo 'Adults'; }else if($farebrakdown[$fb]->PassengerType == 2){ echo 'Child'; }else{ echo 'Infant'; } ?>  x <?php echo $farebrakdown[$fb]->PassengerCount ?>  <span class="price"><i class="fa fa-rupee-sign"></i> <?php echo number_format($farebrakdown[$fb]->BaseFare + $farebrakdownR[$fb]->BaseFare); ?></span></li>
														<?php } ?>
													</ul>
												</li> 
												<li class="fee_subcharge">Taxes & Subcharges <!--<i class="fa fa-angle-down"></i>-->
												<?php  if(@$_GET['IsInt'] == 'False'){ $is_international = 'domestic'; }else{ $is_international = 'international'; }?>
												@if($res->Fare->PublishedFare == $res->Fare->OfferedFare)
												<?php $markupamt = \App\Markup::where('flight_code', $res->Segments[0][0]->Airline->AirlineCode)->where('commission_type', 2)->where('flight_type', $is_international)->first(); 
											
													$markupd =0;
													if($markupamt){
														if($markupamt->service_type == 'fixed'){
															$markupd =  $markupamt->service_fee;
														}else{
															$markupd = ($res->Fare->PublishedFare * $markupamt->service_fee/100);
														}
													}
												
													?>
										@else
											<?php $markupamt = \App\Markup::where('flight_code', $res->Segments[0][0]->Airline->AirlineCode)->where('commission_type', 1)->where('flight_type', $is_international)->first(); 
											$markupd =0;
											if($markupamt){
												if($markupamt->service_type == 'fixed'){
													$markupd =  $markupamt->service_fee;
												}else{
													$markupd = ($res->Fare->PublishedFare * $markupamt->service_fee/100);
												}
											}
											?>
																			@endif
													@if($resarrive->Fare->PublishedFare == $resarrive->Fare->OfferedFare)
												<?php $retmarkupamt = \App\Markup::where('flight_code', $resarrive->Segments[0][0]->Airline->AirlineCode)->where('commission_type', 2)->where('flight_type', $is_international)->first(); 
													$remarkupd =0;
													if($retmarkupamt){
														if($retmarkupamt->service_type == 'fixed'){
															$remarkupd =  $retmarkupamt->service_fee;
														}else{
															$remarkupd = ($resarrive->Fare->PublishedFare * $retmarkupamt->service_fee/100);
														}
													}
													?>
										@else
											<?php $retmarkupamt = \App\Markup::where('flight_code', $resarrive->Segments[0][0]->Airline->AirlineCode)->where('commission_type', 1)->where('flight_type', $is_international)->first(); 
											$remarkupd =0;
											if($retmarkupamt){
												if($retmarkupamt->service_type == 'fixed'){
													$remarkupd =  $retmarkupamt->service_fee;
												}else{
													$remarkupd = ($resarrive->Fare->PublishedFare * $retmarkupamt->service_fee/100);
												}
											}
											?>
																			@endif
													<span class="price"><i class="fa fa-rupee-sign"></i> <?php echo number_format($res->Fare->Tax + $res->Fare->OtherCharges + $res->Fare->AdditionalTxnFeePub + $resarrive->Fare->Tax + $resarrive->Fare->OtherCharges + $resarrive->Fare->AdditionalTxnFeePub + $markupd + $remarkupd); ?></span>
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
												
												<li class="total_value" totalfare="<?php echo round($res->Fare->PublishedFare + $resarrive->Fare->PublishedFare + $markupd + $remarkupd); ?>">Total Fare <span class="price"><i class="fa fa-rupee-sign"></i> <span class="totfare"><?php echo number_format(round($res->Fare->PublishedFare + $resarrive->Fare->PublishedFare + $markupd + $remarkupd)); ?></span></span>
												<input type="hidden" id="dep_we" value="0">
												<input type="hidden" id="ret_we" value="0">
												<input type="hidden" id="ret_meal" value="0">
												<input type="hidden" id="dep_meal" value="0">
												</li> 
												<li class="discount_value" style="display:none;"></li>
												<li class="you_pay">You Pay: <span class="price"><i class="fa fa-rupee-sign"></i> <span class="youpay"><?php echo number_format(round($res->Fare->PublishedFare + $resarrive->Fare->PublishedFare + $markupd + $remarkupd)); ?></span></span>
												</li>
												<?php
											}else{
												
												?>
												<?php if(@$_GET['IsInt']){ $is_international = 'international'; }else{ $is_international = 'domestic'; }?>
												@if($res->Fare->PublishedFare == $res->Fare->OfferedFare)
												<?php $markupamt = \App\Markup::where('flight_code', $res->Segments[0][0]->Airline->AirlineCode)->where('commission_type', 2)->where('flight_type', $is_international)->first(); 
													$markupd =0;
													if($markupamt){
														if($markupamt->service_type == 'fixed'){
															$markupd =  $markupamt->service_fee;
														}else{
															$markupd = ($res->Fare->PublishedFare * $markupamt->service_fee/100);
														}
													}
													?>
										@else
											<?php $markupamt = \App\Markup::where('flight_code', $res->Segments[0][0]->Airline->AirlineCode)->where('commission_type', 1)->where('flight_type', $is_international)->first(); 
											$markupd =0;
											if($markupamt){
												if($markupamt->service_type == 'fixed'){
													$markupd =  $markupamt->service_fee;
												}else{
													$markupd = ($res->Fare->PublishedFare * $markupamt->service_fee/100);
												}
											}
											?>
																			@endif
												<?php $vasefarec = 0; for($fbs = 0; $fbs<count($farebrakdown); $fbs++){ $vasefarec += $farebrakdown[$fbs]->BaseFare; }  ?>
												<li class="basefare">Base Fare <small>(<?php echo count($farebrakdown); ?> Traveller)</small> <i class="fa fa-angle-down"></i>
													<span class="price"><i class="fa fa-rupee-sign"></i> {{number_format($vasefarec)}}</span>
													<ul class="inner_ul">
														<?php for($fb = 0; $fb<count($farebrakdown); $fb++){ ?>
														<li><?php if($farebrakdown[$fb]->PassengerType == 1){ echo 'Adults'; }else if($farebrakdown[$fb]->PassengerType == 2){ echo 'Child'; }else{ echo 'Infant'; } ?>  x <?php echo $farebrakdown[$fb]->PassengerCount ?>  <span class="price"><i class="fa fa-rupee-sign"></i> <?php echo number_format($farebrakdown[$fb]->BaseFare); ?></span></li>
														<?php } ?>
													</ul>
												</li> 
												<li class="fee_subcharge">Fee & Subcharges <!--<i class="fa fa-angle-down"></i>-->
													<span class="price"><i class="fa fa-rupee-sign"></i> <?php echo number_format($res->Fare->Tax + $res->Fare->OtherCharges + $markupd); ?></span>
													<!--<ul class="inner_ul">
														<li>User Development Fee <span class="price"><i class="fa fa-rupee-sign"></i> 142</span></li>
														<li>GST <span class="price"><i class="fa fa-rupee-sign"></i> 254</span></li>
														<li>Airline Fuel Subcharges <span class="price"><i class="fa fa-rupee-sign"></i> 2,187</span></li>
													</ul>-->
												</li>
												<li style="display:none;" class="addons">Add-Ons <i class="fa fa-angle-down"></i>
													<span class="price"><i class="fa fa-rupee-sign"></i> <span class="addonprice">10</span></span>
													<small style="display:block;" class="addonname"></small>
													<ul class="inner_ul addonli">
														
													</ul>
												</li>
												
												<li class="total_value" totalfare="{{$res->Fare->PublishedFare + $markupd}}">Total Fare <span class="price"><i class="fa fa-rupee-sign"></i> <span class="totfare"><?php echo number_format(round($res->Fare->PublishedFare + $markupd)); ?></span></span>
												<input type="hidden" id="dep_we" value="0">
												<input type="hidden" id="ret_we" value="0">
												<input type="hidden" id="ret_meal" value="0">
												<input type="hidden" id="dep_meal" value="0">
												<input type="hidden" id="coupon_code" value="0">
												</li> 
												<li class="discount_value" style="display:none;"></li>
												<li class="you_pay">You Pay: <span class="price"><i class="fa fa-rupee-sign"></i> <span class="youpay"><?php echo number_format(round($res->Fare->PublishedFare + $markupd)); ?></span></span>
												</li>
												<?php
											}
											?>
											
												<!--<li class="earn">Earn <div style="display:inline-block;color:#db9a00;">eCash</div> <i class="fa fa-explanation"></i>: <span class="price"><i class="fa fa-rupee-sign"></i> 500</span>
												</li>-->
											</ul>
											<div class="clearfix"></div>
										</div>
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
												<div id="myUL" style="margin-top: 22px;">
												<?php 
												$today = date('Y-m-d');
													$coupons = \App\Coupon::whereDate('start_date','<=', $today)->whereDate('end_date','>=', $today)->where('status',1)->get();
													foreach($coupons as $coupon){
												?>
												<div class="form-group coupon_li">
													<div class="cus_radio">
														<label>
															<div class="radio_field"><input name="couponcode" value="{{$coupon->coupon_code}}" type="radio" class="coupon_apply" /><span class="checkradio"></span></div> 
															<div class="promo_content">
																<span class="promo_key">{{$coupon->coupon_code}}</span>
																<span class="promo_desc">{{$coupon->description}}</span>
															</div>
														</label>
														<!--<div class="promo_terms">
															<a href="#">Terms & Conditions</a>
														</div>-->
													</div>
												</div>
													<?php } ?>
												</div>
												<div id="loadMore" class="view_all">
													<a href="javascript:;">View All</a>
												</div>
												
											</div>
											<div class="booking_btn">
												<button type="button" onClick="customValidate('frmProduct')" class="pay_btn">Proceed to payment</button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 hidden-sm hidden-xs">
									<div class="booking_btn">
										<button type="button" onClick="customValidate('frmProduct')" class="pay_btn">Proceed to payment</button>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>	
							<input type="hidden" name="payment_method" value="ccavenue">
							  {{ Form::close() }}
						</div>	
					</div>	
				</div>	
			</div>	
			
		</section>	
		<script> 
		$(document).ready(function() {
			<?php
			if(@$resultdata->Response->IsPriceChanged){
				?>
				$('#farecheck').modal('show');
				<?php
			}
			?>
			$('input[name="return"]').on("click", function(){
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
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val());
				}else{
					var dataprice = 0; 
					var dataweight = 0; 
					var totalfare = $('.total_value').attr('totalfare'); 
					$('#ret_we').val(dataprice);
					$('.ret_dep_weight').remove();
					var dep = $('#dep_we').val();
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val());
				}
				if ($('ul.addonli').children('li').length == 0) {
					$('.addons').hide();
				}
			});
			$('input[name="onward"]').on("click", function(){
				$('.selectbag').removeClass('active');
				$('.dep_weight').remove();
				 if ($("input[name='onward']:checked").length > 0)
				{
					$(this).parent().addClass("active"); 
					var group = "input:checkbox[name='"+$(this).attr("name")+"']";
					$(group).attr("checked",false);
					$(this).attr("checked",true);
				 }else{
					  var group = "input:checkbox[name='"+$(this).attr("name")+"']";
					$(group).attr("checked",false);
				}
				
				 if ($("input[name='onward']:checked").length > 0)
				{
					var dataprice = $(this).parent().attr('dataprice'); 
					var dataweight = $(this).parent().attr('dataweight'); 
					var retprice = $('#ret_we').val();
					$('#dep_we').val(dataprice);
					var totalfare = $('.total_value').attr('totalfare'); 
					$('.addons').show();
					$('.addonli').append('<li class="dep_weight">Additional Weight '+dataweight+'kg <div class="fa_close"><i class="fa fa-times"></i></div> <span class="price"><i class="fa fa-rupee-sign"></i> '+dataprice+'</span></li>');
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val());
					
				}else{
					var dataprice = 0; 
					var dataweight = 0; 
					var totalfare = $('.total_value').attr('totalfare'); 
					$('#dep_we').val(dataprice);
					$('.dep_weight').remove();
					var retprice = $('#ret_we').val();
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val());
					
				}
				if ($('ul.addonli').children('li').length == 0) {
					$('.addons').hide();
				}
			});
			$('input[name="returnmeal"]').on("click", function(){
				$('.returnselectbag').removeClass('active');
				$('.ret_dep_meal').remove();
				 if ($("input[name='returnmeal']:checked").length > 0)
				{
					$(this).parent().addClass("active"); 
					var group = "input:checkbox[name='"+$(this).attr("name")+"']";
					$(group).attr("checked",false);
					$(this).attr("checked",true);
				 }else{
					  var group = "input:checkbox[name='"+$(this).attr("name")+"']";
					$(group).attr("checked",false);
				}
				 
				 if ($("input[name='returnmeal']:checked").length > 0)
				{
					var dataprice = $(this).parent().attr('dataprice'); 
					var dataweight = $(this).parent().attr('dataweight'); 
					var totalfare = $('.total_value').attr('totalfare'); 
					$('.addons').show();
					$('#ret_we').val(dataprice);
					$('#ret_meal').val(dataprice);
					var dep = $('#dep_we').val();
					var dep_meal = $('#dep_meal').val();
					
					$('.addonli').append('<li class="ret_dep_meal">Additional Meal '+dataweight+' <div class="fa_close"><i class="fa fa-times"></i></div> <span class="price"><i class="fa fa-rupee-sign"></i> '+dataprice+'</span></li>');
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val());
				}else{
					var dataprice = 0; 
					var dataweight = 0; 
					var totalfare = $('.total_value').attr('totalfare'); 
					$('#ret_we').val(dataprice);
					$('.ret_dep_meal').remove();
					var dep = $('#dep_we').val();
					
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val());
				}
				if ($('ul.addonli').children('li').length == 0) {
					$('.addons').hide();
				}
			});
			$('input[name="onwarmeal"]').on("click", function(){
				$('.selectmeal').removeClass('active');
				$('.dep_meal').remove();
				 if ($("input[name='onwarmeal']:checked").length > 0)
				{
					$(this).parent().addClass("active"); 
					var group = "input:checkbox[name='"+$(this).attr("name")+"']";
					$(group).attr("checked",false);
					$(this).attr("checked",true);
				 }else{
					  var group = "input:checkbox[name='"+$(this).attr("name")+"']";
					$(group).attr("checked",false);
				}
				
				 if ($("input[name='onwarmeal']:checked").length > 0)
				{
					var dataprice = $(this).parent().attr('dataprice'); 
					var dataweight = $(this).parent().attr('dataweight'); 
					var retprice = $('#ret_we').val();
					var dep_meal = $('#dep_meal').val();
					var retmealprice = $('#ret_meal').val();
					$('#ret_meal').val(dataprice);
					var totalfare = $('.total_value').attr('totalfare'); 
					$('.addons').show();
					$('.addonli').append('<li class="dep_meal">Additional Meal '+dataweight+' <div class="fa_close"><i class="fa fa-times"></i></div> <span class="price"><i class="fa fa-rupee-sign"></i> '+dataprice+'</span></li>');
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val());
				}else{
					var dataprice = 0; 
					var dataweight = 0; 
					var totalfare = $('.total_value').attr('totalfare'); 
					$('#ret_meal').val(dataprice);
					$('.dep_meal').remove();
					var retprice = $('#ret_we').val();
					var retmealprice = $('#ret_meal').val();
					calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), $('#coupon_code').val());
					
					
				}
				if ($('ul.addonli').children('li').length == 0) {
					$('.addons').hide();
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
					url:'{{URL::to('/Flight/ApplyCoupon')}}',
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
							calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), cp);
							$('.couponsuccess').css('color','#a8d845');
						}else{
							$('.promo_button').show();
							$('.clear_button').hide();
							$('#coupon_code').val(0);
							$('.discount_value').hide();
							$('.applytext').val('');
							$('.applytextvaue').val('');
							calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), 0);
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
				calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), 0);
				$('.couponsuccess').html('');
			});
			$(document).delegate('.coupon_apply', 'change', function(){
				var coupo = $("input[name='couponcode']:checked").val();
				$('.applytext').val(coupo);
				$.ajax({
					url:'{{URL::to('/Flight/ApplyCoupon')}}',
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
							calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), cp);
							$('.couponsuccess').css('color','#a8d845');
						}else{
							$('.promo_button').show();
							$('.clear_button').hide();
							$('#coupon_code').val(0);
							$('.discount_value').hide();
							$('.applytext').val('');
							$('.applytextvaue').val('');
							calculation($('#dep_we').val(), $('#ret_we').val(), $('#ret_meal').val(), $('#dep_meal').val(), 0);
							$('.couponsuccess').html(obj.message);
							$('.couponsuccess').css('color','#ff0000');
						}
					}
				});
			});
		
			function calculation(ob,rb,om,rm,cm){
				
				var totalfare = $('.total_value').attr('totalfare'); 
				var total = parseInt(totalfare) + parseInt(ob) + parseInt(rb) + parseInt(om) + parseInt(rm);
				var discount = 0;
				if(cm != 0){
					var value = cm.split('|');
					if(value[1] == 'percentage'){
						discount = (total * value[0]/100);
					}else{
						discount =  value[0];
					} 
				}
				$('.distotfare').html(discount.toLocaleString());
				var finaltotal = total - discount;
				var fn = Math.round(finaltotal);
				$('.addonprice').html(parseInt(ob) + parseInt(rb) + parseInt(om) + parseInt(rm));
				$('.totfare').html(total.toLocaleString());
					$('.youpay').html(fn.toLocaleString());
			}
			$('.fare_rules ul li.basefare').on("click", function(){ 
				$('.fare_rules ul li.basefare ul.inner_ul').toggleClass('show');
			});
			$('.fare_rules ul li.fee_subcharge').on("click", function(){ 
				$('.fare_rules ul li.fee_subcharge ul.inner_ul').toggleClass('show');
			});
			$('.fare_rules ul li.addons').on("click", function(){ 
				$('.fare_rules ul li.addons ul.inner_ul').toggleClass('show');
			});
			$('.booking_title a.open_signin').on("click", function(){ 
				$(this).toggleClass('open');
				$('.signin_content').toggleClass('show'); 
			});
			$('.signin_content .content_close').on("click", function(){ 
				$('.booking_title a.open_signin').removeClass('open');
				$('.signin_content').removeClass('show'); 
			});
			$('.add_gst .gst_btn a.add_link').on("click", function(){ 
				$(this).addClass('hide');
				$('.gst_form').toggleClass('show');
				$('.add_gst .gst_btn a.form_close').addClass('show');
			});
			$('.add_gst .gst_btn a.form_close').on("click", function(){ 
				$(this).removeClass('show');
				$('.add_gst .gst_btn a.add_link').removeClass('hide');
				$('.gst_form').toggleClass('show');   
			});  
			/* $('.service_req_list li span.baggage_select').on("click", function(){ 
				$(this).toggleClass('checked'); 
				$(this).parent('.service_req_list li').toggleClass('active');  
			});  */
	
			/* $('.pay_ticket').on('click', function(){
				
					if($("input:radio[name='paymentmethod']").is(":checked")) {
					alert();
				//$('#frmProduct').submit();
				document.getElementById('frmProduct').submit();
				 return false;
				}else{
					alert('Please check Payment Method');
				}
			}); */
		});

	</script>
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
														<label class=""><input type="radio" checked name="paymentmethod" value="ccavenue"> <img src="{{URL::to('/public/icons/cc_avenue1.png')}}"> </label>
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
@endsection