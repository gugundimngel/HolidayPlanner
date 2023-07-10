@extends('layouts.frontend')
@section('title', 'Contact Us')
@section('content')

<!-- Content
		============================================= -->
<section id="content">
	<div id="content-wrap">
		<!-- === Section Flat =========== -->
		<div class="section-flat single_sec_flat contact_page">
			<div class="section-content">
				<div class="banner_light">
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<div class="banner_txt">
									<div class="title">
										<h3>Contact Us</h3>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="inner_contact">
							<div class="col-sm-12">
								<div class="cus_breadcrumb">
									<ul>
										<li class="active"><a href="#">Home</a></li>
										<li><span><i class="fa fa-angle-right"></i></span></li>
										<li><a href="#">Contact</a></li>
									</ul>
								</div>
							</div>

							<div class="clearfix"></div>
							
							<div class="contact_detail" id="row_scroll">
								<div class="col-sm-6">
									<div class="contact_form">
										<h4>Get in tocuh with us</h4>
										{{ Form::open(array('url' => 'contact/send', 'name'=>"add-contact", 'autocomplete'=>'off', "enctype"=>"multipart/form-data", 'class' => "form_sec")) }}
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<input value="{{ old('name')  }}" data-valid="required" type="text" class="form-control txt_field" placeholder="Name" name="name" />
												</div>
												<div class="form-group">
													<input 
													value="{{ old('email')  }}" data-valid="required" 
													type="email" class="form-control txt_field" placeholder="Email Address" name="email" />
												</div>
												<div class="form-group">
													<input value="{{ old('phone')  }}" 
													data-valid="required" type="text" class="form-control txt_field" placeholder="Phone Number" name="phone" />
												</div>
												<div class="form-group">
													<input value="{{ old('subject')  }}" 
													data-valid="required" type="text" class="form-control txt_field" placeholder="Subject" name="subject" />
												</div>
												<div class="form-group">
													<textarea data-valid="required" class="form-control" 
													value="" placeholder="Your Message" name="message">{{ old('message')  }}</textarea>
												</div>
												@if(config('services.recaptcha.key'))
												<div class="g-recaptcha" data-sitekey="{{config('services.recaptcha.key')}}">
												</div>
												@endif
												@if ($errors->has('g-recaptcha-response'))
												<span class="custom-error" role="alert">
													<strong>{{ $errors->first('g-recaptcha-response') }}</strong>
												</span>
												@endif
												<div class="form-group text-center">
													<input onClick='customValidate("add-contact")' type="button" name="submitcontact" class="form_submit_btn" value="Submit" />
												</div>
											</div>
										</div>
										{{ Form::close() }}
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="contact_info">
										<h4>India Office Location</h4>
										<p><span style="display:block;"><b>Company Address
												</b></span>
											112, Near, Gurudwara Medical College Road,<br>
											Sindhi Colony, Sector-E, Shastri Nagar,<br>
											Jodhpur, Rajasthan 342003
										</p>

										<p><b><i style="transform: rotate(112deg);" class="fa fa-phone" aria-hidden="true"></i></b> 
											<a href="tel:+917969224444">(+91)-7969224444 </a>
										</p>
										<p><b><i class="fa fa-envelope" aria-hidden="true"></i></b> <a href="mailto:Support@holidaychacha.com">Support@holidaychacha.com</a></p>
										<p><b><i class="fa fa-globe" aria-hidden="true"></i></b> <a target="_blank" href="https://holidaychacha.com/">holidaychacha.com</a></p>
									</div>


									<div class="contact_info">
										<h4>Dubai Office Location</h4>
										<p><span style="display:block;"><b>Company Address
												</b></span>
											Metro Station - #1202,<br>
											Musallah Tower, Bur Dubai,<br>
											Near - Al Fahidi - Dubai - United Arab Emirates

										</p>

										<p><b><i style="transform: rotate(112deg);" class="fa fa-phone" aria-hidden="true"></i></b> 
											<a href="tel:(+971) 58 825 6515">(+971) 58 825 6515</a>
										</p>
										<p><b><i class="fa fa-envelope" aria-hidden="true"></i></b> <a href="mailto:Support@holidaychacha.com">Support@holidaychacha.com</a></p>
										<p><b><i class="fa fa-globe" aria-hidden="true"></i></b> <a target="_blank" href="https://holidayplanner.ae/">holidayplanner.ae</a></p>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							
							<div class="clearfix"></div>

							<div class="col-sm-12">
								@if ($message = Session::get('success'))
								<div class="alert alert-success alert-dismissible" role="alert">

									<strong>{{ $message }}</strong>
								</div>
								@endif

								@if ($message = Session::get('error'))
								<div class="alert alert-danger alert-dismissible fade show">

									<strong>{{ $message }}</strong>
								</div>
								@endif
								<div class="contact_map">
									<h4>Google Location</h4>
									<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3577.7043277993776!2d73.00339476483816!3d26.271257883408083!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39418c3ad0000001%3A0x608d1f0903cc2a53!2sHoliday%20Planner!5e0!3m2!1sen!2sin!4v1680360645667!5m2!1sen!2sin" width="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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

@endsection