@extends('layouts.admin')
@section('title', 'Manage Contacts')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Manage Contacts</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Manage Contacts</li>
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
								<a href="{{route('admin.managecontact.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Contacts</a>
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
								  <th>Name</th>
								  <th>Company Name</th>
								  <th>Email</th>
								  <th>Work Phone</th>
								  <th>Receivables</th>
								  <th>Unused Credits</th>
								  <th>Action</th>
								</tr>  
							  </thead> 
							  <tbody class="tdata">	
							   @if(@$totalData !== 0)
								@foreach (@$lists as $list)	
								<tr id="id_{{@$list->id}}"> 
								  <td>{{ @$list->id == "" ? config('constants.empty') : str_limit(@$list->id, '50', '...') }}</td> 
								  <td>{{ @$list->srname == "" ? config('constants.empty') : str_limit(@$list->srname, '50', '...') }}
								  {{ @$list->first_name == "" ? config('constants.empty') : str_limit(@$list->first_name, '50', '...') }}
								  {{ @$list->middle_name == "" ? config('constants.empty') : str_limit(@$list->middle_name, '50', '...') }}
								  {{ @$list->last_name == "" ? config('constants.empty') : str_limit(@$list->last_name, '50', '...') }}</td> 
								  <td>{{ @$list->company_name == "" ? config('constants.empty') : str_limit(@$list->company_name, '50', '...') }}</td> 
								  <td>{{ @$list->contact_email == "" ? config('constants.empty') : str_limit(@$list->contact_email, '50', '...') }}</td>
								  <td>{{ @$list->contact_phone == "" ? config('constants.empty') : str_limit(@$list->contact_phone, '50', '...') }}, {{ @$list->work_phone == "" ? config('constants.empty') : str_limit(@$list->work_phone, '50', '...') }}</td>
								  <td></td>
								  <td></td>
								  <td>
									<div class="nav-item dropdown action_dropdown">
										<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
										<div class="dropdown-menu">
											<a href="{{URL::to('/admin/contact/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-edit"></i> Edit</a>
											<a href="javascript:;" onClick="deleteDesAction({{@$list->id}}, 'contacts')"><i class="fa fa-trash"></i> Delete</a>
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