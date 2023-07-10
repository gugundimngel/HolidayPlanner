@extends('layouts.admin')
@section('title', 'Edit Offer')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6 wd50_xs">
					<h1 class="m-0 text-dark">Edit Offer</h1>
				</div><!-- /.col -->
				<div class="col-sm-6 wd50_xs">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit Offer</li>
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
						<h3 class="card-title">Edit Offer</h3>
					  </div> 

					  <!-- /.card-header -->

					  <!-- form start -->

					  {{ Form::open(array('url' => 'admin/agent-offers/edit', 'name'=>"edit-offer", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
					    {{ Form::hidden('id', @$fetchedData->id) }}
						<div class="card-body">
							<div class="form-group" style="text-align:right;">
								
								{{ Form::button('<i class="fa fa-save"></i> Update', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-offer")' ]) }}
							</div>
							<div class="form-group row"> 
								<label for="offer_type" class="col-sm-2 col-form-label">Offer Type <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
									<select class="form-control" name="offer_type" data-valid="required">
										<option value="" >-- Select Offer Type --</option>
										<option value="Flight" @if($fetchedData->offer_type == "Flight") selected @endif>Flight</option>
										<option value="Hotel" @if($fetchedData->offer_type == "Hotel") selected @endif>Hotel</option>
										<option value="Bus" @if($fetchedData->offer_type == "Bus") selected @endif>Bus</option>
										<option value="Holiday" @if($fetchedData->offer_type == "Holiday") selected @endif>Holiday</option>
										<option value="Recharge" @if($fetchedData->offer_type == "Recharge") selected @endif>Recharge</option>
										<option value="BBPS" @if($fetchedData->offer_type == "BBPS") selected @endif>BBPS</option> 
										<option value="Dashboard" @if($fetchedData->offer_type == "Dashboard") selected @endif>Dashboard</option>
										<option value="Agent Login Slider" @if($fetchedData->offer_type == "Agent Login Slider") selected @endif>Agent Login Slider</option>
									</select>
									@if ($errors->has('offer_type'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('offer_type') }}</strong>
										</span> 
									@endif
								</div>
							</div>	
							<div class="form-group row"> 
								<label for="type" class="col-sm-2 col-form-label">Type <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
									<select class="form-control" name="type" data-valid="required">
										<option value="" >-- Select Type --</option>
										<option value="B2B" @if($fetchedData->type == "B2B") selected @endif>B2B</option>
										<option value="B2C" @if($fetchedData->type == "B2C") selected @endif>B2C</option>
									</select>
									@if ($errors->has('type'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('type') }}</strong>
										</span> 
									@endif
								</div>
							</div>
							<div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Name <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
								{{ Form::text('name', @$fetchedData->name, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Name' )) }}
								@if ($errors->has('name'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('name') }}</strong>
									</span> 
								@endif
								</div>
							</div>
							<div class="form-group row"> 
								<label for="image" class="col-sm-2 col-form-label">Image</label> 
								<div class="col-sm-10">
									<input type="file" name="image" class="form-control" autocomplete="off"  />
									<input type="hidden" id="old_image" name="old_image" value="{{@$fetchedData->image}}" />
									<div class="show-uploded-img">	
										@if(@$fetchedData->image != '')
										<img width="70" src="{{URL::to('/public/img/cmspage')}}/{{@$fetchedData->image}}" class="img-avatar"/>
									@endif
									</div>
									@if ($errors->has('image'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('image') }}</strong>
										</span> 
									@endif
									<span class="span_note">Please Add Image Size: 300/120</span>
								</div>
							</div>
							<div class="form-group row"> 
								<label for="url" class="col-sm-2 col-form-label">Url</label>
								<div class="col-sm-10">
									{{ Form::text('url', @$fetchedData->url, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Url' )) }} 
									@if ($errors->has('url'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('url') }}</strong>
										</span> 
									@endif
								</div>
							</div>
							<div class="form-group row"> 
								<label for="price" class="col-sm-2 col-form-label">Price</label>
								<div class="col-sm-10">
								{{ Form::text('price', @$fetchedData->price, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Price' )) }}
								@if ($errors->has('price'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('price') }}</strong>
									</span> 
								@endif
								</div>
							</div>
							<div class="form-group row"> 
								<label for="description" class="col-sm-2 col-form-label">Description </label>
								<div class="col-sm-10">
									<textarea name="description" class="form-control" placeholder="Description" style="width: 100%; height:80px;padding: 10px;margin-bottom:10px;">{{@$fetchedData->description}}</textarea>
									@if ($errors->has('description'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('description') }}</strong>
										</span> 
									@endif
								</div>
							</div>
							<div class="form-group float-right">
								{{ Form::button('<i class="fa fa-save"></i> Update', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-offer")' ]) }}
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