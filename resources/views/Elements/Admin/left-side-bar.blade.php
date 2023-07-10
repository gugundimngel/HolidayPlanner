<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="{{route('admin.dashboard')}}" class="brand-link">
	   <img src="{!! asset('public/img/Frontend/img/logo-header.png') !!}" alt="Logo" class="brand-image" /> 
	  <!--<span class="brand-text font-weight-light">ZapBooking</span>-->
	</a>
	<!-- Sidebar -->
	<div class="sidebar custom_sidebar">
	   <!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			<!-- Add icons to the links using the .nav-icon class
			   with font-awesome or any other icon font library -->
				<li class="nav-item has-treeview menu-open">
					<a href="{{route('admin.dashboard')}}" class="nav-link">
						<i class="nav-icon fas fa-tachometer-alt"></i> Dashboard
					</a>  
				</li>
				<?php
				//echo Route::currentRouteName();
				if(Route::currentRouteName() == 'admin.flightmarkup' || Route::currentRouteName() == 'admin.flightmarkup.create'){
					$markupclasstype = 'active menu-open';
				}
				?> 
				<li class="nav-item has-treeview {{@$markupclasstype}}">
					<a href="javascript:;" class="nav-link">
						<i class="nav-icon fas fa-cog"></i>
						<p>Markup Setting <i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item {{(Route::currentRouteName() == 'admin.flightmarkup' || Route::currentRouteName() == 'admin.flightmarkup.create') ? 'active' : ''}}">
							<a href="{{route('admin.flightmarkup')}}" class="nav-link">
							  <i class="far fa-circle nav-icon"></i>
							  <p>Flight</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{route('admin.hotelmarkup')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Hotels</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Holiday</p>
							</a>
						</li>  
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Bus</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Car</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{route('admin.visamarkup')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Visa</p>
							</a>
						</li>
					</ul>
				<?php
				//echo Route::currentRouteName();
				if(Route::currentRouteName() == 'admin.bookings.index' || Route::currentRouteName() == 'admin.bookings.detail'){
					$bookingclasstype = 'active menu-open';
				}
				?>  
				<li class="nav-item has-treeview {{@$bookingclasstype}}">
					<a href="javascript:;" class="nav-link">
						<i class="nav-icon fas fa-file-alt"></i>
						<p>Booking Managements <i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item {{(Route::currentRouteName() == 'admin.bookings.index' && Request::get('btype') != 'hotel' && Request::get('btype') != 'package') ? 'active' : ''}}">
							<a href="{{route('admin.bookings.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Flights</p>
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'admin.bookings.index' && Request::get('btype') == 'hotel') ? 'active' : ''}}">
							<a href="{{URL::to('/admin/bookings?btype=hotel')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Hotels</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Bus</p>
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'admin.bookings.index' && Request::get('btype') == 'package') ? 'active' : ''}}">
							<a href="{{URL::to('/admin/bookings?btype=package')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Packages</p>
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'admin.visa.visa_query' ) ? 'menu-open' : ''}}">
							<a href="{{url('admin/visa/booking/list')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i> Visa
							</a>
						</li> 
					</ul>
				</li>
				<!--<li class="nav-item has-treeview">-->
				<!--	<a href="javascript:;" class="nav-link">-->
				<!--		<i class="nav-icon fas fa-file-alt"></i>-->
				<!--		<p>GRN Hotel <i class="fas fa-angle-left right"></i></p>-->
				<!--	</a>-->
				<!--	<ul class="nav nav-treeview">-->
				<!--		<li class="nav-item">-->
				<!--			<a href="{{route('admin.grnhotel.index')}}" class="nav-link">-->
				<!--				<i class="far fa-circle nav-icon"></i>-->
				<!--				<p>Hotel List</p>-->
				<!--			</a>-->
				<!--			<a href="{{route('admin.grnhotelfacilties.index')}}" class="nav-link">-->
				<!--				<i class="far fa-circle nav-icon"></i>-->
				<!--				<p>Hotel Facilties</p>-->
				<!--			</a>-->
				<!--		</li>-->
				<!--	</ul>-->
				<!--</li>-->
				<?php
				//echo Route::currentRouteName();
				if(Route::currentRouteName() == 'admin.users.index' || Route::currentRouteName() == 'admin.agents.index' || Route::currentRouteName() == 'admin.agents.view'|| Route::currentRouteName() == 'admin.users.view'){
					$userclasstype = 'active menu-open';
				}
				?>  
				<li class="nav-item has-treeview {{@$userclasstype}}">
					<a href="javascript:;" class="nav-link">
						<i class="nav-icon fas fa-user"></i>
						<p>User Management<i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item {{(Route::currentRouteName() == 'admin.users.index' || Route::currentRouteName() == 'admin.users.view') ? 'active' : ''}}">
							<a href="{{route('admin.users.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>B2C Users</p>
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'admin.agents.index' || Route::currentRouteName() == 'admin.agents.view') ? 'active' : ''}}">
							<a href="{{route('admin.agents.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>B2B Users</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{URL('/')}}/agent-signup" target="_blank" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Create New Agent</p>
							</a>
						</li> 
					</ul>
				</li>
				<?php
				//echo Route::currentRouteName();
				if(Route::currentRouteName() == 'admin.wallet.index' || Route::currentRouteName() == 'admin.wallet.view' || Route::currentRouteName() == 'admin.wallet.create' || Route::currentRouteName() == 'admin.wallet.crdr' || Route::currentRouteName() == 'admin.profitloss' || Route::currentRouteName() == 'admin.dailysale' || Route::currentRouteName() == 'admin.ledger'){
					$Financeclasstype = 'active menu-open';
				}
				?>  
				<li class="nav-item has-treeview {{@$Financeclasstype}}">
					<a href="javascript:;" class="nav-link">
						<i class="nav-icon fas fa-file-alt"></i>
						<p>Finance <i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item {{(Route::currentRouteName() == 'admin.wallet.index' || Route::currentRouteName() == 'admin.wallet.view') ? 'active' : ''}}">
							<a href="{{route('admin.wallet.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Wallet & Deposits</p>
							</a>
						</li>
						<li  class="nav-item {{(Route::currentRouteName() == 'admin.wallet.create' || Route::currentRouteName() == 'admin.wallet.crdr') ? 'active' : ''}}">
							<a href="{{route('admin.wallet.crdr')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Credit/Debit</p>
							</a>
						</li>
						
						<li class="nav-item {{(Route::currentRouteName() == 'admin.dailysale' ) ? 'active' : ''}}">
							<a href="{{route('admin.dailysale')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Daily Sales Report</p>
							</a>
						</li>  
						<li class="nav-item {{(Route::currentRouteName() == 'admin.ledger' ) ? 'active' : ''}}">
							<a href="{{route('admin.ledger')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Ledger Report</p>
							</a>
						</li>
						
					</ul>
				</li>
				
				<?php
				/* echo Route::currentRouteName();
				if(Route::currentRouteName() == 'admin.wallet.index' || Route::currentRouteName() == 'admin.wallet.view' || Route::currentRouteName() == 'admin.wallet.create' || Route::currentRouteName() == 'admin.wallet.crdr' || Route::currentRouteName() == 'admin.profitloss' || Route::currentRouteName() == 'admin.dailysale' || Route::currentRouteName() == 'admin.ledger'){
					$Financeclasstype = 'active menu-open';
				} */
				?>  
				<li class="nav-item has-treeview">
					<a href="javascript:;" class="nav-link">
						<i class="nav-icon fas fa-user"></i>
						<p>Manage Sub Admin<i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Sub Admin List</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Add Department</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Add Designation</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Add New</p>
							</a>
						</li>	
					</ul>
				</li>
				<?php //$userrole = \App\UserRole::where('usertype', Auth::user()->role)->first();		
			  
				//$modules = json_decode(@$userrole->module_access);			
				?>
					{{-- @if(Auth::user()->role == 1 || @in_array('user_management', $modules))
				<li class="nav-item has-treeview">
					<a href="javascript:;" class="nav-link">
						<i class="nav-icon fas fa-user"></i>
						<p>User Management<i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{route('admin.users.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Users</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{route('admin.users.clientlist')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Create Client</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{route('admin.usertype.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>User Type</p>
							</a>
						</li>  
						<li class="nav-item">
							<a href="{{route('admin.userrole.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Role</p>
							</a>
						</li>
					</ul>
				</li>
				@endif --}}
				
				@if(Auth::user()->role == 1 || @in_array('holiday_package',  $modules))
				<?php
					$classtype = '';
					
					if(Route::currentRouteName() == 'admin.managedestination.index' || Route::currentRouteName() == 'admin.managedestination.create' || Route::currentRouteName() == 'admin.managedestination.edit'  || Route::currentRouteName() == 'admin.manageholidaypackage.create' || Route::currentRouteName() == 'admin.manageholidaypackage.edit' || Route::currentRouteName() == 'admin.manageholidaypackage.index' || Route::currentRouteName() == 'admin.manageholidaypackage.create' || Route::currentRouteName() == 'admin.manageholidaypackage.edit' || Route::currentRouteName() == 'admin.managehotel.index' || Route::currentRouteName() == 'admin.managehotel.create' || Route::currentRouteName() == 'admin.managehotel.edit' || Route::currentRouteName() == 'admin.manageinclusion.index' || Route::currentRouteName() == 'admin.manageinclusion.create' || Route::currentRouteName() == 'admin.manageinclusion.edit' || Route::currentRouteName() == 'admin.manageexclusion.index'|| Route::currentRouteName() == 'admin.manageexclusion.create' || Route::currentRouteName() == 'admin.manageexclusion.edit' || Route::currentRouteName() == 'admin.manageamenities.index' || Route::currentRouteName() == 'admin.manageamenities.create' || Route::currentRouteName() == 'admin.manageamenities.edit' || Route::currentRouteName() == 'admin.manageholidaytype.index' || Route::currentRouteName() == 'admin.manageholidaytype.create' || Route::currentRouteName() == 'admin.manageholidaytype.edit' || Route::currentRouteName() == 'admin.managetopinclusion.index' || Route::currentRouteName() == 'admin.managetopinclusion.create' || Route::currentRouteName() == 'admin.managetopinclusion.edit' || Route::currentRouteName() == 'admin.managegallery.index' || Route::currentRouteName() == 'admin.managegallery.create' || Route::currentRouteName() == 'admin.managegallery.edit' || Route::currentRouteName() == 'admin.cities.index' || Route::currentRouteName() == 'admin.cities.create' || Route::currentRouteName() == 'admin.cities.edit' || Route::currentRouteName() == 'admin.manageaddon.index' || Route::currentRouteName() == 'admin.manageaddon.create' || Route::currentRouteName() == 'admin.manageaddon.edit'){
						$classtype = 'active menu-open';
					}
				?>
				
				<li class="nav-item has-treeview {{@$classtype}}">
					<a href="javascript:;" class="nav-link">
						<i class="nav-icon fas fa-suitcase"></i>
						<p>Holiday Package<i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview"> 
						<li class="nav-item {{(Route::currentRouteName() == 'admin.manageholidaypackage.index' || Route::currentRouteName() == 'admin.manageholidaypackage.create' || Route::currentRouteName() == 'admin.manageholidaypackage.edit') ? 'active' : ''}}">
							<a href="{{route('admin.manageholidaypackage.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Manage Package</p>
							</a> 
						</li>
				  {{--  <li class="nav-item {{(Route::currentRouteName() == 'admin.managedestination.index' || Route::currentRouteName() == 'admin.managedestination.create' || Route::currentRouteName() == 'admin.managedestination.edit') ? 'active' : ''}}">
							<a href="{{route('admin.managedestination.index')}}" class="nav-link ">
								<i class="far fa-circle nav-icon"></i>
								<p>Manage Destination</p>
							</a>
						</li> --}}
						<li class="nav-item {{(Route::currentRouteName() == 'admin.manageaddon.index' || Route::currentRouteName() == 'admin.manageaddon.create' || Route::currentRouteName() == 'admin.manageaddon.edit') ? 'active' : ''}}">
							<a href="{{route('admin.manageaddon.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Manage Add On</p>
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'admin.managehotel.index' || Route::currentRouteName() == 'admin.managehotel.create' || Route::currentRouteName() == 'admin.managehotel.edit') ? 'active' : ''}}">
							<a href="{{route('admin.managehotel.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Manage Hotel</p>
							</a>
						</li> 
						<li class="nav-item {{(Route::currentRouteName() == 'admin.manageinclusion.index' || Route::currentRouteName() == 'admin.manageinclusion.create' || Route::currentRouteName() == 'admin.manageinclusion.edit') ? 'active' : ''}}">
							<a href="{{route('admin.manageinclusion.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Manage Inclusion</p>
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'admin.manageexclusion.index' || Route::currentRouteName() == 'admin.manageexclusion.create' || Route::currentRouteName() == 'admin.manageexclusion.edit') ? 'active' : ''}}">
							<a href="{{route('admin.manageexclusion.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Manage Exclusion</p>
							</a>
						</li> 
						<li class="nav-item {{(Route::currentRouteName() == 'admin.manageamenities.index' || Route::currentRouteName() == 'admin.manageamenities.create' || Route::currentRouteName() == 'admin.manageamenities.edit') ? 'active' : ''}}">
							<a href="{{route('admin.manageamenities.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Manage Amenities</p>
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'admin.manageholidaytype.index' || Route::currentRouteName() == 'admin.manageholidaytype.create' || Route::currentRouteName() == 'admin.manageholidaytype.edit') ? 'active' : ''}}">
							<a href="{{route('admin.manageholidaytype.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Manage Holiday Type</p>
							</a>
						</li> 
						<li class="nav-item {{(Route::currentRouteName() == 'admin.managetopinclusion.index' || Route::currentRouteName() == 'admin.managetopinclusion.create' || Route::currentRouteName() == 'admin.managetopinclusion.edit') ? 'active' : ''}}">
							<a href="{{route('admin.managetopinclusion.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Manage Top Inclusion</p>
							</a>
						</li>	
					   <li class="nav-item {{(Route::currentRouteName() == 'admin.cities.index' || Route::currentRouteName() == 'admin.cities.create' || Route::currentRouteName() == 'admin.cities.edit') ? 'active' : ''}}">
							<a href="{{route('admin.cities.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Manage Departure/X-City</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{route('admin.locations.index')}}" class="nav-link">
								<i class="nav-icon fas fa-location-arrow"></i> Destinations
							</a>
						</li> 
						<li class="nav-item">
							<a href="{{route('admin.themes.index')}}" class="nav-link">
								<i class="nav-icon fas fa-leaf"></i> Holiday Themes
							</a>
						</li>
						<li class="nav-item">
							<a href="{{route('admin.topinclusion.index')}}" class="nav-link">
								<i class="nav-icon fas fa-bars"></i> Top Inclusion
							</a>
						</li>	
					
					  <?php /* <li class="nav-item {{(Route::currentRouteName() == 'admin.managegallery.index' || Route::currentRouteName() == 'admin.managegallery.create' || Route::currentRouteName() == 'admin.managegallery.edit') ? 'active' : ''}}">
						<a href="{{route('admin.managegallery.index')}}" class="nav-link">
						  <i class="far fa-circle nav-icon"></i>
						  <p>Manage Gallery</p>
						</a> 
					  </li> */ ?>
					</ul>
				</li>
				
				<li class="nav-item has-treeview {{@$classtype}}">
					<a href="javascript:;" class="nav-link">
						<i class="nav-icon fas fa-suitcase"></i>
						<p>Visa Package<i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview"> 
						<li class="nav-item {{(Route::currentRouteName() == 'admin.visa.view' ) ? 'menu-open' : ''}}">
        					<a href="{{url('admin/visa/view')}}" class="nav-link">
        						<i class="nav-icon fas fa-cogs"></i> Manage Visa
        					</a>
        				</li>  
						<li class="nav-item {{(Route::currentRouteName() == 'admin.visa.category' ) ? 'menu-open' : ''}}">
        					<a href="{{url('admin/visa/category')}}" class="nav-link">
        						<i class="nav-icon fas fa-cogs"></i> Visa Category
        					</a>
        				</li>  
					</ul>
				</li>
				
				@endif
				<?php
				//echo Route::currentRouteName();
				if(Route::currentRouteName() == 'admin.flights.index' || Route::currentRouteName() == 'admin.flightdetail.index' || Route::currentRouteName() == 'admin.flights.create' || Route::currentRouteName() == 'admin.flights.edit' || Route::currentRouteName() == 'admin.flightdetail.create' || Route::currentRouteName() == 'admin.flightdetail.edit'){
					$flightclasstype = 'active menu-open';
				}
				?>  
				<li class="nav-item has-treeview {{@$flightclasstype}}"> 
					<a href="javascript:;" class="nav-link">
						<i class="nav-icon fas fa-plane"></i>
						<p>Flight Managements<i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item {{(Route::currentRouteName() == 'admin.flights.index' || Route::currentRouteName() == 'admin.flights.create' || Route::currentRouteName() == 'admin.flights.edit') ? 'active' : ''}}">
							<a href="{{route('admin.flights.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Flights</p>
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'admin.flightdetail.index' || Route::currentRouteName() == 'admin.flightdetail.create' || Route::currentRouteName() == 'admin.flightdetail.edit') ? 'active' : ''}}">
							<a href="{{route('admin.flightdetail.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Flights Detail</p>
							</a>
						</li>   
					</ul>
				</li>	  
				@if(Auth::user()->role == 1 || @in_array('lead_management',  $modules))
				<!--<li class="nav-item {{(Route::currentRouteName() == 'admin.leads.index' ) ? 'menu-open' : ''}}">-->
				<!--	<a href="{{route('admin.leads.index')}}" class="nav-link">-->
				<!--		<i class="nav-icon fas fa-cogs"></i> Leads-->
				<!--	</a>-->
				<!--</li>  -->
			 
				@endif
			 
				@if(@in_array('staff',  $modules ??  []))
				<li class="nav-item"> 
					<a href="{{route('admin.staff.index')}}" class="nav-link">
						<i class="nav-icon fas fa-users"></i>
						<p>Staffs</p>
					</a>
				</li>  
				@endif
		   
				@if(@in_array('api_key',  $modules ??  []))
				<li class="nav-item">
					<a href="{{route('admin.edit_api')}}" class="nav-link">
						<i class="nav-icon fas fa-key"></i>Api Key
					</a>
				</li>
				@endif
				@if(Auth::user()->role == 1)
			<!--<li class="nav-item">
					<a href="{{route('admin.email.index')}}" class="nav-link">
						<i class="nav-icon fas fa-envelope"></i>Email Templates
					</a>
				</li>
				<li class="nav-item">
					<a href="{{route('admin.coupon_code.index')}}" class="nav-link">
						<i class="nav-icon fas fa-envelope"></i>Promo Codes
					</a>
				</li>-->
			<?php
				//echo Route::currentRouteName();
				if(Route::currentRouteName() == 'admin.website_setting' || Route::currentRouteName() == 'admin.my_profile' || Route::currentRouteName() == 'admin.change_password' || Route::currentRouteName() == 'admin.manageaccounts.index' || Route::currentRouteName() == 'admin.servicefees' || Route::currentRouteName() == 'admin.paymentgateway' || Route::currentRouteName() == 'admin.returnsetting' || Route::currentRouteName() == 'admin.currency.index' || Route::currentRouteName() == 'admin.multi_factor' || Route::currentRouteName() == 'admin.sessions'|| Route::currentRouteName() == 'admin.smsgateway'|| Route::currentRouteName() == 'admin.api'){
					$settingclasstype = 'active menu-open';
				}
				?>  
				<li class="nav-item has-treeview {{@$settingclasstype}}"> 
					<a href="javascript:;" class="nav-link">
						<i class="nav-icon fas fa-cogs"></i>
						<p>Settings<i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item {{(Route::currentRouteName() == 'admin.website_setting') ? 'active' : ''}}">
							<a href="{{route('admin.website_setting')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								Website Setting
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'admin.my_profile') ? 'active' : ''}}">
							<a href="{{route('admin.my_profile')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								My Profile
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'admin.change_password') ? 'active' : ''}}">
							<a href="{{route('admin.change_password')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								Change Password
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'admin.manageaccounts.index') ? 'active' : ''}}">
							<a href="{{route('admin.manageaccounts.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								Bank Account Info
							</a>
						</li>
					 
						<li class="nav-item {{(Route::currentRouteName() == 'admin.servicefees') ? 'active' : ''}}"> 
							<a href="{{route('admin.servicefees')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								Service Fees
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'admin.paymentgateway') ? 'active' : ''}}">
							<a href="{{route('admin.paymentgateway')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								Payment Gateway
							</a>
						</li>
						<li class="nav-item">
							<a href="{{route('admin.api')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								Api Management
							</a>
						</li>						
						<li class="nav-item {{(Route::currentRouteName() == 'admin.returnsetting') ? 'active' : ''}}">
							<a href="{{route('admin.returnsetting')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								Taxes
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'admin.currency.index') ? 'active' : ''}}">
							<a href="{{route('admin.currency.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								Currencies
							</a>
						</li>
						
						<li class="nav-item {{(Route::currentRouteName() == 'admin.multi_factor') ? 'active' : ''}}">
							<a href="{{route('admin.multi_factor')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								Multi-Factor Authentication
							</a>   
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'admin.sessions') ? 'active' : ''}}">
							<a href="{{route('admin.sessions')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								Sessions
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'admin.smsgateway') ? 'active' : ''}}">
							<a href="{{route('admin.smsgateway')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								SMS Settings
							</a>
						</li>							 
					</ul> 
				</li>
				@endif  
				<li class="nav-item has-treeview">
					<a href="javascript:;" class="nav-link">
						<i class="nav-icon fas fa-bullhorn"></i>
						<p>Promotion / Marketing<i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{route('admin.coupon_code.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Promo Codes & Offers</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Email Template</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Email Setting</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{route('admin.agentoffers.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Agent Offers</p>
							</a>
						</li>
					</ul> 
				</li>
				<li class="nav-item has-treeview">
					<a href="javascript:;" class="nav-link">
						<i class="nav-icon fas fa-file"></i> 
						<p>Contents<i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{route('admin.managecontact.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i> Manage Contacts
							</a>
						</li>
						<li class="nav-item">
							<a href="{{route('admin.cms_pages.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Pages</p>
							</a>
						</li>			 
						<li class="nav-item">
							<a href="{{route('admin.news.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>News</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{route('admin.testimonial.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Testimonial</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="{{route('admin.logout')}}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
						<i class="nav-icon fas fa-sign-out-alt"></i>Logout 
					</a>
					{{ Form::open(array('url' => 'admin/logout', 'name'=>'admin_login', 'id' => 'logout-form')) }}
					{{ Form::close() }}
				</li>
			</ul>
		</nav>
	  <!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
<!--<div class="sidebar">
	<nav class="sidebar-nav">
		<ul class="nav">
			<li class="nav-item">
				<a class="nav-link {{Route::currentRouteName() == 'admin.edit_seo' ? 'active' : ''}}" href="{{URL::to('/admin/dashboard')}}">
					<i class="nav-icon icon-speedometer"></i> 
					Dashboard
				</a>
			</li>
			@if(Auth::user()->role == 1)  
					
			<li class="nav-item nav-dropdown {{Route::currentRouteName() == 'admin.edit_course' ? 'open' : ''}}">
				<a class="nav-link nav-dropdown-toggle" href="javascript:void(0);">
					<i class="icon-book-open"></i>
					Manage Courses
				</a>
				<ul class="nav-dropdown-items">
					<li class="nav-item">
						<a class="nav-link" href="{{URL::to('/admin/add_course')}}">
						<i class="nav-icon icon-plus"></i> Add Course</a>
					</li>
					<li class="nav-item">
						<a class="nav-link {{Route::currentRouteName() == 'admin.edit_course' ? 'active' : ''}}" href="{{URL::to('/admin/courses')}}">
						<i class="nav-icon icon-list"></i> All Courses</a>
					</li>
				</ul>
			</li>	
			@endif			
		</ul>
	</nav>
	<button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>-->