<table id="invoicetable" border="1" class="table table-bordered table-hover text-nowrap domesticdata">
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
					<td><i class="fa fa-rupee-sign"></i> {{@$lists[0]->user->wallet}}</td>
					<td></td>
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
					<td><?php if(@$li->type == 'debit'){ 
					$debit = @$li->amount;
					echo  @$li->amount; }else{ echo '0'; } ?></td>		
					 <td><?php if(@$li->type == 'credit'){ 
					 $credit = @$li->amount;
					 echo  @$li->amount; }else{ echo '0'; } ?></td>
					<td><?php $chkbala = $credit - $debit;  echo $tbalance += $chkbala; ?></td>
					
				</tr>
				@endforeach
			</tbody>
		</table>