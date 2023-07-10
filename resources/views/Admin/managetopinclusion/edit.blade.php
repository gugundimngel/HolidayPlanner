@extends('layouts.admin')
@section('title', 'Edit Manage Top Inclusion')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Manage Top Inclusion</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Manage Top Inclusion</li>
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
						<h3 class="card-title">Edit Manage Top Inclusion</h3>
					  </div> 
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/topinclusion/edit', 'name'=>"edit-topinclusion", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
					    @if(!empty($fetchedData->topinclusion))
					   {{ Form::hidden('id', @$fetchedData->id) }}
					   {{ Form::hidden('topinid', @$fetchedData->topinclusion->id) }}
				   @else
					   {{ Form::hidden('id', @$fetchedData->id) }}
				   @endif
						<div class="card-body">
							<div class="form-group" style="text-align:right;">
								<a style="margin-right:5px;" href="{{route('admin.managetopinclusion.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>  
								{{ Form::button('<i class="fa fa-edit"></i> Update Top Inclusion', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-topinclusion")' ]) }}
							</div>
							<div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Name <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
								{{ Form::text('name', @$fetchedData->name, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Inclusion Name' )) }}
								@if ($errors->has('name'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('name') }}</strong>
									</span> 
								@endif
								</div>
						  </div>
						  
						  @if(!empty($fetchedData->topinclusion))
						  <div class="form-group row"> 
								<label for="image" class="col-sm-2 col-form-label">Image</label>
								<div class="col-sm-10">
									<input type="hidden" id="old_image" name="old_image" value="{{@$fetchedData->topinclusion->image}}" />
									
									<input type="file" name="image" class="form-control" autocomplete="off"  />
									
									<div class="show-uploded-img">	
									@if(@$fetchedData->topinclusion->image != '')
										<img width="70" src="{{URL::to('/public/img/topinclusion_img')}}/{{@$fetchedData->topinclusion->image}}" class="img-avatar"/>
									@else
										<img width="70" src="{{URL::to('/public/img/topinclusion_img')}}/{{@$fetchedData->image}}" class="img-avatar"/>
									@endif
									@if ($errors->has('image'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('image') }}</strong>
										</span> 
									@endif
								</div>  
							</div>
						  </div>
						  @else
							   <div class="form-group row"> 
								<label for="image" class="col-sm-2 col-form-label">Image</label>
								<div class="col-sm-10">
									<input type="file" name="image" class="form-control" autocomplete="off"  />
									
									<div class="show-uploded-img">	
									@if(@$fetchedData->image != '')
										<img width="70" src="{{URL::to('/public/img/topinclusion_img')}}/{{@$fetchedData->image}}" class="img-avatar"/>
									@endif
									@if ($errors->has('image'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('image') }}</strong>
										</span> 
									@endif
								</div>  
							</div>
						  </div>
						@endif
						<div class="form-group row">
								<label for="status" class="col-sm-2 col-form-label">Status</label> 
								<div class="col-sm-10">
								@if(!empty($fetchedData->topinclusion))
									<input value="1" type="checkbox" name="status" {{ (@$fetchedData->topinclusion->status == 1 ? 'checked' : '')}} data-bootstrap-switch>
								@else
									<input value="1" type="checkbox" name="status" checked data-bootstrap-switch>
								@endif
									@if ($errors->has('status'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('status') }}</strong>
										</span> 
									@endif
								</div>
						  </div>
						  <div class="form-group float-right"> 
							{{ Form::button('<i class="fa fa-edit"></i> Update Top Inclusion', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-topinclusion")' ]) }}
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