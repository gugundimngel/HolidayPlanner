@extends('layouts.agent')
@section('title', 'Ledger Report')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Ledger Report</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Ledger Report</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->	
	
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
<div class="ledger_report common_report">
<p>For Checking Today's transactions</p> 
<div class="print_export">
<ul>
@if(isset($_GET['ref']))
<li class="export"><a href="{{URL::to('/agent/report/ledger')}}?ref={{@$_GET['ref']}}&type=excel"><i class="fas fa-file-excel"></i> Excel Export</a></li>
<li class="export"><a href="{{URL::to('/agent/report/ledger')}}?ref={{@$_GET['ref']}}&type=pdf"><i class="fas fa-file-excel"></i> PDF Report</a></li>
<li class="print"><a href="javascript:;" dataurl="{{URL::to('/agent/report/ledger')}}?ref={{@$_GET['ref']}}&type=print" class="print_myinvoice"><i class="fas fa-print"></i> Print</a></li>
@else 
	<li class="export"><a href="{{URL::to('/agent/report/ledger')}}?agent={{@$_GET['agent']}}&submission_start={{@$_GET['submission_start']}}&submission_end={{@$_GET['submission_end']}}&type=excel"><i class="fas fa-file-excel"></i> Excel Export</a></li>
<li class="export"><a href="{{URL::to('/agent/report/ledger')}}?agent={{@$_GET['agent']}}&submission_start={{@$_GET['submission_start']}}&submission_end={{@$_GET['submission_end']}}&type=pdf"><i class="fas fa-file-excel"></i> PDF Report</a></li>
<li class="print"><a class="print_myinvoice" href="javascript:;" dataurl="{{URL::to('/agent/report/ledger')}}?agent={{@$_GET['agent']}}&submission_start={{@$_GET['submission_start']}}&submission_end={{@$_GET['submission_end']}}&type=print"><i class="fas fa-print"></i> Print</a></li>
@endif
</ul>
</div>
<div class="clearfix"></div>
<div class="search_ref_id">	
<form action="{{route('agent.ledger')}}" method="get">
<div class="row">	
<div class="col-sm-4">
	<div class="form-group">
		<label>Search Booking By Reference ID</label>
	</div>
</div>
<div class="col-sm-4">
	<div class="form-group">
		<input type="text" value="{{Request::get('ref')}}" required class="form-control" name="ref" placeholder=""/>
		
	</div>
</div>
<div class="col-sm-4">
	<div class="ledger_btn text-right">
		<button type="submit" class="cus_btn">Lookup Booking</button>
	</div>
</div>
</div>
</form>	
</div>	

<div class="ledger_inner"> 
<h4>Refine Your Results</h4>
<div class="cus_report_field">	
<form action="{{route('agent.ledger')}}" method="get">
<div class="row">	
	<div class="col-sm-4">
		<div class="form-group">
			<label>Submission Start Date</label>
			<input type="text" value="{{Request::get('submission_start')}}" class="form-control commondate" name="submission_start" placeholder="mm/dd/yyyy"/>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="form-group">
			<label>Submission End Date</label>
			<input type="text" value="{{Request::get('submission_end')}}" class="form-control commondate" name="submission_end" placeholder="mm/dd/yyyy"/>
		</div>
	</div>
	<div class="col-sm-12">
		<div class="ledger_btn"> 
			<button type="submit" class="cus_btn">Search Order</button>
		</div>
	</div>
	
</div>
</form>
</div>
<div class="row">	
<div class="col-sm-12">
	<div class="table-responsive">
		<table id="invoicetable" class="table table-bordered table-hover text-nowrap domesticdata">
			<thead>
				<tr> 
					<th>Date</th>
					<th>Ref. Number</th>
					<th>Particulars</th>  
					<th>Debit</th>
					<th>Credit</th>
					<th>Running Balance</th>
				</tr> 
			</thead>
			<tbody> 
				<tr style="background-color:#e8e8e8;">
					<td colspan="6">@if(@$lists[0]->user->company_name !='') <b>Company Name: </b>{{@$lists[0]->user->company_name}}, Company Address: </b>{{@$lists[0]->user->address}}, {{@$lists[0]->user->city}}, {{@$lists[0]->user->state}} @endif</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:right;">Opening Balance</td>
					<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b> {{@$lists[0]->user->wallet}}</b></td>
					<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b></b></td>
					<td></td>
				</tr>
				<?php $tbalance=0; ?>
				@foreach($lists as $li)
				<?php
				$debit = 0;
				$credit = 0;
				?>
				<tr>
					<td>{{date('d/m/Y', strtotime($li->created_at))}}</td>
					<td>{{$li->reference_id}}</td>
					<td>{{$li->remark}}</td>
					<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b><?php if(@$li->type == 'debit'){ 
					$debit = @$li->amount;
					echo  @$li->amount; }else{ echo '0'; } ?></b></td>		
					 <td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b><?php if(@$li->type == 'credit'){ 
					 $credit = @$li->amount;
					 echo  @$li->amount; }else{ echo '0'; } ?></b></td>
					<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b><?php $chkbala = $credit - $debit;  echo $tbalance += $chkbala; ?></b></td>
				</tr>
				@endforeach 
			</tbody>
		</table>
	</div>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>	
				</div>	
			</div>
		</div>
	</section>
</div>
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="pdfmodel">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">Print Invoice</h4>
			   <button type="button" onclick="print()" class="btn btn-primary" >
				<span aria-hidden="true">Print</span>
			  </button>
			  <button type="button" class="btn btn-default closeprint">
				<span aria-hidden="true">Close</span>
			  </button>
			</div>

			<div class="modal-body">
				<iframe frameborder="0" src="" style="width:100%;height:80vh;" id="myFrame" name="printframe"></iframe>
			</div>
		</div>
	</div>
</div>
<script>
jQuery(document).ready(function($){
$(document).delegate('.print_myinvoice', "click", function () {
			var val = $(this).attr('dataurl');
			$('#pdfmodel').modal('show');
		
					 $("#pdfmodel .modal-body iframe").attr('src', val) // create an iframe
         
		});
		$(document).delegate('.closeprint', "click", function () {
			$('#pdfmodel').modal('hide');
		
		});
		});
</script>
@endsection