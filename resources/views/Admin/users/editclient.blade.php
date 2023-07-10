@extends('layouts.admin')
@section('title', 'Edit Client')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Edit Client</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit Client</li>
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
						<h3 class="card-title">Edit Client</h3>
					  </div>
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/users/editclient', 'name'=>"edit-client", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
					   {{ Form::hidden('id', @$fetchedData->id) }}
						<div class="card-body">	
							<div class="row"> 
								<div class="col-sm-12"> 
									<div class="form-group" style="text-align:right;">
										<a style="margin-right:5px;" href="{{route('admin.users.clientlist')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a> 
										{{ Form::submit('Update Client', ['class'=>'btn btn-primary' ]) }}
									</div> 
								</div>								
								<div class="col-sm-6">
									<div class="form-group">
										<label for="first_name">First Name</label>
										{{ Form::text('first_name', @$fetchedData->first_name, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'First Name' )) }}
										@if ($errors->has('first_name'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('first_name') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="last_name">Last Name</label>
										{{ Form::text('last_name', @$fetchedData->last_name, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Last Name' )) }}
										@if ($errors->has('last_name'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('last_name') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="company_name">Company Name</label>
										{{ Form::text('company_name', @$fetchedData->company_name, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Company Name' )) }}
										@if ($errors->has('company_name'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('company_name') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="company_website">Company Website</label>
										{{ Form::text('company_website', @$fetchedData->company_website, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Company Website' )) }}
										@if ($errors->has('company_website'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('company_website') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="email">Email</label>
										{{ Form::text('email', @$fetchedData->email, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Email' )) }}
										@if ($errors->has('email'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('email') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="password">Password</label>
										<input type="password" name="password" class="form-control" autocomplete="off" value="" placeholder="Enter Password" data-valid="required" />							
										@if ($errors->has('password'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('password') }}</strong>
											</span> 
										@endif
									</div> 
								</div> 
								<div class="col-sm-6">
									<div class="form-group">
										<label for="phone">Phone No.</label>
										{{ Form::text('phone', @$fetchedData->phone, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Phone Number' )) }}
										@if ($errors->has('phone'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('phone') }}</strong>
											</span> 
										@endif
									</div> 
								</div> 
								<div class="col-sm-6">						  
									<div class="form-group">
										<label for="profile_img">Company Logo</label>
										<input type="hidden" id="old_profile_img" name="old_profile_img" value="{{@$fetchedData->profile_img}}" />
										
										<input type="file" name="profile_img" class="form-control" autocomplete="off" data-valid="required" />
										
										<div class="show-uploded-img">	
											@if(@$fetchedData->profile_img != '')
												<img src="{{URL::to('/public/img/profile_imgs')}}/{{@$fetchedData->profile_img}}" class="img-avatar"/>
											@endif
										</div> 								
										@if ($errors->has('profile_img'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('profile_img') }}</strong>
											</span> 
										@endif 
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group country_field"> 
										<label for="country" class="">Country <span style="color:#ff0000;">*</span></label>
										<div name="country" class="country_input" id="basic" data-input-name="country"></div>		 							
										@if ($errors->has('country'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('country') }}</strong>
											</span> 
										@endif 
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="city">City</label>
										{{ Form::text('city', @$fetchedData->city, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'City' )) }}
										@if ($errors->has('city'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('city') }}</strong>
											</span> 
										@endif 
									</div> 
								</div>
								<div class="clearfix"></div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="gst_no">GST No.</label>
										{{ Form::text('gst_no', @$fetchedData->gst_no, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'e.g. 22AAAAA00000AZ5' )) }}
										@if ($errors->has('gst_no'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('gst_no') }}</strong>
											</span> 
										@endif
									</div> 
								</div>
								<div class="col-sm-12">
									<div class="form-group float-right">
										{{ Form::submit('Update Client', ['class'=>'btn btn-primary' ]) }}
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