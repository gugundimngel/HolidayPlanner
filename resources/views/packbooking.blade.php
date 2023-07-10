@extends('layouts.frontend')
@section('title', 'Book Package')
@section('meta_title', '')
@section('meta_keyword', '')
@section('meta_description', '')
@section('bodyclass', '')
@section('content')
<style>
#myUL .coupon_li{display:none;}
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
button:disabled, button[disabled] {
    color: #666666;
    background-image: linear-gradient(to right, #93968d , #9a9e94)!important;
}
</style>
<?php
$selecteddate = isset($_GET['date']) ? date('Y-m-d', $_GET['date']) : '';
$explode = explode('-', $selecteddate);
 $packagedetail->id;
$date = $explode[1].'/'.$explode[2].'/'.$explode[0];
$allprice = \App\PackagePrice::select('twin','single','triple','child_with_bed','child_without_bedbelow12','child_without_bedbelow26','infant')->where('package_id',$packagedetail->id)->where('departure_date',$date)->first();

$addons = isset($_GET['addons']) ? $_GET['addons'] : '';
if($allprice){
	$jsonprice = json_encode($allprice);
?>
<script>
var jsonprice = '<?php echo json_encode($allprice); ?>';
</script>
<section id="content" style="transform: none;">
			<div id="content-wrap" style="transform: none;">
				<!-- === Section Flat =========== -->
				<div class="section-flat single_sec_flat booking_sec" style="transform: none;">      
					<div class="section-content" style="transform: none;">
<div class="container" style="transform: none;">
{{ Form::open(array('url' => 'package/payment', 'name'=>"frmProduct", 'autocomplete'=>'off', "enctype"=>"multipart/form-data", "id" => "frm_Product")) }}
<input type="hidden" name="package_id" value="{{base64_encode(convert_uuencode(@$packagedetail->id))}}">
<input type="hidden" name="p_id" value="{{$_GET['srch']}}">
<input type="hidden" name="package_date" value="{{@$_GET['date']}}">
	<div class="row">
		<div class="col-md-12">
			<div class="server-error">@include('../Elements/front-flash-message')</div>
		</div>
	</div> 
	<div class="row" style="transform: none;">
		<div class="col-md-9 col-sm-12">
			<div class="inner_booking">
				<div class="booking_title">
				<h3>Package Details</h3>
				</div>
				<div class="book_pack_details custom_block_layout">
					<div class="pack_title cus_title">
						<h4>{{@$packagedetail->package_name}}</h4>
						<p><i class="fa fa-map-marker-alt"></i> {{@$packagedetail->details_day_night}}</p>
					</div>
					<span class="count_days">{{@$packagedetail->no_of_nights}} Nights / {{@$packagedetail->no_of_days}} Days</span>
					<div class="clearfix"></div>
					<div class="pack_inclusion">
						<span>Top Inclusions</span>
						<?php if(@$packagedetail->package_topinclusions != ''){ ?>
						<ul class="bullets">
						<?php 
						$explodee = explode(',',@$packagedetail->package_topinclusions);
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
					<!--<section class="common_section">
					<h4>Overview</h4>
					<article data-readmore="" aria-expanded="false" id="rmjs-1" class="read-more-fade cust_article" style="">  <p>dsamdsd sdkasjdksjdas d askdskd,am scaskdasdjksdjskad dd sdsdaskdsdas ds dsadkksajdskd</p><p>dasdasdasdasdsadasdsad asdasdksadjkasjdkasdams d asdsjdhkasdjkasjd</p> 
					</article>
					</section>-->
				</div>

			<!--<div class="booking_title">
				<h3>Traveller</h3>
			</div> 
			<div class="traveller_info_sec custom_block_layout">
				<div class="pack_title cus_title">
					<h4>Select Traveller</h4>
				</div>  
				<div class="packroomtype">
					<label>Room Type</label>
					<select class="form-control" name="roomtype" id="roomtype">
						<option value="Twin">Twin</option>
						<option value="Single">Single</option>
						<option value="Triple">Triple</option>
					</select>
				</div>
				<div class="pack_table_data table-responsive">
					<table class="table" border="0">
						<thead>
							<tr>
								<th>Person</th>
								<th>Number</th>
								<th>Cost/Person</th>
								<th>Net Cost</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><span>Adult (+12 Yrs)</span><span>Child (Upto 12 Yrs)</span></td>
								<td>
									<div class="counter-add-item">
										<a field="packadult" class="adultdec" href="javascript:;">-</a>
										<input  name="packadult" type="text" value="2">
										<a field="packadult" class="adultinc" href="javascript:;">+</a>
									</div> 
									<div class="counter-add-item">
										<a field="packchild" class="childdec" href="javascript:;">-</a>
										<input name="packchild" type="text" value="0">
										<a field="packchild" class="childinc" href="javascript:;">+</a>
									</div>
								</td>
								<td class="perprice"><i class="fa fa-rupee-sign"></i> {{@$allprice->twin}}</td>
								<td class="netprice"><i class="fa fa-rupee-sign"></i> {{@$allprice->twin * 2}}</td>
							</tr>
							<tr class="linner_child" style="display:none;">
								<td>
									<label>Child 1</label>
									<select>
										<option>Infant (0-2 years)</option>
										<option>Child with bed</option>
										<option>Child without bed</option>
									</select>	
								</td>
								<td>1</td>
								<td><i class="fa fa-rupee-sign"></i> 1845</td>
								<td><i class="fa fa-rupee-sign"></i> 1845</td>
							</tr>
							
							
						</tbody>
					</table>
				</div>
			</div>-->

			<div class="booking_title">
				<h3>Enter Traveller Details</h3>
				<div class="sub_title"><a href="javascript:;" class="open_signin">Sign in</a> to book faster and use eCash</div>									
			</div>
			<div class="custom_block_content signin_content"> 
				<div class="col-md-12 showiferror" style="display:none;">
					<span class="custom-error" role="alert"></span>
				</div>
				<div class="content_close">
					<a href="javascript:;"><i class="fa fa-times"></i></a>
				</div>
				<div class="sign_label cus_label">Sign In Now</div>
				<div class="form_field">
					<input type="email" name="login_email" placeholder="Email Address" class="form-control">
				</div>
				<div class="form_field"><input type="password" name="login_password" placeholder="Password" class="form-control"><!--<a href="#">Forgot?</a>--></div>
				<div class="login_btn">
					<input type="button" name="submit" class="btn login" value="Login">
				</div>
				<div class="or_txt">OR</div> 
				<div class="fb_txt">
					<a href="{{URL::to('/auth/facebook')}}"><i class="fab fa-facebook-f"></i></a>
				</div>
				<div class="fb_txt"><a href="{{URL::to('/auth/google')}}"><i class="fab fa-google"></i></a></div>
			</div><!-- .block-content-2 end -->

			<div class="block-content-2 custom_block_content contact_detail">
				<div class="box-result custom_box_result">
				<div class="col-sm-2 contact_label cus_label">Contact Details</div>
				<div class="col-sm-10">
					<div class="form_field">
						<input data-valid="required" value="" type="email" name="email" placeholder="Email ID" class="form-control">
					</div>
					<div class="form_field country_field">
						<div class="country_code">
							<input class="" id="telephone" type="tel" name="telephone" readonly >
						</div>
						<div class="mobile_no">
							<input data-valid="required" value="{{@Auth::user()->phone}}"  id="phone" name="phone" type="tel" placeholder="Mobile Number" class="form-control"/>
						</div>
					</div>
<p>Your booking details will be sent to this email address and mobile number.</p>
</div>    
<div class="clearfix"></div>
		<div class="traveller_info">
		<h4>Traveller Information</h4>
		<div class="note"><span>Important Note:</span> Please ensure that the names of the passengers on the travel documents is the same as on their government issued identity proof.</div>
		<?php 
			$pax = isset($_GET['srch']) ? $_GET['srch'] : ''; 
			$hid = isset($_GET['hid']) ? $_GET['hid'] : ''; 
			$eexplode = explode('|', $hid);
			$nhdid = isset($_GET['nhdid']) ? $_GET['nhdid'] : ''; 
			$erexplode = explode('|', $nhdid);
			$explode = explode('|', $pax);
			for($i =0; $i<count($explode); $i++){
				$rooms = explode('-', $explode[$i]);
		?>
			<div class="row counttravler">
				
				<h4>Room <?php echo $rooms[0]; ?></h4>
				<?php for($ij =0; $ij<$rooms[1]; $ij++){ ?>
				<div class="col-sm-12">
					<div class="col-sm-2 contact_label cus_label">Adults <?php echo $ij + 1; ?></div>
					<div class="col-sm-10">
						<div class="form_field form_select_field">
							<select data-valid="required" class="form-control" name="passenger[{{$rooms[0]}}][adulttitle][]">
								<option value="">Title</option>
								<option selected="" value="Mr">Mr.</option>
								<option value="Mrs">Mrs.</option>
								<option value="Ms">Ms.</option>
							</select> 
							<input data-valid="required" type="text" name="passenger[{{$rooms[0]}}][adultfirstname][]" placeholder="First Name" class="form-control">
						</div>
						<div class="form_field">
							<input data-valid="required" type="text" name="passenger[{{$rooms[0]}}][adultlastname][]" placeholder="Last Name" class="form-control">
						</div> 
					</div> 
					<div class="clearfix"></div>
				</div>
				<?php } ?>
				
				<?php for($ijin =0; $ijin<$rooms[2]; $ijin++){ ?>
				<div class="col-sm-12">
					<div class="col-sm-2 contact_label cus_label">Infant <?php echo $ijin + 1; ?></div>
					<div class="col-sm-10">
						<div class="form_field form_select_field">
							<select data-valid="required" class="form-control" name="passenger[{{$rooms[0]}}][infanttitle][]">
								<option value="">Title</option>
								<option selected="" value="Miss">Miss</option>
								<option value="Master">Master</option>
							</select> 
							<input data-valid="required" type="text" name="passenger[{{$rooms[0]}}][infantfirstname][]" placeholder="First Name" class="form-control">
						</div>
						<div class="form_field">
							<input data-valid="required" type="text" name="passenger[{{$rooms[0]}}][infantlastname][]" placeholder="Last Name" class="form-control">
						</div> 
					</div> 
					<div class="clearfix"></div>
				</div>
				<?php } ?>
				<?php for($ijcb =0; $ijcb<$rooms[3]; $ijcb++){ ?>
				<div class="col-sm-12">
					<div class="col-sm-2 contact_label cus_label">Child With Bed <?php echo $ijcb + 1; ?></div>
					<div class="col-sm-10">
						<div class="form_field form_select_field">
							<select data-valid="required" class="form-control" name="passenger[{{$rooms[0]}}][cwbtitle][]">
								<option value="">Title</option>
								<option selected="" value="Miss">Miss</option>
								<option value="Master">Master</option>
							</select> 
							<input data-valid="required" type="text" name="passenger[{{$rooms[0]}}][cwbfirstname][]" placeholder="First Name" class="form-control">
						</div>
						<div class="form_field">
							<input data-valid="required" type="text" name="passenger[{{$rooms[0]}}][cwblastname][]" placeholder="Last Name" class="form-control">
						</div> 
					</div> 
					<div class="clearfix"></div>
				</div>
				<?php } ?>
				<?php for($ijcob =0; $ijcob<$rooms[4]; $ijcob++){ ?>
				<div class="col-sm-12">
					<div class="col-sm-2 contact_label cus_label">Child Without Bed <?php echo $ijcob + 1; ?></div>
					<div class="col-sm-10">
						<div class="form_field form_select_field">
							<select data-valid="required" class="form-control" name="passenger[{{$rooms[0]}}][cwobtitle][]">
								<option value="">Title</option>
								<option selected="" value="Miss">Miss</option>
								<option value="Master">Master</option>
							</select> 
							<input data-valid="required" type="text" name="passenger[{{$rooms[0]}}][cwobfirstname][]" placeholder="First Name" class="form-control">
						</div>
						<div class="form_field">
							<input data-valid="required" type="text" name="passenger[{{$rooms[0]}}][cwoblastname][]" placeholder="Last Name" class="form-control">
						</div> 
					</div> 
					<div class="clearfix"></div>
				</div>
				<?php } ?>
				<?php for($ijcobb =0; $ijcobb<$rooms[5]; $ijcobb++){ ?>
				<div class="col-sm-12">
					<div class="col-sm-2 contact_label cus_label">Child without Bed (below 2-3 years) <?php echo $ijcobb + 1; ?></div>
					<div class="col-sm-10">
						<div class="form_field form_select_field">
							<select data-valid="required" class="form-control" name="passenger[{{$rooms[0]}}][cwobbtitle][]">
								<option value="">Title</option>
								<option selected="" value="Miss">Miss</option>
								<option value="Master">Master</option>
							</select> 
							<input data-valid="required" type="text" name="passenger[{{$rooms[0]}}][cwobbfirstname][]" placeholder="First Name" class="form-control">
						</div>
						<div class="form_field">
							<input data-valid="required" type="text" name="passenger[{{$rooms[0]}}][cwobblastname][]" placeholder="Last Name" class="form-control">
						</div> 
					</div> 
					<div class="clearfix"></div>
				</div>
				<?php } ?>
			</div>
			
			
			<?php } ?>
			<div class="ladultrow"></div>
			<div class="lchildrow"></div>
		</div>
	</div><!-- .box-result end -->
</div> 
		<div class="ssrdata"></div>
			<section id="addontour" class="common_section">
			<section>
				<div class="booking_title">
					<h3>Hotels</h3>
				</div>
				<div class="addon_table table-responsive"> 
					<table class="table">
					<thead>
						<tr>
							<th></th>
							<th>Price</th>
						</tr>
						</thead>
						<tbody>
						<?php
						
						$hid = isset($_GET['hid']) ? $_GET['hid'] : ''; 
			$eexplode = explode('|', $hid);
			$nhdid = isset($_GET['nhdid']) ? $_GET['nhdid'] : ''; 
			$erexplode = explode('|', $nhdid);
								$hotels = \App\PackageHotel::where('package_id',$packagedetail->id)->get();
									$pricetotl = 0;
								foreach($hotels as $ht){
									$is_exist = \App\PackageHotel::where('package_id',$packagedetail->id)->where('hotel_name',$ht->hotel_name)->exists();
									$detailhotels = \App\Hotel::where('id',$ht->hotel_name)->first();
								
									if(in_array($ht->hotel_name, $eexplode)){
										$key = array_search ($ht->hotel_name, $eexplode);
										if($erexplode[$key] != 0){
										$detailhotelss = \App\Hotel::where('id',$erexplode[$key])->first();
										$pprice = $detailhotelss->price - $detailhotels->price;
										if($pprice > 0){
											$pricetotl += $pprice;
										}
										?>
									<tr>
										<td>{{@$detailhotelss->name}}</td>
										
											<td><?php
											if($pprice < 0){ echo 'Included'; }else{ echo $pprice; }
										?></td>
									
									</tr>

										<?php
										}else{
											?>
											<tr>
										<td>{{@$detailhotels->name}}</td>
									@if($is_exist)
										<td>Included</td>
									@else
										<td>{{@$detailhotels->price}}</td>
									@endif
									</tr>
											<?php
										}
									}else{
								?>
									<tr>
										<td>{{@$detailhotels->name}}</td>
									@if($is_exist)
										<td>Included</td>
									@else
										<td>{{@$detailhotels->price}}</td>
									@endif
									</tr>
								<?php } ?>
								<?php } ?>
						</tbody>
					</table>
				</div>
			</section>
			<section id="addontour" class="common_section">
				<div class="booking_title">
					<h3>Add-Ons</h3>
				</div>
				<div class="addon_table table-responsive"> 
					<table class="table">
						<thead>
							<tr>
								<th></th>
								<th>Adult Price</th>
							<th>Chilf Price</th>
							<th>Infant Price</th>
								<th>Duration</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$expaddon = explode(',', $packagedetail->addon); 
							for($ai = 0; $ai<count($expaddon); $ai++){
								$addon = \App\Addon::where('id',$expaddon[$ai])->first();
							?>
						<tr>
							<td>{{$addon->title}}</td>
							<td><i class="fa fa-rupee-sign"></i> {{$addon->price}}</td>
							<td><i class="fa fa-rupee-sign"></i> {{$addon->child}}</td>
							<td><i class="fa fa-rupee-sign"></i> {{$addon->infant}}</td>
							<td>{{$addon->duration}}</td>
							<td class="addon{{$addon->id}}">
							<?php 
							$explodeaddon = explode('|',$addons);
							if(in_array($addon->id, $explodeaddon)){
								?>
							<a data-id="{{$addon->id}}" data-price="{{$addon->price}}" data-child="{{$addon->child}}" data-infant="{{$addon->infant}}"  style="display:none;" class="addaddon selected" href="javascript:;"><i class="fa fa-plus"></i></a>

							<a data-id="{{$addon->id}}" class="removeaddon " href="javascript:;"><i class="fa fa-trash"></i></a></td>
								<?php
							}else{
							?>
							<a data-id="{{$addon->id}}" data-price="{{$addon->price}}" data-child="{{$addon->child}}" data-infant="{{$addon->infant}}"  class="addaddon" href="javascript:;"><i class="fa fa-plus"></i></a>

							<a data-id="{{$addon->id}}" style="display:none;" class="removeaddon" href="javascript:;"><i class="fa fa-trash"></i></a></td>
							<?php } ?>
						</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</section>
		</div> 
	</div>  
	<div class="col-md-3 col-sm-12 cus_sidebar" id="sidebar" style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">	
		<div class="booking_sidebar theiaStickySidebar" style="padding-top: 0px; padding-bottom: 1px; position: static; transform: none; left: 939px; top: 0px;">	
			<div class="inner_fare">	
				<h4>Fare Details</h4>
				<div class="fare_rules sidebar_bgclr inner_sidebar" id="DivFareQuote">
				<ul>
				<?php 
				$child = 0;
			$pax = isset($_GET['srch']) ? $_GET['srch'] : ''; 
			$explode = explode('|', $pax);
			$counttravler = 0;
			$countadult = 0;
			$countinfant = 0;
			$countcb = 0;
			$countcob = 0;
			$countcobb = 0;
			$adultprice = 0;
			$cwob = 0;
			$cwobb = 0;
			$cwb = 0;
			$infnt = 0;
			for($i =0; $i<count($explode); $i++){
				$rooms = explode('-', $explode[$i]);
				$countadult += $rooms[1];
				$countinfant += $rooms[2];
				$countcb += $rooms[3];
				$countcob += $rooms[4];
				$countcobb += $rooms[5];
				
				if($rooms[1] == 1){
					$price = $allprice->single;
				}else if($rooms[1] == 2){
					$price = $allprice->twin;
				}else{
					$price = $allprice->triple;
				}
				$adultprice += $price * $rooms[1];
			}
			
			 $counttravler = $countadult + $countinfant + $countcb + $countcob; 
				if($countinfant >0){
					$infnt = @$allprice->infant * $countinfant;
				}
			if($countcb >0){
					$cwb = @$allprice->child_with_bed * $countcb;
				}
				if($countcob >0){
					$cwob = @$allprice->child_without_bedbelow12 * $countcob;
				}
				if($countcobb >0){
					 $cwobb = @$allprice->child_without_bedbelow26 * $countcobb;
				}
				
				
				$totlaprice = $adultprice + $infnt + $cwob + $cwb + $cwobb;
				$child = $cwob + $cwb + $infnt + $cwobb + $pricetotl;
			?>
					<li class="basefare">Base Fare <small>(<span class="base_travel" data-no="{{$counttravler}}">{{$counttravler}}</span> Traveller)</small> <i class="fa fa-angle-down"></i>
					<span class="price mprice"><i class="fa fa-rupee-sign"></i> {{$totlaprice}}</span>
						<ul class="inner_ul">
							<li>Adults  x <span class="no_adult">{{$countadult}}</span>  <span class="adultprices price"><i class="fa fa-rupee-sign"></i> {{$adultprice}}</span></li>
							@if($countinfant >0)
							
								<li>Infant  x <span class="no_adult">{{$countinfant}}</span>  <span class=" price"><i class="fa fa-rupee-sign"></i> {{@$allprice->infant * $countinfant}}</span></li>
							@endif
							@if($countcb >0)
								
								<li>Child with bed  x <span class="no_adult">{{$countcb}}</span>  <span class=" price"><i class="fa fa-rupee-sign"></i> {{@$allprice->child_with_bed * $countcb}}</span></li>
							@endif
							@if($countcob >0)
								
								<li>Child without bed  x <span class="no_adult">{{$countcob}}</span>  <span class=" price"><i class="fa fa-rupee-sign"></i> {{@$allprice->child_without_bedbelow12 * $countcob}}</span></li>
							@endif
							@if($countcobb >0)
								
								<li>Child without bed (below 2-3 years)  x <span class="no_adult">{{$countcobb}}</span>  <span class=" price"><i class="fa fa-rupee-sign"></i> {{@$allprice->child_without_bedbelow26 * $countcobb}}</span></li>
							@endif
						</ul>
					</li> 
					
					<li style="display:none;" class="addons myaddons">Add-Ons <i class="fa fa-angle-down"></i>
						<span class="price"><i class="fa fa-rupee-sign"></i> <span class="addonprice">0</span></span>
						<small style="display:block;" class="addonname"></small>
						<ul class="inner_ul addonli">
							
						</ul>
					</li>
					
					<li class="total_value" totalfare="{{$totlaprice}}">Total Fare <span class="price"><i class="fa fa-rupee-sign"></i> <span class="totfare">{{$totlaprice}}</span></span>
					<input type="hidden" id="adulttotal" value="{{$adultprice}}">
					<input type="hidden" id="childtotal" value="{{$child}}">
					<input type="hidden" id="addontotal" value="0">
					
					<input type="hidden" id="ret_meal" value="0">
					<input type="hidden" id="dep_meal" value="0">
					<input type="hidden" id="coupon_code" value="0">
					</li> 
			
			<li class="discount_value" style="display:none;"></li>
			<li class="you_pay">You Pay: <span class="price"><i class="fa fa-rupee-sign"></i> <span class="youpay">{{$totlaprice}}</span></span>
			</li>
			
		
	</ul>
	<div class="clearfix"></div>
	<div id="bookingCounter" class="">
		<i class="fa fa-clock"></i> Your session will expire in
		<span id="timer">0 min 00 sec</span>
	</div>
	<div class="msessionpop" style="display: none;">
		<div class="searchpopinner searchpopinner1">
			<h2>Your Session is expired</h2>
			
			<a href="{{URL::to('/')}}">go to homepage.</a>
			<div class="clearfix"></div>
		</div> 
	</div>
		<input type="hidden" id="rsindex" value="OB2">
		<input type="hidden" id="traceid" value="">
		<input type="hidden" id="adultcount" value="{{@$countadult}}">
		<input type="hidden" id="childcount" value="{{@$countcb + $countcob + $countcobb}}">
		<input type="hidden" id="infantcount" value="{{@$countinfant}}">
		
		
				<script>
				$(document).ready(function() {
					$('.pay_btn').html('Proceed to payment');
					$('.pay_btn').prop('disabled', false);
				});
				var vald = $('#rsindex').val();
				var traceid = $('#traceid').val();

				if(getCookie("rindex") != vald && getCookie("traceid") != traceid)
						{
							document.cookie = "minutes" + "=;expires="  + new Date(0).toUTCString(); 
							document.cookie = "seconds" + "=;expires="  + new Date(0).toUTCString(); 
						}
				 var timeoutHandle;
						function countdown(minutes,stat) {
							var seconds = 60;
							var mins = minutes;
						if(getCookie("minutes")&&getCookie("seconds")&&stat)
						{
							var seconds = getCookie("seconds");
							var mins = getCookie("minutes");
						}
						function tick() {
							var counter = document.getElementById("timer");
							setCookie("minutes",mins,10)
							setCookie("seconds",seconds,10)
							setCookie("rindex",vald,10)
							setCookie("traceid",vald,10)
							var current_minutes = mins-1
							seconds--;
							counter.innerHTML = 
							current_minutes.toString() + " min " + (seconds < 10 ? "0" : "") + String(seconds)+" sec";
							//save the time in cookie
							if(seconds == 00 && current_minutes == 0){
								$('.myssionpop').show();
							}
							if( seconds > 0 ) {
								timeoutHandle=setTimeout(tick, 1000);
							} else {
								if(mins > 1){  
								setTimeout(function () { countdown(parseInt(mins)-1,false); }, 1000);
								}
							}
						}
						tick();
					}
					
					function setCookie(cname,cvalue,exdays) {
						var d = new Date();
						d.setTime(d.getTime() + (exdays*24*60*60*1000));
						var expires = "expires=" + d.toGMTString();
						document.cookie = cname+"="+cvalue+"; "+expires;
					}
					function getCookie(cname) {
						var name = cname + "=";
						var ca = document.cookie.split(';');
						for(var i=0; i<ca.length; i++) {
							var c = ca[i];
							while (c.charAt(0)==' ') c = c.substring(1);
							if (c.indexOf(name) == 0) {
								return c.substring(name.length, c.length);
							}
						}
						return "";
					}
					
						  countdown(2,true);
					
				</script>
				<script>
				$(document).ready(function() {
										
							$('.continue').on('click', function(){
								$('#farecheck').modal('hide');
							});
				});
				</script>
	</div>
		<h4>Promo Code</h4> 
				<div class="promo_code sidebar_bgclr inner_sidebar">
				<div class="inner_promo">
					<div class="form-group">
						<label class="promo_label">Select a Promo Code</label>
						<div class="promo_field"> 
							<input type="text" class="form-control applytext">
							<input type="hidden" name="coupncode" class="form-control applytextvaue">
							<button type="button" class="promo_button">Apply</button>
							<button type="button" style="display:none;" class="clear_button">Clear</button>
							<p class="couponsuccess" style="display:none;"></p>
						</div>
					</div>
					<div id="myUL" style="margin-top: 22px;">
						<?php 
			$today = date('Y-m-d');
				$coupons = \App\Coupon::whereDate('start_date','<=', $today)->whereDate('end_date','>=', $today)->where('status',1)->where('type','holiday')->get();
				foreach($coupons as $coupon){
			?>
			<div class="form-group coupon_li">
				<div class="cus_radio">
					<label>
						<div class="radio_field"><input name="couponcode" value="{{$coupon->coupon_code}}" type="radio" class="coupon_apply" /><span class="checkradio"></span></div> 
						<div class="promo_content">
							<span class="promo_key">{{$coupon->coupon_code}}</span>
							<span class="promo_desc">{{$coupon->description}}</span>
						</div>
					</label>
					<!--<div class="promo_terms">
						<a href="#">Terms & Conditions</a>
					</div>-->
				</div>
			</div>
				<?php } ?>
					</div>
					<div id="loadMore" class="view_all">
						<a href="javascript:;">View All</a>
					</div>
					
				</div>
				<div class="booking_btn">
					<button type="button" onclick="customValidate('frmProduct')" class="pay_btn">Proceed to payment</button>
				</div>
				</div>
			</div>
			<div class="resize-sensor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; z-index: -1; visibility: hidden;"><div class="resize-sensor-expand" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;"><div style="position: absolute; left: 0px; top: 0px; transition: all 0s ease 0s; width: 303px; height: 542px;"></div></div><div class="resize-sensor-shrink" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;"><div style="position: absolute; left: 0; top: 0; transition: 0s; width: 200%; height: 200%"></div></div></div>
									</div>
								</div>
		<div class="col-md-12 hidden-sm hidden-xs hidden" style="">
			<div class="booking_btn">
				<button type="button" onclick="customValidate('frmProduct')" class="pay_btn">Proceed to payment</button>
			</div>
		</div>
			<div class="clearfix"></div>
		</div>	
		<input type="hidden" id="payment_method" name="payment_method" value="razorpay">
		 {{ Form::close() }}
			</div>	
		</div>	
	</div>	
</div>	
<div class=""></div>	
</section>
	<script>   
	jQuery(document).ready(function($){
		var vccc = 1;
		addoncalulate();
		function addoncalulate(){
			var adult = $('#adultcount').val();
			var child = $('#childcount').val();
			var infant = $('#infantcount').val();
			var addons = '';
			$("#addontour .selected").each(function() {
			  var i = $(this).attr('data-id');
			
			var p = $(this).attr('data-price');
			var pc = $(this).attr('data-child');
			var pi = $(this).attr('data-infant');
			$('.addons').show();
			$('.addon'+i+' .removeaddon').show();
			$('.addon'+i+' .addaddon').hide();
			var htm ='';
			if(adult >  0){
				var pa = parseInt(p) * adult;
				 htm += '<li dataprice="'+pa+'" class="addonid'+i+' alladdons">Adult Addon <span class="adultprices price"><i class="fa fa-rupee-sign"></i> '+pa+'</span><input type="hidden" name="myaddons[]" value="'+i+'"></li>';
			}
			if(child >  0){
				var pac = parseInt(pc) * child;
				htm += '<li dataprice="'+pac+'" class="addonid'+i+' alladdons">Child Addon <span class="childprices price"><i class="fa fa-rupee-sign"></i> '+pac+'</span><input type="hidden" name="myaddons[]" value="'+i+'"></li>';
			}
			if(infant >  0){
				var pai = parseInt(pi) * infant;
				htm += '<li dataprice="'+pai+'" class="addonid'+i+' alladdons">Infant Addon <span class="infantprices price"><i class="fa fa-rupee-sign"></i> '+pai+'</span><input type="hidden" name="myaddons[]" value="'+i+'"></li>';
			}
			$('.myaddons .addonli').append(htm);
			});
			
			calculatepackage();
		}
		$(document).delegate('.addaddon', 'click', function(){
				var i = $(this).attr('data-id');
			var p = $(this).attr('data-price');
			var pc = $(this).attr('data-child');
			var pi = $(this).attr('data-infant');
			
			var adult = $('#adultcount').val();
			var child = $('#childcount').val();
			var infant = $('#infantcount').val();
			$('.addons').show();
			$('.addon'+i+' .removeaddon').show();
			$('.addon'+i+' .addaddon').hide();
			
			var htm ='';
			if(adult >  0){
				var pa = parseInt(p) * adult;
				 htm += '<li dataprice="'+pa+'" class="addonid'+i+' alladdons">Adult Addon <span class="adultprices price"><i class="fa fa-rupee-sign"></i> '+pa+'</span><input type="hidden" name="myaddons[]" value="'+i+'"></li>';
			}
			if(child >  0){
				var pac = parseInt(pc) * child;
				htm += '<li dataprice="'+pac+'" class="addonid'+i+' alladdons">Child Addon <span class="childprices price"><i class="fa fa-rupee-sign"></i> '+pac+'</span><input type="hidden" name="myaddons[]" value="'+i+'"></li>';
			}
			if(infant >  0){
				var pai = parseInt(pi) * infant;
				htm += '<li dataprice="'+pai+'" class="addonid'+i+' alladdons">Infant Addon <span class="infantprices price"><i class="fa fa-rupee-sign"></i> '+pai+'</span><input type="hidden" name="myaddons[]" value="'+i+'"></li>';
			}
			$('.myaddons .addonli').append(htm);
			calculatepackage();
		});
		$(document).delegate('.removeaddon', 'click', function(){
			var i = $(this).attr('data-id');
			
			$('.addon'+i+' .removeaddon').hide();
			$('.addon'+i+' .addaddon').show();
			$('.addons .addonli .addonid'+i).remove();
			/* var rr = window.location.href;
			var spliturl = rr.split('&');
			var splitadd = spliturl[2].split('='); 
			var splitmadd = splitadd[1].split('|'); 
			var index = splitmadd.indexOf('5'); // get index if value found otherwise -1

if (index > -1) { //if found
  splitmadd.splice(index, 1);
}
console.log(splitmadd); */
			calculatepackage(); 
			 var numItems = $('.alladdons').length;
			 if(numItems == 0){
				 $('.addons').hide();
			 }
		});
		function calculatepackage(){
		
			var childtotl = $('#childtotal').val();
			var adulttotal = $('#adulttotal').val();
			var finaltotl = parseInt(adulttotal) + parseInt(childtotl);
			
			
			var inval = 0;
			$(".alladdons").each(function() {
			   inval += parseInt($(this).attr('dataprice'));
			   console.log($(this).attr('dataprice'));
			});
			//var vl = $('#addontotal').val();
			var tt = parseInt(inval);
		
			$('.addonprice').html(tt);
			
			$('.totfare').html(parseInt(finaltotl) + parseInt(tt));
			var total = parseInt(finaltotl) + parseInt(tt);
			var cp = $('#coupon_code').val();
			var discount = 0;
			if(cp != 0){
					var value = cp.split('|');
					if(value[1] == 'percentage'){
						discount = (total * value[0]/100);
					}else{
						discount =  value[0];
					} 
				}
				
				$('.distotfare').html(discount.toLocaleString());
				var finaltotal = parseInt(total) - parseInt(discount);
				var fn = Math.round(finaltotal);
			$('.youpay').html(fn);
		}
		$(document).delegate('.commonc', 'change', function(e){
			var v = $(this).attr('cid');
			var obj = $.parseJSON(jsonprice);
			var vl = $('#s_'+v+' .commonc').val();
			var l = '';
			var sl = 0;
			
			var ptwinprice = $('input[name="packadult"]').val();
			$(".commonc").each(function() {
			   l = $('option:selected',this).attr('value');
			   if(l == "cwb"){
				  sl++; 
			   }
			});
			var a = parseInt(ptwinprice) + parseInt(sl);
			
			if(a > 3){
				$(this).val('0');
				alert("Sum of Adults and Child with bed ina room can't be more than 3");
			}else{
				if(!$('.childrow').hasClass('cd'+v+'')){
				$('<div id="" class="row counttravler childrow cd'+v+'">'
						+'<div class="col-sm-12">'
					+'<div class="col-sm-2 contact_label cus_label">Child '+v+'</div>'
					+'<div class="col-sm-10">'
						+'<div class="form_field form_select_field">'
							+'<select data-valid="required" class="form-control" name="passenger[childtitle][]">'
								+'<option value="">Title</option>'
								+'<option selected="" value="Miss">Miss</option>'
								+'<option value="Master">Master</option>'
							+'</select>' 
							+'<input data-valid="required" type="text" name="passenger[childfirstname][]" placeholder="First Name" class="form-control">'
						+'</div>'
						+'<div class="form_field">'
							+'<input data-valid="required" type="text" name="passenger[childlastname][]" placeholder="Last Name" class="form-control"><input  type="hidden" name="passenger[childtype][]" value="'+vl+'">'
						+'</div> '
					+'</div> '
					+'<div class="clearfix"></div>'
				+'</div>'
			+'</div>').insertBefore('.lchildrow');
			}
			if(vl == "infant"){
				perprice = obj.infant;
				price = obj.infant * 1;
				$('#s_'+v+' .perchild').html('<i class="fa fa-rupee-sign"></i> '+price);
				
			$('#s_'+v+' .netchild').html('<i class="fa fa-rupee-sign"></i> '+perprice+'<input type="hidden" class="infantprice" value="'+price+'">');
			}else if(vl == "cwb"){
				perprice = obj.child_with_bed;
				price = obj.child_with_bed * 1;
				$('#s_'+v+' .perchild').html('<i class="fa fa-rupee-sign"></i> '+price);
			$('#s_'+v+' .netchild').html('<i class="fa fa-rupee-sign"></i> '+perprice+'<input type="hidden" class="cwbprice" value="'+price+'">');
			}else if(vl == "cwob"){
				perprice = obj.child_without_bedbelow12;
				price = obj.child_without_bedbelow12 * 1;
				$('#s_'+v+' .perchild').html('<i class="fa fa-rupee-sign"></i> '+price);
			$('#s_'+v+' .netchild').html('<i class="fa fa-rupee-sign"></i> '+perprice+'<input type="hidden" class="cwobprice" value="'+price+'">');
			
			}else{
				$('#s_'+v+' .perchild').html('');
				$('#s_'+v+' .netchild').html('');
				$('.cd'+v).remove();
			}
			calculatechildprice();
		}
		});
		
		function calculatechildprice(){
			var inval = 0;
			/* $(".infantprice").each(function() {
			   inval += parseInt($(this).val());
			}); */
			var cwbval = 0;
			$(".cwbprice").each(function() {
			   cwbval += parseInt($(this).val());
			});
			var cwobval = 0;
			$(".cwobprice").each(function() {
			   cwobval += parseInt($(this).val());
			});
			
			var totalpri = parseInt(inval) + parseInt(cwbval) + parseInt(cwobval); 
			 $('.childp').show();
			 var numItems = $('.childrow').length;
			 var counttravler = $('.counttravler').length;
			$('.childp').html('Child X <span class="noofchild">'+numItems+'</span><span class="childprices"><i class="fa fa-rupee-sign"></i> '+totalpri+'</span>'); 
			var vdd = $('.base_travel').attr('data-no');
			
			$('.base_travel').attr('data-no',counttravler);
			$('.base_travel').html(counttravler);
			
			$('#childtotal').val(totalpri);
			var childtotl = $('#childtotal').val();
			var adulttotal = $('#adulttotal').val();
			var finaltotl = parseInt(adulttotal) + parseInt(childtotl);
			$('.basefare .mprice').html('<i class="fa fa-rupee-sign"></i> '+finaltotl);
			var inval = 0;
			$(".alladdons").each(function() {
			   inval += parseInt($(this).attr('dataprice'));
			});
			//var vl = $('#addontotal').val();
			var tt = parseInt(inval);
			$('.totfare').html(parseInt(finaltotl) + parseInt(tt));
			
			var total = parseInt(finaltotl) + parseInt(tt);
			var cp = $('#coupon_code').val();
			var discount = 0;
			if(cp != 0){
					var value = cp.split('|');
					if(value[1] == 'percentage'){
						discount = (total * value[0]/100);
					}else{
						discount =  value[0];
					} 
				}
				
				$('.distotfare').html(discount.toLocaleString());
				var finaltotal = parseInt(total) - parseInt(discount);
				var fn = Math.round(finaltotal);
			$('.youpay').html(fn);
		
		}
		$('.adultinc').click(function(e){
			  e.preventDefault();
			   fieldName = $(this).attr('field');
			   var currentVal = parseInt($('input[name='+fieldName+']').val());
			  if(currentVal < 3){
				    if (!isNaN(currentVal)) {
						var sss= currentVal + 1;
						$('<div class="row counttravler adultrow">'
						+'<div class="col-sm-12">'
					+'<div class="col-sm-2 contact_label cus_label">Adults '+sss+'</div>'
					+'<div class="col-sm-10">'
						+'<div class="form_field form_select_field">'
							+'<select data-valid="required" class="form-control" name="passenger[adulttitle][]">'
								+'<option value="">Title</option>'
								+'<option selected="" value="Mr">Mr.</option>'
								+'<option value="Mrs">Mrs.</option>'
								+'<option value="Ms">Ms.</option>'
							+'</select>' 
							+'<input data-valid="required" type="text" name="passenger[adultfirstname][]" placeholder="First Name" class="form-control">'
						+'</div>'
						+'<div class="form_field">'
							+'<input data-valid="required" type="text" name="passenger[adultlastname][]" placeholder="Last Name" class="form-control">'
						+'</div> '
					+'</div> '
					+'<div class="clearfix"></div>'
				+'</div>'
			+'</div>').insertBefore('.ladultrow');
						$('input[name='+fieldName+']').val(currentVal + 1);
					} else {
						// Otherwise put a 0 there
						$('input[name='+fieldName+']').val(1);
					}
			  }  
			  
			  calculatepackage();
		});
		
		$('.childinc').click(function(e){
			  e.preventDefault();
			   fieldName = $(this).attr('field');
			   var currentVal = parseInt($('input[name='+fieldName+']').val());
			  if(currentVal < 3){
				    if (!isNaN(currentVal)) {
						// Increment
						var v = currentVal + 1;
						$('input[name='+fieldName+']').val(currentVal + 1);
						
						$('<tr id="s_'+v+'" class="inner_child"><td><label>Child '+v+'</label><select data-valid="required" class="commonc" cid="'+v+'" name="child[]"><option value="0">Please select</option><option value="infant">Infant (0-2 years)</option><option value="cwb">Child with bed</option><option value="cwob">Child without bed</option></select></td><td>1</td><td class="perchild"></td><td class="netchild"></td></tr>').insertBefore('.linner_child');
					} else {
						$('<tr id="s_1" class="inner_child"><td><label>Child 1</label><select data-valid="required" cid="1" class="commonc" name="child[]"><option value="0">Please select</option><option value="infant">Infant (0-2 years)</option><option value="cwb">Child with bed</option><option value="cwob">Child without bed</option></select></td><td>1</td><td class="perchild"></td><td class="netchild"></td></tr>').insertBefore('.linner_child');
						// Otherwise put a 0 there
						$('input[name='+fieldName+']').val(1);
					}
			  }  
			  
			 // calculatepackage();
		});
		$('.childdec').click(function(e){
			e.preventDefault();
			fieldName = $(this).attr('field'); 
			var currentVal = parseInt($('input[name='+fieldName+']').val());
        
			if (!isNaN(currentVal) && currentVal > 1) {
				var vl = currentVal -1;
				$('.pack_table_data table tr.inner_child:last').remove();
				$('.childrow:last').remove();
				$('input[name='+fieldName+']').val(vl);
			} else {
				// Otherwise put a 0 there
				$('.pack_table_data table tr.inner_child:last').remove();
				$('.childrow').remove();
				$('input[name='+fieldName+']').val(0);
			}
			 calculatepackage();
			 calculatechildprice();
		 });
		 $('.adultdec').click(function(e){
			e.preventDefault();
			fieldName = $(this).attr('field'); 
			var currentVal = parseInt($('input[name='+fieldName+']').val());
        
			if (!isNaN(currentVal) && currentVal > 1) {
				var vl = currentVal -1;
				$('.adultrow:last').remove();
				$('input[name='+fieldName+']').val(vl);
			} else {
				// Otherwise put a 0 there
				$('input[name='+fieldName+']').val(1);
			}
			 calculatepackage();
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
	console.log(jsonprice);
		 function showMBPopup(){
			$('#mytravelModal').modal('show');
		}
			  
		$(document).ready(function() {
			
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
});

	</script>
<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Payment Method</h4>
		  </div>
		  <div class="modal-body">
				<div class="row"> 
					<div class="col-md-12">
						<?php $ccavenu = \App\MyConfig::where('meta_key','cc_status')->first(); ?>
						@if($ccavenu->meta_value == 1)
							<div class="form-group">
								<label class=""><input type="radio" class="paymethod"  name="paymentmethod" value="ccavenue"> <img src="{{URL::to('/public/icons/cc_avenue1.png')}}"> </label>
							</div>
						@endif
						<?php $rzavenu = \App\MyConfig::where('meta_key','rz_status')->first(); ?>
						@if($rzavenu->meta_value == 1)
							<div class="form-group">
								<label class=""><input checked class="paymethod" type="radio"  name="paymentmethod" value="razorpay"> <img style="width: 100px;height:23px;" src="{{URL::to('/public/icons/razorpay.jpg')}}"> </label>
							</div>
						@endif
					</div>
				</div>
		  </div>
		  <div class="modal-footer">
			<button class="pay_ticket" form="frm_Product"  type="submit">Submit</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>

	  </div> 
</div>
<?php }else{
	?>
<section id="content" style="transform: none;">
	<div id="content-wrap" style="transform: none;">
		<div class="section-flat single_sec_flat booking_sec" style="transform: none;">      
			<div class="section-content" style="transform: none;">
				<div class="container" style="transform: none;">
					<h4>Package Not Found</h4>
				</div>
			</div>
		</div>
	</div>
</section>
	<?php
} ?>
@endsection