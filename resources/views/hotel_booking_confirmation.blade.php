@extends('layouts.frontend')
@section('title','Hotel Voucher')
@section('meta_title', '')
@section('meta_keyword', '')
@section('meta_description', '')
@section('bodyclass', 'homepage')
@section('pagespecificstyles')
@endsection
@section('content')
<?php
$booking = json_decode($fetchedData->booking_response); 
//$booking = $detail->;

//echo '<pre>'; print_r($booking); echo '<pre>'; die;
?>
<section id="content">
<div id="content-wrap">
	<!-- === Section Flat =========== -->
	<div class="section-flat single_sec_flat hotel_booking_confirm">      
		<div class="section-content">
			<div class="container">
				<div class="hotel_booking_info">					
					<div class="row">
						<div class="col-sm-12">
							<div class="booking_confrm_title">
								<img src="{!! asset('public/images/hotel_img/success.png') !!}" alt="Booking Success"/> <h2>Hotel Booking <span>Confirmation</span></h2>
							</div>
							<div class="booking_confrm_icons">
								<ul>
									<li><a href="{{URL::to('/Hotel/booking/hotelvoucher/')}}/{{base64_encode(convert_uuencode(@$fetchedData->id))}}"><img src="{!! asset('public/images/hotel_img/print.png') !!}" alt="Booking Print"/></a></li>
									
									<li><a data-toggle="modal" data-target="#sendmailmodel" href="#"><img src="{!! asset('public/images/hotel_img/email.png') !!}" alt="Booking Email"/></a></li>
								</ul>
							</div>
						</div>						
						<div class="col-sm-6">	
							<div class="cus_booking_details">
								<div class="book_row">
									<div class="book_label">
										<span>Booking ID:</span>
									</div>
									<div class="book_value">
										<span><?php echo $booking->booking_id; ?></span>
									</div>
									<div class="book_label">
										<span>Booking Reference No:</span>
									</div>
									<div class="book_value">
										<span><?php echo $booking->booking_reference; ?></b></span>
									</div>
									<div class="book_label">
										<span>Client:</span>
									</div>
									<div class="book_value">
										<span><?php echo $booking->holder->title.' '.$booking->holder->name.' '.$booking->holder->surname; ?></span>
									</div>
									<div class="book_label">
										<span>Country of Residence:</span>
									</div>
									<div class="book_value">
										<span>India</span>
									</div>
									<div class="book_label">
										<span>Hotel Name:</span> 
									</div>
									<div class="book_value">
										<span><?php echo $booking->hotel->name; ?></span>
									</div>
									<div class="book_label">
										<span>Hotel Address:</span>
									</div>
									<div class="book_value">
										<span><?php echo $booking->hotel->address; ?></span>
									</div>
									<div class="book_label">
										<span>Hotel Contact Number:</span>
									</div>
									<div class="book_value">
										<span><?php echo $booking->hotel->phone_number; ?></span>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
						<div class="col-sm-6">	
							<div class="cus_booking_details">
								<div class="book_row">
									<div class="book_label">
										<span>Number of Rooms:</span>
									</div>
									<div class="book_value">
										<span>1</span>
									</div>
									<div class="book_label">
										<span>Number of Extra Beds:</span>
									</div>
									<div class="book_value">
										<span>0</span>
									</div>
									<div class="book_label">
										<span>Number of Adults:</span>
									</div>
									<div class="book_value">
										<span>1</span>
									</div>
									<div class="book_label">
										<span>Number of Children:</span>
									</div>
									<div class="book_value">
										<span>0</span>
									</div>
									<div class="book_label">
										<span>Room Type:</span>
									</div>
									<div class="book_value">
										<span>Superior</span>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
					</div>
					
					<!--<div class="row">
						<div class="col-sm-12">	
							
							<div class="book_info">
								<h3><?php //echo $booking->hotel->name; ?></h3>
								<div class="stars">
								@for($i=0; $i<@$detail->hotel->category; $i++)
									<i class="fa fa-star"></i>
								@endfor
									
								</div>
								<p><?php /*echo $booking->hotel->address; ?></p>
								<div class="checkin_out_detail">
									<span>Check In: <b><?php echo date('l, d M Y', strtotime($fetchedData->checkin)); ?></b></span>
									<span>Check Out: <b><?php echo date('l, d M Y', strtotime($fetchedData->checkout));*/ ?></b></span>
								</div>
							</div>
						</div>
					</div>-->
					
					<div class="row">	
						<div class="col-sm-12">	
							<div class="book_overview">	
								<div class="ticket_head">	
									<h4>Confirmation Details</h4>
								</div>
								<div class="confirm_detail confirm_table">
									<table class="table">
										<thead>
											<tr>
												<th>Lead Pax</th>
												<th>Room Type</th>
												<!--<th>Nights</th>-->
												<th>Rooms</th>
												<th>Adults</th>
												<th>Child</th>
												<th>Meal</th>
											</tr>
										</thead>
										<tbody>
										<?php
											  $booking_items = $booking->hotel->booking_items;
											  $is=0;
											foreach($booking_items as $bookingitems){
												//echo '<pre>'; print_r($bookingitems); die;
												$i=0;
											foreach($bookingitems->rooms as $key => $rooms){
												//echo '<pre>'; print_r($rooms); die;
												
										?>
											<tr>
												<td><small><b><?php 
												foreach($booking->hotel->paxes as $keyp => $paxes){
													if(isset($rooms->pax_ids[0]) && $paxes->pax_id == @$rooms->pax_ids[0]){
														echo $paxes->title.' '.$paxes->name.' '.$paxes->surname;
													}
												}
												?></b></small></td>
												<td><small><b><?php echo @$rooms->room_type; ?></b></small></td>
												<!--<td><small><b><?php //echo $rooms->room_type; ?></b></small></td>-->
												<td><small><b><?php echo $rooms->no_of_rooms; ?></b></small></td>
												<td><small><b><?php echo $rooms->no_of_adults; ?></b></small></td>
												<td><small><b><?php echo $rooms->no_of_children; ?></b></small></td>
												<td><small><b><?php echo implode(',',$bookingitems->boarding_details); ?></b></small></td>
											</tr>
											<?php $i++; } ?>
											<?php $is++; }   ?>
										</tbody>
									</table>
								</div>
								
								<div class="ticket_head">	
									<h4>Booking Information</h4>
								</div>										
								<div class="booking_info_table confirm_table">
									<table class="table">
										<tbody>
											<tr>
												<th>Status</th>
												<td><small><b><?php echo ucfirst($booking->booking_status); ?></b></small></td>
											</tr>
											<tr>
												<th>Nationality</th>
												<td><small><b><?php echo ucfirst($booking->nationality); ?></b></small></td>
											</tr>	
											<tr>	
												<th>Agent Reference</th>
												<td><small><b>Holiday Planner Pvt Ltd</b></small></td>
											</tr>	
											<tr>	
												<th>Voucher Issue Date</th>
												<td><small><b><?php echo date('l, d M Y ', strtotime($booking->voucher_issue_date)); ?></b></small></td>
											</tr>	
											<tr>	
												<th>System Reference No</th>
												<td><small><b><?php echo $booking->booking_reference; ?></b></small></td>
											</tr>
											<tr>	
												<th>Booking ID</th>
												<td><small><b><?php echo $booking->booking_id; ?></b></small></td>
											</tr>
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12 other_detail_info">
							<div class="guest_info ">
								<h4>Guest Details</h4>
								<?php
								  $booking_items = $booking->hotel->booking_items;
								  $is=0;
								foreach($booking_items as $bookingitems){
									//echo '<pre>'; print_r($bookingitems); die;
									$i=0;
									$ia=1;
								foreach($bookingitems->rooms as $key => $rooms){
									
									
							?>
								<div class="guest_col book_cus_col">
									<h5>Room {{$ia}}</h5>
									<ul>
									<?php
									foreach($rooms->pax_ids as $keys => $paxesn){
										
										foreach($booking->hotel->paxes as $keyp => $paxes){
											
											if($paxes->pax_id == @$paxesn){
												?>
											<li><?php echo $paxes->title.' '.$paxes->name.' '.$paxes->surname; ?> <?php if($paxes->type == 'AD'){ echo '(Adult)'; }else if($paxes->type == 'CH'){ echo '(Child)'; }; ?></li>
												<?php
											}
										}
									}
									?>
										
									</ul>
								</div>
								<?php 
									$ia++; 
									$i++; 
								} ?>
								<?php } ?>
								
							</div>
							<div class="emergency_contact">
								<h4>Emergency Contact</h4>
								<div class="guest_col book_cus_col">
									<ul>
										<li>Agent Contact Number: 8826496095</li>
										<li>Service Operator Number: +91 - 9910 411 117 (24X7 India Helpline Number)</li>
									</ul>
								</div>
							</div>
							<div class="essential_info">
								<h4>Essential Information</h4>
								
								<?php
								  $booking_items = $booking->hotel->booking_items;
								  $is=0;
								foreach($booking_items as $bookingitems){
								?>
								<?php if(isset($bookingitems->non_refundable) && $bookingitems->non_refundable != ''){ ?>
								<p><b>Non-Refundable Rate:</b><br/> {{@$bookingitems->non_refundable}}</p>
								<?php } ?>
								<p><b>Pax Comments:</b><br/> {{@$bookingitems->rate_comments->pax_comments}}</p>
								<p><b>Comments:</b><br/> {{@$bookingitems->rate_comments->comments}}</p>
								<p><b>CheckOut Time:</b><br/> {{@$bookingitems->rate_comments->checkout_time}}</p>
								<p><b>CheckIn Time</b><br/> {{@$bookingitems->rate_comments->checkin_end_time}}</p>
								<p><b>CheckIn Begin Time</b><br/> {{@$bookingitems->rate_comments->checkin_begin_time}}</p>
								
								<p>{!! @$bookingitems->rate_comments->checkin_instructions !!}</p>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>	
			</div>	
		</div>	
	</div>	
</div>	
</section>
 <div class="modal fade bs-example-modal-sm" id="sendmailmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document" style="top: 80px;">
		<div class="modal-content" style="border: 30px solid #eeeeee;">
		<div class="modal-body">
		 <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal">×</button>
			<h4 class="modal-title">Email E-Ticket</h4>                 
		 </div>
		  <div class="form-group">
			<div id="error_msg_email" class="alert alert-danger" style="display:none;"></div>
			<label for="recipient-name" class="control-label">Subject</label>
			<input type="text" id="subject" class="form-control" required="">
			<input type="hidden" id="printticketID"  value="{{base64_encode(convert_uuencode(@$fetchedData->id))}}">
		  </div>
		  <div class="form-group">
			<label for="recipient-name" class="control-label"> To Email </label>
			<input type="text" id="mail_id_user" required="" class="form-control">
		  </div>
		</div>
			<div class="modal-footer">
			<div class="bp_email_data_put" style="display:none;">
			
			</div>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  <button type="button" onclick="sendmail()" class="btn btn-primary">Send</button>
			</div>
		  </div>
		</div>
	  </div>

<script type="text/javascript">
	 function sendmail(){
				var email_reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
				var valuesubj= document.getElementById('subject').value;
				var mnailiduser= document.getElementById('mail_id_user').value;
				var printContents = document.getElementById('printticketID').value;
				if(valuesubj==""){
					$('#error_msg_email').html("Please enter a subject");
					$('#error_msg_email').show();
					return false;
				}
				if(mnailiduser==""){
					$('#error_msg_email').html("Please enter an email");
					$('#error_msg_email').show();
					return false;
				}
				if(email_reg.test(mnailiduser)==false){
					$('#error_msg_email').html("Please enter a valid email address");
					$('#error_msg_email').show();
					return false;
				}
				$('#error_msg_email').hide();
				$.ajax({
					type:"POST",
					url:"{{URL::to('/')}}/Hotel/booking/ticketmail",
					data:{valuesubj:valuesubj,mnailiduser:mnailiduser,printid:printContents},
					beforeSend:function(){
					
					  $('#loader').show();
				  },
					success:function(data)  {
						alert(data);
						 $('#loader').hide();
						 $('#sendmailmodel').modal('hide');
					   // alert("Mail Successfully Send");
					},
				});
			}
			
			</script>	  
@endsection