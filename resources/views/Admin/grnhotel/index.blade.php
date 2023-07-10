@extends('layouts.admin')
@section('title', 'GRN Hotel')

@section('content')
<style>
.ui-autocomplete-loading { background:url('{{URL::to('/public/img/loader.gif')}}') no-repeat right center;background-size: 20px }
</style>
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
					<div class="custom-error-msg">
				</div>
					<!-- Flash Message End -->
				</div>
				<div class="col-md-12">
					<div class="card">
						<div class="dataTables_wrapper dt-bootstrap4">
							<div class="card-header">  							
								<div class="card-tools card_tools">
									<div class="row">
										<div class="col-md-12">
											<a href="javascript:;" class="btn btn-primary filter_btn"><i class="fas fa-search"></i> Filter</a>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body table-responsive">
							<div class="filter_panel" style="display:none;">
								<h4>Search By Details</h4>								
								<form action="{{URL::to('/admin/grnhotel')}}" method="get">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="hotel_code" class="col-form-label">Hotel Code</label>
												{{ Form::text('hotel_code', Request::get('hotel_code'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Agent ID', 'id' => 'hotel_code' )) }}
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="hotel_name" class="col-form-label">Hotel Name</label>
												{{ Form::text('hotel_name', Request::get('hotel_name'), array('class' => 'form-control agent_hotel_name', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Company Name', 'id' => 'hotel_name', 'onkeyup' => "suggest(this.value)" )) }}
											
											</div>
										</div>
										
										<div class="col-md-4">
											<div class="form-group">
												<label for="city" class="col-form-label">City</label>
												{{ Form::text('city', Request::get('city'), array('class' => 'form-control agent_city', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'City', 'id' => 'city', 'onkeyup' => "suggestcity(this.value)" )) }}
											</div>
										</div>
									<input type="hidden" name="cid" id="cid">
									</div>
									<div class="row">
										<div class="col-md-12 text-center">
											{{ Form::submit('Search', ['class'=>'btn btn-primary btn-theme-lg' ]) }}
										</div>
									</div>
								</form>
							</div>
								<table id="" class="table table-bordered table-hover text-nowrap">
									<thead>  
										<tr>
											<th>Hotel Name</th>
											<th>Hotel Code</th>
											<th class="no-sort">Action</th>
										</tr> 
									</thead> 
									<tbody class="tdata">	
									@if(@$totalData !== 0)
									@foreach (@$hotelcodes as $list)	
									<tr id="id_{{@$list->id}}"> 
									  <td>{{ @$list->name }}</td> 
									  <td>{{ @$list->hotel_code == "" ? config('constants.empty') : str_limit(@$list->hotel_code, '50', '...') }}</td> 
									  <td>
										<div class="nav-item dropdown action_dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
											<div class="dropdown-menu">
											  <a href="{{URL::to('/admin/grnhotel/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-edit"></i> Edit</a>
											</div> 
										</div>
									  </td>
									</tr>	
									@endforeach						
								  </tbody>
								  @else 
									<tbody>
										<tr>
											<td style="text-align:center;" colspan="3">
												No Record found
											</td>
										</tr>
									</tbody> 
									@endif
								</table>
								<div class="card-footer">
							 {{ $hotelcodes->appends(\Request::except('page'))->render() }}
							 </div>
							</div>
						</div> 
					</div>
				</div>	
			</div>
		</div>
	</section>
</div>
@endsection
@section('scripts')
<script>
function suggest(inputString) {
$( ".agent_hotel_name" ).autocomplete({
	autoFocus: true,	
	minLength : 2,
	source : function(request, response) {
    $.ajax({
        type: "GET",
        url: "{{URL::to('/')}}/admin/gethotel",
        dataType : "json",
        cache : false,
        data: {likewith : 'agent_hotel_name', likevalue: inputString},
        success: 
            function(data){
                var all_l=[];
                for(var i=0;i<data.length;i++)
                {
                    var city_name=data[i].agent_hotel_name; 
                    var id=data[i].id; 
                    all_l.push({ "label": city_name, "value": city_name,  } );
                }
                response(all_l);
            }			
        });	  
    }, 
});    

}

function suggestcity(inputString) {
$( ".agent_city" ).autocomplete({
	autoFocus: true,	
	minLength : 2,
	source : function(request, response) {
    $.ajax({
        type: "GET",
        url: "{{URL::to('/')}}/admin/getcity",
        dataType : "json",
        cache : false,
        data: {likewith : 'agent_city', likevalue: inputString},
        success: 
            function(data){
                var all_l=[];
                for(var i=0;i<data.length;i++)
                {
                    var city_name=data[i].agent_city; 
                    var id=data[i].id; 
                    all_l.push({ "label": city_name, "value": id,  } );
                }
                response(all_l);
            }			
        });	  
    }, 
});    

}
jQuery(document).ready(function($){
	
    $('.agent_city').on('autocompleteselect', function (e, ui) {
		console.log(ui.item.label);
        $('#cid').val(ui.item.value);
        $('.agent_city').val(ui.item.label);
    });
	$('.card .card_tools .filter_btn').on('click', function(){
			$('.card .card-body .filter_panel').slideToggle();
		});
});
</script>
@endsection