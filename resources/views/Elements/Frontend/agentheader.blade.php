<!-- Header
		============================================= -->
<header id="header">
	<div class="top_strip">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="balance_limit">
						<ul>
							<li>Balance: <i class="fa fa-rupee-sign"></i><span class="newbalnace">{{@Auth::user()->wallet}}</span> <a href="javascript:;" class="balance_refresh"><i class="fa fa-sync-alt"></i></a></li>
							<li>Credit Limit: <i class="fa fa-rupee-sign"></i><span class="newcredit">{{@Auth::user()->credit_limit}}</span> <a href="javascript:;" class="credit_refresh"><i class="fa fa-sync-alt"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="col-md-6">
					<div class="payment_instant">
						<ul>
							<li><a href="{{URL::to('/agent/wallet')}}" class="balance_refresh">Payment Upload</a></li>
							<li><a href="{{URL::to('/agent/wallet')}}" class="balance_refresh">Instant Recharge</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
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
										<a href="javascript:;">care@zapbooking.com</a>
									</li>
								</ul><!-- .list-info end -->
							</div><!-- .position-left end -->
							<div class="position-right">
								<ul class="list-info">
									<li>Customer Care: 011 - 47262626</li>
									<!-- <li><a class="popup-btn-login" href="javascript:;">Login</a></li>
									<li><a class="popup-btn-register" href="javascript:;">Sign Up</a></li>-->
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
							<a class="logo logo-header" href="{{URL::to('/agent/flight/index')}}">
							@if(@Auth::user()->logo != '')
<img src="{{URL::to('/public/img/profile_imgs')}}/{{@Auth::user()->logo}}" data-logo-alt="{{URL::to('/public/img/profile_imgs')}}/{{@Auth::user()->logo}}" alt="">								
												@else
								<img src="{!! asset('public/images/logo-header.png') !!}" data-logo-alt="{!! asset('public/images/logo-header.png') !!}" alt="">
							@endif
								<h3><span class="colored">Holiday Planner</span></h3>
								<span>Travel Booking</span>
							</a><!-- .logo end -->
							<ul id="menu-main" class="menu-main">  
								<li class="{{(Route::currentRouteName() == 'home') ? 'active' : ''}}"><a href="{{URL::to('/agent/flight/index')}}">Flight</a></li> 
								<li class="{{(Route::currentRouteName() == 'holiday.index') ? 'active' : ''}}"><a  href="{{URL::to('/holiday')}}">Holiday</a></li>
								<li class="{{(Route::currentRouteName() == 'hotel.index') ? 'active' : ''}}"><a href="{{URL::to('/hotels')}}">Hotels</a></li>
								<li class="{{(Route::currentRouteName() == 'visa.index') ? 'active' : ''}}"><a href="{{URL::to('/visa')}}">Visa</a></li>
								<li class="{{(Route::currentRouteName() == 'offer.index') ? 'active' : ''}}"><a href="{{URL::to('/offer')}}">Offers</a></li>
								<li class="more_list">
									<a href="javascript:;"><i class="fa fa-plus"></i> More</a>
									<ul class="sub-menu">
										<li><a href="{{URL::to('/flightstatus')}}"><i class="fa fa-caret-right"></i> Flight Status</a></li>
										<li><a href="{{URL::to('/activities')}}"><i class="fa fa-caret-right"></i> Activities</a></li>
										<li><a href="{{URL::to('/trains')}}"><i class="fa fa-caret-right"></i> Trains</a></li>
										<li><a href="{{URL::to('/cruise')}}"><i class="fa fa-caret-right"></i> Cruise</a></li>
										<li><a href="{{URL::to('/transfers')}}"><i class="fa fa-caret-right"></i> Transfers</a></li>
										<li><a href="{{URL::to('/cabs')}}"><i class="fa fa-caret-right"></i> Cabs</a></li>
									</ul> 
								</li> 
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
									<a href="javascript:;">{{Auth::user()->company_name}}</a>
								@else
									<a href="javascript:;">My Account</a>
									@endif
										<ul class="sub-menu">
										@if (Auth::user()) 
											<div class="user_img">
												<img src="{!! asset('public/images/user_img.png') !!}" alt="" /> 
											</div> 
											<div class="sub_link">  
												<li><a href="{{URL::to('/agent/dashboard')}}"><i class="fa fa-caret-right"></i> My Dashboard</a></li>
												<li><a href="{{ route('agent.logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"><i class="fa fa-caret-right"></i> Logout </a></li>
												<form id="frm-logout" action="{{ route('agent.logout') }}" method="POST" style="display: none;">
													{{ csrf_field() }}
												</form>
											</div>
										@else 
											<li class="account_btn"><a class="login popup-btn-login" href="javascript:;">Login</a><a class="popup-btn-register signup" href="javascript:;">Sign Up</a></li>
											<li><a href="{{URL::to('/agent/login')}}"><i class="fa fa-caret-right"></i> Zapbooking for Travel Agents</a></li>
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
									<li>     
										<a href="javascript:;"><i class="fa fa-phone-alt"></i></a> 
										<ul class="sub-menu">
											<li><a href="tel:(+91)-7969224444">(+91)-7969224444</a></li>
										</ul> 
									</li>
								</ul><!-- #menu-main end -->   
							</div>
						</div><!-- .hb-content end -->

					</div><!-- .col-md-12 end -->
				</div><!-- .row end -->
			</div><!-- .container end -->

		</div><!-- .header-bar-wrap -->

	</div><!-- #header-bar-2 end -->

</header><!-- #header end -->
 