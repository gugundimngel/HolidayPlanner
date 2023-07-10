<table id="invoicetable" border="1" class="table table-bordered table-hover text-nowrap">
	<thead>
		<tr> 
			<th class="no-sort"> S. N.</th>
			<th>Journey Detail</th>
			<th>Booking Detail</th>  
			<th>Passenger Detail</th>
			<th>Status</th>
			<th>Total Fare</th>
			<th>Admin Profit</th>
		</tr> 
	</thead>
<tbody class="tdata booking_data">
<?php $i=1; $totalcom = 0; ?>
@foreach($lists as $bookdetail)
<?php 
	$booking_response = json_decode($bookdetail->booking_response);
	$tr = 0;
	if(isset($booking_response->Response->Response->FlightItinerary->Segments)){
		$tr = count(@$booking_response->Response->Response->FlightItinerary->Segments) -1;
	}
	//echo '<pre>'; print_r($booking_response); 
	$booking_response_ib = array();
	$trr = 0;
	if($bookdetail->booking_response_ib != ''){
		$booking_response_ib = json_decode(@$bookdetail->booking_response_ib);
		
		$trr = @count(@$booking_response_ib->Response->Response->FlightItinerary->Segments) -1;
	}
	
	$commission = @$booking_response->Response->Response->FlightItinerary->Fare->OfferedFare - @$booking_response->Response->Response->FlightItinerary->Fare->PublishedFare;
	$ibcommission = @$booking_response_ib->Response->Response->FlightItinerary->Fare->OfferedFare - @$booking_response_ib->Response->Response->FlightItinerary->Fare->PublishedFare;
	$bookingib_request = json_decode($bookdetail->bookingib_request);
?>
	<tr>
		<td>{{$i}}</td>
		<td>
		@if(@$bookdetail->depart_flight == '')
			{{@$booking_response->Response->Response->FlightItinerary->Segments[0]->Origin->Airport->AirportCode}}-{{@$booking_response->Response->Response->FlightItinerary->Segments[$tr]->Destination->Airport->AirportCode}}: {{date('d/m/Y', strtotime(@$booking_response->Response->Response->FlightItinerary->Segments[0]->Origin->DepTime))}}
		@else
		{{@$bookdetail->depart_flight}}: {{date('d/m/Y', strtotime(@$bookdetail->depart_date))}}
		@endif		
		<br/>
		@if($bookdetail->return_flight == '' && !empty($booking_response_ib))
			{{@$booking_response_ib->Response->Response->FlightItinerary->Segments[0]->Origin->Airport->AirportCode}}-{{@$booking_response_ib->Response->Response->FlightItinerary->Segments[$trr]->Destination->Airport->AirportCode}}: {{date('d/m/Y', strtotime(@$booking_response_ib->Response->Response->FlightItinerary->Segments[0]->Origin->DepTime))}}
		@else
			@if($bookdetail->return_flight != '')
			{{@$bookdetail->return_flight}}: {{date('d/m/Y', strtotime(@$bookdetail->return_date))}}
			@endif
		@endif
		</td> 
		<td>
		@if($bookdetail->paymentdetail->status != 1)
			Ref. No.: ZAP-{{$bookdetail->id}}<br/>PNR: {{@$bookdetail->pnr}}
			@else 
				Ref. No.: ZAP-{{$bookdetail->id}}<br/>PNR: {{@$bookdetail->pnr}}
				@endif
		<span style="display:block;">Booked On: {{date('d/m/Y h:i', strtotime(@$bookdetail->created_at))}}</span></td>
		<td>
										<?php 
									if(isset($bookingib_request->adulttitle)){ 
										$pes = $bookingib_request->adulttitle;
										for($ps =0;$ps<count($pes); $ps++){
										?>
										{{@$bookingib_request->adulttitle[$ps]}} {{@$bookingib_request->adultfirstname[$ps]}} {{@$bookingib_request->adultlastname[$ps]}} (Adult) <br/>
											<?php  } } ?>
										<?php 
									if(isset($bookingib_request->childtitle)){ 
										$pes = $bookingib_request->childtitle;
										for($ps =0;$ps<count($pes); $ps++){
										?>
										{{@$bookingib_request->childtitle[$ps]}} {{@$bookingib_request->childfirstname[$ps]}} {{@$bookingib_request->childlastname[$ps]}} (Child) <br/>
											<?php  } } ?>
<?php 
									if(isset($bookingib_request->infanttitle)){ 
										$pes = $bookingib_request->infanttitle;
										for($ps =0;$ps<count($pes); $ps++){
										?>
										{{@$bookingib_request->infanttitle[$ps]}} {{@$bookingib_request->infantfirstname[$ps]}} {{@$bookingib_request->infantlastname[$ps]}} (Infant) <br/>
											<?php  } } ?>												
										</td>
	
		<td>
			<div class="check_status">
				@if($bookdetail->status == 1)
					Confirm
						@elseif($bookdetail->status == 2)
							Failed
						@else
							Pending
							@endif
			 
			</div>
		</td>
	
		<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b>{{@$bookdetail->paymentdetail->amount}}</b></td>
		<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b>{{@$list->paymentdetail->markupob+@$list->paymentdetail->markupib + @$commission + @$ibcommission}} </b></td>
	</tr>
	<?php $i++; $totalcom = @$list->paymentdetail->markupob+@$list->paymentdetail->markupib + @$commission + @$ibcommission; ?>
	@endforeach
</tbody>
								<tfoot>
									<tr>
										<td colspan="8">
											<div class="total_value">
												<span>Total Admin Profit: <i class="fa fa-inr"></i> {{number_format($totalcom, 2)}}</span>
											</div>
										</td>
									</tr>
								</tfoot>
							</table>