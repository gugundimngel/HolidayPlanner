<thead>
												<tr> 
												@if($flight_type == 'domestic')
													<th class="no-sort"><input type="checkbox" id="domrcheckedAll"> Select All</th>
												@else 
													<th class="no-sort"><input type="checkbox" id="intercheckedAll"> Select All</th>
													@endif
													<th>Flight Logo</th>
													<th>Flight Code</th>  
													@if($type == 1)
													<th>Service Fee/Markup Detail</th>
												@else 
													<th>Non-Commission</th>
												@endif
													<th>Markup Type</th>
													<th>Delete</th>
												</tr> 
											</thead>
											<tbody class="tdata booking_data "><?php
											foreach($markups as $list){
											?>
												<tr> 
												@if($flight_type == 'domestic')
													<td><input class="checkSingle domesticids" type="checkbox" name="allcheckbox[]" value="{{$list->id}}"></td>
												@else 
													<td><input class="checkSingle internationalids" type="checkbox" name="allcheckbox[]" value="{{$list->id}}"></td>
													@endif
													<td><img width="30" src="{{URL::to('/public/img/airline/')}}/{{$list->flight_code}}.gif" alt=""/></td>
													<td>{{$list->flight_code}}</td>
													@if($type == 1)
													<td>{{$list->service_fee}}</td>
												@else 
													<td >{{$list->commission_fee}}</td>
													@endif
														@if($type == 1)
													<td>{{$list->service_type}}</td>
												@else 
													<td>{{$list->commission_type}}</td>
													@endif
													<td><a href="javascript:;"><i class="fa fa-trash"></i></a></td>
												</tr> 
											<?php } ?>
											</tbody>
													