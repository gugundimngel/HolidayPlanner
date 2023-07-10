@extends('layouts.admin')
@section('title', 'Edit User Role')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Edit User Role</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit User Role</li>
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
				<div class="col-md-6">
					<div class="card card-primary">
					  <div class="card-header">
						<h3 class="card-title">Edit User Role</h3>
					  </div>
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/userrole/edit', 'name'=>"edit-userrole", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
					  {{ Form::hidden('id', @$fetchedData->id) }}
						<div class="card-body">	
						  <div class="form-group">
							<label for="usertype">User Role Type</label>
							<select name="usertype" id="usertype" class="form-control" autocomplete="new-password">
								<option value="">Choose One...</option>
								@if(count(@$usertype) !== 0)
									@foreach (@$usertype as $ut)
										<option value="{{ @$ut->id }}" @if(@$fetchedData->usertype == $ut->id) selected  @endif  >{{ @$ut->name }}</option>
									@endforeach
								@endif		
							</select>							
							@if ($errors->has('usertype'))
								<span class="custom-error" role="alert">
									<strong>{{ @$errors->first('usertype') }}</strong>
								</span> 
							@endif
						  </div>
						  <?php $module_access = json_decode($fetchedData->module_access);?>
						  <div class="form-group">
							<div class="custom-control custom-checkbox">
							  <input class="custom-control-input" type="checkbox" name="module_access[]" <?php if(in_array('user_management',  $module_access)) { echo "checked"; }?> id="user_management" value="user_management"> 
							  <label for="user_management" class="custom-control-label">User Management</label>
							</div>  
							<!--<div class="inner_checkbox">
								<div class="custom-control custom-checkbox">
								  <input class="custom-control-input" type="checkbox" id="adduser" checked>
								  <label for="adduser" class="custom-control-label">Add User</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input class="custom-control-input" type="checkbox" id="edituser">
								  <label for="edituser" class="custom-control-label">Edit User</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input class="custom-control-input" type="checkbox" id="deleteuser">
								  <label for="deleteuser" class="custom-control-label">Delete User</label>
								</div>
							</div>-->
						  </div>
						  <div class="form-group">
							<div class="custom-control custom-checkbox">
							  <input class="custom-control-input" type="checkbox" name="module_access[]" id="user_role" <?php if(in_array('user_role', $module_access)) { echo "checked"; } ?> value="user_role">
							  <label for="user_role" class="custom-control-label">User Role</label>
							</div>
						  </div>
						  <div class="form-group">
							<div class="custom-control custom-checkbox">
							  <input class="custom-control-input" type="checkbox" name="module_access[]" id="holiday_package" <?php if( in_array('holiday_package', $module_access)) { echo "checked"; } ?> value="holiday_package">
							  <label for="holiday_package" class="custom-control-label">Holiday Package</label>
							</div>
						  </div>
						  <div class="form-group">
							<div class="custom-control custom-checkbox">
							  <input class="custom-control-input" type="checkbox" name="module_access[]" id="lead_management" <?php if(in_array('lead_management', $module_access)) { echo "checked"; } ?> value="lead_management">
							  <label for="lead_management" class="custom-control-label">Lead Management</label>
							</div>
							<div class="inner_checkbox">
								<div class="custom-control custom-checkbox">
								  <input class="custom-control-input" type="checkbox" <?php if(in_array('add_lead', $module_access)) { echo "checked"; } ?> id="adduser" name="module_access[]" value="add_lead">
								  <label for="adduser" class="custom-control-label">Add Lead</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input class="custom-control-input" type="checkbox" <?php if(in_array('edit_lead', $module_access)) { echo "checked"; } ?> id="edituser" name="module_access[]" value="edit_lead">
								  <label for="edituser" class="custom-control-label">Edit Lead</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input class="custom-control-input" type="checkbox" <?php if(in_array('lead_history', $module_access)) { echo "checked"; } ?> id="deleteuser" name="module_access[]" value="lead_history">
								  <label for="deleteuser" class="custom-control-label">Lead History</label>
								</div>
								
							</div>
						  </div>
						  <div class="form-group">
							<div class="custom-control custom-checkbox">
							  <input class="custom-control-input" type="checkbox" name="module_access[]" id="invoices" <?php if(in_array('invoices', $module_access)) { echo "checked"; } ?> value="invoices">
							  <label for="invoices" class="custom-control-label">Invoices</label>
							</div>
						  </div>
						  <div class="form-group">
							<div class="custom-control custom-checkbox">
							  <input class="custom-control-input" type="checkbox" name="module_access[]" id="contacts" <?php if(in_array('contacts', $module_access)) { echo "checked"; } ?> value="contacts">
							  <label for="contacts" class="custom-control-label">Contacts</label>
							</div>
						  </div>
						  <div class="form-group">
							<div class="custom-control custom-checkbox">
							  <input class="custom-control-input" type="checkbox" name="module_access[]" id="staff" value="staff" <?php if(in_array('staff', $module_access)) { echo "checked"; } ?>>
							  <label for="staff" class="custom-control-label">Staff</label>
							</div>
						  </div>
						  <div class="form-group">
							<div class="custom-control custom-checkbox">
							  <input class="custom-control-input" type="checkbox" <?php if(in_array('cmspages', $module_access)) { echo "checked"; } ?> name="module_access[]" id="cmspages" value="cmspages" >
							  <label for="cmspages" class="custom-control-label">Page</label>
							</div>
						  </div>
						  <div class="form-group">
							<div class="custom-control custom-checkbox">
							  <input class="custom-control-input" type="checkbox" name="module_access[]" id="api_key" value="api_key" <?php if(in_array('api_key', $module_access)) { echo "checked"; } ?>>
							  <label for="api_key" class="custom-control-label">Api</label>
							</div>
						  </div>
						  <div class="form-group">
							{{ Form::submit('Save', ['class'=>'btn btn-primary' ]) }}
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