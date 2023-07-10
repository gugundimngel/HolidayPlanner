@extends('layouts.admin')
@section('title', 'Payment Gateway')

@section('content')
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Payment Gateway</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Payment Gateway</li>
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
						<h3 class="card-title">Payment Gateway</h3>
					  </div> 
					  <!-- /.card-header -->
					  <!-- form start -->
					  
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
								<div id="tabs">
									<div class="nav flex-column nav-tabs h-100 custom_nav_tabs" id="vert-tabs-tab" role="tablist" aria-orientation="horizontal">
									 <a class="nav-link active" id="vert-tabs-ccavenue-tab" data-toggle="pill" href="#vert-tabs-ccavenue" role="tab" aria-controls="vert-tabs-ccavenue" aria-selected="true">CCAvenue</a>
									  <a class="nav-link " id="vert-tabs-paypal-tab" data-toggle="pill" href="#vert-tabs-paypal" role="tab" aria-controls="vert-tabs-paypal" aria-selected="true">Razorpay</a>
									   <a class="nav-link " id="vert-tabs-payu-tab" data-toggle="pill" href="#vert-tabs-payu" role="tab" aria-controls="vert-tabs-payu" aria-selected="true">PayUmoney</a>
									  </div>
									 <div class="tab-content custom_tab_content" id="vert-tabs-tabContent">
									  <div class="tab-pane text-left fade show active" id="vert-tabs-ccavenue" role="tabpanel" aria-labelledby="vert-tabs-ccavenue-tab">
									  {{ Form::open(array('url' => 'admin/settings/payment-gateway/store', 'name'=>"add-package", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="gateway_name" class="col-form-label">Name <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[cc_name]', @App\MyConfig::where('meta_key','cc_name')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'gateway_name' )) }}
													@if ($errors->has('gateway_name'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('gateway_name') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											<div class="col-sm-6"> 
												<div class="form-group"> 
													<label for="merchant_id" class="col-form-label">Merchant Id <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[cc_merchant_id]', @App\MyConfig::where('meta_key','cc_merchant_id')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'merchant_id' )) }}
													@if ($errors->has('merchant_id'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('merchant_id') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="access_code" class="col-form-label">Access Code <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[cc_access_code]', @App\MyConfig::where('meta_key','cc_access_code')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'access_code' )) }}
													@if ($errors->has('access_code'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('access_code') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="working_key" class="col-form-label">Working Key <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[cc_working_key]', @App\MyConfig::where('meta_key','cc_working_key')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'working_key' )) }}
													@if ($errors->has('working_key'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('working_key') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="working_key" class="col-form-label">Gateway URL <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[cc_gateway_url]', @App\MyConfig::where('meta_key','cc_gateway_url')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'gateway_url' )) }}
													@if ($errors->has('gateway_url'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('gateway_url') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group"> 
													<label for="working_key" class="col-form-label"><input  class="change-status" value="1" <?php if(@App\MyConfig::where('meta_key','cc_status')->first()->meta_value == '1'){ echo 'checked'; } ?> type="checkbox" name="gateway[cc_status]" > Published </label>
													
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group float-right">
													{{ Form::button('<i class="fa fa-save"></i> Save', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-package")' ]) }}
												</div> 
											</div>
										</div>
										{{ Form::close() }}
									  </div>
									   <div class="tab-pane text-left" id="vert-tabs-paypal" role="tabpanel" aria-labelledby="vert-tabs-paypal-tab">
										{{ Form::open(array('url' => 'admin/settings/payment-gateway/store', 'name'=>"add-razor", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
											<div class="row">
												<div class="col-sm-6">
												<div class="form-group"> 
													<label for="rz_paykey" class="col-form-label">Razorpay Key<span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[rz_paykey]', @App\MyConfig::where('meta_key','rz_paykey')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'rz_paykey' )) }}
													@if ($errors->has('rz_paykey'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('rz_paykey') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="rz_paysecret" class="col-form-label">Razorpay Secret<span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[rz_paysecret]', @App\MyConfig::where('meta_key','rz_paysecret')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'rz_paysecret' )) }}
													@if ($errors->has('rz_paysecret'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('rz_paysecret') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											<div class="col-sm-12">
											
												<div class="form-group"> 
													<label for="rz_status" class="col-form-label"><input  class="change-status" value="1" <?php if(@App\MyConfig::where('meta_key','rz_status')->first()->meta_value == '1'){ echo 'checked'; } ?> type="checkbox" name="gateway[rz_status]" > Published 
													
													</label>
												</div>
											</div>
												<div class="col-sm-12">
													<div class="form-group float-right">
														{{ Form::button('<i class="fa fa-save"></i> Save', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-razor")' ]) }}
													</div> 
												</div>
												
											</div>
										{{ Form::close() }}
									  </div>
									   <div class="tab-pane text-left " id="vert-tabs-payu" role="tabpanel" aria-labelledby="vert-tabs-payu-tab">
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

@endsection