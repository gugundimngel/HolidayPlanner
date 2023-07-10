@extends('layouts.admin')
@section('title', 'New Manage Holiday Package')

@section('content')
  <style>
 .datepicker{z-index: 9999!important;}
 .note-toolbar {
    position: relative!important;
    z-index: 1!important;
}
 </style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Manage Holiday Package</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Manage Holiday Package</li>
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
						<h3 class="card-title">New Manage Holiday Package</h3>
					  </div>  
					  <!-- /.card-header -->  
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/holidaypackage/store-duplicate', 'name'=>"store-package", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
						<div class="card-body">
							<div class="form-group" style="text-align:right;">
								<a style="margin-right:5px;" href="{{route('admin.manageholidaypackage.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>  
								{{ Form::button('<i class="fa fa-edit"></i> Update package', ['class'=>'btn btn-primary', 'id'=>'savebtn', 'onClick'=>'customValidate("store-package")' ]) }}
							</div>
							<div class="row">
							  <div class="col-5 col-sm-3">
								<div class="nav flex-column nav-tabs h-100 custom_nav_tabs" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
								  <a class="nav-link active" id="vert-tabs-packge-tab" data-toggle="pill" href="#vert-tabs-packge" role="tab" aria-controls="vert-tabs-packge" aria-selected="true">Holiday Package</a>
								  <a class="nav-link" id="vert-tabs-price-tab" data-toggle="pill" href="#vert-tabs-price" role="tab" aria-controls="vert-tabs-price" aria-selected="false">Price</a>
								  <a class="nav-link" id="vert-tabs-flight-tab" data-toggle="pill" href="#vert-tabs-flight" role="tab" aria-controls="vert-tabs-flight" aria-selected="false">Flights</a>
								   <a class="nav-link" id="vert-tabs-addon-tab" data-toggle="pill" href="#vert-tabs-addon" role="tab" aria-controls="vert-tabs-addon" aria-selected="false">Addons</a>
								  <a class="nav-link" id="vert-tabs-packtheme-tab" data-toggle="pill" href="#vert-tabs-packtheme" role="tab" aria-controls="vert-tabs-packtheme" aria-selected="false">Package Theme</a>
								  <a class="nav-link" id="vert-tabs-itinerary-tab" data-toggle="pill" href="#vert-tabs-itinerary" role="tab" aria-controls="vert-tabs-itinerary" aria-selected="false">Itinerary</a>
								  <a class="nav-link" id="vert-tabs-hotel-tab" data-toggle="pill" href="#vert-tabs-hotel" role="tab" aria-controls="vert-tabs-hotel" aria-selected="false">Hotel</a>
								  <a class="nav-link" id="vert-tabs-inclusions-tab" data-toggle="pill" href="#vert-tabs-inclusions" role="tab" aria-controls="vert-tabs-inclusions" aria-selected="false">Inclusions</a>
								  <a class="nav-link" id="vert-tabs-topinclusions-tab" data-toggle="pill" href="#vert-tabs-topinclusions" role="tab" aria-controls="vert-tabs-topinclusions" aria-selected="false">Top Inclusions</a>
								  <a class="nav-link" id="vert-tabs-exclusions-tab" data-toggle="pill" href="#vert-tabs-exclusions" role="tab" aria-controls="vert-tabs-exclusions" aria-selected="false">Exclusions</a>
								  <a class="nav-link" id="vert-tabs-tourpolicy-tab" data-toggle="pill" href="#vert-tabs-tourpolicy" role="tab" aria-controls="vert-tabs-tourpolicy" aria-selected="false">Tour Policy</a>
								  <a class="nav-link" id="vert-tabs-galleryimg-tab" data-toggle="pill" href="#vert-tabs-galleryimg" role="tab" aria-controls="vert-tabs-galleryimg" aria-selected="false">Gallery Images</a>
								  <a class="nav-link" id="vert-tabs-metatag-tab" data-toggle="pill" href="#vert-tabs-metatag" role="tab" aria-controls="vert-tabs-metatag" aria-selected="false">Meta Tags</a>
								  <a class="nav-link" id="vert-tabs-metasearch-tab" data-toggle="pill" href="#vert-tabs-metasearch" role="tab" aria-controls="vert-tabs-metasearch" aria-selected="false">Tag Destination</a>
								  <a class="nav-link" id="vert-tabs-pdf-tab" data-toggle="pill" href="#vert-tabs-pdf" role="tab" aria-controls="vert-tabs-pdf" aria-selected="false">PDF</a>
								</div> 
							  </div>
							  <div class="col-7 col-sm-9">
								<div class="tab-content custom_tab_content" id="vert-tabs-tabContent">
								  <div class="tab-pane text-left fade show active" id="vert-tabs-packge" role="tabpanel" aria-labelledby="vert-tabs-packge-tab">
								  <div class="form-group row">
											<label for="pack_type" class="col-sm-2 col-form-label">Package Type <span style="color:#ff0000;">*</span></label>
											<div class="col-sm-10">
												<select data-valid ="required" name="pack_type" id="pack_type" class="form-control" autocomplete="new-password">
													<option value="">Choose One...</option>
													<option value="fixed" <?php if($fetchedData->package_type == 'fixed'){ echo 'selected'; } ?>>Fixed Departure</option>
													<option value="group" <?php if($fetchedData->package_type == 'group'){ echo 'selected'; } ?>>Group Departure</option>
													<option value="customized" <?php if($fetchedData->package_type == 'customized'){ echo 'selected'; } ?>>Customized Departure</option>
												</select>							
												@if ($errors->has('dest_type'))
													<span class="custom-error" role="alert">
														<strong>{{ @$errors->first('dest_type') }}</strong>
													</span> 
												@endif
										   </div>	
									  </div>
									  <div class="form-group row">
											<label for="dest_type" class="col-sm-2 col-form-label">Type <span style="color:#ff0000;">*</span></label>
											<div class="col-sm-10">
												<select onChange="getLocations()" data-valid ="required" name="dest_type" id="dest_type" class="form-control" autocomplete="new-password">
													<option value="">Choose One...</option>
													<option value="domestic" <?php if($fetchedData->type == 'domestic'){ echo 'selected'; } ?>>Domestic</option>
													<option value="international" <?php if($fetchedData->type == 'international'){ echo 'selected'; } ?>>International</option>
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
												<select name="destination" data-valid ="required" id="destination" class="form-control" autocomplete="new-password">
													<option value="">Choose One...</option>
													@foreach(\App\Location::where('dest_type', @$fetchedData->type)->get() as $des)
													<option value="{{@$des->id}}" <?php if($fetchedData->destination == $des->id){ echo 'selected'; } ?>>{{@$des->name}}</option>
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
											<label for="city" class="col-sm-2 col-form-label">Departure/X-City <span style="color:#ff0000;">*</span></label>
											<div class="col-sm-10">
												<select name="city" data-valid ="required" id="city" class="form-control" autocomplete="new-password">
													<option value="">Choose One...</option>													@foreach(\App\City::where('user_id',@Auth::user()->id)->orderby('name','ASC')->get() as $clist)
														<option value="{{$clist->id}}" <?php if($fetchedData->city == $clist->id){ echo 'selected'; } ?>>{{$clist->name}}</option>
													@endforeach
												</select>							
												@if ($errors->has('city'))
													<span class="custom-error" role="alert">
														<strong>{{ @$errors->first('city') }}</strong>
													</span> 
												@endif
										   </div>	
									  </div>
									  <div class="form-group" style="text-align:right;">
										<a href="javascript:;"  datatypeid="departure_x_city" datatypemodel="Inclusionsopen_modal" class="openpopmodel"><i class="fa fa-plus"></i> Add new Departure/X-City</a>
									  </div>
									  <div class="form-group row"> 
											<label for="package_name" class="col-sm-2 col-form-label">Package Name <span style="color:#ff0000;">*</span></label>
											<div class="col-sm-10">
											{{ Form::text('package_name', @$fetchedData->package_name, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Package Name' )) }}
											@if ($errors->has('package_name'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('package_name') }}</strong>
												</span> 
											@endif
											</div>
									  </div>
									   <div class="form-group row"> 
											<label for="tour_code" class="col-sm-2 col-form-label">Tour Code </label>
											<div class="col-sm-10">
											{{ Form::text('tour_code', @$fetchedData->tour_code, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Tour Code' )) }}
											@if ($errors->has('tour_code'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('tour_code') }}</strong>
												</span> 
											@endif
											</div>
									  </div>
									  <div class="form-group row">
											<label for="package_image_alt" class="col-sm-2 col-form-label">Image Alt</label>
											<div class="col-sm-10">
											{{ Form::text('package_image_alt', @$fetchedData->package_image_alt, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Image Alt' )) }}
											@if ($errors->has('package_image_alt'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('package_image_alt') }}</strong>
												</span> 
											@endif
										  </div>
									  </div>
									  <div class="form-group row">
											<label for="package_image" class="col-sm-2 col-form-label">Package Image</label>
											<div class="col-sm-10">
												<a href="javascript:;" class="btn btn-primary showimages" data-type="package_image_m">Add Images</a> 
												<div class="package_image_m custom_pack_m"><input type="hidden" id="package_image_m" name="package_image_m" value="{{@$fetchedData->package_image}}">
												<?php $imagedata = \App\MediaImage::where('id',$fetchedData->package_image)->first();
												if($imagedata){
												?>
												<img width="100" height="100" src="{{URL::to('/public/img/media_gallery')}}/{{$imagedata->images}}"><a href="javascript:;" class="removepackimage" rdatatype="package_image_m" id="{{@$fetchedData->package_image}}"><i class="fa fa-times"></i></a>
												<?php } ?>
												</div>
											</div>
									  </div>
									  <div class="form-group row">
											<label for="banner_image_m" class="col-sm-2 col-form-label">Banner Image (1500 X 500)</label>
											<div class="col-sm-10">
												<a href="javascript:;" class="btn btn-primary showimages" data-type="banner_image_m">Add Images</a> 
												<div class="banner_image_m custom_pack_m"><input type="hidden" id="banner_image_m" name="banner_image_m" value="{{@$fetchedData->banner_image_m}}">
												<?php $imagedata = \App\MediaImage::where('id',$fetchedData->banner_image_m)->first();
												if($imagedata){
												?>
												<img width="100" height="100" src="{{URL::to('/public/img/media_gallery')}}/{{$imagedata->images}}"><a href="javascript:;" class="removepackimage" rdatatype="banner_image_m" id="{{@$fetchedData->banner_image_m}}"><i class="fa fa-times"></i></a>
												<?php } ?>
												</div>
											</div>
									  </div>
									  <div class="form-group row">
											<label for="package_overview" class="col-sm-2 col-form-label">Package Overview <span style="color:#ff0000;">*</span></label>
											<div class="col-sm-10">
												<textarea name="package_overview" data-valid ="required" class="textarea" placeholder="Please Add Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ @$fetchedData->package_overview }}</textarea>
												@if ($errors->has('package_overview'))
													<span class="custom-error" role="alert">
														<strong>{{ @$errors->first('package_overview') }}</strong>
													</span> 
												@endif
											</div>
									  </div>
									  <div class="form-group row"> 
											<label for="package_validity" class="col-sm-2 col-form-label">Package Validity <span style="color:#ff0000;">*</span></label>
											<div class="col-sm-10">
											{{ Form::text('package_validity', date('m/d/Y',strtotime(@$fetchedData->package_validity)), array('class' => 'form-control commondate', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Package Validity' )) }}
											@if ($errors->has('package_validity'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('package_validity') }}</strong>
												</span> 
											@endif
											</div>
									  </div>
									  <div class="form-group row"> 
											<label for="no_of_nights" class="col-sm-2 col-form-label">Number Of Nights <span style="color:#ff0000;">*</span></label>
											<div class="col-sm-10">
											{{ Form::text('no_of_nights', @$fetchedData->no_of_nights, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Number Of Nights', 'onkeypress'=>'return isNumberKey(event)' )) }}
											@if ($errors->has('no_of_nights'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('no_of_nights') }}</strong>
												</span> 
											@endif
											</div>
									  </div>
									  <div class="form-group row"> 
											<label for="no_of_days" class="col-sm-2 col-form-label">Number Of Days <span style="color:#ff0000;">*</span></label>
											<div class="col-sm-10">
											{{ Form::text('no_of_days', @$fetchedData->no_of_days, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Number Of Days', 'onkeypress'=>'return isNumberKey(event)' )) }}
											@if ($errors->has('no_of_days'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('no_of_days') }}</strong>
												</span> 
											@endif
											</div>
									  </div>
									  <div class="form-group row"> 
											<label for="details_day_night" class="col-sm-2 col-form-label">Details Of Days and Nights <span style="color:#ff0000;">*</span></label>
											<div class="col-sm-10">
											{{ Form::text('details_day_night', @$fetchedData->details_day_night, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'2 Nights Shimla + 2 Nights Manali + 1 Night Chandigarh' )) }}
											@if ($errors->has('details_day_night'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('details_day_night') }}</strong>
												</span> 
											@endif
											</div>
									  </div>
									  
									  <div class="form-group row"> 
											<label for="support_no" class="col-sm-2 col-form-label">Support Number <span style="color:#ff0000;">*</span></label>
											<div class="col-sm-10">
											{{ Form::text('support_no', @$fetchedData->support_no, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Support Number', 'onkeypress'=>'return isNumberKey(event)' )) }}
											@if ($errors->has('support_no'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('support_no') }}</strong>
												</span> 
											@endif
											</div>
									  </div>
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-price" role="tabpanel" aria-labelledby="vert-tabs-price-tab">
										@include('Admin.manageholidaypackage.inc.editprice')
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-flight" role="tabpanel" aria-labelledby="vert-tabs-flight-tab">	@include('Admin.manageholidaypackage.inc.flights')
								  </div>
								  
								  <div class="tab-pane fade" id="vert-tabs-addon" role="tabpanel" aria-labelledby="vert-tabs-addon-tab">
									<div class="form-group row">
											<label for="package_addons" class="col-sm-2 col-form-label">Addons</label>
			<div class="col-sm-10">
				<select name="package_addons[]" id="package_addons" class="select2" multiple="multiple" data-placeholder="Select Addons" style="width: 100%;">
					@if(count(@$addon) !== 0)
						@foreach (@$addon as $addo)
					<?php $addons = explode(',', $fetchedData->addon); ?>
							<option value="{{ @$addo->id }}" <?php if(in_array($addo->id,$addons)){ echo 'selected';  } ?>>{{ @$addo->title }}</option>
						@endforeach
					@endif 
				</select> 
			</div>
										</div>
										 <div class="form-group" style="text-align:right;">
										
									  </div>
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-packtheme" role="tabpanel" aria-labelledby="vert-tabs-packtheme-tab">	@include('Admin.manageholidaypackage.inc.package_theme')
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-itinerary" role="tabpanel" aria-labelledby="vert-tabs-itinerary-tab"> @include('Admin.manageholidaypackage.inc.itinerary')
								  </div> 
								  <div class="tab-pane fade" id="vert-tabs-hotel" role="tabpanel" aria-labelledby="vert-tabs-hotel-tab">
									  @include('Admin.manageholidaypackage.inc.hotel')
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-inclusions" role="tabpanel" aria-labelledby="vert-tabs-inclusions-tab">
										<div class="form-group row">
											<label for="package_inclusions" class="col-sm-2 col-form-label">Inclusions</label>
											<div class="col-sm-10">
												<select name="package_inclusions[]" id="packageinclusions" class="select2" multiple="multiple" data-placeholder="Select Inclusions" style="width: 100%;">
													@if(count(@$inclusion) !== 0)
														<?php $inclusio = explode(',', $fetchedData->package_inclusions); ?>
														@foreach (@$inclusion as $inclu)
															<option value="{{ @$inclu->id }}" <?php if(in_array($inclu->id,$inclusio)){ echo 'selected';  } ?>  >{{ @$inclu->name }}</option>
														@endforeach
													@endif
												</select>								
												@if ($errors->has('package_inclusions'))
													<span class="custom-error" role="alert">
														<strong>{{ @$errors->first('package_inclusions') }}</strong>
													</span> 
												@endif
											</div>			 								
									  </div>
									   <div class="form-group" style="text-align:right;">
										<a href="javascript:;"  datatypeid="inclusion" datatypemodel="Inclusionsopen_modal" class="openpopmodel"><i class="fa fa-plus"></i> Add new Inclusions</a>
									  </div>
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-topinclusions" role="tabpanel" aria-labelledby="vert-tabs-topinclusions-tab">
										<div class="form-group row">
											<label for="package_topinclusions" class="col-sm-2 col-form-label">Top Inclusions</label>
											<div class="col-sm-10">
												<select id="packagetopinclusions" name="package_topinclusions[]" class="select2" multiple="multiple" data-placeholder="Select Top Inclusions" style="width: 100%;">
													@if(count(@$topinclusion) !== 0)
														<?php $topinclusio = explode(',', $fetchedData->package_topinclusions); ?>
														@foreach (@$topinclusion as $topinclu)
															<option value="{{ @$topinclu->id }}" <?php if(in_array($topinclu->id,$topinclusio)){ echo 'selected';  } ?>  >{{ @$topinclu->name }}</option>
														@endforeach
													@endif 
												</select>								
												@if ($errors->has('package_topinclusions'))
													<span class="custom-error" role="alert">
														<strong>{{ @$errors->first('package_topinclusions') }}</strong>
													</span> 
												@endif
											</div>
										</div>
										 <div class="form-group" style="text-align:right;">
										<a href="javascript:;" datatypeid="topinclusion" datatypemodel="Inclusionsopen_modal" class="openpopmodel"><i class="fa fa-plus"></i> Add new Top Inclusions</a>
									  </div>
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-exclusions" role="tabpanel" aria-labelledby="vert-tabs-exclusions-tab">
										<div class="form-group row">
											<label for="package_exclusions" class="col-sm-2 col-form-label">Exclusions</label>
											<div class="col-sm-10">
												<select id="packageexclusions" name="package_exclusions[]" class="select2" multiple="multiple" data-placeholder="Select Exclusions" style="width: 100%;">
													@if(count(@$exclusion) !== 0)
														<?php $exclusio = explode(',', $fetchedData->package_exclusions); ?>
														@foreach (@$exclusion as $exclu)
															<option value="{{ @$exclu->id }}" <?php if(in_array($exclu->id,$exclusio)){ echo 'selected';  } ?>   >{{ @$exclu->name }}</option>
														@endforeach
													@endif 
												</select>								
												@if ($errors->has('package_exclusions'))
													<span class="custom-error" role="alert">
														<strong>{{ @$errors->first('package_exclusions') }}</strong> 
													</span> 
												@endif 
											</div>
										</div>
										<div class="form-group" style="text-align:right;">
											<a href="javascript:;" datatypeid="exclusions" datatypemodel="Inclusionsopen_modal" class="openpopmodel"><i class="fa fa-plus"></i> Add new Exclusions</a>
										</div>
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-tourpolicy" role="tabpanel" aria-labelledby="vert-tabs-tourpolicy-tab">
										<div class="form-group row">
											<label for="package_tourpolicy" class="col-sm-2 col-form-label">Tour Policy</label>
											<div class="col-sm-10">
												<textarea name="package_tourpolicy" class="textarea" placeholder="Please Add Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{@$fetchedData->package_tourpolicy}}</textarea>
												@if ($errors->has('package_tourpolicy'))
													<span class="custom-error" role="alert">
														<strong>{{ @$errors->first('package_tourpolicy') }}</strong>
													</span> 
												@endif
											</div>
										</div>
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-galleryimg" role="tabpanel" aria-labelledby="vert-tabs-galleryimg-tab">
									  @include('Admin.manageholidaypackage.inc.gallery')
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-metatag" role="tabpanel" aria-labelledby="vert-tabs-metatag-tab">
									  @include('Admin.manageholidaypackage.inc.metatag')
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-metasearch" role="tabpanel" aria-labelledby="vert-tabs-metasearch-tab">
									  @include('Admin.manageholidaypackage.inc.metasearch')
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-pdf" role="tabpanel" aria-labelledby="vert-tabs-pdf-tab">
										<div class="form-group row">
											<label for="pdf" class="col-sm-2 col-form-label">PDF</label>
											<div class="col-sm-10">
												<input type="hidden" id="old_pdf" name="old_pdf" value="{{@$fetchedData->pdf}}" /> 
												<div class="show_custom_file_error"></div>
												<input id="pdfdoc" type="file" accept="application/pdf" name="pdf" class="form-control" autocomplete="off" data-valid="" />
												<div class="pdf_link">
													<a href="{{@$fetchedData->pdf}}">{{@$fetchedData->pdf}}</a>
												</div>
												
												@if ($errors->has('pdf'))
													<span class="custom-error" role="alert">
														<strong>{{ @$errors->first('pdf') }}</strong>
													</span> 
												@endif
											</div>
										</div>
								  </div>
								  
								</div>
							  </div>
							</div>
						  
							<div class="package_full_form" style="text-align: right;">
							  <div class="form-group">
								{{ Form::button('<i class="fa fa-edit"></i> Update package', ['class'=>'btn btn-primary', 'id'=>'savebtn', 'onClick'=>'customValidate("store-package")' ]) }}
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
<div class="modal fade" id="Inclusionsopen_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		
			<div class="modal-header">
			  <h4 class="modal-title">Add New</h4>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			{{ Form::open(array('url' => 'admin/add_inclusion', 'id'=>"addnewdatapackage", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
			<div class="modal-body">
				<div class="inclusion-error"></div>
				<div class="form-group row"> 
					<label for="name" class="col-sm-2 col-form-label">Name <span style="color:#ff0000;">*</span></label>
					<div class="col-sm-10">
					<input type="hidden" id="savetype" name="savetype">
					{{ Form::text('inclusion_Name', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Name','id'=>'inclusion_Name' )) }}
					@if ($errors->has('name'))
						<span class="custom-error" role="alert">
							<strong>{{ @$errors->first('name') }}</strong>
						</span> 
					@endif
					</div>
			  </div>
			  <div class="form-group row displayiftopinclusion" style="display:none"> 
					<label for="name" class="col-sm-2 col-form-label">Image <span style="color:#ff0000;">*</span></label>
					<div class="col-sm-10">
					<input type="file" id="fileimage" name="image" class="form-control" autocomplete="off"  />
						
					</div>
			  </div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" id="save_Inclusion" class="btn btn-primary">Save</button>
			</div>
		{{ Form::close() }}
		</div>
	</div>
</div>
<div class="pricedetail" style="display:none;">
<hr>
<div class="pdetail">
	<div class="form-group row"> 
	<label for="twin" class="col-sm-4 col-form-label">Twin <span style="color:#ff0000;">*</span></label>
	<div class="col-sm-6">
	{{ Form::text('twin[]', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'twin Price', 'onkeypress'=>'return isNumberKey(event)' )) }}
	@if ($errors->has('twin'))
		<span class="custom-error" role="alert">
			<strong>{{ @$errors->first('twin') }}</strong>
		</span> 
	@endif
	</div>
</div>
<div class="form-group row"> 
	<label for="triple" class="col-sm-4 col-form-label">Triple <span style="color:#ff0000;">*</span></label>
	<div class="col-sm-6">
	{{ Form::text('triple[]', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Tripple Price', 'onkeypress'=>'return isNumberKey(event)' )) }}
	@if ($errors->has('triple'))
		<span class="custom-error" role="alert">
			<strong>{{ @$errors->first('triple') }}</strong>
		</span> 
	@endif
	</div>
</div>
<div class="form-group row"> 
	<label for="single" class="col-sm-4 col-form-label">Single</label>
	<div class="col-sm-6">
	{{ Form::text('single[]', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'single', 'onkeypress'=>'return isNumberKey(event)' )) }}
	@if ($errors->has('single'))
		<span class="custom-error" role="alert">
			<strong>{{ @$errors->first('single') }}</strong>
		</span> 
	@endif
	</div>
</div>

<div class="form-group row"> 
	<label for="child_with_bed" class="col-sm-4 col-form-label">Child with Bed (below 12 years)</label>
	<div class="col-sm-6">
	{{ Form::text('child_with_bed[]', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Child with Bed (below 12 years)', 'onkeypress'=>'return isNumberKey(event)' )) }}
	@if ($errors->has('child_with_bed'))
		<span class="custom-error" role="alert">
			<strong>{{ @$errors->first('child_with_bed') }}</strong>
		</span> 
	@endif
	</div>
</div>
<div class="form-group row"> 
	<label for="child_without_bedbelow12" class="col-sm-4 col-form-label">Child without Bed (below 12 years)</label>
	<div class="col-sm-6">
	{{ Form::text('child_without_bedbelow12[]', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Child without Bed (below 12 years)', 'onkeypress'=>'return isNumberKey(event)' )) }}
	@if ($errors->has('child_without_bedbelow12'))
		<span class="custom-error" role="alert">
			<strong>{{ @$errors->first('child_without_bedbelow12') }}</strong>
		</span> 
	@endif
	</div>
</div>
<div class="form-group row"> 
	<label for="child_without_bedbelow26" class="col-sm-4 col-form-label">Child without Bed (below 2-3 years)</label>
	<div class="col-sm-6">
	{{ Form::text('child_without_bedbelow26[]', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Child without Bed (below 2-3 years)', 'onkeypress'=>'return isNumberKey(event)' )) }}
	@if ($errors->has('child_without_bedbelow26'))
		<span class="custom-error" role="alert">
			<strong>{{ @$errors->first('child_without_bedbelow26') }}</strong>
		</span> 
	@endif
	</div>
</div>
<div class="form-group row"> 
	<label for="infant" class="col-sm-4 col-form-label">Infant</label>
	<div class="col-sm-6">
	{{ Form::text('infant[]', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Infant', 'onkeypress'=>'return isNumberKey(event)' )) }}
	@if ($errors->has('infant'))
		<span class="custom-error" role="alert">
			<strong>{{ @$errors->first('infant') }}</strong>
		</span> 
	@endif
	</div>
</div>
<div class="form-group row"> 
	<label for="adult_flight" class="col-sm-4 col-form-label">Adult (Flight Only)</label>
	<div class="col-sm-6">
	{{ Form::text('adult_flight[]', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Adult (Flight Only)', 'onkeypress'=>'return isNumberKey(event)' )) }}
	@if ($errors->has('adult_flight'))
		<span class="custom-error" role="alert">
			<strong>{{ @$errors->first('adult_flight') }}</strong>
		</span> 
	@endif
	</div>
</div>
<div class="form-group row"> 
	<label for="child_flight" class="col-sm-4 col-form-label">Child (Flight Only)</label>
	<div class="col-sm-6">
	{{ Form::text('child_flight[]', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Child (Flight Only)', 'onkeypress'=>'return isNumberKey(event)' )) }}
	@if ($errors->has('child_flight'))
		<span class="custom-error" role="alert">
			<strong>{{ @$errors->first('child_flight') }}</strong>
		</span> 
	@endif
	</div>
</div>
<div class="form-group row"> 
	<label for="infant_flight" class="col-sm-4 col-form-label">Infant (Flight Only)</label>
	<div class="col-sm-6">
	{{ Form::text('infant_flight[]', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Infant (Flight Only)', 'onkeypress'=>'return isNumberKey(event)' )) }}
	@if ($errors->has('infant_flight'))
		<span class="custom-error" role="alert">
			<strong>{{ @$errors->first('infant_flight') }}</strong>
		</span> 
	@endif
	</div>
</div>
<div class="form-group row"> 
	<label for="seats" class="col-sm-4 col-form-label">Total Seat Available</label>
	<div class="col-sm-6">
	{{ Form::text('seats[]', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Total Seat Available', 'onkeypress'=>'return isNumberKey(event)' )) }}
	@if ($errors->has('seats'))
		<span class="custom-error" role="alert">
			<strong>{{ @$errors->first('seats') }}</strong>
		</span> 
	@endif
	</div>
</div>
<div class="form-group row">
<label for="price_type" class="col-sm-4 col-form-label">Price Type</label>
<div class="col-sm-6">
<select class="form-control" name="price_type[]">
	<option value="Per Person">Per Person</option>
	<option value="Twin Sharing">Twin Sharing</option>
	<option value="Triple Sharing">Triple Sharing</option>
</select>
</div>
</div>
<div class="form-group row">
	<label for="booking_amt" class="col-sm-4 col-form-label">Booking Amount</label>
	<div class="col-sm-3">
<input type="text" onkeypress='return isNumberKey(event)' class="form-control" name="booking_amt[]">
	</div>
	<div class="col-sm-3">
		<select class="form-control" name="dis_type[]">
			<option value="Percentage">Percentage</option>
			<option value="Fixed">Fixed</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="bal_rec_day" class="col-sm-4 col-form-label">Balance Receiving Day</label>
	<div class="col-sm-6">
<input type="text" class="form-control" name="bal_rec_day[]">
	</div>
	
</div>
<div class="form-group row">
	<label for="price_summary" class="col-sm-4 col-form-label">More/Additional Detail (Optional)</label>
	<div class="col-sm-6">
		<textarea name="price_summary[]" class="textarea" placeholder="Please Add Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
		@if ($errors->has('price_summary'))
			<span class="custom-error" role="alert">
				<strong>{{ @$errors->first('price_summary') }}</strong>
			</span> 
		@endif
	</div>
</div> 
<div class="form-group row">
	<label for="departure_date" class="col-sm-4 col-form-label">Departure Date</label>
	<div class="col-sm-4">
		{{ Form::text('departure_date[]', '', array('class' => 'form-control commondydate', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Departure Date', 'onkeypress'=>'return isNumberKey(event)' )) }}
	</div>
	<div class="col-sm-4">
		<a href="javascript:;" class="adddate btn btn-primary"><i class="fa fa-plus">Add Date</i></a>
	</div>
</div>
<div class="datedata"></div>

</div>
</div>
@endsection