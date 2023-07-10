 @extends('layouts.frontend')
@section('title', 'Hotel Booking')
@section('content')
<?php
//echo '<pre>'; print_r($detail); die; 
?>
<!-- Content
		============================================= -->
<section id="content">
	<div id="content-wrap">
	{{ Form::open(array('url' => 'Hotel/Payment', 'name'=>"roomfrmProduct", 'autocomplete'=>'off', "enctype"=>"multipart/form-data", "id" => "roomfrm_Product")) }}
	<input type="hidden" value="{{$detail->search_id}}" name="searchid">	
	<input type="hidden" value="{{$detail->hotel->hotel_code}}" name="hotel_code">
	<input type="hidden" value="{{$detail->hotel->city_code}}" name="city_code">
	<input type="hidden" value="{{$detail->hotel->rates[$rm]->group_code}}" name="group_code">
	<input type="hidden" value="{{date('Y-m-d',strtotime($detail->checkin))}}" name="checkin">
	<input type="hidden" value="{{date('Y-m-d',strtotime($detail->checkout))}}" name="checkout">
	
	<input type="hidden" value="{{$detail->hotel->rates[$rm]->room_code}}" name="room_code">
	<input type="hidden" value="{{$detail->hotel->rates[$rm]->rate_key}}" name="rate_key">
	<input type="hidden" value="{{$rm}}" name="room">
		<!-- === Section Flat =========== -->
		<div class="section-flat single_sec_flat" style="background:#e8e8e8;">      
			<div class="section-content">
				<div class="container">
					<div class="row"> 
						<div class="inner_hotel_detail">	  
							<div class="col-sm-12">	 
								<div class="cus_breadcrumb">
									<ul>
										<li class="active"><a href="#">Home</a></li>
										<li><span><i class="fa fa-angle-right"></i></span></li>
										<li class="active"><a href="#">Hotel Booking</a></li>
										<li><span><i class="fa fa-angle-right"></i></span></li>
										<li><a href="#">{{$detail->hotel->name}}</a></li> 
									</ul> 
								</div>
							</div>
							<div class="col-md-9 col-sm-12">	 
								<div class="hotel_booking_info">
									<div class="inner_booking_info">
										<div class="room_img">
											<img src="{{$detail->hotel->images->url}}" alt=""/>
											<?php if(isset($detail->hotel->rates[$rm])){ 
											$rooms = $detail->hotel->rates[$rm];
											?>
											<a href="#" class="roomtype">{{$rooms->rooms[0]->room_type}}</a>
											<?php } ?>
										</div>  
										<div class="hotel_info_rgt">
											<div class="hotel_name">
												<h3>{{$detail->hotel->name}}</h3>
											</div>
											<div class="hotel_rating">
												@for($i=0; $i<@$detail->hotel->category; $i++)
													<i class="fa fa-star"></i>
												@endfor
											</div>
											<div class="hotel_address">
												<p><i class="fa fa-map-marker-alt"></i>{{$detail->hotel->address}}</p>
											</div>  
											<div class="checkin_out_date">
												<div class="room_checkin">
													<span class="chk_title">Check-In</span>
													<div class="check_date">
														<span class="check_day">{{date('d',strtotime($detail->checkin))}}</span>
														<span class="check_month_yr">{{date('M',strtotime($detail->checkin))}}<br/>{{date('Y',strtotime($detail->checkin))}}</span>
													</div>
												</div>
												<div class="room_checkout">
													<span class="chk_title">Check-Out</span>
													<div class="check_date">
														<span class="check_day">{{date('d',strtotime($detail->checkout))}}</span>
														<span class="check_month_yr">{{date('M',strtotime($detail->checkout))}}<br/>{{date('Y',strtotime($detail->checkout))}}</span>
													</div>
												</div>	
												<div class="clearfix"></div>
											</div>
											<div class="room_detail_sec">  
												<div class="room_detail_bg">
													<?php
														
														if(isset($detail->hotel->rates[$rm])){
															$rooms = $detail->hotel->rates[$rm];
															$i = 1;
														foreach($rooms->rooms as $key => $room){	
													?>
													<div class="room_detail_in">
														<span>Room {{$i}}:</span>
														<span>{{$room->no_of_adults}} Adults, @if($room->no_of_children != 0) {{$room->no_of_children}} Childs @endif</span>
													</div>
														<?php $i++; } ?>
														<?php } ?>
														<?php
														
														if(isset($detail->hotel->rates[1])){
															$rooms = $detail->hotel->rates[1];
															$i = 1;
														foreach($rooms->rooms as $key => $room){	
													?>
													<div class="room_detail_in">
														<span>Room {{$i}}:</span>
														<span>{{$room->no_of_adults}} Adults, @if($room->no_of_children != 0) {{$room->no_of_children}} Childs @endif</span>
													</div>
														<?php $i++; } ?>
														<?php } ?>
												</div>
											</div> 									
											<div class="room_cancelation">
												<a href="#">Cancellation Policy</a>
											</div>	
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="traveller_details">
										<div class="traveller_head">
											<h3><i class="fa fa-user"></i> Travellers Details</h3>
										</div>
										<div class="room_sec">
										<?php
														
											if(isset($detail->hotel->rates[$rm])){
												$rooms = $detail->hotel->rates[$rm];
												$is = 1;
											foreach($rooms->rooms as $key => $room){	
										?>
											<div class="room_count">
												<div class="circle">
													<span>Room {{$is}}</span>
												</div>
												<div class="no_of_passanger">
													<?php
													$sa = 1;
													for($ss=0; $ss<$room->no_of_adults; $ss++){
													?>
													<div class="no_of_adult">
														<div class="common_adult adult_{{$is}}">  
															<span>Adult {{$sa}}</span>
															<div class="form_group title_group">
																<label>Title</label>
																<select data-valid="required" name="adulttitle[{{$is}}][]" class="form-control">
																	<option value="Mr.">Mr.</option>
																	<option value="Ms.">Ms.</option>
																	<option value="Mrs.">Mrs.</option>
																</select>
															</div>
															<div class="form_group">
																<label>First Name</label>
																<input data-valid="required" name="firstname[{{$is}}][]" class="form-control"/>
															</div>
															<div class="form_group">
																<label>Last Name</label>
																<input data-valid="required" name="lastname[{{$is}}][]" class="form-control"/>
															</div>
															<div class="clearfix"></div>
														</div> 
														 
													</div>
													<?php $sa++; }
														if($room->no_of_children !=0){ 
														$sc = 1;
														for($s=0; $s<$room->no_of_children; $s++){
													?>
													<div class="no_of_adult">
														<div class="common_adult child_{{$is}}">  
															<span>Child {{$sc}}</span>
															<div class="form_group title_group">
																<label>Title</label>
																<select data-valid="required" name="childtitle[{{$is}}][]" class="form-control">
																	<option value="Mstr.">Master</option>
																	<option value="Mrs.">Miss</option>
																	
																</select>
															</div>
															<div class="form_group">
																<label>First Name</label>
																<input data-valid="required" name="childfirstname[{{$is}}][]" class="form-control"/>
															</div>
															<div class="form_group">
																<label>Last Name</label>
																<input data-valid="required" name="childlastname[{{$is}}][]" class="form-control"/>
															</div>
															<div class="clearfix"></div>
														</div>
													</div>
													<?php
														$sc++;
														}
													?>
													<?php  } ?>
												</div>
												<div class="clearfix"></div>
											</div>
												<?php $is++; } ?>
												<?php } ?>
												
												
												<?php
														
											if(isset($detail->hotel->rates[1])){
												$rooms = $detail->hotel->rates[1];
												$is = 2;
											foreach($rooms->rooms as $key => $room){	
										?>
											<div class="room_count">
												<div class="circle">
													<span>Room {{$is}}</span>
												</div>
												<div class="no_of_passanger">
													<?php
													$sa = 1;
													for($ss=0; $ss<$room->no_of_adults; $ss++){
													?>
													<div class="no_of_adult">
														<div class="common_adult adult_{{$is}}">  
															<span>Adult {{$sa}}</span>
															<div class="form_group title_group">
																<label>Title</label>
																<select data-valid="required" name="adulttitle[{{$is}}][]" class="form-control">
																	<option value="Mr.">Mr.</option>
																	<option value="Ms.">Ms.</option>
																	<option value="Mrs.">Mrs.</option>
																</select>
															</div>
															<div class="form_group">
																<label>First Name</label>
																<input data-valid="required" name="firstname[{{$is}}][]" class="form-control"/>
															</div>
															<div class="form_group">
																<label>Last Name</label>
																<input data-valid="required" name="lastname[{{$is}}][]" class="form-control"/>
															</div>
															<div class="clearfix"></div>
														</div> 
														 
													</div>
													<?php $sa++; }
														if($room->no_of_children !=0){ 
														$sc = 1;
														for($s=0; $s<$room->no_of_children; $s++){
													?>
													<div class="no_of_adult">
														<div class="common_adult child_{{$is}}">  
															<span>Child {{$sc}}</span>
															<div class="form_group title_group">
																<label>Title</label>
																<select data-valid="required" name="childtitle[{{$is}}][]" class="form-control">
																	<option value="Mstr.">Master</option>
																	<option value="Mrs.">Miss</option>
																	
																</select>
															</div>
															<div class="form_group">
																<label>First Name</label>
																<input data-valid="required" name="childfirstname[{{$is}}][]" class="form-control"/>
															</div>
															<div class="form_group">
																<label>Last Name</label>
																<input data-valid="required" name="childlastname[{{$is}}][]" class="form-control"/>
															</div>
															<div class="clearfix"></div>
														</div>
													</div>
													<?php
														$sc++;
														}
													?>
													<?php  } ?>
												</div>
												<div class="clearfix"></div>
											</div>
												<?php $is++; } ?>
												<?php } ?>
										</div>
										<div class="contact_info">
											<h4>Contact Details</h4>
											<div class="contact_field">
												<input data-valid="required" type="text" class="form-control" name="email" placeholder="Enter Email Address"/>
												<div class="select_wrapper">
													<select class="form-control">
														<option value="+91">+91</option>
												
													</select>
													<input data-valid="required" type="text" class="form-control" name="mobile" placeholder="Enter Mobile No" maxlength="10"/> 
												</div>
												<div class="clearfix"></div> 
											</div>  
											<div class="contact_note">
												<span>Your booking details will be sent to this email address and mobile number.</span>
											</div>
											<div class="gst_details">
												<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
													<div class="panel">
														<div class="panel-heading" role="tab" id="headingOne">
															<h4 class="panel-title">
																<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-controls="collapseOne">GST Details <span>(Optional)</span></a>
															</h4>
														</div> 
														<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
															<div class="panel-body">
																<div class="form-group">
																	<label>Email</label>
																	<input class="form-control" placeholder="Enter Email" name="gstemail" />
																</div>
																<div class="form-group">
																	<label>Mobile</label>
																	<input class="form-control" placeholder="Enter Mobile" name="gstemail"/>
																</div>
																<div class="form-group">
																	<label>GST No</label>
																	<input class="form-control" placeholder="Enter GST No" name="gst_no"/>
																</div>
																<div class="form-group">
																	<label>Company Name</label>
																	<input class="form-control" placeholder="Enter Company Name" name="company_name"/>
																</div> 
																<div class="form-group form_full"> 
																	<label>Address</label>
																	<textarea class="form-control" placeholder="Enter Address" name="address"></textarea>
																</div>
																<div class="clearfix"></div>
															</div>
														</div>
													</div>
												</div>
												<div class="check_box">
													<label>
														<input data-valid="required" type="checkbox" name="gst"/> I understand and agree to the rules of this fare, and the <a href="#" class="loadtc" target="_blank">Terms &amp; Conditions </a> of Holiday Planner
													</label>
												</div>
											</div> 
											<div class="booking_btn"> 
												<button type="button" onClick="customValidate('roomfrmProduct')" class="">Continue to Payment</button>
											</div> 
										</div>
									</div>
								</div> 
							</div> 
							<div class="col-md-3 col-sm-12">
								<div class="booking_sidebar"> 
									<h4>Room Price Details</h4> 
									<div class="side_box inner_sidebar">
										<div class="price_sec">
											<ul>
												<li>1 Rooms x  Night(s) <span><i class="fa fa-rupee-sign"></i> {{$detail->hotel->rates[$rm]->price_details->net[2]->amount}}</span></li>
												<!--<li>Hotel Promo Discount <span><i class="fa fa-rupee-sign"></i> 0</span></li>-->
												<li>Total Tax & Fee <span><i class="fa fa-rupee-sign"></i> {{$detail->hotel->rates[$rm]->price_details->GST[2]->amount}}</span></li>
												<li class="grand_total">Grand Total <span><i class="fa fa-rupee-sign"></i> {{$detail->hotel->rates[$rm]->price}}</span></li>
											</ul>
										</div>
									</div>	
									<h4>Promo Code</h4> 
									<div class="promo_code sidebar_bgclr inner_sidebar">
										<div class="inner_promo">
											<div class="form-group">
												<label class="promo_label">Select a Promo Code</label>
												<div class="promo_field"> 
													<input type="text" class="form-control applytext">
													<input type="hidden" name="coupncode" class="form-control applytextvaue">
													<button type="button" class="promo_button">Apply</button>
													<button type="button" style="display:none;" class="clear_button">Clear</button>
													<p class="couponsuccess" style="display:none;"></p>
												</div>
											</div>
											<div id="myUL" style="margin-top: 22px;"></div>
											<div id="loadMore" class="view_all">
												<a href="javascript:;">View All</a>
											</div>
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
		 {{ Form::close() }}
	</div>	
</section>	

@endsection