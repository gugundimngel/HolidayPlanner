@extends('layouts.admin')
@section('title', 'Manage Destination')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Manage Destination</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Manage Destination</li>
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
					<div class="card">
						<div class="card-header">  
							<div class="card-title">
								<a href="{{route('admin.managedestination.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Destination</a>
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
										<a href="javascript:;" data-toggle="modal" data-target="#destsearch_modal" class="btn btn-primary"><i class="fas fa-search"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body table-responsive">
							<table id="destintable" class="table table-bordered table-hover text-nowrap">
							  <thead>
								<tr>
								  <th>ID</th>
								  <th>Dest. Name</th>
								  <th>Dest. Type Name</th>
								
								  <th>Is Active</th> 
								  <th class="no-sort">Action</th>
								</tr>  
							  </thead> 
							  <tbody class="tdata">	
								@if(@$totalData !== 0)
								@foreach (@$lists as $list)	
								<tr id="id_{{@$list->id}}"> 
								  <td>{{ @$list->id == "" ? config('constants.empty') : str_limit(@$list->id, '50', '...') }}</td> 
								  <td>{{ @$list->myloc->name == "" ? config('constants.empty') : str_limit(@$list->myloc->name, '50', '...') }}</td> 
								  <td>{{ @$list->dest_type == "" ? config('constants.empty') : str_limit(@$list->dest_type, '50', '...') }}</td> 
								 
								  <td><input data-id="{{@$list->id}}"  data-status="{{@$list->is_active}}" data-col="is_active" data-table="destinations" class="change-status" value="1" type="checkbox" name="is_active" {{ (@$list->is_active == 1 ? 'checked' : '')}} data-bootstrap-switch></td> 
								  <td>
									<div class="nav-item dropdown action_dropdown">
										<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
										<div class="dropdown-menu">
										  <a href="{{URL::to('/admin/destination/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-edit"></i> Edit</a>
										  <a href="javascript:;" onClick="deleteDesAction({{@$list->id}}, 'destinations')"><i class="fa fa-trash"></i> Delete</a>
										</div> 
									</div>								 
								  </td> 
								</tr>	
								@endforeach						
							  </tbody>
							  @else
							  <tbody>
									<tr>
										<td style="text-align:center;" colspan="6">
											No Record found
										</td>
									</tr>
								</tbody>
							@endif
							</table>
							<div class="card-footer hide">
							{{-- {!! $lists->appends(\Request::except('page'))->render() !!} --}}
							 </div>
						  </div>
					</div>	
				</div>	
			</div> 
		</div>
	</section>
</div>
<div class="modal fade" id="destsearch_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				  <h4 class="modal-title">Destination Search</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
			</div>
			<form action="{{route('admin.managedestination.index')}}" method="get">
				<div class="modal-body"> 
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="dest_id" class="col-sm-2 col-form-label">Destination ID</label>
								<div class="col-sm-10">
									{{ Form::text('dest_id', Request::get('dest_id'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Destination ID', 'id' => 'dest_id' )) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="name" class="col-sm-2 col-form-label">Destination Name</label>
								<div class="col-sm-10">
									{{ Form::text('name', Request::get('name'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Destination Name', 'id' => 'name' )) }}
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
				  <a href="{{route('admin.managedestination.index')}}" class="btn btn-default" >Reset</a>
				  <button type="submit" id="" class="btn btn-primary">Search</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection