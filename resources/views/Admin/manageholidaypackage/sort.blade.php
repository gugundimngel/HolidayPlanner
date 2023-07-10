@extends('layouts.admin')
@section('title', 'Sort Holiday Package')

@section('content')
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>
  #sortable { list-style-type: none;margin: 0; padding: 0;  }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em;}
  
  </style>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Sort Holiday Package</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Sort Holiday Package</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<!-- Flash Message Start -->
					<div class="server-error"> 
						@include('../Elements/flash-message')
					</div>
					<div class="custom-error-msg">
				</div>
					<!-- Flash Message End -->
				</div>
				<div class="col-md-12">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Sort Holiday Package</h3>
						</div> 
						<div class="card-body">
						
						{{ Form::open(array('url' => 'admin/add-sort', 'name'=>"add-sort", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
						
						<div class="form-group" style="text-align:right;">
								<a style="margin-right:5px;" href="{{route('admin.manageholidaypackage.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>  
								{{ Form::button('<i class="fa fa-save"></i> Save', ['class'=>'btn btn-primary', 'id' => 'savebtn', 'onClick'=>'customValidate("add-sort")' ]) }}
							</div>
						<div class="col-md-6">
						<div class="form-group row">
								<label for="dest_type" class="col-sm-2 col-form-label">Type</label>
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
								<label for="destination"  class="col-sm-2 col-form-label">Destination </label>
								<div class="col-sm-10">
									<select name="destination" onChange="getPackages()" data-valid ="required" id="destination" class="form-control" autocomplete="new-password">
										<option value="">Choose One...</option>
									</select>							
									@if ($errors->has('destination'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('destination') }}</strong>
										</span> 
									@endif
							   </div>	
						  </div>
						<div id="sortabledata">
						
						</div>
						</div>
						<div class="package_full_form" style="text-align: right;">
							  <div class="form-group">
								{{ Form::button('<i class="fa fa-save"></i> Save', ['class'=>'btn btn-primary', 'id' => 'savebtn', 'onClick'=>'customValidate("add-sort")' ]) }}
							  </div> 
							 </div> 
						{{ Form::close() }}
						</div>
					</div>
				</div> 
			</div>
		</div>
	</section>
</div>
@endsection