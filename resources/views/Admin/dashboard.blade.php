@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Dashboard</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{URL::to('/admin/dashboard')}}">Home</a></li>
						<li class="breadcrumb-item active">Dashboard</li>
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
			</div>
			<div class="dashboard_status_list">
				<h4>Today Status</h4>	
				<?php $userrole = \App\UserRole::where('usertype', Auth::user()->role)->first();			
				?>
				<div class="row dash_box">
					<div class="col-12 col-sm-6 col-md-3">
						<a href="#"><div class="info-box">
							<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Cash Balance</span>
								<span class="info-box-number">0</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					<?php
					$depositreq = \App\Wallet::count();
					?>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="#"><div class="info-box">
							<span class="info-box-icon bg-info elevation-1"><i class="fas fa-credit-card"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Deposite Request</span>
								<span class="info-box-number">{{@$depositreq}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					<?php $userlog = \App\LoginLog::where('user_id', Auth::user()->id)->orderby('created_at', 'DESC')->first();			
				?>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="#"><div class="info-box">
							<span class="info-box-icon bg-success elevation-1"><i class="fas fa-question"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Last Login IP</span>
								<span class="info-box-number">{{@$userlog->ip}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="#"><div class="info-box">
							<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-calendar"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Last Login Date</span>
								<span class="info-box-number">{{date('h:i A, d M Y', strtotime(@$userlog->date))}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
				</div>
			
				<h4>Pending Work</h4>
				<div class="row dash_box">
					<div class="col-12 col-sm-6 col-md-3">
						<a href="#"><div class="info-box">
							<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-plane"></i></span>
							<div class="info-box-content">
								<span class="info-box-number">Flight</span>
								<span class="info-box-text">Refunds</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="#"><div class="info-box">
							<span class="info-box-icon bg-info elevation-1"><i class="fas fa-bed"></i></span>
							<div class="info-box-content">
								<span class="info-box-number">Hotel</span>
								<span class="info-box-text">Refunds</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="#"><div class="info-box">
							<span class="info-box-icon bg-success elevation-1"><i class="fas fa-bus"></i></span>
							<div class="info-box-content">
								<span class="info-box-number">Bus</span>
								<span class="info-box-text">Refunds</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
				</div>
			<?php 
			$booking = \App\BookingDetail::where('status', 1)->count();			
			$hotelbooking = \App\HotelBookingDetail::where('status', 1)->count();			
				?>
				<h4>Today's Successful Booking</h4>
				<div class="row dash_box">
					<div class="col-12 col-sm-6 col-md-3">
						<a href="{{URL::to('/admin/bookings?status=1')}}"><div class="info-box">
							<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-plane"></i></span>
							<div class="info-box-content">
								<span class="info-box-number">Flight</span>
								<span class="info-box-text">{{@$booking}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="{{URL::to('/admin/bookings?btype=hotel&type=b2c&status=1')}}"><div class="info-box">
							<span class="info-box-icon bg-info elevation-1"><i class="fas fa-bed"></i></span>
							<div class="info-box-content">
								<span class="info-box-number">Hotel</span>
								<span class="info-box-text">{{@$hotelbooking}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="#"><div class="info-box">
							<span class="info-box-icon bg-success elevation-1"><i class="fas fa-bus"></i></span>
							<div class="info-box-content">
								<span class="info-box-number">Bus</span>
								<span class="info-box-text">0</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
				</div>
			<?php 
			$bookingfailed = \App\BookingDetail::where('status', 2)->count();			
			$hotelbookingfailed = \App\HotelBookingDetail::where('status', 2)->count();			
				?>
				<h4>Today's Failed Booking</h4>
				<div class="row dash_box">
					<div class="col-12 col-sm-6 col-md-3">
						<a href="{{URL::to('/admin/bookings?status=2')}}"><div class="info-box">
							<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-plane"></i></span>
							<div class="info-box-content">
								<span class="info-box-number">Flight</span>
								<span class="info-box-text">{{$bookingfailed}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="{{URL::to('/admin/bookings?btype=hotel&type=b2c&status=2')}}"><div class="info-box">
							<span class="info-box-icon bg-info elevation-1"><i class="fas fa-bed"></i></span>
							<div class="info-box-content">
								<span class="info-box-number">Hotel</span>
								<span class="info-box-text">{{$hotelbookingfailed}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="#"><div class="info-box">
							<span class="info-box-icon bg-success elevation-1"><i class="fas fa-bus"></i></span>
							<div class="info-box-content">
								<span class="info-box-number">Bus</span>
								<span class="info-box-text">0</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
				</div>
			
				<h4>Holiday & CRM</h4>
				<div class="row dash_box">	
						@if(Auth::user()->role == 1 )
					<div class="col-12 col-sm-6 col-md-3">
						<a href="#"><div class="info-box">
							<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Clients</span>
								<span class="info-box-number">0</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					@endif	
					@if(Auth::user()->role == 1 || Auth::user()->role == 7)
					<div class="col-12 col-sm-6 col-md-3">
						<a href="{{route('admin.managecontact.index')}}"><div class="info-box">
							<span class="info-box-icon bg-info elevation-1"><i class="fas fa-phone"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Contacts</span>
								<span class="info-box-number">{{@$Contact}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="{{route('admin.invoice.index')}}"><div class="info-box">
							<span class="info-box-icon bg-success elevation-1"><i class="fas fa-file"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Invoices</span>
								<span class="info-box-number">0</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					
					<div class="col-12 col-sm-6 col-md-3">
						<a href="{{route('admin.leads.index')}}"><div class="info-box">
							<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-cog"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Leads</span>
								<span class="info-box-number">{{@$Lead}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="{{route('admin.manageholidaypackage.index')}}"><div class="info-box">
							<span class="info-box-icon bg-info elevation-1"><i class="fas fa-box"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Packages</span>
								<span class="info-box-number">{{@$Package}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="{{route('admin.managedestination.index')}}"><div class="info-box">
							<span class="info-box-icon bg-success elevation-1"><i class="fas fa-map"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Destinations</span>
								<span class="info-box-number">{{@$Destination}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="{{route('admin.managehotel.index')}}"><div class="info-box">
							<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hotel"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Hotels</span>
								<span class="info-box-number">{{@$Hotel}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="{{route('admin.users.index')}}"><div class="info-box">
							<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Users</span>
								<span class="info-box-number">{{@$Admindd}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div></a>
						<!-- /.info-box -->
					</div>
					@elseif(Auth::user()->role == 63)
						<div class="col-12 col-sm-6 col-md-3">
						<div class="info-box">
							<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-phone-slash"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Not Contacted</span>
								<span class="info-box-number">{{@$not_contacted}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<div class="info-box">
							<span class="info-box-icon bg-info elevation-1"><i class="fas fa-file-alt"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Creating Porposal</span>
								<span class="info-box-number">{{@$create_porposal}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<div class="info-box">
							<span class="info-box-icon bg-success elevation-1"><i class="fas fa-retweet"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Follow Up</span>
								<span class="info-box-number">{{@$followup}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div>
						<!-- /.info-box --> 
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<div class="info-box">
							<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-frown-open"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Undecided</span>
								<span class="info-box-number">{{@$undecided}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div> 
					<div class="col-12 col-sm-6 col-md-3">
						<div class="info-box">
							<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-eye-slash"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Lost</span>
								<span class="info-box-number">{{@$lost}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div>
						<!-- /.info-box --> 
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<div class="info-box">
							<span class="info-box-icon bg-success elevation-1"><i class="fas fa-won-sign"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Won</span>
								<span class="info-box-number">{{@$won}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<div class="info-box">
							<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-phone"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Today's Call</span>
								<span class="info-box-number">0</span>
							</div>
						  <!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<div class="info-box"> 
							<span class="info-box-icon bg-info elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Ready to pay</span>
								<span class="info-box-number">{{@$ready_to_pay}}</span>
							</div>
						  <!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					@endif	
				</div>
			</div>
			
		</div>
	</section>
</div>
@endsection