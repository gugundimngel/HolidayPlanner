@extends('layouts.frontend')
@section('content')
<?php //$dest = $pagedata; ?>
<div class="custom_banner">
	<div class="container">
		<div class="row">   
			<div class="col-sm-12">
				<div class="banner_txt">
					<div class="title">
						 <h3>{{@$pagedata->title}}</h3>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="inner_page"> 
	<div class="container">
		<!--<div class="row"> 
			<div class="list_image">
				<img src="{{@$dest->data->image_base_path}}{{@$dest->data->pagedetail->image}}" class="img-fluid" alt=""/>
				<div class="opacity_banner"></div> 
			</div>
		</div>-->
		<div class="row"> 
			<div class="col-md-12">
				<div class="cus_breadcrumb">
					<ul>
						<li class="active"><a href="#">Home</a></li>
						<li><span><i class="fa fa-angle-right"></i></span></li>
						<li><a href="#">{{@$pagedata->title}}</a></li>
					</ul>
				</div>  
			</div> 
			<?php 
				if(@$pagedata->is_sidebar == 1){
					
				?>	
				<div class="col-md-3">	
					<div class="sidebar_menu airline_logos">	
						<ul>
							<li><a href="{{URL::to('/page/indigo')}}"><img src="{{URL::to('/public/img/cmspage')}}/{{@$pagedata->image}}" class="img-fluid" alt="{{@$pagedata->title}}"/></a></li>
						</ul>	
					</div> 
					<div class="sidebar_menu">	
						<ul>
							<li class="{{ (request()->is('page/indigo')) ? 'active' : '' }}"><a href="{{URL::to('/page/indigo')}}">Indigo</a></li>
							<li class="{{ (request()->is('page/goair')) ? 'active' : '' }}"><a href="{{URL::to('/page/goair')}}">GoAir</a></li> 
							<li class="{{ (request()->is('page/spicejet')) ? 'active' : '' }}"><a href="{{URL::to('/page/spicejet')}}">SpiceJet</a></li>
							<li class="{{ (request()->is('page/air-asia')) ? 'active' : '' }}"><a href="{{URL::to('/page/air-asia')}}">Air Asia</a></li>
							<li class="{{ (request()->is('page/vistara')) ? 'active' : '' }}"><a href="{{URL::to('/page/vistara')}}">Vistara</a></li>
							<li class="{{ (request()->is('page/air-india')) ? 'active' : '' }}"><a href="{{URL::to('/page/air-india')}}">Air India</a></li>
						</ul>	
					</div> 
				</div>
				<div class="col-md-9">	
					<div class="inner_page_content">
						<?php echo htmlspecialchars_decode(stripslashes(@$pagedata->content)); ?>
					</div>
				</div>
				<?php 	
				}
				else{
					?>
					<div class="col-md-12">	
						<div class="inner_page_content">
							<?php echo htmlspecialchars_decode(stripslashes(@$pagedata->content)); ?>
						</div>
					</div>
			<?php		
				}
			?>
		</div>
	</div>
</div>	
@endsection