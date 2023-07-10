@extends('layouts.frontend')
@section('title', 'Payonline')
@section('content')

<!-- Content
		============================================= -->
<section id="content">
	<div id="content-wrap">
		<!-- === Section Flat =========== -->
		<div class="section-flat single_sec_flat travelagent_page" style="background:#e8e8e8;">
			<div class="section-content">
				<div class="custom_banner">
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<div class="banner_txt">
									<div class="title">
										 <h3>Payonline</h3>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="inner_contact">

								<div class="cus_breadcrumb">
									<ul>
										<li class="active"><a href="#">Home</a></li>
										<li><span><i class="fa fa-angle-right"></i></span></li>
										<li><a href="#">Payonline</a></li>
									</ul>
								</div>

							<div class="clearfix"></div>
						</div>
						<div class="contact_detail pay_online">
							<!-- <div class="col-sm-6">
								<div class="contact_info">
									<h4>Payment Details</h4>
									@foreach(\App\BankAccount::all() as $list)
									<p><b>Beneficiary Name</b> :  {{@$list->company_bank_name}}</p>
									<p><b>Beneficiary A/C No.</b> : {{@$list->account_no}}</p>
									<p><b>Bank Name</b> : {{@$list->bank_name}}</p>
									<p><b>Address</b> : {{@$list->bank_address}}, {{@$list->bank_city}} – {{@$list->postal_code}} </p>
									<p><b>Code </b> : {{@$list->ifsc_code}}</p>
									<p><b>Swift Code </b> : {{@$list->swift_code}}</p>

									<p>Cheque in Favour of “{{@$list->company_bank_name}}”</p>
									@endforeach
								</div>
							</div> -->
							<div class="col-sm-12">
								<div class="contact_form">
									<h4>Make Payment Online</h4>
									<form class="form_sec" method="" action="">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Amount</label>
													<input type="text" class="form-control txt_field" placeholder="Amount" name="amount" />
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Total (2.50% Service Fee)</label>
													<input type="text" class="form-control txt_field" placeholder="Total Amount" name="total_service_fee" />
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Name</label>
													<input type="text" class="form-control txt_field" placeholder="Name" name="name" />
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>E-mail</label>
													<input type="email" class="form-control txt_field" placeholder="E-mail" name="email" />
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<label>Product Info</label>
													<input type="text" class="form-control txt_field" placeholder="Product Info" name="product_info" />
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group text-center">
													<input type="submit" name="submit" class="form_submit_btn" value="Pay Now" />
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection