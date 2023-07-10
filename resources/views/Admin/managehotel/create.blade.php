@extends('layouts.admin')
@section('title', 'New Manage Hotel')

@section('content')
 <?php use App\Http\Controllers\Controller; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Manage Hotel</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Manage Hotel</li>
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
						<h3 class="card-title">New Manage Hotel</h3>
					  </div>
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/hotel/store', 'name'=>"add-hotel", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
						<div class="card-body">
							<div class="form-group" style="text-align:right;">
								<a style="margin-right:5px;" href="{{route('admin.managehotel.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>  
								{{ Form::button('<i class="fa fa-save"></i> Save Hotel', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-hotel")' ]) }}
							</div>
							<div class="form-group row">
								<label for="dest_type" class="col-sm-2 col-form-label">Dest. Type <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
									<select onChange="getLocations()" data-valid="required" name="dest_type" id="dest_type" class="form-control" autocomplete="new-password">
										<option value="">-- Select Dest. Type --</option>
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
								<label for="destination" class="col-sm-2 col-form-label">Destination <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
									<select name="destination" data-valid="required" id="destination" class="form-control" autocomplete="new-password">
										<option value="">-- Select Destination --</option>
										{{-- @if(count(@$destination) !== 0)
												@foreach (@$destination as $destinate)
													<option value="{{ @$destinate->id }}">{{ @$destinate->dest_name }}</option>
												@endforeach
										@endif	 --}}
									</select>								
									@if ($errors->has('destination'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('destination') }}</strong>
										</span> 
									@endif
								</div>
						  </div> 
						  <div class="form-group row">
							<label for="hotel_categories" class="col-sm-2 col-form-label">Hotel Category <span style="color:#ff0000;">*</span></label>
							<div class="col-sm-10">
								<select name="hotel_categories" data-valid="required" id="hotel_categories" class="form-control" autocomplete="new-password">
									<option value="Hotel">Hotel</option>
									<option value="Cottage">Cottage</option>
									<option value="Resort">Resort</option>
									<option value="Motel">Motel</option>
									<option value="Boutique Hotel">Boutique Hotel</option>
									<option value="Lodge">Lodge</option>
									<option value="Villa">Villa</option>
									<option value="Apartment">Apartment</option>
									<option value="Camp">Camp</option>
									<option value="Inn">Inn</option>
									<option value="Tent">Tent</option>
									<option value="Palace">Palace</option>
									<option value="Tented Safari Camp">Tented Safari Camp</option>
									<option value="Business Hotel">Business Hotel</option>
							
								</select>
							</div>
						  </div>
						  <div class="form-group row"> 
								<label for="hotel_category" class="col-sm-2 col-form-label">Hotel Stars <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
								<select name="hotel_category" data-valid="required" id="hotel_category" class="form-control" autocomplete="new-password">
										<option value="">-- Select Hotel Star --</option>
										<?php 
									  for ($i=1; $i<=7; $i++) {
										$ID = '';	
											for($j=0;$j<$i;$j++){
												$ID .= "*";
											}
											echo "<option value='".$i."'>".$ID."</option>";
										}
										?>
									</select>
								@if ($errors->has('hotel_category'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('hotel_category') }}</strong>
									</span> 
								@endif
								</div>
								
						  </div>
						  
						  <div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Name <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
								{{ Form::text('name', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Hotel Name' )) }}
								@if ($errors->has('name'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('name') }}</strong>
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
								<label for="image" class="col-sm-2 col-form-label">Thumbnail</label>
								<div class="col-sm-10">
									<input type="file" name="image" class="form-control" autocomplete="off" data-valid="" />
									<!--<?php Controller::fileupload('','','hotel_image_id','hotel_img_name'); ?>-->
									@if ($errors->has('image'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('image') }}</strong>
										</span> 
									@endif
								</div>
						  </div>
						   <div class="form-group row">
								<label for="gallery" class="col-sm-2 col-form-label">Gallery</label>
								<div class="col-sm-10">
									<input type="file" name="hotel_gallery[]" class="form-control" autocomplete="off" data-valid="" multiple/>	
									<!--<?php Controller::fileupload('','','hotel_gallery_image_id','hotel_gallery_img_name'); ?>-->
									@if ($errors->has('hotel_gallery'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('hotel_gallery') }}</strong>
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
								<label for="amenities" class="col-sm-2 col-form-label">Amenities</label>
								<div class="col-sm-10">
								<select name="amenities[]" class="select2" multiple="multiple" data-placeholder="Select Amenities" style="width: 100%;">
										@if(count(@$amenitie) !== 0)
											@foreach (@$amenitie as $amenity)
												<option value="{{ @$amenity->id }}">{{ @$amenity->name }}</option>
											@endforeach
										@endif
								  </select>
								@if ($errors->has('amenities'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('amenities') }}</strong>
									</span> 
								@endif
							  </div>
						  </div>
						  <div class="form-group row">
								<label for="help_line_no" class="col-sm-2 col-form-label">Help Line No</label>
								<div class="col-sm-10">
								{{ Form::text('help_line_no', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Help Line No' )) }}
								@if ($errors->has('help_line_no'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('help_line_no') }}</strong>
									</span> 
								@endif
							  </div>
						  </div>
						  <div class="form-group row">
								<label for="email" class="col-sm-2 col-form-label">Email Id</label>
								<div class="col-sm-10">
								{{ Form::text('email', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Email Id' )) }}
								@if ($errors->has('email'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('email') }}</strong>
									</span> 
								@endif
							  </div>
						  </div>
						  <div class="form-group row">
								<label for="address" class="col-sm-2 col-form-label">Address <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
								{{ Form::text('address', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Address' )) }}
								@if ($errors->has('address'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('address') }}</strong>
									</span> 
								@endif
							  </div>
						  </div>
						  <div class="form-group row">
								<label for="pin_code" class="col-sm-2 col-form-label">Pin Code</label>
								<div class="col-sm-10">
								{{ Form::text('pin_code', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Pin Code' )) }}
								@if ($errors->has('pin_code'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('pin_code') }}</strong>
									</span> 
								@endif
							  </div>
						  </div>
						  <div class="form-group row">
								<label for="status" class="col-sm-2 col-form-label">Status</label>
								<div class="col-sm-10">
									<input value="1" type="checkbox" name="status" checked data-bootstrap-switch>
									@if ($errors->has('status'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('status') }}</strong>
										</span> 
									@endif
								</div>
						  </div>
						  <div class="form-group float-right">
							{{ Form::button('<i class="fa fa-save"></i> Save Hotel', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-hotel")' ]) }}
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