@extends('layouts.frontend')
@section('content')
<div class="single_package">
	<div class="inner_single_package">
		<div class="container-fluid">	
			<div class="row"> 
				<div class="list_image">
					<img src="{!! asset('public/img/Frontend/img/rajastan_img.jpg') !!}" class="img-fluid" alt=""/>
					<div class="opacity_banner"></div> 
				</div>
			</div>
			<div class="row"> 
				<div class="col-md-6 col-md-offset-3 agent_thanks"> 
					<div class="check_icon"> 
						<i class="fa fa-check"></i> 
					</div>
					<h2>Thank You !!</h2>
					<p><span>Congratulations</span>, your have successfully registerd.<br/> You'll soon be contacted by our representative after we have processed your details.<br/> This normally takes 1-4 working days.</p>
					<a href="{{URL('/')}}">Back To Home</a>
				</div>
			</div> 
		</div>
	</div>
	@endsection
</div>
