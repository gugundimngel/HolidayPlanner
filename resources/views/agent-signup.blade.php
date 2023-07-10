@extends('layouts.frontend')
@section('title', 'View Print Booking')
@section('content')
<style>
	.progress {
		height: 3px !important;
	}

	.progress-bar-danger {
		background-color: #e90f10;
	}

	.progress-bar-warning {
		background-color: #ffad00;
	}

	.progress-bar-success {
		background-color: #02b502;
	}
</style>
<!-- Content
		============================================= -->
<section id="content">
	<div id="content-wrap">
		<!-- === Section Flat =========== -->
		<div class="section-flat single_sec_flat viewprint_page">
			<div class="section-content">
				<div class="inner_travelagent">
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<div class="cus_breadcrumb">
									<ul>
										<li class="active"><a href="#">Home</a></li>
										<li><span><i class="fa fa-angle-right"></i></span></li>
										<li><a href="#">Agent Sign Up</a></li>
									</ul>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="agent_signup_form">
						<div class="container">
							<div class="row">
								{{ Form::open(array('url' => 'agent/signup', 'name'=>"add-signup", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
								<div class="col-12">
									<div class="inner_form_field">
										<h3>Agent Registration Form</h3>
										@if ($message = Session::get('success'))
										<div class="alert alert-success alert-dismissible fade show" role="alert">

											<strong>{{ $message }}</strong>
										</div>
										@endif

										@if ($message = Session::get('error'))
										<div class="alert alert-danger alert-dismissible fade show">

											<strong>{{ $message }}</strong>
										</div>
										@endif
										<div class="form_note">
											<p>Please fill your details in the request form below and our customer service team will respond within next 72 hours.</p>
										</div>
										<div class="require_note">
											<span>Note: * Fields are mandatory.</span>
										</div>
										<div class="form_heading">
											<h4>Company Detail</h4>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Company Name <span style="color:#ff0000;">*</span></label>
													<input autocomplete="off" data-valid="required" type="text" class="form-control" placeholder="Company Name" name="company_name" />
													@if ($errors->has('company_name'))
													<span class="custom-error" role="alert">
														<strong>{{ $errors->first('company_name') }}</strong>
													</span>
													@endif
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Fax Number</label>
													<input autocomplete="off" type="text" class="form-control" placeholder="Fax Number" name="faxno" />
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Name <span style="color:#ff0000;">*</span></label>
													<div class="select_field">
														<select data-valid="required" class="form-control" name="salute_name">
															<option value="Mr">Mr</option>
															<option value="Mrs">Mrs</option>
															<option value="Miss">Miss</option>
														</select>
													</div>
													<div class="input_field">
														<input autocomplete="off" data-valid="required" type="text" class="form-control" placeholder="First Name" name="first_name" />
													</div>
													<div class="input_field">
														<input autocomplete="off" data-valid="required" type="text" class="form-control" placeholder="Last Name" name="last_name" />
													</div>
													<div class="clearfix"></div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Mobile Number <span style="color:#ff0000;">*</span></label>
													<input autocomplete="off" id="mobile" data-valid="required minlength7 maxlength15" type="tel" class="form-control" placeholder="Mobile Number" name="mobile_no" />
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Phone Number </label>
													<input autocomplete="off" data-valid="" type="tel" id="phone" class="form-control" placeholder="Phone Number" name="phone" />
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Email ID <span style="color:#ff0000;">*</span></label>
													<input autocomplete="off" autocomplete="off" data-valid="required email" type="email" class="form-control" placeholder="Email ID" name="aemail" />
													@if ($errors->has('aemail'))
													<span class="custom-error" role="alert">
														<strong>{{ $errors->first('aemail') }}</strong>
													</span>
													@endif
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Address 1 <span style="color:#ff0000;">*</span></label>
													<input autocomplete="off" data-valid="required" type="text" class="form-control" placeholder="1st Address" name="address" />
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Address 2</label>
													<input autocomplete="off" type="text" class="form-control" placeholder="2nd Address" name="address2" />
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group country_field">
													<label>Country <span style="color:#ff0000;">*</span></label>
													<div name="country" class="niceCountryInputSelector" id="basic" data-isrequired="required" data-selectedcountry="IN" data-showspecial="false" data-showflags="true" data-i18nall="All selected" data-i18nnofilter="No selection" data-i18nfilter="Filter" data-onchangecallback="onChangeCallback"></div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>State</label>
													<input autocomplete="off" type="text" class="form-control" placeholder="State" name="state" />
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>City <span style="color:#ff0000;">*</span></label>
													<input autocomplete="off" data-valid="required" type="text" class="form-control" placeholder="City" name="city" />
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Postal Code <span style="color:#ff0000;">*</span></label>
													<input autocomplete="off" data-valid="required" type="text" class="form-control" placeholder="Postal Code" name="zip" />
												</div>
											</div>
										</div>
										<div class="form_heading">
											<h4>User Detail</h4>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Password <span style="color:#ff0000;">*</span></label></label>
													<input autocomplete="off" id="password" data-valid="required" type="password" class="form-control" placeholder="Password" name="apassword" />
													@if ($errors->has('apassword'))
													<span class="custom-error" role="alert">
														<strong>{{ $errors->first('apassword') }}</strong>
													</span>
													@endif

												</div>
												<div id="popover-password">
													<p><span id="result"></span></p>
													<div class="progress">
														<div id="password-strength" class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">
														</div>
													</div>
												</div>
												<ul class="list-unstyled">
													<li class="">
														<span class="low-upper-case">
															<i class="fas fa-circle" aria-hidden="true"></i>
															&nbsp;Lowercase &amp; Uppercase
														</span>
													</li>
													<li class="">
														<span class="one-number">
															<i class="fas fa-circle" aria-hidden="true"></i>
															&nbsp;Number (0-9)
														</span>
													</li>
													<li class="">
														<span class="one-special-char">
															<i class="fas fa-circle" aria-hidden="true"></i>
															&nbsp;Special Character (!@#$%^&*)
														</span>
													</li>
													<li class="">
														<span class="eight-character">
															<i class="fas fa-circle" aria-hidden="true"></i>
															&nbsp;Atleast 8 Character
														</span>
													</li>
												</ul>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Re-Type Password <span style="color:#ff0000;">*</span></label></label>
													<input autocomplete="off" data-valid="required" type="password" class="form-control" placeholder="Re-Type Password" name="password_confirmation" />
												</div>
											</div>

											<div class="col-sm-6">
												<div class="form-group">
													<label>Contact Name</label>
													<input autocomplete="off" type="text" class="form-control" placeholder="Contact Name" name="contact_name" />
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Contact Number</label>
													<input autocomplete="off" type="tel" id="cphone" class="form-control" placeholder="Contact Number" name="contact_no" />
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Upload Company Logo </label>
													<div class="upload_file">
														<input type="file" class="form-control" name="logo" />
														<span class="upload_btn">Choose File</span>
													</div>
												</div>
											</div>
										</div>
										<div class="form_heading">
											<h4>Documents</h4>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Company Pan Card <span style="color:#ff0000;">*</span></label>
													<div class="upload_file">
														<input data-valid="required" type="file" class="form-control" name="company_pancard" />
														<span class="upload_btn">Choose File</span>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Aadhaar Card <span style="color:#ff0000;">*</span></label>
													<div class="upload_file">
														<input data-valid="required" type="file" class="form-control" name="aadhaar_card" />
														<span class="upload_btn">Choose File</span>
													</div>
												</div>
											</div>
											<div class="col-sm-12">
												<div class="chcekbox">
													<label>
														<input data-valid="required" type="checkbox" />
														By clicking this check box you are accepting our <a href="javascript:;">Terms & Conditions and Disclaimer.</a>
													</label>
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form_btn text-center">
													<input onClick='customValidate("add-signup")' type="button" class="submit_btn" value="Submit" />
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								{{ Form::close() }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection
@section('scripts')
<script>
	jQuery(document).ready(function($) {
		$(".niceCountryInputSelector").each(function(i, e) {
			new NiceCountryInput(e).init();
		});
		$("#phone").on("keypress keyup blur", function(event) {
			var data = $('#phone').val();
			if (phone_validate(data)) {} else {
				$('#phone').val('');
			}
		});
		$("#mobile").on("keypress keyup blur", function(event) {
			var data = $('#mobile').val();
			if (phone_validate(data)) {} else {
				$('#mobile').val('');
			}
		});
		$("#cphone").on("keypress keyup blur", function(event) {
			var data = $('#cphone').val();
			if (phone_validate(data)) {} else {
				$('#cphone').val('');
			}
		});

		function phone_validate(phno) {
			var regexPattern = new RegExp(/^[0-9]+$/); // regular expression pattern
			return regexPattern.test(phno);
		}
	});

	let state = false;
	let password = document.getElementById("password");
	let passwordStrength = document.getElementById("password-strength");
	let lowUpperCase = document.querySelector(".low-upper-case i");
	let number = document.querySelector(".one-number i");
	let specialChar = document.querySelector(".one-special-char i");
	let eightChar = document.querySelector(".eight-character i");
	var s = false;
	password.addEventListener("keyup", function() {
		let pass = document.getElementById("password").value;
		s = checkStrength(pass);

	});

	var v = false;

	function checkStrength(password) {
		let strength = 0;

		//If password contains both lower and uppercase characters
		if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
			strength += 1;
			lowUpperCase.classList.remove('fa-circle');
			lowUpperCase.classList.add('fa-check');
		} else {
			lowUpperCase.classList.add('fa-circle');
			lowUpperCase.classList.remove('fa-check');
		}
		//If it has numbers and characters
		if (password.match(/([0-9])/)) {
			strength += 1;
			number.classList.remove('fa-circle');
			number.classList.add('fa-check');
		} else {
			number.classList.add('fa-circle');
			number.classList.remove('fa-check');
		}
		//If it has one special character
		if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
			strength += 1;
			specialChar.classList.remove('fa-circle');
			specialChar.classList.add('fa-check');
		} else {
			specialChar.classList.add('fa-circle');
			specialChar.classList.remove('fa-check');
		}
		//If password is greater than 7
		if (password.length > 7) {
			strength += 1;
			eightChar.classList.remove('fa-circle');
			eightChar.classList.add('fa-check');
		} else {
			eightChar.classList.add('fa-circle');
			eightChar.classList.remove('fa-check');
		}

		// If value is less than 2
		if (strength < 2) {
			passwordStrength.classList.remove('progress-bar-warning');
			passwordStrength.classList.remove('progress-bar-success');
			passwordStrength.classList.add('progress-bar-danger');
			passwordStrength.style = 'width: 10%';
		} else if (strength == 3) {
			v = true;
			passwordStrength.classList.remove('progress-bar-success');
			passwordStrength.classList.remove('progress-bar-danger');
			passwordStrength.classList.add('progress-bar-warning');
			passwordStrength.style = 'width: 60%';
		} else if (strength == 4) {
			v = true;
			passwordStrength.classList.remove('progress-bar-warning');
			passwordStrength.classList.remove('progress-bar-danger');
			passwordStrength.classList.add('progress-bar-success');
			passwordStrength.style = 'width: 100%';
		}

		return v;
	}
</script>
@endsection