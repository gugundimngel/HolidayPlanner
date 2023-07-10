<div class="form-group row">
	<label for="metasearch" class="col-sm-2 col-form-label">Tag Destination</label>
	<div class="col-sm-10">
		<button type="button" class="btn btn-primary btn-sm metasearchopen"><i class="fa fa-plus"></i> Add</button>
	</div>			 								
</div>
<div class="modal fade" id="metasearch_modal">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">New Tag Destination</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
			<div class="form-group row">
				<label for="destination_metasearch" class="col-sm-2 col-form-label">Destination</label>
				<div class="col-sm-10">
					<select name="destination_metasearch" id="metasearch_destination" class="form-control" autocomplete="new-password">
						<option value="">-- Select Dest. Type --</option>
						@if(count(@$destination) !== 0)
								@foreach (@$destination as $destinate)
									<option value="{{ @$destinate->id }}">{{ @$destinate->name }}</option>
								@endforeach
						@endif	
					</select>							
					@if ($errors->has('destination_metasearch'))
						<span class="custom-error" role="alert">
							<strong>{{ @$errors->first('destination_metasearch') }}</strong>
						</span> 
					@endif
			   </div>
			</div>
		</div>
		<div class="modal-footer justify-content-between">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  <button type="button" id="save_metasearch" class="btn btn-primary">Save</button>
		  <button type="button" id="update_metasearch" style="display:none" class="btn btn-primary">Update</button>
		</div>
	  </div>
	  <!-- /.modal-content -->
	</div> 
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="card"> 
	<div class="card-body table-responsive p-0">
		<table id="metasearch_table" class="table table-hover text-nowrap">
		  <thead>
			<tr> 
			  <th>ID</th>
			  <th>Destination</th>
			  <th>Action</th>
			</tr> 
		  </thead>		    
		  <tbody class="metasearch_data">	
		  @if(isset($fetchedData))
				<?php 
				$fetchmsearch = \App\MetaSearch::where('package_id', $fetchedData->id)->with(['mylocdata'])->get();
				
				
				foreach($fetchmsearch as $slist){
				
			?>
			<tr id="metasearch_<?php echo $slist->destination_id; ?>"><td><?php echo $slist->destination_id; ?></td><td><?php echo $slist->mylocdata->name; ?></td><td><a class="remove_metasearch" id="<?php echo $slist->destination_id; ?>" href="javascript:;"><i class="fa fa-trash"></i></a> / <a href="javascript:;" class="edit_metasearch" id="<?php echo $slist->destination_id; ?>"><i class="fa fa-edit"></i></a><input type="hidden" name="metasearch[]" value="<?php echo $slist->destination_id; ?>"></td></tr>
			<?php } ?>
			  @else
			<tr id="hide_metasearch">
				<td style="text-align:center;" colspan="3">
					No Record Found
				</td>
			</tr>
@endif			
	      </tbody>
		</table>
	 </div>
</div>