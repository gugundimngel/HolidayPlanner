@extends('layouts.admin')
@section('title', 'Edit GRN Hotel')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">GRN Hotel</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">GRN Hotel</li>
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
				<div class="col-md-12">
					<div class="card card-primary">
					  <div class="card-header">
						<h3 class="card-title">Edit GRN Hotel</h3>
					  </div>
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/grnhotel/edit', 'name'=>"edit-grnhotel", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
					   {{ Form::hidden('id', @$fetchedData->id) }}
					   {{ Form::hidden('hotel_code', @$fetchedData->hotel_code) }}
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group" style="text-align:right;">
										<a style="margin-right:5px;" href="{{URL::to('/admin/rooms')}}?hcode={{$fetchedData->hotel_code}}&rId={{$fetchedData->id}}" class="btn btn-danger">Rooms</a>
										<a style="margin-right:5px;" href="{{route('admin.grnhotel.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
										{{ Form::button('<i class="fa fa-edit"></i> Update GRN Hotel', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-grnhotel")' ]) }}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group"> 
										<label for="name" class="col-form-label">Hotel Name <span style="color:#ff0000;">*</span></label>
										{{ Form::text('name', @$fetchedData->name, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Hotel Name' )) }}
										@if ($errors->has('name'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('name') }}</strong>
											</span> 
										@endif
									</div>
									<div class="form-group"> 
										<label for="category" class="col-form-label">Hotel Rating <span style="color:#ff0000;">*</span></label>
										{{ Form::text('category', @$fetchedData->category, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Hotel Rating' )) }}
										@if ($errors->has('category'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('category') }}</strong>
											</span> 
										@endif
									</div>
									<div class="form-group">
										<label for="address" class="col-form-label">Address </label>
										{{ Form::text('address', @$fetchedData->address, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Address' )) }}
										@if ($errors->has('address'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('address') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="zip" class="col-form-label">Pin Code</label>
										{{ Form::text('zip', @$fetchedData->zip, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Pin Code' )) }}
										@if ($errors->has('zip'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('zip') }}</strong>
											</span> 
										@endif
									</div>
									<div class="form-group">
										<label for="longitude" class="col-form-label">Longitude <span style="color:#ff0000;">*</span></label>
										{{ Form::text('longitude', @$fetchedData->longitude, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Longitude' )) }}
										@if ($errors->has('longitude'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('longitude') }}</strong>
											</span> 
										@endif
									</div>
									<div class="form-group">
										<label for="latitude" class="col-form-label">Latitude <span style="color:#ff0000;">*</span></label>
										{{ Form::text('latitude', @$fetchedData->latitude, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Latitude' )) }}
										@if ($errors->has('latitude'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('latitude') }}</strong>
											</span> 
										@endif
									</div>
									<!--<div class="form-group">
										<label for="amenities" class="col-form-label">Amenities</label>
										<select name="amenities[]" class="select2" multiple="multiple" data-placeholder="Select Amenities" style="width: 100%;">
											<option value="">- Amenities -</option>
										</select>
										@if ($errors->has('amenities'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('amenities') }}</strong>
											</span> 
										@endif
									</div>-->
								</div>
								<div class="col-md-12">
									<label for="description" class="col-form-label">Description</label>
									<textarea name="description" data-valid="" class="textarea" placeholder="Please Add Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{@$fetchedData->description}}</textarea>
									@if ($errors->has('description'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('description') }}</strong>
										</span> 
									@endif
								</div> 
								
								<div class="col-md-12">
									<h4>Images</h4>
									<table class="table">
										<thead>
										<tr>
											<th></th>
											<th>Main Image</th>
											<th>Status</th>
										</tr>
										</thead>
										<tbody>
										<?php if(isset($fetchedData->hotelmainimages)){ ?>
										@foreach($fetchedData->hotelmainimages as $list)
											<tr id="id_{{@$list->id}}">
												<td>
												<?php if($list->type == 'online'){ ?>
												<img width="100px" src="https://images.grnconnect.com/{{@$list->image}}">
												<?php }else{
														?>
														<img width="100px" src="{{URL::to('/public/img/gallery_img')}}/{{@$list->image}}">
														<?php
												}?>
												</td>
												<td><input type="radio" name="images" value="" <?php if($list->main_image == 'Y'){ echo 'checked'; } ?>></td>
												<td><input data-id="{{@$list->id}}"  data-status="{{@$list->status}}" data-col="status" data-table="hotel_images" class="change-new-status" value="1" type="checkbox" name="status" {{ (@$list->status == 1 ? 'checked' : '')}} data-bootstrap-switch></td> 
											</tr>
										@endforeach
										<?php } ?>
										</tbody>
										<tfoot>
											<tr>
												<td></td>
												<td></td>
												<td><a class="openimage btn btn-default" href="javascript:;">Add Image</a></td>
											</tr>
										</tfoot>
									</table>
								</div> 
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group float-right">
										{{ Form::button('<i class="fa fa-edit"></i> Update GRN Hotel', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-grnhotel")' ]) }}
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
@section('scripts')
<script >
jQuery(document).ready(function($){
	$('.openimage').on('click', function(){
		$('.table tbody').append('<tr><td><input type="file" class="form-control" name="upimages[]"></td><td><input type="radio" name="images" value="" ></td><td><input value="1" type="checkbox" checked class="checkstatus"></td></tr>');
	});
});
</script>
@endsection