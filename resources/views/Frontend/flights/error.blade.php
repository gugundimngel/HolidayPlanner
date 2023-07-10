@extends('layouts.frontend')
@section('title', @$seoDetails->meta_title)
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
													@if (\Session::has('error'))
														
																<p>{!! \Session::get('error') !!}</p>
															
													@endif
													<a href="{{URL::to('/')}}" class="goback">Go Back</a>
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