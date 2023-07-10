@extends('layouts.frontend')
@section('title', 'Under Construction')
@section('content')

<!-- Content
		============================================= -->
<section id="content">
	<div id="content-wrap">
		<!-- === Section Flat =========== -->
		<div class="section-flat single_sec_flat" style="background:#e8e8e8;">      
			<div class="section-content">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">	 
							<div class="inner_construct">
								<div class="construct_whitebg">
									<div class="row">
										<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">	
											<h3>Page Under Construction</h3>
											<p>Our team is working hard to get this page up!</p>
											<img src="{!! asset('public/images/construction_img.png') !!}" class="img-responsive" alt=""/>
											<a href="javascript:;" class="goback">Contact us</a>
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