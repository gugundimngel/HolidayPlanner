@extends('layouts.admin')
@section('title', 'Agent Offers')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6 wd50_xs">
					<h1 class="m-0 text-dark">Agent Offers</h1>
				</div>
				<div class="col-sm-6 wd50_xs">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{URL::to('/admin/dashboard')}}">Home</a></li>
						<li class="breadcrumb-item active">Agent Offers</li>
					</ol>
				</div>
			</div>
		</div>
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
					<div class="card"> 
						<div class="card-header">   
							<div class="card-title">
								<a href="{{route('admin.agentoffers.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Offers</a> 
							</div>			
						</div> 
						<div class="card-body">
							<div class="table-responsive">
								<table id="" class=" table table-bordered table-hover text-nowrap">
								<thead>
									<tr>
										<th class="">Offer Type</th>
										<th class="">Type</th>
										<th class="">Name</th>
										<th class="">Image</th>
										<th class="">Url</th>
										<th class="">Price</th>									
										<th class="no-sort">Action</th>
									</tr> 
								</thead>
								@if(@$totalData !== 0)
							    <tbody class="tdata">
									
									@foreach (@$lists as $list)	
									<tr id="id_{{@$list->id}}"> 
										<td>{{ @$list->offer_type }}</td> 
										<td>{{ @$list->type }}</td> 
										<td>{{ @$list->name }}</td> 
										<td>
										@if(@$list->image != '')
											<img width="60" src="{{URL::to('/public/img/cmspage')}}/{{@$list->image}}" class="img-avatar"/>
									@endif
										</td> 
										<td>{{ @$list->url }}</td> 
										<td style="text-align:right;font-weight:600;">&#8377; {{ @$list->price }}</td> 
										<td>
											<div class="nav-item dropdown action_dropdown cus_action_btn">
												<a class="nav-link dropdown-toggle action_btn btn btn-primary btn-rounded btn-xs" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
												<div class="dropdown-menu">
													<a href="{{URL::to('/admin/agent-offers/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="fa fa-edit"></i> Edit</a>
													<a href="javascript:;" onClick="deleteAction({{@$list->id}}, 'agent_offers')"><i class="fa fa-trash"></i> Delete</a>
												</div>
											</div> 
										</td>
									</tr>
									@endforeach	
								</tbody> 
								
								@else
									<tbody>
										<tr>
											<td colspan="6">
												{{config('constants.no_data')}}
											</td>
										</tr>
									</tbody>
								@endif	
							</table>
						</div>	
					</div>	
					<div class="card-footer">
						 {!! $lists->appends(\Request::except('page'))->links() !!} 
					</div>
				</div>	
			</div>
		</div>
	</section>
</div>
@endsection