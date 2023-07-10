@extends('layouts.admin')
@section('title', 'Wallet History')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Wallet History</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Wallet History</li>
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
								<a href="{{route('admin.wallet.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Debit/Credit</a> 
								 
							</div>  
							<div class="card-tools card_tools">
								<form action="{{route('admin.wallet.crdr')}}" id="filterform" method="get">
									<div class="row">
										<div class="col-sm-8"> 
											<div class="form-group">
												@php
												$priority = Request::get('type');
											@endphp
											<select class="form-control" onchange="this.form.submit()" name="type">
													<option value="">All</option>
													<option value="credit" @if(@$priority == "credit") selected @endif >Cr</option>
													<option value="debit" @if(@$priority == "debit") selected @endif >Dr</option>
												</select>
											</div>
										</div>
										<div class="col-md-4">
										<a href="javascript:;" data-toggle="modal" data-target="#inclusearch_modal" class="btn btn-primary"><i class="fas fa-search"></i></a>
									</div>
									</div>
								</form>
								
							</div>
						</div>
						<div class="card-body table-responsive">
							<table id="inclusiontable" class="table table-bordered table-hover text-nowrap">
							  <thead>
								<tr> 								
									<th>Date</th>								
									<th>Cr</th>
									<th>DR</th>
									<th class="no-sort">Agent</th>
									<th class="no-sort">Agent Name</th>
								</tr> 
							  </thead> 
							   <tbody class="tdata">	
								@if(@$totalData !== 0)
								@foreach (@$lists as $list)	
								<tr id="id_{{@$list->id}}">
								  <td>{{ date('Y-m-d',strtotime(@$list->created_at)) }}</td>		
								 		
								  <td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b><?php echo  @$list->credit; ?></b></td>		
								  <td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b><?php echo  @$list->debit; ?></b></td>		
								  <td>{{ str_pad(@$list->user->username, 5, '0', STR_PAD_LEFT) }}</td>
								  <td>{{ @$list->user->first_name }} {{ @$list->user->last_name }}</td>		
								</tr>	 
								@endforeach						
							  </tbody>
							  @else
							 
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
<div class="modal fade" id="inclusearch_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				  <h4 class="modal-title">Wallet Request Search</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
			</div>
			<form action="{{route('admin.wallet.crdr')}}" method="get">
				<div class="modal-body"> 
					<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="agent" class="col-sm-2 col-form-label">Agent</label>
							<div class="col-sm-10">
								<select class="form-control" name="agent">
									<option value="">----</option>
									@foreach(\App\Agent::all() as $clist) 
										<option value="{{@$clist->id}}">{{@$clist->first_name}} {{@$clist->last_name}}  ({{str_pad(@$clist->id, 5, '0', STR_PAD_LEFT)}})</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					
						<div class="col-md-6">
							<div class="form-group row">
								<label for="date" class="col-sm-2 col-form-label">Payment Date</label>
								<div class="col-sm-10">
									{{ Form::text('date', Request::get('date'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Payment Date', 'id' => 'followupdate' )) }}
								</div>
							</div>
						</div>
					
						
						
					</div>
				</div>
				<div class="modal-footer justify-content-between">
				  <a href="{{route('admin.wallet.index')}}" class="btn btn-default" >Reset</a>
				  <button type="submit" id="" class="btn btn-primary">Search</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection