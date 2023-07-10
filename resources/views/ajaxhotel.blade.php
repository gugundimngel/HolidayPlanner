<div class="result_found">
@if(isset($datad))
	<h4>{{$city}}: <span>{{count($datad)}}</span> Properties found</h4>
@endif
</div>
<div class="hotel_sorting">
	<label>Sort By:</label>
	<select class="sortprice">
		<option value="ASC" @if($sortprice == 'ASC') selected @endif>Price - Low to High</option>
		<option value="DESC" @if($sortprice == 'DESC') selected @endif>Price - High to Low</option>
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
<div class="hotel_list scrolling-pagination">
	<?php if(isset($datad)) { 
	foreach($datad aS $hotels){ ?>
	<div class="hotel_item">
		<div class="hotel_img">
			<a href="#">
				<img src="{{@$hotels['image']}}" alt=""/>
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
					<h3 class="title"><a href="#">{{@$hotels['name']}}</a></h3> 
					<div class="title_badges"> 
						<div class="hotel_star">
							@for($i=0; $i<@$hotels['category']; $i++)
								<i class="fa fa-star"></i>
							@endfor
						</div>
					
					</div>
				</div>
				<div class="hotel_search_address">
					<span><i class="fa fa-map-marker-alt"></i> {{@$hotels['address']}}</span>
					<!--<span class="distance">14km from center</span>-->
				</div> 
				<div class="tripadvisior_review">
					<img class="item-left-img" src="{!! asset('public/img/ta-45.png')!!}" alt="Trip Advisior">
				</div>
				<div class="room_amenities">
					<!--<span>Amenities</span>-->
					<?php
					$facilities = explode(';', $hotels['facilities']);
					?>
					<ul>
					@for($i=0;$i<5; $i++)
						<li>{{trim($facilities[$i])}}</li>
					@endfor
					</ul>
				</div>
			</div>
			<div class="right">
				<div class="room_price">
					<span class="price_value"><i class="fas fa-rupee-sign"></i> {{@$hotels['price']}}</span>
					<span class="price_tag">Per Night</span>
					<!--<span class="total_cost">(Total Cost)</span>-->
				</div>
				<div class="select_hotel_btn">
					<a href="{{URL::to('Hotel/HotelDetail')}}?city={{$city}}&cin={{$cin}}&cOut={{$cOut}}&Hotel=NA&Rooms={{$Rooms}}&pax={{$paxsde}}&sid={{@$hotels['search_id']}}&hid={{@$hotels['hotel_code']}}">View Room <i class="fa fa-angle-right"></i></a> 
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
		{{ $hotelcodes->appends($_GET)->links() }}
		<?php
	}else{
		?>
		<h4>No Result Found</h4>
		<?php
	} ?>
	
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
<script type="text/javascript">
    $('ul.pagination').hide();
    $(function() {
        $('.scrolling-pagination').jscroll({
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
        });
    });
</script>