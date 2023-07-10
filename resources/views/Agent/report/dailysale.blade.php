@extends('layouts.agent')
@section('title', 'Daily Sales Report')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Daily Sales Report</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Daily Sales Report</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->	
	
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
						<div class="card-body">
							<ul class="nav nav-tabs nav_custom_tabs" id="custom-tab" role="tablist">
								
								<li class="nav-item">
									<a class="nav-link active" id="all_report-tab" data-toggle="pill" href="#all_report" role="tab" aria-controls="all_report">B2B Daily Sales Report</a>
								</li>
							</ul>
							<div class="tab-content" id="custom-tab-content">
								
<div class="tab-pane active show" id="all_report" role="tabpanel" aria-labelledby="all_report-tab">
	<div class="all_sales_report common_report">
		<h4>Refine Your Results</h4>
		<div class="cus_report_field">	
		<form action="{{route('agent.dailysale')}}" autocomplete="off" method="get">
		<input type="hidden" name="type" value="b2b">
			<div class="row">	
				<div class="col-sm-4">
					<div class="form-group">
						<label>Submission Date From</label>
						<input value="{{Request::get('submission_from')}}" type="text" class="form-control commondate" name="submission_from" placeholder="01/04/2020"/>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<label>Submission Date To</label>
						<input value="{{Request::get('submission_to')}}" type="text" class="form-control commondate" name="submission_to" placeholder="mm/dd/yyyy"/>
					</div>
				</div>
				
				<div class="col-sm-12">
					<div class="generate_dsr_btn text-right">
						<button type="submit" class="cus_btn">Generate DSR</button>
					</div>
				</div>
			</div>
			</form>
		</div>
		<div class="row">	
			<div class="col-sm-6">
				<div class="table-responsive">
					<h4 class="table_heading">Hotel Results</h4>
					<table id="" class="table table-bordered table-hover text-nowrap domesticdata">
						<thead>
							<tr> 
								<th>SrNo</th>
								<th>AgentID</th>
								<th>Hotel</th>  
								<th>Total Sales</th>
							</tr> 
						</thead>
						<tbody> 
							
						</tbody>
						<tfoot>
							<tr>
								<td colspan="4"></td>
							</tr>
							<tr>
								<td colspan="3"><b>Gross Total</b></td>
								<td><b><i class="fa fa-rupee-sign"></i> 0.00</b></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="table-responsive">
					<h4 class="table_heading">Airline Results</h4>
					<table id="" class="table table-bordered table-hover text-nowrap domesticdata">
						<thead>
							<tr> 
								<th>Sr.No.</th>
								<th>AgentID</th>
								<th>Airline</th>
								<th>Total Sales</th>
								<th>Commission Earned</th>  
							</tr> 
						</thead>
						<tbody class="tdata booking_data ">
							<?php $totalcom = 0; $totalsale = 0; $i =1; foreach($b2blists as $list){ 
					$booking_response = json_decode(@$list->booking_response);
					$booking_response_ib = json_decode(@$list->booking_response_ib);
					//echo '<pre>'; print_r($booking_response);
					$commission = @$booking_response->Response->Response->FlightItinerary->Fare->OfferedFare - @$booking_response->Response->Response->FlightItinerary->Fare->PublishedFare;
					$ibcommission = @$booking_response_ib->Response->Response->FlightItinerary->Fare->OfferedFare - @$booking_response_ib->Response->Response->FlightItinerary->Fare->PublishedFare;
					?>
<tr>
<td>{{$i}}</td>
							<td>{{@$list->agent->username}}</td>

<td>{{@$booking_response->Response->Response->FlightItinerary->AirlineCode}}</td>
<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b> {{@$list->paymentdetail->amount}}</b></td>
<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b> {{@$commission + @$ibcommission}}</b></td>
</tr>
					<?php 
					$totalsale += @$list->paymentdetail->amount;
					$totalcom = @$commission + @$ibcommission;
					$i++; } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="5"></td>
							</tr>
							<tr>
								<td colspan="3"><b>Gross Total</b></td>
								<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b> {{number_format($totalsale, 2)}}</b></td>
								<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b> {{number_format($totalcom, 2)}}</b></td>
							</tr>
						</tfoot>
					</table>
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
		</div> 
	</section>
</div>
<script>

</script>
@endsection