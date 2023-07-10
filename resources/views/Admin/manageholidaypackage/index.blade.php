@extends('layouts.admin')
@section('title', 'Manage Holiday Package')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Manage Holiday Package</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Manage Holiday Package</li>
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
					<div class="custom-error-msg">
				</div>
					<!-- Flash Message End -->
				</div> 
				<div class="col-md-12">
					<div class="card"> 
						<div class="card-header">   
							<div class="card-title">
								<a href="{{route('admin.manageholidaypackage.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Holiday Package</a>
								<a href="{{route('admin.manageholidaypackage.sort')}}" class="btn btn-primary"><i class="fa fa-sort"></i> Sort Package</a>
								 <a style="display:none;" class="btn btn-primary displayifselected" href="javascript:;" onClick="deleteAllAction('packages')"><i class="fa fa-trash"></i> Delete</a>
								
							</div> 
							<div class="card-tools card_tools">
								<!--<div class="input-group input-group-sm" style="width: 150px;">
									<input type="text" name="table_search" class="form-control float-right" placeholder="Search">
									<div class="input-group-append">
										<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
									</div>
								</div>-->
								<div class="row">
									<div class="col-md-4">
										<a href="javascript:;" data-toggle="modal" data-target="#packagesearch_modal" class="btn btn-primary"><i class="fas fa-search"></i></a>
									</div>
								</div>
							</div> 
						</div>
						<div class="card-body table-responsive">
							<table id="holidaypackage_table" class="table table-bordered table-hover text-nowrap">
							  <thead>
								<tr>  
								  <th class="no-sort"><input type="checkbox" id="checkedAll"></th>
								  <th>ID</th>
								  <th>Package Name</th> 
								  <th>Destination</th>
								  <th class="no-sort">Nights</th>
								  <th class="no-sort">Days</th>
							
								  <th class="no-sort">Sale Price</th>
								  <th class="no-sort">Is Popular</th>
								  <th class="no-sort">Action</th>
								</tr> 
							  </thead>
							   <tbody class="tdata"> 	
								@if(@$totalData !== 0)
								@foreach (@$lists as $list)	
								<tr id="id_{{@$list->id}}"> 
								<td><input class="checkSingle" type="checkbox" name="allcheckbox" value="{{@$list->id}}"></td>
								  <td>{{ @$list->id == "" ? config('constants.empty') : str_limit(@$list->id, '50', '...') }}</td> 
								  <td>{{ @$list->package_name == "" ? config('constants.empty') : str_limit(@$list->package_name, '50', '...') }}</td> 
								  <td>
								  <?php
								 $des =  \App\Location::where('id', @$list->destination)->first();
								  ?>
								  {{ @$des->name == "" ? config('constants.empty') : str_limit(@$des->name, '50', '...') }}</td> 								 
								  <td>{{ @$list->no_of_nights == "" ? config('constants.empty') : str_limit(@$list->no_of_nights, '50', '...') }}</td>
								  <td>{{ @$list->no_of_days == "" ? config('constants.empty') : str_limit(@$list->no_of_days, '50', '...') }}</td> 								 
								
								  <td>{{ @$list->sales_price == "" ? config('constants.empty') : str_limit(@$list->sales_price, '50', '...') }}</td> 
											
								   <td><input data-id="{{@$list->id}}"  data-status="{{@$list->is_popular}}" data-col="is_popular" data-table="packages" class="change-status" value="1" type="checkbox" name="is_popular" {{ (@$list->is_popular == 1 ? 'checked' : '')}} data-bootstrap-switch></td> 	
								  <td>
									<div class="nav-item dropdown action_dropdown">
										<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
										<div class="dropdown-menu">
										 <a href="{{URL::to('/admin/holidaypackage/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-edit"></i> Edit</a>
										 <a href="{{URL::to('/admin/holidaypackage/duplicate/'.base64_encode(convert_uuencode(@$list->id)))}}" ><i class="fa fa-clone"></i> Clone</a>
										 
										</div> 
									</div>								   
								  </td>
								</tr>	
								@endforeach						
							  </tbody>
							  @else
							  
							@endif 
							</table>
							<div class="card-footer hide">
							 
							 </div>
						  </div>
					</div>	
				</div>	 
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="packagesearch_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				  <h4 class="modal-title">Package Search</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
			</div>
			<form action="{{route('admin.manageholidaypackage.index')}}" method="get">
				<div class="modal-body"> 
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="package_id" class="col-sm-2 col-form-label">Package ID</label>
								<div class="col-sm-10">
									{{ Form::text('package_id', Request::get('package_id'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Package ID', 'id' => 'package_id' )) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="name" class="col-sm-2 col-form-label">Package Name</label>
								<div class="col-sm-10">
									{{ Form::text('name', Request::get('name'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Package Name', 'id' => 'name' )) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="name" class="col-sm-2 col-form-label">Destination Type</label>
								<div class="col-sm-10">
								<?php
									$desttype = Request::get('dest_type');
								?>
									<select class="form-control" name="dest_type">
										<option value="">Select</option>
										<option value="domestic" @if($desttype == 'domestic') selected @endif>Domestic</option>
										<option value="international" @if($desttype == 'international') selected @endif>International</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
				  <a href="{{route('admin.manageholidaypackage.index')}}" class="btn btn-default" >Reset</a>
				  <button type="submit" id="" class="btn btn-primary">Search</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection