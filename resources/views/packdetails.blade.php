@extends('layouts.frontend')
<?php
   $fetchmtags = \App\Metatag::where('package_id', $packagedetail->id)->first();
   ?>
@section('meta_title', @$fetchmtags->title)
@section('meta_keyword', @$fetchmtags->keyword)
@section('meta_description', @$fetchmtags->description)
@section('canonicaltag', @$fetchmtags->canonicaltag)
@section('content')
<style>
   #holder .calendar-day {
		width: 100px;
		min-width: 100px;
		max-width: 100px;
		height: 80px;
	}

	#holder .calendar-table {
		margin: 0 auto;
		width: 700px;
	}

	#packcalender {
		width: 100%;
		margin: 0px;
	}

	#packcalender .calendar-table {
		width: 100%;
	}

	#packcalender .calendar-table thead tr.c-weeks th {
		font-size: 11px;
		line-height: 14px;
	}

	#packcalender .calendar-table tr td {
		padding: 3px;
		font-size: 11px;
		line-height: 14px;
		width: 4 0px;
	}

	#packcalender .calendar-table tr td a.btn_2 {
		padding: 5px;
		font-size: 10px;
		line-height: 14px;
		border-radius: 3px !important;
	}

	#packcalender .calendar-day {
		width: auto;
		height: auto;
	}

	.selected {
		background-color: #eee;
	}

	.outside .date {
		color: #ccc;
	}

	.timetitle {
		white-space: nowrap;
		text-align: right;
	}

	#holder .event {
		border-top: 1px solid #b2dba1;
		border-bottom: 1px solid #b2dba1;
		background-image: linear-gradient(to bottom, #dff0d8 0px, #c8e5bc 100%);
		background-repeat: repeat-x;
		color: #3c763d;
		border-width: 1px;
		font-size: .75em;
		padding: 0 .75em;
		line-height: 2em;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
		margin-bottom: 1px;
	}

	#holder .event.begin {
		border-left: 1px solid #b2dba1;
		border-top-left-radius: 4px;
		border-bottom-left-radius: 4px;
	}

	#holder .event.end {
		border: 1px solid #89ad3e;
		border-radius: 0px;
		background: transparent;
		margin-bottom: 2px;
		padding: 3px 5px;
		font-size: 11px;
		line-height: 14px;
	}

	#packcalender .event.begin {
		border-left: 1px solid #b2dba1;
		border-top-left-radius: 4px;
		border-bottom-left-radius: 4px;
	}

	#packcalender .event.end {
		border: 1px solid #89ad3e;
		border-radius: 0px;
		background: transparent;
		margin-bottom: 2px;
		padding: 0px;
		font-size: 10px;
		line-height: 14px;
		width: 20px;
		overflow: hidden;
	}

	.event.all-day {
		border-top: 1px solid #9acfea;
		border-bottom: 1px solid #9acfea;
		background-image: linear-gradient(to bottom, #d9edf7 0px, #b9def0 100%);
		background-repeat: repeat-x;
		color: #31708f;
		border-width: 1px;
	}

	.event.all-day.begin {
		border-left: 1px solid #9acfea;
		border-top-left-radius: 4px;
		border-bottom-left-radius: 4px;
	}

	.event.all-day.end {
		border-right: 1px solid #9acfea;
		border-top-right-radius: 4px;
		border-bottom-right-radius: 4px;
	}

	.event.clear {
		background: none;
		border: 1px solid transparent;
	}

	.table-tight>thead>tr>th,
	.table-tight>tbody>tr>th,
	.table-tight>tfoot>tr>th,
	.table-tight>thead>tr>td,
	.table-tight>tbody>tr>td,
	.table-tight>tfoot>tr>td {
		padding-left: 0;
		padding-right: 0;
	}

	.table-tight-vert>thead>tr>th,
	.table-tight-vert>tbody>tr>th,
	.table-tight-vert>tfoot>tr>th,
	.table-tight-vert>thead>tr>td,
	.table-tight-vert>tbody>tr>td,
	.table-tight-vert>tfoot>tr>td {
		padding-top: 0;
		padding-bottom: 0;
	}

	#holder table.calendar-table tbody tr td a.btn_2 {
		padding: 5px 10px;
		font-size: 12px;
		line-height: 14px;
		border-radius: 4px !important;
	}

	#holder table.calendar-table>thead>tr>td {
		padding: 0px;
	}

	#holder table.calendar-table>thead>tr>td table {
		border: 0px;
	}

	#holder table.calendar-table>thead>tr>td>table>tbody>tr>td:nth-child(1) span.btn-group button,
	#holder table.calendar-table>thead>tr>td table tr td button.js-cal-option.active {
		background: #5091fa;
		border: 0px;
		color: #fff;
		padding: 6px 8px;
		border-radius: 4px;
	}

	#holder table.calendar-table>thead>tr>td table tbody tr td span.btn-group button:hover {
		text-decoration: none;
	}

	#holder table.calendar-table>thead>tr>td>table>tbody>tr>td:nth-child(2) span.btn-group>button {
		font-size: 18px;
	}

	#holder table.calendar-table>thead>tr>td>table>tbody>tr>td:nth-child(2) span.btn-group>button,
	#packcalender table.calendar-table>thead>tr>td>table>tbody>tr>td:nth-child(2) span.btn-group>button {
		color: #5091fa;
		padding: 0px;
		border: 0px;
		background: transparent;
	}

	#holder table.calendar-table>thead>tr>td>table>tbody>tr>td:nth-child(2) span.btn-group button.js-cal-years {
		margin-left: 10px;
	}

	#holder table.calendar-table thead tr td table tbody tr td span.btn-group .popover .popover-content button {
		padding: 5px 10px;
		font-size: 13px;
		line-height: 21px;
		height: auto
	}

	#holder table.calendar-table thead tr.c-weeks th.c-name {
		background: #5091fa;
		color: #fff;
		font-size: 13px;
		line-height: 21px;
	}

	#holder table.calendar-table thead tr.c-weeks th.c-name,
	#holder table.calendar-table tbody td.calendar-day {
		padding-left: 5px !important;
		padding-right: 5px !important;
	}

	#holder table.calendar-table tbody td.calendar-day .popover {
		display: none !important;
	}

	#holder table.calendar-table thead tr td table tr td {
		padding: 10px;
	}

	#packcalender table.calendar-table>thead>tr>td>table>tbody>tr>td:nth-child(1) span.btn-group button,
	#packcalender table.calendar-table>thead>tr>td table tr td button.js-cal-option.active {
		background: #5091fa;
		border: 0px;
		color: #fff;
		padding: 4px 6px;
		border-radius: 4px;
	}
</style>

<?php 
   use App\Http\Controllers\PackageController;
   use App\Http\Controllers\Controller;
?>

<?php 
   $dest = $packagedetail;
   $prices = \App\PackagePrice::where('package_id', $dest->id)->orderby('id', 'ASC')->first();
   //echo '<pre>'; print_r($dest); die;
?>
<input type="hidden" id="package_id" value="{{$dest->id}}">

<!-- <section class="pack_details start_bg_zoom">
   <div class="wrapper">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12">
               <div class="server-error">@include('../Elements/front-flash-message')</div>
            </div>
         </div>
         <div class="row">
            <div class="details_image">
               <img src="{{URL::to('/public/img/media_gallery')}}/{{@$dest->bamedia->images}}" class="img-fluid" alt=""/>
               <div class="opacity_banner"></div>
            </div>
         </div>
      </div>
      <div class="container">
         <div class="pack_banner_title">
            <div class="inner_title">
               <h1 class="fadeInUp animated mytitle"><span></span>{{@$dest->package_name}}</h1>
               <span class="count_days">{{@$dest->no_of_nights}} Nights / {{@$dest->no_of_days}} Days</span> 
            </div>
         </div>
      </div>
   </div>
</section> -->

<section class="packagedetailsBanner">
	<div class="container">
		<div class="bannerText">
			<h1 class="fadeInUp animated mytitle"><span></span>{{@$dest->package_name}}</h1>
			<span class="count_days"><i class="fas fa-calendar-alt"></i> {{@$dest->no_of_nights}} Nights / {{@$dest->no_of_days}} Days</span>
		</div> 
	</div>
</section>


<div class="details_main">
   <div class="bg_color_1 pack_details" style="transform: none;">
      <nav class="secondary_nav sticky_horizontal" style="">
         <div class="container">
            <ul class="pack_tabs clearfix">
                @if($dest->package_overview != '')
               <li><a href="#description" class="active">Overview</a></li>
               @endif
                @if(isset($dest->packitinerary) && count($dest->packitinerary) > 0)
               <li><a href="#itinerary">Itinerary</a></li>
               @endif
               @if($dest->package_inclusions != '')
               <li><a href="#inclu_exclu">Inclusion</a></li>
               @endif
               @if($dest->package_exclusions != '')
               <li><a href="#inclu_exclu">Exclusion</a></li>
               @endif
               @if(isset($dest->packhotel) && count($dest->packhotel) > 0)
               <li><a href="#hotels">Hotels</a></li>
               @endif
               <!--<li><a href="#price">Price & Dates</a></li>-->
               <!--<li><a href="#visa">Visa</a></li>-->
                @if(isset($dest->onward_flight) && isset($dest->return_flight) )
               <li><a href="#flights">Flights</a></li>
               @endif
               @if($dest->addon != '')
               <li><a href="#addontour">Add on Tours</a></li>
               @endif
               @if($dest->package_tourpolicy != "")
               <li><a href="#terms">Terms & Condition</a></li>
               @endif
            </ul>
         </div>
      </nav>

      <div class="container pos_relt">
         <div class="download_btn">
            @if(@$dest->pdf !="")
            <a href="{{@URL::to('/public/img/pdfs')}}/{{@$dest->pdf}}" download="{{@$dest->slug}}" class="download_icon"><i class="fa fa-download"></i> Download Itinerary</a>
            @endif
            <div class="dropdown">
               <button class="sharebtn" class="dropdown-toggle" type="button" data-toggle="dropdown" id="dropdownbtn" ><i class="fa fa-share-alt"></i></button>
               <ul class="mydropdown-menu dropdown-menu" aria-labelledby="dropdownbtn">
                  <li>    
                     <a id="WhatsApp" href="" target="_blank">
                     <img src="{!! asset('public/img/whatsapp.png') !!}" class="SocialLinkImage" alt="WhatsApp" title="WhatsApp" style="vertical-align: middle;">WhatsApp</a>
                  </li>
                  <li>  
                     <a id="Facebook" href="" target="_blank">
                     <img src="{!! asset('public/img/facebook.png') !!}" class="SocialLinkImage" alt="Facebook" title="Facebook" style="vertical-align: middle;">Facebook</a>
                  </li>
                  <li>   
                     <a id="Twitter" href="" target="_blank">
                     <img src="{!! asset('public/img/twitter_opt.png') !!}" class="SocialLinkImage" alt="Twitter" title="Twitter" style="vertical-align: middle;">Twitter</a>
                  </li>
                  <li>
                     <a id="LinkedIn" href="" target="_blank">
                     <img width="30" height="30" src="{!! asset('public/img/linkedIn_PNG36.png') !!}" class="SocialLinkImage" alt="Twitter" title="Twitter" style="vertical-align: middle;">LinkedIn</a>
                  </li>
               </ul>
               <script> 
                  $(window).load(function () {
                  	var Title = '<?php echo $dest->package_name; ?>';
                  
                  	var WhatsAppHref = "https://api.whatsapp.com/send?text=" + encodeURIComponent(Title.trim()) + ' ' + encodeURIComponent(document.URL).replace('#', '');
                  	var FacebookHref = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(window.location.href).replace('#', '') + '&title=' + encodeURIComponent(Title.trim());
                  	var TwitterHref = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(Title.trim()) + '- ' + encodeURIComponent(window.location.href).replace('#', '');
                  	var LinkedInHref = "http://www.linkedin.com/shareArticle?mini=true&url=" + encodeURIComponent(window.location.href).replace('#', '');
                  	
                  	
                  
                  	$("#WhatsApp").attr('href', WhatsAppHref);        
                  	$("#Facebook").attr('href', FacebookHref);
                  	$("#Twitter").attr('href', TwitterHref);
                  	$("#LinkedIn").attr('href', LinkedInHref);
                     // $("#GooglePlus").attr('href', GooglePlusHref);
                  
                  });
                  
               </script>
            </div>
         </div>
      </div>

	  <div class="bg-light-theme">
		<div class="container padd_30_25" style="transform: none;">
			<div id="row_scroll" class="row" style="transform: none;">
				<div class="col-lg-9">
				    @if(count(@$dest->packigalleries) > 0 )
					<section class="common_section">
						<div class="slidersection gallery_section">
							<div id="pack_carousel" class="carousel slide" data-ride="carousel">
							<!-- Wrapper for slides -->
							<div class="carousel-inner" role="listbox">
								<?php $if = 0; ?>
								@foreach(@$dest->packigalleries as $gli)
								<div class="item <?php if($if == 0){ echo 'active'; }else{} ?>">
									<img class="" style="width:100%;" src="{{@URL::to('/public/img/media_gallery')}}/{{@$gli->galleriesmedia->images}}" alt="{{$gli->package_gallery_image_alt}}" />
								</div>
								<?php $if++; ?>
								@endforeach 
							</div>
							<!-- Controls -->
							<a class="left carousel-control" href="#pack_carousel" role="button" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
							</a>
							<a class="right carousel-control" href="#pack_carousel" role="button" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
							</a>
							<!-- Indicators -->
							<ol class="carousel-indicators">
								<?php $ifd = 0; ?>
								@foreach(@$dest->packigalleries as $gli)
								<li data-target="#pack_carousel" data-slide-to="{{@$ifd}}" class="<?php if($ifd == 0){ echo 'active'; }else{} ?>">
									<img class="" src="{{@URL::to('/public/img/media_gallery')}}/{{@$gli->galleriesmedia->images}}" class="img-responsive" alt="" />
								</li>
								<?php $ifd++; ?>
								@endforeach
							</ol>
							</div>
						</div>
					</section>
                    @endif
                    
					@if($dest->package_overview != '')
					<section id="description" class="common_section">
						<h2>Description</h2>
						<div class="packagedetailsCard">
							<article data-readmore="" aria-expanded="false" id="rmjs-1" class="read-more-fade cust_article1" style="">   
								<?php echo htmlspecialchars_decode(stripslashes(@$dest->package_overview)); ?>
							</article>
						</div>
					</section>
					@endif
                    
                    @if(isset($dest->packitinerary) && count($dest->packitinerary) > 0)
					<section id="itinerary" class="common_section">
						<h2>Itinerary</h2>
						<div class="">
							<ul class="cbp_tmtimeline">
								@php
								$cs = 1;
								@endphp
								@foreach(@$dest->packitinerary as $li)
							
								<li>
									<time class="cbp_tmtime" datetime=""><span>Day</span>
									</time>
									<div class="cbp_tmicon">
									{{@$cs}}
									</div>
									<div class="cbp_tmlabel">
									    <div class="hidden-xs">
									        <?php
									        $img_id = $li->itinerary_image;
									        if($img_id != null){
									            $image = DB::table('media_images')->where('id',$img_id)->first();
    									     ?>
    										    <img src="{{ url('/public/img/media_gallery/'.$image->images) }}" alt="" class="rounded-circle thumb_visit">
    										<?php
									        }
										    ?>
										</div>
									<h4>{{@$li->title}}</h4>
									<p><?php echo strip_tags(@$li->details); ?></p>
									<?php $foodt = explode(",", rtrim(@$li->foodtype,",")); 
										if(@$li->foodtype !=""){
										?>
									<div class="itinery_meals">
										<h6>Meals:</h6>
										<ul class="bullets">
											<li><i class="fa fa-cutlery"></i></li>
											<?php 
												for($ki = 0; $ki <count($foodt); $ki++){
												?>
											<li>{{ucfirst(@$foodt[$ki])}}</li>
											<?php } ?>
										</ul>
									</div>
									<?php } ?>
									</div>
								</li>
								@php
								$cs++;
								@endphp
								@endforeach						
							</ul>
						</div>
					</section>
                    @endif
					<script> var gallerydata = new Array(); </script>
					
					@if($dest->package_inclusions != '' && $dest->package_exclusions != '')
					<section id="inclu_exclu" class="common_section">
						<div class="row">
						    @if($dest->package_inclusions != '')
							<div class="col-lg-12 mb-30">
								<h2>Inclusion</h2>
								<div class="packagedetailsCard">
									<ul class="bullets">
										<?php $inclusio = explode('~', $dest->package_inclusions); ?>
										@foreach (@$inclusio as $inclu)
										<li><i class="fas fa-check"></i> {{@$inclu}}</li>
										@endforeach
										
									</ul>
								</div>
							</div>
							@endif
                            @if($dest->package_exclusions != '')
							<div class="col-lg-12">
								<h2>Exclusion</h2>
								<div class="packagedetailsCard">
									<ul class="bullets">
										
										<?php $exclusions = explode('~', $dest->package_exclusions); ?>
										@foreach (@$exclusions as $exclu)
										<li><i class="fas fa-times"></i> {{@$exclu}}</li>
										@endforeach
										
									</ul>
								</div>
							</div>
							@endif
						</div>
					</section>
					@endif
					
					@if(isset($dest->packhotel) && count($dest->packhotel) > 0)
					<section id="hotels" class="common_section">
						<h2>Hotel Details</h2>
						<?php 
						$igh =0; ?>
						@foreach(@$dest->packhotel as $hli)
						<div class="packagedetailsCard">
							<div class="hotel_row hotel_{{$hli->hotel->id}}">
								<input type="hidden" value="0" class="mprice">
								<input type="hidden" value="{{$hli->hotel->id}}" class="hotelsid">
								<input type="hidden" value="0" class="newhotelsid">
								<input type="hidden" value="0" class="nprice">
								<div class="col-lg-12">
									<div class="row">
									<div class="col-sm-5 padding5px">
										<!-- <div class="packagedethotelimg">
											<div class="zoomicon">
												<img class="lozad" src="{!! asset('public/img/zoom.png') !!}" alt="zoom" data-loaded="true">
											</div>
											<a href="javascript:;" ng-src="{{@URL::to('/public/img/hotel_img')}}/{{$hli->hotel->image}}" class="gallerypopup">
											<img  alt="" title="{{$hli->hotel->image_alt}}" class="ng-scope" src="{{@URL::to('/public/img/hotel_img')}}/{{$hli->hotel->image}}">
											</a>
											</div> -->
										<div class="owl-carousel owl-theme">
										    <?php
										    $gallery = json_decode($hli->hotel->hotel_gallery);
										    if(!empty($gallery)){
										        foreach($gallery as $img){
												$im = DB::table('media_images')->where('id',$img)->first();
											?>
											<div class="item">
												<img class="lozad" src="{{ url('/img/media_gallery/'.$im->images) }}" alt="zoom" data-loaded="true">
											</div>
											<?php } 
										    }else{
										    ?>
											<div class="item">
												<img class="lozad" src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1421&q=80" alt="zoom" data-loaded="true">
											</div>
											<div class="item">
												<img class="lozad" src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="zoom" data-loaded="true">
											</div>
											<div class="item">
												<img class="lozad" src="https://images.unsplash.com/photo-1503220317375-aaad61436b1b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="zoom" data-loaded="true">
											</div>
											<div class="item">
												<img class="lozad" src="https://images.unsplash.com/photo-1539635278303-d4002c07eae3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="zoom" data-loaded="true">
											</div>
											<?php } ?>
										</div>
									</div>
									<div class="col-sm-7 padding5px">
										<div class="row row_margin_5">
											<div class="col-sm-8 padding5px">
												<div class="inner_hotel_pack">
												<div class="packagelistboxheading">
													<h3><a href="javascript:void(0)"  datid="<?php echo $igh; ?>" class="ng-binding hotelcontent">{{$hli->hotel->name}}</a></h3>
												</div>
												<div class="starmargin ng-binding" ng-bind-html="hotel.Categoryimg | rawHtml">
													<?php for($ik =0; $ik < $hli->hotel->hotel_category; $ik++){ ?>
													<img src="{!! asset('public/img/star.png') !!}" alt="Star Rating" title="Star Rating">
													<?php } ?>
												</div>
												<div class="textblack13cont topmargin10px">
													<?php
														$cityname = \App\Location::where('id',$hli->hotel->destination)->first();
														// 	dd($hli)
														
														?>
													<!--<span class="textblack13bold ng-scope" ng-if="hotel.Locality!=''">City:</span><span ng-if="hotel.Locality!=''" class="textblue13 optionalCategory ng-binding ng-scope" ng-bind-html="hotel.Locality | rawHtml"> {{@$cityname->name}}</span>-->
													<!-- end ngIf: hotel.Locality!='' -->
													<span class="textblack13bold ng-scope" ng-if="hotel.Locality!=''">Address:</span><span ng-if="hotel.Locality!=''" class="textblue13 optionalCategory ng-binding ng-scope" ng-bind-html="hotel.Locality | rawHtml"> {{@$hli->hotel->address}}</span><!-- end ngIf: hotel.Locality!='' --><br>
													<!--<span class="textblack13bold ng-scope" ng-if="hotel.Locality!=''">Description:</span> {!!@$hli->hotel->description!!}-->
												</div>
												</div>
											</div>
											<div class="col-sm-4 padding5px includedtxt text-right ng-binding"><span>Included in trip</span>
												@if($dest->package_type == 'fixed')
												<span><button data-hotelid="{{$hli->hotel->id}}" data-city="{{$hli->hotel->destination}}" class="openhotelpopup">Upgrade Hotel</button></span>
												@endif
												<a href=""></a>
											</div>
										</div>
									</div>
									<div class="clearfix"></div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>

						<script>
							gallerydata[<?php echo $igh; ?>] = {
							"description":"<?php echo htmlspecialchars_decode(stripslashes(@$hli->hotel->description)); ?>",
							"hotelname":'<?php echo $hli->hotel->name; ?>',
							"address":'<?php echo $hli->hotel->address; ?>',
							"star":<?php echo $hli->hotel->hotel_category; ?>,
							}
						</script>

						<?php $igh++;  ?> 
						@endforeach						
					</section>
                    @endif
					<!--<section id="visa" class="common_section">-->
					<!--	<h2>Visa</h2>-->
					<!--	<div class="packagedetailsCard">-->
					<!--		{!!$dest->visa_overview!!}-->
					<!--	</div>-->
					<!--</section>-->
                    
                    @if(isset($dest->onward_flight) && isset($dest->return_flight) )
					<section id="flights" class="common_section">
						<h2>Flight Details</h2>
						<div class="packagedetailsCard">
							<?php
								$depflight = \App\FlightDetail::where('id',@$dest->onward_flight)->with(['flight','flightsource','flightdest','returnflight'])->first();
								?>
							@if($depflight)
							<h3>Departure</h3>
							<div id="divOB1" class="allshow block-content-2 custom_block_content flight-list-v2 bingo_button_4">
								<div class="box-result custom_box_result">
									<ul class="list-search-result result_list">
									<li>
										<img src="{{URL::to('/public/img/airline')}}/{{@strtoupper($depflight->flight->code)}}.gif" alt="">
										<div class="flight_name">{{@$depflight->flight->name}}
											<span class="flight_no">{{@$depflight->flight_number}}</span>
										</div>
									</li>
									<li class="pad_left30">
										<span class="date departdate">{{date('h:i', strtotime($depflight->dep_time))}}</span>
										{{@$depflight->flightsource->city_code}}
									</li>
									<li>
										<span class="duration">
											<?php echo Controller::GetTimeduration($depflight->dep_time, $depflight->arival_time); ?>
											<div class="cus_tooltip">{{$depflight->stop}}</div>
										</span>
									</li>
									<li class="pad_left30">
										<span class="date arivedate">{{date('h:i', strtotime($depflight->arival_time))}}</span>
										{{@$depflight->flightdest->city_code}}	
									</li>
									<!--<li class="price">
										<i class="fa fa-rupee-sign"></i>{{$depflight->bc_total}}</li>  -->
									</ul>
									<!-- .list-search-result end -->
									<div class="clearfix"></div>
									<div class="flight_details">
									<a href="javascript:;" dataid="0" class="details_btn">Fight Details</a> 
									<div class="flightrefund" style="float: right;margin-right: 15px;">
									</div>
									<div class="clearfix"></div>
									<div class="flight_details_info" id="show_0">
										<ul class="nav nav-tabs custom_tabs">
											<li class="active"><a href="#flightinfo00" aria-controls="flightinfo" role="tab" data-toggle="tab">Flight Information</a></li>
											<li class=""><a href="#faredetail01" aria-controls="faredetail" class="" role="tab" data-toggle="tab">Fare Details</a></li>
											<li class=""><a href="#baggageinfo02" aria-controls="baggageinfo" role="tab" data-toggle="tab">Baggage Information</a></li>
											<li class=""><a href="#cancellationrule03" aria-controls="cancellationrule" class="farerule" role="tab" data-toggle="tab">Cancellation Rules</a></li>
										</ul>
										<div class="flight_details_close cus_flight_detail_close">
											<a href="javascript:;"><i class="fa fa-times"></i></a>
										</div>
										<div class="tab-content">
											<div role="tabpanel" class="tab-pane active" id="flightinfo00">
												<div class="flight_route">
												<h4>{{@$depflight->flightsource->city_code}} <span><i class="fa fa-arrow-right"></i></span> {{@$depflight->flightdest->city_code}}</h4>
												<div class="flight_route_list">
													<ul>
														<li>
															<img src="{{URL::to('/public/img/airline')}}/{{@strtoupper($depflight->flight->code)}}.gif" alt="">
															<div class="flight_name">
															<span class="flight_no">{{$depflight->flight_number}}</span>
															</div>
														</li>
														<li class="flight_timer">
															{{@$depflight->flightsource->city_code}} {{date('h:i', strtotime($depflight->dep_time))}} <span>{{date('D, d M Y', strtotime($depflight->dep_time))}}</span>
														</li>
														<li>
															<span class="duration"><span><i class="fa fa-clock"></i></span><?php echo Controller::GetTimeduration($depflight->dep_time, $depflight->arival_time); ?> </span>
														</li>
														<li class="flight_timer">
															{{@$depflight->flightdest->city_code}} {{date('h:i', strtotime($depflight->arrival_time))}} <span>{{date('D, d M Y', strtotime($depflight->arival_time))}}</span>
														</li>
													</ul>
													<div class="clearfix"></div>
												</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane" id="faredetail01">
												<div class="fare_details">
												<div class="row">
													<p><?php echo htmlspecialchars_decode(stripslashes(@$depflight->fare_detail)); ?></p>
													<div class="clearfix"></div>
												</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane" id="baggageinfo02">
												<div class="baggage_info">
												<div class="baggage_row baggage_border">
													<div class="col-sm-3 col-xs-3 baggcol_3">
														<div class="baggage_title">AIRLINE</div>
													</div>
													<div class="col-sm-3 col-xs-3 baggcol_3">
														<div class="baggage_title">Check-in Baggage</div>
													</div>
													<div class="col-sm-3 col-xs-3 baggcol_3">
														<div class="baggage_title">Cabin Baggage</div>
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="baggage_row">
													<div class="col-sm-3 col-xs-3 baggcol_3">
														<div class="baggage_value">
															<img src="{{URL::to('/public/img/airline')}}/{{@strtoupper($depflight->flight->code)}}.gif" alt="">
															<div class="flight_name"><span>{{@$depflight->flight->name}}</span><span>{{@$depflight->flight_number}}</span></div>
														</div>
													</div>
													<div class="col-sm-3 col-xs-3 baggcol_3">
														<div class="baggage_value">
															<span>{{@$depflight->check_in_baggage}}</span>
														</div>
													</div>
													<div class="col-sm-3 col-xs-3 baggcol_3">
														<div class="baggage_value">
															<span>{{@$depflight->cabbin_baggage}}</span>
														</div>
													</div>
													<div class="clearfix"></div>
												</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane" id="cancellationrule03">
												<div class="cancellationrule_info">
												<?php echo htmlspecialchars_decode(stripslashes(@$depflight->cancellation_policy)); ?>
												<div class="clearfix"></div>
												</div>
											</div>
										</div>
									</div>
									</div>
								</div>
								<!-- .box-result end -->
							</div>
							@endif
							<?php
								$retflight = \App\FlightDetail::where('id',@$dest->return_flight)->with(['flight','flightsource','flightdest','returnflight'])->first();
								?>
							@if($retflight)
							<h3>Return</h3>
							<div id="divOB1" class="allshow block-content-2 custom_block_content flight-list-v2 bingo_button_4">
								<div class="box-result custom_box_result">
									<ul class="list-search-result result_list">
									<li>
										<img src="{{URL::to('/public/img/airline')}}/{{@strtoupper($retflight->flight->code)}}.gif" alt="">
										<div class="flight_name">{{@$retflight->flight->name}}
											<span class="flight_no">{{@$retflight->flight_number}}</span>
										</div>
									</li>
									<li class="pad_left30">
										<span class="date departdate">{{date('h:i', strtotime($retflight->dep_time))}}</span>
										{{@$retflight->flightsource->city_code}}
									</li>
									<li>
										<span class="duration">
											<?php echo Controller::GetTimeduration($retflight->dep_time, $retflight->arival_time); ?>
											<div class="cus_tooltip">{{$retflight->stop}}</div>
										</span>
									</li>
									<li class="pad_left30">
										<span class="date arivedate">{{date('h:i', strtotime($retflight->arival_time))}}</span>
										{{@$retflight->flightdest->city_code}}	
									</li>
									<!--<li class="price">
										<i class="fa fa-rupee-sign"></i>{{$retflight->bc_total}}</li>  -->
									</ul>
									<!-- .list-search-result end -->
									<div class="clearfix"></div>
									<div class="flight_details">
									<a href="javascript:;" dataid="1" class="details_btn">Fight Details</a> 
									<div class="flightrefund" style="float: right;margin-right: 15px;">
									</div>
									<div class="clearfix"></div>
									<div class="flight_details_info" id="show_1">
										<ul class="nav nav-tabs custom_tabs">
											<li class="active"><a href="#flightinfo01" aria-controls="flightinfo" role="tab" data-toggle="tab">Flight Information</a></li>
											<li class=""><a href="#faredetail02" aria-controls="faredetail" class="" role="tab" data-toggle="tab">Fare Details</a></li>
											<li class=""><a href="#baggageinfo03" aria-controls="baggageinfo" role="tab" data-toggle="tab">Baggage Information</a></li>
											<li class=""><a href="#cancellationrule04" aria-controls="cancellationrule" class="farerule" role="tab" data-toggle="tab">Cancellation Rules</a></li>
										</ul>
										<div class="flight_details_close cus_flight_detail_close">
											<a href="javascript:;"><i class="fa fa-times"></i></a>
										</div>
										<div class="tab-content">
											<div role="tabpanel" class="tab-pane active" id="flightinfo01">
												<div class="flight_route">
												<h4>{{@$retflight->flightsource->city_code}} <span><i class="fa fa-arrow-right"></i></span> {{@$retflight->flightdest->city_code}}</h4>
												<div class="flight_route_list">
													<ul>
														<li>
															<img src="{{URL::to('/public/img/airline')}}/{{@strtoupper($retflight->flight->code)}}.gif" alt="">
															<div class="flight_name">
															<span class="flight_no">{{$retflight->flight_number}}</span>
															</div>
														</li>
														<li class="flight_timer">
															{{@$retflight->flightsource->city_code}} {{date('h:i', strtotime($retflight->dep_time))}} <span>{{date('D, d M Y', strtotime($retflight->dep_time))}}</span>
														</li>
														<li>
															<span class="duration"><span><i class="fa fa-clock"></i></span><?php echo Controller::GetTimeduration($retflight->dep_time, $retflight->arival_time); ?> </span>
														</li>
														<li class="flight_timer">
															{{@$retflight->flightdest->city_code}} {{date('h:i', strtotime($retflight->arrival_time))}} <span>{{date('D, d M Y', strtotime($retflight->arival_time))}}</span>
														</li>
													</ul>
													<div class="clearfix"></div>
												</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane" id="faredetail02">
												<div class="fare_details">
												<div class="row">
													<p><?php echo htmlspecialchars_decode(stripslashes(@$retflight->fare_detail)); ?></p>
													<div class="clearfix"></div>
												</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane" id="baggageinfo03">
												<div class="baggage_info">
												<div class="baggage_row baggage_border">
													<div class="col-sm-3 col-xs-3 baggcol_3">
														<div class="baggage_title">AIRLINE</div>
													</div>
													<div class="col-sm-3 col-xs-3 baggcol_3">
														<div class="baggage_title">Check-in Baggage</div>
													</div>
													<div class="col-sm-3 col-xs-3 baggcol_3">
														<div class="baggage_title">Cabin Baggage</div>
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="baggage_row">
													<div class="col-sm-3 col-xs-3 baggcol_3">
														<div class="baggage_value">
															<img src="{{URL::to('/public/img/airline')}}/{{@strtoupper($retflight->flight->code)}}.gif" alt="">
															<div class="flight_name"><span>{{@$retflight->flight->name}}</span><span>{{@$retflight->flight_number}}</span></div>
														</div>
													</div>
													<div class="col-sm-3 col-xs-3 baggcol_3">
														<div class="baggage_value">
															<span>{{@$retflight->check_in_baggage}}</span>
														</div>
													</div>
													<div class="col-sm-3 col-xs-3 baggcol_3">
														<div class="baggage_value">
															<span>{{@$retflight->cabbin_baggage}}</span>
														</div>
													</div>
													<div class="clearfix"></div>
												</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane" id="cancellationrule04">
												<div class="cancellationrule_info">
												<?php echo htmlspecialchars_decode(stripslashes(@$retflight->cancellation_policy)); ?>
												<div class="clearfix"></div>
												</div>
											</div>
										</div>
									</div>
									</div>
								</div>
								<!-- .box-result end -->
							</div>
							@endif
						</div>
					</section>
                    @endif
                    
					@if($dest->addon != '')
					<section id="addontour" class="common_section">
						<h2>Add-Ons</h2>
						<div class="packagedetailsCard">
							<div class="addon_table table-responsive">
								<table class="table">
									<thead>
									<tr>
										<th></th>
										<th>Price</th>
										<th>Duration</th>
										<!--<th>Action</th>-->
									</tr>
									</thead>
									<tbody>
									<?php 
										$expaddon = explode(',', $dest->addon); 
										for($ai = 0; $ai<count($expaddon); $ai++){
											$addon = \App\Addon::where('id',$expaddon[$ai])->first();
										?>
									<tr>
										<td>{{@$addon->title}}</td>
										<td><i class="fa fa-rupee-sign"></i> {{@$addon->price}}</td>
										<td>{{@$addon->duration}}</td>
										<!--<td><a href="#"><i class="fa fa-plus"></i></a> / <a href="#"><i class="fa fa-trash"></i></a></td>-->
									</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</section>
				    @endif
				    
				    @if($dest->package_tourpolicy != "")
					<section id="terms" class="common_section">
						<h2>Terms & Condition</h2>
						<div class="packagedetailsCard">
							<ul class="bullets">
								@if($dest->package_tourpolicy != '')
								<?php $tourpolicy = explode('~', $dest->package_tourpolicy); ?>
								@foreach (@$tourpolicy as $tourpoli)
								<li>{{@$tourpoli}}</li>
								@endforeach
								@endif
							<ul>
						</div>
					</section>
					@endif
				</div>

				<aside class="col-lg-3 pack_sidebar" id="sidebar" style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">
					<div class="trip_inclusion">
						<span>Group Holidays</span>
						<?php if(@$dest->package_topinclusions != ''){ ?>
						<ul class="bullets">
							<?php 
								$explodee = explode(',',@$dest->package_topinclusions);
								if(!empty($explodee)){
									for($i=0; $i<count($explodee);$i++ ){
									$query = \App\SuperTopInclusion::where('id', '=', $explodee[$i]);
									$Topinclusion		= $query->with(['topinclusion' => function($query) {
									$query->select('id','top_inc_id','name','status','image');
									}])->first();
								?>
							<li><img width="20" height="20" src="{{URL::to('/public/img/topinclusion_img')}}/{{@$Topinclusion->image}}">{{@$Topinclusion->name}}</li>
							<?php } } ?>  
						</ul>
						<?php } ?> 
					</div>

					<div class="theiaStickySidebar">
						<div class="booking_sidebar " style="display:none">
							<div class="fare_rules sidebar_bgclr inner_sidebar" id="DivFareQuote" >
								<ul>
								<li style="display:none" class="myadults">Adults  x <span class="no_adult">0</span>  <span class="adultprices price"><i class="fa fa-rupee-sign"></i> 0</span></li>
								<li style="display:none" class="myinfants">Infant  x <span class="no_infants">0</span>  <span class=" price"><i class="fa fa-rupee-sign"></i> 0</span></li>
								<li style="display:none" class="mycwb">Child with bed  x <span class="no_cwb">0</span>  <span class=" price"><i class="fa fa-rupee-sign"></i> 0</span></li>
								<li style="display:none" class="mycwob">Child without bed  x <span class="no_cwob">0</span>  <span class=" price"><i class="fa fa-rupee-sign"></i> 0</span></li>
								<li style="display:none" class="mycwobb">Child without bed<br>(below 2-3 years)  x <span class="no_cwobb">0</span>  <span class=" price"><i class="fa fa-rupee-sign"></i> 0</span></li>
								<li style="display:none" class="rmyaddons">Addons  x <span class="no_addon">0</span>  <span class=" price"><i class="fa fa-rupee-sign"></i> 0</span></li>
								</ul>
							</div>
						</div>
					
						<div class="pkgform-wrapper">
							<div class="package_price ">
								<div class="pack_price_sec">
								<input type="hidden" class="mytotalprice" value="0">							
								<div class="pack_price_txt">
								    @if(isset($prices) && $prices->twin)
									<!--<strike><i class="fa fa-rupee-sign"></i> 95,705</strike>-->
									<h4><i class="fa fa-rupee-sign"></i> <?php echo number_format(@$prices->twin); ?>
										<br>
										<sub>Price Per Adult Twin Sharing Basis</sub>
									</h4>
									@else
									<h4>Price on request</h4>
									@endif
								</div>
								</div>
								<div class="pack_book_btn">
								@if(@$dest->package_type == 'group')
								<!--<a href="#price" class="">Book Online</a>-->
								@else
								<!--<a  href="javascript:;" onClick="getalluserinfo()">Book Online</a>-->
								@endif
								</div>
							</div>
							<a href="#" data-packageid="{{ $dest->id }}" data-toggle="modal" data-target="#inquirymodal" class="btnPackageCard rounded btn btn-primary myqueryli packModal">Book Now</a>
						</div>
					</div>
				</aside>
			</div>

			@if($totalpac !== 0)
			<div class="row">
				<div class="similar_packages">
					<div class="main_title_2">
						<h2>Similar Packages</h2>
					</div>

					<div id="reccomended" class="owl-carousel owl-theme cus_carousel">
						@foreach(@$Packages as $rplist)
						<div class="item">
							<div class="box_grid">
								<figure>
								<a href="#0" class="wish_bt"></a>
								<a href="{{URL::to('/destinations/'.$dslug.'/'.$rplist->slug)}}">
									<img src="{{URL::to('/public/img/media_gallery')}}/{{@$rplist->media->images}}" class="img-fluid" alt="" width="800" height="533">
									<div class="read_more"><span>Read more</span></div>
								</a>
								<small>Historic</small>
								</figure>
								<div class="wrapper">
								<h3><a href="{{URL::to('/destinations/'.$dslug.'/'.$rplist->slug)}}">{{$rplist->package_name}}</a></h3>
								<p>{{$rplist->details_day_night}}</p>
								@if(@$rplist->price_on_request == 1)
								<span class="price">Price on Request</span>
								@else
								<span class="price">From <strong><i class="fa fa-inr"></i>  {{$rplist->sales_price}}</strong> /per person</span>
								@endif
								</div>
								<ul>
								<li><i class="icon_clock_alt"></i> {{$rplist->no_of_nights}}N/{{$rplist->no_of_days}}D</li>
								</ul>
							</div>
						</div>
						<!-- /item -->  
						@endforeach
					</div>
					<!-- /carousel --> 
					<div class="container">
						<p class="btn_home_align"><a href="#" class="btn_1 rounded">View all Tours</a></p>
					</div>
				</div>
			</div>
			@endif
		</div>
	  </div>

   </div>
</div>

<div class="modal fade" id="inquirymodal" tabindex="-1" role="dialog" aria-labelledby="inquirymodalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="inquirymodalLabel">Quick Inquiry</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="pkgform-wrapper">
               <div class="cont-wth1">
                  <div class="pkgform-box">
                     {{ Form::open(array('url' => 'package-enquiry', 'name'=>"queryform", 'autocomplete'=>'off','id'=>'package_enquiry')) }}
                     <span class="customerror"></span>
                     <input type="text" data-valid='required' name="name" class="form-control" value="" placeholder="Name">
                     <input type="text" data-valid='required' name="email" class="form-control" value="" placeholder="Email">
                     <input type="text" data-valid='required' name="phone" class="form-control" value="" placeholder="Phone">
                     <input type="text" data-valid='required' name="city" class="form-control" value="" placeholder="City">
                     <div class="form-group">
                        <input type="text" id="" data-valid='required' name="traveldate" class="form-control" value="" placeholder="Travel Date">
                     </div>
                     <div class="row">
                        <div class="col-sm-6 col-xs-6 codwh">
                           <select class="form-control" name="adults">
                              <option value="">Adults*</option>
                              <?php
                                 for ($ai = 1; $ai <= 10; $ai++) {
                                 ?>
                              <option value="{{$ai}}">{{$ai}}</option>
                              <?php
                                 }
                                 ?>
                           </select>
                        </div>
                        <div class="col-sm-6 col-xs-6 leftpd">
                           <select class="form-control" name="children">
                              <option value="">Children (5-12 yr)</option>
                              <?php
                                 for ($ck = 1; $ck <= 10; $ck++) {
                                 ?>
                              <option value="{{$ck}}">{{$ck}}</option>
                              <?php
                                 }
                                 ?>
                           </select>
                        </div>
                     </div>
                     <textarea class="form-control" type="text" name="add_info" placeholder="Want to customize this package? Tell us more"></textarea>
                     <div class="row">
                        <div class="col-sm-7 col-xs-8 codwh">
                           <?php $codes = rand(1000, 9999); ?>
                           <input data-valid='required captcha' class="form-control" type="text" name="captcha" value="" placeholder="Enter Code" maxlength="4">
                        </div>
                        <div class="col-sm-5 col-xs-4 codwh-1">
                           <input type="hidden" name="code" value="{{$codes}}">
                           <img src="{{route('sicaptcha')}}?code={{$codes}}" class="img-responsive" alt="Captcha" width="65" height="25">
                        </div>
                     </div>
                     <input type="hidden" id="m_package_id" name="package_id" value="">
                     <!--{{ Form::button('Submit', ['class'=>'submitbtt']) }}-->
                     <button type="submit" class="submitbtt">Submit</button>
                     {{ Form::close() }}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php
   $allprice = \App\PackagePrice::select('departure_date','twin','single','triple','child_with_bed','child_without_bedbelow12','child_without_bedbelow26','infant','no_of_seats')->where('package_id',$dest->id)->orderby('id', 'ASC')->get();
   $jsonprice = array();
   //echo '<pre>'; print_r($allprice); die;
   foreach($allprice as $slpriced){
   $expss = $slpriced->departure_date;
    $year = explode('/',$expss);
   	$date = $year[2].'-'.($year[0]).'-'.$year[1];
   	$curdate = date('Y-m-d');
   	
   	 $mdate = strtotime($date);
   	 if(strtotime($curdate) <= $mdate){
   	$jsonprice[$mdate] = array(
   		'twin' => $slpriced->twin,
   		'single' => $slpriced->single,
   		'triple' => $slpriced->triple,
   		'child_with_bed' => $slpriced->child_with_bed,
   		'child_without_bedbelow12' => $slpriced->child_without_bedbelow12,
   		'child_without_bedbelow26' => $slpriced->child_without_bedbelow26,
   		'infant' => $slpriced->infant,
   	);
    }
   /*  foreach($expss as $keys => $lprices){
   	 $year = explode('/',$lprices);
   	$date = $year[2].'-'.($year[0]).'-'.$year[1];
   	$curdate = date('Y-m-d');
   	
   	 $mdate = strtotime($date);
   	 if(strtotime($curdate) <= $mdate){
   	$jsonprice[$mdate] = array(
   		'twin' => $slpriced->twin,
   		'single' => $slpriced->single,
   		'triple' => $slpriced->triple,
   		'child_with_bed' => $slpriced->child_with_bed,
   		'child_without_bedbelow12' => $slpriced->child_without_bedbelow12,
   		'child_without_bedbelow26' => $slpriced->child_without_bedbelow26,
   		'infant' => $slpriced->infant,
   	);
    }
    } */
   
   }
   
    Controller::callender();
    $pricesmy = \App\PackagePrice::where('package_id', $dest->id)->orderby('id', 'ASC')->get();
    
?>
<script>
$(".packModal").on('click',function(){
   	    $id = $(this).data('packageid');
   	    $('#m_package_id').val($id);
   	  
   	});
   $(function() {
		var owl = $(".owl-carousel");
		owl.owlCarousel({
			items: 1,
			margin: 10,
			loop: true,
			nav: true,
			dots: false,
		});
		$( ".owl-prev").html('<i class="fa fa-chevron-left"></i>');
		$( ".owl-next").html('<i class="fa fa-chevron-right"></i>');
	});
   
</script>

<script>
   var jsonprice = '<?php echo json_encode($jsonprice); ?>';
   var data = [],
       date = new Date(),
       d = date.getDate(),
       d1 = d,
       m = date.getMonth(),
       y = date.getFullYear(),
       i,
       end, 
       j, 
       c = 1063, 
       c1 = 3329,
       h,  
       m;
   <?php
      foreach($pricesmy as $key => $lpriced){
      $exp =@ $lpriced->departure_date;
      $no_of_seats = @$lpriced->no_of_seats;	
      //foreach($exp as $key => $lprice){
      	$year = explode('/',$exp);
      	$date = $year[2].'-'.($year[0]).'-'.$year[1];
      	$mdate = date('M d, Y', strtotime($date));
      	$curdate = date('Y-m-d');
      	 if(strtotime($curdate) <= strtotime($mdate)){
      ?> 
   data.push({ seats:'<?php echo $no_of_seats; ?>',title: '<?php echo @$lpriced->twin; ?>', start: new Date('<?php echo $year[2]; ?>', '<?php echo $year[0] -1; ?>', '<?php echo $year[1]; ?>', '00', '00'), end: new Date('<?php echo $year[2]; ?>', '<?php echo $year[0] -1; ?>', '<?php echo $year[1]; ?>', '00', '00'), allDay: 0, text: '', href:'javascript:;', datename:'<?php echo $mdate; ?>', datetimem:'<?php echo strtotime($date); ?>'  });
   <?php } 
      //} 
      } ?>
     data.sort(function(a,b) { return (+a.start) - (+b.start); });
   //https://zapbooking.com/package/booking/{{base64_encode(convert_uuencode(@$dest->id))}}?date={{@$date}}
</script>

<script>  
   function getalluserinfo(){
   	var i = 0;
   	$(".custom-error").remove(); 
   		var formName = 'personpackage';
   			$("form[name="+formName+"] :input[data-valid]").each(function(){
   				var dataValidation = $(this).attr('data-valid');
   				var splitDataValidation = dataValidation.split(' ');
   				var j = 0;
   				if($.inArray("required", splitDataValidation) !== -1) //for required
   				{
   				
   					var for_class = $(this).attr('class');	
   					
   							if( $(this).val() == 0) 
   								{
   									i++;
   									j++;
   									$(this).after("<span class='custom-error' role='alert'>This field is required</span>");  
   								}
   						
   				}
   				
   			});
   	
   			if(i > 0){
   				
   			}else{
   					var html = "";
   					$(".roomno").each(function() {
   					  var val = $(this).val();
   						  var inval = 0;
   						//inval = $("#room"+val+" input[name='packinfant']").val();
   						var cwbval = 0;
   						$("#room"+val+" .cwbprice").each(function() {
   						   cwbval++;
   						});
   						var cwobval = 0;
   						$("#room"+val+" .cwobprice").each(function() {
   						   cwobval++;
   						});
   						var cwobbprice = 0;
   						$("#room"+val+" .cwobbprice").each(function() {
   						   cwobbprice++;
   						});
   						
   					  html += val+'-'+$('#room'+val+' input[name="packadult"]').val()+'-'+inval+'-'+cwbval+'-'+cwobval+'-'+cwobbprice+'|';
   					});
   					var addons = '';
   						$(".myaddons").each(function() {
   						   addons += $(this).val()+'|';
   						});
   					var f = html.slice(0,-1);
   					var addo = addons.slice(0,-1);
   					
   					var hotelsid = '';
   						$(".hotelsid").each(function() {
   						   hotelsid += $(this).val()+'|';
   						});
   					var hdid = hotelsid.slice(0,-1);
   					var inchotelsid = '';
   						$(".newhotelsid").each(function() {
   						   inchotelsid += $(this).val()+'|';
   						});
   					var nhdid = inchotelsid.slice(0,-1);
   					
   					window.location.href= "{{URL::to('/package/booking')}}/{{base64_encode(convert_uuencode(@$dest->id))}}?srch="+f+'&date='+$('#dpdate').val()+'&addons='+addo+'&hid='+hdid+'&nhdid='+nhdid;
   			}
   		}
   	jQuery(document).ready(function($){
   		$(document).delegate('.openhotelpopup', 'click', function(){
   			$('.myoverlay').show();
   			var v = $('#packagetravel #dpdate').val();
   			var city = $(this).data('city');
   			var hotelid = $(this).attr('data-hotelid');
   			
   			var package_id = $('#package_id').val();
   			if(v == ''){
   				alert('Please select date first');
   				$('html, body').animate({
   				scrollTop: $("#price").offset().top -100
   			}, 2000);
   			}else{
   				$('#openhotelpopup').modal('show');
   				$.ajax({
   		   url:"{{URL::to('/Package/hotels/')}}",
   		   method:'GET',
   		   data:{city:city,packageid:package_id,hotel_id:hotelid},
   		   success:function(data)
   		   {
   			   $('.myoverlay').hide();
   				$('.cityhotel').html(data);
   		   }
   		  });
   			}
   		});	
   		
   		$(document).delegate('.closepackagepopup', 'click', function(){
   			calculatepackage();
   			var packadult = 0,
   			noinfant = 0,		
   			cwobprice = 0,		
   			cwbprice = 0,		
   			cwobbprice = 0;	
   			var topackadult = 0,
   			tonoinfant = 0,		
   			tocwobprice = 0,		
   			tocwbprice = 0,		
   			tocwobbprice = 0;	
   			$(".roomno").each(function() {
   			  var val = $(this).val();
   				  var inval = 0;
   				  var inf = 0;
   				inval = $("#room"+val+" input[name='packadult']").val();
   				var adulpriceval = 0;
   				$("#room"+val+" .adultsingleprice").each(function() {
   				   adulpriceval += parseInt($(this).val());
   				});
   				inf = $("#room"+val+" input[name='packinfant']").val();
   				var infpriceval = 0;
   				$("#room"+val+" .infantprice").each(function() {
   				   infpriceval += parseInt($(this).val());
   				});
   				var cwbval = 0;
   				var cwbpriceval = 0;
   				$("#room"+val+" .cwbprice").each(function() {
   				   cwbval++;
   				   cwbpriceval += parseInt($(this).val());
   				});
   				var cwobval = 0;
   				var cwobpriceval = 0;
   				$("#room"+val+" .cwobprice").each(function() {
   				   cwobval++;
   				   cwobpriceval += parseInt($(this).val());
   				});
   				var cwobbpriceval = 0;
   				var cwobbval = 0;
   				$("#room"+val+" .cwobbprice").each(function() {
   				   cwobbval++;
   				   cwobbpriceval += parseInt($(this).val());
   				});
   			packadult += parseInt(inval);		
   			noinfant += parseInt(inf);		
   			cwobprice += parseInt(cwobval);		
   			cwbprice += parseInt(cwbval);		
   			cwobbprice += parseInt(cwobbval);		
   						
   			topackadult += parseInt(adulpriceval);		
   			tonoinfant += parseInt(infpriceval);		
   			tocwobprice += parseInt(cwobpriceval);		
   			tocwbprice += parseInt(cwbpriceval);		
   			tocwobbprice += parseInt(cwobbpriceval);
   			});
   			$('.booking_sidebar').show();
   			$('.myadults').show();
   			$('.no_adult').html(packadult);
   			$('.myadults .price').html('<i class="fa fa-rupee-sign"></i> '+topackadult);
   			if(noinfant > 0){
   			$('.myinfants').show();
   			$('.no_infants').html(noinfant);
   			$('.myinfants .price').html('<i class="fa fa-rupee-sign"></i> '+tonoinfant);
   			
   			}
   			if(cwbprice > 0){
   			$('.mycwb').show();
   			$('.no_cwb').html(cwbprice);
   			$('.mycwb .price').html('<i class="fa fa-rupee-sign"></i> '+tocwbprice);
   			}
   			if(cwobprice > 0){
   			$('.mycwob').show();
   			$('.no_cwob').html(cwobprice);
   			$('.mycwob .price').html('<i class="fa fa-rupee-sign"></i> '+tocwobprice);
   			}
   			if(cwobbprice > 0){
   			$('.mycwobb').show();
   			$('.no_cwobb').html(cwobbprice);
   			$('.mycwobb .price').html('<i class="fa fa-rupee-sign"></i> '+tocwobbprice);
   			}
   			var adons = 0;
   			$(".myaddons").each(function() {
   				   adons++;
   	
   				});
   				if(adons > 0){
   			$('.rmyaddons').show();
   			$('.no_addon').html(adons);
   				}
   			$('#packagetravel').modal('hide');
   			
   		});
   		var vccc = 1;
   		$(document).delegate('.addaddon', 'click', function(){
   			var i = $(this).attr('data-id');
   			var p = $(this).attr('data-price');
   			var pc = $(this).attr('data-child');
   			var pi = $(this).attr('data-infant');
   			$('.addon'+i+' .removeaddon').show();
   			$('.addon'+i+' .addaddon').hide();
   			$('.addons .addonli').append('<li dataprice="'+p+'" datachild="'+pc+'" datainfant="'+pi+'" class="addonid'+i+' alladdons">Addon <span class="adultprices price"><i class="fa fa-rupee-sign"></i> '+p+'</span><input type="hidden" class="myaddons" value="'+i+'"></li>');
   			calculatepackage();
   		});
   		$(document).delegate('.showpackagetravel', 'click', function(){
   			var v = $(this).attr('datadatename');
   			var vs = $(this).attr('datadatetime');
   			$('.depdates').html(v);
   			$('#dpdate').val(vs);
   			$('#packagetravel').modal('show');
   			calculatepackage(1);
   		});
   		$(document).delegate('.removeaddon', 'click', function(){
   			var i = $(this).attr('data-id');
   			
   			$('.addon'+i+' .removeaddon').hide();
   			$('.addon'+i+' .addaddon').show();
   			$('.addons .addonli .addonid'+i).remove();
   			calculatepackage(); 
   			 var numItems = $('.alladdons').length;
   			 if(numItems == 0){
   				 $('.addons').hide();
   			 }
   		});
   	$(document).delegate('.remroom', 'click', function(){
   	
   	var v = $('.allroms:last table').attr('id');
   
   	
   	 var res = v.charAt(v.length-1);
   	 	$('.allroms:last').remove();
   		 var numItems = $('.allroms').length;
   	
   	calculatepackage(res);
   	  calculatechildprice(res);
   if(numItems == 0){
   	 $('.rmrooms').hide();
    }
   
   });
   		function calculatepackage(fieldName){
   			var objjson = $.parseJSON(jsonprice);
   			var cc = $('#dpdate').val();
   		
   			var obj = objjson[cc];
   			
   			var price = 0;
   			var perprice = 0;
   			var ptwinprice = $('#room'+fieldName+' input[name="packadult"]').val();
   			
   			if(ptwinprice == 1){
   				price = obj.single;
   			}else if(ptwinprice == 2){
   				price = obj.twin;
   			}else{
   				price = obj.triple;
   			}
   			
   			$('#room'+fieldName+' .perprice').html('<i class="fa fa-rupee-sign"></i> '+price);
   				var perprice = parseInt(price) * ptwinprice;
   				
   			$('#room'+fieldName+' .netprice').html('<i class="fa fa-rupee-sign"></i> '+perprice+' <input type="hidden" class="adultsingleprice" value="'+perprice+'">');
   			var cwbval = 0;
   			$(".adultsingleprice").each(function() {
   			   cwbval += parseInt($(this).val());
   			});
   		
   			var counttravler = $('.counttravler').length;
   			$('.base_travel').html(counttravler);
   			$('.base_travel').attr('data-no', counttravler);
   			$('.no_adult').html(ptwinprice);
   			
   			$('.basefare .adultprices').html('<i class="fa fa-rupee-sign"></i> '+perprice);
   			
   			$('#adulttotal').val(cwbval);
   			var childtotl = $('#childtotal').val();
   			var adulttotal = $('#adulttotal').val();
   			var packadult = 0;
   			var noinfant = 0;
   			var cwobprice = 0;
   			var cwbprice = 0;
   			var cwobbprice = 0;
   			$(".roomno").each(function() {
   			  var val = $(this).val();
   				  var inval = 0;
   				  var inf = 0;
   				inval = $("#room"+val+" input[name='packadult']").val();
   				//inf = $("#room"+val+" input[name='packinfant']").val();
   				var cwbval = 0;
   				$("#room"+val+" .cwbprice").each(function() {
   				   cwbval++;
   				});
   				var cwobval = 0;
   				$("#room"+val+" .cwobprice").each(function() {
   				   cwobval++;
   				});
   				var cwobbval = 0;
   				$("#room"+val+" .cwobbprice").each(function() {
   				   cwobbval++;
   				});
   			packadult += parseInt(inval);		
   			//noinfant += parseInt(inf);		
   			cwobprice += parseInt(cwobval);		
   			cwbprice += parseInt(cwbval);		
   			cwobbprice += parseInt(cwobbval);		
   		
   			});
   			var hprice = 0;
   			 $(".mprice").each(function() {
   				   hprice += parseInt($(this).val());
   				}); 
   				console.log(hprice);
   			var totalchild = parseInt(cwobprice) + parseInt(cwbprice) + parseInt(cwobbprice);
   		
   			var inval = 0;
   			$(".alladdons").each(function() {
   			   inval += parseInt($(this).attr('dataprice'));
   			});
   			
   			var adult = parseInt(inval) * parseInt(packadult);
   			console.log('adult'+adult);
   			var childval = 0;
   			$(".alladdons").each(function() {
   			   childval += parseInt($(this).attr('datachild'));
   			});
   			var child = parseInt(childval) * parseInt(totalchild);
   			console.log('child'+child);
   			var infantval = 0;
   			$(".alladdons").each(function() {
   			   infantval += parseInt($(this).attr('datainfant'));
   			});
   			//var infant = parseInt(infantval) * parseInt(noinfant);
   			//console.log('infant'+infant);
   			//var finaltotl = parseInt(adulttotal) + parseInt(childtotl)+ parseInt(adult) + parseInt(child) + parseInt(infant);
   			var finaltotl = parseInt(adulttotal) + parseInt(childtotl)+ parseInt(adult) + parseInt(child);
   			//var fftotal =  parseInt(adult) + parseInt(child) + parseInt(infant);
   			var fftotal =  parseInt(adult) + parseInt(child) ;
   			var ftotal = parseInt(finaltotl) + parseInt(hprice);
   			var ftotal = parseInt(finaltotl) + parseInt(hprice);
   			$('.mytotalprice').val(ftotal);
   			$('.rmyaddons .price').html(fftotal);
   			$('.ttprice').html('<i class="fa fa-rupee-sign"></i> '+ftotal);
   			$('.basefare .mprice').html('<i class="fa fa-rupee-sign"></i> '+ftotal);
   			$('.pack_price_txt').html('<h4><i class="fa fa-rupee-sign"></i> '+ftotal+'	<br></h4>');
   			
   			
   			//var vl = $('#addontotal').val();
   			var tt = parseInt(inval);
   		
   			//$('.addonprice').html(tt);
   			
   			$('.totfare').html(parseInt(ftotal) + parseInt(tt));
   			var total = parseInt(ftotal) + parseInt(tt);
   			var cp = $('#coupon_code').val();
   			var discount = 0;
   			
   				
   				$('.distotfare').html(discount.toLocaleString());
   				var finaltotal = parseInt(total) - parseInt(discount);
   				var fn = Math.round(finaltotal);
   			$('.youpay').html(fn);
   		}
   		$(document).delegate('.commonc', 'change', function(e){
   			var v = $(this).attr('cid');
   			var datafield = $(this).attr('datafield');
   			var objjson = $.parseJSON(jsonprice);
   			var cc = $('#dpdate').val();
   			var obj = objjson[cc];
   			var vl = $('#room'+datafield+' #s_'+v+' .commonc').val();
   			var l = '';
   			var sl = 0;
   			
   			var ptwinprice = $('#room'+datafield+' input[name="packadult"]').val();
   			var packchild = $('#room'+datafield+' input[name="packchild"]').val();
   			$("#room"+datafield+" .commonc").each(function() {
   			   l = $('option:selected',this).attr('value');
   			   if(l == "cwb"){
   				  sl++; 
   			   }
   			});
   			var a = parseInt(ptwinprice) + parseInt(packchild);
   			
   			 if(a > 4){
   				$(this).val('0');
   				alert("Maximum person in room is 4");
   			}else{
   				/* if(!$('.childrow').hasClass('cd'+v+'')){
   				
   				}  */
   			if(vl == "cwobbyear"){
   				perprice = obj.child_without_bedbelow26;
   				price = obj.child_without_bedbelow26 * 1;
   				$('#room'+datafield+' #s_'+v+' .perchild').html('<i class="fa fa-rupee-sign"></i> '+price);
   				
   			$('#room'+datafield+' #s_'+v+' .netchild').html('<i class="fa fa-rupee-sign"></i> '+perprice+'<input type="hidden" class="cwobbprice" value="'+price+'">');
   			}else if(vl == "cwb"){
   				perprice = obj.child_with_bed;
   				price = obj.child_with_bed * 1;
   				$('#room'+datafield+' #s_'+v+' .perchild').html('<i class="fa fa-rupee-sign"></i> '+price);
   			$('#room'+datafield+' #s_'+v+' .netchild').html('<i class="fa fa-rupee-sign"></i> '+perprice+'<input type="hidden" class="cwbprice" value="'+price+'">');
   			}else if(vl == "cwob"){
   				perprice = obj.child_without_bedbelow12;
   				price = obj.child_without_bedbelow12 * 1;
   				$('#room'+datafield+' #s_'+v+' .perchild').html('<i class="fa fa-rupee-sign"></i> '+price);
   			$('#room'+datafield+' #s_'+v+' .netchild').html('<i class="fa fa-rupee-sign"></i> '+perprice+'<input type="hidden" class="cwobprice" value="'+price+'">');
   			
   			}else{
   				$('#room'+datafield+' #s_'+v+' .perchild').html('');
   				$('#room'+datafield+' #s_'+v+' .netchild').html('');
   				$('#room'+datafield+' .cd'+v).remove();
   			}
   			calculatechildprice(datafield);
   		}
   		});
   		
   		function calculatechildprice(datafield){
   			
   			var inval = 0;
   			var cwobbprice = 0;
   			/* $(".infantprice").each(function() {
   			   inval += parseInt($(this).val());
   			}); */
   			$(".cwobbprice").each(function() {
   			   cwobbprice += parseInt($(this).val());
   			});
   			var cwbval = 0;
   			$(".cwbprice").each(function() {
   			   cwbval += parseInt($(this).val());
   			});
   			var cwobval = 0;
   			$(".cwobprice").each(function() {
   			   cwobval += parseInt($(this).val());
   			});
   				var packadult = 0;
   var noinfant = 0;
   var cwobprice = 0;
   var cwbprice = 0;
   var mcwobbprice = 0;
   $(".roomno").each(function() {
     var val = $(this).val();
   	  var inval = 0;
   	  var inf = 0;
   	//inval = $("#room"+val+" input[name='packadult']").val();
   	//inf = $("#room"+val+" input[name='packinfant']").val();
   	var cwbval = 0;
   	$("#room"+val+" .cwbprice").each(function() {
   	   cwbval++;
   	});
   	var cwobval = 0;
   	$("#room"+val+" .cwobprice").each(function() {
   	   cwobval++;
   	});
   	var cwobbval = 0;
   	$("#room"+val+" .cwobbprice").each(function() {
   	   cwobbval++;
   	});
   packadult += parseInt(inval);		
   noinfant += parseInt(inf);		
   cwobprice += parseInt(cwobval);		
   cwbprice += parseInt(cwbval);		
   mcwobbprice += parseInt(cwobbval);		
   
   });
   
   	var totalchild = parseInt(cwobprice) + parseInt(cwbprice) + parseInt(mcwobbprice);
   		var hprice = 0;
   			 $(".mprice").each(function() {
   				   hprice += parseInt($(this).val());
   				}); 
   				console.log(hprice);
   			var aduktval = 0;
   			$(".alladdons").each(function() {
   			   aduktval += parseInt($(this).attr('dataprice'));
   			});
   			
   			var adult = parseInt(aduktval) * parseInt(packadult);
   			
   			var childval = 0;
   			$(".alladdons").each(function() {
   			   childval += parseInt($(this).attr('datachild'));
   			});
   			var child = parseInt(childval) * parseInt(totalchild);
   			var infantval = 0;
   			$(".alladdons").each(function() {
   			   infantval += parseInt($(this).attr('datainfant'));
   			});
   			var infant = parseInt(infantval) * parseInt(noinfant);
   
   		
   			var totalpri = parseInt(inval) + parseInt(cwbval) + parseInt(cwobval) + parseInt(cwobbprice)+ parseInt(adult) + parseInt(child) + parseInt(infant); 
   			 $('.childp').show();
   			 //var numItems = $('.childrow').length;
   			// var counttravler = $('.counttravler').length;
   			//$('.childp').html('Child X <span class="noofchild">'+numItems+'</span><span class="childprices"><i class="fa fa-rupee-sign"></i> '+totalpri+'</span>'); 
   			var vdd = $('.base_travel').attr('data-no');
   			
   			//$('.base_travel').attr('data-no',counttravler);
   			//$('.base_travel').html(counttravler);
   			
   			$('#childtotal').val(totalpri);
   			var childtotl = $('#childtotal').val();
   			var adulttotal = $('#adulttotal').val();
   			var inval = 0;
   			$(".alladdons").each(function() {
   			   inval += parseInt($(this).attr('dataprice'));
   			});
   			var finaltotl = parseInt(adulttotal) + parseInt(childtotl) + parseInt(inval) + hprice;
   			
   			$('.ttprice').html('<i class="fa fa-rupee-sign"></i> '+finaltotl);
   			var inval = 0;
   			$('.pack_price_txt').html('<h4><i class="fa fa-rupee-sign"></i> '+finaltotl+'	<br></h4>');
   			
   		
   		}
   		$(document).delegate('.adultinc', 'click', function(e){
   			  e.preventDefault();
   			   fieldName = $(this).attr('field');
   			   fieldid = $(this).attr('fieldid');
   			   var currentVal = parseInt($('#room'+fieldid+' input[name='+fieldName+']').val());
   			    var ptwinprice = $('#room'+fieldid+' input[name="packadult"]').val();	
   			    var chilval = $('#room'+fieldid+' input[name="packchild"]').val();	
   			var a = parseInt(ptwinprice) + parseInt(chilval) + 1;
   			  if(a > 4){
   				alert("Maximum person in room is 4");
   			}else{  
   			  if(currentVal < 3){
   				    if (!isNaN(currentVal)) {
   						var sss= currentVal + 1;
   					
   						$('#room'+fieldid+' input[name='+fieldName+']').val(currentVal + 1);
   					} else {
   						// Otherwise put a 0 there
   						$('#room'+fieldid+' input[name='+fieldName+']').val(1);
   					}
   			  }  
   			  
   			  calculatepackage(fieldid);
   		}
   		});
   		
   		
   		$(document).delegate('.childinc', 'click', function(e){
   			  e.preventDefault();
   			   fieldName = $(this).attr('field');
   			   fieldid = $(this).attr('fieldid');
   			   var currentVal = parseInt($('#room'+fieldid+' input[name='+fieldName+']').val());
   			   var ptwinprice = $('#room'+fieldid+' input[name="packadult"]').val();	
   			var a = parseInt(ptwinprice) + parseInt(currentVal) + 1;
   			
   			 if(a > 4){
   				alert("Maximum person in room is 4");
   			}else{
   			  if(currentVal < 3){
   				    if (!isNaN(currentVal)) {
   						// Increment
   						var v = currentVal + 1;
   						$('#room'+fieldid+' input[name='+fieldName+']').val(currentVal + 1);
   						
   						$('<tr id="s_'+v+'" class="inner_child"><td><label>Child '+v+'</label><select data-valid="required" class="commonc" datafield="'+fieldid+'" cid="'+v+'" name="child[]"><option value="0" >Please select</option><option value="cwb">Child with bed</option><option value="cwob">Child without bed</option><option value="cwobbyear">Child without bed (below 2-3 years)</option></select></td><td>1</td><td class="perchild">0</td><td class="netchild">0</td></tr>').insertBefore('#room'+fieldid+' .linner_child');
   					} else {
   			$('<tr id="s_1" class="inner_child"><td><label>Child 1</label><select data-valid="required" datafield="'+fieldid+'" cid="1" class="commonc" name="child[]"><option value="0">Please select</option><option value="cwb">Child with bed</option><option value="cwob">Child without bed</option><option value="cwobbyear">Child without bed (below 2-3 years)</option></select></td><td>1</td><td class="perchild">0</td><td class="netchild">0</td></tr>').insertBefore('#room'+fieldid+' .linner_child');
   						// Otherwise put a 0 there
   						$('#room'+fieldid+' input[name='+fieldName+']').val(1);
   					}
   			  }  
   		}
   			  
   			 // calculatepackage();
   		});
   		$(document).delegate('.childdec', 'click', function(e){
   			e.preventDefault();
   			fieldName = $(this).attr('field'); 
   			fieldid = $(this).attr('fieldid'); 
   			var currentVal = parseInt($('#room'+fieldid+' input[name='+fieldName+']').val());
          
   			if (!isNaN(currentVal) && currentVal > 1) {
   				var vl = currentVal -1;
   				$(' table#room'+fieldid+' tr.inner_child:last').remove();
   				$('#room'+fieldid+' .childrow:last').remove();
   				$('#room'+fieldid+' input[name='+fieldName+']').val(vl);
   			} else {
   				// Otherwise put a 0 there
   				$(' table#room'+fieldid+' tr.inner_child:last').remove();
   				$('#room'+fieldid+' .childrow').remove();
   				$('#room'+fieldid+' input[name='+fieldName+']').val(0);
   			}
   			 calculatepackage(fieldid);
   			 calculatechildprice();
   		 });
   		 $(document).delegate('.selBtn', 'click', function(){
   			 $('.myoverlay').show();
   			var val = $(this).data('hotel_id');
   			var val1 = $(this).data('inchotel_id');
   			$.ajax({
   			   url:"{{URL::to('/Package/selecthotels/')}}",
   			   method:'GET',
   			   data:{hotel_id:val,inchotel_id:val1},
   			   dataType: 'json',
   			   success:function(res)
   			   {
   				   $('.myoverlay').hide();
   					if(res.success){
   						var s = '';
   						for(var ik =0; ik < res.hoteldetail.hotel_category; ik++){
   							s +='<img src="{!! asset('public/img/star.png') !!}" alt="Star Rating" title="Star Rating">';
   						}
   						
   						$('.hotel_row.hotel_'+val1+' .packagedethotelimg img').attr('src', '{{@URL::to('/public/img/hotel_img')}}/'+res.hoteldetail.image);
   						$('.hotel_row.hotel_'+val1+' .gallerypopup a').attr('ng-src', '{{@URL::to('/public/img/hotel_img')}}/'+res.hoteldetail.image);
   						$('.hotel_row.hotel_'+val1+' .packagelistboxheading h3 a').html(res.hoteldetail.name);
   						$('.hotel_row.hotel_'+val1+' .starmargin').html(s);
   						$('.hotel_row.hotel_'+val1+' .optionalCategory').html(res.hoteldetail.address);
   						$('.hotel_row.hotel_'+val1+' .mprice').val(res.hotelprice);
   						$('.hotel_row.hotel_'+val1+' .newhotelsid').val(res.hoteldetail.id);
   						$('.hotel_row.hotel_'+val1+' .nprice').val(res.oldhotelprice);
   						$('.hotel_row.hotel_'+val1+' .openhotelpopup').attr('data-hotelid', res.hoteldetail.id);
   						$('#openhotelpopup').modal('hide');
   						$('.hotel_row.hotel_'+val1).addClass('hotel_'+res.hoteldetail.id);
   						$('.hotel_row.hotel_'+res.hoteldetail.id).removeClass('hotel_'+val1);
   						calculatemypackage(res.hotelprice);
   					}
   			   }
   			});
   		});
   		function calculatemypackage(price){
   			var mytol = $('.mytotalprice').val();
   			var hprice = 0;
   			 $(".mprice").each(function() {
   				   hprice += parseInt($(this).val());
   				}); 
   				var v = parseInt(mytol) + parseInt(price);
   				$('.mytotalprice').val(v);
   				$('.pack_price_txt').html('<h4><i class="fa fa-rupee-sign"></i> '+v+'	<br></h4>');
   			
   		}
   		 $(document).delegate('.adultdec', 'click', function(e){
   			e.preventDefault();
   			fieldName = $(this).attr('field'); 
   			fieldid = $(this).attr('fieldid'); 
   			var currentVal = parseInt($('#room'+fieldid+' input[name='+fieldName+']').val());
           
   			if (!isNaN(currentVal) && currentVal > 1) {
   				var vl = currentVal -1;
   				$('#room'+fieldid+' .adultrow:last').remove();
   				$('#room'+fieldid+' input[name='+fieldName+']').val(vl);
   			} else {
   				// Otherwise put a 0 there
   				$('#room'+fieldid+' input[name='+fieldName+']').val(1);
   			}
   			 calculatepackage(fieldid);
   		 });
   		 
   		 
   		 $(document).delegate('.infantinc', 'click', function(e){
   			  e.preventDefault();
   			  var objjson = $.parseJSON(jsonprice);
   				var cc = $('#dpdate').val();
   				var obj = objjson[cc];
   			   fieldName = $(this).attr('field');
   			   fieldid = $(this).attr('fieldid');
   			   var currentVal = parseInt($('#room'+fieldid+' input[name='+fieldName+']').val());
   			     
   			  if(currentVal < 2){
   				    if (!isNaN(currentVal)) {
   						var sss= currentVal + 1;
   					
   						$('#room'+fieldid+' input[name='+fieldName+']').val(currentVal + 1);
   						var	perprice = obj.infant;
   						var price = obj.infant * sss;
   						
   						$('#room'+fieldid+' .linner_infant').html('<td><label>Infant</td><td>'+sss+'</td><td class="perinfant">'+perprice+'</td><td class="netinfant">'+price+'</td><input type="hidden" class="infantprice" value="'+price+'">');
   						$('#room'+fieldid+' .linner_infant').show();
   					} else {
   						// Otherwise put a 0 there
   						$('#room'+fieldid+' input[name='+fieldName+']').val(0);
   						$('#room'+fieldid+' .linner_infant').html('<td><label>Infant</td><td>0</td><td class="perinfant">0</td><td class="netinfant">0</td><input type="hidden" class="infantprice" value="0">');
   						$('#room'+fieldid+' .linner_infant').hide();
   					}
   				
   				
   			  }  
   			  
   			calculatechildprice();
   		
   		});
   		  $(document).delegate('.infantdec', 'click', function(e){
   			e.preventDefault();
   			var objjson = $.parseJSON(jsonprice);
   				var cc = $('#dpdate').val();
   				var obj = objjson[cc];
   			fieldName = $(this).attr('field'); 
   			fieldid = $(this).attr('fieldid'); 
   			var currentVal = parseInt($('#room'+fieldid+' input[name='+fieldName+']').val());
           
   			if (!isNaN(currentVal) && currentVal > 1) {
   				var vl = currentVal -1;
   				$('#room'+fieldid+' input[name='+fieldName+']').val(vl);
   				
   				var	perprice = obj.infant;
   				var price = obj.infant * vl;
   				
   				$('#room'+fieldid+' .linner_infant').html('<td><label>Infant</td><td>'+vl+'</td><td class="perinfant">'+perprice+'</td><td class="netinfant">'+price+'</td><input type="hidden" class="infantprice" value="'+price+'">');
   				$('#room'+fieldid+' .linner_infant').show();
   			} else {
   				// Otherwise put a 0 there
   				$('#room'+fieldid+' input[name='+fieldName+']').val(0);
   				$('#room'+fieldid+' .linner_infant').html('<td><label>Infant</td><td>0</td><td class="perinfant">0</td><td class="netinfant">0</td><input type="hidden" class="infantprice" value="0">');
   				$('#room'+fieldid+' .linner_infant').hide();
   			}
   			calculatechildprice();
   		 });
   		 
   $(document).delegate('.addroom', 'click', function(){
   	var rom = $('.allroms').length + 2;
   	$('.rmrooms').show();
   	$('.showroom').append('<div class="allroms"><div class="">Room '+rom+'</div><table class="table borderRemove" border="0" id="room'+rom+'"><thead><tr><th>Person</th><th>Number</th><th>Cost/Person</th><th class="width20">Net Cost</th></tr></thead><tbody><tr><td><span>Adult (+12 Yrs)</span><br><span>Child (Upto 12 Yrs)</span><br><span>infant (0-2 Yrs)</span></td><td><div class="counter-add-item"><input type="hidden" class="roomno" value="'+rom+'"><a field="packadult" class="adultdec" fieldid="'+rom+'" href="javascript:;">-</a><input name="packadult" type="text" value="2"><a field="packadult" fieldid="'+rom+'" class="adultinc" href="javascript:;">+</a></div><div class="counter-add-item"><a fieldid="'+rom+'" field="packchild" class="childdec" href="javascript:;">-</a><input name="packchild" type="text" value="0"><a fieldid="'+rom+'" field="packchild" class="childinc" href="javascript:;">+</a></div><div class="counter-add-item"><a fieldid="'+rom+'" field="packinfant" class="infantdec" href="javascript:;">-</a><input name="packinfant" type="text" value="0"><a fieldid="'+rom+'" field="packinfant" class="infantinc" href="javascript:;">+</a></div></td><td class="perprice"><i class="fa fa-rupee-sign"></i> 0</td><td class="netprice width30"><i class="fa fa-rupee-sign"></i> 0</td></tr><tr class="linner_infant" style="display:none;"></tr><tr class="linner_child" style="display:none;"><td><label>Child 1</label><select><option>Infant (0-2 years)</option><option>Child with bed</option><option>Child without bed</option></select></td><td>1</td><td><i class="fa fa-rupee-sign"></i> 0</td><td><i class="fa fa-rupee-sign"></i> 0</td></tr></tbody></table></div>');
   calculatepackage(rom);
   });
   		 
   		 $(document).delegate('.promo_button', 'click', function(){
   				var flag = true;
   				if($('.applytext').val() == ''){
   					alert('Please enter coupon code');
   					flag = false;
   				}
   				if(flag){
   					var coupo = $(".applytext").val();
   					$.ajax({
   					url:'{{URL::to('/Flight/ApplyCoupon')}}',
   					dataType: 'json',
   					type: 'GET',
   				
   					data:{coupon_code:coupo},
   					success: function(res){
   						var obj = res;
   						$('.couponsuccess').show();
   						if(obj.success){
   							$('.discount_value').show();
   							var postfix = '';
   							var prefix = '';
   							if(obj.coupondetail.discount_type == 'percentage'){
   								postfix = '%';
   							}else{
   								prefix = '<i class="fa fa-rupee-sign"></i>';
   							}
   							$('.discount_value').html('Discount '+obj.coupondetail.coupon_code+' ('+prefix+obj.coupondetail.discount+postfix+')<span class="price"><i class="fa fa-rupee-sign"></i> <span class="distotfare"></span>');
   							$('.applytextvaue').val(coupo);
   							$('.promo_button').hide();
   							$('.clear_button').show();
   							$('.couponsuccess').html(obj.message);
   							var cp = $('#coupon_code').val(obj.coupondetail.discount+'|'+obj.coupondetail.discount_type);
   							var cp = obj.coupondetail.discount+'|'+obj.coupondetail.discount_type;
   							
   							$('.couponsuccess').css('color','#a8d845');
   						}else{
   							$('.promo_button').show();
   							$('.clear_button').hide();
   							$('#coupon_code').val(0);
   							$('.discount_value').hide();
   							$('.applytext').val('');
   							$('.applytextvaue').val('');
   							
   							$('.couponsuccess').html(obj.message);
   							$('.couponsuccess').css('color','#ff0000');
   						}
   						 calculatepackage();
   						calculatechildprice();
   					}
   				});
   				}
   			});
   			$(document).delegate('.clear_button', 'click', function(){
   				$('.promo_button').show();
   				$('.clear_button').hide();
   				$('#coupon_code').val(0);
   				$('.discount_value').hide();
   				$('.applytext').val('');
   				$('.applytextvaue').val('');
   				$('.couponsuccess').hide();
   				$('.couponcode').prop('checked', false);
   				 calculatepackage();
   						calculatechildprice();
   				$('.couponsuccess').html('');
   			});
   			$(document).delegate('.coupon_apply', 'change', function(){
   				var coupo = $("input[name='couponcode']:checked").val();
   				$('.applytext').val(coupo);
   				$.ajax({
   					url:'{{URL::to('/Flight/ApplyCoupon')}}',
   					dataType: 'json',
   					type: 'GET',
   				
   					data:{coupon_code:coupo},
   					success: function(res){
   						$('.couponsuccess').show();
   						var obj = res;
   						if(obj.success){
   							$('.discount_value').show();
   							var postfix = '';
   							var prefix = '';
   							if(obj.coupondetail.discount_type == 'percentage'){
   								postfix = '%';
   							}else{
   								prefix = '<i class="fa fa-rupee-sign"></i>';
   							}
   							$('.discount_value').html('Discount '+obj.coupondetail.coupon_code+' ('+prefix+obj.coupondetail.discount+postfix+')<span class="price"><i class="fa fa-rupee-sign"></i> <span class="distotfare"></span>');
   							$('.applytextvaue').val(coupo);
   							$('.promo_button').hide();
   							$('.clear_button').show();
   							$('.couponsuccess').html(obj.message);
   							var cp = $('#coupon_code').val(obj.coupondetail.discount+'|'+obj.coupondetail.discount_type);
   							var cp = obj.coupondetail.discount+'|'+obj.coupondetail.discount_type;
   							
   							$('.couponsuccess').css('color','#a8d845');
   						}else{
   							$('.promo_button').show();
   							$('.clear_button').hide();
   							$('#coupon_code').val(0);
   							$('.discount_value').hide();
   							$('.applytext').val('');
   							$('.applytextvaue').val('');
   							
   							$('.couponsuccess').html(obj.message);
   							$('.couponsuccess').css('color','#ff0000');
   						}
   						
   						 calculatepackage();
   						calculatechildprice();
   					}
   				});
   			});
   	});
   	
   		 function showMBPopup(){
   			$('#mytravelModal').modal('show');
   		}
   			  
   		$(document).ready(function() {
   			 travelsize_li = $("#mucoverinc .insu").length;
   			  if(travelsize_li > 3){
   				  $('.showmore').show();
   			  }else{
   				  $('.showmore').hide();
   			  } 
   			  xsss = 3; 
   			  $('#mucoverinc .insu:lt(' + xsss + ')').show();
   			  $('.showmore').click(function() {
   				  $('#mucoverinc .insu').show();
   					$('.showmore').hide();
   					$('.lessmore').show();
   			});
   			 $('.lessmore').click(function() {
   				 $('#mucoverinc .insu').hide();
   				  $('#mucoverinc .insu:lt(' + xsss + ')').show();
   				  
   					$('.showmore').show();
   					$('.lessmore').hide();
   			});
   			
   			$(document).delegate('.login', 'click', function(){
   				var flag = true;
   				$(".custom-error").remove();
   				$('.showiferror').hide();
   				if($('input[name="login_email"]').val() == ''){
   					flag = false;
   					$($('input[name="login_email"]')).after("<span class='custom-error' role='alert'>Email is required</span>");
   				}else if(!validateEmail($.trim($('input[name="login_email"]').val()))) 
   				{
   					flag = false;
   					$('input[name="login_email"]').after("<span class='custom-error' role='alert'>Please enter the valid email address.</span>");
   				}
   				if($('input[name="login_password"]').val() == ''){
   					flag = false;
   					$($('input[name="login_password"]')).after("<span class='custom-error' role='alert'>Password is required</span>");
   				}
   				if(flag){
   					$.ajax({
   						url: "{{ route('customer.login') }}",
   						dataType: 'json',
   						type: 'POST',
   						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
   						
   						data: {email:$('input[name="login_email"]').val(),password:$('input[name="login_password"]').val()},
   						success:function(resp){
   					
   							if (resp.success) {
   								location.reload();
   							}else{
   								$('.showiferror').html("<span class='custom-error' role='alert'>"+resp.errors+"</span>");
   								$('.showiferror').show();
   							}
   						}
   					});
   				}
   				
   			});
   			
   		
   			
   			$(document).delegate('.fare_rules ul li.basefare', 'click', function(){				
   				$('.fare_rules ul li.basefare ul.inner_ul').toggleClass('show');
   			});
   			$(document).delegate('.fare_rules ul li.fee_subcharge', "click", function(){ 
   				$('.fare_rules ul li.fee_subcharge ul.inner_ul').toggleClass('show');
   			});
   			$(document).delegate('.fare_rules ul li.addons',"click", function(){ 
   				$('.fare_rules ul li.addons ul.inner_ul').toggleClass('show');
   			});
   			$(document).delegate('.booking_title a.open_signin', "click", function(){ 
   				$(this).toggleClass('open');
   				$('.signin_content').toggleClass('show'); 
   			});
   			$(document).delegate('.signin_content .content_close', "click", function(){ 
   				$('.booking_title a.open_signin').removeClass('open');
   				$('.signin_content').removeClass('show'); 
   			});
   			$(document).delegate('.add_gst .gst_btn a.add_link',"click", function(){ 
   				$(this).addClass('hide');
   				$('.gst_form').toggleClass('show');
   				$('.add_gst .gst_btn a.form_close').addClass('show');
   			});
   			$(document).delegate('.add_gst .gst_btn a.form_close',"click", function(){ 
   				$(this).removeClass('show');
   				$('.add_gst .gst_btn a.add_link').removeClass('hide');
   				$('.gst_form').toggleClass('show');   
   			});  
   			/* $('.service_req_list li span.baggage_select').on("click", function(){ 
   				$(this).toggleClass('checked'); 
   				$(this).parent('.service_req_list li').toggleClass('active');  
   			});  */
   	
   			 $('.paymethod').on('click', function(){
   				var val = $("input:radio[name='paymentmethod']:checked").val();
   				$('#payment_method').val(val);
   			});
   
   
   $(document).delegate('.myfarerule', 'click', function(){
   		$('#fareruleModal').modal('show');
   		var rsindex = $(this).attr('resindex');
   		var val = $('#firsttime').val();
   		if(val == 0){
   		$.ajax({
   		   url:"{{URL::to('/Flight/farerules/')}}",
   		   method:'GET',
   		   data:{resindex:rsindex, traceid:$(this).attr('traceid')},
   		   success:function(data)
   		   {
   				$('.showfarerule').html(data);
   				$('#firsttime').val(1);
   		   }
   		  });
   		}
   	});
   	
   	
   	
 });
   
   	
</script>
@include('modal_package_detail')
@endsection