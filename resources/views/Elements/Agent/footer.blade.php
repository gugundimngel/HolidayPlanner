<footer class="app-footer">
	<div>
		<a href="{{URL::to('/')}}">ApnaMentor</a>
			<span>&copy; <?php echo date('Y'); ?> apnamentor.</span>
	</div>
	<div class="ml-auto">
		<span>Powered by</span>
		<a href="javascript:void(0);">RG</a>
	</div>
</footer>
<div class="modal fade" id="media_modal">
	<div class="modal-dialog modal-xl">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">Media Library</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
	
			<div class="row">
			<input type="hidden" id="mtype">
				<div class="col-3 col-sm-2">
					<div class="nav flex-column nav-tabs h-100 custom_nav_tabs" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link active" id="vert-tabs-upload-tab" data-toggle="pill" href="#vert-tabs-upload" role="tab" aria-controls="vert-tabs-upload" aria-selected="true">Upload Files</a>
						<a class="nav-link" id="vert-tabs-media-tab" data-toggle="pill" href="#vert-tabs-media" role="tab" aria-controls="vert-tabs-media" aria-selected="true">Media Library</a>
					</div>
				</div>
				<div class="col-9 col-sm-10">
					<div class="tab-content custom_tab_content" id="vert-tabs-tabContent">
						<div class="tab-pane text-left fade show active" id="vert-tabs-upload" role="tabpanel" aria-labelledby="vert-tabs-upload-tab">
						<div class="show_custom_msg"></div>
						<input type="file" name="file" id="file">
						<div class="upload-area"  id="uploadfile">
							<h1>Drag and Drop file here<br/>Or</h1>
							<a class="btn btn-outline-primary" href="javascript:;">Select Files</a>
						</div>	
						</div>
						<div class="tab-pane text-left fade show" id="vert-tabs-media" role="tabpanel" aria-labelledby="vert-tabs-media-tab">
						<div class="show_custom_msg"></div>
							<div class="gallery_list_data">
								<ul>
								</ul> 
								<div class="clearfix"></div> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	  </div>
	<!-- /.modal-content -->
	</div>
<!-- /.modal-dialog -->
</div>