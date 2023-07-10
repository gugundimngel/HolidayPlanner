@extends('layouts.admin')
@section('title', 'Agents')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Agents</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{URL::to('/admin/dashboard')}}">Home</a></li>
						<li class="breadcrumb-item active">Agents</li>
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
							<div class="cus_user_tags">
							<?php 
							$activs = \App\Agent::where('status', 1)->count(); 
							$inactivs = \App\Agent::where('status', 0)->count(); 
							$balance = \App\Agent::where('status', 1)->sum('wallet'); 
							?>
								<ul>
									<li class="active_tag cus_tag">
										<span class="span_tag" style="vertical-align: baseline;">{{@$activs}}</span> <span class="tag_label">Active</span>
									</li>
									<li class="inactive_tag cus_tag">
										<span class="span_tag" style="vertical-align: baseline;">{{@$inactivs}}</span> <span class="tag_label">In Active</span>
									</li> 
									<li class="balance_tag cus_tag">
										<span class="span_tag" style="vertical-align: baseline;">{{@$balance}}</span> <span class="tag_label">Balance</span>
									</li>
								</ul>
							</div>	
							<div class="card-tools card_tools" style="margin-top: 13px;">
								<a href="javascript:;" data-toggle="modal" data-target="#amnetsearch_modal" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</a>
							</div>
							<div class="print_export" style="margin-top: 13px;">
								<ul>
									<li class="print"><a dataurl="" href="javascript:;" class="print_myinvoice"><i class="fas fa-print"></i> Print</a></li>
									<li class="export"><a href="{{URL::to('/admin/excel_agents_log')}}?agent_id={{@$_GET['agent_id']}}&company_name={{@$_GET['company_name']}}&from={{@$_GET['from']}}&to={{@$_GET['to']}}&email={{@$_GET['email']}}&mobile={{@$_GET['mobile']}}&status={{@$_GET['status']}}"><i class="fas fa-file-excel"></i> Export</a></li>
								</ul>
							</div>
						</div>  
						
						<div class="card-body table-responsive p-0">
							<table id="" class="table table-bordered table-hover text-nowrap">
							  <thead>
								<tr>
								  <th>Agent ID</th>
								  <th>Company Name</th>
								  <th>Agent Name</th>
								  <th>Wallet Balance</th> 
								  <th>Credit</th> 
								  <th>Status</th>
								  <th>Action</th>
								</tr> 
							  </thead>
							  <tbody class="tdata">	 
								@if(@$totalData !== 0)
								@foreach (@$lists as $list)	
								<tr id="id_{{@$list->id}}"> 
									<td><a href="{{URL::to('/admin/agents/view/'.base64_encode(convert_uuencode(@$list->id)))}}">{{$list->username}}</a></td>
									<td>{{@$list->company_name}}</td>
								  <td>{{ @$list->sur_name }} {{ @$list->first_name }} {{ @$list->last_name }}</td> 
								  <td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b> {{number_format(@$list->wallet,2)}}</b></td> 
								  <td class="setlimitvalue"><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b>{{number_format(@$list->credit_limit,2)}}</b></td> 
								  <td><input data-id="{{@$list->id}}"  data-status="{{@$list->status}}" data-col="status" data-table="agents" class="change-status" value="1" type="checkbox" name="is_active" {{ (@$list->status == 1 ? 'checked' : '')}} data-bootstrap-switch></td> 	
								  <td>
									<div class="nav-item dropdown action_dropdown cus_action_btn">
										<a class="nav-link dropdown-toggle action_btn btn btn-primary btn-rounded btn-xs dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
										<div class="dropdown-menu">
											<a href="{{URL::to('/admin/agents/view/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-eye"></i> View Detail</a>
											<a href="{{URL::to('/admin/agents/send-password/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-eye-slash"></i> Send Password</a>  
											<a target="_blank" href="{{URL::to('/admin/agents/agentlogin')}}/{{base64_encode(convert_uuencode(@$list->id))}}"><i class="fa fa-sign-in"></i> Login</a>
										</div>
									</div> 
									<div class="nav-item dropdown action_dropdown cus_action_btn">
										<a class="nav-link dropdown-toggle finance_btn btn btn-info btn-rounded btn-xs dropdown-toggle" data-toggle="dropdown" href="#">Finance <span class="caret"></span></a>
										<div class="dropdown-menu">
											<a href="{{URL::to('/admin/wallet/create')}}?agent_id={{base64_encode(convert_uuencode(@$list->id))}}&type=topup"><i class="fa fa-money"></i> TopUP Amount</a>
											<a href="{{URL::to('/admin/wallet/create')}}?agent_id={{base64_encode(convert_uuencode(@$list->id))}}&type=deduct"><i class="fa fa-money"></i> Deduct Amount</a>
											<a href="javascript:;" data-id="{{@$list->id}}" class="setcreditlimit"><i class="fa fa-credit-card"></i> Set Credit Limit</a>
											<a href="{{URL::to('/admin/agents/transactionlog/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-money"></i> Transaction Log</a>
											<a href="{{URL::to('/admin/agents/credit_limit_log/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-credit-card"></i> Credit Limit Log</a>
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
<div class="modal fade" id="setlimit_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				  <h4 class="modal-title">Set Credit Limit</h4>
				  <button type="button" class="close closemodel">
					<span aria-hidden="true">&times;</span>
				  </button>
			</div>
			<div class="modal-body"> 
			</div>
			
		</div>
	</div>
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
			
			<form action="{{URL::to('/admin/agents')}}" method="get">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="pnr" class="col-sm-2 col-form-label">Agent ID</label>
								<div class="col-sm-10">
									{{ Form::text('agent_id', Request::get('agent_id'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Agent ID', 'id' => 'agent_id' )) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="company_name" class="col-sm-2 col-form-label">Company Name</label>
								<div class="col-sm-10">
									{{ Form::text('company_name', Request::get('company_name'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Company Name', 'id' => 'company_name' )) }}
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
								<label for="mobile" class="col-sm-2 col-form-label">Mobile</label>
								<div class="col-sm-10">
									{{ Form::text('mobile', Request::get('mobile'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Mobile', 'id' => 'mobile' )) }}
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
<script>
jQuery(document).ready(function($){
	$(document).delegate('.closemodel', 'click', function(){
		$('#setlimit_modal').modal('hide');
		$('#setlimit_modal .modal-body').html('');
	});
	$(document).delegate('.setcreditlimit', 'click', function(){
		$('#setlimit_modal').modal('show');
		var vid = $(this).attr('data-id');
		$.ajax({
			type:'get',
			url:'{{URL::to('admin/agents/setlimit/')}}/'+vid,
			processData: false,
			contentType: false,
			
			success: function(response){
				$('#setlimit_modal .modal-body').html(response);
			}
		});
	});
	
	$(document).delegate('.submitcreditlimit', 'click', function(){
		var myform = document.getElementById('creditlimt');
		var fd = new FormData(myform);
		$.ajax({
		type:'post',
		url:'{{URL::to('admin/agents/setlimit')}}',
		processData: false,
		contentType: false,
		data: fd,
		 headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		success: function(response){
			$('#preloader').hide();
			$('#preloader div').hide();
			var obj = $.parseJSON(response); 
			if(obj.success){
				alert(obj.message);
				$('.tdata #id_'+obj.userid+' .setlimitvalue').html('<i class="fa fa-inr"></i><b> '+obj.amount)+'</b>';
				$('#setlimit_modal').modal('hide');
			}else{
				alert(obj.message);
				
			}
		}
	});
	});
});
</script>
@endsection