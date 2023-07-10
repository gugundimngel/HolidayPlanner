@extends('layouts.admin-login')

@section('title', 'Admin Login')

@section('content')
	
	<div id="login">
		<aside>
			<figure>
				<a href="#"><img src="{!! asset('public/img/Frontend/img/logo-header.png') !!}" data-retina="true" alt="" class="ZapBooking"></a>
			</figure>
			  {{ Form::open(array('url' => 'admin/login', 'name'=>'admin_login')) }}
				<!--<div class="access_social">
					<a href="#0" class="social_bt facebook">Login with Facebook</a>
					<a href="#0" class="social_bt google">Login with Google</a>
					<a href="#0" class="social_bt linkedin">Login with Linkedin</a>
				</div>
				<div class="divider"><span>Or</span></div>-->
				<div class="form-group">
					<label>Email</label>
					<input type="email" class="form-control" placeholder="Email" id="email" name="email" value="{{ (Cookie::get('email') !='' && !old('email')) ? Cookie::get('email') : old('email')  }}" autocomplete="off" data-valid="required email" />
					<i class="icon_mail_alt"></i>
					@if ($errors->has('email'))
						<span class="custom-error" role="alert">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>
				<div class="form-group">
					<label>Password</label>
					<div class="hideShowPassword-wrapper" style="position: relative; display: block; vertical-align: baseline; margin: 0px;">					
					<input type="password" class="form-control hideShowPassword-field" name="password" id="password" value="{{ (Cookie::get('password') !='' && !old('password')) ? Cookie::get('password') : old('password')  }}" autocomplete="off" data-valid="required" style="margin: 0px; padding-right: 51.7344px;"><button type="button" role="button" aria-label="Show Password" title="Show Password" tabindex="0" class="my-toggle hideShowPassword-toggle-show" aria-pressed="false" style="position: absolute; right: 0px; top: 50%; margin-top: -15px; display: none;">Show</button></div>
					<i class="icon_lock_alt"></i>
				</div>
				<div class="clearfix add_bottom_30">
					<div class="checkboxes float-left">
						<label class="container_check">Remember me
						  <input type="checkbox" name="remember" id="remember" @if(Cookie::get('email') != '' && Cookie::get('password') != '') checked  @endif>
						  <span class="checkmark"></span>
						</label>
					</div>
				</div>
				<button type="submit" class="btn_1 rounded full-width">Sign In</button> 
				
			{{ Form::close() }}
			
		</aside>
	</div>
@endsection