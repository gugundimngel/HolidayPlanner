@extends('layouts.admin')
@section('title', 'Edit Coupon')

@section('content')
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Edit Coupon</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit Coupon</li>
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
						<h3 class="card-title">Edit Coupon</h3>
					  </div> 
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/coupon-code/edit', 'name'=>"add-city", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
					   {{ Form::hidden('id', @$fetchedData->id) }}
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group" style="text-align:right;">
										<a style="margin-right:5px;" href="{{route('admin.coupon_code.index')}}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
										{{ Form::button('<i class="fas fa-edit"></i> Update', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-city")' ]) }}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="coupon_name" class="col-form-label">Coupon Name <span style="color:#ff0000;">*</span></label>
										<input type="text" value="{{@$fetchedData->coupon_name}}" id="coupon_name" autocomplete="off" name="coupon_name" data-valid="required" class="form-control" style="">
												
										@if ($errors->has('coupon_name'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('coupon_name') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="type" class="col-form-label">Type <span style="color:#ff0000;">*</span></label>
										<select class="form-control" name="type" data-valid="required">
											<option value="">Select</option>
											<option value="flights" @if($fetchedData->type == 'flights') selected @endif>Flights</option>
											<option value="hotels" @if($fetchedData->type == 'hotels') selected @endif>Hotels</option>
											<option value="holiday" @if($fetchedData->type == 'holiday') selected @endif>holiday</option>
										</select>
										@if ($errors->has('type'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('type') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="discount_type" class="col-form-label">Discount Type</label>
										<select class="form-control" name="discount_type">
											<option value="percentage" @if(@$fetchedData->type == 'percentage') selected @endif>Percentage</option>
											<option value="fixed" @if(@$fetchedData->type == 'fixed') selected @endif>Fixed</option>
										</select>
										@if ($errors->has('discount_type'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('discount_type') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="discount" class="col-form-label">Discount <span style="color:#ff0000;">*</span></label>
										<input type="text" value="{{@$fetchedData->discount}}" name="discount" autocomplete="off" data-valid="required" class="form-control" onkeyup="this.value=this.value.replace(/[^0-9\.]/g,'')">
									</div>
								</div>
								<div class="col-sm-6">   
									<div class="form-group"> 
										<label for="coupon_code" class="col-form-label">Coupon Code </label>
										<input type="text" name="coupon_code" autocomplete="off" value="{{@$fetchedData->coupon_code}}" data-valid="" class="form-control" placeholder="You Can enter your own code here, or leave blank for an auto generated one.">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="no_of_coupon" class="col-form-label">No of Coupon </label>
										<input type="number" name="no_of_coupon" value="{{@$fetchedData->no_of_coupon}}" autocomplete="off" data-valid="" class="form-control" placeholder="The Maximum number of times the coupon can be used, leave blank if you want no limit">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="start_date" class="col-form-label">Start Date <span style="color:#ff0000;">*</span></label>
										<input type="text" name="start_date" value="{{date('m/d/Y', strtotime(@$fetchedData->start_date))}}" autocomplete="off" data-valid="required" class="form-control commodate" placeholder="The date the coupon will valid from">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="end_date" class="col-form-label">End Date <span style="color:#ff0000;">*</span></label>
										<input type="text" name="end_date" value="{{date('m/d/Y', strtotime(@$fetchedData->end_date))}}" autocomplete="off" data-valid="required" class="form-control commodate" placeholder="The date the coupon expires">
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group"> 
									<?php use App\Http\Controllers\Controller; ?>
										<?php  $imagedata = \App\MediaImage::where('id',$fetchedData->image)->first();
										//if($imagedata){
										?>
										<?php Controller::fileupload(@$imagedata->images,$fetchedData->image,'offer_image_m_id','offer_image_m'); ?>
										<?php //} ?>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group"> 
										<label for="shortdescription" class="col-form-label">Short Description</label>
										<input type="text" value="{{@$fetchedData->shortdescription}}" name="shortdescription" autocomplete="off" class="form-control">
									</div>
								</div>
								
								<div class="col-sm-12">
									<div class="form-group"> 
										<label for="description" class="col-form-label">Description</label>
										<textarea type="text" name="description" autocomplete="off" class="form-control textarea">{{@$fetchedData->description}}</textarea>
									</div>
								</div>
								
								<div class="col-sm-12">
									<div class="form-group float-right">
										{{ Form::button('<i class="fa fa-edit"></i> Update', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-city")' ]) }}
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