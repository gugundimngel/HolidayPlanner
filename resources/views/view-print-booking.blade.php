@extends('layouts.frontend')
@section('title', 'View Print Booking')
@section('content')

<!-- Content
		============================================= -->
<section id="content">
	<div id="content-wrap">
		<!-- === Section Flat =========== -->
		<div class="section-flat single_sec_flat viewprint_page" style="background:#e8e8e8;">
			<div class="section-content">
				<div class="inner_travelagent">
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<div class="cus_breadcrumb">
									<ul>
										<li class="active"><a href="#">Home</a></li>
										<li><span><i class="fa fa-angle-right"></i></span></li>
										<li><a href="#">View Print Booking</a></li>
									</ul>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="view_print_form">
						<div class="container">
							<div class="row">
								<div class="inner_print_form col-sm-12">
									<div class="col-sm-6 col-xs-12 login_form_1 custom_login_form">
										<form class="" method="" action="">
											<h3>Sign in to Holiday Planner</h3>
											<div class="form-group">
												<input type="email" class="form-control" placeholder="Enter Your Email Address/Mobile No." value="" />
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password" value="" />
											</div>
											<div class="form-group">
												<input type="submit" class="btnSubmit" value="Sign In" />
											</div>
											<div class="form-group">
												<a href="#" class="btnForgetPwd">Forget Password?</a>
											</div>
										</form>
									</div>
									<div class="col-sm-6 col-xs-12 login_form_2 custom_login_form">

										<form class="" method="get" action="{{URL::to('/view-ticket')}}">
											<h3>View/Cancel/Reschedule your Reservation</h3>
											<div class="form-group">
												<input required name="ticket" type="text" class="form-control" placeholder="Reference ID/Booking ID/PNR" value="" />
											</div>
											<div class="form-group">
												<input required name="email" type="email" class="form-control" placeholder="Email Address" value="" />
											</div>
											<div class="form-group">
												<input type="submit" class="btnSubmit" value="Submit" />
											</div>
										</form>
									</div>
									<div class="clearfix"></div>
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