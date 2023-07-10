<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
	  <li class="nav-item">
		<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
	  </li>
	 
	  
	</ul>
	<!-- SEARCH FORM -->
	

	<!-- Right navbar links -->
	<div class="balance_limit"> 
		<ul>
			<li>Balance: <i class="fa fa-rupee-sign"></i><span class="newbalnace">{{@Auth::user()->wallet}}</span> <a href="javascript:;" class="balance_refresh"><i class="fa fa-sync"></i></a></li>
			<li>Credit Limit: <i class="fa fa-rupee-sign"></i><span class="newcredit">{{@Auth::user()->credit_limit}}</span> <a href="javascript:;" class="credit_refresh"><i class="fa fa-sync"></i></a></li> 
		</ul>
	</div>	
	<ul class="navbar-nav ml-auto">	   
	  <!-- Notifications Dropdown Menu -->
		
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
						<a href="{{route('agent.profile')}}" class="dropdown-item">
							<i class="fas fa-cogs mr-1"></i> My Account
						</a>
						<a class="dropdown-item item_logout" href="{{route('agent.logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							<i class="fas fa-sign-out-alt"></i> Logout
						</a>
							{{ Form::open(array('url' => 'agent/logout', 'name'=>'admin_login', 'id' => 'logout-form')) }}
							{{ Form::close() }}
					</div>
				</div>
			</div>
		</li>	
	</ul>
</nav>