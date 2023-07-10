@extends('layouts.admin')
@section('title', 'My Profile')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">My Profile</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">My Profile</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
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
			</div>	
			<div class="row">
				<div class="col-sm-12">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">My Profile</h3>
							<label style="float: right;margin-bottom: 0px;" for="name"><span style="color:#ff0000;">*</span> Fields are mandatory.</label>
						</div> 
						<div class="card-body">
							{{ Form::open(array('url' => 'admin/my_profile', 'name'=>"my-profile", 'enctype'=>'multipart/form-data')) }}
								{{ Form::hidden('id', $fetchedData->id) }}
								<div class="row">  
									<div class="col-sm-6"> 
										<div class="form-group profile_img_field">
											<label for="test_pdf" style="display:block;">Profile Image Upload</label>
											<input type="hidden" id="old_profile_img" name="old_profile_img" value="{{@$fetchedData->profile_img}}" />
											<div class="show-uploded-img">	  
												@if(@Auth::user()->profile_img == '') 
													<img src="{{ asset('/public/img/avatars/default_profile.jpg') }}" class="img-avatar" />
												@else
													<img src="{{URL::to('/public/img/profile_imgs')}}/{{@Auth::user()->profile_img}}" class="img-avatar"/>
												@endif
												<div class="profile_input">
													<input type="file" name="profile_img" class="uploadImageFile" />
													<div class="capture_icon"><i class="fa fa-camera"></i></div>
												</div> 
											</div>    
										</div>
									</div> 
									<div class="col-sm-6">
										<div class="form-group">
											<label for="logo" style="display:block;">Logo</label>
											<input type="hidden" id="old_profile_logo" name="old_profile_logo" value="{{@$fetchedData->logo}}" />
											@if(@Auth::user()->logo == '') 
													
												@else
													<img src="{{URL::to('/public/img/profile_imgs')}}/{{@Auth::user()->logo}}" class="img-avatar"/>
												@endif
											<input type="file" name="profile_logo" class="form-control" />
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="col-sm-6">
										<div class="form-group">
											@if(Auth::user()->role == 3)
												<label for="first_name">Organization Name <span style="color:#ff0000;">*</span></label>
											@else
												<label for="first_name">First Name <span style="color:#ff0000;">*</span></label>
											@endif	
											
												{{ Form::text('first_name', @$fetchedData->first_name, array('class' => 'form-control', 'data-valid'=>'required')) }}
										
											@if ($errors->has('first_name'))
												<span class="custom-error" role="alert">
													<strong>{{ $errors->first('first_name') }}</strong>
												</span>
											@endif
										</div>
									</div>
								@if(Auth::user()->role != 3)
									<div class="col-sm-6">
										<div class="form-group">
											<label for="last_name">Last Name <span style="color:#ff0000;">*</span></label>
												{{ Form::text('last_name', @$fetchedData->last_name, array('class' => 'form-control', 'data-valid'=>'required')) }}
										
											@if ($errors->has('last_name'))
												<span class="custom-error" role="alert">
													<strong>{{ $errors->first('last_name') }}</strong>
												</span>
											@endif
										</div>
									</div>
								@endif
								<div class="col-sm-6">
									<div class="form-group">
										<label for="email">Email <span style="color:#ff0000;">*</span></label>
											{{ Form::text('email', @$fetchedData->email, array('class' => 'form-control', 'data-valid'=>'required email', 'disabled'=>'disabled')) }}
									
										@if ($errors->has('email'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('email') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="phone">Phone <span style="color:#ff0000;">*</span></label>
											{{ Form::text('phone', @$fetchedData->phone, array('class' => 'form-control mask', 'data-valid'=>'required', 'placeholder'=>'000-000-0000')) }}
									
										@if ($errors->has('phone'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('phone') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="company_name">Company Name <span style="color:#ff0000;">*</span></label>
											{{ Form::text('company_name', @$fetchedData->company_name, array('class' => 'form-control mask', 'data-valid'=>'required', 'placeholder'=>'Company Name')) }}
									
										@if ($errors->has('company_name'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('company_name') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="company_website">Company Website <span style="color:#ff0000;">*</span></label>
											{{ Form::text('company_website', @$fetchedData->company_website, array('class' => 'form-control mask', 'data-valid'=>'required', 'placeholder'=>'Company Website')) }}
									
										@if ($errors->has('company_website'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('company_website') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="country">Country <span style="color:#ff0000;">*</span></label>
										 <div name="country" class="country_input" id="select_country" data-input-name="country"></div>
											@if ($errors->has('country'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('country') }}</strong>
												</span> 
											@endif		
										</select>
										
										@if ($errors->has('country'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('country') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="state">State <span style="color:#ff0000;">*</span></label>
											{{ Form::text('state', @$fetchedData->state, array('class' => 'form-control', 'data-valid'=>'required')) }}
									
										@if ($errors->has('state'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('state') }}</strong>
											</span>
										@endif
									</div>								
								</div>	
								<div class="col-sm-6">
									<div class="form-group">
										<label for="city">City <span style="color:#ff0000;">*</span></label>
											{{ Form::text('city', @$fetchedData->city, array('class' => 'form-control', 'data-valid'=>'required')) }}
									
										@if ($errors->has('city'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('city') }}</strong>
											</span>
										@endif
									</div>								
								</div>	
								<div class="col-sm-6">
									<div class="form-group">
										<label for="zip">Zip Code <span style="color:#ff0000;">*</span></label>
											{{ Form::text('zip', @$fetchedData->zip, array('class' => 'form-control', 'data-valid'=>'required')) }}
									
										@if ($errors->has('zip'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('zip') }}</strong>
											</span>
										@endif
									</div> 													
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="gst_no">GST No. <span style="color:#ff0000;">*</span></label>
											{{ Form::text('gst_no', @$fetchedData->gst_no, array('class' => 'form-control', 'data-valid'=>'required')) }}
									
										@if ($errors->has('gst_no'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('gst_no') }}</strong>
											</span>
										@endif
									</div>																
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="primary_email">Primary Email <span style="color:#ff0000;">*</span></label>
											{{ Form::text('primary_email', @$fetchedData->primary_email, array('class' => 'form-control', 'data-valid'=>'required')) }}
									
										@if ($errors->has('primary_email'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('primary_email') }}</strong>
											</span>
										@endif
									</div>																
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="b2c_email">B2C Email <span style="color:#ff0000;">*</span></label>
											{{ Form::text('b2c_email', @$fetchedData->b2c_email, array('class' => 'form-control', 'data-valid'=>'required')) }}
									
										@if ($errors->has('b2c_email'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('b2c_email') }}</strong>
											</span>
										@endif
									</div>																
								</div> 
								<div class="col-sm-6">
									<div class="form-group">
										<label for="b2b_email">B2B Email <span style="color:#ff0000;">*</span></label>
											{{ Form::text('b2b_email', @$fetchedData->b2b_email, array('class' => 'form-control', 'data-valid'=>'required')) }}
									
										@if ($errors->has('b2b_email'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('b2b_email') }}</strong>
											</span>
										@endif
									</div>																
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="ref_prefix">Reference ID Prefix<span style="color:#ff0000;">*</span></label>
											{{ Form::text('ref_prefix', @$fetchedData->ref_prefix, array('class' => 'form-control', 'data-valid'=>'required')) }}
									
										@if ($errors->has('ref_prefix'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('ref_prefix') }}</strong>
											</span>
										@endif
									</div>																
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="invoice_id">Invoice ID<span style="color:#ff0000;">*</span></label>
											{{ Form::text('invoice_id', @$fetchedData->invoice_id, array('class' => 'form-control', 'data-valid'=>'required')) }}
									
										@if ($errors->has('invoice_id'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('invoice_id') }}</strong>
											</span>
										@endif
									</div>																
								</div>

								<div class="col-sm-12">	
									<div class="form-group">
										<label for="address">Address <span style="color:#ff0000;">*</span></label>
										
									<textarea data-valid="required" name="address" class="form-control">{{@$fetchedData->address}}</textarea>
										@if ($errors->has('address'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('address') }}</strong>
											</span>
										@endif
									</div>
								</div>														
							</div>																
							<div class="form-group">
								{{ Form::button('<i class="fa fa-edit"></i> Update', ['class'=>'btn btn-primary px-4', 'onClick'=>'customValidate("my-profile")']) }}
							</div>
							{{ Form::close() }}	 
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<script>
jQuery(document).ready(function($){
	$('#select_country').attr('data-selected-country','<?php echo @$fetchedData->country; ?>');
		$('#select_country').flagStrap();
});
</script>
@endsection