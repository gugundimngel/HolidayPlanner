<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
	  <li class="nav-item">
		<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
	  </li>
	  <li class="nav-item d-none d-sm-inline-block">
		<a href="#" class="nav-link">Home</a>
	  </li>
	  <li class="nav-item d-none d-sm-inline-block quick_link">
		<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
		  Quick Create <span class="caret"></span>
		</a>
		<div class="dropdown-menu" x-placement="top-start">
		  <a class="dropdown-item" tabindex="-1" href="{{route('admin.manageholidaypackage.create')}}">Package</a>
		  <a class="dropdown-item" tabindex="-1" href="{{route('admin.managedestination.create')}}">Destination</a>
		  <a class="dropdown-item" tabindex="-1" href="{{route('admin.managehotel.create')}}">Hotel</a>
		  <a class="dropdown-item" tabindex="-1" href="{{URL::to('/admin/visa/add') }}">Visa</a>
		  <!--<a class="dropdown-item" tabindex="-1" href="#">Agent</a>-->
		  <!--<a class="dropdown-item" tabindex="-1" href="{{route('admin.leads.create')}}">Lead</a>-->
		  <!--<a class="dropdown-item" tabindex="-1" href="{{route('admin.invoice.index')}}">Invoice</a>-->
		  <!--<a class="dropdown-item" tabindex="-1" href="{{route('admin.managecontact.create')}}">Contact</a>-->
		</div>
	  </li> 
	   <!--<li class="nav-item d-none d-sm-inline-block">
		<a href="{{route('admin.referfriend.index')}}" class="btn btn-block btn-outline-primary btn-sm refer_friend_btn"><i class="nav-icon fas fa-gift"></i> Refer A Friend</a>
	  </li>-->
	</ul>
	<!-- SEARCH FORM -->
	<form class="form-inline ml-3">
	  <div class="input-group input-group-sm">
		<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
		<div class="input-group-append">
		  <button class="btn btn-navbar" type="submit">
			<i class="fas fa-search"></i>
		  </button>
		</div>
	  </div>
	</form>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">	   
	  <!-- Notifications Dropdown Menu -->  
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
			  <i class="far fa-bell"></i>
			  <span class="badge badge-warning navbar-badge">15</span>
			</a>  
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<span class="dropdown-item dropdown-header">15 Notifications</span>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<i class="fas fa-envelope mr-2"></i> 4 new messages
					<span class="float-right text-muted text-sm">3 mins</span>
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<i class="fas fa-users mr-2"></i> 8 friend requests
					<span class="float-right text-muted text-sm">12 hours</span>
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<i class="fas fa-file mr-2"></i> 3 new reports
					<span class="float-right text-muted text-sm">2 days</span>
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
			</div>
		</li>
		<li class="nav-item dropdown">
			<div class="user_info">
				<a href="#" data-toggle="dropdown" href="#" aria-expanded="false">
					<div class="image">
						@if(@Auth::user()->profile_img == '')
							<img src="{{ asset('/public/img/avatars/default_profile.jpg') }}" class="" />
						@else
							<img src="{{URL::to('/public/img/profile_imgs')}}/{{@Auth::user()->profile_img}}" class=""/>
						@endif	
					</div>{{str_limit(Auth::user()->first_name.' '.Auth::user()->last_name, 150, '...')}}
				</a>   
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right side_drop_menu">
					<div class="image"> 
						@if(@Auth::user()->profile_img == '') 
							<img src="{{ asset('/public/img/avatars/default_profile.jpg') }}" class="" />
						@else
							<img src="{{URL::to('/public/img/profile_imgs')}}/{{@Auth::user()->profile_img}}" class=""/>
						@endif	
					</div> 
					<div class="user_name">	
						<span>{{str_limit(Auth::user()->company_name, 150, '...')}}</span>
					</div>	
					<div class="user_email">	
						<span>{{(Auth::user()->email)}}</span>
					</div>
					<div class="item_link">
						<a href="{{route('admin.my_profile')}}" class="dropdown-item">
							<i class="fas fa-cogs mr-1"></i> My Account
						</a>
						<a class="dropdown-item item_logout" href="{{route('admin.logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							<i class="fas fa-sign-out-alt"></i> Logout
						</a>
							{{ Form::open(array('url' => 'admin/logout', 'name'=>'admin_login', 'id' => 'logout-form')) }}
							{{ Form::close() }}
					</div>
				</div>
			</div>
		</li>	
	</ul>
</nav>
<!-- /.navbar -->
<!--<header class="app-header navbar">
	<button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a class="navbar-brand" href="{{URL::to('/')}}">
		<img class="navbar-brand-full" src="{{ asset('public/img/logo.png') }}" width="89" height="25" alt="Apnamentor Logo">
		<img class="navbar-brand-minimized" src="{{ asset('public/img/logo.png') }}" width="30" height="30" alt="Apnamentor Logo">
	</a>
	<button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
		<span class="navbar-toggler-icon"></span>
	</button>
	<ul class="nav navbar-nav ml-auto">
		<li class="nav-item d-md-down-none">
			<a class="nav-link" href="#">
				<i class="icon-bell"></i>
				<span class="badge badge-pill badge-danger">0</span>
			</a>
        </li>
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
				@if(@Auth::user()->profile_img == '')
					<img src="{{ asset('/public/img/avatars/default_profile.jpg') }}" class="img-avatar" />
				@else
					<img src="{{URL::to('/public/img/profile_imgs')}}/{{@Auth::user()->profile_img}}" class="img-avatar"/>
				@endif
			</a>
			<div class="dropdown-menu dropdown-menu-right">
				<div class="dropdown-header text-center">
					<div>
						@if(@Auth::user()->profile_img == '')
							<img src="{{ asset('/public/img/avatars/default_profile.jpg') }}" class="img-avatar" width="30%"/>
						@else
							<img src="{{URL::to('/public/img/profile_imgs')}}/{{@Auth::user()->profile_img}}" class="img-avatar" width="30%"/>
						@endif
					</div>	
					<strong>{{str_limit(Auth::user()->first_name.' '.Auth::user()->last_name, 150, '...')}}</strong>
				</div>
				<a class="dropdown-item" href="{{URL::to('/admin/my_profile')}}">
					<i class="fa fa-user"></i> 
					My Profile
				</a>
				@if(@Auth::user()->role == '1')	
					<a class="dropdown-item" href="{{URL::to('/admin/change_password')}}">
						<i class="fa fa-key"></i> 
						Change Password
					</a>
				@endif	-->	
				<!--Logout -->	
				 <!--<a class="dropdown-item" href="{{route('admin.logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
					Logout
				</a>
				{{ Form::open(array('url' => 'admin/logout', 'name'=>'admin_login', 'id' => 'logout-form')) }}
				{{ Form::close() }}
			</div>
		</li>	
	</ul>
</header>-->