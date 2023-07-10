@extends('layouts.admin')
@section('title', 'Manage Coupon')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Manage Coupon</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Manage Coupon</li>
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
								<a href="{{route('admin.coupon_code.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Coupon</a>
								<a style="display:none;" class="btn btn-primary displayifselected" href="javascript:;" onClick="deleteAllAction('coupons')"><i class="fas fa-trash"></i> Delete</a> 
							</div> 
							<div class="card-tools card_tools">
								<!--<div class="input-group input-group-sm" style="width: 150px;">
									<input type="text" name="table_search" class="form-control float-right" placeholder="Search">
									<div class="input-group-append">
										<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
									</div>
								</div>-->
								<div class="row">
									<!--<div class="col-md-4">
										<a href="javascript:;" data-toggle="modal" data-target="#amnetsearch_modal" class="btn btn-primary"><i class="fas fa-search"></i></a>
									</div>-->
								</div>
							</div>
						</div>
						<div class="card-body table-responsive">
							<table id="departurecity_table" class="table table-bordered table-hover text-nowrap"> 
							  <thead>
								<tr>
							
								  <th>Name</th>
								  <th>Coupon Code</th>
								  <th>Type</th>
								  <th>Status</th>
								 
								  <th>Discount</th>
								  <th>Start date</th>
								  <th>End date</th>
								  <th>No of Used Coupon</th>
								  <th class="no-sort">Action</th>
								</tr> 
							  </thead>
							  <tbody class="tdata">	
							
								@foreach (@$lists as $list)	
								<tr id="id_{{@$list->id}}">
									 <td>{{ @$list->coupon_name  }}</td>
								  <td>{{ @$list->coupon_code  }}</td>
								 
								  <td>{{ ucfirst(@$list->type)  }}</td>
								   <td><input data-id="{{@$list->id}}"  data-status="{{@$list->status}}" data-col="status" data-table="coupons" class="change-status" value="1" type="checkbox" name="is_active" {{ (@$list->status == 1 ? 'checked' : '')}} data-bootstrap-switch></td> 
								 
								  <td>{{ @$list->discount }}@if($list->discount_type == 'percentage') % @else $ @endif</td>
								  <td>{{ date('Y-m-d', strtotime(@$list->start_date)) }}</td>
								  <td>{{ date('Y-m-d', strtotime(@$list->end_date)) }}</td>
								  <td>{{ @$list->used_count }}</td>
								  <td>
								  
									<div class="nav-item dropdown action_dropdown">
										<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
										<div class="dropdown-menu">
											<a href="{{URL::to('/admin/coupon-code/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fas fa-edit"></i> Edit</a>
											
											<a href="javascript:;" onClick="deleteAction({{@$list->id}}, 'coupons')"><i class="fas fa-trash"></i> Delete</a>
											
										</div>
									</div>
									
								  </td>
								</tr>	 
								@endforeach						
							  </tbody>
							 
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
<div class="modal fade" id="amnetsearch_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				  <h4 class="modal-title">Top Inclusion Search</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
			</div>
			<form action="{{route('admin.cities.index')}}" method="get">
				<div class="modal-body"> 
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="cityid" class="col-sm-2 col-form-label">ID</label>
								<div class="col-sm-10">
									{{ Form::text('cityid', Request::get('cityid'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'ID', 'id' => 'cityid' )) }}
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
				  <a href="{{route('admin.cities.index')}}" class="btn btn-default" >Reset</a>
				  <button type="submit" id="" class="btn btn-primary">Search</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection