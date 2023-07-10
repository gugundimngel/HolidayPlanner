@extends('layouts.admin')
@section('title', 'Flight Markup')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Flight Markup</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Flight Markup</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->	
	
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
					<div class="card"> 
						<div class="card-header">   
							<div class="card-title">
								<a href="{{route('admin.flightmarkup.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Markup</a> 
							</div> 
							
						</div> 
						<div class="card-body">
							<ul class="nav nav-tabs nav_custom_tabs" id="custom-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="domestic-tab" data-toggle="pill" href="#domestic" role="tab" aria-controls="domestic" aria-selected="true">Domestic</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="international-tab" data-toggle="pill" href="#international" role="tab" aria-controls="international">International</a>
								</li>
							</ul>
							<div class="tab-content" id="custom-tab-content">
								<div class="tab-pane active show" id="domestic" role="tabpanel" aria-labelledby="domestic-tab">
								 {{ Form::open(array('url' => 'admin/flightmarkup/update', 'name'=>"add-domestic", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
								 <input type="hidden" value="domestic" name="markup_tpe"/>
								 <input type="hidden" value="1" name="update_type" id="update_type"/>
									<!--<div class="commission_radio">
										<div class="radio">
											<label>
												<input type="radio" value="1" class="selectcommission" name="commission" checked /> Commission
											</label>
										</div>
										<div class="radio">
											<label>
												<input type="radio" value="2" class="selectcommission" name="commission"/> Non-Commission
											</label>
										</div>
									</div>-->
									<div class="commission_amount">
										<div class="usertype_select">
											<ul>
												<li>
												<input type="hidden" value="b2c" name="user_type"/>
													<a class="dropdown-toggle btn btn-block btn-outline-primary btn-sm is_not_selected_invoice" data-toggle="dropdown" href="#" aria-expanded="false"><i class="fa fa-plus"></i> User Type <span class="caret"></span></a>
													<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 31px, 0px);">
													  <a class="dropdown-item" tabindex="-1" href="{{URL::to('/admin/flightmarkup')}}">B2C Markup</a>
													  <a class="dropdown-item" tabindex="-1" href="{{URL::to('/admin/flightmarkup')}}?type=b2b">B2B Markup</a>
													</div>	 										
												</li>
											</ul> 
										</div>
										<div class="amount_field">
											<input type="text" class="form-control" id="service_fee" name="amount" placeholder="Amount (Rs.)"/>
										</div>
										<div class="markuptype_field"> 
											<select id="service_type" class="form-control" name="service_type">
												<option value="">Markup Type</option>
												<option value="percentage">Percentage</option>
												<option value="fixed">Fixed</option>
											</select>
										</div>
										<div class="amount_btn">
											<button type="button" onClick="update_selected(1)" class="cus_btn">Update Selected</button>
											<button type="button" onClick="update_all(2)" class="cus_btn">Update All</button>
										</div>
									</div>
									<div class="table-responsive">
										<table id="" class="table table-bordered table-hover text-nowrap domesticdata">
											<thead>
												<tr> 
													<th class="no-sort"><input type="checkbox" id="domrcheckedAll"> Select All</th>
													<th>Flight Logo</th>
													<th>Flight Code</th>  
													<th>Service Fee/Markup Detail</th>
													<th>Markup Type</th>
													<th>Delete</th>
												</tr> 
											</thead>
											<tbody class="tdata booking_data ">
											<?php
											foreach(\App\Markup::where('user_type','b2c')->where('flight_type','domestic')->get() as $list){
											?>
												<tr id="id_{{@$list->id}}"> 
													<td><input class="checkSingle domesticids" type="checkbox" name="allcheckbox[]" value="{{$list->id}}"></td>
													<td><img width="30" src="{{URL::to('/public/img/airline/')}}/{{$list->flight_code}}.gif" alt=""/></td>
													<td>{{$list->flight_code}}</td>
													<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b>{{$list->service_fee}}</b></td>
													<td>{{$list->service_type}}</td>
													<td><a href="javascript:;" onClick="deleteAction({{@$list->id}}, 'markups')"><i class="fa fa-trash"></i></a></td>
												</tr> 
											<?php } ?>
													
											</tbody>
										</table>
									</div>
									{{ Form::close() }}
								</div>
								<div class="tab-pane" id="international" role="tabpanel" aria-labelledby="international-tab">
								 {{ Form::open(array('url' => 'admin/flightmarkup/update', 'name'=>"add-international", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
								  <input type="hidden" value="international" name="markup_tpe"/>
								 <input type="hidden" value="1" name="update_type" id="update_type"/>
									<!--<div class="commission_radio">
										<div class="radio">
											<label>
												<input type="radio" value="1" class="selectinternationalcommission" name="commission" checked /> Commission
											</label>
										</div>
										<div class="radio">
											<label>
												<input type="radio" value="2" class="selectinternationalcommission" name="commission" /> Non-Commission
											</label>
										</div>  
									</div>-->
									<div class="commission_amount"> 
										<div class="usertype_select">
											<ul> 
												<li>
												<input type="hidden" value="b2c" name="user_type"/>
													<a class="dropdown-toggle btn btn-block btn-outline-primary btn-sm is_not_selected_invoice" data-toggle="dropdown" href="#" aria-expanded="false"><i class="fa fa-plus"></i> User Type <span class="caret"></span></a>
													<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 31px, 0px);">
													  <a class="dropdown-item" tabindex="-1" href="{{URL::to('/admin/flightmarkup')}}">B2C Markup</a>
													  <a class="dropdown-item" tabindex="-1" href="{{URL::to('/admin/flightmarkup')}}?type=b2b">B2B Markup</a>
													</div>	 										
												</li>
											</ul>
										</div>
										<div class="amount_field">
											<input type="text" class="form-control" id="service_fee" name="amount" placeholder="Amount (Rs.)"/>
										</div>
										<div class="markuptype_field"> 
											<select id="service_type" class="form-control" name="service_type">
												<option value="">Markup Type</option>
												<option value="percentage">Percentage</option>
												<option value="fixed">Fixed</option>
											</select>
										</div>
										<div class="amount_btn">
											<button type="button" onClick="international_update_selected(1)" class="cus_btn">Update Selected</button>
											<button type="button" onClick="international_update_all(2)" class="cus_btn">Update All</button>
										</div>
									</div>
									<div class="table-responsive">
										<table id="" class="table table-bordered table-hover text-nowrap internationaldata">
											<thead>
												<tr> 
													<th class="no-sort"><input type="checkbox" id="intercheckedAll"> Select All</th>
													<th>Flight Logo</th>
													<th>Flight Code</th>  
													<th>Service Fee/Markup Detail</th>
													<th>Delete</th>
												</tr> 
											</thead>
											<tbody class="tdata booking_data">
											<?php
											foreach(\App\Markup::where('user_type','b2c')->where('flight_type','international')->get() as $llist){
											?>
												<tr id="id_{{@$llist->id}}">  
								
													<td><input class="checkSingle internationalids" type="checkbox" name="allcheckbox[]" value="{{$llist->id}}"></td>
													<td><img width="30" src="{{URL::to('/public/img/airline/')}}/{{$llist->flight_code}}.gif" alt=""/></td>
													<td>{{$llist->flight_code}}</td>
													<td><i class="fa fa-rupee-sign" style="vertical-align: middle;"></i> <b>{{$llist->service_fee}}</b></td>
													<td><a href="javascript:;" onClick="deleteAction({{@$llist->id}}, 'markups')"><i class="fa fa-trash"></i></a></td>
												</tr> 
											<?php } ?>
													
											</tbody>
										</table>
									</div>
										{{ Form::close() }}
								</div>
							</div>
						</div>	
					</div>	
				</div>	
			</div>
		</div>
	</section>
</div>
<script>
function update_selected(val){
	$('#domestic #update_type').val(val);
	var flag = true;
	if($('.domesticids:checkbox:checked').length == 0){
		flag = false;
		alert('Please select atleast one checkbox');
	}
	else if($('#domestic #service_fee').val() == ''){
		flag = false;
			alert('Please enter an amount');
	}
	else if($('#domestic #service_type option:selected').val() == ''){
		flag = false;
			alert('Please Select Markup Type');
	}
	if(flag){
			 $("form[name='add-domestic']").submit();
			return true; 
		}

}

function update_all(val){
	$('#domestic #update_type').val(val);
	var flag = true;
	 if($('#domestic #service_fee').val() == ''){
		flag = false;
			alert('Please enter an amount');
	}
	else if($('#domestic #service_type option:selected').val() == ''){
		flag = false;
			alert('Please Select Markup Type');
	}
	if(flag){
			 $("form[name='add-domestic']").submit();
			return true; 
		}

}

function international_update_selected(val){
	$('#international #update_type').val(val);
	var flag = true;
	if($('.internationalids:checkbox:checked').length == 0){
		flag = false;
		alert('Please select atleast one checkbox');
	}
	else if($('#international #service_fee').val() == ''){
		flag = false;
			alert('Please enter an amount');
	}
	else if($('#international #service_type option:selected').val() == ''){
		flag = false;
			alert('Please Select Markup Type');
	}
	if(flag){
			 $("form[name='add-international']").submit();
			return true; 
		}

}

function international_update_all(val){
	$('#international #update_type').val(val);
	 var flag = true;
	 if($('#international #service_fee').val() == ''){
		flag = false;
			alert('Please enter an amount');
	}
	else if($('#international #service_type option:selected').val() == ''){
		flag = false;
			alert('Please Select Markup Type');
	}
	if(flag){
			 $("form[name='add-international']").submit();
			return true; 
		} 

}

$(document).delegate('.selectcommission', 'change', function(){
	var val = $(this).val();
	$('#loader').show();
	$.ajax({
		url: "{{ route('admin.flightmarkup.commission') }}",
			type: 'GET',
			data: {com_type:val,markup_tpe:$('#domestic input[name="markup_tpe"]').val()},
			success: function( data ){
				$('#loader').hide();
				$('.domesticdata').html(data);
			}
	});
});
$(document).delegate('.selectinternationalcommission', 'change', function(){
	var val = $(this).val();
	$('#loader').show();
	$.ajax({
		url: "{{ route('admin.flightmarkup.commission') }}",
			type: 'GET',
			data: {com_type:val,markup_tpe:$('#international input[name="markup_tpe"]').val()},
			success: function( data ){
				$('#loader').hide();
				$('.internationaldata').html(data);
			}
	});
});
</script>
@endsection