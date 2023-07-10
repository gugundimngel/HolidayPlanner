<?php 
use App\Http\Controllers\Controller;
$set = \App\Admin::where('id',1)->first();
$pessangerdetail = json_decode($fetchedData->passengers);
//echo '<pre>'; print_r($pessangerdetail);
?>
<!DOCTYPE html>
<html lang="en-US">
<head>			
</head>
<body>
	<div style="border: 1px solid #89ad3e;padding: 30px;max-width: 1140px;width: 100%;margin: 0px auto;padding-left: 15px;padding-right: 15px;font-family: Verdana, Geneva, Tahoma, sans-serif">
		<div style="background:#f1f1f1;padding: 10px;border:1px solid #ddd;border-radius:10px;">
			<div style="width:40%; float:left; color:#214a93">
				<div style="width:100%;font-size:24px;">
					<strong style="color:#214a93;">E-Ticket</strong>
				</div>
				<span style="display:block;"><b style="color:#214a93;">{{$set->ref_prefix}} Booking ID : </b> {{$set->ref_prefix}}-{{@$fetchedData->id}}</span>
				<span style="display:block;"><b style="color:#214a93;">Booking Date : </b> {{date('D d/m/Y', strtotime(@$fetchedData->created_at))}}</span>
				
			</div>  
			<div style="width:20%;float:left;">
				<!-- <h4 style="color:#214a93;font-size:20px;text-align:center;margin:0px;font-weight:normal;"> SUCCESS</h4> -->
				<img style="width: 140px;margin: auto;display: block;" src="{{URL::to('/')}}/html/images/ticket-success.png" alt="">
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
					</tr>
					<?php
					$tt = 1;
						if(isset($pessangerdetail->passenger)){
							$pessager = $pessangerdetail->passenger;
							foreach($pessager as $key => $lpist){
								?>
								<tr>
									<td style="color:#214a93;text-align:left;" colspan="2">Room {{$key}}</td>
								</tr>
								<?php
							$pes = $lpist->adulttitle;
							for($ps =0;$ps<count($pes); $ps++){
					?>
						<tr>
							<td style="border: 1px solid #dee2e6; color:#214a93;text-align:center;">{{$tt}}</td>
							<td style="border: 1px solid #dee2e6; color:#214a93;text-align:center;">
							{{@$lpist->adulttitle[$ps]}} {{@$lpist->adultfirstname[$ps]}} {{@$lpist->adultlastname[$ps]}} (Adult)
							</td>
						</tr>
							<?php $tt++; }  ?>
						
						<?php
						if(isset($lpist->infanttitle)){ 
							$pes = $lpist->infanttitle;
							for($ps =0;$ps<count($pes); $ps++){
						?>
							<tr>
								<td style="border: 1px solid #dee2e6; color:#214a93;text-align:center;">{{$tt}}</td>
								<td style="border: 1px solid #dee2e6; color:#214a93;text-align:center;">
								{{@$lpist->infanttitle[$ps]}} {{@$lpist->infantfirstname[$ps]}} {{@$lpist->infantlastname[$ps]}} (Infant)
								</td>
							</tr>
							<?php $tt++; } } ?>
					
						<?php
						if(isset($lpist->cwbtitle)){ 
							$pes = $lpist->cwbtitle;
							for($ps =0;$ps<count($pes); $ps++){
						?>
							<tr>
								<td style="border: 1px solid #dee2e6; color:#214a93;text-align:center;">{{$tt}}</td>
								<td style="border: 1px solid #dee2e6; color:#214a93;text-align:center;">
								{{@$lpist->cwbtitle[$ps]}} {{@$lpist->cwbfirstname[$ps]}} {{@$lpist->cwblastname[$ps]}} (Child with Bed)
								</td>
							</tr>
							<?php $tt++; } } ?>
							
							<?php
						if(isset($lpist->cwobtitle)){ 
							$pes = $lpist->cwobtitle;
							for($ps =0;$ps<count($pes); $ps++){
						?>
							<tr>
								<td style="border: 1px solid #dee2e6; color:#214a93;text-align:center;">{{$tt}}</td>
								<td style="border: 1px solid #dee2e6; color:#214a93;text-align:center;">
								{{@$lpist->cwobtitle[$ps]}} {{@$lpist->cwobfirstname[$ps]}} {{@$lpist->cwoblastname[$ps]}} (Child without Bed)
								</td>
							</tr>
							<?php $tt++; } } ?>
							<?php
						if(isset($lpist->cwobbtitle)){ 
							$pes = $lpist->cwobbtitle;
							for($ps =0;$ps<count($pes); $ps++){
						?>
							<tr>
								<td style="border: 1px solid #dee2e6; color:#214a93;text-align:center;">{{$tt}}</td>
								<td style="border: 1px solid #dee2e6; color:#214a93;text-align:center;">
								{{@$lpist->cwobbtitle[$ps]}} {{@$lpist->cwobbfirstname[$ps]}} {{@$lpist->cwobblastname[$ps]}} (Child without Bed (below 2-3 years))
								</td>
							</tr>
							<?php $tt++; } } ?>
							<?php  } } ?>
				</tbody>
			</table>
		</div>
		<br>
		<br>
		
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<div style="background:#f9f9f9;color:#000;border-radius: 5px;max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right: 0px;padding-left: 0px;border-top:3px solid #89ad3e;">
				<span style="font-size:16px;line-height:21px; padding:8px;display: block;">Package Details</span>
			</div>
		</div>
		<div style="max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right:15px;padding-left: 15px;">
			<h4 style="font-size:21px;line-height:24px;color:#000;margin:5px 0px 10px;">{{@$fetchedData->packagedetail->package_name}} <span style="font-size:16px;line-height:21px;color:#214a93;margin:0px;">({{@$fetchedData->packagedetail->no_of_nights}} Nights / {{@$fetchedData->packagedetail->no_of_days}} Days)</span></h4>
			<span style="font-size:16px;line-height:21px;color:#214a93;margin:0px;">Departure Date: {{date('M d, Y', strtotime($fetchedData->package_date))}}</span><br>
			<span style="font-size:18px;line-height:21px;color:#000;margin:0px;">{{@$fetchedData->packagedetail->details_day_night}}</span>
			<div class="pack_inclusion" style="margin:20px 0px 0px;">
				<h4 style="font-size:16px;line-height:21px;color:#214a93;margin:0px;">Top Inclusion</h4>
				<ul style="padding-left: 20px;list-style-type: circle;font-size:14px;line-height:24px;">
				<?php if(@$fetchedData->packagedetail->package_topinclusions != ''){ 
					$explodee = explode(',',@$fetchedData->packagedetail->package_topinclusions);
					if(!empty($explodee)){
						for($i=0; $i<count($explodee);$i++ ){
						$query = \App\SuperTopInclusion::where('id', '=', $explodee[$i]);
						$Topinclusion		= $query->with(['topinclusion' => function($query) {
						$query->select('id','top_inc_id','name','status','image');
						}])->first();
				?>
					<li style="">{{@$Topinclusion->name}}</li>
					
						<?php } } } ?>
				</ul>
			</div>
			<h4 style="font-size:16px;line-height:21px;color:#214a93;margin:0px;">Description</h4>
			<?php echo htmlspecialchars_decode(stripslashes(@$fetchedData->packagedetail->package_overview)); ?>
			
			<div style="width:50%;float:left;">
				<h4 style="font-size:16px;line-height:21px;color:#214a93;margin:0px;">Inclusion</h4>
				<ul style="padding-left: 20px;list-style-type: circle;font-size:14px;line-height:24px;">
					<?php 
						$explodeei = explode(',',@$fetchedData->packagedetail->package_inclusions);
						for($j=0; $j<count($explodeei);$j++ ){
							$inclusions = \App\Inclusion::where('id', '=', $explodeei[$j])->first();
					?>
					<li>{{@$inclusions->name}}</li>
				<?php } ?>
				</ul>
			</div>
			<div style="width:50%;float:left;">
				<h4 style="font-size:16px;line-height:21px;color:#214a93;margin:0px;">Exclusion</h4>
				<ul style="padding-left: 20px;list-style-type: circle;font-size:14px;line-height:24px;">
					<?php 
					$explodeee = explode(',',@$fetchedData->packagedetail->package_exclusions);
					for($c=0; $c<count($explodeee);$c++ ){
						$exclusions = \App\Exclusion::where('id', '=', $explodeee[$c])->first();
						if(@$exclusions->name != ''){
					?>
						<li>{{@$exclusions->name}}</li>
						<?php } } ?>
				</ul>
			</div>  
			<div style="clear:both;float:none;"></div>
		</div>
		
		<br>
		<br>
		
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<div style="background:#f9f9f9;color:#000;border-radius: 5px;max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right: 0px;padding-left: 0px;border-top:3px solid #89ad3e;">
				<span style="font-size:16px;line-height:21px;padding:8px;display: block;">Add-Ons</span>
			</div>
		</div>
		<div style="max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">			
			<br>
			<table style=" border: 1px solid #dee2e6;border-collapse: collapse;" width="100%">
				<tbody>
					<tr>
						<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:center;" width="15%">Name</th>
						<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:center;" width="25%">Price</th>
						<th style="border: 1px solid #dee2e6;color:#214a93; background: #f3f3f3;text-align:center;" width="25%">Duration</th>
					</tr>
					<?php $expaddon = json_decode(@$fetchedData->addons); 
					foreach($expaddon as $addon){
						
					?>
					<tr>
						<td style="border: 1px solid #dee2e6; text-align:center;"><small>
							{{$addon->name}}</small>
						</td>
						<td style="border: 1px solid #dee2e6; text-align:center;"><small><i class="fa fa-rupee-sign"></i> {{$addon->price}}</small></td>
						<td style="border: 1px solid #dee2e6; text-align:center;"><small>{{$addon->duration}}</small></td>
					</tr>
					
					<?php } ?>
				</tbody>
			</table>
		</div>
		<br>
		<br>
		<?php
			$depflight = \App\FlightDetail::where('id',@$fetchedData->packagedetail->onward_flight)->with(['flight','flightsource','flightdest','returnflight'])->first();
			if($depflight){
		?>
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<div style="background:#f9f9f9;color:#000;border-radius: 5px;max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right: 0px;padding-left: 0px;border-top:3px solid #89ad3e;">
				<span style="font-size:16px;line-height:21px;padding:8px;display: block;">{{@$depflight->flightsource->city_code}} - {{@$depflight->flightdest->city_code}} {{date('D d/m/Y', strtotime($depflight->arival_time))}} (Onward)</span>
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
						
						<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:center;" width="5%">Duration</th>
					</tr>
										<tr>
						<td style="border: 1px solid #dee2e6; text-align:center;">
							<img src="{{URL::to('/public/img/airline')}}/{{@strtoupper($depflight->flight->code)}}.gif"><br>
							<small>{{@$depflight->flight_number}}<br> 	{{@$depflight->flight->name}}
							 <br>  
								{{$depflight->stop}}
						</small>
						</td>
						<td style="border: 1px solid #dee2e6; text-align:center;"><small> {{@$depflight->flightsource->city_name}}<br> {{date('d/m/Y H:i:s', strtotime($depflight->arival_time))}}</small></td>
						<td style="border: 1px solid #dee2e6; text-align:center;"><small>{{@$depflight->flightdest->city_name}}<br> {{date('d/m/Y H:i:s', strtotime($depflight->dep_time))}} </small></td>
						
						<td style="border: 1px solid #dee2e6; text-align:center;"><b><small><?php echo Controller::GetTimeduration($depflight->dep_time, $depflight->arival_time); ?></small></b></td>
					</tr>
									</tbody>
			</table>
		</div>
			<?php } ?>
		<br>
		<?php
			$retflight = \App\FlightDetail::where('id',@$fetchedData->packagedetail->return_flight)->with(['flight','flightsource','flightdest','returnflight'])->first();
			if($retflight){
		?>
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<div style="background:#f9f9f9;color:#000;border-radius: 5px;max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right: 0px;padding-left: 0px;border-top:3px solid #89ad3e;">
				<span style="font-size:16px;line-height:21px;padding:8px;display: block;">{{@$retflight->flightdest->city_code}} - {{@$retflight->flightsource->city_code}}   {{date('D d/m/Y', strtotime($retflight->arival_time))}} (Return)</span>
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
						
						<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:center;" width="5%">Duration</th>
					</tr>
										<tr>
						<td style="border: 1px solid #dee2e6; text-align:center;">
							<img src="{{URL::to('/public/img/airline')}}/{{@strtoupper($retflight->flight->code)}}.gif"><br>
							<small>{{@$retflight->flight_number}}<br> 	{{@$retflight->flight->name}}
							 <br>  
								{{$retflight->stop}}
						</small>
						</td>
						<td style="border: 1px solid #dee2e6; text-align:center;"><small> {{@$retflight->flightdest->city_name}}<br> {{date('d/m/Y H:i:s', strtotime($retflight->arival_time))}}</small></td>
						<td style="border: 1px solid #dee2e6; text-align:center;"><small>{{@$retflight->flightsource->city_name}}<br> {{date('d/m/Y H:i:s', strtotime($retflight->dep_time))}} </small></td>
						
						<td style="border: 1px solid #dee2e6; text-align:center;"><b><small><?php echo Controller::GetTimeduration($retflight->dep_time, $retflight->arival_time); ?></small></b></td>
					</tr>
									</tbody>
			</table>
		</div>
			<?php } ?>
		<br>
		<div style="width:100%;display: flex;flex-wrap: wrap;">
<div style="background:#f9f9f9;color:#000;border-radius: 5px;max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right: 0px;padding-left: 0px;border-top:3px solid #89ad3e;">
	<span style="font-size:16px;line-height:21px;padding:8px;display: block;">Payment Details</span>
</div>
</div>
<div style="max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right:15px;padding-left: 15px;">
<br>
<?php
$paymentdta = \App\PackagePaymentDetail::where('bookingid', @$fetchedData->id)->first();

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
			<td style="border: 1px solid #dee2e6; text-align:right;">{{@$paymentdta->org_amount}}</td>
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
						<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:center;" width="80%">Grand Total</th>
						<th style="border: 1px solid #dee2e6;color:#214a93;background: #f3f3f3; text-align:right;" width="20%"><i class="fa fa-inr"></i> {{round(@$paymentdta->org_amount - $discount)}}</th>
					</tr>
				</tbody>
			</table>
		</div>
		<br>
		<br>
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<div style="max-width: 50%;flex: 0 0 50%;position: relative;min-height: 1px;text-align:center;padding-right: 0px;padding-left: 0px;"><b>Customer E-mail :</b> {{@$fetchedData->user->email}}</div>
			<div style="max-width: 33.333333%;flex: 0 0 50%;position: relative;min-height: 1px;text-align:center;padding-right: 0px;padding-left: 0px;"><b>Customer Contact No. :</b>{{@$fetchedData->user->phone}} <br></div>
		</div>
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<hr style="border: 1px solid #214a93; width:100%;">
		</div>
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<div style="max-width: 100%;flex: 0 0 100%;position: relative;min-height: 1px;padding-right: 0px;padding-left: 0px;font-size:16px;line-height:24px;"><b>Important Information :</b><br>
				<ol>
					
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
				<b>Contact Us</b><br><span><b>Address :</b> {{@$set->address}}</span><br><span><b>Support Email :</b> <a href="mailto:{{@$set->b2c_email}}" style="color:#89ad3e;"> {{@$set->b2c_email}}</a></span>
			</div>
		</div>
		<div style="width:100%;display: flex;flex-wrap: wrap;">
			<hr style="border: 1px solid #214a93; width:100%;">
		</div>
		<footer>
			<div style="max-width: 1140px;width: 100%;margin-right: auto;margin-left: auto;padding-left: 15px;padding-right: 15px;text-align:center;">
				<small>Copyright © 2020 &nbsp;&nbsp; <a href="{{$set->company_website}}" style="color:#89ad3e;">{{$set->company_name}}</a> </small> 
			</div>
		</footer> 
	</div>
</body>
</html>
			