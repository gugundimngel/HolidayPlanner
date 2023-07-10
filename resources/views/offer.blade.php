@extends('layouts.frontend')
@section('title', 'offer')
@section('content')

<!-- Content
		============================================= -->
<section id="content">
	<div id="content-wrap">
		<!-- === Section Flat =========== -->
		<div class="section-flat single_sec_flat offer_page" style="background:#e8e8e8;">      
			<div class="section-content">
				<div class="custom_banner offer_banner">
					<div class="container">
						<div class="row">   
							<div class="col-sm-12">
								<div class="banner_txt">
									<div class="title">
										 <h3>Amazing Offers & Great Deals</h3>
									</div>
								</div>
							</div> 
						</div>
					</div>
				</div>
				<div class="container">
					<div class="row"> 
						<div class="inner_offer">	  
							<div class="col-sm-12">	 
								<div class="cus_breadcrumb">
									<ul>
										<li class="active"><a href="#">Home</a></li>
										<li><span><i class="fa fa-angle-right"></i></span></li>
										<li><a href="#">Offer</a></li>
									</ul>
								</div>
							</div>	
							<div class="col-sm-12">	  
								<div class="offer_tabs">
									<div class="inner_common_tabs">
										<ul class="nav nav-tabs custom_tabs">
											<li class="active"><a href="#flights" aria-controls="flights" role="tab" data-toggle="tab"><img src="{!! asset('public/images/icons/flight-tab.png') !!}"/> Flights</a></li>
											<li class=""><a href="#hotels" aria-controls="hotels" role="tab" data-toggle="tab"><img src="{!! asset('public/images/icons/hotel-tab.png') !!}"/> Hotels</a></li>
											<li class=""><a href="#tour_pack" aria-controls="tour_pack" role="tab" data-toggle="tab"><img src="{!! asset('public/images/icons/holiday-tab.png') !!}"/> Tour Package</a></li>
											<li class=""><a href="#bus" aria-controls="bus" role="tab" data-toggle="tab"><img src="{!! asset('public/images/icons/bus-tab.png') !!}"/> Bus</a></li>
											<li class=""><a href="#visa" aria-controls="visa" role="tab" data-toggle="tab"><img src="{!! asset('public/images/icons/visa-tab.png') !!}"/> Visa</a></li>
										</ul>  	
									</div>
									<div class="tab-content">
										<div role="tabpanel" class="tab-pane active" id="flights">
											<div class="row">
												<div class="col-sm-4 col-xs-6 col_xs_480">
													<div class="offer_col">
														<div class="offer_img">
															<img class="item-left-img" src="{!! asset('public/images/1591079418198.jpg') !!}" alt="">
															<div class="offer_type">
																<span class="name"><i class="fa fa-play"></i> Latest</span>
																<span class="date">Validity: 05, Jun 2020</span>
															</div>
														</div>
														<div class="offer_info">
															<div class="offer_name">
																<h4>Advance Booking on your flights</h4>
															</div>
														</div>
														<div class="view_details">
															<a href="javascript:;">View Details</a>
														</div>
													</div>
												</div>
												<div class="col-sm-4 col-xs-6 col_xs_480">
													<div class="offer_col">
														<div class="offer_img">
															<img class="item-left-img" src="{!! asset('public/images/1590721066030.jpg') !!}" alt="">
															<div class="offer_type">
																<span class="name"><i class="fa fa-play"></i> Latest</span>
																<span class="date">Validity: 05, Jun 2020</span>
															</div>
														</div>
														<div class="offer_info">
															<div class="offer_name">
																<h4>Loyalty Program memberships extended</h4>
															</div>
														</div>
														<div class="view_details">
															<a href="javascript:;">View Details</a>
														</div>
													</div>
												</div>
												<div class="col-sm-4 col-xs-6 col_xs_480">
													<div class="offer_col">
														<div class="offer_img">
															<img class="item-left-img" src="{!! asset('public/images/1590136128766.jpg') !!}" alt="">
															<div class="offer_type">
																<span class="name"><i class="fa fa-play"></i> Latest</span>
																<span class="date">Validity: 05, Jun 2020</span>
															</div>
														</div>
														<div class="offer_info">
															<div class="offer_name">
																<h4>Free Cancellation</h4>
															</div>
														</div>
														<div class="view_details">
															<a href="javascript:;">View Details</a>
														</div>
													</div>
												</div>
											</div> 
										</div>
										<div role="tabpanel" class="tab-pane" id="hotels">
										</div>
										<div role="tabpanel" class="tab-pane" id="tour_pack">
										</div>
										<div role="tabpanel" class="tab-pane" id="bus">
										</div>
										<div role="tabpanel" class="tab-pane" id="visa">
										</div>
									</div>
								</div> 
							</div>
						</div>
					</div>	
				</div>	
			</div>	
		</div>	
	</div>	
</section>	

@endsection