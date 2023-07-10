<header id="header">
	<div id="header-bar-1" class="header-bar">
		<div class="header-bar-wrap">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="hb-content">
							<div class="position-left">
								<ul class="list-info">
									<li>
										<ul class="social-icons x4 grey hover-white icon-only">
											<li><a class="si-youtube"><i class="fab fa-youtube"></i><i class="fa fa-youtube"></i></a></li>
											<li><a class="si-twitter" href="javascript:;"><i class="fab fa-twitter"></i><i class="fa fa-twitter"></i></a>
											</li>
											<li><a class="si-facebook" href="javascript:;"><i class="fab fa-facebook-f"></i><i class="fa fa-facebook"></i></a></li>
											<li><a class="si-instagramorange" href="javascript:;"><i class="fab fa-instagram"></i><i class="fa fa-instagram"></i></a></li>
										</ul><!-- .social-icons end -->
									</li>
									<li>
										<a href="mailto:Support@holidaychacha.com">Support@holidaychacha.com</a>
									</li>
								</ul><!-- .list-info end -->
							</div><!-- .position-left end -->
							<div class="position-right">
								<ul class="list-info">
									<li>Customer Care: 011 - 47262626</li>
								</ul><!-- .list-info end -->
							</div><!-- .position-right end -->
						</div><!-- .hb-content end -->
					</div><!-- .col-md-12 end -->
				</div><!-- .row end -->
			</div><!-- .container end -->
		</div><!-- .header-bar-wrap -->
	</div><!-- #header-bar-1 end -->
	<div id="header-bar-2" class="header-bar sticky">
		<div class="header-bar-wrap">
			<div class="container"> 
				<div class="row">
					<div class="col-md-12"> 
						<div class="hb-content">
							<a class="logo logo-header" href="{{URL::to('/')}}">
								<img src="{!! asset('public/images/logo-header.png') !!}" data-logo-alt="{!! asset('public/images/logo-header.png') !!}" alt="">
								<h3><span class="colored">Holiday Planner</span></h3>
								<span>Travel Booking</span>
							</a><!-- .logo end -->
							<ul id="menu-main" class="menu-main nv_top">  
								<li class="{{(Route::currentRouteName() == 'home') ? 'active' : ''}}"><a href="{{URL::to('/')}}"><i class="fa fa-plane"></i>&nbsp;Flight</a></li> 
								<!--<li class="{{(Route::currentRouteName() == 'holiday.index') ? 'active' : ''}}"><a  href="{{URL::to('/holiday')}}">Holiday</a></li>-->
								<li class="{{(Route::currentRouteName() == 'hotel.index') ? 'active' : ''}}"><a href="{{URL::to('/hotels')}}"><i class="fa fa-hotel"></i>&nbsp;Hotels</a></li>

								<li class="{{(Route::currentRouteName() == 'offer.index') ? 'active' : ''}}"><a href="{{URL::to('/visa')}}"><i class="fa fa-globe"></i>&nbsp;Visa </a></li>

								<li class="{{(Route::currentRouteName() == 'offer.index') ? 'active' : ''}}"><a href="{{URL::to('/holiday')}}"><i class="fas fa-glass-martini-alt"></i>&nbsp;Holidays 
								<li class="{{(Route::currentRouteName() == 'offer.index') ? 'active' : ''}}"><a href="{{URL::to('/cab-booking')}}"><i class="fa fa-car"></i>&nbsp;Cabs</a></li>






								<!--<li class="{{(Route::currentRouteName() == 'visa.index') ? 'active' : ''}}"><a href="{{URL::to('/visa')}}">Visa</a></li>-->
								<!-- <li class="{{(Route::currentRouteName() == 'offer.index') ? 'active' : ''}}"><a href="{{URL::to('/offer')}}">Offers</a></li> -->
								<?php /*<li class="more_list">
									<a href="javascript:;"><i class="fa fa-plus"></i> More</a>
									<ul class="sub-menu">
										<li><a href="{{URL::to('/flightstatus')}}"><i class="fa fa-caret-right"></i> Flight Status</a></li>
										<li><a href="{{URL::to('/activities')}}"><i class="fa fa-caret-right"></i> Activities</a></li>
										<li><a href="{{URL::to('/trains')}}"><i class="fa fa-caret-right"></i> Trains</a></li>
										<li><a href="{{URL::to('/cruise')}}"><i class="fa fa-caret-right"></i> Cruise</a></li>
										<li><a href="{{URL::to('/transfers')}}"><i class="fa fa-caret-right"></i> Transfers</a></li>
										<li><a href="{{URL::to('/cabs')}}"><i class="fa fa-caret-right"></i> Cabs</a></li>
									</ul> 
								</li> */ ?> 
							</ul><!-- #menu-main end --> 
							<div class="menu-mobile-btn">
								<div class="hamburger hamburger--slider">
									<span class="hamburger-box">
										<span class="hamburger-inner"></span>
									</span>
								</div>
							</div><!-- .menu-mobile-btn end -->
							<div class="menu_right">
								<ul id="menu-main" class="menu-main">
									<li>
									@if (Auth::user()) 
									<a href="javascript:;">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</a>
								@else
									<a href="javascript:;">My Account</a>
									@endif
										<ul class="sub-menu">
										@if (Auth::user()) 
											<div class="user_img">
												<img src="{!! asset('public/images/user_img.png') !!}" alt="" />
											</div> 
											<div class="sub_link">  
												<li><a href="{{route('dashboard.index')}}"><i class="fa fa-caret-right"></i> My Booking</a></li>
												<li><a href="{{route('hotel.ecash')}}"><i class="fa fa-caret-right"></i> My eCash</a></li>
												<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"><i class="fa fa-caret-right"></i> Logout </a></li>
												<form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
													{{ csrf_field() }}
												</form>
											</div>
										@else 
											<li class="account_btn"><a class="login popup-btn-login" href="javascript:;">Login</a><a class="popup-btn-register signup" href="javascript:;">Sign Up</a></li>
											<li><a href="{{URL::to('/agent/login')}}"><i class="fa fa-caret-right"></i> Holiday Planner for Travel Agents</a></li>
										@endif
										</ul>
									</li>
									<li>
										<a href="javascript:;">Support</a>
										<ul class="sub-menu">
											<li><a href="{{URL::to('/view-print-booking')}}"><i class="fa fa-caret-right"></i> My Booking</a></li>
											<li><a href="{{URL::to('/contact')}}"><i class="fa fa-caret-right"></i> Contact Us</a></li>
											<li><a href="{{URL::to('/faq')}}"><i class="fa fa-caret-right"></i> FAQ</a></li>
											<li><a href="{{URL::to('/sendquery')}}"><i class="fa fa-caret-right"></i> Send Query</a></li>
											<li><a href="{{URL::to('/payonline')}}"><i class="fa fa-caret-right"></i> Make a Payment</a></li>
										</ul>
									</li>
									
									<!-- <li>     
										<a href="javascript:;"><i class="fa fa-phone-alt"></i></a> 
										<ul class="sub-menu">
											<li><a href="tel:+917969224444 ">(+91)-7969224444</a></li>
										</ul> 
									</li> -->
								</ul><!-- #menu-main end -->   
							</div>
						</div><!-- .hb-content end -->
					</div><!-- .col-md-12 end -->
				</div><!-- .row end -->
			</div><!-- .container end -->
		</div><!-- .header-bar-wrap -->
	</div><!-- #header-bar-2 end -->
</header><!-- #header end -->