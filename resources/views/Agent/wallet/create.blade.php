@extends('layouts.agent')
@section('title', 'Recharge Request')

@section('content')
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Recharge Request</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Recharge Request</li>
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
						<h3 class="card-title">Recharge Request</h3>
					  </div> 
					  <!-- /.card-header -->
					  <!-- form start -->
					  {{ Form::open(array('url' => 'agent/wallet/store', 'name'=>"add-wallet", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group" style="text-align:right;">
										
										{{ Form::button('<i class="fa fa-save"></i> Save', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-wallet")' ]) }}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="pay_mode" class="col-form-label">Payment Mode <span style="color:#ff0000;">*</span></label>
										<select id="pay_mode" data-valid="required" class="form-control" name="pay_mode">
											<option value="Cheque/Draft">Cheque/Draft</option>
											<option value="Cash">Cash</option>
											<option value="RTGC/NEFT">RTGC/NEFT</option>
											<option value="Debit Card/Credit Card/Net Banking">Debit Card/Credit Card/Net Banking</option>
											<option value="EDC Machine/Transfer">EDC Machine/Transfer</option>
											</select>
												
										@if ($errors->has('pay_mode'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('pay_mode') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="amount" class="col-form-label">Amount <span style="color:#ff0000;">*</span></label>
										<input type="text" name="amount" autocomplete="off" data-valid="required" class="form-control" onkeyup="">
										@if ($errors->has('amount'))
											<span class="custom-error" role="alert">
												<strong>{{ @$errors->first('amount') }}</strong>
											</span> 
										@endif
									</div>
								</div>
								
								<div class="col-sm-6 if_cheq">
									<div class="form-group">
										<label class="forutr">Cheque Number</label>
										<input class="form-control" name="cheque_no">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="pay_date" class="col-form-label">Date <span style="color:#ff0000;">*</span></label>
										<input type="text" name="pay_date" autocomplete="off" data-valid="required" class="form-control commodate" placeholder="">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="bank_name" class="col-form-label">Bank <span style="color:#ff0000;">*</span></label>
										<input type="text" name="bank_name" autocomplete="off" data-valid="required" class="form-control" onkeyup="">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="bank_branch" class="col-form-label">Branch <span style="color:#ff0000;">*</span></label>
										<input type="text" name="bank_branch" autocomplete="off" data-valid="required" class="form-control" onkeyup="">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group"> 
										<label for="bank_transaction_id" class="col-form-label">Bank Transaction ID <span style="color:#ff0000;">*</span></label>
										<input type="text" name="bank_transaction_id" autocomplete="off" data-valid="required" class="form-control" onkeyup="">
									</div>
								</div>
								
								<div class="col-sm-6">
								<div class="form-group">
									<label>Remarks</label>
									<textarea class="form-control" name="remarks"></textarea>
								</div>
							</div>
								<div class="col-sm-12">
									<div class="form-group float-right">
										{{ Form::button('<i class="fa fa-save"></i> Save', ['class'=>'btn btn-primary', 'onClick'=>'customValidate("add-wallet")' ]) }}
									</div> 
								</div> 
							</div> 
						</div> 
					  {{ Form::close() }}
					</div>	
				</div>	
			</div> 
		</div>
	</section>
</div>
<script>
$(document).delegate('#pay_mode', "change", function () {
				
				var v = $('#pay_mode option:selected').val();
				if(v == 'Cheque/Draft'){
					$('.forutr').html('Cheque Number');
					$('.if_cheq').show();
			}else if(v == 'Cash'){
				$('.if_cheq').hide();
			}else{
				$('.forutr').html('UTR Number');
				$('.if_cheq').show();
			}
			});
</script>
@endsection