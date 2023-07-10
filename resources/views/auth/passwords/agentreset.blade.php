@extends('layouts.reset')
@section('title', 'Reset Password')

@section('content')
<section id="content">
	<div id="content-wrap">
		<!-- === Section Flat =========== -->
		<div class="section-flat single_sec_flat viewprint_page" style="background:#e8e8e8;">      
			<div class="section-content" style="padding:0px 0px 40px;">
				<div class="inner_travelagent">
					<div class="container">
						<div class="row"> 
							<div class="col-sm-12">	 
								<div class="cus_breadcrumb">
									<ul>
										<li class="active"><a href="#">Home</a></li>
										<li><span><i class="fa fa-angle-right"></i></span></li>
										<li><a href="#">Reset Password</a></li>
									</ul>
								</div>   
							</div>
							<div class="clearfix"></div>
						</div>  
					</div>	 
					<div class="view_print_form">
						<div class="container">
							<div class="row"> 
								<form method="POST" action="{{ route('agent.password.update') }}">
								 @csrf
								  <input type="hidden" name="token" value="{{ $token }}">
									<div class="col-sm-6 col-xs-12 login_form_1 custom_login_form col-sm-offset-3">
										<h3>{{ __('Reset Password') }}</h3>
										<div class="form-group">
											<input type="hidden" name="email" class="form-control" placeholder="{{ __('E-Mail Address') }}" value="{{@$_GET['email']}}" />
											@if ($errors->has('email'))
												<span class="invalid-feedback" role="alert">
													<strong>{{ $errors->first('email') }}</strong>
												</span>
											@endif
										</div> 
										<div class="form-group">
											<input type="password"name="password"  class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" value="" required >
											@if ($errors->has('password'))
												<span class="invalid-feedback" role="alert">
													<strong>{{ $errors->first('password') }}</strong>
												</span>
											@endif
										</div>
										<div class="form-group">
											
											<input id="password-confirm" placeholder="{{ __('Confirm Password') }}" type="password" class="form-control" name="password_confirmation" required>
										</div>
										<div class="form-group">
											<input type="submit" class="btnSubmit" value="{{ __('Reset Password') }}" />
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
</section>	

@endsection