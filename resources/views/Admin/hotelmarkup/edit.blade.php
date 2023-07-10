@extends('layouts.admin')
@section('title', 'Edit Markup')

@section('content')
 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Edit  Markup</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit  Markup</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->	
	<!-- Breadcrumb start-->
	<!--<ol class="breadcrumb">
		<li class="breadcrumb-item active">
			Home / <b>Dashboard</b>
		</li>
		@include('../Elements/Admin/breadcrumb')
	</ol>-->
	<!-- Breadcrumb end-->
	
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
						<h3 class="card-title">Edit  Markup</h3>
					  </div> 
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/hotelmarkup/edit', 'name'=>"add-city", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
					   {{ Form::hidden('id', @$fetchedData->id) }}
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group" style="text-align:right;">
										<a style="margin-right:5px;" href="{{route('admin.hotelmarkup')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
										{{ Form::button('<i class="fa fa-save"></i> Update Markup', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-city")' ]) }}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="user_type" class="col-form-label">User Type <span style="color:#ff0000;">*</span></label>
										<select class="form-control" name="user_type" >
											<option value="b2c" <?php if($fetchedData->user_type == 'b2c'){ echo 'selected'; } ?>>B2C</option>
											<option value="b2b" <?php if($fetchedData->user_type == 'b2b'){ echo 'selected'; } ?>>B2B</option>
											
										</select>
										@if ($errors->has('user_type'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('user_type') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="markup_type" class="col-form-label">Markup Type <span style="color:#ff0000;">*</span></label>
										<select class="form-control" name="markup_type" id="markup_type">
											<option value="domestic"  <?php if($fetchedData->markup_type == 'domestic'){ echo 'selected'; } ?>>Domestic</option>
											<option value="international"  <?php if($fetchedData->markup_type == 'international'){ echo 'selected'; } ?>>International</option>
											<option value="city_wise" <?php if($fetchedData->user_type == 'city_wise'){ echo 'selected'; } ?>>City Wise</option>
											<option value="hotel_wise" <?php if($fetchedData->user_type == 'hotel_wise'){ echo 'selected'; } ?>>Hotel Wise</option>
										</select>
										@if ($errors->has('markup_type'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('markup_type') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="markup_fee" class="col-form-label">Markup Amount<span style="color:#ff0000;">*</span></label>
										{{ Form::text('markup_fee', @$fetchedData->markup_fee, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Markup Amount' )) }}
										@if ($errors->has('markup_fee'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('markup_fee') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="amount_type" class="col-form-label">Amount Type <span style="color:#ff0000;">*</span></label>
										<select data-valid="required" class="form-control" name="amount_type" >
											<option value="fixed" <?php if($fetchedData->amount_type == 'fixed'){ echo 'selected'; } ?>>Fixed</option>
											<option value="Percentage" <?php if($fetchedData->amount_type == 'Percentage'){ echo 'selected'; } ?>>Percentage</option>
											
										</select>
										@if ($errors->has('amount_type'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('amount_type') }}</strong>
											</span> 
										@endif
									</div>
								</div>

								<?php
								$code = '';
									$hname = '';
									if($fetchedData->markup_type == 'city_wise'){
										$hcity = \App\HotelCity::where('city_code', '=', $fetchedData->city_code)->first();
										$hname = @$hcity->name;
										$code = @$fetchedData->city_code;
									}else{
										$hcity = \App\HotelData::where('hotel_code', '=', $fetchedData->hotel_code)->first();
										$hname = @$hcity->hotel_name;
										$code = @$fetchedData->hotel_code;
									}
								?>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="search" class="col-form-label">Search</label>
										<input <?php if($fetchedData->hotel_type == 'city_wise'){ }else if($fetchedData->hotel_type == 'hotel_wise'){ }else{ echo 'readonly'; } ?> type="text" value="{{$hname}}" id="search" name="search" class="form-control">
										<input  type="hidden" id="searchcode" value="{{$code}}" name="searchcode" class="form-control">
									</div>
								</div>
								
								<div class="col-sm-12">
									<div class="form-group float-right">
										{{ Form::button('<i class="fa fa-save"></i> Save', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-city")' ]) }}
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
$('#markup_type').on('change', function(){
	if($('#markup_type option:selected').val() == 'city_wise' || $('#markup_type option:selected').val() == 'hotel_wise'){
		$('#search').prop('readonly', false);
	}else{
		$('#search').prop('readonly', true);
	}
});
$( "#search" ).autocomplete({
	search:function(event,ui){
        var newUrl='{{URL::to('/admin/searchlist')}}?h='+$('#markup_type option:selected').val();
        $(this).autocomplete("option","source",newUrl)
    },
    source:[],
//	source: '{{URL::to('/admin/searchlist')}}&k='+$('#hotel_type option:selected').val(),
	select: function (a, b) {            
        var selected_venue_id = b.item.v_id;
        var selected_venue_name = b.item.label;            
        $("#searchcode").val(selected_venue_id);
        console.log(selected_venue_id);            
    },
	open: function() { 
      $('#from_oneway').autocomplete("widget").width(300),
      $(".ui-autocomplete").css({"max-height": 250,"overflow":"scroll","overflow-x": "hidden","width":301});
      $(".ui-menu").css({"font-size": 13});	
      $('.ui-autocomplete').off('menufocus hover mouseover mouseenter'); 
  },
});
</script>
@endsection