@extends('layouts.admin')
@section('title', 'Service Fees')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Service Fees</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Service Fees</li>
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
							 
						</div> 
						<div class="card-body">
							<div class="commission_amount"> 
								{{ Form::open(array('url' => 'admin/servicefees/store', 'name'=>"add-fees", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}  
								<div class="amount_field">
									<input type="text" value="{{@App\MyConfig::where('meta_key','service_fees')->first()->meta_value}}" class="form-control" id="service_fee" name="fee[service_fees]" placeholder="Amount (Rs.)"/>
								</div>  
								<div class="markuptype_field"> 
									<select id="service_type" class="form-control" name="fee[service_type]">
										<option value="">Type</option>
										<option value="percentage" <?php if(@App\MyConfig::where('meta_key','service_type')->first()->meta_value =='percentage'){ echo 'selected'; } ?>>Percentage</option>
										<option value="fixed" <?php if(@App\MyConfig::where('meta_key','service_type')->first()->meta_value =='fixed'){ echo 'selected'; } ?>>Fixed</option>
									</select>
								</div>
								<div class="amount_btn">
									<button type="submit" class="cus_btn">Save</button>
								</div>
								{{ Form::close() }}
							</div>
						</div>	
					</div>	
				</div>	
			</div> 
		</div>
	</section>
</div>
@endsection