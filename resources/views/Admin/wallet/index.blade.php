@extends('layouts.admin')
@section('title', 'Wallet Request')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Wallet Request</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Wallet Request</li>
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
							<div class="cus_user_tags">
								<ul>
								<?php 
								$approved = \App\Wallet::where('status',1)->count();
								$pending = \App\Wallet::where('status',0)->count();
								$rejected = \App\Wallet::where('status',2)->count();
								$totalrec = \App\Wallet::where('status',1)->sum('amount'); ?>
									<li class="active_tag cus_tag">
										<span class="span_tag approvetag">{{@$approved}}</span> <span class="tag_label">Approved
										<small class="approvetag"> {{@$approved}}</small></span>
									</li>
									<li class="inactive_tag cus_tag">
										<span class="span_tag pendingtag">{{@$pending}}</span> <span class="tag_label">Pending 
										<small class="pendingtag"> {{@$pending}}</small></span>
									</li>
									<li class="balance_tag cus_tag">
										<span class="span_tag rejectedtag"> {{@$rejected}}</span> <span class="tag_label">Rejected
										<small class="rejectedtag"> {{@$rejected}}</small></span>
									</li>
									<li class="active_tag cus_tag">
										<span class="span_tag totalrectag"><i class="fa fa-rupee-sign"></i> {{@$totalrec}}</span> <span class="tag_label">Total Received <small class="totalrectag" style="opacity:0;">{{@$totalrec}}</small></span>
									</li>
								</ul>
							</div>	
							<div class="card-tools card_tools" style="margin-top: 15px;">
								<a href="javascript:;" data-toggle="modal" data-target="#inclusearch_modal" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</a>
							</div>
							<div class="print_export" style="margin-top: 15px;">
								<ul>
									<li class="print"><a dataurl="" href="javascript:;" class="print_myinvoice"><i class="fas fa-print"></i> Print</a></li>
									<li class="export"><a href="{{URL::to('/admin/wallet/excel_waller_log')}}?agent={{@$_GET['agent']}}&rdate={{@$_GET['rdate']}}&date={{@$_GET['date']}}&mode={{@$_GET['mode']}}&transaction_id={{@$_GET['transaction_id']}}&status={{@$_GET['status']}}"><i class="fas fa-file-excel"></i> Export</a></li>
								</ul>
							</div>
						</div>  
						<div class="card-body table-responsive">
							<table id="inclusiontable" class="table table-bordered table-hover text-nowrap">
							  <thead>
								<tr> 
								  <th class="no-sort">Agent ID</th>
								  <th class="no-sort">Agent Name</th>								
								  <th>Request Date</th>
								  <th>Payment Date</th>
								  <th class="no-sort">Amount</th>
								  <th class="no-sort">Payment Mode</th>
								  <th class="no-sort">Status</th>
								  <th class="no-sort">Action</th>
								</tr> 
							  </thead>  
							   <tbody class="tdata">	
								@if(@$totalData !== 0)
								@foreach (@$lists as $list)	
								<tr id="id_{{@$list->id}}">
								  <td>{{ str_pad(@$list->user->username, 5, '0', STR_PAD_LEFT) }}</td>		
								  <td>{{ @$list->user->first_name }} {{ @$list->user->last_name }}</td>		
								  <td>{{ date('Y-m-d',strtotime(@$list->pay_date)) }}</td>		
								  <td>{{ @$list->pay_date }}</td>		
								  <td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b>{{ @$list->amount }}</b></td>		
								  <td>{{ @$list->pay_mode }}</td>		
								  <td class="walletstt">@if($list->status == 1) 
									<span class="priority_green priority_style">Approved</span> 
								   @elseif(@$list->status == 2)
								  <span class="priority_medium priority_style">Rejected</span> 
								  @else
									<span class="priority_high priority_style">Pending</span> 
								  @endif</td>		
								 
								  <td>
									<div class="nav-item dropdown action_dropdown cus_action_btn">
										<a class="nav-link dropdown-toggle  action_btn btn btn-primary btn-rounded btn-xs" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
										<div class="dropdown-menu">
											<a href="{{URL::to('/admin/wallet/view/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-eye"></i> View Detail</a>
											<a class="walletar" href="javascript:;" data-type="approve" data-id="{{@$list->id}}"  ><i class="fa fa-check"></i> Accept</a>
											<a class="walletar" data-id="{{@$list->id}}" href="javascript:;" data-type="reject" ><i class="fa fa-times"></i> Reject</a>
										</div>
									</div>
									
								  </td>
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

<div class="modal fade" id="walletpopup_modal"> 
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Payment Detail</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="inclusearch_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				  <h4 class="modal-title">Search</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
			</div>
			<form action="{{route('admin.wallet.index')}}" method="get">
				<div class="modal-body"> 
					<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="agent" class="col-sm-2 col-form-label">Agent</label>
							<div class="col-sm-10">
								<select class="form-control" name="agent">
									<option value="">----</option>
									@foreach(\App\Agent::all() as $clist) 
										<option @if(Request::get('agent') == @$clist->id) selected @endif value="{{@$clist->id}}">{{@$clist->first_name}} {{@$clist->last_name}} ({{@$clist->username}})</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
							<div class="form-group row">
								<label for="date" class="col-sm-2 col-form-label">Request Date</label>
								<div class="col-sm-10">
									{{ Form::text('rdate', Request::get('rdate'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Request Date', 'id' => 'followupdate' )) }}
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
						<div class="col-md-6">
							<div class="form-group row">
								<label for="name" class="col-sm-2 col-form-label">Payment Mode</label>
								<div class="col-sm-10">
									<select class="form-control" name="mode">
										<option value="">Select</option>
										<option value="Cheque/Draft" @if(Request::get('mode') == 'Cheque/Draft') selected @endif>Cheque/Draft</option>
										<option value="Cash" @if(Request::get('mode') == 'Cash') selected @endif>Cash</option>
										<option value="RTGC/NEFT" @if(Request::get('mode') == 'RTGC/NEFT') selected @endif>RTGC/NEFT</option>
										<option @if(Request::get('mode') == 'Debit Card/Credit Card/Net Banking') selected @endif value="Debit Card/Credit Card/Net Banking">Debit Card/Credit Card/Net Banking</option>
										<option @if(Request::get('mode') == 'EDC Machine/Transfer') selected @endif value="EDC Machine/Transfer">EDC Machine/Transfer</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="status" class="col-sm-2 col-form-label">Payment Status</label>
								<div class="col-sm-10">
									<select class="form-control" name="status">
										<option value="">Select</option>
										<option value="1" @if(Request::get('status') == '1') selected @endif>Approved</option>
										<option value="2" @if(Request::get('status') == '2') selected @endif>Rejected</option>
										<option value="0" @if(Request::get('status') == '0') selected @endif>Pending</option>
										
									</select>
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
<script>
$(document).delegate('.walletar', "click", function () {
			$('#walletpopup_modal').modal('show');	
				var v = $(this).attr('data-type');
				var vid = $(this).attr('data-id');
				if(v == 'approve'){
				$.ajax({
					type:'get',
					url:'{{URL::to('admin/wallet/edit/')}}/'+vid+'?type='+v,
					processData: false,
					contentType: false,
					
					success: function(response){
						$('#walletpopup_modal .modal-body').html(response);
					}
				});
				}else{
					$.ajax({
					type:'get',
					url:'{{URL::to('admin/wallet/edit/')}}/'+vid+'?type='+v,
					processData: false,
					contentType: false,
					
					success: function(response){
						$('#walletpopup_modal .modal-body').html(response);
					}
				});
				}
				
			});
 $(document).delegate('.submitwallet', "click", function () {			
$('#preloader').show();
	$('#preloader div').show();
	var vid = $(this).attr('myid');
	var myform = document.getElementById('acceptpayment');
	var fd = new FormData(myform);
	$.ajax({
		type:'post',
		url:'{{URL::to('admin/wallet/edit')}}',
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
			$('.approvetag').html(obj.approved);
			$('.pendingtag').html(obj.pending);
			$('.rejectedtag').html(obj.rejected);
			$('.totalrectag').html('<i class="fa fa-rupee-sign"></i> '+obj.totalrec);
			if(obj.success){
				if(obj.wallettype == 'approve'){
					$('#inclusiontable .tdata #id_'+vid+' .walletstt').html('<span class="priority_green priority_style">Approved</span>');
					
				}else{
					$('#inclusiontable .tdata #id_'+vid+' .walletstt').html('<span class="priority_medium priority_style">Rejected</span>');
					
				}
				$('.custom-error-msg').html('<div class="alert alert-success">'+obj.message+'</div>');
				$('html, body').animate({scrollTop:$("#inclusiontable"). offset(). top}, 'slow');
				$('#walletpopup_modal').modal('hide');
			}else{
				$('#inclusiontable .tdata #id_'+vid+' .walletstt').html('<span class="priority_high priority_style">Pending</span>');
				
				$('.custom-error-msg').html('<div class="alert alert-danger">'+obj.message+'</div>');
				$('html, body').animate({scrollTop:$("#inclusiontable"). offset(). top}, 'slow');
				
			}
		}
	});
	}); 
</script>
@endsection