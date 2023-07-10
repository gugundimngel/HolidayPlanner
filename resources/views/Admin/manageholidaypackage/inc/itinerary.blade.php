<style>
.itinerarydata td {
    cursor: grab;
}
</style>
<?php use App\Http\Controllers\Controller; ?>
<div class="form-group row">
	<label for="itinerary" class="col-sm-2 col-form-label">Itinerary</label>
	<div class="col-sm-10">
		<button type="button" class="btn btn-primary btn-sm itineraryshow" ><i class="fa fa-plus"></i> Add</button>
	</div>											
</div>
<div class="modal fade" id="itinerary_modal">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">New Itinerary</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
			<div class="form-group row"> 
				<label for="title" class="col-sm-2 col-form-label">Title</label>
				<div class="col-sm-10">
				{{ Form::text('title', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Title', 'id' => 'itinerary_title' )) }}
				@if ($errors->has('title'))
					<span class="custom-error" role="alert">
						<strong>{{ @$errors->first('title') }}</strong>
					</span> 
				@endif 
				</div> 
			</div>
			<div class="form-group row">
				<label for="detail" class="col-sm-2 col-form-label">Details</label>
				<div class="col-sm-10">
					<textarea id="itinerary_detail" name="detail" class="textarea" placeholder="Please Add Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
					@if ($errors->has('detail'))
						<span class="custom-error" role="alert">
							<strong>{{ @$errors->first('detail') }}</strong>
						</span> 
					@endif
				</div>
			</div>
			<div class="form-group row">
				<label for="itineraryimage" class="col-sm-2 col-form-label">Itinerary Image</label>
				<div class="col-sm-10">
					<!--<a href="javascript:;" class="btn btn-primary showimages" data-type="itineraryimage_m">Add Images</a>
					<div class="itineraryimage_m custom_pack_m"></div>-->
					<?php Controller::fileupload('','','itineraryimage_m_id','itineraryimage_m'); ?>
					{{-- <input id="itinerary_image" type="file" name="itineraryimage" class="form-control" autocomplete="off" data-valid="" />
					@if ($errors->has('itineraryimage'))
						<span class="custom-error" role="alert">
							<strong>{{ @$errors->first('itineraryimage') }}</strong>
						</span> 
					@endif --}}
				</div>
			</div>
			<div class="form-group row"> 
				<label for="foodtype" class="col-sm-2 col-form-label">Foodtype</label>
				<div class="col-sm-10">
					<select name="foodtype[]" id="foodtype" class="select2" multiple="multiple" data-placeholder="Select Foodtype" style="width: 100%;">
						<option value="">-- Select Foodtype --</option>
						<option value="breakfast">BreakFast</option>
						<option value="dinner">Dinner</option>
						<option value="lunch">Lunch</option>
					</select>
					@if ($errors->has('foodtype'))
						<span class="custom-error" role="alert">
							<strong>{{ @$errors->first('foodtype') }}</strong>
						</span> 
					@endif 
				</div> 
			</div>
		</div>
		<div class="modal-footer justify-content-between">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  <button type="button" id="save_itinerary" class="btn btn-primary">Save</button>
		  <button type="button" id="update_itinerary" style="display:none" class="btn btn-primary">Update</button>
		</div>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<script> var itinerarydata = new Array(); </script>
<!-- /.modal -->
<div class="card">  
	<div class="card-body table-responsive p-0">
		<table id="itinerary_table" class="table table-hover text-nowrap">
		  <thead>
			<tr> 
			  <th>Day</th>
			  <th>Title</th>
			  <!--<th>Details</th> -->
			  <th>Action</th>
			</tr> 
		  </thead>
		  <tbody class="itinerarydata">
		  @if(isset($fetchedData))
			<?php 
				$i =0;
				$ij =1;
				$fetchitinerary = \App\PackageItinerary::where('package_id', $fetchedData->id)->orderBy('id','ASC')->get();
				foreach($fetchitinerary as $itrrlist){	
			?>
				<tr class="countitlen" id="itinerary_<?php echo $i; ?>">
					<td class="itenery_day"><?php echo $ij; ?></td>
					<td><?php echo $itrrlist->title; ?></td>
					<!--<td><?php //echo str_limit(@$itrrlist->details, '50', '...'); ?></td>-->
					<td><a class="remove_itinerary" id="<?php echo $i; ?>" href="javascript:;"><i class="fa fa-trash"></i></a> / <a href="javascript:;" class="edit_itinerary" id="<?php echo $i; ?>"><i class="fa fa-edit"></i></a><input type="hidden" name="itinerary_title[]" value="<?php echo $itrrlist->title; ?>"><textarea style="display:none;" type="hidden" name="all_itinerary_detail[]" value=""><?php echo $itrrlist->details; ?></textarea><input type="hidden" name="all_itinerary_img[]" value="<?php echo $itrrlist->itinerary_image; ?>"><input type="hidden" name="all_itinerary_food[]" value="<?php echo $itrrlist->foodtype; ?>"></td>
					</tr>
					<?php $fetchimage = \App\MediaImage::where('id', $itrrlist->itinerary_image)->first(); ?>
					<script>
						itinerarydata[<?php echo $i; ?>] = {
					"title":'<?php echo $itrrlist->title; ?>',
					"detail":'<?php echo base64_encode($itrrlist->details); ?>',
					"imageid":'<?php echo $itrrlist->itinerary_image; ?>',
					"image":'<?php if($fetchimage && @$fetchimage->images != ''){ echo URL::to('/public/img/media_gallery').'/'.@$fetchimage->images; } ?>',
					"foodtype":'<?php echo rtrim($itrrlist->foodtype,','); ?>',
					}
					</script>
					<?php $i++; $ij++; } ?>
			@else
				<!--<tr id="hide_itinerary">
					<td style="text-align:center;" colspan="3">
						No Record Found
					</td>
				</tr>-->
			@endif		
			</tbody>
		</table>
	</div>
</div>