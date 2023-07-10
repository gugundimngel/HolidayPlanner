@extends('layouts.frontend')
@section('title', 'FAQ')
@section('content')

<!-- Content
		============================================= -->
<section id="content">
	<div id="content-wrap">
		<!-- === Section Flat =========== -->
		<div class="section-flat single_sec_flat contact_page" style="background:#e8e8e8;">      
			<div class="section-content">
				<div class="custom_banner">
					<div class="container">
						<div class="row">   
							<div class="col-sm-12">
								<div class="banner_txt">
									<div class="title">
										 <h3>FAQ</h3>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="row"> 
						<div class="inner_contact">	  
							<div class="col-sm-12">	 
								<div class="cus_breadcrumb">
									<ul>
										<li class="active"><a href="#">Home</a></li>
										<li><span><i class="fa fa-angle-right"></i></span></li>
										<li><a href="#">FAQ</a></li>
									</ul>
								</div> 
							</div>	 
							<div class="clearfix"></div>
							<div class="col-sm-12 cus_collpse">
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="heading1">
											<h4 class="panel-title">
												<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
												1.  For domestic sectors, which airlines are offered as Full Service airlines?
												</a>
											</h4>
										</div>
										<div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
											<div class="panel-body">
												  <p>Jet Airways (9W),  Air India (AI) and Air Vistara (UK) are offered as full service airlines. They offer full services including free in-flight meals.</p>
											</div> 
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="heading2">
											<h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
													2.  For domestic sectors, which airlines are offered as "Low Cost Carriers"?
												</a>
											</h4>
										</div>
										<div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
											<div class="panel-body">
												<ul>
													<li>Low Cost Carriers presently include SpiceJet (SG),  IndiGo (6E), GoAir (G8) and Air Asia(I5)</li>
													<li>Low cost Carriers are known for their lower fares and the exclusion of services such as free in-flight meals.</li>
												</ul>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="heading3">
											<h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
													3.  What is an airline PNR Number?
												</a>
											</h4>
										</div>
										<div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
											<div class="panel-body">
												<p>An airline PNR is the Passenger Name Record, and is the reference for the particular booking that is logged in the Airline Reservation System. The airlines will be able to assist you with the help of this number.</p>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="heading4">
											<h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
													4.  What is meant by direct flights?
												</a>
											</h4>
										</div>
										<div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
											<div class="panel-body">
												<ul>
													<li>Direct Flights are where two cities are connected by a single aircraft. Thus flights with none, one or more intermediate stops, but with no change of aircraft are known as direct flights.</li>
													<li>Direct Non-stop flights are generally the shortest in duration followed by direct flights with stops.</li>
												</ul>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="heading5">
											<h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false" aria-controls="collapse5">
													5.  What are indirect flights?
												</a>
											</h4>
										</div>
										<div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
											<div class="panel-body">
												<p>Indirect flights are those where transit via intermediate cities are involved. Indirect flights involve change of aircraft. No break of journey is permitted.</p>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="heading6">
											<h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="false" aria-controls="collapse6">
													6.  What are stopovers?
												</a>
											</h4>
										</div>
										<div id="collapse6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
											<div class="panel-body">
												<p>If the duration of transit is longer than 48 hours and thus involving a break in journey, is termed a stopover. The cheapest international fares restrict en route stopovers. Higher fare levels may permit stopovers.</p>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="heading7">
											<h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse7" aria-expanded="false" aria-controls="collapse7">
													7.  Can I make a group booking through your site?
												</a>
											</h4>
										</div>
										<div id="collapse7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading7">
											<div class="panel-body">
												<p>At the moment, a maximum of 7 people can be included in the same ticket. For making a bulk or group booking, contact airlines.</p>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="heading8">
											<h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse8" aria-expanded="false" aria-controls="collapse8">
													8.  Can I book and hold a reservation and pay later?
												</a>
											</h4>
										</div>
										<div id="collapse8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading8">
											<div class="panel-body">
												<p>No. Hold reservation is not possible through our website.</p>
											</div>
										</div>     
									</div> 
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>	
				</div>	
			</div>	
		</div>	
	</div>	
</section>	

@endsection