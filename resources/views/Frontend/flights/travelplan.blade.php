<div class="booking_title">
		<h3><img src="{!! asset('public/images/travel-insurance.png') !!}" alt=""/> Travel Insurance <span class="cus_span">(Recommended)</span></h3>
	</div>
	<div class="block-content-2 custom_block_content add_gst">
		<div class="box-result custom_box_result">
			<div class="checkbox label_checkbox">
				<label class="label-container checkbox-default"><input type="checkbox"/><span class="checkmark"></span> Yes, Add Travel Protection to protect my trip <span>(<i class="fa fa-rupee-sign"></i> per traveller)</span></label>  
			</div>
			<div class="travel_much">
				<p>6000+ travellers on MTI protect their trip daily. <a href="#">Learn More</a></p>
			</div>
			<div class="view_benfits_sec">
				<p>Cover Includes</p> 
				<div class="insurence_list">
					<ul>
					@for($i = 0; $i<count($traveldata->pTrvCoverDtlsList_out); $i++)
						@if($traveldata->pTrvCoverDtlsList_out[$i]->pbenefits == 'Trip Cancellation')
						<li>
							<i class="fa fa-plane"></i>
							<span class="insurence_name">{{@$traveldata->pTrvCoverDtlsList_out[$i]->pbenefits}}</span>
							<div class="claim">
								<span>Claim upto <i class="fa fa-rupee-sign"></i>{{@$traveldata->pTrvCoverDtlsList_out[$i]->plimits}}</span>
							</div>
						</li>
						@endif
						@if($traveldata->pTrvCoverDtlsList_out[$i]->pbenefits == 'Trip Delay')
							<li>
							<i class="fa fa-hotel"></i>
							<span class="insurence_name">{{@$traveldata->pTrvCoverDtlsList_out[$i]->pbenefits}}</span>
							<div class="claim">
								<span>Claim upto <i class="fa fa-rupee-sign"></i>{{@$traveldata->pTrvCoverDtlsList_out[$i]->plimits}}</span>
							</div>
						</li> 
						@endif	
						@if($traveldata->pTrvCoverDtlsList_out[$i]->pbenefits == 'Loss of Checked Baggage')
							<li>
							<i class="fa fa-suitcase"></i>
							<span class="insurence_name">{{@$traveldata->pTrvCoverDtlsList_out[$i]->pbenefits}}</span>
							<div class="claim">
								<span>Claim upto <i class="fa fa-rupee-sign"></i>{{@$traveldata->pTrvCoverDtlsList_out[$i]->plimits}}</span>
							</div>
						</li> 
						@endif
						@if($traveldata->pTrvCoverDtlsList_out[$i]->pbenefits == 'Emergency Medical Evacuation')
							<li>
							<i class="fa fa-suitcase"></i>
							<span class="insurence_name">{{@$traveldata->pTrvCoverDtlsList_out[$i]->pbenefits}}</span>
							<div class="claim">
								<span>Claim upto <i class="fa fa-rupee-sign"></i>{{@$traveldata->pTrvCoverDtlsList_out[$i]->plimits}}</span>
							</div>
						</li> 
						@endif
						@endfor
						<li class="show-only-upfront more-switch" ng-click="showMBPopup()">
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="insurance_note">
					<p>Note: Travel Protection is applicable only for Indian citizens below the age of 70 years. <a href="#">Terms & Conditions</a></p>
				</div> 
				<div class="insurance_holder">
					<span class="logo_cover_more ins_logo">
						<span>India</span>
					</span>
					<span class="logo_bharti_axa ins_logo">
						<span>Insurance Provider</span>
					</span>
				</div>
			</div>
		</div>
	</div>