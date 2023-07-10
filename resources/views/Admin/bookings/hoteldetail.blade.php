@extends('layouts.admin')
@section('title', 'Hotel Booking Detail')

@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Hotel Booking Detail</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Hotel Booking Detail</li>
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
				<div class="col-md-8">
				<div class="card card-primary profile_info">
						<div class="card-header profile_header">  
							<h3 class="card-title">View Hotel Booking Details</h3>
						</div> 
						<?php
						//echo '<pre>'; print_r(json_decode($fetchedData->bookingib_request));
						$bookingib_request = json_decode($fetchedData->booking_request);
						$booking_response = json_decode($fetchedData->booking_response);
						//echo '<pre>'; print_r($booking_response); die;
						$hoteldetail = \App\HotelList::where('hotel_code', $fetchedData->hotel_code)->first();
						 $toroom = 0;
									$adults = 0;
								?>
								@foreach($bookingib_request->adulttitle as $key => $roomdetail)
								<?php 
									$adults += count($roomdetail);
								$toroom++; ?>
								@endforeach
								<?php 
									$child = 0;
								?>
								
						<div class="card-body">	
							<div class="row">
								<div class="col-sm-12">
									<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th>Hotel Name</th>
													<th>NoOfRooms</th>
													<th>Check In Date</th>
													<th>Check Out Date</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?php echo @$hoteldetail->hotel_name.', '.@$hoteldetail->city; ?></td>
													<td>{{$toroom}}</td>
													<td>{{date('h:i A, d m Y', strtotime($fetchedData->checkin))}}</td>
													<td>{{date('h:i A, d m Y', strtotime($fetchedData->checkout))}}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
				</div>
					<div class="card card-primary profile_info">
						<div class="card-header profile_header">  
							<h3 class="card-title">Book Details</h3>
						</div> 
						
						<div class="card-body">	
							<div class="row">
								<div class="col-sm-12">
									<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th>HotelBooking Status</th>
													<th>Booking Id</th>
													<th>Booking Ref No</th>
													
													
													
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
													<?php if(isset($booking_response->booking_status)){
														echo $booking_response->booking_status;
													}else{
														?>
														Pending
														<?php
													} ?>
													</td>
													<td>{{@$fetchedData->booking_id}}</td>
													<td>{{@$fetchedData->booking_reference}}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
				</div>
					<div class="card card-primary profile_info">
						<div class="card-header profile_header">  
							<h3 class="card-title">Contact Information</h3>
						</div> 
						<div class="card-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="table-responsive">
										<table class="table">
											<tbody>
												<tr>
													<th>Email</th>
													<td>{{@$fetchedData->email}}</td>
												</tr>
												
											</tbody>
										</table>
									</div>
								</div>	
								<div class="col-sm-6">
									<div class="table-responsive">
										<table class="table">
											<tbody>
												<tr>
													<th>Mobile</th>
													<td>{{@$fetchedData->mobile}}</td>
												</tr>
											</tbody>   
										</table>
									</div>
								</div>
							</div>
							
						</div>
					</div>
					
					
							<?php
							//echo '<pre>'; print_r($bookingib_request);
								$adultfirstname = $bookingib_request->firstname;
								$adultlastname = $bookingib_request->lastname;
								
							?>
							@foreach($bookingib_request->adulttitle as $key => $roomdetail)
							<?php //print_r(); ?>
								<div class="card card-primary profile_info">
						<div class="card-header profile_header">  
							<h3 class="card-title">Room {{$key}} Passenger Details</h3>
						</div> 
						<div class="card-body">
							<div class="row">
									<div class="col-sm-12">
										
										<div class="table-responsive">
											<table class="table">
												<thead>
													<tr>
														<th>Title</th>
														<th>First Name</th>
														<th>Last Name</th>
														<th>Type</th>
														
													</tr>
												</thead>
												<tbody>
												@foreach($roomdetail as $keys => $roompax)
												
													<tr>
														<th><?php echo $roompax; ?></th>
														<td><?php echo $adultfirstname->$key[$keys]; ?></td>
														<td><?php echo $adultlastname->$key[$keys]; ?></td>
														<td><?php echo 'Adult'; ?></td>
													</tr>
													@endforeach	
													<?php
													if(isset($bookingib_request->childtitle->$key)){
														$childfirstname = $bookingib_request->childfirstname->$key;
														$childlastname = $bookingib_request->childlastname->$key;
														$childtitle = $bookingib_request->childtitle->$key;
														
													?>
												@foreach($childtitle as $keyss => $croompax)
												
													<tr> 
														<th><?php echo @$croompax; ?></th>
														<td><?php echo @$childfirstname[$keyss]; ?></td>
														<td><?php echo @$childlastname[$keyss]; ?></td>
														<td><?php echo 'Child'; ?></td>
													</tr>
													@endforeach	
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							
						</div>
					</div>							
							@endforeach								
								
							
				</div>
				<div class="col-md-4">
					<div class="card card-primary profile_info">
						<div class="card-header profile_header">  
							<h3 class="card-title">Basic Details</h3>
						</div> 
						<div class="card-body">
							<div class="row">
								<table class="table table-bordered ">
                    <tbody>
                        <tr>
                            <td class="warning"><b>ID</b></td>
                            <td>{{$fetchedData->id}}</td>
                        </tr>
                        <tr>
                            <td class="warning"><b>Entry Date</b></td>
                            <td>{{date('h:i A, d m Y', strtotime($fetchedData->created_at))}}</td>
                        </tr>
                        <tr>
                            <td class="warning"><b>Update Date</b></td>
                            <td>{{date('h:i A, d m Y', strtotime($fetchedData->updated_at))}}</td>
                        </tr>
                       
                        <tr>
                            <td class="warning"><b>Booking ID</b></td>
                            <td>{{$fetchedData->booking_id}}</td>
                        </tr>
                       
                        <tr>
                            <td class="warning"><b>Booking Status</b></td>
                            <td>@if($fetchedData->status == 1)
												Success
											@elseif($fetchedData->status == 2)
												Failed
											@else
												Pending
											@endif</td>
                        </tr>
                    </tbody>
                </table>
							</div>
						</div>
					</div>
					
					<div class="card card-primary profile_info">
						<div class="card-header profile_header">  
							<h3 class="card-title">Fare Details </h3>
						</div> 
						<div class="card-body">
							<div class="row">
								<table class="table table-bordered ">
                    <tbody>
                        <tr> 
                            <td class="warning"><b>Base Price</b></td>
                            <td>₹ {{$fetchedData->paymentdetail->base_total}}</td>
                        </tr> 
						<tr> 
                            <td class="warning"><b>Tax/Fee</b></td>
                            <td>₹ {{$fetchedData->paymentdetail->service_fee}}</td>
                        </tr> <tr> 
                            <td class="warning"><b>Amount</b></td>
                            <td>₹ {{$fetchedData->paymentdetail->amount}}</td>
                        </tr>
                     
                       
                       
                    </tbody>
                </table>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</section>
</div>
@endsection