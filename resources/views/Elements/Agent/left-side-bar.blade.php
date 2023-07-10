<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="#" class="brand-link">
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
					<a href="{{route('agent.dashboard')}}" class="nav-link">
						<i class="nav-icon fas fa-tachometer-alt"></i> Dashboard
					</a>  
				</li>
				<li class="nav-item has-treeview">
					<a target="_blank" href="{{route('agent.flights')}}" class="nav-link">
						<i class="nav-icon fas fa-plane"></i> Flight Search
					</a>  
				</li>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-bed"></i> Hotel Search
					</a>  
				</li> 
				<?php
				if(Route::currentRouteName() == 'agent.wallet' || Route::currentRouteName() == 'agent.rechargehistory' || Route::currentRouteName() == 'agent.transaction_log'|| Route::currentRouteName() == 'agent.credit_limit_log'){
					$classtype = 'active menu-open';
				}
				?>
				<li class="nav-item has-treeview {{@$classtype}}">
				
					<a href="javascript:;" class="nav-link">
						<i class="nav-icon fas fa-cog"></i>
						<p>Wallet & Deposits<i class="fas fa-angle-left right"></i></p>
					</a> 
					<ul class="nav nav-treeview">
						<li class="nav-item {{(Route::currentRouteName() == 'agent.transaction_log') ? 'active' : ''}}">
							<a href="{{route('agent.transaction_log')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i> Transactions Log
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'agent.credit_limit_log') ? 'active' : ''}}">
							<a href="{{route('agent.credit_limit_log')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i> Credit Limit Log
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'agent.wallet') ? 'active' : ''}}">
							
							<a href="{{route('agent.wallet')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i> Wallet
							</a>
						</li> 
						<li class="nav-item {{(Route::currentRouteName() == 'agent.rechargehistory') ? 'active' : ''}}">
							<a href="{{route('agent.rechargehistory')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i> Recharge History
							</a>
						</li>
						<!--<li class="nav-item {{(Route::currentRouteName() == 'agent.crdrhistory') ? 'active' : ''}}">
							<a href="{{route('agent.crdrhistory')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i> Credit/Debit History
							</a>
						</li>-->
					</ul>
				</li>
				<?php
				//echo Route::currentRouteName();
				if(Route::currentRouteName() == 'agent.bookings.index' || Route::currentRouteName() == 'agent.profitloss' || Route::currentRouteName() == 'agent.dailysale' || Route::currentRouteName() == 'agent.ledger' || Route::currentRouteName() == 'agent.bookings.detail' ){
					$bookingclasstype = 'active menu-open';
				}
				?>
				<li class="nav-item has-treeview {{@$bookingclasstype}}">
					<a href="javascript:;" class="nav-link">
						<i class="nav-icon fas fa-file-alt"></i>
						<p>Booking Reports <i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item {{(Route::currentRouteName() == 'agent.bookings.index' || Route::currentRouteName() == 'agent.bookings.detail') ? 'active' : ''}}">
							<a href="{{route('agent.bookings.index')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i> Booking Reports
							</a>
						</li> 
						<li class="nav-item {{(Route::currentRouteName() == 'agent.profitloss') ? 'active' : ''}}">
							<a href="{{route('agent.profitloss')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i> Profit & Loss
							</a>
						</li> 
						<li class="nav-item {{(Route::currentRouteName() == 'agent.dailysale') ? 'active' : ''}}">
							<a href="{{route('agent.dailysale')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i> Daily Sales Report
							</a>
						</li>  
						<li class="nav-item {{(Route::currentRouteName() == 'agent.ledger') ? 'active' : ''}}">
							<a href="{{route('agent.ledger')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i> Ledger Report
							</a>
						</li> 
					</ul>
				</li>
				<?php
				//echo Route::currentRouteName();
				if(Route::currentRouteName() == 'agent.profile' || Route::currentRouteName() == 'agent.edit_profile' || Route::currentRouteName() == 'agent.change_password'){
					$settingclasstype = 'active menu-open';
				}
				?>
				<li class="nav-item has-treeview {{@$settingclasstype}}">
					<a href="javascript:;" class="nav-link">
						<i class="nav-icon fas fa-cog"></i>
						<p>Settings <i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item {{(Route::currentRouteName() == 'agent.profile' || Route::currentRouteName() == 'agent.edit_profile') ? 'active' : ''}}">
							<a href="{{route('agent.profile')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i> My Profile
							</a>
						</li>
						<li class="nav-item {{(Route::currentRouteName() == 'agent.change_password') ? 'active' : ''}}">
							<a href="{{route('agent.change_password')}}" class="nav-link">
								<i class="far fa-circle nav-icon"></i> Change Password
							</a>
						</li>
						<!--<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="far fa-circle nav-icon"></i> My Account Balance
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="far fa-circle nav-icon"></i> Multi-Factor Authentication
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="far fa-circle nav-icon"></i> Set PIN
							</a>
						</li>-->
					</ul>
				</li>
				<li class="nav-item">
					<a href="{{route('agent.logout')}}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="nav-icon fas fa-sign-out-alt"></i> Logout</a>
					{{ Form::open(array('url' => 'agent/logout', 'name'=>'admin_login', 'id' => 'logout-form')) }}
					{{ Form::close() }}
				</li>
			</ul>
		</nav>
		  <!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>