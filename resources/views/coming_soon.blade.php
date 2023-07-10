@extends('layouts.frontend')
@section('title', 'Coming Soon')
@section('content')

<section id="content">
	<div id="content-wrap">
		<!-- === Section Flat =========== -->
		<div class="section-flat single_sec_flat" style="background:#e8e8e8;">      
			<div class="section-content">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">	 
							<div class="inner_comingsoon">
								<div class="comingsoon_whitebg"> 
									<div class="row">
										<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">	
											<h3>Coming Soon!</h3>
											<p>This site is under construction, so we will be meet soon.</p>
											<div class="coming_soon_img">
												<img src="{!! asset('public/images/coming-soon.png') !!}" class="img-responsive" alt=""/>
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
	</div>	
</section>

@endsection