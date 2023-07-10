@extends('layouts.frontend')
@section('title', 'Error')
@section('meta_title', '')
@section('meta_keyword', '')
@section('meta_description', '')
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
													<h4>There is something problem in system. please contact our support.</h4>
													<a href="tel:+917969224444">(+91)-7969224444 </a>
												
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