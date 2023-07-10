@extends('layouts.agent')
@section('title', 'Agent Dashboard')

@section('content')
<style>
.cus_offer_carousel .offer_item .offer_content {background: #fff;padding: 12px 8px 8px;}
.cus_offer_carousel .offer_item .offer_content {background: #fff;padding: 12px 8px 8px;}
.cus_offer_carousel .offer_item .offer_content .offer_left {display: inline-block;}
.cus_offer_carousel .offer_item .offer_content .offer_right {display: inline-block;float: right;width: calc(100% - 80px);text-align: right;}
.cus_offer_carousel .offer_item .offer_content h5 {font-size: 15px;
line-height: 21px;color: #000;font-weight: normal;display: inline-block;margin: 0px;}
.cus_offer_carousel .offer_item .offer_content h5 span {color: #808080;}
.owl-theme .owl-nav {margin-top: 10px;
}
.cus_offer_carousel.owl-carousel .owl-nav>div {background: #96ba4d;margin: 0px;padding: 6px 12px;color: #fff;}
.cus_offer_carousel.owl-carousel .owl-nav>div>i {font-size: 16px;line-height: 21px;}
.cus_offer_carousel.owl-carousel .owl-nav .owl-next {margin-left:3px;}
.owl-theme .owl-nav [class*=owl-] {font-size: 14px;display: inline-block;border-radius: 3px;}
.owl-nav{text-align: center;}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Dashboard</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Dashboard</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<?php $userlog = \App\LoginLog::where('user_id', Auth::user()->id)->orderby('created_at', 'DESC')->first();			
				?>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<!-- Flash Message Start -->
					<div class="server-error">
						@include('../Elements/flash-message')
					</div>
					<!-- Flash Message End -->
				</div>
			</div>
			<div class="book_service">
				<h3>Book Services</h3>
				<ul>
					<li><a href="{{route('agent.flights')}}" target="_blank"><span class="flight_icon book_icon"></span><span class="book_label">Flights</span></a></li>
					<li><a href="#"><span class="hotel_icon book_icon"></span><span class="book_label">Hotels</span></a></li>
					<li><a href="#"><span class="bus_icon book_icon"></span><span class="book_label">Bus</span></a></li>
					<li><a href="#"><span class="holidays_icon book_icon"></span><span class="book_label">Holidays</span></a></li>
					<li><a href="#"><span class="blog_icon book_icon"></span><span class="book_label">Blog</span></a></li>
				</ul>
			</div>
			<?php
			$agentoffers = \App\AgentOffer::where('status', 1)->orderby('created_at', 'DESC')->paginate(10);
			?>
			<div class="offer_sec">					
				<h3>Deals & offers</h3>
				 <div id="offer_carousel" class="owl-carousel owl-theme agent_offer_carousel cus_offer_carousel">
					<?php 
						$af = 0; 
						foreach($agentoffers as $agentoffer){
					?>
					<div class="item" style="border-radius: 7px;overflow: hidden;border: 1px solid #ddd;">
						<div class="offer_item">
							<?php if(@$agentoffer->image != '') { ?>
							<a href="{{URL::to('/public/img/cmspage')}}/{{@$agentoffer->image}}" data-lightbox="photos"><img src="{{URL::to('/public/img/cmspage')}}/{{@$agentoffer->image}}" alt="{{@$agentoffer->name}}"/></a>
							<?php } else{ ?>
							<a href="{{URL::to('/public/img/cmspage')}}/{{@$agentoffer->image}}" data-lightbox="photos"><img src="{{URL::to('/public/img/cmspage')}}/{{@$agentoffer->image}}" alt="{{@$agentoffer->name}}"/></a>
							<?php } ?>
							<div class="offer_content">
								<div class="offer_left"> 
								{{--<a href="javascript:;" data-url="{{@$agentoffer->image}}" class="whatsapp_msg_model"><i class="fab fa-whatsapp"></i> Share</a>--}} 
								</div>
								<div class="offer_right">
									<h5><span>Visit:</span> <?php if(@$agentoffer->url != '') { ?><a target="_blank" href="{{preg_replace('/^(?!https?:\/\/)/', 'http://', $agentoffer->url)}}">{{@$agentoffer->name}}</a><?php } else{
										echo $agentoffer->name; 
										}?></h5> 
									<?php if(@$agentoffer->price != '') { ?>
									<span>&#8377;{{@$agentoffer->price}}</span>
									<?php
										} else{  } ?>
								</div>
							</div>
						</div> 
					</div> 
					<?php $af++; } ?>  
				</div> 
			</div> 
		</div>
	</section>
</div>
@endsection