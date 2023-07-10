@extends('layouts.agent')
@section('title', 'Request History')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Request History</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Request History</li>
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
						
						<div class="card-body table-responsive p-0">
							<table id="departurecity_table" class="table table-bordered table-hover text-nowrap">
							  <thead>
								<tr>
								  <th>Sr. No</th>
								  <th>Action Date</th>
								  <th>Payment Type</th>
								  <th>Transaction ID</th> 
								  <th>Trans Date</th> 
								  <th>Amount</th>
								  <th>Status</th>
								</tr> 
							  </thead>
							  <tbody class="tdata">	 
								@if(@$totalData !== 0)
									<?php $is = 1; ?>
								@foreach (@$lists as $lis)	
								<tr id="id_{{@$lis->id}}"> 
									<td>{{ @$is }}</td> 
									<td>{{date('d/m/Y', strtotime($lis->created_at))}}</td> 
									<td>{{$lis->pay_mode}}</td>
									<td>{{$lis->bank_transaction_id}}</td>
									<td>{{date('d/m/Y', strtotime($lis->pay_date))}}</td>
									<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b>{{$lis->amount}}</b></td>
									<td class="check_status">
									@if($lis->status == 1)
										<span class="priority_green priority_style">Recharged</span>
									@elseif($lis->status == 2)
										<span class="priority_medium priority_style">Rejected</span>
										@else 
											<span class="priority_high priority_style">Pending</span>
									@endif
									</td> 
								</tr>	
								<?php $is++; ?>
								@endforeach						
							  </tbody>
							  @else
							  
							@endif
							</table>
							<div class="card-footer">
							
							 </div>
						  </div>
					</div>	
				</div>	
			</div>
		</div>
	</section>
</div>
@endsection