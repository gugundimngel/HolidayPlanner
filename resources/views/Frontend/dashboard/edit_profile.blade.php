@extends('layouts.frontend')
@section('title', 'Edit My Profile')
@section('content')    
<style>
#ui-datepicker-div {
    z-index: 88 !important;
}
</style>  
<section id="content">
			<div id="content-wrap">
				<!-- === Section Flat =========== -->
				<div class="section-flat single_sec_flat profile_sec dashboard_inner">      
					<div class="section-content">
						<div class="container">
							<div class="row">
								<div class="col-sm-12">	
										<!-- Flash Message Start -->
										<div class="server-error">
											@include('../Elements/flash-message')
										</div>
										<!-- Flash Message End -->
									<div class="cus_breadcrumb">
										<ul>
											<li class="active"><a href="#">My Account</a></li>
											<li><span><i class="fa fa-angle-right"></i></span></li>
											<li><a href="#">My Profile</a></li>
										</ul>
									</div>	
								</div>
								<form class="profile_form custom_form">
									<div class="col-sm-3">
											@include('../Elements/Frontend/navigation')
									</div>	
									<div class="col-sm-9">	
										<div class="inner_content">
											<div class="mmail-msg"></div>
											<div class="profile_status">
											<?php 
											$progress = 10;
												if(Auth::user()->email_verify_status == 1){
													$progress += 40;
												}
												if(Auth::user()->mobile_verify_status == 1){
													$progress += 50;
												}
											?>
												<div class="progress_label">
													<h5>Complete your Profile<span>{{$progress}}%</span></h5>
													<div class="progress">
														<div class="progress-bar" role="progressbar" style="width: {{$progress}}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<p>Get the best out of Holiday Planner by adding the remaining details!</p>
												<div class="profile_verify">
													<ul>
													@if(Auth::user()->email_verify_status == 1)
														<li class="verify_email verified">
															<a href="javascript:;"><i class="fa fa-check"></i> Verify Email</a>
														</li>
														@else
															<li class="verify_email">
																<a href="javascript:;" class="verify_myemail"><i class="fa fa-plus"></i> Verify Email</a>
															</li>
															
														@endif
														@if(Auth::user()->mobile_verify_status == 1)
															<li class="verify_phone verified">
																<a href="#"><i class="fa fa-check"></i> Verified Mobile Number</a>
															</li>
														@else
															<li class="verify_phone ">
																<a href="javascript:;" class="verify_mobile"><i class="fa fa-plus"></i> Verified Mobile Number</a>
															</li>
														@endif
													</ul>
												</div>
											</div>
											<div class="profile_component">
												<div class="profile_header">
													<div class="pro_title">
														<h3>Profile</h3>
														<p>Basic info, for a faster booking experience</p>
													</div>
													<div class="custom_profbtn">
														<a href="#" class="popup-btn-profile"><i class="fa fa-pencil-alt"></i> Edit</a>
													</div>  
													<div class="clearfix"></div>
												</div> 
												<div class="profile_list">
													<ul>
														<li><span class="span_label">Name</span><span class="span_value">{{@Auth::user()->first_name}} {{@Auth::user()->last_name}}</span></li>
														<li><span class="span_label">Birthday</span><span class="span_value">@if(@Auth::user()->dob != ''){{date('d/m/Y', strtotime(@Auth::user()->dob))}}@else---@endif</span> @if(@Auth::user()->dob == '')<a href="javascript:;" class="popup-btn-profile"><i class="fa fa-plus"></i> Add</a>@endif</li>
														<li><span class="span_label">Gender</span><span class="span_value">
														@if(@Auth::user()->gender != '')
															@if(@Auth::user()->gender == 1)
																Male
															@elseif(@Auth::user()->gender == 2)
																Female
															@else
																Transgender
															@endif
														@else
															---
														@endif
														
														</span> @if(@Auth::user()->gender == '') <a href="javascript:;" class="popup-btn-profile"><i class="fa fa-plus"></i> Add</a> @endif</li>
													
														<li><span class="span_label">Marital Status</span><span class="span_value"> 
														@if(@Auth::user()->marital_status != '')
															{{@Auth::user()->marital_status}}
														@else
															---
														@endif
														
														</span> @if(@Auth::user()->marital_status == '') <a href="javascript:;" class="popup-btn-profile"><i class="fa fa-plus"></i> Add</a>@endif</li>
													</ul>
												</div> 
											</div>
										</div>
									</div>	
								</form>
							</div>	
						</div>	
					</div>	
				</div>	
			</div>	
		</section>	
		<div class="popup-preview popup-preview-2 popup-mobileverify popup-cusprofile">
			<div class="popup-bg"></div>
			<div class="container"> 
				<div class="row">
					<div class="col-md-8 col-md-offset-2"> 
						<div class="popup-content">
							<div class="block-content">
								<div class="block-title">
									<h3>Verify Mobile</h3>
								</div>
								<div class="content">
									<form id="form-profile" class="" >
										<div class="left">
											<div class="form-content">
												<div class="col-sm-6 col_block">
													<label for="otp">OTP</label>
													<input type="text" name="otp" id="otp" class="form-control" placeholder="" value=""/>
													<span style="display:none;" class="help-block firstname-error">
													<strong></strong>
													</span> 
												</div>
												<div class="col-sm-12 col_block">
												<div class="form-group text-center">
													<input type="submit" id="otpsubmit" class="form-control" value="Save">
												</div><!-- .form-group end --> 
												</div>
												<div class="clearfix"></div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<div class="popup-preview popup-preview-2 popup-editprofile popup-cusprofile">
		<div class="popup-bg"></div>
	
		<div class="container"> 
			<div class="row">
				<div class="col-md-8 col-md-offset-2"> 
					<div class="popup-content">
						<div class="block-content">
							<div class="block-title">
								<h3>Edit Profile</h3>
							</div><!-- .block-title end -->
							<div class="content">
								<form id="form-profile" class="" >
									<div class="left">
										<div class="form-content">
											<div class="col-sm-6 col_block">
												<div class="form-group">
													<label for="firstname">First Name</label>
													<input type="text" name="firstname" id="firstname" class="form-control" placeholder="" value="{{@Auth::user()->first_name}}"/>
													<span style="display:none;" class="help-block firstname-error">
													<strong></strong>
												</span> 
												</div>
											</div>
											<div class="col-sm-6 col_block">	
												<div class="form-group">
													<label for="lastname">Last Name</label>
													<input type="text" name="lastname" id="lastname" class="form-control" placeholder="" value="{{@Auth::user()->last_name}}"/>
													<span style="display:none;" class="help-block lastname-error">
													<strong></strong>
												</span> 
												</div>
											</div>
											<div class="col-sm-6 col_block">
												<div class="form-group">
													<label for="email">Email</label>
													<input type="email" name="email" id="email" class="form-control" placeholder="" value="{{@Auth::user()->email}}"/> 
													<span style="display:none;" class="help-block email-error">
													<strong></strong>
												</span> 
												</div>
											</div>
											<div class="col-sm-6 col_block">
												<div class="form-group">
													<label for="password">Password</label>
													<input type="password" name="password" id="password" class="form-control" placeholder="">
													
												</div><!-- .form-group end -->
											</div>
											<div class="col-sm-6 col_block">
												<div class="form-group">
													<label for="gender">Gender</label>
													<select type="text" name="gender" id="gender" class="form-control" placeholder="">
														<option value="1" @if(@Auth::user()->gender == 1) selected @endif>Male</option>
														<option value="2" @if(@Auth::user()->gender == 2) selected @endif>Female</option>
														<option value="3" @if(@Auth::user()->gender == 3) selected @endif>Transgender</option>
													</select>
												</div>
											</div>
											<div class="col-sm-6 col_block">
												<div class="form-group">
													<label for="gender">Marital Status</label>
													<select type="text" name="marital_staus" id="marital_staus" class="form-control" placeholder="">
														<option value="Married" @if(@Auth::user()->marital_status == 'Married') selected @endif>Married</option>
														<option value="Unmarried" @if(@Auth::user()->marital_status == 'Unmarried') selected @endif>Unmarried</option>
													</select>
												</div>
											</div>
											<div class="col-sm-6 col_block">
												<div class="form-group">
													<label for="phone">Phone</label>
													<input type="text" name="phone" value="{{@Auth::user()->phone}}" id="phone" class="form-control" placeholder=""/> 
												</div>
											</div>
											<div class="col-sm-6 col_block">
												<div class="form-group">
													<label for="phone">DOB</label>
													<input autocomplete="new-password" type="text" name="dob" value="{{@Auth::user()->dob}}" id="dob" class="form-control datepicker-3-ti" placeholder=""/> 
												</div>
											</div>
											<div class="col-sm-6 col_block">
												<div class="form-group">
													<label for="address">Address</label>
													<textarea style="height: 120px;" class="form-control" name="address" id="address">{{@Auth::user()->address}}</textarea> 
												</div><!-- .form-group end -->
											</div>
											<div class="col-sm-6 col_block">
												<div class="form-group">
													<label for="city">City</label>
													<input type="text" value="{{@Auth::user()->city}}" name="city" id="city" class="form-control" placeholder=""/> 
												</div>
											</div>
											<div class="col-sm-6 col_block">
												<div class="form-group">
													<label for="state">State</label>
													<input type="text" value="{{@Auth::user()->state}}" name="state" id="state" class="form-control" placeholder=""/> 
												</div>
											</div>
											<div class="col-sm-6 col_block">
												<div class="form-group">
													<label for="zipcode">Zip Code</label>
													<input type="text" value="{{@Auth::user()->zip}}" name="zipcode" id="zipcode" class="form-control" placeholder=""/> 
												</div> 
											</div>
											<div class="col-sm-6 col_block">
												<div class="form-group">
													<label for="country">Country</label>
													<input type="text" value="{{@Auth::user()->country}}"  name="country" id="country" class="form-control" placeholder=""/> 
												</div>
											</div>
											<div class="col-sm-12 col_block">
												<div class="form-group text-center">
													<input type="submit" id="editsubmit" class="form-control" value="Save">
												</div><!-- .form-group end --> 
											</div>
											<div class="clearfix"></div>
										</div><!-- .form-content end -->
									</div><!-- .left end -->
								</form><!-- #form-login end -->
								<div class="foot-msg">
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
<script>
jQuery(document).ready(function($){
	$(".popup-editprofile").each(function () { 
		var $this = $(this),
			popupBg = $this.find(".popup-bg"), 
			popupClose = $this.find(".popup-close");
		$(".popup-btn-profile").add(popupBg).add(popupClose).on("click", function (e) {
			e.preventDefault();  
			$(".popup-editprofile").toggleClass("viewed");
			$(".popup-preview-overlay-2").toggleClass("viewed");
			$("html").toggleClass("scroll-lock");
		});
	});
	
	$("#editsubmit").on("click", function(e){
		e.preventDefault();
		$('.se-pre-con').show();
		var formElem = $("#form-profile");
		console.log(formElem[0]);
		var formData = new FormData(formElem[0]);
		$("#form-profile :input").prop("disabled", true);
		$.ajax({
			url: "{{ route('dashboard.edit_myprofile') }}",
			dataType: 'json',
			type: 'POST',
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			processData: false,
			contentType: false,
			data: formData,
			success: function( data ){
				$('.se-pre-con').hide();
				//var obj = $.parseJSON(data);
				if (data.success) {
				 window.location.href = "{{url('/my-profile')}}";
				}else{
					alert('Please try again');
				}
			},
			error: function( jqXhr, textStatus, errorThrown ){
				$('.se-pre-con').hide();
				$('html, body').animate({scrollTop:0}, 'slow');
				$("#form-profile :input").prop("disabled", false);
				if(jqXhr.status === 422) {
					var errors = jqXhr.responseJSON;
					console.log( errors );
					if(typeof  errors.errors['firstname']  != "undefined"){
						$('.firstname-error').show();
						$('.firstname-error').html(errors.errors['firstname']);
						$('#firstname').addClass('error');
					}
					if(typeof  errors.errors['lastname']  != "undefined"){
						$('.lastname-error').show();
						$('.lastname-error').html(errors.errors['lastname']);
						$('#lastname').addClass('error');
					}
					if(typeof  errors.errors['email']  != "undefined"){
						$('.email-error').show();
						$('.email-error').html(errors.errors['email']);
						$('#email').addClass('error');
					}
				
				}
			}
		});
	});
	$(document).delegate('.verify_mobile', "click", function () {
		$('.se-pre-con').show();
		$.ajax({
			url: "{{ URL::to('/verifymobile') }}",
			dataType: 'json',
			type: 'GET',
			success: function( data ){
				$('.se-pre-con').hide();
				if (data.success) {
					$(".popup-mobileverify").toggleClass("viewed");
					$(".popup-preview-overlay-2").toggleClass("viewed");
					$("html").toggleClass("scroll-lock");
				}else{
					$('.mmail-msg').show();
					$('.mmail-msg').html('<p class="alert alert-danger">Please try again</p>');
						setTimeout(function() { $(".mmail-msg").hide(); }, 5000);
				}
			}
		});
	});
	$(document).delegate('.verify_myemail', "click", function () {
		$('.se-pre-con').show();
		$.ajax({
			url: "{{ URL::to('/verifyemail') }}",
			dataType: 'json',
			type: 'GET',
			success: function( data ){
				$('.se-pre-con').hide();
			
				if (data.success) {
					
					$('.mmail-msg').show();
					$('.mmail-msg').html('<p class="alert alert-success">Verification email sent successfully</p>');
					setTimeout(function() { $(".mmail-msg").hide(); }, 5000);
				}else{
					$('.mmail-msg').show();
					$('.mmail-msg').html('<p class="alert alert-danger">Please try again</p>');
						setTimeout(function() { $(".mmail-msg").hide(); }, 5000);
				}
			}
		});
	});
	
	$(".datepicker-3-ti").datepicker({
		dateFormat: 'dd/mm/yy',
		 yearRange: '-100:+0',
 changeMonth: true,
   changeYear: true
	}); 
	
		
});
</script>
@endsection