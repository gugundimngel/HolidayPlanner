@extends('layouts.admin')
@section('title', 'Visa Booking')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Visa Booking</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Visa</li>
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
						<div class="card-body">
							<div class="card-body table-responsive p-0">
								<table class="table table-bordered table-hover text-nowrap">
									<thead>
										<tr>
											<th>Visa Category</th>
											<th>Visa Type</th>
											<th>Processing Type</th>
											<th>Adult Cost B2B</th>
											<th>Adult Cost B2C</th>
											<th>Adult Cost Online</th>
											<th>Adult Cost Corporate</th>
											<th>Child Cost B2B</th>
											<th>Child Cost B2C</th>
											<th>Child Cost Online</th>
											<th>Child Cost Corporate</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>10 Days Visa</td>
											<td>Travel Visa</td>
											<td>Express</td>
											<td>500</td>
											<td>250</td>
											<td>150</td>
											<td>250</td>
											<td>100</td>
											<td>500</td>
											<td>500</td>
											<td>250</td>
											<td>
												<button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
												<button class="btn btn-sm btn-danger"><i class="fas fa-edit"></i></button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="card">
						<div class="card-header">  
							<div class="card-tools card_tools">
								<a href="javascript:;" data-toggle="modal" data-target="#amnetsearch_modal" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</a>
							</div>
							<div class="print_export">
								<ul>
									<!--<li class="print"><a dataurl="" href="{{URL::to('/admin/visa/add') }}" class="print_myinvoice"><i class="fas fa-plus"></i> Add Visa</a></li>-->
									<li class="print"><a dataurl="" href="javascript:;" class="print_myinvoice"><i class="fas fa-print"></i> Print</a></li>
									<li class="export"><a href="{{URL::to('/admin/excel_users_log')}}?first_name={{@$_GET['first_name']}}&last_name={{@$_GET['last_name']}}&from={{@$_GET['from']}}&to={{@$_GET['to']}}&email={{@$_GET['email']}}&status={{@$_GET['status']}}"><i class="fas fa-file-excel"></i> Export</a></li>
								</ul>
							</div>
						</div> 

					
						<div class="card-body table-responsive p-0">
							<table id="departurecity_table" class="table table-bordered table-hover text-nowrap">
							  <thead>
								<tr>
								  <th>ID</th>
								  <!--<th></th>-->
								  <th>Name</th>
								  <th>Email Id</th> 
								  <th>Phone</th> 
								   <th>Country Name</th> 
								  <th>Travel Date</th>
								  <th>Action</th>
								</tr> 
							  </thead>
							  <tbody class="tdata">	 
							     <?php use App\Http\Controllers\Controller;?>
							    @if(@$visa_query)
							    @foreach($visa_query as $key => $value)
							    @php
							      $country = Controller::Country_($value->country_name);
							      @endphp
							  <tr>
							    <td>{{$key+1}}</td>
							    <td>{{$value->name}}</td>
							    <td>{{$value->email}}</td>
							    <td>{{ $value->phone}}</td>
							    <td>{{ $country }}</td>
							    <td>{{ date("d F Y", strtotime($value->date_travel));}}</td>
			
							   
 <td>
									<div class="nav-item dropdown action_dropdown">
										<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
										<div class="dropdown-menu">
										 <a href="{{URL::to('/admin/visa/edit/'.base64_encode(convert_uuencode(@$value->id)))}}"><i class="fa fa-edit"></i> Edit</a>
										 <!--<a href="{{URL::to('/admin/visa/duplicate/'.base64_encode(convert_uuencode(@$list->id)))}}" ><i class="fa fa-clone"></i> Clone</a>-->
										 
										</div> 
									</div>								   
								  </td>							    
							</tr>
							    @endforeach
							    @endif
							    
							</table>
							<div class="card-footer">
							    <tr>
							    @if(@$visas)
							    @foreach($visas as $key => $value)
							    <td>{{$key+1}}</td>
							    
							    @endforeach
							    @endif
							    
							</tr>
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