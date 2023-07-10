@extends('layouts.agent')
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
								
							</div>
							<div class="card_custom_menu">
								<ul>
									<li class="active"><a href="javascript:;">Flight</a></li>
									<li><a href="javascript:;">Hotel</a></li>
									<li><a href="javascript:;">Package</a></li>
									<li><a href="javascript:;">Bus</a></li>
									<li><a href="javascript:;">visa</a></li>
								</ul>
							</div>	
							<div class="card-tools card_tools">
								<a href="javascript:;" data-toggle="modal" data-target="#amnetsearch_modal" class="btn btn-primary"><i class="fas fa-search"></i></a>
							</div>
							<div class="print_export">
								<ul>
		<li class="print"><a dataurl="{{URL::to('/agent/bookings')}}?type={{@$_GET['type']}}&action=print&pnr={{@$_GET['pnr']}}&ref={{@$_GET['ref']}}&source={{@$_GET['source']}}&destination={{@$_GET['destination']}}&email={{@$_GET['email']}}&mobile={{@$_GET['mobile']}}&status={{@$_GET['status']}}" href="javascript:;" class="print_myinvoice"><i class="fas fa-print"></i> Print</a></li>
									<li class="export"><a href="{{URL::to('/agent/bookings')}}?type={{@$_GET['type']}}&action=excel&pnr={{@$_GET['pnr']}}&ref={{@$_GET['ref']}}&source={{@$_GET['source']}}&destination={{@$_GET['destination']}}&email={{@$_GET['email']}}&mobile={{@$_GET['mobile']}}&status={{@$_GET['status']}}"><i class="fas fa-file-excel"></i> Export</a></li>
								</ul>
							</div>
						</div>
						<!--<div class="card-header">   
							<div class="card-title">
								<a href="{{route('admin.invoice.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Invoices</a> 
							</div> 
							<div class="card-tools card_tools">
								<div class="input-group input-group-sm" style="width: 150px;">
									<input type="text" name="table_search" class="form-control float-right" placeholder="Search">
									<div class="input-group-append">
										<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
									</div>
								</div>
							</div>
						</div> -->
						<div class="card-body table-responsive">
							<table id="invoicetable" class="table table-bordered table-hover text-nowrap">
								<thead>
									<tr> 
										<th class="no-sort"> S. N.</th>
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
								<?php $i= 0; ?>
								@foreach($lists as $bookdetail)
								<?php 
								$i++;
									$booking_response = json_decode($bookdetail->booking_response);
									$bookingib_request = json_decode($bookdetail->bookingib_request);
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
										@if(@$bookdetail->paymentdetail->status != 1)
											<a href="javascript:;">Ref. No.: ZAP-{{$bookdetail->id}}<br/>PNR: {{@$bookdetail->pnr}}</a>
											@else 
												<a target="_blank" href="{{URL::to('/ticket')}}/{{base64_encode(convert_uuencode(@$bookdetail->id))}}">Ref. No.: ZAP-{{$bookdetail->id}}<br/>PNR: {{@$bookdetail->pnr}}</a>
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
												<a href="javascript:;" class="<?php if($bookdetail->status == 1){ echo 'green_clr'; }else{ echo 'red_clr'; } ?> chk_stat_btn">@if($bookdetail->status == 1)
													Confirm
														@elseif($bookdetail->status == 2)
															Failed
														@else
															Pending
															@endif
											</a>
												<span><a href="{{URL::to('/agent/log/'.base64_encode(convert_uuencode(@$bookdetail->id)))}}" target="_blank" class="view_log">View Log</a></span>
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
										<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b> {{@@$bookdetail->paymentdetail->amount}}
										</b></td>
										<td>
											<div class="nav-item dropdown action_dropdown">
												<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
												<div class="dropdown-menu">
													<a href="{{URL::to('/agent/bookings/detail/'.base64_encode(convert_uuencode(@$bookdetail->id)))}}"><i class="fa fa-edit"></i> View Detail</a>
													
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
			
			<form action="{{URL::to('/agent/bookings')}}" method="get">
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