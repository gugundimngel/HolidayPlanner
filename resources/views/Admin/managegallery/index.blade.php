@extends('layouts.admin')
@section('title', 'Gallery')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Gallery</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Gallery</li>
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
								<a href="{{route('admin.managegallery.create')}}" class="btn btn-primary">New Gallery</a> 
							</div> 
							<div class="card-tools card_tools">
								<div class="input-group input-group-sm" style="width: 150px;">
									<input type="text" name="table_search" class="form-control float-right" placeholder="Search">
									<div class="input-group-append">
										<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body table-responsive p-0">
							<table class="table table-hover text-nowrap">
							  <thead>
								<tr>
								  <th>ID</th>
								  <th>Gallery Name</th>
								  <th>Added By</th>
								  <th>Status</th>
								  <th>Action</th>
								</tr> 
							  </thead>
							  <tbody class="tdata">	
								@if(@$totalData !== 0)
								@foreach (@$lists as $list)	
								<tr id="id_{{@$list->id}}"> 
								  <td>{{ @$list->id == "" ? config('constants.empty') : str_limit(@$list->id, '50', '...') }}</td> 
								  <td>{{ @$list->gallery_name == "" ? config('constants.empty') : str_limit(@$list->gallery_name, '50', '...') }}</td> 
								  <td>{{ @$list->user->company_name == "" ? config('constants.empty') : str_limit(@$list->user->company_name, '50', '...') }}</td>
								  <td><input class="change-status" data-id="{{@$list->id}}"  data-status="{{@$list->status}}" data-col="status" data-table="galleries" value="1" type="checkbox" name="status" {{ (@$list->status == 1 ? 'checked' : '')}} data-bootstrap-switch></td>
								  <td><a href="{{URL::to('/admin/gallery/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-edit"></i> Edit</a> / <a href="javascript:;" onClick="deleteAction({{@$list->id}}, 'galleries')"><i class="fa fa-trash"></i> Delete</a>
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
							<div class="card-footer">
							 {!! $lists->appends(\Request::except('page'))->render() !!}
							 </div>
						  </div>
					</div>	
				</div>	
			</div>
		</div>
	</section>
</div>
@endsection