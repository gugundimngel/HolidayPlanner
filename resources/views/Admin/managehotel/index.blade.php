@extends('layouts.admin')
@section('title', 'Manage Hotel')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Manage Hotel</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Manage Hotel</li>
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
					<div class="custom-error-msg">
				</div>
					<!-- Flash Message End -->
				</div>
				<div class="col-md-12">
					<div class="card">
						<div class="dataTables_wrapper dt-bootstrap4">
							<div class="card-header">  
								<!--<div class="dataTables_length" id="hotel_length">
									<label>Show <select name="hotel_length" aria-controls="example1" class="custom-select custom-select-sm form-control form-control-sm">
										<option value="10">10</option>
										<option value="25">25</option>
										<option value="50">50</option>
										<option value="100">100</option></select> entries</label>
								</div>	-->
								<div class="card-title">
									<a href="{{route('admin.managehotel.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Hotel</a>
									 <a style="display:none;" class="btn btn-primary displayifselected" href="javascript:;" onClick="deleteAllAction('hotels')"><i class="fa fa-trash"></i> Delete</a>
								</div>
								<div class="card-tools card_tools">
									<!--<div class="input-group input-group-sm" style="width: 150px;">
										<input type="text" name="table_search" class="form-control float-right" placeholder="Search">
										<div class="input-group-append">
											<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
										</div>
									</div>-->
									<div class="row">
									
									<div class="col-md-4">
										<a href="javascript:;" data-toggle="modal" data-target="#hotelsearch_modal" class="btn btn-primary"><i class="fas fa-search"></i></a>
									</div>
								</div>
								</div>
							</div>
							<div class="card-body table-responsive">
								<table id="hoteltable" class="table table-bordered table-hover text-nowrap">
								  <thead>  
									<tr>
									<th class="no-sort"><input type="checkbox" id="checkedAll"></th>
									  <th>ID</th>
									  <th>Hotel Name</th>
									  <th class="no-sort">Destination</th>
									  <th class="no-sort">Star Rating</th>
									  <th class="no-sort">Email</th>
									  <th class="no-sort">Phone</th>
									  <th class="no-sort">Added By</th>
									  <th class="no-sort">Action</th>
									</tr> 
								  </thead> 
								   <tbody class="tdata">	
									@if(@$totalData !== 0)
									@foreach (@$lists as $list)	
									<tr id="id_{{@$list->id}}"> 
									<td><input class="checkSingle" type="checkbox" name="allcheckbox" value="{{@$list->id}}"></td>
									  <td>{{ @$list->id == "" ? config('constants.empty') : str_limit(@$list->id, '50', '...') }}</td> 
									  <td>{{ @$list->name == "" ? config('constants.empty') : str_limit(@$list->name, '50', '...') }}</td> 
									  <td>{{ @$list->destination == "" ? config('constants.empty') : str_limit(@$list->locations->name, '50', '...') }}</td> 
									  <td><span class='rating_star'>
										<?php 
											$star_rating = $list->hotel_category;
										  for ($i=1; $i<=$star_rating; $i++) {
											$ID = "<i class='fa fa-star'></i>";	
												echo $ID;
											}
											?></span>
									  </td> 
									  <td>{{ @$list->email == "" ? config('constants.empty') : str_limit(@$list->email, '50', '...') }}</td> 
									  <td>{{ @$list->help_line_no == "" ? config('constants.empty') : str_limit(@$list->help_line_no, '50', '...') }}</td> 
									  <td>{{ @$list->user->company_name == "" ? config('constants.empty') : str_limit(@$list->user->company_name, '50', '...') }}</td>	 
									{{--<td>{{ @$list->usertype->name == "" ? config('constants.empty') : str_limit(@$list->usertype->name, '50', '...') }}</td> --}}
									  <td>
										<div class="nav-item dropdown action_dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
											<div class="dropdown-menu">
											  <a href="{{URL::to('/admin/hotel/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-edit"></i> Edit</a>
											  <a href="{{URL::to('/admin/hotel/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-eye"></i> View</a>
											 
											</div>
										</div>
									  </td>
									</tr>	
									@endforeach						
								  </tbody>
								  @else 
								  <tbody>
										<tr>
											<td style="text-align:center;" colspan="8">
												No Record found
											</td>
										</tr>
									</tbody>
								@endif 
								</table>
								{{-- {!! $lists->appends(\Request::except('page'))->render() !!} --}}
							</div>
						</div> 
					</div>
				</div>	
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="hotelsearch_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				  <h4 class="modal-title">Hotel Search</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
			</div>
			<form action="{{route('admin.managehotel.index')}}" method="get">
				<div class="modal-body"> 
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="dest_id" class="col-sm-2 col-form-label">Hotel ID</label>
								<div class="col-sm-10">
									{{ Form::text('hotel_id', Request::get('hotel_id'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Hotel ID', 'id' => 'hotel_id' )) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="name" class="col-sm-2 col-form-label">Hotel Name</label>
								<div class="col-sm-10">
									{{ Form::text('name', Request::get('name'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Hotel Name', 'id' => 'name' )) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="name" class="col-sm-2 col-form-label">Destination</label>
								<div class="col-sm-10">
								<?php
									$desttype = Request::get('destination');
									
								?>
									<select class="form-control" name="destination">
										<option value="">Select</option>
										@foreach(\App\Destination::where('user_id', '=', Auth::user()->id)->with([ 'myloc'])->get() as $dlist)
								
											<option value="{{$dlist->dest_id}}" @if($desttype == $dlist->dest_id) selected @endif>{{ $dlist->myloc != null ? $dlist->myloc->name : 'N/A' }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>	
						<div class="col-md-6">
							<div class="form-group row">
								<label for="stars" class="col-sm-2 col-form-label">Hotel Stars</label>
								<div class="col-sm-10">
								<?php
									$stars = Request::get('stars');
								?>
										<select name="stars" data-valid="required" id="stars" class="form-control" autocomplete="new-password">
										<option value="">--Hotel Star--</option>
										<?php 
									  for ($i=1; $i<=7; $i++) {
										$ID = '';	
											for($j=0;$j<$i;$j++){
												$ID .= "*";
											}
											echo "<option value='".$i."' ".($stars == $i ? 'selected': '').">".$ID."</option>";
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="category" class="col-sm-2 col-form-label">Hotel Category</label>
								<div class="col-sm-10">
								<?php
									$category = Request::get('category');
								?>
										<select name="category" id="category" class="form-control" autocomplete="new-password">
										<option value="">--Hotel Category--</option>
										<option value="Hotel" @if($category == "Hotel") selected @endif>Hotel</option>
										<option value="Cottage" @if($category == "Cottage") selected @endif >Cottage</option>
										<option value="Resort" @if($category == "Resort") selected @endif>Resort</option>
										<option value="Motel" @if($category == "Motel") selected @endif>Motel</option>
										<option value="Boutique Hotel" @if($category == "Boutique Hotel") selected @endif>Boutique Hotel</option>
										<option value="Lodge" @if($category == "Lodge") selected @endif>Lodge</option>
										<option value="Villa" @if($category == "Villa") selected @endif>Villa</option>
										<option value="Apartment" @if($category == "Apartment") selected @endif>Apartment</option>
										<option value="Camp" @if($category == "Camp") selected @endif>Camp</option>
										<option value="Inn" @if($category == "Inn") selected @endif>Inn</option>
										<option value="Tent" @if($category == "Tent") selected @endif>Tent</option>
										<option value="Palace" @if($category == "Palace") selected @endif>Palace</option>
										<option value="Tented Safari Camp" @if($category == "Tented Safari Camp") selected @endif>Tented Safari Camp</option>
										<option value="Business Hotel" @if($category == "Business Hotel") selected @endif>Business Hotel</option>
										</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
				  <a href="{{route('admin.managehotel.index')}}" class="btn btn-default" >Reset</a>
				  <button type="submit" id="" class="btn btn-primary">Search</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection