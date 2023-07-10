<div class="sidebar_menu">
	<div class="profile_info">
		<div class="profile_image">
			<form id="prosub" action="{{URL::to('/uploadimage')}}" method="post" enctype="multipart/form-data">
			@csrf
			@if(Auth::user()->profile_img == '')
				<img src="{{URL::to('html')}}/images/profile.png" class="img-responsive" alt="Profile Image"/>
			@else
					<img src="{{URL::to('/')}}/public/img/profile_imgs/{{Auth::user()->profile_img}}" class="img-responsive" alt="Profile Image"/>
			@endif	
				<div class="upload_img">
					<input type="file" id="profileimg" name="profileimg" />
					<i class="fa fa-pencil-alt"></i>
				</div> 
			</form>
		</div>
		<div class="profile_name"> 
			<h4>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h4>
			<span>Personal Profile</span>
		</div>
	</div>
	<ul>
		<li class="{{(Route::currentRouteName() == 'dashboard.index') ? 'active' : ''}}"><a href="{{route('dashboard.index')}}"><img src="{{URL::to('/')}}/public/images/icons/my-booking.png" alt="My Booking"/> My Booking</a></li>
	<!--	<li class=""><a href="#"><img src="{{URL::to('/')}}/public/images/icons/wallet.png" alt="My Wallet"/> My Wallet</a></li>
		<li class=""><a href="#"><img src="{{URL::to('/')}}/public/images/icons/save-card.png" alt="Quick Pay"/> Quick Pay</a></li>-->
		<li class="{{(Route::currentRouteName() == 'dashboard.edit_profile') ? 'active' : ''}}"><a href="{{route('dashboard.edit_profile')}}"><img src="{{URL::to('/')}}/public/images/icons/profile.png" alt="My Profile"/> My Profile</a></li>
		<li class=""><a href="{{route('dashboard.logindetail')}}"><img src="{{URL::to('/')}}/public/images/icons/login-detail.png" alt="Login Detail"/> Login Detail</a></li>
		<li class=""><a href="#"><img src="{{URL::to('/')}}/public/images/icons/travellers.png" alt="Save Travellers"/> Save Travellers</a></li>
	</ul>
</div>
<script>
jQuery(document).ready(function($){
$('#profileimg').on('change', function() {
			
		 $('#prosub').submit();
	});
	});
</script>