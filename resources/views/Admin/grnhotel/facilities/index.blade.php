@extends('layouts.admin')
@section('title', 'Hotel Facilities')

@section('content')
	<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Hotel Facilities</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Hotel Facilities</li>
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
										<div class="col-md-4">
											<a href="javascript:;" data-toggle="modal" data-target="#hotelsearch_modal" class="btn btn-primary"><i class="fas fa-search"></i></a>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body table-responsive">
								<table id="" class="table table-bordered table-hover text-nowrap">
									<thead>  
										<tr>
											<th>Name</th>
											<th>Icon</th>
											<th class="no-sort">Action</th>
										</tr> 
									</thead> 
									<tbody class="tdata">	
									@if(@$totalData !== 0)
									@foreach (@$hotelcodes as $list)	
									<tr id="id_{{@$list->id}}"> 
									  <td>{{@$list->name}}</td> 
									  <td>@if(@$list->type == 'image')
										  @if(@$list->icon != '')
											<img width="30" src="{{URL::to('/public/img/hotel_img')}}/{{@$list->icon}}" class="img-avatar"/>
										@endif
										@else
											<i class="{{@$list->icon}}"></i>
										@endif
										</td> 
									  <td>
										<div class="nav-item dropdown action_dropdown">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
											<div class="dropdown-menu">
											  <a href="{{URL::to('/admin/grnhotelfacilties/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-edit"></i> Edit</a>
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