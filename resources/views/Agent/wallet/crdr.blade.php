@extends('layouts.agent')
@section('title', 'Credit/Debit History')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Credit/Debit History</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Credit/Debit History</li>
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
							<table id="invoicetable" class="table table-bordered table-hover text-nowrap">
							  <thead>
								<tr>
								  <th class="no-sort"> S. N.</th>
								  <th class="no-sort">Action Date</th>
								  <th class="no-sort">Cr</th>
								  <th class="no-sort">Dr</th> 
								  <th class="no-sort">Remark</th> 
								</tr> 
							  </thead>
							  <tbody class="tdata">	 
								@if(@$totalData !== 0)
									<?php $is = 1; ?>
								@foreach (@$lists as $lis)	
								<tr id="id_{{@$lis->id}}"> 
									<td>{{$is}}</td>
									<td>{{date('d/m/Y', strtotime($lis->created_at))}}</td> 
									<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b><?php if(@$lis->type == 'credit'){ echo  @$lis->amount; }else{ echo '----'; } ?></b></td>		
									<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b><?php if(@$lis->type == 'debit'){ echo  @$lis->amount; }else{ echo '----'; } ?></b></td>
									<td>{{$lis->remark}}</td>
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