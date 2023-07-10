 @extends('layouts.frontend')
@section('title', 'Hotel Booking')
@section('content')
<?php
//echo '<pre>'; print_r($detail);
?>
<!-- Content
		============================================= -->
<section id="content">
	<div id="content-wrap">
	{{ Form::open(array('url' => 'Hotel/Payment', 'name'=>"roomfrmProduct", 'autocomplete'=>'off', "enctype"=>"multipart/form-data", "id" => "roomfrm_Product")) }}
	<input type="hidden" value="{{@$detail->search_id}}" name="searchid">	
	<input type="hidden" value="{{@$detail->hotel->hotel_code}}" name="hotel_code">
	<input type="hidden" value="{{@$detail->hotel->city_code}}" name="city_code">
	
	<input type="hidden" value="{{date('Y-m-d',strtotime($mydetail->checkin))}}" name="checkin">
	<input type="hidden" value="{{date('Y-m-d',strtotime($mydetail->checkout))}}" name="checkout">
	<?php
	
	if(isset($detail->hotel->rates[$rm])){
		?>
		<input type="hidden" value="{{$detail->hotel->rates[$rm]->group_code}}" name="group_code">
		<input type="hidden" value="{{$detail->hotel->rates[$rm]->room_code}}" name="room_code">
	<input type="hidden" value="{{$detail->hotel->rates[$rm]->rate_key}}" name="rate_key">
		<?php
	}else if(isset($detail->hotel->rate)){
			?>
			<input type="hidden" value="{{$detail->hotel->rate->group_code}}" name="group_code">
		<input type="hidden" value="{{$detail->hotel->rate->room_code}}" name="room_code">
	<input type="hidden" value="{{$detail->hotel->rate->rate_key}}" name="rate_key">
		<?php
	}
	?>
	
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
														<span class="check_day">{{date('d',strtotime($mydetail->checkin))}}</span>
														<span class="check_month_yr">{{date('M',strtotime($mydetail->checkin))}}<br/>{{date('Y',strtotime($mydetail->checkin))}}</span>
													</div>
												</div>
												<div class="room_checkout">
													<span class="chk_title">Check-Out</span>
													<div class="check_date">
														<span class="check_day">{{date('d',strtotime($mydetail->checkout))}}</span>
														<span class="check_month_yr">{{date('M',strtotime($mydetail->checkout))}}<br/>{{date('Y',strtotime($mydetail->checkout))}}</span>
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
												</div>
											</div> 									
											<div class="room_cancelation">
												<a href="javascript:;" data-toggle="modal" data-target="#essentailModal" style="margin-right: 10px;" class="showpolicy">Essential Information</a>
												<a href="javascript:;" data-toggle="modal" data-target="#mypolicyModal" class="showpolicy">Cancellation Policy</a>
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
										$panrequired = false;
											if(isset($detail->hotel->rates[$rm])){
												$rooms = $detail->hotel->rates[$rm];
												if(isset($rooms->pan_required) && $rooms->pan_required){
													$panrequired = true;
												}
											}else if( isset($detail->hotel->rate)){
												$rooms = $detail->hotel->rate;
												if(isset($rooms->pan_required) && $rooms->pan_required){
													$panrequired = true;
												}
											}												
											if(isset($detail->hotel->rates[$rm])  || isset($detail->hotel->rate)){
												
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
																	<option value="">Title</option>
																	<option value="Mstr">Master</option>
																	<option value="Mrs">Miss</option>
																	
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
											<div class="contactemail">
											<div class="form-group">
												<input  data-valid="required" type="text" class="form-control" name="email" placeholder="Enter Email Address"/>
												</div>
												</div>
												<div class="select_wrapper">
												<div class="form-group">
													<select class="form-control">
														<option value="+91">+91</option>
												
													</select>
													<input data-valid="required" type="text" class="form-control" name="mobile" placeholder="Enter Mobile No" maxlength="10"/> 
												</div>
												</div>
												
												<div class="clearfix"></div> 
											</div>  
											<div class="contact_field">
											@if($panrequired)<div class="contactemail"><div class="form-group">
												
													<input style="margin-top: 10px;" data-valid="required" type="text" class="form-control" name="pan" placeholder="Enter PAN"/>
												
												
											</div></div><div class="clearfix"></div>  @endif 
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
									<?php if(isset($detail->hotel->rates[$rm]->boarding_details)){ ?>
									<div class="boarding_info" style="border-bottom: 10px solid #e8e8e8;padding: 15px;">
									<h4>Boarding Details </h4>
									<?php
									foreach($detail->hotel->rates[$rm]->boarding_details as $boarding_details){
										?>
										<p>{{@$boarding_details}}</p>
										<?php
									}
									?>
									</div>
									<?php }else if(isset($detail->hotel->rate->boarding_details)){ ?>
									<div class="boarding_info" style="border-bottom: 10px solid #e8e8e8;padding: 15px;">
									<h4>Boarding Details </h4>
									<?php
									foreach($detail->hotel->rate->boarding_details as $boarding_details){
										?>
										<p>{{@$boarding_details}}</p>
										<?php
									}
									?>
									</div>
									<?php } ?>
								
							
								</div> 
							</div> 
							<div class="col-md-3 col-sm-12">
								<div class="booking_sidebar"> 
									<h4>Room Price Details</h4> 
									<div class="side_box inner_sidebar">
										<div class="price_sec">
											<ul>
												<li>1 Rooms x  Night(s) <span><i class="fa fa-rupee-sign"></i> 
											<?php
											$baseprice = 0;
											if(isset($detail->hotel->rates[$rm])){
												$baseprice = $detail->hotel->rates[$rm]->price_details->net[2]->amount;
												?>
												{{$detail->hotel->rates[$rm]->price_details->net[2]->amount}}
												<?php
											}else if(isset($detail->hotel->rate)){
												$baseprice = $detail->hotel->rate->price_details->net[2]->amount;
												?>
												{{$detail->hotel->rate->price_details->net[2]->amount}}
												<?php
											}
											?>	</span></li>
												<!--<li>Hotel Promo Discount <span><i class="fa fa-rupee-sign"></i> 0</span></li>-->
												<li>Total Tax & Fee <span><i class="fa fa-rupee-sign"></i> 
												
										<?php
								$isdomestic = @$detail->hotel->country;
								$hotel_code = @$detail->hotel->hotel_code;
								$city_code = @$detail->hotel->city_code;
								
									if($isdomestic == 'IN'){
										$type = 'domestic';
									}else{
										$type = 'international';
									}
									if(\App\HotelMarkup::where('markup_type', 'hotel_wise')->where('hotel_code', $hotel_code)->exists()){
										$hotelmarkup  = \App\HotelMarkup::where('markup_type', 'hotel_wise')->where('hotel_code', $hotel_code)->first();
						
									}
									else if(\App\HotelMarkup::where('markup_type', 'city_wise')->where('city_code', $city_code)->exists()){
										$hotelmarkup  = \App\HotelMarkup::where('markup_type', 'city_wise')->where('city_code', $city_code)->first();
										
									}else if(\App\HotelMarkup::where('markup_type', $type)->exists()){
										$hotelmarkup  = \App\HotelMarkup::where('markup_type', $type)->first();
									}
									$amount = 0;
									$mainamount = 0;
									$tax = 0;
									if(isset($detail->hotel->rates[$rm])){
										$tax = number_format($detail->hotel->rates[$rm]->price_details->GST[2]->amount,2,'.','');
									}else{
										$tax = number_format($detail->hotel->rate->price_details->GST[2]->amount,2,'.','');
									}
									$mainprice = $baseprice + $tax;
									if($hotelmarkup->amount_type == 'Percentage'){
										$mainamount = (@$mainprice * $hotelmarkup->markup_fee) / 100;
									}else{
										$mainamount = $hotelmarkup->markup_fee;
									}
									
									$calculateamount = $mainprice + $mainamount;
														?>
												<?php
											if(isset($detail->hotel->rates[$rm])){
												?>{{number_format($detail->hotel->rates[$rm]->price_details->GST[2]->amount + $mainamount,2,'.','')}}
												<?php
											}else if(isset($detail->hotel->rate)){
												?>{{number_format($detail->hotel->rate->price_details->GST[2]->amount + $mainamount,2,'.','')}}<?php
											}
											?>	</span></li>
											
												<li class="grand_total">Grand Total <span><i class="fa fa-rupee-sign"></i>
												{{number_format($calculateamount,2,'.','')}}</span></li>
											<?php
											if(isset($detail->hotel->rates[$rm]->price_details->hotel_charges)){
												?>
											<li>Hotel Charges <span>
												@if($detail->hotel->rates[$rm]->price_details->hotel_charges[0]->included) Included
												@elseif($detail->hotel->rates[$rm]->price_details->hotel_charges[0]->mandatory)
													Pay @ Hotel {{$detail->hotel->rates[$rm]->price_details->hotel_charges[0]->currency}} {{$detail->hotel->rates[$rm]->price_details->hotel_charges[0]->amount}}
												@endif
												</span></li>
												<?php
											}else if(isset($detail->hotel->rate->price_details->hotel_charges)){
												?>
												<li>Hotel Charges <span>@if($detail->hotel->rate->price_details->hotel_charges[0]->included) Included
												@elseif($detail->hotel->rate->price_details->hotel_charges[0]->mandatory)
													Pay @ Hotel {{$detail->hotel->rate->price_details->hotel_charges[0]->currency}} {{$detail->hotel->rate->price_details->hotel_charges[0]->amount}}
												@endif
												</span></li>
												<?php
											}
											?>	
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
<div id="mypolicyModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cancellation Policy</h4>
      </div>
      <div class="modal-body">
        <p><?php
		
		if(isset($detail->hotel->rates[$rm])){
			?>
		@if($detail->hotel->rates[$rm]->non_refundable)
			Non-refundable Booking
			@else
			@if(isset($detail->hotel->rates[$rm]->cancellation_policy))
				@if(isset($detail->hotel->rates[$rm]->cancellation_policy->cancel_by_date))
				<p>Last date for cancellation without charges: {{date('d M Y', strtotime($detail->hotel->rates[$rm]->cancellation_policy->cancel_by_date))}}</p>
				@endif
				@foreach($detail->hotel->rates[$rm]->cancellation_policy->details as $li)
			<p>From: {{date('d M Y', strtotime($li->from))}} {{$li->currency}} @if(isset($li->flat_fee)) {{$li->flat_fee}} @else 0 @endif</p>
			@endforeach
				@if(isset($detail->hotel->rates[$rm]->cancellation_policy->policy_text))
					<h5>Policy Information</h5>
					<p>{{$detail->hotel->rates[$rm]->cancellation_policy->policy_text}}</p>
				@endif
			@endif
			@endif
			<?php
		}else if(isset($detail->hotel->rate)){
			?>
			@if($detail->hotel->rate->non_refundable)
				Non-refundable Booking
			@else
			@if(isset($detail->hotel->rate->cancellation_policy))
				@if(isset($detail->hotel->rate->cancellation_policy->cancel_by_date))
				<p>Last date for cancellation without charges: {{date('d M Y', strtotime($detail->hotel->rate->cancellation_policy->cancel_by_date))}}</p>
				@endif
				@foreach($detail->hotel->rate->cancellation_policy->details as $li)
			<p>From: {{date('d M Y', strtotime($li->from))}} {{$li->currency}} @if(isset($li->flat_fee)) {{$li->flat_fee}} @else 0 @endif</p>
			@endforeach
			@if(isset($detail->hotel->rate->cancellation_policy->policy_text))
					<h5>Policy Information</h5>
					<p>{{$detail->hotel->rate->cancellation_policy->policy_text}}</p>
				@endif
			@endif
			@endif
			<?php
		}
		?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<div id="essentailModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Essential Information</h4>
      </div>
      <div class="modal-body">
		<?php if(isset($detail->hotel->rates[$rm]->rate_comments)){ ?>
			<div class="essential_info">
				<?php
					$ratecomment = $detail->hotel->rates[$rm];
				?>
				<p><b>Pax Comments:</b><br/> {{@$ratecomment->rate_comments->pax_comments}}</p>
				<p><b>Comments:</b><br/> {!!@$ratecomment->rate_comments->comments!!}</p>
				@if(@$ratecomment->rate_comments->MandatoryTax != '')
					<p><b>Mandatory Tax: </b> {{@$ratecomment->rate_comments->MandatoryTax}}</p>
				@endif
				@if(@$ratecomment->rate_comments->policies != '')
					<p><b>Policies: </b> {{@$ratecomment->rate_comments->policies}}</p>
				@endif
				@if(@$ratecomment->rate_comments->mealplan != '')
					<p><b>Meal Plan: </b> {{@$ratecomment->rate_comments->mealplan}}</p>
				@endif
				@if(@$ratecomment->rate_comments->mandatory_fees != '')
					<p><b>Mandatory Fees: </b> {{@$ratecomment->rate_comments->mandatory_fees}}</p>
				@endif
				<p><b>CheckOut Time: </b> {{@$ratecomment->rate_comments->checkout_time}}</p>
				@if(@$ratecomment->rate_comments->checkin_special_instructions != '')
					<p><b>Checkin Special Instructions: </b><br/>{{@$ratecomment->rate_comments->checkin_special_instructions}}</p>
				@endif
				@if(@$ratecomment->rate_comments->checkin_min_age != '')
					<p><b>Checkin Min Age: </b> {{@$ratecomment->rate_comments->checkin_min_age}}</p>
				@endif
				@if(@$ratecomment->rate_comments->checkin_instructions != '')
					<p>{!! @$ratecomment->rate_comments->checkin_instructions !!}</p>
				@endif
				<p><b>CheckIn End Time: </b>{{@$ratecomment->rate_comments->checkin_end_time}}</p>
				<p><b>CheckIn Begin Time: </b> {{@$ratecomment->rate_comments->checkin_begin_time}}</p>
				
				
				<p>{!! @$ratecomment->rate_comments->checkin_instructions !!}</p>
			</div>
			<?php  }else if(isset($detail->hotel->rate->rate_comments)){ 
				$ratecomment = $detail->hotel->rate;
			?>
			<div class="essential_info">
				<p><b>Pax Comments:</b><br/> {{@$ratecomment->rate_comments->pax_comments}}</p>
				<p><b>Comments:</b><br/> {{nl2br(@$ratecomment->rate_comments->comments)}}</p>
				@if(@$ratecomment->rate_comments->MandatoryTax != '')
					<p><b>Mandatory Tax: </b>{{@$ratecomment->rate_comments->MandatoryTax}}</p>
				@endif
				@if(@$ratecomment->rate_comments->policies != '')
					<p><b>Policies: </b> {{@$ratecomment->rate_comments->policies}}</p>
				@endif
				@if(@$ratecomment->rate_comments->mealplan != '')
					<p><b>Meal Plan: </b> {{@$ratecomment->rate_comments->mealplan}}</p>
				@endif
				@if(@$ratecomment->rate_comments->mandatory_fees != '')
					<p><b>Mandatory Fees: </b> {{@$ratecomment->rate_comments->mandatory_fees}}</p>
				@endif
				<p><b>CheckOut Time: </b> {{@$ratecomment->rate_comments->checkout_time}}</p>
				@if(@$ratecomment->rate_comments->checkin_special_instructions != '')
					<p><b>Checkin Special Instructions: </b><br/> {{@$ratecomment->rate_comments->checkin_special_instructions}}</p>
				@endif
				@if(@$ratecomment->rate_comments->checkin_min_age != '')
					<p><b>Checkin Min Age: </b>{{@$ratecomment->rate_comments->checkin_min_age}}</p>
				@endif
				@if(@$ratecomment->rate_comments->checkin_instructions != '')
					<p>{!! @$ratecomment->rate_comments->checkin_instructions !!}</p>
				@endif
				<p><b>CheckIn End Time: </b> {{@$ratecomment->rate_comments->checkin_end_time}}</p>
				<p><b>CheckIn Begin Time: </b> {{@$ratecomment->rate_comments->checkin_begin_time}}</p>
				
			</div>
			<?php } ?>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
    </div>

  </div>
</div>
@endsection