<?php $set = \App\Admin::where('id',1)->first(); ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>HOTEL VOUCHER</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
		body, table, span{font-family: Arial, sans-serif;} 
		* { font-family: DejaVu Sans, sans-serif; }
		table, table tr td table{width:100%;border:0px;}
		table tr td{font-size:11px;line-height:14px;color:#000;}
		table tbody tr td, table thead tr th{padding:3px 5px;}
		table tr td ul, table tr td ol{padding-left:24px;padding-top:8px;} 
		table tr td ul li, table tr td ol li{font-size:10px;line-height:14px;} 
	</style>
</head>
<body style="background: #fff;margin:0px;">
	<div style="max-width: 1140px;width: 100%;margin: 0px auto;padding-left: 15px;padding-right: 15px;font-family: Verdana, Geneva, Tahoma, sans-serif">
			<?php
			$bookingib_request = json_decode($fetchedData->booking_request);
			$booking_response = json_decode($fetchedData->booking_response);
			
			//echo '<pre>'; print_r($booking_response);
			?>
    
        <table style="background: #fff;">
            <tbody>
                <tr>
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td style="margin:0; font-weight:bold; font-size:18px; color:#444; ">HOTEL VOUCHER</td>
									<td>
										<p style="font-size:14px; text-transform:uppercase; color:#333333; margin:0; font-weight:normal; text-align:right; ">
										   <b>Booking ID: {{$fetchedData->id}}</b>
										</p>
									</td>
                                </tr>
							</tbody>
						</table>
					</td>	
				</tr>
				<!-- Empty Row Start Here -->
				<tr>
					<td style="padding:3px 0px;"></td>	 
				</tr>
				<!-- Empty Row End Here --> 
				<tr>
					<td>
						<table style="border: 1px solid #E5E5E5;padding: 3px 5px;">
							<tbody> 
								<tr> 
									<td width="320">
										<p style="font-size:16px; color:#333333; text-transform:uppercase; font-weight:900; margin:0; ">Holiday Planner </p>
										<p style="font-size:16px; color:#000; margin:0;padding:0; ">{{$set->address}},<br> {{$set->city}} India </p>
										<p style="font-size:16px; color:#000; margin:0;padding:0; ">Phone: {{$set->phone}} <br>Email ID: {{$set->b2c_email}} </p>
									</td>
									<td align="left" width="170" style="vertical-align:top; ">
										<table style="width:100%; border-collapse:collapse">
											<tbody>
												<tr>
													<td style="vertical-align:top; padding:18px 18px 8px 23px; ">
														<p style="font-size:16px; color:#333333; text-transform:uppercase; font-weight:900; margin:0; ">
														  Confirm Number : <br>{{@$fetchedData->booking_id}}</p>
													</td>
												</tr>
												<tr>
													<td style="vertical-align:top; padding:18px 18px 8px 23px; ">
														<p style="font-size:16px; color:#333333; text-transform:uppercase; font-weight:900; margin:0; ">
														  Booking Ref Number : <br>{{@$fetchedData->booking_reference}} </p>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tbody>
								<tr>
									<td>
										<p style="margin: 0;padding-left: 20px;">PLEASE PRESENT THIS VOUCHER UPON ARRIVAL</p>
									</td>
								</tr>
							</tbody>
						</table>
					</td>	
				</tr>
				
				<tr>
                    <td>
						<table border="" width="" style="margin-bottom: 15px!important;border-collapse:collapse; background-color:#ffffff; margin:0 0;border: 1px solid #E5E5E5;">
							<thead style="background-color: #00a0db;">
								<tr>
									<td style=" text-align:center; border-radius:4px; vertical-align:middle;padding: 7px 12px;">
										<p style="font-size:14px; text-transform:uppercase; color:#FFF; margin:0; font-weight:900;  ">
										   {{@$booking_response->hotel->name}}</p>
									</td> 
								</tr>
							</thead>
							<tbody>                                               
								<tr>
									<td align="left" style="padding:10px 0 10px 0px;text-align:center; " width="117"><p style="font-size:14px; text-transform:uppercase; color:#333333; margin:0; font-weight:normal;  ">
										<p> {{@$booking_response->hotel->address}}</p>
								   </td>
								</tr>
								<tr>
									<td align="left" style="padding:10px 0 10px 0px;text-align:center; " width="117"><p style="font-size:14px; text-transform:uppercase; color:#333333; margin:0; font-weight:normal;  ">
										<p><b>Hotel Contact Number : </b> {{@$booking_response->hotel->phone_number}}, <br> {{@$booking_response->hotel->email}}
										</p>
									</td>
								</tr>                                                
							</tbody>
						</table>
					</td>	
				</tr>
				
				<tr>
                    <td>
						<table border="1" width="" style="margin-bottom: 15px!important;border-collapse:collapse; background-color:#ffffff; margin:0 0; border: 1px solid #E5E5E5;">
							<thead style="background-color: #00a0db;">
								<tr>
									<td style=" text-align:center; border-radius:4px; vertical-align:middle;padding: 7px 12px;">
										<p style="font-size:14px; text-transform:uppercase; color:#fff; margin:0; font-weight:900;  ">
											Check-in</p>
									</td>
									<td style=" text-align:center; border-radius:4px; vertical-align:middle;padding: 7px 12px;">
										<p style="font-size:14px; text-transform:uppercase; color:#fff; margin:0; font-weight:900;  ">
											Check-out</p>
									</td>
									<td style=" text-align:center; border-radius:4px; vertical-align:middle;padding: 7px 12px;">
										<p style="font-size:14px; text-transform:uppercase; color:#fff; margin:0; font-weight:900;  ">
											Guests</p>
									</td>
								</tr>
							</thead>
							<tbody>                                                
								<tr>
									<td align="left" style="padding:10px 0 10px 0px;text-align:center; " width="117">
										<p style="font-size:14px; text-transform:uppercase; color:#333333; margin:0; font-weight:normal;  ">
										   <b>{{@$booking_response->checkin}}</b>
										</p>
									</td>	
									<td align="left" style="padding:10px 0 10px 0px;text-align:center; " width="117">
										<p style="font-size:14px; text-transform:uppercase; color:#333333; margin:0; font-weight:normal;  ">
										   <b>{{@$booking_response->checkout}}</b>
										</p>
									</td>
									<?php
									$adults = 0;
									$child = 0;
									$toroom = 0;
									?>
				@if(isset($bookingib_request->childtitle))
					@foreach($bookingib_request->adulttitle as $key => $roomdetail)
					<?php 
						$adults += count($roomdetail);
					$toroom++; ?>
					@endforeach
				@endif
				<?php 
					$child = 0;
				?>
				@if(isset($bookingib_request->childtitle))
					@foreach($bookingib_request->childtitle as $keys => $roomcdetail)
					<?php 
						$child += count($roomcdetail);
					 ?>
					@endforeach
				@endif
									<td align="left" style="padding:10px 0 10px 0px;text-align:center; " width="117">
										<p style="font-size:14px; text-transform:uppercase; color:#333333; margin:0; font-weight:normal;  ">
										   <b>{{$adults}} Adults, {{$child}} Children</b>
										</p>
									</td>
								</tr>                                        
							</tbody>
						</table>
					</td>	
				</tr>
						
					
				<?php foreach($booking_response->hotel->booking_items[0]->rooms as $key => $list){?>
				
				<tr>
					<td align="center" cellspacing="0" style="padding:0; vertical-align:middle">
						<table border="1" width="" style="margin-bottom: 15px!important;border-collapse:collapse; background-color:#ffffff; margin:0 0; border: 1px solid #E5E5E5;">
							<thead style="background-color: #00a0db;">
								<tr>
									<td style=" text-align:center; border-radius:4px; vertical-align:middle;padding: 7px 12px;">
										<p style="font-size:14px; text-transform:uppercase; color:#fff; margin:0; font-weight:900;  ">
										{{$list->room_type}}</p>
									</td>
								</tr>
							</thead>
							<tbody>                  
								<tr>
									<td align="left" style="padding:10px 0 10px 0px;text-align:center; " width="117">
										<p style="font-size:14px; text-transform:uppercase; color:#333333; margin:0; font-weight:normal;">
											<?php
											foreach($booking_response->hotel->paxes as $paxl){
												if(in_array($paxl->pax_id, $list->pax_ids)){
													?>
													<b>{{$paxl->title}} {{$paxl->name}}  {{$paxl->surname}}</b><br>
													<?php
												}
											?>		
											<?php } ?>
										</p>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<?php } ?>
				
				<tr>
					<td align="center" cellspacing="0" style="padding:0; vertical-align:middle">
					   <table border="1" width="" style="margin-bottom: 15px!important;border-collapse:collapse; background-color:#ffffff; margin:0 0; border: 1px solid #E5E5E5;">
							<thead style="background-color: #00a0db;">
								<tr>
									<td style=" text-align:center; border-radius:4px; vertical-align:middle;padding: 7px 12px;">
										<p style="font-size:14px; text-transform:uppercase; color:#fff; margin:0; font-weight:900;  ">Boarding Details</p>
									</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align="left" style="padding:10px 0 10px 0px;text-align:center; " width="117">     
										<p style="font-size:14px; text-transform:uppercase; color:#333333; margin:0; font-weight:normal;  ">
										   <b> 
											 <?php if(isset($booking_response->hotel->booking_items[0]->boarding_details)){
												 echo implode(', ', $booking_response->hotel->booking_items[0]->boarding_details);
											 } 
											 ?></b>
										</p>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				
				<tr>
					<td align="center" cellspacing="0" style="padding:0; vertical-align:middle">
						<table border="1" width="" style="margin-bottom: 15px!important;border-collapse:collapse; background-color:#ffffff; margin:0 0; border: 1px solid #E5E5E5;">
							<thead style="background-color: #00a0db;">
								<tr>
									<td style=" text-align:center; border-radius:4px; vertical-align:middle;padding: 7px 12px;">
										<p style="font-size:14px; text-transform:uppercase; color:#fff; margin:0; font-weight:900;  ">Inclusion</p>
									</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align="left" style="padding:10px 0 10px 0px;text-align:center; " width="117">     
										<p style="font-size:14px; text-transform:uppercase; color:#333333; margin:0; font-weight:normal;  ">
										   <b> 
											 <?php if(isset($booking_response->hotel->booking_items[0]->other_inclusions)){
												 echo implode(', ', $booking_response->hotel->booking_items[0]->other_inclusions);
											 } 
											 ?></b>
										</p>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>

				<tr>
					<td align="center" cellspacing="0" style="padding:0; vertical-align:middle">
						<table border="1" width="" style="margin-bottom: 15px!important;border-collapse:collapse; background-color:#ffffff; margin:0 0; border: 1px solid #E5E5E5;">
							<thead style="background-color: #00a0db;">
								<tr>
									<td style=" text-align:center; border-radius:4px; vertical-align:middle;padding: 7px 12px;">
										<p style="font-size:14px; text-transform:uppercase; color:#fff; margin:0; font-weight:900;  ">
											Cancellation Policy</p>
									</td>
								</tr>
							</thead>
							<tbody>                  
								<tr>
									<td align="left" style="padding:10px 0 10px 0px;text-align:center; " width="117">
										<p style="font-size:14px;padding: 6px 0px;font-weight: 600; text-transform:uppercase; color:#333333; margin:0; font-weight:normal; ">
									   <?php
											 if(isset($booking_response->hotel->booking_items[0]->cancellation_policy->cancel_by_date)){ ?>
										 <span>Last Cancellation Date : </span>   {{date('d M Y', strtotime($booking_response->hotel->booking_items[0]->cancellation_policy->cancel_by_date))}}
											 <?php } ?>
										 </p>
									</td> 
								</tr> 
								<tr>
									<td>	
										<table border="1" width="" style="margin-bottom: 15px!important;border-collapse:collapse; margin:0 0; border: 1px solid #E5E5E5;">
											<tbody>
												<tr>
													<th style="padding: 7px 5px; text-align: center;font-size: 14px;">From Date</th>
													<th style="padding: 7px 5px; text-align: center;font-size: 14px;">Charge</th>
												</tr>
												  <?php
													  if(isset($booking_response->hotel->booking_items[0]->cancellation_policy->details)){ 													 foreach($booking_response->hotel->booking_items[0]->cancellation_policy->details as $lid){ 
												
												?>
												<tr>
													<td style="padding: 7px 5px; text-align: center;font-size: 14px;" class="text-center">{{date('d M Y',strtotime($lid->from))}}</td>
													
													<td style="padding: 7px 5px; text-align: center;font-size: 14px;" class="text-center">{{$lid->flat_fee}} </td>
												</tr>
											<?php } }  ?>		
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>			
													
				<tr class="payment_details" >
					<td align="center" style="padding:0; vertical-align:middle">
						<table border="1" width="" style="margin-bottom: 15px!important;border-collapse:collapse; background-color:#ffffff; margin:0 0; border: 1px solid #E5E5E5;">
							<thead style="background-color: #00a0db;">
								<tr>
									<td colspan="2" style=" text-align:center; border-radius:4px; vertical-align:middle;padding: 7px 12px;">
										<p style="font-size:14px; text-transform:uppercase; color:#fff; margin:0; font-weight:900;  ">
											Payment Details</p>
									</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align="left" style="padding:10px 4px 10px 10px;;text-align:left; " width="200"><p style="font-size:14px; text-transform:uppercase; color:#333333; margin:0; font-weight:normal;"> This is an electronic ticket.<br>Please carry a positive identification for check in.</p>
									</td>
									<td width="300">
										<table>
											<tbody>
												<tr>
													<td align="left" style="padding:10px 4px 10px 10px;;text-align:left; " width="117"><p style="font-size:14px; text-transform:uppercase; color:#333333; margin:0; font-weight:normal;">Room Price:</p></td>
													<td align="left" style="padding:10px 0 10px 0px;text-align:center; " width="117"><p style="font-size:14px; text-transform:uppercase; color:#333333; margin:0; font-weight:normal;  "> <i class="fa fa-inr"></i>  {{$fetchedData->paymentdetail->base_total}} </p>
													</td>
												</tr>
												<tr>
													<td align="left" style="padding:10px 4px 10px 10px;;text-align:left; " width="117"><p style="font-size:14px; text-transform:uppercase; color:#333333; margin:0; font-weight:normal;">Tax and Additional Charge (+):</p></td>
													<td align="left" style="padding:10px 0 10px 0px;text-align:center; " width="117"><p style="font-size:14px; text-transform:uppercase; color:#333333; margin:0; font-weight:normal;  ">
													<i class="fa fa-inr"></i>    {{$fetchedData->paymentdetail->service_fee}} </p></td>
												</tr>
												<tr>	
													<td align="left" style="padding:10px 4px 10px 10px;;text-align:left; " width="117"><p style="font-size:14px; text-transform:uppercase; color:#333333; margin:0; font-weight:normal;"><b>Total Fare:</b></p></td>
													<td align="left" style="padding:10px 0 10px 0px;text-align:center; " width="117"><p style="font-size:14px; text-transform:uppercase; color:#333333; margin:0; font-weight:600;  ">
													<i class="fa fa-inr"></i> <b>{{$fetchedData->paymentdetail->amount}}</b></p></td>
												</tr>	
											</tbody>
										</table>
									</td>	
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				
				<tr>
					<td>
						<table>
							<tbody>
								<tr>
									<td>
										<p style="padding: 0 21px;text-align: justify;font-size: 12px;margin: 0;">Carriage and other services provided by the carrier are subject to conditions of carriage which hereby incorporated by reference. These conditions may be obtained from the issuing carrier. If the passenger's journey involves an ultimate destination or stop in a country other than country of departure the Warsaw convention may be applicable and the convention governs and in most cases limits the liability of carriers for death or personal injury and in respect of loss of or damage to baggage.</p>
									</td>	
								</tr>
							</tbody>
						</table>	
					</td>
				</tr>
				
                <tr>
                    <td>
						<table style="background-color:#00a0db; width:100%; border-radius:5px 5px 0 0; border-collapse:collapse">
							<tbody>
								<tr>
									<td align="center" style="vertical-align:middle; padding:22px 4px; ">
										<p style="color:#FFF; font-size:18px; margin:0; ">
											E & O.E
										</p>
									</td>
									<td align="right" style="vertical-align:middle; padding:22px 50px 22px 0; ">
										<p style="color:#FFF; font-size:18px; margin:0; ">
											<a href="https://zapbooking.com/" target="_blank" style="text-decoration:none; color:#fff; font-weight:bold;outline:0;">zapbooking.com</a>
										</p>
									</td>
								</tr>
							</tbody>
						</table>
                    </td>
                </tr>            
            </tbody>
        </table>
	</div>	
</body>
</html>

	



   


