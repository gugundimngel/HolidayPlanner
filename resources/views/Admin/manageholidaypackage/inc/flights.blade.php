<div class="form-group row">
	<label for="" class="col-sm-2 col-form-label">Departure Flights</label>
	<div class="col-sm-10">
		<button type="button" class="btn btn-primary btn-sm 
		depflightopen"><i class="fa fa-plus"></i> Add</button>
		<input type="hidden" id="onward_flight" value="{{@$fetchedData->onward_flight}}" name="onward_flight">
	</div>			 								
</div>
<div class="form-group row">
	<div class="col-sm-12">
		<table class="table table-hover text-nowrap">
			<thead>
				<tr>
					<td>Flight</td>
					<td>Departure City</td>
					<td>Arrival City</td>
					<td>Departure Time</td>
					<td>Arrival Time</td>
					<td>Action</td>
				</tr>
			</thead>
			<tbody id="appendflights">
				<?php
					if(isset($fetchedData->id)){
						$onwardflightid = $fetchedData->onward_flight;
						 $onward 		= \App\FlightDetail::where('id', $onwardflightid)->with(['flight', 'flightsource', 'flightdest'])->first();
						?>
						<tr id="id_{{@$onward->id}}"> 
							<td>{{ @$onward->flight->name == "" ? config('constants.empty') : str_limit(@$onward->flight->name, '50', '...') }} {{ @$onward->flight->code }} {{ @$onward->flight_number }}</td>
								<td>{{ @$onward->flightsource->city_code }}</td> 
								  <td>{{ @$onward->flightdest->city_code }} </td> 
								  <td>{{ @$onward->dep_time }}</td>  
								<td>{{ @$onward->arival_time }}</td> 
								<td><a href="javascript:;" class="btn btn-primary btn-sm removeflight">Remove</a></td>
							</tr>
						<?php
					}
				?>
			</tbody>
		</table>
	</div>			 								
</div>
 
<div class="form-group row">
	<label for="" class="col-sm-2 col-form-label">Return Flights</label>
	<div class="col-sm-10">
		<button type="button" class="btn btn-primary btn-sm retflightopen"><i class="fa fa-plus"></i> Add</button>
		<input type="hidden" id="return_flight" value="{{@$fetchedData->return_flight}}" name="return_flight">
	</div>			 								
</div>
<div class="form-group row">
	<div class="col-sm-12">
		<table class="table table-hover text-nowrap">
			<thead>
				<tr>
					<td>Flight</td>
					<td>Departure City</td>
					<td>Arrival City</td>
					<td>Departure Time</td>
					<td>Arrival Time</td>
					<td>Action</td>
				</tr>
			</thead>
			<tbody id="retappendflights">
				<?php
					if(isset($fetchedData->id)){
						$returnflightid = $fetchedData->return_flight;
						 $retward 		= \App\FlightDetail::where('id', $returnflightid)->with(['flight', 'flightsource', 'flightdest'])->first();
						?>
						<tr id="id_{{@$retward->id}}"> 
							<td>{{ @$retward->flight->name == "" ? config('constants.empty') : str_limit(@$retward->flight->name, '50', '...') }} {{ @$retward->flight->code }} {{ @$retward->flight_number }}</td>
								<td>{{ @$retward->flightsource->city_code }}</td> 
								  <td>{{ @$retward->flightdest->city_code }} </td> 
								  <td>{{ @$retward->dep_time }}</td>  
								<td>{{ @$retward->arival_time }}</td> 
								<td><a href="javascript:;" class="btn btn-primary btn-sm removeflight">Remove</a></td>
							</tr>
						<?php
					}
				?>
			</tbody>
		</table>
	</div>			 								
</div>
<div class="modal fade" id="flight_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">Select Departure Flight</h4>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
			<form action="" method="get">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-sm-3 col-form-label">Flight Code</label>
							<div class="col-sm-9">
								<input class="form-control" type="text" name="code" value="" id="fcode">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-sm-3 col-form-label">Flight Name</label>
							<div class="col-sm-9">
								<input class="form-control"  type="text" name="name" value="" id="fname">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-sm-3 col-form-label">Departure Date</label>
							<div class="col-sm-9">
								<input class="form-control commondate"  type="text" name="dep_date" value="" id="dep_date">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<button type="button" id="search_flight" class="btn btn-primary btn-sm">Search</button>
						</div>
					</div>
				</div>
				</form>
				<table class="table table-hover text-nowrap">
					<thead>
						<tr>
							<td>Flight</td>
							<td>Departure City</td>
							<td>Arrival City</td>
							<td>Departure Time</td>
							<td>Arrival Time</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody id="showflights">
						<tr colspan="6"><td style="text-align:center;">Please Wait....</td></tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="retflight_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">Select Return Flight</h4>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
			<form action="" method="get">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-sm-3 col-form-label">Flight Code</label>
							<div class="col-sm-9">
								<input class="form-control" type="text" name="code" value="" id="rfcode">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-sm-3 col-form-label">Flight Name</label>
							<div class="col-sm-9">
								<input class="form-control"  type="text" name="name" value="" id="rfname">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-sm-3 col-form-label">Departure Date</label>
							<div class="col-sm-9">
								<input class="form-control commondate"  type="text" name="dep_date" value="" id="rdep_date">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<button type="button" id="retsearch_flight" class="btn btn-primary btn-sm">Search</button>
						</div>
					</div>
				</div>
				</form>
				<table class="table table-hover text-nowrap">
					<thead>
						<tr>
							<td>Flight</td>
							<td>Departure City</td>
							<td>Arrival City</td>
							<td>Departure Time</td>
							<td>Arrival Time</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody id="retshowflights">
						<tr colspan="6"><td style="text-align:center;">Please Wait....</td></tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>