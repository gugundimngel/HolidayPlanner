<?php
$fetchprices = \App\PackagePrice::where('package_id', $fetchedData->id)->orderBy('id','ASC')->get();
$ccount=0;
foreach($fetchprices as $pricelist){
	$ccount++;
?>
<div class="pdetail" id="s_0">
<input type="hidden" name="priceid[]" value="{{@$pricelist->id}}">
	<div class="form-group row"> 
			<label for="twin" class="col-sm-4 col-form-label">Twin</label>
			<div class="col-sm-6">
			{{ Form::text('twin[]', @$pricelist->twin, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'twin Price', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('twin'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('twin') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="triple" class="col-sm-4 col-form-label">Triple</label>
			<div class="col-sm-6">
			{{ Form::text('triple[]', @$pricelist->triple, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Tripple Price', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('triple'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('triple') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="single" class="col-sm-4 col-form-label">Single</label>
			<div class="col-sm-6">
			{{ Form::text('single[]', @$pricelist->single, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'single', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('single'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('single') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  
	  <div class="form-group row"> 
			<label for="child_with_bed" class="col-sm-4 col-form-label">Child with Bed (below 12 years)</label>
			<div class="col-sm-6">
			{{ Form::text('child_with_bed[]', @$pricelist->child_with_bed, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Child with Bed (below 12 years)', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('child_with_bed'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('child_with_bed') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="child_without_bedbelow12" class="col-sm-4 col-form-label">Child without Bed (below 12 years)</label>
			<div class="col-sm-6">
			{{ Form::text('child_without_bedbelow12[]', @$pricelist->child_without_bedbelow12, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Child without Bed (below 12 years)', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('child_without_bedbelow12'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('child_without_bedbelow12') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="child_without_bedbelow26" class="col-sm-4 col-form-label">Child without Bed (below 2-3 years)</label>
			<div class="col-sm-6">
			{{ Form::text('child_without_bedbelow26[]', @$pricelist->child_without_bedbelow26, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Child without Bed (below 2-3 years)', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('child_without_bedbelow26'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('child_without_bedbelow26') }}</strong>
				</span> 	
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="infant" class="col-sm-4 col-form-label">Infant</label>
			<div class="col-sm-6">
			{{ Form::text('infant[]', @$pricelist->infant, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Infant', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('infant'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('infant') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="adult_flight" class="col-sm-4 col-form-label">Adult (Flight Only)</label>
			<div class="col-sm-6">
			{{ Form::text('adult_flight[]', @$pricelist->adult_flight, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Adult (Flight Only)', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('adult_flight'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('adult_flight') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="child_flight" class="col-sm-4 col-form-label">Child (Flight Only)</label>
			<div class="col-sm-6">
			{{ Form::text('child_flight[]', @$pricelist->child_flight, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Child (Flight Only)', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('child_flight'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('child_flight') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="infant_flight" class="col-sm-4 col-form-label">Infant (Flight Only)</label>
			<div class="col-sm-6">
			{{ Form::text('infant_flight[]', @$pricelist->infant_flight, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Infant (Flight Only)', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('infant_flight'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('infant_flight') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="seats" class="col-sm-4 col-form-label">Total Seat Available</label>
			<div class="col-sm-6">
			{{ Form::text('seats[]', @$pricelist->seats, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Total Seat Available', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('seats'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('seats') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row">
		<label for="price_type" class="col-sm-4 col-form-label">Price Type</label>
		<div class="col-sm-6">
		<select class="form-control" name="price_type[]">
			<option value="Per Person" <?php if(@$pricelist->price_type == "Per Person"){ echo 'selected'; } ?>>Per Person</option>
			<option value="Twin Sharing" <?php if(@$pricelist->price_type == "Twin Sharing"){ echo 'selected'; } ?>>Twin Sharing</option>
			<option value="Triple Sharing" <?php if(@$pricelist->price_type == "Triple Sharing"){ echo 'selected'; } ?>>Triple Sharing</option>
		</select>
	  </div>
	  </div>
	  <div class="form-group row">
			<label for="booking_amt" class="col-sm-4 col-form-label">Booking Amount</label>
			<div class="col-sm-3">
	<input type="text" onkeypress='return isNumberKey(event)' class="form-control" name="booking_amt">
			</div>
			<div class="col-sm-3">
				<select class="form-control" name="dis_type[]">
					<option value="Percentage" <?php if(@$pricelist->dis_type == "Percentage"){ echo 'selected'; } ?>>Percentage</option>
					<option value="Fixed" <?php if(@$pricelist->dis_type == "Fixed"){ echo 'selected'; } ?>>Fixed</option>
				</select>
			</div>
	  </div>
	  <div class="form-group row">
			<label for="bal_rec_day" class="col-sm-4 col-form-label">Balance Receiving Day</label>
			<div class="col-sm-6">
	<input type="text" class="form-control" value="{{@$pricelist->bal_rec_day}}" name="bal_rec_day[]">
			</div>
			
	  </div>
	  <div class="form-group row">
			<label for="price_summary" class="col-sm-4 col-form-label">More/Additional Detail (Optional)</label>
			<div class="col-sm-6">
				<textarea name="price_summary[]" class="textarea" placeholder="Please Add Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{@$pricelist->price_summary}}</textarea>
				@if ($errors->has('price_summary'))
					<span class="custom-error" role="alert">
						<strong>{{ @$errors->first('price_summary') }}</strong>
					</span> 
				@endif
			</div>
	  </div> 
	  <?php
	  $ecpprice = json_decode(@$pricelist->departure_date);
	  $no_of_seats = json_decode(@$pricelist->no_of_seats);
	  ?>
	  <div class="form-group row">
			<label for="departure_date" class="col-sm-4 col-form-label">Departure Date</label>
			<div class="col-sm-3">
				{{ Form::text('departure_date[0][]', $ecpprice[0], array('class' => 'form-control commondydate', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Departure Date', 'onkeypress'=>'return isNumberKey(event)' )) }}
			</div>
			<div class="col-sm-2">
				<input class="form-control " data-valid="" autocomplete="off" placeholder="Number of Seats Available" onkeypress="return isNumberKey(event)" name="no_of_seats[0][]" type="number" value="{{@$no_of_seats[0]}}">
				
			</div>
			<div class="col-sm-3">
				<a did="0" href="javascript:;" class="adddate btn btn-primary"><i class="fa fa-plus">Add Date</i></a>
			</div>
		</div>
	  <div class="datedata">
	  <?php
	  if(count($ecpprice) > 1){
		for($dd = 1; $dd < count($ecpprice); $dd++){
			?>
			<div class="form-group row">
			<label for="departure_date" class="col-sm-4 col-form-label">Departure Date</label>
			<div class="col-sm-3">
				{{ Form::text('departure_date[0][]', $ecpprice[@$dd], array('class' => 'form-control commondydate', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Enter Departure Date', 'onkeypress'=>'return isNumberKey(event)' )) }}
			</div>
			<div class="col-sm-2">
				<input class="form-control " data-valid="" autocomplete="off" placeholder="Number of Seats Available" onkeypress="return isNumberKey(event)" name="no_of_seats[0][]" type="number" value="{{@$no_of_seats[@$dd]}}">
				
			</div>
			<div class="col-sm-3">
				<a did="0" href="javascript:;" class="remdepdate btn btn-primary"><i class="fa fa-minus"> Remove Date</i></a>
			</div>
		</div>
			<?php
		}
		}
	  ?>
	  </div>
	  </div>
<?php 
if($ccount>0) { break; }
      
} ?>
<div class="pricedata">
<?php
$counter = 0;
foreach($fetchprices as $pricelist){
	if($counter == 0)
        {
            $counter++;
            continue;
        }
?>
<hr>
<div class="pdetail" id="s_{{$counter}}">
<input type="hidden" name="priceid[]" value="{{@$pricelist->id}}">
	<div class="form-group row"> 
			<label for="twin" class="col-sm-4 col-form-label">Twin </label>
			<div class="col-sm-6">
			{{ Form::text('twin[]', @$pricelist->twin, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'twin Price', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('twin'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('twin') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="triple" class="col-sm-4 col-form-label">Triple</label>
			<div class="col-sm-6">
			{{ Form::text('triple[]', @$pricelist->triple, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Tripple Price', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('triple'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('triple') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="single" class="col-sm-4 col-form-label">Single</label>
			<div class="col-sm-6">
			{{ Form::text('single[]', @$pricelist->single, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'single', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('single'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('single') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  
	  <div class="form-group row"> 
			<label for="child_with_bed" class="col-sm-4 col-form-label">Child with Bed (below 12 years)</label>
			<div class="col-sm-6">
			{{ Form::text('child_with_bed[]', @$pricelist->child_with_bed, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Child with Bed (below 12 years)', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('child_with_bed'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('child_with_bed') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="child_without_bedbelow12" class="col-sm-4 col-form-label">Child without Bed (below 12 years)</label>
			<div class="col-sm-6">
			{{ Form::text('child_without_bedbelow12[]', @$pricelist->child_without_bedbelow12, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Child without Bed (below 12 years)', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('child_without_bedbelow12'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('child_without_bedbelow12') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="child_without_bedbelow26" class="col-sm-4 col-form-label">Child without Bed (below 2-6 years)</label>
			<div class="col-sm-6">
			{{ Form::text('child_without_bedbelow26[]', @$pricelist->child_without_bedbelow26, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Child without Bed (below 2-3 years)', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('child_without_bedbelow26'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('child_without_bedbelow26') }}</strong>
				</span> 	
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="infant" class="col-sm-4 col-form-label">Infant</label>
			<div class="col-sm-6">
			{{ Form::text('infant[]', @$pricelist->infant, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Infant', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('infant'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('infant') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="adult_flight" class="col-sm-4 col-form-label">Adult (Flight Only)</label>
			<div class="col-sm-6">
			{{ Form::text('adult_flight[]', @$pricelist->adult_flight, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Adult (Flight Only)', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('adult_flight'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('adult_flight') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="child_flight" class="col-sm-4 col-form-label">Child (Flight Only)</label>
			<div class="col-sm-6">
			{{ Form::text('child_flight[]', @$pricelist->child_flight, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Child (Flight Only)', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('child_flight'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('child_flight') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="infant_flight" class="col-sm-4 col-form-label">Infant (Flight Only)</label>
			<div class="col-sm-6">
			{{ Form::text('infant_flight[]', @$pricelist->infant_flight, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Infant (Flight Only)', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('infant_flight'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('infant_flight') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row"> 
			<label for="seats" class="col-sm-4 col-form-label">Total Seat Available</label>
			<div class="col-sm-6">
			{{ Form::text('seats[]', @$pricelist->seats, array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Total Seat Available', 'onkeypress'=>'return isNumberKey(event)' )) }}
			@if ($errors->has('seats'))
				<span class="custom-error" role="alert">
					<strong>{{ @$errors->first('seats') }}</strong>
				</span> 
			@endif
			</div>
	  </div>
	  <div class="form-group row">
		<label for="price_type" class="col-sm-4 col-form-label">Price Type</label>
		<div class="col-sm-6">
		<select class="form-control" name="price_type[]">
			<option value="Per Person" <?php if(@$pricelist->price_type == "Per Person"){ echo 'selected'; } ?>>Per Person</option>
			<option value="Twin Sharing" <?php if(@$pricelist->price_type == "Twin Sharing"){ echo 'selected'; } ?>>Twin Sharing</option>
			<option value="Triple Sharing" <?php if(@$pricelist->price_type == "Triple Sharing"){ echo 'selected'; } ?>>Triple Sharing</option>
		</select>
	  </div>
	  </div>
	  <div class="form-group row">
			<label for="booking_amt" class="col-sm-4 col-form-label">Booking Amount</label>
			<div class="col-sm-3">
	<input type="text" onkeypress='return isNumberKey(event)' class="form-control" name="booking_amt">
			</div>
			<div class="col-sm-3">
				<select class="form-control" name="dis_type[]">
					<option value="Percentage" <?php if(@$pricelist->dis_type == "Percentage"){ echo 'selected'; } ?>>Percentage</option>
					<option value="Fixed" <?php if(@$pricelist->dis_type == "Fixed"){ echo 'selected'; } ?>>Fixed</option>
				</select>
			</div>
	  </div>
	  <div class="form-group row">
			<label for="bal_rec_day" class="col-sm-4 col-form-label">Balance Receiving Day</label>
			<div class="col-sm-6">
	<input type="text" class="form-control" value="{{@$pricelist->bal_rec_day}}" name="bal_rec_day[]">
			</div>
			
	  </div>
	  <div class="form-group row">
			<label for="price_summary" class="col-sm-4 col-form-label">More/Additional Detail (Optional)</label>
			<div class="col-sm-6">
				<textarea name="price_summary[]" class="textarea" placeholder="Please Add Description Here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{@$pricelist->price_summary}}</textarea>
				@if ($errors->has('price_summary'))
					<span class="custom-error" role="alert">
						<strong>{{ @$errors->first('price_summary') }}</strong>
					</span> 
				@endif
			</div>
	  </div> 
	  <?php
	  $ecpprice = json_decode(@$pricelist->departure_date);
	  $no_of_seats = json_decode(@$pricelist->no_of_seats);
	  ?>
	  <div class="form-group row">
			<label for="departure_date" class="col-sm-4 col-form-label">Departure Date</label>
			<div class="col-sm-3">
				
				<input class="form-control commondydate" data-valid="" autocomplete="off" placeholder="Enter Departure Date" onkeypress="return isNumberKey(event)" name="departure_date[<?php echo $counter; ?>][]" type="text" value="{{@$ecpprice[0]}}">
			</div>
			<div class="col-sm-2">
				<input class="form-control " data-valid="" autocomplete="off" placeholder="Number of Seats Available" onkeypress="return isNumberKey(event)" name="no_of_seats[<?php echo $counter; ?>][]" type="number" value="{{@$no_of_seats[0]}}">
				
			</div>
			<div class="col-sm-3">
				<a did="<?php echo $counter; ?>" href="javascript:;" class="adddate btn btn-primary"><i class="fa fa-plus">Add Date</i></a>
			</div>
		</div>
	  <div class="datedata">
	  <?php
	  if(count($ecpprice) > 1){
		for($dd = 1; $dd < count($ecpprice); $dd++){
			?>
			<div class="form-group row">
			<label for="departure_date" class="col-sm-4 col-form-label">Departure Date</label>
			<div class="col-sm-4">
			<input class="form-control commondydate" data-valid="" autocomplete="off" placeholder="Enter Departure Date" onkeypress="return isNumberKey(event)" name="departure_date[<?php echo $counter; ?>][]" type="text" value="{{@$ecpprice[@$dd]}}">
				
			</div>
			<div class="col-sm-2">
				<input class="form-control " data-valid="" autocomplete="off" placeholder="Number of Seats Available" onkeypress="return isNumberKey(event)" name="no_of_seats[<?php echo $counter; ?>][]" type="number" value="{{@$no_of_seats[@$dd]}}">
				
			</div>
			<div class="col-sm-3">
				<a did="<?php echo $counter; ?>" href="javascript:;" class="remdepdate btn btn-primary"><i class="fa fa-minus"> Remove Date</i></a>
			</div>
		</div>
			<?php
		}
		}
	  ?>
	  </div>
	  </div>
<?php  } ?>
</div>
<div class="form-group row">
	<a href="javascript:;" class="addprice btn btn-primary"><i class="fa fa-plus"></i> Add Price</a>
  </div> 