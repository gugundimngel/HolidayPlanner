@extends('layouts.admin')
@section('title', 'Hotels Booking')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Hotels Booking</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Hotels Booking</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->	
	<!-- Breadcrumb start-->
	<!--<ol class="breadcrumb">
		<li class="breadcrumb-item active">
			Home / <b>Dashboard</b>
		</li>
		@include('../Elements/Admin/breadcrumb')
	</ol>-->
	<!-- Breadcrumb end-->
	
	<!-- Main content --> 
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
					<div class="card">
						<div class="card-header">
							<div class="cus_user_tags">
								<ul>
								<?php 
								$type = isset($_GET['type']) ? $_GET['type'] : 'b2c';
								$suucessb = \App\HotelBookingDetail::where('status',1)->where('type',$type)->count();
								$failedb = \App\HotelBookingDetail::where('status',2)->where('type',$type)->count();
								$pendingb = \App\HotelBookingDetail::where('status',0)->where('type',$type)->count();
							?>
									<li style="cursor:pointer;" onClick="window.location.href='{{URL::to('/admin/bookings/?status=1&btype=hotel')}}'" class="active_tag cus_tag">
										<span class="span_tag approvetag">{{@$suucessb}}</span> <span class="tag_label">Success
										<small class="approvetag"> {{@$suucessb}}</small></span>
										
									</li>
									<li style="cursor:pointer;"  onClick="window.location.href='{{URL::to('/admin/bookings/?status=2&btype=hotel')}}'" class="inactive_tag cus_tag">
										<span class="span_tag pendingtag">{{@$failedb}}</span> <span class="tag_label">Failed 
										<small class="pendingtag"> {{@$failedb}}</small></span>
									</li>
									<li style="cursor:pointer;"  onClick="window.location.href='{{URL::to('/admin/bookings/?status=0&btype=hotel')}}'" class="inactive_tag cus_tag">
										<span class="span_tag pendingtag">{{@$pendingb}}</span> <span class="tag_label">Pending 
										<small class="pendingtag"> {{@$pendingb}}</small></span>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="card"> 
						<div class="card-header">   
							<div class="card-title booking_title">
								<ul>
									<li>
										<a class="dropdown-toggle btn btn-block btn-outline-primary btn-sm is_not_selected_invoice" data-toggle="dropdown" href="#" aria-expanded="false"><i class="fa fa-plus"></i> User Type <span class="caret"></span></a>
										<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 31px, 0px);">
										  <a class="dropdown-item" tabindex="-1" href="{{URL::to('/admin/bookings')}}?btype=hotel">B2C Booking</a>
										  <a class="dropdown-item" tabindex="-1" href="{{URL::to('/admin/bookings')}}?type=b2b&btype=hotel">B2B Booking</a>
										</div>											
									</li>
								</ul>
							</div>
							<?php 
							$ty = isset($_GET['type']) ? $_GET['type'] : 'b2c'; 
							$bstype = isset($_GET['btype']) ? $_GET['btype'] : 'flight'; 
						
					?>
							<div class="card_custom_menu">
								<ul>
									<li class="<?php if($bstype == 'flight'){ echo 'active'; } ?>"><a href="{{URL::to('/admin/bookings')}}?type={{$ty}}">Flight</a></li>
									<li class="<?php if($bstype == 'hotel'){ echo 'active'; } ?>"><a href="{{URL::to('/admin/bookings')}}?btype=hotel&type={{$ty}}">Hotel</a></li>
									<li class="<?php if($bstype == 'package'){ echo 'active'; } ?>"><a href="{{URL::to('/admin/bookings')}}?btype=package&type={{$ty}}">Package</a></li>
									<li ><a href="javascript:;">Bus</a></li>
									<li><a href="javascript:;">visa</a></li>
								</ul>
							</div>	
							<div class="card-tools card_tools">
								<a href="javascript:;" data-toggle="modal" data-target="#amnetsearch_modal" class="btn btn-primary"><i class="fas fa-search"></i></a>
							</div>
							<div class="print_export">
								<ul>
		<li class="print"><a dataurl="" href="javascript:;" class="print_myinvoice"><i class="fas fa-print"></i> Print</a></li>
									<li class="export"><a href=""><i class="fas fa-file-excel"></i> Export</a></li>
								</ul>
							</div>
						</div>
						
						<div class="card-body table-responsive">
							<table id="invoicetable" class="table table-bordered table-hover text-nowrap">
								<thead>
									<tr> 
										<th class="no-sort">Hotel Detail</th>
										<th class="no-sort">Booking Detail</th>  
										
										<th class="no-sort">Booking Status</th>
										<th class="no-sort">Payment Status</th>
										<th class="no-sort">Total Amount</th>
										<th class="no-sort">Action</th>
									</tr> 
								</thead> 
								<tbody class="tdata booking_data">
								@foreach($lists as $bookdetail)
								<?php
									$hoteldetail = \App\HotelList::where('hotel_code', $bookdetail->hotel_code)->first();
								?>
									<tr>
										<td>
											Hotel Code: <?php echo $bookdetail->hotel_code.'<br>'; ?>
											Hotel Name: <?php echo @$hoteldetail->hotel_name.','.@$hoteldetail->city.'<br>'; ?>
											<?php echo 'Checkin: '.date('d M Y, h:i A', strtotime($bookdetail->checkin)).'<br>Checkout: '.date('d M Y, h:i A', strtotime($bookdetail->checkout)); ?>
										</td>
										<td>
											Booking ID: <?php echo $bookdetail->booking_id.'<br>'; ?>
											Booking Reference: <?php echo $bookdetail->booking_reference.'<br>'; ?>
											Booked On: <?php echo date('d M Y, h:i A', strtotime($bookdetail->created_at)).'<br>'; ?>
										</td>
									
										<td>
										<div class="check_status">
											<a href="javascript:;" class="<?php if($bookdetail->status == 1){ echo 'green_clr'; }else{ echo 'red_clr'; } ?> chk_stat_btn">@if($bookdetail->status == 1)
												Confirm
											@elseif($bookdetail->status == 2)
												Failed
											@else
												Pending
											@endif</a>
											<span><a href="{{URL::to('/admin/hotellog/'.base64_encode(convert_uuencode(@$bookdetail->id)))}}" target="_blank" class="view_log">View Log</a></span>
											</div>
										</td>
										<td>
										<div class="check_status">
											<a href="javascript:;" class="<?php if($bookdetail->paymentdetail->status == 1){ echo 'green_clr'; }else{ echo 'red_clr'; } ?> chk_stat_btn">@if($bookdetail->paymentdetail->status == 1)
												Confirm
											@elseif($bookdetail->paymentdetail->status == 2)
												Failed
											@else
												Pending
											@endif</a>
											</div>
										</td>
										<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b>{{@@$bookdetail->paymentdetail->amount}}</b></td>
										<td><div class="nav-item dropdown action_dropdown">
												<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
												<div class="dropdown-menu">
													<a href="{{URL::to('/admin/bookings/hoteldetail/'.base64_encode(convert_uuencode(@$bookdetail->id)))}}"><i class="fa fa-edit"></i> View Detail</a>
													@if($bookdetail->status == 1)
													<a target="_blank" href="{{URL::to('/admin/bookings/hotelvoucher/'.base64_encode(convert_uuencode(@$bookdetail->id)))}}"><i class="fa fa-edit"></i> Hotel Voucher</a>
													@endif
												</div>
											</div></td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>		
									
						<div class="card-body table-responsive">
					
							<div class="card-footer hide">
							{{-- {!! $lists->appends(\Request::except('page'))->render() !!} --}}
							 </div>
						  </div>
					</div>	
				</div>	
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="amnetsearch_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				  <h4 class="modal-title">Search</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
			</div>
			
			<form action="{{URL::to('/admin/bookings')}}" method="get">
			<input type="hidden" name="btype" value="hotel">
			<?php $hoteltype ='b2c'; if(isset($_GET['type'])){ $hoteltype = $_GET['type']; }?>
			<input type="hidden" name="type" value="hotel">
			<input type="hidden" name="type" value="{{$hoteltype}}">

			<div class="modal-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<label for="pnr" class="col-sm-2 col-form-label">Booking ID</label>
						<div class="col-sm-10">
							{{ Form::text('booking_id', Request::get('booking_id'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Booking ID', 'id' => 'booking_id' )) }}
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<label for="booking_reference" class="col-sm-2 col-form-label">Reference No</label>
						<div class="col-sm-10">
							{{ Form::text('booking_reference', Request::get('booking_reference'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Reference No', 'id' => 'booking_reference' )) }}
						</div>
					</div>
				</div>
				
				
				<div class="col-md-6">
					<div class="form-group row">
						<label for="ref" class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-10">
							<select class="form-control" name="status">
								<option value=""></option>
								<option value="1">Confirmed</option>
								<option value="2">Failed</option>
								<option value="7">Pending</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			</div>
			<div class="modal-footer">
				{{ Form::submit('Search', ['class'=>'btn btn-primary' ]) }}
			</div>
			 {{ Form::close() }}
		</div>
	</div>
</div>
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="pdfmodel">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">Print Invoice</h4>
			   <button type="button" onclick="print()" class="btn btn-primary" >
				<span aria-hidden="true">Print</span>
			  </button>
			  <button type="button" class="btn btn-default closeprint">
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
$(document).delegate('.print_myinvoice', "click", function () {
			var val = $(this).attr('dataurl');
			$('#pdfmodel').modal('show');
		
					 $("#pdfmodel .modal-body iframe").attr('src', val) // create an iframe
         
		});
		$(document).delegate('.closeprint', "click", function () {
			$('#pdfmodel').modal('hide');
		
		});
		});
</script>
@endsection