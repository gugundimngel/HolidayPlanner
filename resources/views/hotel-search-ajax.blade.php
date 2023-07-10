<section id="content">
	<div id="content-wrap">
		<!-- === Section Flat =========== -->
		<div class="section-flat single_sec_flat" style="background:#e8e8e8;">      
			<div class="section-content hotel_content_sec sticky">
				<div class="hotel_search_sec">
				<div class="container">
					<div class="row"> 
						<div class="col-sm-12">
							<div class="hotel_search">
								<div class="nationality_option">
								<?php
								$countries1 = json_decode($countries);
								?>
							<select class="form-control" id="nationality" name="nationality">
	<?php
	foreach($countries1 as $countr){
		?>
		<option <?php if(@$_GET['nationality'] == $countr->code){ echo 'selected'; } ?> value="<?php echo $countr->code; ?>"><?php echo $countr->name; ?></option>
		<?php
	}
	?>
</select>
</div>
<div class="clearfix"></div>
								<div class="search_field"> 
								<form class="search_form">
									<div class="form-group loc_search_field cus_loc_field">
									<?php
									$selectedcity = \App\HotelCity::where('name',Request::get('city'))->first();
									$HotelCountryd = \App\HotelCountry::where('country_code_1', $selectedcity->country_code)->first();
									?>
											<input autocomplete="off" type="text" class="hotel-roundwayfrom form-control hotel-wrapper-dropdown-2" placeholder="Where are you going?" id="search-box" name="location" value="{{$selectedcity->name}}, {{$HotelCountryd->name}}" />
											<i class="fa fa-location-arrow"></i> 
											<div class="hotel-location_search selhide" id="hotel-location_search">
													<div class="inner_loc_search">
														<div class="top_city">
															<span>Popular destinations nearby</span>
														</div>
														<ul class="hotel_is_search_from_val">
														@foreach(\App\HotelCity::where('is_top','1')->orderby('priority','ASC')->get() as $alist)
														<?php
												$HotelCountry = \App\HotelCountry::where('country_code_1', $alist->country_code)->first();
												?>
															<li roundwayfromtops="{{$alist->city_code}}, {{$alist->country_code}}" roundwayfromtop="{{$alist->name}}, {{$HotelCountry->name}}" roundwayfrom="{{$alist->name}}">
														<div class="fli_name"><i class="fa fa-map-marker-alt"></i> {{$alist->name}}</div>
														<div class="airport_name">{{$HotelCountry->name}}</div>
													</li>
														@endforeach
														</ul>
													</div>
												</div> 
										</div>
									<input id="txtCity" name="txtCity" value="{{Request::get('city')}}" style="display:none" type="text" class="input_htl_lo validate[required] minSize[3]" value="" autocomplete="off" aria-autocomplete="list" onclick="loadCity();" />
									<div class="form-group cus_calendar_field">
										<input autocomplete="off" type="text" name="brTimeStart" value="{{Request::get('cin')}}" class="form-control" id="hoteldatepicker-time-start" placeholder="2019/09/30">
										<sub>Check-in</sub>
										<i class="far fa-calendar"></i>
									</div><!-- .form-group end -->
									<div class="form-group cus_calendar_field">
										<input autocomplete="off" type="text" name="brTimeEnd" value="{{Request::get('cOut')}}" class="form-control" id="hoteldatepicker-time-end" placeholder="2019/09/30">
										<sub>Check-out</sub> 
										<i class="far fa-calendar"></i>
									</div><!-- .form-group end -->
									<div class="form-group cus_passenger_field">
										<input autocomplete="off" readonly type="text" id="guest" name="guest" class="form-control show-dropdown-passengers roundpessanger"
											placeholder="" value="">
										<div class="select_guest">
											<span class="search-label">Rooms/Guests </span>
											<span class="guests_selected"><span id="guestcount">1</span> Person in <span id="guestroom">2</span> Room</span>
										</div> 
										<i class="fas fa-user"></i>
										<div class="list-dropdown-passengers">
											<div class="list-persons-count">
											<?php  
											$pax = explode('?',$paxsde);
											?>
												<div id="roomshtml">
													
													<div class="box" id="divroom1">
														<div class="roomTxt"><span id="RoomNumer1">Room 1:</span></div>
														<div class="left pull-left">
															<span class="txt">
																<span id="Label7">Adult <em>(Above 12 years)</em></span>
															</span>
														</div>
														<div class="right pull-right">
															<div id="field1" class="PlusMinusRow">
																<a class="decrease-btn hoteladultclass" href="javascript:;">-</a>
																<span id="Adults_room_1_1" class="PlusMinus_number">2</span>
																<a class="increase-btn hoteladultclass" href="javascript:;">+</a>
															</div>
														</div>
														<div class="spacer"></div>
														<div class="left pull-left">
															<span class="txt">
																<span id="Label9">Child <em>(Below 12 years)</em></span>
															</span>
														</div>
														<div class="right pull-right">
															<div id="field2" class="PlusMinusRow">
																<a class="decrease-btn hotelchildclass" href="javascript:;">-</a>
																<span id="Children_room_1_1" class="PlusMinus_number">2</span>
																<a class="increase-btn hotelchildclass" href="javascript:;">+</a>
															</div>
														</div>
														<div class="clearfix"></div>
														<div class="child_age">
															<span>Age(s) of Children</span>
															<select id="Child_Age_1_1" style="display: inline;"><option option="selected">1</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option></select>
															<select id="Child_Age_1_2" style="display: inline;"><option option="selected">1</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option></select>
														</div>
													</div> 
													
												</div> 
												<a id="addhotelRoom" href="javascript:;" class="cus_add_remove_btn addroom">Add Room</a>
												<a id="removehotelRoom" href="javascript:;" class="cus_add_remove_btn removeroom" style="display: none;">Remove Room</a> 
												<a class="btn-reservation-passengers btn x-small colorful hover-dark" href="javascript:;">Done</a>
												 
												<div class="clearfix"></div>
												<input type="hidden" id="hdnroom" value="1">
												
												<!--<li>Adults_room_
													<span>Adults:</span>
													<div class="counter-add-item">
														<a class="decrease-btn" href="javascript:;">-</a>
														<input id="adult" class="adult" type="text" value="1">
														<a class="increase-btn" href="javascript:;">+</a>
													</div>
												</li>
												<li>
													<span>Children</span>
													<div class="counter-add-item">
														<a class="decrease-btn" href="javascript:;">-</a>
														<input id="children" class="children" type="text" value="0">
														<a class="increase-btn" href="javascript:;">+</a>
													</div>
												</li>
												<li>
													<span>Rooms:</span>
													<div class="counter-add-item">
														<a class="decrease-btn" href="javascript:;">-</a>
														<input id="rooms" class="rooms" type="text" value="0">
														<a class="increase-btn" href="javascript:;">+</a>
													</div>
												</li>-->
											</div><!-- .list-persons-count end -->
										</div><!-- .list-dropdown-passengers end -->
									</div><!-- .form-group end -->
									<div class="form-group cus_searchbtn_field">
										<button onclick="HotelSearch();" type="button" class="form-control icon"><i class="fas fa-search"></i> Search</button>
									</div>
									<div class="clearfix"></div>
								</form>
							</div>
							</div>
						</div>
					</div>
					</div>
				</div>
				<div class="container">
					<div class="row">  	
						<div class="inner_hotel" >	  
							<div class="col-sm-12">	 
								<div class="cus_breadcrumb">
									<ul>
										<li class="active"><a href="#">Home</a></li>
										<li><span><i class="fa fa-angle-right"></i></span></li>
										<li><a href="#">Hotel Search</a></li>
									</ul>
								</div>
							</div>
							<div class="col-sm-12 hotel_filter_btn">	
								<div class="filter_btn_style"> 
									<a href="javascript:;" class="filter_btn"><i class="fa fa-filter"></i> <span>Filiter</span></a>
								</div>
							</div>
							<div class="col-md-3 col-sm-12 hotel_sidebar">	  
								<div class="show_map">
									<a href="#" data-toggle="modal" data-target="#hotelmapModal"><i class="fa fa-map-marker-alt"></i> Show On Map</a>
								</div>
								<div class="sidebar style-1 custom_sidebar hotel_filter">
									<div class="filter_head"> 
										<div class="filter_title">
											<h3>Filter <span  class="clearfilter clearall">Clear All</span></h3>
										</div>
										<a class="filter_close"><i class="fa fa-times"></i></a> 
									</div>	
									<div class="inner_filter">
										<div class="box-widget">
											<h5 class="box-title">Search By Name</h5>
											<div class="box-content">
												<input type="text" class="form-control hotelname_search" placeholder="Search By Name"/>
											</div><!-- .box-content end -->
										</div><!-- .box-widget end -->
										<div class="box-widget">
											<h5 class="box-title">Your Budget</h5>
											<div class="box-content">
											<input type="hidden" id="minprice">
											<input type="hidden" id="maxprice">
												<div class="slider-dragable-range slider-range-price">
													<input type="text" class="price">
													<div class="slider-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-slider-min-value="{{$minprice}}" data-slider-max-value="{{$maxprice}}" data-range-start-value="{{$minprice}}" data-range-end-value="{{$maxprice}}" data-slider-value-sign="₹">
														<div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div>
														<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span>
														<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;"></span>
													</div>
												</div> 											 				
											</div><!-- .box-content end -->
										</div><!-- .box-widget end -->
										<!--<div class="box-widget">
											<h5 class="box-title">Popular Filter</h5>
											<div class="box-content">
												<ul class="check-boxes-custom list-checkboxes">
													<li>
														<label for="option1" class="label-container checkbox-default">Villas
															<input name="options" class="Stopfliter" id="option1" type="radio" value="0">
															<span class="checkmark"></span>
														</label>
													</li>
													<li>
														<label for="option2" class="label-container checkbox-default">Private Pool
															<input name="options" class="Stopfliter" id="option2" type="radio" value="0">
															<span class="checkmark"></span>
														</label>
													</li>
													<li>
														<label for="option3" class="label-container checkbox-default">Breakfast Included
															<input name="options" class="Stopfliter" id="option3" type="radio" value="0">
															<span class="checkmark"></span>
														</label>
													</li>
													<li>
														<label for="option4" class="label-container checkbox-default">Apartments + Homes
															<input name="options" class="Stopfliter" id="option4" type="radio" value="0">
															<span class="checkmark"></span>
														</label>
													</li>
													<li>
														<label for="option5" class="label-container checkbox-default">Swimming Pool
															<input name="options" class="Stopfliter" id="option5" type="radio" value="0">
															<span class="checkmark"></span>
														</label>
													</li>
													<li>
														<label for="option6" class="label-container checkbox-default">Kitchen/Kitchenette
															<input name="options" class="Stopfliter" id="option6" type="radio" value="0">
															<span class="checkmark"></span>
														</label>
													</li>
													<li>
														<label for="option7" class="label-container checkbox-default">Beach
															<input name="options" class="Stopfliter" id="option7" type="radio" value="0">
															<span class="checkmark"></span>
														</label>
													</li>
												</ul>
											</div>
										</div> -->
										<div class="box-widget">
											<h5 class="box-title">Star Rating</h5>
											<div class="box-content">
												<ul class="check-boxes-custom list-checkboxes">
												<li>
														<label for="option5" class="label-container checkbox-default"><span>5 <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>
															<input name="options" class="starfliter" id="option5" type="checkbox" value="5">
															<span class="checkmark"></span>
														</label>
													</li>
													<li>
														<label for="option4" class="label-container checkbox-default"><span>4 <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>
															<input name="options" class="starfliter" id="option4" type="checkbox" value="4">
															<span class="checkmark"></span>
														</label>
													</li><li>
														<label for="option3" class="label-container checkbox-default"><span>3 <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>
															<input name="options" class="starfliter" id="option3" type="checkbox" value="3">
															<span class="checkmark"></span>
														</label>
													</li>
													<li>
														<label for="option2" class="label-container checkbox-default"><span>2 <i class="fa fa-star"></i><i class="fa fa-star"></i></span>
															<input name="options" class="starfliter" id="option2" type="checkbox" value="2">
															<span class="checkmark"></span>
														</label>
													</li>
													<li>
														<label for="option1" class="label-container checkbox-default"><span>1 <i class="fa fa-star"></i></span>
															<input name="options" class="starfliter" id="option1" type="checkbox" value="1">
															<span class="checkmark"></span>
														</label>
													</li>
													
													<!--<li>
														<label for="option6" class="label-container checkbox-default"><span>Unrated</span>
															<input name="options" class="starfliter" id="option6" type="checkbox" value="0">
															<span class="checkmark"></span>
														</label>
													</li>-->
												</ul><!-- .check-boxes-custom end -->
											</div><!-- .box-content end -->
										</div><!-- .box-widget end -->
										<!--<div class="box-widget">
											<h5 class="box-title">Property Type</h5>
											<div class="box-content">
												<ul id="myULair" class="check-boxes-custom list-checkboxes">
													<li style="display: list-item;">
														<label class="label-container checkbox-default">Hotels
															<input name="property_type" class="chboxAirline" type="checkbox" value="">
															<span class="checkmark"></span>
														</label>
													</li>
													<li style="display: list-item;">
														<label class="label-container checkbox-default">Bed and Breakfasts
															<input name="property_type" class="chboxAirline" type="checkbox" value="">
															<span class="checkmark"></span>
														</label>
													</li>
													<li style="display: list-item;">
														<label class="label-container checkbox-default">Apartments
															<input name="property_type" class="chboxAirline" type="checkbox" value="">
															<span class="checkmark"></span>
														</label>
													</li>
													<li style="display: list-item;">
														<label class="label-container checkbox-default">Guest Houses
															<input name="property_type" class="chboxAirline" type="checkbox" value="">
															<span class="checkmark"></span>
														</label>
													</li>
													<li style="display: list-item;">
														<label class="label-container checkbox-default">Hostels
															<input name="property_type" class="chboxAirline" type="checkbox" value="">
															<span class="checkmark"></span>
														</label>
													</li>
													<li style="display: list-item;">
														<label class="label-container checkbox-default">Homestays
															<input name="property_type" class="chboxAirline" type="checkbox" value="">
															<span class="checkmark"></span>
														</label>
													</li>
												</ul>
												<a href="javascript:;" id="prop_typeMore">Show more</a>
											</div>
										</div> -->
										<div class="box-widget">
											<h5 class="box-title">Facilities</h5>
											<div class="box-content">
												<ul id="myULairfac" class="check-boxes-custom list-checkboxes">
												@foreach($facilties as $fac)
													<li style="">
														<label class="label-container checkbox-default">{{$fac}}
															<input name="property_type" class="chboxAirline hotelfacilties" type="checkbox" value="{{$fac}}">
															<span class="checkmark"></span>
														</label>
													</li>
													@endforeach
													
												</ul> 
												<a href="javascript:;" id="facloadMore">Show more</a>
											</div><!-- .box-content end -->
										</div><!-- .box-widget end -->
										<!--<div class="box-widget">
											<h5 class="box-title">Meal Plan</h5>
											<div class="box-content">
												<ul id="myULair" class="check-boxes-custom list-checkboxes">
													<li style="display: list-item;">
														<label class="label-container checkbox-default">Breakfast
															<input name="property_type" class="chboxAirline" type="checkbox" value="">
															<span class="checkmark"></span>
														</label>
													</li>
													<li style="display: list-item;">
														<label class="label-container checkbox-default">Lunch
															<input name="property_type" class="chboxAirline" type="checkbox" value="">
															<span class="checkmark"></span>
														</label>
													</li>
													<li style="display: list-item;">
														<label class="label-container checkbox-default">Dinner
															<input name="property_type" class="chboxAirline" type="checkbox" value="">
															<span class="checkmark"></span>
														</label>
													</li>
												</ul> 
											</div>
										<div class="box-widget">
											<h5 class="box-title">Location</h5>
											<div class="box-content">
												<ul id="myULair" class="check-boxes-custom list-checkboxes">
													<li style="display: list-item;">
														<label class="label-container checkbox-default">Delhi
															<input name="property_type" class="chboxAirline" type="checkbox" value="">
															<span class="checkmark"></span>
														</label>
													</li>
													<li style="display: list-item;">
														<label class="label-container checkbox-default">Mumbai
															<input name="property_type" class="chboxAirline" type="checkbox" value="">
															<span class="checkmark"></span>
														</label>
													</li>
												</ul> 
												<a href="javascript:;" id="airloadMore">Show more</a>
											</div>
										</div> 
										<div class="box-widget">
											<h5 class="box-title">Amenities</h5>
											<div class="box-content">
												<ul id="myULair" class="check-boxes-custom list-checkboxes">
													<li style="display: list-item;">
														<label class="label-container checkbox-default">Wifi
															<input name="property_type" class="chboxAirline" type="checkbox" value="">
															<span class="checkmark"></span>
														</label>
													</li>
													<li style="display: list-item;">
														<label class="label-container checkbox-default">Sightseeing
															<input name="property_type" class="chboxAirline" type="checkbox" value="">
															<span class="checkmark"></span>
														</label>
													</li>
													<li style="display: list-item;">
														<label class="label-container checkbox-default">Transport
															<input name="property_type" class="chboxAirline" type="checkbox" value="">
															<span class="checkmark"></span>
														</label>
													</li>
													<li style="display: list-item;">
														<label class="label-container checkbox-default">Bar
															<input name="property_type" class="chboxAirline" type="checkbox" value="">
															<span class="checkmark"></span>
														</label>
													</li>
													<li style="display: list-item;">
														<label class="label-container checkbox-default">Sun Bath
															<input name="property_type" class="chboxAirline" type="checkbox" value="">
															<span class="checkmark"></span>
														</label>
													</li>
												</ul> 
												<a href="javascript:;" id="airloadMore">Show more</a>
											</div>
										</div>-->
									</div>
									<div class="applyfilter_btn">
										<button type="button" class="apply_btn">Apply Filter</button>
									</div> 
								</div><!-- .sidebar end --> 
							</div>	
							<div class="col-md-9 col-sm-12 pos_static">	
								<div class="hotel_list_sec"> 
									<div class="result_found">
									@if(isset($data->hotels))
										<h4>{{$city}}: <span>{{count($data->hotels)}}</span> Properties found</h4>
									@endif
									</div>
									<div class="hotel_sorting">
										<label>Sort By:</label>
										<select class="sortprice">
											
											<option value="ASC" selected>Price - Low to High</option>
											<option value="DESC">Price - High to Low</option>
										</select>
									</div>
									<!--<div class="map_view">  
										<a href="#" class="showmap"> 
											<i class="fa fa-map-marker-alt"></i>
											<span>Map View</span>
										</a>
									</div>-->
									<div class="clearfix"></div>
									<!--<div class="sort_category">
										<ul>
											<li class="active"><a href="#">Our Top Picks</a></li>
											<li><a href="#">Entire homes & apartments</a></li>
											<li><a href="#">Lowest Price First</a></li>
											<li><a href="#">Review Score & Price</a></li>
											<li><a href="#">Star rating and price</a></li>
											<li><a href="#">Distance From Downtown</a></li>
											<li><a href="#">Top Reviewed</a></li>
										</ul>
									</div>-->
									<div  class="hotel_list scrolling-pagination">
										<?php if(isset($data->hotels)) { 
										?>
										<div id="ajaxContent">
										<?php
										foreach($data->hotels aS $hotels){ ?>
										<div class="hotel_item">
											<div class="hotel_img">
												<a href="#">
													<img src="{{@$hotels->images->url}}" alt=""/>
													<!--<div class="hotel_tag tag_green">
														<span>Breakfast Included</span>
													</div>
													<div class="hotel_favorite">
														<i class="fa fa-heart"></i>
													</div>-->
												</a>
											</div>
											<div class="hotel_info">
												<div class="left">
													<div class="title_wrap">
														<h3 class="title"><a href="#">{{@$hotels->name}}</a></h3> 
														<div class="title_badges"> 
															<div class="hotel_star">
																@for($i=0; $i<@$hotels->category; $i++)
																	<i class="fa fa-star"></i>
																@endfor
															</div>
														
														</div>
													</div>
													<div class="hotel_search_address">
														<span><i class="fa fa-map-marker-alt"></i> {{@$hotels->address}}</span>
														<!--<span class="distance">14km from center</span>-->
													</div> 
													<div class="tripadvisior_review">
														<img class="item-left-img" src="{!! asset('public/img/ta-45.png')!!}" alt="Trip Advisior">
													</div>
													<div class="room_amenities">
														<!--<span>Amenities</span>--> 
														<?php
														if(isset($hotels->facilities)){
														$facilities = explode(';', $hotels->facilities);
														?>
														<ul>
														@for($i=0;$i<5; $i++)
															@if(isset($facilities[$i]))
															<li><img src="{!! asset('public/images/ac.png')!!}" alt=""/>{{trim(@$facilities[$i])}}</li>
														@endif
															
														@endfor
														</ul>
														<?php } ?>
													</div>
												</div>
												<div class="right">
													<div class="room_price">
														<span class="price_value"><i class="fas fa-rupee-sign"></i> {{@$hotels->min_rate->price}}</span>
														<span class="price_tag">Per Night</span>
														<!--<span class="total_cost">(Total Cost)</span>-->
													</div>
													<div class="select_hotel_btn">
														<a href="{{URL::to('Hotel/HotelDetail')}}?city={{$city}}&cin={{$cin}}&cOut={{$cOut}}&Hotel=NA&Rooms={{$Rooms}}&pax={{$paxsde}}&sid={{@$data->search_id}}&hid={{@$hotels->hotel_code}}">View Room <i class="fa fa-angle-right"></i></a> 
													</div>
												</div> 
												<div class="clearfix"></div>
												<!--<div class="room_details">
													<div class="left">
														<div class="room_name">
														
															
															<div class="hotel_review">
																<div class="review_score">
																	<span aria-label="Scored 6.7">6.7</span>
																</div>
																<div class="review_content">
																	<span class="review_title">Review Score</span>
																	<span class="review_text">413 Reviews</span>
																</div>
															</div>
															<span class="risk_free risk_green">Risk Free: You can cancel later, so lock in this great price today!</span>
														</div> 
													</div> 
													<div class="right">
														<div class="room_price">
															<span class="price_display_label">1 night, 2 adults</span> 
															<span class="price_tax">includes taxes and charges</span>
														</div>
														<div class="room_refreshment">
															<sup>Breakfast included</sup>
															<sup>FREE cancellation</sup>
														</div>
													</div>
													<div class="clearfix"></div>
												</div> -->
												
											</div> 
											<div class="clearfix"></div>
										</div>
										<?php  
											}
											?>
											 </div>
											 {{ $hotelcodes->appends($_GET)->links() }}
											
											<?php
										}else{
											?>
											<h4>No Result Found</h4>
											<?php
										} ?>
										
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
					<div class="col-md-4"> 
						<div class="hotel_map_list">
							<?php if(isset($data->hotels)) { 
							$mapdata = array();
							$ima=0;
							foreach($data->hotels aS $hotels){
								$LatLng = array();
								$LatLng[] = (object) array(
										'lat' => trim($hotels->geolocation->latitude),
										'lng' => trim($hotels->geolocation->longitude)
									);
									$rate = '';
									for($i=0; $i<@$hotels->category; $i++){
										$rate .= '<i class="fa fa-star"></i>';
									}
								$mapdata[] = array(
									'placeName' => @$hotels->name,
									'placeImage' => $hotels->images->url,
									'placerate' => $rate,
									'placeprice' => @$hotels->min_rate->price,
									'LatLng' => $LatLng
								);
								?>
							<div class="hotel_item">
								<a href="#" onclick="SetHotelMarker({{$ima}})">
									<div class="hotel_img" style="background:url('{{@$hotels->images->url}}')">
									</div>
									<div class="hotel_info">
										<div class="title_wrap">
											<h3 class="title">{{@$hotels->name}}</h3> 
											<div class="hotel_star">
												@for($i=0; $i<@$hotels->category; $i++)
													<i class="fa fa-star"></i>
												@endfor
											</div>
										</div>
										<div class="hotel_address">
											<p>{{@$hotels->address}}</p>
										</div>
										<div class="hotel_stats">
											<span class="beds">1 Bed</span>
											<div class="hotel_stay">
												<span>23 nights, 2 adult</span>
											</div>
										</div>	
										<div class="room_price">
											<span class="price_value"><i class="fas fa-rupee-sign"></i> {{@$hotels->min_rate->price}}</span>
											<div class="tax_price">
												<span>+ <i class="fas fa-rupee-sign"></i> 191, 287 taxes and charges</span>
											</div>
										</div>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
							<?php  
								$ima++; }
								?>
								
								
								<?php
							}else{
								?>
								<h4>No Result Found</h4>
								<?php
							} ?>
						</div>
					</div>
					<div class="col-md-8"> 
						<div class="hotelmap">
							<div style="width:100%;" id="map"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
var markers = new Array();
var map;
                var InforObj = [];
                var centerCords = {
                    lat: <?php echo trim($mapdata[0]["LatLng"][0]->lat); ?>,
                    lng: <?php echo trim($mapdata[0]["LatLng"][0]->lng); ?>
                };
                var markersOnMap = <?php echo json_encode($mapdata); ?>;
				
                $(document).ready(function() {
                    initMap();
                });
        
                function addMarker() {
                    for (var i = 0; i < markersOnMap.length; i++) {
                        var contentString = '<div id="content"><div class="hotelimg"><img src="'+markersOnMap[i].placeImage+'"></div><div class="hotelinf"><h3>' + markersOnMap[i].placeName +
                            '</h3><div class="ht_stars">'+markersOnMap[i].placerate+'</div><div class="ht_tripadvis"><img class="item-left-img" src="{!! asset('public/img/ta-45.png')!!}" width="55" alt="Trip Advisior"></div><div class="ht_price"><span><i class="fas fa-rupee-sign"></i> '+markersOnMap[i].placeprice+'</span></div><div class="clearfix"></div></div></div>';
        
                        const marker = new google.maps.Marker({
                            position: new google.maps.LatLng(markersOnMap[i].LatLng[0].lat, markersOnMap[i].LatLng[0].lng),
                            map: map
                        });
         markers.push(marker);
                        const infowindow = new google.maps.InfoWindow({
                            content: contentString,
                            maxWidth: 650
                        }); 
        
                        marker.addListener('click', function () {
                            closeOtherInfo();
                            infowindow.open(marker.get('map'), marker);
                            InforObj[0] = infowindow;
                        });
                        // marker.addListener('mouseover', function () {
                        //     closeOtherInfo();
                        //     infowindow.open(marker.get('map'), marker);
                        //     InforObj[0] = infowindow;
                        // });
                        // marker.addListener('mouseout', function () {
                        //     closeOtherInfo();
                        //     infowindow.close();
                        //     InforObj[0] = infowindow;
                        // });
                    }
                }
        
                function closeOtherInfo() {
                    if (InforObj.length > 0) {
                        /* detach the info-window from the marker ... undocumented in the API docs */
                        InforObj[0].set("marker", null);
                        /* and close it */
                        InforObj[0].close();
                        /* blank the array */
                        InforObj.length = 0;
                    }
                } 
        
                function initMap() {
                    map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 15,
                        center: centerCords
                    });
                    addMarker();
					//autoCenter();
                }
				
	
	function SetHotelMarker (im) {
        google.maps.event.trigger(markers[im], 'click');
       }
	  
</script>