@extends('layouts.frontend')
@section('title', 'Hotel Search')
@section('bodyclass', 'hotel-search single-page page-search') 
@section('content')
<style>
#hotelmap{width: 100%;height: 350px;}
#hotelmap .gm-style .gm-style-iw-t::after{display:none;}
#hotelmap .gm-style-iw button{display:none!important;}
</style>
<style>
#country-list {
    float: left;
    list-style: none;
    margin-top: -3px;
    padding: 0;
    width: 100%;
    position: absolute;
}
#country-list li {
    padding: 10px;
    background: #fff;
    border-bottom: #bbb9b9 1px solid;
}
#myULairfac li{ display:none;}
.nationality_option select{width: 250px;float: right;margin-bottom: 6px;border-radius: 0px;padding: 12px 10px;font-size: 16px;height: auto;}
.searchtoolbar{margin: 5px 0px;font-size: 12px;}
.searchtoolbar .searchtext{ color: rgb(117, 117, 136); font-weight: bold;margin-right: 10px;}
.searchloader {display: inline-block;}
#myProgress {width: 100%; background-color: #ddd;
}
.myBar {width: 1%; height: 4px; background-color: #89ad3e;}
.hotelcountinfo{ margin-bottom: 15px;line-height: 1.2;}
.fltLoader {text-align: center;position: absolute; top: 0px; left: 9px; height: 100%; width: 94%;z-index: 99; background: rgba(256,256,256,.7);}
.ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            /* add padding to account for vertical scrollbar */
            padding-right: 20px;
        } 
.custom_sidebar .slider-dragable-range input{word-spacing: 58px!important;}
</style>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDkKetQwosod2SZ7ZGCpxuJdxY3kxo5Po"></script>
<script>
var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 7,
          center: new google.maps.LatLng('25.204849', '55.270783'),
        });

        var infowindow = new google.maps.InfoWindow();
		
		var marker, i;
		
 var elementArray = '{{$totalpages}}';
  $('.flight_loader').hide();
  var mi = 0;
  var mip = 0;
  var mis = 0;
  var InforObj = [];
var markers = new Array();
	  var width = 10;
	  var minpricearray =   new Array();
	  var hotelnamedata =   new Array();
	  var maxpricearray =  {};
	  var faciltiesarray =  {};
	  var mealsarray =  {};
	  var markersOnMap =  {};

 function fetch_data(arrCount)
 {
	  
		var link = '{{URL::to('/')}}/Hotel/ajaxlisting?e={{Request::get('e')}}&city={{Request::get('city')}}&cin={{Request::get('cin')}}&cOut={{Request::get('cOut')}}&Hotel={{Request::get('Hotel')}}&Rooms={{Request::get('Rooms')}}&pax={{Request::get('pax')}}&nationality={{Request::get('nationality')}}&page='+arrCount;
		
		var links = '{{URL::to('/')}}/Hotel/ajaxpricelisting?e={{Request::get('e')}}&city={{Request::get('city')}}&cin={{Request::get('cin')}}&cOut={{Request::get('cOut')}}&Hotel={{Request::get('Hotel')}}&Rooms={{Request::get('Rooms')}}&pax={{Request::get('pax')}}&nationality={{Request::get('nationality')}}&page='+arrCount;
		$.ajax({
		url:link+'&ajax=true',
		datatype: 'json',
		success:function(data)
		{
			arrCount++;
			if(elementArray <5){
				var rre = elementArray;
			}else{
				var rre = 5
			}
			if(arrCount==rre){
				  $('.searchloader').hide();
				   $('.fltLoader').hide();
				  $('.searchtext').html('Our best prices have now loaded');
				  $('.properti_f').show();
				width = 100;   
				$('.myBar').css({
                    width: width + '%'
                });
			}
			 width += width;
			 if (width >= 100) {
				  } else {
					$('.myBar').css({
                    width: width + '%'
                });
					
				  } 
			if (arrCount <= elementArray){
				var obj = JSON.parse(data);
				//console.log(obj.filtersMeta.hotelprice.min);
				 if(obj.success){
					
						$.ajax({
						url:links+'&ajax=true',
						datatype: 'json',
						success:function(data)
						{
							var objs = JSON.parse(data);
							 $.each(objs.hotels, function (index, value) {
								 if(value.price != 'Not abailable'){
								minpricearray.push(value.price); 
								 }
								
								 $.each(value.mealplans, function (index, value) {
									if( mealsarray[value.slug] === undefined ) {	
										mealsarray[value.slug] = value.name;
									}else{
								
									} 
						});
							 $.each(mealsarray, function (indexa, valuess) {
							 if($('#myULairmeal li').hasClass(indexa)){}else{
							$('#myULairmeal').append('<li style="" class="'+indexa+'"><label class="label-container checkbox-default">'+valuess+'<input name="meal_plan" check_see="0" class="chboxmealplan hotelmealplans" type="checkbox" value="'+indexa+'"><span class="checkmark"></span></label></li>');
							}
						});
								if(value.price == 'Not abailable'){
									$('#code_'+value.code).remove();
								}
								$('#code_'+value.code+' .mealplans').attr('mealplan',value.mealplan);
								$('#code_'+value.code+' .room_price_res').hide();
								//$('#code_'+value.code+' .room_price').attr('src',value.mapimage);
								$('#code_'+value.code+' .room_price').show();
								$('#code_'+value.code+' .select_hotel_btn').show();
								$('#code_'+value.code+' .price_value').html('<i class="fas fa-rupee-sign"></i>'+value.price);
								$('#code_'+value.code+' .price1').attr('price',value.price);
								$('#code_'+value.code+' .price1').attr('data-price',value.price);
								$('#code_'+value.code+' .select_hotel_btn').html('<a target="_blank" href="<?php echo \URL::to('Hotel/HotelDetail'); ?>?city={{Request::get('city')}}&cin={{Request::get('cin')}}&cOut={{Request::get('cOut')}}&Hotel=NA&Rooms={{Request::get('Rooms')}}&pax={{Request::get('pax')}}&sid='+value.sid+'&hid='+value.code+'">View Room <i class="fa fa-angle-right"></i></a>');
								$('#code_'+value.code+' .bookinglink').attr('href', '<?php echo \URL::to('Hotel/HotelDetail'); ?>?city={{Request::get('city')}}&cin={{Request::get('cin')}}&cOut={{Request::get('cOut')}}&Hotel=NA&Rooms={{Request::get('Rooms')}}&pax={{Request::get('pax')}}&sid='+value.sid+'&hid='+value.code);
							});
							
							priceslider(Math.min.apply(Math,minpricearray), Math.max.apply(Math,minpricearray));
					
							
							
						}
					});
					
					
					 $.each(obj.filtersMeta.hotelnamedata, function (index, value) {
						hotelnamedata.push(value);
					});
					//maxpricearray.push(obj.filtersMeta.hotelprice.max); 
					
						 $.each(obj.filtersMeta.facilties, function (index, value) {
							if( faciltiesarray[value.slug] === undefined ) {	
							
								faciltiesarray[value.slug] = value.name;
							}else{
								
							 } 
						});
						
						
						   
						
						
					$.each(faciltiesarray, function (indexs, values) {
						if($('#myULairfac li').hasClass(indexs)){}else{
						$('#myULairfac').append('<li style="" class="'+indexs+'"><label class="label-container checkbox-default">'+values+'<input name="property_type" check_see="0" class="chboxAirline hotelfacilties" type="checkbox" value="'+indexs+'"><span class="checkmark"></span></label></li>');
						}
					});
					
				} 
				$('#ajaxContent').append(obj.hotelsdata);
				
					fetch_data(arrCount);
						var count_bhanu = 0;
		
				$(".refendable11onword").each(function() {
					if ($("div:visible", this).length > 10) {
						//console.log(count_bhanu);
						count_bhanu = count_bhanu + 1;
					}
				});
				
				$(".properti_f").html(count_bhanu+' Hotels available');
					
					 $.each(obj.mapdata, function (index, value) {
						
						$('.hotel_map_list').append(
						'<div class="hotel_item"><a href="#" onclick="SetHotelMarker('+mi+')"><div class="hotel_img" style="background:url('+value.placeImage+')"></div><div class="hotel_info"><div class="title_wrap"><h3 class="title">'+value.placeName+'</h3> <div class="hotel_star">'+value.placerate+'</div></div><div class="hotel_address">'+value.placeaddress+'</div><div class="hotel_stats"><span class="beds">1 Bed</span><div class="hotel_stay"><span>23 nights, 2 adult</span></div></div><div class="room_price"><span class="price_value"><i class="fas fa-rupee-sign"></i> '+value.placeprice+'</span><div class="tax_price"><span>+ <i class="fas fa-rupee-sign"></i> 191, 287 taxes and charges</span></div></div><div class="clearfix"></div></div></a></div>');
						mi++;
					});
					
					
					size_li = $("#myULairfac li").length;
					for (var i = 0; i < obj.mapdata.length; i++) {
						 var contentString = '<div id="content"><div class="hotelimg"><img src="'+obj.mapdata[i].placeImage+'"></div><div class="hotelinf"><h3>' + obj.mapdata[i].placeName +
                            '</h3><div class="ht_stars">'+obj.mapdata[i].placerate+'</div><div class="ht_tripadvis"><img class="item-left-img" src="{!! asset('public/img/ta-45.png')!!}" width="55" alt="Trip Advisior"></div><div class="ht_price"><span><i class="fas fa-rupee-sign"></i> '+obj.mapdata[i].placeprice+'</span></div><div class="clearfix"></div></div></div>';
					   const marker = new google.maps.Marker({
                            position: new google.maps.LatLng(obj.mapdata[i].LatLng[0].lat, obj.mapdata[i].LatLng[0].lng),
                            map: map
                        });
						//markers.push(marker);
						markers[mis] = marker;
					  const infowindow = new google.maps.InfoWindow({
                            content: contentString,
                            maxWidth: 650
                        }); 
        
                        marker.addListener('click', function () {
                            closeOtherInfo();
                            infowindow.open(marker.get('map'), marker);
                            InforObj[0] = infowindow;
                        }); 
					  mis++;
					}  
					
					
					
					
				xs = 10; 
				  if(size_li > 10){
					  $('#facloadMore').show();
					 
				  }else{
					  $('#facloadMore').hide();
					
				  }
				$('#myULairfac li:lt(' + xs + ')').show();	
			}
		}
	});
	
	var stops1 = "";
	 var count_checked = $(".starfliter:checked").length;
	 if(count_checked != 0){ 
				$(".flightstar").each(function() {
					
					if ($(this).attr("check_see") == "1") {
						stops1 = $(this).val();

						$(".starsscount").each(function() {

							if (stops1 == $(this).attr("stars")) {

								$(this).show();
							}

						});

					} else {
						var stops2 = $(this).val();
						$(".starsscount").each(function() {
							if (stops2 == $(this).attr("stars")) {
								$(this).hide();
							}

						});

					}

				});
				
				
		}
		 var count_checkeds = $(".hotelfacilties:checked").length;
	 if(count_checkeds != 0){ 
		$('.facilities').hide();
				$(".hotelfacilties").each(function() {
					
					if ($(this).attr("check_see") == "1") {
						stops1 = $(this).val();

						$(".facilities").each(function() {
							var s = $(this).attr("facilities");
							
							var d = s.split(';');
							console.log(checkValue(stops1, d));
						if (checkValue(stops1, d) == 'Exist') {
							

								$(this).show();
							}
							

						});

					} 

				});
				if (stops1 == "") {
					$(".facilities").each(function() {
						$(this).show();
					});
	 }
	 }
	 
	 var stops1 = "";
	 var count_checked = $(".hotelmealplans:checked").length;
	 if(count_checked != 0){ 
				$(".hotelmealplans").each(function() {
					
					if ($(this).attr("check_see") == "1") {
						stops1 = $(this).val();

						$(".mealplans").each(function() {

							if (stops1 == $(this).attr("mealplan")) {

								$(this).show();
							}

						});

					} else {
						var stops2 = $(this).val();
						$(".mealplans").each(function() {
							if (stops2 == $(this).attr("mealplan")) {
								$(this).hide();
							}

						});

					}

				});
				
				
		}
		if($('#hotelsearchname').val() != ''){
		  var stops1 = "";
				$('.hotelnamesearch').hide();
				$(".hotelnamesearch").each(function() {
							var stops1 = $('#hotelsearchname').val();
							
						if (stops1 == ui.item.value) {

								$(this).show();
							}
							

						});
		}
		var count_bhanu = 0;
		
				$(".refendable11onword").each(function() {
					if ($("div:visible", this).length > 10) {
						//console.log(count_bhanu);
						count_bhanu = count_bhanu + 1;
					}
				});
				
				$(".properti_f").html(count_bhanu+' Hotels available');
				
		//console.log(hotelnamedata);
				
 } 

 fetch_data(0); 
 
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
 function SetHotelMarker (im) {
        google.maps.event.trigger(markers[im], 'click');
       }
</script>
<?php
//echo '<pre>'; print_r($data); die; 
?>
<!-- Content
		============================================= -->
<section id="table_data">
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
									<div class="form-group cus_checkinout_field">
										<input type="text" placeholder="Check In" name="datetimes" class="form-control" />
										<div class="calender-icon"><i class="far fa-calendar"></i></div>
										<div class="checkinout_wrap">
											
											<div class="checkin cus_check">
												<span><?php
												if(isset($_GET['cin'])){
													$explodecin = explode('/', $_GET['cin']);
													$cindate = $explodecin[2].'-'.$explodecin[1].'-'.$explodecin[0];
													echo date('d M Y',strtotime($cindate));
												}else{
													echo 'Check-In';
												}
												?></span>
											</div>
											<div class="check_space">
												<span>-</span>
											</div>
											<div class="checkout cus_check">
												<span><?php
												if(isset($_GET['cOut'])){
													$explodecOut = explode('/', $_GET['cOut']);
													$cOutdate = $explodecOut[2].'-'.$explodecOut[1].'-'.$explodecOut[0];
													echo date('d M Y',strtotime($cOutdate));
												}else{
													echo 'Check-out';
												}
												?></span>
											</div> 
										</div>
									</div>
									<input type="hidden" value="{{@$_GET['cin']}}" id="txtCheckInDate">
									<input type="hidden" value="{{@$_GET['cOut']}}" id="txtCheckOutDate">
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
										<li class="active"><a href="{{URL::to('/')}}">Home</a></li>
										<li><span><i class="fa fa-angle-right"></i></span></li>
										<li><a href="javascript:;">Hotel Search</a></li>
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
										<div class="fltLoader"><i class="fa fa-spinner  fa-pulse fa-3x fa-fw"></i></div>
										<div class="box-widget">
											<h5 class="box-title">Search By Name</h5>
											<div class="box-content">
												<input type="text" id="hotelsearchname" class="form-control hotelname_search" placeholder="Search By Name"/>
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
										
										<div class="box-widget">
											<h5 class="box-title">Star Rating</h5>
											<div class="box-content">
												<ul class="check-boxes-custom list-checkboxes">
												<li>
														<label for="option5" class="label-container checkbox-default"><span>5 <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>
															<input name="options" class="starfliter flightstar" check_see="0" id="option5" type="checkbox" value="5">
															<span class="checkmark"></span>
														</label>
													</li>
													<li>
														<label for="option4" class="label-container checkbox-default"><span>4 <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>
															<input name="options" class="starfliter flightstar" check_see="0" id="option4" type="checkbox" value="4">
															<span class="checkmark"></span>
														</label>
													</li><li>
														<label for="option3" class="label-container checkbox-default"><span>3 <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>
															<input name="options" class="starfliter flightstar" check_see="0" id="option3" type="checkbox" value="3">
															<span class="checkmark"></span>
														</label>
													</li>
													<li>
														<label for="option2" class="label-container checkbox-default"><span>2 <i class="fa fa-star"></i><i class="fa fa-star"></i></span>
															<input name="options" class="starfliter flightstar" check_see="0" id="option2" type="checkbox" value="2">
															<span class="checkmark"></span>
														</label>
													</li>
													<li>
														<label for="option1" class="label-container checkbox-default"><span>1 <i class="fa fa-star"></i></span>
															<input name="options" class="starfliter flightstar" check_see="0" id="option1" type="checkbox" value="1">
															<span class="checkmark"></span>
														</label>
													</li>
													<li>
														<label for="option0" class="label-container checkbox-default"><span>0 <i class="fa fa-star"></i></span>
															<input name="options" class="starfliter flightstar" check_see="0" id="option0" type="checkbox" value="0">
															<span class="checkmark"></span>
														</label>
													</li>
													
													
												</ul><!-- .check-boxes-custom end -->
											</div><!-- .box-content end -->
										</div><!-- .box-widget end -->
										<div class="box-widget">
											<h5 class="box-title">Meal Plan</h5>
											<div class="box-content">
												<ul id="myULairmeal" class="check-boxes-custom list-checkboxes">
												
												</ul>  
												
											</div><!-- .box-content end -->
										</div><!-- .box-widget end -->
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
									
									<h4 class="hotelcountinfo">{{$city}}: <span style="display:none;" class="properti_f">0 Hotels available</span></h4>
									<div class="searchtoolbar">
										<span class="searchtext">We are loading our best prices</span>
										<div class="searchloader"><i class="fa fa-spinner fa-spin"></i></div>
									</div> 
									</div>
									<div class="hotel_sorting">
										<label>Sort By:</label>
										<select class="sortprice">
											
											<option value="">Sort By</option>
											<option value="ASC">Price - Low to High</option>
											<option value="DESC">Price - High to Low</option>
										</select>
									</div>
									<div id="myProgress">
									  <div class="myBar"></div>
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
									<div id="ajaxContent"></div>
										
										
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



<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
<script>
<?php
$mapdata = array();
?>

	  
</script>
</div>

<div class="flight_loader" style="display:none;">
<div class="inner_loader">
<h4>Please wait....</h4>
<p><i class="fa fa-spinner" aria-hidden="true"></i> We are looking for the best Hotel for you.</p>
</div>
</div>
<div class="searchpop1" style="display:none;">
	<div id="dvWait"> 
		<div class="mob_gif_center">
			<p><strong> Please wait.</strong>. <br> we are searching best fares for you.</p>
			<div class="clearfix"></div>
			<div class="loading-plane-pop"></div>
		</div>
		<div class="wait-popup">			
			<div class="wait-txe">
				<h3>Hotel Search in Progress for <span>Delhi</span></h3>
				<p>Searching for the best deal for you. Kindly wait, this may take a little time</p> 
			</div> 
			<div class="clearfix"></div>
			<div class="hotel_wait_main">
				<div class="check_time">
					<span class="check_btn">Check-In</span>
					<span class="hotel_date checkinda">d <span>MM<br/>YYYY</span></span>
				</div>
				<div class="wait_space">
					<div class="divider_border"></div>
				</div>
				<div class="check_time">
					<span class="check_btn">Check-Out</span>
					<span class="hotel_date checkoutda">d <span>MM<br/>YYYY</span></span>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="wait_hotel_info">
				<div class="wait_col">
					<span class="wait-hotel-txt">Room(s)</span><br>
					<span class="wait-hotel-txt-small waitroomcount">0 Rooms</span>
				</div>
				<div class="wait_col">
					<span class="wait-hotel-txt">Adult(s)</span><br>
					<span class="wait-hotel-txt-small waitadultcount">0 Adult</span>
				</div>
				<div class="wait_col">
					<span class="wait-hotel-txt">Child(s)</span><br>
					<span class="wait-hotel-txt-small waitchildcount">0 Child</span>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="hotel_srch_fotter">
				<img src="{!! asset('public/images/hotel-booking-img.gif') !!}" alt=""/>
			</div>
		</div>
	</div>
</div>

<div id="hotelinfomap" class="modal fade hotelinfomap" role="dialog" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Hotel Location</h4>
			</div>
			<div class="modal-body">
				<div class="row"> 
					<div class="col-md-12"> 
						<div class="hotelmap_iframe">
							<div id="hotelmap" ></div>
						</div> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php //echo '<pre>'; print_r($mapdata); die; ?>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js" ></script>

<script type="text/javascript">

 $(document).on('click', '.openmap', function(event){
	 $('#hotelinfomap').modal('show');
	 var address = $(this).attr('address');
	 var country = $(this).attr('country');
	 var latss = $(this).attr('lat');

	 var longs = $(this).attr('long');
  // The location of Uluru
  const uluru = { lat: +latss, lng: +longs };
  // The map, centered at Uluru
  const map = new google.maps.Map(document.getElementById("hotelmap"), {
    zoom: 15,
    center: uluru,
  });
 
  
  var contents = '<div id="content">'+  
 
  '<h3 id="firstHeading" class="firstHeading">Address</h3>'+  
  '<p id="" class="address" style="max-width: 200px;">'+address+'</p>'+  
  
  '<p id="" class="countryname">'+country+',</p>'+  

   
  '</div>';    
  
  const infowindow = new google.maps.InfoWindow({  
    content: contents,
	pixelOffset: new google.maps.Size(400,200)
  });  
   // The marker, positioned at Uluru
  const marker = new google.maps.Marker({
    position: uluru,
    map: map,
  });

 marker.addListener("click", () => {
    infowindow.open({
      anchor: marker,
      map,
      shouldFocus: false,
    });
  });
  
  infowindow.open(map,marker);

});
    $('ul.pagination').hide();
     $(function() {
		 
		 
	/*	 $(document).on('click', '.pagination a', function(event){
  event.preventDefault(); 
  var page = $(this).attr('href');
  fetch_data(page);
 });

 function fetch_data(page)
 {
	 $('.flight_loader').show();
  $.ajax({
   url:page+'&ajax=true',
   success:function(data)
   {
	   $('.flight_loader').hide();
    $('#table_data').html(data);
	$('html, body').animate({scrollTop:$("#table_data"). offset(). top}, 'slow');
   } 
  });
 } */
 
          /* $('.scrolling-pagination').jscroll({
            autoTrigger: true,
            padding: 0,
			loadingHtml:'<div class="flight_loader" style="display:block;"><div class="inner_loader"><h4>Please wait....</h4><p><i class="fa fa-spinner" aria-hidden="true"></i> We are looking for the best Hotel for you.</p></div></div>',
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.scrolling-pagination',
            callback: function() {
                $('ul.pagination').remove();
				var i=0;
				$('.hotel_list .hotel_item').each( function(){
					i++;
				});
				$('.result_found span').html(i);
            }
        }); */  
    });
</script>

<script>
$(document).delegate('.clearall','click', function(){
			$(".starfliter").each(function() {
				$(this).show();
			});
			$(".hotelnamesearch").each(function() {
				$(this).show();
			});
			$(".price1").each(function() {
				$(this).show();
			});
			$(".mealplans").each(function() {
				$(this).show();
			});
			$(".facilities").each(function() {
				$(this).show();
			});
			$(".starsscount").each(function() {
				$(this).show();
			});
			
			$(".flightstar").each(function() {
				$(this).attr("check_see", "0");
				$('input:checkbox').removeAttr('checked');
			});
			$(".hotelmealplans").each(function() {
				$(this).attr("check_see", "0");
				$('input:checkbox').removeAttr('checked');
			});
			$(".hotelfacilties").each(function() {
				$(this).attr("check_see", "0");
				$('input:checkbox').removeAttr('checked');
			});
			$("#hotelsearchname").val('');
			var minpric = $('.slider-range').attr('data-slider-min-value');
			var maxprice = $('.slider-range').attr('data-slider-max-value');
			
			priceslider(parseInt(minpric),parseInt(maxprice));
			var count_bhanu = 0;
				$(".refendable11onword").each(function() {
					if ($("div:visible", this).length > 10) {
						count_bhanu = count_bhanu + 1;
					}
				});
				
				$(".properti_f").html(count_bhanu+' Hotels available');
		});
function priceslider(minpric,maxprice){
	 $(".slider-range").attr("data-slider-max-value", maxprice);
	$(".slider-range").attr("data-range-end-value",maxprice);
	 $(".slider-range").attr("data-slider-min-value", minpric);
	$(".slider-range").attr("data-range-start-value",minpric);
	 var valueSign = $(".slider-range").attr("data-slider-value-sign");
	 
	  $(".slider-range-price .price").val(valueSign + minpric + " - " + valueSign + maxprice);
	 $(".slider-range").slider("destroy");
					$('.slider-range').slider({
			range: true,
			min: minpric,
			max: maxprice,
			values: [minpric, maxprice],
			stop: function (event, ui) {
				
                var minCheck = parseInt(ui.values[0]);
                var maxCheck = parseInt(ui.values[1]);
				$('#minprice').val(minCheck);
				$('#maxprice').val(maxCheck);
				$(".price1").each(function(){
                    if($(this).attr("price")<=ui.values[ 0 ] || $(this).attr("price")>=ui.values[ 1 ])
                    {
                        $(this).hide();
                    }
                    if($(this).attr("price")>=ui.values[ 0 ] && $(this).attr("price")<=ui.values[ 1 ])
                    {
                        $(this).show();
                    }
                });

var count_bhanu = 0;
				$(".refendable11onword").each(function() {
					if ($("div:visible", this).length > 10) {
						count_bhanu = count_bhanu + 1;
					}
				});
				
				$(".properti_f").html(count_bhanu+' Hotels available');				
            },
			slide: function (event, ui) {
				$(".slider-range-price .price").val(valueSign + ui.values[0] + " - " + valueSign + ui.values[1]);
			}
		});
		
		
}
function selectCountry(val) {
		$("#search-box").val(val);
		$("#txtCity").val(val);
		$("#suggesstion-box").hide();
	}
	$(document).ready(function () {
		/* $(document).delegate('.clearall','click', function(){
			$('.custom_sidebar input:checkbox').removeAttr('checked');
			$('#minprice').val('');
			$('#maxprice').val('');
			hotelfilter();
		}); */
		/* $( ".slider-range-price" ).each( function() {
		var $this = $(this),
			sliderRange = $this.find(".slider-range"),
			valMin = sliderRange.data("slider-min-value"),
			valMax = sliderRange.data("slider-max-value"),
			valStart = sliderRange.data("range-start-value"),
			valEnd = sliderRange.data("range-end-value"),
			valueSign = sliderRange.data("slider-value-sign");

		sliderRange.slider({
			range: true,
			min: valMin,
			max: valMax,
			values: [valStart, valEnd],
			stop: function (event, ui) {
				
                var minCheck = parseInt(ui.values[0]);
                var maxCheck = parseInt(ui.values[1]);
				$('#minprice').val(minCheck);
				$('#maxprice').val(maxCheck);
              hotelfilter();
            },
			slide: function (event, ui) {
				$this.find(".price").val(valueSign + ui.values[0] + " - " + valueSign + ui.values[1]);
			}
		});

		$this.find(".price").val(valueSign + sliderRange.slider("values", 0) +
			" - " + valueSign + sliderRange.slider("values", 1));
	} ); */
		
		/* $(document).delegate('.hotelname_search','keyup', function(){
			//alert($(this).val().length);
			 if($(this).val().length >= 3) {
				hotelfilter();
			 }
		}); */
		// $(document).delegate('.sortprice','change', function(){
			//hotelfilter();
		// });
		$(document).delegate('.starfliter','click', function(){
			//hotelfilter();
		});
		
		//$(document).delegate('.hotelfacilties','click', function(){
			//hotelfilter();
		//});
		
		function hotelfilter(){
			var sortprice = $('.sortprice option:selected').val();
			 var starfliter = new Array();
            $(".starfliter:checked").each(function() {
                starfliter.push($(this).val());
            });
			
			 var hotelfacilties = new Array();
            $(".hotelfacilties:checked").each(function() {
                hotelfacilties.push($(this).val());
            });
			var minCheck = $('#minprice').val();
			var maxCheck = $('#maxprice').val();
			var hotelname = $('.hotelname_search').val();
			 $('.flight_loader').show();
			$.ajax({
				url: '{{URL::to('Search/filter')}}',
				data: {e:'{{Request::get('e')}}', city:'{{Request::get('city')}}', cin:'{{Request::get('cin')}}', cOut:'{{Request::get('cOut')}}', Hotel:'{{Request::get('Hotel')}}', Rooms:'{{Request::get('Rooms')}}', pax:'{{Request::get('pax')}}',starRating:starfliter,sortprice:sortprice,hotelname:hotelname,hotelfacilties:hotelfacilties,minprice:minCheck,maxprice:maxCheck},
				type:'GET',
				success: function(html){
					 $('.flight_loader').hide();
					$('.hotel_list_sec').html(html);
				}
			});
		}
		
		
		$('#facloadMore').click(function() {
			size_li = $("#myULairfac li").length;
				xs = (xs + 5 <= size_li) ? xs + 5 : size_li;
				//alert(size_li);
				$('#myULairfac li:lt(' + xs + ')').show(); 
				 if(xs == size_li){
						$('#facloadMore').hide();
					}
			  });
		
		$("#search-box").keyup(function(){
		$.ajax({
		type: "GET",
		url: "{{URL::to('/hotel-cities')}}",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#search-box").css("background","#FFF");
		}
		});
	});
	
    var itemsMainDiv = ('.MultiCarousel');
    var itemsDiv = ('.MultiCarousel-inner');
    var itemWidth = "";

    $('.leftLst, .rightLst').click(function () {
        var condition = $(this).hasClass("leftLst");
        if (condition)
            click(0, this);
        else
            click(1, this)
    });

    ResCarouselSize();
	
    $(window).resize(function () {
        ResCarouselSize();
    });

    //this function define the size of the items
    function ResCarouselSize() {
        var incno = 0;
        var dataItems = ("data-items");
        var itemClass = ('.item');
        var id = 0;
        var btnParentSb = '';
        var itemsSplit = '';
        var sampwidth = $(itemsMainDiv).width();
        var bodyWidth = $('body').width();
        $(itemsDiv).each(function () {
            id = id + 1;
            var itemNumbers = $(this).find(itemClass).length;
            btnParentSb = $(this).parent().attr(dataItems);
            itemsSplit = btnParentSb.split(',');
            $(this).parent().attr("id", "MultiCarousel" + id);


            if (bodyWidth >= 1200) {
                incno = itemsSplit[3];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 992) {
                incno = itemsSplit[2];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 768) {
                incno = itemsSplit[1];
                itemWidth = sampwidth / incno;
            }
            else {
                incno = itemsSplit[0];
                itemWidth = sampwidth / incno;
            }
            $(this).css({ 'transform': 'translateX(0px)', 'width': itemWidth * itemNumbers });
            $(this).find(itemClass).each(function () {
                $(this).outerWidth(itemWidth);
            });

            $(".leftLst").addClass("over");
            $(".rightLst").removeClass("over");

        });
    }


    //this function used to move the items
    function ResCarousel(e, el, s) {
        var leftBtn = ('.leftLst');
        var rightBtn = ('.rightLst');
        var translateXval = '';
        var divStyle = $(el + ' ' + itemsDiv).css('transform');
        var values = divStyle.match(/-?[\d\.]+/g);
        var xds = Math.abs(values[4]);
        if (e == 0) {
            translateXval = parseInt(xds) - parseInt(itemWidth * s);
            $(el + ' ' + rightBtn).removeClass("over");

            if (translateXval <= itemWidth / 2) {
                translateXval = 0;
                $(el + ' ' + leftBtn).addClass("over");
            }
        }
        else if (e == 1) {
            var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
            translateXval = parseInt(xds) + parseInt(itemWidth * s);
            $(el + ' ' + leftBtn).removeClass("over");

            if (translateXval >= itemsCondition - itemWidth / 2) {
                translateXval = itemsCondition;
                $(el + ' ' + rightBtn).addClass("over");
            }
        }
        $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
    }

    //It is used to get some elements from btn
    function click(ell, ee) {
        var Parent = "#" + $(ee).parent().attr("id");
        var slide = $(Parent).attr("data-slide");
        ResCarousel(ell, Parent, slide);
    }
	
	
	
	var selhotel = $('.hotel-wrapper-dropdown-2'),
   txtroundhotel = $('.hotel-roundwayfrom'),
    optionshotel = $('.hotel-location_search');
selhotel.click(function (e) {
    e.stopPropagation();
    optionshotel.show();
});
$('body').click(function (e) {
    optionshotel.hide();
});
$(document).delegate('.hotel_is_search_from_val li','click',function (e) {
    e.stopPropagation();
    txtroundhotel.val($(this).attr('roundwayfromtop'));
	$('#txtCity').val($(this).attr('roundwayfrom'));
    $(this).addClass('selected').siblings('li').removeClass('selected');
    optionshotel.hide();
	txtroundhotel.blur();
	$('#datepicker-time-start').focus();
});


	var typingTimerhotel;                //timer identifier
	var doneTypingIntervalhotel = 5000;
	var minlength = 3;
	$('.loc_search_field input[name="location"]').on("keyup", function(){
		if (typingTimerhotel) clearTimeout(typingTimerhotel); 
		
		var inputVal = $(this).val();
		if (inputVal.length >= minlength ) {
			typingTimerhotel = setTimeout(doneTyping(inputVal, 'hotel_is_search_from_val'), doneTypingIntervalhotel);
	 
		}
	}); 
	$('.loc_search_field input[name="location"]').on("keyup", function(){
		clearTimeout(typingTimerhotel);
	});
					
	function doneTyping (inputVal,classname) {
		$.ajax({
		   url:"{{URL::to('/Hotel/cities/')}}",
		   method:'GET',
		   data:{textval:inputVal, type:classname},
		   dataType:'json',
		   success:function(data)
		   {
			$('.'+classname).html(data.table_data);
		 
		   }
		  });
	}
});
$(document).ready(function () {
	 function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1]);// decodeURIComponent(results[1].replace(/\+/g, " "));
    }
    var numberOfPaxString = getParameterByName('pax');
        var totalRoomDetails = numberOfPaxString.split('?');
        var TotalRoom = totalRoomDetails.length;
        var childAgetwo = 2, childAgeOne = 1, adult = 0, room = 0, child = 1, childageone = 2, childageTwo = 3;
        var roomhtml = "";  //$("#hdnroom").val(TotalRoom);
        //This will add total adults and total childe with age when customer click the modyfi/search RoomGuest button
        for (var i = 1; i <= TotalRoom; i++) {
            roomhtml += '<div class="box" id="divroom' + i + '">';
            roomhtml += '<div class="roomTxt"><span id="RoomNumer' + i + '">Room ' + i + ':</span></div>';
            roomhtml += '<div class="left pull-left">';
            roomhtml += '<span class="txt">';
            roomhtml += '<span id="Label7">Adult <em>(Above 12 years)</em></span></span>';
            roomhtml += '</div>';
            roomhtml += '<div class="right pull-right">';
            roomhtml += '<div id="field1" class="PlusMinusRow">';
            roomhtml += '<a type="button" id="Adults_room_' + i + '_' + i + '_minus" class="sub hoteladultclass">-</a>';
            roomhtml += '<span id="Adults_room_' + i + '_' + i + '" class="PlusMinus_number">' + totalRoomDetails[room].split('_')[adult] + '</span>';
            //roomhtml += '<a type="button" onclick="GuestCountPluse()" id="Adults_room_1_1_plus" class="add hoteladultclass" >+</a>';
            roomhtml += '<a type="button"  id="Adults_room_' + i + '_' + i + '_plus" class="add hoteladultclass" >+</a>';
            roomhtml += '</div> ';
            roomhtml += '</div> ';
            roomhtml += '<div class="spacer"></div>';
            roomhtml += '<div class="left pull-left"> ';
            roomhtml += '<span class="txt">';
            roomhtml += '<span id="Label9">Child <em>(Below 12 years)</em></span></span>';
            roomhtml += '</div>';
            roomhtml += '<div class="right pull-right">';
            roomhtml += '<div id="field2" class="PlusMinusRow">';
            //roomhtml += '<a type="button" onclick="GuestCountMinus()"   id="Children_room_1_1_minus" class="sub hotelchildclass">-</a>';
            roomhtml += '<a type="button"    id="Children_room_' + i + '_' + i + '_minus" class="sub hotelchildclass">-</a>';
            if (totalRoomDetails[room].split('_')[child] === undefined) {
                roomhtml += '<span id="Children_room_' + i + '_' + i + '" class="PlusMinus_number">0</span>';
            } else {

                roomhtml += '<span id="Children_room_' + i + '_' + i + '" class="PlusMinus_number">' + totalRoomDetails[room].split('_')[child] + '</span>';
            }
            roomhtml += '<a type="button" id="Children_room_' + i + '_' + i + '_plus" class="add hotelchildclass">+</a>';
            roomhtml += '</div> ';
            roomhtml += '</div>';
            roomhtml += '<div class="clear"></div>';
            roomhtml += '<div class="childresAgeTxt" id="Children_room_' + i + '_' + i + '_text" style="display: none">Age(s) of Children</div>';
            //roomhtml += '<select id="Child_Age_'+i+'_'+i+'" style="display: none"><option option="selected">'+totalRoomDetails[loop].split('_')[loop+1]+'</option></select>';
            //roomhtml += '<select id="Child_Age_'+i+'_'+childAgetwo+'" style="display: none"><option option="selected">'+totalRoomDetails[loop].split('_')[loop+1]+'</option></select>';

            if (totalRoomDetails[room].split('_')[childageone] === undefined) {
                roomhtml += '<select id="Child_Age_' + i + '_' + childAgeOne + '" style="display: none"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option></select>';
            } else {
                roomhtml += '<select id="Child_Age_' + i + '_' + childAgeOne + '" ><option option="selected">' + totalRoomDetails[room].split('_')[childageone] + '<option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option></select>';
            }
            if (totalRoomDetails[room].split('_')[childageTwo] === undefined) {
                roomhtml += '<select id="Child_Age_' + i + '_' + childAgetwo + '" style="display: none"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option></select>';
            } else {
                roomhtml += '<select id="Child_Age_' + i + '_' + childAgetwo + '" ><option option="selected">' + totalRoomDetails[room].split('_')[childageTwo] + '<option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option></select>';
            }
            roomhtml += '<div class="clear"></div> ';
            roomhtml += '</div>'; room++; $("#roomcount").val(i);

        }
        if (TotalRoom >= 4) {
            $("#addhotelRoom").css("display", "none");
            $("#removehotelRoom").css("display", "inline-block");
        }
        if (TotalRoom >= 2 && TotalRoom <= 4) {
            $("#addhotelRoom").css("display", "inline-block");
            $("#removehotelRoom").css("display", "inline-block");
        } if (TotalRoom == 1) {
            $("#removehotelRoom").css("display", "none");
        }
        // $("#hdnroom").val(TotalRoom);  //i have assign the Total Room count taking form first page
        $("#roomshtml").html(roomhtml);
        var roomcnt = $("#hdnroom").val();
        if (parseInt(roomcnt) > 1) {
            for (var i = 2; i <= parseInt(roomcnt) ; i++) {
                setRoomsPanel(i)
            }
        } 
        $('#divHotelPaxContent').fadeOut();
        var TotalAdults = 0; TotalChild = 0, NumberOfPax = ""; //2_2_4_3?4_2_4_4?2
        for (var room = 1; room <= TotalRoom; room++) {
            if (document.getElementById('Adults_room_' + room + '_' + room) != null && document.getElementById('Adults_room_' + room + '_' + room).innerHTML != "")
                TotalAdults += parseInt(document.getElementById('Adults_room_' + room + '_' + room).innerHTML);
            TotalChild += parseInt(document.getElementById('Children_room_' + room + '_' + room).innerHTML);
            NumberOfPax += parseInt(document.getElementById('Adults_room_' + room + '_' + room).innerHTML) + "_" + parseInt(document.getElementById('Children_room_' + room + '_' + room).innerHTML) + "_" + parseInt(document.getElementById('Child_Age_' + room + '_' + 1).value) + "_" + parseInt(document.getElementById('Child_Age_' + room + '_' + 2).value) + "?";
        }
        $("#hdnroom").val(TotalRoom);
        document.getElementById("guestcount").innerHTML = TotalAdults + TotalChild;
        document.getElementById("guestroom").innerHTML = TotalRoom;
    setRoomsPaxPanel();
    setroomandguestsMsg();
    $("body").delegate(".hotelchildclass", "click", function () {

        if (/plus/i.test(this.id) && parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) < 2) {
            $("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html(parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) + 1);
            setroomandguestsMsg();
        }
        else if (/minus/i.test(this.id) && parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) > 0) {
            $("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html(parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) - 1);
            setroomandguestsMsg();
        }
        if (parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) >= 0 && parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) <= 2) {
            var currentchildcount = $("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html();

            if (parseInt(currentchildcount) == 1) {
                $("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0) + "_text").css("display", "block");
                $("#Child_Age_" + this.id.split('_room')[1].split("_")[1] + "_1").css("display", "inline");
                $("#Child_Age_" + this.id.split('_room')[1].split("_")[1] + "_2").css("display", "none");
            }
            else if (parseInt(currentchildcount) == 2) {
                $("#Child_Age_" + this.id.split('_room')[1].split("_")[1] + "_1").css("display", "inline");
                $("#Child_Age_" + this.id.split('_room')[1].split("_")[1] + "_2").css("display", "inline");
            }
            else if (parseInt(currentchildcount) == 0) {
                $("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0) + "_text").css("display", "none");
                $("#Child_Age_" + this.id.split('_room')[1].split("_")[1] + "_1").css("display", "none");
                $("#Child_Age_" + this.id.split('_room')[1].split("_")[1] + "_2").css("display", "none");
            }
        }
    });

    $("body").delegate(".hoteladultclass", "click", function () {

        if (/plus/i.test(this.id) && parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) < 4) {
            $("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html(parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) + 1);
            setroomandguestsMsg();
        }
        else if (/minus/i.test(this.id) && parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) > 1) {
            $("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html(parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) - 1);
            setroomandguestsMsg();
        }

    });

    $("#addhotelRoom").click(function () {
        var oldroomcnt = $("#hdnroom").val();
        var roomcount = parseInt(oldroomcnt) + 1;
        $("#removehotelRoom").css("display", "inline-block");
        if (parseInt(oldroomcnt) < 4) {
            var roomhtml = "";
            roomhtml += '<div class="box" id="divroom' + roomcount + '" style="display:none;">';
            roomhtml += '<div class="roomTxt"><span>Room ' + roomcount + ':</span></div>';
            roomhtml += '<div class="left pull-left">';
            roomhtml += '<span class="txt">';
            roomhtml += '<span id="Label7">Adult <em>(Above 12 years)</em></span></span>';
            roomhtml += '</div>';
            roomhtml += '<div class="right pull-right">';
            roomhtml += '<div id="field3" class="PlusMinusRow">';
            roomhtml += '<a type="button" id="Adults_room_' + roomcount + '_' + roomcount + '_minus" class="sub hoteladultclass">-</a>';
            roomhtml += '<span id="Adults_room_' + roomcount + '_' + roomcount + '" class="PlusMinus_number">2</span>';
            roomhtml += '<a type="button" id="Adults_room_' + roomcount + '_' + roomcount + '_plus" class="add hoteladultclass">+</a>';
            roomhtml += '</div> ';
            roomhtml += '</div> ';
            roomhtml += '<div class="spacer"></div>';
            roomhtml += '<div class="left pull-left"> ';
            roomhtml += '<span class="txt">';
            roomhtml += '<span id="Label9">Child <em>(Below 12 years)</em></span></span>';
            roomhtml += '</div>';
            roomhtml += '<div class="right pull-right">';
            roomhtml += '<div id="field4" class="PlusMinusRow">';
            roomhtml += '<a type="button" id="Children_room_' + roomcount + '_' + roomcount + '_minus" class="sub hotelchildclass">-</a>';
            roomhtml += '<span id="Children_room_' + roomcount + '_' + roomcount + '" class="PlusMinus_number">0</span>';
            roomhtml += '<a type="button" id="Children_room_' + roomcount + '_' + roomcount + '_plus" class="add hotelchildclass">+</a>';
            roomhtml += '</div> ';
            roomhtml += '</div>';
            roomhtml += '<div class="clear"></div>';
            roomhtml += '<div class="childresAgeTxt" id="Children_room_' + roomcount + '_' + roomcount + '_text" style="display: none;">Age(s) of Children</div>';
            roomhtml += '<select id="Child_Age_' + roomcount + '_1" style="display: none"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option></select>';
            roomhtml += '<select id="Child_Age_' + roomcount + '_2" style="display: none"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option></select>  ';
            roomhtml += '<div class="clear"></div> ';
            roomhtml += '</div>';
            $("#roomshtml").append(roomhtml);
            $("#hdnroom").val(roomcount);
            $("#divroom" + roomcount).slideDown(500);

            setroomandguestsMsg();
            if (roomcount == 4) {
                $("#addhotelRoom").css("display", "none");
            }
        }
        else {
            $("#addhotelRoom").css("display", "none");
        }
    });

    $("#removehotelRoom").click(function () {
        var roomcnt = $("#hdnroom").val();
        if (parseInt(roomcnt) > 1) {
            $("#divroom" + roomcnt).slideUp('300', function () { $(this).remove(); })
            $("#hdnroom").val(parseInt($("#hdnroom").val()) - 1);
            setroomandguestsMsg();
            if (parseInt($("#hdnroom").val()) == 1) {
                $("#removehotelRoom").css("display", "none");
                $("#addhotelRoom").css("display", "inline-block");
            }
            else if (parseInt($("#hdnroom").val()) == 3) {
                $("#addhotelRoom").css("display", "inline-block");
            }
        }

    });
    $("#exithotelroom").click(function () {
        $('#divHotelPaxContent').fadeOut();
    });
    function setroomandguestsMsg() {
        var roomcount = $("#hdnroom").val(); var roomguestmsg = "";
        var guestcount = "0";
		var roomCounts = "0";
        for (var i = 1; i <= parseInt(roomcount) ; i++) {
            guestcount = parseInt(guestcount) + parseInt($("#Adults_room_" + i + "_" + i + "").html());
            guestcount = parseInt(guestcount) + parseInt($("#Children_room_" + i + "_" + i + "").html());
        }
        if (parseInt(roomcount) > 1) {
            roomCounts = parseInt(roomcount)
        }
        else {
            roomCounts = parseInt(roomcount);
        }
        if (parseInt(guestcount) > 1) {
            roomguestmsg += guestcount;
        }
        else {
            roomguestmsg += guestcount;
        }
        $("#guestroom").html(roomCounts);
		$("#guestcount").html(roomguestmsg);
		
		
    }

    function setRoomsPanel(roomcount) {
        var roomhtml = "";
        roomhtml += '<div class="box " id="divroom' + roomcount + '">';
        roomhtml += '<div class="roomTxt"><span>Room ' + roomcount + ':</span></div>';
        roomhtml += '<div class="left pull-left">';
        roomhtml += '<span class="txt">';
        roomhtml += '<span id="Label7">Adult <em>(Above 12 years)</em></span></span>';
        roomhtml += '</div>';
        roomhtml += '<div class="right pull-right">';
        roomhtml += '<div id="field1" class="PlusMinusRow">';
        roomhtml += '<a type="button" id="Adults_room_' + roomcount + '_' + roomcount + '_minus" class="sub hoteladultclass">-</a>';
        roomhtml += '<span id="Adults_room_' + roomcount + '_' + roomcount + '" class="PlusMinus_number">2</span>';
        roomhtml += '<a type="button" id="Adults_room_' + roomcount + '_' + roomcount + '_plus" class="add hoteladultclass">+</a>';
        roomhtml += '</div> ';
        roomhtml += '</div> ';
        roomhtml += '<div class="spacer"></div>';
        roomhtml += '<div class="left pull-left"> ';
        roomhtml += '<span class="txt">';
        roomhtml += '<span id="Label9">Child <em>(Below 12 years)</em></span></span>';
        roomhtml += '</div>';
        roomhtml += '<div class="right pull-right">';
        roomhtml += '<div id="field1" class="PlusMinusRow">';
        roomhtml += '<a type="button" id="Children_room_' + roomcount + '_' + roomcount + '_minus" class="sub hotelchildclass">-</a>';
        roomhtml += '<span id="Children_room_' + roomcount + '_' + roomcount + '" class="PlusMinus_number">0</span>';
        roomhtml += '<a type="button" id="Children_room_' + roomcount + '_' + roomcount + '_plus" class="add hotelchildclass">+</a>';
        roomhtml += '</div> ';
        roomhtml += '</div>';
        roomhtml += '<div class="clear"></div>';
        roomhtml += '<div class="childresAgeTxt" id="Children_room_' + roomcount + '_' + roomcount + '_text" style="display: none;">Age(s) of Children</div>';
        roomhtml += '<select id="Child_Age_' + roomcount + '_1" style="display: none"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option></select>';
        roomhtml += '<select id="Child_Age_' + roomcount + '_2" style="display: none"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option></select>  ';
        roomhtml += '<div class="clear"></div> ';
        roomhtml += '</div>';
        $("#roomshtml").append(roomhtml);
        $("#removehotelRoom").css("display", "inline-block");
        if (roomcount == 4) {
            $("#addhotelRoom").css("display", "none");
        }
    }

    function setRoomsPaxPanel() {
        if ($("#hdnPaxInfo").val() != undefined) {
            var PaxInfo = $("#hdnPaxInfo").val(); var roomcnt = $("#hdnroom").val();
            var arraypax = [];
            arraypax = PaxInfo.split('|');
            for (var i = 1; i <= parseInt(roomcnt) ; i++) {
                for (var z = 1; z < arraypax.length; z++) {
                    $("#Adults_room_" + i + "_" + z + "").text(arraypax[parseInt(z) - 1].split('$')[0].split('-')[0].length);
                    if (arraypax[parseInt(z) - 1].split('$')[0].indexOf('C') > 0) {
                        var childlen = arraypax[parseInt(z) - 1].split('$')[0].split('-')[1].length;
                        if (childlen > 0) {
                            for (var zz = 1; zz <= childlen; zz++) {
                                if (zz == 1) {
                                    $("#Children_room_" + i + "_" + z + "").text(childlen)
                                    $("#Children_room_" + i + "_" + z + "_text").css("display", "block");
                                }
                                $("#Child_Age_" + z + "_" + zz + "").css("display", "block");
                                $("#Child_Age_" + z + "_" + zz + "").val(arraypax[parseInt(z) - 1].split('$')[1].split(',')[parseInt(zz) - 1]);
                            }
                        }
                    }
                }

            }
        }
    }

});
$(function() {
		$('input[name="datetimes"]').daterangepicker({
			autoUpdateInput: false,
			timePicker: false,
			autoApply: true,
			 minDate: moment().startOf('hour'),
			startDate: moment().startOf('hour'),
			endDate: moment().startOf('hour').add(32, 'hour'),
			locale: {
			  format: 'DD/MM/YYYY'
			}
		},function(start, end) {
        console.log("Callback has been called!");
		$('.checkinout_wrap .checkin span').html(start.format('D MMM YYYY'));
		$('.checkinout_wrap .checkout span').html(end.format('D MMM YYYY'));
        //alert(start.format('D MM YYYY') + ' - ' + end.format('D MMMM YYYY'));
		$('#txtCheckInDate').val(start.format('D/MM/YYYY'));
		$('#txtCheckOutDate').val(end.format('D/MM/YYYY'));
        startDate = start;
         endDate = end;    

       });
	   
	 
	});
	$(document).delegate(".flightstar", 'click', function() {
	
				// $("#form_submit_pop_over").modal("show");
				if ($(this).attr("check_see") == "0") {
					$(this).attr("check_see", "1");
				} else {
					$(this).attr("check_see", "0");
				}
				var stops1 = "";
				$(".flightstar").each(function() {
					if ($(this).attr("check_see") == "1") {
						stops1 = $(this).val();

						$(".starsscount").each(function() {

							if (stops1 == $(this).attr("stars")) {

								$(this).show();
							}

						});

					} else {
						var stops2 = $(this).val();
						$(".starsscount").each(function() {
							if (stops2 == $(this).attr("stars")) {
								$(this).hide();
							}

						});

					}

				});
				if (stops1 == "") {
					$(".starsscount").each(function() {
						$(this).show();
					});
				}
			
				var count_bhanu = 0;
				$(".refendable11onword").each(function() {
					if ($("div:visible", this).length > 10) {
						count_bhanu = count_bhanu + 1;
					}
				});
				
				$(".properti_f").html(count_bhanu+' Hotels available');
			});
			
			
			$(document).delegate(".hotelmealplans", 'click', function() {
	
				// $("#form_submit_pop_over").modal("show");
				if ($(this).attr("check_see") == "0") {
					$(this).attr("check_see", "1");
				} else {
					$(this).attr("check_see", "0");
				}
				var stops1 = "";
				$(".hotelmealplans").each(function() {
					if ($(this).attr("check_see") == "1") {
						stops1 = $(this).val();

						$(".mealplans").each(function() {

							if (stops1 == $(this).attr("mealplan")) {

								$(this).show();
							}

						});

					} else {
						var stops2 = $(this).val();
						$(".mealplans").each(function() {
							if (stops2 == $(this).attr("mealplan")) {
								$(this).hide();
							}

						});

					}

				});
				if (stops1 == "") {
					$(".mealplans").each(function() {
						$(this).show();
					});
				}
			
				var count_bhanu = 0;
				$(".refendable11onword").each(function() {
					if ($("div:visible", this).length > 10) {
						count_bhanu = count_bhanu + 1;
					}
				});
				
				$(".properti_f").html(count_bhanu+' Hotels available');
			});
			
			
			function checkValue(value, arr) {
    var status = 'Not exist';

    for (var i = 0; i < arr.length; i++) {
        var name = arr[i];
        if (name == value) {
            status = 'Exist';
            break;
        }
    }

    return status;
}
			$(document).delegate(".hotelfacilties", 'click', function() {
	
				// $("#form_submit_pop_over").modal("show");
				if ($(this).attr("check_see") == "0") {
					$(this).attr("check_see", "1");
				} else {
					$(this).attr("check_see", "0");
				}
				var stops1 = "";
				$('.facilities').hide();
				$(".hotelfacilties").each(function() {
					
					if ($(this).attr("check_see") == "1") {
						stops1 = $(this).val();

						$(".facilities").each(function() {
							var s = $(this).attr("facilities");
							
							var d = s.split(';');
							console.log(checkValue(stops1, d));
						if (checkValue(stops1, d) == 'Exist') {
							

								$(this).show();
							}
							

						});

					} 

				});
				if (stops1 == "") {
					$(".facilities").each(function() {
						$(this).show();
					});
				}
			
				var count_bhanu = 0;
				$(".refendable11onword").each(function() {
					if ($("div:visible", this).length > 10) {
						count_bhanu = count_bhanu + 1;
					}
				});
				
				$(".properti_f").html(count_bhanu+' Hotels available');
			});
	
		
		$(document).delegate('.sortprice','change', function(){
			var val = $('.sortprice option:selected').val();
			
			if (val == 'ASC') {
					$('.refendable11onword').sort(
					function(a, b) {
						return $(a).find('.price1').data('price')
								- $(b).find('.price1').data('price');
					}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
					});
				
				 }
				   else if (val == 'DESC') {
					   
					   $('.refendable11onword').sort(
						function(a, b) {
							return $(b).find('.price1').data('price')
									- $(a).find('.price1').data('price');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
					
					});
					
				  }  
		});	

 $("#hotelsearchname").autocomplete({
        source: hotelnamedata,
		minLength:3,
		  ignoreCase: true

    });		
	/*  $('#hotelsearchname').on('change', function () {
        $('#tagsname').html('You selected: ' + this.value);
    }).change(); */
    $('#hotelsearchname').on('autocompleteselect', function (e, ui) {
	  
	  var stops1 = "";
				$('.hotelnamesearch').hide();
				$(".hotelnamesearch").each(function() {
							var stops1 = $(this).attr("hotelname");
							
						if (stops1 == ui.item.value) {

								$(this).show();
							}
							

						});
						
						var count_bhanu = 0;
				$(".refendable11onword").each(function() {
					if ($("div:visible", this).length > 10) {
						count_bhanu = count_bhanu + 1;
					}
				});
				
				$(".properti_f").html(count_bhanu+' Hotels available');
    });	 
</script>
@endsection