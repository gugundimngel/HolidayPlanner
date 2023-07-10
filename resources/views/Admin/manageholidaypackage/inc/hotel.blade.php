<div class="form-group row">
	<label for="hotel" class="col-sm-2 col-form-label">Hotel List</label>
	<div class="col-sm-10">
		<button type="button" class="btn btn-primary btn-sm hotelopen"><i class="fa fa-plus"></i> Add</button>
	</div>			 								
</div>
<div class="modal fade" id="hotel_modal">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">New Package Hotels</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">	
			<div class="form-group row">
				<label for="dest_type_pack" class="col-sm-2 col-form-label">Dest. Type</label>
				<div class="col-sm-10">
					<select onChange="getHotelLocations()" name="dest_type_pack" id="dest_type_pack" class="form-control" autocomplete="new-password">
						<option value="">-- Select Dest. Type --</option>
						<option value="domestic">Domestic</option>
						<option value="international">International</option>
					</select>	 						
					@if ($errors->has('dest_type_pack'))
						<span class="custom-error" role="alert">
							<strong>{{ @$errors->first('dest_type_pack') }}</strong>
						</span> 
					@endif
			   </div>	
			</div>
			<div class="form-group row">
				<label for="destination_pack" class="col-sm-2 col-form-label">Destination</label>
				<div class="col-sm-10">
					<select onChange="getHotelNames()" name="destination_pack" id="destination_pack" class="form-control" autocomplete="new-password"> 
						<option value="">-- Select Destination --</option>
						{{--	@if(count(@$destination) !== 0)
								@foreach (@$destination as $destinate)
									<option value="{{ @$destinate->id }}">{{ @$destinate->dest_name }}</option>
								@endforeach
						@endif	--}} 
					</select>    								
					@if ($errors->has('destination_pack'))
						<span class="custom-error" role="alert">
							<strong>{{ @$errors->first('destination_pack') }}</strong>
						</span> 
					@endif
				</div>	
			</div>
			<div class="form-group row">
				<label for="hotel_name" class="col-sm-2 col-form-label">Hotel Name</label>
				<div class="col-sm-10">
					<select name="hotel_name" id="hotel_name" class="form-control" autocomplete="new-password">
						<option value="">-- Select Hotel Name --</option>
					</select>  								
					@if ($errors->has('hotel_name'))
						<span class="custom-error" role="alert">
							<strong>{{ @$errors->first('hotel_name') }}</strong>
						</span> 
					@endif
				</div>	
			</div>
		</div>
		<div class="modal-footer justify-content-between">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  <button type="button" id="save_hotel" class="btn btn-primary">Save</button>
		  <button type="button" id="update_hotel" style="display:none" class="btn btn-primary">Update</button>
		</div>
	  </div>
	<!-- /.modal-content -->
	</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script> var hoteldata = new Array(); </script>
<div class="card"> 
	<div class="card-body table-responsive p-0">
		<table id="hotel_table" class="table table-hover text-nowrap">
		  <thead>
			<tr> 
			  <th>ID</th>
			  <th>Hotel Title</th>
			  <th>Action</th>
			</tr> 
		  </thead>
		  <tbody class="hoteldata">
			@if(isset($fetchedData))
				<?php 
			$ih = 0;
				$fetchhotel = \App\PackageHotel::where('package_id', $fetchedData->id)->with(['hotel'])->orderBy('id','ASC')->get();
				foreach($fetchhotel as $hlist){	
			?>
				<tr class="counthtlen" id="hotel_<?php echo $ih; ?>">
					<td><?php echo $hlist->hotel_name; ?></td>
					<td><?php echo $hlist->hotel->name; ?></td>
					<td><a class="remove_hotel" id="<?php echo $ih; ?>" href="javascript:;"><i class="fa fa-trash"></i></a> / <a href="javascript:;" class="edit_hotel" id="<?php echo $ih; ?>"><i class="fa fa-edit"></i></a><input type="hidden" name="all_hotel_name[]" value="<?php echo $hlist->hotel_name; ?>"><input type="hidden" name="all_dest_type[]" value="<?php echo $hlist->dest_type; ?>"><input type="hidden" name="all_hotel_destination[]" value="<?php echo $hlist->destination; ?>"></td>
					</tr>
					<?php
					$ddlis = '';
					$hotlis = '';
						$dest_typelist = \App\Location::where('dest_type', $hlist->dest_type)->get();
						foreach($dest_typelist as $dlist){
							$ddlis .= '<option value="'.$dlist->id.'">'.$dlist->name.'</option>';
						}
						
						$hotl_typelist = \App\Hotel::where('destination', $hlist->destination)->get();
						foreach($hotl_typelist as $hlllist){
							$hotlis .= '<option value="'.$hlllist->id.'">'.$hlllist->name.'</option>';
						}
					?>
					<script>
						
					hoteldata[<?php echo $ih; ?>] = {
					"destination_type":'<?php echo $hlist->dest_type; ?>',
					"destination":'<?php echo $hlist->destination; ?>',
					"hotel_name":'<?php echo $hlist->hotel_name; ?>',
					"alldest":'<?php echo $ddlis; ?>',
					
					"allhotel":'<?php echo $hotlis; ?>',
					
				}
					</script>
					
					<?php $ih++; } ?>
			@else
				<tr id="hide_hotelrow">
					<td style="text-align:center;" colspan="3">
						No Record Found
					</td>
				</tr>
			@endif
			</tbody>
		</table>
	  </div>
</div>