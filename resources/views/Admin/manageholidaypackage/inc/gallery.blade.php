<?php use App\Http\Controllers\Controller; ?>
<div class="form-group row">
	<label for="gallery" class="col-sm-2 col-form-label">Gallery List</label>
	<div class="col-sm-10">
		<button type="button" class="btn btn-primary btn-sm galleryopen"><i class="fa fa-plus"></i> Add</button>
	</div>			 								
</div>
<div class="modal fade" id="gallery_modal">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">New Gallery</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
			<div class="form-group row">
				<label for="imagealt" class="col-sm-2 col-form-label">Gallery Image Alt</label>
				<div class="col-sm-10">
				{{ Form::text('imagealt', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Image Alt', 'id' => 'gallery_imagealt' )) }}
				@if ($errors->has('imagealt'))
					<span class="custom-error" role="alert">
						<strong>{{ @$errors->first('imagealt') }}</strong>
					</span> 
				@endif
			  </div>
			</div> 
			<div class="form-group row">
				<label for="galleryimage" class="col-sm-2 col-form-label">Gallery Image</label>
				<div class="col-sm-10">
					<!--<a href="javascript:;" class="btn btn-primary showimages" data-type="galleryimage_m">Add Images</a> 
					<div class="galleryimage_m custom_pack_m"></div>-->
					<?php Controller::fileupload('','','galleryimage_m_id','galleryimage_m'); ?>
					{{-- <input type="file" name="galleryimage" class="form-control" autocomplete="off" data-valid="" />
					@if ($errors->has('galleryimage'))
						<span class="custom-error" role="alert">
							<strong>{{ @$errors->first('galleryimage') }}</strong>
						</span> 
					@endif --}}
				</div>
			</div>
		</div>
		<div class="modal-footer justify-content-between">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  <button type="button" id="save_gallery" class="btn btn-primary">Save</button>
		  <button type="button" id="update_gallery" style="display:none" class="btn btn-primary">Update</button>
		</div>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
var gallerydata = new Array();
</script>
<div class="card"> 
	<div class="card-body table-responsive p-0">
		<table id="gallery_table" class="table table-hover text-nowrap">
			<thead>
				<tr> 
					<th>ID</th>
					<th>Image Alt</th>
					<th>Image</th>
					<th>Action</th>
				</tr> 
			</thead>		  
			<tbody class="gallerydata">
			@if(isset($fetchedData))
			<?php 
				$igh =0;
				$fetchgallery = \App\PackageGallery::where('package_id', $fetchedData->id)->get();
				foreach($fetchgallery as $galist){	
			?>
			<?php $fetchggimage = \App\MediaImage::where('id', $galist->package_gallery_image)->first(); ?>
				<tr class="countgallen" id="gallery_<?php echo $igh; ?>">
					<td><?php echo $galist->package_gallery_image; ?></td>
					<td><?php echo $galist->package_gallery_image_alt; ?></td>
					<td><?php if($fetchggimage && @$fetchggimage->images != ''){ echo '<img width="50" height="50" src="'.URL::to('/public/img/media_gallery').'/'.@$fetchggimage->images.'">'; } ?></td>
					<td><a class="remove_gallery" id="<?php echo $igh; ?>" href="javascript:;"><i class="fa fa-trash"></i></a> / <a href="javascript:;" class="edit_gallery" id="<?php echo $igh; ?>"><i class="fa fa-edit"></i></a><input type="hidden" name="all_gallery_imagealt[]" value="<?php echo $galist->package_gallery_image_alt; ?>"><input type="hidden" name="all_gallery_imageid[]" value="<?php echo $galist->package_gallery_image; ?>"></td>  
					</tr>
					
					<script>
						gallerydata[<?php echo $igh; ?>] = {
					"image_alt":'<?php echo $galist->package_gallery_image_alt; ?>',
					"imageid":'<?php echo $galist->package_gallery_image; ?>',
					"image":'<?php if($fetchggimage && @$fetchggimage->images != ''){ echo URL::to('/public/img/media_gallery').'/'.@$fetchggimage->images; } ?>',
				}
					</script>
					<?php $igh++; } ?> 
			@else
				<tr id="hide_gallery">
					<td style="text-align:center;" colspan="3">
						No Record Found
					</td>
				</tr>
			@endif	
			</tbody>
		</table>
	</div>
</div>