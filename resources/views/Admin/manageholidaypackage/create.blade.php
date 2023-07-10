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
 <?php use App\Http\Controllers\Controller; ?>
  <script language="Javascript">
       <!--
       function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
       //-->
    </script>
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
					  {{ Form::open(array('url' => 'admin/holidaypackage/store', 'name'=>"add-package", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
						<div class="card-body">
							<div class="form-group" style="text-align:right;">
								<a style="margin-right:5px;" href="{{route('admin.manageholidaypackage.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>  
								{{ Form::button('<i class="fa fa-save"></i> Save Package', ['class'=>'btn btn-primary', 'id' => 'savebtn', 'onClick'=>'customValidate("add-package")' ]) }}
							</div>
							<div class="row">
							  <div class="col-5 col-sm-3">
								<div class="nav flex-column nav-tabs h-100 custom_nav_tabs" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
								  <a class="nav-link active" id="vert-tabs-packge-tab" data-toggle="pill" href="#vert-tabs-packge" role="tab" aria-controls="vert-tabs-packge" aria-selected="true">Holiday Package</a>
								  <a class="nav-link" id="vert-tabs-flight-tab" data-toggle="pill" href="#vert-tabs-flight" role="tab" aria-controls="vert-tabs-flight" aria-selected="false">Flights</a>
								  <a class="nav-link" id="vert-tabs-price-tab" data-toggle="pill" href="#vert-tabs-price" role="tab" aria-controls="vert-tabs-price" aria-selected="false">Price</a>
								   
								   <a class="nav-link" id="vert-tabs-addon-tab" data-toggle="pill" href="#vert-tabs-addon" role="tab" aria-controls="vert-tabs-addon" aria-selected="false">Addons</a>
								  <a class="nav-link" id="vert-tabs-packtheme-tab" data-toggle="pill" href="#vert-tabs-packtheme" role="tab" aria-controls="vert-tabs-packtheme" aria-selected="false">Package Theme</a>
								  <a class="nav-link" id="vert-tabs-itinerary-tab" data-toggle="pill" href="#vert-tabs-itinerary" role="tab" aria-controls="vert-tabs-itinerary" aria-selected="false">Itinerary</a>
								  <a class="nav-link" id="vert-tabs-hotel-tab" data-toggle="pill" href="#vert-tabs-hotel" role="tab" aria-controls="vert-tabs-hotel" aria-selected="false">Hotel</a>
								  <a class="nav-link" id="vert-tabs-inclusions-tab" data-toggle="pill" href="#vert-tabs-inclusions" role="tab" aria-controls="vert-tabs-inclusions" aria-selected="false">Inclusions</a>
								  <a class="nav-link" id="vert-tabs-topinclusions-tab" data-toggle="pill" href="#vert-tabs-topinclusions" role="tab" aria-controls="vert-tabs-topinclusions" aria-selected="false">Top Inclusions</a>
								  <a class="nav-link" id="vert-tabs-exclusions-tab" data-toggle="pill" href="#vert-tabs-exclusions" role="tab" aria-controls="vert-tabs-exclusions" aria-selected="false">Exclusions</a>
								  <a class="nav-link" id="vert-tabs-visa-tab" data-toggle="pill" href="#vert-tabs-visa" role="tab" aria-controls="vert-tabs-visa" aria-selected="false">Visa</a>
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
													<option value="fixed">Fixed Departure</option>
													<option value="group">Group Departure</option>
													<option value="customized">Customized Departure</option>
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
												<select name="destination" data-valid ="required" id="destination" class="form-control" autocomplete="new-password">
													<option value="">Choose One...</option>
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
													<option value="">Choose One...</option>
													@foreach(\App\City::where('user_id',@Auth::user()->id)->orderby('name','ASC')->get() as $clist)
														<option value="{{$clist->id}}">{{$clist->name}}</option>
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
											{{ Form::text('package_name', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Package Name' )) }}
											@if ($errors->has('package_name'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('package_name') }}</strong>
												</span> 
											@endif
											</div>
									  </div>
									  <div class="form-group row"> 
											<label for="tour_code" class="col-sm-2 col-form-label">Tour Code</label>
											<div class="col-sm-10">
											{{ Form::text('tour_code', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Tour Code' )) }}
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
											{{ Form::text('package_image_alt', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Image Alt' )) }}
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
												
											<?php Controller::fileupload('','','package_image_id','package_img_name'); ?>
											</div>
											
									  </div>
									  <div class="form-group row">
											<label for="banner_image_m" class="col-sm-2 col-form-label">Banner Image (1500 X 500)</label>
											<div class="col-sm-10">
												
											<?php Controller::fileupload('','','banner_image_id','banner_img_name'); ?>
											</div>
									  </div>
									  <div class="form-group row">
											<label for="package_overview" class="col-sm-2 col-form-label">Package Overview</label>
											<div class="col-sm-10">
												<textarea name="package_overview" data-valid ="" class="textarea" placeholder="Please Add Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
												@if ($errors->has('package_overview'))
													<span class="custom-error" role="alert">
														<strong>{{ @$errors->first('package_overview') }}</strong>
													</span> 
												@endif
											</div>
									  </div>
									  <div class="form-group row"> 
											<label for="package_validity" class="col-sm-2 col-form-label">Package Start Date</label>
											<div class="col-sm-10">
											{{ Form::text('package_validity', '', array('class' => 'form-control commondate', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Package Validity' )) }}
											<div class="calendar_icon"><i class="fa fa-calendar"></i></div>
											@if ($errors->has('package_validity'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('package_validity') }}</strong>
												</span> 
											@endif
											</div>
									  </div>
									  <div class="form-group row"> 
											<label for="package_enddate" class="col-sm-2 col-form-label">Package End Date</label>
											<div class="col-sm-10">
											{{ Form::text('package_enddate', '', array('class' => 'form-control commondate', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter End Date' )) }}
											<div class="calendar_icon"><i class="fa fa-calendar"></i></div>
											@if ($errors->has('package_enddate'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('package_enddate') }}</strong>
												</span> 
											@endif
											</div>
									  </div>
									  <div class="form-group row"> 
											<label for="no_of_nights" class="col-sm-2 col-form-label">Number Of Nights <span style="color:#ff0000;">*</span></label>
											<div class="col-sm-10">
											{{ Form::text('no_of_nights', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Number Of Nights', 'onkeypress'=>'return isNumberKey(event)' )) }}
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
											{{ Form::text('no_of_days', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Number Of Days', 'onkeypress'=>'return isNumberKey(event)' )) }}
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
											{{ Form::text('details_day_night', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'2 Nights Shimla + 2 Nights Manali + 1 Night Chandigarh' )) }}
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
											{{ Form::text('support_no', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Support Number', 'onkeypress'=>'return isNumberKey(event)' )) }}
											@if ($errors->has('support_no'))
												<span class="custom-error" role="alert">
													<strong>{{ @$errors->first('support_no') }}</strong>
												</span> 
											@endif
											</div>
									  </div>
								  </div>
								   <div class="tab-pane fade" id="vert-tabs-flight" role="tabpanel" aria-labelledby="vert-tabs-flight-tab">	
										<div class="form-group row"> 
											<label for="flight_name" class="col-sm-2 col-form-label">Flight Name</label>
											<div class="col-sm-10">
											{{ Form::text('flight_name', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Flight Name', 'onkeypress'=>'' )) }}
											
											</div>
										</div>
										<div class="form-group row"> 
											<label for="dep_city" class="col-sm-2 col-form-label">Departure City</label>
											<div class="col-sm-10">
											{{ Form::text('dep_city', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Departure City', 'onkeypress'=>'' )) }}
											
											</div>
										</div>
										<div class="form-group row"> 
											<label for="arv_city" class="col-sm-2 col-form-label">Arrival City</label>
											<div class="col-sm-10">
											{{ Form::text('arv_city', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Arrival City', 'onkeypress'=>'' )) }}
											
											</div>
										</div>
										<div class="form-group row"> 
											<label for="dep_time" class="col-sm-2 col-form-label">Departure Time</label>
											<div class="col-sm-10">
											{{ Form::text('dep_time', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Departure Time', 'onkeypress'=>'' )) }}
											
											</div>
										</div>
										<div class="form-group row"> 
											<label for="arv_time" class="col-sm-2 col-form-label">Arrival Time</label>
											<div class="col-sm-10">
											{{ Form::text('arv_time', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Arrival Time', 'onkeypress'=>'' )) }}
											</div>
										</div>
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-price" role="tabpanel" aria-labelledby="vert-tabs-price-tab">
										<div class="form-group row">
											<a href="javascript:;" class="addmyprice btn btn-primary"><i class="fa fa-plus"></i> Add Price</a>
										</div>
										<table class="table table-hover text-nowrap">
											<thead>
												<tr>
													<th>Departure Date</th>
													<th>Seats Available</th>
													<th></th>
												</tr>
											</thead>
											<tbody class="pricedata">
											</tbody>
										</table>
								  </div>
								 
								  
								  <div class="tab-pane fade" id="vert-tabs-addon" role="tabpanel" aria-labelledby="vert-tabs-addon-tab">
									<div class="form-group row">
											<label for="package_addons" class="col-sm-2 col-form-label">Addons</label>
											<div class="col-sm-10">
												<select name="package_addons[]" id="package_addons" class="select2" multiple="multiple" data-placeholder="Select Addons" style="width: 100%;">
													@if(count(@$addon) !== 0)
														@foreach (@$addon as $addo)
															<option value="{{ @$addo->id }}">{{ @$addo->title }}</option>
														@endforeach
													@endif 
												</select>
											</div>
										</div>
										 <div class="form-group" style="text-align:right;">
										<!--<a href="javascript:;" datatypeid="topinclusion" datatypemodel="Inclusionsopen_modal" class="openpopmodel"><i class="fa fa-plus"></i> Add new Top Inclusions</a>-->
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
										<h4>Inclusions</h4>
										<div class="myinclusion">
											<div class="form-group row">
												<div class="col-sm-10">
													<input type="text" class="form-control" name="package_inclusions[]" value="">			
												</div>			 								
											</div>
										</div>
									  <div class="form-group" style="text-align:right;">
										<a href="javascript:;"  class="btn btn-primary addinclusion"><i class="fa fa-plus"></i> Add New</a>
									  </div>
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-topinclusions" role="tabpanel" aria-labelledby="vert-tabs-topinclusions-tab">
										<div class="form-group row">
											<label for="package_topinclusions" class="col-sm-2 col-form-label">Top Inclusions</label>
											<div class="col-sm-10">
												<select name="package_topinclusions[]" id="packagetopinclusions" class="select2" multiple="multiple" data-placeholder="Select Top Inclusions" style="width: 100%;">
													@if(count(@$topinclusion) !== 0)
														@foreach (@$topinclusion as $topinclu)
															<option value="{{ @$topinclu->id }}">{{ @$topinclu->name }}</option>
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
										<!--<a href="javascript:;" datatypeid="topinclusion" datatypemodel="Inclusionsopen_modal" class="openpopmodel"><i class="fa fa-plus"></i> Add new Top Inclusions</a>-->
									  </div>
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-exclusions" role="tabpanel" aria-labelledby="vert-tabs-exclusions-tab">
									<h4>Exclusions</h4>
									
											
											<div class="myeclusion">
												<div class="form-group row">
													<div class="col-sm-10">
														<input type="text" class="form-control" name="package_exclusions[]" value="">			
													</div>			 								
												</div>
											</div>
										  <div class="form-group" style="text-align:right;">
											<a href="javascript:;"  class="btn btn-primary addeclusion"><i class="fa fa-plus"></i> Add New</a>
										  </div>
										
										
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-visa" role="tabpanel" aria-labelledby="vert-tabs-visa-tab">
										<h4>Visa</h4>
										 <div class="form-group row">
											
											<div class="col-sm-10">
												<textarea name="visa_overview" data-valid ="" class="textarea" placeholder="" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
												
											</div>
									  </div>
								  </div>
								  <div class="tab-pane fade" id="vert-tabs-tourpolicy" role="tabpanel" aria-labelledby="vert-tabs-tourpolicy-tab">
										<h4>Tour Policy</h4>
											<div class="mypolicy">
												<div class="form-group row">
													<div class="col-sm-10">
														<input type="text" class="form-control" name="tour_policy[]" value="">
													</div>
												</div>
											</div>
										  <div class="form-group" style="text-align:right;">
											<a href="javascript:;"  class="btn btn-primary addpolicy"><i class="fa fa-plus"></i> Add New</a>
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
												<div class="show_custom_file_error"></div>
												<input type="file" id="pdfdoc" accept="application/pdf" name="pdf" class="form-control" autocomplete="off" data-valid="" />
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
								{{ Form::button('<i class="fa fa-save"></i> Save Package', ['class'=>'btn btn-primary', 'id' => 'savebtn', 'onClick'=>'customValidate("add-package")' ]) }}
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

@endsection
@section('scripts')
<script>
jQuery(document).ready(function($){
	$(document).delegate('.addinclusion', 'click', function(){
		$('.myinclusion').append('<div class="form-group row"><div class="col-sm-10"><input type="text" class="form-control" name="package_inclusions[]" value=""></div><div class="col-sm-2"><a href="javascript:;" class="remitenry"><i class="fa fa-times"></i></a></div></div>');
	});
	$(document).delegate('.remitenry', 'click', function(){
		$(this).parent().parent().remove();
	});
	
	$(document).delegate('.addeclusion', 'click', function(){
		$('.myeclusion').append('<div class="form-group row"><div class="col-sm-10"><input type="text" class="form-control" name="package_exclusions[]" value=""></div><div class="col-sm-2"><a href="javascript:;" class="remexitenry"><i class="fa fa-times"></i></a></div></div>');
	});
	$(document).delegate('.remexitenry', 'click', function(){
		$(this).parent().parent().remove();
	});
	
	$(document).delegate('.addpolicy', 'click', function(){
		$('.mypolicy').append('<div class="form-group row"><div class="col-sm-10"><input type="text" class="form-control" name="tour_policy[]" value=""></div><div class="col-sm-2"><a href="javascript:;" class="rempolicy"><i class="fa fa-times"></i></a></div></div>');
	});
	$(document).delegate('.rempolicy', 'click', function(){
		$(this).parent().parent().remove();
		
	});
	
	$(document).delegate('.addmyprice', 'click', function(){
		$('#saveprice')[0].reset();
		$('#priceblock').modal('show');
		$('#update_price').hide();
		$('#save_price').show();
		 $('#update_price').attr('did','');
		 $('input[name="flight_type"]').val(['0']);
	});
	
	$(document).delegate('.flighttyp', 'click', function(){
		var v = $('.flighttyp:checked').val();
	
		if(v == 0){
			$('.if_diffrent_flight').hide();
			$('input[name="flightname"]').val('');
			$('input[name="dep_city"]').val('');
			$('input[name="arv_city"]').val('');
			$('input[name="dep_time"]').val('');
			$('input[name="arv_time"]').val('');
		}else{
			$('.if_diffrent_flight').show();
		}
	});
	
	$(document).delegate('#save_flight', 'click', function(){
		var i = 0;	
		$(".custom-error").remove();
		var dep_id = $(this).attr('dep_id');
		$("form[name='saveflight'] :input[data-valid]").each(function(){
				var dataValidation = $(this).attr('data-valid');
			var splitDataValidation = dataValidation.split(' ');
			var j = 0; //for serial wise errors shown	
			if($.inArray("required", splitDataValidation) !== -1) //for required
				{
					var for_class = $(this).attr('class');	
					if( !$.trim($(this).val()) ) 
					{
						i++;
						$(this).after(errorDisplay(requiredError));  
					}
				}
				});
				if(i > 0)
				{
					$('#flightblock').animate({scrollTop:0}, 'slow');
					return false;
				}else{
					var flightdata = $('#saveflight').serialize();
					let obj = Object.fromEntries(new URLSearchParams(flightdata));
					console.log(obj);
					
					$('#'+dep_id+' .flightdata span').html('<input type="hidden" class="flightblo" name="sel_flight[]" value="'+flightdata+'">');
					
					$('#flightblock').modal('hide');
					 $('#saveflight')[0].reset();
					$('.if_diffrent_flight').hide();
				}	
		
	});
	
	
	$(document).delegate('#save_price', 'click', function(){
		var i = 0;	
		$(".custom-error").remove();
		$("form[name='saveprice'] :input[data-valid]").each(function(){
				var dataValidation = $(this).attr('data-valid');
			var splitDataValidation = dataValidation.split(' ');
			var j = 0; //for serial wise errors shown	
			if($.inArray("required", splitDataValidation) !== -1) //for required
				{
					var for_class = $(this).attr('class');	
					if( !$.trim($(this).val()) ) 
					{
						i++;
						$(this).after(errorDisplay(requiredError));  
					}
				}
				});
				if(i > 0)
				{
					$('#priceblock').animate({scrollTop:0}, 'slow');
					return false;
				}else{
					var pricedata = $('#saveprice').serialize();
					let obj = Object.fromEntries(new URLSearchParams(pricedata));
					console.log(obj);
					
					$('.pricedata').append('<tr><td class=""depdateinfo>'+obj.departure_date+'</td><td class="depseatinfo">'+obj.seats+'</td><td class="pricedatainfo"><a href="javascript:;" class="remove_pricerow"><i class="fa fa-trash"></i></a>/<a href="javascript:;" class="edit_pricerow"><i class="fa fa-edit"></i></a> <input type="hidden" class="priceblo" name="dep_price[]" value="'+pricedata+'"></td></tr>');
					
					$('#priceblock').modal('hide');
					 $('#saveprice')[0].reset();
					 trrow_seq();
				}	
		
	});
	$(document).delegate('.edit_pricerow', 'click', function(){
		$('#saveprice')[0].reset();
		$('.if_diffrent_flight').hide();
		$('#priceblock').modal('show');
		$('#update_price').show();
		$('#save_price').hide();
		var v = $(this).parent().find('.priceblo').val();
		var vs = $(this).parent().parent().attr('id');
		var pricedata = v;
		$('#update_price').attr('did',vs);
		let obj = Object.fromEntries(new URLSearchParams(pricedata));
		console.log(obj);
					
		$('input[name="departure_date"]').val(obj.departure_date);
		$('input[name="seats"]').val(obj.seats);
		$('input[name="twin"]').val(obj.twin);
		$('input[name="triple"]').val(obj.triple);
		$('input[name="single"]').val(obj.single);
		$('input[name="child_with_bed"]').val(obj.child_with_bed);
		$('input[name="child_without_bedbelow12"]').val(obj.child_without_bedbelow12);
		$('input[name="child_without_bedbelow26"]').val(obj.child_without_bedbelow26);
		$('input[name="dis_type"]').val(obj.dis_type);
		$('input[name="adult_flight"]').val(obj.adult_flight);
		$('input[name="booking_amt"]').val(obj.booking_amt);
		$('input[name="child_flight"]').val(obj.child_flight);
		$('input[name="infant_flight"]').val(obj.infant_flight);
		$('input[name="infant"]').val(obj.infant);
		$('.price_type').val(obj.price_type);
		$('.dis_type').val(obj.dis_type);
		$('input[name="flight_type"]').val([obj.flight_type]);
		if(obj.flight_type == 1){
			$('.if_diffrent_flight').show();
			$('input[name="flightname"]').val(obj.flightname);
			$('input[name="dep_city"]').val(obj.dep_city);
			$('input[name="arv_city"]').val(obj.arv_city);
			$('input[name="dep_time"]').val(obj.dep_time);
			$('input[name="arv_time"]').val(obj.arv_time);
		}else{
			$('input[name="flightname"]').val('');
						$('input[name="dep_city"]').val('');
						$('input[name="arv_city"]').val('');
						$('input[name="dep_time"]').val('');
						$('input[name="arv_time"]').val('');
			$('.if_diffrent_flight').hide();
		}
		
		$('.balance_rec').val(obj.balance_rec);
	});
	
	$(document).delegate('#update_price', 'click', function(){
		var i = 0;	
		var vs = $(this).attr('did');
		$(".custom-error").remove();
		$("form[name='saveprice'] :input[data-valid]").each(function(){
				var dataValidation = $(this).attr('data-valid');
			var splitDataValidation = dataValidation.split(' ');
			var j = 0; //for serial wise errors shown	
			if($.inArray("required", splitDataValidation) !== -1) //for required
				{
					var for_class = $(this).attr('class');	
					if( !$.trim($(this).val()) ) 
					{
						i++;
						$(this).after(errorDisplay(requiredError));  
					}
				}
				});
				if(i > 0)
				{
					$('#priceblock').animate({scrollTop:0}, 'slow');
					return false;
				}else{
					var pricedata = $('#saveprice').serialize();
					let obj = Object.fromEntries(new URLSearchParams(pricedata));
					console.log(obj);
					$('.pricedata tr#'+vs+' .depdateinfo').html(obj.departure_date);
					$('.pricedata tr#'+vs+' .depseatinfo').html(obj.seats);
					
					$('input[name="flight_type"]').val([obj.flight_type]);
					if(obj.flight_type == 1){
						$('.if_diffrent_flight').show();
						$('input[name="flightname"]').val(obj.flightname);
						$('input[name="dep_city"]').val(obj.dep_city);
						$('input[name="arv_city"]').val(obj.arv_city);
						$('input[name="dep_time"]').val(obj.dep_time);
						$('input[name="arv_time"]').val(obj.arv_time);
					}else{
						$('input[name="flightname"]').val('');
						$('input[name="dep_city"]').val('');
						$('input[name="arv_city"]').val('');
						$('input[name="dep_time"]').val('');
						$('input[name="arv_time"]').val('');
						$('.if_diffrent_flight').hide();
					}
					$('.pricedata tr#'+vs+' .pricedatainfo').html('<a href="javascript:;" class="remove_pricerow"><i class="fa fa-trash"></i></a>/<a href="javascript:;" class="edit_pricerow"><i class="fa fa-edit"></i></a><input type="hidden" class="priceblo" name="dep_price[]" value="'+pricedata+'">');
					/* $('.pricedata tr#'+vs).html('<td>'+obj.departure_date+'</td><td>'+obj.seats+'</td><td><a href="javascript:;" class="remove_pricerow"><i class="fa fa-trash"></i></a>/<a href="javascript:;" class="edit_pricerow"><i class="fa fa-edit"></i></a><input type="hidden" class="priceblo" name="dep_price[]" value="'+pricedata+'"></td><td class="flightdata"><span></span><select class="form-control addsflight" name="flight_type[]"><option value="1">Same Flight </option><option value="2">Add/Update Flight</option></select></td>'); */
					
					$('#priceblock').modal('hide');
					 $('#saveprice')[0].reset();
					 $('#update_price').attr('did','');
				}	
		
	});
	$(document).delegate('.remove_pricerow', 'click', function(){
		$(this).parent().parent().remove();
		trrow_seq();
	});
	function trrow_seq(){
		var troe = 0;
		$('.pricedata tr').each(function(){
			$(this).attr('id',troe);
			troe++;
		});
	}
	
	
});
</script>
<div class="modal fade" id="priceblock">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Price</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
			</div>
			<form action="" method="post" id="saveprice" name="saveprice">
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group row">
							<label for="b2cPrice" class="col-sm-3 col-form-label">Starting B2C Price <span style="color:red">*</span></label>
							<div class="col-sm-9">
								{{ Form::text('b2cPrice', '', array('class' => 'form-control ', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Starting B2C Price', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
						</div>
						<div class="form-group row">
							<label for="b2bPrice" class="col-sm-3 col-form-label">Starting B2B Price <span style="color:red">*</span></label>
							<div class="col-sm-9">
								{{ Form::text('b2bPrice', '', array('class' => 'form-control ','data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Starting B2B Price', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
						</div>
						<div class="form-group row">
							<label for="corporatePrice" class="col-sm-3 col-form-label">Starting Corporate Price <span style="color:red">*</span></label>
							<div class="col-sm-9">
								{{ Form::text('corporatePrice', '', array('class' => 'form-control ','data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Starting Corporate Price', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
						</div>
						<div class="form-group row">
							<label for="departure_date" class="col-sm-3 col-form-label">Departure Date</label>
							<div class="col-sm-9">
								{{ Form::text('departure_date', '', array('class' => 'form-control commondydate', 'autocomplete'=>'off','placeholder'=>'Enter Departure Date', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
						</div>
						<div class="form-group row">
							<label for="seats" class="col-sm-3 col-form-label">Total Seat Available</label>
							<div class="col-sm-9">
								{{ Form::text('seats', '', array('class' => 'form-control', 'autocomplete'=>'off','placeholder'=>'Total Seat Available', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
						</div>
				
						<div class="form-group row"> 
							<label for="twin" class="col-sm-3 col-form-label">Twin</label>
							<div class="col-sm-9">
							{{ Form::text('twin', '', array('class' => 'form-control',  'autocomplete'=>'off','placeholder'=>'twin Price', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
					  </div>
				
						<div class="form-group row"> 
							<label for="triple" class="col-sm-3 col-form-label">Triple</label>
							<div class="col-sm-9">
							{{ Form::text('triple', '', array('class' => 'form-control',  'autocomplete'=>'off','placeholder'=>'Tripple Price', 'onkeypress'=>'return isNumberKey(event)' )) }}							
							</div>
						</div>
					<div class="form-group row"> 
							<label for="single" class="col-sm-3 col-form-label">Single</label>
							<div class="col-sm-9">
							{{ Form::text('single', '', array('class' => 'form-control', 'autocomplete'=>'off','placeholder'=>'single', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
					  </div>
					  
					  <div class="form-group row"> 
							<label for="child_with_bed" class="col-sm-3 col-form-label">Child with Bed (below 12 years)</label>
							<div class="col-sm-9">
							{{ Form::text('child_with_bed', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Child with Bed (below 12 years)', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
					  </div>
					  <div class="form-group row"> 
							<label for="child_without_bedbelow12" class="col-sm-3 col-form-label">Child without Bed (below 12 years)</label>
							<div class="col-sm-9">
							{{ Form::text('child_without_bedbelow12', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Child without Bed (below 12 years)', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
					  </div>
					  <div class="form-group row"> 
							<label for="child_without_bedbelow26" class="col-sm-3 col-form-label">Child without Bed (below 2-6 years)</label>
							<div class="col-sm-9">
							{{ Form::text('child_without_bedbelow26', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Child without Bed (below 2-6 years)', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
					  </div>
					  <div class="form-group row"> 
							<label for="infant" class="col-sm-3 col-form-label">Infant</label>
							<div class="col-sm-9">
							{{ Form::text('infant', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Infant', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
					  </div>
					  <div class="form-group row"> 
							<label for="adult_flight" class="col-sm-3 col-form-label">Adult (Flight Only)</label>
							<div class="col-sm-9">
							{{ Form::text('adult_flight', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Adult (Flight Only)', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
					  </div>
					  <div class="form-group row"> 
							<label for="child_flight" class="col-sm-3 col-form-label">Child (Flight Only)</label>
							<div class="col-sm-9">
							{{ Form::text('child_flight', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Child (Flight Only)', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
					  </div>
					  <div class="form-group row"> 
							<label for="infant_flight" class="col-sm-3 col-form-label">Infant (Flight Only)</label>
							<div class="col-sm-9">
							{{ Form::text('infant_flight', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Infant (Flight Only)', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
					  </div>
					  <div class="form-group row">
							<label for="price_type" class="col-sm-3 col-form-label">Price Type</label>
							<div class="col-sm-9">
							<select class="form-control price_type" name="price_type">
								<option value="Per Person">Per Person</option>
								<option value="Twin Sharing">Twin Sharing</option>
								<option value="Triple Sharing">Triple Sharing</option>
							</select>
						  </div>
					 </div>
					 <div class="form-group row">
						<label for="booking_amt" class="col-sm-3 col-form-label">Booking Amount</label>
							<div class="col-sm-3">
								<input type="text" onkeypress='return isNumberKey(event)' class="form-control" name="booking_amt">
							</div>
							<div class="col-sm-3">
								<select class="form-control dis_type" name="dis_type">
									<option value="Percentage">Percentage</option>
									<option value="Fixed">Fixed</option>
								</select>
							</div>
					</div>
					  <div class="form-group row">
							<label for="balance_rec" class="col-sm-3 col-form-label">Balance Receiving Day</label>
							<div class="col-sm-9">
							<select class="form-control balance_rec" name="balance_rec">
								<option value=""></option>
								<?php for($i = 1; $i<=21; $i++){ ?>
								<option value="{{$i}}">{{$i}}</option>
								<?php } ?>
							</select>
								
							</div>
					  </div> 
					  
					  <div class="form-group row">
							<label for="balance_rec" class="col-sm-3 col-form-label"></label>
							<div class="col-sm-9">
								<label><input checked type="radio" name="flight_type" class="flighttyp" value="0"> Same Flight</label>
								<label><input type="radio" name="flight_type" class="flighttyp" value="1"> Add Flight</label>
							</div>
					  </div>
					  <div class="if_diffrent_flight" style="display:none;">
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group row">
										<label for="flightname" class="col-sm-3 col-form-label">Flight Name</label>
										<div class="col-sm-9">
											{{ Form::text('flightname', '', array('class' => 'form-control ', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Flight Name', 'onkeypress'=>'' )) }}
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group row">
										<label for="dep_city" class="col-sm-3 col-form-label">Departure City</label>
										<div class="col-sm-9">
											{{ Form::text('dep_city', '', array('class' => 'form-control ', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Departure City', 'onkeypress'=>'' )) }}
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group row">
										<label for="arv_city" class="col-sm-3 col-form-label">Arrival City</label>
										<div class="col-sm-9">
											{{ Form::text('arv_city', '', array('class' => 'form-control ', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Arrival City', 'onkeypress'=>'' )) }}
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group row">
										<label for="dep_time" class="col-sm-3 col-form-label">Departure Time</label>
										<div class="col-sm-9">
											{{ Form::text('dep_time', '', array('class' => 'form-control ', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Departure Time', 'onkeypress'=>'' )) }}
										</div>
									</div> 
								</div>
								<div class="col-sm-4">
									<div class="form-group row">
										<label for="arv_time" class="col-sm-3 col-form-label">Arrival Time</label>
										<div class="col-sm-9">
											{{ Form::text('arv_time', '', array('class' => 'form-control ', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Arrival Time', 'onkeypress'=>'' )) }}
										</div>
									</div>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
		<div class="modal-footer justify-content-between">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  <button type="button" id="save_price" class="btn btn-primary">Save</button>
		  <button type="button" id="update_price" style="display:none" class="btn btn-primary">Update</button>
		</div>
		</form>
	</div>
</div>
</div>
@endsection