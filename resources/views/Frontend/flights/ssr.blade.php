<div class="col-md-12">
	<div class="col-sm-4 contact_label cus_label">
		<label>Select Excess Baggage</label>
	</div>
	
<?php
//echo '<pre>'; print_r($ssrdata); echo '<pre>';
if(@$ssrdata->Response->Error->ErrorCode == 0 && @$ssrdata->Response->Baggage !== null){
	$bgh = 0;
	foreach(@$ssrdata->Response->Baggage as $key => $bsslist){ 
	//print_r($bsslist);
		?>
		<div class="col-md-4">
		<p>{{@$ssrdata->Response->Baggage[$key][0]->Origin}} - {{@$ssrdata->Response->Baggage[$key][0]->Destination}}</p>
		<select id="" name="<?php if($key == 0){ echo 'dep_baggage[]'; }else{ echo 'rep_baggage[]'; } ?>" class="selectbagage form-control" tabindex="18">
		<?php
			foreach(@$bsslist as $b_list){
				/* if($b_list->Code == 'EB20'){  
					$aa[] = array(
						'AirlineCode'=>$b_list->AirlineCode,
						'FlightNumber'=>$b_list->FlightNumber,
						'WayType'=>$b_list->WayType,
						'Code'=>$b_list->Code,
						'Description'=>$b_list->Description,
						'Weight'=>$b_list->Weight,
						'Currency'=>$b_list->Currency,
						'Price'=>$b_list->Price,
						'Origin'=>$b_list->Origin,
						'Destination'=>$b_list->Destination,
				);
				
				} */
					if($b_list->Code == 'NONE'){ 
?>
					<option value="0@^@Direct_NONE">No Excess/Extra Baggage</option>
				<?php }else{ ?>
					<option value="<?php echo $b_list->Weight; ?>@^@Direct_{{$b_list->Code}}">{{$b_list->Weight}}-Kg Rs.-{{$b_list->Price}}-Checked Baggage {{$b_list->Weight}}Kg</option>
				<?php } ?>
	 <?php
			}  
		?>
		</select> 
		<span class="baggage_details">
			<kbd>Baggage Weight : <code style="float:none;" class="bagwth">0</code> Kg</kbd>
			<kbd>Baggage Charges : <em>Rs.</em> <code style="float:none;" class="bagcharges">0</code>
			</kbd>
		</span>
	</div>
		<?php
		//print_r($aa);
	} 
}else{
	?>
	<div class="col-md-8">
		<select id="" name="dep_baggage[]" class="selectbagage form-control" tabindex="18">
		<option value="0@^@Direct_NONE">No Excess/Extra Baggage</option>
		</select>
		<span class="baggage_details">
			<kbd>Baggage Weight : <code style="float:none;" id="bagWt_0_indi_1_seg_0">0</code> Kg</kbd>
			<kbd>Baggage Charges : <em>Rs.</em> <code style="float:none;" id="bagCha_0_indi_1_seg_0">0</code>
			</kbd>
		</span>
	</div>
	<?php
} ?>
		
</div>

<div class="col-md-12">
	<div class="col-sm-4 contact_label cus_label">
		<label>Meal Preferences</label>
	</div>
	
<?php
if(@$ssrdata->Response->Error->ErrorCode == 0 && @$ssrdata->Response->MealDynamic !== null){
	$ismeal =0; foreach(@$ssrdata->Response->MealDynamic as $bsslist){ 
				foreach(@$bsslist as $bd_list){  $ismeal++;  }}
				
	foreach(@$ssrdata->Response->MealDynamic as $k => $mlist){ 
	?>
	<div class="col-md-4">
	<p>{{@$ssrdata->Response->MealDynamic[$k][0]->Origin}} - {{@$ssrdata->Response->MealDynamic[$k][0]->Destination}}</p>
	
		<select id="" name="<?php if($k == 0){ echo 'dep_meal[]'; }else{ echo 'rep_meal[]'; } ?>" class="selectmmeal form-control" tabindex="18">
	<?php
		if($ismeal > 0){	
			foreach(@$mlist as $m_list){
					if($m_list->Code == 'NONE'){ 
?>
					<option value="NONE@^@0">Add No Meal Rs.-0</option>
				<?php }else{ ?>
					<option value="{{$m_list->Code}}@^@<?php echo $m_list->Price; ?>">Add {{$m_list->AirlineDescription}} Rs.-{{$m_list->Price}}</option>
	 <?php
				}
			} 
		}
?>
</select>
		<span class="baggage_details mealdetail">
			<kbd>Meal Qunatity : <code style="float:none;" class="mealwth">0</code> Platter</kbd>
			<kbd>Meal Charges : <em>Rs.</em> <code style="float:none;" class="mealcharges">0</code>
			</kbd>
		</span>
	</div>
<?php
	
	} 
}else{
	?>
	<div class="col-md-8">
			<select id="" name="meal[]" class="selectmmeal form-control" tabindex="18">
		<option value="NONE@^@0">Add No Meal Rs.-0</option>
		</select>
		<span class="baggage_details mealdetail">
			<kbd>Meal Qunatity : <code style="float:none;" class="mealwth">0</code> Platter</kbd>
			<kbd>Meal Charges : <em>Rs.</em> <code style="float:none;" class="mealcharges">0</code>
			</kbd>
		</span>
	</div>
	<?php
} ?>
		
</div>	