@extends('layouts.admin')
@section('title', 'Leads')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Leads</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Leads</li>
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
					<div class="custom-error-msg"></div>
					<!-- Flash Message End -->
					
				</div>
				<div class="col-12 col-sm-6 col-md-3">
				<a href="{{route('admin.leads.index')}}?type=not_contacted">
					<div class="info-box">
						
						<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-phone-slash"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Not Contacted</span>
							<span class="info-box-number">{{@$not_contacted}}</span>
						</div>
						
					  <!-- /.info-box-content -->
					</div>
					</a>
					<!-- /.info-box -->
				</div>
				<div class="col-12 col-sm-6 col-md-3">
					<a href="{{route('admin.leads.index')}}?type=create_porposal">
					<div class="info-box">
						<span class="info-box-icon bg-info elevation-1"><i class="fas fa-file-alt"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Creating Porposal</span>
							<span class="info-box-number">{{@$create_porposal}}</span>
						</div>
					  <!-- /.info-box-content -->
					</div>
					</a>
					<!-- /.info-box -->
				</div>
				<div class="col-12 col-sm-6 col-md-3">
					<a href="{{route('admin.leads.index')}}?type=follow_up">
					<div class="info-box">
						<span class="info-box-icon bg-success elevation-1"><i class="fas fa-retweet"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Follow Up</span>
							<span class="info-box-number">{{@$followup}}</span>
						</div>
					  <!-- /.info-box-content -->
					</div>
					</a>
					<!-- /.info-box --> 
				</div>
				<div class="col-12 col-sm-6 col-md-3">
				<a href="{{route('admin.leads.index')}}?type=followup">
					<div class="info-box">
						<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-frown-open"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Undecided</span>
							<span class="info-box-number">{{@$undecided}}</span>
						</div>
					  <!-- /.info-box-content -->
					</div>
				</a>
					<!-- /.info-box -->
				</div> 
				<div class="col-12 col-sm-6 col-md-3">
					<a href="{{route('admin.leads.index')}}?type=lost">
					<div class="info-box">
						<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-eye-slash"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Lost</span>
							<span class="info-box-number">{{@$lost}}</span>
						</div>
					  <!-- /.info-box-content -->
					</div>
					</a>
					<!-- /.info-box --> 
				</div>
				<div class="col-12 col-sm-6 col-md-3">
					<a href="{{route('admin.leads.index')}}?type=won">
					<div class="info-box">
						<span class="info-box-icon bg-success elevation-1"><i class="fas fa-won-sign"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Won</span>
							<span class="info-box-number">{{@$won}}</span>
						</div>
					  <!-- /.info-box-content -->
					</div>
					</a>
					<!-- /.info-box -->
				</div>
				<div class="col-12 col-sm-6 col-md-3">
				<a href="{{route('admin.leads.index')}}?type=today">
					<div class="info-box">
						<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-phone"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Today's Call</span>
							<span class="info-box-number">{{@$todaycall}}</span>
						</div>
					  <!-- /.info-box-content -->
					</div>
					</a>
					<!-- /.info-box -->
				</div>
				<div class="col-12 col-sm-6 col-md-3">
				<a href="{{route('admin.leads.index')}}?type=ready_to_pay">
					<div class="info-box"> 
						<span class="info-box-icon bg-info elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Ready to pay</span>
							<span class="info-box-number">{{@$ready_to_pay}}</span>
						</div>
					  <!-- /.info-box-content -->
					</div>
					</a>
					<!-- /.info-box -->
				</div>
				
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">  
							<div class="card-title">
								<?php
								$userrole = \App\UserRole::where('usertype', Auth::user()->role)->first();
								$modules = json_decode(@$userrole->module_access);	
								if(@in_array('add_lead', $modules)){
								?>
									<a href="{{route('admin.leads.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Leads</a>
									
									 <a style="display:none;" class="btn btn-primary displayifselected" href="javascript:;" onClick="deleteAllAction('leads')"><i class="fa fa-trash"></i> Delete</a>
								<input type="hidden" id="cururl" value="{{@$cur_url}}">
								<?php } ?>
							</div>  
							<div class="card-tools card_tools col-sm-6"> 
								<form action="{{route('admin.leads.index')}}" id="filterform" method="get">
									<div class="row">							
										<div class="col-sm-5"> 
											<div class="form-group">
											@php
												$priority = Request::get('priority');
											@endphp
												<select class="form-control" onchange="this.form.submit()" name="priority">
													<option value="">Priority</option>
													<option value="Low" @if(@$priority == "Low") selected @endif >Low</option>
													<option value="Medium" @if(@$priority == "Medium") selected @endif >Medium</option>
													<option value="High" @if(@$priority == "High") selected @endif >High</option>
													<option value="Urgent" @if(@$priority == "Urgent") selected @endif >Urgent</option>
												</select>
											</div>
										</div>
										<div class="col-sm-5">
											<div class="form-group">
											@php
												$status = Request::get('status');
											@endphp
												<select class="form-control" onchange="this.form.submit()" name="status">
												<option value="">Lead Stage</option>
												@foreach(\App\FollowupType::all() as $flist)
													<option value="{{$flist->id}}" @if(@$status == $flist->id) selected @endif >{{$flist->name}}</option>
												@endforeach
												</select>
											</div>
										</div>						
										<div class="col-sm-2">
											<a href="javascript:;" data-toggle="modal" data-target="#leadsearch_modal" class="btn btn-primary"><i class="fas fa-search"></i></a>
										</div>
									</div> 
								</form>
							</div>
						</div> 
						<div class="card-body table-responsive">
							<table id="hoteltable" class="table table-bordered table-hover text-nowrap">
							  <thead>
								<tr> 
								  <th class="no-sort"><input type="checkbox" id="checkedAll"></th>
								  <th>Lead ID</th>
								  <th>Name</th>
								  <th class="no-sort">Email</th>
								  <th class="no-sort">Phone</th>
								  <th class="no-sort">Going To</th>
								  <th class="no-sort">Service</th>
								  <th class="no-sort">Lead Stage</th>
								  <th class="no-sort">Priority</th>
								  <th class="no-sort">Latest Comment</th> 
								  <th class="no-sort">Action</th>
								</tr>  
							  </thead> 
							  <tbody class="tdata">	
								  @if(@$totalData !== 0)
									@foreach (@$lists as $list)	
								<?php $followp = \App\Followup::where('lead_id','=',$list->id)->where('followup_type','!=','assigned_to')->orderby('id','DESC')->with(['followutype'])->first(); 
								 ?> 
										<tr id="id_{{@$list->id}}">
											<td><input class="checkSingle" type="checkbox" name="allcheckbox" value="{{@$list->id}}"></td>
											<td>{{@$list->id}}</td>
											<td>{{@$list->name}}</td>
											<td>{{@$list->email}}</td>
											<td>{{@$list->phone}}</td>
											<td>{{@$list->going_to}}</td>
											<td>{{@$list->service}}</td>
											@if($followp)
											@if($followp->followutype->type == 'follow_up')
												<td>{{$followp->followutype->name}} {{date('d-m-Y h:i A', strtotime($followp->followup_date))}}</td>
											@else
												<td>{{$followp->followutype->name}}</td>
											@endif
											
											@else
												<td>Not Contacted</td>
											@endif
											<td><span class="priority_{{@lcfirst($list->priority)}} priority_style">{{@$list->priority}}</span>
											</td>
											@if($followp)
											<td>{{ @$followp->note == "" ? config('constants.empty') : str_limit(@$followp->note, '20', '...') }}</td>
											<td>
											@else
												<td>{{ @$list->latest_comment == "" ? config('constants.empty') : str_limit(@$list->latest_comment, '20', '...') }}</td>
											<td>
											@endif
											<div class="nav-item dropdown action_dropdown">
											
												<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
											
												<div class="dropdown-menu">
												@if(@in_array('edit_lead', $modules))
												  <a href="{{URL::to('/admin/leads/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-edit"></i> Edit</a>
											   @endif
											   @if(@in_array('lead_history', $modules))
												  <a href="{{URL::to('/admin/leads/history/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-history"></i> History</a>
											  @endif
											   @if(@in_array('add_lead', $modules) && @in_array('edit_lead', $modules))
												  
											  <a class="assignlead_modal" href="javascript:;" mleadid="{{base64_encode(convert_uuencode(@$list->id))}}"><i class="fa fa-edit"></i> Assign To</a>
											  @endif
												</div>
											  </div>
										</td>
										</tr>
									@endforeach 
										
									@else
									<tr>
										<td style="text-align:center;" colspan="10">
											No Record found
										</td>
									</tr>										
								  @endif  
									 									
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
<div class="modal fade" id="assignlead_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				  <h4 class="modal-title">Assign Lead</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
			</div>
			{{ Form::open(array('url' => 'admin/leads/assign', 'name'=>"add-assign", 'autocomplete'=>'off', "enctype"=>"multipart/form-data", 'id'=>"addnoteform")) }}
			<div class="modal-body">
				<div class="form-group row">
					<div class="col-sm-12">
						<input id="mlead_id" name="mlead_id" type="hidden" value="">
						<select name="assignto" class="form-control select2 " style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
							<option value="">Select</option>
							@foreach(\App\Admin::where('user_id', '=', Auth::user()->id)->Where('role', '=', '63')->get() as $ulist)
							<option value="{{@$ulist->id}}">{{@$ulist->first_name}} {{@$ulist->last_name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				{{ Form::button('<i class="fa fa-save"></i> Assign Lead', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-assign")' ]) }}
			</div>
			 {{ Form::close() }}
		</div>
	</div>
</div>

@endsection