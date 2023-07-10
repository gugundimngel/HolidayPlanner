@extends('layouts.admin')
@section('title', 'Manage Holiday Type')

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
					<div class="custom-error-msg">
				</div>
					<!-- Flash Message End -->
				</div> 
				<div class="col-md-12">
					<div class="card"> 
						<div class="card-header">   
							<div class="card-title">
								<!--<a href="{{route('admin.manageholidaytype.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Holiday Type</a>-->
								
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
										<a href="javascript:;" data-toggle="modal" data-target="#amnetsearch_modal" class="btn btn-primary"><i class="fas fa-search"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body table-responsive">
							<table id="hoteltable" class="table table-bordered table-hover text-nowrap">
							  <thead>
								<tr>
								  <th>ID</th>
								  <th>Name</th>
								  <th>Image</th>
								 <th class="no-sort">Is Active</th>
								  <th class="no-sort">Action</th>
								</tr> 
							  </thead>
							   <tbody class="tdata">   				   
								@if(@$totalData !== 0)
								@foreach (@$lists as $list)	
							<?php //echo '<pre>'; print_r($list); ?>
								<tr id="id_{{@$list->id}}"> 
								  <td>{{ @$list->id == "" ? config('constants.empty') : str_limit(@$list->id, '50', '...') }}</td> 
								  <td>{{ @$list->name == "" ? config('constants.empty') : str_limit(@$list->name, '50', '...') }}</td>
								  @if(!empty($list->holidaytype))
									@if(@$list->holidaytype->image != '')
										<td><img width="30" src="{{URL::to('/public/img/themes_img')}}/{{@$list->holidaytype->image}}" class="img-avatar"/></td>
									@else
										<td><img width="30" src="{{URL::to('/public/img/themes_img')}}/{{@$list->image}}" class="img-avatar"/></td>
									@endif
								@else
								 <td><img width="30" src="{{URL::to('/public/img/themes_img')}}/{{@$list->image}}" class="img-avatar"/></td>
								 @endif
								@if(!empty($list->holidaytype))
									<td><input class="change-status-type" data-id="{{@$list->id}}"  data-status="{{@$list->holidaytype->status}}" data-col="status" data-table="holidaytypes" value="1" type="checkbox" name="status" {{ (@$list->holidaytype->status == 1 ? 'checked' : '')}} data-bootstrap-switch></td> 
								@else
									<td><input class="change-status-type" data-id="{{@$list->id}}"  data-status="1" data-col="status" data-table="holidaytypes" value="1" type="checkbox" name="status" checked data-bootstrap-switch></td> 
								@endif
 
								  <td>
									<div class="nav-item dropdown action_dropdown">
										<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
										<div class="dropdown-menu">
											<a href="{{URL::to('/admin/holidaytype/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-edit"></i> Edit</a>
											
										</div>
									</div>
								  </td>
								</tr>	
								@endforeach						
							  </tbody>
							  @else
							  <tbody>
									<tr>
										<td style="text-align:center;" colspan="5">
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
<div class="modal fade" id="amnetsearch_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				  <h4 class="modal-title">Exclusion Search</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
			</div>
			<form action="{{route('admin.manageholidaytype.index')}}" method="get">
				<div class="modal-body"> 
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="type" class="col-sm-2 col-form-label">ID</label>
								<div class="col-sm-10">
									{{ Form::text('type', Request::get('type'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'ID', 'id' => 'type' )) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="name" class="col-sm-2 col-form-label">Name</label>
								<div class="col-sm-10">
									{{ Form::text('name', Request::get('name'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Destination Name', 'id' => 'name' )) }}
								</div>
							</div>
						</div>
						
					</div>
				</div>
				<div class="modal-footer justify-content-between">
				  <a href="{{route('admin.manageholidaytype.index')}}" class="btn btn-default" >Reset</a>
				  <button type="submit" id="" class="btn btn-primary">Search</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection