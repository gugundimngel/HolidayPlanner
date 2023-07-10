@extends('layouts.agent')
@section('title', 'Booking Detail')

@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Booking Detail</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Booking Detail</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<!-- Flash Message Start -->
					<div class="server-error">
						@include('../Elements/flash-message')
					</div>
					<!-- Flash Message End -->
				</div>
				<div class="col-md-12">
					<div class="card card-primary">
						 <div class="card-header">
							<h3 class="card-title">Passenger Information</h3>
						</div>
						<?php
						//echo '<pre>'; print_r(json_decode($fetchedData->bookingib_request));
						$bookingib_request = json_decode($fetchedData->bookingib_request);
						?>
						<div class="card-body">	
							<div class="row"> 
							<div class="col-sm-6"> 
									<div class="form-group"> 
										
										<b for="first_name">Email</b>
										<h5>{{@$bookingib_request->email}}</h5>
									</div>
								</div>
								<div class="col-sm-6"> 
									<div class="form-group"> 
										
										<b for="first_name">Phone</b>
										<h5>{{@$bookingib_request->phone}}</h5>
									</div>
								</div>
								<?php
								if(isset($bookingib_request->adulttitle)){
									$pes = $bookingib_request->adulttitle;
									for($ps =0;$ps<count($pes); $ps++){
								?>
								<div class="col-sm-12"> 
									<div class="form-group"> 
										<b for="first_name" class="col-sm-3">Passenger Name</b>
										<h5 class="col-sm-6">{{@$bookingib_request->adulttitle[$ps]}} {{@$bookingib_request->adultfirstname[$ps]}} {{@$bookingib_request->adultlastname[$ps]}} (Adult)</h5>
									</div>
								</div>
								
								<?php } } ?>
								<?php
								if(isset($bookingib_request->childtitle)){ 
									$pes = $bookingib_request->childtitle;
									for($ps =0;$ps<count($pes); $ps++){
								?>
								<div class="col-sm-12"> 
									<div class="form-group"> 
										<b for="first_name" class="col-sm-3">Passenger Name</b>
										<h5 class="col-sm-6">{{@$bookingib_request->childtitle[$ps]}} {{@$bookingib_request->childfirstname[$ps]}} {{@$bookingib_request->childlastname[$ps]}} (Child)</h5>
									</div>
								</div>
								
									<?php } } ?>
								<?php
								if(isset($bookingib_request->infanttitle)){ 
									$pes = $bookingib_request->infanttitle;
									for($ps =0;$ps<count($pes); $ps++){
								?>
								<div class="col-sm-12"> 
									<div class="form-group"> 
										<b for="first_name" class="col-sm-3">Passenger Name</b>
										<h5 class="col-sm-6">{{@$bookingib_request->infanttitle[$ps]}} {{@$bookingib_request->infantfirstname[$ps]}} {{@$bookingib_request->infantlastname[$ps]}} (Infant)</h5>
									</div>
								</div>
								
									<?php } } ?>								
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="card card-primary">
						 <div class="card-header">
							<h3 class="card-title">Ticket Detail</h3>
						</div>
						<div class="card-body">	
							<div class="row"> 
							<h3 class="card-title">Departure</h3>
								<?php
									//echo '<pre>'; print_r(json_decode($fetchedData->farequoteob_log));
									if(@$fetchedData->farequoteob_log != ''){
										$response = json_decode($fetchedData->farequoteob_log);
									if(isset($response->Response->Results->Segments[0])){
										$allflighdata = $response->Response->Results->Segments[0];
										
										for($fl =0;$fl<count($allflighdata);$fl++){
											?>
											<div class="col-md-1">
												<img src="{{URL::to('/public/img/airline/')}}/{{$allflighdata[$fl]->Airline->AirlineCode}}.gif" alt="">
											</div>
											<div class="col-md-2">{{$allflighdata[$fl]->Airline->AirlineName}}
												<br>
												{{$allflighdata[$fl]->Airline->AirlineCode}}-{{$allflighdata[$fl]->Airline->FlightNumber}}
											</div>
											<div class="col-md-3">{{$allflighdata[$fl]->Origin->Airport->CityName}}, {{$allflighdata[$fl]->Origin->Airport->CountryCode}} 
											<br>
											<strong>{{date('h:i', strtotime($allflighdata[$fl]->Origin->DepTime))}}</strong>
													<span class="date">{{date('D, d M Y', strtotime($allflighdata[$fl]->Origin->DepTime))}}</span>
													<span class="airport">{{$allflighdata[$fl]->Origin->Airport->AirportName}}  , {{$allflighdata[$fl]->Origin->Airport->Terminal}}</span>
											</div>
											<div class="col-md-3">
												{{$allflighdata[$fl]->Destination->Airport->CityName}}, {{$allflighdata[$fl]->Destination->Airport->CountryCode}}
													<strong>{{date('h:i', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</strong>
													<span class="date">{{date('D, d M Y', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</span>
													<span class="airport">{{$allflighdata[$fl]->Destination->Airport->AirportName}}, {{$allflighdata[$fl]->Destination->Airport->Terminal}}</span>
											</div>
											<?php
										}
										}
									}
								?>
								
							</div>
							<div class="row"> 
							
								<?php
									//echo '<pre>'; print_r(json_decode($fetchedData->farequoteob_log));
									if(@$fetchedData->farequoteib_log != ''){
										?>
										<h3 class="card-title">Return</h3>
										<?php
										$response = json_decode($fetchedData->farequoteib_log);
									if(isset($response->Response->Results->Segments[0])){
										$allflighdata = $response->Response->Results->Segments[0];
										
										for($fl =0;$fl<count($allflighdata);$fl++){
											?>
											<div class="col-md-1">
												<img src="{{URL::to('/public/img/airline/')}}/{{$allflighdata[$fl]->Airline->AirlineCode}}.gif" alt="">
											</div>
											<div class="col-md-2">{{$allflighdata[$fl]->Airline->AirlineName}}
												<br>
												{{$allflighdata[$fl]->Airline->AirlineCode}}-{{$allflighdata[$fl]->Airline->FlightNumber}}
											</div>
											<div class="col-md-3">{{$allflighdata[$fl]->Origin->Airport->CityName}}, {{$allflighdata[$fl]->Origin->Airport->CountryCode}} 
											<br>
											<strong>{{date('h:i', strtotime($allflighdata[$fl]->Origin->DepTime))}}</strong>
													<span class="date">{{date('D, d M Y', strtotime($allflighdata[$fl]->Origin->DepTime))}}</span>
													<span class="airport">{{$allflighdata[$fl]->Origin->Airport->AirportName}}  , {{$allflighdata[$fl]->Origin->Airport->Terminal}}</span>
											</div>
											<div class="col-md-3">
												{{$allflighdata[$fl]->Destination->Airport->CityName}}, {{$allflighdata[$fl]->Destination->Airport->CountryCode}}
													<strong>{{date('h:i', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</strong>
													<span class="date">{{date('D, d M Y', strtotime($allflighdata[$fl]->Destination->ArrTime))}}</span>
													<span class="airport">{{$allflighdata[$fl]->Destination->Airport->AirportName}}, {{$allflighdata[$fl]->Destination->Airport->Terminal}}</span>
											</div>
											<?php
										}
										}
									}
								?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection