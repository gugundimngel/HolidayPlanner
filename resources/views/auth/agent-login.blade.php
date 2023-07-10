@extends('layouts.agent-login')
@section('title', 'Travel Agents')
@section('content')

<!-- Content
		============================================= -->
<section id="content">
	<div id="content-wrap">
		<!-- === Section Flat =========== -->
		<div class="section-flat single_sec_flat travelagent_page" style="background:#e8e8e8;">
			<div class="section-content">
				<div class="custom_banner travelagent_bg">
					<div class="container">
						<div class="agent_form">
							{{ Form::open(array('url' => 'agent/login', 'name'=>'admin_login', 'autocomplete'=> 'off')) }}
							<h1><i class="fa fa-lock" aria-hidden="true"></i> Login</h1>

							<div class="inner_form_field">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fas fa-user-tie"></i>
									</div>
									<input autocomplete="off" type="text" name="email" value="{{ (Cookie::get('email') !='' && !old('email')) ? Cookie::get('email') : old('email')  }}" class="form-control" placeholder="Username" />
									@if ($errors->has('email'))
									<span class="custom-error" role="alert">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
									@endif
								</div>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-key icon"></i>
									</div>
									<input value="{{ (Cookie::get('password') !='' && !old('password')) ? Cookie::get('password') : old('password')  }}" autocomplete="off" type="Password" name="password" class="form-control" placeholder="password" />
								</div>
								<div class="checkbox">
									<label><input name="remember" @if(Cookie::get('email') !='' && Cookie::get('password') !='' ) checked @endif type="checkbox" value="" /> Remember me</label>
								</div>
								<input type="submit" class="btn submit_btn" name="submit" value="Login" />
								<div class="footer">
									<p>Don't have an Account! <a href="{{route('agent-signup.index')}}">Sign Up Here</a></p>
									<a href="#">Forgot Password?</a>
								</div>
							</div>
							{{ Form::close() }}
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>

@endsection