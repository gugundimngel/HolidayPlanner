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
									<div class="inner_notfound">
										
										<div class="found_whitebg">
											<div class="row">
												<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">	
													<img src="{{URL::to('/html')}}/images/plane-img.png" class="img-responsive" alt=""/>
													<h3>{{$message}}</h3>
													
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