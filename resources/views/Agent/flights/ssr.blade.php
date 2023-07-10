<?php

		if(@$ssrdata->Response->Error->ErrorCode == 0 && @$ssrdata->Response->Baggage !== null){
		
			 $isbag =0; foreach(@$ssrdata->Response->Baggage as $bsslist){ 
				foreach(@$bsslist as $bd_list){ if($bd_list->Price != 0){ $isbag++; } }}
				if($isbag > 0){
		?>
										<div class="booking_title">
											<h3>Baggage <span class="cus_span">(Optional)</span></h3>
										</div>	
										<div class="block-content-2 custom_block_content add_gst">
											<div class="box-result custom_box_result">
												<div class="service_req_sec">
												<ul class="nav nav-tabs custom_tabs"> 
														<li class="active"><a href="#addbaggage" aria-controls="addbaggage" role="tab" data-toggle="tab">Departure</a></li>
														@if($is_return == 1)
														<li class=""><a href="#addreturnbaggage" aria-controls="addreturnbaggage" role="tab" data-toggle="tab">Return</a></li>
													@endif
													</ul>
													<div class="tab-content">
														<div role="tabpanel" class="tab-pane active" id="addbaggage">
										<?php 
											if(@$ssrdata->Response->Error->ErrorCode == 0 && @$ssrdata->Response->Baggage !== null){ ?>		
											<?php $isbag =0; foreach(@$ssrdata->Response->Baggage as $bsslist){ 
												foreach(@$bsslist as $bd_list){ if($bd_list->Price != 0){ $isbag++; } }} ?>
													<?php if($isbag > 0){ ?>											
															<div class="service_req_list">
																<ul>  
																
																<?php  foreach(@$ssrdata->Response->Baggage as $blist){ 
																	foreach(@$blist as $b_list){ 
											
																	if($b_list->Price != 0){
																?>		
																	<li class="selectbag" dataweight="{{$b_list->Weight}}" dataprice="{{$b_list->Price}}">
																		<input name="onward" type="checkbox" />
																		<img src="{{URL::to('/html')}}/images/travel-bag.png" alt=""/>
																		<span class="baggage_type">Additional</span>
																		<span class="baggage_name">{{$b_list->Weight}}</span>
																		<span class="baggage_price"><i class="fa fa-rupee-sign"></i> {{number_format($b_list->Price)}}</span>
																		<span class="baggage_select"><a href="javascript:;">Select</a></span>
																	</li> 
																	<?php } } } ?>
																	
																</ul> 
																<div class="clearfix"></div>
															</div>	
											<?php }else{ echo ''; } ?>
											<?php } ?>
														</div>	
														<div role="tabpanel" class="tab-pane" id="addreturnbaggage">
														<?php 
										if(!empty($ssrdataib)){
										if(@$ssrdataib->Response->Error->ErrorCode == 0 && @$ssrdataib->Response->Baggage !== null){ ?>
											<?php $isbag =0; foreach(@$ssrdataib->Response->Baggage as $bsslist){ 
												foreach(@$bsslist as $bd_list){ if($bd_list->Price != 0){ $isbag++; } }} ?>
													<?php if($isbag > 0){ ?>
													<div class="service_req_list">
																<ul>  
																
																<?php  foreach(@$ssrdataib->Response->Baggage as $blist){ 
																	foreach(@$blist as $b_list){ 
											
																	if($b_list->Price != 0){
																?>		
																	<li class="returnselectbag" dataweight="{{$b_list->Weight}}" dataprice={{$b_list->Price}}>
																	<input  name="return" type="checkbox" />
																		<img src="{{URL::to('/html')}}/images/travel-bag.png" alt=""/>
																		<span class="baggage_type">Additional</span>
																		<span class="baggage_name">{{$b_list->Weight}}</span>
																		<span class="baggage_price"><i class="fa fa-rupee-sign"></i> {{number_format($b_list->Price)}}</span>
																		<span class="baggage_select"><a href="javascript:;">Select</a></span>
																	</li> 
																	<?php } } } ?>
																	
																</ul> 
																<div class="clearfix"></div>
															</div>	
													<?php }else{ echo ''; } ?>
										<?php } }  ?>
														</div>
													</div>
												</div>
											</div><!-- .box-result end -->
										</div>
									<?php } } ?>
										
										<?php
										if(@$ssrdata->Response->Error->ErrorCode == 0 && @$ssrdata->Response->MealDynamic !== null){
											$ismeal =0; foreach(@$ssrdata->Response->MealDynamic as $bsslist){ 
												foreach(@$bsslist as $ml_list){ if($ml_list->Price != 0){ $ismeal++; } }}
											if($ismeal > 0){ 
										?>
										<div class="booking_title">
											<h3>Meals <span class="cus_span">(Optional)</span></h3>
										</div>	
										<div class="block-content-2 custom_block_content add_gst">
											<div class="box-result custom_box_result">
												<div class="service_req_sec">
												
													<ul class="nav nav-tabs custom_tabs"> 
														<li class="active"><a href="#addmeal" aria-controls="addmeal" role="tab" data-toggle="tab">Departure</a></li>
														@if($is_return == 1)
														<li class=""><a href="#addreturnmeal" aria-controls="addreturnmeal" role="tab" data-toggle="tab">Return</a></li>
													@endif
													</ul>
													<div class="tab-content">
														<div role="tabpanel" class="tab-pane active" id="addmeal">
										<?php 
									
										if(@$ssrdata->Response->Error->ErrorCode == 0 && @$ssrdata->Response->MealDynamic !== null){ ?>	
											
												<?php if($ismeal > 0){ ?>										
															<div class="service_req_list">
																<ul>  
																<?php  foreach(@$ssrdata->Response->MealDynamic as $mlist){ 
																	foreach(@$mlist as $m_list){ 
											
																	if($m_list->Price != 0){
																?>		
																	<li class="selectmeal" dataweight="{{$m_list->Code}}" dataprice="{{$m_list->Price}}">
																	<input  name="onwarmeal" type="checkbox" />
																		<img src="{{URL::to('/html')}}/images/lunch-1593666-1348717.png" alt=""/>
																		<span class="baggage_type">Additional</span>
																		<span class="baggage_name">{{$m_list->AirlineDescription}}</span>
																		<span class="baggage_price"><i class="fa fa-rupee-sign"></i> {{number_format($m_list->Price)}}</span>
																		<span class="baggage_select"><a href="javascript:;">Select</a></span>
																	</li> 
																	<?php } } } ?>
																	
																</ul> 
																<div class="clearfix"></div>
															</div>
											<?php }  } ?>															
														</div>
														<div role="tabpanel" class="tab-pane" id="addreturnmeal">
															<?php 
															if(!empty($ssrdataib)){
																if(@$ssrdataib->Response->Error->ErrorCode == 0 && @$ssrdataib->Response->MealDynamic !== null){
															?>
															<?php $ismeal =0; foreach(@$ssrdataib->Response->MealDynamic as $bsslist){ 
																foreach(@$bsslist as $ml_list){ if($ml_list->Price != 0){ $ismeal++; } }} ?>
																<?php if($ismeal > 0){ ?>
																<div class="service_req_list">
																<ul>  
																<?php  foreach(@$ssrdataib->Response->MealDynamic as $mlist){ 
																	foreach(@$mlist as $m_list){ 
											
																	if($m_list->Price != 0){
																?>		
																	<li class="selectmeal" dataweight="{{$m_list->Code}}" dataprice="{{$m_list->Price}}">
																	<input  name="returnmeal" type="checkbox" />
																		<img src="{{URL::to('/html')}}/images/lunch-1593666-1348717.png" alt=""/>
																		<span class="baggage_type">Additional</span>
																		<span class="baggage_name">{{$m_list->AirlineDescription}}</span>
																		<span class="baggage_price"><i class="fa fa-rupee-sign"></i> {{number_format($m_list->Price)}}</span>
																		<span class="baggage_select"><a href="javascript:;">Select</a></span>
																	</li> 
																	<?php } } } ?>
																	
																</ul> 
																<div class="clearfix"></div>
															</div>	
																<?php } ?>
															<?php } } ?>
														</div>													
													</div>
										
												</div>
											</div><!-- .box-result end -->
										</div>
											<?php } } ?>