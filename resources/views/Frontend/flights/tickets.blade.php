<!DOCTYPE html>
<html lang="en-US">
<head>	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<style>div.breakNow {page-break-after:always; }</style>
</head>
<body class="invoice_template">
<div class="inv-template"> 
	<?php $set = \App\Admin::where('id',1)->first(); ?>
<?php use App\Http\Controllers\Controller;
 
foreach($explode as $exp){
$fetchedData = \App\BookingDetail::where('id',$exp)->with(['user'])->first();

?>
<?php $booking = json_decode($fetchedData->booking_response); 
if(isset($booking->Response->Response->FlightItinerary)){ 
		$bookingib = json_decode($fetchedData->booking_response_ib);
		?>
<div style="border: 1px solid #89ad3e;padding: 30px;max-width: 1140px;width: 100%;margin: 0px auto;padding-left: 15px;padding-right: 15px;font-family: Verdana, Geneva, Tahoma, sans-serif">
		<div style="background:#f1f1f1;padding: 10px;border:1px solid #ddd;border-radius:10px;">
			<div style="width:40%; float:left; color:#214a93">
				<div style="width:100%;font-size:24px;">
					<strong style="color:#214a93;">E-Ticket</strong>
				</div>
				<span style="display:block;"><b style="color:#214a93;">{{$set->ref_prefix}} Booking ID : </b> {{$set->ref_prefix}}-{{@$fetchedData->id}}</span>
				<span style="display:block;"><b style="color:#214a93;">Booking Date : </b> {{date('D d/m/Y', strtotime(@$fetchedData->created_at))}}</span>
				<span style="display:block;"><b style="color:#214a93;">Ticket No. : </b> {{$booking->Response->Response->PNR}}</span>
			</div>  
			<div style="width:20%;float:left;">
				<!-- <h4 style="color:#214a93;font-size:20px;text-align:center;margin:0px;font-weight:normal;"> SUCCESS</h4> -->
				<img style="width: 140px;margin: auto;display: block;" src="{{URL::to('/')}}/html/images/ticket-success.png" alt=""/>
			</div>
			<div style="width:40%;float:right;text-align:right;">
				<img style="width:auto;" src="{{URL::to('/public/img/profile_imgs')}}/{{@$set->logo}}">
			</div>
			<div style="clear:both;"></div>
		</div>
		
		<div style="height:20px;"></div> 
		<!-- <div style="width:100%;display: flex;flex-wrap: wrap;">
			<hr style="border: 1px solid #214a93; width:100%;">
		</div> -->
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<div style="background:#f9f9f9;color:#000;border-radius: 5px;max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right: 0px;padding-left: 0px;border-top:3px solid #89ad3e;">
				<span style="font-size:16px;line-height:21px; padding:8px;display: block;">Passenger Details</span>
			</div>
		</div>
		<div style="max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right:15px;padding-left: 15px;">
			<br>
			<table style=" border: 1px solid #dee2e6;border-collapse: collapse;" width="100%">
				<tbody>	
					<tr>
						<th style="border: 1px solid #dee2e6; color:#214a93;text-align:center;">Sr. No.</th>
						<th style="border: 1px solid #dee2e6; color:#214a93;text-align:center;">Passenger(s) Name/ Type</th>
						<th style="border: 1px solid #dee2e6; color:#214a93;text-align:center;"> Baggage/ Meal</th>
						<th style="border: 1px solid #dee2e6; color:#214a93;text-align:center;"> Baggage/ Meal(R).</th>
					</tr>
					<?php 
						if(isset($booking->Response->Response->FlightItinerary->Passenger)){ 
							$pes = $booking->Response->Response->FlightItinerary->Passenger;
							$ts = 1;
							$pesib = array();
							if(isset($bookingib->Response->Response->FlightItinerary->Passenger)){
							$pesib = $bookingib->Response->Response->FlightItinerary->Passenger;
							} 
							for($ps =0;$ps<count($pes); $ps++){
								if($pes[$ps]->PaxType == 1){ $paxtype = 'Adult'; }
								else if($pes[$ps]->PaxType == 2){ $paxtype = 'Child'; }else{
									$paxtype = 'Infant';
								}
						?>
					<tr>
						<td style="border: 1px solid #dee2e6; color:#214a93;text-align:center;">{{$ts}}</td>
						<td style="border: 1px solid #dee2e6; color:#214a93;text-align:center;">{{$pes[$ps]->Title}} {{$pes[$ps]->FirstName}} {{$pes[$ps]->LastName}} ({{@$paxtype}})</td>
						<td style="border: 1px solid #dee2e6; color:#214a93;text-align:center;"><small> Cabin: {{$booking->Response->Response->FlightItinerary->Segments[0]->CabinBaggage }} <br> Check-In: {{$pes[$ps]->SegmentAdditionalInfo[0]->Baggage}}<br> Meal:  </small></td>
						<td style="border: 1px solid #dee2e6; color:#214a93;text-align:center;"> 
						Extra Baggage:
						@if(isset($pes[$ps]->Baggage))
							@foreach($pes[$ps]->Baggage as $blis)
							{{$blis->Weight}}kg
							@endforeach
						@else
							-
						@endif
							<br>
							Meal: 
							@if(isset($pes[$ps]->MealDynamic))
								@foreach(@$pes[$ps]->MealDynamic as $mlis)
								{{$mlis->AirlineDescription}}
								@endforeach 
							@else
							-
						@endif
						</td>
					</tr>
							<?php $ts++; } } ?>
				</tbody>
			</table>
		</div>
		<br>
		<br>
		<?php $tr = count($booking->Response->Response->FlightItinerary->Segments) -1; ?>
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<div style="background:#f9f9f9;color:#000;border-radius: 5px;max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right: 0px;padding-left: 0px;border-top:3px solid #89ad3e;">
				<span style="font-size:16px;line-height:21px;padding:8px;display: block;">{{$booking->Response->Response->FlightItinerary->Origin}} - {{@$booking->Response->Response->FlightItinerary->Destination}} ({{date('D d/m/Y', strtotime(@$booking->Response->Response->FlightItinerary->Segments[0]->Origin->DepTime))}}) (Onward)</span>
			</div>
		</div>
		<div style="max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">
			<br>
			<table style=" border: 1px solid #dee2e6;border-collapse: collapse;" width="100%">
				<tbody>
					<tr>
						<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:center;" width="15%">Flight(s)</th>
						<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:center;" width="25%">Departure</th>
						<th style="border: 1px solid #dee2e6;color:#214a93; background: #f3f3f3;text-align:center;" width="25%">Arrival</th>
						<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:center;" width="15%">PNR</th>
						<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:center;" width="5%">Duration</th>
					</tr>
					<?php
					$totalfare = 0;
					if(isset($booking->Response->Response->FlightItinerary->Segments)){
						$ir = 0;
						$res = $booking->Response->Response->FlightItinerary;
						$countflighdata = count($res->Segments); 
						$totalfare = $booking->Response->Response->FlightItinerary->Fare->PublishedFare;
						$allflighdata = $res->Segments;
						for($fl =0;$fl<count($allflighdata);$fl++){
					?>
					<tr>
						<td style="border: 1px solid #dee2e6; text-align:center;">
							<img src="{{URL::to('/public/img/airline/')}}/{{$allflighdata[$fl]->Airline->AirlineCode}}.gif"><br>
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
						<td style="border: 1px solid #dee2e6; text-align:center;"><small>{{$allflighdata[$fl]->Origin->Airport->AirportName}} ({{$allflighdata[$fl]->Origin->Airport->AirportCode}}) {{$allflighdata[$fl]->Origin->Airport->CityName}}<br> {{date('d/m/Y H:i:s', strtotime($allflighdata[$fl]->Origin->DepTime))}}<br> {{$allflighdata[$fl]->Origin->Airport->Terminal}}</small></td>
						<td style="border: 1px solid #dee2e6; text-align:center;"><small>{{$allflighdata[$fl]->Destination->Airport->AirportName}}  ({{$allflighdata[$fl]->Destination->Airport->AirportCode}}) {{$allflighdata[$fl]->Destination->Airport->CityName}}<br> {{date('d/m/Y H:i:s', strtotime($allflighdata[$fl]->Destination->ArrTime))}}<br> {{$allflighdata[$fl]->Destination->Airport->Terminal}} </small></td>
						<td style="border: 1px solid #dee2e6; text-align:center;"><small><b>{{$booking->Response->Response->PNR}}</b></small></td>
						<td style="border: 1px solid #dee2e6; text-align:center;"><b><small><?php echo Controller::GetTimeduration($allflighdata[$fl]->Origin->DepTime, $allflighdata[$fl]->Destination->ArrTime); ?></small></b></td>
					</tr>
					<?php } } ?>
				</tbody>
			</table>
		</div>
		<br>
		<br>
		<?php
		
		$retotalfare = 0;
		if($fetchedData->booking_response_ib != ''){
			if(isset($bookingib->Response->Response->FlightItinerary->Segments)){
				$retotalfare = $bookingib->Response->Response->FlightItinerary->Fare->PublishedFare;
				$trs = count($booking->Response->Response->FlightItinerary->Segments) -1;
		?>
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<div style="background:#f9f9f9;color:#000;border-radius: 5px;max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right: 0px;padding-left: 0px;border-top:3px solid #89ad3e;">
				<span style="font-size:16px;line-height:21px;padding:8px;display: block;">{{$bookingib->Response->Response->FlightItinerary->Origin}} - {{@$bookingib->Response->Response->FlightItinerary->Destination}} ({{date('d/m/Y', strtotime(@$bookingib->Response->Response->FlightItinerary->Segments[0]->Origin->DepTime))}}) (Return)</span>
			</div>
		</div>
		<div style="max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">
			<br>
			<table style=" border: 1px solid #dee2e6;border-collapse: collapse;" width="100%">
				<tbody>
					<tr>
						<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:center;" width="15%">Flight(s)</th>
						<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:center;" width="25%"> Departure</th>
						<th style="border: 1px solid #dee2e6;color:#214a93; background: #f3f3f3;text-align:center;" width="25%">Arrival</th>
						<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:center;" width="15%">PNR</th>
						<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:center;" width="5%">Duration</th>
					</tr>
					<?php
					$irib = 0;
						$ress = $bookingib->Response->Response->FlightItinerary;
						$countflighdataib = count($ress->Segments); 
						$allflighdataib = $ress->Segments;
						for($flib =0;$flib<count($allflighdataib);$flib++){
					?>
		<tr>
			<td style="border: 1px solid #dee2e6; text-align:center;">
				<img src="{{URL::to('/public/img/airline/')}}/{{$allflighdataib[$flib]->Airline->AirlineCode}}.gif"> <br>
				<small>{{$allflighdataib[$flib]->Airline->AirlineCode}}-{{$allflighdataib[$flib]->Airline->FlightNumber}}<br> @if($allflighdataib[$flib]->Airline->AirlineCode == 'I5')
						AirAsia 
					@else
						{{$allflighdataib[$flib]->Airline->AirlineName}}
					@endif  <br> @if(count($res->Segments) > 1)
								<?php echo count($res->Segments)-1; ?> stop
							@else 
								non-stop
						@endif<br> {{$allflighdataib[$flib]->Airline->FareClass}}</small>
			</td>
			<td style="border: 1px solid #dee2e6; text-align:center;"><small>{{$allflighdataib[$flib]->Origin->Airport->AirportName}} ({{$allflighdataib[$flib]->Origin->Airport->AirportCode}})  {{$allflighdataib[$flib]->Origin->Airport->CityName}}<br> {{date('d/m/Y H:i:s', strtotime($allflighdataib[$flib]->Origin->DepTime))}}<br> {{$allflighdataib[$flib]->Origin->Airport->Terminal}}</small></td>
			<td style="border: 1px solid #dee2e6; text-align:center;"><small>{{$allflighdataib[$flib]->Destination->Airport->AirportName}} ({{$allflighdataib[$flib]->Destination->Airport->AirportCode}}) {{$allflighdataib[$flib]->Destination->Airport->CityName}}<br> {{date('d/m/Y H:i:s', strtotime($allflighdataib[$flib]->Destination->ArrTime))}}<br> {{$allflighdataib[$flib]->Destination->Airport->Terminal}}</small></td>
			<td style="border: 1px solid #dee2e6; text-align:center;"><small><b>{{$bookingib->Response->Response->PNR}}</b></small></td>
			<td style="border: 1px solid #dee2e6; text-align:center;"><b><small><?php echo Controller::GetTimeduration($allflighdataib[$flib]->Origin->DepTime, $allflighdataib[$flib]->Destination->ArrTime); ?></small></b></td>
		</tr>
		<?php }  ?>
	</tbody>
</table>
</div>
<br>
<br>
<?php }  } ?>
<div style="width:100%;display: flex;flex-wrap: wrap;">
<div style="background:#f9f9f9;color:#000;border-radius: 5px;max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right: 0px;padding-left: 0px;border-top:3px solid #89ad3e;">
	<span style="font-size:16px;line-height:21px;padding:8px;display: block;">Payment Details (Onward)</span>
</div>
</div>
<div style="max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right:15px;padding-left: 15px;">
<br>
<?php
$paymentdta = \App\PaymentDetail::where('bookingid', $fetchedData->id)->first();
$discount =0;
?>
<table style=" border: 1px solid #dee2e6;border-collapse: collapse;" width="100%">
	<tbody>
		<tr>
			<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:center;" width="80%">Payment Details</th>
			<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:center;" width="20%"><i class="fa fa-inr"></i> Amount (INR)</th>
		</tr>
		<tr>
			<td style="border: 1px solid #dee2e6; text-align:center;">Total Base Fare</td>
			<td style="border: 1px solid #dee2e6; text-align:right;">{{$paymentdta->org_amount}}</td>
					</tr>
					@if(@$paymentdta->discount_amount != 0)
						<?php
					
						if($paymentdta->discount_type == 'percentage'){
							$discounttype = $paymentdta->discount_amount.'%';
							$discount = ($paymentdta->org_amount * $paymentdta->discount_amount/100);
						}else{
							$discounttype = 'INR'.$paymentdta->discount_amount;
							$discount = $paymentdta->discount;
						}
					?>
					<tr>
						<td style="border: 1px solid #dee2e6; text-align:center;">Discount {{@$paymentdta->coupon_id}} ({{@$discounttype}})</td>
						<td style="border: 1px solid #dee2e6; text-align:right;">{{round($discount)}}</td>
					</tr>
					@endif
					<tr>
						<td style="border: 1px solid #dee2e6; text-align:center;">Convenience Fee</td>
						<td style="border: 1px solid #dee2e6; text-align:right;">00.00</td>
					</tr>
					<tr>
						<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:center;" width="80%">Grand Total</th>
						<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:right;" width="20%"><i class="fa fa-inr"></i> {{round(@$paymentdta->org_amount - $discount)}}</th>
					</tr>
				</tbody>
			</table>
		</div>
		<br>
		<br>
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<div style="max-width: 50%;flex: 0 0 50%;position: relative;min-height: 1px;text-align:center;padding-right: 0px;padding-left: 0px;"><b>Customer E-mail :</b><br> {{@$fetchedData->user->email}}</div>
			<div style="max-width: 33.333333%;flex: 0 0 50%;position: relative;min-height: 1px;text-align:center;padding-right: 0px;padding-left: 0px;"><b>Customer Contact No. :</b> <br>{{@$fetchedData->user->phone}}</div>
		</div>
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<hr style="border: 1px solid #214a93; width:100%;">
		</div>
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<div style="max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right: 0px;padding-left: 0px;font-size:16px;line-height:24px;"><b>Important Information :</b><br>
				<ol>
					<li><b>Passenger Charter: </b> <a class="btn btn-link" href="#" style="color:#89ad3e;">Click Here</a></li>
					<li><b>{{@$booking->Response->Response->FlightItinerary->Segments[0]->Airline->AirlineName}} Conditions of Carriage: </b> <a class="btn btn-link" href="#" style="color:#89ad3e;">Click Here</a></li>
					<li>All Guests, including children and infants, must present valid identification at check-in.</li>
					<li>Check-in begins 2 hours prior to the flight for seat assignment and closes 45 minutes prior to the scheduled departure.<!-- li--></li>
					<li>Carriage and other services provided by the carrier are subject to conditions of carriage, which are hereby incorporated by reference. These conditions may be obtained from the issuing carrier.<!-- li--></li>
					<li>In case of cancellations less than 6 hours before departure please cancel with the airlines directly. We are not responsible for any losses if the request is received less than 6 hours before departure.<!-- li--></li>
					<li>Please contact airlines for Terminal Queries.<!-- li--></li>
					<li>Free Baggage Allowance: Checked-in Baggage can be between 15-30 KG(s) <small>(Can be changed accordignly. Please confirm from Airline)</small> in Economy class.<!-- li--></li>
					<li>Partial cancellations are not allowed for Round-trip Fares.<!-- li--></li>
					<li>Changes to the reservation will result in the above fee plus any difference in the fare between the original fare paid and the fare for the revised booking.<!-- li--></li>
					<li>In case of cancellation of a booking, made by a Go channel partner, refund has to be collected from that respective Go Channel.<!-- li--></li>
					<li>The No Show refund should be collected within 15 days from departure date.<!-- li--></li>
					<li>If the basic fare is less than cancellation charges then only statutory taxes would be refunded.<!-- li--></li>
					<li>We are not be responsible for any Flight delay/Cancellation from airline's end.<!-- li--></li>
					<li>Kindly contact the airline at least 24 hrs before to reconfirm your flight detail giving reference of Airline PNR Number.<!-- li--></li>
					<li>We are a travel agent and all reservations made through our website are as per the terms and conditions of the concerned airlines. All modifications,cancellations and refunds of the airline tickets shall be strictly in accordance with the policy of the concerned airlines and we disclaim all liability in connection thereof.<!-- li--></li>
				</ol>
			</div>
		</div>
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<hr style="border: 1px solid #214a93; width:100%;">
		</div>
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<div style="max-width: 50%;flex: 0 0 50%;position: relative;min-height: 1px;padding-right: 0px;padding-left: 0px;text-align:center;">
				<b>24/7 Customer Support</b><br>Call us any time on {{$set->phone}}<br> and we will help you out.
			</div>
			<div style="max-width: 50%;flex: 0 0 50%;position: relative;min-height: 1px;padding-right: 0px;padding-left: 0px;text-align:center;">
				<b>Contact Us</b><br><span><b>Address :</b> {{@$set->company_website}}</span><br><span><b>Support Email :</b> <a href="mailto:booking@holidaychacha.com" style="color:#89ad3e;"> {{@$set->b2c_email}}</a></span>
			</div>
		</div>
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<hr style="border: 1px solid #214a93; width:100%;">
		</div>
		<footer>
			<div style="max-width: 1140px;width: 100%;margin-right: auto;margin-left: auto;padding-left: 15px;padding-right: 15px;text-align:center;">
					<small>Copyright &copy; 2020 &nbsp;&nbsp; <a href="{{$set->company_website}}" style="color:#89ad3e;">{{$set->company_name}}</a> </small> 
			</div>
		</footer> 
	</div>
<div class="breakNow"></div>
<?php } ?>
<?php } ?>
</div>
</body>
</html>