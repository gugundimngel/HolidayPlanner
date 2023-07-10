@extends('layouts.frontend')
@section('title', @$seoDetails->meta_title)
@section('meta_title', '')
@section('meta_keyword', '')
@section('meta_description', '')
@section('bodyclass', 'homepage')
@section('pagespecificstyles')

	<?php
$paymentdta = \App\PaymentDetail::where('bookingid', $fetchedData->id)->first();
$discount =0;
if(@$paymentdta->discount_amount != 0){
	if($paymentdta->discount_type == 'percentage'){
		$discount = ($paymentdta->org_amount * $paymentdta->discount_amount/100);
	}else{
		$discount = $paymentdta->discount;
	}
}
$pp = round(@$paymentdta->org_amount - $discount);
?>


<script>
  gtag('event', 'conversion', {
      'send_to': 'AW-619001147/dJ91CKfG--0CELvqlKcC',
      'value': {{@$pp}},
      'currency': 'INR',
      'transaction_id': ''
  });
</script>
@endsection
@section('content')
<?php use App\Http\Controllers\Controller;

$booking = json_decode($fetchedData->booking_response);

?>
<section id="content">
			<div id="content-wrap">
				<!-- === Section Flat =========== -->
				<div class="section-flat single_sec_flat booking_confirm">
					<div class="section-content">
						<div class="container">
							<div class="row">
								<div class="col-sm-12">
									<div class="booking_confrm_title text-center">
										<h3>Booking Confirmation</h3>
									</div>
									<div class="booking_info">
										<div class="col-sm-2">
											<div class="booking_icon">
												<img src="{{URL::to('/html')}}/images/booking-success.png" alt="" />
											</div>
										</div>
										<div class="col-sm-5 brder_left">
											<div class="person_details">
											<?php $set = \App\Admin::where('id',1)->first();

											?>
												<h4>Dear <?php if(isset($booking->Response->Response->FlightItinerary->Passenger)){
												$pes = $booking->Response->Response->FlightItinerary->Passenger; ?>
												{{$pes[0]->Title}} {{$pes[0]->FirstName}} {{$pes[0]->LastName}}
												<?php
											} ?></h4>
												<p>Congratulations! Your Flight Booking is <b>
												@if(@$fetchedData->status == 1) SUCCESS @elseif(@$fetchedData->status == 2) FAILED @elseif(@$fetchedData->status == 6) NotConfirmed @else @endif</b><br>
												 Reference Number : {{$set->ref_prefix}}-{{@$fetchedData->id}}</p>
											</div>
										</div>
										<div class="col-sm-5">
											<div class="booking_thanks">
												<p>Thank-you for choosing Holiday Planner. Your Booking is <span>confirmed</span> and the E-Ticket has been mailed to you. Please carry a printout of your E-Ticket along with Passport (If required) to the Airline Check-in Counter.</p>
											</div>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="clearfix"></div>

									<div class="booking_confr_txt">
										<span>Confirmation Details has been sent to</span>
										<div class="row mail-msg" style="display:none;"><div class="col-md-12"></div></div>
									</div>
									<div class="booking_email_send">
										<div class="field_wd48 mr_rt4 email_field">
											<div class="form-group">
												<label>Email :</label>
												<input type="email" id="email" class="form-control" name="email"/>
												<input type="hidden" id="tcid" class="" value="{{base64_encode(convert_uuencode(@$fetchedData->id))}}" name="tcid"/>
												<a href="javascript:;" class="resend_btn resend_mail">Re-Send</a>
												<div class="clearfix"></div>
											</div>
										</div>
										<!--<div class="field_wd48 phone_field">
											<div class="form-group">
												<label>Phone :</label>
												<input type="text" class="form-control" id="phone" name="phone"/>
												<a href="javascript:;" class="resend_btn resend_phone">Re-Send</a>
												<div class="clearfix"></div>
											</div>
										</div>-->
										<div class="clearfix"></div>
									</div>
									<div class="row">
									<?php
									$tr = count($booking->Response->Response->FlightItinerary->Segments) -1;
									?>
										<div class="col-md-10 col-md-offset-1 col-sm-12">
											<hr class="hr_seperator"/>
											<div class="view_print_ticket">
												<iframe src="{{URL::to('/ticket')}}/{{base64_encode(convert_uuencode(@$fetchedData->id))}}" style="display:none;" name="frame"></iframe>
												<a href="javascript:;" onclick="frames['frame'].print()"><i class="fa fa-print"></i> Print E-Ticket</a>
												<a target="_blank" href="{{URL::to('/ticket')}}/{{base64_encode(convert_uuencode(@$fetchedData->id))}}"><i class="fa fa-eye"></i> View E-Ticket</a>
											</div>
											<div class="ticket_overview">

												<div class="ticket_head">
													<h4><i class="fa fa-plane fa-rotate-210"></i> {{$booking->Response->Response->FlightItinerary->Origin}} <i class="fa fa-arrow-right"></i> {{@$booking->Response->Response->FlightItinerary->Destination}} <span>{{date('D d/m/Y', strtotime(@$booking->Response->Response->FlightItinerary->Segments[0]->Origin->DepTime))}}</span> (Onward)</h4>
												</div>
												<div class="ticket_table">
													<table class="table">
														<thead>
															<tr>
																<th>Flight(s)</th>
																<th><i class="fa fa-plane fa-rotate-210"></i> Departure</th>
																<th><i class="fa fa-plane fa-rotate-140"></i> Arrival</th>
																<th><i class="fa fa-plane fa-rotate-210"></i> PNR</th>
																<th>Duration</th>
															</tr>
														</thead>
														<tbody>
															<?php
															if(isset($booking->Response->Response->FlightItinerary->Segments)){
																$ir = 0;
																$res = $booking->Response->Response->FlightItinerary;
																$countflighdata = count($res->Segments);
																$allflighdata = $res->Segments;
																for($fl =0;$fl<count($allflighdata);$fl++){
															?>
															<tr>
																<td>
																	<img src="{{URL::to('/public/img/airline/')}}/{{$allflighdata[$fl]->Airline->AirlineCode}}.gif" />
																	<small>{{$allflighdata[$fl]->Airline->AirlineCode}}-{{$allflighdata[$fl]->Airline->FlightNumber}}<br> @if($allflighdata[$fl]->Airline->AirlineCode == 'I5')
																		AirAsia
																	@else
																		{{$allflighdata[$fl]->Airline->AirlineName}}
																	@endif <br> @if(count($res->Segments) > 1)
																			<?php echo count($res->Segments)-1; ?> stop
																		@else
																			non-stop
																	@endif<br> {{$allflighdata[$fl]->Airline->FareClass}}</small>
																</td>
																<td><small>{{$allflighdata[$fl]->Origin->Airport->AirportName}} ({{$allflighdata[$fl]->Origin->Airport->AirportCode}}) {{$allflighdata[$fl]->Origin->Airport->CityName}}<br> {{date('d/m/Y H:i:s', strtotime($allflighdata[$fl]->Origin->DepTime))}}<br>
																Terminal {{$allflighdata[$fl]->Origin->Airport->Terminal}}</small></td>
																<td><small>{{$allflighdata[$fl]->Destination->Airport->AirportName}}  ({{$allflighdata[$fl]->Destination->Airport->AirportCode}}) {{$allflighdata[$fl]->Destination->Airport->CityName}}<br> {{date('d/m/Y H:i:s', strtotime($allflighdata[$fl]->Destination->ArrTime))}}<br> Terminal  {{$allflighdata[$fl]->Destination->Airport->Terminal}}</small></td>
																<td><small><b>{{$booking->Response->Response->PNR}}</b></small></td>
																<td><small><b><?php echo Controller::GetTimeduration($allflighdata[$fl]->Origin->DepTime, $allflighdata[$fl]->Destination->ArrTime); ?></b></small></td>
															</tr>
																<?php } } ?>
														</tbody>
														<tfoot>
															<tr>
																<td colspan="5"><b> Cabin: {{$booking->Response->Response->FlightItinerary->Segments[0]->CabinBaggage }}| Check-In: {{$booking->Response->Response->FlightItinerary->Segments[0]->Baggage}}</b></td>
															</tr>
														</tfoot>
													</table>
												</div>
												<?php
												$bookingib = json_decode($fetchedData->booking_response_ib);

												if($fetchedData->booking_response_ib != ''){
													if(isset($bookingib->Response->Response->FlightItinerary->Segments)){
														$trs = count($booking->Response->Response->FlightItinerary->Segments) -1;
												?>
												<div class="ticket_head">
													<h4><i class="fa fa-plane fa-rotate-324"></i> {{$bookingib->Response->Response->FlightItinerary->Origin}}  <i class="fa fa-arrow-right"></i> {{$bookingib->Response->Response->FlightItinerary->Destination}}<span>{{date('D d/m/Y', strtotime(@$bookingib->Response->Response->FlightItinerary->Segments[0]->Origin->DepTime))}}</span> (Return)</h4>
												</div>
												<div class="ticket_table">
													<table class="table">
														<thead>
															<tr>
																<th>Flight(s)</th>
																<th><i class="fa fa-plane fa-rotate-210"></i> Departure</th>
																<th><i class="fa fa-plane fa-rotate-140"></i> Arrival</th>
																<th><i class="fa fa-plane fa-rotate-210"></i> PNR</th>
																<th>Duration</th>
															</tr>
														</thead>
														<tbody>
														<?php
															$irib = 0;
																$ress = $bookingib->Response->Response->FlightItinerary;
																$countflighdataib = count($ress->Segments);
																$allflighdataib = $ress->Segments;
																for($flib =0;$flib<count($allflighdataib);$flib++){
															?>
															<tr>
																<td>
																	<img src="{{URL::to('/public/img/airline/')}}/{{$allflighdataib[$flib]->Airline->AirlineCode}}.gif" />
																	<small>{{$allflighdataib[$flib]->Airline->AirlineCode}}-{{$allflighdataib[$flib]->Airline->FlightNumber}}<br> @if($allflighdataib[$flib]->Airline->AirlineCode == 'I5')
																		AirAsia
																	@else
																		{{$allflighdataib[$flib]->Airline->AirlineName}}
																	@endif <br> @if(count($res->Segments) > 1)
																			<?php echo count($res->Segments)-1; ?> stop
																		@else
																			non-stop
																	@endif<br> {{$allflighdataib[$flib]->Airline->FareClass}}</small>
																</td>
																<td><small>{{$allflighdataib[$flib]->Origin->Airport->AirportName}} ({{$allflighdataib[$flib]->Origin->Airport->AirportCode}}) {{$allflighdataib[$flib]->Origin->Airport->CityName}}<br> {{date('d/m/Y H:i:s', strtotime($allflighdataib[$flib]->Origin->DepTime))}}<br> Terminal  {{$allflighdataib[$flib]->Origin->Airport->Terminal}}</small></td>
																<td><small>{{$allflighdataib[$flib]->Destination->Airport->AirportName}}  ({{$allflighdataib[$flib]->Destination->Airport->AirportCode}}) {{$allflighdataib[$flib]->Destination->Airport->CityName}}<br> {{date('d/m/Y H:i:s', strtotime($allflighdataib[$flib]->Destination->ArrTime))}}<br> Terminal  {{$allflighdataib[$flib]->Destination->Airport->Terminal}}</small></td>
																<td><small><b>{{$bookingib->Response->Response->PNR}}</b></small></td>
																<td><small><b><?php echo Controller::GetTimeduration($allflighdataib[$flib]->Origin->DepTime, $allflighdataib[$flib]->Destination->ArrTime); ?></b></small></td>
															</tr>
																<?php }  ?>
														</tbody>
														<tfoot>
															<tr>
																<td colspan="5"><b> Cabin: {{@$bookingib->Response->Response->FlightItinerary->Segments[0]->CabinBaggage }}| Check-In: {{@$bookingib->Response->Response->FlightItinerary->Segments[0]->Baggage}}</b></td>
															</tr>
														</tfoot>
													</table>
												</div>
												<?php }  } ?>
												<div class="ticket_head">
													<h4>Passenger Details</h4>
												</div>
												<div class="ticket_table">
													<table class="table">
														<thead>
															<tr>
																<!--<th>Sr. No.</th>-->
																<th>Passenger(s) Name/ Type</th>
																<th>Extra Baggage/ Meal</th>
					@if(isset($bookingib->Response->Response->FlightItinerary->Passenger))											<th>Extra Baggage/ Meal(R).</th>@endif
															</tr>
														</thead>
														<tbody>
														<?php
														if(isset($booking->Response->Response->FlightItinerary->Passenger)){
															$pes = $booking->Response->Response->FlightItinerary->Passenger;
															$pesib = array();
															if(isset($bookingib->Response->Response->FlightItinerary->Passenger)){
															$pesib = $bookingib->Response->Response->FlightItinerary->Passenger;
															}
															$ts = 1;
															for($ps =0;$ps<count($pes); $ps++){
																if($pes[$ps]->PaxType == 1){ $paxtype = 'Adult'; }
																else if($pes[$ps]->PaxType == 2){ $paxtype = 'Child'; }else{
																	$paxtype = 'Infant';
																}
														?>
															<tr>
																<!--<td>{{$ts}}</td>-->
																<td>{{$pes[$ps]->Title}} {{$pes[$ps]->FirstName}} {{$pes[$ps]->LastName}} ({{@$paxtype}})

																@if(isset($pes[$ps]->SeatDynamic) || isset($pesib[$ps]->SeatDynamic))
																 <br>
																<?php 	$seatype = ''; ?>
																@if(isset($pes[$ps]->SeatDynamic))
																	@foreach($pes[$ps]->SeatDynamic as $setli)
																		<?php
																		$seatype .= $setli->Origin .' - '. $setli->Destination.': '.$setli->Code.', ';
																		?>
																	@endforeach
																	@endif
																	@if(isset($bookingib->Response->Response->FlightItinerary->Passenger))
																		@if(isset($pesib[$ps]->SeatDynamic))
																		@foreach($pesib[$ps]->SeatDynamic as $setli)
																			<?php
																			$seatype .= $setli->Origin .' - '. $setli->Destination.': '.$setli->Code.', ';
																			?>
																		@endforeach
																	@endif
																	@endif
																	<?php echo 'Seat Preference: <b>'.rtrim($seatype, ', ').'</b>'; ?>

																@endif
																</td>
																<td>
																@if($paxtype != 'Infant')

																	@if(isset($pes[$ps]->Baggage))

																		@foreach($pes[$ps]->Baggage as $blis)
																		@if($blis->Weight !=0)
																		Extra Baggage: {{$blis->Weight}}kg
																	@else

																	@endif
																		@endforeach
																			<br>
																	@else

																	@endif

																		<?php $mealo = ''; ?>
																		@if(isset($pes[$ps]->MealDynamic))
																			Meal:
																			@foreach(@$pes[$ps]->MealDynamic as $mlis)
																			<?php

																			$mealo .= $mlis->Origin .' - '. $mlis->Destination.': '.$mlis->AirlineDescription.'<br> '; ?>
																			@endforeach
																		@else

																		@endif

																		<?php echo rtrim($mealo, ', '); ?>
															@else

																@endif
															</td>
																@if(isset($bookingib->Response->Response->FlightItinerary->Passenger))
																<td>
																@if($paxtype != 'Infant')

																	@if(isset($pesib[$ps]->Baggage))
																		Extra Baggage:
																		@foreach($pesib[$ps]->Baggage as $blis)
																		@if($blis->Weight !=0)
																		Extra Baggage: {{$blis->Weight}}kg
																	@else

																	@endif
																		@endforeach
																		<br>
																	@else

																	@endif


																		<?php $mealos = ''; ?>
																		@if(isset($pesib[$ps]->MealDynamic))
																			Meal:
																			@foreach(@$pesib[$ps]->MealDynamic as $mlis)
																			<?php

																			$mealos .= $mlis->Origin .' - '. $mlis->Destination.': '.$mlis->AirlineDescription.'<br> '; ?>
																			@endforeach
																		@else

																		@endif

																		<?php echo rtrim($mealos, ', '); ?>
															@else

																@endif
																</td>
																@endif
															</tr>


															<?php $ts++; } } ?>
														</tbody>
													</table>
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
<script>
jQuery(document).ready(function($){
	$(".resend_mail").on("click", function(e){

		var mail = $('#email').val();
		if(mail != ''){
		var tcid = $('#tcid').val();
		$('#email').val('');
		$('#email').prop('disabled', true);
		$('.resend_mail').prop('disabled', true);
		$('.mail-msg').hide();
		$.ajax({
			url: "{{ URL::to('/emailticket') }}/"+tcid,
			dataType: 'json',
			type: 'GET',
			data: {email:mail},
			success: function( data ){
				$('#email').val('');
				$('#email').prop('disabled', false);
		$('.resend_mail').prop('disabled', false);
				if (data.success) {
					$('.mail-msg').show();
					$('.mail-msg').html('<p class="alert alert-success">Mail Sent Successfully</p>');
				}else{
					$('.mail-msg').show();
					$('.mail-msg').html('<p class="alert alert-danger">Please try again</p>');
				}
			}
		});
	}else{
				alert('Please enter Email ID');
			}
	});
	$(".resend_phone").on("click", function(e){

		var mail = $('#phone').val();
			if(mail != ''){
			var tcid = $('#tcid').val();
			$('#phone').val('');
			$('#phone').prop('disabled', true);

			$('.mail-msg').hide();
				 $.ajax({
					url: "{{ URL::to('/phoneticket') }}/"+tcid,
					dataType: 'json',
					type: 'GET',
					data: {phone:mail},
					success: function( data ){
						$('#phone').val('');
						$('#phone').prop('disabled', false);
						$('.resend_phone').prop('disabled', false);
						if (data.success) {
							$('.mail-msg').show();
							$('.mail-msg').html('<p class="alert alert-success">SMS Sent Successfully</p>');
						}else{
							$('.mail-msg').show();
							$('.mail-msg').html('<p class="alert alert-danger">Please try again</p>');
						}
					}
				});
			}else{
				alert('Please enter Phone no');
			}
	});
});
</script>
@endsection