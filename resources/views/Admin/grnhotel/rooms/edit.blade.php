@extends('layouts.admin')
@section('title', 'Edit Room')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">GRN Hotel</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">GRN Hotel</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
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
					<div class="card card-primary">
					  <div class="card-header">
						<h3 class="card-title">Edit Room</h3>
					  </div>
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/rooms/edit', 'name'=>"edit-grnhotel", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
					   {{ Form::hidden('id', @$fetchedData->id) }}
					   {{ Form::hidden('hotel_code', @$hcode) }}
					   {{ Form::hidden('ref', @$ref) }}
						<div class="card-body">
						<?php
						$roominfo = \App\Room::where('room_reference', $ref)->first();
						?>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group" style="text-align:right;">
										
										<a style="margin-right:5px;" href="{{route('admin.grnhotel.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
										{{ Form::button('<i class="fa fa-edit"></i> Update Room', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-grnhotel")' ]) }}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group"> 
										<label for="name" class="col-form-label">Room Name </label>
										
										{{ Form::text('name', @$roomsdata->$ref->room_type, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Hotel Name','readonly'=>true )) }}
										
									</div>
									<div class="form-group"> 
										<label for="room_size" class="col-form-label">Room Size</label>
										{{ Form::text('room_size', @$roominfo->room_size, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Room Size' )) }}
										@if ($errors->has('room_size'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('room_size') }}</strong>
											</span> 
										@endif
									</div>
									
								</div>
								
								
								<div class="col-md-12">
									<h4>Images</h4>
									<table class="table">
										<thead>
										<tr>
											<th>Image</th>
											
											
											<th>Status</th>
											<th>Action</th>
										</tr>
										</thead>
										<tbody>
										<?php
										foreach(\App\RoomImage::where('refid', $ref)->where('hcode', $hcode)->get() as $list){
										?>
											<tr id="id_{{@$list->id}}">
											<td><img width="100px" src="{{URL::to('/public/img/gallery_img')}}/{{@$list->image}}"></td>
											 <td><input data-id="{{@$list->id}}"  data-status="{{@$list->status}}" data-col="status" data-table="room_images" class="change-new-status" value="1" type="checkbox" name="status" {{ (@$list->status == 1 ? 'checked' : '')}} data-bootstrap-switch></td> 	
											<td><a href="javascript:;" onClick="deletenewAction({{@$list->id}}, 'room_images')">Remove</a></td>
											</tr>
										<?php } ?>
										</tbody>
										<tfoot>
										
											<tr>
												<td></td>
												<td></td>
												
												<td><a class="openimage btn btn-default" href="javascript:;">Add Image</a></td>
											</tr>
											
										</tfoot>
									</table>
								</div> 
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group float-right">
										{{ Form::button('<i class="fa fa-edit"></i> Update Room', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-grnhotel")' ]) }}
									</div> 
								</div> 
							</div> 
						</div> 
					  {{ Form::close() }}
					</div>	
				</div>	
			</div>
		</div>
	</section>
</div>
@endsection
@section('scripts')
<script >
jQuery(document).ready(function($){
	$('.openimage').on('click', function(){
		$('.table tbody').append('<tr><td><input type="file" class="form-control" name="upimages[]"></td><td></td><td><a class="removemyimage" href="javascript:;">Remove</a></td></tr>');
	});
	
	$(document).delegate('.removemyimage', 'click', function(){
		$(this).parent().parent().remove();
	});
});
</script>
@endsection