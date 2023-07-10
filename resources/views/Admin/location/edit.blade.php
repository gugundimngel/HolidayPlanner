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
							<h3 class="card-title">Edit Destination</h3>
						</div> 
						<!-- /.card-header -->
						<!-- form start -->
						{{ Form::open(array('url' => 'admin/locations/edit', 'name'=>"edit-loc", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
					   {{ Form::hidden('id', @$fetchedData->id) }}
							<div class="card-body">
						
										<div class="form-group" style="text-align:right;">
											<a style="margin-right:5px;" href="{{route('admin.locations.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
											{{ Form::button('<i class="fa fa-save"></i> Edit Destination', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-loc")' ]) }}
										</div> 
									
									<div class="form-group row">
								<label for="dest_type" class="col-sm-2 col-form-label">Dest. Type <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
									<select name="dest_type" data-valid="required" id="dest_type" class="form-control" autocomplete="new-password">
										<option value="">Choose One...</option>
										<option value="domestic" @if(@$fetchedData->dest_type == 'domestic') selected  @endif>Domestic</option>
										<option value="international" @if(@$fetchedData->dest_type == 'international') selected  @endif>International</option>
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
											{{ Form::text('name', @$fetchedData->name, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Destination Name' )) }}
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
									<textarea name="description" data-valid="required" value="" class="textarea" placeholder="Please Add Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{@$fetchedData->description}}</textarea>
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
								{{ Form::text('image_alt', @$fetchedData->image_alt, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Image Alt' )) }}
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
								
								<?php  $imagedata = \App\MediaImage::where('id',$fetchedData->dest_image)->first();
								//if($imagedata){
								?>
								<?php Controller::fileupload(@$imagedata->images,$fetchedData->dest_image,'package_image_m_id','package_image_m'); ?>
								<?php //} ?>
								</div>
							</div>
							
							 <div class="form-group row">
							<label for="tour_policy" class="col-sm-2 col-form-label">Tour Policy</label>
							<div class="col-sm-10">
								<textarea name="tour_policy" class="textarea" placeholder="Please Add Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ @$fetchedData->tour_policy }} </textarea>
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
									<input value="1" type="checkbox" name="is_active" {{ (@$fetchedData->is_active == 1 ? 'checked' : '')}} data-bootstrap-switch>
									@if ($errors->has('is_active'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('is_active') }}</strong>
										</span>  
									@endif
								</div>
						  </div> 
								
										<div class="form-group float-right">
											{{ Form::button('<i class="fa fa-edit"></i> Edit Destination', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-loc")' ]) }}
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