@extends('layouts.admin')
@section('title', 'Hotel Markup')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Hotel Markup</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Hotel Markup</li>
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
								<a href="{{route('admin.hotelmarkup.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Markup</a> 
							</div> 
							
						</div> 
						<div class="card-body">
							
							<div class="tab-content" id="custom-tab-content">
								<div class="tab-pane active show" id="domestic" role="tabpanel" aria-labelledby="domestic-tab">
								<div class="commission_amount">
										
									</div>
									<div class="table-responsive">
										<table id="" class="table table-bordered table-hover text-nowrap domesticdata">
											<thead>
												<tr> 
													
													<th>User Type</th>
													<th>Markup Type</th>  
													<th>Amount</th>
													<th>Amount Type</th>
													
													<th>City</th>
													<th>Hotel</th>
													<th>Action</th>
												</tr> 
											</thead>
											<tbody class="tdata">
											<?php
											foreach($hotellist as $list){
												$cname = '';
												$hname = '';
												if($list->markup_type == 'city_wise'){
													$hcity = \App\HotelCity::where('city_code', '=', $list->city_code)->first();
													$cname = @$hcity->name;
												}else{
													$hcity = \App\HotelData::where('hotel_code', '=', $list->hotel_code)->first();
													$hname = @$hcity->hotel_name;
												}
												
											?>
												<tr id="id_{{@$list->id}}">
													<td>{{@$list->user_type}}</td>
													<td>{{str_replace('_',' ', $list->markup_type)}}</td>
													<td>{{@$list->markup_fee}}</td>
													<td>{{ucfirst($list->amount_type)}}</td>
													
													<td>{{@$cname}}</td>
													<td>{{@$hname}}</td>
													<td>
													<div class="nav-item dropdown action_dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
											<div class="dropdown-menu">
											  <a href="{{URL::to('/admin/hotelmarkup/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-edit"></i> Edit</a>
											 <a href="javascript:;" onClick="deleteAction({{@$list->id}}, 'hotel_markups')"><i class="fa fa-trash"></i> Delete</a>	
											</div> 
										</div> 
													</td>
												</tr>
											<?php } ?>
													
											</tbody>
										</table>
										<div class="card-footer">
							 {{ $hotellist->appends(\Request::except('page'))->render() }}
							 </div>
									</div>
									
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