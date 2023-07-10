<!DOCTYPE html>
<html lang="en-US">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Holiday Planner Flight, Hotel, Holidays, Fix Departure Packages</title>
	<meta name="author" content="Holiday Planner">
	<meta name="keywords" content="Cheap flight booking, Cheap Hotels, Flight booking offers, Budget hotels, luxury Hotels, Online Hotel rooms, International Flight tickets, Domestic Air Tickets ">
	<meta name="description" content="Find the best deals on flight tickets and hotel bookings. Grab the lowest airfares for international and domestic travel and score exclusive offers on hotels. ">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{URL::asset('public/css/Frontend/css-assets.css')}}" rel="stylesheet">
	<link href="{{URL::asset('public/css/Frontend/swiper.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('public/css/Frontend/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('public/css/Frontend/owl.carousel.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('public/css/Frontend/owl.theme.default.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('public/css/Frontend/intlTelInput.css')}}" rel="stylesheet">
	<link href="{{URL::asset('public/css/Frontend/all.css')}}" rel="stylesheet">
	<link href="{{URL::asset('public/css/Frontend/style.css')}}" rel="stylesheet">
	<link href="{{URL::asset('public/css/Frontend/daterangepicker.css')}}" rel="stylesheet">
	<link href="{{URL::asset('public/css/Frontend/custom.css')}}" rel="stylesheet">
	<link href="{{URL::asset('public/css/Frontend/mycustom.css')}}" rel="stylesheet">
	<link href="{{URL::asset('public/css/Frontend/pe-icon-7-stroke.css')}}" rel="stylesheet">
	<link href="{{URL::asset('public/css/Frontend/hotelcss.css')}}" rel="stylesheet">
	<link href="{{URL::asset('public/css/Frontend/responsive.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/black-tie/jquery-ui.css" />
	<link rel="shortcut icon" href="{!! asset('public/images/favicon.png') !!}">
	<script src="{{URL::asset('public/js/Frontend/jquery.js')}}"></script>
	<style>
		.help-block {
			color: #f33;
		}
	</style>
	<style>
		.se-pre-con {
			display: none;
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url(<?php echo URL::to('/public/img'); ?>/Rolling-1s-48px.gif) center no-repeat #fff;
		}

		#myUL li {
			display: none;
		}

		#myULair li {
			display: none;
		}

		#mucoverinc li.insu {
			display: none;
		}

		#mucoverinc {
			display: grid;
			grid-template-columns: repeat(4, 1fr);
		}

		@import url("https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/blitzer/jquery-ui.min.css");

		.ui-datepicker td span,
		.ui-datepicker td a {
			padding-bottom: 1em;
		}

		.ui-datepicker td[title]::after {
			content: attr(title);
			display: block;
			position: relative;
			font-size: .8em;
			height: 1.25em;
			margin-top: -1.25em;
			text-align: right;
			padding-right: .25em;
			color: #fff;
		}

		.ui-datepicker td.ui-state-disabled[title]::after {
			content: '';
			display: none;
			position: unset;
		}
	</style>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-172343415-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'UA-172343415-1');
	</script>

</head>

<body class="@yield('bodyclass')">
	{{-- <div class="top_lanucher">
		<a href="{!! asset('public/images/guidelines-for-air-passengers.pdf') !!}" target="_blank">Covid-19 Travel Advisory</a>
	</div> --}}
	<div class="se-pre-con"></div>
	<div class="searchpop1" style="display: none;">
		<div id="dvWait"></div>
	</div>
	<div id="full-container">
		<!--Header-->
		@include('../Elements/Frontend/header')

		<!--Content-->
		@yield('content')

		<!-- /main -->
		<!--Footer-->
		@include('../Elements/Frontend/footer')

	</div><!-- #full-container end -->

	<a class="scroll-top-icon scroll-top" href="javascript:;"><i class="fa fa-angle-up"></i></a>

	<div class="popup-preview popup-preview-2 popup-preview-register">
		<div class="popup-bg"></div>

		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">

					<div class="popup-content">
						<div class="block-content">
							<div class="popup-close hamburger hamburger--slider is-active">
								<span class="hamburger-box">
									<span class="hamburger-inner"></span>
								</span>
							</div><!-- .popup-close -->
							<div class="block-title">
								<h3>Join Holiday Planner for Free</h3>
								<!--<h5>Access various of online classes in design, business, and more!</h5>-->
							</div><!-- .block-title end -->
							<div class="content">
								<div class="left">
									<form id="form-register" action="{{ route('register') }}" class="rounded">
										<div class="form-content">
											<div class="form-group">
												<label for="registerFullname">Full Name</label>
												<input type="text" name="jaName" id="registerFullname" class="form-control" placeholder="">
												<span style="display:none;" class="help-block name-error">
													<strong></strong>
												</span>
											</div><!-- .form-group end -->
											<div class="form-group">
												<label for="registerEmail">Email Address</label>
												<input type="text" name="registerEmail" id="registerEmail" class="form-control" placeholder="">
												<span style="display:none;" class="help-block email-error">
													<strong></strong>
												</span>
											</div><!-- .form-group end -->
											<div class="form-group">
												<div class="box-field">
													<label for="registerPassword">Password</label>
													<input type="password" name="password" id="registerPassword" class="form-control" placeholder="">
													<span style="display:none;" class="help-block password-error">
														<strong></strong>
													</span>
												</div><!-- .box-field end -->
												<div class="box-field">
													<label for="registerPasswordConfirm">Confirm Password</label>
													<input type="password" name="password_confirmation" id="registerPasswordConfirm" class="form-control" placeholder="">
													<span style="display:none;" class="help-block confirm-password-error">
														<strong></strong>
													</span>
												</div><!-- .box-field end -->
											</div><!-- .form-group end -->
											<div class="form-group">
												<label class="label-container checkbox-default">
													<span>By clicking this, you are agree to to our <a href="{{URL::to('/')}}/page/terms-conditions">terms of use</a> and <a href="{{URL::to('/')}}/page/privacy-security">privacy policy</a> including the use of cookies.</span>
													<input name="cc" id="cc" type="checkbox">
													<span class="checkmark"></span>
												</label>
												<span style="display:none;" class="help-block cc-error">
													<strong></strong>
												</span>
												<input type="submit" id="usersubmit" class="form-control rounded" value="SignUp">
											</div><!-- .form-group end -->
										</div><!-- .form-content end -->
									</form><!-- #form-register end -->
								</div><!-- .left end -->
								<div class="right">
									<h5>Or Sign up With Your Socials</h5>
									<ul class="list-btns-social rounded">
										<li>
											<a class="btn-social bs-google-plus" href="{{URL::to('/auth/google')}}">
												<i class="fab fa-google-plus-g"></i>
												<span>google</span>
											</a>
										</li>
										<li>
											<a class="btn-social bs-facebook" href="{{URL::to('/auth/facebook')}}">
												<i class="fab fa-facebook-square"></i>
												<span>facebook</span>
											</a>
										</li>
										<!--<li>
											<a class="btn-social bs-twitter" href="javascript:;">
												<i class="fab fa-twitter"></i>
												<span>twitter</span>
											</a>
										</li>-->
									</ul><!-- .list-btns-social end -->
								</div><!-- .right end -->
							</div><!-- .content end -->
						</div><!-- .block-content end -->
					</div><!-- .popup-content end -->

				</div><!-- .col-md-8 end -->
			</div><!-- .row end -->
		</div><!-- .container end -->
	</div><!-- .popup-preview -->

	<div class="popup-preview popup-preview-2 popup-preview-login ">
		<div class="popup-bg"></div>

		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="popup-content">
						<div class="block-content">
							<div class="block-title">
								<h3>Welcome Back to Holiday Planner</h3>
								<h5>Sign in to your account to continue using Holiday Planner</h5>
							</div><!-- .block-title end -->
							<div class="content">
								<div class="left">

									{{ Form::open(array('url' => '/login', 'name'=>"login", 'autocomplete'=>'off', 'class'=>'rounded', 'id' => 'form-login')) }}
									<div class="form-content">
										<div class="form-group">
											<label for="loginUserEmail">Email Adress / Username</label>
											<input autocomplete="new-password" type="text" name="email" id="loginUserEmail" class="form-control" placeholder="">
											@if ($errors->has('email'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('email') }}</strong>
											</span>
											@endif
										</div><!-- .form-group end -->
										<div class="form-group">
											<label for="loginPassword">Password</label>
											<input autocomplete="new-password" type="password" name="password" id="loginPassword" class="form-control" placeholder="">
											@if ($errors->has('password'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('password') }}</strong>
											</span>
											@endif
										</div><!-- .form-group end -->
										<div class="form-group">

											{{ Form::button('Sign in!', ['class'=>'form-control rounded', 'onClick'=>'customValidate("login")']) }}
											<label class="label-container checkbox-default">
												<span>Remember Me</span>
												<input name="remember" id="remember" type="checkbox">
												<span class="checkmark"></span>
											</label>
											<a href="javascript:;" class="popup-btn-forgotpass">Forgot Password?</a>
										</div><!-- .form-group end -->
									</div><!-- .form-content end -->
									</form><!-- #form-login end -->
								</div><!-- .left end -->
								<div class="right">
									<h5>Or Sign up With Your Socials</h5>
									<ul class="list-btns-social rounded">
										<li>
											<a class="btn-social bs-google-plus" href="{{URL::to('/auth/google')}}">
												<i class="fab fa-google-plus-g"></i>
												<span>google</span>
											</a>
										</li>
										<li>
											<a class="btn-social bs-facebook" href="{{URL::to('/auth/facebook')}}">
												<i class="fab fa-facebook-square"></i>
												<span>facebook</span>
											</a>
										</li>
										<!--<li>
											<a class="btn-social bs-twitter" href="javascript:;">
												<i class="fab fa-twitter"></i>
												<span>twitter</span>
											</a>
										</li>-->
									</ul><!-- .list-btns-social end -->
								</div><!-- .right end -->
								<div class="foot-msg">
									<span class="msg">Not a member yet? <a href="javascript:;" class="popup-btn-register">Sign up</a> for free</span>
									<div class="popup-close hamburger hamburger--slider is-active">
										<span class="hamburger-box">
											<span class="hamburger-inner"></span>
										</span>
									</div><!-- .popup-close -->
								</div><!-- .foot-msg end -->
							</div><!-- .content end -->
						</div><!-- .block-content end -->
					</div><!-- .popup-content end -->

				</div><!-- .col-md-8 end -->
			</div><!-- .row end -->
		</div><!-- .container end -->
	</div><!-- .popup-preview -->

	<div class="popup-preview popup-preview-2 popup-preview-forgotpass">
		<div class="popup-bg"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="popup-content">
						<div class="block-content">
							<div class="popup-close hamburger hamburger--slider is-active">
								<span class="hamburger-box">
									<span class="hamburger-inner"></span>
								</span>
							</div><!-- .popup-close -->
							<div class="block-title">
								<h3>Welcome Back to Holiday Planner</h3>
								<h5>Forgot Password to your account to continue using Holiday Planner</h5>
							</div><!-- .block-title end -->
							<div class="content">
								<div class="left">
									<span style="display:none;" class="help-block forgot-error">
										<strong></strong>
									</span>
									{{ Form::open(array('url' => '/forgot_password', 'name'=>"forgot", 'autocomplete'=>'off', 'class'=>'rounded', 'id' => 'form-forgot')) }}
									<div class="form-content">
										<div class="form-group">
											<label for="loginUserEmail">Email Adress / Username</label>
											<input data-valid="required" autocomplete="new-password" type="text" name="email" id="floginUserEmail" class="form-control" placeholder="">

											<span style="display:none;" class="help-block femail-error">
												<strong></strong>
											</span>
										</div><!-- .form-group end -->
										<div class="form-group">
											{{ Form::button('Forgot Password', ['class'=>'form-control rounded', 'id'=>'userforgot']) }}
										</div><!-- .form-group end -->
									</div><!-- .form-content end -->
									</form><!-- #form-login end -->
								</div><!-- .left end -->
								<div class="right">
									<h5>Or Sign up With Your Socials</h5>
									<ul class="list-btns-social rounded">
										<li>
											<a class="btn-social bs-google-plus" href="{{URL::to('/auth/google')}}">
												<i class="fab fa-google-plus-g"></i>
												<span>google</span>
											</a>
										</li>
										<li>
											<a class="btn-social bs-facebook" href="{{URL::to('/auth/facebook')}}">
												<i class="fab fa-facebook-square"></i>
												<span>facebook</span>
											</a>
										</li>
										<!--<li>
											<a class="btn-social bs-twitter" href="javascript:;">
												<i class="fab fa-twitter"></i>
												<span>twitter</span>
											</a>
										</li>-->
									</ul><!-- .list-btns-social end -->
								</div><!-- .right end -->
							</div><!-- .content end -->
						</div><!-- .block-content end -->
					</div><!-- .popup-content end -->

				</div><!-- .col-md-8 end -->
			</div><!-- .row end -->
		</div><!-- .container end -->
	</div><!-- .popup-preview -->

	<div class="popup-preview popup-preview-2 popup-language-choice">
		<div class="popup-bg"></div>

		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">

					<div class="popup-content">
						<div class="block-content">
							<div class="content">
								<h5>Choose Language</h5>
								<form class="form-language-choice form-inline style-2">
									<div class="form-group">
										<div class="list-select-options">
											<input type="text" id="select-language" readonly>
											<input type="hidden" id="select-language_code">
											<i class="fa fa-sort"></i>
										</div><!-- .list-select-options end -->
									</div><!-- .form-group end -->
									<div class="form-group">
										<div class="list-select-options">
											<select class="options-select2">
												<option selected>Egyptian Pound (EGP)</option>
												<option>Saudi Real (SAR)</option>
											</select>
											<i class="fa fa-sort"></i>
										</div><!-- .list-select-options end -->
									</div><!-- .form-group end -->
									<div class="form-group">
										<button type="submit" class="form-control">Save</button>
									</div><!-- .form-group end -->
								</form><!-- .form-language-choice end -->
								<div class="popup-close hamburger hamburger--slider is-active">
									<span class="hamburger-box">
										<span class="hamburger-inner"></span>
									</span>
								</div><!-- .popup-close -->
							</div><!-- .content end -->
						</div><!-- .block-content end -->
					</div><!-- .popup-content end -->

				</div><!-- .col-md-8 end -->
			</div><!-- .row end -->
		</div><!-- .container end -->
	</div><!-- .popup-preview -->

	<!-- COMMON SCRIPTS -->
	<script type="text/javascript">
		var site_url = "<?php echo URL::to('/'); ?>";
		var redirecturl = "<?php echo URL::to('/thanks'); ?>";
	</script>

	<!-- External JavaScripts
		============================================= -->

	<script src="{{URL::asset('public/js/Frontend/bootstrap.min.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/moment.min.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/jRespond.min.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/jquery.fitvids.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/superfish.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/slick.min.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/jquery.magnific-popup.min.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/scrollIt.min.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/isotope.pkgd.min.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/jquery-ui.min.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/select2.min.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/countrySelect.min.js')}}"></script>

	<script src="{{URL::asset('public/js/Frontend/functions.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/intlTelInput.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/ResizeSensor.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/theia-sticky-sidebar.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/daterangepicker.min.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/stickynav.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/readmore_fade.js')}}"></script>

	<script>
		function myFunction(val) {
			if (val == 1) {
				var dots = document.getElementById("dots");
				var moreText = document.getElementById("more");
				var btnText = document.getElementById("myBtn");
			} else if (val == 2) {
				var dots = document.getElementById("dots1");
				var moreText = document.getElementById("more1");
				var btnText = document.getElementById("myBtn1");
			} else if (val == 3) {
				var dots = document.getElementById("dots2");
				var moreText = document.getElementById("more2");
				var btnText = document.getElementById("myBtn2");
			}


			if (dots.style.display === "none") {
				dots.style.display = "inline";
				btnText.innerHTML = "<i class='fa fa-plus'></i> Read more";
				moreText.style.display = "none";
			} else {
				dots.style.display = "none";
				btnText.innerHTML = "<i class='fa fa-minus'></i> Read less";
				moreText.style.display = "inline";
			}
		}
	</script>
	<script>
		$('article.cust_article').readmore();

		function myFunction(val) {
			if (val == 1) {
				var dots = document.getElementById("dots");
				var moreText = document.getElementById("more");
				var btnText = document.getElementById("myBtn");
			} else if (val == 2) {
				var dots = document.getElementById("dots1");
				var moreText = document.getElementById("more1");
				var btnText = document.getElementById("myBtn1");
			} else if (val == 3) {
				var dots = document.getElementById("dots2");
				var moreText = document.getElementById("more2");
				var btnText = document.getElementById("myBtn2");
			}


			if (dots.style.display === "none") {
				dots.style.display = "inline";
				btnText.innerHTML = "<i class='fa fa-plus'></i> Read more";
				moreText.style.display = "none";
			} else {
				dots.style.display = "none";
				btnText.innerHTML = "<i class='fa fa-minus'></i> Read less";
				moreText.style.display = "inline";
			}
		}
	</script>
	<script>
		var airlineurl = '{{URL::to(' / public / img / airline / ')}}';
		var bookurl = '{{URL::to(' / Review / Checkout ')}}';
	</script>
	@if(isset($_GET['jt']) && $_GET['jt'] == 2)
	<script>
		$(document).ready(function() {
			$("input[type=radio][name='inbound']:checked").trigger('click');
			$("input[type=radio][name='outbound']:checked").trigger('click');

		});
	</script>
	<script src="{{URL::asset('public/js/Frontend/RoundTripFilter.js')}}"></script>
	@else
	<script src="{{URL::asset('public/js/Frontend/OneWayFilter.js')}}"></script>
	@endif

	<script src="{{URL::asset('public/js/Frontend/owl.carousel.js')}}"></script>
	<script src="{{URL::asset('public/js/custom-form-validation.js')}}"></script>
	<script src="{{URL::asset('public/js/Frontend/swiper.min.js')}}"></script>



	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
	<script>
		var swiper = new Swiper('.swiper-container', {
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
		});
	</script>

	<script>
		function SwapDestination() {
			var source = $('.loc_search_field_one input[name="onewayfromtext"]').val();
			var Destination = $('.loc_search_field_one_to input[name="onewaytotext"]').val();
			$('.loc_search_field_one input[name="onewayfromtext"]').val(Destination);
			$('.loc_search_field_one_to input[name="onewaytotext"]').val(source);
		}

		function SwapRoundDestination() {
			var source = $('.loc_search_field input[name="roundwayfrmtext"]').val();
			var Destination = $('.loc_search_field_to input[name="roundwaytotext"]').val();
			$('.loc_search_field input[name="roundwayfrmtext"]').val(Destination);
			$('.loc_search_field_to input[name="roundwaytotext"]').val(source);
		}
		$(document).ready(function() {
			$(document).tooltip();
			size_li = $("#myUL .coupon_li").length;
			x = 2;
			$('#myUL .coupon_li:lt(' + x + ')').show();
			$('#loadMore a').click(function() {
				x = (x + 5 <= size_li) ? x + 5 : size_li;
				$('#myUL .coupon_li:lt(' + x + ')').show();
				if (x == size_li) {
					$('#loadMore').hide();
				}
			});

			size_lis = $("#myUL li").length;
			xs = 10;
			if (size_lis > 10) {
				$('#craftloadMore').show();
			} else {
				$('#craftloadMore').hide();
			}
			$('#myUL li:lt(' + xs + ')').show();
			$('#craftloadMore').click(function() {
				xs = (xs + 5 <= size_lis) ? xs + 5 : size_lis;
				$('#myUL li:lt(' + xs + ')').show();
				if (xs == size_lis) {
					$('#craftloadMore').hide();
				}
			});

			size_liss = $("#myULair li").length;
			xss = 10;
			if (size_liss > 10) {
				$('#airloadMore').show();
			} else {
				$('#airloadMore').hide();
			}
			$('#myULair li:lt(' + xss + ')').show();
			$('#airloadMore').click(function() {
				xss = (xss + 5 <= size_liss) ? xss + 5 : size_liss;
				//alert(xss);
				$('#myULair li:lt(' + xss + ')').show();
				if (xss == size_liss) {
					$('#airloadMore').hide();
				}
			});
			$(document).delegate('.roundtripenable', "focus", function() {

				$(".br-tabs li").removeClass('active');
				$('.if_oneway_trip').prop("readonly", false);
				$('.if_oneway_trip').parent().css('opacity', '1');
				$('.roundtriptab').addClass("active");
				$('#journey_type').val(2);
			});
			$(".br-tabs li").on("click", function() {

				$(".br-tabs li").removeClass('active');
				$(this).addClass("active");
				var val = $(this).attr('dataway');
				if (val == 'roundtrip') {
					$('.if_oneway_trip').prop("readonly", false);
					$('.if_oneway_trip').parent().css('opacity', '1');
					$('.if_multicity_trip').hide();
					$('.ismultipleway').removeClass('multiple-destinations');
					$('#journey_type').val(2);
				} else if (val == 'multicity') {
					$('.if_oneway_trip').prop("readonly", true);
					$('.if_oneway_trip').parent().css('opacity', '0.4');
					$('.if_multicity_trip').show();
					$('.ismultipleway').addClass('multiple-destinations');
					$('#journey_type').val(3);
				} else {
					$('.if_oneway_trip').prop("readonly", true);
					$('.if_oneway_trip').parent().css('opacity', '0.4');
					$('.if_multicity_trip').hide();
					$('.ismultipleway').removeClass('multiple-destinations');
					$('#journey_type').val(1);
				}
			});
			var typingTimer; //timer identifier
			var doneTypingInterval = 5000;
			var minlength = 3;
			$('.loc_search_field_one input[name="onewayfromtext"]').on("keyup", function() {
				if (typingTimer) clearTimeout(typingTimer);

				var inputVal = $(this).val();
				if (inputVal.length >= minlength) {
					typingTimer = setTimeout(doneTyping(inputVal, 'if_search_val'), doneTypingInterval);

				}
			});

			$('.loc_search_field_one input[name="onewayfromtext"]').on("keyup", function() {
				clearTimeout(typingTimer);
			});

			var typingTimerto; //timer identifier
			var doneTypingIntervalto = 5000;
			$('.loc_search_field_one_to input[name="onewaytotext"]').on("keyup", function() {
				if (typingTimerto) clearTimeout(typingTimerto);

				var inputVal = $(this).val();
				if (inputVal.length >= minlength) {
					typingTimerto = setTimeout(doneTyping(inputVal, 'is_search_val_to'), doneTypingIntervalto);
				}
			});

			$('.loc_search_field_one_to input[name="onewaytotext"]').on("keyup", function() {
				clearTimeout(typingTimerto);
			});


			var typingTimerroundfrom; //timer identifier
			var doneTypingIntervalroundfrom = 5000;
			$('.loc_search_field input[name="roundwayfrmtext"]').on("keyup", function() {
				if (typingTimerroundfrom) clearTimeout(typingTimerroundfrom);

				var inputVal = $(this).val();
				if (inputVal.length >= minlength) {
					typingTimerroundfrom = setTimeout(doneTyping(inputVal, 'is_search_from_val'), doneTypingIntervalto);
				}
			});

			$('.loc_search_field input[name="roundwayfrmtext"]').on("keyup", function() {
				clearTimeout(typingTimerroundfrom);
			});


			var typingTimerroundto; //timer identifier
			var doneTypingIntervalroundto = 5000;
			$('.loc_search_field_to input[name="roundwaytotext"]').on("keyup", function() {
				if (typingTimerroundto) clearTimeout(typingTimerroundto);

				var inputVal = $(this).val();
				if (inputVal.length >= minlength) {
					typingTimerroundto = setTimeout(doneTyping(inputVal, 'is_search_to_val'), doneTypingIntervalroundto);
				}
			});

			$('.loc_search_field_to input[name="roundwaytotext"]').on("keyup", function() {
				clearTimeout(typingTimerroundto);
			});

			$(document).delegate('.farerule', 'click', function() {
				var rsindex = $(this).attr('resindex');
				var val = $('#first' + $(this).attr('resindex')).val();
				if (val == 0) {
					$.ajax({
						url: "{{URL::to('/Flight/farerules/')}}",
						method: 'GET',
						data: {
							resindex: rsindex,
							traceid: $(this).attr('traceid')
						},
						success: function(data) {
							$('.showtob' + rsindex).html(data);
							$('#first' + rsindex).val(1);
						}
					});
				}
			});


			function doneTyping(inputVal, classname) {

				$.ajax({
					url: "{{URL::to('/Flight/cities/')}}",
					method: 'GET',
					data: {
						textval: inputVal,
						type: classname
					},
					dataType: 'json',
					success: function(data) {
						$('.' + classname).html(data.table_data);

					}
				});
			}
			$(document).on("submit", "#searchform", function(e) {
				e.preventDefault();
				var val = $('.search-query').val();
				if (val != '') {
					window.location = '{{URL::to(' / destinations / ')}}/' + val;
				}
				return false;
			});

			$(".myqueryli").on("click", function() {
				var dataid = $(this).attr("datapacid");

				$("#mpackage_id").val(dataid);
				$('input[name="traveldate"]').daterangepicker({
					singleDatePicker: true,

					locale: {
						cancelLabel: 'Clear'
					}
				});
			});
			$(".hotelcontent").on("click", function() {
				var dataid = $(this).attr("datid");

				$("#hotelcontent h4").html(gallerydata[dataid]['hotelname']);
				$("#hotelcontent .hotel_description").html(gallerydata[dataid]['description']);
				var datatml = '';
				for (var ik = 0; ik < gallerydata[dataid]['star']; ik++) {
					datatml += ('<img src="{!! asset('
						public / img / star.png ') !!}" alt="Star Rating" title="Star Rating">');
				}
				$("#hotelcontent .starmargin").html(datatml);
				$("#hotelcontent .loclity").html('<span class="textblack13bold ng-scope">Locality: ' + gallerydata[dataid]['address'] + '</span>');
				$("#hotelcontent").modal("show");
			});
		});
	</script>
	<script>
		$(document).ready(function() {
			$('#registerFullname').on('keyup', function() {
				$('#registerFullname').removeClass('error');
				$('.name-error').hide();
				$('.name-error').html('');
			});

			$('#registerEmail').on('keyup', function() {
				$('#registerEmail').removeClass('error');
				$('.email-error').hide();
				$('.email-error').html('');
			});
			$('#registerPassword').on('keyup', function() {
				$('#registerPassword').removeClass('error');
				$('.password-error').hide();
				$('.password-error').html('');
			});
			$('#registerPasswordConfirm').on('keyup', function() {
				$('#registerPasswordConfirm').removeClass('error');
				$('.confirm-password-error').hide();
				$('.confirm-password-error').html('');
			});

			$("#userforgot").on("click", function(e) {
				e.preventDefault();
				var formElem = $("#form-forgot");
				var formData = new FormData(formElem[0]);
				$("#form-forgot :input").prop("disabled", true);
				$.ajax({
					url: "{{ route('forgot_password') }}",
					dataType: 'json',
					type: 'POST',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					processData: false,
					contentType: false,
					data: formData,
					success: function(data) {
						$("#form-forgot :input").prop("disabled", false);
						$('#floginUserEmail').val('');
						$('.loading').hide();
						//var obj = $.parseJSON(data);
						if (data.success) {
							$('.forgot-error').show();
							$('.forgot-error').html('<p class="alert alert-success">' + data.message + '</p>');
						} else {
							$('.forgot-error').show();
							$('.forgot-error').html('<p class="alert alert-danger">' + data.message + '</p>');
						}
					},
					error: function(jqXhr, textStatus, errorThrown) {
						$("#form-forgot :input").prop("disabled", false);
						if (jqXhr.status === 422) {
							var errors = jqXhr.responseJSON;
							console.log(errors);

							if (typeof errors.errors['email'] != "undefined") {
								$('.femail-error').show();
								$('.femail-error').html(errors.errors['email']);
								$('#floginUserEmail').addClass('error');
							}


						}
					}
				});
			});
			$("#usersubmit").on("click", function(e) {
				e.preventDefault();

				var formElem = $("#form-register");
				console.log(formElem[0]);
				var formData = new FormData(formElem[0]);
				$("#form-register :input").prop("disabled", true);
				$.ajax({
					url: "{{ route('user.register') }}",
					dataType: 'json',
					type: 'POST',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					processData: false,
					contentType: false,
					data: formData,
					success: function(data) {
						$('.loading').hide();
						//var obj = $.parseJSON(data);
						if (data.success) {
							window.location.href = "{{url('/user')}}";
						} else {
							alert();
						}
					},
					error: function(jqXhr, textStatus, errorThrown) {
						$("#form-register :input").prop("disabled", false);
						if (jqXhr.status === 422) {
							var errors = jqXhr.responseJSON;
							console.log(errors);
							if (typeof errors.errors['jaName'] != "undefined") {
								$('.name-error').show();
								$('.name-error').html(errors.errors['jaName']);
								$('#registerFullname').addClass('error');
							}
							if (typeof errors.errors['registerEmail'] != "undefined") {
								$('.email-error').show();
								$('.email-error').html(errors.errors['registerEmail']);
								$('#registerEmail').addClass('error');
							}
							if (typeof errors.errors['password'] != "undefined") {
								$('.password-error').show();
								$('.password-error').html(errors.errors['password']);
								$('#registerPassword').addClass('error');
							}

							if (typeof errors.errors['cc'] != "undefined") {
								$('.cc-error').show();
								$('.cc-error').html(errors.errors['cc']);
								$('#cc').addClass('error');
							}
							if (typeof errors.errors['password_confirmation'] != "undefined") {
								$('.confirm-password-error').show();
								$('.confirm-password-error').html(errors.errors['password_confirmation']);
								$('#registerPasswordConfirm').addClass('error');
							}

						}
					}
				});
			});

			$("#reccomended").owlCarousel({
				loop: true,
				margin: 10,
				nav: true,
				dots: false,
				responsive: {
					0: {
						items: 2
					},
					600: {
						items: 3
					},
					1000: {
						items: 3
					}
				}
			});
			var owl = $('.owl-carousel');
			owl.owlCarousel({
				margin: 10,
				nav: true,
				dots: false,
				loop: false,
				responsive: {
					0: {
						items: 3
					},
					600: {
						items: 5
					},
					1000: {
						items: 7
					}
				}
			});

			$(document).delegate('.flight_details a.details_btn', "click", function() {
				var val = $(this).attr('dataid');
				$('.flight_details_info').removeClass('show');
				$('#show_' + val).addClass('show');
			});
			$(document).delegate('.flight_details_close a', "click", function() {

				$('.flight_details_info').removeClass('show');
			});

			$(document).delegate('.flight_details a.seconddetails_btn', "click", function() {
				var val = $(this).attr('dataid');
				$('.secflight_details_info').removeClass('show');
				$('#depshow_' + val).addClass('show');
			});
			$(document).delegate('.secflight_details_close a', "click", function() {

				$('.secflight_details_info').removeClass('show');
			});
			$(document).delegate('.advanced_option a', "click", function() {

				$('.advanced_option .list_grade').toggleClass('show');
			});

			var sel = $('.wrapper-dropdown-2'),
				txtround = $('.roundwayfrom'),
				options = $('.location_search');

			sel.click(function(e) {
				e.stopPropagation();
				$('.location_search_to').hide();
				options.show();
			});

			$('body').click(function(e) {
				options.hide();
			});

			$(document).delegate('.is_search_from_val li', 'click', function(e) {
				e.stopPropagation();
				txtround.val($(this).attr('roundwayfrom'));
				$('#roundfromsearch').val($(this).attr('roundwayfromtop'));
				$(this).addClass('selected').siblings('li').removeClass('selected');
				options.hide();
				txtround.blur();
			});


			var sel_to = $('.wrapper-dropdown-3'),
				txtround1 = $('.roundwayto'),
				to_options = $('.location_search_to');

			sel_to.click(function(e) {
				e.stopPropagation();
				$('.location_search').hide();
				to_options.show();
			});

			$('body').click(function(e) {
				to_options.hide();
			});

			$(document).delegate('.is_search_to_val li', 'click', function(e) {
				e.stopPropagation();
				txtround1.val($(this).attr('roundwayto'));
				$('#roundtosearch').val($(this).attr('roundwaytotop'));
				$(this).addClass('selected').siblings('div').removeClass('selected');
				to_options.hide();
				txtround1.blur();
			});

			var sel_from = $('.wrapper-dropdown-4'),
				txt1 = $('.onewayfrom'),
				from_options = $('.one_location_search_from');

			sel_from.click(function(e) {
				e.stopPropagation();
				$('.one_location_search_to').hide();

				from_options.show();
			});

			$('body').click(function(e) {
				from_options.hide();

			});

			$(document).delegate('.if_search_val li', 'click', function(e) {

				e.stopPropagation();
				txt1.val($(this).attr('onewayfrom'));
				$('#onewayfromsearch').val($(this).attr('onewayfromtop'));
				$(this).addClass('selected').siblings('li').removeClass('selected');
				from_options.hide();
				txt1.blur();
			});

			var sel_to_one = $('.wrapper-dropdown-5'),
				txt2 = $('.onewayto'),
				to_one_options = $('.one_location_search_to');

			sel_to_one.click(function(e) {
				e.stopPropagation();
				$('.one_location_search_from').hide();
				to_one_options.show();
			});

			$('body').click(function(e) {
				to_one_options.hide();
			});

			$('.book_btn a, .change_flight').on('click', function() {
				// Animate loader off screen
				$(".se-pre-con").show();
			});

			$(document).delegate('.is_search_val_to li', 'click', function(e) {
				e.stopPropagation();
				txt2.val($(this).attr('onewayto'));
				$('#onewaytosearch').val($(this).attr('onewaytotop'));
				$(this).addClass('selected').siblings('li').removeClass('selected');
				to_one_options.hide();
				txt2.blur();
			});
			$('.onewayformsearch').on('click', function() {
				var val1 = $('#onewayfromsearch').val();
				var val2 = $('#onewaytosearch').val();
				var onewaystartdate = $('#onewaystartdate').val();
				var onewayadult = $('#onewayadult').val();
				var onewaychild = $('#onewaychild').val();
				var onewayinfants = $('#onewayinfants').val();
				var journey_type = 1;
				var seatclass = $('.roundseatclass:checked').val();
				var is_non_stop = $('.is_non_stop:checked').val();
				var flag = true;
				if (val1 == '') {
					flag = false;
					alert("Source cannot be blank");
				} else if (val2 == '') {
					flag = false;
					alert("Destination cannot be blank");
				} else if (onewaystartdate == '') {
					flag = false;
					alert("Departure date cannot be blank");
				} else if (val1 == val2) {
					flag = false;
					alert("Source and destination cannot be same");
				}
				if (flag) {
					window.location.href = "{{URL::to('/FlightList/index')}}?srch=" + val1 + "|" + val2 + "|" + onewaystartdate + "&px=" + onewayadult + "-" + onewaychild + "-" + onewayinfants + "&cbn=" + seatclass + "&nt=" + is_non_stop + "&jt=" + journey_type;
				}
			});

			$('.roundformsearch').on('click', function() {
				var val1 = $('#roundfromsearch').val();
				var val2 = $('#roundtosearch').val();

				var onewaystartdate = $('#datepicker-time-start').val();
				var onewayenddate = $('#datepicker-time-end').val();
				var onewayadult = $('#roundadult').val();
				var onewaychild = $('#roundchild').val();
				var onewayinfants = $('#roundinfant').val();
				var journey_type = $('#journey_type').val();
				var seatclass = $('.roundseatclass:checked').val();
				var is_non_stop = $('#roundis_non_stop:checked').val();
				var flag = true;
				if (val1 == '') {
					flag = false;
					alert("Source cannot be blank");
				} else if (onewaystartdate == '') {
					flag = false;
					alert("Departure Date cannot be blank");
				} else if (onewayenddate == '' && journey_type == 2) {
					flag = false;
					alert("Arrival Date cannot be blank");
				} else if (val2 == '') {
					flag = false;
					alert("Destination cannot be blank");
				} else if (val1 == val2) {
					flag = false;
					alert("Source and destination cannot be same");
				}

				$("#hfFromDestination").val(val1);
				$("#hfToDestination").val(val2);
				$("#hfTripType").val(journey_type);

				var arrD = onewaystartdate.split("/");

				$("#hfFromDate").val(arrD[2] + "/" + arrD[1] + "/" + arrD[0]);

				if (seatclass == 2) {
					$("#select_class").val("Economy");
				} else if (seatclass == 3) {
					$("#select_class").val("Premium Economy");
				} else if (seatclass == 4) {
					$("#select_class").val("Business");
				} else if (seatclass == 6) {
					$("#select_class").val("First Class");
				}
				if (journey_type == 2) {
					var arrR = onewayenddate.split("/");
					$("#hfToDate").val(arrR[2] + "/" + arrR[1] + "/" + arrR[0]);
				}
				$("#hfAdult").val(onewayadult);
				$("#hfChild").val(onewaychild);
				$("#hfInfant").val(onewayinfants);
				if (flag) {
					if (journey_type == 2) {
						$("#dvWait").html(WaitSearch());

						$('.searchpop1').show();
						window.location.href = "{{URL::to('/FlightList/index')}}?srch=" + val1 + "|" + val2 + "|" + onewaystartdate + "|" + onewayenddate + "&px=" + onewayadult + "-" + onewaychild + "-" + onewayinfants + "&cbn=" + seatclass + "&nt=" + is_non_stop + "&jt=" + journey_type;
					} else {


						$("#dvWait").html(WaitSearch());

						$('.searchpop1').show();
						window.location.href = "{{URL::to('/FlightList/index')}}?srch=" + val1 + "|" + val2 + "|" + onewaystartdate + "&px=" + onewayadult + "-" + onewaychild + "-" + onewayinfants + "&cbn=" + seatclass + "&nt=" + is_non_stop + "&jt=" + journey_type;
					}

				}
			});

			$('.bydatesearchdata').on('click', function() {
				var val1 = $(this).attr('fromdestination');
				var val2 = $(this).attr('todestination');

				var onewaystartdate = $(this).attr('fromdate');
				var onewayenddate = '';
				var onewayadult = $(this).attr('hfadult');
				var onewaychild = $(this).attr('hfChild');
				var onewayinfants = $(this).attr('hfInfant');
				var journey_type = $(this).attr('journytype');
				var is_non_stop = $(this).attr('nonstop');
				var seatclass = $(this).attr('seatclass');

				var flag = true;
				if (val1 == '') {
					flag = false;
					alert("Source cannot be blank");
				} else if (onewaystartdate == '') {
					flag = false;
					alert("Departure Date cannot be blank");
				} else if (onewayenddate == '' && journey_type == 2) {
					flag = false;
					alert("Arrival Date cannot be blank");
				} else if (val2 == '') {
					flag = false;
					alert("Destination cannot be blank");
				} else if (val1 == val2) {
					flag = false;
					alert("Source and destination cannot be same");
				}

				$("#hfFromDestination").val(val1);
				$("#hfToDestination").val(val2);
				$("#hfTripType").val(journey_type);

				var arrD = onewaystartdate.split("/");

				$("#hfFromDate").val(arrD[2] + "/" + arrD[1] + "/" + arrD[0]);

				if (seatclass == 2) {
					$("#select_class").val("Economy");
				} else if (seatclass == 3) {
					$("#select_class").val("Premium Economy");
				} else if (seatclass == 4) {
					$("#select_class").val("Business");
				} else if (seatclass == 6) {
					$("#select_class").val("First Class");
				}
				if (journey_type == 2) {
					var arrR = onewayenddate.split("/");
					$("#hfToDate").val(arrR[2] + "/" + arrR[1] + "/" + arrR[0]);
				}
				$("#hfAdult").val(onewayadult);
				$("#hfChild").val(onewaychild);
				$("#hfInfant").val(onewayinfants);
				if (flag) {
					if (journey_type == 2) {
						$("#dvWait").html(WaitSearch());

						$('.searchpop1').show();

					} else {


						$("#dvWait").html(WaitSearch());

						$('.searchpop1').show();

					}

				}
			});
		});

		function WaitSearch() {

			var contact = $("#hfcontact").val();
			var sData = "  <div class='mob_gif_center'><p><strong> Please wait.</strong>. <br> we are searching best fares for you.</p> <div class='clearfix'></div><div class='loading-plane-pop'></div> </div><div class='wait-popup'>" +

				"<div class='wait-logo'> " + " </div>" +
				" <div id='progressbar' style='width: 577px;'>" +
				" <div id='progressLine'>" +
				" <div id='pbaranim'></div>" +
				"  </div>" +
				"</div>" +
				" <div class='wait-txe'>" +
				" <h3> Flight Search in Progress </h3> " + " <p>Searching for the best deal for you. Kindly wait, this may take a little time</p> " +
				" </div>" +

				" <div class='clearfix'></div>" +
				"<div class='wait-main'>" +
				"<div class='wait-1'>";

			sData += "   <span class='wait-txt-small'>" + $("#hfFromDestination").val().split('-')[1] + "</span><br />" +
				"  <span class='wait-txt-big'>" + $("#hfFromDestination").val().split('-')[0] + "</span>";


			sData += " </div>" +
				"  <div class='wait-1'>";
			if ($("#hfTripType").val() == 1) {

				sData += "<div class='search_wtg_divider single-divider'></div>";
			} else {
				sData += "<div class='search_wtg_divider double-divider'></div>";
			}
			sData += " </div>" +
				" <div class='wait-1'>";


			sData += "   <span class='wait-txt-small'>" + $("#hfToDestination").val().split('-')[1] + "</span><br />" +
				"  <span class='wait-txt-big'>" + $("#hfToDestination").val().split('-')[0] + "</span>";

			sData += "  </div>" +
				"  </div>" +
				" <div class='clearfix'></div>" +


				"<div class='wait-depart'>" +

				" <div class='wait-2'>" +
				"<span class='wait-dest-txt'>Departure</span><br />" +
				"<span class='wait-dest-txt-small'>" + $("#hfFromDate").val() + "</span>" +
				"   </div>";

			if ($("#hfTripType").val() == 2) {
				sData += "  <div class='wait-2'>" +
					"      <span class='wait-dest-txt'>Return</span><br />" +
					"       <span class='wait-dest-txt-small'> " + $("#hfToDate").val() + "</span>" +
					"   </div>";
			}


			sData += "   <div class='wait-2'>" +
				"     <span class='wait-dest-txt'>Class</span><br />" +
				"      <span class='wait-dest-txt-small'>" + $("#select_class").val() + "</span>" +
				"   </div>" +
				"    <div class='wait-2'>" +
				"      <span class='wait-dest-txt'>Travellers</span><br />" +
				"       <span class='wait-dest-txt-small'>";

			if (parseInt($("#hfAdult").val()) == 1) {
				sData += "" + $("#hfAdult").val() + " Adult";
			} else {
				sData += "" + $("#hfAdult").val() + " Adults";
			}

			if (parseInt($("#hfChild").val()) > 0) {
				if (parseInt($("#hfChild").val()) == 1) {
					sData += ", " + $("#hfChild").val() + " Child";
				} else {
					sData += ", " + $("#hfChild").val() + " Children";
				}
			}

			if (parseInt($("#hfInfant").val()) > 0) {
				if (parseInt($("#hfInfant").val()) == 1) {
					sData += ", " + $("#hfInfant").val() + " Infant";
				} else {
					sData += ", " + $("#hfInfant").val() + " Infants";
				}
			}
			sData += "</span>" +
				"   </div>" +

				" </div>" +

				" <div class='wait-talk-main'>" +
				"  <div class='talk-txt'>" +
				"    For any assistance or help, Call Now" +
				" </div>" +
				"<div class='clearfix'></div> " +
				" <div class='talk-txt-1'>" +
				"  <img src='https://www.crystaltravel.co.uk/Content/images/phone-icon-wait.png' alt='' />&nbsp;" + contact + "" +
				" </div>" +
				"  </div>" +
				"<div class='search_wtg_fotter'> </div> "

			"</div>";
			return sData;
		}
	</script>
	<?php if (Route::currentRouteName() == 'flightList') { ?>
		<script>
			var sessionTimeout = 20;
			window.onload = DisplaySessionTimeout;

			function DisplaySessionTimeout() {
				sessionTimeout = sessionTimeout - 1;
				if (sessionTimeout >= 0)
					window.setTimeout("DisplaySessionTimeout()", 60000);
				else {
					callSessionTimeOut();
				}
			}

			function callSessionTimeOut() {
				$(".sessionpop").show();
				return true;
			}

			function ShowWait() {
				location.reload();
			}
		</script>

	<?php } ?>
	<script>
		$("#telephone").intlTelInput();
		$('.filter_icon a').on("click", function() {
			$('.cus_col_3').toggleClass('show');
		});
		$('a.filter_close').on("click", function() {
			$('.cus_col_3').removeClass('show');
		});
		$('.search_flight a').on("click", function() {
			$('.search_mobile.custom_reservation_tab').toggleClass('show');
		});
		$('.close_flight a').on("click", function() {
			$('.search_mobile.custom_reservation_tab').removeClass('show');
		});
		$('.cus_sidebar').theiaStickySidebar({
			additionalMarginTop: 80
		});
		$('input[name="datefilter"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
		$('.view_all_offer a').on("click", function() {
			$('.view_all_offer .offersAppliedList').toggleClass('show');
		});
	</script>

	<input type="hidden" id="hfTripType" name="hfTripType" value="false">
	<input type="hidden" id="hfFromDestination" name="hfFromDestination" value="">
	<input type="hidden" id="hfToDestination" name="hfToDestination" value="">
	<input type="hidden" id="hfFromDate" name="hfFromDate" value="">
	<input type="hidden" id="hfToDate" name="hfToDate" value="">
	<input type="hidden" id="hfAdult" name="hfAdult" value="">
	<input type="hidden" id="hfChild" name="hfChild" value="">
	<input type="hidden" id="hfInfant" name="hfInfant" value="">
	<input type="hidden" id="hfflex" name="hfflex">
	<input type="hidden" id="hfdirect" name="hfdirect">
	<input type="hidden" id="hfcontact" name="hfcontact" value="011 47 26 26 26">
	<input type="hidden" id="select_class" name="select_class" value="">
	<!-- Modal -->
	<div class="modal fade" id="inquirymodal" tabindex="-1" role="dialog" aria-labelledby="inquirymodalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="inquirymodalLabel">Quick Inquiry</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="pkgform-wrapper">
						<div class="cont-wth1">
							<div class="pkgform-headbx text-center">QUICK CONTACT <span class="title-arrow"></span></div>
							<div class="pkgform-box">

								{{ Form::open(array('url' => 'enquiry-contact', 'name'=>"queryform", 'autocomplete'=>'off','id'=>'popenquiryco')) }}
								<span class="customerror"></span>
								<input type="text" data-valid='required' name="name" class="form-control" value="" placeholder="Name">
								<input type="text" data-valid='required' name="email" class="form-control" value="" placeholder="Email">
								<input type="text" data-valid='required' name="phone" class="form-control" value="" placeholder="Phone">
								<input type="text" data-valid='required' name="city" class="form-control" value="" placeholder="City">
								<div class="form-group">
									<input type="text" id="" data-valid='required' name="traveldate" class="form-control" value="" placeholder="Travel Date">
								</div>
								<div class="row">
									<div class="col-sm-6 col-xs-6 codwh">
										<select class="form-control" name="adults">
											<option value="">Adults*</option>
											<?php
											for ($ai = 1; $ai <= 10; $ai++) {
											?>
												<option value="{{$ai}}">{{$ai}}</option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="col-sm-6 col-xs-6 leftpd">
										<select class="form-control" name="children">
											<option value="">Children (5-12 yr)</option>
											<?php
											for ($ck = 1; $ck <= 10; $ck++) {
											?>
												<option value="{{$ck}}">{{$ck}}</option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<textarea class="form-control" type="text" name="add_info" placeholder="Want to customize this package? Tell us more"></textarea>
								<div class="row">
									<div class="col-sm-7 col-xs-8 codwh">
										<?php $codes = rand(1000, 9999); ?>
										<input data-valid='required captcha' class="form-control" type="text" name="captcha" value="" placeholder="Enter Code" maxlength="4">
									</div>
									<div class="col-sm-5 col-xs-4 codwh-1">
										<input type="hidden" name="code" value="{{$codes}}">
										<img src="{{route('sicaptcha')}}?code={{$codes}}" class="img-responsive" alt="Captcha" width="65" height="25">
									</div>
								</div>
								<input type="hidden" id="mpackage_id" name="package_id" value="">
								{{ Form::button('Submit', ['class'=>'submitbtt', 'onClick'=>'customValidate("queryform")' ]) }}
								{{ Form::close() }}
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div id="myModalZoom" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<img src="" class="img-fluid zoomsow" alt="" width="100%" height="533">
				</div>
			</div>
		</div>
	</div>
	<div id="hotelcontent" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4></h4>
					<div class="starmargin ">
					</div>
					<div class="loclity ">
						<span class="textblack13bold ng-scope">Locality:</span>
					</div>
					<div class="hotel_description">This Hotels is very comfortable and 5 star hotels. These room services is awesome.</div>
				</div>
			</div>
		</div>
	</div>

	<div class="sessionpop" style="display: none;">
		<div class="searchpopinner searchpopinner1">
			<h2>Your search expired</h2>
			<p>To ensure accurate prices and availability of the flight, you must refresh the results.</p>
			<div class="searcpoprow">
				<asp:hyperlink id="hlRefresResult" onclick="ShowWait();"><img src="{{URL::to('public')}}/images/refresh-btn.png" alt="Refresh" style="cursor:pointer;" /></asp:hyperlink>
			</div>
			<a href='{{URL::to('/')}}'>or go to homepage.</a>
			<div class="clearfix"></div>
		</div>
	</div>

	<div id="farecheck" class="modal fade" role="dialog">
		<?php
		$searchdata = Session::get('allrequest');
		?>
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h3>Oops, the fare you picked has changed.</h3>
					<p>Airlines only have limited seats available for each fare, and unfortunately, the seats at this fare just ran out. The fare has changed from <b><span class="oldprice"></span></b> INR to <b><span class="newprice"></span></b> INR.</p>
					<div class="fare_btn">
						<a class="another_flight" href="{{URL::to('/FlightList/index')}}?srch={{$searchdata['srch']}}&px={{$searchdata['px']}}&cbn={{$searchdata['cbn']}}&nt={{$searchdata['nt']}}&jt={{$searchdata['jt']}}"><i class="fa fa-arrow-left"></i> Choose Another Flight</a>
						<a class="continue" href="javascript:;">Continue <i class="fa fa-arrow-right"></i></a>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</div>


</body>

</html>