@extends('layouts.frontend')
@section('bodyclass', 'homepage')
@section('content')
<section id="content">
			<div id="content-wrap">
				<!-- === Section Flat =========== -->
				<div class="section-flat single_sec_flat" style="background:#e8e8e8;">      
					<div class="section-content">
						<div class="container">
							<div class="row">
								<div class="col-sm-12">	 
									<div class="success_style">
										<div class="success_whitebg">
											<div class="row">
												<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">	
													<img src="{{URL::to('')}}/images/plane-img.png" class="img-responsive" alt=""/>
													<h3>Reset Password Successfully</h3>
													<p>Please login to access your account.</p>
												</div>
											</div>
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