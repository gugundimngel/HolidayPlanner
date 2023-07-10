@extends('layouts.frontend')
@section('title', 'Dashboard')
@section('content')
<section id="content"> 
			<div id="content-wrap">
				<!-- === Section Flat =========== -->
				<div class="section-flat single_sec_flat profile_sec dashboard_inner">      
					<div class="section-content">
						<div class="container">
							<div class="row">
								<div class="col-sm-12">	
									<div class="cus_breadcrumb">
										<ul>
											<li class="active"><a href="#">My Account</a></li>
											<li><span><i class="fa fa-angle-right"></i></span></li>
											<li><a href="#">Login Details</a></li>
										</ul>
									</div>	
								</div>
								<form class="profile_form custom_form">
									<div class="col-sm-3">
										@include('../Elements/Frontend/navigation')
									</div>	
									<div class="col-sm-9">	
										<div class="inner_content">
											<div class="profile_component">
												<div class="profile_header">
													<div class="pro_title">
														<h3>Login Details</h3>
														<p>Manage your email address mobile number and password</p>
													</div>
												</div>
												<div class="profile_list">
													<ul>
														<li><span class="span_label">Mobile Number</span><span class="span_value">+91- {{Auth::user()->phone}}</span> <a href="javascript:;" class="verified_txt">@if(Auth::user()->mobile_verify_status == 1) <i class="fa fa-check"></i> Verified @else <i class="fa fa-plus"></i> Verify @endif </a></li>
														<li><span class="span_label">Email</span><span class="span_value">{{Auth::user()->email}}</span> <a href="javascript:;" class="verified_txt">@if(Auth::user()->email_verify_status == 1) <i class="fa fa-check"></i> Verified @else <i class="fa fa-plus"></i> Verify @endif</a></li>
														<li><span class="span_label">Password</span><span class="span_value"> ......</span> <a href="javascript:;" class="popup-btn-chngpassword">Change Password</a></li>
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
		
		<div class="popup-preview popup-preview-2 popup-changepassword popup-cusprofile">
		<div class="popup-bg"></div>
	
		<div class="container">  
			<div class="row">
				<div class="col-md-8 col-md-offset-2"> 
					<div class="popup-content">
						<div class="block-content">
							<div class="block-title">
								<h3>Change Password?</h3>
							</div><!-- .block-title end -->
							<div class="content">
								<form id="form-profile" class="" action="{{URL::to('/change_password')}}" method="post">
									<div class="left">
										<div class="form-content">
											<div class="col-sm-12 col_block">
												<div class="form-group">
													<label for="oldpassword">Old Password</label>
													<input type="password" name="old_password" id="oldpassword" class="form-control" placeholder=""/>
													<span style="display:none;" class="help-block oldpass-error">
													<strong></strong>
												</span> 
												</div>
												<div class="form-group">
													<label for="newpassword">New Password</label>
													<input type="password" name="password" id="newpassword" class="form-control" placeholder=""/>
													<div class="pass_show_hide">
														<a href="javascript:;"><i class="fa fa-eye"></i></a>
													</div>
													<span style="display:none;" class="help-block password-error">
													<strong></strong>
												</span>
												</div>
												<div class="form-group">
													<label for="confirmpassword">Confirm New Password</label>
													<input type="password" name="password_confirmation" id="confirmpassword" class="form-control" placeholder=""/>
													<div class="pass_show_hide">
														<a href="javascript:;"><i class="fa fa-eye"></i></a>
													</div>
													<span style="display:none;" class="help-block passwordcon-error">
													<strong></strong>
												</span>
												</div>
												<div class="form-group text-center">
													<input type="submit" class="form-control" id="changepwd" value="Update">
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
	jQuery(document).ready(function(){
		$(".popup-changepassword").each(function () { 
		var $this = $(this), 
			popupBg = $this.find(".popup-bg"), 
			popupClose = $this.find(".popup-close");
		$(".popup-btn-chngpassword").add(popupBg).add(popupClose).on("click", function (e) {
			e.preventDefault();  
			$(".popup-changepassword").toggleClass("viewed");
			$(".popup-preview-overlay-2").toggleClass("viewed");
			$("html").toggleClass("scroll-lock");
		});
	}); 
	
	$("#changepwd").on("click", function(e){
				e.preventDefault();
		
		 var formElem = $("#form-profile");
		console.log(formElem[0]);
		var formData = new FormData(formElem[0]);
		$("#form-profile :input").prop("disabled", true);
		$.ajax({
			url: "{{ route('change_password') }}",
			dataType: 'json',
			type: 'POST',
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			processData: false,
			contentType: false,
			data: formData,
			success: function( data ){
				$('.loading').hide();
				//var obj = $.parseJSON(data);
				if (data.success) {
				 location.reload();
				}else{
					$("#form-profile :input").prop("disabled", false);
						$('.oldpass-error').show();
						$('.oldpass-error').html(data.error);
						$('#oldpassword').addClass('error');
				}
			},
			error: function( jqXhr, textStatus, errorThrown ){
				$("#form-profile :input").prop("disabled", false);
				if(jqXhr.status === 422) {
					var errors = jqXhr.responseJSON;
					console.log( errors );
					if(typeof  errors.errors['old_password']  != "undefined"){
						$('.oldpass-error').show();
						$('.oldpass-error').html(errors.errors['old_password']);
						$('#oldpassword').addClass('error');
					}
					if(typeof  errors.errors['password']  != "undefined"){
						$('.password-error').show();
						$('.password-error').html(errors.errors['password']);
						$('#newpassword').addClass('error');
					}
					if(typeof  errors.errors['password_confirmation']  != "undefined"){
						$('.passwordcon-error').show();
						$('.passwordcon-error').html(errors.errors['password_confirmation']);
						$('#confirmpassword').addClass('error');
					}
					
					
				
				}
			}
		});
	});
	});
	</script>
@endsection