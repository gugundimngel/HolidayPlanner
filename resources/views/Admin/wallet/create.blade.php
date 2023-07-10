@extends('layouts.admin')
@section('title', 'Create Debit/Credit')
 
@section('content')
 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Create Debit/Credit</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Create Debit/Credit</li>
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
						<h3 class="card-title">Create Debit/Credit</h3>
					  </div> 
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'admin/wallet/store', 'name'=>"add-flights", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
					   
						<div class="card-body">
							<div class="form-group" style="text-align:right;">
								<a style="margin-right:5px;" href="{{route('admin.wallet.crdr')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>  
								{{ Form::button('<i class="fa fa-save"></i> Save', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-flights")' ]) }}
							</div>
							<div class="form-group row"> 
								<label for="name" class="col-sm-2 col-form-label">Agent <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
								<select id="agent_id" name="agent_id" data-valid="required" class="form-control select2_name" style="width: 100%;">
									<option value="">Select Agent</option>
									@foreach($allusers as $clist) 
										<option @if(@$agent_id == @$clist->id) selected @endif value="{{@$clist->id}}">{{@$clist->first_name}} {{@$clist->last_name}} ({{str_pad(@$clist->id, 5, '0', STR_PAD_LEFT)}})</option>
									@endforeach
								</select>
								</div>   
							</div>
							<div class="form-group row"> 
								<label for="type" class="col-sm-2 col-form-label">Type <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
								<select id="type" name="type" data-valid="required" class="form-control select2_source" style="width: 100%;">
									<option value="">Select Type</option>
									<option @if(@$type == 'topup') selected @endif value="credit">Cr</option>
									<option @if(@$type == 'deduct') selected @endif value="debit">Dr</option>
									
								</select>
								</div> 
							</div>
							<div class="form-group row"> 
								<label for="amount" class="col-sm-2 col-form-label">Amount <span style="color:#ff0000;">*</span></label>
								<div class="col-sm-10">
								<input type="text" name="amount" class="form-control" data-valid="required">
								</div> 
							</div>
							<div class="form-group row"> 
								<label for="amount" class="col-sm-2 col-form-label">Remark </label>
								<div class="col-sm-10">
								<textarea class="form-control" name="remark"></textarea>
							</div>
							<div class="form-group float-right">
								{{ Form::button('<i class="fa fa-save"></i> Save', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-flights")' ]) }}
							</div> 
						</div>  
					  {{ Form::close() }}
					</div>	   
				</div>	
			</div>
		</div>
	</section>
</div>
<script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>
@endsection