@extends('layouts.admin')
@section('title', 'Destination')

@section('content')
 <?php use App\Http\Controllers\Controller; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Destination</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Destination</li>
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
							<h3 class="card-title">Destination</h3>
						</div> 
						<!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/locations/store', 'name'=>"add-loc", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
						<div class="card-body">
						
									<div class="form-group" style="text-align:right;">
										<a style="margin-right:5px;" href="{{route('admin.locations.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
										{{ Form::button('<i class="fa fa-save"></i> Save Destination', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-loc")' ]) }}
									</div>
							
								<div class="form-group row">  
								<label for="dest_type" class="col-sm-2 col-form-label">Dest. Type <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
									<select onChange="getLocations()" name="dest_type" id="dest_type" class="form-control" autocomplete="new-password" data-valid="required">
										<option value="">Choose One...</option>
										<option value="domestic">Domestic</option>
										<option value="international">International</option>
									</select>							
									@if ($errors->has('dest_type'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('dest_type') }}</strong>
										</span> 
									@endif
							   </div>	
						  </div>
						
								<div class="form-group row"> 
										<label for="name" class="col-sm-2 col-form-label">Destination <span style="color:#ff0000;">*</span></label>
										<div class="col-sm-10">
										{{ Form::text('name', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Destination Name' )) }}
										@if ($errors->has('name'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('name') }}</strong>
											</span> 
										@endif
									</div>
									</div>
							<div class="form-group row">
								<label for="description" class="col-sm-2 col-form-label">Description <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
									<textarea name="description" data-valid="required" class="textarea" placeholder="Please Add Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
									@if ($errors->has('description'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('description') }}</strong>
										</span> 
									@endif
								</div>
						  </div>
						  <div class="form-group row">
								<label for="image_alt" class="col-sm-2 col-form-label">Image Alt</label>
								<div class="col-sm-10">
								{{ Form::text('image_alt', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Image Alt' )) }}
								@if ($errors->has('image_alt'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('image_alt') }}</strong>
									</span> 
								@endif
							  </div>
						  </div>
						
						  <div class="form-group row">
								<label for="package_image" class="col-sm-2 col-form-label"> Image</label>
								<div class="col-sm-10">
									<!--<a href="javascript:;" class="btn btn-primary showimages" data-type="package_image_m">Add Images</a> 
									<div class="package_image_m custom_pack_m"></div>-->
									
									<?php Controller::fileupload('','','package_image_m_id','package_image_m'); ?>
								</div>
						  </div>
						  <div class="form-group row">
							<label for="tour_policy" class="col-sm-2 col-form-label">Tour Policy</label>
							<div class="col-sm-10">
								<textarea name="tour_policy" class="textarea" placeholder="Please Add Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
								@if ($errors->has('tour_policy'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('tour_policy') }}</strong>
									</span> 
								@endif
							</div> 
						  </div>
						  <div class="form-group row">
								<label for="is_active" class="col-sm-2 col-form-label">Is Active</label>
								<div class="col-sm-10">
									<input value="1" type="checkbox" name="is_active" checked data-bootstrap-switch>
									@if ($errors->has('is_active'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('is_active') }}</strong>
										</span> 
									@endif  
								</div>
						  </div> 
								<div class="col-sm-12">
									<div class="form-group float-right">
										{{ Form::button('<i class="fa fa-save"></i> Save Destination', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-loc")' ]) }}
									</div> 
								</div> 
						
						</div>	
					{{ Form::close() }}
				</div>	
			</div>
		</div>
	</section>
</div>
@endsection