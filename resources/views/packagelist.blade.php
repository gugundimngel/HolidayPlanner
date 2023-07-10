@extends('layouts.frontend')
@section('content')
<?php use App\Http\Controllers\PackageController; ?>
<style>
    .read-more-fade p{
        text-align:left;
    }
</style>
<div class="single_package packagelistWrapper">
    <div class="inner_single_package">
        <div class="container">
            <div class="row">
                <div class="col-md-12 p-5" style="display:block;">
					<div class="description_box">
						<?php 
							$dest = $destinationdetail;
							$filterlist = json_decode($filterlist);
							$Destination_description = $myquery->description;
							
							if(strlen($Destination_description) > 500){
								$stringCut = substr($Destination_description, 0, 500);
								$endPoint = strrpos($stringCut, ' ');
							
								//if the string doesn't contain any space then it will cut without word basis.
								$newDestination_description = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
								$newDestination_description .= '<button id="description_readMore">Read More</button>';
							}else{
								$newDestination_description = $Destination_description;
							}
							$oldDestination_description = $myquery->description;
							$oldDestination_description .= '<button id="description_showLess">Show Less</button>';
						?>
						<h2>{{@$myquery->name}}</h2>
						<article data-readmore="" aria-expanded="false" id="newDestinationDescription" class="read-more-fade cust_article" style="">
							<?= $newDestination_description; ?>
						</article>

						<article data-readmore="" aria-expanded="false" id="DestinationDescription" class="read-more-fade" style="display:none">
							<?= $oldDestination_description; ?>
						</article>
					</div>
                </div>

                <div class="col-md-3">
                    <div class="sidebar style-1 custom_sidebar">
                        <a class="filter_close"><i class="fa fa-times"></i></a>
                        <input id="mslug" type="hidden" value="{{@$myquery->slug}}">
                        <input id="mprice" type="hidden" value="">
                        <h3>Filter <span onClick="ClearAll();" class="clearfilter">Clear All</span></h3>
                        <div class="inner_filter">
                            <div class="box-widget">
                                <h5 class="box-title">Flights</h5>
                                <div class="box-content">
                                    <ul class="check-boxes-custom list-checkboxes">
                                        <li>
                                            <label for="flight1" class="label-container checkbox-default">With Flight
                                                <input name="flight" class="flightfilter" id="flight1" type="checkbox"
                                                    value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label for="flight2" class="label-container checkbox-default">Without Flight
                                                <input name="flight" class="flightfilter" id="flight2" type="checkbox"
                                                    value="0">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="box-widget">
                                <h5 class="box-title">Holiday Type</h5>
                                <div class="box-content">
                                    <ul class="check-boxes-custom list-checkboxes">
                                        <li>
                                            <label for="pack1" class="label-container checkbox-default">Fixed
                                                <input name="package_type" class="Stopfliter myListicheck" id="pack1"
                                                    type="checkbox" value="fixed">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label for="pack2" class="label-container checkbox-default">Customize
                                                <input name="package_type" class="Stopfliter myListicheck" id="pack2"
                                                    type="checkbox" value="customize">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label for="pack3" class="label-container checkbox-default">Group
                                                <input name="package_type" class="Stopfliter myListicheck" id="pack3"
                                                    type="checkbox" value="group">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="box-widget">
                                <h5 class="box-title">Budget</h5>
                                <div class="box-content">
                                    <div class="slider-dragable-range pslider-range-price">
                                        <input type="text" class="price">
                                        <div class="pslider-range" data-slider-min-value="0"
                                            data-slider-max-value="500000" data-range-start-value="50000"
                                            data-range-end-value="200000" data-slider-value-sign="&#8377;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="box-widget">
                                <div class="filter_type duration_filter">
                                    <h5 class="box-title">Destination</h5>
                                    <div class="box-content">
                                        <input type="text" id="destination" name="destination" value="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
					<div class="" style="text-align:right;">
						<div class="sorting_sec">
							<div class="box-widget">
								<div class="box-content">
									<label>Sort by:</label>
									<select id="filterprice" name="filterprice">
										<option value="popularity">Popularity</option>
										<option value="desc">Price: Low to High</option>
										<option value="asc">Price: High to Low</option>
										<option value="desc">Duration: Low to High</option>
										<option value="asc">Duration: High to Low</option>
									</select>
								</div>
							</div>
						</div>
					</div>

                    <div id="mloader"
                        style="position: fixed;left: 45%;padding: 20px;top: 40%;opacity: 0.5;border: 1px solid rgb(102, 102, 102);z-index: 100;background-color: rgb(255, 255, 255);display: none;">
                        <img src="{!! asset('public/img/loader.gif') !!}" alt="Loading"></div>
                    <div id="ajaxResultContainer">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="tourpack-pagtbox">
                                    <div class="row">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if(count($dest->items()) > 0){
    						foreach($dest as $plist){
    						?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row pkgwrapper d_flex">
                                        <div class="col-md-3 pkgimg-box d_flex">
                                            <a href="{{URL::to('/destinations/'.$myquery->slug.'/'.$plist->slug)}}"
                                                class="pkg-imgbx">
                                                <img data-original="{{URL::to('/public/img/media_gallery')}}/{{@$plist->media->images}}"
                                                    width="250" class="img-fluid lazy" alt="{{@$plist->package_image_alt}}"
                                                    title=""
                                                    src="{{URL::to('/public/img/media_gallery')}}/{{@$plist->media->images}}"
                                                    style="display: block;">
                                            </a>
                                        </div>
                                        <div class="col-md-9 d_flex padd0">
                                            <div class="row d_flex mar_auto_0 wd100 actions_details">
                                                <div class="col-md-8 pkgtext-box">
                                                    {{-- @if(@$plist->tour_code != '')
                                                    <!--<span class="code_span">Tour Code: <strong>{{@$plist->tour_code}}</strong></span>-->
                                                    @endif --}}
                                                    <span class="pack_type">Departure</span>
                                                    <span class="totalNights">{{@$plist->no_of_nights}} Nights /
                                                        {{@$plist->no_of_days}} Days</span>
                                                    <a class="pack_title"
                                                        href="{{URL::to('/destinations/'.$myquery->slug.'/'.$plist->slug)}}">{{@$plist->package_name}}</a>
                                                    <p class="schedule_details">{{@$plist->details_day_night}}</p>
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
                                                        <li>
                                                            <div class="cus_tooltip">
                                                                @if(!empty($Topinclusion->topinclusion))
                                                                @if(@$Topinclusion->topinclusion->image != '')
                                                                <img width="20" height="20"
                                                                    src="{{URL::to('/public/img/topinclusion_img')}}/{{@$Topinclusion->topinclusion->image}}">
                                                                @else
                                                                <img width="20" height="20"
                                                                    src="{{URL::to('/public/img/topinclusion_img')}}/{{@$Topinclusion->image}}">
                                                                @endif
                                                                @else
                                                                <img width="20" height="20"
                                                                    src="{{URL::to('/public/img/topinclusion_img')}}/{{@$Topinclusion->image}}">
                                                                @endif
                                                                <span class="tooltiptext">{{@$Topinclusion->name}}</span>
                                                            </div>
                                                        </li>
                                                        <?php } } ?>
    
                                                    </ul>
                                                    <?php } ?>
    
                                                </div>
                                                
                                                <div class="col-md-4 txt-cntr">
                                                    <span>
                                                        @if($plist->price_on_request == 1)
                                                        <div class="pkg-pricebx price_request">
                                                            <strong>Price On Request</strong>
                                                        </div>
                                                        @else
    
                                                        <?php
    					//$discount = (($plist->sales_price - $plist->offer_price) /$plist->sales_price ) * 100; 
    					?>
                                                        <?php /*<div class="pkg-pricebx" style="font-size: 15px;">
    														<p class="appendBottom10"><span class="font12 redText appendRight5">Save <i class="fa fa-inr"></i> <?php echo $plist->sales_price - $plist->offer_price; ?>
                                                    </span><span class="holidaySprite discountTag"></span><span
                                                        class="discount_box font11 latoBold whiteText">{{@$discount}}%</span>
                                                    </p>
                                                    <strike><strong style="color:#aba5a5"><i class="fa fa-rupee-sign"></i>
                                                            {{@$plist->sales_price}}</strong></strike>
                                                    </div>
                                                    
                                                    */
                                                    $prices = \App\PackagePrice::where('package_id', $plist->id)->orderby('id',
                                                    'ASC')->first();
                                                    ?>
                                                    <div class="pkg-pricebx" style="font-size: 15px;">
                                                        <strong><i class="fa fa-rupee-sign"></i>
                                                            <?php echo number_format(@$prices->twin); ?>
                                                        </strong>
                                                    </div>
                                                    @endif
                                                    </span>
                                                    <a href="#" datapacid="{{$plist->id}}" data-toggle="modal"  data-target="#inquirymodal" class="btnPackageCard btn-outline myqueryli">Get Quotes</a>
                                                    <a href="{{URL::to('/destinations/'.$myquery->slug.'/'.$plist->slug)}}" class="btnPackageCard btn-orange">View Details</a>
                                                    <!--<a href="{{URL::to('/destinations/'.$myquery->slug.'/'.$plist->slug)}}" class="pkglinks-view text-center btnPackageCard">Book Now</a>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        }else{
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row pkgwrapper d_flex">
                                    <p>No Packages Found</p>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                </div>
            </div>
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

							{{ Form::open(array('url' => 'enquiry-contact', 'name'=>"queryform", 'autocomplete'=>'off','id'=>'popenquiryco')) }}
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
							<input type="hidden" id="mpackage_id" name="package_id" value="">
							{{ Form::button('Submit', ['class'=>'submitbtt', 'onClick'=>'customValidate("queryform")' ]) }}
							{{ Form::close() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
    var miprice = '{{@$filterlist->data->min_price}}';
    var maxprice = '{{@$filterlist->data->max_price}}';
    var min_nigt = '{{@$filterlist->data->min_nigt}}';
    var max_day = '{{@$filterlist->data->max_day}}';
    
    $(document).ready(function(){
        $('#description_readMore').on('click',function(){
            $('#newDestinationDescription').css('display','none');
            $('#DestinationDescription').css('display','block');
        });
        $('#description_showLess').on('click',function(){
            $('#DestinationDescription').css('display','none');
            $('#newDestinationDescription').css('display','block');
            $(window).scrollTop(0);
        });
    });
</script>
@endsection