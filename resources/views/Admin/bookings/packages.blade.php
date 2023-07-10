@extends('layouts.admin')
@section('title', 'Booking')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Booking</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Booking</li>
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
							<div class="card-title booking_title">
								<ul>
									<li>
										<a class="dropdown-toggle btn btn-block btn-outline-primary btn-sm is_not_selected_invoice" data-toggle="dropdown" href="#" aria-expanded="false"><i class="fa fa-plus"></i> User Type <span class="caret"></span></a>
										<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 31px, 0px);">
										  <a class="dropdown-item" tabindex="-1" href="{{URL::to('/admin/bookings')}}?btype=package">B2C Booking</a>
										  <a class="dropdown-item" tabindex="-1" href="{{URL::to('/admin/bookings')}}?type=b2b&btype=package">B2B Booking</a>
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
									<li class="<?php if($bstype == 'hotel'){ echo 'active'; } ?>"><a href="javascript:;">Hotel</a></li>
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
		<li class="print"><a dataurl="{{URL::to('/admin/bookings')}}?type={{@$_GET['type']}}&action=print&pnr={{@$_GET['pnr']}}&ref={{@$_GET['ref']}}&source={{@$_GET['source']}}&destination={{@$_GET['destination']}}&email={{@$_GET['email']}}&mobile={{@$_GET['mobile']}}&status={{@$_GET['status']}}" href="javascript:;" class="print_myinvoice"><i class="fas fa-print"></i> Print</a></li>
									<li class="export"><a href="{{URL::to('/admin/bookings')}}?type={{@$_GET['type']}}&action=excel&pnr={{@$_GET['pnr']}}&ref={{@$_GET['ref']}}&source={{@$_GET['source']}}&destination={{@$_GET['destination']}}&email={{@$_GET['email']}}&mobile={{@$_GET['mobile']}}&status={{@$_GET['status']}}"><i class="fas fa-file-excel"></i> Export</a></li>
								</ul>
							</div>
						</div>
						
						<div class="card-body table-responsive">
							<table id="invoicetable" class="table table-bordered table-hover text-nowrap">
								<thead>
									<tr> 
										<th class="no-sort"><input type="checkbox" id="checkedAll"> S. N.</th>
										<th>Journey Detail</th>
										<th>Booking Detail</th>  
										<th>Passenger Detail</th>
										<th>Status</th>
										<th>Payment Status</th>
										<th>Total Fare</th>
										<th class="no-sort">Action</th>
									</tr> 
								</thead> 
								<tbody class="tdata booking_data">
								@foreach($lists as $bookdetail)
								<?php 
									$pessangerdetail = json_decode($bookdetail->passengers);
									//echo '<pre>'; print_r($pessangerdetail);
								?>
									<tr>
										<td><input class="checkSingle" type="checkbox" name="allcheckbox" value=""></td>
							<td>{{@$bookdetail->packagedetail->package_name}}<br>Tour Code: {{@$bookdetail->packagedetail->tour_code}}<br>{{@$bookdetail->packagedetail->details_day_night}}<br>Package Date: {{date('d/m/Y', strtotime(@$bookdetail->package_date))}}</td> 
										<td>
										@if(@$bookdetail->paymentdetail->status != 1)
											<a href="{{URL::to('/package/ticket')}}/{{base64_encode(convert_uuencode(@$bookdetail->id))}}">Ref. No.: ZAP-{{$bookdetail->id}}</a>
											@else 
												<a target="_blank" href="{{URL::to('/ticket')}}/{{base64_encode(convert_uuencode(@$bookdetail->id))}}">Ref. No.: ZAP-{{$bookdetail->id}}</a>
												@endif
										<span style="display:block;">Booked On: {{date('d/m/Y h:i', strtotime(@$bookdetail->created_at))}}</span></td>
										<td>
										<?php 
									if(isset($pessangerdetail->passenger->adulttitle)){ 
										$pes = $pessangerdetail->passenger->adulttitle;
										for($ps =0;$ps<count($pes); $ps++){
										?>
										{{@$pessangerdetail->passenger->adulttitle[$ps]}} {{@$pessangerdetail->passenger->adultfirstname[$ps]}} {{@$pessangerdetail->passenger->adultlastname[$ps]}} (Adult) <br/>
											<?php  } } ?>
										<?php 
									if(isset($pessangerdetail->passenger->childtitle)){ 
										$pes = $pessangerdetail->passenger->childtitle;
										for($ps =0;$ps<count($pes); $ps++){
											if($pessangerdetail->passenger->childtype[$ps] == 'infant'){
												$cildtype = 'Infant';
											}else if($pessangerdetail->passenger->childtype[$ps] == 'cwb'){
												$cildtype = 'Child with bed';
											}else if($pessangerdetail->passenger->childtype[$ps] == 'cwob'){
												$cildtype = 'Child without bed';
												
											}
										?>
										{{@$pessangerdetail->passenger->childtitle[$ps]}} {{@$pessangerdetail->passenger->childfirstname[$ps]}} {{@$pessangerdetail->passenger->childlastname[$ps]}} ({{@$cildtype}}) <br/>
											<?php  } } ?>
								
										</td>
									
										<td>
											<div class="check_status">
												<a href="javascript:;" class="<?php if($bookdetail->status == 1){ echo 'green_clr'; }else{ echo 'red_clr'; } ?> chk_stat_btn">@if($bookdetail->status == 1)
													Confirm
														@elseif($bookdetail->status == 2)
															Failed
														@else
															Pending
															@endif
											</a>
												
											</div>
										</td>
										<td>
											<div class="check_status">
							<a href="javascript:;" class="<?php if(@$bookdetail->paymentdetail->status == 1){ echo 'green_clr'; }else{ echo 'red_clr'; } ?> chk_stat_btn">@if(@$bookdetail->paymentdetail->status == 1)
						Success
						@elseif(@$bookdetail->paymentdetail->status == 2)
						Failed
						@else
						Pending
						@endif
		</a>
		</div>
										</td>
										<td>
											<i class="fa fa-inr"></i> {{@@$bookdetail->paymentdetail->amount}}
										</td>
										<td>
											<div class="nav-item dropdown action_dropdown">
												<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
												<div class="dropdown-menu">
													<a href="{{URL::to('/admin/bookings/detail/'.base64_encode(convert_uuencode(@$bookdetail->id)))}}"><i class="fa fa-edit"></i> View Detail</a>
													
												</div>
											</div>
										</td>
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
			<div class="modal-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<label for="pnr" class="col-sm-2 col-form-label">PNR No</label>
						<div class="col-sm-10">
							{{ Form::text('pnr', Request::get('pnr'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'PNR No', 'id' => 'pnr' )) }}
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<label for="ref" class="col-sm-2 col-form-label">Reference No</label>
						<div class="col-sm-10">
							{{ Form::text('ref', Request::get('ref'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Reference No', 'id' => 'ref' )) }}
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<label for="source" class="col-sm-2 col-form-label">Source</label>
						<div class="col-sm-10">
							<select class="form-control select2" name="source">
							<option value=""></option>
								@foreach(\App\Airport::all() as $list)
									<option value="{{$list->airport_code}}" <?php if(Request::get('source') == $list->airport_code){ echo 'selected'; } ?>>{{$list->city_name}} ({{$list->airport_code}})</option>
								@endforeach
							</select>
						</div>
					</div>
				</div> 
				<div class="col-md-6">
					<div class="form-group row">
						<label for="destination" class="col-sm-2 col-form-label">Destination</label>
						<div class="col-sm-10">
							<select class="form-control select2" name="destination">
							<option value=""></option>
								@foreach(\App\Airport::all() as $list)
									<option value="{{$list->airport_code}}" <?php if(Request::get('destination') == $list->airport_code){ echo 'selected'; } ?>>{{$list->city_name}} ({{$list->airport_code}})</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<?php /*<div class="col-md-6">
					<div class="form-group row">
						<label for="ref" class="col-sm-2 col-form-label">From Date</label>
						<div class="col-sm-10">
							{{ Form::text('from', Request::get('from'), array('class' => 'form-control commodate', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'From Date', 'id' => 'from' )) }}
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<label for="ref" class="col-sm-2 col-form-label">To Date</label>
						<div class="col-sm-10">
							{{ Form::text('to', Request::get('to'), array('class' => 'form-control commodate', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'To Date', 'id' => 'to' )) }}
						</div>
					</div>
				</div>*/ ?>
				<div class="col-md-6">
					<div class="form-group row">
						<label for="email" class="col-sm-2 col-form-label">Email</label>
						<div class="col-sm-10">
							{{ Form::text('email', Request::get('email'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Email', 'id' => 'email' )) }}
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<label for="mobile" class="col-sm-2 col-form-label">Mobile</label>
						<div class="col-sm-10">
							{{ Form::text('mobile', Request::get('mobile'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Mobile', 'id' => 'mobile' )) }}
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
								<option value="7">Cancelled</option>
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