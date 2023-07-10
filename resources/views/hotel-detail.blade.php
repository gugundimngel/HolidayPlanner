@extends('layouts.frontend')
@section('title', 'Hotel Detail')
@section('content')
<style>

</style>
<?php

//echo '<pre>'; print_r($detail); die;
?>
<!-- Content
		============================================= -->
<section id="content">
	<div id="content-wrap">
		<!-- === Section Flat =========== -->
		<div class="section-flat single_sec_flat" style="background:#f7f7f7;">      
			<div class="section-content">
				<div class="container">
					<div class="row"> 
						<div class="inner_hotel_detail">	  
							<div class="col-sm-12">	 
								<div class="cus_breadcrumb">
									<ul>
										<li class="active"><a href="#">Home</a></li>
										<li><span><i class="fa fa-angle-right"></i></span></li>
										<li class="active"><a href="#">Hotel detail</a></li>
										<li><span><i class="fa fa-angle-right"></i></span></li>
										<li><a href="#">{{$detail->hotel->name}}</a></li>
									</ul>
								</div>
							</div>
							<div class="col-sm-12">	 
								<div class="hotel_main_info">
									<div class="hotel_inner">
										<div class="hotel_name">
											<h3>{{$detail->hotel->name}}</h3>
										</div> 
										<div class="hotel_rating">
											@for($i=0; $i<@$detail->hotel->category; $i++)
												<i class="fa fa-star"></i>
											@endfor
										</div>
										<div class="hotel_address">
											<p><i class="fa fa-map-marker-alt"></i> {{$detail->hotel->address}}</p>
										</div>
									</div>
									<div class="hotel_location">
										<a href="#" data-toggle="modal" data-target="#hotelmapModal"><i class="fa fa-map-marker-alt"></i> See Map</a>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="col-sm-8">
							<?php if(isset($images->images)){ ?>
								<div class="hotel_gallery">
									<div id="hotel_gallery_carousel" class="carousel slide" data-ride="carousel">
									<?php
									
									$hotelimages = $images->images->regular;
									?>
									  <!-- Indicators -->
									  <ol class="carousel-indicators">
									  <?php for($i=0; $i<count($hotelimages); $i++){ ?>
										<li data-target="#hotel_gallery_carousel" data-slide-to="{{$i}}" class="<?php if($i==0){echo 'active'; }?>"></li>
									  <?php } ?>
										
									  </ol>
									
									  <!-- Wrapper for slides -->
									  <div class="carousel-inner" role="listbox">
									   <?php for($i=0; $i<count($hotelimages); $i++){ ?>
										<div class="item <?php if($i==0){echo 'active'; }?>">
										  <img src="{{@$hotelimages[$i]->url}}" alt="{{@$hotelimages[$i]->caption}}"/>
										</div>
										<?php } ?>
										
									  </div>
									 
									  <!-- Controls -->
									  <a class="left carousel-control" href="#hotel_gallery_carousel" role="button" data-slide="prev">
										<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
										<span class="sr-only">Previous</span>
									  </a>
									  <a class="right carousel-control" href="#hotel_gallery_carousel" role="button" data-slide="next">
										<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
										<span class="sr-only">Next</span>
									  </a>
									</div>
								</div>
								 <?php } ?> 
							</div>
							<div class="col-sm-4">
								<div class="ht_right">
									<div class="hotel_checkin_out">
										<div class="checkin chck_field">
											<label><i class="fa fa-calendar-alt"></i> Check In</label>
											<?php
											$cindateexp = explode('/', $_GET['cin']);
											$cindate = $cindateexp[2].'-'.$cindateexp[1].'-'.$cindateexp[0];
											$cin = date('d', strtotime($cindate));
											$cinm = date('M', strtotime($cindate));
											$ciny = date('y', strtotime($cindate));
											?>
											<h6><span>{{$cin}}</span> {{$cinm}}'{{$ciny}}</h6>
										</div>
										<?php
											$cOutdateexp = explode('/', $_GET['cOut']);
											$cOutdate = $cOutdateexp[2].'-'.$cOutdateexp[1].'-'.$cOutdateexp[0];
											$cOut = date('d', strtotime($cOutdate));
											$cOutm = date('M', strtotime($cOutdate));
											$cOuty = date('y', strtotime($cOutdate));
											
										$date1 = new \DateTime($cindate);
					$date2 = new \DateTime($cOutdate);
		 $numberOfNights = $date2->diff($date1)->format("%a");
										?>
										<div class="total_night"> 
											<span>{{$numberOfNights}} Night</span>
										</div>
																			
										<div class="checkout chck_field">
											<label><i class="fa fa-calendar-alt"></i> Check Out</label>
											<h6><span>{{$cOut}}</span> {{$cOutm}}'{{$cOuty}}</h6>
										</div>
									</div>
									<?php
									$adultscount =0;
									$childcount =0;
									$pax = explode('?',$_GET['pax']);
									for($i=0; $i< $_GET['Rooms']; $i++){
										$paxs = explode('_',$pax[$i]);
										$adultscount += $paxs[0];
										if(isset($paxs[1])){
										$childcount += $paxs[1];
										}
									}
									?>
									<div class="room_guest">
										<label>Rooms &amp; Guests</label>
										<h6><span>{{$_GET['Rooms']}}</span> Room <span>{{$adultscount + $childcount}}</span> Guest</h6>
									</div>  
									<div class="hotel_feature">
										<ul> 
											<li><i class="fa fa-beer"></i> Bar</li>
											<li><i class="fa fa-wifi"></i> Free Wifi</li>
											<li><i class="fa fa-bed"></i> Room Service</li>
											<li><i class="fa fa-car"></i> Cabs</li>
											<li><i class="fa fa-utensils"></i> Restaurant</li>
										</ul>
									</div>
								</div>
								<!--<div class="hotel_price_sec cus_hotel_whtbg">
									<div class="rating_sec">
										<div class="rating_icon">
											<i class="fa fa-smile"></i>
										</div> 
										<div class="rating_txt">
											<h5>3.5/<sub>5</sub></h5>
											<span>Very Good (1501 Reviews)</span>
										</div>
										<span class="guest_rating"><i class="fa fa-check-circle"></i> 90% guests rated 4+</span>
										<span class="recommend_rating"><i class="fa fa-check-circle"></i> 90% guests rated 4+</span>
									</div>
									<div class="room_cate">
									<?php
									//$rooms = $detail->hotel->rates;
									
									?>
										<span class="cate_name"> 
											<i class="fa fa-bed"></i> @if(isset($rooms[0]->rooms[0]->room_type))
											 {{$rooms[0]->rooms[0]->room_type}}
										 @endif
										</span> 
									</div> 
									<div class="room_price">
										<span class="price_val">
											<i class="fa fa-rupee-sign"></i> @if(isset($rooms[0]->price))
											 {{$rooms[0]->price}}
										 @endif
										</span> 
										<span class="base_price">Base Price (Per Night)</span>
									</div>
									<div class="clearfix"></div>
									<div class="book_room">
										<a href="{{URL::to('Hotel/Booking')}}?sid={{$detail->search_id}}&hid={{$detail->hotel->hotel_code}}&rm=0">Book Now</a> 
									</div>
								</div> -->
							</div>
							<div class="col-sm-12">
								<div class="hotel_amenities"> 
									<?php
									if(isset($detail->hotel->facilities)){
										$facilities = explode(';', $detail->hotel->facilities);
									?>
									<!--<div class="amenities_list">
										<ul>
											<?php
											/* foreach($facilities as $facility){
												if (strpos($facility, 'inter') !== false || strpos($facility, 'Inter') !== false || strpos($facility, 'Wifi') !== false || strpos($facility, 'wi-fi') !== false || strpos($facility, 'Wi-fi') !== false || strpos($facility, 'Wi-Fi') !== false){
											?>
											<li><i class="fa fa-wifi"></i> <span>Wifi</span></li>
											<?php } ?>
											<?php } ?>
											<?php
											foreach($facilities as $facility){
												if (strpos($facility, 'Bar') !== false || strpos($facility, 'bar') !== false || strpos($facility, 'lounge') !== false || strpos($facility, 'Lounge') !== false ){
											?>
											<li><i class="fa fa-glass-cheers"></i> <span>Bar/Lounge</span></li>
											<?php } ?>
											<?php } ?>
										<?php
											foreach($facilities as $facility){
												if (strpos($facility, 'break') !== false || strpos($facility, 'Break') !== false || strpos($facility, 'Coffee') !== false || strpos($facility, 'coffee') !== false ){
											?>
											<li><i class="fa fa-coffee"></i> <span>Breakfast</span></li>
											<?php } ?>
											<?php } ?>
											<?php
											foreach($facilities as $facility){
												if (strpos($facility, 'break') !== false || strpos($facility, 'Break') !== false || strpos($facility, 'Coffee') !== false || strpos($facility, 'coffee') !== false || strpos($facility, 'tea') !== false  || strpos($facility, 'Tea') !== false){
											?>
											<li><i class="fa fa-coffee"></i> <span>Coffee/Tea</span></li>
											<?php } ?>
											<?php } ?>
											<?php
											foreach($facilities as $facility){
												if (strpos($facility, 'tv') !== false || strpos($facility, 'TV') !== false ){
											?>
											<li><i class="fa fa-tv"></i> <span>TV</span></li>
											<?php } ?>
											<?php } ?>
											<?php
											foreach($facilities as $facility){
												if (strpos($facility, 'fit') !== false || strpos($facility, 'Fit') !== false ){
											?>
												<li><i class="fa fa-dumbbell"></i> <span>Fitness Centre</span></li>
											<?php } ?>
											<?php } ?>
											<?php
											foreach($facilities as $facility){
												if (strpos($facility, 'spa') !== false || strpos($facility, 'Spa') !== false || strpos($facility, 'massage') !== false || strpos($facility, 'Massage') !== false){
											?>
												<li><i class="fa fa-spa"></i> <span>Spa</span></li>
											<?php } ?>
											<?php } ?>
											<?php
											foreach($facilities as $facility){
												if (strpos($facility, 'spa') !== false || strpos($facility, 'Spa') !== false  || strpos($facility, 'massage') !== false || strpos($facility, 'Massage') !== false){
											?>
												<li><i class="fa fa-spa"></i> <span>Massage centre</span></li>
											<?php } ?>
											<?php } */?>
										</ul>
									</div>-->
									<h5>Hotel Amenities</h5> 
									<div class="all_amenity_list" id="allamenity">
										<ul>
										@foreach($facilities as $facility)
											<li>{{trim($facility)}}</li>
										@endforeach
											
										</ul>
									</div>
									<?php } ?>
								</div>
								<div class="about_hotel cus_hotel_whtbg">
									<h5>About Hotel</h5> 
									<div class="inner_info">
										{!!$detail->hotel->description!!}
									</div>
								</div>
								 
								<!--<div class="hotel_amenity cus_hotel_whtbg">
									<h4 class="title_h4">Amenities</h4>
									<div class="inner_hotel_amenity">
										<div class="amenity_col">
											<h5>Facilities</h5>
											<ul>
												<li><i class="fa fa-check"></i> air conditioning</li>
												<li><i class="fa fa-check"></i> 24-hour reception</li>
												<li><i class="fa fa-check"></i> 24-hour check-in</li>
												<li><i class="fa fa-check"></i> hotel safe</li>
												<li><i class="fa fa-check"></i> currency exchange</li>
												<li><i class="fa fa-check"></i> café</li>
												<li><i class="fa fa-check"></i> shops</li>
												<li><i class="fa fa-check"></i> bar(s)</li>
												<li><i class="fa fa-check"></i> restaurant(s)</li>
												<li><i class="fa fa-check"></i> restaurant(s) with air conditioning</li>
												<li><i class="fa fa-check"></i> conference room</li>
												<li><i class="fa fa-check"></i> internet access</li>
												<li><i class="fa fa-check"></i> wlan access</li>
												<li><i class="fa fa-check"></i> room service</li>
												<li><i class="fa fa-check"></i> laundry service</li>
												<li><i class="fa fa-check"></i> medical assistance</li>
												<li><i class="fa fa-check"></i> car park</li>
											</ul>
										</div>
										<div class="amenity_col">
											<h5>Object Information</h5>
											<ul>
												<li><i class="fa fa-check"></i> fax</li>
												<li><i class="fa fa-check"></i> telephone hotel</li>
											</ul>
										</div>
										<div class="amenity_col">
											<h5>Building Information</h5>
											<ul>
												<li><i class="fa fa-check"></i> number of rooms (total)</li>
											</ul>
										</div>
										<div class="amenity_col">
											<h5>Sport/Entertainment</h5>
											<ul>
												<li><i class="fa fa-check"></i> outdoor pool(s)</li>
												<li><i class="fa fa-check"></i> sauna</li>
												<li><i class="fa fa-check"></i> steam bath</li>
												<li><i class="fa fa-check"></i> gym</li>
												<li><i class="fa fa-check"></i> number of pools</li>
											</ul>
										</div>
										<div class="amenity_col">
											<h5>Category</h5>
											<ul>
												<li><i class="fa fa-check"></i> category (official)</li>
												<li><i class="fa fa-check"></i> category (recommended)</li>
												<li><i class="fa fa-check"></i> steam bath</li>
												<li><i class="fa fa-check"></i> gym</li>
												<li><i class="fa fa-check"></i> number of pools</li>
											</ul>
										</div>
										<div class="amenity_col">
											<h5>Room Facilities</h5>
											<ul>
												<li><i class="fa fa-check"></i> bathroom</li>
												<li><i class="fa fa-check"></i> shower</li>
												<li><i class="fa fa-check"></i> bathtub</li>
												<li><i class="fa fa-check"></i> hairdryer</li>
												<li><i class="fa fa-check"></i> direct dial telephone</li>
												<li><i class="fa fa-check"></i> satellite/cable tv</li>
												<li><i class="fa fa-check"></i> radio</li>
												<li><i class="fa fa-check"></i> internet access</li>
												<li><i class="fa fa-check"></i> minibar</li>
												<li><i class="fa fa-check"></i> air conditioning (centrally regulated)</li>
												<li><i class="fa fa-check"></i> safe</li>
												<li><i class="fa fa-check"></i> tv</li>
												<li><i class="fa fa-check"></i> tea/coffee maker</li>
											</ul>
										</div>	
										<div class="clearfix"></div>
									</div> 
								</div>-->
								<div class="room_type_sec cus_hotel_whtbg">
									<h4 class="title_h4">Room Type</h4>
									<div class="room_type_list">
										<div class="room_type_head">
											<div class="room_type_row">
												<div class="room_type_col wd35">
													<span>Room Type</span>
												</div> 
												<div class="room_type_col wd40">
													<span>Description / Inclusion</span>
												</div>
												<div class="room_type_col wd25">
													<span>Price</span>
												</div>  
											</div>   
										</div>
										<div class="room_type_body">
										<?php
										/* echo '<pre>'; print_r($detail->hotel);
										die; */
										$rooms = $detail->hotel->rates;
										 $roomsarr = array();
										
										 foreach($rooms as $key => $room){
											$roomsarr[base64_decode($room->rooms[0]->room_type)][] = array( 'key'=>$key,'rooms' => $room );
										}
										  $newarray = array();
										  //echo '<pre>'; print_r($roomsarr); die; 										
										 foreach($roomsarr as $key => $roomddd){
											 $newarray[$key]['room_type'] = $roomddd[0]['rooms']->rooms[0]->room_type;
											 foreach($roomddd as $keys => $room){
												// echo '<pre>'; print_r($room); die;
												 $newarray[$key]['roomdata'][] = array( 'key'=>$room['key'],'rooms' => $room['rooms'] );
											 } 
										 } 
										//echo '<pre>'; print_r($newarray); die; 
										foreach($newarray as $key => $roomss){
											
										?>
										
											<div class="main_row" style="border: 1px solid #e1efc4;border-top:0;">
											<div class="room_type_row" style="padding: 15px 25px;border-bottom: 1px dashed #e1efc4;">
												<h5>{{$roomss['room_type']}}</h5>
												
											</div>
											
												<?php /* <div class="room_type_col wd35">
													<img src="{!! asset('public/images/hotel_img/standard_room1.jpg') !!}" alt=""/> 
												</div> */ ?>
											<?php $is =0; foreach($roomss['roomdata'] as $keys => $room){ ?>
											<div  class="room_type_row <?php if($is== 0){ echo 'mainshow'; }else{ echo 'hideanother'; } ?>" style="border-bottom:0;">
											<div class="room_type_col wd100">
												<div class="room_type_row" style="border-top:1px solid #e1efc4;">
													<div class="room_type_col wd35">
														<span>{{implode(',',$room['rooms']->boarding_details)}}</span>
														@if($room['rooms']->non_refundable)
															<span style="color:#fb440a;">Non-refundable</span>
														@else
															<span style="color:#008000;">Refundable</span>
														@endif
														
													</div>
													<div class="room_type_col wd40">
														@if(isset($room['rooms']->other_inclusions))
													<ul class="benifit_ul">
													@foreach($room['rooms']->other_inclusions as $list)
														<li><i class="fa fa-check"></i> {{$list}}</li>
														@endforeach
													</ul>
													@endif
													</div>
													
													<div class="room_type_col wd25">
													<div class="price_txt">
														<div class="price_label">
															<span class="total_price">Total Price</span>
														</div>
														<?php
									$isdomestic = @$detail->hotel->country;
									$city_code = @$detail->hotel->city_code;
									$hotel_code = @$detail->hotel->hotel_code;
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
								$mainprice = round(@$room['rooms']->price / $numberOfNights);
									//$mainprice = @$room['rooms']->price;
									if($hotelmarkup->amount_type == 'Percentage'){
										$mainamount = (@$mainprice * $hotelmarkup->markup_fee) / 100;
									}else{
										$mainamount = $hotelmarkup->markup_fee;
									}
									
									$calculateamount = $mainprice + $mainamount;
														?>
														<div class="price_value">
															<!--<span class="cross_price"><i class="fa fa-rupee-sign"></i> 6500</span>-->
															<span class="actual_price"><i class="fa fa-rupee-sign"></i> {{round($calculateamount)}}</span>
														</div>
													</div> 
													<div class="booking_btn">
														<a href="{{URL::to('Hotel/Booking')}}?sid={{$detail->search_id}}&hid={{$detail->hotel->hotel_code}}&rm={{@$room['key']}}">Book Now</a>
													</div>
												</div> 
												</div>
												
												
												
												</div> 
												</div>
											
										<?php $is++; } ?>	
									</div>
										<?php } ?>
											
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
	</div>	
</section>	


<div id="hotelmapModal" class="modal fade hotelmapModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Hotel Location</h4>
			</div>
			<div class="modal-body">
				<div class="row"> 
					<div class="col-md-12"> 
						<div class="hotelmap_iframe">
							<?php
								$lat = $detail->hotel->geolocation->latitude;
								$long = $detail->hotel->geolocation->longitude;
								?>
								<iframe width="100%" height="350" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0" src = "https://maps.google.com/maps?q={{$lat}},{{$long}}&hl=es;z=14&amp;output=embed"></iframe> 
						</div> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection