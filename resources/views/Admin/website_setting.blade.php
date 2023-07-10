@extends('layouts.admin')
@section('title', 'Settings')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Api Key</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Settings</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<section class="content website_setting custom_setting">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<!-- Flash Message Start -->
					<div class="server-error">
						@include('../Elements/flash-message')
					</div>
					<!-- Flash Message End -->
				</div>
				<div class="col-md-6">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Settings</h3>
						</div>
					 	{{ Form::open(array('url' => 'admin/website_setting', 'name'=>"website-setting", 'enctype'=>'multipart/form-data', 'autocomplete'=>'off')) }}
							{{ Form::hidden('id', @$fetchedData->id) }}
							<div class="card-body">	
								<h4>Disable Ticket</h4>
								<div class="form-group form_label">
									<label style="margin-right:10px;"><input type="radio" <?php if($fetchedData->disable_booking == 1){ echo 'checked'; } ?> value="1" name="disable_booking" > Disable</label>
									<label><input type="radio" <?php if($fetchedData->disable_booking == 0){ echo 'checked'; } ?> value="0" name="disable_booking" > Enable</label>
						        </div>
								<div class="form-group">
									{{ Form::submit('Save', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("website-setting")' ]) }}
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