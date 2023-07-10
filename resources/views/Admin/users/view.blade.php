@extends('layouts.admin')
@section('title', 'User')

@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Users</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Users</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
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
				<div class="col-md-12 agent_view">
					<div class="card card-primary profile_info">
						 <div class="card-header profile_header">
							<h3 class="card-title">Personal Information</h3>
							<div class="nav-item dropdown action_dropdown cus_action_btn">
								<a href="javascript:;" onclick="history.go(-1);" class="nav-link btn btn-primary btn-rounded back_btn"><i class="fa fa-arrow-left"></i> Back</a>  
							</div>
						</div>
						<div class="card-body">	
							<div class="row"> 
								<div class="col-sm-6">
									<div class="table-responsive">
										<table class="table">
											<tbody>
												<tr>
													<th>Full Name</th>
													<td>{{@$fetchedData->first_name}}  {{@$fetchedData->last_name}}</td>
												</tr>
												<tr>
													<th>Email</th>
													<td>{{@$fetchedData->email}}</td>
												</tr>
												<tr>
													<th>Phone</th>
													<td>{{@$fetchedData->phone}}</td>
												</tr>
												<tr>
													<th>Address</th>
													<td>{{@$fetchedData->address}}</td>
												</tr>
												<tr>
													<th>Country</th>
													<td>{{@$fetchedData->country}}</td>
												</tr>
												<tr>
													<th>State</th>
													<td>{{@$fetchedData->state}}</td>
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
													<th>City</th>
													<td>{{@$fetchedData->city}}</td>
												</tr>
												<tr>
													<th>Zip</th>
													<td>{{@$fetchedData->zip}}</td>
												</tr>
												<tr>
													<th>Gender</th>
													<td>@if(@$fetchedData->gender == 1) Male @elseif(@$fetchedData->gender == 2) Female @else Transgender @endif</td>
												</tr>
												<tr>
													<th>Marital Status</th>
													<td>{{@$fetchedData->marital_status}}</td>
												</tr>
												<tr>
													<th>Date of Birth</th>
													<td>{{date('d/m/Y', strtotime(@$fetchedData->dob))}}</td>
												</tr>
												<tr>
													<th>Profile Image</th>
													<td class="comp_img">
														<img class="img-avatar" src="{{URL::to('/public/img/profile_imgs')}}/{{@$fetchedData->profile_img}}" alt="" />
													</td>
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
													<td>657868678</td>
												</tr>
												<tr>
													<th>PAN Number</th>
													<td>98868678</td>
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
													<td>Nishant</td>
												</tr>
												<tr>
													<th>Address Name</th>
													<td>Delhi</td>
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
												@if(@Auth::user()->logo == '') 
												@else
												<img src="{{URL::to('/public/img/profile_imgs')}}/{{@Auth::user()->logo}}" class="img-avatar" alt="" />
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
												<img src="{{URL::to('/public/img/agentdoc')}}/{{@Auth::user()->company_pancard}}" class="img-avatar" alt="" />
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
@endsection