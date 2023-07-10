@extends('layouts.admin')
@section('title', 'Visa Price')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Visa Price</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Visa</li>
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
						<div class="card-body">
							<div class="card-body table-responsive p-0">
								<table class="table table-bordered table-hover text-nowrap">
									<thead>
										<tr>
											<th>Visa Category</th>
											<th>Visa Type</th>
											<th>Processing Type</th>
											<th>Adult Cost B2B</th>
											<th>Adult Cost B2C</th>
											<th>Adult Cost Online</th>
											<th>Adult Cost Corporate</th>
											<th>Child Cost B2B</th>
											<th>Child Cost B2C</th>
											<th>Child Cost Online</th>
											<th>Child Cost Corporate</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>10 Days Visa</td>
											<td>Travel Visa</td>
											<td>Express</td>
											<td>500</td>
											<td>250</td>
											<td>150</td>
											<td>250</td>
											<td>100</td>
											<td>500</td>
											<td>500</td>
											<td>250</td>
											<td>
												<button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
												<button class="btn btn-sm btn-danger"><i class="fas fa-edit"></i></button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection