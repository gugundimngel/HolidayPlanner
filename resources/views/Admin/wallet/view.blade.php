@extends('layouts.admin')
@section('title', 'Payment Detail')

@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Payment Detail</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Payment Detail</li>
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
							<h3 class="card-title">Payment Detail</h3>
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
													<th>Agent ID</th>
													<td>{{@$fetchedData->user->username}}</td>
												</tr>
												<tr>
													<th>Agent Name</th>
													<td>{{ @$fetchedData->user->first_name }} {{ @$fetchedData->user->last_name }}</td>
												</tr>
												<tr>
													<th>Payment Mode</th>
													<td>{{@$fetchedData->pay_mode}}</td>
												</tr>
												<tr>
													<th>Amount</th>
													<td>{{@$fetchedData->amount}}</td>
												</tr>
												<tr>
													<th>Cheque No.</th>
													<td>{{@$fetchedData->cheque_no}}</td>
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
													<th>Payment Date</th>
													<td>{{date('d/m/Y',strtotime(@$fetchedData->pay_date))}}</td>
												</tr>
												<tr>
													<th>Request Date</th>
													<td>{{date('d/m/Y',strtotime(@$fetchedData->created_at))}}</td>
												</tr>
												<tr>
													<th>Bank Name</th>
													<td>{{@$fetchedData->bank_name}}</td>
												</tr>
												<tr>
													<th>Bank Transaction Id</th>
													<td>{{@$fetchedData->bank_transaction_id}}</td>
												</tr>
												<tr>
													<th>Status</th>
													<td>@if(@$fetchedData->status == 1)
														<span class="priority_green priority_style">Approved</span> 
													  @elseif(@$fetchedData->status == 2)
														<span class="priority_medium priority_style">Rejected</span> 
													  @else
														<span class="priority_high priority_style">Pending</span> 
													  @endif
													</td>
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
	</section>
</div>
@endsection