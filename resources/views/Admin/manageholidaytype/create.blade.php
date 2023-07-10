@extends('layouts.admin')
@section('title', 'New Manage Holiday Type')

@section('content')
 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Manage Holiday Type</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Manage Holiday Type</li>
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
						<h3 class="card-title">New Manage Holiday Type</h3>
					  </div>  
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/holidaytype/store', 'name'=>"add-holidaytype", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
						<div class="card-body">
							<div class="form-group" style="text-align:right;">
								<a style="margin-right:5px;" href="{{route('admin.manageholidaytype.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>  
								{{ Form::button('<i class="fa fa-save"></i> Save Holiday Type', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-holidaytype")' ]) }}
							</div>
							<div class="form-group row">   
								<label for="name" class="col-sm-2 col-form-label">Package Name <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
								{{ Form::text('name', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Package Name' )) }}
								@if ($errors->has('name'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('name') }}</strong>
									</span> 
								@endif
								</div>
						  </div>
						  <div class="form-group row">
								<label for="status" class="col-sm-2 col-form-label">Description</label> 
								<div class="col-sm-10">
									<textarea class="form-control" name="description"></textarea>
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
							{{ Form::button('<i class="fa fa-save"></i> Save Holiday Type', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-holidaytype")' ]) }}
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