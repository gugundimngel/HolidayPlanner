@extends('layouts.admin')
@section('title', 'Markup')

@section('content')
 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Manage Markup</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Manage Markup</li>
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
					<div class="card card-primary">
					  <div class="card-header">
						<h3 class="card-title">New Markup</h3>
					  </div> 
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/flightmarkup/store', 'name'=>"add-city", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group" style="text-align:right;">
										<a style="margin-right:5px;" href="{{route('admin.flightmarkup')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
										{{ Form::button('<i class="fa fa-save"></i> Save Markup', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-city")' ]) }}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="flight_code" class="col-form-label">Flight Code <span style="color:#ff0000;">*</span></label>
										{{ Form::text('flight_code', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Flight Code' )) }}
										@if ($errors->has('flight_code'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('flight_code') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="flight_type" class="col-form-label">Flight Type <span style="color:#ff0000;">*</span></label>
										<select class="form-control" name="flight_type" >
											<option value="domestic">Domestic</option>
											<option value="international">International</option>
										</select>
										@if ($errors->has('flight_type'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('flight_type') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="service_fee" class="col-form-label">Service Fee/Markup<span style="color:#ff0000;">*</span></label>
										{{ Form::text('service_fee', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Service Fee' )) }}
										@if ($errors->has('service_fee'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('service_fee') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="service_type" class="col-form-label">Type <span style="color:#ff0000;">*</span></label>
										<select data-valid="required" class="form-control" name="service_type" >
											<option value=""></option>
											<option value="Percentage">Percentage</option>
											<option value="fixed">Fixed</option>
										</select>
										@if ($errors->has('service_type'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('service_type') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								{{-- <div class="col-sm-6">
									<div class="form-group"> 
										<label for="commission_fee" class="col-form-label">Commission Fee <span style="color:#ff0000;">*</span></label>
										{{ Form::text('commission_fee', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Commission Fee' )) }}
										@if ($errors->has('commission_fee'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('commission_fee') }}</strong>
											</span> 
										@endif
									</div>
								</div> --}}
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="user_type" class="col-form-label">User Type <span style="color:#ff0000;">*</span></label>
										<select class="form-control" name="user_type" >
											<option value="b2c">B2C</option>
											<option value="b2b">B2B</option>
										</select>
										@if ($errors->has('user_type'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('user_type') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group float-right">
										{{ Form::button('<i class="fa fa-save"></i> Save', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-city")' ]) }}
									</div> 
								</div> 
							</div> 
						</div> 
					  {{ Form::close() }}
					</div>	
				</div>	
			</div>
		</div>
	</section>
</div>
@endsection