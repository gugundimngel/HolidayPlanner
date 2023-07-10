@extends('layouts.admin')
@section('title', 'Edit')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	
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
						<h3 class="card-title">Edit Facility</h3>
					  </div>
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/grnhotelfacilties/edit', 'name'=>"edit-grnhotel", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
					   {{ Form::hidden('id', @$fetchedData->id) }}
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group" style="text-align:right;">
										<a style="margin-right:5px;" href="{{route('admin.managehotel.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
										{{ Form::button('<i class="fa fa-edit"></i> Update GRN Hotel', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-grnhotel")' ]) }}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group"> 
										<label for="name" class="col-form-label">Hotel Name <span style="color:#ff0000;">*</span></label>
										{{ Form::text('name', @$fetchedData->name, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter name' )) }}
										@if ($errors->has('name'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('name') }}</strong>
											</span> 
										@endif
									</div>
									
								</div>
								
							</div>
							<div class="row" style="display:none;">
								<div class="col-md-12" >
									<label for="image" class="col-form-label">Image Type</label>
									<ul style="list-style: none;">
										<li style="display: inline-block;    padding-right: 13px;"><input  type="radio" class="imagetype" name="imagetype" value="icon" /> Icon</li>
										<li style="display: inline-block;"><input checked type="radio" class="imagetype" name="imagetype" value="image" /> Image</li>
									</ul>
								</div>
							</div>
							<div class="row if_icon"  style="display:none;">
								<div class="col-md-6">
									<div class="form-group"> 
										<label for="image" class="col-form-label">Icon <span style="color:#ff0000;">*</span></label>
										
									<input type="text" name="icon" class="form-control" autocomplete="off" data-valid="" placeholder="fa fa-example" />
									(Note: only font awesome icons)
									</div>
									
								</div>
								
							</div>
							<div class="row "> 
								<div class="col-md-6">
									<div class="form-group"> 
										<label for="image" class="col-form-label">Image <span style="color:#ff0000;">*</span></label>
										<input type="hidden" id="old_image" name="old_image" value="{{@$fetchedData->icon}}" />
									
									<input type="file" name="image" class="form-control" autocomplete="off" data-valid="" />
									<p>(Size 30 X 30)</p>
									<div class="show-uploded-img">	
										@if(@$fetchedData->icon != '')
											<img width="70" src="{{URL::to('/public/img/hotel_img')}}/{{@$fetchedData->icon}}" class="img-avatar"/>
										@endif
									</div>	
									
									</div>
									
								</div>
								
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group float-right">
										{{ Form::button('<i class="fa fa-edit"></i> Update GRN Hotel', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("edit-grnhotel")' ]) }}
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
<script>
jQuery(document).ready(function($){
	$('.imagetype').on('change', function(){
		var v = $('.imagetype:checked').val();
		if(v == 'image'){
			$('.if_icon').hide();
			$('.if_image').show();
		}else{
			$('.if_icon').show();
			$('.if_image').hide();
		}
	});
});
</script>

@endsection