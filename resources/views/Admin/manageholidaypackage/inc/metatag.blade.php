<div class="form-group row">
	<label for="metatag" class="col-sm-2 col-form-label">Meta Tags</label>
	<div class="col-sm-10">
		<button type="button" class="btn btn-primary btn-sm metatagopen"><i class="fa fa-plus"></i> Add</button>
	</div>			 								
</div>
<div class="modal fade" id="metatag_modal">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">New Meta Tags</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
			<div class="form-group row">
				<label for="metatitle" class="col-sm-2 col-form-label">Title</label>
				<div class="col-sm-10">
				{{ Form::text('metatitle', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Title', 'id' => 'metatitle' )) }}
				@if ($errors->has('metatitle'))
					<span class="custom-error" role="alert">
						<strong>{{ @$errors->first('metatitle') }}</strong>
					</span> 
				@endif
			  </div>
			</div>
			<div class="form-group row">
				<label for="metakeyword" class="col-sm-2 col-form-label">Keyword</label>
				<div class="col-sm-10">
				{{ Form::text('metakeyword', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Keyword', 'id' => 'metakeyword' )) }}
				@if ($errors->has('metakeyword'))
					<span class="custom-error" role="alert">
						<strong>{{ @$errors->first('metakeyword') }}</strong>
					</span> 
				@endif
			  </div>
			</div> 
			<div class="form-group row">
				<label for="metadescription" class="col-sm-2 col-form-label">Description</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="metadescription" placeholder="Please Add Meta Description Here" id="metadescription">
										
					@if ($errors->has('metadescription'))
						<span class="custom-error" role="alert">
							<strong>{{ @$errors->first('metadescription') }}</strong>
						</span> 
					@endif
			   </div>
			</div>
				<div class="form-group row">
				<label for="metadescription" class="col-sm-2 col-form-label">Canonical tag</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="canonicaltag" placeholder="Please Add canonical tag Here" id="canonicaltag">
										
					@if ($errors->has('canonicaltag'))
						<span class="custom-error" role="alert">
							<strong>{{ @$errors->first('canonicaltag') }}</strong>
						</span> 
					@endif
			   </div>
			</div>
		</div>
		<div class="modal-footer justify-content-between">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  <button type="button" id="save_metatag" class="btn btn-primary">Save</button>
		  <button type="button" id="update_metatag" style="display:none" class="btn btn-primary">Update</button>
		</div> 
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script> var metatagdata = new Array(); </script>
<div class="card"> 
	<div class="card-body table-responsive p-0">
		<table id="metatag_table" class="table table-hover text-nowrap">
			<thead>
				<tr> 
				  <th>Title</th>
				  <th>Keyword</th>
				  <th>Description</th> 
				  <th>Canonical tag</th> 
				  <th>Action</th>
				</tr> 
		    </thead>		 
			<tbody class="metatag_data">	
			 @if(isset($fetchedData))
			<?php 
				$im =0;
				$fetchmtags = \App\Metatag::where('package_id', $fetchedData->id)->get();
				foreach($fetchmtags as $mtlist){	
			?>
			<tr class="countmtlist" id="metatag_<?php echo $im; ?>"><td><?php echo $mtlist->title; ?></td><td><?php echo $mtlist->keyword; ?></td><td><?php echo $mtlist->description; ?></td>		<td><?php echo $mtlist->canonicaltag; ?></td><td><a class="remove_metatag" id="<?php echo $im; ?>" href="javascript:;"><i class="fa fa-trash"></i></a> / <a href="javascript:;" class="edit_metatag" id="<?php echo $im; ?>"><i class="fa fa-edit"></i></a><input type="hidden" name="all_meta_title[]" value="<?php echo $mtlist->title; ?>"><input type="hidden" name="all_meta_keyword[]" value="<?php echo $mtlist->keyword; ?>"><textarea style="display:none;" type="hidden" name="all_meta_desc[]" value=""><?php echo $mtlist->description; ?></textarea></td>
	</tr>
			<script>
				metatagdata[<?php echo $im; ?>] = {
					"title":'<?php echo $mtlist->title; ?>',
					"keyword":'<?php echo $mtlist->keyword; ?>',
					"description":'<?php echo base64_encode($mtlist->description); ?>',
				}	
			</script>
			<?php $im++; } ?>
			  @else
				<tr id="hide_metatag">
					<td style="text-align:center;" colspan="4">
						No Record Found
					</td>
				</tr>
				@endif
			</tbody>
		</table>
	 </div>
</div>