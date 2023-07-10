@extends('layouts.admin')
@section('title', 'Api Managment')

@section('content')
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Api Managment</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Api Managment</li>
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
	<section class="content custom_setting sms-setting">
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
						<h3 class="card-title">Api Managment</h3>
					  </div> 
					  <!-- /.card-header -->
					  <!-- form start -->
					  
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
								<div id="tabs">
									<div class="nav flex-column nav-tabs h-100 custom_nav_tabs" id="vert-tabs-tab" role="tablist" aria-orientation="horizontal">
									 <a class="nav-link active" id="vert-tabs-Web2sms-tab" data-toggle="pill" href="#vert-tabs-Web2sms" role="tab" aria-controls="vert-tabs-Web2sms" aria-selected="true">Flights</a>
									 
									   <a class="nav-link " id="vert-tabs-twillo-tab" data-toggle="pill" href="#vert-tabs-twillo" role="tab" aria-controls="vert-tabs-twillo" aria-selected="true">Hotels</a>
									  </div>
									 <div class="tab-content custom_tab_content" id="vert-tabs-tabContent">
									  <div class="tab-pane text-left fade show active" id="vert-tabs-Web2sms" role="tabpanel" aria-labelledby="vert-tabs-Web2sms-tab">
									  {{ Form::open(array('url' => 'admin/settings/api/store', 'name'=>"add-package", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="flight_clientid" class="col-form-label">ClientId <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[flight_clientid]', @App\MyConfig::where('meta_key','flight_clientid')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'flight_clientid' )) }}
													@if ($errors->has('flight_clientid'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('flight_clientid') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="flight_username" class="col-form-label">UserName <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[flight_username]', @App\MyConfig::where('meta_key','flight_username')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'flight_username' )) }}
													@if ($errors->has('flight_username'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('flight_username') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="flight_password" class="col-form-label">Password <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[flight_password]', @App\MyConfig::where('meta_key','flight_password')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'flight_password' )) }}
													@if ($errors->has('flight_password'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('flight_password') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="flight_EndUserIp" class="col-form-label">EndUserIp <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[flight_EndUserIp]', @App\MyConfig::where('meta_key','flight_EndUserIp')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'flight_EndUserIp' )) }}
													@if ($errors->has('flight_EndUserIp'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('flight_EndUserIp') }}</strong>
														</span> 
													@endif
												</div> 
											</div>
											
											<div class="col-sm-12">
												<div class="form-group form_label"> 
													<label for="flight_status" class="col-form-label" style="margin-right:5px;">Test Mode </label>
													<input  class="change-status" value="1" <?php if(@App\MyConfig::where('meta_key','flight_status')->first()->meta_value == '1'){ echo 'checked'; } ?> type="checkbox" name="gateway[flight_status]" >
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
									   
									   <div class="tab-pane text-left fade show " id="vert-tabs-twillo" role="tabpanel" aria-labelledby="vert-tabs-twillo-tab">
									   {{ Form::open(array('url' => 'admin/settings/api/hotelstore', 'name'=>"add-twillo", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="hotel_api_key" class="col-form-label">Api Key <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[hotel_api_key]', @App\MyConfig::where('meta_key','hotel_api_key')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'hotel_api_key' )) }}
													@if ($errors->has('hotel_api_key'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('hotel_api_key') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="hotel_endpoint" class="col-form-label">End Point <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[hotel_endpoint]', @App\MyConfig::where('meta_key','hotel_endpoint')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'hotel_endpoint' )) }}
													@if ($errors->has('hotel_endpoint'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('hotel_endpoint') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											
											<div class="col-sm-12">
												<div class="form-group float-right">
													{{ Form::button('<i class="fa fa-save"></i> Save', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-twillo")' ]) }}
												</div> 
											</div>
										</div>
										{{ Form::close() }}
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