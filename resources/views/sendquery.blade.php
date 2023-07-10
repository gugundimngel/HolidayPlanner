@extends('layouts.frontend')
@section('title', 'Send Query')
@section('content')

<!-- Content
		============================================= -->
<section id="content">
	<div id="content-wrap">
		<!-- === Section Flat =========== -->
		<div class="section-flat single_sec_flat contact_page" style="background:#e8e8e8;">
			<div class="section-content">
				<div class="custom_banner">
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<div class="banner_txt">
									<div class="title">
										 <h3>Send Query</h3>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="inner_contact send_query_section">
							<div class="col-sm-12">
								<div class="cus_breadcrumb">
									<ul>
										<li class="active"><a href="#">Home</a></li>
										<li><span><i class="fa fa-angle-right"></i></span></li>
										<li><a href="#">Send Query</a></li>
									</ul>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="contact_detail">
								<div class="col-sm-12 cusquery_txt">
									<h3>Ask our advisor for your next <span>Holiday trip</span></h3>
									<p>Planning the perfect holiday requires covering a lot of aspects. Right from deciding upon a suitable destination, to finding the best airfare, booking the right hotels and shortlisting the things to see and do, can be a fairly daunting experience. However, with Holiday Planner you are in the right hands. Our destination specialists can save you that time and effort.</p>
									<p>Whether you simply want to know the best time to visit a place, the attractions to include, or foreign exchange rates, we will guide you through everything. All you need to do is to fill out and submit the form below, and we will get contact you to help you plan the perfect holiday.</p>
								</div>
								<div class="col-sm-6">
									<div class="enquiry_info">
										<div class="girl_wrap">
											<img src="{!! asset('public/images/enq-girl.png') !!}" class="img-responsive" alt="" title="">
											<div class="enqNumber">
												<p>Or you can call us, at this number</p>
												<b> (+91)-7969224444</b>
												<div class="enq_icon">
													<i class="fa fa-phone"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="contact_form">
										{{ Form::open(array('url' => 'contact/send', 'name'=>"add-contact", 'autocomplete'=>'off', "enctype"=>"multipart/form-data", 'class' => "form_sec")) }}
											<div class="row">
												<div class="col-sm-12">
													<div class="form-group">
														<input type="text" class="form-control txt_field" placeholder="Name" name="name" />
													</div>
													<div class="form-group">
														<input type="email" class="form-control txt_field" placeholder="Email Address" name="email" />
													</div>
													<div class="form-group">
														<input type="text" class="form-control txt_field" placeholder="Phone Number" name="phone" />
													</div>
													<div class="form-group">
														<label>Enquiry Type</label>
														<select class="form-control" name="enquiry_type">
															<option>Flights</option>
															<option>Hotels</option>
															<option>Tour Package</option>
															<option>Bus</option>
															<option>Visa</option>
														</select>
													</div>
													<div class="form-group">
														<textarea class="form-control" placeholder="Your Message" name="message"></textarea>
													</div>
													<div class="form-group">
														<div class="checkbox form_checkbox">
															<label><input type="checkbox"/><span class="checkmark"></span> By clicking a submission button, I agree to Consent</label>
														</div>
													</div>
													@if(config('services.recaptcha.key'))
														<div class="g-recaptcha"
															data-sitekey="{{config('services.recaptcha.key')}}">
														</div>
													@endif
													@if ($errors->has('g-recaptcha-response'))
															<span class="custom-error" role="alert">
																<strong>{{ $errors->first('g-recaptcha-response') }}</strong>
															</span>
														@endif
													<div class="form-group text-center">
														<input onClick='customValidate("add-contact")' type="submit" name="submit" class="form_submit_btn" value="Submit" />
													</div>
												</div>
											</div>
											{{ Form::close() }}
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<!--<div class="enquiry_info">
								<div class="col-sm-4">
									<h5><i class="fa fa-envelope"></i> Email</h5>
									<p><a href="mailto:info@zapbooking.com">info@zapbooking.com</a></p>
								</div>
								<div class="col-sm-4">
									<h5><i class="fa fa-phone"></i> Phone</h5>
									<p><a href="tel:(+91)-7969224444">(+91)-7969224444</a></p>
								</div>
								<div class="col-sm-4">
									<h5><i class="fa fa-map-marker"></i> Address</h5>
									<p>Holiday Planner Private Limited<br> F111/112 North Square Mall,<br>Netaji subhash place complex,<br>Delhi – 110034, India</p>
								</div>
							</div>-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection