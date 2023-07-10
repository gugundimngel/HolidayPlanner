@extends('layouts.agent')
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
					<div class="card card-primary profile_info">
						<div class="card-header profile_header">
							<h3 class="card-title">Company Information</h3>
							<div class="edit_profile_btn">
								<a class="btn btn-primary" href="{{route('agent.edit_profile')}}"><i class="fa fa-edit"></i> Edit Profile</a>
							</div>
							<div class="clearfix"></div>
						</div> 
						<div class="card-body">
							<div class="row">  
								<div class="col-sm-6">
									<div class="table-responsive">
										<table class="table">
											<tbody>
												<tr>
													<th>Full Name</th>
													<td>{{@$fetchedData->first_name}} {{@$fetchedData->last_name}}</td>
												</tr>
												<tr>
													<th>Email</th>
													<td>{{@$fetchedData->email}}</td>
												</tr>
												<tr>
													<th>Company Name</th>
													<td>{{@$fetchedData->company_name}}</td>
												</tr>
												<tr>
													<th>Phone</th>
													<td>{{@$fetchedData->phone}}</td>
												</tr>
												<tr>
													<th>Country</th>
													<td>{{@$fetchedData->country}}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>	
								<div class="col-sm-6">
									<div class="table-responsive">
										<table class="table">
											<tbody>
												<tr>
													<th>State</th>
													<td>{{@$fetchedData->state}}</td>
												</tr>
												<tr>
													<th>City</th>
													<td>{{@$fetchedData->city}}</td>
												</tr>
												<tr>
													<th>Zip Code</th>
													<td>{{@$fetchedData->zip}}</td>
												</tr>
												<tr>
													<th>Address</th>
													<td>{{@$fetchedData->address}}</td>
												</tr>
												<tr>
													<th>Profile Image</th>
													<td class="comp_img">@if(@Auth::user()->profile_img == '') 
													<img src="{{ asset('/public/img/avatars/default_profile.jpg') }}" class="img-avatar" alt="" />
												@else
													<img src="{{URL::to('/public/img/profile_imgs')}}/{{@Auth::user()->profile_img}}" class="img-avatar" alt="" />
												@endif</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>	
							</div>	
						</div>	
					</div>	
					<div class="card card-primary profile_info">
						<div class="card-header profile_header">
							<h3 class="card-title">Company Logo & Documents</h3>
						</div> 
						<div class="card-body">
							<div class="company_logos_sec">
								<div class="row"> 
									<div class="col-sm-4">
										<div class="profile_img_field">
											<span>Company Logo</span>
											<div class="comp_img">
												@if(@Auth::user()->logo == '') 
												@else
												<img width="100" height="100" src="{{URL::to('/public/img/profile_imgs')}}/{{@Auth::user()->logo}}" class="img-avatar" alt="" />
												@endif
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="profile_img_field">
											<span>PAN Card</span>
											<div class="comp_img">
												@if(@Auth::user()->company_pancard == '') 
												@else
												<img width="100" height="100" src="{{URL::to('/public/img/agentdoc')}}/{{@Auth::user()->company_pancard}}" class="img-avatar" alt="" />
												@endif
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="profile_img_field">
											<span>Aadhaar Card</span>
											<div class="comp_img">
												@if(@Auth::user()->aadhaar_card == '') 
												@else
												<img width="100" height="100" src="{{URL::to('/public/img/agentdoc')}}/{{@Auth::user()->aadhaar_card}}" class="img-avatar" alt="" />
												@endif
											</div>
										</div>
									</div>		
								</div>	 							
							</div>
						</div>
					</div>
					<div class="card card-primary profile_info">
						<div class="card-header profile_header">  
							<h3 class="card-title">Tax Information</h3>
						</div> 
						<div class="card-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="table-responsive">
										<table class="table">
											<tbody>
												<tr>
													<th>GST Number</th>
													<td>{{@$fetchedData->gst_no}}</td>
												</tr>
												<tr>
													<th>PAN Number</th>
													<td>{{@$fetchedData->pan_no}}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>	
								<div class="col-sm-6">
									<div class="table-responsive">
										<table class="table">
											<tbody>
												<tr>
													<th>PAN Name</th>
													<td>{{@$fetchedData->pan_name}}</td>
												</tr>
												<tr>
													<th>Address Name</th>
													<td>{{@$fetchedData->pan_address}}</td>
												</tr>
											</tbody>   
										</table>
									</div>
								</div>
							</div>
							<div class="company_logos_sec">
								<div class="row"> 
									<div class="col-sm-6">
										<div class="profile_img_field">
											<span>GST Doc</span>
											<div class="comp_img">
												@if(@Auth::user()->gst_logo == '') 
												@else
												<img width="100" height="100" src="{{URL::to('/public/img/profile_imgs')}}/{{@Auth::user()->gst_logo}}" class="img-avatar" alt="" />
												@endif
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="profile_img_field">
											<span>PAN Doc</span> 
											<div class="comp_img">
												@if(@Auth::user()->company_pancard == '') 
												@else
												<img width="100" height="100" src="{{URL::to('/public/img/agentdoc')}}/{{@Auth::user()->company_pancard}}" class="img-avatar" alt="" />
												@endif
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
<script>
jQuery(document).ready(function($){
	$('#select_country').attr('data-selected-country','<?php echo @$fetchedData->country; ?>');
		$('#select_country').flagStrap();
});
</script>
@endsection