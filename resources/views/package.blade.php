<!--@extends('layouts.frontend')-->
@section('title', @$seoDetails->meta_title)
@section('meta_title', @$seoDetails->meta_title)
@section('meta_keyword', @$seoDetails->meta_keyword)
@section('meta_description', @$seoDetails->meta_desc)
@section('content')
<?php use App\Http\Controllers\PackageController; 

/* echo '<pre>';
								print_r($internationalesponse);
							echo '<pre>'; */
							
?>

 @if ( Session::has('error'))
 <input type="hidden" value="{{ Session::get('error') }}" id="destination_error">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
  var errTitle = document.getElementById('destination_error').value;
      Swal.fire({
          title: errTitle,
          text: "Please enter a valid destination.",
          icon: 'warning',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        })
  </script>
@endif


<section id="banner" class="package_banner">
	<div class="banner-parallax" >
		
		<div class="overlay-colored color-bg-white"></div><!-- .overlay-colored end -->
		<div class="slide-content">
			<div class="container">
				<div class="row"> 
					<div class="col-md-12">
						<div class="hotel_search">
						    <div class="text_ht">
							    <h4>Book Domestic and International Holidays</h4>
                            </div>
							<form id="searchform" action="{{URL::to('/search/')}}" method="get">
								<div id="custom-search-input">
									<div class="input-group widfull">
										<input type="text" name="term" class="search-query" placeholder="Ex. Kerala, Goa, Bangkok  ...">
										<div class="tnsall">
										    <input type="submit" class="btn_search" value="Search">
                                        </div>
									</div>
								</div>
							</form>
						</div><!-- .banner-center-box end -->
					</div><!-- .col-md-12 end -->
				</div><!-- .row end -->
			</div><!-- .container end -->
		</div><!-- .slide-content end -->
	</div><!-- .banner-parallax end -->
</section>
<div class="holiday_banner_bar container">
    <div class="bar_item">
        <img src="../public/images/india-packages.png">
        <span>India Holiday Packages</span>
    </div>
    
    <div class="bar_item">
        <img src="../public/images/international-packages.png">
        <span>IndiaInternational Holiday Packages</span>
    </div>
    
    <div class="bar_item">
        <img src="../public/images/Holiday-Ideas.png">
        <span>Holiday Ideas</span>
    </div>
    
    <div class="bar_item">
        <img src="../public/images/honeymoon-packages1.png">
        <span>Honeymoon Packages</span>
    </div>
</div>
<!-- /container --> 
<div id="section-international-packages" class="section-flat section-popular-packages">
	<section class="section_content recommended_international_tour common_recommend_slider">
		<div class="container"> 
			<div class="row"> 
				<div class="col-md-12">
					<div class="section-title cus_sec_title">
						<h2><strong>Best Selling International Holiday Packages</strong></h2>
						<p>Explore Top International Holidays</p>
					</div>
					<div class="slider-popular-packages">
						<ul class="slick-slider">
							<?php
							
						    foreach($internationalesponse as $ilist){
								$pprices = 0; 
								$priced  = array();
								
								if(!empty(@$ilist->mypackage)){
									foreach(@$ilist->mypackage as $key => $poplist){
									   // dd($poplist->sales_price);
										$priced[] = !empty($poplist->sales_price) ?$poplist->sales_price : $key;
									}
								
									$pprices = @$priced;
								// 	$pprices = @min(@$priced);
									
							
								}
						    
						?>
						
							<li>
								<div class="box-preview box-tour-package">
									<div class="box-img img-bg">
										<a href="{{URL::to('/destinations/'.$ilist->slug)}}"><img src="{{URL::to('/public/img/media_gallery')}}/{{@$ilist->desmedia->images}}" alt="{{@$ilist->image_alt}}"></a>
										<div class="overlay">
											<div class="overlay-inner">
											</div><!-- .overlay-inner end -->
										</div><!-- .overlay end -->
										{{-- <span class="night-price">INR {{@$pprices}}*</span> --}}
									</div><!-- .box-img end -->
									<div class="box-content">
										<div class="title">
											<h5><a href="{{URL::to('/destinations/'.$ilist->slug)}}">{{@$ilist->name}}</a></h5>
										</div><!-- .title end -->
									</div><!-- .box-content end -->
								</div><!-- .box-preview end -->
							</li> 
								<?php } ?>
						</ul><!-- .slick-slider end -->
						<div class="slick-arrows"></div><!-- .slick-arrows end -->
					</div><!-- .slider-top-destinations end -->
				</div>
				<div class="clearfix"></div>
			</div>	
		</div>	
	</section>
</div>
<div id="section-india-packages" class="section-flat section-popular-packages">
	<section class="section_content recommended_india_tour common_recommend_slider india_holiday">
		<div class="container"> 
			<div class="row">
				<div class="col-md-12"> 
					<div class="section-title cus_sec_title">
						<h2><strong>Best Selling India Holiday Packages</strong></h2>
						<p>Explore Top India Holidays</p>
					</div>
					<div class="slider-popular-packages">
						<ul class="slick-slider">
							<?php 
							
							
							foreach($domesticresponse as $ilist){
								$pprices = 0; 
								$priced  = array();
								
								if(!empty(@$ilist->mypackage)){
									foreach(@$ilist->mypackage as $poplist){
										$priced[] = $poplist->sales_price;
									}
									
									$pprices = @$priced;
								// 	$pprices = @min(@$priced);
							
								}
						?>
							<li>
								<div class="box-preview box-tour-package">
									<div class="box-img img-bg">
										<a href="{{URL::to('/destinations/'.$ilist->slug)}}"><img src="{{URL::to('/public/img/media_gallery')}}/{{@$ilist->desmedia->images}}" alt="{{@$ilist->image_alt}}"></a>
										<div class="overlay">
											<div class="overlay-inner">
											</div><!-- .overlay-inner end -->
										</div><!-- .overlay end -->
										{{-- <span class="night-price">INR {{@$pprices}}*</span> --}}
									</div><!-- .box-img end -->
									<div class="box-content">
										<div class="title">
											<h5><a href="{{URL::to('/destinations/'.$ilist->slug)}}">{{@$ilist->name}}</a></h5>
										</div><!-- .title end -->
									</div><!-- .box-content end -->
								</div><!-- .box-preview end -->
							</li> 
								<?php } ?>
						</ul><!-- .slick-slider end -->
						<div class="slick-arrows"></div><!-- .slick-arrows end -->
					</div><!-- .slider-top-destinations end -->
				</div>
				<div class="clearfix"></div>
			</div>	
		</div>	
	</section>
</div>
<!-- /container -->
<div id="section-services-1" class="section-flat custom_service" style="background: #f5f5f5; margin-top: 0px;"> 
	<div class="section-content">	
		<div class="container">
			<div class="row">
				<div class="col-lg-2 col-md-6">
					<div class="box-info box-service-1 mt-md-50">
						<div class="box-icon">
							<i class="pe-7s-medal"></i>
						</div>
						<div class="box-content">
							<h4>+ 1000 Customers</h4>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-6">
					<div class="box-info box-service-1 mt-md-50">
						<div class="box-icon">
							<i class="pe-7s-help2"></i>
						</div>
						<div class="box-content">
							<h4>H24 Support</h4>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-6">
					<div class="box-info box-service-1 mt-md-50">
						<div class="box-icon">
							<i class="pe-7s-culture"></i>
						</div>
						<div class="box-content">
							<h4>+ 575 Locations</h4>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-6">
					<div class="box-info box-service-1 mt-md-50">
						<div class="box-icon">
							<i class="pe-7s-headphones"></i>
						</div>
						<div class="box-content">
							<h4>Help Direct Line</h4>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-6">
					<div class="box-info box-service-1 mt-md-50">
						<div class="box-icon">
							<i class="pe-7s-credit"></i>
						</div>
						<div class="box-content">
							<h4>Secure Payments</h4>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-6">
					<div class="box-info box-service-1 mt-md-50">
						<div class="box-icon">
							<i class="pe-7s-chat"></i>
						</div>
						<div class="box-content">
							<h4>Support via Chat</h4>
						</div>
					</div>
				</div>
			</div>
			<!--<hr style="border-bottom: 1px solid #ececec;"/> -->
		</div>
	</div>
	<!--/row-->
</div>

<?php if($co !== 0){ ?>
<div class="section-flat section-popular-packages top_deals"> 
	<section class="section_content recommended_india_tour common_recommend_slider">
		<div class="container">
			<div class="section-title cus_sec_title">
				<h2><strong>Top Deals</strong></h2>
			</div>
			<div class="row"> 
				<div id="recommended" class="owl-carousel owl-theme cus_carousel">
					<?php 
					foreach($populartours as $ilist){
						if($ilist->packloc != null){
					?>
					<div class="item">
						<div class="box_grid">
							<figure>
								<a href="#0" class="wish_bt">{{$ilist->no_of_nights}}N/{{$ilist->no_of_days}}D</a>
								<a href="{{URL::to('/destinations/'.$ilist->packloc->slug.'/'.$ilist->slug)}}"><img src="{{URL::to('/public/img/media_gallery')}}/{{@$ilist->media->images}}" class="img-fluid" alt="" width="800" height="533"><div class="read_more"><span>Read more</span></div></a>
								<!--<small>Historic</small>-->
							</figure>
							<div class="wrapper">
								<h3><a href="{{URL::to('/destinations/'.$ilist->packloc->slug.'/'.$ilist->slug)}}">{{$ilist->package_name}}</a></h3>
								<!-- @if(@$ilist->price_on_request == 1)
									<span class="price">Price on Request</span>
								@else
									<span class="price">From <strong><i class="fa fa-inr"></i>  {{$ilist->offer_price}}</strong> /per person</span>
								@endif -->
							</div>
							
						</div>
					</div>
					<?php }
					}?>
				</div>
			</div> 
		</div>
	</section>
</div>
<?php }  ?>

 

<div class="bg_color_1" style="display:none;"> 
	<div class="container padd_80_55">
		<div class="main_title_2"> 
			<h3>Browse packages through holiday THEMES</h3>
		</div>
		<div class="row">
			<div class="col-lg-12">
			<?php
				 $typetour = json_decode($holidaytypetours);
					
				$t = 1;
				if(isset($typetour->data->holidaytype_pack)){
			?>
				<div class="row">
				@foreach(@$typetour->data->holidaytype_pack as $typet)
					<?php if(!empty($typet->holidaytype) && $typet->holidaytype->status == 0){
								
					}else{
					?>
						
                   <div class="col-lg-2 col-md-6">
						<a href="{{URL::to('/themes/'.$typet->slug)}}" class="box_feat">
							<div class="main-cat-icon" style="margin-bottom: 10px;">
							@if(!empty($typet->holidaytype))
								@if(@$typet->holidaytype->image != '')
									<img src="{{@$typetour->data->image_gallery_path}}{{@$typet->holidaytype->image}}">
								@else
									<img src="{{@$typetour->data->image_gallery_path}}{{@$typet->image}}">
								@endif
							 @else
								<img src="{{@$typetour->data->image_gallery_path}}{{@$typet->image}}">
							 @endif
							</div>
							<div class="main-cat-name">
								<h3>{{$typet->name}}</h3>
							</div>
						</a>
					</div>
					<?php } ?>
				 @endforeach 
                </div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
jQuery(document).ready(function($){
	$('.desttab-wrap li a').on('click', function(){
		$('.desttab-wrap li').removeClass('active');
		//$('.desttab-wrap li a').removeClass('active');
		$(this).parent().addClass('active');
	});
});
</script>
<script>
	$(document).ready(function() {  

	});
		
</script>
@endsection