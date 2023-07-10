@extends('layouts.admin')
@section('title', 'Agent')

@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Agent</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Agent</li>
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
					<div class="card card-primary">
						 <div class="card-header">
							<h3 class="card-title">Company Basic Information</h3>
							<div class="nav-item dropdown action_dropdown cus_action_btn">
								<a href="javascript:;" onclick="history.go(-1);" class="nav-link btn btn-primary btn-rounded back_btn"><i class="fa fa-arrow-left"></i> Back</a>  
								<!--<a class="nav-link dropdown-toggle action_btn btn btn-primary btn-rounded dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
								<div class="dropdown-menu"> 
									<a href="#"><i class="fa fa-arrow-up"></i> TopUp</a>
									<a href="#"><i class="fa fa-money"></i> Deduct</a>
									<a href="#"><i class="fa fa-money"></i> Transaction Log</a>
									<a href="#"><i class="fa fa-credit-card"></i> Credit Limit Log</a>
								</div>-->
							</div> 
						</div>
						<div class="card-body">	
							<div class="row">  
								<div class="col-sm-6">
									<div class="table-responsive">
										<table class="table">
											<tbody>
												<tr>
													<th>Agent ID</th>
													<td>{{@$fetchedData->username}}</td>
												</tr>
												<tr>
													<th>Agent Class</th>
													<td></td>
												</tr>
												<tr>
													<th>Entry Date</th>
													<td>{{date('h:i A, d m Y', strtotime($fetchedData->created_at))}}</td>
												</tr>
												<tr>
													<th>Update Date</th>
													<td>{{date('h:i A, d m Y', strtotime($fetchedData->updated_at))}}</td>
												</tr>
												<tr>
													<th>Balance</th>
													<td>{{@$fetchedData->wallet}}</td>
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
													<th>Credit Limit</th>
													<td>{{@$fetchedData->credit_limit}}</td>
												</tr>
												<tr>
													<th>Company Name</th>
													<td>{{@$fetchedData->company_name}}</td>
												</tr>
												<tr>
													<th>Mobile</th>
													<td>{{@$fetchedData->mobile_no}}</td>
												</tr>
												<tr>
													<th>Landline Number</th>
													<td>{{@$fetchedData->phone}}</td>
												</tr>
												<tr>
													<th>Email</th>
													<td>{{@$fetchedData->email}}</td>
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
												@if(@$fetchedData->logo == '') 
												@else
												<img width="100" height="100" src="{{URL::to('/public/img/profile_imgs')}}/{{@$fetchedData->logo}}" class="img-avatar" alt="" />
												@endif
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="profile_img_field">
											<span>PAN Card</span>
											<div class="comp_img">
												@if(@$fetchedData->company_pancard == '') 
												@else
												<img width="100" height="100" src="{{URL::to('/public/img/agentdoc')}}/{{@$fetchedData->company_pancard}}" class="img-avatar" alt="" />
												@endif
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="profile_img_field">
											<span>Aadhaar Card</span>
											<div class="comp_img">
												@if(@$fetchedData->aadhaar_card == '') 
												@else
												<img width="100" height="100" src="{{URL::to('/public/img/agentdoc')}}/{{@$fetchedData->aadhaar_card}}" class="img-avatar" alt="" />
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
												@if(@$fetchedData->gst_logo == '') 
												@else
												<img width="100" height="100" src="{{URL::to('/public/img/profile_imgs')}}/{{@$fetchedData->gst_logo}}" class="img-avatar" alt="" />
												@endif
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="profile_img_field">
											<span>PAN Doc</span> 
											<div class="comp_img">
												@if(@$fetchedData->company_pancard == '') 
												@else
												<img width="100" height="100" src="{{URL::to('/public/img/agentdoc')}}/{{@$fetchedData->company_pancard}}" class="img-avatar" alt="" />
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
							<h3 class="card-title">Contact Information</h3>
						</div>
						<div class="card-body">	
							<div class="row"> 
								<div class="col-sm-6">
									<div class="table-responsive">
										<table class="table">
											<tbody>
												<tr>
													<th>Contact Name</th>
													<td>{{@$fetchedData->contact_name}}</td>
												</tr>
												
												<tr>
													<th>Contact Number</th>
													<td>{{@$fetchedData->contact_no}}</td>
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
													<th>State</th>
													<td>{{@$fetchedData->state}}</td>
												</tr>
												<tr>
													<th>Country</th>
													<td>{{@$fetchedData->country}}</td>
												</tr>
												<tr>
													<th>Pincode</th>
													<td>{{@$fetchedData->zip_code}}</td>
												</tr>
												<tr>
													<th>INCHARGE</th>
													<td></td>
												</tr>
											</tbody>   
										</table>
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