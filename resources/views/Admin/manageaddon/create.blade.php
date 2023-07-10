@extends('layouts.admin')
@section('title', 'New Manage Addon')

@section('content')
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
					<h1 class="m-0 text-dark">Manage Addon</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Manage Addon</li>
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
						<h3 class="card-title">New Manage Addon</h3>
					  </div>
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/addons/store', 'name'=>"add-destination", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
						<div class="card-body">
							<div class="form-group" style="text-align:right;">
								<a style="margin-right:5px;" href="{{route('admin.manageaddon.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a> 
								{{ Form::button('<i class="fa fa-save"></i> Save Addon', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-destination")' ]) }}
							</div> 	
							<div class="form-group row">
							<label for="title" class="col-sm-2 col-form-label">Title </label>
							<div class="col-sm-10">
								{{ Form::text('title', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'' )) }}
							</div>
						  </div>
						  {{-- <div class="form-group row">  
								<label for="dest_type" class="col-sm-2 col-form-label">Dest. Type <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
									<select onChange="getLocations()" name="dest_type" id="dest_type" class="form-control" autocomplete="new-password" data-valid="required">
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
									<select name="destination" data-valid="required" id="destination" class="form-control" autocomplete="new-password">
										<option value="">-- Select Destination --</option>
										
									</select>
									@if ($errors->has('destination'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('destination') }}</strong>
										</span> 
									@endif
								</div>
						  </div> --}}						  
						 
						  <div class="form-group row">
							<label for="price" class="col-sm-2 col-form-label">Adult Price <span style="color:#ff0000;">*</span></label>
							<div class="col-sm-10">
								{{ Form::text('price', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
						  </div>
						  <div class="form-group row">
							<label for="child_price3" class="col-sm-2 col-form-label">Child Price (3-12)</label>
							<div class="col-sm-10">
								{{ Form::text('child_price3', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
						  </div>
						  <div class="form-group row">
							<label for="child_price2" class="col-sm-2 col-form-label">Child Price (2-4)</label>
							<div class="col-sm-10">
								{{ Form::text('child_price2', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
						  </div>
						   <div class="form-group row">
							<label for="infant_price" class="col-sm-2 col-form-label">Infant Price (0-2)</label>
							<div class="col-sm-10">
								{{ Form::text('infant_price', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'', 'onkeypress'=>'return isNumberKey(event)' )) }}
							</div>
						  </div>
						
						  <div class="form-group row">
							<label for="duration" class="col-sm-2 col-form-label">Duration </label>
							<div class="col-sm-10">
								{{ Form::text('duration', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'' )) }}
							</div>
						  </div>
						  <div class="form-group row">
								<label for="description" class="col-sm-2 col-form-label">Description <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
									<textarea name="description" data-valid="required" class="textarea" placeholder="Please Add Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
									@if ($errors->has('description'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('description') }}</strong>
										</span> 
									@endif
								</div>
						  </div>
						  
						
						  
						   
						  <div class="form-group float-right">
							{{ Form::button('<i class="fa fa-save"></i> Save Addon', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-destination")' ]) }}
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