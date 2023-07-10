@extends('layouts.agent')
@section('title', 'Edit My Profile')
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
			{{ Form::open(array('url' => 'agent/edit-profile', 'name'=>"my-profile", 'enctype'=>'multipart/form-data')) }}
								{{ Form::hidden('id', $fetchedData->id) }}
			<div class="row">
				<div class="col-sm-12">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Company Information</h3>
							<div style="float: right;margin-bottom: 0px;">
							  <div class="form-group" style="margin-bottom: 0px;">
									{{ Form::button('<i class="fa fa-edit"></i> Update', ['class'=>'btn btn-primary px-4', 'onClick'=>'customValidate("my-profile")']) }}
							  </div> 
							 </div>	
						</div> 
						<div class="card-body agenteditform">
							<div class="row">  
								<div class="col-sm-12">
									<div class="form-group profile_img_field">
										<label for="test_pdf">Profile Image Upload</label>
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
								<div class="col-sm-6 inner_form_field">
									<div class="form-group">
										<label>Name <span style="color:#ff0000;">*</span></label>
										<div class="select_field">
											<select data-valid="required" class="form-control" name="salute_name">
												<option value="Mr" @if(@$fetchedData->sur_name == 'Mr') selected @endif>Mr</option>
												<option value="Mrs" @if(@$fetchedData->sur_name == 'Mrs') selected @endif>Mrs</option>
												<option value="Miss" @if(@$fetchedData->sur_name == 'Miss') selected @endif>Miss</option>
											</select>
										</div>
										<div class="input_field">
											<input autocomplete="off" data-valid="required" type="text" class="form-control" value="{{@$fetchedData->first_name}}" placeholder="First Name" name="first_name" />
										</div>
										<div class="input_field">
											<input autocomplete="off" data-valid="required" type="text" class="form-control" value="{{@$fetchedData->last_name}}" placeholder="Last Name" name="last_name" />
										</div> 
										<div class="clearfix"></div>
									</div>
								</div> 
								<div class="col-sm-6">
									<div class="form-group">
										<label for="mobile_no">Mobile <span style="color:#ff0000;">*</span></label>
											{{ Form::text('mobile_no', @$fetchedData->mobile_no, array('class' => 'form-control mask', 'data-valid'=>'required', 'placeholder'=>'')) }}
									
										@if ($errors->has('mobile_no'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('mobile_no') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="phone">Phone</label>
											{{ Form::text('phone', @$fetchedData->phone, array('class' => 'form-control mask', 'data-valid'=>'required', 'placeholder'=>'')) }}
									
										@if ($errors->has('phone'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('phone') }}</strong>
											</span>
										@endif
									</div>
								</div>
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
										<label for="address">Address 1<span style="color:#ff0000;">*</span></label>
										
									<textarea data-valid="required" name="address" class="form-control">{{@$fetchedData->address}}</textarea>
										@if ($errors->has('address'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('address') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-sm-6">	
									<div class="form-group">
										<label for="address2">Address 2</label>
										
									<textarea data-valid="" name="address2" class="form-control">{{@$fetchedData->address2}}</textarea>
										@if ($errors->has('address2'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('address2') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group country_field">
									<?php
										$country = 'IN';
										if(@$fetchedData->country != ''){
											$country = @$fetchedData->country ;
										}
										?>
										<label for="country">Country</label>
										 
										 <div name="country" class="niceCountryInputSelector country_input" id="basic" data-isrequired="norequired" data-selectedcountry="{{$country}}" data-showspecial="false" data-showflags="true" data-i18nall="All selected" data-i18nnofilter="No selection" data-i18nfilter="Filter" data-onchangecallback="onChangeCallback"></div>
										@if ($errors->has('country'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('country') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="state">State</label>
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
										<label for="city">City </label>
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
										<label for="zip">Zip Code</label>
											{{ Form::text('zip', @$fetchedData->zip, array('class' => 'form-control', 'data-valid'=>'required')) }}
									
										@if ($errors->has('zip'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('zip') }}</strong>
											</span>
										@endif
									</div>
								</div>
								
							</div>																
							
						</div>
					</div>
				</div>
			
				<div class="col-sm-12">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Company Logo & Documents</h3> 
						</div> 
						<div class="card-body">
							<div class="row">  
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
										<label for="faxno">Fax Number</label>
											{{ Form::text('faxno', @$fetchedData->faxno, array('class' => 'form-control', 'data-valid'=>'', 'placeholder'=>'faxno Name')) }}
									
										@if ($errors->has('faxno'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('faxno') }}</strong>
											</span>
										@endif
									</div>
								</div>
							</div>
							<div class="company_logos_sec">
								<div class="row"> 
									<div class="col-sm-4">
										<div class="form-group profile_img_field">
											<span>Company Logo</span>
											<input type="hidden" id="old_profile_logo" name="old_profile_logo" value="{{@$fetchedData->logo}}" />
											@if(@Auth::user()->logo == '') 
													
												@else
													<img width="100" height="100" id ="profile_logo" src="{{URL::to('/public/img/profile_imgs')}}/{{@Auth::user()->logo}}" class="img-avatar "/>
												@endif
											<div class="logo_update">	
												<input type="file" accept="image/*" onchange="loadFile(event)" name="profile_logo" class="form-control" />
												<a href="javascript:;">Update <i class="fa fa-refresh"></i></a>
												<p>Recomended 232X66</p>
											</div>
										</div>
									</div>
									
									<div class="col-sm-4">
										<div class="form-group profile_img_field">
											<span>Aadhaar Card</span>
											<input type="hidden" id="old_aadhaar_card" name="old_aadhaar_card" value="{{@$fetchedData->aadhaar_card}}" />
											@if(@Auth::user()->aadhaar_card == '') 
													
												@else
													<img id ="aadhaar_card" width="100" height="100"  src="{{URL::to('/public/img/agentdoc')}}/{{@Auth::user()->aadhaar_card}}" class="img-avatar"/>
												@endif
											<div class="logo_update">	
												<input type="file" accept="image/*" onchange="AadhaarloadFile(event)" name="aadhaar_card" class="form-control" />
												<a href="javascript:;">Update <i class="fa fa-refresh"></i></a>
											</div>	
										</div>
									</div> 
								</div>												
							</div>												
						</div>
					</div>
				</div>
				
				<div class="col-sm-12">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Tax Information</h3>
						</div> 
						<div class="card-body">
							<div class="row">  
								<div class="col-sm-6">
									<div class="form-group">
										<label for="gst_no">GST Number <span style="color:#ff0000;">*</span></label>
											{{ Form::text('gst_no', @$fetchedData->gst_no, array('class' => 'form-control mask', 'data-valid'=>'required', 'placeholder'=>'GST Number')) }}
									
										@if ($errors->has('gst_no'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('gst_no') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="pan_no">PAN Number</label>
											{{ Form::text('pan_no', @$fetchedData->pan_no, array('class' => 'form-control', 'data-valid'=>'', 'placeholder'=>'Pan Number')) }}
									
										@if ($errors->has('pan_no'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('pan_no') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="pan_name">PAN Name <span style="color:#ff0000;">*</span></label>
											{{ Form::text('pan_name', @$fetchedData->pan_name, array('class' => 'form-control mask', 'data-valid'=>'required', 'placeholder'=>'PAN Name')) }}
									
										@if ($errors->has('pan_name'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('pan_name') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="pan_address">Address Name</label>
											{{ Form::text('pan_address', @$fetchedData->pan_address, array('class' => 'form-control', 'data-valid'=>'', 'placeholder'=>'Address Name')) }}
									
										@if ($errors->has('pan_address'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('pan_address') }}</strong>
											</span>
										@endif
									</div>
								</div>
							</div>
							<div class="company_logos_sec">
								<div class="row"> 
									<div class="col-sm-6">
										<div class="form-group profile_img_field">
											<span>GST Doc</span>
											<input type="hidden" id="old_gst_logo" name="old_gst_logo" value="{{@$fetchedData->gst_logo}}" />
											@if(@Auth::user()->gst_logo == '') 
													
												@else
													<img src="{{URL::to('/public/img/profile_imgs')}}/{{@Auth::user()->gst_logo}}" class="img-avatar"/>
												@endif
											<div class="logo_update">	
												<input type="file" name="gst_logo" class="form-control" />
												<a href="javascript:;">Update <i class="fa fa-refresh"></i></a>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group profile_img_field">
											<span>PAN Doc</span>
											<input type="hidden" id="old_company_pancard" name="old_company_pancard" value="{{@$fetchedData->company_pancard}}" />
											@if(@Auth::user()->company_pancard == '') 
													
												@else
													<img width="100" height="100" src="{{URL::to('/public/img/agentdoc')}}/{{@Auth::user()->company_pancard}}" class="img-avatar"/>
												@endif
											<div class="logo_update">	
												<input type="file" name="company_pancard" class="form-control" />
												<a href="javascript:;">Update <i class="fa fa-refresh"></i></a>
											</div>
										</div> 
									</div>   
								</div>												
							</div>												
						</div>
					</div>
				</div>
				
				<div class="col-sm-12">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Account Detail</h3>
						</div> 
						<div class="card-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="username">Agency Code <span style="color:#ff0000;">*</span></label>
											{{ Form::text('username', @$fetchedData->username, array('class' => 'form-control', 'readonly'=>'true', 'placeholder'=>'Agency Code')) }}
									
										@if ($errors->has('username'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('username') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="contact_name">Contact Name</label>
											{{ Form::text('contact_name', @$fetchedData->contact_name, array('class' => 'form-control', 'data-valid'=>'', 'placeholder'=>'Contact Name')) }}
									
										@if ($errors->has('contact_name'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('contact_name') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="contact_no">Contact No</label>
											{{ Form::text('contact_no', @$fetchedData->contact_no, array('class' => 'form-control', 'data-valid'=>'', 'placeholder'=>'Contact No')) }}
									
										@if ($errors->has('contact_no'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('contact_no') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="password">Password</label>
											{{ Form::text('password', '', array('class' => 'form-control', 'data-valid'=>'', 'placeholder'=>'Password')) }}
									
										@if ($errors->has('password'))
											<span class="custom-error" role="alert">
												<strong>{{ $errors->first('password') }}</strong>
											</span>
										@endif
									</div>
								</div>
							</div> 
							<div class="package_full_form" style="text-align: right;">
								<div class="form-group">
									{{ Form::button('<i class="fa fa-edit"></i> Update', ['class'=>'btn btn-primary px-4', 'onClick'=>'customValidate("my-profile")']) }}
								</div> 
							</div>													
						</div>
					</div>
				</div>
			</div>
			{{ Form::close() }}	 
		</div>
	</section>
</div>
<script>
  var loadFile = function(event) {
    var output = document.getElementById('profile_logo');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
  
  var AadhaarloadFile = function(event) {
    var Aadhaaroutput = document.getElementById('aadhaar_card');
    Aadhaaroutput.src = URL.createObjectURL(event.target.files[0]);
    Aadhaaroutput.onload = function() {
      URL.revokeObjectURL(Aadhaaroutput.src) // free memory
    }
  };
</script>
@endsection