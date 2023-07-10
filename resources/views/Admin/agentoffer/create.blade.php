@extends('layouts.admin')
@section('title', 'Create Offer')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6 wd50_xs"> 
					<h1 class="m-0 text-dark">Create Offer</h1>
				</div>
				<div class="col-sm-6 wd50_xs">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Create Offer</li>
					</ol>
				</div>
			</div>
		</div>
	</div>

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
							<h3 class="card-title">Create Offer</h3>
						</div> 
						
						{{ Form::open(array('url' => 'admin/agent-offers/store', 'name'=>"add-offer", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}	
						
						<div class="card-body">
							<div class="form-group" style="text-align:right;">
								
								{{ Form::button('<i class="fa fa-save"></i> Save Offer', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-offer")' ]) }}
							</div>
							<div class="form-group row"> 
								<label for="offer_type" class="col-sm-2 col-form-label">Offer Type <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
									<select class="form-control" name="offer_type" data-valid="required">
										<option value="" >-- Select Offer Type --</option>
										<option value="Flight">Flight</option>
										<option value="Hotel">Hotel</option>
										
										<option value="Holiday">Holiday</option>
										
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
										<option value="B2B">B2B</option>
										<option value="B2C">B2C</option>
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
									{{ Form::text('name', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Name' )) }}
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
									<input type="file" data-valid="required" name="image" class="form-control" autocomplete="off"  />
									@if ($errors->has('image'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('image') }}</strong>
									</span> 
									@endif
									<span class="span_note">Image size 700x370px</span>
								</div>
							</div>
							<div class="form-group row"> 
								<label for="url" class="col-sm-2 col-form-label">Url</label>
								<div class="col-sm-10">
									{{ Form::text('url', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Url' )) }} 
									@if ($errors->has('url'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('url') }}</strong>
										</span> 
									@endif
								</div>
							</div>
							<div class="form-group row"> 
								<label for="price" class="col-sm-2 col-form-label">Price </label>
								<div class="col-sm-10">
									{{ Form::text('price', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Price' )) }} 
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
									<textarea name="description" class="form-control" placeholder="Description" style="width: 100%; height:80px;padding: 10px;margin-bottom:10px;"></textarea>
									@if ($errors->has('description'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('description') }}</strong>
										</span> 
									@endif
								</div>
							</div>
							<div class="form-group float-right">
								{{ Form::button('<i class="fa fa-save"></i> Save Offer', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-offer")' ]) }}
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