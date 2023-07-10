@extends('layouts.admin')
@section('title', 'Profit & Loss')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Profit & Loss</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Profit & Loss</li>
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
										<a class="dropdown-toggle btn btn-block btn-outline-primary btn-sm is_not_selected_invoice" data-toggle="dropdown" href="{{URL::to('/admin/profitloss')}}" aria-expanded="false"><i class="fa fa-plus"></i> <?php if(isset($_GET['type']) && $_GET['type'] == 'b2c'){ echo 'B2C'; }else if(isset($_GET['type']) && $_GET['type'] == 'b2b'){ echo 'B2B'; }else{ echo 'ALL'; } ?> <span class="caret"></span></a>
										<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 31px, 0px);">
											<a class="dropdown-item" tabindex="-1" href="{{URL::to('/admin/profitloss')}}">All Profit & Loss</a>
										  <a class="dropdown-item" tabindex="-1" href="{{URL::to('/admin/profitloss')}}?type=b2c">B2C Profit & Loss</a>
										  <a class="dropdown-item" tabindex="-1" href="{{URL::to('/admin/profitloss')}}?type=b2b">B2B Profit & Loss</a>
										</div>											
									</li>
								</ul>
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
							<!--<div class="card-tools card_tools">
								<a href="javascript:;" data-toggle="modal" data-target="#amnetsearch_modal" class="btn btn-primary"><i class="fas fa-search"></i></a>
							</div>-->
							<div class="print_export">
								<ul>
									<li class="print"><a dataurl="{{URL::to('/admin/profitloss')}}?type={{@$_GET['type']}}&action=print" href="javascript:;" class="print_myinvoice"><i class="fas fa-print"></i> Print</a></li>
									<li class="export"><a href="{{URL::to('/admin/profitloss')}}?type={{@$_GET['type']}}&action=excel"><i class="fas fa-file-excel"></i> Export</a></li>
								</ul>
							</div>	 
						</div>
						
						<div class="card-body table-responsive">
<table id="invoicetable" class="table table-bordered table-hover text-nowrap">
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
	$bookingib_request = json_decode(@$bookdetail->bookingib_request);
	$commission = @$booking_response->Response->Response->FlightItinerary->Fare->OfferedFare - @$booking_response->Response->Response->FlightItinerary->Fare->PublishedFare;
	$ibcommission = @$booking_response_ib->Response->Response->FlightItinerary->Fare->OfferedFare - @$booking_response_ib->Response->Response->FlightItinerary->Fare->PublishedFare;
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
				<span><a href="{{URL::to('/admin/log/'.base64_encode(convert_uuencode(@$bookdetail->id)))}}" target="_blank" class="view_log">View Log</a></span>
			</div>
		</td>
	
		<td>
			<i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b> {{@$bookdetail->paymentdetail->amount}}</b>
		</td>
		<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b> {{@$list->paymentdetail->markupob+@$list->paymentdetail->markupib + @$commission + @$ibcommission}}</b></td>
	</tr>
	<?php $i++; $totalcom = @$list->paymentdetail->markupob+@$list->paymentdetail->markupib + @$commission + @$ibcommission; ?>
	@endforeach
</tbody>
								<tfoot>
									<tr>
										<td colspan="8">
											<div class="total_value">
												<span>Total Admin Profit: <i class="fa fa-rupee-sign" style="vertical-align: middle;"></i>{{number_format($totalcom, 2)}}</span>
											</div>
										</td>
									</tr>
								</tfoot>
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