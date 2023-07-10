@extends('layouts.admin')
@section('title', 'Transaction Log')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Transaction Log</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Transaction Log</li>
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
						{{ Form::open(array('name'=>"search-form", 'method' => 'get', 'autocomplete'=>'off')) }}
							<div class="row">
								<div class="col-md-12">
									<div class="nav-item dropdown action_dropdown cus_action_btn" style="float:right;">
										<a href="javascript:;" onclick="history.go(-1);" class="nav-link btn btn-primary btn-rounded back_btn"><i class="fa fa-arrow-left"></i> Back</a>
									</div> 
								</div> 
								<div class="col-md-4">
									<div class="form-group">
										 <label for="">From</label>
										  <input type="text" class="form-control" id="fromdate" name="fromdate" value="{{Request::get('fromdate')}}" placeholder="From Date..." autocomplete="off" required="">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										 <label for="">To</label>
										  <input type="text" class="form-control" id="todate" name="todate" value="{{Request::get('todate')}}" placeholder="To Date..." autocomplete="off" required="">
									</div>
								</div>
								<div class="col-md-12 text-left">
									<ul class="mb-0 list-inline">
										<li class="list-inline-item"><button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button></li>
										<li class="list-inline-item"><a href="{{URL::to('agent/excel_transaction_log/'.$userid)}}/?fromdate={{Request::get('fromdate')}}&todate={{Request::get('todate')}}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export</a></li>
									</ul>
								</div>
								
							</div>
							{{ Form::close() }}
						</div>
						<div class="card-body table-responsive p-0">
							<table id="invoicetable" class="table table-bordered table-hover text-nowrap">
							  <thead>
								<tr>
								  <th class="no-sort"> #</th>
								  <th class="no-sort">Detail</th>
								   <th class="no-sort">Dr</th> 
								  <th class="no-sort">Cr</th>
								  <th class="no-sort">Balance</th>
								 <th class="no-sort">Date</th> 
								</tr> 
							  </thead>
							  <tbody class="tdata">	 
								
									<?php $is = 1; ?>
								@foreach (@$lists as $lis)	
								<tr id="id_{{@$lis->id}}"> 
									<td>{{$is}}</td>
									<td>
									<?php
									if($lis->remark == 'Generate Ticket'){
										echo 'Flight Booking (ID - '.$lis->reference_id.')';
									}else{
										echo $lis->remark;
									}
									?>
									</td>	
									<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b> <?php echo  @$lis->credit;  ?></b></td>							
									<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b> <?php echo  @$lis->debit; ?></b></td>		
			
									<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b> <?php echo  @$lis->balance; ?></b></td>
									<td>{{date('h:i A, d M Y', strtotime($lis->created_at))}}</td> 
								</tr>	
								<?php $is++; ?>
								@endforeach						
							  </tbody>
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