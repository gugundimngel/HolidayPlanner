@extends('layouts.admin')
@section('title', 'New Gallery')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Gallery</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Gallery</li>
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
						<h3 class="card-title">New Gallery</h3>
					  </div>
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/gallery/store', 'name'=>"add-gallery", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
						<div class="card-body">
							<div class="form-group" style="text-align:right;">
								<a style="margin-right:5px;" href="{{route('admin.managegallery.index')}}" class="btn btn-primary">Back</a>  
								{{ Form::button('Save', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-gallery")' ]) }}
							</div>
							<div class="form-group row"> 
								<label for="gallery_name" class="col-sm-2 col-form-label">Gallery Name</label>
								<div class="col-sm-10">
								{{ Form::text('gallery_name', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Gallery Name' )) }}
								@if ($errors->has('gallery_name'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('gallery_name') }}</strong>
									</span> 
								@endif
								</div>
						  </div>
						  <div class="form-group row">
								<label for="gallery" class="col-sm-2 col-form-label">Gallery Image</label>
								<div class="col-sm-10">
									<input type="file" name="gallery" class="form-control" autocomplete="off" data-valid="required" />
									@if ($errors->has('gallery'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('gallery') }}</strong>
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
						  <div class="form-group">
							{{ Form::button('Save', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-gallery")' ]) }}
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