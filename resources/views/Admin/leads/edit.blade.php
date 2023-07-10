@extends('layouts.admin')
@section('title', 'Edit Lead')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Edit Lead</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit Lead</li>
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
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Edit Lead</h3>
						</div>
					  <!-- /.card-header -->
						<div class="card-body">
							<!-- form start -->
							{{ Form::open(array('url' => 'admin/leads/edit', 'name'=>"edit-leads", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
							 {{ Form::hidden('id', @$fetchedData->id) }}
								<div class="form-group" style="text-align:right;">
									<a style="margin-right:5px;" href="{{route('admin.leads.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a> 
									{{ Form::button('<i class="fa fa-edit"></i> Edit Leads', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-leads")' ]) }}
								</div> 	 
								<div class="row">  
									<div class="col-sm-6">  
										<div class="form-group row">  
											<label for="full_name" class="col-sm-3 col-form-label">Full Name <span style="color:#ff0000;">*</span></label>
											<div class="col-sm-9">
											{{ Form::text('full_name', @$fetchedData->name, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Full Name *' )) }}
											@if ($errors->has('full_name'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('full_name') }}</strong>
												</span> 
											@endif
											</div>  
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group row"> 
											<label for="email" class="col-sm-3 col-form-label">Email <span style="color:#ff0000;">*</span></label>
											<div class="col-sm-9">
											{{ Form::text('email', @$fetchedData->email, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Email *' )) }}
											@if ($errors->has('email'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('email') }}</strong>
												</span> 
											@endif
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group row"> 
											<label for="phone" class="col-sm-3 col-form-label">Phone No.<span style="color:#ff0000;">*</span></label>
											<div class="col-sm-9">
											{{ Form::text('phone', @$fetchedData->phone, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Phone No. *' )) }}
											@if ($errors->has('phone'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('phone') }}</strong>
												</span> 
											@endif
											</div>
										</div>
									</div>
									<div class="col-sm-6">	
										<div class="form-group row">
											<label for="going_to" class="col-sm-3 col-form-label">Going To</label>
											<div class="col-sm-9">
											{{ Form::text('going_to', @$fetchedData->going_to, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Going To' )) }}
											@if ($errors->has('going_to'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('going_to') }}</strong>
												</span> 
											@endif
											</div> 
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">										
										<div class="form-group row">
											<label for="departure_date" class="col-sm-3 col-form-label">Departure Date</label>
											<div class="col-sm-9">
											{{ Form::text('departure_date', @$fetchedData->travel_date, array('class' => 'form-control commodate', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Departure Date' )) }}
											@if ($errors->has('departure_date'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('departure_date') }}</strong>
												</span> 
											@endif
											</div>
										</div>
									</div>
									<div class="col-sm-6">	
										<div class="form-group row">
											<label for="service" class="col-sm-3 col-form-label">Product / Service</label>
											<div class="col-sm-9">
											{{ Form::text('service', @$fetchedData->service, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Product / Service' )) }}
											@if ($errors->has('service')) 
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('service') }}</strong>
												</span> 
											@endif
											</div>  
										</div> 
									</div> 
									
								</div> 
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group row">
											<label for="duration_night" class="col-sm-3 col-form-label">Duration</label>
											
											<div class="col-sm-4">
												{{ Form::text('duration_night', @$fetchedData->duration_night, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'No of Nights' )) }}
												@if ($errors->has('duration_night')) 
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('duration_night') }}</strong>
												</span> 
											@endif
											</div>
											<div class="col-sm-4">
												{{ Form::text('duration_day', @$fetchedData->duration_day, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'No of Days' )) }}
												@if ($errors->has('duration_day')) 
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('duration_day') }}</strong>
												</span> 
											@endif
											</div>
											
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group row">
											<label for="duration_night" class="col-sm-3 col-form-label">Adults / Children</label>
											
											<div class="col-sm-3">
												<select class="form-control" name="adults">
												<option value="">Adults*</option>
												<?php
												for($ai=1;$ai<=10;$ai++){
													?>
													<option value="{{$ai}}" @if(@$fetchedData->adults == $ai) selected @endif>{{$ai}}</option>
													<?php
												}
												?>
											</select>
											</div>
											<div class="col-sm-3">
												<select class="form-control" name="children">
												<option value="">Children</option>
												<?php
												for($ck=1;$ck<=10;$ck++){
													?>
													<option value="{{$ck}}" @if(@$fetchedData->children == $ck) selected @endif>{{$ck}}</option>
													<?php
												}
												?>
											</select>
											</div>
											<div class="col-sm-3">
												<select class="form-control" name="baby">
												<option value="">Baby</option>
												<?php
												for($cks=1;$cks<=10;$cks++){
													?>
													<option value="{{$cks}}" @if(@$fetchedData->baby == $cks) selected @endif>{{$cks}}</option>
													<?php
												}
												?>
											</select>
											</div> 
										</div>   
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group row">
											<label for="lead_assign" class="col-sm-3 col-form-label">Lead Assign To</label>
											<div class="col-sm-9">
												<select style="padding: 0px 5px;" name="lead_assign" id="lead_assign" data-valid='required' class="form-control" autocomplete="new-password">
												<option value=""></option>
												@foreach (\App\Admin::where('user_id', '=', Auth::user()->id)->Where('role', '=', '63')->get() as $list)	
													<option value="{{$list->id}}" @if(@$fetchedData->assign_to == $list->id) selected @endif >{{$list->staff_id}} ({{$list->first_name}})</option>
												@endforeach
												</select>
											@if ($errors->has('lead_assign')) 
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('lead_assign') }}</strong>
												</span> 
											@endif
											</div> 
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group row">
											<label for="lead_source" class="col-sm-3 col-form-label">Lead Source</label>
											<div class="col-sm-9">
												<select style="padding: 0px 5px;" name="lead_source" id="lead_source" class="form-control" autocomplete="new-password">
													<option value="Website / Blog" @if(@$fetchedData->lead_source == "Website / Blog") selected @endif>Website / Blog</option>
													<option value="Events / Shows" @if(@$fetchedData->lead_source == "Events / Shows") selected @endif>Events / Shows</option>
													<option value="Referrals" @if(@$fetchedData->lead_source == "Referrals") selected @endif>Referrals</option>
													<option value="Email Marketing" @if(@$fetchedData->lead_source == "Email Marketing") selected @endif>Email Marketing</option>
													<option value="Inbound Phone Calls" @if(@$fetchedData->lead_source == "Inbound Phone Calls") selected @endif>Inbound Phone Calls</option>
													<option value="Outbound Sales" @if(@$fetchedData->lead_source == "Outbound Sales") selected @endif>Outbound Sales</option>
													<option value="Social Media" @if(@$fetchedData->lead_source == "Social Media") selected @endif>Social Media</option>
													<option value="Digital Advertising" @if(@$fetchedData->lead_source == "Digital Advertising") selected @endif>Digital Advertising</option>
													<option value="Premium Content" @if(@$fetchedData->lead_source == "Premium Content") selected @endif>Premium Content</option>
													<option value="Organic Search" @if(@$fetchedData->lead_source == "Organic Search") selected @endif>Organic Search</option>
													<option value="Media Coverage" @if(@$fetchedData->lead_source == "Media Coverage") selected @endif>Media Coverage</option>
													<option value="Direct Marketing" @if(@$fetchedData->lead_source == "Direct Marketing") selected @endif>Direct Marketing</option>
													<option value="Traditional Advertising" @if(@$fetchedData->lead_source == "Traditional Advertising") selected @endif>Traditional Advertising</option>
													<option value="Sponsorship" @if(@$fetchedData->lead_source == "Sponsorship") selected @endif>Sponsorship</option>
													<option value="Affiliate / Partner Programs" @if(@$fetchedData->lead_source == "Affiliate / Partner Programs") selected @endif>Affiliate / Partner Programs</option>
													<option value="Speaking Engagements" @if(@$fetchedData->lead_source == "Speaking Engagements") selected @endif>Speaking Engagements</option>
													<option value="Traditional / Offline Networking" @if(@$fetchedData->lead_source == "Traditional / Offline Networking") selected @endif>Traditional / Offline Networking</option> 
												</select> 
											@if ($errors->has('lead_source')) 
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('lead_source') }}</strong>
												</span> 
											@endif
											</div> 
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group row">
											<label for="city" class="col-sm-3 col-form-label">City</label>
											<div class="col-sm-9">
												{{ Form::text('city', @$fetchedData->city, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'City' )) }}
												@if ($errors->has('city')) 
													<span class="custom-error" role="alert">
														<strong>{{ @$errors->first('city') }}</strong>
													</span> 
												@endif
											</div> 
										</div>
									</div>
									<div class="col-sm-6">	
										<div class="form-group row">
											<label for="remark" class="col-sm-3 col-form-label">Remark</label>
											<div class="col-sm-9">
												<textarea class="form-control" name="remark" placeholder="Remark">{{@$fetchedData->customize_package}}</textarea>
												@if ($errors->has('remark')) 
													<span class="custom-error" role="alert">
														<strong>{{ @$errors->first('remark') }}</strong>
													</span> 
												@endif
											</div> 
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group row">
											<label for="latest_comment" class="col-sm-3 col-form-label">Latest Comment</label>
											<div class="col-sm-9">
												<textarea class="form-control" name="latest_comment" placeholder="Latest Comment">{{@@$fetchedData->latest_comment}}</textarea>
												@if ($errors->has('latest_comment')) 
													<span class="custom-error" role="alert">
														<strong>{{ @$errors->first('latest_comment') }}</strong>
													</span> 
												@endif
											</div> 
										</div>
									</div>
									<div class="col-sm-6"> 
										<div class="form-group row">
											<label for="status" class="col-sm-3 col-form-label">Priority</label>
											<div class="col-sm-9">
												<select style="padding: 0px 5px;" name="status" id="status" class="form-control" autocomplete="new-password">
													<option value="Low" @if(@$fetchedData->lead_source == "Low") selected @endif>Low</option>
													<option value="Medium" @if(@$fetchedData->lead_source == "Medium") selected @endif>Medium</option>
													<option value="High" @if(@$fetchedData->lead_source == "High") selected @endif>High</option>
													<option value="Urgent" @if(@$fetchedData->lead_source == "Urgent") selected @endif>Urgent</option>
												</select>
												@if ($errors->has('latest_comment')) 
													<span class="custom-error" role="alert">
														<strong>{{ @$errors->first('latest_comment') }}</strong>
													</span> 
												@endif
											</div> 
										</div>
									</div>
								</div> 
								<div style="margin-bottom:0px;" class="form-group float-right">
									{{ Form::button('<i class="fa fa-edit"></i> Edit leads', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-leads")' ]) }}
								</div> 
							{{ Form::close() }}   
						</div> 
					</div>	
				</div>
			</div>
		</div>
	</section>
</div>
@endsection