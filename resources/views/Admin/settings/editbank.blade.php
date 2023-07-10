@extends('layouts.admin')
@section('title', 'Bank Accounts')

@section('content')
 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Bank Accounts</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Bank Accounts</li>
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
						<h3 class="card-title">Bank Accounts</h3>
					  </div> 
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/bank-accounts/edit', 'name'=>"add-city", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
					  <input type="hidden" name="id" value="{{@$fetchedData->id}}">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-4 ">
									<div class="form-group"> 
										<label for="company_bank_name" class="col-form-label">Company's Bank Name <span style="color:#ff0000;">*</span></label>
										{{ Form::text('company_bank_name', @$fetchedData->company_bank_name, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'' )) }}
						
										@if ($errors->has('company_bank_name'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('company_bank_name') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-4  ">
									<div class="form-group"> 
										<label for="account_no" class="col-form-label">Company's Bank A/C No <span style="color:#ff0000;">*</span></label>
									{{ Form::text('account_no', @$fetchedData->account_no, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'' )) }}
										@if ($errors->has('account_no'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('account_no') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-4  ">
									<div class="form-group"> 
										<label for="bank_name" class="col-form-label">Bank A/C Name <span style="color:#ff0000;">*</span></label>
									{{ Form::text('bank_name', @$fetchedData->bank_name, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'' )) }}
										@if ($errors->has('bank_name'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('bank_name') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-4  ">
									<div class="form-group"> 
										<label for="bank_address" class="col-form-label">Bank Address <span style="color:#ff0000;">*</span></label>
									{{ Form::text('bank_address', @$fetchedData->bank_address, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'' )) }}
										@if ($errors->has('bank_address'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('bank_address') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-4  ">
									<div class="form-group"> 
										<label for="bank_city" class="col-form-label">Bank City <span style="color:#ff0000;">*</span></label>
									{{ Form::text('bank_city', @$fetchedData->bank_city, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'' )) }}
										@if ($errors->has('bank_city'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('bank_city') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-4  ">
									<div class="form-group"> 
										<label for="postal_code" class="col-form-label">Bank Postal Code <span style="color:#ff0000;">*</span></label>
									{{ Form::text('postal_code', @$fetchedData->postal_code, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'' )) }}
										@if ($errors->has('postal_code'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('postal_code') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-4  ">
									<div class="form-group"> 
										<label for="ifsc_code" class="col-form-label">IFSC Code <span style="color:#ff0000;">*</span></label>
									{{ Form::text('ifsc_code', @$fetchedData->ifsc_code, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'' )) }}
										@if ($errors->has('ifsc_code'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('ifsc_code') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-4  ">
									<div class="form-group"> 
										<label for="swift_code" class="col-form-label">Swift Code <span style="color:#ff0000;">*</span></label>
									{{ Form::text('swift_code', @$fetchedData->swift_code, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'' )) }}
										@if ($errors->has('swift_code'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('swift_code') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-12" >
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