@extends('layouts.admin')
@section('title', 'Credit Limit Log')

@section('content')
 
<!-- Content Wrapper. Contains page content --> 
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Credit Limit Log</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Credit Limit Log</li>
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
							<div class="row">
								<div class="col-md-12">
									<div class="nav-item dropdown action_dropdown cus_action_btn" style="float:right;">
										<a href="javascript:;" onclick="history.go(-1);" class="nav-link btn btn-primary btn-rounded back_btn"><i class="fa fa-arrow-left"></i> Back</a>
									</div> 
								</div>
							</div>
						</div>
						<div class="card-body table-responsive p-0">
							<table id="invoicetable" class="table table-bordered table-hover text-nowrap">
							  <thead>
								<tr>
								  <th class="no-sort"> S. N.</th>
								  <th class="no-sort">Detail</th>
								  <th class="no-sort">Limit</th>
								  <th class="no-sort">Date</th> 
								</tr> 
							  </thead>
							  <tbody class="tdata">	 
								@if(@$totalData !== 0)
									<?php $is = 1; ?>
								@foreach (@$lists as $lis)	
								<tr id="id_{{@$lis->id}}"> 
								<td>{{$is}}</td>
								<td>Company credit</td>
								<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b> {{$lis->credit_limit}}</b></td>
								<td>{{date('h:i A, d M Y', strtotime($lis->created_at))}}</td> 
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