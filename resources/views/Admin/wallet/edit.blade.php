@extends('layouts.admin')
@section('title', 'Payment Detail')

@section('content')

<!-- Content Wrapper. Contains page content -->
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
						<h3 class="card-title">Payment Detail</h3>
					  </div> 
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/wallet/edit', 'name'=>"edit-inclusion", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
					   {{ Form::hidden('id', @$fetchedData->id) }}
						<div class="card-body">
							<div class="form-group" style="text-align:right;">
								<a style="margin-right:5px;" href="{{route('admin.wallet.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
								
							</div>
							<div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Agent Id</label>
								<div class="col-sm-10">
								<h5>{{@$fetchedData->user->id}}</h5>
								</div>
							</div>
							<div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Agent Name </label>
								<div class="col-sm-10">
								<h5>{{ @$fetchedData->user->first_name }} {{ @$fetchedData->user->last_name }}</h5>
								</div>
							</div>
							<div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Payment Mode </label>
								<div class="col-sm-10">
								<h5>{{@$fetchedData->pay_mode}}</h5>
								</div>
							</div>
							<div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Amount </label>
								<div class="col-sm-10">
								<h5>{{@$fetchedData->amount}}</h5>
								</div>
							</div>
							<div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Cheque No </label>
								<div class="col-sm-10">
								<h5>{{@$fetchedData->cheque_no}}</h5>
								</div>
							</div>
							<div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Payment Date </label>
								<div class="col-sm-10">
								<h5>{{date('d/m/Y',strtotime(@$fetchedData->pay_date))}}</h5>
								</div>
							</div>
							<div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Request Date </label>
								<div class="col-sm-10">
								<h5>{{date('d/m/Y',strtotime(@$fetchedData->created_at))}}</h5>
								</div>
							</div>
							<div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Bank Name </label>
								<div class="col-sm-10">
								<h5>{{@$fetchedData->bank_name}}</h5>
								</div>
							</div>
							<div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Bank Transaction Id </label>
								<div class="col-sm-10">
								<h5>{{@$fetchedData->bank_transaction_id}}</h5>
								</div>
							</div>
							<div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Status</label>
								<div class="col-sm-10">
								@if(@$fetchedData->status == 1)
									<span class="priority_green priority_style">Approved</span> 
								  @elseif(@$fetchedData->status == 2)
									<span class="priority_medium priority_style">Approved</span> 
								  @else
									<span class="priority_high priority_style">Pending</span> 
								  @endif
								</div>
							</div>
							<div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Remarks</label>
								<div class="col-sm-10">
									<h5>{{@$fetchedData->remarks}}</h5>
								</div>
							</div>
							<div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Admin Remarks</label>
								<div class="col-sm-10">
									<h5>{{@$fetchedData->admin_remarks}}</h5>
								</div>
							</div>
							@if(@$fetchedData->status == 0)
							<div class="form-group ">
							{{ Form::button('<i class="fa fa-edit"></i> Approve Payment', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-inclusion")' ]) }}
							
						  </div>
							@endif						  
						</div> 
					  {{ Form::close() }}
					</div>	
				</div>	
			</div>
		</div>
	</section>
</div>
@endsection