@extends('layouts.admin')
@section('title', 'Edit Manage Holiday Type')

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
						<h3 class="card-title">Edit Manage Holiday Type</h3>
					  </div> 
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/holidaytype/edit', 'name'=>"edit-holidaytype", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
					  @if(!empty($fetchedData->holidaytype))
					   {{ Form::hidden('id', @$fetchedData->id) }}
				   {{ Form::hidden('typeinid', @$fetchedData->holidaytype->id) }}
				   @else
					   {{ Form::hidden('id', @$fetchedData->id) }}
				   @endif
						<div class="card-body">
							<div class="form-group" style="text-align:right;">
								<a style="margin-right:5px;" href="{{route('admin.manageholidaytype.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>  
								{{ Form::button('<i class="fa fa-edit"></i> Update Holiday Type', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-holidaytype")' ]) }}
							</div>
							<div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Name <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
								{{ Form::text('name', @$fetchedData->name, array('class' => 'form-control', 'data-valid'=>'required','disabled'=>'disabled', 'autocomplete'=>'off','placeholder'=>'Enter Package Name' )) }}
								@if ($errors->has('name'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('name') }}</strong>
									</span> 
								@endif
								</div>
						  </div>
						   <div class="form-group row">
								<label for="description" class="col-sm-2 col-form-label">Description <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
									<textarea name="description" data-valid="required" value="" class="textarea" placeholder="Please Add Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{@$fetchedData->holidaytype->description}}</textarea>
									@if ($errors->has('description'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('description') }}</strong>
										</span> 
									@endif
								</div>
						  </div>
						  @if(!empty($fetchedData->holidaytype))
						  <div class="form-group row"> 
								<label for="image" class="col-sm-2 col-form-label">Image</label>
								<div class="col-sm-10">
									<input type="hidden" id="old_image" name="old_image" value="{{@$fetchedData->holidaytype->image}}" />
									
									<input type="file" name="image" class="form-control" autocomplete="off"  />
									
									<div class="show-uploded-img">	
									@if(@$fetchedData->holidaytype->image != '')
										<img width="70" src="{{URL::to('/public/img/themes_img')}}/{{@$fetchedData->holidaytype->image}}" class="img-avatar"/>
									@else
										<img width="70" src="{{URL::to('/public/img/themes_img')}}/{{@$fetchedData->image}}" class="img-avatar"/>
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
										<img width="70" src="{{URL::to('/public/img/themes_img')}}/{{@$fetchedData->image}}" class="img-avatar"/>
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
								<label for="banner_image" class="col-sm-2 col-form-label">Banner Image</label>
								<div class="col-sm-10">
								<input type="hidden" id="banner_old_image" name="banner_old_image" value="{{@$fetchedData->holidaytype->image}}" />
									<input type="file" name="banner_image" class="form-control" autocomplete="off"  />
									
									<div class="show-uploded-img">	
									@if(@$fetchedData->holidaytype->banner_image != '')
										<img width="70" src="{{URL::to('/public/img/themes_img')}}/{{@$fetchedData->holidaytype->banner_image}}" class="img-avatar"/>
									@endif
									@if ($errors->has('banner_image'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('banner_image') }}</strong>
										</span> 
									@endif
								</div>  
							</div>
						  </div>
						  <?php //echo '<pre>'; print_r($fetchedData); ?>
						<div class="form-group row">
								<label for="status" class="col-sm-2 col-form-label">Status</label> 
								<div class="col-sm-10">
								@if(!empty($fetchedData->holidaytype))
									<input value="1" type="checkbox" name="status" {{ (@$fetchedData->holidaytype->status == 1 ? 'checked' : '')}} data-bootstrap-switch>
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
							{{ Form::button('<i class="fa fa-edit"></i> Update Holiday Type', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-holidaytype")' ]) }}
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