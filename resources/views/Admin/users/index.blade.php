@extends('layouts.admin')
@section('title', 'Users')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Users</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Users</li>
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
							<div class="card-tools card_tools">
								<a href="javascript:;" data-toggle="modal" data-target="#amnetsearch_modal" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</a>
							</div>
							<div class="print_export">
								<ul>
									<li class="print"><a dataurl="" href="javascript:;" class="print_myinvoice"><i class="fas fa-print"></i> Print</a></li>
									<li class="export"><a href="{{URL::to('/admin/excel_users_log')}}?first_name={{@$_GET['first_name']}}&last_name={{@$_GET['last_name']}}&from={{@$_GET['from']}}&to={{@$_GET['to']}}&email={{@$_GET['email']}}&status={{@$_GET['status']}}"><i class="fas fa-file-excel"></i> Export</a></li>
								</ul>
							</div>
						</div> 
						
						<div class="card-body table-responsive p-0">
							<table id="departurecity_table" class="table table-bordered table-hover text-nowrap">
							  <thead>
								<tr>
								  <th>User ID</th>
								  <th>First Name</th>
								  <th>Last Name</th>
								  <th>Email</th> 
								  <th>Phone</th> 
								 
								  <th>Is Active</th>
								  <th>Action</th>
								</tr> 
							  </thead>
							  <tbody class="tdata">	 
								@if(@$totalData !== 0)
								@foreach (@$lists as $list)	
								<tr id="id_{{@$list->id}}"> 
									<td><a href="{{URL::to('/admin/users/view/'.base64_encode(convert_uuencode(@$list->id)))}}">{{str_pad($list->id, 4, '0', STR_PAD_LEFT)}}</a></td>
								  <td>{{ @$list->first_name == "" ? config('constants.empty') : str_limit(@$list->first_name, '50', '...') }}</td> 
								  <td>{{ @$list->last_name == "" ? config('constants.empty') : str_limit(@$list->last_name, '50', '...') }}</td> 
								  <td>{{ @$list->email == "" ? config('constants.empty') : str_limit(@$list->email, '50', '...') }}</td> 
								  <td>{{ @$list->phone }}</td> 
								  
								  <td><input data-id="{{@$list->id}}"  data-status="{{@$list->status}}" data-col="status" data-table="users" class="change-status" value="1" type="checkbox" name="is_active" {{ (@$list->status == 1 ? 'checked' : '')}} data-bootstrap-switch></td> 	
								  <td>
									<div class="nav-item dropdown action_dropdown cus_action_btn">
										<a class="nav-link dropdown-toggle action_btn btn btn-primary btn-rounded btn-xs" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
										<div class="dropdown-menu">
											<a href="{{URL::to('/admin/users/view/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-eye"></i> View Detail</a>
											<a href="{{URL::to('/admin/users/send-password/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-edit"></i> Send Password</a>
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
							<div class="card-footer">
							
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
				  <h4 class="modal-title">Search</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
			</div>
			
			<form action="{{URL::to('/admin/users')}}" method="get">
				<div class="modal-body">
					<div class="row">
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="first_name" class="col-sm-2 col-form-label">First Name</label>
								<div class="col-sm-10">
									{{ Form::text('first_name', Request::get('first_name'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'First Name', 'id' => 'first_name' )) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
								<div class="col-sm-10">
									{{ Form::text('last_name', Request::get('last_name'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Last Name', 'id' => 'last_name' )) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="ref" class="col-sm-2 col-form-label">From Date</label>
								<div class="col-sm-10">
									{{ Form::text('from', Request::get('from'), array('class' => 'form-control commodate', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'From Date', 'id' => 'from' )) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="ref" class="col-sm-2 col-form-label">To Date</label>
								<div class="col-sm-10">
									{{ Form::text('to', Request::get('to'), array('class' => 'form-control commodate', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'To Date', 'id' => 'to' )) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="email" class="col-sm-2 col-form-label">Email</label>
								<div class="col-sm-10">
									{{ Form::text('email', Request::get('email'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Email', 'id' => 'email' )) }}
								</div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="ref" class="col-sm-2 col-form-label">Status</label>
								<div class="col-sm-10">
									<select class="form-control" name="status">
										<option value=""></option>
										<option value="1" @if(Request::get('status') == 1) selected @endif >Active</option>
										<option value="0" @if(Request::get('status') == 0) selected @endif >Inactive</option>
										
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					{{ Form::submit('Search', ['class'=>'btn btn-primary' ]) }}
				</div>
			</form>
		</div>
	</div>
</div>
@endsection