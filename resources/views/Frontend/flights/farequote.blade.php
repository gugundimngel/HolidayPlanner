<?php
if($expired ==0){
if(isset($resultdata->Response->Results->Segments[0])){
	$ir = 0;
		$res = $resultdata->Response->Results;
}

if(!empty($resultdataib)){ 
if(isset($resultdataib->Response->Results->Segments[0])){
	$is_return = 1;
$resarrive = $resultdataib->Response->Results;

}
}

$searchdata = Session::get('allrequest');
$mytravlercount = explode('-', $searchdata['px']);
	$mtcount = 0;
	for($mit =0; $mit<count($mytravlercount); $mit++){
		$mtcount += $mytravlercount[$mit];
	}
?>

<ul>
	<?php 
	$farebrakdown = $res->FareBreakdown;

	if(!empty($resultdataib) && isset($resultdataib->Response->Results->Segments[0])){ 
		$farebrakdownR = $resarrive->FareBreakdown; 
		?>
		<?php $vasefarec = 0; for($fbs = 0; $fbs<count($farebrakdown); $fbs++){ $vasefarec += $farebrakdown[$fbs]->BaseFare + $farebrakdownR[$fbs]->BaseFare; }  ?>
		<li class="basefare">Base Fare <small>(<?php echo $mtcount; ?> Traveller)</small> <i class="fa fa-angle-down"></i>
			<span class="price"><i class="fa fa-rupee-sign"></i> {{number_format($vasefarec)}}</span>
			<ul class="inner_ul">
				<?php for($fb = 0; $fb<count($farebrakdown); $fb++){ ?>
				<li><?php if($farebrakdown[$fb]->PassengerType == 1){ echo 'Adults'; }else if($farebrakdown[$fb]->PassengerType == 2){ echo 'Child'; }else{ echo 'Infant'; } ?>  x <?php echo $farebrakdown[$fb]->PassengerCount ?>  <span class="price"><i class="fa fa-rupee-sign"></i> <?php echo number_format($farebrakdown[$fb]->BaseFare + $farebrakdownR[$fb]->BaseFare); ?></span></li>
				<?php } ?>
			</ul>
		</li> 
		<li class="fee_subcharge">Taxes & Subcharges <!--<i class="fa fa-angle-down"></i>-->
		<?php  $is_international = $_GET['IsInternational']; ?>
		
			<?php
	$markupd =0;
	$submark =0;
	$markupamt = \App\Markup::where('flight_code', $res->Segments[0][0]->Airline->AirlineCode)->where('flight_type', $is_international)->where('user_type', 'b2c')->first(); 
	if($markupamt){
		if($markupamt->service_type == 'fixed'){
			$markupd =  $markupamt->service_fee * $mtcount;
		}else{
			$markupd = ($res->Fare->OfferedFare * $markupamt->service_fee/100) * $mtcount;
		}
		$mark = $res->Fare->OfferedFare + $markupd;
	 $submark = $mark - $res->Fare->PublishedFare;
	}
	
	if($submark < 0){
		$newtotal1 = round($res->Fare->PublishedFare + $submark);
	}else{
		$newtotal1 = round($res->Fare->PublishedFare + $submark);
	}
	/*Return*/
	$remarkupd =0;
	$sremarkupd =0;
	$remarkupamt = \App\Markup::where('flight_code', $resarrive->Segments[0][0]->Airline->AirlineCode)->where('flight_type', $is_international)->where('user_type', 'b2c')->first(); 
	if($remarkupamt){
		if($remarkupamt->service_type == 'fixed'){
			$remarkupd =  $remarkupamt->service_fee * $mtcount;
		}else{
			$remarkupd = ($resarrive->Fare->OfferedFare * $remarkupamt->service_fee/100) * $mtcount;
		}
		 $remark = $resarrive->Fare->OfferedFare + $remarkupd;
	 $sremarkupd = $remark - $resarrive->Fare->PublishedFare;
	}
	if($submark < 0){
		$newtotal2 = round($resarrive->Fare->PublishedFare + $sremarkupd);
	}else{
		$newtotal2 = round($resarrive->Fare->PublishedFare + $sremarkupd);
	}
	?>
			<span class="price"><i class="fa fa-rupee-sign"></i> <?php echo number_format($res->Fare->Tax + $res->Fare->OtherCharges  + $res->Fare->AdditionalTxnFeePub + $res->Fare->ServiceFee + @$res->Fare->AirlineTransFee + $resarrive->Fare->Tax + $resarrive->Fare->OtherCharges  + $resarrive->Fare->AdditionalTxnFeePub + $resarrive->Fare->ServiceFee + @$resarrive->Fare->AirlineTransFee ); ?></span>
			<!--<ul class="inner_ul">
				<li>User Development Fee <span class="price"><i class="fa fa-rupee-sign"></i> 142</span></li>
				<li>GST <span class="price"><i class="fa fa-rupee-sign"></i> 254</span></li>
				<li>Airline Fuel Subcharges <span class="price"><i class="fa fa-rupee-sign"></i> 2,187</span></li>
			</ul>-->
		</li>
		<li style="display:none;" class="addons">Add-Ons <i class="fa fa-angle-down"></i>
			<span class="price"><i class="fa fa-rupee-sign"></i> <span class="addonprice"></span></span>
			<small style="display:block;" class="addonname"></small>
			<ul class="inner_ul addonli">
				
			</ul>
		</li>
		<?php
		
		 $newtotal = $newtotal1 + $newtotal2;
			$service_fees = \App\MyConfig::where('meta_key','service_fees')->first();
			$service_type = \App\MyConfig::where('meta_key','service_type')->first();
			if($service_type->meta_value == 'fixed'){
					$mv =  $service_fees->meta_value;
				}else{
					$mv = ($newtotal * $service_fees->meta_value/100);
				}
				
				$newtoal = $newtotal + $mv;
				//$nytotal = $stotal - $newtotal; 
				 if($submark < 0){
					
					?>
					<li>Discount <span class="price"><i class="fa fa-rupee-sign"></i><?php echo round($submark); ?> </span></li>
					<?php
				}else{
		
					?>
					<li>Discount <span class="price"><i class="fa fa-rupee-sign"></i><?php echo 0; ?> </span></li>
					<?php
				}
				if($submark < 0){
					 ?>
					<li>Service Fee <span class="price"><i class="fa fa-rupee-sign"></i><?php echo round($mv); ?> </span></li>
					<?php
					  }else{
						  ?>
						  <li>Service Fee <span class="price"><i class="fa fa-rupee-sign"></i><?php echo round($submark + $sremarkupd + $mv); ?> </span></li>
						  <?php
					  }
		?>
		<li class="excess_bagage">Excess Baggage (<span class="weightc">0</span>KG )
			<span class="price"><i class="fa fa-rupee-sign"></i> 0.00</span>
		</li>
		<li class="meal_charges">Meal (<span class="mealxc">0</span>)
			<span class="price"><i class="fa fa-rupee-sign"></i> 0.00</span>
		</li>
		<li class="seat_charges">Seat Charges
		<span class="price"><i class="fa fa-rupee-sign"></i> 0.00</span>
	</li>
		<li class="total_value" totalfare="<?php echo round($newtoal); ?>">Total Fare <span class="price"><i class="fa fa-rupee-sign"></i> <span class="totfare"><?php echo number_format(round($newtoal)); ?></span></span>
		<input type="hidden" id="tev_we" value="0">
		<input type="hidden" id="dep_we" value="0">
		<input type="hidden" id="ret_we" value="0">
		<input type="hidden" id="ret_meal" value="0">
		<input type="hidden" id="dep_meal" value="0">
		<input type="hidden" id="coupon_code" value="0">
		</li> 
		<li class="discount_value" style="display:none;"></li>
		<li class="you_pay">You Pay: <span class="price"><i class="fa fa-rupee-sign"></i> <span class="youpay"><?php echo number_format(round($newtoal)); ?></span></span>
		</li>
		
		<?php
	}else{
		
		?>
		<?php if(@$_GET['IsInternational'] == 1 || @$_GET['IsInternational'] == 'true'){ $is_international = 'international'; }else{ $is_international = 'domestic'; }

		$markupd =0;
		$submark = 0;
	foreach($res->Segments as $key => $resss){ 
		$allflighdata = $resss;
		$markupamt = \App\Markup::where('flight_code', $allflighdata[0]->Airline->AirlineCode)->where('flight_type', $is_international)->where('user_type', 'b2c')->first(); 
		if($markupamt){
			if($markupamt->service_type == 'fixed'){
				$markupd =  $markupamt->service_fee * $mtcount;
			}else{
				$markupd = ($res->Fare->OfferedFare * $markupamt->service_fee/100) * $mtcount;
			}
			 $mark = $res->Fare->OfferedFare + $markupd;
			$submark = $mark - $res->Fare->PublishedFare;
		}
	}
	
			
	
	
	
		 if($submark < 0){
			$newtotal = round($res->Fare->PublishedFare + $submark);
		}else{
			$newtotal = round($res->Fare->PublishedFare + $submark);
		}
		?>
		
		<?php $vasefarec = 0; for($fbs = 0; $fbs<count($farebrakdown); $fbs++){ $vasefarec += $farebrakdown[$fbs]->BaseFare; }  ?>
		<li class="basefare">Base Fare <small>(<?php echo $mtcount; ?> Traveller)</small> <i class="fa fa-angle-down"></i>
			<span class="price"><i class="fa fa-rupee-sign"></i> {{number_format($vasefarec)}}</span>
			<ul class="inner_ul">
				<?php for($fb = 0; $fb<count($farebrakdown); $fb++){ ?>
				<li><?php if($farebrakdown[$fb]->PassengerType == 1){ echo 'Adults'; }else if($farebrakdown[$fb]->PassengerType == 2){ echo 'Child'; }else{ echo 'Infant'; } ?>  x <?php echo $farebrakdown[$fb]->PassengerCount ?>  <span class="price"><i class="fa fa-rupee-sign"></i> <?php echo number_format($farebrakdown[$fb]->BaseFare); ?></span></li>
				<?php } ?>
			</ul>
		</li> 
		<li class="fee_subcharge">Taxes & Surcharges <!--<i class="fa fa-angle-down"></i>-->
			<span class="price"><i class="fa fa-rupee-sign"></i> <?php echo number_format($res->Fare->Tax + $res->Fare->OtherCharges  + $res->Fare->AdditionalTxnFeePub + $res->Fare->ServiceFee + @$res->Fare->AirlineTransFee); ?></span>
			<!--<ul class="inner_ul">
				<li>User Development Fee <span class="price"><i class="fa fa-rupee-sign"></i> 142</span></li>
				<li>GST <span class="price"><i class="fa fa-rupee-sign"></i> 254</span></li>
				<li>Airline Fuel Subcharges <span class="price"><i class="fa fa-rupee-sign"></i> 2,187</span></li>
			</ul>-->
		</li>
		<li style="display:none;" class="addons">Add-Ons <i class="fa fa-angle-down"></i>
			<span class="price"><i class="fa fa-rupee-sign"></i> <span class="addonprice">10</span></span>
			<small style="display:block;" class="addonname"></small>
			<ul class="inner_ul addonli">
				
			</ul>
		</li>
		
		<?php 
		 
			$service_fees = \App\MyConfig::where('meta_key','service_fees')->first();
			$service_type = \App\MyConfig::where('meta_key','service_type')->first();
			if($service_type->meta_value == 'fixed'){
					$mv =  $service_fees->meta_value;
				}else{
					$mv = ($newtotal * $service_fees->meta_value/100);
				}
				
				$newtoal = $newtotal + $mv ;
				//$newtoal = $newtotal + $mv;
				//$newtoal = $submark; 
			
				/*  if($nytotal < 0){
					$newtoal = $res->Fare->PublishedFare + $submark + $nytotal;
					?>
					<li>Discount <span class="price"><i class="fa fa-rupee-sign"></i><?php echo round($submark + $nytotal); ?> </span></li>
					<?php
				}else{  */
					//$newtoal = $res->Fare->PublishedFare + $submark;
					 if($submark < 0){
					?>
					<li>Discount <span class="price"><i class="fa fa-rupee-sign"></i><?php echo round($submark); ?> </span></li>
					 <?php }else{
						 ?>
						 <li>Discount <span class="price"><i class="fa fa-rupee-sign"></i><?php echo 0; ?> </span></li>
						 <?php
					 } 
					  if($submark < 0){
					 ?>
					<li>Service Fee <span class="price"><i class="fa fa-rupee-sign"></i><?php echo round($mv); ?> </span></li>
					<?php
					  }else{
						  ?>
						  <li>Service Fee <span class="price"><i class="fa fa-rupee-sign"></i><?php echo round($submark + $mv); ?> </span></li>
						  <?php
					  }
				//}
				
		?>
		<li class="excess_bagage">Excess Baggage (<span class="weightc">0</span>KG )
			<span class="price"><i class="fa fa-rupee-sign"></i> 0.00</span>
		</li>
		<li class="meal_charges">Meal (<span class="mealxc">0</span>)
			<span class="price"><i class="fa fa-rupee-sign"></i> 0.00</span>
		</li>
		<li class="seat_charges">Seat Charges
		<span class="price"><i class="fa fa-rupee-sign"></i> 0.00</span>
	</li>
		<li class="total_value" totalfare="{{$newtoal}}">Total Fare <span class="price"><i class="fa fa-rupee-sign"></i> <span class="totfare"><?php echo number_format(round($newtoal)); ?></span></span>
		<input type="hidden" id="tev_we" value="0">
		<input type="hidden" id="dep_we" value="0">
		<input type="hidden" id="ret_we" value="0">
		<input type="hidden" id="ret_meal" value="0">
		<input type="hidden" id="dep_meal" value="0">
		<input type="hidden" id="coupon_code" value="0">
		</li> 
		
		<li class="discount_value" style="display:none;"></li>
		<li class="you_pay">You Pay: <span class="price"><i class="fa fa-rupee-sign"></i> <span class="youpay"><?php echo number_format(round($newtoal)); ?></span></span>
		</li>
		<?php
	}
	?>
	
		<!--<li class="earn">Earn <div style="display:inline-block;color:#db9a00;">eCash</div> <i class="fa fa-explanation"></i>: <span class="price"><i class="fa fa-rupee-sign"></i> 500</span>
		</li>-->
	</ul>
	<div class="clearfix"></div>

<div id="bookingCounter" class="">
		<i class="fa fa-clock"></i> Your session will expire in
		<span id="timer">
			
		</span>
	</div>
	<div class="msessionpop" style="display: none;">
			<div class="searchpopinner searchpopinner1">
				<h2>Your Session is expired</h2>
				
				<a href='{{URL::to('/')}}'>go to homepage.</a>
				<div class="clearfix"></div>
			</div> 
		</div>
		<input type="hidden" id="rsindex" value="{{@$resultdata->Response->Results->ResultIndex}}">
		<input type="hidden" id="traceid" value="{{@$resultdata->Response->Results->TraceId}}">
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
			<?php
if(@$resultdata->Response->IsPriceChanged || @$resultdataib->Response->IsPriceChanged){
				?>
				$('#farecheck .oldprice').html('{{$mytotal}}');
				$('#farecheck .newprice').html('{{$newtotal}}');
				$('#farecheck').modal('show');
				<?php
			}
			?>
			
			$('.continue').on('click', function(){
				$('#farecheck').modal('hide');
			});
});
</script>
	

		<?php }else{
			?>
			<div class="msessionpop" style="display: none;">
			<div class="searchpopinner searchpopinner1">
				<h2>Booking Error</h2>
				<p>{{$err}}</p>
				
				<a href='{{URL::to('/')}}'>go to homepage.</a>
				<div class="clearfix"></div>
			</div> 
		</div>
			<script>
$(document).ready(function() {
		
			$('.msessionpop').show();
			
});
</script>

			<?php
		} ?>