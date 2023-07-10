<form id="acceptpayment" name="accept_payment" action="{{URL::to('/admin/wallet/edit')}}" method="post">
<input type="hidden" name="walletid" value="{{@$fetchedData->id}}">

<input type="hidden" name="type" class="typeid" value="{{$type}}">
	<div class="modal-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<th>Agent ID</th>
								<td>{{@$fetchedData->user->username}}</td>
							</tr>
							<tr>
								<th>Agent Name</th>
								<td>{{ @$fetchedData->user->first_name }} {{ @$fetchedData->user->last_name }}</td>
							</tr>
							<tr>
								<th>Payment Mode</th>
								<td>{{@$fetchedData->pay_mode}}</td>
							</tr>
							<tr>
								<th>Amount</th>
								<td>{{@$fetchedData->amount}}</td>
							</tr>
							<tr>
								<th>Cheque No.</th>
								<td>{{@$fetchedData->cheque_no}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<th>Payment Date</th>
								<td>{{date('d/m/Y',strtotime(@$fetchedData->pay_date))}}</td>
							</tr>
							<tr>
								<th>Request Date</th>
								<td>{{date('d/m/Y',strtotime(@$fetchedData->created_at))}}</td>
							</tr>
							<tr>
								<th>Bank Name</th>
								<td>{{@$fetchedData->bank_name}}</td>
							</tr>
							<tr>
								<th>Bank Transaction Id</th>
								<td>{{@$fetchedData->bank_transaction_id}}</td>
							</tr>
							<tr>
								<th>Status</th>
								<td class="walletstatus">@if(@$fetchedData->status == 1)
									<span class="priority_green priority_style">Approved</span> 
								  @elseif(@$fetchedData->status == 2)
								  <span class="priority_medium priority_style">Rejected</span> 
								  @else
									<span class="priority_high priority_style">Pending</span> 
								  @endif
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label>Remarks</label>
					<textarea class="form-control" name="remarks"></textarea>
				</div>
				<div class="form-group ">
				<button class="btn @if($type == 'approve') btn-primary @else btn-danger @endif btntype submitwallet" myid="{{@$fetchedData->id}}" type="button"><i class="fa fa-edit"></i> @if($type == 'approve') Accept Payment @else Reject Payment @endif</button>
					
				  </div>
			</div>
		</div>
	</div>
</form>	