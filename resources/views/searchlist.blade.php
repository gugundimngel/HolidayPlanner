<?php 
use App\Http\Controllers\PackageController;

	?>
<?php 
// dd($dest);die;
if($totalData !== 0){
	foreach($dest as $plist){
	     $prices = \App\PackagePrice::where('package_id', $plist->id)->orderby('id',
                                                'ASC')->first();
?>
<div class="row">
	<div class="col-lg-12">
		<div class="row pkgwrapper d_flex">
			<div class="col-sm-3 pkgimg-box d_flex">
				<a href="{{URL::to('/destinations/'.$myquery->slug.'/'.$plist->slug)}}" class="pkg-imgbx">
					<img data-original="{{URL::to('/public/img/media_gallery')}}/{{@$plist->media->images}}" width="250" class="img-fluid lazy" alt="{{@$plist->package_image_alt}}" title="" src="{{URL::to('/public/img/media_gallery')}}/{{@$plist->media->images}}" style="display: block;">
				</a>
			</div>  
			<div class="col-sm-9 d_flex padd0">
				<div class="row d_flex mar_auto_0 wd100">
					<div class="col-sm-9 pkgtext-box">
						<span>{{@$plist->no_of_nights}} Nights / {{@$plist->no_of_days}} Days</span>
						@if(@$plist->tour_code != '')
						<span class="code_span">Tour Code: <strong>{{@$plist->tour_code}}</strong></span>
						@endif
						<a class="pack_title" href="{{URL::to('/destinations/'.$myquery->slug.'/'.$plist->slug)}}">{{@$plist->package_name}}</a>
						<p>{{@$plist->details_day_night}}</p>
						<?php if(@$plist->package_topinclusions != ''){ ?>
						<i>Top Inclusion</i>
						<ul>
<?php 
$explodee = explode(',',@$plist->package_topinclusions);
if(!empty($explodee)){
for($i=0; $i<count($explodee);$i++ ){
$query = \App\SuperTopInclusion::where('id', '=', $explodee[$i]);
$Topinclusion		= $query->with(['topinclusion' => function($query) {
$query->select('id','top_inc_id','name','status','image');
}])->first();

?>
<li><div class="cus_tooltip">
@if(!empty($Topinclusion->topinclusion))
@if(@$Topinclusion->topinclusion->image != '')
<img width="20" height="20" src="{{URL::to('/public/img/topinclusion_img')}}/{{@$Topinclusion->topinclusion->image}}">
@else
<img width="20" height="20" src="{{URL::to('/public/img/topinclusion_img')}}/{{@$Topinclusion->image}}">
@endif
@else
<img width="20" height="20" src="{{URL::to('/public/img/topinclusion_img')}}/{{@$Topinclusion->image}}">
@endif
<span class="tooltiptext">{{@$Topinclusion->name}}</span></div></li>
						<?php } } ?>
						
						</ul>  
						<?php } ?>
						
					</div>			 				
					<div class="col-sm-3 txt-cntr">
						<span>
						@if($plist->price_on_request == 1)
							<div class="pkg-pricebx price_request">
								<strong>Price On Request</strong>
							</div>
						@else
							

							<div class="pkg-pricebx" style="font-size: 15px;">
								<strong><i class="fa fa-rupee-sign"></i> {{@$prices->twin}} <sub>Price/Person</sub></strong>
								<!--<strong><i class="fa fa-rupee-sign"></i> {{@$plist->sales_price}} <sub>Price/Person</sub></strong>-->
							</div>
						@endif
						</span> 
					   <a href="#" datapacid="{{$plist->id}}" data-toggle="modal"  data-target="#inquirymodal" class="btnPackageCard btn-outline myqueryli">Get Quotes</a>
                                                <a href="{{URL::to('/destinations/'.$myquery->slug.'/'.$plist->slug)}}" class="btnPackageCard btn-outline">View Details</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>	
<?php }else{
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="row pkgwrapper">
				<h2>Packages not found.</h2>
			</div>
		</div>
	</div>	
	<?php
} ?>	