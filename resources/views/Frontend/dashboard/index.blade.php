@extends('layouts.frontend')
@section('title', 'Dashboard')
@section('content')      
<section id="content">
			<div id="content-wrap">
				<!-- === Section Flat =========== -->
				<div class="section-flat single_sec_flat profile_sec dashboard_inner">      
					<div class="section-content">
						<div class="container">
							<div class="row">
								<div class="col-sm-6">	
									<div class="cus_breadcrumb">
										<ul>
											<li class="active"><a href="#">My Account</a></li>
											<li><span><i class="fa fa-angle-right"></i></span></li>
											<li><a href="#">My Booking</a></li>
										</ul>
									</div>	
								</div>
								<div class="col-sm-6">	
									<div class="count_search">
										<div class="showcount">
											<label>Show</label>
											<select>
												<option>10</option>
												<option>25</option>
												<option>50</option>
												<option>75</option>
												<option>100</option>
											</select>
										</div>
										<div class="search_booking">
											<input type="text" class="form-control" placeholder="Search for a booking"/>
											<i class="fa fa-search"></i>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="col-sm-3">
										@include('../Elements/Frontend/navigation')
								</div>
								<div class="col-sm-9">	
									<div class="flight_booking">
										<div class="booking_tabs">
											<div class="inner_common_tabs">
												<ul class="nav nav-tabs custom_tabs">
													<li class="active"><a href="#flights" aria-controls="flights" role="tab" data-toggle="tab"><img src="{{URL::to('html')}}/images/icons/flight-tab.png"/> Flights</a></li>
													<!--<li class=""><a href="#hotels" aria-controls="hotels" role="tab" data-toggle="tab"><img src="{{URL::to('html')}}/images/icons/hotel-tab.png"/> Hotels</a></li>
													<li class=""><a href="#tour_pack" aria-controls="tour_pack" role="tab" data-toggle="tab"><img src="{{URL::to('html')}}/images/icons/holiday-tab.png"/> Tour Package</a></li>
													<li class=""><a href="#bus" aria-controls="bus" role="tab" data-toggle="tab"><img src="{{URL::to('html')}}/images/icons/bus-tab.png"/> Bus</a></li>
													<li class=""><a href="#visa" aria-controls="visa" role="tab" data-toggle="tab"><img src="{{URL::to('html')}}/images/icons/visa-tab.png"/> Visa</a></li>-->
												</ul>  	
											</div>	 
											<div class="tab-content">
												<div role="tabpanel" class="tab-pane active" id="flights">
												<div class="inner_flight">
												@if(@$totaldata !== 0)
													
													<div class="mail-msg"></div>
														<div class="bookflight_info">
															<ul>
																<li><a href="javascript:;" class="email_ticket"><i class="fa fa-envelope"></i> Email</a></li>
																<li><a href="javascript:;"><i class="fa fa-times"></i> Cancel Flight</a></li>
																<li><a href="javascript:;" class="print_allinvoice"><i class="fa fa-print"></i> Print E-Ticket</a></li>
															<!--	<li><a href="javascript:;"><i class="fa fa-print"></i> Print Invoice</a></li>
																<li><a href="javascript:;" class="sms_ticket"><i class="fa fa-mobile"></i> SMS Ticket</a></li>-->
															</ul>
														</div> 
														<div class="clearfix"></div>
														<div class="flight_tabledata">
															<div class="table-responsive">
																<table class="table">
																	<thead>
																		<tr>
																			<th></th>
																			<th>DOJ</th>
																			<th>Type</th>
																			<th>Destination</th>
																			<th>Status</th>
																			<th>Booking ID</th>
																		</tr>
																	</thead>
																	<tbody>
																	
																		@foreach (@$lists as $list)
																		<tr>
																			<td>
																				<div class="checkbox">
																					<input name="invoicelist" name="tickets" value="{{@$list->id}}" tid="{{base64_encode(convert_uuencode(@$list->id))}}" type="checkbox" />
																					<span class="checkmark"></span>
																				</div> 
																			</td>
																			<td>
																				<div class="fli_date">
																					<span class="month"><?php echo date('M', strtotime(@$list->from_date)); ?></span>
																					<span class="datetime"><?php echo date('d D', strtotime(@$list->from_date)); ?></span>
																				</div>
																			</td>
																			<td class="plane_icon"><i class="fa fa-plane fa-rotate--45"></i></td>
																			<td>{{@$list->source}} <i class="fa fa-long-arrow-alt-right"></i> {{@$list->destination}}</td>
																			<td>
																			@if(@$list->status == 1)
																				<div class="status"><a class="cus_link confirm">Confirm</a>
																			</div>
																			@elseif(@$list->status == 6)
																				<div class="status"><a class="cus_link incomplete">NotConfirmed</a>
																					</div>
																			@elseif(@$list->status == 2)
																				<div class="status"><a class="cus_link incomplete">Failed</a>
																					</div>
																			@else
																				<div class="status"><a class="cus_link incomplete">Incomplete</a>
																			</div>
																			@endif
																			</td> 
																			<td  class="booking_id">Trip ID: @if(@$list->status == 1) <a target="_blank" href="{{URL::to('/ticket')}}/{{base64_encode(convert_uuencode(@$list->id))}}">ZAP-{{@$list->id}}</a> @else <a target="" href="javascript:;">ZAP-{{@$list->id}}</a> @endif<br><span>Booked on:{{date('d/m/Y h:i:s', strtotime(@$list->created_at))}}</span></td>
																		</tr> 
																		@endforeach
																		
																		
																	</tbody>
																</table>
															</div>
														</div> 
													
													@else
														<div class="col-sm-12 text-center">
														<h4>Looks like you have not booked any trips yet. Start exploring!</h4>
															<a href="{{URL::to('/')}}" class="btn btn-primary">Book your Trip</a>
														</div>
														<div class="clearfix"></div>
													@endif
													{!! $lists->appends(\Request::except('page'))->render() !!}
													</div>
												</div>
												<div role="tabpanel" class="tab-pane" id="hotels">
												</div>
												<div role="tabpanel" class="tab-pane" id="tour_pack">
												</div>
												<div role="tabpanel" class="tab-pane" id="bus">
												</div>
												<div role="tabpanel" class="tab-pane" id="visa">
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
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="pdfallmodel">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">Print Invoice</h4>
			 
			  <button type="button" class="btn btn-default closepri">
				<span aria-hidden="true">Close</span>
			  </button>
			</div>

			<div class="modal-body">
				<iframe frameborder="0" src="" style="width:100%;height:80vh;" id="myFrame" name="printframe"></iframe>
			</div>
		</div>
	</div>
</div>		
<script>
jQuery(document).ready(function($){
$(document).delegate('.print_allinvoice', "click", function () {
			var html = ''; 
			 $("input[name=invoicelist]:checked").each(function() { 
                html += $(this).val()+','; 
            }); 
			var val = html.replace(/,(\s+)?$/, '');
			
			$('#pdfallmodel').modal('show');
		
					 $("#pdfallmodel .modal-body iframe").attr('src', '{{URL::to('/')}}'+'/tickets/printall?inv='+val) // create an iframe
         
		});
			$(document).delegate('.sms_ticket', "click", function () {
				var le = $('input[name="invoicelist"]:checked').length;
				if(le > 1){
					alert('Please select only one checkbox');
				}else{
					if($('input[name="invoicelist"]:checked').length != 0){
						$('.se-pre-con').show();
						var tcid = $('input[name="invoicelist"]:checked').attr('tid');
							$.ajax({
							url: "{{ URL::to('/phoneticket') }}/"+tcid,
							dataType: 'json',
							type: 'GET',
							data: {phone:'{{@Auth::user()->phone}}'},
							success: function( data ){
								$('.se-pre-con').hide();
								$('input[name="invoicelist"]').prop('checked', false);
								if (data.success) {
									
									$('.mail-msg').show();
									$('.mail-msg').html('<p class="alert alert-success">SMS Sent Successfully</p>');
									setTimeout(function() { $(".mail-msg").hide(); }, 5000);
								}else{
									$('.mail-msg').show();
									$('.mail-msg').html('<p class="alert alert-danger">Please try again</p>');
										setTimeout(function() { $(".mail-msg").hide(); }, 5000);
								}
							}
						});
					}else{
						alert('Please select checkbox');
					}
				}
			});
			$(document).delegate('.email_ticket', "click", function () {
				var le = $('input[name="invoicelist"]:checked').length;
				if(le > 1){
					alert('Please select only one checkbox');
				}else{
					if($('input[name="invoicelist"]:checked').length != 0){
						$('.se-pre-con').show();
						var tcid = $('input[name="invoicelist"]:checked').attr('tid');
							$.ajax({
							url: "{{ URL::to('/emailticket') }}/"+tcid,
							dataType: 'json',
							type: 'GET',
							data: {email:'{{@Auth::user()->email}}'},
							success: function( data ){
								$('.se-pre-con').hide();
								$('input[name="invoicelist"]').prop('checked', false);
								if (data.success) {
									
									$('.mail-msg').show();
									$('.mail-msg').html('<p class="alert alert-success">Email Sent Successfully</p>');
									setTimeout(function() { $(".mail-msg").hide(); }, 5000);
								}else{
									$('.mail-msg').show();
									$('.mail-msg').html('<p class="alert alert-danger">Please try again</p>');
										setTimeout(function() { $(".mail-msg").hide(); }, 5000);
								}
							}
						});
					}else{
						alert('Please select checkbox');
					}
				}
			});
			$(document).delegate('.closepri', "click", function () {
				$('#pdfmodel').modal('hide');
				$('#pdfallmodel').modal('hide');
			});
	
		});
	
</script>
@endsection