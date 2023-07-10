@extends('layouts.admin')
@section('title', 'SMS Gateway')

@section('content')
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">SMS Gateway</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">SMS Gateway</li>
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
						<h3 class="card-title">SMS Gateway</h3>
					  </div> 
					  <!-- /.card-header -->
					  <!-- form start -->
					  
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
								<div id="tabs">
									<div class="nav flex-column nav-tabs h-100 custom_nav_tabs" id="vert-tabs-tab" role="tablist" aria-orientation="horizontal">
									 <a class="nav-link active" id="vert-tabs-Web2sms-tab" data-toggle="pill" href="#vert-tabs-Web2sms" role="tab" aria-controls="vert-tabs-Web2sms" aria-selected="true">Web2sms</a>
									 
									   <a class="nav-link " id="vert-tabs-twillo-tab" data-toggle="pill" href="#vert-tabs-twillo" role="tab" aria-controls="vert-tabs-twillo" aria-selected="true">MSG91</a>
									  </div>
									 <div class="tab-content custom_tab_content" id="vert-tabs-tabContent">
									  <div class="tab-pane text-left fade show active" id="vert-tabs-Web2sms" role="tabpanel" aria-labelledby="vert-tabs-Web2sms-tab">
									  {{ Form::open(array('url' => 'admin/settings/sms-gateway/store', 'name'=>"add-package", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="web2sms_senderid" class="col-form-label">Sender ID <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[web2sms_senderid]', @App\MyConfig::where('meta_key','web2sms_senderid')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'web2sms_senderid' )) }}
													@if ($errors->has('web2sms_senderid'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('web2sms_senderid') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="web2sms_routeid" class="col-form-label">Route Id <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[web2sms_routeid]', @App\MyConfig::where('meta_key','web2sms_routeid')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'web2sms_routeid' )) }}
													@if ($errors->has('web2sms_routeid'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('web2sms_routeid') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="web2sms_auth_key" class="col-form-label">Auth Key <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[web2sms_auth_key]', @App\MyConfig::where('meta_key','web2sms_auth_key')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'web2sms_auth_key' )) }}
													@if ($errors->has('web2sms_auth_key'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('web2sms_auth_key') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="web2sms_gateway_url" class="col-form-label">Gateway URL <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[web2sms_gateway_url]', @App\MyConfig::where('meta_key','web2sms_gateway_url')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'web2sms_gateway_url' )) }}
													@if ($errors->has('web2sms_gateway_url'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('web2sms_gateway_url') }}</strong>
														</span> 
													@endif
												</div> 
											</div>
											<div class="col-sm-12">
												<div class="form-group">  
													<label for="web2sms_smscontent" class="col-form-label">SMS Content </label>
													<textarea class="form-control" data-valid="required" name="gateway[web2sms_smscontent]">{{@App\MyConfig::where('meta_key','web2sms_smscontent')->first()->meta_value}}</textarea>
							 						@if ($errors->has('web2sms_smscontent'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('web2sms_smscontent') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group form_label"> 
													<label for="msg_status" class="col-form-label" style="margin-right:5px;">Published </label>
													<input  class="change-status" value="web2sms" <?php if(@App\MyConfig::where('meta_key','msg_status')->first()->meta_value == 'web2sms'){ echo 'checked'; } ?> type="checkbox" name="gateway[msg_status]" >
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
									   {{ Form::open(array('url' => 'admin/settings/sms-gateway/store', 'name'=>"add-twillo", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="msg_senderid" class="col-form-label">Sender ID <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[msg_senderid]', @App\MyConfig::where('meta_key','msg_senderid')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'msg_senderid' )) }}
													@if ($errors->has('msg_senderid'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('msg_senderid') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="msg_authkey" class="col-form-label">Auth Key <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[msg_authkey]', @App\MyConfig::where('meta_key','msg_authkey')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'msg_authkey' )) }}
													@if ($errors->has('msg_authkey'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('msg_authkey') }}</strong>
														</span> 
													@endif
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="msg_template_id" class="col-form-label">SMS Template ID <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[msg_template_id]', @App\MyConfig::where('meta_key','msg_template_id')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'msg_template_id' )) }}
													@if ($errors->has('msg_template_id'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('msg_template_id') }}</strong>
														</span> 
													@endif
												</div> 
											</div>
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="msg_otptemplate_id" class="col-form-label">OTP Template ID <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[msg_otptemplate_id]', @App\MyConfig::where('meta_key','msg_otptemplate_id')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'msg_otptemplate_id' )) }}
													@if ($errors->has('msg_otptemplate_id'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('msg_otptemplate_id') }}</strong>
														</span> 
													@endif
												</div> 
											</div>
											
											<div class="col-sm-6">
												<div class="form-group"> 
													<label for="msg_gateway_url" class="col-form-label">Gateway URL <span style="color:#ff0000;">*</span></label>
													{{ Form::text('gateway[msg_gateway_url]', @App\MyConfig::where('meta_key','msg_gateway_url')->first()->meta_value, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'','id'=>'msg_gateway_url' )) }}
													@if ($errors->has('msg_gateway_url'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('msg_gateway_url') }}</strong>
														</span> 
													@endif
												</div> 
											</div>
											
											<div class="col-sm-12">
												<div class="form-group">  
													<label for="msg_smscontent" class="col-form-label">SMS Content </label>
													<textarea class="form-control" data-valid="required" name="gateway[msg_smscontent]">{{@App\MyConfig::where('meta_key','msg_smscontent')->first()->meta_value}}</textarea>
							 						@if ($errors->has('msg_smscontent'))
														<span class="custom-error" role="alert">
															<strong>{{ @$errors->first('msg_smscontent') }}</strong>
														</span> 
													@endif 
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group form_label">
													<label for="msg_status" class="col-form-label" style="margin-right:5px;">Published </label>
													<input  class="change-status" value="msgnine" <?php if(@App\MyConfig::where('meta_key','msg_status')->first()->meta_value == 'msgnine'){ echo 'checked'; } ?> type="checkbox" name="gateway[msg_status]" >
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