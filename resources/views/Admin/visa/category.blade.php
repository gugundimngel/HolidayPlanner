@extends('layouts.admin')
@section('title', 'Users')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Visa Category</h1>
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
							<div class="print_export">
								<ul>
									<li class="print"><a dataurl="" href="#" data-toggle="modal" data-target="#add_category" class="print_myinvoice"><i class="fas fa-plus"></i> Add Category</a></li>
								</ul>
							</div>
						</div> 
						<div class="card-body table-responsive p-0">
							<table id="departurecity_table" class="table table-bordered table-hover text-nowrap">
							  <thead>
								<tr>
								  <th>ID</th>
								  <th>Category Name</th>
								  <th>Action</th>
								</tr> 
							  </thead>
							  <tbody class="tdata">	 
							    @if(@$categories)
							    @foreach($categories as $key => $value)
							  <tr>
							    <td>{{ $key+1 }}</td>
							    <td>{{ $value->name ?? '' }}</td>
                                <td>
									<div class="nav-item dropdown action_dropdown">
										<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
										<div class="dropdown-menu">
										 <a href="#" data-toggle="modal" data-target="#add_category" data-id="{{ $value->id }}" data-name="{{$value->name}}" class="edit_category"><i class="fa fa-edit"></i> Edit</a>
										 <a style="cursor: pointer" class="delete_category" data-id="{{ $value->id }}"><i class="fa fa-trash"></i> Delete</a>
										</div> 
									</div>								   
								  </td>							    
							</tr>
							    @endforeach
							    @endif
							    
							</table>
						  </div>
					</div>	
				</div>	
			</div>
		</div>
	</section>
	<div class="modal fade" id="add_category">
    	<div class="modal-dialog modal-lg">
    		<div class="modal-content">
    			<div class="modal-header">
    				  <h4 class="modal-title">Add Category</h4>
    				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    					<span aria-hidden="true">&times;</span>
    				  </button>
    			</div>
    			
    			<form action="{{URL::to('/admin/visa/category/add')}}" method="post">
    			    @csrf
    			    <input type="hidden" name="category_id" value="" id="category_id">
    				<div class="modal-body">
    					<div class="row">
    						<div class="col-md-6">
    							<div class="form-group row">
    								<label for="category_name" class="col-sm-6 col-form-label">Category Name</label>
    								<div class="col-sm-10">
    									{{ Form::text('name', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Category Name', 'id' => 'category_name' )) }}
    								</div>
    							</div>
    						</div>
    					</div>
    				</div>
    				<div class="modal-footer">
    					{{ Form::submit('Save', ['class'=>'btn btn-primary' ]) }}
    				</div>
    			</form>
    		</div>
    	</div>
    </div>
</div>
@endsection
@section("scripts")
<script>
    $(".edit_category").on('click',function(){
        $id = $(this).data('id');
        $name = $(this).data('name');
        console.log($id);
        $("#category_id").val($id);
        $("#category_name").val($name);
    });

    $(".delete_category").on("click",function(){
        $id = $(this).data('id');
        Swal.fire({
          title: 'Delete Category?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Delete'
        }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        		url:'<?php echo \URL::to('/admin')?>/visa/category/delete',
                type:'post',
        		data:{id:$id},
        		success:function(res){
        		    
        		    if(res.status === true){
        		        location.reload(true);
            			Swal.fire(
                          'Deleted!',
                          'Your file has been deleted.',
                          'success'
                        );
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
