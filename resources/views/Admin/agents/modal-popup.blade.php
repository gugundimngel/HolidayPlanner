<form id="creditlimt" name="credit_limt" action="" method="post">
	<input type="hidden" name="userid" id="userid" value="{{@$fetchedData->id}}">
		
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="date" class="col-form-label">Credit Limit</label>
							<input type="number" class="form-control" value="{{@$fetchedData->credit_limit}}" name="credit_limit" placeholder="Credit Limit" autocomplete="off">
						</div>
				</div>
		</div>
		<div class="modal-footer">
		  <a href="javascript:;" class="btn btn-default closemodel" >Close</a>
		  <button type="button" id="" class="btn btn-primary submitcreditlimit">Set</button>
		</div>
	</form>