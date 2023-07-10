@extends('layouts.admin')
@section('title', 'Users')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Visa</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Visa</li>
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
					<div class="card">
						<div class="card-header">  
							<div class="card-tools card_tools">
								<a href="javascript:;" data-toggle="modal" data-target="#amnetsearch_modal" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</a>
							</div>
							<div class="print_export">
								<ul>
									<li class="print"><a dataurl="" href="{{URL::to('/admin/visa/add') }}" class="print_myinvoice"><i class="fas fa-plus"></i> Add Visa</a></li>
									<li class="print"><a dataurl="" href="javascript:;" class="print_myinvoice"><i class="fas fa-print"></i> Print</a></li>
									<li class="export"><a href="{{URL::to('/admin/excel_users_log')}}?first_name={{@$_GET['first_name']}}&last_name={{@$_GET['last_name']}}&from={{@$_GET['from']}}&to={{@$_GET['to']}}&email={{@$_GET['email']}}&status={{@$_GET['status']}}"><i class="fas fa-file-excel"></i> Export</a></li>
								</ul>
							</div>
						</div> 
						
						<div class="card-body table-responsive p-0">
							<table id="departurecity_table" class="table table-bordered table-hover text-nowrap">
							  <thead>
								<tr>
								  <th>ID</th>
								  <th>Visa Title</th>
								  <th>Visa Type</th>
								  <th>Country From</th> 
								  <th>Country To</th> 
								  <th>Is Popular</th>
								  <th>Status</th>
								  <th>Action</th>
								</tr> 
							  </thead>
							  <tbody class="tdata">	 
							    @if(@$visas)
							    @foreach($visas as $key => $value)
							  <tr>
							    <td>{{ $key+1 }}</td>
							    <td>{{ $value['visa_title'] ?? '' }}</td>
							    <td>{{ ucfirst($value['visa_type']) ?? '' }}</td>
							    <td>{{ $value['country_from'] ?? '' }}</td>
							    <td>{{ $value['country_to'] ?? '' }}</td>
							    <td><input data-id="{{@$value['id']}}"  data-popular="{{@$value['Is_Popular']}}" data-col="is_popular" data-table="packages" class="change_popular_status" value="1" type="checkbox" name="is_popular" {{ (@$value['Is_Popular'] == 1 ? 'checked' : '')}} data-bootstrap-switch></td>
							    <td><input data-id="{{@$value['id']}}"  data-status="{{@$value['status']}}" data-col="status" data-table="packages" class="change_status" value="1" type="checkbox" name="status" {{ (@$value['status'] == 1 ? 'checked' : '')}} data-bootstrap-switch></td>
                                <td>
									<div class="nav-item dropdown action_dropdown">
										<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
										<div class="dropdown-menu">
										 <a href="{{URL::to('/admin/visa/edit/'.base64_encode(convert_uuencode(@$value['id'])))}}"><i class="fa fa-edit"></i> Edit</a>
										 <a style="cursor: pointer" class="delete_visa" data-id="{{ $value['id'] }}"><i class="fa fa-trash"></i> Delete</a>
										 <!--<a href="{{URL::to('/admin/visa/duplicate/'.base64_encode(convert_uuencode(@$list->id)))}}" ><i class="fa fa-clone"></i> Clone</a>-->
										 
										</div> 
									</div>								   
								  </td>							    
							</tr>
							    @endforeach
							    @endif
							    
							</table>
							<div class="card-footer">
							    <tr>
							    @if(@$visas)
							    @foreach($visas as $key => $value)
							    <td>{{$key+1}}</td>
							    
							    @endforeach
							    @endif
							    
							</tr>
							 </div>
						  </div>
					</div>	
				</div>	
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="amnetsearch_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				  <h4 class="modal-title">Search</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
			</div>
			
			<form action="{{URL::to('/admin/users')}}" method="get">
				<div class="modal-body">
					<div class="row">
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="first_name" class="col-sm-2 col-form-label">First Name</label>
								<div class="col-sm-10">
									{{ Form::text('first_name', Request::get('first_name'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'First Name', 'id' => 'first_name' )) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
								<div class="col-sm-10">
									{{ Form::text('last_name', Request::get('last_name'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Last Name', 'id' => 'last_name' )) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="ref" class="col-sm-2 col-form-label">From Date</label>
								<div class="col-sm-10">
									{{ Form::text('from', Request::get('from'), array('class' => 'form-control commodate', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'From Date', 'id' => 'from' )) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="ref" class="col-sm-2 col-form-label">To Date</label>
								<div class="col-sm-10">
									{{ Form::text('to', Request::get('to'), array('class' => 'form-control commodate', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'To Date', 'id' => 'to' )) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="email" class="col-sm-2 col-form-label">Email</label>
								<div class="col-sm-10">
									{{ Form::text('email', Request::get('email'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Email', 'id' => 'email' )) }}
								</div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="ref" class="col-sm-2 col-form-label">Status</label>
								<div class="col-sm-10">
									<select class="form-control" name="status">
										<option value=""></option>
										<option value="1" @if(Request::get('status') == 1) selected @endif >Active</option>
										<option value="0" @if(Request::get('status') == 0) selected @endif >Inactive</option>
										
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					{{ Form::submit('Search', ['class'=>'btn btn-primary' ]) }}
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
@section("scripts")
<script>
$('.change_popular_status').on('switchChange.bootstrapSwitch', function (event, state) {
    console.log(state);
    $id = $(this).data('id');
    if(state === true){
        $state = 1;
    }else{
        $state = 0;
    }
    $.ajax({
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
		url:'<?php echo \URL::to('/admin')?>/visa/popular_status',
        type:'post',
		data:{id:$id,state:$state,type:'popular'},
		success:function(res){
			Swal.fire(res.visa +' popular status updated.');
		}
	});
}); 

$('.change_status').on('switchChange.bootstrapSwitch', function (event, state) {
    $id = $(this).data('id');
    if(state === true){
        $state = 1;
    }else{
        $state = 0;
    }
    $.ajax({
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
		url:'<?php echo \URL::to('/admin')?>/visa/popular_status',
        type:'post',
		data:{id:$id,state:$state,type:'status'},
		success:function(res){
			Swal.fire(res.visa +' status updated.');
		}
	});
});
    $(".delete_visa").on("click",function(){
        $id = $(this).data('id');
        Swal.fire({
          title: 'Delete Visa?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Delete'
        }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        		url:'<?php echo \URL::to('/admin')?>/visa/delete',
                type:'post',
        		data:{id:$id},
        		success:function(res){
        		    if(res.status === true){
            			Swal.fire(
                          'Deleted!',
                          'success'
                        );
        		        location.reload(true);
        		    }else{
        		        Swal.fire(
                          'Failed!',
                          'Something went wrong.',
                          'error'
                        );
        		    }
        		}
        	});
          }
        })
        
    });
</script>
@endsection