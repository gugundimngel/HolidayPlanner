@extends('layouts.admin')
@section('title', 'Edit Manage Hotel')

@section('content')

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
						<h3 class="card-title">Edit Manage Hotel</h3>
					  </div>
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/hotel/edit', 'name'=>"edit-hotel", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
					   {{ Form::hidden('id', @$fetchedData->id) }}
						<div class="card-body">
							<div class="form-group" style="text-align:right;">
								<a style="margin-right:5px;" href="{{route('admin.managehotel.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
								{{ Form::button('<i class="fa fa-edit"></i> Update Hotel', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-hotel")' ]) }}
						  </div>
							<div class="form-group row">
								<label for="dest_type" class="col-sm-2 col-form-label">Dest. Type <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
									<select name="dest_type" id="dest_type" data-valid="required" class="form-control" autocomplete="new-password">
										<option value="">-- Select Dest. Type --</option>
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
								<label for="destination" class="col-sm-2 col-form-label">Destination <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
									<select name="destination" data-valid="required" id="destination" class="form-control" autocomplete="new-password">
										<option value="">-- Select Destination --</option>
											
											@foreach (\App\Location::where('dest_type',$fetchedData->dest_type)->get() as $Locatio)
												<option value="{{ @$Locatio->id }}" @if(@$fetchedData->destination == $Locatio->id) selected  @endif  >{{ @$Locatio->name }}</option>
												@endforeach
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
									<option value="Hotel" @if(@$fetchedData->hotel_categories == 'Hotel') selected  @endif>Hotel</option>
									<option value="Cottage" @if(@$fetchedData->hotel_categories == 'Cottage') selected  @endif>Cottage</option>
									<option value="Resort" @if(@$fetchedData->hotel_categories == 'Resort') selected  @endif>Resort</option>
									<option value="Motel" @if(@$fetchedData->hotel_categories == 'Motel') selected  @endif>Motel</option>
									<option value="Boutique Hotel" @if(@$fetchedData->hotel_categories == 'Boutique Hotel') selected  @endif>Boutique Hotel</option>
									<option value="Lodge" @if(@$fetchedData->hotel_categories == 'Lodge') selected  @endif>Lodge</option>
									<option value="Villa" @if(@$fetchedData->hotel_categories == 'Villa') selected  @endif>Villa</option>
									<option value="Apartment" @if(@$fetchedData->hotel_categories == 'Apartment') selected  @endif>Apartment</option>
									<option value="Camp" @if(@$fetchedData->hotel_categories == 'Camp') selected  @endif>Camp</option>
									<option value="Inn" @if(@$fetchedData->hotel_categories == 'Inn') selected  @endif>Inn</option>
									<option value="Tent" @if(@$fetchedData->hotel_categories == 'Tent') selected  @endif>Tent</option>
									<option value="Palace" @if(@$fetchedData->hotel_categories == 'Palace') selected  @endif>Palace</option>
									<option value="Tented Safari Camp" @if(@$fetchedData->hotel_categories == 'Tented Safari Camp') selected  @endif>Tented Safari Camp</option>
									<option value="Business Hotel" @if(@$fetchedData->hotel_categories == 'Business Hotel') selected  @endif>Business Hotel</option>
							
								</select>
							</div>
						  </div>
						  <div class="form-group row"> 
								<label for="hotel_category" class="col-sm-2 col-form-label">Hotel Stars <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
									<select name="hotel_category" data-valid="required" id="hotel_category" class="form-control" autocomplete="new-password">
										<option value="">-- Select Hotel Stars --</option>
										<?php 
									  for ($i=1; $i<=7; $i++) {
										$ID = '';	
											for($j=0;$j<$i;$j++){
												$ID .= "*";
											}
										?>
										<option value="<?php echo $i; ?>" @if(@$fetchedData->hotel_category == $i) selected  @endif><?php echo $ID; ?></option>
										<?php	
											//echo "<option value='".$i."'>".$ID."</option>";
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
								{{ Form::text('name', @$fetchedData->name, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Hotel Name' )) }}
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
								{{ Form::text('image_alt', @$fetchedData->image_alt, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Image Alt' )) }}
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
									<input type="hidden" id="old_image" name="old_image" value="{{@$fetchedData->image}}" />
									
									<input type="file" name="image" class="form-control" autocomplete="off" data-valid="" />
									
									<div class="show-uploded-img">	
										@if(@$fetchedData->image != '')
											<img width="70" src="{{URL::to('/public/img/hotel_img')}}/{{@$fetchedData->image}}" class="img-avatar"/>
										@endif
									</div>								
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
									<input type="hidden" id="old_galleries" name="old_gallery[]" value="{{@$fetchedData->hotel_gallery ?? '' }}" />
									
									<input type="file" name="hotel_gallery[]" class="form-control" autocomplete="off" data-valid=""  multiple/>
									<div class="row">
									<?php 
        						 	$gallery = json_decode($fetchedData->hotel_gallery); 
        						    ?>
        						    @if($gallery)
									@if(count(@$gallery) > 0)
										@foreach($gallery as $img)
									<div class="hotel_gallery col-md-3">	
											<?php 
											$im = DB::table('media_images')->where('id',$img)->first();
											?>
											
												<img width="70" src="{{URL::to('/img/media_gallery')}}/{{@$im->images}}" class="img-avatar"/>
											
										</div>								
										@endforeach
									@endif
									@endif
									</div>
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
									<textarea name="description" data-valid="required" class="textarea" placeholder="Please Add Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ @$fetchedData->description }}</textarea>
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
								<?php $amentiearray = @json_decode(@$fetchedData->amenities); ?>
										@if(count(@$amenitie) !== 0)
											@foreach (@$amenitie as $amenity)
												<option value="{{ @$amenity->id }}" @if(@in_array(@$amenity->id,@$amentiearray)) selected  @endif  >{{ @$amenity->name }}</option>
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
								{{ Form::text('help_line_no', @$fetchedData->help_line_no, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Help Line No' )) }}
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
								{{ Form::text('email', @$fetchedData->email, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Email Id' )) }}
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
								{{ Form::text('address', @$fetchedData->address, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Address' )) }}
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
								{{ Form::text('pin_code', @$fetchedData->pin_code, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Pin Code' )) }}
								@if ($errors->has('pin_code'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('pin_code') }}</strong>
									</span> 
								@endif
							  </div>
						  </div>
						  <div class="form-group float-right">
							{{ Form::button('<i class="fa fa-edit"></i> Update Hotel', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-hotel")' ]) }}
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